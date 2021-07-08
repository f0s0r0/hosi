<?php
				$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$parentid'";
				$exec267 = mysql_query($query267) or die ("Error in Query267".mysql_error());
				while($res267 = mysql_fetch_array($exec267))
				{  
					$accountsmain2 = $res267['accountname'];
					$parentid2 = $res267['auto_number'];
					$ledgeranum = $parentid2;
					$id = $res267['id'];
					if($id != '')
					{
						$i = 0;
						$result = array();
						$querydr1 = "SELECT SUM(`totalamount`) as expenses FROM `expensepurchase_details` WHERE `expensecode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and recordstatus <> 'deleted'
									 UNION ALL SELECT SUM(`totalamount`) as expenses FROM `purchase_details` WHERE `expensecode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and recordstatus <> 'deleted'
									 UNION ALL SELECT SUM(`transactionamount`) as expenses FROM `expensesub_details` WHERE `expensecoa` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									 UNION ALL SELECT SUM(debitamount) as expenses FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
									 UNION ALL SELECT SUM(-1*creditamount) as expenses FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
									 UNION ALL SELECT SUM(amount) as expenses FROM `master_stock_transfer` WHERE `tostore` = '$id' AND typetransfer = 'Consumable' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
									 UNION ALL SELECT SUM(transactionamount) as expenses FROM master_transactionpayroll WHERE accountcode = '$id' AND transactiontype = 'PROCESS' AND updatedate BETWEEN '$ADate1' AND '$ADate2'";
						$execdr1 = mysql_query($querydr1) or die ("Error in Querydr1".mysql_error());
						while($resdr1 = mysql_fetch_array($execdr1))
						{
						$i = $i+1;
						$result[$i] = $resdr1['expenses'];
						}
						
						$bankcredit = 0;
					}
					else
					{
						$result = array();
						$bankcredit = 0;
					}
					
					$balance = array_sum($result) - $bankcredit;
					
					$sumbalance = $sumbalance + $balance;
					
				}
				
?>					