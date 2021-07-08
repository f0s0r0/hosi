<?php
//session_start();
include ("db/db_connect.php");

$searchsuppliername1 = $_REQUEST['searchempname'];

$stringbuild1 = "";
 $query1 = "select * from master_employee where employeename like '%$searchsuppliername1%' and status = 'Active' order by employeename limit 0,10";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
while ($res1 = mysql_fetch_array($exec1))
{
	$res1employeecode = $res1['username'];
	$res1jobdescription = $res1['employeename'];
	
	$res1employeecode = addslashes($res1employeecode);
	$res1jobdescription = addslashes($res1jobdescription);


	$res1employeecode = $res1employeecode;
	$res1jobdescription = strtoupper($res1jobdescription);
	
	$res1employeecode = trim($res1employeecode);
	$res1jobdescription = trim($res1jobdescription);
	
	$res1employeecode = preg_replace('/,/', ' ', $res1employeecode);
	$res1jobdescription = preg_replace('/,/', ' ', $res1jobdescription);
	
	if ($stringbuild1 == '')
	{
		$stringbuild1 = $res1employeecode.'||'.$res1jobdescription;
	}
	else
	{
		$stringbuild1 = $stringbuild1.','.$res1employeecode.'||'.$res1jobdescription.',';
	}
}
echo $stringbuild1;



?>
