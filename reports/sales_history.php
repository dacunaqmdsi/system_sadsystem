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
    <div class="report-title">Sales History Report</div>
</div>
<hr>
<?php
include('../includes/init.php');
// include('../header.php'); 

$from = mysqli_real_escape_string($db_connection, $_GET['from4']);
$to = mysqli_real_escape_string($db_connection, $_GET['to4']);

$query = "SELECT 
    a.sales_id, a.order_id, a.created_at, a.processed_by, a.payment_method,
    b.id AS detail_id, b.sales_id AS detail_sales_id, b.inventory_id, b.qty, b.puhunan, b.price,
    c.inventory_id AS inv_id, c.product_id, c.product_name
FROM tblsales a
JOIN tblsales_details b ON a.sales_id = b.sales_id
JOIN tblinventory c ON b.inventory_id = c.inventory_id
WHERE DATE(a.created_at) BETWEEN '$from' AND '$to'";

$result = mysqli_query($db_connection, $query);
?>

<h2>Sales History Report</h2>
<p>From: <?php echo htmlspecialchars($from); ?> To: <?php echo htmlspecialchars($to); ?></p>
<div class="table-responsive">
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Sales ID</th>
            <th>Order ID</th>
            <th>Date</th>
            <th>Processed By</th>
            <th>Payment</th>
            <th>Product</th>
            <th>Qty</th>
            <th>Puhunan</th>
            <th>Price</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) :
            $username = GetValue('select username from tblaccounts where accountid=' . $row['processed_by']);
        ?>
            <tr>
                <td><?php echo $row['sales_id']; ?></td>
                <td><?php echo $row['order_id']; ?></td>
                <td><?php echo $row['created_at']; ?></td>
                <td><?php echo $username; ?></td>
                <td><?php echo $row['payment_method']; ?></td>
                <td><?php echo $row['product_name']; ?></td>
                <td><?php echo $row['qty']; ?></td>
                <td><?php echo $row['puhunan']; ?></td>
                <td><?php echo $row['price']; ?></td>
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
