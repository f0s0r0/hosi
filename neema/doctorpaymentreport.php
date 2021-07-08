<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d');
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$total = '0.00';
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$range = "";
$res1suppliername = '';
$total1 = '0.00';
$total2 = '0.00';
$total3 = '0.00';
$total4 = '0.00';
$total5 = '0.00';
$total6 = '0.00';
//This include updatation takes too long to load for hunge items database.
include ("autocompletebuild_doctor.php");

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$frmflag2 = $_POST['frmflag2'];
if($cbfrmflag1 == 'cbfrmflag1')
{
$paymentreceiveddatefrom = $ADate1;
$paymentreceiveddateto = $ADate2;
$transactiondatefrom = $ADate1;
$transactiondateto = $ADate2;
}
else
{
$paymentreceiveddatefrom = date('Y-m-d');
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');
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
<script src="js/datetimepicker_css.js"></script>
<script type="text/javascript" src="js/autocomplete_doctor.js"></script>
<script type="text/javascript" src="js/autosuggestdoctor.js"></script>
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
}
</script>
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
		
		
              <form name="cbform1" method="post" action="doctorpaymentreport.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#CCCCCC" class="bodytext3"><strong>Doctor Payment Report</strong></td>
              </tr>
               <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Doctor </td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
              <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">
              </span></td>
           </tr>
			  <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>	
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>
            </tr>
          </tbody>
        </table>
		</form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
       <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="864" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="3%" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
              <td colspan="10" bgcolor="#cccccc" class="bodytext31">
             
				  </td>  
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
				 <td width="9%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>  Date </strong></td>
              <td width="19%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Doctor</strong></div></td>
				  <td width="11%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Payment Amt</strong></div></td>
                      
				<td width="10%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> WHT Amt </strong></td>
   				  <td width="9%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Net Payable</strong></div></td>
				 <td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Mode</strong></div></td>
				 <td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Cheque No</strong></div></td>
				 <td width="14%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bank</strong></div></td>
				 <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
				<td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Print</strong></div></td>
            </tr>
			
			<?php
			
			if(isset($_REQUEST['cbfrmflag1']))
			{			
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			
			$arraysupplier = explode("#", $searchsuppliername);
			$arraysuppliername = $arraysupplier[0];
			$arraysuppliername = trim($arraysuppliername);
			$arraysuppliercode = $arraysupplier[1];
			
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
			 $docno = $res12['docno'];
			 
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
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#D3EEB7"';
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
			  <td  align="left" valign="center" class="bodytext31"><div align="left"><a href="print_doctorpayment1.php?billnumber=<?php echo $docno; ?>" target="_blank">Print</a></div></td>
			  
           </tr>
			<?php
			}
			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
             
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong>Total:</strong></td>
								<td  align="right" valign="center" 
                bgcolor="#cccccc" class="bodytext31"><strong><?php echo number_format($total1,2,'.',','); ?></strong></td>
				<td  align="right" valign="center" 
                bgcolor="#cccccc" class="bodytext31"><strong><?php echo number_format($total2,2,'.',','); ?></strong></td>
				<td  align="right" valign="center" 
                bgcolor="#cccccc" class="bodytext31"><strong><?php echo number_format($total3,2,'.',','); ?></strong></td>
				 
				 <td colspan="5" align="right" valign="center" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
             
			</tr>
			<?php
			}
			?>
			<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			//$frmflag2 = $_POST['frmflag2'];
			if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
			if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
			
			if($cbfrmflag1 == 'cbfrmflag1')
			{
			$url = "ADate1=$ADate1&&ADate2=$ADate2&&companyanum=$companyanum&&arraysuppliercode=$arraysuppliercode"
			?>
			<tr>
		<td colspan="5" align="left" class="bodytext3"><a href="print_doctorpayment.php?<?php echo $url; ?>"><img src="images/pdfdownload.jpg" height="40" width="40"></a>
		&nbsp;&nbsp;&nbsp;<a href="print_doctorpaymentxl.php?<?php echo $url; ?>"><img src="images/excel-xls-icon.png" height="40" width="40"></a></td>
		</tr>
			<?php
			}
			?>
          </tbody>
        </table></td>
      </tr>
	  
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
