<?php
include __DIR__ . '/../config.php';  
?>

<style>
  .footer-link {
    color: #ffffff;
    text-decoration: none;
    transition: color 0.3s ease;
  }

  .footer-link:visited {
    color: #ffffff;
  }

  .footer-link:hover {
    color: #ffc107;
   
  }

  .logo {
    width: 150px; 
    height: auto; 
  }

  .social-icon {
    color: #ffffff;
    font-size: 1.2rem;
    transition: color 0.3s ease;
  }

  .social-icon:hover {
    color: #ffc107;
  }

  .footer-logo{
    height: 50px;           
    width: auto;            
    margin-right: 15px;    
    border-radius: 5px;
  }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

   
    
<footer style="background: linear-gradient(135deg, #006366,rgb(56, 132, 125));";
" class="text-white pt-5 pb-4">
  <div class="container">
    <div class="row text-center text-md-start">

      <!-- About Section -->
      <div class="col-md-4 mb-4">
      <a class="navbar-brand" href="<?php echo $base_url; ?>">
      <img src="<?php echo $logo_url; ?>" alt="Pocket Way Logo" class="navbar-logo" />
      </a>
      
      <p class="mb-0">Your smart companion for affordable travel in Uttarakhand using public transport. Save money, travel smart!</p>
      </div>

      <!-- Quick Links -->
      <div class="col-md-4 mb-4">
        <h6 class="text-uppercase fw-bold mb-3">Quick Links</h6>
        <ul class="list-unstyled">
          <li><a href="#" class="footer-link">Home</a></li>
          <li><a href="#trip-planner" class="footer-link">Trip Planner</a></li>
          <li><a href="#contact" class="footer-link">About Us</a></li>
        </ul>
      </div>

      <!-- Contact Info -->
      <div class="col-md-4 mb-4">
        <h6 class="text-uppercase fw-bold mb-3">Contact Us</h6>
        <p>Email: <a href="mailto:support@pocketway.in" class="footer-link">support@pocketway.in</a></p>
        <p>Phone: +91 98765 43210</p>
        <div class="mt-3 d-flex justify-content-center justify-content-md-start gap-3">
          <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
          <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
          <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
        </div>
      </div>

    </div>
    <hr class="border-light mt-4">
    <div class="text-center">
      <p class="mb-0">&copy; 2025 <span style="color: #F9A825;">PocketWay</span>. All rights reserved.</p>
    </div>
  </div>
</footer>
<!-- End of Footer -->
</body>
</html>
