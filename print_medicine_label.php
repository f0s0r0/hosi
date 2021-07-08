<?php
require_once('html2pdf/html2pdf.class.php');
ob_start();
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$sno='';
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
?> 
<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; 
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; 
}
.bodytext41 {FONT-WEIGHT: normal; FONT-SIZE: 10px; COLOR: #3b3b3c; 
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c;  text-decoration:none
}
.bodytext365 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3b3b3c;  text-decoration:none
}
.bodytext366 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #3b3b3c;  text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; 
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; 
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; 
}
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
</style>
<?php 
	
if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if (isset($_REQUEST["billnumber"])) { $docnumber = $_REQUEST["billnumber"]; } else { $docnumber = ""; }

$query7 = "select * from master_visitentry where patientcode='$patientcode'";
$exec7=mysql_query($query7) or die ("Error in Query7".mysql_error());
$res7 = mysql_fetch_array($exec7);
$res7patientfirstname=$res7['patientfirstname'];
$res7patientlastname=$res7['patientlastname'];

$query2 = "select * from master_consultationpharmissue where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and docnumber = '$docnumber' and recordstatus <>'deleted' ";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$num2 = mysql_num_rows($exec2);
$recorddate='';
while( $res2 = mysql_fetch_array($exec2))
{
$res2dose = $res2['dose'];
$res2patientname = $res2['patientname'];
$res2frequencynumber = $res2['frequencynumber'];
$res2days = $res2['days']; 
$res2route = $res2['route'];
$res2instructions = $res2['instructions']; 
$res2itemname = $res2['medicinename'];
$res2medicinecode= $res2['medicinecode'];
$res2itemname = ucwords(strtolower($res2itemname));
$recorddate = $res2['recorddate'];
$phpdate = strtotime($recorddate);
$res9instructions='';

$query9 = "select * from pharmacysales_details where patientcode = '$patientcode' and visitcode = '$visitcode' and docnumber = '$docnumber' and itemcode='$res2medicinecode';";
$exec9=mysql_query($query9) or die ("Error in Query9".mysql_error());
$res9 = mysql_fetch_array($exec9);
$res9instructions = $res9['instructions'];
$res9batchnumber=$res9['batchnumber'];
$res9quantity = $res9['quantity'];
$res9quantity = intval($res9quantity);
$res9itemname = $res9['itemname'];
$res9medicinecode= $res9['itemcode'];

$query6 = "select * from purchase_details where batchnumber = '$res9batchnumber' and itemcode = '$res9medicinecode'";
$exec6=mysql_query($query6) or die ("Error in Query6".mysql_error());
$res6 = mysql_fetch_array($exec6);
$res6expirydate=$res6['expirydate'];
$res6batchnumber=$res6['batchnumber'];
$res6expirydate = strtotime($res6expirydate); 

$query8 = "select * from master_medicine where itemcode='$res9medicinecode'";
$exec8=mysql_query($query8) or die ("Error in Query8".mysql_error());
$res8 = mysql_fetch_array($exec8);
$res8formula = $res8['formula']; 

if($num2>0) 
{
	if($res9quantity>0) 
	{
?>
<page pagegroup="new" >
<table border="0" cellpadding="0" cellspacing="0">
		<tr>
		 <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31" style="border-bottom: solid 2px #000000;"><strong>Qty. <?php echo $res9quantity; ?></strong></td>
		 <td align="right" valign="center" bgcolor="#ffffff" class="bodytext31"  style="border-bottom: solid 2px #000000;"><strong>Exp: <?php echo date('m/y', $res6expirydate); ?></strong></td> 
		</tr>
		<tr>
		 <td width="210"  colspan="2" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong><?php echo ucwords(strtoupper($res2itemname)).' ('.$res6batchnumber.')'; ?></strong></td>
		</tr>
		<tr>
		 <td width="210" colspan="2"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31" style="border-bottom: solid 2px #000000;"><strong><?php if($res8formula=="INCREMENT") 
		{ 
			//echo "TAKE"."&nbsp;".$res2dose."&nbsp;"."TAB"."&nbsp;".$res2frequencynumber."&nbsp;"."TIMES A DAY FOR"."&nbsp;".$res2days."&nbsp;"."DAYS"."&nbsp;";
		}
		?>
		<?php // if($res8formula=="CONSTANT") 
		{ 
		echo $res9instructions;
		}
		?>		</strong>		 </td>
		</tr>
		<tr>
		 <td width="210" colspan="2" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong><?php echo $res7patientfirstname."&nbsp;".$res7patientlastname; ?></strong></td>
	    </tr>
		<tr>
		  <td width="210" colspan="2" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong><?php echo $patientcode; ?>&nbsp;&nbsp;<?php echo $visitcode; ?></strong></td>
  </tr>
		<tr>
		 <td width="210" colspan="2"  align="left"  valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Date:<?php echo date('d/m/Y ',$phpdate); ?></strong></td>
		</tr>
		<tr>
		  <td width="210" colspan="2"  align="left"  valign="center" bgcolor="#ffffff" class="bodytext31"><strong><?php echo $companyname; ?></strong></td>
  </tr>
	</table>
	</page>
<?php 
  }
 }
?>
<?php 
  }
?>
<?php	
$content = ob_get_clean();
// convert in PDF

try
{
$html2pdf = new HTML2PDF('P', array(60,58),'en', true, 'UTF-8', array(0, 0, 0, 0));
//      $html2pdf->setModeDebug();
$html2pdf->setDefaultFont('Arial');
$html2pdf->writeHTML($content, isset($_GET['vuehtml']));

$html2pdf->Output('Medicine Label.pdf');
}
catch(HTML2PDF_exception $e) {
echo $e;
exit;
}
?>
