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
    $store = $_REQUEST['store'];
	$location = $_REQUEST["location"];
	//$store = $_REQUEST["typecode"];
	$store = strtoupper($store);
	$store = trim($store);
	$storenumber = $_REQUEST["idname"];
	$length=strlen($store);
	
	$description = $_REQUEST["description"];
	$calories = $_REQUEST["calories"];
	$amount = $_REQUEST["amountkit"];
	//$location = $_REQUEST["location"];
	//$location = $_REQUEST["location"];
	//$location = $_REQUEST["location"];
	
	$query6 = "select * from master_location where locationcode = '$location'";
	$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
	$res6 = mysql_fetch_array($exec6);
	$locationcode = $res6['locationcode'];
	$locationname = $res6['locationname'];
	//echo $length;
	echo 'tk';
	$query2 = "select * from master_ipkitchen where auto_number = '$storenumber'";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	$res2 = mysql_num_rows($exec2);
	if ($res2 != 0)
	{echo 'ok';
	    $query1 = "update master_ipkitchen set typename = '$store',locationcode = '$locationcode',locationname = '$locationname',description='".$description."',calories='".$calories."',edit_ipaddress='".$ipaddress."',edit_username='".$username."',edit_datetime='".date('Y-m-d h:i:s')."',rate='".$amount."' where auto_number = '$storenumber'";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$errmsg = "Success. New Store Updated.";
		//$bgcolorcode = 'success';
		header ("location:addkitchenmaster.php?bgcolorcode=success&&st=edit&&anum=$storeanum");
		exit();
	}
	//exit();
	else
	{
		$errmsg = "Failed. Name Already Exists.";
		//$bgcolorcode = 'failed';
	header ("location:editipkitchen.php?bgcolorcode=failed&&st=edit&&anum=$storeanum");
	exit();
	}
	
	

}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_ipkitchen set recordstatus = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
}
if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_ipkitchen set recordstatus = '' where auto_number = '$delanum'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
}
if ($st == 'default')
{
	$delanum = $_REQUEST["anum"];
	$query4 = "update master_ipkitchen set defaultstatus = '' where cstid='$custid' and cstname='$custname'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());

	$query5 = "update master_ipkitchen set defaultstatus = 'DEFAULT' where auto_number = '$delanum'";
	$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
}
if ($st == 'removedefault')
{
	$delanum = $_REQUEST["anum"];
	$query6 = "update master_ipkitchen set defaultstatus = '' where auto_number = '$delanum'";
	$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
}

if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add Store To Proceed For Billing.";
	$bgcolorcode = 'failed';
}

if (isset($_REQUEST["anum"])) { $anum = $_REQUEST["anum"]; } else { $anum = ""; }
if ($st == 'edit' && $anum != '')
{
	$query1 = "select * from master_ipkitchen where auto_number = '$anum'";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	$res1 = mysql_fetch_array($exec1);
	$getautonumber = $res1['auto_number'];
    $getlocationname = $res1['locationname'];
	$getlocationcode = $res1['locationcode'];
    $gettypename = $res1['typename'];
	$getrate = $res1['rate'];
	$gettypecode = $res1['typecode'];
	$getdescription = $res1['description'];
	$getcalories = $res1['calories'];
	
}

if (isset($_REQUEST["bgcolorcode"])) { $bgcolorcode = $_REQUEST["bgcolorcode"]; } else { $bgcolorcode = ""; }
if ($bgcolorcode == 'success')
{
		$errmsg = "Success. New Store Updated.";
}
if ($bgcolorcode == 'failed')
{
		$errmsg = "Failed. Visit Sub Already Exists.";
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
	if (document.form1.store.value == "")
	{
		alert ("Pleae Enter Name.");
		document.form1.store.focus();
		return false;
	}
	if (document.form1.description.value == "")
	{
		alert ("Pleae Enter Description.");
		document.form1.description.focus();
		return false;
	}
	if (document.form1.calories.value == "")
	{
		alert ("Pleae Enter Calories.");
		document.form1.calories.focus();
		return false;
	}
	if (document.form1.amountkit.value == "")
	{
		alert ("Pleae Enter Amount.");
		document.form1.amountkit.focus();
		return false;
	}
}
function funcDeletestore(varstoreAutoNumber)
{
 var varstoreAutoNumber = varstoreAutoNumber;
	var fRet;
	fRet = confirm('Are you sure want to delete this account name '+varstoreAutoNumber+'?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("Store Entry Delete Completed.");
		//return false;
	}
	if (fRet == false)
	{
		alert ("Store Entry Delete Not Completed.");
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
              <td><form name="form1" id="form1" method="post" action="editipkitchen.php" onSubmit="return addward1process1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Kitchen Master - Edit </strong></td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Location </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
                        <input type="hidden" name="idname" value="<?php echo $_REQUEST['anum'];?>">
						<select name="location" id="location"  style="border: 1px solid #001E6A;">
						
                          <?php
				$query5 = "select * from master_location where status = '' order by locationname";
				$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
				while ($res5 = mysql_fetch_array($exec5))
				{
				$res5code = $res5["locationcode"];
				$res5location = $res5["locationname"];
				?>
                          <option value="<?php echo $res5code; ?>" <?php if($getlocationcode==$res5code){echo "selected";}?>><?php echo $res5location; ?></option>
                          <?php
				}
				?>
                        </select>
						</td>
                      </tr>
                       <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Menu No </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="storeno" id="storeno" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" readonly value="<?php echo $gettypecode;?>"/></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Add New Menu </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="store" id="store" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" value="<?php echo $gettypename;?>"/></td>
                      </tr>
					  
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Description</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="description" id="description" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" value="<?php echo $getdescription;?>"/></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Calories</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="calories" id="calories" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" onKeyPress="return isNumberDecimal(event)" value="<?php echo $getcalories;?>"/></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Amount</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="amountkit" id="amountkit" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" onKeyPress="return isNumberDecimal(event)" value="<?php echo $getrate;?>"/></td>
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

