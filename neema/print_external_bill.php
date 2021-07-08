<?php
ob_start();
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$res21radiologyitemrate = '';
$subtotal = '';
$res19amount1 = ''; 
$res20amount1 = ''; 
$res21amount1 = ''; 
$res22amount1 = '';
$res23amount1 = '';
$res18total  = '';
$colorloopcount = '';
$totallab = '';
$sno = 0;
$labrate ='';
$res34labitemrate='';
$res33rate='';
$res33quantity='';

	include('convert_currency_to_words.php');

//$financialyear = $_SESSION["financialyear"];
 	$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
	
	$query6 = "select * from master_company where locationcode='$locationcode' and auto_number = '$companyanum'";
	$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
	$res6 = mysql_fetch_array($exec6);
	$res6companycode = $res6["companycode"];
	
	$query7 = "select * from master_settings where locationcode='$locationcode' and companycode = '$res6companycode' and modulename = 'SETTINGS' and 
	settingsname = 'CURRENT_FINANCIAL_YEAR'";
	$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
	$res7 = mysql_fetch_array($exec7);
	$financialyear = $res7["settingsvalue"];
	$_SESSION["financialyear"] = $financialyear;
	//echo $_SESSION['financialyear'];


if (isset($_REQUEST["billnumber"])) { $billnumber = $_REQUEST["billnumber"]; } else { $billnumber = ""; }

$query1 = "select * from master_company where locationcode='$locationcode' and auto_number = '$companyanum'";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
$res1 = mysql_fetch_array($exec1);
$res1companyname = $res1['companyname'];
$res1address1 = $res1['address1'];
$res1area = $res1['area'];
$res1city = $res1['city'];
$res1state = $res1['state'];
$res1country = $res1['country'];
$res1pincode = $res1['pincode'];
$res1phonenumber1 = $res1['phonenumber1'];

$query28 = "select * from billing_externalpharmacy where locationcode='$locationcode' and billnumber = '$billnumber' ";
$exec28 = mysql_query($query28) or die ("Error in Query28".mysql_error());
$res28 = mysql_fetch_array($exec28);
$res28patientname = $res28['patientname'];
$res28patientcode = $res28['patientcode'];
$res28visitcode = $res28['patientvisitcode'];
$res28billnumber = $res28['billnumber'];
$res28transactiondate = $res28['billdate'];


$query2 = "select * from billing_external where locationcode='$locationcode' and billno = '$billnumber'";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$res2patientname = $res2['patientname'];
$res2patientcode = $res2['patientcode'];
$res2visitcode = $res2['visitcode'];
$res2billnumber = $res2['billno'];
$res2transactionamount = $res2['totalamount'];
$res2billdate = $res2['billdate'];
$res2username = $res2['username'];
$res2username = strtoupper($res2username);


$query26 = "select * from billing_externalpharmacy where locationcode='$locationcode' and billnumber = '$billnumber' ";
$exec26 = mysql_query($query26) or die ("Error in Query26".mysql_error());
$res26 = mysql_fetch_array($exec26);
$res26patientname = $res26['patientname'];
$res26patientcode = $res26['patientcode'];
$res26visitcode = $res26['patientvisitcode'];
$res26billnumber = $res26['billnumber'];
$res26quantity = $res26['quantity'];
$res26rate = $res26['rate'];
$res26transactionamount = $res26['amount'];
$res26transactiondate = $res26['billdate'];
$res26username = $res26['username'];
$res2username = strtoupper($res2username);

    $query11 = "select * from master_transactionexternal where locationcode='$locationcode' and billnumber = '$billnumber' ";
	$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
	mysql_num_rows($exec11);
	$res11 = mysql_fetch_array($exec11);
	 $res11patientfirstname = $res11['patientname'];
	$res11patientcode = $res11['patientcode'];
	$res11visitcode = $res11['visitcode'];
	$res11billnumber = $res11['billnumber'];
	//$res11consultationfees = $res11['tr'];
	//$res11subtotalamount = $res11['subtotalamount'];
	//$res11billingdatetime = $res11['billingdatetime'];
	//$res11patientpaymentmode = $res11['patientpaymentmode'];
    $res11transactiontime = $res11['transactiontime'];
	$res11username = $res11['username'];
	$res11cashamount = $res11['cashamount'];
    $res11transactionamount = $res11['transactionamount'];
	$convertedwords = covert_currency_to_words($res11transactionamount);
	$res11chequeamount = $res11['chequeamount'];
	$res11cardamount = $res11['cardamount'];
	$res11onlineamount= $res11['onlineamount'];
	$res11creditamount= $res11['creditamount'];
	//$res11updatetime= $res11['consultationtime'];
	$res11cashgivenbycustomer = $res11['cashgivenbycustomer'];
	$res11cashgiventocustomer = $res11['cashgiventocustomer'];
	$res11locationcode = $res11['locationcode'];

	$query01="select * from paymentmodedebit where locationcode='$locationcode' and billnumber='$billnumber'";
	$exe01=mysql_query($query01) or die("Error in Query01".mysql_error());
	$res01=mysql_fetch_array($exe01);
	$mpesano=$res01['mpesanumber'];
	$checqueno=$res01['chequecoa'];
	$cahno=$res01['cashcoa'];
	$cardno=$res01['cardcoa'];
	$onlineno=$res01['onlinecoa'];
	
?>


<?php 
$query2 = "select * from master_location where locationcode = '$res11locationcode'";
		$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		$res2 = mysql_fetch_array($exec2);
		//$companyname = $res2["companyname"];
		$address1 = $res2["address1"];
		$address2 = $res2["address2"];
//		$area = $res2["area"];
//		$city = $res2["city"];
//		$pincode = $res2["pincode"];
		$emailid1 = $res2["email"];
		$phonenumber1 = $res2["phone"];
		$locationcode = $res2["locationcode"];
//		$phonenumber2 = $res2["phonenumber2"];
//		$tinnumber1 = $res2["tinnumber"];
//		$cstnumber1 = $res2["cstnumber"];
		$locationname =  $res2["locationname"];
		$prefix = $res2["prefix"];
		$suffix = $res2["suffix"];
?>

<style type="text/css">
.bodytext31 { FONT-SIZE: 14px; COLOR: #000000; }
.bodytext32 {FONT-WEIGHT: bold; FONT-SIZE: 16px; COLOR: #000000; }
.bodytext35 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #000000; }
.bodytext34 { FONT-SIZE: 16px; COLOR: #000000; vertical-align:bottom;}
table {
   display: table;
   width: 100%;
   table-layout: fixed;
   border-collapse:collapse;
}
.tableborder{
   border-collapse:collapse;
   border:1px solid black;}
.bodytext33{FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000; text-decoration:underline;}
border{border:1px solid #000000; }
borderbottom{border-bottom:1px solid #000000;}

</style>
			 
<script language="javascript">
window.onload = function() {
    if(!window.location.hash) {
        window.location = window.location + '#externalbill';
        window.location.reload();
    }
}
</script>

<script language="javascript">

function escapekeypressed()
{
	//alert(event.keyCode);
	if(event.keyCode=='27'){ window.close(); }
}
</script>

<body onkeydown="escapekeypressed()">
<table width="100%"  border="" align="center" cellpadding="0" cellspacing="0">
	<tr><td colspan="" width="375">&nbsp;</td></tr>
		<tr valign="middle">
			<td colspan="" class="bodytext32" align="center" ><?php echo $locationname; ?>
		      <?php
			$strlen3 = strlen($address1);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address1 = ' '.$address1.' ';
			}
			?>
            </td>
            </tr>
            <tr valign="middle">
			<td colspan="" class="bodytext32" align="center" >
				<?php echo "TEL: ".$phonenumber1; ?>
		        <?php
			/*$address3 = "TEL: ".$phonenumber1;
			$strlen3 = strlen($address3);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address3 = ' '.$address3.' ';
			}*/
			?></td>
		</tr>
		<!--<tr>
			<td colspan="4" class="bodytext32"><div align="center"><?php //echo $address1; ?>
		      <?php
/*			$address2 = $area.''.$city.' - '.$pincode.'';
			$strlen3 = strlen($address2);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address2 = ' '.$address2.' ';
			}*/
			?>		
		    </div></td>
		</tr>-->
		

  <!--<tr>
    <td>Consultation Charges:</td>
    <td width="125" align="right"><strong><?php //echo $res11subtotalamount; ?></strong></td>
  </tr>-->
  
</table>


<table width="100%"  border="" align="center" cellpadding="2" cellspacing="2">
<tr><td class="" colspan="4" width="375">&nbsp;</td></tr>
	<tr>
    	<td class="bodytext32" >Name: </td>
		<td colspan="" width="150" class="bodytext34"><?php echo $res11patientfirstname; ?></td>
        <td  class="bodytext32">Bill No: </td>
        <td  class="bodytext34" valign="center"><?php echo $res11billnumber; ?></td>
	</tr>
    <tr>
    	<td  class="bodytext32">Reg. No: </td>
        <td colspan="" class="bodytext34"><?php echo $res11patientcode; ?></td>
        <td class="bodytext32">Bill Date: </td>
		<td class="bodytext34"><?php echo date("d/m/Y", strtotime($res2billdate)); ?></td>
	</tr>
    <tr>
    	<td  class="bodytext32">OPVisit No: </td>
        <td colspan="3" class="bodytext34"><?php echo $res11visitcode; ?></td>
	</tr>
	<tr>
		<td colspan="4">&nbsp;</td>
	</tr>
    </table>

<table width="500" border="0" cellpadding="0" cellspacing="0" align="center" style="margin-left:13px;">
  
  <tr>
    <td colspan="5" align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
  </tr>
 
   <tr>
   
     <td width="20"  align="center" valign="center" 
		bgcolor="#ffffff" class="bodytext32"><strong>S.No</strong></td>
    <td width="80" align="center" valign="center" 
		bgcolor="#ffffff" class="bodytext32"><strong>Description</strong></td>
    <td  width="20" align="center" valign="center" 
		bgcolor="#ffffff" class="bodytext32"><strong>Qty </strong></td>
    <td  width="60" align="center" valign="center" 
		bgcolor="#ffffff" class="bodytext32" ><strong>Rate</strong></td>
    <td  width="60" align="center" valign="center" 
		bgcolor="#ffffff" class="bodytext32" ><strong>Amount</strong></td>
  </tr>
  <?php 
$query33 = "select * from billing_externalpharmacy where locationcode='$locationcode' and billnumber = '$billnumber' ";
$exec33 = mysql_query($query33) or die ("Error in Query33".mysql_error());
while($res33 = mysql_fetch_array($exec33))
 {
$res33medicinename =$res33['medicinename'];
$res33quantity=$res33['quantity'];
$res33rate=$res33['rate'];
$res33amount=$res33['amount'];
$totallab=$totallab+$res33amount;

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
   <td class="bodytext34 " valign="center"  align="center" >
			   <?php echo ++$sno; ?></td>
    <td align="center" valign="center" bgcolor="#ffffff" class="bodytext34" width="80" ><?php echo $res33medicinename; ?></td>
    <td class="bodytext39" valign="center"  align="center"><?php echo $res33quantity; ?></td>
    <td class="bodytext39" valign="center"  align="center"><?php echo $res33rate; ?></td>
    <td  align="center" valign="center" bgcolor="#ffffff" class="bodytext39"><?php echo $res33amount; ?></td>
  </tr>
  <?php
		 }
		 ?>
  <?php 
 $query134 = "select * from billing_externallab where locationcode='$locationcode' and billnumber = '$billnumber' ";
$exec134 = mysql_query($query134) or die ("Error in Query134".mysql_error());
 $count134 = mysql_num_rows($exec134);

while($res134 = mysql_fetch_array($exec134))
 {

$count = mysql_num_rows($exec134);
 $res134labitemname =$res134['labitemname'];
$res134labitemrate=$res134['labitemrate'];
$totallab=$totallab+$res134labitemrate;

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
    <td class="bodytext34 " valign="center"  align="center">
			   <?php echo ++$sno; ?></td>
    <td  align="center" valign="center" bgcolor="#ffffff" class="bodytext34" width="80" ><?php echo $res134labitemname; ?></td>
    <td  align="center" valign="center" bgcolor="#ffffff" class="bodytext34">1</td>
    <td  align="center" valign="center" bgcolor="#ffffff" class="bodytext34"><?php echo $res134labitemrate; ?></td>
    <td  align="center" valign="center" bgcolor="#ffffff" class="bodytext34"><?php echo $res134labitemrate; ?></td>
  </tr>
  <?php
		  }
		 ?>
  <?php 
 $query135 = "select * from billing_externalradiology where locationcode='$locationcode' and billnumber = '$billnumber' ";
$exec135 = mysql_query($query135) or die ("Error in Query135".mysql_error());
while($res135 = mysql_fetch_array($exec135))
 {
$count = mysql_num_rows($exec135);
   if($count>0)
     {
$res135radiologyitemname =$res135['radiologyitemname'];
$res135radiologyitemrate=$res135['radiologyitemrate'];
$totallab=$totallab+$res135radiologyitemrate;

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
  <tr> <td class="bodytext34 " valign="center"  align="center">
			   <?php echo ++$sno; ?></td>
   
    <td  align="center" valign="center" bgcolor="#ffffff" class="bodytext34" width="80" ><?php echo $res135radiologyitemname; ?></td>
    <td  align="center" valign="center" bgcolor="#ffffff" class="bodytext34">1</td>
    <td  align="center" valign="center" bgcolor="#ffffff" class="bodytext34"><?php echo $res135radiologyitemrate; ?></td>
    <td  align="center" valign="center" bgcolor="#ffffff" class="bodytext34"><?php echo $res135radiologyitemrate; ?></td>
  </tr>
  <?php
     }
}
?>
  <?php 
$query136 = "select * from billing_externalservices where locationcode='$locationcode' and billnumber = '$billnumber' ";
$exec136 = mysql_query($query136) or die ("Error in Query136".mysql_error());
while($res136 = mysql_fetch_array($exec136))
 {
$count = mysql_num_rows($exec136);
   if($count>0)
     {
$res136labitemname =$res136['servicesitemname'];
$res136labitemrate=$res136['servicesitemrate'];
$totallab=$totallab+$res136labitemrate;

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
    <td class="bodytext34 " valign="center"  align="center">
			   <?php echo ++$sno; ?></td>
    <td  align="center" valign="center" bgcolor="#ffffff" class="bodytext34" width="80" ><?php echo $res136labitemname; ?></td>
    <td  align="center" valign="center" bgcolor="#ffffff" class="bodytext34">1</td>
    <td  align="center" valign="center" bgcolor="#ffffff" class="bodytext34"><?php echo $res136labitemrate; ?></td>
    <td  align="center" valign="center" bgcolor="#ffffff" class="bodytext34"><?php echo $res136labitemrate; ?></td>
  </tr>
  <?php
     }
}
?>
  <tr>
   
	 <td>&nbsp;</td>
	  <td>&nbsp;</td>
	   <td>&nbsp;</td>
	    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="bodytext31" valign="center"  align="center">&nbsp;</td>
    
    <td class="bodytext32" valign="center"  align="center" nowrap="nowrap"><span class="bodytext32"><strong><?php echo 'Net Total'; ?></strong></span></td>
    <td class="bodytext34" valign="center"  align="center"><strong><?php echo number_format($totallab,2,'.',''); ?></strong></td>
    
  </tr>
      <tr>
        <td colspan="5">&nbsp;</td>
      </tr>
      
     <?php if($res11cashgivenbycustomer != 0.00) { ?> 	
	<tr>
		<td class="bodytext32" colspan="2"><strong>Cash Received:</strong></td>
		<td align="right" class="bodytext32"><?php echo number_format($res11cashgivenbycustomer,2,'.',','); ?></td>
        <td></td>
        <td></td>
	</tr>
	<tr>
		<td  class="bodytext32"  colspan="2"><strong>CashReturned:</strong></td>
			<td align="right" class="bodytext32" ><?php echo number_format($res11cashgiventocustomer,2,'.',','); ?></td>
        <td></td>
        <td></td>
	</tr>
	<?php } ?>
	<?php if($res11chequeamount != 0.00) { ?> 
	<tr>
		<td  class="bodytext32"  colspan="2"><strong>Cheque Amount</strong></td>
		<td align="right" class="bodytext32"><?php echo number_format($res11chequeamount,2,'.',','); ?></td>
        <td></td>
        <td></td>
	</tr>
	<?php } ?>
	<?php if($res11onlineamount != 0.00) { ?> 
	<tr>
		<td  class="bodytext32"  colspan="2"><strong>Online Amount</strong></td>
		<td align="right" class="bodytext32"><?php echo number_format($res11onlineamount,2,'.',','); ?></td>
        <td></td>
        <td></td>
	</tr>
	<?php } ?>
	<?php if($res11cardamount != 0.00) { ?> 
	<tr>
		<td  class="bodytext32"  colspan="2"><strong>Card Amount</strong></td>
		<td align="right" class="bodytext32"><?php echo number_format($res11cardamount,2,'.',','); ?></td>
        <td></td>
        <td></td>
	</tr>
	<?php } ?>
	
    <?php
	 if($res11creditamount != 0.00) { ?> 
	<tr>
		<td class="bodytext32"  colspan="2"><strong>MPESA</strong></td>
		<td align="right" class="bodytext34"  ><?php echo number_format($res11creditamount,2,'.',','); ?></td>
        <td></td>
        <td></td>
        </tr>
        <tr>
         <?php if($mpesano!=''){ ?>
        <td colspan="5" class="bodytext35"><strong>MPESA No:&nbsp;</strong><?php echo $mpesano; ?></td>
        <?php } ?>
	</tr>
	<?php } ?>		   
      <tr>
        <td colspan="5">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" class="bodytext35" width="300" ><strong>Kenya Shillings </strong><?php echo str_replace('Kenya Shillings','',$convertedwords); ?></td>
		<td></td>
      </tr>
      <tr>
        <td colspan="5">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="right" class="bodytext35"><strong>Served By:</strong>  <?php echo strtoupper($res11username); ?></td>
        <td></td>
      </tr>
      <tr>
        <td colspan="4" align="right" class="bodytext34"><?php echo strtoupper($res11transactiontime); ?></td>
        <td></td>
      </tr>
  
  
  <!--<tr>
     <td align="right" colspan="2">Cheque Amount:</td>
    <td width="125" align="right"><?php echo number_format($res11chequeamount,2,'.',','); ?></td>
  </tr>
  
   <tr>
     <td align="right" colspan="2">MPESA Amount:</td>
    <td width="125" align="right"><?php echo number_format($res11creditamount,2,'.',','); ?></td>
  </tr>
  <tr>
    <td align="right" colspan="2">Card Amount:</td>
    <td width="125" align="right"><?php echo number_format($res11cardamount,2,'.',','); ?></td>
  </tr>
  <tr>
    <td align="right" colspan="2">Online Amount:</td>
    <td width="125" align="right"><?php echo number_format($res11onlineamount,2,'.',','); ?></td>
  </tr>-->
</table>

<?php
require_once('html2pdf/html2pdf.class.php');

	$content = ob_get_clean();   
    // convert to PDF
    try
    {	
		$width_in_inches = 4.38;
		$height_in_inches = 6.120;

		$width_in_mm = $width_in_inches * 25.4; 
		$height_in_mm = $height_in_inches * 25.4;
        $html2pdf = new HTML2PDF('P', array($width_in_mm,$height_in_mm), 'en', true, 'UTF-8', array(0, 0, 0,0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->setDefaultFont('Helvetica');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('printexternalbill.pdf');
		
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }


/*require_once("dompdf/dompdf_config.inc.php");
$html =ob_get_clean();
$dompdf = new DOMPDF();
$dompdf->load_html($html);
//$dompdf->set_paper("A4",);
$width_in_inches = 4.38;
$height_in_inches = 6.120;
$width_in_mm = $width_in_inches * 25.4; 
$height_in_mm = $height_in_inches * 25.4;
$dompdf->set_paper(array(0, 0, $width_in_inches, $height_in_inches), 'portrait');
$dompdf->render();
$canvas = $dompdf->get_canvas();

//$canvas->line(10,800,800,800,array(0,0,0),1);
$font = Font_Metrics::get_font("Arial", "normal");
$canvas->page_text(272, 814, "Page {PAGE_NUM}/{PAGE_COUNT}", $font, 10, array(0,0,0,0));
$dompdf->stream("printexternalbill.pdf", array("Attachment" => 0));
*/?>