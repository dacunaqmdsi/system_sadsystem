// User Management Functions
function manageUsers() {
  const currentUser = JSON.parse(sessionStorage.getItem("currentUser"));
  if (!currentUser || currentUser.role !== "admin") {
    alert("Access Denied. Only System Admin can manage users.");
    return;
  }
  
  // Toggle Manage Users section visibility
  const manageUsersSection = document.getElementById("manageUsers");
  if (!manageUsersSection) return;
  
  manageUsersSection.style.display = "block";

  // Show Create Account form by default
  const createAccountBox = document.getElementById("createAccountBox");
  const userStatusBox = document.getElementById("userStatusBox");
  
  if (createAccountBox) createAccountBox.style.display = "block";
  if (userStatusBox) userStatusBox.style.display = "none";
}

// Show Create Account form
function showCreateAccount() {
  const createAccountBox = document.getElementById("createAccountBox");
  const userStatusBox = document.getElementById("userStatusBox");
  
  if (createAccountBox) createAccountBox.style.display = "block";
  if (userStatusBox) userStatusBox.style.display = "none";
}

// Show User Status section
function showUserStatus() {
  const userStatusBox = document.getElementById("userStatusBox");
  const createAccountBox = document.getElementById("createAccountBox");
  
  if (userStatusBox) userStatusBox.style.display = "block";
  if (createAccountBox) createAccountBox.style.display = "none";
}

// Create new user account
function createUserAccount(event) {
  event.preventDefault();
  
  const username = document.getElementById("username")?.value.trim();
  const password = document.getElementById("password")?.value;
  const accountType = document.getElementById("accountType")?.value;
  
  if (!username || !password || !accountType) {
    alert("Please fill in all fields.");
    return;
  }
  
  // Check if username already exists
  if (registeredUsers.some(user => user.username === username)) {
    alert("Username already exists. Please choose a different username.");
    return;
  }
  
  // Create new user
  const newUser = {
    username: username,
    password: password,
    role: accountType
  };
  
  // Add to registered users
  registeredUsers.push(newUser);
  localStorage.setItem("registeredUsers", JSON.stringify(registeredUsers));
  
  // Clear form
  const usernameInput = document.getElementById("username");
  const passwordInput = document.getElementById("password");
  const accountTypeSelect = document.getElementById("accountType");
  
  if (usernameInput) usernameInput.value = "";
  if (passwordInput) passwordInput.value = "";
  if (accountTypeSelect) accountTypeSelect.selectedIndex = 0;
  
  alert("User account created successfully!");
  addNotification("New user account created: " + username + " (" + accountType + ")");
}

// Update user status display
function updateUserStatus() {
  const userStatusList = document.getElementById("userStatusList");
  if (!userStatusList) return;
  
  userStatusList.innerHTML = "";
  
  registeredUsers.forEach(user => {
    const li = document.createElement("li");
    li.className = "online"; // For demo purposes, all users are shown as online
    li.textContent = `${user.username} (${user.role})`;
    userStatusList.appendChild(li);
  });
}

// Initialize user management module
document.addEventListener('DOMContentLoaded', function() {
  const createAccountForm = document.getElementById("createAccountForm");
  if (createAccountForm) {
    createAccountForm.addEventListener("submit", createUserAccount);
  }
  
  // Update user status periodically
  setInterval(updateUserStatus, 5000);
});

// User Management Module Functions

// Initialize users array
let users = JSON.parse(localStorage.getItem('users')) || [{
    userId: 'USR001',
    username: 'admin',
    password: 'admin123',
    role: 'admin',
    firstName: 'System',
    lastName: 'Admin',
    middleName: '',
    address: 'Store Address',
    age: 30,
    email: 'admin@marysstore.com',
    contact: '09123456789',
    status: 'active',
    lastLogin: new Date().toISOString()
}];

// Track which user is being edited
let editingUserId = null;

function displayUsers() {
    displayPersonalInfo();
    displayUserStatus();
}

function displayPersonalInfo() {
    const userList = document.getElementById('userPersonalList');
    userList.innerHTML = '';

    users.forEach(user => {
        const row = document.createElement('tr');
        row.setAttribute('data-user-id', user.userId);
        row.innerHTML = `
            <td>${user.userId}</td>
            <td>${user.lastName}</td>
            <td>${user.firstName}</td>
            <td>${user.middleName}</td>
            <td>${user.address}</td>
            <td>${user.age}</td>
            <td>${user.email}</td>
            <td>${user.contact}</td>
        `;
        userList.appendChild(row);
    });
}

function displayUserStatus() {
    const userList = document.getElementById('userStatusList');
    userList.innerHTML = '';

    users.forEach(user => {
        const row = document.createElement('tr');
        row.setAttribute('data-user-id', user.userId);
        row.innerHTML = `
            <td>${user.userId}</td>
            <td>${user.username}</td>
            <td>${user.password}</td>
            <td>${user.role}</td>
            <td>${user.status}</td>
            <td>${new Date(user.lastLogin).toLocaleString()}</td>
            <td>
                <button class="action-btn edit-btn" onclick="editUser('${user.userId}')">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button class="action-btn save-btn" onclick="saveUser('${user.userId}')" style="display: none;">
                    <i class="fas fa-save"></i> Save
                </button>
                <button class="action-btn logout-btn" onclick="logoutUser('${user.userId}')">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </td>
        `;
        userList.appendChild(row);
    });
}

function createUser(event) {
    event.preventDefault();
    console.log("Starting user creation process...");

    const userId = document.getElementById('newUserId').value;
    const username = document.getElementById('newUsername').value;
    const password = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const role = document.getElementById('userRole').value;

    console.log("Validating input data...");
    // Validate passwords match
    if (password !== confirmPassword) {
        alert('Passwords do not match!');
        return;
    }

    // Get existing users
    console.log("Retrieving existing users...");
    const existingUsers = JSON.parse(localStorage.getItem('users')) || [];
    const existingRegisteredUsers = JSON.parse(localStorage.getItem('registeredUsers')) || [];

    console.log("Checking for existing users...");
    // Check if user ID already exists
    if (existingUsers.some(user => user.userId === userId)) {
        alert('User ID already exists!');
        return;
    }

    // Check if username already exists
    if (existingUsers.some(user => user.username === username)) {
        alert('Username already exists!');
        return;
    }

    console.log("Creating new user object...");
    const newUser = {
        userId: userId,
        username: username,
        password: password,
        role: role,
        firstName: document.getElementById('newFirstName').value,
        lastName: document.getElementById('newLastName').value,
        middleName: document.getElementById('newMiddleName').value,
        address: document.getElementById('newAddress').value,
        age: document.getElementById('newAge').value,
        email: document.getElementById('newEmail').value,
        contact: document.getElementById('newContact').value,
        status: 'active',
        lastLogin: new Date().toISOString()
    };

    console.log("Adding new user to arrays...");
    // Add to users array
    existingUsers.push(newUser);
    
    // Add to registeredUsers array
    existingRegisteredUsers.push({
        username: username,
        password: password,
        role: role
    });
    
    console.log("Saving to localStorage...");
    try {
        // Save both arrays to localStorage
        localStorage.setItem('users', JSON.stringify(existingUsers));
        localStorage.setItem('registeredUsers', JSON.stringify(existingRegisteredUsers));
        console.log("Data saved successfully to localStorage");
    } catch (error) {
        console.error("Error saving to localStorage:", error);
        alert("Error saving user data. Please try again.");
        return;
    }

    // Clear form
    console.log("Clearing form...");
    event.target.reset();
    
    // Refresh display
    console.log("Refreshing display...");
    displayUsers();
    
    console.log('User created successfully:', username);
    alert('User created successfully! You can now log in with these credentials.');
}

function editUser(userId) {
    editingUserId = userId;
    const user = users.find(u => u.userId === userId);
    if (!user) return;

    // Make personal info editable
    const personalRow = document.querySelector(`#userPersonalList tr[data-user-id="${userId}"]`);
    if (personalRow) {
        const cells = personalRow.cells;
        for (let i = 1; i < cells.length; i++) { // Skip User ID
            const cell = cells[i];
            const originalValue = cell.textContent;
            cell.innerHTML = `<input type="text" value="${originalValue}" style="width: 100%;">`;
        }
    }

    // Make status info editable
    const statusRow = document.querySelector(`#userStatusList tr[data-user-id="${userId}"]`);
    if (statusRow) {
        // Hide edit button, show save button
        statusRow.querySelector('.edit-btn').style.display = 'none';
        statusRow.querySelector('.save-btn').style.display = 'inline-block';

        const cells = statusRow.cells;
        for (let i = 1; i < cells.length - 1; i++) { // Skip User ID and Actions
            const cell = cells[i];
            const originalValue = cell.textContent;
            cell.innerHTML = `<input type="text" value="${originalValue}" style="width: 100%;">`;
        }
    }
}

function saveUser(userId) {
    const user = users.find(u => u.userId === userId);
    if (!user) return;

    // Update personal info
    const personalRow = document.querySelector(`#userPersonalList tr[data-user-id="${userId}"]`);
    if (personalRow) {
        const cells = personalRow.cells;
        user.lastName = cells[1].querySelector('input').value;
        user.firstName = cells[2].querySelector('input').value;
        user.middleName = cells[3].querySelector('input').value;
        user.address = cells[4].querySelector('input').value;
        user.age = cells[5].querySelector('input').value;
        user.email = cells[6].querySelector('input').value;
        user.contact = cells[7].querySelector('input').value;
    }

    // Update status info
    const statusRow = document.querySelector(`#userStatusList tr[data-user-id="${userId}"]`);
    if (statusRow) {
        const cells = statusRow.cells;
        user.username = cells[1].querySelector('input').value;
        user.password = cells[2].querySelector('input').value;
        user.role = cells[3].querySelector('input').value;
        user.status = cells[4].querySelector('input').value;
    }

    // Reset editing state
    editingUserId = null;
    displayUsers();
    alert('User updated successfully!');
}

function logoutUser(userId) {
    try {
        // Clear session storage
        sessionStorage.clear();
        
        // Hide dashboard and show auth section
        const dashboardSection = document.getElementById("dashboardSection");
        const authSection = document.getElementById("authSection");
        
        if (dashboardSection) dashboardSection.style.display = "none";
        if (authSection) authSection.style.display = "block";
        
        // Clear login form
        const loginForm = document.getElementById("loginContainer");
        if (loginForm) {
            const inputs = loginForm.getElementsByTagName("input");
            for (let input of inputs) {
                input.value = "";
            }
        }
        
        // Reset role selection
        const roleSelect = document.getElementById("loginRole");
        if (roleSelect) roleSelect.selectedIndex = 0;
        
        // Reload the page
        location.reload();
    } catch (error) {
        console.error("Error during logout:", error);
        alert("An error occurred during logout. Please try again.");
    }
}

function searchUsers() {
    const searchTerm = document.getElementById('userSearch').value.toLowerCase();
    const filteredUsers = users.filter(user => 
        user.userId.toLowerCase().includes(searchTerm) ||
        user.username.toLowerCase().includes(searchTerm) ||
        user.firstName.toLowerCase().includes(searchTerm) ||
        user.lastName.toLowerCase().includes(searchTerm) ||
        user.role.toLowerCase().includes(searchTerm)
    );
    
    displayFilteredUsers(filteredUsers);
}

function displayFilteredUsers(filteredUsers) {
    const personalList = document.getElementById('userPersonalList');
    const statusList = document.getElementById('userStatusList');
    personalList.innerHTML = '';
    statusList.innerHTML = '';

    filteredUsers.forEach(user => {
        // Personal Info Row
        const personalRow = document.createElement('tr');
        personalRow.setAttribute('data-user-id', user.userId);
        personalRow.innerHTML = `
            <td>${user.userId}</td>
            <td>${user.lastName}</td>
            <td>${user.firstName}</td>
            <td>${user.middleName}</td>
            <td>${user.address}</td>
            <td>${user.age}</td>
            <td>${user.email}</td>
            <td>${user.contact}</td>
        `;
        personalList.appendChild(personalRow);

        // Status Info Row
        const statusRow = document.createElement('tr');
        statusRow.setAttribute('data-user-id', user.userId);
        statusRow.innerHTML = `
            <td>${user.userId}</td>
            <td>${user.username}</td>
            <td>${user.password}</td>
            <td>${user.role}</td>
            <td>${user.status}</td>
            <td>${new Date(user.lastLogin).toLocaleString()}</td>
            <td>
                <button class="action-btn edit-btn" onclick="editUser('${user.userId}')">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button class="action-btn save-btn" onclick="saveUser('${user.userId}')" style="display: none;">
                    <i class="fas fa-save"></i> Save
                </button>
                <button class="action-btn logout-btn" onclick="logoutUser('${user.userId}')">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </td>
        `;
        statusList.appendChild(statusRow);
    });
}

// Initialize the user management module
function initializeUserManagement() {
    displayUsers();
}

// Add event listener for when the module is shown
document.addEventListener('DOMContentLoaded', function() {
    const userManagementModule = document.getElementById('userManagementModule');
    if (userManagementModule) {
        userManagementModule.addEventListener('show', initializeUserManagement);
    }
}); 