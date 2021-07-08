<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$updatetime = date('H:i:s');

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

$mortuarydocno = isset($_GET["docno"])?$_GET["docno"]:'';

if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
if (isset($_REQUEST["anum"])) { $anum = $_REQUEST["anum"]; } else { $anum = ""; }
//$frmflag2 = $_POST['frmflag2'];

if ($frmflag2 == 'frmflag2')
{
       
		$paymentmode = $_REQUEST['paymentmode'];
		$chequenumber = $_REQUEST['chequenumber'];
		$chequedate = $_REQUEST['ADate1'];
		$bankname = isset($_REQUEST['bankname'])?$_REQUEST['bankname']:'';
	
		$remarks = $_REQUEST['remarks'];
		$paymentamount = $_REQUEST['paymentamount'];
		$mortuarydocno = $_REQUEST['mortuarydocno'];
		$department = $_REQUEST['departmentanum'];
		$anum = $_REQUEST['anum'];
		
		
		$remarks = $_REQUEST['remarks'];
		$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$paynowbillprefix = 'EXDF-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from master_mortuaryexternaldeposit where transactionmodule = 'PAYMENT' order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);

if ($billnumber == '')
{
	$billnumbercode =$paynowbillprefix.'1';
		$openingbalance = '0.00';

}
else
{
	$billnumber = $res2["docno"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = $paynowbillprefix .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
		$patientname = $_REQUEST['patientname'];
		$patientcode = $_REQUEST['patientcode'];
		$visitcode = $_REQUEST['visitcode'];
		$accname = $_REQUEST['accname'];
		$transactionmodule = 'PAYMENT';
		$depositype= $_REQUEST['deposittype'];
		$cashcoa = $_REQUEST['cashcoa'];
		$chequecoa = $_REQUEST['chequecoa'];
		$cardcoa = $_REQUEST['cardcoa'];
		$mpesacoa = $_REQUEST['mpesacoa'];
		$onlinecoa = $_REQUEST['onlinecoa'];
		$ipdepositscoa = $_REQUEST['ipdepositscoa'];
		if($depositype == 'new1')
		{
			if ($paymentmode == 'CASH')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CASH';
		$particulars = 'BY CASH';
		
		$query55 = "select * from financialaccount where transactionmode = 'CASH'";
		 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
		 $res55 = mysql_fetch_array($exec55);
		 $cashcode = $res55['ledgercode'];
		 
		$query9 = "insert into master_mortuaryexternaldeposit (transactiondate, particulars, 
		transactionmode, transactiontype, transactionamount, cashamount,
		ipaddress, updatedate, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,accountname,docno,username,transactiontime,coa,mortuarydocno,department,cashcode) 
		values ('$updatedatetime', '$particulars', 
		'$transactionmode', '$transactiontype', '$paymentamount', '$paymentamount', 
		 '$ipaddress', '$updatedatetime', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule','$patientname','$patientcode','$visitcode','$accname','$billnumbercode','$username','$updatetime','$ipdepositscoa', '$mortuarydocno','$department','$cashcode')";
		
		$exec9 = mysql_query($query9) or die ("Error in Cash Query9".mysql_error());
		
		$query37 = "insert into paymentmodedebit(billnumber,billdate,ipaddress,username,cash,cashcoa,patientname,patientcode,patientvisitcode,accountname,source,mortuarydocno,department)values('$billnumbercode','$updatedatetime','$ipaddress','$username','$paymentamount','$cashcoa','$patientname','$patientcode','$visitcode','$accname','deposit','$mortuarydocno','$department')";
        $exec37 = mysql_query($query37) or die(mysql_error());

		}
		if ($paymentmode == 'MPESA')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'MPESA';
		$particulars = 'BY MPESA';
		$mpesaamount = $_REQUEST['creditamount'];
		$mpesanumber = $_REQUEST['mpesanumber'];
		
		$query552 = "select * from financialaccount where transactionmode = 'MPESA'";
		 $exec552 = mysql_query($query552) or die ("Error in Query552".mysql_error());
		 $res552 = mysql_fetch_array($exec552);
		 $mpesacode = $res552['ledgercode'];
			
		$query9 = "insert into master_mortuaryexternaldeposit (patientname,patientcode,visitcode,transactiondate, particulars, 
		transactionmode, transactiontype,ipaddress, updatedate, companyanum, companyname, remarks, 
		transactionmodule,accountname,docno,transactionamount,creditamount,mpesanumber,bankname,username,transactiontime,coa,mortuarydocno,department,mpesacode) 
		values ('$patientname','$patientcode','$visitcode','$updatedatetime', '$particulars', 
		'$transactionmode', '$transactiontype','$ipaddress', '$updatedatetime','$companyanum', '$companyname', '$remarks', 		'$transactionmodule','$accname','$billnumbercode','$paymentamount','$paymentamount','$mpesanumber','$bankname','$username','$updatetime','$ipdepositscoa' , '$mortuarydocno','$department','$mpesacode')";
		
		$exec9 = mysql_query($query9) or die ("Error in Mpesa Query9".mysql_error());
		
		$query37 = "insert into paymentmodedebit(billnumber,billdate,ipaddress,username,mpesa,mpesacoa,patientname,patientcode,patientvisitcode,accountname,source,mortuarydocno,department)values('$billnumbercode','$updatedatetime','$ipaddress','$username','$paymentamount','$mpesacoa','$patientname','$patientcode','$visitcode','$accname','deposit', '$mortuarydocno','$department')";
        $exec37 = mysql_query($query37) or die(mysql_error());

		}
			if ($paymentmode == 'ONLINE')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'ONLINE';
		$particulars = 'BY ONLINE ';	
		$onlineamount = $_REQUEST['onlineamount'];
		$onlinenumber = $_REQUEST['onlinenumber'];
		
		$query55 = "select * from financialaccount where transactionmode = 'ONLINE'";
		 $exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
		 $res55 = mysql_fetch_array($exec55);
		 $bankcode = $res55['ledgercode']; 	
		
		$query9 = "insert into master_mortuaryexternaldeposit (patientname,patientcode,visitcode,transactiondate, particulars, 
		transactionmode, transactiontype,ipaddress, updatedate, companyanum, companyname, remarks, 
		transactionmodule,accountname,docno,transactionamount,onlineamount,onlinenumber,bankname,username,transactiontime,coa,mortuarydocno,department,bankcode) 
		values ('$patientname','$patientcode','$visitcode','$updatedatetime', '$particulars', 
		'$transactionmode', '$transactiontype','$ipaddress', '$updatedatetime','$companyanum', '$companyname', '$remarks', 		'$transactionmodule','$accname','$billnumbercode','$paymentamount','$paymentamount','$onlinenumber','$bankname','$username','$updatetime','$ipdepositscoa', '$mortuarydocno','$department','$bankcode')";
		$exec9 = mysql_query($query9) or die ("Error in Online Query9".mysql_error());
		
		$query37 = "insert into paymentmodedebit(billnumber,billdate,ipaddress,username,online,onlinecoa,patientname,patientcode,patientvisitcode,accountname,source,mortuarydocno,department)values('$billnumbercode','$updatedatetime','$ipaddress','$username','$paymentamount','$onlinecoa','$patientname','$patientcode','$visitcode','$accname','deposit', '$mortuarydocno','$department')";
        $exec37 = mysql_query($query37) or die(mysql_error());

		}
		if ($paymentmode == 'CHEQUE')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CHEQUE';
		$particulars = 'BY CHEQUE ';		
		$chequeamount = $_REQUEST['chequeamount'];
		$chequenumber = $_REQUEST['chequenumber'];
		$chequedate = $_REQUEST['chequedate'];
		$chequebank = $_REQUEST['chequebank'];
		
		$query551 = "select * from financialaccount where transactionmode = 'CHEQUE'";
		 $exec551 = mysql_query($query551) or die ("Error in Query551".mysql_error());
		 $res551 = mysql_fetch_array($exec551);
		 $bankcode = $res551['ledgercode'];
	
	    $query9 = "insert into master_mortuaryexternaldeposit (patientname,patientcode,visitcode,transactiondate, particulars, 
		transactionmode, transactiontype,ipaddress, updatedate, companyanum, companyname, remarks, 
		transactionmodule,accountname,docno,transactionamount,chequeamount,chequenumber,chequedate,bankname,username,transactiontime,coa,mortuarydocno,department,bankcode) 
		values ('$patientname','$patientcode','$visitcode','$updatedatetime', '$particulars', 
		'$transactionmode', '$transactiontype','$ipaddress', '$updatedatetime','$companyanum', '$companyname', '$remarks', 		'$transactionmodule','$accname','$billnumbercode','$paymentamount','$paymentamount','$chequenumber','$chequedate','$chequebank','$username','$updatetime','$ipdepositscoa', '$mortuarydocno','$department','$bankcode')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		
		$query37 = "insert into paymentmodedebit(billnumber,billdate,ipaddress,username,cheque,chequecoa,patientname,patientcode,patientvisitcode,accountname,source,mortuarydocno,department)values('$billnumbercode','$updatedatetime','$ipaddress','$username','$paymentamount','$chequecoa','$patientname','$patientcode','$visitcode','$accname','deposit', '$mortuarydocno','$department')";
        $exec37 = mysql_query($query37) or die(mysql_error());

		}
		if ($paymentmode == 'CREDITCARD')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CREDITCARD';
		$particulars = 'BY CREDITCARD ';		
		$cardamount = $_REQUEST['cardamount'];
		$cardnumber = $_REQUEST['cardnumber'];
		$cardname = $_REQUEST['cardname'];
		$bankname1 = $_REQUEST['bankname1'];
		
		$query551 = "select * from financialaccount where transactionmode = 'CREDITCARD'";
		 $exec551 = mysql_query($query551) or die ("Error in Query551".mysql_error());
		 $res551 = mysql_fetch_array($exec551);
		 $bankcode = $res551['ledgercode'];
	
	    $query9 = "insert into master_mortuaryexternaldeposit (patientname,patientcode,visitcode,transactiondate, particulars, 
		transactionmode, transactiontype,ipaddress, updatedate, companyanum, companyname, remarks, 
		transactionmodule,accountname,docno,transactionamount,cardamount,cardnumber, cardname, cardbankname,username,transactiontime,coa,mortuarydocno,department,bankcode) 
		values ('$patientname','$patientcode','$visitcode','$updatedatetime', '$particulars', 
		'$transactionmode', '$transactiontype','$ipaddress', '$updatedatetime','$companyanum', '$companyname', '$remarks', 		'$transactionmodule','$accname','$billnumbercode','$paymentamount','$cardamount','$cardnumber', '$cardname' , '$bankname1','$username','$updatetime','$ipdepositscoa', '$mortuarydocno','$department','$bankcode')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		
		$query37 = "insert into paymentmodedebit(billnumber,billdate,ipaddress,username,card,cardcoa,patientname,patientcode,patientvisitcode,accountname,source,mortuarydocno,department)values('$billnumbercode','$updatedatetime','$ipaddress','$username','$paymentamount','$cardcoa','$patientname','$patientcode','$visitcode','$accname','deposit', '$mortuarydocno','$department')";
        $exec37 = mysql_query($query37) or die(mysql_error());

		}
		if ($paymentmode == 'SPLIT')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'SPLIT';
		$particulars = 'BY SPLIT ';	
		
		$cashamount = $_REQUEST['cashamount'];
		$chequeamount = $_REQUEST['chequeamount'];
		$cardamount = $_REQUEST['cardamount'];
		$mpesaamount = $_REQUEST['creditamount'];
		$onlineamount = $_REQUEST['onlineamount'];
		$mpesanumber = $_REQUEST['mpesanumber'];
		$chequenumber = $_REQUEST['chequenumber'];
		$cardnumber = $_REQUEST['cardnumber'];
		$onlinenumber = $_REQUEST['onlinenumber'];
		$chequedate = $_REQUEST['chequedate'];	
		$chequebank = $_REQUEST['chequebank'];	
		$cardname = $_REQUEST['cardname'];
		$cardbankname = $_REQUEST['bankname1'];
	
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
	
	    $query9 = "insert into master_mortuaryexternaldeposit (patientname,patientcode,visitcode,transactiondate, particulars, 
		transactionmode, transactiontype,ipaddress, updatedate, companyanum, companyname, remarks, 
		transactionmodule,accountname,docno,transactionamount, cashamount, onlineamount, creditamount, chequeamount, cardamount,chequenumber,chequedate,bankname,username,transactiontime,coa, mpesanumber , cardnumber , onlinenumber , cardname, cardbankname,mortuarydocno,department,cashcode,bankcode, mpesacode) 
		values ('$patientname','$patientcode','$visitcode','$updatedatetime', '$particulars', 
		'$transactionmode', '$transactiontype','$ipaddress', '$updatedatetime','$companyanum', '$companyname', '$remarks', 
		'$transactionmodule','$accname','$billnumbercode','$paymentamount','$cashamount','$onlineamount', '$mpesaamount', '$chequeamount' , '$cardamount' , '$chequenumber' ,'$chequedate','$chequebank','$username','$updatetime','$ipdepositscoa' , '$mpesanumber', '$cardnumber' , '$onlinenumber' , '$cardname' , '$cardbankname', '$mortuarydocno','$department','$cashcode','$bankcode','$mpesacode')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		
		$query37 = "insert into paymentmodedebit(billnumber,billdate,ipaddress,username,cash,cashcoa,cheque,chequecoa,card,cardcoa,mpesa,mpesacoa, online,onlinecoa,patientname,patientcode,patientvisitcode,accountname,source,mortuarydocno,department)values('$billnumbercode','$updatedatetime','$ipaddress','$username','$cashamount','$cashcoa','$chequeamount','$chequecoa','$cardamount','$cardcoa','$mpesaamount','$mpesacoa','$onlineamount','$onlinecoa','$patientname','$patientcode','$visitcode','$accname','deposit', '$mortuarydocno','$department')";
        $exec37 = mysql_query($query37) or die(mysql_error());

		}
		}
		else
		{
		 $query9 = "insert into master_mortuaryexternaldeposit (patientname,patientcode,visitcode,transactiondate, particulars, 
		ipaddress, updatedate, companyanum, companyname, remarks, 
		transactionmodule,accountname,docno,transactionamount,username,transactiontime,mortuarydocno,department) 
		values ('$patientname','$patientcode','$visitcode','$updatedatetime', 'By Advance Adjustment', 
		'$ipaddress', '$updatedatetime','$companyanum', '$companyname', '$remarks', 
		'Adjustment','$accname','$docno','$paymentamount','$username','$updatetime', '$mortuarydocno','$department')";
		
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		
		foreach($_POST['advancedocno'] as $key => $value)
		{
		$advancedocno=$_POST['advancedocno'][$key];
		if(isset($_POST['ack']))
		{
		$query31 = "update master_transactionadvancedeposit set recordstatus='adjusted' where patientcode='$patientcode' and docno='$advancedocno'";
		$exec31 = mysql_query($query31) or die(mysql_error());
		}
		}
	
		}
		$query64 = "update mortuary_request set paymentstatus='completed' where docno='$mortuarydocno' and visitcode='$visitcode' and auto_number = '$anum'";
		$exec64 = mysql_query($query64) or die(mysql_error());
		header("location:patientbillingstatus.php?ippatientcode=$patientcode&&ipbillnumber=$billnumbercode");
//header("location:patientbillingstatus.php");

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

//include ("autocompletebuild_customer1.php");
?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$paynowbillprefix = 'EXDF-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from master_mortuaryexternaldeposit where transactionmodule = 'PAYMENT' order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);

if ($billnumber == '')
{
	$billnumbercode =$paynowbillprefix.'1';
		$openingbalance = '0.00';

}
else
{
	$billnumber = $res2["docno"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = $paynowbillprefix .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
$query764 = "select * from master_financialintegration where field='ipdeposits'";
$exec764 = mysql_query($query764) or die(mysql_error());
$res764 = mysql_fetch_array($exec764);

$ipdepositscoa = $res764['code'];
$ipdepositscoaname = $res764['coa'];
$ipdepositstype = $res764['type'];
$ipdepositsselect = $res764['selectstatus'];

$query765 = "select * from master_financialintegration where field='cashipdeposits'";
$exec765 = mysql_query($query765) or die(mysql_error());
$res765= mysql_fetch_array($exec765);

$cashcoa = $res765['code'];


$query766 = "select * from master_financialintegration where field='chequeipdeposits'";
$exec766 = mysql_query($query766) or die(mysql_error());
$res766 = mysql_fetch_array($exec766);

$chequecoa = $res766['code'];


$query767 = "select * from master_financialintegration where field='mpesaipdeposits'";
$exec767 = mysql_query($query767) or die(mysql_error());
$res767 = mysql_fetch_array($exec767);

$mpesacoa = $res767['code'];

$query768 = "select * from master_financialintegration where field='cardipdeposits'";
$exec768 = mysql_query($query768) or die(mysql_error());
$res768 = mysql_fetch_array($exec768);

$cardcoa = $res768['code'];

$query769 = "select * from master_financialintegration where field='onlineipdeposits'";
$exec769 = mysql_query($query769) or die(mysql_error());
$res769 = mysql_fetch_array($exec769);

$onlinecoa = $res769['code'];

?>
<?php
//include ("js/sales1scripting2.php");
if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }

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
function functoprint() 
 {
//alert("hi"):
if(document.getElementById("deposittype").value == 'new1')
{
 var patientcode;
patientcode = document.getElementById("patientcode").value;
billnumbercode = document.getElementById("docno").value;
window.open("print_depositcollection_dmp4inch1.php?patientcode="+patientcode+"&&billnumbercode="+billnumbercode,"OriginalWindowA4",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}
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
		
		functoprint();
		//return true;
	}
	
	}
function FunctionCall()
{
//funcCustomerDropDownSearch1();
funcOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
}
function  funcOnLoad(){
	document.getElementById("cashamounttr").style.display = "none";
	document.getElementById("creditamounttr").style.display = "none";
	document.getElementById("chequeamounttr").style.display = "none";
	document.getElementById("cardamounttr").style.display = "none";
	document.getElementById("onlineamounttr").style.display = "none";
}
function paymentinfotr(e){
	if(document.getElementById("deposittype").value==''){
		alert("Please select Deposit Type")
		document.getElementById("deposittype").focus();
		document.getElementById("paymentmode").getElementsByTagName('option')[0].selected = 'selected';
		return false;
	}
	var cash = document.getElementById("cashamounttr");
	var cashamount = document.getElementById("cashamount")
	var credit = document.getElementById("creditamounttr");
	var creditamount = document.getElementById("creditamount")
	var cheque = document.getElementById("chequeamounttr");
	var chequeamount = document.getElementById("chequeamount")
	var card = document.getElementById("cardamounttr");
	var cardamount = document.getElementById("cardamount")
	var online = document.getElementById("onlineamounttr");
	var onlineamount = document.getElementById("onlineamount")
	var net = document.getElementById("paymentamount");
	var netamount = document.getElementById("paymentamount")
	netamount.value = "0.00";
	if(e=='CASH'){
		cash.style.display = "";
		credit.style.display = "none";
		cheque.style.display = "none";
		card.style.display = "none";
		online.style.display = "none";
		creditamount.value = "0.00";
		chequeamount.value = "0.00";
		cardamount.value = "0.00";
		onlineamount.value = "0.00";
	}
	if(e=='MPESA'){
		cash.style.display = "none";
		credit.style.display = "";
		cheque.style.display = "none";
		card.style.display = "none";
		online.style.display = "none";
		cashamount.value = "0.00";
		chequeamount.value = "0.00";
		cardamount.value = "0.00";
		onlineamount.value = "0.00";
	}
	if(e=='CHEQUE'){
		cash.style.display = "none";
		credit.style.display = "none";
		cheque.style.display = "";
		card.style.display = "none";
		online.style.display = "none";
		creditamount.value = "0.00";
		cashamount.value = "0.00";
		cardamount.value = "0.00";
		onlineamount.value = "0.00";
	}
	if(e=='CREDITCARD'){
		cash.style.display = "none";
		credit.style.display = "none";
		cheque.style.display = "none";
		card.style.display = "";
		online.style.display = "none";
		creditamount.value = "0.00";
		chequeamount.value = "0.00";
		cashamount.value = "0.00";
		onlineamount.value = "0.00";
	}
	if(e=='ONLINE'){
		cash.style.display = "none";
		credit.style.display = "none";
		cheque.style.display = "none";
		card.style.display = "none";
		online.style.display = "";
		creditamount.value = "0.00";
		chequeamount.value = "0.00";
		cardamount.value = "0.00";
		cashamount.value = "0.00";
	}
	if(e=='SPLIT'){
		cash.style.display = "";
		credit.style.display = "";
		cheque.style.display = "";
		card.style.display = "";
		online.style.display = "";
		creditamount.value = "0.00";
		chequeamount.value = "0.00";
		cardamount.value = "0.00";
		onlineamount.value = "0.00";
		cashamount.value = "0.00";
	}
}
function funcbillamountcalc1(){
	var cashamount = parseFloat(document.getElementById("cashamount").value);
	if(isNaN(cashamount)){cashamount = 0.00;}
	//alert(cashamount);
	var creditamount = parseFloat(document.getElementById("creditamount").value);
	if(isNaN(creditamount)){creditamount = 0.00;}
	//alert(creditamount);
	var chequeamount = parseFloat(document.getElementById("chequeamount").value);
	if(isNaN(chequeamount)){chequeamount = 0.00;}
	var cardamount = parseFloat(document.getElementById("cardamount").value);
	if(isNaN(cardamount)){cardamount = 0.00;}
	var onlineamount = parseFloat(document.getElementById("onlineamount").value);
	if(isNaN(onlineamount)){onlineamount = 0.00;}
	//alert(onlineamount);
	var netamount = 0.00;
	netamount = cashamount + creditamount + chequeamount + cardamount + onlineamount;
	document.getElementById("paymentamount").value = netamount.toFixed(2);
}
function balancecalc(){
	
	var cashamount = parseFloat(document.getElementById("cashamount").value);
	var cashreceive = parseFloat(document.getElementById("cashgivenbycustomer").value);
	cashbalance = cashreceive-cashamount;
	if(cashbalance<0){
	cashbalance = 0;
	}
	document.getElementById("cashgiventocustomer").value = cashbalance;
	if(isNaN(document.getElementById("cashgiventocustomer").value)){document.getElementById("cashgiventocustomer").value=0;}
}
function funcdepositchange()
{
if(document.getElementById("deposittype").value == 'adjust')
{
document.getElementById("paymentmode").disabled = true;
document.getElementById("paymentamount").readOnly = true;
}
if(document.getElementById("deposittype").value == 'new1')
{
document.getElementById("paymentmode").disabled = false;
document.getElementById("paymentamount").readOnly = true;
}
funcOnLoad();
}

function funpaymentamount(serialnumber,amount)
{
var serialnumber = serialnumber;
var amount = amount;
if(document.getElementById("deposittype").value == '')
{
alert("Please Select Deposit Type");
document.getElementById("deposittype").focus();
return false;
}
if(document.getElementById("deposittype").value == 'new1')
{
alert("Please Change Deposit Type");
document.getElementById("deposittype").focus();
return false;
}
if(document.getElementById("ack"+serialnumber+"").checked == true)
{
document.getElementById("paymentamount").value = amount;
document.getElementById("paymentamount").readOnly = true;
}
if(document.getElementById("ack"+serialnumber+"").checked == false)
{
document.getElementById("paymentamount").value = '0.00';
document.getElementById("paymentamount").readOnly = false;
}
}
function funcToConfirm(){
	var varUserChoice; 
	varUserChoice = confirm('Are You Sure Want To Save This Entry?'); 
	if (varUserChoice == false)
	{
		alert ("Entry Not Saved.");
		return false;
	}
}
function funcMpesa(){
	var mpesa = document.getElementById("creditamount");
	if(isNaN(parseFloat(mpesa.value))){mpesa.value=0;}
	if(parseFloat(mpesa.value)!=0){
	if(document.getElementById("mpesanumber").value==''||document.getElementById("mpesanumber").value==0){
		alert("Please Enter Mpesa Number");
		document.getElementById("mpesanumber").focus();
		return false;
	}
	}
}
function funcCheque(){
	var cheque = document.getElementById("chequeamount");
	var chequeno = document.getElementById("chequenumber");
	var chequedate = document.getElementById("chequedate");
	var chequebank = document.getElementById("chequebank");
	if(isNaN(parseFloat(cheque.value))){cheque.value=0;}
	if(parseFloat(cheque.value)!=0){
	if(chequeno.value==''|| chequeno.value == 0){
		alert("Please Enter Cheque Number");
		chequeno.focus();
		return false;
	}
	if(chequedate.value==''|| chequedate.value == 0){
		alert("Please Select Cheque Date");
		chequedate.focus();
		return false;
	}
	if(chequebank.value==''|| chequebank.value == 0){
		alert("Please Enter Bank Name");
		chequebank.focus();
		return false;
	}
	}
}
function funcCreditcard(){
	var card = document.getElementById("cardamount");
	var cardno = document.getElementById("cardnumber");
	var cardname = document.getElementById("cardname");
	var cardbank = document.getElementById("bankname");
	if(isNaN(parseFloat(card.value))){card.value=0;}
	if(parseFloat(card.value)!=0){
		
	if(cardno.value==''|| cardno.value == 0){
		alert("Please Enter Card Number");
		cardno.focus();
		return false;
	}
	if(cardname.value==''|| cardname.value == 0){
		alert("Please Enter Card Name");
		cardname.focus();
		return false;
	}
	if(cardbank.value==''||cardbank.value==0){
		alert("Please Enter Bank Name");
		cardbank.focus();
		return false;
	}
	}
}
function funcOnline(){
	if(isNaN(parseFloat(document.getElementById("onlineamount").value))){document.getElementById("onlineamount").value=0;}
	if(parseFloat(document.getElementById("onlineamount").value)!=0){
if(document.getElementById("onlinenumber").value==''||document.getElementById("onlinenumber").value==0){
		alert("Please Enter Online Number");
		document.getElementById("onlinenumber").focus();
		return false;
	}
	}
	
}

function checkvalid()
{
if(document.getElementById("deposittype").value == '')
{
alert("Please Select Deposit Type");
document.getElementById("deposittype").focus();
return false;
}
if(document.getElementById("paymentamount").value == '0.00')
{
alert("Please Enter Deposit Amount");
document.getElementById("paymentamount").focus();
return false;
}
if(document.getElementById("deposittype").value == 'new1')
{

if(document.getElementById("paymentmode").value == '')
{
alert("Please Select Payment Mode");
document.getElementById("paymentmode").focus();
return false;
}
var paymentmode = document.getElementById("paymentmode");

if(paymentmode.value == 'CASH'){
	if(document.getElementById("cashamount").value==''||document.getElementById("cashamount").value==0){
		alert("Please Enter Deposit Cash Amount");
		document.getElementById("cashamount").focus();
		return false;
	}/*
	if(document.getElementById("cashamount").value!=''){
	if(document.getElementById("cashgivenbycustomer").value==''||document.getElementById("cashgivenbycustomer").value==0){
		alert("Please Enter Cash");	
		return false;
	}
	}
	if(parseFloat(document.getElementById("cashamount").value) > parseFloat(document.getElementById("cashgivenbycustomer").value)){
		alert("Received Cash is less than Deposit Amount");
		document.getElementById("cashgivenbycustomer").focus();
		return false;
	}
	*/
}
	

if(paymentmode.value == 'MPESA'){
	var mpesa = document.getElementById("creditamount");
	if(mpesa.value== ''|| mpesa.value== 0){
		alert("Please Enter Cash");
		mpesa.focus();
		return false;
	}
	if(funcMpesa()==false){
		return false;	
	}

}
if(paymentmode.value == 'CHEQUE'){
	var cheque = document.getElementById("chequeamount");
	if(cheque.value==''|| cheque.value== 0){
		alert("Please Enter Chq");
		cheque.focus();
		return false;
	}
	if(funcCheque()==false){
		return false;	
	}
}
if(paymentmode.value == 'CREDITCARD'){
	var card = document.getElementById("cardamount");
	if(card.value==''|| card.value == 0){
		alert("Please Enter Cash");
		card.focus();
		return false;
	}
	if(funcCreditcard()==false){
		return false;	
	}	
}
if(paymentmode.value == 'ONLINE'){
	if(document.getElementById("onlineamount").value==''||document.getElementById("onlineamount").value==0){
		alert("Please Enter Cash");
		document.getElementById("onlineamount").focus();
		return false;
	}
	if(funcOnline()==false){
		return false;	
	}
	
}
if(paymentmode.value == 'SPLIT'){
	if(document.getElementById("cashamount")!=''){/*
	if(document.getElementById("cashamount").value==''||document.getElementById("cashamount").value==0){
		alert("Please Enter Deposit Cash Amount");
		document.getElementById("cashamount").focus();
		return false;
	}
	if(document.getElementById("cashamount").value!=''){
	if(document.getElementById("cashgivenbycustomer").value==''||document.getElementById("cashgivenbycustomer").value==0){
		alert("Please Enter Cash");	
		return false;
	}
	}
	if(parseFloat(document.getElementById("cashamount").value) > parseFloat(document.getElementById("cashgivenbycustomer").value)){
		alert("Received Cash is less than Deposit Amount");
		document.getElementById("cashgivenbycustomer").focus();
		return false;
	}
	
	*/}
	if(funcMpesa()==false){
		return false;	
	}
	if(funcCheque()==false){
		return false;	
	}
	if(funcCreditcard()==false){
		return false;	
	}
	if(funcOnline()==false){
		return false;	
	}
}
}
return funcToConfirm();

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
}
.bali
{
text-align:right;
}
</style>
</head>

<script src="js/datetimepicker_css.js"></script>

<?php include ("js/dropdownlist1advancedeposit.php");?>
<script type="text/javascript" src="js/autosuggestadvancedeposit.js"></script> 
<script type="text/javascript" src="js/autocomplete_customer1.js"></script>

<body onLoad="return FunctionCall();">
<form name="form1" id="form1" method="post" action="externaldepositform.php" onSubmit="return checkvalid();">	
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
   
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      
	 
	
		<tr>
		<td>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
             <tr>
			  <td align="center" valign="center" class="bodytext31"><strong>Doc No</strong></td>
			   <td width="12%"  align="left" valign="center" class="bodytext31"><input type="text" name="docno" id="docno" value="<?php echo $billnumbercode; ?>" size="10"></td>
			 </tr>
            <tr>
              
				 <td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient Name</strong></div></td>
           
				 <td width="12%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Code  </strong></div></td>
				 <td width="12%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>IP Visit  </strong></div></td>
				 <td width="18%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Account</strong></div></td>
				 <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Gender  </strong></div></td>
				 <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Age  </strong></div></td>

				 </tr>
           <?php
            $colorloopcount ='';
		
		$query1 = "select * from mortuary_request where docno='$mortuarydocno'  and paymentstatus='' and auto_number = '$anum'";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		
		while($res1 = mysql_fetch_array($exec1))
		{
		$patientname=$res1['patientname'];
		$patientcode=$res1['patientcode'];
		$accname = $res1['accountname'];
		$gender = $res1['gender'];
		$age = $res1['age'];
		//$mortuarydocno = $res1['docno'];
		
		
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
             
			  <td  align="left" valign="center" class="bodytext31">
			    <div align="center"><?php echo $patientname; ?></div></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $patientcode; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $visitcode; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $accname; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $gender; ?></td>
				<td width="10%"  align="center" valign="center" class="bodytext31"><?php echo $age; ?></td>
				<input type="hidden" name="patientname" id="patientname" value="<?php echo $patientname; ?>">
				 
				<input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>">
				<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>">
				<input type="hidden" name="mortuarydocno" id="mortuarydocno" value="<?php echo $mortuarydocno; ?>">
				<input type="hidden" name="accname" id="accname" value="<?php echo $accname; ?>">
			   </tr>
		   <?php 
		   } 
		  
		   ?>
           
            <tr>
             	<td colspan="5" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#cccccc" class="bodytext311">&nbsp;</td><td colspan="3" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#cccccc" class="bodytext311">&nbsp;</td>
             	</tr>
			<tr>
        <td colspan="7">&nbsp;</td>
      </tr>
			<tr>
			<td colspan="7">
			 <table border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                <tbody>
				
                  <tr bgcolor="#011E6A">
                    <td colspan="6" bgcolor="#CCCCCC" class="bodytext3"><strong>Payment  Entry - Details </strong></td>
					<td align="left" valign="middle" bgcolor="#CCCCCC"  class="bodytext31"> <strong>Deposit Type</strong></td>
                    <td align="left" valign="middle" bgcolor="#CCCCCC"  class="bodytext31"><select name="deposittype" id="deposittype" onChange="return funcdepositchange();">
					<option value="">Select Type</option>
					<option value="new1">New</option>
					<option value="adjust">Adjust</option>
					</select></td>
                  </tr>
                  <tr>
                    <td colspan="8" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#FFFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
                  </tr>
                   <tr>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3" width="5%"> Deposit Amount</td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">
					<input name="paymentamount" id="paymentamount" style="border: 1px solid #001E6A; text-align:right" value="0.00"  size="15" readonly/>
							<input type="hidden" name="cashcoa" value="<?php echo $cashcoa; ?>">
							<input type="hidden" name="ipdepositscoa" value="<?php echo $ipdepositscoa; ?>">
				<input type="hidden" name="chequecoa" value="<?php echo $chequecoa; ?>">
				<input type="hidden" name="mpesacoa" value="<?php echo $mpesacoa; ?>">
				<input type="hidden" name="cardcoa" value="<?php echo $cardcoa; ?>">
				<input type="hidden" name="onlinecoa" value="<?php echo $onlinecoa; ?>"></td>
	
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Payment Mode </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">
					<select name="paymentmode" id="paymentmode" style="width: 130px;" onChange="return paymentinfotr(this.value)">
                                            <option value="" selected="selected">SELECT</option>

<?php
		$query1 = "select billtype from master_billtype where status='' order by auto_number";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		
		while($res1 = mysql_fetch_array($exec1))
		{
		$billtype=$res1['billtype'];

?>                    
                        <option value=<?php echo $billtype;?>><?php echo $billtype;?></option>
<?php }?>                    </select></td>
					<td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                  </tr>
                  <!-----------------Payment Mode-------------------->
                  
              <tr id="cashamounttr" >
                <td  align="" valign="center"  
bgcolor="#FFFFFF" class="bodytext3">Cash </td>
				<td align="left" valign="center"  
bgcolor="#FFFFFF" class="bodytext3"><input name="cashamount" id="cashamount" tabindex="1" value="0.00"  style="border: 1px solid #001E6A; text-align:right" size="15"  onKeyUp="return funcbillamountcalc1()"/></td>
                <td align="left" valign="center"  
bgcolor="#FFFFFF" class="bodytext3"><!--Cash Recd--> &nbsp; </td>
                <td align="left" valign="center"  
bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="cashgivenbycustomer" id="cashgivenbycustomer" onKeyUp="return balancecalc()" tabindex="2"  style="border: 1px solid #001E6A; text-align:right" size="15" autocomplete="off"  /></td>
                <td align="left" valign="center"  
bgcolor="#FFFFFF" class="bodytext3">&nbsp;   </td>
                <td align="left" valign="center"  
bgcolor="#FFFFFF" class="bodytext3"><input name="cashgiventocustomer" type="hidden" id="cashgiventocustomer" onBlur="return funcbillamountcalc1()" value="0.00"  style="border: 1px solid #001E6A; text-align:right" size="15" readonly  /></td>
               
               
                <td colspan="2" align="left" valign="center"  
bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
              </tr>
			
              <tr id="creditamounttr">
               
                <td  align="left" valign="center"  
bgcolor="#FFFFFF" class="bodytext3"> MPESA </td>
                <td align="left" valign="center"  
bgcolor="#FFFFFF" class="bodytext3"><input name="creditamount" id="creditamount" onKeyUp="return funcbillamountcalc1()" value="0.00"  style="border: 1px solid #001E6A;  text-align:right" size="15" /></td>
                <td align="left" valign="center"  
bgcolor="#FFFFFF" class="bodytext3"> MPESA No.</td>
                <td align="left" valign="center"  
bgcolor="#FFFFFF" class="bodytext3"><input name="mpesanumber" id="mpesanumber" value=""  style="border: 1px solid #001E6A;  text-transform:uppercase" size="15"  /></td>
 <td  colspan="2"  align="left" valign="center"
bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
 <td  colspan="2"  align="left" valign="center"
bgcolor="#FFFFFF" class="bodytext3" >&nbsp;</td>
                
              </tr>
              <tr id="chequeamounttr">
                <td align="left" valign="center"  
bgcolor="#FFFFFF" class="bodytext3">Cheque  </td>
                <td align="left" valign="center"  
bgcolor="#FFFFFF" class="bodytext3"><input name="chequeamount" id="chequeamount" onKeyUp="return funcbillamountcalc1()" value="0.00"  style="border: 1px solid #001E6A;  text-align:right" size="15" /></td>
                <td align="left" valign="center"  
bgcolor="#FFFFFF" class="bodytext3"> Chq No. </td>
                <td align="left" valign="center"   
bgcolor="#FFFFFF" class="bodytext3"><input name="chequenumber" id="chequenumber" value=""  style="border: 1px solid #001E6A; text-transform:uppercase" size="15"  /></td>
                <td align="left" valign="center"  
bgcolor="#FFFFFF" class="bodytext3" > Date </td>
                <td align="left" valign="center"  
bgcolor="#FFFFFF" class="bodytext3">  <input name="chequedate" id="chequedate" value="" style="border: 1px solid #001E6A; text-transform:uppercase" size="15" readonly />
	<img src="images2/cal.gif" onClick="javascript:NewCssCal('chequedate')" style="cursor:pointer;"></td>
                <td align="left" valign="center"  
bgcolor="#FFFFFF" class="bodytext3"> Bank  </td>
                <td align="left" valign="center"  
bgcolor="#FFFFFF" class="bodytext3"> <input name="chequebank" id="chequebank" value="" style="border: 1px solid #001E6A; text-transform:uppercase" size="15"  /></td>
              </tr>
			  
              <tr id="cardamounttr">
                <td  align="left" valign="center"  
bgcolor="#FFFFFF" class="bodytext3">Card  </td>
                <td align="left" valign="center"  
bgcolor="#FFFFFF" class="bodytext3"><input name="cardamount" id="cardamount" onKeyUp="return funcbillamountcalc1()" value="0.00" style="border: 1px solid #001E6A;text-align:right" size="15" /></td>
                <td align="left" valign="center"  
bgcolor="#FFFFFF" class="bodytext3"> Card No </td>
                <td align="left" valign="center"  
bgcolor="#FFFFFF" class="bodytext3"><input name="cardnumber" id="cardnumber" value="" style="border: 1px solid #001E6A; text-transform:uppercase" size="15"  /></td>
                <td align="left" valign="center"  
bgcolor="#FFFFFF" class="bodytext3">Name </td>
                <td align="left" valign="center"  
bgcolor="#FFFFFF" class="bodytext3"><input type="text" name="cardname" id="cardname" size="15" style="border: 1px solid #001E6A" onChange="return paymentinfo()">
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
                <td align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31" > Bank  </td>
                <td align="left"  bgcolor="#FFFFFF" valign="center" class="bodytext31"><input name="bankname1" id="bankname" value="" style=" text-align:left; text-transform:uppercase; border: 1px solid #001E6A"  size="15"  /></td>
              </tr>
              <tr id="onlineamounttr">
			    <td align="left" valign="center" 
                bgcolor="#FFFFFF" class="bodytext3">Online </div></td>
                <td align="left" valign="center"  
                bgcolor="#FFFFFF" class="bodytext3"><input name="onlineamount" id="onlineamount" onKeyUp="return funcbillamountcalc1()" value="0.00" style=" text-align:right" size="15"  /></td>
                 <td align="left" valign="center"  
                bgcolor="#FFFFFF" class="bodytext3">Online No </td>
                <td align="left" valign="center"   bgcolor="#FFFFFF"
                 class="bodytext31"><input name="onlinenumber" id="onlinenumber" style="border: 1px solid #001E6A" value="" size="15"  /></td>
                <td colspan="4 " bgcolor="#FFFFFF" align="left" valign="center"  
                 class="bodytext3">&nbsp;</td>
              </tr>
                  <!------------------Payment Mode Ends------------------->
                  <!--<tr>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"> Number </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">
					<input name="chequenumber" id="chequenumber" style="border: 1px solid #001E6A" value=""  size="20" /></td>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Bank Name </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="bankname" id="bankname" style="border: 1px solid #001E6A" value=""  size="20" /></td>
                    <td colspan="4 " bgcolor="#FFFFFF" align="left" valign="center"  
                 class="bodytext31" width="8%">&nbsp;</td>
                  </tr>-->
                  <tr>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">  Date </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo date('Y-m-d'); ?>"  size="15"  readonly="readonly" onKeyDown="return disableEnterKey()"/>
					<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>				    </td>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Remarks</td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="remarks" id="remarks" style="border: 1px solid #001E6A" value=""  size="15" />
					 <input type="hidden" name="docno" value="<?php echo $billnumbercode; ?>"></td>
                     <td colspan="4 " bgcolor="#FFFFFF" align="left" valign="center"  
                 class="bodytext31">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">&nbsp;</td>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                      <input type="hidden" name="cbfrmflag2" value="<?php echo $supplieranum; ?>">
                      <input type="hidden" name="frmflag2" value="frmflag2">
<input type="hidden" name="anum" value="<?= $anum; ?>">
                      <input name="Submit" type="submit"  value="Save Payment" class="button" style="border: 1px solid #001E6A"/>
                    </font></td>
                    <td colspan="4 " bgcolor="#FFFFFF" align="left" valign="center"  
                 class="bodytext31">&nbsp;</td>
                  </tr>
                </tbody>
              </table>			  </td>
			 </tr>
          </tbody>
        </table>

		</td>
		</tr>
		
		</table>
		
		</td>
		</tr>
	
      
      <tr>
	    <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
            <tr>
			<td colspan="10" bgcolor="#cccccc" class="bodytext311"><strong>Advance Deposits</strong></td>
			</tr>
			 <tr>
               <td width="5%"align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> No </strong></div></td>
		
				 <td width="22%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient Name</strong></div></td>
           
				 <td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Code  </strong></div></td>
				 <td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date of Collection  </strong></div></td>
				 <td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Doc No</strong></div></td>
				 <td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount  </strong></div></td>
				 <td width="11%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Select </strong></div></td>
		
              </tr>
			  <?php
			   $colorloopcount ='';
			   $sno = '';
			   
			  $query43 = "select * from master_transactionadvancedeposit where patientcode='$patientcode' and recordstatus='' group by docno";
			  $exec43 = mysql_query($query43) or die(mysql_error());
			  $num43 = mysql_num_rows($exec43);
			  while($res43 = mysql_fetch_array($exec43))
			  {
			  
			  $patientname1 = $res43['patientname']; 
			  $patientcode1 = $res43['patientcode'];
			  $dateofcollection = $res43['transactiondate'];
			  $docnum = $res43['docno'];
			  $transactionamount = $res43['transactionamount'];
			  
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
				 <td  align="center" valign="center" class="bodytext31"><?php echo $sno = $sno +1; ?></td>
				 <td  align="left" valign="center" class="bodytext31">
			    <div align="center"><?php echo $patientname1; ?></div></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $patientcode1; ?></td>
				
				<td  align="center" valign="center" class="bodytext31"><?php echo $dateofcollection; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $docnum; ?></td>
				<input type="hidden" name="advancedocno[]" id="advancedocno" value="<?php echo $docnum; ?>">
				<td  align="center" valign="center" class="bodytext31"><?php echo $transactionamount; ?></td>
			<td  align="center" valign="center" class="bodytext31"><input type="checkbox" name="ack[]" id="ack<?php echo $sno; ?>" onClick="return funpaymentamount('<?php echo $sno; ?>','<?php echo $transactionamount; ?>')"></td>
				</tr>
				<?php 
				}
				?>
			</tbody>
			</table>
		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
	  
	 
    </table>
  </table>
   </form>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

