<?php
session_start();
include ("db/db_connect.php");
$errmsg1 = '';
$errmsg2 = '';
$errmsg3 = '';

$query5 = "select * from master_employee where auto_number > '201'";
$exec5 = mysql_query($query5) or die(mysql_error());
while($res5 = mysql_fetch_array($exec5))
{
$usernam = $res5['username'];
$password = $res5['password'];
$password1 = base64_encode($password);

$query51 = "update master_employee set password ='$password1' where username='$usernam'";
$exec51 = mysql_query($query51) or die(mysql_error());
}


?>
