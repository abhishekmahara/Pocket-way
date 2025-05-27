<?php
require_once '../../includes/auth-check.php';
require_once '../../includes/db-config.php';
require_once '../../includes/admin-header.php';

$error = '';
$success = '';

// Fetch all routes for dropdown
try {
    $stmt = $pdo->query("SELECT route_id, source, destination FROM main_routes ORDER BY source, destination");
    $routes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $error = 'Error fetching routes: ' . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (empty($_POST['route_id']) || empty($_POST['station_name']) || empty($_POST['sequence_number'])) {
            throw new Exception("Route, Station Name, and Sequence Number are required.");
        }

        $stmt = $pdo->prepare("INSERT INTO route_stations 
            (route_id, station_name, sequence_number, distance_from_prev, distance_from_source, arrival_time, departure_time, facilities, latitude, longitude) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['route_id'],
            $_POST['station_name'],
            $_POST['sequence_number'],
            $_POST['distance_from_prev'] ?: null,
            $_POST['distance_from_source'] ?: null,
            $_POST['arrival_time'] ?: null,
            $_POST['departure_time'] ?: null,
            $_POST['facilities'] ?: null,
            $_POST['latitude'] ?: null,
            $_POST['longitude'] ?: null
        ]);
        header("Location: manage.php");
        exit;
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Add New Station</h1>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <div class="card mb-4">
        <div class="card-body">
            <form method="POST" action="">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Route</label>
                        <select class="form-select" name="route_id" required>
                            <option value="">Select Route</option>
                            <?php foreach ($routes as $route): ?>
                                <option value="<?= $route['route_id'] ?>">
                                    <?= htmlspecialchars($route['source']) ?> ➜ <?= htmlspecialchars($route['destination']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Station Name</label>
                        <input type="text" class="form-control" name="station_name" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Sequence Number</label>
                        <input type="number" class="form-control" name="sequence_number" min="1" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Distance from Previous (km)</label>
                        <input type="number" step="0.01" class="form-control" name="distance_from_prev">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Distance from Source (km)</label>
                        <input type="number" step="0.01" class="form-control" name="distance_from_source">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Arrival Time</label>
                        <input type="time" class="form-control" name="arrival_time">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Departure Time</label>
                        <input type="time" class="form-control" name="departure_time">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Facilities</label>
                    <input type="text" class="form-control" name="facilities" placeholder="e.g. Restrooms, ATM, Food">
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Latitude</label>
                        <input type="text" class="form-control" name="latitude">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Longitude</label>
                        <input type="text" class="form-control" name="longitude">
                    </div>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Station
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once '../../includes/admin-footer.php'; ?> 