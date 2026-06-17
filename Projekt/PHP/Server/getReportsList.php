<?php
session_start();
header("Content-Type: application/json");
include_once "dbConnect.php";
requireRole(['kadrowa'], true);

$toLoad = isset($_GET["toLoad"]) ? (int)$_GET["toLoad"] : 20;
$loadedReports = isset($_GET["loaded"]) ? (int)$_GET["loaded"] : 0;

$stmt = $db->prepare(
    "SELECT r.id, r.report_month, r.status, u.id AS user_id, u.surname, u.name
     FROM reports r
     JOIN users u ON u.id = r.user_id
     ORDER BY r.report_month DESC, u.surname
     LIMIT ? OFFSET ?"
);
$stmt->bind_param("ii", $toLoad, $loadedReports);
$stmt->execute();

$result = $stmt->get_result();

$reports = [];
while ($row = $result->fetch_assoc()) {
    $reports[] = $row;
}

$stmt->close();
$db->close();

echo json_encode($reports);
