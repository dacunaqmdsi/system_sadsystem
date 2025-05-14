<?php
include('../includes/init.php');
include('../header.php'); 

$from = mysqli_real_escape_string($db_connection, $_GET['from1']);
$to = mysqli_real_escape_string($db_connection, $_GET['to1']);

$query = "SELECT audit_id, activity, description, accountid, created_at 
          FROM tblaudittrail 
          WHERE DATE(created_at) BETWEEN '$from' AND '$to'";

$result = mysqli_query($db_connection, $query);
?>

<h2>System Logs</h2>
<p>From: <?php echo htmlspecialchars($from); ?> To: <?php echo htmlspecialchars($to); ?></p>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Audit ID</th>
            <th>Activity</th>
            <th>Description</th>
            <th>Account ID</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td><?php echo $row['audit_id']; ?></td>
                <td><?php echo $row['activity']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td><?php echo $row['accountid']; ?></td>
                <td><?php echo $row['created_at']; ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>