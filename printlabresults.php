<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
//include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");

$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];

$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$dateonly1 = date("Y-m-d");
$timeonly= date("H:i:s");
$titlestr = 'SALES BILL';
$colorloopcount = '';
$sno = '';

ob_start();



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
$faxnumber1 = $res2["faxnumber1"];
$cstnumber1 = $res2["cstnumber"];

$location= $locationname;

?>

<?php
$patientcode = $_REQUEST["patientcode"];
$visitcode = $_REQUEST["visitcode"];
$docnumber = $_REQUEST["docnumber"];
?>
<?php
  if($patientcode != 'walkin') 
   {
 $query65= "select * from master_visitentry where patientcode='$patientcode'";
$exec65=mysql_query($query65) or die("error in query65".mysql_error());
$res65=mysql_fetch_array($exec65);
$patientname=$res65['patientfullname'];   
   }
  else
  {
$query165= "select * from resultentry_lab where docnumber= '$docnumber' ";
$exec165=mysql_query($query165) or die("error in query165".mysql_error());
$res165=mysql_fetch_array($exec165);
$patientname=$res165['patientname'];
  }

$query69="select * from master_customer where customercode='$patientcode'";
$exec69=mysql_query($query69) or die(mysql_error());
$res69=mysql_fetch_array($exec69);
$patientaccount=$res69['accountname'];

$query78="select * from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$exec78=mysql_query($query78) or die(mysql_error());
$res78=mysql_fetch_array($exec78);
$patientage=$res78['age'];
$patientgender=$res78['gender'];


$query70="select * from master_accountname where auto_number='$patientaccount'";
$exec70=mysql_query($query70);
$res70=mysql_fetch_array($exec70);
$accountname=$res70['accountname'];


				$query31="select * from resultentry_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and docnumber='$docnumber' ";
				$exec31=mysql_query($query31);
				$num=mysql_num_rows($exec31);
				$item=1;
				while($res31=mysql_fetch_array($exec31))
				{ 
				$labname1=$res31['itemname'];
				$itemcode2=$res31['itemcode'];
				$billnumber = $res31['billnumber'];


$query612 = "select * from consultation_lab where patientvisitcode= '$visitcode' and labitemcode = 

'$itemcode2' and billnumber = '$billnumber' order by auto_number desc";
$exec612 = mysql_query($query612) or die(mysql_error());
$res612 = mysql_fetch_array($exec612);
$orderedby = $res612['username'];
$patientname=$res612['patientname'];
$patientcode=$res612['patientcode'];
$accountname=$res612['accountname'];
$accountcode=$res612['accountcode'];
$doctor=$res612['doctor'];
$locationname=$res612['locationname'];
$docnumber=$res612['resultdoc'];
$samplecollectedon1=$res612['consultationdate'];
$samplecollectedon2=$res612['consultationtime'];
$samplecollectedon=$samplecollectedon1.' '.$samplecollectedon2;
//$dob = $res612['dateofbirth'];
$billdatetime = $res612['sampledatetime'];
$sampleid = $res612['sampleid'];
$res38publisheddatetime = $res612['publishdatetime'];
				
}

$query8="select * from master_employee where username = '$username' ";
$exec8=mysql_query($query8);
$num8=mysql_num_rows($exec8);
$res8=mysql_fetch_array($exec8);
$res8jobdescription=$res8['employeename'];

$query123 = "select * from samplecollection_lab where patientcode = '$patientcode' and patientname = 

'$patientname' order by auto_number desc";
$exec123 = mysql_query($query123) or die(mysql_error());
$res123 = mysql_fetch_array($exec123);
$res123recordtime=$res123['recordtime'];
$res123recorddate=$res123['recorddate'];

?>


    <page pagegroup="new" backtop="8mm" backbottom="7mm" backleft="5mm" backright="3mm">

	<table cellspacing="0" cellpadding="1" border="0">
	 <tr>
	  <td width="150" valign="top" rowspan="6">
	  <?php
		$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
		$exec3showlogo = mysql_query($query3showlogo) or die ("Error in Query3showlogo".mysql_error());
		$res3showlogo = mysql_fetch_array($exec3showlogo);
		$showlogo = $res3showlogo['showlogo'];
		if ($showlogo == 'SHOW LOGO')
		{
	  ?>
	  <img src="logofiles/<?php echo $companyanum;?>.jpg" width="65" height="65" />
	  <?php
	    }
	  ?></td> 
	  <td width="430" align="center" class="bodytext21" style="font-size:16px"><?php
			$strlen3 = strlen($address1);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address1 = ' '.$address1.' ';
			}
			?><strong><?php echo $companyname; ?></strong></td>
	  <td width="150" valign="top" rowspan="6" align="right">
	  <?php
	  $query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
	  $exec3showlogo = mysql_query($query3showlogo) or die ("Error in Query3showlogo".mysql_error());
	  $res3showlogo = mysql_fetch_array($exec3showlogo);
	  $showlogo = $res3showlogo['showlogo'];
	  if ($showlogo == 'SHOW LOGO')
	  {
	  ?>
	<!--<img src="logofiles/2.jpg" width="65" height="65" />-->
	  <?php
	  }
	  ?></td> 
	</tr>
	<tr>
	 <td width="430" align="center" class="printbodytext22" style="font-size:15px"><?php
			$address2 = $area.''.$pincode.' '.$city;
			$strlen3 = strlen($address2);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address2 = ' '.$address2.' ';
			}
			?><?php
			$address3 = "Tel: ".$phonenumber1.', '.$phonenumber2;
			$strlen3 = strlen($address3);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address3 = ' '.$address3.' ';
			}
			
			?>
			<?php echo $address2.''.$address3; ?></td>
	</tr>
	<tr>
	 <td width="430" align="center" class="bodytext23" style="font-size:13px"><?php
			//$address5 = "Fax: ".$faxnumber1;
			$strlen3 = strlen($address5);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address5 = ' '.$address5;
			}
			?>
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

			$labemail="Lab E-mail: ".$emailid1;
			$labemobile="Lab Mobile Number: ".$phonenumber1;
			$website="Website : ";

			?>
            <?php echo $address5.', '.$address4; ?>
              <?php echo '<br>'. $labemobile.'<br>'.$labemail.'<br>'; ?>
          </td>
   </tr>
   <tr>
	 <td width="430" align="center" class="bodytext24" style="font-size:13px">&nbsp;</td>
   </tr>
   <tr>
	<td width="430" align="center">&nbsp;</td>
   </tr>
   <tr>
	<td width="430" align="center" style="font-size:12px;">&nbsp;</td>
   </tr>
   <tr>
	<td colspan="3" align="center" class="bodytext26"><strong>&nbsp;</strong></td>
   </tr>
  </table>

  <table cellspacing="4" cellpadding="2" style="border-top:solid 1px #000000;border-bottom:solid 1px #000000;">
   <tr>
	<td width="35" align="left" valign="top" class="bodytext27"><strong>Patient</strong></td>
	<td width="200" align="left" valign="top" class="bodytext27"><?php echo $patientname; ?>&nbsp;<?php if

($patientcode !='') { echo '('.$patientcode.')' ; } ?></td>
	<td width="50" align="left" valign="top" class="bodytext27"><strong>Lab No</strong> </td>
	<td width="165" align="left" valign="top" class="bodytext27"><?php echo $docnumber; ?></td>
	<td width="80" align="left" valign="top" class="bodytext27"><strong>Visit Date</strong></td>
	<td width="130" align="left" valign="top" class="bodytext27"><?php echo date('Y-M-d g:i:A',strtotime

($samplecollectedon)); ?></td>
   </tr>
   <tr>
	<td width="35" align="left" valign="top" class="bodytext27"><strong>Age</strong></td>
	<td width="200" align="left" valign="top" class="bodytext27"><?php echo $patientage; ?></td>
	<td width="50" align="left" valign="top" class="bodytext27"><strong>Doctor</strong></td>
	<td width="165" align="left" valign="top" class="bodytext27"><?php echo $doctor; ?></td>
	<td width="80" align="left" valign="top" class="bodytext27"><strong>Sample Rcvd </strong></td>
	<td width="130" align="left" valign="top" class="bodytext27"><?php echo date('Y-M-d',strtotime

($res123recorddate)).' '.date('g:i:A',strtotime($res123recordtime)); ?></td>
	</tr>
	<tr>
	<td width="35" align="left" valign="top" class="bodytext27"><strong>Sex</strong></td>                
	<td width="200" align="left" valign="top" class="bodytext27"><?php echo substr($patientgender, 0, 1);?></td>
	<td width="50" align="left" valign="top" class="bodytext27"><strong>Account</strong></td>                
	<td width="165" align="left" valign="top" class="bodytext27"><?php if($accountname != ''){ echo 

$accountname; }else{ echo 'SELF'; } ?></td>	
	<td width="80" align="left" valign="top" class="bodytext27"><strong>Reported On</strong></td>
	<td width="130" align="left" valign="top" class="bodytext27"><?php echo date('Y-M-d g:i:A',strtotime

($res38publisheddatetime)); ?></td>
  </tr>
  <tr>
	<?php if($accountcode != '') { ?>
	<td width="35" align="left" valign="top" class="bodytext27"><strong>Acc No</strong></td>
	<td width="200" align="left" valign="top" class="bodytext27"><?php echo $accountcode; ?></td>
	<?php }else { ?>
	<td width="50" align="left" valign="top" class="bodytext27"><strong>&nbsp;</strong></td>
	<td width="165" align="left" valign="top" class="bodytext27"><?php //echo $area; ?></td>
	<?php } ?>	  
	<td width="50" align="left" valign="top" class="bodytext27"><strong>Area</strong></td>	
	<td width="165" align="left" valign="top" class="bodytext27"><?php echo $area12; ?></td>	
	<td width="80" align="left" valign="top" class="bodytext27"><strong>File No</strong></td>
	<td width="130" align="left" valign="top" class="bodytext27"><?php echo $fileno5; ?></td>	
   </tr>	  
</table>


				  
					
		<table width="569" border="0" cellspacing="0" cellpadding="2">
   <tr>
	<td colspan="4" align="center">&nbsp;</td>
   </tr>

	<tr>
	 <td colspan="4" align="center" valign="top" style="font-size:16px; text-

decoration:underline;"><strong>Laboratory Report</strong> </td>
	</tr>

	<tr>
	 <td width="278" align="left" valign="top" class="bodytext27">&nbsp;</td>
	 <td width="142"  align="left" valign="top" class="bodytext27">&nbsp;</td>
	 <td width="51"  align="left" valign="top" class="bodytext27">&nbsp;</td>
	 <td width="0"  align="left" valign="top" class="bodytext27">&nbsp;</td>
	 <td width="70" align="left" valign="top" class="bodytext27">&nbsp;</td>
	 <td width="171" align="left" valign="top" class="bodytext27">&nbsp;</td>
	</tr>
	<tr>
	 <td width="178" align="left" valign="top" class="bodytext27"><strong>TESTS</strong></td>
	 <td width="142"  align="left" valign="top" class="bodytext27"><strong>RESULTS</strong></td>
	 <td width="51"  align="left" valign="top" class="bodytext27"><strong>UNIT</strong></td>
	 <td width="70" align="left" valign="top" class="bodytext27"><strong>REFERANCE RANGE</strong></td>
	 <td width="171" align="left" valign="top" class="bodytext27"><strong>&nbsp;</strong></td>
	</tr>


				<?php
				$query31="select * from resultentry_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and docnumber='$docnumber' ";
				$exec31=mysql_query($query31);
				$num=mysql_num_rows($exec31);
				$item=1;
				while($res31=mysql_fetch_array($exec31))
				{ 
				$labname1=$res31['itemname'];
				$itemcode2=$res31['itemcode'];
				
				$itemname=$res31['itemname'];
				
				$referencename=$res31['referencename'];
				$referenceunit=$res31['referenceunit'];
				$referencerange=$res31['referencerange'];
				$resultvalue=$res31['resultvalue'];
				?>		  
			<tr>	
			   <td colspan="6" class="bodytext366" valign="center"  align="left" 
					bgcolor="#ffffff" nowrap="nowrap"><strong><?php if($item==1) echo $itemname;  $item++; ?></strong></td>             
				</tr>
	         <tr> 
			   <td colspan="1" class="bodytext366" valign="center"  align="left" 
				bgcolor="#ffffff"><?php echo $referencename; ?></td>             
				<td width="100" class="bodytext31" valign="center"  align="left"><?php echo $resultvalue; ?></td>              
				<td width="100" class="bodytext31" valign="center"  align="left"><?php echo $referenceunit; ?></td>              
				<td width="200" class="bodytext366" valign="center"  align="left" 
				bgcolor="#ffffff"><?php echo $referencerange; ?></td>             
			 </tr>
		
			 <?php
			 }
			 ?>
</table>
				

<table border="0" cellspacing="0" cellpadding="2">
	<tr>
	 <td colspan="6" align="left" valign="top" class="bodytext31">&nbsp;</td>
	</tr>
	<tr>
	 <td colspan="6" align="left" valign="top" class="bodytext31">&nbsp;</td>
	</tr>
	<tr>
	 <td colspan="6" align="left" valign="top" class="bodytext31">&nbsp;</td>
	</tr>
	<tr>
	 <td colspan="6" align="left" valign="top" class="bodytext31">&nbsp;</td>
	</tr>
	<tr>
	 <td colspan="6" align="left" valign="top" class="bodytext31">&nbsp;</td>
	</tr>

   <tr>
     <td width="247">REVIEWED :&nbsp;&nbsp;------------------------------</td>
     <td width="242">SIGNATURE:&nbsp;&nbsp;------------------------------</td>
     <td width="240">DATE:&nbsp;&nbsp;------------------------------</td>
   </tr>
   <tr>
     <td width="247"><strong>Quality Manager/Laboratory Director</strong></td>
     <td width="242"><strong>LAB TECHNOLOGIST</strong> </td>
     <td width="240">Printed By: <?php echo strtoupper($res8jobdescription); ?></td>
   </tr>
   <tr>
     <td width="247">Reviewed By:&nbsp;<?php echo strtoupper($res4jobdescription); ?></td>
     <td width="242">Acknowledged By:&nbsp;<?php echo strtoupper($res41jobdescription); ?></td>
     <td width="240">Printed On: <?php echo date('Y-M-d g:i:A',strtotime($updatedatetime)); ?></td>
   </tr>
   <tr>
     <td width="247">&nbsp;</td>
     <td width="242">&nbsp; </td>
     <td width="240">&nbsp;</td>
   </tr>
</table>
<table border="0" cellspacing="0" cellpadding="2" id="footer">
  <tr>
    <td width="745" align="center" valign="top" class="bodytext31">&nbsp;</td>
  </tr>
  <tr>
    <td width="745" align="center" valign="top" class="bodytext31">--------End of Report--------</td>
  </tr>
</table>
	
</page>

<?php

    $content = ob_get_clean();

    // convert in PDF
    require_once('html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
//      $html2pdf->setModeDebug();
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('printlabresult.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>