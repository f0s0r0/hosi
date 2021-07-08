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
$totalamount60 = "0.00";
$totalamount601 = "0.00";
$totalamount90 = "0.00";
$totalamount901 = "0.00";
$totalamount120 = "0.00";
$totalamount1201 = "0.00";
$totalamount180 = "0.00";
$totalamount1801 = "0.00";
$totalamount210 = "0.00";
$totalamount2101 = "0.00";
$totalamount240 = "0.00";
$totalamount2401 = "0.00";
$res21accountnameano='';
$closetotalamount1 = '0';
$closetotalamount301 = '0';
$closetotalamount601 = '0';
$closetotalamount901 = '0';
$closetotalamount1201 = '0';
$closetotalamount1801 = '0';
$closetotalamount2101 = '0';
$closetotalamount2401 = '0';
//This include updatation takes too long to load for hunge items database.
//include("autocompletebuild_subtype.php");

//include ("autocompletebuild_account3.php");


if (isset($_REQUEST["searchsuppliername1"])) { $searchsuppliername1 = $_REQUEST["searchsuppliername1"]; } else { $searchsuppliername1 = ""; }

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }

if (isset($_REQUEST["searchaccountnameanum1"])) {  $searchsuppliercode = $_REQUEST["searchaccountnameanum1"]; } else { $searchsuppliercode = ""; }

if (isset($_REQUEST["searchsubtypeanum1"])) {  $searchsubtypeanum1 = $_REQUEST["searchsubtypeanum1"]; } else { $searchsubtypeanum1 = ""; }


if (isset($_REQUEST["type"])) { $type = $_REQUEST["type"]; } else { $type = ""; }
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

<script src="js/datetimepicker_css.js"></script>
<script>
function validateaccounts()
{
	var supplier=document.getElementById("searchsuppliername1").value;
	var type=document.getElementById("type").value;
	if(supplier=='')
	{
		alert("Please select the sub type");
		document.getElementById("searchsuppliername1").focus();
		return false;
	}
	if(type=='')
	{
		alert("Please select the type");
		document.getElementById("type").focus();
		return false;
	}
}
</script>
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
		
		
              <form name="cbform1" method="post" action="fulldebtoranalysisdetailed.php" onSubmit="return validateaccounts()">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#CCCCCC" class="bodytext3"><strong>Full Debtor Analysis Detailed</strong></td>
              </tr>
            <!--<tr>
              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
			  <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Payment Entry" /> 
                *To Print Other Receipts Please Go To Menu:	Reports	-&gt; Payments Given 
				</td>
              </tr>-->
			   <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Type </td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
              <select name="type" id="type">
			  <option value="">Select</option>
			  <?php
			  $query51 = "select paymenttype from master_paymenttype where recordstatus <> 'deleted'";
			  $exec51 = mysql_query($query51) or die(mysql_error());
			  while($res51 = mysql_fetch_array($exec51))
			  {
			  $paymenttype = $res51['paymenttype'];
			  
			  ?>
			  <option value="<?php echo $paymenttype; ?>"><?php echo $paymenttype; ?></option>
			  <?php
			  }
			  ?>
			  </select>
			  </span></td>
           </tr>
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
              <input name="searchsuppliername" type="text" id="searchsuppliername"  value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">
              <input name="searchsuppliernamehiddentextbox" id="searchsuppliernamehiddentextbox" value="" type="hidden">
			  <input name="searchaccountnameanum1" id="searchaccountnameanum1" value="" type="hidden">
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
 			
              <!--<input  value="Print Report" onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" />
&nbsp;				<input  value="Export Excel" onClick="javascript:printbillreport2()" name="resetbutton22" type="button" id="resetbutton22"  style="border: 1px solid #001E6A" />-->
</span></td>  
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td width="8%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg. No</strong></div></td>
				<td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit Code</strong></div></td>
              <td width="22%" align="left" valign="right"  
                bgcolor="#ffffff" class="bodytext31"><strong> Patient </strong></td>
                <td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Member No </strong></td>
                <td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Bill No </strong></td>
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
			
			if($searchsubtypeanum1!='' && $searchsuppliercode=='')
			{
				$query221 = "select accountname,auto_number,id from master_accountname where subtype='$searchsubtypeanum1'   and recordstatus <>'DELETED' ";
			}
			else if($searchsubtypeanum1!='' && $searchsuppliercode!='')
			{
				 $query221 = "select accountname,auto_number,id from master_accountname where auto_number = '$searchsuppliercode'   and subtype='$searchsubtypeanum1' and recordstatus <>'DELETED' ";
			}
			$exec221 = mysql_query($query221) or die ("Error in Query22".mysql_error());
 			$resnum=mysql_num_rows($exec221); 
			while($res221 = mysql_fetch_array($exec221))
			{
			$res22accountname = $res221['accountname'];
			$res21accountnameano=$res221['auto_number'];
			$res21accountname = $res221['accountname'];
			$res21accountid = $res221['id'];
			
		 	$querydebit1 = "select accountname,subtype,transactiondate,patientcode,patientname,visitcode,billnumber,particulars from master_transactionpaylater where accountnameano='$res21accountnameano' and accountnameid='$res21accountid'";
		
			$execdebit1 = mysql_query($querydebit1) or die ("Error in Querydebit1".mysql_error());
			$numdebit1 = mysql_num_rows($execdebit1);
					
			
			if( $res22accountname != '' && $numdebit1>0)
			{
			?>
			<tr bgcolor="#cccccc">
            <td colspan="15"  align="left" valign="center" bgcolor="#cccccc" class="bodytext31"><strong><?php echo $res22accountname; ?> (Date From: <?php echo $ADate1; ?> Date To: <?php echo $ADate2;?>) </strong></td>
            </tr> 
			
			<?php
			
			$openingbalance='0';
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			
	$totaldebit=0;		
$debit=0;
$credit1=0;
$credit2=0;
$totalpayment=0;
$totalcredit='0';
$resamount=0;
$query2 = "select transactiondate,patientname,visitcode,billnumber,transactionamount,patientcode,particulars,auto_number from master_transactionpaylater where accountnameano = '$res21accountnameano' and transactiondate < '$ADate1'  and transactiontype = 'finalize' order by accountname desc";
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			while ($res2 = mysql_fetch_array($exec2))
{
				$res2transactiondate = $res2['transactiondate'];
				$res2visitcode = $res2['visitcode'];
				$res2billnumber = $res2['billnumber'];
				$res2transactionamount = $res2['transactionamount'];
				$res2patientcode = $res2['patientcode'];
				$anum = $res2['auto_number'];
				
				$totalpayment=0;
				$resamount=0;
				$query98 = "select sum(transactionamount) as transactionamount1 from master_transactionpaylater where visitcode='$res2visitcode' and transactiontype = 'PAYMENT' and billnumber='$res2billnumber' and recordstatus = 'allocated'";
				$exec98 = mysql_query($query98) or die(mysql_error());
				$num98 = mysql_num_rows($exec98);
				while($res98 = mysql_fetch_array($exec98))
				{
				$payment = $res98['transactionamount1'];
				$totalpayment = $totalpayment + $payment;
				}
				
				$res7sumtransactionamount=0;
				$query7 = "select sum(transactionamount) as sumtransactionamount from master_transactionpaylater where accountnameano = '$res21accountnameano' and auto_number > '$anum' and transactiontype = 'pharmacycredit' and patientcode='$res2patientcode' and visitcode='$res2visitcode' order by transactiondate desc";
				$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
				//echo $num = mysql_num_rows($exec3);
				while ($res7 = mysql_fetch_array($exec7))
				{
					$res7sumtransactionamount += $res7['sumtransactionamount'];
				}
				
				$res8sumtransactionamount=0;
				$query8 = "select sum(transactionamount) as sumtransactionamount from master_transactionpaylater where accountnameano = '$res21accountnameano' and transactiondate > '$res2transactiondate' and transactiontype = 'paylatercredit' and patientcode='$res2patientcode' and visitcode='$res2visitcode' order by transactiondate desc";
				$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
				//echo $num = mysql_num_rows($exec3);
				while ($res8 = mysql_fetch_array($exec8))
				{
					$res8sumtransactionamount += $res8['sumtransactionamount'];
				}
				
				
				$res2transactionamount = $res2transactionamount-$res7sumtransactionamount-$res8sumtransactionamount;
				$resamount = $res2transactionamount - $totalpayment;
			
				$credit1=0;
				$query5 = "select visitcode,docno,transactionamount from master_transactionpaylater where accountnameano = '$res21accountnameano' and auto_number > '$anum' and transactiontype = 'pharmacycredit' and patientcode='$res2patientcode' and visitcode='$res2visitcode' order by transactiondate desc";
				$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
				//echo $num = mysql_num_rows($exec3);
				while ($res5 = mysql_fetch_array($exec5))
				{
					$totalpharmacreditpayment = 0;
					
					$res5visitcode = $res5['visitcode'];
					$res5docno = $res5['docno'];
					$res5transactionamount = $res5['transactionamount'];
					
					$totalpharmacreditpayment=0;
					$query77 = "select sum(transactionamount) as pharmamount from master_transactionpaylater where docno='$res5docno' and transactiontype <> 'pharmacycredit' and recordstatus = 'allocated'";
					$exec77 = mysql_query($query77) or die(mysql_error());
					while($res77 = mysql_fetch_array($exec77))
					{
					$pharmacreditpayment = $res77['pharmamount'];
					
					$totalpharmacreditpayment = $totalpharmacreditpayment + $pharmacreditpayment;
					}
					
					$respharmacreditpayment = $res5transactionamount - $totalpharmacreditpayment;
					
				$credit1 +=$respharmacreditpayment;
				}
				
				$credit2=0;
				$query6 = "select visitcode,transactionamount,docno from master_transactionpaylater where accountnameano = '$res21accountnameano' and transactiondate>'$res2transactiondate' and transactiontype = 'paylatercredit' and patientcode='$res2patientcode' and visitcode='$res2visitcode' order by transactiondate desc";
				$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
				//echo $num = mysql_num_rows($exec3);
				while ($res6 = mysql_fetch_array($exec6))
				{
					$totalpaylatercreditpayment = 0;
					$res6visitcode = $res6['visitcode'];
					$res6transactionamount = $res6['transactionamount'];
					$res6docno = $res6['docno'];
					
					$totalpaylatercreditpayment=0;
					$query47 = "select sum(transactionamount) as transactionamount1 from master_transactionpaylater where docno='$res6docno' and transactiontype <> 'paylatercredit' and recordstatus = 'allocated'"; //visitcode='$res6visitcode' and 
					$exec47 = mysql_query($query47) or die(mysql_error());
					while($res47 = mysql_fetch_array($exec47))
					{
						$paylatercreditpayment = $res47['transactionamount1'];					
						$totalpaylatercreditpayment = $totalpaylatercreditpayment + $paylatercreditpayment;
					}
					
					$respaylatercreditpayment = $res6transactionamount - $totalpaylatercreditpayment;
					$credit2 +=$respaylatercreditpayment;
				}
				
				$totaldebit +=$resamount -$credit1-$credit2;		
}
$credit3='0';
$query3 = "select docno,transactionamount from master_transactionpaylater where accountnameano = '$res21accountnameano' and transactiondate < '$ADate1' and transactionstatus in ( 'onaccount','paylatercredit') order by accountname desc";
			$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
			// echo $num3 = mysql_num_rows($exec3);
			while ($res3 = mysql_fetch_array($exec3))
			{
				$res3transactionamount = $res3['transactionamount'];
				$res3docno = $res3['docno'];
			 	
				$totalonaccountpayment = 0;
			 	$query67 = "select sum(transactionamount) as transactionamount1 from master_transactionpaylater where docno='$res3docno' and transactionstatus <> 'onaccount' and recordstatus = 'allocated'";
				$exec67 = mysql_query($query67) or die(mysql_error());
				while($res67 = mysql_fetch_array($exec67))
				{
					$onaccountpayment = $res67['transactionamount1'];
					$totalonaccountpayment = $totalonaccountpayment + $onaccountpayment;
				}
				 
				$resonaccountpayment = $res3transactionamount - $totalonaccountpayment;
				$credit3 +=$resonaccountpayment;
			
			} 
			
	$credit4='0';
$query6 = "select docno,transactionamount from master_transactionpaylater where accountnameano = '$res21accountnameano' and transactiondate < '$ADate1'  and transactiontype = 'paylatercredit' and patientname='' order by transactiondate desc";
			$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
			//echo $num = mysql_num_rows($exec3);
			while ($res6 = mysql_fetch_array($exec6))
			{
				
			
				$res6transactionamount = $res6['transactionamount'];
			
				$res6docno = $res6['docno'];
				$totalpaylatercreditpayment = 0;
				$query47 = "select sum(transactionamount) as transactionamount1 from master_transactionpaylater where docno='$res6docno' and transactiontype <> 'paylatercredit' and recordstatus = 'allocated'"; //visitcode='$res6visitcode' and 
				$exec47 = mysql_query($query47) or die(mysql_error());
				while($res47 = mysql_fetch_array($exec47))
				{
					$paylatercreditpayment = $res47['transactionamount1'];
					
					$totalpaylatercreditpayment = $totalpaylatercreditpayment + $paylatercreditpayment;
				}
				
				$respaylatercreditpayment = $res6transactionamount - $totalpaylatercreditpayment;
			$credit4 +=$respaylatercreditpayment;	
				
			}
	$openingbalance = $totaldebit -$credit3 -$credit4;	
			}
			
				?>
            <tr bgcolor="#cccccc">
            <td colspan="7"  align="left" valign="center" bgcolor="#cccccc" class="bodytext31"><strong>Opening Balance</strong></td>
            <td colspan="1"  align="left" valign="center" bgcolor="#cccccc" class="bodytext31"><strong><?= number_format($openingbalance,2,'.',','); ?></strong></td>
            <td colspan="7"  align="left" valign="center" bgcolor="#cccccc" class="bodytext31"><strong><?= number_format($openingbalance,2,'.',','); ?></strong></td>
            </tr> 
            <?php
			$totalamountgreater=0;
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			$searchsuppliername1 = trim($searchsuppliername1);
		  
		
		  $query1 = "select accountname,subtype,transactiondate,patientcode,patientname,visitcode,billnumber,particulars,transactionamount,auto_number from master_transactionpaylater where accountnameano='$res21accountnameano'  and paymenttype like '%$type%' and accountnameid='$res21accountid' and transactiontype = 'finalize' and transactiondate between '$ADate1' and '$ADate2' and transactionamount <>'0' order by accountname desc";
		  $exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		  while($res2 = mysql_fetch_array($exec1))
		  {
		 		$resamount=0;
				$res2transactionamount=0;
				
				$res2transactiondate = $res2['transactiondate'];
				$res2patientname = $res2['patientname'];
				$res2visitcode = $res2['visitcode'];
				$res2billnumber = $res2['billnumber'];
				$res2transactionamount = $res2['transactionamount'];
				$res2patientcode = $res2['patientcode'];
				$particulars = $res2['particulars'];
				$anum = $res2['auto_number'];
			
				$querymrdno1 = "select mrdno from master_customer where customercode='$res2patientcode'";
				$execmrdno1 = mysql_query($querymrdno1) or die ("Error in Querymrdno1".mysql_error());
				$resmrdno1 = mysql_fetch_array($execmrdno1);
				$res1mrdno = $resmrdno1['mrdno'];
				$res2mrdno='';
				
				$totalpayment = 0;
				$query98 = "select sum(transactionamount) as transactionamount1 from master_transactionpaylater where visitcode='$res2visitcode' and transactiontype = 'PAYMENT' and billnumber='$res2billnumber' and recordstatus = 'allocated'";
				$exec98 = mysql_query($query98) or die(mysql_error());
				$num98 = mysql_num_rows($exec98);
				while($res98 = mysql_fetch_array($exec98))
				{
				$payment = $res98['transactionamount1'];
				$totalpayment = $totalpayment + $payment;
				}
				
				$res7sumtransactionamount =0;
			 	$query7 = "select sum(transactionamount) as sumtransactionamount from master_transactionpaylater where accountnameano = '$res21accountnameano' and auto_number > '$anum' and transactiontype = 'pharmacycredit' and patientcode='$res2patientcode' and visitcode='$res2visitcode' order by transactiondate desc";
				$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
				//echo $num = mysql_num_rows($exec3);
				while ($res7 = mysql_fetch_array($exec7))
				{
					 $res7sumtransactionamount += $res7['sumtransactionamount'];
				}
				
				$res8sumtransactionamount=0;
				$query8 = "select sum(transactionamount) as sumtransactionamount from master_transactionpaylater where accountnameano = '$res21accountnameano' and transactiondate > '$res2transactiondate' and transactiontype = 'paylatercredit' and patientcode='$res2patientcode' and visitcode='$res2visitcode' order by transactiondate desc";
				$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
				//echo $num = mysql_num_rows($exec3);
				while ($res8 = mysql_fetch_array($exec8))
				{
					$res8sumtransactionamount += $res8['sumtransactionamount'];
				}
				
				$res2transactionamount = $res2transactionamount-$res7sumtransactionamount-$res8sumtransactionamount;
				
				$resamount = $res2transactionamount - $totalpayment;
				
				if($resamount != '0')
				{
					$snocount = $snocount + 1;
					$t1 = strtotime($ADate2);
					$t2 = strtotime($res2transactiondate);
					$days_between = ceil(abs($t1 - $t2) / 86400);
					
					if($days_between <= 30)
					{
						
							$totalamount30 = $totalamount30 + $resamount;
						
					}
					else if(($days_between >30) && ($days_between <=60))
					{
						
							$totalamount60 = $totalamount60 + $resamount;
						
					}
					else if(($days_between >60) && ($days_between <=90))
					{
						
							$totalamount90 = $totalamount90 + $resamount;
						
					}
					else if(($days_between >90) && ($days_between <=120))
					{
						
							$totalamount120 = $totalamount120 + $resamount;
						
					}
					else if(($days_between >120) && ($days_between <=180))
					{
						
							$totalamount180 = $totalamount180 + $resamount;
						
					}
					else
					{
						
							$totalamountgreater = $totalamountgreater + $resamount;
						
					}
		 			
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
                <div class="bodytext31"><?php echo $res2patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2patientname; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $res2mrdno; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>              
              <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($res2transactionamount,2,'.',','); ?></div></td>
               <td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($resamount,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($totalamount30,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($totalamount60,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($totalamount90,2,'.',','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($totalamount120,2,'.',','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($totalamount180,2,'.',','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($totalamountgreater,2,'.',','); ?></div></td>
              
           </tr>
			<?php
			$totalamount1 = $totalamount1 + $res2transactionamount;
			$totalamount301 = $totalamount301 + $resamount;
			$totalamount601 = $totalamount601 + $totalamount30;
			$totalamount901 = $totalamount901 + $totalamount60;
			$totalamount1201 = $totalamount1201 + $totalamount90;
			$totalamount1801 = $totalamount1801 + $totalamount120;
			$totalamount2101 = $totalamount2101 + $totalamount180;
			$totalamount2401 = $totalamount2401 + $totalamountgreater;
			
			$closetotalamount1 = $closetotalamount1 + $res2transactionamount;
			$closetotalamount301 = $closetotalamount301 + $resamount;
			$closetotalamount601 = $closetotalamount601 + $totalamount30;
			$closetotalamount901 = $closetotalamount901 + $totalamount60;
			$closetotalamount1201 = $closetotalamount1201 + $totalamount90;
			$closetotalamount1801 = $closetotalamount1801 + $totalamount120;
			$closetotalamount2101 = $closetotalamount2101 + $totalamount180;
			$closetotalamount2401 = $closetotalamount2401 + $totalamountgreater;
			
			$res2transactionamount=0;
			$resamount=0;
			$totalamount30=0;
			$totalamount60=0;
			$totalamount90=0;
			$totalamount120=0;
			$totalamount180=0;
			$totalamountgreater=0;
			}
			$res2transactionamount=0;
			$resamount=0;
			$totalamount30=0;
			$total60=0;
			$totalamount60=0;
			$total90=0;
			$totalamount90=0;
			$total120=0;
			$totalamount120=0;
			$total180=0;
			$totalamount180=0;
			$total210=0;
			$totalamountgreater=0;
			
			
			$query6 = "select transactiondate,patientname,patientcode,visitcode,billnumber,transactionamount,transactionmode,docno,particulars from master_transactionpaylater where accountnameano = '$res21accountnameano'  and paymenttype like '%$type%' and transactiondate>'$res2transactiondate' and transactiontype = 'paylatercredit' and patientcode='$res2patientcode' and visitcode='$res2visitcode' order by transactiondate desc";
				$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
				//echo $num = mysql_num_rows($exec3);
				while ($res6 = mysql_fetch_array($exec6))
				{
					$respaylatercreditpayment=0;
					$res6transactiondate = $res6['transactiondate'];
					$res6patientname = $res6['patientname'];
					$res6patientcode = $res6['patientcode'];
					$res6visitcode = $res6['visitcode'];
					$res6billnumber = $res6['billnumber'];
					$res6transactionamount = $res6['transactionamount'];
					$res6transactionmode = $res6['transactionmode'];
					$res6docno = $res6['docno'];
					$particulars = $res6['particulars'];
					
					$totalpaylatercreditpayment = 0;
					$query47 = "select sum(transactionamount) as transactionamount1 from master_transactionpaylater where docno='$res6docno' and transactiontype <> 'paylatercredit' and recordstatus = 'allocated'"; //visitcode='$res6visitcode' and 
					$exec47 = mysql_query($query47) or die(mysql_error());
					while($res47 = mysql_fetch_array($exec47))
					{
						$paylatercreditpayment = $res47['transactionamount1'];					
						$totalpaylatercreditpayment = $totalpaylatercreditpayment + $paylatercreditpayment;
					}
					
					$respaylatercreditpayment = $res6transactionamount - $totalpaylatercreditpayment;
					
					if($respaylatercreditpayment != 0)
					{
					$query56 = "select billno from billing_paylater where visitcode='$res6visitcode'";
					$exec56 = mysql_query($query56) or die(mysql_error());
					$res56 = mysql_fetch_array($exec56);
					$billnos = $res56['billno'];
					
					$query57 = "select patientvisitcode from consultation_lab where patientvisitcode='$res6visitcode' and labrefund='refund'";
					$exec57 = mysql_query($query57) or die(mysql_error());
					$num57 = mysql_num_rows($exec57);
					
					if($num57 != 0)
					{
					$lab = "Lab";
					}
					else
					{
					$lab = "";
					}
					
					$query58 = "select patientvisitcode from consultation_radiology where patientvisitcode='$res6visitcode' and radiologyrefund='refund'";
					$exec58 = mysql_query($query58) or die(mysql_error());
					$num58 = mysql_num_rows($exec58);
					
					if($num58 != 0)
					{
					$rad = "Rad";
					}
					else
					{
					$rad = "";
					}
					
					$query59 = "select patientvisitcode from consultation_services where patientvisitcode='$res6visitcode' and servicerefund='refund'";
					$exec59 = mysql_query($query59) or die(mysql_error());
					$num59 = mysql_num_rows($exec59);
					
					if($num59 != 0)
					{
					$ser = "Services";
					}
					else
					{
					$ser = "";
					}
					
					$t1 = strtotime("$ADate2");
					$t2 = strtotime("$res6transactiondate");
					$days_between = ceil(abs($t1 - $t2) / 86400);
					
					
					
					
					
					if($days_between <= 30)
					{
					
					$totalamount30 = $totalamount30 + $respaylatercreditpayment;
					
					}
					else if(($days_between >30) && ($days_between <=60))
					{
					
					$totalamount60 = $totalamount60 + $respaylatercreditpayment;
					
					}
					else if(($days_between >60) && ($days_between <=90))
					{
					
					$totalamount90 = $totalamount90 + $respaylatercreditpayment;
					
					}
					else if(($days_between >90) && ($days_between <=120))
					{
					
					$totalamount120 = $totalamount120 + $respaylatercreditpayment;
					
					}
					else if(($days_between >120) && ($days_between <=180))
					{
					
					$totalamount180 = $totalamount180 + $respaylatercreditpayment;
					
					}
					else
					{
					
					$totalamountgreater = $totalamountgreater + $respaylatercreditpayment;
					
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
					<div class="bodytext31"><?php echo $res2patientcode; ?></div></td>
					<td class="bodytext31" valign="center"  align="left">
					<div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
					<div class="bodytext31"><?php echo $res2patientname; ?></div></td>
                    <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $res2mrdno; ?></div></td>
                    <td class="bodytext31" valign="center"  align="left">
				  <div class="bodytext31"><?php echo $res6docno; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div class="bodytext31"><?php echo $res6transactiondate; ?></div></td>
				  <td class="bodytext31" valign="center"  align="right">
					<div align="right">-<?php echo number_format($res6transactionamount,2,'.',','); ?></div></td>
				   <td class="bodytext31" valign="center"  align="right">
					<div align="right">-<?php echo number_format($respaylatercreditpayment,2,'.',','); ?></div></td>
					<td class="bodytext31" valign="center"  align="left">
					<div align="right">-<?php echo number_format($totalamount30,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right">-<?php echo number_format($totalamount60,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right">-<?php echo number_format($totalamount90,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right">-<?php echo number_format($totalamount120,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right">-<?php echo number_format($totalamount180,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right">-<?php echo number_format($totalamountgreater,2,'.',','); ?></div></td>
			   </tr>
				<?php
				$totalamount1 = $totalamount1 - $res6transactionamount;
				$totalamount301 = $totalamount301 - $respaylatercreditpayment;
				$totalamount601 = $totalamount601 - $totalamount30;
				$totalamount901 = $totalamount901 - $totalamount60;
				$totalamount1201 = $totalamount1201 - $totalamount90;
				$totalamount1801 = $totalamount1801 - $totalamount120;
				$totalamount2101 = $totalamount2101 - $totalamount180;
				$totalamount2401 = $totalamount2401 - $totalamountgreater;
				
				$closetotalamount1 = $closetotalamount1 - $res6transactionamount;
				$closetotalamount301 = $closetotalamount301 - $respaylatercreditpayment;
				$closetotalamount601 = $closetotalamount601 - $totalamount30;
				$closetotalamount901 = $closetotalamount901 - $totalamount60;
				$closetotalamount1201 = $closetotalamount1201 - $totalamount90;
				$closetotalamount1801 = $closetotalamount1801 - $totalamount120;
				$closetotalamount2101 = $closetotalamount2101 - $totalamount180;
				$closetotalamount2401 = $closetotalamount2401 - $totalamountgreater;
				
				$res6transactionamount=0;
				$respaylatercreditpayment=0;
				$totalamount30=0;
				$total60=0;
				$totalamount60=0;
				$total90=0;
				$totalamount90=0;
				$total120=0;
				$totalamount120=0;
				$total180=0;
				$totalamount180=0;
				$total210=0;
				$totalamountgreater=0;
			}
			
				$res6transactionamount=0;
				$respaylatercreditpayment=0;
				$totalamount30=0;
				$total60=0;
				$totalamount60=0;
				$total90=0;
				$totalamount90=0;
				$total120=0;
				$totalamount120=0;
				$total180=0;
				$totalamount180=0;
				$total210=0;
				$totalamountgreater=0;
}
			
			$query5 = "select transactiondate,patientname,patientcode,visitcode,docno,particulars,billnumber,transactionamount,transactionmode from master_transactionpaylater where accountnameano = '$searchsuppliercode'  and paymenttype like '%$type%' and auto_number > '$anum' and transactiontype = 'pharmacycredit' and patientcode='$res2patientcode' and visitcode='$res2visitcode' order by transactiondate desc";
				$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
				//echo $num = mysql_num_rows($exec3);
				while ($res5 = mysql_fetch_array($exec5))
				{
					$respharmacreditpayment=0;
					
					$res5transactiondate = $res5['transactiondate'];
					$res5patientname = $res5['patientname'];
					$res5patientcode = $res5['patientcode'];
					$res5visitcode = $res5['visitcode'];
					$res5docno = $res5['docno'];
					$particulars = $res5['particulars'];
					
					$query78 = "select billno from billing_paylater where visitcode='$res5visitcode'";
					$exec78 = mysql_query($query78);
					$res78 = mysql_fetch_array($exec78);
					$finalizedbillno = $res78['billno'];
					$res5billnumber = $res5['billnumber'];
					$res5transactionamount = $res5['transactionamount'];
					$res5transactionmode = $res5['transactionmode'];
					
					
					$t1 = strtotime("$ADate2");
					$t2 = strtotime("$res5transactiondate");
					$days_between = ceil(abs($t1 - $t2) / 86400);
					$totalpharmacreditpayment = 0;
					$totalpharmacreditpayment=0;
					$query77 = "select transactionamount from master_transactionpaylater where docno='$res5docno' and transactiontype <> 'pharmacycredit' and recordstatus = 'allocated'";
					$exec77 = mysql_query($query77) or die(mysql_error());
					while($res77 = mysql_fetch_array($exec77))
					{
					$pharmacreditpayment = $res77['transactionamount'];
					
					$totalpharmacreditpayment = $totalpharmacreditpayment + $pharmacreditpayment;
					}
					
					$respharmacreditpayment = $res5transactionamount - $totalpharmacreditpayment;
					
					if($respharmacreditpayment != 0)
					{
				
					
					if($days_between <= 30)
					{
					
					$totalamount30 = $totalamount30 + $respharmacreditpayment;
					
					}
					else if(($days_between >30) && ($days_between <=60))
					{
					
					$totalamount60 = $totalamount60 + $respharmacreditpayment;
					
					}
					else if(($days_between >60) && ($days_between <=90))
					{
					
					$totalamount90 = $totalamount90 + $respharmacreditpayment;
					
					}
					else if(($days_between >90) && ($days_between <=120))
					{
					
					$totalamount120 = $totalamount120 + $respharmacreditpayment;
					
					}
					else if(($days_between >120) && ($days_between <=180))
					{
					
					$totalamount180 = $totalamount180 + $respharmacreditpayment;
					
					}
					else
					{
					
					$totalamountgreater = $totalamountgreater - $respharmacreditpayment;
					
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
					<div class="bodytext31"><?php echo $res2patientcode; ?></div></td>
					<td class="bodytext31" valign="center"  align="left">
					<div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
					<div class="bodytext31"><?php echo $res2patientname; ?></div></td>
                    <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $res2mrdno; ?></div></td>
                    <td class="bodytext31" valign="center"  align="left">
				  <div class="bodytext31"><?php echo $res5docno; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div class="bodytext31"><?php echo $res5transactiondate; ?></div></td>
                  <td class="bodytext31" valign="center"  align="right">
					<div align="right">-<?php echo number_format($res5transactionamount,2,'.',','); ?></div></td>
				   <td class="bodytext31" valign="center"  align="right">
					<div align="right">-<?php echo number_format($respharmacreditpayment,2,'.',','); ?></div></td>
					<td class="bodytext31" valign="center"  align="left">
					<div align="right">-<?php echo number_format($totalamount30,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right">-<?php echo number_format($totalamount60,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right">-<?php echo number_format($totalamount90,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right">-<?php echo number_format($totalamount120,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right">-<?php echo number_format($totalamount180,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right">-<?php echo number_format($totalamountgreater,2,'.',','); ?></div></td>
			   </tr>
				<?php
				$totalamount1 = $totalamount1 - $res5transactionamount;
				$totalamount301 = $totalamount301 - $respharmacreditpayment;
				$totalamount601 = $totalamount601 - $totalamount30;
				$totalamount901 = $totalamount901 - $totalamount60;
				$totalamount1201 = $totalamount1201 - $totalamount90;
				$totalamount1801 = $totalamount1801 - $totalamount120;
				$totalamount2101 = $totalamount2101 - $totalamount180;
				$totalamount2401 = $totalamount2401 - $totalamountgreater;
				
				$closetotalamount1 = $closetotalamount1 - $res5transactionamount;
				$closetotalamount301 = $closetotalamount301 - $respharmacreditpayment;
				$closetotalamount601 = $closetotalamount601 - $totalamount30;
				$closetotalamount901 = $closetotalamount901 - $totalamount60;
				$closetotalamount1201 = $closetotalamount1201 - $totalamount90;
				$closetotalamount1801 = $closetotalamount1801 - $totalamount120;
				$closetotalamount2101 = $closetotalamount2101 - $totalamount180;
				$closetotalamount2401 = $closetotalamount2401 - $totalamountgreater;
				
				
			}
				$res5transactionamount=0;
				$respharmacreditpayment=0;
				$totalamount30=0;
				$total60=0;
				$totalamount60=0;
				$total90=0;
				$totalamount90=0;
				$total120=0;
				$totalamount120=0;
				$total180=0;
				$totalamount180=0;
				$total210=0;
				$totalamountgreater=0;
		
		
		$res5transactionamount=0;
				$respharmacreditpayment=0;
				$totalamount30=0;
				$total60=0;
				$totalamount60=0;
				$total90=0;
				$totalamount90=0;
				$total120=0;
				$totalamount120=0;
				$total180=0;
				$totalamount180=0;
				$total210=0;
				$totalamountgreater=0;}
		
				$res5transactionamount=0;
				$respharmacreditpayment=0;
				$totalamount30=0;
				$total60=0;
				$totalamount60=0;
				$total90=0;
				$totalamount90=0;
				$total120=0;
				$totalamount120=0;
				$total180=0;
				$totalamount180=0;
				$total210=0;
				$totalamountgreater=0;
}
			
			
		
			$querycredit4 = "select transactionamount,docno,transactiondate,particulars,transactionmode,patientname,patientcode,visitcode,billnumber from master_transactionpaylater where accountnameano='$res21accountnameano'  and paymenttype like '%$type%' and accountnameid='$res21accountid' and patientname = ''  and transactiontype = 'paylatercredit' and recordstatus <> 'deallocated' and transactiondate between '$ADate1' and '$ADate2'";
			$execcredit4 = mysql_query($querycredit4) or die ("Error in Querycredit4".mysql_error());
			while($res6 = mysql_fetch_array($execcredit4))
			{
		
				$respaylatercreditpayment=0;
				$res6transactiondate = $res6['transactiondate'];
				$res6patientname = $res6['patientname'];
				$res6patientcode = $res6['patientcode'];
				$res6visitcode = $res6['visitcode'];
				$res6billnumber = $res6['billnumber'];
				$res6transactionamount = $res6['transactionamount'];
				$res6transactionmode = $res6['transactionmode'];
				$res6docno = $res6['docno'];
				$particulars = $res6['particulars'];
				
				
				$t1 = strtotime($ADate2);
				$t2 = strtotime($res6transactiondate);
				$days_between = ceil(abs($t1 - $t2) / 86400);
				
				$totalpaylatercreditpayment = 0;
				$query47 = "select sum(transactionamount) as transactionamount1 from master_transactionpaylater where docno='$res6docno' and transactiontype <> 'paylatercredit' and recordstatus = 'allocated'"; //visitcode='$res6visitcode' and 
				$exec47 = mysql_query($query47) or die(mysql_error());
				while($res47 = mysql_fetch_array($exec47))
				{
					$paylatercreditpayment = $res47['transactionamount1'];
					
					$totalpaylatercreditpayment = $totalpaylatercreditpayment + $paylatercreditpayment;
				}
				
				$respaylatercreditpayment = $res6transactionamount - $totalpaylatercreditpayment;
				
				if($respaylatercreditpayment != 0)
				{
					
					
					
					if($days_between <= 30)
					{
					
					$totalamount30 = $totalamount30 + $respaylatercreditpayment;
					
					}
					else if(($days_between >30) && ($days_between <=60))
					{
					
					$totalamount60 = $totalamount60 + $respaylatercreditpayment;
					
					}
					else if(($days_between >60) && ($days_between <=90))
					{
					
					$totalamount90 = $totalamount90 + $respaylatercreditpayment;
					
					}
					else if(($days_between >90) && ($days_between <=120))
					{
					
					$totalamount120 = $totalamount120 + $respaylatercreditpayment;
					
					}
					else if(($days_between >120) && ($days_between <=180))
					{
					
					$totalamount180 = $totalamount180 + $respaylatercreditpayment;
					
					}
					else
					{
					
					$totalamountgreater = $totalamountgreater + $respaylatercreditpayment;
					
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
					<div class="bodytext31"><?php echo $res6patientcode; ?></div></td>
					<td class="bodytext31" valign="center"  align="left">
					<div class="bodytext31"><?php echo $res6visitcode; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
					<div class="bodytext31"><?php echo $particulars; ?></div></td>
                    <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo ''; ?></div></td>
                    <td class="bodytext31" valign="center"  align="left">
				  <div class="bodytext31"><?php echo $res6docno; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div class="bodytext31">-<?php echo $res6transactiondate; ?></div></td>
				  <td class="bodytext31" valign="center"  align="right">
					<div align="right">-<?php echo number_format($res6transactionamount,2,'.',','); ?></div></td>
				   <td class="bodytext31" valign="center"  align="right">
					<div align="right">-<?php echo number_format($respaylatercreditpayment,2,'.',','); ?></div></td>
					<td class="bodytext31" valign="center"  align="left">
					<div align="right">-<?php echo number_format($totalamount30,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right">-<?php echo number_format($totalamount60,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right">-<?php echo number_format($totalamount90,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right">-<?php echo number_format($totalamount120,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right">-<?php echo number_format($totalamount180,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right">-<?php echo number_format($totalamountgreater,2,'.',','); ?></div></td>
			   </tr>
				<?php
				$totalamount1 = $totalamount1 - $res6transactionamount;
				$totalamount301 = $totalamount301 - $respaylatercreditpayment;
				$totalamount601 = $totalamount601 - $totalamount30;
				$totalamount901 = $totalamount901 - $totalamount60;
				$totalamount1201 = $totalamount1201 - $totalamount90;
				$totalamount1801 = $totalamount1801 - $totalamount120;
				$totalamount2101 = $totalamount2101 - $totalamount180;
				$totalamount2401 = $totalamount2401 - $totalamountgreater;
				
				$closetotalamount1 = $closetotalamount1 - $res6transactionamount;
				$closetotalamount301 = $closetotalamount301 - $respaylatercreditpayment;
				$closetotalamount601 = $closetotalamount601 - $totalamount30;
				$closetotalamount901 = $closetotalamount901 - $totalamount60;
				$closetotalamount1201 = $closetotalamount1201 - $totalamount90;
				$closetotalamount1801 = $closetotalamount1801 - $totalamount120;
				$closetotalamount2101 = $closetotalamount2101 - $totalamount180;
				$closetotalamount2401 = $closetotalamount2401 - $totalamountgreater;
				
				$res6transactionamount=0;
				$respaylatercreditpayment=0;
				$totalamount30=0;
				$total60=0;
				$totalamount60=0;
				$total90=0;
				$totalamount90=0;
				$total120=0;
				$totalamount120=0;
				$total180=0;
				$totalamount180=0;
				$total210=0;
				$totalamountgreater=0;
				}
				$res6transactionamount=0;
				$respaylatercreditpayment=0;
				$totalamount30=0;
				$total60=0;
				$totalamount60=0;
				$total90=0;
				$totalamount90=0;
				$total120=0;
				$totalamount120=0;
				$total180=0;
				$totalamount180=0;
				$total210=0;
				$totalamountgreater=0;
			}
			
		
			
			    $query3 = "select transactiondate,patientname,patientcode,visitcode,billnumber,docno,transactionamount,transactionmode,chequenumber,particulars from master_transactionpaylater where accountnameano = '$res21accountnameano'  and paymenttype like '%$type%' and accountnameid='$res21accountid'  and  transactiondate between '$ADate1' and '$ADate2' and transactionstatus in ('onaccount','paylatercredit')  order by accountname desc";
			$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
			// echo $num3 = mysql_num_rows($exec3);
			while ($res3 = mysql_fetch_array($exec3))
			{
				$resonaccountpayment=0;
				$res3transactiondate = $res3['transactiondate'];
				$res3patientname = $res3['patientname'];
				$res3patientcode = $res3['patientcode'];
				$res3visitcode = $res3['visitcode'];
				$res3billnumber = $res3['billnumber'];
				$res3docno = $res3['docno'];
			 	$res3transactionamount = $res3['transactionamount'];
				$res3transactionmode = $res3['transactionmode'];
				$res3transactionnumber = $res3['chequenumber'];
				$particulars = $res3['particulars'];
				
				$t1 = strtotime($ADate2);
				$t2 = strtotime($res3transactiondate);
				$days_between = ceil(abs($t1 - $t2) / 86400);

				$totalonaccountpayment = 0;
			 	$query67 = "select sum(transactionamount) as transactionamount1 from master_transactionpaylater where  docno='$res3docno' and transactionstatus <> 'onaccount' and recordstatus = 'allocated'";
				$exec67 = mysql_query($query67) or die(mysql_error());
				while($res67 = mysql_fetch_array($exec67))
				{
					$onaccountpayment = $res67['transactionamount1'];
					$totalonaccountpayment = $totalonaccountpayment + $onaccountpayment;
				}
				 
			 	 $resonaccountpayment = $res3transactionamount - $totalonaccountpayment;
				
				if($resonaccountpayment != 0)
				{
				
				
				
				if($days_between <= 30)
				{
				
				$totalamount30 = $totalamount30 + $resonaccountpayment;
				
				}
				else if(($days_between >30) && ($days_between <=60))
				{
				
				$totalamount60 = $totalamount60 + $resonaccountpayment;
				
				}
				else if(($days_between >60) && ($days_between <=90))
				{
				
				$totalamount90 = $totalamount90 + $resonaccountpayment;
				
				}
				else if(($days_between >90) && ($days_between <=120))
				{
				
				$totalamount120 = $totalamount120 + $resonaccountpayment;
				
				}
				else if(($days_between >120) && ($days_between <=180))
				{
				
				$totalamount180 = $totalamount180 + $resonaccountpayment;
				
				}
				else
				{
				
				$totalamountgreater = $totalamountgreater + $resonaccountpayment;
				
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
					<div class="bodytext31"><?php echo $res3docno; ?></div></td>
					<td class="bodytext31" valign="center"  align="left">
					<div class="bodytext31"><?php echo $res3docno; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
					<div class="bodytext31"><?php echo $particulars; ?></div></td>
                    <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo ''; ?></div></td>
                    <td class="bodytext31" valign="center"  align="left">
				  <div class="bodytext31"><?php echo $res3docno; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div class="bodytext31"><?php echo $res3transactiondate; ?></div></td>
				  <td class="bodytext31" valign="center"  align="right">
					<div align="right">-<?php //echo number_format($res3transactionamount,2,'.',','); ?></div></td>
				   <td class="bodytext31" valign="center"  align="right">
					<div align="right">-<?php echo number_format(abs($resonaccountpayment),2,'.',','); ?></div></td>
					<td class="bodytext31" valign="center"  align="left">
					<div align="right">-<?php echo number_format($totalamount30,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right">-<?php echo number_format($totalamount60,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right">-<?php echo number_format($totalamount90,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right">-<?php echo number_format($totalamount120,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right">-<?php echo number_format($totalamount180,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
				  <div align="right">-<?php echo number_format($totalamountgreater,2,'.',','); ?></div></td>
			   </tr>
				<?php
				//$totalamount1 = $totalamount1 - $res3transactionamount;
				$totalamount301 = $totalamount301 - $resonaccountpayment;
				$totalamount601 = $totalamount601 - $totalamount30;
				$totalamount901 = $totalamount901 - $totalamount60;
				$totalamount1201 = $totalamount1201 - $totalamount90;
				$totalamount1801 = $totalamount1801 - $totalamount120;
				$totalamount2101 = $totalamount2101 - $totalamount180;
				$totalamount2401 = $totalamount2401 - $totalamountgreater;
				
				//$closetotalamount1 = $closetotalamount1 - $res3transactionamount;
				$closetotalamount301 = $closetotalamount301 - $resonaccountpayment;
				$closetotalamount601 = $closetotalamount601 - $totalamount30;
				$closetotalamount901 = $closetotalamount901 - $totalamount60;
				$closetotalamount1201 = $closetotalamount1201 - $totalamount90;
				$closetotalamount1801 = $closetotalamount1801 - $totalamount120;
				$closetotalamount2101 = $closetotalamount2101 - $totalamount180;
				$closetotalamount2401 = $closetotalamount2401 - $totalamountgreater;
			}
			$res3transactionamount=0;
				$resonaccountpayment=0;
				$totalamount30=0;
				$total60=0;
				$totalamount60=0;
				$total90=0;
				$totalamount90=0;
				$total120=0;
				$totalamount120=0;
				$total180=0;
				$totalamount180=0;
				$total210=0;
				$totalamountgreater=0;
			}
			
		$closetotalamount1 =$closetotalamount1 +$openingbalance;
		$closetotalamount301=$closetotalamount301 + $openingbalance;
		
		$totalamount1 =$totalamount1+$openingbalance;
		$totalamount301=$totalamount301 + $openingbalance;
			?>
            <tr>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="center" 
                bgcolor="#cccccc">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="center" 
                bgcolor="#cccccc">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="center" 
                bgcolor="#cccccc">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="center" 
                bgcolor="#cccccc">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="center" 
                bgcolor="#cccccc">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc"><strong>Sub Total:</strong></td>
                <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($closetotalamount1,2,'.',','); ?></strong></td>
                <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($closetotalamount301,2,'.',','); ?></strong></td>
                 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($closetotalamount601,2,'.',','); ?></strong></td>
                <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($closetotalamount901,2,'.',','); ?></strong></td>
                <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($closetotalamount1201,2,'.',','); ?></strong></td>
                <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($closetotalamount1801,2,'.',','); ?></strong></td>
                <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($closetotalamount2101,2,'.',','); ?></strong></td>
                <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($closetotalamount2401,2,'.',','); ?></strong></td>        
            </tr>
            <?php
			$closetotalamount1 = '0';
			$closetotalamount301 = '0';
			$closetotalamount601 = '0';
			$closetotalamount901 = '0';
			$closetotalamount1201 = '0';
			$closetotalamount1801 = '0';
			$closetotalamount2101 = '0';
			$closetotalamount2401 = '0';
			
			
			
			}
			 



			$totalamount30=0;
			$totalamount60=0;
			$totalamount90=0;
			$totalamount120=0;
			$totalamount180=0;
			$totalamount210=0;

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
              <td class="bodytext31" valign="center"  align="center" 
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
				$urlpath = "cbfrmflag1=cbfrmflag1&&ADate1=$ADate1&&ADate2=$ADate2&&searchsuppliername=$searchsuppliername&&searchsuppliername1=$searchsuppliername1&&type=$type&&accountnameano=$res21accountnameano&&searchaccountnameanum1=$searchsuppliercode&&searchsubtypeanum1=$searchsubtypeanum1";			
			?>
			 <td colspan="12"></td>
		   	 <td class="bodytext31" valign="center"  align="right"><a href="print_fulldebtoranalysisdetailed.php?<?php echo $urlpath; ?>"><img  width="40" height="40" src="images/excel-xls-icon.png" style="cursor:pointer;"></a></td>
			</tr>    
          </tbody>
        </table></td>
      </tr>
	  
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
