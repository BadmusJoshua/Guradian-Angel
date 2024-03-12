<?php
require 'inc/header/admin-header.php';
$user = $usernameErr = $passwordErr = $email = $updated = '';

//registering new admin
if (isset($_POST['Register'])) {
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
          $usernameErr = 1;
          // if username and email are available
        } else {
          // save details into admin table
          $sql = "INSERT INTO admins (username,email,password) VALUES (?,?,?)";
          $stmt = $pdo->prepare($sql);
          $stmt->execute([$username, $email, $hashed_password]);
        }
      }
    } else {
      $passwordErr = 1;
    }
  }
}

if (isset($_POST['super-admin'])) {
  $id = $_POST['id'];
  $sql = "UPDATE admins SET superadmin = 1 WHERE id = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$id]);
}
if (isset($_POST['enable'])) {
  $id = $_POST['id'];
  $sql = "UPDATE admins SET disabled = 0 WHERE id = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$id]);
}
if (isset($_POST['disable'])) {
  $id = $_POST['id'];
  $sql = "UPDATE admins SET disabled = 1 WHERE id = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$id]);
}
if (isset($_POST['edit'])) {
  $id = $_POST['id'];
  $sql = "SELECT * FROM admins WHERE id = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$id]);
  $adminDetails = $stmt->fetchALL(PDO::FETCH_ASSOC);
  $username = $adminDetails[0]['username'];
  $email = $adminDetails[0]['email'];
}
//updating admin details
if (isset($_POST['Update'])) {
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
      if ($userCount > 1) {
        $user = 1;
        //check if username is available
      } else {
        $sql = "SELECT * FROM admins WHERE username = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username]);
        $usernameCount = $stmt->rowCount();
        // if username has been used 
        if ($usernameCount > 1) {
          $usernameErr = 1;
          // if username and email are available
        } else {
          // save details into admin table
          $sql = "UPDATE admins SET username = ?, email = ?, password = ? WHERE id = ?";
          $stmt = $pdo->prepare($sql);
          $stmt->execute([$username, $email, $hashed_password, $id]);
          $updated = 1;
        }
      }
    } else {
      $passwordErr = 1;
    }
  }
}
?>


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
                            <h6 class="fw-semibold mb-0">Updated at</h6>
                          </th>
                          <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Actions</h6>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        //sql query to fetch all rows in the admin table
                        $sql = "SELECT * FROM admins";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if ($admins) {
                          foreach ($admins as $details) :
                        ?>
                            <tr>
                              <td class="border-bottom-0">
                                <h6 class="fw-semibold mb-0"><?= $details['id'] ?></h6>
                              </td>
                              <td class="border-bottom-0">
                                <h6 class="fw-semibold mb-1"><?= $details['username'] ?></h6>
                              </td>
                              <td class="border-bottom-0">
                                <p class="mb-0 fw-normal"><?php if ($details['superadmin'] === 0) {
                                                            echo "Admin";
                                                          } else {
                                                            echo "Super-Admin";
                                                          } ?></p>
                              </td>
                              <td class="border-bottom-0">
                                <p class="mb-0 fw-normal"><?php if ($details['disabled'] === 0) { ?>
                                <div class="text-success">Active</div>
                              <?php } else { ?>
                                <div class="text-danger">Disabled</div>
                              <?php  } ?></p>
                              </td>
                              <td class="border-bottom-0">
                                <h6 class="fw-normal mb-0 text-wrap font-size-10"> <?= $details['created'] ?></h6>
                              </td>
                              <td class="border-bottom-0">
                                <h6 class="fw-normal mb-0  text-wrap font-size-10"> <?= $details['updated'] ?></h6>
                              </td>
                              <td class="border-bottom-0">
                                <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" class="text-wrap">
                                  <input type="hidden" name="id" value="<?= $details['id'] ?>">
                                  <button class="btn btn-sm btn-success" name="super-admin">SA</button>
                                  <button class="btn btn-sm btn-danger" name="disable">Disable</button>
                                  <button class="btn btn-sm btn-primary" name="edit">Edit</button>
                                  <button class="btn btn-sm btn-secondary" name="enable">Enable</button>
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

                      <p class="card-title fw-semibold text-center"><?php if (isset($_POST['edit'])) {
                                                                      echo 'Update admin details';
                                                                    } else {
                                                                      echo 'Add new admin';
                                                                    }  ?></p>
                      <form method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                        <?php
                        if ($user) {
                          echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                          Account already exists!
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                        }
                        if ($usernameErr) {
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
                        if ($updated) {
                          echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert">
                          Update Successful!
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                        }
                        ?>
                        <div class="mb-3">
                          <label for="exampleInputtext1" class="form-label">Username</label>
                          <input type="text" class="form-control" id="exampleInputtext1" aria-describedby="textHelp" name="username" value="<?= $username ?>" required>
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputEmail1" class="form-label">Email Address</label>
                          <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" value="<?= $email ?>" required>
                        </div>
                        <div class="mb-4">
                          <label for="exampleInputPassword1" class="form-label">Password</label>
                          <input type="password" class="form-control" id="exampleInputPassword1" name="password" required>
                        </div>
                        <button class="btn btn-success w-100 py-8 fs-4 mb-4 rounded-2" <?php if (isset($_POST['edit'])) {
                                                                                          echo 'name="Update"';
                                                                                        } else {
                                                                                          echo 'name = "Register"';
                                                                                        } ?>> <?php if (isset($_POST['edit'])) {
                                                                                                echo 'Update';
                                                                                              } else {
                                                                                                echo 'Register';
                                                                                              } ?></button>
                      </form>
                    </div>
                  </div>
                </div>


              </div>
            </div>
            <script src="assets/libs/jquery/dist/jquery.min.js"></script>
            <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
            <?php
            include 'inc/footer/admin-footer.php'; ?>