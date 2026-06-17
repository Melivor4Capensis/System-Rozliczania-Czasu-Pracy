import { bindReportRowActions } from '../reportRowActions.js';

let loadedReports = 0;
let isLoading = false;

const monthsFull = ["styczeń", "luty", "marzec", "kwiecień", "maj", "czerwiec",
    "lipiec", "sierpień", "wrzesień", "październik", "listopad", "grudzień"];

function formatMonthLabel(reportMonth) {
    const [year, month] = reportMonth.split('-');
    return `${monthsFull[parseInt(month, 10) - 1]} ${year}`;
}

export async function loadReports(reportsToLoad) {
    if (isLoading) return;
    isLoading = true;

    const tbody = document.getElementById("reportMenagementTbody");

    try {
        const response = await fetch(`/Projekt/PHP/Server/getReportsList.php?toLoad=${encodeURIComponent(reportsToLoad)}&loaded=${encodeURIComponent(loadedReports)}`)

        if (!response.ok) {
            throw new Error(`Błąd serwera: ${response.status}`);
        }

        const reports = await response.json();

        if (reports.length === 0) {
            if (!document.getElementById("lastRow") && loadedReports === 0) {
                tbody.innerHTML += `<tr id="lastRow"><td colspan="5">Brak wysłanych raportów</td></tr>`;
            }
            return;
        }

        loadedReports += reportsToLoad;

        reports.forEach(report => {
            const tr = document.createElement("tr");
            tr.dataset.reportId = report.id;
            tr.innerHTML = `
                <td>${formatMonthLabel(report.report_month)}</td>
                <td>${report.surname}</td>
                <td>${report.name}</td>
                <td>
                    <select class="report-status-select" name="report[${report.id}][status]">
                        <option value="Wyslany" ${report.status === "Wyslany" ? "selected" : ""}>Do zatwierdzenia</option>
                        <option value="Zatwierdzony" ${report.status === "Zatwierdzony" ? "selected" : ""}>Zatwierdzony</option>
                    </select>
                </td>
                <td>
                    <button class="show-report-button">Pokaż</button>
                    <button class="generate-pdf-Button">Wygeneruj PDF</button>
                </td>
            `;
            tbody.appendChild(tr);
            bindReportRowActions(tr, report.id);
        });

        document.querySelectorAll('.report-status-select').forEach(sel => {
            sel.classList.toggle('zatwierdzony', sel.value === 'Zatwierdzony');
        });

        if (reports.length < reportsToLoad) {
            if (!document.getElementById("lastRow")) {
                const tr = document.createElement('tr');
                tr.id = 'lastRow';
                tr.innerHTML = '<td colspan="5">Koniec wyników</td>';

                tbody.appendChild(tr);;
            }
        }
    } catch (error) {
        console.error(error);
        tbody.innerHTML += `<tr><td colspan="5">Wystąpił błąd</td></tr>`;
    } finally {
        isLoading = false;
    }
}

export function resetReports() {
    loadedReports = 0;
    isLoading = false;
    document.getElementById("reportMenagementTbody").innerHTML = '';
}
