<?php include('../includes/init.php'); ?>

<?php
// Handle Add Storage
if (isset($_POST['add_storage'])) {
    $storage = mysqli_real_escape_string($db_connection, $_POST['storage']);
    mysqli_query($db_connection, "INSERT INTO tblstorage (storage, is_archived) VALUES ('$storage', 'No')");
    Audit($user['accountid'], 'Added storage', 'Added storage');
}

// Handle Edit Storage
if (isset($_POST['edit_storage']) && isset($_POST['storageid'])) {
    $storage = mysqli_real_escape_string($db_connection, $_POST['storage']);
    $storageid = intval($_POST['storageid']);
    mysqli_query($db_connection, "UPDATE tblstorage SET storage = '$storage' WHERE storageid = $storageid");
    Audit($user['accountid'], 'Updated storage', 'Updated storage');
}

// Handle Get for Editing
$storage = '';
$storageid = '';
if (isset($_GET['storageid'])) {
    $storageid = intval($_GET['storageid']);
    $result = mysqli_query($db_connection, "SELECT storage FROM tblstorage WHERE storageid = $storageid");
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        $storage = $row['storage'];
    }
}

// Toggle Archive Status
if (isset($_GET['archive_not'])) {
    $storageid = intval($_GET['archive_not']);
    $result = mysqli_query($db_connection, "SELECT is_archived FROM tblstorage WHERE storageid = $storageid");
    if ($row = mysqli_fetch_assoc($result)) {
        $current = strtolower($row['is_archived']) === 'yes' ? 'No' : 'Yes';
        mysqli_query($db_connection, "UPDATE tblstorage SET is_archived = '$current' WHERE storageid = $storageid");
    }
}
?>

<div class="main-container">
    <div class="section-title">Storage</div>
    <div align="right">
        <input type="text" id="storage" value="<?php echo htmlspecialchars($storage); ?>" placeholder="Storage" />
        <button onclick="add_edit_storage(<?php echo $storageid ? $storageid : 'null'; ?>);">
            <?php echo $storageid ? 'Update' : 'Add'; ?>
        </button>
    </div>

    <br>

    <table border="1" width="100%" cellpadding="8" cellspacing="0">
        <tr>
            <th>Storage Name</th>
            <th>Is Archived?</th>
            <th colspan="2">Action</th>
        </tr>
        <?php
        $rs = mysqli_query($db_connection, "SELECT storageid, storage, is_archived FROM tblstorage ORDER BY storage ASC");
        while ($rw = mysqli_fetch_assoc($rs)) {
            $archived = $rw['is_archived'] === 'Yes' ? 'Yes' : 'No';
            $toggleText = $archived === 'Yes' ? 'Unarchive' : 'Archive';

            echo '<tr>
                <td>' . htmlspecialchars($rw['storage']) . '</td>
                <td>' . $archived . '</td>
                <td><a style="text-decoration:none;" href="javascript:void(0);" onclick="ajax_fn(\'submenu/storage.php?storageid=' . $rw['storageid'] . '\',\'tmp_content\');">Edit</a></td>
                <td><a style="text-decoration:none;" href="javascript:void(0);" onclick="ajax_fn(\'submenu/storage.php?archive_not=' . $rw['storageid'] . '\',\'tmp_content\');">' . $toggleText . '</a></td>
            </tr>';
        }
        ?>
    </table>
</div>