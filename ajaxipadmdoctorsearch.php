<?php
session_start();
include ("db/db_connect.php");
$logiddocno = $_SESSION["docno"];
$term = $_REQUEST['term'];
$a_json = array();
$a_json_row = array();
$stringbuild1 = "";
$todate=date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') -7, date('Y')));
$query1 = "select doctorname,auto_number from master_doctor where doctorname like '%$term%' and status <> 'deleted' order by doctorname limit 10";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
while ($res1 = mysql_fetch_array($exec1))
{
	$doctorname = $res1['doctorname'];
	$auto_number = $res1['auto_number'];
	$a_json_row["id"] = trim($auto_number);
	$a_json_row["value"] = trim($doctorname);
	$a_json_row["label"] = trim($doctorname);
	array_push($a_json, $a_json_row);
}
echo json_encode($a_json);
?>