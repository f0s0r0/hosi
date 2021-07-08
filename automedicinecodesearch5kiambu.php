<?php
session_start();
include ("db/db_connect.php");
$medicinesearch = $_REQUEST["medicinesearch"];
$companyanum = $_SESSION['companyanum'];
$username = $_SESSION['username'];

//$medicinesearch = strtoupper($medicinesearch);
$searchresult2 = "";
$query2 = "select * from master_medicine where itemcode = '$medicinesearch' order by itemname";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
while ($res2 = mysql_fetch_array($exec2))
{
	$itemcode = $res2["itemcode"];
	$itemname = $res2["itemname"];
    $itemname = strtoupper($itemname);
    $rateperunit = $res2["rateperunit"];
	$costprice = $res2["purchaseprice"];
	$packagename = $res2["packagename"];
	$strength = $res2["roq"];
	$categoryname = $res2["categoryname"];
	
	$query231 = "select * from master_employeelocation where username='$username' and defaultstore='default'";
$exec231 = mysql_query($query231) or die(mysql_error());
$res231 = mysql_fetch_array($exec231);
$res7locationanum1 = $res231['locationcode'];

/*$query551 = "select * from master_location where auto_number='$res7locationanum1'";
$exec551 = mysql_query($query551) or die(mysql_error());
$res551 = mysql_fetch_array($exec551);*/
$location = $res231['locationname'];

$res7storeanum1 = $res231['storecode'];

$query751 = "select * from master_store where auto_number='$res7storeanum1'";
$exec751 = mysql_query($query751) or die(mysql_error());
$res751 = mysql_fetch_array($exec751);
$store = $res751['store'];
	
	$itemcode = $itemcode;
	$reorderquery1 = "select SUM(batch_quantity) as cum_quantity from transaction_stock where itemcode = '$itemcode' and batch_stockstatus='1' and locationcode = '$res7locationanum1'";
	$reorderexec1 = mysql_query($reorderquery1) or die ("Error in Query1".mysql_error());
	$reordernum1 = mysql_num_rows($reorderexec1);
	$reorderres1=mysql_fetch_array($reorderexec1);
	$currentstock = $reorderres1['cum_quantity'];	
	$currentstock = $currentstock;
	
	if ($searchresult2 == '')
	{
	    $searchresult2 = ''.$itemcode.'||'.$itemname.'||'.$costprice.'||'.$currentstock.'||'.$packagename.'||'.$categoryname.'||'.$strength.'||';
	}
	else
	{
		$searchresult2 = $searchresult2.'||^||'.$itemcode.'||'.$itemname.'||'.$costprice.'||'.$currentstock.'||'.$packagename.'||'.$categoryname.'||'.$strength.'||';
	}
	
}
if ($searchresult2 != '')
{
 echo $searchresult2;
}
?>