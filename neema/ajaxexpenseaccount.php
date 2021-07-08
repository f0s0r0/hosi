<?php

include ("db/db_connect.php");

 $process=$_REQUEST['term'];

$a_json = array();
$a_json_row = array();
 $query1 = "select id,accountname,accountssub from master_accountname where accountsmain IN ('4','6') and accountname like '%$process%' and recordstatus <> 'Deleted' order by accountname";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
while ($res1 = mysql_fetch_array($exec1))
{
	$id = $res1['id'];
	$accountname = $res1['accountname'];
	$accountssubanum = $res1['accountssub'];
	
	$query77 = mysql_query("select accountssub from master_accountssub where auto_number = '$accountssubanum'") or die ("Error in Query77".mysql_error());
	$res77 = mysql_fetch_array($query77);
	$accountssub = $res77['accountssub'];
	
	$a_json_row["id"] = trim($id);
	$a_json_row["accountname"] = trim($accountname);
	$a_json_row["value"] = trim($accountname);
	$a_json_row["label"] = $accountname.' || '.$accountssub;
	
	
	array_push($a_json, $a_json_row);  
}

echo json_encode($a_json);


?>