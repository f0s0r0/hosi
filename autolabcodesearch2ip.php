<?php
session_start();
include ("db/db_connect.php");
$labsearch = $_REQUEST["labsearch"];
$patienttypesearch = $_REQUEST['patienttypesearch'];
$varpaymenttype = $_REQUEST['varpaymenttype'];
$subtype = $_REQUEST['subtype'];

$locationcode = $_REQUEST['locationcode'];
//$medicinesearch = strtoupper($medicinesearch);
$searchresult3 = "";
$query13 = "select * from master_subtype where subtype = '$subtype' order by subtype";
$exec13 = mysql_query($query13) or die ("Error in Query13".mysql_error());
$res13 = mysql_fetch_array($exec13);
$tablename = $res13['labtemplate'];
if($tablename == '')
{
  $tablename = 'master_lab';
}
$query3 = "select * from $tablename where itemcode = '$labsearch' and status <> 'deleted' AND location = '".$locationcode."' order by itemname";
$exec3 = mysql_query($query3) or die ("Error in Query2".mysql_error());
while ($res3 = mysql_fetch_array($exec3))
{
	$itemcode1 = $res3["itemcode"];
	$itemname1 = $res3["itemname"];
    $itemname1 = strtoupper($itemname1);
	$externallab = $res3['externallab'];
	$ipmarkup = $res3['ipmarkup'];
	
	$pkg = $res3['pkg'];
	/*if($varpaymenttype == 'INSURANCE')
	{
    $rateperunit1 = $res3["rate2"];
	}
	else if($varpaymenttype == 'MICRO INSURANCE')
	{
	 $rateperunit1 = $res3["rate3"];   
	}
	else
	{*/
	$rateperunit1 = $res3["rateperunit"];
	/*}*/
	if($ipmarkup > 0)
	{
		$rateperunit1 = $rateperunit1 + ($rateperunit1 * $ipmarkup / 100);
	}
	
	if ($searchresult3 == '')
	{
	    $searchresult3 = ''.$itemcode1.'||'.$itemname1.'||'.$rateperunit1.'||'.$pkg.'||'.$ipmarkup.'||';
	}
	else
	{
		$searchresult3 = $searchresult3.'||^||'.$itemcode1.'||'.$itemname1.'||'.$rateperunit1.'||'.$pkg.'||'.$ipmarkup.'||';
	}
	
}
if ($searchresult3 != '')
{
 echo $searchresult3;
}
?>