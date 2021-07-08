<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$dateonly = date("Y-m-d");
$colorloopcount = "";
$runningbalance = 0;
$totalunpre = 0;
$totalunclr = 0;

if (isset($_REQUEST["frmflg1"])) { $frmflg1 = $_REQUEST["frmflg1"]; } else { $frmflg1 = ""; }

if (isset($_REQUEST["ADate1"])) { $transactiondatefrom = $_REQUEST["ADate1"]; } else { $transactiondatefrom = date("Y-m-d"); }
if (isset($_REQUEST["ADate2"])) { $transactiondateto = $_REQUEST["ADate2"]; } else { $transactiondateto = date("Y-m-d"); }
if (isset($_REQUEST["bankname"])) 
{ 
	$bankfullname = $_REQUEST["bankname"];
	/*$bankfullname = explode("-",$bankfullname,2);
	$banknamereq = $bankfullname[0];
	$accountnumberreq = $bankfullname[1];*/
} 
else 
{ 
	$bankfullname = "";
	/*$banknamereq = "";
	$accountnumberreq = "";*/
}
$colorcode = 'bgcolor="#CBDBFA"';

?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
</style>
<!--<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
--><style type="text/css">

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}

</style>
<script>
function functiontest()
{
if(document.getElementById("bankname").value == "")
{
 alert("Please Select Bank To Proceed");
 document.getElementById("bankname").focus();
 return false;
}
/*if(document.getElementById("transactiontype").value == '')
{
	alert("Please Select Transaction Type To Proceed");
	 document.getElementById("transactiontype").focus();
 	return false;
}*/
}
	</script>
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
    <td colspan="10" bgcolor="#E0E0E0"><?php  include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
            <tr>
              <td>
              <form method="post" action="banktransactionstatement.php">
                <table width="759" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>			  
                <tr>
                  <td  colspan="5" bgcolor="#CCCCCC" class="bodytext3"><strong>Bank Transaction Statement</strong></td>
                  </tr>
                <tr>
                  <td width="90" bgcolor="#ffffff" class="bodytext3"><div align="left">Bank  Name</div></td>
                  <td bgcolor="#ffffff" class="bodytext3"><select name="bankname" id="bankname">
                    <option value="">SELECT BANK </option>
                    <?php
				 	$query11 = "select * from master_bank where bankstatus ='' ";
					$exec11 = mysql_query($query11) or die("Error in Query11".mysql_error());
					while($res11 = mysql_fetch_array($exec11))
					{
					$bankname = $res11["bankname"];
					$accountnumber = $res11["accountnumber"];
					$bankcode = $res11["bankcode"];
					 ?>
                    <option value="<?php echo $bankcode;?>"
                     <?php if($bankname == $bankfullname){?> selected <?php } ?>>
						<?php echo $bankname;?>-<?php echo $accountnumber;?>
                    </option>
                    <?php
					 }
					 ?>
                  </select></td>
                  <td bgcolor="#ffffff" class="bodytext3">&nbsp;</td>
                  <td bgcolor="#ffffff" class="bodytext3">&nbsp;</td>
                </tr>
                <tr>
                  <td bgcolor="#ffffff" class="bodytext3"><span class="bodytext31">Date From </span></td>
                  <td width="192" bgcolor="#ffffff" class="bodytext3"><span class="bodytext31">
                    <input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                    <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/></span></td>
                  <td width="107" bgcolor="#ffffff" class="bodytext3"><span class="bodytext31">Date To</span></td>
                  <td width="159" bgcolor="#ffffff" class="bodytext3"><span class="bodytext31">
                    <input name="ADate2" id="ADate2" style="border: 1px solid #001E6A" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                    <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/></span></td>
                  </tr>
                  <tr>
				  	<td bgcolor="#ffffff">&nbsp;</td>
                    <td align="left" valign="middle" bgcolor="#ffffff" class="bodytext3">
 					<input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1" >				  
				  <input  style="border: 1px solid #001E6A" type="submit" value="Search" name="Submit" onClick="return functiontest()" /></td>
				  <td bgcolor="#ffffff">&nbsp;</td>
				  <td bgcolor="#ffffff">&nbsp;</td>
                  </tr>
				  </tbody>
				  </table>
				  </form>
			    </td>
				  </tr>
				  <tr><td>&nbsp;</td></tr>
                <tr >
				<td><table width="" align="left" cellpadding="4" cellspacing="0"  style="border-collapse: collapse">
				<?php
 					$sno = 0;
				if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
				//$cbfrmflag1 = $_POST['cbfrmflag1'];
				if ($frmflag1 == 'frmflag1')
				{	
					if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
					if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
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
					   $bankname = $bankfullname;
						/*$bankname = $_REQUEST["bankname"];
						$banknameexplode = explode("-",$bankname,4);
						
						echo $bankname1 = $banknameexplode[0];
						$bankname1 = trim($bankname1);
						$bankname2 = $banknameexplode[1];
						$bankname2 = trim($bankname2);*/
				?>
					
				<tr>
                  <td width="30" bgcolor="#CCCCCC" class="bodytext3" align="center" valign="middle"><strong>No</strong></td>
				  <td width="90" bgcolor="#CCCCCC" class="bodytext3" align="left" valign="middle"><strong>Posting Date</strong></td>
                  <td width="90" bgcolor="#CCCCCC" class="bodytext3" align="left" valign="middle"><strong>Value Date</strong></td>
                  <td width="100" bgcolor="#CCCCCC" class="bodytext3" align="left" valign="middle"><strong>Description</strong></td>
				  <td width="50" bgcolor="#CCCCCC" class="bodytext3" align="left" valign="middle"><strong>Transaction <br/> Ref No</strong></td>
				  <td width="150" bgcolor="#CCCCCC" class="bodytext3" align="right" valign="middle"><strong>Money In</strong></td>
                  <td width="150" bgcolor="#CCCCCC" class="bodytext3" align="right" valign="middle"><strong>Money Out</strong></td>
                  <td width="150" bgcolor="#CCCCCC" class="bodytext3" align="right" valign="middle"><strong>Running Balance</strong></td>
                </tr>
				  <?php
				  $totatlmoneyin = 0;
				  $totatlmoneyout = 0;
				  $totatlrunningbal = 0;
				  $moneyin = 0;
				  $moneyout = 0;
				  $runningbalancecalc =0;
				  $temp = 0;
				  $runningbalance = 0;
				  $sno=0;
				  $opening = 0;
				  
				  $query = "select openbalanceamount,entrydate,docno from openingbalanceaccount where accountname = '$bankname'";
				  $exec = mysql_query($query) or die ("Error in Query".mysql_error());
				  while($res = mysql_fetch_array($exec))
				  {
				  	$openingbal = $res['openbalanceamount'];
					$entrydate = $res['entrydate'];
					$docno = $res['docno'];
					$opening = $opening + $openingbal;

				  		$moneyin = 	$opening;
						$moneyout = 0;
				
						$runningbalance = $runningbalance + $moneyin - $moneyout;
						
				  $colorcode = 'bgcolor="#CBDBFA"';
				  ?>
				  <!--<tr  <?php echo $colorcode; ?>>
                  <td class="bodytext3" valign="middle"  align="center"><?php //echo $sno = $sno+1;?> </td>
				  <td class="bodytext3" valign="middle"  align="left"><?php echo $entrydate; ?></td>
                  <td class="bodytext3" valign="middle"  align="left"><?php echo '';?></td>
                  <td class="bodytext3" valign="middle"  align="left"><?php echo 'OPENING BALANCE';?></td>
				  <td class="bodytext3" valign="middle"  align="left"><?php echo $docno;?></td>
                  <td class="bodytext3" valign="middle"  align="right"><?php echo number_format($moneyin,2,'.',',');?> </td>
                  <td class="bodytext3" valign="middle"  align="right"><?php echo number_format($moneyout,2,'.',',');?></td>
                  <td class="bodytext3" valign="center"  align="right"><?php echo number_format($runningbalance,2,'.',',');?></td>
                </tr>-->
				<?php
				}
				?>
				<?php
				$qrybankstatements = "SELECT postdate,bankdate,remarks,docno,bankamount,notes,status FROM bank_record WHERE postdate < '$transactiondatefrom' AND bankcode = '$bankname' AND status IN ('Posted','Unpresented','Uncleared')";
					$excebankstatements = mysql_query($qrybankstatements) or die("Error in qrybankstatements".mysql_error());
			
					while($resbankstatement = mysql_fetch_array($excebankstatements))
					{
					  $postingdate = $resbankstatement["postdate"];
					  $valuedate = $resbankstatement["bankdate"];
					  $description = $resbankstatement["remarks"];
					  $transrefno = $resbankstatement["docno"];
					  $notes = $resbankstatement["notes"];
					  $status = $resbankstatement["status"];
					  	
						$query2 = "select amount, creditamount from bankentryform where docnumber = '$transrefno' and (frombankid = '$bankname' or tobankid = '$bankname')";
						$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
						$res2 = mysql_fetch_array($exec2);
						$num2 = mysql_num_rows($exec2);
						$dramount = $res2['amount'];
						$cramount = $res2['creditamount'];
						if($num2 == 0)
						{
							//MONEY IN  -- notes type is accountrecievelbe
							if($notes == 'accounts receivable')
							{
								if($status == 'Unpresented')
								{
									$moneyin = 0;
									$moneyout = $resbankstatement["bankamount"];
								}
								else if($status == 'Uncleared')
								{
									$moneyin = 	$resbankstatement["bankamount"];
									$moneyout = 0;
								}
								else
								{
									$moneyin = 	$resbankstatement["bankamount"];
									$moneyout = 0;
								}
							}
							else //MONEY OUT
							{
								$moneyout = $resbankstatement["bankamount"];
								$moneyin = 0;
							}
						}
						else
						{
							$moneyin = 	$dramount;
							$moneyout = $cramount;
						}	
						
						$runningbalance = $runningbalance + $moneyin - $moneyout;
						
						/*if($moneyout!=0 && $moneyin == 0)
						{
							if($temp == 0)
							{
								$runningbalancecalc = $runningbalancecalc + $moneyout;
								$runningbalance = "-".number_format($runningbalancecalc,2,'.',',');
							}
							else
							{
								$runningbalancecalc = $temp - $moneyout;
								$runningbalance = number_format($runningbalancecalc,2,'.',',');
								$temp = $runningbalancecalc;
							}
						}
						if($moneyin!= 0 && $moneyout==0)
						{
							if($moneyin>$runningbalancecalc)
							{
								$runningbalancecalc =$moneyin - $runningbalancecalc;
								$runningbalance = number_format($runningbalancecalc,2,'.',',');
								$temp = $runningbalancecalc;
							}
							if($moneyin == $runningbalancecalc)
							{
								$runningbalancecalc = $moneyin - $runningbalancecalc;
								$runningbalance = number_format($runningbalancecalc,2,'.',',');
							}
							
						}*/
						
						$colorcode = 'bgcolor="#CBDBFA"';
						
						//TOTALS
						//$totatlmoneyin = $totatlmoneyin + $moneyin;
						//$totatlmoneyout = $totatlmoneyout + $moneyout;
						//$totatlrunningbal = $totatlrunningbal + $runningbalance;
					}
					?>	
					<tr  <?php echo $colorcode; ?>>
                  <td class="bodytext3" valign="middle"  align="center"><?php echo $sno = $sno+1;?> </td>
				  <td class="bodytext3" valign="middle"  align="center"><?php //echo $sno = $sno+1; ?> </td>
				  <td colspan="3" class="bodytext3" valign="middle"  align="left"><?php echo 'OPENING BALANCE AND BALANCE CARRIED OVER'; ?></td>
                  <td class="bodytext3" valign="center"  align="right"><?php //echo number_format($totatlmoneyin,2,'.',',');?></td>
				  <td class="bodytext3" valign="center"  align="right"><?php //echo number_format($totatlmoneyout,2,'.',',');?></td>
				  <td class="bodytext3" valign="center"  align="right"><?php echo number_format($runningbalance,2,'.',',');?></td>
                </tr>
				  <?php
				  $qrybankstatements = "SELECT postdate,bankdate,remarks,docno,bankamount,notes,status FROM bank_record WHERE postdate BETWEEN '$transactiondatefrom' AND  '$transactiondateto' AND bankcode = '$bankname' AND status IN ('Posted','Unpresented','Uncleared')";
					$excebankstatements = mysql_query($qrybankstatements) or die("Error in qrybankstatements".mysql_error());
			
					while($resbankstatement = mysql_fetch_array($excebankstatements))
					{
					  $postingdate = $resbankstatement["postdate"];
					  $valuedate = $resbankstatement["bankdate"];
					  $description = $resbankstatement["remarks"];
					  $transrefno = $resbankstatement["docno"];
					  $notes = $resbankstatement["notes"];
					  $status = $resbankstatement["status"];
					  	
						$query2 = "select amount, creditamount from bankentryform where docnumber = '$transrefno' and (frombankid = '$bankname' or tobankid = '$bankname')";
						$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
						$res2 = mysql_fetch_array($exec2);
						$num2 = mysql_num_rows($exec2);
						$dramount = $res2['amount'];
						$cramount = $res2['creditamount'];
						if($num2 == 0)
						{
							//MONEY IN  -- notes type is accountrecievelbe
							if($notes == 'accounts receivable')
							{
								if($status == 'Unpresented')
								{
									$moneyin = 0;
									$moneyout = $resbankstatement["bankamount"];
									$totalunpre = $resbankstatement["bankamount"];
								}
								else if($status == 'Uncleared')
								{
									$moneyin = 	$resbankstatement["bankamount"];
									$moneyout = 0;
									$totalunclr = $resbankstatement["bankamount"];
								}
								else
								{
									$moneyin = 	$resbankstatement["bankamount"];
									$moneyout = 0;
								}
							}
							else //MONEY OUT
							{
								$moneyout = $resbankstatement["bankamount"];
								$moneyin = 0;
							}
						}
						else
						{
							$moneyin = 	$dramount;
							$moneyout = $cramount;
						}	
						
						$runningbalance = $runningbalance + $moneyin - $moneyout;
						
						/*if($moneyout!=0 && $moneyin == 0)
						{
							if($temp == 0)
							{
								$runningbalancecalc = $runningbalancecalc + $moneyout;
								$runningbalance = "-".number_format($runningbalancecalc,2,'.',',');
							}
							else
							{
								$runningbalancecalc = $temp - $moneyout;
								$runningbalance = number_format($runningbalancecalc,2,'.',',');
								$temp = $runningbalancecalc;
							}
						}
						if($moneyin!= 0 && $moneyout==0)
						{
							if($moneyin>$runningbalancecalc)
							{
								$runningbalancecalc =$moneyin - $runningbalancecalc;
								$runningbalance = number_format($runningbalancecalc,2,'.',',');
								$temp = $runningbalancecalc;
							}
							if($moneyin == $runningbalancecalc)
							{
								$runningbalancecalc = $moneyin - $runningbalancecalc;
								$runningbalance = number_format($runningbalancecalc,2,'.',',');
							}
							
						}*/
						
						//TOTALS
						$totatlmoneyin = $totatlmoneyin + $moneyin;
						$totatlmoneyout = $totatlmoneyout + $moneyout;
						//$totatlrunningbal = $totatlrunningbal + $runningbalance;
						
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
				<tr  <?php echo $colorcode; ?>>
                  <td class="bodytext3" valign="middle"  align="center"><?php echo $sno = $sno+1;;?> </td>
				  <td class="bodytext3" valign="middle"  align="left"><?php echo $postingdate;?></td>
                  <td class="bodytext3" valign="middle"  align="left"><?php echo $valuedate;?></td>
                  <td class="bodytext3" valign="middle"  align="left"><?php echo $description.' ('.$status.')';?></td>
				  <td class="bodytext3" valign="middle"  align="left"><?php echo $transrefno;?></td>
                  <td class="bodytext3" valign="middle"  align="right"><?php echo number_format($moneyin,2,'.',',');?> </td>
                  <td class="bodytext3" valign="middle"  align="right"><?php echo number_format($moneyout,2,'.',',');?></td>
                  <td class="bodytext3" valign="center"  align="right"><?php echo number_format($runningbalance,2,'.',',');?></td>
                </tr>
		    <?php
					}//CLOSE -- WHILE LOOP
			     ?>
                 <tr>
                 	<td colspan="5" class="bodytext3" bgcolor="#999999" align="right" valign="middle"><strong>Total</strong></td>
                    <td class="bodytext3" bgcolor="#999999" align="right" valign="middle"><strong><?php echo number_format($totatlmoneyin,2,'.',','); ?></strong></td>
                    <td class="bodytext3" bgcolor="#999999" align="right" valign="middle"><strong><?php echo number_format($totatlmoneyout,2,'.',','); ?></strong></td>
                    <td  class="bodytext3" bgcolor="#999999" align="right" valign="middle">&nbsp;</td>
                    <!--<td class="bodytext3" bgcolor="#999999" align="right" valign="middle"><strong><?php //echo number_format($totatlrunningbal,2,'.',','); ?></strong></td>
-->                 <td align="left" valign="center" bgcolor="#e0e0e0" class="bodytext3"><div align="left"><a target="_blank" href="print_banktransactionstmnt.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&bankname=<?php echo $bankname; ?>"><img src="images/pdfdownload.jpg" width="30" height="30"></a></div></td>
                    <td align="right" valign="center" bgcolor="#e0e0e0" class="bodytext3"><div align="left"><a target="_blank" href="print_banktransactionstmnt_xls.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>&&bankname=<?php echo $bankname; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></div></td>
                 </tr>
                 <tr>
                 	<td colspan="5" class="bodytext3" bgcolor="#999999" align="right" valign="middle"><strong>Total Unpresented</strong></td>
                    <td class="bodytext3" bgcolor="#999999" align="right" valign="middle"><strong><?php echo number_format(0,2,'.',','); ?></strong></td>
                    <td class="bodytext3" bgcolor="#999999" align="right" valign="middle"><strong><?php echo number_format($totalunpre,2,'.',','); ?></strong></td>
                    <td  class="bodytext3" bgcolor="#999999" align="right" valign="middle">&nbsp;</td>
                 </tr>
                 <tr>
                 	<td colspan="5" class="bodytext3" bgcolor="#999999" align="right" valign="middle"><strong>Total Uncleared</strong></td>
                    <td class="bodytext3" bgcolor="#999999" align="right" valign="middle"><strong><?php echo number_format($totalunclr,2,'.',','); ?></strong></td>
                    <td class="bodytext3" bgcolor="#999999" align="right" valign="middle"><strong><?php echo number_format(0,2,'.',','); ?></strong></td>
                    <td  class="bodytext3" bgcolor="#999999" align="right" valign="middle">&nbsp;</td>
                 </tr>
             
				<tr>
                 	<td colspan="6" class="bodytext3" bgcolor="#999999" align="right" valign="middle"><strong>Total Bank Balance :</strong></td>
                    <td class="bodytext3" bgcolor="#999999" align="right" valign="middle"><strong><?php echo number_format($runningbalance,2,'.',','); ?></strong></td>
                    <td  class="bodytext3" bgcolor="#999999" align="right" valign="middle">&nbsp;</td>
                </tr>
				 <?php   		
				} //CLOSE -- IF(frmflag1)
				?>	
	      </table>
          </td>
            </tr>  
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

