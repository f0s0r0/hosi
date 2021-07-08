<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$date = date('Y-m-d');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{

	$shelf = $_REQUEST["shelf"];
	$shelfanum1 = $_REQUEST['shelfanum'];
	//$shelf = strtoupper($shelf);
	$shelf = trim($shelf);
	
	
	$length=strlen($shelf);
	$shelfcharges = $_REQUEST['shelfcharges'];

	//echo $length;
	if ($length<=100)
	{
	$query1 = "update master_shelf set shelf='$shelf',shelfcharges='$shelfcharges'  where auto_number='$shelfanum1'";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		
	
		$errmsg = "Success. New shelf Updated.";
		$bgcolorcode = 'success';
		
		}
	//exit();
	
	
	else
	{
		$errmsg = "Failed. Only 100 Characters Are Allowed.";
		$bgcolorcode = 'failed';
	}
header("location:mortuaryshelves.php");
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_shelf set recordstatus = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
}
if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_shelf set recordstatus = '' where auto_number = '$delanum'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
}
if ($st == 'default')
{
	$delanum = $_REQUEST["anum"];
	$query4 = "update master_shelf set defaultstatus = '' where cstid='$custid' and cstname='$custname'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());

	$query5 = "update master_shelf set defaultstatus = 'DEFAULT' where auto_number = '$delanum'";
	$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
}
if ($st == 'removedefault')
{
	$delanum = $_REQUEST["anum"];
	$query6 = "update master_shelf set defaultstatus = '' where auto_number = '$delanum'";
	$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
}


if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add shelf To Proceed For Billing.";
	$bgcolorcode = 'failed';
}
if (isset($_REQUEST["anum"])) { $anum = $_REQUEST["anum"]; } else { $anum = ""; }

$query74 = "select * from master_shelf where auto_number='$anum'";
$exec74 = mysql_query($query74) or die(mysql_error());
$res74 = mysql_fetch_array($exec74);
$shelf = $res74['shelf'];
$shelfcharges = $res74['shelfcharges'];
/*

$query741 = "select * from master_shelfcharge where shelf='$shelf' and charge='shelf Charges'";
$exec741 = mysql_query($query741) or die(mysql_error());
$res741 = mysql_fetch_array($exec741);
$shelfcharges = $res741['rate'];

$query742 = "select * from master_shelfcharge where shelf='$shelf' and charge='Nursing Charges'";
$exec742 = mysql_query($query742) or die(mysql_error());
$res742 = mysql_fetch_array($exec742);
$nursingcharges = $res742['rate'];

$query743 = "select * from master_shelfcharge where shelf='$shelf' and charge='RMO Charges'";
$exec743 = mysql_query($query743) or die(mysql_error());
$res743 = mysql_fetch_array($exec743);
$rmocharges = $res743['rate'];

$grace = $res74['grace'];
$grace = intval($grace);
$query55 = "select * from master_ward where auto_number='$wardanum'";
						  $exec55 = mysql_query($query55) or die(mysql_error());
						  $res55 = mysql_fetch_array($exec55);
						  $wardfullname = $res55['ward'];*/
	
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
<script type="text/javascript" src="js/insertnewitemshelf.js"></script>
<script language="javascript">

function addshelfprocess1()
{
	//alert ("Inside Funtion");
	if (document.form1.shelf.value == "")
	{
		alert ("Please Enter shelf Name.");
		document.form1.shelf.focus();
		return false;
	}
	if (document.form1.ward.value == "")
	{
		alert ("Please Select ward.");
		document.form1.ward.focus();
		return false;
	}
}
function btnDeleteClick9(delID5)
{
	//alert ("Inside btnDeleteClick.");
	var newtotal2;
	//alert(radrate);
	var varDeleteID2= delID5;
	//alert (varDeleteID2);
	var fRet5; 
	fRet5 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet5 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child2= document.getElementById('idTR'+varDeleteID2);  //tr name
    var parent2 = document.getElementById('insertrow2'); // tbody name.
	document.getElementById ('insertrow2').removeChild(child2);
	
	var child2 = document.getElementById('idTRaddtxt'+varDeleteID2);  //tr name
    var parent2 = document.getElementById('insertrow2'); // tbody name.
	//alert (child);
	if (child2 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow2').removeChild(child2);
	}
	
		

	
}
function funcDeleteshelf(varshelfAutoNumber)
{
     var varshelfAutoNumber = varshelfAutoNumber;
	 var fRet;
	fRet = confirm('Are you sure want to delete this shelf Type '+varshelfAutoNumber+'?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("shelf Entry Delete Completed.");
		//return false;
	}
	if (fRet == false)
	{
		alert ("shelf Entry Delete Not Completed.");
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
              <td><form name="form1" id="form1" method="post" action="editshelf.php" onSubmit="return addshelfprocess1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Shelf Master - Edit</strong></td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
					   
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Edit Shelf </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="shelf" id="shelf" style="border: 1px solid #001E6A;" size="40" value="<?php echo $shelf; ?>" />
						<input type="hidden" name="shelfanum" id="shelfanum" value="<?php echo $anum; ?>"></td>
                      </tr>
                   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Shelf Charges</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="shelfcharges" id="shelfcharges" style="border: 1px solid #001E6A;" size="10" value="<?php echo $shelfcharges; ?>"/></td>
                      </tr>
				
			    
					   <!--<tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Grace </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="grace" id="grace" style="border: 1px solid #001E6A;" size="10" value="<?php echo $grace; ?>"/></td>
                      </tr>-->
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

