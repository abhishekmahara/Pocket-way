<?php include '../includes/header.php'; ?>

<style>
    :root {
        --primary-color: #007B7F;
        --accent-color: #F9A825;
        --background-color: #F4F6F8;
        --text-color: #212529;
        --secondary-text: #6c757d;
    }

    .route-container {
        max-width: 1000px;
        margin: 40px auto;
        padding: 20px;
    }

    .route-header {
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
                    url('https://images.unsplash.com/photo-1626621341517-bbf3d9990a23');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 60px 20px;
        border-radius: 15px;
        margin-bottom: 30px;
        text-align: center;
    }

    .route-info {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .station-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    .station-card::before {
        content: '';
        position: absolute;
        left: -30px;
        top: 50%;
        width: 20px;
        height: 20px;
        background: var(--primary-color);
        border-radius: 50%;
        transform: translateY(-50%);
    }

    .station-card::after {
        content: '';
        position: absolute;
        left: -25px;
        top: 100%;
        width: 10px;
        height: calc(100% + 20px);
        background: var(--primary-color);
        transform: translateY(-50%);
    }

    .station-card:last-child::after {
        display: none;
    }

    .timing-chip {
        display: inline-block;
        background: #e3f2fd;
        padding: 5px 15px;
        border-radius: 20px;
        margin: 5px;
        font-size: 0.9rem;
        color: var(--primary-color);
    }

    .info-badge {
        background: var(--accent-color);
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        margin-right: 10px;
    }
</style>

<div class="route-container">
    <div class="route-header">
        <h1>Haldwani to Adi Kailash</h1>
        <p class="mb-2">Total Distance: 472 km</p>
        <p>Estimated Total Fare: ₹5,000</p>
    </div>

    <div class="route-info">
        <h4 class="text-primary mb-3">Route Overview</h4>
        <p>This scenic route takes you through some of the most beautiful landscapes of Uttarakhand, 
           from the foothills of Haldwani to the sacred Adi Kailash. The journey covers multiple stops 
           with regular bus services throughout the day.</p>
    </div>

    <?php
    // Read and decode JSON file
    $jsonData = file_get_contents('../assets/routes-db/haldwani-to-adi-kailash.json');
    $routeData = json_decode($jsonData, true);

    foreach ($routeData['stations'] as $station) {
        echo '<div class="station-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">' . $station['station'] . '</h4>
                    <div>
                        <span class="info-badge">₹' . $station['approx_fare_inr'] . '</span>
                        <span class="info-badge">' . $station['distance_from_previous_km'] . ' km</span>
                    </div>
                </div>
                <div class="timings mt-3">
                    <p class="mb-2">Bus Timings:</p>';
        
        foreach ($station['bus_timings'] as $timing) {
            echo '<span class="timing-chip">' . $timing . '</span>';
        }
        
        echo '</div>
             </div>';
    }
    ?>

    <div class="route-info mt-4">
        <h4 class="text-primary mb-3">Important Notes</h4>
        <ul>
            <li>Book tickets in advance during peak season (May-June, September-October)</li>
            <li>Weather conditions can affect travel times, especially in higher altitudes</li>
            <li>Carry warm clothes as temperatures can drop significantly at higher altitudes</li>
            <li>Some routes might require permits - check with local authorities</li>
        </ul>
    </div>
</div>

<?php include '../includes/footer.php'; ?>