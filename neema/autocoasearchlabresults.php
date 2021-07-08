<?php
session_start();
include ("db/db_connect.php");

if (isset($_REQUEST["coasearch"])) { $coasearch = $_REQUEST["coasearch"]; } else { $coasearch = ""; }
$searchresult = "";

$query2 = "select * from master_labresultvalues where value like '%$coasearch%' and status <> 'deleted' order by value";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
while ($res2 = mysql_fetch_array($exec2))
{
	$id = $res2["auto_number"];
	$value = $res2["value"];
	$type = '';
	
		
	if ($searchresult == '')
	{
		$searchresult = ''.$id.'||'.$value.'||'.$type.'';
	}
	else
	{
		$searchresult = $searchresult.'||^||'.$id.'||'.$value.'||'.$type.'';
	}
	
}

if ($searchresult != '')
{
	echo $searchresult;
}

?>