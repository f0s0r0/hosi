<?php
require_once('html2pdf/html2pdf.class.php');

ob_start(); 
session_start();
//include("barcode/test.php");
//include ("includes/loginverify.php");
include ("db/db_connect.php");
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
if (isset($_REQUEST["assetanum"])) {$assetanum = $_REQUEST["assetanum"]; } else { $assetanum = ""; }
$currentdate=date('Y-m-d H:i:s');
$query61 = "select asset_id from assets_register where auto_number = '$assetanum'";
$exec61 = mysql_query($query61) or die ("Error in Query61".mysql_error());
$res61 = mysql_fetch_array($exec61);
$assetid = $res61['asset_id'];
$assetid=trim($assetid);
?>
    <table width="auto" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
	<td>
	 <img src="logofiles/1.jpg" width="30" height="40" /> </td>
	 <td style="font-size:14px; font-weight:bold;" align="center">Property of <br><?= $companyname;?>
	</td>
	</tr>
      <tr>
        <td colspan="2" align="center"><img src="<?=$applocation1;?>/barcode/test.php?text=<?=$assetid;?>" width="130" height="55" /></td>
      </tr>
    </table>
 
<?php	
$content = ob_get_clean();
// convert in PDF
try
{
$html2pdf = new HTML2PDF('L', array(28,54),'en', true, 'UTF-8', array(0, 0, 0, 0));
//      $html2pdf->setModeDebug();
$html2pdf->setDefaultFont('Arial');
$html2pdf->writeHTML($content, isset($_GET['vuehtml']));

$html2pdf->Output('LabSampleLabel.pdf');
}
catch(HTML2PDF_exception $e) {
echo $e;
exit;
}
?>