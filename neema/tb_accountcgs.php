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
	
					if($id == '02-2001')
					{
						$i = 0;
						$result = array();
						$querydr1 = "SELECT SUM(`totalcp`) as stockpurchase FROM `pharmacysales_details` WHERE `entrydate` BETWEEN '$ADate1' AND '$ADate2'
									 UNION ALL SELECT SUM(debitamount) as stockpurchase FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
						$execdr1 = mysql_query($querydr1) or die ("Error in Querydr1".mysql_error());
						while($resdr1 = mysql_fetch_array($execdr1))
						{
						$i = $i+1;
						//print_r($resdr1);
						$result[$i] = $resdr1['stockpurchase'];
						//$paylater = $result[$i];
						}
						
						$j = 0;
						$resultcr = array();
						$querycr1 = "SELECT SUM(`totalcp`) as stockreturn FROM `pharmacysalesreturn_details` WHERE `entrydate` BETWEEN '$ADate1' AND '$ADate2'
									 UNION ALL SELECT SUM(creditamount) as stockreturn FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
						$execcr1 = mysql_query($querycr1) or die ("Error in Querycr1".mysql_error());
						while($rescr1 = mysql_fetch_array($execcr1))
						{
						$j = $j+1;
						//print_r($resdr1);
						$resultcr[$j] = $rescr1['stockreturn'];
						//$paylater = $result[$i];
						}
						$balance = array_sum($result) - array_sum($resultcr);
					} else {
						$balance = 0;
					}
			
					$sumbalance = $sumbalance + $balance;
			}
?>			