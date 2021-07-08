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
	$accountnameanum = $_REQUEST['accountnameanum'];
	$accountname = $_REQUEST["accountname"];
	$accountname = strtoupper($accountname);
	$accountname = trim($accountname);
	$length=strlen($accountname);
	$paymenttype = $_REQUEST['paymenttype'];
	$subtype = $_REQUEST['subtype'];
	$expirydate = $_REQUEST['expirydate'];
	$recordstatus = $_REQUEST['recordstatus'];
	$address = $_REQUEST['address'];
	$accountsmaintype = $_REQUEST['accountsmain'];
	$accountssub = $_REQUEST['accountssub'];
	$openingbalancecreditnew = $_REQUEST['openingbalancecredit'];
	$openingbalancedebitnew = $_REQUEST['openingbalancedebit'];
	$id = $_REQUEST['id'];
	$contact = $_REQUEST['contact'];
	$locationcode = $_REQUEST['location'];
	$is_subtype = isset($_REQUEST['is_subtype']) ? $_REQUEST['is_subtype'] : "";
	
	$query8 = "select * from master_location where locationcode = '$locationcode'";
	$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
	$res8 = mysql_fetch_array($exec8);
	$locationname = $res8['locationname'];
	
	if ($length<=500)
	{
	$query2 = "select * from master_accountname where auto_number = '$accountnameanum'";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	$res2 = mysql_num_rows($exec2);
	if ($res2 != 0)
	{
		//$query1 = "insert into master_accountname (accountname,recordstatus, paymenttype, subtype, expirydate, ipaddress, recorddate, username) 
		//values ('$accountname', '$recordstatus','$paymenttype', '$subtype', '$expirydate','$ipaddress', '$updatedatetime', '$username')";
		
    	$query1 = "update master_accountname set accountname = '$accountname', recordstatus = '$recordstatus', 
		paymenttype = '$paymenttype', subtype = '$subtype', expirydate = '$expirydate', ipaddress = '$ipaddress', 
		recorddate = '$updatedatetime', username = '$username',address = '$address',openingbalancecredit = '$openingbalancecreditnew',openingbalancedebit = '$openingbalancedebitnew',accountsmain='$accountsmaintype',accountssub='$accountssub',id='$id', contact='$contact', locationcode='$locationcode', locationname='$locationname', is_subtype = '$is_subtype' where auto_number = '$accountnameanum'";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$errmsg = "Success. Account Name Updated.";
		//$bgcolorcode = 'success';
		header ("location:addaccountname1.php");
	}
	//exit();
	else
	{
		$errmsg = "Failed. Account Name Update Failed.";
		//$bgcolorcode = 'failed';
		header ("location:editaccountname1.php?bgcolorcode=success&&st=edit&&anum=$accountnameanum");
	}
	}
	else
	{
		$errmsg = "Failed. Only 500 Characters Are Allowed.";
		//$bgcolorcode = 'failed';
		header ("location:editaccountname1.php?bgcolorcode=success&&st=edit&&anum=$accountnameanum");
	}

}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_accountname set recordstatus = 'DELETED' where auto_number = '$delanum'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
}
if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_accountname set recordstatus = 'ACTIVE' where auto_number = '$delanum'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
}
if ($st == 'default')
{
	$delanum = $_REQUEST["anum"];
	$query4 = "update master_accountname set defaultstatus = '' where cstid='$custid' and cstname='$custname'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());

	$query5 = "update master_accountname set defaultstatus = 'DEFAULT' where auto_number = '$delanum'";
	$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
}
if ($st == 'removedefault')
{
	$delanum = $_REQUEST["anum"];
	$query6 = "update master_accountname set defaultstatus = '' where auto_number = '$delanum'";
	$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
}


if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add Account Name To Proceed For Billing.";
	$bgcolorcode = 'failed';
}

if (isset($_REQUEST["anum"])) { $anum = $_REQUEST["anum"]; } else { $anum = ""; }
if ($st == 'edit' && $anum != '')
{
	$query1 = "select * from master_accountname where auto_number = '$anum'";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	$res1 = mysql_fetch_array($exec1);
	$res1autonumber = $res1['auto_number'];
	$res1paymenttype = $res1['paymenttype'];
	$res1subtype = $res1['subtype'];
	$res1accountname = $res1['accountname'];
	$res1recordstatus = $res1['recordstatus'];
	$res1expirydate = $res1['expirydate'];
	$address = $res1['address'];
	$res1accountsmain = $res1['accountsmain'];
	$res1accountssub = $res1['accountssub'];
	$openingbalancecredit = $res1['openingbalancecredit'];
	$openingbalancedebit = $res1['openingbalancedebit'];
	$id = $res1['id'];
	$contact = $res1['contact'];
	$locationcode1 = $res1['locationcode'];
	$locationname1 = $res1['locationname'];
	$is_subtype = $res1['is_subtype'];
}


   
if (isset($_REQUEST["bgcolorcode"])) { $bgcolorcode = $_REQUEST["bgcolorcode"]; } else { $bgcolorcode = ""; }
if ($bgcolorcode == 'success')
{
		$errmsg = "Success. Account Name Updated.";
}
if ($bgcolorcode == 'failed')
{
		$errmsg = "Failed. Account Name Update Failed.";
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
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</script>

<script src="js/datetimepicker_css.js"></script>

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
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
</style>
</head>
<script language="javascript">



function funcPaymentTypeChange1()
{
	<?php 
	$query12 = "select * from master_paymenttype where recordstatus = ''";
	$exec12 = mysql_query($query12) or die ("Error in Query11".mysql_error());
	while ($res12 = mysql_fetch_array($exec12))
	{
	$res12paymenttypeanum = $res12["auto_number"];
	$res12paymenttype = $res12["paymenttype"];
	?>
	if(document.getElementById("paymenttype").value=="<?php echo $res12paymenttypeanum; ?>")
	{
		document.getElementById("subtype").options.length=null; 
		var combo = document.getElementById('subtype'); 	
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Sub Type", ""); 
		<?php
		$query10 = "select * from master_subtype where maintype = '$res12paymenttypeanum' and recordstatus = ''";
		$exec10 = mysql_query($query10) or die ("error in query10".mysql_error());
		while ($res10 = mysql_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10subtypeanum = $res10['auto_number'];
		$res10subtype = $res10["subtype"];
		?>
			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10subtype;?>", "<?php echo $res10subtypeanum;?>"); 
		<?php 
		}
		?>
	}
	<?php
	}
	?>	
}


function funcexpiry()
{
	<?php $date = mktime(0,0,0,date("m"),date("d")-1,date("Y")); 
	$currentdate = date("Y/m/d",$date);
	?>
	var currentdate = "<?php echo $currentdate; ?>";
	var expirydate = document.getElementById("expirydate").value; 
	var currentdate = Date.parse(currentdate);
	var expirydate = Date.parse(expirydate);
	
	if (expirydate < currentdate)
	{
		alert("Please Select Correct Account Expiry Date");
		document.getElementById("expirydate").value = "";
		document.getElementById("expirydate").focus();
		return false;
	}
}

function funcAccountsMainTypeChange1()
{
	/*if(document.getElementById("paymenttype").value == "1")
	{
		alert("You Cannot Add Account For CASH Type");
		document.getElementById("paymenttype").focus();
		return false;
	}*/
	<?php 
	$query12 = "select * from master_accountsmain where recordstatus = ''";
	$exec12 = mysql_query($query12) or die ("Error in Query11".mysql_error());
	while ($res12 = mysql_fetch_array($exec12))
	{
	$res12accountsmainanum = $res12["auto_number"];
	$res12accountsmain = $res12["accountsmain"];
	?>
	if(document.getElementById("accountsmain").value=="<?php echo $res12accountsmainanum; ?>")
	{
		document.getElementById("accountssub").options.length=null; 
		var combo = document.getElementById('accountssub'); 	
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Sub Type", ""); 
		<?php
		$query10 = "select * from master_accountssub where accountsmain = '$res12accountsmainanum' and recordstatus = ''";
		$exec10 = mysql_query($query10) or die ("error in query10".mysql_error());
		while ($res10 = mysql_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10accountssubanum = $res10['auto_number'];
		$res10accountssub = $res10["accountssub"];
		?>
			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10accountssub;?>", "<?php echo $res10accountssubanum;?>"); 
		<?php 
		}
		?>
	}
	
	<?php
	}
	?>	
}
function funcDeleteAccountName1(varAccountNameAutoNumber)
{
	var varAccountNameAutoNumber = varAccountNameAutoNumber;
	var fRet;
	fRet = confirm('Are you sure want to delete this account name '+varAccountNameAutoNumber+'?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("Account Name Entry Delete Completed.");
		//return false;
	}
	if (fRet == false)
	{
		alert ("Account Name Entry Delete Not Completed.");
		return false;
	}
	//return false;
}


</script>
<script type="text/javascript">
function Process()
{
	if(document.getElementById("location").value=="")
	{
		alert('Select Location');
		document.getElementById("location").focus();
		return false;
	}
	if(document.getElementById("accountsmaintype").value=="")
	{
		alert('Select Accounts Main');
		document.getElementById("accountsmaintype").focus();
		return false;
	}
	if(document.getElementById("accountssub").value=="")
	{
		alert('Select Accounts Sub');
		document.getElementById("accountssub").focus();
		return false;
	}
	if(document.getElementById("id").value=="")
	{
		alert('Select Accounts');
		document.getElementById("id").focus();
		return false;
	}
	if(document.getElementById("accountname").value=="")
	{
		alert('Enter Accountname');
		document.getElementById("accountname").focus();
		return false;
	}
}
</script>

<script src="js/datetimepicker_css.js"></script>

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
              <td><form name="form1" id="form1" method="post" action="editaccountname1.php" onSubmit="return Process()">
                  <table width="864" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="4" bgcolor="#CCCCCC" class="bodytext3"><strong>Account Name Master - Edit </strong></td>
                      </tr>
					  <tr>
                        <td colspan="4" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Location</div></td>
                        <td width="28%" align="left" valign="top"  bgcolor="#FFFFFF"><strong>
						<select name="location" id="location">
						<?php if($locationcode1 != '') { ?>
						<option value="<?php echo $locationcode1; ?>"><?php echo $locationname1; ?></option>
						<?php } ?>
						<option value="">Select Location</option>
						<?php
						$query50 = "select * from master_location where status <> 'deleted' order by locationname";
						$exec50 = mysql_query($query50) or die ("Error in Query50".mysql_error());
						while ($res50 = mysql_fetch_array($exec50))
						{
						$locationname = $res50["locationname"];
						$locationcode = $res50["locationcode"];
						?>
						<option value="<?php echo $locationcode; ?>"><?php echo $locationname; ?></option>
						<?php
						}
						?>
						</select>
                        </strong></td>
                        <td width="20%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">&nbsp;</div></td>
                        <td width="23%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><strong>&nbsp;</strong></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Account Main Type </div></td>
                        <td width="31%" align="left" valign="top"  bgcolor="#FFFFFF"><strong>
						<select name="accountsmain" id="accountsmain" onChange="return funcAccountsMainTypeChange1()">
						<?php
						//*
						if ($res1accountsmain == '')
						{
						echo '<option value="" selected="selected">Select</option>';
						}
						else
						{
						$query4 = "select * from master_accountsmain where auto_number = '$res1accountsmain'";
						$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
						$res4 = mysql_fetch_array($exec4);
						$res4accountsmain = $res4['auto_number'];
						$res4accountsmainname = $res4['accountsmain'];
					
						echo '<option value="'.$res4accountsmain.'" selected="selected">'.$res4accountsmainname.'</option>';
						}
						?>
						
						<?php
						$query5 = "select * from master_accountsmain where recordstatus = '' order by accountsmain";
						$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
						while ($res5 = mysql_fetch_array($exec5))
						{
						$res5anum = $res5["auto_number"];
						$res5accountsmain = $res5["accountsmain"];
						?>
						<option value="<?php echo $res5anum; ?>"><?php echo $res5accountsmain; ?></option>
						<?php
						}
						?>
						</select>
                        </strong></td>
                        <td width="19%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Main Type </div></td>
                        <td width="20%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><strong>
						<select name="paymenttype" id="paymenttype" onChange="return funcPaymentTypeChange1()">
						<?php
						//*
						if ($res1paymenttype == '')
						{
						echo '<option value="" selected="selected">Select Type</option>';
						}
						else
						{
						$query4 = "select * from master_paymenttype where auto_number = '$res1paymenttype'";
						$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
						$res4 = mysql_fetch_array($exec4);
						$res4dmaintypeanum = $res4['auto_number'];
						$res4maintypename = $res4['paymenttype'];
					
						echo '<option value="'.$res4dmaintypeanum.'" selected="selected">'.$res4maintypename.'</option>';
						}
					?>
					<option value="">Select Type</option>
					
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
                        </strong></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Account Sub Type </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF"><strong>
                          <select name="accountssub" id="accountssub">
						<?php
						//*
						if ($res1accountssub == '')
						{
						echo '<option value="" selected="selected">Select </option>';
						}
						else
						{
						$query4 = "select * from master_accountssub where auto_number = '$res1accountssub'";
						$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
						$res4 = mysql_fetch_array($exec4);
						$res4accountssubanum = $res4['auto_number'];
						$res4accountssubname = $res4['accountssub'];
					
						echo '<option value="'.$res4accountssubanum.'" selected="selected">'.$res4accountssubname.'</option>';
						}
						//*/
						?>
                          </select>
                        </strong></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Sub Type </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><strong>
                          <select name="subtype" id="subtype">
						<?php
						//*
						if ($res1subtype == '')
						{
						echo '<option value="" selected="selected">Select Sub Type</option>';
						}
						else
						{
						$query4 = "select * from master_subtype where auto_number = '$res1subtype'";
						$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
						$res4 = mysql_fetch_array($exec4);
						$res4subtypeanum = $res4['auto_number'];
						$res4subtypename = $res4['subtype'];
					
						echo '<option value="'.$res4subtypeanum.'" selected="selected">'.$res4subtypename.'</option>';
						}
						
						?>
							<option value="">Select Sub Type</option>
                          </select>
                        </strong></td>
                      </tr>
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">ID</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="id" id="id" value="<?php echo $id; ?>" readonly="readonly" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" /></td>
                        <td align="right" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Opg.Bal Dr</td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><input type="text" style="border: 1px solid #001E6A;" name="openingbalancedebit" id="openingbalancedebit" value="<?php echo $openingbalancedebit; ?>"></td>
                      </tr>
                      
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Add New Account Name </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="accountname" id="accountname" value="<?php echo $res1accountname; ?>" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" /></td>
                     <td align="right" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Opg.Bal Cr</td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><input type="text" style="border: 1px solid #001E6A;" name="openingbalancecredit" id="openingbalancecredit" value="<?php echo $openingbalancecredit; ?>"></td>
                        </tr>
                      
                      <tr>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Account Status </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF"><label>
                          <select name="recordstatus" id="recordstatus" style="border: 1px solid #001E6A; text-transform:uppercase">
						<?php
						//*
						if ($res1recordstatus == '')
						{
						echo '<option value="" selected="selected">Select Account Status</option>';
						}
						else
						{
						echo '<option value="'.$res1recordstatus.'" selected="selected">'.$res1recordstatus.'</option>';
						}
						//*/
						?>
                            <option value="ACTIVE">ACTIVE</option>
                            <option value="DELETED">INACTIVE</option>
                          </select>
                        </label></td>
                        <td align="right" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Receivable Account</td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><input type="checkbox" name="is_subtype" id="is_subtype" value="1" <?php if($is_subtype==1){ echo "checked"; } ?>></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Validity End Date </div></td>
                        <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
                          <input type="text" name="expirydate" id="expirydate" value="<?php echo $res1expirydate; ?>"   onFocus="return funcexpiry();" readonly="readonly"  style="border: 1px solid #001E6A;">
						   <strong><span class="bodytext312"> <img src="images2/cal.gif" onClick="javascript:NewCssCal('expirydate')" style="cursor:pointer"/> </span></strong></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Address </div></td>
                        <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
						<textarea name="address" id="address" style="border: 1px solid #001E6A; text-transform:uppercase" rows="3" cols="20"><?php echo $address; ?></textarea></td>
                      </tr>
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Contact </div></td>
                        <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="text" name="contact" id="contact" value="<?php echo $contact; ?>" style="border: 1px solid #001E6A;text-transform:uppercase" size="30"></td>
                      </tr>
                      <tr>
                        <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="hidden" name="frmflag" value="addnew" />
                            <input type="hidden" name="frmflag1" value="frmflag1" />
							<input type="hidden" name="accountnameanum" id="accountnameanum" value="<?php echo $res1autonumber; ?>">
                          <input type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A" /></td>
                      </tr>
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
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

