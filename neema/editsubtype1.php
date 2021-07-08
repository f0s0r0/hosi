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
    $subtypeanum = $_REQUEST['subtypeanum'];
	//echo $subtypeanum;
	$maintype = $_REQUEST["maintype"];
	$subtype = $_REQUEST["subtype"];
	//this is for currency and fxrate
	$currency = $_REQUEST["currency"];
	$fxrate = $_REQUEST["fxrate"];
	
	$subtype = strtoupper($subtype);
	$subtype = trim($subtype);
	$length=strlen($subtype);
	$bedcharge1=$_REQUEST["bedcharge"];
	
	$query10 = "select * from master_testtemplate where testname = 'bedcharge' and referencetable='$bedcharge1' order by templatename";
	$exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());
	$res10 = mysql_fetch_array($exec10);
	$bedcharge1 = $res10["templatename"];
	
		$labtemplate = $_REQUEST["labtemplate"];
	$radtemplate = $_REQUEST["radtemplate"];
	$sertemplate = $_REQUEST["sertemplate"];
	$ippactemplate = $_REQUEST["ippactemplate"];
	
	
	//echo $length;
	if ($length<=100)
	{
	$query2 = "select * from master_subtype where auto_number = '$subtypeanum'";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	$res2 = mysql_num_rows($exec2);
	if ($res2 != 0)
	{
	    $query1 = "update master_subtype set maintype = '$maintype',subtype = '$subtype',currency='".$currency."',fxrate='".$fxrate."',labtemplate='$labtemplate',radtemplate='$radtemplate',sertemplate='$sertemplate',ippactemplate='$ippactemplate', bedtemplate='$bedcharge1'  where auto_number = '$subtypeanum'";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$errmsg = "Success. New Sub Type Updated.";
		//$bgcolorcode = 'success';
		header ("location:addsubtype1.php?bgcolorcode=success&&st=edit&&anum=$subtypeanum");
		
	}
	//exit();
	else
	{
		$errmsg = "Failed. Sub Type Already Exists.";
		//$bgcolorcode = 'failed';
	header ("location:addsubtype1.php?bgcolorcode=failed&&st=edit&&anum=$subtypeanum");
	}
	}
	else
	{
		$errmsg = "Failed. Only 100 Characters Are Allowed.";
		//$bgcolorcode = 'failed';
		header ("location:addsubtype1.php?bgcolorcode=failed&&st=edit&&anum=$subtypeanum");
	}

}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_subtype set recordstatus = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
}
if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_subtype set recordstatus = '' where auto_number = '$delanum'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
}
if ($st == 'default')
{
	$delanum = $_REQUEST["anum"];
	$query4 = "update master_subtype set defaultstatus = '' where cstid='$custid' and cstname='$custname'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());

	$query5 = "update master_subtype set defaultstatus = 'DEFAULT' where auto_number = '$delanum'";
	$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
}
if ($st == 'removedefault')
{
	$delanum = $_REQUEST["anum"];
	$query6 = "update master_subtype set defaultstatus = '' where auto_number = '$delanum'";
	$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
}

if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add Sub Type To Proceed For Billing.";
	$bgcolorcode = 'failed';
}

if (isset($_REQUEST["anum"])) { $anum = $_REQUEST["anum"]; } else { $anum = ""; }
if ($st == 'edit' && $anum != '')
{
	$query1 = "select * from master_subtype where auto_number = '$anum'";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	$res1 = mysql_fetch_array($exec1);
	$res1autonumber = $res1['auto_number'];
    $res1maintype = $res1['maintype'];
    $res1subtype = $res1['subtype'];
		$res1labtemplate = $res1["labtemplate"];
	$res1radtemplate = $res1["radtemplate"];
	$res1sertemplate = $res1["sertemplate"];
	$res1ippactemplate = $res1["ippactemplate"];
	$bedcharge=$res1["bedtemplate"];
	
	$currency = $res1["currency"];
	$fxrate = $res1["fxrate"];
}

if (isset($_REQUEST["bgcolorcode"])) { $bgcolorcode = $_REQUEST["bgcolorcode"]; } else { $bgcolorcode = ""; }
if ($bgcolorcode == 'success')
{
		$errmsg = "Success. New Sub Type Updated.";
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
	if (document.form1.subtype.value == "")
	{
		alert ("Pleae Enter Sub Type Name.");
		document.form1.subtype.focus();
		return false;
	}
	
	if (document.form1.currency.value == "")
	{
		alert ("Pleae Enter Currency.");
		document.form1.currency.focus();
		return false;
	}
	if (document.form1.fxrate.value == "")
	{
		alert ("Pleae Enter FXRate.");
		document.form1.fxrate.focus();
		return false;
	}
}
function funcDeleteSubType(varSubTypeAutoNumber)
{
 var varSubTypeAutoNumber = varSubTypeAutoNumber;
	var fRet;
	fRet = confirm('Are you sure want to delete this account name '+varSubTypeAutoNumber+'?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("Sub Type Entry Delete Completed.");
		//return false;
	}
	if (fRet == false)
	{
		alert ("Sub Type Entry Delete Not Completed.");
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
              <td><form name="form1" id="form1" method="post" action="editsubtype1.php" onSubmit="return addward1process1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Sub Type Master - Add New </strong></td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Add New  Type </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="maintype" id="maintype"  style="border: 1px solid #001E6A;">
                          <?php
						
						if ($res1maintype == '')
						{
						echo '<option value="" selected="selected">Select Payment Type</option>';
						}
						else
						{
						$query4 = "select * from master_paymenttype where auto_number = '$res1maintype'";
						$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
						$res4 = mysql_fetch_array($exec4);
						$res4dmaintypeanum = $res4['auto_number'];
						$res4maintypename = $res4['paymenttype'];
					
						echo '<option value="'.$res4dmaintypeanum.'" selected="selected">'.$res4maintypename.'</option>';
						}
					
						$query5 = "select * from master_paymenttype where recordstatus = '' order by paymenttype";
						$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
						while ($res5 = mysql_fetch_array($exec5))
						{
						$res5anum = $res5["auto_number"];
						$res5maintype = $res5["paymenttype"];
						
						
						?>
						<option value="<?php echo $res5anum; ?>"><?php echo $res5maintype; ?></option>
						<?php
						}
						?>
                        </select></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Add New Sub Type </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="subtype" id="subtype"  value="<?php echo $res1subtype;?>"style="border: 1px solid #001E6A; text-transform:uppercase" size="40" /></td>
                      </tr>
                      
                        <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Currency</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="currency" id="currency" style="border: 1px solid #001E6A; text-transform:uppercase" size="15" value="<?php echo $currency?>"  /></td>
                      </tr>
                        <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Fxrate </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="fxrate" id="fxrate" style="border: 1px solid #001E6A; text-transform:uppercase" size="15" value="<?php echo $fxrate?>" /></td>
                      </tr>
                      
                        <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Lab Template </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="labtemplate" id="labtemplate"  style="border: 1px solid #001E6A;">
						<!--<option value="" selected="selected">Select Lab</option> -->
						<option value="master_lab" >master_lab</option>						
                          <?php
				$query10 = "select * from master_testtemplate where testname = 'lab' order by templatename";
				$exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());
				while ($res10 = mysql_fetch_array($exec10))
				{
				
				$templatename = $res10["templatename"];
				?>
                          <option value="<?php echo $templatename; ?>"  <?php if($res1labtemplate==$templatename){ echo "selected";} ?>><?php echo $templatename; ?></option>
                          <?php
				}
				?>
                        </select>
						</td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Radiology Template </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="radtemplate" id="radtemplate"  style="border: 1px solid #001E6A;">
					<!--	<option value="" selected="selected">Select Radiology</option> -->
						<option value="master_radiology" >master_radiology</option>	
                          <?php
				$query11 = "select * from master_testtemplate where testname = 'radiology' order by templatename";
				$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
				while ($res11 = mysql_fetch_array($exec11))
				{
				
				$templatename = $res11["templatename"];
				?>
                          <option value="<?php echo $templatename; ?>" <?php if($res1radtemplate==$templatename){ echo "selected";} ?> ><?php echo $templatename; ?></option>
                          <?php
				}
				?>
                        </select>
						</td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Services Template </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="sertemplate" id="sertemplate"  style="border: 1px solid #001E6A;">
						<!-- <option value="" selected="selected">Select Services</option> -->
						<option value="master_services" >master_services</option>	
                          <?php
				$query12 = "select * from master_testtemplate where testname = 'services' order by templatename";
				$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
				while ($res12 = mysql_fetch_array($exec12))
				{
				
				$templatename = $res12["templatename"];
				?>
                          <option value="<?php echo $templatename; ?>" <?php if($res1sertemplate==$templatename){ echo "selected";} ?> ><?php echo $templatename; ?></option>
                          <?php
				}
				?>
                        </select>
						</td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">IP Package Template </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="ippactemplate" id="ippactemplate"  style="border: 1px solid #001E6A;">
						<!-- <option value="" selected="selected">Select Template</option> -->
						<option value="master_ippackage" >master_ippackage</option>	
                          <?php
				$query13 = "select * from master_testtemplate where testname = 'ippackage' order by templatename";
				$exec13 = mysql_query($query13) or die ("Error in Query13".mysql_error());
				while ($res13 = mysql_fetch_array($exec13))
				{
				
				$templatename = $res13["templatename"];
				?>
                          <option value="<?php echo $templatename; ?>" <?php if($res1ippactemplate==$templatename){ echo "selected";} ?> ><?php echo $templatename; ?></option>
                          <?php
				}
				?>
                        </select>
						</td>
                      </tr>
                        <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Bed Template </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="bedcharge" id="bedcharge"  style="border: 1px solid #001E6A;">
						<!-- <option value="" selected="selected">Select Template</option> -->
						<option value="master_bed" >master_bed</option>	
                          <?php
				$query13 = "select * from master_testtemplate where testname = 'bedcharge' and referencetable!=''  order by templatename";
				$exec13 = mysql_query($query13) or die ("Error in Query13".mysql_error());
				while ($res13 = mysql_fetch_array($exec13))
				{
				
				$templatename = $res13["referencetable"];
				?>
                          <option value="<?php echo $templatename; ?>" <?php if($bedcharge==$templatename){ echo "selected";} ?> ><?php echo $templatename; ?></option>
                          <?php
				}
				?>
                        </select>
						</td>
                      </tr>
                      <tr>
                        <td width="42%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td width="58%" align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="hidden" name="frmflag" value="addnew" />
                        <input type="hidden" name="frmflag1" value="frmflag1" />
						<input type="hidden" name="subtypeanum" id="subtypeanum" value="<?php echo $res1autonumber; ?>">
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

