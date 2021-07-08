<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$currentdate = date("Y-m-d");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$printbill = $_REQUEST["printbill"];
$docno=$_SESSION["docno"];
$totalcopayfixedamount='';
$totalcopay='';
/*echo basename(__FILE__);
//echo phpinfo();
$a=10;$b=5; 
echo $y=bcsub($a,$b,3);
echo '<br>',$_SERVER['REQUEST_URI'];
echo '<br>',$pugazh=getcwd(); echo'<br>', end(explode("\\",$pugazh));*/
if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
$billno='';
 $ambcount=isset($_REQUEST['ambcount'])?$_REQUEST['ambcount']:'';
 $ambcount1=isset($_REQUEST['ambcount1'])?$_REQUEST['ambcount1']:'';
 $locationname=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';
		 $locationcode=isset($_REQUEST['locationcodeget'])?$_REQUEST['locationcodeget']:'';
//$st = $_REQUEST['st'];
if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["patientname"])) { $patientname = $_REQUEST["patientname"]; } else { $patientname = ""; }

if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }

if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }

$titlestr = 'SALES BILL';
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }

if($frm1submit1 =='seekapproval')
{
	$patientcode = isset($_REQUEST["customercode"])?$_REQUEST["customercode"]:'';
	 $query2 = "UPDATE master_consultation SET consolidateapproval = '1' WHERE patientcode = '".$patientcode."' AND patientvisitcode='".$visitcode."'";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	header("location:approvallist2.php?visitcode=$visitcode&&cbfrmflag1=cbfrmflag1&&patientcode=$patientcode&&location=$locationcode");
	}
if ($frm1submit1 == 'frm1submit1')
{ 
    $visitcode=$_REQUEST["visitcode"];
	$patientcode = $_REQUEST["customercode"];
	$patientname = $_REQUEST["patientname"];
	$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$paylaterbillprefix = $res3['paylaterbillprefix'];
$paylaterbillprefix1=strlen($paylaterbillprefix);
$query2 = "select * from billing_paylater where patientcode <> '' order by auto_number desc limit 0, 1";
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

	$billno = $billnumbercode;
	$accountname= $_REQUEST['accountname'];
	$subtype = $_REQUEST['subtype'];
	$paymenttype = $_REQUEST['paymenttype'];
	$totalamount=$_REQUEST['totalamount'];
	$billdate=$_REQUEST['billdate'];
	$consultationamount=$_REQUEST['consultation'];
	$labcoa = $_REQUEST['labcoa'];
		$radiologycoa = $_REQUEST['radiologycoa'];
		$servicecoa = $_REQUEST['servicecoa'];
		$pharmacycoa = $_REQUEST['pharmacycoa'];
		$referalcoa = $_REQUEST['referalcoa'];
		$consultationcoa = $_REQUEST['consultationcoa'];
		
		$query7691 = "select * from master_financialintegration where field='externaldoctors'";
		$exec7691 = mysql_query($query7691) or die(mysql_error());
		$res7691 = mysql_fetch_array($exec7691);
		
		$debitcoa = $res7691['code'];

		$referalname=$_REQUEST['referalname'];
		$query77 = "select * from master_visitentry where visitcode='$visitcode'";
		$exec77 = mysql_query($query77) or die(mysql_error());
		$res77 = mysql_fetch_array($exec77);
		$doctor = $res77['consultingdoctor'];
		
		$query78 = "select * from master_doctor where auto_number='$doctor'";
		$exec78 = mysql_query($query78) or die(mysql_error());
		$res78 = mysql_fetch_array($exec78);
		$doctorname = $res78['doctorname'];
		
		//this is for updating the opdue in master_custormer table
		$opduevalue=0;
		$query78 = "select opdue from master_customer where customercode='$patientcode'";
		$exec78 = mysql_query($query78) or die(mysql_error());
		$opdue = mysql_fetch_array($exec78);
		$opduevalue  =  $opdue['opdue'];
		
		$accountnameano= $_REQUEST['accountnameano'];
		$accountnameid= $_REQUEST['accountnameid'];
		$subtypeano = $_REQUEST['subtypeano'];
		
		$opduevalue=$opduevalue+$totalamount;
		$referalquery1=mysql_query("UPDATE master_customer SET opdue = '".$opduevalue."' where customercode='$patientcode'") or die(mysql_error());
		
		$query2 = "select * from billing_paylater where billno = '$billnumbercode'";
	 $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
     $res29 = mysql_num_rows($exec2);
	if ($res29 == 0)
	{
		//inserting ambulance bill details
		//echo $quantity;
		//echo $ambcount;
		if($ambcount>0)
		{//echo "ok";
			
			foreach($_POST['ambulancecount'] as $key)
			{ 
				 $amdocno=$_REQUEST['amdocno'][$key];
				 $accountname=$_REQUEST['accountname'][$key];
				$description=$_REQUEST['description'][$key];
				$quantity=$_REQUEST['quantityamb'][$key];
				$rate=$_REQUEST['rateamb'][$key];
				$amount=$_REQUEST['amountamb'][$key];
				$actualamount=$_REQUEST['actualamount'][$key];
				$referalquery1=mysql_query("insert into billing_opambulancepaylater(docno,patientcode,patientname,visitcode,accountname,description,quantity,rate,amount,locationname,locationcode,recordtime,recordstatus,ipaddress,recorddate,username,actualamount,billnumber)values('".$amdocno."','$patientcode','$patientname','$visitcode','$accountname','".$description."','".$quantity."','".$rate."','".$amount."','$locationname','$locationcode','".$timeonly."','paid','".$ipaddress."','".$dateonly."','".$username."','".$actualamount."','".$billno."')") or die(mysql_error());
				}
				
				mysql_query("update op_ambulance set paymentstatus='completed' where patientvisitcode='$visitcode' and description = '$description'");
			}
			
			//inserting ambulance ends here
			if($ambcount1>0)
		{//echo "ok";
			
			foreach($_POST['ambulancecounthom'] as $key)
			{ 
				$amdocno2=$_REQUEST['amdocnohom'][$key];
				$accountname2=$_REQUEST['accountnamehom'][$key];
				$description2=$_REQUEST['descriptionhom'][$key];
				$quantity2=$_REQUEST['quantityhom'][$key];
				$rate2=$_REQUEST['ratehom'][$key];
				$amount2=$_REQUEST['amounthom'][$key];
				$actualamount2=$_REQUEST['actualamounthom'][$key];
				$referalquery1=mysql_query("insert into billing_homecarepaylater(docno,patientcode,patientname,visitcode,accountname,description,quantity,rate,amount,locationname,locationcode,recordtime,recordstatus,ipaddress,recorddate,username,actualamount,billnumber)values('".$amdocno2."','$patientcode','$patientname','$visitcode','$accountname2','".$description2."','".$quantity2."','".$rate2."','".$amount2."','$locationname','$locationcode','".$timeonly."','paid','".$ipaddress."','".$dateonly."','".$username."','".$actualamount2."','".$billno."')") or die(mysql_error());
				}
				//exit();
				mysql_query("update homecare set paymentstatus='completed' where patientvisitcode='$visitcode' and description = '$description2'");
			}
			
			//inserting ambulance ends here
		 $query291 = "select * from billing_paylater where visitcode='$visitcode'";
	 $exec291 = mysql_query($query291) or die ("Error in Query2".mysql_error());
	 $num291 = mysql_num_rows($exec291);
	if($num291 == 0)
	{
		
				
		  $query29 = "select * from master_consultationpharm where patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$exec29 = mysql_query($query29) or die ("Error in Query29".mysql_error());
			$num29=mysql_num_rows($exec29);
		if($num29 != 0)
		{
		mysql_query("update master_visitentry set pharmacybill='completed' where visitcode='$visitcode'");
		}
		  $query30 = "select * from consultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$exec30 = mysql_query($query30) or die ("Error in Query1".mysql_error());
		$num30=mysql_num_rows($exec30);
		if($num30 != 0)
		{
		mysql_query("update master_visitentry set labbill='completed' where visitcode='$visitcode'");
		}
		 $query31 = "select * from consultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$exec31 = mysql_query($query31) or die ("Error in Query1".mysql_error());
			$num31=mysql_num_rows($exec31);
			if($num31 != 0)
			{
			mysql_query("update master_visitentry set radiologybill='completed' where visitcode='$visitcode'");
			}
			  $query32 = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$exec32 = mysql_query($query32) or die ("Error in Query1".mysql_error());
		$num32=mysql_num_rows($exec32);
		if($num32 != 0)
		{
			mysql_query("update master_visitentry set servicebill='completed' where visitcode='$visitcode'");
		}
			  $query33 = "select * from consultation_departmentreferal where patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$exec33 = mysql_query($query33) or die ("Error in Query1".mysql_error());
		$num33=mysql_num_rows($exec33);
		if($num33 != 0)
		{
		mysql_query("update master_visitentry set referalbill='completed' where visitcode='$visitcode'");
		}
		
				foreach($_POST['medicinename'] as $key=>$value)
		{	
		    //echo '<br>'.$i;
			//echo '<br>'.
			//$autonumber = $_REQUEST['autonumber'.$p];	
			//echo '<br>'.
		    $medicinename = $_POST['medicinename'][$key];
			$medicinename = addslashes($medicinename);
			$query77="select * from master_medicine where itemname='$medicinename' and status <> 'deleted'";
			$exec77=mysql_query($query77);
			$res77=mysql_fetch_array($exec77);
			$medicinecode=$res77['itemcode'];
			//$rate=$res77['rateperunit'];
			$rate=$_POST['rate'][$key];
			$quantity = $_POST['quantity'][$key];
			$amount = $_POST['amount'][$key];
			
			//if ($medicinename != "" && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")
			if ($medicinename != "")// && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")
			{
		        //echo '<br>'. 
		        $query2 = "insert into billing_paylaterpharmacy(patientcode,patientname,patientvisitcode,medicinename,quantity,rate,amount,billdate,ipaddress,accountname,paymentstatus,medicinecode,billnumber,pharmacycoa,username,locationname,locationcode) 
				values('$patientcode','$patientname','$visitcode','$medicinename','$quantity','$rate','$amount','$currentdate','$ipaddress','$accountname','unpaid','$medicinecode','$billno','$pharmacycoa','$username','".$locationname."','".$locationcode."')";
				$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			
							
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
			
			 /*"insert into billing_paylaterlab(patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,accountname,billdate,paymentstatus,billnumber,labcoa,username,locationname,locationcode)values('$patientcode','$patientname','$visitcode','$labcode','$labname','$labrate','$accountname','$currentdate','unpaid','$billno','$labcoa','$username','".$locationname."','".$locationcode."')"; exit;*/
		$labquery1=mysql_query("insert into billing_paylaterlab(patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,accountname,billdate,paymentstatus,billnumber,labcoa,username,locationname,locationcode)values('$patientcode','$patientname','$visitcode','$labcode','$labname','$labrate','$accountname','$currentdate','unpaid','$billno','$labcoa','$username','".$locationname."','".$locationcode."')") or die(mysql_error());
			}
		}
		
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
		$radiologyquery1=mysql_query("insert into billing_paylaterradiology(patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,accountname,billdate,paymentstatus,billnumber,radiologycoa,username,locationname,locationcode)values('$patientcode','$patientname','$visitcode','$radiologycode','$pairs','$pairs1','$accountname','$currentdate','unpaid','$billno','$radiologycoa','$username','".$locationname."','".$locationcode."')") or die(mysql_error());
		}
		}
		
		foreach($_POST['services'] as $key => $value)
		{
				    //echo '<br>'.$k;

		$servicesname=$_POST["services"][$key];
		$servicequery=mysql_query("select * from master_services where itemname='$servicesname' and status <> 'deleted'");
		$execservice=mysql_fetch_array($servicequery);
		$servicescode=$execservice['itemcode'];
		
		$servicesrate=$_POST["rate3"][$key];
		$quantityser=$_POST['quantityser'][$key];
		$seramount=$_POST['totalservice3'][$key];
		/*for($se=1;$se<=$quantityser;$se++)
		{*/			
		if($servicesname!="")
		{
		$servicesquery1=mysql_query("insert into billing_paylaterservices(patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,accountname,billdate,paymentstatus,billnumber,servicecoa,username,locationname,locationcode,serviceqty,amount)values('$patientcode','$patientname','$visitcode','$servicescode','$servicesname','$servicesrate','$accountname','$currentdate','unpaid','$billno','$servicecoa','$username','".$locationname."','".$locationcode."','".$quantityser."','".$seramount."')") or die(mysql_error());
		}
		/*}*/
		}
		
		foreach($_POST['referal'] as $key=>$value)
		{
		$pairs2= $_POST['referal'][$key];
		$pairvar2= $pairs2;
	    $pairs3= $_POST['rateref'][$key];
		$pairs3amt= $_POST['raterefamt'][$key];
		$pairvar3= $pairs3;
		
		$referalquery=mysql_query("select * from master_doctor where doctorname='$pairvar2'");
		$execreferal=mysql_fetch_array($referalquery);
		$referalcode=$execreferal['doctorcode'];
		
		//echo $pairs2;
		if($pairvar2!="")
		{
		$referalquery1=mysql_query("insert into billing_paylaterreferal(patientcode,patientname,patientvisitcode,referalcode,referalname,referalrate,accountname,billdate,paymentstatus,billnumber,referalcoa,locationname,locationcode,referalamount)values('$patientcode','$patientname','$visitcode','$referalcode','$pairvar2','$pairvar3','$accountname','$currentdate','unpaid','$billno','$referalcoa','".$locationname."','".$locationcode."','".$pairs3amt."')") or die(mysql_error());
		
		}
		}
		if($referalcode == '')
		{
		$debitcoa = '';
		}
		mysql_query("insert into billing_paylater(billno,patientname,patientcode,visitcode,totalamount,billdate,accountname,referalname,doctorstatus,billstatus,subtype,creditcoa,debitcoa,locationname,locationcode,accountnameano,accountnameid,subtypeano)values('$billno','$patientname','$patientcode','$visitcode','$totalamount','$billdate','$accountname','$referalname','unpaid','unpaid','$subtype','$referalcode','$debitcoa','".$locationname."','".$locationcode."','$accountnameano','$accountnameid','$subtypeano')") or die(mysql_error());

		foreach($_POST['departmentreferal'] as $key=>$value)
		{
		$pairs21= $_POST['departmentreferal'][$key];
		$pairvar21= $pairs21;
	    $pairs31= $_POST['departmentreferalrate4'][$key];
		$pairvar31= $pairs31;
		
		$referalquery1=mysql_query("select * from master_department where department ='$pairvar21'");
		$execreferal1=mysql_fetch_array($referalquery1);
		$referalcode1=$execreferal1['auto_number'];
		
		//echo $pairs2;
		if($pairvar21!="")
		{
		$referalquery1=mysql_query("insert into billing_paylaterreferal(patientcode,patientname,patientvisitcode,referalcode,referalname,referalrate,accountname,billdate,paymentstatus,billnumber,username,referalcoa,locationname,locationcode)values('$patientcode','$patientname','$visitcode','$referalcode1','$pairvar21','$pairvar31','$accountname','$billdate','unpaid','$billno','$username','$referalcoa','".$locationname."','".$locationcode."')") or die(mysql_error());
		
		}
		}

	mysql_query("insert into billing_paylaterconsultation(billno,patientname,patientcode,visitcode,totalamount,billdate,accountname,billstatus,consultationcoa,locationname,locationcode)values('$billno','$patientname','$patientcode','$visitcode','$consultationamount','$billdate','$accountname','unpaid','$consultationcoa','".$locationname."','".$locationcode."')") or die(mysql_error());

	$query43="insert into master_transactionpaylater(patientname,patientcode,visitcode,transactiondate,accountname,billnumber,ipaddress,companyanum,companyname,financialyear,transactiontype,paymenttype,subtype,transactionamount,doctorname,username,transactiontime,locationname,locationcode,accountnameano,accountnameid,subtypeano,billbalanceamount,billamount)values('$patientname',
	          '$patientcode','$visitcode','$billdate','$accountname','$billno','$ipaddress','$companyanum','$companyname','$financialyear','finalize','$paymenttype','$subtype','$totalamount','$doctorname','$username','$updatedatetime','".$locationname."','".$locationcode."','$accountnameano','$accountnameid','$subtypeano','$totalamount','$totalamount')";
	$exec43=mysql_query($query43) or die("error in query43".mysql_error());		  
	mysql_query("update master_visitentry set overallpayment='completed' where visitcode='$visitcode'") or die(mysql_error());
	mysql_query("update master_triage set overallpayment='completed' where visitcode='$visitcode'") or die(mysql_error());
	
		header("location:billing_pending_op2.php?billautonumber=$billno&&st=success&&printbill=$printbill");
		exit;
		//header("location:writexml.php?billautonumber=$billno&&st=success&&printbill=$printbill&&frmflag1=frmflag1&&patientcode=$patientcode&&visitcode=$visitcode");
		}
		else
		{
		header("location:billing_pending_op2.php");
		}
		
		}
		else
		{
		header("location:billing_pending_op2.php");
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
$smartap=$execplan['smartap'];

?>
<?php
$querylab1=mysql_query("select * from master_customer where customercode='$patientcode'");
$execlab1=mysql_fetch_array($querylab1);
$patientname=$execlab1['customerfullname'];
$patientaccount=$execlab1['accountname'];

$querylab2=mysql_query("select * from master_accountname where auto_number='$patientaccount'");
$execlab2=mysql_fetch_array($querylab2);
$patientaccount1=$execlab2['accountname'];
$patientaccountid=$execlab2['id'];

$query76 = "select * from master_financialintegration where field='labpaylater'";
$exec76 = mysql_query($query76) or die(mysql_error());
$res76 = mysql_fetch_array($exec76);
$labcoa = $res76['code'];

$query761 = "select * from master_financialintegration where field='radiologypaylater'";
$exec761 = mysql_query($query761) or die(mysql_error());
$res761 = mysql_fetch_array($exec761);

$radiologycoa = $res761['code'];

$query762 = "select * from master_financialintegration where field='servicepaylater'";
$exec762 = mysql_query($query762) or die(mysql_error());
$res762 = mysql_fetch_array($exec762);

$servicecoa = $res762['code'];

$query763 = "select * from master_financialintegration where field='referalpaylater'";
$exec763 = mysql_query($query763) or die(mysql_error());
$res763 = mysql_fetch_array($exec763);

$referalcoa = $res763['code'];

$query764 = "select * from master_financialintegration where field='pharmacypaylater'";
$exec764 = mysql_query($query764) or die(mysql_error());
$res764 = mysql_fetch_array($exec764);

$pharmacycoa = $res764['code'];

$query76 = "select * from master_financialintegration where field='consultationfee'";
$exec76 = mysql_query($query76) or die(mysql_error());
$res76 = mysql_fetch_array($exec76);
$consultationcoa = $res76['code'];

?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$paylaterbillprefix = $res3['paylaterbillprefix'];
$paylaterbillprefix1=strlen($paylaterbillprefix);
$query2 = "select * from billing_paylater where patientcode <> '' order by auto_number desc limit 0, 1";
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

$query85 = "select * from master_visitentry where visitcode='$visitcode' and patientcode='$patientcode'";
$exec85 = mysql_query($query85) or die ("Error in Query1".mysql_error());
$res85 = mysql_fetch_array($exec85);
$consultationfee=$res85['consultationfees'];
$consultationfee = number_format($consultationfee,2,'.','');
$viscode=$res85['visitcode'];
$consultationdate=$res85['consultationdate'];
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


	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	 //To handle ajax dropdown list.
	
	funcPopupPrintFunctionCall();
	
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
<?php include ("js/sales1scripting1.php"); ?>
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
<script type="text/javascript" src="js/insertnewitem7.js"></script>
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
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
</style>

<script src="js/datetimepicker_css.js"></script>
<script>
function loadprintpage1(banum)
{
	var banum = banum;
	window.open("print_paylater_summary.php?billautonumber="+banum+"","Window"+banum+"",'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
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
		document.frmsales.submit();
		//return true;
	}
	}
</script>
<script src="js/autocustomersmartsearch.js"></script>

</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="form1" id="frmsales" method="post" onKeyDown="return disableEnterKey(event)" onSubmit="return funcSaveBill1()">
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
            
                  <?php
						
						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						$res1 = mysql_fetch_array($exec1);
						
						$locationname = $res1["locationname"];
						$locationcode = $res1["locationcode"];
						?>
						<option value="<?php echo $res1locationanum; ?>" <?php if($location!='')if($location==$res1locationanum){echo "selected";}?>><?php echo $res1location; ?></option>
						
                <tr bgcolor="#011E6A">
                <td colspan="4" bgcolor="#CCCCCC" class="bodytext32"><strong>Pay Later Patient Details</strong></td>
                <td  colspan="4" bgcolor="#CCCCCC" class="bodytext32"><strong>Location:&nbsp;&nbsp;<?php echo $locationname ?> </strong></td>
                 <input type="hidden" name="locationcodeget" value="<?php echo $locationcode;?>">
                 <input type="hidden" name="locationnameget" value="<?php echo $locationname;?>">
			 </tr>
			 
		<?php
			if ($st == 'success' && $billautonumber != '' && $patientname != '' && $patientcode !='' && $visitcode !='')
			{
			?>
            <tr>
              <td colspan="8"  align="left" valign="center" bgcolor="#FFFF00" class="bodytext31">&nbsp;
			  * Success. Bill Saved. &nbsp;&nbsp;&nbsp;
			  <input name="billprint" type="button" onClick="return loadprintpage1('<?php echo $billautonumber; ?>')" value="Click Here To Print Summary" class="button" style="border: 1px solid #001E6A"/>
			  <input name="billprint" type="button" onClick="return loadprintpage2('<?php echo $billautonumber; ?>')" value="Click Here To Print Detailed" class="button" style="border: 1px solid #001E6A"/>
			  </td>
              
            </tr>
			<?php
			}
			?>
			
			  <tr>
			    <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Patient  </strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3"><?php echo $patientname; ?>
				<input type="hidden" name="patientname" id="customer" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/>                  </td>
                 
             <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Type</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $patienttype1; ?>
								</td>
		      </tr>
			   <tr>
			    <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="style4">Reg.No</td>
                <td colspan="3" align="left" valign="top" class="bodytext3"><?php echo $patientcode; ?>
				<input type="hidden" name="customercode" id="customercode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<input type="hidden" name="registrationdate" id="registrationdate" value="<?php echo date('Y-m-d'); ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<input type="hidden" name="labcoa" value="<?php echo $labcoa; ?>">
				<input type="hidden" name="radiologycoa" value="<?php echo $radiologycoa; ?>">
				<input type="hidden" name="servicecoa" value="<?php echo $servicecoa; ?>">
				<input type="hidden" name="pharmacycoa" value="<?php echo $pharmacycoa; ?>">
				<input type="hidden" name="referalcoa" value="<?php echo $referalcoa; ?>">
				<input type="hidden" name="consultationcoa" value="<?php echo $consultationcoa; ?>">
		
				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>
				    <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Sub Type</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $patientsubtype1; ?>
				<input type="hidden" name="subtype" id="subtype" value="<?php echo $patientsubtype1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
                <input type="hidden" name="subtypeano" id="subtypeano" value="<?php echo $patientsubtype; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>	
				<input type="hidden" name="paymenttype" id="paymenttype" value="<?php echo $patienttype1; ?>">			</td>
			  </tr>
				  <tr>
				  <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Visit No </strong></td>
                  <td colspan="3" align="left" valign="top" class="bodytext3"><?php echo $visitcode; ?>
				<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
                 <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Account</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $patientaccount1; ?>
				<input type="hidden" name="accountname" id="account" value="<?php echo $patientaccount1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
                <input type="hidden" name="accountnameano" id="accountnameano" value="<?php echo $patientaccount; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
                <input type="hidden" name="accountnameid" id="accountnameid" value="<?php echo $patientaccountid; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
                				</td>
				  </tr>
                   <tr>
				  <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Bill No</strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3"><?php echo $billnumbercode; ?>
				<input type="hidden" name="billno" id="billno" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
                 <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Plan Name</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $patientplan1; ?>
				<input type="hidden" name="account" id="account" value="<?php echo $patientplan1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
				  </tr>
                   <tr>
				  <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Bill Date</strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3"><?php echo $dateonly; ?>
				<input type="hidden" name="billdate" id="billdate" value="<?php echo $dateonly; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
                 <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>&nbsp;</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3">&nbsp;
				<input type="hidden" name="account" id="account" value="" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
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
						$admitid='';
			$colorloopcount = '';
			$totalcopayconsult='';
			$sno = '';
			$totalamount=0;
			
			$query77 = "select * from billing_paylater where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec77 = mysql_query($query77) or die ("Error in Query77".mysql_error());
			$rows77 = mysql_num_rows($exec77);
			if($rows77 == 0)
			{
			
			
			$query17 = "select * from master_visitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec17 = mysql_query($query17) or die ("Error in Query1".mysql_error());
			$res17 = mysql_fetch_array($exec17);
			$consultationfee=$res17['consultationfees'];
			$consultationfee = number_format($consultationfee,2,'.','');
			$viscode=$res17['visitcode'];
			$consultationdate=$res17['consultationdate'];
			$plannumber = $res17['planname'];
			
			$admitid = $res17['admitid'];
			$availablelimit = $res17['availablelimit'];
			
			$queryplanname = "select forall from master_planname where auto_number ='".$plannumber."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execplanname = mysql_query($queryplanname) or die ("Error in Queryplanname".mysql_error());
			$resplanname = mysql_fetch_array($execplanname);
		 	$planforall = $resplanname['forall'];
			
			 $planpercentage=$res17['planpercentage'];
			 $copay=($consultationfee/100)*$planpercentage;
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
			if($planpercentage!=0.00)
			{
			 $totalop=$consultationfee; 
			 $totalcopay=$totalcopay+$copay;
			 $totalcopayconsult=$totalcopayconsult+$copay;
			}
			else
			{
				$totalop=$consultationfee; 
	        	$totalcopay=$totalcopay+$copay;
				}
			
			?>
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $viscode; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'OP Consultation'; ?></div></td>
			     <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $consultationfee; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $consultationfee; ?></div></td>
				 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
             
				</tr>
                
                <?php if(($planpercentage!=0.00)){?>
                <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
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
			$query18 = "select * from master_billing where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec18 = mysql_query($query18) or die ("Error in Query1".mysql_error());
			$res18 = mysql_fetch_array($exec18);
			$billingdatetime=$res18['billingdatetime'];
			$billno=$res18['billnumber'];
			$copayfixed=$res18['copayfixedamount'];
			if($copayfixed != 0.00)
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
			$totalcopayfixedamount=$copayfixed;
			 ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billingdatetime; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Fixed Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $copayfixed; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo $copayfixed; ?></div></td>
			  <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
             
			  </tr>
			  <?php 
			} 
			
    $query11 = "select * from refund_consultation where patientvisitcode='$visitcode' and patientcode='$patientcode'";
	$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
	$num=mysql_num_rows($exec11);
	$res11 = mysql_fetch_array($exec11);
	$res11billnumber = $res11['billnumber'];
	$consultationrefund = $res11['consultation'];
	$res11transactiondate= $res11['billdate'];
    $res11transactiontime= $res11['transactiontime'];

			if($num != 0)
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
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res11transactiondate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res11billnumber; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Consultation Refund'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $consultationrefund; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $consultationrefund; ?></div></td>
			  <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
             
			  </tr>
			  <?php 
			} 
			
			
			  $totallab=0;
			  $query19 = "select * from consultation_lab where labitemcode NOT IN (SELECT labitemcode FROM billing_paynowlab WHERE patientvisitcode='$visitcode' and patientcode='$patientcode') AND  patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemname <> '' and freestatus <> 'yes'  AND labrefund <> 'completed' AND labrefund <> 'refund' and  paymentstatus = 'completed' and sampleid <> ''"; //and approvalstatus <> '2' and approvalstatus = '1'";
			$exec19 = mysql_query($query19) or die ("Error in Query1".mysql_error());
			while($res19 = mysql_fetch_array($exec19))
			{
				$labdate=$res19['consultationdate'];
			$labname=$res19['labitemname'];
			$labcode=$res19['labitemcode'];
			$labrate=$res19['labitemrate'];
			$labrefno=$res19['refno'];
				
				
			
			
			
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
			
			$copay=($labrate/100)*$planpercentage;
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
              <?php 
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
			    $totallab=$totallab+$labrate; 
				$totalcopaylab=$totalcopaylab+$copay;
			   }
			   else
			  {$totallab=$totallab+$labrate;}
			  ?>
              
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labrefno; ?></div></td>
			 <input name="lab[]" id="lab" size="69" type="hidden" value="<?php echo $labname; ?>">
			 <input name="rate5[]" id="rate5" readonly size="8" type="hidden" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $labrate-$copay; } else { echo $labrate;}?>">
			 <input name="labcode[]" id="labcode" readonly size="8" type="hidden" value="<?php echo $labcode; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $labname; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $labrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $labrate; ?></div></td>
			<td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
             </tr>
              <?php if(($planpercentage!=0.00)&&($planforall=='yes')){  $totalcopay=$totalcopay+$copay;?>
                <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $copay; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo $copay; ?></div></td>
			  <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
               
             
			  </tr>
				<?php }?>
			  
			  <?php } 
			  
			  
			  
			  
			  
			  //copay
			   //$totallab=0;
			  $query19 = "select * from consultation_lab where labitemcode  IN (SELECT labitemcode FROM billing_paynowlab WHERE patientvisitcode='$visitcode' and patientcode='$patientcode') AND  patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemname <> '' and freestatus <> 'yes'  AND labrefund <> 'completed' AND labrefund <> 'refund' and  paymentstatus = 'completed' and sampleid <> ''   and approvalstatus <> 2"; //and approvalstatus <> '2' and approvalstatus = '1'";
			$exec19 = mysql_query($query19) or die ("Error in Query1".mysql_error());
			while($res19 = mysql_fetch_array($exec19))
			{
				$labdate=$res19['consultationdate'];
			$labname=$res19['labitemname'];
			$labcode=$res19['labitemcode'];
			$labrate=$res19['labitemrate'];
			$labrefno=$res19['refno'];
				
				
			
			
			
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
			
			$copay=($labrate/100)*$planpercentage;
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
              <?php 
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
			    $totallab=$totallab+$labrate; 
				$totalcopaylab=$totalcopaylab+$copay;
			   }
			   else
			  {$totallab=$totallab+$labrate;}
			  ?>
              
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labrefno; ?></div></td>
			 <input name="lab[]" id="lab" size="69" type="hidden" value="<?php echo $labname; ?>">
			 <input name="rate5[]" id="rate5" readonly size="8" type="hidden" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $labrate-$copay; } else { echo $labrate;}?>">
			 <input name="labcode[]" id="labcode" readonly size="8" type="hidden" value="<?php echo $labcode; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $labname; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $labrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $labrate; ?></div></td>
			<td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
             </tr>
              <?php if(($planpercentage!=0.00)&&($planforall=='yes')){  $totalcopay=$totalcopay+$copay;?>
                <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $copay; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo $copay; ?></div></td>
			  <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
               
             
			  </tr>
				<?php }?>
			  
			  <?php } 
			  ?>
			  
			   <?php 
			   $totalpharm=0;
			  $query23 = "select * from pharmacysales_details where  visitcode='$visitcode' and patientcode='$patientcode' group by itemcode";
			$exec23 = mysql_query($query23) or die ("Error in Query1".mysql_error());
			$pharno = mysql_num_rows($exec23);
			while($res23 = mysql_fetch_array($exec23))
			{
				$phaquantity=0;
			$phaamount=0;
			$totalrefquantity=0;
			$reftotalamount=0;
			$phadate=$res23['entrydate'];
			$phaname=$res23['itemname'];
			$phaitemcode=$res23['itemcode'];
			$pharate=$res23['rate'];
			$pharno1=0;
			
			$serviceitemcode199b=array();
		$query199b = mysql_query("select a.auto_number,b.itemcode as itemcode from consultation_services as a JOIN master_services as b ON a.servicesitemcode=b.itemcode where a.patientvisitcode = '$visitcode'");
/*  		$query199b = mysql_query("select a.auto_number,b.itemcode as itemcode from consultation_services as a JOIN master_services as b ON a.servicesitemcode=b.itemcode where b.pkg='Yes' limit 0,50");
	*/
		$count199b = mysql_num_rows($query199b);
		if($count199b>0){
  	    while($fetch199b = mysql_fetch_array($query199b)){			
			array_push($serviceitemcode199b,$fetch199b['itemcode']);
			//$serviceitemcode199b=$fetch199b['itemcode'];
		}
		}
		
 $serviceitemcode=implode("','",$serviceitemcode199b);
	
		$query199a = mysql_query("select auto_number from master_serviceslinking where servicecode IN('$serviceitemcode') and itemcode = '$phaitemcode' and recordstatus<>'deleted'");
		$count199a = mysql_num_rows($query199a);
		if($count199a>0){
			$pharno-=1; 			
			continue;
		}
				$queryphar = "select auto_number from billing_paynowpharmacy where medicinecode='".$phaitemcode."' and patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$execphar = mysql_query($queryphar) or die ("Error in Query1".mysql_error());
			$pharno1 = mysql_num_rows($execphar);
				if($pharno1==0){
			
		    $query33 = "select * from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode'";
			$exec33 = mysql_query($query33) or die ("Error in Query1".mysql_error());
		    while($res33 = mysql_fetch_array($exec33))
			{
			$quantity=$res33['quantity'];
			$phaquantity=$phaquantity+$quantity;
			$amount=$res33['totalamount'];
			$phaamount=$phaamount+$amount;
			}
			
			$query47 = "select * from pharmacysalesreturn_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode'";
			$exec47 = mysql_query($query47) or die(mysql_error());
			while($res47 = mysql_fetch_array($exec47))
			{
			$refquantity = $res47['quantity'];
			$refamount = $res47['totalamount'];
			$totalrefquantity =  $totalrefquantity + $refquantity;
			$reftotalamount = $reftotalamount + $refamount;
			}
			$realquantity = $phaquantity - $totalrefquantity;
			$phaamount = $phaamount - $reftotalamount;
	
			$phaamount=number_format($phaamount,2,'.','');
			 $query28 = "select * from master_consultationpharm where   patientvisitcode='$visitcode' and patientcode='$patientcode' and medicinecode='$phaitemcode' ";
			$exec28 = mysql_query($query28) or die ("Error in Query1".mysql_error());
			$res28 = mysql_fetch_array($exec28);
			$pharefno=$res28['refno'];
			$excludestatus=$res28['excludestatus'];
			$approvalstatus = $res28['approvalstatus'];
			
			
			if($excludestatus == '')
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
			//$totalpharm=$totalpharm+$phaamount;
			?>
            <?php 
			$copay=(($pharate*$realquantity)/100)*$planpercentage;
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
			    $totalpharm=$totalpharm+$phaamount;
				 $totalcopaypharm=$totalcopaypharm+$copay;
			   }
			   else
			  {$totalpharm=$totalpharm+$phaamount;}
			  ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phadate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $phaname; ?></div></td>
			 <input name="medicinename[]" type="hidden" id="medicinename" size="25" value="<?php echo $phaname; ?>">
			 <input name="quantity[]" type="hidden" id="quantity" size="8" readonly value="<?php echo $realquantity; ?>">
			 <input name="rate[]" type="hidden" id="rate" readonly size="8" value="<?php   echo $pharate; ?>">
			 <input name="amount[]" type="hidden" id="amount" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $phaamount-$copay; } else { echo $phaamount;}  ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $realquantity; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $pharate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $phaamount; ?></div></td>
			<td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
             </tr>
             <?php if(($planpercentage!=0.00)&&($planforall=='yes')){  $totalcopay=$totalcopay+$copay;?>
                <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $copay; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo $copay; ?></div></td>
			  <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
               
             
			  </tr>
				<?php }?>
			  
			  <?php }
			  }}
			  ?>
              
              <!--copay-->
               <?php 
			  // $totalpharm=0;
			  $query23 = "select * from pharmacysales_details where  visitcode='$visitcode' and patientcode='$patientcode'   group by itemcode";
			$exec23 = mysql_query($query23) or die ("Error in Query1".mysql_error());
			$pharno = mysql_num_rows($exec23);
			while($res23 = mysql_fetch_array($exec23))
			{
				$phaquantity=0;
			$phaamount=0;
			$totalrefquantity=0;
			$reftotalamount=0;
			$phadate=$res23['entrydate'];
			$phaname=$res23['itemname'];
			$phaitemcode=$res23['itemcode'];
			$pharate=$res23['rate'];
			$pharno1=0;
			$serviceitemcode199b=array();
	$query199b = mysql_query("select a.auto_number,b.itemcode as itemcode from consultation_services as a JOIN master_services as b ON a.servicesitemcode=b.itemcode where a.patientvisitcode = '$visitcode'");
/*  		$query199b = mysql_query("select a.auto_number,b.itemcode as itemcode from consultation_services as a JOIN master_services as b ON a.servicesitemcode=b.itemcode where b.pkg='Yes' limit 0,50");
	*/
		$count199b = mysql_num_rows($query199b);
		if($count199b>0){
  	    while($fetch199b = mysql_fetch_array($query199b)){			
			array_push($serviceitemcode199b,$fetch199b['itemcode']);
			//$serviceitemcode199b=$fetch199b['itemcode'];
		}
		}
		
 $serviceitemcode=implode("','",$serviceitemcode199b);


 	$query199a = mysql_query("select auto_number from master_serviceslinking where servicecode IN('$serviceitemcode') and itemcode = '$phaitemcode' and recordstatus<>'deleted'");
		$count199a = mysql_num_rows($query199a);
		if($count199a>0){
			$pharno-=1; 			
			continue;
		}
				 $queryphar = "select auto_number from billing_paynowpharmacy where medicinecode='".$phaitemcode."' and patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$execphar = mysql_query($queryphar) or die ("Error in Query1".mysql_error());
			$pharno1 = mysql_num_rows($execphar);
				if($pharno1>0){
			
			 $query33 = "select * from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode'";
			$exec33 = mysql_query($query33) or die ("Error in Query1".mysql_error());
		    while($res33 = mysql_fetch_array($exec33))
			{
			$quantity=$res33['quantity'];
			$phaquantity=$phaquantity+$quantity;
			$amount=$res33['totalamount'];
			$phaamount=$phaamount+$amount;
			}
			
			$query47 = "select * from pharmacysalesreturn_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode'";
			$exec47 = mysql_query($query47) or die(mysql_error());
			while($res47 = mysql_fetch_array($exec47))
			{
			$refquantity = $res47['quantity'];
			$refamount = $res47['totalamount'];
			$totalrefquantity =  $totalrefquantity + $refquantity;
			$reftotalamount = $reftotalamount + $refamount;
			}
			$realquantity = $phaquantity - $totalrefquantity;
			$phaamount = $phaamount - $reftotalamount;
	
			$phaamount=number_format($phaamount,2,'.','');
			$query28 = "select * from master_consultationpharm where  patientvisitcode='$visitcode' and patientcode='$patientcode' and medicinecode='$phaitemcode' and approvalstatus <> 2 ";
			$exec28 = mysql_query($query28) or die ("Error in Query1".mysql_error());
			$res28 = mysql_fetch_array($exec28);
			$rowspharm = mysql_num_rows($exec28);
			$pharefno=$res28['refno'];
			$excludestatus=$res28['excludestatus'];
			$approvalstatus = $res28['approvalstatus'];
			
			
			if($excludestatus == '' && $rowspharm > 0)
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
			//$totalpharm=$totalpharm+$phaamount;
			?>
            <?php 
			$copay=(($pharate*$realquantity)/100)*$planpercentage;
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
			    $totalpharm=$totalpharm+$phaamount;
				 $totalcopaypharm=$totalcopaypharm+$copay;
			   }
			   else
			  {$totalpharm=$totalpharm+$phaamount;}
			  ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phadate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $phaname; ?></div></td>
			 <input name="medicinename[]" type="hidden" id="medicinename" size="25" value="<?php echo $phaname; ?>">
			 <input name="quantity[]" type="hidden" id="quantity" size="8" readonly value="<?php echo $realquantity; ?>">
			 <input name="rate[]" type="hidden" id="rate" readonly size="8" value="<?php   echo $pharate; ?>">
			 <input name="amount[]" type="hidden" id="amount" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $phaamount-$copay; } else { echo $phaamount;}  ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $realquantity; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $pharate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $phaamount; ?></div></td>
			<td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
             </tr>
             <?php if(($planpercentage!=0.00)&&($planforall=='yes')){  $totalcopay=$totalcopay+$copay;?>
                <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $copay; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo $copay; ?></div></td>
			  <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
               
             
			  </tr>
				<?php }?>
			  
			  <?php }
			  }}
			  ?>
                <?php 
				if($pharno>0){
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
			$desprate=0;
			$despratetotal=0;
			$totalcopaydesp=0;
			 if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
			    $desprate=($desprate/100)*$planpercentage;
				$totalcopaydesp=$desprate;
			   }
			  ?>
			 <tr <?php echo $colorcode; ?>>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phadate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo "DISPENSING"; ?></div></td>
			 <input name="medicinename[]" type="hidden" id="medicinename" size="25" value="<?php echo "DISPENSING"; ?>">
			 <input name="quantity[]" type="hidden" id="quantity" size="8" readonly value="<?php echo "1"; ?>">
			 <input name="rate[]" type="hidden" id="rate" readonly size="8" value="<?php   echo $desprate; ?>">
			 <input name="amount[]" type="hidden" id="amount" readonly size="8" value="<?php echo $desprate; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $despratetotal; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $despratetotal; ?></div></td>
			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
             </tr>
              <?php if(($planpercentage!=0.00)&&($planforall=='yes')){ $copay=$desprate;  $totalcopay=$totalcopay+$copay; ?>
                <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $copay; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo $copay; ?></div></td>
			  <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
               
             
			  </tr>
				
			  
			  <?php }}
			  ?>
              
              
              
              
              
              
              
			    <?php 
				$totalrad=0;
				$totalcopayrad='';
			  $query20 = "select * from consultation_radiology where radiologyitemcode NOT IN (SELECT radiologyitemcode FROM billing_paynowradiology WHERE patientvisitcode='$visitcode' and patientcode='$patientcode') AND patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemname <> '' and radiologyrefund <> 'refund' and radiologyrefund <> 'completed' and  paymentstatus = 'completed'"; //and approvalstatus <> '2' and approvalstatus = '1'";
			$exec20 = mysql_query($query20) or die ("Error in Query1".mysql_error());
			while($res20 = mysql_fetch_array($exec20))
			{
			$raddate=$res20['consultationdate'];
			$radname=$res20['radiologyitemname'];
			$radrate=$res20['radiologyitemrate'];
			$radref=$res20['refno'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
			$copay=($radrate/100)*$planpercentage;
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
			
			//$totalrad=$totalrad+$radrate;
			?>
            <?php 
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
			    $totalrad=$totalrad+$radrate; 
				$totalcopayrad=$totalcopayrad+$copay;
			   }
			   else
			  {$totalrad=$totalrad+$radrate;}
			  ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $raddate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $radref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $radname; ?></div></td>
			 <input name="radiology[]" id="radiology" type="hidden" size="69" autocomplete="off" value="<?php echo $radname; ?>">
			 <input name="rate8[]" type="hidden" id="rate8" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $radrate-$copay; } else { echo $radrate;}?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $radrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $radrate; ?></div></td>
			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
             </tr>
              <?php if(($planpercentage!=0.00)&&($planforall=='yes')){  $totalcopay=$totalcopay+$copay;?>
                <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $copay; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo $copay; ?></div></td>
			  <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
               
             
			  </tr>
				<?php }?>
			  
			  <?php }
			  ?>
              <!--copay-->
                <?php 
			//	$totalrad=0;
			//	$totalcopayrad='';
			  $query20 = "select * from consultation_radiology where radiologyitemcode  IN (SELECT radiologyitemcode FROM billing_paynowradiology WHERE patientvisitcode='$visitcode' and patientcode='$patientcode') AND patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemname <> '' and radiologyrefund <> 'refund' and radiologyrefund <> 'completed' and  paymentstatus = 'completed' and approvalstatus <> 2"; //and approvalstatus <> '2' and approvalstatus = '1'";
			$exec20 = mysql_query($query20) or die ("Error in Query1".mysql_error());
			while($res20 = mysql_fetch_array($exec20))
			{
			$raddate=$res20['consultationdate'];
			$radname=$res20['radiologyitemname'];
			$radrate=$res20['radiologyitemrate'];
			$radref=$res20['refno'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
			$copay=($radrate/100)*$planpercentage;
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
			
			//$totalrad=$totalrad+$radrate;
			?>
            <?php 
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
			    $totalrad=$totalrad+$radrate; 
				$totalcopayrad=$totalcopayrad+$copay;
			   }
			   else
			  {$totalrad=$totalrad+$radrate;}
			  ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $raddate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $radref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $radname; ?></div></td>
			 <input name="radiology[]" id="radiology" type="hidden" size="69" autocomplete="off" value="<?php echo $radname; ?>">
			 <input name="rate8[]" type="hidden" id="rate8" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $radrate-$copay; } else { echo $radrate;}?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $radrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $radrate; ?></div></td>
			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
             </tr>
              <?php if(($planpercentage!=0.00)&&($planforall=='yes')){  $totalcopay=$totalcopay+$copay;?>
                <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $copay; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo $copay; ?></div></td>
			  <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
               
             
			  </tr>
				<?php }?>
			  
			  <?php }
			  ?>
			  	    <?php 
					
					$totalser=0;
			  $query21 = "select * from consultation_services where servicesitemcode NOT IN (SELECT servicesitemcode FROM billing_paynowservices WHERE patientvisitcode='$visitcode' and patientcode='$patientcode') AND patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> ''   and  paymentstatus = 'completed'  group by servicesitemcode";
			$exec21 = mysql_query($query21) or die ("Error in Query1".mysql_error());
			while($res21 = mysql_fetch_array($exec21))
			{
			$serdate=$res21['consultationdate'];
			$sername=$res21['servicesitemname'];
			$serrate=$res21['servicesitemrate'];
			$sercode=$res21['servicesitemcode'];
			$serref=$res21['refno'];
			
			$query2111 = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' ";//and approvalstatus <> '2' and approvalstatus = '1'";
			$exec2111 = mysql_query($query2111) or die ("Error in Query2111".mysql_error());
			$numrow2111 = mysql_num_rows($exec2111);
			$resqty = mysql_fetch_array($exec2111);
			$serqty=$resqty['serviceqty'];
			$serrefqty=$resqty['refundquantity'];
			
			$serqty = $serqty-$serrefqty;
			$totserrate=$resqty['amount'];
			$totserrate1=$resqty['amount'];
		    $perrate=$resqty['servicesitemrate'];
			//$totserrate=$serrate*$serqty;
			
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$copay=(($serrate*$serqty)/100)*$planpercentage;
			$copaysingle=($serrate/100)*$planpercentage;
		 	$copayperservice=$copay/$serqty;
			$totamt=$resqty['amount'];
			
			$totserrate=$totamt;
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
			//$totalser=$totalser+$totserrate;
			?>
             <?php 
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
			   
				$serratetot=$serrate;
				//$totalser=$totalser+$serratetot; 
				$totserrate = $totamt-$copay;
				$totalser=$totalser+$totamt;
				
				$totalcopayser=$totalcopayser+$copay;
			   }
			   else if(($planpercentage!=0.00)&&($planforall==''))
			  { 
			    $serratetot=$serrate;
				//$totamt=$perrate*$numrow2111;
			    $totalser=$totalser+$totamt; 
				//$totalcopayser=$totalcopayser+$copay;
			   }
			   
			   else
			  {
				   $serratetot=$serrate;
				  $totalser=$totalser+$totamt;}
			  ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sername; ?></div></td>
			 <input name="services[]" type="hidden" id="services" size="69" value="<?php echo $sername; ?>">
			 <input name="rate3[]" type="hidden" id="rate3" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $serratetot-$copaysingle; } else { echo $serratetot;}?>">
			  <input name="quantityser[]" type="hidden" id="quantityser" readonly size="8" value="<?php echo $serqty; ?>">
              <input name="totalservice3[]" type="hidden" id="totalservice3" readonly size="8" value="<?php echo $totserrate; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serqty; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $serrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totamt,2,'.',''); ?></div></td>
			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
             </tr>
              <?php if(($planpercentage!=0.00)&&($planforall=='yes')){  $totalcopay=$totalcopay+$copay;  $copayperser=$copay/$serqty;?>
                <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serqty; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $copayperser; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo $copay; ?></div></td>
			  <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
               
             
			  </tr>
				<?php }?>
			  
			  <?php }
			  ?>
              <!--copay-->
              <?php 
					
			//		$totalser=0;
			  $query21 = "select * from consultation_services where servicesitemcode  IN (SELECT servicesitemcode FROM billing_paynowservices WHERE patientvisitcode='$visitcode' and patientcode='$patientcode') AND patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> ''   and  paymentstatus = 'completed'   and approvalstatus <> 2 group by servicesitemcode";
			$exec21 = mysql_query($query21) or die ("Error in Query1".mysql_error());
			while($res21 = mysql_fetch_array($exec21))
			{
			$serdate=$res21['consultationdate'];
			$sername=$res21['servicesitemname'];
			$serrate=$res21['servicesitemrate'];
			$sercode=$res21['servicesitemcode'];
			$serref=$res21['refno'];
			
			$query2111 = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' ";//and approvalstatus <> '2' and approvalstatus = '1'";
			$exec2111 = mysql_query($query2111) or die ("Error in Query2111".mysql_error());
			$numrow2111 = mysql_num_rows($exec2111);
			$resqty = mysql_fetch_array($exec2111);
			$serqty=$resqty['serviceqty'];
			$serrefqty=$resqty['refundquantity'];
			
			$serqty = $serqty-$serrefqty;
			$totserrate=$resqty['amount'];
		    $perrate=$resqty['servicesitemrate'];
			//$totserrate=$serrate*$serqty;
			
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$copay=(($serrate*$serqty)/100)*$planpercentage;
			$copaysingle=($serrate/100)*$planpercentage;
		 	$copayperservice=$copay/$serqty;
			$totamt=$resqty['amount'];
			
			$totserrate=$totamt;
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
			//$totalser=$totalser+$totserrate;
			?>
             <?php 
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
			   
				$serratetot=$serrate;
				//$totalser=$totalser+$serratetot; 
				$totserrate = $totamt-$copay;
				$totalser=$totalser+$totamt;
				
				$totalcopayser=$totalcopayser+$copay;
			   }
			   else if(($planpercentage!=0.00)&&($planforall==''))
			  { 
			    $serratetot=$serrate;
				//$totamt=$perrate*$numrow2111;
			    $totalser=$totalser+$totamt; 
				//$totalcopayser=$totalcopayser+$copay;
			   }
			   
			   else
			  {
				   $serratetot=$serrate;
				  $totalser=$totalser+$totamt;}
			  ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sername; ?></div></td>
			 <input name="services[]" type="hidden" id="services" size="69" value="<?php echo $sername; ?>">
			 <input name="rate3[]" type="hidden" id="rate3" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  echo $serratetot-$copaysingle; } else { echo $serratetot;}?>">
			  <input name="quantityser[]" type="hidden" id="quantityser" readonly size="8" value="<?php echo $serqty; ?>">
              <input name="totalservice3[]" type="hidden" id="totalservice3" readonly size="8" value="<?php echo $totserrate; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serqty; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $serrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totamt,2,'.',''); ?></div></td>
			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
             </tr>
              <?php if(($planpercentage!=0.00)&&($planforall=='yes')){  $totalcopay=$totalcopay+$copay;  $copayperser=$copay/$serqty;?>
                <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serqty; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $copayperser; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo $copay; ?></div></td>
			  <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
               
             
			  </tr>
				<?php }?>
			  
			  <?php }
			  ?>
			   <?php 
			   $totalref=0;
			  $query22 = "select * from consultation_referal where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus = 'completed' and approvalstatus <> 2";
			$exec22 = mysql_query($query22) or die ("Error in Query1".mysql_error());
			while($res22 = mysql_fetch_array($exec22))
			{
			$refdate=$res22['consultationdate'];
			$refname=$res22['referalname'];
			$refrate=$res22['referalrate'];
			$refref=$res22['refno'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
			$copay=($refrate/100)*$planpercentage;
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
			//$totalref=$totalref+$refrate;
			?>
             <?php 
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
			    $totalref=$totalref+$refrate; 
				$totalcopayref=$totalcopayref+$copay;
			   }
			   else
			  {$totalref=$totalref+$refrate;}
			  ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refdate; ?></div></td>
			  <input type="hidden" name="referalname" value="<?php echo $refname; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $refname; ?></div></td>
			 <input name="referal[]" type="hidden" id="referal" size="69" value="<?php echo $refname; ?>">
			 <input name="rateref[]" type="hidden" id="rateref" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  
			 echo $refrate-$copay; } else { echo $refrate;}  ?>">
              <input name="raterefamt[]" type="hidden" id="raterefamt" readonly size="8" value="<?php echo $refrate;  ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $refrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $refrate; ?></div></td>
			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
             </tr>
              <?php if(($planpercentage!=0.00)&&($planforall=='yes')){  $totalcopay=$totalcopay+$copay;?>
                <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $copay; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo $copay; ?></div></td>
			  <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
               
             
			  </tr>
				<?php }?>
			  
			  <?php }
			  ?>
              
              
              
            <?php /*?>  <!--copay-->
               <?php 
			   $totalref=0;
			  $query22 = "select * from consultation_referal where patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$exec22 = mysql_query($query22) or die ("Error in Query1".mysql_error());
			while($res22 = mysql_fetch_array($exec22))
			{
			$refdate=$res22['consultationdate'];
			$refname=$res22['referalname'];
			$refrate=$res22['referalrate'];
			$refref=$res22['refno'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
			$copay=($refrate/100)*$planpercentage;
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
			//$totalref=$totalref+$refrate;
			?>
             <?php 
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
			    $totalref=$totalref+$refrate; 
				$totalcopayref=$totalcopayref+$copay;
			   }
			   else
			  {$totalref=$totalref+$refrate;}
			  ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refdate; ?></div></td>
			  <input type="hidden" name="referalname" value="<?php echo $refname; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $refname; ?></div></td>
			 <input name="referal[]" type="hidden" id="referal" size="69" value="<?php echo $refname; ?>">
			 <input name="rateref[]" type="hidden" id="rateref" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  
			 echo $refrate-$copay; } else { echo $refrate;}  ?>">
              <input name="raterefamt[]" type="hidden" id="raterefamt" readonly size="8" value="<?php echo $refrate;  ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $refrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $refrate; ?></div></td>
			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
             </tr>
              <?php if(($planpercentage!=0.00)&&($planforall=='yes')){  $totalcopay=$totalcopay+$copay;?>
                <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $copay; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo $copay; ?></div></td>
			  <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
               
             
			  </tr>
				<?php }?>
			  
			  <?php }
			  ?><?php */?>
              
              
              
              
              
              
              
              
              
              
              
              
               <?php 
			   $totalamb=0;
			    $snohome='0';
			  $query22 = "select * from op_ambulance where patientvisitcode='$visitcode' and billtype = 'PAY LATER' and patientcode='$patientcode' and paymentstatus='completed'";
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
			
			$copay=(($refrate*$qty)/100)*$planpercentage;
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
			//$totalamb=$totalamb+$refamount;
			//$totalambulance=$totalamb;
			?>
            <?php 
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
			    $totalamb=$totalamb+$refamount;
				$totalcopayamb=$totalcopayamb+$copay;
				$totalambulance=$totalamb;
			   }
			   else
			  {$totalamb=$totalamb+$refamount;
			  $totalambulance=$totalamb;
			  }
			  ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno1 = $sno1 + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refdate; ?></div></td>
			  <input type="hidden" name="referalname" value="<?php echo $refname; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $refname; ?></div></td>
			 <?php /*?> <input name="referal[]" type="hidden" id="referal" size="69" value="<?php echo $refname; ?>">
			 <input name="rate4[]" type="hidden" id="rate4" readonly size="8" value="<?php echo $refrate; ?>"><?php */?>
             <input type="hidden" name="ambulancecount[]" value="<?php echo $snohome;?>">
              <input name="accountname[]" type="hidden" id="accountname" readonly size="8" value="<?php echo $accountname; ?>">
               <input name="description[]" type="hidden" id="description" readonly size="8" value="<?php echo $refname; ?>">
                <input name="quantityamb[]" type="hidden" id="quantity" readonly size="8" value="<?php echo $qty; ?>">
                 <input name="rateamb[]" type="hidden" id="rateamb" readonly size="8" value="<?php echo $refrate; ?>">
                  <input name="amountamb[]" type="hidden" id="amountamb" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  
			 echo $refamount-$copay; } else { echo $refamount;}  ?>">
                   <input name="actualamount[]" type="hidden" id="actualamount" readonly size="8" value="<?php echo $refamount; ?>">
                   <input name="amdocno[]" type="hidden" id="amdocno" readonly size="8" value="<?php echo $refref; ?>">
			<?php $snohome=$snohome+1;?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $qty; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $refrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $refamount; ?></div></td>
			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
             </tr>
              <?php if(($planpercentage!=0.00)&&($planforall=='yes')){  $totalcopay=$totalcopay+$copay;?>
                <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $qty; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $copay/$qty; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo $copay; ?></div></td>
			  <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
               
             
			  </tr>
				<?php }?>
			  
			  <?php }
			  ?><input type="hidden" name="ambcount" value="<?php echo $ambcount;?>">
               <?php 
			   $totalhom=0;
			   $snohome='0';
			  $query22 = "select * from homecare where patientvisitcode='$visitcode' and billtype = 'PAY LATER' and patientcode='$patientcode' and paymentstatus='completed'";
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
			
			$copay=(($refrate*$qty)/100)*$planpercentage;
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
            <?php 
			  if(($planpercentage!=0.00)&&($planforall=='yes'))
			  { 
			    $totalhom=$totalhom+$refamount;
				$totalcopayhom=$totalcopayhom+$copay;
				$totalhomecare=$totalhom;
			   }
			   else
			  {
				  $totalhom=$totalhom+$refamount;
			$totalhomecare=$totalhom;
				 // $totalamb=$totalamb+$refamount;
				  }
			  ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno2 = $sno2 + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refdate; ?></div></td>
			  <input type="hidden" name="referalname" value="<?php echo $refname; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $refname; ?></div></td>
			<?php /*?>  <input name="referal[]" type="hidden" id="referal" size="69" value="<?php echo $refname; ?>">
			 <input name="rate4[]" type="hidden" id="rate4" readonly size="8" value="<?php echo $refrate; ?>"><?php */?>
             <input type="hidden" name="ambulancecounthom[]" value="<?php echo $snohome;?>">
             <?php /*?> <input name="accountname2[]" type="hidden" id="accountname" readonly size="8" value="<?php echo $accountname; ?>">
               <input name="description2[]" type="hidden" id="description" readonly size="8" value="<?php echo $refname; ?>">
                <input name="quantity2[]" type="hidden" id="quantity" readonly size="8" value="<?php echo $qty; ?>">
                 <input name="rate2[]" type="hidden" id="rate" readonly size="8" value="<?php echo $refrate; ?>">
                  <input name="amount2[]" type="hidden" id="amount" readonly size="8" value="<?php echo $refamount; ?>">
                   <input name="amdocno2[]" type="hidden" id="amdocno" readonly size="8" value="<?php echo $refref; ?>"><?php */?>
               <input name="accountnamehom[]" type="hidden" id="accountname" readonly size="8" value="<?php echo $accountname; ?>">
               <input name="descriptionhom[]" type="hidden" id="description" readonly size="8" value="<?php echo $refname; ?>">
                <input name="quantityhom[]" type="hidden" id="quantityhom" readonly size="8" value="<?php echo $qty; ?>">
                 <input name="ratehom[]" type="hidden" id="ratehom" readonly size="8" value="<?php echo $refrate; ?>">
                  <input name="amounthom[]" type="hidden" id="amounthom" readonly size="8" value="<?php if(($planpercentage!=0.00)&&($planforall=='yes')){  
			 echo $refamount-$copay; } else { echo $refamount;} ?>">
                   <input name="actualamounthom[]" type="hidden" id="actualamounthom" readonly size="8" value="<?php echo $refamount; ?>">
                   <input name="amdocnohom[]" type="hidden" id="amdocno" readonly size="8" value="<?php echo $refref; ?>">
			<?php $snohome=$snohome+1;?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $qty; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $refrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $refamount; ?></div></td>
			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
             </tr>
              <?php if(($planpercentage!=0.00)&&($planforall=='yes')){  $totalcopay=$totalcopay+$copay;?>
                <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Copay Amount'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $qty; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $copay/$qty; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo $copay; ?></div></td>
			  <td width="4%"  align="left" valign="center" 
                class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
               
             
			  </tr>
				<?php }?>
			  
			  <?php }
			  ?><input type="hidden" name="ambcount1" value="<?php echo $ambcount1;?>">
              
              
              
              
              
              
              
              
              
              
              
              
              
              
			  			   <?php 
			   $totaldepartmentref=0;
			  $query231 = "select * from consultation_departmentreferal where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='completed' and approvalstatus <> 2";
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
			  if(($planpercentage!=0.00)&&($planforall=='yes')){ 
				  
				  $overalltotal=($totalop+$totallab+$totalpharm+$totalrad+$totalser+$totalref+$totalambulance+$totalhomecare+$totaldepartmentref+$despratetotal)-$totalcopay-$totalcopayfixedamount+$consultationrefund;
			  $overalltotal=number_format($overalltotal,2,'.','');
			  $consultationtotal=$totalop;
			   $consultationtotal=number_format($consultationtotal,2,'.','');
			   $netpay= $overalltotal;
			   $netpay=number_format($netpay,2,'.','');
			  }
			 else if(($planpercentage!=0.00)&&($planforall=='')){
			 
			 // echo $totalser;
				   $overalltotal=($totalop+$totallab+$totalpharm+$totalrad+$totalser+$totalref+$totalambulance+$totalhomecare+$totaldepartmentref+$despratetotal)-$totalcopay-$totalcopayfixedamount+$consultationrefund;
			   //echo $totalcopay;
			   //echo $totalop;
			  $consultationtotal=$totalop;
			   $consultationtotal=number_format($consultationtotal,2,'.','');
			   $netpay= $overalltotal;
			   $netpay=number_format($netpay,2,'.','');
			  }
			  else{
			  
				  $overalltotal=($totalop+$totallab+$totalpharm+$totalrad+$totalser+$totalref+$totalambulance+$totalhomecare+$totaldepartmentref+$despratetotal)-$totalcopay+$consultationrefund-$totalcopayfixedamount;
			  $overalltotal=number_format($overalltotal,2,'.','');
			  //echo $totalcopay;
			  $consultationtotal=$totalop-$totalcopay+$consultationrefund-$totalcopayfixedamount;
			   $consultationtotal=number_format($consultationtotal,2,'.','');
			   $netpay= $consultationtotal+$totallab+$totalpharm+$totalrad+$totalser+$totalref+$totaldepartmentref+$totalambulance+$totalhomecare+$despratetotal;
			   $netpay=number_format($netpay,2,'.','');
			  }
			  ?>
			  
			  <?php
			  }   //for checking whether patient finalized
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
		<tr>
		 <td colspan="7" class="bodytext31" valign="center"  align="left" >&nbsp;</td>
		</tr>
		<tr>
		<td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
		 <tr bgcolor="#011E6A">
                <td colspan="7" bgcolor="#CCCCCC" class="bodytext32"><strong>Payable Details</strong></td>
			 </tr>
          <tr>
		    <td width="39%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#CBDBFA"><div align="center"><strong>&nbsp;</strong></div></td>
			
              <td width="37%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#CBDBFA"><div align="left">Total for Consultation</div></td>
				<td width="16%"  align="left" valign="center" 
                bgcolor="#CBDBFA" class="bodytext31"><div align="right">
				<?php echo number_format($consultationtotal-$totalcopayconsult+$consultationrefund,2,'.',''); ?></div></td>
				<input type="hidden" name="consultation" value="<?php echo $consultationtotal-$totalcopayconsult+$consultationrefund; ?>">
				 <td width="15%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#CBDBFA"><div align="center"><strong>&nbsp;</strong></div></td>
			
			</tr>
				<tr>
				  <td width="39%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
			
				<td width="37%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left">Total for Pharmacy </div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><?php echo number_format($totalpharm-$totalcopaypharm,2,'.',''); ?></div></td>
				 <td width="23%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
			
				</tr>
				<tr>
				  <td width="39%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#CBDBFA"><div align="center"><strong>&nbsp;</strong></div></td>
			
                <td width="37%"  align="left" valign="center" 
                bgcolor="#CBDBFA" class="bodytext31"><div align="left">Total for Laboratory</div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#CBDBFA" class="bodytext31"><div align="right"><?php echo number_format($totallab-$totalcopaylab,2,'.',''); ?></div></td>
				 <td width="23%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#CBDBFA"><div align="center"><strong>&nbsp;</strong></div></td>
			
				</tr>
				<tr>
				  <td width="39%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
			
					<td width="37%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left">Total for Radiology </div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><?php echo number_format($totalrad-$totalcopayrad,2,'.',''); ?></div></td>
				 <td width="23%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
			
				</tr>
				<tr>
				  <td width="39%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#CBDBFA"><div align="center"><strong>&nbsp;</strong></div></td>
			
				<td width="37%"  align="left" valign="center" 
                bgcolor="#CBDBFA" class="bodytext31"><div align="left">Total for Service	</div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#CBDBFA" class="bodytext31"><div align="right"><?php echo number_format($totalser-$totalcopayser,2,'.',''); ?></div></td>
				 <td width="23%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#CBDBFA"><div align="center"><strong>&nbsp;</strong></div></td>
			
				</tr>
				<tr>
				  <td width="39%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
			
				<td width="37%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left">Total for Referral		</div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><?php echo number_format($totalref-$totalcopayref,2,'.',''); ?></div></td>
				 <td width="23%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
			
				</tr>
                <tr>
				  <td width="39%" class="bodytext31" valign="center"  align="left" 
                 bgcolor="#CBDBFA"><div align="center"><strong>&nbsp;</strong></div></td>
			
				<td width="37%"  align="left" valign="center" 
                bgcolor="#CBDBFA" class="bodytext31"><div align="left">Total for Ambulance		</div></td>
				<td width="8%"  align="left" valign="center" 
                 bgcolor="#CBDBFA" class="bodytext31"><div align="right"><?php echo number_format($totalambulance-$totalcopayamb,2,'.',''); ?></div></td>
				 <td width="23%" class="bodytext31" valign="center"  align="left" 
                 bgcolor="#CBDBFA"><div align="center"><strong>&nbsp;</strong></div></td>
			
				</tr>
                <tr>
				  <td width="39%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
			
				<td width="37%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left">Total for Homecare		</div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><?php echo number_format($totalhomecare-$totalcopayhom,2,'.',''); ?></div></td>
				 <td width="23%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
			
				</tr>
                
                
                 <tr>
				  <td width="39%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
			
				<td width="37%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left">Total for Dispensing Fee		</div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><?php echo number_format($despratetotal-$totalcopaydesp,2,'.',''); ?></div></td>
				 <td width="23%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
			
				</tr>
                
				<tr>
				  <td width="39%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc"><div align="center"><strong>&nbsp;</strong></div></td>
			
              <td width="37%"  align="left" valign="center" 
                bgcolor="#cccccc" class="bodytext31"><div align="left"><strong>Net Payable	</strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#cccccc" class="bodytext31"><div align="right"><strong><?php echo  $netpay; ?></strong></div></td>
				<input type="hidden" name="totalamount" id="totalamount" value="<?php echo  $netpay; ?>">
				<input type="hidden" id="smartbenefitno">
				<input type="hidden" id="admitid">
				  <td width="23%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc"><div align="center"><strong>&nbsp;</strong></div></td>
			
            </tr>
				  </tbody>
				  </table>				  </td>
				    <tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext32"><div align="left"><strong>User Name</strong> <span class="bodytext3">
                 <?php echo $_SESSION['username']; ?>
                </span>&nbsp;&nbsp;&nbsp;&nbsp;<b>Available Limit:<input type="text" name="availablelimite" id="availablelimit" value="<?php echo $availablelimit;?>" <?php  if($availablelimit < $netpay){?> style="background:#F00;color:#FFF" <?php }?>><?php if($availablelimit < $netpay){ ?><b style="background:#CC0;padding:3px">Available Limit is Less than the Totall Bill Value. Please Seek Approval</b><?php }?></b></div></td>
                <td height="32" colspan="6" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
				    </tr>
				  

      
	        <tr>
         
		 <td colspan="2" align="right" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
		 
		 <select name="printbill">
                      <option value="detailed">Detailed</option>
                      <option value="summary">Summary</option>
                    </select>
					                  
		  <input type="hidden" name="frm1submit1" value="" />
                  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
                  <?php if($admitid!=''){?>
				  <input name="fetch" type="button" value="FETCH" style="height:40px; width:100px; background-color:#FFCC00;" onClick="return funcCustomerSmartSearch()"/>
				  <?php }?>
                  
                   <?php if($smartap==1)
				   { 
				   if($availablelimit >= $netpay){?>
				   <input name="Submit222" type="button" onclick = "return loadprintpage4('smart')" value="Save and Post To Smart" class="button"/>
				  <?php }?>
                  
                    <?php if($availablelimit < $netpay){?>
				   <input name="seekapproval" type="button" onclick = "return loadprintpage4('seek')" value="Seek Approval" class="button"/>
				  <?php }}
				  if($smartap==0){
				  ?>
               <input name="Submit222" type="button" onclick = "return loadprintpage4('submit')" value="Save Bill" class="button"/>
               <?php }?>
               		 </td>
      </tr>
    
    </table>

</form>
<script>

function loadprintpage4(btn)
{
	form1.method="POST";
	if(btn=='smart')
	{
	form1.frm1submit1.value="frm1submit1";
	}
	if(btn=='seek')
	{
	form1.frm1submit1.value="seekapproval";
	}
	if(btn=='submit')
	{
	form1.frm1submit1.value="frm1submit1";
	}
	form1.action="billing_paylater.php" 
	form1.submit();
	}
	
</script>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>
