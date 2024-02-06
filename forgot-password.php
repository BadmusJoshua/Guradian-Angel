<?php
include 'inc/config/database.php';
$not_found = $mail_unsent = $mail_sent = $email = $phoneNumber = "";

if (isset($_POST['reset'])) {
    //sanitizing input
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phoneNumber = filter_input(INPUT_POST, 'phoneNumber', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if (!empty($email && $phoneNumber)) {

        $token = bin2hex(random_bytes(32)); //Generate a random token
        $expires_at = date('Y-m-d H:i:s', strtotime('+15 minutes')); //Set the expiration time to 15 minutes from creation time

        //authenticating user
        $sql = "SELECT * FROM clients WHERE email = ? AND phone = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email, $phoneNumber]);
        $user = $stmt->fetch();
        // $userEmail = $user->email;
        $userCount = $stmt->rowCount();
        if ($userCount == '1') {

            //Update the password_reset_token column in the database
            $stmt = $pdo->prepare("UPDATE clients SET password_reset_token = ?, password_reset_expires_at = ? WHERE email = ? AND phone = ?");
            $stmt->execute([$token, $expires_at, $email, $phoneNumber]);

            //creating reset link
            $reset_link = "http://localhost/guardian-angel/guardian-angel/forgot-password.php?token=$token";

            $receiver = $email;
            $subject = 'Testing Password Reset';
            $message = '<div style="width:80%;border:1px solid black; margin:auto;padding:10px;">Click on the following link to reset your password<br> <b> <a href="http://localhost/guardian-angel/guardian-angel/new_password.php?token=' . $token . '">Password Reset<a></b><br>This token expires at ' . $expires_at . '</div>';

            require 'inc/config/mailer-config.php';


            sendMail($email, $subject, $response);
            if (!$mail->send()) {
                $unsent = 1;
            } else {
                $sql = "UPDATE contactus SET response = ? , replied = ?,attendedBy = ? WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$response, '1', $adminId, $messageId]);
                $sent = 1;
            }
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
                                <p class="text-center w-100 d-flex m-auto">Enter Account details to verify its you.</p>
                                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                                    <?php
                                    if ($not_found) {
                                        echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                          Account not found, check details! 
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                                    }
                                    if ($mail_sent) {
                                        echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert">
                          Check your email for your password reset token
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                                    }
                                    if ($mail_unsent) {
                                        echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                          Sending mail failed, try again later
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                                    }
                                    ?>
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" value="<?= $email ?>" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="exampleInputPhone" class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control" id="exampleInputPhone" name="phoneNumber" value="<?= $phoneNumber ?>" required>
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