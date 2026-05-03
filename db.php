<?php
// db.php — DB connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "birthday_system";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}
?>
