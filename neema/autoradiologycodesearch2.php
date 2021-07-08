<?php
session_start();
include ("db/db_connect.php");
$radiologysearch = $_REQUEST["radiologysearch"];
$patienttypesearch = $_REQUEST['patienttypesearch'];
$varpaymenttype = $_REQUEST['varpaymenttype'];
$subtype = $_REQUEST['subtype'];

$locationcode = $_REQUEST['locationcode'];
//$medicinesearch = strtoupper($medicinesearch);
$searchresult4 = "";
$query14 = "select * from master_subtype where subtype = '$subtype' order by subtype";
$exec14 = mysql_query($query14) or die ("Error in Query14".mysql_error());
$res14 = mysql_fetch_array($exec14);
$tablename = $res14['radtemplate'];
if($tablename == '')
{
  $tablename = 'master_radiology';
}

$query4 = "select * from $tablename where itemcode = '$radiologysearch' AND locationcode = '".$locationcode."' order by itemname";
$exec4 = mysql_query($query4) or die ("Error in Query2".mysql_error());
while ($res4 = mysql_fetch_array($exec4))
{
	$itemcode4 = $res4["itemcode"];
	$itemname4 = $res4["itemname"];
    $itemname4 = strtoupper($itemname4);
	$pkg = $res4['pkg'];
	$ipmarkup = '0';
   /*if($varpaymenttype == 'INSURANCE')
	{
    $rateperunit4 = $res4["rate2"];
	}
	else if($varpaymenttype == 'MICRO INSURANCE')
	{
	$rateperunit4 = $res4["rate3"];
	}
	else
	{*/
	$rateperunit4 = $res4["rateperunit"];
	/*}*/ 
	
	if ($searchresult4 == '')
	{
	    $searchresult4 = ''.$itemcode4.'||'.$itemname4.'||'.$rateperunit4.'||'.$pkg.'||'.$ipmarkup.'||';
	}
	else
	{
		$searchresult4 = $searchresult.'||^||'.$itemcode4.'||'.$itemname4.'||'.$rateperunit4.'||'.$pkg.'||'.$ipmarkup.'||';
	}
	
}
if ($searchresult4 != '')
{
 echo $searchresult4;
}
?>