<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno=$_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');


$locationdetails="select locationcode from login_locationdetails where username='$username' and docno ='$docno'";
$exlocdetail=mysql_query($locationdetails);
$resloc=mysql_fetch_array($exlocdetail);
$locationcode=$resloc['locationcode'];


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
$total30=0;
$total60=0;
$total90=0;
$total120=0;
$total180=0;
$total210=0;
$res11transactionamount='0';
$res12transactionamount='0';
$res2transactionamount=0;
$res3transactionamount=0;
$res4transactionamount=0;
$res5transactionamount=0;
$res6transactionamount=0;
$restot='0';
$searchaccountcode=isset($_REQUEST['accountcode'])?$_REQUEST['accountcode']:'';
	$accountanum=isset($_REQUEST['accountanum'])?$_REQUEST['accountanum']:'';
	$searchaccount=isset($_REQUEST['accountname'])?$_REQUEST['accountname']:'';
//This include updatation takes too long to load for hunge items database.
include ("autocompletebuild_accounts_1.php");
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["searchsuppliercode"])) { $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = $paymentreceiveddatefrom; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = $paymentreceiveddateto; }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];
$searchsuppliername=trim($searchsuppliername);
$searchsuppliername=rtrim($searchsuppliername);
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
if((document.getElementById("accountname").value == "")||(document.getElementById("accountname").value == " "))
{
alert('Please Select Account Name.');
return false;
}
}
</script>
<script type="text/javascript" src="js/autocomplete_accounts1.js"></script>
<script type="text/javascript" src="js/autosuggest3accounts.js"></script>
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("accountname"), new StateSuggestions());        
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
		
		
              <form name="cbform1" method="post" action="nhifstatement.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#CCCCCC" class="bodytext3"><strong>Account Statement</strong></td>
              </tr>
            <!--<tr>
              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
			  <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Payment Entry" /> 
                *To Print Other Receipts Please Go To Menu:	Reports	-&gt; Payments Given 
				</td>
              </tr>-->
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Account </td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
              <input name="accountname" type="text" id="accountname" style="border: 1px solid #001E6A;" value="<?php echo $searchaccount; ?>" size="50" autocomplete="off">
                <input type="hidden" name="accountcode" id="accountcode" value="<?php echo $searchaccountcode; ?>">
                <input type="hidden" name="accountanum" id="accountanum" value="<?php echo $accountanum; ?>">
				<input type="hidden" name="accountnamenew" id="accountnamenew" value="">
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
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit" onClick="return funcAccount();" value="Search" name="Submit" />
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1090" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="2%" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
              <td colspan="14" bgcolor="#cccccc" class="bodytext31"><span class="bodytext311">
              <?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				?>
              <!--<input  value="Print Report" onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" />
&nbsp;				<input  value="Export Excel" onClick="javascript:printbillreport2()" name="resetbutton22" type="button" id="resetbutton22"  style="border: 1px solid #001E6A" />-->
</span></td>  
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>
              <td width="32%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Description </strong></td>
                
		<td width="8%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>NHIF ID</strong></div></td>
				<td width="13%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Bill number </strong></td>
              <td width="11%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Debit</strong></td>
              <td width="11%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Credit</strong></div></td>
				<td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Days</strong></div></td>
				<td width="11%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Current Balance</strong></div></td>
				
            </tr>
			<?php
			
			$openingbalance='0';
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			$openingbalance='0';
		$totaldebit='0';
		$totalcredit='0';
		//debit
				 	$query5 = "select sum(amount) as amount from billing_ipnhif where  locationcode='$locationcode'  and recorddate < '$ADate1' order by recorddate desc";
					$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
					 $num = mysql_num_rows($exec5);
					while ($res5 = mysql_fetch_array($exec5))
					{
						 
					 	$res5transactionamount = abs($res5['amount']);
						$totaldebit =$totaldebit + $res5transactionamount;
						}	
					
					//credit
									
					$query2 = "select sum(transactionamount) as transactionamount from master_transactionpaylater where accountnameano = '$accountanum' and transactiondate < '$ADate1' and locationcode='$locationcode' order by accountname desc";
					$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
 					$numrw=mysql_num_rows($exec2);
					while ($res2 = mysql_fetch_array($exec2))
					{
					$res2transactionamount = $res2['transactionamount'];
					$totalcredit = $totalcredit + $res2transactionamount;			
					}

			$openingbalance=$totaldebit-$totalcredit;}
		  ?>
			<tr>
			<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc"><strong>&nbsp;</strong></td>
				
              <td width="6%" align="left" valign="center"  
                bgcolor="#cccccc" class="bodytext31"><div align="left"><strong>&nbsp;</strong></div></td>
               
              <td width="32%" align="left" valign="center"  
                bgcolor="#cccccc" class="bodytext31"><strong> Opening Balance </strong></td>
                 <td width="8%" align="left" valign="center"  
                bgcolor="#cccccc" class="bodytext31"><div align="left"><strong>&nbsp;</strong></div></td>
              <td width="13%" align="right" valign="center"  
                bgcolor="#cccccc" class="bodytext31"><strong>&nbsp;</strong></td>
              <td width="11%" align="left" valign="center"  
                bgcolor="#cccccc" class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>
			 <td width="11%" align="left" valign="center"  
                bgcolor="#cccccc" class="bodytext31"><div align="right"><strong>&nbsp;</strong></div></td>	
				<td colspan="2" align="left" valign="center"  
                bgcolor="#cccccc" class="bodytext31"><div align="right"><strong><?php echo number_format($openingbalance,2,'.',','); ?></strong></div></td>
			</tr>
			<?php
			//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
			if ($cbfrmflag1 == 'cbfrmflag1')
			{				
				$query22 = "select accountname from master_accountname where auto_number = '$accountanum' and recordstatus <>'DELETED' ";
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
					
					
					//debit
				 	$query5 = "select * from billing_ipnhif where  locationcode='$locationcode'  and recorddate between '$ADate1' and '$ADate2' order by recorddate desc";
					$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
					 $num = mysql_num_rows($exec5);
					while ($res5 = mysql_fetch_array($exec5))
					{
						$totalbalanceamount=0;
						 $res5transactiondate = $res5['recorddate'];
						$res5patientname = $res5['patientname'];
						$res5patientcode = $res5['patientcode'];
						$res5visitcode = $res5['visitcode'];
						//$particulars = $res5['particulars'];
						$docno = $res5['docno'];					
						$finalizedbillno = $docno;
						//$res5billnumber = $res5['billnumber'];
						$res5transactionamount = $res5['transactionamount'];
						$totalamount=abs($res5['amount']);
						
						$totalbalanceamount=$totalamount-$res5transactionamount;
					//	$res5transactionmode = $res5['transactionmode'];

						$query88 = mysql_query("select nhifid from master_ipvisitentry where patientcode = '$res5patientcode' and visitcode = '$res5visitcode'");
						$res88 = mysql_fetch_array($query88);
						$nhifid = $res88['nhifid'];
						
					
						$t1 = strtotime($ADate2);
						$t2 = strtotime($res5transactiondate);
						$days_between = ceil(abs($t1 - $t2) / 86400);
						$snocount = $snocount + 1;
						
						if($snocount == 1)
						{
							$total = $openingbalance + $totalamount;
						}
						else
						{
							$total = $total + $totalamount;
						}
						if($res5transactionamount == '')
						{
							$res5transactionamount = '0.00';
						}
						else
						{
							$res5transactionamount = $res5['transactionamount'];
						}
						
						
						if($days_between <= 30)
						{							
							$totalamount30 = $totalamount30 + $totalamount;							
						}
						else if(($days_between >30) && ($days_between <=60))
						{							
							$totalamount60 = $totalamount60 + $totalamount;							
						}
						else if(($days_between >60) && ($days_between <=90))
						{						
							$totalamount90 = $totalamount90 + $totalamount;						
						}
						else if(($days_between >90) && ($days_between <=120))
						{
							$totalamount120 = $totalamount120 + $totalamount;							
						}
						else if(($days_between >120) && ($days_between <=180))
						{							
							$totalamount180 = $totalamount180 + $totalamount;							
						}
						else
						{							
							$totalamountgreater = $totalamountgreater  + $totalamount;							
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
							<td width="2%"class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
							<td width="6%"class="bodytext31" valign="center"  align="left">
							<div class="bodytext31"><?php echo $res5transactiondate; ?></div></td>
							<td width="32%"class="bodytext31" valign="center"  align="left">
							<div class="bodytext31"><?php echo $res5patientname; ?> (<?php echo $res5patientcode; ?>,<?php echo $res5visitcode; ?>,<?php echo $finalizedbillno; ?>)</div></td>  
                            <td width="8%"class="bodytext31" valign="center"  align="left">
                            <div class="bodytext31"><?php echo $nhifid; ?></div></td>                              
							<td width="13%" class="bodytext31" valign="center"  align="left">
							<div align="right"><?php echo $finalizedbillno; ?></div></td>                                
							<td width="11%"class="bodytext31" valign="center"  align="right">
							<?php echo number_format($totalamount,2,'.',''); ?></td>
							<td width="11%"class="bodytext31" valign="center"  align="right">
							<div align="right"><?php //echo number_format($res5transactionamount,2,'.',',');?></div></td>
							<td width="6%"class="bodytext31" valign="center"  align="right">
							<div align="center"><?php echo $days_between;?></div></td>
							<td width="11%"class="bodytext31" valign="center"  align="left">
							<div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>							
						</tr>
						<?php
							
					}
					//credit
									
					$query2 = "select * from master_transactionpaylater where accountnameano = '$accountanum' and transactiondate between '$ADate1' and '$ADate2' order by accountname desc";
					$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
 					$numrw=mysql_num_rows($exec2);
					while ($res2 = mysql_fetch_array($exec2))
					{
			
						$res2transactionamount=0;
						$res2transactiondate = $res2['transactiondate'];
						$res2transactiontime = $res2['transactiontime'];
						$combinedate=$res2transactiondate.''.$res2transactiontime;
					
						$res2findate=strtotime($combinedate);
					
					
						$res2transactionamount = $res2['transactionamount'];
						
						
						$accountname=$res2['accountname'];
						$docno1=$res2['docno'];
						
						$snocount = $snocount + 1;
						$t1 = strtotime($ADate2);
						$t2 = strtotime($res2transactiondate);
						$days_between = ceil(abs($t1 - $t2) / 86400);
						
					
						
					
						//$res2transactionamount = $res2transactionamount-$res7sumtransactionamount-$res8sumtransactionamount;
						
						if($snocount == 1)
						{
							$total = $openingbalance - $res2transactionamount;
						}
						else
						{
							$total = $total - $res2transactionamount;
						}
						if($res2transactionamount !=0)
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
						<tr <?php echo $colorcode; ?>>
                            <td width="2%" class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
                            <td width="6%"class="bodytext31" valign="center"  align="left">
                            <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
                            <td width="32%"class="bodytext31" valign="center"  align="left">
                            <div class="bodytext31"><?= $accountname.''.$docno1;?></div></td>
                             <td width="8%"class="bodytext31" valign="center"  align="left">
                            <div class="bodytext31"><?php echo ""; ?></div></td>
                            
                            <td width="13%"class="bodytext31" valign="center"  align="left">
                            <div align="right"><?php echo $docno1; ?></div></td>                            
                            <td width="11%"class="bodytext31" valign="center"  align="right">
                            <?php echo ""; ?></td>
                            <td width="11%"class="bodytext31" valign="center"  align="left">
                            <div align="right"><?php echo number_format($res2transactionamount,2,'.',','); ?></div></td>
                            <td class="bodytext31" valign="center"  align="left">
                            <div align="center"><?php echo $days_between; ?></div></td>
                            <td width="11%"class="bodytext31" valign="center"  align="left">
                            <div align="right"><?php echo number_format($total,2,'.',','); ?></div></td>						
						</tr>
					<?php
			
					
					}
				}
				 	
				?>
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
			
			$grandtotal = $totalamount30 + $totalamount60 + $totalamount90 + $totalamount120 + $totalamount180 + $totalamountgreater ;
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
                bgcolor="#D3EEB7"><?php echo number_format($total,2,'.',','); ?></td>
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
         	<?php
			
				$urlpath = "cbfrmflag1=cbfrmflag1&&ADate1=$ADate1&&ADate2=$ADate2&&accountcode=$searchaccountcode&&accountanum=$accountanum";
			
			?>
		    <td class="bodytext31" valign="center"  align="right"><a href="print_nhifstatement.php?<?php echo $urlpath; ?>&&locationcode=<?=$locationcode;?>"><img  width="40" height="40" src="images/excel-xls-icon.png" style="cursor:pointer;"></a></td>
			            
               </tr>
			  </table>
            <?php
			}
			?>
         
</table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
