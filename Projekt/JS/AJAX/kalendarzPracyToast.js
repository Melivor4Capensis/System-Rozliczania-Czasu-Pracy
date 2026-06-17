import { initTableChangeDetector } from '../tableChangeDetector.js';

initTableChangeDetector(
    document.getElementById('calendarTable'),
    async function onSave(changedRows) {

        const days = changedRows.map(row => {
            const dateAttr = row.querySelector('input[name*="[date]"]')?.value;

            return {
                date: dateAttr,
                type: row.querySelector('select[name*="[type]"]')?.value,
                description: row.querySelector('input[name*="[description]"]')?.value.trim(),
            };
        });

        if (days.length === 0) {
            return { success: false, error: "Brak danych do zapisania" };
        }

        try {
            const response = await fetch('/Projekt/PHP/Server/saveCalendarDays.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ days })
            });

            return await response.json();

        } catch (error) {
            console.error("Błąd zapisu:", error);
            return { success: false, error: "Błąd połączenia z serwerem" };
        }

    },
    function onDiscard(table) {
        location.reload(true)
    }
);
