<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Fixing Upload Directories</h2>";
echo "<pre>";

// Define paths
$base_path = '/Applications/XAMPP/xamppfiles/htdocs/Pocket-way';
$uploads_path = $base_path . '/uploads';
$route_maps_path = $uploads_path . '/route_maps';

// Function to create directory with proper permissions
function createDir($path) {
    if (!file_exists($path)) {
        if (mkdir($path, 0777, true)) {
            echo "Created directory: $path\n";
            chmod($path, 0777);
            echo "Set permissions to 0777\n";
        } else {
            echo "Failed to create directory: $path\n";
            $error = error_get_last();
            echo "Error: " . print_r($error, true) . "\n";
        }
    } else {
        echo "Directory exists: $path\n";
        chmod($path, 0777);
        echo "Set permissions to 0777\n";
    }
}

// Create and fix permissions for each directory
echo "Creating/fixing upload directories...\n\n";

// Create uploads directory
createDir($uploads_path);

// Create route_maps directory
createDir($route_maps_path);

// Verify directories
echo "\nVerifying directories:\n";
$dirs = array($uploads_path, $route_maps_path);
foreach ($dirs as $dir) {
    echo "\nDirectory: $dir\n";
    echo "Exists: " . (file_exists($dir) ? 'Yes' : 'No') . "\n";
    echo "Writable: " . (is_writable($dir) ? 'Yes' : 'No') . "\n";
    echo "Permissions: " . substr(sprintf('%o', fileperms($dir)), -4) . "\n";
    echo "Owner: " . posix_getpwuid(fileowner($dir))['name'] . "\n";
    echo "Group: " . posix_getgrgid(filegroup($dir))['name'] . "\n";
}

// Test file creation
echo "\nTesting file creation:\n";
$test_file = $route_maps_path . '/test_' . time() . '.txt';
if (file_put_contents($test_file, 'test')) {
    echo "Successfully created test file: $test_file\n";
    echo "File permissions: " . substr(sprintf('%o', fileperms($test_file)), -4) . "\n";
    unlink($test_file);
    echo "Test file removed\n";
} else {
    echo "Failed to create test file\n";
    $error = error_get_last();
    echo "Error: " . print_r($error, true) . "\n";
}

echo "\nDone! Please try uploading a file again.\n";
?> 