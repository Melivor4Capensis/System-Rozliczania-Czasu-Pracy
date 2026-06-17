<?php
session_start();
include_once "../Server/dbConnect.php";
requireRole(['kadrowa']);

$currYear = (int)date('Y');
$currMonth = (int)date('n');

$year = isset($_GET['year']) ? (int)$_GET['year'] : $currYear;
$month = isset($_GET['month']) ? (int)$_GET['month'] : $currMonth;

if ($month < 1 || $month > 12) {
    $month = $currMonth;
}

$monthValue = sprintf('%04d-%02d', $year, $month);
$daysInMonth = (int)date('t', mktime(0, 0, 0, $month, 1, $year));

$dayNames = ["Poniedziałek", "Wtorek", "Środa", "Czwartek", "Piątek", "Sobota", "Niedziela"];

$stmt = $db->prepare("SELECT day_date, day_type, description FROM calendar_days WHERE day_date LIKE ?");
$likeParam = $monthValue . '-%';
$stmt->bind_param("s", $likeParam);
$stmt->execute();
$result = $stmt->get_result();

$existingDays = [];
while ($row = $result->fetch_assoc()) {
    $existingDays[$row['day_date']] = $row;
}
$stmt->close();
$db->close();
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
    <script type="module" src="../../JS/AJAX/kalendarzPracyToast.js" defer></script>
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
                    <div class="month-picker" id="monthPicker" data-year="<?= $year ?>" data-month="<?= $month ?>">
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
                <table class="date-management-table" id="calendarTable">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Dzień tygodnia</th>
                            <th>Typ dnia</th>
                            <th>Opis</th>
                        </tr>
                    </thead>
                    <tbody id="calendarTbody">
                        <?php for ($day = 1; $day <= $daysInMonth; $day++):
                            $dateValue = sprintf('%04d-%02d-%02d', $year, $month, $day);
                            $weekdayIndex = (int)date('N', mktime(0, 0, 0, $month, $day, $year)) - 1;
                            $existing = $existingDays[$dateValue] ?? null;
                            $dayType = $existing['day_type'] ?? 'Wolny';
                            $description = $existing['description'] ?? '';
                        ?>
                        <tr>
                            <td>
                                <?= sprintf('%02d.%02d.%04d', $day, $month, $year) ?>
                                <input type="hidden" name="day[<?= $day ?>][date]" value="<?= $dateValue ?>">
                            </td>
                            <td><?= $dayNames[$weekdayIndex] ?></td>
                            <td>
                                <select class="day-type-select" name="day[<?= $day ?>][type]">
                                    <option value="Wolny" <?= $dayType === 'Wolny' ? 'selected' : '' ?>>Wolny</option>
                                    <option value="Roboczy" <?= $dayType === 'Roboczy' ? 'selected' : '' ?>>Roboczy</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="day[<?= $day ?>][description]" class="day-description-input" value="<?= htmlspecialchars($description) ?>">
                            </td>
                        </tr>
                        <?php endfor; ?>
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
