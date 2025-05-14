<?php include('../includes/init.php'); is_blocked(); ?>
<?php
if (isset($_POST['add_inventory'])) {
    $inventory_id = mysqli_real_escape_string($db_connection, $_POST['inventory_id']);
    $price = mysqli_real_escape_string($db_connection, $_POST['price']);
    $effective_date = mysqli_real_escape_string($db_connection, $_POST['effective_date']);
    $effective_date_to = mysqli_real_escape_string($db_connection, $_POST['effective_date_to']);

    // Validate inputs
    if (empty($inventory_id) || empty($price) || empty($effective_date)) {
        echo "All fields are required.";
        exit;
    }

    // Insert query
    $query = "INSERT INTO tblinventory_prices (inventory_id, price, effective_date, effective_date_to) 
              VALUES ('$inventory_id', '$price', '$effective_date', '$effective_date_to')";

    if (mysqli_query($db_connection, $query)) {
        echo "Price successfully added.";
    } else {
        echo "Error: " . mysqli_error($db_connection);
    }
}


// UPDATE PRICE
if (isset($_POST['edit_inventory'])) {
    $price_id2 = mysqli_real_escape_string($db_connection, $_POST['price_id_modify']);
    $inventory_id = mysqli_real_escape_string($db_connection, $_POST['inventory_id']);
    $price = mysqli_real_escape_string($db_connection, $_POST['price']);
    $effective_date = mysqli_real_escape_string($db_connection, $_POST['effective_date']);
    $effective_date_to = mysqli_real_escape_string($db_connection, $_POST['effective_date_to']); // Optional usage

    // Optional: Add validation here
    if (empty($price_id2) || empty($inventory_id) || empty($price) || empty($effective_date)) {
        echo "Please fill in all required fields.";
        exit;
    }

    $query = "UPDATE tblinventory_prices 
              SET inventory_id = '$inventory_id',
                  price = '$price',
                  effective_date = '$effective_date',
                  effective_date_to = '$effective_date_to'  
              WHERE price_id = '$price_id2'";

    if (mysqli_query($db_connection, $query)) {
        echo "Price successfully updated.";
    } else {
        echo "Error: " . mysqli_error($db_connection);
    }
}
if (isset($_GET['edit'])) {
    $price_id = $_GET['price_id'];
    $inventory_id_edit = GetValue('select inventory_id from tblinventory_prices where price_id=' . $price_id);
    $price = GetValue('select price from tblinventory_prices where price_id=' . $price_id);
    $effective_date = GetValue('select effective_date price from tblinventory_prices where price_id=' . $price_id);
    $effective_date_to = GetValue('select effective_date_to price from tblinventory_prices where price_id=' . $price_id);
}
?>

<div class="main-container">
    <div class="section-title">Manage Prices</div>
    <div align="right"><button onclick="ajax_fn('pages/maintenance','main_content');">Back</button></div>
    <br><br>
    <div align="right">
        <select id="inventory_id" style="width:400px;">
            <option value="">Select Product</option>
            <?php
            $res = mysqli_query($db_connection, "SELECT inventory_id, product_id, product_name, color, cost_price, retail_price FROM tblinventory");
            while ($row = mysqli_fetch_assoc($res)) {
                $selected = ($row['inventory_id'] == $inventory_id_edit) ? 'selected' : '';
                echo '<option value="' . $row['inventory_id'] . '" ' . $selected . '>' . htmlspecialchars($row['product_id']) . ' ' . htmlspecialchars($row['product_name']) . ' ' . htmlspecialchars($row['color']) . '</option>';
            }
            ?>
        </select>
        Price:
        <input type="number" id="price" value="<?php echo  $price; ?>" />
        Effective Date From:
        <input type="date" id="effective_date" value="<?php echo  $effective_date; ?>" />
        Effective Date To:
        <input type="date" id="effective_date_to" value="<?php echo  $effective_date_to; ?>" />
        <?php
        if ($price_id) {
            echo '<button onclick="update_price_inv(' . $price_id . ');">Update</button>';
        } else {
            echo '<button onclick="insert_price_inv();">Add</button>';
        }
        ?>

    </div>
    <table>
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Cost Price</th>
            <th>Retail Price</th>
            <th>Price</th>
            <th>Effective Date Entry</th>
            <th>Effective Date To</th>
            <th>Action</th>
        </tr>
        <?php
        $rs = mysqli_query($db_connection, 'select * from tblinventory_prices ');
        while ($rw = mysqli_fetch_array($rs)) {
            $product_id = GetValue('select product_id from tblinventory where inventory_id=' . $rw['inventory_id']);
            $product_name = GetValue('select product_name from tblinventory where inventory_id=' . $rw['inventory_id']);
            $cost_price = GetValue('select cost_price from tblinventory where inventory_id=' . $rw['inventory_id']);
            $retail_price = GetValue('select retail_price from tblinventory where inventory_id=' . $rw['inventory_id']);
            echo '<tr>
                <td>' . $product_id . '</td>
                <td>' . $product_name . '</td>
                <td>' . $cost_price . '</td>
                <td>' . $retail_price . '</td>
                <td>' . $rw['price'] . '</td>
                <td>' . date("F d, Y", strtotime($rw['effective_date'])) . '</td>
                <td>' . date("F d, Y", strtotime($rw['effective_date_to'])) . '</td>
                <td><a style="text-decoration: none;" href="javascript:void();" onclick="ajax_fn(\'pages/maintenance_prices.php?edit&price_id=' . $rw['price_id'] . '\',\'main_content\');">Edit</a></td>
            </tr>';
        }
        ?>
    </table>
</div>


<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f7f3e8;
        margin: 0;
        padding: 30px;
    }

    h2 {
        color: #333;
        margin-bottom: 20px;
    }

    .main-container {
        background-color: #fff;
        padding: 20px 30px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        border: 1px solid #ddd;
    }

    .section-title {
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 20px;
    }

    .inner-box {
        background-color: white;
        border: 1px solid #d5d5d5;
        border-radius: 8px;
        padding: 20px;
        max-width: 250px;
    }

    .inner-box-title {
        font-size: 14px;
        color: #4a4a4a;
        margin-bottom: 15px;
    }

    .button {
        display: block;
        width: 100%;
        margin-bottom: 10px;
        padding: 10px 0;
        background-color: #8B6B4A;
        color: white;
        border: none;
        border-radius: 4px;
        font-weight: bold;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .button:hover {
        background-color: #755b3b;
    }
</style>