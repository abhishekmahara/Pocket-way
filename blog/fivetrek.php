<?php include '../includes/header.php'; ?>
<style>
    :root {
        --primary-color: #007B7F;
        --accent-color: #F9A825;
        --background-color: #F4F6F8;
        --text-color: #212529;
        --secondary-text: #6c757d;
    }

    body {
        background-color: var(--background-color);
        color: var(--text-color);
        font-family: 'Segoe UI', sans-serif;
    }

    a:visited {
        color: white;
    }

    .article-wrapper {
        background-color: #fff;
        padding: 50px;
        border-radius: 15px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
    }

    .article-title {
        color: var(--primary-color);
        font-size: 3rem;
        font-weight: bold;
        text-align: center;
        margin-bottom: 40px;
    }

    .section-heading {
        color: var(--accent-color);
        font-size: 1.75rem;
        margin-top: 50px;
        margin-bottom: 20px;
        font-weight: 600;
        text-align: center;
    }

    .trek-box {
        background: #ffffff;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 40px;
      
    }

    .article-img {
        border: 5px solid #ddd; /* Subtle border around images */
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        margin-bottom: 20px;
        width: 90%; /* Reduced image size */
        height: auto;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }

    ul li {
        margin-bottom: 8px;
    }
</style>
</head>
<body>

<div class="container py-5">
    <div class="article-wrapper">
        <h1 class="article-title">Top 5 Treks in Uttarakhand</h1>
        <p class="lead text-center">Uttarakhand is a trekker’s paradise. Let’s explore five of the most iconic and scenic treks perfect for every adventurer.</p>

        <!-- Kedarkantha Trek -->
        <div class="section-heading">1. Kedarkantha Trek</div>
        <div class="trek-box">
            <img src="../assets/img/kedarkantha.jpeg" alt="Kedarkantha Trek" class="article-img">
            <p>The Kedarkantha Trek, nestled in the Govind Wildlife Sanctuary, is one of the most popular winter treks in India. This 6-day journey through pine forests and snow-laden paths rewards you with a jaw-dropping 360° view of peaks like Swargarohini, Bandarpoonch, and Black Peak. It’s beginner-friendly and offers a fairytale-like landscape especially between December and April.</p>
        </div>

        <!-- Valley of Flowers -->
        <div class="section-heading">2. Valley of Flowers</div>
        <div class="trek-box">
            <img src="../assets/img/Valley-off-flowers.jpeg" alt="Valley of Flowers" class="article-img">
            <p>This UNESCO World Heritage Site is a visual treat during the monsoon (July–September). Located in the Chamoli district, the Valley of Flowers trek is ideal for nature lovers. The trail leads you through alpine forests, river crossings, and finally opens into a valley bursting with over 500 species of wildflowers. It’s also home to endangered species like the blue poppy and Himalayan musk deer.</p>
        </div>

        <!-- Roopkund Trek -->
        <div class="section-heading">3. Roopkund Trek</div>
        <div class="trek-box">
            <img src="../assets/img/roopkund.jpg" alt="Roopkund Lake" class="article-img">
            <p>Known for its mysterious skeletal remains, Roopkund is an adventurous high-altitude trek located in the Garhwal Himalayas. The trek takes you through dense oak forests, Bugyals (meadows), and up to the glacial Roopkund Lake at 15,700 feet. It’s ideal for experienced trekkers looking for a mix of mythology, mystery, and mountain thrill.</p>
        </div>

        <!-- Har Ki Dun -->
        <div class="section-heading">4. Har Ki Dun</div>
        <div class="trek-box">
            <img src="../assets/img/har ki doon.jpeg" alt="Har Ki Dun Trek" class="article-img">
            <p>The Har Ki Dun trek, often referred to as the “Valley of Gods,” is known for its picturesque landscapes and rich culture. The route passes through ancient villages, terraced fields, and pine forests. Ideal all year round, it offers views of majestic peaks like Swargarohini and Hata Peak. It’s great for those looking to explore the cultural side of the Himalayas along with breathtaking scenery.</p>
        </div>

        <!-- Nag Tibba -->
        <div class="section-heading">5. Nag Tibba</div>
        <div class="trek-box">
            <img src="../assets/img/nag-tibba.jpeg" alt="Nag Tibba Trek" class="article-img">
            <p>Nag Tibba (“Serpent’s Peak”) is the highest peak in the lower Himalayas of Uttarakhand, making it perfect for a short weekend trek. Starting near Mussoorie, it’s a beginner-friendly trail with dense forests, open meadows, and incredible views of peaks like Bandarpoonch and Kedarnath. It’s also one of the best treks to experience a sunset above the clouds.</p>
        </div>

        <div class="section-heading">Tips for a Safe Trek</div>
        <ul>
            <li>Check weather and road conditions before you begin.</li>
            <li>Travel with an experienced guide or in a group.</li>
            <li>Carry essential gear like waterproof jackets, torch, power bank, snacks, and medical kit.</li>
            <li>Always stay hydrated and follow Leave No Trace principles.</li>
        </ul>
 


        <div class="section-heading">Final Words</div>
        <p>Trekking in Uttarakhand is more than just a hike—it’s an experience of culture, serenity, and self-discovery. Whether you're a beginner or a seasoned trekker, these trails offer something magical for everyone. So lace up your boots, pack your essentials, and let PocketWay guide you into the heart of the Himalayas.</p>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
