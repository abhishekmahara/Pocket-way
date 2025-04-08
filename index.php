
<?php
include 'header.php';
?>


    <main>
        <!-- Popular Destinations Section -->
        <section class="destination-section">
            <h2 class="destination-title">Destinations</h2>
            <div class="destination-grid" id="destinationGrid">
                <div class="destination-card" onclick="redirectToRoute('Taj Mahal, Agra')">
                    <img src="https://images.unsplash.com/photo-1564507592333-c60657eea523?q=80&w=871&auto=format&fit=crop" alt="Taj Mahal">
                    <div class="card-info">
                        <h3>Taj Mahal</h3>
                        <p>Explore the monument of love in Agra</p>
                    </div>
                </div>

                <div class="destination-card" onclick="redirectToRoute('Gateway of India, Mumbai')">
                    <img src="https://images.unsplash.com/photo-1598434192043-71111c1b3f41?q=80&w=735&auto=format&fit=crop" alt="Gateway of India">
                    <div class="card-info">
                        <h3>Gateway of India</h3>
                        <p>Historic arch-monument in Mumbai</p>
                    </div>
                </div>

                <div class="destination-card" onclick="redirectToRoute('Red Fort, Delhi')">
                    <img src="https://source.unsplash.com/300x200/?redfort" alt="Red Fort">
                    <div class="card-info">
                        <h3>Red Fort</h3>
                        <p>Iconic fortress in the heart of Delhi</p>
                    </div>
                </div>

                <div class="destination-card" onclick="redirectToRoute('Mysore Palace, Mysore')">
                    <img src="https://source.unsplash.com/300x200/?mysore-palace" alt="Mysore Palace">
                    <div class="card-info">
                        <h3>Mysore Palace</h3>
                        <p>One of India's grandest royal palaces</p>
                    </div>
                </div>
            </div>
        </section>
    </main>
<?php   
include 'footer.php';
?>

