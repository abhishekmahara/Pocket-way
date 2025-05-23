<?php
require_once '../admin/includes/db-config.php';
include '../includes/header.php';

try {
    // Fetch route details
    $stmt = $pdo->prepare("
        SELECT * FROM main_routes 
        WHERE source = 'Haldwani' AND destination = 'Nainital' 
        AND is_active = 1
    ");
    $stmt->execute();
    $route = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$route) {
        throw new Exception("Route not found");
    }

    // Fetch stations with detailed information
    $stmt = $pdo->prepare("
        SELECT rs.*, rf.fare_amount 
        FROM route_stations rs 
        LEFT JOIN route_fares rf ON rs.station_id = rf.from_station_id 
        WHERE rs.route_id = ? 
        ORDER BY rs.sequence_number
    ");
    $stmt->execute([$route['route_id']]);
    $stations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch bus services
    $stmt = $pdo->prepare("SELECT * FROM bus_services WHERE route_id = ?");
    $stmt->execute([$route['route_id']]);
    $buses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch emergency contacts
    $stmt = $pdo->prepare("
        SELECT ec.*, rs.station_name 
        FROM emergency_contacts ec 
        LEFT JOIN route_stations rs ON ec.station_id = rs.station_id 
        WHERE ec.route_id = ?
    ");
    $stmt->execute([$route['route_id']]);
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch media
    $stmt = $pdo->prepare("SELECT * FROM route_media WHERE route_id = ?");
    $stmt->execute([$route['route_id']]);
    $media = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    $error = $e->getMessage();
}
?>

<main class="py-5">
    <div class="container">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
            </div>
        <?php else: ?>
            <!-- Hero Section with Route Overview -->
            <div class="route-hero mb-5">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="display-4 mb-3">Haldwani to Nainital</h1>
                        <p class="lead mb-4"><?= htmlspecialchars($route['route_description']) ?></p>
                        <div class="d-flex flex-wrap gap-3">
                            <div class="route-stat">
                                <i class="fas fa-road"></i>
                                <span>35 km</span>
                            </div>
                            <div class="route-stat">
                                <i class="fas fa-clock"></i>
                                <span>1.5 hours</span>
                            </div>
                            <div class="route-stat">
                                <i class="fas fa-rupee-sign"></i>
                                <span>₹80 - ₹150</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <?php if ($route['route_map_url']): ?>
                            <img src="<?= htmlspecialchars($route['route_map_url']) ?>" 
                                 alt="Route Map" class="img-fluid rounded shadow">
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Quick Navigation -->
            <div class="quick-nav mb-5">
                <div class="row g-3">
                    <div class="col-md-3">
                        <a href="#transport" class="quick-nav-item">
                            <i class="fas fa-bus"></i>
                            <span>Transport Options</span>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="#stations" class="quick-nav-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Route Stations</span>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="#tips" class="quick-nav-item">
                            <i class="fas fa-lightbulb"></i>
                            <span>Travel Tips</span>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="#gallery" class="quick-nav-item">
                            <i class="fas fa-images"></i>
                            <span>Route Gallery</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Transport Options Section -->
            <div id="transport" class="card mb-5">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-bus"></i> Transport Options
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="mb-3">Public Transport</h6>
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <i class="fas fa-bus text-primary"></i>
                                    <strong>Regular Bus Service</strong>
                                    <ul>
                                        <li>Frequency: Every 30 minutes</li>
                                        <li>First Bus: 5:00 AM</li>
                                        <li>Last Bus: 8:00 PM</li>
                                        <li>Fare: ₹80 per person</li>
                                        <li>Duration: ~1.5 hours</li>
                                        <li>Operator: UPSRTC</li>
                                    </ul>
                                </li>
                                <li>
                                    <i class="fas fa-bus text-primary"></i>
                                    <strong>Deluxe Bus Service</strong>
                                    <ul>
                                        <li>Frequency: Every 1 hour</li>
                                        <li>First Bus: 6:00 AM</li>
                                        <li>Last Bus: 7:00 PM</li>
                                        <li>Fare: ₹120 per person</li>
                                        <li>Duration: ~1.5 hours</li>
                                        <li>Operator: UPSRTC</li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="mb-3">Private Transport</h6>
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <i class="fas fa-taxi text-warning"></i>
                                    <strong>Shared Taxi Service</strong>
                                    <ul>
                                        <li>Available from Haldwani Bus Stand</li>
                                        <li>Cost: ₹100 per person</li>
                                        <li>Duration: ~1 hour</li>
                                        <li>Capacity: 4-6 persons</li>
                                        <li>Frequency: When full</li>
                                    </ul>
                                </li>
                                <li>
                                    <i class="fas fa-taxi text-warning"></i>
                                    <strong>Private Taxi</strong>
                                    <ul>
                                        <li>24x7 availability</li>
                                        <li>Cost: ₹800-1000 per trip</li>
                                        <li>Duration: ~1 hour</li>
                                        <li>AC/Non-AC options</li>
                                        <li>Door-to-door service</li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Info Cards -->
            <div class="row mb-5">
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-plane-departure"></i> Nearest Airport
                            </h5>
                            <p class="card-text">
                                <strong>Pantnagar Airport</strong><br>
                                34 km from Haldwani<br>
                                <small class="text-muted">Daily flights from Delhi</small>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-train"></i> Nearest Railway Station
                            </h5>
                            <p class="card-text">
                                <strong>Kathgodam Railway Station</strong><br>
                                5 km from Haldwani<br>
                                <small class="text-muted">Regular trains from Delhi</small>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-mountain"></i> Best Time to Visit
                            </h5>
                            <p class="card-text">
                                <strong>March to June & September to November</strong><br>
                                Avoid monsoon season (July-August)<br>
                                <small class="text-muted">Pleasant weather for sightseeing</small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Route Details -->
            <div class="row">
                <!-- Stations -->
                <div class="col-lg-8">
                    <div id="stations" class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-map-marker-alt"></i> Route Stations & Facilities
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="route-timeline">
                                <?php foreach ($stations as $index => $station): ?>
                                    <div class="timeline-item">
                                        <div class="timeline-marker"></div>
                                        <div class="timeline-content">
                                            <h6><?= htmlspecialchars($station['station_name']) ?></h6>
                                            <div class="station-details">
                                                <?php if ($station['distance_from_prev']): ?>
                                                    <span class="badge bg-info">
                                                        <i class="fas fa-road"></i> 
                                                        <?= htmlspecialchars($station['distance_from_prev']) ?> km from previous
                                                    </span>
                                                <?php endif; ?>
                                                <?php if ($station['facilities']): ?>
                                                    <div class="facilities mt-2">
                                                        <h6 class="text-muted">Available Facilities:</h6>
                                                        <ul class="list-unstyled">
                                                            <?php foreach (explode(',', $station['facilities']) as $facility): ?>
                                                                <li><i class="fas fa-check-circle text-success"></i> <?= trim($facility) ?></li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Travel Tips -->
                    <div id="tips" class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-lightbulb"></i> Travel Tips
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Best Time to Visit</h6>
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-calendar-check text-success"></i> March to June</li>
                                        <li><i class="fas fa-calendar-check text-success"></i> September to November</li>
                                        <li><i class="fas fa-calendar-times text-danger"></i> Avoid monsoon (July-August)</li>
                                        <li><i class="fas fa-sun text-warning"></i> Pleasant weather year-round</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6>What to Pack</h6>
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-tshirt"></i> Light woolens in winter</li>
                                        <li><i class="fas fa-camera"></i> Camera for scenic views</li>
                                        <li><i class="fas fa-umbrella"></i> Umbrella/raincoat</li>
                                        <li><i class="fas fa-prescription-bottle-medical"></i> Basic medicines</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Emergency Contacts -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-phone-alt"></i> Emergency Contacts
                            </h5>
                        </div>
                        <div class="card-body">
                            <?php foreach ($contacts as $contact): ?>
                                <div class="contact-item mb-3">
                                    <h6><?= htmlspecialchars($contact['contact_name']) ?></h6>
                                    <p class="mb-1">
                                        <i class="fas fa-phone"></i> 
                                        <a href="tel:<?= htmlspecialchars($contact['contact_number']) ?>">
                                            <?= htmlspecialchars($contact['contact_number']) ?>
                                        </a>
                                    </p>
                                    <?php if ($contact['station_name']): ?>
                                        <small class="text-muted">
                                            <i class="fas fa-map-marker-alt"></i> 
                                            <?= htmlspecialchars($contact['station_name']) ?>
                                        </small>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Important Notes -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-info-circle"></i> Important Notes
                            </h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success"></i>
                                    Regular bus service available every 30 minutes
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success"></i>
                                    Shared taxis available from bus stand
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success"></i>
                                    Journey takes approximately 1.5 hours
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success"></i>
                                    Carry motion sickness medicine if needed
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success"></i>
                                    Early morning trips recommended for better views
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Route Gallery -->
                    <?php if (!empty($media)): ?>
                        <div id="gallery" class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-images"></i> Route Gallery
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-2">
                                    <?php foreach ($media as $item): ?>
                                        <?php if ($item['media_type'] === 'image'): ?>
                                            <div class="col-6">
                                                <a href="<?= htmlspecialchars($item['file_url']) ?>" 
                                                   data-lightbox="route-gallery" 
                                                   data-title="<?= htmlspecialchars($item['caption']) ?>">
                                                    <img src="<?= htmlspecialchars($item['file_url']) ?>" 
                                                         alt="<?= htmlspecialchars($item['caption']) ?>" 
                                                         class="img-fluid rounded">
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<style>
.route-hero {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 3rem;
    border-radius: 1rem;
    margin-bottom: 2rem;
}

.route-stat {
    background: white;
    padding: 1rem 1.5rem;
    border-radius: 0.5rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.route-stat i {
    color: var(--primary-color);
    font-size: 1.2rem;
}

.quick-nav {
    margin-bottom: 2rem;
}

.quick-nav-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem;
    background: white;
    border-radius: 0.5rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    color: var(--primary-color);
    text-decoration: none;
    transition: all 0.3s ease;
}

.quick-nav-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    color: var(--primary-color);
}

.quick-nav-item i {
    font-size: 1.2rem;
}

.route-timeline {
    position: relative;
    padding: 1rem 0;
}

.timeline-item {
    position: relative;
    padding-left: 2rem;
    margin-bottom: 2rem;
}

.timeline-marker {
    position: absolute;
    left: 0;
    top: 0;
    width: 1rem;
    height: 1rem;
    border-radius: 50%;
    background: var(--primary-color);
    border: 2px solid white;
    box-shadow: 0 0 0 2px var(--primary-color);
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: 0.5rem;
    top: 1rem;
    bottom: -2rem;
    width: 2px;
    background: var(--primary-color);
}

.station-details {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-top: 0.5rem;
}

.contact-item {
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 0.5rem;
}

.contact-item:not(:last-child) {
    margin-bottom: 1rem;
}

.card {
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    border-radius: 1rem;
}

.card-header {
    background: white;
    border-bottom: 1px solid rgba(0,0,0,0.05);
    padding: 1rem 1.5rem;
}

.card-header h5 {
    color: var(--primary-color);
    margin: 0;
}

.card-body {
    padding: 1.5rem;
}

.badge {
    padding: 0.5rem 0.75rem;
    font-weight: 500;
}

.badge i {
    margin-right: 0.25rem;
}

.facilities ul li {
    margin-bottom: 0.5rem;
}

.facilities i {
    margin-right: 0.5rem;
}

@media (max-width: 768px) {
    .route-hero {
        padding: 2rem;
    }
    
    .route-stat {
        width: 100%;
    }

    .quick-nav-item {
        flex-direction: column;
        text-align: center;
    }
}
</style>

<?php include '../includes/footer.php'; ?>
