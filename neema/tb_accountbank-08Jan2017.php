<?php

$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$parentid'";
$exec267 = mysql_query($query267) or die ("Error in Query267".mysql_error());
while($res267 = mysql_fetch_array($exec267))
{  
	$accountsmain2 = $res267['accountname'];
	$parentid2 = $res267['auto_number'];
	$ledgeranum = $parentid2;
	$id = $res267['id'];
	$accountbank = 0;
	$i = 0;
	
	/*  
	
	UNION ALL SELECT SUM(openbalanceamount) as bankamount FROM `openingbalanceaccount` WHERE `accountcode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
	*/
	$drresult = array();
	$querydr1bnk = "SELECT SUM(`cashamount`) as bankamount FROM `billing_consultation` WHERE (`cashcode` = '$id') AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`creditamount`) as bankamount FROM `billing_consultation` WHERE (`mpesacode` = '$id') AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`cardamount`) as bankamount FROM `billing_consultation` WHERE (`bankcode` = '$id') AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`onlineamount`) as bankamount FROM `billing_consultation` WHERE (`bankcode` = '$id') AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`chequeamount`) as bankamount FROM `billing_consultation` WHERE (`bankcode` = '$id') AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
					
					UNION ALL SELECT SUM(`cashamount`) as bankamount FROM `master_transactionpaynow` WHERE (`cashcode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`creditamount`) as bankamount FROM `master_transactionpaynow` WHERE (`mpesacode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`cardamount`) as bankamount FROM `master_transactionpaynow` WHERE (`bankcode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`onlineamount`) as bankamount FROM `master_transactionpaynow` WHERE (`bankcode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`chequeamount`) as bankamount FROM `master_transactionpaynow` WHERE (`bankcode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					
					UNION ALL SELECT SUM(`cashamount`) as bankamount FROM `master_transactionexternal` WHERE (`cashcode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`creditamount`) as bankamount FROM `master_transactionexternal` WHERE (`mpesacode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`cardamount`) as bankamount FROM `master_transactionexternal` WHERE (`bankcode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`onlineamount`) as bankamount FROM `master_transactionexternal` WHERE (`bankcode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`chequeamount`) as bankamount FROM `master_transactionexternal` WHERE (`bankcode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					
					UNION ALL SELECT SUM(`transactionamount`) as bankamount FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'finalize' AND `billnumber` LIKE '%CB%'
					
					UNION ALL SELECT SUM(`cashamount`) as bankamount FROM `master_transactionadvancedeposit` WHERE `cashcode` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`creditamount`) as bankamount FROM `master_transactionadvancedeposit` WHERE `mpesacode` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`chequeamount`) as bankamount FROM `master_transactionadvancedeposit` WHERE `bankcode` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`onlineamount`) as bankamount FROM `master_transactionadvancedeposit` WHERE `bankcode` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`cardamount`) as bankamount FROM `master_transactionadvancedeposit` WHERE `bankcode` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					
					UNION ALL SELECT SUM(`cashamount`) as bankamount FROM `master_transactionipdeposit` WHERE `cashcode` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactionmodule` = 'PAYMENT'
					UNION ALL SELECT SUM(`creditamount`) as bankamount FROM `master_transactionipdeposit` WHERE `mpesacode` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactionmodule` = 'PAYMENT'
					UNION ALL SELECT SUM(`chequeamount`) as bankamount FROM `master_transactionipdeposit` WHERE `bankcode` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactionmodule` = 'PAYMENT'
					UNION ALL SELECT SUM(`onlineamount`) as bankamount FROM `master_transactionipdeposit` WHERE `bankcode` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactionmodule` = 'PAYMENT'
					UNION ALL SELECT SUM(`cardamount`) as bankamount FROM `master_transactionipdeposit` WHERE `bankcode` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactionmodule` = 'PAYMENT'
	
					UNION ALL SELECT SUM(`cashamount`) as bankamount FROM `master_transactionip` WHERE `cashcode` = '$id' AND billtype = 'PAY NOW' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`mpesaamount`) as bankamount FROM `master_transactionip` WHERE `mpesacode` = '$id' AND billtype = 'PAY NOW' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`chequeamount`) as bankamount FROM `master_transactionip` WHERE `bankcode` = '$id' AND billtype = 'PAY NOW' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`cardamount`) as bankamount FROM `master_transactionip` WHERE `bankcode` = '$id' AND billtype = 'PAY NOW' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`onlineamount`) as bankamount FROM `master_transactionip` WHERE `bankcode` = '$id' AND billtype = 'PAY NOW' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`returnbalance`) as bankamount FROM `master_transactionip` WHERE `cashcode` = '$id' AND billtype = 'PAY NOW' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`returnbalance`) as bankamount FROM `master_transactionip` WHERE `bankcode` = '$id' AND billtype = 'PAY NOW' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`returnbalance`) as bankamount FROM `master_transactionip` WHERE `mpesacode` = '$id' AND billtype = 'PAY NOW' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`totalamount`) as bankamount FROM `billing_ipcreditapprovedtransaction` WHERE `accountnameid` = '$id' AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
					
					UNION ALL SELECT SUM(`cashamount`) as bankamount FROM `receiptsub_details` WHERE (`cashcode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`creditamount`) as bankamount FROM `receiptsub_details` WHERE (`mpesacode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`cardamount`) as bankamount FROM `receiptsub_details` WHERE (`bankcode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`onlineamount`) as bankamount FROM `receiptsub_details` WHERE (`bankcode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`chequeamount`) as bankamount FROM `receiptsub_details` WHERE (`bankcode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
	
					UNION ALL SELECT SUM(transactionamount) as bankamount FROM `master_transactionpaylater` WHERE `bankcode` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `docno` LIKE 'AR-%' AND `transactionstatus` = 'onaccount' AND `transactionmodule` = 'PAYMENT'
					UNION ALL SELECT SUM(amount) as bankamount FROM `bankentryform` WHERE `tobankid` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(debitamount) as bankamount FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
	$execdr1 = mysql_query($querydr1bnk) or die ("Error in querydr1bnk".mysql_error());
	while($resdr1 = mysql_fetch_array($execdr1))
	{
	$i = $i+1;
	$drresult[$i] = $resdr1['bankamount'];
	}
	
	/* 
	
	*/			
	$j = 0;
	$crresult = array();
	$querycr1bnk = "SELECT SUM(transactionamount) as bankcredit FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `docno` LIKE '%IPCr%' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'paylatercredit'
					UNION ALL SELECT SUM(`cashamount`) as bankcredit FROM `refund_paynow` WHERE (`cashcode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`creditamount`) as bankcredit FROM `refund_paynow` WHERE (`mpesacode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`cardamount`) as bankcredit FROM `refund_paynow` WHERE (`bankcode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`onlineamount`) as bankcredit FROM `refund_paynow` WHERE (`bankcode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`chequeamount`) as bankcredit FROM `refund_paynow` WHERE (`bankcode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					
					UNION ALL SELECT SUM(creditamount) as bankcredit FROM `bankentryform` WHERE `frombankid` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					
					UNION ALL SELECT SUM(`transactionamount`) as bankcredit FROM `master_transactionpharmacy` WHERE `bankcode` = '$id' AND `transactionmodule` = 'PAYMENT' AND `recordstatus` = 'allocated' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`transactionamount`) as bankcredit FROM `master_transactiondoctor` WHERE `bankcode` = '$id' AND `transactionmodule` = 'PAYMENT' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(transactionamount) as bankcredit FROM `master_transactionpaylater` WHERE accountnameid = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'pharmacycredit'
					
					UNION ALL SELECT SUM(`cashamount`) as bankcredit FROM `expensesub_details` WHERE (`cashcode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`creditamount`) as bankcredit FROM `expensesub_details` WHERE (`mpesacode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`cardamount`) as bankcredit FROM `expensesub_details` WHERE (`bankcode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`onlineamount`) as bankcredit FROM `expensesub_details` WHERE (`bankcode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT SUM(`chequeamount`) as bankcredit FROM `expensesub_details` WHERE (`bankcode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					
					UNION ALL SELECT SUM(creditamount) as bankcredit FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
	$execcr1 = mysql_query($querycr1bnk) or die ("Error in querycr1bnk".mysql_error());
	while($rescr1 = mysql_fetch_array($execcr1))
	{
	$j = $j+1;
	$crresult[$j] = $rescr1['bankcredit'];
	}
	
	$accountbank = array_sum($drresult) - array_sum($crresult);
	
	$sumbalance = $sumbalance + $accountbank;
	
}
?>					