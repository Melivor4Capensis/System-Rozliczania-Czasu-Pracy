const picker = document.getElementById('monthPicker');
const label = document.getElementById('monthLabel');
const yearLbl = document.getElementById('yearLabel');
const grid = document.getElementById('monthGrid');

const months = ["Sty", "Lut", "Mar", "Kwi", "Maj", "Cze",
    "Lip", "Sie", "Wrz", "Paź", "Lis", "Gru"];
const monthsFull = ["Styczeń", "Luty", "Marzec", "Kwiecień", "Maj", "Czerwiec",
    "Lipiec", "Sierpień", "Wrzesień", "Październik", "Listopad", "Grudzień"];

const currDate = new Date()

let selected = { year: currDate.getFullYear(), month: currDate.getMonth() - 1 };
selected.year = currDate.getFullYear();
label.textContent = `${monthsFull[selected.month]} ${selected.year}`;


function getValue() {
    return `${selected.year}-${String(selected.month + 1).padStart(2, '0')}`;
}

function renderGrid() {
    yearLbl.textContent = selected.year;
    grid.innerHTML = '';
    months.forEach((m, i) => {
        const cell = document.createElement('div');
        cell.className = 'month-picker-cell' +
            (i === selected.month && selected.year === selected.year ? ' selected' : '');
        cell.textContent = m;
        cell.addEventListener('click', e => {
            e.stopPropagation();
            selected = { year: selected.year, month: i };
            label.textContent = `${monthsFull[i]} ${selected.year}`;
            picker.classList.remove('open');
            renderGrid();
            // ajax
        });
        grid.appendChild(cell);
    });
}

picker.addEventListener('click', () => picker.classList.toggle('open'));

document.getElementById('yearPrev').addEventListener('click', e => {
    e.stopPropagation(); selected.year--; renderGrid();
});
document.getElementById('yearNext').addEventListener('click', e => {
    e.stopPropagation(); selected.year++; renderGrid();
});

document.addEventListener('click', e => {
    if (!picker.contains(e.target)) picker.classList.remove('open');
});

document.getElementById('monthPrev').addEventListener('click', () => {
    selected.month--;
    if (selected.month < 0) { selected.month = 11; selected.year--; }
    selected.year = selected.year;
    label.textContent = `${monthsFull[selected.month]} ${selected.year}`;
    renderGrid();
});

document.getElementById('monthNext').addEventListener('click', () => {
    selected.month++;
    if (selected.month > 11) { selected.month = 0; selected.year++; }
    selected.year = selected.year;
    label.textContent = `${monthsFull[selected.month]} ${selected.year}`;
    renderGrid();
});

renderGrid();