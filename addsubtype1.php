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
	$bedtemplate = $_REQUEST["bedtemplate"];
	$maintype = $_REQUEST["maintype"];
	$subtype = $_REQUEST["subtype"];
	$labtemplate = $_REQUEST["labtemplate"];
	$radtemplate = $_REQUEST["radtemplate"];
	$sertemplate = $_REQUEST["sertemplate"];
	$ippactemplate = $_REQUEST["ippactemplate"];
	
	$query10 = "select * from master_testtemplate where testname = 'bedcharge' and referencetable='$bedtemplate' order by templatename";
	$exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());
	$res10 = mysql_fetch_array($exec10);
	$bedtemplate = $res10["templatename"];
	//this is for currency and fxrate
	$currency = $_REQUEST["currency"];
	$fxrate = $_REQUEST["fxrate"];
	
	$subtype = strtoupper($subtype);
	$subtype = trim($subtype);
	$length=strlen($subtype);
	//echo $length;
	if ($length<=100)
	{
		$query1 = "insert into master_subtype (maintype, subtype, ipaddress, recorddate, username,labtemplate,radtemplate,sertemplate,ippactemplate,bedtemplate,currency,fxrate) 
		values ('$maintype', '$subtype', '$ipaddress', '$updatedatetime', '$username','$labtemplate','$radtemplate','$sertemplate','$ippactemplate','$bedtemplate','".$currency."','".$fxrate."')";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$errmsg = "Success. New Sub Type Updated.";
		$bgcolorcode = 'success';
		
	}
	else
	{
		$errmsg = "Failed. Only 100 Characters Are Allowed.";
		$bgcolorcode = 'failed';
	}
	
	header("location:addsubtype1.php");
exit();
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
	
	if (document.form1.labtemplate.value == "")
	{
		alert ("Pleae Enter Lab Template Name.");
		document.form1.labtemplate.focus();
		return false;
	}
	if (document.form1.radtemplate.value == "")
	{
		alert ("Pleae Enter Radiology Template Type Name.");
		document.form1.radtemplate.focus();
		return false;
	}
	if (document.form1.sertemplate.value == "")
	{
		alert ("Pleae Enter Service Template Type Name.");
		document.form1.sertemplate.focus();
		return false;
	}
	if (document.form1.ippactemplate.value == "")
	{
		alert ("Pleae Enter Ip Package Template Type Name.");
		document.form1.ippactemplate.focus();
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
              <td><form name="form1" id="form1" method="post" action="addsubtype1.php" onSubmit="return addward1process1()">
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
						<option value="" selected="selected">Select Type</option>
                          <?php
				$query5 = "select * from master_paymenttype where recordstatus = '' order by paymenttype";
				$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
				while ($res5 = mysql_fetch_array($exec5))
				{
				$res5anum = $res5["auto_number"];
				$res5paymenttype = $res5["paymenttype"];
				?>
                          <option value="<?php echo $res5anum; ?>"><?php echo $res5paymenttype; ?></option>
                          <?php
				}
				?>
                        </select>
						</td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Add New Sub Type </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="subtype" id="subtype" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" /></td>
                      </tr>
                      
                       <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Currency</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="currency" id="currency" style="border: 1px solid #001E6A; text-transform:uppercase" size="15" /></td>
                      </tr>
                        <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Fxrate </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="fxrate" id="fxrate" style="border: 1px solid #001E6A; text-transform:uppercase" size="15" /></td>
                      </tr>
                      
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Lab Template </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="labtemplate" id="labtemplate"  style="border: 1px solid #001E6A;">
						<option value="" selected="selected">Select Lab</option>
						<option value="master_lab" >master_lab</option>						
                          <?php
				$query10 = "select * from master_testtemplate where testname = 'lab' order by templatename";
				$exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());
				while ($res10 = mysql_fetch_array($exec10))
				{
				
				$templatename = $res10["templatename"];
				?>
                          <option value="<?php echo $templatename; ?>"><?php echo $templatename; ?></option>
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
						<option value="" selected="selected">Select Radiology</option>
						<option value="master_radiology" >master_radiology</option>	
                          <?php
				$query11 = "select * from master_testtemplate where testname = 'radiology' order by templatename";
				$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
				while ($res11 = mysql_fetch_array($exec11))
				{
				
				$templatename = $res11["templatename"];
				?>
                          <option value="<?php echo $templatename; ?>"><?php echo $templatename; ?></option>
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
						<option value="" selected="selected">Select Services</option>
						<option value="master_services" >master_services</option>	
                          <?php
				$query12 = "select * from master_testtemplate where testname = 'services' order by templatename";
				$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
				while ($res12 = mysql_fetch_array($exec12))
				{
				
				$templatename = $res12["templatename"];
				?>
                          <option value="<?php echo $templatename; ?>"><?php echo $templatename; ?></option>
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
						<option value="" selected="selected">Select Template</option>
						<option value="master_ippackage" >master_ippackage</option>	
                          <?php
				$query13 = "select * from master_testtemplate where testname = 'ippackage' order by templatename";
				$exec13 = mysql_query($query13) or die ("Error in Query13".mysql_error());
				while ($res13 = mysql_fetch_array($exec13))
				{
				
				$templatename = $res13["templatename"];
				?>
                          <option value="<?php echo $templatename; ?>"><?php echo $templatename; ?></option>
                          <?php
				}
				?>
                        </select>
						</td>
                      </tr>
                       <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Bed Template </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="bedtemplate" id="bedtemplate"  style="border: 1px solid #001E6A;">
						<option value="" selected="selected">Select Template</option>
						<option value="master_bed" >master_bed</option>	
                          <?php
				$query13 = "select * from master_testtemplate where testname = 'bedcharge' and referencetable!='' order by templatename";
				$exec13 = mysql_query($query13) or die ("Error in Query13".mysql_error());
				while ($res13 = mysql_fetch_array($exec13))
				{
				
				$templatename = $res13["referencetable"];
				?>
                          <option value="<?php echo $templatename; ?>"><?php echo $templatename; ?></option>
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
                          <input type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A" /></td>
                      </tr>
                      <tr>
                        <td align="middle" colspan="2" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                <table width="900" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="9" bgcolor="#CCCCCC" class="bodytext3"><strong>Sub  Type Master - Existing List </strong></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" bgcolor="#CCCCCC"  class="bodytext3">&nbsp;</td>
                        <td width="10%" align="left" valign="top" bgcolor="#CCCCCC"  class="bodytext3"><strong>Main Type </strong></td>
                        <td width="20%" align="left" valign="top" bgcolor="#CCCCCC"  class="bodytext3"><strong>Sub Type </strong></td>
						<td width="10%" align="left" valign="top" bgcolor="#CCCCCC"  class="bodytext3"><strong>Lab Template</strong></td>
						<td width="15%" align="left" valign="top" bgcolor="#CCCCCC"  class="bodytext3"><strong>Radiology Template</strong></td>
						<td width="15%" align="left" valign="top" bgcolor="#CCCCCC"  class="bodytext3"><strong>Service Template</strong></td>
						<td width="15%" align="left" valign="top" bgcolor="#CCCCCC"  class="bodytext3"><strong>IP Package Template </strong></td>
                        <td width="15%" align="left" valign="top" bgcolor="#CCCCCC"  class="bodytext3"><strong>Bed Template </strong></td>
                        <td width="5%" align="left" valign="top" bgcolor="#CCCCCC"  class="bodytext3"><strong>Edit</strong></td>
                      </tr>
                      <?php
	    $query1 = "select * from master_subtype where recordstatus <> 'deleted' order by maintype ";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		while ($res1 = mysql_fetch_array($exec1))
		{
		$maintypeanum = $res1['maintype'];
		$subtype = $res1["subtype"];
		$auto_number = $res1["auto_number"];
		$labtemplate = $res1["labtemplate"];
		$radtemplate = $res1["radtemplate"];
		$sertemplate = $res1["sertemplate"];
		$ippactemplate = $res1["ippactemplate"];
		$bedtemp=$res1["bedtemplate"];
		if($bedtemp==''){$bedtemp='master_bed';}
		if($labtemplate==''){$labtemplate='master_lab';}
		if($radtemplate==''){$radtemplate='master_radiology';}
		if($sertemplate==''){$sertemplate='master_services';}
		if($ippactemplate==''){$ippactemplate='master_ippackage';}
		$query2 = "select * from master_paymenttype where auto_number = '$maintypeanum'";
		$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		$res2 = mysql_fetch_array($exec2);
		$maintype = $res2['paymenttype'];
	
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
                        <td width="6%" align="left" valign="top"  class="bodytext3"><div align="center">
					    <a href="addsubtype1.php?st=del&&anum=<?php echo $auto_number; ?>" onClick="return funcDeleteSubType('<?php echo $subtype;?>')">
						<img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $maintype; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $subtype; ?> </td>
						<td align="left" valign="top"  class="bodytext3"><?php echo $labtemplate; ?> </td>
						<td align="left" valign="top"  class="bodytext3"><?php echo $radtemplate; ?> </td>
						<td align="left" valign="top"  class="bodytext3"><?php echo $sertemplate; ?> </td>
						<td align="left" valign="top"  class="bodytext3"><?php echo $ippactemplate; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $bedtemp; ?> </td>
                        <td align="left" valign="top"  class="bodytext3">
						<a href="editsubtype1.php?st=edit&&anum=<?php echo $auto_number; ?>" style="text-decoration:none">Edit</a>
						</td>
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
                        <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Sub Type Master - Deleted </strong></td>
                        <td bgcolor="#CCCCCC" class="bodytext3"><strong>Sub Type </strong></td>
                      </tr>
                      <?php
		
	    $query1 = "select * from master_subtype where recordstatus = 'deleted' order by maintype ";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		while ($res1 = mysql_fetch_array($exec1))
		{
		$maintypeanum = $res1['maintype'];
		$subtype = $res1["subtype"];
		$auto_number = $res1["auto_number"];
		//$defaultstatus = $res1["defaultstatus"];
		
		$query2 = "select * from master_paymenttype where auto_number = '$maintypeanum'";
		$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		$res2 = mysql_fetch_array($exec2);
		$maintype = $res2['paymenttype'];
	
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
						<a href="addsubtype1.php?st=activate&&anum=<?php echo $auto_number; ?>" class="bodytext3">
                          <div align="center" class="bodytext3">Activate</div>
                        </a></td>
                        <td width="37%" align="left" valign="top"  class="bodytext3"><?php echo $maintype; ?></td>
                        <td width="52%" align="left" valign="top"  class="bodytext3"><?php echo $subtype; ?></td>
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

