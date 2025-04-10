

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
      background-color: var(--primary-color);
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
      margin: 0.5rem auto;
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

    .card-title {
      color: var(--primary-color);
    }

  </style>

  <!-- Hero Section with Form -->
  <section class="hero">
    <div class="container">
      <h1>Explore Uttarakhand the Smart Way</h1>
      <p>Plan your journey with affordable public transport.</p>
      <form class="row justify-content-center">
        <div class="col-md-3">
          <select class="form-select2 form-control" id="from">
            <option value="">From</option>
            <option>Nainital</option>
            <option>Haridwar</option>
            <option>Dehradun</option>
          </select>
        </div>
        <div class="col-md-3">
          <select class="form-select2 form-control" id="to">
            <option value="">To</option>
            <option>Kedarnath</option>
            <option>Mussoorie</option>
            <option>Rishikesh</option>
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
        <div class="col-md-4 mb-4">
          <div class="card shadow-sm">
            <img src="assets/img/nanital.jpeg" class="card-img-top" alt="Nainital">
            <div class="card-body">
              <h5 class="card-title">Nainital</h5>
              <p class="card-text">A beautiful lake town surrounded by hills and serene views.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="card shadow-sm">
          <img src="assets/img/kedarnath.jpg" alt="Kedarkantha Trek">
            <div class="card-body">
              <h5 class="card-title">Kedarnath</h5>
              <p class="card-text">A holy shrine in the Himalayas, offering spiritual and scenic beauty.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="card shadow-sm">
            <img src="assets/img/rishikesh.jpg" class="card-img-top" alt="Rishikesh">
            <div class="card-body">
              <h5 class="card-title">Rishikesh</h5>
              <p class="card-text">Yoga capital of the world with adventure sports and river rafting.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="card shadow-sm">
            <img src="assets/img/munsiyari.jpg" class="card-img-top" alt="munsyari">
            <div class="card-body">
              <h5 class="card-title">Munsiyari</h5>
              <p class="card-text"> Munsiyari is a popular trekking destination, and serves as a base to various popular trails</p>
            </div>
          </div>
        </div>

        <div class="col-md-4 mb-4">
          <div class="card shadow-sm">
            <img src="assets/img/harsil.jpg" class="card-img-top" alt="Harsil Valley">
            <div class="card-body">
              <h5 class="card-title">Harsil Valley</h5>
              <p class="card-text">Harsil is a village, tourist hill station and army area located on the banks of the Bhagirathi River, on the way to Gangotri</p>
          </div>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="card shadow-sm">
            <img src="assets/img/adi-kailash.jpg" class="card-img-top" alt=" Adi-kailash">
            <div class="card-body">
              <h5 class="card-title">Adi Kailash</h5>
              <p class="card-text">​Adi Kailash, also known as Chota Kailash, is a sacred Himalayan peak in Uttarakhand.</p>
            </div>
          </div>
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
                        <a href="blog/fivetrek.php" class="text-primary">Read More →</a>
                    </div>
                </div>
            </div>
            <!-- Article 2 -->
            <div class="col-md-4">
                <div class="card card-custom h-100">
                    <img src="https://source.unsplash.com/400x250/?uttarakhand,food" class="card-img-top" alt="Local Cuisine">
                    <div class="card-body">
                        <h5 class="card-title">Local Foods You Must Try</h5>
                        <p class="card-text">Savor delicacies like Aloo Ke Gutke and Bal Mithai while exploring the hills.</p>
                        <a href="blog/localfood.php" class="text-primary">Read More →</a>
                    </div>
                </div>
            </div>
            <!-- Article 3 -->
            <div class="col-md-4">
                <div class="card card-custom h-100">
                    <img src="https://source.unsplash.com/400x250/?uttarakhand,bus" class="card-img-top" alt="Bus Travel Tips">
                    <div class="card-body">
                        <h5 class="card-title">How to Travel Cheaply by Bus</h5>
                        <p class="card-text">Learn how to use public transport smartly with our budget travel guide.</p>
                        <a href="#" class="text-primary">Read More →</a>
                    </div>
                </div>
            </div>
            <!-- Article 4 -->
            <div class="col-md-4">
                <div class="card card-custom h-100">
                    <img src="https://source.unsplash.com/400x250/?uttarakhand,monuments" class="card-img-top" alt="Heritage">
                    <div class="card-body">
                        <h5 class="card-title">Historic Sites to Visit</h5>
                        <p class="card-text">Explore temples, forts, and spiritual places that define Uttarakhand's rich culture.</p>
                        <a href="#" class="text-primary">Read More →</a>
                    </div>
                </div>
            </div>
            <!-- Article 5 -->
            <div class="col-md-4">
                <div class="card card-custom h-100">
                    <img src="https://source.unsplash.com/400x250/?uttarakhand,travel" class="card-img-top" alt="Solo Travel">
                    <div class="card-body">
                        <h5 class="card-title">Solo Travel in Uttarakhand</h5>
                        <p class="card-text">Is it safe? Where to go? Tips for solo travelers looking to explore the unknown.</p>
                        <a href="#" class="text-primary">Read More →</a>
                    </div>
                </div>
            </div>
            <!-- Article 6 -->
            <div class="col-md-4">
                <div class="card card-custom h-100">
                    <img src="https://source.unsplash.com/400x250/?uttarakhand,nature" class="card-img-top" alt="Nature Spots">
                    <div class="card-body">
                        <h5 class="card-title">Peaceful Nature Escapes</h5>
                        <p class="card-text">Find quiet corners of the hills—offbeat spots for nature lovers and photographers.</p>
                        <a href="#" class="text-primary">Read More →</a>
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

