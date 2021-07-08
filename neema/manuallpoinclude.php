<?php
$lastupdate = date('Y-m-d H:i:s');
$billtime = date("H:i:s");
$financialyear = $_SESSION["financialyear"];
$username = $_SESSION['username'];
$balanceamount = '';
$ipaddress = $_SERVER['REMOTE_ADDR'];

//echo $companyanum;
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{

$paynowbillprefix = 'MLPO-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from manual_lpo where companyanum = '$companyanum' order by auto_number desc";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$res2billnumber = $res2["billnumber"];
$billdigit=strlen($res2billnumber);
if ($res2billnumber == '')
{
	$billnumber ='MLPO-'.'1';
	$openingbalance = '0.00';
}
else
{
	$res2billnumber = $res2["billnumber"];
	$billnumbercode = substr($res2billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumber = 'MLPO-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}

$billnumber = $billnumber.'-'.date('y');
//$billnumber = $_REQUEST['billnumber'];
//$store = $_REQUEST['store1'];
$billdate = $_REQUEST['ADate'];
$suppliername = $_REQUEST['supplier'];
$suppliercode = $_REQUEST['suppliercode'];
//$ponumber = $_REQUEST['pono'];
//$accountssubid = $_REQUEST['accountssubid'];
$supplierbillno = $_REQUEST['supplierbillnumber'];
$amount = $_REQUEST['totalamount'];
$locationcode = $_REQUEST['location'];
$query23 = "select * from master_employee where username='$username'";
$exec23 = mysql_query($query23) or die(mysql_error());
$res23 = mysql_fetch_array($exec23);
$res7locationanum = $res23['location'];
$subtotal = $_REQUEST['subtotal'];
$subtotalaftercombinediscount = $_REQUEST['subtotalaftercombinediscount'];
$totalaftertax = $_REQUEST['totalaftertax'];
$packaging = $_REQUEST['packaging'];
$delivery = $_REQUEST['delivery'];
$roundoff = $_REQUEST['roundoff'];
$billtype = $_REQUEST['billtype'];
$creditamount = $_REQUEST['creditamount'];
$subtotaldiscountpercentapply1 = $_REQUEST['subtotaldiscountpercentapply1'];
$subtotaldiscountamountapply1 = $_REQUEST['subtotaldiscountamountapply1'];
$subtotaldiscountamountonlyapply1 = $_REQUEST['subtotaldiscountamountonlyapply1'];
$subtotaldiscountamountonlyapply2 = $_REQUEST['subtotaldiscountamountonlyapply2'];
$cashamount = $_REQUEST['cashamount'];
$project=$_REQUEST['project'];
$budgetline=$_REQUEST['budgetline'];
$budgetcode=$_REQUEST['budgetcode'];
$warrenty=$_REQUEST['warrenty'];
$deliveryortransport=$_REQUEST['deliveryortransport'];
$payment=$_REQUEST['payment'];
$address=$_REQUEST['address'];
$authorisedby=$_REQUEST['authorisedby'];
$quotationnum=$_REQUEST['quotationnum'];
$lpovalidity=$_REQUEST['lpovalidity'];
$expenditure=$_REQUEST['expenditure'];
$vatpercent=$_REQUEST['vatpercent'];
$purchasetype = $_REQUEST['purchasetype'];

$query55 = "select * from master_location where locationcode='$locationcode'";
$exec55 = mysql_query($query55) or die(mysql_error());
$res55 = mysql_fetch_array($exec55);
$locationname = $res55['locationname'];



$coa = $_REQUEST['accountcode'];

	$query1 = "select * from master_accountname where id='$suppliercode'";
	$exec1 = mysql_query($query1) or die(mysql_num_rows());
	$res1 = mysql_fetch_array($exec1);
	$accountssubanum = $res1['accountssub'];

	$query11 = "select * from master_accountssub where auto_number='$accountssubanum'";
	$exec11 = mysql_query($query11) or die(mysql_error());
	$res11 = mysql_fetch_array($exec11);
	$accountssubid = $res11['id'];
	$totalquantity = '0';
$billautonumber=0;
for ($i=1;$i<=1000;$i++)
{
//$itemname = $_POST['itemname1'][$key];
if(isset($_REQUEST['itemname'.$i]))
{
$itemcode = $_REQUEST['itemcode'.$i]?$_REQUEST['itemcode'.$i]:'';
$itemname = $_REQUEST['itemname'.$i]?$_REQUEST['itemname'.$i]:'';
$rate = $_REQUEST['rateperunit'.$i]?$_REQUEST['rateperunit'.$i]:'';
$rate = str_replace(',','',$rate);
$quantity = $_REQUEST['quantity'.$i]?$_REQUEST['quantity'.$i]:'';
$free = $_REQUEST['freequantity'.$i]?$_REQUEST['freequantity'.$i]:'';
$itemtaxpercent = $_REQUEST['itemtaxpercent'.$i]?$_REQUEST['itemtaxpercent'.$i]:'';
$itemtaxamount = $_REQUEST['itemtaxamount'.$i]?$_REQUEST['itemtaxamount'.$i]:'';
$itemdiscountpercent = $_REQUEST['itemdiscountpercent'.$i]?$_REQUEST['itemdiscountpercent'.$i]:'';
$discountamount = $_REQUEST['discountamount'.$i]?$_REQUEST['discountamount'.$i]:'';
$totalamount = $_REQUEST['totalamount'.$i];
$totalamount = str_replace(',','',$totalamount);
$totalquantity = $totalquantity + $quantity;

		
	if($itemname !='')
	{


			$query4 = "insert into manual_lpo (companyanum, billnumber, itemname, rate, quantity, subtotal, free, discountpercentage, totalamount, 
			discountamount, username, ipaddress, entrydate, itemtaxpercentage, itemtaxamount, itemfreequantity, itemtotalquantity,suppliername,suppliercode, locationcode, locationname,project,budgetline,budgetcode,warrenty,deliveryortransport,termsofpayment,address,authorisedby,quotationnum,lpovalidity,expenditure,vatpercent,itemcode,purchasetype) 
			values ('$companyanum', '$billnumber', '$itemname', '$rate', '$quantity', '$totalamount', '$free', '$itemdiscountpercent', '$totalamount', '$discountamount', '$username', '$ipaddress', '$billdate', 
			'$itemtaxpercent', '$itemtaxamount', '$free', '$quantity', '$suppliername','$suppliercode',  '$locationcode', '$locationname','$project','$budgetline','$budgetcode','$warrenty','$deliveryortransport','$payment','$address','$authorisedby','$quotationnum','$lpovalidity','$expenditure','$vatpercent','$itemcode','$purchasetype')";
			$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	}
			
}
}
		

header("location:manuallpo.php?otcbillnumber=$billnumber");
}
$query2 = "select * from settings_purchase where companyanum = '$companyanum'";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	$res2 = mysql_fetch_array($exec2);
	$f18=$res2['f18'];
	$f19=$res2['f19'];
	$f21=$res2['f21'];
	$f22=$res2['f22'];
	
	$billnumberprefix = $res2['billnumberprefix'];
	$billnumberprefix = strtoupper($billnumberprefix);
	$billnumberprefix = trim($billnumberprefix);

	$billnumberpostfix = $res2['billnumberpostfix'];
	$billnumberpostfix = strtoupper($billnumberpostfix);
	$billnumberpostfix = trim($billnumberpostfix);
	
	//$reftext = $res2["reftext"];
	//$billstarttext  = $res2["billstarttext"];
	//$billendtext = $res2["billendtext"];
	$f29 = $res2['f29'];
	$f30 = $res2['f30'];
	$footerline1 = $res2['f18'];
	$footerline2 = $res2['f19'];
	$footerline3 = $res2['f21'];
	$footerline4 = $res2['22'];
	$footerline5 = $res2['f25'];
	$footerline6 = $res2['f26'];
?>