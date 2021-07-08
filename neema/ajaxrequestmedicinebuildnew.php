<?php
session_start();
include ("db/db_connect.php");
$companyanum = $_SESSION['companyanum'];
$username = $_SESSION['username'];

$docno = $_SESSION['docno'];
$action = $_REQUEST['action'];
$a_json = array();
$a_json_row = array();
$stringbuild1 = "";


if($action=='medicinesearch')
{
	$searchmedicinename1 = $_REQUEST['term'];
	$typetransfer = $_REQUEST['typetransfer'];
	$query222 = "select itemcode,itemname from master_medicine where itemname like '%$searchmedicinename1%' and status <> 'Deleted' and transfertype='$typetransfer' limit 0,10";
	$exec222 = mysql_query($query222) or die ("Error in Query2".mysql_error());
	while ($res222 = mysql_fetch_array($exec222))
	{
		$res2itemcode = $res222['itemcode'];
		$res2medicine = $res222['itemname'];
		$itemcode = $res2itemcode;
		
		/*$querycumstock2 = "select sum(batch_quantity) as cum_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$res7locationanum' and storecode='$storecode'";
		$execcumstock2 = mysql_query($querycumstock2) or die ("Error in CumQuery2".mysql_error());
		$rescumstock2 = mysql_fetch_array($execcumstock2);
		$cum_quantity = $rescumstock2["cum_quantity"];
		$currentstock=intval($cum_quantity);
		$currentstock = $currentstock;*/
			
		$res2medicine = addslashes($res2medicine);
	
		$res2medicine = strtoupper($res2medicine);
		
		$res2medicine = trim($res2medicine);
		
		$res2medicine = preg_replace('/,/', ' ', $res2medicine); // To avoid comma from passing on to ajax url.
		$a_json_row["itemcode"] = $res2itemcode;
		
		$a_json_row["value"] = trim($res2medicine);
		$a_json_row["label"] = trim($res2itemcode).'#'.$res2medicine;
		array_push($a_json, $a_json_row);
		
	}
	
	echo json_encode($a_json);
}
else if($action=='medicineqty')
{
	$storecode = $_REQUEST["storecode"];
	$location = $_REQUEST["location"];
	$itemcode = $_REQUEST["itemcode"];
	 $querycumstock2 = "select sum(batch_quantity) as cum_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$location' and storecode='$storecode' and batchnumber in(select batchnumber from purchase_details where expirydate>now() and itemcode ='$itemcode')";
	$execcumstock2 = mysql_query($querycumstock2) or die ("Error in CumQuery2".mysql_error());
	$rescumstock2 = mysql_fetch_array($execcumstock2);
	$cum_quantity = $rescumstock2["cum_quantity"];
	$currentstock=intval($cum_quantity);
	echo $currentstock = $currentstock;
}

?>