<?php
session_start();
include ("db/db_connect.php");

$vehicletypesearch=isset($_REQUEST['vehicletypesearch'])?$_REQUEST['vehicletypesearch']:'';


$stringbuild1 = "";
$query2 = "select * from master_vehicle where vehicletype like '%$vehicletypesearch%' or vehiclemodel like '%$vehicletypesearch%' or vehiclenumber like '%$vehicletypesearch%' order by autonumber ";// order by accountname limit 0, 15";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
while ($res2 = mysql_fetch_array($exec2))
{
	$vehiclenumber = $res2['vehiclenumber'];
	$vehiclemodel = $res2['vehiclemodel'];
	$vehicletype = $res2['vehicletype'];
	
	
	
	if ($stringbuild1 == '')
	{
		//$stringbuild1 = '"'.$res1customername.' #'.$res1customercode.'"';
		$stringbuild1 = ''.$vehicletype.' #'.$vehiclenumber.'#'.$vehiclemodel;
	}
	else
	{
		//$stringbuild1 = $stringbuild1.',"'.$res1customername.' #'.$res1customercode.'"';
		$stringbuild1 = $stringbuild1.','.$vehicletype.' #'.$vehiclenumber.'#'.$vehiclemodel;
	}
}

echo $stringbuild1;






?>