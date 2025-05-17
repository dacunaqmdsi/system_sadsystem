<div class="report-letterhead">
    <div class="report-header">
        <div class="logo-section">
            <img src="../images/logo2.jpg" alt="Store Logo" class="report-logo">
        </div>
        <div class="business-info">
            <div class="business-name">Mary's Native Product Store</div>
            <div class="business-details">
                123 Main Street, City, Province, 1234<br>
                Phone: (123) 456-7890 | Email: info@marysnativeproducts.com
            </div>
        </div>
        <div class="report-date">
            Generated on: <span id="generated-date">5/14/2025</span>
        </div>
    </div>
    <div class="report-title">Inventory Report</div>
</div>
<hr>
<?php
include('../includes/init.php');
// include('../header.php'); 

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
<div class="table-responsive">
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
</div>
<style>
    .report-letterhead {
        font-family: Arial, sans-serif;
        padding: 20px;
    }

    .report-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
    }

    .logo-section {
        flex-shrink: 0;
    }

    .report-logo {
        width: 80px;
        height: 80px;
        object-fit: contain;
        border-radius: 50%;
    }

    .business-info {
        flex-grow: 1;
        margin-left: 20px;
    }

    .business-name {
        font-weight: bold;
        font-size: 20px;
    }

    .business-details {
        font-size: 14px;
        color: #555;
    }

    .report-date {
        position: absolute;
        right: 0;
        top: 0;
        font-size: 13px;
        color: #444;
    }

    .report-title {
        text-align: center;
        margin-top: 40px;
        font-weight: bold;
        font-size: 18px;
    }
</style>
<style>
    table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        word-wrap: break-word;
        font-family: Arial, sans-serif;
        font-size: 14px;
    }

    th, td {
        padding: 8px 10px;
        text-align: left;
        border: 1px solid #444;
    }

    thead {
        background-color: #f0f0f0;
        font-weight: bold;
    }

    @media print {
        body {
            margin: 0;
            padding: 0;
        }

        table {
            page-break-inside: auto;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        th, td {
            border: 1px solid #000;
        }
    }
</style>
