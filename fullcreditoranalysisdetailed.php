<?php
session_start();
error_reporting(0);
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
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
$searchsuppliername1 = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$range = "";
$totalamount = "0.00";
$totalamount30 = "0.00";
$total60 = "0.00";
$total90 = "0.00";
$total120 = "0.00";
$total180 = "0.00";
$total210 = "0.00";
$totalamount1 = "0.00";
$totalamount301 = "0.00";
$totalamount601 = "0.00";
$totalamount901 = "0.00";
$totalamount1201 = "0.00";
$totalamount1801 = "0.00";
$totalamount2101 = "0.00";
$totalamount2401 = "0.00";
//This include updatation takes too long to load for hunge items database.
//include("autocompletebuild_subtype.php");

//include ("autocompletebuild_account3.php");


if (isset($_REQUEST["searchsuppliername1"])) { $searchsuppliername1 = $_REQUEST["searchsuppliername1"]; } else { $searchsuppliername1 = ""; }

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = $transactiondatefrom; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = $transactiondateto; }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

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
<!--<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />-->
<!--<script type="text/javascript" src="js/adddate.js"></script>-->
<!--<script type="text/javascript" src="js/adddate2.js"></script>-->
<!--<script type="text/javascript" src="js/autocomplete_subtype.js"></script>
<script type="text/javascript" src="js/autosuggestsubtype.js"></script>

<script type="text/javascript" src="js/autocomplete_accounts3.js"></script>
<script type="text/javascript" src="js/autosuggest5accounts.js"></script>
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl1(document.getElementById("searchsuppliername1"), new StateSuggestions1());
	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
}


</script>-->
<script type="text/javascript" src="js/autocomplete_supplier12.js"></script>
<script type="text/javascript" src="js/autosuggest2supplier1.js"></script>
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

<script src="js/datetimepicker_css.js"></script>
<script language="javascript">
</script>

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
		
		
              <form  method="post" action="fullcreditoranalysisdetailed.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#CCCCCC" class="bodytext3"><strong>Full Creditor Analysis Detailed</strong></td>
              </tr>
            <!--<tr>
              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
			  <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Payment Entry" /> 
                *To Print Other Receipts Please Go To Menu:	Reports	-&gt; Payments Given 
				</td>
              </tr>-->
			  <!-- <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Subtype </td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
              <input name="searchsuppliername1" type="text" id="searchsuppliername1" value="<?php echo $searchsuppliername1; ?>" size="50" autocomplete="off">
              <input name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox" type="hidden" value="">
			  <input name="searchsubtypeanum1" id="searchsubtypeanum1" value="" type="hidden">
			  </span></td>
           </tr>-->
		 
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Supplier </td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
              <input name="searchsuppliername" type="text" id="searchsuppliername"  value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">
              <input name="searchsuppliernamehiddentextbox" id="searchsuppliernamehiddentextbox" value="" type="hidden">
			  <input name="searchaccountnameanum1" id="searchaccountnameanum1" value="" type="hidden">
			  </span></td>
           </tr>
		   
			  <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $ADate1; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $ADate2; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>	
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input type="submit" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="4%" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
              <td colspan="11" bgcolor="#cccccc" class="bodytext31"><span class="bodytext311">
              <?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					if (isset($_REQUEST["cbcustomername"])) { $cbcustomername = $_REQUEST["cbcustomername"]; } else { $cbcustomername = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["customername"])) { $customername = $_REQUEST["customername"]; } else { $customername = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
					if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
					//$transactiondatefrom = $_REQUEST['ADate1'];
					//$transactiondateto = $_REQUEST['ADate2'];
					
					//$paymenttype = $_REQUEST['paymenttype'];
					//$billstatus = $_REQUEST['billstatus'];
					
					$urlpath = "ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";
				}
				else
				{
					$urlpath = "ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";
				}
				?>
 				<?php
				//For excel file creation.
				
				$applocation1 = $applocation1; //Value from db_connect.php file giving application path.
				$filename1 = "print_paymentgivenreport1.php?$urlpath";
				$fileurl = $applocation1."/".$filename1;
				$filecontent1 = @file_get_contents($fileurl);
				
				$indiatimecheck = date('d-M-Y-H-i-s');
				$foldername = "dbexcelfiles";
				$fp = fopen($foldername.'/PaymentGivenToSupplier.xls', 'w+');
				fwrite($fp, $filecontent1);
				fclose($fp);

				?>
              <script language="javascript">
				function printbillreport1()
				{
					window.open("print_paymentgivenreport1.php?<?php echo $urlpath; ?>","Window1",'width=900,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
					//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
				}
				function printbillreport2()
				{
					window.location = "dbexcelfiles/PaymentGivenToSupplier.xls"
				}
				</script>
              <!--<input  value="Print Report" onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" />
&nbsp;				<input  value="Export Excel" onClick="javascript:printbillreport2()" name="resetbutton22" type="button" id="resetbutton22"  style="border: 1px solid #001E6A" />-->
</span></td>  
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td width="22%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Supplier Name</strong></div></td>
				<td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Bill No</strong></div></td>
             <!-- <td width="22%" align="left" valign="right"  
                bgcolor="#ffffff" class="bodytext31"><strong> Patient </strong></td>-->
              <td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Bill Date </strong></td>
              <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Org. Bill </strong></div></td>
				<td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Bal. Amt</strong></div></td>
				<td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>30 days</strong></div></td>
              <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>60 days </strong></div></td>
				<td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>90 days </strong></div></td>
			<td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>120 days </strong></div></td>
				<td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>180 days </strong></div></td>
				<td width="7%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>180+ days </strong></div></td>
			  </tr>
			<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			
			$arraysupplier = explode(" #", $searchsuppliername);
			$arraysuppliername = $arraysupplier[0];
			$searchsuppliername = trim($arraysuppliername);
			$arraysuppliercode = $arraysupplier[1];
			
			$searchsuppliername = trim($searchsuppliername);
			$query212 = "select * from master_transactionpharmacy where suppliername like '%$searchsuppliername%' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'PURCHASE' group by suppliername order by suppliername desc ";
			$exec212 = mysql_query($query212) or die ("Error in Query21".mysql_error());
			while ($res212 = mysql_fetch_array($exec212))
			{
			$res21suppliername = $res212['suppliername'];
			
			$query222 = "select * from master_accountname where accountname = '$res21suppliername' and recordstatus <>'DELETED' ";
			$exec222 = mysql_query($query222) or die ("Error in Query22".mysql_error());
			$res222 = mysql_fetch_array($exec222);
			$res22accountname = $res222['accountname'];

			
			
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			$searchsuppliername1 = trim($searchsuppliername1);
			$res21suppliername = trim($res21suppliername);
		  
		  $query1 = "select * from master_transactionpharmacy where   suppliername ='$res21suppliername' and transactiondate between '$ADate1' and '$ADate2' group by billnumber order by suppliername";
		  $exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		  $num1 = mysql_num_rows($exec1);
		 
		  if( $res21suppliername != '' && $num1>0)
			{
			?>
			<tr bgcolor="#cccccc">
            <td colspan="12"  align="left" valign="center" bgcolor="#cccccc" class="bodytext31"><strong><?php echo $res22accountname;?> (Date From: <?php echo $ADate1; ?> Date To: <?php echo $ADate2;?>)</strong></td>
            </tr> 
			
			<?php
			
		  while($res1 = mysql_fetch_array($exec1))
		  {
		  $res1suppliername = $res1['suppliername'];
		  $res1suppliercode = $res1['suppliercode'];
		  $res1transactiondate  = $res1['transactiondate'];
		  $res1billnumber = $res1['billnumber'];
		  /*$res1patientname = $res1['patientname'];
		  $res1visitcode = $res1['visitcode'];*/
		  
		  $query2 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and suppliername = '$res1suppliername' and billnumber = '$res1billnumber' and transactiontype = 'PURCHASE'";
		  $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		  $res2 = mysql_fetch_array($exec2);
		  $res2transactionamount = $res2['transactionamount1'];
		  
		  $query3 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and suppliername = '$res1suppliername' and billnumber = '$res1billnumber'  and transactionmodule = 'PAYMENT' and recordstatus = 'allocated'";
		  $exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
		  $res3 = mysql_fetch_array($exec3);
		  $res3transactionamount = $res3['transactionamount1'];
		  
	
		  $invoicevalue =  $res2transactionamount - $res3transactionamount/* + $res4transactionamount + $res5transactionamount*/;
		  if($invoicevalue>0)
		  {
		  $date1 = 30;
		  $date2 = date('Y-m-d',strtotime($ADate2) - (24*3600*$date1)); 
		  
		  $query8 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and suppliername = '$res1suppliername' and billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$date2' and '$ADate2' ";
		  $exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
		  $res8 = mysql_fetch_array($exec8);
		  $res8transactionamount = $res8['transactionamount1'];
	      
		  $query9 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and suppliername = '$res1suppliername' and billnumber = '$res1billnumber' and transactionmodule = 'PAYMENT'  and transactiondate between '$date2' and '$ADate2' and recordstatus = 'allocated'";
		  $exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		  $res9 = mysql_fetch_array($exec9);
		  $res9transactionamount = $res9['transactionamount1'];
		  
		
		  
		  $totalamount30 = $res8transactionamount - $res9transactionamount/* + $res10transactionamount + $res12transactionamount*/;
		  
		  $t1 = strtotime("$res1transactiondate");
		  $t2 = strtotime("$ADate2");
		  $days_between = ceil(abs($t2 - $t1) / 86400);
		  
		  if($days_between>30 && $days_between<=60)
		  {
		  $date3 = 60;
		  $date4 = date('Y-m-d',strtotime($ADate2) - (24*3600*$date3)); 
		  
		   $query13 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and suppliername = '$res1suppliername' and billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$date4' and '$ADate2' ";
		  $exec13 = mysql_query($query13) or die ("Error in Query13".mysql_error());
		  $res13 = mysql_fetch_array($exec13);
		  $res13transactionamount = $res13['transactionamount1'];
	      
		  $query14 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and suppliername = '$res1suppliername' and billnumber = '$res1billnumber' and transactionmodule = 'PAYMENT' and transactiondate between '$date4' and '$ADate2' and recordstatus = 'allocated'";
		  $exec14 = mysql_query($query14) or die ("Error in Query14".mysql_error());
		  $res14 = mysql_fetch_array($exec14);
		  $res14transactionamount = $res14['transactionamount1'];
		  
	
		  
		  $totalamount60 = $res13transactionamount - $res14transactionamount/* + $res15transactionamount + $res16transactionamount*/;
		  
		  $total60 = $totalamount60 - $totalamount30;
		  }
		  
		  if($days_between>60 && $days_between<=90)
		  {
		  $date5 = 90;
		  $date6 = date('Y-m-d',strtotime($ADate2) - (24*3600*$date5));
		  
		  $query17 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and suppliername = '$res1suppliername' and billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$date6' and '$ADate2' ";
		  $exec17 = mysql_query($query17) or die ("Error in Query17".mysql_error());
		  $res17 = mysql_fetch_array($exec17);
		  $res17transactionamount = $res17['transactionamount1'];
	      
		  $query18 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and suppliername = '$res1suppliername' and billnumber = '$res1billnumber'  and transactionmodule = 'PAYMENT' and transactiondate between '$date6' and '$ADate2' and recordstatus = 'allocated'";
		  $exec18 = mysql_query($query18) or die ("Error in Query18".mysql_error());
		  $res18 = mysql_fetch_array($exec18);
		  $res18transactionamount = $res18['transactionamount1'];
		  
		
		  
		  $totalamount90 = $res17transactionamount - $res18transactionamount/* + $res19transactionamount + $res20transactionamount*/;
		  
		  $total90 = $totalamount90 - $totalamount60;
		  }
		  
		  if($days_between>90 && $days_between<=120)
		  {
		  $date7 = 120;
		  $date8 = date('Y-m-d',strtotime($ADate2) - (24*3600*$date7));
		  
		  $query21 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and suppliername = '$res1suppliername' and billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$date8' and '$ADate2' ";
		  $exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
		  $res21 = mysql_fetch_array($exec21);
		  $res21transactionamount = $res21['transactionamount1'];
	      
		  $query22 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and suppliername = '$res1suppliername' and billnumber = '$res1billnumber'  and transactionmodule = 'PAYMENT' and transactiondate between '$date8' and '$ADate2' and recordstatus = 'allocated'";
		  $exec22 = mysql_query($query22) or die ("Error in Query22".mysql_error());
		  $res22 = mysql_fetch_array($exec22);
		  $res22transactionamount = $res22['transactionamount1'];
		  
		
		  
		  $totalamount120 = $res21transactionamount-$res22transactionamount/* + $res23transactionamount + $res24transactionamount*/;
		  
		  $total120 = $totalamount120 - $totalamount90;
		  }
		  
		  if($days_between>120 && $days_between<=180)
		  {
		  $date9 = 180;
		   $date10 = date('Y-m-d',strtotime($ADate2) - (24*3600*$date9));
		  
	 	  $query25 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and suppliername = '$res1suppliername' and billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$date10' and '$ADate2' ";
		  $exec25 = mysql_query($query25) or die ("Error in Query25".mysql_error());
		  $res25 = mysql_fetch_array($exec25);
		  $res25transactionamount = $res25['transactionamount1'];
	      
		  $query26 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and suppliername = '$res1suppliername' and billnumber = '$res1billnumber'  and transactionmodule = 'PAYMENT' and transactiondate between '$date10' and '$ADate2' and recordstatus = 'allocated'";
		  $exec26 = mysql_query($query26) or die ("Error in Query26".mysql_error());
		  $res26 = mysql_fetch_array($exec26);
		  $res26transactionamount = $res26['transactionamount1'];
		  
		
		  
		  $totalamount180 = $res25transactionamount - $res26transactionamount/* + $res27transactionamount + $res28transactionamount*/;
		  
		  $total180 = $totalamount180 - $totalamount120;
		  }
		  
		  if($days_between>180 && $days_between<=2100)
		  {
		  $date11 = 2100;
		  $date12 = date('Y-m-d',strtotime($ADate2) - (24*3600*$date11));
		  
		$query29 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and suppliername = '$res1suppliername' and billnumber = '$res1billnumber' and transactiontype = 'PURCHASE' and transactiondate between '$date12' and '$ADate2' ";

		  $exec29 = mysql_query($query29) or die ("Error in Query29".mysql_error());
		  $res29 = mysql_fetch_array($exec29);
		  $res29transactionamount = $res29['transactionamount1'];
	      
		  $query30 = "select sum(transactionamount) as transactionamount1 from master_transactionpharmacy where suppliercode = '$res1suppliercode' and suppliername = '$res1suppliername' and billnumber = '$res1billnumber'  and transactionmodule = 'PAYMENT' and transactiondate between '$date12' and '$ADate2' and recordstatus = 'allocated'";
		
		  $exec30 = mysql_query($query30) or die ("Error in Query30".mysql_error());
		  $res30 = mysql_fetch_array($exec30);
		  $res30transactionamount = $res30['transactionamount1'];
		  
	
		  
	//  echo '<br>'.$res29transactionamount.'-'.$res30transactionamount;
		  $totalamount210 = $res29transactionamount - $res30transactionamount/* + $res31transactionamount + $res32transactionamount*/;
		  
		  $total210 = $totalamount210 - $totalamount180;
		  }
		  if($res2transactionamount !=''){
		  $snocount = $snocount + 1;
			
			//echo $cashamount;
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
                <div class="bodytext31"><?php echo $res21suppliername; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res1billnumber; ?></div></td>
              <!--<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res21suppliername; ?></div></td>-->
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $res1transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($res2transactionamount,2,'.',','); ?></div></td>
               <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($invoicevalue,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($totalamount30,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($total60,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($total90,2,'.',','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($total120,2,'.',','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($total180,2,'.',','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($total210,2,'.',','); ?></div></td>
           </tr>
			<?php
			}
			$totalamount1 = $totalamount1 + $res2transactionamount;
			$totalamount301 = $totalamount301 + $invoicevalue;
			$totalamount601 = $totalamount601 + $totalamount30;
			$totalamount901 = $totalamount901 + $total60;
			$totalamount1201 = $totalamount1201 + $total90;
			$totalamount1801 = $totalamount1801 + $total120;
			$totalamount2101 = $totalamount2101 + $total180;
			$totalamount2401 = $totalamount2401 + $total210;
			
			$res2transactionamount='';
			$invoicevalue='0.00';
			$totalamount30='0.00';
			$total60='0.00';
			$total90='0.00';
			$total120='0.00';
			$total180='0.00';
			$total210='0.00';
			
			$totalamount210='';
			$totalamount180='';
			$totalamount120='';
			$totalamount90='';
			$totalamount60='';
			$totalamount30='';
			}
		  }
			}
			}
			}
			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              
				<td class="bodytext31" valign="center"  align="center" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="center" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc"><strong>Total:</strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totalamount1,2,'.',','); ?></strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totalamount301,2,'.',','); ?></strong></td>
				 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totalamount601,2,'.',','); ?></strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totalamount901,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totalamount1201,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totalamount1801,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totalamount2101,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totalamount2401,2,'.',','); ?></strong></td>        
            </tr>
			<tr>
			<?php
			
				$urlpath = "cbfrmflag1=cbfrmflag1&&ADate1=$ADate1&&ADate2=$ADate2&&searchsuppliername=$searchsuppliername&&searchsuppliername1=$searchsuppliername1";
			
			?>
			 <td colspan="12"></td>
		   	 <td class="bodytext31" valign="center"  align="right"><a href="print_fullcreditoranalysisdetailed.php?<?php echo $urlpath; ?>"><img  width="40" height="40" src="images/excel-xls-icon.png" style="cursor:pointer;"></a></td>
			</tr>    
          </tbody>
        </table></td>
      </tr>
	  
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
