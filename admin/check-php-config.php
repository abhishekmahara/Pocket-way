<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>PHP Upload Configuration</h2>";
echo "<pre>";

// Check upload-related PHP settings
$upload_settings = array(
    'file_uploads' => ini_get('file_uploads'),
    'upload_max_filesize' => ini_get('upload_max_filesize'),
    'post_max_size' => ini_get('post_max_size'),
    'max_file_uploads' => ini_get('max_file_uploads'),
    'memory_limit' => ini_get('memory_limit'),
    'max_execution_time' => ini_get('max_execution_time'),
    'upload_tmp_dir' => ini_get('upload_tmp_dir'),
    'temp_dir' => sys_get_temp_dir()
);

echo "Upload Settings:\n";
print_r($upload_settings);

// Check if upload_tmp_dir is writable
if ($upload_settings['upload_tmp_dir']) {
    echo "\nTemporary Upload Directory:\n";
    echo "Path: " . $upload_settings['upload_tmp_dir'] . "\n";
    echo "Exists: " . (file_exists($upload_settings['upload_tmp_dir']) ? 'Yes' : 'No') . "\n";
    echo "Writable: " . (is_writable($upload_settings['upload_tmp_dir']) ? 'Yes' : 'No') . "\n";
    echo "Permissions: " . substr(sprintf('%o', fileperms($upload_settings['upload_tmp_dir'])), -4) . "\n";
}

// Check system temp directory
echo "\nSystem Temp Directory:\n";
echo "Path: " . $upload_settings['temp_dir'] . "\n";
echo "Exists: " . (file_exists($upload_settings['temp_dir']) ? 'Yes' : 'No') . "\n";
echo "Writable: " . (is_writable($upload_settings['temp_dir']) ? 'Yes' : 'No') . "\n";
echo "Permissions: " . substr(sprintf('%o', fileperms($upload_settings['temp_dir'])), -4) . "\n";

// Check upload directory
$upload_dir = '/Applications/XAMPP/xamppfiles/htdocs/Pocket-way/uploads/route_maps/';
echo "\nUpload Directory:\n";
echo "Path: " . $upload_dir . "\n";
echo "Exists: " . (file_exists($upload_dir) ? 'Yes' : 'No') . "\n";
echo "Writable: " . (is_writable($upload_dir) ? 'Yes' : 'No') . "\n";
if (file_exists($upload_dir)) {
    echo "Permissions: " . substr(sprintf('%o', fileperms($upload_dir)), -4) . "\n";
    echo "Owner: " . posix_getpwuid(fileowner($upload_dir))['name'] . "\n";
    echo "Group: " . posix_getgrgid(filegroup($upload_dir))['name'] . "\n";
}

// Check PHP process user
echo "\nPHP Process User:\n";
echo "User: " . get_current_user() . "\n";
echo "UID: " . getmyuid() . "\n";
echo "GID: " . getmygid() . "\n"; 