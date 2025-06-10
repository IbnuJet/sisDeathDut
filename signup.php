<?php

session_start();
$_SESSION['id_customer'] = $row['id_customer']; // Simpan id dari DB


// Koneksi ke database
$host = "localhost";
$user = "root";
$password = "";
$db = "reserv_view_resto";

$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari form
$nama_customer = $_POST['name'];
$email = $_POST['email'];
$no_telp = $_POST['phone'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // enkripsi password
$gender = $_POST['gender'];

// Simpan ke tabel customer
$sql = "INSERT INTO customer (nama_customer, email, no_telp, password, gender)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $nama_customer, $email, $no_telp, $password, $gender);

if ($stmt->execute()) {
    // Redirect ke halaman login/signup dengan parameter success
    header("Location: signin.html?success=1");
    exit;
} 
else {
    echo "Gagal sign up: " . $stmt->error;
}


$stmt->close();
$conn->close();
?>
