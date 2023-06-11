<?php 
// Connecting to the Database
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_cars";

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn){
    die("Sorry we failed to connect: ");
}

  
  ?>