<?php
//session_start();
include ("db/db_connect.php");

$term = trim($_REQUEST['term']);

//echo $customersearch;
//$location = $_REQUEST['location'];
//echo $customer;
//$stringbuild1 = "";
$a_json = array();  
$a_json_row = array();
 $query1 = "select subtype,auto_number from master_subtype where subtype like '%$term%' and recordstatus <> 'deleted' order by subtype";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
while ($res1 = mysql_fetch_array($exec1))
{
	$accountname = $res1['subtype'];
	$accountid= '';
	$auto_number = $res1['auto_number'];
	
	$a_json_row["id"] = trim($accountid);
	$a_json_row["value"] = trim($accountname);
	$a_json_row["label"] = trim($accountname);
	$a_json_row["anum"] = trim($auto_number);
	array_push($a_json, $a_json_row);
}
//echo $stringbuild1;
echo json_encode($a_json);
?>