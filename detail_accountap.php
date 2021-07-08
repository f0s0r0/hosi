<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
set_time_limit(0);
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$paymentreceiveddateto1 = "2014-01-01";
$errmsg = "";
$ttlamt = '0.00';
$banum = "1";
$gran =0;
$totalnum2 = 0 ;
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$total = '0.00';
$searchsuppliername = "";
$totalamount3 = "0.00";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$range = "";
$sno = "";
$colorloopcount1="";
$totalamount12 = "0.00";
//This include updatation takes too long to load for hunge items database.


if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = date('Y-m-d',strtotime('-1 month')); }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = date('Y-m-d'); }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
if (isset($_REQUEST["groupid"])) { $parentid = $_REQUEST["groupid"]; } else { $parentid = ""; }
//$frmflag2 = $_POST['frmflag2'];
if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; }
if (isset($_REQUEST["id"])) { $id = $_REQUEST["id"]; } else { $id = ""; }

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
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext44 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none; font-weight:bold
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
    <td valign="top"><table width="99%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
       <tr>
        <td valign="top"><table width="919" id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" 
            align="left" border="0">
			<input type="hidden" name="ledgerid" id="ledgerid">
            <?php
				$query2 = "select accountname from master_accountname where id = '$id'";
				$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
				$res2 = mysql_fetch_array($exec2);
				
				$accountsmain2 = $res2['accountname'];
				?>
				<tbody>
				<tr>
				<td colspan="8" bgcolor="#FFFFFF" class="bodytext3" align="left"><strong><?php echo $accountsmain2.' - '.'From '.date('d-M-Y',strtotime($ADate1)).' '.'to '.date('d-M-Y',strtotime($ADate2)); ?></strong></td>
				</tr>
				<tr bgcolor="#CCC">
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'S.No'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Date'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Docno'; ?></strong></td>
				<td width="103" align="left" class="bodytext3"><strong><?php echo 'Code'; ?></strong></td>
				<td width="190" align="left" class="bodytext3"><strong><?php echo 'Description'; ?></strong></td>
				<td width="141" align="right" class="bodytext3"><strong><?php echo 'Debit'; ?></strong></td>
				<td width="153" align="right" class="bodytext3"><strong><?php echo 'Credit'; ?></strong></td>
				</tr>
				<?php
				$colorloopcount = '';
				$orderid1 = '';
				$lid = '';
				$openingbalance = "0.00";
				$sumopeningbalance = "0.00";
				$totalamount2 = '0.00';
				$totalamount12 = '0.00';
				$balance = '0.00';
				$sumbalance = '0.00';
				$idbuild = "";
				$parentid;				
				
				if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
				if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
				$query267 = "select accountname,auto_number,id from master_accountname where id = '$id'";
				$exec267 = mysql_query($query267) or die ("Error in Query267".mysql_error());
				while($res267 = mysql_fetch_array($exec267))
				{  
					$accountsmain2 = $res267['accountname'];
					$orderid1 = $orderid1 + 1;
					$parentid2 = $res267['auto_number'];
					$ledgeranum = $parentid2;
					//$id2 = $res2['id'];
					$id = $res267['id'];
					//$id2 = trim($id2);
					$lid = $lid + 1;
					
					$querycr1 = "SELECT `transactionamount` as td1,`transactiondate` as td2,`billnumber` as td3,`suppliercode` as td4,`suppliername` as td5 FROM `master_transactionpharmacy` WHERE `suppliercode` = '$id' AND `transactiontype` = 'PURCHASE' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
								 UNION ALL SELECT `totalamount` as td1,`entrydate` as td2,`billnumber` as td3,`suppliercode` as td4,`suppliername` as td5 FROM `purchasereturn_details` WHERE `suppliercode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT (transactionamount) as td1,transactiondate as td2, docno as td3, accountcode as td4, accountname as td5 FROM master_transactionpayroll WHERE accountcode = '$id' AND transactiontype = 'PROCESS' AND updatedate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT (depreciation) as td1, entrydate as td2, billnumber as td3, processmonth as td4, itemname as td5 FROM assets_depreciation WHERE accdepreciationledgercode = '$id' AND entrydate BETWEEN '$ADate1' AND '$ADate2'
						UNION ALL SELECT (`totalamount`) as td1, entrydate as td2, billnumber as td3, purchasetype as td4, itemname as td5 FROM `purchase_details` WHERE `accdepreciation_code` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and recordstatus <> 'deleted'";
					$execcr1 = mysql_query($querycr1) or die ("Error in Querycr1".mysql_error());
					while($rescr1 = mysql_fetch_array($execcr1))
					{
					$amount = $rescr1['td1'];
					$entrydate = $rescr1['td2'];
					$docno = $rescr1['td3'];
					$itemcode = $rescr1['td4'];
					$itemname = $rescr1['td5'];
					$sumbalance = $sumbalance + $amount;
					
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
					<td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
					<td align="left" class="bodytext3"><?php echo $entrydate; ?></td>
					<td align="left" class="bodytext3"><?php echo $docno; ?></td>
					<td align="left" class="bodytext3"><?php echo $itemcode; ?></td>
					<td align="left" class="bodytext3"><?php echo $itemname; ?></td>
					<td align="left" class="bodytext3">&nbsp;</td>
					<td align="right" class="bodytext3"><?php echo number_format($amount,2,'.',','); ?></td>
					</tr>
					<?php
					}
					$querydr1 = "SELECT `transactionamount` as td1,`transactiondate` as td2,`docno` as td3,`suppliercode` as td4,`suppliername` as td5 FROM `master_transactionpharmacy` WHERE `suppliercode` = '$id' AND `transactionmodule` = 'PAYMENT' AND `recordstatus` = 'allocated' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
								 UNION ALL SELECT `totalamount` as td1,`entrydate` as td2,`billnumber` as td3,`itemcode` as td4,`itemname` as td5 FROM `purchasereturn_details` WHERE `suppliercode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
							UNION ALL SELECT (`transactionamount`) as td1, transactiondate as td2, docno as td3, accountcode as td4, accountname as td5 FROM `master_transactionpayroll` WHERE `accountcode` = '$id' AND `transactionmodule` = 'PAYMENT' AND `recordstatus` = 'allocated' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'";
					$execdr1 = mysql_query($querydr1) or die ("Error in Querydr1".mysql_error());
					while($resdr1 = mysql_fetch_array($execdr1))
					{
					$amount = $resdr1['td1'];
					$entrydate = $resdr1['td2'];
					$docno = $resdr1['td3'];
					$itemcode = $resdr1['td4'];
					$itemname = $resdr1['td5'];
					$sumbalance = $sumbalance - $amount;
		
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
					<td align="left" class="bodytext3"><?php echo $colorloopcount; ?></td>
					<td align="left" class="bodytext3"><?php echo $entrydate; ?></td>
					<td align="left" class="bodytext3"><?php echo $docno; ?></td>
					<td align="left" class="bodytext3"><?php echo $itemcode; ?></td>
					<td align="left" class="bodytext3"><?php echo $itemname; ?></td>
					<td align="right" class="bodytext3"><?php echo '-'.number_format($amount,2,'.',','); ?></td>
					<td align="left" class="bodytext3">&nbsp;</td>
					</tr>
					<?php
					}
					}
					?>
					<tr bgcolor="#CCC">
					<td colspan="7" align="right" class="bodytext3"><strong><?php echo number_format($sumbalance,2); ?></strong></td>
					</tr>
</tbody>				
</table>
</td>
</tr>

</table>
</table>

<?php include ("includes/footer1.php"); ?>
</body>
</html>
