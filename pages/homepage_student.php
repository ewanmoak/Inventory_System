<?php
session_start();

$db = mysqli_connect('localhost', 'root', '', 'login');
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}

if (isset($_GET['logout'])) {
  if (isset($_SESSION['success'])) {
    // Display success message from previous login (optional)
    echo $_SESSION['success'];
    unset($_SESSION['success']);
  }
}
?>

<?php if (isset($student_content)): ?>
    <?php echo $student_content; ?>
      <?php endif; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Welcome to UBLC Engineering Tool Room</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Poppins:300,400,500,700" rel="stylesheet">

    <link href="admin/assets/img/Ublogo.png" rel="Ub-Logo">
    <link href="admin/assets/img/ublogo.png" rel="ub-logo">
    <link href="admin/assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="admin/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="admin/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="admin/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="admin/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="admin/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="admin/assets/css/style.css" rel="stylesheet">


    <!-- Template Main CSS File -->
    <link href="admin/assets/css/style.css" rel="stylesheet">


    <style>
        .moving-text {
            display: inline-block;
            white-space: nowrap;
            overflow: hidden;
            box-sizing: border-box;
            animation: marquee 15s linear infinite;
            font-size: 30px;
            font-weight: bold;
            color: #fff; /* Adjust text color as needed */
        }

        @keyframes marquee {
            0% {
                transform: translate(100%, 0);
            }
            100% {
                transform: translate(-100%, 0);
            }
        }

    </style>

</head>

<body>

<!-- ======= Header ======= -->
<header id="header" class="fixed-top d-flex align-items-center header-transparent">
    <div class="container d-flex justify-content-between align-items-center">

        <div id="logo">
            <a href="index.html"><img src="admin/assets/img/UB-Master-Logo.png" alt="" style="width: 220px; height: -250px;"></a>
            <!-- Uncomment below if you prefer to use a text logo -->
            <!--<h1><a href="index.html">Regna</a></h1>-->
        </div>

        <nav id="navbar" class="navbar">
            <ul>
                <li class="dropdown"><a href=""><span>Tools</span> <i class="bi bi-chevron-right"></i></a>
                    <ul>
                        <li><a href="student_hand.php">Hand Tools</a></li>
                        <li><a href="student_measurement.php">Measurement Tools</a></li>
                        <li><a href="student_prototyping.php">Prototyping Tools</a></li>
                        <li><a href="fastening.php">Assembly and Fastening Tools</a></li>
                        <li><a href="student_cutting.php">Cutting and Machining Tools</a></li>
                        <li><a href="student_inspection.php">Measurement and Machining Tools</a></li>
                    </ul>
                </li>
                <li><a class="nav-link" href="borrowedItems_list.php">Borrowed Items</a></li>
                <li><a class="nav-link" href="logout.php">Log Out</a></li>

            </ul>

            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->
    </div>
</header><!-- End Header -->

<!-- ======= Hero Section ======= -->
<section id="hero">
    <div class="hero-container" data-aos="zoom-in" data-aos-delay="100">
        <div class="moving-text">
            Welcome to UBLC Engineering Tool Room
        </div>
    </div>
</section><!-- End Hero Section -->

<main id="main">

    <!-- ======= Team Section ======= -->
    <section id="team">
        <div class="container" data-aos="fade-up">
            <div class="section-header">
                <h3 class="section-title">Team</h3>
                <p class="section-description"> The Development of Inventory System Engineering Tool Room of University of Batangas Lipa Campus</p>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="member" data-aos="fade-up" data-aos-delay="100">
                        <div class="pic"><img src="admin/assets/img/Angge.jpg" alt=""></div>
                        <h4>Fruelda, Angela Victoria C.</h4>
                        <span>Leader</span>
                        <div class="social">
                            <a href="https://twitter.com/home"><i class="bi bi-twitter"></i></a>
                            <a href="https://www.facebook.com/coloma.taucer"><i class="bi bi-facebook"></i></a>
                            <a href="https://www.instagram.com/angge.victoria?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="><i class="bi bi-instagram"></i></a>
                            <a href="https://www.linkedin.com"><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="member" data-aos="fade-up" data-aos-delay="200">
                        <div class="pic"><img src="admin/assets/img/Gamara.jpg" alt=""></div>
                        <h4>Gamara, Diane E.</h4>
                        <span>Member</span>
                        <div class="social">
                            <a href="https://twitter.com/home"><i class="bi bi-twitter"></i></a>
                            <a href="https://www.facebook.com"><i class="bi bi-facebook"></i></a>
                            <a href="https://www.instagram.com"><i class="bi bi-instagram"></i></a>
                            <a href="https://www.linkedin.com"><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="member" data-aos="fade-up" data-aos-delay="300">
                        <div class="pic"><img src="admin/assets/img/Martija_Noe Myron_L..jpg" alt=""></div>
                        <h4>Martija, Noe Myron L.</h4>
                        <span>Member</span>
                        <div class="social">
                            <a href="https://twitter.com/NoeMartija_"><i class="bi bi-twitter"></i></a>
                            <a href="https://www.facebook.com/NMLM.FTW/"><i class="bi bi-facebook"></i></a>
                            <a href="https://www.instagram.com/_noemartija/"><i class="bi bi-instagram"></i></a>
                            <a href="https://www.linkedin.com/in/noe-myron-martija-3824a9302/"><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="member" data-aos="fade-up" data-aos-delay="400">
                        <div class="pic"><img src="admin/assets/img/Mart.jpg" alt=""></div>
                        <h4>Ortiz, Mart Joshua O. </h4>
                        <span>Member</span>
                        <div class="social">
                            <a href="https://twitter.com/home"><i class="bi bi-twitter"></i></a>
                            <a href="https://www.facebook.com/profile.php?id=100027424326007"><i class="bi bi-facebook"></i></a>
                            <a href="https://www.instagram.com/immartortiz?fbclid=IwZXh0bgNhZW0CMTAAAR1P6D8PYGcRKwgxb0TjXDtqDV1o5DTISJc6oqknV0fZAjhxzY6s-fL22Nc_aem_AdXEj6AXxhJWp-6d9ZH4jqxJ5lx27J4cHisCevx3NT9E8NFAZA9n3oZlbZVG0qd3CDeWp7_fZ_Jh7yyWspFSGBmp"><i class="bi bi-instagram"></i></a>
                            <a href="https://www.linkedin.com"><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section><!-- End Team Section -->

    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="footer-top">
            <div class="container">

            </div>
        </div>

        <div class="container">
            <div class="copyright">
                &copy; Copyright <strong>UBLC ENGINEERING TOOLROOM</strong>. All Rights Reserved
            </div>
            <div class="credits">
                <!--
                All the links in the footer should remain intact.
                You can delete the links only if you purchased the pro version.
                Licensing information: https://bootstrapmade.com/license/
                Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=Regna
              -->
                Designed by <a href="https://bootstrapmade.com/">Team 11 CpE3A</a>
            </div>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="admin/assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="admin/assets/vendor/aos/aos.js"></script>
    <script src="admin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="admin/assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="admin/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="admin/assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="admin/assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="admin/assets/js/main.js"></script>

</body>

</html>