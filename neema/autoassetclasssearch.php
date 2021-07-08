<?php
include ("db/db_connect.php");

$asset_class = trim(strtoupper($_REQUEST['term']));
$a_json = array();
$a_json_row = array();

$query2 = "select * from master_assetcategory where category like '%$asset_class%' and recordstatus <> 'deleted'";

$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
while ($res2 = mysql_fetch_array($exec2))
{
	$id = $res2["id"];
	$asset_class = $res2["category"];
	$asset_classanum = $res2['auto_number'];
		
	$a_json_row["id"] = trim($id);
	$a_json_row["anum"] = trim($asset_classanum);
	$a_json_row["value"] = trim($asset_class);
	$a_json_row["label"] = trim($asset_class.' || '.$id);
	array_push($a_json, $a_json_row);
}
echo json_encode($a_json);
 
?>
