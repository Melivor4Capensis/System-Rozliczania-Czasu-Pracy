<?php
session_start();
header("Content-Type: application/json");
include_once "dbConnect.php";
requireRole(['kadrowa', 'pracownik'], true);

$month = isset($_GET['month']) ? $_GET['month'] : null;

if (!$month || !preg_match('/^\d{4}-\d{2}$/', $month)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Nieprawidłowy miesiąc']);
    exit;
}

$stmt = $db->prepare("SELECT day_date, day_type, description FROM calendar_days WHERE day_date LIKE ?");
$likeParam = $month . '-%';
$stmt->bind_param("s", $likeParam);
$stmt->execute();

$result = $stmt->get_result();

$days = [];
while ($row = $result->fetch_assoc()) {
    $days[$row['day_date']] = [
        'type' => $row['day_type'],
        'description' => $row['description'],
    ];
}

$stmt->close();
$db->close();

echo json_encode(['success' => true, 'exists' => count($days) > 0, 'days' => $days]);
