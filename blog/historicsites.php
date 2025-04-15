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

    .container-custom {
        max-width: 1200px;
        margin: 0 auto;
        padding: 60px 20px;
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

    .place-section {
        margin-bottom: 60px;
    }

    .section-heading {
        color: var(--accent-color);
        font-size: 1.75rem;
        font-weight: 600;
        text-align: center;
        margin-bottom: 25px;
    }

    .image-row {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 20px;
    }

    .image-row img {
        width: 48%;
        height: 18rem;
        object-fit: cover;
        border: 4px solid #eee;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .description {
        font-size: 1rem;
        color: var(--secondary-text);
        max-width: 900px;
        margin: 0 auto;
        text-align: center;
        line-height: 1.6;
    }

    @media (max-width: 768px) {
        .image-row img {
            width: 100%;
            height: 15rem;
        }
    }
</style>

<div class="container-custom">
    <div class="article-wrapper">
        <h1 class="article-title">Historic Sites to Visit in Uttarakhand</h1>

        
        <div class="place-section">
            <h2 class="section-heading">Patal Bhuvaneshwar Cave Temple</h2>
            <div class="image-row">
                <img src="https://wandersky.in/wp-content/uploads/2023/08/Patal-Bhuvaneshwar-Cave-Temple_-Unveiling-the-Mysteries.jpg" alt="Patal Bhuvaneshwar">
                <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEj63aMmt_I0I4p7U1OIyqDyZBkSr6ENYc3eyPM85REwPV_dnS-Rgp4QdE4RNk7h300JLsU1a4e_mKsnhWLt4Y7iLdtjsIn_Z-c1PkbghcL7-aIfQHSzQ138Vrq4f5I-EMofhVsSSzDGMvc/s320/Patal+Bhuvaneshwar+Entrance.JPG" alt="Patal Cave Interior">
            </div>
            <p class="description">
                A hidden limestone cave temple near Gangolihat dedicated to Lord Shiva, believed to be as old as time itself. Inside, the natural rock formations are said to represent gods, sages, and mythological scenes. A divine and otherworldly experience for every pilgrim and explorer.
            </p>
        </div>

        <!-- Bageshwar Temple -->
        <div class="place-section">
            <h2 class="section-heading">Bageshwar Temple</h2>
            <div class="image-row">
                <img src="https://www.uttarakhandi.com/wp-content/uploads/Bagnath-Temple-1140x445.jpg" alt="Bagnath Temple">
                <img src="https://staticimg.amarujala.com/assets/images/2016/05/29/bagnath-temple-bagehswar_1464509323.jpeg?w=674&dpr=1.0&q=80" alt="Bageshwar Aarti">
            </div>
            <p class="description">
                Located at the confluence of the Saryu and Gomti rivers, the Bagnath Temple is dedicated to Lord Shiva. A hub for religious devotion, especially during the Uttarayani Mela, this temple complex holds centuries of Kumaoni culture and tradition.
            </p>
        </div>

        <!-- Katarmal Sun Temple -->
        <div class="place-section">
            <h2 class="section-heading">Katarmal Sun Temple</h2>
            <div class="image-row">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b7/Sun_temple_-_Katarmal.jpg/681px-Sun_temple_-_Katarmal.jpg" alt="Katarmal Sun Temple">
                <img src="https://www.nainitalcorbetttourism.com/images/almora-images/katarmal-sun-temple-in-almora.gif" alt="Katarmal Temple Wide View">
            </div>
            <p class="description">
                Built in the 9th century by the Katyuri kings, Katarmal is the second most important sun temple in India. It showcases incredible ancient stone architecture, surrounded by panoramic views of the Almora hills.
            </p>
        </div>

        <!-- Baijnath Temple -->
        <div class="place-section">
            <h2 class="section-heading">Baijnath Temple</h2>
            <div class="image-row">
                <img src="https://s7ap1.scene7.com/is/image/incredibleindia/baijnath-kausani-uttarakhand-2-attr-hero?qlt=82&ts=1727354800832" alt="Baijnath Temple">
                <img src="https://s7ap1.scene7.com/is/image/incredibleindia/baijnath-temple-area-kausani-uttarakhand-3-attr-hero?qlt=82&ts=1727354877628" alt="Baijnath Surroundings">
            </div>
            <p class="description">
                Situated on the banks of the Gomti river in the Kumaon region, Baijnath is a collection of beautiful stone temples dedicated to Lord Shiva. A serene historic site surrounded by nature and spirituality.
            </p>
        </div>

        <!-- Chandpur Fort -->
        <div class="place-section">
            <h2 class="section-heading">Chandpur Fort</h2>
            <div class="image-row">
                <img src="https://i.pinimg.com/736x/17/6e/42/176e428f50ee19fa9a12f48d14ccaa74.jpg" alt="Chandpur Fort">
                <img src="https://i0.wp.com/wegarhwali.com/wp-content/uploads/2020/09/IMG_20200826_105641-scaled-e1599639525881.jpg?fit=640%2C296&ssl=1" alt="Chandpur Hill View">
            </div>
            <p class="description">
                An ancient fort with captivating views located in the Champawat district. Though in ruins, Chandpur Fort once guarded the region and reflects the strategic and architectural strength of Uttarakhand’s past dynasties.
            </p>
        </div>

    </div>
</div>

<?php include '../includes/footer.php'; ?>
