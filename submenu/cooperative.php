<?php include('../includes/init.php'); ?>

<?php
// Handle Add
if (isset($_POST['add_cooperative'])) {
    $cooperative = mysqli_real_escape_string($db_connection, $_POST['cooperative']);
    mysqli_query($db_connection, "INSERT INTO tblcooperative (cooperative, is_archived) VALUES ('$cooperative', 'No')");
    Audit($user['accountid'], 'Added cooperative', 'Added cooperative');
}

// Handle Edit
if (isset($_POST['edit_cooperative']) && isset($_POST['cooperativeid'])) {
    $cooperative = mysqli_real_escape_string($db_connection, $_POST['cooperative']);
    $cooperativeid = intval($_POST['cooperativeid']);
    mysqli_query($db_connection, "UPDATE tblcooperative SET cooperative = '$cooperative' WHERE cooperativeid = $cooperativeid");
    Audit($user['accountid'], 'Updated cooperative', 'Updated cooperative');
}

// Handle Get for Editing
$cooperative = '';
$cooperativeid = '';
if (isset($_GET['cooperativeid'])) {
    $cooperativeid = intval($_GET['cooperativeid']);
    $result = mysqli_query($db_connection, "SELECT cooperative FROM tblcooperative WHERE cooperativeid = $cooperativeid");
    if ($row = mysqli_fetch_assoc($result)) {
        $cooperative = $row['cooperative'];
    }
}

// Toggle Archive
if (isset($_GET['archive_not'])) {
    $cooperativeid = intval($_GET['archive_not']);
    $result = mysqli_query($db_connection, "SELECT is_archived FROM tblcooperative WHERE cooperativeid = $cooperativeid");
    if ($row = mysqli_fetch_assoc($result)) {
        $newStatus = strtolower($row['is_archived']) === 'yes' ? 'No' : 'Yes';
        mysqli_query($db_connection, "UPDATE tblcooperative SET is_archived = '$newStatus' WHERE cooperativeid = $cooperativeid");
    }
}
?>

<div class="main-container">
    <div class="section-title">Cooperative</div>
    <div align="right">
        <input type="text" id="cooperative" value="<?php echo htmlspecialchars($cooperative); ?>" placeholder="Cooperative" />
        <button onclick="add_edit_cooperative(<?php echo $cooperativeid ? $cooperativeid : 'null'; ?>);">
            <?php echo $cooperativeid ? 'Update' : 'Add'; ?>
        </button>
    </div>

    <br>

    <table border="1" width="100%" cellpadding="8" cellspacing="0">
        <tr>
            <th>Cooperative Name</th>
            <th>Is Archived?</th>
            <th colspan="2">Action</th>
        </tr>
        <?php
        $rs = mysqli_query($db_connection, "SELECT cooperativeid, cooperative, is_archived FROM tblcooperative ORDER BY cooperative ASC");
        while ($rw = mysqli_fetch_assoc($rs)) {
            $archived = $rw['is_archived'] === 'Yes' ? 'Yes' : 'No';
            $toggleText = $archived === 'Yes' ? 'Unarchive' : 'Archive';

            echo '<tr>
                <td>' . htmlspecialchars($rw['cooperative']) . '</td>
                <td>' . $archived . '</td>
                <td><a style="text-decoration:none;" href="javascript:void(0);" onclick="ajax_fn(\'submenu/cooperative.php?cooperativeid=' . $rw['cooperativeid'] . '\',\'tmp_content\');">Edit</a></td>
                <td><a style="text-decoration:none;" href="javascript:void(0);" onclick="ajax_fn(\'submenu/cooperative.php?archive_not=' . $rw['cooperativeid'] . '\',\'tmp_content\');">' . $toggleText . '</a></td>
            </tr>';
        }
        ?>
    </table>
</div>