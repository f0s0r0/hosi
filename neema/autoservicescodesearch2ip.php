<?php
session_start();
include ("db/db_connect.php");
$servicessearch = $_REQUEST["servicessearch"];
$patienttypesearch = $_REQUEST['patienttypesearch'];
$varpaymenttype = $_REQUEST['varpaymenttype'];
//$medicinesearch = strtoupper($medicinesearch);
$locationcode = $_REQUEST['locationcode'];
$subtype = $_REQUEST['subtype'];

$searchresult5 = "";
$query15 = "select * from master_subtype where subtype = '$subtype' order by subtype";
$exec15 = mysql_query($query15) or die ("Error in Query15".mysql_error());
$res15 = mysql_fetch_array($exec15);
$tablename = $res15['sertemplate'];
if($tablename == '')
{
  $tablename = 'master_services';
}
$query5 = "select * from $tablename where itemcode = '$servicessearch' AND locationcode = '".$locationcode."' order by itemname";
$exec5 = mysql_query($query5) or die ("Error in Query2".mysql_error());
while ($res5 = mysql_fetch_array($exec5))
{
	$itemcode5 = $res5["itemcode"];
	$itemname5 = $res5["itemname"];
    $itemname5 = strtoupper($itemname5);
	$ipmarkup = '0'; 
	$pkg = $res5['pkg'];
  /* if($varpaymenttype == 'INSURANCE')
	{
    $rateperunit5 = $res5["rate2"];
	}
	else if($varpaymenttype == 'MICRO INSURANCE')
	{
	 $rateperunit5 = $res5["rate3"];
	}
	else
	{*/
	$rateperunit5 = $res5["rateperunit"];
	$baseunit5 = $res5["baseunit"];
	$incrementalquantity5 = $res5["incrementalquantity"];
	$incrementalrate5 = $res5["incrementalrate"];
	$slab5 = $res5["slab"];
	$ipmarkup = $res5['ipmarkup'];
	/*}*/
	
	if ($searchresult5 == '')
	{
	    $searchresult5 = ''.$itemcode5.'||'.$itemname5.'||'.$rateperunit5.'||'.$baseunit5.'||'.$incrementalquantity5.'||'.$incrementalrate5.'||'.$slab5.'||'.$pkg.'||'.$ipmarkup.'||';
	}
	else
	{
		$searchresult5 = $searchresult5.'||^||'.$itemcode5.'||'.$itemname5.'||'.$rateperunit5.'||'.$baseunit5.'||'.$incrementalquantity5.'||'.$incrementalrate5.
		'||'.$slab5.'||'.$pkg.'||'.$ipmarkup.'||';
	}
	
}
if ($searchresult5 != '')
{
 echo $searchresult5;
}
?>