const sendButton = document.getElementById('sendReportButton');
const table = document.getElementById('reportTable');

sendButton.addEventListener('click', async () => {
    const month = table.dataset.month;

    const days = [...table.querySelectorAll('tbody tr')]
        .filter(row => row.querySelector('input[name*="[hours]"]'))
        .map(row => ({
            date: row.querySelector('input[name*="[date]"]')?.value,
            hours: row.querySelector('input[name*="[hours]"]')?.value,
            factor: row.querySelector('input[name*="[factor]"]')?.value,
            comment: row.querySelector('input[name*="[comment]"]')?.value.trim(),
        }));

    sendButton.disabled = true;

    try {
        const response = await fetch('/Projekt/PHP/Server/saveReport.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ month, days })
        });

        const result = await response.json();
        showSendResultPopup(result, table);

        if (result.success) {
            location.reload();
        } else {
            sendButton.disabled = false;
        }
    } catch (error) {
        console.error("Błąd wysyłania raportu:", error);
        showSendResultPopup({ success: false, error: "Błąd połączenia z serwerem" }, table);
        sendButton.disabled = false;
    }
});

function showSendResultPopup(result, tableEl) {
    tableEl.querySelectorAll('.field-error').forEach(el => el.classList.remove('field-error'));

    const popup = document.createElement('div');
    popup.className = 'save-result-popup';

    if (result.success) {
        popup.classList.add('success');
        popup.innerHTML = `
            <p class="save-result-title">Raport wysłany</p>
            <p class="save-result-sub">Zapisano ${result.saved ?? ''} dni do zatwierdzenia przez kadrową</p>
        `;
    } else {
        popup.classList.add('error');

        if (Array.isArray(result.fieldErrors)) {
            result.fieldErrors.forEach(fieldName => {
                const field = tableEl.querySelector(`[name="${fieldName}"]`);
                if (field) {
                    field.classList.add('field-error');
                    field.focus();
                }
            });
        }

        const errorList = Array.isArray(result.errors) && result.errors.length
            ? result.errors.slice(0, 4).map(err => `<li>${err}</li>`).join('')
            : `<li>${result.error || 'Nie udało się wysłać raportu'}</li>`;

        popup.innerHTML = `
            <p class="save-result-title">Wystąpiły błędy</p>
            <ul class="save-result-errors">${errorList}</ul>
        `;
    }

    document.body.appendChild(popup);
    requestAnimationFrame(() => popup.classList.add('visible'));

    setTimeout(() => {
        popup.classList.remove('visible');
        setTimeout(() => popup.remove(), 250);
    }, 4000);
}
