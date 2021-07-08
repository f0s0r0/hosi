<?php
				$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$parentid'";
				$exec267 = mysql_query($query267) or die ("Error in Query267".mysql_error());
				while($res267 = mysql_fetch_array($exec267))
				{  
					$accountsmain2 = $res267['accountname'];
					$orderid1 = $orderid1 + 1;
					$parentid2 = $res267['auto_number'];
					$ledgeranum = $parentid2;
					$id = $res267['id'];
					$lid = $lid + 1;
					/* 
					 UNION ALL SELECT SUM(openbalanceamount) as paylater FROM `openingbalanceaccount` WHERE `accountcode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
					 
					*/
					$i = 0;
					$result = array();
					$querydr1 = "SELECT SUM(`transactionamount`) as paylater FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'finalize' AND `billnumber` LIKE '%CB%'
								 UNION ALL SELECT SUM(`transactionamount`) as paylater FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'finalize' AND `billnumber` LIKE '%IPDr%'
					 			 UNION ALL SELECT SUM(`transactionamount`) as paylater FROM `master_transactionip` WHERE `accountnameid` = '$id' AND billtype = 'PAY LATER' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
								 UNION ALL SELECT SUM(`totalamount`) as paylater FROM `billing_ipcreditapprovedtransaction` WHERE `accountnameid` = '$id' AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
								 UNION ALL SELECT SUM(debitamount) as paylater FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
					$execdr1 = mysql_query($querydr1) or die ("Error in Querydr1".mysql_error());
					$num = mysql_num_rows($execdr1);
					while($resdr1 = mysql_fetch_array($execdr1))
					{
					$i = $i+1;
					$result[$i] = $resdr1['paylater'];
					}
					
					/* 
					 */
					$j = 0;
					$crresult = array();
					$querycr1 = "SELECT SUM(transactionamount) as paylatercredit FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `docno` LIKE '%IPCr%' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'paylatercredit'
								 UNION ALL SELECT SUM(transactionamount) as paylatercredit FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `docno` LIKE 'Cr.N%' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'paylatercredit'
								 UNION ALL SELECT SUM(`amount`) as paylatercredit FROM `paylaterpharmareturns` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' AND `billnumber` IN (SELECT b.`docno` FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE a.accountnameid = '$id' and b.accountnameid = '$id' and a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number`)
								 UNION ALL SELECT SUM(transactionamount) as paylatercredit FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `docno` LIKE 'AR-%' AND `transactionstatus` = 'onaccount' AND `transactionmodule` = 'PAYMENT'
								 UNION ALL SELECT SUM(creditamount) as paylatercredit FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
					$execcr1 = mysql_query($querycr1) or die ("Error in Querycr1".mysql_error());
					while($rescr1 = mysql_fetch_array($execcr1))
					{
					$j = $j+1;
					$crresult[$j] = $rescr1['paylatercredit'];
					}
					
					$balance = array_sum($result) - array_sum($crresult);
			
					$sumbalance = $sumbalance + $balance;
				}
?>					