<?php
require_once('html2pdf/html2pdf.class.php');
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

	$query6 = "select * from master_company where auto_number = '$companyanum'";
	$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
	$res6 = mysql_fetch_array($exec6);
	$res6companycode = $res6["companycode"];
	
	$query7 = "select * from master_settings where companycode = '$res6companycode' and modulename = 'SETTINGS' and 
	settingsname = 'CURRENT_FINANCIAL_YEAR'";
	$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
	$res7 = mysql_fetch_array($exec7);
	$financialyear = $res7["settingsvalue"];
	$_SESSION["financialyear"] = $financialyear;
	//echo $_SESSION['financialyear'];


if (isset($_REQUEST["billnumber"])) { $billnumber = $_REQUEST["billnumber"]; } else { $billnumber = ""; }

$query1 = "select * from master_company where auto_number = '$companyanum'";
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





    $query11 = "select * from master_transactionexternal where billnumber = '$billnumber' ";
	$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
	mysql_num_rows($exec11);
	$res11 = mysql_fetch_array($exec11);
	 $res11patientname = $res11['patientname'];
	$res11patientcode = $res11['patientcode'];
	$res11visitcode = $res11['visitcode'];
	$res11billnumber = $res11['billnumber'];
	$transactionmode=$res11['transactionmode'];
	//$res11consultationfees = $res11['tr'];
	//$res11subtotalamount = $res11['subtotalamount'];
		 $res11billingdatetime = $res11['transactiondate'];
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
?>

<style type="text/css">
.bodytext32 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000; 
}
.bodytext33 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000;
}
.bodytext34 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000;
}
.bodytext35 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000;
}
.bodytext36 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000;
}
.bodytext37 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000;
}
.bodytext38 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000;
}
.bodytext39 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000;
}
.bodytext40 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000;
}
.bodytext41 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000;
}
.bodytext42 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000;
}
.bodytext43 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000;
}
.bodytext44 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000;
}
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
<table width="538" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <?php 
$query2 = "select * from master_company where auto_number = '$companyanum'";
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
    <td width="135" rowspan="4"><?php
			$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
			$exec3showlogo = mysql_query($query3showlogo) or die ("Error in Query3showlogo".mysql_error());
			$res3showlogo = mysql_fetch_array($exec3showlogo);
			$showlogo = $res3showlogo['showlogo'];
			if ($showlogo == 'SHOW LOGO')
			{
			?>
<!--        <img src="logofiles/<?php echo $companyanum;?>.jpg" width="91" height="80" />
-->        <?php
			}
			?></td>
    <td colspan="2" align="left" class="bodytext33"><?php
			$strlen2 = strlen($companyname);
			$totalcharacterlength2 = 35;
			$totalblankspace2 = 35 - $strlen2;
			$splitblankspace2 = $totalblankspace2 / 2;
			for($i=1;$i<=$splitblankspace2;$i++)
			{
			$companyname = ' '.$companyname.' ';
			}
			?>
        <strong><?php echo $companyname; ?></strong></td>
  </tr>
  <!--<tr>
			<td align="left" class="bodytext32">
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
			<strong><?php echo $address1; ?></strong></td>
		</tr>
		<tr>
		  <td align="left" class="bodytext32">
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
			?>
			<strong><?php echo $address2; ?></strong></td>
  </tr>-->
  <tr>
    <td width="279" align="center" class="bodytext34"><?php
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
        <strong><?php echo $address3; ?></strong></td>
    <td width="124" align="left" class="bodytext32">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left" class="bodytext35"><?php
			$address4 = " E-Mail: ".$emailid1;
			$strlen3 = strlen($address4);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address4 = ' '.$address4.' ';
			}
			?>
        <strong><?php echo $address4; ?></strong></td>
  </tr>
</table>
<table width="514" border="0" cellpadding="0" cellspacing="0" align="center" style="margin-left:-13px;">
  
  <tr>
    <td colspan="5" align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext36"><strong>Bill No: <?php echo $billnumber; ?></strong></td>
    <td colspan="3" align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext36"><strong>Bill Date: <?php echo date("d/m/Y", strtotime($res11billingdatetime)); ?></strong></td>
    <td width="5" align="right" valign="center" 
		bgcolor="#ffffff" class="bodytext36">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext37"><strong><?php echo $res11patientname; ?></strong></td>
  </tr>
 
  <tr>
    <td colspan="5" align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
  </tr>
  <tr>
    
    <td width="279" align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext38"><strong>Description</strong></td>
    <td width="96" align="center" valign="center" 
		bgcolor="#ffffff" class="bodytext38"><strong> Quantity</strong></td>
    <td width="53" align="right" valign="center" 
		bgcolor="#ffffff" class="bodytext38"><strong>Rate</strong></td>
    <td width="86" align="right" valign="center" 
		bgcolor="#ffffff" class="bodytext38"><strong>Amount</strong></td>
  </tr>
  <?php 
  


  
$query33 = "select * from mortuary_billing_services where billno = '$billnumber' group by servicesitemcode ";
$exec33 = mysql_query($query33) or die ("Error in Query33".mysql_error());
while($res33 = mysql_fetch_array($exec33))
 {
$res33description =$res33['servicesitemname'];
$res33quantity=$res33['quantity'];
$res33rate=$res33['servicesitemrate'];

 $res33amount= $res33rate*$res33quantity;
 
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
   
    <td class="bodytext39" valign="center"  align="left"><?php echo $res33description; ?></td>
    <td class="bodytext39" valign="center"  align="center"><?php echo $res33quantity; ?></td>
    <td class="bodytext39" valign="center"  align="right"><?php echo $res33rate; ?></td>
    <td  align="right" valign="center" bgcolor="#ffffff" class="bodytext39"><?php echo $res33amount; ?></td>
  </tr>
  <?php
		 }
		 ?>


  <tr>
   
	 <td>&nbsp;</td>
	  <td>&nbsp;</td>
	   <td>&nbsp;</td>
	    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
    <td  align="left" valign="center" nowrap class="bodytext31">&nbsp;</td>
    <td class="bodytext31" valign="center"  align="center" nowrap="nowrap"><span class="bodytext40"><strong><?php echo 'Net Total'; ?></strong></span></td>
    <td class="bodytext40" valign="center"  align="right"><strong><?php echo number_format($totallab,2,'.',''); ?></strong></td>
    <td class="bodytext40" valign="center"  align="right">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5"  align="left" valign="center" class="bodytext31"><table width="519" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="7">&nbsp;</td>
      </tr>
      <?php
	  if($transactionmode=='CASH')
	  {
	 
	  ?>
      <tr>
        <td class="bodytext41"><strong>Cash Received:</strong></td>
        <td width="184" align="right">&nbsp;</td>
        <td width="67" align="right" class="bodytext41"><strong><?php echo number_format($res11cashgivenbycustomer,2,'.',','); ?></strong></td>
        <td width="67" align="right" class="bodytext41">&nbsp;</td>
      </tr>
      <tr>
        <td width="179" class="bodytext41"><strong>Cash Returned:</strong></td>
        <td align="right">&nbsp;</td>
        <td align="right" class="bodytext41"><strong><?php echo number_format($res11cashgiventocustomer,2,'.',','); ?></strong></td>
        <td align="right" class="bodytext41">&nbsp;</td>
      </tr>
      <?php
	  }
	  ?>
        <?php
	  if($transactionmode=='MPESA')
	  {
	 
	  ?>
      <tr>
        <td class="bodytext41"><strong>Transaction Mode:</strong></td>
        <td width="184" align="right">&nbsp;</td>
        <td width="67" align="right" class="bodytext41"><strong><?php echo $transactionmode ?></strong></td>
        <td width="67" align="right" class="bodytext41">&nbsp;</td>
      </tr>
      
      <?php
	  }
	  ?>
      
      <tr>
      
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" class="bodytext42"><strong><?php echo $convertedwords; ?></strong></td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="right" class="bodytext43"><strong>Served By: <?php echo strtoupper($res11username); ?></strong> </td>
      </tr>
      <tr>
        <td colspan="4" align="right" class="bodytext44"><strong><?php echo strtoupper($res11transactiontime); ?></strong> </td>
      </tr>
    </table></td>
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

  $content = ob_get_clean();

    // convert in PDF
    try
    {
        $html2pdf = new HTML2PDF('P', 'A5', 'en');
//      $html2pdf->setModeDebug();
        //$html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('printexternalbillamb.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>
