<?php
require_once '../../includes/auth-check.php';
require_once '../../includes/db-config.php';

$bus_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($bus_id > 0) {
    try {
        $stmt = $pdo->prepare("DELETE FROM bus_services WHERE bus_id = ?");
        $stmt->execute([$bus_id]);
        
        header("Location: manage.php");
        exit;
    } catch (Exception $e) {
        die("Error deleting bus: " . $e->getMessage());
    }
} else {
    header("Location: manage.php");
    exit;
} 