<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "reserv_view_resto";

$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Gabungkan restoran + rating dari review
$sql = "SELECT r.id_restoran, r.nama_restoran, r.kategori, r.jam_operasional,
               COALESCE(AVG(rv.rating), 0) AS avg_rating
        FROM restoran r
        LEFT JOIN review rv ON r.id_restoran = rv.id_restoran
        GROUP BY r.id_restoran";

$result = $conn->query($sql);
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
$conn->close();
?>
