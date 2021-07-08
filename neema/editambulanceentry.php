<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$companyname = $_SESSION["companyname"];
$transactiondatefrom = date('Y-m-d');

if (isset($_REQUEST["anum"])) { $companyanum = $_REQUEST["anum"]; } else { $companyanum = ""; }
if (isset($_REQUEST["docno"])) { $docno = $_REQUEST["docno"]; } else { $docno = ""; }
if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if ($frmflag1 == "frmflag1")
{
	
	
	
	
	
	$docno = $_REQUEST["docno"];
	$patientcode = $_REQUEST["patientcode"];
	$visitcode = $_REQUEST["visitcode"];
	$ptaddress = $_REQUEST["ptaddress"];
	$caller = $_REQUEST["caller"];
	$ptphoneno = $_REQUEST["ptphoneno"];
	$ccomplaint = $_REQUEST["ccomplaint"];
	$analocation = $_REQUEST["analocation"];
	$syslocation = $_REQUEST["syslocation"];
	$medication = $_REQUEST["medication"];
	$allergies = $_REQUEST["allergies"];
	$medadmby = $_REQUEST["medadmby"];
	$diagnosis = $_REQUEST["diagnosis"];
	$origfacility = $_REQUEST["origfacility"];
	$destfacility = $_REQUEST["destfacility"];
	$typedestination = $_REQUEST["typedestination"];
	$treatment = $_REQUEST["treatment"];
	$procedures = $_REQUEST["procedures"];
	$rescue = $_REQUEST["rescue"];
	$receivenurse = $_REQUEST["receivenurse"];
	$destfacility1 = $_REQUEST["destfacility1"];
	$timeout = $_REQUEST["timeout"];
	$timein = $_REQUEST["timein"];
	$pcrno = $_REQUEST["pcrno"];
	
	$ambulancereg = $_REQUEST["ambulancereg"];
	$operator = $_REQUEST["operator"];
	$nurse = $_REQUEST["nurse"];
	$incidentdate = $_REQUEST["incidentdate"];
	$pcrno2 = $_REQUEST["pcrno2"];
	$unitnum = $_REQUEST["unitnum"];
	$ambulancereg1 = $_REQUEST["ambulancereg1"];
	$patientdispose = $_REQUEST["patientdispose"];
	$incidentaddress = $_REQUEST["incidentaddress"];
	$responsemode = $_REQUEST["responsemode"];
	$responsemodefromscene = $_REQUEST["responsemodefromscene"];
	$timeunotified = $_REQUEST["timeunotified"];
	$begodometer = $_REQUEST["begodometer"];
	$timeuarrived = $_REQUEST["timeuarrived"];
	$onsceneodometer = $_REQUEST["onsceneodometer"];
	$timeuleft = $_REQUEST["timeuleft"];
	$ptdestodometer = $_REQUEST["ptdestodometer"];
	$timeparrived = $_REQUEST["timeparrived"];
	$endingodometer = $_REQUEST["endingodometer"];
	$timeunitback = $_REQUEST["timeunitback"];
	$totalkm = $_REQUEST["totalkm"];
	$servicereq = $_REQUEST["servicereq"];
	$payment = $_REQUEST["payment"];
	$amount = $_REQUEST["amount"];
	$extbillno = $_REQUEST["extbillno"];
	
	
	
	 $query5="update ambulancep set  ptaddress='$ptaddress',caller='$caller',ptphoneno='$ptphoneno',ccomplaint='$ccomplaint', analocation='$analocation',syslocation='$syslocation',medication='$medication',allergies='$allergies',medadmby='$medadmby',diagnosis='$diagnosis',origfacility='$origfacility',destfacility='$destfacility',typedestination='$typedestination',treatment='$treatment',procedures='$procedures',rescue='$rescue',receivenurse='$receivenurse',destfacility1='$destfacility1',timeout='$timeout',timein='$timein',pcrno='$pcrno',recorddate='$updatedatetime',username='$username'  where  docno='$docno'"; 
	$exec5 = mysql_query($query5) or die("Query5".mysql_error());
	
		
	
	 $query6 ="update  ambulanceinc set docno='$docno',patientcode='$patientcode',visitcode='$visitcode', ambulancereg='$ambulancereg',operator='$operator',nurse='$nurse',incidentdate='$incidentdate',pcrno2='$pcrno2',unitnum='$unitnum',ambulancereg1='$ambulancereg1',patientdispose='$patientdispose',incidentaddress='$incidentaddress',responsemode='$responsemode',responsemodefromscene='$responsemodefromscene',timeunotified='$timeunotified',begodometer='$begodometer',timeuarrived='$timeuarrived',onsceneodometer='$onsceneodometer',timeuleft='$timeuleft',ptdestodometer='$ptdestodometer',timeparrived='$timeparrived',endingodometer='$endingodometer',timeunitback='$timeunitback',totalkm='$totalkm',servicereq='$servicereq',payment='$payment',amount='$amount',recorddate='$updatedatetime',username='$username' where docno='$docno'";
	
	
	$exec6 = mysql_query($query6) or die("Query6".mysql_error());
	
   	header("location:editambulancelist.php");

}
?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>

<link href="css/jquery.timepicker.css" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.11.1.min.js"></script> 
<script src="js/datetimepicker_css.js"></script> 
<script src="js/jquery.timepicker.js"></script>

<script>
function disableEnterKey()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
	
	var key;
	if(window.event)
	{
		key = window.event.keyCode;     //IE
	}
	else
	{
		key = e.which;     //firefox
	}
	
	if(key == 13) // if enter key press
	{
		//alert ("Enter Key Press2");
		return false;
	}
	else
	{
		return true;
	}
}

function from1submit1()
{
	if (document.form1.companyname.value == "")
	{
		alert ("Hospital Name Cannot Be Empty.");
		document.form1.companyname.focus();
		return false;
	}
	else if (document.form1.city.value == "")
	{
		//alert ("City Cannot Be Empty.");
		//document.form1.city.focus();
		//return false;
	}
}

function validatenumerics(key) 
{
           //getting key code of pressed key
           var keycode = (key.which) ? key.which : key.keyCode;
           //comparing pressed keycodes

           if (keycode > 31 && (keycode < 48 || keycode > 57)) {
               //alert(" You can enter only characters 0 to 9 ");
               return false;
           }
           else return true;
}
</script>

<script src="js/datetimepicker_css.js"></script>

<?php
if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if (isset($_REQUEST["billnumber"])) { $billnumber1 = $_REQUEST["billnumber"]; } else { $billnumber1 = ""; }

if($billnumber1!='')
{
			$query11="select * from billing_external where billno='$billnumber1'";
			$exec11=mysql_query($query11) or die(mysql_error());
			$res11=mysql_fetch_array($exec11);
			$patientname=$res11['patientname'];
			$age=$res11['age'];
			$gender=$res11['gender'];
			$mobilenumber='';

}
else
{

		  $query10 = "select * from master_customer where customercode='$patientcode'";
		 $exec10 = mysql_query($query10) or die(mysql_error());
		 $rows10=mysql_num_rows($exec10);
		 $res10 = mysql_fetch_array($exec10);
		$patientname=$res10['customerfullname'];
		$gender=$res10['gender'];
		$age=$res10['age'];
		$mobilenumber=$res10['mobilenumber'];
}
		if($gender=='Male')
		{
		$gendvalue='0';	
		}
		else
		{
		$gendvalue='1';	
		}
		

			$query13="select * from ambulancep ap LEFT JOIN ambulanceinc ainc ON ap.visitcode=ainc.visitcode   where   ap.visitcode='$visitcode' and ap.patientcode='$patientcode' ";
			$exec13=mysql_query($query13) or die(mysql_error());
			$res13=mysql_fetch_array($exec13);
			
			$operator=$res13['operator'];
			$nurse=$res13['nurse'];
			$ambulancereg=$res13['ambulancereg'];
			$incidentdate=$res13['incidentdate'];
			$pcrno2=$res13['pcrno2'];
			$unitnum=$res13['unitnum'];
			$ambulancereg1=$res13['ambulancereg1'];
			$patientdispose=$res13['patientdispose'];
			$incidentaddress=$res13['incidentaddress'];
			$responsemode=$res13['responsemode'];
			$responsemodefromscene=$res13['responsemodefromscene'];
			$timeunotified=$res13['timeunotified'];
			$begodometer=$res13['begodometer'];
			$timeuarrived=$res13['timeuarrived'];
			$onsceneodometer=$res13['onsceneodometer'];
			$timeuleft=$res13['timeuleft'];
			$ptdestodometer=$res13['ptdestodometer'];
			$timeparrived=$res13['timeparrived'];
			$endingodometer=$res13['endingodometer'];
			$timeunitback=$res13['timeunitback'];
			$totalkm=$res13['totalkm'];
			$servicereq=$res13['servicereq'];
			$payment=$res13['payment'];
			$amount=$res13['amount'];
			$extbillno=$res13['extbillno'];
			
			$ptaddress=$res13['ptaddress'];
			$caller=$res13['caller'];
			$ptphoneno=$res13['ptphoneno'];
			$ccomplaint=$res13['ccomplaint'];
			$analocation=$res13['analocation'];
			$syslocation=$res13['syslocation'];
			$medication=$res13['medication'];
			$allergies=$res13['allergies'];
			$medadmby=$res13['medadmby'];
			$diagnosis=$res13['diagnosis'];
			$origfacility=$res13['origfacility'];
			$destfacility=$res13['destfacility'];
			$typedestination=$res13['typedestination'];
			$treatment=$res13['treatment'];
			$procedures=$res13['procedures'];
			$rescue=$res13['rescue'];
			$receivenurse=$res13['receivenurse'];
			$destfacility1=$res13['destfacility1'];
			$timeout=$res13['timeout'];
			$timein=$res13['timein'];
			$pcrno=$res13['pcrno'];
			
			

?>

		

<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style1 {COLOR: #3B3B3C; FONT-FAMILY: Tahoma; font-size: 11px;}
-->
</style>
</head>

<body>
<table width="103%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <form name="form1" id="form1" method="post" action="editambulanceentry.php" onSubmit="return from1submit1()">
  <tr>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top"><table width="93%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#E0E0E0" id="AutoNumber3" style="border-collapse: collapse">
      <tbody>
		<tr bgcolor="#E0E0E0">
			<td class="bodytext3" bgcolor="#E0E0E0" valign="middle"><strong>Name*</strong></td>
			<td width="28%" colspan="4" align="left" valign="middle" bgcolor="#E0E0E0" class="bodytext3"><?php echo $patientname; ?>
			<input type="hidden" name="patientcode" value="<?php echo $patientcode; ?>">
			<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode;?>">
			<input type="hidden" name="docno" id="docno" value="<?php echo $docno;?>">
			<input type="hidden" name="extbillno" id="extbillno" value="<?php echo $extbillno;?>">
			</td>
			<td bgcolor="#E0E0E0" class="bodytext3" valign="middle"><strong>Date of Admission</strong></td>
			<td valign="middle" bgcolor="#E0E0E0" class="bodytext3">
			<input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $transactiondatefrom; ?>" size="6"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/></td>
		</tr>
		<tr>
			<td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Age</strong></td>
			<td width="28%" colspan="4" bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="age" id="age" value="<?php echo $age;?>" size="5"></td>
			<td width="14%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Sex</strong></td>
			<td align="left" valign="middle" class="bodytext3"><select name="sex" id="sex" value=""  tabindex="12" autocomplete="off">
            <?php
			if($gender!='')
			{?>
			<option value="<?php echo $gendvalue?>"><?php echo $gender?></option>
			<?php	
			}
			?>
			<option value="0">Male</option>
			<option value="1">Female</option>
			</select></td>
		</tr>
      </tbody>
    </table>
	</td>
	</tr>  
	<tr>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top"><table width="93%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#E0E0E0" id="AutoNumber3" style="border-collapse: collapse">
      <tbody>
        <tr>
          <td width="22%" align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">PT address</td>
          <td colspan="2" bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="ptaddress" id="ptaddress" value="<?php echo $ptaddress; ?>" size="20" autocomplete="off"></td>
          <td width="10%" align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">Caller</td>
          <td width="43%" align="left" valign="middle" class="bodytext3"><input type="text" name="caller" id="caller" value="<?php echo $caller; ?>" size="20" autocomplete="off"></td>
        </tr>
        <tr>
          <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">PT Phone Number </td>
          <td colspan="2" bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="ptphoneno" id="ptphoneno" value="<?php echo $ptphoneno?>" size="20"autocomplete="off" onKeyPress="return validatenumerics(event);"></td>
          <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
          <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
        </tr>
        <tr>
          <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Chief Complaint </td>
          <td colspan="2" bgcolor="#E0E0E0" class="bodytext3">
			<select name="ccomplaint" id="ccomplaint">
			 <?php
                  if($ccomplaint!='')
				   {	
				   	$query11 = "select * from master_chiefcomplaint where auto_number='$ccomplaint' and recordstatus=''";
		 $exec11 = mysql_query($query11) or die(mysql_error());
		 $rows11=mysql_num_rows($exec11);
		 $res11 = mysql_fetch_array($exec11);
		
			 $autonumber=$res11['auto_number'];
			 $chiefcomplaint=$res11['chiefcomplaint'];

					   ?>
					 <option value="<?= $autonumber; ?>" ><?= $chiefcomplaint; ?></option>  
                     <?php
				   }
				   else
				   {
				   
				   ?>
                   <option value="">Select</option>
                 
                   
             <?php
				   }
				   
			 		  $query11 = "select * from master_chiefcomplaint where auto_number<> '$ccomplaint' and recordstatus=''";
		 $exec11 = mysql_query($query11) or die(mysql_error());
		 $rows11=mysql_num_rows($exec11);
		 while($res11 = mysql_fetch_array($exec11))
		 {
			 $autonumber=$res11['auto_number'];
			 $chiefcomplaint=$res11['chiefcomplaint'];

			 ?>
			 <option value="<?php echo $autonumber?>"><?php echo $chiefcomplaint?></option>
             <?php
		 }
			 ?>
			</select>
		  </td>
          <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
          <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
        </tr>
        <tr>
          <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Chief Complaint Anatomic Location </td>
          <td colspan="2" bgcolor="#E0E0E0" class="bodytext3">
		    <select name="analocation" id="analocation">
            
            <?php
                  if($analocation!='')
				   {
			$query12 = "select * from master_anatomiclocation where auto_number='$analocation' and recordstatus=''";
			$exec12 = mysql_query($query12) or die(mysql_error());
			$res12 = mysql_fetch_array($exec12);
		 
			 $autonumber=$res12['auto_number'];
			 $anatomiclocation=$res12['anatomiclocation'];

					   ?>
					 <option value="<?= $autonumber; ?>" ><?= $anatomiclocation; ?></option>
					   
	                     <?php
				   }
				   else
				   {
				   
				   ?>
                   <option value="">Select</option>
                 
                   
             <?php
				   }
				   
			 		  $query12 = "select * from master_anatomiclocation where  auto_number<> '$analocation' and recordstatus=''";
		 $exec12 = mysql_query($query12) or die(mysql_error());
		 while($res12 = mysql_fetch_array($exec12))
		 {
			 $autonumber=$res12['auto_number'];
			 $anatomiclocation=$res12['anatomiclocation'];

			 ?>
			 <option value="<?php echo $autonumber?>"><?php echo $anatomiclocation?></option>
             <?php
		 }
			 ?>
			</select>
		  </td>
          <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
          <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
        </tr>
        <tr>
          <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Chief Complaint Organ System Location </td>
          <td colspan="2" bgcolor="#E0E0E0" class="bodytext3">
<input type="text" name="syslocation" id="syslocation" value="<?php echo $syslocation?>" size="20" autocomplete="off">
<!--		    <select name="syslocation" id="syslocation">
			 <option value="">Select</option>
			 <option value=""></option>
			</select>
-->		  </td>
          <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Medication Given </td>
          <td colspan="2" bgcolor="#E0E0E0" class="bodytext3">
<input type="text" name="medication" id="medication" value="<?php echo $medication?>" size="20" autocomplete="off">
<!--		    <select name="medication" id="medication">
			 <option value="">Select</option>
			 <option value=""></option>
			</select>		  
-->		  </td>
        </tr>
       <tr>
          <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Allergies</td>
          <td colspan="2" bgcolor="#E0E0E0" class="bodytext3">
<input type="text" name="allergies" id="allergies" value="<?php echo $allergies?>" size="20" autocomplete="off">
<!--		    <select name="allergies" id="allergies">
			 <option value="">Select</option>
			 <option value=""></option>
			</select>
-->		  </td>
          <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Medication Administered By </td>
          <td colspan="2" bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="medadmby" id="medadmby" value="<?php echo $medadmby?>"  size="20" autocomplete="off"></td>
        </tr>
          <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Diagnosis</td>
          <td colspan="2" bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="diagnosis" id="diagnosis" value="<?php echo $diagnosis?>" size="20"autocomplete="off"></td>
          <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
          <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
        </tr>
        <tr>
          <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Originating Facility </td>
          <td colspan="2" bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="origfacility" id="origfacility" value="<?php echo $origfacility?>" size="20" autocomplete="off"></td>
          <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Destination Facility </td>
          <td align="left" valign="middle" class="bodytext3"><input type="text" name="destfacility" id="destfacility" value="<?php echo $destfacility?>"  size="20" autocomplete="off"></td>
        </tr>
        <tr>
          <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Type of Destination </td>
          <td colspan="2" bgcolor="#E0E0E0" class="bodytext3">
		  <select name="typedestination" id="typedestination">
          
           <?php
                  if($typedestination!='')
				   {
					    $query13 = "select * from amb_destination where auto_number='$typedestination' and recordstatus=''";
		 $exec13 = mysql_query($query13) or die(mysql_error());
		 $res13 = mysql_fetch_array($exec13);
		 
			 $autonumber=$res13['auto_number'];
			 $destination=$res13['destination'];

					   
					   ?>
					 <option value="<?= $autonumber; ?>" ><?= $destination; ?></option>  
                     <?php
				   }
				   else
				   {
				   
				   ?>
                   <option value="">Select</option>
                 
                   
             <?php
				   }
				   
		 $query13 = "select * from amb_destination where auto_number!='$typedestination' and recordstatus=''";
		 $exec13 = mysql_query($query13) or die(mysql_error());
		 while($res13 = mysql_fetch_array($exec13))
		 {
			 $autonumber=$res13['auto_number'];
			 $destination=$res13['destination'];

			 ?>
			 <option value="<?php echo $autonumber?>"><?php echo $destination?></option>
             <?php
		 }
			 ?>
            
<!--            <option value="Home">Home</option>
			<option value="Hospital">Hospital</option>
			<option value="Medical Office">Medical Office</option>
			<option value="Morgue">Morgue</option>
			<option value="Nursing Home">Nursing Home</option>
			<option value="Police">Police</option>
			<option value="Other">Other</option>
-->          </select>
		  </td>
          <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
          <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
        </tr>
        <tr>
          <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Treatment</td>
          <td colspan="2" bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="treatment" id="treatment" value="<?php echo $treatment?>" size="20"autocomplete="off"></td>
          <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
          <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
        </tr>
        <tr>
          <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Procedures</td>
          <td colspan="2" bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="procedures" id="procedures" value="<?php echo $procedures?>" size="20" autocomplete="off"></td>
          <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
          <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
        </tr>
        <tr>
          <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Rescue</td>
          <td colspan="2" bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="rescue" id="rescue" value="<?php echo $rescue?>" size="20" autocomplete="off"></td>
          <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
          <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
        </tr>
        <tr>
          <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Receiving Nurse </td>
          <td colspan="2" bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="receivenurse" id="receivenurse" value="<?php echo $receivenurse?>" size="20"></td>
          <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Destination Facility </td>
          <td align="left" valign="middle" class="bodytext3"><input type="text" name="destfacility1" id="destfacility1" value="<?php echo $destfacility1?>" size="20"></td>
        </tr>
        <tr>
          <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Referral Time </td>
          <td width="18%" bgcolor="#E0E0E0" class="bodytext3">Time Out 
            <input type="text" name="timeout" id="timeout" value="<?php echo $timeout?>"  size="5" autocomplete="off"></td>
          <td width="7%" bgcolor="#E0E0E0" class="bodytext3">Time In 
            <input type="text" name="timein" id="timein" value="<?php echo $timein?>" size="5" autocomplete="off"></td>
          <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
          <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
        </tr>
        <tr>
          <td height="26" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">PCR No. </td>
          <td colspan="2" bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="pcrno" id="pcrno" value="<?php echo $pcrno?>" size="10" autocomplete="off"></td>
          <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
          <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
        </tr>
      </tbody>
    </table>
	</td>
	</tr>  
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="860">
			<table width="848" height="180" border="0" align="left" cellpadding="4" cellspacing="0" id="AutoNumber3" style="border-collapse: collapse">
			 <tbody>
			   <tr>
			     <td height="30" colspan="6" bgcolor="#CCCCCC" class="bodytext3"><strong>Ambulance Reg. </strong>                  
		  <select name="ambulancereg" id="ambulancereg">
          
          
            <?php
            if($ambulancereg!='')
				   {
			 $query20 = "select * from master_vehicle where vehiclenumber='$ambulancereg' AND  recordstatus='ACTIVE'";
		 $exec20 = mysql_query($query20) or die(mysql_error());
		$res20 = mysql_fetch_array($exec20);
		 
			 $autonumber=$res20['autonumber'];
			 $vehiclenumber=$res20['vehiclenumber'];
			
                  
					   ?>
					 <option value="<?= $vehiclenumber; ?>" ><?= $vehiclenumber; ?></option>  
                     <?php
				   }
				   else
				   {
				   
				   ?>
                   <option value="">Select</option>
                 
                   
             <?php
			 
				   }
			 		  $query20 = "select * from master_vehicle where  vehiclenumber!='$ambulancereg' AND recordstatus='ACTIVE'";
		 $exec20 = mysql_query($query20) or die(mysql_error());
		 while($res20 = mysql_fetch_array($exec20))
		 {
			 $autonumber=$res20['autonumber'];
			 $vehiclenumber=$res20['vehiclenumber'];

			 ?>
			 <option value="<?php echo $vehiclenumber?>"><?php echo $vehiclenumber?></option>
             <?php
		 } 
			 ?>
        </select>
			       <strong>Operator</strong>
		  <select name="operator" id="operator">
          
          
          <?php
                  if($operator!='')
				   {
					   
		$query14 = "select * from master_operator where auto_number='$operator' and recordstatus=''";
		 $exec14 = mysql_query($query14) or die(mysql_error());
		 $res14 = mysql_fetch_array($exec14);
		
			 $autonumber=$res14['auto_number'];
			 $operator1=$res14['operator'];
					   
					   ?>
					 <option value="<?= $autonumber; ?>" ><?= $operator1; ?></option>  
                     <?php
				   }
				   else
				   {
				   
				   ?>
                   <option value="">Select</option>
                 
                   
             <?php
				   }
				  
			 		  $query14 = "select * from master_operator where auto_number!='$operator' AND recordstatus=''";
		 $exec14 = mysql_query($query14) or die(mysql_error());
		 while($res14 = mysql_fetch_array($exec14))
		 {
			 $autonumber=$res14['auto_number'];
			 $operator=$res14['operator'];

			 ?>
			 <option value="<?php echo $autonumber?>"><?php echo $operator?></option>
             <?php
		 } 
			 ?>
            
        </select>
			       <strong>Nurse</strong>
			       <input type="text" name="nurse" id="nurse" value="<?= $nurse; ?>" size="10"></td>
			     </tr>
			   
			   <tr>
			     <td width="21%" height="30" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Incident Date :				   </td>
				 <td width="13%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input name="incidentdate" id="incidentdate" style="border: 1px solid #001E6A" value="<?php echo $incidentdate; ?>" size="6"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('incidentdate')" style="cursor:pointer"/></td>
				 <td width="13%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">PCR No.</td>
			     <td width="16%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="pcrno2" id="pcrno2" value="<?= $pcrno2; ?>" size="5" onKeyPress="return isNumberDecimal(event);" autocomplete="off"></td>
			     <td width="8%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Unit Num</td>
			 <td width="29%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="unitnum" id="unitnum" value="<?= $unitnum; ?>" size="5" onKeyPress="return isNumberDecimal(event);" autocomplete="off"></td>
			   </tr>
			   <tr>
			     <td height="30" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Ambulance Reg.			       </td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input id="ambulancereg1" name="ambulancereg1" type="text" value="<?= $ambulancereg1;?>" size="9" autocomplete="off"/></td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     </tr>
			   <tr>
			     <td height="30" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Patient Disposition </td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
                 <input type="text" name="patientdispose" id="patientdispose" value="<?= $patientdispose;?>" size="20" autocomplete="off">
<!--				 <select name="patientdispose" id="patientdispose">
                   <option value="">Select</option>
                   <option value=""></option>
                 </select>
-->				 </td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Incident Address                   </td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input id="incidentaddress" name="incidentaddress" type="text" value="<?= $incidentaddress;?>" size="20" autocomplete="off"/></td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     </tr>
			   <tr>
			     <td height="30" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Response Mode </td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
				 <select name="responsemode" id="responsemode">
                 
                  <?php
                  if($responsemode!='')
				   {
					    $query15 = "select * from master_responsemode where auto_number='$responsemode' and  recordstatus=''";
			 $exec15 = mysql_query($query15) or die(mysql_error());
			 $res15 = mysql_fetch_array($exec15);
		 
			 $autonumber=$res15['auto_number'];
			 $responsemode1=$res15['responsemode'];
					  
					   ?>
					 <option value="<?= $autonumber; ?>" ><?= $responsemode1; ?></option>  
                     <?php
				   }
				   else
				   {
				   
				   ?>
                   <option value="">Select</option>
                 
                   
             <?php
				   }
				   
                   
			 		  $query15 = "select * from master_responsemode where auto_number!='$responsemode' and recordstatus=''";
		 $exec15 = mysql_query($query15) or die(mysql_error());
		 while($res15 = mysql_fetch_array($exec15))
		 {
			 $autonumber=$res15['auto_number'];
			 $responsemode=$res15['responsemode'];

			 ?>
			 <option value="<?php echo $autonumber?>"><?php echo $responsemode?></option>
             <?php
		 }
			 ?>
                 </select></td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			   </tr>
			   <tr>
			     <td height="30" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Response Mode from the scene </td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
				 <select name="responsemodefromscene" id="responsemodefromscene">
                 
                   <?php
                  if($responsemodefromscene!='')
				   {
		 $query15 = "select * from master_responsemode where auto_number='$responsemodefromscene' and recordstatus=''";
		 $exec15 = mysql_query($query15) or die(mysql_error());
		 $res15 = mysql_fetch_array($exec15);
		 
			 $autonumber=$res15['auto_number'];
			 $responsemode=$res15['responsemode'];
					   
					   ?>
					 <option value="<?= $autonumber; ?>" ><?= $responsemode; ?></option>  
                     <?php
				   }
				   else
				   {
				   
				   ?>
                   <option value="">Select</option>
                 
                   
             <?php
				   }
				   
			 		  $query15 = "select * from master_responsemode where auto_number<> '$responsemodefromscene' and recordstatus=''";
		 $exec15 = mysql_query($query15) or die(mysql_error());
		 while($res15 = mysql_fetch_array($exec15))
		 {
			 $autonumber=$res15['auto_number'];
			 $responsemode=$res15['responsemode'];

			 ?>
			 <option value="<?php echo $autonumber?>"><?php echo $responsemode?></option>
             <?php
		 }
			 ?>
                 </select></td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			   </tr>
			</tbody>
			</table>			</td>
		</tr>
    </table>
	</td>
	</tr>
	<tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="860">
			<table width="848" height="311" border="0" align="left" cellpadding="4" cellspacing="0" id="AutoNumber3" style="border-collapse: collapse">
			 <tbody>
			   <tr>
			     <td height="20" bgcolor="#CCCCCC" class="bodytext3"><strong>RUN TIMES</strong></td>
			     <td height="20" bgcolor="#CCCCCC" width="200" class="bodytext3">&nbsp;</td>
			     <td height="20" bgcolor="#CCCCCC" class="bodytext3"><strong>ODOMETER</strong></td>
			     <td bgcolor="#CCCCCC" class="bodytext3">&nbsp;</td>
			   </tr>
			   
			   <tr>
			     <td width="23%" height="30" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Time Unit Notified </td>
				 <td width="23%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input id="timeunotified" value="<?= $timeunotified;  ?>" name="timeunotified" type="text"  size="9" autocomplete="off"/></td>
			     <td width="16%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Beginning Odometer </td>
			     <td width="38%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input id="begodometer" name="begodometer" type="text" value="<?= $begodometer;  ?>" size="9" autocomplete="off"/></td>
			   </tr>
			   <tr>
			     <td height="30" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Time Unit Arrived At Scene </td>
			     <td align="left" valign="middle"  width="200" bgcolor="#E0E0E0" class="bodytext3"><input id="timeuarrived" value="<?= $timeuarrived;  ?>" name="timeuarrived" type="text"  size="9" autocomplete="off"/></td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">On Scene Odometer </td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input id="onsceneodometer" name="onsceneodometer" type="text" value="<?= $onsceneodometer;  ?>" size="9" autocomplete="off"/></td>
			   </tr>
			   <tr>
			     <td height="30" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Time Unit Left At Scene </td>
			     <td align="left" valign="middle"  width="200" bgcolor="#E0E0E0" class="bodytext3"><input id="timeuleft" name="timeuleft" type="text" size="9" value="<?= $timeuleft;  ?>" autocomplete="off"/></td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">PT Destination Odometer</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input id="ptdestodometer" name="ptdestodometer" type="text" size="9"value="<?= $ptdestodometer;  ?>"  autocomplete="off"/></td>
			   </tr>
			   <tr>
			     <td height="30" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Time Patient Arrived at Destination </td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input id="timeparrived" name="timeparrived" type="text" size="9" value="<?= $timeparrived;  ?>" autocomplete="off"/></td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Ending Odometer </td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input id="endingodometer" name="endingodometer" type="text" size="9" value="<?= $endingodometer;  ?>" autocomplete="off"/></td>
			   </tr>
			   <tr>
			     <td height="30" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Time Unit Back in Service(completed)</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input id="timeunitback" name="timeunitback" type="text" size="9" value="<?= $timeunitback;  ?>" autocomplete="off"/></td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Total Km</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input id="totalkm" name="totalkm" type="text" size="9" value="<?= $totalkm;  ?>" autocomplete="off"/></td>
			   </tr>
			   
			   <tr>
			     <td height="30" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">TYPE OF SERVICE REQUESTED </td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
				    <select name="servicereq" id="servicereq">
                    
                   <?php
                  if($servicereq!='')
				   {
					    $query16 = "select * from amb_service where auto_number='$servicereq' and recordstatus=''";
		 $exec16 = mysql_query($query16) or die(mysql_error());
		 $res16 = mysql_fetch_array($exec16);
		
			 $autonumber=$res16['auto_number'];
			 $service=$res16['service'];
					   
					   ?>
					 <option value="<?= $autonumber; ?>" ><?= $service; ?></option>  
                     <?php
				   }
				   else
				   {
				   
				   ?>
                   <option value="">Select</option>
                 
                   
             <?php
				   }
				   
			 		  $query16 = "select * from amb_service where auto_number<> '$servicereq' and recordstatus=''";
		 $exec16 = mysql_query($query16) or die(mysql_error());
		 while($res16 = mysql_fetch_array($exec16))
		 {
			 $autonumber=$res16['auto_number'];
			 $service=$res16['service'];

			 ?>
			 <option value="<?php echo $autonumber?>"><?php echo $service?></option>
             <?php
		 }
			 ?>
					</select>				 </td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			   </tr>
			   <tr>
			     <td height="30" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Payment</td>
			     <td align="left" width="200" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
                 <select name="payment" id="payment">
                 <?php
                  if($payment!='')
				   {
					   $query17 = "select * from amb_payment where auto_number='$payment' and recordstatus=''";
		 $exec17 = mysql_query($query17) or die(mysql_error());
		 $res17 = mysql_fetch_array($exec17);
		
			 $autonumber=$res17['auto_number'];
			 $payment1=$res17['payment'];
					   ?>
					 <option value="<?= $autonumber; ?>" ><?= $payment1; ?></option>  
                     <?php
				   }
				   else
				   {
				   
				   ?>
                   <option value="">Select</option>
                 
                   
             <?php
			 }
				  
		 $query17 = "select * from amb_payment where auto_number<> '$payment' and recordstatus=''";
		 $exec17 = mysql_query($query17) or die(mysql_error());
		 while($res17 = mysql_fetch_array($exec17))
		 {
			 $autonumber=$res17['auto_number'];
			 $payment=$res17['payment'];

			 ?>
			 <option value="<?php echo $autonumber?>"><?php echo $payment?></option>
             <?php
		 } 
			 ?>
                 </select></td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Amount
</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
                   <select name="amount" id="amount">
                   
                   <?php 
				   
				   if($amount!='')
				   {
					   
			$query18 = "select * from master_amount  where amount='$amount' and   recordstatus=''";
		 $exec18 = mysql_query($query18) or die(mysql_error());
		 $res18 = mysql_fetch_array($exec18);
		 
			 $autonumber=$res18['auto_number'];
			 $amount1=$res18['amount'];

					   ?>
					 <option value="<?= $amount1; ?>" ><?= $amount1; ?></option>  
                     <?php
				   }
				   else
				   {
				   
				   ?>
                   <option value="">Select</option>
                   
             <?php
				   }
		 $query18 = "select * from master_amount where amount <> '$amount' and   recordstatus=''";
		 $exec18 = mysql_query($query18) or die(mysql_error());
		 while($res18 = mysql_fetch_array($exec18))
		 {
			 $autonumber=$res18['auto_number'];
			 $amount=$res18['amount'];

			 ?>
			 <option value="<?php echo $amount?>"><?php echo $amount?></option>
             <?php
		 } 
		 ?>
         
         
                   </select>                 </td>
			   </tr>
			   
			   <tr>
			     <td height="27" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     </tr>
			   <tr>
			     <td height="27" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     </tr>
			   <tr>
			     <td height="27" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			   </tr>
			</tbody>
			</table>
			</td>
		</tr>
        <tr>
          <td>
		  <input type="hidden" name="frmflag1" value="frmflag1" />
          <input type="hidden" name="companyanum" value="<?php echo $companyanum; ?>" />
          <input name="Submit222" type="submit"  value="Save" class="button"/>
		  </td>
        </tr>
    </table>
	</td>
	</tr>
	</form>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

