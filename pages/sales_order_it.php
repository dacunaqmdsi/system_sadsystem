<?php include('../includes/init.php');
is_blocked(); ?>
<?php

if (isset($_GET['edit'])) {
    $qty = $_GET['qty_'];
    $id = $_GET['id_x'];

    // Validate values
    if (is_numeric($qty) && is_numeric($id)) {
        $table = $_SESSION['tmp_order'];

        // Validate table name to avoid injection
        if (preg_match('/^[a-zA-Z0-9_]+$/', $table)) {
            $stmt = mysqli_prepare($db_connection, "UPDATE `$table` SET qty = ? WHERE id = ?");
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ii", $qty, $id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            } else {
                // Handle statement preparation error
                echo "Database error.";
            }
        } else {
            echo "Invalid table name.";
        }
    } else {
        echo "Invalid input.";
    }
}


// if (isset($_POST['payment_method'])) {
//     $payment_method = mysqli_real_escape_string($db_connection, $_POST['payment_method']);
//     $rs = mysqli_query($db_connection, 'select order_id from ' . $_SESSION['tmp_order'] . ' ');
//     $rw = mysqli_fetch_array($rs);

//     mysqli_query($db_connection, "INSERT INTO tblsales (order_id, payment_method, processed_by)
//         VALUES ('{$rw['order_id']}', '$payment_method', '{$_SESSION['accountid']}')");

//     $sales_id_ = mysqli_insert_id($db_connection);

//     $rs = mysqli_query($db_connection, 'SELECT * FROM ' . $_SESSION['tmp_order']);
//     while ($rw = mysqli_fetch_array($rs)) {
//         mysqli_query($db_connection, 'insert into tblsales_details set sales_id=\'' . $sales_id_  . '\'
//                     ,inventory_id=\'' . $rw['inventory_id']  . '\'
//                     ,qty=\'' . $rw['qty']   . '\' 
//                      ,puhunan=\'' . $rw['puhunan']   . '\' 
//                        ,price=\'' . $rw['price']   . '\'');
//     }
//     mysqli_query($db_connection, "DELETE FROM `{$_SESSION['tmp_order']}`");
// }

if (isset($_POST['payment_method'])) {
    $payment_method = mysqli_real_escape_string($db_connection, $_POST['payment_method']);
    $rs = mysqli_query($db_connection, 'SELECT order_id FROM ' . $_SESSION['tmp_order']);
    $rw = mysqli_fetch_array($rs);

    mysqli_query($db_connection, "INSERT INTO tblsales (order_id, payment_method, processed_by)
        VALUES ('{$rw['order_id']}', '$payment_method', '{$_SESSION['accountid']}')");

    $sales_id_ = mysqli_insert_id($db_connection);

    // Audit log for inserting main sales record
    Audit($_SESSION['accountid'], 'Processed Sales', 'Inserted main sales record - Sales ID: ' . $sales_id_);

    $rs = mysqli_query($db_connection, 'SELECT * FROM ' . $_SESSION['tmp_order']);
    $has_error = false;

    while ($rw = mysqli_fetch_array($rs)) {
        $inventory_id = $rw['inventory_id'];
        $qty_ordered = $rw['qty'];

        // Get current stock
        $stock_result = mysqli_query($db_connection, "SELECT current_stock FROM tblinventory WHERE inventory_id = '$inventory_id'");
        $stock_row = mysqli_fetch_assoc($stock_result);
        $current_stock = $stock_row['current_stock'];

        if ($qty_ordered > $current_stock) {
            echo "<div class='alert alert-danger'>Error: Quantity ordered ({$qty_ordered}) exceeds available stock ({$current_stock}) for item ID {$inventory_id}.</div>";
            $has_error = true;
            break;
        }
    }

    if (!$has_error) {
        mysqli_data_seek($rs, 0); // Reset result pointer

        while ($rw = mysqli_fetch_array($rs)) {
            $inventory_id = $rw['inventory_id'];
            $qty_ordered = $rw['qty'];

            // Insert into sales details
            mysqli_query($db_connection, "INSERT INTO tblsales_details SET 
                sales_id = '$sales_id_',
                inventory_id = '$inventory_id',
                qty = '$qty_ordered', 
                puhunan = '{$rw['puhunan']}', 
                price = '{$rw['price']}'");

            // Audit log for each item
            Audit($_SESSION['accountid'], "Process Sales: Inserted sales detail for Inventory ID: $inventory_id, Qty: $qty_ordered", "Inserted sales detail for Inventory ID: $inventory_id, Qty: $qty_ordered");

            // Get current stock, reorder threshold, and product details
            $inv_result = mysqli_query($db_connection, "
                SELECT current_stock, reorder_threshold, product_id, product_name 
                FROM tblinventory 
                WHERE inventory_id = '$inventory_id'");
            $inv_row = mysqli_fetch_assoc($inv_result);

            $new_stock = $inv_row['current_stock'] - $qty_ordered;
            $reorder_threshold = $inv_row['reorder_threshold'];
            $product_id = $inv_row['product_id'];
            $product_name = $inv_row['product_name'];

            // Update inventory
            mysqli_query($db_connection, "UPDATE tblinventory 
                SET current_stock = current_stock - $qty_ordered,
                    current_stock_date = NOW() 
                WHERE inventory_id = '$inventory_id'");

            // Audit log for inventory update
            Audit($_SESSION['accountid'], 'Processed Sales', "Updated stock for Inventory ID: $inventory_id, Deducted: $qty_ordered");

            // Check for low stock
            if ($new_stock <= $reorder_threshold) {
                Audit($_SESSION['accountid'], 'Low Stock Warning', 
                    "Low stock on product (Product ID: $product_id, Product Name: $product_name, Inventory ID: $inventory_id). Remaining stock: $new_stock");
            }
        }

        // Clear temporary order table
        mysqli_query($db_connection, "DELETE FROM {$_SESSION['tmp_order']}");
        Audit($_SESSION['accountid'], 'Processed Sales', 'Cleared temporary order table: ' . $_SESSION['tmp_order']);

        echo "<div class='alert alert-success'>Order processed successfully.</div>";
    }
}














$table = mysqli_real_escape_string($db_connection, $_SESSION['tmp_order']);

if (isset($_GET['del']) && isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize the id
    mysqli_query($db_connection, "DELETE FROM `$table` WHERE id = $id") or die(mysqli_error($db_connection));
}

// After delete or update/insert, always re-render the table:
$order_id = isset($_POST['order_id']) ? $_POST['order_id'] : '';

if (isset($_POST['inventory_id_edit'])) {
    $inventory_id_edit = $_POST['inventory_id_edit'];
    $order_id = $_POST['order_id'];
    $qty = $_POST['qty'];
    $puhunan = $_POST['puhunan'];
    $effective_price = $_POST['effective_price'];
    $product_name = $_POST['product_name'];

    $check_sql = "SELECT * FROM `$table` WHERE inventory_id = '$inventory_id_edit'";
    $result = mysqli_query($db_connection, $check_sql);

    if (mysqli_num_rows($result) > 0) {
        $update_sql = "UPDATE `$table` 
                       SET qty = qty + '$qty', price = '$effective_price'
                       WHERE inventory_id = '$inventory_id_edit'";
        mysqli_query($db_connection, $update_sql) or die(mysqli_error($db_connection));
    } else {
        $insert_sql = "INSERT INTO `$table` (inventory_id, qty, puhunan, price, order_id) 
                       VALUES ('$inventory_id_edit', '$qty', '$puhunan', '$effective_price', '$order_id')";
        mysqli_query($db_connection, $insert_sql) or die(mysqli_error($db_connection));
    }
}

// Render the table
echo '
<table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
    <thead style="background-color: #f2f2f2;">
        <tr>
            <th colspan="5" style="text-align: left;">Order ID: ' . htmlspecialchars($order_id) . '</th>
        </tr>
        <tr>
            <th>Product Name</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Subtotal</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>';

$rs = mysqli_query($db_connection, "SELECT * FROM `$table`");
$tot = 0;
while ($rw = mysqli_fetch_array($rs)) {
    $pname = GetValue('SELECT product_name FROM tblinventory WHERE inventory_id=' . $rw['inventory_id']);
    $sub = $rw['qty'] * $rw['price'];
    $tot += $sub;

    echo '<tr>
            <td>' . htmlspecialchars($pname) . '</td>
            <td><span id="tmp_p' . $rw['id'] . '">' . htmlspecialchars($rw['qty']) . '</span></td>
            <td style="text-align:right;">' . number_format((float)$rw['price'], 2) . '</td>
            <td   style="text-align:right;">' . number_format((float)$sub, 2) . '</td>
            <td>
<button class="icon-btn" onclick="ajax_fn(\'pages/sales_order_it_edit?qty=' . $rw['qty'] . '&id=' . $rw['id'] . '\', \'tmp_p' . $rw['id'] . '\')" title="Edit">
    <i class="fas fa-edit"></i>
</button>
<button class="icon-btn delete-btn" onclick="ajax_fn(\'pages/sales_order_it.php?del&id=' . $rw['id'] . '\',\'orderItems\')" title="Delete">
    <i class="fas fa-trash"></i>
</button>

        </tr>';
}
echo '
        <tr>
        <td></td>
        <td></td>
        <td></td>
        <td   style="text-align:right;"><b>' . number_format((float)$tot, 2) . '</b></td>
        <td></td>
        </tr>
        ';
echo '</tbody>
</table>';
?>

<div class="receipt-summary">
    <p><strong>Total Amount: ₱<span id="totalAmount"><?php echo number_format((float)$tot, 2); ?></span></strong></p>

    <label>Payment Method</label>
    <select id="payment_method">
        <option value="">Select Payment Method</option>
        <option value="Cash">Cash</option>
        <option value="GCash">GCash</option>
        <option value="Credit">Credit</option>
    </select>

    <div class="button-group">
        <button class="btn green" onclick="openCustom('pages/sales_receipt',700,700)">Print Receipt</button>
        <button class="btn green" onclick="saveOrder()">Save Order</button>
    </div>
</div>