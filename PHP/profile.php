<?php
session_start();
header('Content-Type: application/json');

$host = "localhost";
$user = "root";
$password = "";
$db = "reserv_view_resto";

// Koneksi ke database
$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) {
    echo json_encode(['error' => 'DB Connection Failed']);
    exit;
}

if (!isset($_SESSION['email'])) {
    echo json_encode(['error' => 'Not logged in']);
    exit;
}

$email = $_SESSION['email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $name = trim($data['name'] ?? '');
    $gender = $data['gender'] ?? '';
    $passwordNew = trim($data['password'] ?? '');

    $updates = [];
    $params = [];
    $types = "";

    if ($name !== "") {
        $updates[] = "nama_customer = ?";
        $params[] = $name;
        $types .= "s";
    }
    if ($gender === "male" || $gender === "female") {
        $updates[] = "gender = ?";
        $params[] = $gender;
        $types .= "s";
    }
    if ($passwordNew !== "") {
        $hashed = password_hash($passwordNew, PASSWORD_DEFAULT);
        $updates[] = "password = ?";
        $params[] = $hashed;
        $types .= "s";
    }

    if (empty($updates)) {
        echo json_encode(['error' => 'No changes submitted']);
        exit;
    }

    $sql = "UPDATE customer SET " . implode(", ", $updates) . " WHERE email = ?";
    $params[] = $email;
    $types .= "s";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Update failed']);
    }
    exit;
}

// Ambil data untuk tampilan profil
$sql = "SELECT nama_customer, email, password, no_telp, gender FROM customer WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

echo json_encode($data);
?>
