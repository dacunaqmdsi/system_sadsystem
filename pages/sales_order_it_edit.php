<?php include('../includes/init.php'); ?>
<?php
if (isset($_GET['qty'])) {
    $qty = $_GET['qty'];
    $id = $_GET['id'];
?>
    <input type="text" id="qty_" value="<?php echo htmlspecialchars($qty); ?>" />
    <button onclick="ajax_fn('pages/sales_order_it.php?edit&id_x=<?php echo $id; ?>&qty_=' + document.getElementById('qty_').value, 'orderItems');">Save</button>
<?php
}
?>