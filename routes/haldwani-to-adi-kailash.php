<?php
require_once '../admin/includes/db-config.php';
include '../includes/header.php';

try {
    // Fetch route details
    $stmt = $pdo->prepare("
        SELECT * FROM main_routes 
        WHERE source = 'Haldwani' AND destination = 'Adi Kailash' 
        AND is_active = 1
    ");
    $stmt->execute();
    $route = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$route) {
        throw new Exception("Route not found");
    }

    // First get the source station ID
    $stmt = $pdo->prepare("
        SELECT station_id 
        FROM route_stations 
        WHERE route_id = ? 
        AND sequence_number = 1
    ");
    $stmt->execute([$route['route_id']]);
    $source_station = $stmt->fetch(PDO::FETCH_ASSOC);
    $source_station_id = $source_station['station_id'];

    // Fetch stations with detailed information
    $stmt = $pdo->prepare("
        SELECT 
            rs.*,
            (
                SELECT fare_amount 
                FROM route_fares 
                WHERE route_id = rs.route_id 
                AND from_station_id = ? 
                AND to_station_id = rs.station_id
                LIMIT 1
            ) as fare_from_source
        FROM route_stations rs 
        WHERE rs.route_id = ? 
        ORDER BY rs.sequence_number
    ");
    $stmt->execute([$source_station_id, $route['route_id']]);
    $stations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Debug information
    error_log("Source Station ID: " . $source_station_id);
    error_log("Number of stations: " . count($stations));
    foreach ($stations as $station) {
        error_log("Station: " . $station['station_name'] . ", Fare: " . ($station['fare_from_source'] ?? 'null'));
    }

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
                        <h1 class="display-4 mb-3">Haldwani to Adi Kailash</h1>
                        <p class="lead mb-4"><?= htmlspecialchars($route['route_description']) ?></p>
                        <div class="d-flex flex-wrap gap-3">
                            <div class="route-stat">
                                <i class="fas fa-road"></i>
                                <span><?= htmlspecialchars($route['total_distance']) ?> km</span>
                            </div>
                            <div class="route-stat">
                                <i class="fas fa-clock"></i>
                                <span><?= htmlspecialchars($route['total_time']) ?></span>
                            </div>
                            <div class="route-stat">
                                <i class="fas fa-rupee-sign"></i>
                                <span>₹<?= htmlspecialchars($route['total_fare']) ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <?php if ($route['route_map_url']): ?>
                            <?php
                            // Ensure the path starts with /Pocket-way/
                            $image_path = $route['route_map_url'];
                            if (!str_starts_with($image_path, '/Pocket-way/')) {
                                $image_path = '/Pocket-way/' . ltrim($image_path, '/');
                            }
                            ?>
                            <img src="<?= htmlspecialchars($image_path) ?>" 
                                 alt="Route Map" 
                                 class="img-fluid rounded shadow"
                                 onerror="console.log('Failed to load: <?= htmlspecialchars($image_path) ?>')">
                        <?php else: ?>
                            <div class="alert alert-info">
                                No route map available
                            </div>
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
                            <h6 class="mb-3">Public Transport (Haldwani to Dharchula)</h6>
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <i class="fas fa-bus text-primary"></i>
                                    <strong>Regular Bus Service</strong>
                                    <ul>
                                        <li>Departure: 5:30 AM from Haldwani</li>
                                        <li>Arrival: 4:45 PM at Dharchula</li>
                                        <li>Fare: ₹1,045 per person</li>
                                        <li>Duration: ~11 hours</li>
                                        <li>Frequency: Daily</li>
                                        <li>Operator: KMOU</li>
                                    </ul>
                                </li>
                                <li>
                                    <i class="fas fa-bus text-primary"></i>
                                    <strong>Express Bus Service</strong>
                                    <ul>
                                        <li>Departure: 6:00 AM from Haldwani</li>
                                        <li>Arrival: 5:00 PM at Dharchula</li>
                                        <li>Fare: ₹1,200 per person</li>
                                        <li>Duration: ~11 hours</li>
                                        <li>Frequency: Daily</li>
                                        <li>Operator: KMOU</li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="mb-3">Shared Taxi (Dharchula to Adi Kailash)</h6>
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <i class="fas fa-taxi text-warning"></i>
                                    <strong>Shared Taxi Service</strong>
                                    <ul>
                                        <li>Cost: ₹15,000 per person (round trip)</li>
                                        <li>Duration: ~4 hours one way</li>
                                        <li>Capacity: 4-6 persons per vehicle</li>
                                        <li>Includes: Driver, fuel, and permits</li>
                                        <li>Best to book in advance</li>
                                        <li>Weather dependent service</li>
                                    </ul>
                                </li>
                                <li>
                                    <i class="fas fa-info-circle text-info"></i>
                                    <strong>Important Notes</strong>
                                    <ul>
                                        <li>Advance booking recommended</li>
                                        <li>Weather dependent service</li>
                                        <li>Inner Line Permit required</li>
                                        <li>Best to travel in groups</li>
                                        <li>Mobile network available only till Dharchula</li>
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
                                <small class="text-muted">Direct trains from Delhi</small>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-id-card"></i> Required Permits
                            </h5>
                            <p class="card-text">
                                <strong>Inner Line Permit</strong><br>
                                Available at SDM Office, Dharchula<br>
                                Fee: ₹150 per person<br>
                                <small class="text-muted">Valid for 15 days</small>
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
                                                <?php if ($station['arrival_time']): ?>
                                                    <span class="badge bg-primary">
                                                        <i class="fas fa-clock"></i> 
                                                        Arrival: <?= htmlspecialchars($station['arrival_time']) ?>
                                                    </span>
                                                <?php endif; ?>
                                                <?php if ($station['departure_time']): ?>
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-clock"></i> 
                                                        Departure: <?= htmlspecialchars($station['departure_time']) ?>
                                                    </span>
                                                <?php endif; ?>
                                                <?php if ($station['fare_from_source'] && $station['sequence_number'] > 1): ?>
                                                    <span class="badge bg-warning">
                                                        <i class="fas fa-rupee-sign"></i> 
                                                        Fare from Haldwani: ₹<?= number_format($station['fare_from_source'], 2) ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
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
                                            <?php if ($station['latitude'] && $station['longitude']): ?>
                                                <a href="https://www.google.com/maps?q=<?= $station['latitude'] ?>,<?= $station['longitude'] ?>" 
                                                   target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                                                    <i class="fas fa-map-marker-alt"></i> View on Map
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
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
                                    Book tickets in advance during peak season
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success"></i>
                                    Weather conditions can affect travel times
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success"></i>
                                    Carry warm clothes and proper trekking gear
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success"></i>
                                    Inner Line Permit required for Adi Kailash
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success"></i>
                                    Shared taxi booking recommended in advance
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success"></i>
                                    Mobile network available only till Dharchula
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Travel Tips & Best Time to Visit -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-calendar-alt"></i> Best Time to Visit
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="season-info mb-4">
                                <h6 class="text-primary mb-3">Recommended Seasons</h6>
                                <div class="season-item mb-3">
                                    <div class="season-header">
                                        <i class="fas fa-sun text-warning"></i>
                                        <span class="ms-2">May to June</span>
                                    </div>
                                    <p class="text-muted small mt-2 mb-0">
                                        Perfect weather for trekking and sightseeing
                                    </p>
                                </div>
                                <div class="season-item mb-3">
                                    <div class="season-header">
                                        <i class="fas fa-cloud-sun text-info"></i>
                                        <span class="ms-2">September to October</span>
                                    </div>
                                    <p class="text-muted small mt-2 mb-0">
                                        Clear skies and comfortable temperatures
                                    </p>
                                </div>
                            </div>

                            <div class="season-info">
                                <h6 class="text-primary mb-3">Seasons to Avoid</h6>
                                <div class="season-item mb-3">
                                    <div class="season-header">
                                        <i class="fas fa-cloud-rain text-danger"></i>
                                        <span class="ms-2">Monsoon (July-August)</span>
                                    </div>
                                    <p class="text-muted small mt-2 mb-0">
                                        Heavy rainfall and landslides
                                    </p>
                                </div>
                                <div class="season-item">
                                    <div class="season-header">
                                        <i class="fas fa-snowflake text-info"></i>
                                        <span class="ms-2">Winter (November-April)</span>
                                    </div>
                                    <p class="text-muted small mt-2 mb-0">
                                        Extreme cold and snow conditions
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Travel Tips -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-lightbulb"></i> Travel Tips
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="travel-tips">
                                <div class="tip-category mb-4">
                                    <h6 class="text-primary mb-3">Planning Tips</h6>
                                    <div class="tip-item mb-3">
                                        <div class="tip-header">
                                            <i class="fas fa-calendar-check text-success"></i>
                                            <span class="ms-2">Advance Booking</span>
                                        </div>
                                        <p class="text-muted small mt-2 mb-0">
                                            Book your bus tickets and shared taxi at least 2-3 days in advance, especially during peak season
                                        </p>
                                    </div>
                                    <div class="tip-item mb-3">
                                        <div class="tip-header">
                                            <i class="fas fa-id-card text-primary"></i>
                                            <span class="ms-2">Permit Preparation</span>
                                        </div>
                                        <p class="text-muted small mt-2 mb-0">
                                            Apply for Inner Line Permit at SDM Office, Dharchula before 2 PM to ensure same-day processing
                                        </p>
                                    </div>
                                </div>

                                <div class="tip-category mb-4">
                                    <h6 class="text-primary mb-3">During Travel</h6>
                                    <div class="tip-item mb-3">
                                        <div class="tip-header">
                                            <i class="fas fa-clock text-warning"></i>
                                            <span class="ms-2">Timing</span>
                                        </div>
                                        <p class="text-muted small mt-2 mb-0">
                                            Start your journey early morning to avoid traffic and reach Dharchula before sunset
                                        </p>
                                    </div>
                                    <div class="tip-item mb-3">
                                        <div class="tip-header">
                                            <i class="fas fa-mobile-alt text-info"></i>
                                            <span class="ms-2">Connectivity</span>
                                        </div>
                                        <p class="text-muted small mt-2 mb-0">
                                            Download offline maps and save important contacts as network is limited beyond Dharchula
                                        </p>
                                    </div>
                                </div>

                                <div class="tip-category">
                                    <h6 class="text-primary mb-3">Safety Tips</h6>
                                    <div class="tip-item mb-3">
                                        <div class="tip-header">
                                            <i class="fas fa-users text-success"></i>
                                            <span class="ms-2">Group Travel</span>
                                        </div>
                                        <p class="text-muted small mt-2 mb-0">
                                            Travel in groups of 4-6 people for shared taxi to reduce costs and ensure safety
                                        </p>
                                    </div>
                                    <div class="tip-item mb-3">
                                        <div class="tip-header">
                                            <i class="fas fa-cloud-sun text-warning"></i>
                                            <span class="ms-2">Weather Check</span>
                                        </div>
                                        <p class="text-muted small mt-2 mb-0">
                                            Check weather forecast before starting journey and be prepared for sudden changes
                                        </p>
                                    </div>
                                    <div class="tip-item">
                                        <div class="tip-header">
                                            <i class="fas fa-first-aid text-danger"></i>
                                            <span class="ms-2">Health Precautions</span>
                                        </div>
                                        <p class="text-muted small mt-2 mb-0">
                                            Carry altitude sickness medicine and stay hydrated throughout the journey
                                        </p>
                                    </div>
                                </div>
                            </div>
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
    :root {
    --primary-color: #006366;
    --secondary-color: #008B8B;
        --accent-color: #F9A825;
    --accent-hover: #FFB74D;
    --light-bg: #E0F7FA;
    --dark-bg: #004D4D;
    --text-light: #ffffff;
    --text-dark: #333333;
    --border-radius: 1rem;
    --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    --transition: all 0.3s ease;
}

.route-hero {
    background: linear-gradient(135deg, #006366, #4db6ac);

    padding: 4rem 3rem;
    border-radius: var(--border-radius);
    margin-bottom: 3rem;
    color: var(--text-light);
    position: relative;
    overflow: hidden;
}

.route-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('/Pocket-way/assets/images/pattern.png') repeat;
    opacity: 0.1;
}

.route-hero h1 {
    font-weight: 700;
    margin-bottom: 1.5rem;
    position: relative;
}

.route-hero .lead {
    font-size: 1.2rem;
    opacity: 0.9;
    margin-bottom: 2rem;
    position: relative;
}

.route-stat {
    background: rgba(255, 255, 255, 0.1);
    padding: 1.2rem 1.8rem;
    border-radius: var(--border-radius);
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: var(--transition);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.route-stat:hover {
    transform: translateY(-3px);
    background: rgba(255, 255, 255, 0.15);
    border-color: var(--accent-color);
}

.route-stat i {
    color: var(--accent-color);
    font-size: 1.5rem;
}

.route-stat span {
    font-size: 1.1rem;
    font-weight: 500;
}

.quick-nav {
    margin: 3rem 0;
}

.quick-nav-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    background: linear-gradient(135deg, white 0%, var(--light-bg) 100%);
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    color: var(--primary-color);
    text-decoration: none;
    transition: var(--transition);
    border: 1px solid rgba(0, 99, 102, 0.1);
    height: 100%;
}

.quick-nav-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    color: var(--secondary-color);
    background: linear-gradient(135deg, var(--light-bg) 0%, white 100%);
    border-color: var(--accent-color);
}

.quick-nav-item i {
    font-size: 1.8rem;
    color: var(--primary-color);
}

.card {
    border: none;
    box-shadow: var(--box-shadow);
    border-radius: var(--border-radius);
    transition: var(--transition);
    margin-bottom: 2rem;
    overflow: hidden;
}

.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
}

.card-header {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    color: var(--text-light);
    padding: 1.2rem 1.5rem;
    border-bottom: none;
}

.card-header h5 {
    color: var(--text-light);
    margin: 0;
    font-weight: 600;
}

.card-header h5 i {
    margin-right: 0.5rem;
}

.card-body {
    padding: 2rem;
}

.route-timeline {
    position: relative;
    padding: 2rem 0;
}

.timeline-item {
    position: relative;
    padding: 2rem;
    margin-bottom: 3rem;
    background: linear-gradient(to right, white, var(--light-bg));
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    border-left: 4px solid var(--accent-color);
    transition: var(--transition);
}

.timeline-item:hover {
    transform: translateX(10px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    border-left-color: var(--primary-color);
}

.timeline-marker {
    position: absolute;
    left: -0.7rem;
    top: 2rem;
    width: 1.2rem;
    height: 1.2rem;
    border-radius: 50%;
    background: var(--accent-color);
    border: 3px solid var(--accent-color);
    box-shadow: 0 0 0 3px var(--accent-color);
    z-index: 2;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: 0.3rem;
    top: 4rem;
    bottom: -3rem;
    width: 2px;
    background: var(--accent-color);
    opacity: 0.5;
}

.timeline-content {
    position: relative;
}

.timeline-content h6 {
    color: var(--primary-color);
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--light-bg);
}

.station-details {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin: 1rem 0;
}

.badge {
    padding: 0.6rem 1rem;
    font-weight: 500;
    border-radius: .5rem;
    font-size: 0.9rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: var(--transition);
    background: linear-gradient(65deg,#F9A825 ,rgb(207, 185, 17) );
    color: white;
    border:none;
}


.badge i {
    font-size: 1rem;
    color: var(--primary-color);
}

.badge:hover i {
    color: white;
}

.facilities {
    background: var(--light-bg);
    padding: 1.5rem;
    border-radius: var(--border-radius);
    margin-top: 1rem;
    border: 1px solid rgba(0, 99, 102, 0.1);
}

.facilities h6 {
    color: var(--primary-color);
    font-size: 1rem;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.facilities h6 i {
    color: var(--accent-color);
}

.facilities ul {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin: 0;
    padding: 0;
}

.facilities ul li {
    list-style: none;
    display: flex;
    align-items: center;
    gap: 0.8rem;
    padding: 0.5rem 1rem;
    background: white;
    border-radius: 0.5rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    transition: var(--transition);
    border: 1px solid rgba(0, 99, 102, 0.1);
}

.facilities ul li:hover {
    transform: translateX(5px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-color: var(--accent-color);
    background: var(--light-bg);
}

.facilities ul li i {
    color: var(--accent-color);
    font-size: 1.1rem;
}

.contact-item {
    padding: 1.5rem;
    background: linear-gradient(135deg, var(--light-bg) 0%, white 100%);
    border-radius: var(--border-radius);
    transition: var(--transition);
    border: 1px solid rgba(0, 99, 102, 0.1);
}

.contact-item:hover {
    transform: translateY(-3px);
    box-shadow: var(--box-shadow);
    border-color: var(--accent-color);
}

.contact-item h6 {
    color: var(--primary-color);
    font-weight: 600;
    margin-bottom: 0.8rem;
}

.contact-item a {
    color: var(--primary-color);
    text-decoration: none;
    transition: var(--transition);
}

.contact-item a:hover {
    color: var(--accent-color);
}

/* Gallery Section */
#gallery .card-body {
    padding: 1.5rem;
}

#gallery .row {
    margin: -0.5rem;
}

#gallery .col-6 {
    padding: 0.5rem;
}

#gallery img {
    border-radius: var(--border-radius);
    transition: var(--transition);
    cursor: pointer;
}

#gallery img:hover {
    transform: scale(1.05);
    border: 2px solid var(--accent-color);
}

/* Responsive Design */
@media (max-width: 768px) {
    .route-hero {
        padding: 2rem;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    }
    
    .route-stat {
        width: 100%;
        margin-bottom: 1rem;
    }

    .quick-nav-item {
        flex-direction: column;
        text-align: center;
        padding: 1rem;
    }

    .timeline-item {
        padding: 1.5rem;
        margin-left: 1rem;
        background: white;
    }
    
    .timeline-marker {
        left: -0.5rem;
    }

    .facilities ul {
        grid-template-columns: 1fr;
    }
}

/* Animation Classes */
.fade-in {
    animation: fadeIn 0.5s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Add animation for station items */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.timeline-item {
    animation: slideIn 0.5s ease-out forwards;
}

.timeline-item:nth-child(2) { animation-delay: 0.1s; }
.timeline-item:nth-child(3) { animation-delay: 0.2s; }
.timeline-item:nth-child(4) { animation-delay: 0.3s; }
.timeline-item:nth-child(5) { animation-delay: 0.4s; }

/* Update button styles */
.btn-primary {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.btn-primary:hover {
    background-color: var(--secondary-color);
    border-color: var(--secondary-color);
}

.btn-outline-primary {
    color: var(--primary-color);
    border-color: var(--primary-color);
}

.btn-outline-primary:hover {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
}

/* Add accent color to important elements */
.important-note {
    border-left: 4px solid var(--accent-color);
    background: var(--light-bg);
    padding: 1rem;
    border-radius: 0.5rem;
    margin: 1rem 0;
}

.important-note i {
    color: var(--accent-color);
}

/* Add subtle animations */
@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(249, 168, 37, 0.4); }
    70% { box-shadow: 0 0 0 10px rgba(249, 168, 37, 0); }
    100% { box-shadow: 0 0 0 0 rgba(249, 168, 37, 0); }
}

.timeline-marker {
    animation: pulse 2s infinite;
}

/* Add these new styles */
.season-info {
    background: var(--light-bg);
    padding: 1.5rem;
    border-radius: var(--border-radius);
    border: 1px solid rgba(0, 99, 102, 0.1);
}

.season-item {
    background: white;
    padding: 1rem;
    border-radius: 0.5rem;
    transition: var(--transition);
    border: 1px solid rgba(0, 99, 102, 0.1);
}

.season-item:hover {
    transform: translateX(5px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-color: var(--accent-color);
}

.season-header {
    display: flex;
    align-items: center;
    font-weight: 600;
        color: var(--primary-color);
}

.season-header i {
    font-size: 1.2rem;
}

/* Update existing styles */
.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
}

.card-header {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    color: var(--text-light);
    padding: 1.2rem 1.5rem;
    border-bottom: none;
}

.card-header h5 {
    margin: 0;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.card-header h5 i {
    color: var(--accent-color);
}

.card-body {
    padding: 1.5rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .season-info {
        padding: 1rem;
    }
    
    .season-item {
        padding: 0.8rem;
    }
}

/* Add these new styles for packing list */
.packing-list {
    background: var(--light-bg);
    padding: 1.5rem;
    border-radius: var(--border-radius);
    border: 1px solid rgba(0, 99, 102, 0.1);
}

.packing-category {
    background: white;
    padding: 1.5rem;
    border-radius: var(--border-radius);
    border: 1px solid rgba(0, 99, 102, 0.1);
}

.packing-item {
    background: var(--light-bg);
    padding: 1rem;
    border-radius: 0.5rem;
    transition: var(--transition);
    border: 1px solid rgba(0, 99, 102, 0.1);
    margin-bottom: 1rem;
}

.packing-item:hover {
    transform: translateX(5px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-color: var(--accent-color);
}

.packing-header {
    display: flex;
    align-items: center;
    font-weight: 600;
    color: var(--primary-color);
}

.packing-header i {
    font-size: 1.2rem;
}

/* Update styles for travel tips */
.travel-tips {
    background: var(--light-bg);
    padding: 1.5rem;
    border-radius: var(--border-radius);
    border: 1px solid rgba(0, 99, 102, 0.1);
}

.tip-category {
    background: white;
    padding: 1.5rem;
    border-radius: var(--border-radius);
    border: 1px solid rgba(0, 99, 102, 0.1);
}

.tip-item {
    background: var(--light-bg);
    padding: 1rem;
    border-radius: 0.5rem;
    transition: var(--transition);
    border: 1px solid rgba(0, 99, 102, 0.1);
    margin-bottom: 1rem;
}

.tip-item:hover {
    transform: translateX(5px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-color: var(--accent-color);
}

.tip-header {
    display: flex;
    align-items: center;
    font-weight: 600;
    color: var(--primary-color);
}

.tip-header i {
    font-size: 1.2rem;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add fade-in animation to cards
    document.querySelectorAll('.card').forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
        card.classList.add('fade-in');
    });

    // Add intersection observer for timeline items
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateX(0)';
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.timeline-item').forEach(item => {
        observer.observe(item);
    });
});
</script>

<?php include '../includes/footer.php'; ?>