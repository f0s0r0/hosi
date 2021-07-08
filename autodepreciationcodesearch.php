<?php
session_start();
include ("db/db_connect.php");
$depreciationsearch = $_REQUEST["depreciationsearch"];

$searchresult3 = "";
$query3 = "select * from master_fixedassets where id = '$depreciationsearch' order by fixedassets";
$exec3 = mysql_query($query3) or die ("Error in Query2".mysql_error());
while ($res3 = mysql_fetch_array($exec3))
{
	$fixedassets = $res3["fixedassets"];
	$category = $res3['category'];
	
	$query31 = "select * from master_assetcategory where auto_number = '$category'";
	$exec31 = mysql_query($query31) or die(mysql_error());
	$res31 = mysql_fetch_array($exec31);
	$categoryname = $res31['category'];
	$assetvalue = $res3['assetvalue'];
	$assetlife = $res3['assetlife'];
	$salvagevalue = $res3['salvagevalue'];
	$salvageamount = ($assetvalue * $salvagevalue)/100;
	$salvageamount = number_format($salvageamount,2,'.','');	
	$depreciation = ($assetvalue - $salvageamount)/$assetlife;
	$depreciation = number_format($depreciation,2,'.','');	
	
	if ($searchresult3 == '')
	{
	    $searchresult3 = ''.$fixedassets.'||'.$categoryname.'||'.$assetvalue.'||'.$assetlife.'||'.$salvageamount.'||'.$depreciation.'||'.$depreciationsearch.'||';
	}
	else
	{
		$searchresult3 = $searchresult3.'||^||'.$fixedassets.'||'.$categoryname.'||'.$assetvalue.'||'.$assetlife.'||'.$salvageamount.'||'.$depreciation.'||'.$depreciationsearch.'||';
	}
	
}
if ($searchresult3 != '')
{
 echo $searchresult3;
}
?>