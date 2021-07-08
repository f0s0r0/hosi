<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$errmsg = '';

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{

	$query1 = "select * from master_bank order by auto_number desc limit 0, 1";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	$rowcount1 = mysql_num_rows($exec1);
	if ($rowcount1 == 0)
	{
		$bankcode = 'BNK00000001';
	}
	else
	{
		$res1 = mysql_fetch_array($exec1);
		$res1bankcode = $res1["bankcode"];
		$bankcode = substr($res1bankcode, 3, 8);
		$bankcode = intval($bankcode);
		$bankcode = $bankcode + 1;
	
		$maxanum = $bankcode;
		if (strlen($maxanum) == 1)
		{
			$maxanum1 = '0000000'.$maxanum;
		}
		else if (strlen($maxanum) == 2)
		{
			$maxanum1 = '000000'.$maxanum;
		}
		else if (strlen($maxanum) == 3)
		{
			$maxanum1 = '00000'.$maxanum;
		}
		else if (strlen($maxanum) == 4)
		{
			$maxanum1 = '0000'.$maxanum;
		}
		else if (strlen($maxanum) == 5)
		{
			$maxanum1 = '000'.$maxanum;
		}
		else if (strlen($maxanum) == 6)
		{
			$maxanum1 = '00'.$maxanum;
		}
		else if (strlen($maxanum) == 7)
		{
			$maxanum1 = '0'.$maxanum;
		}
		else if (strlen($maxanum) == 8)
		{
			$maxanum1 = $maxanum;
		}
		
		$bankcode = 'BNK'.$maxanum1;
	
		//echo $bankcode;
	}
	//echo $bankcode;


	//$bankcode=$_REQUEST["bankcode"];
	$bankcode = $bankcode;
	$companyname = $_REQUEST["companyname"];
	$bankname = $_REQUEST["bankname"];
	$bankname = strtoupper($bankname);
	$bankname = trim($bankname);
	$contactpersonname = $_REQUEST["contactpersonname"];
	$contactpersonname = strtoupper($contactpersonname);
	$contactpersonphone = $_REQUEST["contactpersonphone"];
	$branchname  = $_REQUEST["branchname"];
	$branchname = strtoupper($branchname);
	$branchname = trim($branchname);
	$netbankinglogin = $_REQUEST["netbankinglogin"];
	$netbankinglogin = strtoupper($netbankinglogin);
	$accountnumber = $_REQUEST["accountnumber"];
	$accounttype  = $_REQUEST["accounttype"];
	$currentbalance = $_REQUEST["currentbalance"];
	$commissionpercentage = $_REQUEST["commissionpercentage"];
	$phonenumber = $_REQUEST["phonenumber"];
	$mobilenumber  = $_REQUEST["mobilenumber"];
	$address  = $_REQUEST["address"];
	$remarks = $_REQUEST["remarks"];
	$remarks = strtoupper($remarks);
	$branchcode = $_REQUEST["branchcode"];
	$branchcode = strtoupper($branchcode);
	$swiftcode = $_REQUEST["swiftcode"];
	$swiftcode = strtoupper($swiftcode);
	$dateposted = $_REQUEST["dateposted"];
	$bankstatus = $_REQUEST["bankstatus"];
	$lastupdate = $updatedatetime;
	$lastupdateusername = $username;
	$lastupdateipaddress = $ipaddress;
	
	$query2 = "select * from master_bank where accountnumber = '$accountnumber'";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	$rowcount2 = mysql_num_rows($exec2);
	if ($rowcount2 == 0)
	{
		$query1 = "insert into master_bank (bankcode, companyname, bankname, contactpersonname, contactpersonphone, 
		branchname, netbankinglogin, accountnumber, accounttype, currentbalance, commissionpercentage, 
		phonenumber, mobilenumber, address, remarks, bankstatus, branchcode, swiftcode, 
		lastupdate, lastupdateusername, lastupdateipaddress) 
		values ('$bankcode','$companyname', '$bankname', '$contactpersonname', '$contactpersonphone', 
		'$branchname', '$netbankinglogin', '$accountnumber', '$accounttype', '$currentbalance', '$commissionpercentage', 
		'$phonenumber','$mobilenumber', '$address', '$remarks', '$bankstatus', '$branchcode', '$swiftcode', 
		'$lastupdate', '$lastupdateusername', '$lastupdateipaddress')";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		
		header ("location:addbank1.php?st=success");
	}
	else
	{
		header ("location:addbank1.php?st=failed");
	}	

}
else
{
	$bankcode = '';
	$bankname = '';
	$contactpersonname = '';
	$contactpersonphone = '';
	$branchname  = '';
	$netbankinglogin = '';
	$accountnumber = '';
	$accounttype  = '';
	$currentbalance = '';
	$commissionpercentage = '';
	$phonenumber = '';
	$mobilenumber  = '';
	$address  = '';
	$remarks = '';
	$branchcode = '';
	$swiftcode = '';
	$dateposted = '';
	$bankstatus = '';
	$lastupdate = $updatedatetime;
	$lastupdateusername = $username;
	$lastupdateipaddress = $ipaddress;

}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'success')
{
	$errmsg = "Success. New Bank Updated.";
}
if ($st == 'failed')
{
	$errmsg = "Failed. Bank Account Number Already Exists.";
}

if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_bank set bankstatus = 'Deleted' where auto_number = '$delanum'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
}

$query1 = "select * from master_bank order by auto_number desc limit 0, 1";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
$rowcount1 = mysql_num_rows($exec1);
if ($rowcount1 == 0)
{
	$bankcode = 'BNK00000001';
}
else
{
	$res1 = mysql_fetch_array($exec1);
	$res1bankcode = $res1["bankcode"];
	$bankcode = substr($res1bankcode, 3, 8);
	$bankcode = intval($bankcode);
	$bankcode = $bankcode + 1;

	$maxanum = $bankcode;
	if (strlen($maxanum) == 1)
	{
		$maxanum1 = '0000000'.$maxanum;
	}
	else if (strlen($maxanum) == 2)
	{
		$maxanum1 = '000000'.$maxanum;
	}
	else if (strlen($maxanum) == 3)
	{
		$maxanum1 = '00000'.$maxanum;
	}
	else if (strlen($maxanum) == 4)
	{
		$maxanum1 = '0000'.$maxanum;
	}
	else if (strlen($maxanum) == 5)
	{
		$maxanum1 = '000'.$maxanum;
	}
	else if (strlen($maxanum) == 6)
	{
		$maxanum1 = '00'.$maxanum;
	}
	else if (strlen($maxanum) == 7)
	{
		$maxanum1 = '0'.$maxanum;
	}
	else if (strlen($maxanum) == 8)
	{
		$maxanum1 = $maxanum;
	}
	
	$bankcode = 'BNK'.$maxanum1;

	//echo $bankcode;
}
//echo $bankcode;


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
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script language="javascript">

function process1backkeypress1()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
}

function funcDeleteBankName(varBankNameAutoNumber)
{
 var varBankNameAutoNumber = varBankNameAutoNumber;
	var fRet;
	fRet = confirm('Are you sure want to delete this Bank Name '+varBankNameAutoNumber+'?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("Bank Name Entry Delete Completed.");
		//return false;
	}
	if (fRet == false)
	{
		alert ("Bank Name Entry Delete Not Completed.");
		return false;
	}

}

</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<script language="javascript">

function from1submit1()
{

	if (document.form1.bankname.value == "")
	{
		alert ("Bank Name Cannot Be Empty.");
		document.form1.bankname.focus();
		return false;
	}
	if (document.form1.branchname.value == "")
	{
		alert ("Branch Branch Cannot Be Empty.");
		document.form1.branchname.focus();
		return false;
	}
	if (document.form1.accountnumber.value == "")
	{
		alert ("Account Number Cannot Be Empty.");
		document.form1.accountnumber.focus();
		return false;
	}
	if (document.form1.accounttype.value == "")
	{
		alert ("Account Type Cannot Be Empty.");
		document.form1.accounttype.focus();
		return false;
	}
	if (document.form1.currentbalance.value == "")
	{
		alert ("Current Balance Cannot Be Empty.");
		document.form1.currentbalance.focus();
		return false;
	}
	if (isNaN(document.getElementById("currentbalance").value))
	{
		alert ("Payment Amount Can Only Be Numbers.")
		document.getElementById("currentbalance").focus();
		return false;
	}
	if (isNaN(document.getElementById("commissionpercentage").value))
	{
		alert ("Commission Percentage Can Only Be Numbers.")
		document.getElementById("commissionpercentage").focus();
		return false;
	}
}

</script>
<body>
<table width="103%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#E0E0E0">
	<?php 
	
		include ("includes/menu1.php"); 
	
	//	include ("includes/menu2.php"); 
	
	?>	</td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top">


      	  <form name="form1" id="form1" method="post" action="addbank1.php" onKeyDown="return disableEnterKey()" onSubmit="return from1submit1()">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>
		  
		  
		  
	<table width="700" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
      <tbody>
        <tr bgcolor="#011E6A">
          <td colspan="6" bgcolor="#999999" class="bodytext3"><strong>Bank - Existing List </strong></td>
        </tr>
        <tr bgcolor="#011E6A">
		  <td align="left" valign="top" bgcolor="#CCCCCC"  class="bodytext3">&nbsp;</td>
          <td width="30%" bgcolor="#CCCCCC" class="bodytext3"><strong>Bank Name </strong></td>
          <td width="41%" bgcolor="#CCCCCC" class="bodytext3"><strong>Bank Address </strong></td>
          <td width="12%" bgcolor="#CCCCCC" class="bodytext3"><strong>Phone</strong></td>
          <td width="7%" bgcolor="#CCCCCC" class="bodytext3"><div align="center"><strong>Edit</strong></div></td>
        </tr>
        <?php
		$searchcontact = isset($_REQUEST["searchcontact"]);
		$colorloopcount = '';
	    $query100 = "select * from master_bank where bankstatus = '' order by bankname";
		$exec100 = mysql_query($query100) or die ("Error in Query100".mysql_error());
		while ($res100 = mysql_fetch_array($exec100))
		{
		$res100bankcode = $res100["bankcode"];
		$res100bankname = $res100["bankname"];
		$res100address = $res100["address"];
		$res100phonenumber1 = $res100["phonenumber"];
		$res100bankstatus = $res100["bankstatus"];
		$res100bankstatus = strtoupper($res100bankstatus);
		$res100auto_number = $res100["auto_number"];
	
	
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
					    <a href="addbank1.php?st=del&&anum=<?php echo $res100auto_number; ?>" onClick="return funcDeleteBankName('<?php echo $res100bankname;?>')">
						<img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>
		 <td align="left" valign="top"  class="bodytext3"><?php echo $res100bankname; ?> </td>
          <td align="left" valign="top"  class="bodytext3"><?php echo $res100address; ?></td>
          <td align="left" valign="top"  class="bodytext3"><?php echo $res100phonenumber1; ?></td>
          <td align="left" valign="top"  class="bodytext3">
		  <div align="center"><a href="editbank1.php?bankcode=<?php echo $res100bankcode; ?>" class="bodytext3">Edit</a></div>		  </td>
        </tr>
        <?php
		}
		?>
      </tbody>
    </table>		   </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td width="860"><table width="800" height="282" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
                <td bgcolor="#CCCCCC" class="bodytext3" colspan="2"><strong>Bank - New </strong></td>
                <td bgcolor="#CCCCCC" class="bodytext3" colspan="2">* Indicated Mandatory Fields. </td>
              </tr>
              <tr>
                <td colspan="4" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
                </tr>
				<tr>
                <td width="19%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Bank Code   *</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="bankcode" id="bankcode" value="<?php echo $bankcode; ?>" readonly="readonly" style="border: 1px solid #001E6A; background-color:#CCCCCC" size="20"></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Company Name * </td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="companyname" id="companyname" value="<?php echo $companyname; ?>" readonly="readonly" style="border: 1px solid #001E6A; background-color:#CCCCCC"  size="40"></td>
				</tr>
              <tr>
                <td width="19%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Bank Name   *</td>
                <td colspan="3" align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="bankname" id="bankname" value="<?php echo $bankname; ?>" style="border: 1px solid #001E6A;" size="60"></td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Contact Person Name </td>
                <td width="35%" align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="contactpersonname" id="contactpersonname" value="<?php echo $contactpersonname; ?>" style="border: 1px solid #001E6A;" size="20" />                </td>
                <td width="22%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Contact Phone Number </td>
                <td width="27%" align="left" valign="middle"  bgcolor="#E0E0E0"><input name="contactpersonphone" id="contactpersonphone" value="<?php echo $contactpersonphone; ?>" style="border: 1px solid #001E6A" size="20" /></td>
              </tr>
			  <tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Branch *</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="branchname" id="branchname" value="<?php echo $branchname; ?>" style="border: 1px solid #001E6A;"  size="20" /></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Net Banking Login ID </td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="netbankinglogin" id="netbankinglogin" value="<?php echo $netbankinglogin; ?>" style="border: 1px solid #001E6A;"  size="20" /></td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Account Number * </td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="accountnumber" id="accountnumber" value="<?php echo $accountnumber; ?>" style="border: 1px solid #001E6A;" size="20"></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Account Type * </td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext31">
				<input name="accounttype" id="accounttype" value="<?php echo $accounttype; ?>" style="border: 1px solid #001E6A;" size="20">
                </span></td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Phone Number </td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0"><input name="phonenumber" id="phonenumber" value="<?php echo $phonenumber; ?>" style="border: 1px solid #001E6A"  size="20"></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Mobile Number </td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0"><input name="mobilenumber" id="mobilenumber" value="<?php echo $mobilenumber; ?>" style="border: 1px solid #001E6A"  size="20"></td>
                </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Address</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="address" id="address" value="<?php echo $address; ?>" style="border: 1px solid #001E6A;"  size="20" /></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Remarks</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="remarks" id="remarks" value="<?php echo $remarks; ?>" style="border: 1px solid #001E6A;"  size="20" /></td>
                </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Branch Code </td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0"><input name="branchcode" id="branchcode" value="<?php echo $branchcode; ?>" style="border: 1px solid #001E6A;"  size="20" /></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Swift Code </td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0"><input name="swiftcode" id="swiftcode" value="<?php echo $swiftcode; ?>" style="border: 1px solid #001E6A;"  size="20" /></td>
              </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Date Posted</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="dateposted" id="dateposted" value="<?php echo $updatedatetime; ?>" onKeyDown="return process1backkeypress1()" style="border: 1px solid #001E6A; background-color:#CCCCCC"  size="20"  readonly="readonly" />                </td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Bank  Status</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0"><select name="bankstatus" id="bankstatus" style="width: 130px;">
                    <?php
		 	if ($bankstatus != '') 
		  	{
			  echo '<option value="'.$status.'" selected="selected">'.$bankstatus.'</option>';
		 	}
			else
			{
			  echo '<option value="" selected="selected">Active</option>';
			}
			?>
                    <option value="">Active</option>
                    <option value="Deleted">Deleted</option>
                </select></td>
              </tr>
            </tbody>
          </table></td>
        </tr>
        <tr>
          <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="95%" 
            align="left" border="0">
            <tbody>
              <tr>
                <td width="3%" align="left" valign="center"  
                bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
                <td width="30%" align="left" valign="center"  
                bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
                <td width="30%" align="left" valign="center"  
                bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
                <td width="41%" align="left" valign="center"  
                bgcolor="#cccccc" class="bodytext31"><div align="right">
				<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
				<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
				<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
				<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
				<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                    <input type="hidden" name="frmflag1" value="frmflag1" />
                    <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
                    <input name="Submit222" type="submit"  value="Save Bank" class="button" style="border: 1px solid #001E6A"/>
                </font></font></font></font></font></div></td>
                </tr>
            </tbody>
          </table></td>
        </tr>
        <tr>
          <td><?php include ("includes/footer1.php"); ?></td>
        </tr>
    </table>
	</form>
</table>
</body>
</html>

