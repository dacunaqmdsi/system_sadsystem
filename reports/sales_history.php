<?php
include('../includes/init.php');
include('../header.php'); 

$from = mysqli_real_escape_string($db_connection, $_GET['from4']);
$to = mysqli_real_escape_string($db_connection, $_GET['to4']);

$query = "SELECT 
    a.sales_id, a.order_id, a.created_at, a.processed_by, a.payment_method,
    b.id AS detail_id, b.sales_id AS detail_sales_id, b.inventory_id, b.qty, b.puhunan, b.price,
    c.inventory_id AS inv_id, c.product_id, c.product_name
FROM tblsales a
JOIN tblsales_details b ON a.sales_id = b.sales_id
JOIN tblinventory c ON b.inventory_id = c.inventory_id
WHERE DATE(a.created_at) BETWEEN '$from' AND '$to'";

$result = mysqli_query($db_connection, $query);
?>

<h2>Sales History Report</h2>
<p>From: <?php echo htmlspecialchars($from); ?> To: <?php echo htmlspecialchars($to); ?></p>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Sales ID</th>
            <th>Order ID</th>
            <th>Date</th>
            <th>Processed By</th>
            <th>Payment</th>
            <th>Product</th>
            <th>Qty</th>
            <th>Puhunan</th>
            <th>Price</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) : 
        $username = GetValue('select username from tblaccounts where accountid='.$row['processed_by']);    
        ?>
            <tr>
                <td><?php echo $row['sales_id']; ?></td>
                <td><?php echo $row['order_id']; ?></td>
                <td><?php echo $row['created_at']; ?></td>
                <td><?php echo $username; ?></td>
                <td><?php echo $row['payment_method']; ?></td>
                <td><?php echo $row['product_name']; ?></td>
                <td><?php echo $row['qty']; ?></td>
                <td><?php echo $row['puhunan']; ?></td>
                <td><?php echo $row['price']; ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>