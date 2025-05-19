<?php include 'includes/header.php'; ?>



 <main>
    <style>
    :root {
      --primary-color: #007B7F;
      --accent-color: #F9A825;
      --bg-color: #F4F6F8;
      --text-color: #212529;
      --secondary-text: #6c757d;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: var(--bg-color);
      color: var(--text-color);
    }

    .hero {
      background-image: url('https://images.unsplash.com/photo-1483728642387-6c3bdd6c93e5?q=80&w=1176&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
      background-size: cover;
      background-position: 50% 50%;
      color: white;
      padding: 4rem 0;
      text-align: center;
    }

    .hero h1 {
      font-size: 2.5rem;
      font-weight: bold;
    }

    .hero p {
      font-size: 1.2rem;
    }

    .form-select2 {
      max-width: 300px;
      
    }

    .select2-container .select2-selection--single {
      height: 40px;
      padding: 5px 10px;
    }

    .select2-container--default .select2-selection--single {
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    section {
      padding: 60px 0;
    }

    .section-title {   
      font-size: 2rem;
      font-weight: 600;
      color: var(--primary-color);
      text-align: center;
      margin-bottom: 2rem;
    }

    .read-more {    /* Read More Button  */
    padding: 10px 20px;
    background-color: #F9A825;
    text-decoration: none;
    border-radius: 5px;
    display: inline-block;
    text-align: center;
    color: white ;
    }

    .card-title {
      color: var(--primary-color);
    }

    .card img{
      width: 100%; 
      height: 200px; 
      object-fit: cover; 
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
    }

  
  </style>

  <!-- Hero Section with Form -->
  <section class="hero">
    <div class="container">
      <h1>Explore Uttarakhand the Smart way</h1>
      <p>Plan your journey with affordable public transport.</p>
      <form class="row justify-content-center" method="GET" action="search_routes.php">
  <div class="col-md-3">
    <select class="form-select2 form-control" id="from" name="from">
      <option value="">From</option>
      <option value="Haldwani">Haldwani</option>
      <option value="Haridwar">Haridwar</option>
      <option value="Dehradun">Dehradun</option>
    </select>
  </div>
  <div class="col-md-3">
    <select class="form-select2 form-control" id="to" name="to">
      <option value="">To</option>
      <option value="Adi Kailash">Adi Kailash</option>
      <option value="Kedarnath">Kedarnath</option>
      <option value="Mussoorie">Mussoorie</option>
      <option value="Rishikesh">Rishikesh</option>
    </select>
  </div>
  <div class="col-md-2">
    <button class="btn btn-warning w-100" type="submit">Search</button>
  </div>
</form>
    </div>
  </section>


 <!-- Destinations -->
<section class="bg-white">
  <div class="container">
    <h2 class="section-title">Top Destinations</h2>
    <div class="row">

      <!-- Nainital -->
      <div class="col-md-4 mb-4">
        <a href="blog/blog.php#nainital" class="text-decoration-none text-dark">
          <div class="card shadow-sm">
            <img src="assets/img/nanital.jpeg" class="card-img-top" alt="Nainital">
            <div class="card-body">
              <h5 class="card-title">Nainital</h5>
              <p class="card-text">A beautiful lake town surrounded by hills and serene views.</p>
            </div>
          </div>
        </a>
      </div>

      <!-- Kedarnath -->
      <div class="col-md-4 mb-4">
        <a href="blog/blog.php#kedarnath" class="text-decoration-none text-dark">
          <div class="card shadow-sm">
            <img src="assets/img/kedarnath.jpg" class="card-img-top" alt="Kedarnath">
            <div class="card-body">
              <h5 class="card-title">Kedarnath</h5>
              <p class="card-text">A holy shrine in the Himalayas, offering spiritual and scenic beauty.</p>
            </div>
          </div>
        </a>
      </div>

      <!-- Rishikesh -->
      <div class="col-md-4 mb-4">
        <a href="blog/blog.php#rishikesh" class="text-decoration-none text-dark">
          <div class="card shadow-sm">
            <img src="assets/img/rishikesh.jpg" class="card-img-top" alt="Rishikesh">
            <div class="card-body">
              <h5 class="card-title">Rishikesh</h5>
              <p class="card-text">Yoga capital of the world with adventure sports and river rafting.</p>
            </div>
          </div>
        </a>
      </div>

      <!-- Munsiyari -->
      <div class="col-md-4 mb-4">
        <a href="blog/blog.php#munsiyari" class="text-decoration-none text-dark">
          <div class="card shadow-sm">
            <img src="assets/img/munsiyari.jpg" class="card-img-top" alt="Munsiyari">
            <div class="card-body">
              <h5 class="card-title">Munsiyari</h5>
              <p class="card-text">A trekking hub offering panoramic Himalayan views and adventure trails.</p>
            </div>
          </div>
        </a>
      </div>

      <!-- Harsil Valley -->
      <div class="col-md-4 mb-4">
        <a href="blog/blog.php#harsil-valley" class="text-decoration-none text-dark">
          <div class="card shadow-sm">
            <img src="assets/img/harsil.jpg" class="card-img-top" alt="Harsil Valley">
            <div class="card-body">
              <h5 class="card-title">Harsil Valley</h5>
              <p class="card-text">A quiet hill station on the Bhagirathi River en route to Gangotri.</p>
            </div>
          </div>
        </a>
      </div>

      <!-- Adi Kailash -->
      <div class="col-md-4 mb-4">
        <a href="blog/blog.php#adikailash" class="text-decoration-none text-dark">
          <div class="card shadow-sm">
            <img src="assets/img/adi-kailash.jpg" class="card-img-top" alt="Adi Kailash">
            <div class="card-body">
              <h5 class="card-title">Adi Kailash</h5>
              <p class="card-text">Sacred Himalayan peak also known as Chhota Kailash, ideal for pilgrimages.</p>
            </div>
          </div>
        </a>
      </div>

    </div>
  </div>
</section>


  <!-- Travel Articles -->

<section class="py-5" style="background-color: #f4f6f8;">
    <div class="container">
        <h2 class="section-title text-center mb-5">Travel Tips & Articles</h2>
        <div class="row g-4">
            <!-- Article 1 -->
            <div class="col-md-4">
                <div class="card card-custom h-100">
                    <img src="assets/img/top trek.jpg" class="card-img-top" alt="Top Treks">
                    <div class="card-body">
                        <h5 class="card-title">Top 5 Treks in Uttarakhand</h5>
                        <p class="card-text">Discover thrilling treks like Kedarkantha and Valley of Flowers for your next adventure.</p>
                        <a href="blog/fivetrek.php" class="read-more">Read More </a>
                    </div>
                </div>
            </div>
            <!-- Article 2 -->
            <div class="col-md-4">
                <div class="card card-custom h-100">
                    <img src="assets\img\local_food.jpg" class="card-img-top" alt="Local Cuisine">
                    <div class="card-body">
                        <h5 class="card-title">Local Foods You Must Try</h5>
                        <p class="card-text">Enjoy the taste of Aloo Ke Gutke and Bal Mithai while exploring the beautiful hills of Uttarakhand.</p>
                        <a href="blog/localfood.php" class="read-more">Read More </a>
                    </div>
                </div>
            </div>
            <!-- Article 3 -->
            <div class="col-md-4">
                <div class="card card-custom h-100">
                    <img src="https://images.unsplash.com/photo-1584127088015-3b0be0722c66?w=1000&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8N3x8c29sbyUyMHdpdGglMjBpbmRpYW4lMjBidXN8ZW58MHx8MHx8fDA%3D" class="card-img-top" alt="Bus Travel Tips">
                    <div class="card-body">
                        <h5 class="card-title">How to Travel Affordably by Bus in Uttarakhand</h5>
                        <p class="card-text">Learn how to use public transport smartly with our budget travel guide.</p>
                        <a href="blog/cheaptravel.php" class="read-more">Read More </a>
                    </div>
                </div>
            </div>
            <!-- Article 4 -->
            <div class="col-md-4">
                <div class="card card-custom h-100">
                    <img src="https://images.unsplash.com/photo-1709623868300-e3b78cad10e1?w=1000&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8dXR0YXJha2hhbmR8ZW58MHx8MHx8fDA%3D" class="card-img-top" alt="Heritage">
                    <div class="card-body">
                        <h5 class="card-title">Historic Sites to Visit</h5>
                        <p class="card-text">Explore temples, forts, and spiritual places that define Uttarakhand's rich culture.</p>
                        <a href="blog/historicsites.php" class="read-more">Read More </a>
                    </div>
                </div>
            </div>
            <!-- Article 5 -->
            <div class="col-md-4">
                <div class="card card-custom h-100">
                    <img src="https://images.unsplash.com/photo-1522506209496-4536d9020ec4?w=1000&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8N3x8c29sbyUyMHRyYXZlbHxlbnwwfHwwfHx8MA%3D%3D" class="card-img-top" alt="Solo Travel">
                    <div class="card-body">
                        <h5 class="card-title">Solo Adventures in Uttarakhand</h5>
                        <p class="card-text">Is it safe? Where to go? Tips for solo travelers looking to explore the unknown.</p>
                        <a href="blog/solotravel.php" class="read-more">Read More </a>
                    </div>
                </div>
            </div>
            <!-- Article 6 -->
            <div class="col-md-4">
                <div class="card card-custom h-100">
                    <img src="https://plus.unsplash.com/premium_photo-1688645554172-d3aef5f837ce?q=80&w=1176&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="card-img-top" alt="Nature Spots">
                    <div class="card-body">
                        <h5 class="card-title">Must-See Landscapes in Uttarakhand</h5>
                        <p class="card-text">Explore Uttarakhand’s iconic landscapes, highlighting the region's natural beauty.</p>
                        <a href="blog\natureview.php" class="read-more">Read More </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


    </main>
<?php   
include 'includes/footer.php';
?>

