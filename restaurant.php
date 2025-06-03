<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = ""; // default XAMPP kosong
$dbname = "reserv_view_resto";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk ambil data restoran
$sql = "SELECT id_restoran, nama_restoran, lokasi, kategori, jam_operasional FROM restoran";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Daftar Restoran</h2>";
    echo "<table border='1' cellpadding='10'>";
    echo "<tr><th>ID</th><th>Nama Restoran</th><th>Lokasi</th><th>Kategori</th><th>Jam Operasional</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id_restoran"] . "</td>";
        echo "<td>" . $row["nama_restoran"] . "</td>";
        echo "<td>" . $row["lokasi"] . "</td>";
        echo "<td>" . $row["kategori"] . "</td>";
        echo "<td>" . $row["jam_operasional"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Data restoran tidak ditemukan.";
}

$conn->close();
?>
