<?php
require_once('html2pdf/html2pdf.class.php');
ob_start();
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$currentdate = date("Y-m-d");
if (isset($_REQUEST["frmprntflg"])) { $frmprntflg = $_REQUEST["frmprntflg"]; } else { $frmprntflg = ""; }
if($frmprntflg == 'frmprntflg')
{
$tdi=0;
?>
<table width="500" cellpadding="10" cellspacing="20">
<tr style="margin-top:10px;">
<?php
foreach ($_REQUEST['asset'] as $key=>$value)
{
$assetanum = $_REQUEST["asset"][$key];
$query61 = "select asset_id from assets_register where auto_number = '$assetanum'";
$exec61 = mysql_query($query61) or die ("Error in Query61".mysql_error());
$res61 = mysql_fetch_array($exec61);
$assetid = $res61['asset_id'];
$assetid=trim($assetid);
if( mysql_num_rows($exec61)>0)
{
if(($tdi%3)==0)
{
echo '</tr><tr style="margin-top:10px;">';
}
?>
<td width="80">

    <table width="80" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
	<td width="35">
	 <img src="logofiles/1.jpg" width="30" height="40" /> </td>
	 <td width="180" style="font-size:14px; font-weight:bold;" align="center">Property of <br><?= $companyname;?>
	</td>
	</tr>
      <tr>
        <td>&nbsp;</td>
        <td align="center"><img src="<?=$applocation1;?>/barcode/test.php?text=<?=$assetid;?>" width="130" height="55" /></td>
      </tr>
    </table>
 </td>
 <?php
 $tdi++;
 }
 }
 ?>
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
        $html2pdf->Output('Asset Labels.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
}
else
{
header("location:assetlabelsprint.php");
}
?>

