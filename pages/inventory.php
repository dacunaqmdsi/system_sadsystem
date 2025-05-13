<?php include('../includes/init.php'); ?>
<h2>Inventory Management</h2>

<!-- Inventory List Section -->
<div class="container">
    <div class="section-title">Inventory List</div>
    <div class="inventory-header">
        <input type="text" placeholder="Search inventory...">
        <button class="btn btn-green">Search</button>
        <button class="btn btn-green">View All</button>
    </div>
    <table>
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Category</th>
                <th>Subcategory</th>
                <th>Size</th>
                <th>Cooperative</th>
                <th>Made From</th>
                <th>Storage Location</th>
                <th>Quantity</th>
                <th>Reorder Level</th>
                <th>Cost Price</th>
                <th>Retail Price</th>
                <th>Unit</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Inventory data rows go here -->
        </tbody>
    </table>
</div>

<!-- Add Inventory Section -->
<div class="container">
    <div class="section-title">Add New Inventory Item</div>
    <div class="form-row">
        <input type="text" placeholder="Product ID">
        <select>
            <option>Select Category</option>
        </select>
        <select>
            <option>Select Subcategory</option>
        </select>
        <select>
            <option>Select Size</option>
        </select>
        <select>
            <option>Select Made From</option>
        </select>
        <select>
            <option>Select Cooperative</option>
        </select>
        <input type="number" placeholder="Quantity Available">
        <input type="number" placeholder="Reorder Threshold">
        <select>
            <option>Select Storage Location</option>
        </select>
        <input type="number" placeholder="Cost Price">
        <input type="number" placeholder="Retail Price">
        <select>
            <option>Select Unit</option>
        </select>
        <input type="date" value="2025-05-13">
    </div>
    <br>
    <div align="right"><button class="btn btn-brown">+</button></div>
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

    .inventory-header,
    .inventory-form {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
        margin-bottom: 15px;
    }

    input[type="text"],
    select,
    input[type="number"],
    input[type="date"] {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        min-width: 120px;
    }

    .btn {
        padding: 8px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        color: white;
        width: 100px;
    }

    .btn-green {
        background-color: #4CAF50;
    }

    .btn-brown {
        background-color: #8B6B4A;
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

    .form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 15px;
    }
</style>