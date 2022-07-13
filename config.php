<?php 
$db_server = '{{MASUKIN SERVER}}';
$db_port = '{{MASUKIN PORT}}';
$db_username = '{{MASUKIN USERNAME}}';
$db_password = '{{MASUKIN PASSWORD}}';
$db_name = '{{MASUKIN DB}}';

$conn = pg_connect("host=$db_server port=$db_port dbname=$db_name user=$db_username password=$db_password");
session_start();
// error_reporting(0);

?>