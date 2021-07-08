<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$currentdate = date("Y-m-d");
$colorloopcount = '';
$totalbenefit = "0.00";
$nettotalbenefit = "0.00";

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Employeepayreport.xls"');
header('Cache-Control: max-age=80');

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }


?>
<style>
body {
    font-family: 'Arial'; font-size:11px;	 
}
#footer { position: fixed; left: 0px; bottom: -90px; right: 0px; height: 150px; }
#footer .page:after { content: counter(page, upper-roman); }

.page { page-break-after:always; }
</style>
<?php //include("a4pdfheader1.php"); ?>	


	<?php
	if($frmflag1 == 'frmflag1')
	{
		
	?>
	<table width="510" border="1" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#fff">
	<td colspan="35" align="left" class="bodytext3"><strong>Payroll Employee Report</strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="35" align="left" class="bodytext3"><strong>EMPLOYER'S NAME : <?php eval(base64_decode('IGVjaG8gJGNvbXBhbnluYW1lOyA=')); ?></strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="35" align="left" class="bodytext3"><strong>EMPLOYEE'S NAME : <?php eval(base64_decode('IGVjaG8gJHNlYXJjaGVtcGxveWVlOyA=')); ?></strong></td>
	</tr>
	<tr>
	<td width="26" align="center" bgcolor="#fff" class="bodytext3"><strong>S.No</strong></td>
	<!--<td width="101" align="center" bgcolor="#fff" class="bodytext3"><strong>EMPLOYEE CODE</strong></td>
	<td width="99" align="center" bgcolor="#fff" class="bodytext3"><strong>EMPLOYEE NAME</strong></td>-->
	<td width="35" align="center" bgcolor="#fff" class="bodytext3"><strong>MONTH</strong></td>
	<?php 
	$totalamount = '0.00';
	$query1 = "select * from master_payrollcomponent where recordstatus <> 'deleted' order by typecode, auto_number";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	while($res1 = mysql_fetch_array($exec1))
	{
	$componentanum = $res1['auto_number'];
	$componentname = $res1['componentname'];
	 ?>
	<td align="center" bgcolor="#fff" class="bodytext3" width="26"><strong><?php eval(base64_decode('IGVjaG8gJGNvbXBvbmVudG5hbWU7IA==')); ?></strong></td>
	<?php 
	}
	 ?>
	 <td align="center" bgcolor="#fff" class="bodytext3" width="26"><strong>GROSS PAY</strong></td>
	 <td align="center" bgcolor="#fff" class="bodytext3" width="26"><strong>DEDUCTION</strong></td>
	 <td align="center" bgcolor="#fff" class="bodytext3" width="26"><strong>NOTIONAL BENEFIT</strong></td>
	 <td align="center" bgcolor="#fff" class="bodytext3" width="26"><strong>NET PAY</strong></td>
	</tr>
	<?php 
	$totalamount = '0.00';
	
	$arraymonth = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
	$monthcount = count($arraymonth);
	for($i=0;$i<$monthcount;$i++)
	{
		$searchmonthyear = $arraymonth[$i].'-'.$searchyear;
	
	$query2 = "select * from payroll_assign where status <> 'deleted' and employeename like '%$searchemployee%' group by employeename";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	while($res2 = mysql_fetch_array($exec2))
	{
	$res2employeecode = $res2['employeecode'];
	$res2employeename = $res2['employeename'];
	
	$colorloopcount = $colorloopcount + 1;
	$showcolor = ($colorloopcount & 1); 
	if ($showcolor == 0)
	{
		$colorcode = 'bgcolor="#CBDBFA"';
	}
	else
	{
		$colorcode = 'bgcolor="#D3EEB7"';
	}
	  
	 ?>
	<tr>
	<td align="center" class="bodytext3"><?php eval(base64_decode('IGVjaG8gJGNvbG9ybG9vcGNvdW50OyA=')); ?></td>
	<!--<td align="left" class="bodytext3"><?php eval(base64_decode('IC8vZWNobyAkcmVzMmVtcGxveWVlY29kZTsg')); ?></td>
	<td align="left" class="bodytext3"><?php eval(base64_decode('IC8vZWNobyAkcmVzMmVtcGxveWVlbmFtZTsg')); ?></td>-->
	<td align="left" class="bodytext3"><?php eval(base64_decode('IGVjaG8gZGF0ZSgnRicsc3RydG90aW1lKCRhcnJheW1vbnRoWyRpXSkpOyA=')); ?></td>	
	<?php 
	$gross = 0;
	$deduct = 0;
	$query1 = "select * from master_payrollcomponent where recordstatus <> 'deleted' order by typecode, auto_number";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	while($res1 = mysql_fetch_array($exec1))
	{
	$componentanum = $res1['auto_number'];
	$typecode = $res1['typecode'];

	$query3 = "select employeecode, employeename, `$componentanum` as componentamount from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	$res3 = mysql_fetch_array($exec3);
	
	$employeecode = $res3['employeecode'];
	$employeename = $res3['employeename'];
	$componentname = $res1['componentname'];
	$componentamount = $res3['componentamount'];
	if($typecode == '10')
	{
		$gross = $gross + $componentamount;
	}
	else
	{
		$deduct = $deduct + $componentamount;
	}
	 ?>
	<td align="right" class="bodytext3" width="26"><?php  if($componentamount > 0) { echo number_format($componentamount,0,'.',','); }  ?></td>	
	<?php
	}
	$res9grosspay = $gross;
	?>
	<td align="right" class="bodytext3"><?php if($res9grosspay > 0) { echo number_format($res9grosspay,0,'.',','); } ?></td>	
	<?php
	$res91deduction = $deduct;
	?>
	<td align="right" class="bodytext3"><?php if($res91deduction > 0) { echo number_format($res91deduction,0,'.',','); } ?></td>	
	<?php
	$totalbenefit = '';
	$query912 = "select * from master_payrollcomponent where notional = 'Yes' and recordstatus <> 'deleted'";
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
	<td align="right" class="bodytext3"><?php if($totalbenefit > 0) { echo number_format($totalbenefit,0,'.',','); } ?></td>	
	<?php
	$res92nettpay = $res9grosspay - $res91deduction;
	?>
	<td align="right" class="bodytext3"><?php if($res92nettpay > 0) { echo number_format($res92nettpay-$totalbenefit,0,'.',','); } ?></td>
	<?php 
	}
	 ?>
	</tr>
	<?php 
	}
	 ?>
	
	<tr bgcolor="#fff">
	<td colspan="2" align="right" class="bodytext3"><strong>Total :</strong></td>
	<?php 
	$totalamount = '0.00';
	$totalgross = 0;
	$totaldeduct = 0;
	//$arraymonth = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
	//$monthcount = count($arraymonth);
	//for($i=0;$i<$monthcount;$i++)
	//{
		//$searchmonthyear = $arraymonth[$i].'-'.$searchyear;
	
	$query2 = "select * from payroll_assign where status <> 'deleted' and employeename like '%$searchemployee%' group by employeename";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	while($res2 = mysql_fetch_array($exec2))
	{
	$res2employeecode = $res2['employeecode'];
	$res2employeename = $res2['employeename'];
	
	 ?>
	<?php 
	$query1 = "select * from master_payrollcomponent where recordstatus <> 'deleted' order by typecode, auto_number";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	while($res1 = mysql_fetch_array($exec1))
	{
	$componentanum = $res1['auto_number'];
    $typecode = $res1['typecode'];
	
	$query3 = "select sum(`$componentanum`) as totalcomponentamount from details_employeepayroll where employeecode = '$res2employeecode' and status <> 'deleted'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	$res3 = mysql_fetch_array($exec3);
	
	$totalcomponentamount = $res3['totalcomponentamount'];
	if($typecode == '10')
	{
		$totalgross = $totalgross + $totalcomponentamount;
	}
	else
	{
		$totaldeduct = $totaldeduct + $totalcomponentamount;
	}
	 ?>
	<td align="right" class="bodytext3" width="26"><strong><?php  if($totalcomponentamount > 0) { echo number_format($totalcomponentamount,0,'.',','); }  ?></strong></td>	
	<?php 
	}
	//}
	 ?>
	 <?php
	$res60grosspay = $totalgross;
	?>
	<td align="right" class="bodytext3" width="26"><strong><?php if($res60grosspay > 0) { echo number_format($res60grosspay,0,'.',','); } ?></strong></td>	
	<?php
	$res61totaldeduct = $totaldeduct;
	?>
	<td align="right" class="bodytext3" width="26"><strong><?php if($res61totaldeduct > 0) { echo number_format($res61totaldeduct,0,'.',','); } ?></strong></td>	
	<?php
	$query912 = "select * from master_payrollcomponent where notional = 'Yes' and recordstatus <> 'deleted'";
	$exec912 = mysql_query($query912) or die ("Error in Query912".mysql_error());
	while($res912 = mysql_fetch_array($exec912))
	{
	$benefitanum = $res912['auto_number'];
	$query611 = "select sum(`$benefitanum`) as totalbenefits from details_employeepayroll where employeecode = '$res2employeecode' and status <> 'deleted'";
	$exec611 = mysql_query($query611) or die ("Error in Query611".mysql_error());
	$res611 = mysql_fetch_array($exec611);
	$res611benefits = $res611['totalbenefits'];
	$nettotalbenefit = $nettotalbenefit + $res611benefits;
	}
	?>
	<td align="right" class="bodytext3"><strong><?php if($nettotalbenefit > 0) { echo number_format($nettotalbenefit,0,'.',','); } ?></strong></td>	
	<?php
	$res62totalnett = $res60grosspay - $res61totaldeduct;
	?>
	<td align="right" class="bodytext3" width="26"><strong><?php if($res62totalnett > 0) { echo number_format($res62totalnett-$nettotalbenefit,0,'.',','); } ?></strong></td>
	</tr>
	<?php 
	}
	 ?>
	</tbody>
	</table> 
	<?php
	}
	?>
