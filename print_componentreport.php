<?php
session_start();
$pagename = '';
include ("db/db_connect.php");

ob_start();

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$sessionusername = $_SESSION['username'];
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$errmsg = '';
$bgcolorcode = "";
$colorloopcount = "";  

$month = date('M-Y');

$query81 = "select * from master_company where auto_number = '$companyanum'";
$exec81 = mysql_query($query81) or die ("Error in Query81".mysql_error());
$res81 = mysql_fetch_array($exec81);
$companycode = $res81['companycode']; 
$companyname = $res81['companyname'];

if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }
if (isset($_REQUEST["searchcomponent"])) { $searchcomponent = $_REQUEST["searchcomponent"]; } else { $searchcomponent = ""; }
$searchmonthyear = $searchmonth.'-'.$searchyear; 

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == 'success')
{
		$errmsg = "";
}
else if ($st == 'failed')
{
		$errmsg = "";
}
	$query13 = "select * from master_payrollcomponent where auto_number = '$searchcomponent'";
	$exec13 = mysql_query($query13) or die ("Error in Query13".mysql_error());
	$res13 = mysql_fetch_array($exec13);
	$componentanum = $res13['auto_number'];
	$componentname = $res13['componentname'];
?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #FFF;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; 
}
-->
</style>

<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c;
}
-->
</style>
</head>
<body>
	<table width="100%" border="1" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#FFFFFF">
	<td colspan="5" align="center" class="bodytext3"><strong><?php echo $componentname; ?></strong></td>
	</tr>
	<tr bgcolor="#FFF">
	<td colspan="5" align="left" class="bodytext3"><strong><?php echo $componentname; ?> Report</strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="5" align="left" class="bodytext3"><strong>EMPLOYER'S CODE : <?php echo $companycode; ?></strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="5" align="left" class="bodytext3"><strong>EMPLOYER'S NAME : <?php echo $companyname; ?></strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="5" align="left" class="bodytext3"><strong>MONTH OF CONTRIBUTION : <?php echo $searchmonthyear; ?></strong></td>
	</tr>
	<tr>
	<td width="20" align="center" bgcolor="#FFF" class="bodytext3"><strong>S.No</strong></td>
	<td width="200" align="left" bgcolor="#FFF" class="bodytext3"><strong>EMPLOYEE NAME</strong></td>
	<td width="80" align="left" bgcolor="#FFF" class="bodytext3"><strong>ID NO</strong></td>
	<td width="80" align="left" bgcolor="#FFF" class="bodytext3"><strong>PIN NO</strong></td>
	<td align="right" bgcolor="#FFF" class="bodytext3"><strong>AMOUNT</strong></td>
	</tr>
	<?php
	$totalamount = '0.00';
	$query2 = "select * from payroll_assign where employeename like '%$searchemployee%' and status <> 'deleted' group by employeename";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	while($res2 = mysql_fetch_array($exec2))
	{
	$res2employeecode = $res2['employeecode'];
	$res2employeename = $res2['employeename'];
	
	$query6 = "select * from master_employeeinfo where employeecode = '$res2employeecode'";
	$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
	$res6 = mysql_fetch_array($exec6);
	$passportnumber = $res6['passportnumber'];
	$pinno = $res6['pinno'];
	  
	$query3 = "select `$searchcomponent` as componentamount, employeecode, employeename from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	$res3 = mysql_fetch_array($exec3);
	
	$employeecode = $res3['employeecode'];
	$employeename = $res3['employeename'];
	$componentanum = $searchcomponent;
	$componentamount = $res3['componentamount'];
	
	$totalamount = $totalamount + $componentamount;
	if($componentamount > 0)
	{
	$colorloopcount = $colorloopcount + 1;
	$showcolor = ($colorloopcount & 1); 
	?>
	<tr>
	<td align="center" class="bodytext3"><?php echo $colorloopcount; ?></td>
	<td align="left" class="bodytext3"><?php echo $res2employeename; ?></td>
	<td align="left" class="bodytext3"><?php echo $passportnumber; ?></td>
	<td align="left" class="bodytext3"><?php echo $pinno; ?></td>
	<td align="right" class="bodytext3" width="111"><?php echo number_format($componentamount,0,'.',','); ?></td>
	</tr>	
	<?php
	}
	}
	?>
	<tr>
	<td colspan="4" bgcolor="#FFF" align="right" class="bodytext3"><strong>Total :</strong></td>
	<td bgcolor="#FFF" align="right" class="bodytext3"><strong><?php echo number_format($totalamount,0,'.',','); ?></strong></td>
	</tr>
	</tbody>
	</table> 
</body>
</html>
<?php	
require_once("dompdf/dompdf_config.inc.php");
$html =ob_get_clean();
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper("A4");
$dompdf->render();
$canvas = $dompdf->get_canvas();
//$canvas->line(10,800,800,800,array(0,0,0),1);
$font = Font_Metrics::get_font("Arial", "normal");
$canvas->page_text(272, 814, "Page {PAGE_NUM}/{PAGE_COUNT}", $font, 10, array(0,0,0));
$dompdf->stream("PayrollReport.pdf", array("Attachment" => 0));
?>
