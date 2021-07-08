<?php
session_start();
include ("db/db_connect.php");

$docno = $_SESSION['docno'];
$username = $_SESSION['username'];

$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
$res1 = mysql_fetch_array($exec1);
$locationname = $res1["locationname"];
$locationcode = $res1["locationcode"];  

if (isset($_REQUEST["accountname"])) { $accountname = $_REQUEST["accountname"]; } else { $accountname = ""; }
$searchresult = "";

/*
$query2 = "select * from master_employeelocation where locationcode = '$locationcode' group by employeecode";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
while ($res2 = mysql_fetch_array($exec2))
{
	$res2employeecode = $res2['employeecode'];
	//$res2employeename = $res2['employeename'];
*/
	
$query3 = "select * from master_accountname where accountname like '%$accountname%' and accountssub = '1' limit 0,10";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
while($res3 = mysql_fetch_array($exec3))
{
	$res3accountname = $res3['accountname'];

	$accountcode = $res3['id'];
	$accountname = $res3['accountname'];


	if ($searchresult == '')
	{
		$searchresult = ''.$accountcode.'||'.$accountname.'';
	}
	else
	{
		$searchresult = $searchresult.'||^||'.$accountcode.'||'.$accountname.'';
	}

}

//}	

if ($searchresult != '')
{
	echo $searchresult;
}

?>