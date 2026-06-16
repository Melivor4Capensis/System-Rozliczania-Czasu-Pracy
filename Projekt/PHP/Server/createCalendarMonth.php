<?php
require_once "auth.php";
requireRole("kadrowa");

require_once "dbConnect.php";

$data = json_decode(file_get_contents("php://input"), true);

$year = (int)$data['year'];
$month = (int)$data['month'];

$stmt = $db->prepare("INSERT IGNORE INTO work_calendar_months (year, month, created_by) VALUES (?, ?, ?)");
$stmt->bind_param("iii", $year, $month, $_SESSION['id']);
$stmt->execute();

$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

$stmtDay = $db->prepare("
    INSERT IGNORE INTO work_calendar (date, type, created_by)
    VALUES (?, 'Roboczy', ?)
");

for ($d = 1; $d <= $daysInMonth; $d++) {

    $date = sprintf("%04d-%02d-%02d", $year, $month, $d);

    $stmtDay->bind_param("si", $date, $_SESSION['id']);
    $stmtDay->execute();
}

echo json_encode(["status" => "ok"]);