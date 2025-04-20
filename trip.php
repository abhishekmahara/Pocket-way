

<?php include 'includes/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>About Us - WanderWise</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">WanderWise</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#destinationsSidebar" aria-controls="destinationsSidebar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" href="#">About Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="offcanvas" href="#destinationsSidebar" role="button">Destinations</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Offcanvas Sidebar -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="destinationsSidebar" aria-labelledby="destinationsLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="destinationsLabel">Popular Destinations</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <ul class="list-group">
      <li class="list-group-item"><a href="blog-nainital.html" class="text-decoration-none">Nainital</a></li>
      <li class="list-group-item"><a href="blog-kedarnath.html" class="text-decoration-none">Kedarnath</a></li>
      <li class="list-group-item"><a href="blog-manali.html" class="text-decoration-none">Manali</a></li>
      <li class="list-group-item"><a href="blog-goa.html" class="text-decoration-none">Goa</a></li>
    </ul>
  </div>
</div>

<!-- Main Content -->
<section class="container py-5">
  <h1 class="mb-4">About Us</h1>
  <p>Welcome to <strong>WanderWise</strong> – your gateway to unforgettable journeys. Whether you're dreaming of misty mountains or sunny beaches, we’re here to guide you every step of the way.</p>
  <p>Our platform is designed for curious souls looking to travel deeper, smarter, and more meaningfully. From carefully crafted guides to personal travel stories, our goal is to make every trip a life-changing experience.</p>
</section>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3">
  <p class="mb-0">&copy; 2025 WanderWise. All rights reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


<?php include 'includes/footer.php';