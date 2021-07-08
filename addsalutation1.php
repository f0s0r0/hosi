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

	$salutation = $_REQUEST["salutation"];
	//$salutation = strtoupper($salutation);
	$salutation = trim($salutation);
	$length=strlen($salutation);
	$gender = $_REQUEST["gender"];
	//echo $length;
	if ($length<=100)
	{
	$query2 = "select * from master_salutation where salutation = '$salutation' and gender = '$gender'";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	$res2 = mysql_num_rows($exec2);
	if ($res2 == 0)
	{
		$query1 = "insert into master_salutation (salutation, gender, ipaddress, recorddate, username) 
		values ('$salutation', '$gender', '$ipaddress', '$updatedatetime', '$username')";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$errmsg = "Success. New Salutation Updated.";
		$bgcolorcode = 'success';
		
	}
	//exit();
	else
	{
		$errmsg = "Failed. Salutation Already Exists.";
		$bgcolorcode = 'failed';
	}
	}
	else
	{
		$errmsg = "Failed. Only 100 Characters Are Allowed.";
		$bgcolorcode = 'failed';
	}

}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_salutation set recordstatus = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
}
if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_salutation set recordstatus = '' where auto_number = '$delanum'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
}
if ($st == 'default')
{
	$delanum = $_REQUEST["anum"];
	$query4 = "update master_salutation set defaultstatus = '' where cstid='$custid' and cstname='$custname'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());

	$query5 = "update master_salutation set defaultstatus = 'DEFAULT' where auto_number = '$delanum'";
	$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
}
if ($st == 'removedefault')
{
	$delanum = $_REQUEST["anum"];
	$query6 = "update master_salutation set defaultstatus = '' where auto_number = '$delanum'";
	$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
}


if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add Salutation To Proceed For Billing.";
	$bgcolorcode = 'failed';
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

function addsalutation1process1()
{
	//alert ("Inside Funtion");
	if (document.form1.salutation.value == "")
	{
		alert ("Please Enter Salutation Name.");
		document.form1.salutation.focus();
		return false;
	}
	if (document.form1.gender.value == "")
	{
		alert ("Please Select Gender.");
		document.form1.gender.focus();
		return false;
	}
}

function funcDeleteSalutation(varSalutationAutoNumber)
{
     var varSalutationAutoNumber = varSalutationAutoNumber;
	 var fRet;
	fRet = confirm('Are you sure want to delete this Salutation Type '+varSalutationAutoNumber+'?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("Salutation Entry Delete Completed.");
		//return false;
	}
	if (fRet == false)
	{
		alert ("Salutation Entry Delete Not Completed.");
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
              <td><form name="form1" id="form1" method="post" action="addsalutation1.php" onSubmit="return addsalutation1process1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Salutation Master - Add New </strong></td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Add New Salutation </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="salutation" id="salutation" style="border: 1px solid #001E6A;" size="40" /></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
						<div align="right">Select Gender </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="gender">
                          <option value="" selected="selected">Select Gender</option>
                          <option value="MALE">MALE</option>
                          <option value="FEMALE">FEMALE</option>
                        </select></td>
                      </tr>
                      <tr>
                        <td width="42%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td width="58%" align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="hidden" name="frmflag" value="addnew" />
                            <input type="hidden" name="frmflag1" value="frmflag1" />
                          <input type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A" /></td>
                      </tr>
                      <tr>
                        <td align="middle" colspan="2" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Salutation Master - Existing List </strong></td>
                        <td width="46%" bgcolor="#CCCCCC" class="bodytext3"><strong>Gender </strong></td>
                        <td width="9%" bgcolor="#CCCCCC" class="bodytext3"><strong>Edit</strong></td>
                      </tr>
                      <?php
	    $query1 = "select * from master_salutation where recordstatus <> 'deleted' order by salutation ";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		while ($res1 = mysql_fetch_array($exec1))
		{
		$salutation = $res1["salutation"];
		$gender = $res1['gender'];
		$auto_number = $res1["auto_number"];
		//$defaultstatus = $res1["defaultstatus"];

		$colorloopcount = $colorloopcount + 1;
		$showcolor = ($colorloopcount & 1); 
		if ($showcolor == 0)
		{
			$colorcode = 'bgcolor="#CBDBFA"';
		}
		else
		{
			$colorcode = 'bgcolor="#D3EEB7"';
		}
		  
		?>
        <tr <?php echo $colorcode; ?>>
                        <td width="6%" align="left" valign="top"  class="bodytext3">
						<div align="center">
						<a href="addsalutation1.php?st=del&&anum=<?php echo $auto_number; ?>" onClick="return funcDeleteSalutation('<?php echo $Salutation ?>')">
						<img src="images/b_drop.png" width="16" height="16" border="0" /></a>						</div>						</td>
                        <td width="39%" align="left" valign="top"  class="bodytext3"><?php echo $salutation; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $gender; ?> </td>
                        <td align="left" valign="top"  class="bodytext3">
						<a href="editsalutation1.php?st=edit&&anum=<?php echo $auto_number; ?>" style="text-decoration:none">Edit</a></td>
        </tr>
                      <?php
		}
		?>
           <tr>
                        <td align="middle" colspan="4" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="3" bgcolor="#CCCCCC" class="bodytext3"><strong>Salutation Master - Deleted </strong></td>
                      </tr>
                      <?php
		
	    $query1 = "select * from master_salutation where recordstatus = 'deleted' order by salutation ";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		while ($res1 = mysql_fetch_array($exec1))
		{
		$salutation = $res1['salutation'];
		$gender = $res1['gender'];
		$auto_number = $res1["auto_number"];

		$colorloopcount = $colorloopcount + 1;
		$showcolor = ($colorloopcount & 1); 
		if ($showcolor == 0)
		{
			$colorcode = 'bgcolor="#CBDBFA"';
		}
		else
		{
			$colorcode = 'bgcolor="#D3EEB7"';
		}
		?>
        <tr <?php echo $colorcode; ?>>
                        <td width="11%" align="left" valign="top"  class="bodytext3">
						<a href="addsalutation1.php?st=activate&&anum=<?php echo $auto_number; ?>" class="bodytext3">
                          <div align="center" class="bodytext3">Activate</div>
                        </a></td>
                        <td width="35%" align="left" valign="top"  class="bodytext3"><?php echo $salutation; ?></td>
                        <td width="54%" align="left" valign="top"  class="bodytext3"><?php echo $gender; ?></td>
        </tr>
                      <?php
		}
		?>
                      <tr>
                        <td align="middle" colspan="3" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
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

