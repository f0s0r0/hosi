<?php
session_start();
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="CorporateOutstanding.xls"');
header('Cache-Control: max-age=80');
//include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = '';
$companyanum = '';
$companyname = '';
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
include ("autocompletebuild_account2.php");
// for Excel Export
if (isset($_REQUEST["username"])) { $username = $_REQUEST["username"]; } else { $username = ""; }
if (isset($_REQUEST["companyanum"])) { $companyanum = $_REQUEST["companyanum"]; } else { $companyanum = ""; }
if (isset($_REQUEST["companyname"])) { $companyname = $_REQUEST["companyname"]; } else { $companyname = ""; }
//$sno = $sno + 2;
//echo $companyname;
// for print page
if (isset($_SESSION["username"])) { $username = $_SESSION["username"]; } else { $username = ""; }
if (isset($_SESSION["companyanum"])) { $companyanum = $_SESSION["companyanum"]; } else { $companyanum = ""; }
if (isset($_SESSION["companyname"])) { $companyname = $_SESSION["companyname"]; } else { $companyname = ""; }

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliercode = $_REQUEST["searchsuppliername"]; } else { $searchsuppliercode = ""; }
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


$query12 = "select * from master_accountname where auto_number = '$searchsuppliercode'";
$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
$res12 = mysql_fetch_array($exec12);
$subtype = $res12['subtype'];
$code = $res12['id'];
$locationn = $res12['locationname'];
$searchsuppliername = $res12['accountname'];
?>
<style type="text/css">
<!--
body {
	
	background-color: #FFFFFF;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
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
       <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1200" 
            align="left" border="0">
          <tbody>
           
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
 			
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td width="9%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>
              <td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Description </strong></td>
                <td width="9%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Mrd No</strong></div></td>
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
			$openingbalance='0';
	$totaldebit=0;		
$debit=0;
$credit1=0;
$credit2=0;
$totalpayment=0;
$totalcredit='0';
$resamount=0;
$query2 = "select transactiondate,patientname,visitcode,billnumber,transactionamount,patientcode,particulars from master_transactionpaylater where accountnameano = '$searchsuppliercode' and transactiondate < '$ADate1'  and transactiontype = 'finalize' order by accountname desc";
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			while ($res2 = mysql_fetch_array($exec2))
{
				$res2transactiondate = $res2['transactiondate'];
				$res2visitcode = $res2['visitcode'];
				$res2billnumber = $res2['billnumber'];
				$res2transactionamount = $res2['transactionamount'];
				$res2patientcode = $res2['patientcode'];
				
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
				$query7 = "select sum(transactionamount) as sumtransactionamount from master_transactionpaylater where accountnameano = '$searchsuppliercode' and transactiondate <='$res2transactiondate' and transactiontype = 'pharmacycredit' and patientcode='$res2patientcode' and visitcode='$res2visitcode' order by transactiondate desc";
				$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
				//echo $num = mysql_num_rows($exec3);
				while ($res7 = mysql_fetch_array($exec7))
				{
					$res7sumtransactionamount += $res7['sumtransactionamount'];
				}
				
				$res8sumtransactionamount=0;
				$query8 = "select sum(transactionamount) as sumtransactionamount from master_transactionpaylater where accountnameano = '$searchsuppliercode' and transactiondate <='$res2transactiondate' and transactiontype = 'paylatercredit' and patientcode='$res2patientcode' and visitcode='$res2visitcode' order by transactiondate desc";
				$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
				//echo $num = mysql_num_rows($exec3);
				while ($res8 = mysql_fetch_array($exec8))
				{
					$res8sumtransactionamount += $res8['sumtransactionamount'];
				}
				
				
				$res2transactionamount = $res2transactionamount-$res7sumtransactionamount-$res8sumtransactionamount;
				$resamount = $res2transactionamount - $totalpayment;
			
				$credit1=0;
				$query5 = "select visitcode,docno,transactionamount from master_transactionpaylater where accountnameano = '$searchsuppliercode' and transactiondate>'$res2transactiondate' and transactiontype = 'pharmacycredit' and patientcode='$res2patientcode' and visitcode='$res2visitcode' order by transactiondate desc";
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
				$query6 = "select visitcode,transactionamount,docno from master_transactionpaylater where accountnameano = '$searchsuppliercode' and transactiondate>'$res2transactiondate' and transactiontype = 'paylatercredit' and patientcode='$res2patientcode' and visitcode='$res2visitcode' order by transactiondate desc";
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
$query3 = "select docno,transactionamount from master_transactionpaylater where accountnameano = '$searchsuppliercode' and transactiondate < '$ADate1' and transactionstatus in ( 'onaccount','paylatercredit') order by accountname desc";
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
$query6 = "select docno from master_transactionpaylater where accountnameano = '$searchsuppliercode' and transactiondate < '$ADate1'  and transactiontype = 'paylatercredit' and patientname='' order by transactiondate desc";
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
		  ?>
			<tr>
			<td class="bodytext31" valign="center"  align="left" 
                ><strong>&nbsp;</strong></td>
				
              <td width="9%" align="left" valign="center"  
                 class="bodytext31"><div align="left"><strong>&nbsp;</strong></div></td>
                
              <td width="35%" align="left" valign="center"  
                 class="bodytext31"><strong> Opening Balance </strong></td>
                 <td width="9%" align="left" valign="center"  
                 class="bodytext31"><div align="left"><strong>&nbsp;</strong></div></td>
              <td width="20%" align="right" valign="center"  
                 class="bodytext31"><strong>&nbsp;</strong></td>
              <td width="16%" align="left" valign="center"  
                 class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
			 <td width="16%" align="left" valign="center"  
                 class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>	
				<td width="16%" align="left" valign="center"  
                 class="bodytext31"><div align="right"><strong><?php echo number_format($openingbalance,2,'.',','); ?></strong></div></td>
			</tr>
			<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			
			$query22 = "select accountname from master_accountname where auto_number = '$searchsuppliercode' and recordstatus <>'DELETED' ";
			$exec22 = mysql_query($query22) or die ("Error in Query22".mysql_error());
			$res22 = mysql_fetch_array($exec22);
			$res22accountname = $res22['accountname'];

			if( $res22accountname != '')
			{
			?>
			<tr bgcolor="#ffffff">
            <td colspan="15"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong><?php echo $res22accountname;?> (Date From: <?php echo $ADate1; ?> Date To: <?php echo $ADate2; ?>)</strong></td>
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
		 	$query2 = "select transactiondate,patientname,visitcode,billnumber,transactionamount,patientcode,particulars from master_transactionpaylater where accountnameano = '$searchsuppliercode' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'finalize' order by accountname desc";
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			while ($res2 = mysql_fetch_array($exec2))
			{
				$resamount=0;
				$res2transactiondate = $res2['transactiondate'];
				$res2patientname = $res2['patientname'];
				$res2visitcode = $res2['visitcode'];
				$res2billnumber = $res2['billnumber'];
				$res2transactionamount = $res2['transactionamount'];
				$res2patientcode = $res2['patientcode'];
				$particulars = $res2['particulars'];	
				$querymrdno1 = "select mrdno from master_customer where customercode='$res2patientcode'";
				$execmrdno1 = mysql_query($querymrdno1) or die ("Error in Querymrdno1".mysql_error());
				$resmrdno1 = mysql_fetch_array($execmrdno1);
				$res1mrdno = $resmrdno1['mrdno'];
				$mrdno='';
				
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
				$query7 = "select sum(transactionamount) as sumtransactionamount from master_transactionpaylater where accountnameano = '$searchsuppliercode' and transactiondate <='$res2transactiondate' and transactiontype = 'pharmacycredit' and patientcode='$res2patientcode' and visitcode='$res2visitcode' order by transactiondate desc";
				$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
				//echo $num = mysql_num_rows($exec3);
				while ($res7 = mysql_fetch_array($exec7))
				{
					$res7sumtransactionamount = $res7['sumtransactionamount'];
				}
				$res8sumtransactionamount=0;
				$query8 = "select sum(transactionamount) as sumtransactionamount from master_transactionpaylater where accountnameano = '$searchsuppliercode' and transactiondate <='$res2transactiondate' and transactiontype = 'paylatercredit' and patientcode='$res2patientcode' and visitcode='$res2visitcode' order by transactiondate desc";
				$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
				//echo $num = mysql_num_rows($exec3);
				while ($res8 = mysql_fetch_array($exec8))
				{
					$res8sumtransactionamount = $res8['sumtransactionamount'];
				}
				
				$res2transactionamount = $res2transactionamount-$res7sumtransactionamount-$res8sumtransactionamount;
				$resamount = $res2transactionamount - $totalpayment;
				if($resamount != 0)
				{
					$snocount = $snocount + 1;
					$t1 = strtotime($ADate2);
					$t2 = strtotime($res2transactiondate);
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
					
					<tr>
                        <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
                        <td class="bodytext31" valign="center"  align="left">
                        <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
                        <td class="bodytext31" valign="center"  align="left">
                        <div class="bodytext31"><?php echo $res2patientname; ?> (<?php echo $res2patientcode; ?>, <?php echo $res2visitcode; ?>, <?php echo $res2billnumber; ?>)<?php echo $particulars ?></div></td>
                        <td class="bodytext31" valign="center"  align="left">
                        <div class="bodytext31"><?php echo $res1mrdno; ?></div></td>                        
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
				
				$query5 = "select transactiondate,patientname,patientcode,visitcode,docno,particulars,billnumber,transactionamount,transactionmode from master_transactionpaylater where accountnameano = '$searchsuppliercode' and transactiondate>'$res2transactiondate' and transactiontype = 'pharmacycredit' and patientcode='$res2patientcode' and visitcode='$res2visitcode' order by transactiondate desc";
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
					<tr>
					<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
					<td class="bodytext31" valign="center"  align="left">
					<div class="bodytext31"><?php echo $res5transactiondate; ?></div></td>
					<td class="bodytext31" valign="center"  align="left">
					<div class="bodytext31"><?php echo $res5patientname; ?> (<?php echo $res5patientcode; ?>,<?php echo $res5visitcode; ?>,<?php echo $finalizedbillno; ?>)- Cr.Note : Pharma<?php echo $particulars ?></div></td>
                    <td class="bodytext31" valign="center"  align="left">
                        <div class="bodytext31"><?php echo $res1mrdno; ?></div></td>
					<td class="bodytext31" valign="center"  align="right">
					<?php //echo number_format($res3transactionamount,2,'.',''); ?></td>
					<td class="bodytext31" valign="center"  align="right">
					<div align="right"><?php echo number_format($respharmacreditpayment,2,'.',',');?></div></td>
					<td class="bodytext31" valign="center"  align="right">
					<div align="center"><?php echo $days_between;?></div></td>
					<td class="bodytext31" valign="center"  align="left">
					<div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>
					</tr>
					<?php
					}
				}
				$query6 = "select transactiondate,patientname,patientcode,visitcode,billnumber,transactionamount,transactionmode,docno,particulars from master_transactionpaylater where accountnameano = '$searchsuppliercode' and transactiondate>'$res2transactiondate' and transactiontype = 'paylatercredit' and patientcode='$res2patientcode' and visitcode='$res2visitcode' order by transactiondate desc";
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
					<tr>
					<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
					<td class="bodytext31" valign="center"  align="left">
					<div class="bodytext31"><?php echo $res6transactiondate; ?></div></td>
					<td class="bodytext31" valign="center"  align="left">
					<div class="bodytext31"><?php echo $res6patientname; ?> (<?php echo $res6patientcode; ?>,<?php echo $res6visitcode; ?>,<?php echo $billnos; ?>)- Cr.Note : <?php echo $lab; ?>&nbsp;<?php echo $rad; ?>&nbsp;<?php echo $ser; ?><?php echo $particulars ?></div></td>
                    <td class="bodytext31" valign="center"  align="left">
                        <div class="bodytext31"><?php echo $res1mrdno; ?></div></td>
					<td class="bodytext31" valign="center"  align="right">
					<?php //echo number_format($res3transactionamount,2,'.',''); ?></td>
					<td class="bodytext31" valign="center"  align="right">
					<div align="right"><?php echo number_format($respaylatercreditpayment,2,'.',',');?></div></td>
					<td class="bodytext31" valign="center"  align="right">
					<div align="center"><?php echo $days_between;?></div></td>
					<td class="bodytext31" valign="center"  align="left">
					<div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>
					</tr>
					
					<?php
					}
				}			
			}
		  
		  
		  
			   $query3 = "select transactiondate,patientname,patientcode,visitcode,billnumber,docno,transactionamount,transactionmode,chequenumber,particulars from master_transactionpaylater where accountnameano = '$searchsuppliercode' and transactiondate between '$ADate1' and '$ADate2' and transactionstatus in ( 'onaccount','paylatercredit') order by accountname desc";
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
			 	$query67 = "select sum(transactionamount) as transactionamount1 from master_transactionpaylater where docno='$res3docno' and transactionstatus <> 'onaccount' and recordstatus = 'allocated'";
				$exec67 = mysql_query($query67) or die(mysql_error());
				while($res67 = mysql_fetch_array($exec67))
				{
					$onaccountpayment = $res67['transactionamount1'];
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
				<tr>
				  <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
				   <td class="bodytext31" valign="center"  align="left">
					<div class="bodytext31"><?php echo $res3transactiondate; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
					<div class="bodytext31"><?php echo $res3transactionmode; ?> <?php echo $res3transactionnumber; ?><?php echo $particulars ?></div></td>
                    <td class="bodytext31" valign="center"  align="left">
                        <div class="bodytext31"><?php echo ''; ?></div></td>
				  <td class="bodytext31" valign="center"  align="right">
				 </td>
				  <td class="bodytext31" valign="center"  align="right">
					<div align="right"><?php 
					
					echo number_format($resonaccountpayment,2,'.',',');?></div></td>
					<td class="bodytext31" valign="center"  align="right">
					<div align="center"><?php echo $days_between;?></div></td>
				   <td class="bodytext31" valign="center"  align="left">
					<div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>
				</tr>
				<?php
				}
			}
			
			
			$query6 = "select transactiondate,patientname,patientcode,visitcode,billnumber,transactionamount,transactionmode,docno,particulars from master_transactionpaylater where accountnameano = '$searchsuppliercode' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'paylatercredit' and patientname='' order by transactiondate desc";
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
					<tr>
					<td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
					<td class="bodytext31" valign="center"  align="left">
					<div class="bodytext31"><?php echo $res6transactiondate; ?></div></td>
					<td class="bodytext31" valign="center"  align="left">
					<div class="bodytext31"><?php echo $res6patientname; ?> (<?php echo $res6patientcode; ?>,<?php echo $res6visitcode; ?>,<?php echo $res6billnumber; ?>)- Cr.Note : <?php echo $particulars ?></div></td>
                    <td class="bodytext31" valign="center"  align="left">
                        <div class="bodytext31"><?php echo ''; ?></div></td>
					<td class="bodytext31" valign="center"  align="right">
					<?php //echo number_format($res3transactionamount,2,'.',''); ?></td>
					<td class="bodytext31" valign="center"  align="right">
					<div align="right"><?php echo number_format($respaylatercreditpayment,2,'.',',');?></div></td>
					<td class="bodytext31" valign="center"  align="right">
					<div align="center"><?php echo $days_between;?></div></td>
					<td class="bodytext31" valign="center"  align="left">
					<div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>
					</tr>
				
				<?php
				}
			}
			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
				 <td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
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
                >&nbsp;</td>
              <td  width="160" class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
              <td width="160" class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
              <td width="160" class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
				<td  width="160" class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
					<td  width="160" class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
            
				<td  width="160" class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
            
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
               ><?php echo number_format($totalamount30,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right" 
               ><?php echo number_format($totalamount60,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right" 
               ><?php echo number_format($totalamount90,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
               ><?php echo number_format($totalamount120,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
               ><?php echo number_format($totalamount180,2,'.',','); ?></td>
            <td class="bodytext31" valign="center"  align="right" 
               ><?php echo number_format($totalamountgreater,2,'.',','); ?></td>
            
             	 <td class="bodytext31" valign="center"  align="right" 
               ><?php echo number_format($grandtotal,2,'.',','); ?></td>
            </tr>
			
		    <tr>
              <td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
					<td class="bodytext31" valign="center"  align="left" 
                >&nbsp;</td>
          
               </tr>
			  </table>
			  
			<?php
			}
			}
			?>
         
</table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
