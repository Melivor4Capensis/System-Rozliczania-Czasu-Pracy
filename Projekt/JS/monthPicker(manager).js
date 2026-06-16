const picker = document.getElementById('monthPicker');
const label = document.getElementById('monthLabel');
const yearLbl = document.getElementById('yearLabel');
const grid = document.getElementById('monthGrid');

const months = ["Sty", "Lut", "Mar", "Kwi", "Maj", "Cze",
    "Lip", "Sie", "Wrz", "Paź", "Lis", "Gru"];
const monthsFull = ["Styczeń", "Luty", "Marzec", "Kwiecień", "Maj", "Czerwiec",
    "Lipiec", "Sierpień", "Wrzesień", "Październik", "Listopad", "Grudzień"];

let existingMonths = [];

const currDate = new Date()

let viewYear = currDate.getFullYear();
let viewMonth = currDate.getMonth();

let selectedKey = `${currDate.getFullYear()}-${String(currDate.getMonth() + 1).padStart(2, '0')}`;
label.textContent = `${monthsFull[viewMonth]} ${viewYear}`;



async function loadExistingMonths() {
    const res = await fetch('../../PHP/Server/getCalendarMonths.php');
    const data = await res.json();
    existingMonths = data.existing;
}

async function goToMonth(year, month) {

    const key = `${year}-${String(month + 1).padStart(2, '0')}`;

    const exists = existingMonths.includes(key);

    if (!exists) {
        const confirmCreate = confirm("Ten miesiąc nie istnieje. Utworzyć kalendarz?");
        if (!confirmCreate) return;

        await fetch('../../PHP/Server/createCalendarMonth.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ year, month: month + 1 })
        });

        await loadExistingMonths();
    }

    selectedKey = key;

    viewYear = year;
    viewMonth = month;

    label.textContent = `${monthsFull[month]} ${year}`;

    picker.classList.remove('open');

    renderGrid();
}

function renderGrid() {

    yearLbl.textContent = viewYear;

    grid.innerHTML = '';

    months.forEach((m, i) => {

        const key = `${viewYear}-${String(i + 1).padStart(2, '0')}`;
        const exists = existingMonths.includes(key);

        const isSelected = selectedKey === key;

        const cell = document.createElement('div');

        cell.className =
            'month-picker-cell' +
            (isSelected ? ' selected' : '') +
            (exists ? ' exists' : ' missing');

        cell.textContent = m;

        cell.addEventListener('click', async (e) => {
            e.stopPropagation();
            await goToMonth(viewYear, i);
        });

        grid.appendChild(cell);
    });
}

function setMonth(year, month) {
    viewYear = year;
    viewMonth = month;

    label.textContent = `${monthsFull[month]} ${year}`;

    renderGrid();
}

picker.addEventListener('click', () => picker.classList.toggle('open'));

document.getElementById('yearPrev').addEventListener('click', (e) => {
    e.stopPropagation();
    setMonth(viewYear - 1, viewMonth);
});

document.getElementById('yearNext').addEventListener('click', (e) => {
    e.stopPropagation();
    setMonth(viewYear + 1, viewMonth);
});

document.addEventListener('click', e => {
    if (!picker.contains(e.target)) picker.classList.remove('open');
});


document.getElementById('monthNext').addEventListener('click', async () => {
    let m = viewMonth + 1;
    let y = viewYear;

    if (m > 11) {
        m = 0;
        y++;
    }

    await goToMonth(y, m);
});
document.getElementById('monthPrev').addEventListener('click', async () => {
    let m = viewMonth - 1;
    let y = viewYear;

    if (m < 0) {
        m = 11;
        y--;
    }

    await goToMonth(y, m);
});


async function init() {
    await loadExistingMonths();

    const currentKey = `${viewYear}-${String(viewMonth + 1).padStart(2, '0')}`;

    if (!existingMonths.includes(currentKey)) {
        selectedKey = null; 
    } else {
        selectedKey = currentKey;
    }

    renderGrid();
}

init();