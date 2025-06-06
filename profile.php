<?php
session_start();
$host = "localhost";
$user = "root";
$password = "";
$db = "reserv_view_resto";

// Koneksi ke database
$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) {
    echo json_encode(['error' => 'DB Connection Failed']);
    exit;
}

if (!isset($_SESSION['email'])) {
    echo json_encode(['error' => 'Not logged in']);
    exit;
}

$email = $_SESSION['email'];
$sql = "SELECT nama_customer, email, password, no_telp, gender FROM customer WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

echo json_encode($data);
?>
