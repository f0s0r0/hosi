<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$currentdate = date("Y-m-d");

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="daybookreport.xls"');
header('Cache-Control: max-age=80');

$grandtotal = '0.00';
$searchcustomername = '';
$patientfirstname = '';
$visitcode = '';
$customername = '';
$cbcustomername = '';
$cbbillnumber = '';
$cbbillstatus = '';
$customername = '';
$paymenttype = '';
$billstatus = '';
$res2loopcount = '';
$custid = '';
$visitcode1='';
$res2username ='';
$custname = '';
$colorloopcount = '';
$sno = '';
$customercode = '';
$totalsalesamount = '0.00';
$totalsalesreturnamount = '0.00';
$netcollectionamount = '0.00';
$netpaymentamount = '0.00';
$res2total = '0.00';
$cashamount = '0.00';
$cardamount = '0.00';
$chequeamount = '0.00';
$onlineamount = '0.00';
$total = '0.00';
$cashtotal = '0.00';
$cardtotal = '0.00';
$chequetotal = '0.00';
$onlinetotal = '0.00';
$res2cashamount1 ='';
$res2cardamount1 = '';
$res2chequeamount1 = '';
$res2onlineamount1 ='';
$cashamount2 = '0.00';
$cardamount2 = '0.00';
$chequeamount2 = '0.00';
$onlineamount2 = '0.00';
$total1 = '0.00';
$billnumber = '';
$netcashamount = '0.00';
$netcardamount = '0.00';
$netchequeamount = '0.00';
$netonlineamount = '0.00';
$netcreditamount = '0.00';

//$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
//$transactiondateto = date('Y-m-d');

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
if (isset($_REQUEST["ADate1"])) { $transactiondatefrom = $_REQUEST["ADate1"]; } else { $transactiondatefrom = ""; }
if (isset($_REQUEST["ADate2"])) { $transactiondateto = $_REQUEST["ADate2"]; } else { $transactiondateto = ""; }
$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
//$getcanum = $_GET['canum'];

if ($getcanum != '')
{
	$query4 = "select * from master_customer where locationcode='$locationcode' and auto_number = '$getcanum'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	$res4 = mysql_fetch_array($exec4);
	$cbcustomername = $res4['customername'];
	$customername = $res4['customername'];
}
?>
<style>
.xlText {
    mso-number-format: "\@";
}
</style>
<table border="0" width="1278">

<tr>
<td width="6" >&nbsp;</td>
<td colspan="5"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Day Book Report: </strong><?php echo $transactiondatefrom; ?> To <?php echo $transactiondateto; ?></td>
 </tr>
 <?php
  if (isset($_REQUEST["ADate1"])) { $transactiondatefrom = $_REQUEST["ADate1"]; } else { $transactiondatefrom = ""; }
			 if (isset($_REQUEST["ADate2"])) { $transactiondateto = $_REQUEST["ADate2"]; } else { $transactiondateto = ""; }
			 if (isset($_REQUEST["user"])) { $cbcustomername = $_REQUEST["user"]; } else { $cbcustomername = ""; }
			 
			 if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

			$cbcustomername=trim($cbcustomername);
			
			$query31 = "select * from master_employee where username = '$cbcustomername' and status <>'DELETED'";
			$exe31 = mysql_query($query31) or die("Error in Query31".mysql_error());
			$res31 = mysql_fetch_array($exe31);
			$res3username = $res31["username"];
			$employeename = $res31['employeename'];
?>			
<tr>
<td width="6" >&nbsp;</td>
<td colspan="5"><strong><?php echo $employeename; ?></strong></td>
  </tr>
 <tr>
 <td>&nbsp;</td>
 <td>
  <table width="1278" border="1" cellspacing="0" cellpadding="2">
            
            
            <tr>
              <td width="36"  align="left" valign="center" 
                bgcolor="#CCCCCC" class="bodytext31"><strong>No.</strong></td>
				<td width="154" align="right" valign="center"  
                bgcolor="#CCCCCC" class="bodytext31"><strong>Bill Date </strong></td>
				<td width="146" align="right" valign="center"  
                bgcolor="#CCCCCC" class="bodytext31"><strong>Bill No </strong></td>
              <td width="127" align="right" valign="center"  
                bgcolor="#CCCCCC" class="bodytext31"><strong>Cash </strong></td>
              <td width="114" align="right" valign="center"  
                bgcolor="#CCCCCC" class="bodytext31"><strong> Card </strong></td>
              <td width="134"  align="right" valign="center" 
                bgcolor="#CCCCCC" class="bodytext31"><strong> Cheque </strong></td>
				<td  width="147"  align="right" valign="center" 
                bgcolor="#CCCCCC" class="bodytext31"><strong>Online</strong></td>
				<td  width="147"  align="right" valign="center" 
                bgcolor="#CCCCCC" class="bodytext31"><strong>Mpesa</strong></td>
           </tr>		
				<?php			
			if( $res3username != '')
			{
			?>
            
			  
			  <?php 
			$totalcashamount1 = '0.00';
			$totalcardamount1 = '0.00';
			$totalchequeamount1 = '0.00';
			$totalonlineamount1 = '0.00';
			$totalcreditamount1 = '0.00';
			//$cbcustomername=trim($cbcustomername);
			
			$query2 = "select * from master_transactionpaynow where locationcode='$locationcode' and username = '$res3username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	        while($res2 = mysql_fetch_array($exec2))
			{
			$res2billnumber = $res2['billnumber'];
			$res2transactiondate = $res2['transactiondate'];
			
			$query3 = "select * from master_transactionpaynow where locationcode='$locationcode' and billnumber = '$res2billnumber'";
			$exec3 = mysql_query($query3) or die ("Error in Query3" .mysql_error());
			$res3 = mysql_fetch_array($exec3);
			$res3cashamount1 = $res3['cashamount'];
			$res3cardamount1 = $res3['cardamount'];
			$res3creditamount1 = $res3['creditamount'];
			$res3chequeamount1 = $res3['chequeamount'];
			$res3onlineamount1 = $res3['onlineamount'];
			
			$totalcashamount1 = $totalcashamount1 + $res3cashamount1;
			$totalcardamount1 = $totalcardamount1 + $res3cardamount1;
			$totalchequeamount1 = $totalchequeamount1 + $res3chequeamount1;
			$totalonlineamount1 = $totalonlineamount1 + $res3onlineamount1;    
			$totalcreditamount1 = $totalcreditamount1 + $res3creditamount1;    

			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";
		
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
            <tr >
              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			   <td class="bodytext31" valign="center"  align="right">
               <?php echo $res2transactiondate; ?></td>
			  <td class="xlText" valign="center"  align="right"><?php echo $res2billnumber; ?></td>
              <td class="xlText" valign="center" style="mso-number-format:"0\.000" " align="right"><?php echo number_format($res3cashamount1,2,'.',','); ?></td>
              <td class="xlText" valign="center"  align="right"><?php echo number_format($res3cardamount1,2,'.',','); ?></td>
              <td class="xlText" valign="center"  align="right"><?php echo number_format($res3chequeamount1,2,'.',','); ?></td>
				<td class="xlText" valign="center"  align="right"><?php echo number_format($res3onlineamount1,2,'.',','); ?></td>
				<td class="xlText" valign="center"  align="right"><?php echo number_format($res3creditamount1,2,'.',','); ?></td>
  </tr>
			<?php
			}
			?>
			  
			  <?php 
			$totalcashamount2 = '0.00';
			$totalcardamount2 = '0.00';
			$totalchequeamount2 = '0.00';
			$totalonlineamount2 ='0.00';
			$totalcreditamount2 ='0.00';
			//$cbcustomername=trim($cbcustomername);
			
			$query23 = "select * from master_billing where locationcode='$locationcode' and username = '$res3username' and billingdatetime between '$transactiondatefrom' and '$transactiondateto' order by username desc";
			$exec23 = mysql_query($query23) or die ("Error in Query23".mysql_error());
	        while($res23 = mysql_fetch_array($exec23))
			{
			$res23billnumber = $res23['billnumber'];
			$res23billingdatetime = $res23['billingdatetime'];
			
			$query33 = "select * from master_billing where locationcode='$locationcode' and billnumber = '$res23billnumber'";
			$exec33 = mysql_query($query33) or die ("Error in Query33" .mysql_error());
			$res33 = mysql_fetch_array($exec33);
			$res33cashamount1 = $res33['cashamount'];
			$res33cardamount1 = $res33['cardamount'];
			$res33creditamount1 = $res33['creditamount'];
			$res33chequeamount1 = $res33['chequeamount'];
			$res33onlineamount1 = $res33['onlineamount']; 
			
			$totalcashamount2 = $totalcashamount2 + $res33cashamount1;
			$totalcardamount2 = $totalcardamount2 + $res33cardamount1;
			$totalchequeamount2 = $totalchequeamount2 + $res33chequeamount1;
			$totalonlineamount2 = $totalonlineamount2 + $res33onlineamount1; 
			$totalcreditamount2 = $totalcreditamount2 + $res33creditamount1;  
			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";
		
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
            <tr >
              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			  <td class="bodytext31" valign="center"  align="right"><?php echo $res23billingdatetime; ?></td>
			  <td class="bodytext31" valign="center"  align="right"><?php echo $res23billnumber; ?></td>
              <td class="xlText" valign="center"  align="right"><?php echo number_format($res33cashamount1,2,'.',','); ?></td>
              <td class="xlText" valign="center"  align="right"><?php echo number_format($res33cardamount1,2,'.',','); ?></td>
              <td class="xlText" valign="center"  align="right"><?php echo number_format($res33chequeamount1,2,'.',','); ?></td>
				<td  align="right" valign="center" class="xlText"><?php echo number_format($res33onlineamount1,2,'.',','); ?></td>
			  <td  align="right" valign="center" class="xlText"><?php echo number_format($res33creditamount1,2,'.',','); ?></td>	
  </tr>
			  
			<?php
			 }	
			?>
			
			 <?php 
			$totalcashamount3 = '0.00';
			$totalcardamount3 = '0.00';
			$totalchequeamount3 = '0.00';
			$totalonlineamount3 ='0.00';
			$totalcreditamount3 ='0.00';
			//$cbcustomername=trim($cbcustomername);
			
			$query24 = "select * from master_transactionexternal where locationcode='$locationcode' and username = '$res3username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";
			$exec24 = mysql_query($query24) or die ("Error in Query24".mysql_error());
	        while($res24 = mysql_fetch_array($exec24))
			{
			$res24billnumber = $res24['billnumber'];
			$res24transactiondate = $res24['transactiondate'];
			
			$query34 = "select * from master_transactionexternal where locationcode='$locationcode' and billnumber = '$res24billnumber'";
			$exec34 = mysql_query($query34) or die ("Error in Query34" .mysql_error());
			$res34 = mysql_fetch_array($exec34);
			$res34cashamount1 = $res34['cashamount'];
			$res34cardamount1 = $res34['cardamount'];
			$res34creditamount1 = $res34['creditamount'];
			$res34chequeamount1 = $res34['chequeamount'];
			$res34onlineamount1 = $res34['onlineamount']; 
			
			$totalcashamount3 = $totalcashamount3 + $res34cashamount1;
			$totalcardamount3 = $totalcardamount3 + $res34cardamount1; 
			$totalchequeamount3 = $totalchequeamount3 + $res34chequeamount1;
			$totalonlineamount3 = $totalonlineamount3 + $res34onlineamount1; 
			$totalcreditamount3 = $totalcreditamount3 + $res34creditamount1; 
			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";
		
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
            <tr >
              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			  <td class="bodytext31" valign="center"  align="right"><?php echo $res24transactiondate; ?></td>
			  <td class="bodytext31" valign="center"  align="right"><?php echo $res24billnumber; ?></td>
              <td class="xlText" valign="center"  align="right"><?php echo number_format($res34cashamount1,2,'.',','); ?></td>
              <td class="xlText" valign="center"  align="right"><?php echo number_format($res34cardamount1,2,'.',','); ?></td>
              <td class="xlText" valign="center"  align="right"><?php echo number_format($res34chequeamount1,2,'.',','); ?></td>
				<td  align="right" valign="center" class="xlText"><?php echo number_format($res34onlineamount1,2,'.',','); ?></td>
					<td  align="right" valign="center" class="xlText"><?php echo number_format($res34creditamount1,2,'.',','); ?></td>
  </tr>
			<?php
			 }
			?>
			
			<?php 
			$totalcashamount4 = '0.00';
			$totalcardamount4 = '0.00';
			$totalchequeamount4 = '0.00';
			$totalonlineamount4 ='0.00';
			$totalcreditamount4 ='0.00';
			//$cbcustomername=trim($cbcustomername);
			
			$query25 = "select * from refund_paynow where locationcode='$locationcode' and username = '$res3username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";
			$exec25 = mysql_query($query25) or die ("Error in Query25".mysql_error());
	        while($res25 = mysql_fetch_array($exec25))
			{
			$res25billnumber = $res25['billnumber'];
			$res25transactiondate = $res25['transactiondate'];
			
			$query35 = "select * from refund_paynow where locationcode='$locationcode' and billnumber = '$res25billnumber'";
			$exec35 = mysql_query($query35) or die ("Error in Query35" .mysql_error());
			$res35 = mysql_fetch_array($exec35);
			$res35cashamount1 = $res35['cashamount'];
			$res35cardamount1 = $res35['cardamount'];
			$res35creditamount1 = $res35['creditamount'];
			$res35chequeamount1 = $res35['chequeamount'];
			$res35onlineamount1 = $res35['onlineamount'];
			
			$totalcashamount4 = $totalcashamount4 + $res35cashamount1;
			$totalcardamount4 = $totalcardamount4 + $res35cardamount1;
			$totalchequeamount4 = $totalchequeamount4 + $res35chequeamount1;
			$totalonlineamount4 = $totalonlineamount4 + $res35onlineamount1;
			$totalcreditamount4 = $totalcreditamount4 + $res35creditamount1;
			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";
		
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
            <tr >
              <td height="25"  align="left" valign="center" class="bodytext31"><?php echo $sno = $sno + 1; ?></td>
			  <td class="bodytext31" valign="center"  align="right"><?php echo $res25transactiondate; ?></td>
			  <td class="bodytext31" valign="center"  align="right"><?php echo $res25billnumber; ?></td>
              <td class="xlText" valign="center"  align="right"><?php echo number_format(- $res35cashamount1,2,'.',','); ?></td>
              <td class="xlText" valign="center"  align="right"><?php echo number_format(- $res35cardamount1,2,'.',','); ?></td>
              <td class="xlText" valign="center"  align="right"><?php echo number_format(- $res35chequeamount1,2,'.',','); ?></td>
				<td  align="right" valign="center" class="xlText"><?php echo number_format(- $res35onlineamount1,2,'.',','); ?></td>
					<td  align="right" valign="center" class="xlText"><?php echo number_format(- $res35creditamount1,2,'.',','); ?></td>
  </tr>
			<?php
			 }	
			?>
			<?php 
			$totalcashamount5 = '0.00';
			$totalcardamount5 = '0.00';
			$totalchequeamount5 = '0.00';
			$totalonlineamount5 ='0.00';
			$totalcreditamount5 ='0.00';
			//$cbcustomername=trim($cbcustomername);
			
			$query26 = "select * from master_transactionadvancedeposit where locationcode='$locationcode' and username = '$res3username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";
			$exec26 = mysql_query($query26) or die ("Error in Query24".mysql_error());
	        while($res26 = mysql_fetch_array($exec26))
			{
			$res26billnumber = $res26['docno'];
			$res26transactiondate = $res26['transactiondate'];
			
			$query36 = "select * from master_transactionadvancedeposit where locationcode='$locationcode' and docno = '$res26billnumber'";
			$exec36 = mysql_query($query36) or die ("Error in Query34" .mysql_error());
			$res36 = mysql_fetch_array($exec36);
			$res36cashamount1 = $res36['cashamount'];
			$res36cardamount1 = $res36['cardamount'];
			$res36creditamount1 = $res36['creditamount'];
			$res36chequeamount1 = $res36['chequeamount'];
			$res36onlineamount1 = $res36['onlineamount']; 
			$res36transactionamount = $res36['transactionamount'];
			
			$totalcashamount5 = $totalcashamount5 + $res36cashamount1;
			$totalcardamount5 = $totalcardamount5 + $res36cardamount1; 
			$totalchequeamount5 = $totalchequeamount5 + $res36chequeamount1;
			$totalonlineamount5 = $totalonlineamount5 + $res36onlineamount1; 
			$totalcreditamount5 = $totalcreditamount5 + $res36creditamount1; 
			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";
		
		if($res36transactionamount != '0.00')
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

			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			  <td class="bodytext31" valign="center"  align="right"><?php echo $res26transactiondate; ?></td>
			  <td class="bodytext31" valign="center"  align="right"><?php echo $res26billnumber; ?></td>
              <td class="xlText" valign="center"  align="right"><?php echo number_format($res36cashamount1,2,'.',','); ?></td>
              <td class="xlText" valign="center"  align="right"><?php echo number_format($res36cardamount1,2,'.',','); ?></td>
              <td class="xlText" valign="center"  align="right"><?php echo number_format($res36chequeamount1,2,'.',','); ?></td>
				<td  align="right" valign="center" class="xlText"><?php echo number_format($res36onlineamount1,2,'.',','); ?></td>
				<td  align="right" valign="center" class="xlText"><?php echo number_format($res36creditamount1,2,'.',','); ?></td>
              </tr>
			<?php
			 }
			 }
			?>
			<?php 
			$totalcashamount6 = '0.00';
			$totalcardamount6 = '0.00';
			$totalchequeamount6 = '0.00';
			$totalonlineamount6 ='0.00';
			$totalcreditamount6 ='0.00';
			//$cbcustomername=trim($cbcustomername);
			
			$query27 = "select * from master_transactionipdeposit where locationcode='$locationcode' and username = '$res3username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";
			$exec27 = mysql_query($query27) or die ("Error in Query24".mysql_error());
	        while($res27 = mysql_fetch_array($exec27))
			{
			$res27billnumber = $res27['docno'];
			$res27transactiondate = $res27['transactiondate'];
			
			$query37 = "select * from master_transactionipdeposit where locationcode='$locationcode' and docno = '$res27billnumber' and docno <> ''";
			$exec37 = mysql_query($query37) or die ("Error in Query34" .mysql_error());
			while($res37 = mysql_fetch_array($exec37)){
			$res37cashamount1 = $res37['cashamount'];
			$res37cardamount1 = $res37['cardamount'];
			$res37creditamount1 = $res37['creditamount'];
			$res37chequeamount1 = $res37['chequeamount'];
			$res37onlineamount1 = $res37['onlineamount']; 
			$res37transactionamount = $res37['transactionamount'];
			
			$totalcashamount6 = $totalcashamount6 + $res37cashamount1;
			$totalcardamount6 = $totalcardamount6 + $res37cardamount1; 
			$totalchequeamount6 = $totalchequeamount6 + $res37chequeamount1;
			$totalonlineamount6 = $totalonlineamount6 + $res37onlineamount1; 
			$totalcreditamount6 = $totalcreditamount6 + $res37creditamount1; 
			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";
		
		if($res37transactionamount != '0.00')
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

			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			  <td class="bodytext31" valign="center"  align="right"><?php echo $res27transactiondate; ?></td>
			  <td class="bodytext31" valign="center"  align="right"><?php echo $res27billnumber; ?></td>
              <td class="xlText" valign="center"  align="right"><?php echo number_format($res37cashamount1,2,'.',','); ?></td>
              <td class="xlText" valign="center"  align="right"><?php echo number_format($res37cardamount1,2,'.',','); ?></td>
              <td class="xlText" valign="center"  align="right"><?php echo number_format($res37chequeamount1,2,'.',','); ?></td>
			  <td  align="right" valign="center" class="xlText"><?php echo number_format($res37onlineamount1,2,'.',','); ?></td>
			  <td  align="right" valign="center" class="xlText"><?php echo number_format($res37creditamount1,2,'.',','); ?></td>
              </tr>
			<?php
			 }
			 }
			 }

			$query27 = "select * from master_mortuaryexternaldeposit where username = '$res3username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";
			$exec27 = mysql_query($query27) or die ("Error in Query24".mysql_error());
	        while($res27 = mysql_fetch_array($exec27))
			{
			$res27billnumber = $res27['docno'];
			$res27transactiondate = $res27['transactiondate'];
			
			$query37 = "select * from master_mortuaryexternaldeposit where docno = '$res27billnumber' and docno <> ''";
			$exec37 = mysql_query($query37) or die ("Error in Query34" .mysql_error());
			while($res37 = mysql_fetch_array($exec37)){
			$res37cashamount1 = $res37['cashamount'];
			$res37cardamount1 = $res37['cardamount'];
			$res37creditamount1 = $res37['creditamount'];
			$res37chequeamount1 = $res37['chequeamount'];
			$res37onlineamount1 = $res37['onlineamount']; 
			$res37transactionamount = $res37['transactionamount'];
			
			$totalcashamount6 = $totalcashamount6 + $res37cashamount1;
			$totalcardamount6 = $totalcardamount6 + $res37cardamount1; 
			$totalchequeamount6 = $totalchequeamount6 + $res37chequeamount1;
			$totalonlineamount6 = $totalonlineamount6 + $res37onlineamount1; 
			$totalcreditamount6 = $totalcreditamount6 + $res37creditamount1; 
			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";
		
		if($res37transactionamount != '0.00')
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

			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			  <td class="bodytext31" valign="center"  align="right"><?php echo $res27transactiondate; ?></td>
			  <td class="bodytext31" valign="center"  align="right"><?php echo $res27billnumber; ?></td>
              <td class="xlText" valign="center"  align="right"><?php echo number_format($res37cashamount1,2,'.',','); ?></td>
              <td class="xlText" valign="center"  align="right"><?php echo number_format($res37cardamount1,2,'.',','); ?></td>
              <td class="xlText" valign="center"  align="right"><?php echo number_format($res37chequeamount1,2,'.',','); ?></td>
			  <td  align="right" valign="center" class="xlText"><?php echo number_format($res37onlineamount1,2,'.',','); ?></td>
			  <td  align="right" valign="center" class="xlText"><?php echo number_format($res37creditamount1,2,'.',','); ?></td>
              </tr>
			<?php
			 }
			 }
			 }
			?>
			<?php 
			$totalcashamount7 = '0.00';
			$totalcardamount7 = '0.00';
			$totalchequeamount7 = '0.00';
			$totalonlineamount7 ='0.00';
			$totalcreditamount7 ='0.00';
			//$cbcustomername=trim($cbcustomername);
			
			$query28 = "select * from master_transactionip where locationcode='$locationcode' and username = '$res3username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";
			$exec28 = mysql_query($query28) or die ("Error in Query24".mysql_error());
	        while($res28 = mysql_fetch_array($exec28))
			{
			$res28billnumber = $res28['billnumber'];
			$res28transactiondate = $res28['transactiondate'];
			
			$query38 = "select * from master_transactionip where locationcode='$locationcode' and billnumber = '$res28billnumber'";
			$exec38 = mysql_query($query38) or die ("Error in Query34" .mysql_error());
			$res38 = mysql_fetch_array($exec38);
			$res38cashamount1 = $res38['cashamount'];
			$res38cardamount1 = $res38['cardamount'];
			$res38creditamount1 = $res38['mpesaamount'];
			$res38chequeamount1 = $res38['chequeamount'];
			$res38onlineamount1 = $res38['onlineamount']; 
			$res38transactionamount = $res38['transactionamount'];
			$res38returnbalance = $res38['returnbalance'];
			$res38cashamount1 = $res38cashamount1 + $res38returnbalance;
			
			$totalcashamount7 = $totalcashamount7 + $res38cashamount1;
			$totalcardamount7 = $totalcardamount7 + $res38cardamount1; 
			$totalchequeamount7 = $totalchequeamount7 + $res38chequeamount1;
			$totalonlineamount7 = $totalonlineamount7 + $res38onlineamount1; 
			$totalcreditamount7 = $totalcreditamount7 + $res38creditamount1; 
			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";
		
		if($res38transactionamount != '0.00')
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

			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			  <td class="bodytext31" valign="center"  align="right"><?php echo $res28transactiondate; ?></td>
			  <td class="bodytext31" valign="center"  align="right"><?php echo $res28billnumber; ?></td>
              <td class="xlText" valign="center"  align="right"><?php echo number_format($res38cashamount1,2,'.',','); ?></td>
              <td class="xlText" valign="center"  align="right"><?php echo number_format($res38cardamount1,2,'.',','); ?></td>
              <td class="xlText" valign="center"  align="right"><?php echo number_format($res38chequeamount1,2,'.',','); ?></td>
				<td  align="right" valign="center" class="xlText"><?php echo number_format($res38onlineamount1,2,'.',','); ?></td>
				<td  align="right" valign="center" class="xlText"><?php echo number_format($res38creditamount1,2,'.',','); ?></td>
              </tr>
			<?php
			 }
			 }
			?>
			<?php 
		/*	//$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			//$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));*/
			$totalcashamount7ar = '0.00';
			$totalcardamount7ar = '0.00';
			$totalchequeamount7ar = '0.00';
			$totalonlineamount7ar ='0.00';
			$totalcreditamount7ar ='0.00';
			//$cbcustomername=trim($cbcustomername);
			
			$query28ar = "select * from master_transactionpaylater where username = '$res3username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' and transactionstatus = 'onaccount' order by username desc";
			$exec28ar = mysql_query($query28ar) or die ("Error in Query24".mysql_error());
	        while($res28ar = mysql_fetch_array($exec28ar))
			{
			$res28arbillnumber = $res28ar['docno'];
			$res28artransactiondate = $res28ar['transactiondate'];
			
			$query38ar = "select * from master_transactionpaylater where docno = '$res28arbillnumber' and transactionstatus = 'onaccount'";
			$exec38ar = mysql_query($query38ar) or die ("Error in Query34" .mysql_error());
			$res38ar = mysql_fetch_array($exec38ar);
			$res38arcashamount1 = $res38ar['cashamount'];
			$res38arcardamount1 = $res38ar['cardamount'];
			$res38arcreditamount1 = $res38ar['mpesaamount'];
			$res38archequeamount1 = $res38ar['chequeamount'];
			$res38aronlineamount1 = $res38ar['onlineamount']; 
			$res38artransactionamount = $res38ar['transactionamount'];
			
			$totalcashamount7ar = $totalcashamount7ar + $res38arcashamount1;
			$totalcardamount7ar = $totalcardamount7ar + $res38arcardamount1; 
			$totalchequeamount7ar = $totalchequeamount7ar + $res38archequeamount1;
			$totalonlineamount7ar = $totalonlineamount7ar + $res38aronlineamount1; 
			$totalcreditamount7ar = $totalcreditamount7ar + $res38arcreditamount1;
			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";
		
		if($res38artransactionamount != '0.00')
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

			?>
        		  
			  <tr>
              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			  <td class="bodytext31" valign="center"  align="right"><?php echo $res28artransactiondate; ?></td>
			  <td class="bodytext31" valign="center"  align="right"><?php echo $res28arbillnumber; ?></td>
              <td class="xlText" valign="center"  align="right"><?php echo number_format($res38arcashamount1,2,'.',','); ?></td>
              <td class="xlText" valign="center"  align="right"><?php echo number_format($res38arcardamount1,2,'.',','); ?></td>
              <td class="xlText" valign="center"  align="right"><?php echo number_format($res38archequeamount1,2,'.',','); ?></td>
				<td  align="right" valign="center" class="xlText"><?php echo number_format($res38aronlineamount1,2,'.',','); ?></td>
				<td  align="right" valign="center" class="xlText"><?php echo number_format($res38arcreditamount1,2,'.',','); ?></td>
              </tr>
			<?php
			 }
			 }
			?>
			<?php 
			$totalcashamount8 = '0.00';
			$totalcardamount8 = '0.00';
			$totalchequeamount8 = '0.00';
			$totalonlineamount8 ='0.00';
			$totalcreditamount8 ='0.00';
			//$cbcustomername=trim($cbcustomername);
			
			$query29 = "select * from master_transactionipcreditapproved where locationcode='$locationcode' and username = '$res3username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";
			$exec29 = mysql_query($query29) or die ("Error in Query24".mysql_error());
	        while($res29 = mysql_fetch_array($exec29))
			{
			$res29billnumber = $res29['billnumber'];
			$res29transactiondate = $res29['transactiondate'];
			$res2postingaccount = $res29['postingaccount'];
			
			$query39 = "select * from master_transactionipcreditapproved where locationcode='$locationcode' and billnumber = '$res29billnumber' and postingaccount = '$res2postingaccount'";
			$exec39 = mysql_query($query39) or die ("Error in Query34" .mysql_error());
			$res39 = mysql_fetch_array($exec39);
			$res39cashamount1 = $res39['cashamount'];
			$res39cardamount1 = $res39['cardamount'];
			$res39creditamount1 = $res39['creditamount'];
			$res39chequeamount1 = $res39['chequeamount'];
			$res39onlineamount1 = $res39['onlineamount']; 
			$res39transactionamount = $res39['transactionamount'];
			
			$totalcashamount8 = $totalcashamount8 + $res39cashamount1;
			$totalcardamount8 = $totalcardamount8 + $res39cardamount1; 
			$totalchequeamount8 = $totalchequeamount8 + $res39chequeamount1;
			$totalonlineamount8 = $totalonlineamount8 + $res39onlineamount1; 
			$totalcreditamount8 = $totalcreditamount8 + $res39creditamount1; 
			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";
		
		if(($res39cashamount1 != '0.00')||($res39cardamount1 != '0.00')||($res39chequeamount1 != '0.00')||($res39onlineamount1 != '0.00')||($res39creditamount1 != '0.00'))
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

			?>
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			  <td class="bodytext31" valign="center"  align="right"><?php echo $res29transactiondate; ?></td>
			  <td class="bodytext31" valign="center"  align="right"><?php echo $res29billnumber; ?></td>
              <td class="xlText" valign="center"  align="right"><?php echo number_format($res39cashamount1,2,'.',','); ?></td>
              <td class="xlText" valign="center"  align="right"><?php echo number_format($res39cardamount1,2,'.',','); ?></td>
              <td class="xlText" valign="center"  align="right"><?php echo number_format($res39chequeamount1,2,'.',','); ?></td>
				<td  align="right" valign="center" class="xlText"><?php echo number_format($res39onlineamount1,2,'.',','); ?></td>
				<td  align="right" valign="center" class="xlText"><?php echo number_format($res39creditamount1,2,'.',','); ?></td>
              </tr>
			<?php
			 }
			 }
			?>
			<?php 
			$totalcashamount10 = '0.00';
			$totalcardamount10 = '0.00';
			$totalchequeamount10 = '0.00';
			$totalonlineamount10 ='0.00';
			$totalcreditamount10 ='0.00';
			//$cbcustomername=trim($cbcustomername);
			
			$query45 = "select * from receiptsub_details where locationcode='$locationcode' and username = '$res3username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by username desc";
			$exec45 = mysql_query($query45) or die ("Error in Query45".mysql_error());
	        while($res45 = mysql_fetch_array($exec45))
			{
			$res45billnumber = $res45['docnumber'];
			$res45transactiondate = $res45['transactiondate'];
			
			/*$query35 = "select * from refund_paynow where billnumber = '$res25billnumber'";
			$exec35 = mysql_query($query35) or die ("Error in Query35" .mysql_error());
			$res35 = mysql_fetch_array($exec35);*/
			$res45cashamount1 = $res45['cashamount'];
			$res45cardamount1 = $res45['cardamount'];
			$res45creditamount1 = $res45['creditamount'];
			$res45chequeamount1 = $res45['chequeamount'];
			$res45onlineamount1 = $res45['onlineamount'];
			
			$totalcashamount10 = $totalcashamount10 + $res45cashamount1;
			$totalcardamount10 = $totalcardamount10 + $res45cardamount1;
			$totalchequeamount10 = $totalchequeamount10 + $res45chequeamount1;
			$totalonlineamount10 = $totalonlineamount10 + $res45onlineamount1;
			$totalcreditamount10 = $totalcreditamount10 + $res45creditamount1;
			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";
		
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
            <tr >
              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			  <td class="bodytext31" valign="center"  align="right"><?php echo $res45transactiondate; ?></td>
			  <td class="bodytext31" valign="center"  align="right"><?php echo $res45billnumber; ?></td>
              <td class="xlText" valign="center"  align="right"><?php echo number_format($res45cashamount1,2,'.',','); ?></td>
              <td class="xlText" valign="center"  align="right"><?php echo number_format($res45cardamount1,2,'.',','); ?></td>
              <td class="xlText" valign="center"  align="right"><?php echo number_format($res45chequeamount1,2,'.',','); ?></td>
				<td  align="right" valign="center" class="xlText"><?php echo number_format($res45onlineamount1,2,'.',','); ?></td>
				<td  align="right" valign="center" class="xlText"><?php echo number_format($res45creditamount1,2,'.',','); ?></td>
  </tr>
			<?php
			 }	

			$totalcashamount92 = '0.00';
			$totalcardamount92 = '0.00';
			$totalchequeamount92 = '0.00';
			$totalonlineamount92 ='0.00';
			$totalcreditamount92 ='0.00';
			
			$query402 = "select * from deposit_refund where locationcode='$locationcode' and username = '$res3username' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
			$exec402 = mysql_query($query402) or die ("Error in Query402".mysql_error());
	        while($res402 = mysql_fetch_array($exec402))
			{
			$res402billnumber = $res402['docno'];
			$res402transactiondate = $res402['recorddate'];
			//$res402postingaccount = $res402['postingaccount'];
			
			/*$query392 = "select * from receiptsub_details where billnumber = '$res292billnumber' and postingaccount = '$res2postingaccount'";
			$exec392 = mysql_query($query392) or die ("Error in Query34" .mysql_error());
			$res392 = mysql_fetch_array($exec392);*/
			$res402cashamount1 = $res402['cashamount'];
			$res402cardamount1 = $res402['cardamount'];
			$res402creditamount1 = $res402['creditamount'];
			$res402chequeamount1 = $res402['chequeamount'];
			$res402onlineamount1 = $res402['onlineamount']; 
			$res402transactionamount = $res402['amount'];
			
			$totalcashamount92 = $totalcashamount92 + $res402cashamount1;
			$totalcardamount92 = $totalcardamount92 + $res402cardamount1; 
			$totalchequeamount92 = $totalchequeamount92 + $res402chequeamount1;
			$totalonlineamount92 = $totalonlineamount92 + $res402onlineamount1; 
			$totalcreditamount92 = $totalcreditamount92 + $res402creditamount1;
			//$query1 = "select billnumber from master_billing, master_transactionpaynow, master_transactionexternal where master_billing.";
		
		if(($res402cashamount1 != '0.00')||($res402cardamount1 != '0.00')||($res402chequeamount1 != '0.00')||($res402onlineamount1 != '0.00'))
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

			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			  <td class="bodytext31" valign="center"  align="right">
                <?php echo $res402transactiondate; ?></td>
			  <td class="bodytext31" valign="center"  align="right">
                <?php echo $res402billnumber; ?></td>
              <td class="bodytext31" valign="center"  align="right">
                <?php echo number_format(-$res402cashamount1,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format(-$res402cardamount1,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right">
                <?php echo number_format(-$res402chequeamount1,2,'.',','); ?></td>
				<td  align="right" valign="center" class="bodytext31"><?php echo number_format(-$res402onlineamount1,2,'.',','); ?></td>
				<td  align="right" valign="center" class="bodytext31"><?php echo number_format(-$res402creditamount1,2,'.',','); ?></td>
              </tr>
			<?php
			 }
			 }
			?>
			
			<?php
			$totalcashamount = $totalcashamount1 + $totalcashamount2 + $totalcashamount3 - $totalcashamount4 + $totalcashamount5 + $totalcashamount6 + $totalcashamount7 + $totalcashamount8 + $totalcashamount10 + $totalcashamount7ar - $totalcashamount92;
			$totalcardamount = $totalcardamount1 + $totalcardamount2 + $totalcardamount3 - $totalcardamount4 + $totalcardamount5 + $totalcardamount6 + $totalcardamount7 + $totalcardamount8 + $totalcardamount10 + $totalcardamount7ar - $totalcardamount92;
			$totalchequeamount = $totalchequeamount1 + $totalchequeamount2 + $totalchequeamount3 - $totalchequeamount4 + $totalchequeamount5 + $totalchequeamount6 + $totalchequeamount7 + $totalchequeamount8 + $totalchequeamount10 + $totalchequeamount7ar - $totalchequeamount92;
			$totalonlineamount = $totalonlineamount1 + $totalonlineamount2 +$totalonlineamount3 - $totalonlineamount4 + $totalonlineamount5 + $totalonlineamount6 + $totalonlineamount7 + $totalonlineamount8 + $totalonlineamount10 + $totalonlineamount7ar - $totalonlineamount92;
			$totalcreditamount = $totalcreditamount1 + $totalcreditamount2 +$totalcreditamount3 - $totalcreditamount4 + $totalcreditamount5 + $totalcreditamount6 + $totalcreditamount7 + $totalcreditamount8 + $totalcreditamount10 + $totalcreditamount7ar - $totalcreditamount92;
			
			$netcashamount = $netcashamount + $totalcashamount;
			$netcardamount = $netcardamount + $totalcardamount;
			$netchequeamount = $netchequeamount + $totalchequeamount;
			$netonlineamount = $netonlineamount + $totalonlineamount;
			$netcreditamount = $netcreditamount + $totalcreditamount;
			
			$grandtotal = $totalcashamount + $totalcardamount + $totalchequeamount + $totalonlineamount + $totalcreditamount; 
			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#FFFFFF"></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td  align="right" valign="center" 
                bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#FFFFFF"></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#FFFFFF"><strong>Total:</strong></td>
				<td class="xlText" valign="center"  align="right" 
                bgcolor="#FFFFFF"><?php echo number_format($totalcashamount,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#FFFFFF"><?php echo number_format($totalcardamount,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#FFFFFF"><?php echo number_format($totalchequeamount,2,'.',','); ?></td>
				<td  align="right" valign="center" 
                bgcolor="#FFFFFF" class="xlText"><?php echo number_format($totalonlineamount,2,'.',',');?></td>
				<td  align="right" valign="center" 
                bgcolor="#FFFFFF" class="xlText"><?php echo number_format($totalcreditamount,2,'.',',');?></td>
  </tr>
			  
			 <!-- <tr>
			    <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"></td>
			    <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"></td>
			    <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>Grand Total:</strong></td>
			    <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><?php echo number_format($netcashamount,2,'.',','); ?></td>
			    <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><?php echo number_format($netcardamount,2,'.',','); ?></td>
			    <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><?php echo number_format($netchequeamount,2,'.',','); ?></td>
			    <td  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><?php echo number_format($netonlineamount,2,'.',',');?></td>
			    <td class="bodytext31" valign="center"  align="right" 
                 bgcolor="#e0e0e0">&nbsp;</td>
			    </tr>-->
			  <tr>
			    <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"></td>
			    <td colspan="2" class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff">&nbsp;</td>
			    <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff">&nbsp;</td>
			    <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff">&nbsp;</td>
			    <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff">&nbsp;</td>
			    <td  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
				<td  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
  </tr>
			  <tr>
			    <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"></td>
			
              <td colspan="2" class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>Total for Payment Modes :</strong></td>
				<td class="xlText" valign="center"  align="right" 
                bgcolor="#ffffff"><?php echo number_format($grandtotal,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><?php //echo number_format($totalcardamount,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><?php //echo number_format($totalchequeamount,2,'.',','); ?></td>
				<td  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><?php //echo number_format($totalonlineamount,2,'.',',');?></td>
				<td  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
  </tr>
			  <?php 
			  }
			 // }
			 ?>
</table> </td>
</table>
