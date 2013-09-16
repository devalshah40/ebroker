<?php
include"include/config.php";

if($_POST['id'])
{
$id=mysql_real_escape_string($_POST['id']);
$firstname=mysql_real_escape_string($_POST['firstname']);
echo $sql = "update clients set name='$firstname' where client_id='$id'";
mysql_query($sql);
}
?>