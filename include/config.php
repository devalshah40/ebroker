<?php
error_reporting(0);
if($_SERVER['SERVER_ADDR'] == '127.0.0.1')
{
	$db_host = "localhost";
	$db_user = "root";
	$db_pass = "";
	$db_name = "kalptraders";
}else{
	/*$db_host = "mysql1109.ixwebhosting.com";
	$db_user = "C338571_deval";
	$db_pass = "Shah1530Deva";
	$db_name = "C338571_ebroker";*/
	
	$db_host = "localhost";
	$db_user = "root";
	$db_pass = "";
	$db_name = "kalptraders";
}
$cn = mysql_connect($db_host,$db_user,$db_pass)or die("Database is down!");;
mysql_select_db($db_name,$cn)or die("Database not found!");
?>