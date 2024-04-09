<?php
$servername="localhost";
$username = "root";
$password = "";
$database_name = "tempahan_makanan_mesyuarat";
$conn = new mysqli($servername, $username, $password, $database_name);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
   } 

?>