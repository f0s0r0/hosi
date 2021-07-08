<?php
session_start();
//Called from sales1.php - autoitemsearch2.js
//Item rate called from previous bill entry is done here.

include ("db/db_connect.php");
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$companycode = $_SESSION['companycode'];
$expensemainanum=$_REQUEST["expensemainanum"];
	$searchresult = '';

	$query1 = "select * from master_expensesub where expensemainanum = '$expensemainanum' and status <> 'deleted'";
	$exec1 = mysql_query($query1) or die ("Error in Query1.city".mysql_error());
	while ($res1 = mysql_fetch_array($exec1))
	{
	 $expensesubanum = $res1['auto_number'];
	 $expensesubname = $res1['expensesubname'];

	if ($searchresult == '')
	{
		 $searchresult = ''.$expensesubanum.'||'.$expensesubname.'';
	}
	else
	{
		$searchresult = $searchresult.'||^||'.$expensesubanum.'||'.$expensesubname.'';
	}
	}
	
	if ($searchresult != '')
	{
		echo  $searchresult;
	}

?>