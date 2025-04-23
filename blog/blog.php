<?php include '../includes/header.php'; ?>

<style>
  html {
    scroll-behavior: smooth;
    scroll-padding-top: 100px;
  }
  .scroll-offset::before {
    content: "";
    display: block;
    height: 100px;
    margin-top: -100px;
    visibility: hidden;
  }
  .carousel-inner img {
    object-fit: cover;
  }
  .carousel {
    max-width: 100%;
    margin: 0 auto;
  }
  .blog-entry {
    background-color: #f9f9f9;
    border-left: 6px solid #008080;
    padding: 40px 30px;
    border-radius: 12px;
    margin-bottom: 80px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
  }
  .blog-entry h3 {
    font-size: 2.5rem;
    color: #004d40;
    margin-bottom: 20px;
  }
  .blog-entry h5 {
    color: #00695c;
    margin-top: 30px;
    margin-bottom: 10px;
  }
  .blog-entry p,
  .blog-entry li {
    color: #37474f;
    font-size: 16px;
    line-height: 1.7;
  }
  .blog-entry ul {
    list-style: disc;
    padding-left: 20px;
  }
  .section-title {
    color: #008080;
    font-weight: bold;
    font-size: 2.5rem;
    text-align: center;
    margin-bottom: 40px;
  }

  /* Style for image containers */
  .image-container {
    position: relative;
    overflow: hidden;
    border-radius: 12px;
    max-width: 100%;
    height: 450px; /* increased height for better image display */
    margin-bottom: 20px;
  }
  .image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease-in-out;
  }
  .image-container:hover img {
    transform: scale(1.05);
  }
  
  /* Arrows for carousel */
  .carousel-control-prev, .carousel-control-next {
    font-size: 2rem;
    color: #008080;
  }
</style>

<section class="blog-section container py-5">
  <h2 class="section-title">Explore Uttarakhand: Top Travel Blogs</h2>

  <!-- NAINITAL -->
  <section id="nainital" class="scroll-offset blog-entry">
    <h3>Nainital - The Lake District</h3>
    <div id="slider-nainital" class="carousel slide mb-4" data-bs-ride="carousel">
      <div class="carousel-inner rounded">
        <div class="carousel-item active">
          <div class="image-container">
            <img src="../assets/img/nanital.jpeg" class="d-block w-100" alt="Nainital Lake">
          </div>
        </div>
        <div class="carousel-item">
          <div class="image-container">
            <img src="../assets/img/nainital2.jpg" class="d-block w-100" alt="Snow View Point">
          </div>
        </div>
        <div class="carousel-item">
          <div class="image-container">
            <img src="../assets/img/nainital3.jpg" class="d-block w-100" alt="Tiffin Top">
          </div>
        </div>
        <div class="carousel-item">
          <div class="image-container">
            <img src="../assets/img/nainital4.jpg" class="d-block w-100" alt="Mall Road">
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#slider-nainital" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#slider-nainital" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
    <p><strong>Nainital</strong> is a serene hill station built around the famous pear-shaped Naini Lake. Whether you're a honeymooner, a solo traveler, or a family looking for a mountain escape, Nainital offers the perfect balance of adventure and relaxation.</p>
    <h5>🗓 Best Time to Visit</h5>
    <p>March to June is ideal for sightseeing and boat rides. Winter lovers can visit between December and February for snow-covered scenery.</p>
    <h5>🗺 How to Reach</h5>
    <p>Reach Kathgodam by train and take a 1-hour scenic drive to Nainital. Private/shared taxis and buses are easily available from the station.</p>
    <h5>🌄 Must-Visit Spots</h5>
    <ul>
      <li>Naini Lake – Perfect for boating and relaxing views</li>
      <li>Naina Devi Temple – A divine and peaceful shrine</li>
      <li>Tiffin Top – Great hiking destination with bird’s-eye views</li>
      <li>Snow View Point – Ride the cable car for amazing snowcapped peaks</li>
      <li>Governor’s House – British-era architecture and vast lawns</li>
    </ul>
    <h5>🍲 Local Cuisine</h5>
    <p>Try Bhatt ki Churkani, Aloo ke Gutke, and fresh pastries at the famous bakeries. Don't miss Bal Mithai and Singori for desserts.</p>
    <h5>📌 Pro Tips</h5>
    <p>Book your stay in advance during peak months. Carry warm clothes even in summer evenings. Nearby getaways include Bhimtal, Sattal, and Pangot.</p>
  </section>

  <!-- KEDARNATH -->
  <section id="kedarnath" class="scroll-offset blog-entry">
    <h3>Kedarnath - The Abode of Lord Shiva</h3>
    <div id="slider-kedarnath" class="carousel slide mb-4" data-bs-ride="carousel">
      <div class="carousel-inner rounded">
        <div class="carousel-item active">
          <div class="image-container">
            <img src="../assets/img/kedarnath.jpg" class="d-block w-100" alt="Kedarnath Temple">
          </div>
        </div>
        <div class="carousel-item">
          <div class="image-container">
            <img src="../assets/img/kedarnath2.jpg" class="d-block w-100" alt="Kedarnath Views">
          </div>
        </div>
        <div class="carousel-item">
          <div class="image-container">
            <img src="../assets/img/kedarnath3.jpg" class="d-block w-100" alt="Kedarnath Mountains">
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#slider-kedarnath" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#slider-kedarnath" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
    <p><strong>Kedarnath</strong> is one of the Char Dham pilgrimage sites in Uttarakhand, dedicated to Lord Shiva. The Kedarnath Temple, set amidst snow-capped peaks and dramatic landscapes, is one of the holiest temples in India.</p>
    <h5>🗓 Best Time to Visit</h5>
    <p>Visit from May to June and September to October to avoid the monsoon and snow-bound winters.</p>
    <h5>🗺 How to Reach</h5>
    <p>Reach Gaurikund by road and take a 16 km trek to the temple. Helicopter services are also available for direct access to the shrine.</p>
    <h5>🌄 Must-Visit Spots</h5>
    <ul>
      <li>Kedarnath Temple – The sacred temple of Lord Shiva</li>
      <li>Bhairon Temple – Offers panoramic views of the surroundings</li>
      <li>Chorabari Lake – A serene spot for meditation and reflection</li>
    </ul>
    <h5>🍲 Local Cuisine</h5>
    <p>Try the local Garhwal dishes like Aloo Ke Gutke and Pahadi Rajma. Also, sample traditional Kumaoni sweets like Bal Mithai.</p>
    <h5>📌 Pro Tips</h5>
    <p>The trek is steep, so prepare yourself with proper gear. Carry warm clothing even in the summer months as temperatures can drop suddenly.</p>
  </section>

  <!-- HARSHIL VALLEY -->
  <section id="harsil-valley" class="scroll-offset blog-entry">
    <h3>Harsil Valley - Hidden Gem of Uttarakhand</h3>
    <div id="slider-harsil" class="carousel slide mb-4" data-bs-ride="carousel">
      <div class="carousel-inner rounded">
        <div class="carousel-item active">
          <div class="image-container">
            <img src="../assets/img/harsil1.jpg" class="d-block w-100" alt="Harsil Valley">
          </div>
        </div>
        <div class="carousel-item">
          <div class="image-container">
            <img src="../assets/img/harsil2.jpg" class="d-block w-100" alt="Harsil Landscape">
          </div>
        </div>
        <div class="carousel-item">
          <div class="image-container">
            <img src="../assets/img/harsil3.jpg" class="d-block w-100" alt="Harsil River">
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#slider-harsil" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#slider-harsil" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
    <p><strong>Harsil Valley</strong> is an offbeat destination, untouched by commercial tourism. Located near the Bhagirathi river, this place offers pristine landscapes and an ideal escape for nature lovers.</p>
    <h5>🗓 Best Time to Visit</h5>
    <p>Summer months (March to June) are perfect for exploring. Winters offer a snowy ambiance but are colder.</p>
    <h5>🗺 How to Reach</h5>
    <p>From Haridwar, travel to Uttarkashi by road (around 6-7 hours), then proceed towards Harsil via a private vehicle or taxi.</p>
    <h5>🌄 Must-Visit Spots</h5>
    <ul>
      <li>Harsil Valley – Explore its peaceful surroundings</li>
      <li>Ganga Valley – Visit the scenic valley formed by the river</li>
      <li>Ganga Temple – A spiritual spot in the region</li>
    </ul>
    <h5>🍲 Local Cuisine</h5>
    <p>Local Garhwali food, including fresh mountain vegetables and cooked rice, is a must-try.</p>
    <h5>📌 Pro Tips</h5>
    <p>Carry winter clothing during the cold months. It's a perfect destination for trekking and camping.</p>
  </section>

  <!-- MUNSIYARI -->
  <section id="munsiyari" class="scroll-offset blog-entry">
    <h3>Munsiyari - The Gateway to Inner Kumaon</h3>
    <div id="slider-munsiyari" class="carousel slide mb-4" data-bs-ride="carousel">
      <div class="carousel-inner rounded">
        <div class="carousel-item active">
          <div class="image-container">
            <img src="../assets/img/munsiyari1.jpg" class="d-block w-100" alt="Munsiyari Mountain Views">
          </div>
        </div>
        <div class="carousel-item">
          <div class="image-container">
            <img src="../assets/img/munsiyari2.jpg" class="d-block w-100" alt="Munsiyari Trekking">
          </div>
        </div>
        <div class="carousel-item">
          <div class="image-container">
            <img src="../assets/img/munsiyari3.jpg" class="d-block w-100" alt="Munsiyari Village">
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#slider-munsiyari" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#slider-munsiyari" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
    <p><strong>Munsiyari</strong> is a remote hill station located in the Kumaon region of Uttarakhand. Known for its breathtaking views of the Panchachuli Peaks, it’s a haven for trekkers and nature lovers.</p>
    <h5>🗓 Best Time to Visit</h5>
    <p>March to June is ideal for trekking and sightseeing, while winter offers snow-covered views and is great for snow activities.</p>
    <h5>🗺 How to Reach</h5>
    <p>Travel to Almora or Pithoragarh by road, then take a 4-5 hour drive to Munsiyari. Alternatively, you can reach Pithoragarh and take a taxi from there.</p>
    <h5>🌄 Must-Visit Spots</h5>
    <ul>
      <li>Panchachuli Peaks – A majestic sight for trekkers</li>
      <li>Ralam Glacier – A serene and scenic destination</li>
      <li>Thamri Kund – A picturesque location near the village</li>
    </ul>
    <h5>🍲 Local Cuisine</h5>
    <p>Try the local Kumaoni food, especially the traditional ‘Aloo ke Gutke’ and ‘Singori’ sweet dishes.</p>
    <h5>📌 Pro Tips</h5>
    <p>Wear sturdy trekking shoes and carry high-energy food on your treks. The weather is unpredictable, so pack accordingly.</p>
  </section>

  <!-- ADI KAILASH -->
  <section id="adikailash" class="scroll-offset blog-entry">
    <h3>Adi Kailash - The Abode of Lord Shiva</h3>
    <div id="slider-adikailash" class="carousel slide mb-4" data-bs-ride="carousel">
      <div class="carousel-inner rounded">
        <div class="carousel-item active">
          <div class="image-container">
            <img src="../assets/img/adikailash1.jpg" class="d-block w-100" alt="Adi Kailash Peaks">
          </div>
        </div>
        <div class="carousel-item">
          <div class="image-container">
            <img src="../assets/img/adikailash2.jpg" class="d-block w-100" alt="Adi Kailash Trek">
          </div>
        </div>
        <div class="carousel-item">
          <div class="image-container">
            <img src="../assets/img/adikailash3.jpg" class="d-block w-100" alt="Adi Kailash Views">
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#slider-adikailash" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#slider-adikailash" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
    <p><strong>Adi Kailash</strong>, also known as the 'Little Kailash', is a sacred and isolated mountain in the Kumaon region of Uttarakhand, considered the abode of Lord Shiva.</p>
    <h5>🗓 Best Time to Visit</h5>
    <p>Best visited from May to June and September to October, as weather conditions can get harsh in winters.</p>
    <h5>🗺 How to Reach</h5>
    <p>The base for this pilgrimage is Dharchula. You can take a road trip from Pithoragarh or Almora to reach the village.</p>
    <h5>🌄 Must-Visit Spots</h5>
    <ul>
      <li>Adi Kailash – The main shrine and divine mountain</li>
      <li>Om Parvat – An extraordinary natural phenomenon with an Om symbol</li>
      <li>Gauri Kund – A beautiful and spiritual spot</li>
    </ul>
    <h5>🍲 Local Cuisine</h5>
    <p>Try Garhwali Pahadi food and some Kumaoni sweets like Bal Mithai and Singori.</p>
    <h5>📌 Pro Tips</h5>
    <p>Ensure to carry a good walking stick, warm clothing, and check for weather updates before your visit.</p>
  </section>

</section>

<?php include '../includes/footer.php'; ?>
