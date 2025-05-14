<?php include('../includes/init.php'); is_blocked(); ?>

<?php
echo '
<table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <thead style="background-color: #f2f2f2;">
            <tr>
                <th colspan="5" style="text-align: left;">Order ID: ' . htmlspecialchars($_POST['order_id']) . '</th>
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
$rs = mysqli_query($db_connection, ' select * from ' . $_SESSION['tmp_order'] . ' ');
while ($rw = mysqli_fetch_array($rs)) {
    $pname = GetValue('select product_name from tblinventory where inventory_id=' . $rw['inventory_id']);
    $sub = $rw['qty'] * $rw['price'];
    $tot += $sub;

    echo ' <tr>
                                        <td>' . htmlspecialchars($pname) . '</td>
                                        <td><span id="tmp_p">' . htmlspecialchars($rw['qty']) . '</span></td>
                                        <td>' . number_format((float)$rw['price'], 2) . '</td>
                                        <td>' . number_format((float) $sub, 2) . '</td>
                                        <td>
                                           <button onclick="ajax_fn(\'pages/sales_order_it_edit?id=' . $rw['id'] . '\', \'tmp_p\');">Edit</button>
                                        <button onclick="del(' . $rw['id'] . ', ' . $rw['$order_id'] . ');">Delete</button></td>
                                    </tr>';
}

echo '</tbody>
    </table>
';
?>
