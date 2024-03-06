<?php
include 'inc/config/database.php';
//checks if subscribe button is hit
if (isset($_POST['subscribe'])) {
  //checks if email field is filled
  if (!empty($_POST['email'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    //adds email to newsletter table
    $sql = "INSERT into newsletter (email) value (?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Guardian Angel</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png" />
  <!-- <link rel="stylesheet" href="assets/css/styles.min.css" /> -->
  <!-- <link rel="stylesheet" href="assets/css/styles.css" /> -->


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
              <li class="active"><a href="index.php" class="nav-link">Home</a></li>
              <li><a href="about.php" class="nav-link">About Us</a></li>
              <li><a href="login.php" class="nav-link">Login</a></li>
              <li><a href="signup.php" class="nav-link">SignUp</a></li>
              <li><a href="contact.php" class="nav-link">Contact</a></li>
              <li><a href="admin-login.php" class="nav-link">Admin</a></li>
            </ul>
          </nav>


          <div class="ml-auto toggle-button d-inline-block d-lg-none"><a href="#" class="site-menu-toggle py-5 js-menu-toggle text-white"><span class="icon-menu h3 text-white"></span></a></div>



        </div>
      </div>

    </header>

    <div class="owl-carousel-wrapper">
      <div class="box-92819 d-flex flex-column margin-auto justify-content-center align-items-center">
        <h1 class="text-white mb-3 text-center">Report. Protect. Empower. Every child deserves safety.</h1>
        <p><a href="login.php" class="btn btn-primary py-3 px-4 rounded-0 mx-auto">Report Now</a></p>
      </div>

      <div class="owl-carousel owl-1 ">
        <div class="ftco-cover-1 overlay" style="background-image: url('images/hero_1.jpg'); "></div>
        <div class="ftco-cover-1 overlay" style="background-image: url('images/hero_2.jpg');"></div>
        <div class="ftco-cover-1 overlay" style="background-image: url('images/hero_3.jpg');"></div>
      </div>
    </div>


    <div class="container">
      <div class="feature-29192-wrap d-md-flex" style="margin-top: 170px; ">

        <a href="#" class="feature-29192 overlay-danger" style="background-image: url('images/abandonment.jpeg');">
          <div class="text">
            <h3 class="text-cursive text-white h1">Physical Abuse</h3>
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

    <div class="site-section mb-0">
      <div class="container">
        <div class="d-md-flex cta-20101 align-self-center bg-light p-3">
          <div class="">
            <h4 class="text-cursive">"Children are the world's most valuable resource and it's best hope for the future." - John F. Kennedy</h4>
          </div>
        </div>

      </div>
    </div>

    <div class="site-section mt-1">
      <div class="container">
        <div class="bg-image overlay site-section" style="background-image: url('images/hero_1.jpg');">
          <div class="container">

            <div class="row align-items-center">
              <div class="col-12">
                <div class="row mb-5">
                  <div class="col-md-7">
                    <div class="heading-20219">
                      <h2 class="title text-white mb-4 text-cursive">What should you report?</h2>
                      <p class="text-white">Child abuse can take various forms, and it's crucial to understand the different types of offenses that constitute child abuse. Here are some offenses that fall under child abuse:</p>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 mb-5">
                    <div class="feature-29012 d-flex">
                      <div class="number mr-4"><span>1</span></div>
                      <div>
                        <h3>Physical Abuse:</h3>
                        <p>Involves causing physical harm or injury to a child through actions such as hitting, kicking, burning, shaking, or any form of physical violence.</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 mb-5">
                    <div class="feature-29012 d-flex">
                      <div class="number mr-4"><span>2</span></div>
                      <div>
                        <h3>Sexual Abuse:</h3>
                        <p>Involves any form of sexual activity or exposure imposed on a child, including inappropriate touching, sexual exploitation, molestation, or exposing a child to sexual content or acts.</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6 mb-5">
                    <div class="feature-29012 d-flex">
                      <div class="number mr-4"><span>3</span></div>
                      <div>
                        <h3>Child Labor:</h3>
                        <p>Exploiting a child for labor that is harmful to their physical or mental health, safety, or interferes with their education and development.</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 mb-5">
                    <div class="feature-29012 d-flex">
                      <div class="number mr-4"><span>4</span></div>
                      <div>
                        <h3>Medical Neglect:</h3>
                        <p>Failure to provide necessary medical or mental health treatment for a child's well-being, leading to physical or emotional harm.</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 mb-5">
                    <div class="feature-29012 d-flex">
                      <div class="number mr-4"><span>5</span></div>
                      <div>
                        <h3>Abandonment:</h3>
                        <p>Leaving a child without proper care, supervision, or support, thereby endangering their physical or emotional health.</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 mb-5">
                    <div class="feature-29012 d-flex">
                      <div class="number mr-4"><span>6</span></div>
                      <div>
                        <h3>Trafficking and Exploitation:</h3>
                        <p>Involves the recruitment, transportation, or exploitation of a child for labor, sexual purposes, or illegal activities.</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

      <div class="site-section">
        <div class="container">

          <div class="d-md-flex cta-20101 align-self-center bg-light p-3">
            <div class="">
              <h4 class="text-cursive">"The child must know that he is a miracle, that since the beginning of the world there hasn't been, and until the end of the world there will not be, another child like him." - Pablo Casals</h4>
            </div>
          </div>

        </div>
      </div>

      <footer class="site-footer bg-white m-0 p-0">
        <div class="container">
          <div class="row">
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-7">
                  <h2 class="footer-heading mb-4">About Us</h2>
                  <p>At Guardian Angel, our dedication is to ensure every child lives in
                    safety, free from abuse and neglect.</p>

                </div>
                <div class="col-md-4 ml-auto">
                  <h2 class="footer-heading mb-4">Features</h2>
                  <ul class="list-unstyled">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="signup.php">SignUp</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="admin-login.php">Admin</a></li>
                  </ul>
                </div>

              </div>
            </div>
            <div class="col-md-4 ml-auto">

              <div class="mb-5">
                <h2 class="footer-heading mb-4">Subscribe to Newsletter</h2>
                <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" class="footer-subscribe-form">


                  <div class="col-12">
                    <label for="yourName" class="form-label">Email</label>
                    <div class="input-group">
                      <input type="text" name="email" class="form-control form-control rounded-0 border-secondary bg-transparent" id="yourName" required value="" aria-describedby="button-addon2">
                      <div class="input-group-append">
                        <button class="btn btn-primary text-white" id="button-addon2" name="subscribe" type="submit">Subscribe</button>
                      </div>
                    </div>
                  </div>
                </form>



              </div>


              <h2 class="footer-heading mb-4">Follow Us</h2>
              <a href="#about-section" class="smoothscroll pl-0 pr-3"><span class="icon-facebook"></span></a>
              <a href="#" class="pl-3 pr-3"><span class="icon-twitter"></span></a>
              <a href="#" class="pl-3 pr-3"><span class="icon-instagram"></span></a>
              <a href="#" class="pl-3 pr-3"><span class="icon-linkedin"></span></a>
              </form>
            </div>
          </div>
          <div class="row pt-5 mt-5 text-center">
            <div class="col-md-12">
              <div class="pt-5">
                <p>Copyright &copy;<script>
                    document.write(new Date().getFullYear());
                  </script> All rights reserved</p>
              </div>
            </div>

          </div>
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