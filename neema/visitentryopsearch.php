<?php
//session_start();
include ("db/db_connect.php");
$department=$_REQUEST['department'];
$location=$_REQUEST['location'];
$subtype=$_REQUEST['subtype'];
$action=$_REQUEST['action'];
if($action=='departmentchange')
{
	$drpdownbulid='<option value="">Select Consultation Fee</option>';
	$query10 = "select * from master_consultationtype where department = '$department' and locationcode = '$location' and subtype = '$subtype' AND recordstatus!= 'deleted' and subtype <> '' order by auto_number";
	$exec10 = mysql_query($query10) or die ("error in query10".mysql_error());
	while ($res10 = mysql_fetch_array($exec10))
	{	
		$res10consultationtypeanum = $res10['auto_number'];
		$res10consultationtype = $res10["consultationtype"];
		$res10consultationdefault = $res10["condefault"];
		$res10consultationfee = $res10["consultationfees"];		
		$drpdownbulid=$drpdownbulid.'<option value="'.$res10consultationtypeanum.'">'.$res10consultationtype.'</option>';
	}
	
	echo $drpdownbulid;
}
?>
