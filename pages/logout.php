<?php
include('../includes/init.php');
Audit($_SESSION['accountid'], 'Logout', 'Logout');
session_destroy();
session_write_close();
setcookie(session_name(), '', 0, '/');
header("location: ../");
