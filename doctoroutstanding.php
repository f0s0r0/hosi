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
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$range = "";

//This include updatation takes too long to load for hunge items database.
//include ("autocompletebuild_account2.php");

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
if (isset($_REQUEST["searchsuppliercode"])) { $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }
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
.ui-menu .ui-menu-item{ zoom: 1 !important;}
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}

</style>
<link href="autocomplete.css" rel="stylesheet">
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>

<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script>
function funcAccount()
{
if((document.getElementById("searchsuppliername").value == "")||(document.getElementById("searchsuppliername").value == " "))
{
alert('Please Select Account Name');
return false;
}
}
$(document).ready(function($){
    $('#searchsuppliername').autocomplete({
		
	
	source:"ajaxdoctornewserach.php",
	//alert(source);
	matchContains: true,
	minLength:1,
	html: true, 
		select: function(event,ui){
			var code = ui.item.customercode;
			$("#searchsuppliercode").val(code);
			
			},
    });
});
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
		
		
              <form name="cbform1" method="post" action="doctoroutstanding.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#CCCCCC" class="bodytext3"><strong>Doctor Outstanding</strong></td>
              </tr>
            <!--<tr>
              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
			  <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Payment Entry" /> 
                *To Print Other Receipts Please Go To Menu:	Reports	-&gt; Payments Given 
				</td>
              </tr>-->
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
              <input type="hidden" name="subcode" value="<?php echo $searchsuppliercode; ?>">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input type="submit" onClick="return funcAccount();" value="Search" name="Submit" />
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1200" 
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
              <td width="9%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>
              <td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Description </strong></td>
              <td width="20%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Debit</strong></td>
              <td width="16%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Credit</strong></div></td>
				<td width="16%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Days</strong></div></td>
				<td width="16%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Current Balance</strong></div></td>
            </tr>
			<?php
			
				$openingcreditamount = 0;
				$openingdebittamount = 0;
			 $query81 = "select * from billing_paynow where referalname = '$searchsuppliername' and billstatus='paid' and billdate < '$ADate1' and doctorstatus='unpaid'";
			 $exec81 = mysql_query($query81) or die(mysql_error());
			 while($res81 = mysql_fetch_array($exec81))
			 {
				 $res81visitcode = $res81['visitcode'];
				 $query123="select * from consultation_referal where patientvisitcode='$res81visitcode' and referalname ='$arraysuppliername'";
				 $exec123=mysql_query($query123) or die(mysql_error());
				 while($res123 = mysql_fetch_array($exec123))
				 {
					 $paynowamount = $res123['referalrate'];
					 $openingcreditamount = $openingcreditamount + $paynowamount;
				 }
			 }
			 $query82 = "select * from billing_paylater where referalname = '$searchsuppliername' and billdate < '$ADate1' and doctorstatus='unpaid'";
			 $exec82 = mysql_query($query82) or die(mysql_error());
			 while($res82 = mysql_fetch_array($exec82))
			 {
				 $res82visitcode = $res82['visitcode'];
				 $query124="select * from consultation_referal where patientvisitcode='$res82visitcode' and referalname ='$arraysuppliername'";
				 $exec124=mysql_query($query124) or die(mysql_error());
				 while($res124 = mysql_fetch_array($exec124))
				 {
					 $paylateramount = $res124['referalrate'];
					 $openingcreditamount = $openingcreditamount + $paylateramount;
				 }
			 }
			 $query83 = "select * from billing_ipprivatedoctor where description='$searchsuppliername' and recorddate < '$ADate1' and doctorstatus='unpaid'";
			 $exec83 = mysql_query($query83) or die(mysql_error());
			 while($res83 = mysql_fetch_array($exec83))
			 {
				 $ipamount = $res83['amount'];
				 $openingcreditamount = $openingcreditamount + $ipamount;
			 }
			 $query51 = "select * from paymentmodecredit where source = 'doctorpaymententry' and billdate < '$ADate1' group by billnumber";
			 $exec51 = mysql_query($query51) or die ("Error in Query5".mysql_error());
			  //echo $num = mysql_num_rows($exec3);
			 while ($res51 = mysql_fetch_array($exec51))
			 {
				  $paymentdocno = $res51['billnumber'];
				  $res5transactionamount = $res51['transactionamount'];
				  $res5transactiondate = $res51['billdate'];
				  
				  $query15 = "select * from master_transactiondoctor where doctorcode = '$searchsuppliercode' and transactiondate < '$ADate1' and transactionmodule = 'PAYMENT' and docno ='$paymentdocno' and billstatus = 'unpaid' and recordstatus <> 'deallocated'  order by transactiondate desc";
				  $exec15 = mysql_query($query15) or die ("Error in Query5".mysql_error());
				  $num15 = mysql_num_rows($exec15);
				  if($num15 > 0)
				  {				  
				  	$openingdebittamount = $openingdebittamount + $res5transactionamount;
				  }
				}
			 
		
			 $openingbalance = $openingcreditamount - $openingdebittamount;
		  ?>
			<tr>
			<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc"><strong>&nbsp;</strong></td>
				
              <td width="9%" align="left" valign="center"  
                bgcolor="#cccccc" class="bodytext31"><div align="left"><strong>&nbsp;</strong></div></td>
              <td width="35%" align="left" valign="center"  
                bgcolor="#cccccc" class="bodytext31"><strong> Opening Balance </strong></td>
              <td width="20%" align="right" valign="center"  
                bgcolor="#cccccc" class="bodytext31"><strong>&nbsp;</strong></td>
              <td width="16%" align="left" valign="center"  
                bgcolor="#cccccc" class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
			 <td width="16%" align="left" valign="center"  
                bgcolor="#cccccc" class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>	
				<td width="16%" align="left" valign="center"  
                bgcolor="#cccccc" class="bodytext31"><div align="right"><strong><?php echo number_format($openingbalance,2,'.',''); ?></strong></div></td>
			</tr>
			<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			$query21 = "select accountname from master_transactiondoctor where accountname = '$searchsuppliername' and transactiondate between '$ADate1' and '$ADate2' and billstatus = 'unpaid' group by accountname order by accountname desc ";
			$exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
			while ($res21 = mysql_fetch_array($exec21))
			{
			$res21accountname = $res21['accountname'];
			

			if( $res21accountname != '')
			{
			?>
			<tr bgcolor="#ffffff">
            <td colspan="15"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong><?php echo $res21accountname;?> (Date From: <?php echo $ADate1; ?> Date To: <?php echo $ADate2; ?>)</strong></td>
            </tr>
			
			<?php
			
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			$totalamount30 = 0;
			$totalamount60 = 0;
			$totalamount90 = 0;
			$totalamount120 = 0;
			$totalamount180 = 0;
			$totalamountgreater = 0;
			
		  
		      
		  /*$query2 = "select * from master_transactiondoctor where accountname = '$res21accountname' and transactiondate between '$ADate1' and '$ADate2' and billstatus = 'unpaid' order by accountname desc";
		  $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		  while ($res2 = mysql_fetch_array($exec2))
		  {
		  $totalpayment = 0;
     	  $res2transactiondate = $res2['transactiondate'];
	      $res2patientname = $res2['patientname'];
		  $res2visitcode = $res2['visitcode'];
		  $res2billnumber = $res2['billnumber'];
		  $res2transactionamount = $res2['transactionamount'];
		  $res2patientcode = $res2['patientcode'];
		  
		  
		  $query98 = "select transactionamount from master_transactiondoctor where visitcode='$res2visitcode' and transactiontype = 'PAYMENT' and billnumber='$res2billnumber'";
		  $exec98 = mysql_query($query98) or die(mysql_error());
		  $num98 = mysql_num_rows($exec98);
		  while($res98 = mysql_fetch_array($exec98))
		  {
			  $payment = $res98['transactionamount'];
			  $totalpayment = $totalpayment + $payment;
		  }
		  $resamount = $res2transactionamount - $totalpayment;
		  if($resamount > 0)
		  {
		  $snocount = $snocount + 1;
		  $t1 = strtotime("$ADate2");
		  $t2 = strtotime("$res2transactiondate");
		  $days_between = ceil(abs($t1 - $t2) / 86400);
		 
		  
		  if($snocount == 1)
		  {
		  	$total = $openingbalance + $resamount;
		  }
		  else
		  {
		  	$total = $total + $resamount;
		  }
		
		  
		  if($days_between <= 30)
		  {
			  if($snocount == 1)
			  {
				$totalamount30 = $openingbalance + $resamount;
			  }
			  else
			  {
				 $totalamount30 = $totalamount30 + $resamount;
			  }
		  }
		  else if(($days_between >30) && ($days_between <=60))
		  {
			  if($snocount == 1)
			  {
			  	$totalamount60 = $openingbalance + $resamount;
			  }
			  else
			  {
			 	 $totalamount60 = $totalamount60 + $resamount;
			  }
		  }
		  else if(($days_between >60) && ($days_between <=90))
		  {
			  if($snocount == 1)
			  {
			 	 $totalamount90 = $openingbalance + $resamount;
			  }
			  else
			  {
			 	 $totalamount90 = $totalamount90 + $resamount;
			  }
		  }
		  else if(($days_between >90) && ($days_between <=120))
		  {
			  if($snocount == 1)
			  {
			  	$totalamount120 = $openingbalance + $resamount;
			  }
			  else
			  {
			  	$totalamount120 = $totalamount120 + $resamount;
			  }
		  }
		  else if(($days_between >120) && ($days_between <=180))
		  {
			if($snocount == 1)
			{
				$totalamount180 = $openingbalance + $resamount;
			}
			else
			{
				$totalamount180 = $totalamount180 + $resamount;
			}
		  }
		  else
		  {
		      if($snocount == 1)
			  {
			 	 $totalamountgreater = $openingbalance + $resamount;
			  }
			  else
			  {
			  	$totalamountgreater = $totalamountgreater + $resamount;
			  }
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
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2patientname; ?> (<?php echo $res2patientcode; ?>, <?php echo $res2visitcode; ?>, <?php echo $res2billnumber; ?>)</div></td>
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($resamount,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php //echo $days_between; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $days_between; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>
           </tr>
			<?php
			}
			}*/
			$cashamount21 = '';
			$cardamount21 = '';
			$onlineamount21 = '';
			$chequeamount21 = '';
			$tdsamount21 = '';
			$taxamount21 = '';
			$writeoffamount21 = '';
			$totalnumbr='';
			$totalnumb=0;
			$query2 = "select patientname,patientcode,visitcode,billno,billdate,referalname,auto_number from billing_paylater where referalname='$searchsuppliername' and billstatus='paid' and doctorstatus='unpaid' and billdate between '$ADate1' and '$ADate2'";
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			$rowcount2 = mysql_num_rows($exec2);
			//echo $rowcount2;
			while ($res2 = mysql_fetch_array($exec2))
			{
				$res2patientname = $res2['patientname'];
				$res2patientcode = $res2['patientcode'];
				$res2res2visitcode = $res2['visitcode'];				
				$res2res2billnumber = $res2['billno'];
				$res2transactiondate = $res2['billdate'];
				$res2referalname=$res2['referalname'];
				$billautonumber=$res2['auto_number'];
				
				$query76="select consultationfees from master_doctor where doctorname='$res2referalname'";
				$exec76=mysql_query($query76) or die(mysql_error());
				$res76=mysql_fetch_array($exec76);
				$res2transactionamount = $res76['consultationfees'];
				
				
				
				$query3 = "select cashamount,onlineamount,creditamount,chequeamount,cardamount,tdsamount,writeoffamount from master_transactiondoctor where billnumber = '$res2billnumber' and companyanum='$companyanum' and recordstatus = '' and billautonumber='$billautonumber'";
				$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
				$numb=mysql_num_rows($exec3);				
				while ($res3 = mysql_fetch_array($exec3))
				{
					//echo $res3['auto_number'];
					$cashamount1 = $res3['cashamount'];
					$onlineamount1 = $res3['onlineamount'];
					$creditamount1 = $res3['creditamount'];
					$chequeamount1 = $res3['chequeamount'];
					$cardamount1 = $res3['cardamount'];	
					$tdsamount1 = $res3['tdsamount'];
					$writeoffamount1 = $res3['writeoffamount'];					
					$cashamount21 = $cashamount21 + $cashamount1;
					$cardamount21 = $cardamount21 + $cardamount1;
					$onlineamount21 = $onlineamount21 + $onlineamount1;
					$chequeamount21 = $chequeamount21 + $chequeamount1;
					$tdsamount21 = $tdsamount21 + $tdsamount1;
					$writeoffamount21 = $writeoffamount21 + $writeoffamount1;
					
					
				}
			
				$totalpayment = $cashamount21 + $chequeamount21 + $onlineamount21 + $cardamount21;
				//$netpayment = $totalpayment;
				//$balanceamount = $billtotalamount - $netpayment;
					

				$resamount = $res2transactionamount - $totalpayment;
			  if($resamount > 0)
			  {
			  $snocount = $snocount + 1;
			  $t1 = strtotime("$ADate2");
			  $t2 = strtotime("$res2transactiondate");
			  $days_between = ceil(abs($t1 - $t2) / 86400);
			 
			  
			  if($snocount == 1)
			  {
				$total = $openingbalance + $resamount;
			  }
			  else
			  {
				$total = $total + $resamount;
			  }
			
			  
			  if($days_between <= 30)
			  {
				  if($snocount == 1)
				  {
					$totalamount30 = $openingbalance + $resamount;
				  }
				  else
				  {
					 $totalamount30 = $totalamount30 + $resamount;
				  }
			  }
			  else if(($days_between >30) && ($days_between <=60))
			  {
				  if($snocount == 1)
				  {
					$totalamount60 = $openingbalance + $resamount;
				  }
				  else
				  {
					 $totalamount60 = $totalamount60 + $resamount;
				  }
			  }
			  else if(($days_between >60) && ($days_between <=90))
			  {
				  if($snocount == 1)
				  {
					 $totalamount90 = $openingbalance + $resamount;
				  }
				  else
				  {
					 $totalamount90 = $totalamount90 + $resamount;
				  }
			  }
			  else if(($days_between >90) && ($days_between <=120))
			  {
				  if($snocount == 1)
				  {
					$totalamount120 = $openingbalance + $resamount;
				  }
				  else
				  {
					$totalamount120 = $totalamount120 + $resamount;
				  }
			  }
			  else if(($days_between >120) && ($days_between <=180))
			  {
				if($snocount == 1)
				{
					$totalamount180 = $openingbalance + $resamount;
				}
				else
				{
					$totalamount180 = $totalamount180 + $resamount;
				}
			  }
			  else
			  {
				  if($snocount == 1)
				  {
					 $totalamountgreater = $openingbalance + $resamount;
				  }
				  else
				  {
					$totalamountgreater = $totalamountgreater + $resamount;
				  }
			  }
	
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
					<div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
					<div class="bodytext31"><?php echo $suppliername1; ?> (<?php echo $patientcode; ?>, <?php echo $visitcode; ?>, <?php echo $res2billnumber; ?>)</div></td>
				  <td class="bodytext31" valign="center"  align="right">0
				  </td>
				  <td class="bodytext31" valign="center"  align="left">
					<div align="right"><?php echo number_format($resamount,2,'.',','); ?></div></td>
					<td class="bodytext31" valign="center"  align="left">
					<div align="center"><?php echo $days_between; ?></div></td>
				   <td class="bodytext31" valign="center"  align="left">
					<div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>
			   </tr>
				<?php
					//$totalbalance = $totalbalance + $balanceamount;
					}
					$cashamount21 = '0.00';
					$cardamount21 = '0.00';
					$onlineamount21 = '0.00';
					$chequeamount21 = '0.00';
					$tdsamount21 = '0.00';
					$writeoffamount21 = '0.00';
					$taxamount21 = '0.00';
	
					$totalpayment = '0.00';
					$netpayment = '0.00';
					$balanceamount = '0.00';
					
					$billtotalamount = '0.00';
					$netpayment = '0.00';
					$balanceamount = '0.00';
					
					$billstatus = '0.00';
				}
			
			?>
			
			<?php
				
			$cashamount21 = '';
			$cardamount21 = '';
			$onlineamount21 = '';
			$chequeamount21 = '';
			$tdsamount21 = '';
			$writeoffamount21 = '';
			$taxamount21 = '';
			$totalnumbr='';
			$totalnumb=0;
			$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			$totalpurchase1=0;
			$colorloopcount=0;
			if (isset($_REQUEST["showbilltype"])) { $showbilltype = $_REQUEST["showbilltype"]; } else { $showbilltype = ""; }
			if ($showbilltype == 'All Bills')
			{
				$showbilltype = '';
			}			
			
				
				//echo $number;
	
			$query2 = "select patientname,patientcode,visitcode,billno,billdate,referalname,auto_number from billing_paynow where referalname='$searchsuppliername' and billstatus='paid' and doctorstatus='unpaid' and billdate between '$ADate1' and '$ADate2'";
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			$rowcount2 = mysql_num_rows($exec2);
			//echo $rowcount2;
			while ($res2 = mysql_fetch_array($exec2))
			{
				$res2patientname = $res2['patientname'];
				$res2patientcode = $res2['patientcode'];
				$res2visitcode = $res2['visitcode'];				
				$res2billnumber = $res2['billno'];
				$res2transactiondate = $res2['billdate'];
				$res2referalname=$res2['referalname'];
				$billautonumber=$res2['auto_number'];
				$query77="select consultationfees from master_doctor where doctorname='$res2referalname'";
				$exec77=mysql_query($query77) or die(mysql_error());
				$res77=mysql_fetch_array($exec77);
				$res2transactionamount = $res77['consultationfees'];
				
				$query3 = "select cashamount,onlineamount,creditamount,chequeamount,cardamount,tdsamount,writeoffamount from master_transactiondoctor where billnumber = '$res2billnumber' and companyanum='$companyanum' and recordstatus = '' and billautonumber='$billautonumber'";
				$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
				$numb=mysql_num_rows($exec3);				
				while ($res3 = mysql_fetch_array($exec3))
				{
					//echo $res3['auto_number'];
					$cashamount1 = $res3['cashamount'];
					$onlineamount1 = $res3['onlineamount'];
					$creditamount1 = $res3['creditamount'];
					$chequeamount1 = $res3['chequeamount'];
					$cardamount1 = $res3['cardamount'];	
					$tdsamount1 = $res3['tdsamount'];
					$writeoffamount1 = $res3['writeoffamount'];					
					$cashamount21 = $cashamount21 + $cashamount1;
					$cardamount21 = $cardamount21 + $cardamount1;
					$onlineamount21 = $onlineamount21 + $onlineamount1;
					$chequeamount21 = $chequeamount21 + $chequeamount1;
					$tdsamount21 = $tdsamount21 + $tdsamount1;
					$writeoffamount21 = $writeoffamount21 + $writeoffamount1;
					
					
				}
			
				$totalpayment = $cashamount21 + $chequeamount21 + $onlineamount21 + $cardamount21;
				
				
				
			
			
				//echo $balanceamount;
				$resamount = $res2transactionamount - $totalpayment;
		  if($resamount > 0)
		  {
		  $snocount = $snocount + 1;
		  $t1 = strtotime("$ADate2");
		  $t2 = strtotime("$res2transactiondate");
		  $days_between = ceil(abs($t1 - $t2) / 86400);
		 
		  
		  if($snocount == 1)
		  {
		  	$total = $openingbalance + $resamount;
		  }
		  else
		  {
		  	$total = $total + $resamount;
		  }
		
		  
		  if($days_between <= 30)
		  {
			  if($snocount == 1)
			  {
				$totalamount30 = $openingbalance + $resamount;
			  }
			  else
			  {
				 $totalamount30 = $totalamount30 + $resamount;
			  }
		  }
		  else if(($days_between >30) && ($days_between <=60))
		  {
			  if($snocount == 1)
			  {
			  	$totalamount60 = $openingbalance + $resamount;
			  }
			  else
			  {
			 	 $totalamount60 = $totalamount60 + $resamount;
			  }
		  }
		  else if(($days_between >60) && ($days_between <=90))
		  {
			  if($snocount == 1)
			  {
			 	 $totalamount90 = $openingbalance + $resamount;
			  }
			  else
			  {
			 	 $totalamount90 = $totalamount90 + $resamount;
			  }
		  }
		  else if(($days_between >90) && ($days_between <=120))
		  {
			  if($snocount == 1)
			  {
			  	$totalamount120 = $openingbalance + $resamount;
			  }
			  else
			  {
			  	$totalamount120 = $totalamount120 + $resamount;
			  }
		  }
		  else if(($days_between >120) && ($days_between <=180))
		  {
			if($snocount == 1)
			{
				$totalamount180 = $openingbalance + $resamount;
			}
			else
			{
				$totalamount180 = $totalamount180 + $resamount;
			}
		  }
		  else
		  {
		      if($snocount == 1)
			  {
			 	 $totalamountgreater = $openingbalance + $resamount;
			  }
			  else
			  {
			  	$totalamountgreater = $totalamountgreater + $resamount;
			  }
		  }
	
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
	
				//if ($balanceamount != 0.00)
				//{
				?>
				<tr <?php echo $colorcode; ?>>
				  <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
				   <td class="bodytext31" valign="center"  align="left">
					<div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
					<div class="bodytext31"><?php echo $res2patientname; ?> (<?php echo $res2patientcode; ?>, <?php echo $res2visitcode; ?>, <?php echo $res2billnumber; ?>)</div></td>
				  <td class="bodytext31" valign="center"  align="right">
                  0
				 </td>
				  <td class="bodytext31" valign="center"  align="left">
					<div align="right"><?php echo number_format($resamount,2,'.',','); ?></div></td>
					<td class="bodytext31" valign="center"  align="left">
					<div align="center"><?php echo $days_between; ?></div></td>
				   <td class="bodytext31" valign="center"  align="left">
					<div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>
			   </tr>
				<?php
					//$totalbalance = $totalbalance+ $balanceamount;
				}
				$cashamount21 = '0.00';
				$cardamount21 = '0.00';
				$onlineamount21 = '0.00';
				$chequeamount21 = '0.00';
				$tdsamount21 = '0.00';
				$writeoffamount21 = '0.00';
				$taxamount21 = '0.00';

				$totalpayment = '0.00';
				$netpayment = '0.00';
				$balanceamount = '0.00';
				
				$billtotalamount = '0.00';
				$netpayment = '0.00';
				$balanceamount = '0.00';
				
				$billstatus = '0.00';
			}
			
			
			$query212 = "select patientname,patientcode,visitcode,docno,recorddate,description,amount,auto_number from billing_ipprivatedoctor where description='$searchsuppliername' and billstatus='paid' and doctorstatus='unpaid' and recorddate between '$ADate1' and '$ADate2'";
			
			$exec212 = mysql_query($query212) or die ("Error in Query2".mysql_error());
			$rowcount2 = mysql_num_rows($exec212);
			//echo $rowcount2;
			while ($res212 = mysql_fetch_array($exec212))
			{
				$res2patientname = $res212['patientname'];
				$res2patientcode = $res212['patientcode'];
				$res2visitcode = $res212['visitcode'];
				$res2billnumber = $res212['docno'];
				$res2transactiondate = $res212['recorddate'];
				$res2referalname=$res212['description'];				
				$res2transactionamount = $res212['amount'];
				$billautonumber=$res212['auto_number'];
				
				
				$query3 = "select cashamount,onlineamount,creditamount,chequeamount,cardamount,tdsamount,writeoffamount from master_transactiondoctor where billnumber = '$res2billnumber' and companyanum='$companyanum' and recordstatus = '' and billautonumber='$billautonumber'";
				$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
				$numb=mysql_num_rows($exec3);				
				while ($res3 = mysql_fetch_array($exec3))
				{
					//echo $res3['auto_number'];
					$cashamount1 = $res3['cashamount'];
					$onlineamount1 = $res3['onlineamount'];
					$creditamount1 = $res3['creditamount'];
					$chequeamount1 = $res3['chequeamount'];
					$cardamount1 = $res3['cardamount'];	
					$tdsamount1 = $res3['tdsamount'];
					$writeoffamount1 = $res3['writeoffamount'];					
					$cashamount21 = $cashamount21 + $cashamount1;
					$cardamount21 = $cardamount21 + $cardamount1;
					$onlineamount21 = $onlineamount21 + $onlineamount1;
					$chequeamount21 = $chequeamount21 + $chequeamount1;
					$tdsamount21 = $tdsamount21 + $tdsamount1;
					$writeoffamount21 = $writeoffamount21 + $writeoffamount1;
					
					
				}
			
				$totalpayment = $cashamount21 + $chequeamount21 + $onlineamount21 + $cardamount21;
				//$netpayment = $totalpayment + $tdsamount21 + $writeoffamount21;
				//$balanceamount = $billtotalamount - $netpayment;
				

				//echo $balanceamount;
				$resamount = $res2transactionamount - $totalpayment;
		  if($resamount > 0)
		  {
		  $snocount = $snocount + 1;
		  $t1 = strtotime("$ADate2");
		  $t2 = strtotime("$res2transactiondate");
		  $days_between = ceil(abs($t1 - $t2) / 86400);
		 
		  
		  if($snocount == 1)
		  {
		  	$total = $openingbalance + $resamount;
		  }
		  else
		  {
		  	$total = $total + $resamount;
		  }
		
		  
		  if($days_between <= 30)
		  {
			  if($snocount == 1)
			  {
				$totalamount30 = $openingbalance + $resamount;
			  }
			  else
			  {
				 $totalamount30 = $totalamount30 + $resamount;
			  }
		  }
		  else if(($days_between >30) && ($days_between <=60))
		  {
			  if($snocount == 1)
			  {
			  	$totalamount60 = $openingbalance + $resamount;
			  }
			  else
			  {
			 	 $totalamount60 = $totalamount60 + $resamount;
			  }
		  }
		  else if(($days_between >60) && ($days_between <=90))
		  {
			  if($snocount == 1)
			  {
			 	 $totalamount90 = $openingbalance + $resamount;
			  }
			  else
			  {
			 	 $totalamount90 = $totalamount90 + $resamount;
			  }
		  }
		  else if(($days_between >90) && ($days_between <=120))
		  {
			  if($snocount == 1)
			  {
			  	$totalamount120 = $openingbalance + $resamount;
			  }
			  else
			  {
			  	$totalamount120 = $totalamount120 + $resamount;
			  }
		  }
		  else if(($days_between >120) && ($days_between <=180))
		  {
			if($snocount == 1)
			{
				$totalamount180 = $openingbalance + $resamount;
			}
			else
			{
				$totalamount180 = $totalamount180 + $resamount;
			}
		  }
		  else
		  {
		      if($snocount == 1)
			  {
			 	 $totalamountgreater = $openingbalance + $resamount;
			  }
			  else
			  {
			  	$totalamountgreater = $totalamountgreater + $resamount;
			  }
		  }
	
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
					<div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
					<div class="bodytext31"><?php echo $res2patientname; ?> (<?php echo $res2patientcode; ?>, <?php echo $res2visitcode; ?>, <?php echo $res2billnumber; ?>)</div></td>
				  <td class="bodytext31" valign="center"  align="right">0
				  </td>
				  <td class="bodytext31" valign="center"  align="left">
					<div align="right"><?php echo number_format($resamount,2,'.',','); ?></div></td>
					<td class="bodytext31" valign="center"  align="left">
					<div align="center"><?php echo $days_between; ?></div></td>
				   <td class="bodytext31" valign="center"  align="left">
					<div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>
			   </tr>
				<?php
					//$totalbalance = $totalbalance + $balanceamount;
					}
						$cashamount21 = '0.00';
					$cardamount21 = '0.00';
					$onlineamount21 = '0.00';
					$chequeamount21 = '0.00';
					$tdsamount21 = '0.00';
					$writeoffamount21 = '0.00';
					$taxamount21 = '0.00';
	
					$totalpayment = '0.00';
					$netpayment = '0.00';
					$balanceamount = '0.00';
					
					$billtotalamount = '0.00';
					$netpayment = '0.00';
					$balanceamount = '0.00';
					
					$billstatus = '0.00';
				}
			?>
			
			<?php
			$query411 = "select patientfullname,patientcode,visitcode,consultingdoctor,auto_number from master_visitentry where consultingdoctor='$searchsuppliername' and billtype = 'PAY NOW'";
			//$query2 = "select * from master_transaction where transactiontype = 'PAYMENT' and transactionmode <> 'CREDIT' and transactionmodule = 'SALES' and billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = ''";
			$exec411 = mysql_query($query411) or die ("Error in Query2".mysql_error());
			$rowcount2 = mysql_num_rows($exec411);
			//echo $rowcount2;
			while ($res411 = mysql_fetch_array($exec411))
			{
				$res2patientname = $res411['patientfullname'];
				$res2patientcode = $res411['patientcode'];
				$res2visitcode = $res411['visitcode'];				
				$res2referalname=$res411['consultingdoctor'];
				$billautonumber=$res411['auto_number'];
				$query29 = "select billnumber,billdate,consultation from billing_consultation where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' and billdate between '$ADate1' and '$ADate2'";
				$exec29 = mysql_query($query29) or die ("Error in Query29".mysql_error());
				while($res29 = mysql_fetch_array($exec29))
				{
				$res2billnumber = $res29['billnumber'];
				$res2transactiondate = $res29['billdate'];
				$res2transactionamount = $res29['consultation'];
				
				
				
				$query3 = "select cashamount,onlineamount,creditamount,chequeamount,cardamount,tdsamount,writeoffamount from master_transactiondoctor where billnumber = '$res2billnumber' and companyanum='$companyanum' and recordstatus = '' and billautonumber='$billautonumber'";
				$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
				$numb=mysql_num_rows($exec3);				
				while ($res3 = mysql_fetch_array($exec3))
				{
					//echo $res3['auto_number'];
					$cashamount1 = $res3['cashamount'];
					$onlineamount1 = $res3['onlineamount'];
					$creditamount1 = $res3['creditamount'];
					$chequeamount1 = $res3['chequeamount'];
					$cardamount1 = $res3['cardamount'];	
					$tdsamount1 = $res3['tdsamount'];
					$writeoffamount1 = $res3['writeoffamount'];					
					$cashamount21 = $cashamount21 + $cashamount1;
					$cardamount21 = $cardamount21 + $cardamount1;
					$onlineamount21 = $onlineamount21 + $onlineamount1;
					$chequeamount21 = $chequeamount21 + $chequeamount1;
					$tdsamount21 = $tdsamount21 + $tdsamount1;
					$writeoffamount21 = $writeoffamount21 + $writeoffamount1;
					
					
				}
			
				$totalpayment = $cashamount21 + $chequeamount21 + $onlineamount21 + $cardamount21;
				//$netpayment = $totalpayment + $tdsamount21 + $writeoffamount21;
				//$balanceamount = $res2transactionamount - $netpayment;
				
				
				
			//echo $balanceamount;
			$resamount = $res2transactionamount - $totalpayment;
		  if($resamount > 0)
		  {
		  $snocount = $snocount + 1;
		  $t1 = strtotime("$ADate2");
		  $t2 = strtotime("$res2transactiondate");
		  $days_between = ceil(abs($t1 - $t2) / 86400);
		 
		  
		  if($snocount == 1)
		  {
		  	$total = $openingbalance + $resamount;
		  }
		  else
		  {
		  	$total = $total + $resamount;
		  }
		
		  
		  if($days_between <= 30)
		  {
			  if($snocount == 1)
			  {
				$totalamount30 = $openingbalance + $resamount;
			  }
			  else
			  {
				 $totalamount30 = $totalamount30 + $resamount;
			  }
		  }
		  else if(($days_between >30) && ($days_between <=60))
		  {
			  if($snocount == 1)
			  {
			  	$totalamount60 = $openingbalance + $resamount;
			  }
			  else
			  {
			 	 $totalamount60 = $totalamount60 + $resamount;
			  }
		  }
		  else if(($days_between >60) && ($days_between <=90))
		  {
			  if($snocount == 1)
			  {
			 	 $totalamount90 = $openingbalance + $resamount;
			  }
			  else
			  {
			 	 $totalamount90 = $totalamount90 + $resamount;
			  }
		  }
		  else if(($days_between >90) && ($days_between <=120))
		  {
			  if($snocount == 1)
			  {
			  	$totalamount120 = $openingbalance + $resamount;
			  }
			  else
			  {
			  	$totalamount120 = $totalamount120 + $resamount;
			  }
		  }
		  else if(($days_between >120) && ($days_between <=180))
		  {
			if($snocount == 1)
			{
				$totalamount180 = $openingbalance + $resamount;
			}
			else
			{
				$totalamount180 = $totalamount180 + $resamount;
			}
		  }
		  else
		  {
		      if($snocount == 1)
			  {
			 	 $totalamountgreater = $openingbalance + $resamount;
			  }
			  else
			  {
			  	$totalamountgreater = $totalamountgreater + $resamount;
			  }
		  }

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
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2patientname; ?> (<?php echo $res2patientcode; ?>, <?php echo $res2visitcode; ?>, <?php echo $res2billnumber; ?>)</div></td>
              <td class="bodytext31" valign="center"  align="right">0
			  </td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($resamount,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $days_between; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>
           </tr>
            <?php
				//$totalbalance = $totalbalance + $balanceamount;
				}
				}
					$cashamount21 = '0.00';
				$cardamount21 = '0.00';
				$onlineamount21 = '0.00';
				$chequeamount21 = '0.00';
				$tdsamount21 = '0.00';
				$writeoffamount21 = '0.00';
				$taxamount21 = '0.00';

				$totalpayment = '0.00';
				$netpayment = '0.00';
				$balanceamount = '0.00';
				
				$billtotalamount = '0.00';
				$netpayment = '0.00';
				$balanceamount = '0.00';
				
				$billstatus = '0.00';
			}
			?>
			
			<?php
			$query412 = "select patientfullname,patientcode,visitcode,consultingdoctor,auto_number from master_visitentry where consultingdoctor='$searchsuppliername' and billtype = 'PAY LATER'";
			//$query2 = "select * from master_transaction where transactiontype = 'PAYMENT' and transactionmode <> 'CREDIT' and transactionmodule = 'SALES' and billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = ''";
			$exec412 = mysql_query($query412) or die ("Error in Query2".mysql_error());
			$rowcount2 = mysql_num_rows($exec412);
			//echo $rowcount2;
			while ($res412 = mysql_fetch_array($exec412))
			{
				$res2patientname = $res412['patientfullname'];
				$res2patientcode = $res412['patientcode'];
				$res2visitcode = $res412['visitcode'];
				$res2referalname=$res412['consultingdoctor'];
				$billautonumber=$res412['auto_number'];
				
				$query30 = "select billno,billdate,totalamount from billing_paylaterconsultation where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and billdate between '$ADate1' and '$ADate2'";
				$exec30 = mysql_query($query30) or die ("Error in Query30".mysql_error());
				while($res30 = mysql_fetch_array($exec30))
				{
				$res2billnumber = $res30['billno'];
				$res2transactiondate = $res30['billdate'];
				$res2transactionamount = $res30['totalamount'];
				
				
				
				$query3 = "select cashamount,onlineamount,creditamount,chequeamount,cardamount,tdsamount,writeoffamount from master_transactiondoctor where billnumber = '$res2billnumber' and companyanum='$companyanum' and recordstatus = '' and billautonumber='$billautonumber'";
				$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
				$numb=mysql_num_rows($exec3);				
				while ($res3 = mysql_fetch_array($exec3))
				{
					//echo $res3['auto_number'];
					$cashamount1 = $res3['cashamount'];
					$onlineamount1 = $res3['onlineamount'];
					$creditamount1 = $res3['creditamount'];
					$chequeamount1 = $res3['chequeamount'];
					$cardamount1 = $res3['cardamount'];	
					$tdsamount1 = $res3['tdsamount'];
					$writeoffamount1 = $res3['writeoffamount'];					
					$cashamount21 = $cashamount21 + $cashamount1;
					$cardamount21 = $cardamount21 + $cardamount1;
					$onlineamount21 = $onlineamount21 + $onlineamount1;
					$chequeamount21 = $chequeamount21 + $chequeamount1;
					$tdsamount21 = $tdsamount21 + $tdsamount1;
					$writeoffamount21 = $writeoffamount21 + $writeoffamount1;
					
					
				}
			
				$totalpayment = $cashamount21 + $chequeamount21 + $onlineamount21 + $cardamount21;
				//$netpayment = $totalpayment + $tdsamount21 + $writeoffamount21;
				//$balanceamount = $res2transactionamount - $netpayment;
				
					
					
				//echo $balanceamount;
				$resamount = $res2transactionamount - $totalpayment;
		  if($resamount > 0)
		  {
		  $snocount = $snocount + 1;
		  $t1 = strtotime("$ADate2");
		  $t2 = strtotime("$res2transactiondate");
		  $days_between = ceil(abs($t1 - $t2) / 86400);
		 
		  
		  if($snocount == 1)
		  {
		  	$total = $openingbalance + $resamount;
		  }
		  else
		  {
		  	$total = $total + $resamount;
		  }
		
		  
		  if($days_between <= 30)
		  {
			  if($snocount == 1)
			  {
				$totalamount30 = $openingbalance + $resamount;
			  }
			  else
			  {
				 $totalamount30 = $totalamount30 + $resamount;
			  }
		  }
		  else if(($days_between >30) && ($days_between <=60))
		  {
			  if($snocount == 1)
			  {
			  	$totalamount60 = $openingbalance + $resamount;
			  }
			  else
			  {
			 	 $totalamount60 = $totalamount60 + $resamount;
			  }
		  }
		  else if(($days_between >60) && ($days_between <=90))
		  {
			  if($snocount == 1)
			  {
			 	 $totalamount90 = $openingbalance + $resamount;
			  }
			  else
			  {
			 	 $totalamount90 = $totalamount90 + $resamount;
			  }
		  }
		  else if(($days_between >90) && ($days_between <=120))
		  {
			  if($snocount == 1)
			  {
			  	$totalamount120 = $openingbalance + $resamount;
			  }
			  else
			  {
			  	$totalamount120 = $totalamount120 + $resamount;
			  }
		  }
		  else if(($days_between >120) && ($days_between <=180))
		  {
			if($snocount == 1)
			{
				$totalamount180 = $openingbalance + $resamount;
			}
			else
			{
				$totalamount180 = $totalamount180 + $resamount;
			}
		  }
		  else
		  {
		      if($snocount == 1)
			  {
			 	 $totalamountgreater = $openingbalance + $resamount;
			  }
			  else
			  {
			  	$totalamountgreater = $totalamountgreater + $resamount;
			  }
		  }
	
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
					<div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
					<div class="bodytext31"><?php echo $res2patientname; ?> (<?php echo $res2patientcode; ?>, <?php echo $res2visitcode; ?>, <?php echo $res2billnumber; ?>)</div></td>
				  <td class="bodytext31" valign="center"  align="right">0
				  </td>
				  <td class="bodytext31" valign="center"  align="left">
					<div align="right"><?php echo number_format($resamount,2,'.',','); ?></div></td>
					<td class="bodytext31" valign="center"  align="left">
					<div align="center"><?php echo $days_between; ?></div></td>
				   <td class="bodytext31" valign="center"  align="left">
					<div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>
			   </tr>
				<?php
					//$totalbalance = $totalbalance + $balanceamount;
				}
				}
				$cashamount21 = '0.00';
				$cardamount21 = '0.00';
				$onlineamount21 = '0.00';
				$chequeamount21 = '0.00';
				$tdsamount21 = '0.00';
				$writeoffamount21 = '0.00';
				$taxamount21 = '0.00';

				$totalpayment = '0.00';
				$netpayment = '0.00';
				$balanceamount = '0.00';
				
				$billtotalamount = '0.00';
				$netpayment = '0.00';
				$balanceamount = '0.00';
				
				$billstatus = '0.00';
			}
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
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
            </tr>
				 </tbody>
        </table></td>
      </tr>
	  
   
			<tr>
        <td>&nbsp;</td>
      </tr>
		
			<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 
            align="left" border="0">
			<tr>
              <td width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td  width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				<td  width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
					<td  width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
            
				<td  width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
            
            	 </tr>
						<tr>
               <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>30 days</strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>60 days</strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>90 days</strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>120 days</strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>180 days</strong></td>
           <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>180+ days</strong></td>
           
             	 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>Total Due</strong></td>
            </tr>
			<?php 
			$grandtotal = $totalamount30 + $totalamount60 + $totalamount90 + $totalamount120 + $totalamount180 + $totalamountgreater;
			?>
			<tr>
               <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#D3EEB7"><?php echo number_format($totalamount30,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#D3EEB7"><?php echo number_format($totalamount60,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#D3EEB7"><?php echo number_format($totalamount90,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#D3EEB7"><?php echo number_format($totalamount120,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#D3EEB7"><?php echo number_format($totalamount180,2,'.',','); ?></td>
            <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#D3EEB7"><?php echo number_format($totalamountgreater,2,'.',','); ?></td>
            
             	 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#D3EEB7"><?php echo number_format($grandtotal,2,'.',','); ?></td>
            </tr>
			
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
					<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
           <?php
				//$supp=mysql_real_escape_string($searchsuppliername);
				$urlpath = "cbfrmflag1=cbfrmflag1&&ADate1=$ADate1&&ADate2=$ADate2&&searchsuppliername=$searchsuppliercode";
			
			?>
             <td class="bodytext31" valign="center"  align="right"><a href="print_corporateoutstandingpdf.php?<?php echo $urlpath; ?>"><img  width="40" height="40" src="images/pdfdownload.jpg" style="cursor:pointer;"></a></td>   
		   	 <td class="bodytext31" valign="center"  align="right"><a href="print_corporateoutstanding.php?<?php echo $urlpath; ?>"><img  width="40" height="40" src="images/excel-xls-icon.png" style="cursor:pointer;"></a></td>
			        
               </tr>
			  </table>
			  
			<?php
			}
			}
			}
			?>
         
</table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
