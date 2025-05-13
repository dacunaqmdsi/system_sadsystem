// Sales Module Functions
let currentOrderItems = [];
let orderTotal = 0;
let inventoryData = [];
let editingItemIndex = -1;
let editingField = '';

// Notification system
function showNotification(message, type = 'info') {
    // Add to system notifications
    const systemNotification = document.createElement('div');
    systemNotification.className = `system-notification ${type}`;
    systemNotification.innerHTML = `
        <div class="notification-icon">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'}"></i>
        </div>
        <div class="notification-content">
            <div class="notification-title">${type.charAt(0).toUpperCase() + type.slice(1)}</div>
            <div class="notification-message">${message}</div>
        </div>
        <div class="notification-time">${new Date().toLocaleTimeString()}</div>
        <div class="notification-date">${new Date().toLocaleDateString()}</div>
        <button class="notification-close" onclick="this.parentElement.remove(); updateNotificationCount();">
            <i class="fas fa-times"></i>
        </button>
    `;

    // Add to notification module
    const notificationOutput = document.getElementById('notificationOutput');
    if (notificationOutput) {
        notificationOutput.insertBefore(systemNotification, notificationOutput.firstChild);
        updateNotificationCount();
    }
}

// Function to update notification count
function updateNotificationCount() {
    const notificationCount = document.getElementById('notificationCount');
    const notificationOutput = document.getElementById('notificationOutput');
    if (notificationCount && notificationOutput) {
        const count = notificationOutput.children.length;
        notificationCount.textContent = count;
        notificationCount.style.display = count > 0 ? 'block' : 'none';
    }
}

// Add CSS for notifications
const style = document.createElement('style');
style.textContent = `
    /* System notifications */
    .system-notification {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-bottom: 10px;
        padding: 15px;
        display: flex;
        align-items: center;
        animation: slideIn 0.3s ease-out;
        position: relative;
    }
    
    .system-notification.success {
        border-left: 4px solid #4CAF50;
    }
    
    .system-notification.error {
        border-left: 4px solid #f44336;
    }
    
    .system-notification.info {
        border-left: 4px solid #2196F3;
    }
    
    .notification-icon {
        margin-right: 15px;
        font-size: 20px;
    }
    
    .notification-icon .fa-check-circle {
        color: #4CAF50;
    }
    
    .notification-icon .fa-exclamation-circle {
        color: #f44336;
    }
    
    .notification-icon .fa-info-circle {
        color: #2196F3;
    }
    
    .notification-content {
        flex: 1;
    }
    
    .notification-title {
        font-weight: bold;
        margin-bottom: 5px;
    }
    
    .notification-message {
        font-size: 14px;
        color: #666;
    }
    
    .notification-time {
        font-size: 12px;
        color: #999;
        margin-left: 10px;
    }
    
    .notification-date {
        font-size: 12px;
        color: #999;
        margin-left: 10px;
    }
    
    .notification-close {
        position: absolute;
        top: 10px;
        right: 10px;
        background: none;
        border: none;
        color: #999;
        cursor: pointer;
        padding: 5px;
    }
    
    .notification-close:hover {
        color: #666;
    }
    
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
`;
document.head.appendChild(style);

// Function to generate order ID
function generateOrderId() {
    const orders = JSON.parse(localStorage.getItem('orders') || '[]');
    const nextOrderNumber = orders.length + 1;
    return `ORD-${nextOrderNumber.toString().padStart(4, '0')}`;
}

// Function to load inventory data
function loadInventoryData() {
    const savedInventory = localStorage.getItem('inventoryData');
    if (savedInventory) {
        inventoryData = JSON.parse(savedInventory);
    }
    return inventoryData;
}

// Function to search inventory items
if (typeof window.searchSalesInventory === 'undefined') {
    window.searchSalesInventory = function() {
    const searchTerm = document.getElementById('salesInventorySearch').value.toLowerCase();
    const inventory = loadInventoryData();
    
    if (!inventory || inventory.length === 0) {
        document.getElementById("inventoryView").innerHTML = "<p>No inventory data.</p>";
        return;
    }

    const filteredItems = inventory.filter(item =>
        item.productId.toLowerCase().includes(searchTerm) ||
        item.category.toLowerCase().includes(searchTerm) ||
        item.subcategory.toLowerCase().includes(searchTerm) ||
        item.madeFrom.toLowerCase().includes(searchTerm)
    );

    if (filteredItems.length === 0) {
        document.getElementById("inventoryView").innerHTML = "<p>No matching items found.</p>";
        return;
    }

    displaySalesInventoryList(filteredItems);
    };
}

// Function to display inventory items in sales module
function displaySalesInventoryList(items) {
    const inventoryView = document.getElementById('inventoryView');
    if (!inventoryView) return;

    const table = document.createElement('table');
    table.innerHTML = `
        <tr>
            <th>Item Code</th>
            <th>Category</th>
            <th>Subcategory</th>
            <th>Made From</th>
            <th>Available Stock</th>
            <th>Unit</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
    `;
    
    items.forEach(item => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${item.productId}</td>
            <td>${item.category}</td>
            <td>${item.subcategory}</td>
            <td>${item.madeFrom}</td>
            <td>${item.quantityAvailable}</td>
            <td>${item.unit}</td>
            <td>₱${item.retailPrice.toFixed(2)}</td>
            <td>
                <button onclick="selectItem('${item.productId}')" class="select-btn">Select</button>
            </td>
        `;
        table.appendChild(tr);
    });
    
    inventoryView.innerHTML = '';
    inventoryView.appendChild(table);
}

// Function to select an item from search results
function selectItem(productId) {
    const item = loadInventoryData().find(item => item.productId === productId);
    if (item) {
        document.getElementById('salesItemCode').value = item.productId;
        document.getElementById('salesCategory').value = item.category;
        document.getElementById('salesSubcategory').value = item.subcategory;
        document.getElementById('salesSize').value = item.size;
        document.getElementById('salesUnit').value = item.unit;
        document.getElementById('salesQuantity').focus();
    }
}

// Function to update subcategories based on selected category
if (typeof window.updateSalesSubcategories === 'undefined') {
    window.updateSalesSubcategories = function() {
    const category = document.getElementById('salesCategory').value;
        const subcategorySelect = $('#salesSubcategory');
    if (!subcategorySelect) return;

        // Clear existing options
        subcategorySelect.empty();
        
        // Add default option
        subcategorySelect.append(new Option('Select Subcategory', '', true, true));
        
        if (category && window.subcategoriesMap[category]) {
            window.subcategoriesMap[category].forEach(sub => {
                subcategorySelect.append(new Option(sub, sub));
            });
        }
        
        // Reinitialize Select2
        subcategorySelect.trigger('change.select2');
    };
}

// Function to add item to order
function addToOrder() {
    const itemCode = document.getElementById('salesItemCode').value;
    const quantity = document.getElementById('salesQuantity').value;
    const category = document.getElementById('salesCategory').value;
    const subcategory = document.getElementById('salesSubcategory').value;
    const size = document.getElementById('salesSize').value;
    const unit = document.getElementById('salesUnit').value;

    // Check if item is selected or entered
    if (!itemCode) {
        showNotification('Please select or enter an item first', 'error');
        return;
    }

    // Check if quantity is entered
    if (!quantity) {
        showNotification('Please enter quantity', 'error');
        return;
    }
    
    // Convert quantity to number and validate
    const quantityNum = parseInt(quantity);
    if (isNaN(quantityNum) || quantityNum <= 0) {
        showNotification('Please enter a valid quantity', 'error');
        return;
    }

    // Check if item exists in inventory
    const item = loadInventoryData().find(item => item.productId === itemCode);
    if (!item) {
        showNotification('Selected item not found in inventory', 'error');
        return;
    }
    
    // Check if quantity is available
    if (quantityNum > item.quantityAvailable) {
        showNotification('Insufficient stock available', 'error');
        return;
    }
    
    // Add item to order
    const orderItem = {
        itemCode,
        category: item.category,
        subcategory: item.subcategory,
        size: item.size,
        unit: item.unit,
        quantity: quantityNum,
        price: item.retailPrice,
        total: quantityNum * item.retailPrice
    };
    
    // Add to order items array
    currentOrderItems.push(orderItem);
    orderTotal += orderItem.total;

    // Update order display
    updateOrderDisplay();

    // Clear input fields
    document.getElementById('salesItemCode').value = '';
    document.getElementById('salesQuantity').value = '';
    document.getElementById('salesCategory').value = '';
    document.getElementById('salesSubcategory').value = '';
    document.getElementById('salesSize').value = '';
    document.getElementById('salesUnit').value = '';

    // Reset Select2 dropdowns
    $('#salesCategory').val('').trigger('change');
    $('#salesSubcategory').val('').trigger('change');
    $('#salesSize').val('').trigger('change');
    $('#salesUnit').val('').trigger('change');

    showNotification('Item added to order successfully', 'success');
}

// Function to update order display
function updateOrderDisplay() {
    const orderItemsContainer = document.getElementById('orderItems');
    const totalAmountElement = document.getElementById('totalAmount');
    
    if (!orderItemsContainer || !totalAmountElement) {
        console.error('Required elements not found');
        return;
    }

    // Clear existing items
    orderItemsContainer.innerHTML = '';

    // Add each item to the display
    let totalAmount = 0;
    currentOrderItems.forEach((item, index) => {
        const itemElement = document.createElement('div');
        itemElement.className = 'order-item';
        itemElement.innerHTML = `
            <div class="order-item-details">
                <span>${item.itemCode}</span>
                <span>${item.category} - ${item.subcategory}</span>
                <span>Size: ${item.size}, Unit: ${item.unit}</span>
            </div>
            <div class="order-item-total">
                <span>${item.quantity} x ₱${item.price.toFixed(2)} = ₱${item.total.toFixed(2)}</span>
            <div class="order-item-actions">
                    <button class="edit-btn" onclick="editOrderItem(${index})">
                        <i class="fas fa-edit"></i>
                    </button>
                <button class="remove-btn" onclick="removeOrderItem(${index})">
                    <i class="fas fa-times"></i>
                </button>
                </div>
            </div>
        `;
        orderItemsContainer.appendChild(itemElement);
        totalAmount += item.total;
    });

    // Update total amount
    totalAmountElement.textContent = totalAmount.toFixed(2);
}

// Function to edit order item
function editOrderItem(index) {
    const item = currentOrderItems[index];
    if (!item) {
        showNotification('Item not found', 'error');
        return;
    }

    // Populate form with item details
    document.getElementById('salesItemCode').value = item.itemCode;
    document.getElementById('salesCategory').value = item.category;
    document.getElementById('salesSubcategory').value = item.subcategory;
    document.getElementById('salesSize').value = item.size;
    document.getElementById('salesUnit').value = item.unit;
    document.getElementById('salesQuantity').value = item.quantity;

    // Remove the item from the order
    currentOrderItems.splice(index, 1);
    orderTotal -= item.total;
    updateOrderDisplay();
    
    showNotification('Item ready for editing', 'info');
}

// Function to remove item from order
function removeOrderItem(index) {
    if (currentOrderItems && currentOrderItems[index]) {
    const removedItem = currentOrderItems.splice(index, 1)[0];
    orderTotal -= removedItem.total;
    updateOrderDisplay();
        showNotification('Item removed from order', 'success');
    }
}

// Function to clear order form
function clearOrderForm() {
    const fields = [
        'salesItemCode',
        'salesQuantity',
        'salesCategory',
        'salesSubcategory',
        'salesSize',
        'salesUnit'
    ];
    
    fields.forEach(fieldId => {
        const element = document.getElementById(fieldId);
        if (element) {
            element.value = '';
        }
    });
}

// Function to save order
function saveOrder() {
    if (currentOrderItems.length === 0) {
        showNotification('Please add items to the order before saving', 'error');
        return;
    }

    // Generate new order number
    const orderId = generateOrderId();
    document.getElementById('currentOrderId').textContent = orderId;

    // Save order to localStorage
    const order = {
        orderId,
        items: currentOrderItems,
        total: orderTotal,
        date: new Date().toISOString()
    };

    let orders = JSON.parse(localStorage.getItem('orders') || '[]');
    orders.push(order);
    localStorage.setItem('orders', JSON.stringify(orders));

    // Clear current order
    currentOrderItems = [];
    orderTotal = 0;
    updateOrderDisplay();

    showNotification('Order saved successfully!', 'success');
}

// Function to print receipt
function printReceipt() {
    if (currentOrderItems.length === 0) {
        showNotification('No items to print', 'error');
        return;
    }

    const orderId = document.getElementById('currentOrderId').textContent;
    const paymentMethod = document.getElementById('paymentMethod').value;
    
    let receipt = `
        <div style="text-align: center; font-family: Arial, sans-serif;">
            <h2>Mary's Native Product Store</h2>
            <p>Order ID: ${orderId}</p>
            <p>Date: ${new Date().toLocaleString()}</p>
            <hr>
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <th style="text-align: left;">Product Code</th>
                    <th style="text-align: left;">Item</th>
                    <th style="text-align: right;">Qty</th>
                    <th style="text-align: right;">Price</th>
                    <th style="text-align: right;">Total</th>
                </tr>
    `;

    currentOrderItems.forEach(item => {
        receipt += `
            <tr>
                <td>${item.itemCode}</td>
                <td style="text-align: right;">${item.quantity} ${item.unit}</td>
                <td style="text-align: right;">₱${item.price.toFixed(2)}</td>
                <td style="text-align: right;">₱${item.total.toFixed(2)}</td>
            </tr>
        `;
    });

    receipt += `
            </table>
            <hr>
            <p style="text-align: right;"><strong>Total: ₱${orderTotal.toFixed(2)}</strong></p>
            <p>Payment Method: ${paymentMethod}</p>
            <p>Thank you for your purchase!</p>
        </div>
    `;

    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html>
            <head>
                <title>Receipt - ${orderId}</title>
                <style>
                    @media print {
                        body { -webkit-print-color-adjust: exact; }
                    }
                </style>
            </head>
            <body>
                ${receipt}
                <script>
                    window.onload = function() {
                        window.print();
                        window.close();
                    };
                </script>
            </body>
        </html>
    `);
    printWindow.document.close();

    showNotification('Receipt printed successfully', 'success');
}

// Make functions available globally
window.selectItem = selectItem;
window.addToOrder = addToOrder;
window.removeOrderItem = removeOrderItem;
window.editOrderItem = editOrderItem;
window.saveOrder = saveOrder;
window.printReceipt = printReceipt;

// Initialize sales module when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Load inventory data
    loadInventoryData();
    
    // Set initial order ID
    const currentOrderId = document.getElementById('currentOrderId');
    if (currentOrderId) {
        currentOrderId.textContent = generateOrderId();
    }
    
    // Add event listeners
    const searchButton = document.querySelector('.search-icon');
    if (searchButton) {
        searchButton.addEventListener('click', searchSalesInventory);
    }
    
    const searchInput = document.getElementById('salesInventorySearch');
    if (searchInput) {
        searchInput.addEventListener('input', searchSalesInventory);
    }
    
    // Initialize Select2 for sales category
    $('#salesCategory').select2({
        width: '100%',
        placeholder: 'Select Category',
        allowClear: true
    }).on('change', function() {
        window.updateSalesSubcategories();
    });

    // Initialize Select2 for sales subcategory
    $('#salesSubcategory').select2({
        width: '100%',
        placeholder: 'Select Subcategory',
        allowClear: true
    });

    // Initialize other Select2 dropdowns
    $('#salesSize, #salesUnit').select2({
        width: '100%',
        placeholder: 'Select an option',
        allowClear: true
    });

    // Initialize subcategories
    window.updateSalesSubcategories();

    const printBtn = document.querySelector('.print-btn');
    if (printBtn) {
        printBtn.addEventListener('click', printReceipt);
    }
}); 