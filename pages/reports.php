<?php include('../includes/init.php'); ?>
<h2>Reports</h2>

<!-- System Logs -->
<div class="report-box">
    <div class="report-title">System Logs</div>
    <div class="report-row">
        <label>Date Range:</label>
        <input type="date" value="2025-05-13">
        <input type="date" value="2025-05-13">
        <label>Log Type:</label>
        <select>
            <option>All Logs</option>
        </select>
        <div class="report-buttons">
            <button class="button"><i class="fas fa-file-alt"></i> View Logs</button>
            <button class="button"><i class="fas fa-download"></i> PDF</button>
        </div>
    </div>
</div>

<!-- Sales Report -->
<div class="report-box">
    <div class="report-title">Sales Report</div>
    <div class="report-row">
        <label>Date Range:</label>
        <input type="date" value="2025-05-13">
        <input type="date" value="2025-05-13">
        <label>Item:</label>
        <select>
            <option>All Items</option>
        </select>
        <label>Sales Level:</label>
        <select>
            <option>All Levels</option>
        </select>
        <div class="report-buttons">
            <button class="button"><i class="fas fa-sync-alt"></i> Generate</button>
            <button class="button"><i class="fas fa-download"></i> PDF</button>
        </div>
    </div>
</div>

<!-- Inventory Report -->
<div class="report-box">
    <div class="report-title">Inventory Report</div>
    <div class="report-row">
        <label>Date Range:</label>
        <input type="date" value="2025-05-13">
        <input type="date" value="2025-05-13">
        <label>Item:</label>
        <select>
            <option>All Items</option>
        </select>
        <label>Stock Level:</label>
        <select>
            <option>All Levels</option>
        </select>
        <div class="report-buttons">
            <button class="button"><i class="fas fa-sync-alt"></i> Generate</button>
            <button class="button"><i class="fas fa-download"></i> PDF</button>
        </div>
    </div>
</div>

<!-- Sales History -->
<div class="report-box">
    <div class="report-title">Sales History</div>
    <div class="report-row">
        <label>Date Range:</label>
        <input type="date" value="2025-05-13">
        <input type="date" value="2025-05-13">
        <div class="report-buttons">
            <button class="button"><i class="fas fa-filter"></i> Filter</button>
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