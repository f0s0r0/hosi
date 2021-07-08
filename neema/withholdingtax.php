<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
set_time_limit(0);
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$paymentreceiveddateto1 = "2014-01-01";
$errmsg = "";
$colorloopcount="";
$range = "";
$sno = "";
$totaltax = '0.00';
$totaltrans = '0.00';
$status = 'Unpaid';

//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//echo $ADate2;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];
if ($cbfrmflag1 == 'cbfrmflag1')
{
$paymentreceiveddatefrom = $ADate1;
$paymentreceiveddateto = $ADate2;
}
?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
.bal
{
border-style:none;
background:none;
text-align:right;
}
.bali
{
text-align:right;
}
</style>
</head>

<script src="js/datetimepicker_css.js"></script>

<body>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="withholdingtax.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#CCCCCC" class="bodytext3"><strong>With Holding Tax</strong></td>
              </tr>
            <!--<tr>
              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
			  <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Payment Entry" /> 
                *To Print Other Receipts Please Go To Menu:	Reports	-&gt; Payments Given 
				</td>
              </tr>-->
            
		   
			  <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" style="border: 1px solid #001E6A" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>	
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="border: 1px solid #001E6A; text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  style="border: 1px solid #001E6A" type="submit" onClick="return funcAccount();" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton"  style="border: 1px solid #001E6A" value="Reset" /></td>
            </tr>
          </tbody>
        </table>
		</form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
		<?php
	if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
	//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
	if ($cbfrmflag1 == 'cbfrmflag1')
	{
	if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
	//echo $ADate1;
	if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
	//echo $ADate2;
	$url = "ADate1=$ADate1&&ADate2=$ADate2";
	?>
       <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" 
            align="left" border="0">
          <tbody>
          
		 	<tr bgcolor="#CCCCCC">
			<td width="36" align="left" class="bodytext31"><strong>S.No</strong></td>
			<td width="81" align="left" class="bodytext31"><strong>Date</strong></td>
			<td width="90" align="left" class="bodytext31"><strong>Doc No</strong></td>
			<td width="171" align="left" class="bodytext31"><strong>Towards</strong></td>
			<td width="231" align="right" class="bodytext31"><strong>Trans Amount</strong></td>
			<td width="89" align="right" class="bodytext31"><strong>WHT Amount</strong></td>
			<!--<td width="71" align="center" class="bodytext31"><strong>Status</strong></td>-->			
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
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#D3EEB7"';
			}
			?>
			<tr <?php echo $colorcode; ?>>
			<td align="left" class="bodytext31"><?php echo $sno; ?></td>
			<td align="left" class="bodytext31"><?php echo $transactiondate; ?></td>
			<td align="left" class="bodytext31"><?php echo $docno; ?></td>
			<td align="left" class="bodytext31"><?php echo $doctorname; ?></td>
			<td align="right" class="bodytext31"><?php echo number_format($transactionamount,2,'.',','); ?></td>
			<td align="right" class="bodytext31"><?php echo number_format($taxamount,2,'.',','); ?></td>
			<!--<td align="center" class="bodytext31"><?php echo $status; ?></td>-->
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
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#D3EEB7"';
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
	         <tr bgcolor="#CCCCCC">
			 <td class="bodytext31" valign="center"  align="left"></td>
			  <td colspan="3" class="bodytext31" valign="center"  align="right"><strong>Total</strong></td>
			  <td class="bodytext31" valign="center"  align="right"><strong><?php echo number_format($totaltrans,2,'.',','); ?></strong></td>
			  <td class="bodytext31" valign="center"  align="right"><strong><?php echo number_format($totaltax,2,'.',','); ?></strong></td>
			  
			 </tr>
			 </tbody>
			</table></td>
		  </tr>
		  <tr>
		  <td align="left">&nbsp;</td>
		  </tr>
		 <tr>
	<td colspan="7" align="left" class="bodytext3"><a href="print_whtreport1.php?<?php echo $url; ?>"><img src="images/pdfdownload.jpg" height="40" width="40"></a>
	&nbsp;&nbsp;&nbsp;<a href="print_whtreportxl.php?<?php echo $url; ?>"><img src="images/excel-xls-icon.png" height="40" width="40"></a></td>
	</tr>
			<?php
			}			
			?>
         
</table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
