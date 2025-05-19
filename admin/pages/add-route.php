<?php
// Connect to database
$conn = new mysqli("localhost", "root", "", "pocket_way");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Sanitize & get main route data
  $source = $conn->real_escape_string($_POST['source']);
  $destination = $conn->real_escape_string($_POST['destination']);
  $total_distance = $conn->real_escape_string($_POST['total_distance']);
  $total_time = $conn->real_escape_string($_POST['total_time']);
  $route_map_url = $conn->real_escape_string($_POST['route_map_url']);
  $route_description = $conn->real_escape_string($_POST['route_description']);

  // Insert main route
  $sql_route = "INSERT INTO main_routes (source, destination, total_distance, total_time, route_map_url, route_description, created_at)
                VALUES ('$source', '$destination', '$total_distance', '$total_time', '$route_map_url', '$route_description', NOW())";

  if ($conn->query($sql_route) === TRUE) {
    $route_id = $conn->insert_id;

    // Insert stations
    if (isset($_POST['station_name']) && is_array($_POST['station_name'])) {
      $stations = $_POST['station_name'];
      $distances = $_POST['distance_from_prev'];
      $arrival_times = $_POST['arrival_time'];
      $departure_times = $_POST['departure_time'];
      $latitudes = $_POST['latitude'];
      $longitudes = $_POST['longitude'];
      $facilities = $_POST['facilities'];

      for ($i = 0; $i < count($stations); $i++) {
        $station = $conn->real_escape_string($stations[$i]);
        $distance = $conn->real_escape_string($distances[$i] ?? '');
        $arrival = $conn->real_escape_string($arrival_times[$i] ?? '');
        $departure = $conn->real_escape_string($departure_times[$i] ?? '');
        $lat = $conn->real_escape_string($latitudes[$i] ?? '');
        $lon = $conn->real_escape_string($longitudes[$i] ?? '');
        $facility = $conn->real_escape_string($facilities[$i] ?? '');

        if (!empty($station)) { // Avoid empty stations
          $sql_station = "INSERT INTO route_stations (route_id, station_name, distance_from_prev, arrival_time, departure_time, latitude, longitude, facilities)
                          VALUES ($route_id, '$station', '$distance', '$arrival', '$departure', '$lat', '$lon', '$facility')";
          $conn->query($sql_station);
        }
      }
    }

    // Insert fares
    if (isset($_POST['from_station']) && is_array($_POST['from_station'])) {
      $from_stations = $_POST['from_station'];
      $to_stations = $_POST['to_station'];
      $fares = $_POST['fare'];

      for ($i = 0; $i < count($from_stations); $i++) {
        $from = $conn->real_escape_string($from_stations[$i]);
        $to = $conn->real_escape_string($to_stations[$i]);
        $fare = $conn->real_escape_string($fares[$i]);

        if (!empty($from) && !empty($to)) {
          $sql_fare = "INSERT INTO route_fares (route_id, from_station, to_station, fare_amount)
                       VALUES ($route_id, '$from', '$to', '$fare')";
          $conn->query($sql_fare);
        }
      }
    }

    // Insert bus services (optional)
    $bus_number = $conn->real_escape_string($_POST['bus_number'] ?? '');
    $bus_type = $conn->real_escape_string($_POST['bus_type'] ?? '');
    $seating_capacity = intval($_POST['seating_capacity'] ?? 0);
    $departure_time_bus = $conn->real_escape_string($_POST['departure_time'] ?? '');
    $arrival_time_bus = $conn->real_escape_string($_POST['arrival_time'] ?? '');
    $operating_days = $conn->real_escape_string($_POST['operating_days'] ?? '');

    if ($bus_number || $bus_type || $seating_capacity || $departure_time_bus || $arrival_time_bus || $operating_days) {
      $sql_bus = "INSERT INTO bus_services (route_id, bus_number, bus_type, seating_capacity, departure_time, arrival_time, operating_days)
                  VALUES ($route_id, '$bus_number', '$bus_type', $seating_capacity, '$departure_time_bus', '$arrival_time_bus', '$operating_days')";
      $conn->query($sql_bus);
    }

    // TODO: Add media upload handling here if needed

    $message = "Route saved successfully!";
  } else {
    $message = "Error saving route: " . $conn->error;
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add New Route - Pocket Way</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
      background: #f4f9ff;
    }
    h2 {
      color: #333;
    }
    form {
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      margin-bottom: 30px;
    }
    input, textarea, select {
      padding: 8px;
      margin: 5px 0;
      width: 100%;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    .section {
      margin-bottom: 20px;
    }
    .station-row {
      display: flex;
      gap: 10px;
      margin-bottom: 10px;
    }
    .station-row input {
      flex: 1;
    }
    button {
      padding: 8px 12px;
      background: #007BFF;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .remove-btn {
      background: #dc3545;
    }
    .route-card {
      background: #fff;
      border: 1px solid #ccc;
      border-radius: 8px;
      padding: 15px;
      margin-bottom: 10px;
    }
    .message {
      padding: 10px;
      margin-bottom: 20px;
      border-radius: 5px;
    }
    .success {
      background: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }
    .error {
      background: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }
  </style>
</head>
<body>

<h2>Add New Route</h2>

<?php if ($message): ?>
  <div class="message <?= strpos($message, 'successfully') !== false ? 'success' : 'error' ?>">
    <?= htmlspecialchars($message) ?>
  </div>
<?php endif; ?>

<form action="" method="POST" enctype="multipart/form-data">

  <div class="section">
    <h3>Route Details</h3>
    <input type="text" name="source" placeholder="Source" required>
    <input type="text" name="destination" placeholder="Destination" required>
    <input type="text" name="total_distance" placeholder="Total Distance (km)" required>
    <input type="text" name="total_time" placeholder="Total Time (e.g. 5h 30m)" required>
    <input type="text" name="route_map_url" placeholder="Route Map URL">
    <textarea name="route_description" placeholder="Route Description"></textarea>
  </div>

  <div class="section">
    <h3>Stations</h3>
    <div id="stations"></div>
    <button type="button" onclick="addStationRow()">+ Add Station</button>
  </div>

  <div class="section">
    <h3>Fares</h3>
    <div id="fares"></div>
    <button type="button" onclick="addFareRow()">+ Add Fare</button>
  </div>

  <div class="section">
    <h3>Bus Services (Optional)</h3>
    <input type="text" name="bus_number" placeholder="Bus Number">
    <select name="bus_type">
      <option value="">Select Bus Type</option>
      <option value="Local">Local</option>
      <option value="Express">Express</option>
      <option value="Deluxe">Deluxe</option>
    </select>
    <input type="number" name="seating_capacity" placeholder="Seating Capacity">
    <input type="time" name="departure_time" placeholder="Departure Time">
    <input type="time" name="arrival_time" placeholder="Arrival Time">
    <input type="text" name="operating_days" placeholder="Operating Days (e.g. Mon-Fri)">
  </div>

  <div class="section">
    <h3>Route Media (Optional)</h3>
    <input type="file" name="media[]" multiple>
    <textarea name="caption" placeholder="Caption for uploaded media"></textarea>
  </div>

  <button type="submit">Save Route</button>
</form>

<h2>Existing Routes</h2>

<?php
$result = $conn->query("SELECT * FROM main_routes ORDER BY created_at DESC");
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo "<div class='route-card'>";
    echo "<h3>" . htmlspecialchars($row['source']) . " → " . htmlspecialchars($row['destination']) . "</h3>";
    echo "<p><strong>Distance:</strong> " . htmlspecialchars($row['total_distance']) . " km</p>";
    echo "<p><strong>Time:</strong> " . htmlspecialchars($row['total_time']) . "</p>";
    echo "<p><strong>Description:</strong> " . nl2br(htmlspecialchars($row['route_description'])) . "</p>";
    echo "</div>";
  }
} else {
  echo "<p>No routes found.</p>";
}

$conn->close();
?>

<script>
  function addStationRow() {
    const container = document.getElementById('stations');
    const row = document.createElement('div');
    row.className = 'station-row';
    row.innerHTML = `
      <input name="station_name[]" placeholder="Station Name" required>
      <input name="distance_from_prev[]" placeholder="Distance from Previous (km)">
      <input name="arrival_time[]" type="time" placeholder="Arrival Time">
      <input name="departure_time[]" type="time" placeholder="Departure Time">
      <input name="latitude[]" placeholder="Latitude">
      <input name="longitude[]" placeholder="Longitude">
      <input name="facilities[]" placeholder="Facilities">
      <button type="button" class="remove-btn" onclick="this.parentNode.remove()">Remove</button>
    `;
    container.appendChild(row);
  }

  function addFareRow() {
    const container = document.getElementById('fares');
    const row = document.createElement('div');
    row.className = 'station-row';
    row.innerHTML = `
      <input name="from_station[]" placeholder="From Station">
      <input name="to_station[]" placeholder="To Station">
      <input name="fare[]" placeholder="Fare Amount">
      <button type="button" class="remove-btn" onclick="this.parentNode.remove()">Remove</button>
    `;
    container.appendChild(row);
  }
</script>

</body>
</html>
