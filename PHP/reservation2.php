<?php
session_start(); // pastikan session berjalan
$host = "localhost";
$user = "root";
$password = "";
$db = "reserv_view_resto";

$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "Koneksi gagal"]);
    exit;
}

$id_customer = $_SESSION['id_customer'] ?? 1; // sementara default 1
$id_restoran = $_POST['id_restoran'];
$tanggal = $_POST['tanggal'];
$waktu = $_POST['waktu'];
$jumlah = $_POST['jumlah_orang'];
$menus = $_POST['menu'] ?? [];

$stmt = $conn->prepare("INSERT INTO reservasi (id_customer, id_restoran, tanggal, waktu, jumlah_orang) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("iissi", $id_customer, $id_restoran, $tanggal, $waktu, $jumlah);
$stmt->execute();
$id_reservasi = $conn->insert_id;

foreach ($menus as $id_menu => $qty) {
    if ((int)$qty > 0) {
        $stmt2 = $conn->prepare("INSERT INTO detail_pesanan (id_reservasi, id_menu, jumlah) VALUES (?, ?, ?)");
        $stmt2->bind_param("iii", $id_reservasi, $id_menu, $qty);
        $stmt2->execute();
    }
}

echo json_encode(["success" => true]);
$conn->close();
