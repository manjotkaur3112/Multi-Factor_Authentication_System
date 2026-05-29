<!-- <?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "secure_auth";

$conn = mysqli_connect($host, $user, $pass, $dbname);
?>

<?php
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?> -->

<?php

$host = getenv('DB_HOST') ?: 'localhost';
$user = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASSWORD') ?: '';
$database = getenv('DB_DATABASE') ?: 'secure_auth';

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>