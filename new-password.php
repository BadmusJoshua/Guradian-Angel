<?php
require 'inc/config/database.php';
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    //Check if token exists in the db
    $sql = "SELECT * FROM clients WHERE password_reset_token = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$token]);
    $user = $stmt->rowCount();
    $userDetails = $stmt->fetch();
    $userId = $userDetails->id;
    if ($user == '1') {
        header("Location:input-new-password.php?token=$token?id=$userId");
    } else {
        header("Location:forgot-password.php?invalidToken=1");
    }
} else {
    header("Location:forgot-password.php?noToken=1");
}
