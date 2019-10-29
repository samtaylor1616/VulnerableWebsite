<?php 
// Set constants for the database connection
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'student');
define('DB_PASSWORD', 'CCSEP2019');
define('DB_DATABASE', 'assignment');

// Connect to the database
$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
?>