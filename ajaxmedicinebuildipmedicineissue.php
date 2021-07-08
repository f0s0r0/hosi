<?php
session_start();
include ("db/db_connect.php");
$companyanum = $_SESSION['companyanum'];
$username = $_SESSION["username"];
$docno = $_SESSION['docno'];


$searchmedicinename1 = $_REQUEST['searchmedicinename1'];

$locationcode = $_REQUEST['searchlocation'];
$searchstore = $_REQUEST['searchstore'];
$stringbuild100='';
//$res7storeanum = $res23['store'];

$query75 = "select * from master_store where storecode='$searchstore'";
$exec75 = mysql_query($query75) or die(mysql_error());
$res75 = mysql_fetch_array($exec75);
$storecode = $res75['storecode'];
$ratecolumn = $locationcode.'_rateperunit';

	$query6 = "select shownostockitems from master_company where auto_number = '$companyanum'";
	$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
	$res6 = mysql_fetch_array($exec6);
	$stocks = $res6['shownostockitems'];
	
/*echo	$query571 = "select itemcode from transaction_stock where storecode='".$storecode."' AND locationcode='".$locationcode."' AND itemname like '%$searchmedicinename1%' order by auto_number desc";*/
	
	$query571 = "select itemcode from transaction_stock where storecode='".$storecode."' AND locationcode='".$locationcode."' and batch_stockstatus <> '0' AND itemname like '%$searchmedicinename1%' group by itemcode order by auto_number desc";
	$res571=mysql_query($query571)or die ("Error in Query571".mysql_error());
	while($exec571 = mysql_fetch_array($res571))
	{
	$stockitemcode = $exec571['itemcode'];
	
	$query57 = "select sum(batch_quantity) as currentstock,itemcode from transaction_stock where storecode='".$storecode."' AND locationcode='".$locationcode."' AND itemcode = '$stockitemcode' and batch_stockstatus='1'";
	$res57=mysql_query($query57);
	$exec57 = mysql_fetch_array($res57);
	$currentstock = $exec57['currentstock'];
	
	//echo $res200itemcode;
	//include ('autocompletestockcount1include1.php');
	 
//echo $res200itemcode;
	//$currentstock = $currentstock;
	$currentstock = $currentstock;
	
		$query200 = "select itemcode,itemname,disease,genericname,pkg,`$ratecolumn` from master_medicine where itemcode = '$stockitemcode' and status <> 'Deleted' order by itemname limit 0, 15";
	$exec200 = mysql_query($query200) or die ("Error in Query200".mysql_error());
	$res200 = mysql_fetch_array($exec200);
	$res200itemcode = $res200['itemcode'];	
	$res200medicine = $res200['itemname'];
	$disease = $res200['disease'];
	$itemcode = $res200itemcode;
	$genericname = $res200['genericname'];
	$rateperunit = $res200[$locationcode.'_rateperunit'];
	$pkg = $res200['pkg'];
	
	
	$res200medicine = addslashes($res200medicine);

	$res200medicine = strtoupper($res200medicine);
	
	$res200medicine = trim($res200medicine);
	
	$res200medicine = preg_replace('/,/', ' ', $res200medicine); // To avoid comma from passing on to ajax url.
	if($stocks == 'NO')
	
	{
		if($currentstock > 0)
		{
			if ($stringbuild100 == '')
			{
				//$stringbuild1 = '"'.$res1customername.' #'.$res1customercode.'"';
				$stringbuild100 = ''.$res200itemcode.' ||'.$res200medicine.' ||'.$currentstock.' ||'.$disease.' ||'.$rateperunit.'||'.$pkg.'||';
			}
			else
			{
				//$stringbuild1 = $stringbuild1.',"'.$res1customername.' #'.$res1customercode.'"';
				$stringbuild100 = $stringbuild100.','.$res200itemcode.' ||'.$res200medicine.' ||'.$currentstock.' ||'.$disease.' ||'.$rateperunit.'||'.$pkg.'||';
			}
		}
		
	}
	else
	{
			if ($stringbuild100 == '')
			{
				//$stringbuild1 = '"'.$res1customername.' #'.$res1customercode.'"';
				$stringbuild100 = ''.$res200itemcode.' ||'.$res200medicine.' ||'.$currentstock.' ||'.$disease.' ||'.$rateperunit.'||'.$pkg.'||';
			}
			else
			{
				//$stringbuild1 = $stringbuild1.',"'.$res1customername.' #'.$res1customercode.'"';
				$stringbuild100 = $stringbuild100.','.$res200itemcode.' ||'.$res200medicine.' ||'.$currentstock.' ||'.$disease.' ||'.$rateperunit.'||'.$pkg.'||';
			}
	}
}
echo $stringbuild100;

	

?>