document.addEventListener('DOMContentLoaded', function () {
    // Restore collapsible states before adding any listeners
    var collapsibles = document.querySelectorAll('.collapsible');
    collapsibles.forEach(function(collapsible, index) {
        var content = collapsible.nextElementSibling;
        var state = localStorage.getItem('collapsible-' + index);
        if (state === 'open') {
            content.style.display = 'block';
            collapsible.classList.add('active');
        }
    });

    // Handle form-check-container click events
    document.querySelectorAll('.form-check-container').forEach(function(container) {
        container.addEventListener('click', function() {
            const checkbox = container.querySelector('.form-check-input');
            checkbox.checked = !checkbox.checked;
            container.classList.toggle('active', checkbox.checked);
            checkbox.dispatchEvent(new Event('change')); // Trigger change event to update filters
        });
    });

    // Apply active class to form-check-container elements based on checked checkboxes
    document.querySelectorAll('.form-check-input:checked').forEach(function(checkbox) {
        const container = checkbox.closest('.form-check-container');
        if (container) {
            container.classList.add('active');
        }
    });

    // AJAX Filter checkboxes
    document.querySelectorAll('.form-check-input').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            document.getElementById('filter-form').submit();
        });
    });


    // Clear Filters
    document.getElementById('clear-filters').addEventListener('click', function () {
        const form = document.getElementById('filter-form');
        const url = new URL(form.action, window.location.origin);

        // Maintain query and sort parameters
        const query = form.querySelector('input[name="query"]')?.value || '';
        const sort = form.querySelector('input[name="sort"]')?.value || '';
        if (query) url.searchParams.set('query', query);
        if (sort) url.searchParams.set('sort', sort);

        window.location.href = url.toString();
    });

    // Collapsible toggle functionality
    collapsibles.forEach(function(collapsible, index) {
        var content = collapsible.nextElementSibling;
        collapsible.addEventListener('click', function() {
            this.classList.toggle('active');
            if (content.style.display === "block") {
                content.style.display = "none";
                localStorage.setItem('collapsible-' + index, 'closed');
            } else {
                content.style.display = "block";
                localStorage.setItem('collapsible-' + index, 'open');
            }
        });
    });

    // "See More" and "Show Less" buttons
    function handleSeeMore(section) {
        const seeMoreBtn = document.getElementById(`see-more-btn-${section}`);
        if (seeMoreBtn) {
            seeMoreBtn.addEventListener('click', function () {
                const hiddenItems = document.querySelectorAll(`.${section} .hidden-category`);
                hiddenItems.forEach(function (item) {
                    item.style.display = 'block';
                });
                seeMoreBtn.style.display = 'none'; // Hide the "See More" button after clicking

                // Create and insert the "Show Less" button
                const showLessBtn = document.createElement('button');
                showLessBtn.type = 'button';
                showLessBtn.id = `show-less-btn-${section}`;
                showLessBtn.className = 'btn btn-link';
                showLessBtn.textContent = 'Show Less';
                seeMoreBtn.parentNode.appendChild(showLessBtn);

                // Add event listener to the "Show Less" button
                showLessBtn.addEventListener('click', function () {
                    hiddenItems.forEach(function (item) {
                        item.style.display = 'none';
                    });
                    seeMoreBtn.style.display = 'block'; // Show the "See More" button again
                    showLessBtn.remove(); // Remove the "Show Less" button
                });
            });
        }
    }

    handleSeeMore('category');
    handleSeeMore('platform');
    handleSeeMore('language');

    // Event listeners for price range inputs
    document.querySelectorAll('input[name="min_price"], input[name="max_price"]').forEach(function (input) {
        input.addEventListener('change', function () {
            // Ensure the value is within the allowed range
            let value = parseFloat(input.value);
            if (value < 0) {
                input.value = 0;
            } else if (value > 9999.99) {
                input.value = 9999.99;
            }
        });

        // Restrict input to digits only, allowing up to two decimal places
        input.addEventListener('input', function () {
            let value = input.value;
            const regex = /^\d{0,4}(\.\d{0,2})?$/;
            if (!regex.test(value)) {
                input.value = value.slice(0, -1); // Remove the last character if it doesn't match the regex
            }
        });
    });
    
    // Apply price filter on confirm button click
    document.getElementById('apply-price-filter').addEventListener('click', function () {
        document.getElementById('filter-form').submit();
    });

    function updateActiveFilters() {
        const activeFiltersContainer = document.querySelector('.active-filters');
        activeFiltersContainer.innerHTML = ''; // Clear previous filters
    
        const filterNames = [];
        
        // Collect Price Range
        const minPrice = document.querySelector('input[name="min_price"]').value;
        const maxPrice = document.querySelector('input[name="max_price"]').value;
        if (minPrice) {
            filterNames.push({ type: 'Price', value: `Min Price: ${minPrice} €`, id: 'min_price' });
        }
        if (maxPrice) {
            filterNames.push({ type: 'Price', value: `Max Price: ${maxPrice} €`, id: 'max_price' });
        }

        // Collect selected Categories
        document.querySelectorAll('input[name="categories[]"]:checked').forEach(input => {
            const label = document.querySelector(`label[for="${input.id}"]`).textContent.trim();
            filterNames.push({ type: 'Category', value: label, id: input.id });
        });
    
        // Collect selected Platforms
        document.querySelectorAll('input[name="platforms[]"]:checked').forEach(input => {
            const label = document.querySelector(`label[for="${input.id}"]`).textContent.trim();
            filterNames.push({ type: 'Platform', value: label, id: input.id });
        });
    
        // Collect selected Languages
        document.querySelectorAll('input[name="languages[]"]:checked').forEach(input => {
            const label = document.querySelector(`label[for="${input.id}"]`).textContent.trim();
            filterNames.push({ type: 'Language', value: label, id: input.id });
        });
    
        // Collect selected Players
        document.querySelectorAll('input[name="players[]"]:checked').forEach(input => {
            const label = document.querySelector(`label[for="${input.id}"]`).textContent.trim();
            filterNames.push({ type: 'Player', value: label, id: input.id });
        });
    
        // Append collected filters to the Active Filters section
        if (filterNames.length === 0) {
            activeFiltersContainer.innerHTML = '<span>No active filters</span>';
        } else {
            filterNames.forEach(filter => {
                const filterElement = document.createElement('div');
                filterElement.className = 'game-tags';
                filterElement.textContent = filter.value; // Display the filter value
            
                // Create the Font Awesome cross icon
                const removeIcon = document.createElement('i');
                removeIcon.className = 'fas fa-times remove-icon';
                removeIcon.style.marginLeft = '8px'; // Add space between the text and the icon
            
                // Add an event listener to remove the filter and uncheck the corresponding checkbox
                filterElement.addEventListener('click', function () {
                    if (filter.id === 'min_price' || filter.id === 'max_price') {
                        document.querySelector(`input[name="${filter.id}"]`).value = '';
                    } else {
                        const checkbox = document.getElementById(filter.id);
                        if (checkbox) {
                            checkbox.checked = false;
                            // Remove the active class from the container
                            const container = checkbox.closest('.form-check-container');
                            if (container) {
                                container.classList.remove('active');
                            }
                            // Trigger the filter change so the results update
                            const changeEvent = new Event('change');
                            checkbox.dispatchEvent(changeEvent);
                        }
                    }
                    updateActiveFilters(); // Update the active filters display
                    document.getElementById('filter-form').submit(); // Submit the form to update the results
                });
            
                // Append the Font Awesome icon to the filter tag
                filterElement.appendChild(removeIcon);
            
                // Append the filter element to the active filters container
                activeFiltersContainer.appendChild(filterElement);
            });
            
        }
    }

    updateActiveFilters();
});