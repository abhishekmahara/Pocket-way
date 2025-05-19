<?php
require_once 'admin/includes/db-config.php';

try {
    // Get unique sources
    $sources = $pdo->query("SELECT DISTINCT source FROM main_routes WHERE is_active = 1")->fetchAll();
    
    // Get unique destinations
    $destinations = $pdo->query("SELECT DISTINCT destination FROM main_routes WHERE is_active = 1")->fetchAll();
    
    echo json_encode([
        'sources' => array_column($sources, 'source'),
        'destinations' => array_column($destinations, 'destination')
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
