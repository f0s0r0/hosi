<?php
//session_start();
include ("db/db_connect.php");

$searchdisease1 = trim($_REQUEST['term']);
//echo $searchsuppliername1;
$stringbuild1 = "";
$a_json = array();
$a_json_row = array();

$query2 = "select instructions from pharmainstructions where (shortcode like '%$searchdisease1%' OR instructions like '%$searchdisease1%') and recordstatus = '' order by auto_number LIMIT 8";// order by subtype limit 0, 15";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
while ($res2 = mysql_fetch_array($exec2))
{
	$instructions = $res2['instructions'];
	

		
		$stringbuild1 = ''.$instructions.'';
	
	
	$a_json_row["label"] = $stringbuild1;
	$a_json_row["value"] = trim($stringbuild1);
	array_push($a_json, $a_json_row);
}
//echo $stringbuild1;
echo json_encode($a_json);

?>
