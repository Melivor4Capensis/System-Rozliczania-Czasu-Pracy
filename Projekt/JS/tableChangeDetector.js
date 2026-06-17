export function initTableChangeDetector(tableEl, onSave, onDiscard) {
    const toast = document.getElementById('saveToast');
    const dirtyRows = new Set();

    function showToast(e) {
        const row = e.target.closest('tr');

        if (row) dirtyRows.add(row);

        if (dirtyRows.size > 0) {
            toast.classList.add('visible');
        }
    }

    function hideToast() {
        dirtyRows.clear();
        toast.classList.remove('visible');
    }

    tableEl.addEventListener('input', showToast);
    tableEl.addEventListener('change', showToast);

    window.addEventListener('beforeunload', (e) => {
        if (dirtyRows.size === 0) return;

        e.preventDefault();
        e.returnValue = '';
    });

    document.getElementById('toastSave').addEventListener('click', async function () {
        const rows = [...dirtyRows];
        const result = await (onSave ? onSave(rows) : null);
        hideToast();
        showSaveResultPopup(result, tableEl);
    });

    document.getElementById('toastDiscard').addEventListener('click', function () {
        hideToast();
        clearFieldErrors(tableEl);
        if (onDiscard) onDiscard(tableEl);
    });
}

function clearFieldErrors(tableEl) {
    tableEl.querySelectorAll('.field-error').forEach(el => el.classList.remove('field-error'));
}

function showSaveResultPopup(result, tableEl) {
    if (!result) return;

    clearFieldErrors(tableEl);

    const popup = document.createElement('div');
    popup.className = 'save-result-popup';

    if (result.success) {
        popup.classList.add('success');
        popup.innerHTML = `
            <p class="save-result-title">Zapisano</p>
            <p class="save-result-sub">Zapisano ${result.saved ?? ''} wierszy</p>
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
            : `<li>${result.error || 'Nie udało się zapisać danych'}</li>`;

        popup.innerHTML = `
            <p class="save-result-title">Wystąpiły błędy</p>
            <ul class="save-result-errors">${errorList}</ul>
            ${result.saved ? `<p class="save-result-sub">Zapisano poprawnie ${result.saved} wierszy</p>` : ''}
        `;
    }

    document.body.appendChild(popup);
    requestAnimationFrame(() => popup.classList.add('visible'));

    setTimeout(() => {
        popup.classList.remove('visible');
        setTimeout(() => popup.remove(), 250);
    }, 4000);
}