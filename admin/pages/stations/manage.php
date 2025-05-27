<?php
require_once '../../includes/auth-check.php';
require_once '../../includes/db-config.php';
require_once '../../includes/admin-header.php';

$error = '';
$success = '';

// Fetch all stations with route info
try {
    $stmt = $pdo->query("
        SELECT rs.*, mr.source, mr.destination
        FROM route_stations rs
        JOIN main_routes mr ON rs.route_id = mr.route_id
        ORDER BY rs.route_id, rs.sequence_number
    ");
    $stations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $error = 'Error fetching station data: ' . $e->getMessage();
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Manage Stations</h1>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php elseif ($success): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-map-marker-alt"></i> All Stations
            <a href="add.php" class="btn btn-primary float-end">
                <i class="fas fa-plus"></i> Add New Station
            </a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Route (Source ➜ Destination)</th>
                        <th>Station Name</th>
                        <th>Sequence</th>
                        <th>Arrival Time</th>
                        <th>Departure Time</th>
                        <th>Distance From Start (km)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($stations)): ?>
                        <?php foreach ($stations as $index => $station): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo htmlspecialchars($station['source']) . " ➜ " . htmlspecialchars($station['destination']); ?></td>
                                <td><?php echo htmlspecialchars($station['station_name']); ?></td>
                                <td><?php echo htmlspecialchars($station['sequence_number']); ?></td>
                                <td><?php echo isset($station['arrival_time']) ? htmlspecialchars($station['arrival_time']) : '—'; ?></td>
                                <td><?php echo isset($station['departure_time']) ? htmlspecialchars($station['departure_time']) : '—'; ?></td>
                                <td><?php echo isset($station['distance_from_source']) ? htmlspecialchars($station['distance_from_source']) : '—'; ?></td>
                                <td>
                                    <a href="edit.php?station_id=<?php echo $station['station_id']; ?>" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="delete.php?station_id=<?php echo $station['station_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this station?');">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="8" class="text-center">No stations found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../../includes/admin-footer.php'; ?> 