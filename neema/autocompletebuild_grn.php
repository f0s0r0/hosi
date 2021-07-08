<?php
session_start();
include ("db/db_connect.php");
$term = $_REQUEST['term'];
$logiddocno = $_SESSION["docno"];
$user12 = $_SESSION["username"];
$query1 = "select locationcode from login_locationdetails where username='$user12' and docno='$logiddocno'  group by locationname order by locationname";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
$res1 = mysql_fetch_array($exec1);
$locationcode = $res1["locationcode"];
$a_json = array();
$a_json_row = array();

$stringbuild1 = "";
$query1 = "select billnumber from purchase_details where billnumber like '%$term%' and itemstatus ='' and locationcode='$locationcode' group by billnumber limit 10";
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
