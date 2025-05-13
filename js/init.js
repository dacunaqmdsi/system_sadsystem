// Initialize all Select2 dropdowns and subcategory functionality
document.addEventListener('DOMContentLoaded', function() {
    // Initialize category dropdowns
    $('#inventoryCategory, #salesCategory').select2({
        width: '100%',
        placeholder: 'Select Category',
        allowClear: true
    });

    // Initialize subcategory dropdowns
    $('#inventorySubcategory, #salesSubcategory').select2({
        width: '100%',
        placeholder: 'Select Subcategory',
        allowClear: true
    });

    // Initialize other dropdowns
    $('#inventorySize, #salesSize, #inventoryUnit, #salesUnit').select2({
        width: '100%',
        placeholder: 'Select an option',
        allowClear: true
    });

    // Handle category changes for inventory
    $('#inventoryCategory').on('change', function() {
        const category = $(this).val();
        const subcategorySelect = $('#inventorySubcategory');
        
        // Clear existing options
        subcategorySelect.empty();
        subcategorySelect.append(new Option('Select Subcategory', '', true, true));
        
        // Add new options based on selected category
        if (category && window.subcategoriesMap[category]) {
            window.subcategoriesMap[category].forEach(subcategory => {
                subcategorySelect.append(new Option(subcategory, subcategory));
            });
        }
        
        // Update Select2
        subcategorySelect.trigger('change.select2');
    });

    // Handle category changes for sales
    $('#salesCategory').on('change', function() {
        const category = $(this).val();
        const subcategorySelect = $('#salesSubcategory');
        
        // Clear existing options
        subcategorySelect.empty();
        subcategorySelect.append(new Option('Select Subcategory', '', true, true));
        
        // Add new options based on selected category
        if (category && window.subcategoriesMap[category]) {
            window.subcategoriesMap[category].forEach(subcategory => {
                subcategorySelect.append(new Option(subcategory, subcategory));
            });
        }
        
        // Update Select2
        subcategorySelect.trigger('change.select2');
    });

    // Initialize subcategories for any pre-selected categories
    $('#inventoryCategory, #salesCategory').trigger('change');
}); 