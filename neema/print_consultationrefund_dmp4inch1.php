<?php
require_once('html2pdf/html2pdf.class.php');
ob_start();
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
 $companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];


$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }

	include('convert_currency_to_words.php');
	
	$query11 = "select * from refund_paynow where locationcode='$locationcode' and billnumber = '$billautonumber' ";
	$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
	mysql_num_rows($exec11);
	$res11 = mysql_fetch_array($exec11);
	 $res11patientfirstname = $res11['patientname'];
	$res11patientcode = $res11['patientcode'];
	$res11visitcode = $res11['visitcode'];
	 $res11billnumber = $res11['billnumber'];
	$res11transactionamount = $res11['transactionamount'];
	$convertedwords = covert_currency_to_words($res11transactionamount);
	$res11transactiondate= $res11['transactiondate'];
    $res11transactiontime= $res11['transactiontime'];
	$res11username = $res11['username'];
	$res11cashamount = $res11['cashamount'];
	$res11chequeamount = $res11['chequeamount'];
	$res11cardamount = $res11['cardamount'];
	$res11onlineamount= $res11['onlineamount'];
	$res11creditamount= $res11['creditamount'];
	$res11cashgivenbycustomer = $res11['cashgivenbycustomer'];
	$res11cashgiventocustomer = $res11['cashgiventocustomer'];
	
	$query01="select * from paymentmodecredit where billnumber='$billautonumber'";
	$exe01=mysql_query($query01);
	$res01=mysql_fetch_array($exe01);
	$mpesanumber=$res01['mpesanumber'];
?>
<style type="text/css">
.bodytext32 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000; 
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 16px; COLOR: #3B3B3C; }
.bodytext321 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #3B3B3C; 
}
.bodytext33 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000;
}
.bodytext34 {FONT-WEIGHT: normal; FONT-SIZE: 10px; COLOR: #000000;
}
.bodytext35 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000;
}
.bodytext36 {FONT-WEIGHT: normal; FONT-SIZE: 9px; COLOR: #000000;
}
.bodytext37 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;
}
.bodytext38 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;
}
.bodytext39 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;
}
.bodytext40 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;
}
.bodytext41 {FONT-WEIGHT: bold; FONT-SIZE: 20px; COLOR: #000000;
}
.bodytext42 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;
}
</style>
<table width="532" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <?php 
$query2 = "select * from master_company where  auto_number = '$companyanum'";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$companyname = $res2["companyname"];
$address1 = $res2["address1"];
$address2 = $res2["address2"];
$area = $res2["area"];
$city = $res2["city"];
$pincode = $res2["pincode"];
$emailid1 = $res2["emailid1"];
$phonenumber1 = $res2["phonenumber1"];
$phonenumber2 = $res2["phonenumber2"];
$tinnumber1 = $res2["tinnumber"];
$cstnumber1 = $res2["cstnumber"];
?>
    <td width="118" rowspan="4"><?php
			$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
			$exec3showlogo = mysql_query($query3showlogo) or die ("Error in Query3showlogo".mysql_error());
			$res3showlogo = mysql_fetch_array($exec3showlogo);
			$showlogo = $res3showlogo['showlogo'];
			if ($showlogo == 'SHOW LOGO')
			{
			?>
        <!--<img src="logofiles/<?php echo $companyanum;?>.jpg" width="91" height="80" />-->
        <?php
			}
			?>    </td>
    <td colspan="2" align="ceter"><?php
			$strlen2 = strlen($companyname);
			$totalcharacterlength2 = 35;
			$totalblankspace2 = 35 - $strlen2;
			$splitblankspace2 = $totalblankspace2 / 2;
			for($i=1;$i<=$splitblankspace2;$i++)
			{
			$companyname = 	' '.$companyname.' ';
			}
			?></td>
  </tr>
  <tr>
    <td c align="center" class="bodytext33"><strong><?php echo $companyname; ?></strong>
        <?php
			$strlen3 = strlen($address1);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address1 = ' '.$address1.' ';
			}
			?></td>
  </tr>
  <!--<tr>
    <td align="left" class="bodytext321"><?php echo $address1; ?>
        <?php
			$address2 = $area.''.$city.'  '.$pincode.'';
			$strlen3 = strlen($address2);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address2 = ' '.$address2.' ';
			}
			?></td>
  </tr>-->
  <tr>
    <td width="259" align="center" class="bodytext34">
        <?php
			$address3 = "PHONE: ".$phonenumber1;
			$strlen3 = strlen($address3);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address3 = ' '.$address3.' ';
			}
			?>
	<strong><?php echo $address3; ?></strong>	</td>
    <td width="155" align="left" class="bodytext32">&nbsp;</td>
  </tr>
   <tr>
    <td colspan="2" align="left" class="bodytext32">
        <?php
			$address4 = " E-Mail: ".$emailid1;
			$strlen3 = strlen($address4);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address4 = $address4.' ';
			}
			?>
	<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $address4; ?></strong>	</td>
  </tr>
</table>
<table width="100%"  border="" align="center" cellpadding="0" cellspacing="0">
<tr><td class="" colspan="4" width="375">&nbsp;</td></tr>
	<tr>
    	<td class="bodytext32"  >Name: </td>
		<td colspan="" width="150" class="bodytext34"><?php echo $res11patientfirstname; ?></td>
        <td  class="bodytext32">Bill No: </td>
        <td  class="bodytext34"><?php echo $res11billnumber; ?></td>
	</tr>
    <tr>
    	<td  class="bodytext32">Reg. No: </td>
        <td colspan="" class="bodytext34"><?php echo $res11patientcode; ?></td>
        <td class="bodytext32">Bill Date: </td>
		<td class="bodytext34"><?php echo date("d/m/Y", strtotime($res11transactiontime)); ?></td>
	</tr>
    <tr>
    	<td  class="bodytext32">OPVisit No: </td>
        <td colspan="3" class="bodytext34"><?php echo $res11visitcode; ?></td>
	</tr>
	<tr>
		<td colspan="4">&nbsp;</td>
	</tr>
    </table>
<table width="508" border="0" align="center" cellpadding="0" cellspacing="0">
  
  <tr>
    <td colspan="3" class="bodytext32">&nbsp;</td>
  </tr>
  <tr>
    <td class="bodytext32">&nbsp;</td>
    <td colspan="2"  align="right" class="bodytext32">&nbsp;</td>
  </tr>
  
  <tr>
    <td class="bodytext32">&nbsp;</td>
    <td colspan="2"  align="right" class="bodytext32">&nbsp;</td>
  </tr>
  <tr>
    <td width="162" class="bodytext32" align="left"><strong>Refund Consultation:</strong></td>
    <td colspan="2"  align="right" class="bodytext34"><?php echo $res11transactionamount; ?></td>
  </tr>

  <tr>
    <td >&nbsp;</td>
    <td colspan="2" align="right">&nbsp;</td>
  </tr>
     <?php if($res11cashgivenbycustomer != 0.00) { ?> 	
	<tr>
		<td class="bodytext32"><strong>Cash Received:</strong></td>
		
		<td align="right">&nbsp;</td>
		<td align="right" class="bodytext34"><?php echo number_format($res11cashgivenbycustomer,2,'.',','); ?></td>
	</tr>
	<tr>
		<td width="203" class="bodytext32"><strong>CashReturned:</strong></td>
		<td align="right">&nbsp;</td>
		
		<td align="right" class="bodytext34"><?php echo number_format($res11cashgiventocustomer,2,'.',','); ?><</td>
	</tr>
	<?php } ?>
	<?php if($res11chequeamount != 0.00) { ?> 
	<tr>
		<td width="203" class="bodytext32"><strong>Cheque Amount</strong></td>
		<td align="right">&nbsp;</td>
		
		<td align="right" class="bodytext34"><?php echo number_format($res11chequeamount,2,'.',','); ?></td>
	</tr>
	<?php } ?>
	<?php if($res11onlineamount != 0.00) { ?> 
	<tr>
		<td width="203" class="bodytext32"><strong>Online Amount</strong></td>
		<td align="right">&nbsp;</td>
		
		<td align="right" class="bodytext34"><?php echo number_format($res11onlineamount,2,'.',','); ?></td>
	</tr>
	<?php } ?>
	<?php if($res11cardamount != 0.00) { ?> 
	<tr>
		<td width="203" class="bodytext32"><strong>Credit Amount</strong></td>
		<td align="right">&nbsp;</td>
		
		<td align="right" class="bodytext34"><?php echo number_format($res11cardamount,2,'.',','); ?></td>
	</tr>
	<?php } ?>
	
    <?php if($res11creditamount != 0.00) { ?> 
	<tr>
		<td width="203" class="bodytext32"><strong>MPESA</strong></td>
		<td align="right">&nbsp;</td>
		
		<td align="right" class="bodytext34"><?php echo number_format($res11creditamount,2,'.',','); ?></td>
	</tr>
    <tr>
    <td width="203" class="bodytext32"><strong>MPESA No:</strong></td>
		<td align="right">&nbsp;</td>
		<td align="right" class="bodytext34">&nbsp;<?php echo $mpesanumber; ?></td>
		
	</tr>
	<?php } ?>	


  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="bodytext35"><strong>Kenya Shillings </strong><?php echo str_replace('Kenya Shillings','',$convertedwords); ?></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td  colspan="3" align="right" class="bodytext35"><strong>Served By: </strong><?php echo strtoupper($res11username); ?></td>
  </tr>
  <tr>
    <td  colspan="3" align="right" class="bodytext34"><?php echo strtoupper($res11transactiontime); ?> </td>
  </tr>
</table>
<?php	
$content = ob_get_clean();

// convert in PDF

try
{
$html2pdf = new HTML2PDF('P', 'A5', 'en');
//      $html2pdf->setModeDebug();
$html2pdf->setDefaultFont('Arial');
$html2pdf->writeHTML($content, isset($_GET['vuehtml']));

$html2pdf->Output('print_consultationrefund.pdf');
}
catch(HTML2PDF_exception $e) {
echo $e;
exit;
}
?>
