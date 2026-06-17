<?php
session_start();
include_once "../Server/dbConnect.php";
requireRole(['kadrowa']);
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
    <script type="module" src="../../JS/raportyPracownikowMain.js" defer></script>
    <script type="module" src="../../JS/AJAX/raportyPracownikowToast.js" defer></script>
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
            <main class="primary-main" id="primaryMain">
                <h2 class="page-title">Raporty pracowników</h2>
                <table class="report-menagement-table" id="reportMenagementTable">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Nazwisko</th>
                            <th>Imie</th>
                            <th>Status</th>
                            <th>Akcje</th>
                        </tr>
                    </thead>
                    <tbody id="reportMenagementTbody"></tbody>
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

    <div class="report-preview-overlay" id="reportPreviewOverlay">
        <div class="report-preview-sheet" id="reportPreviewSheet"></div>
    </div>
</body>

</html>
