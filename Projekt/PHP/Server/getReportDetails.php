<?php
session_start();
header("Content-Type: application/json");
include_once "dbConnect.php";
requireRole(['kadrowa'], true);

$reportId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($reportId <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Nieprawidłowe id']);
    exit;
}

$stmt = $db->prepare(
    "SELECT r.id, r.report_month, r.status, r.sent_at, r.approved_at,
            u.id AS user_id, u.name, u.surname, u.role
     FROM reports r
     JOIN users u ON u.id = r.user_id
     WHERE r.id = ?"
);
$stmt->bind_param("i", $reportId);
$stmt->execute();
$report = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$report) {
    http_response_code(404);
    echo json_encode(['success' => false, 'error' => 'Raport nie istnieje']);
    exit;
}

$stmtDays = $db->prepare(
    "SELECT day_date, hours, factor, comment FROM report_days WHERE report_id = ? ORDER BY day_date"
);
$stmtDays->bind_param("i", $reportId);
$stmtDays->execute();
$daysResult = $stmtDays->get_result();

$days = [];
while ($row = $daysResult->fetch_assoc()) {
    $days[] = $row;
}
$stmtDays->close();
$db->close();

echo json_encode(['success' => true, 'report' => $report, 'days' => $days]);
