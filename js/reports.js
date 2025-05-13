// Reports Module Functions

// Business Information
const businessInfo = {
    name: "Mary's Native Product Store",
    address: "123 Main Street, City, Province, 1234",
    contact: "Phone: (123) 456-7890 | Email: info@marysnativeproducts.com",
    logo: "images/logo2.jpg"
};

// Generate Letterhead HTML
function generateLetterhead(reportTitle) {
    return `
        <div class="report-letterhead">
            <div class="report-header">
                <img src="${businessInfo.logo}" alt="Store Logo" class="report-logo">
                <div class="report-business-info">
                    <div class="report-business-name">${businessInfo.name}</div>
                    <div class="report-business-details">
                        ${businessInfo.address}<br>
                        ${businessInfo.contact}
                    </div>
                </div>
            </div>
            <div class="report-title">${reportTitle}</div>
            <div class="report-date">Generated on: ${new Date().toLocaleDateString()}</div>
        </div>
    `;
}

// System Logs Report
function viewErrorLogs() {
    const output = document.getElementById('systemLogsOutput');
    const fromDate = document.getElementById('logsFromDate').value;
    const toDate = document.getElementById('logsToDate').value;
    const logType = document.getElementById('logTypeFilter').value;

    // Add letterhead
    output.innerHTML = generateLetterhead('System Logs Report');

    // Add report content
    output.innerHTML += `
        <div class="report-filters">
            <div class="report-filter-group">
                <label>Date Range:</label>
                <div>${fromDate || 'All dates'} to ${toDate || 'All dates'}</div>
            </div>
            <div class="report-filter-group">
                <label>Log Type:</label>
                <div>${logType || 'All types'}</div>
            </div>
        </div>
        <div class="report-content">
            <!-- Logs will be displayed here -->
        </div>
    `;
}

// Sales Report
function generateSalesReport() {
    const output = document.getElementById('salesReportOutput');
    const fromDate = document.getElementById('salesFromDate').value;
    const toDate = document.getElementById('salesToDate').value;
    const itemFilter = document.getElementById('salesItemFilter').value;
    const levelFilter = document.getElementById('salesLevelFilter').value;

    // Get sales data from localStorage
    const salesData = JSON.parse(localStorage.getItem('salesOrders') || '[]');

    // Filter sales data
    const filteredSales = salesData.filter(sale => {
        const saleDate = new Date(sale.date);
        const from = fromDate ? new Date(fromDate) : null;
        const to = toDate ? new Date(toDate) : null;

        return (!from || saleDate >= from) &&
            (!to || saleDate <= to) &&
            (!itemFilter || sale.itemCode === itemFilter) &&
            (!levelFilter || (levelFilter === 'high' && sale.quantity > 10) ||
                (levelFilter === 'low' && sale.quantity <= 10));
    });

    // Calculate totals
    const totalSales = filteredSales.reduce((sum, sale) => sum + sale.total, 0);
    const totalItems = filteredSales.reduce((sum, sale) => sum + sale.quantity, 0);

    // Add letterhead
    output.innerHTML = generateLetterhead('Sales Report');

    // Add report content
    output.innerHTML += `
        <div class="report-filters">
            <div class="report-filter-group">
                <label>Date Range:</label>
                <div>${fromDate || 'All dates'} to ${toDate || 'All dates'}</div>
            </div>
            <div class="report-filter-group">
                <label>Item:</label>
                <div>${itemFilter || 'All items'}</div>
            </div>
            <div class="report-filter-group">
                <label>Sales Level:</label>
                <div>${levelFilter || 'All levels'}</div>
            </div>
        </div>
        <div class="report-summary">
            <div class="report-summary-item">
                <span class="report-summary-label">Total Sales:</span>
                <span>₱${totalSales.toFixed(2)}</span>
            </div>
            <div class="report-summary-item">
                <span class="report-summary-label">Total Items Sold:</span>
                <span>${totalItems}</span>
            </div>
        </div>
        <div class="report-content">
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Order ID</th>
                        <th>Item Code</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    ${filteredSales.map(sale => `
                        <tr>
                            <td>${sale.date || ''}</td>
                            <td>${sale.orderId || ''}</td>
                            <td>${sale.itemCode || ''}</td>
                            <td>${sale.category || ''}</td>
                            <td>${sale.quantity || 0}</td>
                            <td>₱${(sale.unitPrice || 0).toFixed(2)}</td>
                            <td>₱${(sale.total || 0).toFixed(2)}</td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        </div>
    `;
}

// Inventory Report
function generateInventoryReport() {
    const output = document.getElementById('inventoryReportOutput');
    const fromDate = document.getElementById('inventoryFromDate').value;
    const toDate = document.getElementById('inventoryToDate').value;
    const itemFilter = document.getElementById('inventoryItemFilter').value;
    const levelFilter = document.getElementById('stockLevelFilter').value;

    // Get inventory data from localStorage
    const inventoryData = JSON.parse(localStorage.getItem('inventoryData') || '[]');

    // Filter inventory data
    const filteredInventory = inventoryData.filter(item => {
        const itemDate = new Date(item.dateAdded);
        const from = fromDate ? new Date(fromDate) : null;
        const to = toDate ? new Date(toDate) : null;

        return (!from || itemDate >= from) &&
            (!to || itemDate <= to) &&
            (!itemFilter || item.productId === itemFilter) &&
            (!levelFilter ||
                (levelFilter === 'high' && item.quantityAvailable > item.reorderThreshold) ||
                (levelFilter === 'low' && item.quantityAvailable <= item.reorderThreshold) ||
                (levelFilter === 'critical' && item.quantityAvailable < item.reorderThreshold * 0.5));
    });

    // Calculate total inventory value
    const totalValue = filteredInventory.reduce((sum, item) =>
        sum + (item.quantityAvailable * item.retailPrice), 0);

    // Add letterhead
    output.innerHTML = generateLetterhead('Inventory Report');

    // Add report content
    output.innerHTML += `
        <div class="report-filters">
            <div class="report-filter-group">
                <label>Date Range:</label>
                <div>${fromDate || 'All dates'} to ${toDate || 'All dates'}</div>
            </div>
            <div class="report-filter-group">
                <label>Item:</label>
                <div>${itemFilter || 'All items'}</div>
            </div>
            <div class="report-filter-group">
                <label>Stock Level:</label>
                <div>${levelFilter || 'All levels'}</div>
            </div>
        </div>
        <div class="report-summary">
            <div class="report-summary-item">
                <span class="report-summary-label">Total Inventory Value:</span>
                <span>₱${totalValue.toFixed(2)}</span>
            </div>
            <div class="report-summary-item">
                <span class="report-summary-label">Total Items:</span>
                <span>${filteredInventory.length}</span>
            </div>
        </div>
        <div class="report-content">
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Category</th>
                        <th>Subcategory</th>
                        <th>Quantity Available</th>
                        <th>Reorder Threshold</th>
                        <th>Cost Price</th>
                        <th>Retail Price</th>
                        <th>Storage Location</th>
                    </tr>
                </thead>
                <tbody>
                    ${filteredInventory.map(item => `
                        <tr>
                            <td>${item.productId || ''}</td>
                            <td>${item.category || ''}</td>
                            <td>${item.subcategory || ''}</td>
                            <td>${item.quantityAvailable || 0}</td>
                            <td>${item.reorderThreshold || 0}</td>
                            <td>₱${(item.costPrice || 0).toFixed(2)}</td>
                            <td>₱${(item.retailPrice || 0).toFixed(2)}</td>
                            <td>${item.storageLocation || ''}</td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        </div>
    `;
}

// Sales History
function filterSalesHistory() {
    const output = document.getElementById('salesHistory');
    const fromDate = document.getElementById('historyFromDate').value;
    const toDate = document.getElementById('historyToDate').value;

    // Get sales data from localStorage
    const salesData = JSON.parse(localStorage.getItem('salesOrders') || '[]');

    // Filter sales data
    const filteredSales = salesData.filter(sale => {
        const saleDate = new Date(sale.date);
        const from = fromDate ? new Date(fromDate) : null;
        const to = toDate ? new Date(toDate) : null;
        return (!from || saleDate >= from) && (!to || saleDate <= to);
    });

    // Group sales by date
    const salesByDate = filteredSales.reduce((groups, sale) => {
        const date = sale.date;
        if (!groups[date]) {
            groups[date] = [];
        }
        groups[date].push(sale);
        return groups;
    }, {});

    // Add letterhead
    output.innerHTML = generateLetterhead('Sales History Report');

    // Add report content
    output.innerHTML += `
        <div class="report-filters">
            <div class="report-filter-group">
                <label>Date Range:</label>
                <div>${fromDate || 'All dates'} to ${toDate || 'All dates'}</div>
            </div>
        </div>
        <div class="report-content">
            ${Object.entries(salesByDate).map(([date, sales]) => `
                <div class="sales-history-date">
                    <h4>${date}</h4>
                    <table class="report-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Item Code</th>
                                <th>Category</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${sales.map(sale => `
                                <tr>
                                    <td>${sale.orderId || ''}</td>
                                    <td>${sale.itemCode || ''}</td>
                                    <td>${sale.category || ''}</td>
                                    <td>${sale.quantity || 0}</td>
                                    <td>₱${(sale.unitPrice || 0).toFixed(2)}</td>
                                    <td>₱${(sale.total || 0).toFixed(2)}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            `).join('')}
        </div>
    `;
}

// Export to PDF
function downloadLogsPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    // Add letterhead
    doc.addImage(businessInfo.logo, 'JPEG', 10, 10, 30, 30);
    doc.setFontSize(16);
    doc.text(businessInfo.name, 50, 20);
    doc.setFontSize(10);
    doc.text(businessInfo.address, 50, 30);
    doc.text(businessInfo.contact, 50, 35);
    doc.setFontSize(14);
    doc.text('System Logs Report', 105, 50, { align: 'center' });
    doc.text(`Generated on: ${new Date().toLocaleDateString()}`, 105, 60, { align: 'center' });

    // Add content
    // ... Add your PDF content here

    doc.save('system_logs_report.pdf');
}

function downloadSalesPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    // Add letterhead
    doc.addImage(businessInfo.logo, 'JPEG', 10, 10, 30, 30);
    doc.setFontSize(16);
    doc.text(businessInfo.name, 50, 20);
    doc.setFontSize(10);
    doc.text(businessInfo.address, 50, 30);
    doc.text(businessInfo.contact, 50, 35);
    doc.setFontSize(14);
    doc.text('Sales Report', 105, 50, { align: 'center' });
    doc.text(`Generated on: ${new Date().toLocaleDateString()}`, 105, 60, { align: 'center' });

    // Get sales data
    const salesData = JSON.parse(localStorage.getItem('salesOrders') || '[]');

    // Add sales table
    const headers = ['Date', 'Order ID', 'Item Code', 'Category', 'Quantity', 'Unit Price', 'Total'];
    const data = salesData.map(sale => [
        sale.date || '',
        sale.orderId || '',
        sale.itemCode || '',
        sale.category || '',
        sale.quantity || 0,
        `₱${(sale.unitPrice || 0).toFixed(2)}`,
        `₱${(sale.total || 0).toFixed(2)}`
    ]);

    doc.autoTable({
        head: [headers],
        body: data,
        startY: 70,
        margin: { left: 10, right: 10 }
    });

    doc.save('sales_report.pdf');
}

function downloadInventoryPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    // Add letterhead
    doc.addImage(businessInfo.logo, 'JPEG', 10, 10, 30, 30);
    doc.setFontSize(16);
    doc.text(businessInfo.name, 50, 20);
    doc.setFontSize(10);
    doc.text(businessInfo.address, 50, 30);
    doc.text(businessInfo.contact, 50, 35);
    doc.setFontSize(14);
    doc.text('Inventory Report', 105, 50, { align: 'center' });
    doc.text(`Generated on: ${new Date().toLocaleDateString()}`, 105, 60, { align: 'center' });

    // Get inventory data
    const inventoryData = JSON.parse(localStorage.getItem('inventoryData') || '[]');

    // Add inventory table
    const headers = ['Product ID', 'Category', 'Subcategory', 'Quantity', 'Reorder', 'Cost', 'Retail', 'Location'];
    const data = inventoryData.map(item => [
        item.productId || '',
        item.category || '',
        item.subcategory || '',
        item.quantityAvailable || 0,
        item.reorderThreshold || 0,
        `₱${(item.costPrice || 0).toFixed(2)}`,
        `₱${(item.retailPrice || 0).toFixed(2)}`,
        item.storageLocation || ''
    ]);

    doc.autoTable({
        head: [headers],
        body: data,
        startY: 70,
        margin: { left: 10, right: 10 }
    });

    doc.save('inventory_report.pdf');
}

// Export to Excel
function downloadLogsExcel() {
    // Create Excel file with letterhead
    // ... Add your Excel export code here
}

function downloadSalesExcel() {
    // Create Excel file with letterhead
    // ... Add your Excel export code here
}

function downloadInventoryExcel() {
    // Create Excel file with letterhead
    // ... Add your Excel export code here
}

// Initialize reports module
document.addEventListener('DOMContentLoaded', function () {
    // Set default dates for date inputs
    const today = new Date().toISOString().split('T')[0];
    document.querySelectorAll('input[type="date"]').forEach(input => {
        input.value = today;
    });

    // Populate item filters
    const inventoryData = JSON.parse(localStorage.getItem('inventoryData') || '[]');
    const salesItemFilter = document.getElementById('salesItemFilter');
    const inventoryItemFilter = document.getElementById('inventoryItemFilter');

    if (salesItemFilter) {
        inventoryData.forEach(item => {
            const option = document.createElement('option');
            option.value = item.productId;
            option.textContent = `${item.productId}`;
            salesItemFilter.appendChild(option);
        });
    }

    if (inventoryItemFilter) {
        inventoryData.forEach(item => {
            const option = document.createElement('option');
            option.value = item.productId;
            option.textContent = `${item.productId}`;
            inventoryItemFilter.appendChild(option);
        });
    }
}); 