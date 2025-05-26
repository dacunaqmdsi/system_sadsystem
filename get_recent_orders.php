<?php
include('includes/dbconfig.php');

function getDateRangeCondition($filter, $start = null, $end = null) {
    switch ($filter) {
        case 'today':
            return "DATE(s.created_at) = CURDATE()";
        case 'week':
            return "YEARWEEK(s.created_at, 1) = YEARWEEK(CURDATE(), 1)";
        case 'month':
            return "MONTH(s.created_at) = MONTH(CURDATE()) AND YEAR(s.created_at) = YEAR(CURDATE())";
        case 'year':
            return "YEAR(s.created_at) = YEAR(CURDATE())";
        case 'custom':
            if ($start && $end) {
                return "DATE(s.created_at) BETWEEN '$start' AND '$end'";
            }
        default:
            return "1"; // No filter
    }
}

$filter = $_GET['vall'] ?? '';
$start = $_GET['start'] ?? null;
$end = $_GET['end'] ?? null;

$where = getDateRangeCondition($filter, $start, $end);

$query = "
    SELECT 
        s.order_id,
        s.created_at,
        GROUP_CONCAT(i.product_name SEPARATOR ', ') AS items,
        SUM(d.qty * d.price) AS total
    FROM tblsales s
    JOIN tblsales_details d ON s.sales_id = d.sales_id
    JOIN tblinventory i ON d.inventory_id = i.inventory_id
    WHERE $where
    GROUP BY s.order_id, s.created_at
    ORDER BY s.created_at DESC
";

$rs = mysqli_query($db_connection, $query);

while ($rw = mysqli_fetch_assoc($rs)) {
    echo '<tr>
        <td>' . htmlspecialchars($rw['order_id']) . '</td>
        <td>' . htmlspecialchars($rw['created_at']) . '</td>
        <td>' . htmlspecialchars($rw['items']) . '</td>
        <td>' . number_format($rw['total'], 2) . '</td>
        <td>DONE</td>
    </tr>';
}
?>