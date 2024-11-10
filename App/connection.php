<?php
error_reporting(0);
date_default_timezone_set('Asia/Colombo');

$now = date('Y-m-d H:i:s',time());

$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'warna';

$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);    
}

mysqli_query("set character_set_server='utf8'");
mysqli_query("set names 'utf8'");
?>