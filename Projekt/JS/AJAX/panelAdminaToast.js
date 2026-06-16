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
            alert("Brak danych do zapisania");
            return;
        }

        try {
            const response = await fetch('/Projekt/PHP/Server/saveUsers.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ users })
            });

            if (!response.ok) {
                throw new Error(`Błąd serwera: ${response.status}`);
            }

            const result = await response.json();

            if (!result.success) {
                window.dispatchEvent(new CustomEvent('reloadTable'));
                throw new Error(result.error || "Inny błąd serwera");
            }

        } catch (error) {
            console.error("Błąd zapisu:", error);
        }

    },
    function onDiscard(table) {
        location.reload(true)
    }
);
