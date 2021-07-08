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
if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if (isset($_REQUEST["docno"])) { $docno = $_REQUEST["docno"]; } else { $docno = ""; }
if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == "frmflag1")
{
	$docno = $_REQUEST["docno"];
	$patientcode = $_REQUEST["patientcode"];
	$visitcode = $_REQUEST["visitcode"];
	$intakedate = $_REQUEST["intakedate"];
	$intaketime = $_REQUEST["intaketime"];
	$intaketime=date("H:i",strtotime($intaketime)); 
	$milkgiven = $_REQUEST["milkgiven"];
	$milkremain = $_REQUEST["milkremain"];
	$milktaken = $_REQUEST["milktaken"];
	$milktakenngt = $_REQUEST["milktakenngt"];
	$amountvomit = $_REQUEST["amountvomit"];
	$timesvomit = $_REQUEST["timesvomit"];
	$watery = $_REQUEST["watery"];
	$timesdiarrohea = $_REQUEST["timesdiarrohea"];
	$totalvol = $_REQUEST["totalvol"];
	
	$query6 = "select visitcode from paed_foodintake where visitcode='$visitcode' and patientcode='$patientcode'";
	$exec6 = mysql_query($query6) or die(mysql_error());
	$num6 = mysql_num_rows($exec6);
	$res6 = mysql_fetch_array($exec6);
	if($num6=='0')
	{
		//echo 'insert'; exit;
	$query5 = "insert into paed_foodintake(docno,patientcode,visitcode,intakedate,milkgiven,milkremain,milktaken,milktakenngt,amountvomit,timesvomit,watery,timesdiarrohea,totalvol,intaketime,recorddate,username) values('$docno','$patientcode','$visitcode','$intakedate','$milkgiven','$milkremain','$milktaken','$milktakenngt','$amountvomit','$timesvomit','$watery','$timesdiarrohea','$totalvol','$intaketime','$updatedatetime','$username')";   
	$exec5 = mysql_query($query5) or die("Query5".mysql_error());
	}
	else
	{
		//echo 'update'; exit;
		$update=mysql_query("update paed_foodintake set intakedate='$intakedate',milkgiven='$milkgiven',milkremain='$milkremain',milktakenngt='$milktakenngt',amountvomit='$amountvomit',timesvomit='$timesvomit',watery='$watery',timesdiarrohea='$timesdiarrohea',totalvol='$totalvol',intaketime='$intaketime' where patientcode='$patientcode' and visitcode='$visitcode'");
		
	}
	header("location:peadiatricactivity.php");
}
if($visitcode!='' && $patientcode!='')
{
	$query3 = "select * from paed_foodintake where visitcode='$visitcode' and patientcode='$patientcode' and docno = '$docno' order by auto_number desc ";
	$exec3 = mysql_query($query3) or die(mysql_error());
	$num3 = mysql_num_rows($exec3);
	$res3 = mysql_fetch_array($exec3);
	$res3intaketime = $res3['intaketime'];
    $res3intaketime=date("g:i a",strtotime($res3intaketime));
	
	
	$query4 = "select * from paed_foodintake where visitcode='$visitcode' and patientcode='$patientcode'";
	$exec4 = mysql_query($query4) or die(mysql_error());
	$num4 = mysql_num_rows($exec4);
	$res4 = mysql_fetch_array($exec4);
	$intakedate = $res4['intakedate'];
	$milkgiven = $res4['milkgiven'];
	$milkremain = $res4['milkremain'];
	$milktaken = $res4['milktaken'];
	$milktakenngt = $res4['milktakenngt'];
	$amountvomit = $res4['amountvomit'];
	$timesvomit = $res4['timesvomit'];
	$watery = $res4['watery'];
	$timesdiarrohea = $res4['timesdiarrohea'];
	$totalvol = $res4['totalvol'];
	$intaketime = $res4['intaketime'];
	
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

$(function() {
$('#intaketime').timepicker({ 'step': 60 });
});

function isNumberDecimal(evt) 
{
//getting key code of pressed key  
var charCode = (evt.which) ? evt.which : evt.keyCode
//comparing pressed keycodes
if (charCode != 45 && (charCode != 46 || $(this).val().indexOf('.') != -1) && 
(charCode < 48 || charCode > 57))
return false;
return true;
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

function taken() 
{
var milkgiven = document.getElementById('milkgiven').value; 
var milkremain = document.getElementById('milkremain').value;
var result = parseFloat(milkgiven - milkremain).toFixed(2);
if (isNaN(result)) result=0;
	if (parseFloat(milkremain)>parseFloat(milkgiven)) 
	{
	  alert('Amount remaining greater than given');
	  return false;
	}
	document.getElementById('milktaken').value = result;
}

function vomit() 
{
var milktaken = document.getElementById('milktaken').value; 
var milktakenngt = document.getElementById('milktakenngt').value;
var amountvomit = document.getElementById('amountvomit').value; 
var timesvomit = document.getElementById('timesvomit').value;
var cd = parseFloat(milktaken) + parseFloat(milktakenngt);
var ef = parseFloat(amountvomit) * parseInt(timesvomit);  
var cdef = parseFloat(cd - ef).toFixed(2); 
if (isNaN(cdef)) cdef=0;
document.getElementById('totalvol').value = cdef;
}

</script>

<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<script language="javascript">

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
</script>

<script src="js/datetimepicker_css.js"></script>

<?php 

	$query1 = "select * from master_customer where customercode='$patientcode'";
	$exec1 = mysql_query($query1) or die(mysql_error());
	$num1 = mysql_num_rows($exec1);
	$res1 = mysql_fetch_array($exec1);
	$patientname = $res1['customerfullname'];
	$gender = $res1['gender'];
	$age = $res1['age'];
	$dob = $res1['dateofbirth'];
	
	$query = "select * from ip_bedallocation where patientcode='$patientcode'";
	$exec = mysql_query($query) or die(mysql_error());
	$num = mysql_num_rows($exec);
	$res = mysql_fetch_array($exec);
	$wardid = $res['ward'];
	
	$query2 = "select * from master_ward where auto_number='$wardid'";
	$exec2 = mysql_query($query2) or die(mysql_error());
	$num2 = mysql_num_rows($exec2);
	$res2 = mysql_fetch_array($exec2);
	$ward = $res2['ward'];

?>

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
  <form name="form1" id="form1" method="post" action="paed_foodintake.php" onSubmit="return from1submit1()">
  <tr>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top"><table width="93%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#E0E0E0" id="AutoNumber3" style="border-collapse: collapse">
      <tbody>
        <tr bgcolor="#E0E0E0">
          <td class="bodytext3" bgcolor="#E0E0E0" valign="middle"><strong>Name*</strong></td>
          <td width="28%" colspan="4" align="left" valign="middle" bgcolor="#E0E0E0" class="bodytext3"><?php echo $patientname; ?>
		  <input type="hidden" name="patientcode" value="<?php echo $patientcode; ?>"></td>
          <td bgcolor="#E0E0E0" class="bodytext3" valign="middle"><strong>Date of Admission</strong></td>
          <td width="11%" bgcolor="#E0E0E0" class="bodytext3" valign="middle">
		  <input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $transactiondatefrom; ?>" size="6"  readonly="readonly" onKeyDown="return disableEnterKey()" />
		  <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/></td>
          <td width="9%" align="left" valign="middle" class="bodytext3"><strong>Ward</strong></td>
          <td width="14%" align="left" valign="middle" class="bodytext3"><strong><input type="text" name="ward2" id="ward2" value="<?php echo $ward; ?>" size="15"></strong></td>
          <td width="5%" align="left" valign="middle" class="bodytext3"><strong>IP No.</strong></td>
          <td width="10%" align="left" valign="middle" class="bodytext3"><?php echo $visitcode; ?>
		  <input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode;?>">
		  <input type="hidden" name="docno" id="docno" value="<?php echo $docno;?>"></td>
        </tr>
        <tr>
          <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>DOB</strong></td>
          <td width="28%" colspan="4" bgcolor="#E0E0E0" class="bodytext3">
		  <input name="dob" id="dob" style="border: 1px solid #001E6A" value="<?php echo $dob; ?>" size="6" onKeyDown="return disableEnterKey()"/>
		  <img src="images2/cal.gif" onClick="javascript:NewCssCal('dob')" style="cursor:pointer"/></td>
          <td width="14%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Age</strong></td>
          <td align="left" class="bodytext3" valign="middle"><input type="text" name="age" id="age" value="<?php echo $age; ?>" size="5"></td>
          <td align="left" valign="middle" class="bodytext3"><strong>Sex</strong></td>
          <td align="left" class="bodytext3" valign="middle"><select name="sex" id="sex" value=""  tabindex="12" autocomplete="off">
            <?php 
			 	
			 	if($gender=='Female')
				{
					$gen='1';
				}
				else
				{
					$gen='0';
				}
				?>
                 <option value="<?php echo $gen; ?>"><?php echo $gender ?></option>
          </select></td>
          <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
          <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
        </tr>
      </tbody>
    </table>  
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="860">
			<table width="848" height="320" border="0" align="left" cellpadding="4" cellspacing="0" id="AutoNumber3" style="border-collapse: collapse">
			 <tbody>
			   <tr>
			   <td height="20" colspan="3" bgcolor="#CCCCCC" class="bodytext3"><strong>Date&nbsp;</strong><input name="intakedate" id="intakedate" style="border: 1px solid #001E6A" value="<?php echo $transactiondatefrom; ?>" size="6"  readonly="readonly" onKeyDown="return disableEnterKey()" />
		  <img src="images2/cal.gif" onClick="javascript:NewCssCal('intakedate')" style="cursor:pointer"/></td>
			   </tr>
			   <tr>
			     <td width="17%" height="30" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Time: 
				 <input id="intaketime" name="intaketime" type="text" class="time" value="<?php echo $intaketime;?>" data-scroll-default="7:00 am" size="9"/>
				 </td>
				 <td width="27%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">a. Amount of milk given (ml) </td>
			     <td width="56%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="milkgiven" id="milkgiven" value="<?php echo $milkgiven;?>" size="5" onKeyPress="return isNumberDecimal(event);"></td>
			   </tr>
			   <tr>
			     <td height="30" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">b. Amount of milk remaining in the cup (ml) </td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="milkremain" id="milkremain" value="<?php echo $milkremain;?>" size="5" onKeyPress="return isNumberDecimal(event);" onKeyUp="taken();"></td>
			     </tr>
			   <tr>
			     <td height="30" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Type of feed: </td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">c. Amount taken (a-b) </td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="milktaken" id="milktaken" value="<?php echo $milktaken;?>" size="5"></td>
			     </tr>
			   <tr>
			     <td height="30" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">d. Amount taken by NGT (ml) </td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="milktakenngt" id="milktakenngt" value="<?php echo $milktakenngt;?>" size="5" onKeyPress="return isNumberDecimal(event);"></td>
			     </tr>
			   <tr>
			     <td height="30" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Amount given: </td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">e. Amount vomitted (ml) </td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="amountvomit" id="amountvomit" value="<?php echo $amountvomit;?>" size="5" onKeyPress="return isNumberDecimal(event);"></td>
			     </tr>
			   <tr>
			     <td height="30" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">f. Number of times child had vomited </td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="timesvomit" id="timesvomit" value="<?php echo $timesvomit;?>" size="5" onKeyPress="return validatenumerics(event);" onKeyUp="vomit();"></td>
			     </tr>
			   <tr>
			     <td height="30" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">g. Watery diarrhea (Yes/No) </td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><select name="watery" id="watery" tabindex="12" autocomplete="off">
            <option value="0">No</option>
            <option value="1">Yes</option>
          </select></td>
			     </tr>
			   <tr>
			     <td height="30" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">h. No. of times child had diarrhea in 3 hrs </td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="timesdiarrohea" id="timesdiarrohea" value="<?php echo $timesdiarrohea;?>" size="5" onKeyPress="return validatenumerics(event);"></td>
			     </tr>
			   <tr>
			     <td height="30" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Total Volume ((c+d)-(e*f)) </strong></td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="totalvol" id="totalvol" value="<?php echo $totalvol;?>" size="5"></td>
			     </tr>
			   <tr>
			     <td height="30" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
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
          <input name="Submit222" type="submit"  value="Save Record" class="button"/>
		  </td>
        </tr>
    </table>
	</form>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

