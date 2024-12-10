function loadContent(type) {
    fetch(`/admin/sales-report/${type}`)
        .then((response) => response.text())
        .then((html) => {
            document.getElementById('sales-report-content').innerHTML = html;
        })
        .catch((error) => console.error('Error loading content:', error));
}

function loadCustomContent(event) {
    event.preventDefault();

    const form = document.getElementById('custom-sales-form');
    const formData = new FormData(form);
    const startDate = formData.get('start_date');
    const endDate = formData.get('end_date');

    fetch(`/admin/sales-report/custom?start_date=${startDate}&end_date=${endDate}`)
        .then((response) => response.text())
        .then((html) => {
            document.getElementById('sales-report-content').innerHTML = html;
        })
        .catch((error) => console.error('Error loading custom content:', error));
}
