<?php
session_start();
include_once "dbConnect.php";

header('Content-Type: application/json');
requireRole(['admin'], true);

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$id = isset($data['id']) ? (int)$data['id'] : 0;

if ($id <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Nieprawidłowe id']);
    exit;
}

if ($id === (int)$_SESSION['id']) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Nie można usunąć własnego konta']);
    exit;
}

$stmt = $db->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Błąd usuwania']);
}

$stmt->close();
$db->close();
