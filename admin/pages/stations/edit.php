<?php
require_once '../../includes/auth-check.php';
require_once '../../includes/db-config.php';
require_once '../../includes/admin-header.php';

$error = '';
$success = '';
$station = null;

// Get station ID from URL
$station_id = isset($_GET['station_id']) ? (int)$_GET['station_id'] : 0;

// Fetch all routes for dropdown
try {
    $stmt = $pdo->query("SELECT route_id, source, destination FROM main_routes ORDER BY source, destination");
    $routes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($station_id > 0) {
        $stmt = $pdo->prepare("SELECT * FROM route_stations WHERE station_id = ?");
        $stmt->execute([$station_id]);
        $station = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$station) {
            header("Location: manage.php");
            exit;
        }
    } else {
        header("Location: manage.php");
        exit;
    }
} catch (Exception $e) {
    $error = 'Error fetching data: ' . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (empty($_POST['route_id']) || empty($_POST['station_name']) || empty($_POST['sequence_number'])) {
            throw new Exception("Route, Station Name, and Sequence Number are required.");
        }

        $stmt = $pdo->prepare("UPDATE route_stations SET 
            route_id = ?, 
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
            $_POST['longitude'] ?: null,
            $station_id
        ]);
        $success = "Station updated successfully.";
        // Refresh station data
        $stmt = $pdo->prepare("SELECT * FROM route_stations WHERE station_id = ?");
        $stmt->execute([$station_id]);
        $station = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Station</h1>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
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
                                <option value="<?= $route['route_id'] ?>" <?= ($route['route_id'] == $station['route_id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($route['source']) ?> ➜ <?= htmlspecialchars($route['destination']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Station Name</label>
                        <input type="text" class="form-control" name="station_name" value="<?= htmlspecialchars($station['station_name']) ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Sequence Number</label>
                        <input type="number" class="form-control" name="sequence_number" min="1" value="<?= htmlspecialchars($station['sequence_number']) ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Distance from Previous (km)</label>
                        <input type="number" step="0.01" class="form-control" name="distance_from_prev" value="<?= htmlspecialchars($station['distance_from_prev']) ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Distance from Source (km)</label>
                        <input type="number" step="0.01" class="form-control" name="distance_from_source" value="<?= htmlspecialchars($station['distance_from_source']) ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Arrival Time</label>
                        <input type="time" class="form-control" name="arrival_time" value="<?= htmlspecialchars($station['arrival_time']) ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Departure Time</label>
                        <input type="time" class="form-control" name="departure_time" value="<?= htmlspecialchars($station['departure_time']) ?>">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Facilities</label>
                    <input type="text" class="form-control" name="facilities" value="<?= htmlspecialchars($station['facilities']) ?>">
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Latitude</label>
                        <input type="text" class="form-control" name="latitude" value="<?= htmlspecialchars($station['latitude']) ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Longitude</label>
                        <input type="text" class="form-control" name="longitude" value="<?= htmlspecialchars($station['longitude']) ?>">
                    </div>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Station
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once '../../includes/admin-footer.php'; ?> 