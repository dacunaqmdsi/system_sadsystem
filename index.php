<?php
if (session_id() == '') {
    session_start();
}

if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = rand(1, 100);
}

$err = '';

if (isset($_POST['signin']) && isset($_SESSION['token']) && $_SESSION['token'] == $_POST['token']) {

    include('includes/dbconfig.php');

    $username = mysqli_real_escape_string($db_connection, $_POST['username']);
    $password = mysqli_real_escape_string($db_connection, $_POST['account_password']);
    // $password = secureData(mysqli_real_escape_string($db_connection, $_POST['accountpassword']));

    $sql = "SELECT accountid, username, account_password, account_type FROM tblaccounts WHERE username='$username' AND account_password='$password' LIMIT 1";
    $rs = mysqli_query($db_connection, $sql);

    if ($rs && mysqli_num_rows($rs) === 1) {
        $user = mysqli_fetch_assoc($rs);
        $_SESSION['accountid'] = $user['accountid'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['account_type'] = $user['account_type'];
        include('home.php');
        exit();
    } else {
        $err = '<span style="color:red; font-size:16px;" class="fw-bold blink" >Invalid Username or Password</span>';
    }
}
if (isset($_SESSION['accountid'])) {
    include_once('includes/dbconfig.php');
    include('home.php');
    exit(0);
}
$_SESSION['token'] = rand(1, 100);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mary's Native Product Store System - Login</title>
    <link rel="icon" type="image/png" href="images/log.png" />
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/styles.css">

    <style>
        .blink {
            animation: 2s linear infinite condemned_blink_effect;
        }

        @keyframes spin-slow {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        body {
            overflow-x: hidden;
            overflow-y: hidden;
            /* Prevent vertical scroll */
        }
    </style>
</head>

<body>
    <!-- Login Section -->
    <div id="authSection">
        <div class="auth-container" id="loginContainer">
            <img src="images/logo2.jpg" alt="Mary's Native Product Store Logo" class="auth-logo" />
            <h2><i class="fas fa-sign-in-alt"></i> Login</h2>
            <form method="POST">
                <input hidden type="text" value="<?= $_SESSION['token']; ?>" name="token">
                <div class="form-group">
                    <input type="text" id="loginUsername" name="username" placeholder="Username" required />
                </div>

                <div class="form-group">
                    <input type="password" name="account_password" id="loginPassword" placeholder="Password" required />
                </div>

                <div class="form-group">
                    <label for="loginRole">Account Type</label>
                    <select name="account_type" id="loginRole" required>
                        <option value="admin">System Admin</option>
                        <option value="inventory">Inventory Personnel</option>
                        <option value="cashier">Cashier</option>
                    </select>
                </div>

                <button type="submit" name="signin" class="accent-btn">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
                <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($err)) : ?>
                    <div class="mt-2 text-sm">
                        <?= $err ?>
                    </div>
                <?php endif; ?>
            </form>
            <p>Accounts must be created by the System Admin.</p>
        </div>
    </div>
</body>

</html>