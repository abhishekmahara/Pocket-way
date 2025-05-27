<?php
require_once '../../includes/auth-check.php';
require_once '../../includes/db-config.php';
require_once '../../includes/admin-header.php';

try {
    // Fetch all buses with their route information
    $stmt = $pdo->prepare("
        SELECT 
            bs.*,
            mr.source,
            mr.destination
        FROM bus_services bs
        LEFT JOIN main_routes mr ON bs.route_id = mr.route_id
        ORDER BY bs.bus_number ASC
    ");
    $stmt->execute();
    $buses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $error = 'Error fetching buses: ' . $e->getMessage();
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Manage Bus Fleet</h1>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-bus"></i> All Buses
            <a href="add.php" class="btn btn-primary float-end">
                <i class="fas fa-plus"></i> Add New Bus
            </a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Bus Number</th>
                        <th>Type</th>
                        <th>Route</th>
                        <th>Capacity</th>
                        <th>Departure</th>
                        <th>Arrival</th>
                        <th>Operating Days</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($buses)): ?>
                        <tr>
                            <td colspan="9" class="text-center">
                                <div class="text-muted">
                                    <i class="fas fa-bus fa-2x mb-3"></i>
                                    <p class="mb-0">No buses found</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($buses as $index => $bus): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td>
                                    <span class="fw-bold"><?= htmlspecialchars($bus['bus_number']) ?></span>
                                </td>
                                <td>
                                    <span class="badge bg-info text-dark">
                                        <?= htmlspecialchars($bus['bus_type']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($bus['source'] && $bus['destination']): ?>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-route text-primary me-2"></i>
                                            <?= htmlspecialchars($bus['source']) ?> ➜ <?= htmlspecialchars($bus['destination']) ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted">Not assigned</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">
                                        <?= htmlspecialchars($bus['seating_capacity']) ?> seats
                                    </span>
                                </td>
                                <td>
                                    <i class="far fa-clock text-primary me-1"></i>
                                    <?= htmlspecialchars($bus['departure_time']) ?>
                                </td>
                                <td>
                                    <i class="far fa-clock text-primary me-1"></i>
                                    <?= htmlspecialchars($bus['arrival_time']) ?>
                                </td>
                                <td>
                                    <span class="text-muted">
                                        <?= htmlspecialchars($bus['operating_days']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="edit.php?id=<?= $bus['bus_id'] ?>" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" 
                                            onclick="deleteBus(<?= $bus['bus_id'] ?>)">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function deleteBus(busId) {
    if (confirm('Are you sure you want to delete this bus?')) {
        window.location.href = `delete.php?id=${busId}`;
    }
}
</script>

<?php require_once '../../includes/admin-footer.php'; ?> 