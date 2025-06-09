<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "reserv_view_resto";

$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$id_restoran = $_GET['id'] ?? null;

if ($id_restoran) {
    $stmt = $conn->prepare("SELECT r.rating, r.komentar, r.tanggal_review, c.nama_customer, res.nama_restoran
                            FROM review r
                            JOIN customer c ON r.id_customer = c.id_customer
                            JOIN restoran res ON r.id_restoran = res.id_restoran
                            WHERE r.id_restoran = ?
                            ORDER BY r.tanggal_review DESC");
    $stmt->bind_param("i", $id_restoran);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $reviews = [];
    while ($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }
    
    echo json_encode($reviews);
} else {
    echo json_encode([]);
}

$conn->close();
?>
