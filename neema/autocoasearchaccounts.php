<?php
session_start();
include ("db/db_connect.php");

if (isset($_REQUEST["coasearch"])) { $coasearch = $_REQUEST["coasearch"]; } else { $coasearch = ""; }
$searchresult = "";

$query2 = "select * from master_subtype where subtype like '%$coasearch%' and maintype = '3' and recordstatus <> 'deleted' order by subtype";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
while ($res2 = mysql_fetch_array($exec2))
{
	$id = $res2["auto_number"];
	$accountname = $res2["subtype"];
	$accountsmain = $res2["maintype"];
	
	
	
	if ($searchresult == '')
	{
		$searchresult = ''.$id.'||'.$accountname.'||'.$accountsmain.'';
	}
	else
	{
		$searchresult = $searchresult.'||^||'.$id.'||'.$accountname.'||'.$accountsmain.'';
	}
	
}

if ($searchresult != '')
{
	echo $searchresult;
}

?>