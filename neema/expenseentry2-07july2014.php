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

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag1 = $_REQUEST['frmflag1'];
if ($frmflag1 == 'frmflag1')
{
	$expensemainanum = $_REQUEST['expensemainanum'];
	$query1 = "select * from master_expensemain where auto_number = '$expensemainanum'";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	$res1 = mysql_fetch_array($exec1);
	$expensemainname = $res1['expensemainname'];

	$expensesubanum = $_REQUEST['expensesubanum'];
	$query1 = "select * from master_expensesub where auto_number = '$expensesubanum'";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	$res1 = mysql_fetch_array($exec1);
	$expensesubname = $res1['expensesubname'];

	$expensedate = $_REQUEST['expensedate'];
	$expenseentrydate = $_REQUEST['expenseentrydate'];
	$expenseamount = $_REQUEST['expenseamount'];
	$expensemode = $_REQUEST['expensemode'];
	$chequenumber = $_REQUEST['chequenumber'];
	$bankname = $_REQUEST['bankname'];
	$chequedate = $_REQUEST['ADate1'];
	$remarks = $_REQUEST['remarks'];
	$docnumber = $_REQUEST['docnumber'];
	$cashcoa = $_REQUEST['cashcoa'];
		$chequecoa = $_REQUEST['chequecoa'];
		$cardcoa = $_REQUEST['cardcoa'];
		$mpesacoa = $_REQUEST['mpesacoa'];
		$onlinecoa = $_REQUEST['onlinecoa'];
		$expenseentrycoa = $_REQUEST['paynowlabcode5'];
		$coaname = $_REQUEST['paynowlabcoa5'];
		$coacode = $_REQUEST['paynowlabcode5'];
	/*
	$query1 = "select * from master_expense where auto_number = '$expensename'";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	$res1 = mysql_fetch_array($exec1);
	$expensename = $res1['expensename'];
	*/
	
	$transactiondate = $expenseentrydate;
	$transactionamount = $expenseamount;
	$transactionmode1 = $expensemode;
	$ipaddress = $ipaddress;
	$updatedate = $updatedatetime;
	
	//to update transaction master form transaction report.
	$transactiontype1 = $expensename;
	$transactionmodule1 = 'EXPENSE';
	$particulars1 = 'BY EXPENSE - '.$expensename;	
	
	$chequeamount = '0.00';
	$cashamount = '0.00';
	$onlineamount = '0.00';
	$cardamount = '0.00';
	$adjustmentamount = '0.00';

	if ($expensemode == 'CHEQUE') 
	{
	$chequeamount = $expenseamount;	
	$query37 = "insert into paymentmodecredit(billnumber,billdate,ipaddress,username,cheque,chequecoa,accountname,accountcode,transactionamount)values('$docnumber','$transactiondate','$ipaddress','$username','$chequeamount','$chequecoa','$coaname','$coacode','$chequeamount')";
        $exec37 = mysql_query($query37) or die(mysql_error());
	
	}
	if ($expensemode == 'CASH') 
	{
	$cashamount = $expenseamount;	
	
		$query37 = "insert into paymentmodecredit(billnumber,billdate,ipaddress,username,cash,cashcoa,accountname,accountcode,transactionamount)values('$docnumber','$transactiondate','$ipaddress','$username','$cashamount','$cashcoa','$coaname','$coacode','$cashamount')";
        $exec37 = mysql_query($query37) or die(mysql_error());
	
	}
	if ($expensemode == 'ONLINE') 
	{
	$onlineamount = $expenseamount;	
	
	$query37 = "insert into paymentmodecredit(billnumber,billdate,ipaddress,username,online,onlinecoa,accountname,accountcode,transactionamount)values('$docnumber','$transactiondate','$ipaddress','$username','$onlineamount','$onlinecoa','$coaname','$coacode','$onlineamount')";
        $exec37 = mysql_query($query37) or die(mysql_error());
	
	}
	if ($expensemode == 'CARD')
	{
	 $cardamount = $expenseamount;	
	 
	 	$query37 = "insert into paymentmodecredit(billnumber,billdate,ipaddress,username,card,cardcoa,accountname,accountcode,transactionamount)values('$docnumber','$transactiondate','$ipaddress','$username','$cardamount','$cardcoa','$coaname','$coacode','$cardamount')";
        $exec37 = mysql_query($query37) or die(mysql_error());

	 }
	if ($expensemode == 'ADJUSTMENT')
	{
	 $adjustmentamount = $expenseamount;
	}
	$query10 = "select * from expensesub_details where expensemainanum = '$expensemainanum' and expensesubanum = '$expensesubanum' and companyanum = '$companyanum' and updatedate = '$updatedate' ";
	$exec10 = mysql_query($query10) or die ("Error in Query10 ".mysql_error());
	$res10 = mysql_num_rows($exec10);
	if ($res10 != 0)
	{
		header ("location:expenseentry2.php?st=1");
	}

	$query9 = "insert into expensesub_details (expensemainanum, expensemainname, expensesubanum, expensesubname, 
	transactiondate, particulars,  
	transactionmode, transactiontype, transactionamount, ipaddress, 
	cashamount, onlineamount, chequeamount, adjustmentamount, cardamount, 
	updatedate, companyanum, companyname, transactionmodule, 
	chequenumber, bankname, chequedate, remarks,docnumber,expensecoa) 
	values ('$expensemainanum', '$expensemainname', '$expensesubanum', '$expensesubname', 
	'$transactiondate', '$particulars1',  
	'$transactionmode1', '$transactiontype1', '$transactionamount', '$ipaddress', 
	'$cashamount', '$onlineamount', '$chequeamount', '$adjustmentamount', '$cardamount', 
	'$updatedate', '$companyanum', '$companyname', '$transactionmodule1', 
	'$chequenumber', '$bankname', '$chequedate', '$remarks','$docnumber','$expenseentrycoa')";
	$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
	
	header ("location:expenseentry2.php?st=1");
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == '1')
{
	$errmsg = "Success. Expense Payment Entry Updated.";
	$bgcolorcode = 'failed';
}

?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$paynowbillprefix = 'EE-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from expensesub_details order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docnumber"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='EE-'.'1';
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
	
	
	$billnumbercode = 'EE-' .$maxanum;
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
<script type="text/javascript" src="js/expensefunction.js"></script>

<script type="text/javascript">


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
	if (document.getElementById("expensename").value == "")
	{
		alert ("Please Select Expense Name.");
		document.getElementById("expensename").focus();
		return false;
	}
	*/
	if (document.getElementById("expensemainanum").value == "")
	{
		alert ("Please Select Expense Main Name.");
		document.getElementById("expensemainanum").focus();
		return false;
	}
	if (document.getElementById("expensesubanum").value == "")
	{
		alert ("Please Select Expense Sub Name.");
		document.getElementById("expensesubanum").focus();
		return false;
	}
	if (document.getElementById("expenseamount").value == "")
	{
		alert ("Expense Amount Cannot Be Empty.");
		document.getElementById("expenseamount").focus();
		document.getElementById("expenseamount").value = "0.00"
		return false;
	}
	if (document.getElementById("expenseamount").value == "0.00")
	{
		alert ("Expense Amount Cannot Be Empty.");
		document.getElementById("expenseamount").focus();
		document.getElementById("expenseamount").value = "0.00"
		return false;
	}
	if (isNaN(document.getElementById("expenseamount").value))
	{
		alert ("Expense Amount Can Only Be Numbers.");
		document.getElementById("expenseamount").focus();
		return false;
	}
	if (document.getElementById("expensemode").value == "")
	{
		alert ("Please Select Expense Mode.");
		document.getElementById("expensemode").focus();
		return false;
	}
	if (document.getElementById("expensemode").value == "CHEQUE")
	{
		if(document.getElementById("chequenumber").value == "")
		{
			alert ("If Expense By Cheque, Then Cheque Number Cannot Be Empty.");
			document.getElementById("chequenumber").focus();
			return false;
		} 
		else if (document.getElementById("bankname").value == "")
		{
			alert ("If Expense By Cheque, Then Bank Name Cannot Be Empty.");
			document.getElementById("bankname").focus();
			return false;
		}
		else if (document.getElementById("ADate1").value == "")
		{
			alert ("If Expense By Cheque, Then Cheque Date Cannot Be Empty.");
			document.getElementById("ADate1").focus();
			return false;
		}
	}
	
		
	//return false;
	
}

function funcPrintReceipt1()
{
	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	window.open("print_expense_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}

</script>
<script>
function coasearch(varCallFrom)
{
	var varCallFrom = varCallFrom;
	window.open("popup_coaserach1.php?callfrom="+varCallFrom,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}
</script>
<?php

$query765 = "select * from master_financialintegration where field='cashexpenseentry'";
$exec765 = mysql_query($query765) or die(mysql_error());
$res765= mysql_fetch_array($exec765);

$cashcoa = $res765['code'];


$query766 = "select * from master_financialintegration where field='chequeexpenseentry'";
$exec766 = mysql_query($query766) or die(mysql_error());
$res766 = mysql_fetch_array($exec766);

$chequecoa = $res766['code'];


$query767 = "select * from master_financialintegration where field='mpesaexpenseentry'";
$exec767 = mysql_query($query767) or die(mysql_error());
$res767 = mysql_fetch_array($exec767);

$mpesacoa = $res767['code'];

$query768 = "select * from master_financialintegration where field='cardexpenseentry'";
$exec768 = mysql_query($query768) or die(mysql_error());
$res768 = mysql_fetch_array($exec768);

$cardcoa = $res768['code'];

$query769 = "select * from master_financialintegration where field='onlineexpenseentry'";
$exec769 = mysql_query($query769) or die(mysql_error());
$res769 = mysql_fetch_array($exec769);

$onlinecoa = $res769['code'];


?>
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
		
		
		
				<form name="form1" id="form1" method="post" action="expenseentry2.php" onSubmit="return paymententry1process1()">
			  <table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                <tbody>
                  <tr bgcolor="#011E6A">
                    <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Expense Entry - Details </strong></td>
                    <!--<td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                    <td bgcolor="#CCCCCC" class="bodytext3" colspan="2">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="8" align="left" valign="middle"  
					bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?></td>
                  </tr>
                  <tr>
                    <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext32">
                    <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Expense Entry" />
*To Print Other Receipts Please Go To Menu:	Reports	-&gt; Expense Report </span></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="text" name="paynowlabcoa5" id="paynowreferalcoa" size="40"/>
						 <input type="button" onClick="javascript:coasearch('4')" value="Select Account" accesskey="m" style="border: 1px solid #001E6A"> 
						 <input type="hidden" name="paynowlabtype5" id="paynowreferaltype" size="10"/>
						 	<input type="hidden" name="cashcoa" value="<?php echo $cashcoa; ?>">
				<input type="hidden" name="chequecoa" value="<?php echo $chequecoa; ?>">
				<input type="hidden" name="mpesacoa" value="<?php echo $mpesacoa; ?>">
				<input type="hidden" name="cardcoa" value="<?php echo $cardcoa; ?>">
				<input type="hidden" name="onlinecoa" value="<?php echo $onlinecoa; ?>">
	
						 <input type="hidden" name="paynowlabcode5" id="paynowreferalcode" size="10"/></td>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"></td>
                  </tr>
                  <tr>
                         <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Doc No</td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><input type="text" name="docnumber" value="<?php echo $billnumbercode; ?>" size="8"></td>
            
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Entry Date (YYYY-MM-DD) </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">
					<input name="expenseentrydate" id="expenseentrydate" style="border: 1px solid #001E6A" value="<?php echo date('Y-m-d'); ?>"  readonly="readonly" onKeyDown="return disableEnterKey()" size="20" />
					<img src="images2/cal.gif" onClick="javascript:NewCssCal('expenseentrydate')" style="cursor:pointer"/>					</td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Expense Amount </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">
					<input name="expenseamount" id="expenseamount" style="border: 1px solid #001E6A" value="0.00"  size="20" /></td>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Expense Mode </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">
					<select name="expensemode" id="expensemode" style="width: 130px;">
                        <option value="" selected="selected">SELECT</option>
                        <option value="CHEQUE">CHEQUE</option>
                        <option value="CASH">CASH</option>
                        <option value="ONLINE">ONLINE</option>
                        <option value="CARD">CARD</option>
                        <option value="ADJUSTMENT">ADJUSTMENT</option>
                    </select></td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Cheque Number </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">
					<input name="chequenumber" id="chequenumber" style="border: 1px solid #001E6A" value=""  size="20" /></td>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Bank Name </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="bankname" id="bankname" style="border: 1px solid #001E6A" value=""  size="20" /></td>
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
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">&nbsp;</td>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                      <input type="hidden" name="cbfrmflag2" value="<?php echo $customeranum; ?>">
                      <input type="hidden" name="frmflag1" value="frmflag1">
                      <input name="Submit" type="submit"  value="Save Expense" class="button" style="border: 1px solid #001E6A"/>
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

