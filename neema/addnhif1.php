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

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
	$template = $_REQUEST['template'];
	$from = $_REQUEST['from'];
	$to = $_REQUEST['to'];
	$amount = $_REQUEST['amount'];
	
	$query1 = "insert into master_nhif(from1, to1, amount, ipaddress, username, updatetime,template) values('$from', '$to', '$amount', '$ipaddress',
	'$username', '$updatedatetime','$template')";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	
	header("location:addnhif1.php?st=success");
}

if(isset($_REQUEST['st'])) { $st = $_REQUEST['st']; } else { $st = ""; }
if($st == 'del')
{
	$delanum = $_REQUEST['anum'];
	$query2 = "update master_nhif set status = 'deleted' where auto_number = '$delanum'";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	
}
if($st == 'activate')
{
	$actanum = $_REQUEST['anum'];
	$query2 = "update master_nhif set status = '' where auto_number = '$actanum'";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	
}
if($st == 'success')
{
	$errmsg = "Added Successfully";
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
	if (document.getElementById("from").value == "")
	{
		alert ("Pleae Enter From Amount.");
		document.getElementById("from").focus();
		return false;
	}
	if(isNaN(document.getElementById("from").value))
	{
		alert("Please Enter Numbers");
		document.getElementById("from").focus();
		return false;
	}
	if (document.getElementById("to").value == "")
	{
		alert ("Pleae Enter To Amount.");
		document.getElementById("to").focus();
		return false;
	}
	if(isNaN(document.getElementById("to").value))
	{
		alert("Please Enter Numbers");
		document.getElementById("to").focus();
		return false;
	}
	if (document.getElementById("amount").value == "")
	{
		alert ("Pleae Enter Amount.");
		document.getElementById("amount").focus();
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
              <td><form name="form1" id="form1" method="post" action="addnhif1.php" onSubmit="return addward1process1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Service Tax Master</strong></td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($st == '') { echo '#FFFFFF'; } else if ($st == 'success') { echo '#FFBF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Template </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="template" id="template" value="" style="border: 1px solid #001E6A;" size="25" /></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">From </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="from" id="from" value="" style="border: 1px solid #001E6A;" size="10" /></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">To </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="to" id="to" value="" style="border: 1px solid #001E6A;" size="10" /></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Amount </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="amount" id="amount" value="" style="border: 1px solid #001E6A;" size="10" /></td>
                      </tr>
                      <tr>
                        <td width="27%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td width="73%" align="left" valign="top"  bgcolor="#FFFFFF">
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
                        <td colspan="5" bgcolor="#CCCCCC" class="bodytext3"><strong>Service Tax Master - Existing List </strong></td>
                      </tr>
					   <?php
					  $query3 = "select * from master_nhif where status <> 'deleted' group by template order by auto_number";
					  $exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
					  while($res3 = mysql_fetch_array($exec3))
					  {
					  	$template = $res3['template'];
					  ?>
					  <tr bgcolor="#FFFFFF">
					  <td colspan="5" align="center" class="bodytext3"><strong><?php echo $template; ?></strong></td>
					  </tr>
					  <tr>
					  <td align="center" class="bodytext3"><strong>Delete</strong></td>
					  <td align="right" class="bodytext3"><strong>From</strong></td>
					  <td align="right" class="bodytext3"><strong>To</strong></td>
					  <td align="right" class="bodytext3"><strong>Amount</strong></td>
					  <td align="right" class="bodytext3"><strong>Edit</strong></td>
					  </tr>
					  <?php	
						$query1 = "select * from master_nhif where status <> 'deleted' and template = '$template' order by from1";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						while ($res1 = mysql_fetch_array($exec1))
						{
						$auto_number = $res1["auto_number"];
						$from1 = $res1['from1'];
						$to1 = $res1['to1'];
						$amount = $res1['amount'];
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
						<td width="8%" align="left" valign="top"  class="bodytext3">
						<div align="center">	
					    <a href="addnhif1.php?st=del&&anum=<?php echo $auto_number; ?>"> 
						<img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>
                        <td width="16%" align="right" valign="top"  class="bodytext3"><?php echo number_format($from1,2,'.',',');?> </td>
						<td width="23%" align="right" valign="top"  class="bodytext3"><?php echo number_format($to1,2,'.',',');?> </td>
						<td width="26%" align="right" valign="top"  class="bodytext3"><?php echo number_format($amount,2,'.',',');?> </td>
                        <td width="27%" align="right" valign="top"  class="bodytext3">
						<a href="editnhif1.php?st=edit&&anum=<?php echo $auto_number; ?>" style="text-decoration:none">Edit</a>						</td>
                      </tr>
                      <?php
						}
						}
						?>
                      <tr>
                        <td align="middle" colspan="5" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
				   <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="5" bgcolor="#CCCCCC" class="bodytext3"><strong>Service Tax Master - Deleted </strong></td>
                      </tr>
					   <?php
					  $query3 = "select * from master_nhif where status = 'deleted' group by template order by auto_number";
					  $exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
					  while($res3 = mysql_fetch_array($exec3))
					  {
					  	$template = $res3['template'];
					  ?>
					  <tr bgcolor="#FFFFFF">
					  <td colspan="5" align="center" class="bodytext3"><strong><?php echo $template; ?></strong></td>
					  </tr>
					  <tr>
					  <td align="center" class="bodytext3"><strong>Activate</strong></td>
					  <td align="right" class="bodytext3"><strong>From</strong></td>
					  <td align="right" class="bodytext3"><strong>To</strong></td>
					  <td align="right" class="bodytext3"><strong>Amount</strong></td>
					  <td align="right" class="bodytext3"><strong></strong></td>
					  </tr>
					  <?php	
						$query1 = "select * from master_nhif where status = 'deleted' and template = '$template' order by from1";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						while ($res1 = mysql_fetch_array($exec1))
						{
						$auto_number = $res1["auto_number"];
						$from1 = $res1['from1'];
						$to1 = $res1['to1'];
						$amount = $res1['amount'];
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
						<td width="8%" align="left" valign="top"  class="bodytext3">
						<div align="center">	
					    <a href="addnhif1.php?st=activate&&anum=<?php echo $auto_number; ?>"> 
						Activate</a></div></td>
                        <td width="16%" align="right" valign="top"  class="bodytext3"><?php echo number_format($from1,2,'.',',');?> </td>
						<td width="23%" align="right" valign="top"  class="bodytext3"><?php echo number_format($to1,2,'.',',');?> </td>
						<td width="26%" align="right" valign="top"  class="bodytext3"><?php echo number_format($amount,2,'.',',');?> </td>
                        <td width="27%" align="right" valign="top"  class="bodytext3">
						</td>
                      </tr>
                      <?php
						}
						}
						?>
                      <tr>
                        <td align="middle" colspan="5" >&nbsp;</td>
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

