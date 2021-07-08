<?php
$sumbalance = 0;
$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$parentid'";
$exec267 = mysql_query($query267) or die ("Error in Query267".mysql_error());
while($res267 = mysql_fetch_array($exec267))
{  
	$accountsmain2 = $res267['accountname'];
	$parentid2 = $res267['auto_number'];
	$ledgeranum = $parentid2;
	$id = $res267['id'];
	
	$i = 0;
	$result = array();
	$querydr1 = "SELECT SUM(`totalamount`) as assetvalue FROM `assetpurchase_details` WHERE `assetcode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and recordstatus <> 'deleted'
				 UNION ALL SELECT SUM(debitamount) as assetvalue FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
				 UNION ALL SELECT SUM(-1*creditamount) as assetvalue FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
	$execdr1 = mysql_query($querydr1) or die ("Error in Querydr1".mysql_error());
	while($resdr1 = mysql_fetch_array($execdr1))
	{
	$i = $i+1;
	$result[$i] = $resdr1['assetvalue'];
	}
	$balance = array_sum($result);
	
	$sumbalance = $sumbalance + $balance;
}
?>			