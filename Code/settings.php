<?php 
/*
 * Last Modified: Monday, 30rd September 2019 10:43:47 pm
 * Modified By: Samantha Taylor
 * -----
 * Purpose: Settings page
*/
require_once('validateSession.php');
// Include the php database configuration
require_once("db.php");
require_once("login.php");

if (!empty($_POST['currentPassword']) && !empty($_POST['newPassword']) && !empty($_POST['newPasswordConfirm'])) {
  $currentPassword = $_POST['currentPassword'];
  $newPassword = md5($_POST['newPassword']);
  $newConfirm = md5($_POST['newPasswordConfirm']);
  if ($newPassword === $newConfirm) {
    $userId = $_SESSION['id'];
    $username = $_SESSION['username'];
    $sql = "UPDATE users SET password = '$newPassword' WHERE id = '$userId' AND username = '$username'";

    $result = mysqli_multi_query($db, $sql);
    
    if ($result) {
      echo "<h5>Password has been updated</h5>";
    } else {
      echo "<h5>Password has NOT been successfully updated</h5>";
    }
  } else {
    echo "<h5>New passwords do not match</h5>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/settings.css">
  <title>Settings</title>
</head>

<body>
<?php
    $page = "Settings";
    require_once("navbar.php");
  ?>
  <div class="topImg" style="background-image: url(./assets/settings.jpeg);">
  </div>
  <div class="card settingsCard">

    <div class="col-md-10 mx-auto text-center">
      <div class="headerTitle">
        <h1 class="mainTitle">
          Change your password
        </h1>
      </div>
    </div>

    <div class="row">
      <div class="col-md-10 mx-auto">
        <form method="post">
        <div class="form-group">
            <input name="currentPassword" type="password" class="form-control my-input" id="currentPassword"
              placeholder="Current Password">
          </div>
          <div class="form-group">
            <input name="newPassword" type="password" class="form-control my-input" id="newPassword"
              placeholder="New Password">
          </div>
          <div class="form-group">
            <input name="newPasswordConfirm" type="password" class="form-control my-input" id="newPasswordConfirm"
              placeholder="Confirm Password">
          </div>
          <button class="btn loginBtn" type="submit">Update Password</button>
        </form>
      </div>
    </div>
  </div> <!-- END CARD -->

  </div>
</body>

</html>