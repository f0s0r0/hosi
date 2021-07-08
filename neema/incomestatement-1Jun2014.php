<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
date_default_timezone_set('Asia/Calcutta'); 
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$paymentreceiveddateto1 = "2014-01-01";
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$total = '0.00';
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$range = "";
$sno = "";
$colorloopcount1="";
$grandtotal = '';
$grandtotal1 = "0.00";
$costofgoodssold = "0.00";
//This include updatation takes too long to load for hunge items database.
include ("autocompletebuild_account2.php");

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

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
		
		
              <form name="cbform1" method="post" action="incomestatement.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#CCCCCC" class="bodytext3"><strong> Income Statement</strong></td>
              </tr>
            <!--<tr>
              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
			  <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Payment Entry" /> 
                *To Print Other Receipts Please Go To Menu:	Reports	-&gt; Payments Given 
				</td>
              </tr>-->
            
		   
			  <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $paymentreceiveddateto1; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" style="border: 1px solid #001E6A" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>	
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="border: 1px solid #001E6A; text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  style="border: 1px solid #001E6A" type="submit" onClick="return funcAccount();" value="Search" name="Submit" />
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" 
            align="left" border="0">
          <tbody>
            		
           
		
			<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			$ipfinaldiscount = '';
			$ipfinaldiscountcreditapproved = '';
		  $query2 = "select sum(consultation) as consultationamount from billing_consultation where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		  $res2 = mysql_fetch_array($exec2);
		  $consultationamount = $res2['consultationamount'];
		  
		  /*$query15 = "select sum(totalamount) as consultationamount from billing_paylaterconsultation where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec15= mysql_query($query15) or die ("Error in Query2".mysql_error());
		  $res15 = mysql_fetch_array($exec15);
		  echo $consultationamountpaylater = $res15['consultationamount'];
	*/
		  
		  $query3 = "select sum(totalamount) as paynowamount from billing_paynow where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec3 = mysql_query($query3) or die ("Error in Query2".mysql_error());
		  $res3 = mysql_fetch_array($exec3);
		  $paynowamount = $res3['paynowamount'];
		  
		 	  
		  $query10 = "select sum(totalamount) as paylateramount from billing_paylater where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec10 = mysql_query($query10) or die ("Error in Query2".mysql_error());
		  $res10 = mysql_fetch_array($exec10);
		  $paylateramount = $res10['paylateramount'];
		  
		  $query61 = "select sum(totalamount) as externalamount from billing_external where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec61 = mysql_query($query61) or die ("Error in Query2".mysql_error());
		  $res61 = mysql_fetch_array($exec61);
		  $externalamount = $res61['externalamount'];

		  
		  $query8 = "select sum(transactionamount) as expenseamount from expensesub_details where transactiondate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec8 = mysql_query($query8) or die ("Error in Query2".mysql_error());
		  $res8 = mysql_fetch_array($exec8);
		  $expenseamount = $res8['expenseamount'];
		  
		  $query9 = "select * from master_company";
		  $exec9 = mysql_query($query9) or die(mysql_error());
		  $res9 = mysql_fetch_array($exec9);
		  $incometax = $res9['incometax'];
		  
		  $query16 = "select sum(transactionamount) as receiptamount from receiptsub_details where transactiondate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec16 = mysql_query($query16) or die ("Error in Query2".mysql_error());
		  $res16 = mysql_fetch_array($exec16);
		  $receiptamount = $res16['receiptamount'];
		  
		  $query17 = "select sum(consultation) as consultationrefundamount from refund_consultation where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec17 = mysql_query($query17) or die ("Error in Query2".mysql_error());
		  $res17 = mysql_fetch_array($exec17);
		  $consultationrefundamount = $res17['consultationrefundamount'];
		  
		  $query18 = "select sum(labitemrate) as paynowlabrefundamount from refund_paynowlab where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec18 = mysql_query($query18) or die ("Error in Query2".mysql_error());
		  $res18 = mysql_fetch_array($exec18);
		  $paynowlabrefundamount = $res18['paynowlabrefundamount'];
		  
   	      $query19 = "select sum(radiologyitemrate) as paynowradiologyrefundamount from refund_paynowradiology where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec19 = mysql_query($query19) or die ("Error in Query2".mysql_error());
		  $res19 = mysql_fetch_array($exec19);
		  $paynowradiologyrefundamount = $res19['paynowradiologyrefundamount'];
		  
		  $query20 = "select sum(servicesitemrate) as paynowservicesrefundamount from refund_paynowservices where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec20 = mysql_query($query20) or die ("Error in Query2".mysql_error());
		  $res20 = mysql_fetch_array($exec20);
		  $paynowservicesrefundamount = $res20['paynowservicesrefundamount'];
		  
    	  $query20 = "select sum(amount) as paynowpharmacyrefundamount from refund_paynowpharmacy where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec20 = mysql_query($query20) or die ("Error in Query2".mysql_error());
		  $res20 = mysql_fetch_array($exec20);
		  $paynowpharmacyrefundamount = $res20['paynowpharmacyrefundamount'];
		  
		  $query21 = "select sum(referalrate) as paynowreferalrefundamount from refund_paynowreferal where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec21 = mysql_query($query21) or die ("Error in Query2".mysql_error());
		  $res21 = mysql_fetch_array($exec21);
		  $paynowreferalrefundamount = $res21['paynowreferalrefundamount'];

		  $totalrefundpaynow = $paynowlabrefundamount + $paynowradiologyrefundamount + $paynowservicesrefundamount + $paynowpharmacyrefundamount + $paynowreferalrefundamount;
		
		  $query22 = "select sum(totalamount) as paylaterrefundamount from refund_paylater where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec22 = mysql_query($query22) or die ("Error in Query2".mysql_error());
		  $res22 = mysql_fetch_array($exec22);
		  $paylaterrefundamount = $res22['paylaterrefundamount'];
		  
		   $query32 = "select sum(labitemrate) as ipfinallabamount from billing_iplab where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec32 = mysql_query($query32) or die ("Error in Query32".mysql_error());
		  $res32 = mysql_fetch_array($exec32);
		  $ipfinallabamount = $res32['ipfinallabamount'];
		  
   	      $query33 = "select sum(radiologyitemrate) as ipfinalradiologyamount from billing_ipradiology where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec33 = mysql_query($query33) or die ("Error in Query33".mysql_error());
		  $res33 = mysql_fetch_array($exec33);
		  $ipfinalradiologyamount = $res33['ipfinalradiologyamount'];
		  
		  $query34 = "select sum(servicesitemrate) as ipfinalservicesamount from billing_ipservices where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec34 = mysql_query($query34) or die ("Error in Query34".mysql_error());
		  $res34 = mysql_fetch_array($exec34);
		  $ipfinalservicesamount = $res34['ipfinalservicesamount'];
		  
    	  $query35 = "select sum(amount) as ipfinalpharmacyamount from billing_ippharmacy where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec35 = mysql_query($query35) or die ("Error in Query35".mysql_error());
		  $res35 = mysql_fetch_array($exec35);
		  $ipfinalpharmacyamount = $res35['ipfinalpharmacyamount'];
		  
		  $query36 = "select sum(amount) as ipfinalprivatedoctoramount from billing_ipprivatedoctor where recorddate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec36 = mysql_query($query36) or die ("Error in Query36".mysql_error());
		  $res36 = mysql_fetch_array($exec36);
		  $ipfinalprivatedoctoramount = $res36['ipfinalprivatedoctoramount'];
		  
		  $query37 = "select sum(amount) as ipfinalotbillingamount from billing_ipotbilling where recorddate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec37 = mysql_query($query37) or die ("Error in Query37".mysql_error());
		  $res37 = mysql_fetch_array($exec37);
		  $ipfinalotbillingamount = $res37['ipfinalotbillingamount'];


		  $query38 = "select sum(amount) as ipfinalmiscbilling from billing_ipmiscbilling where recorddate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec38 = mysql_query($query38) or die ("Error in Query38".mysql_error());
		  $res38 = mysql_fetch_array($exec38);
		  $ipfinalmiscbilling = $res38['ipfinalmiscbilling'];

  		  $query39 = "select sum(amount) as ipfinalbedcharges from billing_ipbedcharges where recorddate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec39 = mysql_query($query39) or die ("Error in Query39".mysql_error());
		  $res39 = mysql_fetch_array($exec39);
		 $ipfinalbedcharges = $res39['ipfinalbedcharges'];

 		  $query40 = "select sum(amount) as ipfinalambulance from billing_ipambulance where recorddate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec40= mysql_query($query40) or die ("Error in Query40".mysql_error());
		  $res40 = mysql_fetch_array($exec40);
		 $ipfinalambulance = $res40['ipfinalambulance'];
		  
		  $query41 = "select sum(amount) as ipfinalnhif from billing_ipnhif where recorddate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec41= mysql_query($query41) or die ("Error in Query41".mysql_error());
		  $res41 = mysql_fetch_array($exec41);
		  $ipfinalnhif = $res41['ipfinalnhif'];


		  $query43 = "select sum(amount) as ipfinaladmissioncharge from billing_ipadmissioncharge where recorddate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec43= mysql_query($query43) or die ("Error in Query43".mysql_error());
		  $res43 = mysql_fetch_array($exec43);
		 $ipfinaladmissioncharge = $res43['ipfinaladmissioncharge'];
		  
		  if($ipfinaladmissioncharge != '')
		  {
		  
		  $query42 = "select sum(discount) as ipfinaldiscount,sum(deposit) as  ipfinaldeposit from billing_ip where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec42= mysql_query($query42) or die ("Error in Query42".mysql_error());
		  $res42 = mysql_fetch_array($exec42);
		  $ipfinaldiscount = $res42['ipfinaldiscount'];
		  $ipfinaldeposit = $res42['ipfinaldeposit'];
		  
		  $query421 = "select sum(discount) as ipfinaldiscount,sum(deposit) as  ipfinaldeposit from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec421= mysql_query($query421) or die ("Error in Query42".mysql_error());
		  $res421 = mysql_fetch_array($exec421);
		  $ipfinaldiscountcreditapproved = $res421['ipfinaldiscount'];
		  $ipfinaldepositcreditapproved = $res421['ipfinaldeposit'];
		  }

				
		$totalipamount = $ipfinallabamount  + $ipfinaladmissioncharge  + $ipfinalambulance + $ipfinalbedcharges + $ipfinalmiscbilling + $ipfinalotbillingamount +  $ipfinalpharmacyamount + $ipfinalservicesamount +  $ipfinalradiologyamount - $ipfinaldiscount - $ipfinaldiscountcreditapproved;


		
			include("costofgoodssoldcalculation.php");
		 
		  $totalrevenue = $consultationamount + $paynowamount + $paylateramount + $totalipamount + $externalamount;
		  $totalrevenue = $totalrevenue - $consultationrefundamount - $totalrefundpaynow + $paylaterrefundamount;
		  $totalpaylaterpharmrefundamount = 0;
		  $query23 = "select * from pharmacysalesreturn_details where billstatus = 'completed' and entrydate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec23 = mysql_query($query23) or die ("Error in Query2".mysql_error());
		  while($res23 = mysql_fetch_array($exec23))
		  {
		  $paylaterpharmrefundpatientcode = $res23['patientcode'];
		  
		  $query231 = "select * from master_customer where customercode = '$paylaterpharmrefundpatientcode'";
		  $exec231 = mysql_query($query231) or die ("Error in Query2".mysql_error());
		  $res231 = mysql_fetch_array($exec231);
		  $patientrefundtype = $res231['billtype'];
		  
		  if($patientrefundtype == 'PAY LATER')
		  {
		  $paylaterpharmrefundamount = $res23['totalamount'];
		  $totalpaylaterpharmrefundamount = $totalpaylaterpharmrefundamount + $paylaterpharmrefundamount;
		  }
		  }
	$totalrevenue = $totalrevenue - $totalpaylaterpharmrefundamount;

		  $costofgoodssold = $grandtotalcogs;
		  if($costofgoodssold == '')
		  {
		  $costofgoodssold = "0.00";
		  }
		  
		  $query13 = "select sum(totalamount) as totalreturnamount from purchasereturn_details where entrydate between '$ADate1' and '$ADate2'";
		  $exec13 = mysql_query($query13) or die(mysql_error());
		  $res13 = mysql_fetch_array($exec13);
		  $totalreturnamount = $res13['totalreturnamount'];
		  
		  $costofgoodssold = $costofgoodssold + $totalreturnamount;
		  $grossprofit = ($totalrevenue+$receiptamount) - $costofgoodssold;
		  $incomefromoperations = $grossprofit - $expenseamount;
		  $nonoperatingitems = 0;
		  $incomebeforetaxes = $incomefromoperations - $nonoperatingitems;
		  $taxamount = $incometax * $incomebeforetaxes;
		  $taxamount = $taxamount/100;
		  $netincome = $incomebeforetaxes - $taxamount;
				?>
			
           <tr bgcolor="#CBDBFA">
              <td width="249"  align="left" valign="center" class="bodytext31"><strong>Sales Revenue</strong></td>
              <td width="71"  align="right" valign="center" class="bodytext31"><?php echo number_format($totalrevenue,2,'.',','); ?> </td>
           </tr>
		   <tr bgcolor="#D3EEB7">
              <td width="249"  align="left" valign="center" class="bodytext31"><strong>Other Incomes</strong></td>
              <td width="71"  align="right" valign="center" class="bodytext31"><?php echo number_format($receiptamount,2,'.',','); ?> </td>
           </tr>
		  <tr bgcolor="#CBDBFA">
              <td class="bodytext31" valign="center"  align="left"><strong>Cost of Goods Sold</strong></td>
              <td class="bodytext31" valign="right"  align="right"><?php echo number_format($costofgoodssold,2,'.',','); ?> </td>
           </tr>
			<tr bgcolor="#D3EEB7">
              <td class="bodytext31" valign="center"  align="left"><strong>Gross Profit</strong></td>
              <td class="bodytext31" valign="right"  align="right"><?php echo number_format($grossprofit,2,'.',','); ?> </td>
           </tr>
		   <tr bgcolor="#CBDBFA">
              <td class="bodytext31" valign="center"  align="left"><strong>Operating Expense</strong></td>
              <td class="bodytext31" valign="right"  align="right"><?php echo number_format($expenseamount,2,'.',','); ?> </td>
           </tr>
		    <tr bgcolor="#D3EEB7">
              <td class="bodytext31" valign="center"  align="left"><strong>Income from Operations</strong></td>
              <td class="bodytext31" valign="right"  align="right"><?php echo number_format($incomefromoperations,2,'.',','); ?> </td>
           </tr>
		   <tr bgcolor="#CBDBFA">
              <td class="bodytext31" valign="center"  align="left"><strong>Non Operating Items</strong></td>
              <td class="bodytext31" valign="right"  align="right"><?php echo number_format($nonoperatingitems,2,'.',','); ?> </td>
           </tr>
		    <tr bgcolor="#D3EEB7">
              <td class="bodytext31" valign="center"  align="left"><strong>Income Before Taxes</strong></td>
              <td class="bodytext31" valign="right"  align="right"><?php echo number_format($incomebeforetaxes,2,'.',','); ?> </td>
           </tr>
		   <tr bgcolor="#CBDBFA">
              <td class="bodytext31" valign="center"  align="left"><strong>Income Taxes</strong></td>
              <td class="bodytext31" valign="right"  align="right"><?php echo number_format($taxamount,2,'.',','); ?> </td>
           </tr>
		   <tr bgcolor="#D3EEB7">
              <td class="bodytext31" valign="center"  align="left"><strong>Net Income</strong></td>
              <td class="bodytext31" valign="right"  align="right"><?php echo number_format($netincome,2,'.',','); ?> </td>
           </tr>
   		  </tbody>
        </table></td>
      </tr>
		<?php
			}
			?>
         
</table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
