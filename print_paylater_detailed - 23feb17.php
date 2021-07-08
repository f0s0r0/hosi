<?php
session_start();
//include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$docno=$_SESSION["docno"];
$res21radiologyitemrate = '';
$subtotal = '';
$res19amount1 = ''; 
$res20amount1 = ''; 
$res21amount1 = ''; 
$res22amount1 = '';
$res23amount1 = '';
$res18total  = '';
$res17memberno = '';
$res18copayfixedamount='';

ob_start();

	$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname ";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	$res1 = mysql_fetch_array($exec1);
	
 	$locationname = $res1["locationname"];
	$locationcode = $res1["locationcode"];

//$financialyear = $_SESSION["financialyear"];
	//$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
	
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


if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }
//echo $billautonumber;

		$query3 = "select * from master_location where locationcode = '$locationcode'";
		$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
		$res3 = mysql_fetch_array($exec3);
		//$companyname = $res2["companyname"];
		$address1 = $res3["address1"];
		$address2 = $res3["address2"];
//		$area = $res2["area"];
//		$city = $res2["city"];
//		$pincode = $res2["pincode"];
		$emailid1 = $res3["email"];
		$phonenumber1 = $res3["phone"];
		$locationcode = $res3["locationcode"];
//		$phonenumber2 = $res2["phonenumber2"];
//		$tinnumber1 = $res2["tinnumber"];
//		$cstnumber1 = $res2["cstnumber"];
		$locationname =  $res3["locationname"];
		$prefix = $res3["prefix"];
		$suffix = $res3["suffix"];

	 $query2 = "select * from master_transactionpaylater as ms LEFT JOIN login_locationdetails as mel ON ms.username = mel.username where mel.locationcode='$locationcode' and ms.billnumber = '$billautonumber'";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	$res2 = mysql_fetch_array($exec2);
	$res2patientname = $res2['patientname'];
	$res2patientcode = $res2['patientcode'];
	$res2visitcode = $res2['visitcode'];
	$res2billnumber = $res2['billnumber'];
	$res2transactionamount = $res2['transactionamount'];
	$res2transactiondate = $res2['transactiondate'];
	$res2transactiontime = $res2['transactiontime'];
	$res2transactiontime = explode(":",$res2transactiontime);
	$res2transactionmode = $res2['transactionmode'];
	$res2username = $res2['username'];
	$res2accountname = $res2['accountname'];
	$res2patientname = $res2['patientname'];
	$res2subtype = $res2['subtype'];

	 $querya2 = "select employeename from master_employee where username='$res2username'";
	$execa2 = mysql_query($querya2) or die ("Error in Querya2".mysql_error());
	$resa2 = mysql_fetch_array($execa2);
	$res2username= $resa2['employeename'];
	
	$res2username = strtoupper($res2username);


	
	$querymember = "select planpercentage from master_visitentry where visitcode='$res2visitcode' and patientcode='$res2patientcode'";
	$execmember = mysql_query($querymember) or die ("Error in querymember".mysql_error());
	$resmember = mysql_fetch_array($execmember);
	//$plancount = mysql_num_rows($execmember);
	 $planpercentage = $resmember['planpercentage'];


 $query44 = "select * from master_customer WHERE customercode = '$res2patientcode' ";
$exec44 = mysql_query($query44) or die ("Error in Query44".mysql_error());
$num44 = mysql_num_rows($exec44);
$res44 = mysql_fetch_array($exec44);
$res44accountname = $res44['accountname'];
$res44customerfullname = $res44['customerfullname'];

$query15 = "select * from master_accountname where auto_number = '$res44accountname'";
$exec15 = mysql_query($query15) or die ("Error in Query15".mysql_error());
$res15 = mysql_fetch_array($exec15);
$res15accountname = $res15['accountname'];
$res15accountno = $res15['id'];
  
$query4 = "select sum(totalamount) as totalamount1 from billing_paylaterconsultation where billno = '$res2billnumber' and visitcode = '$res2visitcode'";
$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
$res4 = mysql_fetch_array($exec4);
$res4totalamount = $res4['totalamount1'];

 $querycr = "select * from refund_consultation where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode' ";
	$execcr = mysql_query($querycr) or die ("Error in Querycr".mysql_error());
	$numcr=mysql_num_rows($execcr);
	$rescr = mysql_fetch_array($execcr);
	$rescrconsultation = $rescr['consultation'];
	
	if($planpercentage>0.00){ $concopay=($res4totalamount/100)*$planpercentage; $res4totalamount=$res4totalamount-$concopay;}
	if($numcr>0){ $res4totalamount=$res4totalamount+$rescrconsultation;}

$query5 = "select sum(amount) as amount1 from billing_paylaterpharmacy where billnumber = '$res2billnumber' and patientvisitcode = '$res2visitcode'";
$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
$res5 = mysql_fetch_array($exec5);
//echo $num = mysql_num_rows($exec5);
$res5amount = $res5['amount1'];

$query8 = "select sum(labitemrate) as labitemrate1 from billing_paylaterlab where billnumber = '$res2billnumber' and patientvisitcode = '$res2visitcode'";
$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
$res8 = mysql_fetch_array($exec8);
$res8labitemrate = $res8['labitemrate1'];

$query9 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_paylaterradiology where billnumber = '$res2billnumber' and patientvisitcode = '$res2visitcode'";
$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
$res9 = mysql_fetch_array($exec9);
$res9radiologyitemrate = $res9['radiologyitemrate1'];

$query10 = "select sum(referalrate) as referalrate1 from billing_paylaterreferal where billnumber = '$res2billnumber' and patientvisitcode = '$res2visitcode'";
$exec10 = mysql_query($query10) or die ("Error in Query10". mysql_error());
$res10 = mysql_fetch_array($exec10);
$res10referalrate = $res10['referalrate1'];

$queryopamb = "select sum(rate) as opambrate1 from billing_opambulancepaylater where  visitcode = '$res2visitcode'";
$execopamb = mysql_query($queryopamb) or die ("Error in Queryopamb". mysql_error());
$resopamb = mysql_fetch_array($execopamb);
$resopambrate = $resopamb['opambrate1'];


$queryophom = "select sum(rate) as ophomrate1 from billing_homecarepaylater where  visitcode = '$res2visitcode'";
$execophom = mysql_query($queryophom) or die ("Error in Queryophom". mysql_error());
$resophom = mysql_fetch_array($execophom);
$resophomrate = $resophom['ophomrate1'];

$query10 = "select sum(referalrate) as referalrate1 from billing_paylaterreferal where billnumber = '$res2billnumber' and patientvisitcode = '$res2visitcode'";
$exec10 = mysql_query($query10) or die ("Error in Query10". mysql_error());
$res10 = mysql_fetch_array($exec10);
$res10referalrate = $res10['referalrate1'];

$query11 = "select sum(servicesitemrate) as servicesitemrate1 from billing_paylaterservices where billnumber = '$res2billnumber' and patientvisitcode = '$res2visitcode'";
$exec11 = mysql_query($query11) or die ("Error in Query11". mysql_error());
$res11 = mysql_fetch_array($exec11);
$res11servicesitemrate = $res11['servicesitemrate1'];

$query12 = "select * from master_transactionpaylater where billnumber = '$res2billnumber' and visitcode = '$res2visitcode' and transactiontype = 'paylatercredit'";
$exec12 = mysql_query($query12) or die ("Error in Query12". mysql_error());
$res12 = mysql_fetch_array($exec12);
$res12transactionamount = $res12['transactionamount'];

$query13 = "select * from master_transactionpaylater where billnumber = '$res2billnumber' and visitcode = '$res2visitcode' and transactiontype = 'pharmacycredit'";
$exec13 = mysql_query($query13) or die ("Error in Query13". mysql_error());
$res13 = mysql_fetch_array($exec13);
$res13transactionamount = $res13['transactionamount'];

$query14 = "select * from master_transactionpaylater where billnumber = '$res2billnumber' and visitcode = '$res2visitcode' and transactionmodule = 'PAYMENT'";
$exec14 = mysql_query($query14) or die ("Error in Query14". mysql_error());
$res14 = mysql_fetch_array($exec14);
$res14transactionamount = $res14['transactionamount'];

$querymember = "select * from master_customer where customercode='$res2patientcode'";
$execmember = mysql_query($querymember) or die ("Error in querymember".mysql_error());
while($resmember = mysql_fetch_array($execmember)){
$resmemberno = $resmember['mrdno'];
}
$credit = $res12transactionamount + $res13transactionamount;

$rescreditnote = 0.00;

$querycreditnote = "select * from ip_creditnote where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and locationcode = '$locationcode'";
$execcredit = mysql_query($querycreditnote) or die ("Error in querycreditnote".mysql_error());
while($rescredit = mysql_fetch_array($execcredit)){
$rescredit1 = $rescredit['totalamount'];
$rescreditnote += $rescredit1;
}

$query17 = "select consultationdate from master_visitentry where visitcode='$res2visitcode' and patientcode='$res2patientcode'";
$exec17 = mysql_query($query17) or die ("Error in Query17".mysql_error());
while($res17 = mysql_fetch_array($exec17))
{
$res17consultationdate=$res17['consultationdate'];
}

$res18billingdatetime=$res17consultationdate;
$res19billdate=$res17consultationdate;
$res20billdate=$res17consultationdate;
$res21billdate=$res17consultationdate;
$res22billdate=$res17consultationdate;
$res23billdate=$res17consultationdate;
$res2227billdate=$res17consultationdate;
$res2222billdate=$res17consultationdate;
?>


<style type="text/css">
<!--
.bodytext32 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000; 
}
-->
.bodytext313 {FONT-WEIGHT: bold; FONT-SIZE: 12px; vertical-align:text-bottom; COLOR: #000000; 
}
.bodytext33 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;
}



.bodytext34 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;
}
.bodytext35 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;
}
.border{border-top:1px #000000; border-bottom:1px #000000;}


body{margin:auto; width:100%}

.page_footer{
    display: table;
    text-align: center;
    margin-left: auto;
    margin-right: auto;
}
hr.style8 {
	border-top: 1px dashed #8c8b8b;
	border-bottom: 1px dashed #fff;
}
hr.style8:after {
	content: '';
	display: block;
	margin-top: 2px;
	border-top: 1px solid #8c8b8b;
	border-bottom: 1px solid #fff;
}
hr{
border-top: 1px dashed #8c8b8b;	
	border-bottom: 1px dashed #fff;

}
hr:after {
	content: '';
	display: block;
	margin-top: 2px;
	border-top: 1px solid #8c8b8b;
	border-bottom: 1px solid #fff;
}

</style>

<page pagegroup="new" backtop="12mm" backbottom="20mm" backleft="2mm" backright="3mm">
 <?php  include('print_header_invoice.php'); ?>
    
<page_footer>
 <hr class="style8" />
  <div class="page_footer" >
                   <h4>"WE CARE, GOD HEALS"</h4>
                </div>
    </page_footer>


 <table width="800" border="" cellpadding="0" cellspacing="0" align="center" >
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>

  </table>

  <table width="100%"  cellpadding="0" cellspacing="0" align="center">
  
   <thead>
   
     <tr>
    <td  class="bodytext32" align="left"><strong>Invoice No: </strong></td>
    <td align="left"  colspan="3"><?php echo $billautonumber; ?></td>
	<td class="bodytext32"   align="left"><strong>Bill Date: </strong></td>
	<td   align="left"><?php echo date("d/m/Y", strtotime($res17consultationdate)); ?></td>

  </tr>

  <tr>
    <td class="bodytext32"  align="left"><strong>Name : </strong></td>
    <td  colspan="3"  align="left"><?php echo $res2patientname; ?></td>
    <td  align="left"  class="bodytext32"><strong>Reg No: </strong></td>
    <td  align="left"><?php echo $res2patientcode; ?></td>

  </tr>

  <tr>
  	<td align="left"  class="bodytext32"  valign="middle" ><span style="font-weight: bold">Account: </span></td>
    <td class= "" align="left" valign="middle" colspan="3" width="450"><?php echo nl2br($res15accountname); ?></td>
    <td  align="left" ><span style="font-weight: bold">OP Visit No</span> : </td>
    <td  align="left"><?php echo $res2visitcode; ?></td>

  </tr>
  <tr>
    <td class="bodytext32"  align="left"><strong>Catagory: </strong></td>
    <td align="left"  colspan="3"><?php echo nl2br($res2subtype); ?></td> 
    <td valign="middle"  align="left"  class="bodytext32"><strong>A/c No: </strong> </td> 
     <td  > <?php echo "$res15accountno";?></td>

  </tr>
  <tr>
    <td colspan=""  >&nbsp;</td>
    <td colspan="3"  >&nbsp;</td>
    <td  align="left"  class="bodytext32"><strong>Membership No: </strong></td>
    <td align="left"  colspan=""><?php echo $resmemberno; ?></td> 
  </tr>

  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>

  <tr>
    <td colspan="6" width="725" align="center"><strong><?php echo 'DETAILED INVOICE'; ?></strong></td>
  </tr>

 <tr>
   <td colspan="6" align="left">&nbsp;</td>
   </tr>
  
  <tr>
	<td width="auto" align="left" valign="center" 
	 bgcolor="#ffffff" class="bodytext31 border"><strong>BILL DATE</strong></td>
	<td width="auto" valign="center" 
	bgcolor="#ffffff" class="bodytext31 border"><strong>REF No.</strong></td>
	<td width="auto"  align="left" valign="center" 
	bgcolor="#ffffff" class="bodytext31 border"><strong>DESCRIPTION</strong></td>
	<td width="auto"align="center" valign="center" 
	bgcolor="#ffffff" class="bodytext31 border"><strong>QTY</strong></td>
	<td width="auto"  align="right" valign="center" 
	 bgcolor="#ffffff" class="bodytext31 border"><strong>RATE</strong></td>
	<td width="auto"  align="right" valign="center" 
	bgcolor="#ffffff" class="bodytext31 border"><strong>AMOUNT</strong></td>
  </tr>
  </thead>
  <tbody>
<?php
if($res4totalamount !='')
{
?>
	<tr>
		 <td colspan="6">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="6" class="bodytext31" valign="center"  align="left">
		<strong>Consultation</strong></td>
	</tr>
	
<?php 
$query17 = "select * from master_visitentry where visitcode='$res2visitcode' and patientcode='$res2patientcode'";
$exec17 = mysql_query($query17) or die ("Error in Query17".mysql_error());
while($res17 = mysql_fetch_array($exec17))
{
$res17consultationfee=$res17['consultationfees'];
$res17viscode=$res17['visitcode'];
$res17consultationdate=$res17['consultationdate'];

 $res17planpercentage=$res17['planpercentage'];
  $plannumber = $res17['planname'];
			
			$queryplanname = "select forall from master_planname where auto_number ='".$plannumber."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execplanname = mysql_query($queryplanname) or die ("Error in Queryplanname".mysql_error());
			$resplanname = mysql_fetch_array($execplanname);
		 	$planforall = $resplanname['forall'];

$res17quantity = '1.00';
 $res17total = $res17consultationfee/$res17quantity;
 $copayconsult = ($res17consultationfee/100)*$res17planpercentage;
$copaytotalconsult = $res17total-$copayconsult;
//$res41billdate = $res41bill['billdate'];
?>

<tr>
	<td  align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	<?php echo $res17consultationdate; ?></td>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" ><?php echo $res17viscode; ?></td>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" width="300" ><?php echo 'OP Consultation'; ?></td>
	<td align="center" valign="center" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo $res17quantity; ?></td>
    <td align="right" valign="right" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo number_format($res17consultationfee,2,'.',','); ?></td>
	<td align="right" valign="right" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo number_format($res17total,2,'.',','); ?></td>
</tr>
<?php
if($copayconsult!=0.00){
	
?>

<tr>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"  width="300">
		<?php echo 'Copay Amount'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($copayconsult,2,'.',','); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format(-$copayconsult,2,'.',','); ?></td>
	</tr>
<?php
}
}
?>

<?php 

$query18 = "select * from master_billing where visitcode='$res2visitcode' and patientcode='$res2patientcode'";
$exec18 = mysql_query($query18) or die ("Error in Query1".mysql_error());
while($res18 = mysql_fetch_array($exec18))
{
//$res18billingdatetime=$res18['billingdatetime'];
$res18quantity = '1.00';
$res18billno = $res18['billnumber'];
$res18copayfixedamount = $res18['copayfixedamount'];
$res18total = $res18copayfixedamount/$res18quantity;

if($res18copayfixedamount!=0.00){
	
?>
	<tr>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $res18billingdatetime; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $res18billno; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"  width="300">
		<?php echo 'Copay Fixed Amount'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $res18quantity; ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($res18copayfixedamount,2,'.',','); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format(-$res18total,2,'.',','); ?></td>
	</tr>
<?php 
}
}
	$query11 = "select * from refund_consultation where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode'";
	$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
	$num=mysql_num_rows($exec11);
	$res11 = mysql_fetch_array($exec11);
	$res11billnumber = $res11['billnumber'];
	$consultationrefund = $res11['consultation'];
	$res11transactiondate= $res11['billdate'];
?><?php if($num>'0.00'){?>
	<tr>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $res18billingdatetime; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo $res18billno; ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"  width="300">
		<?php echo 'Consultation Refund'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo '1.00'; ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($consultationrefund,2,'.',','); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($consultationrefund,2,'.',','); ?></td>
	</tr>
    
<?php }

$subtotal = $res17consultationfee-$copayconsult-$res18copayfixedamount+$consultationrefund;
?>

<tr>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	  <?php //echo $res18billingdatetime; ?>	  </td>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	  <?php //echo $patientcode; ?>    </td>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"  width="300">
	  <?php //echo 'Copay Amount'; ?>    </td>
<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">&nbsp;	</td>
<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	<strong><?php echo 'Sub Total:'; ?></strong></td>
<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	<?php echo number_format($subtotal,2,'.',','); ?></td>
</tr>
<?php
}
?>

<?php
if($res5amount != '')
{
?>
<tr>
	<td>
	<strong>Pharmacy</strong>	</td>
</tr>
<?php 
$res19amount1 = '0.00';
$totalcopaypharm='';
$query19 = "select * from billing_paylaterpharmacy where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode' and billnumber = '$billautonumber' and medicinename <> 'DISPENSING'";
$exec19 = mysql_query($query19) or die ("Error in Query19".mysql_error());
$medno=mysql_num_rows($exec19);
while($res19 = mysql_fetch_array($exec19))
{
//$res19billdate = $res19['billdate'];
$res19medicinename = $res19['medicinename'];
$res19quantity = $res19['quantity'];
$res19rate = $res19['rate'];
$res19amount = $res19['amount'];
$res19medicinecode = $res19['medicinecode'];


$query199 = "select * from master_consultationpharm where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode' and medicinecode = '".$res19medicinecode."'";
$exec199 = mysql_query($query199) or die ("Error in Query199".mysql_error());
$res199 = mysql_fetch_array($exec199);
$res199rate = $res199['rate'];
$res199referalno=$res199['refno'];
 $res199amount = $res199['amount'];
$copaypharm = (($res199rate*$res19quantity)/100)*$res17planpercentage;

$resqtymedrate=$res199rate*$res19quantity;
$res19amount1 = $res19amount1 + $resqtymedrate;


?>

<tr>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	  <?php echo $res19billdate; ?></td>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	 <?php echo $res199referalno; ?></td>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"  width="300">
	<?php echo $res19medicinename; ?></td>
	<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	<?php echo $res19quantity; ?></td>
    <td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	 <?php echo number_format($res199rate,2,'.',','); ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	 <?php echo number_format($resqtymedrate,2,'.',','); ?></td>
</tr>
<?php if($planforall=='yes'){ $totalcopaypharm=$totalcopaypharm+$copaypharm;
?>
<tr>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"  width="300">
		<?php echo 'Copay Amount'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($copaypharm,2,'.',','); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format(-$copaypharm,2,'.',','); ?></td>
	</tr>
<?php
}
}
if($medno>0)
{
?>

<tr>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	  <?php echo $res19billdate; ?></td>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	 <?php echo $res199referalno; ?></td>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"  width="300">
	<?php echo "DISPENSING"; ?></td>
	<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	<?php echo 1; ?></td>
    <td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	 <?php echo 0.00; ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	 <?php echo 0.00; $res19amount1=$res19amount1+0;?></td>
     
</tr>
<?php if($planforall=='yes'){$despamount = (30/100)*$res17planpercentage;  $totalcopaypharm=$totalcopaypharm+$despamount;
?>
<tr>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>

		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"  width="300">
		<?php echo 'Copay Amount'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($despamount,2,'.',','); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format(-$despamount,2,'.',','); ?></td>
	</tr>
<?php
}  }?>
<tr>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	 
		<?php //echo $res18billingdatetime; ?>	 </td>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	 
		<?php //echo $patientcode; ?>	</td>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"  width="300">
		<?php //echo 'Copay Amount'; ?>	</td>
<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	<?php //echo $res18quantity; ?></td>
<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	 <strong><?php echo 'Sub Total:'; ?></strong></td>
<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	 <?php echo number_format($res19amount1=$res19amount1-$totalcopaypharm,2,'.',','); ?></td>
</tr>
<?php
}
?>

<?php 
if($res8labitemrate != '')
{
?>
<tr>
	<td>
	<strong>Laboratory</strong>	</td>
</tr>

<?php 
$res20amount1 = '0.00';
$res200labitemratetotal='';
$query20 = "select * from billing_paylaterlab where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode' and billnumber = '$billautonumber'";
$exec20 = mysql_query($query20) or die ("Error in Query20".mysql_error());

while($res20 = mysql_fetch_array($exec20))
{
//$res20billdate = $res20['billdate'];
$res20labitemname = $res20['labitemname'];
$res20quantity = '1.00';
$res20labitemrate = $res20['labitemrate'];
$res20labitemcode = $res20['labitemcode'];
$res20amount = $res20labitemrate/$res20quantity;
$res20amount1 = $res20amount1 + $res20amount;

$query200 = "select * from consultation_lab where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode' and labitemcode = '".$res20labitemcode."'";
$exec200 = mysql_query($query200) or die ("Error in Query200".mysql_error());
$res200 = mysql_fetch_array($exec200);
$res200referalno=$res200['refno'];
 $res200labitemrate = $res200['labitemrate'];
 $res20amount = $res200labitemrate/$res20quantity;
$res200labitemratetotal=$res200labitemratetotal+$res200labitemrate;
 $copaylab = ($res200labitemrate/100)*$res17planpercentage;
?>
<tr>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	<?php echo $res20billdate; ?></td>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	<?php echo $res200referalno; ?></td>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"  width="300">
<?php echo $res20labitemname; ?></td>
	<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo $res20quantity; ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	<?php echo number_format($res20amount,2,'.',','); ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	<?php echo number_format($res200labitemrate,2,'.',','); ?></td>
</tr>
<?php if($planforall=='yes'){?>
<tr>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"  width="300">
		<?php echo 'Copay Amount'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($copaylab,2,'.',','); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format(-$copaylab,2,'.',','); ?></td>
	</tr>
<?php
}
}
?>
<tr>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	 
		<?php //echo $res18billingdatetime; ?>	 </td>
	<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	 
		<?php //echo $patientcode; ?>	</td>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"  width="300">
		<?php //echo 'Copay Amount'; ?>	</td>
<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	<?php //echo $res18quantity; ?></td>
<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	 <strong><?php echo 'Sub Total:'; ?></strong></td>
<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
	 <?php echo number_format($res20amount1,2,'.',','); ?></td>
</tr>
<?php
}
?>

<?php 
if($res9radiologyitemrate != '')
{
?>
<tr>
	<td>
	<strong>Radiology</strong>	</td>
</tr>
<?php 
$res21amount1 = '0.00';
$res211referalratetotal='';
$query21 = "select * from billing_paylaterradiology where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode' and billnumber = '$billautonumber'";
$exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
while($res21 = mysql_fetch_array($exec21))
{
//$res21billdate = $res21['billdate'];
$res21radiologyitemname = $res21['radiologyitemname'];
$res21quantity = '1.00';
$res21radiologyitemrate = $res21['radiologyitemrate'];
$res21radiologyitemcode = $res21['radiologyitemcode'];
$res21amount = $res21radiologyitemrate/$res21quantity;
$res21amount1 = $res21amount1 + $res21amount;

$query211 = "select * from consultation_radiology where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode'  and radiologyitemcode = '".$res21radiologyitemcode."'";
$exec211 = mysql_query($query211) or die ("Error in Query211".mysql_error());
$res211 = mysql_fetch_array($exec211);
$res211referal=$res211['refno'];
$res211referalrate = $res211['radiologyitemrate'];
$res21amount = $res211referalrate/$res21quantity;
$res211referalratetotal = $res211referalratetotal+$res211referalrate;
$copayrad = ($res211referalrate/100)*$res17planpercentage;
?>
<tr>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo $res21billdate; ?></td>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo $res211referal; ?></td>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"  width="300"><?php echo $res21radiologyitemname; ?></td>
<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo $res21quantity; ?></td>
<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo number_format($res21amount,2,'.',','); ?></td>
<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo number_format($res211referalrate,2,'.',','); ?></td>
</tr>
<?php if($planforall=='yes'){?>
<tr>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"  width="300">
		<?php echo 'Copay Amount'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($copayrad,2,'.',','); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format(-$copayrad,2,'.',','); ?></td>
	</tr>
<?php
}
}
?>
<tr>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php //echo $res18billingdatetime; ?></td>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">		<?php //echo $patientcode; ?></td>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"  width="300">		<?php //echo 'Copay Amount'; ?></td>
<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><?php //echo $res18quantity; ?></td>
<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><strong><?php echo 'Sub Total:'; ?></strong></td>
<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo number_format($res21amount1,2,'.',','); ?></td>
</tr>



<?php
}
?>

<?php
if($res10referalrate != '')
{
?>
<tr>
	<td>
<strong>Referral</strong>	</td>
</tr>
<?php 
$res22amount1 = '0.00';
$copayreftotal='';
$query22 = "select * from billing_paylaterreferal where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode' and billnumber = '$billautonumber'";
$exec22 = mysql_query($query22) or die ("Error in Query22".mysql_error());
while($res22 = mysql_fetch_array($exec22))
{
//$res22billdate = $res22['billdate'];
$res22referalname = $res22['referalname'];
$res22quantity = '1.00';
$res22referalrate = $res22['referalrate'];

$res22referalrateamt = $res22['referalamount'];

$res22amount = $res22referalrateamt/$res22quantity;
$res22amount1 = $res22amount1 + $res22amount;

$query222 = "select * from consultation_departmentreferal where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode'";
$exec222 = mysql_query($query222) or die ("Error in Query222".mysql_error());
$res222 = mysql_fetch_array($exec222);
$res222referalno=$res222['refno'];

$copayref = ($res22referalrateamt/100)*$res17planpercentage;


?>

<tr>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo $res22billdate; ?></td>
	
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo $res222referalno; ?></td>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"  width="300">	<?php echo $res22referalname; ?></td>
<td width="auto" align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo $res22quantity; ?></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo number_format($res22referalrateamt,2,'.',','); ?></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo number_format($res22amount,2,'.',','); ?></td>
</tr>
<?php if($planforall=='yes'){ $copayreftotal=$copayreftotal+$copayref;?>
<tr>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"  width="300">
		<?php echo 'Copay Amount'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo "1"; ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($copayref,2,'.',','); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format(-$copayreftotal,2,'.',','); ?></td>
	</tr>
<?php
}
}
?>
<tr>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php //echo $res18billingdatetime; ?>	  </td>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	  <?php //echo $patientcode; ?>    </td>
<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"  width="300">	  <?php //echo 'Copay Amount'; ?>    </td>
<td width="auto" align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php //echo $res18quantity; ?></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<strong><?php echo 'Sub Total:'; ?></strong></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo number_format($res22amount1=$res22amount1-$copayreftotal,2,'.',','); ?></td>
</tr>
<?php
}
?>

<?php
$res222amount1 = '0.00';
if($resopambrate != '')
{
?>
<tr>
	<td>
<strong>OP Ambulance</strong>	</td>
</tr>
<?php 

$copayambtotal='';
$copayopamb='';
$query2227 = "select * from billing_opambulancepaylater where visitcode='$res2visitcode' and patientcode='$res2patientcode' ";
$exec2227 = mysql_query($query2227) or die ("Error in Query2227".mysql_error());
$row = mysql_num_rows($exec2227);
while($res2227 = mysql_fetch_array($exec2227))
{
//$res2227billdate = $res2227['recorddate'];
$res2227referalname = $res2227['description'];
$res2227quantity = $res2227['quantity'];
$res2227referalrate = $res2227['rate'];
$res2227amount = $res2227referalrate*$res2227quantity;
$res222amount1 = $res222amount1 + $res2227amount;

$query2221 = "select * from consultation_departmentreferal where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode'";
$exec2221 = mysql_query($query2221) or die ("Error in Query2221".mysql_error());
$res2221 = mysql_fetch_array($exec2221);
$res2227referalno=$res2221['refno'];

$copayopamb = (($res2227referalrate*$res2227quantity)/100)*$res17planpercentage;


?>

<tr>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo $res2227billdate; ?></td>
	
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo $res2227referalno; ?></td>
<td  width="300" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo $res2227referalname; ?></td>
<td width="auto" align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo $res2227quantity; ?></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo number_format($res2227referalrate,2,'.',','); ?></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo number_format($res2227amount,2,'.',','); ?></td>
</tr>
<?php if($planforall=='yes'){ $copayambtotal=$copayambtotal+$copayopamb;?>
<tr>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"  width="300">
		<?php echo 'Copay Amount'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo "1"; ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($copayopamb,2,'.',','); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format(-$copayambtotal,2,'.',','); ?></td>
	</tr>
<?php
}
}
?>
<tr>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php //echo $res18billingdatetime; ?>	  </td>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	  <?php //echo $patientcode; ?>    </td>
<td  width="300" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	  <?php //echo 'Copay Amount'; ?>    </td>
<td width="auto" align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php //echo $res18quantity; ?></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<strong><?php echo 'Sub Total:'; ?></strong></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo number_format($res222amount1=$res222amount1-$copayambtotal,2,'.',','); ?></td>
</tr>
<?php
}
?>


<?php
$res2222amount1 = '0.00';
if($resophomrate != '')
{
?>
<tr>
	<td>
<strong>Homecare</strong>	</td>
</tr>
<?php 

$copayhomtotal='';
$copayhom='';
$query2222 = "select * from billing_homecarepaylater where visitcode='$res2visitcode' and patientcode='$res2patientcode' ";
$exec2222 = mysql_query($query2222) or die ("Error in Query2222".mysql_error());
while($res2222 = mysql_fetch_array($exec2222))
{
//$res2222billdate = $res2222['recorddate'];
$res2222referalname = $res2222['description'];
$res2222quantity = $res2222['quantity'];
$res2222referalrate = $res2222['rate'];
$res2222amount = $res2222referalrate*$res2222quantity;
$res2222amount1 = $res2222amount1 + $res2222amount;

$query2228 = "select * from consultation_departmentreferal where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode'";
$exec2228 = mysql_query($query2228) or die ("Error in Query2228".mysql_error());
$res2228 = mysql_fetch_array($exec2228);
$res222referalno=$res2228['refno'];

$copayhom = (($res2222referalrate*$res2222quantity)/100)*$res17planpercentage;


?>

<tr>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo $res2222billdate; ?></td>
	
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo $res222referalno; ?></td>
<td  width="300" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo $res2222referalname; ?></td>
<td width="auto" align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo $res2222quantity; ?></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo number_format($res2222referalrate,2,'.',','); ?></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo number_format($res2222amount,2,'.',','); ?></td>
</tr>
<?php if($planforall=='yes'){ $copayhomtotal=$copayhomtotal+$copayhom;?>
<tr>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"  width="300">
		<?php echo 'Copay Amount'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo "1"; ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($copayhom,2,'.',','); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format(-$copayhomtotal,2,'.',','); ?></td>
	</tr>
<?php
}
}
?>
<tr>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php //echo $res18billingdatetime; ?>	  </td>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	  <?php //echo $patientcode; ?>    </td>
<td  width="300" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" >	  <?php //echo 'Copay Amount'; ?>    </td>
<td width="auto" align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php //echo $res18quantity; ?></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<strong><?php echo 'Sub Total:'; ?></strong></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo number_format($res2222amount1=$res2222amount1-$copayhomtotal,2,'.',','); ?></td>
</tr>
<?php
}
?>


<?php
if($res11servicesitemrate != '')
{
?>
<tr>
	<td>
	<strong>Service</strong></td>
</tr>
<?php 
$res23amount1 = '0.00';
$res23servicesitemratetotal='';
$copaysertotal='';
$query23 = "select * from billing_paylaterservices where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode' and billnumber = '$billautonumber' group by servicesitemcode";
$exec23 = mysql_query($query23) or die ("Error in Query23".mysql_error());
while($res23 = mysql_fetch_array($exec23))
{
//$res23billdate = $res23['billdate'];
$res23servicesitemname = $res23['servicesitemname'];
$res23servicesitemrate = $res23['servicesitemrate'];
$res23servicesitemcode = $res23['servicesitemcode'];


 $query2111 = "select * from billing_paylaterservices where  patientvisitcode='$res2visitcode' and patientcode ='$res2patientcode' and servicesitemcode = '$res23servicesitemcode' and billnumber = '$billautonumber'";
$exec2111 = mysql_query($query2111) or die ("Error in Query2111".mysql_error());
$numrow2111 = mysql_num_rows($exec2111);
$resqty = mysql_fetch_array($exec2111);
			 $serqty=$resqty['serviceqty'];
			 $servicesitemrate=$resqty['servicesitemrate'];
			 $seramount=$resqty['amount'];
/*$res23servicesitemamount = $res23servicesitemrate*$numrow2111;*/

$res23servicesitemamount = $seramount;

$res23amount = $res23servicesitemamount;
$res23amount1 = $res23amount1 + $res23amount;

$query233 = "select * from consultation_services where patientvisitcode='$res2visitcode' and patientcode='$res2patientcode' and servicesitemcode = '".$res23servicesitemcode."'";
$exec233 = mysql_query($query233) or die ("Error in Query233".mysql_error());
$res233 = mysql_fetch_array($exec233);
$numrow233 = mysql_num_rows($exec233);
$res233referal=$res233['refno'];

 $res233serviceitemrate = $res233['servicesitemrate'];
$res23servicesitemrate = $res233serviceitemrate;
//$res23servicesitemratetotal1=$res23servicesitemrate*$serqty;
$res23servicesitemratetotal1=$seramount;
$res23servicesitemratetotal = $res23servicesitemratetotal+$res23servicesitemratetotal1;
$copayser = ($res233serviceitemrate/100)*$res17planpercentage;
$copayser1 = (($res233serviceitemrate*$serqty)/100)*$res17planpercentage;
$copaysertotal=$copaysertotal+$copayser1;
?>

<tr>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo $res23billdate; ?></td>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo $res233referal; ?></td>
<td  width="300" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo $res23servicesitemname; ?></td>
<td width="auto" align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo $serqty; ?></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo number_format($res23servicesitemrate,2,'.',','); ?></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo number_format($res23servicesitemratetotal1,2,'.',','); ?></td>
</tr>
<?php if($planforall=='yes'){?>
<tr>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
		<td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"  width="300">
		<?php echo 'Copay Amount'; ?></td>
		<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php  ?></td>
	<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format($copayser,2,'.',','); ?></td>
		<td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">
		<?php echo number_format(-$copayser1,2,'.',','); ?></td>
	</tr>
<?php
}
}
?>
<tr>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	  
		<?php //echo $res18billingdatetime; ?>	  </td>
<td width="auto" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">		<?php //echo $patientcode; ?>    </td>
<td  width="300" align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	
		<?php //echo 'Copay Amount'; ?>    </td>
<td width="auto" align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php //echo $res18quantity; ?></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<strong><?php echo 'Sub Total:'; ?></strong></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">	<?php echo number_format($res23amount1,2,'.',','); ?></td>
</tr>
<?php
}
?>

<?php 

$totalpayable = '';
$grandtotal = '';
$grandtotal = $subtotal + $res19amount1 + $res20amount1 + $res21amount1 + $res22amount1 + $res23amount1+$res222amount1+$res2222amount1;
$totalpayable = $grandtotal - $rescreditnote ;
$totalpayable = number_format($totalpayable,2,'.',',');
$grandtotal = number_format($grandtotal,2,'.',',');
include('convert_currency_to_words.php');
$convertedwords = covert_currency_to_words($totalpayable);
?>
</tbody>
<tr>
  <td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
  <td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
  <td align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
  <td align="center" valign="left" 

	 bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
  <td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
  <td align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
</tr>
<tr>
<td width="400" align="left" colspan="4" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><strong>Kenya Shillings </strong><?php echo str_replace('Kenya Shillings','',$convertedwords); ?></td>

<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><strong>Total Amount:</strong></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo $grandtotal; ?></td>
</tr>
<tr>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" colspan="5" class="bodytext31"><strong>Total Credits:</strong></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo number_format($rescreditnote,2,'.',','); ?></td>
</tr>
<tr>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" colspan="5" class="bodytext31"><strong>Amount Payable:</strong></td>
<td width="auto" align="right" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"><?php echo $totalpayable; ?></td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td width="auto" align="left" valign="middle" 
	 bgcolor="#ffffff" class="bodytext31"><strong>Served By: </strong></td>
<td width="auto" align="left" valign="middle" colspan="5"
	 bgcolor="#ffffff" class="bodytext31"><?php echo strtoupper($res2username); ?></td>
</tr>
<tr>
	<td>&nbsp;	
    </td>
</tr>

            <tr>
				<td align="center" class="underline" colspan="6" valign="middle"><b style="text-decoration:underline">SUMMARY</b><br /><br />
                </td></tr>

            <tr>
                <td colspan="2" align="center"></td>
                <td width="auto" align="left" ><strong>Consultation Amount:</strong></td>
                <td align="right" ><?php echo number_format($res4totalamount,2,'.',','); ?></td>
            </tr>
            <tr>
                <td colspan="2" align="center"></td>
              <td align="left"><strong>Pharmacy Amount:</strong></td>
              <td align="right" ><?php echo number_format($res5amount,2,'.',','); ?></td>
            </tr>
            <tr>
                <td colspan="2" align="center"></td>
              <td align="left"><strong>Lab Amount:</strong></td>
              <td align="right" ><?php echo number_format($res8labitemrate,2,'.',','); ?></td>
            </tr>
            <tr>
                <td colspan="2" align="center"></td>
              <td align="left" ><strong>Radiology Amount:</strong></td>
              <td align="right"><?php echo number_format($res9radiologyitemrate,2,'.',','); ?></td>
            </tr>
            
            <tr>
                <td colspan="2" align="center"></td>
              <td align="left"><strong>Referral Amount:</strong></td>
              <td align="right"><?php echo number_format($res10referalrate,2,'.',','); ?></td>
            </tr>
            <tr>
                <td colspan="2" align="center"></td>
              <td align="left"><strong>Service Amount:</strong></td>
              <td align="right"><?php echo number_format($res11servicesitemrate,2,'.',','); ?></td>
            </tr>
            <tr>
                <td colspan="2" align="center"></td>
              <td align="left"><strong>Credit Notes Amount:</strong></td>
              <td align="right"><?php echo number_format($rescreditnote,2,'.',','); ?></td>
            </tr>
            <tr>
                <td colspan="2" align="center"></td>
                <td colspan="2">
                <hr />
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center"></td>
              <td align="left"><strong>Total Amount</strong></td>
              <td align="right"><?php echo number_format(($res4totalamount+$res5amount+$res8labitemrate+$res9radiologyitemrate+$res10referalrate+$res11servicesitemrate+$rescreditnote),2,'.',','); ?></td>
            </tr>

<tr>
    <td>
    &nbsp;<br /><br /><br />
    </td>
</tr>


<tr >
<td  align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" colspan="2" width="32%"> <b>Billing Clerk </b> 
      <br />
      <br />
      Signature ....................
     </td>
<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"  colspan="2"  width="32%">  <b>Hospital Administrator </b> 
      <br />
      <br />
      Signature .................... 
     </td>
<td align="left" valign="left"  colspan="2"  width="32%" 
	 bgcolor="#ffffff"><strong>Client</strong>
      <br />
      <br />
      Signature ....................    
     </td>
</tr>
<tr>
    <td>
    &nbsp;<br />
    </td>
</tr>

<tr>
<td colspan="6" align="center" width="80%"> <b> 1) All accounts are payable within 30 daysof the date of invoice. 2) 2% interest will be chargedon overdue invoices </b></td>
</tr>

</table>
</page>

<?php 
  $total = $res4totalamount + $res5amount + $res8labitemrate + $res9radiologyitemrate + $res10referalrate + $res11servicesitemrate;
  $amountdue = $total - $credit; 
  ?>
  

<?php
$content = ob_get_clean();

    // convert in PDF
    require_once('html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array(0, 0, 0, 0));
//      $html2pdf->setModeDebug();
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('print_paylater.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
	?>


  
	
				  

