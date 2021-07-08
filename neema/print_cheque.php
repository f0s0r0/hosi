<?php
session_start();
ini_set("display_errors", "1");
//include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$updatedate = date('Y-m-d');
$updatetime = date('H:i:s');

ob_start();

if(isset($_REQUEST['docno'])) {  $docno = $_REQUEST["docno"]; } else { $docno = ""; }
if(isset($_REQUEST['fm'])) {  $fm = $_REQUEST["fm"]; } else { $fm = ""; }
?>
<link href="css/pdf.css" rel="stylesheet">
<style type="text/css">
@page { margin: 230px 0px 0px 355px; size: letter landscape;}	

body {
    font-family: 'Arial'
}
.bodytext40 {FONT-WEIGHT: normal; FONT-SIZE: 14px; font-family:"Times New Roman", Times, serif; COLOR: #000000; 
}
.bodytext41 {FONT-WEIGHT: normal; FONT-SIZE: 14px; font-family:"Times New Roman", Times, serif; COLOR: #000000; 
}
.bodytext42 {FONT-WEIGHT: normal; FONT-SIZE: 14px; font-family:"Times New Roman", Times, serif; COLOR: #000000; 
}
.bodytext43 {FONT-WEIGHT: normal; FONT-SIZE: 16px; font-family:"Times New Roman", Times, serif; COLOR: #000000; 
}
.bodytext44 {FONT-WEIGHT: normal; FONT-SIZE: 14px; font-family:"Times New Roman", Times, serif; COLOR: #000000; 
}
.bodytext45 {FONT-WEIGHT: normal; FONT-SIZE: 14px; font-family:"Times New Roman", Times, serif; COLOR: #000000; 
}

.bodytext46 {FONT-WEIGHT: normal; FONT-SIZE: 14px; font-family:"Times New Roman", Times, serif; COLOR: #000000; 
}
.bodytext47 {FONT-WEIGHT: normal; FONT-SIZE: 14px; font-family:"Times New Roman", Times, serif; COLOR: #000000; 
}
.bodytext48 {FONT-WEIGHT: normal; FONT-SIZE: 14px; font-family:"Times New Roman", Times, serif; COLOR: #000000; 
}
.bodytext49 {FONT-WEIGHT: normal; FONT-SIZE: 14px; font-family:"Times New Roman", Times, serif; COLOR: #000000; 
}
</style>

	<?php
	$payarray=array();
	$payarray[0]='';
	$payarray[1]='';
	$payword1='';
	$payword2='';
	
	$amtarray=array();
	$amtarray[0]='';
	$amtarray[1]='';
	$amtword1='';
	$amtword2='';
	
	if($fm=='supplier'){
	$query3 = "select docno,suppliername as chequepayableto,bankname,chequedate,sum(chequeamount) as chequeamount,transactionmode as paymentmode from master_transactionpharmacy where docno = '$docno' and transactionmode = 'CHEQUE' and recordstatus = 'allocated'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	$res3 = mysql_fetch_array($exec3);
	$res3chequepayableto= $res3['chequepayableto'];
	$res3bankname= $res3['bankname'];
	$res3chequedate= $res3['chequedate'];
	$res3chequeamount= $res3['chequeamount'];
    $res3paymentmode = strtolower($res3['paymentmode']);
	}
	else
	{
	$query3 = "select docnumber as docno,payee as chequepayableto,bankname,chequedate,sum(transactionamount) as chequeamount,transactionmode as paymentmode from expensesub_details where docnumber = '$docno' and transactionmode = 'CHEQUE'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	$res3 = mysql_fetch_array($exec3);
	$res3chequepayableto= $res3['chequepayableto'];
	$res3bankname= $res3['bankname'];
	$res3chequedate= $res3['chequedate'];
	$res3chequeamount= $res3['chequeamount'];
    $res3paymentmode = strtolower($res3['paymentmode']);
	}
	//$res3paymentmode = 'bcheque';
	
	$res3docno= '';
    $res3branchname= '';
	$res3branchcode= '';
	$res3bankcharges= '';
	$res3currency= '';
	$res3rbankcode= '';
	$res3rbankname= '';
	
	$res22bankname = '';
	$res22bankbranch = '';
	$res22branchcode = '';
	$res22checkpayable = '';
	$res22accountnumber = '';
	
	$res12ledgerid = '';
	$res12ledgername = '';
	$res13clientname = '';
	
	$res15citycurrencyname= '';
	$res15beneficiarymode = ''; 
	$res15citycurrency = ''; 
	$res15beneficiaryaccountamt = ''; 
	$res15chequepayableto = ''; 
	$res15paymentmode= '';
	
	if($res3paymentmode=='cheque') { $res3chequepayableto= '**'.$res3chequepayableto.'**'; } 
	if($res3paymentmode=='bcheque') { $res3chequepayableto= '**'.$res3chequepayableto.'**'; } 
	if($res3paymentmode=='rtgs') { $res3chequepayableto= '**'.$res22checkpayable.'**'; } 
	if($res3paymentmode=='multicurrency') { $res3chequepayableto= '**'.$res15chequepayableto.'**'; } 
	if($res3paymentmode=='whtax') { $res3chequepayableto= '**Yourself**'; }
	if($res3paymentmode=='payeetax') { $res3chequepayableto= '**Yourself**'; } 
	if($res3paymentmode=='payroll') { $res3chequepayableto= '**Yourself**'; } 
	if($res3paymentmode=='dirpayroll') { $res3chequepayableto= '**Yourself**'; } 
	  
	$intpart = intval($res3chequeamount);
	$decimal = substr($res3chequeamount, strpos($res3chequeamount, ".") + 1);    
	$intpart1 = intval($res15beneficiaryaccountamt);
	$decimal1 = substr($res15beneficiaryaccountamt, strpos($res15beneficiaryaccountamt, ".") + 1);    
	
	$desired_width = 63;
	
	$payarray = wordwrap($res3chequepayableto, $desired_width, "\n");
	$payarray = explode("\n", $payarray);
	
	if (isset($payarray[0])) $payword1 = $payarray[0];
	if (isset($payarray[1])) $payword2 = $payarray[1];
	if (isset($payarray[2])) $payword3 = $payarray[2];
	
	include("convert_currency_to_words.php");
	$convertwords=covert_currency_to_words($intpart);
    $convertwords1=covert_currency_to_words($intpart1);
	$convertwords=str_replace('Kenya Shillings','',str_replace('-Zero  Cents Only',' ',$convertwords));
	$convertwords1=str_replace('Kenya Shillings','',str_replace('-Zero  Cents Only',' ',$convertwords1));
	
	if($decimal>0) $convertwords=$convertwords.' & '.$decimal.'/100 Only';
	else $convertwords=$convertwords.'Only';
	
	if($decimal1>0) $convertwords1=$convertwords1.' & '.$decimal1.'/100 Only';
	else $convertwords1=$convertwords1.'Only';
	
	$desired_width = 56;
	
	$amtarray = wordwrap($convertwords, $desired_width, "\n");
	$amtarray = explode("\n", $amtarray);

	if (isset($amtarray[0])) $amtword1 = $amtarray[0];
	if (isset($amtarray[1])) $amtword2 = $amtarray[1];

	?>

<table width="516" border="0" cellspacing="0" cellpadding="1" align="center" <?php if($res3paymentmode !='cheque') { ?>style="page-break-after: always; <?php } ?>float:center;">
  <tr>
    <td colspan="2" align="left" valign="center" class="bodytext40">&nbsp;</td>
    <td width="34" align="left" valign="center" class="bodytext40">&nbsp;</td>
    <td colspan="2" align="left" valign="center" class="bodytext40">&nbsp;</td>
    <td width="24" align="left" valign="center" class="bodytext40">&nbsp;</td>
    <td width="26" align="left" valign="center" class="bodytext40">&nbsp;</td>
    <td width="87" align="left" valign="center" class="bodytext40"><?php echo date('d-M-Y',strtotime($res3chequedate)); ?></td>
  </tr>
  
  <tr>
    <td colspan="2" align="left" valign="center" class="bodytext40">&nbsp;</td>
    <td align="left" valign="center" class="bodytext40">&nbsp;</td>
    <td colspan="2" align="left" valign="center" class="bodytext40">&nbsp;</td>
    <td align="left" valign="center" class="bodytext40">&nbsp;</td>
    <td align="left" valign="center" class="bodytext40">&nbsp;</td>
    <td align="left" valign="center" class="bodytext40">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="center" class="bodytext40">&nbsp;</td>
    <td align="left" valign="center" class="bodytext40">&nbsp;</td>
    <td colspan="2" align="left" valign="center" class="bodytext40">&nbsp;</td>
    <td align="left" valign="center" class="bodytext40">&nbsp;</td>
    <td align="left" valign="center" class="bodytext40">&nbsp;</td>
    <td align="left" valign="center" class="bodytext40">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="center" class="bodytext40">&nbsp;</td>
    <td align="left" valign="center" class="bodytext40">&nbsp;</td>
    <td colspan="2" align="left" valign="center" class="bodytext40">&nbsp;</td>
    <td align="left" valign="center" class="bodytext40">&nbsp;</td>
    <td align="left" valign="center" class="bodytext40">&nbsp;</td>
    <td align="left" valign="center" class="bodytext40">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="center" class="bodytext41">&nbsp;</td>
    <td align="left" valign="center" class="bodytext41">&nbsp;</td>
    <td colspan="2" rowspan="2" align="center" valign="bottom" class="bodytext41">**Not Over <strong><?php echo number_format(ceil($res3chequeamount)); ?></strong>**</td>
    <td align="left" valign="center" class="bodytext41">&nbsp;</td>
    <td align="left" valign="center" class="bodytext41">&nbsp;</td>
    <td align="left" valign="center" class="bodytext41">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="center" class="bodytext41">&nbsp;</td>
    <td width="34" align="left" valign="center" class="bodytext41">&nbsp;</td>
    <td width="24" align="left" valign="center" class="bodytext41">&nbsp;</td>
    <td width="26" align="left" valign="center" class="bodytext41">&nbsp;</td>
    <td width="87" align="left" valign="center" class="bodytext41">&nbsp;</td>
  </tr>
  <tr>
    <td height="24" colspan="2" align="left" valign="center" class="bodytext41">&nbsp;</td>
    <td align="left" valign="center" class="bodytext41">&nbsp;</td>
    <td colspan="2" align="left" valign="center" class="bodytext41">&nbsp;</td>
    <td align="left" valign="center" class="bodytext41">&nbsp;</td>
    <td align="left" valign="center" class="bodytext41">&nbsp;</td>
    <td align="left" valign="center" class="bodytext41">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="center" class="bodytext42">&nbsp;</td>
    <td colspan="3" align="left" valign="bottom" class="bodytext42"><?php if($res3paymentmode=='rtgs') { echo  $payword1= '**Yourself**'; } else if(($res15paymentmode=='multicurrency') && ($res15beneficiarymode!='')) { echo  $payword1= '**Yourself**'; } else if($res15paymentmode=='bcheque') { echo $payword1= '**Yourself**'; } else { echo $payword1; } ?></td>
    <td width="24" align="left" valign="center" class="bodytext43">&nbsp;</td>
    <td colspan="2" align="left" valign="center" class="bodytext43"><strong>**<?php echo number_format($res3chequeamount,2,'=',','); ?>**</strong></td>
  </tr>
  <tr>
    <td height="14" colspan="2" align="left" valign="center" class="bodytext42">&nbsp;</td>
    <td colspan="3" align="left" valign="bottom" class="bodytext42"><?php echo $payword2; ?></td>
    <td width="24" align="left" valign="center" class="bodytext42">&nbsp;</td>
    <td width="26" align="left" valign="center" class="bodytext42">&nbsp;</td>
    <td width="87" align="left" valign="center" class="bodytext42">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="center" class="bodytext44">&nbsp;</td>
    <td width="34" align="left" valign="center" class="bodytext44">&nbsp;</td>
    <td colspan="2" align="left" valign="center" class="bodytext44">&nbsp;&nbsp;<?php echo $amtword1; ?></td>
    <td width="24" align="left" valign="center" class="bodytext44">&nbsp;</td>
    <td width="26" align="left" valign="center" class="bodytext44">&nbsp;</td>
    <td width="87" align="left" valign="center" class="bodytext44">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="center" class="bodytext44">&nbsp;</td>
    <td colspan="3" align="left" valign="center" class="bodytext44">&nbsp;</td>
    <td align="left" valign="center" class="bodytext44">&nbsp;</td>
    <td align="left" valign="center" class="bodytext44">&nbsp;</td>
    <td align="left" valign="center" class="bodytext44">&nbsp;</td>
  </tr>
  <tr>
    <td width="32" align="left" valign="center" class="bodytext44">&nbsp;</td>
    <td colspan="4" align="left" valign="center" class="bodytext44">&nbsp;&nbsp;<?php echo $amtword2; ?></td>
    <td align="left" valign="center" class="bodytext44">&nbsp;</td>
    <td align="left" valign="center" class="bodytext44">&nbsp;</td>
    <td align="left" valign="center" class="bodytext44">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="center" class="bodytext44">&nbsp;</td>
    <td align="left" valign="center" class="bodytext44">&nbsp;</td>
    <td colspan="2" align="center" valign="center" class="bodytext44">&nbsp;</td>
    <td align="left" valign="center" class="bodytext44">&nbsp;</td>
    <td align="left" valign="center" class="bodytext44">&nbsp;</td>
    <td align="left" valign="center" class="bodytext44">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="center" class="bodytext45">&nbsp;</td>
    <td align="left" valign="center" class="bodytext45">&nbsp;</td>
    <td width="148" align="center" valign="center" class="bodytext45">&nbsp;</td>
    <td width="134" align="left" valign="center" class="bodytext45"><strong><?php echo $res3docno; ?></strong></td>
    <td align="left" valign="center" class="bodytext45">&nbsp;</td>
    <td align="left" valign="center" class="bodytext45">&nbsp;</td>
    <td align="left" valign="center" class="bodytext45">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="center" class="bodytext44">&nbsp;</td>
    <td align="left" valign="center" class="bodytext44">&nbsp;</td>
    <td colspan="2" align="center" valign="center" class="bodytext44">&nbsp;</td>
    <td align="left" valign="center" class="bodytext44">&nbsp;</td>
    <td align="left" valign="center" class="bodytext44">&nbsp;</td>
    <td align="left" valign="center" class="bodytext44">&nbsp;</td>
  </tr>
</table>
<?php
if($res3paymentmode != 'cheque') 
{
?>
<table width="516" border="0" cellspacing="0" cellpadding="1" align="center" style="float:center;">
	<tr>
		<td width="33" align="left" valign="center" class="bodytext46">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext46">&nbsp;</td>
	</tr>
	<?php
	if($res3paymentmode=='bcheque') 
	{   
	?>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext46">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext46">Please issue Banker's Cheque payable to <strong><?php echo $res3chequepayableto; ?></strong> for <?php echo '<strong>'.ucwords(strtolower($res3currency)).' '; ?><?php echo number_format($res3chequeamount,2,'=',',').'</strong>'.' ('.ucwords(strtolower($res3currency)).' '.trim($convertwords).')'; ?>. Please debit our Kenya Shillings account with you for charges of <?php echo number_format($res3bankcharges,2,'.',','); ?>.</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext46">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext46">&nbsp;</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext47">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext47"><strong>NB: </strong>The above instruction is valid for Cheque Number <?php echo $res3docno; ?> dated <?php echo date('d-M-Y',strtotime($res3chequedate)); ?>. No alteration permitted.</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext47">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext47">&nbsp;</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext47">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext47">&nbsp;</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext47">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext47">&nbsp;</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext47">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext47">&nbsp;</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext48">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext48">Authorised Signatory</td>
	</tr>
	<?php
	 }
	?>
	<?php
	if($res3paymentmode=='rtgs') 
	{  
	?>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext46">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext46">Please Send RTGS as per the attached application, as well as the details as per below for <?php echo '<strong>'.ucwords(strtolower($res3currency)).' '; ?><?php echo number_format($res3chequeamount,2,'=',',').'</strong>'.' ('.ucwords(strtolower($res3currency)).' '.trim($convertwords).')'; ?>. Please debit our Kenya Shillings account with you for charges of <?php echo number_format($res3bankcharges,2,'.',','); ?>.</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext46">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext46">&nbsp;</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext46">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext46">
		 <table width="476" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		   <td width="115" align="left" valign="center" class="bodytext49"><strong>Name of the Payee</strong></td>
		   <td width="355" align="left" valign="center" class="bodytext49"><?php echo $res3chequepayableto; ?></td>
		  </tr>
		  <tr>
		   <td width="115" align="left" valign="center" class="bodytext49"><strong>Bank & Branch</strong></td>
		   <td width="355" align="left" valign="center" class="bodytext49"><?php echo $res22bankname.' & '.$res22bankbranch; ?></td>
		  </tr>
		  <tr>
		   <td width="115" align="left" valign="center" class="bodytext49"><strong>Branch Code</strong></td>
		   <td width="355" align="left" valign="center" class="bodytext49"><?php echo $res22branchcode; ?></td>
		  </tr>
		  <tr>
		   <td width="115" align="left" valign="center" class="bodytext49"><strong>Account No</strong></td>
		   <td width="355" align="left" valign="center" class="bodytext49"><?php echo $res22accountnumber; ?></td>
		  </tr>
		  <tr>
		   <td width="115" align="left" valign="center" class="bodytext49"><strong>Amount</strong></td>
		   <td width="355" align="left" valign="center" class="bodytext49"><?php echo ucwords(strtolower($res3currency)).' '; ?><?php echo number_format($res3chequeamount,2,'=',',').' ('.trim($convertwords).')'; ?></td>
		  </tr>
		 </table>	  </td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext47">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext47">&nbsp;</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext47">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext47"><strong>NB: </strong>The above instruction is valid for Cheque Number <?php echo $res3docno; ?> dated <?php echo date('d-M-Y',strtotime($res3chequedate)); ?>. No alteration permitted.</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext47">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext47">&nbsp;</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext47">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext47">&nbsp;</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext47">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext47">&nbsp;</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext47">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext47">&nbsp;</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext48">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext48">Authorised Signatory</td>
	</tr>
	<?php
	 }
	?>
	
	<?php
	if($res3paymentmode=='payeetax') 
	{  
	?>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext46">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext46">Please pay to <strong>Commissioner of Domestic Taxes Deparment A/C PAYE</strong> <?php echo '<strong>'.ucwords(strtolower($res3currency)).' '; ?><?php echo number_format($res3chequeamount,2,'=',',').'</strong>'.' ('.ucwords(strtolower($res3currency)).' '.trim($convertwords).')'; ?> as per attached payment slip.</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext46">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext46">&nbsp;</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext47">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext47"><strong>NB: </strong>The above instruction is valid for Cheque Number <?php echo $res3docno; ?> dated <?php echo date('d-M-Y',strtotime($res3chequedate)); ?>. No alteration permitted.</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext47">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext47">&nbsp;</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext47">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext47">&nbsp;</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext47">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext47">&nbsp;</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext47">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext47">&nbsp;</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext48">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext48">Authorised Signatory</td>
	</tr>
	<?php
	 }
	?>
    <?php
	if($res3paymentmode=='whtax') 
	{  
	?>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext46">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext46">Please pay to <strong>Commissioner of Domestic Taxes Deparment A/C W/Tax</strong> <?php echo '<strong>'.ucwords(strtolower($res3currency)).' '; ?><?php echo number_format($res3chequeamount,2,'=',',').'</strong>'.' ('.trim($convertwords).')'; ?> as per attached request.</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext46">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext46">&nbsp;</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext47">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext47"><strong>NB: </strong>The above instruction is valid for Cheque Number <?php echo $res3docno; ?> dated <?php echo date('d-M-Y',strtotime($res3chequedate)); ?>. No alteration permitted.</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext47">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext47">&nbsp;</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext47">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext47">&nbsp;</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext47">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext47">&nbsp;</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext47">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext47">&nbsp;</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext48">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext48">Authorised Signatory</td>
	</tr>
	<?php
	 }
	?>
	<?php
	if(($res3paymentmode=='multicurrency') && ($res15beneficiarymode !=''))
	{ 
	?>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext46">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext46">Please issue <?php echo ucwords(strtolower($res15citycurrencyname)).' '.$res15beneficiarymode; ?> payable at <?php echo $res15citycurrency; ?> in favour of <strong><?php echo $res3chequepayableto; ?></strong> for <?php echo '<strong>'.ucwords(strtolower($res15citycurrencyname)).'&nbsp;'; ?><?php echo number_format($res15beneficiaryaccountamt,2,'=',',').'</strong>'.' ('.ucwords(strtolower($res15citycurrencyname)).'&nbsp;'.trim($convertwords1).')'; ?> as per attached request. Please debit our Kenya Shillings account with you for charges of <?php echo number_format($res3bankcharges,2,'.',','); ?>.</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext46">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext46">&nbsp;</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext47">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext47"><strong>NB: </strong>The above instruction is valid for Cheque Number <?php echo $res3docno; ?> dated <?php echo date('d-M-Y',strtotime($res3chequedate)); ?>. No alteration permitted.</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext47">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext47">&nbsp;</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext47">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext47">&nbsp;</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext47">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext47">&nbsp;</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext47">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext47">&nbsp;</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext48">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext48">Authorised Signatory</td>
	</tr>
	<?php
	 }
	?>
	<?php
	if($res3paymentmode=='payroll') 
	{  
	?>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext46">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext46">Please process the payroll payments of our various staff members & your accounts holders with amounts payable by way of crediting their respective accounts being held with you as per attached request for <?php echo '<strong>'.ucwords(strtolower($res3currency)).' '; ?><?php echo number_format($res3chequeamount,2,'=',',').'</strong>'.' ('.trim($convertwords).')'; ?>.</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext46">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext46">&nbsp;</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext47">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext47"><strong>NB: </strong>The above instruction is valid for Cheque Number <?php echo $res3docno; ?> dated <?php echo date('d-M-Y',strtotime($res3chequedate)); ?>. No alteration permitted.</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext47">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext47">&nbsp;</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext47">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext47">&nbsp;</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext47">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext47">&nbsp;</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext47">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext47">&nbsp;</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext48">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext48">Authorised Signatory</td>
	</tr>
	<?php
	 }
	?>
	<?php
	if($res3paymentmode=='dirpayroll') 
	{  
	?>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext46">&nbsp;</td>
		 <td width="479" align="left" valign="center" class="bodytext46">Please process the payments for <?php echo '<strong>'.ucwords(strtolower($res3currency)).' '; ?><?php echo number_format($res3chequeamount,2,'=',',')?> (Ksh. <?php echo (trim($convertwords)).'</strong>' ?>) by way of crediting the below mentioned respective accounts held with you.</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext46">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext46">&nbsp;</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext46">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext46">
		 <table width="356" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		   <td width="171" align="left" valign="center" class="bodytext49"><strong>Account Holder</strong></td>
		   <td width="85" align="left" valign="center" class="bodytext49"><strong>Account No.</strong></td>
		   <td width="100" align="right" valign="center" class="bodytext49"><strong>Amount</strong></td>
		  </tr>
		 <?php
		 $query14 = "select accountname,accountno,amount from cheque_dirpayroll where mpdocno='$docno' and status='' order by auto_number asc ";
		 $exec14 = mysql_query($query14) or die ("Error in Query14".mysql_error());
		 while($res14 = mysql_fetch_array($exec14))
		  {
		   $res14accountname= $res14['accountname'];
		   $res14accountno= $res14['accountno'];
		   $res14amount= $res14['amount'];
		 ?>
		  <tr>
		   <td width="171" align="left" valign="center" class="bodytext49"><?php echo $res14accountname; ?></td>
		   <td width="85" align="left" valign="center" class="bodytext49"><?php echo $res14accountno; ?></td>
		   <td width="100" align="right" valign="center" class="bodytext49"><?php echo number_format($res14amount,2,'.',','); ?></td>
		  </tr>
		 <?php
		   }
		 ?>
		 </table>	  </td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext46">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext46">&nbsp;</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext47">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext47"><strong>NB: </strong>The above instruction is valid for Cheque Number <?php echo $res3docno; ?> dated <?php echo date('d-M-Y',strtotime($res3chequedate)); ?>. No alteration permitted.</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext47">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext47">&nbsp;</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext47">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext47">&nbsp;</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext47">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext47">&nbsp;</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext47">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext47">&nbsp;</td>
	</tr>
	<tr>
		<td width="33" align="left" valign="center" class="bodytext48">&nbsp;</td>
		<td width="479" align="left" valign="center" class="bodytext48">Authorised Signatory</td>
	</tr>
	<?php
	 }
	?>
</table>
<?php
 }
?>

<?php	
require_once("dompdf/dompdf_config.inc.php");
$html =ob_get_clean();
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper('letter', 'landscape');
//$paper_size = array(0,0,612.00,792.00);
//$dompdf->set_paper($paper_size);
$dompdf->render();
//$canvas = $dompdf->get_canvas();
//$canvas->line(10,800,800,800,array(0,0,0),1);
//$font = Font_Metrics::get_font("times-roman", "normal");
//$canvas->page_text(272, 814, "Page {PAGE_NUM}/{PAGE_COUNT}", $font, 10, array(0,0,0));
$dompdf->stream("Cheque.pdf", array("Attachment" => 0)); 
?>
