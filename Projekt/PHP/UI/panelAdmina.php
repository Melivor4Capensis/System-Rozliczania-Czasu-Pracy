<?php
require_once "../Server/auth.php";
requireRole("admin");
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Rozliczania Czasu Pracy</title>
    <link rel="stylesheet" href="../../style.css">

    <script src="../../JS/userMenu.js" defer></script>
    <script type="module" src="../../JS/AJAX/panelAdminaToast.js" defer></script>
    <script type="module" src="../../JS/userManagmentMain.js" defer></script>
    <script type="module" src="../../JS/addUserButton.js" defer></script>
    
</head>

<body>
    <div class="layout-wrapper">
        <header class="primary-header">
            <h1 class="headline">System Rozliczania Czasu Pracy</h1>
            <?php include "../Components/userMenu.php"; ?>
        </header>
        <div class="layout-body">
            <nav class="primary-nav">
                <a href="panelAdmina.php">
                    <div class="primary-nav-element active">
                        <img src="../../Assets/Report-Icon.svg" alt="report-icon" class="primary-nav-element-icon">
                        <p class="primary-nav-element-label">Zarządzanie użytkownikami</p>
                    </div>
                </a>
            </nav>
            <main class="primary-main" id="primaryMain">
                <h2 class="page-title">Zarządzanie użytkownikami</h2>
                <button id="addUserButton" class="add-user-button">Dodaj użytkownika</button>
                <div>
                    <table class="user-menagement-table" id="userMenagementTable">
                        <thead>
                            <tr>
                                <th>Nazwisko</th>
                                <th>Imie</th>
                                <th>Login</th>
                                <th>Rola</th>
                                <th>Akcje</th>
                            </tr>
                        </thead>
                        <tbody id="userMenagementTbody">
                            
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
                </div>
            </main>
        </div>
    </div>
</body>

</html>