<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

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
//This include updatation takes too long to load for hunge items database.
include ("autocompletebuild_account2.php");

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["anum"])) { $anum = $_REQUEST["anum"]; } else { $anum = ""; }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["locationcode"])) { $locationcode = $_REQUEST["locationcode"]; } else { $locationcode = ""; }
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];
$locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';
$query31 = "select st.shiftstarttime,st.shiftouttime,st.username from shift_tracking as st LEFT JOIN master_employeelocation as mel ON st.username = mel.username where mel.locationcode='$locationcode' and st.auto_number='$anum'";
$exe31 = mysql_query($query31) or die("Error in Query31".mysql_error());
$res31 = mysql_fetch_array($exe31);
 $starttime = $res31['shiftstarttime'];
$outtime = $res31['shiftouttime'];
$user = $res31['username'];

$query32 = "select * from master_employee where username='$user'";
$exec32 = mysql_query($query32) or die(mysql_error());
$res32 = mysql_fetch_array($exec32);
$employeename = $res32['employeename'];
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
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="3">
		
		
              <form name="cbform1" method="post" action="cashflowstatement.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            
            <!--<tr>
              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
			  <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Payment Entry" /> 
                *To Print Other Receipts Please Go To Menu:	Reports	-&gt; Payments Given 
				</td>
              </tr>-->
          </tbody>
        </table>
		</form>		</td>
      </tr>
	  <tr>
        <td align="center" valign="center" class="bodytext31">&nbsp;</td>
		<td align="center" valign="center" class="bodytext31">&nbsp;</td>
		<td align="left" valign="center" class="bodytext31"><ins><strong><?php echo $employeename; ?> </strong></ins></td>
      </tr>
      <tr>
        <td align="center" valign="center" class="bodytext31">&nbsp;</td>
		<td align="center" valign="center" class="bodytext31">&nbsp;</td>
		<td align="left" valign="center" class="bodytext31"><ins><strong> Shift Report between <?php echo $starttime; ?> and <?php echo $outtime; ?> for Shift ID: <?php echo $anum; ?></strong></ins></td>
      </tr>
	  <tr>
	  <td>&nbsp;</td>
	  </tr>
       <tr>
        <td colspan="3"><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" 
            align="left" border="0">
          <tbody>
		  <tr>
		  <td colspan ="9" align="center" valign="center" class="bodytext31"><strong>Voucher Transactions</strong></td>
		  <td colspan ="9" align="center" valign="center" class="bodytext31"><strong>Refund Voucher Transactions</strong></td>
		   <td width="1" align="center" valign="center" class="bodytext31">&nbsp;</td>
		   <td class="bodytext31" valign="center" bgcolor="#E0E0E0" align="right"> 
                 <a target="_blank" href="printshiftwisereport.php?anum=<?php echo $anum;?>&& locationcode=<?php echo $locationcode;?>"> <img src="images/pdfdownload.jpg" width="30" height="30"></a>           </td>	
		  </tr>
            		<?php
		
			
		  $query48 = "select * from paymentmodecredit where billdatetime between '$starttime' and '$outtime' order by auto_number desc";
		  $exec48 = mysql_query($query48) or die ("Error in Query2".mysql_error());
		  $num48 = mysql_num_rows($exec48);
		  
	      $query49 = "select * from paymentmodedebit where billdatetime between '$starttime' and '$outtime' order by auto_number desc";
		  $exec49 = mysql_query($query49) or die ("Error in Query2".mysql_error());
		  $num49 = mysql_num_rows($exec49);
	
		
		  
		  if($num48 > $num49)
		  {
		  $rowspancount = $num48;
		  }
		  else
		  {
		  $rowspancount = $num49;
		  }
		  $rowspancount;
		 
		  ?>
            <tr>
              <td width="37"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
              <td width="76" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>
				  <td width="82" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bill </strong></div></td>
              <td width="220" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Description </strong></td>
              <td width="102" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Cash</strong></td>
				<td width="47" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Card</strong></td>
		 <td width="51" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Cheque</strong></td>
		 <td width="47" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Mpesa</strong></td>
				<td width="47" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Online</strong></td>
		
				<td colspan="2" rowspan="1000"  align="left" valign="top" bgcolor="#E0E0E0" >
			
				  <table width="649" id="AutoNumber3" style="BORDER-COLLAPSE: collapse; margin-top:-3px;" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" 
            align="left" border="0">
				  <tr>
				  <td width="51"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
              <td width="66" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>
				 <td width="64" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bill </strong></div></td>
              <td width="193" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Description </strong></td>
            <td width="54" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Cash</strong></td>
				<td width="55" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Card</strong></td>
		 <td width="55" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Cheque</strong></td>
		 <td width="47" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Mpesa</strong></td>
				<td width="47" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Online</strong></td>		
				  </tr>
				<?php
			$colorcode1 = '';
			$totalcashamount = 0;
			$totalcardamount = 0;
			$totalchequeamount = 0;
			$totalmpesaamount = 0;
			$totalonlineamount = 0;
			
		  $query28 = "select * from paymentmodecredit where  billdatetime between '$starttime' and '$outtime' and username = '$user' order by auto_number desc";
		  $exec28 = mysql_query($query28) or die ("Error in Query2".mysql_error());
		
		
		  while ($res28= mysql_fetch_array($exec28))
		  {
     	  $res2transactiondate8 = $res28['billdate'];
		  $res2billnumber8 = $res28['billnumber'];
		  $res2accountname = $res28['accountname'];
		  $patientcode = $res28['patientcode'];
		  $patientname = $res28['patientname'];
		  $patientvisitcode = $res28['patientvisitcode'];
		  
		  $cashamount28 = $res28['cash']; 
		  $cardamount28 = $res28['card'];
		  $chequeamount28 = $res28['cheque'];
		  $onlineamount28 = $res28['online'];
		  $mpesaamount28 = $res28['mpesa'];
		  $cashcoa =  $res28['cashcoa'];
		  $cardcoa =  $res28['cardcoa'];
		  $chequecoa =  $res28['chequecoa'];
		  $onlinecoa =  $res28['onlinecoa'];
		  $mpesacoa =  $res28['mpesacoa'];
		  $source = $res28['source'];
		  
		  	   if($source == 'expenseentry')
		   {
		   $patientname=$res2accountname;
		   $patientvisitcode='Expense';
		   }
		  
		  if($res2accountname == '')
		  {
		  $query213 = "select * from master_accountname where id='$cashcoa' or id='$cardcoa' or id='$chequecoa' or id='$onlinecoa' or id='$mpesacoa'";
		  $exec213 = mysql_query($query213) or die(mysql_error());
		  $res213 = mysql_fetch_array($exec213);
		  $accountssub = $res213['accountssub'];
		  
		  $query214 = "select * from master_accountssub where auto_number='$accountssub'";
		  $exec214 = mysql_query($query214) or die(mysql_error());
		  $res214 = mysql_fetch_array($exec214);
		  $accountssubname = $res214['accountssub'];
		  $res2accountname = $accountssubname;
		  }
		   $totalamount38 = $cashamount28 + $cardamount28 + $chequeamount28 + $onlineamount28 + $mpesaamount28;
		  $sno = $sno + 1;
		  $totalcashamount = $totalcashamount + $cashamount28;
		  $totalcardamount = $totalcardamount + $cardamount28;
		  $totalchequeamount = $totalchequeamount + $chequeamount28;
		  $totalmpesaamount = $totalmpesaamount + $mpesaamount28;
		  $totalonlineamount = $totalonlineamount + $onlineamount28;
		  
		  $colorloopcount1 = $colorloopcount1 + 1;
			$showcolor1 = ($colorloopcount1 & 1); 
			if ($showcolor1 == 0)
			{
				//echo "if";
				$colorcode1 = 'bgcolor="#D3EEB7"';
			}
			else
			{
				//echo "else";
				$colorcode1 = 'bgcolor="#CBDBFA"';
			}
			$grandtotal1 = $grandtotal1 + $totalamount38;
		  ?>
		  <tr <?php echo $colorcode1; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $sno; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate8; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber8; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $patientname; ?>(<?php echo $patientvisitcode; ?>) </div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($cashamount28,2,'.',','); ?></td>
			  <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($cardamount28,2,'.',','); ?></td>
			   <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($chequeamount28,2,'.',','); ?></td>
			   <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($mpesaamount28,2,'.',','); ?></td>
			  <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($onlineamount28,2,'.',','); ?></td>
           </tr>
		   <?php
			}
			
			?>
				  <tr>
			 <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
				 <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
			 <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
			 <td class="bodytext31" valign="center"  align="right"><strong>Total</strong></td>
			 <td class="bodytext31" valign="center"  align="right"> <strong><?php echo number_format($totalcashamount,2,'.',','); ?></strong></td>
			 <td class="bodytext31" valign="center"  align="right"> <strong><?php echo number_format($totalcardamount,2,'.',','); ?></strong></td>
			 <td class="bodytext31" valign="center"  align="right"> <strong><?php echo number_format($totalchequeamount,2,'.',','); ?></strong></td>
			 <td class="bodytext31" valign="center"  align="right"> <strong><?php echo number_format($totalmpesaamount,2,'.',','); ?></strong></td>
			 <td class="bodytext31" valign="center"  align="right"> <strong><?php echo number_format($totalonlineamount,2,'.',','); ?></strong></td>
			</tr>
				  </table>				</td>
                </tr>
				
			
	
			
			<?php
			$totalcashamount1 = 0;
			$totalcardamount1 = 0;
			$totalchequeamount1 = 0;
			$totalmpesaamount1 = 0;
			$totalonlineamount1 = 0;
			
		  $query2 = "select * from paymentmodedebit where billdatetime between '$starttime' and '$outtime' and username = '$user' order by auto_number desc";
		  $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		   while ($res2 = mysql_fetch_array($exec2))
		  {
     	  $res2transactiondate = $res2['billdate'];
		  $res2billnumber = $res2['billnumber'];
		  $patientcode = $res2['patientcode'];
		  $patientname = $res2['patientname'];
		  $patientvisitcode = $res2['patientvisitcode'];
		  $source = $res2['source'];
		  if($source == 'advancedeposit')
		  {
		  $patientvisitcode = $patientcode;
		  }
		  if($patientvisitcode == 'walkinvis')
		  {
		  $patientvisitcode = 'External';
		  }
		  $cashamount2 = $res2['cash'];
		  $cashcoa =  $res2['cashcoa'];
		  $cardamount2 = $res2['card'];
		  $cardcoa =  $res2['cardcoa'];
		  $chequeamount2 = $res2['cheque'];
		  $chequecoa =  $res2['chequecoa'];
		  $onlineamount2 = $res2['online'];
		  $onlinecoa =  $res2['onlinecoa'];
		  $mpesaamount2 = $res2['mpesa'];
		  $mpesacoa =  $res2['mpesacoa'];
		   $source = $res2['source'];
		   if($source == 'ipfinalinvoice')
		   {
			$query88 = mysql_fetch_array(mysql_query("select sum(returnbalance) as returnbalance from master_transactionip where billnumber = '$res2billnumber'"));
			$returnbalance = $query88['returnbalance'];
			$cashamount2 = $cashamount2 + $returnbalance;
		   }
		   if($source == 'receiptentry')
		   {
		   $query51= "select * from receiptsub_details where docnumber='$res2billnumber'";
		   $exec51=mysql_query($query51) or die(mysql_error());
		   $res51=mysql_fetch_array($exec51);
		   $receiptcoa = $res51['receiptcoa'];
		   
		    $query511= "select * from master_accountname where id='$receiptcoa'";
		   $exec511=mysql_query($query511) or die(mysql_error());
		   $res511=mysql_fetch_array($exec511);
		   $receiptname = $res511['accountname'];
		   
		   $patientname=$receiptname;
		   $patientvisitcode='Receipt';
		   }
		   
		  $query21 = "select * from master_accountname where id='$cashcoa' or id='$cardcoa' or id='$chequecoa' or id='$onlinecoa' or id='$mpesacoa'";
		  $exec21 = mysql_query($query21) or die(mysql_error());
		  $res21 = mysql_fetch_array($exec21);
		  $accountssub = $res21['accountssub'];
		  
		  $query212 = "select * from master_accountssub where auto_number='$accountssub'";
		  $exec212 = mysql_query($query212) or die(mysql_error());
		  $res212 = mysql_fetch_array($exec212);
		  $accountssubname = $res212['accountssub'];
		  
		   $totalamount3 = $cashamount2 + $cardamount2 + $chequeamount2 + $onlineamount2 + $mpesaamount2;
		
		  $snocount = $snocount + 1;
		  
		  $totalcashamount1 = $totalcashamount1 + $cashamount2;
		  $totalcardamount1 = $totalcardamount1 + $cardamount2;
		  $totalchequeamount1 = $totalchequeamount1 + $chequeamount2;
		  $totalmpesaamount1 = $totalmpesaamount1 + $mpesaamount2;
		  $totalonlineamount1 = $totalonlineamount1 + $onlineamount2;
				
			//echo $cashamount;
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
			$grandtotal = $grandtotal + $totalamount3;
	
			?>
			
         <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $patientname; ?>(<?php echo $patientvisitcode; ?>) </div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($cashamount2,2,'.',','); ?></td>
			  <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($cardamount2,2,'.',','); ?></td>
			   <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($chequeamount2,2,'.',','); ?></td>
			   <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($mpesaamount2,2,'.',','); ?></td>
			  <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($onlineamount2,2,'.',','); ?></td>
         </tr>
			<?php
			}
			$grandtotal = $grandtotal + $openingbalance
			?>
			<tr>
			<td class="bodytext31" valign="center"  align="right">&nbsp;</td>
		    <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
			 <td class="bodytext31" valign="center"  align="right">&nbsp;</td>
			 <td class="bodytext31" valign="center"  align="right"><strong>Total</strong></td>
			 <td class="bodytext31" valign="center"  align="right"> <strong><?php echo number_format($totalcashamount1,2,'.',','); ?></strong></td>
			 <td class="bodytext31" valign="center"  align="right"> <strong><?php echo number_format($totalcardamount1,2,'.',','); ?></strong></td>
			 <td class="bodytext31" valign="center"  align="right"> <strong><?php echo number_format($totalchequeamount1,2,'.',','); ?></strong></td>
			 <td class="bodytext31" valign="center"  align="right"> <strong><?php echo number_format($totalmpesaamount1,2,'.',','); ?></strong></td>
			 <td class="bodytext31" valign="center"  align="right"> <strong><?php echo number_format($totalonlineamount1,2,'.',','); ?></strong></td>
			</tr>
			  </tbody>
        </table></td>
      </tr>
	  <?php
	  $grandtot = $grandtotal - $grandtotal1;
	  $grandcash = $totalcashamount1 - $totalcashamount;
	  $grandcard = $totalcardamount1 - $totalcardamount;
	  $grandcheque = $totalchequeamount1 - $totalchequeamount;
	  $grandmpesa = $totalmpesaamount1 - $totalmpesaamount;
	  $grandonline = $totalonlineamount1 - $totalonlineamount;
	  ?>
	  <tr>
        <td colspan="3"  align="left" valign="center" class="bodytext31">&nbsp;</td>
      </tr>
	   <tr>
	   <td width="160"  align="left" valign="center" class="bodytext31">Total Bill Amount</td>
        <td width="63"  align="right" valign="center" class="bodytext31"><?php echo number_format($grandtotal,2,'.',','); ?></td>
        <td width="1041"  align="left" valign="center" class="bodytext31">&nbsp;</td>
        <td width="23"  align="left" valign="center" class="bodytext31">&nbsp;</td>
      </tr>
	   <tr>
	   <td width="160"  align="left" valign="center" class="bodytext31">Total Refund Amount(Less)</td>
        <td width="63"  align="right" valign="center" class="bodytext31"><?php echo number_format($grandtotal1,2,'.',','); ?></td>
        <td width="1041"  align="left" valign="center" class="bodytext31">&nbsp;</td>
        <td width="23"  align="left" valign="center" class="bodytext31">&nbsp;</td>
      </tr>
	  <tr>
	   <td width="160"  align="left" valign="center" class="bodytext31">Total Cash In Hand</td>
        <td width="63"  align="right" valign="center" class="bodytext31"><?php echo number_format($grandcash,2,'.',','); ?></td>
        <td width="1041"  align="left" valign="center" class="bodytext31">&nbsp;</td>
        <td width="23"  align="left" valign="center" class="bodytext31">&nbsp;</td>
      </tr>
	   <tr>
	   <td width="160"  align="left" valign="center" class="bodytext31">Total Card</td>
        <td  align="right" valign="center" class="bodytext31"> <?php echo number_format($grandcard,2,'.',','); ?></td>
        <td  align="left" valign="center" class="bodytext31">&nbsp;</td>
        <td width="23"  align="left" valign="center" class="bodytext31">&nbsp;</td>
      </tr>
	   <tr>
	   <td width="160"  align="left" valign="center" class="bodytext31">Total Cheque</td>
        <td  align="right" valign="center" class="bodytext31"> <?php echo number_format($grandcheque,2,'.',','); ?></td>
        <td  align="left" valign="center" class="bodytext31">&nbsp;</td>
        <td width="23"  align="left" valign="center" class="bodytext31">&nbsp;</td>
      </tr>
	   <tr>
	   <td width="160"  align="left" valign="center" class="bodytext31">Total Mpesa</td>
        <td  align="right" valign="center" class="bodytext31"> <?php echo number_format($grandmpesa,2,'.',','); ?></td>
        <td  align="left" valign="center" class="bodytext31">&nbsp;</td>
        <td width="23"  align="left" valign="center" class="bodytext31">&nbsp;</td>
      </tr>
	  <tr>
	   <td width="160"  align="left" valign="center" class="bodytext31">Total Online</td>
        <td  align="right" valign="center" class="bodytext31"> <?php echo number_format($grandonline,2,'.',','); ?></td>
        <td  align="left" valign="center" class="bodytext31">&nbsp;</td>
        <td width="23"  align="left" valign="center" class="bodytext31">&nbsp;</td>
      </tr>
   
			<tr>
        <td  align="left" valign="center" class="bodytext31"><strong>Total For Submission</strong> </td>
        <td  align="right" valign="center" class="bodytext31"><strong><?php echo number_format($grandtot,2,'.',','); ?></strong></td>
        <td  align="left" valign="center" class="bodytext31">&nbsp;</td>
		</tr>
			
         
</table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
