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
$percent1 = '';

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{

	$percent = $_REQUEST['percent'];
	$amount = $_REQUEST['amount'];
	$basedon = $_REQUEST['basedon'];
	
	$query2 = "select * from master_nssf where componentname = 'NSSF'";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	$res2 = mysql_num_rows($exec2);
	if ($res2 == 0)
	{
		$query1 = "insert into master_nssf (componentanum, componentname, amount, ipaddress, updatetime, username, percent,basedon) 
		values ('7', 'NSSF', '$amount', '$ipaddress', '$updatedatetime', '$username', '$percent','$basedon')";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$errmsg = "Success. New Amount Updated.";
		$bgcolorcode = 'success';
		
	}
	//exit();
	else
	{
		$query2 = "update master_nssf set amount = '$amount', percent = '$percent', updatetime = '$updatedatetime', basedon = '$basedon' where componentanum = '7'";
		$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		
		$errmsg = "Success. New Amount Updated.";
		$bgcolorcode = 'success';
	}
	
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'edit')
{
	$editanum = $_REQUEST["anum"];
	$query3 = "select * from master_nssf where auto_number = '$editanum'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	$res3 = mysql_fetch_array($exec3);
	$amount1 = $res3['amount'];
	$percent1 = $res3['percent'];
	$basedon = $res3['basedon'];
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
	if (document.form1.amount.value == "")
	{
		alert ("Pleae Enter Amount.");
		document.form1.amount.focus();
		return false;
	}
	if(isNaN(document.getElementById("amount").value))
	{
		alert("Please Enter Numbers");
		document.getElementById("amount").focus();
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
              <td><form name="form1" id="form1" method="post" action="addnssf1.php" onSubmit="return addward1process1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>NSSF Master</strong></td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">NSSF Amount </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="amount" id="amount" value="<?php echo $amount1; ?>" style="border: 1px solid #001E6A;" size="10" /></td>
                      </tr>
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">NSSF Percent </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="percent" id="percent" value="<?php echo $percent1; ?>" style="border: 1px solid #001E6A;" size="10" /></td>
                      </tr>
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">NSSF Based on </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="basedon" id="basedon" style="border: 1px solid #001E6A;">
						<?php if($basedon != '') { ?>
						<option value="<?php echo $basedon; ?>"><?php echo $basedon; ?></option>
						<?php } ?>
						<option value="Amount">Amount</option>
						<option value="Percent">Percent</option>
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
                        <td colspan="4" bgcolor="#CCCCCC" class="bodytext3"><strong>NSSF Master - Existing List </strong></td>
                        <td bgcolor="#CCCCCC" class="bodytext3"><strong>Edit</strong></td>
                      </tr>
                      <?php
						$query1 = "select * from master_nssf where status <> 'deleted'";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						while ($res1 = mysql_fetch_array($exec1))
						{
						$componentname = $res1["componentname"];
						$auto_number = $res1["auto_number"];
						$amount = $res1['amount'];
						$percent = $res1['percent'];
						$basedon = $res1['basedon'];
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
                        <td width="21%" align="left" valign="top"  class="bodytext3"><?php echo $componentname;?> </td>
						<td width="21%" align="left" valign="top"  class="bodytext3"><?php echo $amount;?> </td>
						<td width="22%" align="left" valign="top"  class="bodytext3"><?php echo $percent;?> </td>
						<td width="31%" align="left" valign="top"  class="bodytext3"><?php echo $basedon;?> </td>
                        <td width="5%" align="left" valign="top"  class="bodytext3">
						<a href="addnssf1.php?st=edit&&anum=<?php echo $auto_number; ?>" style="text-decoration:none">Edit</a>						</td>
                      </tr>
                      <?php
						}
						?>
                      <tr>
                        <td align="middle" colspan="4" >&nbsp;</td>
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

