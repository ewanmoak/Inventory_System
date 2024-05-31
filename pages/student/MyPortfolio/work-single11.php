<?php

$db = mysqli_connect('localhost', 'root', '', 'inventory'); // Assuming correct connection details

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}

$desiredToolId = 11; // The specific tool ID you want to display

$stmt = mysqli_prepare($db, "SELECT id, tool_name, quantity, def, category_name, category_id FROM tools");

// Check if statement preparation was successful
if (!$stmt) {
  echo "Error preparing statement: " . mysqli_error($db);
  exit();
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>CPE TOOL</title>
  <script src="borrowItems.js"></script>
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
  <script src="borrowItems.js"></script>

</head>

<body>

  <!-- ======= Navbar ======= -->
  <div class="collapse navbar-collapse custom-navmenu" id="main-navbar">
    <div class="container py-2 py-md-5">
      <div class="row align-items-start">
        <div class="col-md-2">
          <ul class="custom-menu">
            <li><a href="index.html">Home</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <nav class="navbar navbar-light custom-navbar">
    <div class="container">
      <a class="navbar-brand" href="index.html">CPE Hand Tool</a>
      <span></span>
    </div>
  </nav>

  <main id="main">

    <section class="section">
      <div class="container">
        <div class="row mb-4 align-items-center">
          <div class="col-md-6" data-aos="fade-up">
            <?php
            $toolFound = false;
            while ($row = $result->fetch_assoc()) {
              if ($row['id'] == $desiredToolId) {
                $toolFound = true;
                $toolId = $row['id'];
                $toolName = $row['tool_name'];
                $def = $row['def'];
                $quantity = $row['quantity'];
                $categoryId = $row['category_id'];
                $categoryName = $row['category_name'];

                echo "<section class='section'>";
                echo "<div class='container'>";
                echo "  <div class='row mb-4 align-items-center'>";
                echo "    <div class='col-md-6' data-aos='fade-up'>";
                echo "      <div class='card'>";
                echo "        <h2>$toolName</h2>";
                echo "        <p>Id: $toolId</p>";
                echo "        <p>Description: $def</p>";
                echo "        <p>Quantity: $quantity</p>";
                echo "        <p>Category: $categoryId</p>";
                echo "        <p>Category: $categoryName</p>";
                echo "        <a href='http://localhost/Inventory_System/login/student_borrowed.php?tool_id=$toolId' class='btn btn-primary'>Borrow Tool</a>";
                echo "      </div>";
                echo "    </div>";
                echo "  </div>";
                echo "</div>";
                echo "</section>";
                break;
              }
            }

            if (!$toolFound) {
              echo "The desired tool (ID: $desiredToolId) was not found in the database.";
            }

            mysqli_stmt_close($stmt);
            mysqli_close($db);
            ?>
          </div>
        </div>
      </div>
    </section>

    <div class="site-section pb-0">
      <div class="container">
        <div class="row align-items-stretch">
          <div class="col-md-8" data-aos="fade-up">
            <img src="assets/img/Resistor.jpg" alt="Image" class="img-fluid" style="width: 500px; height: 350px;">
          </div>
          <div class="col-md-3 ml-auto" data-aos="fade-up" data-aos-delay="100">
          </div>
        </div>
      </div>
    </div>
  </main>

  <footer>
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center">
          <p>&copy; 2024 CPE Hand Tools. All Rights Reserved.</p>
        </div>
      </div>
    </div>
  </footer>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

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
