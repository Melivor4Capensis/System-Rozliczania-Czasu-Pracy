import { initTableChangeDetector } from '../tableChangeDetector.js';

initTableChangeDetector(
    document.getElementById('userMenagementTable'),
    async function onSave(changedRows) {

        const users = changedRows.map(row => {
            const nameAttr = row.querySelector('input[name*="[name]"]')?.getAttribute('name');
            const idMatch = nameAttr?.match(/\[(\d+|new)\]/)?.[1];
            const id = idMatch ?? null;

            return {
                id,
                surname: row.querySelector('input[name*="[surname]"]')?.value.trim(),
                name: row.querySelector('input[name*="[name]"]')?.value.trim(),
                login: row.querySelector('input[name*="[login]"]')?.value.trim(),
                role: row.querySelector('select[name*="[role]"]')?.value,
            };
        });

        if (users.length === 0) {
            return { success: false, error: "Brak danych do zapisania" };
        }

        try {
            const response = await fetch('/Projekt/PHP/Server/saveUsers.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ users })
            });

            const result = await response.json();

            if (!result.success) {
                window.dispatchEvent(new CustomEvent('reloadTable'));
            }

            return result;

        } catch (error) {
            console.error("Błąd zapisu:", error);
            return { success: false, error: "Błąd połączenia z serwerem" };
        }

    },
    function onDiscard(table) {
        location.reload(true)
    }
);
