<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

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
$nettotal = '0.00';
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
.style3 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
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
<script>
function viewReport()
 {
window.open("<?php echo basename($_SERVER['PHP_SELF']); ?>","OriginalWindowA4",'width=922,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
  }
</script>
<script src="js/datetimepicker_css.js"></script>

<body>
<table width="1900" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="oprevenuereportuser.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr bgcolor="#011E6A">
                      <td colspan="3" bgcolor="#CCCCCC" class="bodytext3"><strong>OP Revenue Report </strong></td>
                      <!--<td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
			  <td bgcolor="#CCCCCC" class="bodytext3"><strong><a href="#" onClick="viewReport();">W</a></strong></td>
                    </tr>
                    <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input  type="submit" value="Search" name="Submit" />
                          <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="400" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="10%" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
              <td colspan="2" bgcolor="#cccccc" class="bodytext31">
              <?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					if (isset($_REQUEST["cbcustomername"])) { $cbcustomername = $_REQUEST["cbcustomername"]; } else { $cbcustomername = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["customername"])) { $customername = $_REQUEST["customername"]; } else { $customername = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
					if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
					$transactiondatefrom = $_REQUEST['ADate1'];
					$transactiondateto = $_REQUEST['ADate2'];
				}	
					?> 			</td>
            </tr>
            
			<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
				?>
			<?php
			
			$query1 = "select sum(billamount) as billamount1 from master_billing where billingdatetime between '$transactiondatefrom' and '$transactiondateto'";
			$exec1 = mysql_query($query1) or die ("Error in query1".mysql_error());
			$res1 = mysql_fetch_array($exec1);
			$res1consultationamount = $res1['billamount1'];
			
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
              <td class="bodytext31" valign="center" bgcolor="#FFFFFF" align="left"><strong>No.</strong></td>
              <td align="left" valign="center" bgcolor="#FFFFFF" class="style3">Head</td>
              <td align="right" valign="center" bgcolor="#FFFFFF" class="style3">Value</td>
              <td width="21%" align="right" valign="center" bgcolor="#E0E0E0" class="style3">&nbsp;</td>
            </tr>
            
            <tr <?php //echo $colorcode; ?>>
              <td class="bodytext31" valign="center" bgcolor="#D3EEB7" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center" bgcolor="#D3EEB7" align="left">
                <div class="bodytext31">Consultation</div>              </td>
               <td align="right" valign="center" bgcolor="#D3EEB7" class="bodytext31"><div class="bodytext31"><?php echo number_format($res1consultationamount,2,'.',','); ?></div></td>
               <td class="bodytext31" valign="center" bgcolor="#E0E0E0" align="right">&nbsp;</td>
           </tr>
		   <?php
			
			$query2 = "select sum(labitemrate) as labitemrate1 from billing_paylaterlab where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec2 = mysql_query($query2) or die ("Error in query2".mysql_error());
			$res2 = mysql_fetch_array($exec2);
			$res2labitemrate = $res2['labitemrate1'];
			
			$query3 = "select sum(labitemrate) as labitemrate1 from billing_paynowlab where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
			$res3 = mysql_fetch_array($exec3);
			$res3labitemrate = $res3['labitemrate1'];
			
			$query14 = "select sum(labitemrate) as labitemrate1 from billing_externallab where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec14 = mysql_query($query14) or die ("Error in query14".mysql_error());
			$res14 = mysql_fetch_array($exec14);
			$res14labitemrate = $res14['labitemrate1'];
			
			$totallabitemrate = $res2labitemrate + $res3labitemrate + $res14labitemrate;
			
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
              <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left">
                <div class="bodytext31">Lab</div>              </td>
               <td align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><div class="bodytext31"><?php echo number_format($totallabitemrate,2,'.',','); ?></div></td>
               <td class="bodytext31" valign="center" bgcolor="#E0E0E0" align="right">&nbsp;</td>
           </tr>
		   <?php
			
			$query4 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_paylaterradiology where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec4 = mysql_query($query4) or die ("Error in query4".mysql_error());
			$res4 = mysql_fetch_array($exec4);
			$res4radiologyitemrate = $res4['radiologyitemrate1'];
			
			$query5 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_paynowradiology where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
			$res5 = mysql_fetch_array($exec5);
			$res5radiologyitemrate = $res5['radiologyitemrate1'];
			
			$query15 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_externalradiology where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec15 = mysql_query($query15) or die ("Error in Query15".mysql_error());
			$res15 = mysql_fetch_array($exec15);
			$res15radiologyitemrate = $res15['radiologyitemrate1'];
			
			$totalradiologyitemrate = $res4radiologyitemrate + $res5radiologyitemrate + $res15radiologyitemrate;
			
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
              <td class="bodytext31" valign="center" bgcolor="#D3EEB7" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center" bgcolor="#D3EEB7" align="left">
                <div class="bodytext31">Radiology</div>              </td>
               <td align="right" valign="center" bgcolor="#D3EEB7" class="bodytext31"><div class="bodytext31"><?php echo number_format($totalradiologyitemrate,2,'.',','); ?></div></td>
               <td class="bodytext31" valign="center" bgcolor="#E0E0E0" align="right">&nbsp;</td>
           </tr>
		   
		   <?php
			
			$query6 = "select sum(servicesitemrate) as servicesitemrate1 from billing_paylaterservices where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec6 = mysql_query($query6) or die ("Error in query6".mysql_error());
			$res6 = mysql_fetch_array($exec6);
			$res6servicesitemrate = $res6['servicesitemrate1'];
			
			$query7 = "select sum(servicesitemrate) as servicesitemrate1 from billing_paynowservices where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
			$res7 = mysql_fetch_array($exec7);
			$res7servicesitemrate = $res7['servicesitemrate1'];
			
			$query16 = "select sum(servicesitemrate) as servicesitemrate1 from billing_externalservices where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec16 = mysql_query($query16) or die ("Error in Query16".mysql_error());
			$res16 = mysql_fetch_array($exec16);
			$res16servicesitemrate = $res16['servicesitemrate1'];
			
			$totalservicesitemrate = $res6servicesitemrate + $res7servicesitemrate + $res16servicesitemrate ;
			
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
              <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left">
                <div class="bodytext31">Service</div>              </td>
               <td align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><div class="bodytext31"><?php echo number_format($totalservicesitemrate,2,'.',','); ?></div></td>
               <td class="bodytext31" valign="center" bgcolor="#E0E0E0" align="right">&nbsp;</td>
           </tr>
		   
		   <?php
			
			$query8 = "select sum(amount) as amount1 from billing_paylaterpharmacy where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec8 = mysql_query($query8) or die ("Error in query8".mysql_error());
			$res8 = mysql_fetch_array($exec8);
			$res8pharmacyitemrate = $res8['amount1'];
			
			$query9 = "select sum(amount) as amount1 from billing_paynowpharmacy where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
			$res9 = mysql_fetch_array($exec9);
			$res9pharmacyitemrate = $res9['amount1'];
			
			$query17 = "select sum(amount) as amount1 from billing_externalpharmacy where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec17 = mysql_query($query17) or die ("Error in Query17".mysql_error());
			$res17 = mysql_fetch_array($exec17);
			$res17pharmacyitemrate = $res17['amount1'];
			
			$totalpharmacyitemrate = $res8pharmacyitemrate + $res9pharmacyitemrate + $res17pharmacyitemrate;
			
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
              <td class="bodytext31" valign="center" bgcolor="#D3EEB7" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center" bgcolor="#D3EEB7" align="left">
                <div class="bodytext31">Pharmacy</div>              </td>
               <td align="right" valign="center" bgcolor="#D3EEB7" class="bodytext31"><div class="bodytext31"><?php echo number_format($totalpharmacyitemrate,2,'.',','); ?></div></td>
               <td class="bodytext31" valign="center" bgcolor="#E0E0E0" align="right">&nbsp;</td>
           </tr>
		   
		   <?php
			
			$query10 = "select sum(referalrate) as referalrate1 from billing_paylaterreferal where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec10 = mysql_query($query10) or die ("Error in query10".mysql_error());
			$res10 = mysql_fetch_array($exec10);
			$res10referalitemrate = $res10['referalrate1'];
			
			$query11 = "select sum(referalrate) as referalrate1 from billing_paynowreferal where billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
			$res11 = mysql_fetch_array($exec11);
			$res11referalitemrate = $res11['referalrate1'];
			
			$totalreferalitemrate = $res10referalitemrate + $res11referalitemrate;
			
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
              <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center" bgcolor="#CBDBFA" align="left">
                <div class="bodytext31">Referral</div>              </td>
               <td align="right" valign="center" bgcolor="#CBDBFA" class="bodytext31"><div class="bodytext31"><?php echo number_format($totalreferalitemrate,2,'.',','); ?></div></td>
			   <td align="right" valign="center" bgcolor="#E0E0E0" class="bodytext31">&nbsp;</td>
           </tr>
		   <?php
			$nettotal = $res1consultationamount + $totallabitemrate + $totalradiologyitemrate + $totalservicesitemrate + $totalpharmacyitemrate + $totalreferalitemrate;
			?>
		   <?php 
		   }
		   ?>
            <tr>
              <td colspan="2"  class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong>Net Revenue:</strong></td>
              <td align="right" valign="center" 
                bgcolor="#cccccc" class="bodytext31"><strong><?php echo number_format($nettotal,2,'.',','); ?></strong></td>
				<?php if($nettotal != 0.00) { ?>
				<td rowspan="2" align="right" valign="center" bgcolor="#E0E0E0" class="bodytext31"><a target="_blank" href="print_oprevenuereport.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&user=<?php echo $res21username; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></td>
			    <?php } ?>
			   </tr>
          </tbody>
        </table></td>
      </tr>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

