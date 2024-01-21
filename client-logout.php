<?php
include 'inc/config/database.php';
// Delete all active sessions
session_start();
session_destroy();

// Redirect to the login page
header("Location: login.php");
exit;
