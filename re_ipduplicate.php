<?php
include ("db/db_connect.php");
$amount1 = 0;
$amount2 = 0;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = "2016-01-01"; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = "2016-12-30"; }
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = "cbfrmflag1"; }
if (isset($_REQUEST["billno"])) { $billno = $_REQUEST["billno"]; } else { $billno = ""; }
?>
<table border="1" width="100%" style="border-collapse:collapse;">
<tr>
<td colspan="12" align="center" valign="middle"><strong>MED 360</strong></td>
</tr>
<tr>
<td colspan="12" align="center" valign="middle"><strong>IP Reconcile</strong></td>
</tr>
<form method="post" action="">
<tr>
<td colspan="12" align="center" valign="middle"><strong>
<input type="hidden" name="cbfrmflag1" id="cbfrmflag1" value="cbfrmflag1" />
<input type="submit" name="submit" value="Submit" /></td>
</tr>
</form>
<?php if($cbfrmflag1 == 'cbfrmflag1') { ?>
<tr>
<td align="left"><strong>Date</strong></td>
<td align="left"><strong>Bill No</strong></td>
<td align="left"><strong>Visitcode</strong></td>
<td align="left"><strong>Billtype</strong></td>
<td align="left"><strong>Account</strong></td>
<td align="left"><strong>Account Code</strong></td>
<td align="right"><strong>Amount (Dr)</strong></td>
<td align="right"><strong>Admission (Cr)</strong></td>
<td align="right"><strong>Amb (Cr)</strong></td>
<td align="right"><strong>Bed Chrg (Cr)</strong></td>
<td align="right"><strong>Lab (Cr)</strong></td>
<td align="right"><strong>Misc (Cr)</strong></td>
<td align="right"><strong>Home (Cr)</strong></td>
<td align="right"><strong>Phar (Cr)</strong></td>
<td align="right"><strong>Dr (Cr)</strong></td>
<td align="right"><strong>Rad (Cr)</strong></td>
<td align="right"><strong>Ser (Cr)</strong></td>
<td align="right"><strong>Total</strong></td>
</tr>
<?php 
if($billno != '')
{
$query8 = "SELECT a.visitcode as visitcode,a.billnumber as billnumber,a.transactionamount as transactionamount,a.cashamount as cashamount,a.onlineamount as onlineamount,a.chequeamount as chequeamount,a.creditamount as creditamount,a.mpesaamount as mpesaamount,a.cardamount as cardamount,a.returnbalance as returnbalance,a.transactiondate as transactiondate,a.accountname as accountname,a.accountnameid as accountnameid,b.billtype as billtype FROM `master_transactionip` AS a JOIN `master_ipvisitentry` AS b ON (a.visitcode = b.visitcode) WHERE a.billnumber = '$billno' AND a.`transactiondate` BETWEEN '$ADate1' AND '$ADate2'";
		   //UNION ALL SELECT visitcode,billno,totalamount as totalrevenue,billdate,accountname,accountnameid FROM `billing_ipcreditapprovedtransaction` WHERE billno <> '' AND `billdate` BETWEEN '$ADate1' AND '$ADate2'";
$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
while($res8 = mysql_fetch_array($exec8))
{
$docno = $res8['billnumber'];
$visitcode = $res8['visitcode'];
$billtype = $res8['billtype'];
$cashamount = $res8['cashamount'];
$creditamount = $res8['creditamount'];
$chequeamount = $res8['chequeamount'];
$mpesaamount = $res8['mpesaamount'];
$cardamount = $res8['cardamount'];
$onlineamount = $res8['onlineamount'];
$returnbalance = $res8['returnbalance'];
if($returnbalance > 0) { $returnbalance = 0; }
if($billtype == 'PAY NOW')
{
$transactionamount = $cashamount+$creditamount+$chequeamount+$mpesaamount+$cardamount+$onlineamount+$returnbalance;
} else {
$transactionamount = $res8['transactionamount'];
}
$transactiondate = $res8['transactiondate'];
$accountname = $res8['accountname'];
$accountcode = $res8['accountnameid'];
$amount1 = $amount1 + $transactionamount;
?>
<tr>
<td align="left" valign="middle"><?= date('d-m-Y',strtotime($transactiondate)); ?></td>
<td align="left" valign="middle"><?= $docno; ?></td>
<td align="left" valign="middle"><?= $visitcode; ?></td>
<td align="left" valign="middle"><?= $billtype; ?></td>
<td align="left" valign="middle"><?= $accountname; ?></td>
<td align="left" valign="middle"><?= $accountcode; ?></td>
<td align="right" valign="middle"><?= number_format($transactionamount,2); ?></td>
<?php	
//SELECT SUM(`consultation`) as income FROM `billing_consultation` WHERE billnumber = '$docno'
//UNION ALL 
$i = 0;
$drresult = array();
$querydr1bnk = "UPDATE `billing_ip` SET visitcode = CONCAT(visitcode,'/1'),`totalamount` = '0' WHERE billno = '$docno' and visitcode = '$visitcode'";
$execdr1 = mysql_query($querydr1bnk) or die ("Error in querydr1bnk".mysql_error());

$querydr1bnk = "UPDATE `master_transactionip` SET visitcode = CONCAT(visitcode,'/1'),transactionamount=0,cashamount=0,chequeamount=0,cardamount=0,onlineamount=0,creditamount=0 WHERE billnumber = '$docno' and visitcode = '$visitcode'";
$execdr1 = mysql_query($querydr1bnk) or die ("Error in querydr1bnk".mysql_error());

$querydr1bnk = "UPDATE `billing_ipadmissioncharge` SET `amount` = '0' WHERE docno = '$docno' and visitcode = '$visitcode'";
$execdr1 = mysql_query($querydr1bnk) or die ("Error in querydr1bnk".mysql_error());

$querydr1bnk = "UPDATE `billing_ipambulance` SET `amount` = '0' WHERE docno = '$docno' and visitcode = '$visitcode'";
$execdr1 = mysql_query($querydr1bnk) or die ("Error in querydr1bnk".mysql_error());

$querydr1bnk = "UPDATE `billing_ipbedcharges` SET `amount` = '0' WHERE docno = '$docno' and visitcode = '$visitcode'";
$execdr1 = mysql_query($querydr1bnk) or die ("Error in querydr1bnk".mysql_error());

$querydr1bnk = "UPDATE `billing_iplab` SET `labitemrate` = '0' WHERE billnumber = '$docno' and patientvisitcode = '$visitcode'";
$execdr1 = mysql_query($querydr1bnk) or die ("Error in querydr1bnk".mysql_error());

$querydr1bnk = "UPDATE `billing_ipmiscbilling` SET `amount` = '0' WHERE docno = '$docno' and visitcode = '$visitcode'";
$execdr1 = mysql_query($querydr1bnk) or die ("Error in querydr1bnk".mysql_error());

$querydr1bnk = "UPDATE `billing_iphomecare` SET `amount` = '0' WHERE docno = '$docno' and visitcode = '$visitcode'";
$execdr1 = mysql_query($querydr1bnk) or die ("Error in querydr1bnk".mysql_error());

$querydr1bnk = "UPDATE `billing_ippharmacy` SET `amount` = '0' WHERE billnumber = '$docno' and patientvisitcode = '$visitcode'";
$execdr1 = mysql_query($querydr1bnk) or die ("Error in querydr1bnk".mysql_error());

$querydr1bnk = "UPDATE `billing_ipprivatedoctor` SET `amount` = '0' WHERE docno = '$docno' and visitcode = '$visitcode'";
$execdr1 = mysql_query($querydr1bnk) or die ("Error in querydr1bnk".mysql_error());

$querydr1bnk = "UPDATE `billing_ipradiology` SET `radiologyitemrate` = '0' WHERE billnumber = '$docno' and patientvisitcode = '$visitcode'";
$execdr1 = mysql_query($querydr1bnk) or die ("Error in querydr1bnk".mysql_error());

$querydr1bnk = "UPDATE `billing_ipservices` SET `servicesitemrate` = '0' WHERE billnumber = '$docno' and patientvisitcode = '$visitcode'";
$execdr1 = mysql_query($querydr1bnk) or die ("Error in querydr1bnk".mysql_error());
?>
</tr>
<?php
}
}
?>
</table>
<?php } ?>
