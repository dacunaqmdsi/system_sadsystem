<!-- This will not be printed -->
<div align="center" class="no-print">
    <button onclick="window.print()">Print Receipt</button>
</div>

<?php include('../includes/init.php'); is_blocked(); ?>

<style>
    @media print {
        .no-print {
            display: none !important;
        }
    }
</style>

<?php
$table = mysqli_real_escape_string($db_connection, $_SESSION['tmp_order']);
$order_id = GetValue("SELECT order_id FROM `$table` LIMIT 1");
$date = date("Y-m-d H:i:s");

// Start output
echo "<div style='max-width: 400px; font-family: Arial, sans-serif; margin: auto; border: 1px solid #ccc; padding: 20px;'>";

echo "<h2 style='text-align: center;'>Sales Receipt</h2>";
echo "<p><strong>Order ID:</strong> $order_id</p>";
echo "<p><strong>Date:</strong> $date</p>";
echo "<hr>";

echo "<table width='100%' cellpadding='5' cellspacing='0' style='border-collapse: collapse;'>";
echo "<tr style='border-bottom: 1px solid #ccc;'>
        <th align='left'>Product</th>
        <th align='right'>Qty</th>
        <th align='right'>Price</th>
        <th align='right'>Subtotal</th>
      </tr>";

$total = 0;
$rs = mysqli_query($db_connection, "SELECT * FROM `$table`");
while ($rw = mysqli_fetch_array($rs)) {
    $pname = GetValue("SELECT product_name FROM tblinventory WHERE inventory_id = '{$rw['inventory_id']}'");
    $qty = $rw['qty'];
    $price = $rw['price'];
    $sub = $qty * $price;
    $total += $sub;

    echo "<tr>
            <td>" . htmlspecialchars($pname) . "</td>
            <td align='right'>" . htmlspecialchars($qty) . "</td>
            <td align='right'>" . number_format($price, 2) . "</td>
            <td align='right'>" . number_format($sub, 2) . "</td>
          </tr>";
}

echo "<tr style='border-top: 1px solid #ccc;'>
        <td colspan='3' align='right'><strong>Total:</strong></td>
        <td align='right'><strong>" . number_format($total, 2) . "</strong></td>
      </tr>";
echo "</table>";

echo "<hr><p style='text-align: center;'>Thank you for your purchase!</p>";
echo "</div>";
?>