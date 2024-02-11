<?php ob_start(); ?>
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
  <head> 
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script
      src="https://kit.fontawesome.com/7cac6f5ac1.js"
      crossorigin="anonymous"
    ></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap"
      rel="stylesheet"
    />
    <script defer src="JS/script.js"></script>
    <link rel="stylesheet" href="css/general.css" />
    <link rel="stylesheet" href="css/headerfooter.css" />

    <link rel="icon" href="img/icons/Logo-Web.png">
    <title>The Glow Light</title>
  </head>
  <body>
  <?php include 'inc/db.php'; ?>
  <?php include 'inc/functions.php'; ?>
  <!----------------->
  <!-- Heading -->
  <!----------------->
  <header class="header">
    <div class="head-container">
      <div class="head">
        <div class="heading">
          <h1 href="#">The Glow Light</h1>
          <p class="site-description text">Smart Detailing</p>
        </div>
        <div class="head-info">
          <div class="head-info-container">
            <i class="fas fa-phone"></i>
            <div>
              <p class="head-info-heading">Call Us</p>
              <p class="head-info-content text">07577&nbsp;425&nbsp;727</p>
            </div>
          </div>
          <div class="head-info-container">
            <i class="far fa-envelope-open"></i>
            <div>
              <p class="head-info-heading">Email Address</p>
              <p class="head-info-content text">info@theglowlight.co.uk</p>
            </div>
          </div>
        </div>
      </div>
    </div> 
    <!----------------->
    <!-- Navigation -->
    <!----------------->
    <nav class="main-nav-section">
      <div class="main-nav-container">
        <button class="btn-mobile-nav-open">
          <i class=" fas fa-bars btn-mobile-nav-open-icon" name="menu-open-icon"></i>
        </button>
        <div class="main-nav">
          <button class="btn-mobile-nav-close">
            <i class=" fas fa-times btn-mobile-nav-close-icon" name="menu-close-icon"></i>
          </button>
          <ul class="main-nav-list">
            <li><a class="main-nav-link" href="home.php">Home</a></li>
            <li><a class="main-nav-link" href="services.php">Services</a></li>
            <li><a class="main-nav-link" href="aboutus.php">About Us</a></li>
            <li><a class="main-nav-link" href="testimonials.php">Testimonials</a></li>
            <?php displayLinks(); ?>
          </ul>
        </div>
      </div>
    </nav>
  </header>