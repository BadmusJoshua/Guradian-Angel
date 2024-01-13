<?php
require 'inc/config/database.php';
$notFound = $passwordErr = '';
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
      session_start();
      $_SESSION['id'] = $adminId;
      echo $_SESSION['id'];
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
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
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
                      <input class="form-check-input primary" type="checkbox" value="" id="flexCheckChecked" checked>
                      <label class="form-check-label text-dark" for="flexCheckChecked">
                        Remember this Device
                      </label>
                    </div>
                    <a class="text-success fw-bold" href="./index.html">Forgot Password ?</a>

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
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>