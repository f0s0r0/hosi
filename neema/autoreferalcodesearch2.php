<?php
session_start();
include ("db/db_connect.php");
$referalsearch = $_REQUEST["referalsearch"];
$locationcode=$_REQUEST['locationcode'];
//$medicinesearch = strtoupper($medicinesearch);
$searchresult7 = "";
$query7 = "select * from master_doctor where doctorcode = '$referalsearch' AND locationcode = '".$locationcode."' order by doctorname";
$exec7 = mysql_query($query7) or die ("Error in Query2".mysql_error());
while ($res7 = mysql_fetch_array($exec7))
{
	$itemcode7 = $res7["doctorcode"];
	$itemname7 = $res7["doctorname"];
    $itemname7 = strtoupper($itemname7);
    $rateperunit7 = $res7["consultationfees"];
	
	if ($searchresult7 == '')
	{
	    $searchresult7 = ''.$itemcode7.'||'.$itemname7.'||'.$rateperunit7.'||';
	}
	else
	{
		$searchresult7 = $searchresult.'||^||'.$itemcode7.'||'.$itemname7.'||'.$rateperunit7.'||';
	}
	
}
if ($searchresult7 != '')
{
 echo $searchresult7;
}
?>