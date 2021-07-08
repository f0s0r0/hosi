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

	/*$planname = $_REQUEST["planname"];
	$planname = strtoupper($planname);
	$planname = trim($planname);
	$length=strlen($planname);
	//echo $length;
	
	$planstatus = $_REQUEST["planstatus"];
	$planstatus = strtoupper($planstatus);
	$planstatus = trim($planstatus);
	$length=strlen($planstatus);

	$maintype = $_REQUEST["paymenttypecode"];
	$subtype = $_REQUEST["subtypecode"];*/
	$accountnamecode = $_REQUEST["accountnamecode"];
//	$plancondition = $_REQUEST["plancondition"];
//	$planfixedamount = $_REQUEST["planfixedamount"];
//	$planpercentage = $_REQUEST["planpercentage"];
//	$smart = $_REQUEST["smart"];
	$lab_copay=isset($_REQUEST["lab_copay"])?$_REQUEST["lab_copay"]:'';
	$radiology_copay=isset($_REQUEST["radiology_copay"])?$_REQUEST["radiology_copay"]:'';
	$service_copay=isset($_REQUEST["service_copay"])?$_REQUEST["service_copay"]:'';
	$pharmacy_copay=isset($_REQUEST["pharmacy_copay"])?$_REQUEST["pharmacy_copay"]:'';
	
	//for ip
	$bed_copay=isset($_REQUEST["bed_copay"])?$_REQUEST["bed_copay"]:'';
	$nursing_copay=isset($_REQUEST["nursing_copay"])?$_REQUEST["nursing_copay"]:'';
	$rmo_copay=isset($_REQUEST["rmo_copay"])?$_REQUEST["rmo_copay"]:'';
	$package_copay=isset($_REQUEST["package_copay"])?$_REQUEST["package_copay"]:'';
	
	$misc_copay=isset($_REQUEST["misc_copay"])?$_REQUEST["misc_copay"]:'';
	$ambulance_copay=isset($_REQUEST["ambulance_copay"])?$_REQUEST["ambulance_copay"]:'';
	$mortuary_copay=isset($_REQUEST["mortuary_copay"])?$_REQUEST["mortuary_copay"]:'';
//	$recordstatus=$_REQUEST["recordstatus"];
//	$planstartdate = $_REQUEST["planstartdate"];
//	$planexpirydate = $_REQUEST["planexpirydate"];
//	$exclusions = $_REQUEST['exclusions'];
	
//	$forall = isset($_REQUEST['forall'])?$_REQUEST['forall']:'';
	
	
	/*$query2 = "select * from master_planname where planname = '$planname'";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	$res2 = mysql_num_rows($exec2);*/
	
		$query1 = "UPDATE master_copayaccount SET lab_copay = '".$lab_copay."',radiology_copay = '".$radiology_copay."',service_copay = '".$service_copay."',pharmacy_copay = '".$pharmacy_copay."', bed_copay = '".$bed_copay."', nursing_copay = '".$nursing_copay."', rmo_copay = '".$rmo_copay."', package_copay = '".$package_copay."', misc_copay = '".$misc_copay."', ambulance_copay = '".$ambulance_copay."', mortuary_copay = '".$mortuary_copay."' WHERE auto_number = '".$accountnamecode."'";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	//	$errmsg = "Success. New Plan Name Updated.";
	//	$bgcolorcode = 'success';
		
	header("location:addcopayplan.php");
	exit();
	
	

}

/*if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
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
if($st=='changed')
{
   $errmsg = "Success. New Plan Name Updated.";
   $bgcolorcode='success';
}
if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add Plan Name To Proceed For Billing.";
	$bgcolorcode = 'failed';
}
*/

?>
<style type="text/css">

body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none
}


</style>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />  


<style type="text/css">

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}

</style>
</head>
<script type="text/javascript" src="js/autocomplete_paymenttypeplan.js"></script>
<script type="text/javascript" src="js/autosuggest_paymenttype.js"></script>
<script type="text/javascript" src="js/autocomplete_subtypeplan.js"></script>
<script type="text/javascript" src="js/autosuggest_subtype.js"></script>
<script type="text/javascript" src="js/autocomplete_accountplan.js"></script>
<script type="text/javascript" src="js/autosuggest_account.js"></script>
<script language="javascript">

window.onload = function () 
{
		
	var oTextbox = new AutoSuggestControl(document.getElementById("paymenttype"), new StateSuggestions());
	var oTextbox = new AutoSuggestControl1(document.getElementById("subtype"), new StateSuggestions1());
	var oTextbox = new AutoSuggestControl2(document.getElementById("accountname"), new StateSuggestions2());  
	      
      
}
</script>
<script language="javascript">
/*function functionpayment()
{
	alert('hai');
	document.getElementById("subtype").value='';
	document.getElementById("accountname").value='';
	
}*/
//$(document).ready(function() {
//    $(".limit").click(function() {
//        selectedBox = this.id;
//
//        $(".limit").each(function() {
//            if ( this.id == selectedBox )
//            {
//                this.checked = true;
//				
//            }
//            else
//            {
//                this.checked = false;
//            };        
//        });
//    });    
//});

/*	function checking(){
		
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
	}*/
	function copay(a){
	var amount = document.getElementById("planfixedamount");
	var percentage = document.getElementById("planpercentage");
	if(amount.id==a){
		percentage.readOnly = true;
		percentage.value = '';
		amount.readOnly = false;
	}else if(percentage.id==a){
		percentage.readOnly = false;
		amount.readOnly = true;
		amount.value = '';
	}
}
function addplanname1process1()
{/*
	//alert ("Inside Funtion");
	if (document.form1.paymenttypecode.value == "")
	{
		alert ("Please Select Paymenttype Name.");
		document.form1.paymenttype.focus();
		return false;
	}
	if (document.form1.subtypecode.value == "")
	{
		alert ("Please Select Subtype Name.");
		document.form1.subtype.focus();
		return false;
	}
	if (document.form1.accountnamecode.value == "")
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
	
	
	if (document.form1.planname.value == "")
	{
		alert ("Please Enter Plan Name.");
		document.form1.planname.focus();
		return false;
	}
	
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
	
*/}
function numbervaild(key)
{
 var keycode = (key.which) ? key.which : key.keyCode;
  if(keycode > 40 && (keycode < 48 || keycode > 57 )&&( keycode < 96 || keycode > 111))
 {
  return false;
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
	//alert("hi");
	/*if(document.getElementById("paymenttype").value == "1")
	{
		alert("You Cannot Add Account For CASH Type");
		document.getElementById("paymenttype").focus();
		return false;
	}*/

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
              <td><form name="form1" id="form1" method="post" action="editcopayplan.php" onSubmit="return addplanname1process1()">
                <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                
                 <?php
					  $planid = isset($_REQUEST['planid'])?$_REQUEST['planid']:'';
	    $query1 = "select * from master_copayaccount where recordstatus <> 'DELETED' AND auto_number = '".$planid."'";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$res1 = mysql_fetch_array($exec1);
		
		//$planname = $res1["planname"];
		$accountname = $res1["accountname"];
		$lab_copay = $res1["lab_copay"];
		$radiology_copay = $res1["radiology_copay"];
		$service_copay = $res1["service_copay"];
		$pharmacy_copay = $res1["pharmacy_copay"];
		$bed_copay = $res1["bed_copay"];
		$nursing_copay = $res1["nursing_copay"];
		$rmo_copay = $res1["rmo_copay"];
		$package_copay = $res1["package_copay"];
		
		$misc_copay = $res1["misc_copay"];
		$ambulance_copay = $res1["ambulance_copay"];
		$mortuary_copay = $res1["mortuary_copay"];
		/*$planpercentage = $res1["planpercentage"];
		$auto_number = $res1["auto_number"];
		//$defaultstatus = $res1["defaultstatus"];*/
		$accountnamecode = $res1['auto_number'];
		
		
		
		?>
                <tbody>
                  <tr>
                    <td align="left" colspan="3" valign="top"  bgcolor="#FFFFFF"><table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber" style="border-collapse: collapse">
                      <tbody>
                        <tr bgcolor="#011E6A">
                          <td colspan="4" bgcolor="#CCCCCC" class="bodytext3"><strong>Edit Copay </strong></td>
                        </tr>
                        <tr>
                          <td colspan="4" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                        </tr>
                       <!-- <tr>
                          <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Main Type </div></td>
                          <td align="left" colspan="3" valign="top"  bgcolor="#FFFFFF">
                          <input type="text" name="paymenttype" id="paymenttype" autocomplete="off"    >
                           <input name="paymenttypecode" id="paymenttypecode"  type="hidden" >
                            <input name="paymenttypesearch" id="paymenttypesearch" type="hidden" >
                        
                          </td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Sub Type </div></td>
                          <td align="left" colspan="3" valign="top"  bgcolor="#FFFFFF">
                          <input type="text" name="subtype" id="subtype" autocomplete="off" >
                          <input name="subtypecode" id="subtypecode"  type="hidden" >
                           <input name="subtypesearch" id="subtypesearch" type="hidden" >
                           </td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Account Name </div></td>
                          <td align="left" valign="top" colspan="1"  bgcolor="#FFFFFF">
                            <input type="text" name="accountname" id="accountname" autocomplete="off" >
                            <input name="accountnamecode" id="accountnamecode"  type="hidden" >
                           <input name="accountnamesearch" id="accountnamesearch" type="hidden" >  
                          </td>
                         
                        </tr>-->
                       <!-- <tr>
                          <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Add Plan Name </div></td>
                          <td align="left" valign="top" colspan="3" bgcolor="#FFFFFF">
                          <input name="planname" id="planname" style="text-transform:uppercase;" size="40"  /></td>
                          <input type="hidden" name="plancondition" id="plancondition" value="">
                        </tr>-->
                       <!-- <tr>
                          <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Status </div></td>
                          <td align="left" valign="top"  bgcolor="#FFFFFF"><strong>
                            <select name="planstatus" id="planstatus">
                              <option value="op+ip" selected="selected">OP+IP</option>
                              <option value="op" >OP</option>
                              <option value="ip" >IP</option>
                            </select>
                          </strong></td>
                          <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Limit Status </div></td>
                          <td align="left" valign="top"  bgcolor="#FFFFFF"><strong>
                            <select name="limitstatus" id="limitstatus" onChange="functionlimit(this.value)">
                              <option value="" selected="selected">Select Limit</option>
                              <option value="overall" >Overall</option>
                              <option value="visit" >Visit</option>
                            </select>
                          </strong></td>
                        </tr>-->
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
                          <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Account Name </div></td>
                          <td width="66%" align="left" valign="top"   bgcolor="#FFFFFF"><input name="accountname" id="accountname" style="text-transform:uppercase;" size="40"  onKeyDown="return numbervaild(event)" onFocus="return copay(this.id)" readonly value="<?php echo $accountname;?>"/></td>	
                          <input type="hidden" name="accountnamecode" id="accountnamecode" value="<?php echo $accountnamecode?>">					<!--<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Smart Applicable </div></td>-->
                         
                        </tr>
                        <tr>
                          <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Lab </div></td>
                          <td align="left" valign="top"   bgcolor="#FFFFFF"><input name="lab_copay" id="lab_copay" style="text-transform:uppercase;" size="10"  onKeyDown="return numbervaild(event)" onFocus="return copay(this.id)" value="<?php echo $lab_copay;?>"/></td>						<!--<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Smart Applicable </div></td>-->
                         
                        </tr>
                        <tr>
                          <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Radiology </div></td>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><input name="radiology_copay" id="radiology_copay" style="text-transform:uppercase;" size="10"  onKeyDown="return numbervaild(event)" onFocus="return copay(this.id)" value="<?php echo $radiology_copay;?>"/></td>
                          <!-- <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">All</div></td>-->
                          <td width="6%" align="left" valign="top"   bgcolor="#FFFFFF">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Service </div></td>
                          <td align="left" valign="top"  bgcolor="#FFFFFF"><label>
                            <input name="service_copay" type="text" id="service_copay" style="text-transform:uppercase;" size="10" onKeyDown="return numbervaild(event)" value="<?php echo $service_copay;?>">
                          </label></td>
                          <!--<td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Overall IP Limit </div></td>-->
                          <td align="left" valign="top"  bgcolor="#FFFFFF">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right" >Pharmacy </div></td>
                          <td align="left" valign="top"   bgcolor="#FFFFFF"><label>
                            <input name="pharmacy_copay" type="text" id="pharmacy_copay" style="text-transform:uppercase;" size="10"  onKeyDown="return numbervaild(event)" value="<?php echo $pharmacy_copay;?>">
                          </label></td>
                          <!--<td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right" >Visit IP Limit </div></td>-->
                          <td align="left" valign="top"   bgcolor="#FFFFFF">&nbsp;</td>
                        </tr>
                        
                        <tr>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right" >Bed Charges </div></td>
                          <td align="left" valign="top"   bgcolor="#FFFFFF"><label>
                            <input name="bed_copay" type="text" id="bed_copay" style="text-transform:uppercase;" size="10"  onKeyDown="return numbervaild(event)" value="<?php echo $bed_copay;?>">
                          </label></td>
                          <!--<td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right" >Visit IP Limit </div></td>-->
                          <td align="left" valign="top"   bgcolor="#FFFFFF">&nbsp;</td>
                        </tr>
                         <tr>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right" >Nursing Charges </div></td>
                          <td align="left" valign="top"   bgcolor="#FFFFFF"><label>
                            <input name="nursing_copay" type="text" id="nursing_copay" style="text-transform:uppercase;" size="10"  onKeyDown="return numbervaild(event)" value="<?php echo $nursing_copay;?>">
                          </label></td>
                          <!--<td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right" >Visit IP Limit </div></td>-->
                          <td align="left" valign="top"   bgcolor="#FFFFFF">&nbsp;</td>
                        </tr>
                         <tr>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right" >RMO Charges </div></td>
                          <td align="left" valign="top"   bgcolor="#FFFFFF"><label>
                            <input name="rmo_copay" type="text" id="rmo_copay" style="text-transform:uppercase;" size="10"  onKeyDown="return numbervaild(event)" value="<?php echo $rmo_copay;?>">
                          </label></td>
                          <!--<td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right" >Visit IP Limit </div></td>-->
                          <td align="left" valign="top"   bgcolor="#FFFFFF">&nbsp;</td>
                        </tr>
                        
                        <tr>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right" >Package Charges </div></td>
                          <td align="left" valign="top"   bgcolor="#FFFFFF"><label>
                            <input name="package_copay" type="text" id="package_copay" style="text-transform:uppercase;" size="10"  onKeyDown="return numbervaild(event)" value="<?php echo $package_copay;?>">
                          </label></td>
                          <!--<td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right" >Visit IP Limit </div></td>-->
                          <td align="left" valign="top"   bgcolor="#FFFFFF">&nbsp;</td>
                        </tr>
                        
                        <tr>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right" >Misc Charges </div></td>
                          <td align="left" valign="top"   bgcolor="#FFFFFF"><label>
                            <input name="misc_copay" type="text" id="misc_copay" style="text-transform:uppercase;" size="10"  onKeyDown="return numbervaild(event)" value="<?php echo $misc_copay;?>">
                          </label></td>
                          <!--<td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right" >Visit IP Limit </div></td>-->
                          <td align="left" valign="top"   bgcolor="#FFFFFF">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right" >Ambulance Charges </div></td>
                          <td align="left" valign="top"   bgcolor="#FFFFFF"><label>
                            <input name="ambulance_copay" type="text" id="ambulance_copay" style="text-transform:uppercase;" size="10"  onKeyDown="return numbervaild(event)" value="<?php echo $ambulance_copay;?>">
                          </label></td>
                          <!--<td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right" >Visit IP Limit </div></td>-->
                          <td align="left" valign="top"   bgcolor="#FFFFFF">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right" >Mortuary Charges </div></td>
                          <td align="left" valign="top"   bgcolor="#FFFFFF"><label>
                            <input name="mortuary_copay" type="text" id="mortuary_copay" style="text-transform:uppercase;" size="10"  onKeyDown="return numbervaild(event)" value="<?php echo $mortuary_copay;?>">
                          </label></td>
                          <!--<td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right" >Visit IP Limit </div></td>-->
                          <td align="left" valign="top"   bgcolor="#FFFFFF">&nbsp;</td>
                        </tr>
                       <?php /*?> <tr>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Plan Start Date </div></td>
                          <td align="left" valign="top"  colspan="3" bgcolor="#FFFFFF"><input type="text" name="planstartdate" id="planstartdate" value="<?php //echo $registrationdate; ?>"  onFocus="return funcexpiry();" readonly>
                            <strong><span class="bodytext312"> <img src="images2/cal.gif" onClick="javascript:NewCssCal('planstartdate')" style="cursor:pointer"/></span></strong></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Plan Validity End </div></td>
                          <td align="left" valign="top" colspan="3" bgcolor="#FFFFFF"><input type="text" name="planexpirydate" id="planexpirydate" value="<?php //echo $registrationdate; ?>"  onFocus="return funcexpiry();" readonly>
                            <strong><span class="bodytext312"> <img src="images2/cal.gif" onClick="javascript:NewCssCal('planexpirydate')" style="cursor:pointer"/></span></strong></td>
                        </tr><?php */?>
                        <!--<tr>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Plan Status </div></td>
                          <td align="left" valign="top" colspan="3"  bgcolor="#FFFFFF"><label>
                            <select name="recordstatus" id="recordstatus">
                              <option value="" selected="selected">Select Account Status</option>
                              <option value="ACTIVE">ACTIVE</option>
                              <option value="DELETED">INACTIVE</option>
                            </select>
                          </label></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right" >Exclusions </div></td>
                          <td align="left" valign="top"  colspan="3" bgcolor="#FFFFFF"><label>
                            <textarea name="exclusions" id="exclusions" style="text-transform:uppercase;" rows="3"></textarea>
                          </label></td>
                        </tr>-->
                        <tr>
                          <td width="28%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                          <td align="left" valign="top" colspan="3"  bgcolor="#FFFFFF"><input type="hidden" name="frmflag" value="addnew" />
                            <input type="hidden" name="frmflag1" value="frmflag1" />
                            <input type="submit" name="Submit" value="Submit" /></td>
                        </tr>
                        <tr>
                          <td align="middle" colspan="2" >&nbsp;</td>
                        </tr>
                      </tbody>
                    </table></td>
                  </tr>
                </tbody>
                </table>
                
                <table width="800" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    
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

