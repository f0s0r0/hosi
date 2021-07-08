<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$financialyear = $_SESSION["financialyear"];

$task = $_REQUEST['task'];
$anum = $_REQUEST['anum'];

if ($task == 'delete' && $anum != '')
{
	$query19 = "select * from master_purchasereturn where auto_number = '$anum' and companyanum = '$companyanum'";// and financialyear = '$financialyear'";
	$exec19 = mysql_query($query19) or die ("Error in Query19".mysql_error());
	while ($res19 = mysql_fetch_array($exec19))
	{
		$res19anum = $res19["auto_number"];
		$delbillnumber = $res19['billnumber'];
		
		$query15 = "update master_purchasereturn set recordstatus = 'DELETED' where billnumber = '$delbillnumber' and companyanum = '$companyanum'";// and financialyear = '$financialyear'";
		$exec15 = mysql_query($query15) or die ("Error in Query15".mysql_error());
	
		$query16 = "update purchasereturn_details set recordstatus = 'DELETED' where billnumber = '$delbillnumber' and companyanum = '$companyanum'";// and financialyear = '$financialyear'";
		$exec16 = mysql_query($query16) or die ("Error in Query16".mysql_error());
	
		$query17 = "update purchasereturn_tax set recordstatus = 'DELETED' where billnumber = '$delbillnumber' and companyanum = '$companyanum'";// and financialyear = '$financialyear'";
		$exec17 = mysql_query($query17) or die ("Error in Query17".mysql_error());
	
		$query18 = "update master_transactionpharmacy set recordstatus = 'DELETED' where transactionmodule = 'PURCHASE' and billnumber = '$delbillnumber' and companyanum = '$companyanum'";// and financialyear = '$financialyear'";
		$exec18 = mysql_query($query18) or die ("Error in Query18".mysql_error());
		
		$query20 = "update master_stock set recordstatus='DELETED' where transactionmodule = 'PURCHASE' and billnumber = '$delbillnumber' and companyanum = '$companyanum'";// and financialyear = '$financialyear'";
		$exec20=mysql_query($query20) or die("Error in Query19".mysql_error());

	}
}

header ("location:purchasereturnreport1.php?task=deleted");

?>