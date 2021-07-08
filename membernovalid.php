<?php
session_start();

include ("db/db_connect.php");
include ("includes/loginverify.php");

$insure = "";

if (isset($_REQUEST["membernos"])) { 

$memberno = $_REQUEST["membernos"]; 

$queryvalid = "select * from member_insurance where membernumber = '$memberno';";
$execvalid = mysql_query($queryvalid) or die ("Error in Query2".mysql_error());
$resvaild = mysql_fetch_array($execvalid);

$insure = $resvaild['insurance'];
$fname = $resvaild['firstname'];
$lname = $resvaild['lastname'];
$poilcy = $resvaild['policyholder'];

$values = $insure.'||'.$fname.' '.$lname.'||'.$poilcy;

echo $values;

}
?>