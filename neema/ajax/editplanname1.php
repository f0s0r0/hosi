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
$plannameanum = $_REQUEST['anum'];
if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
    $plannameanum = $_REQUEST['plannameanum'];
	$planname = $_REQUEST["planname"];
	$planname = strtoupper($planname);
	$planname = trim($planname);
	$length=strlen($planname);
	$planstatus = $_REQUEST["planstatus"];
	$planstatus = strtoupper($planstatus);
	$planstatus = trim($planstatus);
	$length=strlen($planstatus);
	
	//echo $length;
	$maintype = $_REQUEST["paymenttype"];
	$subtype = $_REQUEST["subtype"];
	$accountname = $_REQUEST["accountname"];
	$plancondition = $_REQUEST["plancondition"];
	$planfixedamount = isset($_REQUEST["planfixedamount"])?$_REQUEST["planfixedamount"]:'0.00';
	$planpercentage = isset($_REQUEST["planpercentage"])?$_REQUEST["planpercentage"]:'0.00';
	$planexpirydate = $_REQUEST["planexpirydate"];
	$planstartdate = $_REQUEST["planstartdate"];
	$overalllimitop=isset($_REQUEST["overalllimitop"])?$_REQUEST["overalllimitop"]:'';
	$overalllimitip=isset($_REQUEST["overalllimitip"])?$_REQUEST["overalllimitip"]:'';
	$opvisitlimit=isset($_REQUEST["opvisitlimit"])?$_REQUEST["opvisitlimit"]:'';
	$ipvisitlimit=isset($_REQUEST["ipvisitlimit"])?$_REQUEST["ipvisitlimit"]:'';
	$smartap = isset($_REQUEST['smart'])?$_REQUEST['smart']:'';
	$recordstatus = $_REQUEST["recordstatus"];
	$exclusions = $_REQUEST['exclusions'];
	
	$forall = isset($_REQUEST['forall'])?$_REQUEST['forall']:'';
	
	if ($length<=255)
	{
	$query2 = "select * from master_planname where auto_number = '$plannameanum'";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	$res2 = mysql_num_rows($exec2); 
	if ($res2 != 0)
	{
		$query1 = "update master_planname set maintype = '$maintype', subtype = '$subtype',accountname = '$accountname',planname = '$planname', planstatus='$planstatus',  plancondition = '$plancondition', planfixedamount = '$planfixedamount',planpercentage = '$planpercentage', smartap = '$smartap',
		planexpirydate = '$planexpirydate',overalllimitop = '$overalllimitop', overalllimitip = '$overalllimitip',opvisitlimit = '$opvisitlimit',ipvisitlimit = '$ipvisitlimit',recordstatus = '$recordstatus',exclusions =  '$exclusions',planstartdate='".$planstartdate."',forall='".$forall."' where auto_number = '$plannameanum'";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		
		//$bgcolorcode = 'success';
		header ("location:addplanname1.php?bgcolorcode=success&&st=changed&&anum=$plannameanum");
	}
	//exit();
	else
	{
		$errmsg = "Failed. Plan Name Already Exists.";
		$bgcolorcode = 'failed';
		header ("location:editplanname1.php?bgcolorcode=success&&st=edit&&anum=$plannameanum");
	}
	}
	else
	{
		$errmsg = "Failed. Only 100 Characters Are Allowed.";
		//$bgcolorcode = 'failed';
		header ("location:editplanname1.php?bgcolorcode=success&&st=edit&&anum=$plannameanum");
	}

}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_planname set recordstatus = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
}
if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_planname set recordstatus = '' where auto_number = '$delanum'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
}
if ($st == 'default')
{
	$delanum = $_REQUEST["anum"];
	$query4 = "update master_planname set defaultstatus = '' where cstid='$custid' and cstname='$custname'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());

	$query5 = "update master_planname set defaultstatus = 'DEFAULT' where auto_number = '$delanum'";
	$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
}
if ($st == 'removedefault')
{
	$delanum = $_REQUEST["anum"];
	$query6 = "update master_planname set defaultstatus = '' where auto_number = '$delanum'";
	$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
}


if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add Plan Name To Proceed For Billing.";
	$bgcolorcode = 'failed';
}

if (isset($_REQUEST["anum"])) { $anum = $_REQUEST["anum"]; } else { $anum = ""; }
if ($st == 'edit' && $anum != '')
{
	$query1 = "select * from master_planname where auto_number = '$anum'";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	$res1 = mysql_fetch_array($exec1);
	
	$res1autonumber = $res1['auto_number'];
    $res1maintype = $res1["maintype"];
	$res1subtype =  $res1["subtype"];
	$res1accountname =  $res1["accountname"];
	$res1planname =  $res1["planname"];
	$res1plancondition =  $res1["plancondition"];
	
	 $res1forall =  $res1["forall"];
	 $res1planstartdate =  $res1["planstartdate"];
	
	$res1planfixedamount =  $res1["planfixedamount"];
	if ($res1planfixedamount == '0.00') $res1planfixedamount = '';
	
	$res1planpercentage =  $res1["planpercentage"];
	if ($res1planpercentage == '0.00') $res1planpercentage = '';

	$res1planexpirydate = $res1["planexpirydate"];
	$res1overalllimitop =  $res1["overalllimitop"];
	$res1overalllimitip =  $res1["overalllimitip"];
	$res1opvisitlimit =  $res1["opvisitlimit"];
	$res1ipvisitlimit =  $res1["ipvisitlimit"];
    $res1recordstatus =  $res1["recordstatus"];
	$res1exclusions = $res1['exclusions'];
	$res1smartap = $res1['smartap'];
	$res1planstatus = $res1['planstatus'];
}

   
if (isset($_REQUEST["bgcolorcode"])) { $bgcolorcode = $_REQUEST["bgcolorcode"]; } else { $bgcolorcode = ""; }
if ($bgcolorcode == 'success')
{
	$errmsg = "Success. New Insurance Company Updated.";
}
if ($bgcolorcode == 'failed')
{
	$errmsg = "Failed. Insurance Company Already Exists.";
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
</head>
<script language="javascript">
function checking(){
		//alert('ok');
	var vlimit = document.getElementById("vlimit");
	var alllimit = document.getElementById("alllimit");
	var overalllimit = document.getElementById("overalllimit");
	var visitlimit = document.getElementById("visitlimit");
	var limit = document.getElementsByClassName("limit");
	if(vlimit.checked){
		vlimit.checked = true;
		alllimit.checked = false;
		overalllimit.disabled = true;
		overalllimit.value ='';
		visitlimit.disabled = false;	
	}else if(alllimit.checked){
		alllimit.checked = true;
		vlimit.checked = false;
		visitlimit.disabled = true;
		visitlimit.value = '';
		overalllimit.disabled = false;	
	}
	}
function addplanname1process1()
{
	//alert ("Inside Funtion");
	if (document.form1.accountname.value == "")
	{
		alert ("Please Select Account Name.");
		document.form1.accountname.focus();
		return false;
	}
	if (document.form1.limitstatus.value == "")
	{
		alert ("Please Select Limit status.");
		document.form1.limitstatus.focus();
		return false;
	}
	if (document.form1.limitstatus.value == "overall")
	{
		if (document.form1.overalllimitop.value == ''){
		alert ("Please Enter Overalllimitop.");
		document.form1.overalllimitop.focus();
		return false;
		}else if(document.form1.overalllimitip.value == ''){
		alert ("Please Enter Overalllimitip.");
		document.form1.overalllimitip.focus();
		return false;
		}
	}else if(document.form1.limitstatus.value == "visit"){
		if (document.form1.opvisitlimit.value == ''){
		alert ("Please Enter opvisitlimit.");
		document.form1.opvisitlimit.focus();
		return false;
		}else if(document.form1.ipvisitlimit.value == ''){
		alert ("Please Enter ipvisitlimit.");
		document.form1.ipvisitlimit.focus();
		return false;
		}
	}
	if (document.form1.planstartdate.value == "")
	{
		alert ("Please Select Plan Start Date.");
		document.form1.planstartdate.focus();
		return false;
	}
	if (document.form1.planexpirydate.value == "")
	{
		alert ("Please Select Plan Expiry Date.");
		document.form1.planexpirydate.focus();
		return false;
	}
	if (document.form1.recordstatus.value == "")
	{
		alert ("Please Select Plan Status.");
		document.form1.recordstatus.focus();
		return false;
	}
	
	/*if(document.getElementById("paymenttype").value == "1")
	{
		alert("You Cannot Add Account For CASH Type");
		document.getElementById("paymenttype").focus();
		return false;
	}*/
	if (document.form1.planname.value == "")
	{
		alert ("Please Enter Plan Name.");
		document.form1.planname.focus();
		return false;
	}
	/*
	if (document.form1.plancondition.value == "")
	{
		alert ("Please Select Plan Condition.");
		document.form1.plancondition.focus();
		return false;
	}
	
	if (document.form1.plancondition.value == "OVERALL LIMIT" && document.form1.overalllimit.value== "")
	{
		alert ("Please Enter  Overall Limit.");
		document.form1.overalllimit.focus();
		return false;
	}
	*/
	
	if (document.form1.planfixedamount.value != "")
	{
		if (isNaN(document.form1.planfixedamount.value))
		{
			alert ("Plan Fixed Amount Can Only Be Numbers.");
			document.form1.planfixedamount.focus();
			return false;
		}
	}
	if (document.form1.planpercentage.value != "")
	{
		if (isNaN(document.form1.planpercentage.value))
		{
			alert ("Plan Percentage Can Only Be Numbers.");
			document.form1.planpercentage.focus();
			return false;
		}
	}
	
	if (document.form1.overalllimit.value != "")
	{
		if (isNaN(document.form1.overalllimit.value))
		{
			alert ("Plan  Overall Limit Can Only Be Numbers.");
			document.form1.overalllimit.focus();
			return false;
		}
	}
	
	if (document.form1.visitlimit.value != "")
	{
		if (isNaN(document.form1.visitlimit.value))
		{
			alert ("Plan  Visit Limit Can Only Be Numbers.");
			document.form1.visitlimit.focus();
			return false;
		}
	}
	if (document.form1.planexpirydate.value == "")
	{
		alert ("Please Enter Plan Expiry Date.");
		document.form1.planexpirydate.focus();
		return false;
	}
	if (document.form1.recordstatus.value == "")
	{
		alert ("Please Select Plan Status.");
		document.form1.recordstatus.focus();
		return false;
	}	
	
}
function numbervaild(key)
{
 var keycode = (key.which) ? key.which : key.keyCode;

  if(keycode > 40 && (keycode < 48 || keycode > 57 )&&( keycode < 96 || keycode > 111))
 {
  return false;
 }
}
window.onload= function(){
 var limitstatus = document.getElementById("limitstatus");
 if(limitstatus.value=='overall')
 {
		 document.getElementById("ipvisitlimit").disabled=true;
		 document.getElementById("ipvisitlimit").value = '';
		 document.getElementById("opvisitlimit").disabled=true;
		 document.getElementById("opvisitlimit").value= '';
		 document.getElementById("overalllimitip").disabled=false;
		 document.getElementById("overalllimitop").disabled=false;
	}
	else if(limitstatus.value=='visit')
	{
		 document.getElementById("overalllimitip").disabled=true;
		 document.getElementById("overalllimitip").value = '';
		 document.getElementById("overalllimitop").disabled=true;
		 document.getElementById("overalllimitop").value = '';
		 document.getElementById("ipvisitlimit").disabled=false;
		 document.getElementById("opvisitlimit").disabled=false;
	}
	
}
function functionlimit(a)
{
	var limit =a;
	if(limit=='overall')
	{
		 document.getElementById("ipvisitlimit").disabled=true;
		 document.getElementById("ipvisitlimit").value = '';
		 document.getElementById("opvisitlimit").disabled=true;
		 document.getElementById("opvisitlimit").value= '';
		 document.getElementById("overalllimitip").disabled=false;
		 document.getElementById("overalllimitop").disabled=false;
	}
	else if(limit=='visit')
	{
		 document.getElementById("overalllimitip").disabled=true;
		 document.getElementById("overalllimitip").value = '';
		 document.getElementById("overalllimitop").disabled=true;
		 document.getElementById("overalllimitop").value = '';
		 document.getElementById("ipvisitlimit").disabled=false;
		 document.getElementById("opvisitlimit").disabled=false;
	}
	
	return false;
}

function funcPaymentTypeChange1()
{
	<?php 
	$query12 = "select * from master_paymenttype where recordstatus = ''";
	$exec12 = mysql_query($query12) or die ("Error in Query11".mysql_error());
	while ($res12 = mysql_fetch_array($exec12))
	{
	$res12paymenttypeanum = $res12['auto_number'];
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



function funcSubTypeChange1()
{
	<?php 
	$query12 = "select * from master_subtype where recordstatus = ''";
	$exec12 = mysql_query($query12) or die ("Error in Query11".mysql_error());
	while ($res12 = mysql_fetch_array($exec12))
	{
	$res12subtypeanum = $res12["auto_number"];
	$res12subtype = $res12["subtype"];
	?>
	if(document.getElementById("subtype").value=="<?php echo $res12subtypeanum; ?>")
	{
		document.getElementById("accountname").options.length=null; 
		var combo = document.getElementById('accountname'); 	
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Account Name", ""); 
		<?php
		$query10 = "select * from master_accountname where subtype = '$res12subtypeanum' and recordstatus = 'ACTIVE'";
		$exec10 = mysql_query($query10) or die ("error in query10".mysql_error());
		while ($res10 = mysql_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10accountnameanum = $res10['auto_number'];
		$res10accountname = $res10["accountname"];
		?>
			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10accountname;?>", "<?php echo $res10accountnameanum;?>"); 
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
	var expirydate = document.getElementById("planexpirydate").value; 
	var currentdate = Date.parse(currentdate);
	var expirydate = Date.parse(expirydate);
	
	if (expirydate < currentdate)
	{
		alert("Please Select Correct Account Expiry Date");
		document.getElementById("planexpirydate").value = "";
		document.getElementById("planexpirydate").focus();
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
              <td><form name="form1" id="form1" method="post" action="editplanname1.php" onSubmit="return addplanname1process1()">
              <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber" style="border-collapse: collapse">
                      <tbody>
                        <tr bgcolor="#011E6A">
                          <td colspan="4" bgcolor="#CCCCCC" class="bodytext3"><strong>Plan Name Master - Edit</strong></td>
                        </tr>
                        <tr>
                          <td colspan="4" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Main Type </div></td>
                          <td align="left" colspan="3" valign="top"  bgcolor="#FFFFFF">
                          
                          <input name="plannameanum" id="plannameanum"  type="hidden" value="<?php echo $plannameanum;?>"/>
                          <select name="paymenttype" id="paymenttype" onChange="return funcPaymentTypeChange1();">
                            <?php
				if ($res1maintype == '')
				{
					echo '<option value="" selected="selected">Select Type</option>';
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
				$res5paymenttype = $res5["paymenttype"];
				?>
                          <option value="<?php echo $res5anum; ?>"><?php echo $res5paymenttype; ?></option>
                          <?php
				}
				?>
                          </select></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Sub Type </div></td>
                          <td align="left" colspan="3" valign="top"  bgcolor="#FFFFFF"><select name="subtype" id="subtype" onChange="return funcSubTypeChange1()">
                           <?php   	if ($res1subtype == '')
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
					
					$query5 = "select * from master_subtype where recordstatus = '' order by subtype";
					$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
					while ($res5 = mysql_fetch_array($exec5))
					{
					$res5anum = $res5["auto_number"];
					$res5subtype = $res5["subtype"];
					?>
							  <option value="<?php echo $res5anum; ?>"><?php echo $res5subtype; ?></option>
                          <?php
				}
				?>
                          </select></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Account Name </div></td>
                          <td align="left" valign="top" colspan="3"  bgcolor="#FFFFFF"><strong>
                            <select name="accountname" id="accountname">
                               <?php
				if ($res1accountname == '')
				{
					echo '<option value="" selected="selected">Select Type</option>';
				}
				else
				{
					$query4 = "select * from master_accountname where auto_number = '$res1accountname'";
					$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
					$res4 = mysql_fetch_array($exec4);
					$res4res1accountnameanum = $res4['auto_number'];
					$res4res1accountname = $res4['accountname'];
				
					echo '<option value="'.$res4res1accountnameanum.'" selected="selected">'.$res4res1accountname.'</option>';
				}
				
				$query5 = "select * from master_accountname where recordstatus = '' order by accountname";
				$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
				while ($res5 = mysql_fetch_array($exec5))
				{
				$res5anum = $res5["auto_number"];
				$res5accountname = $res5["accountname"];
				?>
                          <option value="<?php echo $res5anum; ?>"><?php echo $res5accountname; ?></option>
                          <?php
				}
				?>
                            </select>
                          </strong></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Add Plan Name </div></td>
                          <td align="left" valign="top" colspan="3" bgcolor="#FFFFFF"><input name="planname" id="planname" value=" <?php echo $res1planname ?>" style="border: 1px solid #001E6A; text-transform:uppercase;" size="40" /></td>
						<input type="hidden" name="plancondition" id="plancondition" value="">
                        </tr>
                        <tr>
                          <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Status </div></td>
                          <td align="left" valign="top"  bgcolor="#FFFFFF"><strong>
                            <select name="planstatus" id="planstatus">
							<?php if($res1planstatus != '') { ?>
							<option value="<?php echo $res1planstatus; ?>"><?php echo $res1planstatus; ?></option>
							<?php } ?>
                              <option value="op+ip" >OP+IP</option>
                              <option value="op" >OP</option>
                              <option value="ip" >IP</option>
                            </select>
                          </strong></td>
                          <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Limit Status </div></td>
                          <td align="left" valign="top"  bgcolor="#FFFFFF"><strong>
                            <select name="limitstatus" id="limitstatus" onChange="functionlimit(this.value)">
                              <option value="" selected="selected">Select Limit</option>
                              <option <?php if($res1overalllimitop != 0){echo "selected";}?> value="overall" >Overall</option>
                              <option <?php if($res1opvisitlimit !=0){echo "selected";}?> value="visit" >Visit</option>
                            </select>
                          </strong></td>
                        </tr>
                        <!--					  
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Plan Condition </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF"><strong>
                          <select name="plancondition" id="plancondition">
                            <?php
				if ($plancondition == '')
				{
					echo '<option value="" selected="selected">Select Plan Condition</option>';
				}
				else
				{
					$query51 = "select * from master_plancondition where recordstatus = ''";
					$exec51 = mysql_query($query51) or die ("Error in Query51".mysql_error());
					$res51 = mysql_fetch_array($exec51);
					$res51plancondition = $res51["plancondition"];
					//echo '<option value="">Select Normal Tax</option>';
					echo '<option value="'.$res51plancondition.'" selected="selected">'.$res51plancondition.'</option>';
				}
				
				$query5 = "select * from master_plancondition where recordstatus = '' order by plancondition";
				$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
				while ($res5 = mysql_fetch_array($exec5))
				{
				$res5anum = $res5["auto_number"];
				$res5plancondition = $res5["plancondition"];
				?>
                            <option value="<?php echo $res5plancondition; ?>"><?php echo $res5plancondition; ?></option>
                            <?php
				}
				?>
                          </select>
                        </strong></td>
                      </tr>
-->
                        <tr>
                          <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Copay Amount </div></td>
                          <td align="left" valign="top"   bgcolor="#FFFFFF"><input name="planfixedamount" id="planfixedamount" style="text-transform:uppercase;" size="10" value="<?php echo $res1planfixedamount;?>" onKeyDown="return numbervaild(event)"/></td>						<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Smart Applicable </div></td>
                          <td align="left" valign="top"   bgcolor="#FFFFFF"> <input type="checkbox" name="smart" <?php if($res1smartap ==1){echo "checked";}?> value="1"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Copay Percentage </div></td>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><input name="planpercentage" id="planpercentage" style="text-transform:uppercase;" size="10"  value="<?php echo $res1planpercentage ?>" onKeyDown="return numbervaild(event)"/></td>
                           <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">All</div></td>
                          <td align="left" valign="top"   bgcolor="#FFFFFF">
                            <input type="checkbox" name="forall" <?php if($res1forall =="yes"){echo "checked";}?> value="yes"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Overall OP Limit </div></td>
                          <td align="left" valign="top"  bgcolor="#FFFFFF"><label>
                            <input name="overalllimitop" type="text" id="overalllimitop" style="text-transform:uppercase;" size="10" onKeyDown="return numbervaild(event)" value="<?php echo $res1overalllimitop;?>">
                          </label></td>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Overall IP Limit </div></td>
                          <td align="left" valign="top"  bgcolor="#FFFFFF"><label>
                            <input name="overalllimitip" type="text" id="overalllimitip" style="text-transform:uppercase;" size="10"  onKeyDown="return numbervaild(event)" value="<?php echo $res1overalllimitip;?>">
                          </label></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right" >Visit OP Limit </div></td>
                          <td align="left" valign="top"   bgcolor="#FFFFFF"><label>
                            <input name="opvisitlimit" type="text" id="opvisitlimit" style="text-transform:uppercase;" size="10"  onKeyDown="return numbervaild(event)" value="<?php echo $res1opvisitlimit;?>">
                          </label></td>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right" >Visit IP Limit </div></td>
                          <td align="left" valign="top"   bgcolor="#FFFFFF"><label>
                            <input name="ipvisitlimit" type="text" id="ipvisitlimit" style="text-transform:uppercase;" size="10"  onKeyDown="return numbervaild(event)" value="<?php echo $res1ipvisitlimit;?>">
                          </label></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Plan Start Date </div></td>
                          <td align="left" valign="top"  colspan="3" bgcolor="#FFFFFF"><input type="text" name="planstartdate" id="planstartdate" value="<?php echo $res1planstartdate; ?>"  onFocus="return funcexpiry();" readonly >
                            <strong><span class="bodytext312"> <img src="images2/cal.gif" onClick="javascript:NewCssCal('planstartdate')" style="cursor:pointer"/></span></strong></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Plan Validity End </div></td>
                          <td align="left" valign="top" colspan="3" bgcolor="#FFFFFF"><input type="text" name="planexpirydate" id="planexpirydate" value="<?php echo $res1planexpirydate; ?>"  onFocus="return funcexpiry();" readonly>
                            <strong><span class="bodytext312"> <img src="images2/cal.gif" onClick="javascript:NewCssCal('planexpirydate')" style="cursor:pointer"/></span></strong></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Plan Status </div></td>
                          <td align="left" valign="top" colspan="3"  bgcolor="#FFFFFF"><label>
                            <select name="recordstatus" id="recordstatus" style="border: 1px solid #001E6A;">
	                       <?php
						if ($res1recordstatus == '')
						{
						echo '<option value="" selected="selected">Select Account Status</option>';
						}
						else
						{
						echo '<option value="'.$res1recordstatus.'" selected="selected">'.$res1recordstatus.'</option>';
						}
						?>
						<option value="ACTIVE">ACTIVE</option>
						<option value="DELETED">INACTIVE</option>
                        </select>
                          </label></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right" >Exclusions </div></td>
                          <td align="left" valign="top"  colspan="3" bgcolor="#FFFFFF"><label>
                            <textarea name="exclusions" id="exclusions" style="text-transform:uppercase;" rows="3"><?php echo $res1exclusions;?></textarea>
                          </label></td>
                        </tr>
                        <tr>
                          <td width="42%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                          <td width="58%" align="left" valign="top" colspan="3"  bgcolor="#FFFFFF"><input type="hidden" name="frmflag" value="addnew" />
                            <input type="hidden" name="frmflag1" value="frmflag1" />
                            <input type="submit" name="Submit" value="Submit" /></td>
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

