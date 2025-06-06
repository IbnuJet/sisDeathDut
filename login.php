<?php
session_start(); // ⬅️ Harus paling atas!

// Koneksi ke database
$host = "localhost";
$user = "root";
$password = "";
$db = "reserv_view_resto";

$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari form login
$email = $_POST['email'];
$password = $_POST['password'];

// Cek apakah email terdaftar
$sql = "SELECT * FROM customer WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    $password_hash = $user['password'];

    // Verifikasi password
    if (password_verify($password, $password_hash)) {
        // ✅ Set session untuk nama dan email
        $_SESSION['email'] = $user['email'];
        $_SESSION['nama'] = $user['nama_customer'];

        // Redirect ke dashboard
        header("Location: dashboard.html");
        exit();
    } else {
        // Password salah
        header("Location: signin.html?error=password");
        exit();
    }
} else {
    // Email tidak ditemukan
    header("Location: signin.html?error=email");
    exit();
}

$stmt->close();
$conn->close();
?>
