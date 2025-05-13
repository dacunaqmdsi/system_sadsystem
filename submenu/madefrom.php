<?php include('../includes/init.php');

// Add
if (isset($_POST['add_madefrom'])) {
    $madefrom = mysqli_real_escape_string($db_connection, $_POST['madefrom']);
    mysqli_query($db_connection, "INSERT INTO tblmadefrom (madefrom, is_archived) VALUES ('$madefrom', 'No')");
}

// Edit
if (isset($_POST['edit_madefrom']) && isset($_POST['madefromid'])) {
    $madefrom = mysqli_real_escape_string($db_connection, $_POST['madefrom']);
    $madefromid = intval($_POST['madefromid']);
    mysqli_query($db_connection, "UPDATE tblmadefrom SET madefrom = '$madefrom' WHERE madefromid = $madefromid");
}

// Load data for edit
$madefrom = '';
$madefromid = '';
if (isset($_GET['madefromid'])) {
    $madefromid = intval($_GET['madefromid']);
    $result = mysqli_query($db_connection, "SELECT madefrom FROM tblmadefrom WHERE madefromid = $madefromid");
    if ($row = mysqli_fetch_assoc($result)) {
        $madefrom = $row['madefrom'];
    }
}

// Archive/Unarchive
if (isset($_GET['archive_not'])) {
    $madefromid = intval($_GET['archive_not']);
    $result = mysqli_query($db_connection, "SELECT is_archived FROM tblmadefrom WHERE madefromid = $madefromid");
    if ($row = mysqli_fetch_assoc($result)) {
        $new_status = strtolower($row['is_archived']) === 'yes' ? 'No' : 'Yes';
        mysqli_query($db_connection, "UPDATE tblmadefrom SET is_archived = '$new_status' WHERE madefromid = $madefromid");
    }
}
?>

<div class="main-container">
    <div class="section-title">Made From</div>
    <div align="right">
        <input type="text" id="madefrom" value="<?php echo htmlspecialchars($madefrom); ?>" placeholder="Made From" />
        <button onclick="add_edit_madefrom(<?php echo $madefromid ? $madefromid : 'null'; ?>);">
            <?php echo $madefromid ? 'Update' : 'Add'; ?>
        </button>
    </div>

    <br>

    <table border="1" width="100%" cellpadding="8" cellspacing="0">
        <tr>
            <th>Made From</th>
            <th>Is Archived?</th>
            <th colspan="2">Action</th>
        </tr>
        <?php
        $rs = mysqli_query($db_connection, "SELECT madefromid, madefrom, is_archived FROM tblmadefrom ORDER BY madefrom ASC");
        while ($rw = mysqli_fetch_assoc($rs)) {
            $archived = $rw['is_archived'] === 'Yes' ? 'Yes' : 'No';
            $toggleText = $archived === 'Yes' ? 'Unarchive' : 'Archive';

            echo '<tr>
                <td>' . htmlspecialchars($rw['madefrom']) . '</td>
                <td>' . $archived . '</td>
                <td><a style="text-decoration:none;" href="javascript:void(0);" onclick="ajax_fn(\'submenu/madefrom.php?madefromid=' . $rw['madefromid'] . '\',\'tmp_content\');">Edit</a></td>
                <td><a style="text-decoration:none;" href="javascript:void(0);" onclick="ajax_fn(\'submenu/madefrom.php?archive_not=' . $rw['madefromid'] . '\',\'tmp_content\');">' . $toggleText . '</a></td>
            </tr>';
        }
        ?>
    </table>
</div>