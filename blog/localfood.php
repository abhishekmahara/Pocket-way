<?php include '../includes/header.php'; ?>
<style>
    :root {
        --primary-color: #007B7F;
        --accent-color: #F9A825;
        --bg-light: #f4f6f8;
        --bg-white: #ffffff;
        --text-dark: #212529;
        --text-muted: #6c757d;
        --card-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
    }

    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: var(--bg-light);
        color: var(--text-dark);
        margin: 0;
        padding: 0;
    }

   .hero {
    background-color: var(--bg-light);
    height: 30vh;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary-color);;
    text-align: center;
    position: relative;
    }

   

    .hero h1 {
        position: relative;
        font-size: 3.3rem;
        font-weight: bold;
        z-index: 1;
    }

    .content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 60px 20px;
    }

    .intro {
        text-align: center;
        font-size: 1.2rem;
        color: var(--text-muted);
        margin-bottom: 50px;
    }

    .food-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
    }

    .food-card {
        background: var(--bg-white);
        border-radius: 15px;
        overflow: hidden;
        box-shadow: var(--card-shadow);
        transition: transform 0.3s ease;
    }

    .food-card:hover {
        transform: translateY(-5px);
    }

    .food-card img {
        width: 100%;
        height: 250px;
        object-fit: cover;
    }

    .food-card .card-body {
        padding: 20px;
    }

    .food-card h2 {
        color: var(--primary-color);
        font-size: 1.5rem;
        margin-bottom: 10px;
    }

    .food-card p {
        color: var(--text-muted);
        font-size: 1rem;
    }

    .section-ending {
        text-align: center;
        font-size: 1.3rem;
        margin-top: 60px;
        color: var(--primary-color);
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .hero h1 {
            font-size: 2.2rem;
        }
    }
</style>

<div class="hero">
    <h1>Local Foods You Must Try in Uttarakhand</h1>
</div>

<div class="content">
    <p class="intro">
        Uttarakhand's cuisine is a delightful reflection of its rich culture and natural bounty. Here are some traditional dishes that offer a true taste of the region.
    </p>

    <div class="food-section">

        <!-- Aloo Ke Gutke -->
        <div class="food-card">
            <img src="../assets/img/aalu k gutke.jpg" alt="Aloo Ke Gutke">
            <div class="card-body">
                <h2>1. Aloo Ke Gutke</h2>
                <p>Aloo Ke Gutke is a traditional Kumaoni dish made with boiled potatoes sautéed in mustard oil and seasoned with local spices like jakhiya or cumin. It’s often served with puris or rotis.</p>
            </div>
        </div>

        <!-- Jholi -->
        <div class="food-card">
            <img src="../assets/img/jholi.jpeg" alt="Jholi">
            <div class="card-body">
                <h2>2. Jholi</h2>
                <p>Jholi is a delicious curry made with buttermilk and gram/wheat flour, flavored with garlic or radish. Best enjoyed with rice or roti.</p>
            </div>
        </div>

        <!-- Bhang Ki Chutney -->
        <div class="food-card">
            <img src="../assets/img/Bhang Ki Chutney.jpg" alt="Bhang Ki Chutney">
            <div class="card-body">
                <h2>3. Bhang Ki Chutney</h2>
                <p>This tangy condiment is made from roasted hemp seeds, cumin, and tamarind, offering a burst of bold local flavors.</p>
            </div>
        </div>

        <!-- Bal Mithai -->
        <div class="food-card">
            <img src="../assets/img/Bal Mithai.jpg" alt="Bal Mithai">
            <div class="card-body">
                <h2>4. Bal Mithai</h2>
                <p>A signature sweet of Almora, Bal Mithai is like chocolate fudge made with roasted khoya and coated with sugar pearls.</p>
            </div>
        </div>

        <!-- Singori -->
        <div class="food-card">
            <img src="../assets/img/Singori.png" alt="Singori">
            <div class="card-body">
                <h2>5. Singori</h2>
                <p>Singori is a cone-shaped dessert made with khoya and wrapped in maalu leaves, giving it a unique fragrance and flavor.</p>
            </div>
        </div>

         <!-- Madue ki Roti -->
        <div class="food-card">
            <img src="https://i0.wp.com/www.navuttarakhand.com/wp-content/uploads/2016/09/Mandua-Ki-Roti.jpg?fit=1128%2C846&ssl=1" alt="Mandua">
            <div class="card-body">
                <h2>5. Mandua Ki Roti </h2>
                <p>Mandua Ki Roti is a nutritious millet flatbread from Uttarakhand, rich in calcium and great for digestion—especially enjoyed during cold winters.</p>
            </div>
        </div>

    </div>

    <div class="section-ending">
        Experience the Flavors of Uttarakhand – A Journey Through Taste and Tradition.
    </div>
</div>

<?php include '../includes/footer.php'; ?>
