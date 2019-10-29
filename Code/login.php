<?php
/*
 * File: login.php
 * Author: Samantha Taylor
 * -----
 * Purpose: File contains helper functions for
 * creating and logging in users
*/
function pwdMatch($pwd1, $pwd2) {
  $doesMatch = false;
  if ($pwd1 === $pwd2) {
    $doesMatch = true;
  }
  return $doesMatch;
}

// Creates a user with a unique username into the db table users
function createUser($db, $username, $password) {
  $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
  $resultStr = "";

  if (mysqli_multi_query($db, $sql)) {
    $resultStr = "Successfully created: " . $username;
  } else {
    $resultStr = "Could not create a new user: " . mysqli_error($db);
  }

  return $resultStr;
}

// Checks if the provided username and password match in the db
function loginUser($db, $username, $pwd) {
  $password = md5($pwd);
  $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";

  $result = mysqli_query($db, $sql);
  $count = mysqli_num_rows($result);

  $isLoggedIn = false;
  if ($count === 1) {
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC); // Associative array

    if ($row["userEnabled"]) {
      $id = $row["id"];
      $isAdmin = $row["isAdmin"];
      startSession($id, $username, $isAdmin);
      $isLoggedIn = true;
    } else {
      echo "<h5>Users account is disabled</h5>";
    }
  }

  return $isLoggedIn;
}

function startSession($id, $username, $isAdmin) {
  $_SESSION['username'] = $username;
  $_SESSION['id'] = $id;

  // If the user has the admin flag set to true add it to the session
  if ($isAdmin) {
    $_SESSION['isAdmin'] = true;
  }

  header("location: welcomePage.php");
}

?>
