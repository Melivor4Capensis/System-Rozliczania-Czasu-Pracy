document.querySelectorAll('.report-status-select').forEach(sel => {
    sel.classList.toggle('zatwierdzony', sel.value === 'Zatwierdzony');

    sel.addEventListener('change', function () {
        this.classList.toggle('zatwierdzony', this.value === 'Zatwierdzony');
    });
});