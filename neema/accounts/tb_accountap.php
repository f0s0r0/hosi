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
					
					$i = 0;
					$result = array();
					$querydr1 = "SELECT SUM(`transactionamount`) as payablesdr FROM `master_transactionpharmacy` WHERE `suppliercode` = '$id' AND `transactionmodule` = 'PAYMENT' AND `recordstatus` = 'allocated' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
								 UNION ALL SELECT SUM(`totalamount`) as payablesdr FROM `purchasereturn_details` WHERE `suppliercode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
								 UNION ALL SELECT SUM(`transactionamount`) as payablesdr FROM `master_transactiondoctor` WHERE `doctorcode` = '$id' AND `transactionmodule` = 'PAYMENT' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
								 UNION ALL SELECT SUM(debitamount) as payablesdr FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
								 UNION ALL SELECT SUM(`transactionamount`) as payablesdr FROM `master_transactionpayroll` WHERE `accountcode` = '$id' AND `transactionmodule` = 'PAYMENT' AND `recordstatus` = 'allocated' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'";
					$execdr1 = mysql_query($querydr1) or die ("Error in Querydr1".mysql_error());
					while($resdr1 = mysql_fetch_array($execdr1))
					{
					$i = $i+1;
					$result[$i] = $resdr1['payablesdr'];
					}
				 
					$j = 0;
					$crresult = array();
					$querycr1 = "SELECT SUM(`transactionamount`) as payables FROM `master_transactionpharmacy` WHERE `suppliercode` = '$id' AND `transactiontype` = 'PURCHASE' AND particulars <> '' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
								 UNION ALL SELECT SUM(creditamount) as payables FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
								 UNION ALL SELECT SUM(transactionamount) as payables FROM master_transactionpayroll WHERE accountcode = '$id' AND transactiontype = 'PROCESS' AND updatedate BETWEEN '$ADate1' AND '$ADate2'";
								 //UNION ALL SELECT SUM(openbalanceamount) as payables FROM `openingbalancesupplier` WHERE `accountcode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
						
					$execcr1 = mysql_query($querycr1) or die ("Error in Querycr1".mysql_error());
					while($rescr1 = mysql_fetch_array($execcr1))
					{
					$j = $j+1;
					$crresult[$j] = $rescr1['payables'];
					}
					
					$balance = array_sum($crresult) - array_sum($result);
					
					$sumbalance = $sumbalance + $balance;
					
				}
?>					