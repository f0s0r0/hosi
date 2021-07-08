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

$bgcolorcode=isset($_REQUEST['bgcolorcode'])?$_REQUEST['bgcolorcode']:'';
$edit=isset($_REQUEST['edit'])?$_REQUEST['edit']:'';
if($edit=='1')
{
$errmsg = "Updated Successfully";
}
if($edit=='0')
{
$errmsg = "Updated Failed";
}

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{

	$instructions = $_REQUEST["instructions"];
	$shortcode = $_REQUEST["shortcode"];
	
	//$instructions = strtoupper($instructions);
	$instructions = trim($instructions);
	$length=strlen($instructions);
	//$gender = $_REQUEST["gender"];
	//echo $length;
	if ($length<=100)
	{
	$query2 = "select * from pharmainstructions where instructions = '$instructions' ";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	$res2 = mysql_num_rows($exec2);
	if ($res2 == 0)
	{
		$query1 = "insert into pharmainstructions (instructions,shortcode) 
		values ('$instructions','$shortcode')";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$errmsg = "Success. New instructions Updated.";
		$bgcolorcode = 'success';
		
	}
	//exit();
	else
	{
		$errmsg = "Failed. instructions Already Exists.";
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
	$query3 = "update pharmainstructions set recordstatus = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
}
if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update pharmainstructions set recordstatus = '' where auto_number = '$delanum'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
}




if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add instructions To Proceed For Billing.";
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

function addinstructions1process1()
{
	//alert ("Inside Funtion");
	if (document.form1.instructions.value == "")
	{
		alert ("Please Enter instructions Name.");
		document.form1.instructions.focus();
		return false;
	}
	if (document.form1.gender.value == "")
	{
		alert ("Please Select Gender.");
		document.form1.gender.focus();
		return false;
	}
}

function funcDeleteinstructions(varinstructionsAutoNumber)
{
     var varinstructionsAutoNumber = varinstructionsAutoNumber;
	 var fRet;
	fRet = confirm('Are you sure want to delete this instructions Type '+varinstructionsAutoNumber+'?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("instructions Entry Delete Completed.");
		//return false;
	}
	if (fRet == false)
	{
		alert ("instructions Entry Delete Not Completed.");
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
              <td><form name="form1" id="form1" method="post" action="pharmainstructions.php" onSubmit="return addinstructions1process1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Instructions Master - Add New </strong></td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Add New Instructions </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="instructions" id="instructions" style="border: 1px solid #001E6A;" size="40" /></td>
                      </tr>
					  
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Add Short code </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="shortcode" id="shortcode" style="border: 1px solid #001E6A;" size="40" /></td>
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
                        <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Instructions Master - Existing List </strong></td>
                      <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Short Code</strong></td>
                        <td width="9%" bgcolor="#CCCCCC" class="bodytext3"><strong>Edit</strong></td>
                      </tr>
                      <?php
	    $query1 = "select * from pharmainstructions where recordstatus <> 'deleted' order by instructions ";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		while ($res1 = mysql_fetch_array($exec1))
		{
		$instructions = $res1['instructions'];
		$shortcode = $res1['shortcode'];
	//	$gender = $res1['gender'];
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
						<a href="pharmainstructions.php?st=del&&anum=<?php echo $auto_number; ?>" onClick="return funcDeleteinstructions('<?php echo $instructions ?>')">
						<img src="images/b_drop.png" width="16" height="16" border="0" /></a>						</div>						</td>
                        <td width="39%" align="left" valign="top"  class="bodytext3"><?php echo $instructions; ?> </td>
						<td  colspan="2" align="left" valign="top"  class="bodytext3"><?php echo $shortcode; ?> </td>
                   
                        <td align="left" valign="top"  class="bodytext3">
						<a href="editinstructions.php?st=edit&&anum=<?php echo $auto_number; ?>" style="text-decoration:none">Edit</a></td>
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
                        <td colspan="3" bgcolor="#CCCCCC" class="bodytext3"><strong>Instructions Master - Deleted </strong></td>
                      </tr>
                      <?php
		
	    $query1 = "select * from pharmainstructions where recordstatus = 'deleted' order by instructions ";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		while ($res1 = mysql_fetch_array($exec1))
		{
		$instructions = $res1['instructions'];
	//	$gender = $res1['gender'];
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
						<a href="pharmainstructions.php?st=activate&&anum=<?php echo $auto_number; ?>" class="bodytext3">
                          <div align="center" class="bodytext3">Activate</div>
                        </a></td>
                        <td width="35%" align="left" valign="top"  class="bodytext3"><?php echo $instructions; ?></td>
                      
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

