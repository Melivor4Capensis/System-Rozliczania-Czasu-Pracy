<?php
require_once "../Server/auth.php";
requireRole("kadrowa");
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Rozliczania Czasu Pracy</title>
    <link rel="stylesheet" href="../../style.css">

    <script src="../../JS/userMenu.js" defer></script>
    <script src="../../JS/reportStatusSelectStyleChange.js" defer></script>
</head>

<body>
    <div class="layout-wrapper">
        <header class="primary-header">
            <h1 class="headline">System Rozliczania Czasu Pracy</h1>
            <?php include "../Components/userMenu.php"; ?>
        </header>
        <div class="layout-body">
            <nav class="primary-nav">
                <a href="kalendarzPracy.php">
                    <div class="primary-nav-element">
                        <img src="../../Assets/Calendar-Icon.svg" alt="calendar-icon" class="primary-nav-element-icon">
                        <p class="primary-nav-element-label">Kalendarz pracy</p>
                    </div>
                </a>
                <a href="raportyPracownikow.php">
                    <div class="primary-nav-element active">
                        <img src="../../Assets/Report-Icon.svg" alt="report-icon" class="primary-nav-element-icon">
                        <p class="primary-nav-element-label">Raporty pracowników</p>
                    </div>
                </a>
            </nav>
            <main class="primary-main">
                <h2 class="page-title">Raporty pracowników</h2>
                <table class="report-menagement-table">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Nazwisko</th>
                            <th>Imie</th>
                            <th>Status</th>
                            <th>Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>05.2026</td>
                            <td>Nowak</td>
                            <td>Jan</td>
                            <td>
                                <select class="report-status-select" name="report[0][status]">
                                    <option value="Zatwierdzony">Zatwierdzony</option>
                                    <option value="Do Zatwierdzenia">Do zatwierdzenia</option>
                                </select>
                            </td>
                            <td>
                                <button class="show-report-button">Pokaż</button>
                                <button class="generate-pdf-Button">Wygeneruj PDF</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </main>
        </div>
    </div>
</body>

</html>