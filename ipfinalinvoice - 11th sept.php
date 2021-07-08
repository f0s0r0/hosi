<?php
session_start();
error_reporting(0);
include ("includes/loginverify.php");
include ("db/db_connect.php"); 

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$updatetime = date('H:i:s');
$updatedate = date('Y-m-d');
$currentdate = date('Y-m-d');
$mortuaryupdatedate=date('Y-m-d');
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$balancevalue = 0;


if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
	//get locationcode and locationname for inserting
 $locationcodeget=isset($_REQUEST['locationcodeget'])?$_REQUEST['locationcodeget']:'';
 $locationnameget=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';
//get ends here
    $visitcode=$_REQUEST["visitcode"];
	$patientcode = $_REQUEST["patientcode"];
	$patientname = $_REQUEST["patientname"];
	$patientbilltype = $_REQUEST['patientbilltype'];
	$packagecoa = $_REQUEST['packagecoa'];
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
		$bedchargescoa = $_REQUEST['bedchargescoa'];
		$rmocoa = $_REQUEST['rmocoa'];
		$nursingcoa = $_REQUEST['nursingcoa'];
		$privatedoctorcoa = $_REQUEST['privatedoctorcoa'];
		$ambulancecoa = $_REQUEST['ambulancecoa'];
		$nhifcoa = $_REQUEST['nhifcoa'];
		$otbillingcoa = $_REQUEST['otbillingcoa'];
		$miscbillingcoa = $_REQUEST['miscbillingcoa'];
		$admissionchargecoa = $_REQUEST['admissionchargecoa'];
		$totalrevenue = $_REQUEST['totalrevenue'];
		$discount = $_REQUEST['discount'];
		$deposit = $_REQUEST['deposit'];
		$nhif = $_REQUEST['nhif'];
		$ipdepositscoa = $_REQUEST['ipdepositscoa'];
		$returnbalance = $_REQUEST['returnbalance'];
		
		$accountname= $_REQUEST['accountname'];
		$subtype = $_REQUEST['subtype'];
		$paymenttype = $_REQUEST['paymenttype'];
		$totalamount=$_REQUEST['netpayable'];
		
		$accountnameano= $_REQUEST['accountnameano'];
		$accountnameid= $_REQUEST['accountnameid'];
		$subtypeano = $_REQUEST['subtypeano'];
	
	
	//this is for update master_customer ipdue
	$ipduevalue=0;
	$Querylab=mysql_query("select ipdue from master_customer where customercode='$patientcode'");
$execlab=mysql_fetch_array($Querylab);
 $ipduevalue=$execlab['ipdue'];
 $ipduevalue=$ipduevalue+$totalamount;
 
 mysql_query("UPDATE  master_customer SET ipdue = '".$ipduevalue."' where customercode='$patientcode'");
 //exit();
 
	$query7691 = "select * from master_financialintegration where field='externaldoctors'";
		$exec7691 = mysql_query($query7691) or die(mysql_error());
		$res7691 = mysql_fetch_array($exec7691);
		
		$debitcoa = $res7691['code'];
	
	$paylaterbillprefix = 'IPF-';
	$paylaterbillsuffix = '-'.date('y');

$paylaterbillprefix1=strlen($paylaterbillprefix);
$query2 = "select * from billing_ip order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["billno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode =$paylaterbillprefix.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billno"];
	$billnumbercode = substr($billnumber,$paylaterbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = $paylaterbillprefix .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}

$billnumbercode.=$paylaterbillsuffix;
$billno= $billnumbercode;

	if($patientbilltype == 'PAY NOW')
	{
   $cash = $_REQUEST['cash'];
	if($cash == '')
	{
	$cash = 0;
	}
	else
	{
	$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,cash,cashcoa,source,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accountname','$billno','$updatedate','$ipaddress','$username','$cash','$cashcoa','ipfinalinvoice','".$locationnameget."','".$locationcodeget."')";
    $exec37 = mysql_query($query37) or die(mysql_error());
	
	}
	$cheque = $_REQUEST['cheque'];
	if($cheque == '')
	{
	$cheque = 0;
	}
	else
	{
	$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,cheque,chequecoa,source,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accountname','$billno','$updatedate','$ipaddress','$username','$cheque','$chequecoa','ipfinalinvoice','".$locationnameget."','".$locationcodeget."')";
    $exec37 = mysql_query($query37) or die(mysql_error());
	
	}
	$chequenumber = $_REQUEST['chequenumber1'];
	if($chequenumber == '')
	{
	$chequenumber = 0;
	}
	
	$online = $_REQUEST['online'];
	if($online == '')
	{
	$online = 0;
	}
	else
	{
	$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,online,onlinecoa,source,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accountname','$billno','$updatedate','$ipaddress','$username','$online','$onlinecoa','ipfinalinvoice','".$locationnameget."','".$locationcodeget."')";
    $exec37 = mysql_query($query37) or die(mysql_error());
	
	}
	$onlinenumber = $_REQUEST['onlinenumber1'];
	if($onlinenumber == '')
	{
	$onlinenumber = 0;
	}
	$creditcard = $_REQUEST['creditcard'];
	if($creditcard == '')
	{
	$creditcard = 0;
	}
	else
	{
	$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,card,cardcoa,source,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accountname','$billno','$updatedate','$ipaddress','$username','$creditcard','$cardcoa','ipfinalinvoice','".$locationnameget."','".$locationcodeget."')";
    $exec37 = mysql_query($query37) or die(mysql_error());
	
	}
	$creditcardnumber = $_REQUEST['creditcardnumber1'];
	if($creditcardnumber == '')
	{
	$creditcardnumber = 0;
	}
	$mpesa = $_REQUEST['mpesa'];
	if($mpesa == '')
	{
	$mpesa = 0;
	}
	else
	{
	$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,mpesa,mpesacoa,source,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accountname','$billno','$updatedate','$ipaddress','$username','$mpesa','$mpesacoa','ipfinalinvoice','".$locationnameget."','".$locationcodeget."')";
    $exec37 = mysql_query($query37) or die(mysql_error());
	
	}
	$mpesanumber = $_REQUEST['mpesanumber1'];
	if($mpesanumber == '')
	{
	$mpesanumber = 0;
	}
	}
	else
	{
	$cash = 0;
	$cheque = 0;
	$chequenumber = 0;
	$online = 0;
	$onlinenumber = 0;
	$creditcard = 0;
	$creditcardnumber = 0;
	$mpesa = 0;
	$mpesanumber = 0;

	}
	
	
if(isset($_POST['description']))
{
foreach($_POST['description'] as $key=>$value)
		{
				    //echo '<br>'.$k;

		$descriptionname=$_POST['description'][$key];
		if($descriptionname == 'Bed Charges')
		{
		$coa = $bedchargescoa;
		}
		else if($descriptionname == 'Nursing Charges')
		{
		$coa = $nursingcoa;
		}
		else if($descriptionname == 'RMO Charges')
		{
		$coa = $rmocoa;
		}
		else
		{
		$coa = $packagecoa;
		}
		$descriptionrate=$_POST['descriptionrate'][$key];
		$descriptionamount=$_POST['descriptionamount'][$key];
		$descriptionquantity=$_POST['descriptionquantity'][$key];
		$descriptiondocno=$_POST['descriptiondocno'][$key];
		
		
		if($descriptionname!="")
		{
		$query71 = "insert into billing_ipbedcharges(description,rate,quantity,amount,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa,locationname,locationcode)values('$descriptionname','$descriptionrate','$descriptionquantity','$descriptionamount','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$coa','".$locationnameget."','".$locationcodeget."')";
		$exec71=mysql_query($query71) or die(mysql_error());
		}
		}
		}
		if(isset($_POST['descriptioncharge']))
		{
		foreach($_POST['descriptioncharge'] as $key=>$value)
		{
				    //echo '<br>'.$k;

		$descriptioncharge=$_POST['descriptioncharge'][$key];
		if($descriptioncharge == 'Bed Charges')
		{
		$coa = $bedchargescoa;
		}
		if($descriptioncharge == 'Nursing Charges')
		{
		$coa = $nursingcoa;
		}
		if($descriptioncharge == 'RMO Charges')
		{
		$coa = $rmocoa;
		}
		$descriptionchargerate=$_POST['descriptionchargerate'][$key];
	    $descriptionchargeamount=$_POST['descriptionchargeamount'][$key];
		$descriptionchargequantity=$_POST['descriptionchargequantity'][$key];
		$descriptionchargedocno=$_POST['descriptionchargedocno'][$key];
		$descriptionchargeward=$_POST['descriptionchargeward'][$key];
		$descriptionchargebed=$_POST['descriptionchargebed'][$key];
		
		if($descriptioncharge!="")
		{
		$query71 = "insert into billing_ipbedcharges(description,rate,quantity,amount,ward,bed,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa,locationname,locationcode)values('$descriptioncharge','$descriptionchargerate','$descriptionchargequantity','$descriptionchargeamount','$descriptionchargeward','$descriptionchargebed','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$coa','".$locationnameget."','".$locationcodeget."')";
		$exec71=mysql_query($query71) or die(mysql_error());
		}
		}
		}
		if(isset($_POST['descriptioncharge1']))
		{
			foreach($_POST['descriptioncharge1'] as $key=>$value)
		{
				    //echo '<br>'.$k;

		$descriptioncharge1=$_POST['descriptioncharge1'][$key];
			if($descriptioncharge1 == 'Bed Charges')
		{
		$coa = $bedchargescoa;
		}
		if($descriptioncharge1 == 'Nursing Charges')
		{
		$coa = $nursingcoa;
		}
		if($descriptioncharge1 == 'RMO Charges')
		{
		$coa = $rmocoa;
		}
		$descriptionchargerate1=$_POST['descriptionchargerate1'][$key];
		$descriptionchargeamount1=$_POST['descriptionchargeamount1'][$key];
		$descriptionchargequantity1=$_POST['descriptionchargequantity1'][$key];
		$descriptionchargedocno1=$_POST['descriptionchargedocno1'][$key];
		$descriptionchargeward1=$_POST['descriptionchargeward1'][$key];
		$descriptionchargebed1=$_POST['descriptionchargebed1'][$key];
		
		if($descriptioncharge1!="")
		{
		$query711 = "insert into billing_ipbedcharges(description,rate,quantity,amount,ward,bed,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa,locationname,locationcode)values('$descriptioncharge1','$descriptionchargerate1','$descriptionchargequantity1','$descriptionchargeamount1','$descriptionchargeward1','$descriptionchargebed1','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$coa','".$locationnameget."','".$locationcodeget."')";
		$exec711=mysql_query($query711) or die(mysql_error());
		}
		}
		}
		
		if(isset($_POST['descriptioncharge12']))
		{
			foreach($_POST['descriptioncharge12'] as $key=>$value)
		{
				    //echo '<br>'.$k;

		$descriptioncharge12=$_POST['descriptioncharge12'][$key];
				if($descriptioncharge12 == 'Bed Charges')
		{
		$coa = $bedchargescoa;
		}
		if($descriptioncharge12 == 'Nursing Charges')
		{
		$coa = $nursingcoa;
		}
		if($descriptioncharge12 == 'RMO Charges')
		{
		$coa = $rmocoa;
		}
		$descriptionchargerate12=$_POST['descriptionchargerate12'][$key];
		$descriptionchargeamount12=$_POST['descriptionchargeamount12'][$key];
		$descriptionchargequantity12=$_POST['descriptionchargequantity12'][$key];
		$descriptionchargedocno12=$_POST['descriptionchargedocno12'][$key];
		$descriptionchargeward12=$_POST['descriptionchargeward12'][$key];
		$descriptionchargebed12=$_POST['descriptionchargebed12'][$key];
		
		if($descriptioncharge12!="")
		{
		$query712 = "insert into billing_ipbedcharges(description,rate,quantity,amount,ward,bed,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa,locationname,locationcode)values('$descriptioncharge12','$descriptionchargerate12','$descriptionchargequantity12','$descriptionchargeamount12','$descriptionchargeward12','$descriptionchargebed12','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$coa','".$locationnameget."','".$locationcodeget."')";
		$exec712=mysql_query($query712) or die(mysql_error());
		}
		}
		}
		if(isset($_POST['medicinename']))
		{
	foreach($_POST['medicinename'] as $key=>$value)
		{	
		    //echo '<br>'.$i;
			//echo '<br>'.
			//$autonumber = $_REQUEST['autonumber'.$p];	
			//echo '<br>'.
		    $medicinename = $_POST['medicinename'][$key];
			$query77="select * from master_medicine where itemname='$medicinename'";
			$exec77=mysql_query($query77);
			$res77=mysql_fetch_array($exec77);
			$medicinecode=$res77['itemcode'];
			$rate=$res77['rateperunit'];
			$quantity = $_POST['quantity'][$key];
				$amount = $_POST['amount'][$key];
			
			//if ($medicinename != "" && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")
			if ($medicinename != "")// && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")
			{
		        //echo '<br>'. 
		        $query2 = "insert into billing_ippharmacy(patientcode,patientname,patientvisitcode,medicinename,quantity,rate,amount,billdate,ipaddress,accountname,medicinecode,billnumber,pharmacycoa,locationname,locationcode) 
				values('$patientcode','$patientname','$visitcode','$medicinename','$quantity','$rate','$amount','$currentdate','$ipaddress','$accountname','$medicinecode','$billno','$pharmacycoa','".$locationnameget."','".$locationcodeget."')";
				$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			
							
			}
		
		}
		}
		if(isset($_POST['lab']))
		{
		foreach($_POST['lab'] as $key=>$value)
		{
				    //echo '<br>'.$k;

		$labname=$_POST['lab'][$key];
		$labquery=mysql_query("select * from master_lab where itemname='$labname'");
		$execlab=mysql_fetch_array($labquery);
		$labcode=$execlab['itemcode'];
		$labrate=$_POST['rate5'][$key];
		
		if($labname!="")
		{
		$labquery1=mysql_query("insert into billing_iplab(patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,accountname,billdate,billnumber,labcoa,locationname,locationcode)values('$patientcode','$patientname','$visitcode','$labcode','$labname','$labrate','$accountname','$currentdate','$billno','$labcoa','".$locationnameget."','".$locationcodeget."')") or die(mysql_error());
			}
		}
		}
		if(isset($_POST['radiology']))
		{
		foreach($_POST['radiology'] as $key=>$value){	
			//echo '<br>'.
		
		$pairs= $_POST['radiology'][$key];
		$pairvar= $pairs;
	    $pairs1= $_POST['rate8'][$key];
		$pairvar1= $pairs1;
		
		$radiologyquery=mysql_query("select * from master_radiology where itemname='$pairvar'");
		$execradiology=mysql_fetch_array($radiologyquery);
		$radiologycode=$execradiology['itemcode'];
		
		
		if($pairvar!="")
		{
		$radiologyquery1=mysql_query("insert into billing_ipradiology(patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,accountname,billdate,billnumber,radiologycoa,locationname,locationcode)values('$patientcode','$patientname','$visitcode','$radiologycode','$pairs','$pairs1','$accountname','$currentdate','$billno','$radiologycoa','".$locationnameget."','".$locationcodeget."')") or die(mysql_error());
		}
		}
		}
		if(isset($_POST['services']))
		{
		foreach($_POST['services'] as $key => $value)
		{
				    //echo '<br>'.$k;

		$servicesname=$_POST["services"][$key];
		$servicequery=mysql_query("select * from master_services where itemname='$servicesname'");
		$execservice=mysql_fetch_array($servicequery);
		$servicescode=$execservice['itemcode'];
		
		$servicesrate=$_POST["rate3"][$key];
		
		if($servicesname!="")
		{
		$servicesquery1=mysql_query("insert into billing_ipservices(patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,accountname,billdate,billnumber,servicecoa,locationname,locationcode)values('$patientcode','$patientname','$visitcode','$servicescode','$servicesname','$servicesrate','$accountname','$currentdate','$billno','$servicecoa','".$locationnameget."','".$locationcodeget."')") or die(mysql_error());
		}
		}
		}
		if(isset($_POST['ambulance']))
		{
		foreach($_POST['ambulance'] as $key=>$value)
		{
				    //echo '<br>'.$k;

		$ambulance=$_POST['ambulance'][$key];
		
		$ambulancerate=$_POST['ambulancerate'][$key];
	    $ambulanceamount=$_POST['ambulanceamount'][$key];
		$ambulancequantity=$_POST['ambulancequantity'][$key];
			
		if($ambulance!="")
		{
		$query51 = "insert into billing_ipambulance(description,rate,quantity,amount,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa,locationname,locationcode)values('$ambulance','$ambulancerate','$ambulancequantity','$ambulanceamount','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$ambulancecoa','".$locationnameget."','".$locationcodeget."')";
		$exec51=mysql_query($query51) or die(mysql_error());
			}
		}
		}
		
		if(isset($_POST['iphomecare']))
		{
		foreach($_POST['iphomecare'] as $key=>$value)
		{
				    //echo '<br>'.$k;

		$iphomecare=$_POST['iphomecare'][$key];
		
		$iphomecarerate=$_POST['iphomecarerate'][$key];
	    $iphomecareamount=$_POST['iphomecareamount'][$key];
		$iphomecarequantity=$_POST['iphomecarequantity'][$key];
			
		if($iphomecare!="")
		{
		$query51 = "insert into billing_iphomecare(description,rate,quantity,amount,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa,locationname,locationcode)values('$iphomecare','$iphomecarerate','$iphomecarequantity','$iphomecareamount','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$iphomecarecoa','".$locationnameget."','".$locationcodeget."')";
		$exec51=mysql_query($query51) or die(mysql_error());
			}
		}
		}
		
			if(isset($_POST['privatedoctor']))
		{
		foreach($_POST['privatedoctor'] as $key=>$value)
		{
				    //echo '<br>'.$k;

		$privatedoctor=$_POST['privatedoctor'][$key];
		$privatedoctor=trim($privatedoctor);
		$privatedoctorrate=$_POST['privatedoctorrate'][$key];
	    $privatedoctoramount=$_POST['privatedoctoramount'][$key];
		$privatedoctorquantity=$_POST['privatedoctorquantity'][$key];
		
		$query13 = "select id from master_accountname where accountname = '$privatedoctor'";
		$exec13 = mysql_query($query13) or die (mysql_error());
		$res13 = mysql_fetch_array($exec13);
		$doccoa = $res13['id'];
		
		if($patientbilltype == 'PAY NOW')
		{
		$stat = 'paid';
		}
		else
		{
		$stat = 'unpaid';
		}
			
		if($privatedoctor!="")
		{
		$query52 = "insert into billing_ipprivatedoctor(description,rate,quantity,amount,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa,billstatus,doctorstatus,billtype,creditcoa,debitcoa,locationname,locationcode,doccoa)values('$privatedoctor','$privatedoctorrate','$privatedoctorquantity','$privatedoctoramount','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$privatedoctorcoa','$stat','unpaid','$patientbilltype','$referalcode','$debitcoa','".$locationnameget."','".$locationcodeget."','$doccoa')";
		$exec52=mysql_query($query52) or die(mysql_error());
			}
		}
		}
		
		if(isset($_POST['nhifquantity']))
		{
		foreach($_POST['nhifquantity'] as $key=>$value)
		{
				    //echo '<br>'.$k;

		
		
		$nhifrate=$_POST['nhifrate'][$key];
	    $nhifamount=$_POST['nhifamount'][$key];
		$nhifquantity=$_POST['nhifquantity'][$key];
			
		if($nhifquantity!="")
		{
		$query53 = "insert into billing_ipnhif(rate,quantity,amount,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa,locationname,locationcode)values('$nhifrate','$nhifquantity','$nhifamount','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$nhifcoa','".$locationnameget."','".$locationcodeget."')";
		$exec53=mysql_query($query53) or die(mysql_error());
			}
		}
		}
		
		if(isset($_POST['otbilling']))
		{
		foreach($_POST['otbilling'] as $key=>$value)
		{
				    //echo '<br>'.$k;

		
		$otbilling=$_POST['otbilling'][$key];
		$otbillingrate=$_POST['otbillingrate'][$key];
	    $otbillingamount=$_POST['otbillingamount'][$key];
		
			
		if($otbilling!="")
		{
		$query54 = "insert into billing_ipotbilling(description,rate,quantity,amount,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa,locationname,locationcode)values('$otbilling','$otbillingrate','1','$otbillingamount','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$otbillingcoa','".$locationnameget."','".$locationcodeget."')";
		$exec54=mysql_query($query54) or die(mysql_error());
			}
		}
		}
		
		if(isset($_POST['miscbilling']))
		{
		foreach($_POST['miscbilling'] as $key=>$value)
		{
				    //echo '<br>'.$k;

		
		$miscbilling=$_POST['miscbilling'][$key];
		$miscbillingrate=$_POST['miscbillingrate'][$key];
	    $miscbillingamount=$_POST['miscbillingamount'][$key];
		$miscbillingquantity=$_POST['miscbillingquantity'][$key];
			
		if($miscbilling!="")
		{
		$query55 = "insert into billing_ipmiscbilling(description,rate,quantity,amount,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa,locationname,locationcode)values('$miscbilling','$miscbillingrate','miscbillingquantity','$miscbillingamount','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$miscbillingcoa','".$locationnameget."','".$locationcodeget."')";
		$exec55=mysql_query($query55) or die(mysql_error());
			}
		}
		}

		if(isset($_POST['admissionchargerate']))
		{
		foreach($_POST['admissionchargerate'] as $key=>$value)
		{
				    //echo '<br>'.$k;

		$admissionchargerate=$_POST['admissionchargerate'][$key];
	    $admissionchargeamount=$_POST['admissionchargeamount'][$key];
		
			
		if($admissionchargerate!="")
		{
		$query56 = "insert into billing_ipadmissioncharge(rate,quantity,amount,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa,locationname,locationcode)values('$admissionchargerate','1','$admissionchargeamount','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$admissionchargecoa','".$locationnameget."','".$locationcodeget."')";
		$exec56=mysql_query($query56) or die(mysql_error());
			}
		}
		}
		
		if(isset($_POST['mortuarypackagename']))
		{
			foreach($_POST['mortuarypackagename'] as $key=>$value)
			{
				$mortuarypackagename = $_POST['mortuarypackagename'][$key];
				$mortuarypackageamount = $_POST['mortuarypackageamount'][$key];
				$mortuarypackagecopayamount = $_POST['mortuarypackagecopayamount'][$key];
				$mortuarypackdays = $_POST['mortuarypackdays'][$key];
				$mortuarytotaldays = $_POST['mortuarytotaldays'][$key];
				$mortuarypackstartdate = $_POST['mortuarypackstartdate'][$key];
				
				$querymor = "INSERT INTO `billing_mortuary`(`docno`, `patientname`, `patientcode`, `visitcode`, `accountname`, `accountcode`, `packagename`, `packageamount`, `copay_packageamount`, `packdays`, `totaldays`, `packstartdate`, `recordtime`, `recordstatus`, `ipaddress`, `recorddate`, `username`) 
							VALUES ('$billno','$patientname','$patientcode','$visitcode','$accountname','$accountnameid','$mortuarypackagename','$mortuarypackageamount','$mortuarypackagecopayamount','$mortuarypackdays','$mortuarytotaldays','$mortuarypackstartdate','$currenttime','','$ipaddress','$currentdate','$username')";
				$execmor = mysql_query($querymor) or die ("Error in Querymor".mysql_error());			
			}
		}
		
		if(isset($_POST['shelvename']))
		{
			foreach($_POST['shelvename'] as $key=>$value)
			{
				$shelvename = $_POST['shelvename'][$key];
				$shelveamount = $_POST['shelveamount'][$key];
				$shelvecopayamount = $_POST['shelvecopayamount'][$key];
				$shelvedays = $_POST['shelvedays'][$key];
				$shelvetotaldays = $_POST['shelvetotaldays'][$key];
				$shelvestartdate = $_POST['shelvestartdate'][$key];
				
				$queryshl = "INSERT INTO `billing_mortuary`(`docno`, `patientname`, `patientcode`, `visitcode`, `accountname`, `accountcode`, `shelfname`, `shelfamount`, `copay_shelfamount`, `packdays`, `totaldays`, `packstartdate`, `recordtime`, `recordstatus`, `ipaddress`, `recorddate`, `username`) 
							VALUES ('$billno','$patientname','$patientcode','$visitcode','$accountname','$accountnameid','$shelvename','$shelveamount','$shelvecopayamount','$shelvedays','$shelvetotaldays','$shelvestartdate','$currenttime','','$ipaddress','$currentdate','$username')";
				$execshl = mysql_query($queryshl) or die ("Error in Queryshl".mysql_error());
			}
		}
		
		mysql_query("insert into billing_ip(billno,patientname,patientcode,visitcode,totalamount,billdate,accountname,subtype,patientbilltype,totalrevenue,discount,deposit,nhif,depositcoa,paymenttype,locationname,locationcode,accountnameano,accountnameid,subtypeano)values('$billno','$patientname','$patientcode','$visitcode','$totalamount','$currentdate','$accountname','$subtype','$patientbilltype','$totalrevenue','$discount','$deposit','$nhif','$ipdepositscoa','$paymenttype','".$locationnameget."','".$locationcodeget."','$accountnameano','$accountnameid','$subtypeano')") or die(mysql_error());
		
		$cash = $_REQUEST['cash'];
		$cheque = $_REQUEST['cheque'];
		$online = $_REQUEST['online'];
		$mpesa = $_REQUEST['mpesa'];
		$creditcard = $_REQUEST['creditcard'];
		$cashcode = '';
		$bankcode = '';
		$mpesacode = '';
		
		if($cash > 0)
		{
		$query55 = "select * from financialaccount where transactionmode = 'CASH'";
		 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
		 $res55 = mysql_fetch_array($exec55);
		 $cashcode = $res55['ledgercode'];
		} 
		if($cheque > 0)
		{
		$query55 = "select * from financialaccount where transactionmode = 'CHEQUE'";
		 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
		 $res55 = mysql_fetch_array($exec55);
		 $bankcode = $res55['ledgercode'];
		} 
		if($online > 0)
		{
		$query55 = "select * from financialaccount where transactionmode = 'ONLINE'";
		 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
		 $res55 = mysql_fetch_array($exec55);
		 $bankcode = $res55['ledgercode'];
		}
		if($creditcard > 0)
		{
		$query55 = "select * from financialaccount where transactionmode = 'CREDITCARD'";
		 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
		 $res55 = mysql_fetch_array($exec55);
		 $bankcode = $res55['ledgercode'];
		}
		if($mpesa > 0)
		{
		$query55 = "select * from financialaccount where transactionmode = 'MPESA'";
		 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
		 $res55 = mysql_fetch_array($exec55);
		 $mpesacode = $res55['ledgercode'];
		}
		
		
		$query43="insert into master_transactionip(patientname,patientcode,visitcode,transactiondate,accountname,billnumber,ipaddress,companyanum,companyname,transactiontype,paymenttype,subtype,transactionamount,username,transactiontime,cashamount,chequeamount,onlineamount,cardamount,mpesaamount,chequenumber,onlinenumber,mpesanumber,creditcardnumber,locationname,locationcode,returnbalance,accountnameano,accountnameid,subtypeano,cashcode,bankcode,mpesacode,billtype)values('$patientname','$patientcode','$visitcode','$currentdate','$accountname','$billno','$ipaddress','$companyanum','$companyname','finalize','$paymenttype','$subtype','$totalamount','$username','$updatetime','$cash','$cheque','$online','$creditcard','$mpesa','$chequenumber','$onlinenumber','$mpesanumber','$creditcardnumber','$locationnameget','$locationcodeget','$returnbalance','$accountnameano','$accountnameid','$subtypeano','$cashcode','$bankcode','$mpesacode','$patientbilltype')";
	    $exec43=mysql_query($query43) or die("error in query43".mysql_error());	
			
		
		if($patientbilltype != 'PAY NOW')
		{
		$query431="insert into master_transactionpaylater(patientname,patientcode,visitcode,transactiondate,accountname,billnumber,ipaddress,companyanum,companyname,transactiontype,paymenttype,subtype,transactionamount,username,transactiontime,cashamount,chequeamount,onlineamount,cardamount,mpesaamount,chequenumber,onlinenumber,mpesanumber,creditcardnumber,locationname,locationcode,accountnameano,accountnameid,subtypeano,billbalanceamount,billamount)values('$patientname','$patientcode','$visitcode','$currentdate','$accountname','$billno','$ipaddress','$companyanum','$companyname','finalize','$paymenttype','$subtype','$totalamount','$username','$updatetime','$cash','$cheque','$online','$creditcard','$mpesa','$chequenumber','$onlinenumber','$mpesanumber','$creditcardnumber','".$locationnameget."','".$locationcodeget."','$accountnameano','$accountnameid','$subtypeano','$totalamount','$totalamount')";
	    $exec431=mysql_query($query431) or die("error in query431".mysql_error());		  
			  
		}
		$query64 = "update ip_bedallocation set paymentstatus='completed' where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec64 = mysql_query($query64) or die(mysql_error());
		
		$query691 = "update master_ipvisitentry set paymentstatus='completed',finalbillno='$billno' where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec691 = mysql_query($query691) or die(mysql_error());
		
		$query6412 = "update ip_discharge set paymentstatus='completed' where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec6412 = mysql_query($query6412) or die(mysql_error());
		
		$query6412c = "update newborn_motherdetails set ipbill='completed' where patientcode='$patientcode' and patientvisitcode='$visitcode'";
		$exec6412c = mysql_query($query6412c) or die(mysql_error());
	
	
	?>
    <script>
    function open_print(){
	window.open("print_ipfinalinvoice1.php?patientcode=<?php echo $patientcode;?>&&visitcode=<?php echo $visitcode?>&&billnumber=<?php echo $billno?>&&loc=<?php echo $locationcodeget?>", "_blank");
	window.location="ipbilling.php";
}
    </script>
    <?php
	echo '<script>open_print()</script>';
	//header("location:ipbilling.php?savedpatientcode=$patientcode&&savedvisitcode=$visitcode&&billnumber=$billno&&loc=$locationcodeget");
	exit;

}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == '1')
{
	$errmsg = "Success. Payment Entry Update Completed.";
}
if ($st == '2')
{
	$errmsg = "Failed. Payment Entry Not Completed.";
}


?>

<?php

if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }

$Querylab=mysql_query("select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'");
$execlab=mysql_fetch_array($Querylab);
 $patientage=$execlab['age'];
 $patientgender=$execlab['gender'];
 $patientbilltype = $execlab['billtype'];

$patienttype=$execlab['paymenttype'];
$querytype=mysql_query("select * from master_paymenttype where auto_number='$patienttype'");
$exectype=mysql_fetch_array($querytype);
$patienttype1=$exectype['paymenttype'];
$patientsubtype=$execlab['subtype'];
$querysubtype=mysql_query("select * from master_subtype where auto_number='$patientsubtype'");
$execsubtype=mysql_fetch_array($querysubtype);
$patientsubtype1=$execsubtype['subtype'];

$query32 = "select * from ip_discharge where patientcode='$patientcode' and visitcode='$visitcode'";
$exec32 = mysql_query($query32) or die(mysql_error());
$num32 = mysql_num_rows($exec32);

$queryv32 = "select * from newborn_motherdetails where mothervisitcode='$visitcode'";
$execv32 = mysql_query($queryv32) or die(mysql_error());
$numv32 = mysql_num_rows($execv32);

$queryc32 = "select * from newborn_motherdetails where mothervisitcode='$visitcode' and discharge='discharged'";
$execc32 = mysql_query($queryc32) or die(mysql_error());
$numc32 = mysql_num_rows($execc32);

$queryf32 = "select * from newborn_motherdetails where mothervisitcode='$visitcode' and ipbill <> '' and discharge='discharged'";
$execf32 = mysql_query($queryf32) or die(mysql_error());
$numf32 = mysql_num_rows($execf32);



?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$paylaterbillprefix = 'IPF-';
$paylaterbillsuffix = '-'.date('y');

$paylaterbillprefix1=strlen($paylaterbillprefix);
$query2 = "select * from billing_ip order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["billno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode =$paylaterbillprefix.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billno"];
	$billnumbercode = substr($billnumber,$paylaterbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = $paylaterbillprefix .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}


$billnumbercode .=$paylaterbillsuffix;
$query7641 = "select * from master_financialintegration where field='ipdeposits'";
$exec7641 = mysql_query($query7641) or die(mysql_error());
$res7641 = mysql_fetch_array($exec7641);

$ipdepositscoa = $res7641['code'];
$ipdepositscoaname = $res7641['coa'];
$ipdepositstype = $res7641['type'];
$ipdepositsselect = $res7641['selectstatus'];

$query76 = "select * from master_financialintegration where field='labipfinal'";
$exec76 = mysql_query($query76) or die(mysql_error());
$res76 = mysql_fetch_array($exec76);
$labcoa = $res76['code'];

$query761 = "select * from master_financialintegration where field='radiologyipfinal'";
$exec761 = mysql_query($query761) or die(mysql_error());
$res761 = mysql_fetch_array($exec761);

$radiologycoa = $res761['code'];

$query762 = "select * from master_financialintegration where field='serviceipfinal'";
$exec762 = mysql_query($query762) or die(mysql_error());
$res762 = mysql_fetch_array($exec762);

$servicecoa = $res762['code'];

$query763 = "select * from master_financialintegration where field='referalipfinal'";
$exec763 = mysql_query($query763) or die(mysql_error());
$res763 = mysql_fetch_array($exec763);

$referalcoa = $res763['code'];

$query764 = "select * from master_financialintegration where field='pharmacyipfinal'";
$exec764 = mysql_query($query764) or die(mysql_error());
$res764 = mysql_fetch_array($exec764);

$pharmacycoa = $res764['code'];

$query765 = "select * from master_financialintegration where field='cashipfinal'";
$exec765 = mysql_query($query765) or die(mysql_error());
$res765= mysql_fetch_array($exec765);

$cashcoa = $res765['code'];


$query766 = "select * from master_financialintegration where field='chequeipfinal'";
$exec766 = mysql_query($query766) or die(mysql_error());
$res766 = mysql_fetch_array($exec766);

$chequecoa = $res766['code'];


$query767 = "select * from master_financialintegration where field='mpesaipfinal'";
$exec767 = mysql_query($query767) or die(mysql_error());
$res767 = mysql_fetch_array($exec767);

$mpesacoa = $res767['code'];

$query768 = "select * from master_financialintegration where field='cardipfinal'";
$exec768 = mysql_query($query768) or die(mysql_error());
$res768 = mysql_fetch_array($exec768);

$cardcoa = $res768['code'];

$query769 = "select * from master_financialintegration where field='onlineipfinal'";
$exec769 = mysql_query($query769) or die(mysql_error());
$res769 = mysql_fetch_array($exec769);

$onlinecoa = $res769['code'];

$query770 = "select * from master_financialintegration where field='bedchargesipfinal'";
$exec770 = mysql_query($query770) or die(mysql_error());
$res770 = mysql_fetch_array($exec770);

$bedchargescoa = $res770['code'];

$query771 = "select * from master_financialintegration where field='rmoipfinal'";
$exec771 = mysql_query($query771) or die(mysql_error());
$res771 = mysql_fetch_array($exec771);

$rmocoa = $res771['code'];

$query772 = "select * from master_financialintegration where field='nursingipfinal'";
$exec772 = mysql_query($query772) or die(mysql_error());
$res772 = mysql_fetch_array($exec772);

$nursingcoa = $res772['code'];

$query773 = "select * from master_financialintegration where field='privatedoctoripfinal'";
$exec773 = mysql_query($query773) or die(mysql_error());
$res773= mysql_fetch_array($exec773);

$privatedoctorcoa = $res773['code'];

$query774 = "select * from master_financialintegration where field='ambulanceipfinal'";
$exec774 = mysql_query($query774) or die(mysql_error());
$res774= mysql_fetch_array($exec774);

$ambulancecoa = $res774['code'];

$query775 = "select * from master_financialintegration where field='nhifipfinal'";
$exec775 = mysql_query($query775) or die(mysql_error());
$res775= mysql_fetch_array($exec775);

$nhifcoa = $res775['code'];

$query776 = "select * from master_financialintegration where field='otbillingipfinal'";
$exec776 = mysql_query($query776) or die(mysql_error());
$res776= mysql_fetch_array($exec776);

$otbillingcoa = $res776['code'];

$query777 = "select * from master_financialintegration where field='miscbillingipfinal'";
$exec777 = mysql_query($query777) or die(mysql_error());
$res777= mysql_fetch_array($exec777);

$miscbillingcoa = $res777['code'];

$query778 = "select * from master_financialintegration where field='admissionchargeipfinal'";
$exec778 = mysql_query($query778) or die(mysql_error());
$res778= mysql_fetch_array($exec778);

$admissionchargecoa = $res778['code'];

$query779 = "select * from master_financialintegration where field='ippackagefinal'";
$exec779 = mysql_query($query779) or die(mysql_error());
$res779= mysql_fetch_array($exec779);

$packagecoa = $res779['code'];

?>

<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
<script src="js/jquery.min.js"></script>

<script>



function funcwardChange1()
{
	/*if(document.getElementById("ward").value == "1")
	{
		alert("You Cannot Add Account For CASH Type");
		document.getElementById("ward").focus();
		return false;
	}*/
	<?php 
	$query12 = "select * from master_ward where recordstatus=''";
	$exec12 = mysql_query($query12) or die ("Error in Query11".mysql_error());
	while ($res12 = mysql_fetch_array($exec12))
	{
	$res12wardanum = $res12["auto_number"];
	$res12ward = $res12["ward"];
	?>
	if(document.getElementById("ward").value=="<?php echo $res12wardanum; ?>")
	{
		document.getElementById("bed").options.length=null; 
		var combo = document.getElementById('bed'); 	
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Sub Type", ""); 
		<?php
		$query10 = "select * from master_bed where ward = '$res12wardanum' and recordstatus = ''";
		$exec10 = mysql_query($query10) or die ("error in query10".mysql_error());
		while ($res10 = mysql_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10bedanum = $res10['auto_number'];
		$res10bed = $res10["bed"];
		
		
		
		?>
			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10bed;?>", "<?php echo $res10bedanum;?>"); 
		<?php 
		
		}
		?>
	}
	<?php
	}
	?>	
}

function funcvalidation()
{
//alert('h');
if(document.getElementById("readytodischarge").checked == false)
{
alert("Please Click on Ready To Discharge");
return false;
}

}

function balancecalc()
{

var netpayable = document.getElementById("netpayable").value;
var cash = document.getElementById("cash").value;

var cheque = document.getElementById("cheque").value;
if(cheque != '')
{
funcchequenumbershow();
}
else
{
funcchequenumberhide();
}
var online = document.getElementById("online").value;
if(online != '')
{
funconlinenumbershow();
}
else
{
funconlinenumberhide();
}
var mpesa = document.getElementById("mpesa").value;
if(mpesa != '')
{
funcmpesanumbershow();
}
else
{
funcmpesanumberhide();
}
var creditcard = document.getElementById("creditcard").value;
if(creditcard != '')
{
funccreditcardnumbershow();
}
else
{
funccreditcardnumberhide();
}

if(cash == '')
{
cash = 0;
}
if(cheque == '')
{
cheque = 0;
}
if(online == '')
{
online = 0;
}
if(mpesa == '')
{
mpesa = 0;
}
if(creditcard == '')
{
creditcard = 0;
}

var balance = netpayable - (parseInt(cash)+parseInt(cheque)+parseInt(online)+parseInt(mpesa)+parseInt(creditcard));


if(balance < 0)
{

document.getElementById("balance").value = 0;
document.getElementById("returnbalance").value = balance.toFixed(2);
//return false;
}
else
{
document.getElementById("balance").value = balance.toFixed(2);
document.getElementById("returnbalance").value = 0;
//return false;
}
if(document.getElementById("balance").value ==0){
	document.getElementById("submit").disabled =false;
	}else{
		document.getElementById("submit").disabled =true;
		}

}

function funcchequenumbershow()
{

  if (document.getElementById("chequenumber") != null) 
     {
	 document.getElementById("chequenumber").style.display = 'none';
	}
	if (document.getElementById("chequenumber") != null) 
	  {
	  document.getElementById("chequenumber").style.display = '';
	 }
	  if (document.getElementById("chequenumber1") != null) 
     {
	 document.getElementById("chequenumber1").style.display = 'none';
	}
	if (document.getElementById("chequenumber1") != null) 
	  {
	  document.getElementById("chequenumber1").style.display = '';
	 }
}

function funcchequenumberhide()
{		
 if (document.getElementById("chequenumber") != null) 
	{
	document.getElementById("chequenumber").style.display = 'none';
	}	
	if (document.getElementById("chequenumber1") != null) 
	{
	document.getElementById("chequenumber1").style.display = 'none';
	}	
}

function funconlinenumbershow()
{

  if (document.getElementById("onlinenumber") != null) 
     {
	 document.getElementById("onlinenumber").style.display = 'none';
	}
	if (document.getElementById("onlinenumber") != null) 
	  {
	  document.getElementById("onlinenumber").style.display = '';
	 }
	  if (document.getElementById("onlinenumber1") != null) 
     {
	 document.getElementById("onlinenumber1").style.display = 'none';
	}
	if (document.getElementById("onlinenumber1") != null) 
	  {
	  document.getElementById("onlinenumber1").style.display = '';
	 }
}

function funconlinenumberhide()
{		
 if (document.getElementById("onlinenumber") != null) 
	{
	document.getElementById("onlinenumber").style.display = 'none';
	}	
	if (document.getElementById("onlinenumber1") != null) 
	{
	document.getElementById("onlinenumber1").style.display = 'none';
	}	
}

function funccreditcardnumbershow()
{

  if (document.getElementById("creditcardnumber") != null) 
     {
	 document.getElementById("creditcardnumber").style.display = 'none';
	}
	if (document.getElementById("creditcardnumber") != null) 
	  {
	  document.getElementById("creditcardnumber").style.display = '';
	 }
	  if (document.getElementById("creditcardnumber1") != null) 
     {
	 document.getElementById("creditcardnumber1").style.display = 'none';
	}
	if (document.getElementById("creditcardnumber1") != null) 
	  {
	  document.getElementById("creditcardnumber1").style.display = '';
	 }
}

function funccreditcardnumberhide()
{		
 if (document.getElementById("creditcardnumber") != null) 
	{
	document.getElementById("creditcardnumber").style.display = 'none';
	}	
	if (document.getElementById("creditcardnumber1") != null) 
	{
	document.getElementById("creditcardnumber1").style.display = 'none';
	}	
}

function funcmpesanumbershow()
{

  if (document.getElementById("mpesanumber") != null) 
     {
	 document.getElementById("mpesanumber").style.display = 'none';
	}
	if (document.getElementById("mpesanumber") != null) 
	  {
	  document.getElementById("mpesanumber").style.display = '';
	 }
	  if (document.getElementById("mpesanumber1") != null) 
     {
	 document.getElementById("mpesanumber1").style.display = 'none';
	}
	if (document.getElementById("mpesanumber1") != null) 
	  {
	  document.getElementById("mpesanumber1").style.display = '';
	 }
}

function funcmpesanumberhide()
{		
 if (document.getElementById("mpesanumber") != null) 
	{
	document.getElementById("mpesanumber").style.display = 'none';
	}	
	if (document.getElementById("mpesanumber1") != null) 
	{
	document.getElementById("mpesanumber1").style.display = 'none';
	}	
}

function funcOnLoadBodyFunctionCall()
{

if(document.getElementById("balance").value== 0){
	document.getElementById("submit").disabled= false;
}
funcchequenumberhide();
funconlinenumberhide();
funccreditcardnumberhide();
funcmpesanumberhide();
}

function validcheck()
{
if(document.getElementById("accountname").value == 'CASH')
{
var balance = document.getElementById("balance").value;
if(balance == '')
{
alert("Please Enter the Amount");
return false;
}
if(balance != 0.00)
{
alert("Balance is still pending, Pl collect fully before saving");
return false;
}
}
var discharge = document.getElementById("discharge").value;
if(discharge == 0)
{
alert("Please discharge the patient before finalization");
return false;
}

var splitbill = document.getElementById("splitbill").value;
if(discharge == 0)
{
alert("Please post Doctor bill first");
return false;
}

var mother = document.getElementById("mother").value;
var babydischarge = document.getElementById("babydischarge").value;
var babyfinalaize = document.getElementById("babyfinalaize").value;
if(mother == 1)
{
	if(babydischarge == 0)
	{
	alert("Please discharge the Baby before finalization");
	return false;
	}
	if(babyfinalaize == 0)
	{
	alert("Please finalize the Baby before finalization");
	return false;
	}	
}

if(document.getElementById('totalcopay').value > 0)
{
	alert("Please collect copay before finalization");
	return false;
}

var check = confirm("Are you sure to finalize the bill?\nOnce finalized, the patient's Visit will be closed permanently");
if(check == false)
{
return false;
}
if(check == true)
{
//printIPFinalInvoice();
}

if (confirm("Do You Want To Save The Record?")==false){return false;}
}

function printIPFinalInvoice()
 {
var popWin; 
popWin = window.open("print_ipfinalinvoice.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&billnumber=<?php echo $billnumbercode; ?>","_blank");
return true;
 }
 
 function checkrefundapproval(visitcode,patientcode)
{
	//alert('first');
$.ajax(
{
type:"get",
url:"ajax/ajaxgetrefundapproval.php?visitcode="+visitcode,

success: function(data){
	var getval=data;
	//alert(getval);
	if(getval==1)
	{
	alert('Request for refund is already done');
	//window.history.back();
	//document.referrer;	
	window.location.reload;
	
	}
	else
	{
		//alert('hai');
	//window.location("depositrefundrequest.php?patientcode="+patientcode+"&&visitcode="+visitcode);
	window.location.href = "depositrefundrequest.php?patientcode=" + patientcode + "&visitcode=" + visitcode;	
	}
	//$("#backup").val("Completed");
	//var set=setTimeout(function(){$("#backup").val("Back Up");},1000);
	}


}); 


}
  
  
  function coasearch(vsc,ptc)
{
	var vsc = vsc;
	//alert('ok');
	window.open("showdoctorsplitbill.php?visitcode="+vsc+"&&patientcode="+ptc,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}
</script>
<?php
function roundTo($number, $to){ 
    return round($number/$to, 0)* $to; 
} 

?>

<script type="text/javascript">
function ViewDr(patientcodes,visitcodes)
{
window.open("viewdoctorbill.php?patientcode="+patientcodes+"&&visitcode="+visitcodes,"OriginalWindowA25",'width=750,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
}

</script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
.bal
{
border-style:none;
background:none;
text-align:right;
font-weight:bold;
}
.bal1
{
border-style:none;
background:none;
text-align:center;
font-weight:bold;
}
.bali
{
text-align:right;
}
</style>
</head>


<script src="js/datetimepicker_css.js"></script>

<body onLoad="return funcOnLoadBodyFunctionCall()">
<form name="form1" id="form1" method="post" action="ipfinalinvoice.php" onSubmit="return validcheck();">	
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="14" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="14" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="14" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="14">&nbsp;</td>
  </tr>
  <tr>
    <td width="0%">&nbsp;</td>
   
    <td colspan="5" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      
	 
	
		<tr>
		<td>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
           <?php
		  
		  $locationnameget=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';
		   $query1 = "select locationcode,package from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		
		while($res1 = mysql_fetch_array($exec1))
		{
		
		
		$locationcodeget = $res1['locationcode'];
		$res2package = $res1["package"];
		$query551 = "select * from master_location where locationcode='".$locationcodeget."'";
		$exec551 = mysql_query($query551) or die(mysql_error());
		$res551 = mysql_fetch_array($exec551);
		$locationnameget = $res551['locationname'];
		}?>
             <tr>
						  <td colspan="4" class="bodytext31" bgcolor="#CCCCCC"><strong>IP Final Invoice</strong></td>
                            <td colspan="3" class="bodytext31" bgcolor="#CCCCCC"><strong>Location &nbsp;</strong><?php echo $locationnameget;?></td>
                  <input type="hidden" name="locationcodeget" value="<?php echo $locationcodeget?>">
				<input type="hidden" name="locationnameget" value="<?php echo $locationnameget?>">
						</tr>
            <tr>
              <td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Bill No</strong></div></td>
           
				 <td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient Name</strong></div></td>
           
				 <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Code  </strong></div></td>
				 <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>IP Visit  </strong></div></td>
				 <td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date</strong></div></td>
				<td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bill Type</strong></div></td>
				<td width="19%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Account</strong></div></td>
              </tr>
           <?php
            $colorloopcount ='';
		
		$query1 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		
		while($res1 = mysql_fetch_array($exec1))
		{
		$patientname=$res1['patientfullname'];
		$patientcode=$res1['patientcode'];
		$accountname = $res1['accountname'];
		$billtype = $res1['billtype'];
		$gender = $res1['gender'];
		$age = $res1['age'];
		$type = $res1['type'];
		
		$querymenu = "select subtype from master_customer where customercode='$patientcode'";
		$execmenu = mysql_query($querymenu) or die ("Error in Query1".mysql_error());
		$nummenu=mysql_num_rows($execmenu);
		
		$resmenu = mysql_fetch_array($execmenu);
		
		$menusub=$res1['subtype'];
		
		$query32 = "select subtype,bedtemplate,labtemplate,radtemplate,sertemplate from master_subtype where auto_number = '".$menusub."'";
		$exec32 = mysql_query($query32) or die ("Error in Query2".mysql_error());
	//	$res2 = mysql_num_rows($exec2);
		$mastervalue = mysql_fetch_array($exec32);
		//$currency=$mastervalue['currency'];
		//$fxrate=$mastervalue['fxrate'];
		$subtype=$mastervalue['subtype'];
		$bedtemplate=$mastervalue['bedtemplate'];
		$labtemplate=$mastervalue['labtemplate'];
		$radtemplate=$mastervalue['radtemplate'];
		$sertemplate=$mastervalue['sertemplate'];
		
		$querytt32 = "select * from master_testtemplate where templatename='$bedtemplate'";
		$exectt32 = mysql_query($querytt32) or die(mysql_error());
		$numtt32 = mysql_num_rows($exectt32);
		$exectt=mysql_fetch_array($exectt32);
		$bedtable=$exectt['referencetable'];
		if($bedtable=='')
		{
			$bedtable='master_bed';
		}
		$bedchargetable=$exectt['templatename'];
		if($bedchargetable=='')
		{
			$bedchargetable='master_bedcharge';
		}
		
		$query813 = "select * from ip_discharge where visitcode='$visitcode' and patientcode='$patientcode'";
		$exec813 = mysql_query($query813) or die(mysql_error());
		$res813 = mysql_fetch_array($exec813);
		$num813 = mysql_num_rows($exec813);
		if($num813 > 0)
		{
		$updatedate=$res813['recorddate'];
		}
			
		
		$query67 = "select * from master_accountname where auto_number='$accountname'";
		$exec67 = mysql_query($query67); 
		$res67 = mysql_fetch_array($exec67);
		$accname = $res67['accountname'];
		$accountnameid = $res67['id'];
		
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
             <td align="left" valign="center" class="bodytext31">
			    <div align="center"><?php echo $billnumbercode; ?></div></td>
			
			  <td align="left" valign="center" class="bodytext31">
			    <div align="center"><?php echo $patientname; ?></div></td>
				<td align="center" valign="center" class="bodytext31"><?php echo $patientcode; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $visitcode; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $updatedate; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $billtype; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $accname; ?></td>
				<input type="hidden" name="patientname" id="patientname" value="<?php echo $patientname; ?>">
				<input type="hidden" name="packagecoa" value="<?php echo $packagecoa; ?>">
				<input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>">
				<input type="hidden" name="ipdepositscoa" value="<?php echo $ipdepositscoa; ?>">
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
				<input type="hidden" name="bedchargescoa" value="<?php echo $bedchargescoa; ?>">
				<input type="hidden" name="rmocoa" value="<?php echo $rmocoa; ?>">
				<input type="hidden" name="nursingcoa" value="<?php echo $nursingcoa; ?>">
				<input type="hidden" name="privatedoctorcoa" value="<?php echo $privatedoctorcoa; ?>">
				<input type="hidden" name="ambulancecoa" value="<?php echo $ambulancecoa; ?>">
				<input type="hidden" name="nhifcoa" value="<?php echo $nhifcoa; ?>">
				<input type="hidden" name="otbillingcoa" value="<?php echo $otbillingcoa; ?>">
				<input type="hidden" name="miscbillingcoa" value="<?php echo $miscbillingcoa; ?>">
				<input type="hidden" name="admissionchargecoa" value="<?php echo $admissionchargecoa; ?>">
				<input type="hidden" name="patientbilltype" value="<?php echo $patientbilltype; ?>">
				<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>">
			
				<input type="hidden" name="accountname" id="accountname" value="<?php echo $accname; ?>">
                <input type="hidden" name="accountnameano" id="accountnameano" value="<?php echo $accountname; ?>">
                <input type="hidden" name="accountnameid" id="accountnameid" value="<?php echo $accountnameid; ?>">
				<input type="hidden" name="subtype" id="subtype" value="<?php echo $patientsubtype1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>	
                <input type="hidden" name="subtypeano" id="subtypeano" value="<?php echo $patientsubtype; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>	
				<input type="hidden" name="paymenttype" id="paymenttype" value="<?php echo $patienttype1; ?>">	
				<input type="hidden" name="discharge" id="discharge" value="<?php echo $num32; ?>">	
				<input type="hidden" name="babydischarge" id="babydischarge" value="<?php echo $numc32; ?>">
				<input type="hidden" name="babyfinalaize" id="babyfinalaize" value="<?php echo $numf32; ?>">	
				<input type="hidden" name="mother" id="mother" value="<?php echo $numv32; ?>">
               
                	
			   </tr>
		   <?php 
		   } 
		  
		   ?>
            </tbody>
        </table>		</td>
		</tr>
		
		</table>		</td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		<td width="7%">&nbsp;</td>
		<?php if($num32 == '0') {?>
        <td bgcolor="#FA5858" class="bodytext311" align="left">Patient is not yet discharged. Hence can not finalize the bill</td>
		<?php }else {?>
		<td>&nbsp;</td>
		<?php } ?>
		</tr>
		
		<?php 
		if($numv32 == '1') {
			if($numc32 == '0') { ?>
			<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td bgcolor="#cc99ff" class="bodytext311" align="left">Baby is not yet discharged. Hence can not finalize the bill</td>
			<td>&nbsp;</td>
			</tr>
			<?php } else if($numf32 == '0'){?>
			<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td bgcolor="#cc99ff" class="bodytext311" align="left">Baby is not yet Finalized. Hence can not finalize the bill</td>
			<td>&nbsp;</td>
			</tr>
			<?php }
		} ?>
	<tr>
    
		<?php $numpr=0;
		if($res2package != 0) {
			$query112 = "select * from privatedoctor_billing where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysql_query($query112) or die(mysql_error());
			$privno = mysql_num_rows($exec112);
			
			$query112 = "select * from residentdoctor_billing where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysql_query($query112) or die(mysql_error());
			$resno = mysql_num_rows($exec112);
			$numpr = $privno+$resno;
			if($numpr == '0') { ?>
			<!--<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td bgcolor="#cc99ff" class="bodytext311" align="left">Please do the Doctor bill first</td>
			<td>&nbsp;</td>
			</tr>-->
			
			<?php }
			if($numpr > '0')
			{
			?>
			<!--<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td bgcolor="#cc99ff" class="bodytext311" align="left"><strong>Doctor Bill Posted. &nbsp; <a id="myLink" href="#" onClick="return ViewDr('<?php echo $patientcode; ?>','<?php echo $visitcode; ?>');">Click to see</a></strong></td>
			<td>&nbsp;</td>
			</tr>-->
			<?php
			}
		} ?>
         <input type="hidden" name="splitbill" id="splitbill" value="<?php echo $numpr; ?>">	
	<tr>
	
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td width="60%">
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
           <tr bgcolor="#011E6A">
                <td colspan="8" bgcolor="#CCCCCC" class="bodytext31"><strong>Transaction Details</strong></td>
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
					<td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount </strong></div></td>
                  </tr>
				  		<?php
			$colorloopcount = '';
			$sno = '';  
			$totalamount=0;
			$totalquantity = 0;
			$totalop =0;
			$totalcopay = 0;
			$query17 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec17 = mysql_query($query17) or die ("Error in Query1".mysql_error());
			$res17 = mysql_fetch_array($exec17);
			$consultationfee=$res17['admissionfees'];
			$consultationfee = number_format($consultationfee,2,'.','');
			$viscode=$res17['visitcode'];
			$consultationdate=$res17['consultationdate'];
			$packchargeapply = $res17['packchargeapply'];
			$packageanum1 = $res17['package'];
			$accountnum = $res17['accountname'];
			
			$querycop = "select lab_copay,radiology_copay,service_copay,pharmacy_copay,bed_copay,nursing_copay,rmo_copay,package_copay,misc_copay,ambulance_copay,mortuary_copay from master_copayaccount where accountnameano='$accountnum' and recordstatus <>'DELETED'";
			$execcop = mysql_query($querycop) or die(mysql_error());
			$rescop = mysql_fetch_array($execcop);
			$lab_copay = $rescop['lab_copay'];
			$radiology_copay = $rescop['radiology_copay'];
			$service_copay = $rescop['service_copay'];
			$pharmacy_copay = $rescop['pharmacy_copay'];
			$bed_copay = $rescop['bed_copay'];
			$nursing_copay = $rescop['nursing_copay'];
			$rmo_copay = $rescop['rmo_copay'];
			$package_copay = $rescop['package_copay'];
			$misc_copay = $rescop["misc_copay"];
			$ambulance_copay = $rescop["ambulance_copay"];
			$mortuary_copay = $rescop["mortuary_copay"];
			$copayyes = $lab_copay+$radiology_copay+$service_copay+$pharmacy_copay+$bed_copay+$nursing_copay+$rmo_copay+$package_copay+$misc_copay+$ambulance_copay+$mortuary_copay;
			
			
			$query53 = "select * from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec53 = mysql_query($query53) or die(mysql_error());
			$res53 = mysql_fetch_array($exec53);
			$refno = $res53['docno'];
			
			if($packageanum1 != 0)
			{
			if($packchargeapply == 1)
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
			$totalop=$consultationfee;
			?>
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Admission Charge'; ?></div></td>
			     <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
				  	 <input type="hidden" name="admissionchargerate[]" id="admissionchargerate" value="<?php echo $consultationfee; ?>">
			 <input type="hidden" name="admissionchargeamount[]" id="admissionchargeamount" value="<?php echo $consultationfee; ?>">
			
	
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($consultationfee,2,'.',','); ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $consultationfee; ?></div></td>
           	</tr>
			<?php
			}
			}
			else
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
			$totalop=$consultationfee;
			?>
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Admission Charge'; ?></div></td>
			     <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
				 		  	 <input type="hidden" name="admissionchargerate[]" id="admissionchargerate" value="<?php echo $consultationfee; ?>">
			 <input type="hidden" name="admissionchargeamount[]" id="admissionchargeamount" value="<?php echo $consultationfee; ?>">
	
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($consultationfee,2,'.',','); ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $consultationfee; ?></div></td>
           	</tr>
			<?php
			}
			
			?>
					  <?php
					  $packageamount = 0;
			 $query731 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec731 = mysql_query($query731) or die(mysql_error());
			$res731 = mysql_fetch_array($exec731);
			$packageanum1 = $res731['package'];
			$packagedate1 = $res731['consultationdate'];
			$packageamount = $res731['packagecharge'];
			
			$query741 = "select * from master_ippackage where auto_number='$packageanum1'";
			$exec741 = mysql_query($query741) or die(mysql_error());
			$res741 = mysql_fetch_array($exec741);
			$packdays1 = $res741['days'];
			$packagename = $res741['packagename'];
			
			
			if($packageanum1 != 0)
	{
	
	 $reqquantity = $packdays1;
	 
	 $reqdate = date('Y-m-d',strtotime($packagedate1) + (24*3600*$reqquantity));
	 
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
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $packagedate1; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $visitcode; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left" <?php if($res2package!=0){?> style=" cursor:pointer"onClick="coasearch('<?php echo $visitcode?>','<?php echo $patientcode?>')" <?php }?>><?php echo $packagename; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
			 <input type="hidden" name="description[]" id="description" value="<?php echo $packagename; ?>">
			 <input type="hidden" name="descriptionrate[]" id="descriptionrate" value="<?php echo $packageamount; ?>">
			 <input type="hidden" name="descriptionamount[]" id="descriptionamount" value="<?php echo $packageamount; ?>">
			 <input type="hidden" name="descriptionquantity[]" id="descriptionquantity" value="<?php echo '1'; ?>">
			  <input type="hidden" name="descriptiondocno[]" id="descriptiondocno" value="<?php echo $visitcode; ?>">
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($packageamount,2,'.',','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($packageamount,2,'.',','); ?></div></td>
			  </tr>
			  <?php
			  }
			  ?>
			 
			   <?php 
			   $totalbedallocationamount=0;
				$query18 = "select ward,bed,docno,recorddate,leavingdate,recordstatus from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";
				$exec18 = mysql_query($query18) or die ("Error in Query1".mysql_error());
				while($res18 = mysql_fetch_array($exec18))
				{
					$querybedtr = "select visitcode from ip_bedtransfer where visitcode='$visitcode' and patientcode='$patientcode'";
					$execbedtr = mysql_query($querybedtr) or die ("Error in Querybedtr".mysql_error());
					$rowbedtr = mysql_num_rows($execbedtr);
					
					$ward = $res18['ward'];
					$allocateward = $res18['ward'];			
					$bed = $res18['bed'];
					$refno = $res18['docno'];
					$date = $res18['recorddate'];
					$bedallocateddate = $res18['recorddate'];
					$packagedate = $res18['recorddate'];
					$leavingdate = $res18['leavingdate'];
					$recordstatus = $res18['recordstatus'];
					if($leavingdate=='0000-00-00')
					{
						$leavingdate=$updatedate;
					}
					$query51 = "select bed,threshold from `$bedtable` where auto_number='$bed'";
					$exec51 = mysql_query($query51) or die(mysql_error());
					$res51 = mysql_fetch_array($exec51);
					$bedname = $res51['bed'];
					$threshold = $res51['threshold'];
					$thresholdvalue = $threshold/100;
					$time1 = new DateTime($bedallocateddate);
					$time2 = new DateTime($leavingdate);
					$interval = $time1->diff($time2);			  
					$quantity1 = $interval->format("%a");
					if($packdays1>$quantity1)
					{
						$quantity1=$quantity1-$packdays1; 
						$packdays1=$packdays1-$quantity1;
					}
					else
					{
						$quantity1=$quantity1-$packdays1;
						$packdays1=0;
					}
					$quantity='0';
					$diff = abs(strtotime($leavingdate) - strtotime($bedallocateddate));
					$query91 = "select charge,rate from `$bedchargetable` where bedanum='$bed' and recordstatus ='' and charge not in ('Accommodation Charges','Cafetaria Charges')";
					$exec91 = mysql_query($query91) or die(mysql_error());
					$num91 = mysql_num_rows($exec91);
					while($res91 = mysql_fetch_array($exec91))
					{
						$charge = $res91['charge'];
						$rate = $res91['rate'];	
						
						if($charge!='Bed Charges')
						{
							$quantity=$quantity1+1;
						}
						else
						{
							if($recordstatus=='discharged')
							{
								if($bedallocateddate==$leavingdate)
								{
									$quantity=$quantity1+1;
								}
								else
								{
									$quantity=$quantity1;
								}
							}
							else
							{
								$quantity=$quantity1;
							}
						}
						$amount = $quantity * $rate;						
						$allocatequantiy = $quantity;
						$allocatenewquantity = $quantity;
						if($quantity>=0)
						{
							if($type=='hospital'||$charge!='Resident Doctor Charges')
							{
								$colorloopcount = $sno + 1;
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
								
								if($charge == 'Bed Charges')
								{
									$bcopay = $bed_copay;
								}
								else if($charge == 'Nursing Charges')
								{
									$bcopay = $nursing_copay;
								}
								else if($charge == 'RMO Charges')
								{
									$bcopay = $rmo_copay;
								}
								else
								{
									$bcopay = 0;
								}
								if($bcopay > 0){
								$bedratecopay = $rate * ($bcopay / 100); } else {
								$bedratecopay = 0; }
								$bedrate = $rate - $bedratecopay;
								
								$totalcopay = $totalcopay + ($bedratecopay*$quantity);
								
					  ?>
					  <?php if($rowbedtr == 0) 
					  { 
					  $totalbedallocationamount=$totalbedallocationamount+$amount;
					  ?>
								<tr <?php echo $colorcode; ?>>
									<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $bedallocateddate; ?></div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $charge; ?>(<?php echo $bedname; ?>)</div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $quantity; ?></div></td>
									<input type="hidden" name="descriptioncharge[]" id="descriptioncharge" value="<?php echo $charge; ?>">
									<input type="hidden" name="descriptionchargerate[]" id="descriptionchargerate" value="<?php echo $rate; ?>">
									<input type="hidden" name="descriptionchargeamount[]" id="descriptionchargeamount" value="<?php echo $amount; ?>">
									<input type="hidden" name="descriptionchargequantity[]" id="descriptionchargequantity" value="<?php echo $quantity; ?>">
									<input type="hidden" name="descriptionchargedocno[]" id="descriptionchargedocno" value="<?php echo $refno; ?>">
									<input type="hidden" name="descriptionchargeward[]" id="descriptionchargeward" value="<?php echo $ward; ?>">
									<input type="hidden" name="descriptionchargebed[]" id="descriptionchargebed" value="<?php echo $bed; ?>">
									<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($bedrate,2,'.',','); ?></div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($bedrate*$quantity,2,'.',','); ?></div></td>
								</tr>              
					   <?php } 
					   if($bcopay > 0) { ?>
					   <tr <?php echo $colorcode; ?>>
									<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $bedallocateddate; ?></div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $charge; ?>(<?php echo $bedname; ?>) Copay</div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $quantity; ?></div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($bedratecopay,2,'.',','); ?></div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($bedratecopay*$quantity,2,'.',','); ?></div></td>
								</tr>   
					   <?php
					   }
					   ?>
					   <?php 
							}
						}
					}
				}
				
				$bedalloc_qty = $quantity-1;
				$totalbedtransferamount=0;
				$query18 = "select ward,bed,docno,recorddate,leavingdate,recordstatus from ip_bedtransfer where visitcode='$visitcode' and patientcode='$patientcode'";
				$exec18 = mysql_query($query18) or die ("Error in Query1".mysql_error());
				while($res18 = mysql_fetch_array($exec18))
				{
					$quantity1=0;
					$ward = $res18['ward'];
					$allocateward = $res18['ward'];			
					$bed = $res18['bed'];
					$refno = $res18['docno'];
					$date = $res18['recorddate'];
					//$bedallocateddate = $res18['recorddate'];
					$packagedate = $res18['recorddate'];
					$leavingdate = $res18['leavingdate'];
					$recordstatus = $res18['recordstatus'];
					if($leavingdate=='0000-00-00')
					{
						$leavingdate=$updatedate;
					}
					$query51 = "select bed,threshold from master_bed where auto_number='$bed'";
					$exec51 = mysql_query($query51) or die(mysql_error());
					$res51 = mysql_fetch_array($exec51);
					$bedname = $res51['bed'];
					$threshold = $res51['threshold'];
					$thresholdvalue = $threshold/100;
					$time1 = new DateTime($date);
					$time2 = new DateTime($leavingdate);
					$interval = $time1->diff($time2);			  
					$quantity1 = $interval->format("%a");
					if($packdays1>$quantity1)
					{
						$quantity1=$quantity1-$packdays1; 
						$packdays1=$packdays1-$quantity1;
					}
					else
					{
						$quantity1=$quantity1-$packdays1;
						$packdays1=0;
					}
					$quantity='0';
					$bedcharge='0';
					$diff = abs(strtotime($leavingdate) - strtotime($bedallocateddate));
					$query91 = "select charge,rate from `$bedchargetable` where bedanum='$bed' and recordstatus ='' and charge not in ('Accommodation Charges','Cafetaria Charges')";
					$exec91 = mysql_query($query91) or die(mysql_error());
					$num91 = mysql_num_rows($exec91);
					while($res91 = mysql_fetch_array($exec91))
					{
						$charge = $res91['charge'];
						$rate = $res91['rate'];	
						
						if($charge!='Bed Charges')
						{
							$quantity=$quantity1+1;
						}
						else
						{
							if($recordstatus=='discharged')
							{
								if($bedallocateddate==$leavingdate)
								{
									$quantity=$quantity1+1;
								}
								else
								{
									$quantity=$quantity1;
								}
							}
							else
							{
								$quantity=$quantity1;
							}
						}
						
						$quantity = $quantity+$bedalloc_qty;
						$amount = $quantity * $rate;						
						$allocatequantiy = $quantity;
						$allocatenewquantity = $quantity;
						if($bedcharge=='0')
						{
							if($quantity>0)
							{
								if($type=='hospital'||$charge!='Resident Doctor Charges')
								{
									$colorloopcount = $sno + 1;
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
									
									if($charge == 'Bed Charges')
									{
										$bcopay = $bed_copay;
									}
									else if($charge == 'Nursing Charges')
									{
										$bcopay = $nursing_copay;
									}
									else if($charge == 'RMO Charges')
									{
										$bcopay = $rmo_copay;
									}
									else
									{
										$bcopay = 0;
									}
									if($bcopay > 0){
									$bedratecopay = $rate * ($bcopay / 100); } else {
									$bedratecopay = 0; }
									$bedrate = $rate - $bedratecopay;
									$totalcopay = $totalcopay + ($bedratecopay*$quantity);
									
									$totalbedtransferamount=$totalbedtransferamount+$amount;
						  ?>
									<tr <?php echo $colorcode; ?>>
										<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
										<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $date; ?></div></td>
										<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
										<td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $charge; ?>(<?php echo $bedname; ?>)</div></td>
										<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $quantity; ?></div></td>
										<input type="hidden" name="descriptioncharge[]" id="descriptioncharge" value="<?php echo $charge; ?>">
										<input type="hidden" name="descriptionchargerate[]" id="descriptionchargerate" value="<?php echo $rate; ?>">
										<input type="hidden" name="descriptionchargeamount[]" id="descriptionchargeamount" value="<?php echo $amount; ?>">
										<input type="hidden" name="descriptionchargequantity[]" id="descriptionchargequantity" value="<?php echo $quantity; ?>">
										<input type="hidden" name="descriptionchargedocno[]" id="descriptionchargedocno" value="<?php echo $refno; ?>">
										<input type="hidden" name="descriptionchargeward[]" id="descriptionchargeward" value="<?php echo $ward; ?>">
										<input type="hidden" name="descriptionchargebed[]" id="descriptionchargebed" value="<?php echo $bed; ?>">
										<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($bedrate,2,'.',','); ?></div></td>
										<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($bedrate*$quantity,2,'.',','); ?></div></td>
									</tr>  
									<?php            
						 			if($bcopay > 0) { ?>
									<tr <?php echo $colorcode; ?>>
										<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
										<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $bedallocateddate; ?></div></td>
										<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
										<td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $charge; ?>(<?php echo $bedname; ?>) Copay</div></td>
										<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $quantity; ?></div></td>
										<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($bedratecopay,2,'.',','); ?></div></td>
										<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($bedratecopay*$quantity,2,'.',','); ?></div></td>
									</tr>   
								   <?php
								   }
								   ?>             
						 
						   <?php 
								}
							}
							else
							{
								if($charge=='Bed Charges')
								{
									$bedcharge='1';
								}
							}
						}
					}
				} 
				?>
				<?php
			$totalnhifamount = 0;
			$originalmor=0;
			$copaytotalbed = 0;
			$totalshelfamount = 0;
			$query641 = "select * from mortuary_allocation where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec641 = mysql_query($query641) or die(mysql_error());
			$num121=mysql_num_rows($exec641);
			while($res641= mysql_fetch_array($exec641))
		   {
			 $nhifdate = $res641['recorddate'];
			//echo $mortuaryupdatedate;
			$nhifrefno = $res641['docno'];
			$package = $res641['package'];
			$shelve = $res641['shelve'];
			
			$query642 = "select shelfcharges from master_shelf where shelf like '%$shelve%'";
			$exec642 = mysql_query($query642) or die(mysql_error());
			$res642= mysql_fetch_array($exec642);
			$shelfcharges = $res642['shelfcharges'];
			
		    $diff = abs(strtotime($nhifdate) - strtotime($mortuaryupdatedate));
			
			
			$years = floor($diff / (365*60*60*24));
			$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
			$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
			$days=$days+1;
			
			
			$shelfamount=$shelfcharges * $days;
			
			if($package!='')
			{
			 $query6430 = "select total,days from master_mortuarypackage where packagename like '%$package%'";
			$exec6430 = mysql_query($query6430) or die(mysql_error());
			$res6430= mysql_fetch_array($exec6430);
			$packagecharges = $res6430['total'];			
			$packagedays = $res6430['days'];
						$amount=$packagecharges;	

			}
						
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
			if($num121!=0)
			{
			if($package!='')
			{
				
				//copay starts
			//$originalmiscbillingamount = $originalmiscbillingamount + $miscbillingamount;
			$originalamount =  $amount;
			
				 if(($mortuary_copay<100.00)&&($mortuary_copay>0.00))
				{ 
					$insumor_copay=100-$mortuary_copay;
					$amount=($originalamount/100)*$insumor_copay;
					//$miscbillingamount=($originalmiscbillingamount1/100)*$insumis_copay;
				}
				if($mortuary_copay>=100.00){$amount=0;}
			
			//copay end
			$mortuarypackageamount = $amount;
		
			$copayamount2 = ($originalamount/100)*$mortuary_copay;
			?>
            <?php if($mortuary_copay<100){?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"> <?php echo $package; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
                  
             <td class="bodytext31" valign="center"  align="left"><div align="right">
			<?php echo number_format($amount,2,'.',','); ?></div>
                <input type="hidden" name="mortuarypackagename[]" id="mortuarypackagename" value="<?php echo $package; ?>">
				<input type="hidden" name="mortuarypackageamount[]" id="mortuarypackageamount" value="<?php echo $amount; ?>">
				<input type="hidden" name="mortuarypackagecopayamount[]" id="mortuarypackagecopayamount" value="<?php echo $copayamount2; ?>">
				<input type="hidden" name="mortuarypackdays[]" id="mortuarypackdays" value="<?php echo $packagedays; ?>">
				<input type="hidden" name="mortuarytotaldays[]" id="mortuarytotaldays" value="<?php echo $days; ?>">
				<input type="hidden" name="mortuarypackstartdate[]" id="mortuarypackstartdate" value="<?php echo $nhifdate; ?>"></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
			    </tr>
                <?php
				$totalshelfamount = $totalshelfamount + $amount;
				 }?>
                 <?php if($mortuary_copay>0.00){
				  $copayamount = ($originalamount/100)*$mortuary_copay;
				   //$copayamount = $copayrate*$quantity;
				   $copaytotalbed = $copaytotalbed + $copayamount;
			  ?>
               <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"> <?php echo $package ,' COPAY'; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
                 
             <td class="bodytext31" valign="center"  align="left"><div align="right">
               <?php echo number_format($copayamount,2); ?>
             </div></td>
             
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copayamount,2,'.',','); ?></div></td>
			 </tr>
			  <?php
			  $totalshelfamount = $totalshelfamount + $copayamount;
			   }?>
                
				<?php
			}
			else
			{
				$originalshelfcharges =  $shelfcharges;
				$originalshelfamount =  $shelfamount;
			
				 if(($mortuary_copay<100.00)&&($mortuary_copay>0.00))
				{ 
					$insushel_copay=100-$mortuary_copay;
					$shelfcharges=($originalshelfcharges/100)*$insushel_copay;
					$shelfamount=($originalshelfamount/100)*$insushel_copay;
				}
				if($mortuary_copay>=100.00){$amount=0;}
				
				$copayshelfamount3 = ($originalshelfamount/100)*$mortuary_copay;
				if($mortuary_copay<100){?>
                
			 <tr <?php echo $colorcode; ?>>
             
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"> <?php echo $shelve; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $days; ?></div>
				 <input type="hidden" name="shelvename[]" id="shelvename" value="<?php echo $shelve; ?>">
				<input type="hidden" name="shelveamount[]" id="shelveamount" value="<?php echo $shelfamount; ?>">
				<input type="hidden" name="shelvecopayamount[]" id="shelvecopayamount" value="<?php echo $copayshelfamount3; ?>">
				<input type="hidden" name="shelvedays[]" id="shelvedays" value="<?php echo $days; ?>">
				<input type="hidden" name="shelvetotaldays[]" id="shelvetotaldays" value="<?php echo $days; ?>">
				<input type="hidden" name="shelvestartdate[]" id="shelvestartdate" value="<?php echo $nhifdate; ?>">
				 </td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($shelfcharges,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($shelfamount,2,'.',','); ?></div></td>
			    </tr>
                <?php
				$totalshelfamount = $totalshelfamount + $shelfamount;
				 }?>
                 <?php if($mortuary_copay>0.00){
				  $copayshelfcharges = ($originalshelfcharges/100)*$mortuary_copay;
				  $copayshelfamount = ($originalshelfamount/100)*$mortuary_copay;
				   //$copayamount = $copayrate*$quantity;
				   $copaytotalbed = $copaytotalbed + $copayshelfamount;
			  ?>
                <tr <?php echo $colorcode; ?>>
             
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"> <?php echo $shelve,' COPAY' ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $days; ?></div></td>
                 
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copayshelfcharges,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copayshelfamount,2,'.',','); ?></div></td>
			    </tr>
              <?php 
			  $totalshelfamount = $totalshelfamount + $copayshelfamount;
			  }?>
				<?php

			}
			if($package!='')
			{
			if($days> $packagedays)
			{
				
			$daysafterpackage=$days-$packagedays+1;
			
			$shelfamount=$shelfcharges*$daysafterpackage;
			
			    $originalshelfcharges =  $shelfcharges;
				$originalshelfamount =  $shelfamount;
			
				 if(($mortuary_copay<100.00)&&($mortuary_copay>0.00))
				{ 
					$insushel_copay=100-$mortuary_copay;
					$shelfcharges=($originalshelfcharges/100)*$insushel_copay;
					$shelfamount=($originalshelfamount/100)*$insushel_copay;
				}
				if($mortuary_copay>=100.00){$amount=0;}
				
				$copayshelfamount3 = ($originalshelfamount/100)*$mortuary_copay;
				if($mortuary_copay<100){
				?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"> <?php echo $shelve ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $daysafterpackage; ?></div>
                 <input type="hidden" name="shelvename[]" id="shelvename" value="<?php echo $shelve; ?>">
				<input type="hidden" name="shelveamount[]" id="shelveamount" value="<?php echo $shelfamount; ?>">
				<input type="hidden" name="shelvecopayamount[]" id="shelvecopayamount" value="<?php echo $copayshelfamount3; ?>">
				<input type="hidden" name="shelvedays[]" id="shelvedays" value="<?php echo $daysafterpackage; ?>">
				<input type="hidden" name="shelvetotaldays[]" id="shelvetotaldays" value="<?php echo $daysafterpackage; ?>">
				<input type="hidden" name="shelvestartdate[]" id="shelvestartdate" value="<?php echo $nhifdate; ?>"></td>
               
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($shelfcharges,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($shelfamount,2,'.',','); ?></div></td>
			    </tr>
                 <?php
				 $totalshelfamount = $totalshelfamount + $shelfamount;
				  }?>
                 <?php if($mortuary_copay>0.00){
				  $copayshelfcharges = ($originalshelfcharges/100)*$mortuary_copay;
				  $copayshelfamount = ($originalshelfamount/100)*$mortuary_copay;
				   //$copayamount = $copayrate*$quantity;
				   $copaytotalbed = $copaytotalbed + $copayshelfamount;
			  ?>
                <tr <?php echo $colorcode; ?>>
             
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"> <?php echo $shelve,' COPAY' ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $days; ?></div></td>
                 
            
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copayshelfcharges,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copayshelfamount,2,'.',','); ?></div></td>
			    </tr>
              <?php
			   $totalshelfamount = $totalshelfamount + $copayshelfamount;
			   }?>
				<?php
				
			}
			}
			}
				}
				?>
              <?php
			$totalpharm=0;
			
			$query23 = "select * from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' group by itemcode";
			$exec23 = mysql_query($query23) or die ("Error in Query1".mysql_error());
			while($res23 = mysql_fetch_array($exec23))
			{
			$phaquantity=0;
			$quantity1=0;
			$phaamount=0;
			$phaquantity1=0;
			$totalrefquantity=0;
			$phaamount1=0;
			$phadate=$res23['entrydate'];
			$phaname=$res23['itemname'];
			$phaitemcode=$res23['itemcode'];
			$pharate=$res23['rate'];
			$refno = $res23['ipdocno'];
			$pharmfree = $res23['freestatus'];
			$query33 = "select * from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode'";
			$exec33 = mysql_query($query33) or die ("Error in Query1".mysql_error());
		    while($res33 = mysql_fetch_array($exec33))
			{
			$quantity=$res33['quantity'];
			$phaquantity=$phaquantity+$quantity;
			$amount=$res33['totalamount'];
			$phaamount=$phaamount+$amount;
			}
			
			$query331 = "select * from pharmacysalesreturn_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode'";
			$exec331 = mysql_query($query331) or die ("Error in Query1".mysql_error());
		    while($res331 = mysql_fetch_array($exec331))
			{
			$quantity1=$res331['quantity'];
			$phaquantity1=$phaquantity1+$quantity1;
			$amount1=$res331['totalamount'];
			$phaamount1=$phaamount1+$amount1;
			}
			
			$resquantity = $phaquantity - $phaquantity1;
			$resamount = $phaamount - $phaamount1;
						
			$resamount=number_format($resamount,2,'.','');
			if($resquantity != 0)
			{
			if($pharmfree =='No')
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
			$totalpharm=$totalpharm+$resamount;
			if($pharmacy_copay > 0)
			{
				$pharatecopay = $pharate * ($pharmacy_copay / 100);
			}
			else
			{
				$pharatecopay = 0;
			}
			$phacopay = $pharate - $pharatecopay;
			
			$totalcopay = $totalcopay + ($pharatecopay*$resquantity); 
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phadate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $phaname; ?></div></td>
			 <input name="medicinename[]" type="hidden" id="medicinename" size="25" value="<?php echo $phaname; ?>">
			 <input name="quantity[]" type="hidden" id="quantity" size="8" readonly value="<?php echo $resquantity; ?>">
			 <input name="rate[]" type="hidden" id="rate" readonly size="8" value="<?php echo $pharate; ?>">
			 <input name="amount[]" type="hidden" id="amount" readonly size="8" value="<?php echo $resamount; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $resquantity; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $phacopay; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($phacopay*$resquantity,2); ?></div></td>
		     </tr>
			 <?php
			 if($pharmacy_copay > 0)
			 { 
			 ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phadate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $phaname.' Copay'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $resquantity; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $pharatecopay; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($pharatecopay*$resquantity,2); ?></div></td>
		     </tr>
			 <?php
			 }
			 ?>
			  
			  <?php }
			  }
			  }
			  ?>
			  <?php 
			  $totallab=0;
			  $query19 = "select * from ipconsultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemname <> '' and labrefund <> 'refund'";
			$exec19 = mysql_query($query19) or die ("Error in Query1".mysql_error());
			while($res19 = mysql_fetch_array($exec19))
			{
			$labdate=$res19['consultationdate'];
			$labname=$res19['labitemname'];
			$labcode=$res19['labitemcode'];
			$labrate=$res19['labitemrate'];
			$labrefno=$res19['iptestdocno'];
			$labfree = $res19['freestatus'];
			
			if($labfree == 'No')
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
			$totallab=$totallab+$labrate;
			if($lab_copay > 0)
			{
				$labcopay = $labrate * ($lab_copay / 100);
			}
			else
			{
				$labcopay = 0;
			}
			$labcopayrate = $labrate - $labcopay;
			$totalcopay = $totalcopay + $labcopay;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labrefno; ?></div></td>
			 <input name="lab[]" id="lab" size="69" type="hidden" value="<?php echo $labname; ?>">
			 <input name="rate5[]" id="rate5" readonly size="8" type="hidden" value="<?php echo $labrate; ?>">
			 <input name="labcode[]" id="labcode" readonly size="8" type="hidden" value="<?php echo $labcode; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $labname; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labcopayrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labcopayrate,2,'.',','); ?></div></td>
		     </tr>  
			  <?php
			  if($lab_copay > 0)
			  {
			  ?>
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $labname.' Copay'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labcopay,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labcopay,2,'.',','); ?></div></td>
		     </tr>  
			  <?php
			  }
			  ?> 
			  
			  <?php }
			  }
			  ?>
			  
			    <?php 
				$totalrad=0;
			  $query20 = "select * from ipconsultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemname <> '' and radiologyrefund <> 'refund'";
			$exec20 = mysql_query($query20) or die ("Error in Query1".mysql_error());
			while($res20 = mysql_fetch_array($exec20))
			{
			$raddate=$res20['consultationdate'];
			$radname=$res20['radiologyitemname'];
			$radrate=$res20['radiologyitemrate'];
			$radref=$res20['iptestdocno'];
			$radiologyfree = $res20['freestatus'];
			
			if($radiologyfree == 'No')
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
			$totalrad=$totalrad+$radrate;
			if($radiology_copay > 0)
			{	
				$radcopay = $radrate * ($radiology_copay / 100);
			}
			else
			{
				$radcopay = 0;
			}
			$radratecopay = $radrate - $radcopay;
			$totalcopay=$totalcopay+$radcopay;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $raddate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $radref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $radname; ?></div></td>

			 <input name="radiology[]" id="radiology" type="hidden" size="69" autocomplete="off" value="<?php echo $radname; ?>">
			 <input name="rate8[]" type="hidden" id="rate8" readonly size="8" value="<?php echo $radrate; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radratecopay,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radratecopay,2,'.',','); ?></div></td>
			 </tr>   
			  <?php
			  if($radiology_copay > 0)
			 { ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $raddate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $radref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $radname.' Copay'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radcopay,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radcopay,2,'.',','); ?></div></td>
			 </tr>   
			  <?php 
			  }  
			  }
			  }
			  ?>	  	    <?php 
					
					$totalser=0;
		    $query21 = "select * from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> '' and servicerefund <> 'refund'";
			$exec21 = mysql_query($query21) or die ("Error in Query1".mysql_error());
			while($res21 = mysql_fetch_array($exec21))
			{
			$serdate=$res21['consultationdate'];
			$sername=$res21['servicesitemname'];
			$serrate=$res21['servicesitemrate'];
			$serref=$res21['iptestdocno'];
			$servicesfree = $res21['freestatus'];
			$sercode=$res21['servicesitemcode'];
			$query2111 = "select * from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' and iptestdocno = '$serref' and servicerefund <> 'refund'";
			$exec2111 = mysql_query($query2111) or die ("Error in Query2111".mysql_error());
			$numrow2111 = mysql_num_rows($exec2111);
			$res211 = mysql_fetch_array($exec2111);
			$serqty=$res21['serviceqty'];
			if($serqty==0){$serqty=$numrow2111;}
			$servicesfree = strtoupper($servicesfree);
			if($servicesfree == 'NO')
			{	
			$totserrate=$res21['amount'];
			 if($totserrate==0){
			$totserrate=$serrate*$numrow2111;
			  }
			/*$totserrate=$serrate*$numrow2111;*/
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
			$totalser=$totalser+$totserrate;
			if($service_copay > 0)
			{
				$sercopay = $serrate * ($service_copay / 100);
			}
			else
			{
				$sercopay = 0;
			}
			$sercopayrate = $serrate - $sercopay;
			$totalcopay = $totalcopay + ($sercopay*$serqty);
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sername; ?></div></td>
			 <input name="services[]" type="hidden" id="services" size="69" value="<?php echo $sername; ?>">
			 <input name="rate3[]" type="hidden" id="rate3" readonly size="8" value="<?php echo $totserrate; ?>">
			 <input name="quantityser[]" type="hidden" id="quantityser" readonly size="8" value="<?php echo $serqty; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serqty; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($sercopayrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($sercopayrate*$serqty,2,'.',','); ?></div></td>
			  </tr>
			  <?php if($service_copay > 0)
			{ ?>
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sername.' Copay'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serqty; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($sercopay,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($sercopay*$serqty,2,'.',','); ?></div></td>
			  </tr>
			  <?php 
			  }  
			  }
			  }
			  ?>
			<?php
			$totalotbillingamount = 0;
			$query61 = "select * from ip_otbilling where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec61 = mysql_query($query61) or die(mysql_error());
			while($res61 = mysql_fetch_array($exec61))
		   {
			$otbillingdate = $res61['consultationdate'];
			$otbillingrefno = $res61['docno'];
			$otbillingname = $res61['surgeryname'];
			$otbillingrate = $res61['rate'];
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
			$totalotbillingamount = $totalotbillingamount + $otbillingrate;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $otbillingdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $otbillingrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $otbillingname; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
			  		 <input type="hidden" name="otbilling[]" id="otbilling" value="<?php echo $otbillingname; ?>">
			 	 <input type="hidden" name="otbillingrate[]" id="otbillingrate" value="<?php echo $otbillingrate; ?>">
			 <input type="hidden" name="otbillingamount[]" id="otbillingamount" value="<?php echo $otbillingrate; ?>">
			 

             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($otbillingrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($otbillingrate,2,'.',','); ?></div></td>
			    </tr>
				<?php
				}
				?>
				<?php
			$totalprivatedoctoramount = 0;
			$query62 = "select * from ipprivate_doctor where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec62 = mysql_query($query62) or die(mysql_error());
			while($res62 = mysql_fetch_array($exec62))
		   {
			$privatedoctordate = $res62['consultationdate'];
			$privatedoctorrefno = $res62['docno'];
			$privatedoctor = $res62['doctorname'];
			$privatedoctorrate = $res62['rate'];
			$privatedoctoramount = $res62['amount'];
			$privatedoctorunit = $res62['units'];
			$description = $res62['remarks'];
			if($description != '')
			{
			$description = '-'.$description;
			}
			
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
			$totalprivatedoctoramount = $totalprivatedoctoramount + $privatedoctoramount;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $privatedoctordate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $privatedoctorrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $privatedoctor.' '.$description; ?></div></td>
			 		 <input type="hidden" name="privatedoctor[]" id="privatedoctor" value="<?php echo $privatedoctor; ?>">
			 	 <input type="hidden" name="privatedoctorrate[]" id="privatedoctorrate" value="<?php echo $privatedoctorrate; ?>">
			 <input type="hidden" name="privatedoctoramount[]" id="privatedoctoramount" value="<?php echo $privatedoctoramount; ?>">
			 <input type="hidden" name="privatedoctorquantity[]" id="privatedoctorquantity" value="<?php echo $privatedoctorunit; ?>">

			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $privatedoctorunit; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($privatedoctorrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($privatedoctoramount,2,'.',','); ?></div></td>
			    </tr>
				<?php
				}
				?>
				<?php
			$totalambulanceamount = 0;
			$query63 = "select * from ip_ambulance where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec63 = mysql_query($query63) or die(mysql_error());
			while($res63 = mysql_fetch_array($exec63))
		   {
			$ambulancedate = $res63['consultationdate'];
			$ambulancerefno = $res63['docno'];
			$ambulance = $res63['description'];
			$ambulancerate = $res63['rate'];
			$ambulanceamount = $res63['amount'];
			$ambulanceunit = $res63['units'];
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
			if($ambulance_copay > 0)
			{
				$ambcopay = $ambulancerate * ($ambulance_copay / 100);
			}
			else
			{
				$ambcopay = 0;
			}
			$ambratecopay = $ambulancerate - $ambcopay;
			$totalcopay = $totalcopay + ($ambcopay*$ambulanceunit);
			$totalambulanceamount = $totalambulanceamount + $ambulanceamount;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $ambulancedate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $ambulancerefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $ambulance; ?></div></td>
			 <input type="hidden" name="ambulance[]" id="ambulance" value="<?php echo $ambulance; ?>">
			 	 <input type="hidden" name="ambulancerate[]" id="ambulancerate" value="<?php echo $ambulancerate; ?>">
			 <input type="hidden" name="ambulanceamount[]" id="ambulanceamount" value="<?php echo $ambulanceamount; ?>">
			 <input type="hidden" name="ambulancequantity[]" id="ambulancequantity" value="<?php echo $ambulanceunit; ?>">
	
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $ambulanceunit; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($ambratecopay,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($ambratecopay*$ambulanceunit,2,'.',','); ?></div></td>
			    </tr>
				<?php
				if($ambulance_copay > 0)
				{ ?>
				<tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $ambulancedate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $ambulancerefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $ambulance.' Copay'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $ambulanceunit; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($ambcopay,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($ambcopay*$ambulanceunit,2,'.',','); ?></div></td>
			    </tr>
				<?php
				}
				}
				?>
                
                <?php
			$totaliphomecareamount = 0;
			$query63 = "select * from iphomecare where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec63 = mysql_query($query63) or die(mysql_error());
			while($res63 = mysql_fetch_array($exec63))
		   {
			$iphomecaredate = $res63['consultationdate'];
			$iphomecarerefno = $res63['docno'];
			$iphomecare = $res63['description'];
			$iphomecarerate = $res63['rate'];
			$iphomecareamount = $res63['amount'];
			$iphomecareunit = $res63['units'];
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
			$totaliphomecareamount = $totaliphomecareamount + $iphomecareamount;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $iphomecaredate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $iphomecarerefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $iphomecare; ?></div></td>
			 <input type="hidden" name="iphomecare[]" id="iphomecare" value="<?php echo $iphomecare; ?>">
			 	 <input type="hidden" name="iphomecarerate[]" id="iphomecarerate" value="<?php echo $iphomecarerate; ?>">
			 <input type="hidden" name="iphomecareamount[]" id="iphomecareamount" value="<?php echo $iphomecareamount; ?>">
			 <input type="hidden" name="iphomecarequantity[]" id="iphomecarequantity" value="<?php echo $iphomecareunit; ?>">
	
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $iphomecareunit; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($iphomecarerate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($iphomecareamount,2,'.',','); ?></div></td>
			    </tr>
				<?php
				}
				?>
				<?php
			$totalmiscbillingamount = 0;
			$query69 = "select * from ipmisc_billing where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec69 = mysql_query($query69) or die(mysql_error());
			while($res69 = mysql_fetch_array($exec69))
		   {
			$miscbillingdate = $res69['consultationdate'];
			$miscbillingrefno = $res69['docno'];
			$miscbilling = $res69['description'];
			$miscbillingrate = $res69['rate'];
			$miscbillingamount = $res69['amount'];
			$miscbillingunit = $res69['units'];
			
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
			$totalmiscbillingamount = $totalmiscbillingamount + $miscbillingamount;
			if($misc_copay > 0)
			{
				$misccopay = $miscbillingrate * ($misc_copay / 100);
			}
			else
			{
				$misccopay = 0;
			}
			$misccopayrate = $miscbillingrate - $misccopay;
			$totalcopay = $totalcopay + ($misccopay*$miscbillingunit);
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $miscbillingdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $miscbillingrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $miscbilling; ?></div></td>
			  <input type="hidden" name="miscbilling[]" id="miscbilling" value="<?php echo $miscbilling; ?>">
			 	 <input type="hidden" name="miscbillingrate[]" id="miscbillingrate" value="<?php echo $miscbillingrate; ?>">
			 <input type="hidden" name="miscbillingamount[]" id="miscbillingamount" value="<?php echo $miscbillingamount; ?>">
			 <input type="hidden" name="miscbillingquantity[]" id="miscbillingquantity" value="<?php echo $miscbillingunit; ?>">
	
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $miscbillingunit; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($misccopayrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($misccopayrate*$miscbillingunit,2,'.',','); ?></div></td>
			    </tr>
				<?php
				if($misc_copay > 0)
				{
				?>
				<tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $miscbillingdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $miscbillingrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $miscbilling.' Copay'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $miscbillingunit; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($misccopay,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($misccopay*$miscbillingunit,2,'.',','); ?></div></td>
			    </tr>
				<?php
				}
				}
				?>
				<?php
			$totaldiscountamount = 0;
			$query64 = "select * from ip_discount where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec64 = mysql_query($query64) or die(mysql_error());
			while($res64 = mysql_fetch_array($exec64))
		   {
			$discountdate = $res64['consultationdate'];
			$discountrefno = $res64['docno'];
			$discount= $res64['description'];
			$discountrate = $res64['rate'];
			$discountrate1 = $discountrate;
			$discountrate = -$discountrate;
			$authorizedby = $res64['authorizedby'];
			
						
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
			$totaldiscountamount = $totaldiscountamount + $discountrate;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $discountdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $discountrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left">Discount On <?php echo $discount; ?> by <?php echo $authorizedby; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($discountrate1,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($discountrate,2,'.',','); ?></div></td>
			    </tr>
				<?php
				}
				?>
						<?php
			$totalnhifamount = 0;
			$query641 = "select * from ip_nhifprocessing where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec641 = mysql_query($query641) or die(mysql_error());
			while($res641= mysql_fetch_array($exec641))
		   {
			$nhifdate = $res641['consultationdate'];
			$nhifrefno = $res641['docno'];
			$nhifqty = $res641['totaldays'];
			$nhifrate = $res641['nhifrebate'];
			$nhifclaim = $res641['nhifclaim'];
			$nhifclaim = -$nhifclaim;
			
						
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
			$totalnhifamount = $totalnhifamount + $nhifclaim;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"> <?php echo 'NHIF'; ?></div></td>
			 	
			 	 <input type="hidden" name="nhifrate[]" id="nhifrate" value="<?php echo $nhifrate; ?>">
			 <input type="hidden" name="nhifamount[]" id="nhifamount" value="<?php echo $nhifclaim; ?>">
			 <input type="hidden" name="nhifquantity[]" id="nhifquantity" value="<?php echo $nhifqty; ?>">
	
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifqty; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($nhifrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($nhifclaim,2,'.',','); ?></div></td>
			    </tr>
				<?php
				}
				?>
			<?php
			$totaldepositamount = 0;
			$query112 = "select * from master_transactionipdeposit where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysql_query($query112) or die(mysql_error());
			while($res112 = mysql_fetch_array($exec112))
			{
			$depositamount = $res112['transactionamount'];
			$depositamount1 = -$depositamount;
			$docno = $res112['docno'];
			$transactionmode = $res112['transactionmode'];
			$transactiondate = $res112['transactiondate'];
			$chequenumber = $res112['chequenumber'];
			
			$query731 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec731 = mysql_query($query731) or die(mysql_error());
			$res731 = mysql_fetch_array($exec731);
			$depositbilltype = $res731['billtype'];
		
			
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
			$totaldepositamount = $totaldepositamount + $depositamount1;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $transactiondate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Deposit'; ?>&nbsp;&nbsp;<?php echo $transactionmode; ?>
			 <?php
			 if($transactionmode == 'CHEQUE')
			 {
			 echo $chequenumber;
			 }
			 ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($depositamount,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($depositamount,2,'.',','); ?></div></td>
			    
			  
			  <?php }
			 
			  ?>
			  		  <?php
			$totaldepositrefundamount = 0;
			$query112 = "select * from deposit_refund where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysql_query($query112) or die(mysql_error());
			while($res112 = mysql_fetch_array($exec112))
			{
			$depositrefundamount = $res112['amount'];
			$docno = $res112['docno'];
			$transactiondate = $res112['recorddate'];
			
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
			$totaldepositrefundamount = $totaldepositrefundamount + $depositrefundamount;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $transactiondate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Deposit Refund'; ?>
			</div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($depositrefundamount,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($depositrefundamount,2,'.',','); ?></div></td>
			    
			  
			  <?php 
			  }
			  $totaladvancedepositamount=0;
			  $query112 = "select * from master_transactionadvancedeposit where patientcode='$patientcode' and recordstatus='adjusted'";
			$exec112 = mysql_query($query112) or die(mysql_error());
			while($res112 = mysql_fetch_array($exec112))
			{
			$advancedepositamount = $res112['transactionamount'];
			$docno = $res112['docno'];
			$transactiondate = $res112['transactiondate'];
			
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
			$totaladvancedepositamount += $advancedepositamount;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $transactiondate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Advance Deposit'; ?>
			</div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($advancedepositamount,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($advancedepositamount,2,'.',','); ?></div></td>
			    
			  
			  <?php 
			  }
			  ?>
              
              <!--for package doctor-->
              
              
               <?php
			   if($res2package!=0)
			   {
			$totalprivatedoctorbill = 0;
			$query112 = "select * from privatedoctor_billing where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysql_query($query112) or die(mysql_error());
			while($res112 = mysql_fetch_array($exec112))
			{
			$privatedoctorbill = $res112['amount'];
			$docno = $res112['visitcode'];
			$transactiondate = $res112['recorddate'];
			$doctorname = $res112['description'];
			
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
			$totalprivatedoctorbill = $totalprivatedoctorbill + $privatedoctorbill;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $transactiondate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $doctorname; ?>
			</div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($privatedoctorbill,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($privatedoctorbill,2,'.',','); ?></div></td>
			    
			  
			  <?php 
			  }
			  ?>
              <?php
			   
			$totalresidentdoctorbill = 0;
			$query112 = "select * from residentdoctor_billing where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysql_query($query112) or die(mysql_error());
			while($res112 = mysql_fetch_array($exec112))
			{
			$residentdoctorbill = $res112['amount'];
			$docno = $res112['visitcode'];
			$transactiondate = $res112['recorddate'];
			$doctorname = $res112['description'];
			
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
			$totalresidentdoctorbill = $totalresidentdoctorbill + $residentdoctorbill;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $transactiondate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $doctorname; ?>
			</div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($residentdoctorbill,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($residentdoctorbill,2,'.',','); ?></div></td>
			    
			  
			  <?php 
			  }}
			  ?>
			  <?php 
			 
			  $depositamount = 0;
			  
			  $overalltotal=($totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalprivatedoctoramount+$totalambulanceamount+$totaliphomecareamount+$totalmiscbillingamount+$totaldepositamount+$totalnhifamount+$totaldepositrefundamount)+$totaldiscountamount-$totaladvancedepositamount;
			  $overalltotal = $overalltotal+$totalshelfamount;
			  $overalltotal=number_format($overalltotal,2,'.','');
			  $totalrevenue = $totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalprivatedoctoramount+$totalambulanceamount+$totaliphomecareamount+$totalmiscbillingamount+$totalshelfamount;
			  $consultationtotal=$totalop;
			   $consultationtotal=number_format($consultationtotal,2,'.','');
			   $netpay= $consultationtotal+$totallab+$totalpharm+$totalrad+$totalser;
			   $netpay=number_format($netpay,2,'.','');
			   
			   $totaldepositamount = $totaldepositamount + $totaldepositrefundamount;
			   $positivetotaldiscountamount = -($totaldiscountamount);
			   $positivetotaldepositamount = -($totaldepositamount);
			   $positivetotalnhifamount = -($totalnhifamount);
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
                bgcolor="#cccccc"><strong></strong></td>
             <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong></strong></td>
			 </tr>
          </tbody>
        </table>		</td>
	</tr>
	<tr>
	  <td colspan="3" class="bodytext31" align="right"><strong> Grand Total&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($overalltotal+$copaytotalbed+$totalcopay,2,'.',','); ?></strong></td>
	     <td class="bodytext31" align="center">&nbsp;</td>
	     <td class="bodytext31" align="center">&nbsp;</td>
		 <td class="bodytext31" align="center">&nbsp;

<?php

$final_copay_amount=$copaytotalbed+$totalcopay+$totaldepositamount-$totaladvancedepositamount;
if($billtype=="PAY NOW"){
$final_copay_amount= 0;
}
?>
		 <input type="hidden" name="totalcopay" id="totalcopay" value="<?php echo number_format($final_copay_amount,2,'.',''); ?>">

		<!-- <input type="hidden" name="totalcopay" id="totalcopay" value="<?php echo number_format($copaytotalbed+$totalcopay+$totaldepositamount-$totaladvancedepositamount,2,'.',''); ?>"> -->
		 </td>
		</tr>
		<?php if($totalcopay > 0) { ?>
		<tr>

	  <td colspan="3" class="bodytext31" align="right"><strong> Copay Total&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($copaytotalbed+$totalcopay,2,'.',','); ?></strong></td>
	     <td class="bodytext31" align="center">&nbsp;</td>
	     <td class="bodytext31" align="center">&nbsp;</td>
		 <td class="bodytext31" align="center">&nbsp;</td>
		</tr>
		<?php } ?>
		<tr>
		<?php  $overalltotal = round($overalltotal); ?>
	  <td colspan="3" class="bodytext31" align="right"><strong> Net Payable&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo number_format($overalltotal,2,'.',','); ?></strong></strong></td>
	   <input type="hidden" name="netpayable" id="netpayable" value="<?php echo $overalltotal; ?>">
	   <input type="hidden" name="totalrevenue" value="<?php echo $totalrevenue; ?>">
	   <input type="hidden" name="discount" value="<?php echo $positivetotaldiscountamount; ?>">
	   <input type="hidden" name="deposit" value="<?php echo $positivetotaldepositamount; ?>">
	    <input type="hidden" name="nhif" value="<?php echo $positivetotalnhifamount; ?>">
	     <td class="bodytext31" align="center">&nbsp;</td>
	     <td class="bodytext31" align="center">&nbsp;</td>
		 <td class="bodytext31" align="center">&nbsp;</td>
		</tr>
		 <td colspan="3" class="bodytext31" align="right"><strong> Receivable Account-<?php echo $accname; ?></strong></td>
	    	</tr>
			<?php
			if($patientbilltype == 'PAY NOW')
			{
			
			?>
			<tr>
			<td class="bodytext31" align="center">&nbsp;</td>
			<td class="bodytext31" align="center">&nbsp;</td>
			<td><table id="AutoNumber" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="100%" 
            align="left" border="0">
			  <tbody id="foo2">
			    <tr>
			      <td width="23%" align="right" class="bodytext31"><strong>Cash</strong></td>
			      <?php
			 if($overalltotal > 0)
			 {
			 $balancevalue = $overalltotal;
			 }
			 else
			 {
			 $balancevalue = '0.00';
			 }
			 if($overalltotal < 0){
			 $returnbalance = $overalltotal ;
			 }else{
			 $returnbalance = '0.00';
			 }
			 ?>
			      <td width="10%" align="center" class="bodytext31"><input type="text" name="cash" id="cash" size="10" onKeyUp="return balancecalc();"></td>
                  
			      <td width="15%" align="right" class="bodytext31" ><strong id="balancename">Balance</strong></td>
			      <td width="12%" align="center"  class="bodytext31"><input type="text" name="balance" id="balance" size="8" class="bal" readonly value="<?php echo $balancevalue; ?>"></td>
                  
			      <td width="35%" align="right" class="bodytext31"><strong>Return Balance</strong></td>
     			  <td width="8%" align="left" class="bodytext31"><input type="text" name="returnbalance" id="returnbalance" size="8" class="bal" readonly value="<?php echo $returnbalance; ?>">  </td>
                  

                  
		        </tr>
			    <tr>
			      <td align="right" class="bodytext31"><strong>Cheque</strong></td>
			      <td class="bodytext31" align="center"><input type="text" name="cheque" id="cheque" size="10" onKeyUp="return balancecalc();"></td>
			      <td class="bodytext31" align="right" id="chequenumber"><strong>Cheque Number</strong></td>
			      <td class="bodytext31" align="center"><input type="text" name="chequenumber1" id="chequenumber1" size="10"></td>
			      <td  align="center" class="bodytext31">&nbsp;</td>
			     
                  
                  <td colspan="3" width="55%"  class="bodytext31" align="left" >
		  				<?php
		  					if($overalltotal < 0)
		  					{
								 
		 			    ?>
		  				 <a onClick="checkrefundapproval('<?php echo $visitcode; ?>','<?php echo $patientcode;?>')" style="cursor:pointer;
           						color:#00F">Click to Refund</a>
                              <?php }?>  
                                
                                </td>
                  
		        </tr>
			    <tr>
			      <td class="bodytext31" align="right"><strong>Online</strong></td>
			      <td class="bodytext31" align="center"><input type="text" name="online" id="online" size="10" onKeyUp="return balancecalc();"></td>
			      <td class="bodytext31" align="right" id="onlinenumber"><strong>Online Number</strong></td>
			      <td class="bodytext31" align="center"><input type="text" name="onlinenumber1" id="onlinenumber1" size="10"></td>
			      <td class="bodytext31" align="center">&nbsp;</td>
			      <td class="bodytext31" align="center">&nbsp;</td>
			      <td class="bodytext31" align="center">&nbsp;</td>
		        </tr>
			    <tr>
			      <td class="bodytext31" align="right"><strong>Credit Card</strong></td>
			      <td class="bodytext31" align="center"><input type="text" name="creditcard" id="creditcard" size="10" onKeyUp="return balancecalc();"></td>
			      <td class="bodytext31" align="right" id="creditcardnumber"><strong>Credit Card Number</strong></td>
			      <td class="bodytext31" align="center"><input type="text" name="creditcardnumber1" id="creditcardnumber1" size="10"></td>
			      <td class="bodytext31" align="center">&nbsp;</td>
			      <td class="bodytext31" align="center">&nbsp;</td>
			      <td class="bodytext31" align="center">&nbsp;</td>
		        </tr>
                
           
			    <tr>
			      <td class="bodytext31" align="right"><strong>MPESA</strong></td>
			      <td class="bodytext31" align="center"><input type="text" name="mpesa" id="mpesa" size="10" onKeyUp="return balancecalc();"></td>
			      <td class="bodytext31" align="right" id="mpesanumber"><strong>MPESA Number</strong></td>
			      <td class="bodytext31" align="center"><input type="text" name="mpesanumber1" id="mpesanumber1" size="10"></td>
			      <td class="bodytext31" align="center">&nbsp;</td>
			      <td class="bodytext31" align="center">&nbsp;</td>
			      <td class="bodytext31" align="center">&nbsp;</td>
		        </tr>
		      </tbody>
			  </table></td>
              
             
			</tr>
	<?php
	}
	?>
	  <tr>
        <td>&nbsp;</td>
		 <td>&nbsp;</td>
		  <td width="60%" class="bodytext31" align="left">User Name<input type="text" name="username" id="username" value="<?php echo $username; ?>" class="bal1" readonly></td>
		 
		 <?php if($overalltotal >= 0)
		 {
			  ?>
        <td  align="left" valign="left" class="bodytext311">         
        <input type="hidden" name="frm1submit1" value="frm1submit1" />
		<input name="Submit222" type="submit" <?php if($billtype!='PAY LATER'){ if($balancevalue>0){ echo 'disabled'; } }?> id="submit" value="Save Bill"  class="button"/>
        </td>
        <?php }
        else
        {
		?>
		 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <?php
        }
		?>
		
        
        <td width="31%" align="left" valign="left" class="bodytext311">         
 
          
 <!--       <input type="hidden" name="frm1submit1" value="frm1submit1" />
		<input name="Submit222" type="submit" <?php if($billtype!='PAY LATER'){echo 'disabled';}?> id="submit" value="Save Bill"  class="button"/></td> 
-->      </tr>
    </table>
  </table>
</form>
<?php include ("includes/footer1.php");
			?>
</body>
</html>

