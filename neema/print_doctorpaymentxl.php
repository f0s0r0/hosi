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
$total1 = 0.00;
$total2 = 0.00;
$total3 = 0.00;
$snocount = "";

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="DoctorPaymentreport.xls"');
header('Cache-Control: max-age=80');


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
	
	<table width="530" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#FFFFFF">
	<td colspan="6" align="left" class="bodytext3"><strong>Doctor Payment Report</strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="6" align="left" class="bodytext3"><strong>Date From <?php echo $ADate1.' to Date '. $ADate2; ?></strong></td>
	</tr>
	<tr>
<?php 
$query2 = "select * from master_company where auto_number = '$companyanum'";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$companyname = $res2["companyname"];
$address1 = $res2["address1"];
$address2 = $res2["address2"];
$area = $res2["area"];
$city = $res2["city"];
$pincode = $res2["pincode"];
$phonenumber1 = $res2["phonenumber1"];
$phonenumber2 = $res2["phonenumber2"];
$tinnumber1 = $res2["tinnumber"];
$cstnumber1 = $res2["cstnumber"];
?>

 
<td colspan="4" class="bodytext35"><div align="left"><?php echo $companyname; ?>
  <?php
$strlen3 = strlen($address1);
$totalcharacterlength3 = 35;
$totalblankspace3 = 35 - $strlen3;
$splitblankspace3 = $totalblankspace3 / 2;
for($i=1;$i<=$splitblankspace3;$i++)
{
$address1 = ' '.$address1.' ';
}
?>			
</div></td>
  </tr>
		<tr>
			<td colspan="4" class="bodytext32"><div align="left"><?php echo $address1; ?>
		      <?php
			$address2 = $area.''.$city.' '.$pincode.'';
			$strlen3 = strlen($address2);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address2 = ' '.$address2.' ';    
			}
			?>			
		    </div></td>
		</tr>
		<tr>
			<td colspan="4" class="bodytext32">
			
			  <div align="left"><?php echo $address2; ?>
		        <?php
			$address3 = "PHONE: ".$phonenumber1.' '.$phonenumber2;
			$strlen3 = strlen($address3);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address3 = ' '.$address3.' ';
			}
			?>			
	        </div></td>
		</tr>

<tr>
<td colspan="4" style="">&nbsp;</td>
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
