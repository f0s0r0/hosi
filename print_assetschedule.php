<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$location =isset( $_REQUEST['location'])?$_REQUEST['location']:'';

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Assetschedule.xls"');
header('Cache-Control: max-age=80');

//This include updatation takes too long to load for hunge items database.


if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select * from master_supplier where auto_number = '$getcanum'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	$res4 = mysql_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}

if(isset($_REQUEST['searchitem'])) { $searchitem = $_REQUEST['searchitem']; } else { $searchitem = ""; }
?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #FFF;
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

<?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = "cbfrmflag1"; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{
$searchpatient = '';		
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1284" 
            align="left" border="1">
          <tbody>
             
            <tr>
              <td width="2%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
              <td width="5%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Account</strong></div></td>
				    <td width="21%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Name/ID</strong></div></td>
				 <td width="6%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No </strong></div></td>
				  <td width="7%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Cost</strong></div></td>
				 <td width="6%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Date</strong></div></td>
				  <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Years</strong></div></td>
				 <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>From</strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Category</strong></div></td>
			 <td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Location </strong></div></td>
				<td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Sale Price</strong></div></td>
			 <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Sale Date</strong></div></td>
				<td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Total Cost</strong></div></td>
			 <td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Opening Cost</strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Accum Depn Op</strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Year Dp</strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Cumu dp CB</strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Net Asset Value</strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Accn Depn </strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Check</strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Fully Depreciated</strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Addtions</strong></div></td>
              </tr>
           <?php
		 
           $query34 = "select * from assets_register where (itemname like '%$searchitem%' or asset_class like '%$searchitem%')";
		   $exec34 = mysql_query($query34) or die(mysql_error());
		   while($res34 = mysql_fetch_array($exec34))
		   {
		   $itemname = $res34['itemname'];
		   $itemcode = $res34['itemcode'];
		   $totalamount = $res34['totalamount'];
		   $entrydate = $res34['entrydate'];
		   $suppliercode = $res34['suppliercode'];
		   $suppliername = $res34['suppliername'];
		   $anum = $res34['auto_number'];
		   $asset_id = $res34['asset_id'];
			$asset_category = $res34['asset_category'];
			$asset_class = $res34['asset_class'];
			$asset_department = $res34['asset_department'];
			$asset_unit = $res34['asset_unit'];
			$asset_period = $res34['asset_period'];
			$startyear = $res34['startyear'];
			$quantity = $res34['quantity'];
			$dep_percent = $res34['dep_percent'];
			$depreciation = $totalamount * ($dep_percent / 100);
			$accdepreciation = $depreciation * $asset_period;
			$depreciationmonth = $depreciation / 12;
			$netvalue = $totalamount - $depreciation;
			
			$qryprchamount = "SELECT sum(depreciation) as totdepreciation FROM assets_depreciation WHERE itemname='$itemname' AND recordstatus<>'deleted'";
			$execprchamount = mysql_query($qryprchamount) or die ("Error in qryprchamount".mysql_error());
			$resdep = mysql_fetch_array($execprchamount);
			$totdepreciation = $resdep['totdepreciation'];
			if($totdepreciation > $totalamount)
			{
				$fdep = '';
			}
			else
			{
				$fdep = 'NO';
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
			
          <tr>
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $asset_id; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $itemname; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo number_format($quantity,0); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo number_format($totalamount,2); ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $entrydate; ?></div></td>	  
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $asset_period; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $startyear; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $asset_class; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $asset_department; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo number_format($totalamount,2); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo number_format(0,2); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo number_format(0,2); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo number_format($depreciation,2); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo number_format($depreciation,2); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo number_format($netvalue,2); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo number_format($depreciation,2); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo ''; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $fdep; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo number_format($totalamount,2); ?></div></td>
				</tr>
		  <?php
		  }
           ?>
            <tr>
              <td colspan="22" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#FFF">&nbsp;</td>
			</tr>
					
          </tbody>
        </table>
<?php
}
?>	
</body>
</html>

