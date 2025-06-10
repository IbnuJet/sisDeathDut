<?php
session_start();

if (!isset($_SESSION['id_customer'])) {
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}
$host = "localhost";
$user = "root";
$pass = "";
$db   = "reserv_view_resto";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}


$id_customer = $_SESSION['id_customer'];

$query = "
SELECT r.id_reservasi, res.nama_restoran, r.tanggal, r.jam_mulai, r.jam_selesai, 
       r.jumlah_orang, r.status
FROM reservasi r
JOIN restoran res ON r.id_restoran = res.id_restoran
WHERE r.id_customer = ?
ORDER BY r.tanggal DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_customer);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>
