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
$sno = '';
$totaltax = '';
$totaltrans = '';

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="WHTreport.xls"');
header('Cache-Control: max-age=80');

$month = date('M-Y');

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//echo $ADate2;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

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

	<table width="500" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#FFFFFF">
	<td width="50" align="center" bgcolor="#FFFFFF" class="bodytext3"><strong>&nbsp;</strong></td>
	<td colspan="10" align="left" class="bodytext3"><strong>Withholding Tax Report From : <?php echo $ADate1.' to Date :'.$ADate2; ?></strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
			<td width="36" align="left" class="bodytext31"><strong>S.No</strong></td>
			<td width="81" align="left" class="bodytext31"><strong>Date</strong></td>
			<td width="90" align="left" class="bodytext31"><strong>Doc No</strong></td>
			<td width="171" align="left" class="bodytext31"><strong>Towards</strong></td>
			<td width="231" align="right" class="bodytext31"><strong>Trans Amount</strong></td>
			<td width="89" align="right" class="bodytext31"><strong>WHT Amount</strong></td>
			<td width="71" align="center" class="bodytext31"><strong></strong></td>			
			</tr>
			<?php
			$query4 = "select * from master_transactiondoctor where transactiondate between '$ADate1' and '$ADate2' and recordstatus <> 'deleted' and taxamount <> '0.00'";
			$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
			while($res4 = mysql_fetch_array($exec4))
			{
			$sno = $sno + 1;
			$docno = $res4['docno'];
			$doctorname = $res4['doctorname'];
			$patientname = $res4['patientname'];
			$patientcode = $res4['patientcode'];
			$visitcode = $res4['visitcode'];
			$transactionamount = $res4['transactionamount'];
			$taxamount = $res4['taxamount'];
			$transactiondate = $res4['transactiondate'];
			
			//$query12 = "select * from withholdtax_details where recordstatus <> 'deleted' and billnumber = '$docno'";
			//$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
			//$rows12 = mysql_num_rows($exec12);
			$rows12=0;
			if($rows12 != 0)
			{
			$status = 'Paid';
			}
			else
			{
			$status = 'Unpaid';
			}
		
			$totaltax = $totaltax + $taxamount;
			$totaltrans = $totaltrans + $transactionamount;
			
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
			?>
			<tr <?php echo $colorcode; ?>>
			<td align="left" class="bodytext31"><?php echo $sno; ?></td>
			<td align="left" class="bodytext31"><?php echo $transactiondate; ?></td>
			<td align="left" class="bodytext31"><?php echo $docno; ?></td>
			<td align="left" class="bodytext31"><?php echo $doctorname; ?></td>
			<td align="right" class="bodytext31"><?php echo number_format($transactionamount,2,'.',','); ?></td>
			<td align="right" class="bodytext31"><?php echo number_format($taxamount,2,'.',','); ?></td>
			<td align="center" class="bodytext31"><?php //echo $status; ?></td>
			</tr>
			<?php
			}
			?>
	        <!-- <tr bgcolor="#CCCCCC">
			 <td class="bodytext31" valign="center"  align="left"></td>
			  <td colspan="3" class="bodytext31" valign="center"  align="right"><strong>Total</strong></td>
			  <td class="bodytext31" valign="center"  align="right"><strong><?php //echo number_format($totaltrans,2,'.',','); ?></strong></td>
			  <td class="bodytext31" valign="center"  align="right"><strong><?php //echo number_format($totaltax,2,'.',','); ?></strong></td>
			  <td class="bodytext31" align="left">&nbsp;</td>
			 </tr>-->          
			<?php
			$query5 = "select * from master_transactionpharmacy where transactiondate between '$ADate1' and '$ADate2' and recordstatus <> 'deleted' and taxamount <> '0.00'";
			$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
			while($res5 = mysql_fetch_array($exec5))
			{
			$sno = $sno + 1;
			$pharmacydocno = $res5['docno'];
			$suppliername = $res5['suppliername'];
			$billnumber = $res5['billnumber'];
			$pharmacytransactionamount = $res5['transactionamount'];
			$pharmacytaxamount = $res5['taxamount'];
			$pharmacytransactiondate = $res5['transactiondate'];
			
			$query13 = "select * from withholdtax_details where recordstatus <> 'deleted' and billnumber = '$pharmacydocno'";
			$exec13 = mysql_query($query13) or die ("Error in Query13".mysql_error());
			$rows13 = mysql_num_rows($exec13);
			
			if($rows13 != 0)
			{
			$status = 'Paid';
			}
			else
			{
			$status = 'Unpaid';
			}
			$totaltax = $totaltax + $pharmacytaxamount;
			$totaltrans = $totaltrans + $pharmacytransactionamount;
			
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#FFFFFF"';
			}
			?>
			<tr <?php echo $colorcode; ?>>
			<td width="36" align="left" class="bodytext31"><?php echo $sno; ?></td>
			<td width="81" align="left" class="bodytext31"><?php echo $pharmacytransactiondate; ?></td>
			<td width="90" align="left" class="bodytext31"><?php echo $pharmacydocno; ?></td>
			<td width="171" align="left" class="bodytext31"><?php echo $suppliername; ?></td>
			<td width="231" align="right" class="bodytext31"><?php echo number_format($pharmacytransactionamount,2,'.',','); ?></td>
			<td width="89" align="right" class="bodytext31"><?php echo number_format($pharmacytaxamount,2,'.',','); ?></td>
			<td width="71" align="center" class="bodytext31"><?php echo $status; ?></td>
			</tr>
			<?php
			}
			?>
	         <tr bgcolor="#FFFFFF">
			 <td class="bodytext31" valign="center"  align="left"></td>
			  <td colspan="3" class="bodytext31" valign="center"  align="right"><strong>Total</strong></td>
			  <td class="bodytext31" valign="center"  align="right"><strong><?php echo number_format($totaltrans,2,'.',','); ?></strong></td>
			  <td class="bodytext31" valign="center"  align="right"><strong><?php echo number_format($totaltax,2,'.',','); ?></strong></td>
			  <td class="bodytext31" align="left">&nbsp;</td>
			 </tr>
	</tbody>
	</table>
	
	
