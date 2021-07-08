<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
//include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");

$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
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

$query1 = "select * from master_company where auto_number = '$companyanum'";
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

<page pagegroup="new" backtop="8mm" backbottom="7mm" backleft="2mm" backright="3mm">

<?php include('a4pdfheader.php'); ?>
    
	
	<?php
	$totalearnings = '0.00';
	$totaldeductions = '0.00';
	$nettpay = '0.00';
	$grosspay = '0.00';
	$totalnotionalbenefit = '0.00';
	$totaldeduct = '0.00';

	$query30 = "select * from details_employeepayroll where paymonth = '$assignmonth' and status <> 'deleted'  group by employeecode order by employeename limit $emplimit";
	$exec30 = mysql_query($query30) or die ("Error in Query30".mysql_error());
	while($res30 = mysql_fetch_array($exec30))
	{
		$res30employeecode = $res30['employeecode'];

	?>
	<table width="360" border="0" cellspacing="0" cellpadding="2" align="center">  
	<tr>
	<td align="left" valign="top" nowrap="nowrap">
	<table width="360" border="0" cellspacing="0" cellpadding="2"> 
        <tr>
		  <td width="90" rowspan="6" align="left" valign="top" nowrap="nowrap" class="bodytext27"><img src="logofiles/<?php echo $companyanum;?>.jpg" height="60" width="50" /></td>
          <td width="250" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong><?php echo $companyname; ?></strong></td>
        </tr>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>PAY SLIP : <?php echo $fullmonth; ?></strong></td>
        </tr>
		<?php
		$query2 = "select * from master_employee where employeecode = '$res30employeecode' ";
		$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		$res2 = mysql_fetch_array($exec2);
		$employeename = $res2['employeename'];
		$res2employeecode = $res2['employeecode'];
		
		$query3 = "select * from master_employeeinfo where employeecode = '$res30employeecode' ";
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
	<table width="360" border="0" cellspacing="0" cellpadding="2"> 
		<tr>
          <td width="180" align="left" valign="middle" nowrap="nowrap" class="bodytext27"><strong>EARNINGS</strong></td>
		  <td width="180" align="right" valign="middle" nowrap="nowrap" class="bodytext27"><strong>AMOUNT</strong>&nbsp;&nbsp;</td>
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

		$query6 = "select auto_number, componentname from master_payrollcomponent where recordstatus <> 'deleted' and typecode = '10' and notional = 'No'";
		$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
		while($res6 = mysql_fetch_array($exec6))
		{
			$auto_number = $res6['auto_number'];
			$query3 = "select `$auto_number` as componentamount from details_employeepayroll where employeecode = '$res30employeecode' and paymonth = '$assignmonth' and status <> 'deleted'  order by auto_number";
			$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
			$res3 = mysql_fetch_array($exec3);
			$res3componentanum = $auto_number;
			
			
			$res6componentname = $res6['componentname'];
			if($res6componentname != '')
			{
				$res3componentname = $res6['componentname'];
				$res3componentrate = $res3['componentamount'];
				$res3componentunit = 1;
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
		$query8 = "select * from master_payrollcomponent where recordstatus <> 'deleted' and typecode = '10' and notional = 'Yes'";
		$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
		while($res8 = mysql_fetch_array($exec8))
		{
			$auto_number = $res8['auto_number'];
			$query7 = "select `$auto_number` as componentamount from details_employeepayroll where employeecode = '$res30employeecode' and paymonth = '$assignmonth' and status <> 'deleted'  order by auto_number";
			$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
			$res7 = mysql_fetch_array($exec7);
			$res7componentanum = $auto_number;
			
			
			$res8componentname = $res8['componentname'];
			if($res8componentname != '')
			{
				$res7componentname = $res8['componentname'];
				$res7componentrate = $res7['componentamount'];
				$res7componentunit = 1;
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
		$query822 = "select * from master_payrollcomponent where recordstatus <> 'deleted' and typecode = '10'";
		$exec822 = mysql_query($query822) or die ("Error in Query822".mysql_error());
		while($res822 = mysql_fetch_array($exec822))
		{
			$auto_number = $res822['auto_number'];
			
		$query81 = "select `$auto_number` as componentamount from details_employeepayroll where employeecode = '$res30employeecode' and paymonth = '$assignmonth' and status <> 'deleted' ";
		$exec81 = mysql_query($query81) or die ("Error in Query81".mysql_error());
		$res81 = mysql_fetch_array($exec81);
		$res81componentname = $res81['componentname'];
		if($res81componentname != '')
		{
			$res81componentname = $res822['componentname'];
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
		$query5 = "select * from master_payrollcomponent where deductearning = 'Yes' and recordstatus <> 'deleted'";
		$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
		while($res5 = mysql_fetch_array($exec5))
		{
			$anum = $res5['auto_number'];
			$query79 = "select `$anum` as componentamount from details_employeepayroll where employeecode = '$res30employeecode' and paymonth = '$assignmonth' and status <> 'deleted'  order by auto_number";
			$exec79 = mysql_query($query79) or die ("Error in Query79".mysql_error());
			$res79 = mysql_fetch_array($exec79);
			$res79componentanum = $anum;
			
		
		$res5componentname = $res5['componentname'];
		if($res5componentname != '')
		{
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
		$query521 = "select * from master_payrollcomponent where auto_number = '8' and recordstatus <> 'deleted' ";
		$exec521 = mysql_query($query521) or die ("Error in Query521".mysql_error());
		$res521 = mysql_fetch_array($exec521);
		
		$query52 = "select `8` as componentamount from details_employeepayroll where employeecode = '$res30employeecode' and paymonth = '$assignmonth' and status <> 'deleted' ";
		$exec52 = mysql_query($query52) or die ("Error in Query52".mysql_error());
		$res52 = mysql_fetch_array($exec52);
		$res52componentname = $res521['componentname'];
		$res52componentamount = $res52['componentamount'];
		if($res52componentname != '')
		{
			$query53 = "select * from master_taxrelief where status <> 'deleted'";
			$exec53 = mysql_query($query53) or die ("Error in Query53".mysql_error());
			$res53 = mysql_fetch_array($exec53);
			$res53amount = $res53['finalamount'];
			
			$query7 = "select * from insurance_relief where employeecode = '$res30employeecode'  and status <> 'deleted'";
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
		$query4 = "select * from master_payrollcomponent where typecode = '20' and recordstatus <> 'deleted'  order by auto_number";
		$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		while($res4 = mysql_fetch_array($exec4))
		{
			$res4componentanum = $res4['auto_number'];
			$query41 = "select `$res4componentanum` as componentamount from details_employeepayroll where employeecode = '$res30employeecode' and paymonth = '$assignmonth' and status <> 'deleted'  order by auto_number";
			$exec41 = mysql_query($query41) or die ("Error in Query41".mysql_error());
			$res41 = mysql_fetch_array($exec41);
			
			$res4componentname = $res4['componentname'];
			$res4componentamount = $res41['componentamount'];
			
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
		<?php if($totalnotionalbenefit != '0.00') { ?>
		<tr>
          <td align="left" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo 'NOTIONAL BENEFITS'; ?></td>
		  <td align="right" valign="middle" nowrap="nowrap" class="bodytext27"><?php echo '- '.number_format($totalnotionalbenefit,2,'.',','); ?>&nbsp;&nbsp;</td>
        </tr>
		<?php } ?>
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
     </table>
	</td>  
	</tr>
	</table>  
	<?php
	}
	?>
	 
	 </page>
	 
	 <?php

    $content = ob_get_clean();

    // convert in PDF
    require_once('html2pdf/html2pdf.class.php');
    try
    {
         $html2pdf = new HTML2PDF('P', array(250,110),'en', true, 'UTF-8', array(0, 0, 0, 0));
//      $html2pdf->setModeDebug();
        //$html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('Payslip.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>

