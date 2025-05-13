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
    <link rel="icon" type="image/png" href="images/log.png" />
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <!-- Favicon Icon -->

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>


    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
        function setActiveLink(el) {
            // Select all nav links (adjust selector to match your structure)
            const links = document.querySelectorAll('a[onclick*="ajax_fn"]');

            links.forEach(link => link.classList.remove('active'));
            el.classList.add('active');
        }

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


        function create_user() {
            var user_id = document.getElementById("user_id").value.trim();
            var last_name = document.getElementById("last_name").value.trim();
            var first_name = document.getElementById("first_name").value.trim();
            var middle_name = document.getElementById("middle_name").value.trim();
            var address = document.getElementById("address").value.trim();
            var age = document.getElementById("age").value.trim();
            var email_address = document.getElementById("email_address").value.trim();
            var contact_number = document.getElementById("contact_number").value.trim();
            var username = document.getElementById("username").value.trim();
            var account_password = document.getElementById("account_password").value;
            var account_password_confirm = document.getElementById("account_password_confirm").value;
            var account_type = document.getElementById("account_type").value;
            if (user_id === "") {
                alert("User ID is required.");
                return;
            }
            if (last_name === "") {
                alert("Last name is required.");
                return;
            }
            if (first_name === "") {
                alert("First name is required.");
                return;
            }
            if (address === "") {
                alert("Address is required.");
                return;
            }
            if (age === "") {
                alert("Age is required.");
                return;
            }
            if (email_address === "") {
                alert("Email address is required.");
                return;
            }
            if (contact_number === "") {
                alert("Contact number is required.");
                return;
            }
            if (username === "") {
                alert("Username is required.");
                return;
            }
            if (account_password === "") {
                alert("Password is required.");
                return;
            }
            if (account_password_confirm === "") {
                alert("Confirm Password is required.");
                return;
            }
            if (account_password !== account_password_confirm) {
                alert("Passwords do not match.");
                return;
            }
            if (parseInt(account_type) === 0) {
                alert("Account type is required.");
                return;
            }
            if (confirm("Are you sure you want to create this user?")) {
                var formData = new FormData();
                formData.append('user_id', user_id);
                formData.append('last_name', last_name);
                formData.append('first_name', first_name);
                formData.append('middle_name', middle_name);
                formData.append('address', address);
                formData.append('age', age);
                formData.append('email_address', email_address);
                formData.append('contact_number', contact_number);
                formData.append('username', username);
                formData.append('account_password', account_password);
                formData.append('account_password_confirm', account_password_confirm);
                formData.append('account_type', account_type);
                formData.append('add_user', 1);
                $.ajax({
                    url: 'pages/user_management_add_user.php',
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $("#tmp_user_add").html(data);
                        $("#tmp_user_add").css('opacity', '1');
                        document.getElementById("user_id").value = "";
                        document.getElementById("last_name").value = "";
                        document.getElementById("first_name").value = "";
                        document.getElementById("middle_name").value = "";
                        document.getElementById("address").value = "";
                        document.getElementById("age").value = "";
                        document.getElementById("email_address").value = "";
                        document.getElementById("contact_number").value = "";
                        document.getElementById("username").value = "";
                        document.getElementById("account_password").value = "";
                        document.getElementById("account_password_confirm").value = "";
                        document.getElementById("account_type").value = "0";
                    },
                    error: function() {
                        alert("Error occurred while creating the user.");
                    }
                });
            } else {
                alert("User creation canceled.");
            }
        }

        function update_user(accountid) {
            var user_id = document.getElementById("user_id").value.trim();
            var last_name = document.getElementById("last_name").value.trim();
            var first_name = document.getElementById("first_name").value.trim();
            var middle_name = document.getElementById("middle_name").value.trim();
            var address = document.getElementById("address").value.trim();
            var age = document.getElementById("age").value.trim();
            var email_address = document.getElementById("email_address").value.trim();
            var contact_number = document.getElementById("contact_number").value.trim();
            var username = document.getElementById("username").value.trim();
            var account_password = document.getElementById("account_password").value;
            var account_password_confirm = document.getElementById("account_password_confirm").value;
            var account_type = document.getElementById("account_type").value;
            if (user_id === "") {
                alert("User ID is required.");
                return;
            }
            if (last_name === "") {
                alert("Last name is required.");
                return;
            }
            if (first_name === "") {
                alert("First name is required.");
                return;
            }
            if (address === "") {
                alert("Address is required.");
                return;
            }
            if (age === "") {
                alert("Age is required.");
                return;
            }
            if (email_address === "") {
                alert("Email address is required.");
                return;
            }
            if (contact_number === "") {
                alert("Contact number is required.");
                return;
            }
            if (username === "") {
                alert("Username is required.");
                return;
            }
            if (account_password === "") {
                alert("Password is required.");
                return;
            }
            if (account_password_confirm === "") {
                alert("Confirm Password is required.");
                return;
            }
            if (account_password !== account_password_confirm) {
                alert("Passwords do not match.");
                return;
            }
            if (parseInt(account_type) === 0) {
                alert("Account type is required.");
                return;
            }
            if (confirm("Are you sure you want to create this user?")) {
                var formData = new FormData();
                formData.append('user_id', user_id);
                formData.append('last_name', last_name);
                formData.append('first_name', first_name);
                formData.append('middle_name', middle_name);
                formData.append('address', address);
                formData.append('age', age);
                formData.append('email_address', email_address);
                formData.append('contact_number', contact_number);
                formData.append('username', username);
                formData.append('account_password', account_password);
                formData.append('account_password_confirm', account_password_confirm);
                formData.append('account_type', account_type);
                formData.append('accountid', accountid);
                formData.append('edit_user', 1);
                $.ajax({
                    url: 'pages/user_management_add_user.php',
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $("#tmp_user_add").html(data);
                        $("#tmp_user_add").css('opacity', '1');
                        document.getElementById("user_id").value = "";
                        document.getElementById("last_name").value = "";
                        document.getElementById("first_name").value = "";
                        document.getElementById("middle_name").value = "";
                        document.getElementById("address").value = "";
                        document.getElementById("age").value = "";
                        document.getElementById("email_address").value = "";
                        document.getElementById("contact_number").value = "";
                        document.getElementById("username").value = "";
                        document.getElementById("account_password").value = "";
                        document.getElementById("account_password_confirm").value = "";
                        document.getElementById("account_type").value = "0";
                    },
                    error: function() {
                        alert("Error occurred while creating the user.");
                    }
                });
            } else {
                alert("User creation canceled.");
            }
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
                    <i class="fas fa-user"></i> <span id="userRoleText"><?php echo $_SESSION['username']; ?></span>
                </div>
                <div class="user-role" style="margin-left:-20px; white-space: nowrap; overflow: visible; max-width: none; padding: 0 8px;">
                    <small>(<?php echo $_SESSION['account_type']; ?>)</small>
                </div>
                <button class="logout-btn" onclick="window.location.href='pages/logout.php'">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </div>
        </div>


        <nav id="navBar">
            <div class="logo-space">
                <div class="logo-container">
                    <img src="images/logo2.jpg" alt="Mary's Native Product Store Logo" class="logo">
                </div>
            </div>
            <div class="menu-items">
                <a href="javascript:void(0)" onclick="setActiveLink(this); ajax_fn('pages/dashboard','main_content')"><i class="fa-solid fa-gauge-high"></i><span>Dashboard</span></a>
                <a href="javascript:void(0)" onclick="setActiveLink(this); ajax_fn('pages/sales','main_content')"><i class="fa-solid fa-chart-line"></i><span>Sales</span></a>
                <a href="javascript:void(0)" onclick="setActiveLink(this); ajax_fn('pages/inventory','main_content')"><i class="fa-solid fa-boxes-stacked"></i><span>Inventory</span></a>
                <a href="javascript:void(0)" onclick="setActiveLink(this); ajax_fn('pages/user_management','main_content')"><i class="fa-solid fa-users-gear"></i><span>User Management</span></a>
                <a href="javascript:void(0)" onclick="setActiveLink(this); ajax_fn('pages/maintenance','main_content')"><i class="fa-solid fa-screwdriver-wrench"></i><span>Maintenance</span></a>
                <a href="javascript:void(0)" onclick="setActiveLink(this); ajax_fn('pages/reports','main_content')"><i class="fa-solid fa-file-lines"></i><span>Reports</span></a>
                <a href="javascript:void(0)" onclick="setActiveLink(this); ajax_fn('pages/notifications.php','main_content')"><i class="fa-solid fa-bell"></i><span>Notifications</span></a>
            </div>
        </nav>


        <div class="content" id="main_content">
            <?php include('pages/dashboard.php'); ?>
        </div>

        <div id="clock" style="position:fixed; right:10px; bottom:4px; padding:4px 10px; background:#fff; border:1px solid #d4c9b8; border-radius:5px; box-shadow:0 2px 5px rgba(0,0,0,0.1); font-size:13px; z-index:100;">Loading date & time...</div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Setup logic if needed
        });

        window.showModule = function(moduleId) {
            document.querySelectorAll('.module').forEach(mod => mod.style.display = 'none');
            document.getElementById(moduleId).style.display = 'block';

            document.querySelectorAll('.menu-items a').forEach(link => link.classList.remove('active'));
            const activeLink = [...document.querySelectorAll('.menu-items a')].find(link =>
                link.textContent.trim().toLowerCase() === moduleId.replace('Module', '').toLowerCase()
            );
            if (activeLink) activeLink.classList.add('active');
        };

        window.showModule('dashboardModule');
    </script>
</body>

</html>