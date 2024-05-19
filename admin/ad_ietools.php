<?php
include "connect.php";

$ie_content = "<h1>IE Tools</h1>";

// Assuming you have a database table for tools (modify as needed)
// Retrieve categories
$sql_categories = "SELECT * FROM categories";
$result_categories = mysqli_query($db, $sql_categories);

// Retrieve tools
$sql_tools = "SELECT * FROM tools";
$result_tools = mysqli_query($db, $sql_tools);

if ($result_tools) { // Check if query was successful
  // Proceed with using $result_tools
  if (mysqli_num_rows($result_tools) > 0) {
    // Loop through results
  } else {
    echo "No tools found.";
  }
  mysqli_close($db); // Close connection within successful execution block
} else {
  // Handle query error (optional)
  echo "Error retrieving tools: " . mysqli_error($db);
}

// Removed the extra closing curly brace and else statement
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>MyPortfolio Bootstrap Template - Index</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=https://fonts.googleapis.com/css?family=Inconsolata:400,500,600,700|Raleway:400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: MyPortfolio
  * Template URL: https://bootstrapmade.com/myportfolio-bootstrap-portfolio-website-template/
  * Updated: Mar 17 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Navbar ======= -->
  <div class="collapse navbar-collapse custom-navmenu" id="main-navbar">
    <div class="container py-2 py-md-5">
      <div class="row align-items-start">
        <div class="col-md-2">
          <ul class="custom-menu">
            <li class="active"><a href="index.html">Home</a></li>
            
          </ul>
        </div>
            <div>
              <p><em>Cutting and machining tools in industrial engineering refer to instruments designed to shape, carve, or remove material from workpieces during manufacturing processes. These tools enable precise alterations to raw materials, enhancing their dimensional accuracy and surface finish. They play a pivotal role in various industries, facilitating the creation of intricate components vital for modern machinery and technology. <br> <a href="#"></a></em></p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <nav class="navbar navbar-light custom-navbar">
    <div class="container">
      <a class="navbar-brand" href="index.html">IE Tools</a>
      <a href="#" class="burger" data-bs-toggle="collapse" data-bs-target="#main-navbar">
        <span></span>
      </a>
    </div>
  </nav>

  <main id="main">

    <!-- ======= Works Section ======= -->
    <section class="section site-portfolio">
      <div class="container">
        <div class="row mb-5 align-items-center">
          <div class="col-md-12 col-lg-6 mb-4 mb-lg-0" data-aos="fade-up">
            <h2>Cutting and Machining Tools</h2>
           
          </div>
          <div class="col-md-12 col-lg-6 text-start text-lg-end" data-aos="fade-up" data-aos-delay="100">
            <div id="filters" class="filters">

            </div>
          </div>
        </div>
        <div id="portfolio-grid" class="row no-gutter" data-aos="fade-up" data-aos-delay="200">
          <div class="item web col-sm-6 col-md-4 col-lg-4 mb-4">
            <a href="work-single20.html" class="item-wrap fancybox">
              <div class="work-info">
                <h3>Manual Rivet Gun</h3>
                <span>Tool</span>
              </div>
              <img class="img-fluid" src="assets/img/Manual Rivet Gun.jpg" style="width: 500px; height: 350px;">>
            </a>
          </div>
          <div class="item photography col-sm-6 col-md-4 col-lg-4 mb-4">
            <a href="work-single22.html" class="item-wrap fancybox">
              <div class="work-info">
                <h3>Combination Pliers<h3>
                <span>Tool</span>
              </div>
              <img class="img-fluid" src="assets/img/Combination Pliers.jpg" style="width: 500px; height: 350px;">
            </a>
          </div>
          <div class="item branding col-sm-6 col-md-4 col-lg-4 mb-4">
            <a href="work-single23.html" class="item-wrap fancybox">
              <div class="work-info">
                <h3>Craft Knife</h3>
                <span>Tool</span>
              </div>
              <img class="img-fluid" src="assets/img/Craft Knife.jpg" style="width: 500px; height: 350px;">
            </a>
          </div>
          <div class="item design col-sm-6 col-md-4 col-lg-4 mb-4">
            <a href="work-single24.html" class="item-wrap fancybox">
              <div class="work-info">
                <h3>Hacksaw</h3>
                <span>Tool</span>
              </div>
              <img class="img-fluid" src="assets/img/Hacksaw.jpg" style="width: 500px; height: 350px;">
            </a>
          </div>
          <div class="item photography col-sm-6 col-md-4 col-lg-4 mb-4">
            <a href="work-single25.html" class="item-wrap fancybox">
              <div class="work-info">
                <h3>Manual Pipe Cutter</h3>
                <span>Tool</span>
              </div>
              <img class="img-fluid" src="assets/img/Manual Pipe Cutter.jpg" style="width: 500px; height: 350px;"> 
            </a>
          </div>
         
        </div>
      </div>
    </section><!-- End  Works Section -->
          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>
    </section><!-- End Testimonials Section -->

  </main><!-- End #main -->

 
  <!-- Vendor JS Files -->
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>