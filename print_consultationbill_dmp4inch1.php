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

/*	$query2 = "select * from master_company where locationcode='$locationcode' and auto_number = '$companyanum'";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	$res2 = mysql_fetch_array($exec2);
	$companyname = $res2["companyname"];
	$address1 = $res2["address1"];
	$area = $res2["area"];
	$city = $res2["city"];
	$pincode = $res2["pincode"];
	$phonenumber1 = $res2["phonenumber1"];
	$phonenumber2 = $res2["phonenumber2"];
	$tinnumber1 = $res2["tinnumber"];
	$cstnumber1 = $res2["cstnumber"];*/

	include('convert_currency_to_words.php');
	
	$query11 = "select * from master_billing where billnumber = '$billautonumber' ";
	$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
	mysql_num_rows($exec11);
	$res11 = mysql_fetch_array($exec11);
	$res11patientfirstname = $res11['patientfirstname'];
	$res11patientfullname = $res11['patientfullname'];
	$res11patientcode = $res11['patientcode'];
	$res11visitcode = $res11['visitcode'];
	$res11billnumber = $res11['billnumber'];
	$res11consultationfees = $res11['consultationfees'];
	$res11subtotalamount = $res11['subtotalamount'];
	$convertedwords = covert_currency_to_words($res11subtotalamount);
	$res11billingdatetime = $res11['billingdatetime'];
	$res11patientpaymentmode = $res11['patientpaymentmode'];
	$res11username = $res11['username'];
	$res11cashamount = $res11['cashamount'];
	$res11chequeamount = $res11['chequeamount'];
	$res11cardamount = $res11['cardamount'];
	$res11onlineamount= $res11['onlineamount'];
	$res11creditamount= $res11['creditamount'];
	$res11updatetime= $res11['consultationtime'];
	$res11cashgivenbycustomer = $res11['cashgivenbycustomer'];
	$res11cashgiventocustomer = $res11['cashgiventocustomer'];
	$res11locationcode = $res11['locationcode'];
	
	$department='';
	
	$query01=mysql_query("select departmentname from master_visitentry where patientcode='$res11patientcode' and visitcode='$res11visitcode'");
	if($res01= mysql_fetch_array($query01)){
		$department=$res01['departmentname'];
	}
?>
<style type="text/css">
.bodytext32t {FONT-WEIGHT: bold; FONT-SIZE: 16px; COLOR: #000000; }

.bodytext3 {	FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000; 
}
.bodytext31 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000; 
}
.bodytext311 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000;  text-decoration:none
}
.bodytext365 {FONT-WEIGHT: bold; FONT-SIZE: 14px; COLOR: #000000;  text-decoration:none
}
.bodytext366 {FONT-WEIGHT: bold; FONT-SIZE: 13px; COLOR: #000000;  text-decoration:none
}
.bodytext311 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000; 
}
.bodytext32 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000; 
}
.bodytext33{FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000; }
.bodytext332{FONT-WEIGHT: bold; FONT-SIZE: 25px; COLOR: #000000; }


.bodytext312 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000; 
}
.bodytext30 { FONT-SIZE: 18px; FONT-WEIGHT: bold; COLOR: #000000; }
.bodytext{ text-decoration: underline; line-height:14px}
body {
	background-color: #E0E0E0;
}
table {
   display: table;
   width: 100%;
   table-layout: fixed;
}
body {
	width:421px;
	heigth:595px;
	margin:  auto;
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000;  }
</style>
<body onLoad="window.print()">
<div>
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="5">
	<tr><td colspan="4" width="400">&nbsp;</td></tr>
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
//		$phonenumber2 = $res2["phonenumber2"];
//		$tinnumber1 = $res2["tinnumber"];
//		$cstnumber1 = $res2["cstnumber"];
		$locationname =  $res2["locationname"];
		$prefix = $res2["prefix"];
		$suffix = $res2["suffix"];
?>	
			
<!--			<td colspan="4">
			  <div align="center">
			    <?php
			$strlen2 = strlen($locationname);
			$totalcharacterlength2 = 35;
			$totalblankspace2 = 35 - $strlen2;
			$splitblankspace2 = $totalblankspace2 / 2;
			for($i=1;$i<=$splitblankspace2;$i++)
			{
			$locationname = ' '.$locationname.' ';
			}
			?>			
	        </div></td>-->
 
		<tr>
			<td colspan="4" width="auto" class="bodytext32t" align="center" valign="middle"><?php echo "".$locationname; ?>
		    </td>
		</tr>
        <tr>
			<td colspan="4" width="auto" class="bodytext32t" align="center" valign="top">
			<?php echo "TEL: ".$phonenumber1; ?>
		    </td>
		</tr>
		 <tr>
			<td colspan="4" width="auto" class="bodytext32t" align="center" valign="top">
			<?php echo "Email: ".$emailid1; ?>
		    </td>
		</tr>
		<!--<tr>
			<td colspan="4" class="bodytext32"><div align="center"><?php echo $address1; ?>
		      <?php
		/*	$address2 = $area.''.$city.'  '.$pincode.'';
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


<tr>
<td colspan="4" width="">&nbsp;&nbsp;&nbsp;&nbsp;</td>
</tr>
	<tr>
    <td width="50%" class="bodytext32" >Name : </td>
    <td width="50%" colspan='3'   class="bodytext33" ><?php echo $res11patientfullname; ?></td>
	</tr>
	<tr>
		<td width="50%"  align="left" class="bodytext32" >Reg No: </td>
        <td width="50%"  colspan='3'  align="left" class="bodytext332" ><?php echo $res11patientcode; ?></td>
	</tr>
	<tr>
		<td width="50%"  align="left" class="bodytext32" >Bill No: </td>
        <td width="50%"   align="left" class="bodytext33" ><?php echo $res11billnumber; ?></td>
        <td width="50%" align="left"  class="bodytext32">Bill Date: </td>
        <td width="50%" align="left" class="bodytext33"><?php echo date("d/m/Y", strtotime($res11billingdatetime)); ?></td>
	</tr>


</table>

<table width="100%" border="" align="left" cellpadding="1" cellspacing="1">

	<tr>
		<td width="50%"  align="left" class="bodytext32" colspan="3" >Department: &nbsp;&nbsp; <?php echo $department; ?></td>
	</tr>
  
<tr>
    <td class="bodytext32" width="20%">Consultation Charges:</td>
    <td width="21%" align="right" class="bodytext33"><?php echo number_format($res11subtotalamount,2,'.',','); ?></td>
    <td width="59%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <tr>
    <td class="bodytext32 bodytext" colspan="3"><br />Payment Mode:</td>
  </tr>
  <?php if($res11cashgivenbycustomer != 0.00) { ?> 	
  <tr>
    <td class="bodytext32">Cash Received:</td>
    <td width="21%" align="right" class="bodytext33"><?php echo number_format($res11cashgivenbycustomer,2,'.',','); ?></td>
    <td width="59%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <tr>
    <td class="bodytext32">Cash Returned:</td>
    <td width="21%" align="right" class="bodytext33"><?php echo number_format($res11cashgiventocustomer,2,'.',','); ?></td>
    <td width="59%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
   <?php } ?>
  
  <?php if($res11chequeamount != 0.00) { ?> 	
  <tr>
    <td class="bodytext32">Cheque Amount:</td>
    <td width="21%" align="right" class="bodytext33"><?php echo number_format($res11chequeamount,2,'.',','); ?></td>
    <td width="59%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <?php } ?>
  <?php if($res11creditamount != 0.00) { ?> 
  <tr>
    <td class="bodytext32">MPESA Amount:</td>
    <td width="21%" align="right" class="bodytext33"><?php echo number_format($res11creditamount,2,'.',','); ?></td>
    <td width="59%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
   <?php } ?>
   <?php if($res11cardamount != 0.00) { ?> 
  <tr>
    <td class="bodytext32">Card Amount:</td>
    <td width="21%" align="right" class="bodytext33"><?php echo number_format($res11cardamount,2,'.',','); ?></td>
    <td width="59%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <?php } ?>
  <?php if($res11onlineamount != 0.00) { ?>
  <tr>
    <td class="bodytext32">Online Amount:</td>
    <td width="21%" align="right" class="bodytext33"><?php echo number_format($res11onlineamount,2,'.',','); ?></td>
    <td width="59%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
   <?php } ?>



  
  <tr>
    <td colspan="3" class="bodytext33"><?php echo $convertedwords; ?></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td  colspan="3" align="right" class="bodytext33"><strong>Served By: </strong><?php echo strtoupper($res11username); ?></td>
  </tr>
  <tr>
    <td  colspan="3" width="400" align="right" class="bodytext30"><?php echo date("d/m/Y", strtotime($res11billingdatetime)). "&nbsp;". date('g.i A',strtotime($res11updatetime)); ?> </td>
  </tr>
</table>
</div>
</body>
<?php	
	$content = ob_get_clean();
   
    // convert to PDF
   
    try
    {	
		$width_in_inches = 4.39;
		$height_in_inches = 6.2;
		$width_in_mm = $width_in_inches * 25.4; 
		$height_in_mm = $height_in_inches * 25.4;
		$width_in_mm = 120.39; 
		$height_in_mm = 300.06;		
        $html2pdf = new HTML2PDF('P', array($width_in_mm,$height_in_mm), 'en', true, 'UTF-8', array(0, 0, 0,0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->setDefaultFont('Helvetica');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('print_consultationbill.pdf');
		
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
	
?>

