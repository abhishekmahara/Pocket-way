<?php
include __DIR__ . '/../config.php';  
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Smart Travel - Public Transport Guide</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="style.css" />
  <!-- Add Lightbox CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" />
  <style>
    body {
      
      font-family: 'Segoe UI', sans-serif;
    }
    .navbar-brand {
      font-weight: bold;
      color: #0056b3;
    }
    .nav-link {
      font-size: 1rem;
      margin-right: 1rem;
    }
    .nav-link:hover {
      color: #ffc107 !important;
    }
    .navbar {
    background: linear-gradient(135deg, #006366,rgb(56, 132, 125));
     
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .navbar-logo {
      height: 50px;
      width: auto;
      margin-right: 15px;
      border-radius: 5px;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top" style="background-color: #007B7F; padding: 1.2rem 0;">
  <div class="container">
      <img src="<?php echo $logo_url; ?>" alt="Pocket Way Logo" class="navbar-logo" />
 
    
    <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link text-white fs-5 px-3" href="<?php echo $base_url; ?>index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white fs-5 px-3" href="<?php echo $base_url; ?>trip_planner.php">Trip Planner</a>
        </li>
        <li class="nav-item"> 
         <a class="nav-link text-white fs-5 px-3 " href="<?php echo $base_url; ?>#travel-tips">Travel Tips</a>
        </li>

        <li class="nav-item">
          <a class="nav-link text-white fs-5 px-3" href="<?php echo $base_url; ?>about us.php">About Us</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Bootstrap Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Add jQuery (required for lightbox) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Add Lightbox JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>

</body>
</html>
