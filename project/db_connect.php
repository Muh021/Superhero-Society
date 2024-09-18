<?php
$servername = "localhost"; // typically 'localhost' for XAMPP
$username = "root"; // your MySQL username, default is 'root' in XAMPP
$password = ""; // your MySQL password, default is '' (empty string) in XAMPP
$dbname = "4347_projectdb_final"; // the name of your database


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
