<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$errmsg = "";
$banum = "1";
$bgcolorcode = '';
$docno = $_SESSION['docno'];

$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysql_query($query) or die ("Error in Query1".mysql_error());
$res = mysql_fetch_array($exec);
	
	$locationname = $res["locationname"];
	$locationcode = $res["locationcode"];
	$res12locationanum = $res["auto_number"];



if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag1 = $_REQUEST['frmflag1'];
if ($frmflag1 == 'frmflag1')
{
	

	$receiptdate = $_REQUEST['receiptdate'];
	$receiptentrydate = $_REQUEST['receiptentrydate'];
	$receiptamount = $_REQUEST['receiptamount'];
	$receiptmode = $_REQUEST['receiptmode'];
	$chequenumber = $_REQUEST['chequenumber'];
	$bankname = $_REQUEST['bankname'];
	$chequedate = $_REQUEST['ADate1'];
	$remarks = $_REQUEST['remarks'];
	$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$paynowbillprefix = 'MSE-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from receiptsub_details order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docnumber"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='MSE-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["docnumber"];
 	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'MSE-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
	$docnumber = $billnumbercode;
	$cashcoa = $_REQUEST['cashcoa'];
		$chequecoa = $_REQUEST['chequecoa'];
		$cardcoa = $_REQUEST['cardcoa'];
		$mpesacoa = $_REQUEST['mpesacoa'];
		$onlinecoa = $_REQUEST['onlinecoa'];
		$receiptentrycoa = $_REQUEST['paynowlabcode5'];
		$mpesanumber=$_REQUEST['mpesanum'];
		$refrencenum=$_REQUEST['refrenceno'];
		$receivedfrom=$_REQUEST['receivedfrom'];
	/*
	$query1 = "select * from master_receipt where auto_number = '$receiptname'";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	$res1 = mysql_fetch_array($exec1);
	$receiptname = $res1['receiptname'];
	*/
	
	$query21 = "select * from master_accountname where id='$receiptentrycoa' order by auto_number desc limit 0, 1";
	$exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
	$res21 = mysql_fetch_array($exec21);
	$receiptmainanum = $res21["accountsmain"];
	$receiptsubanum = $res21["accountssub"];
	$receiptsubname = $res21["accountname"];
	
	$query1 = "select * from master_accountsmain where auto_number = '$receiptmainanum'";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	$res1 = mysql_fetch_array($exec1);
	$receiptmainname = $res1['accountsmain'];	
	
	$transactiondate = $receiptentrydate;
	$transactionamount = $receiptamount;
	$transactionmode1 = $receiptmode;
	$ipaddress = $ipaddress;
	$updatedate = $updatedatetime;
	
	//to update transaction master form transaction report.
	$transactiontype1 = $receiptname;
	$transactionmodule1 = 'EXPENSE';
	$particulars1 = 'BY EXPENSE - '.$receiptname;	
	
	$chequeamount = '0.00';
	$cashamount = '0.00';
	$onlineamount = '0.00';
	$cardamount = '0.00';
	$mpesaamount = '0.00';
	
	
	$query10 = "select * from receiptsub_details where receiptmainanum = '$receiptmainanum' and receiptsubanum = '$receiptsubanum' and companyanum = '$companyanum' and updatedate = '$updatedate' ";
	$exec10 = mysql_query($query10) or die ("Error in Query10 ".mysql_error());
	$res10 = mysql_num_rows($exec10);
	if ($res10 != 0)
	{
		header ("location:miscellaneous_receiptentry.php?st=1");
	}

	if ($receiptmode == 'CHEQUE') 
	{
	$chequeamount = $receiptamount;	
	$query37 = "insert into paymentmodedebit(billnumber,billdate,ipaddress,username,cheque,chequecoa,source,locationcode, locationname)values('$docnumber','$transactiondate','$ipaddress','$username','$chequeamount','$chequecoa','miscreceiptentry','$locationcode','$locationname')";
        $exec37 = mysql_query($query37) or die(mysql_error());
	
	$query551 = "select * from financialaccount where transactionmode = 'CHEQUE'";
	 $exec551 = mysql_query($query551) or die ("Error in Query551".mysql_error());
	 $res551 = mysql_fetch_array($exec551);
	 $chequecode = $res551['ledgercode'];	
		
	$query9 = "insert into receiptsub_details (receiptmainanum, receiptmainname, receiptsubanum, receiptsubname, 
	transactiondate, particulars,  
	transactionmode, transactiontype, transactionamount, ipaddress, 
	cashamount, onlineamount, chequeamount, creditamount, cardamount, 
	updatedate, companyanum, companyname, transactionmodule, 
	chequenumber, bankname, chequedate, remarks,docnumber,receiptcoa,username,mpesanumber,refrenceno,receivedfrom,locationcode,locationname,bankcode) 
	values ('$receiptmainanum', '$receiptmainname', '$receiptsubanum', '$receiptsubname', 
	'$transactiondate', '$particulars1',  
	'$transactionmode1', '$transactiontype1', '$transactionamount', '$ipaddress', 
	'$cashamount', '$onlineamount', '$chequeamount', '$mpesaamount', '$cardamount', 
	'$updatedate', '$companyanum', '$companyname', '$transactionmodule1', 
	'$chequenumber', '$bankname', '$chequedate', '$remarks','$docnumber','$receiptentrycoa','$username','$mpesanumber','$refrencenum', '$receivedfrom','$locationcode','$locationname','$chequecode')";
	$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		

	}
	if ($receiptmode == 'CASH')
	{
	 $cashamount = $receiptamount;	
	 	$query37 = "insert into paymentmodedebit(billnumber,billdate,ipaddress,username,cash,cashcoa,source,locationcode, locationname)values('$docnumber','$transactiondate','$ipaddress','$username','$cashamount','$cashcoa','miscreceiptentry','$locationcode','$locationname')";
        $exec37 = mysql_query($query37) or die(mysql_error());
		
	$query551 = "select * from financialaccount where transactionmode = 'CASH'";
	 $exec551 = mysql_query($query551) or die ("Error in Query551".mysql_error());
	 $res551 = mysql_fetch_array($exec551);
	 $cashcode = $res551['ledgercode'];	
		
	$query9 = "insert into receiptsub_details (receiptmainanum, receiptmainname, receiptsubanum, receiptsubname, 
	transactiondate, particulars,  
	transactionmode, transactiontype, transactionamount, ipaddress, 
	cashamount, onlineamount, chequeamount, creditamount, cardamount, 
	updatedate, companyanum, companyname, transactionmodule, 
	chequenumber, bankname, chequedate, remarks,docnumber,receiptcoa,username,mpesanumber,refrenceno,receivedfrom,locationcode,locationname,cashcode) 
	values ('$receiptmainanum', '$receiptmainname', '$receiptsubanum', '$receiptsubname', 
	'$transactiondate', '$particulars1',  
	'$transactionmode1', '$transactiontype1', '$transactionamount', '$ipaddress', 
	'$cashamount', '$onlineamount', '$chequeamount', '$mpesaamount', '$cardamount', 
	'$updatedate', '$companyanum', '$companyname', '$transactionmodule1', 
	'$chequenumber', '$bankname', '$chequedate', '$remarks','$docnumber','$receiptentrycoa','$username','$mpesanumber','$refrencenum', '$receivedfrom','$locationcode','$locationname','$cashcode')";
	$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());	

	}
	if ($receiptmode == 'ONLINE') 
	{
	$onlineamount = $receiptamount;	
		$query37 = "insert into paymentmodedebit(billnumber,billdate,ipaddress,username,online,onlinecoa,source,locationcode,locationname)values('$docnumber','$transactiondate','$ipaddress','$username','$onlineamount','$onlinecoa','miscreceiptentry','$locationcode','$locationname')";
        $exec37 = mysql_query($query37) or die(mysql_error());
		
	$query551 = "select * from financialaccount where transactionmode = 'ONLINE'";
	 $exec551 = mysql_query($query551) or die ("Error in Query551".mysql_error());
	 $res551 = mysql_fetch_array($exec551);
	 $chequecode = $res551['ledgercode'];	
		
	$query9 = "insert into receiptsub_details (receiptmainanum, receiptmainname, receiptsubanum, receiptsubname, 
	transactiondate, particulars,  
	transactionmode, transactiontype, transactionamount, ipaddress, 
	cashamount, onlineamount, chequeamount, creditamount, cardamount, 
	updatedate, companyanum, companyname, transactionmodule, 
	chequenumber, bankname, chequedate, remarks,docnumber,receiptcoa,username,mpesanumber,refrenceno,receivedfrom,locationcode,locationname,bankcode) 
	values ('$receiptmainanum', '$receiptmainname', '$receiptsubanum', '$receiptsubname', 
	'$transactiondate', '$particulars1',  
	'$transactionmode1', '$transactiontype1', '$transactionamount', '$ipaddress', 
	'$cashamount', '$onlineamount', '$chequeamount', '$mpesaamount', '$cardamount', 
	'$updatedate', '$companyanum', '$companyname', '$transactionmodule1', 
	'$chequenumber', '$bankname', '$chequedate', '$remarks','$docnumber','$receiptentrycoa','$username','$mpesanumber','$refrencenum', '$receivedfrom','$locationcode','$locationname','$chequecode')";
	$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());	

	}
	if ($receiptmode == 'CARD') 
	{
	$cardamount = $receiptamount;
	$query37 = "insert into paymentmodedebit(billnumber,billdate,ipaddress,username,card,cardcoa,source,locationcode,locationname)values('$docnumber','$transactiondate','$ipaddress','$username','$cardamount','$cardcoa','miscreceiptentry','$locationcode','$locationname')";
        $exec37 = mysql_query($query37) or die(mysql_error());
		
	$query551 = "select * from financialaccount where transactionmode = 'CREDITCARD'";
	 $exec551 = mysql_query($query551) or die ("Error in Query551".mysql_error());
	 $res551 = mysql_fetch_array($exec551);
	 $chequecode = $res551['ledgercode'];	
		
	$query9 = "insert into receiptsub_details (receiptmainanum, receiptmainname, receiptsubanum, receiptsubname, 
	transactiondate, particulars,  
	transactionmode, transactiontype, transactionamount, ipaddress, 
	cashamount, onlineamount, chequeamount, creditamount, cardamount, 
	updatedate, companyanum, companyname, transactionmodule, 
	chequenumber, bankname, chequedate, remarks,docnumber,receiptcoa,username,mpesanumber,refrenceno,receivedfrom,locationcode,locationname,bankcode) 
	values ('$receiptmainanum', '$receiptmainname', '$receiptsubanum', '$receiptsubname', 
	'$transactiondate', '$particulars1',  
	'$transactionmode1', '$transactiontype1', '$transactionamount', '$ipaddress', 
	'$cashamount', '$onlineamount', '$chequeamount', '$mpesaamount', '$cardamount', 
	'$updatedate', '$companyanum', '$companyname', '$transactionmodule1', 
	'$chequenumber', '$bankname', '$chequedate', '$remarks','$docnumber','$receiptentrycoa','$username','$mpesanumber','$refrencenum', '$receivedfrom','$locationcode','$locationname','$chequecode')";
	$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());	

	}
	
	if ($receiptmode == 'MPESA') 
	{
	$mpesaamount = $receiptamount;
	$query37 = "insert into paymentmodedebit(billnumber,billdate,ipaddress,username,mpesa,mpesacoa,source,locationcode,locationname)values('$docnumber','$transactiondate','$ipaddress','$username','$mpesaamount','$cardcoa','miscreceiptentry','$locationcode','$locationname')";
        $exec37 = mysql_query($query37) or die(mysql_error());
		
	$query551 = "select * from financialaccount where transactionmode = 'MPESA'";
	 $exec551 = mysql_query($query551) or die ("Error in Query551".mysql_error());
	 $res551 = mysql_fetch_array($exec551);
	 $mpesacode = $res551['ledgercode'];	
		
	$query9 = "insert into receiptsub_details (receiptmainanum, receiptmainname, receiptsubanum, receiptsubname, 
	transactiondate, particulars,  
	transactionmode, transactiontype, transactionamount, ipaddress, 
	cashamount, onlineamount, chequeamount, creditamount, cardamount, 
	updatedate, companyanum, companyname, transactionmodule, 
	chequenumber, bankname, chequedate, remarks,docnumber,receiptcoa,username,mpesanumber,refrenceno,receivedfrom,locationcode,locationname,mpesacode) 
	values ('$receiptmainanum', '$receiptmainname', '$receiptsubanum', '$receiptsubname', 
	'$transactiondate', '$particulars1',  
	'$transactionmode1', '$transactiontype1', '$transactionamount', '$ipaddress', 
	'$cashamount', '$onlineamount', '$chequeamount', '$mpesaamount', '$cardamount', 
	'$updatedate', '$companyanum', '$companyname', '$transactionmodule1', 
	'$chequenumber', '$bankname', '$chequedate', '$remarks','$docnumber','$receiptentrycoa','$username','$mpesanumber','$refrencenum', '$receivedfrom','$locationcode','$locationname','$mpesacode')";
	$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());		

	}	
		
	header ("location:miscellaneous_receiptentry.php?st=1");
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];

if ($st == '1')
{
	$errmsg = "Success. Receipt Payment Entry Updated.";
	$bgcolorcode = 'failed';
}

?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$paynowbillprefix = 'MSE-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from receiptsub_details where docnumber LIKE '%MSE-%' order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docnumber"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='MSE-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["docnumber"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'MSE-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
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
<?php

$query765 = "select * from master_financialintegration where field='cashreceiptentry'";
$exec765 = mysql_query($query765) or die(mysql_error());
$res765= mysql_fetch_array($exec765);

$cashcoa = $res765['code'];


$query766 = "select * from master_financialintegration where field='chequereceiptentry'";
$exec766 = mysql_query($query766) or die(mysql_error());
$res766 = mysql_fetch_array($exec766);

$chequecoa = $res766['code'];


$query767 = "select * from master_financialintegration where field='mpesareceiptentry'";
$exec767 = mysql_query($query767) or die(mysql_error());
$res767 = mysql_fetch_array($exec767);

$mpesacoa = $res767['code'];

$query768 = "select * from master_financialintegration where field='cardreceiptentry'";
$exec768 = mysql_query($query768) or die(mysql_error());
$res768 = mysql_fetch_array($exec768);

$cardcoa = $res768['code'];

$query769 = "select * from master_financialintegration where field='onlinereceiptentry'";
$exec769 = mysql_query($query769) or die(mysql_error());
$res769 = mysql_fetch_array($exec769);

$onlinecoa = $res769['code'];


?>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">

function cbcustomername1()
{
	document.cbform1.submit();
}

</script>
<script type="text/javascript" src="js/autocomplete_customer1.js"></script>
<script type="text/javascript" src="js/autosuggest3.js"></script>
<script type="text/javascript" src="js/receiptfunction.js"></script>

<script type="text/javascript">

function functionkeyup(val)
{
var key=val;
document.getElementById("receivedfrom").value=key;	

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


function paymententry1process1()
{
	//alert ("inside if");
	/*
	if (document.getElementById("receiptname").value == "")
	{
		alert ("Please Select Receipt Name.");
		document.getElementById("receiptname").focus();
		return false;
	}
	*/
	if (document.getElementById("paynowreferalcode").value == "")
	{
		alert ("Please Select an Account");
		document.getElementById("paynowreferalcode").focus();
		return false;
	}
	
	if (document.getElementById("receiptamount").value == "")
	{
		alert ("Receipt Amount Cannot Be Empty.");
		document.getElementById("receiptamount").focus();
		document.getElementById("receiptamount").value = "0.00"
		return false;
	}
	if (document.getElementById("receiptamount").value == "0.00")
	{
		alert ("Receipt Amount Cannot Be Empty.");
		document.getElementById("receiptamount").focus();
		document.getElementById("receiptamount").value = "0.00"
		return false;
	}
	if (isNaN(document.getElementById("receiptamount").value))
	{
		alert ("Receipt Amount Can Only Be Numbers.");
		document.getElementById("receiptamount").focus();
		return false;
	}
	if (document.getElementById("receiptmode").value == "")
	{
		alert ("Please Select Receipt Mode.");
		document.getElementById("receiptmode").focus();
		return false;
	}
	if (document.getElementById("receiptmode").value == "CHEQUE")
	{
		if(document.getElementById("chequenumber").value == "")
		{
			alert ("If Receipt By Cheque, Then Cheque Number Cannot Be Empty.");
			document.getElementById("chequenumber").focus();
			return false;
		} 
		else if (document.getElementById("bankname").value == "")
		{
			alert ("If Receipt By Cheque, Then Bank Name Cannot Be Empty.");
			document.getElementById("bankname").focus();
			return false;
		}
		else if (document.getElementById("ADate1").value == "")
		{
			alert ("If Receipt By Cheque, Then Cheque Date Cannot Be Empty.");
			document.getElementById("ADate1").focus();
			return false;
		}
		
		
	}
		
		if (document.getElementById("receiptmode").value == "MPESA")
		{
		if(document.getElementById("mpesanum").value == "")
		{
			alert('Please Enter The Mpesa Number');
			document.getElementById("mpesanum").focus();
			return false;
		}
		}
			
	if (document.getElementById("refrenceno").value == "")
	{
		alert ("Please Enter The Refrence Number .");
		document.getElementById("refrenceno").focus();
		
		return false;
	}
	if (document.getElementById("receivedfrom").value == "")
	{
		alert ("Please Enter The Received From.");
		document.getElementById("receivedfrom").focus();
		
		return false;
	}		
			
	var varUserChoice; 
	varUserChoice = confirm('Are You Sure Want To Save This Entry?'); 
	//alert(fRet); 
	if (varUserChoice == false)
	{
		alert ("Entry Not Saved.");
		return false;
	}
	//return false;
	funcPrintReceipt1();
}

function funcPrintReceipt1()
{
	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	window.open("receipt_mis_print.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}

</script>
<script>
function coasearch(varCallFrom)
{
	var varCallFrom = varCallFrom;
	window.open("popup_coasearchmis.php?callfrom="+varCallFrom,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}
</script>
<script src= "http://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
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
        <td >
		
		
		
				<form name="form1" id="form1" method="post" action="miscellaneous_receiptentry.php" onSubmit="return paymententry1process1()">
			  <table ng-app='' width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse" >
                <tbody>
                  <tr bgcolor="#011E6A">
                    <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Micellaneous Receipt Entry - Details </strong></td>
                    <!--<td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                    <td bgcolor="#CCCCCC" class="bodytext3" colspan="2">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="8" align="left" valign="middle"  
					bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?></td>
                  </tr>
                  <!--<tr>
                    <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext32">
                    <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Receipt Entry" />
*To Print Other Receipts Please Go To Menu:	Reports	-&gt; Receipt Report </span></td>
                  </tr>-->
                  
                  <tr>
                    <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext32">
                    <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Miscellaneous Receipt - Previous Receipt Entry" />
*To Print Other Receipts Please Go To Menu:	Reports	-&gt; Receipt Report </span></td>
                  </tr>
                  
                  
                  
                  <tr>
                
                   <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="text" name="paynowlabcoa5" id="paynowreferalcoa" size="40"/>
						 <input type="button" onClick="javascript:coasearch('4')" value="Select Account" accesskey="m" style="border: 1px solid #001E6A"> 
						 <input type="hidden" name="paynowlabtype5" id="paynowreferaltype" size="10"/>
						 	<input type="hidden" name="cashcoa" value="<?php echo $cashcoa; ?>">
				<input type="hidden" name="chequecoa" value="<?php echo $chequecoa; ?>">
				<input type="hidden" name="mpesacoa" value="<?php echo $mpesacoa; ?>">
				<input type="hidden" name="cardcoa" value="<?php echo $cardcoa; ?>">
				<input type="hidden" name="onlinecoa" value="<?php echo $onlinecoa; ?>">
	
						 <input type="hidden" name="paynowlabcode5" id="paynowreferalcode" size="10"/></td>
                
                     </tr>
                  <tr>
                       <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Doc No</td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><input type="text" name="docnumber" value="<?php echo $billnumbercode; ?>" size="8"></td>
           
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Entry Date (YYYY-MM-DD) </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">
					<input name="receiptentrydate" id="receiptentrydate" style="border: 1px solid #001E6A" value="<?php echo date('Y-m-d'); ?>"  readonly="readonly" onKeyDown="return disableEnterKey()" size="20" />
					<img src="images2/cal.gif" onClick="javascript:NewCssCal('receiptentrydate')" style="cursor:pointer"/>					</td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Receipt Amount </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">
					<input name="receiptamount" id="receiptamount" style="border: 1px solid #001E6A" value="0.00"  size="20" /></td>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Receipt Mode </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">
					<select name="receiptmode" id="receiptmode" style="width: 130px;" onChange="return functionmode(value)">
                        <option value="" selected="selected">SELECT</option>
                        <option value="CHEQUE">CHEQUE</option>
                        <option value="MPESA">MPESA</option>
                        <option value="CASH">CASH</option>
                        <option value="ONLINE">ONLINE</option>
                        <option value="CARD">CARD</option>
                        
                    </select></td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Cheque Number </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">
					<input name="chequenumber" id="chequenumber" style="border: 1px solid #001E6A" value=""  size="20" /></td>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Bank Name </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><!--<input name="bankname" id="bankname" style="border: 1px solid #001E6A" value=""  size="20" />-->
					<select name="bankname" id="bankname"   >
					<option value="">Select Bank</option>
					<?php 
					$querybankname = "select * from master_bank where bankstatus <> 'deleted'";
					$execbankname = mysql_query($querybankname) or die ("Error in Query3".mysql_error());
					while($resbankname = mysql_fetch_array($execbankname))
					{?>
						<option value="<?php echo $resbankname['bankname']; ?>"><?php echo $resbankname['bankname'];?></option>
					<?php
					}
					?>
					</select></td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Cheque  Date </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">
					<input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php //echo date('Y-m-d'); ?>"  size="20"  readonly="readonly" onKeyDown="return disableEnterKey()"/>
					<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>					  </td>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Remarks</td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="remarks" id="remarks" style="border: 1px solid #001E6A" value=""  size="20" /></td>
                  </tr>
                  <tr>
                  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Mpesa No</td>
                  <td align="left"   valign="middle"   bgcolor="#FFFFFF" class="bodytext3"><input name="mpesanum" id="mpesanum" style="border: 1px solid #001E6A" value=""  size="20" /></td>
                   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Refrence No</td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="refrenceno" id="refrenceno"    style="border: 1px solid #001E6A" value=""  size="20" /></td>
                  
                 
                  </tr>
                  <tr>
                   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Received From</td>
                  <td align="left" colspan="4" valign="middle"   bgcolor="#FFFFFF" class="bodytext3"><input name="receivedfrom" id="receivedfrom" style="border: 1px solid #001E6A"  size="20" /></td>
                 
                  </tr>
                  <tr>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">&nbsp;</td>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                      <input type="hidden" name="cbfrmflag2" value="<?php echo $customeranum; ?>">
                      <input type="hidden" name="frmflag1" value="frmflag1">
                      <input name="Submit" type="submit"  value="Save Receipt"  class="button" style="border: 1px solid #001E6A"/>
                    </font></td>
                  </tr>
                </tbody>
              </table>
		  </form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

