<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
date_default_timezone_set('Asia/Calcutta'); 
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');

$searchsuppliername = '';
$suppliername = '';
$cbsuppliername = '';
$cbcustomername = '';
$cbbillnumber = '';
$cbbillstatus = '';
$colorloopcount = '';
$sno = '';
$snocount = '';
$visitcode1 = '';
$total = '';
$looptotalpaidamount = '0.00';
$looptotalpendingamount = '0.00';
$looptotalwriteoffamount = '0.00';
$looptotalcashamount = '0.00';
$looptotalcreditamount = '0.00';
$looptotalcardamount = '0.00';
$looptotalonlineamount = '0.00';
$looptotalchequeamount = '0.00';
$looptotaltdsamount = '0.00';
$looptotalwriteoffamount = '0.00';
$pendingamount = '0.00';
$accountname = '';

if (isset($_REQUEST["accountname"])) { $accountname = $_REQUEST["accountname"]; } else { $accountname = ""; }

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
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	//$cbsuppliername = $_REQUEST['cbsuppliername'];
	//$suppliername = $_REQUEST['cbsuppliername'];
	$paymentreceiveddatefrom = $_REQUEST['ADate1'];
	$paymentreceiveddateto = $_REQUEST['ADate2'];
	$visitcode1 = 10;

}

if (isset($_REQUEST["task"])) { $task = $_REQUEST["task"]; } else { $task = ""; }
//$task = $_REQUEST['task'];
if ($task == 'deleted')
{
	$errmsg = 'Payment Entry Delete Completed.';
}

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//$paymenttype = $_REQUEST['paymenttype'];
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//$billstatus = $_REQUEST['billstatus'];
if ($ADate1 != '' && $ADate2 != '')
{
	$transactiondatefrom = $_REQUEST['ADate1'];
	$transactiondateto = $_REQUEST['ADate2'];
}
else
{
	$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
	$transactiondateto = date('Y-m-d');
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

function cbsuppliername1()
{
	document.cbform1.submit();
}

</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>
<script language="javascript">

function funcPrintReceipt1(varRecAnum)
{
	var varRecAnum = varRecAnum
	//alert (varRecAnum);
	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php //echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	window.open("print_payment_receipt1.php?receiptanum="+varRecAnum+"","OriginalWindow<?php //echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}

function funcDeletePayment1(varPaymentSerialNumber)
{
	var varPaymentSerialNumber = varPaymentSerialNumber;
	var fRet;
	fRet = confirm('Are you sure want to delete this payment entry serial number '+varPaymentSerialNumber+'?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("Payment Entry Delete Completed.");
		//return false;
	}
	if (fRet == false)
	{
		alert ("Payment Entry Delete Not Completed.");
		return false;
	}
	//return false;
}

</script>
</head>

<script src="js/datetimepicker_css.js"></script>

<body>
<table width="1900" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="revenuereportbytype.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr bgcolor="#011E6A">
                      <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Revenue Report By User</strong></td>
                      <!--<td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                      <td bgcolor="#CCCCCC" class="bodytext3" colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" style="border: 1px solid #001E6A" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
					  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input  style="border: 1px solid #001E6A" type="submit" value="Search" name="Submit" />
                          <input name="resetbutton" type="reset" id="resetbutton"  style="border: 1px solid #001E6A" value="Reset" /></td>
                    </tr>
                  </tbody>
                </table>
              </form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="600" 

            align="left" border="0">
          <tbody>
            <tr>
              <td width="5%" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
              <td colspan="4" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" width="5%" 
                bgcolor="#ffffff"><strong></strong></td>
              <td width="25%" align="left" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Cash</strong></div></td>
				<td width="25%" align="left" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Insurance</strong></div></td>
				<td width="25%" align="left" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Direct Credit</strong></div></td>
				<td width="25%" align="left" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Staff</strong></div></td>
				
               
            </tr>
			<?php
			
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$totalcashamount = '0.00';
			$revenueamountfinal = '0.00';
			$billnumberamountfinal = '0.00';
			$averagecostfinal = '0.00';
			
$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{
		  $query2 = "select * from master_paymenttype where recordstatus <> 'deleted'"; 
		  $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		  while ($res2 = mysql_fetch_array($exec2))
		  {
			  $res2auto_number = $res2['auto_number'];
			  $res2paymenttype = $res2['paymenttype'];
			  
			  $query3 = "select sum(transactionamount) as transactionamount1, count(billnumber) as billnumber1 from master_transactionpaynow where paymenttype = '$res2paymenttype' and transactionamount <>'0.00'"; 
			  $exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
			  $res3 = mysql_fetch_array($exec3);
			  $res3transactionamount= $res3['transactionamount1'];
			  $res3billnumber = $res3['billnumber1'];
			  
			  $query4 = "select sum(totalamount) as totalamount1, count(billnumber) as billnumber1 from master_billing where paymenttype = '$res2paymenttype'and totalamount <> '0.00'"; 
			  $exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
			  $res4 = mysql_fetch_array($exec4);
			  $res4totalamount= $res4['totalamount1'];
			  $res4billnumber = $res4['billnumber1'];
			  
			  $query5 = "select sum(transactionamount) as transactionamount1, count(billnumber) as billnumber1 from master_transactionpaylater where paymenttype = '$res2paymenttype' and transactionamount <>'0.00'"; 
			  $exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
			  $res5 = mysql_fetch_array($exec5);
			  $res5totalamount= $res5['transactionamount1'];
			  $res5billnumber = $res5['billnumber1'];
			  
			  echo '<br>'.$revenueamount = $res3transactionamount + $res4totalamount + $res5totalamount;
			  echo '<br>'.$billnumbercount = $res3billnumber + $res4billnumber + $res5billnumber;
			  echo '<br>'.$averagecost = $revenueamount / $billnumbercount;
			  echo '<br>';
			  
			  $revenueamountfinal = $revenueamountfinal + $revenueamount;
			  //$billnumberamountfinal = $billnumberamountfinal + $billnumbercount;
			  //$averagecostfinal = $averagecostfinal + $averagecost;
		 }
		  
		  
		  $snocount = $snocount + 1;
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
           <tr <?php //echo $colorcode; ?>>
              <td class="bodytext31" valign="center" bgcolor="#D3EEB7"  align="left"><strong>Revenue</strong></td>
               <td class="bodytext31" valign="center" bgcolor="#D3EEB7" align="right">
                <div class="bodytext31"><?php echo number_format($revenueamountfinal,2,'.',','); ?></div>              </td>
              <td class="bodytext31" valign="center" bgcolor="#D3EEB7" align="right">
                <div class="bodytext31"><?php //echo number_format($billnumbercount ,2,'.',','); ?></div>              </td>
              <td class="bodytext31" valign="center" bgcolor="#D3EEB7" align="right">
			  <?php //echo number_format($averagecost,2,'.',','); ?></td>
              <td class="bodytext31" valign="center" bgcolor="#D3EEB7" align="right">
			    <div align="right"><?php //echo number_format($onlineamount1,2,'.',','); ?></div></td>
		 </tr>
		 <tr <?php //echo $colorcode; ?>>
              <td class="bodytext31" valign="center" bgcolor="#CBDBFA"  align="left"><strong>Count</strong></td>
               <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="right">
                <div class="bodytext31"><?php //echo number_format($cashamount1,2,'.',','); ?></div>              </td>
              <td class="bodytext31" valign="center" bgcolor="#CBDBFA"  align="right">
                <div class="bodytext31"><?php //echo number_format($cardamount1,2,'.',','); ?></div>              </td>
              <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="right">
			  <?php //echo number_format($chequeamount1,2,'.',','); ?></td>
              <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="right">
			    <div align="right"><?php //echo number_format($onlineamount1,2,'.',','); ?></div></td>
		 </tr>
		 <tr <?php //echo $colorcode; ?>>
              <td class="bodytext31" valign="center" bgcolor ="#D3EEB7" align="left"><strong>Avg Cost</strong></td>
               <td class="bodytext31" valign="center" bgcolor="#D3EEB7" align="right">
                <div class="bodytext31"><?php //echo number_format($cashamount1,2,'.',','); ?></div>              </td>
              <td class="bodytext31" valign="center" bgcolor="#D3EEB7" align="right">
                <div class="bodytext31"><?php //echo number_format($cardamount1,2,'.',','); ?></div>              </td>
              <td class="bodytext31" valign="center" bgcolor="#D3EEB7" align="right">
			  <?php //echo number_format($chequeamount1,2,'.',','); ?></td>
              <td class="bodytext31" valign="center" bgcolor="#D3EEB7" align="right">
			    <div align="right"><?php //echo number_format($onlineamount1,2,'.',','); ?></div></td>
		 </tr>
		<!-- <tr>
		 <td class="bodytext31" valign="center"  align="left">Revenue</td>
		 </tr>-->
			<?php
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
              
               
            </tr>
          </tbody>
        </table></td>
      </tr>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

