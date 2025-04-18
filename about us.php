

<?php include '../includes/header.php'; ?>


<!--main page --->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>About Us - Travel World</title>
  <!-- Bootstrap CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

  <!-- Header -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Travel World</a>
    </div>
  </nav>

  <!-- About Us Section -->
  <section class="container my-5">
    <div class="text-center">
      <h1>About Us</h1>
      <p class="lead">Your travel companion around the globe!</p>
    </div>

    <div class="row mt-4">
      <div class="col-md-6">
        <img src="https://source.unsplash.com/600x400/?travel,nature" alt="About Us Image" class="img-fluid rounded">
      </div>
      <div class="col-md-6">
        <h3>Who We Are</h3>
        <p>We are a passionate team of travelers and explorers. Our mission is to help you discover breathtaking places around the world with unforgettable experiences. Whether you're seeking adventure, relaxation, or culture, we’ve got the perfect trip for you!</p>
      </div>
    </div>
  </section>

  <!-- Image Scroll Bar (Carousel) -->
  <section class="container my-5">
    <h2 class="text-center mb-4">Our Journeys</h2>

    <div id="travelCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="https://source.unsplash.com/800x400/?paris" class="d-block w-100" alt="Paris">
        </div>
        <div class="carousel-item">
          <img src="https://source.unsplash.com/800x400/?tokyo" class="d-block w-100" alt="Tokyo">
        </div>
        <div class="carousel-item">
          <img src="https://source.unsplash.com/800x400/?newyork" class="d-block w-100" alt="New York">
        </div>
        <div class="carousel-item">
          <img src="https://source.unsplash.com/800x400/?bali" class="d-block w-100" alt="Bali">
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#travelCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#travelCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
      </button>
    </div>
  </section>
  <?php include '../includes/footer.php'; ?>
