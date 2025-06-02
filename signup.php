<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = $_POST['name'] ?? '';
    $email    = $_POST['email'] ?? '';
    $phone    = $_POST['phone'] ?? '';
    $gender   = $_POST['gender'] ?? '';
    $password = $_POST['password'] ?? '';

    // Simulate saving data
    echo 'Sign Up Successful!<br>';
    echo 'Name   : ' . $name . '<br>';
    echo 'Email  : ' . $email . '<br>';
    echo 'Phone  : ' . $phone . '<br>';
    echo 'Gender : ' . $gender . '<br>';
}
?>
