<?php
//session_start();
include ("db/db_connect.php");

$genericname1 = $_REQUEST['genericname1'];
//echo $searchsuppliername1;
$stringbuild1 = "";

$query2 = "select * from master_doctor where doctorname like '%$genericname1%' and status = '' order by auto_number LIMIT 15";// order by subtype limit 0, 15";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
while ($res2 = mysql_fetch_array($exec2))
{
	$res2anum = $res2['auto_number'];
	$res2genericname = $res2['doctorname'];
	
	$res2genericname = addslashes($res2genericname);
	$res2genericname = strtoupper($res2genericname);
	$res2genericname = trim($res2genericname);
	$res2genericname = preg_replace('/,/', ' ', $res2genericname); // To avoid comma from passing on to ajax url.
	
	$query33 = "select * from master_employee where employeename='$res2genericname'";
	$exec33 = mysql_query($query33) or die(mysql_error());
	$res33 = mysql_fetch_array($exec33);
	$res2genericcode = $res33['username'];
	if ($stringbuild1 == '')
	{
		//$stringbuild1 = '"'.$res1customername.' #'.$res1customercode.'"';
		$stringbuild1 = ''.$res2genericname.'||'.$res2genericcode.'';
	}
	else
	{
		//$stringbuild1 = $stringbuild1.',"'.$res1customername.' #'.$res1customercode.'"';
		$stringbuild1 = $stringbuild1.','.$res2genericname.'||'.$res2genericcode.'';
	}
}

echo $stringbuild1;



?>