<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Upload Process Debug</h2>";
echo "<pre>";

// 1. Check if file was uploaded
if (isset($_FILES['test_file'])) {
    echo "File upload detected\n";
    echo "File details:\n";
    print_r($_FILES['test_file']);
    
    // 2. Check upload directory
    $upload_dir = '/Applications/XAMPP/xamppfiles/htdocs/Pocket-way/uploads/route_maps/';
    echo "\nUpload directory check:\n";
    echo "Path: " . $upload_dir . "\n";
    echo "Exists: " . (file_exists($upload_dir) ? 'Yes' : 'No') . "\n";
    echo "Writable: " . (is_writable($upload_dir) ? 'Yes' : 'No') . "\n";
    echo "Permissions: " . substr(sprintf('%o', fileperms($upload_dir)), -4) . "\n";
    
    // 3. Try to create a test file
    $test_file = $upload_dir . 'test_' . time() . '.txt';
    echo "\nTesting file creation:\n";
    if (file_put_contents($test_file, 'test')) {
        echo "Test file created successfully\n";
        unlink($test_file);
    } else {
        echo "Failed to create test file\n";
        $error = error_get_last();
        echo "Error: " . print_r($error, true) . "\n";
    }
    
    // 4. Try to move uploaded file
    if ($_FILES['test_file']['error'] === UPLOAD_ERR_OK) {
        $target_file = $upload_dir . 'test_upload_' . time() . '.jpg';
        echo "\nAttempting to move uploaded file:\n";
        echo "From: " . $_FILES['test_file']['tmp_name'] . "\n";
        echo "To: " . $target_file . "\n";
        
        if (move_uploaded_file($_FILES['test_file']['tmp_name'], $target_file)) {
            echo "File moved successfully\n";
            echo "File exists: " . (file_exists($target_file) ? 'Yes' : 'No') . "\n";
            echo "File size: " . filesize($target_file) . " bytes\n";
            unlink($target_file);
        } else {
            echo "Failed to move file\n";
            $error = error_get_last();
            echo "Error: " . print_r($error, true) . "\n";
        }
    } else {
        echo "\nUpload error code: " . $_FILES['test_file']['error'] . "\n";
        echo "Error message: " . getUploadErrorMessage($_FILES['test_file']['error']) . "\n";
    }
} else {
    echo "No file uploaded\n";
}

// Function to get upload error message
function getUploadErrorMessage($error_code) {
    switch ($error_code) {
        case UPLOAD_ERR_INI_SIZE:
            return 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
        case UPLOAD_ERR_FORM_SIZE:
            return 'The uploaded file exceeds the MAX_FILE_SIZE directive in the HTML form';
        case UPLOAD_ERR_PARTIAL:
            return 'The uploaded file was only partially uploaded';
        case UPLOAD_ERR_NO_FILE:
            return 'No file was uploaded';
        case UPLOAD_ERR_NO_TMP_DIR:
            return 'Missing a temporary folder';
        case UPLOAD_ERR_CANT_WRITE:
            return 'Failed to write file to disk';
        case UPLOAD_ERR_EXTENSION:
            return 'A PHP extension stopped the file upload';
        default:
            return 'Unknown upload error';
    }
}
?>

<form action="" method="POST" enctype="multipart/form-data">
    <input type="file" name="test_file" accept="image/*">
    <input type="submit" value="Test Upload">
</form> 