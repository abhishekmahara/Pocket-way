<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../includes/auth-check.php';
require_once '../includes/db-config.php';
require_once '../includes/admin-header.php';

try {
    $totalRoutes = $pdo->query("SELECT COUNT(*) AS count FROM main_routes")->fetch()['count'] ?? 0;
    $totalStations = $pdo->query("SELECT COUNT(*) AS count FROM route_stations")->fetch()['count'] ?? 0;
    $totalBuses = $pdo->query("SELECT COUNT(*) AS count FROM bus_services")->fetch()['count'] ?? 0;
} catch (Exception $e) {
    $error = 'Error fetching statistics: ' . $e->getMessage();
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
.dashboard-bg {
    background: var(--gray);
    min-height: 100vh;
    padding-bottom: 40px;
}
.dashboard-header-card {
    background: linear-gradient(90deg, var(--primary) 60%, var(--accent) 100%);
    color: var(--white);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    padding: 2.2rem 2rem 2rem 2rem;
    margin-bottom: 2.5rem;
}
.dashboard-header-card h1 {
    font-size: 2.3rem;
    font-weight: 700;
    margin-bottom: 0.3rem;
}
.dashboard-header-card p {
    font-size: 1.15rem;
    opacity: 0.95;
}
.dashboard-header-actions .btn {
    font-weight: 600;
    font-size: 1.1rem;
    border-radius: 12px;
    padding: 0.7rem 1.6rem;
    background: var(--white);
    color: var(--primary);
    border: none;
    box-shadow: 0 2px 8px rgba(0,0,0,0.07);
    transition: all 0.2s;
}
.dashboard-header-actions .btn:hover {
    background: var(--accent);
    color: var(--secondary);
}
.stats-row .card {
    border: none;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    transition: transform 0.2s;
}
.stats-row .card:hover {
    transform: translateY(-6px) scale(1.03);
}
.stat-gradient-primary {
    background: linear-gradient(120deg, var(--primary) 0%, #00b3b8 100%);
    color: var(--white);
}
.stat-gradient-accent {
    background: linear-gradient(120deg, var(--accent) 0%, #ffe066 100%);
    color: #333;
}
.stat-gradient-secondary {
    background: linear-gradient(120deg, var(--secondary) 0%, #009398 100%);
    color: var(--white);
}
.stat-icon {
    font-size: 2.5rem;
    background: rgba(255,255,255,0.18);
    border-radius: 50%;
    width: 62px;
    height: 62px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.2rem;
}
.stat-label {
    font-size: 1.1rem;
    font-weight: 500;
    margin-bottom: 0.2rem;
}
.stat-value {
    font-size: 2.2rem;
    font-weight: 700;
    margin-bottom: 0.7rem;
}
.stat-link {
    font-weight: 500;
    text-decoration: none;
    opacity: 0.9;
    color: inherit;
    transition: opacity 0.2s;
}
.stat-link:hover {
    opacity: 1;
    text-decoration: underline;
}
.quick-actions-card {
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    background: var(--white);
    margin-top: 2.5rem;
    padding: 2rem 1.5rem;
}
.quick-actions-title {
    color: var(--primary);
    font-size: 1.4rem;
    font-weight: 700;
    margin-bottom: 1.7rem;
}
.quick-actions-row .action-card {
    border-radius: 14px;
    background: var(--gray);
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    padding: 1.7rem 1rem;
    text-align: center;
    text-decoration: none;
    color: #222;
    border: 2px solid transparent;
    transition: all 0.2s;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
}
.quick-actions-row .action-card:hover {
    border-color: var(--primary);
    background: #e6f7f8;
    transform: translateY(-4px) scale(1.02);
}
.action-icon {
    width: 54px;
    height: 54px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.7rem;
    margin-bottom: 1rem;
    background: var(--white);
}
.action-icon.primary { color: var(--primary); }
.action-icon.accent { color: var(--accent); }
.action-icon.secondary { color: var(--secondary); }
@media (max-width: 900px) {
    .dashboard-header-card { padding: 1.5rem 1rem; }
    .quick-actions-card { padding: 1rem 0.5rem; }
}
</style>

<div class="dashboard-bg">
    <div class="container py-4">
        <!-- Dashboard Header -->
        <div class="dashboard-header-card d-flex flex-wrap justify-content-between align-items-center mb-5">
            <div>
                <h1>Pocket-Way Admin Dashboard</h1>
                <p>Welcome back! Manage your routes, stations, buses, and more with ease.</p>
            </div>
            <div class="dashboard-header-actions">
                <a href="routes/add-route.php" class="btn">
                    <i class="fas fa-plus"></i> Add New Route
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row stats-row g-4 mb-4">
            <div class="col-md-4">
                <div class="card stat-gradient-primary h-100">
                    <div class="card-body d-flex flex-column align-items-start">
                        <div class="stat-icon"><i class="fas fa-route"></i></div>
                        <div class="stat-label">Total Routes</div>
                        <div class="stat-value"><?php echo number_format($totalRoutes); ?></div>
                        <a href="manage-routes.php" class="stat-link mt-auto">Manage <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-gradient-accent h-100">
                    <div class="card-body d-flex flex-column align-items-start">
                        <div class="stat-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div class="stat-label">Total Stations</div>
                        <div class="stat-value"><?php echo number_format($totalStations); ?></div>
                        <a href="station.php" class="stat-link mt-auto">Manage <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-gradient-secondary h-100">
                    <div class="card-body d-flex flex-column align-items-start">
                        <div class="stat-icon"><i class="fas fa-bus"></i></div>
                        <div class="stat-label">Active Buses</div>
                        <div class="stat-value"><?php echo number_format($totalBuses); ?></div>
                        <a href="buses/manage.php" class="stat-link mt-auto">Manage <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions-card">
            <div class="quick-actions-title">Quick Actions</div>
            <div class="row quick-actions-row g-4">
                <div class="col-md-3 col-6">
                    <a href="add-route.php" class="action-card">
                        <div class="action-icon primary"><i class="fas fa-plus-circle"></i></div>
                        <h3 class="h6 mb-1">Add Route</h3>
                        <p class="mb-0 small">Create a <b>completely new route</b> with all details: stations, fares, timings, buses, and map image.</p>
                    </a>
                </div>
                <div class="col-md-3 col-6">
                    <a href="manage-routes.php" class="action-card">
                        <div class="action-icon accent"><i class="fas fa-route"></i></div>
                        <h3 class="h6 mb-1">Manage Routes</h3>
                        <p class="mb-0 small"><b>Edit or manage everything</b> about existing routes: stations, fares, timings, buses, map images, and more.</p>
                    </a>
                </div>
                <div class="col-md-3 col-6">
                    <a href="station.php" class="action-card">
                        <div class="action-icon secondary"><i class="fas fa-map-marked-alt"></i></div>
                        <h3 class="h6 mb-1">Stations</h3>
                        <p class="mb-0 small">Manage all bus stations in the system.</p>
                    </a>
                </div>
                <div class="col-md-3 col-6">
                    <a href="buses/manage.php" class="action-card">
                        <div class="action-icon primary"><i class="fas fa-bus"></i></div>
                        <h3 class="h6 mb-1">Bus Fleet</h3>
                        <p class="mb-0 small">Manage all buses and their assignments.</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/admin-footer.php'; ?>