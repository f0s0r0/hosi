<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$rateperunit = "0";
$purchaseprice = "0";
$checkboxnumber = '';
$recordupdate = date('Y-m-d H:i:s');

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
	if (isset($_POST["checkboxcount"])) { $checkboxcount = $_POST["checkboxcount"]; } else { $checkboxcount = ""; }
	$suppliercode = $_REQUEST['suppliercode'];
	$suppliername = $_REQUEST['suppliercoa'];
	for ($i=1;$i<=$checkboxcount;$i++)
	{
		//$itemcode = $_REQUEST['checkbox'.$i];
		if (isset($_POST['checkbox'.$i])) { $itemcode = $_POST['checkbox'.$i]; } else { $itemcode = ""; }
		//echo $itemcode;
		///*
		if ($itemcode != '')
		{
			$query1 = "select * from master_itempharmacy where itemcode = '$itemcode'";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			$res1 = mysql_fetch_array($exec1);
			$itemname = $res1['itemname'];
			
			
			$query3 = "update pharma_insurance set recordstatus = 'deleted' where itemcode = '$itemcode'";
			$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
			
			$query4 = "insert into pharma_insurance (itemcode, itemname, code, accountname, recordupdate, username, ipaddress) 
			values ('$itemcode', '$itemname', '$suppliercode', '$suppliername', '$recordupdate', '$username', '$ipaddress')";
			$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		}
		//*/
	}
}

header ("location:pharmainsurance.php?st=success");

?>