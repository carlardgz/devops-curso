<?php
$servername = "mysql-service:3306";
$database = "siceuc";
$username = "root";
$password = "mysql-secret-password";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
mysqli_close($conn);
?>