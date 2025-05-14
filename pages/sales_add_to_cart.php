<?php include('../includes/init.php'); is_blocked(); ?>
<?php
if (isset($_GET['inventory_id'])) {
    $inventory_id = $_GET['inventory_id'];
}

if (isset($_GET['effective_price'])) {
    $effective_price = $_GET['effective_price'];
}


// Get the max sales_id and add 1 for the new order
$result = mysqli_query($db_connection, "SELECT MAX(sales_id) AS max_id FROM tblsales");
$row = mysqli_fetch_assoc($result);
$next_id = $row['max_id'] + 1;

// Format as ORD-0001
$orderid = 'ORD-' . str_pad($next_id, 4, '0', STR_PAD_LEFT);

$product_id = GetValue('select product_id from tblinventory where inventory_id=' . $inventory_id);
$product_name = GetValue('select product_name from tblinventory where inventory_id=' . $inventory_id);
$categoryid = GetValue('select categoryid from tblinventory where inventory_id=' . $inventory_id);
$category = GetValue('select category from tblcategory where categoryid=' . $categoryid);

$subcategoryid = GetValue('select subcategoryid from tblinventory where inventory_id=' . $inventory_id);
$subcategory = GetValue('select subcategory from tblsubcategory where subcategoryid=' . $subcategoryid);

$sizesid = GetValue('select sizesid from tblinventory where inventory_id=' . $inventory_id);
$size = GetValue('select size from tblsizes where sizesid=' . $sizesid);

$unitid = GetValue('select unitid from tblinventory where inventory_id=' . $inventory_id);
$unit = GetValue('select unit from tblunit where unitid=' . $unitid);
$puhunan = GetValue('select cost_price from tblinventory where inventory_id=' . $inventory_id);

?>

<h3>Order Details</h3>
<p>Order ID: <span id="currentOrderId"><?php echo $orderid; ?></span></p>
<input type="text" hidden id="order_id" value="<?php echo $orderid; ?>" />
<input type="text" hidden id="puhunan" value="<?php echo $puhunan; ?>" />
<input type="text" hidden id="product_name" value="<?php echo $product_name; ?>" />
<input type="text" hidden id="effective_price" value="<?php echo $effective_price; ?>" />
<div class="form-group">
    <label>Item Code</label>
    <input type="text" id="product_id" disabled value="<?php echo $product_id; ?>" />

    <label>Category</label>
    <input type="text" id="categoryid" disabled value="<?php echo $category; ?>" />

    <label>Subcategory</label>
    <input type="text" id="subcategoryid" disabled value="<?php echo $subcategory; ?>" />

    <label>Size</label>
    <input type="text" id="sizesid" disabled value="<?php echo $size; ?>" />

    <label>Unit</label>
    <input type="text" id="unitid" disabled value="<?php echo $unit; ?>" />

    <label>Quantity</label>
    <input type="number" id="qty" />

    <button class="btn brown" onclick="order_it(<?php echo $inventory_id; ?>)">Add to Order</button>
</div>