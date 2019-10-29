<!-- 
 * Author: Samantha Taylor
 * -----
 * Purpose: Reusable component that displays the items in the database
 -->
<div class="container">
  <hr class="mb-3"/>
  <h1 class="whiteFont mt-3">Search Items:</h1>
  <!-- FORM -->
  <form method="GET" action="./admin.php">
    <div class="input-group mt-2 mb-3 w-50">
        <input type="text" class="form-control" placeholder="Name of item to search by" name="itemName" >
        <div class="input-group-append">
          <!-- type=submit will trigger the form -->
          <button class="btn btn-outline-secondary" type="submit" id="searchItemBtn">Search</button>
        </div>
    </div>
  </form>
  <!-- END FORM -->
  <div class="card mb-5">
    <!-- Start Table -->
    <table class="table">
      <!-- Table Header -->
      <thead>
        <th>Item ID</th>
        <th>Owners Username</th>
        <th>Title</th>
        <th>Description</th>
        <th>Price</th>
        <th>Delete</th>
      </thead>
      <!-- End Table Header -->
      <tbody>
          <?php 
          // If the GET variable "itemName" is set then use it
          if(isset($_GET["itemName"])){
            $name = $_GET["itemName"];
            $sql = "SELECT * FROM items where ownersName LIKE '%$name%'";
          }else{
            // Otherwise just grab them all
            $sql = "SELECT * FROM items";                  
          } 

          $result = mysqli_query($db, $sql); 

          // Iterate through all results and create a list item
          while($row = mysqli_fetch_array($result)){
            
            echo "<tr>";
            // Access by name
            echo "<td>".$row["id"]."</td>";
            echo "<td>".$row["ownersName"]."</td>";
            echo "<td>".$row["title"]."</td>";
            echo "<td>".$row["description"]."</td>";
            echo "<td>".$row["price"]."</td>";
            
            // Add a button that sends the ID of the user to the delete function
            echo "<td>";
                echo "<button class='btn btn-danger' onclick='deleteItem(".$row["id"].")'><i class='fas fa-times'></button></i>";
            echo "</td>";
          }
          ?>
      </tbody>
    </table>
  </div>
</div>