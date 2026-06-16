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

    <script src="../../JS/monthPicker(manager).js" defer></script>
    <script src="../../JS/dayTypeSelectStyleChange.js" defer></script>
    <script src="../../JS/userMenu.js" defer></script>
    <script type="module" src="../../JS/AJAX/calendarMain.js" defer></script>
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
                    <div class="primary-nav-element active">
                        <img src="../../Assets/Calendar-Icon.svg" alt="calendar-icon" class="primary-nav-element-icon">
                        <p class="primary-nav-element-label">Kalendarz pracy</p>
                    </div>
                </a>
                <a href="raportyPracownikow.php">
                    <div class="primary-nav-element">
                        <img src="../../Assets/Report-Icon.svg" alt="report-icon" class="primary-nav-element-icon">
                        <p class="primary-nav-element-label">Raporty pracowników</p>
                    </div>
                </a>
            </nav>
            <main class="primary-main">
                <h2 class="page-title">Kalendarz pracy</h2>
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
                <table id="calendarTable" class="date-management-table">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Dzień tygodnia</th>
                            <th>Typ dnia</th>
                            <th>Opis</th>
                        </tr>
                    </thead>
                    <tbody id="calendarTbody">
                        <tr>
                            <td>
                                01.05.2026
                                <input type="hidden" name="day[0][date]">
                            </td>
                            <td>Piątek</td>
                            <td>
                                <select class="day-type-select" name="day[0][type]">
                                    <option value="Wolny">Wolny</option>
                                    <option value="Roboczy">Roboczy</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="day[0][description]" class="day-description-input">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                02.05.2026
                                <input type="hidden" name="day[1][date]">
                            </td>
                            <td>Piątek</td>
                            <td>
                                <select class="day-type-select" name="day[1][type]">
                                    <option value="Wolny">Wolny</option>
                                    <option value="Roboczy">Roboczy</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="day[1][description]" class="day-description-input">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                03.05.2026
                                <input type="hidden" name="day[2][date]">
                            </td>
                            <td>Piątek</td>
                            <td>
                                <select class="day-type-select" name="day[2][type]">
                                    <option value="Wolny">Wolny</option>
                                    <option value="Roboczy" selected>Roboczy</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="day[2][description]" class="day-description-input">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="save-toast" id="saveToast" role="status" aria-live="polite">
                    <div class="save-toast-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                            <line x1="12" y1="9" x2="12" y2="13" />
                            <line x1="12" y1="17" x2="12.01" y2="17" />
                        </svg>
                    </div>
                    <div class="save-toast-text">
                        <p class="save-toast-title">Niezapisane zmiany</p>
                        <p class="save-toast-sub">Tabela zawiera niezapisane dane</p>
                    </div>
                    <div class="save-toast-actions">
                        <button class="toast-btn-discard" id="toastDiscard">Odrzuć</button>
                        <button class="toast-btn-save" id="toastSave">Zapisz</button>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>