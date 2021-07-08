<?php
require_once('html2pdf/html2pdf.class.php');
ob_start();
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");


$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

$patientcode = $_REQUEST['patientcode'];   
$billnumbercode = $_REQUEST['billnumbercode'];

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
.bodytext33 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;
}
.bodytext34 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;
}
.bodytext35 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;
}
.bodytext36 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;
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
<table width="285" border="0" cellspacing="0" cellpadding="0">

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
          <td colspan="5" class="bodytext32"><table border="0" align="left" cellpadding="0" cellspacing="0">
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
              <td width="58" rowspan="4"><?php
			$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
			$exec3showlogo = mysql_query($query3showlogo) or die ("Error in Query3showlogo".mysql_error());
			$res3showlogo = mysql_fetch_array($exec3showlogo);
			$showlogo = $res3showlogo['showlogo'];
			if ($showlogo == 'SHOW LOGO')
			{
			?>
                  <!--<img src="logofiles/<?php echo $companyanum;?>.jpg" width="75" height="60" />-->
                  <?php
			}
			?></td>
              <td colspan="2" align="left" class="bodytext33"><?php
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
              <td width="223" align="center" class="bodytext34"><?php
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
              <td width="4" align="left" class="bodytext32">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2" align="left" class="bodytext35"><?php
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
          <td colspan="5" class="bodytext32">&nbsp;</td>
        </tr>
  
<?php include ('convert_currency_to_words.php'); ?>
<?php
/*	$query1 = "select * from master_mortuaryexternaldeposit where docno='$billnumbercode'";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		
		$res1 = mysql_fetch_array($exec1);
		
		$patientname=$res1['patientname'];
		$patientcode=$res1['customercode'];
		$accountname = $res1['accountname'];
		$gender = $res1['gender'];
		$age = $res1['age'];
		
		
		$query67 = "select * from master_accountname where auto_number='$accountname'";
		$exec67 = mysql_query($query67); 
		$res67 = mysql_fetch_array($exec67);
		$accname = $res67['accountname'];
*/		
		$query1 = "select * from master_mortuaryexternaldeposit where docno='$billnumbercode'";
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
	  
	   $transactionamountinwords = covert_currency_to_words($transactionamount); 

		?>

<tr>
  <td colspan="5" class="bodytext32">&nbsp;</td>
  </tr>
<tr>
  <td width="93" class="bodytext36">Receipt No:</td>
  <td class="bodytext36" width="70" nowrap="nowrap"><?php echo $billnumbercode; ?></td>
  <td class="bodytext36" width="45" nowrap="nowrap">Date:</td>
  <td colspan="2" nowrap="nowrap" class="bodytext36" ><?php echo date('d/m/y',$transactiondate); ?></td>
  </tr>
<tr>
  <td colspan="5" class="bodytext32">&nbsp;</td>
  </tr>
<tr>
  <td class="bodytext37">Patient : </td>
  <td class="bodytext37" colspan="4" nowrap="nowrap"><?php echo $patientname; ?></td>
  </tr>
<tr>
  <td class="bodytext38" >Reg No: </td>
  <td class="bodytext38" colspan="4" nowrap="nowrap"><?php  echo $patientcode; ?></td>
</tr>
<tr>
  <td class="bodytext39" >Mode :</td>
  <td class="bodytext39" colspan="4" nowrap="nowrap"><?php echo $transactionmode; ?></td>
</tr>
<tr>
			<td colspan="2" class="bodytext40" >Deposit Amount: <strong><?php echo number_format($transactionamount,2,'.',','); ?></strong></td>
			<td class="bodytext40" nowrap="nowrap">&nbsp;</td>
            <td width="28" nowrap="nowrap" class="bodytext40">&nbsp;</td>
            <td width="49" nowrap="nowrap" class="bodytext40">&nbsp;</td>
</tr>
		
		
		<tr>
		  <td class="bodytext32" colspan="5">&nbsp;</td>
  </tr>
		<tr>
		<td class="bodytext41" colspan="5"><?php echo $transactionamountinwords; ?></td>
	</tr>
<?php
?>


<?php

?>

<tr>
  <td colspan="5" class="bodytext32">&nbsp;</td>
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
<td class="bodytext42" align="right">&nbsp;</td>
<td class="bodytext42" colspan="2" align="right" ><strong>Served By:</strong></td>
<td class="bodytext42" align="right"><strong><?php echo strtoupper($depusername); ?></strong></td>
<td class="bodytext42" align="right">&nbsp;</td>
</tr>
<tr>
  <td class="bodytext43" align="right">&nbsp;</td>
  <td class="bodytext43" colspan="2" align="right" >&nbsp;</td>
  <td class="bodytext43" align="right"><strong><?php echo $transactiontime; ?></strong></td>
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
        $html2pdf = new HTML2PDF('P', 'A5', 'en');
//      $html2pdf->setModeDebug();
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		
        $html2pdf->Output('print_depositcollection.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
	?>