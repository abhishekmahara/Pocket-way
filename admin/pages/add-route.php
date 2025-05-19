<?php
require_once '../../includes/auth-check.php';
require_once '../../includes/db-config.php';
require_once '../../includes/admin-header.php';

$error = '';
$success = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo->beginTransaction();

        // Insert main route
        $stmt = $pdo->prepare("
            INSERT INTO main_routes (source, destination, total_distance, total_time, route_map_url, route_description, is_active)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        $mapFileName = null;
        if (isset($_FILES['route_map']) && $_FILES['route_map']['error'] === 0) {
            $mapFileName = time() . '_' . $_FILES['route_map']['name'];
            move_uploaded_file($_FILES['route_map']['tmp_name'], '../../../uploads/maps/' . $mapFileName);
        }

        $stmt->execute([
            $_POST['source'],
            $_POST['destination'],
            $_POST['total_distance'],
            $_POST['total_time'],
            $mapFileName,
            $_POST['route_description'],
            1
        ]);

        $routeId = $pdo->lastInsertId();

        // Insert stations
        if (!empty($_POST['stations'])) {
            $stationStmt = $pdo->prepare("
                INSERT INTO route_stations (route_id, station_name, sequence_number, distance_from_prev, distance_from_source, arrival_time, departure_time, facilities, latitude, longitude)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

            foreach ($_POST['stations'] as $index => $station) {
                $stationStmt->execute([
                    $routeId,
                    $station['name'],
                    $index + 1,
                    $station['distance_from_prev'],
                    $station['distance_from_source'],
                    $station['arrival_time'],
                    $station['departure_time'],
                    $station['facilities'],
                    $station['latitude'],
                    $station['longitude']
                ]);
            }
        }

        // Insert buses
        if (!empty($_POST['buses'])) {
            $busStmt = $pdo->prepare("
                INSERT INTO bus_services (route_id, bus_number, bus_type, seating_capacity, departure_time, arrival_time, operating_days)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");

            foreach ($_POST['buses'] as $bus) {
                $busStmt->execute([
                    $routeId,
                    $bus['bus_number'],
                    $bus['bus_type'],
                    $bus['seating_capacity'],
                    $bus['departure_time'],
                    $bus['arrival_time'],
                    $bus['operating_days']
                ]);
            }
        }

        // Insert fares
        if (!empty($_POST['fares'])) {
            $fareStmt = $pdo->prepare("
                INSERT INTO route_fares (route_id, from_station_id, to_station_id, fare_amount)
                VALUES (?, ?, ?, ?)
            ");

            foreach ($_POST['fares'] as $fare) {
                $fareStmt->execute([
                    $routeId,
                    $fare['from_station_id'],
                    $fare['to_station_id'],
                    $fare['fare_amount']
                ]);
            }
        }

        $pdo->commit();
        $success = 'Route added successfully!';
    } catch (Exception $e) {
        $pdo->rollBack();
        $error = 'Error adding route: ' . $e->getMessage();
    }
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Add New Route</h1>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php elseif ($success): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <form method="POST" action="" enctype="multipart/form-data">
        <!-- Route Details -->
        <div class="card mb-4">
            <div class="card-header">Route Details</div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Source</label>
                        <input type="text" class="form-control" name="source" required>
                    </div>
                    <div class="col-md-6">
                        <label>Destination</label>
                        <input type="text" class="form-control" name="destination" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Total Distance (km)</label>
                        <input type="number" class="form-control" name="total_distance" step="0.1" required>
                    </div>
                    <div class="col-md-6">
                        <label>Total Time</label>
                        <input type="text" class="form-control" name="total_time" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label>Route Description</label>
                        <textarea class="form-control" name="route_description" rows="3"></textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label>Route Map</label>
                        <input type="file" class="form-control" name="route_map" accept="image/*">
                    </div>
                </div>
            </div>
        </div>

        <!-- Stations -->
        <div class="card mb-4">
            <div class="card-header">Stations</div>
            <div class="card-body">
                <div id="stations-container">
                    <!-- Stations will be added dynamically -->
                </div>
                <button type="button" class="btn btn-success" id="add-station">Add Station</button>
            </div>
        </div>

        <!-- Buses -->
        <div class="card mb-4">
            <div class="card-header">Buses</div>
            <div class="card-body">
                <div id="buses-container">
                    <!-- Buses will be added dynamically -->
                </div>
                <button type="button" class="btn btn-info" id="add-bus">Add Bus</button>
            </div>
        </div>

        <!-- Fares -->
        <div class="card mb-4">
            <div class="card-header">Fares</div>
            <div class="card-body">
                <div id="fares-container">
                    <!-- Fares will be added dynamically -->
                </div>
                <button type="button" class="btn btn-warning" id="add-fare">Add Fare</button>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Save Route</button>
    </form>
</div>

<script>
    // JavaScript for dynamically adding stations, buses, and fares
</script>

<?php require_once '../../includes/admin-footer.php'; ?>