<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$currentdate = date('Y-m-d');
$updatetime = date('H:i:s');
$updatedate = date('Y-m-d');
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

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
					$paylaterbillprefix = 'IPFCA';
$paylaterbillprefix1=strlen($paylaterbillprefix);
$query2 = "select * from billing_ipcreditapproved order by auto_number desc limit 0, 1";
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

$billno= $billnumbercode;
		$accountname= $_REQUEST['accname'];
		$subtype = $_REQUEST['subtype'];
		$paymenttype = $_REQUEST['paymenttype'];
		$totalamount=$_REQUEST['netpayable'];
		$account1name = $_REQUEST['accountname'];
		$account2name = $_REQUEST['accountname2'];
		$account3name = $_REQUEST['accountname3'];
		$account1amount = $_REQUEST['amount1'];
		$account2amount = $_REQUEST['amount2'];
		$account3amount = $_REQUEST['amount3'];
		
		$code1 = $_REQUEST['code1'];
		$code2 = $_REQUEST['code2'];
		$code3 = $_REQUEST['code3'];
		
		$codeano1 = $_REQUEST['codeano1'];
		$codeano2 = $_REQUEST['codeano2'];
		$codeano3 = $_REQUEST['codeano3'];
		
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
		
			if(($account1name == 'CASH')||($account2name == 'CASH')||($account3name == 'CASH'))
	{
	$cash = $_REQUEST['cash'];
	if($cash == '')
	{
	$cash = 0;
	}
	else
	{
	$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,cash,cashcoa,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accountname','$billno','$updatedate','$ipaddress','$username','$cash','$cashcoa','".$locationnameget."','".$locationcodeget."')";
    $exec37 = mysql_query($query37) or die(mysql_error());
	
	}
	$cheque = $_REQUEST['cheque'];
	if($cheque == '')
	{
	$cheque = 0;
	}
	else
	{
	$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,cheque,chequecoa,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accountname','$billno','$updatedate','$ipaddress','$username','$cheque','$chequecoa','".$locationnameget."','".$locationcodeget."')";
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
	$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,online,onlinecoa,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accountname','$billno','$updatedate','$ipaddress','$username','$online','$onlinecoa','".$locationnameget."','".$locationcodeget."')";
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
	$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,card,cardcoa,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accountname','$billno','$updatedate','$ipaddress','$username','$creditcard','$cardcoa','".$locationnameget."','".$locationcodeget."')";
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
	$query37 = "insert into paymentmodedebit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,mpesa,mpesacoa,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accountname','$billno','$updatedate','$ipaddress','$username','$mpesa','$mpesacoa','".$locationnameget."','".$locationcodeget."')";
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
		if(isset($_POST['privatedoctor']))
		{
		foreach($_POST['privatedoctor'] as $key=>$value)
		{
				    //echo '<br>'.$k;

		$privatedoctor=$_POST['privatedoctor'][$key];
		
		$privatedoctorrate=$_POST['privatedoctorrate'][$key];
	    $privatedoctoramount=$_POST['privatedoctoramount'][$key];
		$privatedoctorquantity=$_POST['privatedoctorquantity'][$key];
			
		if($privatedoctor!="")
		{
		$query52 = "insert into billing_ipprivatedoctor(description,rate,quantity,amount,docno,patientname,patientcode,visitcode,accountname,recordtime,recorddate,ipaddress,username,coa,locationname,locationcode)values('$privatedoctor','$privatedoctorrate','$privatedoctorquantity','$privatedoctoramount','$billno','$patientname','$patientcode','$visitcode','$accountname','$updatetime','$updatedate','$ipaddress','$username','$privatedoctorcoa','".$locationnameget."','".$locationcodeget."')";
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
		mysql_query("insert into billing_ipcreditapproved(billno,patientname,patientcode,visitcode,totalamount,billdate,accountname,subtype,totalrevenue,discount,deposit,nhif,depositcoa,locationname,locationcode)values('$billno','$patientname','$patientcode','$visitcode','$totalamount','$currentdate','$accountname','$subtype','$totalrevenue','$discount','$deposit','$nhif','$ipdepositscoa','".$locationnameget."','".$locationcodeget."')") or die(mysql_error());
		
		if($account1name != '')
		{
		if($account1name == 'CASH')
		{
		$query43="insert into master_transactionipcreditapproved(patientname,patientcode,visitcode,transactiondate,accountname,billnumber,ipaddress,companyanum,companyname,transactiontype,paymenttype,subtype,transactionamount,username,transactiontime,cashamount,chequeamount,onlineamount,cardamount,mpesaamount,chequenumber,onlinenumber,mpesanumber,creditcardnumber,postingaccount,locationname,locationcode,accountnameano,accountnameid)values('$patientname','$patientcode','$visitcode','$currentdate','$accountname','$billno','$ipaddress','$companyanum','$companyname','finalize','$paymenttype','$subtype','$account1amount','$username','$updatetime','$cash','$cheque','$online','$creditcard','$mpesa','$chequenumber','$onlinenumber','$mpesanumber','$creditcardnumber','$account1name','".$locationnameget."','".$locationcodeget."','$codeano1','$code1')";
	    $exec43=mysql_query($query43) or die("error in query43".mysql_error());	
		
				  
		}else
		{
		$query43="insert into master_transactionipcreditapproved(patientname,patientcode,visitcode,transactiondate,accountname,billnumber,ipaddress,companyanum,companyname,transactiontype,paymenttype,subtype,transactionamount,username,transactiontime,postingaccount,locationname,locationcode,accountnameano,accountnameid)values('$patientname','$patientcode','$visitcode','$currentdate','$accountname','$billno','$ipaddress','$companyanum','$companyname','finalize','$paymenttype','$subtype','$account1amount','$username','$updatetime','$account1name','".$locationnameget."','".$locationcodeget."','$codeano1','$code1')";
	    $exec43=mysql_query($query43) or die("error in query43".mysql_error());		  
		
		$query432="insert into master_transactionpaylater(patientname,patientcode,visitcode,transactiondate,accountname,billnumber,ipaddress,companyanum,companyname,transactiontype,paymenttype,subtype,transactionamount,username,transactiontime,locationname,locationcode,accountnameano,accountnameid)values('$patientname','$patientcode','$visitcode','$currentdate','$account1name','$billno','$ipaddress','$companyanum','$companyname','finalize','$paymenttype','$subtype','$account1amount','$username','$updatetime','".$locationnameget."','".$locationcodeget."','$codeano1','$code1')";
	    $exec432=mysql_query($query432) or die("error in query432".mysql_error());		  
		
		mysql_query("insert into billing_ipcreditapprovedtransaction(billno,patientname,patientcode,visitcode,totalamount,billdate,accountname,subtype,locationname,locationcode,accountnameano,accountnameid)values('$billno','$patientname','$patientcode','$visitcode','$account1amount','$currentdate','$account1name','$subtype','".$locationnameget."','".$locationcodeget."','$codeano1','$code1')") or die(mysql_error());
	
	
		}
		}
		if($account2name != '')
		{
		if($account2name == 'CASH')
		{
		$query431="insert into master_transactionipcreditapproved(patientname,patientcode,visitcode,transactiondate,accountname,billnumber,ipaddress,companyanum,companyname,transactiontype,paymenttype,subtype,transactionamount,username,transactiontime,cashamount,chequeamount,onlineamount,cardamount,mpesaamount,chequenumber,onlinenumber,mpesanumber,creditcardnumber,postingaccount,locationname,locationcode,accountnameano,accountnameid)values('$patientname','$patientcode','$visitcode','$currentdate','$accountname','$billno','$ipaddress','$companyanum','$companyname','finalize','$paymenttype','$subtype','$account2amount','$username','$updatetime','$cash','$cheque','$online','$creditcard','$mpesa','$chequenumber','$onlinenumber','$mpesanumber','$creditcardnumber','$account2name','".$locationnameget."','".$locationcodeget."','$codeano2','$code2')";
	    $exec431=mysql_query($query431) or die("error in query431".mysql_error());		  
		
		
		}
		else
		{
		$query431="insert into master_transactionipcreditapproved(patientname,patientcode,visitcode,transactiondate,accountname,billnumber,ipaddress,companyanum,companyname,transactiontype,paymenttype,subtype,transactionamount,username,transactiontime,postingaccount,locationname,locationcode,accountnameano,accountnameid)values('$patientname','$patientcode','$visitcode','$currentdate','$accountname','$billno','$ipaddress','$companyanum','$companyname','finalize','$paymenttype','$subtype','$account2amount','$username','$updatetime','$account2name','".$locationnameget."','".$locationcodeget."','$codeano2','$code2')";
	    $exec431=mysql_query($query431) or die("error in query431".mysql_error());		  
		
		$query4312="insert into master_transactionpaylater(patientname,patientcode,visitcode,transactiondate,accountname,billnumber,ipaddress,companyanum,companyname,transactiontype,paymenttype,subtype,transactionamount,username,transactiontime,locationname,locationcode,accountnameano,accountnameid)values('$patientname','$patientcode','$visitcode','$currentdate','$account2name','$billno','$ipaddress','$companyanum','$companyname','finalize','$paymenttype','$subtype','$account2amount','$username','$updatetime','".$locationnameget."','".$locationcodeget."','$codeano2','$code2')";
	    $exec4312=mysql_query($query4312) or die("error in query4312".mysql_error());		  
		
		mysql_query("insert into billing_ipcreditapprovedtransaction(billno,patientname,patientcode,visitcode,totalamount,billdate,accountname,subtype,locationname,locationcode,accountnameano,accountnameid)values('$billno','$patientname','$patientcode','$visitcode','$account2amount','$currentdate','$account2name','$subtype','".$locationnameget."','".$locationcodeget."','$codeano2','$code2')") or die(mysql_error());
	
	
		}
		}
		if($account3name != '')
		{
		if($account3name == 'CASH')
		{
		$query432="insert into master_transactionipcreditapproved(patientname,patientcode,visitcode,transactiondate,accountname,billnumber,ipaddress,companyanum,companyname,transactiontype,paymenttype,subtype,transactionamount,username,transactiontime,cashamount,chequeamount,onlineamount,cardamount,mpesaamount,chequenumber,onlinenumber,mpesanumber,creditcardnumber,postingaccount,locationname,locationcode,accountnameano,accountnameid)values('$patientname','$patientcode','$visitcode','$currentdate','$accountname','$billno','$ipaddress','$companyanum','$companyname','finalize','$paymenttype','$subtype','$account3amount','$username','$updatetime','$cash','$cheque','$online','$creditcard','$mpesa','$chequenumber','$onlinenumber','$mpesanumber','$creditcardnumber','$account3name','".$locationnameget."','".$locationcodeget."','$codeano3','$code3')";
	    $exec432=mysql_query($query432) or die("error in query432".mysql_error());		  
		}
		else
		{
		$query432="insert into master_transactionipcreditapproved(patientname,patientcode,visitcode,transactiondate,accountname,billnumber,ipaddress,companyanum,companyname,transactiontype,paymenttype,subtype,transactionamount,username,transactiontime,postingaccount,locationname,locationcode,accountnameano,accountnameid)values('$patientname','$patientcode','$visitcode','$currentdate','$accountname','$billno','$ipaddress','$companyanum','$companyname','finalize','$paymenttype','$subtype','$account3amount','$username','$updatetime','$account3name','".$locationnameget."','".$locationcodeget."','$codeano3','$code3')";
	    $exec432=mysql_query($query432) or die("error in query432".mysql_error());		  
		
		$query4321="insert into master_transactionpaylater(patientname,patientcode,visitcode,transactiondate,accountname,billnumber,ipaddress,companyanum,companyname,transactiontype,paymenttype,subtype,transactionamount,username,transactiontime,locationname,locationcode,accountnameano,accountnameid)values('$patientname','$patientcode','$visitcode','$currentdate','$account3name','$billno','$ipaddress','$companyanum','$companyname','finalize','$paymenttype','$subtype','$account3amount','$username','$updatetime','".$locationnameget."','".$locationcodeget."','$codeano3','$code3')";
	    $exec4321=mysql_query($query4321) or die("error in query4321".mysql_error());	
		
		mysql_query("insert into billing_ipcreditapprovedtransaction(billno,patientname,patientcode,visitcode,totalamount,billdate,accountname,subtype,locationname,locationcode,accountnameano,accountnameid)values('$billno','$patientname','$patientcode','$visitcode','$account3amount','$currentdate','$account3name','$subtype','".$locationnameget."','".$locationcodeget."','$codeano3','$code3')") or die(mysql_error());
			  
	
	
		}
		}
		$query64 = "update ip_bedallocation set paymentstatus='completed' where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec64 = mysql_query($query64) or die(mysql_error());
		
		$query641 = "update master_ipvisitentry set paymentstatus='completed',finalbillno='$billno' where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec641 = mysql_query($query641) or die(mysql_error());
		
		$query6412 = "update ip_discharge set paymentstatus='completed' where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec6412 = mysql_query($query6412) or die(mysql_error());
		
		$query92 = "update ip_creditapproval set recordstatus='finalized' where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec92 = mysql_query($query92) or die(mysql_error());
		
		header("location:approvedcreditlist.php?patientcode=$patientcode&&visitcode=$visitcode&&billnumber=$billnumbercode&&st=success");
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
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$paylaterbillprefix = 'IPFCA';
$paylaterbillprefix1=strlen($paylaterbillprefix);
$query2 = "select * from billing_ipcreditapproved order by auto_number desc limit 0, 1";
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
$query7641 = "select * from master_financialintegration where field='ipdepositscreditapproval'";
$exec7641 = mysql_query($query7641) or die(mysql_error());
$res7641 = mysql_fetch_array($exec7641);

$ipdepositscoa = $res7641['code'];
$ipdepositscoaname = $res7641['coa'];
$ipdepositstype = $res7641['type'];
$ipdepositsselect = $res7641['selectstatus'];



$query76 = "select * from master_financialintegration where field='labipcreditapproval'";
$exec76 = mysql_query($query76) or die(mysql_error());
$res76 = mysql_fetch_array($exec76);
$labcoa = $res76['code'];

$query761 = "select * from master_financialintegration where field='radiologyipcreditapproval'";
$exec761 = mysql_query($query761) or die(mysql_error());
$res761 = mysql_fetch_array($exec761);

$radiologycoa = $res761['code'];

$query762 = "select * from master_financialintegration where field='serviceipcreditapproval'";
$exec762 = mysql_query($query762) or die(mysql_error());
$res762 = mysql_fetch_array($exec762);

$servicecoa = $res762['code'];

$query763 = "select * from master_financialintegration where field='referalipcreditapproval'";
$exec763 = mysql_query($query763) or die(mysql_error());
$res763 = mysql_fetch_array($exec763);

$referalcoa = $res763['code'];

$query764 = "select * from master_financialintegration where field='pharmacyipcreditapproval'";
$exec764 = mysql_query($query764) or die(mysql_error());
$res764 = mysql_fetch_array($exec764);

$pharmacycoa = $res764['code'];

$query765 = "select * from master_financialintegration where field='cashipcreditapproval'";
$exec765 = mysql_query($query765) or die(mysql_error());
$res765= mysql_fetch_array($exec765);

$cashcoa = $res765['code'];


$query766 = "select * from master_financialintegration where field='chequeipcreditapproval'";
$exec766 = mysql_query($query766) or die(mysql_error());
$res766 = mysql_fetch_array($exec766);

$chequecoa = $res766['code'];


$query767 = "select * from master_financialintegration where field='mpesaipcreditapproval'";
$exec767 = mysql_query($query767) or die(mysql_error());
$res767 = mysql_fetch_array($exec767);

$mpesacoa = $res767['code'];

$query768 = "select * from master_financialintegration where field='cardipcreditapproval'";
$exec768 = mysql_query($query768) or die(mysql_error());
$res768 = mysql_fetch_array($exec768);

$cardcoa = $res768['code'];

$query769 = "select * from master_financialintegration where field='onlineipcreditapproval'";
$exec769 = mysql_query($query769) or die(mysql_error());
$res769 = mysql_fetch_array($exec769);

$onlinecoa = $res769['code'];

$query770 = "select * from master_financialintegration where field='bedchargesipcreditapproval'";
$exec770 = mysql_query($query770) or die(mysql_error());
$res770 = mysql_fetch_array($exec770);

$bedchargescoa = $res770['code'];

$query771 = "select * from master_financialintegration where field='rmoipcreditapproval'";
$exec771 = mysql_query($query771) or die(mysql_error());
$res771 = mysql_fetch_array($exec771);

$rmocoa = $res771['code'];

$query772 = "select * from master_financialintegration where field='nursingipcreditapproval'";
$exec772 = mysql_query($query772) or die(mysql_error());
$res772 = mysql_fetch_array($exec772);

$nursingcoa = $res772['code'];

$query773 = "select * from master_financialintegration where field='privatedoctoripcreditapproval'";
$exec773 = mysql_query($query773) or die(mysql_error());
$res773= mysql_fetch_array($exec773);

$privatedoctorcoa = $res773['code'];

$query774 = "select * from master_financialintegration where field='ambulanceipcreditapproval'";
$exec774 = mysql_query($query774) or die(mysql_error());
$res774= mysql_fetch_array($exec774);

$ambulancecoa = $res774['code'];

$query775 = "select * from master_financialintegration where field='nhifipcreditapproval'";
$exec775 = mysql_query($query775) or die(mysql_error());
$res775= mysql_fetch_array($exec775);

$nhifcoa = $res775['code'];

$query776 = "select * from master_financialintegration where field='otbillingipcreditapproval'";
$exec776 = mysql_query($query776) or die(mysql_error());
$res776= mysql_fetch_array($exec776);

$otbillingcoa = $res776['code'];

$query777 = "select * from master_financialintegration where field='miscbillingipcreditapproval'";
$exec777 = mysql_query($query777) or die(mysql_error());
$res777= mysql_fetch_array($exec777);

$miscbillingcoa = $res777['code'];

$query778 = "select * from master_financialintegration where field='admissionchargeipcreditapproval'";
$exec778 = mysql_query($query778) or die(mysql_error());
$res778= mysql_fetch_array($exec778);

$admissionchargecoa = $res778['code'];

$query779 = "select * from master_financialintegration where field='ippackagecreditapproval'";
$exec779 = mysql_query($query779) or die(mysql_error());
$res779= mysql_fetch_array($exec779);

$packagecoa = $res779['code'];


?>
<?php

if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }

?>

<?php

$query72 = "select * from ip_creditapprovalformdata where patientcode='$patientcode' and visitcode='$visitcode'";
$exec72 = mysql_query($query72) or die(mysql_error());
$res72 = mysql_fetch_array($exec72);
$account1name = $res72['account1name'];
$account1code = $res72['account1code'];
$approvalcomments = $res72['approvalcomments'];
if($account1name == 'nil')
{
$account1name = '';
$account1code = '';
}
$account1amount = $res72['account1amount'];
if($account1amount == '0.00')
{
$account1amount = '';
$account2code = '';
}
$account2name = $res72['account2name'];
$account2code = $res72['account2code'];
if($account2name == 'nil')
{
$account2name = '';
$account2code = '';
}
$account2amount = $res72['account2amount'];
if($account2amount == '0.00')
{
$account2amount = '';
}
$account3name = $res72['account3name'];
$account3code = $res72['account3code'];
if($account3name == 'nil')
{
$account3name = '';
$account3code = '';
}
$account3amount = $res72['account3amount'];
if($account3amount == '0.00')
{
$account3amount = '';
}
$query67 = "select auto_number from master_accountname where id='$account1code'";
$exec67 = mysql_query($query67); 
$res67 = mysql_fetch_array($exec67);
$codeano1 = $res67['auto_number'];
$query67 = "select auto_number from master_accountname where id='$account2code'";
$exec67 = mysql_query($query67); 
$res67 = mysql_fetch_array($exec67);
$codeano2 = $res67['auto_number'];
$query67 = "select auto_number from master_accountname where id='$account3code'";
$exec67 = mysql_query($query67); 
$res67 = mysql_fetch_array($exec67);
$codeano3 = $res67['auto_number'];
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



function balancecalc()
{

var netpayable = document.getElementById("netcashpayable").value;
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

var balance = netpayable - (parseFloat(cash)+parseFloat(cheque)+parseFloat(online)+parseFloat(mpesa)+parseFloat(creditcard));


if(balance < 0)
{
alert("Entered Amount is greater than Cash Amount");
document.getElementById("balance").value = "";
return false;
}

document.getElementById("balance").value = balance.toFixed(2);

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
funcchequenumberhide();
funconlinenumberhide();
funccreditcardnumberhide();
funcmpesanumberhide();
}

function validcheck()
{
var accountname = document.getElementById("accountname").value;
var accountname2 = document.getElementById("accountname2").value;
var accountname3 = document.getElementById("accountname3").value;
if((accountname == 'CASH')||(accountname2 == 'CASH')||(accountname3 == 'CASH'))
{
var balance = document.getElementById("balance").value;
if(balance == '')
{
alert("Please Enter the Amount");
return false;
}
if(balance != 0.00)
{
alert("Balance is still pending");
return false;
}
}
  funcSaveBill1();
}
function funcSaveBill1()
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
		//alert ("Entry Saved.");
		
		
		//return true;
	}
	
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
.bali
{
text-align:right;
}
</style>
</head>

<script src="js/datetimepicker_css.js"></script>

<body onLoad="return funcOnLoadBodyFunctionCall()">
<form name="form1" id="form1" method="post" action="ipapprovedcreditform.php" onSubmit="return validcheck()">	
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="17" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="17" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="17" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="17">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
   
    <td colspan="8" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      
	 
	
		<tr>
		<td>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
          <?php
		  
		  $locationnameget=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';
		   $query1 = "select locationcode from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		
		while($res1 = mysql_fetch_array($exec1))
		{
		
		
		$locationcodeget = $res1['locationcode'];
		$query551 = "select * from master_location where locationcode='".$locationcodeget."'";
		$exec551 = mysql_query($query551) or die(mysql_error());
		$res551 = mysql_fetch_array($exec551);
		$locationnameget = $res551['locationname'];
		}?>
             <tr>
						  <td colspan="4" class="bodytext31" bgcolor="#CCCCCC"><strong>Credit Approval</strong></td>
                          <td colspan="3" class="bodytext31" bgcolor="#CCCCCC"><strong>Location &nbsp;</strong><?php echo $locationnameget;?></td>
                  <input type="hidden" name="locationcodeget" value="<?php echo $locationcodeget?>">
				<input type="hidden" name="locationnameget" value="<?php echo $locationnameget?>">
						</tr>
            <tr>
              <td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bill No</strong></div></td>
				 <td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient Name</strong></div></td>
           
				 <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Code  </strong></div></td>
				 <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>IP Visit  </strong></div></td>
				 <td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bill Type</strong></div></td>
				<td width="13%"  align="left" valign="center" 
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
		$Querylab=mysql_query("select * from master_customer where customercode='$patientcode'");
		$execlab=mysql_fetch_array($Querylab);
		$patienttype=$execlab['maintype'];
		$querytype=mysql_query("select * from master_paymenttype where auto_number='$patienttype'");
		$exectype=mysql_fetch_array($querytype);
		$patienttype1=$exectype['paymenttype'];
		$patientsubtype=$execlab['subtype'];
		$querysubtype=mysql_query("select * from master_subtype where auto_number='$patientsubtype'");
		$execsubtype=mysql_fetch_array($querysubtype);
		$patientsubtype1=$execsubtype['subtype'];
		$bedtemplate=$execsubtype['bedtemplate'];
		$labtemplate=$execsubtype['labtemplate'];
		$radtemplate=$execsubtype['radtemplate'];
		$sertemplate=$execsubtype['sertemplate'];
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
				<input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>">
				<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>">
					<input type="hidden" name="subtype" id="subtype" value="<?php echo $patientsubtype1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>	
				<input type="hidden" name="paymenttype" id="paymenttype" value="<?php echo $patienttype1; ?>">	
			
				<input type="hidden" name="accname" id="accname" value="<?php echo $accname; ?>">
				<input type="hidden" name="billno" id="billno" value="<?php echo $billnumbercode; ?>">
			   </tr>
		   <?php 
		   } 
		  
		   ?>
           
            <tr>
             	<td colspan="7" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#cccccc" class="bodytext311">&nbsp;</td>
             	</tr>
          </tbody>
        </table>		</td>
		</tr>
		
		</table>		</td>
		</tr>
		<tr>
        <td>&nbsp;</td>
		</tr>
	<tr>
	
	<td>&nbsp;</td>
	<td width="6%">&nbsp;</td>
	<td colspan="4">
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
			$query17 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec17 = mysql_query($query17) or die ("Error in Query1".mysql_error());
			$res17 = mysql_fetch_array($exec17);
			$consultationfee=$res17['admissionfees'];
			$consultationfee = number_format($consultationfee,2,'.','');
			$viscode=$res17['visitcode'];
			$consultationdate=$res17['consultationdate'];
			$packchargeapply = $res17['packchargeapply'];
			$packageanum1 = $res17['package'];
			
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
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $packagename; ?></div></td>
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
			$totalbedallocationamount = 0;
			
			 
			 
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
						if($quantity>0)
						{
							if($type=='hospital'||$charge!='RMO Charges')
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
								
								
					  ?>
					   <?php if($rowbedtr == 0) { $totalbedallocationamount=$totalbedallocationamount+$amount; ?>
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
									<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($rate,2,'.',','); ?></div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
								</tr>              
					  <?php } ?>
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
					$query51 = "select bed,threshold from `$bedtable` where auto_number='$bed'";
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
					$bedcharge='0';
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
						
						$quantity = $quantity+$bedalloc_qty;
						$amount = $quantity * $rate;						
						$allocatequantiy = $quantity;
						$allocatenewquantity = $quantity;
						if($bedcharge=='0')
						{
							if($quantity>0)
							{
								if($type=='hospital'||$charge!='RMO Charges')
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
										<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($rate,2,'.',','); ?></div></td>
										<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
									</tr>              
						 
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
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($pharate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $resamount; ?></div></td>
		     
			  
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
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labrate,2,'.',','); ?></div></td>
		       
			  
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
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $raddate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $radref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $radname; ?></div></td>

			 <input name="radiology[]" id="radiology" type="hidden" size="69" autocomplete="off" value="<?php echo $radname; ?>">
			 <input name="rate8[]" type="hidden" id="rate8" readonly size="8" value="<?php echo $radrate; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radrate,2,'.',','); ?></div></td>
			    
			  
			  <?php }
			  }
			  ?>
		  	    <?php 
					
					$totalser=0;
		    $query21 = "select * from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> '' and servicerefund <> 'refund' group by servicesitemname";
			$exec21 = mysql_query($query21) or die ("Error in Query1".mysql_error());
			while($res21 = mysql_fetch_array($exec21))
			{
			$serdate=$res21['consultationdate'];
			$sername=$res21['servicesitemname'];
			$serrate=$res21['servicesitemrate'];
			$serref=$res21['iptestdocno'];
			$servicesfree = $res21['freestatus'];
			$sercode=$res21['servicesitemcode'];
			$query2111 = "select * from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' and servicerefund <> 'refund' and iptestdocno = '$serref'";
			$exec2111 = mysql_query($query2111) or die ("Error in Query2111".mysql_error());
			$numrow2111 = mysql_num_rows($exec2111);
			if($servicesfree == 'No')
			{
			$totserrate=$serrate*$numrow2111;
		
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
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sername; ?></div></td>
			 <input name="services[]" type="hidden" id="services" size="69" value="<?php echo $sername; ?>">
			 <input name="rate3[]" type="hidden" id="rate3" readonly size="8" value="<?php echo $serrate; ?>">
			 <input name="quantityser[]" type="hidden" id="quantityser" readonly size="8" value="<?php echo $numrow2111; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $numrow2111; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($serrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totserrate,2,'.',','); ?></div></td>
			    
			  
			  <?php }
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
		  		 <input type="hidden" name="otbilling[]" id="otbilling" value="<?php echo $otbillingname; ?>">
			 	 <input type="hidden" name="otbillingrate[]" id="otbillingrate" value="<?php echo $otbillingrate; ?>">
			 <input type="hidden" name="otbillingamount[]" id="otbillingamount" value="<?php echo $otbillingrate; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
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
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $privatedoctor; ?></div></td>
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
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($ambulancerate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($ambulanceamount,2,'.',','); ?></div></td>
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
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($miscbillingrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($miscbillingamount,2,'.',','); ?></div></td>
			    </tr>
				<?php
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
			 <input name="doctorname[]" type="hidden" id="doctorname" size="69" value="<?php echo $discount; ?>">
			 <input name="doctorrate[]" type="hidden" id="doctorrate" readonly size="8" value="<?php echo $discountrate; ?>">
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
			  $depositamount = 0;
			  $overalltotal=($totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalprivatedoctoramount+$totalambulanceamount+$totaldiscountamount+$totalmiscbillingamount+$totaldepositamount+$totalnhifamount);
			  $overalltotal=number_format($overalltotal,2,'.','');
			    $totalrevenue = $totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalprivatedoctoramount+$totalambulanceamount+$totalmiscbillingamount;
			  $consultationtotal=$totalop;
			   $consultationtotal=number_format($consultationtotal,2,'.','');
			   $netpay= $consultationtotal+$totallab+$totalpharm+$totalrad+$totalser;
			   $netpay=number_format($netpay,2,'.','');
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
	  <td colspan="6" class="bodytext31" align="right"><strong> Grand Total&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($overalltotal,2,'.',','); ?></strong></td>
	     <td class="bodytext31" align="center">&nbsp;</td><input type="hidden" name="grandtotal" id="grandtotal" value="<?php echo $overalltotal; ?>">
	     <td class="bodytext31" align="center">&nbsp;</td>
		 <td class="bodytext31" align="center">&nbsp;</td>
		</tr>
		<tr>
		<?php  $overalltotal = round($overalltotal); ?>
	  <td colspan="6" class="bodytext31" align="right"><strong> Net Payable&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($overalltotal,2,'.',','); ?></strong></td>
	   <input type="hidden" name="netpayable" id="netpayable" value="<?php echo $overalltotal; ?>">
	    <input type="hidden" name="totalrevenue" value="<?php echo $totalrevenue; ?>">
	   <input type="hidden" name="discount" value="<?php echo $positivetotaldiscountamount; ?>">
	   <input type="hidden" name="deposit" value="<?php echo $positivetotaldepositamount; ?>">
	    <input type="hidden" name="nhif" value="<?php echo $positivetotalnhifamount; ?>">
	   <?php 
			if(($account1name =='CASH')||($account2name =='CASH')||($account3name =='CASH'))
			{
			if($account1name =='CASH')
			{
			$cashamount = $account1amount;
			}
			if($account2name =='CASH')
			{
			$cashamount = $account2amount;
			}
			if($account3name =='CASH')
			{
			$cashamount = $account3amount;
			}
			
			?>
			 <input type="hidden" name="netcashpayable" id="netcashpayable" value="<?php echo $cashamount; ?>">
			<?php } ?>
	     <td class="bodytext31" align="center">&nbsp;</td>
	     <td class="bodytext31" align="center">&nbsp;</td>
		 <td class="bodytext31" align="center">&nbsp;</td>
		</tr>
	<tr>
			<td class="bodytext31" align="center">&nbsp;</td>
			<td class="bodytext31" align="center">&nbsp;</td>
	  <td colspan="4">
			<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
		  <tr>
			<td width="25%" align="center" class="bodytext31"> Account</td>
			 
	
			<td width="12%" align="center" class="bodytext31">Amount</td>
		    <td width="16%" align="center" class="bodytext31"><?php 
			if(($account1name =='CASH')||($account2name =='CASH')||($account3name =='CASH'))
			{
			?>Cash<?php } ?></td>
		    <td width="17%" align="center" class="bodytext31">
			<?php 
			if(($account1name =='CASH')||($account2name =='CASH')||($account3name =='CASH'))
			{
			?>
			<input type="text" name="cash" id="cash" size="10" onKeyUp="return balancecalc();">
			<?php } ?>			</td>
			<td width="17%" align="center" class="bodytext31"></td>
			<td width="17%" align="right" class="bodytext31">
			<?php 
			if(($account1name =='CASH')||($account2name =='CASH')||($account3name =='CASH'))
			{
			?>
			Balance
			<?php } ?></td>
			<td width="17%" align="center" class="bodytext31">
			<?php 
			if(($account1name =='CASH')||($account2name =='CASH')||($account3name =='CASH'))
			{
			?>
			<input type="text" name="balance" id="balance" size="8" class="bal" readonly>
			<?php } ?>			</td>
		  </tr>
			<tr>
			<td align="right" class="bodytext31"><input name="accountname" type="text" id="accountname" value="<?php if($account1amount == '') { echo ''; }else { echo $account1name; } ?>" size="32" autocomplete="off" readonly></td>
			 <td class="bodytext31" align="center"><input type="text" id="amount1" name="amount1" size="10" onKeyUp="return balancecalc('1')" value="<?php echo $account1amount; ?>" readonly>
             
             <input type="hidden" id="code1" name="code1" size="10" onKeyUp="return balancecalc('1')" value="<?php echo $account1code; ?>" readonly>
             <input type="hidden" id="codeano1" name="codeano1" size="10" onKeyUp="return balancecalc('1')" value="<?php echo $codeano1; ?>" readonly>
             </td>
			 <td class="bodytext31" align="center">
			 <?php 
			if(($account1name =='CASH')||($account2name =='CASH')||($account3name =='CASH'))
			{
			?>
			Cheque
			<?php } ?>			 </td>
			 <td class="bodytext31" align="center">
			 <?php 
			if(($account1name =='CASH')||($account2name =='CASH')||($account3name =='CASH'))
			{
			?>
			<input type="text" name="cheque" id="cheque" size="10" onKeyUp="return balancecalc();">
			<?php
			}
			?>			 </td>
			 <td width="12%" align="center" class="bodytext31" id="chequenumber"><strong>Cheque No</strong></td>
	     <td width="10%" align="center" class="bodytext31"><input type="text" name="chequenumber1" id="chequenumber1" size="10"></td>
		 <td width="8%" align="right" class="bodytext31">&nbsp;</td>
			</tr>
			<tr>
			<td class="bodytext31" align="right"><input name="accountname2" type="text" id="accountname2" value="<?php if($account2amount == '') { echo ''; }else { echo $account2name; } ?>" size="32" autocomplete="off" readonly></td>
			 <td class="bodytext31" align="center"><input type="text" id="amount2" name="amount2" size="10" onKeyUp="return balancecalc('2')" value="<?php echo $account2amount; ?>" readonly>
             <input type="hidden" id="code2" name="code2" size="10" onKeyUp="return balancecalc('2')" value="<?php echo $account2code; ?>" readonly>
             <input type="hidden" id="codeano2" name="codeano2" size="10" onKeyUp="return balancecalc('1')" value="<?php echo $codeano2; ?>" readonly>
             </td>
		 <td class="bodytext31" align="center">
		 <?php 
			if(($account1name =='CASH')||($account2name =='CASH')||($account3name =='CASH'))
			{
			?>
			Online
			<?php } ?>		 </td>
			 <td class="bodytext31" align="center">
			  <?php 
			if(($account1name =='CASH')||($account2name =='CASH')||($account3name =='CASH'))
			{
			?>
			<input type="text" name="online" id="online" size="10" onKeyUp="return balancecalc();">
			<?php } ?>			 </td>
		 <td class="bodytext31" align="center" id="onlinenumber"><strong>Online No</strong></td>
			 <td class="bodytext31" align="center"><input type="text" name="onlinenumber1" id="onlinenumber1" size="10"></td>
		 <td class="bodytext31" align="center">&nbsp;</td>
			</tr>
			<tr>
			<td class="bodytext31" align="right"><input name="accountname3" type="text" id="accountname3" value="<?php if($account3amount == '') { echo ''; }else { echo $account3name; } ?>" size="32" autocomplete="off" readonly></td>
			 <td class="bodytext31" align="center"><input type="text" id="amount3" name="amount3" size="10" onKeyUp="return balancecalc('3')" value="<?php echo $account3amount; ?>" readonly>
             <input type="hidden" id="code3" name="code3" size="10" onKeyUp="return balancecalc('3')" value="<?php echo $account3code; ?>" readonly>
             <input type="hidden" id="codeano3" name="codeano3" size="10" onKeyUp="return balancecalc('3')" value="<?php echo $codeano3; ?>" readonly>
             </td>
			 <td class="bodytext31" align="center">
			 <?php 
			if(($account1name =='CASH')||($account2name =='CASH')||($account3name =='CASH'))
			{
			?>
			Credit Card
			
			<?php
			} ?>			 </td>
			 <td class="bodytext31" align="center">
			  <?php 
			if(($account1name =='CASH')||($account2name =='CASH')||($account3name =='CASH'))
			{
			?>
			<input type="text" name="creditcard" id="creditcard" size="10" onKeyUp="return balancecalc();">
			<?php } ?>			 </td>
			 <td class="bodytext31" align="center" id="creditcardnumber"><strong> Card No</strong></td>
			 <td class="bodytext31" align="center"><input type="text" name="creditcardnumber1" id="creditcardnumber1" size="10"></td>
		 <td class="bodytext31" align="center">&nbsp;</td>
			</tr>
			<tr>
			<td class="bodytext31" align="right">&nbsp;</td>
			 <td class="bodytext31" align="center"></td>
			 <td class="bodytext31" align="center">
			 <?php 
			if(($account1name =='CASH')||($account2name =='CASH')||($account3name =='CASH'))
			{
			?>
			MPESA
			<?php } ?>			 </td>
			 <td class="bodytext31" align="center">
			 <?php 
			if(($account1name =='CASH')||($account2name =='CASH')||($account3name =='CASH'))
			{
			?>
			<input type="text" name="mpesa" id="mpesa" size="10" onKeyUp="return balancecalc();">
			<?php } ?></td>
		 <td class="bodytext31" align="center" id="mpesanumber"><strong>MPESA No</strong></td>
			 <td class="bodytext31" align="center"><input type="text" name="mpesanumber1" id="mpesanumber1" size="10"></td>
			 <td class="bodytext31" align="center">&nbsp;</td>
			</tr>
			</tbody>
			</table>	  </td>
			</tr>
			
	  <tr>
        <td>&nbsp;</td>
		 <td>&nbsp;</td>
		  <td width="10%" class="bodytext31" align="left">Approval Comments</td>
		  <td width="25%" class="bodytext31" align="left"><textarea name="approvalcomments" id="approvalcomments"><?php echo $approvalcomments; ?></textarea></td>
	      <td width="12%" class="bodytext31" align="center"><strong>User Name</strong></td>
          <td width="13%" class="bodytext31" align="left"><?php echo $username; ?></td>
        <td width="1%">&nbsp;</td>
		<td width="1%">&nbsp;</td>
		<td width="31%" align="center" valign="center" class="bodytext311">&nbsp; </td>
      </tr>
	  
	  <tr>
        <td>&nbsp;</td>
		 <td>&nbsp;</td>
		  <td colspan="4">&nbsp;</td>
		<td width="1%">&nbsp;</td>
		<td width="1%">&nbsp;</td>
		<td width="31%" align="center" valign="center" class="bodytext311">         
         <input type="hidden" name="frm1submit1" value="frm1submit1" />
		<input name="Submit222" type="submit" value="Save Bill" class="button" style="border: 1px solid #001E6A"/>		</td>
      </tr>
    </table>
  </table>
</form>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

