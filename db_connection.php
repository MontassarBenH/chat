<?php

// Define the database connection variables
$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "chat-app";

// Create a connection to the database
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check if the connection was successful or not
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
