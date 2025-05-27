<?php
// Test script for upload directory permissions

// Get various possible directory paths
$paths = array(
    'Project Root' => dirname(dirname(dirname(__FILE__))),
    'Home Directory' => $_SERVER['HOME'] ?? getenv('HOME'),
    'Temp Directory' => sys_get_temp_dir(),
    'Current Directory' => dirname(__FILE__)
);

echo "<h2>Directory Information</h2>";
echo "<pre>";

foreach ($paths as $name => $path) {
    echo "\n$name:\n";
    echo "Path: $path\n";
    echo "Exists: " . (file_exists($path) ? 'Yes' : 'No') . "\n";
    if (file_exists($path)) {
        echo "Permissions: " . substr(sprintf('%o', fileperms($path)), -4) . "\n";
        echo "Writable: " . (is_writable($path) ? 'Yes' : 'No') . "\n";
        echo "Owner: " . posix_getpwuid(fileowner($path))['name'] . "\n";
        echo "Group: " . posix_getgrgid(filegroup($path))['name'] . "\n";
    }
}

// Try to create test directories
echo "\n\nAttempting to create test directories:\n";

$test_dirs = array(
    'Project Uploads' => dirname(dirname(dirname(__FILE__))) . '/uploads',
    'Home Uploads' => ($_SERVER['HOME'] ?? getenv('HOME')) . '/pocket-way-uploads',
    'Temp Uploads' => sys_get_temp_dir() . '/pocket-way-uploads'
);

foreach ($test_dirs as $name => $dir) {
    echo "\n$name:\n";
    echo "Path: $dir\n";
    
    if (!file_exists($dir)) {
        echo "Creating directory...\n";
        if (@mkdir($dir, 0777, true)) {
            echo "Directory created successfully\n";
            echo "Setting permissions...\n";
            if (@chmod($dir, 0777)) {
                echo "Permissions set successfully\n";
            } else {
                echo "Failed to set permissions\n";
            }
        } else {
            echo "Failed to create directory\n";
            $error = error_get_last();
            echo "Error: " . ($error ? $error['message'] : 'Unknown error') . "\n";
        }
    } else {
        echo "Directory already exists\n";
        echo "Permissions: " . substr(sprintf('%o', fileperms($dir)), -4) . "\n";
        echo "Writable: " . (is_writable($dir) ? 'Yes' : 'No') . "\n";
    }
}

echo "</pre>"; 