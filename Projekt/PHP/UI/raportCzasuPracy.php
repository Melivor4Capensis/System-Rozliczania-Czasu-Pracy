<?php
require_once "../Server/auth.php";
requireRole("pracownik");
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Rozliczania Czasu Pracy</title>
    <link rel="stylesheet" href="../../style.css">

    <script src="../../JS/monthPicker(employee).js" defer></script>
    <script src="../../JS/userMenu.js" defer></script>
</head>

<body>
    <div class="layout-wrapper">
        <header class="primary-header">
            <h1 class="headline">System Rozliczania Czasu Pracy</h1>
            <?php include "../Components/userMenu.php"; ?>
        </header>
        <div class="layout-body">
            <nav class="primary-nav">
                <a href="raportCzasuPracy.php">
                    <div class="primary-nav-element active">
                        <img src="../../Assets/Calendar-Icon.svg" alt="calendar-icon" class="primary-nav-element-icon">
                        <p class="primary-nav-element-label">Raport czasu pracy</p>
                    </div>
                </a>
            </nav>
            <main class="primary-main">
                <h2 class="page-title">Raport czasu pracy</h2>
                <div class="month-picker-wrapper">
                    <button class="month-step-nav" id="monthPrev">&#8249;</button>
                    <div class="month-picker" id="monthPicker">
                        <span class="month-picker-icon">
                            <img src="../../Assets/Calendar-Icon.svg" alt="" class="month-picker-cal-icon">
                        </span>
                        <span class="month-picker-label" id="monthLabel">Maj 2026</span>
                        <div class="month-picker-dropdown" id="monthDropdown">
                            <div class="month-picker-header">
                                <button class="month-picker-nav" id="yearPrev">&#8249;</button>
                                <span class="month-picker-year" id="yearLabel">2026</span>
                                <button class="month-picker-nav" id="yearNext">&#8250;</button>
                            </div>
                            <div class="month-picker-grid" id="monthGrid"></div>
                        </div>
                    </div>
                    <button class="month-step-nav" id="monthNext">&#8250;</button>
                </div>
                <table class="workTime-report-table">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Dzień tygodnia</th>
                            <th>Liczba godzin</th>
                            <th>Współczynnik</th>
                            <th>Komentarz</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>01.01.2026
                                <input type="hidden" name="day[0][date]">
                            </td>
                            <td>Piątek</td>
                            <td><input type="number" min="0" value="0" name="day[0][hours]"></td>
                            <td><input type="number" min="0" value="0" name="day[0][factor]"></td>
                            <td><input type="text" name="day[0][comment]"></td>
                        </tr>
                    </tbody>
                </table>
            </main>
        </div>
    </div>
</body>

</html>