<?php
ob_start();
session_start();
//include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$chequenumber = '';
$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysql_query($query) or die ("Error in Query1".mysql_error());
$res = mysql_fetch_array($exec);
	
	 $locationname  = $res["locationname"];
	 $locationcode = $res["locationcode"];
	 
	 $query2 = "select * from master_location where locationcode = '$locationcode'";
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

$query1 = "select * from expensesub_details where docnumber LIKE '%EE%' AND  recordstatus <> 'DELETED' and companyanum = '$companyanum' order by auto_number desc";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
$rowcount1 = mysql_num_rows($exec1);
if ($rowcount1 == 0)
{
	echo 'Sorry. No Receipt Entry To Print.';
	exit;
}

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
//$receiptanum = $_REQUEST['receiptanum'];
if ($receiptanum != '')
{
	$query21 = "select * from expensesub_details where docnumber like '%EE%' AND  auto_number = '$receiptanum'";
}
else
{
	$query21 = "select * from expensesub_details where docnumber like '%EE%' AND recordstatus <> 'DELETED' and companyanum = '$companyanum' order by auto_number desc";
}
$exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
$res21 = mysql_fetch_array($exec21);
$res21anum = $res21['auto_number'];
/*
$res21date = $res21['transactiondate'];
$billtime = substr($res21date, 11, 8);
$dotarray = explode("-", $res21date);
$dotyear = $dotarray[0];
$dotmonth = $dotarray[1];
$dotday = $dotarray[2];
$dbdateday = strtoupper(date("d-M-Y", mktime(0, 0, 0, $dotmonth, $dotday, $dotyear)));
*/
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
if ($transactionmode == 'CASH')
{
	$amount = $res21['cashamount'];
}
if ($transactionmode == 'CHEQUE')
{
	$amount = $res21['chequeamount'];
}
if ($transactionmode == 'ONLINE')
{
	$amount = $res21['onlineamount'];
}
if ($transactionmode == 'MPESA')
{
	$amount = $res21['creditamount'];
}
else
{
	$amount = $res21['transactionamount'];
}
/*if ($transactionmode == 'MPESA')
{
	$amount = $res21['creditamount'];
}*/
$remarks = $res21['remarks'];
$docno = $res21['docnumber'];
$payee = $res21['payee'];
$transactionmode = $res21['transactionmode'];
if (true)
{
	$chequenumber = $res21['chequenumber'];
	$chequedate = $res21['chequedate'];
	$transactionmode = 'Cheque No.'.$chequenumber.' Dated '.$chequedate;
}
$transactionmode = 'By '.$transactionmode;

$receiptmainname = '';
$receiptsubname = '';
$receiptfullname = $receiptmainname.' - '.$receiptsubname;

/*
$query3 = "select * from master_customer where auto_number = '$customeranum'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$customername = $res3['customername'];
if ($customername != '') $customername = 'M/s. '.$customername;
$address = $res3['address'];
$location = $res3['location'];
$city = $res3['city'];
$state = $res3['state'];
$pincode = $res3['pincode'];
$city = $city.', '.$state;
if ($pincode != '') $city = $city.' - '.$pincode;

$subtotal = $res3['subtotal'];

$delivery = $res3['delivery'];
$deliverymode = $res3['deliverymode'];
$roundoff = $res3['roundoff'];
$totalamount = $res3['totalamount'];
*/

/*
$footerline1 = $res3['footerline1'];
$footerline2 = $res3['footerline2'];
$footerline3 = $res3['footerline3'];
$footerline4 = $res3['footerline4'];
$footerline5 = $res3['footerline5'];
$footerline6 = $res3['footerline6'];

$tinnumber = $res3['tinnumber'];
$cstnumber = $res3['cstnumber'];

$fontsize1 = $res2['fontsize1']; //F1 customer title
$fontsize2 = $res2['fontsize2']; // F2 Header lines.
$fontsize3 = $res2['fontsize3']; // F3 Body of bill.
$fontsize4 = $res2['fontsize4']; // F4 Tabular Columns.

$companyanum = $_SESSION['companyanum'];
$query4 = "select * from master_company where auto_number = '$companyanum'";
$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
$res4 = mysql_fetch_array($exec4);
$f9color = $res4['f9color'];
$f10color = $res4['f10color'];
$f25color = $res4['f25color'];

*/

?>
<style type="text/css">
<!--
.style6 {<?php echo 'font-size: '.$fontsize4.'px'; ?>;}
.style8 {<?php echo 'font-size: '.$fontsize4.'px'; ?>; font-weight: bold; }


/*
.style3 {
	font-family: "Times New Roman", Times, serif;
	font-weight: bold;
	font-size: 24px;
}

.style2 {font-size: 10px}
.style5 {font-family: "Times New Roman", Times, serif; font-weight: bold; font-size: 18px; }
.style6 {font-size: 14px}
.style8 {font-size: 14px; font-weight: bold; }
*/

table.sample {
	border-width: 1px;
	border-spacing: 1px;
	border-style: outset;
	border-color: gray;
	border-collapse: collapse;
	background-color: white;
}
table.sample th {
	border-width: 1px;
	border-spacing: 1px;
	border-style: outset;
	border-color: gray;
	border-collapse: collapse;
	background-color: white;
}
.style12 {font-size: 18px; font-weight: bold; }
.style27 {font-size: 14px; }
.style28 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 24px;
}
.style29 {font-family: Neuropol}

-->
</style>
<script language="javascript">

function escapekeypressed()
{
	//alert(event.keyCode);
	if(event.keyCode=='27'){ window.close(); }
}

</script>
<body onkeydown="escapekeypressed()">
<table width="530" border="0" cellpadding="0" cellspacing="0" align="center">  
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
$phonenumber1 = $res2["phonenumber1"];
$phonenumber2 = $res2["phonenumber2"];
$tinnumber1 = $res2["tinnumber"];
$cstnumber1 = $res2["cstnumber"];
?>
<td width="172" colspan="2" class="bodytext32"><div align="left" style="font-size:18px;"><strong>Petty Cash Voucher</strong></div></td>
    <td width="100" rowspan="4" align="left" valign="center" 
	 bgcolor="#ffffff" class="bodytext31">
	
	<?php
			$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
			$exec3showlogo = mysql_query($query3showlogo) or die ("Error in Query3showlogo".mysql_error());
			$res3showlogo = mysql_fetch_array($exec3showlogo);
			$showlogo = $res3showlogo['showlogo'];
			if ($showlogo == 'SHOW LOGO')
			{
			?>
				
			<img src="logofiles/<?php echo $companyanum;?>.jpg" width="100" height="100" />
			
			<?php
			}
			?>	</td>
			
 
			<td colspan="2" class="bodytext32"><div align="left"><?php echo $companyname; ?>
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
		    </div></td>
	  
  </tr>
		<tr>
		<td colspan="2" class="bodytext32"><div align="left">No: <?php echo $docno; ?></div></td>
			<td colspan="2" class="bodytext32"><div align="left"><?php echo $address1; ?>
		      <?php
			$address2 = $area.''.$city.' '.$pincode.'';
			$strlen3 = strlen($address2);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address2 = ' '.$address2.' ';    
			}
			?>			
		    </div></td>
			
		</tr>
		<tr>
		<td colspan="2" class="bodytext32"><div align="left">Date :  <?php echo date("d-M-Y", strtotime($billdate)); ?></div></td>
			<td colspan="2" class="bodytext32">
			
			  <div align="left"><?php echo $address2; ?>
		        <?php
			$address3 = "PHONE: ".$phonenumber1.' '.$phonenumber2;
			$strlen3 = strlen($address3);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address3 = ' '.$address3.' ';
			}
			?>			
	        </div></td>
			
		</tr>
	<?php if($chequenumber != ''){ ?>
		<tr>
		<td colspan="4" class="bodytext32"><div align="left">Cheque No:  <?php echo $chequenumber; ?></div></td>
</tr>
<?php } ?>
<tr>
<td colspan="5" style="">&nbsp;</td>
</tr>
<tr>
<td colspan="5" style="border-bottom:solid 1px #000000;">&nbsp;</td>
</tr>
</table>
<table width="100%" border="0" style="border-collapse:collapse; border:solid 1px">
<tr>
<td colspan="3" align="left" class="bodytext32">&nbsp;</td>
</tr>
<tr>
<td colspan="2" align="left" class="bodytext32"><strong><?php echo 'A/c To: '; ?></strong> <?php echo $payee; ?></td>
<td align="right" class="bodytext32"><strong><?php echo 'Amount'; ?></strong></td>
</tr>
<tr>
<td colspan="3" align="left" class="bodytext32">&nbsp;</td>
</tr>
<tr>
<td colspan="2" align="left" class="bodytext32"><?php echo 'Required for: '.$remarks; ?></td>
<td align="right" class="bodytext32"><?php echo $amount; ?></td>
</tr>
<tr>
<td colspan="3" align="left" class="bodytext32">&nbsp;</td>
</tr>
<tr>
<td colspan="3" align="left" class="bodytext32">&nbsp;</td>
</tr>
<tr>
<td colspan="3" align="left" class="bodytext32">&nbsp;</td>
</tr>
<tr>
<td colspan="3" align="left" class="bodytext32">&nbsp;</td>
</tr>
<tr>
<td colspan="3" align="left" class="bodytext32">&nbsp;</td>
</tr>
<tr>
<td colspan="2" align="left" class="bodytext32" style="border:solid 1px;"><strong><?php echo 'Total'; ?></strong></td>
<td align="right" class="bodytext32" style="border:solid 1px;"><strong><?php echo number_format($amount,2); ?></strong></td>
</tr>
<tr>
<td colspan="3" align="left" class="bodytext32"><?php 
	include ('convert_currency_to_words.php');
	$convertedwords = covert_currency_to_words($amount); //function call
	echo $convertedwords; ?></td>
</tr>
<tr>
<td colspan="2" align="left" class="bodytext32">&nbsp;</td>
<td align="center" rowspan="6" valign="top">Recepient Signature</td>
</tr>

<tr>
<td colspan="2" align="left" class="bodytext32">Prepared by: -------------------------------</td>
</tr>
<tr>
<td colspan="2" align="left" class="bodytext32">&nbsp;</td>
</tr>
<tr>
<td colspan="2" align="left" class="bodytext32">Checked by: -------------------------------</td>
</tr>
<tr>
<td colspan="2" align="left" class="bodytext32">&nbsp;</td>
</tr>
<tr>
<td colspan="2" align="left" class="bodytext32">Authorised by: -------------------------------</td>
</tr>
<tr>
<td colspan="3" align="left" class="bodytext32">&nbsp;</td>
</tr>
</table>
</body>
<?php	
require_once("dompdf/dompdf_config.inc.php");
$html =ob_get_clean();
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper("A4");
$dompdf->render();
$canvas = $dompdf->get_canvas();
//$canvas->line(10,800,800,800,array(0,0,0),1);
$font = Font_Metrics::get_font("times-roman", "normal");
$canvas->page_text(272, 814, "Page {PAGE_NUM}/{PAGE_COUNT}", $font, 10, array(0,0,0));
$dompdf->stream("Receipt.pdf", array("Attachment" => 0)); 
?>