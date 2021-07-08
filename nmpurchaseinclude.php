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

$paynowbillprefix = 'NMP-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from master_purchase where companyanum = '$companyanum' and typeofpurchase='NMManual' order by auto_number desc";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$res2billnumber = $res2["billnumber"];
$billdigit=strlen($res2billnumber);
if ($res2billnumber == '')
{
	$billnumber ='NMP-'.'1';
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
	
	
	$billnumber = 'NMP-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
$billnumber = $billnumber;
//$store = $_REQUEST['store1'];
$billdate = $_REQUEST['ADate'];
$suppliername = $_REQUEST['supplier'];
$suppliercode = $_REQUEST['suppliercode'];
//$ponumber = $_REQUEST['pono'];
//$accountssubid = $_REQUEST['accountssubid'];
$currency1 = $_REQUEST['currency'];
$currencysp = explode('||',$currency1);
$currency = $currencysp[1];
$fxrate = $currencysp[0];

$supplierbillno = $_REQUEST['supplierbillnumber'];
$amount = $_REQUEST['totalamount'];
$amount = str_replace(',','',$amount);
$fxamount1 = $amount * $fxrate;
$fxamount1 = str_replace(',','',$fxamount1);

$query23 = "select * from master_employee where username='$username'";
$exec23 = mysql_query($query23) or die(mysql_error());
$res23 = mysql_fetch_array($exec23);
$res7locationanum = $res23['location'];
$subtotal = $_REQUEST['subtotal'];
$subtotal = str_replace(',','',$subtotal);
$subtotalaftercombinediscount = $_REQUEST['subtotalaftercombinediscount'];
$subtotalaftercombinediscount = str_replace(',','',$subtotalaftercombinediscount);
$totalaftertax = $_REQUEST['totalaftertax'];
$totalaftertax = str_replace(',','',$totalaftertax);
$packaging = $_REQUEST['packaging'];
$packaging = str_replace(',','',$packaging);
$delivery = $_REQUEST['delivery'];
$delivery = str_replace(',','',$delivery);
$roundoff = $_REQUEST['roundoff'];
$roundoff = str_replace(',','',$roundoff);
$billtype = $_REQUEST['billtype'];
$creditamount = $_REQUEST['creditamount'];
$creditamount = str_replace(',','',$creditamount);
$subtotaldiscountpercentapply1 = $_REQUEST['subtotaldiscountpercentapply1'];
$subtotaldiscountpercentapply1 = str_replace(',','',$subtotaldiscountpercentapply1);
$subtotaldiscountamountapply1 = $_REQUEST['subtotaldiscountamountapply1'];
$subtotaldiscountamountapply1 = str_replace(',','',$subtotaldiscountamountapply1);
$subtotaldiscountamountonlyapply1 = $_REQUEST['subtotaldiscountamountonlyapply1'];
$subtotaldiscountamountonlyapply1 = str_replace(',','',$subtotaldiscountamountonlyapply1);
$subtotaldiscountamountonlyapply2 = $_REQUEST['subtotaldiscountamountonlyapply2'];
$subtotaldiscountamountonlyapply2 = str_replace(',','',$subtotaldiscountamountonlyapply2);
$cashamount = $_REQUEST['cashamount'];
$cashamount = str_replace(',','',$cashamount);
$locationcode = $_REQUEST['location'];

$query55 = "select * from master_location where locationcode='$locationcode'";
$exec55 = mysql_query($query55) or die(mysql_error());
$res55 = mysql_fetch_array($exec55);
$location = $res55['locationname'];

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
$itemname = $_REQUEST['itemname'.$i];
$itemname = addslashes($itemname);
$rate = $_REQUEST['rateperunit'.$i];
$rate = str_replace(',','',$rate);
$quantity = $_REQUEST['quantity'.$i];
$free = $_REQUEST['freequantity'.$i];
$totalamount = $_REQUEST['totalamount'.$i];
$totalamount = str_replace(',','',$totalamount);
$itemfxamount = $totalamount * $fxrate;
$totalquantity = $totalquantity + $quantity;

$account = $_REQUEST['account'.$i];
$coa = $_REQUEST['accountcode'.$i];
		
	if($itemname !='')
	{
			$query4 = "insert into purchase_details (bill_autonumber, companyanum, billnumber, itemname, rate, quantity, subtotal, free, discountpercentage, totalamount, 
			discountamount, username, ipaddress, entrydate, itemtaxpercentage, itemtaxamount, itemfreequantity, itemtotalquantity,  typeofpurchase,suppliername,suppliercode,supplierbillnumber,location,coa,locationcode,expense,expensecode) 
			values ('$billautonumber', '$companyanum', '$billnumber', '$itemname', '$rate', '$quantity', '$itemfxamount', '$free', '$itemdiscountpercent', '$itemfxamount', '$discountamount', '$username', '$ipaddress', '$billdate', 
			'$itemtaxpercent', '$itemtaxamount', '$free', '$quantity', 'NMManual','$suppliername','$suppliercode','$supplierbillno','$location','$coa','$locationcode','$account','$coa')";
			$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	}
	
	$query44 = "select accountssub from master_accountname where id = '$coa'";
	$exec44 = mysql_query($query44) or die ("Error in Query44".mysql_error());
	$res44 = mysql_fetch_array($exec44);
	$accountssub = $res44['accountssub'];
	
	if($accountssub == '16')
	{
		$query4asset = "insert into assets_register (bill_autonumber, companyanum, billnumber, itemname, rate, quantity, subtotal, free, discountpercentage, totalamount, 
			discountamount, username, ipaddress, entrydate, itemtaxpercentage, itemtaxamount, itemfreequantity, itemtotalquantity,  typeofpurchase,suppliername,suppliercode,supplierbillnumber,location,coa,locationcode,assetledger,assetledgercode,mrnno) 
			values ('$billautonumber', '$companyanum', '$billnumber', '$itemname', '$rate', '$quantity', '$itemfxamount', '$free', '$itemdiscountpercent', '$itemfxamount', '$discountamount', '$username', '$ipaddress', '$billdate', 
			'$itemtaxpercent', '$itemtaxamount', '$free', '$quantity', 'NMManual','$suppliername','$suppliercode','$supplierbillno','$location','$coa','$locationcode','$account','$coa','$billnumber')";
		$exec4asset = mysql_query($query4asset) or die ("Error in Query4asset".mysql_error());
	}
			
}
}
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CREDIT';
		$particulars = 'BY CREDIT (Inv NO:'.$billnumber.$supplierbillno.')';	
		//include ("transactioninsert1.php");
		$query9 = "insert into master_transactionpharmacy (transactiondate, particulars, supplieranum, suppliername, 
		transactionmode, transactiontype, transactionamount, creditamount,balanceamount,
		billnumber, billanum, ipaddress, updatedate,  companyanum, companyname, transactionmodule,suppliercode,locationcode, locationname) 
		values ('$billdate', '$particulars', '$accountssubid', '$suppliername', 
		'$transactionmode', '$transactiontype', '$fxamount1', '$fxamount1', '$fxamount1',
		'$billnumber',  '$billautonumber', '$ipaddress', '$updatedate', '$companyanum', '$companyname', '$transactionmodule1','$suppliercode','$locationcode', '$location')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		
		$transactiontype = 'PURCHASE';
		$transactionmode = 'BILL';
		$particulars = 'BY PURCHASE (Inv NO:'.$billnumber.$supplierbillno.')';	
		//include ("transactioninsert1.php");
		$query9 = "insert into master_transactionpharmacy (transactiondate, particulars, supplieranum, suppliername, 
		transactionmode, transactiontype, transactionamount,
		billnumber, billanum, ipaddress, updatedate,  companyanum, companyname, transactionmodule,suppliercode, locationcode, locationname) 
		values ('$billdate', '$particulars', '$accountssubid', '$suppliername', 
		'$transactionmode', '$transactiontype', '$fxamount1', 
		'$billnumber',  '$billautonumber', '$ipaddress', '$updatedate', '$companyanum', '$companyname', '$transactionmodule1','$suppliercode','$locationcode', '$location')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		
		$query3 = "insert into master_purchase (companyanum, billnumber, billdate, suppliercode, suppliername,totalamount,totalquantity,ipaddress,supplierbillnumber,typeofpurchase
		,subtotal,packaging,delivery,subtotalaftercombinediscount,roundoff,billtype,subtotaldiscountpercentapply1,subtotaldiscountamountapply1,subtotalaftertax,
		username,credit,cash,subtotaldiscountamountonlyapply1,subtotaldiscountamountonlyapply2,locationcode, locationname,mrnno)values('$companyanum','$billnumber','$billdate','$suppliercode', '$suppliername','$fxamount1','$totalquantity','$ipaddress','$supplierbillno','NMManual',
		'$fxamount1','$packaging','$delivery','$subtotalaftercombinediscount','$roundoff','$billtype','$subtotaldiscountpercentapply1','$subtotaldiscountamountapply1','$totalaftertax',
		'$username','$fxamount1','$cashamount','$subtotaldiscountamountonlyapply1','$subtotaldiscountamountonlyapply2','$locationcode', '$location','$billnumber')";
		$exec3 = mysql_query($query3) or die(mysql_error());


header("location:nmpurchase.php?invoice_number=$billnumber");
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