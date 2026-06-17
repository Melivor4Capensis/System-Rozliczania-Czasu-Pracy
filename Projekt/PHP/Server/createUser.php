<?php
session_start();
include_once "dbConnect.php";

header('Content-Type: application/json');
requireRole(['admin'], true);

$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!$data) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Nieprawidłowe dane']);
    exit;
}

$surname = isset($data['surname']) ? trim($data['surname']) : '';
$name = isset($data['name']) ? trim($data['name']) : '';
$login = isset($data['login']) ? trim($data['login']) : '';
$role = isset($data['role']) ? trim($data['role']) : '';
$password = isset($data['password']) ? $data['password'] : '';

$allowedRoles = ['pracownik', 'kadrowa', 'admin'];
$fieldErrors = [];

if (!$surname) $fieldErrors[] = 'newUser[surname]';
if (!$name) $fieldErrors[] = 'newUser[name]';
if (!$login) $fieldErrors[] = 'newUser[login]';
if (!in_array($role, $allowedRoles)) $fieldErrors[] = 'newUser[role]';
if (strlen($password) < 6) $fieldErrors[] = 'newUser[password]';

if (!empty($fieldErrors)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'error' => 'Uzupełnij wszystkie pola poprawnie', 'fieldErrors' => $fieldErrors]);
    exit;
}

$stmtCheck = $db->prepare("SELECT id FROM users WHERE login = ?");
$stmtCheck->bind_param("s", $login);
$stmtCheck->execute();

if ($stmtCheck->get_result()->fetch_assoc()) {
    $stmtCheck->close();
    http_response_code(422);
    echo json_encode(['success' => false, 'error' => 'Login jest już zajęty', 'fieldErrors' => ['newUser[login]']]);
    exit;
}
$stmtCheck->close();

$hashed = password_hash($password, PASSWORD_DEFAULT);

$stmtInsert = $db->prepare("INSERT INTO users (surname, name, login, password, role, must_change_password) VALUES (?, ?, ?, ?, ?, 1)");
$stmtInsert->bind_param("sssss", $surname, $name, $login, $hashed, $role);

if ($stmtInsert->execute()) {
    echo json_encode(['success' => true, 'id' => $db->insert_id]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Błąd zapisu do bazy']);
}

$stmtInsert->close();
$db->close();
