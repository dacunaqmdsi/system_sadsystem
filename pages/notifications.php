<?php include('../includes/init.php'); is_blocked(); ?>

<h2>Notifications</h2>

<div class="notification-container">
    <div class="section-title">System Notifications</div>
    <div class="notification-box">
        Notifications will appear here.
        <table class="audit-trail-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Account ID</th>
                    <th>Activity</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $rs = mysqli_query($db_connection, 'SELECT a.*, b.* FROM tblaudittrail a, tblaccounts b WHERE a.accountid=b.accountid ORDER BY a.created_at DESC');
                while ($rw = mysqli_fetch_array($rs)) {
                    $created_at = date('F j, Y - g:i A', strtotime($rw['created_at']));

                    $accountid = htmlspecialchars($rw['first_name']); // Sanitize the accountid
                    $accountid2 = htmlspecialchars($rw['last_name']); // Sanitize the accountid
                    $activity = htmlspecialchars($rw['activity']); // Sanitize the activity
                    echo '
                        <tr>
                            <td>' . $created_at . '</td>
                            <td>' . $accountid . ' ' . $accountid2 . '</td>
                            <td>' . $activity . '</td>
                        </tr>
                    ';
                }
                ?>
            </tbody>
        </table>
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
        color: #333;
        margin-bottom: 20px;
    }

    .notification-container {
        background-color: #fff;
        padding: 20px 30px;
        border: 1px solid #ddd;
        border-radius: 6px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .section-title {
        font-weight: bold;
        margin-bottom: 15px;
        font-size: 16px;
    }

    .notification-box {
        background-color: #f7f2e7;
        border: 1px solid #d6d0c4;
        border-radius: 4px;
        padding: 15px;
        min-height: 300px;
        color: #333;
    }
</style>