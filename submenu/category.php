<?php include('../includes/init.php'); ?>

<?php
// Handle Add Category
if (isset($_POST['add_category'])) {
    $category = mysqli_real_escape_string($db_connection, $_POST['category']);
    mysqli_query($db_connection, "INSERT INTO tblcategory (category, is_archived) VALUES ('$category', 'No')");
}

// Handle Edit Category
if (isset($_POST['edit_category']) && isset($_POST['categoryid'])) {
    $category = mysqli_real_escape_string($db_connection, $_POST['category']);
    $categoryid = intval($_POST['categoryid']);
    mysqli_query($db_connection, "UPDATE tblcategory SET category = '$category' WHERE categoryid = $categoryid");
}

// Handle Get for Editing
$category = '';
$categoryid = '';
if (isset($_GET['categoryid'])) {
    $categoryid = intval($_GET['categoryid']);
    $result = mysqli_query($db_connection, "SELECT category FROM tblcategory WHERE categoryid = $categoryid");
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        $category = $row['category'];
    }
}

// Toggle Archive Status
if (isset($_GET['archive_not'])) {
    $categoryids = intval($_GET['archive_not']);

    // Get current archive status
    $result = mysqli_query($db_connection, "SELECT is_archived FROM tblcategory WHERE categoryid = $categoryids");
    if ($row = mysqli_fetch_assoc($result)) {
        $current = strtolower($row['is_archived']) === 'yes' ? 'No' : 'Yes';
        mysqli_query($db_connection, "UPDATE tblcategory SET is_archived = '$current' WHERE categoryid = $categoryids");
    }
}
?>

<div class="main-container">
    <div class="section-title">Category</div>
    <div align="right">
        <input type="text" id="category" value="<?php echo htmlspecialchars($category); ?>" placeholder="Category" />
        <button onclick="add_edit_category(<?php echo $categoryid ? $categoryid : 'null'; ?>);">
            <?php echo $categoryid ? 'Update' : 'Add'; ?>
        </button>
    </div>

    <br>

    <table border="1" width="100%" cellpadding="8" cellspacing="0">
        <tr>
            <th>Category Name</th>
            <th>Is Archived?</th>
            <th colspan="2">Action</th>
        </tr>
        <?php
        $rs = mysqli_query($db_connection, "SELECT categoryid, category, is_archived FROM tblcategory ORDER BY category ASC");
        while ($rw = mysqli_fetch_assoc($rs)) {
            $archived = $rw['is_archived'] === 'Yes' ? 'Yes' : 'No';
            $toggleText = $archived === 'Yes' ? 'Unarchive' : 'Archive';

            echo '<tr>
                <td>' . htmlspecialchars($rw['category']) . '</td>
                <td>' . $archived . '</td>
                <td><a style="text-decoration:none;" href="javascript:void(0);" onclick="ajax_fn(\'submenu/category.php?categoryid=' . $rw['categoryid'] . '\',\'tmp_content\');">Edit</a></td>
                <td><a style="text-decoration:none;" href="javascript:void(0);" onclick="ajax_fn(\'submenu/category.php?archive_not=' . $rw['categoryid'] . '\',\'tmp_content\');">' . $toggleText . '</a></td>
            </tr>';
        }
        ?>
    </table>
</div>