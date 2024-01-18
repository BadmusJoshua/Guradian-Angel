<?php
require 'inc/header/admin-header.php';
$user = $username = $passwordErr = $email = '';
if (isset($_POST['signUp'])) {
  if (!empty($_POST['username'])) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  }
  if (!empty($_POST['email'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  }
  if (!empty($_POST['password'])) {
    $password = ($_POST['password']);
    if (strlen($password) >= 8) {
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);
      //checking if email is available
      $sql = "SELECT * FROM admins WHERE email = ?";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$email]);
      $userCount = $stmt->rowCount();
      //if email has been used
      if ($userCount === 1) {
        $user = 1;
        //check if username is available
      } else {
        $sql = "SELECT * FROM admins WHERE username = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username]);
        $usernameCount = $stmt->rowCount();
        // if username has been used 
        if ($usernameCount === 1) {
          $username = 1;
          // if username and email are available
        } else {
          // save details into admin table
          $sql = "INSERT INTO admins (username,email,password) VALUES (?,?,?)";
          $stmt = $pdo->prepare($sql);
          $stmt->execute([$username, $email, $hashed_password]);
          $detail = $stmt->fetch(PDO::FETCH_ASSOC);
          $adminId = $detail['id'];
        }
      }
    } else {
      $passwordErr = 1;
    }
  }
}

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Guardian Angel</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/adminos/favicon.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">

      <div class="container-fluid">
        <!--  Row 1 -->
        <div class="row">
          <div class="col-lg-8 d-flex align-items-stretch">
            <div class="card w-100">
              <div class="card-body w-100">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9 w-100">
                  <div class="table-responsive w-100">
                    <h5 class="card-title fw-semibold text-center">List of Admins</h5>
                    <table class="table text-nowrap mb-0 align-middle w-100">
                      <thead class="text-dark fs-4">
                        <tr>
                          <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Id</h6>
                          </th>
                          <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Username</h6>
                          </th>
                          <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Category</h6>
                          </th>
                          <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Status</h6>
                          </th>
                          <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Created at</h6>
                          </th>
                          <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Actions</h6>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $sql = 'SELECT * FROM admins WHERE 1';
                        $stmt = $pdo->prepare($sql);
                        // $stmt->execute([$userId]);
                        $admins = $stmt->fetchAll();
                        // $n = 0;
                        if ($admins) {
                          foreach ($admins as $details) :
                        ?>
                            <tr>
                              <td class="border-bottom-0">
                                <h6 class="fw-semibold mb-0"><?= $details->id ?></h6>
                              </td>
                              <td class="border-bottom-0">
                                <h6 class="fw-semibold mb-1"><?= $details->username ?></h6>
                              </td>
                              <td class="border-bottom-0">
                                <p class="mb-0 fw-normal"><?php if ($details->superadmin === 0) {
                                                            echo "Admin";
                                                          } else {
                                                            echo "Super-Admin";
                                                          } ?></p>
                              </td>
                              <td class="border-bottom-0">
                                <p class="mb-0 fw-normal"><?php if ($details->disabled === 0) {
                                                            echo "Active";
                                                          } else {
                                                            echo "Disabled";
                                                          } ?></p>
                              </td>
                              <td class="border-bottom-0">
                                <h6 class="fw-semibold mb-0 fs-4"> <?= $details->created ?></h6>
                              </td>
                              <td class="border-bottom-0">
                                <h6 class="fw-semibold mb-0 fs-4"> <?= $details->updated ?></h6>
                              </td>
                              <td class="border-bottom-0">
                                <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                                  <input type="hidden" name="id" value="<?= $details->id ?>">
                                  <button class="btn btn-sm btn-success">Make SA</button>
                                  <button class="btn btn-sm btn-danger">Disabled</button>
                                  <button class="btn btn-sm btn-primary">Edit</button>
                                  <button class="btn btn-sm btn-secondary">Enabled</button>
                                </form>
                              </td>
                            </tr>
                        <?php endforeach;
                        } else {
                          echo '<div class="alert alert-danger text-center" role="alert">
                    Oops! No admins yet, maybe you need to sign up first.
                  </div>';
                        }
                        ?>





                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="row">
              <div class="col">
                <!-- Yearly Breakup -->
                <div class="card overflow-hidden">
                  <div class="card mb-0">
                    <div class="card-body">

                      <p class="card-title fw-semibold text-center">Add new admin</p>
                      <form method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                        <?php
                        if ($user) {
                          echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                          Account already exists!
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                        }
                        if ($username) {
                          echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                          Sorry, this username is unavailable!
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                        }
                        if ($passwordErr) {
                          echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                          Your password must have at least 8 characters!
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                        }
                        ?>
                        <div class="mb-3">
                          <label for="exampleInputtext1" class="form-label">Username</label>
                          <input type="text" class="form-control" id="exampleInputtext1" aria-describedby="textHelp" name="username" value="<?= $username ?>">
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputEmail1" class="form-label">Email Address</label>
                          <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" value="<?= $email ?>" required>
                        </div>
                        <div class="mb-4">
                          <label for="exampleInputPassword1" class="form-label">Password</label>
                          <input type="password" class="form-control" id="exampleInputPassword1" name="password" required>
                        </div>
                        <button class="btn btn-success w-100 py-8 fs-4 mb-4 rounded-2" name="signUp">Register</button>
                      </form>
                    </div>
                  </div>
                </div>


              </div>
            </div>
            <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
            <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>