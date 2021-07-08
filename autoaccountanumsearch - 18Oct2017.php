<?php
session_start();
include ("db/db_connect.php");
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$consultationdate = date('Y-m-d');
//$customersearch = strtoupper($customersearch);
$searchresult = "";
$availablelimit = "";

$location= $_REQUEST["location"];
$accountsmain= $_REQUEST["accountsmain"];
$accountssub= $_REQUEST["accountssub"];

$query8 = "select * from master_location where locationcode = '$location'";
$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
$res8 = mysql_fetch_array($exec8);
$locationprefix = $res8['prefix'];

$query82 = "select * from master_accountssub where auto_number = '$accountssub'";
$exec82 = mysql_query($query82) or die ("Error in Query82".mysql_error());
$res82 = mysql_fetch_array($exec82);
$accanum = $res82['id'];
$accanumexplode = explode('-',$accanum);
$accanum1 = $accanumexplode[0];
$accanum2 = $accanumexplode[1];

$accinc = intval($accanum2);
$accinc = $accinc + 1;

//$query2 = "select * from master_accountname where locationcode = '$location' and accountsmain = '$accountsmain' and accountssub = '$accountssub'  order by auto_number desc";
$query2 = "select * from master_accountname where accountsmain = '$accountsmain' and accountssub = '$accountssub'  order by auto_number desc";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);

$res2id = $res2['id'];

if($res2id == '')
{
	if($accountssub == '15')
	{
 		$searchresult = $accanum1.'-'.$accinc;
	}
	else
	{
		$searchresult = $accanum1.'-'.$accinc.'-'.$locationprefix;
	}
}
else
{
	$res2id = $res2['id'];
	$res2idexplode = explode('-',$res2id);
	$res2id1 = $res2idexplode[0];
	$res2id2 = $res2idexplode[1];
	
	$incanum = intval($res2id2);
	$incanum = $incanum + 1;
	
	if($accountssub == '15')
	{
 		$searchresult = $res2id1.'-'.$incanum;
	}
	else
	{
		$searchresult = $res2id1.'-'.$incanum.'-'.$locationprefix;
	}

}

if ($searchresult != '')
{
	echo $searchresult;
}

?>