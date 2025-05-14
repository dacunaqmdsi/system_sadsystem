<?php
include_once('../includes/dbconfig.php');

$range = $_POST['range'] ?? 'weekly';

switch ($range) {
    case 'monthly':
        $groupFormat = '%Y-%m';
        $labelFormat = 'DATE_FORMAT(s.created_at, "%M %Y")';
        $limit = 12;
        break;

    case 'yearly':
        $groupFormat = '%Y';
        $labelFormat = 'DATE_FORMAT(s.created_at, "%Y")';
        $limit = 5;
        break;

    case 'weekly':
    default:
        $groupFormat = '%Y-%u'; // Year-WeekNumber
        $labelFormat = 'CONCAT("Week ", WEEK(s.created_at), " - ", YEAR(s.created_at))';
        $limit = 8;
        break;
}

$sql = "
    SELECT 
        $labelFormat AS label,
        SUM(d.qty * d.price) AS total_sales
    FROM tblsales s
    JOIN tblsales_details d ON s.sales_id = d.sales_id
    WHERE s.created_at IS NOT NULL
    GROUP BY DATE_FORMAT(s.created_at, '$groupFormat')
    ORDER BY s.created_at DESC
    LIMIT $limit
";

$result = $conn->query($sql);

$labels = [];
$values = [];

while ($row = $result->fetch_assoc()) {
    $labels[] = $row['label'];
    $values[] = round($row['total_sales'], 2);
}

echo json_encode([
    'labels' => array_reverse($labels),
    'values' => array_reverse($values),
]);
