
<?php
//session_start();
include ("db/db_connect.php");

$searchsuppliername1 = trim($_REQUEST['searchsuppliername']);

$stringbuild1 = "";
$query1 = "select * from master_employee where employeename like '%$searchsuppliername1%' and  status <> 'Deleted' group by employeename limit 0,10";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
while ($res1 = mysql_fetch_array($exec1))
{
	$res1auto_number = $res1['auto_number'];
	$res1username = $res1['username'];
	$res1employeecode = $res1['employeecode'];
	$employeename = $res1['employeename'];
	$res1username = strtoupper($res1username);
	$res1username = trim($res1username);
	$res1username = preg_replace('/,/', ' ', $res1username);
	if ($stringbuild1 == '')
	{
		$stringbuild1 = $employeename.'#'.$res1username.'';
	}
	else
	{
		$stringbuild1 = $stringbuild1.','.$employeename.'#'.$res1username.'';
	}
}
echo $stringbuild1;


?>

