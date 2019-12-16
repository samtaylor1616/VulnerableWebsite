<?php 
/* Purpose: Login and registration page. */

// Include the php database configuration
require_once("db.php");
require_once("login.php");
session_start();

// User has filled out the 'Create new user' Form
if (!empty($_POST["registerUsername"]) && !empty($_POST["registerPassword"]) && !empty($_POST["registerConfirm"])) {
  $username = trim($_POST["registerUsername"]);
  $pwd = md5( $_POST["registerPassword"] );
  $confirmPwd = md5( $_POST["registerConfirm"] );

  // If password and password confirm match, enter new user into db
  if ( pwdMatch($pwd, $confirmPwd) ) {
    $result = createUser($db, $username, $pwd);
    echo "<h5>$result</h5>";
  } else {
    echo "<h5>Could not create a new user: Passwords did not match</h5>";
  }
}

// User has filled out 'User Login' form
if (!empty($_POST["usernameLogin"]) && !empty($_POST["passwordLogin"])) {
  $username = $_POST["usernameLogin"]; 
  $password = $_POST["passwordLogin"]; //hashing done in loginUser()

  if( !loginUser($db, $username, $password) ) {
    echo "<h5>Could not login user</h5>";
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
    <link rel="stylesheet" href="./css/login.css">
    <title>Login</title>
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e6e6e6;">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="welcomePage.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="searchPage.php">Search</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="settings.php">Settings</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="nav-item navRight active">
                    <a class="nav-link" href="index.php">Register & Login <span class="sr-only">(current)</span></a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- END NAVBAR -->
    <div class="topImg" style="background-image: url(./assets/red.jpeg);">
        <h1 class="text-center pageTitle">Hackers Market Place</h1>
    </div>
    <div class="container-fluid mt-4">
        <div class="row">
            <!-- SIGN IN -->
            <div class="col-sm-12 col-md-6 contentLeft">
                <div class="col-md-10 mx-auto text-center">
                    <div class="headerTitle">
                        <h1 class="mainTitle">
                            Sign In
                        </h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-xl-7 mx-auto">
                        <!-- FORM -->
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="form-group">
                                <input name="usernameLogin" type="text" class="form-control my-input" id="username"
                                    placeholder="Username"
                                    value="<?php if(isset($_COOKIE['username'])) { echo $_COOKIE['username']; }?>">
                            </div>
                            <div class="form-group">
                                <input name="passwordLogin" type="password" class="form-control my-input" id="password"
                                    placeholder="Password">
                            </div>
                            <!-- <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="rememberMe">
                <label class="form-check-label" for="rememberMe">Remember me</label>
              </div> -->
                            <button class="btn loginBtn" type="submit">Log in</button>
                        </form>
                        <!-- END FORM -->

                        <div class="col-sm-12">
                            <div class="login-or">
                                <hr class="hr-or">
                                <span class="span-or">or create a new account</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- REGISTER -->
            <div class="col-sm-12 col-md-6">
                <div class="col-md-10 mx-auto text-center">
                    <div class="headerTitle">
                        <h1 class="mainTitle">
                            Create a Free Account
                        </h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-xl-7 mx-auto">
                        <form method="post">
                            <div class="form-group">
                                <input name="registerUsername" type="text" class="form-control my-input"
                                    id="registerUsername" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <input name="registerPassword" type="password" class="form-control my-input"
                                    id="registerPassword" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <input name="registerConfirm" type="password" class="form-control my-input"
                                    id="registerConfirm" placeholder="Confirm Password">
                            </div>
                            <button class="btn loginBtn" type="submit">Create New Account</button>
                            <p class="small mt-2">By signing up, you are indicating that you have read and agree to the
                                <a href="#" class="ps-hero__content__link">Terms of Use</a> where it states you will not
                                hack
                                us.
                            </p>
                        </form>
                    </div>
                </div> <!-- End Row -->
            </div>
        </div> <!-- End Row -->

        <footer class="container-fluid fixed-bottom" id="footer">
            <p class="float-right"><a href="#">Back to top</a></p>
            <p>© 2019-2020 Company, Inc. · <a href="#">Privacy</a> · <a href="#">Terms</a></p>
        </footer>
</body>

</html>