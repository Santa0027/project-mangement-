<?php
$servername = "localhost"; // Host name
$username = "root"; // Database username
$password = ""; // Database password
$database = "billing"; // Database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Optional: Set the character set to UTF-8
mysqli_set_charset($conn, "utf8");


?>
