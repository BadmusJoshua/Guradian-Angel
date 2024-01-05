<?php
include 'inc/config/database.php';
$userExist = $passwordErr = $name = $email = $phone = $address = '';

if (isset($_POST['submit'])) {
  echo "submitted";
  if (!empty($_POST['name'])) {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    echo $name;
  }
  if (!empty($_POST['email'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  }
  if (!empty($_POST['phone'])) {
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    echo $phone;
  }
  if (!empty($_POST['address'])) {
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  }
  if (!empty($_POST['password'])) {
    $password = $_POST['password'];

    // Password pattern for validation
    $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';

    if (preg_match($pattern, $password)) {
      // Password meets the criteria

      $hashed_password = password_hash($password, PASSWORD_DEFAULT);
      // Check if email exists
      $sqli = "SELECT * FROM clients WHERE email = ?";
      $stmt = $pdo->prepare($sqli);
      $stmt->execute([$email]);
      $userCount = $stmt->rowCount();

      if ($userCount > 0) {
        $userExist = 1;
      } else {
        $sql = "INSERT INTO clients (name, email, phone, address, password) VALUES (?,?,?,?,?) ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $email, $phone, $address, $hashed_password]);

        // Fetch user ID
        $id_fetch = "SELECT id FROM clients WHERE email = ?";
        $stmt = $pdo->prepare($id_fetch);
        $stmt->execute([$email]);
        $detail = $stmt->fetch(PDO::FETCH_ASSOC);
        $userId = $detail['id'];

        session_start();
        $_SESSION['id'] = $userId;
        header("Location: complaint.php");
        exit(); // Terminate script execution after redirect
      }
    } else {
      // Password doesn't meet the criteria
      $passwordErr = 1;
    }
  }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Guardian &mdash; Angel</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


  <link href="https://fonts.googleapis.com/css?family=Mansalva|Roboto&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="fonts/icomoon/style.css">

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/animate.min.css">
  <link rel="stylesheet" href="css/jquery.fancybox.min.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">
  <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
  <link rel="stylesheet" href="css/aos.css">

  <!-- MAIN CSS -->
  <link rel="stylesheet" href="css/style.css">

</head>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">


  <div class="site-wrap" id="home-section">

    <div class="site-mobile-menu site-navbar-target">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div>
    <header class="site-navbar site-navbar-target bg-secondary shadow" role="banner">

      <div class="container">
        <div class="row align-items-center position-relative">


          <div class="site-logo">
            <a href="index.php" class="text-white">Guardian Angel</a>
          </div>


          <nav class="site-navigation text-left ml-auto " role="navigation">
            <ul class="site-menu main-menu js-clone-nav ml-auto d-none d-lg-block">
              <li><a href="index.php" class="nav-link">Home</a></li>
              <li><a href="about.php" class="nav-link">About Us</a></li>
              <li><a href="causes.php" class="nav-link">Our Causes</a></li>
              <li><a href="login.php" class="nav-link">Login</a></li>
              <li class="active"><a href="signup.php" class="nav-link">SignUp</a></li>
              <li><a href="contact.php" class="nav-link">Contact</a></li>
            </ul>
          </nav>
          <div class="ml-auto toggle-button d-inline-block d-lg-none"><a href="#" class="site-menu-toggle py-5 js-menu-toggle text-white"><span class="icon-menu h3 text-white"></span></a></div>
        </div>
      </div>

    </header>

    <div class="container">
      <div class="feature-29192-wrap d-md-flex py-2">

        <a href="#" class="feature-29192 overlay-danger" style="background-image: url('images/abandonment.jpeg');">
          <div class="text">
            <h3 class="text-cursive text-white h1">Abandonment</h3>
          </div>
        </a>

        <a class="feature-29192 overlay-success" style="background-image: url('images/sexual\ assault.jpeg');">
          <div class="text">
            <h3 class="text-cursive text-white h1">Sexual Abuse</h3>
          </div>
        </a>

        <div class="feature-29192 overlay-warning" style="background-image: url('images/kid\ begging.jpeg');">
          <div class="text">
            <h3 class="text-cursive text-white h1">Neglect</h3>
          </div>
        </div>

      </div>
    </div>

    <div class="site-section bg-image overlay-primary" style="background-image: url('images/img_1.jpg');">
      <div class="container">
        <div class="row align-items-stretch d-flex">
          <div class="col-md-6 col-sm-12 m-auto">
            <div class="bg-white h-100 p-4 shadow">
              <h3 class="mb-4 text-cursive text-center">Signup Now</h3>
              <span>
                <p class="text-center">Reporting abuse isn't just an option; it's a responsibility.</p>
              </span>
              <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                <?php

                if ($userExist) {
                  echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                          Account already exists!
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                }
                if ($passwordErr) {
                  echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                          Password must have at least 8!
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                }
                ?>
                <div class="form-group">
                  <input type="text" class="form-control" placeholder="Name" name="name" value="<?= $name ?>" required>
                </div>

                <div class="form-group">
                  <input type="email" class="form-control" placeholder="Email" name="email" value="<?= $email ?>" required>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" placeholder="Address" name="address" value="<?= $address ?>" required>
                </div>
                <div class="form-group">
                  <input type="tel" class="form-control" placeholder="Phone Number" name="phone" value="<?= $phone ?>" required>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" placeholder="Password" name="password" required>
                </div>

                <div class="form-group d-flex flex-column justify-content-center">
                  <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                  <p class="text-center">
                    <a href="login.php">Have an account already? Login</a>
                  </p>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <footer class="bg-white">
      <div class="pt-5">
        <p class="text-center">
          By using Guardian Angel, you already agree to our terms. Copyright
          &copy;
          <script>
            document.write(new Date().getFullYear());
          </script>
          All rights reserved
        </p>
      </div>
    </footer>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/jquery.waypoints.min.js"></script>
    <script src="js/jquery.animateNumber.min.js"></script>
    <script src="js/jquery.fancybox.min.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script src="js/aos.js"></script>

    <script src="js/main.js"></script>

</body>

</html>