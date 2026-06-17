<?php
session_start();
include_once "dbConnect.php";

header('Content-Type: application/json');
requireRole(['admin'], true);

$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!$data || !isset($data['users']) || !is_array($data['users'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Nieprawidłowe dane']);
    exit;
}

$stmtUpdate = $db->prepare("UPDATE users SET surname=?, name=?, login=?, role=? WHERE id=?");

$allowedRoles = ['pracownik', 'kadrowa', 'admin'];
$errors = [];
$fieldErrors = [];
$savedCount = 0;

foreach ($data['users'] as $index => $user) {

    $id = isset($user['id']) ? $user['id'] : null;
    $surname = isset($user['surname']) ? trim($user['surname']) : null;
    $name = isset($user['name']) ? trim($user['name']) : null;
    $login = isset($user['login']) ? trim($user['login']) : null;
    $role = isset($user['role']) ? trim($user['role']) : null;

    if ($id === null || $id === 'new') {
        $errors[] = "Wiersz $index: brak identyfikatora użytkownika";
        continue;
    }

    if (!$surname) {
        $fieldErrors[] = "user[$id][surname]";
    }
    if (!$name) {
        $fieldErrors[] = "user[$id][name]";
    }
    if (!$login) {
        $fieldErrors[] = "user[$id][login]";
    }

    if (!$surname || !$name || !$login || !$role) {
        $errors[] = "Wiersz $index: brakujące pola";
        continue;
    }

    if (!in_array($role, $allowedRoles)) {
        $errors[] = "Wiersz $index: niedozwolona rola '$role'";
        continue;
    }

    $id = (int) $id;
    $stmtUpdate->bind_param("ssssi", $surname, $name, $login, $role, $id);

    if (!$stmtUpdate->execute()) {
        $errors[] = "Wiersz $index: błąd zapisu do bazy";
    } else {
        $savedCount++;
    }
}

$stmtUpdate->close();
$db->close();

if (!empty($errors)) {
    http_response_code(207);
    echo json_encode(['success' => false, 'errors' => $errors, 'fieldErrors' => $fieldErrors, 'saved' => $savedCount]);
} else {
    echo json_encode(['success' => true, 'saved' => $savedCount]);
}
