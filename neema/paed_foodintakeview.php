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

if($visitcode!='' && $patientcode!='')
{
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

	
	$query3 = "select * from paed_foodintake where visitcode='$visitcode' and patientcode='$patientcode' and docno = '$docno' order by auto_number desc ";
	$exec3 = mysql_query($query3) or die(mysql_error());
	$num3 = mysql_num_rows($exec3);
	$res3 = mysql_fetch_array($exec3);
	$res3intaketime = $res3['intaketime'];
    $res3intaketime=date("g:i a",strtotime($res3intaketime));
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
<script src="js/datetimepicker_css.js"></script> 
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

function popup()
{
  NewWindow=window.open('foodintakechart1.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>','newWin','width=700,height=400,left=0,top=0,toolbar=No,location=No,scrollbars=No,status=No,resizable=Yes,fullscreen=No');
  //NewWindow.focus();
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
    <td colspan="10" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <form name="form1" id="form1" method="post" action="paed_foodintakeview.php" onSubmit="return from1submit1()">
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
          <td width="14%" align="left" valign="middle" class="bodytext3"><strong><?php echo $ward; ?></strong></td>
          <td width="5%" align="left" valign="middle" class="bodytext3"><strong>IP No.</strong></td>
          <td width="10%" align="left" valign="middle" class="bodytext3"><?php echo $visitcode; ?>
		  <input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode;?>">
		  <input type="hidden" name="docno" id="docno" value="<?php echo $docno;?>"></td>
        </tr>
        <tr>
          <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>DOB</strong></td>
          <td width="28%" colspan="4" bgcolor="#E0E0E0" class="bodytext3">
		  <input name="dob" id="dob" style="border: 1px solid #001E6A" value="<?php echo $dob;?>" size="6" onKeyDown="return disableEnterKey()"/>
		  <img src="images2/cal.gif" onClick="javascript:NewCssCal('dob')" style="cursor:pointer"/></td>
          <td width="14%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Age</strong></td>
          <td align="left" class="bodytext3" valign="middle"><input type="text" name="age" id="age" value="<?php echo $age;?>" size="5"></td>
          <td align="left" valign="middle" class="bodytext3"><strong>Sex</strong></td>
          <td align="left" class="bodytext3" valign="middle"><select name="sex" id="sex" value=""  tabindex="12" autocomplete="off">
            <option value="<?php echo  $gender;?>"><?php echo  $gender;?></option>
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
			<table width="848" height="260" border="0" align="left" cellpadding="4" cellspacing="0" id="AutoNumber3" style="border-collapse: collapse">
			 <tbody>
			   <tr>
			   <td height="20" colspan="3" bgcolor="#CCCCCC" class="bodytext3">&nbsp;</td>
			   </tr>
			   <tr>
			     <td width="17%" height="30" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><a href="" onclick='popup();'><strong>Click</strong></a></td>
				 <td width="27%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td width="56%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			   </tr>
			   <tr>
			     <td height="30" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     </tr>
			   <tr>
			     <td height="30" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     </tr>
			   <tr>
			     <td height="30" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     </tr>
			   <tr>
			     <td height="30" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     </tr>
			   <tr>
			     <td height="30" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     </tr>
			   <tr>
			     <td height="30" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
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
		  <input type="hidden" name="frmflag1" value="frmflag1"/>
          <input type="hidden" name="companyanum" value="<?php echo $companyanum; ?>" />
<!--          <input name="Submit222" type="submit"  value="Save Record" class="button"/>
-->		  </td>
        </tr>
    </table>
	</form>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

