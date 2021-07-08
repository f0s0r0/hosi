<?php
//session_start();
include ("db/db_connect.php");

$patient = trim($_REQUEST['term']);

//echo $customersearch;
//$location = $_REQUEST['location'];
//echo $customer;
//$stringbuild1 = "";
$a_json = array();
$a_json_row = array();
$query1 = "select * from master_customer where customerfullname like '%$patient%'  order by customerfullname limit 0,20";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
while ($res1 = mysql_fetch_array($exec1))
{
	
	$customername = $res1['customerfullname'];
	$customercode =$res1['customercode'];

	$a_json_row["value"] = trim($customername);
	$a_json_row["customercode"] = trim($customercode);
	$a_json_row["label"] = trim($customername);

	
	
	array_push($a_json, $a_json_row);
}
//echo $stringbuild1;
echo json_encode($a_json);
?>