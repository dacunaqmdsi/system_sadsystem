<?php include('../includes/init.php'); ?>

<?php
// Handle Add Subcategory
if (isset($_POST['add_subcategory'])) {
    $subcategory = mysqli_real_escape_string($db_connection, $_POST['subcategory']);
    mysqli_query($db_connection, "INSERT INTO tblsubcategory (subcategory, is_archived) VALUES ('$subcategory', 'No')");
}

// Handle Edit Subcategory
if (isset($_POST['edit_subcategory']) && isset($_POST['subcategoryid'])) {
    $subcategory = mysqli_real_escape_string($db_connection, $_POST['subcategory']);
    $subcategoryid = intval($_POST['subcategoryid']);
    mysqli_query($db_connection, "UPDATE tblsubcategory SET subcategory = '$subcategory' WHERE subcategoryid = $subcategoryid");
}

// Handle Get for Editing
$subcategory = '';
$subcategoryid = '';
if (isset($_GET['subcategoryid'])) {
    $subcategoryid = intval($_GET['subcategoryid']);
    $result = mysqli_query($db_connection, "SELECT subcategory FROM tblsubcategory WHERE subcategoryid = $subcategoryid");
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        $subcategory = $row['subcategory'];
    }
}

// Toggle Archive Status
if (isset($_GET['archive_not'])) {
    $subcategoryid = intval($_GET['archive_not']);

    $result = mysqli_query($db_connection, "SELECT is_archived FROM tblsubcategory WHERE subcategoryid = $subcategoryid");
    if ($row = mysqli_fetch_assoc($result)) {
        $current = strtolower($row['is_archived']) === 'yes' ? 'No' : 'Yes';
        mysqli_query($db_connection, "UPDATE tblsubcategory SET is_archived = '$current' WHERE subcategoryid = $subcategoryid");
    }
}
?>

<div class="main-container">
    <div class="section-title">Sub Category</div>
    <div align="right">
        <input type="text" id="subcategory" value="<?php echo htmlspecialchars($subcategory); ?>" placeholder="Sub Category" />
        <button onclick="add_edit_subcategory(<?php echo $subcategoryid ? $subcategoryid : 'null'; ?>);">
            <?php echo $subcategoryid ? 'Update' : 'Add'; ?>
        </button>
    </div>

    <br>

    <table border="1" width="100%" cellpadding="8" cellspacing="0">
        <tr>
            <th>Sub Category Name</th>
            <th>Is Archived?</th>
            <th colspan="2">Action</th>
        </tr>
        <?php
        $rs = mysqli_query($db_connection, "SELECT subcategoryid, subcategory, is_archived FROM tblsubcategory ORDER BY subcategory ASC");
        while ($rw = mysqli_fetch_assoc($rs)) {
            $archived = $rw['is_archived'] === 'Yes' ? 'Yes' : 'No';
            $toggleText = $archived === 'Yes' ? 'Unarchive' : 'Archive';

            echo '<tr>
                <td>' . htmlspecialchars($rw['subcategory']) . '</td>
                <td>' . $archived . '</td>
                <td><a style="text-decoration:none;" href="javascript:void(0);" onclick="ajax_fn(\'submenu/subcategory.php?subcategoryid=' . $rw['subcategoryid'] . '\',\'tmp_content\');">Edit</a></td>
                <td><a style="text-decoration:none;" href="javascript:void(0);" onclick="ajax_fn(\'submenu/subcategory.php?archive_not=' . $rw['subcategoryid'] . '\',\'tmp_content\');">' . $toggleText . '</a></td>
            </tr>';
        }
        ?>
    </table>
</div>