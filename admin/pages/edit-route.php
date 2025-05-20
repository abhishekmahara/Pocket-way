<?php
require_once '../includes/auth-check.php';
require_once '../includes/db-config.php';
require_once '../includes/admin-header.php';

// Add custom styles
?>
<style>
:root {
    --primary: #007B7F;
    --primary-dark: #005F62;
    --accent: #F9A825;
    --secondary: #003840;
    --white: #fff;
    --gray: #f8f9fa;
    --shadow: 0 4px 24px rgba(0,0,0,0.08);
    --radius: 18px;
}

.edit-route-bg {
    background: var(--gray);
    min-height: 100vh;
    padding-bottom: 40px;
}

.page-header {
    background: linear-gradient(90deg, var(--primary) 60%, var(--accent) 100%);
    color: var(--white);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    padding: 2rem;
    margin-bottom: 2rem;
}

.page-header h1 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.card {
    border: none;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    margin-bottom: 2rem;
}

.card-header {
    background: var(--white);
    border-bottom: 1px solid rgba(0,0,0,0.05);
    padding: 1.2rem 1.5rem;
    font-weight: 600;
    color: var(--primary);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.card-body {
    padding: 1.5rem;
}

.form-label {
    font-weight: 500;
    color: var(--secondary);
    margin-bottom: 0.5rem;
}

.form-control, .form-select {
    border-radius: 12px;
    border: 1px solid rgba(0,0,0,0.1);
    padding: 0.7rem 1rem;
    transition: all 0.2s;
}

.form-control:focus, .form-select:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 0.2rem rgba(0,123,127,0.15);
}

.btn {
    border-radius: 12px;
    padding: 0.7rem 1.5rem;
    font-weight: 500;
    transition: all 0.2s;
}

.btn-primary {
    background: var(--primary);
    border: none;
}

.btn-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
}

.btn-secondary {
    background: var(--secondary);
    border: none;
}

.btn-danger {
    background: #dc3545;
    border: none;
}

.station-row, .bus-row, .contact-row, .media-row {
    background: var(--white);
    border-radius: 12px;
    transition: all 0.2s;
}

.station-row:hover, .bus-row:hover, .contact-row:hover, .media-row:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.alert {
    border-radius: var(--radius);
    padding: 1rem 1.5rem;
    margin-bottom: 2rem;
    border: none;
}

.alert-success {
    background: #d4edda;
    color: #155724;
}

.alert-danger {
    background: #f8d7da;
    color: #721c24;
}

.route-map-preview {
    border-radius: 12px;
    box-shadow: var(--shadow);
    margin: 1rem 0;
}

.form-check-input:checked {
    background-color: var(--primary);
    border-color: var(--primary);
}

@media (max-width: 768px) {
    .page-header {
        padding: 1.5rem;
    }
    
    .card-body {
        padding: 1rem;
    }
}
</style>
<?php

$route_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$error = '';
$success = '';

// Verify route exists
try {
    $stmt = $pdo->prepare("SELECT * FROM main_routes WHERE route_id = ?");
    $stmt->execute([$route_id]);
    $route = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$route) {
        header("Location: manage-routes.php?error=Route not found");
        exit;
    }
} catch (Exception $e) {
    $error = "Error fetching route: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Start transaction
        $pdo->beginTransaction();

        // Update main route
        $stmt = $pdo->prepare("UPDATE main_routes SET 
            source = ?, destination = ?, total_distance = ?, total_time = ?, 
            total_fare = ?, route_description = ?, is_active = ? 
            WHERE route_id = ?");
        
        $stmt->execute([
            $_POST['source'] ?? '',
            $_POST['destination'] ?? '',
            $_POST['total_distance'] ?? null,
            $_POST['total_time'] ?? '',
            $_POST['total_fare'] ?? null,
            $_POST['route_description'] ?? '',
            isset($_POST['is_active']) ? 1 : 0,
            $route_id
        ]);

        // Handle route map upload only if a new file is provided
        if (isset($_FILES['route_map']) && $_FILES['route_map']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../uploads/route_maps/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $file_extension = strtolower(pathinfo($_FILES['route_map']['name'], PATHINFO_EXTENSION));
            $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');

            if (in_array($file_extension, $allowed_extensions)) {
                $new_filename = uniqid() . '.' . $file_extension;
                $upload_path = $upload_dir . $new_filename;

                if (move_uploaded_file($_FILES['route_map']['tmp_name'], $upload_path)) {
                    // Delete old map file if exists
                    if ($route['route_map_url'] && file_exists('../' . $route['route_map_url'])) {
                        unlink('../' . $route['route_map_url']);
                    }
                    
                    $stmt = $pdo->prepare("UPDATE main_routes SET route_map_url = ? WHERE route_id = ?");
                    $stmt->execute(['uploads/route_maps/' . $new_filename, $route_id]);
                }
            }
        }

        // Update stations only if station data is provided
        if (isset($_POST['station_name']) && is_array($_POST['station_name'])) {
            // Delete existing stations and fares
            $pdo->prepare("DELETE FROM route_stations WHERE route_id = ?")->execute([$route_id]);
            $pdo->prepare("DELETE FROM route_fares WHERE route_id = ?")->execute([$route_id]);

            $stmt = $pdo->prepare("INSERT INTO route_stations (route_id, station_name, sequence_number, 
                distance_from_prev, distance_from_source, arrival_time, departure_time, 
                facilities, latitude, longitude) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $prev_station_id = null;
            for ($i = 0; $i < count($_POST['station_name']); $i++) {
                if (!empty($_POST['station_name'][$i])) {
                    $arrival_time = !empty($_POST['arrival_time'][$i]) ? $_POST['arrival_time'][$i] : null;
                    $departure_time = !empty($_POST['departure_time'][$i]) ? $_POST['departure_time'][$i] : null;
                    
                    $stmt->execute([
                        $route_id,
                        $_POST['station_name'][$i],
                        $_POST['sequence_number'][$i] ?? null,
                        !empty($_POST['distance_from_prev'][$i]) ? $_POST['distance_from_prev'][$i] : null,
                        !empty($_POST['distance_from_source'][$i]) ? $_POST['distance_from_source'][$i] : null,
                        $arrival_time,
                        $departure_time,
                        $_POST['facilities'][$i] ?? null,
                        !empty($_POST['latitude'][$i]) ? $_POST['latitude'][$i] : null,
                        !empty($_POST['longitude'][$i]) ? $_POST['longitude'][$i] : null
                    ]);

                    $current_station_id = $pdo->lastInsertId();

                    // Insert fare only if provided
                    if (!empty($_POST['fare'][$i])) {
                        $stmt_fare = $pdo->prepare("INSERT INTO route_fares (route_id, from_station_id, to_station_id, fare_amount) 
                                                  VALUES (?, ?, ?, ?)");
                        $stmt_fare->execute([
                            $route_id,
                            $prev_station_id,
                            $current_station_id,
                            $_POST['fare'][$i]
                        ]);
                    }

                    $prev_station_id = $current_station_id;
                }
            }
        }

        // Update bus services only if bus data is provided
        if (isset($_POST['bus_number']) && is_array($_POST['bus_number'])) {
            $pdo->prepare("DELETE FROM bus_services WHERE route_id = ?")->execute([$route_id]);

            $stmt = $pdo->prepare("INSERT INTO bus_services (route_id, bus_number, bus_type, 
                seating_capacity, departure_time, arrival_time, operating_days) 
                VALUES (?, ?, ?, ?, ?, ?, ?)");

            for ($i = 0; $i < count($_POST['bus_number']); $i++) {
                if (!empty($_POST['bus_number'][$i])) {
                    $stmt->execute([
                        $route_id,
                        $_POST['bus_number'][$i],
                        $_POST['bus_type'][$i] ?? null,
                        $_POST['seating_capacity'][$i] ?? null,
                        $_POST['bus_departure_time'][$i] ?? null,
                        $_POST['bus_arrival_time'][$i] ?? null,
                        $_POST['operating_days'][$i] ?? null
                    ]);
                }
            }
        }

        // Update emergency contacts only if contact data is provided
        if (isset($_POST['contact_name']) && is_array($_POST['contact_name'])) {
            $pdo->prepare("DELETE FROM emergency_contacts WHERE route_id = ?")->execute([$route_id]);

            $stmt = $pdo->prepare("INSERT INTO emergency_contacts (route_id, station_id, contact_name, 
                contact_number, contact_type) VALUES (?, ?, ?, ?, ?)");

            for ($i = 0; $i < count($_POST['contact_name']); $i++) {
                if (!empty($_POST['contact_name'][$i]) && !empty($_POST['contact_number'][$i])) {
                    $stmt->execute([
                        $route_id,
                        $_POST['contact_station_id'][$i] ?? null,
                        $_POST['contact_name'][$i],
                        $_POST['contact_number'][$i],
                        $_POST['contact_type'][$i] ?? null
                    ]);
                }
            }
        }

        // Update media only if media data is provided
        if (isset($_POST['media_type']) && is_array($_POST['media_type'])) {
            $pdo->prepare("DELETE FROM route_media WHERE route_id = ?")->execute([$route_id]);

            $stmt = $pdo->prepare("INSERT INTO route_media (route_id, media_type, file_url, caption) 
                VALUES (?, ?, ?, ?)");

            for ($i = 0; $i < count($_POST['media_type']); $i++) {
                if (!empty($_POST['file_url'][$i])) {
                    $stmt->execute([
                        $route_id,
                        $_POST['media_type'][$i] ?? null,
                        $_POST['file_url'][$i],
                        $_POST['caption'][$i] ?? null
                    ]);
                }
            }
        }

        $pdo->commit();
        header("Location: manage-routes.php?success=Route updated successfully");
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        $error = "Error updating route: " . $e->getMessage();
    }
}

// Fetch route data
try {
    $stmt = $pdo->prepare("SELECT * FROM main_routes WHERE route_id = ?");
    $stmt->execute([$route_id]);
    $route = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("SELECT * FROM route_stations WHERE route_id = ? ORDER BY sequence_number");
    $stmt->execute([$route_id]);
    $stations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch fares for each station
    foreach ($stations as &$station) {
        $stmt = $pdo->prepare("SELECT fare_amount FROM route_fares WHERE route_id = ? AND from_station_id = ?");
        $stmt->execute([$route_id, $station['station_id']]);
        $fare = $stmt->fetch(PDO::FETCH_ASSOC);
        $station['fare'] = $fare ? $fare['fare_amount'] : null;
    }

    $stmt = $pdo->prepare("SELECT * FROM bus_services WHERE route_id = ?");
    $stmt->execute([$route_id]);
    $buses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("SELECT * FROM emergency_contacts WHERE route_id = ?");
    $stmt->execute([$route_id]);
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("SELECT * FROM route_media WHERE route_id = ?");
    $stmt->execute([$route_id]);
    $media = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $error = "Error fetching route data: " . $e->getMessage();
}

// Include the form HTML
include 'route-form.php';
?>

<script>
function addStationRow() {
    const container = document.getElementById('stations');
    const row = document.createElement('div');
    row.className = 'station-row mb-3 p-3 border rounded';
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
    const container = document.getElementById('buses');
    const row = document.createElement('div');
    row.className = 'bus-row mb-3 p-3 border rounded';
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
    const container = document.getElementById('contacts');
    const row = document.createElement('div');
    row.className = 'contact-row mb-3 p-3 border rounded';
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

function addMediaRow() {
    const container = document.getElementById('media');
    const row = document.createElement('div');
    row.className = 'media-row mb-3 p-3 border rounded';
    row.innerHTML = `
        <div class="row">
            <div class="col-md-3">
                <label class="form-label">Media Type</label>
                <select class="form-select" name="media_type[]">
                    <option value="Map">Map</option>
                    <option value="Station Photo">Station Photo</option>
                    <option value="Bus Photo">Bus Photo</option>
                    <option value="Scenic View">Scenic View</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">File URL</label>
                <input type="url" class="form-control" name="file_url[]" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Caption</label>
                <input type="text" class="form-control" name="caption[]">
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.media-row').remove()">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `;
    container.appendChild(row);
}
</script>

<?php require_once '../includes/admin-footer.php'; ?>
