<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pass = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    if ($pass === $confirm && !empty($pass)) {
        echo 'Password reset successful!';
    } else {
        echo 'Passwords do not match!';
    }
}
?>
