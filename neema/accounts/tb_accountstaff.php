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
	
	if($id != '') 
	{
		$i = 0;
		$result = array();
		$querydr1 = "SELECT SUM(transactionamount) as payroll FROM master_transactionpayroll WHERE accountcode = '$id' AND transactiontype = 'PROCESS' AND updatedate BETWEEN '$ADate1' AND '$ADate2'
					 UNION ALL SELECT SUM(-1*transactionamount) as payroll FROM master_transactionpayroll WHERE accountcode = '$id' AND transactionmodule = 'PAYMENT' AND recordstatus = 'allocated' AND transactiondate BETWEEN '$ADate1' AND '$ADate2'";
		$execdr1 = mysql_query($querydr1) or die ("Error in Querydr1".mysql_error());
		while($resdr1 = mysql_fetch_array($execdr1))
		{
		$i = $i+1;
		$result[$i] = $resdr1['payroll'];
		}
	}
	else
	{
		$result = array();
	}
	
	$balance = array_sum($result);
	
	$sumbalance = $sumbalance + $balance;
	
}
?>					