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
		
		
		
						  
            $query34 = "SELECT * FROM mortuary_allocation WHERE docno='$docno'";
			$exec34 = mysql_query($query34) or die("Error in Query34: ".mysql_error());
			$res34 = mysql_fetch_array($exec34);
			 $shelf = $res34['shelve'];
			 $package = $res34['package'];
						  
	 $query782="select * from mortuary_removaldetails where docno='$docno'";
	$exec782=mysql_query($query782) or die(mysql_error());
	$result=mysql_fetch_array($exec782);
	 $placeofremoval=$result['placeofremoval'];
	 $disease=$result['disease'];
	 $conditionofdisease=$result['conditionofdecease'];
	 $scars=$result['scarsmarkings'];
	 $comments=$result['comments'];
	  $shirt=$result['shirt'];
	 $belt=$result['belt'];
	 $trousers=$result['trousers'];
	 $jacket=$result['jacket'];
	 $socks=$result['socks'];
	 $tie=$result['tie'];
	 $dress=$result['dress'];
	 $skirt=$result['skirt'];
	 $blouse=$result['blouse'];
	 $clothingothers=$result['clothingothers'];
	 $rings=$result['rings'];
	  $bracelet=$result['bracelet'];
	 $necklace=$result['necklace'];
	 $earrings=$result['earrings'];
	 $watch=$result['watch'];
	 $make=$result['make'];
	 $pens=$result['pens'];
	 $jewelleryspecify=$result['jewelleryspecify'];
	 $walletid=$result['walletid'];
	 $keyy=$result['keyy'];
	 $passport=$result['passport'];
	 $drivinglicense=$result['drivinglicense'];
	  $creditcard=$result['creditcard'];
	 $cash=$result['cash'];
	 $amount=$result['amount'];
	 $walletspecify=$result['walletspecify'];
	 $witnessedby=$result['witnessedby'];
	 $relationship=$result['relationship'];
	 $witnessid=$result['witnessid'];
	 $witnesstelephone=$result['witnesstelephone'];
	 $nextofkin=$result['nextofkin'];
	 $kinrelationship=$result['kinrelationship'];
	 $nextofkintelephone=$result['nextofkintelephone'];
         
		}
?>

<table width="700" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-left:-13px;">
  <!--<tr>
    <td>Consultation Charges:</td>
    <td width="125" align="right"><strong><?php //echo $res11subtotalamount; ?></strong></td>
  </tr>-->
 	
  <tr>
    <td width="122" height="24" class="bodytext43">Patientname:</td>
    <td width="235"><?php echo $patientname; ?></td>
    <td width="110" align="left" class="bodytext43">Patientcode:</td>
    <td width="233" colspan="2" align="left" ><?php echo $patientcode; ?> </td>
    
  </tr>
  <tr>
  <td align="left" class="bodytext43">Visitcode:</td>
    <td  ><?php echo $visitcode; ?></td>
    <td height="24" class="bodytext43">Account:</td>
    <td><?php echo $accname; ?></td>
  </tr>
  
  <tr>
   
    <td align="center" class="bodytext32">&nbsp;</td>
    <td align="right" class="bodytext32">&nbsp;</td>
    <td align="right" class="bodytext32">&nbsp;</td>
  </tr>
  
  
<tr></tr>
   </table>
   <table width="654" height="780" align="center" cellpadding="0" cellspacing="0"bborder="1" >
   <tr>
   
			  <td colspan="4" align="center" valign="center"  class="bodytext3" ><b><u>REMOVAL FORM</u></b></td>
			  
			  </tr>
              
			  <tr>
			  <td align="left" valign="middle" class="bodytext3" ><strong>Place of Removal :</strong></td>
              
			  <td><?php echo $placeofremoval;?></td>
              </tr>
			 
			  <tr>
			  <td align="left" valign="middle" class="bodytext3" ><strong>Condition of the diseased :</strong></td>
              
			  <td><?php echo $conditionofdisease;?></td>
              </tr>
              <tr>
			  <td align="left" valign="middle" class="bodytext3"   width="158"><strong>Scars,Tattoos,Marking:</strong></td>
			  <td><?php echo $scars;?> </td>
              </tr>
              <tr>
			 <td colspan="1" align="left" valign="middle" class="bodytext3"  width="158"><strong>Other Comments:</strong></td>
			  <td><?php echo $comments;?></td>
			  </tr>
			   <tr></tr>
 				<tr>
                <td>&nbsp;</td>
                
                </tr>
			  <tr>
			  <td colspan="4" align="left" valign="middle" class="bodytext3" ><b >PERSONAL EFFECTS:</b></td>
			  </tr>
			  <tr>
			  <td colspan="4" align="left" valign="middle" class="bodytext3"  cellspacing="5" cellpadding="5">During removal the following personal  
			  effects were found on the diseased and <br />if none mention</td>
			  </tr>
              <tr>
              <td>&nbsp;
              </td>
              </tr>
			  <tr>
			  <td colspan="4" align="left" valign="middle" class="bodytext3" ><strong>Clothing:</strong></td>
              
			  </tr>
			  <tr>
			  <td width="150" height="30" colspan="">Shirt/tshirt</td>
			  <td  align="left"  width="200" colspan=""><?php echo $shirt?></td>
              
			  <td colspan=""  align="left">Belt</td>
			  <td colspan="" align="left" width="200"><?php echo $belt?></td>
              </tr>
              <tr>
			  <td height="23" colspan="1" align="left">Trousers/short</td>
			  <td align="left" colspan="" width="200"><?php echo $trousers?></td>
              <td >Jacket</td>
			  <td colspan="" align="left" width="200"><?php echo $jacket?></td>
			  </tr>
              <tr>
			  
			  <td height="25" colspan="" align="left">Socks</td>
			  <td colspan="" align="left" width="200"><?php echo $socks?></td>
			  <td colspan="" align="align="left"">Tie</td>
			  <td colspan="" align="left" width="200"><?php echo $tie?></td>
              </tr>
			  <tr>
			  <td height="22" >Dress</td>
			  <td colspan="" align="left" width="200"><?php echo $dress?></td>
              
			  <td align="align="left"">Skirt</td>
			  <td colspan="" align="left" width="200"><?php echo $skirt?></td>
              </tr>
              <tr>
			  <td align="left">Blouse</td>
			  <td colspan="" align="left" width="200"><?php echo $blouse?></td>
			  <td  align="align="left"" valign="middle" class="bodytext3"  width="150"><strong>Any others:</strong></td>
			  <td align="left" width="200"><?php echo $clothingothers?></td>
              </tr>
               <tr>
              <td>&nbsp;
              </td>
              </tr>
			  <tr>
			  <td colspan="4" align="left" valign="middle" class="bodytext3" ><strong>Jewellery:</strong></td>
			  </tr>
			  <tr>
			  <td height="22" >Rings</td>
			  <td colspan="" align="left" width="200"><?php echo $rings?></td>
			  <td colspan="" align="left">Bracelet</td>
			  <td colspan="" align="left" width="200"><?php echo $bracelet?></td>
              </tr>
              <tr>
			  <td height="24"  align="left">Necklace</td>
			  <td colspan="" align="left" width="200"><?php echo $necklace?></td>
              <td  align="left">Earrings</td>
			  <td colspan="" align="left" width="200"><?php echo $earrings?></td>
			  </tr>
			  <tr>
			 
			  <td height="25" align="left">Watch</td>
			  <td colspan="" align="left" width="200"><?php echo $watch?></td>
			  <td align="left">Make</td>
			  <td colspan="" align="left" width="200"><?php echo $make?></td>
              </tr>
              <tr>
			  <td height="24"  align="left">Pens</td>
			  <td colspan="" align="left" width="200"><?php echo $pens?></td>
              
			  <td  colspan="" align="left" valign="middle" class="bodytext3"  ><strong>Specify:</strong></td>
			  <td align="left" width="200"><?php echo $jewelleryspecify?></td>
              </tr>
               <tr>
              <td height="19">&nbsp;
              </td>
              </tr>
			  <tr>
			  <td height="26" colspan="4" align="left" valign="middle" class="bodytext3" ><strong>Wallet:</strong></td>
			  </tr>
              
			  <tr>
			  <td height="24" align="left">Id</td>
			  <td colspan="" align="left" width="200" ><?php echo $walletid?></td>
			  <td colspan="" align="left">Keys</td>
			  <td colspan="" align="left" width="200"><?php echo $keyy?></td>
			  
			  </tr>
              
              
			  <tr>
			  <td height="24" >DrivingLicense</td>
			  <td colspan="" align="left" width="200"><?php echo $drivinglicense?></td>
			  <td colspan="" align="left">CreditCard</td>
			  <td colspan="" align="left" width="200"><?php echo $creditcard?></td>
			  
			  </tr>
              <tr>
              <td height="26" colspan="" align="left">Cash</td>
			  <td align="left" width="200"><?php echo $cash; ?></td>
              </tr>
			  <tr>
			  <td colspan="" align="left">Amount</td>
			  <td colspan="" align="left" width="200"><?php echo $amount?></td>
           
			  <td colspan="" align="left" class="bodytext3"><strong>Others Specify:</strong></td>
			  <td colspan="" align="left" width="200"><?php echo $walletspecify?></td>
			  
			 </tr>
			 <tr>
             <td height="24"  align="left" valign="center" 
              class="bodytext311">&nbsp;</td><td class="bodytext311" valign="center" align="left" 
             >&nbsp;</td>
            
             	<td class="bodytext311" valign="center" align="left" 
               >&nbsp;</td>
             	</tr>
				<tr>
				<td  align="left" valign="left" class="bodytext3"><strong>Received by:</strong></td>
				<td align="left" width="200"><?php echo $username;?></td>
				<td  align="left" valign="middle" class="bodytext3"  width="175"><strong>Witnessed by:</strong></td>
				<td align="left" width="200"><?php echo $witnessedby?></td>
                </tr>
                <tr>
				<td  width="158" height="28"  align="left" valign="middle" class="bodytext3"><strong>Relationship:</strong></td>
				<td align="left" width="200"><?php echo $relationship?></td>
				<td  align="left" valign="middle" class="bodytext3"  width="175"><strong>Witness ID:</strong></td>
				<td align="left" width="200" ><?php echo $witnessid?></td>
				</tr>
				
				<tr>
				<td height="32"  align="left" valign="left" class="bodytext3"><strong>Witness Telephone:</strong></td>
				<td align="left" width="200"><?php echo $witnesstelephone?></td>
				<td  align="left" valign="middle" class="bodytext3"  width="175"><strong>Next of Kin</strong></td>
				<td align="left" width="200"><?php echo $nextofkin?></td>
                </tr>
                <tr>
				<td  align="left" valign="middle" class="bodytext3"  width="158"><strong>Relationship:</strong></td>
				<td align="left" width="200"><?php echo $kinrelationship?></td>
				<td align="left" valign="middle" class="bodytext3"  width="175"><strong>Next of Kin Telephone:</strong></td>
				<td align="left" width="200"><?php echo $nextofkintelephone?></td>
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