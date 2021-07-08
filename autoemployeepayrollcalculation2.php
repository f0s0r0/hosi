<?php
//session_start();
//include ("db/db_connect.php");

//if (isset($_REQUEST["employeesearch"])) { $employeesearch = $_REQUEST["employeesearch"]; } else { $employeesearch = ""; }
$sumofcomponent = '';
$sumofcomponent51 = '';
$sumofcomponent55 = '';
$sumoftotalearnings = '';

//echo $employeesearch;

if($employeesearch != '')
{
$query6 = "select * from master_employee where employeecode = '$employeesearch'";
$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
$res6 = mysql_fetch_array($exec6);
$payrollstatus = $res6['payrollstatus'];
if($payrollstatus == 'Active')
{
$query2 = "select * from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted' order by type desc";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
while ($res2 = mysql_fetch_array($exec2))
{
	$anum = $res2['auto_number'];
	$componentanum = $res2['componentanum'];
	$employeecode = $res2['employeecode'];
	$employeename = $res2['employeename'];
	$componentname = $res2['componentname'];
	$componentvalue = $res2['componentvalue'];
	$amounttype = $res2['amounttype'];
	if($amounttype == 'Percent')
	{
		$formulafrom = $res2['formula'];
		if($formulafrom == '1')
		{
			$query4 = "select * from payroll_assign where employeecode = '$employeesearch' and componentanum = '$formulafrom' and status <> 'deleted'";
			$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
			$res4 = mysql_fetch_array($exec4);
			$value = $res4['componentvalue'];
			
			$calc1 = $value * ($componentvalue/100);
			$calc1 = number_format($calc1,2,'.','');
			$calc1 = round_calc($calc1);
			
			$query86 = "select * from master_payrollcomponent where auto_number = '$componentanum'";
			$exec86 = mysql_query($query86) or die ("Error in Query86".mysql_error());
			$res86 = mysql_fetch_array($exec86);
			$notexceed = $res86['notexceed'];
			if($notexceed != '0.00')
			{
				if($calc1 > $notexceed)
				{
					$resamount = $notexceed;
				}
				else
				{
					$resamount = $calc1;
				}
			}
			else
			{
				$resamount = $calc1;
			}
				
			
			$query6 = "update payroll_assign set componentamount = '$resamount' where employeecode = '$employeesearch' and componentanum = '$componentanum' and status <> 'deleted'";
			$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
		}
		else if($formulafrom == '1+2')
		{	
			$sumofcomponent = '';
			for($i=1;$i<=2;$i++)
			{
				$query5 = "select * from payroll_assign where employeecode = '$employeesearch' and componentanum = '$i' and status <> 'deleted'";
				$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
				$res5 = mysql_fetch_array($exec5);
				$res5value = $res5['componentamount'];
				$sumofcomponent = $sumofcomponent + $res5value;
			}
				$calc1 = $sumofcomponent * ($componentvalue / 100);
				$calc1 = number_format($calc1,2,'.','');
				$calc1 = round_calc($calc1);
				
				$query86 = "select * from master_payrollcomponent where auto_number = '$componentanum'";
				$exec86 = mysql_query($query86) or die ("Error in Query86".mysql_error());
				$res86 = mysql_fetch_array($exec86);
				$notexceed = $res86['notexceed'];
				if($notexceed != '0.00')
				{
					if($calc1 > $notexceed)
					{
						$resamount = $notexceed;
					}
					else
					{
						$resamount = $calc1;
					}
				}
				else
				{
					$resamount = $calc1;
				}
				
				
				$query8 = "update payroll_assign set componentamount = '$resamount' where employeecode = '$employeesearch' and componentanum = '$componentanum' and status <> 'deleted'";
				$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
		}
		else if($formulafrom == 'Gross')
		{
			$totalgrossper = '';
			$query78 = "select * from payroll_assign where employeecode = '$employeesearch' and typecode = '10' and status <> 'deleted'";
			$exec78 = mysql_query($query78) or die ("Error in Query78".mysql_error());
			while($res78 = mysql_fetch_array($exec78))
			{
				$res78value = $res78['componentamount'];
				$totalgrossper = $totalgrossper + $res78value;
			}
			$calc3 = $totalgrossper * ($componentvalue / 100);
			$calc3 = number_format($calc3,2,'.','');
			$calc3 = round_calc($calc3);
			
			$query86 = "select * from master_payrollcomponent where auto_number = '$componentanum'";
			$exec86 = mysql_query($query86) or die ("Error in Query86".mysql_error());
			$res86 = mysql_fetch_array($exec86);
			$notexceed = $res86['notexceed'];
			if($notexceed != '0.00')
			{
				if($calc3 > $notexceed)
				{
					$resamount = $notexceed;
				}
				else
				{
					$resamount = $calc3;
				}
			}
			else
			{
				$resamount = $calc3;
			}
			
			$query8 = "update payroll_assign set componentamount = '$resamount' where employeecode = '$employeesearch' and componentanum = '$componentanum' and status <> 'deleted'";
			$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
				
		}
		else
		{
			
		}
	}	
	else
	{
		$calc1 = $componentvalue;
		$calc1 = number_format($calc1,2,'.','');
		$calc1 = round_calc($calc1);
		$query7 = "update payroll_assign set componentamount = '$componentvalue' where employeecode = '$employeesearch' and componentanum = '$componentanum' and status <> 'deleted'";
		$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
	}
	$sumofcomponent51 = '';
	$query1 = "select * from master_otcalculation where componentanum = '$componentanum' and status <> 'deleted'";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	$res1 = mysql_fetch_array($exec1);
	$rate = $res1['rate'];
	if($rate != '')
	{
		$totalhours = $res1['totalhours'];
		$totaldays = $res1['totaldays'];
		$res1formula = $res1['calculationanum'];
		if($res1formula == '1+2')
		{	
			for($j=1;$j<=2;$j++)
			{
				$query51 = "select * from payroll_assign where employeecode = '$employeesearch' and componentanum = '$j' and status <> 'deleted'";
				$exec51 = mysql_query($query51) or die ("Error in Query51".mysql_error());
				$res51 = mysql_fetch_array($exec51);
				$res51value = $res51['componentamount'];
				$sumofcomponent51 = $sumofcomponent51 + $res51value;
			}
		}
		else if($res1formula == '2')
		{
			$totalgrossper1 = '';
			$query78 = "select * from payroll_assign where employeecode = '$employeesearch' and typecode = '10' and componentanum NOT IN ('3','4') and status <> 'deleted'";
			$exec78 = mysql_query($query78) or die ("Error in Query78".mysql_error());
			while($res78 = mysql_fetch_array($exec78))
			{
				$res78value = $res78['componentamount'];
				$totalgrossper1 = $totalgrossper1 + $res78value;
			}
			
			$sumofcomponent51 = $totalgrossper1;
				
		}
		else if($res1formula == '1')
		{
			$query52 = "select * from payroll_assign where employeecode = '$employeesearch' and componentanum = '$res1formula' and status <> 'deleted'";
			$exec52 = mysql_query($query52) or die ("Error in Query52".mysql_error());
			$res52 = mysql_fetch_array($exec52);
			$res52value = $res52['componentamount'];
			$sumofcomponent51 = $sumofcomponent51 + $res52value;
		}	
	
			$otcalculation = ($sumofcomponent51 / $totaldays / $totalhours) * $rate;
			$otcalculation = number_format($otcalculation,2,'.','');
			$otcalculation = round_calc($otcalculation);
			
			$query57 = "update payroll_assign set componentamount = '$otcalculation' where employeecode = '$employeesearch' and componentanum = '$componentanum' and status <> 'deleted'";
			$exec57 = mysql_query($query57) or die ("Error in Query57".mysql_error());
	}
	
	$sumofcomponent55 = '';
	$query13 = "select * from master_absent where componentanum = '$componentanum' and status <> 'deleted'";
	$exec13 = mysql_query($query13) or die ("Error in Query13".mysql_error());
	$res13 = mysql_fetch_array($exec13);
	$totaldays = $res13['totaldays'];
	if($totaldays != '')
	{
		$res13formula = $res13['formula'];
		if($res13formula == '1+2')
		{	
			for($k=1;$k<=2;$k++)
			{
				$query55 = "select * from payroll_assign where employeecode = '$employeesearch' and componentanum = '$k' and status <> 'deleted'";
				$exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
				$res55 = mysql_fetch_array($exec55);
				$res55value = $res55['componentamount'];
				$sumofcomponent55 = $sumofcomponent55 + $res55value;
			}
		}
		else if($res13formula == '1')
		{
			$query56 = "select * from payroll_assign where employeecode = '$employeesearch' and componentanum = '$res13formula' and status <> 'deleted'";
			$exec56 = mysql_query($query56) or die ("Error in Query56".mysql_error());
			$res56 = mysql_fetch_array($exec56);
			$res56value = $res56['componentamount'];
			$sumofcomponent55 = $sumofcomponent55 + $res56value;
		}	
	
			$absentcalculation = $sumofcomponent55 / $totaldays;
			$absentcalculation = number_format($absentcalculation,2,'.','');
			$absentcalculation = round_calc($absentcalculation);
			
			$query58 = "update payroll_assign set componentamount = '$absentcalculation' where employeecode = '$employeesearch' and componentanum = '$componentanum' and status <> 'deleted'";
			$exec58 = mysql_query($query58) or die ("Error in Query58".mysql_error());
	}
	
	$query15 = "select * from master_nssf where componentanum = '$componentanum' and status <> 'deleted'";
	$exec15 = mysql_query($query15) or die ("Error in Query15".mysql_error());
	$res15 = mysql_fetch_array($exec15);
	$res15amount = $res15['amount'];
	$res15percent = $res15['percent'];
	$res15basedon = $res15['basedon'];
	if($res15basedon == 'Amount')
	{	
		$res15amount = number_format($res15amount,2,'.','');
		$res15amount = round_calc($res15amount);
		
		$query88 = "select * from master_employee where employeecode = '$employeesearch'";
		$exec88 = mysql_query($query88) or die ("Error in Query88".mysql_error());
		$res88 = mysql_fetch_array($exec88);
		$res88employeename = $res88['employeename'];
		$res88excludenssf = $res88['excludenssf'];
		
		if($res88excludenssf == 'Yes')
		{
		$query59 = "update payroll_assign set componentamount = '0.00' where employeecode = '$employeesearch' and componentanum = '$componentanum' and status <> 'deleted'";
		$exec59 = mysql_query($query59) or die ("Error in Query59".mysql_error());
		}
		else
		{
		$query591 = "update payroll_assign set componentamount = '$res15amount' where employeecode = '$employeesearch' and componentanum = '$componentanum' and status <> 'deleted'";
		$exec591 = mysql_query($query591) or die ("Error in Query591".mysql_error());
		}
	}
	else if($res15basedon == 'Percent')
	{
		$totalgrossnssf1 = '';
		$query785 = "select * from payroll_assign where employeecode = '$employeesearch' and typecode = '10' and componentanum NOT IN ('3','4') and status <> 'deleted'";
		$exec785 = mysql_query($query785) or die ("Error in Query785".mysql_error());
		while($res785 = mysql_fetch_array($exec785))
		{
			$res785value = $res785['componentamount'];
			$totalgrossnssf1 = $totalgrossnssf1 + $res785value;
		}
		$totalgrossnssf1 = number_format($totalgrossnssf1,2,'.','');
		$totalgrossnssf1 = round_calc($totalgrossnssf1);
		
		$res15amount = $totalgrossnssf1 * ($res15percent / 100);
		$res15amount = number_format($res15amount,2,'.','');
		$res15amount = round_calc($res15amount);
		
		$query88 = "select * from master_employee where employeecode = '$employeesearch'";
		$exec88 = mysql_query($query88) or die ("Error in Query88".mysql_error());
		$res88 = mysql_fetch_array($exec88);
		$res88employeename = $res88['employeename'];
		$res88excludenssf = $res88['excludenssf'];
		
		if($res88excludenssf == 'Yes')
		{
		$query59 = "update payroll_assign set componentamount = '0.00' where employeecode = '$employeesearch' and componentanum = '$componentanum' and status <> 'deleted'";
		$exec59 = mysql_query($query59) or die ("Error in Query59".mysql_error());
		}
		else
		{
		$query591 = "update payroll_assign set componentamount = '$res15amount' where employeecode = '$employeesearch' and componentanum = '$componentanum' and status <> 'deleted'";
		$exec591 = mysql_query($query591) or die ("Error in Query591".mysql_error());
		}			
	}
}

//include("autoemployeeloandetails3.php");
include("autopayecalculation2.php");

}

}
?>