<?php
require_once('html2pdf/html2pdf.class.php');
ob_start();
session_start();
include ("includes/loginverify.php");
include ("db/db_connectemr.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$colorloopcount = '';
$sno = '';

if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
?>
<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; 
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; 
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
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C;  }
</style>

<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td width="100%" valign="top">
	  <table width="58%" border="0">
  <tr>
  <?php 
$query2 = "select * from master_company where auto_number = '$companyanum'";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$companyname = $res2["companyname"];
?>
    <td colspan="9" align="center" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">
	        <?php
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
  <tr>
    <td colspan="9" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="9" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><div align="center"><strong><u>CASE SHEET</u></strong></div></td>
    </tr>
  <tr>
    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
    <td colspan="8" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
  </tr>
  
  <tr>
	<?php
	$query1="select * from master_visitentry where visitcode = '$visitcode'";
	$exec1=mysql_query($query1);
	$res1=mysql_fetch_array($exec1);
	$patientfullname = $res1['patientfullname'];
	$patientfullname = strtoupper($patientfullname);
	$patientcode = $res1['patientcode'];
	$consultationdate = $res1['consultationdate'];
	$username = $res1['username'];
	$department = $res1['departmentname'];
	$age = $res1['age'];
	$gender = $res1['gender'];
	
	$query19="select * from master_triage where visitcode = '$visitcode'";
	$exec19=mysql_query($query19);
	$res19=mysql_fetch_array($exec19);
	$user = $res19['user'];
	?>
    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>Patient</strong></td>
		<td colspan="8" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><?php echo $patientfullname; ?>, <?php echo $age; ?>, <?php echo $gender; ?></td>
    </tr>
  <tr>
    <td colspan="9" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
    </tr>
  <tr>
    <td width="80" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>Reg.No</strong></td>
    <td width="80" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><?php echo $patientcode; ?></td>
    <td width="70" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>Visit</strong></td>
    <td width="70" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><?php echo $visitcode; ?></td>
    <td width="70" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>Date</strong></td>
    <td width="70" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><?php echo $consultationdate; ?></td>
	<td width="70" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>Nurse</strong></td>
    <td width="150" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><?php echo strtoupper($user); ?></td>
    </tr>
  <tr>
    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
    <td colspan="7" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
  </tr>
  <?php
			$query2="select * from master_triage where visitcode = '$visitcode'";
			$exec2=mysql_query($query2);
			$res2=mysql_fetch_array($exec2);
			$complaints = $res2['complanits'];
			$dm = $res2['dm'];
					if($dm == '1')
					{
					$dm = 'YES';
					}
					else
					{
					$dm = '';
					}
					$cardiac = $res2['cardiac'];
					if($cardiac == '1')
					{
					$cardiac = 'YES';
					}
					else
					{
					$cardiac = '';
					}
					$hypertension = $res2['hypertension'];
					if($hypertension == '1')
					{
					$hypertension = 'YES';
					}
					else
					{
					$hypertension = '';
					}
					$epilepsy = $res2['epilepsy'];
					if($epilepsy == '1')
					{
					$epilepsy = 'YES';
					}
					else
					{
					$epilepsy = '';
					}
					$respiratory = $res2['respiratory'];
					if($respiratory == '1')
					{
					$respiratory = 'YES';
					}
					else
					{
					$respiratory = '';
					}
					$renal = $res2['renal'];
					if($renal == '1')
					{
					$renal = 'YES';
					}
					else
					{
					$renal = '';
					}
					$none = $res2['none'];
					if($none == '1')
					{
					$none = 'YES';
					}
					else
					{
					$none = '';
					}
					$other = $res2['other'];
					$triagedate = $res2['registrationdate'];
					$triageuser = $res2['user'];
					$smoking = $res2['smoking'];
					if($smoking == '1')
					{
					$smoking = 'YES';
					}
					else
					{
					$smoking = '';
					}
					$alcohol = $res2['alcohol'];
					if($alcohol == '1')
					{
					$alcohol = 'YES';
					}
					else
					{
					$alcohol = '';
					}
					$drugs = $res2['drugs'];
					if($drugs == '1')
					{
					$drugs = 'YES';
					}
					else
					{
					$drugs = '';
					}
					$gravida = $res2['gravida'];
					$para = $res2['para'];
					$abortion = $res2['abortion'];
					$familyhistory = $res2['familyhistory'];
					$surgicalhistory = $res2['surgicalhistory'];
					$transfusionhistory = $res2['transfusionhistory'];
					$lmp = $res2['lmp'];
					$edt = $res2['edt'];
					$bloodgroup = $res2['bloodgroup'];
					$hblevel = $res2['hblevel'];
					$vdrl = $res2['vdrl'];
					$pmtct = $res2['pmtct'];
					$urinalysis = $res2['urinalysis'];
					$gestationage = $res2['gestationage'];
					$noofvisit = $res2['noofvisit'];
					$urinedipstict = $res2['urinedipstict'];
					$height = $res2['height'];
					$weight = $res2['weight'];
					$bmi = $res2['bmi'];
					$bpsystolic = $res2['bpsystolic'];
					$bpdiastolic = $res2['bpdiastolic'];
					$respiration = $res2['respiration'];
					$pulse = $res2['pulse'];
					$celsius = $res2['celsius'];
					$spo2 = $res2['spo2'];
					$intdrugs = $res2['intdrugs'];
					$dose = $res2['dose'];
					$route = $res2['route'];
		  ?>
  <tr>
    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>Vitals</strong></td>

    <td colspan="7" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">
	  <?php if($height!=0) { ?>Height(<label style="color:black;"><?php echo $height; ?>)&nbsp; </label><?php }?>
		<?php if($weight!=0) { ?>Weight(<label style="color:black;"><?php echo $weight; ?>)&nbsp; </label><?php }?>
		<?php if($bmi!=0) { ?>BMI(<label style="color:black;"><?php echo $bmi; ?>)&nbsp; </label><?php }?>
		
		<?php if($bpsystolic!=0) { ?>bp(<label style="color:black;"><?php echo $bpsystolic; ?>/</label><?php }?>
		
		<?php if($bpdiastolic!=0) { ?><label style="color:black;"><?php echo $bpdiastolic; ?>) </label><?php }?>
		
		<?php if($respiration!=0) { ?>Resp(<label style="color:black;"><?php echo $respiration; ?>)&nbsp; </label><?php }?>
		
		<?php if($pulse!=0) { ?>Pulse(<label style="color:black;"><?php echo $pulse; ?>)&nbsp; </label><?php }?>
		
		<?php if($celsius!=0) { ?>Celsius(<label style="color:black;"><?php echo $celsius; ?>)&nbsp; </label><?php }?>
		
		<?php if($spo2!=0) { ?>Spo2(<label style="color:black;"><?php echo $spo2; ?>)&nbsp; </label><?php }?>
		
		<?php if($intdrugs!='') { ?>Intdrugs(<label style="color:black;"><?php echo $intdrugs; ?>)&nbsp; </label><?php }?>
		
		<?php if($height !=0 && $weight !=0 && $bmi !=0 && $bpsystolic !=0 && $bpdiastolic !=0 && $respiration !=0 && $pulse !=0 && $celsius!=0 && $spo2!=0 && $intdrugs!='')
		      { echo "<br>"; } ?>
		
		<?php if($dose!=0) { ?>Dose(<label style="color:black;"><?php echo $dose; ?>)&nbsp; </label><?php }?>
		
		<?php if($route!='') { ?>Route(<label style="color:black;"><?php echo $route; ?>) </label><?php }?>	</td>
  </tr>
  <tr>
    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
    <td colspan="7" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>Chief Complaint </strong></td>
    <td colspan="7" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><?php echo wordwrap($complaints,130,"<br>\n"); ?></td>
  </tr>
  <tr>
    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
    <td colspan="7" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><span class="style1">Medical History </span></td>
    <td colspan="7" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">
      <?php if($dm =='YES'){ ?>
DM (
<label style="color:black;"><?php echo $dm; ?></label>
)&nbsp;
<?php } ?>
<?php if($cardiac =='YES'){ ?>
Cardiac (
<label style="color:black;"><?php echo $cardiac; ?></label>
)&nbsp;
<?php } ?>
<?php if($hypertension =='YES'){ ?>
Hypertension (
<label style="color:black;"><?php echo $hypertension; ?></label>
)&nbsp;
<?php } ?>
<?php if($epilepsy =='YES'){ ?>
Epilepsy (
<label style="color:black;"><?php echo $epilepsy; ?></label>
)&nbsp;
<?php } ?>
<?php if($renal =='YES'){ ?>
Renal (
<label style="color:black;"><?php echo $renal; ?></label>
)&nbsp;
<?php } ?>
<?php if($respiratory =='YES'){ ?>
Respiratory (
<label style="color:black;"><?php echo $respiratory; ?></label>
)&nbsp;
<?php } ?>

<?php if($dm !='' && $cardiac !='' && $hypertension !='' && $epilepsy !='' && $renal !='' && $respiratory !='') { echo "<br>"; } ?>

<?php if($none =='YES'){ ?>
None (
<label style="color:black;"><?php echo $none; ?></label>
)&nbsp;
<?php } $other = trim($other); ?>
<?php if($other !=''){ ?>
Other (
<label style="color:black;"><?php echo $other; ?></label>
)
<?php } ?>
   </td>
  </tr>
  <tr>
    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
    <td colspan="7" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>Obsterical History </strong><br /></td>
    <td colspan="7" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><?php if($gravida !=''){ ?>
Gravida (
  <label ><?php echo $gravida; ?></label>
  )&nbsp;
  <?php } ?>
  <?php if($para !=''){ ?>
Para (
<label ><?php echo $para; ?></label>
)&nbsp;
<?php } ?>
<?php if($abortion !=''){ ?>
Abortion (
<label ><?php echo $abortion; ?></label>
)&nbsp;
<?php } ?>
<?php if($lmp !=''){ ?>
LMP (
<label><?php echo $lmp; ?></label>
)&nbsp;
<?php } ?>
<?php if($edt !=''){ ?>
EDT (
<label><?php echo $edt; ?></label>
)&nbsp;
<?php } ?></td>
  </tr>
  <tr>
    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
    <td colspan="7" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>Surgical History</strong></td>
    <td colspan="7" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><?php if($surgicalhistory !=''){ ?>
      <label><?php echo $surgicalhistory; ?></label>
      &nbsp;
      <?php } ?></td>
  </tr>
  <tr>
    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
    <td colspan="7" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong>Family History </strong></td>
    <td colspan="7" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><?php if($familyhistory !=''){ ?>
      <label ><?php echo $familyhistory; ?></label>
      <?php } ?></td>
  </tr>
  <tr>
    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
    <td colspan="7" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><span class="style1">Intoxications</span></td>
    <td colspan="7" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><?php if($smoking =='YES'){ ?>
Smoking (
  <label ><?php echo $smoking; ?></label>
  )&nbsp;
  <?php } ?>
  <?php if($alcohol =='YES'){ ?>
Alcohol (
<label ><?php echo $alcohol; ?></label>
)&nbsp;
<?php } ?>
<?php if($drugs =='YES'){ ?>
Drugs (
<label ><?php echo $drugs; ?></label>
)&nbsp;
<?php } ?></td>
  </tr>
  <tr>
    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
    <td colspan="7" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><span class="style1">Transfusions</span></td>
    <td colspan="7" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><?php if($transfusionhistory !=''){ ?>
      <label ><?php echo $transfusionhistory; ?></label>
      <?php } ?></td>
  </tr>
  <tr>
    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
    <td colspan="7" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><span class="style1">ANC Profile</span></td>
    <td colspan="7" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><?php if($bloodgroup !=''){ ?>
BloodGroup (
  <label style="color:black;"><?php echo $bloodgroup; ?></label>
  )&nbsp;
  <?php } ?>
  <?php if($hblevel !=''){ ?>
HB Level (
<label style="color:black;"><?php echo $hblevel; ?></label>
)&nbsp;
<?php } ?>
<?php if($vdrl !=''){ ?>
VDRL (
<label style="color:black;"><?php echo $vdrl; ?></label>
)&nbsp;
<?php } ?>
<?php if($pmtct !=''){ ?>
PMTCT (
<label style="color:black;"><?php echo $pmtct; ?></label>
)&nbsp;
<?php } ?>
<?php if($urinalysis !=''){ ?>
Urinalysis (
<label style="color:black;"><?php echo $urinalysis; ?></label>
)&nbsp;
<?php } ?></td>
  </tr>
  <tr>
    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
    <td colspan="7" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><span class="style1">Subsequent Visit</span></td>
    <td colspan="7" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><?php if($gestationage !=''){ ?>
GestationAge (
  <label style="color:black;"><?php echo $gestationage; ?></label>
  )&nbsp;
  <?php } ?>
  <?php if($noofvisit !=''){ ?>
NoofVisit (
<label style="color:black;"><?php echo $noofvisit; ?></label>
)&nbsp;
<?php } ?>
<?php if($urinedipstict !=''){ ?>
Urinedipstict (
<label style="color:black;"><?php echo $urinedipstict; ?></label>
)&nbsp;
<?php } ?></td>
  </tr>
  <tr>
    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
    <td colspan="7" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
  </tr>
        <tr>
			<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><span class="style1">Medical Notes</span></td>
	     </tr> 		
		<?php
		$query3="select * from master_consultationlist where visitcode = '$visitcode'";
		$exec3=mysql_query($query3);
		while($res3=mysql_fetch_array($exec3))
			 { 
			   $count=1; 
			   $res3username = $res3['username'];
			   $res3consultation = $res3['consultation'];
			   $res3date = $res3['date'];
		       $res3consultation = $res3['consultation'];
		?>
		<?php if(($count==1) && ($res3consultation != '')) { ?>
		 <tr>
			<td colspan="8" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
	     </tr> 	
		<tr>
		    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong><?php echo strtoupper($res3username); ?></strong></td>
			<td colspan="7" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><strong><?php echo $res3date; ?></strong></td>
		</tr>
		<?php } ?>
		<tr>
		    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
			<td width="400" colspan="7" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><?php echo $res3consultation; ?></td>
		</tr>
  	 <?php  }?>
      
  <tr>
    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
    <td colspan="7" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><span class="style1">ICD Codes</span></td>
    <td colspan="7" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><table width="99%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="2" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext31"><strong>Primary Diagnosis: </strong></td>
      </tr>
      <?php
		    $query4="select * from consultation_icd where patientvisitcode = '$visitcode'";
			$exec4=mysql_query($query4);
			while($res4=mysql_fetch_array($exec4))
			 {
			$res4disease = $res4['primarydiag'];
			$res4icdcode = $res4['primaryicdcode'];
			?>
      <tr>
        <td width="73%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext31"><?php echo $res4disease; ?></td>
        <td width="27%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext31"><?php echo $res4icdcode; ?></td>
      </tr>
      <?php } ?>
      <tr>
        <td colspan="2" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext31"><strong>Secondary Diagnosis: </strong></td>
      </tr>
      <?php
		    $query5="select * from consultation_icd where patientvisitcode = '$visitcode'";
			$exec5=mysql_query($query5);
			while($res5=mysql_fetch_array($exec5))
			 {
			$res5disease = $res5['secondarydiag'];
			$res5icdcode = $res5['secicdcode'];
			?>
      <tr>
        <td width="73%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext31"><?php echo $res5disease; ?></td>
        <td width="27%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext31"><?php echo $res5icdcode; ?></td>
      </tr>
      <?php } ?>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
    <td colspan="7" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><span class="style1">Prescription</span></td>
    <td colspan="7" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><table width="101%" border="0" cellspacing="2" cellpadding="6">
      <tr>
        <td width="23%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Medicine</strong></td>
        <td width="11%" align="left" valign="middle"  bgcolor="#FFFFFF" class="style1">Dose</td>
        <td width="11%" align="left" valign="middle"  bgcolor="#FFFFFF" class="style1">Freq</td>
        <td width="7%" align="center" valign="middle"  bgcolor="#FFFFFF" class="style1">Days</td>
        <td width="12%" align="center" valign="middle"  bgcolor="#FFFFFF" class="style1">Quantity</td>
        <td width="11%" align="left" valign="middle"  bgcolor="#FFFFFF" class="style1">Route</td>
        <td width="25%" align="left" valign="middle"  bgcolor="#FFFFFF" class="style1">Instructions</td>
      </tr>
      <?php
		    $query6="select * from master_consultationpharm where patientvisitcode = '$visitcode'";
			$exec6=mysql_query($query6);
			while($res6=mysql_fetch_array($exec6))
			 {
			$medicinename = $res6['medicinename'];
			$dose = $res6['dose'];
			$frequencyauto_number = $res6['frequencyauto_number'];
			$frequencycode = $res6['frequencycode'];
			$days = $res6['days'];
			$route = $res6['route'];
			$quantity = $res6['quantity'];
			$instructions = $res6['instructions'];
		    ?>
      <tr>
        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><?php echo $medicinename; ?></td>
        <td align="center" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><?php echo $dose; ?></td>
        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><?php echo $frequencycode; ?></td>
        <td align="center" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><?php echo $days; ?></td>
        <td align="center" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><?php echo $quantity; ?></td>
        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><?php echo $route; ?></td>
        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><?php echo $instructions; ?></td>
      </tr>
      <?php } ?>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
    <td colspan="7" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><span class="style1">Lab Tests</span></td>
    <td colspan="7" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">
      <?php
		    $query7="select * from consultation_lab where patientvisitcode = '$visitcode'";
			$exec7=mysql_query($query7);
			while($res7=mysql_fetch_array($exec7))
			 {
			$labitemname = $res7['labitemname'];
		    ?>
      <?php echo $labitemname; ?> <?php echo "<br>"; ?>
      <?php } ?>
    	</td>
  </tr>
  <tr>
    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
    <td colspan="7" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><span class="style1">Radiology Tests</span></td>
    <td colspan="7" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">
      <?php
		    $query8="select * from consultation_radiology where patientvisitcode = '$visitcode'";
			$exec8=mysql_query($query8);
			while($res8=mysql_fetch_array($exec8))
			 {
			$radiologyitemname = $res8['radiologyitemname'];
		    ?>
      <?php echo $radiologyitemname.'<br>'; ?> 
      <?php } ?>
    </td>
  </tr>
  <tr>
    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
    <td colspan="7" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><span class="style1">Procedures</span></td>
    <td colspan="7" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><span class="bodytext3">
      <?php
		    $query9="select * from consultation_services where patientvisitcode = '$visitcode'";
			$exec9=mysql_query($query9);
			while($res9=mysql_fetch_array($exec9))
			 {
			$servicesitemname = $res9['servicesitemname'];
		    ?>
      <?php echo $servicesitemname; ?> <?php echo "<br>"; ?>
      <?php } ?>
    </span></td>
    </tr>
  <tr>
    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
    <td colspan="7" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32">&nbsp;</td>
  </tr>
		<?php
		$query44="select * from master_consultationlist where visitcode = '$visitcode'";
		$exec44=mysql_query($query44) or die ("Error in Query44".mysql_error());;
		while($res44=mysql_fetch_array($exec44))
		{
		$res44templatedata = $res44['templatedata'];
		?>	
  <tr>
    <td colspan="8" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext32"><?php echo $res44templatedata; ?></td>
    </tr>
  <?php } ?> 
</table>

	</td>
  </tr>
</table>   
<?php

    $content = ob_get_clean();

    // convert in PDF
    require_once('html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
		$html2pdf->setDefaultFont('Arial');
//      $html2pdf->setModeDebug();
        //$html2pdf->SetMargins('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('casesheet.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>
