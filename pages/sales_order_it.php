<?php include('../includes/init.php'); is_blocked(); ?>
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


if (isset($_POST['payment_method'])) {
    $payment_method = mysqli_real_escape_string($db_connection, $_POST['payment_method']);
    $rs = mysqli_query($db_connection, 'select order_id from ' . $_SESSION['tmp_order'] . ' ');
    $rw = mysqli_fetch_array($rs);

    mysqli_query($db_connection, "INSERT INTO tblsales (order_id, payment_method, processed_by)
        VALUES ('{$rw['order_id']}', '$payment_method', '{$_SESSION['accountid']}')");

    $sales_id_ = mysqli_insert_id($db_connection);

    $rs = mysqli_query($db_connection, 'SELECT * FROM ' . $_SESSION['tmp_order']);
    while ($rw = mysqli_fetch_array($rs)) {
        mysqli_query($db_connection, 'insert into tblsales_details set sales_id=\'' . $sales_id_  . '\'
                    ,inventory_id=\'' . $rw['inventory_id']  . '\'
                    ,qty=\'' . $rw['qty']   . '\' 
                     ,puhunan=\'' . $rw['puhunan']   . '\' 
                       ,price=\'' . $rw['price']   . '\'');
    }
    mysqli_query($db_connection, "DELETE FROM `{$_SESSION['tmp_order']}`");
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
             <button onclick="ajax_fn(\'pages/sales_order_it_edit?qty=' . $rw['qty'] . '&id=' . $rw['id'] . '\', \'tmp_p'.$rw['id'].'\');">Edit</button>
            <button onclick="ajax_fn(\'pages/sales_order_it.php?del&id=' . $rw['id'] . '\',\'orderItems\');">Delete</button></td>
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