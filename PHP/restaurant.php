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

// Query insert
$sql = "INSERT INTO restoran (id_restoran, nama_restoran, lokasi, kategori, jam_operasional)
        VALUES (1, 'Rumah Makan Padang Raya', 'Jl. Sumagung 3, RT.15/RW.2, Klp. Gading Tim., Kec. Klp. Gading, Jkt Utara', 'Asian Food', '09.00 - 20.00 WIB'),
               (2, 'Dimsum Sembilan Naga', 'Ruko Paskal Hypersquare Blok G. 2, Jl. Pasir Kaliki No.25 - 27, Ciroyom, Kec. Andir, Kota Bandung, Jawa Barat', 'Asian Food', '06.00 - 21.30 WIB'),
               (3, 'UNION Plaza Senayan', 'Plaza Senayan, Jl. Asia Afrika No.8 Ground Floor, Gelora, Kecamatan Tanah Abang, Kota Jakarta Pusat,', 'Western Food', '10.00 - 01.00 WIB'),
               (4, 'Queen's Tandoor', 'Jl. Raya Seminyak No.1, Seminyak, Kec. Kuta, Kabupaten Badung, Bali', 'Indian Food', '12.00 - 00.00 WITA'),
               (5, 'AL GHIFARI KEBAB & BURGER(G.2)', 'Jl. Bukit Puri Sukamaju, Tanimulya, Kec. Ngamprah, Kabupaten Bandung Barat, Jawa Barat', 'Middle Eastern Food', '09.00 - 17.00 WIB'),
               (6, 'Opa Resto', 'Jalan Sunter Karya Blok e7 No 14 Kompleks DKI, Sunter Agung Podomoro, RT.3/RW.13, Sunter Agung, Kec. Tj. Priok, North Jakarta', 'Mediterranean Food', '10.00 - 21.00'),
               (7, 'Nasi Kebuli Mbah Soleh Ngru-Q', 'Jl. Perintis Kemerdekaan No.66, Sondakan, Kec. Laweyan, Kota Surakarta, Jawa Tengah', 'Middle Eastern Food', '08.00- 20.30'),
               (8, 'DIL RANI RESTAURANT', 'Jl. Komp. Colombo No.50, Mrican, Caturtunggal, Kec. Depok, Kabupaten Sleman, Daerah Istimewa Yogyakarta', 'Indian Food', '10.00 - 22.00'),
               (9, 'Bottega Ristorante', 'Gedung Fairgrounds No.Kav 52-53, Jl. Scbd No.Lot 14, RT.5/RW.3, Senayan, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta', 'Western Food', '11.00 - 22.00'),
               (10, 'Blue Olives Taverna', 'Jl. Kawaluyaan II 24-20, Jatisari, Kec. Buahbatu, Kota Bandung, Jawa Barat', 'Mediterranean Food', '07.00 - 22.00')";
if ($conn->query($sql) === TRUE) {
    echo "Data restoran berhasil ditambahkan.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
