<?php

include ("db/db_connect.php");
  
 $process=$_REQUEST['term'];



$a_json = array();
$a_json_row = array();
 $query1 = "select id,accountname from master_accountname where recordstatus <>'DELETED' and (accountname like '%$process%' or id like '%$process%')and accountssub in('23','24') limit 0,20";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
while ($res1 = mysql_fetch_array($exec1))
{
	$id = $res1['id'];
	$accountname = $res1['accountname'];
	
	$a_json_row["id"] = trim($id);
	$a_json_row["accountname"] = trim($accountname);
	$a_json_row["value"] = trim($accountname);
	$a_json_row["label"] = trim($accountname);
	
	
	array_push($a_json, $a_json_row);  
}

echo json_encode($a_json);


?>