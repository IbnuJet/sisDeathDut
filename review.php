<?php
// Koneksi ke database
$host = "localhost";
$user = "root";
$password = "";
$db = "reserv_view_resto";

$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query gabungkan restoran dan review
$sql = "SELECT r.id_restoran, r.tanggal_review, r.rating, r.komentar, c.nama_customer, rest.nama_restoran
        FROM review r
        JOIN customer c ON r.id_customer = c.id_customer
        JOIN restoran rest ON r.id_restoran = rest.id_restoran
        ORDER BY r.tanggal_review DESC";



$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
$conn->close();
?>
