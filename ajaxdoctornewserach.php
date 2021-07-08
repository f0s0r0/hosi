<?php
//session_start();
include ("db/db_connect.php");

$doctorname = trim($_REQUEST['term']);

//echo $customersearch;
//$location = $_REQUEST['location'];
//echo $customer;
$stringbuild1 = "";
$a_json = array();
$a_json_row = array();
$query1 = "select * from master_doctor where doctorname like '%$doctorname%' and status <> 'Deleted' order by doctorname limit 0,10";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
while ($res1 = mysql_fetch_array($exec1))
{
	$res1suppliercode = $res1['doctorcode'];
	$res1suppliername = $res1['doctorname'];
	$namewithcode=$res1suppliername."#".$res1suppliercode;
	
	$a_json_row["customercode"] = $res1suppliercode;
	$a_json_row["accountname"] = $res1suppliername;
	$a_json_row["namewithcode"] = $namewithcode;
	$a_json_row["value"] = trim($res1suppliername);
	$a_json_row["label"] = trim($res1suppliername);
	array_push($a_json, $a_json_row);
}
//echo $stringbuild1;
echo json_encode($a_json);
?>