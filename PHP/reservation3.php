<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "reserv_view_resto";

$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

$id_restoran = $_GET['id_restoran'] ?? 0;

$sql = "SELECT id_menu, nama_menu FROM menu WHERE id_restoran = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_restoran);
$stmt->execute();
$result = $stmt->get_result();

$menu = [];
while ($row = $result->fetch_assoc()) {
    $menu[] = $row;
}
echo json_encode($menu);
$conn->close();
