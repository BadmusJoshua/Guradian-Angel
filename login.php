<?php
$passwordErr = $userNotFound = '';
if (isset($_POST['login'])) {
  if (!empty($_POST['email'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  }
  if (!empty($_POST['password'])) {
    $password = $_post['password'];
  }
  //checking email
  $sql = "SELECT * FROM clients WHERE email = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$email]);
  $userCount = $stmt->rowCount();
  if ($userCount > 0) {
    // Fetch user password
    $id_fetch = "SELECT * FROM clients WHERE email = ?";
    $stmt = $pdo->prepare($id_fetch);
    $stmt->execute([$email]);
    $detail = $stmt->fetch(PDO::FETCH_ASSOC);
    $hashedPassword = $detail['password'];
    $Id = $detail['id'];
    // Verify if the input password matches the hashed password
    if (password_verify($password, $hashedPassword)) {
      // Passwords match, perform the desired action (e.g., grant access)
      session_start();
      $_SESSION['id'] = $Id;
      Header("Location:complaint.php");
    } else {
      // Passwords do not match
      $passwordErr = 1;
    }
  } else {
    $userNotFound = 1;
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Guardian Angel</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <link href="https://fonts.googleapis.com/css?family=Mansalva|Roboto&display=swap" rel="stylesheet" />

  <link rel="stylesheet" href="fonts/icomoon/style.css" />

  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/animate.min.css" />
  <link rel="stylesheet" href="css/jquery.fancybox.min.css" />
  <link rel="stylesheet" href="css/owl.carousel.min.css" />
  <link rel="stylesheet" href="css/owl.theme.default.min.css" />
  <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css" />
  <link rel="stylesheet" href="css/aos.css" />

  <!-- MAIN CSS -->
  <link rel="stylesheet" href="css/style.css" />
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

          <nav class="site-navigation text-left ml-auto" role="navigation">
            <ul class="site-menu main-menu js-clone-nav ml-auto d-none d-lg-block">
              <li><a href="index.php" class="nav-link">Home</a></li>
              <li><a href="about.php" class="nav-link">About Us</a></li>
              <li><a href="causes.php" class="nav-link">Our Causes</a></li>
              <li class="active">
                <a href="login.php" class="nav-link">Login</a>
              </li>
              <li><a href="signup.php" class="nav-link">SignUp</a></li>
              <li><a href="contact.php" class="nav-link">Contact</a></li>
            </ul>
          </nav>

          <div class="ml-auto toggle-button d-inline-block d-lg-none">
            <a href="#" class="site-menu-toggle py-5 js-menu-toggle text-white"><span class="icon-menu h3 text-white"></span></a>
          </div>
        </div>
      </div>
    </header>

    <div class="row justify-content-center align-items-md-center mx-auto mt-4 mb-4" style="width: 70%; height: 90vh; overflow: hidden">
      <div class="col-md-6 col-sm-12 d-block" style="height: 100%">
        <div class="wrapper" style="height: 100%">
          <div class="owl-carousel owl-1" style="height: 100%">
            <div class="ftco-cover-1" style="
                  background-image: url('images/jakayla-toney-Zjx73GhhCaw-unsplash.jpg');
                  height: 100%;
                "></div>
            <div class="ftco-cover-1" style="
                  background-image: url('images/kiana-bosman-0pB01U2NDCQ-unsplash.jpg');
                  height: 100%;
                "></div>
            <div class="ftco-cover-1" style="
                  background-image: url('images/girl-sitting-stack-books.jpg');
                  height: 100%;
                "></div>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-sm-12 bg-white">
        <h3 class="mb-4 text-cursive text-center">Guardian Angel</h3>
        <span>
          <p class="text-center">
            Enter your login details to report incidence
          </p>
        </span>
        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
          <?php
          if ($passwordErr) {
            echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                          Incorrect Password! 
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
          }
          ?>
          <div class="form-group">
            <input type="email" class="form-control" placeholder="Email" name="email" />
          </div>
          <div class="form-group">
            <input type="password" class="form-control" placeholder="Enter your password" name="password" />
          </div>
          <div class="form-group d-flex flex-column justify-content-center">
            <button class="btn btn-primary" type="submit" name="login">Login</button>
            <p class="text-center">
              <a href="signup.php">Don't have an account yet? SignUp</a>
            </p>
          </div>
        </form>
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