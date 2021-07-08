<?php
$taxableincome = '';
$totaldeductions = '0.00';
$sumoftotalearningsfinal = '';
$nssfamount = '';
$nhifamount = '';
$netpay = '0.00';
$res19absentamount = '0.00';
$totaldeductearning = '0.00';
$gratuity = '0.00';

$query31 = "select * from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted' and typecode = '10'";
$exec31 = mysql_query($query31) or die ("Error in Query31".mysql_error());
while ($res31 = mysql_fetch_array($exec31))
{
	$res31componentanum = $res31['componentanum'];
	$res31monthly = $res31['monthly'];
	//$res31componentamount = $res31['componentamount'];
	if($res31monthly == 'Yes')
	{
		$query32 = "select * from payroll_assignmonthwise where componentanum = '$res31componentanum' and employeecode = '$employeesearch' and assignmonth = '$assignmonth' and status <> 'deleted' and typecode = '10'";
		$exec32 = mysql_query($query32) or die ("Error in Query32".mysql_error());
		$res32 = mysql_fetch_array($exec32);
		$rows32 = mysql_num_rows($exec32);
		$res32componentname = $res32['componentname'];
		
		if($res32componentname != '')
		{	
			$componentamount = $res32['amount'];
		}
		//else if($res31componentanum == '3' || $res31componentanum == '4')
		else
		{
			//$componentamount = $res31['componentamount'];
			$componentamount = '0.00';
		}
	}	
	else
	{
		$componentamount = $res31['componentamount'];
		//$componentamount = '0.00';
	}
	//echo '<br>'.$componentamount;	
	$sumoftotalearnings = $sumoftotalearnings + $componentamount;
}

$query67 = "select * from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted' and typecode = '10' and taxinclude = 'No'";
$exec67 = mysql_query($query67) or die ("Error in Query67".mysql_error());
while ($res67 = mysql_fetch_array($exec67))
{
	$res67componentanum = $res67['componentanum'];
	$res67monthly = $res67['monthly'];
	//$res67componentamount = $res67['componentamount'];
	if($res67monthly == 'Yes')
	{
		$query68 = "select * from payroll_assignmonthwise where componentanum = '$res67componentanum' and employeecode = '$employeesearch' and assignmonth = '$assignmonth' and status <> 'deleted' and typecode = '10'";
		$exec68 = mysql_query($query68) or die ("Error in Query68".mysql_error());
		$res68 = mysql_fetch_array($exec68);
		$rows68 = mysql_num_rows($exec68);
		$res68componentname = $res68['componentname'];
		
		if($res68componentname != '')
		{	
			$componentamount1 = $res68['amount'];
		}
		//else if($res31componentanum == '3' || $res31componentanum == '4')
		else
		{
			//$componentamount = $res31['componentamount'];
			$componentamount1 = '0.00';
		}
	}	
	else
	{
		$componentamount1 = $res67['componentamount'];
		//$componentamount = '0.00';
	}
	//echo '<br>'.$componentamount;	
	$gratuity = $gratuity + $componentamount1;
}

$sumoftotalearnings = $sumoftotalearnings - $gratuity;

$query61 = "select * from details_loanpay where employeecode = '$employeesearch' and paymonth = '$assignmonth' and status <> 'deleted'";
$exec61 = mysql_query($query61) or die ("Error in Query61".mysql_error());
$res61 = mysql_fetch_array($exec61);
$res61loanname = $res61['loanname'];
if($res61loanname != '')
{
	$fringerate = $res61['fringerate'];
}
else
{
	$fringerate = '0.00';
}
//$fringerate;
$sumoftotalearnings = $sumoftotalearnings + $fringerate;

$sumoftotalearnings;
$res19absentamount = '';

$query39 = "select * from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
$exec39 = mysql_query($query39) or die ("Error in Query39".mysql_error());
while ($res39 = mysql_fetch_array($exec39))
{
	$res39componentanum = $res39['componentanum'];
	$res39componentamount = $res39['componentamount'];
	
	$query8 = "select * from master_payrollcomponent where auto_number = '$res39componentanum'";
	$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
	$res8 = mysql_fetch_array($exec8);
	$res8deductearning = $res8['deductearning'];
	$res8monthly = $res8['monthly'];
	if($res8deductearning == 'Yes' && $res8monthly == 'Yes')
	{
		$query19 = "select * from payroll_assignmonthwise where componentanum = '$res39componentanum' and employeecode = '$employeesearch' and assignmonth = '$assignmonth' and status <> 'deleted'";
		$exec19 = mysql_query($query19) or die ("Error in Query19".mysql_error());
		$res19 = mysql_fetch_array($exec19);
		$rows19 = mysql_num_rows($exec19);
		$res19componentname = $res19['componentname'];
		$res19componentanum = $res19['componentanum'];
		
		if($res19componentname != '' && $res19componentanum == '5')
		{	
			$res19absentamount = $res19['amount'];
		}
		else if($res31componentanum == '5')
		{
			//$componentamount = $res31['componentamount'];
			$res19absentamount = '0.00';
		}
	}
	else if($res8deductearning == 'Yes')
	{
		$totaldeductearning = $totaldeductearning + $res39componentamount;
	}
}

$res19absentamount;
$sumoftotalearningsfinal = $sumoftotalearnings - $res19absentamount - $totaldeductearning;
$sumoftotalearningsfinalnhif = $sumoftotalearnings;

$grosspay = $sumoftotalearnings;
$query71 = "select * from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted' and componentanum = '7'";
$exec71 = mysql_query($query71) or die ("Error in Query71".mysql_error());
$res71 = mysql_fetch_array($exec71);
$res71componentname = $res71['componentname'];
if($res71componentname != '')
{	
	$query34 = "select * from master_employee where employeecode = '$employeesearch'";
	$exec34 = mysql_query($query34) or die ("Error in Query34".mysql_error());
	$res34 = mysql_fetch_array($exec34);
	$res34excludenssf = $res34['excludenssf'];
	if($res34excludenssf == 'Yes')
	{
	$nssfamount = '0';
	}
	else
	{
	$nssfamount = $res71['componentamount'];
	}
}

	//$taxableincome = $sumoftotalearningsfinal - $nssfamount;
	$taxableincome = $sumoftotalearningsfinal;
	$nhiftaxableincome = $sumoftotalearningsfinalnhif;
	//$taxableincome = '8000';

$query72 = "select * from master_nhif where status <> 'deleted'";
$exec72 = mysql_query($query72) or die ("Error in Query72".mysql_error());
while($res72 = mysql_fetch_array($exec72))
{
	$res72from = $res72['from1'];
	$res72to = $res72['to1'];

	if($nhiftaxableincome >= $res72from && $nhiftaxableincome <= $res72to)
	{
		$query34 = "select * from master_employee where employeecode = '$employeesearch'";
		$exec34 = mysql_query($query34) or die ("Error in Query34".mysql_error());
		$res34 = mysql_fetch_array($exec34);
		$res34excludenhif = $res34['excludenhif'];
		if($res34excludenhif == 'Yes')
		{
		$nhifamount = '0';
		}
		else
		{
		$nhifamount = $res72['amount'];
		}
	}
}	

$nhifamount;
$taxableincome;
$totalpercentcalc = '';
$balance = '';
$totalbalance = 0;
$j = '0';
$query73 = "select * from master_paye where status <> 'deleted'";
$exec73 = mysql_query($query73) or die ("Error in Query73".mysql_error());
while($res73 = mysql_fetch_array($exec73))
{
	$res73from = $res73['from1'];
	$res73to = $res73['to1'];
	$res73percent = $res73['percent'];
	$template = $res73['template'];
	
	if($template == 'Kenya')
	{
		if($taxableincome >= $res73from && $taxableincome <= $res73to)
		{
			$difference = $res73['difference'];
			if($balance == "")
			{
				$payepercentcalc = $taxableincome * ($res73percent / 100);
			}
			else
			{
				$payepercentcalc = $balance * ($res73percent / 100);
			}
			$totalpercentcalc = $totalpercentcalc + $payepercentcalc;
			$j = '1';
		}
		else
		{
			if($j == '0')
			{
				$difference = $res73['difference'];
				if($balance == '')
				{
					$balance = $taxableincome - $difference;
				}
				else
				{
					$balance = $balance - $difference;
				}
				
				$payepercentcalc = $difference * ($res73percent / 100);
				$totalpercentcalc = $totalpercentcalc + $payepercentcalc;
			}
		}
	}
	else if($template == 'Uganda')
	{
		$res73add = $res73['addgross'];
		$res73deduct = $res73['deductgross'];
		if($taxableincome >= $res73from && $taxableincome <= $res73to)
		{
			$payepercentcalc = $res73add + (($taxableincome - $res73deduct) * ($res73percent / 100));   //10000+(Gross-335000)*20%
			$totalpercentcalc = $totalpercentcalc + $payepercentcalc;
		}
	}	
}

$totalpercentcalc;
$taxrelief = '0.00';
$query55 = "select * from master_taxrelief where status <> 'deleted'";
$exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
$res55 = mysql_fetch_array($exec55);
$res55finalamount = $res55['finalamount'];
if($res55finalamount != '')
{
	$taxrelief = $res55finalamount;
}

$query7 = "select * from insurance_relief where employeecode = '$employeesearch' and status <> 'deleted'";
$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
$res7 = mysql_fetch_array($exec7);
$res7employeecode = $res7['employeecode'];
$res7includepaye = $res7['includepaye'];
$res7premium = $res7['premium'];
$res7tax = $res7['taxpercent'];
if($res7employeecode != '' && $res7includepaye == 'Yes')
{
	$insurancerelief = $res7premium * ($res7tax / 100);
}
else
{
	$insurancerelief = '0.00';
}

$totalpayeeamount = $totalpercentcalc - $taxrelief - $insurancerelief;
//$totalpayeeamount = $totalpercentcalc;
$totalpayeeamount = number_format($totalpayeeamount,2,'.','');
$totalpayeeamount = round_calc($totalpayeeamount);

$query34 = "select * from master_employee where employeecode = '$employeesearch'";
$exec34 = mysql_query($query34) or die ("Error in Query34".mysql_error());
$res34 = mysql_fetch_array($exec34);
$res34excludepaye = $res34['excludepaye'];
if($res34excludepaye == 'Yes')
{	
	$query35 = "select * from master_dirpercent where status <> 'deleted'";
	$exec35 = mysql_query($query35) or die ("Error in Query35".mysql_error());
	$res35 = mysql_fetch_array($exec35);
	$res35dirpercent = $res35['finalamount'];
	
	$dirpercentamount = $taxableincome * ($res35dirpercent / 100);
	$totalpayeeamount = $dirpercentamount;
}
else
{
	$totalpayeeamount = $totalpayeeamount;
}

if($totalpayeeamount < 0)
{
	$totalpayeeamount = '0.00';	
}
else
{
	$totalpayeeamount = $totalpayeeamount;	
}

$query66 = "select * from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted' and typecode = '20'";
$exec66 = mysql_query($query66) or die ("Error in Query66".mysql_error());
while ($res66 = mysql_fetch_array($exec66))
{
	$res66componentanum = $res66['componentanum'];
	//$res66componentamount = $res66['componentamount'];
	$res66monthly = $res66['monthly'];
	if($res66monthly == 'Yes')
	{
		$query67 = "select * from payroll_assignmonthwise where componentanum = '$res66componentanum' and employeecode = '$employeesearch' and assignmonth = '$assignmonth' and status <> 'deleted' and typecode = '20'";
		$exec67 = mysql_query($query67) or die ("Error in Query67".mysql_error());
		$res67 = mysql_fetch_array($exec67);
		$rows67 = mysql_num_rows($exec67);
		$res67componentname = $res67['componentname'];
		
		if($res67componentname != '')
		{	
			$deductionamount = $res67['amount'];
		}
		else if($res66componentanum == '5')
		{
			//$componentamount = $res31['componentamount'];
			$deductionamount = '0.00';
		}
		else
		{
			//$componentamount = $res31['componentamount'];
			$deductionamount = '0.00';
		}
	}	
	else
	{
		$deductionamount = $res66['componentamount'];
		//$componentamount = '0.00';
	}
	
	$totaldeductions = $totaldeductions + $deductionamount;
}

$totaldeductions = $totaldeductions + $nhifamount + $totalpayeeamount;


$query74 = "select * from nhif_monthwise where status <> 'deleted' and employeecode = '$employeesearch' and assignmonth = '$assignmonth'";
$exec74 = mysql_query($query74) or die ("Error in Query74".mysql_error());
$res74 = mysql_fetch_array($exec74);
$res74componentanum = $res74['componentanum'];
if($res74componentanum == '')
{
	$query88 = "select * from master_employee where employeecode = '$employeesearch'";
	$exec88 = mysql_query($query88) or die ("Error in Query88".mysql_error());
	$res88 = mysql_fetch_array($exec88);
	$res88employeename = $res88['employeename'];
	$res88excludenhif = $res88['excludenhif'];
	
	if($res88excludenhif == 'Yes')
	{
		$query75 = "insert into nhif_monthwise(componentanum, componentname, employeecode, employeename, assignmonth, componentamount, ipaddress, username, updatedatetime)
		values('6', 'NHIF', '$employeesearch', '$res88employeename', '$assignmonth', '0.00', '$ipaddress', '$username', '$updatedatetime')";
		$exec75 = mysql_query($query75) or die ("Error in Query75".mysql_error());
	}
	else
	{
		$query75 = "insert into nhif_monthwise(componentanum, componentname, employeecode, employeename, assignmonth, componentamount, ipaddress, username, updatedatetime)
		values('6', 'NHIF', '$employeesearch', '$res88employeename', '$assignmonth', '$nhifamount', '$ipaddress', '$username', '$updatedatetime')";
		$exec75 = mysql_query($query75) or die ("Error in Query75".mysql_error());
	}
}
else
{	
	$query88 = "select * from master_employee where employeecode = '$employeesearch'";
	$exec88 = mysql_query($query88) or die ("Error in Query88".mysql_error());
	$res88 = mysql_fetch_array($exec88);
	$res88employeename = $res88['employeename'];
	$res88excludenhif = $res88['excludenhif'];
	
	if($res88excludenhif == 'Yes')
	{
		$query75 = "update nhif_monthwise set componentamount = '0.00', updatedatetime = '$updatedatetime' where componentanum = '6' and employeecode = '$employeesearch' and assignmonth = '$assignmonth'";
		$exec75 = mysql_query($query75) or die ("Error in Query75".mysql_error());
	}
	else
	{
		$query75 = "update nhif_monthwise set componentamount = '$nhifamount', updatedatetime = '$updatedatetime' where componentanum = '6' and employeecode = '$employeesearch' and assignmonth = '$assignmonth'";
		$exec75 = mysql_query($query75) or die ("Error in Query75".mysql_error());
	}
	
}

$query76 = "select * from paye_monthwise where status <> 'deleted' and employeecode = '$employeesearch' and assignmonth = '$assignmonth'";
$exec76 = mysql_query($query76) or die ("Error in Query76".mysql_error());
$res76 = mysql_fetch_array($exec76);
$res76componentanum = $res76['componentanum'];
if($res76componentanum == '')
{	
	$query78 = "insert into paye_monthwise(componentanum, componentname, employeecode, employeename, assignmonth, componentamount, ipaddress, username, updatedatetime)
	values('8', 'PAYE', '$employeesearch', '$res88employeename', '$assignmonth', '$totalpayeeamount', '$ipaddress', '$username', '$updatedatetime')";
	$exec78 = mysql_query($query78) or die ("Error in Query78".mysql_error());
}
else
{	
	$query77 = "update paye_monthwise set componentamount = '$totalpayeeamount', updatedatetime = '$updatedatetime' where componentanum = '8' and employeecode = '$employeesearch' and assignmonth = '$assignmonth'";
	$exec77 = mysql_query($query77) or die ("Error in Query77".mysql_error());
	
}

/*else
{
	$query311 = "select * from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted' and typecode = '10'";
	$exec311 = mysql_query($query311) or die ("Error in Query311".mysql_error());
	while ($res311 = mysql_fetch_array($exec311))
	{
		$res311componentamount = $res311['componentamount'];
		//$res31componentamount = $res31['componentamount'];
		$grosspay = $grosspay + $res311componentamount;
	}
	$grosspay;	
}*/

?>