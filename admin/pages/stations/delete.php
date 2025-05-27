<?php
require_once '../../includes/auth-check.php';
require_once '../../includes/db-config.php';

$station_id = isset($_GET['station_id']) ? (int)$_GET['station_id'] : 0;

if ($station_id > 0) {
    try {
        $stmt = $pdo->prepare("DELETE FROM route_stations WHERE station_id = ?");
        $stmt->execute([$station_id]);
        header("Location: manage.php");
        exit;
    } catch (Exception $e) {
        die("Error deleting station: " . $e->getMessage());
    }
} else {
    header("Location: manage.php");
    exit;
} 