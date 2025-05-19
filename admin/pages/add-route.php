<?php
session_start();
require_once '../includes/auth-check.php';
require_once '../db-config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Route - PocketWay Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            background-color: #f4f6f8;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 1000px;
            margin: 30px auto;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #007B7F;
            text-align: center;
        }
        label {
            font-weight: bold;
        }
        input[type="text"], input[type="number"], input[type="time"], input[type="file"], textarea, select {
            width: 100%;
            padding: 10px;
            margin: 8px 0 16px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .section-title {
            background-color: #007B7F;
            color: white;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        .btn {
            background-color: #F9A825;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #e69500;
        }
    </style>
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="container">
    <h2>Add New Route</h2>
    <form action="add-route-process.php" method="POST" enctype="multipart/form-data">
        <div class="section-title">Basic Route Details</div>
        <label for="source">Source:</label>
        <input type="text" name="source" required>

        <label for="destination">Destination:</label>
        <input type="text" name="destination" required>

        <label for="distance">Total Distance (in km):</label>
        <input type="number" name="distance" required>

        <label for="duration">Estimated Duration:</label>
        <input type="text" name="duration" required>

        <label for="description">Route Description:</label>
        <textarea name="description" rows="5" required></textarea>

        <label for="status">Route Status:</label>
        <select name="status">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>

        <label for="map_image">Route Map Image:</label>
        <input type="file" name="map_image" accept="image/*">

        <button type="submit" class="btn">Next: Add Stations, Buses, Fares</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html>
