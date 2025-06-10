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

// Query gabungkan restoran dan review, tapi 1 baris per restoran
$sql = "SELECT restoran.id_restoran, restoran.nama_restoran, ROUND(AVG(review.rating)) AS rating 
        FROM review 
        JOIN restoran ON review.id_restoran = restoran.id_restoran
        GROUP BY restoran.id_restoran, restoran.nama_restoran";

$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
$conn->close();
?>
