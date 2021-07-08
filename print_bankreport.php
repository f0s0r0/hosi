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

$month = date('M-Y');

ob_start();

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }
if (isset($_REQUEST["companyanum"])) { $companyanum = $_REQUEST["companyanum"]; } else { $companyanum = '1'; }
if (isset($_REQUEST["searchbank"])) { $searchbank = $_REQUEST["searchbank"]; } else { $searchbank = ""; }

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
<?php include("a4pdfpayrollheader1.php"); ?>	

	<?php
	if($frmflag1 == 'frmflag1')
	{
		$searchmonthyear = $searchmonth.'-'.$searchyear; 
	?>	
	<table width="100%" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#FFF">
	<td colspan="6" align="left" class="bodytext3"><strong>BANK REPORT</strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="6" align="left" class="bodytext3"><strong>EMPLOYER'S CODE : <?php echo $companycode; ?></strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="6" align="left" class="bodytext3"><strong>EMPLOYER'S NAME : <?php echo $companyname; ?></strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="6" align="left" class="bodytext3"><strong>MONTH OF CONTRIBUTION : <?php echo $searchmonthyear; ?></strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="6" align="left" class="bodytext3"><strong>&nbsp;</strong></td>
	</tr>
	<tr>
	<td width="30" align="center" bgcolor="#FFFFFF" class="bodytext3"><strong>S.No</strong></td>
	<td width="25" align="left" bgcolor="#FFFFFF" class="bodytext3"><strong>PAYROLL NO</strong></td>
	<td width="180" align="left" bgcolor="#FFFFFF" class="bodytext3"><strong>EMPLOYEE NAME</strong></td>
	<td width="80" align="left" bgcolor="#FFFFFF" class="bodytext3"><strong>BRANCH NAME</strong></td>
	<td width="80" align="left" bgcolor="#FFFFFF" class="bodytext3"><strong>ACCOUNT NO</strong></td>
	<td colspan="2" width="50" align="right" bgcolor="#FFFFFF" class="bodytext3"><strong>AMOUNT</strong></td>
	</tr>
	<?php
	$totalamount = '0.00';
	$query9 = "select * from master_employeeinfo where bankname like '%$searchbank%' and bankname <> '' group by bankname order by bankname";
	$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
	while($res9 = mysql_fetch_array($exec9))
	{
	$res9bankname = $res9['bankname'];
	?>
	<tr>
	<td colspan="7" align = "left" class="bodytext3" bgcolor="#FFFFFF"><strong><?php echo $res9bankname; ?></strong></td>
	</tr>
	<?php
	$query2 = "select a.employeename as employeename,a.employeecode as employeecode,b.departmentname as departmentname,b.payrollno as payrollno from payroll_assign a,master_employee b where a.employeename  like '%$searchemployee%' and a.employeecode = b.employeecode and b.payrollstatus = 'Active' and a.status <> 'deleted' group by a.employeecode order by b.payrollno";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	while($res2 = mysql_fetch_array($exec2))
	{
	$res2employeecode = $res2['employeecode'];
	$res2employeename = $res2['employeename'];
	$payrollno = $res2['payrollno'];
	
	$query6 = "select * from master_employeeinfo where employeecode = '$res2employeecode' and bankname = '$res9bankname'";
	$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
	$res6 = mysql_fetch_array($exec6);
	$bankbranch = $res6['bankbranch'];
	$accountnumber = $res6['accountnumber'];
	
	if($accountnumber != '')
	{ 

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
	<td align="left" class="bodytext3"><?php echo $bankbranch; ?></td>
	<td align="left" class="bodytext3"><?php echo $accountnumber; ?></td>
	<?php
	$componentamount = 0;
	$componentamount4 = 0;
	$query7 = "select auto_number, typecode from master_payrollcomponent where recordstatus <> 'deleted'";
	$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
	while($res7 = mysql_fetch_array($exec7))
	{
		$auto_number = $res7['auto_number'];
		$typecode = $res7['typecode'];
	
		$query3 = "select SUM(`$auto_number`) as componentamount from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
		$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
		$res3 = mysql_fetch_array($exec3);
		$componentamount1 = $res3['componentamount'];
		
		if($typecode == '10')
		{
			$componentamount = $componentamount + $componentamount1;
		}
		else
		{
			$componentamount4 = $componentamount4 + $componentamount1;
		}
		
	}
	$nettpay = $componentamount - $componentamount4;
	$totalamount = $totalamount + $nettpay;
	?>
	<td colspan="2" align="right" class="bodytext3" width="70"><?php echo number_format($nettpay,2,'.',','); ?></td>
	<?php
	}
	}
	}
	?>
	</tr>
	<tr>
	<td colspan="5" bgcolor="#FFFFFF" align="right" class="bodytext3"><strong>Total :</strong></td>
	<td colspan="2" bgcolor="#FFFFFF" align="right" class="bodytext3"><strong><?php echo number_format($totalamount,2,'.',','); ?></strong></td>
	</tr>
	</tbody>
	</table> 
	<?php
	}
	?>
	<?php	
require_once("dompdf/dompdf_config.inc.php");
$html =ob_get_clean();
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper("A4");
$dompdf->render();
$canvas = $dompdf->get_canvas();
//$canvas->line(10,800,800,800,array(0,0,0),1);
$font = Font_Metrics::get_font("times-roman", "normal");
$canvas->page_text(272, 814, "Page {PAGE_NUM}/{PAGE_COUNT}", $font, 10, array(0,0,0));
$dompdf->stream("BankReport.pdf", array("Attachment" => 0)); 
?>