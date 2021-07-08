<?php
ob_start();
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$suppliername="";
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

//This include updatation takes too long to load for hunge items database.
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


if (isset($_REQUEST["docno"])) { $docno = $_REQUEST["docno"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];



$totalamount=0;
$query5="select * from master_transactiondoctor where docno='$docno' group by docno";
$exec5 = mysql_query($query5) or die(mysql_error());
$res5 = mysql_fetch_array($exec5);
$entrydate = $res5['transactiondate'];
$totalamount = $res5['transactionamount'];		  
$receivableamount = $totalamount;
$paymentmode = $res5['transactionmode'];
$taxamount = $res5['taxamount'];
$netamount = $totalamount - $taxamount;
if($paymentmode == '')
{
$paymentmode = 'By Credit Note';
}
$number = $res5['chequenumber'];
$date = $res5['chequedate'];
$bankname = $res5['bankname'];
$suppliername = $res5['accountname'];
switch ($paymentmode) {
    case "CHEQUE":
        $desp = "CHQNO".$number;
        break;
    case "CASH":
        $desp =  "CASH";
        break;
    case "ONLINE":
        $desp =  "ONLINE";
        break;
    default:
        $desp = "";
}
?>

<style>
.bodyhead{font-weight:bold; font-size:16px; text-align:center; text-decoration:underline;}
.bodytextbold{font-weight:bold; font-size:15px; text-align:center;}
.bodytext{font-weight:normal; font-size:15px; text-align:center; vertical-align:middle;}
td{{height: 50px;padding: 5px;}
table{table-layout:fixed;
width:100%;
display:table;}
</style>

<page backtop="10mm" backbottom="10mm" backright=1mm backleft="1mm">
<?php include("print_header.php");?>
<table  align="center" border="" width="700" cellpadding="" cellspacing="0">
	<tr>
	  <td width="700" class="bodyhead" colspan="4">REMITTANCE ADVICE - Accounts Payable</td></tr>
    <tr>
        <td  align="left" width="" rowspan="2" valign="center" class="bodytextbold">Payment To:</td>
        <td  align="left" width="200" rowspan="2" valign="center" class="bodytext"><?php echo $suppliername; ?></td>
        <td  align="left" width="" valign="center" class="bodytextbold">Payment Date:</td>
        <td align="left" width="" valign="center" class="bodytext" ><?php echo $entrydate; ?></td>
    </tr>
    <tr>
        <td class="bodytextbold" valign="center"  align="left">Payment No:</td>
        <td class="bodytext" valign="center"  align="left"><?php echo $docno; ?></td>
    </tr>
    <tr>
        <td class="bodytextbold" valign="center"  align="left">Payment Mode:</td>
        <td class="bodytext" valign="center"  align="left"><?php echo $paymentmode.', '.$number; ?></td>
        <td class="bodytextbold" valign="center"  align="left">Payment Amount:</td>
        <td class="bodytext" valign="center"  align="left"><?php echo number_format($netamount,2,'.',','); ?></td>
    </tr>
    <tr><td colspan="4">&nbsp;</td></tr>
</table>
<table width="700" border="1" cellspacing="" cellpadding="2" align="center">
   
    <tr>
        <td width="10%" class="bodytextbold">Date</td>
        <td width="10%" class="bodytextbold">Reference</td>
        <td width="250" class="bodytextbold">Description</td>
        <td width="20%" class="bodytextbold">Original Amt</td>
        <td width="20%" class="bodytextbold">Balance</td>
        <td width="20%" class="bodytextbold">Payment</td>
    </tr>
                      <?php 
			  $colorloopcount = 0;
			  $totamount = 0;
			  $totaltax = 0;
				$query2 = "select * from master_transactiondoctor where docno='$docno' and recordstatus=''";
			  $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			  $num2 = mysql_num_rows($exec2);
			 // echo $num2;
			  while ($res2 = mysql_fetch_array($exec2))
			  {
			 	  $billnumber = $res2['billnumber'];
				  $patientname = $res2['patientname'];
				  $visitcode = $res2['visitcode'];
				  $patientcode = $res2['patientcode'];
				  $accountname = $res2['accountname'];
				  $taxamount = $res2['taxamount'];
				  
				  $totaltax = $totaltax + $taxamount;
				  
				  if($patientname == '')
				  {
				  $query43 = "select * from master_visitentry where visitcode='$visitcode'";
				  $exec43 = mysql_query($query43) or die(mysql_error());
				  $res43 = mysql_fetch_array($exec43);
				  $patientname = $res43['patientfullname'];
				  }
				  $billnumber1 = substr($billnumber,0,4);
				  if($billnumber1 != 'IPF-')
				  {
				  $query23 = "select * from billing_paylater where billno='$billnumber'";
				  $exec23 = mysql_query($query23) or die(mysql_error());
				  $res23 = mysql_fetch_array($exec23);
				  $billamount = $res23['totalamount'];
				  }
				  else
				  {
				  $query231 = "select * from billing_ipprivatedoctor where description = '$accountname' and docno='$billnumber'";
				  $exec231 = mysql_query($query231) or die(mysql_error());
				  $res231 = mysql_fetch_array($exec231);
				  $billamount = $res231['amount'];
				  }
				  $transactiondate = $res2['transactiondate'];
				  $amount = $res2['transactionamount'];
				  $balanceamount = $res2['balanceamount'];
				  
			  	  $totamount = $totamount + $amount;
				  if($patientname == 'Opening Balance')
				  {
				  	$query111 = "select * from openingbalanceaccount where docno='$billnumber'";
					$exec111 =  mysql_query($query111) or die(mysql_error());
					$res111 = mysql_fetch_array($exec111);
					$billamount = $res111['amount'];
				  }
			  
			  //$query3 = "select * from master_patientadmission where patientcode = '$res2customercode' order by auto_number desc limit 0, 1";
			  //$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
			  //$res3 = mysql_fetch_array($exec3);
			  //$res3ipnumber = $res3['ipnumber'];
			  
			  ?>
<tr>
    <td valign="center" class="bodytext"><?php echo $transactiondate; ?></td>
    <td valign="center" class="bodytext"><?php echo $billnumber; ?></td>
    <td valign="center" class="bodytext"><?php echo $patientname.', '.$patientcode.', '.$visitcode;?></td>
    <td valign="center" class="bodytext"><?php echo number_format($billamount,2,'.',','); ?></td>
    <td valign="center" class="bodytext"><?php echo number_format($balanceamount,2,'.',','); ?></td>
    <td valign="center" class="bodytext"><?php echo number_format($amount,2,'.',','); ?></td>
</tr>
                      <?php
			  }
			  //}
			  ?>
<tr>
    <td valign="center" class="bodytext"><?php echo $transactiondate; ?></td>
    <td valign="center" class="bodytext"><?php echo $docno; ?></td>
    <td valign="center" class="bodytext"><?php echo 'WITHHOLDING TAX AMOUNT';?></td>
    <td valign="center" class="bodytext"><?php echo number_format(0.00,2,'.',','); ?></td>
    <td valign="center" class="bodytext"><?php echo number_format(0.00,2,'.',','); ?></td>
    <td valign="center" class="bodytext"><?php echo '- '.number_format($totaltax,2,'.',','); ?></td>
</tr>
<tr>
    <td colspan="5" valign="center" class="bodytext" align="right"><strong><?php echo 'NET PAYABLE'; ?></strong></td>
    <td valign="center" class="bodytext"><?php echo number_format($netamount,2,'.',','); ?></td>
</tr>			  
</table>

</page>
<?php

    $content = ob_get_clean();

    // convert in PDF
    require_once('html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
//      $html2pdf->setModeDebug();
        //$html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('printaccountremit.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>

