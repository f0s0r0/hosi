<?php
//session_start();
include ("db/db_connect.php");

$consultingdoctor = $_REQUEST['consultingdoctor'];
$location = $_REQUEST['location'];
//echo $customer;
$stringbuild1 = "";

$query1 = "select * from master_doctor where doctorname like '%$consultingdoctor%' and locationcode = '$location' and status <> 'Deleted' order by doctorname LIMIT 10";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
while ($res1 = mysql_fetch_array($exec1))
{
	$res1customercode = $res1['doctorcode'];
	$res1customername = $res1['doctorname'];
	
	$res1customercode = addslashes($res1customercode);
	$res1customername = addslashes($res1customername);
	
	$res1customercode = strtoupper($res1customercode);
	$res1customername = strtoupper($res1customername);
	
	$res1customercode = trim($res1customercode);
	$res1customername = trim($res1customername);
	
	$res1customercode = preg_replace('/,/', ' ', $res1customercode);
	$res1customername = preg_replace('/,/', ' ', $res1customername);
	
	if ($stringbuild1 == '')
	{
		$stringbuild1 = $res1customername.'#'.$res1customercode.'';
	}
	else
	{
		$stringbuild1 = $stringbuild1.','.$res1customername.'#'.$res1customercode.'';
		
	}
}
if($stringbuild1 != '')
{
echo $stringbuild1;
}
else
{
echo $stringbuild1 = 'OP DOCTOR'.'#'.'08-8000'.'';
}

?>