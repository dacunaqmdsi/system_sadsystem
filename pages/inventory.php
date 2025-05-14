<?php include('../includes/init.php'); ?>
<?php
if (isset($_POST['add_inventory'])) {
    // Sanitize inputs
    $product_id = mysqli_real_escape_string($db_connection, $_POST['product_id']);
    $product_name = mysqli_real_escape_string($db_connection, $_POST['product_name']);
    $color = mysqli_real_escape_string($db_connection, $_POST['color']);
    $categoryid = $_POST['categoryid'];
    $subcategoryid = $_POST['subcategoryid'];
    $sizesid = $_POST['sizesid'];

    // Get category name
    $category_result = mysqli_query($db_connection, "SELECT category FROM tblcategory WHERE categoryid = $categoryid");
    $category_row = mysqli_fetch_assoc($category_result);
    $category_name = $category_row['category'] ?? '';

    // Get subcategory name
    $subcategory_result = mysqli_query($db_connection, "SELECT subcategory FROM tblsubcategory WHERE subcategoryid = $subcategoryid");
    $subcategory_row = mysqli_fetch_assoc($subcategory_result);
    $subcategory_name = $subcategory_row['subcategory'] ?? '';

    // Get size name
    $size_result = mysqli_query($db_connection, "SELECT size FROM tblsizes WHERE sizesid = $sizesid");
    $size_row = mysqli_fetch_assoc($size_result);
    $size_name = $size_row['size'] ?? '';

    // Safely extract first character
    $category_initial = strtoupper(substr($category_name, 0, 1));
    $subcategory_initial = strtoupper(substr($subcategory_name, 0, 1));
    $size_initial = strtoupper(substr($size_name, 0, 1));

    // Get MAX inventory ID
    $res = mysqli_query($db_connection, "SELECT MAX(inventory_id) AS max_id FROM tblinventory");
    $row = mysqli_fetch_assoc($res);
    $max_id = $row['max_id'] ?? 0;

    // Generate next number, padded with 4 digits
    $next_number = str_pad($max_id + 1, 4, '0', STR_PAD_LEFT);

    // Build the Product ID: format => C-S-S-XXXX (first letters)
    $generated_product_id = $category_initial . '-' . $subcategory_initial . '-' . $size_initial . '-' . $next_number;



    $madefromid = $_POST['madefromid'];
    $cooperativeid = $_POST['cooperativeid'];
    $qty_available = $_POST['qty_available'];
    $reorder_threshold = $_POST['reorder_threshold'];
    $storageid = $_POST['storageid'];
    $cost_price = $_POST['cost_price'];
    $retail_price = $_POST['retail_price'];
    $unitid = $_POST['unitid'];
    $current_stock = $_POST['current_stock'];
    $new_stock = $_POST['new_stock'];
    $total_stock = $_POST['total_stock'];

    // Perform insert
    $query = "INSERT INTO tblinventory (
        product_id, product_name, color, categoryid, subcategoryid, sizesid,
        madefromid, cooperativeid, qty_available, reorder_threshold, storageid,
        cost_price, retail_price, unitid, current_stock, new_stock, total_stock
    ) VALUES (
        '$generated_product_id', '$product_name', '$color', '$categoryid', '$subcategoryid', '$sizesid',
        '$madefromid', '$cooperativeid', '$qty_available', '$reorder_threshold', '$storageid',
        '$cost_price', '$retail_price', '$unitid', '$current_stock', '$new_stock', '$total_stock'
    )";

    if (mysqli_query($db_connection, $query)) {
        Audit($user['accountid'], 'Added inventory', 'Inventory item added successfully');
        echo "<div class='alert alert-success'>Inventory item added successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($db_connection) . "</div>";
    }
}

if (isset($_POST['update_inventory'])) {
    // Sanitize inputs
    $inventory_id_ = mysqli_real_escape_string($db_connection, $_POST['inventory_id']);  // We use inventory_id for the update
    $product_name = mysqli_real_escape_string($db_connection, $_POST['product_name']);
    $color = mysqli_real_escape_string($db_connection, $_POST['color']);
    $categoryid = $_POST['categoryid'];
    $subcategoryid = $_POST['subcategoryid'];
    $sizesid = $_POST['sizesid'];

    // Get category name
    $category_result = mysqli_query($db_connection, "SELECT category FROM tblcategory WHERE categoryid = $categoryid");
    $category_row = mysqli_fetch_assoc($category_result);
    $category_name = $category_row['category'] ?? '';

    // Get subcategory name
    $subcategory_result = mysqli_query($db_connection, "SELECT subcategory FROM tblsubcategory WHERE subcategoryid = $subcategoryid");
    $subcategory_row = mysqli_fetch_assoc($subcategory_result);
    $subcategory_name = $subcategory_row['subcategory'] ?? '';

    // Get size name
    $size_result = mysqli_query($db_connection, "SELECT size FROM tblsizes WHERE sizesid = $sizesid");
    $size_row = mysqli_fetch_assoc($size_result);
    $size_name = $size_row['size'] ?? '';

    // Update the inventory item but leave product_id unchanged
    $madefromid = $_POST['madefromid'];
    $cooperativeid = $_POST['cooperativeid'];
    $qty_available = $_POST['qty_available'];
    $reorder_threshold = $_POST['reorder_threshold'];
    $storageid = $_POST['storageid'];
    $cost_price = $_POST['cost_price'];
    $retail_price = $_POST['retail_price'];
    $unitid = $_POST['unitid'];
    $current_stock = $_POST['current_stock'];
    $new_stock = $_POST['new_stock'];
    $total_stock = $_POST['total_stock'];

    // Perform update
    $update_query = "UPDATE tblinventory SET 
        product_name = '$product_name',
        color = '$color',
        categoryid = '$categoryid',
        subcategoryid = '$subcategoryid',
        sizesid = '$sizesid',
        madefromid = '$madefromid',
        cooperativeid = '$cooperativeid',
        qty_available = '$qty_available',
        reorder_threshold = '$reorder_threshold',
        storageid = '$storageid',
        cost_price = '$cost_price',
        retail_price = '$retail_price',
        unitid = '$unitid',
        current_stock = '$current_stock',
        new_stock = '$new_stock',
        total_stock = '$total_stock'
    WHERE inventory_id = '$inventory_id_'";

    if (mysqli_query($db_connection, $update_query)) {
        Audit($user['accountid'], 'Update inventory', 'Inventory item updated successfully');
        echo "<div class='alert alert-success'>Inventory item updated successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($db_connection) . "</div>";
    }
}
?>


<h2>Inventory Management</h2>

<!-- Inventory List Section -->
<div class="container">
    <div class="section-title">Inventory List</div>
    <div class="inventory-header">
        <input type="text" id="str" placeholder="Search inventory...">
        <button class="btn btn-green" onclick="ajax_fn('pages/inventory_tmp.php?str='+document.getElementById('str').value,'tmp_inventory');">Search</button>
        <button class="btn btn-green" onclick="openCustom('pages/inventory_all',1000,1000);">View All</button>
    </div>
    <div id="tmp_inventory">
        <table>
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Color</th>
                    <th>Category</th>
                    <th>Subcategory</th>
                    <th>Size</th>
                    <th>Made From</th>
                    <th>Cooperative</th>
                    <th>Quantity Available</th>
                    <th>Reorder Threshold</th>
                    <th>Storage Location</th>
                    <th>Cost Price</th>
                    <th>Retail Price</th>
                    <th>Unit</th>
                    <th>Current Stock</th>
                    <th>New Stock</th>
                    <th>Total Stock</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "
                SELECT 
                    i.product_id,
                    i.product_name,
                    i.color,
                    c.category,
                    sc.subcategory,
                    s.size,
                    mf.madefrom,
                    coop.cooperative,
                    i.qty_available,
                    i.reorder_threshold,
                    st.storage,
                    i.cost_price,
                    i.retail_price,
                    u.unit,
                    i.current_stock,
                    i.new_stock,
                    i.total_stock,
                    i.inventory_id
                FROM tblinventory i
                LEFT JOIN tblcategory c ON i.categoryid = c.categoryid
                LEFT JOIN tblsubcategory sc ON i.subcategoryid = sc.subcategoryid
                LEFT JOIN tblsizes s ON i.sizesid = s.sizesid
                LEFT JOIN tblmadefrom mf ON i.madefromid = mf.madefromid
                LEFT JOIN tblcooperative coop ON i.cooperativeid = coop.cooperativeid
                LEFT JOIN tblstorage st ON i.storageid = st.storageid
                LEFT JOIN tblunit u ON i.unitid = u.unitid
                ORDER BY i.product_name ASC LIMIT 0,6
            ";

                $result = mysqli_query($db_connection, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                    <td>" . htmlspecialchars($row['product_id']) . "</td>
                    <td>" . htmlspecialchars($row['product_name']) . "</td>
                    <td>" . htmlspecialchars($row['color']) . "</td>
                    <td>" . htmlspecialchars($row['category']) . "</td>
                    <td>" . htmlspecialchars($row['subcategory']) . "</td>
                    <td>" . htmlspecialchars($row['size']) . "</td>
                    <td>" . htmlspecialchars($row['madefrom']) . "</td>
                    <td>" . htmlspecialchars($row['cooperative']) . "</td>
                    <td>" . htmlspecialchars($row['qty_available']) . "</td>
                    <td>" . htmlspecialchars($row['reorder_threshold']) . "</td>
                    <td>" . htmlspecialchars($row['storage']) . "</td>
                    <td>" . htmlspecialchars($row['cost_price']) . "</td>
                    <td>" . htmlspecialchars($row['retail_price']) . "</td>
                    <td>" . htmlspecialchars($row['unit']) . "</td>
                    <td>" . htmlspecialchars($row['current_stock']) . "</td>
                    <td>" . htmlspecialchars($row['new_stock']) . "</td>
                    <td>" . htmlspecialchars($row['total_stock']) . "</td>
                    <td>";
                    echo '<button onclick="ajax_fn(\'pages/inventory.php?inventory_id=' . $row['inventory_id'] . '\',\'main_content\');">Edit</button>';
                    echo "</td>
                </tr>";
                }
                ?>

            </tbody>
        </table>
    </div>
</div>
<?php
// Database connection assumed to be stored in $db_connection
$product_id = $product_name = $color = $categoryid = $subcategoryid = $sizesid = $madefromid = $cooperativeid = '';
$qty_available = $reorder_threshold = $storageid = $cost_price = $retail_price = $unitid = $current_stock = $new_stock = $total_stock = '';

if (isset($_GET['inventory_id'])) {
    $inventory_id = intval($_GET['inventory_id']);
    $sql = "SELECT * FROM tblinventory WHERE inventory_id = $inventory_id LIMIT 1";
    $result = mysqli_query($db_connection, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        $product_id = $row['product_id'];
        $product_name = $row['product_name'];
        $color = $row['color'];
        $categoryid = $row['categoryid'];
        $subcategoryid = $row['subcategoryid'];
        $sizesid = $row['sizesid'];
        $madefromid = $row['madefromid'];
        $cooperativeid = $row['cooperativeid'];
        $qty_available = $row['qty_available'];
        $reorder_threshold = $row['reorder_threshold'];
        $storageid = $row['storageid'];
        $cost_price = $row['cost_price'];
        $retail_price = $row['retail_price'];
        $unitid = $row['unitid'];
        $current_stock = $row['current_stock'];
        $new_stock = $row['new_stock'];
        $total_stock = $row['total_stock'];
    }
}
?>

<!-- Add Inventory Section -->
<div class="container">
    <div class="section-title">Add New Inventory Item</div>
    <div class="form-row">
        <input value="<?php echo htmlspecialchars($product_id); ?>" disabled type="text" id="product_id" placeholder="Product ID">
        <input value="<?php echo htmlspecialchars($product_name); ?>" type="text" id="product_name" placeholder="Product Name">
        <input value="<?php echo htmlspecialchars($color); ?>" type="text" id="color" placeholder="Color">

        <!-- Category -->
        <select id="categoryid">
            <option value="">Select Category</option>
            <?php
            $res = mysqli_query($db_connection, "SELECT categoryid, category FROM tblcategory WHERE is_archived = 'No' ORDER BY category ASC");
            while ($row = mysqli_fetch_assoc($res)) {
                $selected = ($row['categoryid'] == $categoryid) ? 'selected' : '';
                echo '<option value="' . $row['categoryid'] . '" ' . $selected . '>' . htmlspecialchars($row['category']) . '</option>';
            }
            ?>
        </select>

        <!-- Subcategory -->
        <select id="subcategoryid">
            <option value="">Select Subcategory</option>
            <?php
            $res = mysqli_query($db_connection, "SELECT subcategoryid, subcategory FROM tblsubcategory WHERE is_archived = 'No' ORDER BY subcategory ASC");
            while ($row = mysqli_fetch_assoc($res)) {
                $selected = ($row['subcategoryid'] == $subcategoryid) ? 'selected' : '';
                echo '<option value="' . $row['subcategoryid'] . '" ' . $selected . '>' . htmlspecialchars($row['subcategory']) . '</option>';
            }
            ?>
        </select>

        <!-- Size -->
        <select id="sizesid">
            <option value="">Select Size</option>
            <?php
            $res = mysqli_query($db_connection, "SELECT sizesid, size FROM tblsizes WHERE is_archived = 'No' ORDER BY size ASC");
            while ($row = mysqli_fetch_assoc($res)) {
                $selected = ($row['sizesid'] == $sizesid) ? 'selected' : '';
                echo '<option value="' . $row['sizesid'] . '" ' . $selected . '>' . htmlspecialchars($row['size']) . '</option>';
            }
            ?>
        </select>

        <!-- Made From -->
        <select id="madefromid">
            <option value="">Select Made From</option>
            <?php
            $res = mysqli_query($db_connection, "SELECT madefromid, madefrom FROM tblmadefrom WHERE is_archived = 'No' ORDER BY madefrom ASC");
            while ($row = mysqli_fetch_assoc($res)) {
                $selected = ($row['madefromid'] == $madefromid) ? 'selected' : '';
                echo '<option value="' . $row['madefromid'] . '" ' . $selected . '>' . htmlspecialchars($row['madefrom']) . '</option>';
            }
            ?>
        </select>

        <!-- Cooperative -->
        <select id="cooperativeid">
            <option value="">Select Cooperative</option>
            <?php
            $res = mysqli_query($db_connection, "SELECT cooperativeid, cooperative FROM tblcooperative WHERE is_archived = 'No' ORDER BY cooperative ASC");
            while ($row = mysqli_fetch_assoc($res)) {
                $selected = ($row['cooperativeid'] == $cooperativeid) ? 'selected' : '';
                echo '<option value="' . $row['cooperativeid'] . '" ' . $selected . '>' . htmlspecialchars($row['cooperative']) . '</option>';
            }
            ?>
        </select>

        <input id="qty_available" type="number" value="<?php echo $qty_available; ?>" placeholder="Quantity Available">
        <input id="reorder_threshold" type="number" value="<?php echo $reorder_threshold; ?>" placeholder="Reorder Threshold">

        <!-- Storage -->
        <select id="storageid">
            <option value="">Select Storage Location</option>
            <?php
            $res = mysqli_query($db_connection, "SELECT storageid, storage FROM tblstorage WHERE is_archived = 'No' ORDER BY storage ASC");
            while ($row = mysqli_fetch_assoc($res)) {
                $selected = ($row['storageid'] == $storageid) ? 'selected' : '';
                echo '<option value="' . $row['storageid'] . '" ' . $selected . '>' . htmlspecialchars($row['storage']) . '</option>';
            }
            ?>
        </select>

        <input id="cost_price" type="number" value="<?php echo $cost_price; ?>" placeholder="Cost Price">
        <input id="retail_price" type="number" value="<?php echo $retail_price; ?>" placeholder="Retail Price">

        <!-- Unit -->
        <select id="unitid">
            <option value="">Select Unit</option>
            <?php
            $res = mysqli_query($db_connection, "SELECT unitid, unit FROM tblunit WHERE is_archived = 'No' ORDER BY unit ASC");
            while ($row = mysqli_fetch_assoc($res)) {
                $selected = ($row['unitid'] == $unitid) ? 'selected' : '';
                echo '<option value="' . $row['unitid'] . '" ' . $selected . '>' . htmlspecialchars($row['unit']) . '</option>';
            }
            ?>
        </select>

        <input id="current_stock" type="number" value="<?php echo $current_stock; ?>" placeholder="Current Stock">
        <input id="new_stock" type="number" value="<?php echo $new_stock; ?>" placeholder="New Stock">
        <input id="total_stock" type="number" value="<?php echo $total_stock; ?>" placeholder="Total Stock">
    </div>
    <br>
    <div align="right">
        <?php
        if ($inventory_id != 0) {
            // If $inventory_id is not 0, show the "Update" button
            echo '<button class="btn btn-brown" onclick="update_inventory(' . $inventory_id . ');">Update</button>';
        } else {
            // If $inventory_id is 0 (new inventory), show the "Add" button
            echo '<button class="btn btn-brown" onclick="insert_inventory();">+</button>';
        }
        ?>

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

    .container {
        background-color: white;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .section-title {
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 10px;
    }

    .inventory-header,
    .inventory-form {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
        margin-bottom: 15px;
    }

    input[type="text"],
    select,
    input[type="number"],
    input[type="date"] {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        min-width: 120px;
    }

    .btn {
        padding: 8px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        color: white;
        width: 100px;
    }

    .btn-green {
        background-color: #4CAF50;
    }

    .btn-brown {
        background-color: #8B6B4A;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    .form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 15px;
    }
</style>