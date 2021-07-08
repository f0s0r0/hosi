<?php
session_start();
include ("db/db_connect.php");
$servicessearch = $_REQUEST["servicessearch"];

$locationcode=$_REQUEST['locationcode'];
$subtype=$_REQUEST['subtype'];

//$medicinesearch = strtoupper($medicinesearch);
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
   
    $rateperunit5 = $res5["rateperunit"];
	
	
	
	if ($searchresult5 == '')
	{
	    $searchresult5 = ''.$itemcode5.'||'.$itemname5.'||'.$rateperunit5.'||';
	}
	else
	{
		$searchresult5 = $searchresult5.'||^||'.$itemcode5.'||'.$itemname5.'||'.$rateperunit5.'||';
	}
	
}
if ($searchresult5 != '')
{
 echo $searchresult5;
}
?>