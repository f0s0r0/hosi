<?php
session_start();
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("db/db_connect.php");
$username = $_SESSION['username'];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$pagename = "";
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
	$employeecode = $_REQUEST['employeecode'];
	$employeename = $_REQUEST['employeename'];
	$employeename = strtoupper($employeename);
	$fathername = $_REQUEST['fathername'];
	$nationality = $_REQUEST['nationality'];
	$gender = $_REQUEST['gender'];
	$dob = $_REQUEST['dob'];
	$maritalstatus = $_REQUEST['maritalstatus'];
	$religion = $_REQUEST['religion'];
	$bloodgroup = $_REQUEST['bloodgroup'];
	$height = $_REQUEST['height'];
	$weight = $_REQUEST['weight'];
	$address = $_REQUEST['address'];
	$city = $_REQUEST['city'];
	$state = $_REQUEST['state'];
	$phone = $_REQUEST['phone'];
	$mobile = $_REQUEST['mobile'];
	$email = $_REQUEST['email'];
	$university = $_REQUEST['university'];
	$univregno = $_REQUEST['univregno'];
	if(isset($_REQUEST['disabledperson'])) { $disabledperson = $_REQUEST['disabledperson']; } else { $disabledperson = 'No'; }
	$doj = $_REQUEST['doj'];
	$employmenttype = $_REQUEST['employmenttype'];
	$department = $_REQUEST['department'];
	$departmentsplit = explode('||',$department);
	$departmentanum = $departmentsplit[0];
	$departmentname = $departmentsplit[1];
	$category = $_REQUEST['category'];
	$designation = $_REQUEST['designation'];
	$supervisor = $_REQUEST['supervisor'];
	if(isset($_REQUEST['firstjob'])) { $firstjob = $_REQUEST['firstjob']; } else { $firstjob = 'No'; }
	if(isset($_REQUEST['overtime'])) { $overtime = $_REQUEST['overtime']; } else { $overtime = 'No'; }
	if(isset($_REQUEST['user'])) { $user = $_REQUEST['user']; } else { $user = 'No'; }
	if(isset($_REQUEST['prorata'])) { $prorata = $_REQUEST['prorata']; } else { $prorata = 'No'; }
	$nextofkin = $_REQUEST['nextofkin'];
	$pinno = $_REQUEST['pinno'];
	$spousename = $_REQUEST['spousename'];
	$hosp = $_REQUEST['hosp'];
	$nssf = $_REQUEST['nssf'];
	$nhif = $_REQUEST['nhif'];
	$passportnumber = $_REQUEST['passportnumber'];
	$passportcountry = $_REQUEST['passportcountry'];
	$sacconumber = $_REQUEST['sacconumber'];
	$costcenter = $_REQUEST['costcenter'];
	$bankname = $_REQUEST['bankname'];
	$bankbranch = $_REQUEST['bankbranch'];
	$accountnumber = $_REQUEST['accountnumber'];
	$bankcode = $_REQUEST['bankcode'];
	$insurancename = $_REQUEST['insurancename'];
	$insurancecity = $_REQUEST['insurancecity'];
	$policytype = $_REQUEST['policytype'];
	$policynumber = $_REQUEST['policynumber'];
	$policyfrom = $_REQUEST['policyfrom'];
	$policyto = $_REQUEST['policyto'];
	$qualificationbasic = $_REQUEST['qualificationbasic'];
	$qualificationadditional = $_REQUEST['qualificationadditional'];
	$employername = $_REQUEST['employername'];
	$employeraddress = $_REQUEST['employeraddress'];
	$promotiondue = $_REQUEST['promotiondue'];
	$incrementdue = $_REQUEST['incrementdue'];
	if(isset($_REQUEST['freetravel'])) { $freetravel = $_REQUEST['freetravel']; } else { $freetravel = 'No'; }
	if(isset($_REQUEST['companycar'])) { $companycar = $_REQUEST['companycar']; } else { $companycar = 'No'; }
	$vehicleno = $_REQUEST['vehicleno'];
	$dol = $_REQUEST['dol'];
	if(isset($_REQUEST['blacklisted'])) { $blacklisted = $_REQUEST['blacklisted']; } else { $blacklisted = 'No'; }
	$reasonforleaving = $_REQUEST['reasonforleaving'];
	$doh = $_REQUEST['doh'];
	if(isset($_REQUEST['lastjobforexpatriate'])) { $lastjobforexpatriate = $_REQUEST['lastjobforexpatriate']; } else { $lastjobforexpatriate = 'No'; }
	if(isset($_REQUEST['hold'])) { $hold = $_REQUEST['hold']; } else { $hold = 'No'; }
	$pensionno = $_REQUEST['pensionno'];
	$payrollno = $_REQUEST['payrollno'];
	
	$query10 = "select * from master_employee where employeename = '$employeename'";
	$exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());
	$res10 = mysql_fetch_array($exec10);
	$res10employeename = $res10['employeename'];
	if($res10employeename == '')
	{	
		$query11 = "insert into master_employee(employeecode, employeename, dateofjoining, firstjob, overtime, is_user, prorata, hold, dateofholding, employmenttype, departmentanum, departmentname, category, designation, supervisor, status, lastupdateusername, lastupdateipaddress, lastupdate,payrollstatus,pensionno,payrollno)
		values('$employeecode', '$employeename', '$doj', '$firstjob', '$overtime', '$user', '$prorata', '$hold', '$doh', '$employmenttype', '$departmentanum', '$departmentname', '$category', '$designation', '$supervisor', 'Active', '$username', '$ipaddress', '$updatedatetime','Active','$pensionno','$payrollno')";
		$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
		
		$query12 = "insert into master_employeeinfo(employeecode, employeename, fathername, nationality, gender, dateofbirth, maritalstatus, religion, bloodgroup, height, weight, address, city, state, phone, mobile, email, university, univregno, disabledperson, nextofkin, pinno, spousename, hosp, nssf, nhif, passportnumber, passportcountry, sacconumber, costcenter, bankname, 
		bankbranch, accountnumber, bankcode, insurancename, insurancecity, policytype, policynumber, policyfrom, policyto, qualificationbasic, qualificationadditional, employername, employeraddress, promotiondue, incrementdue, freetravel, companycar, vehicleno, dateofleaving, blacklisted, reasonforleaving, lastjobforexpatriate, status, username, ipaddress, updatedatetime)
		values('$employeecode', '$employeename', '$fathername', '$nationality', '$gender', '$dob', '$maritalstatus', '$religion', '$bloodgroup', '$height', '$weight', '$address', '$city', '$state', '$phone', '$mobile', '$email', '$university', '$univregno', '$disabledperson', '$nextofkin', '$pinno', '$spousename', '$hosp', '$nssf', '$nhif', '$passportnumber', '$passportcountry', '$sacconumber', '$costcenter', '$bankname', 
		'$bankbranch', '$accountnumber', '$bankcode', '$insurancename', '$insurancecity', '$policytype', '$policynumber', '$policyfrom', '$policyto', '$qualificationbasic', '$qualificationadditional', '$employername', '$employeraddress', '$promotiondue', '$incrementdue', '$freetravel', '$companycar', '$vehicleno', '$dol', '$blacklisted', '$reasonforleaving', '$lastjobforexpatriate', 'Active', '$username', '$ipaddress', '$updatedatetime')";
		$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
		
		
		header("location:addemployeeinfo.php?st=success");
	}
	else
	{
		header("location:addemployeeinfo.php?st=failed");
	}
	
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'success')
{
	$errmsg = "Success. New Employee Updated.";
}
else if ($st == 'failed')
{
	$errmsg = "Failed. Employee Already Exists.";
}

$query1 = "select * from master_employee order by auto_number desc limit 0, 1";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
$rowcount1 = mysql_num_rows($exec1);
if ($rowcount1 == 0)
{
	$employeecode = 'EMP00000001';
}
else
{
	$res1 = mysql_fetch_array($exec1);
	$res1employeecode = $res1['employeecode'];
	$employeecode = substr($res1employeecode, 3, 8);
	$employeecode = intval($employeecode);
	$employeecode = $employeecode + 1;

	$maxanum = $employeecode;
	if (strlen($maxanum) == 1)
	{
		$maxanum1 = '0000000'.$maxanum;
	}
	else if (strlen($maxanum) == 2)
	{
		$maxanum1 = '000000'.$maxanum;
	}
	else if (strlen($maxanum) == 3)
	{
		$maxanum1 = '00000'.$maxanum;
	}
	else if (strlen($maxanum) == 4)
	{
		$maxanum1 = '0000'.$maxanum;
	}
	else if (strlen($maxanum) == 5)
	{
		$maxanum1 = '000'.$maxanum;
	}
	else if (strlen($maxanum) == 6)
	{
		$maxanum1 = '00'.$maxanum;
	}
	else if (strlen($maxanum) == 7)
	{
		$maxanum1 = '0'.$maxanum;
	}
	else if (strlen($maxanum) == 8)
	{
		$maxanum1 = $maxanum;
	}
	
	$employeecode = 'EMP'.$maxanum1;

	//echo $employeecode;
}
//echo $res1employeecode;

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
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script language="javascript">


function process1backkeypress1()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
}

function WindowRedirect()
{
	window.location = "addemployeeinfo.php";
}
</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
</style>
</head>
<script language="javascript">

function process1()
{

}

</script>
<script src="js/datetimepicker_css.js"></script>
<body>
<table width="103%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); 	//	include ("includes/menu2.php"); ?>	</td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top">


      	  <form name="form1" id="form1" method="post" onKeyDown="return disableEnterKey()" action="addemployeeinfo.php" onSubmit="return process1()">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="860"><table width="900" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
                <td bgcolor="#CCCCCC" class="bodytext3" colspan="2"><strong>Add Employee - New </strong></td>
                <!--<td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                <td bgcolor="#CCCCCC" class="bodytext3" colspan="2">* Indicated Mandatory Fields. </td>
              </tr>
			  <?php
			  if($errmsg != ''){ ?>
              <tr>
                <td colspan="8" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
              </tr>
			  <?php } ?>
              <tr>
			  <td width="155" align="left" class="bodytext3">Employee Name</td>
			  <td width="261" align="left" class="bodytext3"><input type="text" name="employeename" id="employeename" size="35" style="border:solid 1px #001E6A;"></td>
			  <td width="140" align="left" class="bodytext3">Employee Code</td>
			  <td width="302" align="left" class="bodytext3"><input type="text" name="employeecode" id="employeecode" value="<?php echo $employeecode; ?>" readonly="readonly" size="20" style="background-color:#CCCCCC;"></td>
			  </tr>
			  <tr>
			  <td width="155" align="left" class="bodytext3">Payroll No</td>
			  <td width="261" align="left" class="bodytext3"><input type="text" name="payrollno" id="payrollno" size="20" style="border:solid 1px #001E6A;"></td>
			  <td width="140" align="left" class="bodytext3"></td>
			  <td width="302" align="left" class="bodytext3"></td>
			  </tr>
			  <tr>
			  <td colspan="4" align="left" bgcolor="#CCCCCC" class="bodytext3"><strong>Personal Details</strong></td>
			  </tr>
			  <tr>
			  <td align="left" class="bodytext3">Father Name</td>
			  <td align="left" class="bodytext3"><input type="text" name="fathername" id="fathername" size="25" style="border:solid 1px #001E6A;"></td>
			  <td align="left" class="bodytext3">Nationality</td>
			  <td align="left" class="bodytext3"><input type="text" name="nationality" id="nationality" size="20" style="border:solid 1px #001E6A;"></td>
			  </tr>
			  <tr>
			  <td align="left" class="bodytext3">Gender</td>
			  <td align="left" class="bodytext3"><select name="gender" id="gender" style="border:solid 1px #001E6A;">
			  <option value="Male">Male</option>
			  <option value="Female">Female</option></select></td>
			  <td align="left" class="bodytext3">Date of Birth</td>
			  <td align="left" class="bodytext3"><input type="text" name="dob" id="dob" readonly="readonly" size="10" style="border:solid 1px #001E6A;">
			  <img src="images2/cal.gif" onClick="javascript:NewCssCal('dob')" style="cursor:pointer"/>	</td>
			  </tr>
			  <tr>
			  <td align="left" class="bodytext3">Marital Status</td>
			  <td align="left" class="bodytext3"><select name="maritalstatus" id="maritalstatus" style="border:solid 1px #001E6A;">
			  <option value="">Select</option>
			  <option value="Unmarried">Unmarried</option>
			  <option value="Married">Married</option>
			  <option value="Widow/Widower">Widow/Widower</option>
			  <option value="Divorcee">Divorcee</option></select></td>
			  <td align="left" class="bodytext3">Religion</td>
			  <td align="left" class="bodytext3"><input type="text" name="religion" id="religion" size="20" style="border:solid 1px #001E6A;"></td>
			  </tr>
			  <tr>
			  <td align="left" class="bodytext3">Blood Group</td>
			  <td align="left" class="bodytext3"><select name="bloodgroup" id="bloodgroup" style="border:solid 1px #001E6A;">
			  <option value="">Select</option>
			  <?php
			  $query7 = "select * from master_bloodgroup where recordstatus <> 'deleted' order by bloodgroup";
			  $exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
			  while($res7 = mysql_fetch_array($exec7))
			  {
			  $bloodgroup = $res7['bloodgroup'];
			  ?>
			  <option value="<?php echo $bloodgroup; ?>"><?php echo $bloodgroup; ?></option>
			  <?php
			  }
			  ?>
			  </select></td>
			  <td align="left" class="bodytext3">Height</td>
			  <td align="left" class="bodytext3"><input type="text" name="height" id="height" size="10" style="border:solid 1px #001E6A;">
			  <span class="bodytext3">Weight</span>&nbsp;&nbsp;<input type="text" name="weight" id="weight" size="10" style="border:solid 1px #001E6A;"></td>
			  </tr>
			  <tr>
			  <td align="left" class="bodytext3">Address</td>
			  <td align="left" class="bodytext3"><input type="text" name="address" id="address" size="25" style="border:solid 1px #001E6A;"></td>
			  <td align="left" class="bodytext3">City</td>
			  <td align="left" class="bodytext3"><input type="text" name="city" id="city" size="20" style="border:solid 1px #001E6A;"></td>
			  </tr>
			  <tr>
			  <td align="left" class="bodytext3">State</td>
			  <td align="left" class="bodytext3"><input type="text" name="state" id="state" size="20" style="border:solid 1px #001E6A;"></td>
			  <td align="left" class="bodytext3">Landline </td>
			  <td align="left" class="bodytext3"><input type="text" name="phone" id="phone" size="20" style="border:solid 1px #001E6A;"></td>
			  </tr>
			  <tr>
			  <td align="left" class="bodytext3">Email</td>
			  <td align="left" class="bodytext3"><input type="text" name="email" id="email" size="25	" style="border:solid 1px #001E6A;"></td>
			  <td align="left" class="bodytext3">Mobile </td>
			  <td align="left" class="bodytext3"><input type="text" name="mobile" id="mobile" size="20" style="border:solid 1px #001E6A;"></td>
			  </tr>
			  <tr>
			  <td align="left" class="bodytext3">University Name</td>
			  <td align="left" class="bodytext3"><input type="text" name="university" id="university" size="25	" style="border:solid 1px #001E6A;"></td>
			  <td align="left" class="bodytext3">University Reg No </td>
			  <td align="left" class="bodytext3"><input type="text" name="univregno" id="univregno" size="20" style="border:solid 1px #001E6A;"></td>
			  </tr>
			   <tr>
			  <td align="left" class="bodytext3">Is Disabled Employee ?</td>
			  <td align="left" class="bodytext3"><input type="checkbox" name="disabledperson" id="disabledperson" value="Yes"></td>
			  <td align="left" class="bodytext3">&nbsp;</td>
			  <td align="left" class="bodytext3">&nbsp;</td>
			  </tr>
			  <tr>
			  <td colspan="4" align="left" valign="middle"  bgcolor="#CCCCCC" class="bodytext3"><strong>Job Profile</strong></td>
			  </tr>
			  <tr>
			  <td align="left" class="bodytext3">Date of Joining</td>
			  <td align="left" class="bodytext3"><input type="text" name="doj" id="doj" readonly="readonly" size="10" style="border:solid 1px #001E6A;">
			  <img src="images2/cal.gif" onClick="javascript:NewCssCal('doj')" style="cursor:pointer"/>	</td>
			  <td align="left" class="bodytext3">Employment Type</td>
			  <td align="left" class="bodytext3"><select name="employmenttype" id="employmenttype" style="border:solid 1px #001E6A;">
			  <option value="">Select</option>
			  <option value="Regular">Regular</option>
			  <option value="Casual">Casual</option>
			  </select></td>
			  </tr>
			  <tr>
			  <td align="left" class="bodytext3">Department</td>
			  <td align="left" class="bodytext3"><select name="department" id="department" style="border:solid 1px #001E6A;">
			  <option value="">Select</option>
			  <?php
			  $query5 = "select * from master_department where recordstatus <> 'deleted' order by department";
			  $exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
			  while($res5 = mysql_fetch_array($exec5))
			  {
			  $departmentanum = $res5['auto_number'];
			  $departmentname = $res5['department'];
			  ?>
			  <option value="<?php echo $departmentanum.'||'.$departmentname; ?>"><?php echo $departmentname; ?></option>
			  <?php
			  }
			  ?>
			  </select></td>
			  <td align="left" class="bodytext3">Category</td>
			  <td align="left" class="bodytext3"><select name="category" id="category" style="border:solid 1px #001E6A;">
			  <option value="">Select</option>
			   <?php
			  $query6 = "select * from master_employeecategory where status <> 'deleted' order by category";
			  $exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
			  while($res6 = mysql_fetch_array($exec6))
			  {
			  $categoryanum = $res6['auto_number'];
			  $category = $res6['category'];
			  ?>
			  <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
			  <?php
			  }
			  ?>
			  </select></td>
			  </tr>
			  <tr>
			  <td align="left" class="bodytext3">Designation</td>
			  <td align="left" class="bodytext3"><select name="designation" id="designation" style="border:solid 1px #001E6A;">
			  <option value="">Select</option>
			   <?php
			  $query6 = "select * from master_employeedesignation where status <> 'deleted' order by designation";
			  $exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
			  while($res6 = mysql_fetch_array($exec6))
			  {
			  $designationanum = $res6['auto_number'];
			  $designation = $res6['designation'];
			  ?>
			  <option value="<?php echo $designation; ?>"><?php echo $designation; ?></option>
			  <?php
			  }
			  ?>
			  </select></td>
			  <td align="left" class="bodytext3">Supervisor</td>
			  <td align="left" class="bodytext3"><select name="supervisor" id="supervisor" style="border:solid 1px #001E6A;">
			  <option value="">Select</option>
			  <?php
			  $query6 = "select * from master_supervisor where status <> 'deleted' order by supervisor";
			  $exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
			  while($res6 = mysql_fetch_array($exec6))
			  {
			  $supervisoranum = $res6['auto_number'];
			  $supervisor = $res6['supervisor'];
			  ?>
			  <option value="<?php echo $supervisor; ?>"><?php echo $supervisor; ?></option>
			  <?php
			  }
			  ?>
			  </select></td>
			  </tr>
			  <tr>
			  <td align="left" class="bodytext3">First Job in Kenya</td>
			  <td align="left" class="bodytext3"><input type="checkbox" name="firstjob" id="firstjob" value="Yes"></td>
			  <td align="left" class="bodytext3">Overtime Applicable</td>
			  <td align="left" class="bodytext3"><input type="checkbox" name="overtime" id="overtime" value="Yes"></td>
			  </tr>
			  <tr>
			  <td align="left" class="bodytext3">Is User ?</td>
			  <td align="left" class="bodytext3"><input type="checkbox" name="user" id="user" value="Yes"></td>
			  <td align="left" class="bodytext3">Prorata</td>
			  <td align="left" class="bodytext3"><input type="checkbox" name="prorata" id="prorata" value="Yes"></td>
			  </tr>
			 <tr>
			 <td colspan="4" align="left" valign="middle"  bgcolor="#CCCCCC" class="bodytext3"><strong>References</strong></td>
			 </tr>
			 <tr>
			 <td align="left" class="bodytext3">Next of Kin</td>
			 <td align="left" class="bodytext3"><input type="text" name="nextofkin" id="nextofkin" size="30" style="border:solid 1px #001E6A;"></td>
			 <td align="left" class="bodytext3">PIN</td>
			 <td align="left" class="bodytext3"><input type="text" name="pinno" id="pinno" size="20" style="border:solid 1px #001E6A;"></td>
			 </tr>
			 <tr>
			 <td align="left" class="bodytext3">Name of Spouse</td>
			 <td align="left" class="bodytext3"><input type="text" name="spousename" id="spousename" size="30" style="border:solid 1px #001E6A;"></td>
			 <td align="left" class="bodytext3">HOSP No</td>
			 <td align="left" class="bodytext3"><input type="text" name="hosp" id="hosp" size="20" style="border:solid 1px #001E6A;"></td>
			 </tr>
			 <tr>
			 <td align="left" class="bodytext3">NSSF No</td>
			 <td align="left" class="bodytext3"><input type="text" name="nssf" id="nssf" size="20" style="border:solid 1px #001E6A;"></td>
			 <td align="left" class="bodytext3">NHIF No</td>
			 <td align="left" class="bodytext3"><input type="text" name="nhif" id="nhif" size="20" style="border:solid 1px #001E6A;"></td>
			 </tr>
			 <tr>
			 <td align="left" class="bodytext3">National ID / Passport No</td>
			 <td align="left" class="bodytext3"><input type="text" name="passportnumber" id="passportnumber" size="20" style="border:solid 1px #001E6A;"></td>
			 <td align="left" class="bodytext3">National ID / Passport Country</td>
			 <td align="left" class="bodytext3"><input type="text" name="passportcountry" id="passportcountry" size="20" style="border:solid 1px #001E6A;"></td>
			 </tr>
			 <tr>
			 <td align="left" class="bodytext3">SACCO No</td>
			 <td align="left" class="bodytext3"><input type="text" name="sacconumber" id="sacconumber" size="20" style="border:solid 1px #001E6A;"></td>
			 <td align="left" class="bodytext3">Cost Center Name</td>
			 <td align="left" class="bodytext3"><input type="text" name="costcenter" id="costcenter" size="20" style="border:solid 1px #001E6A;"></td>
			 </tr>
			 <tr>
			<td colspan="4" align="left" valign="middle"  bgcolor="#CCCCCC" class="bodytext3"><strong>Bank Details</strong></td>
			</tr>
			<tr>
			 <td align="left" class="bodytext3">Bank Name</td>
			 <td align="left" class="bodytext3"><input type="text" name="bankname" id="bankname" size="30" style="border:solid 1px #001E6A;"></td>
			 <td align="left" class="bodytext3">Branch</td>
			 <td align="left" class="bodytext3"><input type="text" name="bankbranch" id="bankbranch" size="20" style="border:solid 1px #001E6A;"></td>
			 </tr>
			 <tr>
			 <td align="left" class="bodytext3">Account No</td>
			 <td align="left" class="bodytext3"><input type="text" name="accountnumber" id="accountnumber" size="30" style="border:solid 1px #001E6A;"></td>
			 <td align="left" class="bodytext3">Bank Code</td>
			 <td align="left" class="bodytext3"><input type="text" name="bankcode" id="bankcode" size="20" style="border:solid 1px #001E6A;"></td>
			 </tr>
			 <tr>
			<td colspan="4" align="left" valign="middle"  bgcolor="#CCCCCC" class="bodytext3"><strong>Insurance Details</strong></td>
			</tr>
			<tr>
			 <td align="left" class="bodytext3">Company Name</td>
			 <td align="left" class="bodytext3"><input type="text" name="insurancename" id="insurancename" size="30" style="border:solid 1px #001E6A;"></td>
			 <td align="left" class="bodytext3">City</td>
			 <td align="left" class="bodytext3"><input type="text" name="insurancecity" id="insurancecity" size="20" style="border:solid 1px #001E6A;"></td>
			 </tr>
			 <tr>
			 <td align="left" class="bodytext3">Policy Type</td>
			 <td align="left" class="bodytext3"><input type="text" name="policytype" id="policytype" size="20" style="border:solid 1px #001E6A;"></td>
			 <td align="left" class="bodytext3">Policy No</td>
			 <td align="left" class="bodytext3"><input type="text" name="policynumber" id="policynumber" size="20" style="border:solid 1px #001E6A;"></td>
			 </tr>
			  <tr>
			  <td align="left" class="bodytext3">Valid From</td>
			  <td align="left" class="bodytext3"><input type="text" name="policyfrom" id="policyfrom" readonly="readonly" size="10" style="border:solid 1px #001E6A;">
			  <img src="images2/cal.gif" onClick="javascript:NewCssCal('policyfrom')" style="cursor:pointer"/>	</td>
			  <td align="left" class="bodytext3">Valid To</td>
			  <td align="left" class="bodytext3"><input type="text" name="policyto" id="policyto" readonly="readonly" size="10" style="border:solid 1px #001E6A;">
			  <img src="images2/cal.gif" onClick="javascript:NewCssCal('policyto')" style="cursor:pointer"/>	</td>
			  </tr>
			  <tr>
			  <td align="left" class="bodytext3">Pension Membership No</td>
			  <td align="left" class="bodytext3"><input type="text" name="pensionno" id="pensionno" size="20" style="border:solid 1px #001E6A;">
			  </td>
			  <td align="left" class="bodytext3">&nbsp;</td>
			  <td align="left" class="bodytext3">&nbsp;</td>
			  </tr>
			  <tr>
			<td colspan="4" align="left" valign="middle"  bgcolor="#CCCCCC" class="bodytext3"><strong>Qualification</strong></td>
			</tr>
			<tr>
			 <td align="left" class="bodytext3">Basic</td>
			 <td align="left" class="bodytext3"><input type="text" name="qualificationbasic" id="qualificationbasic" size="30" style="border:solid 1px #001E6A;"></td>
			 <td align="left" class="bodytext3">Additional</td>
			 <td align="left" class="bodytext3"><input type="text" name="qualificationadditional" id="qualificationadditional" size="30" style="border:solid 1px #001E6A;"></td>
			 </tr>
			  <tr>
			<td colspan="4" align="left" valign="middle"  bgcolor="#CCCCCC" class="bodytext3"><strong>Previous Employer</strong></td>
			</tr>
			<tr>
			 <td align="left" class="bodytext3">Name</td>
			 <td align="left" class="bodytext3"><input type="text" name="employername" id="employername" size="30" style="border:solid 1px #001E6A;"></td>
			 <td align="left" class="bodytext3">Address</td>
			 <td align="left" class="bodytext3"><input type="text" name="employeraddress" id="employeraddress" size="30" style="border:solid 1px #001E6A;"></td>
			 </tr>
			 <tr>
			<td colspan="4" align="left" valign="middle"  bgcolor="#CCCCCC" class="bodytext3"><strong>Others</strong></td>
			</tr>
			  <tr>
			  <td align="left" class="bodytext3">Promotion Due on</td>
			  <td align="left" class="bodytext3"><input type="text" name="promotiondue" id="promotiondue" readonly="readonly" size="10" style="border:solid 1px #001E6A;">
			  <img src="images2/cal.gif" onClick="javascript:NewCssCal('promotiondue')" style="cursor:pointer"/>	</td>
			  <td align="left" class="bodytext3">Increment Due on</td>
			  <td align="left" class="bodytext3"><input type="text" name="incrementdue" id="incrementdue" readonly="readonly" size="10" style="border:solid 1px #001E6A;">
			  <img src="images2/cal.gif" onClick="javascript:NewCssCal('incrementdue')" style="cursor:pointer"/>	</td>
			 </tr>
			 <tr>
			 <td align="left" class="bodytext3">Free Travel allowance</td>
			 <td align="left" class="bodytext3"><input type="checkbox" name="freetravel" id="freetravel" value="Yes"></td>
			 <td align="left" class="bodytext3">Company Car</td>
			 <td align="left" class="bodytext3"><input type="checkbox" name="companycar" id="companycar" value="Yes">
			 <span class="bodytext3">Vehicle No</span>&nbsp;&nbsp;<input type="text" name="vehicleno" id="vehicleno" size="15" style="border:solid 1px #001E6A;"></td>
			 </tr>
			 <tr>
			<td colspan="4" align="left" valign="middle"  bgcolor="#CCCCCC" class="bodytext3"><strong>Leaving</strong></td>
			</tr>
			  <tr>
			  <td align="left" class="bodytext3">Date of Leaving</td>
			  <td align="left" class="bodytext3"><input type="text" name="dol" id="dol" readonly="readonly" size="10" style="border:solid 1px #001E6A;">
			  <img src="images2/cal.gif" onClick="javascript:NewCssCal('dol')" style="cursor:pointer"/>	</td>
			  <td align="left" class="bodytext3">Is Black Listed ?</td>
			  <td align="left" class="bodytext3"><input type="checkbox" name="blacklisted" id="blacklisted" value="Yes"></td>
			  </tr>
			  <tr>
			  <td align="left" class="bodytext3">Reason for Leaving</td>
			  <td align="left" class="bodytext3"><input type="text" name="reasonforleaving" id="reasonforleaving" size="35" style="border:solid 1px #001E6A;"></td>
			  <td align="left" class="bodytext3">Last Job in Kenya for Expatriate</td>
			  <td align="left" class="bodytext3"><input type="checkbox" name="lastjobforexpatriate" id="lastjobforexpatriate" value="Yes"></td>
			  </tr>
			  <tr>
			  <td align="left" class="bodytext3">Employee Status on HOLD</td>
			  <td align="left" class="bodytext3"><input type="checkbox" name="hold" id="hold" value="Yes"></td>
			  <td align="left" class="bodytext3">Date of Holding</td>
			  <td align="left" class="bodytext3"><input type="text" name="doh" id="doh" readonly="readonly" size="10" style="border:solid 1px #001E6A;">
			    <img src="images2/cal.gif" onClick="javascript:NewCssCal('doh')" style="cursor:pointer"/></td>
			  </tr>
			 <tr>
			 <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			 </tr>
                 <tr>
                <td colspan="4" align="middle"  bgcolor="#E0E0E0"><div align="left">
                  <input type="hidden" name="frmflag1" value="frmflag1" />
                  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
                  <input name="Submit222" type="submit"  value="Save Employee" class="button" style="border: 1px solid #001E6A"/>
				  <input type="reset" name="reset" value="Reset" onClick="return WindowRedirect()" style="border: 1px solid #001E6A">
                </div></td>
              </tr>
            </tbody>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
    </table>
	</form>
<script language="javascript">


</script>
    </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

