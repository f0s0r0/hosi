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
	$locationcode = $_REQUEST['locationcode'];
	
	$query5 = "select * from master_location where locationcode = '$locationcode'";
	$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
	$res5 = mysql_fetch_array($exec5);
	$locationname = $res5['locationname'];
	
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
			
			$query2 = "select * from master_accountname where id = '$suppliercode'";
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			$res2 = mysql_fetch_array($exec2);
			$suppliername = $res2['accountname'];
			
			//$query3 = "update master_itemtosupplier set recordstatus = 'deleted' where itemcode = '$itemcode'";
			//$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
			$query3 = "select * from master_itemtosupplier where locationcode = '$locationcode' and suppliercode = '$suppliercode' and itemcode = '$itemcode'";
			$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
			$rows3 = mysql_num_rows($exec3);
			if($rows3 == 0)
			{
			$query4 = "insert into master_itemtosupplier (itemcode, itemname, suppliercode, suppliername, recordupdate, username, ipaddress, locationname, locationcode) 
			values ('$itemcode', '$itemname', '$suppliercode', '$suppliername', '$recordupdate', '$username', '$ipaddress','$locationname', '$locationcode')";
			$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
			}
		}
		//*/
	}
}

header ("location:additemtosupplier1.php?st=success");

?>