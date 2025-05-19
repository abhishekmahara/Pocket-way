<?php include 'includes/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>About Us - Pocket Way</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f7f9fc;
    }

    .hero {
      background-image: url('https://source.unsplash.com/1600x600/?uttarakhand,mountains,travel');
      background-size: cover;
      background-position: center;
      color: white;
      padding: 120px 20px;
      text-align: center;
    }

    .hero h1 {
      color: #007B7F;
      font-size: 3rem;
      font-weight: bold;
    }

    .hero p{
      color: #007B7F;

    }

    .section-title {
      font-weight: bold;
      font-size: 2rem;
      margin-bottom: 20px;

    }

    .core-values i {
      font-size: 2rem;
      color:  #007B7F;
    }

    .core-values .card {
      transition: 0.3s;
    }

    .core-values .card:hover {
      background: #eaf4ff;
      transform: scale(1.03);
    }

    .collapse-section {
      background: #ffffff;
      border-radius: 12px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
      padding: 20px;
      margin-top: 20px;
    }

    .gallery img {
      width: 100%;
      border-radius: 10px;
      height: 220px;
      object-fit: cover;
      transition: 0.3s ease;
    }

    .gallery img:hover {
      transform: scale(1.05);
    }
  </style>
</head>
<body>

<!-- Hero Section -->
<div class="hero">
  <h1>Explore Uttarakhand the Smart Way</h1>
  <p>Where Affordability Meets Authenticity — Welcome to Pocket Way</p>
</div>

<!-- Introduction -->
<section class="container py-5">
  <div class="row align-items-center">
    <div class="col-md-6">
      <h2 class="section-title">Who We Are</h2>
      <p>Pocket Way is a travel platform built with one mission: to connect travelers with the heart of Uttarakhand — its people, culture, and nature — in the most affordable and meaningful way possible.</p>
      <p>We're not just about destinations. We're about the journey. With local bus routes, curated trip tools, and up-to-date travel info, we help you explore like a true adventurer — not just a tourist.</p>
    </div>
    <div class="col-md-6">
      <img src="assets/img/kedarkantha.jpeg" class="img-fluid rounded shadow" alt="Travel Image">
    </div>
  </div>
</section>

<!-- Our Vision & Mission -->
<section class="container py-5">
  <div class="row text-center">
    <div class="col-md-6 mb-4">
      <h3 class="section-title">Our Vision</h3>
      <p>To redefine how India travels — making offbeat and rural destinations accessible and exciting for all.</p>
    </div>
    <div class="col-md-6">
      <h3 class="section-title">Our Mission</h3>
      <p>To empower budget travelers with smart, hyper-local, eco-conscious travel tools through transparent transport data and local insights.</p>
    </div>
  </div>
</section>

<!-- Core Values -->
<section class="container py-5">
  <h2 class="section-title text-center">Our Core Values</h2>
  <div class="row core-values text-center">
    <div class="col-md-3 mb-4">
      <div class="card p-4">
        <i class="bi bi-globe2"></i>
        <h5 class="mt-3">Accessibility</h5>
        <p>We bring remote places closer by sharing real travel data that helps you explore smarter.</p>
      </div>
    </div>
    <div class="col-md-3 mb-4">
      <div class="card p-4">
        <i class="bi bi-people-fill"></i>
        <h5 class="mt-3">Community</h5>
        <p>We support local businesses, guides, and shared transport to boost rural economies.</p>
      </div>
    </div>
    <div class="col-md-3 mb-4">
      <div class="card p-4">
        <i class="bi bi-currency-rupee"></i>
        <h5 class="mt-3">Affordability</h5>
        <p>We promote travel solutions that are budget-friendly for students, families, and solo travelers.</p>
      </div>
    </div>
    <div class="col-md-3 mb-4">
      <div class="card p-4">
        <i class="bi bi-tree-fill"></i>
        <h5 class="mt-3">Sustainability</h5>
        <p>We advocate for low-impact travel using public transport and eco-conscious practices.</p>
      </div>
    </div>
  </div>
</section>

<!-- How It Works -->
<section class="container py-5">
  <h2 class="section-title text-center">How Pocket Way Works</h2>
  <div class="row text-center">
    <div class="col-md-3">
      <h5>1. Search Destination</h5>
      <p>Use our search tools to explore places across Uttarakhand.</p>
    </div>
    <div class="col-md-3">
      <h5>2. View Routes</h5>
      <p>Get clear bus-by-bus guidance between any two places.</p>
    </div>
    <div class="col-md-3">
      <h5>3. Plan Itinerary</h5>
      <p>Check travel types: snow, waterfalls, temples, treks, and more.</p>
    </div>
    <div class="col-md-3">
      <h5>4. Travel Smart</h5>
      <p>Pack light, pay less, and discover more with local knowledge.</p>
    </div>
  </div>
</section>

<!-- Travel Gallery -->
<section class="container py-5">
  <h2 class="section-title text-center">Moments from the Road</h2>
  <div class="row g-4 gallery">
    <div class="col-md-4"><img src="assets/img/top trek.jpg" alt=""></div>
    <div class="col-md-4"><img src="assets/img/Valley-off-flowers.jpeg" alt=""></div>
    <div class="col-md-4"><img src="assets/img/har ki doon.jpeg" alt=""></div>
    <div class="col-md-4"><img src="assets/img/nanital.jpeg" alt=""></div>
    <div class="col-md-4"><img src="assets/img/munsiyari.jpg" alt=""></div>
    <div class="col-md-4"><img src="assets/img/kedarkantha.jpeg" alt=""></div>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<?php include 'includes/footer.php'; ?>
