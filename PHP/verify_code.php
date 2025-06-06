<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = $_POST['code'] ?? '';
    // Simulate checking code
    if ($code === '123456') {
        echo 'Code verified.';
    } else {
        echo 'Invalid code.';
    }
}
?>
