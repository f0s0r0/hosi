<?php
include ("db/db_connect.php");

$expense = trim(strtoupper($_REQUEST['term']));
$requestfrm = $_REQUEST['requestfrm'];
$a_json = array();
$a_json_row = array();  

if($requestfrm == 'depreciation')
{
$query2 = "select * from master_accountname where accountssub = '13' and accountname like '%$expense%' and recordstatus <> 'deleted'  order by accountname";
}
else if($requestfrm == 'accdepreciation')
{
$query2 = "select * from master_accountname where accountssub = '24' and accountname like '%$expense%' and recordstatus <> 'deleted'  order by accountname";
}
else if($requestfrm == 'disposal')
{
$query2 = "select * from master_accountname where accountssub = '24' and accountname like '%$expense%' and recordstatus <> 'deleted'  order by accountname";
}
else if($requestfrm == 'asset')
{
$query2 = "select * from master_accountname where accountssub = '16' and accountname like '%$expense%' and recordstatus <> 'deleted'  order by accountname";
}
else
{
$query2 = "select * from master_accountname where accountssub = '24' and accountname like '%$expense%' and recordstatus <> 'deleted'  order by accountname";
}
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
while ($res2 = mysql_fetch_array($exec2))
{
	$id = $res2["id"];
	$accountname = $res2["accountname"];
	$acccountanum = $res2['auto_number'];
	$accountsubanum = $res2['accountssub'];
	
	$query3 = mysql_query("select accountssub from master_accountssub where auto_number = '$accountsubanum'") or die ("Error in Query3".mysql_error());
	$res3 = mysql_fetch_array($query3);
	$accountssub = $res3['accountssub'];
	
	$a_json_row["id"] = trim($id);
	$a_json_row["anum"] = trim($acccountanum);
	$a_json_row["value"] = trim($accountname);
	$a_json_row["label"] = trim($accountname.' || '.$accountssub);
	array_push($a_json, $a_json_row);
}
echo json_encode($a_json);

?>
