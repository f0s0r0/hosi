<?php
session_start();
include ("db/db_connect.php");
$medicinesearch = $_REQUEST["medicinesearch"];

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
	$formula = $res2['formula'];
	$strength = $res2['roq'];
	$genericname = $res2['genericname'];
	$pkg = $res2['pkg'];
	if ($searchresult2 == '')
	{
	    $searchresult2 = ''.$itemcode.'||'.$itemname.'||'.$rateperunit.'||'.$formula.'||'.$strength.'||'.$genericname.'||'.$pkg.'||';
	}
	else
	{
		$searchresult2 = $searchresult2.'||^||'.$itemcode.'||'.$itemname.'||'.$rateperunit.'||'.$formula.'||'.$strength.'||'.$genericname.'||'.$pkg.'||';
	}
	
}
if ($searchresult2 != '')
{
 echo $searchresult2;
}
?>