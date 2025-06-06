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
$sql = "SELECT restoran.nama_restoran, review.rating 
        FROM review 
        JOIN restoran ON review.id_restoran = restoran.id_restoran";

$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
$conn->close();
?>
