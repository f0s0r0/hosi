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
	include("print_header.php");
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
			$sumtotalquantity = 0;
			
		$query34="select * from purchaseorder_details where billnumber='$billnumber' and recordstatus='generated' and itemstatus != 'deleted' group by itemname";
		$exec34=mysql_query($query34) or die(mysql_error());
		$num34 = mysql_num_rows($exec34);
		while($res34=mysql_fetch_array($exec34))
			{
			$totalquantity =0;
			
			$amount = 0;
			$itemname=$res34['itemname'];
			$itemcode=$res34['itemcode'];
			$res34username=$res34['username'];
			$indentdocno = $res34['purchaseindentdocno'];

			$query880 = mysql_fetch_array(mysql_query("select employeename from master_employee where username = '$res34username' and username <> ''"));
			$res34username1 = $query880['employeename'];

			$query810 = mysql_fetch_array(mysql_query("select bausername,project,budgetline,budgetcode,warrenty,deliveryortransport,payment,address,authorisedby,quotationnum,lpovalidity,expenditure,vatpercent from purchase_indent where docno = '$indentdocno' order by project desc"));
			$resbausername1 = $query810['bausername'];
			$project=$query810['project'];
			$budgetline=$query810['budgetline'];
			$budgetcode=$query810['budgetcode'];
			$warrenty=$query810['warrenty'];
			$deliveryortransport=$query810['deliveryortransport'];
			$payment=$query810['payment'];
			$address=$query810['address'];
			$authorisedby=$query810['authorisedby'];
			$quotationnum=$query810['quotationnum'];
			$lpovalidity=$query810['lpovalidity'];
			$expenditure=$query810['expenditure'];
			$vatpercent=$query810['vatpercent'];

			$query8801 = mysql_fetch_array(mysql_query("select employeename from master_employee where username = '$resbausername1' and username <> ''"));
			$resbausername = $query8801['employeename'];
			
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
            <table width="530" align="center" border="0" cellpadding="5" cellspacing="">
			<tr>
			<td class="bodytextbold" valign="center" width="150"  align="right" >Total No of Items :</td>
			<td class="bodytext" valign="center" width="30"  align="right" ><?php echo number_format($sumtotalquantity,2,'.',','); ?></td>
			<td class="bodytextbold" valign="center" width="85"   align="right"><strong>Net Amount:</strong></td>
			  <td class="bodytext" valign="center" width="63"  align="right"><?php echo number_format($netamount,2,'.',','); ?></td>
			  <td class="bodytext" valign="center"  align="right">&nbsp;</td>
			</tr> 
			<tr>
			<td colspan="3" class="bodytextbold" valign="center"  align="right" ><strong>Grand Total:</strong></td>
			<td class="bodytext" valign="center"  align="right"><?php echo number_format($netamount,2,'.',','); ?></td>
			<td class="bodytext" valign="center"  align="right">&nbsp;</td>
			</tr> 
			<tr>
            <td align="left" valign="center"  width="184" height="20">PROJECT:</td>
                 <td colspan="4"> <?php echo $project;?></td>
           </tr>
             <tr>
             <td align="left" valign="center" class="bodytext31" width="184" height="20">BUDGET LINE:</td>
               <td colspan="4"> <?php echo $budgetline;?></td>
               </tr>
               <tr><td align="left" valign="center" class="bodytext31"  width="184" height="20">BUDGET CODE:</td>
               <td colspan="4"> <?php echo $budgetcode;?></td>
               </tr>
               <tr>
               <td align="left" valign="center" class="bodytext31" width="184" height="20">WARRENTY:</td>
               <td colspan="4"> <?php echo $warrenty;?></td>
               </tr>
               <tr>
               <td align="left" valign="center" class="bodytext31" width="184" height="20">DELIVERY/TRANSPORT:</td> 
               <td colspan="4"> <?php echo $deliveryortransport;?></td>
               </tr>
               <tr>
               <td align="left" valign="center" class="bodytext31"  width="184" height="20">TERMS OF PAYMENT:</td>
               <td colspan="4"> <?php echo $payment;?></td>
               </tr>
               <tr>
                <td width="184"  align="left" valign="center" class="bodytext31" height="20">QUOTATION NUMBER/DATE:</td>
               <td colspan="4"> <?php echo $quotationnum;?></td>
               </tr>
               <tr>
                <td width="184"  align="left" valign="center" class="bodytext31" height="20">LPO VALIDITY:</td>
               <td colspan="4"> <?php echo $lpovalidity;?></td>
               </tr>
               <tr>
                <td width="184"  align="left" valign="center" class="bodytext31" height="20">REASON FOR EXPENDITURE:</td>
               <td colspan="4"> <?php echo $expenditure;?></td>
               </tr>
               <tr>
                <td width="184"  align="left" valign="center" class="bodytext31" height="20">VAT @16%:</td>
               <td colspan="4"> <?php echo $vatpercent;?></td>
               </tr>
               <tr>
                <td width="184"  align="left" valign="center" class="bodytext31" height="20">ADDRESS:</td>
               <td colspan="4"> <?php echo $address;?></td>
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
			<td colspan="3" align="right" class="bodytext32">---------------------------------------------------------------</td>
			</tr>
			<tr>
			<td colspan="2" align="left" class="bodytext32"><strong>Prepared By:</strong> <?php echo $res34username1; ?></td>
			
			<td colspan="3" align="left" class="bodytext32"><strong>Authorized By:</strong> <?php echo $authorisedby; ?></td>
			</tr>
			<tr>
			<td colspan="2" align="left" class="bodytextbold">Date</td>
          
			<td colspan="3" align="left" class="bodytextbold">Date</td>
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
<!-----------------------------------unwanted---------------------------------->


<?php	
require_once("dompdf/dompdf_config.inc.php");
$html =ob_get_clean();
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper("A4");
$dompdf->render();
$canvas = $dompdf->get_canvas();
//$canvas->line(10,800,800,800,array(0,0,0),1);
$font = Font_Metrics::get_font("times-roman", "normal");
$canvas->page_text(272, 814, "Page {PAGE_NUM}/{PAGE_COUNT}", $font, 10, array(0,0,0));
$dompdf->stream("LPO.pdf", array("Attachment" => 0)); 
?>