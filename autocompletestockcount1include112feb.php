<?php
//WARNING//
//*****************************************************************
//This file is called as file_get_contents from autoitemsearch2.php
//*****************************************************************

$totalpurchase = "";
$totalpurchasereturn = "";
$totalsales = "";
$totalsalesreturn = "";
$totaldccustomer = "";
$totaldcsupplier = "";
$totalsumadjustmentadd = "";
$totalsumadjustmentminus = "";
$totalsumtransferadd = "";
$totalsumtransferminus = "";

$query1 = "select * from master_itempharmacy where itemcode = '$itemcode'";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
$res1 = mysql_fetch_array($exec1);
$res1itemcode = $res1['itemcode'];
$res1itemcode = trim($res1itemcode);

$res1itemname = $res1['itemname'];

$query1 = "select sum(quantity) as sumsales from pharmacysales_details where itemcode = '$res1itemcode' and  recordstatus <> 'DELETED' and companyanum = '$companyanum' and store = '$store' and location = '$location'";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
$res1 = mysql_fetch_array($exec1);
$totalsales = $res1['sumsales'];

$query1 = "select sum(quantity) as sumsalesreturn from pharmacysalesreturn_details where itemcode = '$res1itemcode' and  recordstatus <> 'DELETED' and companyanum = '$companyanum' and store = '$store' and location = '$location'";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
$res1 = mysql_fetch_array($exec1);
$totalsalesreturn = $res1['sumsalesreturn'];

//$query1 = "select sum(quantity) as sumpurchase from purchase_details where itemcode = '$itemcode' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";
$query1 = "select sum(allpackagetotalquantity) as sumpurchase from purchase_details where itemcode = '$res1itemcode' and recordstatus <> 'DELETED' and companyanum = '$companyanum' and store = '$store' and location = '$location'";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
$res1 = mysql_fetch_array($exec1);

$totalpurchase = $res1['sumpurchase'];

$query1 = "select sum(quantity) as sumpurchasereturn from purchasereturn_details where itemcode = '$res1itemcode' and recordstatus <> 'DELETED' and companyanum = '$companyanum' and store = '$store' and location = '$location'";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
$res1 = mysql_fetch_array($exec1);
$totalpurchasereturn = $res1['sumpurchasereturn'];

$query1 = "select sum(quantity) as sumdccustomer from dccustomer_details where itemcode = '$res1itemcode' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
$res1 = mysql_fetch_array($exec1);
$totaldccustomer = $res1['sumdccustomer'];

$query1 = "select sum(quantity) as sumdcsupplier from dcsupplier_details where itemcode = '$res1itemcode' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
$res1 = mysql_fetch_array($exec1);
$totaldcsupplier = $res1['sumdcsupplier'];
			
$query1 = "select sum(quantity) as sumadjustmentadd from master_stock where itemcode = '$res1itemcode' and 
transactionmodule = 'ADJUSTMENT' and transactionparticular = 'BY ADJUSTMENT ADD' and recordstatus <> 'DELETED' and companyanum = '$companyanum' and store = '$store' and location = '$location'";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
$res1 = mysql_fetch_array($exec1);
$totalsumadjustmentadd = $res1['sumadjustmentadd'];



$query1 = "select sum(quantity) as sumadjustmentminus from master_stock where itemcode = '$res1itemcode' and 
transactionmodule = 'ADJUSTMENT' and transactionparticular = 'BY ADJUSTMENT MINUS' and recordstatus <> 'DELETED' and companyanum = '$companyanum' and store = '$store' and location = '$location'";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
$res1 = mysql_fetch_array($exec1);
$totalsumadjustmentminus = $res1['sumadjustmentminus'];

$query2 = "select sum(transferquantity) as sumtransferadd from master_stock_transfer where itemcode = '$res1itemcode' and companyanum = '$companyanum' and location = '$location' and tostore = '$store'";
$exec2 = mysql_query($query2) or die(mysql_error());
$res2 = mysql_fetch_array($exec2);
$totalsumtransferadd = $res2['sumtransferadd'];

$query21 = "select sum(transferquantity) as sumtransferminus from master_stock_transfer where itemcode = '$res1itemcode' and companyanum = '$companyanum' and location = '$location' and fromstore = '$store'";
$exec21 = mysql_query($query21) or die(mysql_error());
$res21 = mysql_fetch_array($exec21);
$totalsumtransferminus = $res21['sumtransferminus'];

$currentstock = $totalpurchase;
$currentstock = $currentstock - $totalpurchasereturn;
$currentstock = $currentstock - $totalsales;
$currentstock = $currentstock + $totalsalesreturn;
$currentstock = $currentstock - $totaldccustomer;
$currentstock = $currentstock + $totaldcsupplier;
$currentstock = $currentstock + $totalsumadjustmentadd;
$currentstock = $currentstock - $totalsumadjustmentminus;
$currentstock = $currentstock + $totalsumtransferadd;
$currentstock = $currentstock - $totalsumtransferminus;



?>