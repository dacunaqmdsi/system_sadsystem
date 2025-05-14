<?php include('../includes/init.php'); is_blocked(); ?>

<?php
if (isset($_POST['add_user'])) {
    $user_id = escape_str($db_connection, $_POST['user_id']);
    $last_name = escape_str($db_connection, $_POST['last_name']);
    $first_name = escape_str($db_connection, $_POST['first_name']);
    $middle_name = escape_str($db_connection, $_POST['middle_name']);
    $address = escape_str($db_connection, $_POST['address']);
    $age = escape_str($db_connection, $_POST['age']);
    $email_address = escape_str($db_connection, $_POST['email_address']);
    $contact_number = escape_str($db_connection, $_POST['contact_number']);
    $username = escape_str($db_connection, $_POST['username']);
    $account_password = escape_str($db_connection, $_POST['account_password']);
    $account_type = escape_str($db_connection, $_POST['account_type']);

    $query = "INSERT INTO tblaccounts (
        user_id, last_name, first_name, middle_name, address, age, email_address,
        contact_number, username, account_password, account_type
    ) VALUES (
        '$user_id', '$last_name', '$first_name', '$middle_name', '$address', '$age',
        '$email_address', '$contact_number', '$username', '$account_password', '$account_type'
    )";

    if (mysqli_query($db_connection, $query)) {
        Audit($_SESSION['accountid'], 'Added new user', 'Added new user');
        echo "User successfully added.";
    } else {
        echo "Error: " . mysqli_error($db_connection);
    }
}

if (isset($_POST['edit_user'])) {
    $accountid = escape_str($db_connection, $_POST['accountid']);
    $user_id = escape_str($db_connection, $_POST['user_id']);
    $last_name = escape_str($db_connection, $_POST['last_name']);
    $first_name = escape_str($db_connection, $_POST['first_name']);
    $middle_name = escape_str($db_connection, $_POST['middle_name']);
    $address = escape_str($db_connection, $_POST['address']);
    $age = escape_str($db_connection, $_POST['age']);
    $email_address = escape_str($db_connection, $_POST['email_address']);
    $contact_number = escape_str($db_connection, $_POST['contact_number']);
    $username = escape_str($db_connection, $_POST['username']);
    $account_password = escape_str($db_connection, $_POST['account_password']);
    $account_type = escape_str($db_connection, $_POST['account_type']);

    $query = "UPDATE tblaccounts SET
        user_id = '$user_id',
        last_name = '$last_name',
        first_name = '$first_name',
        middle_name = '$middle_name',
        address = '$address',
        age = '$age',
        email_address = '$email_address',
        contact_number = '$contact_number',
        username = '$username',
        account_password = '$account_password',
        account_type = '$account_type'
        WHERE accountid = '$accountid'";

    if (mysqli_query($db_connection, $query)) {
        Audit($_SESSION['accountid'], 'Update user', 'Update user');
        echo "User successfully updated.";
    } else {
        echo "Error: " . mysqli_error($db_connection);
    }
}
?>

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
        $q = 'SELECT * FROM tblaccounts where (is_blocked=1 OR is_blocked=0) ';
        if (isset($_GET['str'])) {
            $q .= ' AND (
                first_name LIKE \'%' . escape_str($db_connection, $_GET['str']) . '%\'  OR
                last_name LIKE \'%' . escape_str($db_connection, $_GET['str']) . '%\' OR
                middle_name LIKE \'%' . escape_str($db_connection, $_GET['str']) . '%\' OR
                address LIKE \'%' . escape_str($db_connection, $_GET['str']) . '%\' OR
                age LIKE \'%' . escape_str($db_connection, $_GET['str']) . '%\' OR
                email_address LIKE \'%' . escape_str($db_connection, $_GET['str']) . '%\' OR
                contact_number LIKE \'%' . escape_str($db_connection, $_GET['str']) . '%\' 
            )';
        }
        $rs = mysqli_query($db_connection, $q);
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
                            <a style='text-decoration: none; cursor:pointer;' 
                            onclick=\"ajax_fn('pages/user_management_update.php?toggle_block=1&accountid={$row['accountid']}', 'tmp_up{$row['accountid']}');\">
                            $button_label
                            </a>
                        </td>";
            echo '<td>
                            <a style="text-decoration: none;" href="javascript:void(0);" onclick="ajax_fn(\'pages/user_management.php?edit=1&accountid=' . $row['accountid'] . '\',\'main_content\');">Edit</a>
                        </td>';
            echo "</tr>";
        }
        ?>
    </tbody>
</table>