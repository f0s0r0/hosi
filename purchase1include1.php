<?php
$lastupdate = date('Y-m-d H:i:s');
$billtime = date("H:i:s");
$financialyear = $_SESSION["financialyear"];
$username = $_SESSION['username'];
$balanceamount = '';


//echo $companyanum;
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
//$frm1submit1 = $_REQUEST["frm1submit1"];
if ($frm1submit1 == 'frm1submit1')
{
	$billnumber = $_REQUEST['billnumber'];
	$supplierbillnumber=$_REQUEST['supplierbillnumber'];
	$location = $_REQUEST['location'];
	$storeanum = $_REQUEST['store'];
	
	$query23 = "select * from master_employee where username='$username'";
$exec23 = mysql_query($query23) or die(mysql_error());
$res23 = mysql_fetch_array($exec23);
$res7locationanum = $res23['location'];

 $query55 = "select * from master_location where locationcode='$location'";
$exec55 = mysql_query($query55) or die(mysql_error());
$res55 = mysql_fetch_array($exec55);
$locationcode = $res55['locationcode'];
$locationname = $res55['locationname'];
$res7storeanum = $res23['store'];

$query75 = "select * from master_store where auto_number='$storeanum'";
$exec75 = mysql_query($query75) or die(mysql_error());
$res75 = mysql_fetch_array($exec75);
//$store = $res75['store'];
$store = $storeanum;

	//bill number for bill save.
	$query201 = "select * from master_purchase where billnumber = '$billnumber' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";
	$exec201 = mysql_query($query201) or die ("Error in  Query201".mysql_error());
	$rowcount201 = mysql_fetch_array($exec201);
	if ($rowcount201 != 0) //If bill number already present, go for the latest bill number.
	{
		$query2 = "select max(billnumber) as maxbillnumber from master_purchase where companyanum = '$companyanum'";// order by auto_number desc limit 0, 1";
		$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		$res2 = mysql_fetch_array($exec2);
		$res2billnumber = $res2['maxbillnumber'];
		if ($res2billnumber == '')
		{
			$billnumber = '1';
		}
		else
		{
			$billnumber = $res2['maxbillnumber'];
			$billnumber = $billnumber + 1;
		}
	}
	
	$delbillnumber = $_REQUEST['delbillnumber'];
	if ($delbillnumber != '')
	{
		$billnumber = $delbillnumber; 
	}

	
	$billnumberprefix = $_REQUEST['billnumberprefix'];
	$billnumberpostfix = $_REQUEST['billnumberpostfix'];
	
	$query751 = "select * from master_financialintegration where field='grn'";
	$exec751 = mysql_query($query751) or die(mysql_error());
	$res751 = mysql_fetch_array($exec751);
	$coa = $res751['code'];
	
	$billdate = $_REQUEST['ADate'];
	$suppbilldate = $_REQUEST['ADate2'];
	/*
	$dotarray = explode("-", $billdate);
	//print_r($dotarray);
	$billyear = $dotarray[2];
	$billyear = substr($billyear, 0, 4);
	$billmonth = $dotarray[1];
	$billday = $dotarray[0];
	$billtime = date("H:i:s");
	$billdate = $billyear.'-'.$billmonth.'-'.$billday.' '.$billtime;
	$billdate = $billdate.' '.$billtime;
	*/
	
	if (isset($_REQUEST["suppliertype"])) { $suppliertype = $_REQUEST["suppliertype"]; } else { $suppliertype = ""; }
	//$suppliertype = $_REQUEST["suppliertype"];
	if (isset($_REQUEST["suppliercode"])) { $suppliercode = $_REQUEST["suppliercode"]; } else { $suppliercode = ""; }
	//$suppliercode = $_REQUEST["suppliercode"];

	$query101 = "select * from master_supplier where suppliercode = '$suppliercode'";
	$exec101 = mysql_query($query101) or die ("Error in Query101".mysql_error());
	$res101 = mysql_fetch_array($exec101);
	$supplieranum = $res101['auto_number'];
	
	$query1 = "select * from master_accountname where id='$suppliercode'";
	$exec1 = mysql_query($query1) or die(mysql_num_rows());
	$res1 = mysql_fetch_array($exec1);
	$accountssubanum = $res1['accountssub'];
	
	$query11 = "select * from master_accountssub where auto_number='$accountssubanum'";
	$exec11 = mysql_query($query11) or die(mysql_error());
	$res11 = mysql_fetch_array($exec11);
	$accountssubid = $res11['id'];
	
	$suppliername = strtoupper($_REQUEST['supplier']);
	$supplierbillnumber = $_REQUEST['supplierbillnumber'];
	$address = strtoupper($_REQUEST['address1']);
	$location = strtoupper($_REQUEST['area']);
	$city = strtoupper($_REQUEST['city1']);
	$state = strtoupper($res101['state']);
	$pincode = strtoupper($_REQUEST['pincode']);
	$phone = "";
	$email = "";
	$tinnumber = strtoupper($_REQUEST['suppliertin']);
	$cstnumber = strtoupper($_REQUEST['suppliercst']);
	$deliveryaddress = $_REQUEST["deliveryaddress"];
	
	$subtotal = $_REQUEST['subtotal'];
	$packaging = $_REQUEST['packaging'];
	$delivery = $_REQUEST['delivery'];
	$totalamount = $_REQUEST['totalamount'];
	$totalquantity = "";
	$billtype = $_REQUEST['billtype'];
	$cash = $_REQUEST['cashamount'];
	$credit = $_REQUEST['creditamount'];
	$creditcard = $_REQUEST['cardamount'];
	$online = $_REQUEST['onlineamount'];
	$creditcardname = strtoupper($_REQUEST['cardname']);
	$creditcardnumber = strtoupper($_REQUEST['cardnumber']);
	//$creditcardbank = strtoupper($_REQUEST['bankname']);
	$bankanum = $_REQUEST['bankname'];
	$query7 = "select * from master_bank where auto_number = '$bankanum'";
	$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
	$res7 = mysql_fetch_array($exec7);
	$creditcardbank = $res7['bankname'];
	
	$remarks = strtoupper($_REQUEST['remarks']);
	$username = $username;
	$subtotaldiscountrupees = $_REQUEST['subtotaldiscountrupees'];
	$subtotaldiscountpercent = $_REQUEST['subtotaldiscountpercent'];
	if ($subtotaldiscountpercent != '0.00')
	{
		$subtotaldiscounttotal = $subtotal / 100;
		$subtotaldiscounttotal = $subtotaldiscounttotal * $subtotaldiscountpercent;
	}
	else
	{
		$subtotaldiscounttotal = $subtotaldiscountrupees;
	}
	$subtotalafterdiscount = $_REQUEST['afterdiscountamount'];
	
	$subtotalamountdiscountpercent = $_REQUEST['subtotaldiscountpercentapply1'];
	$subtotalamountdiscountamount = $_REQUEST['subtotaldiscountamountapply1'];
	$subtotalaftercombinediscount = $_REQUEST['subtotalaftercombinediscount'];
	
	$subtotalaftertax = $_REQUEST['totalaftertax'];
	
	$subtotaldiscountpercentapply1 = $_REQUEST['subtotaldiscountpercentapply1'];
	$subtotaldiscountamountapply1 = $_REQUEST['subtotaldiscountamountapply1'];
	$subtotaldiscountamountonlyapply1 = $_REQUEST['subtotaldiscountamountonlyapply1'];
	$subtotaldiscountamountonlyapply2 = $_REQUEST['subtotaldiscountamountonlyapply2'];
	
	$deliverymode = "";
	$totalweight = "";
	$roundoff = $_REQUEST['roundoff'];
	//$lastupdate = $billdate;
	$lastupdateusername = $username;
	$lastupdateipaddress = $ipaddress;
	
	$cashgivenbysupplier = $_REQUEST['cashgivenbysupplier'];
	$cashgiventosupplier = $_REQUEST['cashgiventosupplier'];
	
	//$footerline1 = $_REQUEST['footerline1'];
	$footerline1 = ''; 
	$footerline2 = $_REQUEST['footerline2'];
	$footerline3 = $_REQUEST['footerline3'];
	$footerline4 = $_REQUEST['footerline4'];
	$footerline5 = "";
	$footerline6 = "";
	
	$query2 = "select * from settings_approval where modulename = 'purchase' and status <> 'deleted'";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	$res2 = mysql_fetch_array($exec2);
	$approvalrequired = $res2['approvalrequired'];
	if ($approvalrequired == 'YES')	{
		$approvalstatus = 'PENDING';
	}
	else {
		$approvalstatus = 'APPROVED';
	}
	
	$query3 = "insert into master_purchase (companyanum, billnumber, billdate, suppliertype, subtotal, suppliercode, suppliername, 
	address, location, city, state, pincode, phone, email, tinnumber, cstnumber, 
	roundoff, delivery, totalamount, totalquantity, billtype, cash, credit, online, creditcard, creditcardname, 
	footerline1, footerline2, footerline3, footerline4, footerline5, footerline6, subtotalafterdiscount, subtotalaftertax, 
	creditcardnumber, creditcardbankname, remarks, username, subtotaldiscountrupees, subtotaldiscountpercent, subtotaldiscounttotal, deliverymode, 
	lastupdate, ipaddress, billnumberprefix, billnumberpostfix, packaging, cashgivenbysupplier, cashgiventosupplier, approvalstatus, 
	deliveryaddress, subtotalamountdiscountpercent, subtotalamountdiscountamount, subtotalaftercombinediscount, 
	subtotaldiscountpercentapply1, subtotaldiscountamountapply1, subtotaldiscountamountonlyapply1, subtotaldiscountamountonlyapply2, supplierbillnumber,supplierbilldate,typeofpurchase,locationcode,locationname) 	
	values ('$companyanum', '$billnumber', '$billdate', '$suppliertype', '$subtotal', '$suppliercode', '$suppliername', 
	'$address', '$locationname', '$city', '$state', '$pincode', '$phone', '$email', '$tinnumber', '$cstnumber',  
	'$roundoff', '$delivery', 
	'$totalamount', '$totalquantity', '$billtype', '$cash', '$credit', '$online', '$creditcard', '$creditcardname', 
	'$footerline1', '$footerline2', '$footerline3', '$footerline4', '$footerline5', '$footerline6', '$subtotalafterdiscount', '$subtotalaftertax', 
	'$creditcardnumber', '$creditcardbank', '$remarks', '$username', '$subtotaldiscountrupees', '$subtotaldiscountpercent', '$subtotaldiscounttotal', '$deliverymode', 
	'$lastupdate', '$lastupdateipaddress', '$billnumberprefix', '$billnumberpostfix', '$packaging', 
	'$cashgivenbysupplier', '$cashgiventosupplier', '$approvalstatus', 
	'$deliveryaddress', '$subtotalamountdiscountpercent', '$subtotalamountdiscountamount', '$subtotalaftercombinediscount', 
	'$subtotaldiscountpercentapply1', '$subtotaldiscountamountapply1', '$subtotaldiscountamountonlyapply1', '$subtotaldiscountamountonlyapply2', '$supplierbillnumber','$suppbilldate','Manual','$locationcode','$locationname')";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	
	
	$query3 = "select auto_number from master_purchase  where companyanum = '$companyanum' and suppliercode = '$suppliercode' and lastupdate = '$lastupdate' and 
	billdate = '$billdate' and totalamount = '$totalamount' and billnumber = '$billnumber' and billtype = '$billtype'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	$res3 = mysql_fetch_array($exec3);
	$res3anum = $res3['auto_number'];
	$billautonumber = $res3anum;

	for ($i=1;$i<=1000;$i++)
	{
		if (isset($_REQUEST["serialnumber".$i]))
		{
			$serialnumber = $_REQUEST["serialnumber".$i];
		}
		else
		{
			$serialnumber = "";
		}
		//$serialnumber = $_REQUEST["serialnumber".$i];
		if ($serialnumber != '')
		{
			$itemcode = $_REQUEST['itemcode'.$i];
			
			$query31 = "select * from master_itempharmacy where itemcode = '$itemcode'"; 
			$exec31 = mysql_query($query31) or die ("Error in Query31".mysql_error());
			$res31 = mysql_fetch_array($exec31);
			$itemunitabb = $res31['unitname_abbreviation'];
			$res31packageanum = $res31['packageanum'];
			
			$itemname = $_REQUEST['itemname'.$i];
			$itemmrp = $_REQUEST['rateperunit'.$i];
			$itemquantity = $_REQUEST['quantity'.$i];
			$itemfreequantity = $_REQUEST['freequantity'.$i];
			$itemtotalquantity = $_REQUEST['totalquantity'.$i];
			$itemdiscountpercent = $_REQUEST['discountpercent'.$i];
			$itemdiscountrupees = $_REQUEST['discountrupees'.$i];
			$itemtaxpercent = $_REQUEST['taxpercent'.$i];
			$itemtaxname = $_REQUEST['taxname'.$i];
			$itemtaxautonumber = $_REQUEST['taxautonumber'.$i];
			$itemtotalamount = $_REQUEST['totalamount'.$i];
			$costprice = $_REQUEST['costprice'.$i];
			if (isset($_REQUEST["itemdescription".$i]))
			{
				$itemdescription = $_REQUEST["itemdescription".$i];
			}
			else
			{
				$itemdescription = "";
			}
			$batchnumber = $_REQUEST['batchnumber'.$i];
			//$batchnumber = strtoupper($batchnumber);
			$salesprice = $_REQUEST['salesprice'.$i];
			$expirydate = $_REQUEST['expirydate'.$i];
			$packagename = $_REQUEST['packagename'.$i];
			//$packagename = stripslashes($packagename);
			$packagename = addslashes($packagename);
			$manufacturername = $_REQUEST['manufacturername'.$i];
			$manufacturername = addslashes($manufacturername);
			
		    $query43 = "select * from master_itempharmacy where itemcode = '$itemcode'";//and packagename = ''";//or packageanum = '') ";
			$exec43 = mysql_query($query43) or die ("Error in Query43".mysql_error());
			$rowcount43 = mysql_num_rows($exec43);
			while($result43 = mysql_fetch_array($exec43))
			{
				if ($rowcount43 != 0)
				{
					 $res43packageanum = $result43['packageanum'];
					if($res43packageanum == '0')
					{
						$query32 = "select * from master_packagepharmacy where packagename = '$packagename'";//packagename = '$packagename'";
						$exec32 = mysql_query($query32) or die ("Error in Query32".mysql_error());
						$res32 = mysql_fetch_array($exec32);
						$packageanum = $res32['auto_number'];
			
						$query44 = "update master_itempharmacy set packagename = '$packagename', packageanum = '$packageanum'
						where itemcode = '$itemcode' and packageanum = '0'";
						$exec44 = mysql_query($query44) or die ("Error in Query44".mysql_error());	
						
						$query44 = "update master_medicine set packagename = '$packagename', packageanum = '$packageanum'
						where itemcode = '$itemcode' and packageanum = '0'";
						$exec44 = mysql_query($query44) or die ("Error in Query44".mysql_error());	
					}
					
					$res43packagename = $result43['packagename'];
					if($res43packagename == '')
					{
						$query32 = "select * from master_packagepharmacy where packagename = '$packagename'";//packagename = '$packagename'";
						$exec32 = mysql_query($query32) or die ("Error in Query32".mysql_error());
						$res32 = mysql_fetch_array($exec32);
						$packageanum = $res32['auto_number'];
			
						$query44 = "update master_itempharmacy set packagename = '$packagename', packageanum = '$packageanum'
						where itemcode = '$itemcode' and packagename = ''";
						$exec44 = mysql_query($query44) or die ("Error in Query44".mysql_error());	
						
						$query44 = "update master_medicine set packagename = '$packagename', packageanum = '$packageanum'
						where itemcode = '$itemcode' and packageanum = '0'";
						$exec44 = mysql_query($query44) or die ("Error in Query44".mysql_error());	
					}
				}
			}
			
			$query31 = "select * from master_itempharmacy where itemcode = '$itemcode'"; 
			$exec31 = mysql_query($query31) or die ("Error in Query31".mysql_error());
			$res31 = mysql_fetch_array($exec31);
			$itemunitabb = $res31['unitname_abbreviation'];
			$res31packageanum = $res31['packageanum'];
			$categoryname = $res31['categoryname'];

			//$packagename = addslashes($packagename);
			$query32 = "select * from master_packagepharmacy where auto_number = '$res31packageanum'";//packagename = '$packagename'";
			$exec32 = mysql_query($query32) or die ("Error in Query32".mysql_error());
			$res32 = mysql_fetch_array($exec32);
			$packageanum = $res32['auto_number'];
			$quantityperpackage = $res32['quantityperpackage'];
			
			$allpackagetotalquantity =  $itemtotalquantity;
			
			$query33 = "select * from master_manufacturerpharmacy where manufacturername = '$manufacturername'";
			$exec33 = mysql_query($query33) or die ("Error in Query33".mysql_error());
			$res33 = mysql_fetch_array($exec33);
			$manufactureranum = $res33['auto_number'];
			
			$expirymonth = substr($expirydate, 0, 2);
			$expiryyear = substr($expirydate, 3, 2);
			$expiryday = '01';
			$expirydate = $expiryyear.'-'.$expirymonth.'-'.$expiryday;
			
			$itemsubtotal = $itemmrp * $itemquantity;
			
			$itemtaxamount = $itemsubtotal / 100;
			$itemtaxamount = $itemtaxamount * $itemtaxpercent;
			
			if ($itemdiscountpercent != '0.00')
			{
				$discountamount = $itemsubtotal * $itemdiscountpercent;
				$discountamount = $discountamount / 100;
				
			}
			else
			{
				$discountamount = $itemdiscountrupees;
			}
			
			$query5 = "select * from master_itempharmacy where itemcode = '$itemcode'";
			$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
			$res5 = mysql_fetch_array($exec5);
			$itemanum = $res5['auto_number'];
			$itemname = $res5['itemname'];
			$itemname = addslashes($itemname);
			
			$free = "";
			$openingstock = "";
			$closingstock = "";
			//$suppliercode = "";
			//$suppliername = "";
			
			$query4 = "insert into purchase_details (bill_autonumber, companyanum, 
			billnumber, itemanum, itemcode, itemname, itemdescription, rate, quantity, 
			subtotal, free, discountpercentage, discountrupees, openingstock, closingstock, totalamount, 
			discountamount, username, ipaddress, entrydate, itemtaxpercentage, itemtaxamount, unit_abbreviation, 
			batchnumber, salesprice, expirydate, itemfreequantity, itemtotalquantity, 
			packageanum, packagename, quantityperpackage, allpackagetotalquantity, 
			manufactureranum, manufacturername,typeofpurchase,locationcode,store,coa,categoryname,suppliername,suppliercode,costprice,supplierbillnumber) 
			values ('$billautonumber', '$companyanum', '$billnumber', '$itemanum', '$itemcode', '$itemname', '$itemdescription', '$itemmrp', '$itemquantity', 
			'$itemsubtotal', '$free', '$itemdiscountpercent', '$itemdiscountrupees', '$opening
			stock', '$closingstock', 
			'$itemtotalamount', '$discountamount', '$username', '$ipaddress', '$billdate', 
			'$itemtaxpercent', '$itemtaxamount', '$itemunitabb', 
			'$batchnumber', '$salesprice', '$expirydate', '$itemfreequantity', '$itemtotalquantity', 
			'$packageanum', '$packagename', '$quantityperpackage', '$allpackagetotalquantity', 
			'$manufactureranum', '$manufacturername','Manual','$locationcode','$store','$coa','$categoryname','$suppliername','$suppliercode','$costprice','$supplierbillnumber')";
			$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
			
			if ($salesprice != '0.00')
			{
				$query42 = "update master_itempharmacy set rateperunit = '$salesprice', purchaseprice = '$itemmrp' 
				where itemcode = '$itemcode'";
				$exec42 = mysql_query($query42) or die ("Error in Query42".mysql_error());
				
				$query42 = "update master_medicine set rateperunit = '$salesprice', purchaseprice = '$itemmrp' 
				where itemcode = '$itemcode'";
				$exec42 = mysql_query($query42) or die ("Error in Query42".mysql_error());
			}
		    /*$query48 = "select * from master_itempharmacy where itemcode = '$itemcode' and packageanum = '' ";
			$exec48 = mysql_query($query48) or die ("Error in Query48".mysql_error());
			$rowcount48 = mysql_num_rows($exec48);
			if ($rowcount48 != 0)
			{
			$query49 = "update master_itempharmacy set packageanum = '$packageanum'
				where itemcode = '$itemcode' and packageanum = '' ";
				$exec49 = mysql_query($query49) or die ("Error in Query49".mysql_error());
			}*/
			
			
			$query45 = "select * from master_itempharmacy where itemcode = '$itemcode' and manufacturername = ''";
			$exec45 = mysql_query($query45) or die ("Error in Query45".mysql_error());
			$rowcount45 = mysql_num_rows($exec45);
			if ($rowcount45 != 0)
			{
				$query46 = "update master_itempharmacy set manufactureranum = '$manufactureranum', manufacturername = '$manufacturername' 
				where itemcode = '$itemcode' and manufacturername = ''";
				$exec46 = mysql_query($query46) or die ("Error in Query46".mysql_error());
				
				$query46 = "update master_medicine set manufactureranum = '$manufactureranum', manufacturername = '$manufacturername' 
				where itemcode = '$itemcode' and manufacturername = ''";
				$exec46 = mysql_query($query46) or die ("Error in Query46".mysql_error());
			}
			
			$purchaseprice = $itemmrp;
			$query47 = "update master_itempharmacy set rateperunit = '$salesprice', purchaseprice = '$purchaseprice' where itemcode = '$itemcode'";
			$exec47 = mysql_query($query47) or die ("Error in Query47".mysql_error());
			
			$query47 = "update master_medicine set rateperunit = '$salesprice', purchaseprice = '$purchaseprice' where itemcode = '$itemcode'";
			$exec47 = mysql_query($query47) or die ("Error in Query47".mysql_error());
			
			$customercode = '';
			$customername = '';
			$query41 = "insert into master_stock (itemcode, itemname, transactiondate, transactionmodule, 
			transactionparticular, billautonumber, billnumber, quantity, remarks, 
			customercode, customername, suppliercode, suppliername, username, ipaddress, rateperunit, totalrate, 
			companyanum, companyname, batchnumber, salesprice, expirydate, 
			packageanum, packagename, quantityperpackage, allpackagetotalquantity, 
			manufactureranum, manufacturername,typeofpurchase,location,store,locationcode,locationname) 
			values ('$itemcode', '$itemname', '$billdate', 'PURCHASE', 
			'BY PURCHASE (BILL NO: $billnumber )', '$billautonumber', '$billnumber', '$itemtotalquantity', '$remarks', 
			'$customercode', '$customername', '$suppliercode', '$suppliername', '$username', '$ipaddress', '$itemmrp', '$itemsubtotal', 
			'$companyanum', '$companyname', '$batchnumber', '$salesprice', '$expirydate', 
			'$packageanum', '$packagename', '$quantityperpackage', '$allpackagetotalquantity', 
			'$manufactureranum', '$manufacturername','Manual','$locationname','$store','$locationcode','$locationname')";
			$res41 = mysql_query($query41) or die ("Error in Query41".mysql_error());
		
			$taxtype = 'main';
			$taxamount = $itemtotalamount / 100;
			$taxamount = $taxamount * $itemtaxpercent;
			$taxamount = round($taxamount, 2);
			$amountaftertax = "";
			
			if ($itemcode != '')
			{
				$query7 = "insert into purchase_tax (bill_autonumber, billnumber, billdate, itemanum, itemcode, itemname, 
				itemrate, itemquantity, taxtype, 
				tax_autonumber, taxname, taxpercent, taxamount, amountaftertax, ipaddress, 
				updatedate, companyanum, companyname,locationcode,locationname) 
				values ('$billautonumber', '$billnumber', '$billdate', '$itemanum', '$itemcode',  '$itemname',  
				'$itemmrp',  '$itemquantity', '$taxtype', 
				'$itemtaxautonumber', '$itemtaxname', '$itemtaxpercent', '$taxamount', 
				'$amountaftertax', '$ipaddress', '$updatedatetime', '$companyanum', '$companyname','$locationcode','$locationname')";
				$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
			}
	
		$query72 = "select * from master_taxsub where taxparentanum = '$itemtaxautonumber' and status <> 'deleted'";
		$exec72 = mysql_query($query72) or die ("Error in Query72".mysql_error());
		$rowcount72 = mysql_num_rows($exec72);
		while ($res72 = mysql_fetch_array($exec72))
		{
			$taxsubtype = 'sub';
			$taxsub_autonumber = $res72['auto_number'];
			$taxsubname = $res72['taxsubname'];
			$taxsubpercent = $res72['taxsubpercent'];
		
			$taxsubamount = $taxamount / 100;
			$taxsubamount = $taxsubamount * $taxsubpercent;  //with main tax amount.
			$taxsubamount = round($taxsubamount, 2);
			
			//if ($taxsub_autonumber != '')
			if ($rowcount72 != 0)
			{
				if ($itemcode != '')
				{
					$query8 = "insert into purchase_tax (bill_autonumber, billnumber, billdate, itemcode, itemname, itemrate, itemquantity, taxtype, 
					tax_autonumber, taxname, taxpercent, taxamount, amountaftertax, ipaddress, 
					updatedate, companyanum, companyname,locationcode,locationname) 
					values ('$billautonumber', '$billnumber', '$billdate', '$itemcode',  '$itemname',  '$itemrate',  '$itemquantity', '$taxsubtype', 
					'$taxsub_autonumber', '$taxsubname', '$taxsubpercent', '$taxsubamount', 
					'$amountaftertaxsub', '$ipaddress', '$updatedatetime', '$companyanum', '$companyname','$locationcode','$locationname')";
					$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
				}
			}
			$taxsubtype = '';
			$taxsub_autonumber = '';
			$taxsubname = '';
			$taxsubpercent = '';
			$taxsubamount = '';
		}
				
		$taxtype = '';
		$itemcode = '';
		$itemname = '';
		$itemrate = '';
		$itemquantity = '';
		$subtotal = '';
		$itemtaxpercent = '';
		$itemtaxamount = '';
		$itemtaxautonum = '';
		$itemtaxname = '';
		$taxamount = '';

		}	
	}
	
	
	
	//For generating first code
	include ("transactioncodegenerate1pharmacy.php");


	$transactiondate = $updatedatetime;
	$supplieranum = $supplieranum;
	$suppliername = $suppliername;
	$transactionamount = $totalamount;
	$ipaddress = $ipaddress;
	$updatedate = $updatedatetime;
	
	//to update transaction master form transaction report.
	$transactiontype1 = 'PURCHASE';
	$transactionmode1 = 'BILL';
	$transactionmodule1 = 'PURCHASE';
	$particulars1 = 'BY PURCHASE (Inv NO:'.$billnumberprefix.$supplierbillnumber.')';	
	//include ("transactioninsert1.php");
	$query9 = "insert into master_transactionpharmacy (transactioncode, transactiondate, particulars, supplieranum, suppliername, 
	transactionmode, transactiontype, transactionamount, billnumber, billanum, ipaddress, 
	updatedate, balanceamount, companyanum, companyname, transactionmodule,typeofpurchase,suppliercode,username,locationcode,locationname) 
	values ('$transactioncode', '$transactiondate', '$particulars1', '$supplieranum', '$suppliername', 
	'$transactionmode1', '$transactiontype1', '$transactionamount', '$billnumber',  '$billautonumber', 
	'$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$transactionmodule1','Manual','$suppliercode','$username','$locationcode','$locationname')";
	$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
	
	
	//For generating second code
	include ("transactioncodegenerate1pharmacy.php");

	$cashamount = $_REQUEST['cashamount'];
	$onlineamount = $_REQUEST['onlineamount'];
	$creditamount = $_REQUEST['creditamount'];
	$chequeamount = $_REQUEST['chequeamount'];
	$cardamount = $_REQUEST['cardamount'];
	//$writeoffamount = $_REQUEST['writeoffamount'];
	$chequenumber = $_REQUEST['chequenumber'];
	$chequedate = $_REQUEST['chequedate'];
	$bankname = $_REQUEST['bankname'];
	//$tdsamount = $_REQUEST['tdsamount'];
	
	if ($creditamount != '0.00')
	{
		$balanceamount = $balanceamount + $creditamount;
	}
	
	if ($cashamount != '0.00')
	{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CASH';
		$particulars = 'BY CASH (Inv NO:'.$billnumberprefix.$supplierbillnumber.')';	
		//include ("transactioninsert1.php");
		$query9 = "insert into master_transactionpharmacy (transactioncode, transactiondate, particulars, supplieranum, suppliername, 
		transactionmode, transactiontype, transactionamount, cashamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, transactionmodule,typeofpurchase,username,locationcode,locationname) 
		values ('$transactioncode', '$transactiondate', '$particulars', '$supplieranum', '$suppliername', 
		'$transactionmode', '$transactiontype', '$transactionamount', '$cashamount', 
		'$billnumber',  '$billautonumber', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$transactionmodule1','Manual','$username','$locationcode','$locationname')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
	}
	
	if ($creditamount != '0.00')
	{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CREDIT';
		$particulars = 'BY CREDIT (Inv NO:'.$billnumberprefix.$supplierbillnumber.')';	
		//include ("transactioninsert1.php");
		$query9 = "insert into master_transactionpharmacy (transactioncode, transactiondate, particulars, supplieranum, suppliername, 
		transactionmode, transactiontype, transactionamount, creditamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, transactionmodule,typeofpurchase,suppliercode,username,locationcode,locationname) 
		values ('$transactioncode', '$transactiondate', '$particulars', '$accountssubid', '$suppliername', 
		'$transactionmode', '$transactiontype', '$transactionamount', '$creditamount', 
		'$billnumber',  '$billautonumber', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$transactionmodule1','Manual','$suppliercode','$username','$locationcode','$locationname')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
	}
	
	if ($onlineamount != '0.00')
	{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'ONLINE';
		$particulars = 'BY ONLINE (Inv NO:'.$billnumberprefix.$supplierbillnumber.')';	
		//include ("transactioninsert1.php");
		$query9 = "insert into master_transactionpharmacy (transactioncode, transactiondate, particulars, supplieranum, suppliername, 
		transactionmode, transactiontype, transactionamount, onlineamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, transactionmodule,typeofpurchase,username,locationcode,locationname) 
		values ('$transactioncode', '$transactiondate', '$particulars', '$supplieranum', '$suppliername', 
		'$transactionmode', '$transactiontype', '$transactionamount', '$onlineamount', 
		'$billnumber',  '$billautonumber', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$transactionmodule1','Manual','$username','$locationcode','$locationname')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
	}
	
	if ($cardamount != '0.00')
	{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CREDIT CARD';
		$particulars = 'BY CREDIT CARD (Inv NO:'.$billnumberprefix.$supplierbillnumber.')';	
		//include ("transactioninsert1.php");
		$query9 = "insert into master_transactionpharmacy (transactioncode, transactiondate, particulars, supplieranum, suppliername, 
		transactionmode, transactiontype, transactionamount, cardamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, transactionmodule,typeofpurchase,username,locationcode,locationname) 
		values ('$transactioncode', '$transactiondate', '$particulars', '$supplieranum', '$suppliername', 
		'$transactionmode', '$transactiontype', '$transactionamount', '$cardamount', 
		'$billnumber',  '$billautonumber', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$transactionmodule1','Manual','$username','$locationcode','$locationname')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
	}

	if ($chequeamount != '0.00')
	{
	$transactiontype = 'PAYMENT';
	$transactionmode = 'CHEQUE';
	$particulars = 'BY CHEQUE (Inv NO:'.$billnumberprefix.$supplierbillnumber.')';		
	//include ("transactioninsert1.php");
	$query9 = "insert into master_transactionpharmacy (transactioncode, transactiondate, particulars, supplieranum, suppliername, 
	transactionmode, transactiontype, transactionamount,
	chequeamount,chequenumber, billnumber, billanum, 
	chequedate, bankname, bankbranch, ipaddress, updatedate, balanceamount, companyanum, companyname, transactionmodule,typeofpurchase,username,locationcode,locationname) 
	values ('$transactioncode', '$transactiondate', '$particulars', '$supplieranum', '$suppliername', 
	'$transactionmode', '$transactiontype', '$transactionamount',
	'$chequeamount','$chequenumber',  '$billnumber',  '$billautonumber', 
	'$chequedate', '$bankname', '$bankbranch','$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$transactionmodule1','Manual','$username','$locationcode','$locationname')";
	$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());

	}
	
/*	if ($writeoffamount != '0.00')
	{
	$transactiontype = 'PAYMENT';
	$transactionmode = 'WRITEOFF';
	$particulars = 'BY WRITEOFF (BILL NO:'.$billnumberprefix.$billnumber.')';		
	//include ("transactioninsert1.php");
	$query9 = "insert into master_transactionpharmacy (transactioncode, transactiondate, particulars, supplieranum, suppliername, 
	transactionmode, transactiontype, transactionamount, writeoffamount,
	billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, transactionmodule,username) 
	values ('$transactioncode', '$transactiondate', '$particulars', '$supplieranum', '$suppliername', 
	'$transactionmode', '$transactiontype', '$transactionamount', '$writeoffamount', 
	'$billnumber',  '$billautonumber', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$transactionmodule1','$username')";
	$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
	}
*/	

	header ("location:purchase1.php");
	exit;


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