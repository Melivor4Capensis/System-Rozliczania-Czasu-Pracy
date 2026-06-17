<?php
session_start();
include_once "../Server/dbConnect.php";
requireRole(['admin']);
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
    <script type="module" src="../../JS/addUserModal.js" defer></script>

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

    <div class="modal-overlay" id="addUserModal">
        <div class="modal-box">
            <button type="button" class="modal-close" id="addUserModalClose">&times;</button>
            <h3 class="modal-title">Dodaj użytkownika</h3>
            <form id="addUserForm" class="modal-form">
                <div>
                    <label class="modal-field-label">Imię</label>
                    <input type="text" class="modal-input" name="newUser[name]" required>
                </div>
                <div>
                    <label class="modal-field-label">Nazwisko</label>
                    <input type="text" class="modal-input" name="newUser[surname]" required>
                </div>
                <div>
                    <label class="modal-field-label">Login</label>
                    <input type="text" class="modal-input" name="newUser[login]" required>
                </div>
                <div>
                    <label class="modal-field-label">Rola</label>
                    <select class="modal-select" name="newUser[role]">
                        <option value="pracownik">Pracownik</option>
                        <option value="kadrowa">Kadrowa</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div>
                    <label class="modal-field-label">Hasło tymczasowe</label>
                    <input type="password" class="modal-input" name="newUser[password]" required>
                </div>
                <p class="errorMessage" id="addUserModalError"></p>
                <div class="modal-actions">
                    <button type="button" class="modal-button-cancel" id="addUserModalCancel">Anuluj</button>
                    <button type="submit" class="modal-button-submit">Dodaj</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
