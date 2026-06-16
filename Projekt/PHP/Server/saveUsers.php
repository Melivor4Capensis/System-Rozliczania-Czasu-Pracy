<?php
include_once "dbConnect.php";

header('Content-Type: application/json');

$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!$data || !isset($data['users']) || !is_array($data['users'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Nieprawidłowe dane']);
    exit;
}

$stmtUpdate = $db->prepare("UPDATE users SET surname=?, name=?, login=?, role=? WHERE id=?");
$stmtInsert = $db->prepare("INSERT INTO users (surname, name, login, role) VALUES (?, ?, ?, ?)");

$allowedRoles = ['pracownik', 'kadrowa', 'admin'];
$errors = [];
$inserted = [];

foreach ($data['users'] as $index => $user) {

    $id = isset($user['id']) ? $user['id'] : null;
    $surname = isset($user['surname']) ? trim($user['surname']) : null;
    $name = isset($user['name']) ? trim($user['name']) : null;
    $login = isset($user['login']) ? trim($user['login']) : null;
    $role = isset($user['role']) ? trim($user['role']) : null;

    if ($id === null || !$surname || !$name || !$login || !$role) {
        $errors[] = "Wiersz $index: brakujące pola";
        continue;
    }

    if (!in_array($role, $allowedRoles)) {
        $errors[] = "Wiersz $index: niedozwolona rola '$role'";
        continue;
    }

    if ($id === 'new') {
        $stmtInsert->bind_param("ssss", $surname, $name, $login, $role);

        if (!$stmtInsert->execute()) {
            $errors[] = "Wiersz $index: błąd zapisu do bazy";
        } else {
            $inserted[] = $db->insert_id;
        }
    } else {
        $id = (int) $id;
        $stmtUpdate->bind_param("ssssi", $surname, $name, $login, $role, $id);

        if (!$stmtUpdate->execute()) {
            $errors[] = "Wiersz $index: błąd zapisu do bazy";
        }
    }
}

$stmtUpdate->close();
$stmtInsert->close();
$db->close();

if (!empty($errors)) {
    http_response_code(207);
    echo json_encode(['success' => false, 'errors' => $errors, 'inserted_ids' => $inserted]);
} else {
    echo json_encode(['success' => true, 'inserted_ids' => $inserted]);
}