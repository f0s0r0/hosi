<?php
session_start();
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$netamount=0.00;
$username = $_SESSION["username"];
$docno = $_SESSION["docno"];

ob_start();

 	$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
	if (isset($_REQUEST["billnumber"])) { $billnumber = $_REQUEST["billnumber"]; } else { $billnumber = ""; }

//header location
	$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname ";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	$res1 = mysql_fetch_array($exec1);
	
 	$locationname = $res1["locationname"];
	$locationcode = $res1["locationcode"];
	$query3 = "select * from master_location where locationcode = '$locationcode'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	$res3 = mysql_fetch_array($exec3);
	//$companyname = $res2["companyname"];
	$address1 = $res3["address1"];
	$address2 = $res3["address2"];
	//$area = $res2["area"];
	//$city = $res2["city"];
	//$pincode = $res2["pincode"];
	$emailid1 = $res3["email"];
	$phonenumber1 = $res3["phone"];
	$locationcode = $res3["locationcode"];
	//$phonenumber2 = $res2["phonenumber2"];
	//$tinnumber1 = $res2["tinnumber"];
	//$cstnumber1 = $res2["cstnumber"];
	$locationname =  $res3["locationname"];
	$prefix = $res3["prefix"];
	$suffix = $res3["suffix"];
	

	$query55 = "select * from capitation_po where billnumber='$billnumber'";
	$exec55=mysql_query($query55) or die(mysql_error());
	$num55=mysql_num_rows($exec55);
	$res55=mysql_fetch_array($exec55);
	$billdate = $res55['entrydate'];
	$suppliername = $res55['suppliername'];
	$suppliercode = $res55['suppliercode'];
	
	$query14 = "select * from master_accountname where locationcode='$locationcode' and id='$suppliercode'";
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
.border{border-top: 1px #000000; border-bottom:1px #000000;}
td{{height: 50px;padding: 5px;}
table{table-layout:fixed;
width:100%;
display:table;
border-collapse:collapse;}
body{font-family:Arial, Helvetica, sans-serif;}
</style>
    <?php include("print_header.php");?>
<table align="center">
  <tr>
    <td colspan="6" style="text-transform:uppercase" class="bodyhead">Invoice</td></tr>
	<tr>
   	  <td class="bodytextbold">Supplier:</td>
      <td width="300px"><?php echo $suppliername;?></td>
        <td colspan="2">&nbsp;</td>
      <td class="bodytextbold">Location:</td>
      <td><?php echo $locationname;?></td>
    </tr>
    <tr>
   	  <td class="bodytextbold">Tel No:</td>
        <td><?php echo $res14contact;?></td>
        <td colspan="2">&nbsp;</td>
      <td class="bodytextbold">Invoice No:</td>
      <td><?php echo $billnumber; ?></td>
    </tr>
    <tr>
   	  <td class="bodytextbold">Fax No:</td>
        <td><?php //echo $suppliername;?></td>
        <td colspan="2">&nbsp;</td>
      <td class="bodytextbold">Date:</td>
      <td><?php echo date("d/m/Y", strtotime($billdate)); ?></td>
    </tr>
    <tr>
   	  <td class="bodytextbold">E Mail:</td>
        <td colspan="2"><?php //echo $suppliername;?></td>
        <td>&nbsp;</td>
      <td class="bodytextbold">Time:</td>
      <td><?php echo date("g.i A", strtotime($updatedatetime));?></td>
    </tr>
    
</table>
<table align="center" border="1px #000000" class="adjust">
	<tr>
    	<td class="bodytextbold" align="center"> DESCRIPTION</td>
        <td class="bodytextbold" align="center">QTY</td>
        <td class="bodytextbold" align="center">PRICE</td>
        <td class="bodytextbold" align="center">AMOUNT</td>
        <td class="bodytextbold" align="center">REMARKS</td>
    </tr>
<?php
	$sno = '';
	$totalqty = 0;
	$query34="select * from capitation_po where billnumber='$billnumber'";
	$exec34=mysql_query($query34) or die(mysql_error());
	$num34 = mysql_num_rows($exec34);
	while($res34=mysql_fetch_array($exec34))
	{
		$totalquantity =0;
		$amount = 0;
		$itemname=$res34['itemname'];
		$quantity=$res34['itemtotalquantity'];
		$rate=$res34['rate'];
		$remarks=$res34['remarks'];
		$amount=$res34['totalamount'];
		if($res34['free']!=''){$free = 'BONUS';}else{$free = '';}
		$totalqty=$totalqty+$quantity;
		$netamount = $netamount + $amount;
		$totalamt12 = $res34['subtotal'];
?>
	<tr>
    	<td class="bodytext" align=""><?php echo $itemname;?></td>
        <td class="bodytext" align="right"><?php echo number_format($quantity,2);?></td>
        <td class="bodytext" align="right"><?php echo $rate;?></td>
        <td class="bodytext" align="right"><?php echo number_format($amount,2);?></td>
        <td class="bodytext" align=""><?php echo $remarks;?></td>
    </tr>
<?php
	}
	
?>
	
</table>
<table align="center" class="foot">
<?php for($i=0;$i<=14-$num34;$i++){?>
	<tr>
    	<td colspan="2">&nbsp;</td>
    </tr>
<?php }?>
	<tr>
    	<td class="bodytextbold" align="left">Prepared By</td>
        <td class="bodytextbold" align="right">Authorized by</td>
    </tr>
	<tr>
    	<td class="bodytext" align="left"><?php echo $username;?></td>
        <td class="bodytext" align="right">&nbsp;</td>
    </tr>
    <tr>
    	<td class="bodytext" align="center" colspan="2">This purchase order is valid for 24 hours</td>
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
$font = Font_Metrics::get_font("Helvetica", "normal");
$canvas->page_text(272, 814, "Page {PAGE_NUM}/{PAGE_COUNT}", $font, 10, array(0,0,0));
$dompdf->stream("LPO.pdf", array("Attachment" => 0)); 
?>