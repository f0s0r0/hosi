<?php
require_once('html2pdf/html2pdf.class.php');
ob_start();
session_start();
error_reporting(0);
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$docno = $_SESSION['docno'];

//header location
	$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname ";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	$res1 = mysql_fetch_array($exec1);
	
 	$locationname = $res1["locationname"];
	$locationcode = $res1["locationcode"];
	$query3 = "select * from master_location where locationcode = '$locationcode'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	$res3 = mysql_fetch_array($exec3);
	//$companyname = $res2["companyname"];
	$address1 = $res3["address1"];
	$address2 = $res3["address2"];
	//$area = $res2["area"];
	//$city = $res2["city"];
	//$pincode = $res2["pincode"];
	$emailid1 = $res3["email"];
	$phonenumber1 = $res3["phone"];
	$locationcode = $res3["locationcode"];
	//$phonenumber2 = $res2["phonenumber2"];
	//$tinnumber1 = $res2["tinnumber"];
	//$cstnumber1 = $res2["cstnumber"];
	$locationname =  $res3["locationname"];
	$prefix = $res3["prefix"];
	$suffix = $res3["suffix"];

$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';

$query1 = "select * from master_transactionpaylater where transactionstatus = 'onaccount' group by docno order by auto_number desc";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
$rowcount1 = mysql_num_rows($exec1);
if ($rowcount1 == 0)
{
	echo 'Sorry. No Receipt Entry To Print.';
	exit;
}   

	include('convert_currency_to_words.php');
	
	if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }
//$billautonumber = $_REQUEST["billautonumber"];

if (isset($_REQUEST["copy1"])) { $copy1 = $_REQUEST["copy1"]; } else { $copy1 = ""; }
//$copy1 = $_REQUEST['copy1'];
if (isset($_REQUEST["title1"])) { $title1 = $_REQUEST["title1"]; } else { $title1 = ""; }
//$title1 = $_REQUEST['title1'];

$query2 = "select * from settings_billhospital where companyanum = '$companyanum'";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);

	$f1 = $res2['f1'];
	$f2 = $res2['f2'];
	$f3 = $res2['f3'];
	$f4 = $res2['f4'];
	$f5 = $res2['f5'];
	$f6 = $res2['f6'];
	$f7 = $res2['f7'];
	$f8 = $res2['f8'];
	$f9 = $res2['f9'];
	$f10 = $res2['f10'];
	$f11 = $res2['f11'];
	$f12 = $res2['f12'];
	$f13 = $res2['f13'];
	$f14 = $res2['f14'];
	$f15 = $res2['f15'];
	$f16 = $res2['f16'];
	$f17 = $res2['f17'];
	$f18 = $res2['f18'];
	$f19 = $res2['f19'];
	$f20 = $res2['f20'];
	$f21 = $res2['f21'];
	$f22 = $res2['f22'];
	$f23 = $res2['f23'];
	$f24 = $res2['f24'];
	$f25 = $res2['f25'];
	$f26 = $res2['f26'];
	$f27 = $res2['f27'];
	$f28 = $res2['f28'];
	$f29 = $res2['f29'];
	$f30 = $res2['f30'];
	$f31 = $res2['f31'];
	$f32 = $res2['f32'];
	$f9size = $res2['f9size'];
	$f27size = $res2['f27size'];
	$f28size = $res2['f28size'];
	$letterheadprinting = $res2['letterheadprinting'];


//$query21 = "select auto_number from master_sales where auto_number = '$res22anum' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";
if (isset($_REQUEST["receiptanum"])) { $receiptanum = $_REQUEST["receiptanum"]; } else { $receiptanum = ""; }
$receiptanum = $_REQUEST['receiptanum'];
if ($receiptanum != '')
{
	 $query21 = "select * from master_transactionpaylater where transactionstatus = 'onaccount' and auto_number = '$receiptanum'";
}
else
{
	 $query21 = "select * from master_transactionpaylater where transactionstatus = 'onaccount' order by auto_number desc";
}
$exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
$res21 = mysql_fetch_array($exec21);
$res21anum = $res21['auto_number'];
$res21receivedfrom = $res21['accountname'];
$res21docnumber = $res21['docno'];
$res21remarks = $res21['remarks'];
$res21refrenceno = $res21['accountcode'];
$res21username = $res21['username'];

$res21date = $res21["transactiondate"];
$billtime = substr($res21date, 11, 8);
$billdateonly = substr($res21date, 0, 10);
$dotarray = explode("-", $billdateonly);
$dotyear = $dotarray[0];
$dotmonth = $dotarray[1];
$dotday = $dotarray[2];
$dbdateday = strtoupper(date("d-M-Y", mktime(0, 0, 0, $dotmonth, $dotday, $dotyear)));

//$billdate = $dbdateday.' '.$billtime;
$billdate = $dbdateday;//.' '.$billtime;
//$customeranum = $res21['customeranum'];
 $transactionmode = $res21['transactionmode'];
 $refnum=$res21['refrenceno'];
if ($transactionmode == 'CASH')

{
	$mode="CASH";
	$amount = $res21['cashamount'];
        $res11cashgivenbycustomer = $amount;
}
if ($transactionmode == 'CHEQUE')
{
	$mode="CHEQUE";
	$amount = $res21['chequeamount'];
	$chequenum=$res21['chequenumber'];
	$chequedat=$res21['chequedate'];
	$bank=$res21['bankname'];
}
if ($transactionmode == 'ONLINE')
{
	$mode="ONLINE";
	$amount = $res21['onlineamount'];
}
if ($transactionmode == 'CARD')
{
	$mode="CARD";
	$amount = $res21['cardamount'];
}
if ($transactionmode == 'MPESA')
{
	$mode="MPESA";
	$amount = $res21['mpesaamount'];
	$mpesanum=$res21['mpesanumber'];
}
$remarks = $res21['remarks'];
$transactionmode = $res21['transactionmode'];
if ($transactionmode == 'CHEQUE')
{
	$chequenumber = $res21['chequenumber'];
	$chequedate = $res21['chequedate'];
	$transactionmode = 'Cheque No.'.$chequenumber.' Dated '.$chequedate;
}
$transactionmode = 'By '.$transactionmode;


$convertedwords=covert_currency_to_words($amount);


	
?>
<style type="text/css">
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
.bodytext32 {FONT-WEIGHT: bold; FONT-SIZE: 12px; COLOR: #000000; 
}
.bodytext33{ FONT-SIZE: 13px; COLOR: #000000; }
.bodytext312 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000; 
}
.bodytext30 { FONT-SIZE: 9px; COLOR: #000000; }
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
<style>
.bodytexthead {FONT-WEIGHT: bold; FONT-SIZE: 20px; COLOR: #000000; font-family: Times;}
.bodytextaddress {FONT-WEIGHT: bold; FONT-SIZE: 19px; COLOR: #000000; font-family: Times;}
.style1 {font-size: 24px}
</style>
<div>
<table width="auto" border="0" cellpadding="0" cellspacing="0" align="center">

  <tr>
    <td width="100" rowspan="4"  align="left" valign="top" 
	 bgcolor="#ffffff" class="bodytext31">
      
      <?php
			$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
			$exec3showlogo = mysql_query($query3showlogo) or die ("Error in Query3showlogo".mysql_error());
			$res3showlogo = mysql_fetch_array($exec3showlogo);
			$showlogo = $res3showlogo['showlogo'];
			if ($showlogo == 'SHOW LOGO')
			{ 
			?>
      
      <img src="logofiles/<?php echo $companyanum; ?>.jpg" width="164" height="101" />
      
      <?php
			}
			?>	</td>
            <td width="431" align="center" valign="bottom" 
	 bgcolor="#ffffff" class="bodytexthead style1"><?php echo $companyname; ?></td>
  </tr>
    <tr>
      <td align="center" valign="top" 
	 bgcolor="#ffffff" class="bodytextaddress"><?php echo $address1; ?></td>
    </tr>
    <tr>
	<td align="center" valign="top" 
	 bgcolor="#ffffff" class="bodytextaddress">
	<?php
	if($phonenumber1 != '')
	 {
	echo '<strong class="bodytextaddress"> Tel : '.$phonenumber1.'</strong>';
	 }
	 ?></td>
  </tr>
  <tr>
	<td align="center" valign="top" 
	 bgcolor="#ffffff" class="bodytextaddress">
	<?php
	if($emailid1 != '')
	 {
	echo '<strong class="bodytextaddress"> Email : '.$emailid1.'</strong>';
	 }
	 ?></td>
  </tr>
</table>


<table width="100%" border="" align="center" cellpadding="1" cellspacing="1">
  <tr>
  <td class="bodytext32" width="20%">&nbsp;</td>
  <td class="bodytext32" width="20%">&nbsp;</td>
  <td class="bodytext32" width="20%">&nbsp;</td>
  
  </tr>
<tr>
  <td class="bodytext32" width="20%">&nbsp;</td>
  <td class="bodytext32" width="20%">&nbsp;</td>
  <td class="bodytext32" width="20%">&nbsp;</td>
  
  </tr>
<tr>
    <td class="bodytext32" width="10%">Name:</td>
    <td width="21%" align="left" class="bodytext33"><?php echo $res21receivedfrom; ?></td>
    <td width="59%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    
  </tr>
<tr>
    <td class="bodytext32" width="10%">Doc Number:</td>
    <td width="21%" align="left" class="bodytext33"><?php echo $res21docnumber; ?></td>
    <td width="59%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    
  </tr>
<tr>
    <td class="bodytext32" width="10%">Date:</td>
    <td width="21%" align="left" class="bodytext33"><?php echo $res21date; ?></td>
    <td width="59%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    
  </tr>
<tr>
    <td class="bodytext32" width="10%">Reference Number:</td>
    <td width="21%" align="left" class="bodytext33"><?php echo $refnum; ?></td>
    <td width="59%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    
  </tr>
  <tr>
    <td class="bodytext32 bodytext" width="10%">Payment &nbsp;Mode:</td>
     <td width="12%" align="left" class="bodytext33"><?php echo $mode; ?></td>
      <td class="bodytext32" width="20%">&nbsp;</td>
  </tr>
  <?php if($res11cashgivenbycustomer != 0.00) { ?> 	
  <tr>
    <td class="bodytext32">Cash Amount:</td>
    <td width="21%" align="left" class="bodytext33"><?php echo number_format($amount,2,'.',','); ?></td>
    <td width="59%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
  
   <?php } ?>
  
  <?php if($mode == "CHEQUE") { ?> 
   <tr>
    <td class="bodytext32">Cheque Datet:</td>
    <td width="21%" align="left" class="bodytext33"><?php echo $chequedat ; ?></td>
    <td width="59%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>	
  <tr>
    <td class="bodytext32">Cheque Number:</td>
    <td width="21%" align="left" class="bodytext33"><?php echo $chequenum; ?></td>
    <td width="59%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
   <tr>
    <td class="bodytext32">Cheque Amount:</td>
    <td width="21%" align="left" class="bodytext33"><?php echo number_format($amount,2,'.',','); ?></td>
    <td width="59%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
   <tr>
    <td class="bodytext32">Bank Name:</td>
    <td width="21%" align="left" class="bodytext33"><?php echo $bank; ?></td>
    <td width="59%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <?php } ?>
  <?php if($mode=="MPESA") { ?> 
  <tr>
    <td class="bodytext32">MPESA Amount:</td>
    <td width="21%" align="left" class="bodytext33"><?php echo number_format($amount,2,'.',','); ?></td>
    <td width="59%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <tr>
   <td class="bodytext32">MPESA Number:</td>
    <td width="21%" align="left" class="bodytext33"><?php echo $mpesanum ?></td>
    <td width="59%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
   <?php } ?>
   <?php if($mode=="CARD") { ?> 
  <tr>
    <td class="bodytext32">Card Amount:</td>
    <td width="21%" align="left" class="bodytext33"><?php echo number_format($amount,2,'.',','); ?></td>
    <td width="59%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <?php } ?>
  <?php if($mode=="ONLINE") { ?>
  <tr>
    <td class="bodytext32">Online Amount:</td>
    <td width="21%" align="left" class="bodytext33"><?php echo number_format($amount,2,'.',','); ?></td>
    <td width="59%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
   <?php } ?> 


<tr>
    <td class="bodytext32">Remarks:</td>
    <td width="21%" align="left" class="bodytext33"><?php echo $res21remarks; ?></td>
    <td width="59%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="3" class="bodytext33"><strong>Kenya Shillings </strong><?php echo str_replace('Kenya Shillings','',$convertedwords); ?></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
   <td >&nbsp;</td>
  
    <td   align="right"  class="bodytext33"><strong>Served By: </strong><?php echo strtoupper($res21username); ?></td>
  </tr>
  <tr>
  <td >&nbsp;</td>
  
    <td   align="right" class="bodytext30	"><?php echo date("d/m/Y", strtotime($res21date)). "&nbsp;". ''; ?> </td>
  </tr>
</table>
</div>
<?php	
	$content = ob_get_clean();
   
    // convert to PDF
   
    try
    {	
		//$width_in_inches = 4.39;
		//$height_in_inches = 6.2;
		//$width_in_mm = $width_in_inches * 25.4; 
		//$height_in_mm = $height_in_inches * 25.4;
        $html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array(0, 0, 0,0));
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
