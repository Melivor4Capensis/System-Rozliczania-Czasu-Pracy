const picker = document.getElementById('monthPicker');
const label = document.getElementById('monthLabel');
const yearLbl = document.getElementById('yearLabel');
const grid = document.getElementById('monthGrid');

const months = ["Sty", "Lut", "Mar", "Kwi", "Maj", "Cze",
    "Lip", "Sie", "Wrz", "Paź", "Lis", "Gru"];
const monthsFull = ["Styczeń", "Luty", "Marzec", "Kwiecień", "Maj", "Czerwiec",
    "Lipiec", "Sierpień", "Wrzesień", "Październik", "Listopad", "Grudzień"];

const initialYear = parseInt(picker.dataset.year, 10);
const initialMonth = parseInt(picker.dataset.month, 10) - 1;

let selected = { year: initialYear, month: initialMonth };
let viewYear = initialYear;
label.textContent = `${monthsFull[selected.month]} ${viewYear}`;

function renderGrid() {
    yearLbl.textContent = viewYear;
    grid.innerHTML = '';
    months.forEach((m, i) => {
        const cell = document.createElement('div');
        cell.className = 'month-picker-cell' +
            (i === selected.month && viewYear === selected.year ? ' selected' : '');
        cell.textContent = m;
        cell.addEventListener('click', e => {
            e.stopPropagation();
            window.location.href = `kalendarzPracy.php?year=${viewYear}&month=${i + 1}`;
        });
        grid.appendChild(cell);
    });
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
    let month = selected.month - 1;
    let year = selected.year;
    if (month < 0) { month = 11; year--; }
    window.location.href = `kalendarzPracy.php?year=${year}&month=${month + 1}`;
});

document.getElementById('monthNext').addEventListener('click', () => {
    let month = selected.month + 1;
    let year = selected.year;
    if (month > 11) { month = 0; year++; }
    window.location.href = `kalendarzPracy.php?year=${year}&month=${month + 1}`;
});

renderGrid();
