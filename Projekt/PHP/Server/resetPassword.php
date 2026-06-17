<?php
session_start();
include_once "dbConnect.php";

header('Content-Type: application/json');
requireRole(['admin'], true);

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$id = isset($data['id']) ? (int)$data['id'] : 0;
$password = isset($data['password']) ? $data['password'] : '';

if ($id <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Nieprawidłowe id']);
    exit;
}

if (strlen($password) < 6) {
    http_response_code(422);
    echo json_encode(['success' => false, 'error' => 'Hasło musi mieć minimum 6 znaków']);
    exit;
}

$hashed = password_hash($password, PASSWORD_DEFAULT);

$stmt = $db->prepare("UPDATE users SET password = ?, must_change_password = 1 WHERE id = ?");
$stmt->bind_param("si", $hashed, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Błąd zapisu']);
}

$stmt->close();
$db->close();
