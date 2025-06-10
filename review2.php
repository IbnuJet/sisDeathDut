<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "reserv_view_resto";

$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$id_restoran = $_GET['id_restoran'] ?? null;


if ($id_restoran) {
    // Ambil nama restoran
    $stmt1 = $conn->prepare("SELECT nama_restoran FROM restoran WHERE id_restoran = ?");
    $stmt1->bind_param("i", $id_restoran);
    $stmt1->execute();
    $result1 = $stmt1->get_result();
    $nama_restoran = $result1->fetch_assoc()['nama_restoran'] ?? 'Unknown';

    // Ambil review
    $stmt2 = $conn->prepare("SELECT r.rating, r.komentar, r.tanggal_review, c.nama_customer
                             FROM review r
                             JOIN customer c ON r.id_customer = c.id_customer
                             WHERE r.id_restoran = ?
                             ORDER BY r.tanggal_review DESC");
    $stmt2->bind_param("i", $id_restoran);
    $stmt2->execute();
    $result2 = $stmt2->get_result();

    $reviews = [];
    while ($row = $result2->fetch_assoc()) {
        $row['nama_restoran'] = $nama_restoran; // Tambahkan nama restoran ke tiap review
        $reviews[] = $row;
    }

    // Jika tidak ada review, tetap kirim nama restoran
    if (empty($reviews)) {
        $reviews[] = ['nama_restoran' => $nama_restoran];
    }

    echo json_encode($reviews);
} else {
    echo json_encode([]);
}

$conn->close();
?>
