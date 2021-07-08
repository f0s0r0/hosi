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
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = date('Y-m-d', strtotime('01-01-2015')); }
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
if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; }

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
		
		
              <form name="cbform1" method="post" action="ledgerreport.php" onSubmit="return modulecheck()">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#CCCCCC" class="bodytext3"><strong> Ledger Report</strong></td>
              </tr>
            <!--<tr>
              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
			  <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Payment Entry" /> 
                *To Print Other Receipts Please Go To Menu:	Reports	-&gt; Payments Given 
				</td>
              </tr>-->
            
		   
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
				$query7 = "select * from master_accountssub where recordstatus <> 'deleted' order by auto_number";
				$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
				while($res7 = mysql_fetch_array($exec7))
				{
				$groupname = $res7['accountssub'];
				$groupcode = $res7['auto_number'];
				?>
				<option value="<?php echo $groupcode; ?>" <?php if($group == $groupcode) { echo "selected=selected"; } ?>> <?php echo $groupname; ?> </option>
				<?php
				}
				?>
				</select>
				 </td>
				<td width="12%"  align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31">Select Location </td>
                      <td width="24%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">
					   <select name="location" id="location" style="border: 1px solid #001E6A" >
						<option value="">Select Location</option>
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
			$openingbalance = "0.00";
			$query89 = "select * from master_accountname where auto_number = '$ledgeranum'";
			$exec89 = mysql_query($query89) or die ("Error in Query89".mysql_error());
			$res89 = mysql_fetch_array($exec89);
			$group = $res89['accountssub'];
			$ledgerid = $res89['id'];
			
			$query83 = "select condfield from master_financialintegration where groupcode = '$group' and recordstatus <> 'deleted'";
			$exec83 = mysql_query($query83) or die ("Error in Query83".mysql_error());
			$res83 = mysql_fetch_array($exec83);
			$condfield3 = $res83['condfield'];
			if($condfield3 == '')
			{
			$query31 = "select * from master_financialintegration where code = '$ledgerid' and recordstatus <> 'deleted'";
			}
			else
			{
			$query31 = "select * from master_financialintegration where groupcode = '$group' and recordstatus <> 'deleted'";
			}
			$exec31 = mysql_query($query31) or die ("Error in Query31".mysql_error());
			while($res31 = mysql_fetch_array($exec31))
			{
			$tblname1 = $res31['tblname'];
			$tblcolumn1 = $res31['field'];
			$tbldate1 = $res31['datefield'];
			$acccoa = $res31['coa'];
			$status = $res31['selectstatus'];
			$type1 = $res31['type'];
			//$condfield = $res31['condfield'];
			$code1 = $res31['code'];
			
			$query9 = "select * from master_accountname where auto_number = '$ledgeranum'";
			$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
			$res9 = mysql_fetch_array($exec9);
			$accountsmain2 = $res9['accountname'];	
			$id2 = $res9['id'];
		
		
			$query81 = "select condfield from master_financialintegration where groupcode = '$group' and tblname = '$tblname1' and recordstatus <> 'deleted'";
			$exec81 = mysql_query($query81) or die ("Error in Query81".mysql_error());
			$res81 = mysql_fetch_array($exec81);
			$condfield1 = $res81['condfield'];
			if($condfield1 == '')
			{
			$query132 = "select SUM($tblcolumn1) as totalsumamount32 from $tblname1 where $tbldate1 < '$ADate1' and locationcode = '$location'";
			}
			else
			{
			$query132 = "select SUM($tblcolumn1) as totalsumamount32 from $tblname1 where $condfield1 = '$id2' and $tbldate1 < '$ADate1' and locationcode = '$location'";
			}
			$exec132 = mysql_query($query132) or die ("Error in Query132".mysql_error());
			$res132 = mysql_fetch_array($exec132);
			//echo '<br>'.$query132;
			$totalsumamount32 = $res132['totalsumamount32'];
			
			if($status == 'dr' && $type1 == 'A')
			{
			$openingbalance = $openingbalance + $totalsumamount32;
			}
			if($status == 'cr' && $type1 == 'A')
			{
			$openingbalance = $openingbalance - $totalsumamount32;
			}
			if($status == 'cr' && $type1 == 'I')
			{
			$openingbalance = $openingbalance + $totalsumamount32;
			}
			if($status == 'dr' && $type1 == 'I')
			{
			$openingbalance = $openingbalance - $totalsumamount32;
			}
			if($status == 'cr' && $type1 == 'L')
			{
			$openingbalance = $openingbalance + $totalsumamount32;
			}
			if($status == 'dr' && $type1 == 'L')
			{
			$openingbalance = $openingbalance - $totalsumamount32;
			}
			if($status == 'dr' && $type1 == 'E')
			{
			$openingbalance = $openingbalance + $totalsumamount32;
			}
			if($status == 'cr' && $type1 == 'E')
			{
			$openingbalance = $openingbalance - $totalsumamount32;
			}
			}
			//$openingbalance;
			if($type1 == 'A' || $type1 == 'E')
			{
				$openingbalancedebit = $openingbalance;
			}
			else
			{
				$openingbalancecredit = $openingbalance;
			}
			?>	
				
            <tr>
              <td width="47"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
              <td width="229" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Description </strong></td>
              <td width="99" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Credit</strong></td>
				<td width="400" rowspan="1000"  align="left" valign="top" bgcolor="#E0E0E0" >
			
				  <table width="400" id="AutoNumber3" style="BORDER-COLLAPSE: collapse; margin-top:-3px;" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" 
            align="left" border="0">
				  <tr>
				  <td width="12%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
              <td width="45%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Description </strong></td>
              <td width="20%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Debit</strong></td>
				</tr>
				
				<tr>
			<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc"><strong>&nbsp;</strong></td>
				<td width="169" align="left" valign="center"  
                bgcolor="#cccccc" class="bodytext31"><strong>Balance Brought Forward </strong></td>
       			  <td width="93" align="left" valign="center"  
                bgcolor="#cccccc" class="bodytext31"><div align="right"><strong><?php echo number_format($openingbalancedebit,2,'.',','); ?></strong></div></td>
			</tr>
			<?php
			$query8 = "select condfield from master_financialintegration where groupcode = '$group' and recordstatus <> 'deleted'";
			$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
			$res8 = mysql_fetch_array($exec8);
			$condfield = $res8['condfield'];
			if($condfield == '')
			{
			$query1 = "select * from master_financialintegration where code = '$ledgerid' and selectstatus = 'dr' and recordstatus <> 'deleted'";
			}
			else
			{
			$query1 = "select * from master_financialintegration where groupcode = '$group' and selectstatus = 'dr' and recordstatus <> 'deleted'";
			}
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			while($res1 = mysql_fetch_array($exec1))
			{
			$tblname1 = $res1['tblname'];
			$tblcolumn1 = $res1['field'];
			$tbldate1 = $res1['datefield'];
			//$acccoa = $res1['coa'];
			$status = $res1['selectstatus'];
			$type1 = $res1['type'];
			$displayname = $res1['displayname'];
			$condfield = $res1['condfield'];
			$code1 = $res1['code'];
			$fanum1 = $res1['auto_number'];
			
			$query9 = "select * from master_accountname where auto_number = '$ledgeranum'";
			$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
			$res9 = mysql_fetch_array($exec9);
			$acccoa = $res9['accountname'];
			$id = $res9['id'];
			
			if($condfield == '')
			{
			$query2 = "select SUM($tblcolumn1) as totalsumamount2 from $tblname1 where $tbldate1 between '$ADate1' and '$ADate2' and locationcode = '$location'";
			}
			else
			{
			$query2 = "select SUM($tblcolumn1) as totalsumamount2 from $tblname1 where $condfield = '$id' and $tbldate1 between '$ADate1' and '$ADate2' and locationcode = '$location'";
			}
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			while($res2 = mysql_fetch_array($exec2))
			{
			$totalsumamount2 = $res2['totalsumamount2'];
			
			$totalamount21 = $totalamount21 + $totalsumamount2;
			
			?>
			<?php
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
			<td width="17" align="left" class="bodytext3"><?php echo $snocount; ?></td>
			<td width="50" align="left" class="bodytext3"><a href="ledgerreport_detail.php?tbl=<?php echo $tblname1; ?>&&field=<?php echo $tblcolumn1; ?>&&ledgeranum=<?php echo $ledgeranum;?>&&group=<?php echo $group; ?>&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&anum=<?php echo $fanum1; ?>&&location=<?php echo $location; ?>" target="_blank"><?php echo $displayname; ?></a></td>
			<td width="70" align="right" class="bodytext3"><?php echo number_format($totalsumamount2,2,'.',','); ?></td>
			</tr>
			<?php
			}
			}
			?>
			<tr bgcolor="#CCCCCC">
			<td width="17" align="left" class="bodytext3"><?php //echo $snocount; ?></td>
			<td width="50" align="left" class="bodytext3"><strong><?php echo 'Total'; ?></strong></td>
			<td width="70" align="right" class="bodytext3"><strong><?php echo number_format($totalamount21+$openingbalancedebit,2,'.',','); ?></strong></td>
			</tr>
			  </tbody>
        </table></td>
      </tr>
	  <tr>
		<td class="bodytext31" valign="center"  align="left" 
			bgcolor="#cccccc"><strong>&nbsp;</strong></td>
		  <td width="229" align="left" valign="center"  
			bgcolor="#cccccc" class="bodytext31"><strong>Balance Brought Forward</strong></td>
			  <td width="99" align="left" valign="center"  
			bgcolor="#cccccc" class="bodytext31"><div align="right"><strong><?php echo number_format($openingbalancecredit,2,'.',','); ?></strong></div></td>
		</tr>
		<?php
		$totalamount2 = '0.00';
		$snocount = '';
		$condfield1 = '';
		$query81 = "select condfield from master_financialintegration where groupcode = '$group' and recordstatus <> 'deleted'";
		$exec81 = mysql_query($query81) or die ("Error in Query81".mysql_error());
		$res81 = mysql_fetch_array($exec81);
		$condfield1 = $res81['condfield'];
		if($condfield1 == '')
		{
		$query1 = "select * from master_financialintegration where code = '$ledgerid' and selectstatus = 'cr' and recordstatus <> 'deleted'";
		}
		else
		{
		$query1 = "select * from master_financialintegration where groupcode = '$group' and selectstatus = 'cr' and recordstatus <> 'deleted'";
		}
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			while($res1 = mysql_fetch_array($exec1))
			{
			$tblname1 = $res1['tblname'];
			$tblcolumn1 = $res1['field'];
			$tbldate1 = $res1['datefield'];
			//$acccoa = $res1['coa'];
			$status = $res1['selectstatus'];
			$type1 = $res1['type'];
			$displayname = $res1['displayname'];
			$condfield = $res1['condfield'];
			$code1 = $res1['code'];
			$fanum2 = $res1['auto_number'];
			
			$query9 = "select * from master_accountname where auto_number = '$ledgeranum'";
			$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
			$res9 = mysql_fetch_array($exec9);
			$acccoa = $res9['accountname'];
			$id = $res9['id'];
						
			if($condfield == '')
			{
			$query2 = "select SUM($tblcolumn1) as totalsumamount2 from $tblname1 where $tbldate1 between '$ADate1' and '$ADate2' and locationcode = '$location'";
			}
			else
			{
			$query2 = "select SUM($tblcolumn1) as totalsumamount2 from $tblname1 where $condfield = '$id' and $tbldate1 between '$ADate1' and '$ADate2' and locationcode = '$location'";
			}
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			while($res2 = mysql_fetch_array($exec2))
			{
			$totalsumamount2 = $res2['totalsumamount2'];
			
			$totalamount2 = $totalamount2 + $totalsumamount2;
			
			?>
			<?php
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
			<td width="47" align="left" class="bodytext3"><?php echo $snocount; ?></td>
			<td width="229" align="left" class="bodytext3"><a href="ledgerreport_detail.php?tbl=<?php echo $tblname1; ?>&&field=<?php echo $tblcolumn1; ?>&&ledgeranum=<?php echo $ledgeranum;?>&&group=<?php echo $group; ?>&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&anum=<?php echo $fanum2; ?>&&location=<?php echo $location; ?>" target="_blank"><?php echo $displayname; ?></a></td>
			<td width="99" align="right" class="bodytext3"><?php echo number_format($totalsumamount2,2,'.',','); ?></td>
			</tr>
			<?php
			}
			}
			if($type1 == 'A' || $type1 == 'E')
			{
   			$balance = $totalamount21 - $totalamount2 + $openingbalance;
			}
			else
			{
			$balance = $totalamount2 - $totalamount21 + $openingbalance;
			}
			?>
			<tr bgcolor="#CCCCCC">
			<td width="47" align="left" class="bodytext3"><?php //echo $snocount; ?></td>
			<td width="229" align="left" class="bodytext3"><strong><?php echo 'Total'; ?></strong></td>
			<td width="99" align="right" class="bodytext3"><strong><?php echo number_format($totalamount2+$openingbalancecredit,2,'.',','); ?></strong></td>
			</tr>
            <tr>
            <td colspan="3" align="left" class="bodytext3">&nbsp;</td>
            </tr>
             <tr>
            <td colspan="3" align="left" class="bodytext3">&nbsp;</td>
            </tr>
             <tr>
            <td colspan="3" align="left" class="bodytext3">&nbsp;</td>
            </tr>
			<tr bgcolor="#CCCCCC">
			<td width="47" align="left" class="bodytext3"><?php //echo $snocount; ?></td>
			<td width="229" align="left" class="bodytext3"><strong><?php echo 'Ledger Balance'; ?></strong></td>
			<td width="99" align="right" class="bodytext3"><strong><?php echo number_format($balance,2,'.',','); ?></strong></td>
			</tr>
			
         
</table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
