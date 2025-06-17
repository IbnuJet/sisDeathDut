<?php
session_start();

if (!isset($_SESSION['email'])) {
  echo json_encode(['nama' => 'Guest', 'email' => 'not-logged-in@example.com']);
  exit;
}

$host = "localhost";
$user = "root";
$password = "";
$db = "reserv_view_resto";

$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) {
  echo json_encode(['nama' => 'Error', 'email' => 'DB Error']);
  exit;
}

$email = $_SESSION['email'];
$stmt = $conn->prepare("SELECT nama_customer, email FROM customer WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
  echo json_encode([
    'nama' => $row['nama_customer'],
    'email' => $row['email']
  ]);
} else {
  echo json_encode(['nama' => 'Unknown', 'email' => 'unknown@example.com']);
}

$stmt->close();
$conn->close();
?>
