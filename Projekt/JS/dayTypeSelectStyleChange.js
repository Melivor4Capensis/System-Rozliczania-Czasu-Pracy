document.querySelectorAll('.day-type-select').forEach(sel => {
    sel.classList.toggle('roboczy', sel.value === 'Roboczy');

    sel.addEventListener('change', function () {
        this.classList.toggle('roboczy', this.value === 'Roboczy');
    });
});