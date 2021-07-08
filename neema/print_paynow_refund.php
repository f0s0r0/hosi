<?php
require_once('html2pdf/html2pdf.class.php');
ob_start();
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$docno = $_SESSION["docno"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$subtotal = '';
$res19amount1 = ''; 
$res20amount1 = ''; 
$res21amount1 = ''; 
$res22amount1 = '';
$res23amount1 = '';
$res18total  = '';
$colorloopcount = '';
$totallab = 0.00;
$totalradiology = 0.00;
$totalmedicine = 0.00;
$totalservices = 0.00;
$totalreferal = 0.00;
$overalltotal = 0.00;
$sno = 0;
$labrate =0.00;

//$financialyear = $_SESSION["financialyear"];

	

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
$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
// $locationcode;
if (isset($_REQUEST["billnumber"])) { $billnumber = $_REQUEST["billnumber"]; } else { $billnumber = ""; }

if (isset($_REQUEST["patientcode"])) { $patientcode1 = $_REQUEST["patientcode"]; } else { $patientcode1 = ""; }
//echo $billnumber;
if (isset($_REQUEST["visitcode"])) { $visitcode1 = $_REQUEST["visitcode"]; } else { $visitcode1 = ""; }
$query01="select * from paymentmodecredit where billnumber='$billnumber'";
$exe01=mysql_query($query01);
$res01=mysql_fetch_array($exe01);
$mpesanumber=$res01['mpesanumber'];

	$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname ";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	$res1 = mysql_fetch_array($exec1);
	
 	$logolocationname = $res1["locationname"];
	$logolocationcode = $res1["locationcode"];
	$query3 = "select * from master_location where locationcode = '$logolocationcode'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	$res3 = mysql_fetch_array($exec3);
	//$companyname = $res2["companyname"];
	$logoaddress1 = $res3["address1"];
	$logoaddress2 = $res3["address2"];
	//$area = $res2["area"];
	//$city = $res2["city"];
	//$pincode = $res2["pincode"];
	$logoemailid1 = $res3["email"];
	$logophonenumber = $res3["phone"];
	$logolocationcode = $res3["locationcode"];
	//$phonenumber2 = $res2["phonenumber2"];
	//$tinnumber1 = $res2["tinnumber"];
	//$cstnumber1 = $res2["cstnumber"];
	$logolocationname =  $res3["locationname"];
	$logoprefix = $res3["prefix"];
	$logosuffix = $res3["suffix"];
	
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


 $query2 = "select * from master_transactionpaylater where locationcode='".$locationcode."' and billnumber = '$billnumber'";
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

$res2username = strtoupper($res2username);
//$res2cashgiventocustomer = $res2['cashgiventocustomer'];
//$res2cashgivenbycustomer = $res2['cashgivenbycustomer'];

$querylab1=mysql_query("select * from master_customer where locationcode='$locationcode' and customercode='$patientcode1'");
$execlab1=mysql_fetch_array($querylab1);
$res22patientname=$execlab1['customerfullname'];
$res22patientaccount=$execlab1['accountname'];

$query26 = "select * from refund_paynowlab where locationcode='$locationcode' and billnumber = '$billnumber' ";
$exec26 = mysql_query($query26) or die ("Error in Query26".mysql_error());
$res26 = mysql_fetch_array($exec26);
//$res22patientname = $res22['patientname'];
$res26billnumber = $res26['billnumber'];
$res26transactionamount = $res26['labitemrate'];

$res26accountname = $res26['accountname'];
$res26username = $res26['username'];

$query27 = "select * from refund_paynow where locationcode='$locationcode' and billnumber = '$billnumber' ";
$exec27 = mysql_query($query27) or die ("Error in Query27".mysql_error());
$res27 = mysql_fetch_array($exec27);
$res27billnumber = $res27['billnumber'];
$res27transactiontime = $res27['transactiontime'];
$res27transactionmode=$res27['transactionmode'];
$res27accountname = $res27['accountname'];
$res27username = $res27['username'];
$res27transactiondate = $res27['transactiondate'];
$res27username = strtoupper($res27username);
$res26patientcode = $res27['patientcode'];
$res26visitcode = $res27['visitcode'];
$res26patientname = $res27['patientname'];

//$res2cashgiventocustomer = $res2['cashgiventocustomer'];
//$res2cashgivenbycustomer = $res2['cashgivenbycustomer'];

  
$query4 = "select sum(totalamount) as totalamount1 from billing_paylaterconsultation where locationcode='$locationcode' and billno = '$res2billnumber' and visitcode = '$res2visitcode'";
$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
$res4 = mysql_fetch_array($exec4);
$res4totalamount = $res4['totalamount1'];

$query5 = "select sum(amount) as amount1 from billing_paylaterpharmacy where locationcode='$locationcode' and billnumber = '$res2billnumber' and patientvisitcode = '$res2visitcode'";
$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
$res5 = mysql_fetch_array($exec5);
//echo $num = mysql_num_rows($exec5);
$res5amount = $res5['amount1'];

$query8 = "select sum(labitemrate) as labitemrate1 from billing_paylaterlab where locationcode='$locationcode' and billnumber = '$res2billnumber' and patientvisitcode = '$res2visitcode'";
$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
$res8 = mysql_fetch_array($exec8);
$res8labitemrate = $res8['labitemrate1'];

$query9 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_paylaterradiology where locationcode='$locationcode' and billnumber = '$res2billnumber' and patientvisitcode = '$res2visitcode'";
$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
$res9 = mysql_fetch_array($exec9);
$res9radiologyitemrate = $res9['radiologyitemrate1'];

$query10 = "select sum(referalrate) as referalrate1 from billing_paylaterreferal where locationcode='$locationcode' and billnumber = '$res2billnumber' and patientvisitcode = '$res2visitcode'";
$exec10 = mysql_query($query10) or die ("Error in Query10". mysql_error());
$res10 = mysql_fetch_array($exec10);
$res10referalrate = $res10['referalrate1'];

$query11 = "select sum(servicesitemrate) as servicesitemrate1 from billing_paylaterservices where locationcode='$locationcode' and billnumber = '$res2billnumber' and patientvisitcode = '$res2visitcode'";
$exec11 = mysql_query($query11) or die ("Error in Query11". mysql_error());
$res11 = mysql_fetch_array($exec11);
$res11servicesitemrate = $res11['servicesitemrate1'];

$query12 = "select * from master_transactionpaylater where locationcode='$locationcode' and billnumber = '$res2billnumber' and visitcode = '$res2visitcode' and transactiontype = 'paylatercredit'";
$exec12 = mysql_query($query12) or die ("Error in Query12". mysql_error());
$res12 = mysql_fetch_array($exec12);
$res12transactionamount = $res12['transactionamount'];

$query13 = "select * from master_transactionpaylater where locationcode='$locationcode' and billnumber = '$res2billnumber' and visitcode = '$res2visitcode' and transactiontype = 'pharmacycredit'";
$exec13 = mysql_query($query13) or die ("Error in Query13". mysql_error());
$res13 = mysql_fetch_array($exec13);
$res13transactionamount = $res13['transactionamount'];

$query14 = "select * from master_transactionpaylater where locationcode='$locationcode' and billnumber = '$res2billnumber' and visitcode = '$res2visitcode' and transactionmodule = 'PAYMENT'";
$exec14 = mysql_query($query14) or die ("Error in Query14". mysql_error());
$res14 = mysql_fetch_array($exec14);
$res14transactionamount = $res14['transactionamount'];

$credit = $res12transactionamount + $res13transactionamount;

$query200 = "select * from refund_paynowlab where locationcode='$locationcode' and billnumber = '$billnumber' ";
$exec200 = mysql_query($query200) or die ("Error in Query200".mysql_error());

$totalpharm=0;
$phaname = '';

$query25 = "select * from pharmacysalesreturn_details where locationcode='$locationcode' and visitcode='$visitcode1' and patientcode='$patientcode1' and billstatus='pending'";
$exec25 = mysql_query($query25) or die ("Error in Query25".mysql_error());
			while($res25 = mysql_fetch_array($exec25))
			{
			$phadate=$res25['entrydate'];
			$phaname=$res25['itemname'];
			$phaquantity=$res25['quantity'];
			$pharate=$res25['rate'];
			$phaamount=$res25['totalamount'];
			}
			
$query87="select * from master_consultationpharm where locationcode='$locationcode' and patientcode='$patientcode1' and patientvisitcode='$visitcode1' and medicinename='$phaname'";
			$exec87=mysql_query($query87) or die(mysql_error());
			$res87=mysql_fetch_array($exec87);
			$pharefno=$res87['billnumber'];
						 
			 ?>
<script language="javascript">
window.onload = function() {
    if(!window.location.hash) {
        window.location = window.location + '#externalbill';
        window.location.reload();
    }
}

function escapekeypressed()
{
	//alert(event.keyCode);
	if(event.keyCode=='27'){ window.close(); }
}

</script>
<style>
/*.logo {
	font-weight: bold;
	font-size: 18px;
	text-align: center;
}
.bodyhead {
	font-weight: bold;
	font-size: 20px;
	text-align: center;
}
.bodytextbold {
	font-weight: bold;
	font-size: 15px;
	text-align: center;
}
.bodytext {
	font-weight: normal;
	font-size: 15px;
	text-align: center;
	vertical-align: middle;
}
.border {
	border-top: 1px #000000;
	border-bottom: 1px #000000;
}
td {
{
height: 50px;
padding: 5px;
}
table {
	table-layout: fixed;
	width: 100%;
	display: table;
}*/

.bodytext31 { FONT-SIZE: 8px; COLOR: #000000; }
.bodytext32 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000; }
.bodytext35 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; }
.bodytext34 { FONT-SIZE: 10px; COLOR: #000000; vertical-align:bottom;}
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
<body>
<table  align="center" border="" cellpadding="0" cellspacing="0" >
  <tr align="center">
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
    <td rowspan="" align="center" class="logo"><?php
			$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
			$exec3showlogo = mysql_query($query3showlogo) or die ("Error in Query3showlogo".mysql_error());
			$res3showlogo = mysql_fetch_array($exec3showlogo);
			$showlogo = $res3showlogo['showlogo'];
			if ($showlogo == 'SHOW LOGO')
			{
			?>
      
      <!--<img src="logofiles/<?php echo $companyanum;?>.jpg" width="90" height="85" />-->
      
      <?php
			}
			?></td>
    <td colspan="2" align="center" class="bodytext32"><?php
			$strlen2 = strlen($companyname);
			$totalcharacterlength2 = 35;
			$totalblankspace2 = 35 - $strlen2;
			$splitblankspace2 = $totalblankspace2 / 2;
			for($i=1;$i<=$splitblankspace2;$i++)
			{
			$companyname = ' '.$companyname.' ';
			}
			?>
      <?php echo $companyname; 
	  ?></td>
  </tr>
  <!--<tr>
		  <td align="left"  class="bodytext">
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
			<?php echo $address1; ?>
			</td>
  </tr>
		<tr>
		  <td align="left"  class="bodytext">
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
			<?php echo $address2; ?>
			</td>
  </tr>-->
  <tr>
    <td height="" align="center"  class="bodytext32"><?php
			/*$address3 = "PHONE: ".$phonenumber1;
			$strlen3 = strlen($address3);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address3 = ' '.$address3.' ';
			}*/
			?>
      <?php if($logolocationname!=''){  }?></td>
    <td align="center"  class="bodytext32">&nbsp;</td>
  </tr>
  <tr>
    <td height="" colspan="2" align="center"  class="bodytext32"><?php
			/*$address4 = " E-Mail : ".$emailid1;
			$strlen3 = strlen($address4);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address4 = ' '.$address4.' ';
			}*/
			?>
      <?php if($logophonenumber!=''){echo 'TEL:'.$logophonenumber; }?></td>
  </tr>
  <tr>
    <td height="" colspan="2" align="center"  class="bodytext32">
      <?php if($emailid1!=''){echo 'Email:'.$emailid1; }?></td>
  </tr>
</table>
<?php 
  $total = $res4totalamount + $res5amount + $res8labitemrate + $res9radiologyitemrate + $res10referalrate + $res11servicesitemrate;
  $amountdue = $total - $credit; 
  ?>
  <table width="120%"   border=""  cellpadding="2" cellspacing="5">
<tr>
<td class="" colspan="4" width="375">&nbsp;</td>
</tr>
	<tr >
    	<td class="bodytext32" >Name: </td>
		<td colspan="" width="150" class="bodytext34"><?php  echo $res26patientname; ?></td>
        <td  class="bodytext32" align="center" >&nbsp;Bill No: </td>
        <td  class="bodytext34" ><?php echo $billnumber; ?></td>
	</tr>
    <tr>
    	<td  class="bodytext32">Reg. No: </td>
        <td colspan="" class="bodytext34"><?php echo $res26patientcode; ?></td>
        <td class="bodytext32" align="right" > Bill Date: </td>
		<td class="bodytext34" ><?php echo date("d/m/y", strtotime($res27transactiondate)); ?></td>
	</tr>
    <tr>
    	<td  class="bodytext32">OPVisit No: </td>
        <td colspan="3" class="bodytext34"><?php  echo $res26visitcode; ?></td>
	</tr>
	<tr>
		<td colspan="4">&nbsp;</td>
	</tr>
    </table>


<table  border="" cellpadding="0" cellspacing="0" align="left" width="300%">
  
 

  <tr class="bodytext32">
    <td align="center" valign="center" 
	bgcolor="#ffffff" class="bodytextbold">S.No. </td>
    <td align="center" valign="center" 
	bgcolor="#ffffff" class="bodytextbold" width="250">Description</td>
    <td valign="center" bgcolor="#ffffff" align="center" class="bodytextbold">Qty</td>
    <td align="center" valign="center" 
	bgcolor="#ffffff" class="bodytextbold" width="100">Rate</td>
    <td align="center" valign="center" 
	bgcolor="#ffffff" class="bodytextbold" width="100">Amount</td>
  </tr>
  <?php 
			$query201 = "select * from refund_paynowlab where locationcode='$locationcode' and billnumber = '$billnumber' ";
			$exec201 = mysql_query($query201) or die ("Error in Query201".mysql_error());
			while($res201 = mysql_fetch_array($exec201))
			 {
			$labdate=$res201['billdate'];
			$labname=$res201['labitemname'];
			$labrate=$res201['labitemrate'];
			$totallab=$totallab+$labrate; 
			?>
  <tr class="bodytext34">
    <td   valign="center"  align="center"><?php echo $sno=$sno +1 ; ?></td>
    <td  align="center" valign="center" nowrap  width="250" class="bodytext39"><?php echo $labname; ?></td>
    <td class="bodytext39" valign="center"  align="center" nowrap="nowrap">1</td>
    <td class="bodytext39" valign="center"  align="center"><?php echo number_format($labrate,2,'.',','); ?></td>
    <td class="bodytext39" valign="center"  align="center"><?php echo number_format($labrate,2,'.',','); ?></td>
  </tr>
  <?php
			}
			?>
  <?php 
			$query202 = "SELECT * FROM refund_paynowradiology WHERE locationcode='".$locationcode."' AND  billnumber = '".$billnumber."' ";
			$exec202 = mysql_query($query202) or die ("Error in Query202".mysql_error());
			while($res202 = mysql_fetch_array($exec202))
			 {
			$radiologydate=$res202['billdate'];
			$radiologyitemname=$res202['radiologyitemname'];
			$radiologyitemrate=$res202['radiologyitemrate'];
			$totalradiology=$totalradiology+$radiologyitemrate; 
			?>
  <tr>
    <td class="bodytext39"  valign="center"  align="left"><?php echo $sno=$sno +1 ; ?></td>
    <td  align="left" valign="center" nowrap  width="250" class="bodytext39"><?php echo $radiologyitemname; ?></td>
    <td class="bodytext39" valign="center"  align="center" nowrap="nowrap">1</td>
    <td class="bodytext39" valign="center"  align="right"><?php echo number_format($radiologyitemrate,2,'.',','); ?></td>
    <td class="bodytext39" valign="center"  align="right"><?php echo number_format($radiologyitemrate,2,'.',','); ?></td>
  </tr>
  <?php
			}
			?>
  <?php 
  $query78="select locationcode,planname,planpercentage from master_visitentry where patientcode='$patientcode1' and visitcode='$visitcode1'";
$exec78=mysql_query($query78) or die(mysql_error());
$res78=mysql_fetch_array($exec78);
$locationcodeget=$res78['locationcode'];
$plancode=$res78['planname'];
$planpercentage=$res78['planpercentage'];
//get plandetails 
$queryplan = "select forall from master_planname where auto_number='".$plancode."'";
$execplan = mysql_query($queryplan) or die(mysql_error());
$resplan = mysql_fetch_array($execplan);
$forall = $resplan['forall'];

			$query203 = "select * from refund_paynowpharmacy where locationcode='".$locationcode."' AND  billnumber = '$billnumber' ";
			$exec203 = mysql_query($query203) or die ("Error in Query203".mysql_error());
			while($res203 = mysql_fetch_array($exec203))
			 {
			$medicinedate=$res203['billdate'];
			$medicinename=$res203['medicinename'];
			$medicinerate=$res203['rate'];
			$medicineamount=$res203['amount'];
			$medicinequantity = $res203['quantity'];
		    $totalmedicine=$totalmedicine+$medicineamount; 
			if($forall=='yes'){$medicinerate=($medicinerate/100)*$planpercentage;}
			?>
  <tr>
    <td class="bodytext39"  valign="center"  align="left"><?php echo $sno=$sno +1 ; ?></td>
    <td  align="left" valign="center" nowrap  width="250" class="bodytext39"><?php echo $medicinename; ?></td>
    <td class="bodytext39" valign="center"  align="center" nowrap="nowrap"><?php echo $medicinequantity; ?></td>
    <td class="bodytext39" valign="center"  align="right"><?php echo number_format($medicinerate,2,'.',','); ?></td>
    <td class="bodytext39" valign="center"  align="right"><?php echo number_format($medicineamount,2,'.',','); ?></td>
  </tr>
  <?php
			}
			?>
  <?php 
			$query204 = "select * from refund_paynowreferal where locationcode='$locationcode' and billnumber = '$billnumber' ";
			$exec204 = mysql_query($query204) or die ("Error in Query204".mysql_error());
			while($res204 = mysql_fetch_array($exec204))
			 {
			$referaldate=$res204['billdate'];
			$referalname=$res204['referalname'];
			$referalrate=$res204['referalrate'];
			$totalreferal=$totalreferal+$referalrate; 
			?>
  <tr>
    <td class="bodytext39"  valign="center"  align="left"><?php echo $sno=$sno +1 ; ?></td>
    <td  align="left" valign="center" nowrap  width="250" class="bodytext39"><?php echo $referalname; ?></td>
    <td class="bodytext39" valign="center"  align="center" nowrap="nowrap">1</td>
    <td class="bodytext39" valign="center"  align="right"><?php echo number_format($referalrate,2,'.',','); ?></td>
    <td class="bodytext39" valign="center"  align="right"><?php echo number_format($referalrate,2,'.',','); ?></td>
  </tr>
  <?php
			}
			?>
  <?php 
			$query205 = "select * from refund_paynowservices where locationcode='$locationcode' and billnumber = '$billnumber' ";
			$exec205 = mysql_query($query205) or die ("Error in Query205".mysql_error());
			while($res205 = mysql_fetch_array($exec205))
			 {
			$servicedate=$res205['billdate'];
			$servicesitemname=$res205['servicesitemname'];
			$servicesitemrate=$res205['servicesitemrate'];
			$servicesitemqty=$res205['servicequantity'];
			$totalser=$servicesitemrate*$servicesitemqty;
			$totalservices=$totalservices+$totalser; 
			?>
  <tr>
    <td class="bodytext39"  valign="center"  align="left"><?php echo $sno=$sno +1 ; ?></td>
    <td  align="left" valign="center" nowrap  width="250" class="bodytext39"><?php echo $servicesitemname; ?></td>
    <td class="bodytext39" valign="center"  align="center" nowrap="nowrap"><?php echo $servicesitemqty;?></td>
    <td class="bodytext39" valign="center"  align="right"><?php echo number_format($servicesitemrate,2,'.',','); ?></td>
    <td class="bodytext39" valign="center"  align="right"><?php echo number_format($totalser,2,'.',','); ?></td>
  </tr>
  <?php
			}
			?>
  <?php $overalltotal = $totallab + $totalradiology + $totalmedicine + $totalreferal + $totalservices; ?>
  <tr>
    <td class="bodytext31"  valign="center"  align="left"></td>
    <td  align="left" width="250" valign="center" nowrap class="bodytext31">&nbsp;</td>
    <td class="bodytext31" valign="center"  align="left" nowrap="nowrap">&nbsp;</td>
    <td  align="center" valign="center" class="bodytext32">Total:</td>
    <td class="bodytext34" valign="center"  align="center"><?php echo number_format($overalltotal,2,'.',','); ?></td>
  </tr>
  
  <!-- 
		  <?php
	include ('convert_currency_to_words.php');
	$convertedwords = covert_currency_to_words($overalltotal); ?>
-->
  
  <tr>
    <td colspan="5"  align="left"  valign="center" bgcolor="#ffffff"  class="bodytext">&nbsp;</td>
  </tr>
   <tr>
     <td  align="left" valign="center" colspan="2" width="50" class="bodytext32"><strong>MODE:</strong> <?php echo $res27transactionmode;?></td>
     </tr>
     <tr>
<?php if($mpesanumber!='')
{?>
	    <td  align="left" valign="center" colspan="2"  width="50" class="bodytext32"><strong>MPESA NUMBER:</strong> <?php echo $mpesanumber;?></td>
   <?php } ?>  
  </tr>
 
  <tr>
    <td colspan="5"  align="left"  valign="center" bgcolor="#ffffff"  class="bodytext35"><strong>Kenya Shillings: </strong>
	<?php echo $convertedwords; ?></td>
  </tr>
  <tr>
    <td class="bodytext31"  valign="center"  align="left">&nbsp;</td>
    <td  align="left" valign="center" nowrap class="bodytext31">&nbsp;</td>
    <td class="bodytext31" valign="center"  align="left" nowrap="nowrap">&nbsp;</td>
    <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
    <td class="bodytext31" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td class="bodytext31"  valign="center"  align="left">&nbsp;</td>
    <td  align="left" valign="center" nowrap class="bodytext31">&nbsp;
      <?php //echo 'Copay Amount'; ?></td>
    <td class="bodytext32" valign="center"  align="left" nowrap="nowrap">&nbsp;</td>
    <td class="bodytext32" valign="center"  align="left"><?php echo 'Served By:'; ?></td>
    <td class="bodytext34" align="left"><?php echo strtoupper($res27username); ?></td>
  </tr>
  <tr>
    <td class="bodytext31"  valign="center"  align="left">&nbsp;</td>
    <td  align="left" valign="center" nowrap class="bodytext31">&nbsp;
      <?php //echo 'Copay Amount'; ?></td>
    <td class="bodytext31" valign="center"  align="left"><?php //echo 'Served By:'; ?></td>
    <td class="bodytext34" align="left">&nbsp;</td>
    <td align="left" nowrap class=""><?php echo $res27transactiontime; ?></td>
  </tr>
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
 /*$html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->setDefaultFont('Helvetica');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));*/
$html2pdf->Output('print_paynowrefund.pdf');
}
catch(HTML2PDF_exception $e) {
echo $e;
exit;
}
?>
