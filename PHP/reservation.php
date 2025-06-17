<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "reserv_view_resto";

$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$tanggal = $_GET['tanggal'] ?? '';
$waktu = $_GET['waktu'] ?? '';
$jumlah = $_GET['jumlah'] ?? '';
$search = $_GET['search'] ?? '';

$sql = "SELECT r.id_restoran, r.nama_restoran, r.kategori, r.jam_operasional, 
               COALESCE(AVG(rv.rating), 0) AS avg_rating
        FROM restoran r
        LEFT JOIN review rv ON r.id_restoran = rv.id_restoran
        WHERE 1=1";

$params = [];
$types = "";

// Filter keyword (opsional)
if ($search) {
    $sql .= " AND (r.nama_restoran LIKE ? OR r.kategori LIKE ?)";
    $types .= "ss";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

// Filter tanggal, waktu, jumlah (hanya jika semua diisi)
if ($tanggal && $waktu && $jumlah) {
    $sql .= " AND EXISTS (
        SELECT 1 FROM reservasigeneral rg 
        WHERE rg.id_restoran = r.id_restoran
          AND rg.tanggal = ?
          AND rg.waktu = ?
          AND rg.jumlah_orang = ?
    )";
    $types .= "ssi";
    $params[] = $tanggal;
    $params[] = $waktu;
    $params[] = $jumlah;
}

$sql .= " GROUP BY r.id_restoran";

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
$conn->close();
