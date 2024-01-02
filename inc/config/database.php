<?php
$host = "localhost";
$username = "josh";
$password = "josh0574";
$db_name = "guardian-angel";

try {   // set DSN
  $dsn = "mysql:host=$host;dbname=$db_name;charset=UTF8";

  //new PDO instance
  $pdo = new PDO($dsn, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
  $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $ex) {
  die(json_encode(array('outcome' => false, 'message' => $ex->getMessage())));
}

//setting pdo attribute
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
echo 'seen database';
