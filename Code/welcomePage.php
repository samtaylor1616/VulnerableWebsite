<?php
/*
 * Last Modified: Monday, 1st October 2019 8:43:47 pm
 * Modified By: Samantha Taylor
 * -----
 * Purpose: Welcome page that a user gets redirected once successfully logged in
*/

include('validateSession.php');
// Include the php database configuration
require_once("db.php");
require_once("utils.php");

if (!empty($_POST['moneyInputValue'])) {
  $username = $_SESSION['username'];
  $value = $_POST['moneyInputValue'];

  if (!addFunds($db, $username, $value)) {
    echo "<h5>Couldn't add funds: ".mysqli_error($db)."</h5>";
  }
}

if (!empty($_POST['itemTitle']) && !empty($_POST['itemDesc']) && !empty($_POST['itemPrice']) ) {
  $username = $_SESSION['username'];
  $title = $_POST['itemTitle'];
  $desc = $_POST['itemDesc'];
  $price = $_POST['itemPrice'];
  if (createItem($db, $username, $title, $desc, $price)) {
    echo "<h5>Successfully created an item</h5>";
  } else {
    echo "<h5>Error creating an item: " . mysqli_error($db) . "</h5>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <link rel="stylesheet" href="./css/fontawesome.css">
  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/welcomePage.css">
  <link rel="stylesheet" href="./css/itemList.css">

  <title>Welcome</title>
</head>

<body>
<?php
    $page = "Home";
    require_once("navbar.php");
  ?>

  <div class="topImg" style="background-image: url(./assets/field.jpg);">
  <h1 class='text-center pageTitle'>Welcome <?php echo $_SESSION['username']; ?></h1>";
  </div>

  <div class="row cardContainer">
    <div class="col"></div>
    <div class="col-sm-12 col-md-3">
      <img class="card-img-top" src="./assets/piggy.jpg" alt="Money image">
      <div class="card">
        <h5 class="card-title text-center">Add funds to account</h5>
        <p class="m-1 p-1 text-center">Currently you have: $<?php
          $username = $_SESSION['username'];

          $sql = "SELECT money FROM users WHERE username = '$username'";
          $result = mysqli_query($db, $sql);

          if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            echo $row["money"];

        }
        ?>
        </p>
        <!-- FORM -->
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="ml-3 mr-1">
          <div class="form-row align-items-center">
            <div class="col-sm-8 my-1">
              <input name="moneyInputValue" required min="0" type="number" step="0.01" class="form-control" id="moneyInputValue" placeholder="$0.00">
            </div>
            <div class="col-sm-4 my-1">
              <button type="submit" class="btn btn-success mr-0">Add</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="col-sm-12 col-md-3">
      <img class="card-img-top" src="./assets/shopping.jpg" alt="Shopping image">
      <div class="card">
        <h5 class="card-title text-center">User details</h5>
        <div class="m-3">
        <?php
          $username = $_SESSION['username'];
          $sql = "SELECT * FROM users WHERE username = '$username'";
          $userResult = mysqli_fetch_array(mysqli_query($db, $sql));
          $isEnabled = $userResult['userEnabled'] ? 'Enabled' : 'Disabled';
          $status = $userResult['isAdmin'] ? 'Admin' : 'Standard';

          echo '<p class="pl-1 pt-1 m-0"><i class="fas fa-user mr-1"></i>Username: '.$username.'</p>';
          echo '<p class="pl-1 pt-1 m-0"><i class="fas fa-lock-open mr-1"></i>Account status: '.$isEnabled.'</p>';
          echo '<p class="pl-1 pt-1 m-0"><i class="fas fa-shield-alt mr-1"></i>User level: '.$status.'</p>';
        ?>
        </div>
        <a class="m-4 mt-3" href=?page=settings.php><button class="btn btn-pwd btn-warning">Change Password</button></a>
      </div>
    </div>
    <div class="col-sm-12 col-md-3">
      <img class="card-img-top" src="./assets/open.jpg" alt="Sell image">
      <div class="card">
        <h5 class="card-title text-center">Looking to Sell</h5>
        <!-- FORM -->
        <form method="post" class="mt-2" action="<?php echo $_SERVER['PHP_SELF']; ?>">
          <div class="form-group-row center">
            <div class="col-sm-12 my-1">
              <input name="itemTitle" type="text" class="form-control" id="itemTitle" placeholder="Title"/>
            </div>
            <div class="col-sm-12 my-1">
              <input name="itemDesc" type="text" class="form-control" id="itemDesc" placeholder="Description"/>
            </div>
            <div class="col-sm-12 my-1">
              <input name="itemPrice" required min="0" type="number" step="0.01" class="form-control" id="itemPrice" placeholder="Price $0.00">
            </div>
            <div class="col-sm-8 my-1">
              <button type="submit" class="btn btn-success mr-0">Create Item</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="col"></div>
  </div>

  <?php
    if (isset($_GET['page'])){
      include($_GET['page']);
    }
  ?>
</body>

</html>
