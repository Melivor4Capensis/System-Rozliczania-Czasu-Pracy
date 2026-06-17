const dayNamesFull = ["Poniedziałek", "Wtorek", "Środa", "Czwartek", "Piątek", "Sobota", "Niedziela"];

function formatDisplayDate(dateValue) {
    const [year, month, day] = dateValue.split('-');
    return `${day}.${month}.${year}`;
}

function weekdayName(dateValue) {
    const date = new Date(dateValue + 'T00:00:00');
    const isoIndex = (date.getDay() + 6) % 7;
    return dayNamesFull[isoIndex];
}

export async function loadReportForMonth(month, cellState) {
    const tbody = document.getElementById('reportTbody');
    const table = document.getElementById('reportTable');
    const emptyState = document.getElementById('reportEmptyState');
    const sendWrapper = document.getElementById('sendReportWrapper');
    const sendButton = document.getElementById('sendReportButton');
    const lockedNotice = document.getElementById('reportLockedNotice');

    tbody.innerHTML = '';
    table.dataset.month = month;
    table.style.display = 'none';
    emptyState.style.display = 'none';
    sendWrapper.style.display = 'none';
    lockedNotice.style.display = 'none';

    if (cellState === 'none') {
        emptyState.textContent = 'Kadrowa nie przygotowała jeszcze planu pracy dla tego miesiąca.';
        emptyState.style.display = 'block';
        return;
    }

    try {
        const response = await fetch(`/Projekt/PHP/Server/getReport.php?month=${encodeURIComponent(month)}`);
        const result = await response.json();

        if (!result.success || !result.planExists) {
            emptyState.textContent = 'Kadrowa nie przygotowała jeszcze planu pracy dla tego miesiąca.';
            emptyState.style.display = 'block';
            return;
        }

        const isApproved = result.report && result.report.status === 'Zatwierdzony';

        Object.keys(result.calendarDays).sort().forEach(dateValue => {
            const calendarDay = result.calendarDays[dateValue];
            const reportDay = result.reportDays[dateValue] || null;
            const isWorkday = calendarDay.day_type === 'Roboczy';

            const tr = document.createElement('tr');
            tr.dataset.date = dateValue;

            if (!isWorkday) {
                tr.innerHTML = `
                    <td>${formatDisplayDate(dateValue)}<input type="hidden" name="day[${dateValue}][date]" value="${dateValue}"></td>
                    <td>${weekdayName(dateValue)}</td>
                    <td><input type="number" min="0" value="0" disabled></td>
                    <td><input type="number" min="0" value="0" disabled></td>
                    <td>${calendarDay.description || 'Dzień wolny'}</td>
                `;
            } else {
                const hours = reportDay ? reportDay.hours : '1';
                const factor = reportDay ? reportDay.factor : '1';
                const comment = reportDay ? (reportDay.comment || '') : '';

                tr.innerHTML = `
                    <td>${formatDisplayDate(dateValue)}<input type="hidden" name="day[${dateValue}][date]" value="${dateValue}"></td>
                    <td>${weekdayName(dateValue)}</td>
                    <td><input type="number" min="0" step="0.5" value="${hours}" name="day[${dateValue}][hours]" ${isApproved ? 'disabled' : ''}></td>
                    <td><input type="number" min="0" step="0.1" value="${factor}" name="day[${dateValue}][factor]" ${isApproved ? 'disabled' : ''}></td>
                    <td><input type="text" value="${comment}" name="day[${dateValue}][comment]" ${isApproved ? 'disabled' : ''}></td>
                `;
            }

            tbody.appendChild(tr);
        });

        table.style.display = '';

        if (isApproved) {
            lockedNotice.style.display = 'block';
        } else {
            sendWrapper.style.display = 'block';
            sendButton.disabled = false;
        }

    } catch (error) {
        console.error("Błąd wczytywania raportu:", error);
        emptyState.textContent = 'Wystąpił błąd podczas wczytywania raportu.';
        emptyState.style.display = 'block';
    }
}
