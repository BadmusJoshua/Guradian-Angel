<?php
include 'inc/config/database.php';
// Delete all active sessions
session_start();
session_destroy();
if (isset($_COOKIE['remember_token'])) {
    $token = $_COOKIE['remember_token'];

    //delete token from database
    $sql = "DELETE FROM remember_me WHERE token = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$token]);

    //delete the remember_token cookie
    setcookie('remember_token', '', time() - 3600);
}
// Redirect to the login page
header("Location: admin-login.php");
exit;
