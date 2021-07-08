<?php
session_start();
include ("db/db_connect.php");
$medicinesearch = $_REQUEST["medicinesearch"];
$accountname = $_REQUEST["accountname"];
$username = $_SESSION["username"];
$docno = $_SESSION['docno'];
$query = "select locationcode from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysql_query($query) or die ("Error in Query1".mysql_error());
$res = mysql_fetch_array($exec);
$locationcode = $res["locationcode"];

//$medicinesearch = strtoupper($medicinesearch);
$searchresult2 = "";
$query2 = "select * from master_medicine where itemcode = '$medicinesearch' order by itemname";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
while ($res2 = mysql_fetch_array($exec2))
{
	$itemcode = $res2["itemcode"];
	$itemname = $res2["itemname"];
    $itemname = strtoupper($itemname);
    $rateperunit = $res2[$locationcode."_rateperunit"];
	$formula = $res2['formula'];
	$strength = $res2['roq'];
	$genericname = $res2['genericname'];
	
	$query22 = "select * from pharma_insurance where itemcode='$itemcode' and accountname='$accountname'";
	$exec22 = mysql_query($query22) or die(mysql_error());
	$num22 = mysql_num_rows($exec22);
	if ($searchresult2 == '')
	{
	    $searchresult2 = ''.$itemcode.'||'.$itemname.'||'.$rateperunit.'||'.$formula.'||'.$strength.'||'.$genericname.'||'.$num22.'||';
	}
	else
	{
		$searchresult2 = $searchresult2.'||^||'.$itemcode.'||'.$itemname.'||'.$rateperunit.'||'.$formula.'||'.$strength.'||'.$genericname.'||'.$num22.'||';
	}
	
}
if ($searchresult2 != '')
{
 echo $searchresult2;
}
?>