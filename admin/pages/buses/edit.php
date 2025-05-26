<?php
require_once '../../includes/auth-check.php';
require_once '../../includes/db-config.php';
require_once '../../includes/admin-header.php';

$error = '';
$success = '';
$bus = null;

// Get bus ID from URL
$bus_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

try {
    // Fetch all routes for dropdown
    $stmt = $pdo->query("SELECT route_id, source, destination FROM main_routes ORDER BY source, destination");
    $routes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch bus details
    if ($bus_id > 0) {
        $stmt = $pdo->prepare("SELECT * FROM bus_services WHERE bus_id = ?");
        $stmt->execute([$bus_id]);
        $bus = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$bus) {
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
        // Validate required fields
        if (empty($_POST['bus_number']) || empty($_POST['route_id'])) {
            throw new Exception("Bus number and route are required");
        }

        // Update bus
        $stmt = $pdo->prepare("UPDATE bus_services SET 
            route_id = ?,
            bus_number = ?,
            bus_type = ?,
            seating_capacity = ?,
            departure_time = ?,
            arrival_time = ?,
            operating_days = ?
            WHERE bus_id = ?");
        
        $stmt->execute([
            $_POST['route_id'],
            $_POST['bus_number'],
            $_POST['bus_type'],
            $_POST['seating_capacity'],
            $_POST['departure_time'],
            $_POST['arrival_time'],
            $_POST['operating_days'],
            $bus_id
        ]);

        $success = "Bus updated successfully";
        
        // Refresh bus data
        $stmt = $pdo->prepare("SELECT * FROM bus_services WHERE bus_id = ?");
        $stmt->execute([$bus_id]);
        $bus = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Edit Bus</h1>
        <a href="manage.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Bus Number</label>
                        <input type="text" class="form-control" name="bus_number" 
                               value="<?= htmlspecialchars($bus['bus_number']) ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Route</label>
                        <select class="form-select" name="route_id" required>
                            <option value="">Select Route</option>
                            <?php foreach ($routes as $route): ?>
                                <option value="<?= $route['route_id'] ?>" 
                                    <?= ($route['route_id'] == $bus['route_id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($route['source']) ?> to <?= htmlspecialchars($route['destination']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Bus Type</label>
                        <select class="form-select" name="bus_type">
                            <option value="Local" <?= ($bus['bus_type'] == 'Local') ? 'selected' : '' ?>>Local</option>
                            <option value="Express" <?= ($bus['bus_type'] == 'Express') ? 'selected' : '' ?>>Express</option>
                            <option value="Deluxe" <?= ($bus['bus_type'] == 'Deluxe') ? 'selected' : '' ?>>Deluxe</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Seating Capacity</label>
                        <input type="number" class="form-control" name="seating_capacity" 
                               value="<?= htmlspecialchars($bus['seating_capacity']) ?>" min="1" max="100">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Departure Time</label>
                        <input type="time" class="form-control" name="departure_time" 
                               value="<?= htmlspecialchars($bus['departure_time']) ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Arrival Time</label>
                        <input type="time" class="form-control" name="arrival_time" 
                               value="<?= htmlspecialchars($bus['arrival_time']) ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Operating Days</label>
                    <input type="text" class="form-control" name="operating_days" 
                           value="<?= htmlspecialchars($bus['operating_days']) ?>"
                           placeholder="e.g., Monday to Friday">
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Bus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once '../../includes/admin-footer.php'; ?> 