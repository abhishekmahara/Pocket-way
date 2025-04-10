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

    .food-box {
        background: #ffffff;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 40px;
   
    }

    .article-img {
        border: 5px solid #ddd;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        margin-bottom: 20px;
        width: 90%;
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
        <h1 class="article-title">Local Foods You Must Try in Uttarakhand</h1>
        <p class="lead text-center">Uttarakhand's cuisine is a delightful reflection of its rich culture and natural bounty. Here are some traditional dishes that offer a true taste of the region.</p>

        <!-- Aloo Ke Gutke -->
        <div class="section-heading">1. Aloo Ke Gutke</div>
        <div class="food-box">
            <img src="../assets/img/aloo-ke-gutke.jpg" alt="Aloo Ke Gutke" class="article-img">
            <p>Aloo Ke Gutke is a traditional Kumaoni dish made with boiled potatoes sautéed in mustard oil and seasoned with local spices like jakhiya (wild mustard seeds) or cumin seeds. It's often garnished with fresh coriander and served with puris or rotis. This simple yet flavorful dish is a staple in Uttarakhand households. :contentReference[oaicite:0]{index=0}</p>
        </div>

        <!-- Kafuli -->
        <div class="section-heading">2. Kafuli</div>
        <div class="food-box">
            <img src="../assets/img/kafuli.jpg" alt="Kafuli" class="article-img">
            <p>Kafuli is a nutritious dish prepared with spinach and fenugreek leaves, cooked in an iron kadhai to enhance its health benefits. It's typically served with steamed rice and is cherished for its rich flavors and wholesome goodness. :contentReference[oaicite:1]{index=1}</p>
        </div>

        <!-- Bhang Ki Chutney -->
        <div class="section-heading">3. Bhang Ki Chutney</div>
        <div class="food-box">
            <img src="../assets/img/bhang-ki-chutney.jpg" alt="Bhang Ki Chutney" class="article-img">
            <p>Bhang Ki Chutney is a unique condiment made from roasted hemp seeds, blended with garlic, cumin, and tamarind. This tangy and flavorful chutney is a perfect accompaniment to various dishes and showcases the inventive use of local ingredients in Uttarakhand's cuisine. :contentReference[oaicite:2]{index=2}</p>
        </div>

        <!-- Bal Mithai -->
        <div class="section-heading">4. Bal Mithai</div>
        <div class="food-box">
            <img src="../assets/img/bal-mithai.jpg" alt="Bal Mithai" class="article-img">
            <p>Bal Mithai is a beloved sweet from the Kumaon region, particularly famous in Almora. This chocolate-like fudge is made from roasted khoya and coated with white sugar balls, offering a delightful treat for those with a sweet tooth. :contentReference[oaicite:3]{index=3}</p>
        </div>

        <!-- Singori -->
        <div class="section-heading">5. Singori</div>
        <div class="food-box">
            <img src="../assets/img/singori.jpg" alt="Singori" class="article-img">
            <p>Singori is a traditional sweet made with khoya, wrapped in maalu leaves, imparting a distinct aroma and flavor. This cone-shaped delicacy is a testament to the region's rich culinary heritage and is a must-try for visitors. :contentReference[oaicite:4]{index=4}</p>
        </div>

        <div class="section-heading">Experience the Flavors of Uttarakhand</div>
        <p>Exploring Uttarakhand's local cuisine offers a deeper understanding of its culture and traditions. Each dish tells a story of the land and its people, making your culinary journey through this Himalayan state truly unforgettable.</p>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
