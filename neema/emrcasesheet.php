<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");

$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];

$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$dateonly1 = date("Y-m-d");
$timeonly= date("H:i:s");
$titlestr = 'SALES BILL';
$colorloopcount = '';
$sno = '';
?>

<?php
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
?>

<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext365 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext366 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
</style>

</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body>
<form name="frm" id="frmsales" method="post" action="emrcasesheet.php" onKeyDown="return disableEnterKey(event)">
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
<!--  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
-->
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="1322" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td width="1281" colspan="4" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#E0E0E0'; } else { echo 'red'; } ?>" class="bodytext3"><strong><?php echo $errmsg;?>&nbsp;</strong></td></tr>
      <tr>
        <td colspan="8"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="8" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext32"><table width="99%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="8" align="center" valign="middle"  bgcolor="#cccccc" class="bodytext32"><strong>CASE SHEET </strong></td>
                <td align="center" valign="middle"  bgcolor="#cccccc" class="style1">&nbsp;</td>
                <td align="center" valign="middle"  bgcolor="#cccccc" class="bodytext32"><span class="style1"><a target="_blank" href="sick_referral1.php?visitcode=<?php echo $visitcode; ?>">Refer</a></span></td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext32">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext32">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext32">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext32">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext32">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext32">&nbsp;</td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext32">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext32">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext32">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext32">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext32">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">&nbsp;</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext32">&nbsp;</td>
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
				$department = $res1['departmentname'];
				$age = $res1['age'];
				$gender = $res1['gender'];
				
				$query19="select * from master_triage where visitcode = '$visitcode'";
				$exec19=mysql_query($query19);
				$res19=mysql_fetch_array($exec19);
				$user = $res19['user'];
				$height = $res19['height'];
				$weight = $res19['weight'];
				$bmi = $res19['bmi'];
				$bpsystolic = $res19['bpsystolic'];
				$bpdiastolic = $res19['bpdiastolic'];
				$respiration = $res19['respiration'];
				$pulse = $res19['pulse'];
				$celsius = $res19['celsius'];
				$spo2 = $res19['spo2'];
				$intdrugs = $res19['intdrugs'];
				$dose = $res19['dose'];
				$route = $res19['route'];
			  ?>
                <td width="4%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext32"><strong>Patient</strong></td>
                <td width="20%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext32"><?php echo $patientfullname; ?>, <?php echo $age; ?>, <?php echo $gender; ?></td>
                <td width="6%" align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">Reg.No</td>
                <td width="16%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext32"><?php echo $patientcode; ?></td>
                <td width="4%" align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">Visit</td>
                <td width="14%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext32"><?php echo $visitcode; ?></td>
                <td width="4%" align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">Date</td>
                <td width="14%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext32"><?php echo $consultationdate; ?></td>
                <td width="5%" align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">Nurse</td>
                <td width="13%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext32"><?php echo strtoupper($user); ?></td>
              </tr>
            </table>			</td>
            <td class="bodytext31" valign="center" bgcolor="#E0E0E0" align="right"> 
                 <a target="_blank" href="print_emrcasesheet.php?visitcode=<?php echo $visitcode; ?>" > <img src="images/pdfdownload.jpg" width="30" height="30"></a>            </td>
			</tr>
			<tr>
            <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext32">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext32">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext32"><strong>Vitals</strong></td>
            <td align="left" class="bodytext32" colspan="7">
			<?php if($height!=0) { ?>Height(<label style="color:black;"><?php echo $height; ?>)&nbsp; </label><?php }?>
			<?php if($weight!=0) { ?>Weight(<label style="color:black;"><?php echo $weight; ?>)&nbsp; </label><?php }?>
			<?php if($bmi!=0) { ?>BMI(<label style="color:black;"><?php echo $bmi; ?>)&nbsp; </label><?php }?>
			
			<?php if($bpsystolic!=0) { ?>bp(<label style="color:black;"><?php echo $bpsystolic; ?>/</label><?php }?>

			<?php if($bpdiastolic!=0) { ?><label style="color:black;"><?php echo $bpdiastolic; ?>) </label><?php }?>
			
			<?php if($respiration!=0) { ?>Resp(<label style="color:black;"><?php echo $respiration; ?>)&nbsp; </label><?php }?>
			
			<?php if($pulse!=0) { ?>Pulse(<label style="color:black;"><?php echo $pulse; ?>)&nbsp; </label><?php }?>
			
			<?php if($celsius!=0) { ?>Celsius(<label style="color:black;"><?php echo $celsius; ?>)&nbsp; </label><?php }?>
			
			<?php if($spo2!=0) { ?>Spo2(<label style="color:black;"><?php echo $spo2; ?>)&nbsp; </label><?php }?>
			
			<?php if($height !=0 && $weight!=0 && $bmi!=0 && $bpsystolic!=0 && $bpdiastolic !=0 && $respiration !=0 && $pulse !=0 && $celsius!=0 && $spo2!=0) { echo "<br>"; } ?>
			
			<?php if($intdrugs!='') { ?>Intdrugs(<label style="color:black;"><?php echo $intdrugs; ?>)&nbsp; </label><?php }?>
			
			<?php if($dose!=0) { ?>Dose(<label style="color:black;"><?php echo $dose; ?>)&nbsp; </label><?php }?>
			
			<?php if($route!='') { ?>Route(<label style="color:black;"><?php echo $route; ?>) </label><?php }?>			</td>
          </tr>
		  <tr>
            <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext32">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext32">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
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
		  ?>
            <td width="25" align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext32"><strong>Chief Complaint </strong></td>
            <td width="43%" colspan="5" align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext32"><?php echo $complaints; ?></td>
            <td width="8%" align="left" valign="top"  bgcolor="#E0E0E0" class="style1">Medical History </td>
            <td width="40%">
			<span class="bodytext32">
					  <?php if($dm =='YES'){ ?>
				   DM (
				   <label style="color:black;"><?php echo $dm; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($cardiac =='YES'){ ?>
				   Cardiac (<label style="color:black;"><?php echo $cardiac; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($hypertension =='YES'){ ?>
				   Hypertension (<label style="color:black;"><?php echo $hypertension; ?></label>)&nbsp;
				   <?php } ?>
				   </span><span class="bodytext32">
				       <?php if($epilepsy =='YES'){ ?>
				   Epilepsy (<label style="color:black;"><?php echo $epilepsy; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($renal =='YES'){ ?>
				   Renal (<label style="color:black;"><?php echo $renal; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($respiratory =='YES'){ ?>
				   Respiratory (<label style="color:black;"><?php echo $respiratory; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($none =='YES'){ ?>
				   None (<label style="color:black;"><?php echo $none; ?></label>)&nbsp;
				   <?php } $other = trim($other);?>
				   <?php if($other !=''){ ?>
				   Other (<label style="color:black;"><?php echo $other; ?></label>)
				   <?php } ?>
			      </span>			</td>
          </tr>
          <tr>
            <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext32">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext32">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="25" align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext32"><strong>Obsterical History </strong></td>
            <td colspan="5"><span class="bodytext32">
					  <?php if($gravida !=''){ ?>
				   Gravida (<label style="color:black;"><?php echo $gravida; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($para !=''){ ?>
				   Para (<label style="color:black;"><?php echo $para; ?></label>)&nbsp;
				   <?php } ?>
				   <?php if($abortion !=''){ ?>
				   Abortion (<label style="color:black;"><?php echo $abortion; ?></label>)&nbsp;
				   <?php } ?>
				   
				    <?php if($lmp !=''){ ?>
				   LMP (<label style="color:black;"><?php echo $lmp; ?></label>)&nbsp;
				   <?php } ?>
				   
				   <?php if($edt !=''){ ?>
				   EDT (<label style="color:black;"><?php echo $edt; ?></label>)&nbsp;
				   <?php } ?>

				  </span></td>
            <td width="8%" align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext32"><strong>Surgical History</strong></td>
            <td><span class="bodytext32">
					 <?php if($surgicalhistory !=''){ ?>
				   <label style="color:black;"><?php echo $surgicalhistory; ?></label>
				   <?php } ?>
					 </span></td>
          </tr>
          <tr>
            <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext32">&nbsp;</td>
            <td colspan="5" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext32">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext32">&nbsp;</td>
          </tr>
          <tr>
            <td width="25" align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext32"><strong>Family History </strong></td>
            <td width="43%" colspan="5" align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext32">
			<span class="bodytext32">
					 <?php if($familyhistory !=''){ ?>
				   <label style="color:black;"><?php echo $familyhistory; ?></label>
				   <?php } ?>
				    </span>			</td>
            <td width="8%" align="left" valign="top"  bgcolor="#E0E0E0" class="style1">Intoxications</td>
            <td width="40%" align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext32">
			<span class="bodytext32">
					  <?php if($smoking =='YES'){ ?>
				   Smoking (
				   <label style="color:black;"><?php echo $smoking; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($alcohol =='YES'){ ?>
				   Alcohol (<label style="color:black;"><?php echo $alcohol; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($drugs =='YES'){ ?>
				   Drugs (<label style="color:black;"><?php echo $drugs; ?></label>)&nbsp;
				   <?php } ?>
				    </span>			</td>
          </tr>
          <tr>
            <td align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">&nbsp;</td>
            <td colspan="5" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext32">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext32">&nbsp;</td>
          </tr>
          <tr>
            <td width="25" align="left" valign="top"  bgcolor="#E0E0E0" class="style1">Transfusions</td>
            <td width="43%" colspan="5" align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext32">
			<label class="bodytext32">
				  <?php if($transfusionhistory !=''){ ?>
				   <label style="color:black;"><?php echo $transfusionhistory; ?></label>
				   <?php } ?></label>			</td>
			<?php if(($department == 'MCH  CONSULTATION')){?>
            <td width="8%" align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">Subsequent Visit</td>
            <td width="40%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext32"><?php if($gestationage !=''){ ?>
				   GestationAge (<label style="color:black;"><?php echo $gestationage; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($noofvisit !=''){ ?>
				   NoofVisit (<label style="color:black;"><?php echo $noofvisit; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($urinedipstict !=''){ ?>
				   Urinedipstict (<label style="color:black;"><?php echo $urinedipstict; ?></label>)&nbsp;
				   <?php } ?>   </td>
          </tr>
          <tr>
            <td align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
		  <tr>
            <td width="25" align="left" valign="top"  bgcolor="#E0E0E0" class="style1">ANC Profile</td>
            <td width="43%" colspan="5" align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext32">
			 <?php if($bloodgroup !=''){ ?>
				   BloodGroup (<label style="color:black;"><?php echo $bloodgroup; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($hblevel !=''){ ?>
				   HB Level (<label style="color:black;"><?php echo $hblevel; ?></label>)&nbsp;
				   <?php } ?>
				    <?php if($vdrl !=''){ ?>
				   VDRL (<label style="color:black;"><?php echo $vdrl; ?></label>)&nbsp;
				   <?php } ?>
				   <?php if($pmtct !=''){ ?>
				   PMTCT (<label style="color:black;"><?php echo $pmtct; ?></label>)&nbsp;
				   <?php } ?>
				   <?php if($urinalysis !=''){ ?>
				   Urinalysis (<label style="color:black;"><?php echo $urinalysis; ?></label>)&nbsp;
			  <?php } ?>			</td>
			  <?php } ?>
            <td width="8%" align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">&nbsp;</td>
            <td width="40%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext32">&nbsp;</td>
          </tr>
          </tr>
          <tr>
            <td align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <?php
		  		$query100="select * from master_consultation where patientcode='$patientcode' and patientvisitcode = '$visitcode'";
				$exec100=mysql_query($query100);
				$res100=mysql_fetch_array($exec100);
				$murphing=$res100['murphing'];
				 ?>
           <tr>
            <td align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">Murphing</td>
            
            <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext32"><?php echo $murphing; ?></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
		 
               <td width="25" align="left" valign="top"  bgcolor="#E0E0E0" class="style1">Prescription</td>
			
            <td colspan="5" align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3"><table width="99%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Medicine</strong></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">Dose</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">Freq</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">Days</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">Quantity</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">Route</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">Instructions</td>
              </tr>
			  <?php
		     $query6="select * from master_consultationpharm where patientvisitcode = '$visitcode'";
			$exec6=mysql_query($query6);
			$num6=mysql_num_rows($exec6);
			while($res6=mysql_fetch_array($exec6))
			 {
			$medicinecode = $res6['medicinecode'];
			$medicinename = $res6['medicinename'];
			$dose = $res6['dose'];
			$frequencyauto_number = $res6['frequencyauto_number'];
			$frequencycode = $res6['frequencycode'];
			$days = $res6['days'];
			$route = $res6['route'];
			$quantity = $res6['quantity'];
			$instructions = $res6['instructions'];
			$res6username = $res6['username'];
			
			$query44 = "select * from pharmacysales_details where itemcode = '$medicinecode' and visitcode='$visitcode' order by auto_number desc";
			$exec44=mysql_query($query44);
			$num44=mysql_num_rows($exec44);
			$res44=mysql_fetch_array($exec44);
			$res44username = $res44['username'];
			$quantity1 = $res44['quantity'];
			
			$query441 = "select * from pharmacysalesreturn_details where itemcode = '$medicinecode' and visitcode='$visitcode' order by auto_number desc";
			$exec441=mysql_query($query441);
			$res441=mysql_fetch_array($exec441);
			$quantity1 -= $res441['quantity'];
			if(true)
			{
		    ?>
			<tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><?php echo $medicinename.' - <strong>'.strtoupper($res44username).'</strong>'; ?></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><?php echo $dose; ?></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><?php echo $frequencycode; ?></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><?php echo $days; ?></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><?php echo $quantity; ?></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><?php echo $route; ?></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><?php echo $instructions; ?></td>
              </tr>
            <?php } } ?>
            </table>			</td>
            <td width="8%" align="left" valign="top"  bgcolor="#E0E0E0" class="style1">ICD Codes</td>
            <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext31"><table width="99%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext31"><strong>Primary Diagnosis: </strong></td>
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
                <td width="63%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext31"><?php echo $res4disease; ?></td>
                <td width="37%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext31"><?php echo $res4icdcode; ?></td>
              </tr>
			<?php } ?>  
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext31">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext31"><strong>Secondary Diagnosis: </strong></td>
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
                <td width="63%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext31"><?php echo $res5disease; ?></td>
                <td width="37%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext31"><?php echo $res5icdcode; ?></td>
              </tr>
			<?php } ?>  
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
          </tr>
         
		  
          <tr>
        
			<td width="25" align="left" valign="top"  bgcolor="#E0E0E0" class="style1">Lab Tests</td>
			
            <td colspan="5" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><?php
		    $query7="select * from consultation_lab where patientvisitcode = '$visitcode' and labrefund <> 'refunded'";
			$exec7=mysql_query($query7);
			while($res7=mysql_fetch_array($exec7))
			 {
			$labitemname = $res7['labitemname'];
			$res7username = $res7['username'];
		    ?>
			<?php echo $labitemname.' - <strong>'.strtoupper($res7username).'</strong>'; ?>
			<?php echo "<br>"; ?>
			<?php } ?></td>
          </tr>
          <tr>
            <td align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top"  bgcolor="#E0E0E0" class="style1">Radiology Tests</td>
            <td colspan="5" align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3"><?php
		    $query8="select * from consultation_radiology where patientvisitcode = '$visitcode' and radiologyrefund <> 'refunded'";
			$exec8=mysql_query($query8);
			while($res8=mysql_fetch_array($exec8))
			 {
			$radiologyitemname = $res8['radiologyitemname'];
			$res8username = $res8['username'];
		    ?>
                <?php echo $radiologyitemname.' - <strong>'.strtoupper($res8username).'</strong>'; ?>
				<?php echo "<br>"; ?>
                <?php } ?></td>
          </tr>
		   <tr>
            <td align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top"  bgcolor="#E0E0E0" class="style1">Procedures</td>
            <td colspan="5" align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3"><?php
		    $query9="select * from consultation_services where patientvisitcode = '$visitcode' and servicerefund <> 'completed'";
			$exec9=mysql_query($query9);
			while($res9=mysql_fetch_array($exec9))
			 {
			$servicesitemname = $res9['servicesitemname'];
			$res9username = $res9['username'];
		    ?>
                <?php echo $servicesitemname.' - <strong>'.strtoupper($res9username).'</strong>'; ?>; 
				<?php echo "<br>"; ?>
                <?php } ?></td>            <td width="8%" align="left" valign="top"  bgcolor="#E0E0E0" class="style1">&nbsp;</td>
            <td align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
          </tr>
		   <tr>
            <td align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            <td align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
		   <tr>
            <td align="left" valign="top"  bgcolor="#E0E0E0" class="style1">Doctor Notes</td>
            <td colspan="5" align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3">
			<?php
		    $query10="select * from master_consultationlist where visitcode = '$visitcode'";
			$exec10=mysql_query($query10);
			$num10=mysql_num_rows($exec10);
			while($res10=mysql_fetch_array($exec10))
			 { 
			   $count=1; 
			   $res10username = $res10['username'];
			   $res10consultation = $res10['consultation'];
			   $res10date = $res10['date'];
			?>			</td>
			<?php if(($count==1) && ($res10consultation != '')) { ?>
			<tr>
			  <td align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			  <td colspan="5" align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			  <tr>  
				<td align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3">Doctor : <?php echo strtoupper($res10username); ?></td>
				 <td colspan="3" align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
				<td colspan="2" align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3">Date : <?php echo $res10date; ?></td>
			</tr>
			  <tr>
			    <td align="left" valign="top"  bgcolor="#E0E0E0" class="style1">&nbsp;</td>
			    <td colspan="5" align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			   </tr>
			<?php  } ?>
			<tr>
			  <td colspan="6" align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3">
			  <?php 
			   echo $res10consultation = $res10['consultation'];
			  ?></td>
			  </tr>
		    <?php $count++; } ?>		
                
			<tr>       
			<td width="25" align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
            <td colspan="5" align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
          </tr>
		<tr>
			<td colspan="8" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
			<?php
			$query3="select * from master_consultationlist where visitcode = '$visitcode'";
			$exec3=mysql_query($query3);
			while($res3=mysql_fetch_array($exec3))
			{
			echo $consultation = $res3['templatedata'];
			echo "<br />\n";
			}
			?>			</td>
		</tr>
        </table></td>
      </tr>
		  </table>
</td>
	</tr>
  </table>   

</form>
<?php include ("includes/footer1.php"); ?>

</body>
</html>