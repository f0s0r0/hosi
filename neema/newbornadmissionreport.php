<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d');
$paymentreceiveddateto = date('Y-m-d');

$colorloopcount = '';
$sno = '';
$snocount = '';
$visitcode1 = '';
$total = '0.00';

if (isset($_REQUEST["accountname"])) { $accountname = $_REQUEST["accountname"]; } else { $accountname = ""; }

if (isset($_REQUEST["department"])) { $department = $_REQUEST["department"]; } else { $department = ""; }
//echo $department;
$query111 = "select * from master_department where auto_number = '$department'";
$exec111 = mysql_query($query111) or die ("Error in query111".mysql_error());
$res111 = mysql_fetch_array($exec111);
$res111department = $res111['department'];

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select * from master_supplier where auto_number = '$getcanum'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	$res4 = mysql_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	//$cbsuppliername = $_REQUEST['cbsuppliername'];
	//$suppliername = $_REQUEST['cbsuppliername'];
	$paymentreceiveddatefrom = $_REQUEST['ADate1'];
	$paymentreceiveddateto = $_REQUEST['ADate2'];
	$visitcode1 = 10;

}

if (isset($_REQUEST["task"])) { $task = $_REQUEST["task"]; } else { $task = ""; }
//$task = $_REQUEST['task'];
if ($task == 'deleted')
{
	$errmsg = 'Payment Entry Delete Completed.';
}

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//$paymenttype = $_REQUEST['paymenttype']; 
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//$billstatus = $_REQUEST['billstatus'];
if ($ADate1 != '' && $ADate2 != '')
{
	$transactiondatefrom = $_REQUEST['ADate1'];
	$transactiondateto = $_REQUEST['ADate2'];
}
else
{
	$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
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
<script language="javascript">

function cbsuppliername1()
{
	document.cbform1.submit();
}

</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>
<script language="javascript">

function funcPrintReceipt1(varRecAnum)
{
	var varRecAnum = varRecAnum
	//alert (varRecAnum);
	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php //echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	window.open("print_payment_receipt1.php?receiptanum="+varRecAnum+"","OriginalWindow<?php //echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}

function funcDeletePayment1(varPaymentSerialNumber)
{
	var varPaymentSerialNumber = varPaymentSerialNumber;
	var fRet;
	fRet = confirm('Are you sure want to delete this payment entry serial number '+varPaymentSerialNumber+'?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("Payment Entry Delete Completed.");
		//return false;
	}
	if (fRet == false)
	{
		alert ("Payment Entry Delete Not Completed.");
		return false;
	}
	//return false;
}

</script>
</head>

<script src="js/datetimepicker_css.js"></script>

<body>
<table width="1900" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="newbornadmissionreport.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr bgcolor="#011E6A">
                      <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>New Born Admission Report</strong></td>
                      <!--<td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                      <td bgcolor="#CCCCCC" class="bodytext3" colspan="2">&nbsp;</td>
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
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
					  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input  type="submit" value="Search" name="Submit" />
                          <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
                    </tr>
                  </tbody>
                </table>
              </form>		</td>
      </tr>
<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
		    if ($cbfrmflag1 == 'cbfrmflag1')
			{

?>      
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4"  width="966"
            align="left" border="0">
          <tbody>
            <tr>
              <td colspan="8" align="left" valign="center" 
                bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
            </tr>
            <tr>
              <td width="33"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
              <td width="80" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Entry Date</strong></div></td>
              <td width="188" valign="right"  
                bgcolor="#ffffff" align="left" class="bodytext31"><strong> Patient Name </strong></td>
              <td width="84"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Patient Code</strong></td>
              <td width="109"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Visit Code</strong></td>
              <td width="219" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Mother Name</strong></div></td>
              <td width="80" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Mother Code</strong></td>
              <td width="109" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Mother Visit Code</strong></td>
            </tr>
			
			<?php
			
			$s='';
			
		   $query2 = "select * from newborn_motherdetails where entrydate between '$ADate1' and '$ADate2'";
		  $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		  while ($res2 = mysql_fetch_array($exec2))
		  {
     	  $patientname = $res2['patientname'];
     	  $patientcode = $res2['patientcode'];
     	  $patientvisitcode = $res2['patientvisitcode'];
     	  $mothername = $res2['mothername'];
     	  $mothercode = $res2['mothercode'];
     	  $mothervisitcode = $res2['mothervisitcode'];
     	  $entrydate = $res2['entrydate'];
		  
		  	 $s = $s + 1;
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
           <tr  <?php echo $colorcode; ?> >
              <td class="bodytext31" width="33" valign="center"  align="left"><?php echo $s; ?></td>
              <td class="bodytext31" width="80" valign="center"  align="left">
                <div class="bodytext31"><?php echo $entrydate; ?></div></td>
               <td class="bodytext31" width="188" valign="center"  align="left">
                <div class="bodytext31"><?php echo $patientname; ?></div></td>
              <td class="bodytext31" width="84" valign="center"  align="left">
                <div class="bodytext31"><?php echo $patientcode; ?></div></td>
               <td class="bodytext31" width="109" valign="center"  align="left">
                <div class="bodytext31"><?php echo $patientvisitcode; ?></div></td>
              <td class="bodytext31" width="219" valign="center"  align="left">
                <div class="bodytext31"><?php echo $mothername; ?></div></td>
              <td class="bodytext31" width="80" valign="center"  align="left">
                <div class="bodytext31"><?php echo $mothercode; ?></div></td>
               <td class="bodytext31" width="109" valign="center"  align="left">
                <div class="bodytext31"><?php echo $mothervisitcode; ?></div></td>
           </tr>
			<?php
			}
			?>
            <tr >
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc" colspan="8">&nbsp;</td>
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

