<?php include('../includes/init.php'); is_blocked(); ?>

<h2>Inventory Management</h2>

<!-- Inventory List Section -->
<div class="container">
    <div class="section-title">Inventory List</div>
    <div class="table-responsive">
        <table>
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
                    <!-- <th>Action</th> -->
                </tr>
            </thead>
            <tbody>
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
                        i.inventory_id
                    FROM tblinventory i
                    LEFT JOIN tblcategory c ON i.categoryid = c.categoryid
                    LEFT JOIN tblsubcategory sc ON i.subcategoryid = sc.subcategoryid
                    LEFT JOIN tblsizes s ON i.sizesid = s.sizesid
                    LEFT JOIN tblmadefrom mf ON i.madefromid = mf.madefromid
                    LEFT JOIN tblcooperative coop ON i.cooperativeid = coop.cooperativeid
                    LEFT JOIN tblstorage st ON i.storageid = st.storageid
                    LEFT JOIN tblunit u ON i.unitid = u.unitid
                    ORDER BY i.product_name ASC 
                ";

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
                        <td>";
                    // echo '<button onclick="ajax_fn(\'pages/inventory.php?inventory_id=' . $row['inventory_id'] . '\',\'main_content\');">Edit</button>';
                    echo "</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f7f2e8;
        margin: 0;
        padding: 20px;
    }

    h2 {
        color: #333;
    }

    .container {
        background-color: white;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .section-title {
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 10px;
    }

    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    button {
        background-color: #4CAF50;
        color: white;
        padding: 5px 10px;
        border: none;
        cursor: pointer;
        border-radius: 4px;
    }

    button:hover {
        background-color: #45a049;
    }

    @media (max-width: 768px) {

        table th,
        table td {
            font-size: 12px;
            padding: 8px;
        }
    }

    @media (max-width: 480px) {

        table th,
        table td {
            font-size: 10px;
            padding: 6px;
        }

        button {
            font-size: 10px;
            padding: 4px 8px;
        }
    }
</style>