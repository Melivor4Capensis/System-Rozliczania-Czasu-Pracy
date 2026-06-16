<?php

$userFullName = $_SESSION['name'] . ' ' . $_SESSION['surname'];

$roleLabels = [
    'admin' => 'Administrator',
    'kadrowa' => 'Kadrowa',
    'pracownik' => 'Pracownik'
];

$userRoleLabel = $roleLabels[$_SESSION['role']] ?? $_SESSION['role'];
?>

<div class="user-menu" id="userMenu">
    <div class="user-menu-trigger" id="userMenuTrigger">
        <p>Zalogowano jako: <?= htmlspecialchars($userFullName) ?></p>

        <svg class="user-menu-chevron" viewBox="0 0 14 14" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path d="M3 5l4 4 4-4"
                stroke="white"
                stroke-width="1.5"
                stroke-linecap="round"
                stroke-linejoin="round" />
        </svg>
    </div>

    <div class="user-menu-dropdown" id="userMenuDropdown">

        <div class="user-menu-info">
            <div class="user-menu-name">
                <?= htmlspecialchars($userFullName) ?>
            </div>

            <div class="user-menu-role">
                <?= htmlspecialchars($userRoleLabel) ?>
            </div>
        </div>

        <div class="user-menu-items">

            <button
                class="user-menu-item danger"
                onclick="window.location.href='../Server/logout.php'">

                <svg width="15"
                    height="15"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round">

                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <polyline points="16 17 21 12 16 7" />
                    <line x1="21" y1="12" x2="9" y2="12" />
                </svg>

                Wyloguj się

            </button>

        </div>

    </div>
</div>