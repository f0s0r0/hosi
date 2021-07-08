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

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Nhifreport.xls"');
header('Cache-Control: max-age=80');

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }
if (isset($_REQUEST["companyanum"])) { $companyanum = $_REQUEST["companyanum"]; } else { $companyanum = date('Y'); }

$query81 = "select * from master_company where auto_number = '$companyanum'";
$exec81 = mysql_query($query81) or die ("Error in Query81".mysql_error());
$res81 = mysql_fetch_array($exec81);
$companycode = $res81['companycode'];
$companyname = $res81['companyname'];


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
		$searchmonthyear = $searchmonth.'-'.$searchyear; 
	?>	
	<table width="470" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#FFFFFF">
	<td colspan="6" align="left" class="bodytext3"><strong>MONTHLY PAYROLL RETURN TO NHIF</strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="6" align="left" class="bodytext3"><strong>EMPLOYER'S CODE : <?php echo $companycode; ?></strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="6" align="left" class="bodytext3"><strong>EMPLOYER'S NAME : <?php echo $companyname; ?></strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="6" align="left" class="bodytext3"><strong>MONTH OF CONTRIBUTION : <?php echo $searchyear.'-'.date('m',strtotime($searchmonth)); ?></strong></td>
	</tr>
	<tr>
	<td width="50" align="center" bgcolor="#FFFFFF" class="bodytext3"><strong>S.No</strong></td>
	<td width="80" align="left" bgcolor="#FFFFFF" class="bodytext3"><strong>PAYROLL NO</strong></td>
	<td width="120" align="left" bgcolor="#FFFFFF" class="bodytext3"><strong>EMPLOYEE'S NAME</strong></td>
	<td width="85" align="left" bgcolor="#FFFFFF" class="bodytext3"><strong>ID NO</strong></td>
	<td width="85" align="left" bgcolor="#FFFFFF" class="bodytext3"><strong>NSSF NO</strong></td>
	<td width="85" align="right" bgcolor="#FFFFFF" class="bodytext3"><strong>AMOUNT</strong></td>
	</tr>
	<?php
	$totalamount = '0.00';
	$query2 = "select a.employeename as employeename,a.employeecode as employeecode,b.departmentname as departmentname,b.payrollno as payrollno from payroll_assign a,master_employee b where a.employeename  like '%$searchemployee%' and a.employeecode = b.employeecode and b.payrollstatus = 'Active' and a.status <> 'deleted' group by a.employeecode order by b.payrollno";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	while($res2 = mysql_fetch_array($exec2))
	{
	$res2employeecode = $res2['employeecode'];
	$res2employeename = $res2['employeename'];
	$payrollno = $res2['payrollno'];
	
	$query6 = "select * from master_employeeinfo where employeecode = '$res2employeecode'";
	$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
	$res6 = mysql_fetch_array($exec6);
	$passportnumber = $res6['passportnumber'];
	$nhif = $res6['nhif'];
	
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
	<tr <?php echo $colorcode; ?>>
	<td align="center" class="bodytext3"><?php echo $colorloopcount; ?></td>
	<td align="left" class="bodytext3"><?php echo $payrollno; ?></td>
	<td align="left" class="bodytext3"><?php echo $res2employeename; ?></td>
	<td align="left" class="bodytext3"><?php echo $passportnumber; ?></td>
	<td align="left" class="bodytext3"><?php echo $nhif; ?></td>
	<?php
	$query1 = "select * from master_payrollcomponent where recordstatus <> 'deleted' and auto_number = '6' order by typecode, auto_number";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	while($res1 = mysql_fetch_array($exec1))
	{
	$componentanum = $res1['auto_number'];

	$query3 = "select `$componentanum` as componentamount, employeecode, employeename from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	$res3 = mysql_fetch_array($exec3);
	
	$employeecode = $res3['employeecode'];
	$employeename = $res3['employeename'];
	$componentname = $res1['componentname'];
	$componentamount = $res3['componentamount'];
	
	$totalamount = $totalamount + $componentamount;

	?>
	<td align="right" class="bodytext3"><?php echo number_format($componentamount,2,'.',','); ?></td>
	<?php
	}
	}
	?>
	</tr>
	<tr>
	<td colspan="5" bgcolor="#FFFFFF" align="right" class="bodytext3"><strong>Total :</strong></td>
	<td bgcolor="#FFFFFF" align="right" class="bodytext3"><strong><?php echo number_format($totalamount,2,'.',','); ?></strong></td>
	</tr>
	</tbody>
	</table>
	<?php
	}
	?>
