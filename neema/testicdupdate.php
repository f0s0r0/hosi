<?php
session_start();
include ("db/db_connect.php");
$errmsg1 = '';
$errmsg2 = '';
$errmsg3 = '';



	
$query1 = "select * from consultation_icd where age='0'";
$exec1 = mysql_query($query1) or die(mysql_error());
while($res1=mysql_fetch_array($exec1))
{
$visitcode = $res1['patientvisitcode'];

$query11 = "select * from master_visitentry where visitcode='$visitcode'";
$exec11 = mysql_query($query11) or die(mysql_error());
$res11 = mysql_fetch_array($exec11);
$age = $res11['age'];

$query12 = "update consultation_icd set age='$age' where patientvisitcode='$visitcode'";
$exec12 = mysql_query($query12) or die(mysql_error());

}	


?>

