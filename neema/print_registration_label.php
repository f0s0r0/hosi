<?php
require_once('html2pdf/html2pdf.class.php');
ob_start();
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

if (isset($_REQUEST["previouspatientcode"])) {$previouspatientcode = $_REQUEST["previouspatientcode"]; } else { $previouspatientcode = ""; }

$query1 = "select * from master_company where auto_number = '$companyanum'";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	$res1 = mysql_fetch_array($exec1);
	
	$companycode = $res1["companycode"];
	$phonenumber1 = $res1["phonenumber1"];
    $companyname1 = $res1["companyname"];
	
$query2 = "select * from master_customer where customercode ='$previouspatientcode' ";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	$res2 = mysql_fetch_array($exec2);
	
	$res2patientname = $res2["customerfullname"];
	$res2gender = $res2["gender"];
	$res2age = $res2["age"];
	$res2dateofbirth = $res2["dateofbirth"];
	$res2dateofbirth = strtotime($res2dateofbirth);
	$res2mobilenumber = $res2["mobilenumber"];

 

?>

	<table border="0" cellpadding="2" cellspacing="0" width="288" align="center">
		<tr>
			<td colspan="5" align="center" valign="center" 
			bgcolor="#ffffff" ><strong>&nbsp;</strong></td>
		</tr>
		
		<tr>
			<td colspan="5" align="center" valign="center" 
			bgcolor="#ffffff" style="border-bottom: solid 1px black; padding-left: 66px; padding-right: 66px; " class="bodytext31" nowrap="nowrap"><strong><?php echo $companyname1." -"."Tel No: "; ?><?php echo $phonenumber1; ?></strong></td>
		</tr>
		<tr>
		  <td colspan="3" align="">&nbsp;</td>
	  </tr>
		<tr>
			<td colspan="3" align=""><span class="bodytext31"><img src="http://<?php echo  $_SERVER['SERVER_NAME']; ?>/<?php echo basename(__DIR__); ?>/barcode/test.php?text=<?php echo $previouspatientcode; ?>" width="150" height="32" /></span></td>
		</tr>
		
		<tr>
			<td width="60"  align="left" valign="center" nowrap="nowrap" 
			bgcolor="#ffffff" class="bodytext31">		
			<strong>Reg No.</strong></td>
			<td width="100" align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31" id="pcode" >		
			<strong><?php echo $previouspatientcode; ?></strong></td>
			<td align="right" valign="center" 
			bgcolor="#ffffff" class="bodytext31" id="pcode" >&nbsp;</td>
		</tr>
		<tr>
			<td   align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31" >		
			<strong>Name </strong>   </td>
			<td width="282" colspan="3"   align="left" valign="center" nowrap="nowrap" 
			bgcolor="#ffffff" class="bodytext31">		
			<strong><?php echo strtolower($res2patientname); ?></strong>   </td>
		</tr>
		<tr>
			<td   align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31" ><strong>Gender </strong></td>
			<td colspan="3"   align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31" ><strong><?php echo $res2gender; ?></strong></td>
		</tr>
		<tr>
			<td   align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31" ><strong>Age</strong></td>
			<td colspan="3"   align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31" ><strong><?php echo $res2age; ?></strong></td>
		</tr>
		<tr>
			<td align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31" >		
			<strong>DOB </strong>   </td>
			<td colspan="3"   align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31" >		
			<strong><?php echo date('d/m/y',$res2dateofbirth); ?></strong>   </td>
		</tr>
		<tr>
			<td   align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31" >		
			<strong>Phone </strong>   </td>
			<td colspan="3"   align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext31" >		
			<strong><?php echo $res2mobilenumber; ?></strong>   </td>
		</tr>
	</table>


<?php

    $content = ob_get_clean();

    // convert in PDF
    try
    {
        $html2pdf = new HTML2PDF('P', 'A5', 'en');
//      $html2pdf->setModeDebug();
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('print_paylater.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>