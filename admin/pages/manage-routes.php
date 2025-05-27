<?php
require_once '../includes/auth-check.php';
require_once '../includes/db-config.php';
require_once '../includes/admin-header.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = '';
$success = '';

// Check for session messages
if (isset($_SESSION['success_message'])) {
    $success = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

if (isset($_SESSION['error_message'])) {
    $error = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}

// Handle route deletion
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
try {
        $route_id = (int)$_GET['delete'];
        
        // Start transaction
        $pdo->beginTransaction();
        
        // Delete related records first
        $pdo->prepare("DELETE FROM route_stations WHERE route_id = ?")->execute([$route_id]);
        $pdo->prepare("DELETE FROM bus_services WHERE route_id = ?")->execute([$route_id]);
        $pdo->prepare("DELETE FROM emergency_contacts WHERE route_id = ?")->execute([$route_id]);
        $pdo->prepare("DELETE FROM route_media WHERE route_id = ?")->execute([$route_id]);
        
        // Delete the route
        $pdo->prepare("DELETE FROM main_routes WHERE route_id = ?")->execute([$route_id]);
        
        $pdo->commit();
        $_SESSION['success_message'] = "Route deleted successfully!";
        header("Location: manage-routes.php");
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        $_SESSION['error_message'] = "Error deleting route: " . $e->getMessage();
        header("Location: manage-routes.php");
        exit;
    }
}

// Fetch all routes with their details
try {
    $sql = "SELECT r.*, 
            COUNT(DISTINCT s.station_id) as total_stations,
            COUNT(DISTINCT b.bus_id) as total_buses,
            GROUP_CONCAT(DISTINCT s.station_name ORDER BY s.sequence_number SEPARATOR ' → ') as station_sequence
            FROM main_routes r
            LEFT JOIN route_stations s ON r.route_id = s.route_id
            LEFT JOIN bus_services b ON r.route_id = b.route_id
            GROUP BY r.route_id
            ORDER BY r.created_at DESC";
    
    $routes = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $error = "Error fetching routes: " . $e->getMessage();
}
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

.manage-routes-bg {
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

.table {
    margin-bottom: 0;
}

.table th {
    font-weight: 600;
    color: var(--secondary);
    border-bottom: 2px solid rgba(0,0,0,0.05);
    padding: 1rem;
}

.table td {
    padding: 1rem;
    vertical-align: middle;
}

.route-map {
    max-width: 100px;
    max-height: 60px;
    border-radius: 8px;
    object-fit: cover;
}

.status-badge {
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
}

.status-active {
    background: #d4edda;
    color: #155724;
}

.status-inactive {
    background: #f8d7da;
    color: #721c24;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.btn {
    border-radius: 12px;
    padding: 0.5rem 1rem;
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

.btn-warning {
    background: var(--accent);
    border: none;
    color: var(--secondary);
}

.btn-warning:hover {
    background: #e69a00;
    transform: translateY(-2px);
}

.btn-danger {
    background: #dc3545;
    border: none;
}

.btn-danger:hover {
    background: #c82333;
    transform: translateY(-2px);
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

.station-sequence {
    font-size: 0.9rem;
    color: var(--secondary);
    max-width: 300px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

@media (max-width: 768px) {
    .page-header {
        padding: 1.5rem;
    }
    
    .table-responsive {
        border-radius: var(--radius);
    }
    
    .action-buttons {
        flex-direction: column;
    }
}
</style>

<div class="manage-routes-bg">
<div class="container-fluid px-4">
        <div class="page-header d-flex justify-content-between align-items-center">
            <div>
                <h1>Manage Routes</h1>
                <p class="mb-0">View, edit, and manage all bus routes in the system</p>
            </div>
            <a href="add-route.php" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Route
            </a>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 1050; min-width: 300px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                <i class="fas fa-exclamation-circle me-2"></i> <?= htmlspecialchars($error) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <script>
                setTimeout(function() {
                    document.querySelector('.alert-danger').classList.remove('show');
                }, 8000);
            </script>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 1050; min-width: 300px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                <i class="fas fa-check-circle me-2"></i> <?= htmlspecialchars($success) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <script>
                setTimeout(function() {
                    document.querySelector('.alert-success').classList.remove('show');
                }, 5000);
            </script>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                <i class="fas fa-route"></i> All Routes
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table">
                <thead>
                    <tr>
                                <th>Route</th>
                                <th>Stations</th>
                                <th>Distance</th>
                                <th>Time</th>
                                <th>Buses</th>
                                <th>Status</th>
                                <th>Map</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($routes)): ?>
                                <?php foreach($routes as $route): ?>
                            <tr>
                                        <td>
                                            <strong><?= htmlspecialchars($route['source']) ?> → <?= htmlspecialchars($route['destination']) ?></strong>
                                        </td>
                                        <td>
                                            <div class="station-sequence" title="<?= htmlspecialchars($route['station_sequence']) ?>">
                                                <?= htmlspecialchars($route['station_sequence']) ?>
                                            </div>
                                            <small class="text-muted"><?= $route['total_stations'] ?> stations</small>
                                        </td>
                                        <td><?= htmlspecialchars($route['total_distance']) ?> km</td>
                                        <td><?= htmlspecialchars($route['total_time']) ?></td>
                                        <td>
                                            <span class="badge bg-primary"><?= $route['total_buses'] ?> buses</span>
                                        </td>
                                        <td>
                                            <span class="status-badge <?= $route['is_active'] ? 'status-active' : 'status-inactive' ?>">
                                                <?= $route['is_active'] ? 'Active' : 'Inactive' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($route['route_map_url']): ?>
                                                <img src="<?= htmlspecialchars($route['route_map_url']) ?>" 
                                                     alt="Route Map" class="route-map">
                                            <?php else: ?>
                                                <span class="text-muted">No map</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="action-buttons">
                                            <a href="edit-route.php?id=<?= $route['route_id'] ?>" 
                                               class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                            <a href="manage-routes.php?delete=<?= $route['route_id'] ?>" 
                                               class="btn btn-danger btn-sm" 
                                               onclick="return confirm('Are you sure you want to delete this route? This action cannot be undone.')">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-route fa-2x mb-3"></i>
                                            <p>No routes found. Click "Add New Route" to create one.</p>
                                        </div>
                                    </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/admin-footer.php'; ?>
