<?php
include('validateSession.php');
require_once("db.php");
require_once("utils.php");

// Disables chrome XSS protection for reflective XSS
header("X-XSS-Protection: 0");

// If user clicked delete item
if (!empty($_POST['delItemById']) ) {
  $id = $_POST['delItemById'];
  deleteItem($db, $id); // Calls deleteItem in utils.php
}

// If user clicked buy item
if (!empty($_POST['buyItemById'])) {
  $loggedInUser = $_SESSION['username'];
  $itemId = $_POST['buyItemById'];
  $result = buyItem($db, $itemId, $loggedInUser); // Calls buyItem in utils.php
  if ($result) {
    echo "<h5>Successfully bought item</h5>";
  } else {
    echo "<h5>Could not buy item</h5>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <script src="./js/jquery.min.js"></script>
    <link rel="stylesheet" href="./css/fontawesome.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/searchPage.css">
    <title>Search results</title>

    <script>
    function deleteItem(id) {
        document.getElementById('delItemById').value = id;
        $("#deleteItemForm").submit();
    }

    function buyItem(itemId) {
        document.getElementById('buyItemById').value = itemId;
        $("#buyItemForm").submit();
    }
    </script>
</head>

<body>
    <?php
    $page = "Search";
    require_once("navbar.php");
  ?>
    <div class="topImg" style="background-image: url(./assets/simple.jpg);">
        <form class="form-inline p-2">
            <input name="searchTitle" id="searchTitle" class="form-control mr-sm-2 search" type="text"
                placeholder="Search by Title" aria-label="Search">
            <button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
        </form>
        <form class="form-inline p-2">
            <input name="searchUser" id="searchName" class="form-control mr-sm-2 search" type="text"
                placeholder="Search by Username" aria-label="Search">
            <button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
        </form>
        <h1 class="text-center pageTitle">
            Search Results
            <?php
        if (!empty($_GET["searchTitle"])) {
          echo " For: ".$_GET["searchTitle"];
        }
      ?>
            <?php
        if(!empty($_GET["searchUser"])) {
          echo " For: ".$_GET["searchUser"];
        }
      ?>
        </h1>
    </div>

    <div class="card mr-4 ml-4 mb-4 searchTable">
        <table class="table itemsTable">
            <thead>
                <th>Title</th>
                <th>Owners Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Buy</th>
            </thead>
            <tbody>
                <?php
          // If the flag is true it will create a green happy face button
          // otherwise the default is a orange sad face button
          function constructBtn($ownersName, $id, $price) {
          $loggedInUser = $_SESSION['username'];
          $btnStr = "<button class='btn btn-success' onclick='buyItem(".$id.")'><i class='fas fa-shopping-cart'></button></i>";

          // If the logged in user is the owner of the item
          // give them the option to delete it rather than buy it
          if ($ownersName === $loggedInUser) {
            $btnStr = "<button class='btn btn-danger pl-3 pr-3' onclick='deleteItem(".$id.")'><i class='fas fa-times'></button></i>";
          }

          return $btnStr;
        }

        if (isset($_GET["searchTitle"])) {
          $title = $_GET["searchTitle"];
          $sql = "SELECT * FROM items where title LIKE '%".$title."%'";
         } else if (isset($_GET["searchUser"])) {
          $name = $_GET["searchUser"];
          $sql = "SELECT * FROM items where ownersName LIKE '%$name%'";
         } else {
            $sql = "SELECT * FROM items";
         }
          $result = mysqli_query($db, $sql);

          while($row = mysqli_fetch_array($result)) {
            echo "<tr>";
              // Access by id
              echo "<td>".$row["2"]."</td>";
              echo "<td>".$row["1"]."</td>";
              echo "<td>".$row["3"]."</td>";
              echo "<td>$".$row["4"]."</td>";
              // Access by name
              echo "<td>".constructBtn($row["ownersName"], $row["id"], $row["price"]) ."</td>";
            echo "</tr>";
          }
        ?>
            </tbody>
        </table>

        <!-- Hidden form used to delete a user by their id -->
        <!-- Delete Item form -->
        <form id="deleteItemForm" method='post' action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input name='delItemById' type='hidden' class='form-control' id='delItemById' placeholder='id'>
        </form>
        <!-- Buy Item form -->
        <form id="buyItemForm" method='post' action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input name='buyItemById' type='hidden' class='form-control' id='buyItemById' placeholder='id'>
        </form>
    </div>
</body>

</html>