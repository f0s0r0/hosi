<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");

$dateonly = date("Y-m-d");
$timeonly = date("H:i:s");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$currentdate = date("Y-m-d");
$updatedate=date("Y-m-d");
$titlestr = 'SALES BILL';

 $docno = $_SESSION['docno'];
						
						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname limit 0,1";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						while ($res1 = mysql_fetch_array($exec1))
						{
						$locationname = $res1["locationname"];
						$locationcode = $res1["locationcode"];
						
						}
						
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
	
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$paynowbillprefix = 'EB-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from billing_external where billstatus = '' order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["billno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='EB-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billno"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'EB-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
		//get locationcode and locationname here for insert
		$locationcodeget=$_REQUEST['locationcodeget'];
		$locationnameget=$_REQUEST['locationnameget'];
		//get locationcode ends here
		$billnumber=$billnumbercode;
		$billdate=$_REQUEST['billdate'];
		$referalname=$_REQUEST['referalname'];
		$paymentmode = $_REQUEST['billtype'];
		$chequenumber = $_REQUEST['chequenumber'];
		$chequedate = $_REQUEST['chequedate'];
		$nettamount1 = $_REQUEST['nettamount'];
		$bankname = $_REQUEST['bankname'];
		$bankbranch = $_REQUEST['bankbranch'];
		$remarks = $_REQUEST['remarks'];
		$card = $_REQUEST['cardname'];
		$cardnumber = $_REQUEST['cardnumber'];
		$bankname1 = $_REQUEST['bankname1'];
		$totalamount=$_REQUEST['totalamount'];
		$cashgivenbycustomer = $_REQUEST['cashgivenbycustomer'];
		$cashgiventocustomer = $_REQUEST['cashgiventocustomer'];
		$cashamount = $_REQUEST['cashamount'];
		$onlineamount = $_REQUEST['onlineamount'];
		$chequeamount = $_REQUEST['chequeamount'];
		$cardamount = $_REQUEST['cardamount'];
		$creditamount = $_REQUEST['creditamount'];
			$labcoa = $_REQUEST['labcoa'];
		$radiologycoa = $_REQUEST['radiologycoa'];
		$servicecoa = $_REQUEST['servicecoa'];
		$pharmacycoa = $_REQUEST['pharmacycoa'];
		$referalcoa = $_REQUEST['referalcoa'];
		$cashcoa = $_REQUEST['cashcoa'];
		$chequecoa = $_REQUEST['chequecoa'];
		$cardcoa = $_REQUEST['cardcoa'];
		$mpesacoa = $_REQUEST['mpesacoa'];
		$onlinecoa = $_REQUEST['onlinecoa'];
		$mpesanumber=$_REQUEST['mpesanumber'];
		$patientfirstname = $_REQUEST["customername"];
		$patientfirstname = strtoupper($patientfirstname);
		$patientmiddlename = $_REQUEST['customermiddlename'];
		$patientmiddlename = strtoupper($patientmiddlename);
		$patientlastname = $_REQUEST["customerlastname"];
		$patientlastname = strtoupper($patientlastname);
		$patientfullname=$patientfirstname.' '.$patientmiddlename.' '.$patientlastname;
		$age=$_REQUEST['age'];
		$gender=$_REQUEST['gender'];

		$rad= $_POST['radiology'];
		$rat=$_POST['rate8'];
		$items = array_combine($rad,$rat);
		$pairs = array();
		
		$query21 = "select * from consultation_radiology order by auto_number desc limit 0, 1";
	    $exec21 = mysql_query($query21) or die ("Error in Query2".mysql_error());
		$res21 = mysql_fetch_array($exec21);
		$radrefnonumber = $res21["refno"];
		
		foreach($_POST['radiology'] as $key=>$value){	
			//echo '<br>'.
		
		$pairs= $_POST['radiology'][$key];
		$pairvar= $pairs;
	    $pairs1= $_POST['rate8'][$key];
		$pairvar1= $pairs1;
		
		$radiologyquery=mysql_query("select * from master_radiology where itemname='$pairvar' and status <> 'deleted'");
		$execradiology=mysql_fetch_array($radiologyquery);
		$radiologycode=$execradiology['itemcode'];
		
		
		if($pairvar!="")
		{
		$radiologyquery1=mysql_query("insert into consultation_radiology(patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,consultationdate,paymentstatus,resultentry,billnumber,refno,locationname,locationcode,billtype,accountname)values('walkin','$patientfullname','walkinvis','$radiologycode','$pairvar','$pairvar1','$currentdate','paid','pending','$billnumber','$radrefnonumber','".$locationnameget."','".$locationcodeget."','PAY NOW','CASH')") or die(mysql_error());
		$radiologyquery12=mysql_query("insert into billing_externalradiology(patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,billdate,paymentstatus,billnumber,username,radiologycoa,locationname,locationcode)values('walkin','$patientfullname','walkinvis','$radiologycode','$pairvar','$pairvar1','$currentdate','paid','$billnumber','$username','$radiologycoa','".$locationnameget."','".$locationcodeget."')") or die(mysql_error());
		}
                                                 }
		
		$query2 = "select * from consultation_lab order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$labrefnonumber = $res2["refno"];

			foreach($_POST['categorylab'] as $key=>$value)
	{
	
	$categorylabname=$_POST['categorylab'][$key];
	$categorylabname;
	
	$categorylabrate=$_POST['categoryrate5'][$key];
	if($categorylabname != "")
	{
	$categorylabquery1=mysql_query("insert into consultation_lab(patientcode,patientname,patientvisitcode,labitemname,labitemrate,consultationdate,paymentstatus,labsamplecoll,resultentry,labrefund,billnumber,refno,locationname,locationcode,billtype,accountname)values('walkin','$patientfullname','walkinvis','$categorylabname','$categorylabrate','$currentdate','paid','pending','pending','norefund','$billnumber','$labrefnonumber')") or die(mysql_error());
	$labquery31=mysql_query("insert into billing_externallab(patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,billdate,paymentstatus,billnumber,username,labcoa)values('walkin','$patientfullname','walkinvis','$labcode','$categorylabname','$categorylabrate','$currentdate','paid','$billnumber','$username','$labcoa','".$locationnameget."','".$locationcodeget."','PAY NOW','CASH')") or die(mysql_error());
	}	
	}
	
		foreach($_POST['lab'] as $key=>$value)
		{
				    //echo '<br>'.$k;

		$labname=$_POST['lab'][$key];
		$labquery=mysql_query("select * from master_lab where itemname='$labname' and status <> 'deleted'");
		$execlab=mysql_fetch_array($labquery);
		$labcode=$execlab['itemcode'];
		$labrate=$_POST['rate5'][$key];
		
		if($labname!="")
		{
		$labquery1=mysql_query("insert into consultation_lab(patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,consultationdate,paymentstatus,labsamplecoll,resultentry,labrefund,billnumber,refno,locationname,locationcode,billtype,accountname)values('walkin','$patientfullname','walkinvis','$labcode','$labname','$labrate','$currentdate','paid','pending','pending','norefund','$billnumber','$labrefnonumber','".$locationnameget."','".$locationcodeget."','PAY NOW','CASH')") or die(mysql_error());
		$labquery21=mysql_query("insert into billing_externallab(patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,billdate,paymentstatus,billnumber,username,labcoa,locationname,locationcode,billtype,accountname)values('walkin','$patientfullname','walkinvis','$labcode','$labname','$labrate','$currentdate','paid','$billnumber','$username','$labcoa','".$locationnameget."','".$locationcodeget."','PAY NOW','CASH')") or die(mysql_error());
			}
		}
		$query22 = "select * from consultation_services order by auto_number desc limit 0, 1";
	    $exec22 = mysql_query($query22) or die ("Error in Query2".mysql_error());
		$res22 = mysql_fetch_array($exec22);
		$serrefnonumber = $res22["refno"];
		
		foreach($_POST['services'] as $key => $value)
		{
				    //echo '<br>'.$k;

		$servicesname=$_POST["services"][$key];
		$servicequery=mysql_query("select * from master_services where itemname='$servicesname' and status <> 'deleted'");
		$execservice=mysql_fetch_array($servicequery);
		$servicescode=$execservice['itemcode'];
		
		$servicesrate=$_POST["rate3"][$key];
		
		if($servicesname!="")
		{
		$servicesquery1=mysql_query("insert into consultation_services(patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,consultationdate,paymentstatus,process,billnumber,refno,locationname,locationcode,billtype,accountname)values('walkin','$patientfullname','walkinvis','$servicescode','$servicesname','$servicesrate','$currentdate','paid','pending','$billnumber','$serrefnonumber','".$locationnameget."','".$locationcodeget."','PAY NOW','CASH')") or die(mysql_error());
		$servicesquery41=mysql_query("insert into billing_externalservices(patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,billdate,paymentstatus,billnumber,username,servicecoa,locationname,locationcode,billtype,accountname)values('walkin','$patientfullname','walkinvis','$servicescode','$servicesname','$servicesrate','$currentdate','paid','$billnumber','$username','$servicecoa','".$locationnameget."','".$locationcodeget."','PAY NOW','CASH')") or die(mysql_error());
		}
		}
		
		$transactionmode = $paymentmode;
		if ($transactionmode == 'TDS')
		{
			$transactiontype = 'TDS';
		}
		else
		{
			$transactiontype = 'PAYMENT';
		}
		$transactionmodule = 'PAYMENT';
		if ($paymentmode == 'CASH')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CASH';
		$particulars = 'BY CASH '.$billnumberprefix.$billnumber.'';	
		
		$query55 = "select * from financialaccount where transactionmode = 'CASH'";
		 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
		 $res55 = mysql_fetch_array($exec55);
		 $cashcode = $res55['ledgercode']; 
		
		$query9 = "insert into master_transactionexternal (transactiondate, particulars, 
		transactionmode, transactiontype, transactionamount, cashamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,billstatus,financialyear,username,transactiontime,cashgivenbycustomer,cashgiventocustomer,locationname,locationcode,cashcode) 
		values ('$billdate', '$particulars', 
		'$transactionmode', '$transactiontype', '$totalamount', '$cashamount', 
		'$billnumber',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule','$patientfullname','walkin','walkinvis','paid','$financialyear','$username','$timeonly','$cashgivenbycustomer','$cashgiventocustomer','".$locationnameget."','".$locationcodeget."','$cashcode')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		
		$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,billnumber,billdate,ipaddress,username,cash,cashcoa,source,locationname,locationcode,accountname)values('$patientfullname','walkin','walkinvis','$billnumber','$billdate','$ipaddress','$username','$totalamount','$cashcoa','externalbilling','".$locationnameget."','".$locationcodeget."','CASH')";
        $exec37 = mysql_query($query37) or die(mysql_error());


		}
		
		if ($paymentmode == 'SPLIT')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'SPLIT';  
		$particulars = 'BY SPLIT '.$billnumberprefix.$billnumber.'';	
		
		$query55 = "select * from financialaccount where transactionmode = 'CASH'";
		 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
		 $res55 = mysql_fetch_array($exec55);
		 $cashcode = $res55['ledgercode'];

		 if($cardamount > 0)
		 {
		 	$trans = 'CREDITCARD';
		 }
		 else if($onlineamount > 0)
		 {
		 	$trans = 'ONLINE';
		 }
		 else if($chequeamount > 0)
		 {
		 	$trans = 'CHEQUE';
		 }
		 else
		 {
		 	$trans = 'CHEQUE';
		 }
		 
		 $query551 = "select * from financialaccount where transactionmode = '$trans'";
		 $exec551 = mysql_query($query551) or die ("Error in Query551".mysql_error());
		 $res551 = mysql_fetch_array($exec551);
		 $bankcode = $res551['ledgercode'];
		 
		 $query552 = "select * from financialaccount where transactionmode = 'MPESA'";
		 $exec552 = mysql_query($query552) or die ("Error in Query552".mysql_error());
		 $res552 = mysql_fetch_array($exec552);
		 $mpesacode = $res552['ledgercode'];
		
		$query9 = "insert into master_transactionexternal (transactiondate, particulars, 
		transactionmode, transactiontype, transactionamount, cashamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks,cardamount,onlineamount,chequeamount,chequenumber,
		transactionmodule,patientname,patientcode,visitcode,billstatus,financialyear,username,transactiontime,cashgivenbycustomer,cashgiventocustomer,locationname,locationcode,cashcode, bankcode, mpesacode, creditamount) 
		values ('$billdate', '$particulars', 
		'$transactionmode', '$transactiontype', '$totalamount', '$cashamount', 
		'$billnumber',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', '$cardamount', '$onlineamount', '$chequeamount', 
		'$chequenumber', '$transactionmodule','$patientfullname','walkin','walkinvis','paid','$financialyear','$username','$timeonly','$cashgivenbycustomer','$cashgiventocustomer','".$locationnameget."','".$locationcodeget."','$cashcode', '$bankcode', '$mpesacode', '$creditamount')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		
		$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,billnumber,billdate,ipaddress,username,card,cardcoa,cash,cashcoa,cheque,chequecoa,online,onlinecoa,mpesa,mpesacoa,mpesanumber,source,locationname,locationcode,accountname)values('$patientfullname','walkin','walkinvis','$billnumber','$billdate','$ipaddress','$username','$cardamount','$cardcoa','$cashamount','$cashcoa','$chequeamount','$chequecoa','$onlineamount','$onlinecoa','$creditamount','$mpesacoa','$mpesanumber','externalbilling','".$locationnameget."','".$locationcodeget."','CASH')";
        $exec37 = mysql_query($query37) or die(mysql_error());
	

		}
		
		if ($paymentmode == 'MPESA')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'MPESA';
		$particulars = 'BY MPESA '.$billnumberprefix.$billnumber.'';	
		
		$query552 = "select * from financialaccount where transactionmode = 'MPESA'";
		 $exec552 = mysql_query($query552) or die ("Error in Query552".mysql_error());
		 $res552 = mysql_fetch_array($exec552);
		 $mpesacode = $res552['ledgercode'];
		
		$query9 = "insert into master_transactionexternal (transactiondate, particulars, 
		transactionmode, transactiontype, transactionamount, cashamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,creditamount,patientname,patientcode,visitcode,billstatus,financialyear,username,transactiontime,cashgivenbycustomer,cashgiventocustomer,locationname,locationcode,mpesacode) 
		values ('$billdate', '$particulars', 
		'$transactionmode', '$transactiontype', '$totalamount', '0', 
		'$billnumber',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule','$creditamount','$patientfullname','walkin','walkinvis','paid','$financialyear','$username','$timeonly','$cashgivenbycustomer','$cashgiventocustomer','".$locationnameget."','".$locationcodeget."','$mpesacode')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		
		$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,billnumber,billdate,ipaddress,username,mpesa,mpesacoa,mpesanumber,source,locationname,locationcode,accountname)values('$patientfullname','walkin','walkinvis','$billnumber','$billdate','$ipaddress','$username','$totalamount','$mpesacoa','$mpesanumber','externalbilling','".$locationnameget."','".$locationcodeget."','CASH')";
        $exec37 = mysql_query($query37) or die(mysql_error());


		}
		
		if ($paymentmode == 'ONLINE')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'ONLINE';
		$particulars = 'BY ONLINE '.$billnumberprefix.$billnumber.'';	
		
		$query55 = "select * from financialaccount where transactionmode = 'ONLINE'";
		 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
		 $res55 = mysql_fetch_array($exec55);
		 $bankcode = $res55['ledgercode']; 
		 
		$query9 = "insert into master_transactionexternal (transactiondate, particulars,
		transactionmode, transactiontype, transactionamount, onlineamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,billstatus,financialyear,username,transactiontime,locationname,locationcode,bankcode) 
		values ('$billdate','$particulars', 
		'$transactionmode', '$transactiontype', '$totalamount', '$onlineamount', 
		'$billnumber',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule','$patientfullname','walkin','walkinvis','paid','$financialyear','$username','$timeonly','".$locationnameget."','".$locationcodeget."','$bankcode')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		
		$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,billnumber,billdate,ipaddress,username,online,onlinecoa,source,locationname,locationcode,accountname)values('$patientname','walkin','walkinvis','$billnumber','$billdate','$ipaddress','$username','$totalamount','$onlinecoa','externalbilling','".$locationnameget."','".$locationcodeget."','CASH')";
        $exec37 = mysql_query($query37) or die(mysql_error());

	    }
		if ($paymentmode == 'CREDIT CARD')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CREDIT CARD';
		$particulars = 'BY CREDIT CARD '.$billnumberprefix.$billnumber.'';	
		
		$query55 = "select * from financialaccount where transactionmode = 'CREDITCARD'";
		 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
		 $res55 = mysql_fetch_array($exec55);
		 $bankcode = $res55['ledgercode']; 
		 
		$query9 = "insert into master_transactionexternal (transactiondate, particulars,
		transactionmode, transactiontype, transactionamount, cardamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,billstatus,financialyear,username,transactiontime,creditcardname,creditcardnumber,creditcardbankname,locationname,locationcode,bankcode) 
		values ('$billdate','$particulars', 
		'$transactionmode', '$transactiontype', '$totalamount', '$cardamount', 
		'$billnumber',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule','$patientfullname','walkin','walkinvis','paid','$financialyear','$username','$timeonly','$card','$cardnumber','$bankname1','".$locationnameget."','".$locationcodeget."','$bankcode')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		
		$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,billnumber,billdate,ipaddress,username,card,cardcoa,source,locationname,locationcode,accountname)values('$patientname','walkin','walkinvis','$billnumber','$billdate','$ipaddress','$username','$totalamount','$cardcoa','externalbilling','".$locationnameget."','".$locationcodeget."','CASH')";
        $exec37 = mysql_query($query37) or die(mysql_error());

	    }
		if ($paymentmode == 'CHEQUE')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CHEQUE';
		$particulars = 'BY CHEQUE '.$billnumberprefix.$billnumber;
		
		$query55 = "select * from financialaccount where transactionmode = 'CHEQUE'";
		 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
		 $res55 = mysql_fetch_array($exec55);
		 $bankcode = $res55['ledgercode'];
		 		
			$query9 = "insert into master_transactionexternal (transactiondate, particulars,
		transactionmode, transactiontype, transactionamount,
		chequeamount,chequenumber, billnumber, billanum, 
		chequedate, bankname, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,billstatus,financialyear,username,transactiontime,locationname,locationcode,bankcode) 
		values ('$billdate', '$particulars', 
		'$transactionmode', '$transactiontype', '$totalamount',
		'$chequeamount','$chequenumber',  '$billnumber',  '$billanum', 
		'$chequedate', '$bankname', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', 
		'$remarks', '$transactionmodule','$patientfullname','walkin','walkinvis','paid','$financialyear','$username','$timeonly','".$locationnameget."','".$locationcodeget."','$bankcode')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		
		$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,billnumber,billdate,ipaddress,username,cheque,chequecoa,source,locationname,locationcode,accountname)values('$patientname','walkin','walkinvis','$billnumber','$billdate','$ipaddress','$username','$totalamount','$chequecoa','externalbilling','".$locationnameget."','".$locationcodeget."','CASH')";
        $exec37 = mysql_query($query37) or die(mysql_error());

	    }
	    
		if ($paymentmode != '' && $nettamount1 != "0.00") { 	
	 	mysql_query("insert into billing_external(billno,patientname,patientcode,visitcode,totalamount,billdate,age,gender,username,locationname,locationcode)values('$billnumber','$patientfullname','walkin','walkinvis','$totalamount','$billdate','$age','$gender','$username','".$locationnameget."','".$locationcodeget."')") or die(mysql_error());
	                        }
		header("location:menupage1.php?locationcode=$locationcodeget&&savedbillnumber=$billnumber&&mainmenuid=MM005");
        exit;
    
       }


//to redirect if there is no entry in masters category or item or customer or settings



//To get default tax from autoitemsearch1.php and autoitemsearch2.php - for CST tax override.
if (isset($_REQUEST["defaulttax"])) { $defaulttax = $_REQUEST["defaulttax"]; } else { $defaulttax = ""; }
if(isset($_REQUEST['delete']))
{
$radiologyname=$_REQUEST['delete'];
mysql_query("delete from consultation_radiology where radiologyitemname='$radiologyname'");
}
//$defaulttax = $_REQUEST["defaulttax"];
if ($defaulttax == '')
{
	$_SESSION["defaulttax"] = '';
}
else
{
	$_SESSION["defaulttax"] = $defaulttax;
}
if(isset($_REQUEST["patientcode"]))
{
$patientcode=$_REQUEST["patientcode"];
$visitcode=$_REQUEST["visitcode"];
}


//This include updatation takes too long to load for hunge items database.


//To populate the autocompetelist_services1.js


//To verify the edition and manage the count of bills.
$thismonth = date('Y-m-');
$query77 = "select * from master_edition where status = 'ACTIVE'";
$exec77 =  mysql_query($query77) or die ("Error in Query77".mysql_error());
$res77 = mysql_fetch_array($exec77);
$res77allowed = $res77["allowed"];




/*
$query99 = "select count(auto_number) as cntanum from master_quotation where quotationdate like '$thismonth%'";
$exec99 = mysql_query($query99) or die ("Error in Query99".mysql_error());
$res99 = mysql_fetch_array($exec99);
$res99cntanum = $res99["cntanum"];
$totalbillandquote = $res88cntanum + $res99cntanum; //total of bill and quote in current month.
if ($totalbillandquote > $res77allowed)
{
	//header ("location:usagelimit1.php"); // redirecting.
	//exit;
}
*/

//To Edit Bill
if (isset($_REQUEST["delbillst"])) { $delbillst = $_REQUEST["delbillst"]; } else { $delbillst = ""; }
//$delbillst = $_REQUEST["delbillst"];
if (isset($_REQUEST["delbillautonumber"])) { $delbillautonumber = $_REQUEST["delbillautonumber"]; } else { $delbillautonumber = ""; }
//$delbillautonumber = $_REQUEST["delbillautonumber"];
if (isset($_REQUEST["delbillnumber"])) { $delbillnumber = $_REQUEST["delbillnumber"]; } else { $delbillnumber = ""; }
//$delbillnumber = $_REQUEST["delbillnumber"];

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
//$frm1submit1 = $_REQUEST["frm1submit1"];




if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST["st"];
if (isset($_REQUEST["banum"])) { $banum = $_REQUEST["banum"]; } else { $banum = ""; }
//$banum = $_REQUEST["banum"];
if ($st == '1')
{
	$errmsg = "Success. New Bill Updated. You May Continue To Add Another Bill.";
	$bgcolorcode = 'success';
}
if ($st == '2')
{
	$errmsg = "Failed. New Bill Cannot Be Completed.";
	$bgcolorcode = 'failed';
}
if ($st == '1' && $banum != '')
{
	$loadprintpage = 'onLoad="javascript:loadprintpage1()"';
}

if ($delbillst == "" && $delbillnumber == "")
{
	$res41customername = "";
	$res41customercode = "";
	$res41tinnumber = "";
	$res41cstnumber = "";
	$res41address1 = "";
	$res41deliveryaddress = "";
	$res41area = "";
	$res41city = "";
	$res41pincode = "";
	$res41billdate = "";
	$billnumberprefix = "";
	$billnumberpostfix = "";
}




?>

<?php
$Querylab=mysql_query("select * from master_customer where customercode='$patientcode'");
$execlab=mysql_fetch_array($Querylab);
 $patientage=$execlab['age'];
 $patientgender=$execlab['gender'];

$patienttype=$execlab['maintype'];
$querytype=mysql_query("select * from master_paymenttype where auto_number='$patienttype'");
$exectype=mysql_fetch_array($querytype);
$patienttype1=$exectype['paymenttype'];
$patientsubtype=$execlab['subtype'];
$querysubtype=mysql_query("select * from master_subtype where auto_number='$patientsubtype'");
$execsubtype=mysql_fetch_array($querysubtype);
$patientsubtype1=$execsubtype['subtype'];
$patientplan=$execlab['planname'];
$queryplan=mysql_query("select * from master_planname where auto_number='$patientplan'");
$execplan=mysql_fetch_array($queryplan);
$patientplan1=$execplan['planname'];

?>
<?php
$querylab1=mysql_query("select * from master_customer where customercode='$patientcode'");
$execlab1=mysql_fetch_array($querylab1);
$patientname=$execlab1['customerfullname'];
$patientaccount=$execlab1['accountname'];

$querylab2=mysql_query("select * from master_accountname where auto_number='$patientaccount'");
$execlab2=mysql_fetch_array($querylab2);
$patientaccount1=$execlab2['accountname'];

$query76 = "select * from master_financialintegration where field='labexternal'";
$exec76 = mysql_query($query76) or die(mysql_error());
$res76 = mysql_fetch_array($exec76);
$labcoa = $res76['code'];

$query761 = "select * from master_financialintegration where field='radiologyexternal'";
$exec761 = mysql_query($query761) or die(mysql_error());
$res761 = mysql_fetch_array($exec761);

$radiologycoa = $res761['code'];

$query762 = "select * from master_financialintegration where field='serviceexternal'";
$exec762 = mysql_query($query762) or die(mysql_error());
$res762 = mysql_fetch_array($exec762);

$servicecoa = $res762['code'];

$query763 = "select * from master_financialintegration where field='referalexternal'";
$exec763 = mysql_query($query763) or die(mysql_error());
$res763 = mysql_fetch_array($exec763);

$referalcoa = $res763['code'];

$query764 = "select * from master_financialintegration where field='pharmacyexternal'";
$exec764 = mysql_query($query764) or die(mysql_error());
$res764 = mysql_fetch_array($exec764);

$pharmacycoa = $res764['code'];

$query765 = "select * from master_financialintegration where field='cashexternal'";
$exec765 = mysql_query($query765) or die(mysql_error());
$res765= mysql_fetch_array($exec765);

$cashcoa = $res765['code'];


$query766 = "select * from master_financialintegration where field='chequeexternal'";
$exec766 = mysql_query($query766) or die(mysql_error());
$res766 = mysql_fetch_array($exec766);

$chequecoa = $res766['code'];


$query767 = "select * from master_financialintegration where field='mpesaexternal'";
$exec767 = mysql_query($query767) or die(mysql_error());
$res767 = mysql_fetch_array($exec767);

$mpesacoa = $res767['code'];

$query768 = "select * from master_financialintegration where field='cardexternal'";
$exec768 = mysql_query($query768) or die(mysql_error());
$res768 = mysql_fetch_array($exec768);

$cardcoa = $res768['code'];

$query769 = "select * from master_financialintegration where field='onlineexternal'";
$exec769 = mysql_query($query769) or die(mysql_error());
$res769 = mysql_fetch_array($exec769);

$onlinecoa = $res769['code'];


?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$paynowbillprefix = 'EB-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from billing_external where billstatus = '' order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["billno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='EB-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billno"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'EB-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
?>
<?php
include ("js/sales1scripting1.php"); 

include ("autocompletebuild_lab1.php");
include ("autocompletebuild_radiology1.php");
include ("autocompletebuild_services1.php");

?>
<script language="javascript">



<?php
if ($delbillst != 'billedit') // Not in edit mode or other mode.
{
?>
	//Function call from billnumber onBlur and Save button click.
	function billvalidation()
	{
		billnovalidation1();
	}
<?php
}
?>

function funcOnLoadBodyFunctionCall()
{


	funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	 //To handle ajax dropdown list.
	
	funcPopupPrintFunctionCall();
	
	
	funcCustomerDropDownSearch3();
	funcCustomerDropDownSearch1();
	funcCustomerDropDownSearch2();
		
		funcOnLoadBodyFunctionCall1();
	
}
function funcOnLoadBodyFunctionCall1()
{
    
	
	funcLabHideView();
	funcRadHideView();
	funcSerHideView();
	
}


function funcLabShowView()
{
if (document.getElementById("customername").value == '') 
     {
	 alert("Please Enter First Name");
	 document.getElementById("customername").focus();
	 return false;
	 }

if (document.getElementById("customerlastname").value == '') 
     {
	 alert("Please Enter Last Name");
	 document.getElementById("customerlastname").focus();
	 return false;
	 }

 
  if (document.getElementById("labid") != null) 
     {
	 document.getElementById("labid").style.display = 'none';
	}
	if (document.getElementById("labid") != null) 
	  {
	  document.getElementById("labid").style.display = '';
	 }
	 
	return true;
	 return true;
}
	
function funcLabHideView()
{		
 if (document.getElementById("labid") != null) 
	{
	document.getElementById("labid").style.display = 'none';
	}		
	 
}

function funcRadShowView()
{
if (document.getElementById("customername").value == '') 
     {
	 alert("Please Enter First Name");
	 document.getElementById("customername").focus();
	 return false;
	 }
if (document.getElementById("customerlastname").value == '') 
     {
	 alert("Please Enter Last Name");
	 document.getElementById("customerlastname").focus();
	 return false;
	 }

 
  if (document.getElementById("radid") != null) 
     {
	 document.getElementById("radid").style.display = 'none';
	}
	if (document.getElementById("radid") != null) 
	  {
	  document.getElementById("radid").style.display = '';
	 }
	 return true;
	 return true;
}
	
function funcSerHideView()
{		
 if (document.getElementById("serid") != null) 
	{
	document.getElementById("serid").style.display = 'none';
	}			
}
function funcSerShowView()
{
if (document.getElementById("customername").value == '') 
     {
	 alert("Please Enter First Name");
	 document.getElementById("customername").focus();
	 return false;
	 }
if (document.getElementById("customerlastname").value == '') 
     {
	 alert("Please Enter Last Name");
	 document.getElementById("customerlastname").focus();
	 return false;
	 }

 
  if (document.getElementById("serid") != null) 
     {
	 document.getElementById("serid").style.display = 'none';
	}
	if (document.getElementById("serid") != null) 
	  {
	  document.getElementById("serid").style.display = '';
	 }
	 return true;
	 return true;
}
	
function funcRadHideView()
{		
 if (document.getElementById("radid") != null) 
	{
	document.getElementById("radid").style.display = 'none';
	}			
}
function funcPopupPrintFunctionCall()
{

	///*
	//alert ("Auto Print Function Runs Here.");
	<?php
	if (isset($_REQUEST["src"])) { $src = $_REQUEST["src"]; } else { $src = ""; }
	//$src = $_REQUEST["src"];
	if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
	//$st = $_REQUEST["st"];
	if (isset($_REQUEST["billnumber"])) { $previousbillnumber = $_REQUEST["billnumber"]; } else { $previousbillnumber = ""; }
	//$previousbillnumber = $_REQUEST["billnumber"];
	if (isset($_REQUEST["billautonumber"])) { $previousbillautonumber = $_REQUEST["billautonumber"]; } else { $previousbillautonumber = ""; }
	//$previousbillautonumber = $_REQUEST["billautonumber"];
	if (isset($_REQUEST["companyanum"])) { $previouscompanyanum = $_REQUEST["companyanum"]; } else { $previouscompanyanum = ""; }
	//$previouscompanyanum = $_REQUEST["companyanum"];
	if ($src == 'frm1submit1' && $st == 'success')
	{
	$query1print = "select * from master_printer where defaultstatus = 'default' and status <> 'deleted'";
	$exec1print = mysql_query($query1print) or die ("Error in Query1print.".mysql_error());
	$res1print = mysql_fetch_array($exec1print);
	$papersize = $res1print["papersize"];
	$paperanum = $res1print["auto_number"];
	$printdefaultstatus = $res1print["defaultstatus"];
	if ($paperanum == '1') //For 40 Column paper
	{
	?>
		//quickprintbill1();
		quickprintbill1sales();
	<?php
	}
	else if ($paperanum == '2') //For A4 Size paper
	{
	?>
		loadprintpage1('A4');
	<?php
	}
	else if ($paperanum == '3') //For A4 Size paper
	{
	?>
		loadprintpage1('A5');
	<?php
	}
	}
	?>
	//*/


}

//Print() is at bottom of this page.

</script>


<script type="text/javascript">


function loadprintpage1(varPaperSizeCatch)
{
	//var varBillNumber = document.getElementById("billnumber").value;
	var varPaperSize = varPaperSizeCatch;
	//alert (varPaperSize);
	//return false;
	<?php
	//To previous js error if empty. 
	if ($previousbillnumber == '') 
	{ 
		$previousbillnumber = 1; 
		$previousbillautonumber = 1; 
		$previouscompanyanum = 1; 
	} 
	?>
	var varBillNumber = document.getElementById("quickprintbill").value;
	var varBillAutoNumber = "<?php //echo $previousbillautonumber; ?>";
	var varBillCompanyAnum = "<?php echo $_SESSION["companyanum"]; ?>";
	if (varBillNumber == "")
	{
		alert ("Bill Number Cannot Be Empty.");//quickprintbill
		document.getElementById("quickprintbill").focus();
		return false;
	}
	
	var varPrintHeader = "INVOICE";
	var varTitleHeader = "ORIGINAL";
	if (varTitleHeader == "")
	{
		alert ("Please Select Print Title.");
		document.getElementById("titleheader").focus();
		return false;
	}
	
	//alert (varBillNumber);
	//alert (varPrintHeader);
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');

	if (varPaperSize == "A4")
	{
		window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&billnumber="+varBillNumber+"","OriginalWindowA4<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	}
	if (varPaperSize == "A5")
	{
		window.open("print_bill1_a5.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&billnumber="+varBillNumber+"","OriginalWindowA5<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	}
}



function funcDefaultTax1() //Function to CST Taxes if required.
{
	//alert ("Default Tax");
	<?php
	//delbillst=billedit&&delbillautonumber=13&&delbillnumber=1
	//To avoid change of bill number on edit option after selecting default tax.
	if (isset($_REQUEST["delbillst"])) { $delBillSt = $_REQUEST["delbillst"]; } else { $delBillSt = ""; }
	//$delBillSt = $_REQUEST["delbillst"];
	if (isset($_REQUEST["delbillautonumber"])) { $delBillAutonumber = $_REQUEST["delbillautonumber"]; } else { $delBillAutonumber = ""; }
	//$delBillAutonumber = $_REQUEST["delbillautonumber"];
	if (isset($_REQUEST["delbillnumber"])) { $delBillNumber = $_REQUEST["delbillnumber"]; } else { $delBillNumber = ""; }
	//$delBillNumber = $_REQUEST["delbillnumber"];
	
	?>
	var varDefaultTax = document.getElementById("defaulttax").value;
	if (varDefaultTax != "")
	{
		<?php
		if ($delBillSt == 'billedit')
		{
		?>
		window.location="sales1.php?defaulttax="+varDefaultTax+"&&delbillst=<?php echo $delBillSt; ?>&&delbillautonumber="+<?php echo $delBillAutonumber; ?>+"&&delbillnumber="+<?php echo $delBillNumber; ?>+"";
		<?php
		}
		else
		{
		?>
		window.location="sales1.php?defaulttax="+varDefaultTax+"";
		<?php
		}
		?>
	}
	else
	{
		window.location="sales1.php";
	}
	//return false;
}



</script>



<?php include ("js/dropdownlist1scriptinglab1.php"); ?>
<script type="text/javascript" src="js/autocomplete_lab1.js"></script>
<script type="text/javascript" src="js/autosuggestlab1.js"></script> 
<script type="text/javascript" src="js/autolabcodesearchexternal.js"></script>


<?php include ("js/dropdownlist1scriptingradiology1.php"); ?>
<script type="text/javascript" src="js/autocomplete_radiology1.js"></script>
<script type="text/javascript" src="js/autosuggestradiology1.js"></script> 
<script type="text/javascript" src="js/autoradiologycodesearchexternal.js"></script>


<?php include ("js/dropdownlist1scriptingservices1.php"); ?>
<script type="text/javascript" src="js/autocomplete_services1.js"></script>
<script type="text/javascript" src="js/autosuggestservices1.js"></script>
<script type="text/javascript" src="js/autoservicescodesearchexternal.js"></script>


<script type="text/javascript" src="js/insertnewitem22.js"></script>
<script type="text/javascript" src="js/insertnewitem33.js"></script>
<script type="text/javascript" src="js/insertnewitem44.js"></script>

<script language="javascript">
var totalamount=0;
var totalamount1=0;
var totalamount2=0;
var totalamount3=0;
var totalamount4=0;
var totalamount11;
var totalamount21;
var totalamount31;
var totalamount41;
var grandtotal=0;
function process1backkeypress1()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
}
function frequencyitem()
{
if(document.form1.frequency.value=="select")
{
alert("please select a frequency");
document.form1.frequency.focus();
return false;
}
return true;
}

function Functionfrequency()
{
var ResultFrequency;
 var frequencyanum = document.getElementById("frequency").value;
var medicinedose=document.getElementById("dose").value;
 var VarDays = document.getElementById("days").value; 
 if((frequencyanum != '') && (VarDays != ''))
 {
  ResultFrequency = medicinedose*frequencyanum * VarDays;
 }
 else
 {
 ResultFrequency =0;
 }
 document.getElementById("quantity").value = ResultFrequency;
var VarRate = document.getElementById("rate").value;
var ResultAmount = parseFloat(VarRate * ResultFrequency);
  document.getElementById("amount").value = ResultAmount.toFixed(2);
}
function processflowitem(varstate)
{
	//alert ("Hello World.");
	var varProcessID = varstate;
	//alert (varProcessID);
	var varItemNameSelected = document.getElementById("state").value;
	//alert (varItemNameSelected);
	ajaxprocess5(varProcessID);
	//totalcalculation();
}

function processflowitem1()
{
}

function btnDeleteClick1(delID1,vrate1)
{
var vrate1 = vrate1;

	var newtotal3;
	//alert(vrate1);
	var varDeleteID1 = delID1;
	//alert(varDeleteID1);
	var fRet4; 
	fRet4 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet4); 
	if (fRet4 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}
	
	var child1 = document.getElementById('idTR'+varDeleteID1); //tr name
    var parent1 = document.getElementById('insertrow1'); // tbody name.
	document.getElementById ('insertrow1').removeChild(child1);
	
	var child1= document.getElementById('idTRaddtxt'+varDeleteID1);  //tr name
    var parent1= document.getElementById('insertrow1'); // tbody name.
	//alert (child);
	if (child1 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow1').removeChild(child1);
	}
	
	var currenttotal3=document.getElementById('total1').value;
	//alert(currenttotal);
	newtotal3= currenttotal3-vrate1;
	newtotal3=newtotal3.toFixed(2);
	//alert(newtotal3);
	
	document.getElementById('total1').value=newtotal3;
	
	if(document.getElementById('total2').value=='')
	{
	 totalamount21=0;
	//alert(totalamount21);
	}
	else
	{
	totalamount21=document.getElementById('total2').value;
	}
	if(document.getElementById('total3').value=='')
	{
	 totalamount31=0;
	//alert(totalamount31);
	}
	else
	{
	 totalamount31=document.getElementById('total3').value;
	}
	
	
		 newgrandtotal3=parseInt(newtotal3)+parseInt(totalamount21)+parseInt(totalamount31);
	//alert(newgrandtotal3);
	document.getElementById('total4').value=newgrandtotal3.toFixed(2);
	
	
	document.getElementById("totalamount").value=newgrandtotal3.toFixed(2);

	document.getElementById("subtotal").value=newgrandtotal3.toFixed(2);
	//alert('h');
	document.getElementById("tdShowTotal").innerHTML=newgrandtotal3.toFixed(2);
		document.getElementById("nettamount").value=newgrandtotal3.toFixed(2);
		document.getElementById("cashamount").value=newgrandtotal3.toFixed(2);
		document.getElementById("creditamount").value=newgrandtotal3.toFixed(2);
		document.getElementById("chequeamount").value=newgrandtotal3.toFixed(2);
		document.getElementById("cardamount").value=newgrandtotal3.toFixed(2);
		document.getElementById("onlineamount").value=newgrandtotal3.toFixed(2);


}

function btnDeleteClick5(delID5,radrate)
{
var radrate=radrate;
	//alert ("Inside btnDeleteClick.");
	var newtotal2;
	//alert(radrate);
	//alert(delID5);
	var varDeleteID2= delID5;
	//alert (varDeleteID2);
	var fRet5; 
	fRet5 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet5 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child2= document.getElementById('idTR'+varDeleteID2);  //tr name
	//alert(child2);
    var parent2 = document.getElementById('insertrow2'); // tbody name.
	//alert(parent2);
	document.getElementById ('insertrow2').removeChild(child2);
	
	var child2 = document.getElementById('idTRaddtxt'+varDeleteID2);  //tr name
    var parent2 = document.getElementById('insertrow2'); // tbody name.
	//alert (child);
	if (child2 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow2').removeChild(child2);
	}
	
	var currenttotal2=document.getElementById('total2').value;
	//alert(currenttotal);
	newtotal2= currenttotal2-radrate;
	
	//alert(newtotal);
	
	document.getElementById('total2').value=newtotal2;
	
	if(document.getElementById('total1').value=='')
	{
	totalamount21=0;
	}
	else
	{
	totalamount21=document.getElementById('total1').value;
	}
	if(document.getElementById('total3').value=='')
	{
	totalamount31=0;
	}
	else
	{
	totalamount31=document.getElementById('total3').value;
	}
	
	
	
    var newgrandtotal2=parseInt(totalamount21)+parseInt(newtotal2)+parseInt(totalamount31);
	
	//alert(newgrandtotal4);
	
	document.getElementById('total4').value=newgrandtotal2.toFixed(2);
	
	
	
		document.getElementById("subtotal").value=newgrandtotal2.toFixed(2);
	

	document.getElementById("totalamount").value=newgrandtotal2.toFixed(2);
	document.getElementById("tdShowTotal").innerHTML=newgrandtotal2.toFixed(2);
		document.getElementById("nettamount").value=newgrandtotal2.toFixed(2);
		document.getElementById("cashamount").value=newgrandtotal2.toFixed(2);
		document.getElementById("creditamount").value=newgrandtotal2.toFixed(2);
		document.getElementById("chequeamount").value=newgrandtotal2.toFixed(2);
		document.getElementById("cardamount").value=newgrandtotal2.toFixed(2);
		document.getElementById("onlineamount").value=newgrandtotal2.toFixed(2);


	
}
function btnDeleteClick3(delID3,vrate3)
{
var vrate3=vrate3;
	//alert ("Inside btnDeleteClick.");
	var newtotal1;
	var varDeleteID3= delID3;
	//alert (varDeleteID3);
	//alert(vrate3);
	var fRet6; 
	fRet6 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet6 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child3 = document.getElementById('idTR'+varDeleteID3);  
	//alert (child3);//tr name
    var parent3 = document.getElementById('insertrow3'); // tbody name.
	document.getElementById ('insertrow3').removeChild(child3);
	
	var child3= document.getElementById('idTRaddtxt'+varDeleteID3);  //tr name
    var parent3 = document.getElementById('insertrow3'); // tbody name.
	
	if (child3 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow3').removeChild(child3);
	}
var currenttotal1=document.getElementById('total3').value;
	//alert(currenttotal);
	newtotal1= currenttotal1-vrate3;
	
	//alert(newtotal);
	
	document.getElementById('total3').value=newtotal1;
	
	if(document.getElementById('total1').value=='')
	{
	totalamount21=0;
	}
	else
	{
	totalamount21=document.getElementById('total1').value;
	}
	if(document.getElementById('total2').value=='')
	{
	totalamount31=0;
	}
	else
	{
	totalamount31=document.getElementById('total2').value;
	}
	
	
	var newgrandtotal1=parseInt(totalamount21)+parseInt(totalamount31)+parseInt(newtotal1);
	
	//alert(newgrandtotal4);
	
	document.getElementById('total4').value=newgrandtotal1.toFixed(2);	
	document.getElementById("totalamount").value=newgrandtotal1.toFixed(2);
		document.getElementById("subtotal").value=newgrandtotal1.toFixed(2);
	document.getElementById("tdShowTotal").innerHTML=newgrandtotal1.toFixed(2);
	document.getElementById("nettamount").value=newgrandtotal1.toFixed(2);
		document.getElementById("cashamount").value=newgrandtotal1.toFixed(2);
		document.getElementById("creditamount").value=newgrandtotal1.toFixed(2);
		document.getElementById("chequeamount").value=newgrandtotal1.toFixed(2);
		document.getElementById("cardamount").value=newgrandtotal1.toFixed(2);
		document.getElementById("onlineamount").value=newgrandtotal1.toFixed(2);


}

function balancecalc(mode)
{
var mode = mode;
var cashamount = document.getElementById("cashamount").value;
//alert(cashamount);
if(cashamount == '')
{
cashamount = 0;
}
var chequeamount = document.getElementById("chequeamount").value;
if(chequeamount == '')
{
chequeamount = 0;
}
var cardamount = document.getElementById("cardamount").value;
if(cardamount == '')
{
cardamount = 0;
}
var onlineamount = document.getElementById("onlineamount").value;
if(onlineamount == '')
{
onlineamount = 0;
}
var mpesaamount = document.getElementById("creditamount").value;
if(mpesaamount == '')
{
mpesaamount = 0;
}
var balance =  document.getElementById("totalamount").value;

var totalamount = parseFloat(cashamount)+parseFloat(chequeamount)+parseFloat(cardamount)+parseFloat(onlineamount)+parseFloat(mpesaamount);

var newbalance=parseFloat(balance) - parseFloat(totalamount);
newbalance = newbalance.toFixed(2);

if(newbalance < 0)
{
alert("Entered Amount is greater than Bill Amount");

if(mode == '1')
{
document.getElementById("cashamount").value = '0.00';
}    
if(mode == '2')
{
document.getElementById("creditamount").value = '0.00';
}  
if(mode == '3')
{
document.getElementById("chequeamount").value = '0.00';
}  
if(mode == '4')
{
document.getElementById("cardamount").value = '0.00';
}  
if(mode == '5')
{
document.getElementById("onlineamount").value = '0.00';
}            
          
return false;

}
if(newbalance == -0.00)
{
newbalance = 0;
newbalance = newbalance.toFixed(2);
}
document.getElementById("tdShowTotal").innerHTML = newbalance;
}

</script>

<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
.style1 {
	font-size: 30px;
	font-weight: bold;
}
.style2 {
	font-size: 18px;
	font-weight: bold;
}
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
.bal
{
border-style:none;
background:none;
text-align:right;
font-size: 30px;
	font-weight: bold;
	FONT-FAMILY: Tahoma
}
</style>

<script src="js/datetimepicker_css.js"></script>
</head>

<script>
function printConsultationBill()
 {
  if (document.getElementById("nettamount").value != "0.00")
	{
var popWin; 
popWin = window.open("print_external_bill.php?locationcode=<?php echo $locationcodeget; ?>&&billnumber=<?php echo $billnumbercode; ?>","OriginalWindowA4",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
    }
 }
</script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="form1" id="frmsales" method="post" action="externalbilling.php" onKeyDown="return disableEnterKey(event)">
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>

  </tr>
  <tr>
    <td colspan="9" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
<!--  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
-->
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="980" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
                <tr bgcolor="#011E6A">
                <td colspan="4" bgcolor="#CCCCCC" class="bodytext32"><strong>Patient Details</strong></td>
                <td colspan="3" bgcolor="#CCCCCC" class="bodytext32"><strong>Location&nbsp;</strong> <?php echo $locationname;?>
                <input type="hidden" name="locationnameget" id="locationname" value="<?php echo $locationname;?>">
                <input type="hidden" name="locationcodeget" id="locationcode" value="<?php echo $locationcode;?>">
                </td>
			 </tr>
		<tr>
                <td colspan="7" class="bodytext32"><strong>&nbsp;</strong></td>
			 </tr>
			<tr>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext32"> &nbsp;First Name   </span></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext32"> &nbsp;Middle Name   </span></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext32"> &nbsp;Last Name   </span></td>
				  </tr>
				<tr>
                <td width="17%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext32"> <strong>Patient Name</strong>  </span></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="customername" id="customername" value="" style="text-transform:uppercase;" size="18">
				<input type="hidden" name="nameofrelative" id="nameofrelative" value="<?php echo $nameofrelative; ?>"size="45"></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
				<input name="customermiddlename" id="customermiddlename" value="" style="text-transform:uppercase;" size="18"></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="subtype" id="subtype" value="" type="hidden" />
				<input name="customerlastname" id="customerlastname" value="" style="text-transform:uppercase;" size="18"></td>
				<input type="hidden" name="labcoa" value="<?php echo $labcoa; ?>">
				<input type="hidden" name="radiologycoa" value="<?php echo $radiologycoa; ?>">
				<input type="hidden" name="servicecoa" value="<?php echo $servicecoa; ?>">
				<input type="hidden" name="pharmacycoa" value="<?php echo $pharmacycoa; ?>">
				<input type="hidden" name="referalcoa" value="<?php echo $referalcoa; ?>">
				<input type="hidden" name="cashcoa" value="<?php echo $cashcoa; ?>">
				<input type="hidden" name="chequecoa" value="<?php echo $chequecoa; ?>">
				<input type="hidden" name="mpesacoa" value="<?php echo $mpesacoa; ?>">
				<input type="hidden" name="cardcoa" value="<?php echo $cardcoa; ?>">
				<input type="hidden" name="onlinecoa" value="<?php echo $onlinecoa; ?>">
				</tr>       
               
			   <tr>
			    <td width="17%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Age </strong></td>
                <td align="left" valign="top" class="bodytext3">
				<input type="text" name="age" id="age" value="" size="18" />	</td>			
			   	  <td width="17%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Gender</strong></td>
                <td align="left" valign="top" class="bodytext3">
				<select name="gender" id="gender">
				<option value="">Select </option>
				<option value="Male">Male </option>
				<option value="Female">Female </option>
				</select></td>	
                </tr>
				  <tr>
							 <td align="left" valign="middle" class="bodytext3"><strong>Bill Date</strong></td>
				<td><input type="text" name="billdate" id="billdate" value="<?php echo $dateonly; ?>" size="18" rsize="20" readonly/>				</td>	
                 <td align="left" valign="middle" class="bodytext3"><strong>Bill No</strong></td>
				<td><input type="text" name="billno" id="billno" value="<?php echo $billnumbercode; ?>" size="18" rsize="20" readonly/></td>
				  </tr>
                  				
				 		
				 
				  	<tr>
                <td colspan="7" class="bodytext32"><strong>&nbsp;</strong></td>
			 </tr>
            </tbody>
        </table></td>
      </tr>
     
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
          
			 
				  
				   <tr>
				   <td colspan="11" align="left" valign="middle"  bgcolor="#CCCCCC" class="bodytext3"><span class="bodytext32"><strong>Lab <img src="images/plus1.gif" width="13" height="13" onDblClick="return funcLabHideView()"  onClick="return funcLabShowView()"> </strong></span></td>
			      </tr>
				  
				  <tr id="labid">
				   <td colspan="11" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
				     <table width="621" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="30" class="bodytext3">Laboratory Test</td>
                       <td class="bodytext3">Rate</td>
                       <td width="30" class="bodytext3">&nbsp;</td>
                     </tr>
					  <tr>
					 <div id="insertrow1">					 </div></tr>
					  <tr>
					  <input type="hidden" name="serialnumber1" id="serialnumber17" value="1">
					  <input type="hidden" name="labcode" id="labcode" value="">
				      <td width="30"><input name="lab[]" id="lab" type="text" size="69" autocomplete="off" ></td>
				      <td width="30"><input name="rate5[]" type="text" id="rate5" readonly size="8"></td>
					  <td><label>
                       <input type="button" name="Add1" id="Add1" value="Add" onClick="return insertitem2()" class="button">
                       </label></td>
					   </tr>
					    </table>	  </td> 
				  </tr>
				  <tr>
				   <td colspan="8" align="right" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Total</strong><input type="text" id="total1" readonly size="7"></td>
				  </tr> 
		         <tr>
				   <td colspan="11" align="left" valign="middle"  bgcolor="#CCCCCC" class="bodytext3"><span class="bodytext32"><strong>Radiology <img src="images/plus1.gif" width="13" height="13" onDblClick="return funcRadHideView()"  onClick="return funcRadShowView()"> </strong></span></td>
		        </tr>
				<tr id="radid">
				   <td colspan="11" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
				    <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="30" class="bodytext3">Radiology Test</td>
                       <td class="bodytext3">Rate</td>
                       <td width="30" class="bodytext3">&nbsp;</td>
                     </tr>
					  <tr>
					 <div id="insertrow2">					 </div></tr>
					  <tr>
					  <input type="hidden" name="serialnumber2" id="serialnumber27" value="1">
					  <input type="hidden" name="radiologycode" id="radiologycode" value="">
				   <td width="30"><input name="radiology[]" id="radiology" type="text" size="69" autocomplete="off"></td>
				      <td width="30"><input name="rate8[]" type="text" id="rate8" readonly size="8"></td>
					   <td><label>
                       <input type="button" name="Add2" id="Add2" value="Add" onClick="return insertitem3()" class="button">
                       </label></td>
				      </tr>
					    </table>						</td>
		        </tr>
				
				 <tr>
				   <td colspan="8" align="right" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Total</strong><input type="text" id="total2" readonly size="7"></td>
				   </tr>
		        <tr>
				   <td colspan="11" align="left" valign="middle"  bgcolor="#CCCCCC" class="bodytext3"><span class="bodytext32"><strong>Services <img src="images/plus1.gif" width="13" height="13" onDblClick="return funcSerHideView()" onClick="return funcSerShowView()"> </strong></span></td>
		        </tr>
				<tr id="serid">
				   <td colspan="11" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
				    <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="30" class="bodytext3">Services</td>
                       <td class="bodytext3">Rate</td>
                       <td width="30" class="bodytext3">&nbsp;</td>
                     </tr>
					  <tr>
					 <div id="insertrow3">					 </div></tr>
					  <tr>
					  <input type="hidden" name="serialnumber3" id="serialnumber3" value="1">
					  <input type="hidden" name="servicescode" id="servicescode" value="">
				   <td width="30"><input name="services[]" type="text" id="services" size="69"></td>
				    <td width="30"><input name="rate3[]" type="text" id="rate3" readonly size="8"></td>
					   <td><label>
                       <input type="button" name="Add3" id="Add3" value="Add" onClick="return insertitem4()" class="button">
                       </label></td>
					   </tr>
					    </table></td>
		       </tr>
			   <tr>
				   <td colspan="8" align="right" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Total</strong><input type="text" id="total3" readonly size="7"></td>
				 <input type="hidden" id="total4" readonly size="7">
				   </tr>
				            
          </tbody>
        </table>		</td>
		<tr>
		 <td colspan="7" class="bodytext31" valign="center"  align="left" >&nbsp;</td>
		</tr>
		<tr>
		<td>
		<table width="99%" border="0" 
            align="left" cellpadding="2" cellspacing="0" 
            bordercolor="#666666" bgcolor="#F3F3F3" id="AutoNumber3" style="BORDER-COLLAPSE: collapse">
            <tbody id="foo">

              <tr>
                <td width="1%" align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>
                <td colspan="4" rowspan="10" align="left" valign="top"  
                bgcolor="#F3F3F3" class="bodytext31">		
				<!--<table width="99%" border="0" align="right" cellpadding="2" cellspacing="0"  style="BORDER-COLLAPSE: collapse">
				<tr>
				  <td width="53%" align="left" valign="center"  
				bgcolor="#F3F3F3" class="bodytext31"><div align="right"><span class="bodytext311"><strong> Disc %                  </strong></span></div></td>
				  <td><span class="bodytext311"><strong>
				    <input name="allitemdiscountpercent" id="allitemdiscountpercent" onKeyUp="return funcAllItemDiscountApply1()" 
				style=" text-align:right;" value="0.00" size="4" />
				  <input name="allitemdiscountpercent1" id="allitemdiscountpercent1" onKeyUp="return funcAllItemDiscountApply1()" 
				style=" text-align:right;background-color:#CCCCCC" value="0.00" size="4"  />
				  <input name="subtotaldiscountpercent" id="subtotaldiscountpercent" onKeyDown="return funcResetPaymentInfo1()" 
					 type="hidden" onBlur="return funcbillamountcalc1()" value="0.00" style=" text-align:right" size="8" />
				    <input name="totaldiscountamount" id="totaldiscountamount" value="0.00" type="hidden" style=" text-align:right" size="8"  readonly="readonly" />
				    <input type="hidden" name="subtotaldiscountrupees" id="subtotaldiscountrupees" onKeyDown="return funcResetPaymentInfo1()" onBlur="return funcbillamountcalc1()" value="0.00" style=" text-align:right" size="8" />
				    <input type="hidden" name="afterdiscountamount" id="afterdiscountamount" value="0.00" style=" text-align:right" size="8"  readonly="readonly" />
				  </strong></span></td>
				  </tr>
				 
				  <tr bordercolor="#f3f3f3">
                    <td align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#F3F3F3" class="bodytext31"><div align="right"><span class="bodytext311"><strong>  Disc Amt </strong></span></div></td>
				    <td><span class="bodytext311"><strong>
                      <input name="totaldiscountamountonlyapply1" id="totaldiscountamountonlyapply1" onKeyUp="return funcDiscountAmountCalc1()" 
				type="text" style=" text-align:right;" value="0.00" size="4" />
                      <input name="totaldiscountamountonlyapply2" id="totaldiscountamountonlyapply2" onKeyUp="return funcDiscountAmountCalc1()" readonly  
				type="text" style=" text-align:right; background-color:#CCCCCC" value="0.00" size="4" />
                    </strong></span></td>
				    </tr>
			
				  
 				
				  <tr>
                    <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31"><span class="bodytext311">
                     
                    </span>
                      <div align="right"><strong><?php //.' '.$res6taxpercent.'%'; ?></strong></div></td>
                    <td width="39%"><span class="bodytext312">
                     
                    </span></td>
                  </tr>
                </table>-->						  </td>
				<?php
				$originalamount = $totalamount;
			  $totalamount = round($totalamount/5,2)*5;
			  $totalamount = number_format($totalamount,2,'.','');
			  $roundoffamount = $originalamount - $totalamount;
			  $roundoffamount = number_format($roundoffamount,2,'.','');
			  $roundoffamount = -($roundoffamount);
			  ?>
                <td width="3%" rowspan="3" align="right" valign="top"  
                bgcolor="#F3F3F3" class="style1" id="tdShowTotal"><?php echo $totalamount; ?><input name="subtotal1" id="subtotal1" value="" class="bal" readonly type="hidden"></td>
                <td width="12%" align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Sub Total </strong></div></td>
                <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31" width="6%">&nbsp;</td>
                <td align="left" valign="top" bgcolor="#F3F3F3" width="15%"><span class="bodytext31">
                  <input name="subtotal" id="subtotal" value="<?php echo $originalamount; ?>" style="text-align:right" size="8"  readonly="readonly" />
                </span></td>
				
                <td align="left" valign="top" bgcolor="#F3F3F3" width="10%">&nbsp;</td>
                <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext31" width="8%"><div align="right"><strong>Bill Amt </strong></div></td>
                <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext31" width="6%">&nbsp;</td>
                <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext31" width="9%"><span class="bodytext311">
                 
                <input name="totalamount" id="totalamount" value="<?php echo $totalamount; ?>" style="text-align:right" size="8"  readonly="readonly" />
                </span></td>
                <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext31" width="23%">&nbsp;</td>
              </tr>
			  
              <tr>
                <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>
                <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Round Off </strong></div></td>
                <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31" width="6%">&nbsp;</td>
                <td align="left" valign="top" bgcolor="#F3F3F3" width="15%"><span class="bodytext311">
				 <input name="roundoff" id="roundoff" value="<?php echo $roundoffamount; ?>" style="text-align:right"  readonly="readonly" size="8"/>
                  <input name="totalaftercombinediscount" id="totalaftercombinediscount" value="0.00" style="text-align:right" size="8"  readonly="readonly" type="hidden"/>
                </span></td>
                <td align="left" valign="top" bgcolor="#F3F3F3" width="10%">&nbsp;</td>
                <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext311" width="8%"><div align="right"><strong>Nett Amt</strong></div></td>
                <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext311" width="6%">&nbsp;</td>
                <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext311" width="9%"><span class="bodytext31">
                   <input name="nettamount" id="nettamount" value="0.00" style="text-align:right" size="8" readonly />
                </span></td>
                <td align="left" valign="center" bgcolor="#F3F3F3" class="bodytext311" width="23%">&nbsp;</td>
              </tr>
              <input type="hidden" name="totalaftertax" id="totalaftertax" value="0.00"  onKeyDown="return disableEnterKey()" onBlur="return funcSubTotalCalc()" style=" text-align:right" size="8"  readonly="readonly"/>
              
               
              <tr>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>
                <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> Mode </strong></div></td>
                <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31" width="6%">&nbsp;</td>
                <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31" width="15%"><select name="billtype" id="billtype" onChange="return paymentinfo()">
                  <option value="">SELECT BILL TYPE</option>
                  <?php
					$query1billtype = "select * from master_billtype where status = '' order by listorder";
					$exec1billtype = mysql_query($query1billtype) or die ("Error in Query1billtype".mysql_error());
					while ($res1billtype = mysql_fetch_array($exec1billtype))
					{
					$billtype = $res1billtype["billtype"];
					?>
                  <option value="<?php echo $billtype; ?>"><?php echo $billtype; ?></option>
                  <?php
					}
					?>
                  <!--					
                    <option value="CASH">CASH</option>
                    <option value="CREDIT">CREDIT</option>
                    <option value="CHEQUE">CHEQUE</option>
                    <option value="CREDIT CARD">CREDIT CARD</option>
                    <option value="ONLINE">ONLINE</option>
                    <option value="SPLIT">SPLIT</option>
-->
                </select></td>
                <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31" width="10%">&nbsp;</td>
                <td align="left" valign="middle" bgcolor="#F3F3F3" class="bodytext31" width="8%">
				<!--<select name="billtype" id="billtype" onChange="return paymentinfo()" onFocus="return funcbillamountcalc1()">--></td>
                
                <td align="left" valign="middle" bgcolor="#F3F3F3" class="bodytext31" width="6%">&nbsp;</td>
                <td align="left" valign="middle" bgcolor="#F3F3F3" width="9%">&nbsp;</td>
                <td align="left" valign="middle" bgcolor="#F3F3F3" width="23%">&nbsp;</td>
              </tr>
			  <tr>
			   <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>
			  </tr>
			  <tr>
			   <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>
			  </tr>
              <tr id="cashamounttr">
			 
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"></td>
                <td colspan="2" align="right" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Cash </strong></div></td>
                                <td width="6%" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><input name="cashamount" id="cashamount" onBlur="return funcbillamountcalc1()" tabindex="1" value="0.00" style="text-align:right" size="8"  readonly="readonly" onKeyUp="return balancecalc('1')"/></td>
                <td width="15%" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Cash Recd </strong></div></td>
                <td width="10%" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><input name="cashgivenbycustomer" id="cashgivenbycustomer" onKeyUp="return funcbillamountcalc1()" onFocus="return cashentryonfocus1()" tabindex="2" style="text-align:right" size="8" autocomplete="off"  /></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="8%"><div align="right"><strong>Change   </strong></div></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="6%"><input name="cashgiventocustomer" id="cashgiventocustomer" onBlur="return funcbillamountcalc1()" value="0.00" style="text-align:right" size="8" readonly  /></td>
               
               
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="9%">&nbsp;</td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>
              </tr>
			
              <tr id="creditamounttr">
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"></td>
                <td colspan="2" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> MPESA </strong></div></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="6%"><input name="creditamount" id="creditamount" onBlur="return funcbillamountcalc1()" value="0.00" style=" text-align:right" size="8"  readonly="readonly" onKeyUp="return balancecalc('2')"/></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> MPESA No. </strong></div></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="10%"><input name="mpesanumber" id="mpesanumber" value="" style="text-align:left; text-transform:uppercase" size="8"  /></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="8%"></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="6%"></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="9%"></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="23%"></td>
                <td width="1%" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"></td>
              </tr>
              <tr id="chequeamounttr">
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"></td>
                <td colspan="2" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Cheque  </strong></div></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><input name="chequeamount" id="chequeamount" onBlur="return funcbillamountcalc1()" value="0.00" style=" text-align:right" size="8"  readonly="readonly" onKeyUp="return balancecalc('3')"/></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> Chq No. </strong></div></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="10%"><input name="chequenumber" id="chequenumber" value="" style=" text-align:left; text-transform:uppercase" size="8"  /></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="8%"><div align="right"><strong> Date </strong></div></td>
                <td width="6%" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31">  <input name="chequedate" id="chequedate" value="" style=" text-align:left; text-transform:uppercase" size="8"  /></td>
                <td width="9%" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> Bank  </strong></div></td>
                <td width="23%" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"> <input name="chequebank" id="chequebank" value="" style=" text-align:left; text-transform:uppercase" size="8"  /></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"></td>
              </tr>
			  
              <tr id="cardamounttr">
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"></td>
                <td colspan="2" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Card  </strong></div></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><input name="cardamount" id="cardamount" onBlur="return funcbillamountcalc1()" value="0.00" style=" text-align:right" size="8"  readonly="readonly" onKeyUp="return balancecalc('4')"/></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> Card No </strong></div></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="10%"><input name="cardnumber" id="cardnumber" value="" style=" text-align:left; text-transform:uppercase" size="8"  /></td>
                <td width="8%" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Name  </strong></div></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="6%"><input type="text" name="cardname" id="cardname" size="8" style=" text-align:left;">
                <!--<select name="cardname" id="cardname">
                  <option value="">SELECT CARD</option>
                  <?php
				$querycom="select * from master_creditcard where status <> 'deleted'";
				$execcom=mysql_query($querycom) or die("Error in querycom".mysql_error());
				while($rescom=mysql_fetch_array($execcom))
				{
				$creditcardname=$rescom["creditcardname"];
				?>
                  <option value="<?php echo $creditcardname;?>"><?php echo $creditcardname;?></option>
                  <?php
				}
				?>
                </select>--></td>
                <td align="left" valign="center" class="bodytext31" width="9%"><div align="right"><strong> Bank  </strong></div></td>
                <td align="left" valign="center" class="bodytext31" width="23%"><input name="bankname1" id="bankname" value="" style=" text-align:left; text-transform:uppercase"  size="8"  /></td>
              </tr>
              <tr id="onlineamounttr">
			  <td align="left" valign="center"
                bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>
			    <td colspan="2" align="left" valign="center" 
                bgcolor="#F3F3F3" class="bodytext31">
                 <div align="right"><strong>Online  </strong></div>                  </td>
                <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31"><input name="onlineamount" id="onlineamount" onBlur="return funcbillamountcalc1()" value="0.00" style=" text-align:right" size="8" readonly onKeyUp="return balancecalc('5')"/></td>
                 <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> Online No </strong></div></td>
                <td align="left" valign="center"  
                 class="bodytext31" width="10%"><input name="onlinenumber" id="onlinenumber" value="" style=" text-align:left; text-transform:uppercase" size="8"  /></td>
                <td align="left" valign="center"  
                 class="bodytext31" width="8%">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31" width="6%">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31" width="9%">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31" width="23%">&nbsp;</td>
                <td align="left" valign="center"  
                 class="bodytext31">&nbsp;</td>
              </tr>
				
              



              
              
              <tr>
                
                <td colspan="14" align="left" valign="center"  
                bgcolor="#CCCCCC" class="bodytext31"><div align="right"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
                  <input name="delbillst" id="delbillst" type="hidden" value="billedit">
                  <input name="delbillautonumber" id="delbillautonumber" type="hidden" value="<?php echo $delbillautonumber;?>">
                  <input name="delbillnumber" id="delbillnumber" type="hidden" value="<?php echo $delbillnumber;?>">

				  <input name="Submit2223" type="submit" onClick="return funcSaveBill1()" value="Save Bill(Alt+S)" accesskey="s" class="button"/>
                </font></font></font></font></font></div></td>
              </tr>
			  
			 <!-- <tr>
                <td colspan="8" class="bodytext32">
				<div align="right"><span class="bodytext31">
                <strong>Print Bill No: </strong>
                <input name="quickprintbill" id="quickprintbill" value="<?php echo $billnumber; ?>" style=" text-align:right; text-transform:uppercase"  size="7"  />
                <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                <input name="print4inch2" type="hidden" class="button" id="print4inch2" style="border: 1px solid #001E6A" 
				  onClick="return quickprintbill1sales()" value="Print 40" accesskey="p"/>
                </font></font></font></font></font></font></font></font></font>                <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input name="print4inch" type="button" class="button" id="print4inch" style="border: 1px solid #001E6A" 
				  onClick="return quickprintbill2sales()" value="View 40" accesskey="p"/>
                  <input onClick="return loadprintpage1('A4<?php //echo $previousbillnumber; ?>')" value="View A4" 
				  name="printA4" type="button" class="button" id="printA4" style="border: 1px solid #001E6A"/>
                  <input onClick="return loadprintpage1('A5<?php //echo $previousbillnumber; ?>')" value="View A5" 
				  name="printA5" type="button" class="button" id="printA5" style="border: 1px solid #001E6A"/>
                </font></font></font></font></font></font></font></font></font></span></div>
				</td>
			 </tr>-->
			 
            </tbody>
        </table>
	
    </table>

</form>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>