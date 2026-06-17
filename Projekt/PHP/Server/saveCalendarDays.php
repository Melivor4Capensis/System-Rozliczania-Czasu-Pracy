<?php
session_start();
include_once "dbConnect.php";

header('Content-Type: application/json');
requireRole(['kadrowa'], true);

$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!$data || !isset($data['days']) || !is_array($data['days'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Nieprawidłowe dane']);
    exit;
}

$stmt = $db->prepare(
    "INSERT INTO calendar_days (day_date, day_type, description) VALUES (?, ?, ?)
     ON DUPLICATE KEY UPDATE day_type = VALUES(day_type), description = VALUES(description)"
);

$allowedTypes = ['Wolny', 'Roboczy'];
$errors = [];
$fieldErrors = [];
$savedCount = 0;

foreach ($data['days'] as $index => $day) {

    $date = isset($day['date']) ? trim($day['date']) : null;
    $type = isset($day['type']) ? trim($day['type']) : null;
    $description = isset($day['description']) ? trim($day['description']) : '';

    if (!$date || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
        $errors[] = "Wiersz $index: brak prawidłowej daty";
        continue;
    }

    if (!in_array($type, $allowedTypes)) {
        $fieldErrors[] = "day[$index][type]";
        $errors[] = "Wiersz $index: nieprawidłowy typ dnia";
        continue;
    }

    $stmt->bind_param("sss", $date, $type, $description);

    if (!$stmt->execute()) {
        $errors[] = "Wiersz $index: błąd zapisu do bazy";
    } else {
        $savedCount++;
    }
}

$stmt->close();
$db->close();

if (!empty($errors)) {
    http_response_code(207);
    echo json_encode(['success' => false, 'errors' => $errors, 'fieldErrors' => $fieldErrors, 'saved' => $savedCount]);
} else {
    echo json_encode(['success' => true, 'saved' => $savedCount]);
}
