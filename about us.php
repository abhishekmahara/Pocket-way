

<?php include 'includes/header.php'; ?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>About Us </title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f7f9fc;
    }

    .hero {
      background-image: url('https://source.unsplash.com/1600x600/?travel,landscape');
      background-size: cover;
      background-position: center;
      color: white;
      padding: 100px 20px;
      text-align: center;
    }

    .hero h1 {
      font-size: 3rem;
      font-weight: bold;
    }

    .gallery img {
      width: 100%;
      border-radius: 10px;
      transition: 0.3s ease;
    }

    .gallery img:hover {
      transform: scale(1.05);
    }

    .video-section iframe {
      border-radius: 10px;
    }
  </style>
</head>
<body>

 
  <!-- About Us Text Section -->
  <section class="container my-5">
    <div class="row align-items-center">
      <div class="col-md-6">
        <h2>Who We Are</h2>
        <p>Welcome to Explore Uttarakhand the Smart Way– a travel hub created by explorers, for explorers. We're passionate travelers with a deep love for discovering new cultures, places, and experiences. Our goal? To help you travel smarter, explore deeper, and make memories that last forever.</p>
      </div>
    
      </div>
    
  </section>

  <!-- About Us Text Section -->
  <section class="container my-5">
    <div class="row align-items-center">
      <div class="col-md-6">
        <h2>Our Mission</h2>
        <p>We believe travel changes lives. That’s why our mission is to make travel easy, exciting, and meaningful for everyone—whether you're a first-timer or a seasoned adventurer.</p>
  </div>
      </div>
    
  </section>


  <!-- Photo Gallery -->
  <section class="container my-5">
    <h2 class="text-center mb-4">Travel Moments</h2>
    <div class="row g-4 gallery">
    
      <div class="col-md-4"><img src="assets/img/top trek.jpg" alt=""></div>
      <div class="col-md-4"><img src="assets/img/Valley-off-flowers.jpeg" alt=""></div>
      <div class="col-md-4"><img src="assets/img/har ki doon.jpeg" alt=""></div>
      <div class="col-md-4"><img src="assets/img/nanital.jpeg" alt=""></div>
      <div class="col-md-4"><img src="assets/img/munsiyari.jpg" alt=""></div>
      <div class="col-md-4"><img src="assets/img/rishikesh.jpg" alt=""></div>
      <div class="col-md-4"><img src="assets/img/kedarkantha.jpeg" alt=""></div>
      <div class="col-md-4"><img src="assets/img/nag-tibba.jpeg" alt=""></div>
      <div class="col-md-4"><img src="assets/img/harsil.jpg" alt=""></div>
      <div class="col-md-4"><img src="assets/img/roopkund.jpeg" alt=""></div>
      <div class="col-md-4"><img src="assets/img/triund.jpeg" alt=""></div>

  </div>
  </section>


  <?php   
include 'includes/footer.php';
?>
