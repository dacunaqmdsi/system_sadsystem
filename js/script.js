// Sidebar Toggle Functionality
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.querySelector('.sidebar');
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    const menuItems = document.querySelectorAll('.sidebar-menu a');

    // Toggle sidebar
    sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
    });

    // Handle menu item clicks
    menuItems.forEach(item => {
        item.addEventListener('click', function(e) {
            // Remove active class from all items
            menuItems.forEach(i => i.classList.remove('active'));
            // Add active class to clicked item
            this.classList.add('active');
        });
    });

    // Handle mobile responsive
    const mobileToggle = document.querySelector('.mobile-toggle');
    if (mobileToggle) {
        mobileToggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });
    }

    // Initialize subcategories when the page loads
    const inventoryCategory = document.getElementById('inventoryCategory');
    if (inventoryCategory) {
        if (typeof window.updateInventorySubcategories === 'function') {
            window.updateInventorySubcategories();
            inventoryCategory.addEventListener('change', window.updateInventorySubcategories);
        }
    }

    // Initialize sales subcategories
    const salesCategory = document.getElementById('salesCategory');
    if (salesCategory) {
        if (typeof window.updateSalesSubcategories === 'function') {
            window.updateSalesSubcategories();
            salesCategory.addEventListener('change', window.updateSalesSubcategories);
        }
    }

    const searchButton = document.querySelector('.search-icon');
    if (searchButton) {
        if (typeof window.searchSalesInventory === 'function') {
            searchButton.addEventListener('click', window.searchSalesInventory);
        }
    }

    // Initialize the clock
    updateClock();
    setInterval(updateClock, 1000);

    // Initialize the dashboard
    if (typeof initializeDashboard === 'function') {
        initializeDashboard();
    }

    // Initialize the inventory module
    if (typeof initializeInventory === 'function') {
        initializeInventory();
    }

    // Initialize the sales module
    if (typeof initializeSales === 'function') {
        initializeSales();
    }
});

// Clock functionality
function updateClock() {
    const clockElement = document.getElementById('clock');
    if (clockElement) {
        const now = new Date();
        const options = { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };
        clockElement.textContent = now.toLocaleDateString('en-US', options);
    }
} 