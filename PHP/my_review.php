<?php
session_start();
ini_set('display_errors', 1); // Tampilkan error PHP
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

// Cek apakah user sudah login
if (!isset($_SESSION['id_customer'])) {
    echo json_encode(["error" => "Unauthorized: No session"]);
    exit;
}

$id_customer = $_SESSION['id_customer'];

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "reserv_view_resto");
if ($conn->connect_error) {
    echo json_encode(["error" => "Koneksi gagal: " . $conn->connect_error]);
    exit;
}

// ==== TAMBAHAN: HANDLE DELETE REVIEW ====
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Ambil ID dari query string
    parse_str($_SERVER['QUERY_STRING'], $params);
    $id_review = isset($params['id']) ? (int) $params['id'] : 0;

    if (!$id_review) {
        echo json_encode(["success" => false, "error" => "ID review tidak valid"]);
        exit;
    }

    // Pastikan review milik user ini
    $stmt = $conn->prepare("DELETE FROM review WHERE id_review = ? AND id_customer = ?");
    $stmt->bind_param("ii", $id_review, $id_customer);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $stmt->error]);
    }

    exit;
}
// ==== END HANDLE DELETE ====

// ==== DEFAULT: Ambil review user (GET) ====
$query = "
    SELECT rv.id_review, res.nama_restoran, rv.rating, rv.komentar, rv.tanggal_review
    FROM review rv
    JOIN restoran res ON rv.id_restoran = res.id_restoran
    WHERE rv.id_customer = ?
    ORDER BY rv.tanggal_review DESC
";

$stmt = $conn->prepare($query);
if (!$stmt) {
    echo json_encode(["error" => "Prepare failed: " . $conn->error]);
    exit;
}

$stmt->bind_param("i", $id_customer);
if (!$stmt->execute()) {
    echo json_encode(["error" => "Execute failed: " . $stmt->error]);
    exit;
}

$result = $stmt->get_result();
if (!$result) {
    echo json_encode(["error" => "Get result failed: " . $stmt->error]);
    exit;
}

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>
