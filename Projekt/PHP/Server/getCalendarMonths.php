<?php
require_once "dbConnect.php";

$result = $db->query("SELECT year, month FROM work_calendar_months");

$existing = [];

while ($row = $result->fetch_assoc()) {
    $key = $row['year'] . '-' . str_pad($row['month'], 2, '0', STR_PAD_LEFT);
    $existing[] = $key;
}

echo json_encode([
    "existing" => $existing
]);