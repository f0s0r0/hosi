<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$ADate1 = date('Y-m-d', strtotime('01-01-2016'));
$ADate2 = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$type1 = '';
$acccoa = '';
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";  
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$total = '0.00';
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$range = "";
$sno = "";
$colorloopcount1="";
$grandtotal = '';
$grandtotal1 = "0.00";
$openingbalancecredit = "0.00";
$openingbalancedebit = "0.00";
$totalamount2 = '0.00';
$totalamount21 = '0.00';
$totalamount3 = '0.00';
$totalamount4 = '0.00';
//This include updatation takes too long to load for hunge items database.
//include ("autocompletebuild_ledger.php");

if (isset($_REQUEST["subtype"])) { $subtype = $_REQUEST["subtype"]; } else { $subtype = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = '2016-01-01'; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = date('Y-m-d'); }
//echo $ADate2;
if (isset($_REQUEST["ledger"])) { $ledger = $_REQUEST["ledger"]; } else { $ledger = ""; }
//echo $ledger = str_replace('&',' ',$ledger);
if (isset($_REQUEST["ledgeranum"])) { $ledgeranum = $_REQUEST["ledgeranum"]; } else { $ledgeranum = ""; }
//$ledger = trim($ledger);
if (isset($_REQUEST["ledgerid"])) { $ledgerid = $_REQUEST["ledgerid"]; } else { $ledgerid = ""; }
//$ledgerid = trim($ledgerid);
if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; }
if (isset($_REQUEST["group"])) { $group = $_REQUEST["group"]; } else { $group = ""; }

?>
<style type="text/css">

body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
.bal
{
border-style:none;
background:none;
text-align:right;
}
.bali
{
text-align:right;
}
</style>
</head>

<script src="js/datetimepicker_css.js"></script>
<script type="text/javascript">
window.onload = function(){

}
</script>
<body>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tbody>
				
       <tr>
        <td><table width="80%" id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" 
            align="left" border="0">
			 <tr>
				<td colspan="9" bgcolor="#CCC" class="bodytext3" align="left"><strong><?php echo 'Ledger Report'; ?></strong></td>
			</tr>
			<?php
			if(true)
			{
				$query= "select accountssub from master_accountssub where auto_number='$group'";
				$exec = mysql_query($query) or die (mysql_error());
				$res = mysql_fetch_array($exec);
				$accountssub = $res['accountssub'];
			?>
            <tr>
				<td colspan="9" bgcolor="#FFFFFF" class="bodytext3" align="left"><strong><?php echo $accountssub.' - '.'From '.date('d-M-Y',strtotime($ADate1)).' '.'to '.date('d-M-Y',strtotime($ADate2)); ?></strong></td>
			</tr>
			<?php } 
				$ledgertotal = 0;
				
				if(true)
				{
				?>
				<tr bgcolor="#CCC">
				<td width="87" align="left" class="bodytext3"><strong><?php echo 'S.No'; ?></strong></td>
				<td width="87" align="left" class="bodytext3"><strong><?php echo 'Date'; ?></strong></td>
				<td width="87" align="left" class="bodytext3"><strong><?php echo 'Docno'; ?></strong></td>
				<td width="98" align="left" class="bodytext3"><strong><?php echo 'Code'; ?></strong></td>
				<td width="288" align="left" class="bodytext3"><strong><?php echo 'Description'; ?></strong></td>
				<td width="92" align="right" class="bodytext3"><strong><?php echo 'Debit'; ?></strong></td>
                <td width="106" align="right" class="bodytext3"><strong><?php echo 'Credit'; ?></strong></td>
                <td width="78" align="right" class="bodytext3"><strong><?php echo 'Balance'; ?></strong></td>
				</tr>
				<?php
				$totalamount=0;
				$openingbalance1=0;
				$sumbalance = '0.00';
				$sumbalance1 = '0.00';
				$colorloopcount = 0;
				
				$scount=0;
				$ledgertotal = 0;
				$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$group' and subtype = '$subtype'";
				$exec267 = mysql_query($query267) or die ("Error in Query267".mysql_error());
				while($res267 = mysql_fetch_array($exec267))
				{  
					$accountsmain2 = $res267['accountname'];
					$accountname = addslashes ($res267['accountname']);
					$parentid2 = $res267['auto_number'];
					$ledgeranum = $parentid2;
					$id = $res267['id'];
					$opening = 0;
					$i=0;
					$result = array();
					$querycr1 = "SELECT * FROM (SELECT (`transactionamount`) as paylater,transactiondate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'finalize' AND `billnumber` LIKE '%CB%'
								 UNION ALL SELECT (`transactionamount`) as paylater,transactiondate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'finalize' AND `billnumber` LIKE '%IPDr%'
					 			 UNION ALL SELECT (`transactionamount`) as paylater,transactiondate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `master_transactionip` WHERE `accountnameid` = '$id' AND billtype = 'PAY LATER' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
								 UNION ALL SELECT (`totalamount`) as paylater,billdate as td2, billno as td3, patientcode as td4, patientname as td5 FROM `billing_ipcreditapprovedtransaction` WHERE `accountnameid` = '$id' AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
								 UNION ALL SELECT (`debitamount`) as paylater,entrydate as td2, docno as td3, ledgerid as td4, narration as td5 FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
								 
								 UNION ALL SELECT (-1*transactionamount) as paylater,transactiondate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `docno` LIKE '%IPCr%' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'paylatercredit'
								 UNION ALL SELECT (-1*transactionamount) as paylater,transactiondate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `docno` LIKE 'Cr.N%' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'paylatercredit'
								 UNION ALL SELECT (-1*transactionamount) as paylater,transactiondate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `master_transactionpaylater` WHERE accountnameid = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'pharmacycredit'
								 UNION ALL SELECT (-1*transactionamount) as paylater,transactiondate as td2, docno as td3, accountnameid as td4, accountname as td5 FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `docno` LIKE 'AR-%' AND `transactionstatus` = 'onaccount' AND `transactionmodule` = 'PAYMENT'
								 UNION ALL SELECT (-1*creditamount) as paylater,entrydate as td2, docno as td3, ledgerid as td4, narration as td5 FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2') as pp ORDER BY pp.td2";
					$execcr1 = mysql_query($querycr1) or die ("Error in Querycr1".mysql_error());
					$numdr1 = mysql_num_rows($execcr1);
					if($numdr1 > 0)
					{
				?>
				<tr>
				<td colspan="9" bgcolor="#FFFFFF" class="bodytext3" align="left"><strong><?php echo $accountname; ?></strong></td>
				</tr>
				<?php	
					while($resdr1 = mysql_fetch_array($execcr1))
					{
						$paylater = $resdr1['paylater'];
						$code = $resdr1['td4'];
						$name = $resdr1['td5'];
						$billno = $resdr1['td3'];
						$date = $resdr1['td2'];
						
						$sumbalance = $sumbalance + $paylater;
						$sumbalance1 = $sumbalance1 + $paylater;
						
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
						<tr <?php echo $colorcode; ?>>
						<td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
						<td align="left" class="bodytext3"><?php echo $date; ?></td>
						<td align="left" class="bodytext3"><?php echo $billno; ?></td>
						<td align="left" class="bodytext3"><?php echo $code; ?></td>
						<td align="left" class="bodytext3"><?php echo $name; ?></td>
						<?php if($paylater > 0) { ?>
						<td align="right" class="bodytext3"><?php echo number_format($paylater,2); ?></td>
						<td align="right" class="bodytext3">&nbsp;</td>
						<?php } else { ?>
						<td align="right" class="bodytext3">&nbsp;</td>
						<td width="17" align="right" class="bodytext3"><?php echo number_format(abs($paylater),2); ?></td>
						<?php } ?>
						<td width="17" align="right" class="bodytext3"><?php echo number_format($sumbalance1,2); ?></td>
						</tr>
						<?php
					}
					}
				}
				}
				?>
				<tr bgcolor="#CCCCCC">
				<td colspan="8" align="right" class="bodytext3"><strong><?php echo number_format($sumbalance1,2); ?></strong></td>
				</tr>
                </table>
                </td>
                </tr>
                </tbody>
                
                
          
         
</table>

</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
