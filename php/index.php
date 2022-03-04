<?php 

$servername = "db";
// $servername = "127.0.0.1";
$username = "devuser";
$password = "devpass";
$db = 'world_of_garages';

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";


?>