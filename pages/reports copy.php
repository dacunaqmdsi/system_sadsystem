<?php include('../includes/init.php'); ?>
<h2>Reports</h2>

<!-- System Logs -->
<div class="report-box">
    <div class="report-title">System Logs</div>
    <div class="report-row">
        <label>Date Range:</label>
        <input type="date" id="from1">
        <input type="date" id="to1">
        <!-- <label>Log Type:</label> -->
        <!-- <select>
            <option>All Logs</option>
        </select> -->
        <div class="report-buttons">
            <button class="button" onclick="openCustom('reports/system_logs?from1='+document.getElementById('from1').value
                                            +'&to1='+document.getElementById('to1').value,1000,1000);"><i class="fas fa-file-alt"></i> View Logs</button>
            <button class="button"><i class="fas fa-download"></i> PDF</button>
        </div>
    </div>
</div>

<!-- Sales Report -->
<div class="report-box">
    <div class="report-title">Sales Report</div>
    <div class="report-row">
        <label>Date Range:</label>
        <input type="date" id="from2">
        <input type="date" id="to2">
        <label>Item:</label>
        <select id="inventory_id" style="width:400px;">
            <option value="">All Items</option>
            <?php
            $res = mysqli_query($db_connection, "SELECT inventory_id, product_id, product_name, color, cost_price, retail_price FROM tblinventory");
            while ($row = mysqli_fetch_assoc($res)) {
                echo '<option value="' . $row['inventory_id'] . '">' . htmlspecialchars($row['product_id']) . ' ' . htmlspecialchars($row['product_name']) . ' ' . htmlspecialchars($row['color']) . '</option>';
            }
            ?>
        </select>
        <!-- <label>Sales Level:</label> -->
        <!-- <select id="sales2">
            <option value="0">All Levels</option>
            <option value="High Sales">High Sales</option>
            <option value="Low Sales">Low Sales</option>
        </select> -->
        <div class="report-buttons">
            <button class="button" onclick="openCustom('reports/sales_report?from2='+document.getElementById('from2').value
                                            +'&to2='+document.getElementById('to2').value
                                            +'&inventory_id='+document.getElementById('inventory_id').value
                                            +'&sales2='+document.getElementById('sales2').value,1000,1000);"><i class="fas fa-sync-alt"></i> Generate</button>
            <button class="button"><i class="fas fa-download"></i> PDF</button>
        </div>
    </div>
</div>

<!-- Inventory Report -->
<div class="report-box">
    <div class="report-title">Inventory Report</div>
    <div class="report-row">
        <label>Date Range:</label>
        <input type="date" id="from3">
        <input type="date" id="to3">
        <label>Item:</label>
        <select id="inventory_id2" style="width:400px;">
            <option value="">All Items</option>
            <?php
            $res = mysqli_query($db_connection, "SELECT inventory_id, product_id, product_name, color, cost_price, retail_price FROM tblinventory");
            while ($row = mysqli_fetch_assoc($res)) {
                echo '<option value="' . $row['inventory_id'] . '">' . htmlspecialchars($row['product_id']) . ' ' . htmlspecialchars($row['product_name']) . ' ' . htmlspecialchars($row['color']) . '</option>';
            }
            ?>
        </select>
        <!-- <label>Stock Level:</label>
        <select>
            <option>All Levels</option>
        </select> -->
        <div class="report-buttons">
            <button class="button" onclick="openCustom('reports/inventory_report?from3='+document.getElementById('from3').value
                                            +'&to3='+document.getElementById('to3').value
                                            +'&inventory_id2='+document.getElementById('inventory_id2').value, 1000,1000);"><i class="fas fa-sync-alt"></i> Generate</button>
            <button class="button"><i class="fas fa-download"></i> PDF</button>
        </div>
    </div>
</div>

<!-- Sales History -->
<div class="report-box">
    <div class="report-title">Sales History</div>
    <div class="report-row">
        <label>Date Range:</label>
        <input type="date" id="from4">
        <input type="date" id="to4">
        <div class="report-buttons">
            <button class="button" onclick="openCustom('reports/sales_history?from4='+document.getElementById('from4').value
                                            +'&to4='+document.getElementById('to4').value,1000,1000);"><i class="fas fa-filter"></i> Filter</button>
        </div>
    </div>
</div>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f6f2e7;
        margin: 0;
        padding: 30px;
    }

    h2 {
        margin-bottom: 20px;
        color: #333;
    }

    .report-box {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .report-title {
        font-weight: bold;
        font-size: 16px;
        margin-bottom: 15px;
        text-align: left;
    }

    .report-row {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 10px;
    }

    .report-row select,
    .report-row input[type="date"] {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .report-buttons {
        margin-left: auto;
        display: flex;
        gap: 10px;
    }

    .button {
        background-color: #8B6B4A;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 8px 12px;
        font-size: 12px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        width: 120px;
    }

    .button i {
        font-size: 14px;
    }

    .button:hover {
        background-color: #755b3b;
    }
</style>