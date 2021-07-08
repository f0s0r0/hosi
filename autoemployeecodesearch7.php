<?php
session_start();
include ("db/db_connect.php");

if (isset($_REQUEST["employeesearch"])) { $employeesearch = $_REQUEST["employeesearch"]; } else { $employeesearch = ""; }
$searchresult = "";


$query3 = "select * from master_employee where (employeecode like '%$employeesearch%' or employeename like '%$employeesearch%') and status <> 'deleted' limit 0,10";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
while($res3 = mysql_fetch_array($exec3))
{
	$res3employeecode = $res3['employeecode'];

	$employeecode = $res3['employeecode'];
	$employeename = $res3['employeename'];


	if ($searchresult == '')
	{
		$searchresult = ''.$employeecode.'||'.$employeename.'';
	}
	else
	{
		$searchresult = $searchresult.'||^||'.$employeecode.'||'.$employeename.'';
	}

}
	

if ($searchresult != '')
{
	echo $searchresult;
}

?>