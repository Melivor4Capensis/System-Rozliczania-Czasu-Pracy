<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $db = new mysqli("localhost", "root", "", "settlement_system");
    $db->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
    die("Błąd połączenia z bazą danych");
}