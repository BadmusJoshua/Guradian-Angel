<?php
require 'inc/config/database.php';
$notFound = $passwordErr = $Expired_token = $token_lost = '';

// Check if the user has a valid remember token
if (isset($_COOKIE['remember_token'])) {
  $token = $_COOKIE['remember_token'];

  // Validate the token against the database or any other persistent storage
  $sql = "SELECT * FROM remember_me WHERE token  = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$token]);
  $user = $stmt->rowCount();

  //if token found
  if ($user === 1) {
    //fetching the user id
    $user_details = $stmt->fetch();
    $adminId = $user_details->user_id;

    // Calculate the expiration timestamp by adding 30 days to the token creation time
    $expirationTimestamp = strtotime($user_details->created_at) + (30 * 24 * 60 * 60);

    // Check if the current time is less than the expiration timestamp
    $tokenIsValid = time() < $expirationTimestamp;

    if ($tokenIsValid) {
      // Token is valid, authenticate the user

      // Redirect the user to the welcome page
      session_start();
      $_SESSION['id'] = $adminId;
      Header("Location:admin-index.php");
    } else {
      //delete token from database
      $sql = "DELETE FROM remember_me WHERE token = ?";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$token]);

      //delete the remember_token cookie
      setcookie('remember_token', '', time() - 3600);
      $Expired_token = 1;
    }
  } else {
    //delete token from database
    $sql = "DELETE FROM remember_me WHERE token = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$token]);

    //delete the remember_token cookie
    setcookie('remember_token', '', time() - 3600);
    $token_lost = 1;
  }
}

//when user tries to sign in
if (isset($_POST['signIn'])) {
  if (!empty($_POST['username'])) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  }
  if (!empty($_POST['password'])) {
    $password = ($_POST['password']);
  }

  $sql = "SELECT * FROM admins WHERE username = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$username]);
  $userCount = $stmt->rowCount();
  if ($userCount === 1) {
    $sql = "SELECT * FROM admins WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);
    $detail = $stmt->fetch(PDO::FETCH_ASSOC);
    $adminId = $detail['id'];
    $hashedPassword = $detail['password'];
    $verify = password_verify($password, $hashedPassword);
    if ($verify) {
      // Check if the "Remember Me" checkbox is checked
      if (isset($_POST['remember'])) {
        // Generate a random token for the user
        $token = bin2hex(random_bytes(20));

        // Set a cookie with the token that expires in 30 days
        setcookie('remember_token', $token, time() + (30 * 24 * 60 * 60));

        // Save the token in a database or any other persistent storage for future reference
        $sql = "INSERT into remember_me (token, user_id) VALUE (?,?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$token, $adminId]);
      }
      // Redirect the user to the dashboard
      session_start();
      $_SESSION['id'] = $adminId;
      Header("Location:admin-index.php");
    } else {
      $passwordErr = 1;
    }
  } else {
    $notFound = 1;
  }
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Guardian Angel</title>
  <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="assets/css/styles.min.css" />
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <p class="text-nowrap logo-img text-center d-block py-3 w-100"> Guardian Angel
                </p>
                <form method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                  <?php
                  if ($notFound) {
                    echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                          Account not found!
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                  }
                  if ($passwordErr) {
                    echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                          Incorrect Password!
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                  }
                  if ($Expired_token) {
                    echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                          Your token has expired! You have to SignIn.
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                  }
                  if ($token_lost) {
                    echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                          Invalid token! Please SignIn
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                  }
                  ?>
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Username</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="username" value="<?= $username ?>" required>
                  </div>
                  <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="password" required>
                  </div>
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                      <input class="form-check-input primary" type="checkbox" value="" id="flexCheckChecked" name="remember">
                      <label class=" form-check-label text-dark" for="flexCheckChecked">
                        Remember this Device
                      </label>
                    </div>
                    <a class="text-success fw-bold" href="./index.php">Forgot Password ?</a>

                  </div>
                  <button class="btn btn-success w-100 py-8 fs-4 mb-4 rounded-2" name="signIn">Sign In</button>

                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>