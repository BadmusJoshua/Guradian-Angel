<?php
include 'inc/config/database.php';
$sent   = $fullname = $email = $message = '';
if (isset($_POST['submit'])) {
  //checking if name field isn't empty
  if (!empty($_POST['fullname'])) {
    $fullname = filter_input(INPUT_POST, 'fullname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  }
  //checking if email is provided
  if (!empty($_POST['email'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  }
  //checking and sanitizing message
  if (!empty($_POST['message'])) {
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  }

  $sql = "INSERT INTO contactus (fullname, email, message) VALUES (?,?,?)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$fullname, $email, $message]);
  $sent = 1;
  // exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Guardian &mdash; Angel</title>
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
              <li><a href="login.php" class="nav-link">Login</a></li>
              <li>
                <a href="signup.php" class="nav-link">SignUp</a>
              </li>
              <li class="active">
                <a href="contact.php" class="nav-link">Contact</a>
              </li>
            </ul>
          </nav>
          <div class="ml-auto toggle-button d-inline-block d-lg-none">
            <a href="#" class="site-menu-toggle py-5 js-menu-toggle text-white"><span class="icon-menu h3 text-white"></span></a>
          </div>
        </div>
      </div>
    </header>

    <div class="owl-carousel-wrapper mb-md-5">
      <div class="box-92819">
        <h1 class="text-white mb-3">Contact</h1>
        <p class="lead text-white">
          Reporting abuse is the first step toward healing and justice. Every
          report matters. Every child deserves protection. Don't look away!
          Report to protect vulnerable children. No child should suffer in
          silence. Report for their safety.
        </p>
      </div>

      <div class="ftco-cover-1 overlay" style="background-image: url('images/hero_3.jpg')"></div>
    </div>

    <div class="site-section w-75 d-flex mx-auto mt-md-5" style="
          box-shadow: 0px 1px 3px 3px rgba(47, 215, 35, 0.3);
          height: fit-content;
        ">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-sm-12">
            <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
              <?php
              if ($sent) {
                echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert">
                          Message sent!
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
              }
              ?>
              <div class="form-group row">
                <div class="col-12 mb-4 mb-md-0">
                  <input type="text" class="form-control" placeholder="Full name" name="fullname" value="<?= $fullname ?>" required />
                </div>
              </div>

              <div class="form-group row">
                <div class="col-12">
                  <input type="email" class="form-control" placeholder="Email address" name="email" value="<?= $email ?>" required />
                </div>
              </div>

              <div class="form-group row">
                <div class="col-12">
                  <textarea name="message" id="" class="form-control" placeholder="Write your message." cols="30" rows="10" required value="<?= $message ?>"></textarea>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-6 d-flex m-auto">
                  <input type="submit" class="btn btn-block btn-primary text-white py-3 px-5 rounded-0" value="Send Message" name="submit" />
                </div>
              </div>
            </form>
          </div>
          <div class="col-lg-4 ml-auto">
            <div class="bg-white p-3 p-md-5">
              <h3 class="text-cursive mb-4">Contact Info</h3>
              <ul class="list-unstyled footer-link">
                <li class="d-block mb-3">
                  <span class="d-block text-muted small text-uppercase font-weight-bold">Address:</span>
                  <span>34 Freeman, Lagos, Nigeria</span>
                </li>
                <li class="d-block mb-3">
                  <span class="d-block text-muted small text-uppercase font-weight-bold">Phone:</span><span>+234 913 5864 525</span>
                </li>
                <li class="d-block mb-3">
                  <span class="d-block text-muted small text-uppercase font-weight-bold">Email:</span><span>info@guardianangel.com</span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">
        <div class="d-md-flex cta-20101 align-self-center bg-light p-5">
          <div class="">
            <h2 class="text-cursive">
              Helping the Homeless, Hungry, and Hurting Children
            </h2>
          </div>
          <div class="ml-auto">
            <a href="#" class="btn btn-primary">Donate Now</a>
          </div>
        </div>
      </div>
    </div>

    <footer class="bg-white">
      <div class="">
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
  </div>

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