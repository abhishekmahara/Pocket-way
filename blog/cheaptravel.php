<?php include '../includes/header.php'; ?>
<style>
    :root {
        --primary-color: #007B7F;
        --accent-color: #F9A825;
        --bg-color: #f9fafb;
        --text-color: #212529;
        --muted-text: #6c757d;
    }

    body {
        background-color: var(--bg-color);
        font-family: 'Segoe UI', sans-serif;
        color: var(--text-color);
    }

    .article-wrapper {
        background-color: #fff;
        padding: 50px 30px;
        border-radius: 15px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        animation: fadeIn 1s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .article-title {
        color: var(--primary-color);
        font-size: 3rem;
        text-align: center;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .lead {
        text-align: center;
        font-size: 1.2rem;
        color: var(--muted-text);
        margin-bottom: 40px;
    }

    .section-heading {
        color: var(--accent-color);
        font-size: 1.75rem;
        margin: 50px 0 20px;
        font-weight: 600;
        border-left: 5px solid var(--accent-color);
        padding-left: 15px;
    }

    .grid-2 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
    }

    .card {
        background: #f1fdfd;
        border-left: 6px solid var(--primary-color);
        border-radius: 12px;
        padding: 20px 25px;
        transition: 0.3s ease;
    }

    .card:hover {
        background: #e6fafa;
        transform: translateY(-5px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    }

    .card h4 {
        margin-top: 0;
        color: var(--primary-color);
        margin-bottom: 10px;
    }

    .highlight {
        background: #fff5e0;
        padding: 8px 12px;
        border-radius: 8px;
        margin: 15px 0;
        font-weight: bold;
        color: #d17b00;
        display: inline-block;
    }

    .tip-list li {
        margin-bottom: 10px;
        line-height: 1.6;
    }

    .place-tag {
        display: inline-block;
        background: #e0f2f1;
        color: var(--primary-color);
        font-weight: 600;
        padding: 6px 14px;
        border-radius: 20px;
        margin: 5px;
        font-size: 0.95rem;
    }

    .final-words {
        background: #e8f5e9;
        padding: 25px;
        border-radius: 10px;
        font-size: 1.1rem;
        margin-top: 40px;
        color: #2e7d32;
    }

    a {
        color: var(--primary-color);
        text-decoration: underline;
    }
</style>

<div class="container py-5">
    <div class="article-wrapper">
        <h1 class="article-title">How to Travel Affordably by Bus in Uttarakhand</h1>
        <p class="lead">Dreaming of exploring the mountains without spending a fortune? Here's your guide to traveling through Uttarakhand using local and government buses, keeping your adventure budget-friendly and full of memories.</p>

        <div class="section-heading">🚍 Types of Buses You Can Use</div>
        <div class="grid-2">
            <div class="card">
                <h4>UTC Ordinary & Semi-Deluxe</h4>
                <p>Operated by Uttarakhand Transport Corporation, these are cost-effective for long-distance journeys like Dehradun to Pithoragarh, Nainital to Badrinath, etc. They're reliable and budget-conscious.</p>
                <span class="highlight">Book at: <a href="https://utconline.uk.gov.in" target="_blank">utconline.uk.gov.in</a></span>
            </div>
            <div class="card">
                <h4>Mini & Local Town Buses</h4>
                <p>Great for inner city travel — these cover local areas in towns like Rishikesh, Haldwani, and Almora. Tickets range from ₹10–₹40.</p>
            </div>
            <div class="card">
                <h4>Shared Jeeps & Taxis</h4>
                <p>Perfect for offbeat places where buses are rare (e.g., Munsiyari, Chopta). Slightly costlier than buses, but still economical and fast.</p>
            </div>
        </div>

        <div class="section-heading">📍 Must-Know Bus Routes & Destinations</div>
        <div>
            <span class="place-tag">Dehradun – Mussoorie (₹60)</span>
            <span class="place-tag">Rishikesh – Badrinath (₹500)</span>
            <span class="place-tag">Haldwani – Almora (₹120)</span>
            <span class="place-tag">Haridwar – Rudraprayag (₹300)</span>
            <span class="place-tag">Pithoragarh – Munsiyari (₹250)</span>
        </div>

        <div class="section-heading">💡 Smart Travel Tips</div>
        <ul class="tip-list">
        <li>🕐 Start early: Most buses leave between 4 AM and 9 AM. Arriving early gives you better options.</li>
    <li>📱 Book online: Use the <a href="https://utconline.uk.gov.in">UTC website</a> to reserve seats on longer routes.</li>
    <li>💬 Talk to locals: Shopkeepers or locals at bus stands often know more than online schedules.</li>
    <li>🎒 Travel light: Buses have limited luggage space. Only carry what you really need.</li>
    <li>🌄 Mix buses and walking: For places like Chopta or Auli, take a bus close by, then walk or grab a shared jeep.</li>
        </ul>

        <div class="section-heading">🎯 Best Times to Travel Affordably</div>
        <div class="grid-2">
            <div class="card">
                <h4>Off-Peak Seasons</h4>
                <p>Try March–April or September–November. Less crowd = cheaper transport and lodging!</p>
            </div>
            <div class="card">
                <h4>Night Buses</h4>
                <p>Overnight buses to places like Pithoragarh or Joshimath save you a night’s stay and maximize your day time.</p>
            </div>
        </div>

        <div class="section-heading">📌 Bonus Hacks</div>
        <ul class="tip-list">
            <li>🗺 Use Google Maps to spot major stops on your route and plan break journeys.</li>
            <li>📷 Download offline maps — signal is patchy in the hills.</li>
            <li>🚶 If a direct bus isn’t available, break your trip into 2-3 legs. It’s cheaper and more flexible.</li>
            <li>🪪 Carry ID: Especially helpful if asked by local officers in sensitive zones.</li>
        </ul>

        <div class="final-words">
            Traveling through Uttarakhand by bus is not just affordable — it’s an adventure in itself. You'll meet locals, enjoy raw scenic beauty, and uncover real culture along the journey. Ditch the taxi, embrace the bus, and explore more for less. 🏔️
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
