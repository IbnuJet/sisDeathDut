<?php
session_start();

$host = "localhost";
$user = "root";
$password = "";
$db = "reserv_view_resto";

$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM customer WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    $password_hash = $user['password'];

    if (password_verify($password, $password_hash)) {
        $_SESSION['id_customer'] = $user['id_customer'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['nama'] = $user['nama_customer'];

        header("Location: dashboard.html");
        exit();
    } else {
        header("Location: signin.html?error=password");
        exit();
    }
} else {
    header("Location: signin.html?error=email");
    exit();
}

$stmt->close();
$conn->close();
?>
