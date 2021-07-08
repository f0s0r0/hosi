<?php
session_start();
include ("db/db_connect.php");
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$mrp = '0.00';

if (isset($_REQUEST["itemcode"])) { $itemcode = $_REQUEST["itemcode"]; } else { $itemcode = ""; }
//$itemcode = $_REQUEST["itemcode"];
if (isset($_REQUEST["batchnumber"])) { $batchnumber = $_REQUEST["batchnumber"]; } else { $batchnumber = ""; }
$batchnumber = trim($batchnumber);
//echo $batchnumber = $_REQUEST["batchnumber"];
if (isset($_REQUEST["rateapplyfrom"])) { $rateapplyfrom = $_REQUEST["rateapplyfrom"]; } else { $rateapplyfrom = ""; }
//$rateapplyfrom = $_REQUEST["rateapplyfrom"];
if (isset($_REQUEST["customercode"])) { $customercode = $_REQUEST["customercode"]; } else { $customercode = ""; }
//$customercode = $_REQUEST["customercode"];
$i = 0;
$query2 = "select * from master_itempharmacy where itemcode = '$itemcode'";// and customerstatus = 'Active'";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$res2anum = $res2["auto_number"];
$unitname = $res2["unitname_abbreviation"];
$itemcode = $res2["itemcode"];
$itemname = $res2["itemname"];
$categoryname = $res2["categoryname"];
$description = $res2["description"];
$res2taxanum = $res2["taxanum"];

$rateperunit = $res2["rateperunit"];
$mrp = $rateperunit;

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
	//Copied from autoitemsearch2.php / Called from autoitemsearch2.js / Stock alert in quotation is pending work.



$query5 = "select * from purchase_details where itemcode = '$itemcode' and batchnumber = '$batchnumber'";
$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
$res5 = mysql_fetch_array($exec5);
$res5batchnumber = $res5['batchnumber'];

$batchname = $res5batchnumber;
	include ('autocompletestockbatch.php');
	$currentstock = $currentstock;
	
	if($currentstock > 0)
{
if ($res2anum != '')
{
	//echo $rateperunit.'||'.$unitname.'||'.$itemcode.'||'.$res4taxpercent.'||'.$subtotal.'||'.$totalamount.'||'.$itemname.'||'.$categoryname.'||'.$description.'||'.$res2taxanum;
}

if ($res2anum != '')
{
	echo $currentstock;
}

}
?>