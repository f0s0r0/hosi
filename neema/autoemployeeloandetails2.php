<?php
session_start();
include ("db/db_connect.php");
$username = $_SESSION['username'];
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');

if (isset($_REQUEST["employeesearch"])) { $employeesearch = $_REQUEST["employeesearch"]; } else { $employeesearch = ""; }
if (isset($_REQUEST["assignmonth"])) { $assignmonth = $_REQUEST["assignmonth"]; } else { $assignmonth = ""; }

$searchresult = "";
$totalloanamount = "";
$loanbuild = "";
$totalmonthpaid = "";
$totalafterinstallment = "";

//include("autoemployeepayrollcalculation1.php");


	
$loanbuild = "";
$query80 = "select * from loan_assign where status <> 'deleted' and employeecode = '$employeesearch'";
$exec80 = mysql_query($query80) or die ("Error in Query80".mysql_error());
while($res80 = mysql_fetch_array($exec80))
{
	$res80employeecode = $res80['employeecode'];
	$res80employeename = $res80['employeename'];
	$res80loanname = $res80['loanname'];
	$loaninterest = $res80['interest'];
	$fringebenefit = $res80['fringebenefit'];
	$nonofinstallments = $res80['installments'];
	$installmentamount = $res80['installmentamount'];
	$interestapplicable = $res80['interestapplicable'];
	$res80loanname = $res80['loanname'];
	$res80loanamount = $res80['amount'];
	
	$totalloanamount = "";
	$query81 = "select * from loan_assign where status <> 'deleted' and employeecode = '$res80employeecode' and loanname = '$res80loanname'";
	$exec81 = mysql_query($query81) or die ("Error in Query81".mysql_error());
	while($res81 = mysql_fetch_array($exec81))
	{	
		$loanname = $res81['loanname'];
		$loanamount = $res81['amount'];
		$totalloanamount = $totalloanamount + $loanamount;
	}
	//echo $totalloanamount;
	$totalmonthpaid = "";
	$installmentspaid = "";
	$query82 = "select * from details_loanpay where status <> 'deleted' and employeecode = '$res80employeecode' and loanname = '$res80loanname' and paymonth <> '$assignmonth'";
	$exec82 = mysql_query($query82) or die ("Error in Query82".mysql_error());
	while($res82 = mysql_fetch_array($exec82))
	{	
		$monthamount = $res82['monthamount'];
		if($monthamount != 0.00)
		{
			$installmentspaid = $installmentspaid + 1;
		}	
		$totalmonthpaid = $totalmonthpaid + $monthamount;
	}	
	//echo $totalmonthpaid;
	$totalafterinstallment = $totalloanamount - $totalmonthpaid;
	
	if($loaninterest < $fringebenefit)
	{
		$fringepercent = $fringebenefit - $loaninterest;
		$fringeamount = $totalafterinstallment * ($fringepercent / 100);
		$fringeamount = $fringeamount / 12;
	}
	else
	{
		$fringeamount = "0.00";
	}
	$installmentspaid;
	$remaininstallments = $nonofinstallments - $installmentspaid;
	$interesttotal = $totalafterinstallment * ($loaninterest / 100);
	$principleinterest = $totalafterinstallment + $interesttotal;
	$amountthismonth = $totalafterinstallment / $remaininstallments;
	$interestthismonth = $interesttotal / 12;
	$thismonthpay = $amountthismonth + $interestthismonth;
	
	$query11 = "select * from loan_assign where employeecode = '$employeesearch' and loanname = '$res80loanname' and amount = '$res80loanamount'";
	$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
	$res11 = mysql_fetch_array($exec11);
	$holdstatus = $res11['holdstatus'];
	if($holdstatus == 'Yes')
	{
		$thismonthpay = $interestthismonth;	
		$amountthismonth = '0.00';
	}
	else
	{
		$thismonthpay = $thismonthpay;
		$amountthismonth = $amountthismonth;
	}
	
	$query6 = "select * from details_loanpay where employeecode = '$employeesearch' and paymonth = '$assignmonth' and status <> 'deleted'";
	$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
	$res6 = mysql_fetch_array($exec6);
	$res6employeecode = $res6['employeecode'];
	if($res6employeecode == '')
	{				
		$query3 = "insert into details_loanpay(employeecode, employeename, loanname, installments, interestapplicable, interest, fringebenefit, amount, amountremain, monthamount, monthinterest, installmentamount, fringerate, paymonth, username, ipaddress, updatedatetime)
		values('$employeesearch', '$res80employeename', '$loanname', '$nonofinstallments', '$interestapplicable', '$loaninterest', '$fringebenefit', '$totalloanamount', '$totalafterinstallment', '$amountthismonth', '$interestthismonth', '$thismonthpay', '$fringeamount', '$assignmonth', '$username', '$ipaddress', '$updatedatetime')";
		//$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	}
	else
	{
		$query4 = "update details_loanpay set installmentamount = '$thismonthpay', monthamount = '$amountthismonth', monthinterest = '$interestthismonth', fringerate = '$fringeamount', updatedatetime = '$updatedatetime' where employeecode = '$employeesearch' and paymonth = '$assignmonth' and status <> 'deleted' and loanname = '$loanname'";
		//$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	}
}	
	
if ($loanbuild != '')
{
	//echo $loanbuild;
}

?>