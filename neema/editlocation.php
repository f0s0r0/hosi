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
	$locationanum = $_REQUEST['locationanum'];
	$location = $_REQUEST["location"];
	$locationcode = $_REQUEST["locationcode"];
	$prefix = $_REQUEST["prefix"];
	$suffix = $_REQUEST["suffix"];
	$address1 = $_REQUEST["address1"];
	$address2 = $_REQUEST["address2"];
	$phone = $_REQUEST["phone"];
	$email = $_REQUEST["email"];
	$status = $_REQUEST["status"];
	$ipaddress = $_REQUEST["ipaddress"];
	$nhif = $_REQUEST['nhif'];
	
	$locationcode = strtoupper($locationcode);
	$prefix = strtoupper($prefix);
	$suffix = strtoupper($suffix);
	$address1 = strtoupper($address1);
	$address2 = strtoupper($address2);

	$location = trim($location);
	$length=strlen($location);
	//echo $length;
	if ($length<=100)
	{
	$query2 = "select * from master_location where auto_number = '$locationanum'";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	$res2 = mysql_num_rows($exec2);
	if ($res2 != 0)
	{
		$query1 = "update master_location set locationcode = '$locationcode',locationname = '$location',prefix = '$prefix',suffix = '$suffix',address1 = '$address1',address2 = '$address2',phone = '$phone',email = '$email',ipaddress = '$ipaddress',nhif = '$nhif' where auto_number = '$locationanum'";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$errmsg = "Success. New location Updated.";
		//$bgcolorcode = 'success';
		header ("location:addlocation.php?bgcolorcode=success&&st=edit&&anum=$locationanum");
	}
	//exit();
	else
	{
		$errmsg = "Failed. location Already Exists.";
		//$bgcolorcode = 'failed';
		header ("location:editlocation.php?bgcolorcode=failed&&st=edit&&anum=$locationanum");
	}
	}
	else
	{
		$errmsg = "Failed. Only 100 Characters Are Allowed.";
		//$bgcolorcode = 'failed';
		header ("location:editlocation1.php?bgcolorcode=failed&&st=edit&&anum=$locationanum");
	}

}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_location set status = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
}
if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_location set status = '' where auto_number = '$delanum'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
}
if ($st == 'default')
{
	$delanum = $_REQUEST["anum"];
	$query4 = "update master_location set defaultstatus = '' where cstid='$custid' and cstname='$custname'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());

	$query5 = "update master_location set defaultstatus = 'DEFAULT' where auto_number = '$delanum'";
	$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
}
if ($st == 'removedefault')
{
	$delanum = $_REQUEST["anum"];
	$query6 = "update master_location set defaultstatus = '' where auto_number = '$delanum'";
	$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
}


if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add location To Proceed For Billing.";
	$bgcolorcode = 'failed';
}


if (isset($_REQUEST["anum"])) { $anum = $_REQUEST["anum"]; } else { $anum = ""; }
if ($st == 'edit' && $anum != '')
{
    $query1 = "select * from master_location where auto_number = '$anum'";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	$res1 = mysql_fetch_array($exec1);
	$res1autonumber = $res1['auto_number'];
	$locationcode = $res1['locationcode'];
	$locationname = $res1['locationname'];
	$prefix = $res1['prefix'];
	$suffix = $res1['suffix'];
	$address1 = $res1['address1'];
	$address2 = $res1['address2'];
	$phone = $res1['phone'];
	$email = $res1['email'];
	$nhif = $res1['nhif'];
}

   
if (isset($_REQUEST["bgcolorcode"])) { $bgcolorcode = $_REQUEST["bgcolorcode"]; } else { $bgcolorcode = ""; }
if ($bgcolorcode == 'success')
{
		$errmsg = "Success. New location Updated.";
}
if ($bgcolorcode == 'failed')
{
		$errmsg = "Failed. location Already Exists.";
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
	if (document.form1.location.value == "")
	{
		alert ("Pleae Enter location Name.");
		document.form1.location.focus();
		return false;
	}
}

function ucFirstAllWords1( str,id,key)
{
	var keycode = (key.which) ? key.which : key.keyCode;	
	//alert(str);		
		
		
		if(document.getElementById('fullnamevaild').value=='1')
		{
			//pieces=1;
			//var pieces = str.split(" ");
			var str=str;
			//alert(str);
		}
		else
		{
			var str=str;
			//var pieces = str.split(" ");
			//var pieces = pieces.length;
		}
		var pieces = str.split(" ");
		//alert(pieces);
		for ( var i = 0; i < pieces.length; i++ )
		{
			var j = pieces[i].charAt(0).toUpperCase();
			pieces[i] = j + pieces[i].substr(1);
		}
		var word = pieces.join(" ");
		//alert(word);
		document.getElementById(id).value=word;
	
}
function funcDeletelocation1(varlocationAutoNumber)
{

     var varlocationAutoNumber = varlocationAutoNumber;
	 var fRet;
	fRet = confirm('Are you sure want to delete this Consultation Type '+varlocationAutoNumber+'?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("location  Entry Delete Completed.");
		//return false;
	}
	if (fRet == false)
	{
		alert ("location Entry Delete Not Completed.");
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
              <td><form name="form1" id="form1" method="post" action="editlocation.php" onSubmit="return addward1process1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Location Master - Edit </strong></td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                     <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Location Code </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="locationcode" id="locationcode" style="border: 1px solid #001E6A; text-transform:uppercase;" size="40" value="<?php echo $locationcode; ?>"/></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Edit  Location 
                    </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="location" id="location" value="<?php echo $locationname; ?>" onKeyPress="ucFirstAllWords1(this.value,this.id,event)" style="border: 1px solid #001E6A; " size="40" /><input name="fullnamevaild" id="fullnamevaild" type="hidden"></td>
                      </tr> 
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">PREFIX</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="prefix" id="prefix" value="<?php echo $prefix; ?>" style="border: 1px solid #001E6A; text-transform:uppercase;" size="40" /></td>
                      </tr>
                     <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">SUFFIX</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="suffix" id="suffix" value="<?php echo $suffix; ?>" style="border: 1px solid #001E6A; text-transform:uppercase; " size="40" /></td>
                      </tr>
                     <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">ADDRESS1</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="address1" id="address1" value="<?php echo $address1; ?>" style="border: 1px solid #001E6A; text-transform:uppercase;" size="40" /></td>
                      </tr>
                     <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">ADDRESS2</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="address2" id="address2" value="<?php echo $address2; ?>" style="border: 1px solid #001E6A;  text-transform:uppercase;" size="40" /></td>
                      </tr>
                     <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">PHONE</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="phone" id="phone" value="<?php echo $phone; ?>" style="border: 1px solid #001E6A; " size="40" /></td>
                      </tr>
                     <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">EMAIL </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="email" id="email" value="<?php echo $email; ?>" style="border: 1px solid #001E6A;" size="40" /></td>
                      </tr>
                     <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">NHIF </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="nhif" id="nhif" value="<?php echo $nhif; ?>" style="border: 1px solid #001E6A;" size="40" /></td>
                      </tr>
                      <tr>
                        <td width="42%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td width="58%" align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="hidden" name="frmflag" value="addnew" />
                            <input type="hidden" name="frmflag1" value="frmflag1" />
							<input type="hidden" name="locationanum" id="locationanum" value="<?php echo $res1autonumber; ?>">
                          <input type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A" /></td>
                      </tr>
                      <tr>
                        <td align="middle" colspan="2" >&nbsp;</td>
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

