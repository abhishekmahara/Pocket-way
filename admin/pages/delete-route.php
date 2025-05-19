<?php
require_once '../../includes/auth-check.php';
require_once '../../includes/db-config.php';

$routeId = $_GET['route_id'] ?? null;

if ($routeId) {
    try {
        $stmt = $pdo->prepare("DELETE FROM main_routes WHERE route_id = ?");
        $stmt->execute([$routeId]);
        header('Location: manage-routes.php?success=Route deleted successfully');
        exit;
    } catch (Exception $e) {
        die('Error deleting route: ' . $e->getMessage());
    }
} else {
    header('Location: manage-routes.php?error=Invalid route ID');
    exit;
}