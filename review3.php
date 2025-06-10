<?php
session_start();
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "reserv_view_resto");
if ($conn->connect_error) {
    die(json_encode(["error" => "Koneksi gagal: " . $conn->connect_error]));
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Ambil review berdasarkan ID_REVIEW (EDIT MODE)
    if (isset($_GET['id_review'])) {
        $id_review = (int) $_GET['id_review'];
        $stmt = $conn->prepare("
            SELECT r.id_review, r.id_restoran, r.rating, r.komentar, res.nama_restoran
            FROM review r
            JOIN restoran res ON r.id_restoran = res.id_restoran
            WHERE r.id_review = ?
        ");
        $stmt->bind_param("i", $id_review);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($row = $res->fetch_assoc()) {
            echo json_encode(["success" => true, "review" => $row]);
        } else {
            echo json_encode(["success" => false, "error" => "Review tidak ditemukan"]);
        }
        exit;
    }

    // Ambil info restoran dan review berdasarkan ID_RESTORAN
    if (!isset($_GET['id_restoran'])) {
        echo json_encode(["error" => "Missing id_restoran"]);
        exit;
    }

    $id = (int) $_GET['id_restoran'];
    $response = [];

    $res = $conn->prepare("SELECT nama_restoran FROM restoran WHERE id_restoran = ?");
    $res->bind_param("i", $id);
    $res->execute();
    $result = $res->get_result();
    if ($row = $result->fetch_assoc()) {
        $response['nama_restoran'] = $row['nama_restoran'];
    } else {
        echo json_encode(["error" => "Restoran tidak ditemukan"]);
        exit;
    }

    $sql = $conn->prepare("
        SELECT r.id_review, r.rating, r.komentar, r.tanggal_review, c.nama_customer
        FROM review r
        JOIN customer c ON r.id_customer = c.id_customer
        WHERE r.id_restoran = ?
        ORDER BY r.tanggal_review DESC
    ");
    $sql->bind_param("i", $id);
    $sql->execute();
    $result = $sql->get_result();
    $reviews = [];

    while ($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }

    $response['reviews'] = $reviews;
    echo json_encode($response);
    exit;
}

// POST: insert atau update review
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['id_customer'])) {
        echo json_encode(["success" => false, "error" => "Unauthorized"]);
        exit;
    }

    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($data['rating'], $data['komentar'])) {
        echo json_encode(["success" => false, "error" => "Incomplete data"]);
        exit;
    }

    $id_customer = $_SESSION['id_customer'];
    $rating = (int) $data['rating'];
    $komentar = $conn->real_escape_string($data['komentar']);
    $tanggal = date("Y-m-d");

    if (isset($data['id_review'])) {
        $id_review = (int) $data['id_review'];
        $stmt = $conn->prepare("
            UPDATE review 
            SET rating = ?, komentar = ?, tanggal_review = ? 
            WHERE id_review = ? AND id_customer = ?
        ");
        $stmt->bind_param("sssii", $rating, $komentar, $tanggal, $id_review, $id_customer);
    } else {
        if (!isset($data['id_restoran'])) {
            echo json_encode(["success" => false, "error" => "Missing id_restoran"]);
            exit;
        }

        $id_restoran = (int) $data['id_restoran'];
        $stmt = $conn->prepare("
            INSERT INTO review (id_restoran, id_customer, rating, komentar, tanggal_review)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("iiiss", $id_restoran, $id_customer, $rating, $komentar, $tanggal);
    }

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $conn->error]);
    }
    exit;
}
?>
