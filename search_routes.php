<?php
$from = $_GET['from'] ?? '';
$to = $_GET['to'] ?? '';

// Normalize values for matching
$route = strtolower(trim($from)) . '-to-' . strtolower(str_replace(' ', '-', trim($to)));

// Example condition - route exists
if ($route === 'haldwani-to-adi-kailash') {
    header("Location: routes/haldwani-to-adi-kailash.php");
    exit;
} else {
    // Route not found – show error or redirect to homepage
    echo "<h2 style='text-align:center; margin-top: 100px;'>Sorry, route from <b>$from</b> to <b>$to</b> not found yet.</h2>";
    echo "<p style='text-align:center;'><a href='index.php'>Go back</a></p>";
}
?>
