<?php include('../includes/init.php'); ?>
<?php
$_SESSION['tmp_order'] = 'tmp_order' . $_SESSION['accountid'];
$result = mysqli_query($db_connection, 'DROP TABLE IF EXISTS ' . $_SESSION['tmp_order'] . '') or die(mysqli_error($db_connection));
$str = "CREATE TABLE " . $_SESSION['tmp_order'] . " (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`inventory_id` double DEFAULT 0,
	`qty` double DEFAULT 0,
	`puhunan` double DEFAULT 0,
	`price` double DEFAULT 0,
	`order_id` VARCHAR(128) DEFAULT '',
	primary key(`id`) ) 
ENGINE=InnoDB DEFAULT CHARSET=latin1;";
mysqli_query($db_connection, $str) or die(mysqli_error($db_connection));



?>
<h2>Sales</h2>
<div class="sales-grid">


    <!-- Top Row -->
    <div class="card">
        <h3>Item Inquiry</h3>
        <div class="search-bar">
            <input type="text" id="str" onkeyup="ajax_fn('pages/sales_search.php?str='+document.getElementById('str').value,'inventoryView');" placeholder="Search items..." />
            <button onclick="ajax_fn('pages/sales_search.php?str='+document.getElementById('str').value,'inventoryView');" class="search-icon"><i class="fas fa-search"></i></button>
        </div>
    </div>

    <div class="card">
        <h3>Item List</h3>
        <div class="inventory-box" id="inventoryView"><?php include('sales_search.php'); ?></div>
    </div>

    <!-- Bottom Row -->
    <div class="card" id="tmp_tmp">
        <h3>Order Details</h3>
        <p>Order ID: <span id="currentOrderId">ORD-0001</span></p>

        <div class="form-group">
            <label>Item Code</label>
            <input type="text" id="salesItemCode" readonly />

            <label>Category</label>
            <input type="text" id="salesItemCode" readonly />

            <label>Subcategory</label>
            <input type="text" id="salesItemCode" readonly />

            <label>Size</label>
            <input type="text" id="salesItemCode" readonly />

            <label>Unit</label>
            <input type="text" id="salesItemCode" readonly />

            <label>Quantity</label>
            <input type="number" id="salesQuantity" />

            <button class="btn brown" onclick="addToOrder()">Add to Order</button>
        </div>
    </div>

    <div class="card">
        <h3>Receipt</h3>
        <div id="orderItems">
            <?php include('sales_order_it.php'); ?>
        </div>


    </div>

</div>
<style>
    body {
        font-family: Arial, sans-serif;
        background: #f5f2eb;
        margin: 0;
        padding: 20px;
    }

    .sales-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    /* Box Styling */
    .card {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
    }

    /* Shared Fields */
    input,
    select {
        width: 100%;
        padding: 8px;
        margin-top: 4px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    /* Inventory Box */
    .inventory-box {
        border: 1px solid #ccc;
        height: 200px;
        overflow-y: auto;
        background: #f9f9f9;
        padding: 10px;
        border-radius: 4px;
    }

    /* Buttons */
    .btn {
        padding: 10px;
        border: none;
        border-radius: 4px;
        font-weight: bold;
        cursor: pointer;
    }

    .btn.green {
        background-color: #4CAF50;
        color: white;
    }

    .btn.green:hover {
        background-color: #3e8e41;
    }

    .btn.brown {
        background-color: #8b7355;
        color: white;
    }

    .btn.brown:hover {
        background-color: #6b5c4d;
    }

    .button-group {
        display: flex;
        gap: 10px;
        margin-top: 10px;
    }

    /* Search bar */
    .search-bar {
        display: flex;
        gap: 10px;
    }

    .search-bar input {
        flex: 1;
    }

    .search-icon {
        background-color: #8b7355;
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 4px;
        cursor: pointer;
    }

    .search-icon:hover {
        background-color: #6b5c4d;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .sales-grid {
            grid-template-columns: 1fr;
        }
    }
</style>