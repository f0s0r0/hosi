<?php
session_start();
include ("db/db_connect.php");
$radiologysearch = $_REQUEST["radiologysearch"];

$locationcode=$_REQUEST['locationcode'];

//$medicinesearch = strtoupper($medicinesearch);
$searchresult4 = "";
$query4 = "select * from master_radiology where itemcode = '$radiologysearch' AND locationcode = '".$locationcode."' order by itemname";
$exec4 = mysql_query($query4) or die ("Error in Query2".mysql_error());
while ($res4 = mysql_fetch_array($exec4))
{
	$itemcode4 = $res4["itemcode"];
	$itemname4 = $res4["itemname"];
    $itemname4 = strtoupper($itemname4);
 
    $rateperunit4 = $res4["rateperunit"];
	
	
	if ($searchresult4 == '')
	{
	    $searchresult4 = ''.$itemcode4.'||'.$itemname4.'||'.$rateperunit4.'||';
	}
	else
	{
		$searchresult4 = $searchresult.'||^||'.$itemcode4.'||'.$itemname4.'||'.$rateperunit4.'||';
	}
	
}
if ($searchresult4 != '')
{
 echo $searchresult4;
}
?>