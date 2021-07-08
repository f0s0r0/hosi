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
$ADate1 = "2014-01-01";
$ADate2 =  date('Y-m-d');

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
include ("autocompletebuild_account2.php");

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
<script>
function funcAccount()
{
if((document.getElementById("searchsuppliername").value == "")||(document.getElementById("searchsuppliername").value == " "))
{
alert('Please Select Account Name');
return false;
}
}
</script>
<script type="text/javascript" src="js/autocomplete_accounts2.js"></script>
<script type="text/javascript" src="js/autosuggest4accounts.js"></script>
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
		<form name="cbform1" method="post" action="nettpositions.php">
<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1200" 
            align="left" border="0">
          <tbody>
		   <tr>
   <td colspan="2"  align="left" valign="center" class="bodytext31"><strong>Nett Positions</strong></td>
</tr>
		  <?php
		  $query91 = "select sum(cash) as cashdebitamount from paymentmodedebit where billdate between '$ADate1' and '$ADate2'";
		  $exec91 = mysql_query($query91) or die(mysql_error());
		  $res91 = mysql_fetch_array($exec91);
		  $debitcashamount = $res91['cashdebitamount'];
		  
		  $query92 = "select sum(cash) as cashcreditamount from paymentmodecredit where billdate between '$ADate1' and '$ADate2'";
		  $exec92 = mysql_query($query92) or die(mysql_error());
		  $res92 = mysql_fetch_array($exec92);
		  $creditcashamount = $res92['cashcreditamount'];

		  $finalcashinhand = $debitcashamount - $creditcashamount;
		  
		  $query93 = "select sum(cheque) as chequedebitamount,sum(card) as carddebitamount,sum(mpesa) as mpesadebitamount,sum(online) as onlinedebitamount from paymentmodedebit where billdate between '$ADate1' and '$ADate2'";
		  $exec93 = mysql_query($query93) or die(mysql_error());
		  $res93 = mysql_fetch_array($exec93);
		  $chequedebitamount = $res93['chequedebitamount'];
		  $carddebitamount = $res93['carddebitamount'];
		  $mpesadebitamount = $res93['mpesadebitamount'];
		  $onlinedebitamount = $res93['onlinedebitamount'];
		  
		  $query94 = "select sum(cheque) as chequecreditamount,sum(card) as cardcreditamount,sum(mpesa) as mpesacreditamount,sum(online) as onlinecreditamount from paymentmodecredit where billdate between '$ADate1' and '$ADate2'";
		  $exec94 = mysql_query($query94) or die(mysql_error());
		  $res94 = mysql_fetch_array($exec94);
		  $chequecreditamount = $res94['chequecreditamount'];
		  $cardcreditamount = $res94['cardcreditamount'];
		  $mpesacreditamount = $res94['mpesacreditamount'];
		  $onlinecreditamount = $res94['onlinecreditamount'];
		  
		  $totalbankdebitamount = $chequedebitamount + $carddebitamount + $mpesadebitamount + $onlinedebitamount;
		  $totalbankcreditamount = $chequecreditamount + $cardcreditamount + $mpesacreditamount + $onlinecreditamount;
		  $finalbankamount = $totalbankdebitamount - $totalbankcreditamount;


		  ?>
		  
   <tr>
   <td width="108"  align="left" valign="center" class="bodytext31">Cash In Hand</td>
     <td width="812"  align="left" valign="center" class="bodytext31"><?php echo number_format($finalcashinhand,2,'.',','); ?></td>
     <td width="256"  align="left" valign="center" class="bodytext31">&nbsp;</td>
   </tr>
   <tr>
   <td width="108"  align="left" valign="center" class="bodytext31">Bank</td>
     <td width="812"  align="left" valign="center" class="bodytext31"><?php echo number_format($finalbankamount,2,'.',','); ?></td>
     <td width="256"  align="left" valign="center" class="bodytext31">&nbsp;</td>
   </tr>
 		
            
              <!--<input  value="Print Report" onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" />
&nbsp;				<input  value="Export Excel" onClick="javascript:printbillreport2()" name="resetbutton22" type="button" id="resetbutton22"  style="border: 1px solid #001E6A" />-->

          
			<?php
			
		  $query1 = "select sum(transactionamount) as transactionamount1 from master_transactionpaylater where accountname like '%$searchsuppliername%' and transactiontype = 'finalize' and transactiondate < '$ADate1'";
		  $exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		  $res1 = mysql_fetch_array($exec1);
		  $res1transactionamount1 = $res1['transactionamount1'];
		  
		  $query4 = "select sum(transactionamount) as transactionamount1 from master_transactionpaylater where accountname like '%$searchsuppliername%' and transactiontype = 'PAYMENT' and transactiondate < '$ADate1'";
		  $exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		  $res4 = mysql_fetch_array($exec4);
		  $res4transactionamount1 = $res4['transactionamount1'];	
		  
		  $openingbalance = $res1transactionamount1 - $res4transactionamount1;
		  ?>
		
			<?php
			
			
			$grandtotalamount30 = 0;
			$grandtotalamount60 = 0;
			$grandtotalamount90 = 0;
			$grandtotalamount120 = 0;
			$grandtotalamount180 = 0;
			$grandtotalamountgreater = 0;
			$query21 = "select * from master_transactionpaylater where accountname like '%$searchsuppliername%' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'finalize' group by accountname order by accountname desc ";
			$exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
			while ($res21 = mysql_fetch_array($exec21))
			{
			$res21accountname = $res21['accountname'];
			
			$query22 = "select * from master_accountname where accountname = '$res21accountname' and recordstatus <>'DELETED' ";
			$exec22 = mysql_query($query22) or die ("Error in Query22".mysql_error());
			$res22 = mysql_fetch_array($exec22);
			$res22accountname = $res22['accountname'];

			if( $res21accountname != '')
			{
			?>
					
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
			
		  
		      
		  $query2 = "select * from master_transactionpaylater where accountname like '%$res21accountname%' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'finalize' order by accountname desc";
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
		  
		  
		  $query98 = "select * from master_transactionpaylater where visitcode='$res2visitcode' and transactiontype = 'PAYMENT' and billnumber='$res2billnumber' and recordstatus = 'allocated'";
		  $exec98 = mysql_query($query98) or die(mysql_error());
		  $num98 = mysql_num_rows($exec98);
		  while($res98 = mysql_fetch_array($exec98))
		  {
		  $payment = $res98['transactionamount'];
		  $totalpayment = $totalpayment + $payment;
		  }
		 $resamount = $res2transactionamount - $totalpayment;
		  if($resamount != 0)
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
		
			}
			}
			?>
          <?php
			
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			
			
		      
		  $query3 = "select * from master_transactionpaylater where accountname like '$res21accountname' and transactiondate between '$ADate1' and '$ADate2' and transactionstatus = 'onaccount' order by accountname desc";
		  $exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
		 // echo $num3 = mysql_num_rows($exec3);
		  while ($res3 = mysql_fetch_array($exec3))
		  {
		  $totalonaccountpayment = 0;
     	  $res3transactiondate = $res3['transactiondate'];
	      $res3patientname = $res3['patientname'];
		  $res3patientcode = $res3['patientcode'];
		  $res3visitcode = $res3['visitcode'];
		  $res3billnumber = $res3['billnumber'];
		  $res3docno = $res3['docno'];
		  $res3transactionamount = $res3['transactionamount'];
		  $res3transactionmode = $res3['transactionmode'];
		  $res3transactionnumber = $res3['chequenumber'];
		  
		  $t1 = strtotime("$ADate2");
		  $t2 = strtotime("$res3transactiondate");
		  $days_between = ceil(abs($t1 - $t2) / 86400);
		  
		  $query67 = "select * from master_transactionpaylater where docno='$res3docno' and transactionstatus <> 'onaccount' and recordstatus = 'allocated'";
		  $exec67 = mysql_query($query67) or die(mysql_error());
		  while($res67 = mysql_fetch_array($exec67))
		  {
		   $onaccountpayment = $res67['transactionamount'];
		  $totalonaccountpayment = $totalonaccountpayment + $onaccountpayment;
		  }
		  
		  $resonaccountpayment = $res3transactionamount - $totalonaccountpayment;
		 
		  if($resonaccountpayment != 0)
		  {
		
		  $total = $total - $resonaccountpayment;
		  
		  if($days_between <= 30)
		  {
		 
		  $totalamount30 = $totalamount30 - $resonaccountpayment;
		  
		  }
		  else if(($days_between >30) && ($days_between <=60))
		  {
		
		  $totalamount60 = $totalamount60 - $resonaccountpayment;
		  
		  }
		  else if(($days_between >60) && ($days_between <=90))
		  {
		 
		  $totalamount90 = $totalamount90 - $resonaccountpayment;
		 
		  }
		  else if(($days_between >90) && ($days_between <=120))
		  {
		 
		  $totalamount120 = $totalamount120 - $resonaccountpayment;
		  
		  }
		  else if(($days_between >120) && ($days_between <=180))
		  {
		
		  $totalamount180 = $totalamount180 - $resonaccountpayment;
		  
		  }
		  else
		  {
		
		  $totalamountgreater = $totalamountgreater - $resonaccountpayment;
		 
		  }
		  $snocount = $snocount + 1;
			

			
			}
			}
			?>
			<?php
			
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			
			
		      
		  $query34 = "select * from master_transactionpaylater where accountname like '$res21accountname' and transactiondate between '$ADate1' and '$ADate2' and transactionstatus <> 'onaccount' and transactiontype = 'PAYMENT' and transactionmodule = 'PAYMENT' order by accountname desc";
		  $exec34 = mysql_query($query34) or die ("Error in Query34".mysql_error());
		   $num34 = mysql_num_rows($exec34);
		  while ($res34 = mysql_fetch_array($exec34))
		  {
		  $totalonlinepayment = 0;
     	  $res34transactiondate = $res34['transactiondate'];
	      $res34patientname = $res34['patientname'];
		  $res34patientcode = $res34['patientcode'];
		  $res34visitcode = $res34['visitcode'];
		  $res34billnumber = $res34['billnumber'];
		  $res34docno = $res34['docno'];
		  $res34transactionamount = $res34['transactionamount'];
		  $res34transactionmode = $res34['transactionmode'];
		  $res34transactionnumber = $res34['chequenumber'];
		  $t1 = strtotime("$ADate2");
		  $t2 = strtotime("$res34transactiondate");
		  $days_between = ceil(abs($t1 - $t2) / 86400);
		  
		  $query66 = "select sum(transactionamount) as tottransactionamount from master_transactionpaylater where transactionstatus <> 'onaccount' and transactiontype = 'PAYMENT' and transactionmodule = 'PAYMENT' and docno ='$res34docno'";
		  $exec66 = mysql_query($query66) or die(mysql_error());
		  $res66 = mysql_fetch_array($exec66);
		  $tottransactionamount = $res66['tottransactionamount'];
		  
		  $query674 = "select * from master_transactionpaylater where docno='$res34docno' and transactionstatus <> 'onaccount' and recordstatus = 'allocated'";
		  $exec674 = mysql_query($query674) or die(mysql_error());
		   $num674 = mysql_num_rows($exec674);
		  while($res674 = mysql_fetch_array($exec674))
		  {
		  $onlinepayment = $res674['transactionamount'];
		  $totalonlinepayment = $totalonlinepayment + $onlinepayment;
		  }
		 
		  $resonlinepayment = $tottransactionamount - $totalonlinepayment;
		 
		  if($resonlinepayment != 0)
		  {
		
		  $total = $total - $resonlinepayment;
		  
		  if($days_between <= 30)
		  {
		 
		  $totalamount30 = $totalamount30 - $resonlinepayment;
		  
		  }
		  else if(($days_between >30) && ($days_between <=60))
		  {
		
		  $totalamount60 = $totalamount60 - $resonlinepayment;
		  
		  }
		  else if(($days_between >60) && ($days_between <=90))
		  {
		 
		  $totalamount90 = $totalamount90 - $resonlinepayment;
		 
		  }
		  else if(($days_between >90) && ($days_between <=120))
		  {
		 
		  $totalamount120 = $totalamount120 - $resonlinepayment;
		  
		  }
		  else if(($days_between >120) && ($days_between <=180))
		  {
		
		  $totalamount180 = $totalamount180 - $resonlinepayment;
		  
		  }
		  else
		  {
		
		  $totalamountgreater = $totalamountgreater - $resonlinepayment;
		 
		  }
		  $snocount = $snocount + 1;
			
		
			
			}
			}
			?> 
			<?php
			
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			
		      
		  $query5 = "select * from master_transactionpaylater where accountname = '$searchsuppliername' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'pharmacycredit' order by transactiondate desc";
		  $exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
		  //echo $num = mysql_num_rows($exec3);
		  while ($res5 = mysql_fetch_array($exec5))
		  {
		  $totalpharmacreditpayment = 0;
     	  $res5transactiondate = $res5['transactiondate'];
	      $res5patientname = $res5['patientname'];
		  $res5patientcode = $res5['patientcode'];
		  $res5visitcode = $res5['visitcode'];
		  $res5docno = $res5['docno'];
		  
		  $query78 = "select * from billing_paylater where visitcode='$res5visitcode'";
		  $exec78 = mysql_query($query78);
		  $res78 = mysql_fetch_array($exec78);
		  $finalizedbillno = $res78['billno'];
		  $res5billnumber = $res5['billnumber'];
		  $res5transactionamount = $res5['transactionamount'];
		  $res5transactionmode = $res5['transactionmode'];
		  
		 
		  $t1 = strtotime("$ADate2");
		  $t2 = strtotime("$res5transactiondate");
		  $days_between = ceil(abs($t1 - $t2) / 86400);
		  $query77 = "select * from master_transactionpaylater where visitcode='$res5visitcode' and docno='$res5docno' and transactiontype <> 'pharmacycredit' and recordstatus = 'allocated'";
		  $exec77 = mysql_query($query77) or die(mysql_error());
		  while($res77 = mysql_fetch_array($exec77))
		  {
		   $pharmacreditpayment = $res77['transactionamount'];
		   
		  $totalpharmacreditpayment = $totalpharmacreditpayment + $pharmacreditpayment;
		  }
		  
		  $respharmacreditpayment = $res5transactionamount - $totalpharmacreditpayment;
		
		  if($respharmacreditpayment != 0)
		  {
		  $total = $total - $respharmacreditpayment;
		 
		 	  
		  if($days_between <= 30)
		  {
		 
		  $totalamount30 = $totalamount30 - $respharmacreditpayment;
		 
		  }
		  else if(($days_between >30) && ($days_between <=60))
		  {
		 
		  $totalamount60 = $totalamount60 - $respharmacreditpayment;
		  
		  }
		  else if(($days_between >60) && ($days_between <=90))
		  {
		
		  $totalamount90 = $totalamount90 - $respharmacreditpayment;
		 
		  }
		  else if(($days_between >90) && ($days_between <=120))
		  {
		 
		  $totalamount120 = $totalamount120 - $respharmacreditpayment;
		  
		  }
		  else if(($days_between >120) && ($days_between <=180))
		  {
		 
		  $totalamount180 = $totalamount180 - $respharmacreditpayment;
		  
		  }
		  else
		  {
		
		  $totalamountgreater = $totalamountgreater - $respharmacreditpayment;
		  
		  }
		  $snocount = $snocount + 1;
			
	
		
		   }
		   }
		   ?>
		    <?php
			
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			
		      
		  $query6 = "select * from master_transactionpaylater where accountname = '$searchsuppliername' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'paylatercredit' order by transactiondate desc";
		  $exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
		  //echo $num = mysql_num_rows($exec3);
		  while ($res6 = mysql_fetch_array($exec6))
		  {
		  $totalpaylatercreditpayment = 0;
     	  $res6transactiondate = $res6['transactiondate'];
	      $res6patientname = $res6['patientname'];
		  $res6patientcode = $res6['patientcode'];
		  $res6visitcode = $res6['visitcode'];
		  $res6billnumber = $res6['billnumber'];
		  $res6transactionamount = $res6['transactionamount'];
		  $res6transactionmode = $res6['transactionmode'];
		  $res6docno = $res6['docno'];
		  
		  $query56 = "select * from billing_paylater where visitcode='$res6visitcode'";
		  $exec56 = mysql_query($query56) or die(mysql_error());
		  $res56 = mysql_fetch_array($exec56);
		  $billnos = $res56['billno'];
		  
		  $query57 = "select * from consultation_lab where patientvisitcode='$res6visitcode' and labrefund='refund'";
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
		  
		  $query58 = "select * from consultation_radiology where patientvisitcode='$res6visitcode' and radiologyrefund='refund'";
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
		  
		  $query59 = "select * from consultation_services where patientvisitcode='$res6visitcode' and servicerefund='refund'";
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
		  
		   $query47 = "select * from master_transactionpaylater where visitcode='$res6visitcode' and docno='$res6docno' and transactiontype <> 'paylatercredit' and recordstatus = 'allocated'";
		  $exec47 = mysql_query($query47) or die(mysql_error());
		  while($res47 = mysql_fetch_array($exec47))
		  {
		   $paylatercreditpayment = $res47['transactionamount'];
		   
		  $totalpaylatercreditpayment = $totalpaylatercreditpayment + $paylatercreditpayment;
		  }
		  
		  $respaylatercreditpayment = $res6transactionamount - $totalpaylatercreditpayment;
		
		  if($respaylatercreditpayment != 0)
		  {
		  $total = $total - $respaylatercreditpayment;
		 
				  
		  if($days_between <= 30)
		  {
		  
		  $totalamount30 = $totalamount30 - $respaylatercreditpayment;
		  
		  }
		  else if(($days_between >30) && ($days_between <=60))
		  {
		  
		  $totalamount60 = $totalamount60 - $respaylatercreditpayment;
		  
		  }
		  else if(($days_between >60) && ($days_between <=90))
		  {
		  
		  $totalamount90 = $totalamount90 - $respaylatercreditpayment;
		 
		  }
		  else if(($days_between >90) && ($days_between <=120))
		  {
		  
		  $totalamount120 = $totalamount120 - $respaylatercreditpayment;
		 
		  }
		  else if(($days_between >120) && ($days_between <=180))
		  {
		  
		  $totalamount180 = $totalamount180 - $respaylatercreditpayment;
		  
		  }
		  else
		  {
		      
		  $totalamountgreater = $totalamountgreater - $respaylatercreditpayment;
		  
		  }
		  $snocount = $snocount + 1;
			
			
			
			}
			}
			}
			$grandtotalamount30 = $grandtotalamount30 + $totalamount30;
			$grandtotalamount60 = $grandtotalamount60 + $totalamount60;
			$grandtotalamount90 = $grandtotalamount90 + $totalamount90;
			$grandtotalamount120 = $grandtotalamount120 + $totalamount120;
			$grandtotalamount180 = $grandtotalamount180 + $totalamount180;
			$grandtotalamountgreater = $grandtotalamountgreater + $totalamountgreater;
			}
			?>
				 </tbody>
        </table>
		</form>
		</td>
      </tr>
	  
   
			<tr>
        <td>&nbsp;</td>
      </tr>
		
			<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 
            align="left" border="0">
			<tr>
              <td width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc"><strong>Debt Status</strong></td>
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
                bgcolor="#ffffff"><strong>Total Receivables</strong></td>
            </tr>
			<?php 
			$grandtotal = $grandtotalamount30 + $grandtotalamount60 + $grandtotalamount90 + $grandtotalamount120 + $grandtotalamount180 + $grandtotalamountgreater;
			?>
			<tr>
               <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#D3EEB7"><?php echo number_format($grandtotalamount30,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#D3EEB7"><?php echo number_format($grandtotalamount60,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#D3EEB7"><?php echo number_format($grandtotalamount90,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#D3EEB7"><?php echo number_format($grandtotalamount120,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#D3EEB7"><?php echo number_format($grandtotalamount180,2,'.',','); ?></td>
            <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#D3EEB7"><?php echo number_format($grandtotalamountgreater,2,'.',','); ?></td>
            
             	 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#D3EEB7"><?php echo number_format($grandtotal,2,'.',','); ?></td>
            </tr>
			
		 
			  </table>
			  <?php
			
			
			$grandtotalamount30 = 0;
			$grandtotalamount60 = 0;
			$grandtotalamount90 = 0;
			$grandtotalamount120 = 0;
			$grandtotalamount180 = 0;
			$grandtotalamountgreater = 0;
			$query21 = "select * from master_transactionpharmacy where transactiondate between '$ADate1' and '$ADate2' and transactionmode = 'CREDIT' group by suppliercode order by suppliername desc ";
			$exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
			while ($res21 = mysql_fetch_array($exec21))
			{
			$res21suppliercode = $res21['suppliercode'];
			$res21suppliername = $res21['suppliername'];
			
			$query22 = "select * from master_accountname where accountname = '$res21suppliername' and recordstatus <>'DELETED' ";
			$exec22 = mysql_query($query22) or die ("Error in Query22".mysql_error());
			$res22 = mysql_fetch_array($exec22);
			$res22suppliername = $res22['accountname'];

			if($res22suppliername != '')
			{
			?>
					
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
			
		  
		      
		  $query2 = "select * from master_transactionpharmacy where suppliercode like '%$res21suppliercode%' and transactiondate between '$ADate1' and '$ADate2' and transactionmode = 'CREDIT' order by suppliername desc";
		  $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		  while ($res2 = mysql_fetch_array($exec2))
		  {
		  $totalpayment = 0;
     	  $res2transactiondate = $res2['transactiondate'];
		  $res2billnumber = $res2['billnumber'];
		  $res2transactionamount = $res2['transactionamount'];
		  
		  
		  
		  $query98 = "select * from master_transactionpharmacy where transactiontype = 'PAYMENT' and transactionmodule = 'PAYMENT' and billnumber='$res2billnumber'";
		  $exec98 = mysql_query($query98) or die(mysql_error());
		  $num98 = mysql_num_rows($exec98);
		  while($res98 = mysql_fetch_array($exec98))
		  {
		  $payment = $res98['transactionamount'];
		  $totalpayment = $totalpayment + $payment;
		  }
		  $resamount = $res2transactionamount - $totalpayment;
		  if($resamount != 0)
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
		
			}
			}
			?>
   
			
			<?php
			
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			
		      
		  $query5 = "select * from purchasereturn_details where suppliercode = '$res21suppliercode' and entrydate between '$ADate1' and '$ADate2' order by entrydate desc";
		  $exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
		  //echo $num = mysql_num_rows($exec3);
		  while ($res5 = mysql_fetch_array($exec5))
		  {
		  $totalpharmacreditpayment = 0;
     	  $res5transactiondate = $res5['entrydate'];
		  $res5transactionamount = $res5['totalamount'];
		 
		 
		  $t1 = strtotime("$ADate2");
		  $t2 = strtotime("$res5transactiondate");
		  $days_between = ceil(abs($t1 - $t2) / 86400);
		
		  
		  $respharmacreditpayment = $res5transactionamount;
		
		  if($respharmacreditpayment != 0)
		  {
		  $total = $total - $respharmacreditpayment;
		 
		 	  
		  if($days_between <= 30)
		  {
		 
		  $totalamount30 = $totalamount30 - $respharmacreditpayment;
		 
		  }
		  else if(($days_between >30) && ($days_between <=60))
		  {
		 
		  $totalamount60 = $totalamount60 - $respharmacreditpayment;
		  
		  }
		  else if(($days_between >60) && ($days_between <=90))
		  {
		
		  $totalamount90 = $totalamount90 - $respharmacreditpayment;
		 
		  }
		  else if(($days_between >90) && ($days_between <=120))
		  {
		 
		  $totalamount120 = $totalamount120 - $respharmacreditpayment;
		  
		  }
		  else if(($days_between >120) && ($days_between <=180))
		  {
		 
		  $totalamount180 = $totalamount180 - $respharmacreditpayment;
		  
		  }
		  else
		  {
		
		  $totalamountgreater = $totalamountgreater - $respharmacreditpayment;
		  
		  }
		  $snocount = $snocount + 1;
			
	
		
		   }
		   }
		   ?>
		    <?php
			}
			$grandtotalamount30 = $grandtotalamount30 + $totalamount30;
			$grandtotalamount60 = $grandtotalamount60 + $totalamount60;
			$grandtotalamount90 = $grandtotalamount90 + $totalamount90;
			$grandtotalamount120 = $grandtotalamount120 + $totalamount120;
			$grandtotalamount180 = $grandtotalamount180 + $totalamount180;
			$grandtotalamountgreater = $grandtotalamountgreater + $totalamountgreater;
			}
			?>
			
			<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 
            align="left" border="0">
			<tr>
			<td>&nbsp;</td>
			</tr>
			<tr>
              <td width="160" class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc"><strong>Credit Status</strong></td>
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
                bgcolor="#ffffff"><strong>Total Payables</strong></td>
            </tr>
			<?php 
			$grandtotal = $grandtotalamount30 + $grandtotalamount60 + $grandtotalamount90 + $grandtotalamount120 + $grandtotalamount180 + $grandtotalamountgreater;
			?>
			<tr>
               <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#D3EEB7"><?php echo number_format($grandtotalamount30,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#D3EEB7"><?php echo number_format($grandtotalamount60,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#D3EEB7"><?php echo number_format($grandtotalamount90,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#D3EEB7"><?php echo number_format($grandtotalamount120,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#D3EEB7"><?php echo number_format($grandtotalamount180,2,'.',','); ?></td>
            <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#D3EEB7"><?php echo number_format($grandtotalamountgreater,2,'.',','); ?></td>
            
             	 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#D3EEB7"><?php echo number_format($grandtotal,2,'.',','); ?></td>
            </tr>
			
		
			  </table>
			
       
</table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
