<?php
session_start();
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
$totalamount = "0.00";
$totalamount30 = "0.00";
$searchsuppliername = "";
$searchsuppliername1 = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$range = "";
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
//This include updatation takes too long to load for hunge items database.
//include("autocompletebuild_subtype.php");

//include ("autocompletebuild_account3.php");


if (isset($_REQUEST["searchsuppliername1"])) { $searchsuppliername1 = $_REQUEST["searchsuppliername1"]; } else { $searchsuppliername1 = ""; }

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
<script type="text/javascript" src="js/autocomplete_subtype.js"></script>
<script type="text/javascript" src="js/autosuggestsubtype.js"></script>

<script type="text/javascript" src="js/autocomplete_accounts3.js"></script>
<script type="text/javascript" src="js/autosuggest5accounts.js"></script>
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl1(document.getElementById("searchsuppliername1"), new StateSuggestions1());
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
<script>
function viewReport()
 {
window.open("<?php echo basename($_SERVER['PHP_SELF']); ?>","OriginalWindowA4",'width=922,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
  }
</script>
<script src="js/datetimepicker_css.js"></script>
<script language="javascript">
</script>

<body>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="fulldebtoranalysissummaryuser.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#CCCCCC" class="bodytext3"><strong>Full Debtor Analysis Summary</strong>&nbsp;&nbsp;&nbsp;<a href="#" onClick="viewReport();"><strong>W</strong></a></td>
              </tr>
            <!--<tr>
              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
			  <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Payment Entry" /> 
                *To Print Other Receipts Please Go To Menu:	Reports	-&gt; Payments Given 
				</td>
              </tr>-->
			   <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Subtype </td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
              <input name="searchsuppliername1" type="text" id="searchsuppliername1" value="<?php echo $searchsuppliername1; ?>" size="50" autocomplete="off">
              <input name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox" type="hidden" value="">
			  <input name="searchsubtypeanum1" id="searchsubtypeanum1" value="" type="hidden">
			  </span></td>
           </tr>
		 
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Account </td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
              <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">
              <input name="searchsuppliernamehiddentextbox" id="searchsuppliernamehiddentextbox" value="" type="hidden">
			  <input name="searchaccountnameanum1" id="searchaccountnameanum1" value="" type="hidden">
			  </span></td>
           </tr>
		   
			  <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1000" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="7%" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
              <td colspan="14" bgcolor="#cccccc" class="bodytext31"><span class="bodytext311">
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
              <td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account</strong></div></td>
              <td width="16%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Total Amount </strong></td>
              <td width="11%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> 30 days </strong></td>
              <td width="11%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>60 days </strong></div></td>
				<td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>90 days</strong></div></td>
				<td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>120 days</strong></div></td>
              <td width="9%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>180 days </strong></div></td>
				<td width="11%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>180+ days </strong></div></td>
            </tr>
			
			<?php
			
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
				
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			$searchsuppliername1 = trim($searchsuppliername1);
		 
		
		  $query1 = "select * from master_transactionpaylater where subtype like '%$searchsuppliername1%' and accountname like '%$searchsuppliername%' and transactiontype = 'finalize'  group by accountname";
		  $exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		  while($res1 = mysql_fetch_array($exec1))
		  {
		  $res1accountname = $res1['accountname'];
		  $res1subtype = $res1['subtype'];
		  $res1transactiondate  = $res1['transactiondate'];
		  
		  $t1 = strtotime("$ADate1");
		  $t2 = strtotime("$ADate2");
		  $days_between = ceil(abs($t2 - $t1) / 86400);
		
		  $query2 = "select sum(transactionamount) as transactionamount2 from master_transactionpaylater where transactiontype = 'finalize' and accountname = '$res1accountname' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		  $res2 = mysql_fetch_array($exec2);
		  $res2transactionamount = $res2['transactionamount2'];
	      
		  $query3 = "select sum(transactionamount) as transactionamount2 from master_transactionpaylater where transactionmodule = 'PAYMENT' and accountname = '$res1accountname' and transactiondate between '$ADate1' and '$ADate2' and recordstatus <> 'deallocated'";
		  $exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
		  $res3 = mysql_fetch_array($exec3);
		  $res3transactionamount = $res3['transactionamount2'];
		  
		  $query5 = "select sum(transactionamount) as transactionamount2 from master_transactionpaylater where transactiontype = 'paylatercredit' and accountname = '$res1accountname' and transactiondate between '$ADate1' and '$ADate2' and recordstatus <> 'deallocated'";
		  $exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
		  $res5 = mysql_fetch_array($exec5);
		  $res5transactionamount = $res5['transactionamount2'];
	
		  $query7 = "select sum(transactionamount) as transactionamount2 from master_transactionpaylater where transactiontype = 'pharmacycredit' and accountname = '$res1accountname' and transactiondate between '$ADate1' and '$ADate2' and recordstatus <> 'deallocated'";
		  $exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
		  $res7 = mysql_fetch_array($exec7);
		  $res7transactionamount = $res7['transactionamount2'];
		  
		  $totalamount = $res2transactionamount - $res3transactionamount - $res5transactionamount - $res7transactionamount;
		  
		  $date1 = 30;
		  $date2 = date('Y-m-d',strtotime($ADate2) - (24*3600*$date1)); 
		  
		  $query8 = "select sum(transactionamount) as transactionamount2 from master_transactionpaylater where transactiontype = 'finalize' and accountname = '$res1accountname' and transactiondate between '$date2' and '$ADate2'";
		  $exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
		  $res8 = mysql_fetch_array($exec8);
		  $res8transactionamount = $res8['transactionamount2'];
	      
		  $query9 = "select sum(transactionamount) as transactionamount2 from master_transactionpaylater where transactionmodule = 'PAYMENT' and accountname = '$res1accountname'  and transactiondate between '$date2' and '$ADate2' and recordstatus <> 'deallocated'";
		  $exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		  $res9 = mysql_fetch_array($exec9);
		  $res9transactionamount = $res9['transactionamount2'];
		  
		  $query10 = "select sum(transactionamount) as transactionamount2 from master_transactionpaylater where transactiontype = 'paylatercredit' and accountname = '$res1accountname'  and transactiondate between '$date2' and '$ADate2' and recordstatus <> 'deallocated'";
		  $exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());
		  $res10 = mysql_fetch_array($exec10);
		  $res10transactionamount = $res10['transactionamount2'];
	
		  $query12 = "select sum(transactionamount) as transactionamount2 from master_transactionpaylater where transactiontype = 'pharmacycredit' and accountname = '$res1accountname'  and transactiondate between '$date2' and '$ADate2' and recordstatus <> 'deallocated'";
		  $exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
		  $res12 = mysql_fetch_array($exec12);
		  $res12transactionamount = $res12['transactionamount2'];
		  
		  $totalamount30 = $res8transactionamount - $res9transactionamount - $res10transactionamount - $res12transactionamount;
		  
		  if($days_between>30 && $days_between<=60)
		  {
		  $date3 = 60;
		  $date4 = date('Y-m-d',strtotime($ADate2) - (24*3600*$date3)); 
		  
		  $query13 = "select sum(transactionamount) as transactionamount2 from master_transactionpaylater where transactiontype = 'finalize' and accountname = '$res1accountname' and transactiondate between '$date4' and '$ADate2'";
		  $exec13 = mysql_query($query13) or die ("Error in Query13".mysql_error());
		  $res13 = mysql_fetch_array($exec13);
		  $res13transactionamount = $res13['transactionamount2'];
	      
		  $query14 = "select sum(transactionamount) as transactionamount2 from master_transactionpaylater where transactionmodule = 'PAYMENT' and accountname = '$res1accountname' and transactiondate between '$date4' and '$ADate2' and recordstatus <> 'deallocated'";
		  $exec14 = mysql_query($query14) or die ("Error in Query14".mysql_error());
		  $res14 = mysql_fetch_array($exec14);
		  $res14transactionamount = $res14['transactionamount2'];
		  
		  $query15 = "select sum(transactionamount) as transactionamount2 from master_transactionpaylater where transactiontype = 'paylatercredit' and accountname = '$res1accountname' and transactiondate between '$date4' and '$ADate2' and recordstatus <> 'deallocated'";
		  $exec15 = mysql_query($query15) or die ("Error in Query15".mysql_error());
		  $res15 = mysql_fetch_array($exec15);
		  $res15transactionamount = $res15['transactionamount2'];
	
		  $query16 = "select sum(transactionamount) as transactionamount2 from master_transactionpaylater where transactiontype = 'pharmacycredit' and accountname = '$res1accountname' and transactiondate between '$date4' and '$ADate2' and recordstatus <> 'deallocated'";
		  $exec16 = mysql_query($query16) or die ("Error in Query16".mysql_error());
		  $res16 = mysql_fetch_array($exec16);
		  $res16transactionamount = $res16['transactionamount2'];
		  
		  $totalamount60 = $res13transactionamount - $res14transactionamount - $res15transactionamount - $res16transactionamount;
		  
		  $total60 = $totalamount60 - $totalamount30;
		  }
		 
		  if($days_between>60 && $days_between<=90)
		  {
		  $date5 = 90;
		  $date6 = date('Y-m-d',strtotime($ADate2) - (24*3600*$date5));
		  
		  $query17 = "select sum(transactionamount) as transactionamount2 from master_transactionpaylater where transactiontype = 'finalize' and accountname = '$res1accountname' and transactiondate between '$date6' and '$ADate2'";
		  $exec17 = mysql_query($query17) or die ("Error in Query17".mysql_error());
		  $res17 = mysql_fetch_array($exec17);
		  $res17transactionamount = $res17['transactionamount2'];
	      
		  $query18 = "select sum(transactionamount) as transactionamount2 from master_transactionpaylater where transactionmodule = 'PAYMENT' and accountname = '$res1accountname' and transactiondate between '$date6' and '$ADate2' and recordstatus <> 'deallocated'";
		  $exec18 = mysql_query($query18) or die ("Error in Query18".mysql_error());
		  $res18 = mysql_fetch_array($exec18);
		  $res18transactionamount = $res18['transactionamount2'];
		  
		  $query19 = "select sum(transactionamount) as transactionamount2 from master_transactionpaylater where transactiontype = 'paylatercredit' and accountname = '$res1accountname' and transactiondate between '$date6' and '$ADate2' and recordstatus <> 'deallocated'";
		  $exec19 = mysql_query($query19) or die ("Error in Query19".mysql_error());
		  $res19 = mysql_fetch_array($exec19);
		  $res19transactionamount = $res19['transactionamount2'];
	
		  $query20 = "select sum(transactionamount) as transactionamount2 from master_transactionpaylater where transactiontype = 'pharmacycredit' and accountname = '$res1accountname' and transactiondate between '$date6' and '$ADate2' and recordstatus <> 'deallocated'";
		  $exec20 = mysql_query($query20) or die ("Error in Query20".mysql_error());
		  $res20 = mysql_fetch_array($exec20);
		  $res20transactionamount = $res20['transactionamount2'];
		  
		  $totalamount90 = $res17transactionamount - $res18transactionamount - $res19transactionamount - $res20transactionamount;
		  
		  $total90 = $totalamount90 - $totalamount60;
		  }
		  
		  if($days_between>90 && $days_between<=120)
		  {
		  $date7 = 120;
		  $date8 = date('Y-m-d',strtotime($ADate2) - (24*3600*$date7));
		  
		  $query21 = "select sum(transactionamount) as transactionamount2 from master_transactionpaylater where transactiontype = 'finalize' and accountname = '$res1accountname' and transactiondate between '$date8' and '$ADate2' ";
		  $exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
		  $res21 = mysql_fetch_array($exec21);
		  $res21transactionamount = $res21['transactionamount2'];
	      
		  $query22 = "select sum(transactionamount) as transactionamount2 from master_transactionpaylater where transactionmodule = 'PAYMENT' and accountname = '$res1accountname' and transactiondate between '$date8' and '$ADate2' and recordstatus <> 'deallocated'";
		  $exec22 = mysql_query($query22) or die ("Error in Query22".mysql_error());
		  $res22 = mysql_fetch_array($exec22);
		  $res22transactionamount = $res22['transactionamount2'];
		  
		  $query23 = "select sum(transactionamount) as transactionamount2 from master_transactionpaylater where transactiontype = 'paylatercredit' and accountname = '$res1accountname' and transactiondate between '$date8' and '$ADate2' and recordstatus <> 'deallocated'";
		  $exec23 = mysql_query($query23) or die ("Error in Query23".mysql_error());
		  $res23 = mysql_fetch_array($exec23);
		  $res23transactionamount = $res23['transactionamount2'];
	
		  $query24 = "select sum(transactionamount) as transactionamount2 from master_transactionpaylater where transactiontype = 'pharmacycredit' and accountname = '$res1accountname' and transactiondate between '$date8' and '$ADate2' and recordstatus <> 'deallocated'";
		  $exec24 = mysql_query($query24) or die ("Error in Query24".mysql_error());
		  $res24 = mysql_fetch_array($exec24);
		  $res24transactionamount = $res24['transactionamount2'];
		  
		  $totalamount120 = $res21transactionamount - $res22transactionamount - $res23transactionamount - $res24transactionamount;
		  
		  $total120 = $totalamount120 - $totalamount90;
		  }
		  
		  if($days_between>120 && $days_between<=180)
		  {
		  $date9 = 180;
		  $date10 = date('Y-m-d',strtotime($ADate2) - (24*3600*$date9));
		  
		  $query25 = "select sum(transactionamount) as transactionamount2 from master_transactionpaylater where transactiontype = 'finalize' and accountname = '$res1accountname' and transactiondate between '$date10' and '$ADate2' ";
		  $exec25 = mysql_query($query25) or die ("Error in Query25".mysql_error());
		  $res25 = mysql_fetch_array($exec25);
		  $res25transactionamount = $res25['transactionamount2'];
	      
		  $query26 = "select sum(transactionamount) as transactionamount2 from master_transactionpaylater where transactionmodule = 'PAYMENT' and accountname = '$res1accountname' and transactiondate between '$date10' and '$ADate2' and recordstatus <> 'deallocated'";
		  $exec26 = mysql_query($query26) or die ("Error in Query26".mysql_error());
		  $res26 = mysql_fetch_array($exec26);
		  $res26transactionamount = $res26['transactionamount2'];
		  
		  $query27 = "select sum(transactionamount) as transactionamount2 from master_transactionpaylater where transactiontype = 'paylatercredit' and accountname = '$res1accountname' and transactiondate between '$date10' and '$ADate2' and recordstatus <> 'deallocated'";
		  $exec27 = mysql_query($query27) or die ("Error in Query27".mysql_error());
		  $res27 = mysql_fetch_array($exec27);
		  $res27transactionamount = $res27['transactionamount2'];
	
		  $query28 = "select sum(transactionamount) as transactionamount2 from master_transactionpaylater where transactiontype = 'pharmacycredit' and accountname = '$res1accountname' and transactiondate between '$date10' and '$ADate2' and recordstatus <> 'deallocated'";
		  $exec28 = mysql_query($query28) or die ("Error in Query28".mysql_error());
		  $res28 = mysql_fetch_array($exec28);
		  $res28transactionamount = $res28['transactionamount2'];
		  
		  $totalamount180 = $res25transactionamount - $res26transactionamount - $res27transactionamount - $res28transactionamount;
		  
		  $total180 = $totalamount180 - $totalamount120;
		  }
		  
		  if($days_between>180 && $days_between<=210)
		  {
		  $date11 = 210;
		  $date12 = date('Y-m-d',strtotime($ADate2) - (24*3600*$date9));
		  
		  $query29 = "select sum(transactionamount) as transactionamount2 from master_transactionpaylater where transactiontype = 'finalize' and accountname = '$res1accountname' and transactiondate between '$date12' and '$ADate2' ";
		  $exec29 = mysql_query($query29) or die ("Error in Query29".mysql_error());
		  $res29 = mysql_fetch_array($exec29);
		  $res29transactionamount = $res29['transactionamount2'];
	      
		  $query30 = "select sum(transactionamount) as transactionamount2 from master_transactionpaylater where transactionmodule = 'PAYMENT' and accountname = '$res1accountname' and transactiondate between '$date12' and '$ADate2' and recordstatus <> 'deallocated'";
		  $exec30 = mysql_query($query30) or die ("Error in Query30".mysql_error());
		  $res30 = mysql_fetch_array($exec30);
		  $res30transactionamount = $res30['transactionamount2'];
		  
		  $query31 = "select sum(transactionamount) as transactionamount2 from master_transactionpaylater where transactiontype = 'paylatercredit' and accountname = '$res1accountname' and transactiondate between '$date12' and '$ADate2' and recordstatus <> 'deallocated'";
		  $exec31 = mysql_query($query31) or die ("Error in Query31".mysql_error());
		  $res31 = mysql_fetch_array($exec31);
		  $res31transactionamount = $res31['transactionamount2'];
	
		  $query32 = "select sum(transactionamount) as transactionamount2 from master_transactionpaylater where transactiontype = 'pharmacycredit' and accountname = '$res1accountname' and transactiondate between '$date12' and '$ADate2' and recordstatus <> 'deallocated'";
		  $exec32 = mysql_query($query32) or die ("Error in Query32".mysql_error());
		  $res32 = mysql_fetch_array($exec32);
		  $res32transactionamount = $res32['transactionamount2'];
		  
		  $totalamount210 = $res29transactionamount - $res30transactionamount - $res31transactionamount - $res32transactionamount;
		  
		  $total210 = $totalamount210 - $totalamount180;
		  }
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
                <div class="bodytext31"><?php echo $res1accountname; ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($totalamount,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($totalamount30,2,'.',','); ?></td>
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
			
			$totalamount1 = $totalamount1 + $totalamount;
			$totalamount301 = $totalamount301 + $totalamount30;
			$totalamount601 = $totalamount601 + $total60;
			$totalamount901 = $totalamount901 + $total90;
			$totalamount1201 = $totalamount1201 + $total120;
			$totalamount1801 = $totalamount1801 + $total180;
			$totalamount2101 = $totalamount2101 + $total210;
			}
			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="center" 
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
            </tr>
			<tr>
			<?php
			
				$urlpath = "cbfrmflag1=cbfrmflag1&&ADate1=$ADate1&&ADate2=$ADate2&&searchsuppliername=$searchsuppliername&&searchsuppliername1=$searchsuppliername1";
			
			?>
			 <td colspan="8"></td>
		   	 <td class="bodytext31" valign="center"  align="right"><a href="print_fulldebtoranalysissummary.php?<?php echo $urlpath; ?>"><img  width="40" height="40" src="images/excel-xls-icon.png" style="cursor:pointer;"></a></td>
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
