<?php include('../includes/init.php'); ?>

<?php
// Handle Add Unit
if (isset($_POST['add_unit'])) {
    $unit = mysqli_real_escape_string($db_connection, $_POST['unit']);
    mysqli_query($db_connection, "INSERT INTO tblunit (unit, is_archived) VALUES ('$unit', 'No')");
}

// Handle Edit Unit
if (isset($_POST['edit_unit']) && isset($_POST['unitid'])) {
    $unit = mysqli_real_escape_string($db_connection, $_POST['unit']);
    $unitid = intval($_POST['unitid']);
    mysqli_query($db_connection, "UPDATE tblunit SET unit = '$unit' WHERE unitid = $unitid");
}

// Handle Get for Editing
$unit = '';
$unitid = '';
if (isset($_GET['unitid'])) {
    $unitid = intval($_GET['unitid']);
    $result = mysqli_query($db_connection, "SELECT unit FROM tblunit WHERE unitid = $unitid");
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        $unit = $row['unit'];
    }
}

// Toggle Archive Status
if (isset($_GET['archive_not'])) {
    $unitid = intval($_GET['archive_not']);
    $result = mysqli_query($db_connection, "SELECT is_archived FROM tblunit WHERE unitid = $unitid");
    if ($row = mysqli_fetch_assoc($result)) {
        $current = strtolower($row['is_archived']) === 'yes' ? 'No' : 'Yes';
        mysqli_query($db_connection, "UPDATE tblunit SET is_archived = '$current' WHERE unitid = $unitid");
    }
}
?>

<div class="main-container">
    <div class="section-title">Unit</div>
    <div align="right">
        <input type="text" id="unit" value="<?php echo htmlspecialchars($unit); ?>" placeholder="Unit" />
        <button onclick="add_edit_unit(<?php echo $unitid ? $unitid : 'null'; ?>);">
            <?php echo $unitid ? 'Update' : 'Add'; ?>
        </button>
    </div>

    <br>

    <table border="1" width="100%" cellpadding="8" cellspacing="0">
        <tr>
            <th>Unit Name</th>
            <th>Is Archived?</th>
            <th colspan="2">Action</th>
        </tr>
        <?php
        $rs = mysqli_query($db_connection, "SELECT unitid, unit, is_archived FROM tblunit ORDER BY unit ASC");
        while ($rw = mysqli_fetch_assoc($rs)) {
            $archived = $rw['is_archived'] === 'Yes' ? 'Yes' : 'No';
            $toggleText = $archived === 'Yes' ? 'Unarchive' : 'Archive';

            echo '<tr>
                <td>' . htmlspecialchars($rw['unit']) . '</td>
                <td>' . $archived . '</td>
                <td><a style="text-decoration:none;" href="javascript:void(0);" onclick="ajax_fn(\'submenu/unit.php?unitid=' . $rw['unitid'] . '\',\'tmp_content\');">Edit</a></td>
                <td><a style="text-decoration:none;" href="javascript:void(0);" onclick="ajax_fn(\'submenu/unit.php?archive_not=' . $rw['unitid'] . '\',\'tmp_content\');">' . $toggleText . '</a></td>
            </tr>';
        }
        ?>
    </table>
</div>