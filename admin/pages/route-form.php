<?php
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

<div class="container-fluid px-4">
    <h1 class="mt-4"><?= isset($route_id) && $route_id > 0 ? 'Edit' : 'Add' ?> Route</h1>
    
    <?php if (isset($error) && $error): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <!-- Main Route Details -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-route"></i> Route Details
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="source" class="form-label">Source</label>
                            <input type="text" class="form-control" id="source" name="source" 
                                   value="<?= isset($route['source']) ? htmlspecialchars($route['source']) : '' ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="destination" class="form-label">Destination</label>
                            <input type="text" class="form-control" id="destination" name="destination" 
                                   value="<?= isset($route['destination']) ? htmlspecialchars($route['destination']) : '' ?>" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="total_distance" class="form-label">Total Distance (km)</label>
                            <input type="number" step="0.01" class="form-control" id="total_distance" 
                                   name="total_distance" value="<?= isset($route['total_distance']) ? htmlspecialchars($route['total_distance']) : '' ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="total_time" class="form-label">Total Time</label>
                            <input type="text" class="form-control" id="total_time" name="total_time" 
                                   value="<?= isset($route['total_time']) ? htmlspecialchars($route['total_time']) : '' ?>" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="total_fare" class="form-label">Total Fare (₹)</label>
                            <input type="number" step="0.01" class="form-control" id="total_fare" 
                                   name="total_fare" value="<?= isset($route['total_fare']) ? htmlspecialchars($route['total_fare']) : '' ?>" required>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="route_description" class="form-label">Route Description</label>
                    <textarea class="form-control" id="route_description" name="route_description" 
                              rows="3"><?= isset($route['route_description']) ? htmlspecialchars($route['route_description']) : '' ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="route_map" class="form-label">Route Map</label>
                    <?php if (isset($route['route_map_url']) && $route['route_map_url']): ?>
                        <div class="mb-2">
                            <img src="<?= htmlspecialchars($route['route_map_url']) ?>" alt="Current Route Map" 
                                 style="max-width: 200px; max-height: 150px;">
                        </div>
                    <?php endif; ?>
                    <input type="file" class="form-control" id="route_map" name="route_map" accept="image/*">
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" 
                               <?= isset($route['is_active']) && $route['is_active'] ? 'checked' : '' ?>>
                        <label class="form-check-label" for="is_active">Active Route</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stations Section -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div><i class="fas fa-map-marker-alt"></i> Stations</div>
                <button type="button" class="btn btn-primary btn-sm" onclick="addStationRow()">
                    <i class="fas fa-plus"></i> Add Station
                </button>
            </div>
            <div class="card-body">
                <div id="stations">
                    <?php if (isset($stations) && is_array($stations)): ?>
                        <?php foreach ($stations as $station): ?>
                            <div class="station-row mb-3 p-3 border rounded">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label">Station Name</label>
                                        <input type="text" class="form-control" name="station_name[]" 
                                               value="<?= htmlspecialchars($station['station_name']) ?>" required>
                                    </div>
                                    <div class="col-md-1">
                                        <label class="form-label">Sequence</label>
                                        <input type="number" class="form-control" name="sequence_number[]" 
                                               value="<?= htmlspecialchars($station['sequence_number']) ?>" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Distance from Prev (km)</label>
                                        <input type="number" step="0.01" class="form-control" name="distance_from_prev[]" 
                                               value="<?= htmlspecialchars($station['distance_from_prev']) ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Distance from Source (km)</label>
                                        <input type="number" step="0.01" class="form-control" name="distance_from_source[]" 
                                               value="<?= htmlspecialchars($station['distance_from_source']) ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Fare (₹)</label>
                                        <input type="number" step="0.01" class="form-control" name="fare[]" 
                                               value="<?= htmlspecialchars($station['fare']) ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Arrival Time</label>
                                        <input type="time" class="form-control" name="arrival_time[]" 
                                               value="<?= htmlspecialchars($station['arrival_time']) ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Departure Time</label>
                                        <input type="time" class="form-control" name="departure_time[]" 
                                               value="<?= htmlspecialchars($station['departure_time']) ?>">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-4">
                                        <label class="form-label">Facilities</label>
                                        <input type="text" class="form-control" name="facilities[]" 
                                               value="<?= htmlspecialchars($station['facilities']) ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Latitude</label>
                                        <input type="number" step="0.00000001" class="form-control" name="latitude[]" 
                                               value="<?= htmlspecialchars($station['latitude']) ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Longitude</label>
                                        <input type="number" step="0.00000001" class="form-control" name="longitude[]" 
                                               value="<?= htmlspecialchars($station['longitude']) ?>">
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.station-row').remove()">
                                            <i class="fas fa-trash"></i> Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Bus Services Section -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div><i class="fas fa-bus"></i> Bus Services</div>
                <button type="button" class="btn btn-primary btn-sm" onclick="addBusRow()">
                    <i class="fas fa-plus"></i> Add Bus
                </button>
            </div>
            <div class="card-body">
                <div id="buses">
                    <?php if (isset($buses) && is_array($buses)): ?>
                        <?php foreach ($buses as $bus): ?>
                            <div class="bus-row mb-3 p-3 border rounded">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="form-label">Bus Number</label>
                                        <input type="text" class="form-control" name="bus_number[]" 
                                               value="<?= htmlspecialchars($bus['bus_number']) ?>" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Bus Type</label>
                                        <select class="form-select" name="bus_type[]">
                                            <option value="Local" <?= $bus['bus_type'] === 'Local' ? 'selected' : '' ?>>Local</option>
                                            <option value="Express" <?= $bus['bus_type'] === 'Express' ? 'selected' : '' ?>>Express</option>
                                            <option value="Deluxe" <?= $bus['bus_type'] === 'Deluxe' ? 'selected' : '' ?>>Deluxe</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Seating Capacity</label>
                                        <input type="number" class="form-control" name="seating_capacity[]" 
                                               value="<?= htmlspecialchars($bus['seating_capacity']) ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Departure Time</label>
                                        <input type="time" class="form-control" name="bus_departure_time[]" 
                                               value="<?= htmlspecialchars($bus['departure_time']) ?>" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Arrival Time</label>
                                        <input type="time" class="form-control" name="bus_arrival_time[]" 
                                               value="<?= htmlspecialchars($bus['arrival_time']) ?>" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Operating Days</label>
                                        <input type="text" class="form-control" name="operating_days[]" 
                                               value="<?= htmlspecialchars($bus['operating_days']) ?>">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.bus-row').remove()">
                                            <i class="fas fa-trash"></i> Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Emergency Contacts Section -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div><i class="fas fa-phone"></i> Emergency Contacts</div>
                <button type="button" class="btn btn-primary btn-sm" onclick="addContactRow()">
                    <i class="fas fa-plus"></i> Add Contact
                </button>
            </div>
            <div class="card-body">
                <div id="contacts">
                    <?php if (isset($contacts) && is_array($contacts)): ?>
                        <?php foreach ($contacts as $contact): ?>
                            <div class="contact-row mb-3 p-3 border rounded">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label">Contact Name</label>
                                        <input type="text" class="form-control" name="contact_name[]" 
                                               value="<?= htmlspecialchars($contact['contact_name']) ?>" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Contact Number</label>
                                        <input type="text" class="form-control" name="contact_number[]" 
                                               value="<?= htmlspecialchars($contact['contact_number']) ?>" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Contact Type</label>
                                        <input type="text" class="form-control" name="contact_type[]" 
                                               value="<?= htmlspecialchars($contact['contact_type']) ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Station ID</label>
                                        <input type="number" class="form-control" name="contact_station_id[]" 
                                               value="<?= htmlspecialchars($contact['station_id']) ?>">
                                    </div>
                                    <div class="col-md-1 d-flex align-items-end">
                                        <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.contact-row').remove()">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Media Section -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div><i class="fas fa-images"></i> Route Media</div>
                <button type="button" class="btn btn-primary btn-sm" onclick="addMediaRow()">
                    <i class="fas fa-plus"></i> Add Media
                </button>
            </div>
            <div class="card-body">
                <div id="media">
                    <?php if (isset($media) && is_array($media)): ?>
                        <?php foreach ($media as $item): ?>
                            <div class="media-row mb-3 p-3 border rounded">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label">Media Type</label>
                                        <select class="form-select" name="media_type[]">
                                            <option value="Map" <?= $item['media_type'] === 'Map' ? 'selected' : '' ?>>Map</option>
                                            <option value="Station Photo" <?= $item['media_type'] === 'Station Photo' ? 'selected' : '' ?>>Station Photo</option>
                                            <option value="Bus Photo" <?= $item['media_type'] === 'Bus Photo' ? 'selected' : '' ?>>Bus Photo</option>
                                            <option value="Scenic View" <?= $item['media_type'] === 'Scenic View' ? 'selected' : '' ?>>Scenic View</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">File URL</label>
                                        <input type="url" class="form-control" name="file_url[]" 
                                               value="<?= htmlspecialchars($item['file_url']) ?>" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Caption</label>
                                        <input type="text" class="form-control" name="caption[]" 
                                               value="<?= htmlspecialchars($item['caption']) ?>">
                                    </div>
                                    <div class="col-md-1 d-flex align-items-end">
                                        <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.media-row').remove()">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Changes
            </button>
            <a href="manage-routes.php" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>

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