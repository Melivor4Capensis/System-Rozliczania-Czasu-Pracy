<?php
session_start();
header("Content-Type: application/json");
include_once "dbConnect.php";
requireRole(['pracownik'], true);

$userId = (int)$_SESSION['id'];

$monthsResult = $db->query(
    "SELECT DISTINCT DATE_FORMAT(day_date, '%Y-%m') AS month FROM calendar_days WHERE day_type = 'Roboczy'"
);

$months = [];
while ($row = $monthsResult->fetch_assoc()) {
    $months[$row['month']] = ['hasPlan' => true, 'status' => null];
}

$stmt = $db->prepare("SELECT report_month, status FROM reports WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $months[$row['report_month']]['hasPlan'] = true;
    $months[$row['report_month']]['status'] = $row['status'];
}

$stmt->close();
$db->close();

echo json_encode(['success' => true, 'months' => $months]);
