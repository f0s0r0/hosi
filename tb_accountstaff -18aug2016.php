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
					if($id == '04-4001-01')  
					{
						$i = 0;
						$drresult = array();
						$querydr1pay = "SELECT SUM(`componentamount`) as payroll FROM `details_employeepayroll` WHERE `componentanum` = '1' AND DATE(`updatedatetime`) BETWEEN '$ADate1' AND '$ADate2'
									 UNION ALL SELECT SUM(`componentamount`) as payroll FROM `details_employeepayroll` WHERE `componentanum` = '6' AND DATE(`updatedatetime`) BETWEEN '$ADate1' AND '$ADate2'
									 UNION ALL SELECT SUM(`componentamount`) as payroll FROM `details_employeepayroll` WHERE `componentanum` = '7' AND DATE(`updatedatetime`) BETWEEN '$ADate1' AND '$ADate2'
									 UNION ALL SELECT SUM(`componentamount`) as payroll FROM `details_employeepayroll` WHERE `componentanum` = '8' AND DATE(`updatedatetime`) BETWEEN '$ADate1' AND '$ADate2'
									 UNION ALL SELECT SUM(`componentamount`) as payroll FROM `details_employeepayroll` WHERE `componentanum` = '88' AND DATE(`updatedatetime`) BETWEEN '$ADate1' AND '$ADate2'
									 UNION ALL SELECT SUM(`componentamount`) as payroll FROM `details_employeepayroll` WHERE `componentanum` NOT IN ('0','1','6','7','8','88') AND DATE(`updatedatetime`) BETWEEN '$ADate1' AND '$ADate2'";
						$execdr1 = mysql_query($querydr1pay) or die ("Error in querydr1pay".mysql_error());
						while($resdr1 = mysql_fetch_array($execdr1))
						{
						$i = $i+1;
						$drresult[$i] = $resdr1['payroll'];
						}
						$balance = array_sum($drresult);
					} else if($id == '08-9101') {
						$querydr1pay = "SELECT SUM(`componentamount`) as payroll FROM `details_employeepayroll` WHERE `componentanum` = '8' AND DATE(`updatedatetime`) BETWEEN '$ADate1' AND '$ADate2'";
						$execdr1 = mysql_query($querydr1pay) or die ("Error in querydr1pay".mysql_error());
						$resdr1 = mysql_fetch_array($execdr1);
						$balance = $resdr1['payroll'];
					} else if($id == '08-9102') {
						$querydr1pay = "SELECT SUM(`componentamount`) as payroll FROM `details_employeepayroll` WHERE `componentanum` = '7' AND DATE(`updatedatetime`) BETWEEN '$ADate1' AND '$ADate2'";
						$execdr1 = mysql_query($querydr1pay) or die ("Error in querydr1pay".mysql_error());
						$resdr1 = mysql_fetch_array($execdr1);
						$balance = $resdr1['payroll'];
					} else if($id == '08-9103') {
						$querydr1pay = "SELECT SUM(`componentamount`) as payroll FROM `details_employeepayroll` WHERE `componentanum` = '6' AND DATE(`updatedatetime`) BETWEEN '$ADate1' AND '$ADate2'";
						$execdr1 = mysql_query($querydr1pay) or die ("Error in querydr1pay".mysql_error());
						$resdr1 = mysql_fetch_array($execdr1);
						$balance = $resdr1['payroll'];
					} else if($id == '08-9105') {
						$querydr1pay = "SELECT SUM(`componentamount`) as payroll FROM `details_employeepayroll` WHERE `componentanum` = '88' AND DATE(`updatedatetime`) BETWEEN '$ADate1' AND '$ADate2'";
						$execdr1 = mysql_query($querydr1pay) or die ("Error in querydr1pay".mysql_error());
						$resdr1 = mysql_fetch_array($execdr1);
						$balance = $resdr1['payroll'];
					} else if($id == '08-9109') {
						$querydr1pay = "SELECT SUM(`componentamount`) as payroll FROM `details_employeepayroll` WHERE `componentanum` NOT IN ('0','6','7','8','88') AND DATE(`updatedatetime`) BETWEEN '$ADate1' AND '$ADate2'";
						$execdr1 = mysql_query($querydr1pay) or die ("Error in querydr1pay".mysql_error());
						$resdr1 = mysql_fetch_array($execdr1);
						$balance = $resdr1['payroll'];
					} else {
						$balance = '0';
					}
					
					$sumbalance = $sumbalance + $balance;
					
				}
?>					