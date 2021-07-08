<?php //eval(base64_decode(
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$updatedate = date("Y-m-d");
$titlestr = 'SALES BILL';
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
    $visitcode=$_REQUEST["visitcode"];
	$patientcode = $_REQUEST["customercode"];
	$patientname = $_REQUEST["patientname"];
	$locationcode = $_REQUEST['locationcode'];
	$locationname = $_REQUEST['locationname'];
	
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

$query77 = "select * from master_visitentry where visitcode='$visitcode'";
		$exec77 = mysql_query($query77) or die(mysql_error());
		$res77 = mysql_fetch_array($exec77);
		$doctor = $res77['consultingdoctor'];
		
		$query78 = "select * from master_doctor where auto_number='$doctor'";
		$exec78 = mysql_query($query78) or die(mysql_error());
		$res78 = mysql_fetch_array($exec78);
		$doctorname = $res78['doctorname'];
		
	$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$paylaterbillprefix = 'Cr.N-';
$paylaterbillprefix1=strlen($paylaterbillprefix);
$query2 = "select * from refund_paylater order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["billno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='Cr.N-'.'1';
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
	
	
	$billnumbercode = 'Cr.N-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}

$billno = $billnumbercode;
	$accountname= $_REQUEST['accountname'];
	$accountcode = $_REQUEST['accountcode'];
	$totalamount=$_REQUEST['grandtotalamount'];
	$totalamount=-$totalamount;
	$totalrefundamount = $_REQUEST['grandtotalamount'];
	$billdate=$_REQUEST['billdate'];
	$finalizedbillno=$_REQUEST['finalizedbillno'];
	$labcoa = $_REQUEST['labcoa'];
	$radiologycoa = $_REQUEST['radiologycoa'];
	$servicecoa = $_REQUEST['servicecoa'];
	$pharmacycoa = $_REQUEST['pharmacycoa'];
	$referalcoa = $_REQUEST['referalcoa'];
	
		 
		 foreach($_POST['lab'] as $key => $value)
		{
		$labname=$_POST['lab'][$key];
		$labquery=mysql_query("select * from master_lab where itemname='$labname'");
		$execlab=mysql_fetch_array($labquery);
		$labcode=$execlab['itemcode'];
	    $labrate=$_POST['labrate'][$key];
		foreach($_POST['ref'] as $check1)
		{
		$refund=$check1;
		if($refund == $labname)
	{
	$query45 = "insert into refund_paylaterlab(patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,accountname,billdate,billnumber,username,labcoa,locationcode,locationname)values
	           ('$patientcode','$patientname','$visitcode','$labcode','$labname','$labrate','$accountname','$updatedate','$billno','$username','$labcoa','$locationcode','$locationname')";
	$exec45 = mysql_query($query45) or die(mysql_error());		   

	mysql_query("update consultation_lab set labrefund='refund' where patientvisitcode='$visitcode' and labitemcode='$labcode'");
	}
	}
	}
	foreach($_POST['rad'] as $key => $value)
		{
		$radname=$_POST['rad'][$key];
		$radiologyquery=mysql_query("select * from master_radiology where itemname='$radname'");
		$execradiology=mysql_fetch_array($radiologyquery);
		$radiologycode=$execradiology['itemcode'];
		$radiologyrate=$_POST['radrate'][$key];
		foreach($_POST['ref'] as $check2)
		{
		$refund2=$check2;
			if($refund2 == $radname)
	{
	$query46 = "insert into refund_paylaterradiology(patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,accountname,billdate,billnumber,username,radiologycoa,locationcode,locationname)values
	           ('$patientcode','$patientname','$visitcode','$radiologycode','$radname','$radiologyrate','$accountname','$updatedate','$billno','$username','$radiologycoa','$locationcode','$locationname')";
	$exec46 = mysql_query($query46) or die(mysql_error());		   

	mysql_query("update consultation_radiology set radiologyrefund='refund' where patientvisitcode='$visitcode' and radiologyitemname='$radname'");
	}
	}
	}
	foreach($_POST['ser'] as $key => $value)
		{
		$sername=$_POST['ser'][$key];
		$servicequery=mysql_query("select * from master_services where itemname='$sername'");
		$execservice=mysql_fetch_array($servicequery);
		$servicescode=$execservice['itemcode'];
		$servicesrate=$_POST['servicerate'][$key];
	    $serviceqty = $_POST['refundserqty'][$key];
		$serviceamt = $_POST['refseramt'][$key];
		foreach($_POST['ref'] as $check3)
		{
		$refund3=$check3;
			if($refund3 == $sername)
	{
	 $query47 = "insert into refund_paylaterservices(patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,accountname,billdate,billnumber,username,servicecoa, servicesitemqty, amount,locationcode,locationname)values
	           ('$patientcode','$patientname','$visitcode','$servicescode','$sername','$servicesrate','$accountname','$updatedate','$billno','$username','$servicecoa','$serviceqty','$serviceamt','$locationcode','$locationname')";
	$exec47 = mysql_query($query47) or die(mysql_error());	
	
	$query89 = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode = '$patientcode' and servicesitemname='$sername'";
	$exec89 = mysql_query($query89) or die ("Error in Query89".mysql_error());
	$res89 = mysql_fetch_array($exec89);	
	$refundqty89 = $res89['refundquantity'];  
	
	$refundqty = $refundqty89 + $serviceqty;

	mysql_query("update consultation_services set refundquantity='$refundqty' where patientvisitcode='$visitcode' and servicesitemname='$sername'");
	}
	}
	}
	foreach($_POST['referalname'] as $key => $value)
		{
		$referalname=$_POST['referalname'][$key];
		$referalquery=mysql_query("select * from master_doctor where doctorname='$referalname'");
		$execreferal=mysql_fetch_array($referalquery);
		$referalcode=$execreferal['doctorcode'];
		$referalrate=$_POST['referalrate'][$key];

		foreach($_POST['ref'] as $check4)
		{
		$refund4=$check4;
			if($refund4 == $referalname)
	{
	$query47 = "insert into refund_paylaterreferal(patientcode,patientname,patientvisitcode,referalcode,referalname,referalrate,accountname,billdate,billnumber,username,referalcoa,locationcode,locationname)values
	           ('$patientcode','$patientname','$visitcode','$referalcode','$referalname','$referalrate','$accountname','$updatedate','$billno','$username','$referalcoa','$locationcode','$locationname')";
	$exec47 = mysql_query($query47) or die(mysql_error());		   

	mysql_query("update consultation_referal set referalrefund='refund' where patientvisitcode='$visitcode' and referalname='$referalname'");
	}
	}
	}
	
	foreach($_POST['ambname'] as $key => $value)
		{
		$ambname=$_POST['ambname'][$key];
		//$servicequery=mysql_query("select * from master_services where itemname='$sername'");
		//$execservice=mysql_fetch_array($servicequery);
		//$servicescode=$execservice['itemcode'];
		$ambrate=$_POST['ambrate'][$key];
	    $ambqty = $_POST['refambqty'][$key];
		$ambamt = $_POST['ambamt4'][$key];
		$ambdoc = $_POST['ambdoc'][$key];
		foreach($_POST['ref'] as $check5)
		{
		$refund5=$check5;
			if($refund5 == $ambname)
	{
	 $query47 = "insert into refund_paylaterambulance(patientcode,patientname,patientvisitcode,docno,description,rate,accountname,billdate,billnumber,username,ambulancecoa,quantity, amount,locationcode,locationname)values
	           ('$patientcode','$patientname','$visitcode','$ambdoc','$ambname','$ambrate','$accountname','$updatedate','$billno','$username','','$ambqty','$ambamt','$locationcode','$locationname')";
	$exec47 = mysql_query($query47) or die(mysql_error());	
	
	}
	}
	}
	
	foreach($_POST['homename'] as $key => $value)
		{
		$homename=$_POST['homename'][$key];
		//$servicequery=mysql_query("select * from master_services where itemname='$sername'");
		//$execservice=mysql_fetch_array($servicequery);
		//$servicescode=$execservice['itemcode'];
		$homerate=$_POST['homerate'][$key];
	    $homeqty = $_POST['refhomeqty'][$key];
		$homeamt = $_POST['homeamt4'][$key];
		$homedoc = $_POST['homedoc'][$key];
		foreach($_POST['ref'] as $check6)
		{
		$refund6=$check6;
			if($refund6 == $homename)
	{
	 $query47 = "insert into refund_paylaterhomecare(patientcode,patientname,patientvisitcode,docno,description,rate,accountname,billdate,billnumber,username,homecarecoa,quantity, amount,locationcode,locationname)values
	           ('$patientcode','$patientname','$visitcode','$homedoc','$homename','$homerate','$accountname','$updatedate','$billno','$username','','$homeqty','$homeamt','$locationcode','$locationname')";
	$exec47 = mysql_query($query47) or die(mysql_error());	
	
	}
	}
	}
	
	if($_POST['cons'] != '')
		{
		$cons=$_POST['cons'];
		$crate = $_POST['rates'];
		foreach($_POST['ref'] as $check61)
		{
		$refund61=$check61;
			if($refund61 == $cons)
	{
	 $query471 = "insert into refund_paylaterconsultation(patientcode,patientname,patientvisitcode,consultation,accountname,billdate,billnumber,username,locationcode,locationname,ipaddress,billtype)values
	           ('$patientcode','$patientname','$visitcode','$crate','$accountname','$updatedate','$billno','$username','$locationcode','$locationname','$ipaddress','$billtype')";
	$exec471 = mysql_query($query471) or die(mysql_error());	
	}
	}
	}
	
			mysql_query("insert into refund_paylater(billno,patientname,patientcode,visitcode,totalamount,billdate,accountname,referalname,doctorstatus,finalizationbillno,locationcode,locationname)values('$billno','$patientname','$patientcode','$visitcode','$totalamount','$billdate','$accountname','$referalname','unpaid','$finalizedbillno','$locationcode','$locationname')") or die(mysql_error());
	
	$query83="insert into master_transactionpaylater(patientname,patientcode,visitcode,transactiondate,accountname,docno,ipaddress,companyanum,companyname,financialyear,transactiontype,paymenttype,subtype,transactionamount,receivableamount,doctorname,locationcode,locationname,billbalanceamount,billamount,accountnameid)values('$patientname',
	          '$patientcode','$visitcode','$dateonly','$accountname','$billno','$ipaddress','$companyanum','$companyname','$financialyear','paylatercredit','$patienttype1','$patientsubtype1','$totalrefundamount','$totalrefundamount','$doctorname','$locationcode','$locationname','$totalrefundamount','$totalrefundamount','$accountcode')";
	$exec83=mysql_query($query83) or die("error in query83".mysql_error());		  

		header("location:paylaterrefundlist.php?billno=$billno&&patientcode=$patientcode&&visitcode=$visitcode");
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

<?php eval(base64_decode('DQokUXVlcnlsYWI9bXlzcWxfcXVlcnkoInNlbGVjdCAqIGZyb20gbWFzdGVyX2N1c3RvbWVyIHdoZXJlIGN1c3RvbWVyY29kZT0nJHBhdGllbnRjb2RlJyIpOw0KJGV4ZWNsYWI9bXlzcWxfZmV0Y2hfYXJyYXkoJFF1ZXJ5bGFiKTsNCiAkcGF0aWVudGFnZT0kZXhlY2xhYlsnYWdlJ107DQogJHBhdGllbnRnZW5kZXI9JGV4ZWNsYWJbJ2dlbmRlciddOw0KDQokcGF0aWVudHR5cGU9JGV4ZWNsYWJbJ21haW50eXBlJ107DQokcXVlcnl0eXBlPW15c3FsX3F1ZXJ5KCJzZWxlY3QgKiBmcm9tIG1hc3Rlcl9wYXltZW50dHlwZSB3aGVyZSBhdXRvX251bWJlcj0nJHBhdGllbnR0eXBlJyIpOw0KJGV4ZWN0eXBlPW15c3FsX2ZldGNoX2FycmF5KCRxdWVyeXR5cGUpOw0KJHBhdGllbnR0eXBlMT0kZXhlY3R5cGVbJ3BheW1lbnR0eXBlJ107DQokcGF0aWVudHN1YnR5cGU9JGV4ZWNsYWJbJ3N1YnR5cGUnXTsNCiRxdWVyeXN1YnR5cGU9bXlzcWxfcXVlcnkoInNlbGVjdCAqIGZyb20gbWFzdGVyX3N1YnR5cGUgd2hlcmUgYXV0b19udW1iZXI9JyRwYXRpZW50c3VidHlwZSciKTsNCiRleGVjc3VidHlwZT1teXNxbF9mZXRjaF9hcnJheSgkcXVlcnlzdWJ0eXBlKTsNCiRwYXRpZW50c3VidHlwZTE9JGV4ZWNzdWJ0eXBlWydzdWJ0eXBlJ107DQokcGF0aWVudHBsYW49JGV4ZWNsYWJbJ3BsYW5uYW1lJ107DQokcXVlcnlwbGFuPW15c3FsX3F1ZXJ5KCJzZWxlY3QgKiBmcm9tIG1hc3Rlcl9wbGFubmFtZSB3aGVyZSBhdXRvX251bWJlcj0nJHBhdGllbnRwbGFuJyIpOw0KJGV4ZWNwbGFuPW15c3FsX2ZldGNoX2FycmF5KCRxdWVyeXBsYW4pOw0KJHBhdGllbnRwbGFuMT0kZXhlY3BsYW5bJ3BsYW5uYW1lJ107DQoNCg==')); ?>
<?php 
$querylab1=mysql_query("select * from master_customer where customercode='$patientcode'");
$execlab1=mysql_fetch_array($querylab1);
$patientname=$execlab1['customerfullname'];
$patientaccount=$execlab1['accountname'];

$querylab2=mysql_query("select * from master_accountname where auto_number='$patientaccount'");
$execlab2=mysql_fetch_array($querylab2);
$patientaccount1=$execlab2['accountname'];
$patientaccountid1=$execlab2['id'];

$query76 = "select * from master_financialintegration where field='labpaylaterrefund'";
$exec76 = mysql_query($query76) or die(mysql_error());
$res76 = mysql_fetch_array($exec76);
$labcoa = $res76['code'];

$query761 = "select * from master_financialintegration where field='radiologypaylaterrefund'";
$exec761 = mysql_query($query761) or die(mysql_error());
$res761 = mysql_fetch_array($exec761);

$radiologycoa = $res761['code'];

$query762 = "select * from master_financialintegration where field='servicepaylaterrefund'";
$exec762 = mysql_query($query762) or die(mysql_error());
$res762 = mysql_fetch_array($exec762);

$servicecoa = $res762['code'];

$query763 = "select * from master_financialintegration where field='referalpaylaterrefund'";
$exec763 = mysql_query($query763) or die(mysql_error());
$res763 = mysql_fetch_array($exec763);

$referalcoa = $res763['code'];

$query764 = "select * from master_financialintegration where field='pharmacypaylaterrefund'";
$exec764 = mysql_query($query764) or die(mysql_error());
$res764 = mysql_fetch_array($exec764);

$pharmacycoa = $res764['code'];

?>
<?php eval(base64_decode('IA0KJHF1ZXJ5NTQ9InNlbGVjdCAqIGZyb20gYmlsbGluZ19wYXlsYXRlciB3aGVyZSBwYXRpZW50Y29kZT0nJHBhdGllbnRjb2RlJyBhbmQgdmlzaXRjb2RlPSckdmlzaXRjb2RlJyI7DQokZXhlYzU0PW15c3FsX3F1ZXJ5KCRxdWVyeTU0KSBvciBkaWUobXlzcWxfZXJyb3IoKSk7DQokcmVzNTQ9bXlzcWxfZmV0Y2hfYXJyYXkoJGV4ZWM1NCk7DQokZmluYWxpemVkYmlsbG51bWJlcj0kcmVzNTRbJ2JpbGxubyddOw0K')); ?>
<?php 
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$paylaterbillprefix = 'Cr.N-';
$paylaterbillprefix1=strlen($paylaterbillprefix);
$query2 = "select * from refund_paylater order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["billno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='Cr.N-'.'1';
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
	
	
	$billnumbercode = 'Cr.N-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
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

function disableEnterKey()
{

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
<?php eval(base64_decode('IGluY2x1ZGUgKCJqcy9zYWxlczFzY3JpcHRpbmcxLnBocCIpOyA=')); ?>
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
	var varBillAutoNumber = "<?php eval(base64_decode('IC8vZWNobyAkcHJldmlvdXNiaWxsYXV0b251bWJlcjsg')); ?>";
	var varBillCompanyAnum = "<?php eval(base64_decode('IGVjaG8gJF9TRVNTSU9OWyJjb21wYW55YW51bSJdOyA=')); ?>";
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
		window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&billnumber="+varBillNumber+"","OriginalWindowA4<?php eval(base64_decode('IGVjaG8gJGJhbnVtOyA=')); ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	}
	if (varPaperSize == "A5")
	{
		window.open("print_bill1_a5.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&billnumber="+varBillNumber+"","OriginalWindowA5<?php eval(base64_decode('IGVjaG8gJGJhbnVtOyA=')); ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
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
		window.location="sales1.php?defaulttax="+varDefaultTax+"&&delbillst=<?php eval(base64_decode('IGVjaG8gJGRlbEJpbGxTdDsg')); ?>&&delbillautonumber="+<?php eval(base64_decode('IGVjaG8gJGRlbEJpbGxBdXRvbnVtYmVyOyA=')); ?>+"&&delbillnumber="+<?php eval(base64_decode('IGVjaG8gJGRlbEJpbGxOdW1iZXI7IA==')); ?>+"";
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


function updateboxcons(varSerialNumber1,varrate1,totalcount1)
{

var varSerialNumber1 = varSerialNumber1;
var varrate1 = varrate1;
var totalcount1 = totalcount1;
var grandtotal1=0;
if(document.getElementById("reffcc"+varSerialNumber1+"").checked == true)
{
for(i=1;i<=totalcount1;i++)
{
if(document.getElementById("reffcc"+i+"").checked == true)
{
//alert('h');
var totalamount1=document.getElementById("rates").value;
totalamount1=totalamount1.replace(/\,/g,'');
if(totalamount1 == "")
{
totalamount1=0;
}

grandtotal1=parseFloat(grandtotal1)+parseFloat(totalamount1);
}
}
document.getElementById("totalamtconsultation").value=grandtotal1.toFixed(2);
var totalamountconsultation=document.getElementById("totalamtconsultation").value;
var totalamountconsultation=totalamountconsultation.replace(/\,/g,'');
if(totalamountconsultation== "")
{
totalamountconsultation=0;
}

var totalamountlab=document.getElementById("totalamtlab").value;
if(totalamountlab == "")
{
totalamountlab=0;
}
//alert(totalamountlab);
var totalamountrad=document.getElementById("totalamtrad").value;
if(totalamountrad == "")
{
totalamountrad=0;
}
//alert(totalamountrad);
var totalamountser=document.getElementById("totalamtser").value;
if(totalamountser == "")
{
totalamountser=0;
}
var totalamountref=document.getElementById("totalamtref").value;
if(totalamountref == "")
{
totalamountref=0;
}
//alert(totalamountser);
var totalamountamb=document.getElementById("totalamtamb").value;
if(totalamountamb == "")
{
totalamountamb=0;
}
var totalamounthome=document.getElementById("totalamthome").value;
if(totalamounthome == "")
{
totalamounthome=0;
}
//alert(totalamountser);
var grandtotalamount=parseInt(totalamountconsultation)+parseInt(totalamountlab)+parseInt(totalamountrad)+parseInt(totalamountser)+parseInt(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome);
document.getElementById("grandtotalamount").value=grandtotalamount.toFixed(2);

}
else
{
grandtotal1=0;
for(i=1;i<=totalcount1;i++)
{

if(document.getElementById("reffcc"+i+"").checked == false)
{
if(document.getElementById("reffcc"+i+"").checked == true)
{
var totalamount1=document.getElementById("rates").value;
}
else
{
var totalamount1=0;
}
if(totalamount1 == "")
{
totalamount1=0;
}
//alert(totalamount);
grandtotal1=parseFloat(grandtotal1)+parseFloat(totalamount1);

}
else
{
if(document.getElementById("reffcc"+i+"").checked == true)
{
var totalamount1=document.getElementById("rates").value;
}
else
{
var totalamount1=0;
}
if(totalamount1 == "")
{
totalamount1=0;
}
//alert(totalamount);
grandtotal1=parseFloat(grandtotal1)+parseFloat(totalamount1);

}
}
document.getElementById("totalamtconsultation").value=grandtotal1.toFixed(2);
var totalamountconsultation=document.getElementById("totalamtconsultation").value;
var totalamountconsultation=totalamountconsultation.replace(/\,/g,'');
if(totalamountconsultation== "")
{
totalamountconsultation=0;
}

var totalamountlab=document.getElementById("totalamtlab").value;
if(totalamountlab == "")
{
totalamountlab=0;
}
//alert(totalamountlab);
var totalamountrad=document.getElementById("totalamtrad").value;
if(totalamountrad == "")
{
totalamountrad=0;
}
//alert(totalamountrad);
var totalamountser=document.getElementById("totalamtser").value;
if(totalamountser == "")
{
totalamountser=0;
}
var totalamountref=document.getElementById("totalamtref").value;
if(totalamountref == "")
{
totalamountref=0;
}
var totalamountamb=document.getElementById("totalamtamb").value;
if(totalamountamb == "")
{
totalamountamb=0;
}
var totalamounthome=document.getElementById("totalamthome").value;
if(totalamounthome == "")
{
totalamounthome=0;
}
//alert(totalamountser);
var grandtotalamount=parseInt(totalamountconsultation)+parseInt(totalamountlab)+parseInt(totalamountrad)+parseInt(totalamountser)+parseInt(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome);
document.getElementById("grandtotalamount").value=grandtotalamount.toFixed(2);


}
}

function updatebox(varSerialNumber,varrate,totalcount)
{

var varSerialNumber = varSerialNumber;
var varrate = varrate;
var totalcount = totalcount;
//alert(totalcount);
var grandtotal=0;
if(document.getElementById("reff"+varSerialNumber+"").checked == true)
{

for(i=1;i<=totalcount;i++)
{
if(document.getElementById("reff"+i+"").checked == true)
{
var totalamount=document.getElementById("rate"+i+"").value;

if(totalamount == "")
{
totalamount=0;
}

grandtotal=parseFloat(grandtotal)+parseFloat(totalamount);
}
}
document.getElementById("totalamtlab").value=grandtotal.toFixed(2);
var totalamountconsultation=document.getElementById("totalamtconsultation").value;
var totalamountconsultation=totalamountconsultation.replace(/\,/g,'');
if(totalamountconsultation== "")
{
totalamountconsultation=0;
}

var totalamountlab=document.getElementById("totalamtlab").value;
if(totalamountlab == "")
{
totalamountlab=0;
}
//alert(totalamountlab);
var totalamountrad=document.getElementById("totalamtrad").value;
if(totalamountrad == "")
{
totalamountrad=0;
}
//alert(totalamountrad);
var totalamountser=document.getElementById("totalamtser").value;
if(totalamountser == "")
{
totalamountser=0;
}
var totalamountref=document.getElementById("totalamtref").value;
if(totalamountref == "")
{
totalamountref=0;
}
//alert(totalamountser);
var totalamountamb=document.getElementById("totalamtamb").value;
if(totalamountamb == "")
{
totalamountamb=0;
}
var totalamounthome=document.getElementById("totalamthome").value;
if(totalamounthome == "")
{
totalamounthome=0;
}
//alert(totalamountser);
var grandtotalamount=parseInt(totalamountconsultation)+parseInt(totalamountlab)+parseInt(totalamountrad)+parseInt(totalamountser)+parseInt(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome);
document.getElementById("grandtotalamount").value=grandtotalamount.toFixed(2);

}
else
{
grandtotal=0;
for(i=1;i<=totalcount;i++)
{

if(document.getElementById("reff"+i+"").checked == false)
{
if(document.getElementById("reff"+i+"").checked == true)
{
var totalamount=document.getElementById("rate"+i+"").value;
}
else
{
var totalamount=0;
}
if(totalamount == "")
{
totalamount=0;
}
//alert(totalamount);
grandtotal=parseFloat(grandtotal)+parseFloat(totalamount);

}
else
{
if(document.getElementById("reff"+i+"").checked == true)
{
var totalamount=document.getElementById("rate"+i+"").value;
}
else
{
var totalamount=0;
}
if(totalamount == "")
{
totalamount=0;
}
//alert(totalamount);
grandtotal=parseFloat(grandtotal)+parseFloat(totalamount);

}
}
document.getElementById("totalamtlab").value=grandtotal.toFixed(2);
var totalamountconsultation=document.getElementById("totalamtconsultation").value;
var totalamountconsultation=totalamountconsultation.replace(/\,/g,'');
if(totalamountconsultation== "")
{
totalamountconsultation=0;
}

var totalamountlab=document.getElementById("totalamtlab").value;
if(totalamountlab == "")
{
totalamountlab=0;
}
//alert(totalamountlab);
var totalamountrad=document.getElementById("totalamtrad").value;
if(totalamountrad == "")
{
totalamountrad=0;
}
//alert(totalamountrad);
var totalamountser=document.getElementById("totalamtser").value;
if(totalamountser == "")
{
totalamountser=0;
}
var totalamountref=document.getElementById("totalamtref").value;
if(totalamountref == "")
{
totalamountref=0;
}
//alert(totalamountser);
var totalamountamb=document.getElementById("totalamtamb").value;
if(totalamountamb == "")
{
totalamountamb=0;
}
var totalamounthome=document.getElementById("totalamthome").value;
if(totalamounthome == "")
{
totalamounthome=0;
}
//alert(totalamountser);
var grandtotalamount=parseInt(totalamountconsultation)+parseInt(totalamountlab)+parseInt(totalamountrad)+parseInt(totalamountser)+parseInt(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome);
document.getElementById("grandtotalamount").value=grandtotalamount.toFixed(2);


}
}

function updatebox1(varSerialNumber1,varrate1,totalcount1)
{

var varSerialNumber1 = varSerialNumber1;
var varrate1 = varrate1;
var totalcount1 = totalcount1;
//alert(totalcount1);
var grandtotal1=0;
if(document.getElementById("reff1"+varSerialNumber1+"").checked == true)
{
for(i=1;i<=totalcount1;i++)
{
if(document.getElementById("reff1"+i+"").checked == true)
{
//alert('h');
var totalamount1=document.getElementById("rate1"+i+"").value;

if(totalamount1 == "")
{
totalamount1=0;
}

grandtotal1=parseFloat(grandtotal1)+parseFloat(totalamount1);
}
}
document.getElementById("totalamtrad").value=grandtotal1.toFixed(2);
var totalamountconsultation=document.getElementById("totalamtconsultation").value;
var totalamountconsultation=totalamountconsultation.replace(/\,/g,'');
if(totalamountconsultation== "")
{
totalamountconsultation=0;
}

var totalamountlab=document.getElementById("totalamtlab").value;
if(totalamountlab == "")
{
totalamountlab=0;
}
//alert(totalamountlab);
var totalamountrad=document.getElementById("totalamtrad").value;
if(totalamountrad == "")
{
totalamountrad=0;
}
//alert(totalamountrad);
var totalamountser=document.getElementById("totalamtser").value;
if(totalamountser == "")
{
totalamountser=0;
}
var totalamountref=document.getElementById("totalamtref").value;
if(totalamountref == "")
{
totalamountref=0;
}
//alert(totalamountser);
var totalamountamb=document.getElementById("totalamtamb").value;
if(totalamountamb == "")
{
totalamountamb=0;
}
var totalamounthome=document.getElementById("totalamthome").value;
if(totalamounthome == "")
{
totalamounthome=0;
}
//alert(totalamountser);
var grandtotalamount=parseInt(totalamountconsultation)+parseInt(totalamountlab)+parseInt(totalamountrad)+parseInt(totalamountser)+parseInt(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome);
document.getElementById("grandtotalamount").value=grandtotalamount.toFixed(2);

}
else
{
grandtotal1=0;
for(i=1;i<=totalcount1;i++)
{

if(document.getElementById("reff1"+i+"").checked == false)
{
if(document.getElementById("reff1"+i+"").checked == true)
{
var totalamount1=document.getElementById("rate1"+i+"").value;
}
else
{
var totalamount1=0;
}
if(totalamount1 == "")
{
totalamount1=0;
}
//alert(totalamount);
grandtotal1=parseFloat(grandtotal1)+parseFloat(totalamount1);

}
else
{
if(document.getElementById("reff1"+i+"").checked == true)
{
var totalamount1=document.getElementById("rate1"+i+"").value;
}
else
{
var totalamount1=0;
}
if(totalamount1 == "")
{
totalamount1=0;
}
//alert(totalamount);
grandtotal1=parseFloat(grandtotal1)+parseFloat(totalamount1);

}
}
document.getElementById("totalamtrad").value=grandtotal1.toFixed(2);
var totalamountconsultation=document.getElementById("totalamtconsultation").value;
var totalamountconsultation=totalamountconsultation.replace(/\,/g,'');
if(totalamountconsultation== "")
{
totalamountconsultation=0;
}

var totalamountlab=document.getElementById("totalamtlab").value;
if(totalamountlab == "")
{
totalamountlab=0;
}
//alert(totalamountlab);
var totalamountrad=document.getElementById("totalamtrad").value;
if(totalamountrad == "")
{
totalamountrad=0;
}
//alert(totalamountrad);
var totalamountser=document.getElementById("totalamtser").value;
if(totalamountser == "")
{
totalamountser=0;
}
var totalamountref=document.getElementById("totalamtref").value;
if(totalamountref == "")
{
totalamountref=0;
}
var totalamountamb=document.getElementById("totalamtamb").value;
if(totalamountamb == "")
{
totalamountamb=0;
}
var totalamounthome=document.getElementById("totalamthome").value;
if(totalamounthome == "")
{
totalamounthome=0;
}
//alert(totalamountser);
var grandtotalamount=parseInt(totalamountconsultation)+parseInt(totalamountlab)+parseInt(totalamountrad)+parseInt(totalamountser)+parseInt(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome);
document.getElementById("grandtotalamount").value=grandtotalamount.toFixed(2);

}
}
function updatebox3()
{
if(document.getElementById("reff3").checked == true)
{
var totalamount3=document.getElementById("rates").value;
//alert(totalamount3);
var totalamount3=totalamount3.replace(/\,/g,'');
document.getElementById("totalamtconsultation").value=totalamount3;

var totalamountconsultation = document.getElementById("totalamtconsultation").value;
if(totalamountconsultation == '')
{
totalamountconsultation = 0;
}
var totalamountlab=document.getElementById("totalamtlab").value;
if(totalamountlab == "")
{
totalamountlab=0;
}
//alert(totalamountlab);
var totalamountrad=document.getElementById("totalamtrad").value;
if(totalamountrad == "")
{
totalamountrad=0;
}
//alert(totalamountrad);
var totalamountser=document.getElementById("totalamtser").value;
if(totalamountser == "")
{
totalamountser=0;
}
var totalamountref=document.getElementById("totalamtref").value;
if(totalamountref == "")
{
totalamountref=0;
}
//alert(totalamountser);
var totalamountamb=document.getElementById("totalamtamb").value;
if(totalamountamb == "")
{
totalamountamb=0;
}
var totalamounthome=document.getElementById("totalamthome").value;
if(totalamounthome == "")
{
totalamounthome=0;
}
//alert(totalamountser);
var grandtotalamount=parseInt(totalamountconsultation)+parseInt(totalamountlab)+parseInt(totalamountrad)+parseInt(totalamountser)+parseInt(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome);
document.getElementById("grandtotalamount").value=grandtotalamount.toFixed(2);

}
else
{
var totalamount3=0;
document.getElementById("totalamtconsultation").value=totalamount3.toFixed(2);
var totalamountconsultation = document.getElementById("totalamtconsultation").value;
if(totalamountconsultation == '')
{
totalamountconsultation = 0;
}
var totalamountlab=document.getElementById("totalamtlab").value;
if(totalamountlab == "")
{
totalamountlab=0;
}
//alert(totalamountlab);
var totalamountrad=document.getElementById("totalamtrad").value;
if(totalamountrad == "")
{
totalamountrad=0;
}
//alert(totalamountrad);
var totalamountser=document.getElementById("totalamtser").value;
if(totalamountser == "")
{
totalamountser=0;
}
var totalamountref=document.getElementById("totalamtref").value;
if(totalamountref == "")
{
totalamountref=0;
}
var totalamountamb=document.getElementById("totalamtamb").value;
if(totalamountamb == "")
{
totalamountamb=0;
}
var totalamounthome=document.getElementById("totalamthome").value;
if(totalamounthome == "")
{
totalamounthome=0;
}
//alert(totalamountser);
var grandtotalamount=parseInt(totalamountconsultation)+parseInt(totalamountlab)+parseInt(totalamountrad)+parseInt(totalamountser)+parseInt(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome);
document.getElementById("grandtotalamount").value=grandtotalamount.toFixed(2);

}
}
function updatebox2(varSerialNumber2,varrate2,totalcount2)
{
	var grandtotal2 = 0;
	for(var i=1;i<=totalcount2;i++)
	{
		//alert(i);
		if(document.getElementById("reff2"+i)!= null)
		{
			if(document.getElementById("reff2"+i).checked  == true)
			{
				var refseramt = document.getElementById("refseramt"+i+"").value;
				//var totalamount2=document.getElementById("rate2"+i+"").value;
				var totalamount2=parseFloat(refseramt);
				
				if(totalamount2 == "")
				{
					totalamount2=0;
				}
				
				grandtotal2=parseFloat(grandtotal2)+parseFloat(totalamount2);
			}
			//alert(grandtotal2);
			document.getElementById("totalamtser").value=grandtotal2.toFixed(2);
			var totalamountconsultation=document.getElementById("totalamtconsultation").value;
			var totalamountconsultation=totalamountconsultation.replace(/\,/g,'');
			if(totalamountconsultation== "")
			{
			totalamountconsultation=0;
			}
			
			var totalamountlab=document.getElementById("totalamtlab").value;
			if(totalamountlab == "")
			{
			totalamountlab=0;
			}
			//alert(totalamountlab);
			var totalamountrad=document.getElementById("totalamtrad").value;
			if(totalamountrad == "")
			{
			totalamountrad=0;
			}
			//alert(totalamountrad);
			var totalamountser=document.getElementById("totalamtser").value;
			if(totalamountser == "")
			{
			totalamountser=0;
			}
			var totalamountref=document.getElementById("totalamtref").value;
			if(totalamountref == "")
			{
			totalamountref=0;
			}
			var totalamountamb=document.getElementById("totalamtamb").value;
			if(totalamountamb == "")
			{
			totalamountamb=0;
			}
			var totalamounthome=document.getElementById("totalamthome").value;
			if(totalamounthome == "")
			{
			totalamounthome=0;
			}
			//alert(totalamountser);
			var grandtotalamount=parseInt(totalamountconsultation)+parseInt(totalamountlab)+parseInt(totalamountrad)+parseInt(totalamountser)+parseInt(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome);
			document.getElementById("grandtotalamount").value=grandtotalamount.toFixed(2);

		}
	}
	
}
function updatebox4(varSerialNumber4,varrate4,totalcount4)
{

var varSerialNumber4 = varSerialNumber4;
var varrate4 = varrate4;
var totalcount4 = totalcount4;
//alert(totalcount1);
var grandtotal4=0;
if(document.getElementById("reff4"+varSerialNumber4+"").checked == true)
{
for(i=1;i<=totalcount4;i++)
{
if(document.getElementById("reff4"+i+"").checked == true)
{
//alert('h');
var totalamount4=document.getElementById("rate4"+i+"").value;

if(totalamount4 == "")
{
totalamount4=0;
}

grandtotal4=parseFloat(grandtotal4)+parseFloat(totalamount4);
}
}
document.getElementById("totalamtref").value=grandtotal4.toFixed(2);

var totalamountconsultation=document.getElementById("totalamtconsultation").value;
var totalamountconsultation=totalamountconsultation.replace(/\,/g,'');
if(totalamountconsultation== "")
{
totalamountconsultation=0;
}

var totalamountlab=document.getElementById("totalamtlab").value;
if(totalamountlab == "")
{
totalamountlab=0;
}
//alert(totalamountlab);
var totalamountrad=document.getElementById("totalamtrad").value;
if(totalamountrad == "")
{
totalamountrad=0;
}
//alert(totalamountrad);
var totalamountser=document.getElementById("totalamtser").value;
if(totalamountser == "")
{
totalamountser=0;
}
var totalamountref=document.getElementById("totalamtref").value;
if(totalamountref == "")
{
totalamountref=0;
}
var totalamountamb=document.getElementById("totalamtamb").value;
if(totalamountamb == "")
{
totalamountamb=0;
}
var totalamounthome=document.getElementById("totalamthome").value;
if(totalamounthome == "")
{
totalamounthome=0;
}
//alert(totalamountser);
var grandtotalamount=parseInt(totalamountconsultation)+parseInt(totalamountlab)+parseInt(totalamountrad)+parseInt(totalamountser)+parseInt(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome);
document.getElementById("grandtotalamount").value=grandtotalamount.toFixed(2);

}
else
{
grandtotal4=0;
for(i=1;i<=totalcount4;i++)
{

if(document.getElementById("reff4"+i+"").checked == false)
{
if(document.getElementById("reff4"+i+"").checked == true)
{
var totalamount4=document.getElementById("rate4"+i+"").value;
}
else
{
var totalamount4=0;
}
if(totalamount4 == "")
{
totalamount4=0;
}
//alert(totalamount);
grandtotal4=parseFloat(grandtotal4)+parseFloat(totalamount4);

}
else
{
if(document.getElementById("reff4"+i+"").checked == true)
{
var totalamount4=document.getElementById("rate4"+i+"").value;
}
else
{
var totalamount4=0;
}
if(totalamount4 == "")
{
totalamount4=0;
}
//alert(totalamount);
grandtotal4=parseFloat(grandtotal4)+parseFloat(totalamount4);

}
}
document.getElementById("totalamtref").value=grandtotal4.toFixed(2);
var totalamountconsultation=document.getElementById("totalamtconsultation").value;
var totalamountconsultation=totalamountconsultation.replace(/\,/g,'');
if(totalamountconsultation== "")
{
totalamountconsultation=0;
}

var totalamountlab=document.getElementById("totalamtlab").value;
if(totalamountlab == "")
{
totalamountlab=0;
}
//alert(totalamountlab);
var totalamountrad=document.getElementById("totalamtrad").value;
if(totalamountrad == "")
{
totalamountrad=0;
}
//alert(totalamountrad);
var totalamountser=document.getElementById("totalamtser").value;
if(totalamountser == "")
{
totalamountser=0;
}
var totalamountref=document.getElementById("totalamtref").value;
if(totalamountref == "")
{
totalamountref=0;
}
var totalamountamb=document.getElementById("totalamtamb").value;
if(totalamountamb == "")
{
totalamountamb=0;
}
var totalamounthome=document.getElementById("totalamthome").value;
if(totalamounthome == "")
{
totalamounthome=0;
}
//alert(totalamountser);
var grandtotalamount=parseInt(totalamountconsultation)+parseInt(totalamountlab)+parseInt(totalamountrad)+parseInt(totalamountser)+parseInt(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome);
document.getElementById("grandtotalamount").value=grandtotalamount.toFixed(2);


}
}

function updateboxamb(varSerialNumber2,varrate2,totalcount2)
{
	var grandtotal2 = 0;
	for(var i=1;i<=totalcount2;i++)
	{
		//alert(i);
		if(document.getElementById("reffamb4"+i)!= null)
		{
			if(document.getElementById("reffamb4"+i).checked  == true)
			{
				var refseramt = document.getElementById("ambamt4"+i+"").value;
				//var totalamount2=document.getElementById("rate2"+i+"").value;
				var totalamount2=parseFloat(refseramt);
				
				if(totalamount2 == "")
				{
					totalamount2=0;
				}
				
				grandtotal2=parseFloat(grandtotal2)+parseFloat(totalamount2);
			}
			//alert(grandtotal2);
			document.getElementById("totalamtamb").value=grandtotal2.toFixed(2);
			var totalamountconsultation=document.getElementById("totalamtconsultation").value;
			var totalamountconsultation=totalamountconsultation.replace(/\,/g,'');
			if(totalamountconsultation== "")
			{
			totalamountconsultation=0;
			}
			
			var totalamountlab=document.getElementById("totalamtlab").value;
			if(totalamountlab == "")
			{
			totalamountlab=0;
			}
			//alert(totalamountlab);
			var totalamountrad=document.getElementById("totalamtrad").value;
			if(totalamountrad == "")
			{
			totalamountrad=0;
			}
			//alert(totalamountrad);
			var totalamountser=document.getElementById("totalamtser").value;
			if(totalamountser == "")
			{
			totalamountser=0;
			}
			var totalamountref=document.getElementById("totalamtref").value;
			if(totalamountref == "")
			{
			totalamountref=0;
			}
			var totalamountamb=document.getElementById("totalamtamb").value;
			if(totalamountamb == "")
			{
			totalamountamb=0;
			}
			var totalamounthome=document.getElementById("totalamthome").value;
			if(totalamounthome == "")
			{
			totalamounthome=0;
			}
			//alert(totalamountser);
			var grandtotalamount=parseInt(totalamountconsultation)+parseInt(totalamountlab)+parseInt(totalamountrad)+parseInt(totalamountser)+parseInt(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome);
			document.getElementById("grandtotalamount").value=grandtotalamount.toFixed(2);

		}
	}
	
}

function updateboxhome(varSerialNumber2,varrate2,totalcount2)
{
	var grandtotal2 = 0;
	for(var i=1;i<=totalcount2;i++)
	{
		//alert(i);
		if(document.getElementById("reffhome4"+i)!= null)
		{
			if(document.getElementById("reffhome4"+i).checked  == true)
			{
				var refseramt = document.getElementById("homeamt4"+i+"").value;
				//var totalamount2=document.getElementById("rate2"+i+"").value;
				var totalamount2=parseFloat(refseramt);
				
				if(totalamount2 == "")
				{
					totalamount2=0;
				}
				
				grandtotal2=parseFloat(grandtotal2)+parseFloat(totalamount2);
			}
			//alert(grandtotal2);
			document.getElementById("totalamthome").value=grandtotal2.toFixed(2);
			var totalamountconsultation=document.getElementById("totalamtconsultation").value;
			var totalamountconsultation=totalamountconsultation.replace(/\,/g,'');
			if(totalamountconsultation== "")
			{
			totalamountconsultation=0;
			}
			
			var totalamountlab=document.getElementById("totalamtlab").value;
			if(totalamountlab == "")
			{
			totalamountlab=0;
			}
			//alert(totalamountlab);
			var totalamountrad=document.getElementById("totalamtrad").value;
			if(totalamountrad == "")
			{
			totalamountrad=0;
			}
			//alert(totalamountrad);
			var totalamountser=document.getElementById("totalamtser").value;
			if(totalamountser == "")
			{
			totalamountser=0;
			}
			var totalamountref=document.getElementById("totalamtref").value;
			if(totalamountref == "")
			{
			totalamountref=0;
			}
			var totalamountamb=document.getElementById("totalamtamb").value;
			if(totalamountamb == "")
			{
			totalamountamb=0;
			}
			var totalamounthome=document.getElementById("totalamthome").value;
			if(totalamounthome == "")
			{
			totalamounthome=0;
			}
			//alert(totalamountser);
			var grandtotalamount=parseInt(totalamountconsultation)+parseInt(totalamountlab)+parseInt(totalamountrad)+parseInt(totalamountser)+parseInt(totalamountref)+parseFloat(totalamountamb)+parseFloat(totalamounthome);
			document.getElementById("grandtotalamount").value=grandtotalamount.toFixed(2);

		}
	}
	
}


function validcheck()
{
if(confirm("Are You Sure Want To Save This Entry?")==false) {return false;}	
}

function chkser(id)
{
 var id = id;
 var reqser = document.getElementById("reqserqty"+id).value;
 var refser = document.getElementById("refundserqty"+id).value;
 if(refser == '') { refser = 0; }
 var refrate = document.getElementById("rate2"+id).value;
 if(parseFloat(refser) > parseFloat(reqser))
 {
 	alert("Refund Qty Greater than Balance Qty");
	document.getElementById("refundserqty"+id).value = "0";
	document.getElementById("refseramt"+id).value = "0.00";
	document.getElementById("refundserqty"+id).focus();
	return false;
 }
 var Amt = parseFloat(refser) * parseFloat(refrate);
 document.getElementById("refseramt"+id).value = Amt.toFixed(2);
}

function chkamb(id)
{
 var id = id;
 var reqser = document.getElementById("reqambqty"+id).value;
 var refser = document.getElementById("refambqty"+id).value;
 if(refser == '') { refser = 0; }
 var refrate = document.getElementById("reqambrate"+id).value;
 if(parseFloat(refser) > parseFloat(reqser))
 {
 	alert("Refund Qty Greater than Balance Qty");
	document.getElementById("refambqty"+id).value = "0";
	document.getElementById("ambamt4"+id).value = "0.00";
	document.getElementById("refambqty"+id).focus();
	return false;
 }
 var Amt = parseFloat(refser) * parseFloat(refrate);
 document.getElementById("ambamt4"+id).value = Amt.toFixed(2);
}

function chkhome(id)
{
 var id = id;
 var reqser = document.getElementById("reqhomeqty"+id).value;
 var refser = document.getElementById("refhomeqty"+id).value;
 if(refser == '') { refser = 0; }
 var refrate = document.getElementById("reqhomerate"+id).value;
 if(parseFloat(refser) > parseFloat(reqser))
 {
 	alert("Refund Qty Greater than Balance Qty");
	document.getElementById("refhomeqty"+id).value = "0";
	document.getElementById("homeamt4"+id).value = "0.00";
	document.getElementById("refhomeqty"+id).focus();
	return false;
 }
 var Amt = parseFloat(refser) * parseFloat(refrate);
 document.getElementById("homeamt4"+id).value = Amt.toFixed(2);
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
.style1 {
	font-size: 36px;
	font-weight: bold;
}
.style2 {
	font-size: 18px;
	font-weight: bold;
}
.bal
{
border-style:none;
background:none;
text-align:right;
}
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }

</style>

<script src="js/datetimepicker_css.js"></script>

</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="form1" id="frmsales" method="post" action="paylaterrefund.php" onKeyDown="return disableEnterKey(event)"  onSubmit="return validcheck()">
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#6487DC"><?php eval(base64_decode('IGluY2x1ZGUgKCJpbmNsdWRlcy9hbGVydG1lc3NhZ2VzMS5waHAiKTsg')); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#8CAAE6"><?php eval(base64_decode('IGluY2x1ZGUgKCJpbmNsdWRlcy90aXRsZTEucGhwIik7IA==')); ?></td>

  </tr>
  <tr>
    <td colspan="9" bgcolor="#E0E0E0"><?php eval(base64_decode('IGluY2x1ZGUgKCJpbmNsdWRlcy9tZW51MS5waHAiKTsg')); ?></td>
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
                <td colspan="7" bgcolor="#CCCCCC" class="bodytext32"><strong>Pay Later Patient Details</strong></td>
			 </tr>
		<tr>
                <td colspan="7" class="bodytext32"><strong>&nbsp;</strong></td>
			 </tr>
			  <tr>
			    <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Patient  </strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3"><?php eval(base64_decode('IGVjaG8gJHBhdGllbnRuYW1lOyA=')); ?>
				<input type="hidden" name="patientname" id="customer" value="<?php eval(base64_decode('IGVjaG8gJHBhdGllbnRuYW1lOyA=')); ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/>                  </td>
                     	<input type="hidden" name="labcoa" value="<?php eval(base64_decode('IGVjaG8gJGxhYmNvYTsg')); ?>">
				<input type="hidden" name="radiologycoa" value="<?php eval(base64_decode('IGVjaG8gJHJhZGlvbG9neWNvYTsg')); ?>">
				<input type="hidden" name="servicecoa" value="<?php eval(base64_decode('IGVjaG8gJHNlcnZpY2Vjb2E7IA==')); ?>">
				<input type="hidden" name="pharmacycoa" value="<?php eval(base64_decode('IGVjaG8gJHBoYXJtYWN5Y29hOyA=')); ?>">
				<input type="hidden" name="referalcoa" value="<?php eval(base64_decode('IGVjaG8gJHJlZmVyYWxjb2E7IA==')); ?>">
		
             <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Type</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php eval(base64_decode('IGVjaG8gJHBhdGllbnR0eXBlMTsg')); ?>
				<input type="hidden" name="account" id="account" value="<?php eval(base64_decode('IGVjaG8gJHBhdGllbnR0eXBlMTsg')); ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
		      </tr>
			   <tr>
			    <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Patient code </strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3"><?php eval(base64_decode('IGVjaG8gJHBhdGllbnRjb2RlOyA=')); ?>
				<input type="hidden" name="customercode" id="customercode" value="<?php eval(base64_decode('IGVjaG8gJHBhdGllbnRjb2RlOyA=')); ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				
				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php eval(base64_decode('IC8vZWNobyAkcmVzNDFkZWxpdmVyeWFkZHJlc3M7IA==')); ?></textarea>--></td>
				    <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Sub Type</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php eval(base64_decode('IGVjaG8gJHBhdGllbnRzdWJ0eXBlMTsg')); ?>
				<input type="hidden" name="account" id="account" value="<?php eval(base64_decode('IGVjaG8gJHBhdGllbnRzdWJ0eXBlMTsg')); ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
			  </tr>
				  <tr>
				  <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Visit Code</strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3"><?php eval(base64_decode('IGVjaG8gJHZpc2l0Y29kZTsg')); ?>
				<input type="hidden" name="visitcode" id="visitcode" value="<?php eval(base64_decode('IGVjaG8gJHZpc2l0Y29kZTsg')); ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
                 <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Account</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php eval(base64_decode('IGVjaG8gJHBhdGllbnRhY2NvdW50MTsg')); ?>
				<input type="hidden" name="accountname" id="accountname" value="<?php eval(base64_decode('IGVjaG8gJHBhdGllbnRhY2NvdW50MTsg')); ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<input type="hidden" name="accountcode" id="accountcode" value="<?php echo $patientaccountid1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
				  </tr>
                   <tr>
				  <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Doc No</strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3"><?php eval(base64_decode('IGVjaG8gJGJpbGxudW1iZXJjb2RlOyA=')); ?>
				<input type="hidden" name="billno" id="billno" value="<?php eval(base64_decode('IGVjaG8gJGJpbGxudW1iZXJjb2RlOyA=')); ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
                 <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Plan Name</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php eval(base64_decode('IGVjaG8gJHBhdGllbnRwbGFuMTsg')); ?>
				<input type="hidden" name="account" id="account" value="<?php eval(base64_decode('IGVjaG8gJHBhdGllbnRwbGFuMTsg')); ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
				  </tr>
                   <tr>
				  <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong> Date</strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3"><?php eval(base64_decode('IGVjaG8gJGRhdGVvbmx5OyA=')); ?>
				<input type="hidden" name="billdate" id="billdate" value="<?php eval(base64_decode('IGVjaG8gJGRhdGVvbmx5OyA=')); ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				</td>
                 <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Bill No</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php eval(base64_decode('IGVjaG8gJGZpbmFsaXplZGJpbGxudW1iZXI7IA==')); ?><input type="hidden" name="finalizedbillno" value="<?php eval(base64_decode('IGVjaG8gJGZpbmFsaXplZGJpbGxudW1iZXI7IA==')); ?>">
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
                <td colspan="10" bgcolor="#CCCCCC" class="bodytext32"><strong>Transaction Details</strong></td>
			 </tr>
          
            <tr>
              <td width="5%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				<td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date</strong></div></td>
				<td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bill No</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Description</strong></div></td>
                <td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Qty</strong></div></td>
				<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Refund Qty</strong></div></td>
				<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bal Qty</strong></div></td>
				<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Rate  </strong></div></td>
					<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount </strong></div></td>
				<td width="1%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Refund</strong></div></td>
                  </tr>
				  		<?php 
			$colorloopcount = '';
			$sno = '';
			$totalamount=0;
			$sso3=0;
			$query17 = "select * from master_visitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec17 = mysql_query($query17) or die ("Error in Query1".mysql_error());
			$res17 = mysql_fetch_array($exec17);
			$consultationfee2=$res17['consultationfees'];
			$consultationfee2=number_format($consultationfee2,2);
			$viscode=$res17['visitcode'];
			$consultationdate=$res17['consultationdate'];
			
			$locationcode = $res17['locationcode'];
			
			$query89 = "select * from master_location where locationcode = '$locationcode'";
			$exec89 = mysql_query($query89) or die ("Error in Query89".mysql_error());
			$res89 = mysql_fetch_array($exec89);
			
			$locationname = $res89['locationname'];
			
			?>
			<input type="hidden" name="locationcode" id="locationcode" value="<?php echo $locationcode; ?>">
			<input type="hidden" name="locationname" id="locationname" value="<?php echo $locationname; ?>">
			<?php
			$query181 = "select * from billing_paylaterconsultation where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec181 = mysql_query($query181) or die ("Error in Query181".mysql_error());
			$res181 = mysql_fetch_array($exec181);
			$billingdatetime=$res181['billdate'];
			$billno=$res181['billno'];
		
			$consultationfee = $res181['totalamount'];
			
			$query803 = "select * from refund_paylaterconsultation where patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$exec803 = mysql_query($query803) or die ("Error in Query803".mysql_error());
			$res803rows = mysql_num_rows($exec803);
			if($res803rows == 0)
			{
			
			$consultationfee=number_format($consultationfee,2,'.','');
		
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
			$sso3=$sso3+1;
			 ?>
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate;  ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'OP Consultation';  ?></div>
			 <input type="hidden" name="cons" id="cons" value="<?php echo 'OP Consultation';  ?>"></td>
			     <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" size="2" readonly="readonly" style="background-color:#CCCCCC;" value="<?php echo '1';  ?>"></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="center">1</div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $consultationfee;  ?></div></td>
				<input type="hidden" name="rates" id="rates" value="<?php echo $consultationfee;  ?>">
				 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $consultationfee; ?></div></td>
				 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>  <input type="checkbox" name="ref[]" id="reffcc<?php echo $sso3; ?>" value="<?php echo 'OP Consultation'; ?>" onClick="updateboxcons('<?php  echo $sso3;  ?>','<?php echo $consultationfee; ?>','<?php echo '1'; ?>')"/></strong></div></td>
				</tr>
			<?php
			}
			?>
			  <?php  
			  $totallab=0;
			  $sso=0;
			  $query19 = "select * from billing_paylaterlab where patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemname <> ''";
			$exec19 = mysql_query($query19) or die ("Error in Query1".mysql_error());
			$numb=mysql_num_rows($exec19);
			while($res19 = mysql_fetch_array($exec19))
			{
			$labdate=$res19['billdate'];
			$labname=$res19['labitemname'];
			$labrate=$res19['labitemrate'];
			$labrefno=$res19['billnumber'];
			
			$query80 = "select * from refund_paylaterlab where patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemname = '$labname'";
			$exec80 = mysql_query($query80) or die ("Error in Query80".mysql_error());
			$res80rows = mysql_num_rows($exec80);
			if($res80rows == 0)
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
			$sso=$sso+1;
			 ?>
			 <tr <?php eval(base64_decode('IGVjaG8gJGNvbG9yY29kZTsg')); ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJHNubyA9ICRzbm8gKyAxOyA=')); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJGxhYmRhdGU7IA==')); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJGxhYnJlZm5vOyA=')); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php eval(base64_decode('IGVjaG8gJGxhYm5hbWU7IA==')); ?></div></td>
			 <input type="hidden" name="lab[]" value="<?php eval(base64_decode('IGVjaG8gJGxhYm5hbWU7IA==')); ?>">
			 <input type="hidden" name="labrate[]" value="<?php eval(base64_decode('IGVjaG8gJGxhYnJhdGU7IA==')); ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJzEnOyA=')); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" size="2" readonly style="background-color:#CCCCCC;" value="<?php eval(base64_decode('IGVjaG8gJzEnOyA=')); ?>"></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center">1</div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php eval(base64_decode('IGVjaG8gJGxhYnJhdGU7IA==')); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php eval(base64_decode('IGVjaG8gJGxhYnJhdGU7IA==')); ?></div></td>
			  <input type="hidden" name="rate[]" id="rate<?php eval(base64_decode('IGVjaG8gJHNzbzsg')); ?>" value="<?php eval(base64_decode('IGVjaG8gJGxhYnJhdGU7IA==')); ?>">
			<td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>  <input type="checkbox" name="ref[]" id="reff<?php eval(base64_decode('IGVjaG8gJHNzbzsg')); ?>" value="<?php eval(base64_decode('IGVjaG8gJGxhYm5hbWU7IA==')); ?>" onClick="updatebox('<?php eval(base64_decode('IGVjaG8gJHNzbzsg')); ?>','<?php eval(base64_decode('IGVjaG8gJGxhYnJhdGU7')); ?>','<?php eval(base64_decode('IGVjaG8gJG51bWI7IA==')); ?>')"/></strong></div></td>
             
			  
			  <?php  }
			  }
			   ?>
			   <?php  
		
			$totalpharm = '0';
			 ?>
		
			    <?php  
				$totalrad=0;
				$sso1=0;
			  $query20 = "select * from billing_paylaterradiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemname <> ''";
			$exec20 = mysql_query($query20) or die ("Error in Query1".mysql_error());
			$numb1=mysql_num_rows($exec20);
			while($res20 = mysql_fetch_array($exec20))
			{
			$raddate=$res20['billdate'];
			$radname=$res20['radiologyitemname'];
			$radrate=$res20['radiologyitemrate'];
			$radref=$res20['billnumber'];
			
			$query81 = "select * from refund_paylaterradiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemname = '$radname'";
			$exec81 = mysql_query($query81) or die ("Error in Query80".mysql_error());
			$res81rows = mysql_num_rows($exec81);
			if($res81rows == 0)
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
			$sso1=$sso1+1;
			 ?>
			 <tr <?php eval(base64_decode('IGVjaG8gJGNvbG9yY29kZTsg')); ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJHNubyA9ICRzbm8gKyAxOyA=')); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJHJhZGRhdGU7IA==')); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJHJhZHJlZjsg')); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php eval(base64_decode('IGVjaG8gJHJhZG5hbWU7IA==')); ?></div></td>
			 <input type="hidden" name="rad[]" value="<?php eval(base64_decode('IGVjaG8gJHJhZG5hbWU7IA==')); ?>">
			  <input type="hidden" name="radrate[]" value="<?php eval(base64_decode('IGVjaG8gJHJhZHJhdGU7IA==')); ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJzEnOyA=')); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" size="2" readonly style="background-color:#CCCCCC;" value="<?php eval(base64_decode('IGVjaG8gJzEnOyA=')); ?>"></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="center">1</div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php eval(base64_decode('IGVjaG8gJHJhZHJhdGU7IA==')); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php eval(base64_decode('IGVjaG8gJHJhZHJhdGU7IA==')); ?></div></td>
			 	  <input type="hidden" name="rate[]" id="rate1<?php eval(base64_decode('IGVjaG8gJHNzbzE7IA==')); ?>" value="<?php eval(base64_decode('IGVjaG8gJHJhZHJhdGU7IA==')); ?>">
		
			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>  <input type="checkbox" name="ref[]" id="reff1<?php eval(base64_decode('IGVjaG8gJHNzbzE7IA==')); ?>" value="<?php eval(base64_decode('IGVjaG8gJHJhZG5hbWU7IA==')); ?>" onClick="updatebox1('<?php eval(base64_decode('IGVjaG8gJHNzbzE7IA==')); ?>','<?php eval(base64_decode('IGVjaG8gJHJhZHJhdGU7')); ?>','<?php eval(base64_decode('IGVjaG8gJG51bWIxOyA=')); ?>')"/></strong></div></td>
             
			  
			  <?php  }
			  }
			   ?>
			  	    <?php  
					$sersno=0;
					$totalser=0;
					$sso2=0;
					$totserqtyref = 0;
			  $query21 = "select * from billing_paylaterservices where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> ''";
			$exec21 = mysql_query($query21) or die ("Error in Query1".mysql_error());
			$numb2=mysql_num_rows($exec21);
			while($res21 = mysql_fetch_array($exec21))
			{
			$serdate=$res21['billdate'];
			$sercode = $res21['servicesitemcode'];
			$sername=$res21['servicesitemname'];
			$serrate=$res21['servicesitemrate'];
			$seramount1=$res21['amount'];
			$serref=$res21['billnumber'];
			$serqtyreq = $res21['serviceqty'];
			$serqq1 = $res21['serviceqty'];
			$refundquantity = 0;
			
			$query82 = "select * from refund_paylaterservices where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname = '$sername'";
			$exec82 = mysql_query($query82) or die ("Error in Query82".mysql_error());
			while($res82 = mysql_fetch_array($exec82))
			{
			$res82qty = $res82['servicesitemqty'];
			$refundquantity = $refundquantity + $res82qty;
			}
			$serqty = $serqtyreq - $refundquantity;
			
			
			if($serqty > 0)
			{
			
			$seramount = $serqty * $serrate;
			$seramount = number_format($seramount,2,'.','');
			
			$sersno = $sersno + 1;
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
			$totalser=$totalser+$seramount;
			$sso2=$sso2+1;
			 ?>
			 <tr <?php eval(base64_decode('IGVjaG8gJGNvbG9yY29kZTsg')); ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJHNubyA9ICRzbm8gKyAxOyA=')); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJHNlcmRhdGU7IA==')); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJHNlcnJlZjsg')); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php eval(base64_decode('IGVjaG8gJHNlcm5hbWU7IA==')); ?></div></td>
			 <input type="hidden" name="ser[]" value="<?php eval(base64_decode('IGVjaG8gJHNlcm5hbWU7IA==')); ?>">
			  <input type="hidden" name="servicerate[]" value="<?php eval(base64_decode('IGVjaG8gJHNlcnJhdGU7IA==')); ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo round($serqq1); ?></div>
			 <input type="hidden" name="reqserqty[]" id="reqserqty<?php echo $sersno; ?>" value="<?php echo $serqty; ?>">
			 </td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="refundserqty[]" id="refundserqty<?php echo $sersno; ?>" size="2" value="<?php echo $serqty; ?>" onKeyUp="return chkser(<?php echo $sersno; ?>)"></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serqty; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php eval(base64_decode('IGVjaG8gJHNlcnJhdGU7IA==')); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><input type="text" name="refseramt[]" id="refseramt<?php echo $sersno; ?>" value="<?php echo $seramount; ?>" readonly size="6" style="text-align:right; border:none; background-color:transparent;"></div></td>
				  <input type="hidden" name="rate[]" id="rate2<?php eval(base64_decode('IGVjaG8gJHNzbzI7IA==')); ?>" value="<?php eval(base64_decode('IGVjaG8gJHNlcnJhdGU7IA==')); ?>">
		
			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>  <input type="checkbox" name="ref[]" id="reff2<?php eval(base64_decode('IGVjaG8gJHNzbzI7IA==')); ?>" value="<?php eval(base64_decode('IGVjaG8gJHNlcm5hbWU7IA==')); ?>" onClick="updatebox2('<?php eval(base64_decode('IGVjaG8gJHNzbzI7IA==')); ?>','<?php eval(base64_decode('IGVjaG8gJHNlcnJhdGU7')); ?>','<?php echo $numb2; ?>')"/></strong></div></td>
             
			  
			  <?php  }
			  }
			   ?>
			   <?php  
			   $totalref=0;
			   $sso4=0;
			  $query22 = "select * from billing_paylaterreferal where patientvisitcode='$visitcode' and patientcode='$patientcode' and referalname <> ''";
			$exec22 = mysql_query($query22) or die ("Error in Query1".mysql_error());
			$numbb=mysql_num_rows($exec22);
			while($res22 = mysql_fetch_array($exec22))
			{
			$refdate=$res22['billdate'];
			$refname=$res22['referalname'];
			$refrate=$res22['referalrate'];
			$refref=$res22['billnumber'];
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
			$sso4=$sso4+1;
			 ?>
			 <tr <?php eval(base64_decode('IGVjaG8gJGNvbG9yY29kZTsg')); ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJHNubyA9ICRzbm8gKyAxOyA=')); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJHJlZmRhdGU7IA==')); ?></div></td>
			  <input type="hidden" name="referalname[]" value="<?php eval(base64_decode('IGVjaG8gJHJlZm5hbWU7IA==')); ?>">
			  <input type="hidden" name="referalrate[]" value="<?php eval(base64_decode('IGVjaG8gJHJlZnJhdGU7IA==')); ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJHJlZnJlZjsg')); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php eval(base64_decode('IGVjaG8gJHJlZm5hbWU7IA==')); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php eval(base64_decode('IGVjaG8gJzEnOyA=')); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" size="2" value="1" readonly style="background-color:#CCCCCC;"></div></td>
			 <td class="bodytext31" valign="center" align="left"><div align="center">1</div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php eval(base64_decode('IGVjaG8gJHJlZnJhdGU7IA==')); ?></div></td>
			 <input type="hidden" name="rate[]" id="rate4<?php eval(base64_decode('IGVjaG8gJHNzbzQ7IA==')); ?>" value="<?php eval(base64_decode('IGVjaG8gJHJlZnJhdGU7IA==')); ?>">
		
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php eval(base64_decode('IGVjaG8gJHJlZnJhdGU7IA==')); ?></div></td>
			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>  <input type="checkbox" name="ref[]" id="reff4<?php eval(base64_decode('IGVjaG8gJHNzbzQ7IA==')); ?>" value="<?php eval(base64_decode('IGVjaG8gJHJlZm5hbWU7IA==')); ?>" onClick="updatebox4('<?php eval(base64_decode('IGVjaG8gJHNzbzQ7IA==')); ?>','<?php eval(base64_decode('IGVjaG8gJHJlZnJhdGU7')); ?>','<?php eval(base64_decode('IGVjaG8gJG51bWJiOyA=')); ?>')"/></strong></div></td>
             
			  
			  <?php  }
			   ?>
			    <?php  
			   $totalambulance=0;
			   $amb1=0;
			  $query22a = "select * from billing_opambulancepaylater where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec22a = mysql_query($query22a) or die ("Error in Query22a".mysql_error());
			$numbba=mysql_num_rows($exec22a);
			while($res22a = mysql_fetch_array($exec22a))
			{
			$ambdate=$res22a['recorddate'];
			$ambname=$res22a['description'];
			$ambrate=$res22a['rate'];
			$ambamount=$res22a['amount'];
			$ambunit=$res22a['quantity'];
			$ambunit12=$res22a['quantity'];
			$ambbillno = $res22a['billnumber'];
			$ambdoc = $res22a['docno'];
			
			$refundquantity1 = 0;
			
			$query83 = "select * from refund_paylaterambulance where patientvisitcode='$visitcode' and patientcode='$patientcode' and description = '$ambname'";
			$exec83 = mysql_query($query83) or die ("Error in Query83".mysql_error());
			while($res83 = mysql_fetch_array($exec83))
			{
			$res83qty = $res83['quantity'];
			$refundquantity1 = $refundquantity1 + $res83qty;
			}
			$ambunit = $ambunit - $refundquantity1;
			
			
			if($ambunit > 0)
			{
			$ambamount=$ambunit*$ambrate;
			$ambamount=$ambamount;
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
			$totalambulance=$totalambulance+$ambamount;
			$amb1=$amb1+1;
			 ?>
			 <tr <?php eval(base64_decode('IGVjaG8gJGNvbG9yY29kZTsg')); ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1;  ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $ambdate;  ?></div></td>
			  <input type="hidden" name="ambname[]" value="<?php echo $ambname; ?>">
			  <input type="hidden" name="ambrate[]" value="<?php echo $ambrate; ?>">
			  <input type="hidden" name="ambdoc[]" value="<?php echo $ambdoc; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $ambbillno;  ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php  echo $ambname; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $ambunit12;  ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="refambqty[]" id="refambqty<?php echo $amb1; ?>" size="2" value="<?php echo $ambunit;  ?>" onKeyUp="return chkamb(<?php echo $amb1; ?>)"></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $ambunit;  ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php  echo $ambrate;  ?></div></td>
			 <input type="hidden" name="ambrate4[]" id="ambrate4<?php echo $amb1;  ?>" value="<?php  echo $ambamount;  ?>">
			 <input type="hidden" name="reqambrate[]" id="reqambrate<?php echo $amb1;  ?>" value="<?php  echo $ambrate;  ?>">
			 <input type="hidden" name="reqambqty[]" id="reqambqty<?php echo $amb1;  ?>" value="<?php  echo $ambunit;  ?>">
		
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><input type="text" size="5" name="ambamt4[]" id="ambamt4<?php echo $amb1;  ?>" value="<?php  echo $ambamount;  ?>" readonly style="background-color:transparent; text-align:right; border:none;"></div></td>
			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>  <input type="checkbox" name="ref[]" id="reffamb4<?php echo $amb1;  ?>" value="<?php echo $ambname;  ?>" onClick="updateboxamb('<?php echo $amb1;  ?>','<?php echo $ambrate; ?>','<?php echo $numbba;  ?>')"/></strong></div></td>
             
			  
			  <?php  }
			  }
			   ?>
			    <?php  
			   $totalhome=0;
			   $home1=0;
			  $query22b = "select * from billing_homecarepaylater where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec22b = mysql_query($query22b) or die ("Error in Query22b".mysql_error());
			$numbbb=mysql_num_rows($exec22b);
			while($res22b = mysql_fetch_array($exec22b))
			{
			$homedate=$res22b['recorddate'];
			$homename=$res22b['description'];
			$homerate=$res22b['rate'];
			$homeamount=$res22b['amount'];
			$homeunit=$res22b['quantity'];
			$homeunit12=$res22b['quantity'];
			$homebillno = $res22b['billnumber'];
			$homedoc = $res22b['docno'];
			
			$refundquantity2 = 0;
			
			$query84 = "select * from refund_paylaterhomecare where patientvisitcode='$visitcode' and patientcode='$patientcode' and description = '$homename'";
			$exec84 = mysql_query($query84) or die ("Error in Query84".mysql_error());
			while($res84 = mysql_fetch_array($exec84))
			{
			$res84qty = $res84['quantity'];
			$refundquantity2 = $refundquantity2 + $res84qty;
			}
			$homeunit = $homeunit - $refundquantity2;
			
			
			if($homeunit > 0)
			{
			$homeamount=$homeunit * $homerate;
			$homeamount = $homeamount;
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
			$totalhome=$totalhome+$homeamount;
			$home1=$home1+1;
			 ?>
			 <tr <?php eval(base64_decode('IGVjaG8gJGNvbG9yY29kZTsg')); ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1;  ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $homedate;  ?></div></td>
			  <input type="hidden" name="homename[]" value="<?php echo $homename; ?>">
			  <input type="hidden" name="homerate[]" value="<?php echo $homerate; ?>">
			  <input type="hidden" name="homedoc[]" value="<?php echo $homedoc; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $homebillno;  ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php  echo $homename; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $homeunit12;  ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="refhomeqty[]" id="refhomeqty<?php echo $home1; ?>" size="2" value="<?php echo $homeunit;  ?>" onKeyUp="return chkhome(<?php echo $home1; ?>)"></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $homeunit;  ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php  echo $homerate;  ?></div></td>
			 <input type="hidden" name="homerate4[]" id="homerate4<?php echo $home1;  ?>" value="<?php  echo $homeamount;  ?>">
			 <input type="hidden" name="reqhomerate[]" id="reqhomerate<?php echo $home1;  ?>" value="<?php  echo $homerate;  ?>">
			 <input type="hidden" name="reqhomeqty[]" id="reqhomeqty<?php echo $home1;  ?>" value="<?php  echo $homeunit;  ?>">
		
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><input type="text" size="5" name="homeamt4[]" id="homeamt4<?php echo $home1;  ?>" value="<?php  echo $homeamount;  ?>" readonly style="background-color:transparent; text-align:right; border:none;"></div></td>
			 <td width="4%"  align="left" valign="center" 
               class="bodytext31"><div align="right"><strong>  <input type="checkbox" name="ref[]" id="reffhome4<?php echo $home1;  ?>" value="<?php echo $homename;  ?>" onClick="updateboxhome('<?php echo $home1;  ?>','<?php echo $homerate; ?>','<?php echo $numbbb;  ?>')"/></strong></div></td>
             
			  
			  <?php  }
			  }
			   ?>

			  <?php 
			  
			 $totalop=str_replace(',', '',$totalop);
			   
			   
			    $overalltotal=($totalop+$totallab+$totalpharm+$totalrad+$totalser+$totalref+$totalambulance+$totalhome)-$totalcopay;
			  $overalltotal=number_format($overalltotal,2,'.','');
			  $consultationtotal=$totalop-$totalcopay;
			   $consultationtotal=number_format($consultationtotal,2,'.','');
			   $netpay= $consultationtotal+$totallab+$totalpharm+$totalrad+$totalser+$totalref+$totalambulance+$totalhome;
			   $netpay=number_format($netpay,2,'.','');
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
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong>&nbsp;</strong></td>
             <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong>
				<input type="text" name="totalrefund[]" id="totalrefund" value="<?php //eval(base64_decode('IGVjaG8gJG92ZXJhbGx0b3RhbDsg')); ?>" readonly size="6" style="text-align:right; border:none; background-color:transparent;"></strong></td>
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
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
			
              <td width="37%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left">Total for Consultation</div></td>
				<td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><input type="text" name="totalamtconsultation" id="totalamtconsultation" size="7" class="bal" readonly>
				</div></td>
				 <td width="15%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
			
			</tr>
				<tr>
				  <td width="39%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#CBDBFA"><div align="center"><strong>&nbsp;</strong></div>
				</td>
			
                <td width="37%"  align="left" valign="center" 
                bgcolor="#CBDBFA" class="bodytext31"><div align="left">Total for Laboratory</div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#CBDBFA" class="bodytext31"><div align="right"><input type="text" name="totalamtlab" id="totalamtlab" size="7" class="bal" readonly></div></td>
				 <td width="23%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#CBDBFA"><div align="center"><strong>&nbsp;</strong></div></td>
			
				</tr>
				<tr>
				  <td width="39%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
			
					<td width="37%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left">Total for Radiology </div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><input type="text" name="totalamtrad" id="totalamtrad" size="7" class="bal" readonly></div></td>
				 <td width="23%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
			
				</tr>
				<tr>
				  <td width="39%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#CBDBFA"><div align="center"><strong>&nbsp;</strong></div></td>
			
				<td width="37%"  align="left" valign="center" 
                bgcolor="#CBDBFA" class="bodytext31"><div align="left">Total for Service	</div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#CBDBFA" class="bodytext31"><div align="right"><input type="text" name="totalamtser" id="totalamtser" size="7" class="bal" readonly></div></td>
				 <td width="23%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#CBDBFA"><div align="center"><strong>&nbsp;</strong></div></td>
			
				</tr>
				<tr>
				  <td width="39%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
			
				<td width="37%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left">Total for Referral		</div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><input type="text" name="totalamtref" id="totalamtref" size="7" class="bal" readonly></div></td>
				 <td width="23%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
			
				</tr>
				<tr>
				  <td width="39%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#CBDBFA"><div align="center"><strong>&nbsp;</strong></div></td>
			
				<td width="37%"  align="left" valign="center" 
                bgcolor="#CBDBFA" class="bodytext31"><div align="left">Total for Ambulance		</div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#CBDBFA" class="bodytext31"><div align="right"><input type="text" name="totalamtamb" id="totalamtamb" size="7" class="bal" readonly></div></td>
				 <td width="23%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#CBDBFA"><div align="center"><strong>&nbsp;</strong></div></td>
			
				</tr>
				<tr>
				  <td width="39%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
			
				<td width="37%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left">Total for Homecare		</div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><input type="text" name="totalamthome" id="totalamthome" size="7" class="bal" readonly></div></td>
				 <td width="23%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
			
				</tr>
				<tr>
				  <td width="39%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc"><div align="center"><strong>&nbsp;</strong></div></td>
			
              <td width="37%"  align="left" valign="center" 
                bgcolor="#cccccc" class="bodytext31"><div align="left"><strong>Net Payable	</strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#cccccc" class="bodytext31"><div align="right"><strong><input type="text" name="grandtotalamount" id="grandtotalamount" value="" class="bal" size="7"></strong></div></td>
				
				  <td width="23%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc"><div align="center"><strong>&nbsp;</strong></div></td>
			
            </tr>
				  </tbody>
				  </table>				  </td>
				    <tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext32"><div align="left"><strong>User Name</strong> <span class="bodytext3">
                 <?php eval(base64_decode('IGVjaG8gJF9TRVNTSU9OWyd1c2VybmFtZSddOyA=')); ?>
                </span></div></td>
                <td height="32" colspan="6" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
				    </tr>
				  
      </tr>
      
     
      <tr>
        
		 <td colspan="2" align="right" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
		  <input type="hidden" name="frm1submit1" value="frm1submit1" />
                  <input type="hidden" name="loopcount" value="<?php eval(base64_decode('IGVjaG8gJGkgLSAxOyA=')); ?>" />
               <input name="Submit222" type="submit"  value="Save Bill" class="button" style="border: 1px solid #001E6A"/>		 </td>
      </tr>
      </td>
      </tr>
    </table>

</form>
<?php eval(base64_decode('IGluY2x1ZGUgKCJpbmNsdWRlcy9mb290ZXIxLnBocCIpOyA=')); ?>
<?php eval(base64_decode('IC8vaW5jbHVkZSAoInByaW50X2JpbGxfZG1wNGluY2gxLnBocCIpOyA=')); ?>
</body>
</html>