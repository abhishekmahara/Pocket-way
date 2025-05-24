<?php
require_once '../includes/auth-check.php';
require_once '../includes/db-config.php';
require_once '../includes/admin-header.php';

// Initialize variables
$route_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$error = '';
$success = '';
$route = null;
$stations = [];
$buses = [];
$contacts = [];

// Verify route exists and fetch initial data
    try {
        $stmt = $pdo->prepare("SELECT * FROM main_routes WHERE route_id = ?");
    $stmt->execute([$route_id]);
        $route = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$route) {
        header("Location: manage-routes.php");
        exit;
    }

    // Fetch stations with proper ordering and their fares in one query
    $stmt = $pdo->prepare("
        SELECT DISTINCT 
            rs.*,
            rf.fare_amount
        FROM route_stations rs
        LEFT JOIN route_fares rf ON 
            rs.route_id = rf.route_id AND 
            rs.station_id = rf.to_station_id
        WHERE rs.route_id = ?
        GROUP BY rs.station_id
        ORDER BY rs.sequence_number ASC
    ");
    $stmt->execute([$route_id]);
    $stations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Ensure unique sequence numbers and proper fare assignment
    $unique_stations = [];
    $used_sequences = [];
    foreach ($stations as $station) {
        if (!in_array($station['sequence_number'], $used_sequences)) {
            $unique_stations[] = [
                'station_id' => $station['station_id'],
                'route_id' => $station['route_id'],
                'station_name' => $station['station_name'],
                'sequence_number' => $station['sequence_number'],
                'distance_from_prev' => $station['distance_from_prev'],
                'distance_from_source' => $station['distance_from_source'],
                'arrival_time' => $station['arrival_time'],
                'departure_time' => $station['departure_time'],
                'facilities' => $station['facilities'],
                'latitude' => $station['latitude'],
                'longitude' => $station['longitude'],
                'fare' => $station['fare_amount']
            ];
            $used_sequences[] = $station['sequence_number'];
        }
    }
    $stations = $unique_stations;

    // Fetch buses
    $stmt = $pdo->prepare("SELECT * FROM bus_services WHERE route_id = ?");
    $stmt->execute([$route_id]);
    $buses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch contacts
    $stmt = $pdo->prepare("SELECT * FROM emergency_contacts WHERE route_id = ?");
    $stmt->execute([$route_id]);
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    error_log("Error fetching route data: " . $e->getMessage());
    $error = "Error fetching route data. Please try again.";
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Start transaction
        $pdo->beginTransaction();

        // Validate required fields
        $required_fields = ['source', 'destination', 'total_distance', 'total_time'];
        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("Please fill in all required fields");
            }
        }

        // Validate numeric fields
        if (!is_numeric($_POST['total_distance']) || !is_numeric($_POST['total_fare'])) {
            throw new Exception("Distance and fare must be numeric values");
        }

        // Sanitize inputs
        $source = filter_var($_POST['source'], FILTER_SANITIZE_STRING);
        $destination = filter_var($_POST['destination'], FILTER_SANITIZE_STRING);
        $route_description = filter_var($_POST['route_description'], FILTER_SANITIZE_STRING);

        // Update main route
        $stmt = $pdo->prepare("UPDATE main_routes SET 
            source = ?, destination = ?, total_distance = ?, total_time = ?, 
            total_fare = ?, route_description = ?, is_active = ?
            WHERE route_id = ?");
        
        $stmt->execute([
            $source,
            $destination,
            floatval($_POST['total_distance']),
            $_POST['total_time'],
            floatval($_POST['total_fare']),
            $route_description,
            isset($_POST['is_active']) ? 1 : 0,
            $route_id
        ]);

        // Handle route map upload
        if (isset($_FILES['route_map']) && $_FILES['route_map']['error'] === UPLOAD_ERR_OK) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $max_size = 5 * 1024 * 1024; // 5MB
            
            if (!in_array($_FILES['route_map']['type'], $allowed_types)) {
                throw new Exception("Invalid file type. Please upload JPG, PNG, or GIF");
            }
            
            if ($_FILES['route_map']['size'] > $max_size) {
                throw new Exception("File size exceeds 5MB limit");
            }

            $upload_dir = '../uploads/route_maps/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $file_extension = pathinfo($_FILES['route_map']['name'], PATHINFO_EXTENSION);
            $new_filename = 'route_' . $route_id . '_' . time() . '.' . $file_extension;
            $upload_path = $upload_dir . $new_filename;

            if (move_uploaded_file($_FILES['route_map']['tmp_name'], $upload_path)) {
                $stmt = $pdo->prepare("UPDATE main_routes SET route_map_url = ? WHERE route_id = ?");
                $stmt->execute(['uploads/route_maps/' . $new_filename, $route_id]);
            }
        }

        // Handle stations update
        if (isset($_POST['station_name']) && is_array($_POST['station_name'])) {
            // Get existing stations with their IDs
            $stmt = $pdo->prepare("SELECT station_id, station_name, sequence_number FROM route_stations WHERE route_id = ?");
            $stmt->execute([$route_id]);
            $existing_stations = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Create a map of existing stations by sequence number
            $existing_stations_map = [];
            foreach ($existing_stations as $station) {
                $existing_stations_map[$station['sequence_number']] = $station;
            }

            // First, delete all existing fares for this route
            $pdo->prepare("DELETE FROM route_fares WHERE route_id = ?")->execute([$route_id]);

            // Get the source station ID (sequence number 1)
            $source_station_id = null;
            foreach ($existing_stations as $station) {
                if ($station['sequence_number'] == 1) {
                    $source_station_id = $station['station_id'];
                    break;
                }
            }

            $stmt = $pdo->prepare("INSERT INTO route_stations (route_id, station_name, sequence_number, 
                distance_from_prev, distance_from_source, arrival_time, departure_time, 
                facilities, latitude, longitude) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $processed_stations = [];
            $sequence_numbers = [];
            $updated_station_ids = [];
            $station_sequence_map = [];

            foreach ($_POST['station_name'] as $i => $station_name) {
                if (empty($station_name)) continue;
                
                // Skip duplicates
                if (in_array($station_name, $processed_stations)) continue;
                $processed_stations[] = $station_name;

                // Get sequence number
                $seq_num = $_POST['sequence_number'][$i] ?? ($i + 1);
                if (in_array($seq_num, $sequence_numbers)) {
                    throw new Exception("Duplicate sequence numbers are not allowed");
                }
                $sequence_numbers[] = $seq_num;

                // Format times
                $arrival_time = !empty($_POST['arrival_time'][$i]) ? 
                    date('H:i:s', strtotime($_POST['arrival_time'][$i])) : null;
                $departure_time = !empty($_POST['departure_time'][$i]) ? 
                    date('H:i:s', strtotime($_POST['departure_time'][$i])) : null;

                // Validate times
                if ($arrival_time && $departure_time && strtotime($arrival_time) >= strtotime($departure_time)) {
                    throw new Exception("Arrival time must be before departure time for station " . $station_name);
                }

                // Check if station exists at this sequence number
                if (isset($existing_stations_map[$seq_num])) {
                    // Update existing station
                    $station_id = $existing_stations_map[$seq_num]['station_id'];
                    $update_stmt = $pdo->prepare("UPDATE route_stations SET 
                        station_name = ?,
                        sequence_number = ?, 
                        distance_from_prev = ?, 
                        distance_from_source = ?, 
                        arrival_time = ?, 
                        departure_time = ?, 
                        facilities = ?, 
                        latitude = ?, 
                        longitude = ? 
                        WHERE station_id = ?");
                    
                    $update_stmt->execute([
                        filter_var($station_name, FILTER_SANITIZE_STRING),
                        $seq_num,
                        !empty($_POST['distance_from_prev'][$i]) ? floatval($_POST['distance_from_prev'][$i]) : null,
                        !empty($_POST['distance_from_source'][$i]) ? floatval($_POST['distance_from_source'][$i]) : null,
                        $arrival_time,
                        $departure_time,
                        filter_var($_POST['facilities'][$i] ?? '', FILTER_SANITIZE_STRING),
                        !empty($_POST['latitude'][$i]) ? floatval($_POST['latitude'][$i]) : null,
                        !empty($_POST['longitude'][$i]) ? floatval($_POST['longitude'][$i]) : null,
                        $station_id
                    ]);
                    
                    $current_station_id = $station_id;
                    $updated_station_ids[] = $station_id;
                } else {
                    // Insert new station
                    $stmt->execute([
                        $route_id,
                        filter_var($station_name, FILTER_SANITIZE_STRING),
                        $seq_num,
                        !empty($_POST['distance_from_prev'][$i]) ? floatval($_POST['distance_from_prev'][$i]) : null,
                        !empty($_POST['distance_from_source'][$i]) ? floatval($_POST['distance_from_source'][$i]) : null,
                        $arrival_time,
                        $departure_time,
                        filter_var($_POST['facilities'][$i] ?? '', FILTER_SANITIZE_STRING),
                        !empty($_POST['latitude'][$i]) ? floatval($_POST['latitude'][$i]) : null,
                        !empty($_POST['longitude'][$i]) ? floatval($_POST['longitude'][$i]) : null
                    ]);
                    
                    $current_station_id = $pdo->lastInsertId();
                    $updated_station_ids[] = $current_station_id;
                }

                // Store station ID with its sequence number
                $station_sequence_map[$seq_num] = $current_station_id;

                // Handle fares - only for non-source stations
                if (!empty($_POST['fare'][$i]) && floatval($_POST['fare'][$i]) > 0 && $seq_num > 1) {
                    $stmt_fare = $pdo->prepare("INSERT INTO route_fares (route_id, from_station_id, to_station_id, fare_amount) 
                                              VALUES (?, ?, ?, ?)");
                    $stmt_fare->execute([
                        $route_id,
                        $source_station_id, // Always use source station as from_station_id
                        $current_station_id,
                        floatval($_POST['fare'][$i])
                    ]);
                }
            }

            // Delete stations that were not updated
            if (!empty($updated_station_ids)) {
                $placeholders = str_repeat('?,', count($updated_station_ids) - 1) . '?';
                $pdo->prepare("DELETE FROM route_stations WHERE route_id = ? AND station_id NOT IN ($placeholders)")
                    ->execute(array_merge([$route_id], $updated_station_ids));
            }
        }

        // Handle bus services update
        if (isset($_POST['bus_number']) && is_array($_POST['bus_number'])) {
            $pdo->prepare("DELETE FROM bus_services WHERE route_id = ?")->execute([$route_id]);
            
            $stmt = $pdo->prepare("INSERT INTO bus_services (route_id, bus_number, bus_type, 
                seating_capacity, departure_time, arrival_time, operating_days) 
                VALUES (?, ?, ?, ?, ?, ?, ?)");

            foreach ($_POST['bus_number'] as $i => $bus_number) {
                if (empty($bus_number)) continue;

                // Validate times
                $departure_time = !empty($_POST['bus_departure_time'][$i]) ? 
                    date('H:i:s', strtotime($_POST['bus_departure_time'][$i])) : null;
                $arrival_time = !empty($_POST['bus_arrival_time'][$i]) ? 
                    date('H:i:s', strtotime($_POST['bus_arrival_time'][$i])) : null;

                if ($departure_time && $arrival_time && strtotime($departure_time) >= strtotime($arrival_time)) {
                    throw new Exception("Bus departure time must be before arrival time for bus " . $bus_number);
                }

                $stmt->execute([
                    $route_id,
                    filter_var($bus_number, FILTER_SANITIZE_STRING),
                    $_POST['bus_type'][$i] ?? 'Local',
                    !empty($_POST['seating_capacity'][$i]) ? (int)$_POST['seating_capacity'][$i] : null,
                    $departure_time,
                    $arrival_time,
                    filter_var($_POST['operating_days'][$i] ?? '', FILTER_SANITIZE_STRING)
                ]);
            }
        }

        // Handle emergency contacts update
        if (isset($_POST['contact_name']) && is_array($_POST['contact_name'])) {
            $pdo->prepare("DELETE FROM emergency_contacts WHERE route_id = ?")->execute([$route_id]);
            
            $stmt = $pdo->prepare("INSERT INTO emergency_contacts (route_id, station_id, contact_name, 
                contact_number, contact_type) 
                VALUES (?, ?, ?, ?, ?)");

            foreach ($_POST['contact_name'] as $i => $contact_name) {
                if (empty($contact_name) || empty($_POST['contact_number'][$i])) continue;

                // Validate phone number
                $phone = filter_var($_POST['contact_number'][$i], FILTER_SANITIZE_STRING);
                if (!preg_match('/^[0-9+\-\s()]{10,15}$/', $phone)) {
                    throw new Exception("Invalid phone number format for contact " . $contact_name);
                }

                $stmt->execute([
                    $route_id,
                    !empty($_POST['contact_station_id'][$i]) ? (int)$_POST['contact_station_id'][$i] : null,
                    filter_var($contact_name, FILTER_SANITIZE_STRING),
                    $phone,
                    filter_var($_POST['contact_type'][$i] ?? '', FILTER_SANITIZE_STRING)
                ]);
            }
        }

        $pdo->commit();
        $success = "Route updated successfully";
        header("Location: manage-routes.php");
        exit;

    } catch (Exception $e) {
        $pdo->rollBack();
        error_log("Route update error: " . $e->getMessage());
        $error = $e->getMessage();
    }
}

// Include the form HTML
include 'route-form.php';
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            var submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
            }
        });
    }
});

function addStationRow() {
    var container = document.getElementById('stations');
    var row = document.createElement('div');
    row.className = 'station-row';
    row.innerHTML = `
        <div class="row">
            <div class="col-md-3">
                <label class="form-label">Station Name</label>
                <input type="text" class="form-control" name="station_name[]" required>
            </div>
            <div class="col-md-1">
                <label class="form-label">Sequence</label>
                <input type="number" class="form-control" name="sequence_number[]" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Distance from Prev (km)</label>
                <input type="number" step="0.01" class="form-control" name="distance_from_prev[]">
            </div>
            <div class="col-md-2">
                <label class="form-label">Distance from Source (km)</label>
                <input type="number" step="0.01" class="form-control" name="distance_from_source[]">
            </div>
            <div class="col-md-2">
                <label class="form-label">Fare (₹)</label>
                <input type="number" step="0.01" class="form-control" name="fare[]">
                        </div>
            <div class="col-md-2">
                <label class="form-label">Arrival Time</label>
                <input type="time" class="form-control" name="arrival_time[]">
                        </div>
                    </div>
        <div class="row mt-2">
            <div class="col-md-2">
                <label class="form-label">Departure Time</label>
                <input type="time" class="form-control" name="departure_time[]">
            </div>
            <div class="col-md-4">
                <label class="form-label">Facilities</label>
                <input type="text" class="form-control" name="facilities[]">
            </div>
            <div class="col-md-3">
                <label class="form-label">Latitude</label>
                <input type="number" step="0.00000001" class="form-control" name="latitude[]">
                        </div>
            <div class="col-md-3">
                <label class="form-label">Longitude</label>
                <input type="number" step="0.00000001" class="form-control" name="longitude[]">
                        </div>
                    </div>
        <div class="row mt-2">
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.station-row').remove()">
                    <i class="fas fa-trash"></i> Remove
                </button>
                        </div>
                    </div>
    `;
    container.appendChild(row);
}

function addBusRow() {
    var container = document.getElementById('buses');
    var row = document.createElement('div');
    row.className = 'bus-row';
    row.innerHTML = `
        <div class="row">
            <div class="col-md-2">
                <label class="form-label">Bus Number</label>
                <input type="text" class="form-control" name="bus_number[]" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Bus Type</label>
                <select class="form-select" name="bus_type[]">
                    <option value="Local">Local</option>
                    <option value="Express">Express</option>
                    <option value="Deluxe">Deluxe</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Seating Capacity</label>
                <input type="number" class="form-control" name="seating_capacity[]">
            </div>
            <div class="col-md-2">
                <label class="form-label">Departure Time</label>
                <input type="time" class="form-control" name="bus_departure_time[]" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Arrival Time</label>
                <input type="time" class="form-control" name="bus_arrival_time[]" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Operating Days</label>
                <input type="text" class="form-control" name="operating_days[]">
                        </div>
                    </div>
        <div class="row mt-2">
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.bus-row').remove()">
                    <i class="fas fa-trash"></i> Remove
                </button>
                        </div>
                    </div>
    `;
    container.appendChild(row);
}

function addContactRow() {
    var container = document.getElementById('contacts');
    var row = document.createElement('div');
    row.className = 'contact-row';
    row.innerHTML = `
        <div class="row">
            <div class="col-md-3">
                <label class="form-label">Contact Name</label>
                <input type="text" class="form-control" name="contact_name[]" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Contact Number</label>
                <input type="text" class="form-control" name="contact_number[]" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Contact Type</label>
                <input type="text" class="form-control" name="contact_type[]">
            </div>
            <div class="col-md-2">
                <label class="form-label">Station ID</label>
                <input type="number" class="form-control" name="contact_station_id[]">
                </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.contact-row').remove()">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `;
    container.appendChild(row);
}

function previewImage(input) {
    if (input.files && input.files[0]) {
        var file = input.files[0];
        
        // Validate file size
        if (file.size > 5 * 1024 * 1024) {
            alert('File size exceeds 5MB limit');
            input.value = '';
            return;
        }
        
        // Validate file type
        var allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            alert('Invalid file type. Please upload JPG, PNG, or GIF');
            input.value = '';
            return;
        }
        
        var reader = new FileReader();
        reader.onload = function(e) {
            var preview = document.getElementById('imagePreview');
            if (!preview) {
                var newPreview = document.createElement('img');
                newPreview.id = 'imagePreview';
                newPreview.className = 'image-preview';
                input.parentNode.appendChild(newPreview);
            }
            preview.src = e.target.result;
            
            var status = document.getElementById('uploadStatus');
            if (!status) {
                var newStatus = document.createElement('div');
                newStatus.id = 'uploadStatus';
                newStatus.className = 'upload-status text-success';
                input.parentNode.appendChild(newStatus);
            }
            status.innerHTML = '<i class="fas fa-check-circle"></i> Image selected';
        }
        
        reader.readAsDataURL(file);
    }
}
</script>

<?php require_once '../includes/admin-footer.php'; ?>
