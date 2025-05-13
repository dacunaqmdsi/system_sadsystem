<?php include('../includes/init.php'); ?>
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
                        echo '<td><a style="text-decoration: none;" href="javascript:void(0);" onclick="ajax_fn(\'pages/user_management.php?edit=1&accountid=' . $row['accountid'] . '\',\'main_content\');">Edit</a></td>';
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php
    if (isset($_GET['edit'])) {
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
        if ($user_id) {
            echo '<button class="btn" onclick="update_user(' . $user_id . ');">Update User</button>';
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