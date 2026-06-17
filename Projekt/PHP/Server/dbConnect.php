<?php
$db = new mysqli("localhost", "root", "", "settlement_system");

if ($db->connect_error) {
    die("Błąd połączenia z bazą danych");
}

function requireRole(array $allowedRoles, bool $jsonResponse = false): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $unauthorized = !isset($_SESSION['id'], $_SESSION['role']) || !in_array($_SESSION['role'], $allowedRoles, true);

    if (!$unauthorized) {
        return;
    }

    if ($jsonResponse) {
        header("Content-Type: application/json");
        http_response_code(403);
        echo json_encode(['success' => false, 'error' => 'Brak uprawnień']);
        exit;
    }

    header("Location: /Projekt/index.php");
    exit;
}