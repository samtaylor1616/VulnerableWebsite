<?php
/* Purpose: Checks the user is logged in otherwise send them to the login page */
  require_once("db.php");
  session_start();

  if (isset($_SESSION['username']) && isset($_SESSION['id'])) {
    $usernameSet = $_SESSION['username'];
    $idSet = $_SESSION['id'];
  
    $sql = "SELECT * FROM users WHERE username = '$usernameSet' AND id = '$idSet'";
    $result = mysqli_query($db, $sql);
    $count = mysqli_num_rows($result);
    if ($count !== 1) {
      header("location: index.php");
      die();
    }
  } else {
    // Otherwise the user is not logged in
    header("location: index.php");
    die();
  }
?>