<?php
require 'inc/config/database.php';
$expired_token  = $passwordErr = $password_reset = $password_unmatch = '';


if (isset($_GET['token']) && ($_GET['id'])) {
    $token = $_GET['token'];
    $userId = $_GET['id'];
    if (isset($_POST['update_password'])) {

        $new_password = $_POST['new-password'];
        $confirm_password = $_POST['confirm-password'];

        $sql = "SELECT * FROM clients WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId]);
        $user = $stmt->fetch();

        if (strtotime($user->password_reset_expires_at) > time()) {

            if (strlen($new_password) > 8) {
            } else {
                $passwordErr = 1;
            }
            if (($new_password == $confirm_password)) {
                $new_password = password_hash($confirm_password, PASSWORD_DEFAULT);
            } else {
                $password_unmatch = 1;
            }

            $stmt = $pdo->prepare("UPDATE clients SET password = ?, password_reset_token = NULL, password_reset_expires_at = NULL WHERE id = ?");
            $stmt->execute([$new_password, $userId]);
            $password_reset = 1;
            //redirect to client homepage
            header("Location:complaint.php");
            exit;
        } else {

            $expired_token = 1;
            //redirect to client homepage
            header("Location:forgot-password.php");
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
    <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="assets/css/styles.min.css" />
    <link rel="stylesheet" href="assets\libs\bootstrap\dist\css\bootstrap.min.css" />
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
                                <p class="text-nowrap logo-img text-center d-block py-3 w-100 font-size-14  font-weight-bolder"> <img src="assets\images\logos\favicon.png" alt=""> <a href="index.php" style="text-decoration:none; color:black; font-weight:bolder;">Guardian Angel</a>
                                </p>
                                <p class="text-center w-100 d-flex m-auto">Enter new password to secure your account</p>
                                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                                    <?php
                                    if ($expired_token) {
                                        echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                          Token expired!
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                                    }
                                    if ($password_unmatch) {
                                        echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert">
                          Your passwords do not match!
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                                    }
                                    if ($passwordErr) {
                                        echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                          Your password must contain at least 8 characters
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                                    }
                                    ?>
                                    <div class="mb-3">
                                        <label for="exampleInputNew" class="form-label">New Password</label>
                                        <input type="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="new-password" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="exampleInputConfirm" class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control" id="exampleInputPhone" name="confirm-password" required>
                                    </div>

                                    <button class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2" name="reset">Reset Password</button>

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
    <script src="assets\libs\bootstrap\dist\js\bootstrap.js"></script>
</body>

</html>