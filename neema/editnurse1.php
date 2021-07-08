<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
    $nurseanum = $_REQUEST["nurseanum"];
	$nursename = $_REQUEST["nursename"];
	$nursename = strtoupper($nursename);
	$nursename = trim($nursename);
	$length=strlen($nursename);
	$ipaddress = $_REQUEST["ipaddress"];
	$recorddate = $_REQUEST["recorddate"];
	$username = $_REQUEST["username"];
	
	//echo $length;
	if ($length<=100)
	{
	$query2 = "select * from master_nurse where auto_number = '$nurseanum'";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	$res2 = mysql_num_rows($exec2);
	if ($res2 != 0)
	{
		$query1 = "update master_nurse set nursename = '$nursename',ipaddress = '$ipaddress',ipaddress = '$recorddate', username = '$username'";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$errmsg = "Success. New nurse Updated.";
		//$bgcolorcode = 'success';
		header ("location:editnurse1.php?bgcolorcode=success&&st=edit&&anum=$nurseanum");
		
	}
	//exit();
	else
	{
		$errmsg = "Failed. nurse Already Exists.";
		//$bgcolorcode = 'failed';
		header ("location:editnurse1.php?bgcolorcode=failed&&st=edit&&anum=$nurseanum");
	}
	}
	else
	{
		$errmsg = "Failed. Only 100 Characters Are Allowed.";
		//$bgcolorcode = 'failed';
		header ("location:editnurse1.php?bgcolorcode=failed&&st=edit&&anum=$nurseanum");
	}

}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_nurse set recordstatus = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
}
if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_nurse set recordstatus = '' where auto_number = '$delanum'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
}
if ($st == 'default')
{
	$delanum = $_REQUEST["anum"];
	$query4 = "update master_nurse set defaultstatus = '' where cstid='$custid' and cstname='$custname'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());

	$query5 = "update master_nurse set defaultstatus = 'DEFAULT' where auto_number = '$delanum'";
	$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
}
if ($st == 'removedefault')
{
	$delanum = $_REQUEST["anum"];
	$query6 = "update master_nurse set defaultstatus = '' where auto_number = '$delanum'";
	$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
}


if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add nurse To Proceed For Billing.";
	$bgcolorcode = 'failed';
}

if (isset($_REQUEST["anum"])) { $anum = $_REQUEST["anum"]; } else { $anum = ""; }
if ($st == 'edit' && $anum != '')
{
    $query1 = "select * from master_nurse where auto_number = '$anum'";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	$res1 = mysql_fetch_array($exec1);
	$res1autonumber = $res1['auto_number'];
	$res1nursename = $res1['nursename'];
}
   
if (isset($_REQUEST["bgcolorcode"])) { $bgcolorcode = $_REQUEST["bgcolorcode"]; } else { $bgcolorcode = ""; }
if ($bgcolorcode == 'success')
{
		$errmsg = "Success. New Department Updated.";
}
if ($bgcolorcode == 'failed')
{
		$errmsg = "Failed. Department Already Exists.";
}
?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
</style>
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<script language="javascript">

function addward1process1()
{
	//alert ("Inside Funtion");
	if (document.form1.nurse.value == "")
	{
		alert ("Pleae Enter nurse Name.");
		document.form1.nurse.focus();
		return false;
	}
}

function funcDeleteNurse1(varNurseAutoNumber)
{

     var varNurseAutoNumber = varNurseAutoNumber;
	 var fRet;
	fRet = confirm('Are you sure want to delete this Nurse '+varNurseAutoNumber+'?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("Nurse  Entry Delete Completed.");
		//return false;
	}
	if (fRet == false)
	{
		alert ("Nurse Entry Delete Not Completed.");
		return false;
	}

}

</script>
<body>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
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
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
            <tr>
              <td><form name="form1" id="form1" method="post" action="editnurse1.php" onSubmit="return addward1process1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Nurse  Master - Add New </strong></td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Add New Nurse </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="nursename" id="nursename" value="<?php echo $res1nursename;?>" style="border: 1px solid #001E6A; text-transform:uppercase;" size="40" /></td>
                      </tr>
                      <tr>
                        <td width="42%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td width="58%" align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="hidden" name="frmflag" value="addnew" />
                            <input type="hidden" name="frmflag1" value="frmflag1" />
							<input type="hidden" name="nurseanum" id="nurseanum" value="<?php echo $res1autonumber; ?>">
                          <input type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A" /></td>
                      </tr>
                      <tr>
                        <td align="middle" colspan="2" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                  <p>&nbsp;</p>
              </form>
                </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

