<?php
require_once '../../includes/auth-check.php';
require_once '../../includes/db-config.php';
require_once '../../includes/admin-header.php';

$routeId = $_GET['route_id'] ?? null;
$error = '';
$success = '';

// Fetch route details
if ($routeId) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM main_routes WHERE route_id = ?");
        $stmt->execute([$routeId]);
        $route = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$route) {
            $error = 'Route not found.';
        }

        // Fetch stations
        $stationStmt = $pdo->prepare("SELECT * FROM route_stations WHERE route_id = ? ORDER BY sequence_number ASC");
        $stationStmt->execute([$routeId]);
        $stations = $stationStmt->fetchAll(PDO::FETCH_ASSOC);

        // Fetch buses
        $busStmt = $pdo->prepare("SELECT * FROM bus_services WHERE route_id = ?");
        $busStmt->execute([$routeId]);
        $buses = $busStmt->fetchAll(PDO::FETCH_ASSOC);

        // Fetch fares
        $fareStmt = $pdo->prepare("SELECT * FROM route_fares WHERE route_id = ?");
        $fareStmt->execute([$routeId]);
        $fares = $fareStmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $error = 'Error fetching route details: ' . $e->getMessage();
    }
} else {
    $error = 'Invalid route ID.';
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Route</h1>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php elseif ($success): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <?php if ($route): ?>
        <form method="POST" action="update-route.php" enctype="multipart/form-data">
            <input type="hidden" name="route_id" value="<?php echo $route['route_id']; ?>">

            <!-- Route Details -->
            <div class="card mb-4">
                <div class="card-header">Route Details</div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Source</label>
                            <input type="text" class="form-control" name="source" value="<?php echo htmlspecialchars($route['source']); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label>Destination</label>
                            <input type="text" class="form-control" name="destination" value="<?php echo htmlspecialchars($route['destination']); ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Total Distance (km)</label>
                            <input type="number" class="form-control" name="total_distance" value="<?php echo htmlspecialchars($route['total_distance']); ?>" step="0.1" required>
                        </div>
                        <div class="col-md-6">
                            <label>Total Time</label>
                            <input type="text" class="form-control" name="total_time" value="<?php echo htmlspecialchars($route['total_time']); ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label>Route Description</label>
                            <textarea class="form-control" name="route_description" rows="3"><?php echo htmlspecialchars($route['route_description']); ?></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label>Route Map</label>
                            <input type="file" class="form-control" name="route_map" accept="image/*">
                            <?php if ($route['route_map_url']): ?>
                                <img src="../../../uploads/maps/<?php echo $route['route_map_url']; ?>" alt="Route Map" class="img-fluid mt-2" style="max-height: 200px;">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stations, Buses, and Fares -->
            <!-- Add dynamic forms for stations, buses, and fares here -->

            <button type="submit" class="btn btn-primary">Update Route</button>
        </form>
    <?php endif; ?>
</div>

<?php require_once '../../includes/admin-footer.php'; ?>