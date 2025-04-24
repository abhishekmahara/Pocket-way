<?php

$servername = "localhost"; // usually localhost for local dev
$username = "root";        // default for XAMPP/WAMP/MAMP
$password = "";            // often empty in local setup
$dbname = "travelwebsite"; // replace with your actual DB name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$source = 'Dehradun';
$destination = 'Kedarnath';

$sql = "SELECT b.bus_name, b.bus_type, b.fare, b.departure_time
        FROM routes r
        JOIN buses b ON r.bus_id = b.id
        JOIN locations l1 ON r.source_id = l1.id
        JOIN locations l2 ON r.destination_id = l2.id
        WHERE l1.name = ? AND l2.name = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $source, $destination);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Available Buses - PocketWay</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9f9f9;
            padding: 40px;
        }
        h2 {
            text-align: center;
            color: teal;
            margin-bottom: 30px;
        }
        table {
            border-collapse: collapse;
            margin: 0 auto;
            width: 80%;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            background-color: #fff;
        }
        th, td {
            padding: 14px 18px;
            text-align: center;
        }
        th {
            background-color: teal;
            color: white;
            text-transform: uppercase;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e0f7fa;
        }
        .no-data {
            text-align: center;
            color: gray;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<h2>Available Buses from <?php echo $source; ?> to <?php echo $destination; ?></h2>

<?php
if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>Bus Name</th>
                <th>Type</th>
                <th>Fare (₹)</th>
                <th>Departure Time</th>
            </tr>";
    
    while ($row = $result->fetch_assoc()) {
        // Convert 24-hour to 12-hour format with AM/PM
        $time = date("g:i A", strtotime($row['departure_time']));
        echo "<tr>
                <td>{$row['bus_name']}</td>
                <td>{$row['bus_type']}</td>
                <td>{$row['fare']}</td>
                <td>$time</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p class='no-data'>No buses found for this route.</p>";
}
?>

</body>
</html>
