<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$docno = $_SESSION['docno'];
$username = $_SESSION['username'];
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');
  $ADate1=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:$transactiondatefrom;
  $ADate2=isset($_REQUEST['ADate2'])?$_REQUEST['ADate2']:$transactiondateto;
$location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
if($location!='')
{
	$locationcode=$location;
	}
$data = '';
$status = '';
$searchsupplier = '';

ob_start();

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="StockTransfer.xls"');
header('Cache-Control: max-age=80');

$fromstore=isset($_REQUEST['fromstore'])?$_REQUEST['fromstore']:"";
$tostore=isset($_REQUEST['tostore'])?$_REQUEST['tostore']:"";
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
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
-->
</style>
</head>

<body>
			<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1451" 
            align="left" border="1">
            <tbody>
              <tr>
                <td colspan="13" bgcolor="#FFF" class="bodytext31">
				<strong>Stock Transfer Report</strong></td>
                </tr>
              
              <tr>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
                <td width="3%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Type</strong></div></td>
                <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> Doc No </strong></div></td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Location</strong></div></td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong> From Store </strong></div></td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>To Store</strong></div></td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Date</strong></div></td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Itemname</strong></div></td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Batch </strong></div></td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Exp.Dt </strong></div></td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"><strong>Tsn.Qty </strong></div></td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"><strong>Cost</strong></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="right"><strong>Total Amt</strong></div></td>
              </tr>
			  <?php
			  $colorloopcount = '';
			  $loopcount = '';
			  $totamount = 0;
			 $location=isset($_REQUEST['location'])?$_REQUEST['location']:$res1locationanum;
			 
			 if($tostore!=""){
			$query66 = "select * from master_stock_transfer where locationcode = '".$location."' and fromstore = '".$fromstore."' and tostore = '".$tostore."' and entrydate BETWEEN '".$ADate1."' and '".$ADate2."'";
			 }else{
			$query66 = "select * from master_stock_transfer where locationcode = '".$location."' and fromstore = '".$fromstore."' and entrydate BETWEEN '".$ADate1."' and '".$ADate2."'";
			 }
			 $exec66 = mysql_query($query66) or die ("Error in Query66".mysql_error());
			 while($res66 = mysql_fetch_array($exec66))
			 {
			  $itemcode = $res66['itemcode'];
			  $docno = $res66['docno'];
			  $typetransfer = $res66['typetransfer'];
			  $fromstore = $res66['fromstore'];
			  $tostore = $res66['tostore'];
			  $loopcount=$loopcount+1;
			  
			  $query22 = mysql_query("select store from master_store where storecode = '$fromstore'");
			  $res22 = mysql_fetch_array($query22);
			  $fromstore1 = $res22['store'];
			  
			  $query221 = mysql_query("select store from master_store where storecode = '$tostore'");
			  $res221 = mysql_fetch_array($query221);
			  $tostore1 = $res221['store'];

			if($typetransfer=="Consumable" || $tostore1==''){						
			  $query2a = "select accountname,accountsmain,id from master_accountname where id='$tostore'";
			  $exec2a = mysql_query($query2a) or die ("Error in Query2a".mysql_error());
			  $res2a = mysql_fetch_array($exec2a);
			  $tostore1 = $res2a["accountname"];
			 }
			  
			  $batch = $res66['batch'];
			  $fifo_code = $res66['fifo_code'];
			  $transaction_quantity = $res66['transferquantity'];
			  $entrydate = $res66['entrydate'];
			  $itemname = $res66['itemname'];
			  $locationname = $res66['locationname'];
			  
 			  $query2 = "SELECT expirydate FROM purchase_details WHERE fifo_code = '$fifo_code' and itemcode = '$itemcode' order by auto_number desc";
			  $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			  $res2 = mysql_fetch_array($exec2);
			  $expirydate = $res2['expirydate'];
			  
			  $query3 = "select purchaseprice from master_medicine where itemcode = '$itemcode'";
			  $exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
			  $res3 = mysql_fetch_array($exec3);
			  $rate = $res3['purchaseprice'];
			  
			  $amount = $transaction_quantity * $rate;
			  $totamount = $totamount + $amount;
			  
			  $colorloopcount = $colorloopcount + 1;
			  $showcolor = ($colorloopcount & 1); 
			  $colorcode = '';
			  if ($showcolor == 0)
			  {
			  	//$colorcode = 'bgcolor="#66CCFF"';
			  }
			  else
			  {
			  	$colorcode = 'bgcolor="#FFCC99"';
			  }
			  ?>
              <tr>
                <td class="bodytext31" valign="center"  align="left"><?php echo $loopcount; ?></td>
                <td class="bodytext31" valign="center"  align="left">
				<div align="center"><?php echo $typetransfer;?></div></td>
                <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">
                  <div align="left"><?php echo $docno;?></div>
                </div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="left">
				<?php echo $locationname; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31">
				  <div align="left"><?php echo $fromstore1; ?></div>
				</div></td>
                <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $tostore1; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $entrydate; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $itemname; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $batch; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $expirydate; ?></div></td>
                  <td class="bodytext31" valign="center"  align="left">
				  <div align="right"><?php echo $transaction_quantity; ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
				<div align="right"><?php echo $rate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
				  <div align="right"><?php echo number_format($amount,2); ?></div></td>
              </tr>
			  <?php
			  //}
			  }
			  ?>
              <tr>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong>Total : </strong></td>
                <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><strong><?php echo number_format($totamount,2); ?></strong></td>
                </tr>
            </tbody>
        </table>