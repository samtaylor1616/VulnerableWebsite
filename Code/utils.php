<?php
/* File contains helper functions for managing users and items */

// Adds money to a users account
function addFunds($db, $username, $amount) {
  $sql = "UPDATE users SET money = money + $amount WHERE username = '$username'";
  return mysqli_query($db, $sql);
}

function transferMoney($db, $price, $buyer, $receiver) {
  addFunds($db, $receiver, $price);
  $negPrice = $price * -1;
  addFunds($db, $buyer, $negPrice);
}

// Inserts an item into the database
function createItem($db, $username, $title, $desc, $price) {
  $sql = "INSERT INTO items (ownersName, title, description, price) VALUES ('$username', '$title', '$desc', $price)";
  $result = mysqli_multi_query($db, $sql);

  return $result;
}

// Deletes an item in the users table, based off the unique id
function deleteItem($db, $id) {
  $sql = "DELETE FROM items WHERE id = $id";
  $result = mysqli_query($db, $sql);

  if (!$result) {
    echo "<h5>Could not delete the item with the id: $id</h5>";
  }
}

function buyItem($db, $id, $buyer) {
  $isSuccessful = false;

  // 1. Find if user has enough money
  $sql = "SELECT money FROM users WHERE username = '$buyer'";
  $userResult = mysqli_query($db, $sql);
  $buyersMoney = mysqli_fetch_array($userResult)['money'];

  $sql = "SELECT ownersName, price FROM items WHERE id = $id";
  $itemResult = mysqli_query($db, $sql);
  $itemRow = mysqli_fetch_array($itemResult);

  $itemPrice = $itemRow['price'];
  $ownersName = $itemRow['ownersName'];

  if ($buyersMoney >= $itemPrice) {
    // 2. Transfer money
    transferMoney($db, $itemPrice, $buyer, $ownersName);

    // 3. Delete item
    deleteItem($db, $id);
    $isSuccessful = true;
  }

  return $isSuccessful;
}

// Deletes a person in the users table, based off the unique id
function deletePerson($db, $id) {
  $sql = "DELETE FROM users WHERE id = $id";
  $result = mysqli_query($db, $sql);

  if (!$result) {
     echo "<h5>Could not delete the user with the id: $id".mysqli_error($db)."</h5>";
  }
}

// Locks or unlocks a person in the users table, based off the unique id
function lockUserById($db, $id, $flag) {
  $sql = "UPDATE users SET userEnabled = $flag WHERE id = $id";
  $result = mysqli_query($db, $sql);
  if (!$result) {
     echo "<h5>Could not enable/disable the user with the id: $id ".mysqli_error($db)."</h5>";
  }
}
?>