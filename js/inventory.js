// Initialize inventory data array
window.inventoryData = [];
let editingIndex = -1;

// Function to populate datalist options
function populateDatalist(datalistId, options) {
    const datalist = document.getElementById(datalistId);
    datalist.innerHTML = '';
    options.forEach(option => {
        const optionElement = document.createElement('option');
        optionElement.value = option;
        datalist.appendChild(optionElement);
    });
}

// Function to update subcategories based on selected category
if (typeof window.updateInventorySubcategories === 'undefined') {
    window.updateInventorySubcategories = function() {
        const categorySelect = $('#inventoryCategory');
        const subcategorySelect = $('#inventorySubcategory');
        const selectedCategory = categorySelect.val();
        
        // Clear existing options
        subcategorySelect.empty();
        
        // Add default option
        subcategorySelect.append(new Option('Select Subcategory', '', true, true));
        
        // If a category is selected and it exists in our map
        if (selectedCategory && window.subcategoriesMap[selectedCategory]) {
            // Add new options
            window.subcategoriesMap[selectedCategory].forEach(subcategory => {
                subcategorySelect.append(new Option(subcategory, subcategory));
            });
        }
        
        // Reinitialize Select2
        subcategorySelect.trigger('change.select2');
    };
}

// Function to update sales subcategories
function updateSalesSubcategories() {
    const categorySelect = $('#salesCategory');
    const subcategorySelect = $('#salesSubcategory');
    const selectedCategory = categorySelect.val();
    
    // Clear existing options
    subcategorySelect.empty().append('<option value="">Select Subcategory</option>');
    
    // If a category is selected and it exists in our map
    if (selectedCategory && window.subcategoriesMap[selectedCategory]) {
        // Add new options
        window.subcategoriesMap[selectedCategory].forEach(subcategory => {
            subcategorySelect.append(new Option(subcategory, subcategory));
        });
    }
    
    // Reinitialize Select2
    subcategorySelect.trigger('change');
}

// Function to initialize Select2 dropdowns
function initializeSelect2Dropdowns() {
    // Initialize category dropdown first
    $('#inventoryCategory').select2({
        width: '100%',
        placeholder: 'Select Category',
        allowClear: true
    }).on('change', function() {
        window.updateInventorySubcategories();
    });

    // Initialize subcategory dropdown
    $('#inventorySubcategory').select2({
        width: '100%',
        placeholder: 'Select Subcategory',
        allowClear: true
    });

    // Initialize other dropdowns
    const otherDropdowns = [
        '#inventoryMadeFrom',
        '#inventoryCooperative',
        '#inventoryStorageLocation',
        '#inventoryUnit',
        '#inventorySize'
    ];

    $(otherDropdowns.join(',')).select2({
        width: '100%',
        placeholder: 'Select an option',
        allowClear: true
    });
}

// Function to format Select2 options
function formatOption(option) {
    if (!option.id) return option.text; // For placeholder
    return $('<span class="select2-option">' + option.text + '</span>');
}

// Add event listeners when document is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Select2
    initializeSelect2Dropdowns();

    // Handle Select2 focus events
    $('select').on('select2:open', function() {
        document.querySelector('.select2-search__field').focus();
    });

    // Add event listeners for category changes
    $('#inventoryCategory').on('change', updateInventorySubcategories);
    $('#salesCategory').on('change', updateSalesSubcategories);
    
    // Initialize subcategories for any pre-selected categories
    window.updateInventorySubcategories();
    updateSalesSubcategories();

    // Set today's date as default for dateAdded
    const dateAdded = document.getElementById('inventoryDateAdded');
    if (dateAdded) {
        dateAdded.valueAsDate = new Date();
    }

    // Load saved inventory data
    const savedData = localStorage.getItem('inventoryData');
    if (savedData) {
        window.inventoryData = JSON.parse(savedData);
        displayInventoryList();
    }

    // Add event listener for search input
    const searchInput = document.getElementById('inventorySearch');
    if (searchInput) {
        searchInput.addEventListener('input', filterInventory);
    }
});

function addOrUpdateInventory(event) {
    if (event) event.preventDefault();

    const inventory = {
        productId: document.getElementById("inventoryProductId").value.trim(),
        category: document.getElementById("inventoryCategory").value,
        subcategory: document.getElementById("inventorySubcategory").value,
        size: document.getElementById("inventorySize").value,
        cooperative: document.getElementById("inventoryCooperative").value,
        madeFrom: document.getElementById("inventoryMadeFrom").value,
        quantityAvailable: parseInt(document.getElementById("inventoryQuantityAvailable").value),
        reorderThreshold: parseInt(document.getElementById("inventoryReorderThreshold").value),
        storageLocation: document.getElementById("inventoryStorageLocation").value,
        costPrice: parseFloat(document.getElementById("inventoryCostPrice").value),
        retailPrice: parseFloat(document.getElementById("inventoryRetailPrice").value),
        unit: document.getElementById("inventoryUnit").value,
        dateAdded: document.getElementById("inventoryDateAdded").value
    };

    // Validate required fields
    if (!validateInventoryFields(inventory)) {
        return;
    }

    if (editingIndex === -1) {
        // Add new item
        window.inventoryData.push(inventory);
        addNotification(`New item added: ${inventory.productId}`);
    } else {
        // Update existing item
        window.inventoryData[editingIndex] = inventory;
        addNotification(`Item updated: ${inventory.productId}`);
        editingIndex = -1; // Reset editing index
        document.querySelector('.accent-btn').innerHTML = '<i class="fas fa-plus"></i> Add Item';
    }
    
    // Save to localStorage
    saveInventoryData();
    
    // Update display
    displayInventoryList();
    
    // Clear form
    clearInventoryForm();
    
    // Check stock levels
    checkStockLevels();

    // Show success message
    alert('Product successfully ' + (editingIndex === -1 ? 'added' : 'updated') + ' to inventory!');

    // Scroll to inventory list
    document.getElementById('inventoryList').scrollIntoView({ behavior: 'smooth' });
}

function validateInventoryFields(inventory) {
    if (!inventory.productId || !inventory.category || 
        !inventory.subcategory || !inventory.size || !inventory.cooperative || 
        !inventory.quantityAvailable || !inventory.reorderThreshold || 
        !inventory.costPrice || !inventory.retailPrice || !inventory.unit || 
        !inventory.dateAdded) {
        alert("Please fill in all required fields.");
        return false;
    }

    // Validate Product ID format (e.g., PROD-001)
    if (!/^[A-Z]{2,3}-[A-Z]{2,3}-(S|M|L|XL|XXL)-\d{3}$/.test(inventory.productId)) {
        alert("Product ID must be in format CAT-SUB-SIZE-XXX (e.g., CL-SH-M-001)");
        return false;
    }
    
    // Validate prices
    if (inventory.costPrice <= 0 || inventory.retailPrice <= 0) {
        alert("Prices must be greater than 0");
        return false;
    }

    if (inventory.retailPrice <= inventory.costPrice) {
        alert("Retail price must be greater than cost price");
        return false;
    }

    return true;
}

function clearInventoryForm() {
    $('#inventoryProductId').val('');
    $('#inventoryCategory').val('').trigger('change');
    $('#inventorySubcategory').val('').trigger('change');
    $('#inventorySize').val('').trigger('change');
    $('#inventoryCooperative').val('').trigger('change');
    $('#inventoryMadeFrom').val('').trigger('change');
    $('#inventoryQuantityAvailable').val('');
    $('#inventoryReorderThreshold').val('');
    $('#inventoryStorageLocation').val('').trigger('change');
    $('#inventoryCostPrice').val('');
    $('#inventoryRetailPrice').val('');
    $('#inventoryUnit').val('').trigger('change');
    $('#inventoryDateAdded').valAsDate = new Date();
}

function editInventoryItem(index) {
    const item = window.inventoryData[index];
    editingIndex = index;

    // Populate form with item data
    $('#inventoryProductId').val(item.productId);
    $('#inventoryCategory').val(item.category).trigger('change');
    updateInventorySubcategories();
    $('#inventorySubcategory').val(item.subcategory).trigger('change');
    $('#inventorySize').val(item.size).trigger('change');
    $('#inventoryCooperative').val(item.cooperative).trigger('change');
    $('#inventoryMadeFrom').val(item.madeFrom).trigger('change');
    $('#inventoryQuantityAvailable').val(item.quantityAvailable);
    $('#inventoryReorderThreshold').val(item.reorderThreshold);
    $('#inventoryStorageLocation').val(item.storageLocation).trigger('change');
    $('#inventoryCostPrice').val(item.costPrice);
    $('#inventoryRetailPrice').val(item.retailPrice);
    $('#inventoryUnit').val(item.unit).trigger('change');
    $('#inventoryDateAdded').val(item.dateAdded);

    // Show save button and hide edit button for this row
    const row = document.querySelector(`#inventoryList tr:nth-child(${index + 2})`);
    if (row) {
        row.querySelector('.edit-btn').style.display = 'none';
        row.querySelector('.save-btn').style.display = 'inline-block';
    }

    // Scroll to form
    $('.inventory-form')[0].scrollIntoView({ behavior: 'smooth' });
}

function saveInventoryItem(index) {
    const inventory = {
        productId: document.getElementById("inventoryProductId").value.trim(),
        category: document.getElementById("inventoryCategory").value,
        subcategory: document.getElementById("inventorySubcategory").value,
        size: document.getElementById("inventorySize").value,
        cooperative: document.getElementById("inventoryCooperative").value,
        madeFrom: document.getElementById("inventoryMadeFrom").value,
        quantityAvailable: parseInt(document.getElementById("inventoryQuantityAvailable").value),
        reorderThreshold: parseInt(document.getElementById("inventoryReorderThreshold").value),
        storageLocation: document.getElementById("inventoryStorageLocation").value,
        costPrice: parseFloat(document.getElementById("inventoryCostPrice").value),
        retailPrice: parseFloat(document.getElementById("inventoryRetailPrice").value),
        unit: document.getElementById("inventoryUnit").value,
        dateAdded: document.getElementById("inventoryDateAdded").value
    };

    // Validate required fields
    if (!validateInventoryFields(inventory)) {
        return;
    }

    // Update existing item
    window.inventoryData[index] = inventory;
    addNotification(`Item updated: ${inventory.productId}`);
    editingIndex = -1; // Reset editing index
    
    // Save to localStorage
    saveInventoryData();
    
    // Update display
    displayInventoryList();
    
    // Clear form
    clearInventoryForm();
    
    // Check stock levels
    checkStockLevels();

    // Show success message
    alert('Product successfully updated!');
}

function deleteInventoryItem(index) {
    if (confirm('Are you sure you want to delete this item?')) {
        const deletedItem = window.inventoryData[index];
        window.inventoryData.splice(index, 1);
        saveInventoryData();
        displayInventoryList();
        addNotification(`Item deleted: ${deletedItem.productId}`);
    }
}

function filterInventory() {
    const searchTerm = document.getElementById("inventorySearch").value.toLowerCase();
    const filteredData = window.inventoryData.filter(item =>
        item.productId.toLowerCase().includes(searchTerm) ||
        item.category.toLowerCase().includes(searchTerm) ||
        item.subcategory.toLowerCase().includes(searchTerm) ||
        item.cooperative.toLowerCase().includes(searchTerm) ||
        item.madeFrom.toLowerCase().includes(searchTerm) ||
        item.storageLocation.toLowerCase().includes(searchTerm)
    );
    displayFilteredInventory(filteredData);
}

function displayFilteredInventory(filteredData) {
    const table = document.createElement("table");
    table.innerHTML = `
        <tr>
            <th>Product ID</th>
            <th>Category</th>
            <th>Subcategory</th>
            <th>Size</th>
            <th>Cooperative</th>
            <th>Made From</th>
            <th>Storage Location</th>
            <th>Quantity</th>
            <th>Reorder Level</th>
            <th>Cost Price</th>
            <th>Retail Price</th>
            <th>Unit</th>
            <th>Action</th>
        </tr>
    `;
    
    filteredData.forEach((item, index) => {
        const tr = document.createElement("tr");
        const lowStock = item.quantityAvailable <= item.reorderThreshold;
        tr.innerHTML = `
            <td>${item.productId}</td>
            <td>${item.category}</td>
            <td>${item.subcategory}</td>
            <td>${item.size}</td>
            <td>${item.cooperative}</td>
            <td>${item.madeFrom}</td>
            <td>${item.storageLocation}</td>
            <td class="${lowStock ? 'low-stock' : ''}">${item.quantityAvailable}</td>
            <td>${item.reorderThreshold}</td>
            <td>₱${item.costPrice.toFixed(2)}</td>
            <td>₱${item.retailPrice.toFixed(2)}</td>
            <td>${item.unit}</td>
            <td>
                <button onclick="editInventoryItem(${index})" class="edit-btn">
                    <i class="fas fa-edit"></i>
                </button>
                <button onclick="saveInventoryItem(${index})" class="save-btn" style="display: none;">
                    <i class="fas fa-check"></i>
                </button>
            </td>
        `;
        table.appendChild(tr);
    });
    
    document.getElementById("inventoryList").innerHTML = "";
    document.getElementById("inventoryList").appendChild(table);
}

function displayInventoryList() {
    displayFilteredInventory(window.inventoryData);
}

function checkStockLevels() {
    window.inventoryData.forEach(item => {
        if (item.quantityAvailable <= item.reorderThreshold) {
            addNotification(`Low Stock Alert: ${item.productId} is below reorder threshold. Current quantity: ${item.quantityAvailable}`);
        }
    });
}

function saveInventoryData() {
    localStorage.setItem('inventoryData', JSON.stringify(window.inventoryData));
}

// Function to view all inventory items
function viewAllInventory() {
    document.getElementById("inventorySearch").value = "";
    displayFilteredInventory(window.inventoryData);
} 