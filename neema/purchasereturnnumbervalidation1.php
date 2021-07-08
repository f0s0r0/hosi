<?php
session_start();

include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly=date("Y-m-d");
$username = $_SESSION['username'];
$ipaddress = $_SERVER['REMOTE_ADDR'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

if (isset($_REQUEST["billnumber"])) { $billnumber = $_REQUEST["billnumber"]; } else { $billnumber = ""; }
//$billnumber=$_REQUEST["billnumber"];
$singlerecord = "";

$query2 = "select * from master_purchasereturn where billnumber = '$billnumber' and recordstatus <> 'DELETED' and companyanum = '$companyanum';";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_num_rows($exec2);

	if ($res2 == 0)
	{
		$singlerecord = $billnumber;
	}
	else
	{
//		$singlerecord = 'notempty';
		$singlerecord = '';
	}

echo $singlerecord;

?>
