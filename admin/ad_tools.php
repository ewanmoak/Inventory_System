<?php
include "connect.php";

$tools_content = "<h1>Tools</h1>";

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
<!--
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin CPE Tools</title>
  <style>
    /* Optional styling for tool containers */
    .tool-container {
      display: inline-block;
      margin: 10px;
      border: 1px solid #ddd;
      padding: 10px;
      text-align: center;
    }
    .tool-container img {
      width: 150px;
      height: 150px;
    }
  </style>
</head>


</html>
  -->
  
  <!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>UBLC Engineering Toolroom</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/UBlogo.png" rel="icon">
  <link href="assets/img/UBlogo.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Poppins:300,400,500,700" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Regna
  * Template URL: https://bootstrapmade.com/regna-bootstrap-onepage-template/
  * Updated: Mar 17 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center ">
    <div class="container d-flex justify-content-between align-items-center">

      <div id="logo">
        <a href="index.html"><img src="assets/img/UB-Master-Logo.png" alt="" style="width: 220px; height: -250px;"></a>
        <!-- Uncomment below if you prefer to use a text logo -->
        <!--<h1><a href="index.html">Regna</a></h1>-->
      </div>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
           <li class="dropdown"><a href="#Cpe tools"><span>Cpe tools</span> <i class="bi bi-chevron-right"></i></a>
                <ul>
                  <li><a href="#">Hand Tools</a></li>
                  <li><a href="#">Measurement Tools</a></li>
                  <li><a href="#">Prototyping Tools</a></li>
                </ul>
              </li>
          <li class="dropdown"><a href="#IE tools"><span>IE tools</span> <i class="bi bi-chevron-right"></i></a>
                <ul>
                  <li><a href="#">Assembly and Fastening Tools</a></li>
                  <li><a href="#">Cutting and Machining Tools</a></li>
                  <li><a href="#">Measurement and Machining Tools</a></li>
                </ul>
              </li>
          <li><a class="nav-link scrollto" href="#services">Borrowers</a></li>
          <li><a class="nav-link scrollto " href="#portfolio">Log Out</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->
<!--
      <nav class="navbar navbar-light custom-navbar">
    <div class="container">
      <a class="navbar-brand" href="index.html">CPE Tools</a>
      <a href="#" class="burger" data-bs-toggle="collapse" data-bs-target="#main-navbar">
        <span></span>
      </a>
    </div>
  </nav> -->
  
    </div>
  </header><!--End Header -->

  <main id="main">


  </main><!-- End #main -->


  <main id="main">

  
  <!-- ======= Works Section ======= -->
    <section class="section site-portfolio">
      <div class="container">
        <div class="row mb-5 align-items-center">
          <div class="col-md-12 col-lg-6 mb-4 mb-lg-0" data-aos="fade-up">
            <h2>Tools</h2>
           
          </div>
          <div class="col-md-12 col-lg-6 text-start text-lg-end" data-aos="fade-up" data-aos-delay="100">
            <div id="filters" class="filters">

            </div>
          </div>
        </div>
        <div id="portfolio-grid" class="row no-gutter" data-aos="fade-up" data-aos-delay="200">
          <div class="item web col-sm-6 col-md-4 col-lg-4 mb-4">
            <a href="work-single.html" class="item-wrap fancybox">
              <div class="work-info">
                <h3>Wire Cutter</h3>
                <span>Tool</span>
              </div>
              <img class="img-fluid" src="assets/img/Wire Cutter.jpg" style="width: 500px; height: 350px;">>
            </a>
          </div>
          <div class="item photography col-sm-6 col-md-4 col-lg-4 mb-4">
            <a href="work-single2.html" class="item-wrap fancybox">
              <div class="work-info">
                <h3>SolderingIron</h3>
                <span>Tool</span>
              </div>
              <img class="img-fluid" src="assets/img/SolderingIron.jpg" style="width: 500px; height: 350px;">
            </a>
          </div>
          <div class="item branding col-sm-6 col-md-4 col-lg-4 mb-4">
            <a href="work-single3.html" class="item-wrap fancybox">
              <div class="work-info">
                <h3>Drill</h3>
                <span>Tool</span>
              </div>
              <img class="img-fluid" src="assets/img/Drill.jpg" style="width: 500px; height: 350px;">
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

  <!-- 
  <footer id="footer">
    <div class="footer-top">
      <div class="container">

      </div>
    </div>

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong>Regna</strong>. All Rights Reserved
      </div>
      <div class="credits">
        
        All the links in the footer should remain intact.
        You can delete the links only if you purchased the pro version.
        Licensing information: https://bootstrapmade.com/license/
        Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=Regna
    
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>
  </footer><- End Footer 
-->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>
