<?php
session_start();
include_once "dbConnect.php";

header('Content-Type: application/json');
requireRole(['kadrowa'], true);

$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!$data || !isset($data['reports']) || !is_array($data['reports'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Nieprawidłowe dane']);
    exit;
}

$allowedStatuses = ['Wyslany', 'Zatwierdzony'];
$errors = [];
$fieldErrors = [];
$savedCount = 0;

$stmtApprove = $db->prepare("UPDATE reports SET status = 'Zatwierdzony', approved_at = NOW() WHERE id = ?");
$stmtRevert = $db->prepare("UPDATE reports SET status = 'Wyslany', approved_at = NULL WHERE id = ?");

foreach ($data['reports'] as $index => $report) {

    $id = isset($report['id']) ? (int)$report['id'] : 0;
    $status = isset($report['status']) ? trim($report['status']) : null;

    if ($id <= 0) {
        $errors[] = "Wiersz $index: brak identyfikatora raportu";
        continue;
    }

    if (!in_array($status, $allowedStatuses)) {
        $fieldErrors[] = "report[$id][status]";
        $errors[] = "Wiersz $index: nieprawidłowy status";
        continue;
    }

    $stmt = $status === 'Zatwierdzony' ? $stmtApprove : $stmtRevert;
    $stmt->bind_param("i", $id);

    if (!$stmt->execute()) {
        $errors[] = "Wiersz $index: błąd zapisu do bazy";
    } else {
        $savedCount++;
    }
}

$stmtApprove->close();
$stmtRevert->close();
$db->close();

if (!empty($errors)) {
    http_response_code(207);
    echo json_encode(['success' => false, 'errors' => $errors, 'fieldErrors' => $fieldErrors, 'saved' => $savedCount]);
} else {
    echo json_encode(['success' => true, 'saved' => $savedCount]);
}
