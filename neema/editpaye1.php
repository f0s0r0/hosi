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
$amount1 = '';
$from1 = '';
$to1 = '';
$percent1 = '';
$difference1 = '';
$description1 = '';

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
	$anum = $_REQUEST['anum'];
	$from1 = $_REQUEST['from'];
	$to1 = $_REQUEST['to'];
	$percent = $_REQUEST['percent'];
	$difference = $_REQUEST['difference'];
	$description = $_REQUEST['description'];
	$template = $_REQUEST['template'];
	$addgross = $_REQUEST['addgross'];
	$deductgross = $_REQUEST['deductgross'];
	
	$query1 = "update master_paye set from1 = '$from1', to1 = '$to1', difference = '$difference', percent = '$percent', description = '$description', template = '$template', 
	addgross = '$addgross', deductgross = '$deductgross', updatetime = '$updatedatetime' where auto_number = '$anum'";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	
	header("location:addpaye1.php");
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if (isset($_REQUEST["anum"])) { $anum = $_REQUEST["anum"]; } else { $anum = ""; }
if($st == 'edit')
{
	$editanum = $_REQUEST['anum'];
	$query2 = "select * from master_paye where auto_number = '$editanum'";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error()); 
	$res2 = mysql_fetch_array($exec2);
	$from1 = $res2['from1'];
	$to1 = $res2['to1'];
	$percent1 = $res2['percent'];
	$difference1 = $res2['difference'];
	$description1 = $res2['description'];
	$template = $res2['template'];
	$addgross = $res2['addgross'];
	$deductgross = $res2['deductgross'];
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

function process1()
{
	var varFrom = document.getElementById("from").value;
	var varTo = document.getElementById("to").value;
	var varPercent = document.getElementById("percent").value;
	var varFrom = varFrom.trim();
	var varTo = varTo.trim();
	var varPercent = varPercent.trim();
	
	if(varFrom == "")
	{
		alert("Please Enter From Amount");
		document.getElementById("from").focus();
		return false;
	}
	if(varTo == "")
	{
		alert("Please Enter To Amount");
		document.getElementById("to").focus();
		return false;
	}
	if(varPercent == "")
	{
		alert("Please Enter Percent");
		document.getElementById("percent").focus();
		return false;
	}
	if(isNaN(document.getElementById("percent").value))
	{
		alert("Please Enter Numbers");
		document.getElementById("percent").focus();
		return false;
	}	
	if(document.getElementById("description").value == "")
	{
		alert("Please Enter Description");
		document.getElementById("description").focus();
		return false;
	}
	if(document.getElementById("difference").value < 0)
	{
		alert("Difference should be Positive Integer");
		document.getElementById("difference").focus();
		return false;
	}	
}

function DiffCalc()
{
	//alert("Hi");
	if(document.getElementById("from").value != "")
	{
		if(!isNaN(document.getElementById("from").value))
		{
			if(document.getElementById("to").value != "")
			{
				if(!isNaN(document.getElementById("to").value))
				{
					var Diff = parseInt(document.getElementById("to").value) - parseInt(document.getElementById("from").value);
					document.getElementById("difference").value = Diff.toFixed(2);
				}
				else
				{
					alert("Please Enter Numbers");
					return false;
				}
			}
			else
			{
				var Diff = parseInt("0.00") - parseInt(document.getElementById("from").value);
				document.getElementById("difference").value = Diff.toFixed(2);		
			}
		}
		else
		{
			alert("Please Enter Numbers");
			return false;
		}	
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
              <td><form name="form1" id="form1" method="post" action="editpaye1.php" onSubmit="return process1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>PAYE Master - Edit</strong></td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Template </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="template" id="template" style="border: 1px solid #001E6A;">
						<option value="<?php echo $template; ?>"><?php echo $template; ?></option>
						<option value="Uganda">Uganda</option>
						<option value="Kenya">Kenya</option>
						</select></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">From </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="hidden" name="anum" id="anum" value="<?php echo $anum; ?>">
						<input name="from" id="from" value="<?php echo $from1; ?>" autocomplete="off" style="border: 1px solid #001E6A;" onKeyUp="return DiffCalc()" size="10" /></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">To </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="to" id="to" value="<?php echo $to1; ?>" autocomplete="off" style="border: 1px solid #001E6A;" onKeyUp="return DiffCalc()" size="10" /></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Percent </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="percent" id="percent" value="<?php echo $percent1; ?>" style="border: 1px solid #001E6A;" size="10" /> %</td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Add to Gross </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="addgross" id="addgross" value="<?php echo $addgross; ?>" style="border: 1px solid #001E6A;" size="10" /></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Deduct from Gross </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="deductgross" id="deductgross" value="<?php echo $deductgross; ?>" style="border: 1px solid #001E6A;" size="10" /></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Difference </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="difference" id="difference" value="<?php echo $difference1; ?>" readonly="readonly" style="border: 1px solid #001E6A;background-color:#E0E0E0;" size="10" /></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Description </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="description" id="description" value="<?php echo $description1; ?>" style="border: 1px solid #001E6A;" size="25" /></td>
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
	</td>
	</tr>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

