<?php
require_once('html2pdf/html2pdf.class.php');
ob_start();
session_start();

include ("includes/loginverify.php");
include ("db/db_connect.php");

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
include('convert_currency_to_words.php');
?>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>




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
</head>

<script src="js/datetimepicker_css.js"></script>

<body>

  <table width="100%" border="0" cellspacing="0" cellpadding="2">
  
  <tr>
    <td colspan="14">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      
	 
	
		<tr>
		<td>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
             <tr></tr>
          	 
			  
			  
           <?php
            $colorloopcount ='';

	 
	
		$query1 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode' and paymentstatus =''";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		
		while($res1 = mysql_fetch_array($exec1))
		{
		$patientname=$res1['patientfullname'];
		$patientcode=$res1['patientcode'];
		$accountname = $res1['accountname'];
		$gender = $res1['gender'];
		$age = $res1['age'];
		$billtype =  $res1['billtype'];
		
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
						  
	 $query782="select * from mortuary_receivedetails where docno='$docno'";
	$exec782=mysql_query($query782) or die(mysql_error());
	$result=mysql_fetch_array($exec782);
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
                                     	

	$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				echo "";
				$colorcode = 'bgcolor="#D3EEB7"';
			}
			?>
            
             <tr>
              
				 <td colspan="2"  align="left" valign="center" 
                bgcolor="#fffff" class="bodytext31"><div align="center"><label><strong> Patient Name</strong></label></div></td>
            	<td colspan="2"  align="left" valign="center" class="bodytext31">
			    <div align="center"><?php echo $patientname; ?></div></td>
				 <td colspan="2"  align="left" valign="center" 
                bgcolor="#" class="bodytext31"><div align="center"><strong>Patient Code  </strong></div></td>
                <td colspan="2"  align="center" valign="center" class="bodytext31"><?php echo $patientcode; ?></td>
                </tr>
                <tr>
				 <td width="146"  align="left" valign="center" 
                bgcolor="#" class="bodytext31"><div align="center"><strong>IP Visit  </strong></div></td>
                <td  align="center" valign="center" class="bodytext31"><?php echo $visitcode; ?></td>
				 <td width="160"  align="left" valign="center" 
                bgcolor="#" class="bodytext31"><div align="center"><strong>Account</strong></div></td>
                <td  align="center" valign="center" class="bodytext31"><?php echo $accname; ?></td>
                </tr>
				 <td width="160"  align="left" valign="center" 
                bgcolor="#" class="bodytext31"><div align="center"><strong>Ward</strong></div></td>
                <td  align="center" valign="center" class="bodytext31"><?php echo $wardname1; ?></td>
				<td width="144"  align="left" valign="center" 
                bgcolor="#" class="bodytext31"><div align="center"><strong>Bed</strong></div></td>
                <td  align="center" valign="center" class="bodytext31"><?php echo $bedname; ?></td>
              </tr>
			  
         
			   <tr>
             	<td colspan="1500" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#cccccc" class="bodytext311">&nbsp;</td><td width="1" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#cccccc" class="bodytext311">&nbsp;</td>
            
             	<td width="22" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#cccccc" class="bodytext311">&nbsp;</td>
             	</tr>
 
			   
			  <tr>
			  <td colspan="30"align="center" valign="center" bgcolor="#E0E0E0" class="bodytext3" ><b><u>RECEIVING FORM</u></b></td>
			  
			  </tr>
			 
			  <tr>
			  <td colspan="3"align="left" valign="left" class="bodytext3" bgcolor="#E0E0E0"><strong>Condition of the diseased :</strong></td>
			  <td><input type="textarea" name="conditionofdisease" value="<?php echo $conditionofdisease;?>"></td>
			  <td colspan="1"align="center" valign="middle" class="bodytext3"  bgcolor="#E0E0E0" width="146"><strong>Scars,Tattoos,Marking:</strong></td>
			  <td><input type="textarea"    name="scars" value="<?php echo $scars;?> "></td>
			 <td colspan="1" align="right" valign="right" class="bodytext3" bgcolor="#E0E0E0" width="160"><strong>Other Comments:</strong></td>
			  <td><input type="textarea"   name="comments" value="<?php echo $comments;?>"></td>
			  </tr>
			   <tr>
             <td colspan="1500" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#cccccc" class="bodytext311">&nbsp;</td><td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
            
             	<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
             	</tr>
 
			  <tr>
			  <td colspan="20" align="left" valign="middle" class="bodytext3" bgcolor="#E0E0E0"><b style="font-family:Verdana">PERSONAL EFFECTS:</b></td>
			  </tr>
			  <tr>
			  <td colspan="100" align="left" valign="middle" class="bodytext3" bgcolor="#E0E0E0" cellspacing="5" cellpadding="5"><strong class="bodytext31" width="100" >During removal the following personal effects were found on the diseased and if none mention</strong></td>
			  </tr>
			  <tr>
			  <td colspan="20" align="left" valign="middle" class="bodytext3" bgcolor="#E0E0E0"><strong>Clothing:</strong></td>
			  </tr>
			  <tr>
			  <td colspan="2">Shirt/tshirt</td>
			  <td colspan=""><textarea id="shirt" name="shirt"><?php echo $shirt?></textarea></td>
              
			  <td colspan="" align="right">Belt</td>
			  <td colspan=""><textarea id="belt" name="belt"><?php echo $belt?></textarea></td>
			  <td colspan="1" align="right">Trousers/short</td>
			  <td colspan=""><textarea id="trousers" name="trousers"><?php echo $trousers?></textarea></td>
			  </tr>
              <tr>
			  <td colspan="2">Jacket</td>
			  <td colspan=""><textarea id="jacket" name="jacket"><?php echo $jacket?></textarea></td>
			  <td colspan="" align="right">Socks</td>
			  <td colspan=""><textarea id="socks" name="socks"><?php echo $socks?></textarea></td>
			  <td colspan="" align="right">Tie</td>
			  <td colspan=""><textarea id="tie" name="tie"><?php echo $tie?></textarea></td>
              </tr>
			  <tr>
			  <td colspan="2">Dress</td>
			  <td colspan=""><textarea id="dress" name="dress"><?php echo $dress?></textarea></td>
              
			  <td align="right">Skirt</td>
			  <td colspan=""><textarea id="skirt" name="skirt"><?php echo $skirt?></textarea></td>
              
			  <td align="right">Blouse</td>
			  <td colspan=""><textarea id="blouse" name="blouse"><?php echo $blouse?></textarea></td>
			  <td  align="right" valign="middle" class="bodytext3" bgcolor="#E0E0E0" width="2500"><strong>Any others:</strong></td>
			  <td><textarea id="anyothers" name="anyothers"><?php echo $clothingothers?></textarea></td>
              </tr>
			  <tr>
			  <td colspan="20" align="left" valign="middle" class="bodytext3" bgcolor="#E0E0E0"><strong>Jewellery:</strong></td>
			  </tr>
			  <tr>
			  <td colspan="2">Rings</td>
			  <td colspan=""><textarea id="rings" name="rings"><?php echo $rings?></textarea></td>
			  <td colspan="" align="right">Bracelet</td>
			  <td colspan=""><textarea id="bracelet" name="bracelet"><?php echo $bracelet?></textarea></td>
			  <td colspan="1" align="right">Necklace</td>
			  <td colspan=""><textarea id="necklace" name="necklace"><?php echo $necklace?></textarea></td>
			  </tr>
			  <tr>
			  <td colspan="2">Earrings</td>
			  <td colspan=""><textarea id="earrings" name="earrings"><?php echo $earrings?></textarea></td>
			  <td align="right">Watch</td>
			  <td colspan=""><textarea id="watch" name="watch"><?php echo $watch?></textarea></td>
			  <td align="right">Make</td>
			  <td colspan=""><textarea id="make" name="make"><?php echo $make?></textarea></td>
              </tr>
              <tr>
			  <td colspan="2">Pens</td>
			  <td colspan=""><textarea id="pens" name="pens"><?php echo $pens?></textarea></td>
              <td colspan="4">&nbsp;</td>
			  <td  colspan="" align="right" valign="middle" class="bodytext3" bgcolor="#E0E0E0" ><strong>Specify:</strong></td>
			  <td><textarea id="specify" name="specify" rows="0"><?php echo $jewelleryspecify?></textarea>
              </tr>
			  <tr>
			  <td colspan="20" align="left" valign="middle" class="bodytext3" bgcolor="#E0E0E0"><strong>Wallet:</strong></td>
			  </tr>
              
			  <tr>
			  <td colspan="2">Id</td>
			  <td colspan=""><textarea id="id" name="id"><?php echo $walletid?></textarea></td>
			  <td colspan="" align="right">Keys</td>
			  <td colspan=""><textarea id="keys" name="keys"><?php echo $keyy?></textarea></td>
			  <td colspan="1" align="right">Passport</td>
			  <td colspan=""><textarea id="passport" name="passport"><?php echo $passport?></textarea></td>
			  </tr>
              
              
			  <tr>
			  <td colspan="2">DrivingLicense</td>
			  <td colspan=""><textarea id="drivinglicense" name="drivinglicense"><?php echo $drivinglicense?></textarea></td>
			  <td colspan="" align="right">CreditCard</td>
			  <td colspan=""><textarea id="creditcard" name="creditcard"><?php echo $creditcard?></textarea></td>
			  <td colspan="1" align="right">Cash</td>
			  <td colspan=""><input type="text" name="cash" id="cash" value="<?php echo $cash?>"></td>
			  </tr>
			  <tr>
			  <td colspan="2">Amount</td>
			  <td colspan=""><input type="text" name="amount" id="amount" value="<?php echo $amount?>"></td>
              <td colspan="4">&nbsp;</td>
			  <td colspan="" align="right" class="bodytext3"><strong>Others Specify:</strong></td>
			  <td colspan=""><textarea id="othersspecify" name="othersspecify"><?php echo $walletspecify?></textarea></td>
			  <td colspan="1">&nbsp;</td>
			  <td  align="right" valign="middle" class="bodytext3" bgcolor="#E0E0E0" width="2500"><strong>&nbsp;</strong></td>
			  <td>&nbsp;</td>
			 </tr>
			 <tr>
             <td colspan="7" align="left" valign="center" bordercolor="#f3f3f3" 
              bgcolor="#cccccc" class="bodytext311">&nbsp;</td><td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
              bgcolor="#cccccc">&nbsp;</td>
            
             	<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
             	</tr>
				<tr>
				<td colspan="2" align="left" valign="left" class="bodytext3" bgcolor="#E0E0E0" width="1500"><strong>Received by:</strong></td>
				<td><?php echo $username;?></td>
				<td colspan="1" align="center" valign="middle" class="bodytext3" bgcolor="#E0E0E0" width="1500"><strong>Witnessed by:</strong></td>
				<td><input type="text" name="witnessedby" value="<?php echo $witnessedby?>"></td>
				<td colspan="1" align="right" valign="middle" class="bodytext3" bgcolor="#E0E0E0" width="1500"><strong>Relationship:</strong></td>
				<td><input type="text" name="relationship" value="<?php echo $relationship?>"></td>
				<td colspan="1" align="center" valign="middle" class="bodytext3" bgcolor="#E0E0E0" width="1500"><strong>Witness ID:</strong></td>
				<td><input type="text" name="witnessid" value="<?php echo $witnessid?>"></td>
				</tr>
				
				<tr>
				<td colspan="2" align="left" valign="left" class="bodytext3" bgcolor="#E0E0E0" width="1500"><strong>Witness Telephone:</strong></td>
				<td><input type="text" name="witnesstelephone" value="<?php echo $witnesstelephone?>"></td>
				<td colspan="1" align="right" valign="middle" class="bodytext3" bgcolor="#E0E0E0" width="1500"><strong>Next of Kin</strong></td>
				<td><input type="text" name="nextofkin" value="<?php echo $nextofkin?>"></td>
				<td colspan="1" align="right" valign="middle" class="bodytext3" bgcolor="#E0E0E0" width="1500"><strong>Relationship:</strong></td>
				<td><input type="text" name="nextofkinrelationship" value="<?php echo $kinrelationship?>"></td>
				<td colspan="1" align="right" valign="middle" class="bodytext3" bgcolor="#E0E0E0" width="1500"><strong>Next of Kin Telephone:</strong></td>
				<td><input type="text" name="nextofkinrelationshitelephone" value="<?php echo $nextofkintelephone?>"></td>
				</tr>
				
 
			  
 
			  
		   <?php 
		  } 
		  
		   ?>
          
  </table>
  </table>

<?php	
/*$content = ob_get_clean();

// convert in PDF

try
{
$html2pdf = new HTML2PDF('P', 'A5', 'en');
//      $html2pdf->setModeDebug();
$html2pdf->setDefaultFont('Arial');
$html2pdf->writeHTML($content, isset($_GET['vuehtml']));

$html2pdf->Output('print_billpaynowbill.pdf');
}
catch(HTML2PDF_exception $e) {
echo $e;
exit;
}*/
?>

