<?php
session_start();
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$currentdate = date("Y-m-d");
$colorloopcount = '';
$nettotalbenefit = '0.00';

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="payrollreport.xls"');
header('Cache-Control: max-age=80'); 

$month = date('M-Y');

$query81 = "select * from master_company where auto_number = '$companyanum'";
$exec81 = mysql_query($query81) or die ("Error in Query81".mysql_error());
$res81 = mysql_fetch_array($exec81);
$companycode = $res81['companycode'];
$companyname = $res81['companyname'];

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }
if (isset($_REQUEST["department"])) { $departmentname = $_REQUEST["department"]; } else { $departmentname = ""; }
if (isset($_REQUEST["type"])) { $type = $_REQUEST["type"]; } else { $type = ""; }
//$frmflag1 = $_REQUEST['frmflag1'];
if ($frmflag1 == 'frmflag1')
{
	$searchmonthyear = $searchmonth.'-'.$searchyear;
}
	
?>	
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #FFFFFF;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>	
<style>
.xlText {
    mso-number-format: "\@";
}
</style>
<table border="1" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#FFFFFF">
	<td colspan="30" align="left" class="bodytext3"><strong>PAYROLL REPORT</strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="30" align="left" class="bodytext3"><strong>EMPLOYER'S CODE : <?php echo $companycode; ?></strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="30" align="left" class="bodytext3"><strong>EMPLOYER'S NAME : <?php echo $companyname; ?></strong></td>
	</tr>
		<tr bgcolor="#FFFFFF">
	<td colspan="30" align="left" class="bodytext3"><strong>MONTH OF CONTRIBUTION : <?php echo $searchmonthyear; ?></strong></td>
	</tr>
	<tr>
	<td width="26" align="center" bgcolor="#FFFFFF" class="bodytext3"><strong>S.No</strong></td>
	<td width="101" align="center" bgcolor="#FFFFFF" class="bodytext3"><strong>EMPLOYEE CODE</strong></td>
	<td width="99" align="center" bgcolor="#FFFFFF" class="bodytext3"><strong>EMPLOYEE NAME</strong></td>
	<td width="99" align="center" bgcolor="#FFFFFF" class="bodytext3"><strong>DEPARTMENT NAME</strong></td>
	<?php
	$totalamount = '0.00';
	$totnhif10 = 0;
	$totloan = 0;
	$totgross = 0;
	$totdeduct = 0;
	$totnett = 0;	
	$datatotal['totgross'] = array();
	$datatotal['totloan'] = array();
	$datatotal['totdeduct'] = array();
	$datatotal['totnett'] = array();
	
	
	$query1 = "select auto_number,componentname from master_payrollcomponent where recordstatus <> 'deleted' and typecode = '10' order by typecode, auto_number";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	while($res1 = mysql_fetch_array($exec1))
	{
	$componentanum = $res1['auto_number'];
	$componentname = $res1['componentname'];
	$datatotal[$componentanum] = array();
	?>
	<td align="center" bgcolor="#FFFFFF" class="bodytext3" width="184"><strong><?php echo $componentname; ?></strong></td>
	<?php
	}
	?>
	<td align="center" bgcolor="#FFFFFF" class="bodytext3" width="84"><strong>GROSS PAY</strong></td>
	<?php
	$query1d = "select auto_number,componentname from master_payrollcomponent where recordstatus <> 'deleted' and typecode = '20' order by typecode, auto_number";
	$exec1d = mysql_query($query1d) or die ("Error in Query1d".mysql_error());
	while($res1d = mysql_fetch_array($exec1d))
	{
	$componentanum1 = $res1d['auto_number'];
	$componentname1 = $res1d['componentname'];
	$datatotal[$componentanum1] = array();
	?>
	<td align="center" bgcolor="#FFFFFF" class="bodytext3" width="184"><strong><?php echo $componentname1; ?></strong></td>
	<?php
	}
	?>
	<td align="center" bgcolor="#FFFFFF" class="bodytext3" width="84"><strong><?php echo 'LOAN DEDUCTION'; ?></strong></td>
	<td align="center" bgcolor="#FFFFFF" class="bodytext3" width="84"><strong>DEDUCTIONS</strong></td>
	<td align="center" bgcolor="#FFFFFF" class="bodytext3" width="84"><strong>NETT PAY</strong></td>
	</tr>
	<?php
	$totalamount = '0.00';
	
  if($type=='Detail')
  {  
    $query2 = "select a.employeename as employeename,a.employeecode as employeecode,b.departmentname as departmentname,b.payrollno as payrollno from payroll_assign a,master_employee b where a.employeename  like '%$searchemployee%'  and b.departmentname LIKE '%$departmentname%' and  a.employeecode = b.employeecode and b.payrollstatus <> 'Inactive' and a.status <> 'deleted' group by a.employeecode order by b.payrollno";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	while($res2 = mysql_fetch_array($exec2))
	{	
		$searchemployeename = $res2['employeename'];
		$searchemployeecode = $res2['employeecode'];
		$departmentname = $res2['departmentname'];
		$payrollno = $res2['payrollno'];
		
		$datatotal['gross'] = array();
		$datatotal['loan'] = array();
		$datatotal['deduct'] = array();
		$datatotal['nett'] = array();
	
		$query31 = "select employeecode,employeename from details_employeepayroll where employeecode = '$searchemployeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
		$exec31 = mysql_query($query31) or die ("Error in Query31".mysql_error());
		$res31 = mysql_fetch_array($exec31);
		$res31employeecode = $res31['employeecode'];
		
		if($res31employeecode != '')
		{	
		$res2employeecode = $res2['employeecode'];
		$res2employeename = $res2['employeename'];
		
	$colorloopcount = $colorloopcount + 1;
	$showcolor = ($colorloopcount & 1);  
	?>
	<tr>
	<td align="center" class="bodytext3"><?php echo $colorloopcount; ?></td>
	<td align="left" class="bodytext3"><?php echo $payrollno; ?></td>
	<td align="left" class="bodytext3"><?php echo $res2employeename; ?></td>
	<td align="left" class="bodytext3"><?php echo $departmentname; ?></td>
	<?php
	$query1 = "select auto_number from master_payrollcomponent where recordstatus <> 'deleted' and typecode = '10' order by typecode, auto_number";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	while($res1 = mysql_fetch_array($exec1))
	{
	$componentanum = $res1['auto_number'];

	$query3 = "select employeecode,employeename, `$componentanum` as componentamount from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	$res3 = mysql_fetch_array($exec3);
	$componentamount = $res3['componentamount'];
	
	array_push($datatotal[$componentanum], $componentamount);
	array_push($datatotal['gross'], $componentamount);
	array_push($datatotal['totgross'], $componentamount);
	?>
	<td align="right" class="bodytext3" width="184"><?php if($componentamount > 0) { echo number_format($componentamount,0,'.',','); } ?></td>	
	<?php
	}
	?>
	<td align="right" class="bodytext3" width="184"><?php if(true) { echo number_format(array_sum($datatotal['gross']),0,'.',','); } ?></td>
	<?php
	$query1dd = "select auto_number from master_payrollcomponent where recordstatus <> 'deleted' and typecode = '20' order by typecode, auto_number";
	$exec1dd = mysql_query($query1dd) or die ("Error in Query1dd".mysql_error());
	while($res1dd = mysql_fetch_array($exec1dd))
	{
	$componentanum = $res1dd['auto_number'];

	$query3 = "select employeecode,employeename, `$componentanum` as componentamount from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	$res3 = mysql_fetch_array($exec3);
	$componentamount = $res3['componentamount'];
	
	array_push($datatotal[$componentanum], $componentamount);
	array_push($datatotal['deduct'], $componentamount);
	array_push($datatotal['totdeduct'], $componentamount);
	?>
	<td align="right" class="bodytext3" width="184"><?php if($componentamount > 0) { echo number_format($componentamount,0,'.',','); } ?></td>	
	<?php
	}
	?>
	<?php
	/*$query63 = "select insurancename from insurance_relief where employeecode = '$res2employeecode' and status <> 'deleted' and insurancename <> ''";
	$exec63 = mysql_query($query63) or die ("Error in Query63".mysql_error());
	$res63 = mysql_fetch_array($exec63);
	$insurancename = $res63['insurancename'];
	$query31 = "select employeecode,employeename,componentanum,componentname,componentamount from details_employeepayroll where employeecode = '$res2employeecode' and componentname = '$insurancename' and paymonth = '$searchmonthyear' and status <> 'deleted'";
	$exec31 = mysql_query($query31) or die ("Error in Query31".mysql_error());
	$res31 = mysql_fetch_array($exec31);
	
	$employeecode = $res31['employeecode'];
	$employeename = $res31['employeename'];
	$componentanum = $res31['componentanum'];
	$componentname = $res31['componentname'];
	$componentamount3 = $res31['componentamount'];*/
	$loanamount = 0;
	$query80 = "select sum(installmentamount) as loanamount from loan_assign where status <> 'deleted' and paymonth = '$searchmonthyear' and employeecode = '$res2employeecode'";
	$exec80 = mysql_query($query80) or die ("Error in Query80".mysql_error());
	$res80 = mysql_fetch_array($exec80);
	$loanamount = $res80['loanamount'];	
	array_push($datatotal['loan'],$loanamount);
	array_push($datatotal['deduct'],$loanamount);
	array_push($datatotal['totdeduct'], $loanamount);
	array_push($datatotal['totloan'], $loanamount);
	?>
	<td align="right" class="bodytext3" width="184"><?php if($loanamount > 0) { echo number_format($loanamount,0,'.',','); } ?></td>	
	<td align="right" class="bodytext3" width="184"><?php if(true) { echo number_format(array_sum($datatotal['deduct']),0,'.',','); } ?></td>	
	<?php
	$totalbenefit = '0';
	$query912 = "select auto_number from master_payrollcomponent where notional = 'Yes' and recordstatus <> 'deleted'";
	$exec912 = mysql_query($query912) or die ("Error in Query912".mysql_error());
	while($res912 = mysql_fetch_array($exec912))
	{
	$benefitanum = $res912['auto_number'];
	$query911 = "select `$benefitanum` as componentamount from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
	$exec911 = mysql_query($query911) or die ("Error in Query911".mysql_error());
	$res911 = mysql_fetch_array($exec911);
	$res911benefits = $res911['componentamount'];
	$totalbenefit = $totalbenefit + $res911benefits;
	}
	?>
	<?php
	$res92nettpay = array_sum($datatotal['gross']) - array_sum($datatotal['deduct']);
	array_push($datatotal['nett'], $res92nettpay);
	array_push($datatotal['totnett'], $res92nettpay);
	?>
	<td align="right" class="bodytext3"><?php if($res92nettpay > 0) { echo number_format($res92nettpay-$totalbenefit,0,'.',','); } ?></td>	
	<?php
	}
	}
	?>
	</tr>
	<?php 
	?>
	<tr bgcolor="#FFFFFF">
	<td colspan="4" align="right" class="bodytext3"><strong>Total :</strong></td>
	<?php
	$totalamount = '0.00';
	$query1 = "select auto_number from master_payrollcomponent where recordstatus <> 'deleted' and typecode = '10' order by typecode, auto_number";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	while($res1 = mysql_fetch_array($exec1))
	{
	$i = $res1['auto_number'];
	?>
	<td align="right" class="bodytext3"><strong><?php if(array_sum($datatotal[$i]) > 0) { echo number_format(array_sum($datatotal[$i]),0,'.',','); } ?></strong></td>	
	<?php
	}
	?>
	<td align="right" class="bodytext3"><strong><?php if(array_sum($datatotal['totgross']) > 0) { echo number_format(array_sum($datatotal['totgross']),0,'.',','); } ?></strong></td>
	<?php
	$query1de = "select auto_number from master_payrollcomponent where recordstatus <> 'deleted' and typecode = '20' order by typecode, auto_number";
	$exec1de = mysql_query($query1de) or die ("Error in Query1de".mysql_error());
	while($res1de = mysql_fetch_array($exec1de))
	{
	$j = $res1de['auto_number'];
	?>
	<td align="right" class="bodytext3"><strong><?php if(array_sum($datatotal[$j]) > 0) { echo number_format(array_sum($datatotal[$j]),0,'.',','); } ?></strong></td>	
	<?php
	}
	?>
	<td align="right" class="bodytext3"><strong><?php if(array_sum($datatotal['totloan']) > 0) { echo number_format(array_sum($datatotal['totloan']),0,'.',','); } ?></strong></td>
	<td align="right" class="bodytext3"><strong><?php if(array_sum($datatotal['totdeduct']) > 0) { echo number_format(array_sum($datatotal['totdeduct']),0,'.',','); } ?></strong></td>
	<td align="right" class="bodytext3"><strong><?php if(array_sum($datatotal['totnett']) > 0) { echo number_format(array_sum($datatotal['totnett']),0,'.',','); } ?></strong></td>
	</tr>
	<?php 
	}
	else if($type=='Summary')
	{
	?>
	<tr bgcolor="#FFFFFF">
	<td colspan="4" align="right" class="bodytext3"><strong>Total :</strong></td>
	<?php
	$totalamount = '0.00';
	$query1 = "select auto_number from master_payrollcomponent where recordstatus <> 'deleted' and typecode = '10' order by typecode, auto_number";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	while($res1 = mysql_fetch_array($exec1))
	{
	$i = $res1['auto_number'];
	
	$query3 = "select SUM(`$i`) as componentamount from details_employeepayroll where employeename LIKE '%$searchemployee%' and paymonth = '$searchmonthyear' and status <> 'deleted'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	$res3 = mysql_fetch_array($exec3);
	$componentamount = $res3['componentamount'];
	$totgross = $totgross + $componentamount;
	?>
	<td align="right" class="bodytext3"><strong><?php if($componentamount > 0) { echo number_format($componentamount,0,'.',','); } ?></strong></td>	
	<?php
	}
	?>
	<td align="right" class="bodytext3"><strong><?php if($totgross > 0) { echo number_format($totgross,0,'.',','); } ?></strong></td>
	<?php
	$query1de = "select auto_number from master_payrollcomponent where recordstatus <> 'deleted' and typecode = '20' order by typecode, auto_number";
	$exec1de = mysql_query($query1de) or die ("Error in Query1de".mysql_error());
	while($res1de = mysql_fetch_array($exec1de))
	{
	$j = $res1de['auto_number'];
	$query3 = "select SUM(`$j`) as componentamount from details_employeepayroll where employeename LIKE '%$searchemployee%' and paymonth = '$searchmonthyear' and status <> 'deleted'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	$res3 = mysql_fetch_array($exec3);
	$componentamount = $res3['componentamount'];
	$totdeduct = $totdeduct + $componentamount;
	?>
	<td align="right" class="bodytext3"><strong><?php if($componentamount > 0) { echo number_format($componentamount,0,'.',','); } ?></strong></td>	
	<?php
	}
	$loanamount = 0;
	$query80 = "select sum(installmentamount) as loanamount from loan_assign where status <> 'deleted' and paymonth = '$searchmonthyear' and employeename LIKE '%$searchemployee%'";
	$exec80 = mysql_query($query80) or die ("Error in Query80".mysql_error());
	$res80 = mysql_fetch_array($exec80);
	$loanamount = $res80['loanamount'];	
	
	$totnett = $totgross - $totdeduct - $loanamount;
	?>
	<td align="right" class="bodytext3"><strong><?php if($loanamount > 0) { echo number_format($loanamount,0,'.',','); } ?></strong></td>
	<td align="right" class="bodytext3"><strong><?php if($totdeduct > 0) { echo number_format($totdeduct,0,'.',','); } ?></strong></td>
	<td align="right" class="bodytext3"><strong><?php if($totnett > 0) { echo number_format($totnett,0,'.',','); } ?></strong></td>
	</tr>
	<?php
	}
	?>	
	</tbody>
	</table> 