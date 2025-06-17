<?php
session_start();
header('Content-Type: application/json');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['id_customer'])) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized: session not found"]);
    exit;
}

$host = "localhost";
$user = "root";
$pass = "";
$db   = "reserv_view_resto";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
    exit;
}

$action = isset($_GET['action']) ? $_GET['action'] : "get_reservations";

if ($action === "get_restaurants") {
    // Ambil daftar restoran dari database
    $query = "SELECT nama_restoran FROM restoran ORDER BY nama_restoran ASC";
    $result = $conn->query($query);

    if (!$result) {
        http_response_code(500);
        echo json_encode(["error" => "Query failed: " . $conn->error]);
        exit;
    }

    $restos = [];
    while ($row = $result->fetch_assoc()) {
        $restos[] = $row['nama_restoran'];
    }

    echo json_encode($restos);
    exit;
}

// Ambil data reservasi user login dengan filter
$id_customer = $_SESSION['id_customer'];

$resto = isset($_GET['resto']) ? $_GET['resto'] : "";
$tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : "";

$query = "
SELECT r.id_reservasi, res.nama_restoran, r.tanggal_reservasi, r.waktu_reservasi, 
       r.jumlah_orang, r.status_reservasi
FROM reservasi r
JOIN restoran res ON r.id_restoran = res.id_restoran
WHERE r.id_customer = ?";

$params = [$id_customer];
$types = "i";

if ($resto !== "" && strtolower($resto) !== "pilih restoran") {
    $query .= " AND res.nama_restoran = ?";
    $params[] = $resto;
    $types .= "s";
}

if ($tanggal !== "") {
    $query .= " AND r.tanggal_reservasi = ?";
    $params[] = $tanggal;
    $types .= "s";
}

$query .= " ORDER BY r.tanggal_reservasi DESC";

$stmt = $conn->prepare($query);
if ($stmt === false) {
    http_response_code(500);
    echo json_encode(["error" => "Failed to prepare statement: " . $conn->error]);
    exit;
}

if (!$stmt->bind_param($types, ...$params)) {
    http_response_code(500);
    echo json_encode(["error" => "Failed to bind parameters: " . $stmt->error]);
    exit;
}

$stmt->execute();

$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
