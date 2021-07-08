<?php
session_start();

include ("db/db_connect.php");
//include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly=date("Y-m-d");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$i=0;
$query23 = "select * from master_employee where username='$username'";
$exec23 = mysql_query($query23) or die(mysql_error());
$res23 = mysql_fetch_array($exec23);
$res7locationanum = $res23['location'];

$query55 = "select * from master_location where auto_number='$res7locationanum'";
$exec55 = mysql_query($query55) or die(mysql_error());
$res55 = mysql_fetch_array($exec55);
$location = $res55['locationname'];

$res7storeanum = $res23['store'];

$query75 = "select * from master_store where auto_number='$res7storeanum'";
$exec75 = mysql_query($query75) or die(mysql_error());
$res75 = mysql_fetch_array($exec75);
$store = $res75['store'];
//$financialyear = $_SESSION["financialyear"];

if (isset($_REQUEST["batch"])) { $batch = $_REQUEST["batch"]; } else { $batch = ""; }
if (isset($_REQUEST["itemcode"])) { $itemcode = $_REQUEST["itemcode"]; } else { $itemcode = ""; }
if (isset($_REQUEST["serial1"])) { $serial1 = $_REQUEST["serial1"]; } else { $serial1 = ""; }
//$billnumber=$_REQUEST["billnumber"];

$query2 = "select * from purchase_details where recordstatus = '' and batchnumber = '$batch' and itemcode='$itemcode'";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$expirydate = $res2['expirydate'];
$costprice = $res2['costprice'];

$batchname = $batch;
	include ('autocompletestockbatch.php');
	$currentstock = $currentstock;

echo $expirydate.'||'.$currentstock.'||'.$costprice.'||'.$serial1;

?>
