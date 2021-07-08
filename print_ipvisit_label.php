<?php
session_start();
include ("db/db_connect.php");
require_once('html2pdf/html2pdf.class.php');

ob_start();
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

?> 

<style type="text/css">
<!--
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 12px; COLOR: #000000; FONT-FAMILY: Tahoma
}
.number
{
padding-left:690px;
text-align:right;
font-weight:bold;
}
-->

table.data
{
    height: 201.312;
    width: 325.344;
	position: relative;
	white-space: nowrap
    top: 20;
    left: 0;
  
}
.data {font-size:12px; }
#pcode{font-size:16px; }

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
<?php 	
if (isset($_REQUEST["patientcode"])) {$patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }

$query1 = "select * from master_company where auto_number = '$companyanum'";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	$res1 = mysql_fetch_array($exec1);
	
	$companycode = $res1["companycode"];
	$phonenumber1 = $res1["phonenumber1"];
    $companyname1 = $res1["companyname"];
	
$query2 = "select * from master_customer where customercode ='$patientcode' ";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	$res2 = mysql_fetch_array($exec2);
	
	$res2patientname = $res2["customerfullname"];
	$res2gender = $res2["gender"];
	$res2age = $res2["age"];
	$res2dateofbirth = $res2["dateofbirth"];
	$res2dateofbirth = strtotime($res2dateofbirth);
	$res2mobilenumber = $res2["mobilenumber"];

$query3 = "select * from master_ipvisitentry where patientcode ='$patientcode' order by auto_number desc limit 0, 1";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	$res3 = mysql_fetch_array($exec3);
    $res3visitcode = $res3["visitcode"];
	$res3accountfullname = $res3["accountfullname"];
	$res3consultationdate= $res3["consultationdate"];
	$res3consultationdate = strtotime($res3consultationdate);
    $res3consultationtime= $res3["consultationtime"];
	$res3username= $res3["username"];
	
	?>

<table border="0" cellpadding="2" cellspacing="0" class = "data">
  <tr>
    <td colspan="4" align="center" valign="center" 
                bgcolor="#ffffff" style="border-bottom: solid 1px black;" class="bodytext31" nowrap="nowrap"><strong><?php echo $companyname1." - "."Tel No: "; ?><?php echo $phonenumber1; ?></strong></td>
  </tr>
  
  <tr>
  	   <td width="102" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31" >		
				<strong><?php echo $patientcode; ?></strong>   </td>
   <td colspan="2" align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31" >		
				<strong>IP No. <?php echo $res3visitcode; ?></strong></td>
  </tr>
  <tr>
    <td colspan="4" align="center" valign="center" 
                bgcolor="#ffffff" style="border-bottom: solid 0px black;" class="bodytext31" nowrap="nowrap">&nbsp;</td>
  </tr>
  <tr>
  <td   align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31" nowrap="nowrap">		
				<strong><?php echo $res2patientname; ?></strong>   </td>
  <td align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31" >&nbsp;</td>
   <td  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31" ><strong><?php echo strtoupper($res2gender); ?>&nbsp;&nbsp;&nbsp;<?php echo $res2age; ?></strong></td>
  </tr>
  <tr>
    <td colspan="4" align="center" valign="center" 
                bgcolor="#ffffff" style="border-bottom: solid 0px black;" class="bodytext31" nowrap="nowrap">&nbsp;</td>
  </tr>
  <tr>
  <td  colspan="3" align="left" valign="center" width="77" 
                bgcolor="#ffffff" class="bodytext31" >		
				<strong><?php echo $res3accountfullname; ?></strong>   </td>
   
   </tr>
   
  <tr>
  <td align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31" >		
				<strong><?php echo date('d/m/y',$res3consultationdate); ?> <?php echo $res3consultationtime; ?></strong>   </td>
   <td   align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31" >		
				Registered By </td>
   <td   align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31" ><?php echo strtoupper($res3username); ?></td>
  </tr>
</table>
</body>
<?php	
	$content = ob_get_clean();
   
    // convert to PDF
   
    try
    {	
		$width_in_inches = 3.39;
		$height_in_inches = 2.10;
		$width_in_mm = $width_in_inches * 30.4; 
		$height_in_mm = $height_in_inches * 25.4;
        $html2pdf = new HTML2PDF('L', array($width_in_mm,$height_in_mm), 'en', true, 'UTF-8', array(0, 0, 0,0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->setDefaultFont('Helvetica');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('ipvisitlabel.pdf');
		
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
	
?>
