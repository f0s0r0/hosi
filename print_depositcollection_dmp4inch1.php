<?php
require_once('html2pdf/html2pdf.class.php');
ob_start();
session_start();
error_reporting(0);
include ("includes/loginverify.php");
include ("db/db_connect.php");


$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

$patientcode = $_REQUEST['patientcode'];
$billnumbercode = $_REQUEST['billnumbercode'];
$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
?>
<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; 
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; 
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c;  text-decoration:none
}
.bodytext365 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3b3b3c;  text-decoration:none
}
.bodytext366 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #3b3b3c;  text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; 
}
.bodytext32 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000; 
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; 
}
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
.style2 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000; }
.bodytext33 {FONT-WEIGHT: normal; FONT-SIZE: 19px; COLOR: #000000;
}
.bodytext34 {FONT-WEIGHT: bold; FONT-SIZE: 16px; COLOR: #000000;
}
.bodytext35 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;
}
.bodytext36 {FONT-WEIGHT: bold; FONT-SIZE: 16px; COLOR: #000000;
}
.bodytext37 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;
}
.bodytext38 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;
}
.bodytext39 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;
}
.bodytext40 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;
}
.bodytext41 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;
}
.bodytext42 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;
}
.bodytext43 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;
}

</style>

<script language="javascript">
window.onload = function() {
    if(!window.location.hash) {
        window.location = window.location + '#';
        window.location.reload();
    }
}
</script>
<body onkeydown="escapeke11ypressed()">
<table border="0" cellspacing="0" align="center" cellpadding="0">

		<!--<tr>
			<td colspan="4" class="bodytext32">
              <?php
			$strlen3 = strlen($address1);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address1 = $address1.' ';
			}
			?></td>
		</tr>
		
		<tr>
			<td colspan="4" align="left" class="bodytext32">
            <?php
			$address2 = $area.''.$city.'  '.$pincode.'';
			$strlen3 = strlen($address2);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address2 = $address2.' ';
			}
			?>
			<strong><?php echo $address2; ?></strong></td>
		</tr> -->
		



        <tr>
          <td colspan="3" class="bodytext32"><table width="411" border="0" align="center" cellpadding="0" cellspacing="0">
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
$emailid1 = $res2["emailid1"];
$phonenumber1 = $res2["phonenumber1"];
$phonenumber2 = $res2["phonenumber2"];
$tinnumber1 = $res2["tinnumber"];
$cstnumber1 = $res2["cstnumber"];
?>
              <td align="center" class="bodytext36"><?php
			$strlen2 = strlen($companyname);
			$totalcharacterlength2 = 35;
			$totalblankspace2 = 35 - $strlen2;
			$splitblankspace2 = $totalblankspace2 / 2;
			for($i=1;$i<=$splitblankspace2;$i++)
			{
			$companyname = ' '.$companyname.' ';
			}
			?>
                  <strong><?php echo $companyname; ?></strong></td>
            </tr>
            <!--<tr>
			<td align="left" class="bodytext32">
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
			<strong><?php echo $address1; ?></strong></td>
		</tr>
		<tr>
		  <td align="left" class="bodytext32">
            <?php
			$address2 = $area.''.$city.'  '.$pincode.'';
			$strlen3 = strlen($address2);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address2 = ' '.$address2.' ';
			}
			?>
			<strong><?php echo $address2; ?></strong></td>
  </tr>-->
            <tr>
              <td width="186" align="center" class="bodytext36"><?php
			$address3 = "PHONE: ".$phonenumber1;
			$strlen3 = strlen($address3);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address3 = ' '.$address3.' ';
			}
			?>
                  <strong><?php echo $address3; ?></strong></td>
            </tr>
            <tr>
              <td align="center" class="bodytext36"><?php
			$address4 = " E-Mail: ".$emailid1;
			$strlen3 = strlen($address4);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address4 = ' '.$address4.' ';
			}
			?>
                  <strong><?php echo $address4; ?></strong></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="3" class="bodytext32">&nbsp;</td>
        </tr>
  
<?php include ('convert_currency_to_words.php'); ?>
<?php
/*	 $query1 = "select * from master_customer where locationcode='$locationcode' and customercode = '$patientcode'";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		
		$res1 = mysql_fetch_array($exec1);
		
		$patientname=$res1['customerfullname'];
		$patientcode=$res1['customercode'];
		$accountname = $res1['accountname'];
		$gender = $res1['gender'];
		$age = $res1['age'];
		
		
		$query67 = "select * from master_accountname where locationcode='$locationcode' and auto_number='$accountname'";
		$exec67 = mysql_query($query67); 
		$res67 = mysql_fetch_array($exec67);
		$accname = $res67['accountname'];*/
		
		$query1 = "select * from master_transactionipdeposit where locationcode='$locationcode' and patientcode = '$patientcode' and docno='$billnumbercode'";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		
		$transactionamount = 0.00;
		
		$res1 = mysql_fetch_array($exec1);
	     $patientname=$res1['patientname'];
		$patientcode=$res1['patientcode'];
		$accountname = $res1['accountname'];
		$transactionmode = $res1['transactionmode'];
	    $transactionamount = $res1['transactionamount'];
	    $transactiondate = $res1['transactiondate'];
		$transactiontime = $res1['transactiontime'];
	    $transactiondate = strtotime($transactiondate);
		$depusername = $res1['username'];
		$number=$res1['chequenumber'];
		
		
	  
	   $transactionamountinwords = covert_currency_to_words($transactionamount); 

		?>

<tr>
  <td colspan="3" align="center" class="bodytext32"><u><strong>IP Deposit</strong></u></td>
  </tr>
<tr>
  <td colspan="3"  class="bodytext32"><span class="bodytext33"><strong>Receipt No:</strong> <?php echo $billnumbercode; ?>                                    </span></td>
  </tr>
<tr>
  <td class="bodytext33" width="400" nowrap="nowrap"><strong>Date :</strong> <?php echo date('d/m/y',$transactiondate); ?></td>
  <td colspan="0"class="bodytext33" >&nbsp;</td>
  </tr>
<tr>
  <td colspan="3" class="bodytext32">&nbsp;</td>
  </tr>
<tr>
  <td class="bodytext33" colspan="3" nowrap="nowrap"><strong>Patient Name :</strong> <?php echo $patientname; ?></td>
  </tr>
<tr>
  <td class="bodytext33" colspan="3" nowrap="nowrap"><strong>Reg No :</strong> <?php  echo $patientcode; ?></td>
</tr>
<tr>
  <td class="bodytext33" colspan="1" nowrap="nowrap"><strong>Mode :</strong> <?php echo $transactionmode; ?>    <strong>Ref No.:</strong> <?php echo $number; ?></td>
 <?php if($number!='')
{
	?>
 <td width="74" colspan="1" align="left" nowrap="nowrap" class="bodytext33">&nbsp;</td>
  <?php 
}
?>
</tr>



<tr>

			<td class="bodytext33" ><strong>Deposit Amount:   &nbsp;<?php echo number_format($transactionamount,2,'.',','); ?></strong></td>
			<td nowrap="nowrap" class="bodytext40">&nbsp;</td>
            <td width="7" nowrap="nowrap" class="bodytext40">&nbsp;</td>
</tr>
		
		
		<tr>
		  <td class="bodytext32" colspan="3">&nbsp;</td>
  </tr>
		<tr>
		<<td class="bodytext33"><strong>Kenya Shillings </strong><?php echo str_replace('Kenya Shillings','',$transactionamountinwords); ?></td>
	</tr>
<?php
?>


<?php

?>

<tr>
  <td colspan="3" class="bodytext32">&nbsp;</td>
</tr>


<?php

		//$age = $res1['age'];
?>
	
<?php

?>
<?php
?>

<?php

?>

<?php

?>

<tr>
<td class="bodytext36" align="left" ><strong>Served By:<span class="bodytext33"><?php echo strtoupper($depusername); ?></span></strong></td>
<td class="bodytext33" align="left">&nbsp;</td>
<td class="bodytext42" align="left">&nbsp;</td>
</tr>
<tr>
  <td class="bodytext43" align="left" ><span class="bodytext33"><strong>Receipt Time :</strong> <?php echo $transactiontime; ?></span></td>
  <td class="bodytext33" align="right">&nbsp;</td>
  <td class="bodytext43" align="right">&nbsp;</td>
</tr>
</table>
<br>
<br>
</body>
<?php	
  $content = ob_get_clean();
    // convert in PDF
    try
    {	
		$width_in_inches = 4.39;
		$height_in_inches = 6.2;
		$width_in_mm = $width_in_inches * 25.4; 
		$height_in_mm = $height_in_inches * 25.4;
		$width_in_mm = 120.39; 
		$height_in_mm = 300.06;		
        $html2pdf = new HTML2PDF('P', array($width_in_mm,$height_in_mm), 'en', true, 'UTF-8', array(0, 0, 0,0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->setDefaultFont('Helvetica');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('print_consultationbill.pdf');
		
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
