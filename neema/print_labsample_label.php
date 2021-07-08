<?php
require_once('html2pdf/html2pdf.class.php');

ob_start();
session_start();
include("barcode/test.php");
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

if (isset($_REQUEST["docnumber"])) {$docnumber = $_REQUEST["docnumber"]; } else { $docnumber = ""; }

?> 

<style type="text/css">
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000;  text-decoration:none
}
.bodytext3{FONT-WEIGHT: bolder; FONT-SIZE: 15px; COLOR: #000000;  text-decoration:none}
.bodytext4{FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #000000;  text-decoration:none}
td{ height: 14px; }
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 20px; COLOR: #000000;  text-decoration:none
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 23px; COLOR: #000000;  text-decoration:none
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 23px; COLOR: #000000;  text-decoration:none
}
.bodytext33 {FONT-WEIGHT: normal; FONT-SIZE: 20px; COLOR: #000000;  text-decoration:none
}
.bodytext34 {FONT-WEIGHT: normal; FONT-SIZE: 20px; COLOR: #000000;  text-decoration:none
}
.bodytext35 {FONT-WEIGHT: normal; FONT-SIZE: 20px; COLOR: #000000;  text-decoration:none 
}
.bodytext36 {FONT-WEIGHT: normal; FONT-SIZE: 20px; COLOR: #000000;  text-decoration:none 
}
table {
   display: table;
   width:100%;
   table-layout: fixed;
}
body {
	
}

</style>

    

<body onkeydown="escapeke11ypressed()">
<?php 
$currentdate=date('Y-m-d H:i:s');
$query61 = "select patientname,sample_id, patientcode,visitcode,sampledate from pending_test_orders where sample_id = '$docnumber' order by sample_id ASC ";
$exec61 = mysql_query($query61) or die ("Error in Query61".mysql_error());
$num = mysql_num_rows($exec61);
if($num==0)
{
echo "<script>window.close();</script>";
}
else
{
$res61 = mysql_fetch_array($exec61);
$patientname = $res61['patientname'];
$sampleid = $res61['sample_id'];
//$itemname = $res61['testname'];
$patientcode=$res61['patientcode'];
$visitcode=$res61['visitcode'];
$datetime = $res61['sampledate'];
$sampleanum = substr($sampleid,4);
?>
    <table width="auto" border="" cellpadding="0" cellspacing="0" align="center">
	
      <tr align="center">
      <td align="center" class="bodytext31"  ><?php echo $patientname; ?></td>
      </tr>
      <tr>
        <td align="center" class="bodytext31" ><?php
//			$address4 = " E-Mail: ".$emailid1;
//			$strlen3 = strlen($address4);
//			$totalcharacterlength3 = 35;
//			$totalblankspace3 = 35 - $strlen3;
//			$splitblankspace3 = $totalblankspace3 / 2;
//			for($i=1;$i<=$splitblankspace3;$i++)
//			{
//			$address4 = ' '.$address4.' ';
//			}
//			?>
<img src="<?php echo $applocation1; ?>/barcode/test.php?text=<?php echo $sampleid; ?>" width="0" height="0" /> </td>


              
      </tr>
    </table>
    <!--</td>
  </tr>
  
 -->
  <table width="auto" height="" border="" align="center" cellpadding="0" cellspacing="2">
  <tr>
  <td   align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext31" >		
				<strong><?= $patientcode.' &nbsp;'.$visitcode ?> </strong> </td>
   
  </tr>
  <tr>
  <td   align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext31" >		
				<strong><?= $datetime ?> </strong> </td>
   
  </tr>
 
  
</table>


<?php

$content = ob_get_clean();

// convert in PDF

try
{
$html2pdf = new HTML2PDF('L', array(28,48),'en', true, 'UTF-8', array(0, 0, 0, 0));
//      $html2pdf->setModeDebug();
$html2pdf->setDefaultFont('Arial');
$html2pdf->writeHTML($content, isset($_GET['vuehtml']));

$html2pdf->Output('LabSampleLabel.pdf');
}
catch(HTML2PDF_exception $e) {
echo $e;
exit;
}
}	 
?>