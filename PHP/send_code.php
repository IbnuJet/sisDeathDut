<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);
$kode = rand(100000, 999999); // contoh kode verifikasi
$to = "quertoon10@gmail.com"; // Ganti dengan alamat email tujuan

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'dhaifanntapzz@gmail.com'; // Ganti dengan email kamu
    $mail->Password   = 'bwanuybqzilycagn'; // Gunakan App Password, bukan password biasa
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('emailkamu@gmail.com', 'App Kamu');
    $mail->addAddress($to);

    $mail->Subject = 'Kode Verifikasi';
    $mail->Body    = 'Kode verifikasi kamu adalah: ' . $kode;

    $mail->send();
    echo 'Kode berhasil dikirim ke email.';
} catch (Exception $e) {
    echo "Failed to send verification code. Error: {$mail->ErrorInfo}";
}
?>
