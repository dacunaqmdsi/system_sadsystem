// In-memory arrays (simulate a database)
let registeredUsers = JSON.parse(localStorage.getItem("registeredUsers")) || [];
let dataInventory = [];
let orderSales = [];
let notifications = [];
let updateMode = false;

// If no user is registered, create a default admin account for testing
if (registeredUsers.length === 0) {
  registeredUsers.push({ username: "admin", password: "admin", role: "admin" });
  localStorage.setItem("registeredUsers", JSON.stringify(registeredUsers));
  console.log("Default admin account created: username 'admin', password 'admin'");
}

// Allowed navigation items for each role
const navItems = {
  admin: [
    { id: "dashboardModule", label: "Dashboard", emoji: "📊" },
    { id: "maintenanceModule", label: "Maintenance", emoji: "🛠️" },
    { id: "reportsModule", label: "Reports", emoji: "📈" },
    { id: "notificationModule", label: "Notification", emoji: "🔔" }
  ],
  cashier: [
    { id: "dashboardModule", label: "Dashboard", emoji: "📊" },
    { id: "salesModule", label: "Sales", emoji: "🛒" },
    { id: "reportsModule", label: "Reports", emoji: "📈" },
    { id: "notificationModule", label: "Notification", emoji: "🔔" }
  ],
  inventory: [
    { id: "dashboardModule", label: "Dashboard", emoji: "📊" },
    { id: "inventoryModule", label: "Inventory", emoji: "📦" },
    { id: "reportsModule", label: "Reports", emoji: "📈" },
    { id: "notificationModule", label: "Notification", emoji: "🔔" }
  ]
};

// Universal navigation items (all modules always visible except Settings and Help)
const universalNavItems = [
  { id: "dashboardModule", label: "Dashboard", emoji: "📊" },
  { id: "salesModule", label: "Sales", emoji: "🛒" },
  { id: "inventoryModule", label: "Inventory", emoji: "📦" },
  { id: "userManagementModule", label: "User Management", emoji: "👥" },
  { id: "maintenanceModule", label: "Maintenance", emoji: "🛠️" },
  { id: "reportsModule", label: "Reports", emoji: "📈" },
  { id: "notificationModule", label: "Notification", emoji: "🔔" }
];

// Get current user role from session storage after login
function getCurrentUserRole() {
  const currentUser = JSON.parse(sessionStorage.getItem("currentUser"));
  return currentUser ? currentUser.role : null;
}

// Update navigation bar based on the user's role
function updateNavBar(role) {
  const navBar = document.querySelector(".menu-items");
  if (!navBar) return;
  
  navBar.innerHTML = ""; // Clear existing navigation

  // Add all universal navigation items
  universalNavItems.forEach(item => {
    const a = document.createElement("a");
    a.href = "javascript:void(0)";
    a.onclick = () => showModule(item.id);
    a.innerHTML = `
      <i class="fa-solid ${getIconClass(item.id)}"></i>
      <span>${item.label}</span>
    `;
    navBar.appendChild(a);
  });
}

// Helper function to get icon class
function getIconClass(moduleId) {
  const iconMap = {
    'dashboardModule': 'fa-gauge-high',
    'salesModule': 'fa-chart-line',
    'inventoryModule': 'fa-boxes-stacked',
    'userManagementModule': 'fa-users-gear',
    'maintenanceModule': 'fa-screwdriver-wrench',
    'reportsModule': 'fa-file-lines',
    'notificationModule': 'fa-bell'
  };
  return iconMap[moduleId] || 'fa-circle';
}

// Check if the module is allowed for the current user
function isModuleAllowed(moduleId) {
  const currentUser = JSON.parse(sessionStorage.getItem("currentUser"));
  if (!currentUser) return false;

  const modulePermissions = {
    "dashboardModule": ["admin", "inventory", "cashier"],
    "salesModule": ["cashier", "admin"],
    "inventoryModule": ["inventory", "admin"],
    "userManagementModule": ["admin"],
    "maintenanceModule": ["admin"],
    "reportsModule": ["inventory", "cashier", "admin"],
    "notificationModule": ["inventory", "cashier", "admin"],
    "profileModule": ["inventory", "cashier", "admin"]
  };

  const allowedRoles = modulePermissions[moduleId];
  return allowedRoles && allowedRoles.includes(currentUser.role);
}

// Show the requested module or show Access Denied message
function showModule(moduleId) {
  const currentUser = JSON.parse(sessionStorage.getItem("currentUser"));
  if (!currentUser) return;

  if (!isModuleAllowed(moduleId)) {
    const deniedMessage = `
      <div style="background-color: #f8d7da; color: #721c24; padding: 20px; border: 1px solid #f5c6cb; border-radius: 5px;">
        <h2>Access Denied</h2>
        <p>You are not authorized to access this module.</p>
      </div>
    `;

    const accessDeniedArea = document.getElementById("accessDeniedModule");
    if (accessDeniedArea) {
      accessDeniedArea.innerHTML = deniedMessage;
      accessDeniedArea.style.display = "block";
    }

    const modules = document.querySelectorAll(".module");
    modules.forEach(mod => {
      if (mod.id !== "accessDeniedModule") {
        mod.style.display = "none";
      }
    });

    return;
  }

  const modules = document.querySelectorAll(".module");
  modules.forEach(mod => mod.style.display = "none");

  const targetModule = document.getElementById(moduleId);
  if (targetModule) {
    targetModule.style.display = "block";
  }

  const accessDeniedArea = document.getElementById("accessDeniedModule");
  if (accessDeniedArea) {
    accessDeniedArea.style.display = "none";
  }
}

// Real-time clock update
function updateClock() {
  const clockElement = document.getElementById("clock");
  if (!clockElement) return;

  const now = new Date();
  const options = { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' };
  const timeString = now.toLocaleTimeString();
  const dateString = now.toLocaleDateString(undefined, options);
  clockElement.innerText = dateString + " " + timeString;
}

// Initialize clock update
setInterval(updateClock, 1000);

// Initialize dashboard on load
document.addEventListener('DOMContentLoaded', function() {
  // Initialize dashboard if it exists
  if (typeof updateDashboard === 'function') {
    updateDashboard();
  }
  
  // Initialize sales chart if it exists
  if (typeof updateSalesChart === 'function') {
    updateSalesChart('weekly');
  }
});