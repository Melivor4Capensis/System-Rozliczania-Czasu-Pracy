<?php
header("Content-Type: application/json");
include_once "dbConnect.php";

$toLoad = isset($_GET["toLoad"]) ? (int)$_GET["toLoad"] : 20;
$loadedUsers = isset($_GET["loaded"]) ? (int)$_GET["loaded"] : 0;

$stmt = $db->prepare("SELECT id, name, surname, login, role FROM users ORDER BY id LIMIT ? OFFSET ?");
$stmt->bind_param("ii", $toLoad, $loadedUsers);
$stmt->execute();

$result = $stmt->get_result();

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

$stmt->close();
$db->close();

echo json_encode($users);