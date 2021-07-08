<?php
session_start();
include ("db/db_connect.php");
$medicinenamesearch = $_REQUEST["medicinenamesearch"];
$searchresult41 = "";
$query41="select * from master_medicine where itemname like '%$medicinenamesearch%' order by itemname";
$exec41=mysql_query($query41) or die(mysql_error());
while($res41=mysql_fetch_array($exec41))
{
	$itemcode41 = $res41["itemcode"];
	$itemname41 = $res41["itemname"];
    $itemname41 = strtoupper($itemname41);
    $rateperunit41 = $res41["rateperunit"];
	
	if ($searchresult41 == '')
	{
	    $searchresult41 = ''.$itemcode41.'||'.$itemname41.'||'.$rateperunit41.'||';
	}
	else
	{
		$searchresult41 = $searchresult41.'||^||'.$itemcode41.'||'.$itemname41.'||'.$rateperunit41.'||';
	}
	
}
if ($searchresult41 != '')
{
 echo $searchresult41;
}
?>

