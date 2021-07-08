<?php
session_start();
include ("db/db_connect.php");

if (isset($_REQUEST["coasearch"])) { $coasearch = $_REQUEST["coasearch"]; } else { $coasearch = ""; }
$searchresult = "";

$query2 = "select * from master_accountname where accountname like '%$coasearch%' and accountssub = '2' and recordstatus <> 'deleted' order by accountname";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
while ($res2 = mysql_fetch_array($exec2))
{
	$id = $res2["id"];
	$accountname = $res2["accountname"];
	$accountsmain = $res2["accountsmain"];
	
	$query21 = "select * from master_accountsmain where auto_number='$accountsmain'";
	$exec21 = mysql_query($query21) or die(mysql_error());
	$res21 = mysql_fetch_array($exec21);
	$type = $res21['section'];
	
	
	if ($searchresult == '')
	{
		$searchresult = ''.$id.'||'.$accountname.'||'.$type.'';
	}
	else
	{
		$searchresult = $searchresult.'||^||'.$id.'||'.$accountname.'||'.$type.'';
	}
	
}

if ($searchresult != '')
{
	echo $searchresult;
}

?>