document.addEventListener('change', function (e) {
    if (!e.target.classList.contains('report-status-select')) return;

    e.target.classList.toggle('zatwierdzony', e.target.value === 'Zatwierdzony');
});