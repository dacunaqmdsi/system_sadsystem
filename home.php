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
    <!-- FontAwesome (only one latest version) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Select2 (optional, if you're using it) -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>

    <!-- Your CSS -->
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/styles.css" />

    <style>
        html,
        body {
            overflow-x: hidden;
        }

        /* Example: General active/hover styling for menu items */
        .menu-items a.active,
        .menu-items a:hover {
            /* background-color: #1f2937; */
            /* Example hover/active bg color */
            color: #fff;
        }

        /* Prevent Dashboard link from receiving active/hover style */
        .menu-items a.no-active,
        .menu-items a.no-active:hover,
        .menu-items a.no-active.active {
            background-color: transparent !important;
            color: inherit !important;
            cursor: pointer;
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


        function submenu(id) {
            switch (id) {
                case 1:
                    ajax_new('customer/customer.php', 'tmp_content');
                    break;
                case 2:
                    ajax_new_to_load('pages/orders.php', 'tmp_content');
                    break;
                case 3:
                    ajax_new_without_search('pages/inventory_product.php', 'tmp_content');
                    break;

            }
        }


        function add_edit_category(categoryid = null) {
            var category = document.getElementById('category').value.trim();
            if (!category) {
                alert("Please input category");
                return;
            }

            if (confirm(categoryid ? "Update this category?" : "Create this category?")) {
                var formData = new FormData();
                formData.append('category', category);
                if (categoryid) {
                    formData.append('edit_category', 1);
                    formData.append('categoryid', categoryid);
                } else {
                    formData.append('add_category', 1);
                }

                $.ajax({
                    url: 'submenu/category.php',
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $("#tmp_content").html(data);
                        $("#tmp_content").css('opacity', '1');
                        document.getElementById("category").value = "";
                    },
                    error: function() {
                        alert("Error occurred while saving the category.");
                    }
                });
            }
        }

        function add_edit_subcategory(subcategoryid = null) {
            var subcategory = document.getElementById('subcategory').value.trim();
            if (!subcategory) {
                alert("Please input subcategory");
                return;
            }

            if (confirm(subcategoryid ? "Update this subcategory?" : "Create this subcategory?")) {
                var formData = new FormData();
                formData.append('subcategory', subcategory);
                if (subcategoryid) {
                    formData.append('edit_subcategory', 1);
                    formData.append('subcategoryid', subcategoryid);
                } else {
                    formData.append('add_subcategory', 1);
                }

                $.ajax({
                    url: 'submenu/subcategory.php',
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $("#tmp_content").html(data);
                        $("#tmp_content").css('opacity', '1');
                        document.getElementById("subcategory").value = "";
                    },
                    error: function() {
                        alert("Error occurred while saving the subcategory.");
                    }
                });
            }
        }


        function add_edit_size(sizesid = null) {
            var size = document.getElementById('size').value.trim();
            if (!size) {
                alert("Please input size");
                return;
            }

            if (confirm(sizesid ? "Update this size?" : "Create this size?")) {
                var formData = new FormData();
                formData.append('size', size);
                if (sizesid) {
                    formData.append('edit_size', 1);
                    formData.append('sizesid', sizesid);
                } else {
                    formData.append('add_size', 1);
                }

                $.ajax({
                    url: 'submenu/sizes.php',
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $("#tmp_content").html(data);
                        $("#tmp_content").css('opacity', '1');
                        document.getElementById("size").value = "";
                    },
                    error: function() {
                        alert("Error occurred while saving the size.");
                    }
                });
            }
        }


        function add_edit_madefrom(madefromid = null) {
            var madefrom = document.getElementById('madefrom').value.trim();
            if (!madefrom) {
                alert("Please input 'Made From' value");
                return;
            }

            if (confirm(madefromid ? "Update this entry?" : "Create this entry?")) {
                var formData = new FormData();
                formData.append('madefrom', madefrom);
                if (madefromid) {
                    formData.append('edit_madefrom', 1);
                    formData.append('madefromid', madefromid);
                } else {
                    formData.append('add_madefrom', 1);
                }

                $.ajax({
                    url: 'submenu/madefrom.php',
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $("#tmp_content").html(data);
                        $("#tmp_content").css('opacity', '1');
                        document.getElementById("madefrom").value = "";
                    },
                    error: function() {
                        alert("Error occurred while saving the entry.");
                    }
                });
            }
        }

        function add_edit_cooperative(madefromid = null) {
            var madefrom = document.getElementById('madefrom').value.trim();
            if (!madefrom) {
                alert("Please input 'Made From' value");
                return;
            }

            if (confirm(madefromid ? "Update this entry?" : "Create this entry?")) {
                var formData = new FormData();
                formData.append('madefrom', madefrom);
                if (madefromid) {
                    formData.append('edit_madefrom', 1);
                    formData.append('madefromid', madefromid);
                } else {
                    formData.append('add_madefrom', 1);
                }

                $.ajax({
                    url: 'submenu/madefrom.php',
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $("#tmp_content").html(data);
                        $("#tmp_content").css('opacity', '1');
                        document.getElementById("madefrom").value = "";
                    },
                    error: function() {
                        alert("Error occurred while saving the entry.");
                    }
                });
            }
        }

        function add_edit_cooperative(cooperativeid = null) {
            var cooperative = document.getElementById('cooperative').value.trim();
            if (!cooperative) {
                alert("Please input 'Cooperative' value");
                return;
            }

            if (confirm(cooperativeid ? "Update this entry?" : "Create this entry?")) {
                var formData = new FormData();
                formData.append('cooperative', cooperative);
                if (cooperativeid) {
                    formData.append('edit_cooperative', 1);
                    formData.append('cooperativeid', cooperativeid);
                } else {
                    formData.append('add_cooperative', 1);
                }

                $.ajax({
                    url: 'submenu/cooperative.php',
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $("#tmp_content").html(data);
                        $("#tmp_content").css('opacity', '1');
                        document.getElementById("cooperative").value = "";
                    },
                    error: function() {
                        alert("Error occurred while saving the entry.");
                    }
                });
            }
        }


        function add_edit_storage(storageid = null) {
            var storage = document.getElementById('storage').value.trim();
            if (!storage) {
                alert("Please input 'Storage' value");
                return;
            }

            if (confirm(storageid ? "Update this entry?" : "Create this entry?")) {
                var formData = new FormData();
                formData.append('storage', storage);
                if (storageid) {
                    formData.append('edit_storage', 1);
                    formData.append('storageid', storageid);
                } else {
                    formData.append('add_storage', 1);
                }

                $.ajax({
                    url: 'submenu/storage.php',
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $("#tmp_content").html(data);
                        $("#tmp_content").css('opacity', '1');
                        document.getElementById("storage").value = "";
                    },
                    error: function() {
                        alert("Error occurred while saving the entry.");
                    }
                });
            }
        }

        function add_edit_unit(unitid = null) {
            var unit = document.getElementById('unit').value.trim();
            if (!unit) {
                alert("Please input 'Unit' value");
                return;
            }

            if (confirm(unitid ? "Update this entry?" : "Create this entry?")) {
                var formData = new FormData();
                formData.append('unit', unit);
                if (unitid) {
                    formData.append('edit_unit', 1);
                    formData.append('unitid', unitid);
                } else {
                    formData.append('add_unit', 1);
                }

                $.ajax({
                    url: 'submenu/unit.php',
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $("#tmp_content").html(data);
                        $("#tmp_content").css('opacity', '1');
                        document.getElementById("unit").value = "";
                    },
                    error: function() {
                        alert("Error occurred while saving the entry.");
                    }
                });
            }
        }

        function insert_inventory() {
            // Store values in variables
            const product_id = document.getElementById('product_id').value.trim();
            const product_name = document.getElementById('product_name').value.trim();
            const color = document.getElementById('color').value.trim();
            const categoryid = document.getElementById('categoryid').value;
            const subcategoryid = document.getElementById('subcategoryid').value;
            const sizesid = document.getElementById('sizesid').value;
            const madefromid = document.getElementById('madefromid').value;
            const cooperativeid = document.getElementById('cooperativeid').value;
            const qty_available = document.getElementById('qty_available').value;
            const reorder_threshold = document.getElementById('reorder_threshold').value;
            const storageid = document.getElementById('storageid').value;
            const cost_price = document.getElementById('cost_price').value;
            const retail_price = document.getElementById('retail_price').value;
            const unitid = document.getElementById('unitid').value;
            const current_stock = document.getElementById('current_stock').value;
            const new_stock = document.getElementById('new_stock').value;
            const total_stock = document.getElementById('total_stock').value;

            // // Sample validation
            // if (!product_id || !product_name || !categoryid || !subcategoryid || !unitid) {
            //     alert("Please fill in all required fields.");
            //     return;
            // }

            // If validation passes, create FormData
            const formData = new FormData();
            formData.append('product_id', product_id);
            formData.append('product_name', product_name);
            formData.append('color', color);
            formData.append('categoryid', categoryid);
            formData.append('subcategoryid', subcategoryid);
            formData.append('sizesid', sizesid);
            formData.append('madefromid', madefromid);
            formData.append('cooperativeid', cooperativeid);
            formData.append('qty_available', qty_available);
            formData.append('reorder_threshold', reorder_threshold);
            formData.append('storageid', storageid);
            formData.append('cost_price', cost_price);
            formData.append('retail_price', retail_price);
            formData.append('unitid', unitid);
            formData.append('current_stock', current_stock);
            formData.append('new_stock', new_stock);
            formData.append('total_stock', total_stock);
            formData.append('add_inventory', 1);


            if (confirm("Are you sure you want to create this user?")) {
                $.ajax({
                    url: 'pages/inventory.php',
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $("#main_content").html(data);
                        $("#main_content").css('opacity', '1');
                        // document.getElementById("unit").value = "";
                    },
                    error: function() {
                        alert("Error occurred while saving the entry.");
                    }
                });
            }

        }

        function update_inventory(inventory_id) {
            // Collect values from the form fields
            const product_id = document.getElementById('product_id').value.trim();
            const product_name = document.getElementById('product_name').value.trim();
            const color = document.getElementById('color').value.trim();
            const categoryid = document.getElementById('categoryid').value;
            const subcategoryid = document.getElementById('subcategoryid').value;
            const sizesid = document.getElementById('sizesid').value;
            const madefromid = document.getElementById('madefromid').value;
            const cooperativeid = document.getElementById('cooperativeid').value;
            const qty_available = document.getElementById('qty_available').value;
            const reorder_threshold = document.getElementById('reorder_threshold').value;
            const storageid = document.getElementById('storageid').value;
            const cost_price = document.getElementById('cost_price').value;
            const retail_price = document.getElementById('retail_price').value;
            const unitid = document.getElementById('unitid').value;
            const current_stock = document.getElementById('current_stock').value;
            const new_stock = document.getElementById('new_stock').value;
            const total_stock = document.getElementById('total_stock').value;

            // Create FormData object for the update request
            const formData = new FormData();
            formData.append('inventory_id', inventory_id); // Append inventory ID
            formData.append('product_id', product_id);
            formData.append('product_name', product_name);
            formData.append('color', color);
            formData.append('categoryid', categoryid);
            formData.append('subcategoryid', subcategoryid);
            formData.append('sizesid', sizesid);
            formData.append('madefromid', madefromid);
            formData.append('cooperativeid', cooperativeid);
            formData.append('qty_available', qty_available);
            formData.append('reorder_threshold', reorder_threshold);
            formData.append('storageid', storageid);
            formData.append('cost_price', cost_price);
            formData.append('retail_price', retail_price);
            formData.append('unitid', unitid);
            formData.append('current_stock', current_stock);
            formData.append('new_stock', new_stock);
            formData.append('total_stock', total_stock);
            formData.append('update_inventory', 1); // Indicate update operation

            // Confirmation before proceeding with the update
            if (confirm("Are you sure you want to update this inventory item?")) {
                $.ajax({
                    url: 'pages/inventory.php', // The PHP file handling the request
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $("#main_content").html(data); // Update the content on success
                        $("#main_content").css('opacity', '1');

                    },
                    error: function() {
                        alert("Error occurred while updating the inventory.");
                    }
                });
            }
        }

        function insert_price_inv() {
            var inventory_id = document.getElementById('inventory_id').value;
            var price = document.getElementById('price').value;
            var effective_date = document.getElementById('effective_date').value;
            var effective_date_to = document.getElementById('effective_date_to').value;

            // // Sample validation
            if (!inventory_id || !price || !effective_date || !effective_date_to) {
                alert("Please fill in all required fields.");
                return;
            }

            const formData = new FormData();
            formData.append('inventory_id', inventory_id);
            formData.append('price', price);
            formData.append('effective_date', effective_date);
            formData.append('effective_date_to', effective_date_to);
            formData.append('add_inventory', 1);
            if (confirm("Are you sure you want to add this price?")) {
                $.ajax({
                    url: 'pages/maintenance_prices.php', // The PHP file handling the request
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $("#main_content").html(data); // Update the content on success
                        $("#main_content").css('opacity', '1');

                    },
                    error: function() {
                        alert("Error occurred while updating the inventory.");
                    }
                });
            }
        }

        function update_price_inv(price_id) {
            var inventory_id = document.getElementById('inventory_id').value;
            var price = document.getElementById('price').value;
            var effective_date = document.getElementById('effective_date').value;
            var effective_date_to = document.getElementById('effective_date_to').value;

            // // Sample validation
            if (!inventory_id || !price || !effective_date || !effective_date_to) {
                alert("Please fill in all required fields.");
                return;
            }

            const formData = new FormData();
            formData.append('inventory_id', inventory_id);
            formData.append('price_id_modify', price_id);
            formData.append('price', price);
            formData.append('effective_date', effective_date);
            formData.append('effective_date_to', effective_date_to);
            formData.append('edit_inventory', 1);
            if (confirm("Are you sure you want to update this price?")) {
                $.ajax({
                    url: 'pages/maintenance_prices.php', // The PHP file handling the request
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $("#main_content").html(data); // Update the content on success
                        $("#main_content").css('opacity', '1');
                        document.getElementById("inventory_id").value = "";
                        document.getElementById("price").value = "";
                        document.getElementById("effective_date").value = "";
                        document.getElementById("effective_date_to").value = "";

                    },
                    error: function() {
                        alert("Error occurred while updating the inventory.");
                    }
                });
            }
        }

        function order_it(inventory_id) {
            const qty = document.getElementById("qty").value;
            const order_id = document.getElementById("order_id").value;
            const puhunan = document.getElementById("puhunan").value;
            const product_name = document.getElementById("product_name").value;
            const effective_price = document.getElementById("effective_price").value;

            if (!qty || qty == 0) {
                alert("Please input QTY || Quantity must be greater than zero.");
                return;
            }

            const formData = new FormData();
            formData.append('qty', qty);
            formData.append('order_id', order_id);
            formData.append('puhunan', puhunan);
            formData.append('effective_price', effective_price);
            formData.append('product_name', product_name);
            formData.append('inventory_id_edit', inventory_id);
            // console.log(formData);
            $.ajax({
                url: 'pages/sales_order_it.php', // The PHP file handling the request
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    $("#orderItems").html(data); // Update the content on success
                    $("#orderItems").css('opacity', '1');
                    document.getElementById("product_id").value = "";
                    document.getElementById("categoryid").value = "";
                    document.getElementById("subcategoryid").value = "";
                    document.getElementById("sizesid").value = "";
                    document.getElementById("unitid").value = "";
                    document.getElementById("qty").value = "";

                },
                error: function() {
                    alert("Error occurred while updating the inventory.");
                }
            });
        }

        function saveOrder() {
            var payment_method = document.getElementById('payment_method').value;

            // Check if the payment method is selected
            if (!payment_method) {
                alert("Please select payment method");
                return;
            }

            // Confirm before proceeding
            var confirmation = confirm("Are you sure you want to process this?");
            if (!confirmation) {
                return; // Stop the function if the user cancels
            }

            const formData = new FormData();
            formData.append('payment_method', payment_method);

            $.ajax({
                url: 'pages/sales_order_it.php', // The PHP file handling the request
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    $("#orderItems").html(data); // Update the content on success
                    $("#orderItems").css('opacity', '1');
                    // alert("Successfully Processed Request");
                },
                error: function() {
                    alert("Error occurred while updating the inventory.");
                }
            });
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

        <script>
            function setActiveLink(el) {
                const links = document.querySelectorAll('a[onclick*="ajax_fn"]');
                links.forEach(link => link.classList.remove('active'));
                el.classList.add('active');
            }
        </script>

        <nav id="navBar">
            <div class="logo-space">
                <div class="logo-container">
                    <img src="images/logo2.jpg" alt="Mary's Native Product Store Logo" class="logo">
                </div>
            </div>
            <div class="menu-items">
                <a href="javascript:void(0)" class="no-active" onclick="location.reload();">
                    <i class="fa-solid fa-gauge-high"></i><span>Dashboard</span>
                </a>

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