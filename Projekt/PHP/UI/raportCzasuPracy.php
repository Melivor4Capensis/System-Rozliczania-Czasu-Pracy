<?php
session_start();
include_once "../Server/dbConnect.php";
requireRole(['pracownik']);
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Rozliczania Czasu Pracy</title>
    <link rel="stylesheet" href="../../style.css">

    <script type="module" src="../../JS/monthPicker(employee).js" defer></script>
    <script src="../../JS/userMenu.js" defer></script>
    <script type="module" src="../../JS/AJAX/sendReportButton.js" defer></script>
</head>

<body>
    <div class="layout-wrapper">
        <header class="primary-header">
            <h1 class="headline">System Rozliczania Czasu Pracy</h1>
            <div class="user-menu" id="userMenu">
                <div class="user-menu-trigger" id="userMenuTrigger">
                    <p>Zalogowano jako: Anna Nowak</p>
                    <svg class="user-menu-chevron" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 5l4 4 4-4" stroke="white" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>
                <div class="user-menu-dropdown" id="userMenuDropdown">
                    <div class="user-menu-info">
                        <div class="user-menu-name">Anna Nowak</div>
                        <div class="user-menu-role">Kadrowa</div>
                    </div>
                    <div class="user-menu-items">
                        <button class="user-menu-item danger">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                <polyline points="16 17 21 12 16 7" />
                                <line x1="21" y1="12" x2="9" y2="12" />
                            </svg>
                            Wyloguj się
                        </button>
                    </div>
                </div>
            </div>
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
                <p class="report-locked-notice" id="reportLockedNotice">Raport za ten miesiąc został zatwierdzony przez kadrową i nie można go już edytować.</p>
                <p class="report-empty-state" id="reportEmptyState"></p>
                <table class="workTime-report-table" id="reportTable" style="display:none;">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Dzień tygodnia</th>
                            <th>Liczba godzin</th>
                            <th>Współczynnik</th>
                            <th>Komentarz</th>
                        </tr>
                    </thead>
                    <tbody id="reportTbody"></tbody>
                </table>
                <div class="send-report-wrapper" id="sendReportWrapper" style="display:none;">
                    <button class="send-report-button" id="sendReportButton">Wyślij raport do zatwierdzenia</button>
                </div>
            </main>
        </div>
    </div>
</body>

</html>
