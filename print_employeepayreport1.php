<?php
session_start();
//error_reporting(0);
$pagename = '';
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION['username'])) header ("location:index.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$sessionusername = $_SESSION['username'];
$username = $_SESSION['username'];
$errmsg = '';
$bgcolorcode = "";
$colorloopcount = "";
$totalbenefit = "0.00";
$nettotalbenefit = "0.00";

$month = date('M-Y');

ob_start();

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }


?>
<style>
body {
    font-family: 'Arial'; font-size:11px;	 
}
</style>

	<table width="510" border="0" align="left" cellpadding="4" cellspacing="0"  id="AutoNumber3" style="border-collapse: collapse">
	<tr bgcolor="#FFFFFF">
	<td colspan="20" align="left" class="bodytext3"><strong>Payroll Employee Report - <?php echo $searchyear; ?></strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="20" align="left" class="bodytext3"><strong>Name : <?php echo $searchemployee; ?></strong></td>
	</tr>
	<tr>
	<td width="40" align="center" bgcolor="#FFFFFF" class="bodytext3"><strong>S.No</strong></td>
	<td width="70" align="center" bgcolor="#FFFFFF" class="bodytext3"><strong>MONTH</strong></td>
	<?php
	$totalamount = '0.00';
	$query1 = "select * from master_payrollcomponent where recordstatus <> 'deleted' order by typecode, auto_number";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	while($res1 = mysql_fetch_array($exec1))
	{
	$componentanum = $res1['auto_number'];
	$componentname = $res1['componentname'];
	?>
	<td align="center" bgcolor="#FFFFFF" class="bodytext3" width="90"><strong><?php echo $componentname; ?></strong></td>
	<?php
	}
	?>
	<td align="center" bgcolor="#FFFFFF" class="bodytext3" width="84"><strong>GROSS PAY</strong></td>
	<td align="center" bgcolor="#FFFFFF" class="bodytext3" width="84"><strong>DEDUCTIONS</strong></td>
	<td align="center" bgcolor="#FFFFFF" class="bodytext3" width="26"><strong>NOTIONAL BENEFIT</strong></td>
	<td align="center" bgcolor="#FFFFFF" class="bodytext3" width="84"><strong>NETT PAY</strong></td>
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
		$colorcode = 'bgcolor="#FFFFFF"';
	}
	else
	{
		$colorcode = 'bgcolor="#FFFFFF"';
	}
	  
	?>
	<tr>
	<td align="center" class="bodytext3"><?php echo $colorloopcount; ?></td>
	<td align="left" class="bodytext3"><?php echo date('F',strtotime($arraymonth[$i])); ?></td>	
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
	<td align="right" class="bodytext3" width="10"><?php echo number_format($componentamount,2,'.',',');  ?></td>	
	<?php
	}
	$res9grosspay = $gross;
	?>
	<td align="right" class="bodytext3"><?php echo number_format($res9grosspay,2,'.',',');  ?></td>	
	<?php
	$res91deduction = $deduct;
	?>
	<td align="right" class="bodytext3"><?php echo number_format($res91deduction,2,'.',',');  ?></td>	
	<?php
	$totalbenefit = '0';
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
	<td align="right" class="bodytext3"><?php  echo number_format($totalbenefit,0,'.',','); ?></td>	
	<?php
	$res92nettpay = $res9grosspay - $res91deduction;
	?>
	<td align="right" class="bodytext3"><?php echo number_format($res92nettpay-$totalbenefit,2,'.',','); ?></td>
	</tr>	
	<?php
	}
	}
	?>
	
	<tr bgcolor="#FFF">
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
	</table> 
	
<?php	
require_once('html2pdf/html2pdf.class.php');
$content = ob_get_clean();
try
    {	
        $html2pdf = new HTML2PDF('L', array(120, 450), 'en', true, 'UTF-8', array(0, 0, 0,0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->setDefaultFont('Helvetica');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('EmployeePayReport.pdf');
		
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>
