<?php
// Display PHP upload settings
echo "<h2>PHP Upload Settings</h2>";
echo "<pre>";
echo "file_uploads: " . ini_get('file_uploads') . "\n";
echo "upload_max_filesize: " . ini_get('upload_max_filesize') . "\n";
echo "post_max_size: " . ini_get('post_max_size') . "\n";
echo "max_file_uploads: " . ini_get('max_file_uploads') . "\n";
echo "upload_tmp_dir: " . ini_get('upload_tmp_dir') . "\n";
echo "memory_limit: " . ini_get('memory_limit') . "\n";

// Check upload directory
$upload_dir = '/Applications/XAMPP/xamppfiles/htdocs/Pocket-way/uploads/route_maps/';
echo "\nUpload Directory Check:\n";
echo "Directory exists: " . (file_exists($upload_dir) ? 'Yes' : 'No') . "\n";
if (file_exists($upload_dir)) {
    echo "Directory permissions: " . substr(sprintf('%o', fileperms($upload_dir)), -4) . "\n";
    echo "Directory writable: " . (is_writable($upload_dir) ? 'Yes' : 'No') . "\n";
    echo "Directory owner: " . posix_getpwuid(fileowner($upload_dir))['name'] . "\n";
    echo "Directory group: " . posix_getgrgid(filegroup($upload_dir))['name'] . "\n";
}

// Test file creation
echo "\nTesting file creation:\n";
$test_file = $upload_dir . 'test.txt';
if (@file_put_contents($test_file, 'test')) {
    echo "Successfully created test file\n";
    @unlink($test_file);
} else {
    echo "Failed to create test file\n";
    $error = error_get_last();
    echo "Error: " . ($error ? $error['message'] : 'Unknown error') . "\n";
}
echo "</pre>"; 