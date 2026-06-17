import { initTableChangeDetector } from '../tableChangeDetector.js';

initTableChangeDetector(
    document.getElementById('reportMenagementTable'),
    async function onSave(changedRows) {

        const reports = changedRows.map(row => {
            const select = row.querySelector('select[name*="[status]"]');
            const nameAttr = select?.getAttribute('name');
            const idMatch = nameAttr?.match(/\[(\d+)\]/)?.[1];

            return {
                id: idMatch ?? null,
                status: select?.value,
            };
        });

        if (reports.length === 0) {
            return { success: false, error: "Brak danych do zapisania" };
        }

        try {
            const response = await fetch('/Projekt/PHP/Server/saveReportsStatus.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ reports })
            });

            const result = await response.json();

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
