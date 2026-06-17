<?php
session_start();
header("Content-Type: application/json");
include_once "dbConnect.php";

if (!isset($_SESSION['id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Brak sesji']);
    exit;
}

$stmt = $db->prepare("SELECT name, surname, role FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();
$db->close();

if (!$user) {
    http_response_code(404);
    echo json_encode(['success' => false, 'error' => 'Użytkownik nie istnieje']);
    exit;
}

echo json_encode(['success' => true, 'user' => $user]);
