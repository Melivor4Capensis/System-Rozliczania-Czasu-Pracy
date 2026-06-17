import { renderReportPreview } from './AJAX/reportPreview.js';

export function bindReportRowActions(row, reportId) {
    const showButton = row.querySelector('.show-report-button');
    const pdfButton = row.querySelector('.generate-pdf-Button');
    

    showButton.addEventListener('click', () => {
        renderReportPreview(reportId);
    });

    pdfButton.addEventListener('click', () => {
        alert("Do zaimplementowania");
    });
}
