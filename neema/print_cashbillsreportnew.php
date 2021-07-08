<?php
session_start();
//include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');

$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$username = '';
$companyanum = '';
$companyname = '';
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
$res1suppliername = '';
$total1 = '0.00';
$total2 = '0.00';
$total3 = '0.00';
$total4 = '0.00';
$total5 = '0.00';
$total6 = '0.00';

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="cashbillsreportnew.xls"');
header('Cache-Control: max-age=80');

if (isset($_REQUEST["user"])) { $searchsuppliername = $_REQUEST["user"]; } else { $searchsuppliername = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) {  $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) {  $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];
$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
?>
<style>
.text{
  mso-number-format:"\@";/*force text*/
}
</style>

          <table width="55%" height="103" border="0" cellpadding="0" cellspacing="0">
          <tbody>
            <tr>
              <td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
				 <td width="13%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>  Date </strong></td>
              <td width="34%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient</strong></div></td>
				  <td width="14%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Code</strong></div></td>
                           <td width="11%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Visit No </strong></td>
				<td width="9%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Bill No </strong></td>
   				  <td width="14%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount</strong></div></td>
			</tr>
			
			<?php
			
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			
		      
		
		  $query4 = "select * from master_billing where locationcode='$locationcode' and billingdatetime between '$ADate1' and '$ADate2'"; 
		  $exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		  $num4=mysql_num_rows($exec4);
		  while($res4 = mysql_fetch_array($exec4))
{

			 $patientname = $res4['patientfullname'];
			$patientcode = $res4['patientcode'];
			$visitcode = $res4['visitcode'];
			$date = $res4['billingdatetime'];
			 $amount = $res4['cashamount'];
			$billnumber = $res4['billnumber'];
			$total6 = $total6 + $amount;
			$snocount = $snocount + 1;
            ?>
           <tr>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $date; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $patientcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $visitcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left"><?php echo $billnumber; ?></td>
             			  <td  align="left" valign="center" class="text"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
           </tr>
			<?php
			}
			?>
			<?php
		  $query4 = "select * from master_transactionpaynow where locationcode='$locationcode' and transactiondate between '$ADate1' and '$ADate2'"; 
		  $exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		  while($res4 = mysql_fetch_array($exec4))
{

			$patientname = $res4['patientname'];
			$patientcode = $res4['patientcode'];
			$visitcode = $res4['visitcode'];
			$date = $res4['transactiondate'];
			$amount = $res4['cashamount'];
			$billnumber = $res4['billnumber'];
			$total6 = $total6 + $amount;

		  	$snocount = $snocount + 1;
			
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
	
			?>
           <tr>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $date; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $patientcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $visitcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left"><?php echo $billnumber; ?></td>
             			  <td  align="left" valign="center" class="text"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
           </tr>
			<?php
			}
			?>
					<?php
		  $query4 = "select * from master_transactionexternal where locationcode='$locationcode' and transactiondate between '$ADate1' and '$ADate2'"; 
		  $exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		  while($res4 = mysql_fetch_array($exec4))
{

			$patientname = $res4['patientname'];
			$patientcode = $res4['patientcode'];
			$visitcode = $res4['visitcode'];
			$date = $res4['transactiondate'];
			$amount = $res4['cashamount'];
			$billnumber = $res4['billnumber'];
			$total6 = $total6 + $amount;

		  	$snocount = $snocount + 1;
			
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
	
			?>
           <tr>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $date; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $patientcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $visitcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left"><?php echo $billnumber; ?></td>
             			  <td  align="left" valign="center" class="text"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
           </tr>
			<?php
			}
			?>
			<?php
		  $query4 = "select * from master_transactionadvancedeposit where locationcode='$locationcode' and transactiondate between '$ADate1' and '$ADate2'"; 
		  $exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		  while($res4 = mysql_fetch_array($exec4))
{

			$patientname = $res4['patientname'];
			$patientcode = $res4['patientcode'];
			$visitcode = '';
			$date = $res4['transactiondate'];
			$amount = $res4['cashamount'];
			$billnumber = $res4['docno'];
			$total6 = $total6 + $amount;

		  	$snocount = $snocount + 1;
			
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
	
			?>
           <tr>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $date; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $patientcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $visitcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left"><?php echo $billnumber; ?></td>
             			  <td  align="left" valign="center" class="text"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
           </tr>
			<?php
			}
			?>
				<?php
		  $query4 = "select * from master_transactionipdeposit where locationcode='$locationcode' and transactionmodule <> 'Adjustment' and transactiondate between '$ADate1' and '$ADate2'"; 
		  $exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		  while($res4 = mysql_fetch_array($exec4))
{

		    $patientname = $res4['patientname'];
			$patientcode = $res4['patientcode'];
			$visitcode = $res4['visitcode'];
			$date = $res4['transactiondate'];
			$amount = $res4['cashamount'];
			$billnumber = $res4['docno'];
			$total6 = $total6 + $amount;

		  	$snocount = $snocount + 1;
			
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
	
			?>
           <tr>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $date; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $patientcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $visitcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left"><?php echo $billnumber; ?></td>
             			  <td  align="left" valign="center" class="text"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
           </tr>
			<?php
			}
			?>
			
			<?php
		  $query4 = "select * from master_transactionip where locationcode='$locationcode' and transactiondate between '$ADate1' and '$ADate2'"; 
		  $exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		  while($res4 = mysql_fetch_array($exec4))
{

			$patientname = $res4['patientname'];
			$patientcode = $res4['patientcode'];
			$visitcode = $res4['visitcode'];
			$date = $res4['transactiondate'];
			$amount = $res4['cashamount'];
			$billnumber = $res4['billnumber'];
			
			
			if($amount != '0.00')
{
$total6 = $total6 + $amount;
		  	$snocount = $snocount + 1;
			
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
	
			?>
           <tr>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $date; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $patientcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $visitcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left"><?php echo $billnumber; ?></td>
             			  <td  align="left" valign="center" class="text"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
           </tr>
			<?php
			}
			}
			?>
					<?php
		  $query4 = "select * from master_transactionipcreditapproved where locationcode='$locationcode' and transactiondate between '$ADate1' and '$ADate2'"; 
		  $exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		  while($res4 = mysql_fetch_array($exec4))
{

			$patientname = $res4['patientname'];
			$patientcode = $res4['patientcode'];
			$visitcode = $res4['visitcode'];
			$date = $res4['transactiondate'];
			$amount = $res4['cashamount'];
			$billnumber = $res4['billnumber'];
			
			
			if($amount != '0.00')
{
$total6 = $total6 + $amount;
		  	$snocount = $snocount + 1;
			
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
	
			?>
           <tr>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $date; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $patientcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $visitcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left"><?php echo $billnumber; ?></td>
             			  <td  align="left" valign="center" class="text"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
           </tr>
			<?php
			}
			}
			?>
		
			
								<?php
		  $query4 = "select * from refund_paynow where locationcode='$locationcode' and transactiondate between '$ADate1' and '$ADate2'"; 
		  $exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		  while($res4 = mysql_fetch_array($exec4))
{

			$patientname = $res4['patientname'];
			$patientcode = $res4['patientcode'];
			$visitcode = $res4['visitcode'];
			$date = $res4['transactiondate'];
			$amount = $res4['cashamount'];
			$billnumber = $res4['billnumber'];
			
			
			if($amount != '0.00')
{

$total6 = $total6 - $amount;
		  	$snocount = $snocount + 1;
			
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
	
			?>
           <tr>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $date; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $patientcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $visitcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left"><?php echo $billnumber; ?></td>
             			  <td  align="left" valign="center" class="text"><div align="right"> - <?php echo number_format($amount,2,'.',','); ?></div></td>
           </tr>
			<?php
			}
			}
			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
					<td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>

              <td class="bodytext31" valign="center"  align="right" 
                ><strong>Total:</strong></td>
								<td  align="right" valign="center" 
                 class="text"><strong><?php echo number_format($total6,2,'.',','); ?></strong></td>
				 
			  <?php if($total6 != 0)
			 { 
			  ?>	 
			  <?php
		      }
		   ?>
			</tr>
          </tbody>
</table>
