<?php
session_start();
header('Content-Type: application/json');

echo json_encode([
  'id_customer' => $_SESSION['id_customer'] ?? null
]);
