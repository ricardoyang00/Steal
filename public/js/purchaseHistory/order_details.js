document.addEventListener('DOMContentLoaded', function () {
    console.log('order_details.js loaded: Initializing CDK toggle functionality.');

    // Select all "View CDKs" buttons
    const viewCdkButtons = document.querySelectorAll('.view-cdks-btn');

    viewCdkButtons.forEach(button => {
        // Initialize ARIA attribute
        button.setAttribute('aria-expanded', 'false');

        button.addEventListener('click', function () {
            const cdkSection = this.nextElementSibling; // Assuming .cdk-codes is the next sibling

            if (cdkSection && cdkSection.classList.contains('cdk-codes')) {
                // Toggle the 'show' class to handle display via CSS
                cdkSection.classList.toggle('show');

                // Update ARIA attribute and button text
                if (cdkSection.classList.contains('show')) {
                    this.setAttribute('aria-expanded', 'true');
                    this.innerHTML = 'Hide CDKs'; // Up arrow for expanded state
                } else {
                    this.setAttribute('aria-expanded', 'false');
                    this.innerHTML = 'View CDKs'; // Down arrow for collapsed state
                }
            } else {
                console.warn('CDK Codes section not found for the clicked button.');
            }
        });
    });

    console.log('CDK toggle functionality initialized.');
});
