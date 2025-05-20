<?php
require_once '../includes/auth-check.php';
require_once '../includes/db-config.php';
require_once '../includes/admin-header.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Start transaction
        $pdo->beginTransaction();

  // Insert main route
        $stmt = $pdo->prepare("INSERT INTO main_routes (source, destination, total_distance, total_time, route_description, is_active, created_at) 
                              VALUES (?, ?, ?, ?, ?, ?, NOW())");
        
        $stmt->execute([
            $_POST['source'],
            $_POST['destination'],
            $_POST['total_distance'],
            $_POST['total_time'],
            $_POST['route_description'],
            isset($_POST['is_active']) ? 1 : 0
        ]);

        $route_id = $pdo->lastInsertId();

        // Handle route map upload
        if (isset($_FILES['route_map']) && $_FILES['route_map']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../uploads/route_maps/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $file_extension = strtolower(pathinfo($_FILES['route_map']['name'], PATHINFO_EXTENSION));
            $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');

            if (in_array($file_extension, $allowed_extensions)) {
                $new_filename = uniqid() . '.' . $file_extension;
                $upload_path = $upload_dir . $new_filename;

                if (move_uploaded_file($_FILES['route_map']['tmp_name'], $upload_path)) {
                    $stmt = $pdo->prepare("UPDATE main_routes SET route_map_url = ? WHERE route_id = ?");
                    $stmt->execute(['uploads/route_maps/' . $new_filename, $route_id]);
                }
            }
        }

    // Insert stations
    if (isset($_POST['station_name']) && is_array($_POST['station_name'])) {
            $stmt = $pdo->prepare("INSERT INTO route_stations (route_id, station_name, sequence_number, 
                distance_from_prev, distance_from_source, arrival_time, departure_time, 
                facilities, latitude, longitude) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            for ($i = 0; $i < count($_POST['station_name']); $i++) {
                if (!empty($_POST['station_name'][$i])) {
                    $arrival_time = !empty($_POST['arrival_time'][$i]) ? $_POST['arrival_time'][$i] : null;
                    $departure_time = !empty($_POST['departure_time'][$i]) ? $_POST['departure_time'][$i] : null;
                    
                    $stmt->execute([
                        $route_id,
                        $_POST['station_name'][$i],
                        $_POST['sequence_number'][$i],
                        $_POST['distance_from_prev'][$i] ?? null,
                        $_POST['distance_from_source'][$i] ?? null,
                        $arrival_time,
                        $departure_time,
                        $_POST['facilities'][$i] ?? null,
                        $_POST['latitude'][$i] ?? null,
                        $_POST['longitude'][$i] ?? null
                    ]);

                    // Insert fare for this station
                    if (!empty($_POST['fare'][$i])) {
                        $stmt_fare = $pdo->prepare("INSERT INTO route_fares (route_id, from_station_id, to_station_id, fare_amount) 
                                                  VALUES (?, ?, ?, ?)");
                        $stmt_fare->execute([
                            $route_id,
                            $pdo->lastInsertId(), // Current station ID
                            null, // To be updated when next station is added
                            $_POST['fare'][$i]
                        ]);
                    }
                }
            }
        }

        // Insert bus services
        if (isset($_POST['bus_number']) && is_array($_POST['bus_number'])) {
            $stmt = $pdo->prepare("INSERT INTO bus_services (route_id, bus_number, bus_type, 
                seating_capacity, departure_time, arrival_time, operating_days) 
                VALUES (?, ?, ?, ?, ?, ?, ?)");

            for ($i = 0; $i < count($_POST['bus_number']); $i++) {
                if (!empty($_POST['bus_number'][$i])) {
                    $stmt->execute([
                        $route_id,
                        $_POST['bus_number'][$i],
                        $_POST['bus_type'][$i],
                        $_POST['seating_capacity'][$i] ?? null,
                        $_POST['bus_departure_time'][$i],
                        $_POST['bus_arrival_time'][$i],
                        $_POST['operating_days'][$i] ?? null
                    ]);
                }
            }
    }

        // Insert emergency contacts
        if (isset($_POST['contact_name']) && is_array($_POST['contact_name'])) {
            $stmt = $pdo->prepare("INSERT INTO emergency_contacts (route_id, station_id, contact_name, 
                contact_number, contact_type) VALUES (?, ?, ?, ?, ?)");

            for ($i = 0; $i < count($_POST['contact_name']); $i++) {
                if (!empty($_POST['contact_name'][$i]) && !empty($_POST['contact_number'][$i])) {
                    $stmt->execute([
                        $route_id,
                        $_POST['contact_station_id'][$i] ?? null,
                        $_POST['contact_name'][$i],
                        $_POST['contact_number'][$i],
                        $_POST['contact_type'][$i] ?? null
                    ]);
                }
            }
        }

        // Insert media
        if (isset($_POST['media_type']) && is_array($_POST['media_type'])) {
            $stmt = $pdo->prepare("INSERT INTO route_media (route_id, media_type, file_url, caption) 
                VALUES (?, ?, ?, ?)");

            for ($i = 0; $i < count($_POST['media_type']); $i++) {
                if (!empty($_POST['file_url'][$i])) {
                    $stmt->execute([
                        $route_id,
                        $_POST['media_type'][$i],
                        $_POST['file_url'][$i],
                        $_POST['caption'][$i] ?? null
                    ]);
  }
            }
}

        $pdo->commit();
        header("Location: manage-routes.php?success=Route added successfully");
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        $message = "Error adding route: " . $e->getMessage();
  }
}

// Include the form HTML
include 'route-form.php';
?>