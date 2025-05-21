<?php include('../includes/init.php'); is_blocked(); ?>
<h2>User Management</h2>
<div class="main-container">
    <div class="user-list">
        <div class="section-title">User List</div>
        <div class="search-box">
            <input type="text" id="str" placeholder="Search users..." onkeyup="ajax_fn('pages/user_management_add_user.php?str='+this.value,'tmp_user_add');">
        </div>
        <div id="tmp_user_add">
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
                        <th>Status</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $rs = mysqli_query($db_connection, "SELECT * FROM tblaccounts");
                    while ($row = mysqli_fetch_assoc($rs)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['user_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['middle_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['address']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['age']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email_address']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['contact_number']) . "</td>";
                        $status = $row['is_blocked'] == 0 ? 'Active' : 'BLOCKED';
                        $toggle_to = $row['is_blocked'] == 0 ? 1 : 0;
                        $button_label = $row['is_blocked'] == 0 ? 'Block' : 'Unblock';

                        echo "<td><span id='tmp_up{$row['accountid']}'>$status</span></td>";
                     echo "<td>
    <button class='icon-btn' onclick=\"ajax_fn('pages/user_management_update.php?toggle_block=1&accountid={$row['accountid']}', 'tmp_up{$row['accountid']}')\" title=\"{$button_label}\">
        <i class='fas fa-user-lock'></i>
    </button>
</td>";

echo "<td>
    <button class='icon-btn' onclick=\"ajax_fn('pages/user_management.php?edit=1&accountid={$row['accountid']}', 'main_content')\" title=\"Edit User\">
        <i class='fas fa-edit'></i>
    </button>
</td>";

                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
<style>
.icon-btn {
    background-color: #8b7455;
    color: white;
    border: none;
    padding: 10px 12px;
    border-radius: 6px;
    cursor: pointer;
    margin-right: 5px;
    transition: background-color 0.3s ease;
}

.icon-btn:hover {
    background-color: #7a664a;
}

.icon-btn i {
    font-size: 16px;
}
</style>

    <?php
    if (isset($_GET['edit'])) {
        $accountid = GetData('select accountid from tblaccounts where accountid=' . $_GET['accountid']);
        $user_id = GetData('select user_id from tblaccounts where accountid=' . $_GET['accountid']);
        $last_name = GetData('select last_name from tblaccounts where accountid=' . $_GET['accountid']);
        $first_name = GetData('select first_name from tblaccounts where accountid=' . $_GET['accountid']);
        $middle_name = GetData('select middle_name from tblaccounts where accountid=' . $_GET['accountid']);
        $address = GetData('select address from tblaccounts where accountid=' . $_GET['accountid']);
        $age = GetData('select age from tblaccounts where accountid=' . $_GET['accountid']);
        $email_address = GetData('select email_address from tblaccounts where accountid=' . $_GET['accountid']);
        $contact_number = GetData('select contact_number from tblaccounts where accountid=' . $_GET['accountid']);
        $username = GetData('select username from tblaccounts where accountid=' . $_GET['accountid']);
        $account_password = GetData('select account_password from tblaccounts where accountid=' . $_GET['accountid']);
        $account_type = GetData('select account_type from tblaccounts where accountid=' . $_GET['accountid']);
    }
    ?>
    <!-- Create User -->
    <div class="create-user">
        <div class="section-title">Create New User</div>
        <!-- <form> -->
        <div class="form-row">
            <div><input type="text" id="user_id" value="<?php echo $user_id; ?>" placeholder="User ID"></div>
            <div><input type="text" id="last_name" value="<?php echo $last_name; ?>" placeholder="Last Name"></div>
        </div>
        <div class="form-row">
            <div><input type="text" id="first_name" value="<?php echo $first_name; ?>" placeholder="First Name"></div>
            <div><input type="text" id="middle_name" value="<?php echo $middle_name; ?>" placeholder="Middle Name"></div>
        </div>
        <div class="form-row">
            <div><input type="text" id="address" value="<?php echo $address; ?>" placeholder="Address"></div>
            <div><input type="number" id="age" value="<?php echo $age; ?>" placeholder="Age"></div>
        </div>
        <div class="form-row">
            <div><input type="email" id="email_address" value="<?php echo $email_address; ?>" placeholder="Email"></div>
            <div><input type="text" id="contact_number" value="<?php echo $contact_number; ?>" placeholder="Contact Number"></div>
        </div>
        <div class="form-row">
            <div><input type="text" id="username" value="<?php echo $username; ?>" placeholder="Username"></div>
            <div><input type="password" id="account_password" value="<?php echo $account_password; ?>" placeholder="Password"></div>
        </div>
        <div class="form-row">
            <div><input type="password" id="account_password_confirm" value="<?php echo $account_password; ?>" placeholder="Confirm Password"></div>
            <div>
                <select id="account_type" name="account_type">
                    <option value="0" <?php if ($account_type == "0") echo 'selected'; ?>>Select Role</option>
                    <option value="System Admin" <?php if ($account_type == "System Admin") echo 'selected'; ?>>System Admin</option>
                    <option value="Inventory Personnel" <?php if ($account_type == "Inventory Personnel") echo 'selected'; ?>>Inventory Personnel</option>
                    <option value="Cashier" <?php if ($account_type == "Cashier") echo 'selected'; ?>>Cashier</option>
                </select>
            </div>
        </div>
        <?php
        if ($accountid) {
            echo '<button class="btn" onclick="update_user(' . $accountid . ');">Update User</button>';
        } else {
            echo '<button class="btn" onclick="create_user();">Create User</button>';
        }
        ?>
        <button class="btn" onclick="ajax_fn('pages/user_management.php','main_content');">Reset</button>
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
    flex-wrap: wrap;
    gap: 20px;
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.user-list,
.create-user {
    flex: 1 1 100%;
}

@media (min-width: 768px) {
    .user-list,
    .create-user {
        flex: 1 1 48%;
    }
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
    font-size: 14px;
}

.form-row {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 10px;
}

.form-row > div {
    flex: 1 1 100%;
}

@media (min-width: 600px) {
    .form-row > div {
        flex: 1 1 48%;
    }
}

.btn {
    padding: 10px 15px;
    background-color: #8B6B4A;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 10px;
    width: 100%;
    font-size: 14px;
}

@media (min-width: 600px) {
    .btn {
        width: auto;
    }
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
    overflow-x: auto;
}

th,
td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
    font-size: 14px;
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
    font-size: 14px;
}

#tmp_user_add {
    overflow-x: auto;
}

</style>