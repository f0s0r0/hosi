<?php
require_once('html2pdf/html2pdf.class.php');
session_start();
//include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$res20radiologyitemrate = '';
$res2radiologyitemrate = '';
$nettotal = ''; 
$consultationsubtotal = '';
$subtotal = '';
$consultationrefundsubtotal = '';
$labrefundsubtotal = ''; 
$pharmrefundsubtotal = '';
$radiologyrefundsubtotal='';
$servicesrefundsubtotal='';
$referalrefundsubtotal = '';
$labsubtotal ='';
$ambsubtotal ='';
$homesubtotal ='';

ob_start();

include('convert_currency_to_words.php');

$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }

if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }
//echo $billautonumber;


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
$res1emailid1= $res1['emailid1'];

$query44 = "select * from master_customer where locationcode='$locationcode' and customercode = '$patientcode' ";
$exec44 = mysql_query($query44) or die ("Error in Query44".mysql_error());
$num44 = mysql_num_rows($exec44);
$res44 = mysql_fetch_array($exec44);
$res44accountname = $res44['accountname'];

$query5 = "select * from master_accountname where locationcode='$locationcode' and auto_number = '$res44accountname'";
$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
$res5 = mysql_fetch_array($exec5);
$res5accountname = $res5['accountname'];


$query11 = "select * from master_visitentry where locationcode='$locationcode' and patientcode = '$patientcode' and visitcode='$visitcode' ";
$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
$res11 = mysql_fetch_array($exec11);
$res11patientfullname = $res11['patientfullname'];
$res11patientcode = $res11['patientcode'];
$res11visitcode = $res11['visitcode'];
?>
<style type="text/css">
<!--
.bodytext32 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000; 
}
-->
.bodytext313 {FONT-WEIGHT: bold; FONT-SIZE: 12px; vertical-align:text-bottom; 
}
.style1 {vertical-align:text-bottom; font-size: 12px;}
</style>

<table width="742" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="left" valign="center" 
	 bgcolor="#ffffff" class="bodytext32">
	        <?php
			$query3showlogo = "select * from settings_billhospital  where companyanum = '$companyanum'";
			$exec3showlogo = mysql_query($query3showlogo) or die ("Error in Query3showlogo".mysql_error());
			$res3showlogo = mysql_fetch_array($exec3showlogo);
			$showlogo = $res3showlogo['showlogo'];
			if ($showlogo == 'SHOW LOGO')
			{
			?>
				
			<img src="logofiles/<?php echo $companyanum;?>.jpg" width="200" height="50" />
			
			<?php
			}
			?>	 </td>
			
	<td width="321" align="left" valign="center" 
	 bgcolor="#ffffff" class="bodytext32">&nbsp;</td>
    <td width="288" align="left" valign="center" 
	 bgcolor="#ffffff" class="bodytext32"><?php
	echo '<strong>'.$res1companyname.'</strong>';
	//echo '<br>'.$res1address1.' '.$res1area.' '.$res1city;
	//echo '<br>'.$res1pincode;
	echo '<br>PHONE : '.$res1phonenumber1;
    if($res1emailid1 != '')
	 {
	echo '<br>E-Mail : '.$res1emailid1;
	 }
	?></td>
    <td width="17" align="left" valign="center" 
	 bgcolor="#ffffff" class="bodytext32">&nbsp;</td>
  </tr>
  
  <tr>

    <td colspan="4">&nbsp;</td>
  </tr>
  
  <tr>
    <td width="104">
      <strong>Patient Name</strong></td>
	
    <td colspan="3"><strong><?php echo $res11patientfullname; ?></strong></td>
  </tr>
  <tr>
    <td><strong>Reg No</strong></td>
    <td colspan="3"><strong><?php echo $res11patientcode; ?></strong></td>
  </tr>
  <tr>
    <td><strong>Visit No</strong> </td>
    <td colspan="3"><strong><?php echo $res11visitcode; ?></strong></td>
  </tr>
  <tr>
    <td><strong>Account</strong></td>
    <td colspan="3"><strong><?php echo $res5accountname; ?></strong></td>
  </tr>
  
  <tr>
    <td colspan="5">
	 <table width="723" border="0" cellspacing="0" cellpadding="0">
  <tr>
	 <td colspan="6">&nbsp;</td> 
	 </tr>
  <tr>
	<td width="92" align="left" valign="center" 
	 bgcolor="#ffffff" class="bodytext31"><strong>Bill Date</strong></td>
	<td width="101" valign="center" 
	bgcolor="#ffffff" class="bodytext31"><strong>Ref.No</strong></td>
	<td width="256"  align="left" valign="center" 
	bgcolor="#ffffff" class="bodytext31"><strong>Description</strong></td>
	<td width="80"align="center" valign="center" 
	bgcolor="#ffffff" class="bodytext31"><strong>Qty</strong></td>
	<td width="69"  align="right" valign="center" 
	 bgcolor="#ffffff" class="bodytext31"><strong>Rate</strong></td>
	<td width="125"  align="right" valign="center" 
	bgcolor="#ffffff" class="bodytext31"><strong>Amount</strong></td>
  </tr>
    <?php 
  $query11 = "select * from master_billing where locationcode='$locationcode' and patientcode = '$patientcode' and visitcode='$visitcode'";
	$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
	$num11= mysql_num_rows($exec11);
	while($res11 = mysql_fetch_array($exec11))
	 {
	$res11patientfirstname = $res11['patientfirstname'];
	$res11patientcode = $res11['patientcode'];
	$res11visitcode = $res11['visitcode'];
	$res11billnumber = $res11['billnumber'];
	$res11consultationfees = $res11['consultationfees'];
	$res11subtotalamount = $res11['subtotalamount'];
	$res11billingdatetime = $res11['billingdatetime'];
	$consultationsubtotal = $consultationsubtotal + $res11subtotalamount;
	?>  

    <tr>
      <td colspan="6" align="left" valign="center" 
	 bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="6" align="left" valign="center" 
	 bgcolor="#ffffff" class="bodytext31"><strong>Consultation</strong></td>
      </tr>
    <tr>
	<td width="92" align="left" valign="center" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo $res11billingdatetime; ?></td>
	<td width="101" valign="center" 
	bgcolor="#ffffff" class="bodytext31"><?php echo $res11billnumber; ?></td>
	<td width="256"  align="left" valign="center" 
	bgcolor="#ffffff" class="bodytext31">OP Consultation</td>
	<td width="80"align="center" valign="center" 
	bgcolor="#ffffff" class="bodytext31">1</td>
	<td width="69"  align="right" valign="center" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo number_format($res11consultationfees,2,',','.'); ?></td>
	<td width="125"  align="right" valign="center" 
	bgcolor="#ffffff" class="bodytext31"><?php echo number_format($res11subtotalamount,2,',','.'); ?></td>
 </tr> 
  <?php
   }
  ?>
 
	<?php
	$query12 = "select * from refund_consultation where locationcode='$locationcode' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billnumber='$res11billnumber' ";
	$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
	while($res12 = mysql_fetch_array($exec12))
	 {
	$res12patientfirstname = $res12['patientname'];
	$res12patientcode = $res12['patientcode'];
	$res12visitcode = $res12['patientvisitcode'];
	$res12billnumber = $res12['billnumber'];
	$res12consultation = $res12['consultation'];
	$res12billdate= $res12['billdate'];
	$consultationrefundsubtotal = $consultationrefundsubtotal + $res12consultation;
	?>
	<tr>
		<td width="92" align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res12billdate; ?></td>
		<td width="101" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res12billnumber; ?></td>
		<td width="256"  align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext31">Refund</td>
		<td width="80"align="center" valign="center" 
		bgcolor="#ffffff" class="bodytext31">1</td>
		<td width="69"  align="right" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo number_format($res12consultation,2,',','.'); ?></td>
		<td width="125"  align="right" valign="center" 
		bgcolor="#ffffff" class="bodytext31">-<?php echo number_format($res12consultation,2,',','.'); ?></td>
	</tr>
  <?php
   }
  ?>
  <?php $consultationsubtotal = $consultationsubtotal - $consultationrefundsubtotal; ?>
  
  <tr>
    <td colspan="4" align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
    <td align="right" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><strong>Subtotal</strong></td>
    <td align="right" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><strong><?php echo number_format($consultationsubtotal,2,'.',','); ?></strong></td>
  </tr>
  <tr>
    <td colspan="6" align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
  </tr>
  <tr>
	  <td colspan="6" align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><strong>Paynow</strong></td>
	  </tr>
	<?php  
	$query14 = "select * from master_transactionpaynow where locationcode='$locationcode' and patientcode = '$patientcode' and visitcode='$visitcode' and billnumber='$billautonumber' group by visitcode ";
	$exec14 = mysql_query($query14) or die ("Error in Query14".mysql_error());
	while($res14 = mysql_fetch_array($exec14))
	 {
		$res14patientfirstname = $res14['patientname'];
		$res14patientcode = $res14['patientcode'];
		$res14visitcode = $res14['visitcode'];
		$res14billnumber = $res14['billnumber'];
		$res14billingdatetime = $res14['transactiondate'];
		$res14patientpaymentmode = $res14['transactionmode'];
		$res14username = $res14['username'];
		$res14cashamount = $res14['cashamount'];
		$res14transactionamount = $res14['transactionamount'];
		$res14chequeamount = $res14['chequeamount'];
		$res14cardamount = $res14['cardamount'];
		$res14onlineamount= $res14['onlineamount'];
		$res14creditamount= $res14['creditamount'];
		$res14updatetime= $res14['transactiontime'];
		
		$query01 = "select * from billing_paynowlab where locationcode='$locationcode' and patientvisitcode = '$res14visitcode' and patientcode = '$res14patientcode' and billnumber='$res14billnumber' ";
		$exec01 = mysql_query($query01) or die ("Error in Query01".mysql_error());
		while($res01 = mysql_fetch_array($exec01))
		{
		$res01labitemname = $res01['labitemname'];
		$res01labitemrate = $res01['labitemrate'];
		$res01lbilldate= $res01['billdate'];
		$res01lbillnumber= $res01['billnumber'];
		$labsubtotal = $labsubtotal + $res01labitemrate;
    ?>
	
	<tr>
		<td width="92" align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res01lbilldate; ?></td>
		<td width="101" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res01lbillnumber; ?></td>
		<td width="256"  align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res01labitemname; ?></td>
		<td width="80"align="center" valign="center" 
		bgcolor="#ffffff" class="bodytext31">1</td>
		<td width="69"  align="right" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res01labitemrate; ?></td>
		<td width="125"  align="right" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res01labitemrate; ?></td>
	</tr>
	<?php
		} 
		
		$query2 = "select * from billing_paynowradiology where locationcode='$locationcode' and patientvisitcode = '$res14visitcode' and patientcode = '$res14patientcode' and billnumber='$res14billnumber' ";
		$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		while ($res2 = mysql_fetch_array($exec2))
		{
		$res2radiologyitemname = $res2['radiologyitemname'];
		$res2radiologyitemrate = $res2['radiologyitemrate'];
		$res2billdate = $res2['billdate'];
		$res2billnumber = $res2['billnumber'];
		$labsubtotal = $labsubtotal + $res2radiologyitemrate;
    ?>
	
	<tr>
		<td width="92" align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res2billdate; ?></td>
		<td width="101" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res2billnumber; ?></td>
		<td width="256"  align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res2radiologyitemname; ?></td>
		<td width="80"align="center" valign="center" 
		bgcolor="#ffffff" class="bodytext31">1</td>
		<td width="69"  align="right" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res2radiologyitemrate; ?></td>
		<td width="125"  align="right" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res2radiologyitemrate; ?></td>
	</tr>
	
	<?php  
	     }
		$query3 = "select * from billing_paynowservices where locationcode='$locationcode' and patientvisitcode = '$res14visitcode' and patientcode = '$res14patientcode' and billnumber='$res14billnumber' group by servicesitemcode";
		$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	  	$num3 = mysql_num_rows($exec3);
		while($res3 = mysql_fetch_array($exec3))
		{
		$res3servicesitemname= $res3['servicesitemname'];
		$res3servicesitemrate= $res3['servicesitemrate'];
		$res3servicesitemcode = $res3['servicesitemcode'];
		$res3billdate= $res3['billdate'];
		$res3billnumber= $res3['billnumber'];
		
		$res3serviceqty= $res3['serviceqty'];
		
		
		$query2111 = "select * from billing_paynowservices where locationcode='$locationcode' and patientvisitcode='$res11visitcode' and patientcode='$res11patientcode' and billnumber='$res14billnumber' and servicesitemcode = '$res3servicesitemcode'";
		$exec2111 = mysql_query($query2111) or die ("Error in Query2111".mysql_error());
		$numrow2111 = mysql_num_rows($exec2111);
		$res3servicesitemamount = $res3servicesitemrate*$res3serviceqty;
		$labsubtotal = $labsubtotal + $res3servicesitemamount;
    ?>
	
	<tr>
		<td width="92" align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res3billdate; ?></td>
		<td width="101" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res3billnumber; ?></td>
		<td width="256"  align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res3servicesitemname; ?></td>
		<td width="80"align="center" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res3serviceqty; ?></td>
		<td width="69"  align="right" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res3servicesitemrate; ?></td>
		<td width="125"  align="right" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo number_format($res3servicesitemamount,2,'.',''); ?></td>
	</tr>
	
	<?php 
		}
	$query34 = "select * from billing_opambulance where locationcode='$locationcode' and visitcode = '$res14visitcode' and patientcode = '$res14patientcode' and billnumber='$res14billnumber' ";
		$exec34 = mysql_query($query34) or die ("Error in Query34".mysql_error());
	  	$num34 = mysql_num_rows($exec34);
		while($res34 = mysql_fetch_array($exec34))
		{
		$res4description= $res34['description'];
		$res4quantity= $res34['quantity'];
		$res4rate= $res34['rate'];
		$res4amount= $res34['amount'];
		$res4billdate= $res34['recorddate'];
		$res4billnumber= $res34['docno'];
		$labsubtotal = $labsubtotal + $res4amount;
    ?>
	
	<tr>
		<td width="92" align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res4billdate; ?></td>
		<td width="101" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res4billnumber; ?></td>
		<td width="256"  align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res4description; ?></td>
		<td width="80"align="center" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res4quantity; ?></td>
		<td width="69"  align="right" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res4rate; ?></td>
		<td width="125"  align="right" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res4amount; ?></td>
	</tr>
	
	<?php  
	 
		}
	$query334 = "select * from billing_homecare where locationcode='$locationcode' and visitcode = '$res14visitcode' and patientcode = '$res14patientcode' and billnumber='$res14billnumber' ";
		$exec334 = mysql_query($query334) or die ("Error in Query334".mysql_error());
	  	$num334 = mysql_num_rows($exec334);
		while($res334 = mysql_fetch_array($exec334))
		{
		$res4description= $res334['description'];
		$res4quantity= $res334['quantity'];
		$res4rate= $res334['rate'];
		$res4amount= $res334['amount'];
		$res4billdate= $res334['recorddate'];
		$res4billnumber= $res334['docno'];
		$labsubtotal = $labsubtotal + $res4amount;
    ?>
	
	<tr>
		<td width="92" align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res4billdate; ?></td>
		<td width="101" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res4billnumber; ?></td>
		<td width="256"  align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res4description; ?></td>
		<td width="80"align="center" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res4quantity; ?></td>
		<td width="69"  align="right" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res4rate; ?></td>
		<td width="125"  align="right" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res4amount; ?></td>
	</tr>
	
	<?php    
	     }
		$query4 = "select * from billing_paynowpharmacy where locationcode='$locationcode' and patientvisitcode = '$res14visitcode' and patientcode = '$res14patientcode' and billnumber='$res14billnumber' ";
		$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	  	$num4 = mysql_num_rows($exec4);
		while($res4 = mysql_fetch_array($exec4))
		{
		$res4medicinename= $res4['medicinename'];
		$res4quantity= $res4['quantity'];
		$res4rate= $res4['rate'];
		$res4amount= $res4['amount'];
		$res4billdate= $res4['billdate'];
		$res4billnumber= $res4['billnumber'];
		$labsubtotal = $labsubtotal + $res4amount;
    ?>
	
	<tr>
		<td width="92" align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res4billdate; ?></td>
		<td width="101" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res4billnumber; ?></td>
		<td width="256"  align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res4medicinename; ?></td>
		<td width="80"align="center" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res4quantity; ?></td>
		<td width="69"  align="right" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res4rate; ?></td>
		<td width="125"  align="right" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res4amount; ?></td>
	</tr>
	
	<?php  
	     }
		$query6 = "select * from billing_paynowreferal where locationcode='$locationcode' and patientvisitcode = '$res14visitcode' and patientcode = '$res14patientcode' and billnumber='$res14billnumber' ";
		$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
	  	$num6 = mysql_num_rows($exec6);
		while($res6 = mysql_fetch_array($exec6))
		{
		$res6referalname= $res6['referalname'];
		$res6referalrate= $res6['referalrate'];
		$res6billdate= $res6['billdate'];
		$res6billnumber= $res6['billnumber'];
		$labsubtotal = $labsubtotal + $res6referalrate;
    ?>
	
	<tr>
		<td width="92" align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res6billdate; ?></td>
		<td width="101" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res6billnumber; ?></td>
		<td width="256"  align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res6referalname; ?></td>
		<td width="80"align="center" valign="center" 
		bgcolor="#ffffff" class="bodytext31">1</td>
		<td width="69"  align="right" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res6referalrate; ?></td>
		<td width="125"  align="right" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res6referalrate; ?></td>
	</tr>
	
	<?php
		}
	}
	?>
    <?php
	$query134 = "select * from refund_paynowpharmacy where locationcode='$locationcode' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billnumber='$res14billnumber' ";
	$exec134 = mysql_query($query134) or die ("Error in Query13".mysql_error());
	while($res134 = mysql_fetch_array($exec134))
	 {
	$res134billnumber = $res134['billnumber'];
	$res134abitemrate = $res134['rate'];
	$res134amount = $res134['amount'];
	$res134qty = $res134['quantity'];
	$res134abitemname= $res134['medicinename'];
	$res134billdate= $res134['billdate'];
	$pharmrefundsubtotal = $pharmrefundsubtotal + $res134amount;
	?>
	<tr>
		<td width="92" align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res134billdate; ?></td>
		<td width="101" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res134billnumber; ?></td>
		<td width="256"  align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res134abitemname; ?></td>
		<td width="80"align="center" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res134qty; ?></td>
		<td width="69"  align="right" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res134abitemrate; ?></td>
		<td width="125"  align="right" valign="center" 
		bgcolor="#ffffff" class="bodytext31">-<?php echo $res134amount; ?></td>
	</tr>
  <?php
   }
  ?>
    <?php $labsubtotal = $labsubtotal - $pharmrefundsubtotal; ?>
  <?php
	$query13 = "select * from refund_paynowlab where locationcode='$locationcode' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billnumber='$res14billnumber' ";
	$exec13 = mysql_query($query13) or die ("Error in Query13".mysql_error());
	while($res13 = mysql_fetch_array($exec13))
	 {
	$res13billnumber = $res13['billnumber'];
	$res13labitemrate = $res13['labitemrate'];
	$res13labitemname= $res13['labitemname'];
	$res13billdate= $res13['billdate'];
	$labrefundsubtotal = $labrefundsubtotal + $res13labitemrate;
	?>
	<tr>
		<td width="92" align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res13billdate; ?></td>
		<td width="101" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res13billnumber; ?></td>
		<td width="256"  align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res13labitemname; ?></td>
		<td width="80"align="center" valign="center" 
		bgcolor="#ffffff" class="bodytext31">1</td>
		<td width="69"  align="right" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res13labitemrate; ?></td>
		<td width="125"  align="right" valign="center" 
		bgcolor="#ffffff" class="bodytext31">-<?php echo $res13labitemrate; ?></td>
	</tr>
  <?php
   }
  ?>
    <?php $labsubtotal = $labsubtotal - $labrefundsubtotal; ?>
	
  <?php
	$query20 = "select * from refund_paynowradiology where locationcode='$locationcode' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billnumber='$res14billnumber' ";
	$exec20 = mysql_query($query20) or die ("Error in Query20".mysql_error());
	while($res20 = mysql_fetch_array($exec20))
	 {
	$res20radiologyitemrate = $res20['radiologyitemrate'];
	$res20transactiondate= $res20['billdate'];
	$res20billnumber= $res20['billnumber'];
    $res20radiologyitemname =$res20['radiologyitemname'];
	$radiologyrefundsubtotal = $radiologyrefundsubtotal + $res20radiologyitemrate;
	?>
	<tr>
		<td width="92" align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res20transactiondate; ?></td>
		<td width="101" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res20billnumber; ?></td>
		<td width="256"  align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res20radiologyitemname; ?></td>
		<td width="80"align="center" valign="center" 
		bgcolor="#ffffff" class="bodytext31">1</td>
		<td width="69"  align="right" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res20radiologyitemrate; ?></td>
		<td width="125"  align="right" valign="center" 
		bgcolor="#ffffff" class="bodytext31">-<?php echo $res20radiologyitemrate; ?></td>
	</tr>
  <?php
   }
  ?>
    <?php $labsubtotal = $labsubtotal - $radiologyrefundsubtotal; ?>	
	
   <?php
	$query21 = "select * from refund_paynowservices where locationcode='$locationcode' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billnumber='$res14billnumber' ";
	$exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
	while($res21 = mysql_fetch_array($exec21))
	 {
	$res21servicesitemname= $res21['servicesitemname'];
	$res21servicesitemrate = $res21['servicesitemrate'];
	$res21billdate= $res21['billdate'];
	$res21billnumber= $res21['billnumber'];
	$res21serviceqty= $res21['servicequantity'];
	$servicesrefundsubtotal = $servicesrefundsubtotal + ($res21servicesitemrate*$res21serviceqty);
	?>
	<tr>
		<td width="92" align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res21billdate; ?></td>
		<td width="101" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res21billnumber; ?></td>
		<td width="256"  align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res21servicesitemname; ?></td>
		<td width="80"align="center" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res21serviceqty;?></td>
		<td width="69"  align="right" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res21servicesitemrate; ?></td>
		<td width="125"  align="right" valign="center" 
		bgcolor="#ffffff" class="bodytext31">-<?php echo $res21servicesitemrate*$res21serviceqty; ?></td>
	</tr>
  <?php
   }
  ?>
    <?php $labsubtotal = $labsubtotal - $servicesrefundsubtotal; ?>	
	
   <?php
	$query22 = "select * from refund_paynowreferal where locationcode='$locationcode' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billnumber='$res14billnumber' ";
	$exec22 = mysql_query($query22) or die ("Error in Query22".mysql_error());
	while($res22 = mysql_fetch_array($exec22))
	 {
	$res22referalnamee= $res22['referalname'];
	$res22referalrate = $res22['referalrate'];
	$res22billdate= $res22['billdate'];
	$res22billnumber= $res22['billnumber'];
	$referalrefundsubtotal = $referalrefundsubtotal + $res22referalrate;
	?>
	<tr>
		<td width="92" align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res22billdate; ?></td>
		<td width="101" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res22billnumber; ?></td>
		<td width="256"  align="left" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res22referalnamee; ?></td>
		<td width="80"align="center" valign="center" 
		bgcolor="#ffffff" class="bodytext31">1</td>
		<td width="69"  align="right" valign="center" 
		bgcolor="#ffffff" class="bodytext31"><?php echo $res22referalrate; ?></td>
		<td width="125"  align="right" valign="center" 
		bgcolor="#ffffff" class="bodytext31">-<?php echo $res22referalrate; ?></td>
	</tr>
  <?php
   }
  ?>
    <?php $labsubtotal = $labsubtotal - $referalrefundsubtotal; ?>			


<tr>
<td width="92" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext32">    <?php //echo $res18billingdatetime; ?></td>
<td width="101" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext32">    <?php //echo $patientcode; ?></td>
<td width="256" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext32">    <?php //echo 'Copay Amount'; ?></td>
<td width="80" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext32"><?php //echo $res18quantity; ?></td>
<td width="69" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><strong>Subtotal</strong></td>
<td width="125" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><strong><?php echo number_format($labsubtotal,2,'.',','); ?></strong></td>
</tr>
<?php $nettotal = $consultationsubtotal + $labsubtotal; ?>
<tr>
  <td colspan="6" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext32">&nbsp;</td>
  </tr>
<?php 
	//$convertedwords = covert_currency_to_words($nettotal); 
?>
<tr>
  <td colspan="4" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext32">&nbsp;</td>
  <td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><strong>NetTotal</strong></td>
  <td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><strong><?php echo number_format($nettotal,2,'.',','); ?></strong></td>
</tr>

<tr>
  <td colspan="6" class="bodytext32">&nbsp;</td>
</tr>
<tr>
  <td colspan="6" class="bodytext32"><?php //echo $convertedwords; ?></td>
</tr>
<tr>
		<td colspan="6" class="bodytext32">&nbsp;</td>
	    </tr>


<tr>
  <td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><strong>Patient Sign: </strong></td>
  <td colspan="5" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext32">&nbsp;</td>
  </tr>
<tr>
  <td colspan="6" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext32">&nbsp;</td>
  </tr>
</table>	</td>
  </tr>
</table>

<?php
$content = ob_get_clean();
    // convert in PDF
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
//      $html2pdf->setModeDebug();
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('print_paynowsummary.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
	?>


  
	
				  

