<?php 
/*
 * Author: Samantha Taylor
 * -----
 * Purpose: Provide a navbar to all pages and includes the admin page if the user 
 * has the isAdmin flag set
 */
include('validateSession.php');
// require = if it cant find it then error
// once = dont include it multiple times (prevents loops)
require_once("db.php");
require_once("utils.php");

// If user clicked delete user
if (!empty($_POST['delUserById']) ) {
   $id = $_POST['delUserById'];
   deletePerson($db, $id); // Calls deletePerson in utils.php
}

// If user clicked delete item
if (!empty($_POST['delItemById']) ) {
   $id = $_POST['delItemById'];
   deleteItem($db, $id); // Calls deleteItem in utils.php
}

// If user clicked enable/disable user
if (!empty($_POST['lockUserById']) && (!empty($_POST['flagSet']))) {
   $id = $_POST['lockUserById'];
   $flag = $_POST['flagSet'];
   lockUserById($db, $id, $flag); // Calls lockUserById in utils.php
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Admin</title>

   <script src="./js/jquery.min.js"></script>
   <link rel="stylesheet" href="./css/bootstrap.min.css">
   <link rel="stylesheet" href="./css/fontawesome.css">
   <link rel="stylesheet" href="./css/admin.css">

   <script>
      // Must use javascript function for onClick which will set 
      // the values of a hidden form and submit it
      function deletePerson(id) {
         document.getElementById('delUserById').value = id;
         $("#deleteUserForm").submit();
      }
      function deleteItem(id) {
         document.getElementById('delItemById').value = id;
         $("#deleteItemForm").submit();
      }

      // Enables or disables user
      function setUserLock(id, flag) {
         document.getElementById('lockUserById').value = id;
         document.getElementById('flagSet').value = flag;
         $("#setUserLockForm").submit();
      }
   </script>
</head>
<body>
<?php
    $page = "Admin";
    require_once("navbar.php");
  ?>

   <div class="container mb-3">
      <h1 class="whiteFont mt-3">Search Users:</h1>
      <!-- FORM -->
      <form method="GET" action="./admin.php">
         <div class="input-group mt-3 mb-3 w-50">
            <input type="text" class="form-control" placeholder="Username to search by" name="name" >
            <div class="input-group-append">
               <!-- type=submit will trigger the form -->
               <button class="btn btn-outline-secondary" type="submit" id="searchButton">Search</button>
            </div>
         </div>
      </form>
      <!-- END FORM -->

      <div class="card">
         <!-- Start Table -->
         <table class="table">
            <!-- Table Header -->
            <thead>
               <th>User ID</th>
               <th>Username</th>
               <th>Money</th>
               <th>User Enabled/Disabled</th>
               <th>Admin Enabled</th>
               <th>Delete</th>
            </thead>
            <!-- End Table Header -->
            <tbody>
               <?php 
                  // Provides true or false rather than 1 or 0
                  function getBoolean($x) {
                     return $x ? 'True' : 'False';
                  }

                  // If the flag is true it will create a green happy face button
                  // otherwise the default is a orange sad face button
                  function constructBtn($flag, $id, $funcToCall) {
                     $btnStr = "<button class='btn btn-warning' onclick='".$funcToCall."(".$id.", !$flag)'><i class='fas fa-frown'></button></i>";
                     if ($flag) {
                        $btnStr = "<button class='btn btn-success' onclick='".$funcToCall."(".$id.", !$flag)'><i class='fas fa-smile'></button></i>";
                     } 

                     return $btnStr;
                  }

                  // If the GET variable "name" is set then use it
                  if(isset($_GET["name"])){
                     $name = $_GET["name"];
                     $sql = "SELECT * FROM users where username LIKE '%$name%'";
                  }else{
                     // Otherwise just grab them all
                     $sql = "SELECT * FROM users";                  
                  }

                  $result = mysqli_query($db, $sql); 

                  // Iterate through all results and create a list item
                  while($row = mysqli_fetch_array($result)){
                     
                     echo "<tr>";
                     // Access by name
                     echo "<td>".$row["id"]."</td>";
                     echo "<td>".$row["username"]."</td>";
                     echo "<td>".$row["money"]."</td>";
                     $isAdmin = getBoolean($row["isAdmin"]);

                     // Add a button that sends the ID and isEnabled flag of the user to the disable/enable user function
                     echo "<td>";
                        echo constructBtn( $row["userEnabled"], $row["id"], 'setUserLock');
                     echo "</td>";

                     // echo "<td>$userEnabled</td>";
                     echo "<td>$isAdmin</td>";
                     
                     // Add a button that sends the ID of the user to the delete function
                     echo "<td>";
                        echo "<button class='btn btn-danger' onclick='deletePerson(".$row["id"].")'><i class='fas fa-times'></button></i>";
                     echo "</td>";
                     echo "</tr>";
                  }
               ?>
            </tbody>
         </table>
         <!-- End Table -->
      </div>
   </div>

   <?php
    $page = "Admin";
    require_once("itemList.php");
  ?>

   <!-- Hidden form used to delete a user by their id -->
   <!-- Delete User form -->
   <form id="deleteUserForm" method='post' action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <input name='delUserById' type='hidden' class='form-control' id='delUserById' placeholder='id'>
   </form>
   <!-- Delete Item form -->
   <form id="deleteItemForm" method='post' action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <input name='delItemById' type='hidden' class='form-control' id='delItemById' placeholder='id'>
   </form>
   <!-- Disable/Enable User form -->
   <form id="setUserLockForm" method='post' action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <input name='lockUserById' type='hidden' class='form-control' id='lockUserById'>
      <input name='flagSet' type='hidden' class='form-control' id='flagSet'>
   </form>
</body>
</html>