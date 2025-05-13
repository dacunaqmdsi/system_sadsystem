<?php include('../includes/init.php'); ?>

<?php
// Add Size
if (isset($_POST['add_size'])) {
    $size = mysqli_real_escape_string($db_connection, $_POST['size']);
    mysqli_query($db_connection, "INSERT INTO tblsizes (size, is_archived) VALUES ('$size', 'No')");
    Audit($user['accountid'], 'Added size', 'Added size');
}

// Edit Size
if (isset($_POST['edit_size']) && isset($_POST['sizesid'])) {
    $size = mysqli_real_escape_string($db_connection, $_POST['size']);
    $sizesid = intval($_POST['sizesid']);
    mysqli_query($db_connection, "UPDATE tblsizes SET size = '$size' WHERE sizesid = $sizesid");
    Audit($user['accountid'], 'Updated size', 'Updated size');
}

// Load for Editing
$size = '';
$sizesid = '';
if (isset($_GET['sizesid'])) {
    $sizesid = intval($_GET['sizesid']);
    $result = mysqli_query($db_connection, "SELECT size FROM tblsizes WHERE sizesid = $sizesid");
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        $size = $row['size'];
    }
}

// Toggle Archive
if (isset($_GET['archive_toggle'])) {
    $sizesid = intval($_GET['archive_toggle']);
    $result = mysqli_query($db_connection, "SELECT is_archived FROM tblsizes WHERE sizesid = $sizesid");
    if ($row = mysqli_fetch_assoc($result)) {
        $new_status = strtolower($row['is_archived']) === 'yes' ? 'No' : 'Yes';
        mysqli_query($db_connection, "UPDATE tblsizes SET is_archived = '$new_status' WHERE sizesid = $sizesid");
    }
}
?>

<div class="main-container">
    <div class="section-title">Sizes</div>
    <div align="right">
        <input type="text" id="size" value="<?php echo htmlspecialchars($size); ?>" placeholder="Size" />
        <button onclick="add_edit_size(<?php echo $sizesid ? $sizesid : 'null'; ?>);">
            <?php echo $sizesid ? 'Update' : 'Add'; ?>
        </button>
    </div>

    <br>

    <table border="1" width="100%" cellpadding="8" cellspacing="0">
        <tr>
            <th>Size</th>
            <th>Is Archived?</th>
            <th colspan="2">Action</th>
        </tr>
        <?php
        $rs = mysqli_query($db_connection, "SELECT sizesid, size, is_archived FROM tblsizes ORDER BY size ASC");
        while ($rw = mysqli_fetch_assoc($rs)) {
            $archived = $rw['is_archived'] === 'Yes' ? 'Yes' : 'No';
            $toggleText = $archived === 'Yes' ? 'Unarchive' : 'Archive';

            echo '<tr>
                <td>' . htmlspecialchars($rw['size']) . '</td>
                <td>' . $archived . '</td>
                <td><a style="text-decoration:none;" href="javascript:void(0);" onclick="ajax_fn(\'submenu/sizes.php?sizesid=' . $rw['sizesid'] . '\',\'tmp_content\');">Edit</a></td>
                <td><a style="text-decoration:none;" href="javascript:void(0);" onclick="ajax_fn(\'submenu/sizes.php?archive_toggle=' . $rw['sizesid'] . '\',\'tmp_content\');">' . $toggleText . '</a></td>
            </tr>';
        }
        ?>
    </table>
</div>