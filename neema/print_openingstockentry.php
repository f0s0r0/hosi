<?php
require_once('html2pdf/html2pdf.class.php');
ob_start();
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$sno = 0;
$totalrate = 0.00;
$colorloopcount = '';

if (isset($_REQUEST["docnumber"])) { $docnumber = $_REQUEST["docnumber"]; } else { $docnumber = ""; }
if (isset($_REQUEST["ADate1"])) { $fromdate = $_REQUEST["ADate1"]; } else { $fromdate = ""; }
if (isset($_REQUEST["ADate2"])) { $todate = $_REQUEST["ADate2"]; } else { $todate = ""; }
if (isset($_REQUEST["store"])) { $store1 = $_REQUEST["store"]; } else { $store = ""; }
if (isset($_REQUEST["location"])) { $location1 = $_REQUEST["location"]; } else { $location1 = ""; }
?>

	  <table cellspacing="0" cellpadding="4" width="746" 
            align="left" border="0">
			 <tr>
             <td colspan="6">&nbsp;</td>
           </tr>
           <tr>
             <td colspan="6">&nbsp;</td>
           </tr>
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
			<td colspan="6">
			  <div align="center">
			    <?php
			$strlen2 = strlen($companyname);
			$totalcharacterlength2 = 35;
			$totalblankspace2 = 35 - $strlen2;
			$splitblankspace2 = $totalblankspace2 / 2;
			for($i=1;$i<=$splitblankspace2;$i++)
			{
			$companyname = ' '.$companyname.' ';
			}
			?>			
	        </div></td>
  </tr>
		<tr>
			<td colspan="6"><div align="center"><?php echo $companyname; ?>
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
		</tr>
		<tr>
			<td colspan="6"><div align="center"><?php echo $address1; ?>
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
		</tr>
		<tr>
			<td colspan="6">
			
			  <div align="center"><?php echo $address2; ?>
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
		</tr>
             <tr>
               <td colspan="6"  align="left" valign="middle">&nbsp;</td>
             </tr>
             <tr>
			 <td colspan="6"  align="left" valign="middle"><strong>Opening Stock Entry: <?php echo $docnumber.'/'.$store1.'/'.$location1; ?></strong></td>
			 </tr>
			  <tr>
			    <td  valign="center"  align="left" 
					bgcolor="#ffffff">&nbsp;</td>
			    <td  align="left" valign="center" 
					bgcolor="#ffffff" class="style2">&nbsp;</td>
			    <td  align="right" valign="center" 
					bgcolor="#ffffff" class="style2">&nbsp;</td>
			    <td  align="right" valign="center" 
					bgcolor="#ffffff" class="style2">&nbsp;</td>
			    <td  align="right" valign="center" 
					bgcolor="#ffffff" >&nbsp;</td>
	    </tr>
			  <tr>
			    <td width="46"  valign="center"  align="left" 
					bgcolor="#ffffff"><strong>S.No.</strong></td>
				  				  <td width="272"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><strong>Item</strong></td>
				  				  <td width="98"  align="right" valign="center" 
					bgcolor="#ffffff" class="style2"><strong>Cost Price </strong></td>
				  				  <td width="147"  align="right" valign="center" 
					bgcolor="#ffffff" class="style2"><strong>Qty</strong></td>
				  				  <td width="143"  align="right" valign="center" 
					bgcolor="#ffffff" ><strong>Expiry Date </strong></td>
		    </tr>					
           <?php
		$query1 = "select * from openingstock_entry where recordstatus <> 'deleted' and billnumber='$docnumber' and transactiondate between '$fromdate' and '$todate' ";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		
		while($res1 = mysql_fetch_array($exec1))
		{
		$res1billnumber =$res1['billnumber'];
		$res1itemname =$res1['itemname'];
		$res1transactiondate =$res1['transactiondate'];
		$res1expirydate =$res1['expirydate'];
		$res1quantity =$res1['quantity'];
		$res1totalrate =$res1['totalrate'];
		$res1rateperunit = $res1['rateperunit'];
	    $res1username =$res1['username'];
		$res1itemname = htmlspecialchars(stripslashes($res1itemname));
	    $totalrate =$totalrate + $res1totalrate;
		
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
		 	  <td align="left" valign="center" ><?php echo $sno= $sno + 1; ?></td>
	        	<td align="left" valign="center" ><?php echo $res1itemname; ?></td>
				<td align="right" valign="center" ><?php echo number_format($res1rateperunit,2,'.',','); ?></td>
				<td align="right" valign="center" ><?php echo intval($res1quantity); ?></td>
				<td  align="right" valign="center" ><?php echo $res1expirydate; ?></td>
			</tr>	
	      <?php } ?>		
		
			 <tr>
			   <td  valign="center" bordercolor="#f3f3f3" align="left">&nbsp;</td>
			   <td align="right" valign="center" bordercolor="#f3f3f3" >&nbsp;</td>
			   <td align="right" valign="center" bordercolor="#f3f3f3" >&nbsp;</td>
			   <td align="left" valign="center" bordercolor="#f3f3f3" >&nbsp;</td>
			   <td align="left" valign="center" bordercolor="#f3f3f3" >&nbsp;</td>
	    </tr>
			 <tr>
				<td  valign="center" bordercolor="#f3f3f3" align="left">&nbsp;</td>
				<td align="right" valign="center" bordercolor="#f3f3f3" ><strong>Total</strong></td>
				<td align="right" valign="center" bordercolor="#f3f3f3" ><?php echo number_format($totalrate,2,'.',','); ?></td>
				<td align="left" valign="center" bordercolor="#f3f3f3" >&nbsp;</td>
				<td align="left" valign="center" bordercolor="#f3f3f3" >&nbsp;</td>
			</tr>		
</table>
<?php

    $content = ob_get_clean();

    // convert in PDF
    require_once('html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
//      $html2pdf->setModeDebug();
        //$html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('viewopeningstockentry.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>


