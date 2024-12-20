document.querySelectorAll('.payment-method-card').forEach(card => {
    card.addEventListener('click', () => {
        const methodId = card.getAttribute('data-method-id');
        document.getElementById(`payment_method_${methodId}`).checked = true;
    });
});