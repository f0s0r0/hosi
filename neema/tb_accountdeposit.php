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
					/*  */
					if($id != '')
					{					 
						$i = 0;
						$drresult = array();
						$querydr1dp = "SELECT SUM(`transactionamount`) as depositref FROM `master_transactionipdeposit` WHERE visitcode IN (select visitcode FROM `master_transactionip` WHERE transactiondate BETWEEN '$ADate1' AND '$ADate2' group by billnumber)
										UNION ALL SELECT SUM(`transactionamount`) as depositref FROM `master_transactionadvancedeposit` WHERE visitcode IN (select visitcode FROM `master_transactionip` WHERE transactiondate BETWEEN '$ADate1' AND '$ADate2' group by billnumber)
										UNION ALL SELECT SUM(`transactionamount`) as depositref FROM `master_transactionipdeposit` WHERE visitcode IN (select visitcode FROM `billing_ipcreditapprovedtransaction` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' group by billno)
										UNION ALL SELECT SUM(`transactionamount`) as depositref FROM `master_transactionadvancedeposit` WHERE visitcode IN (select visitcode FROM `billing_ipcreditapprovedtransaction` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' group by billno)
										UNION ALL SELECT SUM(debitamount) as depositref FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
						$execdr1 = mysql_query($querydr1dp) or die ("Error in querydr1dp".mysql_error());
						while($resdr1 = mysql_fetch_array($execdr1))
						{
						$i = $i+1;
						$drresult[$i] = $resdr1['depositref'];
						}
						
						$j = 0;
						$crresult = array();
						$querycr1dp = "SELECT SUM(amount) as deposit FROM `deposit_refund` WHERE visitcode IN (select visitcode FROM `master_transactionip` WHERE transactiondate BETWEEN '$ADate1' AND '$ADate2')
									 UNION ALL SELECT SUM(amount) as deposit FROM `deposit_refund` WHERE visitcode IN (select visitcode FROM `billing_ipcreditapprovedtransaction` WHERE billdate BETWEEN '$ADate1' AND '$ADate2')
									 UNION ALL SELECT SUM(`transactionamount`) as deposit FROM `master_transactionadvancedeposit` WHERE `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									 UNION ALL SELECT SUM(`transactionamount`) as deposit FROM `master_transactionipdeposit` WHERE `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactionmodule` = 'PAYMENT'
									 UNION ALL SELECT SUM(`transactionamount`) as deposit FROM `master_mortuaryexternaldeposit` WHERE `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactionmodule` = 'PAYMENT'
									 UNION ALL SELECT SUM(creditamount) as deposit FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
						$execcr1 = mysql_query($querycr1dp) or die ("Error in querycr1dp".mysql_error());
						while($rescr1 = mysql_fetch_array($execcr1))
						{
						$j = $j+1;
						$crresult[$j] = $rescr1['deposit'];
						}
						
						$balance = array_sum($crresult) - array_sum($drresult);
					}	
					
					$sumbalance = $sumbalance + $balance;
					
				}
?>					