<?php
session_start();
include ("db/db_connect.php");
//include('convert_currency_to_words.php');
include('convert_number.php');
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
 $companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$netamount=0.00;
//$username = $_SESSION["username"];  
//$docno = $_SESSION["docno"];
if (isset($_REQUEST["type"])) { $type = $_REQUEST["type"]; } else { $type = ""; }

ob_start();

 	$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
	if (isset($_REQUEST["billnumber"])) { $billnumber = $_REQUEST["billnumber"]; } else { $billnumber = ""; }

$query2 = "select * from master_company where auto_number = '$companyanum'";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$companyname = $res2["companyname"];
$address1 = $res2["address1"];
$address2 = $res2["address2"];
$area = $res2["area"];
$city = $res2["city"];
$pincode = $res2["pincode"];
$phonenumber1 = $res2["phonenumber1"];
$phonenumber2 = $res2["phonenumber2"];
$tinnumber1 = $res2["tinnumber"];
$cstnumber1 = $res2["cstnumber"];



	$query55 = "select * from manual_lpo where billnumber='$billnumber'";
	$exec55=mysql_query($query55) or die(mysql_error());
	$num55=mysql_num_rows($exec55);
	$res55=mysql_fetch_array($exec55);
	$billdate = $res55['entrydate'];
	$suppliername = $res55['suppliername'];
	$suppliercode = $res55['suppliercode'];
	
	$query14 = "select * from master_accountname where  id='$suppliercode'";
	$exec14 = mysql_query($query14) or die ("Error in Query14".mysql_error());
	$res14 = mysql_fetch_array($exec14);
	$res14accountname = $res14['accountname'];
	$res14address = $res14['address'];
	
	
?>
<style>
.bodytext32 {FONT-WEIGHT: bold; FONT-SIZE: 14px; COLOR: #000000; 
}
.rap
{
	text-wrap:suppress;
	
	}
</style>
    <?php //include("print_header.php");?>

<table width="530" border="0" cellpadding="0" cellspacing="0" align="center">  
	<tr>
<?php 
$query2 = "select * from master_company where auto_number = '$companyanum'";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$companyname = $res2["companyname"];
$address1 = $res2["address1"];
$address2 = $res2["address2"];
$area = $res2["area"];
$city = $res2["city"];
$pincode = $res2["pincode"];
$phonenumber1 = $res2["phonenumber1"];
$phonenumber2 = $res2["phonenumber2"];
$tinnumber1 = $res2["tinnumber"];
$cstnumber1 = $res2["cstnumber"];
?>

    <td width="100" rowspan="4" align="left" valign="center" 
	 bgcolor="#ffffff" class="bodytext31">
	
	<?php
			$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
			$exec3showlogo = mysql_query($query3showlogo) or die ("Error in Query3showlogo".mysql_error());
			$res3showlogo = mysql_fetch_array($exec3showlogo);
			$showlogo = $res3showlogo['showlogo'];
			if ($showlogo == 'SHOW LOGO')
			{
			?>
				
			<img src="logofiles/<?php echo $companyanum;?>.jpg" width="100" height="100" />
			
			<?php
			}
			?>	</td>
			
 
			<td colspan="2" class="bodytext32"><div align="left"><?php echo $companyname; ?>
		      <?php
			$strlen3 = strlen($address1);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address1 = ' '.$address1.' ';
			}
			?>			
		    </div></td>
	  <td width="172" colspan="2" class="bodytext32"><div align="left" style="font-size:18px;">&nbsp;</div></td>
  </tr>
		<tr>
			<td colspan="2" class="bodytext32"><div align="left"><?php echo $address1; ?>
		      <?php
			$address2 = $area.''.$city.' '.$pincode.'';
			$strlen3 = strlen($address2);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address2 = ' '.$address2.' ';    
			}
			?>			
		    </div></td>
			<td colspan="2" class="bodytext32"><div align="left">&nbsp;</div></td>
		</tr>
		<tr>
			<td colspan="2" class="bodytext32">
			
			  <div align="left"><?php echo $address2; ?>
		        <?php
			$address3 = "PHONE: ".$phonenumber1.' '.$phonenumber2;
			$strlen3 = strlen($address3);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address3 = ' '.$address3.' ';
			}
			?>			
	        </div></td>
			<td colspan="2" class="bodytext32"><div align="left">&nbsp;</div></td>
		</tr>

<tr>
<td colspan="4" style="">&nbsp;</td>
</tr>
<tr>
<td colspan="5" style="border-bottom:solid 1px #000000;">&nbsp;</td>
</tr>
</table>

<table width="530" border="0" cellpadding="0" cellspacing="2" align="center"> 
        
  <tr><td colspan="5" align="center" class="bodyhead"><strong>PURCHASE ORDER</strong></td></tr>
  <tr>
<td colspan="5">&nbsp; </td>
</tr>
	<tr>
   	  <td class="bodytextbold"><strong>Supplier:</strong></td>
      <td><?php echo $suppliername;?></td>
        <td>&nbsp;</td>
     
    </tr>
    <tr>
   	  <td class="bodytextbold"><strong>Tel No:</strong></td>
        <td><?php //echo $res14contact;?></td>
        <td>&nbsp;</td>
      <td class="bodytextbold"><strong>LPO No:</strong></td>
      <td><?php echo $billnumber; ?></td>
    </tr>
    <tr>
   	  <td class="bodytextbold"><strong>Fax No:</strong></td>
        <td><?php //echo $suppliername;?></td>
        <td>&nbsp;</td>
      <td class="bodytextbold"><strong>Date:</strong></td>
      <td><?php echo date("d/m/Y", strtotime($billdate)); ?></td>
    </tr>
    <tr>
   	  <td class="bodytextbold"><strong>E Mail:</strong></td>
        <td><?php //echo $suppliername;?></td>
        <td>&nbsp;</td>
      <td class="bodytextbold"><strong>Time:</strong></td>
      <td><?php echo date("g.i A", strtotime($updatedatetime));?></td>
    </tr>
    <tr>
<td colspan="5">&nbsp; </td>
</tr> 
</table>
<table align="ledt"  width="530" cellspacing="0" style="border:1px #000000;">
	<tr>
    	<td class="bodytextbold" style="border:solid 1px #000000; background:#FFFFFF; border-right:none;" align="center">ITEM DESCRIPTION</td>
        <td class="bodytextbold" style="border:solid 1px #000000; background:#FFFFFF; border-right:none;" align="center">QUANTITY</td>
        <td class="bodytextbold" style="border:solid 1px #000000; background:#FFFFFF; border-right:none;" align="center">RATE</td>
      <td class="bodytextbold" style="border:solid 1px #000000; background:#FFFFFF; border-right:solid 1px #000000;" align="center">TOTAL</td>
    </tr>
<?php
	$sno = '';
	$totalqty = 0;
	$amt1=0;
	$query34="select * from manual_lpo where billnumber='$billnumber'";
	$exec34=mysql_query($query34) or die(mysql_error());
	$num34 = mysql_num_rows($exec34);
	while($res34=mysql_fetch_array($exec34))
	{
		$totalquantity =0;
		$amount = 0;
		$itemname=$res34['itemname'];
		$username=$res34['username'];
		$quantity=$res34['itemtotalquantity'];
		$rate=$res34['rate'];
		$amount=$res34['totalamount'];
		$project=$res34['project'];
		$budgetline=$res34['budgetline'];
		$budgetcode=$res34['budgetcode'];
		$warrenty=$res34['warrenty'];
		 $deliveryortransport=$res34['deliveryortransport'];
		$termsofpayment=$res34['termsofpayment'];
		$address=$res34['address'];
		$authorisedby=$res34['authorisedby'];
	
		$quotationnum=$res34['quotationnum'];
		$lpovalidity=$res34['lpovalidity'];
		$expenditure=$res34['expenditure'];
		$vatpercent=$res34['vatpercent'];

		$amt=$rate*$quantity;		
		if($res34['free']!=''){$free = 'BONUS';}else{$free = '';}
		$totalqty=$totalqty+$quantity;
		$netamount = $netamount + $amount;
		$totalamt12 = $res34['subtotal'];
		
		$query334="select * from master_employee where username='$username'";
	$exec334=mysql_query($query334) or die(mysql_error());
	$res334=mysql_fetch_array($exec334);
	$username1=$res334['employeename'];


?>

	<tr>
    	<td class="bodytext" style="border:solid 1px #000000; background:#FFFFFF; border-right:none;" align=""><?php echo $itemname;?></td>
        <td class="bodytext" style="border:solid 1px #000000; background:#FFFFFF; border-right:none;" align="right"><?php echo number_format("$quantity",2,'.',',');?></td>
        <td class="bodytext" style="border:solid 1px #000000; background:#FFFFFF; border-right:none;" align="right"><?php echo $rate;?></td>
        <td class="bodytext" style="border:solid 1px #000000; background:#FFFFFF; border-right:solid 1px #000000;" align="right"><?php echo number_format("$amt", 2, '.', ',');?></td>
    </tr>
    <?php 
	$amt1=$amt+$amt1;
	}
	 ?>
   
    

    <tr>
<td colspan="4">&nbsp;</td>
</tr>

</table>
<table align="ledt"  width="530" cellspacing="0" >
 <tr>
    	<td width="25" align="" class="bodytext" style=" background:#FFFFFF; border-right:none;"></td>
        <td width="40" align="right" class="bodytext" style=" background:#FFFFFF; border-right:none;"></td>
        <td width="376" align="right"  class="bodytext" style=" background:#FFFFFF; border-right:none;" >Total</td>
        <td width="79" align="right" class="bodytext" style=" background:#FFFFFF; border-right:none;"><?php echo number_format("$amt1", 2, '.', ',');?></td>
    </tr>

</table>

<table width="530" border="0" align="center"> 
<tr>
<td >&nbsp;</td>
</tr>


 <tr>
            <td align="left" valign="center"  width="184" height="20">PROJECT:</td>
                 <td width="330"  > <?php echo $project;?></td>
           </tr>
             <tr>
             <td align="left" valign="center" class="bodytext31" width="184" height="20">BUDGET LINE:</td>
               <td width="330" > <?php echo $budgetline;?></td>
               </tr>
               <tr><td align="left" valign="center" class="bodytext31"  width="184" height="20">BUDGET CODE:</td>
               <td width="330" > <?php echo $budgetcode;?></td>
               </tr>
               <tr>
               <td align="left" valign="center" class="bodytext31" width="184" height="20">WARRENTY:</td>
               <td width="330" > <?php echo $warrenty;?></td>
               </tr>
               <tr>
               <td align="left" valign="center" class="bodytext31" width="184" height="20">DELIVERY/TRANSPORT:</td> 
               <td width="330" > <?php echo $deliveryortransport;?></td>
               </tr>
               <tr>
               <td align="left" valign="center" class="bodytext31"  width="184" height="20">TERMS OF PAYMENT:</td>
               <td width="330"> <?php echo $termsofpayment;?></td>
               </tr>
               <tr>
                <td width="184"  align="left" valign="center" class="bodytext31" height="20">QUOTATION NUMBER/DATE:</td>
               <td width="330"> <?php echo $quotationnum;?></td>
               </tr>
               <tr>
                <td width="184"  align="left" valign="center" class="bodytext31" height="20">LPO VALIDITY:</td>
               <td width="330"> <?php echo $lpovalidity;?></td>
               </tr>
               <tr>
                <td width="184"  align="left" valign="center" class="bodytext31" height="20">REASON FOR EXPENDITURE:</td>
               <td width="330"> <?php echo $expenditure;?></td>
               </tr>
               <tr>
                <td width="184"  align="left" valign="center" class="bodytext31" height="20">VAT @16%:</td>
               <td width="330"> <?php echo $vatpercent;?></td>
               </tr>
               <tr>
                <td width="184"  align="left" valign="center" class="bodytext31" height="20">ADDRESS:</td>
               <td width="330"> <?php echo $address;?></td>
               </tr>
               <tr>
<td >&nbsp;</td>
</tr>
               <tr>
<td colspan="5" ><strong><?php  

$convertedwords = convertNumber($amt1);
//$convertedwords = covert_currency_to_words($amt1);  ?>
<?php echo $convertedwords;?></strong></td>
</tr>
<tr>
<td >&nbsp;</td>
</tr>
              
	<tr>
    	<td class="bodytextbold" width="184" align="left"><strong>Prepared By</strong></td>
        <td class="bodytextbold" align="right" colspan=""><strong>Authorized by</strong></td>
    </tr>
	<tr>
    	<td class="bodytext" width="184" align="left"><?php echo $username1;?></td>
        <td class="bodytext" width="330" align="right"><?php echo $authorisedby;?></td>
    </tr>
  
<tr>
<td colspan="3">&nbsp;</td>
</tr>

</table>
<!--------------------------------------unwanted-------------------------------------------->

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