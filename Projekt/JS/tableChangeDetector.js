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

    document.getElementById('toastSave').addEventListener('click', function () {
        if (onSave) onSave([...dirtyRows]); 
        hideToast();
    });

    document.getElementById('toastDiscard').addEventListener('click', function () {
        hideToast();
        if (onDiscard) onDiscard(tableEl);
    });
}