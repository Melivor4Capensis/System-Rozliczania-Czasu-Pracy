<?php
session_start();
include_once "dbConnect.php";

header('Content-Type: application/json');
requireRole(['pracownik'], true);

$userId = (int)$_SESSION['id'];

$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!$data || !isset($data['month'], $data['days']) || !is_array($data['days'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Nieprawidłowe dane']);
    exit;
}

$month = trim($data['month']);

if (!preg_match('/^\d{4}-\d{2}$/', $month)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Nieprawidłowy miesiąc']);
    exit;
}

$stmtCheck = $db->prepare("SELECT id, status FROM reports WHERE user_id = ? AND report_month = ?");
$stmtCheck->bind_param("is", $userId, $month);
$stmtCheck->execute();
$existing = $stmtCheck->get_result()->fetch_assoc();
$stmtCheck->close();

if ($existing && $existing['status'] === 'Zatwierdzony') {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Raport został już zatwierdzony i nie można go edytować']);
    exit;
}

if ($existing) {
    $reportId = $existing['id'];
    $stmtUpdate = $db->prepare("UPDATE reports SET status = 'Wyslany', sent_at = NOW() WHERE id = ?");
    $stmtUpdate->bind_param("i", $reportId);
    $stmtUpdate->execute();
    $stmtUpdate->close();
} else {
    $stmtInsert = $db->prepare("INSERT INTO reports (user_id, report_month, status, sent_at) VALUES (?, ?, 'Wyslany', NOW())");
    $stmtInsert->bind_param("is", $userId, $month);
    $stmtInsert->execute();
    $reportId = $db->insert_id;
    $stmtInsert->close();
}

$stmtDay = $db->prepare(
    "INSERT INTO report_days (report_id, day_date, hours, factor, comment) VALUES (?, ?, ?, ?, ?)
     ON DUPLICATE KEY UPDATE hours = VALUES(hours), factor = VALUES(factor), comment = VALUES(comment)"
);

$errors = [];
$fieldErrors = [];
$savedCount = 0;

foreach ($data['days'] as $index => $day) {

    $date = isset($day['date']) ? trim($day['date']) : null;
    $hours = isset($day['hours']) ? $day['hours'] : 0;
    $factor = isset($day['factor']) ? $day['factor'] : 0;
    $comment = isset($day['comment']) ? trim($day['comment']) : '';

    if (!$date || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
        $errors[] = "Wiersz $index: brak prawidłowej daty";
        continue;
    }

    if (!is_numeric($hours) || (float)$hours < 0) {
        $fieldErrors[] = "day[$index][hours]";
        $errors[] = "Wiersz $index: nieprawidłowa liczba godzin";
        continue;
    }

    $hours = (float)$hours;
    $factor = is_numeric($factor) ? (float)$factor : 0;

    $stmtDay->bind_param("isdds", $reportId, $date, $hours, $factor, $comment);

    if (!$stmtDay->execute()) {
        $errors[] = "Wiersz $index: błąd zapisu do bazy";
    } else {
        $savedCount++;
    }
}

$stmtDay->close();
$db->close();

if (!empty($errors)) {
    http_response_code(207);
    echo json_encode(['success' => false, 'errors' => $errors, 'fieldErrors' => $fieldErrors, 'saved' => $savedCount]);
} else {
    echo json_encode(['success' => true, 'saved' => $savedCount]);
}
