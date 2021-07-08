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
$suppliername="";
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$insert_id = '';
$docno = $_SESSION['docno'];
$arraysuppliercode = '';

$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
$res1 = mysql_fetch_array($exec1);

$locationname = $res1["locationname"];
$locationcode = $res1["locationcode"];

//This include updatation takes too long to load for hunge items database.
include ("autocompletebuild_accounts_ar.php");

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select * from master_supplier where auto_number = '$getcanum'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	$res4 = mysql_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	$searchsuppliername = $_POST['searchsuppliername'];
	if ($searchsuppliername != '')
	{
		$arraysupplier = explode("#", $searchsuppliername);
		$arraysuppliername = $arraysupplier[0];
		$arraysuppliername = trim($arraysuppliername);
		$arraysuppliercode = $arraysupplier[1];
		
		$query1 = "select auto_number from master_accountname where id = '$arraysuppliercode'";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$res1 = mysql_fetch_array($exec1);
		$supplieranum = $res1['auto_number'];
		
		$suppliername = $arraysuppliername;
	}
	else
	{
		$cbsuppliername = $_REQUEST['cbsuppliername'];
		$suppliername = $_REQUEST['cbsuppliername'];
	}

	//$transactiondatefrom = $_REQUEST['ADate1'];
	//$transactiondateto = $_REQUEST['ADate2'];

}

if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

if ($frmflag2 == 'frmflag2')
{
	
	
		//For generating first code
		//include ("transactioncodegenerate1pharmacy.php");

		$query2 = "select * from settings_approval where modulename = 'collection' and status <> 'deleted'";
		$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		$res2 = mysql_fetch_array($exec2);
		$approvalrequired = $res2['approvalrequired'];
		if ($approvalrequired == 'YES')	{
			$approvalstatus = 'PENDING';
		}
		else {
			$approvalstatus = 'APPROVED';
		}
	
		$query8 = "select * from master_supplier where auto_number = '$cbfrmflag2'";
		$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
		$res8 = mysql_fetch_array($exec8);
		$res8suppliername = $res8['suppliername'];
		
		//echo "inside if";
		$paymententrydate = $_REQUEST['paymententrydate'];
		$paymentmode = $_REQUEST['paymentmode'];
		$chequenumber = $_REQUEST['chequenumber'];
		$chequedate = $_REQUEST['ADate1'];
		$bankname1 = $_REQUEST['bankname'];
		if($bankname1 != '')
		{
		$banknamesplit = explode('|',$bankname1);
		$bankcode = $banknamesplit[0];
		$bankname = $banknamesplit[1];
		}
		else
		{
		$bankcode = '';
		$bankname = '';
		}
		$bankbranch = $_REQUEST['bankbranch'];
		$remarks = $_REQUEST['remarks'];
		$paymentamount = $_REQUEST['paymentamount'];
		$pendingamount = $_REQUEST['pendingamount'];
		$remarks = $_REQUEST['remarks'];
		$docno = $_REQUEST['docno'];
		$transactionamount = $paymentamount;
		$accname = $_REQUEST['accname'];
		$accountnameano = $_REQUEST['accnameano'];
		$accountnameid = $_REQUEST['accnameid'];	
		$cashcoa = $_REQUEST['cashcoa'];
		$chequecoa = $_REQUEST['chequecoa'];
		$cardcoa = $_REQUEST['cardcoa'];
		$mpesacoa = $_REQUEST['mpesacoa'];
		$onlinecoa = $_REQUEST['onlinecoa'];
		$paymentamount=str_replace(',', '', $paymentamount);
		$pendingamount=str_replace(',', '', $pendingamount);	
		$balanceamount = $pendingamount - $paymentamount;
		$transactiondate = $paymententrydate;
		$balanceamount=str_replace(',', '', $balanceamount);
		$transactionmode = $paymentmode;
		if ($transactionmode == 'TDS')
		{
			$transactiontype = 'TDS';
		}
		else
		{
			$transactiontype = 'PAYMENT';
		}
		
		$ipaddress = $ipaddress;
		$updatedate = $updatedatetime;
		
		$paynowbillprefix = 'AR-';
		$paynowbillprefix1=strlen($paynowbillprefix);
		
		$query2 = "select paylaterdocno from master_transactionpaylater where transactiontype='PAYMENT' and paylaterdocno <>'' order by auto_number desc 							limit 0, 1";
		$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		$res2 = mysql_fetch_array($exec2);
		$billnumber = $res2["paylaterdocno"];
		$billdigit=strlen($billnumber);
		if ($billnumber == '')
		{
			$billnumbercode ='AR-'.'1';
			$openingbalance = '0.00';
		}
		else
		{
			$billnumber = $res2["paylaterdocno"];
			$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
			//echo $billnumbercode;
			$billnumbercode = intval($billnumbercode);
			$billnumbercode = $billnumbercode + 1;
		
			$maxanum = $billnumbercode;
			
			
			$billnumbercode = 'AR-' .$maxanum;
			$openingbalance = '0.00';
			//echo $companycode;
		}
		$docno = $billnumbercode;
		
		$acccode = $accountnameid;
		
		$transactionmodule = 'PAYMENT';
		if(isset($_POST['onaccount']))
		{
		
		$query55 = "select * from master_accountname where accountname='$accname'";
		$exec55 = mysql_query($query55) or die(mysql_error());
		$res55 = mysql_fetch_array($exec55);
		$paytype = $res55['paymenttype'];
		$subpaytype = $res55['subtype'];
		
		$querytype1=mysql_query("select * from master_paymenttype where auto_number='$paytype'");
		$exectype1=mysql_fetch_array($querytype1);
		$patienttype11=$exectype1['paymenttype'];
		
		$querysubtype1=mysql_query("select * from master_subtype where auto_number='$subpaytype'");
		$execsubtype1=mysql_fetch_array($querysubtype1);
		$patientsubtype11=$execsubtype1['subtype'];
			
		$query2dup = "select paylaterdocno from master_transactionpaylater where paylaterdocno='$docno'";
		$exec2dup = mysql_query($query2dup) or die ("Error in query2dup".mysql_error());
		$num2dup = mysql_num_rows($exec2dup);
		if($num2dup=='0')
		{
		
	if ($paymentmode == 'CASH')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CASH';
		$particulars = 'BY CASH '.$billnumberprefix.$billnumber.'';	
		
		$query551 = "select * from financialaccount where transactionmode = 'CASH'";
	 	$exec551 = mysql_query($query551) or die ("Error in Query551".mysql_error());
		 $res551 = mysql_fetch_array($exec551);
	 	$cashcode = $res551['ledgercode'];;
		
		$query9 = "insert into master_transactionpaylater (transactiondate, particulars, 
		transactionmode, transactiontype,ipaddress, updatedate, companyanum, companyname, remarks, 
		transactionmodule,accountname,docno,recordstatus,receivableamount,paylaterdocno,transactionamount,cashamount,transactionstatus,paymenttype,subtype,username,accountnameano,accountnameid,acc_flag,bankcode,bankname) 
		values ('$transactiondate', '$particulars', 
		'$transactionmode', '$transactiontype','$ipaddress', '$updatedate','$companyanum', '$companyname', '$remarks', 
		'$transactionmodule','$accname','$docno','','$paymentamount','$docno','$paymentamount','$paymentamount','onaccount','$patienttype11','$patientsubtype11','$username','$accountnameano','$accountnameid','2','$cashcode','$bankname')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		$insert_id = mysql_insert_id();
		
		
		$queryon = "insert into master_transactiononaccount (`transactiondate`, `docno`, `particulars`, `paymenttype`, `subtype`, `accountcode`, `accountname`, `transactionmode`, `transactiontype`, `transactionmodule`, `transactionstatus`, 
		`transactionamount`, `adjamount`, `balanceamount`, `ipaddress`, `updatedate`, `recordstatus`, `companyanum`, `companyname`,`locationcode`,`locationname`,`cashamount`, `cashcode`)
		values('$transactiondate','$docno','onaccount','$patienttype11','$patientsubtype11','$acccode','$accname','$transactionmode','$transactiontype','$transactionmodule','onaccount',
		'$paymentamount','$paymentamount','0.00','$ipaddress','$transactiondate','','$companyanum', '$companyname','$locationcode','$locationname','$paymentamount','$cashcode')";
		$execon = mysql_query($queryon) or die ("Error in Queryon".mysql_error());
		
		$query37 = "insert into paymentmodedebit(accountname,billnumber,billdate,ipaddress,username,cash,cashcoa,source)values('$accname','$docno','$transactiondate','$ipaddress','$username','$paymentamount','$cashcoa','accountreceivable')";
        $exec37 = mysql_query($query37) or die(mysql_error());
	
		}
		if ($paymentmode == 'ONLINE')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'ONLINE';
		$particulars = 'BY ONLINE '.$billnumberprefix.$billnumber.'';	
		
		$query551 = "select * from financialaccount where transactionmode = 'ONLINE'";
	 	$exec551 = mysql_query($query551) or die ("Error in Query551".mysql_error());
		 $res551 = mysql_fetch_array($exec551);
	 	$bankcode = $res551['ledgercode'];;
		
		$query9 = "insert into master_transactionpaylater (transactiondate, particulars, 
		transactionmode, transactiontype,ipaddress, updatedate, companyanum, companyname, remarks, 
		transactionmodule,accountname,docno,recordstatus,receivableamount,paylaterdocno,transactionamount,onlineamount,transactionstatus,chequenumber,paymenttype,subtype,username,accountnameano,accountnameid,acc_flag,bankcode,bankname) 
		values ('$transactiondate', '$particulars', 
		'$transactionmode', '$transactiontype','$ipaddress', '$updatedate','$companyanum', '$companyname', '$remarks', 
		'$transactionmodule','$accname','$docno','','$paymentamount','$docno','$paymentamount','$paymentamount','onaccount','$chequenumber','$patienttype11','$patientsubtype11','$username','$accountnameano','$accountnameid','2','$bankcode','$bankname')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		$insert_id = mysql_insert_id();
		
		$queryon = "insert into master_transactiononaccount (`transactiondate`, `docno`, `particulars`, `paymenttype`, `subtype`, `accountcode`, `accountname`, `transactionmode`, `transactiontype`, `transactionmodule`, `transactionstatus`, 
		`transactionamount`, `adjamount`, `balanceamount`, `ipaddress`, `updatedate`, `recordstatus`, `companyanum`, `companyname`,`locationcode`,`locationname`,`onlineamount`, `bankcode`)
		values('$transactiondate','$docno','onaccount','$patienttype11','$patientsubtype11','$acccode','$accname','$transactionmode','$transactiontype','$transactionmodule','onaccount',
		'$paymentamount','$paymentamount','0.00','$ipaddress','$transactiondate','','$companyanum', '$companyname','$locationcode','$locationname','$paymentamount','$bankcode')";
		$execon = mysql_query($queryon) or die ("Error in Queryon".mysql_error());
		
		
		$query37 = "insert into paymentmodedebit(accountname,billnumber,billdate,ipaddress,username,online,onlinecoa,source)values('$accname','$docno','$transactiondate','$ipaddress','$username','$paymentamount','$onlinecoa','accountreceivable')";
        $exec37 = mysql_query($query37) or die(mysql_error());
	
		}
		if ($paymentmode == 'MPESA')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'MPESA';
		$particulars = 'BY MPESA '.$billnumberprefix.$billnumber.'';	
		
		$query551 = "select * from financialaccount where transactionmode = 'MPESA'";
	 	$exec551 = mysql_query($query551) or die ("Error in Query551".mysql_error());
		 $res551 = mysql_fetch_array($exec551);
	 	$bankcode = $res551['ledgercode'];;
		
		$query9 = "insert into master_transactionpaylater (transactiondate, particulars, 
		transactionmode, transactiontype,ipaddress, updatedate, companyanum, companyname, remarks, 
		transactionmodule,accountname,docno,recordstatus,receivableamount,paylaterdocno,transactionamount,mpesaamount,transactionstatus,chequenumber,paymenttype,subtype,username,accountnameano,accountnameid,acc_flag,bankcode,bankname) 
		values ('$transactiondate', '$particulars', 
		'$transactionmode', '$transactiontype','$ipaddress', '$updatedate','$companyanum', '$companyname', '$remarks', 
		'$transactionmodule','$accname','$docno','','$paymentamount','$docno','$paymentamount','$paymentamount','onaccount','$chequenumber','$patienttype11','$patientsubtype11','$username','$accountnameano','$accountnameid','2','$bankcode','$bankname')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		$insert_id = mysql_insert_id();
		
		$queryon = "insert into master_transactiononaccount (`transactiondate`, `docno`, `particulars`, `paymenttype`, `subtype`, `accountcode`, `accountname`, `transactionmode`, `transactiontype`, `transactionmodule`, `transactionstatus`, 
		`transactionamount`, `adjamount`, `balanceamount`, `ipaddress`, `updatedate`, `recordstatus`, `companyanum`, `companyname`,`locationcode`,`locationname`,`onlineamount`, `bankcode`)
		values('$transactiondate','$docno','onaccount','$patienttype11','$patientsubtype11','$acccode','$accname','$transactionmode','$transactiontype','$transactionmodule','onaccount',
		'$paymentamount','$paymentamount','0.00','$ipaddress','$transactiondate','','$companyanum', '$companyname','$locationcode','$locationname','$paymentamount','$bankcode')";
		$execon = mysql_query($queryon) or die ("Error in Queryon".mysql_error());
		
		
		$query37 = "insert into paymentmodedebit(accountname,billnumber,billdate,ipaddress,username,mpesa,onlinecoa,source)values('$accname','$docno','$transactiondate','$ipaddress','$username','$paymentamount','$onlinecoa','accountreceivable')";
        $exec37 = mysql_query($query37) or die(mysql_error());
	
		}
		if ($paymentmode == 'CHEQUE')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CHEQUE';
		$particulars = 'BY CHEQUE '.$billnumberprefix.$billnumber;		

	
	    $query9 = "insert into master_transactionpaylater (transactiondate, particulars, 
		transactionmode, transactiontype,ipaddress, updatedate, companyanum, companyname, remarks, 
		transactionmodule,accountname,docno,recordstatus,receivableamount,paylaterdocno,transactionamount,chequeamount,chequenumber,chequedate,bankname,transactionstatus,paymenttype,subtype,username,accountnameano,accountnameid,acc_flag,bankcode) 
		values ('$transactiondate', '$particulars', 
		'$transactionmode', '$transactiontype','$ipaddress', '$updatedate','$companyanum', '$companyname', '$remarks', 
		'$transactionmodule','$accname','$docno','','$paymentamount','$docno','$paymentamount','$paymentamount','$chequenumber','$chequedate','$bankname','onaccount','$patienttype11','$patientsubtype11','$username','$accountnameano','$accountnameid','2','$bankcode')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		$insert_id = mysql_insert_id();
		
		$queryon = "insert into master_transactiononaccount (`transactiondate`, `docno`, `particulars`, `paymenttype`, `subtype`, `accountcode`, `accountname`, `transactionmode`, `transactiontype`, `transactionmodule`, `transactionstatus`, 
		`transactionamount`, `adjamount`, `balanceamount`, `ipaddress`, `updatedate`, `recordstatus`, `companyanum`, `companyname`,`locationcode`,`locationname`,`chequeamount`, `bankcode`)
		values('$transactiondate','$docno','onaccount','$patienttype11','$patientsubtype11','$acccode','$accname','$transactionmode','$transactiontype','$transactionmodule','onaccount',
		'$paymentamount','$paymentamount','0.00','$ipaddress','$transactiondate','','$companyanum', '$companyname','$locationcode','$locationname','$paymentamount','$bankcode')";
		$execon = mysql_query($queryon) or die ("Error in Queryon".mysql_error());
		
		$query37 = "insert into paymentmodedebit(accountname,billnumber,billdate,ipaddress,username,cheque,chequecoa,source)values('$accname','$docno','$transactiondate','$ipaddress','$username','$paymentamount','$chequecoa','accountreceivable')";
        $exec37 = mysql_query($query37) or die(mysql_error());
	
		}
		if ($paymentmode == 'WRITEOFF')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'WRITEOFF';
		$particulars = 'BY WRITEOFF '.$billnumberprefix.$billnumber;		
		
		$query9 = "insert into master_transactionpaylater (transactiondate, particulars, 
		transactionmode, transactiontype,ipaddress, updatedate, companyanum, companyname, remarks, 
		transactionmodule,accountname,docno,recordstatus,receivableamount,paylaterdocno,transactionamount,writeoffamount,transactionstatus,paymenttype,subtype,username,accountnameano,accountnameid,acc_flag,bankcode) 
		values ('$transactiondate', '$particulars', 
		'$transactionmode', '$transactiontype','$ipaddress', '$updatedate','$companyanum', '$companyname', '$remarks', 
		'$transactionmodule','$accname','$docno','','$paymentamount','$docno','$paymentamount','$paymentamount','onaccount','$patienttype11','$patientsubtype11','$username','$accountnameano','$accountnameid','2','$bankcode')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		$insert_id = mysql_insert_id();
		
		}
		}
		
		}
		
		header ("location:paylaterpaymententry.php?st=1&&insert_id=$insert_id");
		exit;
		
		//$errmsg = "Success. Payment Entry Updated.";

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
<script>
<?php
if (isset($_REQUEST["insert_id"])) { $insert_id = $_REQUEST["insert_id"]; } else { $insert_id = ""; }
if($insert_id != '' && $st == '1')
{
?>
var insert_id = "<?php echo $insert_id; ?>";
	//alert(refundbillnumber);
	if(insert_id != "") 
	{
		window.open("receipt_receivable_print.php?receiptanum="+insert_id+"","OriginalWindowA25",'width=600,height=800,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
	}	
<?php
}
?>
</script>
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
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">

function cbsuppliername1()
{
	document.cbform1.submit();
}

</script>
<script type="text/javascript" src="js/autocomplete_accounts.js"></script>
<script type="text/javascript" src="js/autosuggest2accounts.js"></script>
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
}


function disableEnterKey(varPassed)
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
	
	var key;
	if(window.event)
	{
		key = window.event.keyCode;     //IE
	}
	else
	{
		key = e.which;     //firefox
	}

	if(key == 13) // if enter key press
	{
		//alert ("Enter Key Press2");
		return false;
	}
	else
	{
		return true;
	}
}


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

function disableEnterKey()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
	
	var key;
	if(window.event)
	{
		key = window.event.keyCode;     //IE
	}
	else
	{
		key = e.which;     //firefox
	}
	
	if(key == 13) // if enter key press
	{
		return false;
	}
	else
	{
		return true;
	}

}

function paymententry1process2()
{
	if (document.getElementById("cbfrmflag1").value == "")
	{
		alert ("Search Bill Number Cannot Be Empty.");
		document.getElementById("cbfrmflag1").focus();
		document.getElementById("cbfrmflag1").value = "<?php echo $cbfrmflag1; ?>";
		return false;
	}
}

function paymententry1process1()
{
	//alert ("inside if");
	
	if (document.getElementById("accnameid").value == "")
	{
		alert ("Select account from list");
		document.getElementById("searchsuppliername").focus();
		return false;
	}
	if (document.getElementById("paymentamount").value == "")
	{
		alert ("Payment Amount Cannot Be Empty.");
		document.getElementById("paymentamount").focus();
		document.getElementById("paymentamount").value = "0.00"
		return false;
	}
	if (document.getElementById("paymentamount").value == "0.00")
	{
		alert ("Payment Amount Cannot Be Empty.");
		document.getElementById("paymentamount").focus();
		document.getElementById("paymentamount").value = "0.00"
		return false;
	}
	var numbers =/^[a-zA-Z]+$/;
	if ((document.getElementById("paymentamount").value.match(numbers)))
	{
		alert ("Payment Amount Can Only Be Numbers.");
		document.getElementById("paymentamount").focus();
		return false;
	}
	if (document.getElementById("paymentmode").value == "")
	{
		alert ("Please Select Payment Mode.");
		document.getElementById("paymentmode").focus();
		return false;
	}
	if (document.getElementById("paymentmode").value == "CHEQUE")
	{
		if(document.getElementById("chequenumber").value == "")
		{
			alert ("If Payment By Cheque, Then Cheque Number Cannot Be Empty.");
			document.getElementById("chequenumber").focus();
			return false;
		} 
	}
	if (document.getElementById("bankname").value == "")
	{
		alert ("Bank Name Cannot Be Empty.");
		document.getElementById("bankname").focus();
		return false;
	}
	
	var fRet; 
	fRet = confirm('Are you sure want to save this payment entry?'); 
	//alert(fRet); 
	//alert(document.getElementById("paymentamount").value); 
	//alert(document.getElementById("pendingamounthidden").value); 
	if (fRet == true)
	{
		var varPaymentAmount = document.getElementById("paymentamount").value; 
		var varPaymentAmount = varPaymentAmount * 1;
		var varPendingAmount = document.getElementById("pendingamounthidden").value; 
		var varPendingAmount = parseInt(varPendingAmount);
		var varPendingAmount = varPendingAmount * 1;
		//alert (varPendingAmount);
		/*
		if (varPaymentAmount > varPendingAmount)
		{
			alert('Payment Amount Is Greater Than Pending Amount. Entry Cannot Be Saved.'); 
			alert ("Payment Entry Not Completed.");
			return false;
		}
		*/
	}
	if (fRet == false)
	{
		alert ("Payment Entry Not Completed.");
		return false;
	}
		
	//return false;
	
}

function funcPrintReceipt1()
{
	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}

</script>
<script>
function updatebox(varSerialNumber,billamt,totalcount1)
{
if(document.getElementById("onaccount").checked == true)
{
alert("Dont Select Invoice");
document.getElementById("acknow"+varSerialNumber+"").checked = false;
return false;
}
var adjamount1;
var grandtotaladjamt2=0;
var varSerialNumber = varSerialNumber;
var totalcount1=totalcount1;
var billamt = billamt;
  var textbox = document.getElementById("adjamount"+varSerialNumber+"");
    textbox.value = "";
if(document.getElementById("acknow"+varSerialNumber+"").checked == true)
{
    if(document.getElementById("acknow"+varSerialNumber+"").checked) {
        textbox.value = billamt;
    }
	var balanceamt=billamt-billamt;
	document.getElementById("balamount"+varSerialNumber+"").value=balanceamt.toFixed(2);
	var totalbillamt=document.getElementById("paymentamount").value;
	totalbillamt=totalbillamt.replace(/,/g,'');
	if(totalbillamt == 0.00)
{
totalbillamt=0;
}
				totalbillamt=parseFloat(totalbillamt)+parseFloat(billamt);
			
			//alert(totalbillamt);
totalbillamt = totalbillamt.toFixed(2);
totalbillamt = totalbillamt.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
document.getElementById("paymentamount").value = totalbillamt;
document.getElementById("totaladjamt").value = totalbillamt;
}
else
{
//alert(totalcount1);
for(j=1;j<=totalcount1;j++)
{
var totaladjamount2=document.getElementById("adjamount"+j+"").value;

if(totaladjamount2 == "")
{
totaladjamount2=0;
}
grandtotaladjamt2=grandtotaladjamt2+parseFloat(totaladjamount2);
}
//alert(grandtotaladjamt);
document.getElementById("paymentamount").value = grandtotaladjamt2.toFixed(2);
document.getElementById("totaladjamt").value=grandtotaladjamt2.toFixed(2);

 }  
}
function checkboxcheck(varSerialNumber5)
{

if(document.getElementById("acknow"+varSerialNumber5+"").checked == false)
{
alert("Please click on the Select check box");
return false;
}
return true;
}

function checkvalid(totcount)
{
var totcount=totcount;

for(j=1;j<=totcount;j++)
{
if(document.getElementById("acknow"+j+"").checked == true)
{
alert("Please deselect invoice");

return false;
}
}
return true;

}

function checkboxvalidat()
{
var accname = document.getElementById("searchsuppliername").value;
if(accname == '')
{
alert('Please Select the Account');
document.getElementById("searchsuppliername").focus();
return false;
}
var chks = document.getElementsByName('onaccount');
var hasChecked = false;
for (var i = 0; i < chks.length; i++)
{
if (chks[i].checked)
{
hasChecked = true;
}
}

var chks1 = document.getElementsByName('ack[]');
hasChecked1 = false;
for(var j = 0; j < chks1.length; j++)
{
if(chks1[j].checked)
{
hasChecked1 = true;
}
}

if (hasChecked == false && hasChecked1 == false)
{
alert("Please Select OnAccount or Invoice");
return false;
}
return true;
}
function balancecalc(varSerialNumber1,billamt1,totalcount)
{
var varSerialNumber1 = varSerialNumber1;
var billamt1 = billamt1;
var totalcount=totalcount;
var grandtotaladjamt=0;

var adjamount=document.getElementById("adjamount"+varSerialNumber1+"").value;
var adjamount3=parseFloat(adjamount);
if(adjamount3 > billamt1)
{
alert("Please enter correct amount");
document.getElementById("paymentamount").value = '0.00';
document.getElementById("totaladjamt").value = '0.00';
document.getElementById("adjamount"+varSerialNumber1+"").value = '0.00';
document.getElementById("balamount"+varSerialNumber1+"").value = billamt1;
document.getElementById("adjamount"+varSerialNumber1+"").focus();
return false;
}
var balanceamount=parseFloat(billamt1)-parseFloat(adjamount);
balanceamount = balanceamount.toFixed(2);
balanceamount = balanceamount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
document.getElementById("balamount"+varSerialNumber1+"").value=balanceamount;
for(i=1;i<=totalcount;i++)
{
var totaladjamount=document.getElementById("adjamount"+i+"").value;
if(totaladjamount == "")
{
totaladjamount=0;
}
grandtotaladjamt=grandtotaladjamt+parseFloat(totaladjamount);

}
grandtotaladjamt = grandtotaladjamt.toFixed(2);
grandtotaladjamt = grandtotaladjamt.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
document.getElementById("paymentamount").value = grandtotaladjamt;
document.getElementById("totaladjamt").value=grandtotaladjamt;

}

</script>
<?php

$query765 = "select code from master_financialintegration where field='cashaccountreceivable'";
$exec765 = mysql_query($query765) or die(mysql_error());
$res765= mysql_fetch_array($exec765);

$cashcoa = $res765['code'];


$query766 = "select code from master_financialintegration where field='chequeaccountreceivable'";
$exec766 = mysql_query($query766) or die(mysql_error());
$res766 = mysql_fetch_array($exec766);

$chequecoa = $res766['code'];


$query767 = "select code from master_financialintegration where field='mpesaaccountreceivable'";
$exec767 = mysql_query($query767) or die(mysql_error());
$res767 = mysql_fetch_array($exec767);

$mpesacoa = $res767['code'];

$query768 = "select code from master_financialintegration where field='cardaccountreceivable'";
$exec768 = mysql_query($query768) or die(mysql_error());
$res768 = mysql_fetch_array($exec768);

$cardcoa = $res768['code'];

$query769 = "select code from master_financialintegration where field='onlineaccountreceivable'";
$exec769 = mysql_query($query769) or die(mysql_error());
$res769 = mysql_fetch_array($exec769);

$onlinecoa = $res769['code'];

/*$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);*/
$paynowbillprefix = 'AR-';
$paynowbillprefix1=strlen($paynowbillprefix);

$query2 = "select paylaterdocno from master_transactionpaylater where transactiontype='PAYMENT' and paylaterdocno <>'' order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["paylaterdocno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='AR-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["paylaterdocno"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'AR-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
?>

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

<body>
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
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="paylaterpaymententry.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#CCCCCC" class="bodytext3"><strong>Receivable Entry     - Select Account </strong></td>
              </tr>
            <tr>
              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
              </tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Account </td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">
              </span></td>
              </tr>
            <tr>
              <td width="18%"  align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"> Account </td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  
			  <input value="<?php echo $cbsuppliername; ?>" name="cbsuppliername" type="text" id="cbsuppliername" readonly onKeyDown="return disableEnterKey()" size="50" ></td>
              </tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>
            </tr>
          </tbody>
        </table>
		</form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      
   
      <tr>
        <td>
		
		
		
				<form name="form1" id="form1" method="post" action="paylaterpaymententry.php?cbfrmflag1=<?php echo $cbfrmflag1; ?>" onSubmit="return paymententry1process1()">
			  <table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                <tbody>
				<?php
				// include("rowcount1.php");
				 
				?>
                  <tr bgcolor="#011E6A">
                    <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Payment  Entry - Details </strong></td>
                    <!--<td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                    <td bgcolor="#CCCCCC" class="bodytext3" colspan="2">
					</td>
                  </tr>
                  <tr>
                    <td colspan="8" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#FFFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="17%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Total Pending Amount </td>
                    <td width="29%" align="left" valign="top"  bgcolor="#FFFFFF">
					<input name="pendingamount" id="pendingamount" style="border: 1px solid #001E6A; text-align:right" value=""  size="20" readonly onKeyDown="return disableEnterKey()" />
					<input name="pendingamounthidden" id="pendingamounthidden" type="hidden" value="<?php echo $balanceamount; ?>"  size="20" readonly onKeyDown="return disableEnterKey()" />					</td>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Entry Date (YYYY-MM-DD) </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">
					<input name="paymententrydate" id="paymententrydate" style="border: 1px solid #001E6A" value="<?php echo $updatedatetime; ?>"  readonly="readonly" onKeyDown="return disableEnterKey()" size="20" />
                    <img src="images2/cal.gif" onClick="javascript:NewCssCal('paymententrydate')" style="cursor:pointer"/>
                    </td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Receivable Amount </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">
					<input name="paymentamount" id="paymentamount" style="border: 1px solid #001E6A; text-align:right" value="0.00"  size="20" />
					<input type="hidden" name="cashcoa" value="<?php echo $cashcoa; ?>">
				<input type="hidden" name="chequecoa" value="<?php echo $chequecoa; ?>">
				<input type="hidden" name="mpesacoa" value="<?php echo $mpesacoa; ?>">
				<input type="hidden" name="cardcoa" value="<?php echo $cardcoa; ?>">
				<input type="hidden" name="onlinecoa" value="<?php echo $onlinecoa; ?>">
				<input type="hidden" name="accname" value="<?php echo $suppliername; ?>">
                <input type="hidden" name="accnameano" value="<?php echo $supplieranum; ?>">
                <input type="hidden" name="accnameid" id="accnameid" value="<?php echo $arraysuppliercode; ?>">
		</td>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Payment Mode </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">
					<select name="paymentmode" id="paymentmode" style="width: 130px;">
                        <option value="" selected="selected">SELECT</option>
                        <option value="CHEQUE">CHEQUE</option>
                        <option value="CASH">CASH</option>
                        <!--<option value="TDS">TDS</option>-->
                        <option value="ONLINE">ONLINE</option>
						<option value="MPESA">MPESA</option>
                        <option value="WRITEOFF">ADJUSTMENT</option>
						
                    </select></td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"> Number </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">
					<input name="chequenumber" id="chequenumber" style="border: 1px solid #001E6A" value=""  size="20" /></td>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Bank Name </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><!--<input name="bankname" id="bankname" style="border: 1px solid #001E6A" value=""  size="20" />-->
					<select name="bankname" id="bankname">
					<option value="">Select Bank</option>
					<?php 
					$querybankname = "select bankname, bankcode from master_bank where bankstatus <> 'deleted'";
					$execbankname = mysql_query($querybankname) or die ("Error in Query3".mysql_error());
					while($resbankname = mysql_fetch_array($execbankname))
					{?>
						<option value="<?php echo $resbankname['bankcode'].'|'.$resbankname['bankname']; ?>"><?php echo $resbankname['bankname'];?></option>
					<?php
					}
					?>
					</select>
					</td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">  Date </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo date('Y-m-d'); ?>"  size="20"  readonly="readonly" onKeyDown="return disableEnterKey()"/>
					<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>
				    </td>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Remarks</td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="remarks" id="remarks" style="border: 1px solid #001E6A" value=""  size="20" />
					 <input type="hidden" name="docno" value="<?php echo $billnumbercode; ?>"></td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">ON Account</td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><input type="checkbox" name="onaccount" id="onaccount" onClick="return checkvalid('<?php echo $number; ?>');" checked></td>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                      <input type="hidden" name="cbfrmflag2" value="<?php echo $supplieranum; ?>">
                      <input type="hidden" name="frmflag2" value="frmflag2">
                      <input name="Submit" type="submit"  value="Save Payment" class="button" onClick="return checkboxvalidat();"style="border: 1px solid #001E6A"/>
                    </font></td>
                  </tr>
                </tbody>
              </table>
			 	</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
	  <tr>
        <td>
			</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
	  
	  </form>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

