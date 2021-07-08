<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$ADate1 = date('Y-m-d', strtotime('01-01-2015'));
$ADate2 = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$type1 = '';
$acccoa = '';
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
$sno = "";
$colorloopcount1="";
$grandtotal = '';
$grandtotal1 = "0.00";
$openingbalancecredit = "0.00";
$openingbalancedebit = "0.00";
$totalamount2 = '0.00';
$totalamount21 = '0.00';
$totalamount3 = '0.00';
$totalamount4 = '0.00';
//This include updatation takes too long to load for hunge items database.
//include ("autocompletebuild_ledger.php");

if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = date('Y-m-d', strtotime('01-01-2017')); }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = date('Y-m-d'); }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }

if (isset($_REQUEST["module"])) { $module = $_REQUEST["module"]; } else { $module = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if (isset($_REQUEST["ledger"])) { $ledger = $_REQUEST["ledger"]; } else { $ledger = ""; }
//echo $ledger = str_replace('&',' ',$ledger);
if (isset($_REQUEST["ledgeranum"])) { $ledgeranum = $_REQUEST["ledgeranum"]; } else { $ledgeranum = ""; }
//$ledger = trim($ledger);
if (isset($_REQUEST["ledgerid"])) { $ledgerid = $_REQUEST["ledgerid"]; } else { $ledgerid = ""; }
//$ledgerid = trim($ledgerid);
$id = $ledgerid;

if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; }
if (isset($_REQUEST["group"])) { $group = $_REQUEST["group"]; } else { $group = ""; }

$url = "group=$group&&ledgeranum=$ledgeranum&&ledgerid=$ledgerid&&cbfrmflag1=$cbfrmflag1&&ADate1=$ADate1&&ADate2=$ADate2&&ledger=$ledger";

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
<script type="text/javascript" src="js/autocomplete_ledger.js"></script>
<script type="text/javascript" src="js/autosuggestledger.js"></script>
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>

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
<script type="text/javascript">
window.onload = function(){

var oTextbox = new AutoSuggestControlledger(document.getElementById("ledger"), new StateSuggestions()); 
	//alert(oTextbox1); 
}
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
		
		
              <form name="cbform1" method="post" action="ledgerreportdetail.php" onSubmit="return modulecheck()">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#CCCCCC" class="bodytext3"><strong> Ledger Report</strong></td>
              </tr>
              <tr>
                      <td width="14%"  align="left" valign="center" 
                bgcolor="#FFFFFF" class="bodytext31"> Date From </td>
                      <td width="45%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $ADate1; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                    <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="8%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $ADate2; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                  </tr>	
					<tr>
					<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Select Group</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> 
				<select name="group" id="group">
				<?php
				$group = $_REQUEST['group'];
				?>
				<option value=""> Select </option>
				<?php 
				$query7 = "select * from master_accountssub where recordstatus <> 'deleted' order by accountsmain, auto_number";
				$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
				while($res7 = mysql_fetch_array($exec7))
				{
				$groupname = $res7['accountssub'];
				$groupcode = $res7['auto_number'];
				?>
				<option value="<?php echo $groupcode; ?>" <?php if($group == $groupcode) { echo "selected=selected"; } ?>> <?php echo $groupcode.' - '.$groupname; ?> </option>
				<?php
				}
				?>
				</select>
				 </td>
				<td width="12%"  align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31">Select Location </td>
                      <td width="24%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
					   <select name="location" id="location" style="border: 1px solid #001E6A" >
						<?php
						$query1 = "select * from master_employeelocation where username='$username' group by locationcode order by locationname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						while ($res1 = mysql_fetch_array($exec1))
						{
						$res1location = $res1["locationname"];
						$res1locationcode = $res1["locationcode"];
						?>
						<option value="<?php echo $res1locationcode; ?>" <?php if($location == $res1locationcode) { echo "selected='selected'"; } ?>><?php echo $res1location; ?></option>
						<?php
						}
						?>
                  </select>
				   </td>
					</tr>
			<tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Select Ledger </td>
                      <td width="45%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ledger" id="ledger" autocomplete="off" value="<?php echo $ledger; ?>"  size="40" />
					 <input type="hidden" name="autobuildledger" id="autobuildledger" size="50"> 
					 <input type="hidden" name="ledgerid" id="ledgerid" size="10" value="<?php echo $ledgerid; ?>">
                     <input type="hidden" name="ledgeranum" id="ledgeranum" size="10" value="<?php echo $ledgeranum; ?>"> 
                    </td>
                      <td width="8%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">&nbsp;  </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF">&nbsp;</td>
                  </tr>			
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="border: 1px solid #001E6A; text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" 
            align="left" border="0">
          <tbody>
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
		?>
		  <?php
		  if($group == '1')
		  {
		  ?>
		  <tr>
		<td colspan="9" bgcolor="#FFFFFF" class="bodytext3" align="left"><strong><?php echo $ledger.' - '.'From '.date('d-M-Y',strtotime($ADate1)).' '.'to '.date('d-M-Y',strtotime($ADate2)); ?></strong></td>
		</tr>
		<?php if($id == '') { ?>
				<tr bgcolor="#CCC">
				<td width="44" align="left" class="bodytext3"><strong><?php echo 'S.No'; ?></strong></td>
				<td width="87" align="left" class="bodytext3"><strong><?php echo 'Date'; ?></strong></td>
				<td width="86" align="left" class="bodytext3"><strong><?php echo 'Docno'; ?></strong></td>
				<td width="84" align="left" class="bodytext3"><strong><?php echo 'Code'; ?></strong></td>
				<td width="196" align="left" class="bodytext3"><strong><?php echo 'Description'; ?></strong></td>
				<td width="101" align="left" class="bodytext3"><strong><?php echo 'Department'; ?></strong></td>
				<td width="121" align="right" class="bodytext3"><strong><?php echo 'Debit'; ?></strong></td>
				<td width="136" align="right" class="bodytext3"><strong><?php echo 'Credit'; ?></strong></td>
				<td width="136" align="right" class="bodytext3"><strong><?php echo 'Balance'; ?></strong></td>
				</tr>
				<?php } else { ?>
				<tr bgcolor="#CCC">
				<td width="44" align="left" class="bodytext3"><strong><?php echo 'S.No'; ?></strong></td>
				<td width="87" align="left" class="bodytext3"><strong><?php echo 'Date'; ?></strong></td>
				<td width="86" align="left" class="bodytext3"><strong><?php echo 'Docno'; ?></strong></td>
				<td width="84" align="left" class="bodytext3"><strong><?php echo 'Code'; ?></strong></td>
				<td width="196" align="left" class="bodytext3"><strong><?php echo 'Description'; ?></strong></td>
				<td width="101" align="right" class="bodytext3"><strong><?php echo 'Debit'; ?></strong></td>
				<td width="121" align="right" class="bodytext3"><strong><?php echo 'Credit'; ?></strong></td>
				<td width="136" align="right" class="bodytext3"><strong><?php echo 'Balance'; ?></strong></td>
				</tr>
				<?php } ?>
		  <?php
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
			
			if($id == '01-1006')
			{
				$j = 0;
				$crresult = array();
				$querycr1in = "SELECT ROUND((`amount`)) as income,billdate as td2,billnumber as td3, patientcode as td4, patientname as td5 FROM `billing_paynowpharmacy` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2' group by billnumber
							   UNION ALL SELECT ROUND((`amount`)) as income,billdate as td2,billnumber as td3, patientcode as td4, patientname as td5 FROM `billing_externalpharmacy` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2' group by billnumber
							   UNION ALL SELECT (`amount`) as income,billdate as td2,billnumber as td3, patientcode as td4, patientname as td5 FROM `billing_paylaterpharmacy` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2'
							   UNION ALL SELECT (`amount`) as income,billdate as td2,billnumber as td3, patientcode as td4, patientname as td5 FROM `billing_ippharmacy` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2'
							   
							   UNION ALL SELECT (-1*`amount`) as income,billdate as td2,billnumber as td3, patientcode as td4, patientname as td5 FROM `refund_paynowpharmacy` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2'
							   UNION ALL SELECT (-1*`amount`) as income,billdate as td2,billnumber as td3, patientcode as td4, patientname as td5 FROM `paylaterpharmareturns` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' AND `billnumber` IN (SELECT b.`docno` FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number`)";
				$execcr1 = mysql_query($querycr1in) or die ("Error in querycr1in".mysql_error());
				while($rescr1 = mysql_fetch_array($execcr1))
				{
				$amount = $rescr1['income'];
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
                <td align="right" class="bodytext3"><?php echo number_format($sumbalance,2,'.',','); ?></td>
				</tr>
				<?php
				}	
			}
			else if($id == '01-1008')
			{
				$i = 0;
				$drresult = array();
				$querydr1in = "SELECT (`labitemrate`) as incomedr,billdate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `refund_paynowlab` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2'
								UNION ALL SELECT (`labitemrate`) as incomedr,billdate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `refund_paylaterlab` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
								UNION ALL SELECT (`rate`) as incomedr,consultationdate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Lab'";
				$execdr1 = mysql_query($querydr1in) or die ("Error in querydr1in".mysql_error());
				while($resdr1 = mysql_fetch_array($execdr1))
				{
				$amount = $resdr1['incomedr'];
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
				<td align="right" class="bodytext3"><?php echo number_format($amount,2,'.',','); ?></td>
				<td align="left" class="bodytext3">&nbsp;</td>
                <td align="right" class="bodytext3"><?php echo number_format($sumbalance,2,'.',','); ?></td>
				</tr>
				<?php
				}
				
				/* */
				$j = 0;
				$crresult = array();
				$querycr1in = "SELECT (`labitemrate`) as income,billdate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `billing_paylaterlab` WHERE `billnumber` LIKE 'CB%' AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
							   UNION ALL SELECT (`labitemrate`) as income,billdate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `billing_iplab` WHERE `billnumber` LIKE 'IPF%' AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
							   UNION ALL select (labitemrate) as income,billdate as td2, billnumber as td3, patientcode as td4, patientname as td5 from billing_paynowlab where billdate between '$ADate1' AND '$ADate2' and billnumber LIKE 'OPC-%'
							   UNION ALL select (labitemrate) as income,billdate as td2, billnumber as td3, patientcode as td4, patientname as td5 from billing_externallab where billdate between '$ADate1' AND '$ADate2' and billnumber LIKE 'EB%'
							   UNION ALL SELECT (`rate`) as income,consultationdate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Lab'";
				$execcr1 = mysql_query($querycr1in) or die ("Error in querycr1in".mysql_error());
				while($rescr1 = mysql_fetch_array($execcr1))
				{
				$amount = $rescr1['income'];
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
                <td align="right" class="bodytext3"><?php echo number_format($sumbalance,2,'.',','); ?></td>
				</tr>
				<?php
				}	
				$balance = array_sum($crresult) - array_sum($drresult);
			}
			else if($id == '01-1012')
			{
				$i = 0;
				$drresult = array();
				
				/* */
				$j = 0;
				$crresult = array();
				$querycr1in = "SELECT (`subtotal`) as income,billdate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `billing_referal` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2' AND `billnumber` LIKE 'CB%'
							   UNION ALL SELECT (`referalrate`) as income,billdate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `billing_paylaterreferal` WHERE `billnumber` LIKE 'CB%' AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
							   UNION ALL select (subtotal) as income,billdate as td2, billnumber as td3, patientcode as td4, patientname as td5 from billing_referal where billdate between '$ADate1' AND '$ADate2' and billnumber LIKE 'OPC-%'
							   UNION ALL select (referalrate) as income,billdate as td2, billnumber as td3, patientcode as td4, patientname as td5 from billing_paynowreferal where billdate between '$ADate1' AND '$ADate2' and billnumber LIKE 'OPC-%' 
							   UNION ALL SELECT (-1*`referalrate`) as income,billdate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `refund_paylaterreferal` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'";
				$execcr1 = mysql_query($querycr1in) or die ("Error in querycr1in".mysql_error());
				while($rescr1 = mysql_fetch_array($execcr1))
				{
				$amount = $rescr1['income'];
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
                <td align="right" class="bodytext3"><?php echo number_format($sumbalance,2,'.',','); ?></td>
				</tr>
				<?php
				}
				$balance = array_sum($crresult) - array_sum($drresult);
			}
			else if($id == '01-1003')
			{	
				$j = 0;
				$crresult = array();
				$querycr1in = "SELECT `amount` as income, recorddate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `billing_ipbedcharges` WHERE `recorddate` BETWEEN '$ADate1' AND '$ADate2'
								UNION ALL SELECT (`rate`) as income, consultationdate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Bed Charges'
								UNION ALL SELECT (`rate`) as income, consultationdate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Nursing Charges'
								UNION ALL SELECT (`rate`) as income, consultationdate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'RMO Charges'
								UNION ALL SELECT (-1*`rate`) as income, consultationdate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Bed Charges'
								UNION ALL SELECT (-1*`rate`) as income, consultationdate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Nursing Charges'
								UNION ALL SELECT (-1*`rate`) as income, consultationdate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'RMO Charges'";
				$execcr1 = mysql_query($querycr1in) or die ("Error in querycr1in".mysql_error());
				while($rescr1 = mysql_fetch_array($execcr1))
				{
				$amount = $rescr1['income'];
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
                <td align="right" class="bodytext3"><?php echo number_format($sumbalance,2,'.',','); ?></td>
				</tr>
				<?php
				}	
			}
			else if($id == '01-1004')
			{
				$i = 0;
				$drresult = array();
				$drresult[$i] = 0;
			
				$j = 0;
				$crresult = array();
				$querycr1in = "SELECT `amount` as income, recorddate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `billing_ipadmissioncharge` WHERE `recorddate` BETWEEN '$ADate1' AND '$ADate2'";
				$execcr1 = mysql_query($querycr1in) or die ("Error in querycr1in".mysql_error());
				while($rescr1 = mysql_fetch_array($execcr1))
				{
				$amount = $rescr1['income'];
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
                <td align="right" class="bodytext3"><?php echo number_format($sumbalance,2,'.',','); ?></td>
				</tr>
				<?php
				}	
			}
			else if($id == '01-1013')
			{
				$i = 0;
				$drresult = array();
				$querydr1in = "SELECT (`amount`) as incomedr, billdate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `refund_paylaterambulance` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
								UNION ALL SELECT (`amount`) as incomedr, billdate as td2, docno as td3, patientcode as td4, patientname as td5  FROM `refund_paylaterhomecare` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
								UNION ALL SELECT (`rate`) as incomedr, consultationdate as td2, docno as td3, patientcode as td4, patientname as td5  FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Others'";
				$execdr1 = mysql_query($querydr1in) or die ("Error in querydr1in".mysql_error());
				while($resdr1 = mysql_fetch_array($execdr1))
				{
				$amount = $resdr1['incomedr'];
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
				<td align="right" class="bodytext3"><?php echo number_format($amount,2,'.',','); ?></td>
				<td align="left" class="bodytext3">&nbsp;</td>
                <td align="right" class="bodytext3"><?php echo number_format($sumbalance,2,'.',','); ?></td>
				</tr>
				<?php
				}
			
				$j = 0;
				$crresult = array();
				$querycr1in = "SELECT (`amount`) as income, recorddate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `billing_ipprivatedoctor` WHERE `docno` LIKE 'IPF%' AND `recorddate` BETWEEN '$ADate1' AND '$ADate2'
							   UNION ALL SELECT (`amount`) as income, recorddate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `billing_ipmiscbilling` WHERE `docno` LIKE 'IPF%' AND `recorddate` BETWEEN '$ADate1' AND '$ADate2'
							   UNION ALL SELECT (`amount`) as income, recorddate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `billing_iphomecare` WHERE `docno` LIKE 'IPF%' AND `recorddate` BETWEEN '$ADate1' AND '$ADate2'
							   UNION ALL SELECT (`rate`) as income, consultationdate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Others'";
				$execcr1 = mysql_query($querycr1in) or die ("Error in querycr1in".mysql_error());
				while($rescr1 = mysql_fetch_array($execcr1))
				{
				$amount = $rescr1['income'];
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
                <td align="right" class="bodytext3"><?php echo number_format($sumbalance,2,'.',','); ?></td>
				</tr>
				<?php
				}
				$balance = array_sum($crresult) - array_sum($drresult);
			}
			else if($id == '01-1017')
			{
				$i = 0;
				$drresult = array();
				$drresult[$i] = 0;
			
				$j = 0;
				$crresult = array();
				$querycr1in = "SELECT (`amount`) as income, recorddate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `billing_ipambulance` WHERE `recorddate` BETWEEN '$ADate1' AND '$ADate2'";
				$execcr1 = mysql_query($querycr1in) or die ("Error in querycr1in".mysql_error());
				while($rescr1 = mysql_fetch_array($execcr1))
				{
				$amount = $rescr1['income'];
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
                <td align="right" class="bodytext3"><?php echo number_format($sumbalance,2,'.',','); ?></td>
				</tr>
				<?php
				}	
				$balance = array_sum($crresult) - array_sum($drresult);
			}
			else if($id == '01-1014')
			{
				$i = 0;
				$drresult = array();
				
				/**/
				$j = 0;
				$crresult = array();
				$querycr1in = "SELECT (`amount`) as income, billdate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `billing_paylaterservices` WHERE `billnumber` LIKE 'CB%' AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
							   UNION ALL SELECT (`servicesitemrate`) as income, billdate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `billing_ipservices` WHERE `billnumber` LIKE 'IPF%' AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
							   UNION ALL select (amount) as income, billdate as td2, billnumber as td3, patientcode as td4, patientname as td5 from billing_paynowservices where billdate between '$ADate1' AND '$ADate2' and billnumber LIKE 'OPC-%'
							   UNION ALL select (servicesitemrate) as income, billdate as td2, billnumber as td3, patientcode as td4, patientname as td5 from billing_externalservices where billdate between '$ADate1' AND '$ADate2' and billnumber LIKE 'EB%'
							   UNION ALL SELECT (`rate`) as income, consultationdate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Service'
							   UNION ALL SELECT (-1*`rate`) as income, consultationdate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Service'
								UNION ALL SELECT (-1*`amount`) as income, billdate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `refund_paylaterservices` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
								UNION ALL SELECT (-1*`servicesitemrate`) as income, billdate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `refund_paynowservices` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'";
				$execcr1 = mysql_query($querycr1in) or die ("Error in querycr1in".mysql_error());
				while($rescr1 = mysql_fetch_array($execcr1))
				{
				$amount = $rescr1['income'];
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
                <td align="right" class="bodytext3"><?php echo number_format($sumbalance,2,'.',','); ?></td>
				</tr>
				<?php
				}	
				$balance = array_sum($crresult) - array_sum($drresult);
			}
			else if($id == '01-1001')
			{
				/**/
				$j = 0;
				$crresult = array();
				$querycr1in = "SELECT `totalamount` as income, billdate as td2, billno as td3, patientcode as td4, patientname as td5 FROM `billing_paylaterconsultation` WHERE `billno` LIKE 'CB%' AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
							   UNION ALL SELECT `consultation` as income, billdate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `billing_consultation` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2'";
				$execcr1 = mysql_query($querycr1in) or die ("Error in querycr1in".mysql_error());
				while($rescr1 = mysql_fetch_array($execcr1))
				{
				$amount = $rescr1['income'];
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
                <td align="right" class="bodytext3"><?php echo number_format($sumbalance,2,'.',','); ?></td>
				</tr>
				<?php
				}	
				$i = 0;
				$drresult = array();
				$querydr1in = "SELECT `consultation` as incomedebit, billdate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `refund_consultation` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2' and billnumber NOT LIKE 'Cr.N%'";
							   //UNION ALL SELECT SUM(`consultation`) as incomedebit FROM `refund_consultation` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2' and billnumber LIKE 'Cr.N%'";
				$execdr1 = mysql_query($querydr1in) or die ("Error in querydr1in".mysql_error());
				while($resdr1 = mysql_fetch_array($execdr1))
				{
				$amount = $resdr1['incomedebit'];
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
                <td align="right" class="bodytext3"><?php echo number_format($sumbalance,2,'.',','); ?></td>
				</tr>
				<?php
				}	
			}
			else if($id == '01-1015')
			{
				$i = 0;
				$drresult = array();
				
				/**/
				$j = 0;
				$crresult = array();
				$querycr1in = "SELECT (`radiologyitemrate`) as income, billdate as td2, billnumber as td3, patientcode as td4, patientname as td5  FROM `billing_paylaterradiology` WHERE `billnumber` LIKE 'CB%' AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
							   UNION ALL SELECT (`radiologyitemrate`) as income, billdate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `billing_ipradiology` WHERE `billdate` BETWEEN '$ADate1' AND '$ADate2'
							   UNION ALL select (radiologyitemrate) as income, billdate as td2, billnumber as td3, patientcode as td4, patientname as td5 from billing_paynowradiology where billdate BETWEEN '$ADate1' AND '$ADate2' and billnumber LIKE 'OPC-%'
							   UNION ALL select (radiologyitemrate) as income, billdate as td2, billnumber as td3, patientcode as td4, patientname as td5 from billing_externalradiology where billdate BETWEEN '$ADate1' AND '$ADate2' and billnumber LIKE 'EB%'
							   UNION ALL SELECT (`rate`) as income, consultationdate as td2, docno as td3, patientcode as td4, patientname as td5  FROM `ip_debitnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Radiology'
							   UNION ALL SELECT (-1*`rate`) as income, consultationdate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `ip_creditnotebrief` WHERE consultationdate BETWEEN '$ADate1' AND '$ADate2' and `description` = 'Radiology'
							   UNION ALL SELECT (-1*`radiologyitemrate`) as income, billdate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `refund_paylaterradiology` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'
								UNION ALL SELECT (-1*`radiologyitemrate`) as income, billdate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `refund_paynowradiology` WHERE billdate BETWEEN '$ADate1' AND '$ADate2'";
				$execcr1 = mysql_query($querycr1in) or die ("Error in querycr1in".mysql_error());
				while($rescr1 = mysql_fetch_array($execcr1))
				{
				$amount = $rescr1['income'];

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
                <td align="right" class="bodytext3"><?php echo number_format($sumbalance,2,'.',','); ?></td>
				</tr>
				<?php
				}	
				$balance = array_sum($crresult) - array_sum($drresult);
			}
			else 
			{
				$j = 0;
				$crresult = array();
				$drresult = array();
				$querycr1in = "SELECT (openbalanceamount) as income, `entrydate` as td2, `remarks` as td3, `accountcode` as td4, `accountname` as td5  FROM `openingbalancesupplier` WHERE `accountcode` = '$id' and entrydate between '$ADate1' AND '$ADate2'";
				$execcr1 = mysql_query($querycr1in) or die ("Error in querycr1in".mysql_error());
				while($rescr1 = mysql_fetch_array($execcr1))
				{
				$amount = $rescr1['income'];
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
				<td align="right" class="bodytext3"><?php echo number_format($sumbalance,2,'.',','); ?></td>
				</tr>
				<?php
				}	
				$balance = array_sum($crresult) - array_sum($drresult);
			}
		}
			?>
			<tr bgcolor="#CCC">
			<td colspan="9" align="right" class="bodytext3"><strong><?php echo number_format($sumbalance,2); ?></strong></td>
			</tr>
		  <?php
		  }
		  else if($group == '3')
		  {
		  ?>
		  <tr>
		<td colspan="9" bgcolor="#FFFFFF" class="bodytext3" align="left"><strong><?php echo $ledger.' - '.'From '.date('d-M-Y',strtotime($ADate1)).' '.'to '.date('d-M-Y',strtotime($ADate2)); ?></strong></td>
		</tr>
		<tr bgcolor="#CCC">
		<td width="44" align="left" class="bodytext3"><strong><?php echo 'S.No'; ?></strong></td>
		<td width="87" align="left" class="bodytext3"><strong><?php echo 'Date'; ?></strong></td>
		<td width="76" align="left" class="bodytext3"><strong><?php echo 'Visitcode'; ?></strong></td>
		<td width="121" align="left" class="bodytext3"><strong><?php echo 'Patientname'; ?></strong></td>
		<td width="92" align="left" class="bodytext3"><strong><?php echo 'Itemcode'; ?></strong></td>
		<td width="168" align="left" class="bodytext3"><strong><?php echo 'Itemname'; ?></strong></td>
		<td width="131" align="right" class="bodytext3"><strong><?php echo 'Debit'; ?></strong></td>
		<td width="136" align="right" class="bodytext3"><strong><?php echo 'Credit'; ?></strong></td>
		<td width="136" align="right" class="bodytext3"><strong><?php echo 'Balance'; ?></strong></td>
		</tr>
		<?php
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
					
					if($id == '02-2001')
					{
					$querydr1 = "SELECT `totalcp` as td1, `entrydate` as td2, `visitcode` as td3, `patientname` as td4, `itemcode` as td5, `itemname` as td6 FROM `pharmacysales_details` WHERE `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
					$execdr1 = mysql_query($querydr1) or die ("Error in Querydr1".mysql_error());
					while($resdr1 = mysql_fetch_array($execdr1))
					{
					$amount = $resdr1['td1'];
					$entrydate = $resdr1['td2'];
					$visitcode = $resdr1['td3'];
					$patientname = $resdr1['td4'];
					$itemcode = $resdr1['td5'];
					$itemname = $resdr1['td6'];
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
					<td align="left" class="bodytext3"><?php echo $visitcode; ?></td>
					<td align="left" class="bodytext3"><?php echo $patientname; ?></td>
					<td align="left" class="bodytext3"><?php echo $itemcode; ?></td>
					<td align="left" class="bodytext3"><?php echo $itemname; ?></td>
					<td align="right" class="bodytext3"><?php echo number_format($amount,2,'.',','); ?></td>
					<td align="left" class="bodytext3">&nbsp;</td>
                    <td align="right" class="bodytext3"><?php echo number_format($sumbalance,2,'.',','); ?></td>
					</tr>
					<?php
					}
					
					$querydr1 = "SELECT `totalcp` as td1, `entrydate` as td2, `visitcode` as td3, `patientcode` as td4, `itemcode` as td5, `itemname` as td6 FROM `pharmacysalesreturn_details` WHERE `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
					$execdr1 = mysql_query($querydr1) or die ("Error in Querydr1".mysql_error());
					while($resdr1 = mysql_fetch_array($execdr1))
					{
					$amount = $resdr1['td1'];
					$entrydate = $resdr1['td2'];
					$visitcode = $resdr1['td3'];
					$patientname = $resdr1['td4'];
					$itemcode = $resdr1['td5'];
					$itemname = $resdr1['td6'];
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
					<td align="left" class="bodytext3"><?php echo $visitcode; ?></td>
					<td align="left" class="bodytext3"><?php echo $patientname; ?></td>
					<td align="left" class="bodytext3"><?php echo $itemcode; ?></td>
					<td align="left" class="bodytext3"><?php echo $itemname; ?></td>
					<td align="left" class="bodytext3">&nbsp;</td>	
					<td align="right" class="bodytext3"><?php echo '-'.number_format($amount,2,'.',','); ?></td>
                    <td align="right" class="bodytext3"><?php echo number_format($sumbalance,2,'.',','); ?></td>
					</tr>
					<?php
					}
					}
					}
					?>
					<tr bgcolor="#CCC">
					<td colspan="9" align="right" class="bodytext3"><strong><?php echo number_format($sumbalance,2); ?></strong></td>
					</tr>
		  <?php
		  }
		  else if($group == '2')
		  {
		  ?>
		  <tr>
		<td colspan="9" bgcolor="#FFFFFF" class="bodytext3" align="left"><strong><?php echo $ledger.' - '.'From '.date('d-M-Y',strtotime($ADate1)).' '.'to '.date('d-M-Y',strtotime($ADate2)); ?></strong></td>
		</tr>
		<tr bgcolor="#CCC">
		<td width="92" align="left" class="bodytext3"><strong><?php echo 'S.No'; ?></strong></td>
		<td width="92" align="left" class="bodytext3"><strong><?php echo 'Date'; ?></strong></td>
		<td width="92" align="left" class="bodytext3"><strong><?php echo 'Docno'; ?></strong></td>
		<td width="103" align="left" class="bodytext3"><strong><?php echo 'Code'; ?></strong></td>
		<td width="190" align="left" class="bodytext3"><strong><?php echo 'Description'; ?></strong></td>
		<td width="141" align="right" class="bodytext3"><strong><?php echo 'Debit'; ?></strong></td>
		<td width="153" align="right" class="bodytext3"><strong><?php echo 'Credit'; ?></strong></td>
		<td width="153" align="right" class="bodytext3"><strong><?php echo 'Balance'; ?></strong></td>
		</tr>
		  <?php
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
					$i = 0;
					$result = array();
					
					$balance = array_sum($result);
					$sumbalance = $sumbalance + $balance;
						
					$querydr1 = "SELECT `transactionamount` as td1,`transactiondate` as td2,`docnumber` as td3,`receiptcoa` as td4, CONCAT(`particulars`,`remarks`) as td5, `chequenumber` as td6 FROM `receiptsub_details` WHERE `receiptcoa` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT (openbalanceamount) as td1, `entrydate` as td2, `docno` as td3, `remarks` as td4, `accountcode` as td5, `accountname` as td6  FROM `openingbalancesupplier` WHERE `accountcode` = '$id' and entrydate between '$ADate1' AND '$ADate2'
					UNION ALL SELECT (-1*debitamount) as td1, `entrydate` as td2, `docno` as td3, null as td4, `ledgerid` as td5, `ledgername` as td6 FROM `master_journalentries` WHERE `ledgerid` = '$id' and debitamount > '0' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
					UNION ALL SELECT (creditamount) as td1, `entrydate` as td2, `docno` as td3, null as td4, `ledgerid` as td5, `ledgername` as td6 FROM `master_journalentries` WHERE `ledgerid` = '$id' and creditamount > '0' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
					$execdr1 = mysql_query($querydr1) or die ("Error in Querydr1".mysql_error());
					while($resdr1 = mysql_fetch_array($execdr1))
					{
					$amount = $resdr1['td1'];
					$entrydate = $resdr1['td2'];
					$docno = $resdr1['td3'];
					$itemcode = $resdr1['td4'];
					$itemname = $resdr1['td5'];
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
					<td align="right" class="bodytext3"><?php echo number_format($sumbalance,2,'.',','); ?></td>
					</tr>
					<?php
					}
					}
					?>
					<tr bgcolor="#CCC">
					<td colspan="9" align="right" class="bodytext3"><strong><?php echo number_format($sumbalance,2); ?></strong></td>
					</tr>
		  <?php
		  }
		  
				else if($group == '5' || $group == '6' || $group == '7' || $group == '8' || $group == '9' || $group == '10' || $group == '11' || $group == '12' || $group == '13' || $group == '14' || $group == '16' || $group == '30')
				{
				?>
				<tr>
				<td colspan="9" bgcolor="#FFFFFF" class="bodytext3" align="left"><strong><?php echo $ledger.' - '.'From '.date('d-M-Y',strtotime($ADate1)).' '.'to '.date('d-M-Y',strtotime($ADate2)); ?></strong></td>
				</tr>
				<tr bgcolor="#CCC">
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'S.No'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Date'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Docno'; ?></strong></td>
				<td width="103" align="left" class="bodytext3"><strong><?php echo 'Code'; ?></strong></td>
				<td width="190" align="left" class="bodytext3"><strong><?php echo 'Description'; ?></strong></td>
				<td width="141" align="right" class="bodytext3"><strong><?php echo 'Debit'; ?></strong></td>
				<td width="153" align="right" class="bodytext3"><strong><?php echo 'Credit'; ?></strong></td>
				<td width="153" align="right" class="bodytext3"><strong><?php echo 'Balance'; ?></strong></td>
				</tr>
				<?php
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
					
					if($id != '')
					{
						$i = 0;
						$result = array();
						
					}
					else
					{
						$result = array();
					}
					
					$balance = array_sum($result);
					
					$sumbalance = $sumbalance + $balance;
											
					$querydr1 = "SELECT (`totalamount`) as expenses,`entrydate` as td2,`billnumber` as td3,`itemcode` as td4,`itemname` as td5 FROM `expensepurchase_details` WHERE `expensecode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and recordstatus <> 'deleted'
								 UNION ALL SELECT (`totalamount`) as expenses,`entrydate` as td2,`billnumber` as td3,`itemcode` as td4,`itemname` as td5 FROM `purchase_details` WHERE `expensecode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2' and recordstatus <> 'deleted'
								 UNION ALL SELECT (`transactionamount`) as expenses,`transactiondate` as td2,`docnumber` as td3,`expensecoa` as td4,`remarks` as td5 FROM `expensesub_details` WHERE `expensecoa` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
								 UNION ALL SELECT (debitamount) as expenses, entrydate as td2, docno as td3, ledgerid as td4, narration as td5 FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
								 UNION ALL SELECT (-1*creditamount) as expenses, entrydate as td2, docno as td3, ledgerid as td4, narration as td5 FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
								 UNION ALL SELECT (amount) as expenses, entrydate as td2, docno as td3, itemcode as td4, itemname as td5 FROM `master_stock_transfer` WHERE `tostore` = '$id' AND typetransfer = 'Consumable' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
					$execdr1 = mysql_query($querydr1) or die ("Error in Querydr1".mysql_error());
					while($resdr1 = mysql_fetch_array($execdr1))
					{
					$amount = $resdr1['expenses'];
					$entrydate = $resdr1['td2'];
					$docno = $resdr1['td3'];
					$itemcode = $resdr1['td4'];
					$itemname = $resdr1['td5'];
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
					<td align="right" class="bodytext3"><?php echo number_format($amount,2,'.',','); ?></td>
					<td align="left" class="bodytext3">&nbsp;</td>
					<td align="right" class="bodytext3"><?php echo number_format($sumbalance,2,'.',','); ?></td>
					</tr>
					<?php
					}
					}
					?>
					<tr bgcolor="#CCC">
				<td colspan="9" align="right" class="bodytext3"><strong><?php echo number_format($sumbalance,2); ?></strong></td>
				</tr>
				<?php
				}
				else if($group == '28')
				{
				?>
				<tr>
				<td colspan="9" bgcolor="#FFFFFF" class="bodytext3" align="left"><strong><?php echo $ledger.' - '.'From '.date('d-M-Y',strtotime($ADate1)).' '.'to '.date('d-M-Y',strtotime($ADate2)); ?></strong></td>
				</tr>
				<tr bgcolor="#CCC">
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'S.No'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Date'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Docno'; ?></strong></td>
				<td width="103" align="left" class="bodytext3"><strong><?php echo 'Code'; ?></strong></td>
				<td width="190" align="left" class="bodytext3"><strong><?php echo 'Description'; ?></strong></td>
				<td width="141" align="right" class="bodytext3"><strong><?php echo 'Debit'; ?></strong></td>
				<td width="153" align="right" class="bodytext3"><strong><?php echo 'Credit'; ?></strong></td>
				<td width="153" align="right" class="bodytext3"><strong><?php echo 'Balance'; ?></strong></td>
				</tr>
				<?php
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
					if($id != '')
					{					 
						$i = 0;
						$drresult = array();
												
						$j = 0;
						$crresult = array();
												
						$balance = array_sum($crresult) - array_sum($drresult);
					}	
					$sumbalance = $sumbalance + $balance;
						
					$querydr1 = "SELECT (`transactionamount`) as deposit, transactiondate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `master_transactionadvancedeposit` WHERE `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									 UNION ALL SELECT (`transactionamount`) as deposit, transactiondate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `master_transactionipdeposit` WHERE `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactionmodule` = 'PAYMENT'
									 UNION ALL SELECT (creditamount) as deposit, entrydate as td2, docno as td3, ledgerid as td4, narration as td5 FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
									 UNION ALL SELECT (amount) as deposit, recorddate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `deposit_refund` WHERE visitcode IN (select visitcode FROM `master_transactionip` WHERE transactiondate BETWEEN '$ADate1' AND '$ADate2')
									 UNION ALL SELECT (amount) as deposit, recorddate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `deposit_refund` WHERE visitcode IN (select visitcode FROM `billing_ipcreditapprovedtransaction` WHERE billdate BETWEEN '$ADate1' AND '$ADate2')
									 
									 UNION ALL SELECT (-1*ABS(`transactionamount`)) as deposit, transactiondate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `master_transactionipdeposit` WHERE visitcode IN (select visitcode FROM `master_transactionip` WHERE transactiondate BETWEEN '$ADate1' AND '$ADate2' group by billnumber)
									 UNION ALL SELECT (-1*ABS(`transactionamount`)) as deposit, transactiondate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `master_transactionadvancedeposit` WHERE visitcode IN (select visitcode FROM `master_transactionip` WHERE transactiondate BETWEEN '$ADate1' AND '$ADate2' group by billnumber)
									 UNION ALL SELECT (-1*ABS(`transactionamount`)) as deposit, transactiondate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `master_transactionipdeposit` WHERE visitcode IN (select visitcode FROM `billing_ipcreditapprovedtransaction` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' group by billnumber)
									 UNION ALL SELECT (-1*ABS(`transactionamount`)) as deposit, transactiondate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `master_transactionadvancedeposit` WHERE visitcode IN (select visitcode FROM `billing_ipcreditapprovedtransaction` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' group by billnumber)
									 UNION ALL SELECT (-1*ABS(debitamount)) as deposit, entrydate as td2, docno as td3, ledgerid as td4, narration as td5 FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
					$execdr1 = mysql_query($querydr1) or die ("Error in Querydr1".mysql_error());
					while($resdr1 = mysql_fetch_array($execdr1))
					{
					$amount = $resdr1['deposit'];
					$entrydate = $resdr1['td2'];
					$docno = $resdr1['td3'];
					$itemcode = $resdr1['td4'];
					$itemname = $resdr1['td5'];
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
					<?php if($amount >= 0) { ?>
					<td align="left" class="bodytext3">&nbsp;</td>
					<td align="right" class="bodytext3"><?php echo number_format($amount,2,'.',','); ?></td>
					<?php } else { ?>
					<td align="right" class="bodytext3"><?php echo number_format(abs($amount),2,'.',','); ?></td>
					<td align="left" class="bodytext3">&nbsp;</td>
					<?php } ?>
					<td align="right" class="bodytext3"><?php echo number_format($sumbalance,2,'.',','); ?></td>
					</tr>
					<?php
					}
					}
					?>
					<tr bgcolor="#CCC">
					<td colspan="9" align="right" class="bodytext3"><strong><?php echo number_format($sumbalance,2); ?></strong></td>
					</tr>
					<?php
				}
				else if($group == '29')
				{
				?>
				<tr>
				<td colspan="9" bgcolor="#FFFFFF" class="bodytext3" align="left"><strong><?php echo $ledger.' - '.'From '.date('d-M-Y',strtotime($ADate1)).' '.'to '.date('d-M-Y',strtotime($ADate2)); ?></strong></td>
				</tr>
				<tr bgcolor="#CCC">
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'S.No'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Date'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Docno'; ?></strong></td>
				<td width="103" align="left" class="bodytext3"><strong><?php echo 'Code'; ?></strong></td>
				<td width="190" align="left" class="bodytext3"><strong><?php echo 'Description'; ?></strong></td>
				<td width="141" align="right" class="bodytext3"><strong><?php echo 'Debit'; ?></strong></td>
				<td width="153" align="right" class="bodytext3"><strong><?php echo 'Credit'; ?></strong></td>
				<td width="153" align="right" class="bodytext3"><strong><?php echo 'Balance'; ?></strong></td>
				</tr>
				<?php
				$sumbalance = 0;
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
					if($id != '')
					{				
						
						
						$balance = 0;
						
						$sumbalance = $sumbalance + $balance;
					}
						
					$querydr1inv = "SELECT `totalamount` as stock, `entrydate` as td2, `billnumber` as td3, `itemcode` as td4, `itemname` as td5 FROM `purchase_details` WHERE `entrydate` BETWEEN '$ADate1' AND '$ADate2' AND `suppliername` <> 'OPENINGSTOCK' AND `recordstatus` <> 'deleted'
									UNION ALL SELECT `totalcp` as stock, `entrydate` as td2, `billnumber` as td3, `itemcode` as td4, `itemname` as td5 FROM `pharmacysalesreturn_details` WHERE `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
					$execdr1 = mysql_query($querydr1inv) or die ("Error in querydr1inv".mysql_error());
					while($resdr1 = mysql_fetch_array($execdr1))
					{
					$amount = $resdr1['stock'];
					$entrydate = $resdr1['td2'];
					$docno = $resdr1['td3'];
					$itemcode = $resdr1['td4'];
					$itemname = $resdr1['td5'];
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
					<td align="right" class="bodytext3"><?php echo number_format($amount,2,'.',','); ?></td>
					<td align="left" class="bodytext3">&nbsp;</td>
                    <td align="right" class="bodytext3"><?php echo number_format($sumbalance,2,'.',','); ?></td>
					</tr>
					<?php
					}
					$querycr1inv = "SELECT `totalamount` as stockcredit, `entrydate` as td2, `billnumber` as td3, `suppliercode` as td4, `suppliername` as td5 FROM `purchasereturn_details` WHERE `entrydate` BETWEEN '$ADate1' AND '$ADate2'
									UNION ALL SELECT `totalcp` as stockcredit, `entrydate` as td2, `billnumber` as td3, `itemcode` as td4, `itemname` as td5 FROM `pharmacysales_details` WHERE `entrydate` BETWEEN '$ADate1' AND '$ADate2'
									UNION ALL SELECT `amount` as stockcredit, `entrydate` as td2, `docno` as td3, `itemcode` as td4, `itemname` as td5 FROM `master_stock_transfer` WHERE typetransfer = 'Consumable' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";				 
					$execcr1 = mysql_query($querycr1inv) or die ("Error in Querycr1".mysql_error());
					while($rescr1 = mysql_fetch_array($execcr1))
					{
					$amount = $rescr1['stockcredit'];
					$entrydate = $rescr1['td2'];
					$docno = $rescr1['td3'];
					$itemcode = $rescr1['td4'];
					$itemname = $rescr1['td5'];
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
					<td align="left" class="bodytext3">&nbsp;</td>
					<td align="right" class="bodytext3"><?php echo '-'.number_format($amount,2,'.',','); ?></td>
                    <td align="right" class="bodytext3"><?php echo number_format($sumbalance,2,'.',','); ?></td>
					</tr>
					<?php
					}
					}
					?>
					<tr bgcolor="#CCC">
					<td colspan="9" align="right" class="bodytext3"><strong><?php echo number_format($sumbalance,2); ?></strong></td>
					</tr>
					<?php
				}
				else if($group == '27' || $group == '26')
				{
				?>
				<tr>
				<td colspan="9" bgcolor="#FFFFFF" class="bodytext3" align="left"><strong><?php echo $ledger.' - '.'From '.date('d-M-Y',strtotime($ADate1)).' '.'to '.date('d-M-Y',strtotime($ADate2)); ?></strong></td>
				</tr>
				<tr bgcolor="#CCC">
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'S.No'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Date'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Docno'; ?></strong></td>
				<td width="103" align="left" class="bodytext3"><strong><?php echo 'Code'; ?></strong></td>
				<td width="190" align="left" class="bodytext3"><strong><?php echo 'Description'; ?></strong></td>
				<td width="141" align="right" class="bodytext3"><strong><?php echo 'Debit'; ?></strong></td>
				<td width="153" align="right" class="bodytext3"><strong><?php echo 'Credit'; ?></strong></td>
				<td width="153" align="right" class="bodytext3"><strong><?php echo 'Balance'; ?></strong></td>
				</tr>
				<?php
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
					if($id == '07-8101-01')
					{
					$querydr1 = "SELECT (-1*ABS(amount)) as income, recorddate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `billing_ipnhif` WHERE visitcode IN (select visitcode FROM `master_transactionip` WHERE transactiondate BETWEEN '$ADate1' AND '$ADate2' group by billnumber)
						UNION ALL SELECT (-1*ABS(amount)) as income, recorddate as td2, docno as td3, patientcode as td4, patientname as td5  FROM `billing_ipnhif` WHERE visitcode IN (select visitcode FROM `billing_ipcreditapprovedtransaction` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' group by billno)";
					}
					else if($id == '01-2101-01')
					{
					$querydr1 = "SELECT (-1*`rate`) as income, consultationdate as td2, docno as td3, patientcode as td4, patientname as td5  FROM `ip_discount` WHERE patientvisitcode IN (select visitcode FROM `master_transactionip` WHERE transactiondate BETWEEN '$ADate1' AND '$ADate2' group by billnumber)
						UNION ALL SELECT (-1*`rate`) as income, consultationdate as td2, docno as td3, patientcode as td4, patientname as td5  FROM `ip_discount` WHERE patientvisitcode IN (select visitcode FROM `billing_ipcreditapprovedtransaction` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' group by billno)";
					}
					$execdr1 = mysql_query($querydr1) or die ("Error in Querydr1".mysql_error());
					while($resdr1 = mysql_fetch_array($execdr1))
					{
					$amount = $resdr1['income'];
					$entrydate = $resdr1['td2'];
					$docno = $resdr1['td3'];
					$itemcode = $resdr1['td4'];
					$itemname = $resdr1['td5'];
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
					<?php if($amount >= 0) { ?>
					<td align="left" class="bodytext3">&nbsp;</td>
					<td align="right" class="bodytext3"><?php echo number_format($amount,2,'.',','); ?></td>
					<?php } else { ?>
					<td align="right" class="bodytext3"><?php echo number_format(abs($amount),2,'.',','); ?></td>
					<td align="left" class="bodytext3">&nbsp;</td>
					<?php } ?>
					<td align="right" class="bodytext3"><?php echo number_format($sumbalance,2,'.',','); ?></td>
					</tr>
					<?php
					}
					}
					?>
					<tr bgcolor="#CCC">
					<td colspan="9" align="right" class="bodytext3"><strong><?php echo number_format($sumbalance,2); ?></strong></td>
					</tr>
					<?php
				}
				else if($group == '17' || $group == '21' || $group == '22')
				{
				?>
                <tr>
				<td colspan="9" bgcolor="#FFFFFF" class="bodytext3" align="left"><strong><?php echo $ledger.' - '.'From '.date('d-M-Y',strtotime($ADate1)).' '.'to '.date('d-M-Y',strtotime($ADate2)); ?></strong></td>
				</tr>
				<tr bgcolor="#CCC">
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'S.No'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Date'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Docno'; ?></strong></td>
				<td width="103" align="left" class="bodytext3"><strong><?php echo 'Code'; ?></strong></td>
				<td width="190" align="left" class="bodytext3"><strong><?php echo 'Description'; ?></strong></td>
				<td width="141" align="right" class="bodytext3"><strong><?php echo 'Debit'; ?></strong></td>
				<td width="153" align="right" class="bodytext3"><strong><?php echo 'Credit'; ?></strong></td>
				<td width="153" align="right" class="bodytext3"><strong><?php echo 'Balance'; ?></strong></td>
				</tr>
                <?php
                $query267 = "select accountname,auto_number,id from master_accountname where id = '$id' group by id";
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
					//$dno = $dno + 1;
										
					$querycr1 = "SELECT * FROM (SELECT (`transactionamount`) as paylater,transactiondate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'finalize' AND `billnumber` LIKE '%CB%'
								 UNION ALL SELECT (`transactionamount`) as paylater,transactiondate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'finalize' AND `billnumber` LIKE '%IPDr%'
					 			 UNION ALL SELECT (`transactionamount`) as paylater,transactiondate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `master_transactionip` WHERE `accountnameid` = '$id' AND billtype = 'PAY LATER' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
								 UNION ALL SELECT (`totalamount`) as paylater,billdate as td2, billno as td3, patientcode as td4, patientname as td5 FROM `billing_ipcreditapprovedtransaction` WHERE `accountnameid` = '$id' AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
								 UNION ALL SELECT (`debitamount`) as paylater,entrydate as td2, docno as td3, ledgerid as td4, narration as td5 FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
								 
								 UNION ALL SELECT (-1*transactionamount) as paylater,transactiondate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `docno` LIKE '%IPCr%' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'paylatercredit'
								 UNION ALL SELECT (-1*transactionamount) as paylater,transactiondate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `docno` LIKE 'Cr.N%' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'paylatercredit'
								 UNION ALL SELECT (-1*`amount`) as paylater,billdate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `paylaterpharmareturns` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' AND `billnumber` IN (SELECT b.`docno` FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE b.`accountnameid` = '$id' and a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number`)
								 UNION ALL SELECT (-1*transactionamount) as paylater,transactiondate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `docno` LIKE 'AR-%' AND `transactionstatus` = 'onaccount' AND `transactionmodule` = 'PAYMENT'
								 UNION ALL SELECT (-1*creditamount) as paylater,entrydate as td2, docno as td3, ledgerid as td4, narration as td5 FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2') as pp ORDER BY pp.td2";
					$execcr1 = mysql_query($querycr1) or die ("Error in Querycr1".mysql_error());
					while($rescr1 = mysql_fetch_array($execcr1))
					{
					$amount = $rescr1['paylater'];
					$entrydate = $rescr1['td2'];
					$docno = $rescr1['td3'];
					$itemcode = $rescr1['td4'];
					$itemname = $rescr1['td5'];
					$chequeno = '';
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
					<?php if($amount >= 0) { ?>
					<td align="right" class="bodytext3"><?php echo number_format(abs($amount),2,'.',','); ?></td>
					<td align="left" class="bodytext3">&nbsp;</td>
					<?php } else { ?>
					<td align="left" class="bodytext3">&nbsp;</td>
					<td align="right" class="bodytext3"><?php echo number_format(abs($amount),2,'.',','); ?></td>
					<?php } ?>
                    <td align="right" class="bodytext3"><?php echo number_format($sumbalance,2,'.',','); ?></td>
					</tr>
					<?php
					}
				}
				
				}
				else if($group == '18' || $group == '19' || $group == '20')
				{
				?>
                <tr>
				<td colspan="9" bgcolor="#FFFFFF" class="bodytext3" align="left"><strong><?php echo $ledger.' - '.'From '.date('d-M-Y',strtotime($ADate1)).' '.'to '.date('d-M-Y',strtotime($ADate2)); ?></strong></td>
				</tr>
				<tr bgcolor="#CCC">
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'S.No'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Date'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Docno'; ?></strong></td>
				<td width="103" align="left" class="bodytext3"><strong><?php echo 'Code'; ?></strong></td>
				<td width="190" align="left" class="bodytext3"><strong><?php echo 'Description'; ?></strong></td>
				<td width="141" align="right" class="bodytext3"><strong><?php echo 'Debit'; ?></strong></td>
				<td width="153" align="right" class="bodytext3"><strong><?php echo 'Credit'; ?></strong></td>
				<td width="153" align="right" class="bodytext3"><strong><?php echo 'Balance'; ?></strong></td>
				</tr>
                <?php
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
		
					$querydr1 = "SELECT (`cashamount`) as bankamount, billdate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `billing_consultation` WHERE (`cashcode` = '$id') AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
									UNION ALL SELECT (`creditamount`) as bankamount, billdate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `billing_consultation` WHERE (`mpesacode` = '$id') AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
									UNION ALL SELECT (`cardamount`) as bankamount, billdate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `billing_consultation` WHERE (`bankcode` = '$id') AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
									UNION ALL SELECT (`onlineamount`) as bankamount, billdate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `billing_consultation` WHERE (`bankcode` = '$id') AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
									UNION ALL SELECT (`chequeamount`) as bankamount, billdate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `billing_consultation` WHERE (`bankcode` = '$id') AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
									
									UNION ALL SELECT (`cashamount`) as bankamount, transactiondate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `master_transactionpaynow` WHERE (`cashcode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									UNION ALL SELECT (`creditamount`) as bankamount, transactiondate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `master_transactionpaynow` WHERE (`mpesacode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									UNION ALL SELECT (`cardamount`) as bankamount, transactiondate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `master_transactionpaynow` WHERE (`bankcode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									UNION ALL SELECT (`onlineamount`) as bankamount, transactiondate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `master_transactionpaynow` WHERE (`bankcode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									UNION ALL SELECT (`chequeamount`) as bankamount, transactiondate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `master_transactionpaynow` WHERE (`bankcode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									
									UNION ALL SELECT (`cashamount`) as bankamount, transactiondate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `master_transactionexternal` WHERE (`cashcode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									UNION ALL SELECT (`creditamount`) as bankamount, transactiondate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `master_transactionexternal` WHERE (`mpesacode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									UNION ALL SELECT (`cardamount`) as bankamount, transactiondate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `master_transactionexternal` WHERE (`bankcode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									UNION ALL SELECT (`onlineamount`) as bankamount, transactiondate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `master_transactionexternal` WHERE (`bankcode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									UNION ALL SELECT (`chequeamount`) as bankamount, transactiondate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `master_transactionexternal` WHERE (`bankcode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									
									UNION ALL SELECT (`transactionamount`) as bankamount, transactiondate as td2, docno as td3, accountnameid as td4, accountname as td5 FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'finalize' AND `billnumber` LIKE '%CB%'
									
									UNION ALL SELECT (`cashamount`) as bankamount, transactiondate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `master_transactionadvancedeposit` WHERE `cashcode` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									UNION ALL SELECT (`creditamount`) as bankamount, transactiondate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `master_transactionadvancedeposit` WHERE `mpesacode` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									UNION ALL SELECT (`chequeamount`) as bankamount, transactiondate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `master_transactionadvancedeposit` WHERE `bankcode` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									UNION ALL SELECT (`onlineamount`) as bankamount, transactiondate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `master_transactionadvancedeposit` WHERE `bankcode` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									UNION ALL SELECT (`cardamount`) as bankamount, transactiondate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `master_transactionadvancedeposit` WHERE `bankcode` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									
									UNION ALL SELECT (`cashamount`) as bankamount, transactiondate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `master_transactionipdeposit` WHERE `cashcode` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactionmodule` = 'PAYMENT'
									UNION ALL SELECT (`creditamount`) as bankamount, transactiondate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `master_transactionipdeposit` WHERE `mpesacode` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactionmodule` = 'PAYMENT'
									UNION ALL SELECT (`chequeamount`) as bankamount, transactiondate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `master_transactionipdeposit` WHERE `bankcode` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactionmodule` = 'PAYMENT'
									UNION ALL SELECT (`onlineamount`) as bankamount, transactiondate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `master_transactionipdeposit` WHERE `bankcode` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactionmodule` = 'PAYMENT'
									UNION ALL SELECT (`cardamount`) as bankamount, transactiondate as td2, docno as td3, patientcode as td4, patientname as td5 FROM `master_transactionipdeposit` WHERE `bankcode` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactionmodule` = 'PAYMENT'
					
									UNION ALL SELECT (`cashamount`) as bankamount, transactiondate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `master_transactionip` WHERE `cashcode` = '$id' AND billtype = 'PAY NOW' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									UNION ALL SELECT (`mpesaamount`) as bankamount, transactiondate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `master_transactionip` WHERE `mpesacode` = '$id' AND billtype = 'PAY NOW' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									UNION ALL SELECT (`chequeamount`) as bankamount, transactiondate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `master_transactionip` WHERE `bankcode` = '$id' AND billtype = 'PAY NOW' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									UNION ALL SELECT (`cardamount`) as bankamount, transactiondate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `master_transactionip` WHERE `bankcode` = '$id' AND billtype = 'PAY NOW' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									UNION ALL SELECT (`onlineamount`) as bankamount, transactiondate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `master_transactionip` WHERE `bankcode` = '$id' AND billtype = 'PAY NOW' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									UNION ALL SELECT (`returnbalance`) as bankamount, transactiondate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `master_transactionip` WHERE `cashcode` = '$id' AND billtype = 'PAY NOW' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									
									UNION ALL SELECT (`totalamount`) as bankamount, billdate as td2, billno as td3, patientcode as td4, patientname as td5 FROM `billing_ipcreditapprovedtransaction` WHERE `accountnameid` = '$id' AND `billdate` BETWEEN '$ADate1' AND '$ADate2'
									
									UNION ALL SELECT (`cashamount`) as bankamount, transactiondate as td2, docnumber as td3, receiptcoa as td4, remarks as td5 FROM `receiptsub_details` WHERE (`cashcode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									UNION ALL SELECT (`creditamount`) as bankamount, transactiondate as td2, docnumber as td3, receiptcoa as td4, remarks as td5 FROM `receiptsub_details` WHERE (`mpesacode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									UNION ALL SELECT (`cardamount`) as bankamount, transactiondate as td2, docnumber as td3, receiptcoa as td4, remarks as td5 FROM `receiptsub_details` WHERE (`bankcode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									UNION ALL SELECT (`onlineamount`) as bankamount, transactiondate as td2, docnumber as td3, receiptcoa as td4, remarks as td5 FROM `receiptsub_details` WHERE (`bankcode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									UNION ALL SELECT (`chequeamount`) as bankamount, transactiondate as td2, docnumber as td3, receiptcoa as td4, remarks as td5 FROM `receiptsub_details` WHERE (`bankcode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
					
									UNION ALL SELECT (transactionamount) as bankamount, transactiondate as td2, docno as td3, accountnameid as td4, accountname as td5 FROM `master_transactionpaylater` WHERE `bankcode` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `docno` LIKE 'AR-%' AND `transactionstatus` = 'onaccount' AND `transactionmodule` = 'PAYMENT'
									UNION ALL SELECT (amount) as bankamount, transactiondate as td2, docnumber as td3, tobankid as td4, bankname as td5 FROM `bankentryform` WHERE `tobankid` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									UNION ALL SELECT (debitamount) as bankamount, `entrydate` as td2, `docno` as td3, `ledgerid` as td4, `narration` as td5 FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'
									
									UNION ALL SELECT (-1*transactionamount) as bankamount, transactiondate as td2, docno as td3, accountnameid as td4, accountname as td5 FROM `master_transactionpaylater` WHERE `accountnameid` = '$id' AND `docno` LIKE '%IPCr%' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2' AND `transactiontype` = 'paylatercredit'
									UNION ALL SELECT (-1*`cashamount`) as bankamount, transactiondate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `refund_paynow` WHERE (`cashcode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									UNION ALL SELECT (-1*`creditamount`) as bankamount, transactiondate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `refund_paynow` WHERE (`mpesacode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									UNION ALL SELECT (-1*`cardamount`) as bankamount, transactiondate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `refund_paynow` WHERE (`bankcode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									UNION ALL SELECT (-1*`onlineamount`) as bankamount, transactiondate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `refund_paynow` WHERE (`bankcode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									UNION ALL SELECT (-1*`chequeamount`) as bankamount, transactiondate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `refund_paynow` WHERE (`bankcode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									
									UNION ALL SELECT (-1*creditamount) as bankamount, transactiondate as td2, docnumber as td3, frombankid as td4, frombankname as td5 FROM `bankentryform` WHERE `frombankid` = '$id' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									
									UNION ALL SELECT (-1*`transactionamount`) as bankamount, transactiondate as td2, docno as td3, suppliercode as td4, suppliername as td5 FROM `master_transactionpharmacy` WHERE `bankcode` = '$id' AND `transactionmodule` = 'PAYMENT' AND `recordstatus` = 'allocated' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									UNION ALL SELECT (-1*`transactionamount`) as bankamount, transactiondate as td2, paymonth as td3, accountcode as td4, accountname as td5 FROM `master_transactionpayroll` WHERE `bankcode` = '$id' AND `transactionmodule` = 'PAYMENT' AND `recordstatus` = 'allocated' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									UNION ALL SELECT (-1*`transactionamount`) as bankamount, transactiondate as td2, docno as td3, doctorcode as td4, doctorname as td5 FROM `master_transactiondoctor` WHERE `bankcode` = '$id' AND `transactionmodule` = 'PAYMENT' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									UNION ALL SELECT (-1*`amount`) as bankamount,billdate as td2, billnumber as td3, patientcode as td4, patientname as td5 FROM `paylaterpharmareturns` WHERE billdate BETWEEN '$ADate1' AND '$ADate2' AND `billnumber` IN (SELECT b.`docno` FROM `master_transactionpaylater` as a JOIN `master_transactionpaylater` as b ON (a.`visitcode` = b.`visitcode`) WHERE b.`accountnameid` = '$id' and a.`transactiontype` = 'finalize' and b.`transactiontype` = 'pharmacycredit' and b.`auto_number` > a.`auto_number`)
									
									UNION ALL SELECT (-1*`cashamount`) as bankamount, transactiondate as td2, docnumber as td3, expensecoa as td4, remarks as td5 FROM `expensesub_details` WHERE (`cashcode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									UNION ALL SELECT (-1*`creditamount`) as bankamount, transactiondate as td2, docnumber as td3, expensecoa as td4, remarks as td5 FROM `expensesub_details` WHERE (`mpesacode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									UNION ALL SELECT (-1*`cardamount`) as bankamount, transactiondate as td2, docnumber as td3, expensecoa as td4, remarks as td5 FROM `expensesub_details` WHERE (`bankcode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									UNION ALL SELECT (-1*`onlineamount`) as bankamount, transactiondate as td2, docnumber as td3, expensecoa as td4, remarks as td5 FROM `expensesub_details` WHERE (`bankcode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									UNION ALL SELECT (-1*`chequeamount`) as bankamount, transactiondate as td2, docnumber as td3, expensecoa as td4, remarks as td5 FROM `expensesub_details` WHERE (`bankcode` = '$id') AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
									
									UNION ALL SELECT (-1*creditamount) as bankamount, `entrydate` as td2, `docno` as td3, `ledgerid` as td4, `narration` as td5 FROM `master_journalentries` WHERE `ledgerid` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
					$execdr1 = mysql_query($querydr1) or die ("Error in Querydr1".mysql_error());
					while($resdr1 = mysql_fetch_array($execdr1))
					{
					$amount = $resdr1['bankamount'];
					$entrydate = $resdr1['td2'];
					$docno = $resdr1['td3'];
					$itemcode = $resdr1['td4'];
					$itemname = $resdr1['td5'];
					$chequeno = '';
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
					<?php if($amount >= 0) { ?>
					<td align="right" class="bodytext3"><?php echo number_format($amount,2,'.',','); ?></td>
					<td align="left" class="bodytext3">&nbsp;</td>
					<?php } else { ?>
					<td align="left" class="bodytext3">&nbsp;</td>
					<td align="right" class="bodytext3"><?php echo number_format(abs($amount),2,'.',','); ?></td>
					<?php } ?>
                    <td align="right" class="bodytext3"><?php echo number_format($sumbalance,2,'.',','); ?></td>
					</tr>
					<?php
					}
					}
                	
				}
				else if($group == '15' || $group == '23' || $group == '24' || $group == '25')
				{
				?>
                <tr>
				<td colspan="9" bgcolor="#FFFFFF" class="bodytext3" align="left"><strong><?php echo $ledger.' - '.'From '.date('d-M-Y',strtotime($ADate1)).' '.'to '.date('d-M-Y',strtotime($ADate2)); ?></strong></td>
				</tr>
				<tr bgcolor="#CCC">
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'S.No'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Date'; ?></strong></td>
				<td width="92" align="left" class="bodytext3"><strong><?php echo 'Docno'; ?></strong></td>
				<td width="103" align="left" class="bodytext3"><strong><?php echo 'Code'; ?></strong></td>
				<td width="190" align="left" class="bodytext3"><strong><?php echo 'Description'; ?></strong></td>
				<td width="141" align="right" class="bodytext3"><strong><?php echo 'Debit'; ?></strong></td>
				<td width="153" align="right" class="bodytext3"><strong><?php echo 'Credit'; ?></strong></td>
				<td width="153" align="right" class="bodytext3"><strong><?php echo 'Balance'; ?></strong></td>
				</tr>
                <?php
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
								 UNION ALL SELECT `totalamount` as td1,`entrydate` as td2,`billnumber` as td3,`suppliercode` as td4,`suppliername` as td5 FROM `purchasereturn_details` WHERE `suppliercode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
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
                    <td align="right" class="bodytext3"><?php echo number_format($sumbalance,2,'.',','); ?></td>
					</tr>
					<?php
					}
					$querydr1 = "SELECT `transactionamount` as td1,`transactiondate` as td2,`docno` as td3,`suppliercode` as td4,`suppliername` as td5 FROM `master_transactionpharmacy` WHERE `suppliercode` = '$id' AND `transactionmodule` = 'PAYMENT' AND `recordstatus` = 'allocated' AND `transactiondate` BETWEEN '$ADate1' AND '$ADate2'
								 UNION ALL SELECT `totalamount` as td1,`entrydate` as td2,`billnumber` as td3,`itemcode` as td4,`itemname` as td5 FROM `purchasereturn_details` WHERE `suppliercode` = '$id' AND `entrydate` BETWEEN '$ADate1' AND '$ADate2'";
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
                    <td align="right" class="bodytext3"><?php echo number_format($sumbalance,2,'.',','); ?></td>
					</tr>
					<?php
					}
					}
                	
				}
				?>
				<?php
				if($cbfrmflag1 == 'cbfrmflag1')
				{
				?>
				<tr bgcolor="#CCC">
				<td colspan="9" align="right" class="bodytext3">
				<a target="_blank" href="print_ledgerreport.php?<?php echo $url; ?>"> <img src="images/excel-xls-icon.png" width="30" height="30"></a>
				</td>
				</tr>
				<?php
				}
				?>
           </tbody>
		   </table>
		   </td>
		   </tr>
		   </table>
		   </td>
		   </tr>
		   </table>
		  
<?php include ("includes/footer1.php"); ?>
</body>
</html>
