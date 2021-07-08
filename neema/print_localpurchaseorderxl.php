<?php
session_start();
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$username = $_SESSION["username"];
$docno=$_SESSION["docno"];
$netamount=0.00;

ob_start();
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="POgenerated.xls"');
header('Cache-Control: max-age=80');

	$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname ";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	$res1 = mysql_fetch_array($exec1);
 	$locationname = $res1["locationname"];
	$locationcode = $res1["locationcode"];
	
if (isset($_REQUEST["billnumber"])) { $billnumber = $_REQUEST["billnumber"]; } else { $billnumber = ""; }

	$query2 = "select * from master_company where auto_number = '$companyanum'";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	$res2 = mysql_fetch_array($exec2);
	$companyname = $res2["companyname"];
	$address1 = $res2["address1"];
	$area = $res2["area"];
	$city = $res2["city"];
	$pincode = $res2["pincode"];
	$phonenumber1 = $res2["phonenumber1"];
	$phonenumber2 = $res2["phonenumber2"];
	$tinnumber1 = $res2["tinnumber"];
	$cstnumber1 = $res2["cstnumber"];
	$emailid1 = $res2['emailid1'];
	
	$query55 = "select * from purchaseorder_details where billnumber='$billnumber'";
	$exec55=mysql_query($query55) or die(mysql_error());
	$num55=mysql_num_rows($exec55);
	$res55=mysql_fetch_array($exec55);
	$billdate = $res55['billdate'];
	$suppliername = $res55['suppliername'];
	$suppliercode = $res55['suppliercode'];
	$remarks = $res55['remarks'];
	
	$query14 = "select * from master_accountname where id='$suppliercode'";
	$exec14 = mysql_query($query14) or die ("Error in Query14".mysql_error());
	$res14 = mysql_fetch_array($exec14);
	$res14accountname = $res14['accountname'];
	$res14address = $res14['address'];
	$res14contact = $res14['contact'];
	
?>
<style>
.logo{font-weight:bold; font-size:18px; text-align:center;}
.bodyhead{font-weight:bold; font-size:20px; text-align:center; text-decoration:underline;}
.bodytextbold{font-weight:bold; font-size:15px; }
.bodytext{font-weight:normal; font-size:15px;  vertical-align:middle;}
.border{border:1px #000000;}
td{{height: 50px;padding: 5px;}
table{table-layout:fixed;
width:100%;
display:table;
border-collapse:collapse;}
</style>
<table width="auto" border="0" cellpadding="0" cellspacing="0" align="center">

  <tr>
    <td width="100" rowspan="4"  align="left" valign="top" 
	 bgcolor="#ffffff" class="bodytext31">
      
      <?php
			$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
			$exec3showlogo = mysql_query($query3showlogo) or die ("Error in Query3showlogo".mysql_error());
			$res3showlogo = mysql_fetch_array($exec3showlogo);
			$showlogo = $res3showlogo['showlogo'];
			if ($showlogo == 'SHOW LOGO')
			{ 
			?>
      
     
      
      <?php
			}
			?>	</td>
            <td width="431" align="center" valign="bottom" 
	 bgcolor="#ffffff" class="bodytexthead style1"><?php echo $companyname; ?></td>
  </tr>
    <tr>
      <td align="center" valign="top" 
	 bgcolor="#ffffff" class="bodytextaddress"><?php echo $address1; ?></td>
    </tr>
    <tr>
	<td align="center" valign="top" 
	 bgcolor="#ffffff" class="bodytextaddress"><?php
	//echo '<br>'.$res1address1.' '.$res1area.' '.$res1city;
	//echo '<br>'.$res1pincode;
    if($phonenumber1 != '')
	 {
	echo '<strong class="bodytextaddress"> Tel : '.$phonenumber1.'</strong>';
	 }
	 ?></td>
  </tr>
  <tr>
	<td align="center" valign="top" 
	 bgcolor="#ffffff" class="bodytextaddress"><?php
	//echo '<br>'.$res1address1.' '.$res1area.' '.$res1city;
	//echo '<br>'.$res1pincode;
    if($emailid1 != '')
	 {
	echo '<strong class="bodytextaddress"> Email : '.$emailid1.'</strong>';
	 }
	 ?></td>
  </tr>
</table>

<table border="" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="5" class="bodyhead">PURCHASE ORDER</td>
	</tr>
    <tr>
    	<td class="bodytextbold">Supplier:</td>
        <td class="bodytext"><?php echo $suppliername;?></td>
        <td>&nbsp;</td>
        <td class="bodytextbold">Location:</td>
        <td class="bodytext"><?php echo $locationname;?></td>
    </tr>
    <tr>
		<td class="bodytextbold">Tel No:</td>
		<td class="bodytext"><?php echo $res14contact; ?></td>
		<td>&nbsp;</td>
		<td class="bodytextbold">LPO No:</td>
		<td class="bodytext"> <?php echo $billnumber; ?></td>
    </tr>
    <tr>
    	<td class="bodytextbold">Fax No:</td>
        <td class="bodytext"&nbsp;></td>
        <td>&nbsp;</td>
        <td class="bodytextbold">Date:</td>
        <td class="bodytext"><?php echo date("d-M-Y", strtotime($billdate)); ?></td>
    </tr>
    <tr>
    	<td class="bodytextbold">E Mail:</td>
        <td class="bodytext">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="bodytextbold">Time:</td>
        <td class="bodytext"><?php echo date('g.m A',strtotime($updatedatetime));?></td>
    </tr>
</table>
<table width="530" align="center" border="1" cellpadding="5" cellspacing="">
  <tr>
	  <td width="150" align="center" class="bodytextbold" >ITEM DESCRIPTION</td>
    <td width="30" align="center" class="bodytextbold" >ORDER QTY</td>
	 <td width="85" align="center" class="bodytextbold">PRICE</td>
	   <td width="63" align="center" class="bodytextbold" >TOTAL (KSH)</td>
	    <td width="58" align="center" class="bodytextbold" >REMARKS</td>
  </tr>
	  <?php
			$sno = '';
			
		$query34="select * from purchaseorder_details where billnumber='$billnumber' and recordstatus='generated' and itemstatus != 'deleted' group by itemname";
		$exec34=mysql_query($query34) or die(mysql_error());
		$num34 = mysql_num_rows($exec34);
		while($res34=mysql_fetch_array($exec34))
			{
			$totalquantity =0;
			$sumtotalquantity = 0;
			$amount = 0;
			$itemname=$res34['itemname'];
			$itemcode=$res34['itemcode'];
			$res34username=$res34['username'];
			
			$query35="select * from purchaseorder_details where billnumber='$billnumber' and recordstatus='generated' and itemstatus != 'deleted' and itemname='$itemname'";
		$exec35=mysql_query($query35) or die(mysql_error());
		while($res35=mysql_fetch_array($exec35))
		{
		$packagequantity=$res35['packagequantity'];
		$amt = $res35['totalamount'];
		$itemrate = $res35['rate'];
		$quantity = $res35['quantity'];
		$subtotal = $itemrate * $quantity;
		$amount = $amount + $amt;
		$totalquantity=$totalquantity+$packagequantity;
		$sumtotalquantity = $sumtotalquantity + $quantity;
	    }
			$query77 = "select * from master_medicine where itemcode='$itemcode'";
			$exec77 = mysql_query($query77) or die(mysql_error());
			$res77 = mysql_fetch_array($exec77);
			$rate = $res77['rateperunit'];
			$netamount = $netamount + $amount;
			?>
    <tr>
        <td class="bodytext " valign="center"  align="left" ><?php echo $itemname; ?></td>
        <td class="bodytext " valign="center"  align="right" ><?php echo number_format($quantity,2,'.',','); ?></td>
        <td class="bodytext " valign="center"  align="right"><?php echo number_format($itemrate,2,'.',','); ?></td>
        <td class="bodytext " valign="center"  align="right" ><?php echo number_format($subtotal,2,'.',','); ?></td>
        <td class="bodytext " valign="center"  align="right">&nbsp;</td>				
    </tr>
			<?php
			  }
			?> 
            </table>
            <table width="530" align="center" border="" cellpadding="5" cellspacing="">
			<tr>
			<td class="bodytextbold" valign="center" width="150"  align="right" >Total No of Items :</td>
			<td class="bodytext" valign="center" width="30"  align="right" ><?php echo number_format($sumtotalquantity,2,'.',','); ?></td>
			<td class="bodytextbold" valign="center" width="85"   align="right"><strong>Net Amount:</strong></td>
			  <td width="30" class="bodytext" valign="center" width="63"  align="right"><?php echo number_format($netamount,2,'.',','); ?></td>
			  <td width="58" class="bodytext" valign="center"  align="right">&nbsp;</td>
			</tr> 
			<tr>
			<td colspan="3" class="bodytextbold" valign="center"  align="right" ><strong>Grand Total:</strong></td>
			<td class="bodytext" valign="center"  align="right"><?php echo number_format($netamount,2,'.',','); ?></td>
			<td class="bodytext" valign="center"  align="right">&nbsp;</td>
			</tr> 
			<?php
				include('convert_currency_to_words.php');
				
			$convertedwords = covert_currency_to_words($netamount); 
			?>
			<tr>
			<td colspan="5" align="left" class="bodytextbold"><strong><i><?php echo $convertedwords; ?></i></strong></td>
			</tr>
			<tr>
			<td colspan="5" align="left" class="bodytext32">&nbsp;</td>
			</tr>
			<tr>
			<td colspan="5" align="left" class="bodytext32">&nbsp;</td>
			</tr>
			<tr>
			<td colspan="5" align="left" class="bodytext32">&nbsp;</td>
			</tr>
			<tr>
			<td colspan="5" align="left" class="bodytext32">&nbsp;</td>
			</tr>
			<tr>
			<td colspan="2" align="left" class="bodytext32">-----------------------------------------------</td>
			<td colspan="3" align="right" class="bodytext32">-----------------------------------------------</td>
			</tr>
			<tr>
			<td colspan="2" align="center" class="bodytextbold">Sign</td>
			<td colspan="3" align="center" class="bodytextbold">Sign</td>
			</tr>
			<tr>
			<td colspan="2" align="left" class="bodytextbold">Date</td>
            <td align="left" class="bodytext32">&nbsp;</td>
			<td colspan="2" align="left" class="bodytextbold">Date</td>
			</tr>
			<tr>
			<td colspan="5" align="left" class="bodytext32">&nbsp;</td>
			</tr>
			<tr>
			<td colspan="5" align="center" class="">This Purchase order is not valid unless signed by two signatories</td>
			</tr>
			<tr>
			<td colspan="5" align="left" class="bodytext32" style="border-bottom:solid 1px #000000;">&nbsp;</td>
			</tr>
    </table>
