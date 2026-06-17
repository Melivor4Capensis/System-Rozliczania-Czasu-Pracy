<?php
session_start();
header("Content-Type: application/json");
include_once "dbConnect.php";
requireRole(['pracownik', 'kadrowa'], true);

$month = isset($_GET['month']) ? $_GET['month'] : null;
$userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : (int)$_SESSION['id'];

if ($_SESSION['role'] === 'pracownik') {
    $userId = (int)$_SESSION['id'];
}

if (!$month || !preg_match('/^\d{4}-\d{2}$/', $month)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Nieprawidłowy miesiąc']);
    exit;
}

$stmtCalendar = $db->prepare("SELECT day_date, day_type, description FROM calendar_days WHERE day_date LIKE ? ORDER BY day_date");
$likeParam = $month . '-%';
$stmtCalendar->bind_param("s", $likeParam);
$stmtCalendar->execute();
$calendarResult = $stmtCalendar->get_result();

$calendarDays = [];
while ($row = $calendarResult->fetch_assoc()) {
    $calendarDays[$row['day_date']] = $row;
}
$stmtCalendar->close();

if (count($calendarDays) === 0) {
    echo json_encode(['success' => true, 'planExists' => false]);
    exit;
}

$stmtReport = $db->prepare("SELECT id, status, sent_at, approved_at FROM reports WHERE user_id = ? AND report_month = ?");
$stmtReport->bind_param("is", $userId, $month);
$stmtReport->execute();
$report = $stmtReport->get_result()->fetch_assoc();
$stmtReport->close();

$reportDays = [];

if ($report) {
    $stmtDays = $db->prepare("SELECT day_date, hours, factor, comment FROM report_days WHERE report_id = ?");
    $stmtDays->bind_param("i", $report['id']);
    $stmtDays->execute();
    $daysResult = $stmtDays->get_result();

    while ($row = $daysResult->fetch_assoc()) {
        $reportDays[$row['day_date']] = $row;
    }
    $stmtDays->close();
}

$db->close();

echo json_encode([
    'success' => true,
    'planExists' => true,
    'calendarDays' => $calendarDays,
    'report' => $report ?: null,
    'reportDays' => $reportDays,
]);
