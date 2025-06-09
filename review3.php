<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "reserv_view_resto";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// GET method untuk ambil nama_restoran dan review
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['id'])) {
        echo json_encode(["error" => "Missing id"]);
        exit;
    }

    $id = (int) $_GET['id'];
    $sql = "SELECT r.rating, r.komentar, r.tanggal_review, c.nama_customer, rest.nama_restoran
            FROM review r
            JOIN customer c ON r.id_customer = c.id_customer
            JOIN restoran rest ON r.id_restoran = rest.id_restoran
            WHERE r.id_restoran = $id
            ORDER BY r.tanggal_review DESC";

    $result = $conn->query($sql);
    $reviews = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $reviews[] = $row;
        }
    } else {
        // Tetap ambil nama restoran meski review belum ada
        $res = $conn->query("SELECT nama_restoran FROM restoran WHERE id_restoran = $id");
        if ($res && $row = $res->fetch_assoc()) {
            $reviews[] = ["nama_restoran" => $row['nama_restoran']];
        }
    }

    echo json_encode($reviews);
    exit;
}

// POST method untuk simpan review baru
$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['id_restoran'], $data['id_customer'], $data['rating'], $data['komentar'])) {
    echo json_encode(["success" => false, "error" => "Incomplete data"]);
    exit;
}

$id_restoran = (int) $data['id_restoran'];
$id_customer = (int) $data['id_customer'];
$rating = (int) $data['rating'];
$komentar = $conn->real_escape_string($data['komentar']);
$tanggal = date("Y-m-d");

$sql = "INSERT INTO review (id_restoran, id_customer, rating, komentar, tanggal_review)
        VALUES ($id_restoran, $id_customer, $rating, '$komentar', '$tanggal')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => $conn->error]);
}

$conn->close();
?>
