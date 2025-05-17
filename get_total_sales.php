<?php
include('includes/dbconfig.php');

function getSalesQuery($filter, $start = null, $end = null)
{
    switch ($filter) {
        case 'today':
            return "AND DATE(b.created_at) = CURDATE()";
        case 'week':
            return "AND YEARWEEK(b.created_at, 1) = YEARWEEK(CURDATE(), 1)";
        case 'month':
            return "AND MONTH(b.created_at) = MONTH(CURDATE()) AND YEAR(b.created_at) = YEAR(CURDATE())";
        case 'year':
            return "AND YEAR(b.created_at) = YEAR(CURDATE())";
        case 'custom':
            if ($start && $end) {
                return "AND DATE(b.created_at) BETWEEN '$start' AND '$end'";
            }
        default:
            return "";
    }
}

if (isset($_GET['vall'])) {
    $filter = $_GET['vall'];
    $start = $_GET['start'] ?? null;
    $end = $_GET['end'] ?? null;

    $condition = getSalesQuery($filter, $start, $end);

    $sql = "SELECT SUM(a.qty * a.price) AS total 
            FROM tblsales_details a 
            JOIN tblsales b ON a.sales_id = b.sales_id 
            WHERE b.is_void = 0 $condition";

    $result = $db_connection->query($sql);
    $row = $result->fetch_assoc();
    echo number_format($row['total'] ?? 0, 2);
}
