<?php
session_start();
include ("db/db_connect.php");
$logiddocno = $_SESSION["docno"];
$username = $_SESSION["username"];
$term = $_REQUEST['term'];
$query1 = "select locationcode from login_locationdetails where username='$username' and docno='$logiddocno'  group by locationname order by locationname";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
$res1 = mysql_fetch_array($exec1);
$locationcode = $res1["locationcode"];
$a_json = array();
$a_json_row = array();
$stringbuild1 = "";
$todate=date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') -30, date('Y')));
$query1 = "select billnumber from purchaseorder_details where billnumber like '%$term%' and goodsstatus='' and billdate <= '".date('Y-m-d')."' AND billdate >= '".$todate."' and locationcode='$locationcode' group by billnumber limit 0,10";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
while ($res1 = mysql_fetch_array($exec1))
{
	$resbillnumber = $res1['billnumber'];
	$a_json_row["value"] = trim($resbillnumber);
	$a_json_row["label"] = trim($resbillnumber);
	array_push($a_json, $a_json_row);
}
echo json_encode($a_json);
?>
