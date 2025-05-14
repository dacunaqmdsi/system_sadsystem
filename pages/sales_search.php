<?php include('../includes/init.php'); ?>
<table>
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
        <th><b>PRICE</b></th>
        <th>Action</th>
    </tr>
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
            i.inventory_id,
            ip.price AS effective_price
        FROM tblinventory i
        LEFT JOIN tblcategory c ON i.categoryid = c.categoryid
        LEFT JOIN tblsubcategory sc ON i.subcategoryid = sc.subcategoryid
        LEFT JOIN tblsizes s ON i.sizesid = s.sizesid
        LEFT JOIN tblmadefrom mf ON i.madefromid = mf.madefromid
        LEFT JOIN tblcooperative coop ON i.cooperativeid = coop.cooperativeid
        LEFT JOIN tblstorage st ON i.storageid = st.storageid
        LEFT JOIN tblunit u ON i.unitid = u.unitid
        LEFT JOIN tblinventory_prices ip 
            ON ip.inventory_id = i.inventory_id
            AND CURDATE() >= ip.effective_date
            AND (ip.effective_date_to IS NULL OR CURDATE() <= ip.effective_date_to)
        WHERE ip.price_id = (
            SELECT MAX(price_id) 
            FROM tblinventory_prices 
            WHERE inventory_id = i.inventory_id
              AND CURDATE() >= effective_date
              AND (effective_date_to IS NULL OR CURDATE() <= effective_date_to)
        )
    ";

    // Optional search filter
    if (isset($_GET['str']) && !empty($_GET['str'])) {
        $searchString = mysqli_real_escape_string($db_connection, $_GET['str']);
        $query .= " AND (
            i.product_name LIKE '%$searchString%' OR
            i.product_id LIKE '%$searchString%' OR
            i.color LIKE '%$searchString%' OR
            c.category LIKE '%$searchString%' OR
            sc.subcategory LIKE '%$searchString%' OR
            s.size LIKE '%$searchString%' OR
            mf.madefrom LIKE '%$searchString%' OR
            coop.cooperative LIKE '%$searchString%'
        )";
    }

    $query .= " ORDER BY i.product_name ASC LIMIT 0,2";

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
            <td><b>" . number_format($row['effective_price'], 2) . "</b></td>
            <td>
            <button onclick=\"ajax_fn('pages/sales_add_to_cart.php?effective_price=" . urlencode($row['effective_price']) . "&inventory_id=" . urlencode($row['inventory_id']) . "', 'tmp_tmp');\">
                Select
            </button>
        </td> </tr>";
    }
    ?>
</table>