<?php
session_start();

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="purchaseindentapproval.xls"');
header('Cache-Control: max-age=80');

include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('d-m-Y');
$paymentreceiveddateto1 = "2014-01-01";
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
$docno1 = $_SESSION['docno'];

//This include updatation takes too long to load for hunge items database.
//include ("autocompletebuild_account2.php");

//echo $amount;
if (isset($_REQUEST['docnumber'])) { $docnumber= $_REQUEST["docnumber"]; } else { $docnumber = ""; }

 $query = "select * from login_locationdetails where username='$username' and docno='$docno1' order by locationname";
$exec = mysql_query($query) or die ("Error in Query1".mysql_error());
$res = mysql_fetch_array($exec);
	
 	$locationname  = $res["locationname"]; 
	$locationcode = $res["locationcode"]; 

$query23 = "select * from master_employeelocation where username='$username' and defaultstore='default' and locationcode='".$locationcode."'";
$exec23 = mysql_query($query23) or die(mysql_error());
$res23 = mysql_fetch_array($exec23);

$res7storeanum = $res23['storecode'];
$query75 = "select * from master_store where auto_number='$res7storeanum'";
$exec75 = mysql_query($query75) or die(mysql_error());
$res75 = mysql_fetch_array($exec75);
$store = $res75['store'];
$storecode = $res75['storecode'];

$query2 = "select * from master_location where locationcode = '$locationcode'";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
//$companyname = $res2["companyname"];
$address1 = $res2["address1"];
$address2 = $res2["address2"];
//		$area = $res2["area"];
//		$city = $res2["city"];
//		$pincode = $res2["pincode"];
$emailid1 = $res2["email"];
$phonenumber1 = $res2["phone"];
//		$phonenumber2 = $res2["phonenumber2"];
//		$tinnumber1 = $res2["tinnumber"];
//		$cstnumber1 = $res2["cstnumber"];
$locationname =  $res2["locationname"];
$prefix = $res2["prefix"];
$suffix = $res2["suffix"];
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
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
</style>
</head>
<body>
<table width="100%" cellpadding="4" cellspacing="0" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
<tr>
					<td colspan="2" width="168" align="left" class="bodytext3"><?php echo $companyname; ?></td>
					<td width="88" align="left" class="bodytext3">&nbsp;</td>
					<td width="267" align="left" class="bodytext3">&nbsp;</td>
					<td width="151" align="left" class="bodytext3"><?php echo $transactiondateto; ?></td>
                    <td width="151" align="left" class="bodytext3">&nbsp;</td>
</tr>
<tr>
					<td colspan="2" width="168" align="left" class="bodytext3"><?php echo $address1; ?> </td>
					<td width="88" align="left" class="bodytext3">&nbsp;</td>
					<td width="267" align="left" class="bodytext3">&nbsp;</td>
					<td width="151" align="left" class="bodytext3">Doc No. <?php echo $docnumber; ?></td>
                    <td width="151" align="left" class="bodytext3"></td>
</tr>
<tr>
					<td colspan="2" width="168" align="left" class="bodytext3"><?php echo $address2; ?> </td>
					<td width="88" align="left" class="bodytext3">&nbsp;</td>
					<td width="267" align="left" class="bodytext3">&nbsp;</td>
					<td width="151" align="left" class="bodytext3">&nbsp;</td>
                    <td width="151" align="left" class="bodytext3"></td>
</tr>
<tr>
					<td colspan="2" width="168" align="left" class="bodytext3">&nbsp;</td>
					<td width="88" align="left" class="bodytext3">&nbsp;</td>
					<td width="267" align="left" class="bodytext3">&nbsp;</td>
					<td width="151" align="left" class="bodytext3">&nbsp;</td>
                    <td width="151" align="left" class="bodytext3"></td>
</tr>
</tbody>
</table>
		
      <table width="100%" border="1" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
					
<tr bgcolor="#011E6A">
                       	 
                        <td width="6%" bgcolor="#CCCCCC" class="bodytext3"><strong>No </strong></td>
                        <td width="9%" bgcolor="#CCCCCC" class="bodytext3"><strong>Medicine Name</strong></td>
                        <td width="8%" bgcolor="#CCCCCC" class="bodytext3"><strong>Req Qty</strong></td>
                        <td width="10%" bgcolor="#CCCCCC" class="bodytext3"><div align="center"><strong>Pack Size</strong></div></td>
                        <td width="5%" bgcolor="#CCCCCC" class="bodytext3"><div align="center"><strong>Pkg Qty</strong></div></td>
						<td width="8%" bgcolor="#CCCCCC" class="bodytext3"><div align="center"><strong>Rate</strong></div></td>
						<td width="10%" bgcolor="#CCCCCC" class="bodytext3"><div align="center"><strong>Amount</strong></div></td>

                      </tr>
					   <?php
		$query12 = "select * from purchase_indent where docno='$docnumber' and approvalstatus NOT LIKE '%reject%'";
		$exec12 = mysql_query($query12) or die ("Error in Query1".mysql_error());
		$numb=mysql_num_rows($exec12);

		while ($res12 = mysql_fetch_array($exec12))
		{
			
		$itemcode = $res12["medicinecode"];
		$itemname = $res12["medicinename"];
		$rate = $res12["rate"];
		$reqqty = $res12['quantity'];
		$amount = $res12['amount'];
		
		include ('autocompletestockcount1include1.php');
		 $currentstock = $currentstock; 
		
		$query330 = "select sum(quantity) as totalquantitypurchasequantity from purchase_indent where medicinecode = '$itemcode' and status='Process'";
		$exec330 = mysql_query($query330) or die(mysql_error()); 
		$res330 = mysql_fetch_array($exec330);
		$purchasequantity = $res330['totalquantitypurchasequantity'];
		
		
		$query331 = "select sum(packagequantity) as totalquantity from purchase_indent where medicinecode = '$itemcode' and docno='$docnumber'";
		$exec331 = mysql_query($query331) or die(mysql_error()); 
		$res331 = mysql_fetch_array($exec331);
		$quantity = $res331['totalquantity'];
		

		
		$query2 = "select * from master_medicine where itemcode = '$itemcode'";
		$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		$res2 = mysql_fetch_array($exec2);
		$package = $res2['packagename'];
		
		$sno = $sno + 1;	
		?>
        <tr>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="center"><?php echo $sno; ?></div></td>
                
					    <td align="left" valign="top"  class="bodytext3"><?php echo $itemname; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $reqqty; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $package; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $quantity; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $rate; ?></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $amount; ?></td>

						 </tr>
		<?php
		}
		?>
		</tbody>
		</table>
		<table width="100%" border="0" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
        <tbody>
		<tr>
		<td colspan="2" align="left" class="bodytext3"><strong>&nbsp;</strong></td>
		<td align="left" valign="top"  class="bodytext3"></td>
		</tr>
		<tr>
		<td colspan="2" align="left" class="bodytext3"><strong>PROJECT :</strong></td>
		<td align="left" valign="top"  class="bodytext3"></td>
		</tr>
		<tr>
		<td colspan="2" align="left" class="bodytext3"><strong>BUDGET LINE :</strong></td>
		<td align="left" valign="top"  class="bodytext3"></td>
		</tr>
		<tr>
		<td colspan="2" align="left" class="bodytext3"><strong>BUDGET CODE :</strong></td>
		<td align="left" valign="top"  class="bodytext3"></td>
		</tr>
		<tr>
		<td colspan="2" align="left" class="bodytext3"><strong>WARRENTY :</strong></td>
		<td align="left" valign="top"  class="bodytext3"></td>
		</tr>
		<tr>
		<td colspan="2" align="left" class="bodytext3"><strong>DELIVERY/TRANSPORT :</strong></td>
		<td align="left" valign="top"  class="bodytext3"></td>
		</tr>
		<tr>
		<td colspan="2" align="left" class="bodytext3"><strong>TERMS OF PAYMENT :</strong></td>
		<td align="left" valign="top"  class="bodytext3"></td>
		</tr>
		<tr>
		<td colspan="2" align="left" class="bodytext3"><strong>QUOTATION NUMBER/DATE :</strong></td>
		<td align="left" valign="top"  class="bodytext3"></td>
		</tr>
		<tr>
		<td colspan="2" align="left" class="bodytext3"><strong>LPO VALIDITY :</strong></td>
		<td align="left" valign="top"  class="bodytext3"></td>
		</tr>
		<tr>
		<td colspan="2" align="left" class="bodytext3"><strong>REASON FOR EXPENDITURE :</strong></td>
		<td align="left" valign="top"  class="bodytext3"></td>
		</tr>
		<tr>
		<td colspan="2" align="left" class="bodytext3"><strong>VAT @16% :</strong></td>
		<td align="left" valign="top"  class="bodytext3"></td>
		</tr>
		<tr>
		<td colspan="2" align="left" class="bodytext3"><strong>ADDRESS :</strong></td>
		<td align="left" valign="top"  class="bodytext3"></td>
		</tr>
		<tr>
		<td colspan="2" align="left" class="bodytext3"><strong>&nbsp;</strong></td>
		<td align="left" valign="top"  class="bodytext3"></td>
		</tr>
		<tr>
		<td colspan="2" align="left" class="bodytext3"><strong>Prepared By</strong></td>
		<td colspan="2" align="left" class="bodytext3"><strong>Authorized By</strong></td>
		</tr>
		  </tbody>
        </table>
        

</body>
</html>
