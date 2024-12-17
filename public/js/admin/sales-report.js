function loadContent(type) {
    const url = new URL(window.location);
    url.searchParams.set('type', type);
    window.history.pushState({}, '', url);

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

    const url = new URL(window.location);
    url.searchParams.set('type', 'custom');
    url.searchParams.set('start_date', startDate);
    url.searchParams.set('end_date', endDate);
    window.history.pushState({}, '', url);

    fetch(`/admin/sales-report/custom?start_date=${startDate}&end_date=${endDate}`)
        .then((response) => response.text())
        .then((html) => {
            document.getElementById('sales-report-content').innerHTML = html;
        })
        .catch((error) => console.error('Error loading custom content:', error));
}

document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const type = urlParams.get('type');
    const startDate = urlParams.get('start_date');
    const endDate = urlParams.get('end_date');

    if (type) {
        if (type === 'custom' && startDate && endDate) {
            fetch(`/admin/sales-report/custom?start_date=${startDate}&end_date=${endDate}`)
                .then((response) => response.text())
                .then((html) => {
                    document.getElementById('sales-report-content').innerHTML = html;
                })
                .catch((error) => console.error('Error loading custom content:', error));
        } else {
            fetch(`/admin/sales-report/${type}`)
                .then((response) => response.text())
                .then((html) => {
                    document.getElementById('sales-report-content').innerHTML = html;
                })
                .catch((error) => console.error('Error loading content:', error));
        }
    }
});