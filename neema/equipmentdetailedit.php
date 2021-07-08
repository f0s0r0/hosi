<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
//include ("autocompletebuild_expenses.php");
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
if (isset($_REQUEST["anum"])) {  $expensesanum = $_REQUEST["anum"]; } else { $expensesanum = ""; }
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag1 = $_REQUEST['frmflag1'];
if ($frmflag1 == 'frmflag1')
{ 
	$vehiclenumber = $_REQUEST["vehiclenumber"];
	$description = $_REQUEST["description"];
	$expensesanum = $_REQUEST['expensesanum'];
		 $query1 = "update equipment_details  set vehiclenumber = '$vehiclenumber',description= '$description' where autonumber = '$expensesanum'";
		
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		
		header ("location:equipmentdetail.php");
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
$paynowbillprefix = 'AOP-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from openingbalanceaccount order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='AOP-'.'1';
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
	
	
	$billnumbercode = 'AOP-' .$maxanum;
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
	/*if (document.getElementById("paynowreferalcode").value == "")
	{
		alert ("Please Select an Account");
		document.getElementById("paynowreferalcode").focus();
		return false;
	}*/
	
	if (document.getElementById("vehiclenumber").value == "")
	{
		alert ("Please Enter Vehicle Number");
		document.getElementById("vehiclenumber").focus();
		return false;
	}
	if (document.getElementById("description").value == "")
	{
		alert ("Please Enter Vehicle Description.");
		document.getElementById("description").focus();
		return false;
	}/*
	if (isNaN(document.getElementById("expenseamount").value))
	{
		alert ("Expense Amount Can Only Be Numbers.");
		document.getElementById("expenseamount").focus();
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

	*/
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
	window.open("popup_openingbalacesearch.php?callfrom="+varCallFrom,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}
function coa1()

{
	var oTextbox11 = new AutoSuggestControl11(document.getElementById("account"), new StateSuggestions11()); 
}
function funcexpiry()
{
	<?php $date = mktime(0,0,0,date("m"),date("d")-1,date("Y")); 
	$currentdate = date("Y/m/d",$date);
	?>
	var currentdate = "<?php echo $currentdate; ?>";
	var expirydate = document.getElementById("renewabledate").value; 
	var currentdate = Date.parse(currentdate);
	var expirydate = Date.parse(expirydate);
	
	
}
</script>


<script type="text/javascript" src="js/nmpurchaseinsertitem.js"></script>
<!--<script type="text/javascript" src="js/autoitemsearch2purchase.js"></script>-->
<script type="text/javascript" src="js/autosuggest1expenseaccount.js"></script>
<script type="text/javascript" src="js/autocomplete_13accounts.js"></script>
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<?php

if (isset($_REQUEST["anum"])) { $expensesanum = $_REQUEST["anum"]; } else { $expensesanum = ""; }
if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }


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

<body onLoad="coa1()">
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
        
		
		<?php
			$query2 = "select * from equipment_details  where autonumber = '$expensesanum'";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	$res2 = mysql_num_rows($exec2);
	$userrow=mysql_fetch_array($exec2);	 
		 
	  $vehiclenumber =  $userrow["vehiclenumber"];
	  $description = $userrow["description"];
	
	 
		?>
		
				<form name="form1" id="form1" method="post" action="equipmentdetailedit.php" onSubmit="return paymententry1process1()">
			  <table width="400" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                <tbody>
                  <tr bgcolor="#011E6A">
                    <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Edit EquipmentDetail </strong></td>
                    <!--<td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                    <td bgcolor="#CCCCCC" class="bodytext3" colspan="2">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="4" align="left" valign="middle"  
					bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?></td>
                  </tr>
                  <!--<tr>
                    <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext32">
                    <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Expense Entry" />
*To Print Other Receipts Please Go To Menu:	Reports	-&gt; Expense Report </span></td>
                  </tr>-->
                  <tr>
                    <td colspan="2" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
						 <input type="hidden" name="paynowlabtype5" id="paynowreferaltype" size="10"/>
						 	<input type="hidden" name="cashcoa" value="<?php echo $cashcoa; ?>">
				<input type="hidden" name="chequecoa" value="<?php echo $chequecoa; ?>">
				<input type="hidden" name="mpesacoa" value="<?php echo $mpesacoa; ?>">
				<input type="hidden" name="cardcoa" value="<?php echo $cardcoa; ?>">
				<input type="hidden" name="onlinecoa" value="<?php echo $onlinecoa; ?>">
	
						 <input type="hidden" name="paynowlabcode5" id="paynowreferalcode" size="10"/></td>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><b id="balamount" style="display:none"></b></td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"></td>
                  </tr>
                  <tr>
                         <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Vehicle Number</strong></td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="vehiclenumber" id="vehiclenumber"  style="border: 1px solid #001E6A" readonly value="<?php echo  $vehiclenumber ?>"    size="38"/></td>
                    
                              <td align="left" valign="top"  bgcolor="#FFFFFF"></td>
                                         <td align="left" valign="top"  bgcolor="#FFFFFF"></td>
            </tr>
            <tr>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Description</strong></td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">
                 <textarea rows="4" cols="40" style="resize: none" 
              name="description" id="description" ><?php echo $description; ?></textarea>
					                    <td align="left" valign="top"  bgcolor="#FFFFFF">
</td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">
</td>
										</td>  <td>&nbsp;</td> <td>&nbsp;</td>&nbsp;</td>
                  
                  </tr>
                   
                         
                   
					
                 
                   
                
                                    
                  <!--<tr>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Cheque Number </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">
					<input name="chequenumber" id="chequenumber" style="border: 1px solid #001E6A" value=""  size="20" /></td>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Bank Name </td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="bankname" id="bankname" style="border: 1px solid #001E6A" value=""  size="20" /></td>
                  </tr>-->
                  <!--<tr>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">
										  </td>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Remarks</td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="remarks" id="remarks" style="border: 1px solid #001E6A" value=""  size="20" /></td>
                  </tr>-->
                  <tr>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF">&nbsp;</td>
                    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                    <td align="left" valign="top"  bgcolor="#FFFFFF"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                      <input type="hidden" name="cbfrmflag2" value="<?php echo $customeranum; ?>">
                      <input type="hidden" name="frmflag1" value="frmflag1">
                        
                         <input type="hidden" name="expensesanum" value="<?php echo $expensesanum; ?>">
                         <tr>
                         <td>
                      <input name="Submit" type="submit"  value="Update" class="button" style="border: 1px solid #001E6A"/>
                      </td>
                      </tr>
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

