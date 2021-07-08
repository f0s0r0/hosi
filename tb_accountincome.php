<?php
$journal = 0;
				$query267 = "select accountname,auto_number,id from master_accountname where accountssub = '$parentid'";
				$exec267 = mysql_query($query267) or die ("Error in Query267".mysql_error());
				while($res267 = mysql_fetch_array($exec267))
				{  
					$accountsmain2 = $res267['accountname'];
					$parentid2 = $res267['auto_number'];
					$ledgeranum = $parentid2;
					$id = $res267['id'];
					
					$k = 0;
					$jresult = array();
					$querydr11 = "SELECT SUM(-1*debitamount) as journal FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
								 UNION ALL SELECT SUM(creditamount) as journal FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
					$execdr11 = mysql_query($querydr11) or die ("Error in Querydr11".mysql_error());
					while($resdr11 = mysql_fetch_array($execdr11))
					{
					$k = $k+1;
					$jresult[$k] = $resdr11['journal'];
					}
					$journal = array_sum($jresult);
	
					/*  
					
					*/
					if($id == '01-1006')
					{
						$i = 0;
						$drresult = array();
						$querydr1in = "SELECT SUM(`amount`) as incomedr FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `accountcode` <> ''
										
										UNION ALL SELECT SUM(`consultation`) as incomedr FROM `refund_consultation` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
										UNION ALL SELECT SUM(`labitemrate`) as incomedr FROM `refund_paynowlab` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
										UNION ALL SELECT SUM(`amount`) as incomedr FROM `refund_paynowpharmacy` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
										UNION ALL SELECT SUM(`radiologyitemrate`) as incomedr FROM `refund_paynowradiology` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
										UNION ALL SELECT SUM(`servicesitemrate`) as incomedr FROM `refund_paynowservices` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
										UNION ALL SELECT SUM(`referalrate`) as incomedr FROM `refund_paynowreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
										
										UNION ALL SELECT SUM(`labitemrate`) as incomedr FROM `refund_paylaterlab` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
										UNION ALL SELECT SUM(`radiologyitemrate`) as incomedr FROM `refund_paylaterradiology` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
										UNION ALL SELECT SUM(`amount`) as incomedr FROM `refund_paylaterservices` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
										UNION ALL SELECT SUM(`amount`) as incomedr FROM `refund_paylaterambulance` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
										UNION ALL SELECT SUM(`amount`) as incomedr FROM `refund_paylaterhomecare` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
										UNION ALL SELECT SUM(`referalrate`) as incomedr FROM `refund_paylaterreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
										
										UNION ALL SELECT SUM(`amount`) as incomedr FROM `paylaterpharmareturns` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' AND `billnumber` IN (SELECT b.`docno` FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number`)";
										//UNION ALL SELECT SUM(`amount`) as incomedr FROM `paylaterpharmareturns` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'";
					
						$execdr1 = mysql_query($querydr1in) or die ("Error in querydr1in".mysql_error());
						while($resdr1 = mysql_fetch_array($execdr1))
						{
						$i = $i+1;
						$drresult[$i] = $resdr1['incomedr'];
						}
						
						/*
						
						*/
						$j = 0;
						$crresult = array();  
						$querycr1in = "SELECT SUM(`consultation`) as income FROM `billing_consultation` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2'
						
										UNION ALL SELECT SUM(`labitemrate`) as income FROM `billing_paynowlab` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2'
										UNION ALL SELECT ROUND(SUM(`amount`)) as income FROM `billing_paynowpharmacy` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2' group by billnumber
										UNION ALL SELECT SUM(`radiologyitemrate`) as income FROM `billing_paynowradiology` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2'
										UNION ALL SELECT SUM(`amount`) as income FROM `billing_paynowservices` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2'
										UNION ALL SELECT SUM(`referalrate`) as income FROM `billing_paynowreferal` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2'
										UNION ALL SELECT SUM(`subtotal`) as income FROM `billing_referal` WHERE billnumber LIKE '%OPC%' AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
										
										UNION ALL SELECT SUM(`labitemrate`) as income FROM `billing_externallab` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2'
										UNION ALL SELECT ROUND(SUM(`amount`)) as income FROM `billing_externalpharmacy` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2' group by billnumber
										UNION ALL SELECT SUM(`radiologyitemrate`) as income FROM `billing_externalradiology` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2'
										UNION ALL SELECT SUM(`servicesitemrate`) as income FROM `billing_externalservices` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2'
										UNION ALL SELECT SUM(`servicesitemrate` * `quantity`) as income FROM `mortuaryexternal_services` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2'
								
										UNION ALL SELECT SUM(`totalamount`) as income FROM `billing_paylaterconsultation` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2'
										UNION ALL SELECT SUM(`labitemrate`) as income FROM `billing_paylaterlab` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2'
										UNION ALL SELECT SUM(`amount`) as income FROM `billing_paylaterpharmacy` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2'
										UNION ALL SELECT SUM(`radiologyitemrate`) as income FROM `billing_paylaterradiology` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2'
										UNION ALL SELECT SUM(`amount`) as income FROM `billing_paylaterservices` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2'
										UNION ALL SELECT SUM(`referalrate`) as income FROM `billing_paylaterreferal` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2'
										UNION ALL SELECT SUM(`subtotal`) as income FROM `billing_referal` WHERE billnumber LIKE '%CB%' AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
						
									    UNION ALL SELECT SUM(`amount`) as income FROM `billing_ipadmissioncharge` WHERE `recorddate` BETWEEN '$ADate1' AND '$ADate2'
										UNION ALL SELECT SUM(`amount`) as income FROM `billing_ipambulance` WHERE `recorddate` BETWEEN '$ADate1' AND '$ADate2'
										UNION ALL SELECT SUM(`amount`) as income FROM `billing_ipbedcharges` WHERE `recorddate` BETWEEN '$ADate1' AND '$ADate2'
										UNION ALL SELECT SUM(`labitemrate`) as income FROM `billing_iplab` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2'
										UNION ALL SELECT SUM(`amount`) as income FROM `billing_ipmiscbilling` WHERE `recorddate` BETWEEN '$ADate1' AND '$ADate2'
										UNION ALL SELECT SUM(`amount`) as income FROM `billing_iphomecare` WHERE `recorddate` BETWEEN '$ADate1' AND '$ADate2'
										UNION ALL SELECT SUM(`amount`) as income FROM `billing_ippharmacy` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2'
										UNION ALL SELECT SUM(`amount`) as income FROM `billing_ipprivatedoctor` WHERE `recorddate` BETWEEN '$ADate1' AND '$ADate2'
										UNION ALL SELECT SUM(`radiologyitemrate`) as income FROM `billing_ipradiology` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2'
										UNION ALL SELECT SUM(`servicesitemrate`) as income FROM `billing_ipservices` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2'
										
										UNION ALL SELECT SUM(`amount`) as income FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and accountcode <> ''";
						$execcr1 = mysql_query($querycr1in) or die ("Error in querycr1in".mysql_error());
						while($rescr1 = mysql_fetch_array($execcr1))
						{
						$j = $j+1;
						$crresult[$j] = $rescr1['income'];
						}
						
						$balance = array_sum($crresult) - array_sum($drresult);
					}
					else 
					{
						$balance = 0;
					}
					
					$balance = $balance + $journal;
					$sumbalance = $sumbalance + $balance;
				}
				
				$sumbalance;
?>					