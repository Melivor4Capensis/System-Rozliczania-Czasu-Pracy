const monthsFull = ["styczeń", "luty", "marzec", "kwiecień", "maj", "czerwiec",
    "lipiec", "sierpień", "wrzesień", "październik", "listopad", "grudzień"];
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

function formatMonthLabel(reportMonth) {
    const [year, month] = reportMonth.split('-');
    return `${monthsFull[parseInt(month, 10) - 1]} ${year}`;
}

function formatDateTime(value) {
    if (!value) return '-';
    const date = new Date(value.replace(' ', 'T'));
    const pad = n => String(n).padStart(2, '0');
    return `${pad(date.getDate())}.${pad(date.getMonth() + 1)}.${date.getFullYear()} ${pad(date.getHours())}:${pad(date.getMinutes())}`;
}

export async function renderReportPreview(reportId) {
    const overlay = document.getElementById('reportPreviewOverlay');
    const sheet = document.getElementById('reportPreviewSheet');

    sheet.innerHTML = '<p style="padding: 40px; text-align:center; color:#6b7280;">Wczytywanie raportu...</p>';
    overlay.classList.add('visible');

    try {
        const response = await fetch(`/Projekt/PHP/Server/getReportDetails.php?id=${encodeURIComponent(reportId)}`);
        const result = await response.json();

        if (!result.success) {
            sheet.innerHTML = `<p style="padding: 40px; text-align:center; color:#c0392b;">${result.error || 'Nie udało się wczytać raportu'}</p>`;
            return;
        }

        sheet.innerHTML = buildReportHtml(result.report, result.days);
        bindCloseButtons();

    } catch (error) {
        console.error("Błąd wczytywania podglądu raportu:", error);
        sheet.innerHTML = '<p style="padding: 40px; text-align:center; color:#c0392b;">Błąd połączenia z serwerem</p>';
    }
}

function buildReportHtml(report, days) {
    const isApproved = report.status === 'Zatwierdzony';
    const totalHours = days.reduce((sum, day) => sum + parseFloat(day.hours), 0);
    const totalWeighted = days.reduce((sum, day) => sum + parseFloat(day.hours) * parseFloat(day.factor), 0);
    const workDays = days.filter(day => parseFloat(day.hours) > 0).length;

    const rowsHtml = days.map(day => `
        <tr>
            <td>${formatDisplayDate(day.day_date)}</td>
            <td>${weekdayName(day.day_date)}</td>
            <td>${parseFloat(day.hours).toFixed(2)}</td>
            <td>${parseFloat(day.factor).toFixed(2)}</td>
            <td>${(parseFloat(day.hours) * parseFloat(day.factor)).toFixed(2)}</td>
            <td>${day.comment || ''}</td>
        </tr>
    `).join('');

    return `
        <button class="report-preview-close" id="reportPreviewClose">&times;</button>
        <div class="report-preview-header">
            <div class="report-preview-title">
                <h1>RAPORT CZASU PRACY</h1>
                <p>${formatMonthLabel(report.report_month)}</p>
            </div>
            <div class="report-preview-school">System Rozliczania Czasu Pracy<br>Dokument wygenerowany elektronicznie</div>
        </div>

        <div class="report-preview-grid">
            <div class="report-preview-box">
                <h3>DANE PRACOWNIKA</h3>
                <div class="report-preview-row"><span>Imię i nazwisko:</span><span>${report.name} ${report.surname}</span></div>
                <div class="report-preview-row"><span>Rola:</span><span>${report.role}</span></div>
                <div class="report-preview-row"><span>ID pracownika:</span><span>N-${report.user_id}</span></div>
            </div>
            <div class="report-preview-box">
                <h3>STATUS RAPORTU</h3>
                <div class="report-preview-row"><span>Miesiąc:</span><span>${formatMonthLabel(report.report_month)}</span></div>
                <div class="report-preview-row"><span>Data wysłania:</span><span>${formatDateTime(report.sent_at)}</span></div>
                <div class="report-preview-row"><span>Status:</span><span class="report-preview-status ${isApproved ? 'zatwierdzony' : ''}">${isApproved ? 'Zatwierdzony' : 'Wysłany'}</span></div>
            </div>
        </div>

        <table class="report-preview-table">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Dzień tygodnia</th>
                    <th>Godziny</th>
                    <th>Współczynnik</th>
                    <th>Godziny x współczynnik</th>
                    <th>Komentarz</th>
                </tr>
            </thead>
            <tbody>${rowsHtml}</tbody>
            <tfoot>
                <tr>
                    <td colspan="2">ŁĄCZNIE</td>
                    <td>${totalHours.toFixed(2)}</td>
                    <td></td>
                    <td>${totalWeighted.toFixed(2)}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>

        <div class="report-preview-summary">
            <div class="report-preview-box">
                <h3>PODSUMOWANIE</h3>
                <div class="report-preview-row"><span>Łączna liczba godzin:</span><span>${totalHours.toFixed(2)}</span></div>
                <div class="report-preview-row"><span>Po uwzględnieniu współczynnika:</span><span>${totalWeighted.toFixed(2)}</span></div>
                <div class="report-preview-row"><span>Liczba dni roboczych:</span><span>${workDays}</span></div>
            </div>
            <div class="report-preview-box">
                <h3>ZATWIERDZENIE</h3>
                <div class="report-preview-row"><span>Raport został:</span><span>${isApproved ? 'Zatwierdzony' : 'Wysłany do zatwierdzenia'}</span></div>
                <div class="report-preview-row"><span>Data zatwierdzenia:</span><span>${formatDateTime(report.approved_at)}</span></div>
            </div>
        </div>

        <p class="report-preview-footer">Dokument wygenerowany elektronicznie.</p>
    `;
}

function bindCloseButtons() {
    const overlay = document.getElementById('reportPreviewOverlay');
    document.getElementById('reportPreviewClose').addEventListener('click', () => {
        overlay.classList.remove('visible');
    });
}

const previewOverlay = document.getElementById('reportPreviewOverlay');

if (previewOverlay) {
    previewOverlay.addEventListener('click', (e) => {
        if (e.target.id === 'reportPreviewOverlay') {
            e.target.classList.remove('visible');
        }
    });
}
