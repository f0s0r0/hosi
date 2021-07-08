<?php
session_start();
error_reporting(0);
include ("db/db_connect.php");
//include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");

$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$dateonly1 = date("Y-m-d");
$timeonly= date("H:i:s");
$colorloopcount = '';
$sno = '';
$pagebreak = '';

ob_start();

if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode= $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if (isset($_REQUEST["ADate1"])) { $fromdate = $_REQUEST["ADate1"]; } else { $fromdate = ""; }
if (isset($_REQUEST["ADate2"])) { $todate = $_REQUEST["ADate2"]; } else { $todate = ""; }
if (isset($_REQUEST["billnumber"])) { $billnumber = $_REQUEST["billnumber"]; } else { $billnumber = ""; }

$query166= "select * from consultation_lab where billnumber= '$billnumber'";
$exec166=mysql_query($query166) or die("error in query166".mysql_error());
$res166=mysql_fetch_array($exec166);
$res166patientname=$res166['patientname'];

$query167 = "select * from billing_external where billno='$billnumber'";
$exec167 = mysql_query($query167) or die(mysql_error());
$res167 = mysql_fetch_array($exec167);
$age = $res167['age'];
$gender = $res167['gender'];

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
?>


	<table width="750" border="0" cellspacing="0" cellpadding="2">
	<?php
		$pagecount='';
		$query38="select * from consultation_lab where patientcode = 'walkin' and patientvisitcode = 'walkinvis' and billnumber='$billnumber' group by labitemcode order by auto_number desc ";
		$exec38=mysql_query($query38);
		$num38=mysql_num_rows($exec38);
		while($res38=mysql_fetch_array($exec38))
		{ 
		$res38itemcode=$res38['labitemcode'];
		$res38itemname=$res38['labitemname']; 
		$res38resultdoc=$res38['resultdoc'];
		
		$query321="select * from resultentry_lab where patientcode = 'walkin' and patientvisitcode = 'walkinvis' and docnumber='$res38resultdoc' and itemcode='$res38itemcode' and resultstatus='completed'";
		$exec321=mysql_query($query321) or die(mysql_error());
		$res321=mysql_fetch_array($exec321);
		$date1=$res321['recorddate'];
		$date1=date("d-m-Y",strtotime($date1));
		$time1=$res321['recordtime'];
		
		if($res38itemcode!='')
		{
		$pagecount++;
		?>
	<tr>
			 <td rowspan="3" align="left">
      <?php
			$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
			$exec3showlogo = mysql_query($query3showlogo) or die ("Error in Query3showlogo".mysql_error());
			$res3showlogo = mysql_fetch_array($exec3showlogo);
			$showlogo = $res3showlogo['showlogo'];
			if ($showlogo == 'SHOW LOGO')
			{
			?>
      <img src="logofiles/<?php echo $companyanum;?>.jpg" width="100" height="75" />      <?php
			}
	?></td>
			<td colspan="3" align="left">
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
			<strong><?php echo $companyname; ?></strong></td>
	  </tr>
		<tr>
			<td colspan="3" align="left">
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
		</tr>	
		<tr>
		  <td colspan="3" align="left"><strong><?php echo "E-Mail :".$emailid1; ?></strong></td>
		</tr>
		<tr>
		  <td width="729" colspan="4" style="border-bottom:1px solid black;">&nbsp;</td>
	    </tr>
		
		<tr>
		  <td width="729" colspan="4">&nbsp;</td>
	    </tr>
		<tr>
			<td width="100"><strong>Patient</strong></td>
			<td width="363" align="left" valign="middle"><?php echo $res166patientname; ?></td>
			<td width="60"><strong>Date</strong></td>
			
		  <td width="206" ><?php echo $date1.' '.$time1; ?></td>
          
		</tr>

		<tr>
					
					 <td width="100" align="left" valign="top" nowrap="nowrap"><strong>Patient Code</strong></td>
					<td width="363" align="left" valign="top"><?php echo 'walkin'; ?></td>
					
					<td width="60" align="left" valign="top"><strong>Age</strong></td>
					<td width="206" align="left" valign="top"><?php echo $age; ?></td>                
	  </tr>
		<tr>
		  <td width="100" align="left" valign="top" nowrap="nowrap"><strong>Visit Code</strong></td>
		  <td width="363" align="left" valign="top"><?php echo 'walkinvis'; ?></td>
		  <td width="60" align="left" valign="top"><strong>Gender</strong></td>
		  <td width="206" align="left" valign="top"><?php echo $gender; ?></td>
	  </tr>
	<tr>
		<td  width="100" align="left" valign="top"><strong>&nbsp;</strong></td>
		<td width="363" align="left" valign="top" >&nbsp;</td>
		<td width="60" align="left" valign="top"><strong>&nbsp;</strong></td>                
		<td width="206" align="left" valign="top">&nbsp;<?php //echo $accountname; ?></td>	
	</tr>
		
		
	<tr>
		  <td width="734" colspan="5" style="border-bottom:1px solid black;">&nbsp;</td>
	    </tr>
		<tr>
		  <td colspan="4" align="left" valign="middle" nowrap="nowrap">
		  <table width="733" border="0">
            
			
            <tr>
				<td width="260" align="left" valign="middle"><strong>Test</strong></td>
				<td width="222" align="left" valign="middle"><strong>Results</strong></td>
					<td width="238"  align="left" valign="middle"><strong>Reference</strong></td>
	        </tr>
		            <?php
		 $query31="select * from consultation_lab where billnumber= '$billnumber' and patientcode = 'walkin' and patientvisitcode = 'walkinvis' and labitemcode='$res38itemcode' group by labitemcode order by auto_number desc  ";
				$exec31=mysql_query($query31);
				$num31=mysql_num_rows($exec31);
				while($res31=mysql_fetch_array($exec31))
				{ 
				  $itemcode=$res31['labitemcode'];
				  $itemname=$res31['labitemname'];
				  $docnumber=$res31['billnumber'];
				  $resultdoc=$res31['resultdoc'];
			 ?>		  
		
					<tr>
					<td align="left" valign="middle"><strong><?php echo $itemname; ?></strong></td>
					<td align="left" valign="middle">&nbsp;</td>
					<td align="left" valign="middle">&nbsp;</td>
					</tr>
				  
				<?php  
				$query32="select * from resultentry_lab where patientcode = 'walkin' and patientvisitcode = 'walkinvis' and billnumber='$docnumber' and itemcode='$itemcode' and resultstatus='completed'";
				$exec32=mysql_query($query32);
				$num32=mysql_num_rows($exec32);
				while($res32=mysql_fetch_array($exec32))
				 {
					$referencename=$res32['referencename'];
					
					$query23 = "select * from master_lab where referencename='$referencename' and itemcode='$itemcode' and status <> 'deleted'";
					$exc23 = mysql_query($query23) or die(mysql_error());
					$res23 = mysql_fetch_array($exc23);
					$referenceunit = $res23['referenceunit'];
					$referenceunit = htmlentities($referenceunit);
					$referencerange=$res23['referencerange'];
					$referencerange = htmlentities($referencerange);
					$resultvalue=$res32['resultvalue'];
					$resultvalue = htmlentities($resultvalue);
					$resultenteredby=$res32['username'];
			    ?>
				<tr>
				<td align="left" valign="middle"><?php echo $referencename; ?></td>
				<td align="left" valign="middle" width="209"><?php echo $resultvalue.' '.$referenceunit; ?></td>
				<td align="left" valign="middle" width="254"><?php echo $referencerange; ?></td>
				</tr>
				<?php 		
				  }
				?>
				 <?php
				  
				}
				  ?>
				  <tr>
					<td align="left" valign="middle">&nbsp;</td>
					<td align="left" valign="middle">&nbsp;</td>
					</tr>
				   <tr>
					<td align="left" valign="middle"><strong>Technician : <?php echo strtoupper($resultenteredby); ?></strong></td>
					</tr>
					 <tr>
					<td align="left" valign="middle">&nbsp;</td>
					</tr>
					 <tr>
					<td align="left" valign="middle">&nbsp;</td>
					</tr>
					 <tr>
					<td align="left" valign="middle"><strong>Sign : .............................................</strong></td>
					<td align="left" valign="middle"><strong></strong></td>
					<td align="left" valign="middle"><strong>Printed On : <?php echo $indiandatetime; ?></strong></td>					
					</tr>
          </table>		  </td>
		    <?php 
					if($pagecount < $num38)
					{
					?> 
					<tr>
					<td>
					<br /><br /><br /><br /><br />
					<br /><br /><br />
						<br /><br /><br />
					<br /><br /><br />	<br /><br /><br />
					<br /><br /><br />	<br /><br /><br />
					<br /><br /><br />	<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
					<br /><br /><br /><br /><br /><br /><br /><br />
					<br /><br /><br /><br /><br /><br /><br /><br /><br />					</td>
					</tr>
				<?php }
				 ?>	
	  </tr>
	 
	<tr><td>&nbsp;</td></tr>
	 <?php } }?> 
</table>

		<!--<tr>
			<td align="left" valign="middle" class="bodytext32">Results Posted By:
			<input type="hidden" name="user" id="user" size="5" style="border: 1px solid #001E6A" value="<?php echo $_SESSION['username']; ?>" readonly="readonly"><strong><?php //echo strtoupper($_SESSION['username']); ?></strong></td>
		</tr>-->
	
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
        $html2pdf->Output('LabResultExternal.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>
