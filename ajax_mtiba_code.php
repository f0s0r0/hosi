<?php
//session_start();
include ("db/db_connect.php");

$stringbuild1 = "";
$term = trim(strip_tags($_GET['term'])); 
$get = trim(strip_tags($_GET['get'])); 
$a_json = array();
$a_json_row = array();

$query2 = "SELECT item_name,item_code FROM mtiba_price_list WHERE item_name LIKE '%$term%' AND item_code LIKE '$get%' AND record_status = '1' GROUP BY item_code ASC LIMIT 0,20";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());

while ($res2 = mysql_fetch_array($exec2))
{
	$name = strtoupper(trim($res2['item_name']));	  
	$code = trim($res2['item_code']);
	$name = preg_replace('/,/', ' ', $name); 
	
	$a_json_row["value"] = $name;
	$a_json_row["label"] = $name;
	$a_json_row["item_code"] = $code;
	
	array_push($a_json, $a_json_row);
}

echo json_encode($a_json);


?>