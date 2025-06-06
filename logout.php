<?php
session_start();
session_destroy(); // Menghapus semua session
header("Location: signIn.html"); // Arahkan ke halaman login
exit;
?>
