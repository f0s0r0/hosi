<?php
$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$parentid'";
$exec267 = mysql_query($query267) or die ("Error in Query267".mysql_error());
while($res267 = mysql_fetch_array($exec267))
{  
	$accountsmain2 = $res267['accountname'];
	$orderid1 = $orderid1 + 1;
	$parentid2 = $res267['auto_number'];
	$ledgeranum = $parentid2;
	//$id2 = $res2['id'];
	$id = $res267['id'];
	//$id2 = trim($id2);
	$lid = $lid + 1;
	
	if($id == '01-2101-01')
	{
		$i = 0;
		$crresult = array();
		$querycr1bnk = "SELECT SUM(-1*`rate`) as income FROM `ip_discount` WHERE patientvisitcode IN (select visitcode FROM `master_transactionip` WHERE transactiondate BETWEEN '$ADate1' AND '$ADate2' group by billnumber)
						UNION ALL SELECT SUM(-1*`rate`) as income FROM `ip_discount` WHERE patientvisitcode IN (select visitcode FROM `billing_ipcreditapprovedtransaction` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' group by billno)";
		$execcr1 = mysql_query($querycr1bnk) or die ("Error in querycr1bnk".mysql_error());
		while($rescr1 = mysql_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult[$i] = $rescr1['income'];
		}
		
		$balance = array_sum($crresult);
		$sumbalance = $sumbalance + $balance;
	}
	else if($id == '07-8101-01')
	{
		$i = 0;
		$crresult = array();
		$querycr1bnk = "SELECT SUM(1*ABS(amount)) as income FROM `billing_ipnhif` WHERE visitcode IN (select visitcode FROM `master_transactionip` WHERE transactiondate BETWEEN '$ADate1' AND '$ADate2' group by billnumber)
						UNION ALL SELECT SUM(1*ABS(amount)) as income FROM `billing_ipnhif` WHERE visitcode IN (select visitcode FROM `billing_ipcreditapprovedtransaction` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' group by billno)
						UNION ALL SELECT SUM(-1*transactionamount) as income FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `docno` LIKE 'AR-%' AND `transactionstatus` = 'onaccount' AND `transactionmodule` = 'PAYMENT'";
		$execcr1 = mysql_query($querycr1bnk) or die ("Error in querycr1bnk".mysql_error());
		while($rescr1 = mysql_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult[$i] = $rescr1['income'];
		}
		
		$balance = array_sum($crresult);
		$sumbalance = $sumbalance + $balance;
	}
	/*else if($id == '01-2201-01')
	{
		$i = 0;
		$crresult = array();
		$querycr1bnk = "SELECT SUM(1*ABS(amount)) as income FROM `billing_ipnhif` WHERE visitcode IN (select visitcode FROM `master_transactionip` WHERE transactiondate BETWEEN '$ADate1' AND '$ADate2' group by billnumber)
						UNION ALL SELECT SUM(1*ABS(amount)) as income FROM `billing_ipnhif` WHERE visitcode IN (select visitcode FROM `billing_ipcreditapprovedtransaction` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' group by billno)
						UNION ALL SELECT SUM(-1*transactionamount) as income FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `docno` LIKE 'AR-%' AND `transactionstatus` = 'onaccount' AND `transactionmodule` = 'PAYMENT'";
		$execcr1 = mysql_query($querycr1bnk) or die ("Error in querycr1bnk".mysql_error());
		while($rescr1 = mysql_fetch_array($execcr1))
		{
		$i = $i+1;
		$crresult[$i] = $rescr1['income'];
		}
		
		$balance = array_sum($crresult);
		$sumbalance = $sumbalance + $balance;
	}*/
	else 
	{
		$balance = 0;
		$sumbalance = $sumbalance + $balance;
	}
	
}
?>					