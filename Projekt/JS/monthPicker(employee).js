import { loadReportForMonth } from './AJAX/reportLoader.js';

const picker = document.getElementById('monthPicker');
const label = document.getElementById('monthLabel');
const yearLbl = document.getElementById('yearLabel');
const grid = document.getElementById('monthGrid');

const months = ["Sty", "Lut", "Mar", "Kwi", "Maj", "Cze",
    "Lip", "Sie", "Wrz", "Paź", "Lis", "Gru"];
const monthsFull = ["Styczeń", "Luty", "Marzec", "Kwiecień", "Maj", "Czerwiec",
    "Lipiec", "Sierpień", "Wrzesień", "Październik", "Listopad", "Grudzień"];

const currDate = new Date();

let selected = { year: currDate.getFullYear(), month: currDate.getMonth() };
let viewYear = currDate.getFullYear();
let availableMonths = {};

function monthKey(year, month) {
    return `${year}-${String(month + 1).padStart(2, '0')}`;
}

function getCellState(year, month) {
    const info = availableMonths[monthKey(year, month)];
    if (!info) return 'none';
    if (info.status === 'Zatwierdzony') return 'approved';
    if (info.status === 'Wyslany') return 'sent';
    return 'open';
}

function renderGrid() {
    yearLbl.textContent = viewYear;
    grid.innerHTML = '';
    months.forEach((m, i) => {
        const state = getCellState(viewYear, i);
        const cell = document.createElement('div');
        cell.className = 'month-picker-cell' +
            (i === selected.month && viewYear === selected.year ? ' selected' : '') +
            (state === 'none' ? ' disabled' : '') +
            (state === 'sent' ? ' has-plan' : '') +
            (state === 'approved' ? ' approved' : '');
        cell.textContent = m;
        cell.addEventListener('click', e => {
            e.stopPropagation();
            selectMonth(viewYear, i);
        });
        grid.appendChild(cell);
    });
}

function selectMonth(year, month) {
    selected = { year, month };
    label.textContent = `${monthsFull[month]} ${year}`;
    picker.classList.remove('open');
    renderGrid();
    loadReportForMonth(monthKey(year, month), getCellState(year, month));
}

picker.addEventListener('click', () => picker.classList.toggle('open'));

document.getElementById('yearPrev').addEventListener('click', e => {
    e.stopPropagation(); viewYear--; renderGrid();
});
document.getElementById('yearNext').addEventListener('click', e => {
    e.stopPropagation(); viewYear++; renderGrid();
});

document.addEventListener('click', e => {
    if (!picker.contains(e.target)) picker.classList.remove('open');
});

document.getElementById('monthPrev').addEventListener('click', () => {
    selected.month--;
    if (selected.month < 0) { selected.month = 11; selected.year--; }
    viewYear = selected.year;
    label.textContent = `${monthsFull[selected.month]} ${selected.year}`;
    renderGrid();
    loadReportForMonth(monthKey(selected.year, selected.month), getCellState(selected.year, selected.month));
});

document.getElementById('monthNext').addEventListener('click', () => {
    selected.month++;
    if (selected.month > 11) { selected.month = 0; selected.year++; }
    viewYear = selected.year;
    label.textContent = `${monthsFull[selected.month]} ${selected.year}`;
    renderGrid();
    loadReportForMonth(monthKey(selected.year, selected.month), getCellState(selected.year, selected.month));
});

(async function init() {
    try {
        const response = await fetch('/Projekt/PHP/Server/getAvailableMonths.php');
        const result = await response.json();

        if (result.success) {
            availableMonths = result.months;
        }
    } catch (error) {
        console.error("Błąd wczytywania dostępnych miesięcy:", error);
    }

    label.textContent = `${monthsFull[selected.month]} ${selected.year}`;
    renderGrid();
    loadReportForMonth(monthKey(selected.year, selected.month), getCellState(selected.year, selected.month));
})();
