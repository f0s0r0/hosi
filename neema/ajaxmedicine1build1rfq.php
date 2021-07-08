<?php
session_start();
include ("db/db_connect.php");
$companyanum = $_SESSION['companyanum'];
$username = $_SESSION["username"];

$searchmedicinename1 = $_REQUEST['searchmedicinename1'];
$stocks = '';
$stringbuild100 = "";

$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysql_query($query) or die ("Error in Query1".mysql_error());
$res = mysql_fetch_array($exec);
	
	 $locationname  = $res["locationname"];
	 $locationcode = $res["locationcode"];
	$res12locationanum = $res["auto_number"];
	
$query55 = "select * from master_location where auto_number='$res12locationanum'";
$exec55 = mysql_query($query55) or die(mysql_error());
$res55 = mysql_fetch_array($exec55);
$location = $res55['locationname'];

$query23 = "select * from master_employeelocation where username='$username' and locationcode = '$locationcode' and defaultstore = 'default'";
$exec23 = mysql_query($query23) or die(mysql_error());
$res23 = mysql_fetch_array($exec23);
$res7locationanum = $res23['locationanum'];

$query55 = "select * from master_location where locationcode='$locationcode'";
$exec55 = mysql_query($query55) or die(mysql_error());
$res55 = mysql_fetch_array($exec55);
$location = $res55['locationname'];

$res7storeanum = $res23['storecode'];

$query75 = "select * from master_store where auto_number='$res7storeanum'";
$exec75 = mysql_query($query75) or die(mysql_error());
$res75 = mysql_fetch_array($exec75);
$storecode = $res75['storecode'];

$ratecolumn = $locationcode.'_rateperunit';

	$query6 = "select shownostockitems from master_company where auto_number = '$companyanum'";
	$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
	$res6 = mysql_fetch_array($exec6);
	$stocks = $res6['shownostockitems'];
	
	$query200 = "select itemcode,itemname,disease,genericname,pkg,`$ratecolumn` from master_medicine where itemname LIKE '%$searchmedicinename1%' and status <> 'deleted' order by itemname limit 0, 20";
	$exec200 = mysql_query($query200) or die ("Error in Query200".mysql_error());
	while($res200 = mysql_fetch_array($exec200))
	{
	$res200itemcode = $res200['itemcode'];
	$res200medicine = $res200['itemname'];
	$disease = $res200['disease'];
	$itemcode = $res200itemcode;
	$genericname = $res200['genericname'];
	$rateperunit = $res200[$locationcode.'_rateperunit'];
	
	$query57 = "select sum(batch_quantity) as currentstock from transaction_stock where locationcode='".$locationcode."' AND itemcode = '$res200itemcode' and batch_stockstatus='1'";
	$res57=mysql_query($query57);
	$exec57 = mysql_fetch_array($res57);
	$currentstock = $exec57['currentstock'];
	
	//$currentstock = $currentstock;
	$currentstock = $currentstock;
	
	$res200medicine = addslashes($res200medicine);

	$res200medicine = strtoupper($res200medicine);
	
	$res200medicine = trim($res200medicine);
	
	$res200medicine = preg_replace('/,/', ' ', $res200medicine); // To avoid comma from passing on to ajax url.
	
	if($stocks == 'NO')
	{
		if(true)
		{
			if ($stringbuild100 == '')
			{
				//$stringbuild1 = '"'.$res1customername.' #'.$res1customercode.'"';
				$stringbuild100 = ''.$res200itemcode.' ||'.$res200medicine.' ||'.$currentstock.' ||'.$disease.' ||'.$rateperunit.'';
			}
			else
			{
				//$stringbuild1 = $stringbuild1.',"'.$res1customername.' #'.$res1customercode.'"';
				$stringbuild100 = $stringbuild100.','.$res200itemcode.' ||'.$res200medicine.' ||'.$currentstock.' ||'.$disease.' ||'.$rateperunit.'';
			}
		}
	}
	else
	{
			if ($stringbuild100 == '')
			{
				//$stringbuild1 = '"'.$res1customername.' #'.$res1customercode.'"';
				$stringbuild100 = ''.$res200itemcode.' ||'.$res200medicine.' ||'.$currentstock.' ||'.$disease.' ||'.$rateperunit.'';
			}
			else
			{
				//$stringbuild1 = $stringbuild1.',"'.$res1customername.' #'.$res1customercode.'"';
				$stringbuild100 = $stringbuild100.','.$res200itemcode.' ||'.$res200medicine.' ||'.$currentstock.' ||'.$disease.' ||'.$rateperunit.'';
			}
	}
}

echo $stringbuild100;



?>
