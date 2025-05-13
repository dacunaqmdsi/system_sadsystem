<h2>User Management</h2>
<div class="main-container">

    <!-- User List -->
    <div class="user-list">
        <div class="section-title">User List</div>
        <div class="search-box">
            <input type="text" placeholder="Search users...">
        </div>
        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Last Name</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Address</th>
                    <th>Age</th>
                    <th>Email</th>
                    <th>Contact #</th>
                </tr>
            </thead>
            <tbody>
                <!-- Example row -->
                <tr>
                    <td>User ID</td>
                    <td>Username</td>
                    <td>Password</td>
                    <td>Role</td>
                    <td>Status</td>
                    <td>Last Login</td>
                    <td>Actions</td>
                </tr>
                <tr>
                    <td colspan="7">• admin (admin)</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Create User -->
    <div class="create-user">
        <div class="section-title">Create New User</div>
        <form>
            <div class="form-row">
                <div><input type="text" placeholder="User ID"></div>
                <div><input type="text" placeholder="Last Name"></div>
            </div>
            <div class="form-row">
                <div><input type="text" placeholder="First Name"></div>
                <div><input type="text" placeholder="Middle Name"></div>
            </div>
            <div class="form-row">
                <div><input type="text" placeholder="Address"></div>
                <div><input type="number" placeholder="Age"></div>
            </div>
            <div class="form-row">
                <div><input type="email" placeholder="Email"></div>
                <div><input type="text" placeholder="Contact Number"></div>
            </div>
            <div class="form-row">
                <div><input type="text" placeholder="Username"></div>
                <div><input type="password" placeholder="Password"></div>
            </div>
            <div class="form-row">
                <div><input type="password" placeholder="Confirm Password"></div>
                <div>
                    <select>
                        <option>Select Role</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn">Create User</button>
        </form>
    </div>

</div>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f7f2e8;
        margin: 0;
        padding: 20px;
    }

    h2 {
        color: #333;
    }

    .main-container {
        display: flex;
        justify-content: space-between;
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .user-list,
    .create-user {
        width: 48%;
    }

    .section-title {
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 10px;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="number"],
    select {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        width: 100%;
        box-sizing: border-box;
    }

    .form-row {
        display: flex;
        gap: 10px;
        margin-bottom: 10px;
    }

    .form-row>div {
        flex: 1;
    }

    .btn {
        padding: 10px 15px;
        background-color: #8B6B4A;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    .search-box {
        margin-bottom: 10px;
    }

    .search-box input {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
</style>