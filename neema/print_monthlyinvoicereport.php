<?php
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="MonthlyInvoiceReport.xls"');
header('Cache-Control: max-age=80');

//include ("includes/loginverify.php");
include ("db/db_connect.php");

//$ipaddress = $_SERVER['REMOTE_ADDR'];
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$errmsg = "";
$searchsuppliername = "";
$searchsuppliername1 = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$totalcredit = "0.00";
$overalldebit= "0.00";
$overallcredit= "0.00";
$overallbalance= "0.00";

//This include updatation takes too long to load for hunge items database.
// for Excel Export
if (isset($_REQUEST["account"])) { $account = $_REQUEST["account"]; } else { $account = ""; }
if (isset($_REQUEST["subtype"])) { $subtype = $_REQUEST["subtype"]; } else { $subtype = ""; }
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
$account = trim($account);
$subtype = trim($subtype);
?></head>

<body>
<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1200" 
            align="left" border="1">
          <tbody>
            <tr>
              <td colspan="11" align="center" bgcolor="#ffffff" class="bodytext31"><strong>STATEMENT</strong></td>  
            </tr>
		<?php
		$query10 = "select * from master_accountname where subtype = '$subtype' and recordstatus = 'ACTIVE' ";
		$exec10 = mysql_query($query10) or die ("error in query10".mysql_error());
		$res10 = mysql_fetch_array($exec10);
	    $res10subtype = $res10['subtype'];
		?>
			
            <tr>
              <td colspan="2"align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Billing Month:</strong></td>
              <td colspan="7"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong><?php echo date('M',strtotime($ADate1)); ?>-<?php echo date('M',strtotime($ADate2)); ?> <?php echo date('Y',strtotime($ADate1)); ?></strong></td>
			</tr>
            <tr>
              <td colspan="2"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td colspan="9" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
            </tr>
			 <?php if($account != '') { ?> 	
            <tr>
              <td colspan="2"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>A/c Name: </strong></td>
              <td colspan="9" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong><?php echo $account; ?></strong></td>
            </tr>
			<?php } ?>
	        <?php if($subtype != '') { ?> 		
			<tr>
				<td colspan="2"  align="left" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><strong>A/c Subtype: </strong></td>
				<td colspan="9" align="left" valign="center"  
				bgcolor="#ffffff" class="bodytext31"><strong><?php echo $subtype; ?></strong></td>
			</tr>           
			<?php } ?>
			<tr>
              <td colspan="2"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td colspan="7" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td width="9%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Date</strong></td>
              <td width="35%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Bill No </strong></td>
              <td width="20%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Reg No </strong></td>
              <td width="20%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Visit Code </strong></td>
              <td width="20%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Member No. </strong></td>
              <td width="20%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>NHIF No. </strong></td>
              <td width="16%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Patient Name </strong></td>
				<td width="16%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Debit</strong></td>
				<td width="16%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Credit</strong></td>
				<td width="16%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Balance</strong></td>
            </tr>
			<?php if($account != '' || $subtype !='') { ?>
			<?php
			
			if(($account != '')&&($subtype != ''))
			{
$query21 = "select * from master_transactionpaylater where subtype = '$subtype' and accountname = '$account' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'finalize' order by auto_number desc ";
			}
			else if(($account == '')&&($subtype != ''))
			{
$query21 = "select * from master_transactionpaylater where subtype = '$subtype' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'finalize' order by auto_number desc ";
			}
			else if(($account != '')&&($subtype == ''))
			{
$query21 = "select * from master_transactionpaylater where accountname = '$account' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'finalize' order by auto_number desc ";
			}			
			$exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
			while ($res21 = mysql_fetch_array($exec21))
			{
			$res21accountname = $res21['accountname'];
			$res1subtype = $res21['subtype'];
			$res1transactiondate  = $res21['transactiondate'];
			$res1billnumber  = $res21['billnumber'];
			$res1patientcode = $res21['patientcode'];
			$res1patientname = $res21['patientname'];
			$res1visitcode = $res21['visitcode'];
		  
		  $query2 = "select sum(transactionamount) as transactionamount from master_transactionpaylater where accountname = '$res21accountname' and patientcode = '$res1patientcode' and visitcode = '$res1visitcode' and billnumber = '$res1billnumber' and transactiontype = 'finalize'";
		  $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		  $res2 = mysql_fetch_array($exec2);
		  $res2transactionamount = $res2['transactionamount'];
		  $overalldebit=$overalldebit + $res2transactionamount;
		  
		  $query3 = "select sum(transactionamount) as transactionamount from master_transactionpaylater where accountname = '$res21accountname' and patientcode = '$res1patientcode' and visitcode = '$res1visitcode'  and transactiontype = 'PAYMENT' and recordstatus = 'allocated'";
		  $exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
		  $res3 = mysql_fetch_array($exec3);
		  $res3transactionamount = $res3['transactionamount'];
		  
		  $query4 = "select sum(transactionamount) as transactionamount from master_transactionpaylater where accountname = '$res21accountname' and patientcode = '$res1patientcode' and visitcode = '$res1visitcode'  and transactiontype = 'paylatercredit' and recordstatus <> 'deallocated'";
		  $exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		  $res4 = mysql_fetch_array($exec4);
		  $res4transactionamount = $res4['transactionamount'];
		  
		  $query5 = "select sum(transactionamount) as transactionamount from master_transactionpaylater where accountname = '$res21accountname' and patientcode = '$res1patientcode' and visitcode = '$res1visitcode'  and transactiontype = 'pharmacycredit' and recordstatus <> 'deallocated'";
		  $exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
		  $res5 = mysql_fetch_array($exec5);
		  $res5transactionamount = $res5['transactionamount'];
          $totalcredit=  $res3transactionamount + $res4transactionamount + $res5transactionamount;
		  $overallcredit = $overallcredit  + $totalcredit;
		  $invoicevalue = $res2transactionamount - ($res3transactionamount + $res4transactionamount + $res5transactionamount);

		  $query51 = "select mrdno from master_customer where customercode = '$res1patientcode'";
		  $exec51 = mysql_query($query51) or die ("Error in Query51".mysql_error());
		  $res51 = mysql_fetch_array($exec51);
		  $res51memberno = $res51['mrdno'];

		  $res51nhifno="";

		  $query51 = "select nhifid from master_ipvisitentry where patientcode = '$res1patientcode' and visitcode='$res1visitcode'";
		  $exec51 = mysql_query($query51) or die ("Error in Query51".mysql_error());
		  if($res51 = mysql_fetch_array($exec51)){
		  $res51nhifno = $res51['nhifid'];
}

          $overallbalance = $overallbalance + $invoicevalue;
		  if($invoicevalue != 0)
		  {
			?>
			
		<tr>
			<td class="bodytext31" valign="center"  align="left"><?php echo $snocount=$snocount + 1; ?></td>
			<td class="bodytext31" valign="center"  align="left"><?php echo $res1transactiondate; ?></td>
			<td class="bodytext31" valign="center"  align="left"><?php echo $res1billnumber; ?></td>
			<td class="bodytext31" valign="center"  align="left"><?php echo $res1patientcode; ?></td>
			<td class="bodytext31" valign="center"  align="left" style='mso-number-format:"\@"'><?php echo $res1visitcode; ?></td>
<td class="bodytext31" valign="center"  align="left"><?php echo $res51memberno; ?></td>
<td class="bodytext31" valign="center"  align="left"><?php echo $res51nhifno; ?></td>
			<td class="bodytext31" valign="center"  align="left"><?php echo $res1patientname; ?></td>
			<td class="bodytext31" valign="center"  align="left" style='mso-number-format:"\#\,\#\#0\.00"'><div align="right"><?php echo number_format($res2transactionamount,2,'.',','); ?></div></td>
			<td class="bodytext31" valign="center"  align="right" style='mso-number-format:"\#\,\#\#0\.00"'><?php echo number_format($totalcredit,2,'.',','); ?></td>
			<td class="bodytext31" valign="center"  align="right" style='mso-number-format:"\#\,\#\#0\.00"'><?php echo number_format($invoicevalue,2,'.',','); ?></td>
			</tr>			
		<?php
		} }
		?>
		 <?php } ?>		
            <tr>
              <td colspan="7"  align="left" valign="center" class="bodytext31" 
           >&nbsp;</td>
              <td align="right" valign="center" 
            class="bodytext31"><strong>Total</strong></td>
              <td class="bodytext31" valign="center"  align="right" style='mso-number-format:"\#\,\#\#0\.00"'
           ><strong><?php echo number_format($overalldebit,2,'.',','); ?></strong></td>
                <td class="bodytext31" valign="center"  align="right" style='mso-number-format:"\#\,\#\#0\.00"'
           ><strong><?php echo number_format($overallcredit,2,'.',','); ?></strong></td>
                <td class="bodytext31" valign="center"  align="right" style='mso-number-format:"\#\,\#\#0\.00"' 
           ><strong><?php echo number_format($overallbalance,2,'.',','); ?></strong></td>
			    </tr>
  </tbody>
</table>
</td>
      </tr>
            </table>
            </table>
</body>
</html>
