<?php 

$servername = "db";
// $servername = "127.0.0.1";
$username = "root";
$password = "my_secret_pw_shh";
$db = 'world_of_garages';

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

?>