<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment_2";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
