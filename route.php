<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Route | Pocket Trip</title>
  <link rel="stylesheet" href="css/route.css" />
  <script defer src="route.js"></script>
</head>
<body>
  <header>
    <h1>Pocket Trip</h1>
  </header>

  <main class="container">
    <!-- Destination Section -->
    <section id="left-panel">
      <div id="destination-image">
        <img src="https://images.unsplash.com/photo-1548013146-72479768bada?q=80&w=876&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Destination" />
        <div class="image-overlay">
          <h2>Om Beach, Gokarna</h2>
          <p>Scenic coastline with peace and beauty in one destination.</p>
        </div>
      </div>
      <button id="route-btn">View Route</button>
    </section>

    <!-- Route Section -->
    <section id="route-section" class="hidden">
      <h3>Connecting Buses</h3>
      <div id="bus-line"></div>
    </section>
  </main>

  <footer>
    <p>© 2025 Pocket Trip</p>
  </footer>
</body>
</html>
