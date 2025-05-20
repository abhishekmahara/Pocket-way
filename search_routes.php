<?php
require_once 'admin/includes/db-config.php';
include 'includes/header.php';

$from = $_GET['from'] ?? '';
$to = $_GET['to'] ?? '';

// Special case for Haldwani to Adi Kailash route
if (strtolower($from) === 'haldwani' && strtolower($to) === 'adi kailash') {
    header('Location: routes/haldwani-to-adi-kailash.php');
    exit;
}

try {
    // Get matching routes
    $stmt = $pdo->prepare("
        SELECT r.*, 
            COUNT(DISTINCT s.station_id) as total_stations,
            COUNT(DISTINCT b.bus_id) as total_buses
        FROM main_routes r
        LEFT JOIN route_stations s ON r.route_id = s.route_id
        LEFT JOIN bus_services b ON r.route_id = b.route_id
        WHERE r.source = ? AND r.destination = ? AND r.is_active = 1
        GROUP BY r.route_id
    ");
    $stmt->execute([$from, $to]);
    $routes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $error = 'Error searching routes: ' . $e->getMessage();
    $routes = [];
}
?>

<main class="py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="section-title">Search Results</h2>
                <p class="text-muted">
                    <?php if ($from && $to): ?>
                        Showing routes from <?= htmlspecialchars($from) ?> to <?= htmlspecialchars($to) ?>
                    <?php endif; ?>
                </p>
            </div>
        </div>

        <?php if (!empty($routes)): ?>
            <div class="row">
                <?php foreach ($routes as $route): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <?= htmlspecialchars($route['source']) ?> → <?= htmlspecialchars($route['destination']) ?>
                                </h5>
                                <div class="mb-3">
                                    <span class="badge bg-primary me-2">
                                        <i class="fas fa-road"></i> <?= htmlspecialchars($route['total_distance']) ?> km
                                    </span>
                                    <span class="badge bg-info me-2">
                                        <i class="fas fa-clock"></i> <?= htmlspecialchars($route['total_time']) ?>
                                    </span>
                                    <span class="badge bg-success me-2">
                                        <i class="fas fa-map-marker-alt"></i> <?= $route['total_stations'] ?> Stations
                                    </span>
                                    <span class="badge bg-warning">
                                        <i class="fas fa-bus"></i> <?= $route['total_buses'] ?> Buses
                                    </span>
                                </div>
                                <p class="card-text"><?= htmlspecialchars($route['route_description']) ?></p>
                                <a href="route_details.php?id=<?= $route['route_id'] ?>" class="btn btn-primary">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> No routes found from <?= htmlspecialchars($from) ?> to <?= htmlspecialchars($to) ?>.
                Please try different locations or check back later.
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
