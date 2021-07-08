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

$query1111 = "select * from master_employee where username = '$username'";
			$exec1111 = mysql_query($query1111) or die ("Error in Query1111".mysql_error());
			 while ($res1111 = mysql_fetch_array($exec1111))
			 {
			   $locationnumber = $res1111["location"];
			   	  $useranum = $res1111["auto_number"];

			   $query1112 = "select * from master_location where auto_number = '$locationnumber' and status<>'deleted'";
				$exec1112 = mysql_query($query1112) or die ("Error in Query1112".mysql_error());
			 while ($res1112 = mysql_fetch_array($exec1112))
			 {
			   $locationname = $res1112["locationname"];    
			   $locationcode = $res1112["locationcode"];
			 }
			 }

			
if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }

$titlestr = 'SALES BILL';
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{




    $visitcode=$_REQUEST["visitcode"];
	$patientcode = $_REQUEST["customercode"];
	
	$Querylab=mysql_query("select * from master_customer where customercode='$patientcode'");
	$execlab=mysql_fetch_array($Querylab);
	$patientpaymenttype = $execlab['billtype'];

	$patientname = $_REQUEST["patientname"];
	
	$query43 = "select * from master_consultation where patientvisitcode='$visitcode' order by auto_number desc";
	$exec43 = mysql_query($query43) or die(mysql_error());
	$res43 = mysql_fetch_array($exec43);
	$consultationid = $res43['consultation_id'];
	
	
	if($consultationid == '')
	{
	$query431 = "select * from master_triagebilling where patientvisitcode='$visitcode' order by auto_number desc";
	$exec431 = mysql_query($query431) or die(mysql_error());
	$res431 = mysql_fetch_array($exec431);
	$consultationid = $res431['docnumber'];
	}
	
	/*if($patientpaymenttype == 'PAY LATER')
	{
	$query4311 = "select * from approvalstatus where visitcode='$visitcode' order by auto_number desc";
	$exec4311 = mysql_query($query4311) or die(mysql_error());
	$res4311 = mysql_fetch_array($exec4311);
	$consultationid = $res4311['docno'];
	}*/
	
	

	$accountname= $_REQUEST['accountname'];
	$subtype = $_REQUEST['subtype'];
	$totalamount=$_REQUEST['totalamount'];
	$billdate=$_REQUEST['billdate'];
	$referalname=$_REQUEST['referalname'];
	$paymentmode = $_REQUEST['billtype'];
	$chequenumber = $_REQUEST['chequenumber'];
		$chequedate = $_REQUEST['chequedate'];
		$bankname = $_REQUEST['chequebank'];
		$bankbranch = $_REQUEST['bankbranch'];
		$remarks = $_REQUEST['remarks'];
		$card = $_REQUEST['cardname'];
		$cardnumber = $_REQUEST['cardnumber'];
		$bankname1 = $_REQUEST['bankname1'];
		$paymenttype = $_REQUEST['paymenttype'];
		$query77 = "select * from master_visitentry where visitcode='$visitcode'";
		$exec77 = mysql_query($query77) or die(mysql_error());
		$res77 = mysql_fetch_array($exec77);
		$doctor = $res77['consultingdoctor'];
		$cashgiventocustomer = $_REQUEST['cashgiventocustomer'];
		$cashgivenbycustomer = $_REQUEST['cashgivenbycustomer'];
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
		$mpesanumber = $_REQUEST['mpesanumber'];
		$onlinenumber = $_REQUEST['onlinenumber'];
		$dispensingfee = $_REQUEST['dispensingfee'];
		$dispensingdocno = $_REQUEST['dispensingdocno'];
	
		//get location from form
		 $locationname=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';
		 $locationcode=isset($_REQUEST['locationcodeget'])?$_REQUEST['locationcodeget']:'';
		 
		 $ambcount=isset($_REQUEST['ambcount'])?$_REQUEST['ambcount']:'';
		  $ambcount1=isset($_REQUEST['ambcount1'])?$_REQUEST['ambcount1']:'';
		 
		$patientage = $_REQUEST['patientage'];
		$patientgender = $_REQUEST['patientgender'];
		$desipaddress=$_REQUEST['desipaddress'];
		$desusername=$_REQUEST['desusername'];
	
		
		$query7691 = "select * from master_financialintegration where field='externaldoctors'";
		$exec7691 = mysql_query($query7691) or die(mysql_error());
		$res7691 = mysql_fetch_array($exec7691);
		
		$debitcoa = $res7691['code'];
			
		$query78 = "select * from master_doctor where auto_number='$doctor'";
		$exec78 = mysql_query($query78) or die(mysql_error());
		$res78 = mysql_fetch_array($exec78);
		$doctorname = $res78['doctorname'];
		
	$query3 = "select * from master_company where companystatus = 'Active'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	$res3 = mysql_fetch_array($exec3);
	$paynowbillprefix = $res3['paynowbillnoprefix'];
	$paynowbillprefix1=strlen($paynowbillprefix);
	$query2 = "select * from billing_paynow order by auto_number desc limit 0, 1";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	$res2 = mysql_fetch_array($exec2);
	$billnumber = $res2["billno"];
	$billdigit=strlen($billnumber);
	
	$dispensingkey=isset($_REQUEST['dispensingkey'])?$_REQUEST['dispensingkey']:'';
	
	
	if ($billnumber == '')
	{
		$billnumbercode =$paynowbillprefix.'1'.'-'.$useranum;
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
		
		
		$billnumbercode = $paynowbillprefix.$maxanum.'-'.$useranum;
		$openingbalance = '0.00';
		//echo $companycode;
	}
	
	$billnumber = $billnumbercode;
		
		$query386="select * from billing_paynow where billno='$billnumber'";
		$exec386=mysql_query($query386) or die(mysql_error());
		$num386=mysql_num_rows($exec386);
	if($num386 == 0)
	{
	
		//inserting ambulance bill details
		//echo $quantity;
		if($ambcount>0)
		{
			
			foreach($_POST['ambulancecount'] as $key)
			{ $key=$key-1;
				$amdocno=$_REQUEST['amdocno'][$key];
				$accountname=$_REQUEST['accountname'][$key];
				$description=$_REQUEST['description'][$key];
				$quantity=$_REQUEST['quantityop'][$key]; 
				$rate=$_REQUEST['rateop'][$key];
				$amount=$_REQUEST['amountop'][$key];
				
				if($paymentmode != 'SPLIT')
					{
					 if($cashamount > 0)
					 {
					 $query55 = "select * from financialaccount where transactionmode = 'CASH'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $cashcode = $res55['ledgercode'];
					 
					 $referalquery1=mysql_query("insert into billing_opambulance(docno,patientcode,patientname,visitcode,accountname,description,quantity,rate,amount,locationname,locationcode,recordtime,recordstatus,ipaddress,recorddate,username,transactionmode,cashamount,cashcode,billnumber)values('".$amdocno."','$patientcode','$patientname','$visitcode','$accountname','".$description."','".$quantity."','".$rate."','".$amount."','$locationname','$locationcode','".$timeonly."','paid','".$ipaddress."','".$dateonly."','".$username."','CASH','$amount','$cashcode','$billnumber')") or die(mysql_error());
					 
					 }
					 else if($chequeamount > 0)
					 {
					 $query55 = "select * from financialaccount where transactionmode = 'CHEQUE'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $chequecode = $res55['ledgercode'];
					 $referalquery1=mysql_query("insert into billing_opambulance(docno,patientcode,patientname,visitcode,accountname,description,quantity,rate,amount,locationname,locationcode,recordtime,recordstatus,ipaddress,recorddate,username,transactionmode,chequeamount,bankcode,billnumber)values('".$amdocno."','$patientcode','$patientname','$visitcode','$accountname','".$description."','".$quantity."','".$rate."','".$amount."','$locationname','$locationcode','".$timeonly."','paid','".$ipaddress."','".$dateonly."','".$username."','CHEQUE','$amount','$chequecode','$billnumber')") or die(mysql_error());
					
					 }
					 else if($onlineamount > 0)
					 {
					 $query55 = "select * from financialaccount where transactionmode = 'ONLINE'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $chequecode = $res55['ledgercode'];
					 
					 $referalquery1=mysql_query("insert into billing_opambulance(docno,patientcode,patientname,visitcode,accountname,description,quantity,rate,amount,locationname,locationcode,recordtime,recordstatus,ipaddress,recorddate,username,transactionmode,onlineamount,bankcode,billnumber)values('".$amdocno."','$patientcode','$patientname','$visitcode','$accountname','".$description."','".$quantity."','".$rate."','".$amount."','$locationname','$locationcode','".$timeonly."','paid','".$ipaddress."','".$dateonly."','".$username."','ONLINE','$amount','$chequecode','$billnumber')") or die(mysql_error());
					
					 }
					 else if($creditamount > 0)
					 {
					 $query55 = "select * from financialaccount where transactionmode = 'MPESA'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $mpesacode = $res55['ledgercode'];
					 
					 $referalquery1=mysql_query("insert into billing_opambulance(docno,patientcode,patientname,visitcode,accountname,description,quantity,rate,amount,locationname,locationcode,recordtime,recordstatus,ipaddress,recorddate,username,transactionmode,creditamount,mpesacode,billnumber)values('".$amdocno."','$patientcode','$patientname','$visitcode','$accountname','".$description."','".$quantity."','".$rate."','".$amount."','$locationname','$locationcode','".$timeonly."','paid','".$ipaddress."','".$dateonly."','".$username."','MPESA','$amount','$mpesacode','$billnumber')") or die(mysql_error());
					
					 }
					 else if($cardamount > 0)
					 {
					 $query55 = "select * from financialaccount where transactionmode = 'CREDITCARD'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $chequecode = $res55['ledgercode'];
					 
					 $referalquery1=mysql_query("insert into billing_opambulance(docno,patientcode,patientname,visitcode,accountname,description,quantity,rate,amount,locationname,locationcode,recordtime,recordstatus,ipaddress,recorddate,username,transactionmode,cardamount,bankcode,billnumber)values('".$amdocno."','$patientcode','$patientname','$visitcode','$accountname','".$description."','".$quantity."','".$rate."','".$amount."','$locationname','$locationcode','".$timeonly."','paid','".$ipaddress."','".$dateonly."','".$username."','CREDIT CARD','$amount','$chequecode','$billnumber')") or die(mysql_error());
															 
					 }
				 }
				 else
				 {
					 $query55 = "select * from financialaccount where transactionmode = 'CASH'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $cashcode = $res55['ledgercode'];
					 
					 $query551 = "select * from financialaccount where transactionmode = 'CHEQUE'";
					 $exec551 = mysql_query($query551) or die ("Error in Query551".mysql_error());
					 $res551 = mysql_fetch_array($exec551);
					 $chequecode = $res551['ledgercode'];
					 
					 $query552 = "select * from financialaccount where transactionmode = 'MPESA'";
					 $exec552 = mysql_query($query552) or die ("Error in Query552".mysql_error());
					 $res552 = mysql_fetch_array($exec552);
					 $mpesacode = $res552['ledgercode'];
					 
					 $referalquery178=mysql_query("insert into billing_opambulance(docno,patientcode,patientname,visitcode,accountname,description,quantity,rate,amount,locationname,locationcode,recordtime,recordstatus,ipaddress,recorddate,username,transactionmode,cashamount,onlineamount,chequeamount,cardamount,creditamount,bankcode,cashcode,mpesacode,billnumber)values('".$amdocno."','$patientcode','$patientname','$visitcode','$accountname','".$description."','".$quantity."','".$rate."','".$amount."','$locationname','$locationcode','".$timeonly."','paid','".$ipaddress."','".$dateonly."','".$username."','SPLIT','$amount','0.00','0.00','0.00','0.00','$chequecode','$cashcode','$mpesacode','$billnumber')") or die(mysql_error());
				}
				//$referalquery1=mysql_query("insert into billing_opambulance(docno,patientcode,patientname,visitcode,accountname,description,quantity,rate,amount,locationname,locationcode,recordtime,recordstatus,ipaddress,recorddate,username)values('".$amdocno."','$patientcode','$patientname','$visitcode','$accountname','".$description."','".$quantity."','".$rate."','".$amount."','$locationname','$locationcode','".$timeonly."','paid','".$ipaddress."','".$dateonly."','".$username."')") or die(mysql_error());
				}
				
				mysql_query("update op_ambulance set paymentstatus='completed' where patientvisitcode='$visitcode'");
			}
			//insert query  for homecare
			if($ambcount1>0)
		{
			
			foreach($_POST['ambulancecounthom'] as $key)
			{ 
				$amdocno1=$_REQUEST['amdocnohom'][$key];
				$accountname1=$_REQUEST['accountnamehom'][$key];
				$description1=$_REQUEST['descriptionhom'][$key];
				$quantity1=$_REQUEST['quantityhom'][$key];
				$rate1=$_REQUEST['ratehom'][$key];
				$amount1=$_REQUEST['amounthom'][$key];
				
				if($paymentmode != 'SPLIT')
					{
					 if($cashamount > 0)
					 {
					 $query55 = "select * from financialaccount where transactionmode = 'CASH'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $cashcode = $res55['ledgercode'];
					 
					 $referalquery1=mysql_query("insert into billing_homecare(docno,patientcode,patientname,visitcode,accountname,description,quantity,rate,amount,locationname,locationcode,recordtime,recordstatus,ipaddress,recorddate,username,transactionmode,cashamount,cashcode,billnumber)values('".$amdocno1."','$patientcode','$patientname','$visitcode','$accountname1','".$description1."','".$quantity1."','".$rate1."','".$amount1."','$locationname','$locationcode','".$timeonly."','paid','".$ipaddress."','".$dateonly."','".$username."','CASH','$amount1','$cashcode','$billnumber')") or die(mysql_error());
					 
					 }
					 else if($chequeamount > 0)
					 {
					 $query55 = "select * from financialaccount where transactionmode = 'CHEQUE'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $chequecode = $res55['ledgercode'];
					 $referalquery1=mysql_query("insert into billing_homecare(docno,patientcode,patientname,visitcode,accountname,description,quantity,rate,amount,locationname,locationcode,recordtime,recordstatus,ipaddress,recorddate,username,transactionmode,chequeamount,bankcode,billnumber)values('".$amdocno1."','$patientcode','$patientname','$visitcode','$accountname1','".$description1."','".$quantity1."','".$rate1."','".$amount1."','$locationname','$locationcode','".$timeonly."','paid','".$ipaddress."','".$dateonly."','".$username."','CHEQUE','$amount1','$chequecode','$billnumber')") or die(mysql_error());
					
					 }
					 else if($onlineamount > 0)
					 {
					 $query55 = "select * from financialaccount where transactionmode = 'ONLINE'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $chequecode = $res55['ledgercode'];
					 
					 $referalquery1=mysql_query("insert into billing_homecare(docno,patientcode,patientname,visitcode,accountname,description,quantity,rate,amount,locationname,locationcode,recordtime,recordstatus,ipaddress,recorddate,username,transactionmode,onlineamount,bankcode,billnumber)values('".$amdocno1."','$patientcode','$patientname','$visitcode','$accountname1','".$description1."','".$quantity1."','".$rate1."','".$amount1."','$locationname','$locationcode','".$timeonly."','paid','".$ipaddress."','".$dateonly."','".$username."','ONLINE','$amount1','$chequecode','$billnumber')") or die(mysql_error());
					
					 }
					 else if($creditamount > 0)
					 {
					 $query55 = "select * from financialaccount where transactionmode = 'MPESA'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $mpesacode = $res55['ledgercode'];
					 
					 $referalquery1=mysql_query("insert into billing_homecare(docno,patientcode,patientname,visitcode,accountname,description,quantity,rate,amount,locationname,locationcode,recordtime,recordstatus,ipaddress,recorddate,username,transactionmode,creditamount,mpesacode,billnumber)values('".$amdocno1."','$patientcode','$patientname','$visitcode','$accountname1','".$description1."','".$quantity1."','".$rate1."','".$amount1."','$locationname','$locationcode','".$timeonly."','paid','".$ipaddress."','".$dateonly."','".$username."','MPESA','$amount1','$mpesacode','$billnumber')") or die(mysql_error());
					
					 }
					 else if($cardamount > 0)
					 {
					 $query55 = "select * from financialaccount where transactionmode = 'CREDITCARD'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $chequecode = $res55['ledgercode'];
					 
					 $referalquery1=mysql_query("insert into billing_homecare(docno,patientcode,patientname,visitcode,accountname,description,quantity,rate,amount,locationname,locationcode,recordtime,recordstatus,ipaddress,recorddate,username,transactionmode,cardamount,bankcode,billnumber)values('".$amdocno1."','$patientcode','$patientname','$visitcode','$accountname1','".$description1."','".$quantity1."','".$rate1."','".$amount1."','$locationname','$locationcode','".$timeonly."','paid','".$ipaddress."','".$dateonly."','".$username."','CREDIT CARD','$amount1','$chequecode','$billnumber')") or die(mysql_error());
															 
					 }
				 }
				 else
				 {
					 $query55 = "select * from financialaccount where transactionmode = 'CASH'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $cashcode = $res55['ledgercode'];
					 
					 $query551 = "select * from financialaccount where transactionmode = 'CHEQUE'";
					 $exec551 = mysql_query($query551) or die ("Error in Query551".mysql_error());
					 $res551 = mysql_fetch_array($exec551);
					 $chequecode = $res551['ledgercode'];
					 
					 $query552 = "select * from financialaccount where transactionmode = 'MPESA'";
					 $exec552 = mysql_query($query552) or die ("Error in Query552".mysql_error());
					 $res552 = mysql_fetch_array($exec552);
					 $mpesacode = $res552['ledgercode'];
					 
					 $referalquery199=mysql_query("insert into billing_homecare(docno,patientcode,patientname,visitcode,accountname,description,quantity,rate,amount,locationname,locationcode,recordtime,recordstatus,ipaddress,recorddate,username,transactionmode,cashamount,onlineamount,chequeamount,cardamount,creditamount,bankcode,cashcode,mpesacode,billnumber)values('".$amdocno1."','$patientcode','$patientname','$visitcode','$accountname1','".$description1."','".$quantity1."','".$rate1."','".$amount1."','$locationname','$locationcode','".$timeonly."','paid','".$ipaddress."','".$dateonly."','".$username."','SPLIT','$amount1','0.00','0.00','0.00','0.00','$chequecode','$cashcode','$mpesacode','$billnumber')") or die(mysql_error());
					
				}	
				//$referalquery1=mysql_query("insert into billing_homecare(docno,patientcode,patientname,visitcode,accountname,description,quantity,rate,amount,locationname,locationcode,recordtime,recordstatus,ipaddress,recorddate,username)values('".$amdocno1."','$patientcode','$patientname','$visitcode','$accountname1','".$description1."','".$quantity1."','".$rate1."','".$amount1."','$locationname','$locationcode','".$timeonly."','paid','".$ipaddress."','".$dateonly."','".$username."')") or die(mysql_error());
				}
				
				mysql_query("update homecare set paymentstatus='completed' where patientvisitcode='$visitcode'");
			}
			//ends here
		$query3861="select * from billing_paynow where visitcode='$visitcode' and consultationid='$consultationid'";
		$exec3861=mysql_query($query3861) or die(mysql_error());
		$num3861=mysql_num_rows($exec3861);//echo 'ok';
	
	if($num3861 == 0)
	{
	
			
		    $query29 = "select * from master_consultationpharm where patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$exec29 = mysql_query($query29) or die ("Error in Query29".mysql_error());
			$num29=mysql_num_rows($exec29);
			
		if($num29 != 0)
		{
		mysql_query("update master_visitentry set pharmacybill='completed' where visitcode='$visitcode'");
		mysql_query("update master_consultationpharm set pharmacybill='completed', paymentstatus = 'completed' where patientvisitcode='$visitcode'"); 
		}
			$query23 = "select * from billing_pharmacy where billnumber = '$billnumber'";
	$exec23 = mysql_query($query23) or die ("Error in Query2".mysql_error());
	$res23 = mysql_num_rows($exec233);
	if ($res23 == 0)
	{
	$query24=mysql_query("insert into billing_pharmacy(billnumber,patientcode,patientvisitcode,patientname,accountname,subtotal,billdate,totalamountafterdis,grandtotal,paymentmode,locationname,locationcode)values('$billnumber','$patientcode','$visitcode','$patientname','$accountname','$subtotal','$billingdatetime','$totalamountafterdis','$patientbillamount','$patientpaymentmode','$locationname','$locationcode')") or die(mysql_error());
		}
	$query30=mysql_query("update master_consultation set paymentstatus='completed' where patientvisitcode='$visitcode'");
		foreach($_POST['pharmname'] as $key => $value)
		{
		$pharmname=$_POST['pharmname'][$key];
		$pharmname =addslashes($pharmname);
	
	$query34=mysql_query("update master_consultationpharm set billing='completed', paymentstatus = 'completed' where medicinename='$pharmname' and patientvisitcode='$visitcode'") or die(mysql_error());
	$query38=mysql_query("update master_consultationpharmissue set paymentstatus='completed' where medicinename='$pharmname' and patientvisitcode='$visitcode'");
	}
		
		  $query30 = "select * from consultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$exec30 = mysql_query($query30) or die ("Error in Query1".mysql_error());
		$num30=mysql_num_rows($exec30);
		if($num30 != 0)
		{
		mysql_query("update master_visitentry set labbill='completed' where visitcode='$visitcode'");
		}
		$query23 = "select * from billing_lab where billnumber = '$billnumber'";
	$exec23 = mysql_query($query23) or die ("Error in Query2".mysql_error());
	$res23 = mysql_num_rows($exec233);
	if ($res23 == 0)
	{
	$query24=mysql_query("insert into billing_lab(billnumber,patientcode,patientname,accountname,subtotal,billdate,totalamountafterdis,grandtotal,paymentmode,locationname,locationcode)values('$billnumber','$patientcode','$patientname','$accountname','$subtotal','$billingdatetime','$totalamountafterdis','$patientbillamount','$patientpaymentmode','$locationname','$locationcode')") or die(mysql_error());
	}
	
	//echo "update consultation_lab set paymentstatus='completed' , copay = 'completed' where patientvisitcode='$visitcode'";
	$query27=mysql_query("update consultation_lab set paymentstatus='completed' , copay = 'completed' where patientvisitcode='$visitcode'");
	
		 $query31 = "select * from consultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$exec31 = mysql_query($query31) or die ("Error in Query1".mysql_error());
			$num31=mysql_num_rows($exec31);
			if($num31 != 0)
			{
			mysql_query("update master_visitentry set radiologybill='completed' where visitcode='$visitcode'");
			}
			$query23 = "select * from billing_radiology where billnumber = '$billnumber'";
	$exec23 = mysql_query($query23) or die ("Error in Query2".mysql_error());
	$res23 = mysql_num_rows($exec233);
	if ($res23 == 0)
	{
	
	$query24=mysql_query("insert into billing_radiology(billnumber,patientcode,patientname,accountname,subtotal,billdate,totalamountafterdis,grandtotal,paymentmode,locationname,locationcode)values('$billnumber','$patientcode','$patientname','$accountname','$subtotal','$billingdatetime','$totalamountafterdis','$patientbillamount','$patientpaymentmode','$locationname','$locationcode')") or die(mysql_error());
	
	}
$query28=mysql_query("update consultation_radiology set paymentstatus='completed' where patientvisitcode='$visitcode'") or die(mysql_query());

				  $query32 = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$exec32 = mysql_query($query32) or die ("Error in Query1".mysql_error());
		$num32=mysql_num_rows($exec32);
		if($num32 != 0)
		{
			mysql_query("update master_visitentry set servicebill='completed' where visitcode='$visitcode'");
		}
		$query23 = "select * from billing_services where billnumber = '$billnumber'";
	$exec23 = mysql_query($query23) or die ("Error in Query2".mysql_error());
	$res23 = mysql_num_rows($exec233);
	if ($res23 == 0)
	{
	//echo "insert into billing_services(billnumber,patientcode,patientname,accountname,subtotal,billdate,totalamountafterdis,grandtotal,paymentmode,locationname,locationcode)values('$billnumber','$patientcode','$patientname','$accountname','$subtotal','$billingdatetime','$totalamountafterdis','$patientbillamount','$patientpaymentmode','$locationname','$locationcode')";
	$query24=mysql_query("insert into billing_services(billnumber,patientcode,patientname,accountname,subtotal,billdate,totalamountafterdis,grandtotal,paymentmode,locationname,locationcode)values('$billnumber','$patientcode','$patientname','$accountname','$subtotal','$billingdatetime','$totalamountafterdis','$patientbillamount','$patientpaymentmode','$locationname','$locationcode')") or die(mysql_error());
	
	}
	$query29=mysql_query("update consultation_services set paymentstatus='completed' where patientvisitcode='$visitcode'");
	
	
			  $query33 = "select * from consultation_departmentreferal where patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$exec33 = mysql_query($query33) or die ("Error in Query1".mysql_error());
		$num33=mysql_num_rows($exec33);
		if($num33 != 0)
		{
		mysql_query("update master_visitentry set referalbill='completed' where visitcode='$visitcode'");
		}
		$query23 = "select * from billing_referal where billnumber = '$billnumber'";
	$exec23 = mysql_query($query23) or die ("Error in Query2".mysql_error());
	$res23 = mysql_num_rows($exec233);
	if ($res23 == 0)
	{
	
	$query24=mysql_query("insert into billing_referal(billnumber,patientcode,patientname,accountname,subtotal,billdate,totalamountafterdis,grandtotal,paymentmode,locationname,locationcode)values('$billnumber','$patientcode','$patientname','$accountname','$subtotal','$billingdatetime','$totalamountafterdis','$patientbillamount','$patientpaymentmode','$locationname','$locationcode')") or die(mysql_error());
	
	}
	$query30=mysql_query("update consultation_referal set paymentstatus='completed' where patientvisitcode='$visitcode'");
	$query301=mysql_query("update consultation_departmentreferal set paymentstatus='completed' where patientvisitcode='$visitcode'");
	
foreach($_POST['medicinename'] as $key=>$value)
		{	
		    
		    $medicinename = $_POST['medicinename'][$key];
			$medicinename = addslashes($medicinename);
			$query77="select * from master_medicine where itemname='$medicinename'";
			$exec77=mysql_query($query77);
			$res77=mysql_fetch_array($exec77);
			$medicinecode=$res77['itemcode'];
			//$rate=$res77['rateperunit'];
			$rate=$_POST['rate'][$key];
			$quantity = $_POST['quantity'][$key];
				$amount = $_POST['amount'][$key];
				
				if($dispensingkey==1 && $medicinename=='Dispensing Fee')
	{
			 $query7q="select docno from dispensingfee where 1 order by auto_number desc limit 0,1";
			$exec7q=mysql_query($query7q);
			$res7q=mysql_fetch_array($exec7q);
			$docno1=$res7q['docno'];
			$medicinecode='DISPENS';
			$rate=$amount;
		if($docno1=='')
		{
			$docno1="DSF-1";
			}
			else
			{
				 $docadd=substr($docno1,4,15);
				 $docno1=$docadd+1;
				 $docno1='DSF-'.$docno1;
				}
			
		$querydisp="insert into dispensingfee(recorddate,recordtime,patientname,visitcode,patientcode,age,gender,billtype,accountname,dispensingfee,docno,status,locationname,locationcode,ipaddress,username)values('".date('Y-m-d')."','".date('h:i:s')."','$patientname','$visitcode','$patientcode','$patientage','$patientgender','$paymentmode','$accountname','$amount','$docno1','completed','$locationname','$locationcode','$desipaddress','$desusername')";
	$exec32 = mysql_query($querydisp) or die ("Error in Querydisp".mysql_error());
		}
			
			//if ($medicinename != "" && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")
			if ($medicinename != "")// && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")
			{
		        //echo '<br>'. 
				
				if($paymentmode != 'SPLIT')
				{
					 if($cashamount > 0)
					 {
					 $query55 = "select * from financialaccount where transactionmode = 'CASH'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $cashcode = $res55['ledgercode'];
					
					 $query2 = "insert into billing_paynowpharmacy(patientcode,patientname,patientvisitcode,medicinename,quantity,rate,amount,billdate,ipaddress,accountname,paymentstatus,medicinecode,billnumber,username,pharmacycoa,locationname,locationcode,transactionmode,cashamount,cashcode,discount) 
				     values('$patientcode','$patientname','$visitcode','$medicinename','$quantity','$rate','$amount','$billdate','$ipaddress','$accountname','unpaid','$medicinecode','$billnumber','$username','$pharmacycoa','$locationname','$locationcode','CASH','$amount','$cashcode','$pharate2')";
					 $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error()); 
					
					 }
					 else if($chequeamount > 0)
					 {
					 $query55 = "select * from financialaccount where transactionmode = 'CHEQUE'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $chequecode = $res55['ledgercode'];
					 
					 $query2 = "insert into billing_paynowpharmacy(patientcode,patientname,patientvisitcode,medicinename,quantity,rate,amount,billdate,ipaddress,accountname,paymentstatus,medicinecode,billnumber,username,pharmacycoa,locationname,locationcode,transactionmode,chequeamount,bankcode,discount) 
				     values('$patientcode','$patientname','$visitcode','$medicinename','$quantity','$rate','$amount','$billdate','$ipaddress','$accountname','unpaid','$medicinecode','$billnumber','$username','$pharmacycoa','$locationname','$locationcode','CHEQUE','$amount','$chequecode','$pharate2')";
					 $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error()); 
				
					 }
					 else if($onlineamount > 0)
					 {
					 $query55 = "select * from financialaccount where transactionmode = 'ONLINE'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $chequecode = $res55['ledgercode'];
					 
					 $query2 = "insert into billing_paynowpharmacy(patientcode,patientname,patientvisitcode,medicinename,quantity,rate,amount,billdate,ipaddress,accountname,paymentstatus,medicinecode,billnumber,username,pharmacycoa,locationname,locationcode,transactionmode,onlineamount,bankcode,discount) 
				     values('$patientcode','$patientname','$visitcode','$medicinename','$quantity','$rate','$amount','$billdate','$ipaddress','$accountname','unpaid','$medicinecode','$billnumber','$username','$pharmacycoa','$locationname','$locationcode','ONLINE','$amount','$chequecode','$pharate2')";
					 $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error()); 
					 }
					 else if($creditamount > 0)
					 {
					 $query55 = "select * from financialaccount where transactionmode = 'MPESA'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $mpesacode = $res55['ledgercode'];
					 
					 $query2 = "insert into billing_paynowpharmacy(patientcode,patientname,patientvisitcode,medicinename,quantity,rate,amount,billdate,ipaddress,accountname,paymentstatus,medicinecode,billnumber,username,pharmacycoa,locationname,locationcode,transactionmode,creditamount,mpesacode,discount) 
				     values('$patientcode','$patientname','$visitcode','$medicinename','$quantity','$rate','$amount','$billdate','$ipaddress','$accountname','unpaid','$medicinecode','$billnumber','$username','$pharmacycoa','$locationname','$locationcode','MPESA','$amount','$mpesacode','$pharate2')";
					 $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error()); 
					 }
					 else if($cardamount > 0)
					 {
					 $query55 = "select * from financialaccount where transactionmode = 'CREDITCARD'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $chequecode = $res55['ledgercode'];
					 
					 $query2 = "insert into billing_paynowpharmacy(patientcode,patientname,patientvisitcode,medicinename,quantity,rate,amount,billdate,ipaddress,accountname,paymentstatus,medicinecode,billnumber,username,pharmacycoa,locationname,locationcode,transactionmode,cardamount,bankcode,discount) 
				     values('$patientcode','$patientname','$visitcode','$medicinename','$quantity','$rate','$amount','$billdate','$ipaddress','$accountname','unpaid','$medicinecode','$billnumber','$username','$pharmacycoa','$locationname','$locationcode','CREDIT CARD','$amount','$chequecode','$pharate2')";
					 $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error()); 
					 
					 }
				 }
				 else
				 {
					 $query55 = "select * from financialaccount where transactionmode = 'CASH'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $cashcode = $res55['ledgercode'];
					 
					 $query551 = "select * from financialaccount where transactionmode = 'CHEQUE'";
					 $exec551 = mysql_query($query551) or die ("Error in Query551".mysql_error());
					 $res551 = mysql_fetch_array($exec551);
					 $chequecode = $res551['ledgercode'];
					 
					 $query552 = "select * from financialaccount where transactionmode = 'MPESA'";
					 $exec552 = mysql_query($query552) or die ("Error in Query552".mysql_error());
					 $res552 = mysql_fetch_array($exec552);
					 $mpesacode = $res552['ledgercode'];
					
					$query21 = "insert into billing_paynowpharmacy(patientcode,patientname,patientvisitcode,medicinename,quantity,rate,amount,billdate,ipaddress,accountname,paymentstatus,medicinecode,billnumber,username,pharmacycoa,locationname,locationcode,transactionmode,cashamount,onlineamount,chequeamount,cardamount,creditamount,bankcode,cashcode,mpesacode,discount) 
				     values('$patientcode','$patientname','$visitcode','$medicinename','$quantity','$rate','$amount','$billdate','$ipaddress','$accountname','unpaid','$medicinecode','$billnumber','$username','$pharmacycoa','$locationname','$locationcode','SPLIT','$amount','0.00','0.00','0.00','0.00','$chequecode','$cashcode','$mpesacode','$pharate2')";
					$exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error()); 
				 } 
		       // $query2 = "insert into billing_paynowpharmacy(patientcode,patientname,patientvisitcode,medicinename,quantity,rate,amount,billdate,ipaddress,accountname,paymentstatus,medicinecode,billnumber,username,pharmacycoa,locationname,locationcode) 
				//values('$patientcode','$patientname','$visitcode','$medicinename','$quantity','$rate','$amount','$billdate','$ipaddress','$accountname','unpaid','$medicinecode','$billnumber','$username','$pharmacycoa','$locationname','$locationcode')";
				//$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			
							
			}
			
			$query54 = "update master_consultationpharm set excludebill='completed' where medicinecode='$medicinecode' and patientvisitcode='$visitcode' and excludestatus='excluded'";
			$exec54 = mysql_query($query54) or die(mysql_error());
			
			$query55 = "update master_consultationpharmissue set excludebill='completed' where medicinecode='$medicinecode' and patientvisitcode='$visitcode' and excludestatus='excluded'";
			$exec55 = mysql_query($query55) or die(mysql_error());
		}
		
		if($dispensingfee != '')
		{
				$query551 = "insert into billing_paynowpharmacy(patientcode,patientname,patientvisitcode,medicinename,quantity,rate,amount,billdate,ipaddress,accountname,paymentstatus,medicinecode,billnumber,username,pharmacycoa,locationname,locationcode) 
				values('$patientcode','$patientname','$visitcode','Dispensing Fee','1','$dispensingfee','$dispensingfee','$billdate','$ipaddress','$accountname','unpaid','dispensingfee','$billnumber','$username','$pharmacycoa','$locationname','$locationcode')";
				//$exec551 = mysql_query($query551) or die ("Error in Query551".mysql_error());
				
				$query552 = "update dispensingfee set status='completed' where docno='$dispensingdocno'";
				$exec552 = mysql_query($query552) or die(mysql_error());
			
		}
		foreach($_POST['lab'] as $key=>$value)
		{
				    //echo '<br>'.$k;

		$labname=$_POST['lab'][$key];
		$labquery=mysql_query("select * from master_lab where itemname='$labname'");
		$execlab=mysql_fetch_array($labquery);
		$labcode=$execlab['itemcode'];
		$labrate=$_POST['rate5'][$key];
		$copaylab=$_POST['copaylab'][$key];
		
		if($labname!="")
		{	
			if($paymentmode != 'SPLIT')
				{
					 if($cashamount > 0)
					 {
					 $query55 = "select * from financialaccount where transactionmode = 'CASH'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $cashcode = $res55['ledgercode'];
					 
					 $labquery1=mysql_query("insert into billing_paynowlab(patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,accountname,billdate,paymentstatus,billnumber,username,labcoa,locationname,locationcode,transactionmode,cashamount,cashcode,copayamount)values('$patientcode','$patientname','$visitcode','$labcode','$labname','$labrate','$accountname','$billdate','unpaid','$billnumber','$username','$labcoa','$locationname','$locationcode','CASH','$labrate','$cashcode','$copaylab')") or die(mysql_error());
					
					 }
					 else if($chequeamount > 0)
					 {
					 $query55 = "select * from financialaccount where transactionmode = 'CHEQUE'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $chequecode = $res55['ledgercode'];
					 
					 $labquery1=mysql_query("insert into billing_paynowlab(patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,accountname,billdate,paymentstatus,billnumber,username,labcoa,locationname,locationcode,transactionmode,chequeamount,bankcode,copayamount)values('$patientcode','$patientname','$visitcode','$labcode','$labname','$labrate','$accountname','$billdate','unpaid','$billnumber','$username','$labcoa','$locationname','$locationcode','CHEQUE','$labrate','$chequecode','$copaylab')") or die(mysql_error());
									
					 }
					 else if($onlineamount > 0)
					 {
					 $query55 = "select * from financialaccount where transactionmode = 'ONLINE'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $chequecode = $res55['ledgercode'];
					 
					 $labquery1=mysql_query("insert into billing_paynowlab(patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,accountname,billdate,paymentstatus,billnumber,username,labcoa,locationname,locationcode,transactionmode,onlineamount,bankcode,copayamount)values('$patientcode','$patientname','$visitcode','$labcode','$labname','$labrate','$accountname','$billdate','unpaid','$billnumber','$username','$labcoa','$locationname','$locationcode','ONLINE','$labrate','$chequecode','$copaylab')") or die(mysql_error());
					
					 }
					 else if($creditamount > 0)
					 {
					 $query55 = "select * from financialaccount where transactionmode = 'MPESA'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $mpesacode = $res55['ledgercode'];
					 
					 $labquery1=mysql_query("insert into billing_paynowlab(patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,accountname,billdate,paymentstatus,billnumber,username,labcoa,locationname,locationcode,transactionmode,creditamount,mpesacode,copayamount)values('$patientcode','$patientname','$visitcode','$labcode','$labname','$labrate','$accountname','$billdate','unpaid','$billnumber','$username','$labcoa','$locationname','$locationcode','MPESA','$labrate','$mpesacode','$copaylab')") or die(mysql_error());
					
					 }
					 else if($cardamount > 0)
					 {
					 $query55 = "select * from financialaccount where transactionmode = 'CREDITCARD'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $chequecode = $res55['ledgercode'];
					 
					 $labquery1=mysql_query("insert into billing_paynowlab(patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,accountname,billdate,paymentstatus,billnumber,username,labcoa,locationname,locationcode,transactionmode,cardamount,bankcode,copayamount)values('$patientcode','$patientname','$visitcode','$labcode','$labname','$labrate','$accountname','$billdate','unpaid','$billnumber','$username','$labcoa','$locationname','$locationcode','CREDIT CARD','$labrate','$chequecode','$copaylab')") or die(mysql_error());
										 
					 }
				 }
				 else
				 {
					 $query55 = "select * from financialaccount where transactionmode = 'CASH'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $cashcode = $res55['ledgercode'];
					 
					 $query551 = "select * from financialaccount where transactionmode = 'CHEQUE'";
					 $exec551 = mysql_query($query551) or die ("Error in Query551".mysql_error());
					 $res551 = mysql_fetch_array($exec551);
					 $chequecode = $res551['ledgercode'];
					 
					 $query552 = "select * from financialaccount where transactionmode = 'MPESA'";
					 $exec552 = mysql_query($query552) or die ("Error in Query552".mysql_error());
					 $res552 = mysql_fetch_array($exec552);
					 $mpesacode = $res552['ledgercode'];
					
					$labquery124 =mysql_query("insert into billing_paynowlab(patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,accountname,billdate,paymentstatus,billnumber,username,labcoa,locationname,locationcode,transactionmode,cashamount,onlineamount,chequeamount,cardamount,creditamount,bankcode,cashcode,mpesacode,copayamount)values('$patientcode','$patientname','$visitcode','$labcode','$labname','$labrate','$accountname','$billdate','unpaid','$billnumber','$username','$labcoa','$locationname','$locationcode','SPLIT','$labrate','0.00','0.00','0.00','0.00','$chequecode','$cashcode','$mpesacode','$copaylab')") or die(mysql_error());
						
				 }
		//$labquery1=mysql_query("insert into billing_paynowlab(patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,accountname,billdate,paymentstatus,billnumber,username,labcoa,locationname,locationcode,copayamount)values('$patientcode','$patientname','$visitcode','$labcode','$labname','$labrate','$accountname','$billdate','unpaid','$billnumber','$username','$labcoa','$locationname','$locationcode','".$copaylab."')") or die(mysql_error());
			}
		}
		
		foreach($_POST['radiology'] as $key=>$value){	
			//echo '<br>'.
		
		$pairs= $_POST['radiology'][$key];
		$pairvar= $pairs;
	    $pairs1= $_POST['rate8'][$key];
		$pairvar1= $pairs1;
		
		$radiologyquery=mysql_query("select * from master_radiology where itemname='$pairvar'");
		$execradiology=mysql_fetch_array($radiologyquery);
		$radiologycode=$execradiology['itemcode'];
		$copayrad=$_POST['copayrad'][$key];
		
		
		if($pairvar!="")
		{
			if($paymentmode != 'SPLIT')
				{
					 if($cashamount > 0)
					 {
					 $query55 = "select * from financialaccount where transactionmode = 'CASH'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $cashcode = $res55['ledgercode'];
					 
					 $radiologyquery1=mysql_query("insert into billing_paynowradiology(patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,accountname,billdate,paymentstatus,billnumber,username,radiologycoa,locationname,locationcode,transactionmode,cashamount,cashcode,copayamount)values('$patientcode','$patientname','$visitcode','$radiologycode','$pairs','$pairs1','$accountname','$billdate','unpaid','$billnumber','$username','$radiologycoa','$locationname','$locationcode','CASH','$pairs1','$cashcode','$copayrad')") or die(mysql_error());
					
					 }
					 else if($chequeamount > 0)
					 {
					 $query55 = "select * from financialaccount where transactionmode = 'CHEQUE'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $chequecode = $res55['ledgercode'];
					 
					 $radiologyquery1=mysql_query("insert into billing_paynowradiology(patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,accountname,billdate,paymentstatus,billnumber,username,radiologycoa,locationname,locationcode,transactionmode,chequeamount,bankcode,copayamount)values('$patientcode','$patientname','$visitcode','$radiologycode','$pairs','$pairs1','$accountname','$billdate','unpaid','$billnumber','$username','$radiologycoa','$locationname','$locationcode','CHEQUE','$pairs1','$chequecode','$copayrad')") or die(mysql_error());
														
					 }
					 else if($onlineamount > 0)
					 {
					 $query55 = "select * from financialaccount where transactionmode = 'ONLINE'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $chequecode = $res55['ledgercode'];
					 
					 $radiologyquery1=mysql_query("insert into billing_paynowradiology(patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,accountname,billdate,paymentstatus,billnumber,username,radiologycoa,locationname,locationcode,transactionmode,onlineamount,bankcode,copayamount)values('$patientcode','$patientname','$visitcode','$radiologycode','$pairs','$pairs1','$accountname','$billdate','unpaid','$billnumber','$username','$radiologycoa','$locationname','$locationcode','ONLINE','$pairs1','$chequecode','$copayrad')") or die(mysql_error());
					
					 }
					 else if($creditamount > 0)
					 {
					 $query55 = "select * from financialaccount where transactionmode = 'MPESA'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $mpesacode = $res55['ledgercode'];
					 
					 $radiologyquery1=mysql_query("insert into billing_paynowradiology(patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,accountname,billdate,paymentstatus,billnumber,username,radiologycoa,locationname,locationcode,transactionmode,creditamount,mpesacode,copayamount)values('$patientcode','$patientname','$visitcode','$radiologycode','$pairs','$pairs1','$accountname','$billdate','unpaid','$billnumber','$username','$radiologycoa','$locationname','$locationcode','MPESA','$pairs1','$mpesacode','$copayrad')") or die(mysql_error());
										
					 }
					 else if($cardamount > 0)
					 {
					 $query55 = "select * from financialaccount where transactionmode = 'CREDITCARD'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $chequecode = $res55['ledgercode'];
					 
					 $radiologyquery1=mysql_query("insert into billing_paynowradiology(patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,accountname,billdate,paymentstatus,billnumber,username,radiologycoa,locationname,locationcode,transactionmode,cardamount,bankcode,copayamount)values('$patientcode','$patientname','$visitcode','$radiologycode','$pairs','$pairs1','$accountname','$billdate','unpaid','$billnumber','$username','$radiologycoa','$locationname','$locationcode','CREDIT CARD','$pairs1','$chequecode','$copayrad')") or die(mysql_error());
															 
					 }
				 }
				 else
				 {
					 $query55 = "select * from financialaccount where transactionmode = 'CASH'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $cashcode = $res55['ledgercode'];
					 
					 $query551 = "select * from financialaccount where transactionmode = 'CHEQUE'";
					 $exec551 = mysql_query($query551) or die ("Error in Query551".mysql_error());
					 $res551 = mysql_fetch_array($exec551);
					 $chequecode = $res551['ledgercode'];
					 
					 $query552 = "select * from financialaccount where transactionmode = 'MPESA'";
					 $exec552 = mysql_query($query552) or die ("Error in Query552".mysql_error());
					 $res552 = mysql_fetch_array($exec552);
					 $mpesacode = $res552['ledgercode'];
					
					$radiologyquery1=mysql_query("insert into billing_paynowradiology(patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,accountname,billdate,paymentstatus,billnumber,username,radiologycoa,locationname,locationcode,transactionmode,cashamount,onlineamount,chequeamount,cardamount,creditamount,bankcode,cashcode,mpesacode,copayamount)values('$patientcode','$patientname','$visitcode','$radiologycode','$pairs','$pairs1','$accountname','$billdate','unpaid','$billnumber','$username','$radiologycoa','$locationname','$locationcode','SPLIT','$pairs1','0.00','0.00','0.00','0.00','$chequecode','$cashcode','$mpesacode','$copayrad')") or die(mysql_error());
											
				 }
		//$radiologyquery1=mysql_query("insert into billing_paynowradiology(patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,accountname,billdate,paymentstatus,billnumber,username,radiologycoa,locationname,locationcode,copayamount)values('$patientcode','$patientname','$visitcode','$radiologycode','$pairs','$pairs1','$accountname','$billdate','unpaid','$billnumber','$username','$radiologycoa','$locationname','$locationcode','".$copayrad."')") or die(mysql_error());
		}
		}
		
		foreach($_POST['services'] as $key => $value)
		{
				    //echo '<br>'.$k;

		$servicesname=$_POST["services"][$key];
		$servicequery=mysql_query("select * from master_services where itemname='$servicesname'");
		$execservice=mysql_fetch_array($servicequery);
		$servicescode=$execservice['itemcode'];
		
		$servicesrate=$_POST["rate3"][$key];
		$quantityser=$_POST['quantityser'][$key];
		$seramount=$_POST['seramount'][$key];
		$copayser=$_POST['copayser'][$key];
		/*for($se=1;$se<=$quantityser;$se++)
		{	*/
		if($servicesname!="")
		{	
			if($paymentmode != 'SPLIT')
				{
					 if($cashamount > 0)
					 {
					 $query55 = "select * from financialaccount where transactionmode = 'CASH'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $cashcode = $res55['ledgercode'];
					 
					 $servicesquery1=mysql_query("insert into billing_paynowservices(patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,accountname,billdate,paymentstatus,billnumber,username,servicecoa,locationname,locationcode,serviceqty,amount,transactionmode,cashamount,cashcode,copayamount)values('$patientcode','$patientname','$visitcode','$servicescode','$servicesname','$servicesrate','$accountname','$billdate','unpaid','$billnumber','$username','$servicecoa','$locationname','$locationcode','".$quantityser."','".$seramount."','CASH','$servicesrate','$cashcode','$copayser')") or die(mysql_error());
					
					 }
					 else if($chequeamount > 0)
					 {
					 $query55 = "select * from financialaccount where transactionmode = 'CHEQUE'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $chequecode = $res55['ledgercode'];
					 
					 $servicesquery1=mysql_query("insert into billing_paynowservices(patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,accountname,billdate,paymentstatus,billnumber,username,servicecoa,locationname,locationcode,serviceqty,amount,transactionmode,chequeamount,bankcode,copayamount)values('$patientcode','$patientname','$visitcode','$servicescode','$servicesname','$servicesrate','$accountname','$billdate','unpaid','$billnumber','$username','$servicecoa','$locationname','$locationcode','".$quantityser."','".$seramount."','CHEQUE','$servicesrate','$chequecode','$copayser')") or die(mysql_error());
					
					 }
					 else if($onlineamount > 0)
					 {
					 $query55 = "select * from financialaccount where transactionmode = 'ONLINE'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $chequecode = $res55['ledgercode'];
					 
					 $servicesquery1=mysql_query("insert into billing_paynowservices(patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,accountname,billdate,paymentstatus,billnumber,username,servicecoa,locationname,locationcode,serviceqty,amount,transactionmode,onlineamount,bankcode,copayamount)values('$patientcode','$patientname','$visitcode','$servicescode','$servicesname','$servicesrate','$accountname','$billdate','unpaid','$billnumber','$username','$servicecoa','$locationname','$locationcode','".$quantityser."','".$seramount."','ONLINE','$servicesrate','$chequecode','$copayser')") or die(mysql_error());
										
					 }
					 else if($creditamount > 0)
					 {
					 $query55 = "select * from financialaccount where transactionmode = 'MPESA'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $mpesacode = $res55['ledgercode'];
					 
					 $servicesquery1=mysql_query("insert into billing_paynowservices(patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,accountname,billdate,paymentstatus,billnumber,username,servicecoa,locationname,locationcode,serviceqty,amount,transactionmode,creditamount,mpesacode,copayamount)values('$patientcode','$patientname','$visitcode','$servicescode','$servicesname','$servicesrate','$accountname','$billdate','unpaid','$billnumber','$username','$servicecoa','$locationname','$locationcode','".$quantityser."','".$seramount."','MPESA','$servicesrate','$mpesacode','$copayser')") or die(mysql_error());
					
					 }
					 else if($cardamount > 0)
					 {
					 $query55 = "select * from financialaccount where transactionmode = 'CREDITCARD'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $chequecode = $res55['ledgercode'];
					 
					 $servicesquery1=mysql_query("insert into billing_paynowservices(patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,accountname,billdate,paymentstatus,billnumber,username,servicecoa,locationname,locationcode,serviceqty,amount,transactionmode,cardamount,bankcode,copayamount)values('$patientcode','$patientname','$visitcode','$servicescode','$servicesname','$servicesrate','$accountname','$billdate','unpaid','$billnumber','$username','$servicecoa','$locationname','$locationcode','".$quantityser."','".$seramount."','CREDIT CARD','$servicesrate','$chequecode','$copayser')") or die(mysql_error());
															 
					 }
				 }
				 else
				 {
					 $query55 = "select * from financialaccount where transactionmode = 'CASH'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $cashcode = $res55['ledgercode'];
					 
					 $query551 = "select * from financialaccount where transactionmode = 'CHEQUE'";
					 $exec551 = mysql_query($query551) or die ("Error in Query551".mysql_error());
					 $res551 = mysql_fetch_array($exec551);
					 $chequecode = $res551['ledgercode'];
					 
					 $query552 = "select * from financialaccount where transactionmode = 'MPESA'";
					 $exec552 = mysql_query($query552) or die ("Error in Query552".mysql_error());
					 $res552 = mysql_fetch_array($exec552);
					 $mpesacode = $res552['ledgercode'];
					
					$servicesquery1=mysql_query("insert into billing_paynowservices(patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,accountname,billdate,paymentstatus,billnumber,username,servicecoa,locationname,locationcode,serviceqty,amount,transactionmode,cashamount,onlineamount,chequeamount,cardamount,creditamount,bankcode,cashcode,mpesacode,copayamount)values('$patientcode','$patientname','$visitcode','$servicescode','$servicesname','$servicesrate','$accountname','$billdate','unpaid','$billnumber','$username','$servicecoa','$locationname','$locationcode','".$quantityser."','".$seramount."','SPLIT','$servicesrate','0.00','0.00','0.00','0.00','$chequecode','$cashcode','$mpesacode','$copayser')") or die(mysql_error());											
				 }
		//$servicesquery1=mysql_query("insert into billing_paynowservices(patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,accountname,billdate,paymentstatus,billnumber,username,servicecoa,locationname,locationcode,serviceqty,amount,copayamount)values('$patientcode','$patientname','$visitcode','$servicescode','$servicesname','$servicesrate','$accountname','$billdate','unpaid','$billnumber','$username','$servicecoa','$locationname','$locationcode','".$quantityser."','".$seramount."','".$copayser."')") or die(mysql_error());
		}
		/*}*/
		}
		
		foreach($_POST['departmentreferal'] as $key=>$value)
		{
		$pairs21= $_POST['departmentreferal'][$key];
		$pairvar21= $pairs21;
	    $pairs31= $_POST['departmentreferalrate4'][$key];
		$pairvar31= 0;
		
		$referalquery1=mysql_query("select * from master_department where department ='$pairvar21'");
		$execreferal1=mysql_fetch_array($referalquery1);
		$referalcode1=$execreferal1['auto_number'];
		
		
		
		//echo $pairs2;
		if($pairvar21!="")
		{
			if($paymentmode != 'SPLIT')
				{
					 if($cashamount > 0)
					 {
					 $query55 = "select * from financialaccount where transactionmode = 'CASH'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $cashcode = $res55['ledgercode'];
					 
					 $referalquery1=mysql_query("insert into billing_paynowreferal(patientcode,patientname,patientvisitcode,referalcode,referalname,referalrate,accountname,billdate,paymentstatus,billnumber,username,referalcoa,locationname,locationcode,transactionmode,cashamount,cashcode)values('$patientcode','$patientname','$visitcode','$referalcode1','$pairvar21','$pairvar31','$accountname','$billdate','unpaid','$billnumber','$username','$referalcoa','$locationname','$locationcode','CASH','$pairvar31','$cashcode')") or die(mysql_error());
					
					 }
					 else if($chequeamount > 0)
					 {
					 $query55 = "select * from financialaccount where transactionmode = 'CHEQUE'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $chequecode = $res55['ledgercode'];
					 
					 $referalquery1=mysql_query("insert into billing_paynowreferal(patientcode,patientname,patientvisitcode,referalcode,referalname,referalrate,accountname,billdate,paymentstatus,billnumber,username,referalcoa,locationname,locationcode,transactionmode,chequeamount,bankcode)values('$patientcode','$patientname','$visitcode','$referalcode1','$pairvar21','$pairvar31','$accountname','$billdate','unpaid','$billnumber','$username','$referalcoa','$locationname','$locationcode','CHEQUE','$pairvar31','$chequecode')") or die(mysql_error());
					
					 }
					 else if($onlineamount > 0)
					 {
					 $query55 = "select * from financialaccount where transactionmode = 'ONLINE'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $chequecode = $res55['ledgercode'];
					 
					 $referalquery1=mysql_query("insert into billing_paynowreferal(patientcode,patientname,patientvisitcode,referalcode,referalname,referalrate,accountname,billdate,paymentstatus,billnumber,username,referalcoa,locationname,locationcode,transactionmode,onlineamount,bankcode)values('$patientcode','$patientname','$visitcode','$referalcode1','$pairvar21','$pairvar31','$accountname','$billdate','unpaid','$billnumber','$username','$referalcoa','$locationname','$locationcode','ONLINE','$pairvar31','$chequecode')") or die(mysql_error());
										
					 }
					 else if($creditamount > 0)
					 {
					 $query55 = "select * from financialaccount where transactionmode = 'MPESA'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $mpesacode = $res55['ledgercode'];
					 
					 $referalquery1=mysql_query("insert into billing_paynowreferal(patientcode,patientname,patientvisitcode,referalcode,referalname,referalrate,accountname,billdate,paymentstatus,billnumber,username,referalcoa,locationname,locationcode,transactionmode,creditamount,mpesacode)values('$patientcode','$patientname','$visitcode','$referalcode1','$pairvar21','$pairvar31','$accountname','$billdate','unpaid','$billnumber','$username','$referalcoa','$locationname','$locationcode','MPESA','$pairvar31','$mpesacode')") or die(mysql_error());
					
					 }
					 else if($cardamount > 0)
					 {
					 $query55 = "select * from financialaccount where transactionmode = 'CREDITCARD'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $chequecode = $res55['ledgercode'];
					 
					 $referalquery1=mysql_query("insert into billing_paynowreferal(patientcode,patientname,patientvisitcode,referalcode,referalname,referalrate,accountname,billdate,paymentstatus,billnumber,username,referalcoa,locationname,locationcode,transactionmode,cardamount,bankcode)values('$patientcode','$patientname','$visitcode','$referalcode1','$pairvar21','$pairvar31','$accountname','$billdate','unpaid','$billnumber','$username','$referalcoa','$locationname','$locationcode','CREDIT CARD','$pairvar31','$chequecode')") or die(mysql_error());
															 
					 }
				 }
				 else
				 {
					 $query55 = "select * from financialaccount where transactionmode = 'CASH'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $cashcode = $res55['ledgercode'];
					 
					 $query551 = "select * from financialaccount where transactionmode = 'CHEQUE'";
					 $exec551 = mysql_query($query551) or die ("Error in Query551".mysql_error());
					 $res551 = mysql_fetch_array($exec551);
					 $chequecode = $res551['ledgercode'];
					 
					 $query552 = "select * from financialaccount where transactionmode = 'MPESA'";
					 $exec552 = mysql_query($query552) or die ("Error in Query552".mysql_error());
					 $res552 = mysql_fetch_array($exec552);
					 $mpesacode = $res552['ledgercode'];
					 
					 $referalquery122=mysql_query("insert into billing_paynowreferal(patientcode,patientname,patientvisitcode,referalcode,referalname,referalrate,accountname,billdate,paymentstatus,billnumber,username,referalcoa,locationname,locationcode,transactionmode,cashamount,onlineamount,chequeamount,cardamount,creditamount,bankcode,cashcode,mpesacode)values('$patientcode','$patientname','$visitcode','$referalcode1','$pairvar21','$pairvar31','$accountname','$billdate','unpaid','$billnumber','$username','$referalcoa','$locationname','$locationcode','SPLIT','$pairvar31','0.00','0.00','0.00','0.00','$chequecode','$cashcode','$mpesacode')") or die(mysql_error());
				 }
		//$referalquery1=mysql_query("insert into billing_paynowreferal(patientcode,patientname,patientvisitcode,referalcode,referalname,referalrate,accountname,billdate,paymentstatus,billnumber,username,referalcoa,locationname,locationcode)values('$patientcode','$patientname','$visitcode','$referalcode1','$pairvar21','$pairvar31','$accountname','$billdate','unpaid','$billnumber','$username','$referalcoa','$locationname','$locationcode')") or die(mysql_error());
		
		}
		}
		
		foreach($_POST['referal'] as $key=>$value)
		{
		$pairs2= $_POST['referal'][$key];
		$pairvar2= $pairs2;
	    $pairs3= $_POST['refrate4'][$key];
		$pairvar3= $pairs3;
		
		$referalquery=mysql_query("select * from master_doctor where doctorname='$pairvar2'");
		$execreferal=mysql_fetch_array($referalquery);
		$referalcode=$execreferal['doctorcode'];
		$copayref=$_POST['copayref'][$key];
		//echo $pairs2;
		if($pairvar2!="")
		{
			if($paymentmode != 'SPLIT')
				{
					 if($cashamount > 0)
					 {
					 $query55 = "select * from financialaccount where transactionmode = 'CASH'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $cashcode = $res55['ledgercode'];
					 
					 $referalquery2=mysql_query("insert into billing_paynowreferal(patientcode,patientname,patientvisitcode,referalcode,referalname,referalrate,accountname,billdate,paymentstatus,billnumber,username,referalcoa,locationname,locationcode,transactionmode,cashamount,cashcode,copayamount)values('$patientcode','$patientname','$visitcode','$referalcode','$pairvar2','$pairvar3','$accountname','$billdate','unpaid','$billnumber','$username','$referalcoa','$locationname','$locationcode','CASH','$pairvar3','$cashcode','$copayref')") or die(mysql_error());
					
					 }
					 else if($chequeamount > 0)
					 {
					 $query55 = "select * from financialaccount where transactionmode = 'CHEQUE'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $chequecode = $res55['ledgercode'];
					 
					 $referalquery2=mysql_query("insert into billing_paynowreferal(patientcode,patientname,patientvisitcode,referalcode,referalname,referalrate,accountname,billdate,paymentstatus,billnumber,username,referalcoa,locationname,locationcode,transactionmode,chequeamount,bankcode,copayamount)values('$patientcode','$patientname','$visitcode','$referalcode','$pairvar2','$pairvar3','$accountname','$billdate','unpaid','$billnumber','$username','$referalcoa','$locationname','$locationcode','CHEQUE','$pairvar3','$chequecode','$copayref')") or die(mysql_error());
					
					 }
					 else if($onlineamount > 0)
					 {
					 $query55 = "select * from financialaccount where transactionmode = 'ONLINE'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $chequecode = $res55['ledgercode'];
					 
					 $referalquery2=mysql_query("insert into billing_paynowreferal(patientcode,patientname,patientvisitcode,referalcode,referalname,referalrate,accountname,billdate,paymentstatus,billnumber,username,referalcoa,locationname,locationcode,transactionmode,onlineamount,bankcode,copayamount)values('$patientcode','$patientname','$visitcode','$referalcode','$pairvar2','$pairvar3','$accountname','$billdate','unpaid','$billnumber','$username','$referalcoa','$locationname','$locationcode','ONLINE','$pairvar3','$chequecode','$copayref')") or die(mysql_error());
					
					 }
					 else if($creditamount > 0)
					 {
					 $query55 = "select * from financialaccount where transactionmode = 'MPESA'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $mpesacode = $res55['ledgercode'];
					 
					 $referalquery2=mysql_query("insert into billing_paynowreferal(patientcode,patientname,patientvisitcode,referalcode,referalname,referalrate,accountname,billdate,paymentstatus,billnumber,username,referalcoa,locationname,locationcode,transactionmode,creditamount,mpesacode,copayamount)values('$patientcode','$patientname','$visitcode','$referalcode','$pairvar2','$pairvar3','$accountname','$billdate','unpaid','$billnumber','$username','$referalcoa','$locationname','$locationcode','MPESA','$pairvar3','$mpesacode','$copayref')") or die(mysql_error());
					
					 }
					 else if($cardamount > 0)
					 {
					 $query55 = "select * from financialaccount where transactionmode = 'CREDITCARD'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $chequecode = $res55['ledgercode'];
					 
					 $referalquery2=mysql_query("insert into billing_paynowreferal(patientcode,patientname,patientvisitcode,referalcode,referalname,referalrate,accountname,billdate,paymentstatus,billnumber,username,referalcoa,locationname,locationcode,transactionmode,cardamount,bankcode,copayamount)values('$patientcode','$patientname','$visitcode','$referalcode','$pairvar2','$pairvar3','$accountname','$billdate','unpaid','$billnumber','$username','$referalcoa','$locationname','$locationcode','CREDIT CARD','$pairvar3','$chequecode','$copayref')") or die(mysql_error());
															 
					 }
				 }
				 else
				 {
					 $query55 = "select * from financialaccount where transactionmode = 'CASH'";
					 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
					 $res55 = mysql_fetch_array($exec55);
					 $cashcode = $res55['ledgercode'];
					 
					 $query551 = "select * from financialaccount where transactionmode = 'CHEQUE'";
					 $exec551 = mysql_query($query551) or die ("Error in Query551".mysql_error());
					 $res551 = mysql_fetch_array($exec551);
					 $chequecode = $res551['ledgercode'];
					 
					 $query552 = "select * from financialaccount where transactionmode = 'MPESA'";
					 $exec552 = mysql_query($query552) or die ("Error in Query552".mysql_error());
					 $res552 = mysql_fetch_array($exec552);
					 $mpesacode = $res552['ledgercode'];
					 
					 $referalquery122=mysql_query("insert into billing_paynowreferal(patientcode,patientname,patientvisitcode,referalcode,referalname,referalrate,accountname,billdate,paymentstatus,billnumber,username,referalcoa,locationname,locationcode,transactionmode,cashamount,onlineamount,chequeamount,cardamount,creditamount,bankcode,cashcode,mpesacode,copayamount)values('$patientcode','$patientname','$visitcode','$referalcode1','$pairvar21','$pairvar31','$accountname','$billdate','unpaid','$billnumber','$username','$referalcoa','$locationname','$locationcode','SPLIT','$pairvar3','0.00','0.00','0.00','0.00','$chequecode','$cashcode','$mpesacode','$copayref')") or die(mysql_error());
				 }
		//$referalquery1=mysql_query("insert into billing_paynowreferal(patientcode,patientname,patientvisitcode,referalcode,referalname,referalrate,accountname,billdate,paymentstatus,billnumber,username,referalcoa,locationname,locationcode,copayamount)values('$patientcode','$patientname','$visitcode','$referalcode','$pairvar2','$pairvar3','$accountname','$billdate','unpaid','$billnumber','$username','$referalcoa','$locationname','$locationcode','".$copayref."')") or die(mysql_error());
		
		}
		}
	if($referalcode == '')
		{
		$debitcoa = '';
		}
		
	mysql_query("insert into billing_paynow(billno,patientname,patientcode,visitcode,totalamount,billdate,accountname,referalname,doctorstatus,billstatus,username,subtype,consultationid,creditcoa,debitcoa,locationname,locationcode)values('$billnumber','$patientname','$patientcode','$visitcode','$totalamount','$billdate','$accountname','$referalname','unpaid','paid','$username','$subtype','$consultationid','$referalcode','$debitcoa','$locationname','$locationcode')") or die(mysql_error());
	if($patientpaymenttype == 'PAY NOW')
	{
		mysql_query("update master_visitentry set overallpayment='completed' where visitcode='$visitcode'") or die(mysql_error());
	mysql_query("update master_triage set overallpayment='completed' where visitcode='$visitcode'") or die(mysql_error());
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
	    //$billnumber= $_REQUEST['billno'];
		
		$query55 = "select * from financialaccount where transactionmode = 'CASH'";
		 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
		 $res55 = mysql_fetch_array($exec55);
		 $cashcode = $res55['ledgercode']; 
		
		$query9 = "insert into master_transactionpaynow (transactiondate, transactiontime, particulars, patientcode,patientname,  visitcode, paymenttype, subtype,  
	    accountname, transactionmode, transactiontype, transactionmodule, transactionamount, cashamount, balanceamount, billnumber, billanum, remarks, ipaddress, updatedate, companyanum,
		companyname, financialyear, doctorname, billstatus, username, cashgiventocustomer, cashgivenbycustomer,locationname,locationcode,cashcode)

		values ('$billdate', '$timeonly', '$particulars', '$patientcode', '$patientname', '$visitcode', '$paymenttype', '$subtype', '$accountname', '$transactionmode', '$transactiontype',
	    '$transactionmodule', '$totalamount', '$totalamount', '$balanceamount', '$billnumber', '$billanum', '$remarks', '$ipaddress', '$updatedate', '$companyanum', '$companyname' ,  
        '$financialyear', '$doctorname', 'paid', '$username', '$cashgiventocustomer','$cashgivenbycustomer','$locationname','$locationcode','$cashcode')";
		
		
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		
		$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,cash,cashcoa,source,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accountname','$billnumber','$billdate','$ipaddress','$username','$totalamount','$cashcoa','billingpaynow','$locationname','$locationcode')";
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
		 	
		$query9 = "insert into master_transactionpaynow (transactiondate, particulars,
		transactionmode, transactiontype, transactionamount, onlineamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,financialyear,username,paymenttype,subtype,transactiontime,cashgiventocustomer,cashgivenbycustomer,onlinenumber,locationname,locationcode,bankcode) 
		values ('$billdate','$particulars', 
		'$transactionmode', '$transactiontype', '$totalamount', '$totalamount', 
		'$billnumber',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule','$patientname','$patientcode','$visitcode','$accountname','$doctorname','paid','$financialyear','$username','$paymenttype','$subtype','$timeonly','$cashgiventocustomer','$cashgivenbycustomer','$onlinenumber','$locationname','$locationcode','$bankcode')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		
		$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,online,onlinecoa,source,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accountname','$billnumber','$billdate','$ipaddress','$username','$totalamount','$onlinecoa','billingpaynow','$locationname','$locationcode')";
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
		 	
			$query9 = "insert into master_transactionpaynow (transactiondate, particulars,
		transactionmode, transactiontype, transactionamount,
		chequeamount,chequenumber, billnumber, billanum, 
		chequedate, bankname, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,financialyear,username,paymenttype,subtype,transactiontime,cashgiventocustomer,cashgivenbycustomer,locationname,locationcode,bankcode) 
		values ('$billdate', '$particulars', 
		'$transactionmode', '$transactiontype', '$totalamount',
		'$totalamount','$chequenumber',  '$billnumber',  '$billanum', 
		'$chequedate', '$bankname', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', 
		'$remarks', '$transactionmodule','$patientname','$patientcode','$visitcode','$accountname','$doctorname','paid','$financialyear','$username','$paymenttype','$subtype','$timeonly','$cashgiventocustomer','$cashgivenbycustomer','$locationname','$locationcode','$bankcode')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		
		$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,cheque,chequecoa,source,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accountname','$billnumber','$billdate','$ipaddress','$username','$totalamount','$chequecoa','billingpaynow','$locationname','$locationcode')";
        $exec37 = mysql_query($query37) or die(mysql_error());
	
	}
	
	if($paymentmode == 'CREDIT CARD')
	{
	$transactiontype = 'PAYMENT';
		$transactionmode = 'CREDIT CARD';
		$particulars = 'BY CREDIT CARD '.$billnumberprefix.$billnumber;	
		
		$query55 = "select * from financialaccount where transactionmode = 'CREDITCARD'";
		 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
		 $res55 = mysql_fetch_array($exec55);
		 $bankcode = $res55['ledgercode']; 
		 	
			$query9 = "insert into master_transactionpaynow (transactiondate, particulars,
		transactionmode, transactiontype, transactionamount,
		cardamount, billnumber, billanum, 
		chequedate, bankname, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,financialyear,username,creditcardname,creditcardnumber,creditcardbankname,paymenttype,subtype,transactiontime,cashgiventocustomer,cashgivenbycustomer,locationname,locationcode,bankcode) 
		values ('$billdate', '$particulars', 
		'$transactionmode', '$transactiontype', '$totalamount',
		'$totalamount','$billnumber',  '$billanum', 
		'$chequedate', '$bankname', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', 
		'$remarks', '$transactionmodule','$patientname','$patientcode','$visitcode','$accountname','$doctorname','paid','$financialyear','$username','$card','$cardnumber','$bankname1','$paymenttype','$subtype','$timeonly','$cashgiventocustomer','$cashgivenbycustomer','$locationname','$locationcode','$bankcode')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		
		$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,card,cardcoa,source,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accountname','$billnumber','$billdate','$ipaddress','$username','$totalamount','$cardcoa','billingpaynow','$locationname','$locationcode')";
        $exec37 = mysql_query($query37) or die(mysql_error());
	
	}
	
		if ($paymentmode == 'SPLIT')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'SPLIT ';
		$particulars = 'BY SPLIT'.$billnumberprefix.$billnumber.'';
		
		$query55 = "select * from financialaccount where transactionmode = 'CASH'";
		 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
		 $res55 = mysql_fetch_array($exec55);
		 $cashcode = $res55['ledgercode'];
		 
		 $query551 = "select * from financialaccount where transactionmode = 'CHEQUE'";
		 $exec551 = mysql_query($query551) or die ("Error in Query551".mysql_error());
		 $res551 = mysql_fetch_array($exec551);
		 $bankcode = $res551['ledgercode'];
		 
		 $query552 = "select * from financialaccount where transactionmode = 'MPESA'";
		 $exec552 = mysql_query($query552) or die ("Error in Query552".mysql_error());
		 $res552 = mysql_fetch_array($exec552);
		 $mpesacode = $res552['ledgercode'];	
	
		$query9 = "insert into master_transactionpaynow (transactiondate, particulars,
		transactionmode, transactiontype, transactionamount,
		cardamount, billnumber, billanum, 
		chequedate, bankname, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,financialyear,username,creditcardname,creditcardnumber,creditcardbankname,paymenttype,subtype,transactiontime,cashgiventocustomer,cashgivenbycustomer,cashamount,onlineamount,chequeamount,chequenumber,creditamount,onlinenumber,mpesanumber,locationname,locationcode,cashcode, bankcode, mpesacode) 
		values ('$billdate', '$particulars', 
		'$transactionmode', '$transactiontype', '$totalamount',
		'$cardamount','$billnumber',  '$billanum', 
		'$chequedate', '$bankname', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', 
		'$remarks', '$transactionmodule','$patientname','$patientcode','$visitcode','$accountname','$doctorname','paid','$financialyear','$username','$card','$cardnumber','$bankname1','$paymenttype','$subtype','$timeonly','$cashgiventocustomer','$cashgivenbycustomer','$cashamount','$onlineamount','$chequeamount','$chequenumber','$creditamount','$onlinenumber','$mpesanumber','$locationname','$locationcode','$cashcode', '$bankcode', '$mpesacode')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		
		$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,card,cardcoa,cash,cashcoa,cheque,chequecoa,online,onlinecoa,mpesa,mpesacoa,source,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accountname','$billnumber','$billdate','$ipaddress','$username','$cardamount','$cardcoa','$cashamount','$cashcoa','$chequeamount','$chequecoa','$onlineamount','$onlinecoa','$creditamount','$mpesacoa','billingpaynow','$locationname','$locationcode')";
        $exec37 = mysql_query($query37) or die(mysql_error());
	
		}
		
		if ($paymentmode == 'MPESA')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'MPESA';
		$particulars = 'BY MPESA'.$billnumberprefix.$billnumber.'';	
		
		$query552 = "select * from financialaccount where transactionmode = 'MPESA'";
		 $exec552 = mysql_query($query552) or die ("Error in Query552".mysql_error());
		 $res552 = mysql_fetch_array($exec552);
		 $mpesacode = $res552['ledgercode'];
	
		$query9 = "insert into master_transactionpaynow (transactiondate, particulars,
		transactionmode, transactiontype, transactionamount, creditamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,financialyear,username,paymenttype,subtype,transactiontime,cashgiventocustomer,cashgivenbycustomer,mpesanumber,locationname,locationcode,mpesacode) 
		values ('$billdate','$particulars', 
		'$transactionmode', '$transactiontype', '$totalamount', '$totalamount', 
		'$billnumber',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule','$patientname','$patientcode','$visitcode','$accountname','$doctorname','paid','$financialyear','$username','$paymenttype','$subtype','$timeonly','$cashgiventocustomer','$cashgivenbycustomer','$mpesanumber','$locationname','$locationcode','$mpesacode')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		
		$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,mpesa,mpesacoa,source,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accountname','$billnumber','$billdate','$ipaddress','$username','$totalamount','$mpesacoa','billingpaynow','$locationname','$locationcode')";
        $exec37 = mysql_query($query37) or die(mysql_error());
	
		}
		
		header("location:patientbillingstatus.php?paynowpatientcode1=$patientcode&&paynowbillnumber=$billnumber");
		exit;
		}
		
		else
		{
		header("location:patientbillingstatus.php");
		}
		}
		else
		{
		header("location:patientbillingstatus.php");
		}
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
$patientpaymenttype = $execlab['billtype'];


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

//location get here
 $locationcode=$execlab1['locationcode'];
//get locationname from location code
$querylab2=mysql_query("select locationname from master_location where locationcode='".$locationcode."'");
$execlab2=mysql_fetch_array($querylab2);
 $locationname=$execlab2['locationname'];


$querylab2=mysql_query("select * from master_accountname where auto_number='$patientaccount'");
$execlab2=mysql_fetch_array($querylab2);
$patientaccount1=$execlab2['accountname'];

$query76 = "select * from master_financialintegration where field='labpaynow'";
$exec76 = mysql_query($query76) or die(mysql_error());
$res76 = mysql_fetch_array($exec76);
$labcoa = $res76['code'];

$query761 = "select * from master_financialintegration where field='radiologypaynow'";
$exec761 = mysql_query($query761) or die(mysql_error());
$res761 = mysql_fetch_array($exec761);

$radiologycoa = $res761['code'];

$query762 = "select * from master_financialintegration where field='servicepaynow'";
$exec762 = mysql_query($query762) or die(mysql_error());
$res762 = mysql_fetch_array($exec762);

$servicecoa = $res762['code'];

$query763 = "select * from master_financialintegration where field='referalpaynow'";
$exec763 = mysql_query($query763) or die(mysql_error());
$res763 = mysql_fetch_array($exec763);

$referalcoa = $res763['code'];

$query764 = "select * from master_financialintegration where field='pharmacypaynow'";
$exec764 = mysql_query($query764) or die(mysql_error());
$res764 = mysql_fetch_array($exec764);

$pharmacycoa = $res764['code'];

$query765 = "select * from master_financialintegration where field='cashpaynow'";
$exec765 = mysql_query($query765) or die(mysql_error());
$res765= mysql_fetch_array($exec765);

$cashcoa = $res765['code'];


$query766 = "select * from master_financialintegration where field='chequepaynow'";
$exec766 = mysql_query($query766) or die(mysql_error());
$res766 = mysql_fetch_array($exec766);

$chequecoa = $res766['code'];


$query767 = "select * from master_financialintegration where field='mpesapaynow'";
$exec767 = mysql_query($query767) or die(mysql_error());
$res767 = mysql_fetch_array($exec767);

$mpesacoa = $res767['code'];

$query768 = "select * from master_financialintegration where field='cardpaynow'";
$exec768 = mysql_query($query768) or die(mysql_error());
$res768 = mysql_fetch_array($exec768);

$cardcoa = $res768['code'];

$query769 = "select * from master_financialintegration where field='onlinepaynow'";
$exec769 = mysql_query($query769) or die(mysql_error());
$res769 = mysql_fetch_array($exec769);

$onlinecoa = $res769['code'];

$querylab2=mysql_query("select locationcode,paymenttype,subtype,planname from master_visitentry where visitcode='$visitcode'");
$execlab2=mysql_fetch_array($querylab2);

 $locationcode=$execlab2['locationcode'];
 $subtype=$execlab2['subtype'];
 $plannumber = $execlab2['planname'];
// echo $planpercentage =  $execlab2['planpercenteage'];
			
			$queryplanname = "select forall,planpercentage from master_planname where auto_number ='".$plannumber."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execplanname = mysql_query($queryplanname) or die ("Error in Queryplanname".mysql_error());
			$resplanname = mysql_fetch_array($execplanname);
		 	$planforall = $resplanname['forall'];
			$copay1 = $resplanname['planpercentage'];

/*$query40=mysql_query("select * from master_accountname where auto_number='$accname'");
			$res40=mysql_fetch_array($query40);
			$accountname=$res40['accountname'];
			$patientvisitcode=$exec31['visitcode'];
			$patientname=$exec31['patientfullname'];
			$consultationdate=$exec31['consultationdate'];
			
			 $paymenttypeanum = $exec31['paymenttype'];
			  
			  $query3 = "select * from master_paymenttype where auto_number = '$paymenttypeanum'";
			  $exec3 = mysql_query($query3) or die ("Error in Query5".mysql_error());
			  $res3 = mysql_fetch_array($exec3);
			  $res3paymenttype = $res3['paymenttype'];*/
			  
			  
 
$query768 = "select locationname from master_location where locationcode='$locationcode'";
$exec768 = mysql_query($query768) or die(mysql_error());
$res768 = mysql_fetch_array($exec768);

 $locationname = $res768['locationname'];


?>

<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$paynowbillprefix = $res3['paynowbillnoprefix'];
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from billing_paynow order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["billno"];
$billdigit=strlen($billnumber);

if ($billnumber == '')
{
	$billnumbercode =$paynowbillprefix.'1'.'-'.$useranum;
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
	
	
	$billnumbercode = $paynowbillprefix .$maxanum.'-'.$useranum;
	$openingbalance = '0.00';
	//echo $companycode;
}
$query3 = "select count(auto_number) as counts from billing_pharmacy where patientcode = '".$patientcode."' AND patientvisitcode='".$visitcode."'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
 $dispensingcount = $res3['counts'];

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
	funcPopupPrintFunctionCall();
	//alert ("Auto Print Function Runs Here.");	
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
	//alert ("Auto Print Function Runs Here.");
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
	//alert(varBillNumber);
	var varBillAutoNumber ="<?php //echo $previousbillautonumber; ?>" ;
	//alert(varBillAutoNumber);
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
		window.open("print_paynow.php?printsource=billpage&&billautonumber="+varBillNumber+"","OriginalWindowA4<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	}
	if (varPaperSize == "A5")
	{
		window.open("print_paynow_a5.php?printsource=billpage&&billautonumber="+varBillNumber+"","OriginalWindowA5<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	}
}

function cashentryonfocus1()
{
	if (document.getElementById("cashgivenbycustomer").value == "0.00")
	{
		document.getElementById("cashgivenbycustomer").value = "";
		document.getElementById("cashgivenbycustomer").focus();
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
		window.location="billing_paynow.php?defaulttax="+varDefaultTax+"&&delbillst=<?php echo $delBillSt; ?>&&delbillautonumber="+<?php echo $delBillAutonumber; ?>+"&&delbillnumber="+<?php echo $delBillNumber; ?>+"";
		<?php
		}
		else
		{
		?>
		window.location="billing_paynow.php?defaulttax="+varDefaultTax+"";
		<?php
		}
		?>
	}
	else
	{
		window.location="billing_paynow.php";
	}
	//return false;
}



</script>
<script type="text/javascript">

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
<?php include ("js/sales1scripting1.php"); ?>

<script type="text/javascript" src="js/insertnewitem7.js"></script>
<style type="text/css">
.bodytext3 {
	FONT-WEIGHT: normal;
	FONT-SIZE: 11px;
	/* [disabled]COLOR: #3B3B3C; */
	FONT-FAMILY: Tahoma
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
	font-size: 36px;
	font-weight: bold;
}
.style2 {
	font-size: 18px;
	font-weight: bold;
}
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }

</style>

<script src="js/datetimepicker_css.js"></script>

<script>
function printPaynowBill()
 {
var popWin; 
popWin = window.open("print_billpaynowbill_dmp4inch_copay.php?patientcode=<?php echo $patientcode; ?>&&billautonumber=<?php echo $billnumbercode; ?>&&ranum=<?php echo (rand(10,100)); ?>","OriginalWindowA4",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
 }
</script>

<script>
function funcSaveBill13()
{
var varUserChoice; 
	varUserChoice = confirm('Are You Sure Want To Save This Entry?'); 
	//alert(fRet); 
	if (varUserChoice == false)
	{
		alert ("Entry Not Saved.");
		return false;
	}
	else
	{
		document.getElementById("save").disabled=true;
		document.frmsales.submit();
		//return true;
	}
	}
	</script>
	
<script>	
function loadprintpage3()
{
	var varBillNumber1 = document.getElementById("quickprintbill").value;
	
	window.open("print_paynow.php?billautonumber="+varBillNumber1+"","OriginalWindowA4<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}
</script>
<script>	
function quickprintbill2sales()
{
   
	var varBillNumber1 = document.getElementById("quickprintbill").value;
	
	window.open("print_paynow_dmp4inch1view1.php?billautonumber="+varBillNumber1+"","OriginalWindowA4<?php echo $banum; ?>",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}
</script>
</head>
<script>
function funcPopupOnLoader()
{
funcOnLoadBodyFunctionCall();
<?php 
if (isset($_REQUEST["savedpatientcode"])) { $savedpatientcode = $_REQUEST["savedpatientcode"]; } else { $savedpatientcode = ""; }
?>
var patientcodes;
var patientcodes = "<?php echo $savedpatientcode; ?>";
//alert(patientcodes);
if(patientcodes != "") 
{
	window.open("print_registration_label.php?previouspatientcode="+patientcodes+" ","OriginalWindowA4",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
}
}
</script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall()">
<form name="form1" id="frmsales" method="post" action="billing_paynow-copay.php" onKeyDown="return disableEnterKey(event)" onSubmit="return funcSaveBill1()">
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
                <tr >
                <td colspan="6" bgcolor="#CCCCCC" class="bodytext32"><strong>Pay Now Patient Details</strong></td>
                
                <td  bgcolor="#CCCCCC" class="bodytext32"><strong>Location:&nbsp;&nbsp;<?php echo $locationname ?> </strong></td>
                 <input type="hidden" name="locationcodeget" value="<?php echo $locationcode;?>">
                <input type="hidden" name="locationnameget" value="<?php echo $locationname;?>">
			 </tr>
			 <?php
			 if (isset($_REQUEST["src"])) { $src = $_REQUEST["src"]; } else { $src = ""; }
			 if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
				//$st = $_REQUEST["st"];
				
     		 if (isset($_REQUEST["billnumber"])) { $previousbillnumber = $_REQUEST["billnumber"]; } else { $previousbillnumber = ""; }
			if ($st == 'success' && $billautonumber != '')
			{
			?>
            <tr>
             
              <td colspan="8"  align="left" valign="center" bgcolor="#FFFF00" class="bodytext31">&nbsp;
			  * Success. Bill Saved. &nbsp;&nbsp;&nbsp;
			  <input name="billprint" type="button" onClick="return loadprintpage3()" value="Click Here To Print Invoice" class="button" style="border: 1px solid #001E6A"/>			  </td>
            </tr>
			<?php
			}
			?>
		<tr>
                <td colspan="7" class="bodytext32"><strong>&nbsp;</strong></td>
			 </tr>
			  <tr>
			    <td width="14%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Patient  </strong></td>
                <td width="20%" align="left" valign="top" class="bodytext3"><?php echo $patientname; ?>
				<input type="hidden" name="patientname" id="customer" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/>                  </td>
                 
                <td width="17%" align="left" valign="top" class="bodytext3"><strong>Reg.No</strong></td>
                <td width="15%" align="left" valign="top" class="bodytext3"><?php echo $patientcode; ?></td>
                <td width="15%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Visit Code</strong></td>
                <td width="22%" colspan="3" align="left" valign="middle" class="bodytext3">
				<input type="hidden" name="billno" id="billno" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<input type="hidden" name="paymenttype" id="paymenttype" value="<?php echo $patienttype1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>	
				<input type="hidden" name="subtype" id="subtype" value="<?php echo $patientsubtype1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>			<?php echo $visitcode; ?></td>
		      </tr>
			   <tr>
			    <td width="14%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Bill No</strong></td>
                <td align="left" valign="top" class="bodytext3">
				<input type="hidden" name="customercode" id="customercode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
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
                <input type="hidden" name="patientage" value="<?php echo $patientage; ?>">
                <input type="hidden" name="patientgender" value="<?php echo $patientgender; ?>">
				<?php echo $billnumbercode; ?>
				
				
				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>
				    <td align="left" valign="top" class="bodytext3"><strong>Bill Date</strong></td>
				    <td align="left" valign="top" class="bodytext3"><?php echo $dateonly; ?></td>
				    <td width="15%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Account</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3">
				<input type="hidden" name="billdate" id="billdate" value="<?php echo $dateonly; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				<?php echo $patientaccount1; ?></td>
              	<input type="hidden" name="account" id="account" value="<?php echo $patientsubtype1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				
			  </tr>
				 	<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>								<input type="hidden" name="accountname" id="account" value="<?php echo $patientaccount1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				
				 
                  <input type="hidden" name="account" id="account" value="<?php echo $patientplan1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>			
				  <input type="hidden" name="account" id="account" value="" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				
				 
				  	<tr>
                <td colspan="7" class="bodytext32"><strong>&nbsp;</strong></td>
			 </tr>
            </tbody>
        </table>
   </td>
      </tr>
	  
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
           <tr bgcolor="#011E6A">
                <td colspan="8" bgcolor="#CCCCCC" class="bodytext32"><strong>Transaction Details</strong></td>
			 </tr>
          
            <tr>
              <td width="5%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				<td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date</strong></div></td>
				<td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Ref.No</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Description</strong></div></td>
                <td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Qty</strong></div></td>
				<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Rate  </strong></div></td>
					<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount </strong></div></td>
				<td width="1%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
                  </tr>
                  
                   <?php 
			$query18 = "select * from master_billing where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec18 = mysql_query($query18) or die ("Error in Query1".mysql_error());
			$res18 = mysql_fetch_array($exec18);
			$billingdatetime=$res18['billingdatetime'];
			$billno=$res18['billnumber'];
			//$copay1=$res18['copaypercentageamount'];
			//echo $labrate;
			 $copay=($labrate/100)*$copay1;
			/*if($copay != 0.00)
			{
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#D3EEB7"';
			}
			$totalcopay=$copay;*/
			 ?>
			<?php /*?> <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billingdatetime; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $copay; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo $copay; ?></div></td>
			  <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
               
             
			  </tr>
			  <?php 
			  } 
			  ?><?php */?>

			 <?php /*?> <?php 
			  $totallab=0;
			  $query19 = "select * from consultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and (paymentstatus='completed' AND copay <> 'completed') ";
			$exec19 = mysql_query($query19) or die ("Error in Query1".mysql_error());
			while($res19 = mysql_fetch_array($exec19))
			{
			$labdate=$res19['consultationdate'];
			$labname=$res19['labitemname'];
			$labrate=$res19['labitemrate'];
			$labcode=$res19['labitemcode'];
			$labrefno=$res19['refno'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#D3EEB7"';
			}
			$totallab=$totallab+$labrate; 
			
			?>
			 <tr <?php echo $colorcode; ?>>
              <?php  $copay=($labrate/100)*$copay1; $totalcopay=$totalcopay+$copay;?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $labname; ?></div></td>
			  <input name="lab[]" id="lab" size="69" type="hidden" value="<?php echo $labname; ?>">
			 <input name="rate5[]" id="rate5" readonly size="8" type="hidden" value="<?php echo $labrate; ?>">
              <input name="copay[]" id="copay" readonly size="8" type="hidden" value="<?php echo $copay; ?>">
			 <input name="labcode[]" id="labcode" readonly size="8" type="hidden" value="<?php echo $labcode; ?>">
			
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $labrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $labrate; ?></div></td>
			<td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
             
            
             <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billingdatetime; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $copay; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo $copay; ?></div></td>
			  <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
               
             
			  </tr>
			  
			  <?php }
			 
			  ?><?php */?>
              
              
              <?php 
			  $totallab=0;
			  $query19 = "select * from consultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and (approvalstatus='2' or approvalstatus='') and (paymentstatus='pending' AND copay <> 'completed') ";
			$exec19 = mysql_query($query19) or die ("Error in Query1".mysql_error());
			while($res19 = mysql_fetch_array($exec19))
			{
			$labdate=$res19['consultationdate'];
			$labname=$res19['labitemname'];
			$labrate=$res19['labitemrate'];
			$labcode=$res19['labitemcode'];
			$labrefno=$res19['refno'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#D3EEB7"';
			}
			$totallab=$totallab+$labrate; 
			
			$totlabratecopay=$labrate;
			if($planforall=='yes'){
			//	$refratecopay=($radrate/100)*$copay1;
				$totlabratecopay= ($labrate/100)*$copay1;
				}
			?>
			 <tr <?php echo $colorcode; ?>>
             
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $labname; ?></div></td>
			  <input name="lab[]" id="lab" size="69" type="hidden" value="<?php echo $labname; ?>">
			 <input name="rate5[]" id="rate5" readonly size="8" type="hidden" value="<?php echo $totlabratecopay; ?>">
             
			 <input name="labcode[]" id="labcode" readonly size="8" type="hidden" value="<?php echo $labcode; ?>">
			
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $labrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $labrate; ?></div></td>
			<td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
             
            <?php if($planforall=='yes'){?>
             <tr <?php echo $colorcode; ?>>
              <?php  $copay=($labrate/100)*$copay1; $totalcopay=$totalcopay+$copay;?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billingdatetime; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $copay; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo $copay; ?></div></td>
			  <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
               
             
			  </tr>
			  <input name="copaylab[]" id="copaylab" readonly size="8" type="hidden" value="<?php echo $copay; ?>">
			  <?php } else {?>
			   <input name="copaylab[]" id="copaylab" readonly size="8" type="hidden" value="<?php echo "0.00"; ?>">
			  <?php
			  }
			  }
			 
			  ?>
              
              
              
              
              
              
              
              
              
              
             <?php /*?> <?php 
			$query18 = "select * from master_billing where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec18 = mysql_query($query18) or die ("Error in Query1".mysql_error());
			$res18 = mysql_fetch_array($exec18);
			$billingdatetime=$res18['billingdatetime'];
			$billno=$res18['billnumber'];
			$copay1=$res18['copaypercentageamount'];
			//echo $labrate;
			 $copay=($labrate/100)*$copay1;
			if($copay != 0.00)
			{
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#D3EEB7"';
			}
			$totalcopay=$copay;
			 ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billingdatetime; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $copay; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo $copay; ?></div></td>
			  <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
               
             
			  </tr>
			  <?php 
			  } 
			  ?><?php */?>
              
              
              
              
              
              
              
              
              
              
              
              
              
              
              
              
			   <?php
		
			   $totalpharm=0;
			   $pharmno=0;
			$query23 = "select * from master_consultationpharm where patientvisitcode='$visitcode' and patientcode='$patientcode' and (approvalstatus='2' or approvalstatus='') and paymentstatus='pending' and medicineissue='pending'";
			$exec23 = mysql_query($query23) or die ("Error in Query1".mysql_error());
			$pharmtotalno=mysql_num_rows($exec23);
			while($res23 = mysql_fetch_array($exec23))
			{
			$phadate=$res23['recorddate'];
			$phaname=$res23['medicinename'];
			$phaquantity=$res23['quantity'];
			$pharate=$res23['rate'];
			
			$phaamount=$phaquantity * $pharate;
			
			$pharefno=$res23['refno'];
			$billtype=$res23['billtype'];
			$excludestatus=$res23['excludestatus'];
			$excludebill = $res23['excludebill'];
			$approvalstatus = $res23['approvalstatus'];
			/*if($billtype == 'PAY LATER')
			{
			if(($excludestatus == 'excluded')&&($excludebill == '') || $approvalstatus=='2')
			{
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#D3EEB7"';
			}
			$totalpharm=$totalpharm+$phaamount;
			
			
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phadate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $phaname; ?></div></td>
			  <input type="hidden" name="pharmname[]" value="<?php echo $phaname; ?>">
			  <input name="medicinename[]" type="hidden" id="medicinename" size="25" value="<?php echo $phaname; ?>">
			 <input name="quantity[]" type="hidden" id="quantity" size="8" readonly value="<?php echo $phaquantity; ?>">
			 <input name="rate[]" type="hidden" id="rate" readonly size="8" value="<?php echo $pharate; ?>">
			 <input name="amount[]" type="hidden" id="amount" readonly size="8" value="<?php echo $phaamount; ?>">
		
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phaquantity; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $pharate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($phaamount,2); ?></div></td>
             
			<td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>copay</strong></div></td>
             
			  
			  <?php 
			 }
			  }*/
			  if(($billtype == 'PAY LATER') && ($copay1>0.00))
			{
			
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#D3EEB7"';
			}
			$totalpharm=$totalpharm+$phaamount;
			$pharmno=$pharmno+1;
			
			$phamratecopay=$pharate;
			$totphamratecopay=$phaamount;
			if($planforall=='yes'){ 
				$phamratecopay=(($phaamount/100)*$copay1)/$phaquantity;
			 	$totphamratecopay= ($phaamount/100)*$copay1;
				}
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phadate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $phaname; ?></div></td>
			  <input type="hidden" name="pharmname[]" value="<?php echo $phaname; ?>">
			  <input name="medicinename[]" type="hidden" id="medicinename" size="25" value="<?php echo $phaname; ?>">
			 <input name="quantity[]" type="hidden" id="quantity" size="8" readonly value="<?php echo $phaquantity; ?>">
			 <input name="rate[]" type="hidden" id="rate" readonly size="8" value="<?php echo $phamratecopay; ?>">
			 <input name="amount[]" type="hidden" id="amount" readonly size="8" value="<?php echo $totphamratecopay; ?>">
		
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phaquantity; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $pharate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($phaamount,2); ?></div></td>
			<td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
             </tr>
             <?php if($planforall=='yes'){?>
             <tr <?php echo $colorcode; ?>>
              <?php  $copay=($phaamount/100)*$copay1; $totalcopay=$totalcopay+$copay; $indcopay=$copay/$phaquantity;?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billingdatetime; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phaquantity; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $indcopay; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo $copay; ?></div></td>
			  <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
               
             
			  </tr>
			  <input name="copayphar[]" id="copayphar" readonly size="8" type="hidden" value="<?php echo $copay; ?>">
			  <?php } else{?>
			   <input name="copayphar[]" id="copayphar" readonly size="8" type="hidden" value="<?php echo "0.00"; ?>">
			  <?php
			  }
			  }
			   if($billtype == 'PAY NOW')
			{
			
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#D3EEB7"';
			}
			$totalpharm=$totalpharm+$phaamount;
			$pharmno=$pharmno+1;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phadate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $phaname; ?></div></td>
			  <input type="hidden" name="pharmname[]" value="<?php echo $phaname; ?>">
			  <input name="medicinename[]" type="hidden" id="medicinename" size="25" value="<?php echo $phaname; ?>">
			 <input name="quantity[]" type="hidden" id="quantity" size="8" readonly value="<?php echo $phaquantity; ?>">
			 <input name="rate[]" type="hidden" id="rate" readonly size="8" value="<?php echo $pharate; ?>">
			 <input name="amount[]" type="hidden" id="amount" readonly size="8" value="<?php echo $phaamount; ?>">
		
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phaquantity; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $pharate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($phaamount,2); ?></div></td>
			<td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
             
			  
			  <?php 
			  }
			  }
			   if(($dispensingcount==0)&&($pharmtotalno>0))
			{
			$query3 = "select dispensing from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$dispensingamount = $res3['dispensing'];

if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#D3EEB7"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			$dispensingfee1=$dispensingfee1+$dispensingamount; 
			
			$desratecopay=$dispensingfee1;
			if($planforall=='yes'){
				$desratecopay=($dispensingfee1/100)*$copay1;
			//	$totdesratecopay= ($dispensingfee1/100)*$copay1;
				}
			  ?>
              
               <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phadate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo "Dispensing Fee"; ?></div></td>
              <input type="hidden" name="pharmname[]" value="<?php echo "Dispensing Fee"; ?>">
			  <input name="medicinename[]" type="hidden" id="medicinename" size="25" value="<?php echo  "Dispensing Fee";  ?>">
			 <input name="quantity[]" type="hidden" id="quantity" size="8" readonly value="<?php echo "1"; ?>">
			 <input name="rate[]" type="hidden" id="rate" readonly size="8" value="<?php echo $desratecopay; ?>">
			 <input name="amount[]" type="hidden" id="amount" readonly size="8" value="<?php echo $desratecopay; ?>">
             <input name="dispensingkey" id="dispensingkey" readonly size="8" type="hidden" value="1">
             <input name="desipaddress" id="desipaddress" readonly  type="hidden" value="<?php echo $_SERVER['REMOTE_ADDR'];?>">
             <input name="desusername" id="desusername" readonly  type="hidden" value="<?php echo $username;?>">
             
			 <?php /*?> <input name="lab[]" id="lab" size="69" type="hidden" value="<?php echo "Dispensingamount"; ?>">
			 <input name="rate5[]" id="rate5" readonly size="8" type="hidden" value="<?php echo $dispensingamount; ?>">
			 <input name="labcode[]" id="labcode" readonly size="8" type="hidden" value="<?php echo 'DISPENS'; ?>">
              <input name="dispensingkey" id="dispensingkey" readonly size="8" type="hidden" value="1"><?php */?>
			
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $dispensingamount; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $dispensingamount; ?></div></td>
			<td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
              
              
              </tr>
               <?php if($planforall=='yes'){?>
             <tr <?php echo $colorcode; ?>>
              <?php  $copay=($dispensingfee1/100)*$copay1; $totalcopay=$totalcopay+$copay; $indcopay=$copay;?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billingdatetime; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo "1"; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $indcopay; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo $copay; ?></div></td>
			  <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
               
             
			  </tr>
			 <?php /*?> <input name="copayphar[]" id="copayphar" readonly size="8" type="hidden" value="<?php echo $copay; ?>">
			  <?php } else{?>
			   <input name="copayphar[]" id="copayphar" readonly size="8" type="hidden" value="<?php echo "0.00"; ?>"><?php */?>
			  <?php
			  }
			   }
			if($pharmno > 0)
			{
			 $query201 = "select * from dispensingfee where visitcode='$visitcode' and patientcode='$patientcode' and status = '' order by auto_number desc limit 0,1";
			$exec201 = mysql_query($query201) or die ("Error in Query1".mysql_error());
			$res201 = mysql_fetch_array($exec201);
			
			$recorddate=$res201['recorddate'];
			$dispensingfee=$res201['dispensingfee'];
			$docno=$res201['docno'];
			
			if($dispensingfee != '')
			{
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#D3EEB7"';
			}
			
			
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $recorddate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo "Dispensing Fee"; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $dispensingfee; ?></div></td>
			 <input type="hidden" name="dispensingfee" id="dispensingfee" value="<?php echo $dispensingfee; ?>">
			 <input type="hidden" name="dispensingdocno" id="dispensingdocno" value="<?php echo $docno; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $dispensingfee; ?></div></td>
			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
             
			  
			  <?php }
			  
			  }
			  ?>
			  
			    <?php 
				$totalrad=0;
			  $query20 = "select * from consultation_radiology where patientvisitcode='$visitcode'  and patientcode='$patientcode' and (approvalstatus='2' or approvalstatus='') and paymentstatus='pending'";
			$exec20 = mysql_query($query20) or die ("Error in Query1".mysql_error());
			while($res20 = mysql_fetch_array($exec20))
			{
			$raddate=$res20['consultationdate'];
			$radname=$res20['radiologyitemname'];
			$radrate=$res20['radiologyitemrate'];
		
			$radref=$res20['refno'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#D3EEB7"';
			}
			$totalrad=$totalrad+$radrate;
			$totrefratecopay=$radrate;
			if($planforall=='yes'){
			//	$refratecopay=($radrate/100)*$copay1;
				$totrefratecopay= ($radrate/100)*$copay1;
				}
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $raddate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $radref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $radname; ?></div></td>
			  <input name="radiology[]" id="radiology" type="hidden" size="69" autocomplete="off" value="<?php echo $radname; ?>">
			 <input name="rate8[]" type="hidden" id="rate8" readonly size="8" value="<?php echo $totrefratecopay; ?>">
		
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $radrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $radrate; ?></div></td>
			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
             </tr>
              <?php if($planforall=='yes'){?>
             <tr <?php echo $colorcode; ?>>
              <?php  $copay=($radrate/100)*$copay1; $totalcopay=$totalcopay+$copay;?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billingdatetime; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $copay; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo $copay; ?></div></td>
			  <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
               
             
			  </tr>
			  <input name="copayrad[]" id="copayrad" readonly size="8" type="hidden" value="<?php echo $copay; ?>">
			  <?php } else{?>
			   <input name="copayrad[]" id="copayrad" readonly size="8" type="hidden" value="<?php echo "0.00"; ?>">
			  <?php
			  }
			  }
			  ?>
			  	    <?php 
					
					$totalser=0;
			  $query21 = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and (approvalstatus='2' or approvalstatus='') and  paymentstatus='pending' group by servicesitemcode";
			$exec21 = mysql_query($query21) or die ("Error in Query1".mysql_error());
			while($res21 = mysql_fetch_array($exec21))
			{
			$serdate=$res21['consultationdate'];
			$sername=$res21['servicesitemname'];
			$sercode=$res21['servicesitemcode'];
			 $serrate=$res21['servicesitemrate'];
			$serref=$res21['refno'];
			
			 $quantity=$res21['serviceqty'];
			 $totserrate=$res21['amount'];
			
			$query2111 = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' and paymentstatus='pending'";
			$exec2111 = mysql_query($query2111) or die ("Error in Query2111".mysql_error());
			$numrow2111 = mysql_num_rows($exec2111);
			
			//$rateperservice=$totserrate/$numrow2111;
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
			$serratecopay=$serrate;
			
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#D3EEB7"';
			}
			$totalser=$totalser+$totserrate;
			$totserratecopay=$totserrate;
			
			if($planforall=='yes'){
				$serratecopay=(($totserrate/100)*$copay1)/$quantity;
				$totserratecopay= ($totserrate/100)*$copay1;
				}
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sername; ?></div></td>
			  <input name="services[]" type="hidden" id="services" size="69" value="<?php echo $sername; ?>">
			 <input name="rate3[]" type="hidden" id="rate3" readonly size="8" value="<?php echo $serratecopay; ?>">
		 	 <input name="quantityser[]" type="hidden" id="quantityser" readonly size="8" value="<?php echo $quantity; ?>">
             <input name="seramount[]" type="hidden" id="seramount" readonly size="8" value="<?php echo $totserratecopay; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $quantity; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $serrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totserrate,2,'.',''); ?></div></td>
			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
             </tr>
              <?php if($planforall=='yes'){?>
             <tr <?php echo $colorcode; ?>>
              <?php  $copay=($totserrate/100)*$copay1; $totalcopay=$totalcopay+$copay; $copayperser=$copay/$quantity;?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billingdatetime; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $quantity; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $copayperser; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo $copay; ?></div></td>
			  <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
               
             
			  </tr>
			  <input name="copayser[]" id="copayser" readonly size="8" type="hidden" value="<?php echo $copay; ?>">
			  <?php }
			  else{?>
			  <input name="copayser[]" id="copayser" readonly size="8" type="hidden" value="<?php echo "0.00"; ?>">
			  <?php }
			  }
			  ?>
			   <?php 
			   $totalref=0;
			  $query22 = "select * from consultation_referal where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='pending'";
			$exec22 = mysql_query($query22) or die ("Error in Query1".mysql_error());
			while($res22 = mysql_fetch_array($exec22))
			{
			$refdate=$res22['consultationdate'];
			$refname=$res22['referalname'];
			$refrate=$res22['referalrate'];
			$refref=$res22['refno'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#D3EEB7"';
			}
			$totalref=$totalref+$refrate;
			
			$totrefrratecopay=$refrate;
			
			if($planforall=='yes'){
				//$serratecopay=(($totserrate/100)*$copay1)/$quantity;
				$totrefrratecopay= ($refrate/100)*$copay1;
				}
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refdate; ?></div></td>
			  <input type="hidden" name="referalname" value="<?php echo $refname; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $refname; ?></div></td>
			  <input name="referal[]" type="hidden" id="referal" size="69" value="<?php echo $refname; ?>">
			 <input name="refrate4[]" type="hidden" id="refrate4" readonly size="8" value="<?php echo $totrefrratecopay; ?>">
			
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $refrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $refrate; ?></div></td>
			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
             </tr>
             <?php if($planforall=='yes'){?>
             <tr <?php echo $colorcode; ?>>
              <?php  $copay=($refrate/100)*$copay1; $totalcopay=$totalcopay+$copay;?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billingdatetime; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $copay; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo $copay; ?></div></td>
			  <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
               
             
			  </tr>
			  <input name="copayref[]" id="copayref" readonly size="8" type="hidden" value="<?php echo $copay; ?>">
			  <?php } else{?>
			   <input name="copayref[]" id="copayref" readonly size="8" type="hidden" value="<?php echo "0.00"; ?>">
			  <?php
			  }
			  
			   }
			  ?>
              
              
              
              
              
              
              
              
              <?php 
			   $totalopa=0;
			  $query22 = "select * from op_ambulance where patientvisitcode='$visitcode' and billtype='PAY LATER' and patientcode='$patientcode' and paymentstatus='completed'";
			$exec22 = mysql_query($query22) or die ("Error in Query1".mysql_error());
			$ambcount=mysql_num_rows($exec22);
			while($res22 = mysql_fetch_array($exec22))
			{
			$refdate=$res22['consultationdate'];
			$refname=$res22['description'];
			$refrate=$res22['rate'];
			$refamount=$res22['amount'];
			$refref=$res22['docno'];
			$qty=$res22['units'];
			
			$accountname=$res22['accountname'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#D3EEB7"';
			}
			$totalopa=$totalopa+$refamount;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refdate; ?></div></td>
			  <?php /*?><input type="hidden" name="referalname" value="<?php echo $refname; ?>"><?php */?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $refname; ?></div></td>
			  <input name="opname[]" type="hidden" id="opname" size="69" value="<?php echo $refname; ?>">
			 <input name="oprate4[]" type="hidden" id="oprate4" readonly size="8" value="<?php echo $refrate; ?>">
             <input type="hidden" name="ambulancecount[]" value="<?php echo $sno-1;?>">
              <input name="accountname[]" type="hidden" id="accountname" readonly size="8" value="<?php echo $accountname; ?>">
               <input name="description[]" type="hidden" id="description" readonly size="8" value="<?php echo $refname; ?>">
                <input name="quantityop[]" type="hidden" id="quantityop" readonly size="8" value="<?php echo $qty; ?>">
                 <input name="rateop[]" type="hidden" id="rateop" readonly size="8" value="<?php echo $refrate; ?>">
                  <input name="amountop[]" type="hidden" id="amountop" readonly size="8" value="<?php echo $refamount; ?>">
                   <input name="amdocno[]" type="hidden" id="amdocno" readonly size="8" value="<?php echo $refref; ?>">
			
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $qty; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $refrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $refamount; ?></div></td>
			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
             </tr>
              <?php if($planforall=='yes'){?>
             <tr <?php echo $colorcode; ?>>
              <?php   $copay=(($refrate*$qty)/100)*$copay1; $totalcopay=$totalcopay+$copay;?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billingdatetime; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $qty; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $copay/$qty; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo $copay; ?></div></td>
			  <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
             
			  </tr>
			  <input name="copayopamb[]" id="copayopamb" readonly size="8" type="hidden" value="<?php echo $copay; ?>">
			  <?php } else{?>
			   <input name="copayopamb[]" id="copayopamb" readonly size="8" type="hidden" value="<?php echo "0.00"; ?>">
			  <?php
			  }}
			  ?><input type="hidden" name="ambcount" value="<?php echo $ambcount;?>">
              
               <?php 
			   $totalhom=0;
			   $snohome='0';
			  $query22 = "select * from homecare where patientvisitcode='$visitcode' and billtype='PAY LATER' and patientcode='$patientcode' and paymentstatus='completed'";
			$exec22 = mysql_query($query22) or die ("Error in Query1".mysql_error());
			$ambcount1=mysql_num_rows($exec22);
			while($res22 = mysql_fetch_array($exec22))
			{
			$refdate=$res22['consultationdate'];
			$refname=$res22['description'];
			$refrate=$res22['rate'];
			$refamount=$res22['amount'];
			$refref=$res22['docno'];
			$qty=$res22['units'];
			
			$accountname=$res22['accountname'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#D3EEB7"';
			}
			$totalhom=$totalhom+$refamount;
			
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refdate; ?></div></td>
			  <?php /*?><input type="hidden" name="referalname" value="<?php echo $refname; ?>"><?php */?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $refname; ?></div></td>
			  <input name="homecare[]" type="hidden" id="homecare" size="69" value="<?php echo $refname; ?>">
			 <input name="homerate4[]" type="hidden" id="homerate4" readonly size="8" value="<?php echo $refrate; ?>">
             <input type="hidden" name="ambulancecounthom[]" value="<?php echo $snohome;?>">
              <input name="accountnamehom[]" type="hidden" id="accountname" readonly size="8" value="<?php echo $accountname; ?>">
               <input name="descriptionhom[]" type="hidden" id="description" readonly size="8" value="<?php echo $refname; ?>">
                <input name="quantityhom[]" type="hidden" id="quantityhom" readonly size="8" value="<?php echo $qty; ?>">
                 <input name="ratehom[]" type="hidden" id="ratehom" readonly size="8" value="<?php echo $refrate; ?>">
                  <input name="amounthom[]" type="hidden" id="amounthom" readonly size="8" value="<?php echo $refamount; ?>">
                   <input name="amdocnohom[]" type="hidden" id="amdocno" readonly size="8" value="<?php echo $refref; ?>">
			<?php $snohome=$snohome+1;?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $qty; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $refrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $refamount; ?></div></td>
			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
             </tr>
             <?php if($planforall=='yes'){?>
             <tr <?php echo $colorcode; ?>>
              <?php  $copay=(($refrate*$qty)/100)*$copay1; $totalcopay=$totalcopay+$copay;?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billingdatetime; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $qty; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $copay/$qty; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo $copay; ?></div></td>
			  <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
             
			  </tr>
			  <input name="copayopamb[]" id="copayopamb" readonly size="8" type="hidden" value="<?php echo $copay; ?>">
			  <?php } else{?>
			   <input name="copayopamb[]" id="copayopamb" readonly size="8" type="hidden" value="<?php echo "0.00"; ?>">
			  <?php
			  } }
			  ?><input type="hidden" name="ambcount1" value="<?php echo $ambcount1;?>">
              
              
              
              
              
              
              
              
              
              
              
              
			   <?php 
			   $totaldepartmentref=0;
			  $query231 = "select * from consultation_departmentreferal where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='pending'";
			$exec231 = mysql_query($query231) or die ("Error in Query1".mysql_error());
			while($res231 = mysql_fetch_array($exec231))
			{
			$departmentrefdate=$res231['consultationdate'];
			$departmentrefname=$res231['referalname'];
			$departmentrefrate=$res231['referalrate'];
			$departmentrefref=$res231['refno'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#D3EEB7"';
			}
			$totaldepartmentref=$totaldepartmentref+$departmentrefrate;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $departmentrefdate; ?></div></td>
			  <input type="hidden" name="departmentreferalname" value="<?php echo $departmentrefname; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $departmentrefref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left">Referral Fee - <?php echo $departmentrefname; ?></div></td>
			  <input name="departmentreferal[]" type="hidden" id="departmentreferal" size="69" value="<?php echo $departmentrefname; ?>">
			 <input name="departmentreferalrate4[]" type="hidden" id="departmentreferalrate4" readonly size="8" value="<?php echo $departmentrefrate; ?>">
			
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $departmentrefrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $departmentrefrate; ?></div></td>
			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
             
			  
			  <?php }
			  ?>
			  <?php 
			  if($planforall=='yes'){ //echo $dispensingfee;
			  //$overalltotal=($totalop+$totallab+$totalpharm+$totalrad+$totalser+$totalref+$totaldepartmentref+$dispensingfee)-$totalcopay;
			  $overalltotal=$totalcopay;
			   $overalltotal=number_format($overalltotal,2,'.','');
			   $consultationtotal=$totalcopay;
			   $consultationtotal=number_format($consultationtotal,2,'.','');
			   $netpay= $totalcopay;
			   $netpay=number_format($netpay,2,'.','');
			   $totalamount=$overalltotal;
			
			   }
			  else
			  { 
			   $overalltotal=($totallab+$totalpharm+$totalrad+$totalser+$totalref+$totaldepartmentref+$desratecopay+$totalopa+$totalhom)+$totalcopay;
			   $overalltotal=number_format($overalltotal,2,'.','');
			   $consultationtotal=$totalcopay;
			   $consultationtotal=number_format($consultationtotal,2,'.','');
			   $netpay= $consultationtotal+$totallab+$totalpharm+$totalrad+$totalser+$totalref+$totaldepartmentref+$desratecopay+$totalopa+$totalhom;
			   $netpay=number_format($netpay,2,'.','');
			   $totalamount=$overalltotal;
				  
				  }
			  ?>
			  <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong>Total</strong></td>
             <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo $overalltotal; ?></strong></td>
				 <td width="4%"  align="left" valign="center" 
               class="bodytext31" bgcolor="#cccccc"><div align="right"><strong>&nbsp;</strong></div></td>
             
			 </tr>
          </tbody>
        </table>		</td>
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
				style="border: 1px solid #001E6A; text-align:right;" value="0.00" size="4" />
				  <input name="allitemdiscountpercent1" id="allitemdiscountpercent1" onKeyUp="return funcAllItemDiscountApply1()" 
				style="border: 1px solid #001E6A; text-align:right;background-color:#CCCCCC" value="0.00" size="4"  />
				  <input name="subtotaldiscountpercent" id="subtotaldiscountpercent" onKeyDown="return funcResetPaymentInfo1()" 
					 type="hidden" onBlur="return funcbillamountcalc1()" value="0.00" style="border: 1px solid #001E6A; text-align:right" size="8" />
				    <input name="totaldiscountamount" id="totaldiscountamount" value="0.00" type="hidden" style="border: 1px solid #001E6A; text-align:right" size="8"  readonly="readonly" />
				    <input type="hidden" name="subtotaldiscountrupees" id="subtotaldiscountrupees" onKeyDown="return funcResetPaymentInfo1()" onBlur="return funcbillamountcalc1()" value="0.00" style="border: 1px solid #001E6A; text-align:right" size="8" />
				    <input type="hidden" name="afterdiscountamount" id="afterdiscountamount" value="0.00" style="border: 1px solid #001E6A; text-align:right" size="8"  readonly="readonly" />
				  </strong></span></td>
				  </tr>
				 
				  <tr bordercolor="#f3f3f3">
                    <td align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#F3F3F3" class="bodytext31"><div align="right"><span class="bodytext311"><strong>  Disc Amt </strong></span></div></td>
				    <td><span class="bodytext311"><strong>
                      <input name="totaldiscountamountonlyapply1" id="totaldiscountamountonlyapply1" onKeyUp="return funcDiscountAmountCalc1()" 
				type="text" style="border: 1px solid #001E6A; text-align:right;" value="0.00" size="4" />
                      <input name="totaldiscountamountonlyapply2" id="totaldiscountamountonlyapply2" onKeyUp="return funcDiscountAmountCalc1()" readonly  
				type="text" style="border: 1px solid #001E6A; text-align:right; background-color:#CCCCCC" value="0.00" size="4" />
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
			  $totalamount = round($totalamount);
			  $totalamount = number_format($totalamount,2,'.','');
			  $roundoffamount = $originalamount - $totalamount;
			  $roundoffamount = number_format($roundoffamount,2,'.','');
			  $roundoffamount = -($roundoffamount);
			  ?>
                <td width="3%" rowspan="3" align="right" valign="top"  
                bgcolor="#F3F3F3" class="style1" id="tdShowTotal"><?php echo $totalamount; ?></td>
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
                  <input type="hidden" name="totalaftertax" id="totalaftertax" value="0.00"  onKeyDown="return disableEnterKey()" onBlur="return funcSubTotalCalc()" style="border: 1px solid #001E6A; text-align:right" size="8"  readonly="readonly"/>
              
               
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
bgcolor="#F3F3F3" class="bodytext31" width="6%"><input name="creditamount" id="creditamount" onBlur="return funcbillamountcalc1()" value="0.00" style="border: 1px solid #001E6A; text-align:right" size="8"  readonly="readonly" onKeyUp="return balancecalc('2')"/></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> MPESA No. </strong></div></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="10%"><input name="mpesanumber" id="mpesanumber" value="" style="border: 1px solid #001E6A; text-align:left; text-transform:uppercase" size="8"  /></td>
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
bgcolor="#F3F3F3" class="bodytext31"><input name="chequeamount" id="chequeamount" onBlur="return funcbillamountcalc1()" value="0.00" style="border: 1px solid #001E6A; text-align:right" size="8"  readonly="readonly" onKeyUp="return balancecalc('3')"/></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> Chq No. </strong></div></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="10%"><input name="chequenumber" id="chequenumber" value="" style="border: 1px solid #001E6A; text-align:left; text-transform:uppercase" size="8"  /></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="8%"><div align="right"><strong> Date </strong></div></td>
                <td width="6%" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31">  <input name="chequedate" id="chequedate" value="" style="border: 1px solid #001E6A; text-align:left; text-transform:uppercase" size="8"  /></td>
                <td width="9%" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> Bank  </strong></div></td>
                <td width="23%" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"> <input name="chequebank" id="chequebank" value="" style="border: 1px solid #001E6A; text-align:left; text-transform:uppercase" size="8"  /></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"></td>
                   </tr>
			  
              <tr id="cardamounttr">
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"></td>
                <td colspan="2" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Card  </strong></div></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><input name="cardamount" id="cardamount" onBlur="return funcbillamountcalc1()" value="0.00" style="border: 1px solid #001E6A; text-align:right" size="8"  readonly="readonly" onKeyUp="return balancecalc('4')"/></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> Card No </strong></div></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="10%"><input name="cardnumber" id="cardnumber" value="" style="border: 1px solid #001E6A; text-align:left; text-transform:uppercase" size="8"  /></td>
                <td width="8%" align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong>Name  </strong></div></td>
                <td align="left" valign="center"  
bgcolor="#F3F3F3" class="bodytext31" width="6%"><input type="text" name="cardname" id="cardname" size="8" style="border: 1px solid #001E6A; text-align:left;">
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
                <td align="left" valign="center" class="bodytext31" width="23%"><input name="bankname1" id="bankname" value="" style="border: 1px solid #001E6A; text-align:left; text-transform:uppercase"  size="8"  /></td>
              </tr>
              <tr id="onlineamounttr">
			  <td align="left" valign="center"
                bgcolor="#F3F3F3" class="bodytext31">&nbsp;</td>
			    <td colspan="2" align="left" valign="center" 
                bgcolor="#F3F3F3" class="bodytext31">
                 <div align="right"><strong>Online  </strong></div>                  </td>
                <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31"><input name="onlineamount" id="onlineamount" onBlur="return funcbillamountcalc1()" value="0.00" style="border: 1px solid #001E6A; text-align:right" size="8" readonly onKeyUp="return balancecalc('5')"/></td>
                 <td align="left" valign="center"  
                bgcolor="#F3F3F3" class="bodytext31"><div align="right"><strong> Online No </strong></div></td>
                <td align="left" valign="center"  
                 class="bodytext31" width="10%"><input name="onlinenumber" id="onlinenumber" value="" style="border: 1px solid #001E6A; text-align:left; text-transform:uppercase" size="8"  /></td>
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

				  <input name="Submit2223" type="submit" id="save" value="Save Bill(Alt+S)" accesskey="s" class="button"/>
                </font></font></font></font></font></div></td>
              </tr>
			  
			 <!-- <tr>
                <td colspan="8" class="bodytext32">
				<div align="right"><span class="bodytext31">
                <strong>Print Bill No: </strong>
                <input name="quickprintbill" id="quickprintbill" value="<?php echo $billnumber; ?>" style="border: 1px solid #001E6A; text-align:right; text-transform:uppercase"  size="7"  />
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
		</td>
   </tr>
    </table>

</form>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>
