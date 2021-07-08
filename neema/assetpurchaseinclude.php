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
$billnumber = $_REQUEST['billnumber'];
//$store = $_REQUEST['store1'];
$billdate = $_REQUEST['ADate'];
$suppliername = $_REQUEST['supplier'];
$suppliercode = $_REQUEST['suppliercode'];
//$ponumber = $_REQUEST['pono'];
//$accountssubid = $_REQUEST['accountssubid'];
$supplierbillno = $_REQUEST['supplierbillnumber'];
$amount = $_REQUEST['totalamount'];
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
$locationcode = $_REQUEST['location'];

$query55 = "select * from master_location where locationcode='$locationcode'";
$exec55 = mysql_query($query55) or die(mysql_error());
$res55 = mysql_fetch_array($exec55);
$location = $res55['locationname'];

$coaname = $_REQUEST['account'];

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
$itemname = $_REQUEST['itemname'.$i];
$itemname = addslashes($itemname);
$rate = $_REQUEST['rateperunit'.$i];
$quantity = $_REQUEST['quantity'.$i];
$free = $_REQUEST['freequantity'.$i];
$totalamount = $_REQUEST['totalamount'.$i];
$totalquantity = $totalquantity + $quantity;


			
			
	if($itemname !='')
	{


			$query4 = "insert into assetpurchase_details (bill_autonumber, companyanum, billnumber, itemname, rate, quantity, subtotal, free, discountpercentage, totalamount, 
			discountamount, username, ipaddress, entrydate, itemtaxpercentage, itemtaxamount, itemfreequantity, itemtotalquantity,  typeofpurchase,suppliername,suppliercode,supplierbillnumber,location,locationname,coa,locationcode, asset, assetcode) 
			values ('$billautonumber', '$companyanum', '$billnumber', '$itemname', '$rate', '$quantity', '$totalamount', '$free', '$itemdiscountpercent', '$totalamount', '$discountamount', '$username', '$ipaddress', '$billdate', 
			'$itemtaxpercent', '$itemtaxamount', '$free', '$quantity', 'Asset','$suppliername','$suppliercode','$supplierbillno','$location','$location','$coa','$locationcode','$coaname','$coa')";
			$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
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
		values ('$updatedatetime', '$particulars', '$accountssubid', '$suppliername', 
		'$transactionmode', '$transactiontype', '$amount', '$amount', '$amount',
		'$billnumber',  '$billautonumber', '$ipaddress', '$updatedate', '$companyanum', '$companyname', '$transactionmodule1','$suppliercode','$locationcode', '$location')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		
		$transactiontype = 'PURCHASE';
		$transactionmode = 'BILL';
		$particulars = 'BY PURCHASE (Inv NO:'.$billnumber.$supplierbillno.')';	
		//include ("transactioninsert1.php");
		$query9 = "insert into master_transactionpharmacy (transactiondate, particulars, supplieranum, suppliername, 
		transactionmode, transactiontype, transactionamount,
		billnumber, billanum, ipaddress, updatedate,  companyanum, companyname, transactionmodule,suppliercode, locationcode, locationname) 
		values ('$updatedatetime', '$particulars', '$accountssubid', '$suppliername', 
		'$transactionmode', '$transactiontype', '$amount', 
		'$billnumber',  '$billautonumber', '$ipaddress', '$updatedate', '$companyanum', '$companyname', '$transactionmodule1','$suppliercode','$locationcode', '$location')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		
		$query3 = "insert into master_purchase (companyanum, billnumber, billdate, suppliercode, suppliername,totalamount,totalquantity,ipaddress,supplierbillnumber,typeofpurchase
		,subtotal,packaging,delivery,subtotalaftercombinediscount,roundoff,billtype,subtotaldiscountpercentapply1,subtotaldiscountamountapply1,subtotalaftertax,
		username,credit,cash,subtotaldiscountamountonlyapply1,subtotaldiscountamountonlyapply2,locationcode, locationname)values('$companyanum','$billnumber','$updatedatetime','$suppliercode', '$suppliername','$amount','$totalquantity','$ipaddress','$supplierbillno','Asset',
		'$subtotal','$packaging','$delivery','$subtotalaftercombinediscount','$roundoff','$billtype','$subtotaldiscountpercentapply1','$subtotaldiscountamountapply1','$totalaftertax',
		'$username','$creditamount','$cashamount','$subtotaldiscountamountonlyapply1','$subtotaldiscountamountonlyapply2','$locationcode', '$location')";
		$exec3 = mysql_query($query3) or die(mysql_error());


header("location:menupage1.php?mainmenuid=MM009");
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