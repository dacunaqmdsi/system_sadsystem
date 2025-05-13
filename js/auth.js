// Login Function
let currentUserRole = "";

function loginUser() {
    const username = document.getElementById("loginUsername").value.trim();
    const password = document.getElementById("loginPassword").value;
    let role = document.getElementById("loginRole").value;

    // Normalize role value for comparison
    if (role === "System Admin") role = "admin";
    if (role === "Inventory Personnel") role = "inventory";
    if (role === "Cashier") role = "cashier";

    // Get registered users from localStorage
    const registeredUsers = JSON.parse(localStorage.getItem('registeredUsers')) || [];
    const users = JSON.parse(localStorage.getItem('users')) || [];
    
    // First try to find user in registeredUsers
    let user = registeredUsers.find(u => u.username === username && u.password === password && u.role === role);
    
    // If not found in registeredUsers, try to find in users array
    if (!user) {
        user = users.find(u => u.username === username && u.password === password && u.role === role);
    }
    
    if (!user) {
        alert("Invalid credentials. Please try again.");
        return;
    }

    // Store the full user object in session
    const fullUserData = users.find(u => u.username === username) || user;
    sessionStorage.setItem("currentUser", JSON.stringify(fullUserData));
    currentUserRole = fullUserData.role;

    // Update UI
    document.getElementById("authSection").style.display = "none";
    document.getElementById("dashboardSection").style.display = "block";
    document.getElementById("userRoleText").innerHTML = `${fullUserData.username} (${fullUserData.role.toUpperCase()})`;

    // Update last login time
    const updatedUsers = users.map(u => {
        if (u.username === username) {
            return { ...u, lastLogin: new Date().toISOString() };
        }
        return u;
    });
    localStorage.setItem('users', JSON.stringify(updatedUsers));

    updateNavBar(fullUserData.role);
    showModule("dashboardModule");
    console.log("Login successful for user:", username);
}

// Logout Function
function logoutUser() {
    try {
        console.log("Starting logout process...");
        
        // Clear all session storage
        sessionStorage.clear();
        currentUserRole = "";

        // Reset UI
        const dashboardSection = document.getElementById("dashboardSection");
        const authSection = document.getElementById("authSection");
        
        if (dashboardSection) {
            console.log("Hiding dashboard section");
            dashboardSection.style.display = "none";
        }
        
        if (authSection) {
            console.log("Showing auth section");
            authSection.style.display = "block";
        }

        // Clear any form data
        const loginForm = document.getElementById("loginContainer");
        if (loginForm) {
            console.log("Clearing login form");
            const inputs = loginForm.getElementsByTagName("input");
            for (let input of inputs) {
                input.value = "";
            }
        }

        // Reset role selection
        const roleSelect = document.getElementById("loginRole");
        if (roleSelect) {
            console.log("Resetting role selection");
            roleSelect.selectedIndex = 0;
        }

        // Reload the page to ensure clean state
        console.log("Logout successful, reloading page...");
        location.reload();
    } catch (error) {
        console.error("Error during logout:", error);
        alert("An error occurred during logout. Please try again.");
    }
}

// Disabled sign-up function
function registerUser() {
    alert("User registration is disabled. Only a System Admin can create accounts via Manage Users.");
}

// Toggle Auth UI – only login is shown
function toggleAuth() {
    const signup = document.getElementById("signupContainer");
    const login = document.getElementById("loginContainer");
    signup.style.display = "none";
    login.style.display = login.style.display === "none" ? "block" : "none";
}