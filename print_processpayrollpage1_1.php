<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");

$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$dateonly1 = date("Y-m-d");
$timeonly= date("H:i:s");

$colorloopcount = '';
$sno = '';
$pagebreak = '';
$totalearnings = '0.00';
$totaldeductions = '0.00';
$nettpay = '0.00';
$grosspay = '0.00';
$totalnotionalbenefit = '0.00';
$totaldeduct = '0.00';

ob_start();

//if (isset($_REQUEST["employeecode"])) { $employeecode = $_REQUEST["employeecode"]; } else { $employeecode = ""; }
if (isset($_REQUEST["assignmonth"])) { $assignmonth= $_REQUEST["assignmonth"]; } else { $assignmonth = ""; }
if (isset($_REQUEST["emplimit"])) { $emplimit= $_REQUEST["emplimit"]; } else { $emplimit = ""; }

$fullmonth = date('F-Y',strtotime($assignmonth));

$query1 = "select * from master_company";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
$res1 = mysql_fetch_array($exec1);
$companycode = $res1['companycode'];
$companyname = $res1['companyname'];
$companyanum = $res1['auto_number'];

?>
<style>
body {
    font-family: 'Arial'; font-size:11px;	 
}
#footer { position: fixed; left: 0px; bottom: -90px; right: 0px; height: 150px; }
#footer .page:after { content: counter(page, upper-roman); }
.page { page-break-after:always; }

</style>
<?php include('a4pdfheader.php'); ?>
    
	
	<?php
	$totalearnings = '0.00';
	$totaldeductions = '0.00';
	$nettpay = '0.00';
	$grosspay = '0.00';
	$totalnotionalbenefit = '0.00';
	$totaldeduct = '0.00';

	$query30 = "select * from details_employeepayroll where paymonth = '$assignmonth' and status <> 'deleted' group by employeecode order by employeename limit $emplimit";
	$exec30 = mysql_query($query30) or die ("Error in Query30".mysql_error());
	while($res30 = mysql_fetch_array($exec30))
	{
		$res30employeecode = $res30['employeecode'];

	?>
	<table class="page" id="pagebreak" width="260" border="0" cellspacing="0" cellpadding="2" align="center">  
	<tr>
	<td align="left" valign="top" nowrap="nowrap">
	<table width="260" border="0" cellspacing="0" cellpadding="2"> 
        <tr>
		  <td rowspan="6" align="left" valign="top" nowrap="nowrap" class="bodytext27"><img src="logofiles/<?php echo $companyanum;?>.jpg" height="60" width="50" /></td>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo $companyname; ?></strong></td>
        </tr>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>PAY SLIP : <?php echo $fullmonth; ?></strong></td>
        </tr>
		<?php
		$query2 = "select * from master_employee where employeecode = '$res30employeecode'";
		$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		$res2 = mysql_fetch_array($exec2);
		$employeename = $res2['employeename'];
		$res2employeecode = $res2['employeecode'];
		
		$query3 = "select * from master_employeeinfo where employeecode = '$res30employeecode'";
		$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
		$res3 = mysql_fetch_array($exec3);
		$pinno = $res3['pinno'];
		$nssfno = $res3['nssf'];
		$nhifno = $res3['nhif'];
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong> Name : <?php echo $employeename; ?></strong></td>
        </tr>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong> Payroll No : <?php echo $res2employeecode; ?></strong></td>
        </tr>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong> Pin No : <?php echo $pinno; ?></strong></td>
        </tr>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong> NSSF : <?php echo $nssfno.' , '.'NHIF : '.$nhifno; ?></strong></td>
        </tr>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
        </tr>
		</table>
	<table width="260" border="0" cellspacing="0" cellpadding="2"> 
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>EARNINGS</strong></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><strong>AMOUNT</strong>&nbsp;&nbsp;</td>
        </tr>
		<?php
		$totalearnings = '0.00';
		$totaldeductions = '0.00';
		$nettpay = '0.00';
		$grosspay = '0.00';
		$totalnotionalbenefit = '0.00';
		$res5componentamount = '0.00';
		$res51componentamount = '0.00';
		$totaldeduct = '0.00';

		$query3 = "select * from details_employeepayroll where employeecode = '$res30employeecode' and paymonth = '$assignmonth' and typecode = '10' and status <> 'deleted' order by auto_number";
		$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
		while($res3 = mysql_fetch_array($exec3))
		{
			$res3componentanum = $res3['componentanum'];
			
			$query6 = "select * from master_payrollcomponent where auto_number = '$res3componentanum' and recordstatus <> 'deleted' and notional = 'No'";
			$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
			$res6 = mysql_fetch_array($exec6);
			$res6componentname = $res6['componentname'];
			if($res6componentname != '')
			{
				$res3componentname = $res3['componentname'];
				$res3componentrate = $res3['componentrate'];
				$res3componentunit = $res3['componentunit'];
				$res3componentamount = $res3['componentamount'];
				
				$totalearnings = $totalearnings + $res3componentamount;		
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $res3componentname; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($res3componentamount,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>	
		<?php
		}
		}
		?>
		<tr>
          <td colspan="2" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
        </tr>
		<!--<tr>
          <td colspan="2" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo 'NOTIONAL BENEFITS'; ?></strong></td>
        </tr>-->
		<?php
		$query7 = "select * from details_employeepayroll where employeecode = '$res30employeecode' and paymonth = '$assignmonth' and typecode = '10' and status <> 'deleted' order by auto_number";
		$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
		while($res7 = mysql_fetch_array($exec7))
		{
			$res7componentanum = $res7['componentanum'];
			
			$query8 = "select * from master_payrollcomponent where auto_number = '$res7componentanum' and recordstatus <> 'deleted' and notional = 'Yes'";
			$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
			$res8 = mysql_fetch_array($exec8);
			$res8componentname = $res8['componentname'];
			if($res8componentname != '')
			{
				$res7componentname = $res7['componentname'];
				$res7componentrate = $res7['componentrate'];
				$res7componentunit = $res7['componentunit'];
				$res7componentamount = $res7['componentamount'];
				
				$totalnotionalbenefit = $totalnotionalbenefit + $res7componentamount;
				
				$totalearnings = $totalearnings + $res7componentamount;			
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $res7componentname; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($res7componentamount,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>	
		<?php
		}
		}
		?>
		<?php
		$query81 = "select * from details_employeepayroll where employeecode = '$res30employeecode' and paymonth = '$assignmonth' and componentanum = '0' and typecode = '10' and status <> 'deleted'";
		$exec81 = mysql_query($query81) or die ("Error in Query81".mysql_error());
		$res81 = mysql_fetch_array($exec81);
		$res81componentname = $res81['componentname'];
		if($res81componentname != '')
		{
			$res81componentname = $res81['componentname'];
			$res81componentrate = $res81['componentrate'];
			$res81componentunit = $res81['componentunit'];
			$res81componentamount = $res81['componentamount'];
			
			$totalnotionalbenefit = $totalnotionalbenefit + $res81componentamount;
			
			$totalearnings = $totalearnings + $res81componentamount;			
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $res81componentname; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($res81componentamount,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>	
		<?php
		}
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo 'TOTAL EARNINGS'; ?></strong></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo number_format($totalearnings,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
        </tr>
		<tr>
          <td colspan="2" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
        </tr>
		<tr>
          <td colspan="2" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo 'TAX CALCULATION'; ?></strong></td>
        </tr>
		<?php
		$query79 = "select * from details_employeepayroll where employeecode = '$res30employeecode' and paymonth = '$assignmonth' and status <> 'deleted' order by auto_number";
		$exec79 = mysql_query($query79) or die ("Error in Query79".mysql_error());
		while($res79 = mysql_fetch_array($exec79))
		{
			$res79componentanum = $res79['componentanum'];
			
		$query5 = "select * from master_payrollcomponent where auto_number = '$res79componentanum' and deductearning = 'Yes' and recordstatus <> 'deleted'";
		$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
		$res5 = mysql_fetch_array($exec5);
		$res5componentname = $res5['componentname'];
		if($res5componentname != '')
		{
		$res79componentrate = $res79['componentrate'];
		$res79componentunit = $res79['componentunit'];
		$res79componentamount = $res79['componentamount'];
		
		$totaldeduct = $totaldeduct + $res79componentamount;
		
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $res5componentname; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo '- '.number_format($res79componentamount,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>
		<?php
		}
		}
		$taxablepay = $totalearnings - $totaldeduct;
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo 'TAXABLE PAY'; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($taxablepay,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>
		<?php
		$query52 = "select * from details_employeepayroll where employeecode = '$res30employeecode' and paymonth = '$assignmonth' and componentanum = '8' and status <> 'deleted'";
		$exec52 = mysql_query($query52) or die ("Error in Query52".mysql_error());
		$res52 = mysql_fetch_array($exec52);
		$res52componentname = $res52['componentname'];
		$res52componentrate = $res52['componentrate'];
		$res52componentunit = $res52['componentunit'];
		$res52componentamount = $res52['componentamount'];
		if($res52componentname != '')
		{
			$query53 = "select * from master_taxrelief where status <> 'deleted'";
			$exec53 = mysql_query($query53) or die ("Error in Query53".mysql_error());
			$res53 = mysql_fetch_array($exec53);
			$res53amount = $res53['finalamount'];
			
			$query7 = "select * from insurance_relief where employeecode = '$res30employeecode' and status <> 'deleted'";
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

			
			$taxcharged = $res53amount + $res52componentamount + $insurancerelief;
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo 'TAX CHARGED'; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($taxcharged,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>
		<?php
		}
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo 'TAX RELIEF'; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($res53amount,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>
		<?php
		if($insurancerelief != '0.00')
		{
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo 'INSURANCE RELIEF'; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($insurancerelief,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>
		<?php
		}
		?>
		<tr>
          <td colspan="2" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
        </tr>
		<tr>
          <td colspan="2" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo 'DEDUCTIONS'; ?></strong></td>
        </tr>
		<?php
		$query4 = "select * from details_employeepayroll where employeecode = '$res30employeecode' and paymonth = '$assignmonth' and typecode = '20' and status <> 'deleted' order by auto_number";
		$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		while($res4 = mysql_fetch_array($exec4))
		{
			$res4componentanum = $res4['componentanum'];
			$res4componentname = $res4['componentname'];
			$res4componentrate = $res4['componentrate'];
			$res4componentunit = $res4['componentunit'];
			$res4componentamount = $res4['componentamount'];
			
			$totaldeductions = $totaldeductions + $res4componentamount;
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo $res4componentname; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($res4componentamount,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>	
		<?php
		}
		
		$grosspay = $totalearnings - $totalnotionalbenefit;
		$nettpay = $grosspay - $totaldeductions;
		?>
		<!--<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo 'TOTAL DEDUCTIONS'; ?></strong></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo number_format($totaldeductions,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
        </tr>-->
		<tr>
          <td colspan="2" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
        </tr>	
		<tr>
          <td colspan="2" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>SUMMARY</strong></td>
        </tr>	
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo 'TOTAL EARNINGS'; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($totalearnings,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>	
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo 'NOTIONAL BENEFITS'; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo '- '.number_format($totalnotionalbenefit,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo 'GROSS PAY'; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($grosspay,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo 'DEDUCTIONS'; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo '- '.number_format($totaldeductions,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>	
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo 'NET SALARY'; ?></strong></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo number_format($nettpay,2,'.',','); ?></strong>&nbsp;&nbsp;</td>
        </tr>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
        </tr>	
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>RECEIVED BY :</strong></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
        </tr>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
        </tr>	
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>LOAN DETAILS</strong></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><strong>&nbsp;</strong></td>
        </tr>	
		<?php
		$query55 = "select sum(amount) as totalloan, loanname from loan_assign where employeecode = '$res30employeecode' and status <> 'deleted'";
		$exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
		$res55 = mysql_fetch_array($exec55);
		$loanname = $res55['loanname'];
		$totalloan = $res55['totalloan'];
		if($loanname == '')
		{
			$loanname = '';
			$totalloan = '0.00';
		}	
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27">Loan Amount :</td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($totalloan,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>	
		<?php
		$query56 = "select sum(monthamount) as totalloanpaid from details_loanpay where employeecode = '$res30employeecode' and loanname = '$loanname' and status <> 'deleted'";
		$exec56 = mysql_query($query56) or die ("Error in Query56".mysql_error());
		$res56 = mysql_fetch_array($exec56);
		$totalloanpaid = $res56['totalloanpaid'];
		if($totalloanpaid == '')
		{
			$totalloanpaid = '0.00';
		}
		$balance = $totalloan - $totalloanpaid;
		?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27">Loan Paid :</td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($totalloanpaid,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27">Balance :</td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo number_format($balance,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>	
		
     </table>
	</td>  
	</tr>
	</table>  
	<?php
	}
	?>
	 
<?php	
require_once("dompdf/dompdf_config.inc.php");
$html =ob_get_clean();
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper(array(0,0,330.00, 842.00));
$dompdf->render();
$canvas = $dompdf->get_canvas();
//$canvas->line(10,800,800,800,array(0,0,0),1);
$font = Font_Metrics::get_font("times-roman", "normal");
//$canvas->page_text(272, 814, "Page {PAGE_NUM}/{PAGE_COUNT}", $font, 10, array(0,0,0));
$dompdf->stream("Payslip.pdf", array("Attachment" => 1)); 
?>