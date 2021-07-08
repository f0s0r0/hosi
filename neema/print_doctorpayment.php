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
$total1 = 0.00;
$total2 = 0.00;
$total3 = 0.00;
$snocount = "";

$month = date('M-Y');

ob_start();

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
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
<?php //include("a4pdfpayrollheader1.php"); ?>	

	
	<table width="530" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#FFFFFF">
	<td colspan="10" align="center" class="bodytext3" style="font-size:14px;"><strong><u>Doctor Payment Report</u></strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="10" align="left" class="bodytext3"><strong>Date From <?php echo $ADate1.' to Date '. $ADate2; ?></strong></td>
	</tr>
	 <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
				 <td width="9%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>  Date </strong></td>
              <td width="19%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Doctor</strong></div></td>
				  <td width="11%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Pay Amt</strong></div></td>
                      
				<td width="10%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> WHT Amt </strong></td>
   				  <td width="9%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Net Pay</strong></div></td>
				 <td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Mode</strong></div></td>
				 <td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Cheque No</strong></div></td>
				 <td width="14%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bank</strong></div></td>
				 <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
            </tr>
			
			<?php
			$arraysuppliercode = $_REQUEST['arraysuppliercode'];
		     $query12 = "select * from master_transactiondoctor where doctorcode = '$arraysuppliercode' and transactiondate between '$ADate1' and '$ADate2'"; 
			 $exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
			 while($res12 = mysql_fetch_array($exec12))
			 {
			 $doctorname = $res12['doctorname'];
			 $transactionamount = $res12['transactionamount'];
			 $taxamount = $res12['taxamount'];
			 $billnumber = $res12['billnumber'];
			 $transactiondate = $res12['transactiondate'];
			 $doctorcode = $res12['doctorcode'];
			 $transactionmode = $res12['transactionmode'];
			 $chequenumber = $res12['chequenumber'];
			 $bankname = $res12['bankname'];
			 
			 $cashamount = $res12['cashamount'];
			 $creditamount = $res12['creditamount'];
			 $onlineamount = $res12['onlineamount'];
			 $chequeamount = $res12['chequeamount'];
			 $cardamount = $res12['cardamount'];
			 $tdsamount = $res12['tdsamount'];
			 $writeoffamount = $res12['writeoffamount'];
			 
			 $netpay = $cashamount + $creditamount + $onlineamount + $chequeamount + $cardamount + $tdsamount + $writeoffamount;
			 
			 $total1 = $total1 + $transactionamount;
			 $total2 = $total2 + $taxamount;
			 $total3 = $total3 + $netpay;
			 
			 $snocount = $snocount + 1;
			 
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
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $doctorname; ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($transactionamount,2,'.',','); ?></td>
			  <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($taxamount,2,'.',','); ?></td>
			  <td class="bodytext31" valign="center"  align="right"><?php echo number_format($netpay,2,'.',','); ?></td>
             <td  align="left" valign="center" class="bodytext31"><div align="center"> <?php echo $transactionmode; ?></div></td>
			 <td  align="left" valign="center" class="bodytext31"><div align="left"> <?php echo $chequenumber; ?></div></td>
			 <td colspan="2" align="left" valign="center" class="bodytext31"><div align="left"> <?php echo $bankname; ?></div></td>
			  
			  
           </tr>
			<?php
			}
			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
             
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>Total:</strong></td>
								<td  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong><?php echo number_format($total1,2,'.',','); ?></strong></td>
				<td  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong><?php echo number_format($total2,2,'.',','); ?></strong></td>
				<td  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong><?php echo number_format($total3,2,'.',','); ?></strong></td>
				 
				 <td colspan="4" align="right" valign="center" bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
             
			</tr>
	</tbody>
	</table>

	
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
$dompdf->stream("DoctorpaymentReport.pdf", array("Attachment" => 1));
?>