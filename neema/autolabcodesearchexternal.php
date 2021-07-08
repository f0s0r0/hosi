<?php
session_start();
include ("db/db_connect.php");
$labsearch = $_REQUEST["labsearch"];

$locationcode=$_REQUEST['locationcode'];

//$medicinesearch = strtoupper($medicinesearch);
$searchresult3 = "";
$query3 = "select * from master_lab where itemcode = '$labsearch' AND location = '".$locationcode."' order by itemname";
$exec3 = mysql_query($query3) or die ("Error in Query2".mysql_error());
while ($res3 = mysql_fetch_array($exec3))
{
	$itemcode1 = $res3["itemcode"];
	$itemname1 = $res3["itemname"];
    $itemname1 = strtoupper($itemname1);
	
    $rateperunit1 = $res3["rateperunit"];
	
	
	if ($searchresult3 == '')
	{
	    $searchresult3 = ''.$itemcode1.'||'.$itemname1.'||'.$rateperunit1.'||';
	}
	else
	{
		$searchresult3 = $searchresult3.'||^||'.$itemcode1.'||'.$itemname1.'||'.$rateperunit1.'||';
	}
	
}
if ($searchresult3 != '')
{
  echo $searchresult3;
}
?>