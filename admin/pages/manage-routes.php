<?php
require_once '../includes/auth-check.php';
require_once '../includes/db-config.php';
require_once '../includes/admin-header.php';

$error = '';
$success = '';

// Fetch all routes
try {
    $stmt = $pdo->query("SELECT * FROM main_routes ORDER BY created_at DESC");
    $routes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $error = 'Error fetching routes: ' . $e->getMessage();
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Manage Routes</h1>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php elseif ($success): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-route"></i> All Routes
            <a href="add-route.php" class="btn btn-primary btn-sm float-end">
                <i class="fas fa-plus"></i> Add New Route
            </a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Source</th>
                        <th>Destination</th>
                        <th>Total Distance (km)</th>
                        <th>Total Time</th>
                        <th>Fare (₹)</th> <!-- New Fare column -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($routes)): ?>
                        <?php foreach ($routes as $index => $route): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo htmlspecialchars($route['source']); ?></td>
                                <td><?php echo htmlspecialchars($route['destination']); ?></td>
                                <td><?php echo htmlspecialchars($route['total_distance']); ?></td>
                                <td><?php echo htmlspecialchars($route['total_time']); ?></td>
                                <td><?php echo htmlspecialchars($route['fare']); ?></td> <!-- Display Fare -->
                                <td>
                                    <a href="edit-route.php?route_id=<?php echo $route['route_id']; ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="delete-route.php?route_id=<?php echo $route['route_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this route?');">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No routes found.</td> <!-- Updated colspan -->
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../includes/admin-footer.php'; ?>
