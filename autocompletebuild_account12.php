<?php
//session_start();
include ("db/db_connect.php");

if(isset($_REQUEST['searchmedicinename1']))
$searchmedicinename1 = $_REQUEST['searchmedicinename1'];
else
$searchmedicinename1 ='';

$stringbuild1 = "";
$query1 = "select * from master_accountname where accountname like '%$searchmedicinename1%' and recordstatus <> 'Deleted' and accountssub ='15' order by accountname";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
while ($res1 = mysql_fetch_array($exec1))
{
	$res1suppliercode = $res1['auto_number'];
	$res1suppliername = $res1['accountname'];
	$res1suppliername = strtoupper($res1suppliername);
	$res1suppliername = trim($res1suppliername); 
	$res1suppliername = preg_replace('/,/', ' ', $res1suppliername);
	if ($stringbuild1 == '')
	{
		$stringbuild1 = ''.''.$res1suppliername.''.'';
	}
	else
	{
		$stringbuild1 = $stringbuild1.','.''.$res1suppliername.''.'';
	}
}


echo $stringbuild1;





?>