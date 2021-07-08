<?php
session_start();
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$timeonly = date("H:i:s");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$errmsg = "";
$bgcolorcode = "";
$pagename = "";
$consultationfees1 = '';
$availablelimit = '';
$mrdno = '';
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];

$patientcode = '';
$patientname = '';

if (isset($_REQUEST["errorcode"])) { $errorcode = $_REQUEST["errorcode"]; } else { $errorcode = ""; }
//$patientcode = 'MSS00000009';
if ($errorcode == 'errorcode1failed')
{
	$errmsg = 'Patient Already Visited Today. Cannot Proceed With Visit Entry. Save Not Completed.';	
}

if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if($patientcode != '')
{
$query41 = "select * from master_customer where customercode='$patientcode'";
$exec41 = mysql_query($query41) or die(mysql_error());
$res41 = mysql_fetch_array($exec41);
$patientname = $res41['customerfullname'];
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$patientcode = 'MSS00000009';
if ($st == 'success')
{
	$errmsg = 'Appointment Saved Successfully';	
}

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
	$patientname=$_REQUEST["customer"];
	$patientcode=$_REQUEST["patientcode"];
	$appointmentdate = $_REQUEST["appointmentdate"];
	$appointmenttime = $_REQUEST["appointmenttime"];
	$department = $_REQUEST["department"];
	$hour = $_REQUEST['hour'.$p];
	$minute = $_REQUEST['minute'.$p];
	$starttime = $hour.':'.$minute;
    $sess = $_REQUEST['sess'.$p];
	
	$apnum = $_REQUEST['apnum'];
	$referal = $_REQUEST['referal'];
	$rate = $_REQUEST['rate4'];

	$query1 = "insert into appointmentschedule_entry (patientname,appointmentdate,appointmenttime,consultingdoctor,patientcode,department,session,recorddate,rate,username,ipaddress) 
	values('$patientname','$appointmentdate','$starttime','$referal','$patientcode','$department','$sess','$updatedatetime','$rate','$username','$ipaddress')";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	
	$status = 'success';
		
	header("location:appointmentscheduleentry.php?st=$status");
}
include ("autocompletebuild_referal.php");
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
<script type="text/javascript" src="js/membervalidation.js"></script>
<script language="javascript">
function process1()
{

	if (document.form1.department.value == "")
	{
		alert ("department Name Cannot Be Empty.");
		document.form1.department.focus();
		return false;
	}
	if (document.form1.doctor.value == "")
	{
		alert ("doctor Cannot Be Empty.");
		document.form1.doctor.focus();
		return false;
	}
	
	
}
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

function funcDepartmentChange1()
{
	<?php 
	$query12 = "select * from master_department where recordstatus = ''";
	$exec12 = mysql_query($query12) or die ("Error in Query11".mysql_error());
	while ($res12 = mysql_fetch_array($exec12))
	{
	$res12departmentanum = $res12['auto_number'];
	?>
	if(document.getElementById("department").value=="<?php echo $res12departmentanum; ?>")
	{
		document.getElementById("doctor").options.length=null; 
		var combo = document.getElementById('doctor'); 	
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Sub Type", ""); 
		<?php
		$query10 = "select * from master_doctor where auto_number = '$res12departmentanum' and status = ''";
		$exec10 = mysql_query($query10) or die ("error in query10".mysql_error());
		while ($res10 = mysql_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10doctoranum = $res10['auto_number'];
		$res10doctorname = $res10["doctorname"];
		?>
			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10doctorname;?>", "<?php echo $res10doctoranum;?>"); 
		<?php 
		}
		?>
	}
	<?php
	}
	?>	
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
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<script language="javascript">
function funcOnLoadBodyFunctionCall()
{
	funcCustomerDropDownSearch1(); //To handle ajax dropdown list.
	funcCustomerDropDownSearch7();
}
</script>

<?php include ("js/dropdownlist1newscripting1.php"); ?>
<script type="text/javascript" src="js/autosuggestnew1.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_newcustomer.js"></script>
<?php include ("js/dropdownlist1scriptingreferal.php"); ?>
<script type="text/javascript" src="js/autocomplete_referal.js"></script>
<script type="text/javascript" src="js/autosuggestreferal1.js"></script>
<script type="text/javascript" src="js/autoreferalcodesearch2.js"></script>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>

<script src="js/datetimepicker_css.js"></script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall()">
<table width="103%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#E0E0E0">
	<?php 
	
		include ("includes/menu1.php"); 
	
	//	include ("includes/menu2.php"); 
	
	?>	</td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top">


      	  <form name="form1" id="form1" method="post" action="appointmentscheduleentry.php" onKeyDown="return disableEnterKey(event)" onSubmit="return process1()">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="860"><table width="736" height="177" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
                <td bgcolor="#CCCCCC" class="bodytext3" colspan="2"><strong>Appointment Schedule Entry</strong></td>
                <!--<td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                </tr>
            <tr bgcolor="#011E6A">
              <td colspan="6" bgcolor="<?php if ($errmsg == '') { echo '#E0E0E0'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?></td>
             </tr>
            	<tr>
				  <td width="14%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Patient Name </td>
				  <td width="86%" align="left" valign="middle"  bgcolor="#E0E0E0">
				  <input name="customer" id="customer" size="60" autocomplete="off" value="<?php echo $patientname; ?>">
				  <input name="customerhiddentextbox" id="customerhiddentextbox" value="" type="hidden">				  </tr>
				
				<tr>
				  <td height="30" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Patient Reg ID </td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0">
				  <input name="patientcode" id="patientcode" size="20" value="<?php echo $patientcode; ?>"/></td>
				  </tr>
				<tr>
				<td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Appointment Date </td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input type="text" name="appointmentdate" id="appointmentdate" value="<?php //echo $registrationdate; ?>" readonly="readonly" >
                  <strong><span class="bodytext312"> 
				  <img src="images2/cal.gif" onClick="javascript:NewCssCal('appointmentdate')" style="cursor:pointer"/> 
				  </span></strong></td>
			    </tr>
                 <tr>
				<td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Appointment Time </td>
			      <td align="left" valign="middle"  bgcolor="#E0E0E0">
					<input type="text" name="hour" id="hour" size="4" placeholder="HH">
					<input type="text" name="minute" id="minute" size="4" placeholder="MM">
						<select name="sess" id="sess" width="10">
						<option value="am">AM</option>
						<option value="pm">PM</option>
						</select>				  </td>
				</tr>
                  <tr>
				<td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Department</td>
			      <td align="left" valign="middle"  bgcolor="#E0E0E0"><select name="department" id="department" onChange="return funcDepartmentChange1();">
                    <option value="" selected="selected">Select Department</option>
                    <?php
				$query5 = "select * from master_department where recordstatus = '' order by auto_number";
				$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
				while ($res5 = mysql_fetch_array($exec5))
				{
				$res5anum = $res5["auto_number"];
				$res5paymenttype = $res5["department"];
				?>
                    <option value="<?php echo $res5anum; ?>"><?php echo $res5paymenttype; ?></option>
                    <?php
				}
				?>
                  </select></td>
				</tr>
                  
                  <tr>
                    <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Doctor</td>
                    <td>
						<input name="referal" type="text" id="referal" size="20" autocomplete="off">
						 <input type="hidden" name="referalcode" id="referalcode" value="">
					</td>
                  </tr>
				  <tr>
                    <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Rate</td>
                    <td>
						<input name="rate4" type="text" id="rate4" size="20" autocomplete="off" readonly="readonly">
					</td>
                  </tr>
                  <tr>
				 <td></td>
				 <td>
				   <input type="hidden" name="frmflag1" value="frmflag1" />
                   <input name="Submit222" type="submit"  value="Save Appointment" class="button"/>
				</td>
                </tr>
                 <tr>
                   <td></td>
                   <td>&nbsp;</td>
                 </tr>
                 <tr>
                   <td></td>
                   <td>&nbsp;</td>
                 </tr>
            </tbody>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
    </table>
	</form>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>