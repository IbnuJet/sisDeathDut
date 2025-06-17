<?php

$host = "localhost";
$user = "root";
$password = "";
$db = "reserv_view_resto";

$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$sql = "SELECT restoran.id_restoran, restoran.nama_restoran, ROUND(AVG(review.rating)) AS rating 
        FROM review 
        JOIN restoran ON review.id_restoran = restoran.id_restoran
        GROUP BY restoran.id_restoran, restoran.nama_restoran";

$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    // Tambahan ambil gambar
    $id_resto = $row['id_restoran'];
    $gambar_sql = "SELECT gambar FROM restoran WHERE id_restoran = $id_resto";
    $gambar_result = $conn->query($gambar_sql);
    $gambar = 'uploads/default.jpg'; // default jika tidak ditemukan

    if ($gambar_result && $gambar_result->num_rows > 0) {
        $gambar_row = $gambar_result->fetch_assoc();
        if (!empty($gambar_row['gambar'])) {
            $gambar = $gambar_row['gambar'];
        }
    }

    $row['gambar'] = $gambar; // tambahkan ke array
    $data[] = $row;
}

echo json_encode($data);
$conn->close();
?>
