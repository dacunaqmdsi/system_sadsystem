
<?php
include('../includes/init.php');
include('../header.php'); 

$from = isset($_GET['from3']) ? mysqli_real_escape_string($db_connection, $_GET['from3']) : '';
$to = isset($_GET['to3']) ? mysqli_real_escape_string($db_connection, $_GET['to3']) : '';
$inventory_id = isset($_GET['inventory_id2']) ? intval($_GET['inventory_id2']) : 0;

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
        i.created_at
    FROM tblinventory i
    LEFT JOIN tblcategory c ON i.categoryid = c.categoryid
    LEFT JOIN tblsubcategory sc ON i.subcategoryid = sc.subcategoryid
    LEFT JOIN tblsizes s ON i.sizesid = s.sizesid
    LEFT JOIN tblmadefrom mf ON i.madefromid = mf.madefromid
    LEFT JOIN tblcooperative coop ON i.cooperativeid = coop.cooperativeid
    LEFT JOIN tblstorage st ON i.storageid = st.storageid
    LEFT JOIN tblunit u ON i.unitid = u.unitid
    WHERE 1
";

// Filter by date range
if (!empty($from) && !empty($to)) {
    $query .= " AND DATE(i.created_at) BETWEEN '$from' AND '$to'";
}

// Filter by inventory ID if not 0
if ($inventory_id !== 0) {
    $query .= " AND i.inventory_id = $inventory_id";
}

$query .= " ORDER BY i.product_name ASC";

$result = mysqli_query($db_connection, $query);
?>

<h2>Inventory Report</h2>
<p>From: <?php echo htmlspecialchars($from); ?> To: <?php echo htmlspecialchars($to); ?></p>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
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
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td><?= htmlspecialchars($row['product_id']); ?></td>
                <td><?= htmlspecialchars($row['product_name']); ?></td>
                <td><?= htmlspecialchars($row['color']); ?></td>
                <td><?= htmlspecialchars($row['category']); ?></td>
                <td><?= htmlspecialchars($row['subcategory']); ?></td>
                <td><?= htmlspecialchars($row['size']); ?></td>
                <td><?= htmlspecialchars($row['madefrom']); ?></td>
                <td><?= htmlspecialchars($row['cooperative']); ?></td>
                <td><?= htmlspecialchars($row['qty_available']); ?></td>
                <td><?= htmlspecialchars($row['reorder_threshold']); ?></td>
                <td><?= htmlspecialchars($row['storage']); ?></td>
                <td><?= htmlspecialchars($row['cost_price']); ?></td>
                <td><?= htmlspecialchars($row['retail_price']); ?></td>
                <td><?= htmlspecialchars($row['unit']); ?></td>
                <td><?= htmlspecialchars($row['current_stock']); ?></td>
                <td><?= htmlspecialchars($row['new_stock']); ?></td>
                <td><?= htmlspecialchars($row['total_stock']); ?></td>
                <td><?= htmlspecialchars($row['created_at']); ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>