<?php
include "admin_connect1.php";

// Check if user is logged in (replace with your authentication logic)
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
  echo json_encode(array("error" => "Unauthorized access. Please login."));
  exit();
}

$toolId = isset($_POST['tool_id']) ? intval($_POST['tool_id']) : 0;
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;

if ($toolId > 0 && $quantity > 0) {
  $studentId = $_SESSION['user_id']; // Retrieve student ID from session

  $borrowedDate = date('Y-m-d'); // Today's date

  // Prepared statement to prevent SQL injection (recommended)
  $stmt = mysqli_prepare($db, "INSERT INTO borrowed_items (student_id, id_tool, borrowed_date, quantity) VALUES (?, ?, ?, ?)");
  mysqli_stmt_bind_param($stmt, "iiii", $studentId, $toolId, $borrowedDate, $quantity);

  if (mysqli_stmt_execute($stmt)) {
    echo json_encode(array("message" => "Item borrowed successfully!"));
  } else {
    echo json_encode(array("error" => "Failed to add item: " . mysqli_error($db)));
  }

  mysqli_stmt_close($stmt);
} else {
  echo json_encode(array("error" => "Invalid data provided."));
}

mysqli_close($db);
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

  

<body>

  <!-- ======= Navbar ======= -->
  <div class="collapse navbar-collapse custom-navmenu" id="main-navbar">
    <div class="container py-2 py-md-5">
      <div class="row align-items-start">
        <div class="col-md-2">
          <ul class="custom-menu">
            <li><a href="index.html">Home</a></li>
          
        </div>
        
      </div>

    </div>
  </div>

  <nav class="navbar navbar-light custom-navbar">
    <div class="container">
      <a class="navbar-brand" href="index.html">CPE Hand Tools.</a>
      <a href="#" class="burger" data-bs-toggle="collapse" data-bs-target="#main-navbar">
        <span></span>
      </a>
    </div>
  </nav>

  <main id="main">

    <section class="section">
      <div class="container">
        <div class="row mb-4 align-items-center">
          <div class="col-md-6" data-aos="fade-up">
            <h2>Wire Cutter</h2>
            <p>-A wire cutter is a hand tool designed for cutting wires and cables. It typically consists of two sharp blades that are forced together to cleanly cut through the wire.
            </p>
          </div>
        </div>
      </div>

      <div class="site-section pb-0">
        <div class="container">
          <div class="row align-items-stretch">
            <div class="col-md-8" data-aos="fade-up">
            <img src="assets/img/Wire Cutter.jpg" alt="Image" class="img-fluid" >
            </div>
            <div class="col-md-3 ml-auto" data-aos="fade-up" data-aos-delay="100">
              

               

                <button id="borrow-item-btn">Borrow Item</button>
          <div id="borrowed-items-list"></div>
              <script>
                // Placeholder Javascript for demonstration
                  document.getElementById('borrow-item-btn').addEventListener('click', function() {
                // Simulate AJAX request
                  console.log("Borrowing item...");
                // Update borrowed-items-list using Javascript (replace with actual logic)
                  document.getElementById('borrowed-items-list').innerHTML += "<li>Wire Cutter (1)</li>";
                });
              </script>
                
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>

 

            <!--
            All the links in the footer should remain intact.
            You can delete the links only if you purchased the pro version.
            Licensing information: https://bootstrapmade.com/license/
            Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=MyPortfolio
          -->
          </div>
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