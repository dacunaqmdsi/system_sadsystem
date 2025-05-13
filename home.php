<?php
if (session_id() == '') {
    session_start();
}
if (isset($_SESSION['accountid'])) {
    if (file_exists('includes/dbconfig.php')) {
        include_once('includes/dbconfig.php');
    }
} else {
    header('location: ./');
    exit(0);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mary's Native Product Store System</title>

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />

    <!-- Styles -->
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/styles.css" />

    <style>
        html,
        body {
            overflow-x: hidden;
        }
    </style>
    <script>
        function param(w, h) {
            var width = w;
            var height = h;
            var left = (screen.width - width) / 2;
            var top = (screen.height - height) / 2;
            var params = 'width=' + width + ', height=' + height;
            params += ', top=' + top + ', left=' + left;
            params += ', directories=no, location=no, resizable=no, status=no, toolbar=no';
            return params;
        }

        function openWin(url) {
            window.open(url, 'mywin', param(800, 500)).focus();
        }

        function openCustom(url, w, h) {
            window.open(url, 'mywin', param(w, h)).focus();
        }

        function openCustom2(url, w, h) {
            let newWindow = window.open(url, '_blank', param(w, h));
            if (!newWindow) {
                alert("Popup blocked! Please allow popups for this site.");
            } else {
                newWindow.focus();
            }
        }

        function ajax_fn(url, elementId) {
            const xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                    document.getElementById(elementId).innerHTML = xmlhttp.responseText;
                }
            };
            xmlhttp.open("GET", url, true);
            xmlhttp.send();
        }
    </script>
</head>

<body>
    <!-- Dashboard Section (Login Removed) -->
    <div id="dashboardSection" style="display: block;">
        <!-- User Info Bar -->
        <div class="user-info-bar">
            <div class="system-title">
                <b>Mary's Native Product Store System</b>
            </div>
            <div class="user-controls">
                <div class="notification-icon" onclick="showNotifications()" style="cursor:pointer; position:relative;">
                    <i class="fas fa-bell" style="color: #fff;"></i>
                    <span id="notificationCount" style="position:absolute; top:-8px; right:-8px; background:#ff4444; color:white; border-radius:50%; padding:2px 6px; font-size:12px; display:none;">0</span>
                </div>
                <div class="user-role">
                    <i class="fas fa-user"></i> <span id="userRoleText">Admin</span>(Admin)
                </div>
                <button class="logout-btn" onclick="window.location.href='pages/logout.php'">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </div>
        </div>

        <!-- Navigation Sidebar -->
        <nav id="navBar">
            <div class="logo-space">
                <div class="logo-container">
                    <img src="images/logo2.jpg" alt="Mary's Native Product Store Logo" class="logo">
                </div>
            </div>
            <div class="menu-items">
                <a href="javascript:void(0)" onclick="ajax_fn('pages/dashboard','main_content')" class="active"><i class="fa-solid fa-gauge-high"></i><span>Dashboard</span></a>
                <a href="javascript:void(0)" onclick="ajax_fn('pages/sales','main_content')"><i class="fa-solid fa-chart-line"></i><span>Sales</span></a>
                <a href="javascript:void(0)" onclick="ajax_fn('pages/inventory','main_content')"><i class="fa-solid fa-boxes-stacked"></i><span>Inventory</span></a>
                <a href="javascript:void(0)" onclick="ajax_fn('pages/user_management','main_content')"><i class="fa-solid fa-users-gear"></i><span>User Management</span></a>
                <a href="javascript:void(0)" onclick="ajax_fn('pages/maintenance','main_content')"><i class="fa-solid fa-screwdriver-wrench"></i><span>Maintenance</span></a>
                <a href="javascript:void(0)" onclick="ajax_fn('pages/reports','main_content')"><i class="fa-solid fa-file-lines"></i><span>Reports</span></a>
                <a href="javascript:void(0)" onclick="ajax_fn('pages/notifications.php','main_content')"><i class="fa-solid fa-bell"></i><span>Notifications</span></a>
            </div>
        </nav>

        <!-- Main Content Area -->
        <div class="content" id="main_content">
            <!-- Include your modules here -->
            <!-- Example: -->
            <?php include('pages/dashboard.php'); ?>
        </div>

        <!-- Clock -->
        <div id="clock" style="position:fixed; right:10px; bottom:4px; padding:4px 10px; background:#fff; border:1px solid #d4c9b8; border-radius:5px; box-shadow:0 2px 5px rgba(0,0,0,0.1); font-size:13px; z-index:100;">Loading date & time...</div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Setup logic if needed
        });

        // Example: If you want to default to dashboard
        window.showModule = function(moduleId) {
            document.querySelectorAll('.module').forEach(mod => mod.style.display = 'none');
            document.getElementById(moduleId).style.display = 'block';

            document.querySelectorAll('.menu-items a').forEach(link => link.classList.remove('active'));
            const activeLink = [...document.querySelectorAll('.menu-items a')].find(link =>
                link.textContent.trim().toLowerCase() === moduleId.replace('Module', '').toLowerCase()
            );
            if (activeLink) activeLink.classList.add('active');
        };

        window.showModule('dashboardModule'); // show dashboard by default
    </script>
</body>

</html>