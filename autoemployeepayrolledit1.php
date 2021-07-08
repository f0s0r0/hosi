<?php
session_start();
include ("db/db_connect.php");
$username = $_SESSION['username'];
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');

if (isset($_REQUEST["employeesearch"])) { $employeesearch = $_REQUEST["employeesearch"]; } else { $employeesearch = ""; }

$searchresult = "";
$totalloanamount = "";
$loanbuild = "";
$totalmonthpaid = "";
$totalafterinstallment = "";

//include("autoemployeepayrollcalculation1.php");

$query77 = "select auto_number, typecode, componentname from master_payrollcomponent where recordstatus <> 'deleted'";
$exec77 = mysql_query($query77) or die ("Error in Query77".mysql_error());
while($res77 = mysql_fetch_array($exec77))
{
	$componentanum = $res77['auto_number'];
	$componentname = $res77['componentname'];
	$typecode = $res77['typecode'];
	
	$query80 = "select `$componentanum` as componentvalue, employeecode from payroll_assign where status <> 'deleted' and employeecode = '$employeesearch'";
	$exec80 = mysql_query($query80) or die ("Error in Query80".mysql_error());
	$res80 = mysql_fetch_array($exec80);

	$employeecode = $res80['employeecode'];
	$componentvalue = $res80['componentvalue'];
	if($componentvalue > 0)
	{
		if($searchresult == "")
		{
			$searchresult = ''.$employeecode.'||'.$componentanum.'||'.$componentname.'||'.$componentvalue.'||'.$typecode.'';
		}	
		else
		{
			$searchresult = $searchresult.'||^||'.$employeecode.'||'.$componentanum.'||'.$componentname.'||'.$componentvalue.'||'.$typecode.'';
		}
	}
}	
	
if ($searchresult != '')
{
	echo $searchresult;
}

?>