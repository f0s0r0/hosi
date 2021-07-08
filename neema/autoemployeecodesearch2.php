<?php
session_start();
include ("db/db_connect.php");

if (isset($_REQUEST["employeesearch"])) { $employeesearch = $_REQUEST["employeesearch"]; } else { $employeesearch = ""; }
$searchresult = "";

$query2 = "select * from master_employee where employeecode = '$employeesearch'";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
while ($res2 = mysql_fetch_array($exec2))
{
	$employeecode = $res2['employeecode'];
	$employeename = $res2['employeename'];
	$locationanum = $res2['location'];
	$storeanum = $res2['store'];
	$shift = $res2['shift'];
	$jobdescription = $res2['jobdescription'];
	$gender = '';
	$dob = '';
	$doj = '';
	$employmenttype = '';
	$firstjobinkenya = '';
	$overtime = '';
	$nationality = '';
	$category = '';
	
	$query3 = "select * from master_location where auto_number = '$locationanum'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	$res3 = mysql_fetch_array($exec3);
	$location = $res3['locationname'];
	
	$query4 = "select * from master_store where auto_number = '$storeanum'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	$res4 = mysql_fetch_array($exec4);
	$store = $res4['store'];
	
	if ($searchresult == '')
	{
		$searchresult = ''.$employeecode.'||'.$employeename.'||'.$location.'||'.$store.'||'.$shift.'||'.$jobdescription.'||'.$gender.'||'.$dob.'||'.$doj.'||'.$employmenttype.'||'.$firstjobinkenya.'||'.$overtime.'||'.$nationality.'||'.$category.'';
	}
	else
	{
		$searchresult = $searchresult.'||^||'.$employeecode.'||'.$employeename.'||'.$location.'||'.$store.'||'.$shift.'||'.$jobdescription.'||'.$gender.'||'.$dob.'||'.$doj.'||'.$employmenttype.'||'.$firstjobinkenya.'||'.$overtime.'||'.$nationality.'||'.$category.'';
	}
	
}

if ($searchresult != '')
{
	echo $searchresult;
}

?>