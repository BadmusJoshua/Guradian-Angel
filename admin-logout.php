<?php
// Delete all active sessions
session_start();
session_destroy();

// Redirect to the login page
header("Location: admin-login.php");
exit;
