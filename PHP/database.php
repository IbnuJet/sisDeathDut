<?php
$host = 'localhost';
$dbname = 'reserv_view_resto';
$username = 'root';
$password = '';    

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
