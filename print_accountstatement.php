<?php
session_start();
include ("db/db_connect.php");

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="AccountStatement.xls"');
header('Cache-Control: max-age=80');

//$ipaddress = $_SERVER['REMOTE_ADDR'];
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
//include ("autocompletebuild_account2.php");
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

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
//echo $searchsuppliername;
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1260" 
            align="left" border="1">
          <tbody>
		  <?php
            $query22 = "select accountname from master_accountname where auto_number = '$searchsuppliercode' and recordstatus <>'DELETED' ";
				$exec22 = mysql_query($query22) or die ("Error in Query22".mysql_error());
				$res22 = mysql_fetch_array($exec22);
				$res22accountname = $res22['accountname'];
				
			
				if( $res22accountname != '')
				{
					?>
			<tr>
            <td colspan="10"  align="left" valign="center"  class="bodytext31"><strong><?php echo $res22accountname;?> (Date From: <?php echo $ADate1; ?> Date To: <?php echo $ADate2; ?>)</strong></td>
            </tr>
           
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                ><strong>No.</strong></td>
              <td width="4%" align="left" valign="center"  
                 class="bodytext31"><div align="left"><strong>Date</strong></div></td>
              <td width="6%" align="left" valign="center"  
                 class="bodytext31"><strong> Bill No </strong></td>
                <td width="9%" align="left" valign="center"  
                 class="bodytext31"><div align="left"><strong>Reg No</strong></div></td>
			  <td width="9%" align="left" valign="center"  
                 class="bodytext31"><div align="left"><strong>Visit No</strong></div></td>
				<td width="30%" align="left" valign="center"  
                 class="bodytext31"><strong> Patient Name</strong></td>
              <td width="9%" align="right" valign="center"  
                 class="bodytext31"><strong>Debit</strong></td>
              <td width="7%" align="left" valign="center"  
                 class="bodytext31"><div align="right"><strong>Credit</strong></div></td>
				<td width="7%" align="left" valign="center"  
                 class="bodytext31"><div align="center"><strong>Days</strong></div></td>
				<td width="17%" align="left" valign="center"  
                 class="bodytext31"><div align="right"><strong>Current Balance</strong></div></td>
				
            </tr>
			<?php
			$openingbalance='0';
		$totaldebit=0;
$credit1=0;
$credit2=0;
$debit=0;

$query2 = "select transactiontime,transactiondate,visitcode,transactionamount,patientcode from master_transactionpaylater where accountnameano = '$searchsuppliercode' and transactiondate < '$ADate1'  and transactiontype = 'finalize' order by accountname desc";
					$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
 					$numrw=mysql_num_rows($exec2);
					while ($res2 = mysql_fetch_array($exec2))
					{
						$res2transactiondate = $res2['transactiondate'];
						$res2transactiontime = $res2['transactiontime'];
						$combinedate=$res2transactiondate.''.$res2transactiontime;
					
						$res2findate=strtotime($combinedate);
						$res2visitcode = $res2['visitcode'];
						
						$res2transactionamount = $res2['transactionamount'];
						$res2patientcode = $res2['patientcode'];
		
						$debit=0;
						
						$res7sumtransactionamount =0;
						$query7 = "select sum(transactionamount) as sumtransactionamount from master_transactionpaylater where accountnameano = '$searchsuppliercode' and transactiondate<'$res2transactiondate' and transactiontype = 'pharmacycredit' and patientcode='$res2patientcode' and visitcode='$res2visitcode' order by transactiondate desc";
						$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
						//echo $num = mysql_num_rows($exec3);
						while ($res7 = mysql_fetch_array($exec7))
						{
							$res7sumtransactionamount += $res7['sumtransactionamount'];
						}
						$res8sumtransactionamount =0;
						$query8 = "select sum(transactionamount) as sumtransactionamount from master_transactionpaylater where accountnameano = '$searchsuppliercode' and transactiondate<'$res2transactiondate' and transactiontype = 'paylatercredit' and patientcode='$res2patientcode' and visitcode='$res2visitcode' order by transactiondate desc";
						$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
						//echo $num = mysql_num_rows($exec3);
						while ($res8 = mysql_fetch_array($exec8))
						{
							$res8sumtransactionamount += $res8['sumtransactionamount'];
						}
						
						
				
						$debit = $res2transactionamount-$res7sumtransactionamount-$res8sumtransactionamount;
						
				
					$credit1=0;
					$query5 = "select sum(transactionamount) as transamount from master_transactionpaylater where accountnameano = '$searchsuppliercode' and transactiondate >='$res2transactiondate' and transactiontype = 'pharmacycredit' and patientcode='$res2patientcode' and visitcode='$res2visitcode' order by transactiondate desc";
					$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
					while ($res5 = mysql_fetch_array($exec5))
					{
					 	$res5transactionamount = $res5['transamount'];
						$credit1 +=$res5transactionamount;
					}
						
						$credit2 =0;
						$query6 = "select transactiontime,transactiondate,transactionamount from master_transactionpaylater where accountnameano = '$searchsuppliercode'  and transactiontype = 'paylatercredit' and patientcode='$res2patientcode' and visitcode='$res2visitcode'  order by transactiondate desc";
						$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
						while ($res6 = mysql_fetch_array($exec6))
						{
							$res6transactiondate = $res6['transactiondate'];
							$res6transactiontime =$res6['transactiontime'];
							$combinedate1=$res6transactiondate.''.$res6transactiontime;
					
					$res6findate=strtotime($combinedate1);
							if($res6findate>$res2findate)
							{
							
							$res6transactionamount = $res6['transactionamount'];
							$credit2 +=$res6transactionamount;
							}
						}
					
					$totaldebit +=$debit-$credit1-$credit2;
					}
						
$credit3=0; 
	$query2 = "select sum(transactionamount) as transamount from master_transactionpaylater where accountnameano = '$searchsuppliercode' and transactiondate < '$ADate1'  and transactiontype = 'PAYMENT' and transactionstatus='onaccount' order by accountname desc";
					$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
					while ($res22 = mysql_fetch_array($exec2))
					{
						
						$res2transactionamount2 = $res22['transamount'];
					$credit3 +=$res2transactionamount2;
					}
			
$credit4=0;
$query6 = "select sum(transactionamount) as transamount from master_transactionpaylater where accountnameano = '$searchsuppliercode' and transactiondate < '$ADate1' and transactiontype = 'paylatercredit'and patientname='' order by transactiondate desc";
				$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
				//echo $num = mysql_num_rows($exec6);
				while ($res62 = mysql_fetch_array($exec6))
				{ 
			
					$res6transactionamount2 = $res62['transamount'];
					$credit4 +=$res6transactionamount2;
				}	
$openingbalance = $totaldebit - $credit3 - $credit4 ;		
		  ?>
			<tr>
			<td class="bodytext31" valign="center"  align="left" 
                ><strong>&nbsp;</strong></td>
				
              <td width="4%" align="left" valign="center"  
                 class="bodytext31"><div align="left"><strong>&nbsp;</strong></div></td>
               
              <td colspan="2" align="left" valign="center"  
                 class="bodytext31"><strong> Opening Balance </strong></td>
                 <td width="9%" align="left" valign="center"  
                class="bodytext31"><div align="left"><strong>&nbsp;</strong></div></td>
              <td width="30%" align="right" valign="center"  
                 class="bodytext31"><strong>&nbsp;</strong></td>
              <td width="9%" align="left" valign="center"  
                 class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
			 <td width="7%" align="left" valign="center"  
                 class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>	
				<td colspan="2" align="left" valign="center"  
                 class="bodytext31"><div align="right"><strong><?php echo number_format($openingbalance,2,'.',','); ?></strong></div></td>
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
					$totalamount30 = 0;
					$totalamount60 = 0;
					$totalamount90 = 0;
					$totalamount120 = 0;
					$totalamount180 = 0;
					$totalamountgreater = 0;					
					$query2 = "select transactiontime,transactiondate,patientname,visitcode,billnumber,transactionamount,patientcode,particulars from master_transactionpaylater where accountnameano = '$searchsuppliercode' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'finalize' order by accountname desc";
					$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
 					$numrw=mysql_num_rows($exec2);
					while ($res2 = mysql_fetch_array($exec2))
					{
						$res2transactionamount=0;
						$res2transactiondate = $res2['transactiondate'];
						$res2transactiontime = $res2['transactiontime'];
						$combinedate=$res2transactiondate.''.$res2transactiontime;
					
						$res2findate=strtotime($combinedate);
					
						$res2patientname = $res2['patientname'];
						$res2visitcode = $res2['visitcode'];
						$res2billnumber = $res2['billnumber'];
						$res2transactionamount = $res2['transactionamount'];
						$res2patientcode = $res2['patientcode'];
						$particulars = $res2['particulars'];
						$snocount = $snocount + 1;
						$t1 = strtotime($ADate2);
						$t2 = strtotime($res2transactiondate);
						$days_between = ceil(abs($t1 - $t2) / 86400);
						$querymrdno1 = "select mrdno from master_customer where customercode='$res2patientcode'";
						$execmrdno1 = mysql_query($querymrdno1) or die ("Error in Querymrdno1".mysql_error());
						$resmrdno1 = mysql_fetch_array($execmrdno1);
						$res1mrdno = $resmrdno1['mrdno'];
						$mrdno='';
					
						$res7sumtransactionamount=0;
						$query7 = "select sum(transactionamount) as sumtransactionamount from master_transactionpaylater where accountnameano = '$searchsuppliercode' and transactiondate<'$res2transactiondate' and transactiontype = 'pharmacycredit' and patientcode='$res2patientcode' and visitcode='$res2visitcode' order by transactiondate desc";
						$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
						//echo $num = mysql_num_rows($exec3);
						while ($res7 = mysql_fetch_array($exec7))
						{
							$res7sumtransactionamount = $res7['sumtransactionamount'];
						}
						
						$res8sumtransactionamount=0;
						$query8 = "select sum(transactionamount) as sumtransactionamount from master_transactionpaylater where accountnameano = '$searchsuppliercode' and transactiondate<'$res2transactiondate' and transactiontype = 'paylatercredit' and patientcode='$res2patientcode' and visitcode='$res2visitcode' order by transactiondate desc";
						$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
						//echo $num = mysql_num_rows($exec3);
						while ($res8 = mysql_fetch_array($exec8))
						{
							$res8sumtransactionamount = $res8['sumtransactionamount'];
						}
						
						
					
						if ($res2transactionamount == '')
						{
							$res2transactionamount = '0.00';
						}
						else
						{
							$res2transactionamount = $res2['transactionamount'];
						}
						
						$res2transactionamount = $res2transactionamount-$res7sumtransactionamount-$res8sumtransactionamount;
						
						if($snocount == 1)
						{
							$total = $openingbalance + $res2transactionamount;
						}
						else
						{
							$total = $total + $res2transactionamount;
						}
						if($res2transactionamount !=0)
						{
						if($days_between <= 30)
						{
							if($snocount == 1)
							{
								$totalamount30 = $openingbalance + $res2transactionamount;
							}
							else
							{
								$totalamount30 = $totalamount30 + $res2transactionamount;
							}
						}
						else if(($days_between >30) && ($days_between <=60))
						{
							if($snocount == 1)
							{
								$totalamount60 = $openingbalance + $res2transactionamount;
							}
							else
							{
								$totalamount60 = $totalamount60 + $res2transactionamount;
							}
						}
						else if(($days_between >60) && ($days_between <=90))
						{
							if($snocount == 1)
							{
								$totalamount90 = $openingbalance + $res2transactionamount;
							}
							else
							{
								$totalamount90 = $totalamount90 + $res2transactionamount;
							}
						}
						else if(($days_between >90) && ($days_between <=120))
						{
							if($snocount == 1)
							{
								$totalamount120 = $openingbalance + $res2transactionamount;
							}
							else
							{
								$totalamount120 = $totalamount120 + $res2transactionamount;
							}
						}
						else if(($days_between >120) && ($days_between <=180))
						{
							if($snocount == 1)
							{
								$totalamount180 = $openingbalance + $res2transactionamount;
							}
							else
							{
								$totalamount180 = $totalamount180 + $res2transactionamount;
							}
						}
						else
						{
							if($snocount == 1)
							{
								$totalamountgreater = $openingbalance + $res2transactionamount;
							}
							else
							{
								$totalamountgreater = $totalamountgreater + $res2transactionamount;
							}
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
						<tr >
                            <td width="2%" class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
                            <td width="4%"class="bodytext31" valign="center"  align="left">
                          <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
							 <td width="6%"class="bodytext31" valign="center"  align="left">
                          <div align="left"><?php echo $res2billnumber; ?></div></td> 
                            <td width="9%"class="bodytext31" valign="center"  align="left">
                          <div class="bodytext31"><?php echo $res2patientcode; ?></div></td>
							 <td width="9%"class="bodytext31" valign="center"  align="left">
                          <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
                              <td width="30%"class="bodytext31" valign="center"  align="left">
                          <div class="bodytext31"><?php echo $res2patientname; ?>, <?php echo $particulars ?></div></td>                
                            <td width="9%"class="bodytext31" valign="center"  align="right">
                            <?php echo number_format($res2transactionamount,2,'.',','); ?></td>
                            <td width="7%"class="bodytext31" valign="center"  align="left">
                          <div align="right"><?php //echo $days_between; ?></div></td>
                            <td class="bodytext31" valign="center"  align="left">
                            <div align="center"><?php echo $days_between; ?></div></td>
                            <td width="17%"class="bodytext31" valign="center"  align="left">
                          <div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>						
						</tr>
					<?php
			
					
					$query5 = "select transactiondate,patientname,patientcode,visitcode,particulars,transactionamount,billnumber,transactionmode,docno from master_transactionpaylater where accountnameano = '$searchsuppliercode' and transactiondate>='$res2transactiondate' and transactiontype = 'pharmacycredit' and patientcode='$res2patientcode' and visitcode='$res2visitcode' order by transactiondate desc";
					$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
					 $num = mysql_num_rows($exec5);
					while ($res5 = mysql_fetch_array($exec5))
					{
						$res5transactiondate = $res5['transactiondate'];
						$res5patientname = $res5['patientname'];
						$res5patientcode = $res5['patientcode'];
						$res5visitcode = $res5['visitcode'];
						$particulars = $res5['particulars'];
						$docno = $res5['docno'];					
						$finalizedbillno = $docno;
						$res5billnumber = $res5['billnumber'];
					 	$res5transactionamount = $res5['transactionamount'];
						$res5transactionmode = $res5['transactionmode'];
						
						
						$t1 = strtotime($ADate2);
						$t2 = strtotime($res5transactiondate);
						$days_between = ceil(abs($t1 - $t2) / 86400);
						
						$total = $total - $res5transactionamount;
						
						if($res5transactionamount == '')
						{
							$res5transactionamount = '0.00';
						}
						else
						{
							$res5transactionamount = $res5['transactionamount'];
						}
						
						if($res5transactionamount != 0)
						{
						if($days_between <= 30)
						{							
							$totalamount30 = $totalamount30 - $res5transactionamount;							
						}
						else if(($days_between >30) && ($days_between <=60))
						{							
							$totalamount60 = $totalamount60 - $res5transactionamount;							
						}
						else if(($days_between >60) && ($days_between <=90))
						{						
							$totalamount90 = $totalamount90 - $res5transactionamount;						
						}
						else if(($days_between >90) && ($days_between <=120))
						{
							$totalamount120 = $totalamount120 - $res5transactionamount;							
						}
						else if(($days_between >120) && ($days_between <=180))
						{							
							$totalamount180 = $totalamount180 - $res5transactionamount;							
						}
						else
						{							
							$totalamountgreater = $totalamountgreater - $res5transactionamount;							
						}
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
						<tr >
							<td width="2%"class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
							<td width="4%"class="bodytext31" valign="center"  align="left">
						  <div class="bodytext31"><?php echo $res5transactiondate; ?></div></td>
							<td width="6%" class="bodytext31" valign="center"  align="left">
						  <div align="left"><?php echo $finalizedbillno; ?></div></td> 
							<td width="9%"class="bodytext31" valign="center"  align="left">
						  <div class="bodytext31"><?php echo $res5patientcode; ?></div></td>  
                            
							<td width="9%"class="bodytext31" valign="center"  align="left">
						  <div class="bodytext31"><?php echo $res5visitcode; ?></div></td>  
                            
							<td width="30%"class="bodytext31" valign="center"  align="left">
						  <div class="bodytext31"><?php echo $res5patientname; ?> ( Cr.Note : Pharma <?php echo $particulars ?></div></td>                              
							                               
							<td width="9%"class="bodytext31" valign="center"  align="right">
							<?php //echo number_format($res3transactionamount,2,'.',''); ?></td>
							<td width="7%"class="bodytext31" valign="center"  align="right">
						  <div align="right"><?php echo number_format($res5transactionamount,2,'.',',');?></div></td>
							<td width="7%"class="bodytext31" valign="center"  align="right">
						  <div align="center"><?php echo $days_between;?></div></td>
							<td width="17%"class="bodytext31" valign="center"  align="left">
						  <div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>							
						</tr>
						<?php
						}	
						$query6 = "select transactiontime,transactiondate,patientname,patientcode,visitcode,billnumber,transactionamount,transactionmode,particulars,docno from master_transactionpaylater where accountnameano = '$searchsuppliercode'  and transactiontype = 'paylatercredit' and patientcode='$res2patientcode' and visitcode='$res2visitcode'  order by transactiondate desc";
						$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
						 $num = mysql_num_rows($exec6);
						while ($res6 = mysql_fetch_array($exec6))
						{
							$res6transactiondate = $res6['transactiondate'];
							$res6transactiontime =$res6['transactiontime'];
							$combinedate1=$res6transactiondate.''.$res6transactiontime;
					
					$res6findate=strtotime($combinedate1);
					if($res6findate>$res2findate)
					{
							$res6patientname = $res6['patientname'];
							$res6patientcode = $res6['patientcode'];
							$res6visitcode = $res6['visitcode'];
							$res6billnumber = $res6['billnumber'];
							$res6transactionamount = $res6['transactionamount'];
							$res6transactionmode = $res6['transactionmode'];
							$particulars = $res6['particulars'];
							$res6docno = $res6['docno'];
							
							
							$billnos = $res6docno; 
													
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
							
							$t1 = strtotime($ADate2);
							$t2 = strtotime($res6transactiondate);
							$days_between = ceil(abs($t1 - $t2) / 86400);							
							$total = $total - $res6transactionamount;
							
							if($res6transactionamount == '')
							{
								$res6transactionamount = '0.00';
							}
							else
							{
								$res6transactionamount = $res6['transactionamount'];
							}
							if($res6transactionamount  != 0)
							{
							if($days_between <= 30)
							{
								$totalamount30 = $totalamount30 - $res6transactionamount;							
							}
							else if(($days_between >30) && ($days_between <=60))
							{						
								$totalamount60 = $totalamount60 - $res6transactionamount;
							}
							else if(($days_between >60) && ($days_between <=90))
							{							
								$totalamount90 = $totalamount90 - $res6transactionamount;							
							}
							else if(($days_between >90) && ($days_between <=120))
							{							
								$totalamount120 = $totalamount120 - $res6transactionamount;							
							}
							else if(($days_between >120) && ($days_between <=180))
							{							
								$totalamount180 = $totalamount180 - $res6transactionamount;							
							}
							else
							{							
								$totalamountgreater = $totalamountgreater - $res6transactionamount;							
							}
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
							<tr >
                                <td width="2%"class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
                                <td width="4%"class="bodytext31" valign="center"  align="left">
                              <div class="bodytext31"><?php echo $res6transactiondate; ?></div></td>
                          					
                                <td width="6%"class="bodytext31" valign="center"  align="left">
                              <div align="left"><?php echo $billnos; ?></div></td>	
								<td width="9%"class="bodytext31" valign="center"  align="left">
                              <div class="bodytext31"><?php echo $res6patientcode; ?></div></td>		
                                
								<td width="9%"class="bodytext31" valign="center"  align="left">
                              <div class="bodytext31"><?php echo $res6visitcode; ?></div></td>		
                                
								<td width="30%"class="bodytext31" valign="center"  align="left">
                              <div class="bodytext31"><?php echo $res6patientname; ?> ( Cr.Note : <?php echo $lab; ?>&nbsp;<?php echo $rad; ?>&nbsp;<?php echo $ser; ?> <?php echo $particulars ?></div></td>		
                                						
                                <td width="9%"class="bodytext31" valign="center"  align="right">
                                <?php //echo number_format($res3transactionamount,2,'.',''); ?></td>						
                                <td width="7%"class="bodytext31" valign="center"  align="right">
                              <div align="right"><?php echo number_format($res6transactionamount,2,'.',',');?></div></td>
                                <td width="7%"class="bodytext31" valign="center"  align="right">
                              <div align="center"><?php echo $days_between;?></div></td>
                                <td width="17%"class="bodytext31" valign="center"  align="left">
                              <div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>							
							</tr>						
							<?php
						}
						}
					
					
					}
					
				 	$query2 = "select transactiondate,patientname,visitcode,billnumber,transactionamount,patientcode,particulars,docno from master_transactionpaylater where accountnameano = '$searchsuppliercode' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'PAYMENT' and transactionstatus='onaccount' order by accountname desc";
					$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
					while ($res2 = mysql_fetch_array($exec2))
					{
						$res2transactiondate = $res2['transactiondate'];
						$res2patientname = $res2['patientname'];
						$res2visitcode = $res2['visitcode'];
						$res2billnumber = $res2['billnumber'];
						$res2docno = $res2['docno'];
						$res2transactionamount = $res2['transactionamount'];
						$res2patientcode = $res2['patientcode'];
						$particulars = $res2['particulars'];
						$snocount = $snocount + 1;
						$t1 = strtotime($ADate2);
						$t2 = strtotime($res2transactiondate);
						$days_between = ceil(abs($t1 - $t2) / 86400);
						if($res2patientname=='')
						{
							$res2patientname='On Account';
						}
					
						
						if($snocount == 1)
						{
							$total = $openingbalance - $res2transactionamount;
						}
						else
						{
							$total = $total - $res2transactionamount;
						}
					
						if ($res2transactionamount == '')
						{
							$res2transactionamount = '0.00';
						}
						else
						{
							$res2transactionamount = $res2['transactionamount'];
						}
						if($res2transactionamount != 0)
						{
							
							
						if($days_between <= 30)
						{
							if($snocount == 1)
							{
								$totalamount30 = $openingbalance - $res2transactionamount;
							}
							else
							{
								$totalamount30 = $totalamount30 - $res2transactionamount;
							}
						}
						else if(($days_between >30) && ($days_between <=60))
						{
							if($snocount == 1)
							{
								$totalamount60 = $openingbalance - $res2transactionamount;
							}
							else
							{
								$totalamount60 = $totalamount60 - $res2transactionamount;
							}
						}
						else if(($days_between >60) && ($days_between <=90))
						{
							if($snocount == 1)
							{
								$totalamount90 = $openingbalance - $res2transactionamount;
							}
							else
							{
								$totalamount90 = $totalamount90 - $res2transactionamount;
							}
						}
						else if(($days_between >90) && ($days_between <=120))
						{
							if($snocount == 1)
							{
								$totalamount120 = $openingbalance - $res2transactionamount;
							}
							else
							{
								$totalamount120 = $totalamount120 - $res2transactionamount;
							}
						}
						else if(($days_between >120) && ($days_between <=180))
						{
							if($snocount == 1)
							{
								$totalamount180 = $openingbalance - $res2transactionamount;
							}
							else
							{
								$totalamount180 = $totalamount180 - $res2transactionamount;
							}
						}
						else
						{
							if($snocount == 1)
							{
								$totalamountgreater = $openingbalance - $res2transactionamount;
							}
							else
							{
								$totalamountgreater = $totalamountgreater - $res2transactionamount;
							}
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
						
						<tr >
                            <td width="2%"class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
                            <td width="4%"class="bodytext31" valign="center"  align="left">
                          <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
                       
                            <td width="6%"class="bodytext31" valign="center"  align="left">
                          <div align="left"><?php echo $res2docno; ?></div></td>  
							 <td width="9%"class="bodytext31" valign="center"  align="left">
                          <div class="bodytext31"><?php echo $res2patientcode; ?></div></td>
                            
							 <td width="9%"class="bodytext31" valign="center"  align="left">
                          <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
                            
							 <td width="30%"class="bodytext31" valign="center"  align="left">
                          <div class="bodytext31"><?php echo $res2patientname; ?>, <?php echo $particulars ?></div></td>
                                                      
                            <td width="9%"class="bodytext31" valign="center"  align="right">                            </td>
                            <td width="7%"class="bodytext31" valign="center"  align="left">
                          <div align="right"><?php echo number_format($res2transactionamount,2,'.',','); ?></div></td>
                            <td width="7%"class="bodytext31" valign="center"  align="left">
                          <div align="center"><?php echo $days_between; ?></div></td>
                            <td width="17%"class="bodytext31" valign="center"  align="left">
                          <div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>						
						</tr>
					
					<?php
					
						
					}
						
				
					//on account paymnent
					
				
}
				$query6 = "select transactiondate,patientname,patientcode,visitcode,billnumber,transactionamount,transactionmode,particulars,docno from master_transactionpaylater where accountnameano = '$searchsuppliercode' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'paylatercredit'and patientname='' order by transactiondate desc";
				$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
				//echo $num = mysql_num_rows($exec6);
				while ($res6 = mysql_fetch_array($exec6))
				{ 
				$res6transactiondate = $res6['transactiondate'];
					$res6patientname = $res6['patientname'];
					$res6patientcode = $res6['patientcode'];
					$res6visitcode = $res6['visitcode'];
					$res6billnumber = $res6['billnumber'];
					$res6transactionamount = $res6['transactionamount'];
					$res6transactionmode = $res6['transactionmode'];
					$particulars = $res6['particulars'];
					$res6docno = $res6['docno'];					
					
					$t1 = strtotime($ADate2);
					$t2 = strtotime($res6transactiondate);
					$days_between = ceil(abs($t1 - $t2) / 86400);
					
					$total = $total - $res6transactionamount;
					
					if($res6transactionamount == '')
					{
						$res6transactionamount = '0.00';
					}
					else
					{
						$res6transactionamount = $res6['transactionamount'];
					}
					if($res6transactionamount != 0)
					{
					
					if($days_between <= 30)
					{				
						$totalamount30 = $totalamount30 - $res6transactionamount;					
					}
					else if(($days_between >30) && ($days_between <=60))
					{					
						$totalamount60 = $totalamount60 - $res6transactionamount;					
					}
					else if(($days_between >60) && ($days_between <=90))
					{				
						$totalamount90 = $totalamount90 - $res6transactionamount;					
					}
					else if(($days_between >90) && ($days_between <=120))
					{					
						$totalamount120 = $totalamount120 - $res6transactionamount;						
					}
					else if(($days_between >120) && ($days_between <=180))
					{					
						$totalamount180 = $totalamount180 - $res6transactionamount;					
					}
					else
					{					
						$totalamountgreater = $totalamountgreater - $res6transactionamount;					
					}
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
					<tr >
                        <td width="2%"class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
                        <td width="4%"class="bodytext31" valign="center"  align="left">
                      <div class="bodytext31"><?php echo $res6transactiondate; ?></div></td>
                        <td width="6%"class="bodytext31" valign="center"  align="left">
                      <div align="left"><?php echo $res6billnumber; ?></div></td>	
						<td width="9%"class="bodytext31" valign="center"  align="left">
                      <div class="bodytext31"><?php echo $res6patientcode; ?></div></td>		
                        
						<td width="9%"class="bodytext31" valign="center"  align="left">
                      <div class="bodytext31"><?php echo $res6visitcode; ?></div></td>		
                        <td width="30%"class="bodytext31" valign="center"  align="left">
                      <div class="bodytext31"><?php echo $res6patientname; ?> ( Cr.Note : <?php echo $particulars ?>)</div></td>		
                        				
                        <td width="9%"class="bodytext31" valign="center"  align="right">
                        <?php //echo number_format($res3transactionamount,2,'.',''); ?></td>				
                        <td width="7%" class="bodytext31" valign="center"  align="right">
                      <div align="right"><?php echo number_format($res6transactionamount,2,'.',',');?></div></td>
                        <td width="7%" class="bodytext31" valign="center"  align="right">
                      <div align="center"><?php echo $days_between;?></div></td>
                        <td width="17%" class="bodytext31" valign="center"  align="left">
                      <div align="right"><?php echo number_format($totalamount30,2,'.',','); ?></div></td>					
					</tr>			
					<?php				
				}
				
				?>
               <tr>
        <td colspan="10">&nbsp;</td>
      </tr>
            <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 
            align="left" border="1">
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
                ><strong>30 days</strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                ><strong>60 days</strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                ><strong>90 days</strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                ><strong>120 days</strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                ><strong>180 days</strong></td>
           <td class="bodytext31" valign="center"  align="right" 
                ><strong>180+ days</strong></td>
           
             	 <td class="bodytext31" valign="center"  align="right" 
                ><strong>Total Due</strong></td>
            </tr>
			<?php 
			
			$grandtotal = $totalamount30 + $totalamount60 + $totalamount90 + $totalamount120 + $totalamount180 + $totalamountgreater ;
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
         	
			     <td class="bodytext31" valign="center"  align="left" 
               >&nbsp;</td>       
               </tr>
			  </table>
            <?php
			}
			?>
         
</table>
</table>
</body>
</html>
