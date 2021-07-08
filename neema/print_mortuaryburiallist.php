<?php
require_once('html2pdf/html2pdf.class.php');
ob_start();
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
date_default_timezone_set('Asia/Calcutta'); 
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];

if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }

	include('convert_currency_to_words.php');
	
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$updatetime = date('H:i:s');

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";



if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag2 = $_POST['frmflag2'];
if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if(isset($_REQUEST['docno'])) { $docno = $_REQUEST["docno"]; } else { $docno = ""; }
if(isset($_REQUEST['update'])) { echo $update = $_REQUEST["update"]; } else { $update = ""; }
//include('convert_currency_to_words.php');
?>
<style type="text/css">
.bodytext33 {FONT-WEIGHT: bold; FONT-SIZE: 17px; COLOR: #000000; 
}
.bodytext40 {FONT-WEIGHT: bold; FONT-SIZE: 24px; COLOR: #000000; 
}
.bodytext41 {FONT-WEIGHT: bold; FONT-SIZE: 24px; COLOR: #000000; 
}
.bodytext42 {FONT-WEIGHT: bold; FONT-SIZE: 24px; COLOR: #000000; 
}
.bodytext43 {FONT-WEIGHT: bold; FONT-SIZE: 17px; COLOR: #000000; 
}
.bodytext44 {FONT-WEIGHT: bold; FONT-SIZE: 17px; COLOR: #000000; 
}
.bodytext45 {FONT-WEIGHT: bold; FONT-SIZE: 20px; COLOR: #000000; 
}
.bodytext46 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000; 
}
.bodytext47 {FONT-WEIGHT: bold; FONT-SIZE: 19px; COLOR: #000000; 
}
.bodytext48 {FONT-WEIGHT: bold; FONT-SIZE: 19px; COLOR: #000000; 
}
.bodytext49 {FONT-WEIGHT: bold; FONT-SIZE: 18px; COLOR: #000000; 
}
.bodytext50 {FONT-WEIGHT: bold; FONT-SIZE: 17px; COLOR: #000000; 
}

.bodytext51 {FONT-WEIGHT: bold; FONT-SIZE: 17px; COLOR: #000000; 
}
</style>
<style type="text/css">
.bodytext34 {FONT-WEIGHT: bold; FONT-SIZE: 17px; COLOR: #000000; 
}
</style>
<style type="text/css">
.bodytext32 {FONT-WEIGHT: bold; FONT-SIZE: 17px; COLOR: #000000; 
}
</style>
<style type="text/css">
.bodytext31 {FONT-WEIGHT: bold; FONT-SIZE: 19.5px; COLOR: #000000; 
}
table {font-size:18px; }
</style>

<table width="623" border="0" cellpadding="0" cellspacing="0" align="center">
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
			<td width="80" rowspan="4">
			  <?php
			$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
			$exec3showlogo = mysql_query($query3showlogo) or die ("Error in Query3showlogo".mysql_error());
			$res3showlogo = mysql_fetch_array($exec3showlogo);
			$showlogo = $res3showlogo['showlogo'];
			if ($showlogo == 'SHOW LOGO')
			{
			?>
				
			<!--<img src="logofiles/<?php echo $companyanum;?>.jpg" width="90" height="85" />-->
			
			<?php
			}
			?></td>
            <td colspan="2" align="left" class="bodytext40"><?php
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
			<td align="center" class="bodytext33">
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
		  <td align="center" class="bodytext33">
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
    <td width="374" align="center" class="bodytext41">
            <?php
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
    <td width="169" align="left" class="bodytext33">&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="2" align="left" class="bodytext42">
            <?php
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
  <tr>
  <td>&nbsp;  </td>
  
  </tr>
</table>


<?php 


	$query1 = "select * from mortuary_allocation where patientcode='$patientcode' and visitcode='$visitcode' and docno ='$docno'";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		
		while($res1 = mysql_fetch_array($exec1))
		{
		$patientname=$res1['patientname'];
		$patientcode=$res1['patientcode'];
		$accountname = $res1['accountname'];
			 $requestno = $res1['requestno'];
		
	
		$query69 = "SELECT * FROM mortuary_request WHERE docno = '$requestno'";
		$exec69 = mysql_query($query69) or die(mysql_error());
		$num69 = mysql_num_rows($exec69);
		$res69 = mysql_fetch_array($exec69);
		$age = $res69['age'];
		$gender = $res69['gender'];
		$billtype = $res69['billtype'];
		
		$query32 = "select * from ip_discharge where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec32 = mysql_query($query32) or die(mysql_error());
		$num32 = mysql_num_rows($exec32);
		
		$query67 = "select * from master_accountname where auto_number='$accountname'";
		$exec67 = mysql_query($query67); 
		$res67 = mysql_fetch_array($exec67);
		$accname = $res67['accountname'];
		
		
		   $query63 = "select * from ip_bedallocation where patientcode='$patientcode' and visitcode='$visitcode'";
		   $exec63 = mysql_query($query63) or die(mysql_error());
		   $res63 = mysql_fetch_array($exec63);
		   $ward = $res63['ward'];
		   $bed = $res63['bed'];
		   
		   $query71 = "select * from ip_creditapproval where patientcode='$patientcode' and visitcode='$visitcode' order by auto_number desc";
		   $exec71 = mysql_query($query71) or die(mysql_error());
		   $res71 = mysql_fetch_array($exec71);
		   $num71 = mysql_num_rows($exec71);
		   if($num71 > 0)
		   {
		    $ward = $res71['ward'];
		    $bed = $res71['bed'];
		   }
		
		$query7811 = "select * from master_ward where auto_number='$ward' and recordstatus=''";
						  $exec7811 = mysql_query($query7811) or die(mysql_error());
						  $res7811 = mysql_fetch_array($exec7811);
						  $wardname1 = $res7811['ward'];
						  
						  $query50 = "select * from master_bed where auto_number='$bed'";
		                  $exec50 = mysql_query($query50) or die(mysql_error());
						  $res50 = mysql_fetch_array($exec50);
						  $bedname = $res50['bed'];
						  
            $query34 = "SELECT * FROM mortuary_allocation WHERE docno='$docno'";
			$exec34 = mysql_query($query34) or die("Error in Query34: ".mysql_error());
			$res34 = mysql_fetch_array($exec34);
			 $shelf = $res34['shelve'];
			 $package = $res34['package'];
						  
						  
	 $query782="select * from mortuary_burialdetails where docno='$docno'";
	$exec782=mysql_query($query782) or die(mysql_error());
	$result=mysql_fetch_array($exec782);
	  $bodyrelaseto= mysql_real_escape_string($result['bodyrelaseto']);
	  $relationship= mysql_real_escape_string($result['relationship']);
	  $placeofdeath= mysql_real_escape_string($result['placeofdeath']);
	  $country1= mysql_real_escape_string($result['country1']);
	  $country2= mysql_real_escape_string($result['country2']);
	  $country3= mysql_real_escape_string($result['country3']);
	  $country4= mysql_real_escape_string($result['country4']);
	  $placeofburial= mysql_real_escape_string($result['placeofburial']);
	  $constituency= mysql_real_escape_string($result['constituency']);
	  $ward= mysql_real_escape_string($result['ward']);
	  $location= mysql_real_escape_string($result['location']);
	  $sublocation= mysql_real_escape_string($result['sublocation']);
	  $village= mysql_real_escape_string($result['village']);
	  $persontransportingdeceased= mysql_real_escape_string($result['persontransportingdeceased']);
	  $firm= mysql_real_escape_string($result['firm']);
	  $vehicleregno= mysql_real_escape_string($result['vehicleregno']);
	  $type= mysql_real_escape_string($result['type']);
	  $contact= mysql_real_escape_string($result['contact']);
	  $humanremainsrelasedby= mysql_real_escape_string($result['humanremainsrelasedby']);
	  $telephone= mysql_real_escape_string($result['telephone']);
	  $trackno= mysql_real_escape_string($result['trackno']);
		}
?>

<table width="750" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-left:-13px;">
  <!--<tr>
    <td>Consultation Charges:</td>
    <td width="125" align="right"><strong><?php //echo $res11subtotalamount; ?></strong></td>
  </tr>-->
 	
  <tr>
    <td width="108" height="24" class="bodytext43">Patientname:</td>
    <td width="185"><?php echo $patientname; ?></td>
    <td width="151" align="left" class="bodytext43">Patientcode:</td>
    <td  align="left" ><?php echo $patientcode; ?> </td>
    <td width="81" align="left" class="bodytext43">Package:</td>
    <td width="113"  align="left" ><?php echo $package; ?> </td>
  </tr>
  <tr>
  <td align="left" class="bodytext43">Visitcode:</td>
    <td  ><?php echo $visitcode; ?></td>
    <td height="24" class="bodytext43">Account:</td>
    <td width="112"><?php echo $accname; ?></td>
     <td width="81" align="left" class="bodytext43">Shelves:</td>
    <td  align="left" ><?php echo $shelf; ?> </td>
  </tr>
  
  <tr>
   
    <td align="center" class="bodytext32">&nbsp;</td>
    <td align="right" class="bodytext32">&nbsp;</td>
    <td align="right" class="bodytext32">&nbsp;</td>
  </tr>
  
  
<tr></tr>
   </table>
   <table width="654" height="411"  align="center" cellpadding="0" cellspacing="0"bborder="1" >
   <tr>
   
			  <td colspan="4" align="center" valign="center"  class="bodytext3" ><b><u>BURIAL FORM</u></b></td>
			  
			  </tr>
			 
			  <tr></tr>
              <tr></tr>
              <tr></tr>
			   <tr></tr>
 				<tr></tr>
			  <tr></tr>
			  <tr>
			  <td colspan="4" align="left" valign="middle" class="bodytext3"  cellspacing="5" cellpadding="5">&nbsp;</td>
			  </tr>
              <tr></tr>
			  <tr></tr>
			  <tr>
			  <td width="140" height="37" colspan="">Body Relase to:</td>
			  <td  align="left"  width="142" colspan=""><?php echo $bodyrelaseto;?></td>
              
			  <td colspan=""  align="left">Realationship:</td>
			  <td colspan="" align="left" width="229"><?php echo $relationship;?></td>
              </tr>
              <tr>
			  <td height="36" colspan="1" align="left">Place of Death:</td>
			  <td align="left" colspan="" width="142"><?php echo $placeofdeath;?></td>
              <td >Place of Burial:</td>
			  <td colspan="" align="left" width="229"><?php echo $placeofburial;?></td>
			  </tr>
              <tr>
			  
			  <td height="38" colspan="" align="left">Constituencys:</td>
			  <td colspan="" align="left" width="142"><?php echo $constituency;?></td>
			  <td colspan="" align="align="left"">Ward:</td>
			  <td colspan="" align="left" width="229"><?php echo $ward;?></td>
              </tr>
			  <tr>
			  <td height="40" >Village:</td>
			  <td colspan="" align="left" width="142"><?php echo $village;?></td>
              
			  <td align="align="left"" >Person Transforting deceased:</td>
			  <td colspan="" align="left" width="229"><?php echo $persontransportingdeceased?></td>
              </tr>
              <tr>
			  <td height="31" align="left">Type:</td>
			  <td colspan="" align="left" width="142"><?php echo $type?></td>
			  <td  align="align="left"" valign="middle" class="bodytext3"  width="141">Contact:</td>
			  <td align="left" width="229"><?php echo $contact?></td>
              </tr>
               
			 
			  <tr>
			  <td height="32" >Place of Death:</td>
			  <td colspan="" align="left" width="142"><?php echo $placeofdeath?></td>
			  <td colspan="" align="left">Country:</td> 
			  <td colspan="" align="left" width="229"><?php echo $country1?></td>
              </tr>
              <tr>
			  <td height="30"  align="left">Country:</td>
			  <td colspan="" align="left" width="142"><?php echo $country2?></td>
              <td  align="left">Country:</td>
			  <td colspan="" align="left" width="229"><?php echo $country3?></td>
			  </tr>
			  <tr>
			 
			  <td height="31" align="left">Country:</td>
			  <td colspan="" align="left" width="142"><?php echo $country4?></td>
			  <td align="left">Location:</td>
			  <td colspan="" align="left" width="229"><?php echo $location?></td>
              </tr>
              <tr>
			  <td height="29"  align="left">Sub-Location:</td>
			  <td colspan="" align="left" width="142"><?php echo $sublocation?></td>
              
			  <td  colspan="" align="left" valign="middle" class="bodytext3"  >Firm:</td>
			  <td align="left" width="229"><?php echo $firm?></td>
              </tr>
              
              
			  <tr>
			  <td height="40" align="left">Vehicle Reg.No:</td>
			  <td colspan="" align="left" width="142" ><?php echo $vehicleregno?></td>
			  <td colspan="" align="left">Human remains released by:</td>
			  <td colspan="" align="left" width="229"><?php echo $humanremainsrelasedby?></td>
			  
			  </tr>
              
              
			  <tr>
			  <td >Telephone:</td>
			  <td colspan="" align="left" width="142"><?php echo $telephone?></td>
			  <td colspan="" align="left">Track No:</td>
			  <td colspan="" align="left" width="229"><?php echo $trackno?></td>
			  
			  </tr>
              
</table> 
	


<?php	
$content = ob_get_clean();

// convert in PDF

try
{
$html2pdf = new HTML2PDF('P', 'A4', 'en');
//      $html2pdf->setModeDebug();
$html2pdf->setDefaultFont('Arial');
$html2pdf->writeHTML($content, isset($_GET['vuehtml']));

$html2pdf->Output('print_billpaynowbill.pdf');
}
catch(HTML2PDF_exception $e) {
echo $e;
exit;
}
?>