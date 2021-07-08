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
$customername ='';
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
//include ("autocompletebuild_customer2.php");


if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
if (isset($_REQUEST["searchsuppliercode"])) { $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }
if (isset($_REQUEST["searchvisitcode"])) { $searchvisitcode = $_REQUEST["searchvisitcode"]; } else { $searchvisitcode = ""; }
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
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script src="js/datetimepicker_css.js"></script>
<script type="text/javascript" src="js/autocomplete_patientstatus.js"></script>
<script type="text/javascript" src="js/autosuggestpatientstatus1.js"></script>
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
		
		
              <form name="cbform1" method="post" action="cashbillsreport.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#CCCCCC" class="bodytext3"><strong>Cash Bills Report</strong></td>
              </tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Patient </td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
              <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">
			  <input name="searchsuppliercode" id="searchsuppliercode" value="<?php echo $searchsuppliercode; ?>" type="hidden">
			  <input name="searchvisitcode" id="searchvisitcode" value="<?php echo $searchvisitcode; ?>" type="hidden">
			  <input name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox" type="hidden" value="">
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1178" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="3%" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
              <td colspan="15" bgcolor="#cccccc" class="bodytext31">
              <?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					if (isset($_REQUEST["cbcustomername"])) { $cbcustomername = $_REQUEST["cbcustomername"]; } else { $cbcustomername = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["searchsuppliername"])) { $customername = $_REQUEST["searchsuppliername"]; } else { $customername = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
					if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
				}
				?> 				</td>  
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient</strong></div></td>
              <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date </strong></td>
				 <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Reg No </strong></td>
              <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Visit No </strong></td>
				<td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Bill No </strong></td>
				 <td width="8%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Consultation</strong></div></td>
              <td width="4%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Lab</strong></div></td>
				<td width="7%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Pharmacy</strong></div></td>
				<td width="7%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Radiology</strong></div></td>
              <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Services</strong></div></td>
				<td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Referral</strong></div></td>
				<td width="7%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Deposits</strong></div></td>
				  <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>IP Final</strong></div></td>
				<td width="7%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>OTC Bill</strong></div></td>
				<td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Total</strong></div></td>
				</tr>
			
			<?php
			
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			$totalcon = 0;
			
			
		  $query11 = "select * from master_billing where patientfullname like '%$customername%' and billingdatetime between '$ADate1' and '$ADate2'";
		  $exec11 = mysql_query($query11) or die(mysql_error());
		  while($res11 = mysql_fetch_array($exec11))
		  {
		  $res11patientfullname = $res11['patientfullname'];
		  $res11consultationdate = $res11['billingdatetime'];
		  $res11visitcode = $res11['visitcode'];
		  $res11patientcode = $res11['patientcode'];
		  $amount = $res11['cashamount'];
		  $billnumber = $res11['billnumber'];
		  $total = $amount;
		  $totalcon = $totalcon + $total;
		  $total6 = $total6 + $total;
		  
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
                <div class="bodytext31"><?php echo $res11patientfullname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res11consultationdate; ?></div></td>
				   <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res11patientcode; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res11visitcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $billnumber; ?></td>
			   <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo "0.00"; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo "0.00"; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo "0.00"; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
			  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>
			  </tr>
			<?php
		  }
		  $totalconref = 0;
		  $query12 = "select * from refund_consultation where patientname like '%$customername%' and billdate between '$ADate1' and '$ADate2'";
		  $exec12 = mysql_query($query12) or die(mysql_error());
		  while($res12 = mysql_fetch_array($exec12))
		  {
		  $res12patientfullname = $res12['patientname'];
		  $res12consultationdate = $res12['billdate'];
		  $res12visitcode = $res12['patientvisitcode'];
		  $res12patientcode = $res12['patientcode'];
		  $amount = $res12['consultation'];
		  $billnumber = $res12['billnumber'];
		  $total = -$amount;
		  $totalconref = $totalconref + $total;
		  $total6 = $total6 + $total;
		  
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
                <div class="bodytext31"><?php echo $res12patientfullname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res12consultationdate; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res12patientcode; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res12visitcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $billnumber; ?></td>
			   <td class="bodytext31" valign="center"  align="left">
			    <div align="right">-<?php echo number_format($amount,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo "0.00"; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo "0.00"; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo "0.00"; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
			  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>
			  </tr>
			<?php
		  }  
		  $query2 = "select * from master_visitentry where patientfullname like '%$customername%' and billtype = 'PAY NOW' and overallpayment = 'completed' and consultationdate between '$ADate1' and '$ADate2' order by consultationdate desc";
		  $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		  while ($res2 = mysql_fetch_array($exec2))
		  {
     	  $res2patientfullname = $res2['patientfullname'];
		  $res2consultationdate = $res2['consultationdate'];
		  $res2visitcode = $res2['visitcode'];
		  $res2patientcode = $res2['patientcode'];
		  $query8 = "select * from billing_paynow where patientname = '$res2patientfullname' and visitcode = '$res2visitcode'";
		  $exec8 = mysql_query($query8) or die ("Error in query8".mysql_error());
		  $res8 = mysql_fetch_array($exec8);
		  $res8billnumber = $res8['billno'];
		  
		  $query3 = "select sum(labitemrate) as labitemrate1 from billing_paynowlab where patientname = '$res2patientfullname' and patientvisitcode = '$res2visitcode'";
		  $exec3 = mysql_query($query3) or die ("Error in Query3". mysql_error());
		  $res3= mysql_fetch_array($exec3);
		  $res3labitemrate = $res3['labitemrate1'];
		  
		  if($res3labitemrate == '')
		  {
		  $res3labitemrate = '0.00';
		  }
		  else
		  {
		  $res3labitemrate = $res3['labitemrate1'];
		  }
		  
		  $query4 = "select sum(amount) as amount1 from billing_paynowpharmacy where patientname = '$res2patientfullname' and patientvisitcode = '$res2visitcode'";
		  $exec4 = mysql_query($query4) or die ("Error in Query4". mysql_error());
		  $res4= mysql_fetch_array($exec4);
		  $res4pharmacyitemrate = $res4['amount1'];
		  if($res4pharmacyitemrate == '')
		  {
		  $res4pharmacyitemrate = '0.00';
		  }
		  else
		  {
		  $res4pharmacyitemrate = $res4['amount1'];
		  }
		  
		  $query5 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_paynowradiology where patientname = '$res2patientfullname' and patientvisitcode = '$res2visitcode'";
		  $exec5 = mysql_query($query5) or die ("Error in Query5". mysql_error());
		  $res5= mysql_fetch_array($exec5);
		  $res5radiologyitemrate = $res5['radiologyitemrate1'];
		  if($res5radiologyitemrate == '')
		  {
		  $res5radiologyitemrate = '0.00';
		  }
		  else
		  {
		  $res5radiologyitemrate = $res5['radiologyitemrate1'];
		  }
		  
		  $query6 = "select sum(servicesitemrate) as servicesitemrate1 from billing_paynowservices where patientname = '$res2patientfullname' and patientvisitcode = '$res2visitcode'";
		  $exec6 = mysql_query($query6) or die ("Error in Query6". mysql_error());
		  $res6 = mysql_fetch_array($exec6);
		  $res6servicesitemrate = $res6['servicesitemrate1'];
		  if($res6servicesitemrate == '')
		  {
		  $res6servicesitemrate = '0.00';
		  }
		  else
		  {
		  $res6servicesitemrate = $res6['servicesitemrate1'];
		  }
		  
		  $query7 = "select sum(referalrate) as referalrate1 from billing_paynowreferal where patientname = '$res2patientfullname' and patientvisitcode = '$res2visitcode'";
		  $exec7 = mysql_query($query7) or die ("Error in Query7". mysql_error());
		  $res7 = mysql_fetch_array($exec7);
		  $res7referalitemrate = $res7['referalrate1'];
		  if($res7referalitemrate == '')
		  {
		  $res7referalitemrate = '0.00';
		  }
		  else
		  {
		  $res7referalitemrate = $res6['servicesitemrate1'];
		  }
		  
		  $total = $res3labitemrate + $res4pharmacyitemrate + $res5radiologyitemrate + $res6servicesitemrate + $res7referalitemrate;
		  $total1 = $total1 + $res3labitemrate;
		  $total2 = $total2 + $res4pharmacyitemrate;
		  $total3 = $total3 + $res5radiologyitemrate;
		  $total4 = $total4 + $res6servicesitemrate;
		  $total5 = $total5 + $res7referalitemrate;
		  $total6 = $total6 + $total;
		  
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
                <div class="bodytext31"><?php echo $res2patientfullname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2consultationdate; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2patientcode; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2visitcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res8billnumber; ?></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			   			    <div align="right"><?php echo number_format($res3labitemrate,2,'.',','); ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($res4pharmacyitemrate,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($res5radiologyitemrate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res6servicesitemrate,2,'.',','); ?></div></td>
              <td  align="left" valign="center" class="bodytext31">
			  <div align="right"><?php echo number_format($res7referalitemrate,2,'.',','); ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
 			 <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
			  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>
			  </tr>
			<?php
			}
		  $query2 = "select * from master_visitentry where patientfullname like '%$customername%' and billtype = 'PAY NOW' and overallpayment = 'completed' and consultationdate between '$ADate1' and '$ADate2' order by consultationdate desc";
		  $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		  while ($res2 = mysql_fetch_array($exec2))
		  {
     	  $res2patientfullname = $res2['patientfullname'];
		  $res2consultationdate = $res2['consultationdate'];
		  $res2visitcode = $res2['visitcode'];
		   $res2patientcode = $res2['patientcode'];
		  $query8 = "select * from refund_paynow where patientname = '$res2patientfullname' and visitcode = '$res2visitcode'";
		  $exec8 = mysql_query($query8) or die ("Error in query8".mysql_error());
		  $res8 = mysql_fetch_array($exec8);
		  $res8billnumber = $res8['billnumber'];
		  
		  $query3 = "select sum(labitemrate) as labitemrate1 from refund_paynowlab where patientname = '$res2patientfullname' and patientvisitcode = '$res2visitcode'";
		  $exec3 = mysql_query($query3) or die ("Error in Query3". mysql_error());
		  $res3= mysql_fetch_array($exec3);
		  $res3labitemrate = $res3['labitemrate1'];
		  
		  if($res3labitemrate == '')
		  {
		  $res3labitemrate = '0.00';
		  }
		  else
		  {
		  $res3labitemrate = -$res3['labitemrate1'];
		  }
		  
		  $query4 = "select sum(amount) as amount1 from refund_paynowpharmacy where patientname = '$res2patientfullname' and patientvisitcode = '$res2visitcode'";
		  $exec4 = mysql_query($query4) or die ("Error in Query4". mysql_error());
		  $res4= mysql_fetch_array($exec4);
		  $res4pharmacyitemrate = $res4['amount1'];
		  if($res4pharmacyitemrate == '')
		  {
		  $res4pharmacyitemrate = '0.00';
		  }
		  else
		  {
		  $res4pharmacyitemrate = -$res4['amount1'];
		  }
		  
		  $query5 = "select sum(radiologyitemrate) as radiologyitemrate1 from refund_paynowradiology where patientname = '$res2patientfullname' and patientvisitcode = '$res2visitcode'";
		  $exec5 = mysql_query($query5) or die ("Error in Query5". mysql_error());
		  $res5= mysql_fetch_array($exec5);
		  $res5radiologyitemrate = $res5['radiologyitemrate1'];
		  if($res5radiologyitemrate == '')
		  {
		  $res5radiologyitemrate = '0.00';
		  }
		  else
		  {
		  $res5radiologyitemrate = -$res5['radiologyitemrate1'];
		  }
		  
		  $query6 = "select sum(servicesitemrate) as servicesitemrate1 from refund_paynowservices where patientname = '$res2patientfullname' and patientvisitcode = '$res2visitcode'";
		  $exec6 = mysql_query($query6) or die ("Error in Query6". mysql_error());
		  $res6 = mysql_fetch_array($exec6);
		  $res6servicesitemrate = $res6['servicesitemrate1'];
		  if($res6servicesitemrate == '')
		  {
		  $res6servicesitemrate = '0.00';
		  }
		  else
		  {
		  $res6servicesitemrate = -$res6['servicesitemrate1'];
		  }
		  
		  $query7 = "select sum(referalrate) as referalrate1 from refund_paynowreferal where patientname = '$res2patientfullname' and patientvisitcode = '$res2visitcode'";
		  $exec7 = mysql_query($query7) or die ("Error in Query7". mysql_error());
		  $res7 = mysql_fetch_array($exec7);
		  $res7referalitemrate = $res7['referalrate1'];
		  if($res7referalitemrate == '')
		  {
		  $res7referalitemrate = '0.00';
		  }
		  else
		  {
		  $res7referalitemrate = -$res7['referalrate1'];
		  }
		  
		  $total = $res3labitemrate + $res4pharmacyitemrate + $res5radiologyitemrate + $res6servicesitemrate + $res7referalitemrate;
		  $total1 = $total1 + $res3labitemrate;
		  $total2 = $total2 + $res4pharmacyitemrate;
		  $total3 = $total3 + $res5radiologyitemrate;
		  $total4 = $total4 + $res6servicesitemrate;
		  $total5 = $total5 + $res7referalitemrate;
		  $total6 = $total6 + $total;
		  
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
                <div class="bodytext31"><?php echo $res2patientfullname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2consultationdate; ?></div></td>
						 <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2patientcode; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2visitcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res8billnumber; ?></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>

              <td class="bodytext31" valign="center"  align="left">
			   			    <div align="right"><?php echo number_format($res3labitemrate,2,'.',','); ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($res4pharmacyitemrate,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($res5radiologyitemrate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res6servicesitemrate,2,'.',','); ?></div></td>
              <td  align="left" valign="center" class="bodytext31">
			  <div align="right"><?php echo number_format($res7referalitemrate,2,'.',','); ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
 			 <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
			  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>
			  </tr>
			<?php
			}
			$totaladv = 0;
		  $query13 = "select * from master_transactionadvancedeposit where patientname like '%$customername%' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec13 = mysql_query($query13) or die(mysql_error());
		  while($res13 = mysql_fetch_array($exec13))
		  {
		  $res13patientfullname = $res13['patientname'];
		  $res13consultationdate = $res13['transactiondate'];
		  $res13patientcode = $res13['patientcode'];
		  $res13visitcode = '';
		  $amount = $res13['cashamount'];
		  $billnumber = $res13['docno'];
		  $total = $amount;
		  $totaladv = $totaladv + $total;
		  $total6 = $total6 + $total;
		  
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
                <div class="bodytext31"><?php echo $res13patientfullname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res13consultationdate; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res13patientcode; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res13visitcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $billnumber; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo "0.00"; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo "0.00"; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo "0.00"; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
			  			   <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
			  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>
			  </tr>
			<?php
		  }
		  $totalipdep = 0;
		  $query13 = "select * from master_transactionipdeposit where patientname like '%$customername%' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec13 = mysql_query($query13) or die(mysql_error());
		  while($res13 = mysql_fetch_array($exec13))
		  {
		  $res13patientfullname = $res13['patientname'];
		  $res13consultationdate = $res13['transactiondate'];
		  $res13patientcode = $res13['patientcode'];
		  $res13visitcode = $res13['visitcode'];
		  $amount = $res13['cashamount'];
		  $billnumber = $res13['docno'];
		  $total = $amount;
		  $totalipdep = $totalipdep  + $total;
		  $total6 = $total6 + $total;
		  
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
                <div class="bodytext31"><?php echo $res13patientfullname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res13consultationdate; ?></div></td>
				   <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res13patientcode; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res13visitcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $billnumber; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo "0.00"; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo "0.00"; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo "0.00"; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
			  			   <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
			  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>
			  </tr>
			<?php
		  }
		  $totaldepref = 0; 
		   $query13 = "select * from deposit_refund where patientname like '%$customername%' and recorddate between '$ADate1' and '$ADate2'";
		  $exec13 = mysql_query($query13) or die(mysql_error());
		  while($res13 = mysql_fetch_array($exec13))
		  {
		  $res13patientfullname = $res13['patientname'];
		  $res13consultationdate = $res13['recorddate'];
		  $res13patientcode = $res13['patientcode'];
		  $res13visitcode = $res13['visitcode'];
		  $amount = $res13['amount'];
		  $billnumber = $res13['docno'];
		  $total = -$amount;
		  $totaldepref = $totaldepref  + $total;
		  $total6 = $total6 + $total;
		  
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
                <div class="bodytext31"><?php echo $res13patientfullname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res13consultationdate; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res13patientcode; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res13visitcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $billnumber; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo "0.00"; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo "0.00"; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo "0.00"; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
			  			   <td class="bodytext31" valign="center"  align="left">
			    <div align="right">-<?php echo number_format($amount,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
			  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>
			  </tr>
			<?php
		  }
		  $totalipfinal = 0;
		  $query13 = "select * from master_transactionip where patientname like '%$customername%' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec13 = mysql_query($query13) or die(mysql_error());
		  while($res13 = mysql_fetch_array($exec13))
		  {
		  $res13patientfullname = $res13['patientname'];
		  $res13consultationdate = $res13['transactiondate'];
		  $res13patientcode = $res13['patientcode'];
		  $res13visitcode = $res13['visitcode'];
		  $amount = $res13['cashamount'];
		  $billnumber = $res13['billnumber'];
		  $total = $amount;
		  $totalipfinal = $totalipfinal  + $total;
		  $total6 = $total6 + $total;
		  
		  if($amount != 0.00)
		  {
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
                <div class="bodytext31"><?php echo $res13patientfullname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res13consultationdate; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res13patientcode; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res13visitcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $billnumber; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo "0.00"; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo "0.00"; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo "0.00"; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
			  			  
						   		  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
					  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>
			  </tr>
			<?php
		  }
		  }
		  $totalipcredit = 0;
		  $query13 = "select * from master_transactionipcreditapproved where patientname like '%$customername%' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec13 = mysql_query($query13) or die(mysql_error());
		  while($res13 = mysql_fetch_array($exec13))
		  {
		  $res13patientfullname = $res13['patientname'];
		  $res13consultationdate = $res13['transactiondate'];
		  $res13patientcode = $res13['patientcode'];
		  $res13visitcode = $res13['visitcode'];
		  $amount = $res13['cashamount'];
		  $billnumber = $res13['billnumber'];
		  $total = $amount;
		  $totalipcredit = $totalipcredit  + $total;
		  $total6 = $total6 + $total;
		  
		  if($amount != 0.00)
		  {
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
                <div class="bodytext31"><?php echo $res13patientfullname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res13consultationdate; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res13patientcode; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res13visitcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $billnumber; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo "0.00"; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo "0.00"; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo "0.00"; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>			  			  
						   		  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
					  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>
			  </tr>
			<?php
		  }
		  }
		 
			
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			$totalotc = 0;
			$totalotcs = '0.00';
			
		  $query11otc = "select * from billing_externalpharmacy where patientname like '%$customername%' and billdate between '$ADate1' and '$ADate2'";
		  $exec11otc = mysql_query($query11otc) or die(mysql_error());
		  while($res11otc = mysql_fetch_array($exec11otc))
		  {
		  $res11patientfullname = $res11otc['patientname'];
		  $res11consultationdate = $res11otc['billdate'];
		  $res11visitcode = $res11otc['patientvisitcode'];
		  $res11patientcode = $res11otc['patientcode'];
		  $amount = $res11otc['amount'];
		  $billnumber = $res11otc['billnumber'];
		  $totalotc = $amount;
		  $totalotcs = $totalotcs + $totalotc;
		  $total6 = $total6 + $totalotc;
		  
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
                <div class="bodytext31"><?php echo $res11patientfullname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res11consultationdate; ?></div></td>
				   <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res11patientcode; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res11visitcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $billnumber; ?></td>
			   <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo "0.00"; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo "0.00"; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo "0.00"; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo "0.00"; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
			  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($totalotcs,2,'.',','); ?></div></td>
			  </tr>
			<?php
		  }
		  $dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			$totalext = 0;
			$totalexts = '0.00';
			
		  $query11ext = "select * from billing_external where patientname like '%$customername%' and billdate between '$ADate1' and '$ADate2'";
		  $exec11ext = mysql_query($query11ext) or die(mysql_error());
		  while($res11ext = mysql_fetch_array($exec11ext))
		  {
		  $res11patientfullname = $res11ext['patientname'];
		  $res11consultationdate = $res11ext['billdate'];
		  $res11visitcode = $res11ext['visitcode'];
		  $res11patientcode = $res11ext['patientcode'];
		  $amount = $res11ext['totalamount'];
		  $billnumber = $res11ext['billno'];
		  $totalexts = '0';
		 
		  
		  $query3 = "select sum(labitemrate) as labitemrate1 from billing_externallab where billnumber='$billnumber' and patientname = '$res11patientfullname' and patientvisitcode = '$res11visitcode'";
		  $exec3 = mysql_query($query3) or die ("Error in Query3". mysql_error());
		  $res3= mysql_fetch_array($exec3);
		  $res3labitemrate = $res3['labitemrate1'];
		  
		  if($res3labitemrate == '')
		  {
		  $res3labitemrate = '0.00';
		  }
		  else
		  {
		  $res3labitemrate = $res3['labitemrate1'];
		  $total1 = $total1 + $res3labitemrate;
		  $total6 = $total6 + $res3labitemrate;
		  $totalexts = $totalexts + $res3labitemrate;
		  }
		  
		  $query3 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_externalradiology where billnumber='$billnumber' and patientname = '$res11patientfullname' and patientvisitcode = '$res11visitcode'";
		  $exec3 = mysql_query($query3) or die ("Error in Query3". mysql_error());
		  $res3= mysql_fetch_array($exec3);
		  $res3radiologyitemrate = $res3['radiologyitemrate1'];
		  
		  if($res3radiologyitemrate == '')
		  {
		  $res3radiologyitemrate = '0.00';
		  }
		  else
		  {
		  $res3radiologyitemrate = $res3['radiologyitemrate1'];
		  $total3 = $total3 + $res3radiologyitemrate;
		  $total6 = $total6 + $res3radiologyitemrate;
		  $totalexts = $totalexts + $res3radiologyitemrate;
		  }
		  
		  $query3 = "select sum(servicesitemrate) as servicesitemrate1 from billing_externalservices where billnumber='$billnumber' and patientname = '$res11patientfullname' and patientvisitcode = '$res11visitcode'";
		  $exec3 = mysql_query($query3) or die ("Error in Query3". mysql_error());
		  $res3= mysql_fetch_array($exec3);
		  $res3servicesitemrate = $res3['servicesitemrate1'];
		  
		  if($res3servicesitemrate == '')
		  {
		  $res3servicesitemrate = '0.00';
		  }
		  else
		  {
		  $res3servicesitemrate = $res3['servicesitemrate1'];
		  $total4 = $total4 + $res3servicesitemrate;
		  $total6 = $total6 + $res3servicesitemrate;
		  $totalexts = $totalexts + $res3servicesitemrate;
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
                <div class="bodytext31"><?php echo $res11patientfullname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res11consultationdate; ?></div></td>
				   <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res11patientcode; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res11visitcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $billnumber; ?></td>
			   <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo "0.00"; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($res3labitemrate,2,'.',',');; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo "0.00"; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($res3radiologyitemrate,2,'.',',');; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res3servicesitemrate,2,'.',',');; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo "0.00"; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format('0.0',2,'.',','); ?></div></td>
			  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($totalexts,2,'.',','); ?></div></td>
			  </tr>
			<?php
		  }
			$totalcon = $totalcon + $totalconref;
			$totaladv = $totaladv + $totalipdep + $totaldepref;
			$totalipfinal = $totalipfinal + $totalipcredit;
			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				  <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong>Total:</strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totalcon,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($total1,2,'.',','); ?></strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($total2,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($total3,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($total4,2,'.',','); ?></strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($total5,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totaladv,2,'.',','); ?></strong></td>
					<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totalipfinal,2,'.',','); ?></strong></td>
				 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totalotcs,2,'.',','); ?></strong></td>
				<td  align="right" valign="center" 
                bgcolor="#cccccc" class="bodytext31"><strong><?php echo number_format($total6,2,'.',','); ?></strong></td>
				 <?php if($total6 != 0)
			 { 
			  ?>	 
				 <?php
		      }
		   ?>
			</tr>
          </tbody>
        </table></td>
      </tr>
	  
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
