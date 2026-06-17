import { loadReports, resetReports } from './AJAX/raportyPracownikowFetchReports.js';
import './AJAX/reportPreview.js';

await loadReports(20);


const tableContainer = document.getElementById("primaryMain");

tableContainer.addEventListener('scroll', () => {
    const { scrollTop, scrollHeight, clientHeight } = tableContainer;
    const isAtBottom = scrollTop + clientHeight >= scrollHeight - 50;

    if (isAtBottom) {
        loadReports(20);
    }
});

window.addEventListener('reloadReportsTable', async () => {
    resetReports();
    await loadReports(20);
});
