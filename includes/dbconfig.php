<?php
echo $_SERVER['REQUEST_URI'];
error_reporting(E_ALL);
$hostname = 'localhost';
$dbname   = 'inventory';
$username = 'root';
$password = '';
global $db_connection;
$db_connection = mysqli_connect($hostname, $username, $password) or die('Connection to Database Server is failed, perhaps the service is down!');
$db = mysqli_select_db($db_connection, $dbname);
include('function.php');
