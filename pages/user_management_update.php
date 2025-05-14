<?php include('../includes/init.php'); is_blocked(); ?>

<?php
if (isset($_GET['toggle_block']) && isset($_GET['accountid'])) {
    $accountid = (int) $_GET['accountid'];

    // Get current status
    $res = mysqli_query($db_connection, "SELECT is_blocked FROM tblaccounts WHERE accountid = $accountid");
    $row = mysqli_fetch_assoc($res);

    if ($row) {
        $new_status = $row['is_blocked'] == 0 ? 1 : 0;

        // Update status
        mysqli_query($db_connection, "UPDATE tblaccounts SET is_blocked = $new_status WHERE accountid = $accountid");

        // Echo new status for AJAX response
        echo $new_status == 0 ? 'Active' : 'BLOCKED';
    } else {
        echo "User not found";
    }
}
?>
