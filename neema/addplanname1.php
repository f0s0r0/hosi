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

	$planname = $_REQUEST["planname"];
	$planname = strtoupper($planname);
	$planname = trim($planname);
	$length=strlen($planname);
	//echo $length;
	
	$planstatus = $_REQUEST["planstatus"];
	$planstatus = strtoupper($planstatus);
	$planstatus = trim($planstatus);
	$length=strlen($planstatus);

	$maintype = $_REQUEST["paymenttype"];
	$subtype = $_REQUEST["subtype"];
	$accountname = $_REQUEST["accountname"];
	$plancondition = $_REQUEST["plancondition"];
	$planfixedamount = $_REQUEST["planfixedamount"];
	$planpercentage = $_REQUEST["planpercentage"];
	$smart = $_REQUEST["smart"];
	$overalllimitop=isset($_REQUEST["overalllimitop"])?$_REQUEST["overalllimitop"]:'';
	$overalllimitip=isset($_REQUEST["overalllimitip"])?$_REQUEST["overalllimitip"]:'';
	$opvisitlimit=isset($_REQUEST["opvisitlimit"])?$_REQUEST["opvisitlimit"]:'';
	$ipvisitlimit=isset($_REQUEST["ipvisitlimit"])?$_REQUEST["ipvisitlimit"]:'';
	$recordstatus=$_REQUEST["recordstatus"];
	$planstartdate = $_REQUEST["planstartdate"];
	$planexpirydate = $_REQUEST["planexpirydate"];
	$exclusions = $_REQUEST['exclusions'];
	
	$forall = isset($_REQUEST['forall'])?$_REQUEST['forall']:'';
	
	if ($length<=255)
	{
	$query2 = "select * from master_planname where planname = '$planname'";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	$res2 = mysql_num_rows($exec2);
	
		$query1 = "insert into master_planname (maintype, subtype, accountname, planname, planstatus, plancondition, planfixedamount,planpercentage,
		overalllimitop, overalllimitip, opvisitlimit,ipvisitlimit ,smartap,recordstatus,ipaddress, recorddate, username, planstartdate, planexpirydate,exclusions,forall) 
		values ('$maintype', '$subtype', '$accountname', '$planname', '$planstatus', '$plancondition', '$planfixedamount',  '$planpercentage', 
		'$overalllimitop','$overalllimitip', '$opvisitlimit','$ipvisitlimit', '$smart', '$recordstatus','$ipaddress', '$updatedatetime', '$username', '".$planstartdate."', '$planexpirydate','$exclusions','".$forall."')";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$errmsg = "Success. New Plan Name Updated.";
		$bgcolorcode = 'success';
		
	header("location:addplanname1.php");
	exit();
	
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
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<style type="text/css">

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}

</style>
</head>

<script language="javascript">

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

function funcplansearch()
{
	var serialno = $("#serialno").val();
	var plansearch = $("#plansearch").val();
	var sortfiled='';
	var sortfunc='';
	if(plansearch=='')
	{
		alert('Enter The Plan Name');
		return false;
	}
	var dataString = 'serialno='+serialno+'&&action=searchplanfunction&&textid='+sortfiled+'&&sortfunc='+sortfunc+'&&plansearch='+plansearch;
	
	$.ajax({
		type: "POST",
		url: "policyaccountupdateajaxphp.php",
		data: dataString,
		cache: true,
		//delay:100,
		success: function(html){
		//alert(html);
			$("#insertplan").empty();
			$("#insertplan").append(html);
			$("#hiddenplansearch").val('Searched');
			
		}
	});
}
$(window).scroll(function() {
	   if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
		  // alert("near bottom!");
		 // alert($(window).scrollTop());
		  //alert($(window).height());
		  //alert($(document).height());
		   var hiddenplansearch = $("#hiddenplansearch").val();
		   var scrollfunc = $("#scrollfunc").val();
			$("#scrollfunc").val('');
			 var sortfiled = '';
			 var sortfunc = '';
			if(sortfunc=='asc')
			{
				sortfunc='desc'
			}
			else
			{
				sortfunc='asc'
			}
			if(hiddenplansearch=='')
			{
			   if(scrollfunc=='getdata')
			   {
					var serialno = $("#serialno").val();
					
					var dataString = 'serialno='+serialno+'&&action=scrollplanfunction&&textid='+sortfiled+'&&sortfunc='+sortfunc;
					
					$.ajax({
						type: "POST",
						url: "policyaccountupdateajaxphp.php",
						data: dataString,
						cache: true,
						//delay:100,
						success: function(html){
						//alert(html);
							serialno = parseFloat(serialno)+25;
							$("#insertplan").append(html);
							$("#serialno").val(serialno);
							$("#scrollfunc").val('getdata');
							
						}
					});
			   }
			}
		   
	   }
});
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
              <td><form name="form1" id="form1" method="post" action="addplanname1.php" onSubmit="return addplanname1process1()">
                <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                <tbody>
                  <tr>
                    <td align="left" colspan="3" valign="top"  bgcolor="#FFFFFF"><table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber" style="border-collapse: collapse">
                      <tbody>
                        <tr bgcolor="#011E6A">
                          <td colspan="4" bgcolor="#CCCCCC" class="bodytext3"><strong>Plan Name Master - Add New </strong></td>
                        </tr>
                        <tr>
                          <td colspan="4" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Main Type </div></td>
                          <td align="left" colspan="3" valign="top"  bgcolor="#FFFFFF"><select name="paymenttype" id="paymenttype" onChange="return funcPaymentTypeChange1();">
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
                          </select></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Sub Type </div></td>
                          <td align="left" colspan="3" valign="top"  bgcolor="#FFFFFF"><select name="subtype" id="subtype" onChange="return funcSubTypeChange1()">
                            <option value="" selected="selected">Select Subtype</option>
                          </select></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Account Name </div></td>
                          <td align="left" valign="top" colspan="3"  bgcolor="#FFFFFF"><strong>
                            <select name="accountname" id="accountname">
                              <option value="" selected="selected">Select Account Name</option>
                            </select>
                          </strong></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Add Plan Name </div></td>
                          <td align="left" valign="top" colspan="3" bgcolor="#FFFFFF"><input name="planname" id="planname" style="text-transform:uppercase;" size="40"  /></td>
                          <input type="hidden" name="plancondition" id="plancondition" value="">
                        </tr>
                        <tr>
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
                          <td align="left" valign="top"   bgcolor="#FFFFFF"><input name="planfixedamount" id="planfixedamount" style="text-transform:uppercase;" size="10"  onKeyDown="return numbervaild(event)" onFocus="return copay(this.id)"/></td>						<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Smart Applicable </div></td>
                          <td align="left" valign="top"   bgcolor="#FFFFFF"> <input type="checkbox" name="smart" value="1"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Copay Percentage </div></td>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><input name="planpercentage" id="planpercentage" style="text-transform:uppercase;" size="10"  onKeyDown="return numbervaild(event)" onFocus="return copay(this.id)"/></td>
                           <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">All</div></td>
                          <td align="left" valign="top"   bgcolor="#FFFFFF">
                            <input type="checkbox" name="forall" value="yes"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Overall OP Limit </div></td>
                          <td align="left" valign="top"  bgcolor="#FFFFFF"><label>
                            <input name="overalllimitop" type="text" id="overalllimitop" style="text-transform:uppercase;" size="10" onKeyDown="return numbervaild(event)">
                          </label></td>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Overall IP Limit </div></td>
                          <td align="left" valign="top"  bgcolor="#FFFFFF"><label>
                            <input name="overalllimitip" type="text" id="overalllimitip" style="text-transform:uppercase;" size="10"  onKeyDown="return numbervaild(event)">
                          </label></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right" >Visit OP Limit </div></td>
                          <td align="left" valign="top"   bgcolor="#FFFFFF"><label>
                            <input name="opvisitlimit" type="text" id="opvisitlimit" style="text-transform:uppercase;" size="10"  onKeyDown="return numbervaild(event)">
                          </label></td>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right" >Visit IP Limit </div></td>
                          <td align="left" valign="top"   bgcolor="#FFFFFF"><label>
                            <input name="ipvisitlimit" type="text" id="ipvisitlimit" style="text-transform:uppercase;" size="10"  onKeyDown="return numbervaild(event)">
                          </label></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Plan Start Date </div></td>
                          <td align="left" valign="top"  colspan="3" bgcolor="#FFFFFF"><input type="text" name="planstartdate" id="planstartdate" value="<?php //echo $registrationdate; ?>"  onFocus="return funcexpiry();" readonly>
                            <strong><span class="bodytext312"> <img src="images2/cal.gif" onClick="javascript:NewCssCal('planstartdate')" style="cursor:pointer"/></span></strong></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Plan Validity End </div></td>
                          <td align="left" valign="top" colspan="3" bgcolor="#FFFFFF"><input type="text" name="planexpirydate" id="planexpirydate" value="<?php //echo $registrationdate; ?>"  onFocus="return funcexpiry();" readonly>
                            <strong><span class="bodytext312"> <img src="images2/cal.gif" onClick="javascript:NewCssCal('planexpirydate')" style="cursor:pointer"/></span></strong></td>
                        </tr>
                        <tr>
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
                        </tr>
                        <tr>
                          <td width="42%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                          <td width="58%" align="left" valign="top" colspan="3"  bgcolor="#FFFFFF"><input type="hidden" name="frmflag" value="addnew" />
                            <input type="hidden" name="frmflag1" value="frmflag1" />
                            <input type="hidden" name="scrollfunc" id="scrollfunc" value="getdata">
                            <input type="hidden" name="serialno" id="serialno" value="50">
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
                    
                    <tr bgcolor="#011E6A">
                        <td colspan="11" bgcolor="#CCCCCC" class="bodytext3"><strong><input type="text" id="plansearch" name="plansearch" value="" size="30" placeholder="Plan Search">
                        <input type="hidden" id="hiddenplansearch" name="hiddenplansearch" value="">
                        <input type="button" id="plansearchbutton" name="plansearchbutton" value="Search" size="30" placeholder="Plan Search" onClick="return funcplansearch();"></strong></td>
                      </tr>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Plan Name Master - Existing List </strong></td>
                        <td width="22%" bgcolor="#CCCCCC" class="bodytext3"><strong>Account</strong></td>
                        <td bgcolor="#CCCCCC" class="bodytext3"><strong>Fixed Amt </strong></td>
                        <td width="12%" bgcolor="#CCCCCC" class="bodytext3"><strong>Percentage</strong></td>
                        <td width="12%" bgcolor="#CCCCCC" class="bodytext3"><strong>Validity End </strong></td>
                        <td width="13%" bgcolor="#CCCCCC" class="bodytext3"><strong>Edit</strong></td>
                      </tr>
                      <tbody id='insertplan'>
                      <?php
	    $query1 = "select * from master_planname where recordstatus <> 'deleted' order by planname limit 50";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		while ($res1 = mysql_fetch_array($exec1))
		{
		$planname = $res1["planname"];
		$accountnameanum = $res1["accountname"];
		$plancondition = $res1["plancondition"];
		$planfixedamount = $res1["planfixedamount"];
		$planpercentage = $res1["planpercentage"];
		$auto_number = $res1["auto_number"];
		//$defaultstatus = $res1["defaultstatus"];
		$planexpirydate = $res1['planexpirydate'];
		
		$query2 = "select * from master_accountname where auto_number = '$accountnameanum'";
		$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		$res2 = mysql_fetch_array($exec2);
		$accountname = $res2['accountname'];
		
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
                        <td width="6%" align="left" valign="top"  class="bodytext3"><div align="center"><a href="addplanname1.php?st=del&&anum=<?php echo $auto_number; ?>"><img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>
                        <td width="34%" align="left" valign="top"  class="bodytext3"><?php echo $planname; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $accountname; ?></td>
                        <td width="13%" align="left" valign="top"  class="bodytext3"><?php echo $planfixedamount; ?></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $planpercentage; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $planexpirydate; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"> <a href="editplanname1.php?st=edit&&anum=<?php echo $auto_number; ?>" style="text-decoration:none">Edit</a></td>
        </tr>
                      <?php
		}
		?>
        </tbody>
                      <tr>
                        <td align="middle" colspan="7" >&nbsp;</td>
                      </tr>
               
                  </table>
                <table width="800" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Plan Name Master - Deleted </strong></td>
                        <td bgcolor="#CCCCCC" class="bodytext3"><strong>Account</strong></td>
                        <td bgcolor="#CCCCCC" class="bodytext3"><strong>Fixed Amt </strong></td>
                        <td bgcolor="#CCCCCC" class="bodytext3"><strong>Percentage</strong></td>
                        <td bgcolor="#CCCCCC" class="bodytext3"><strong>Validity End </strong></td>
                      </tr>
                      <?php
		
	    $query1 = "select * from master_planname where recordstatus = 'deleted' order by planname ";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		while ($res1 = mysql_fetch_array($exec1))
		{
		$planname = $res1["planname"];
		$accountnameanum = $res1["accountname"];
		$plancondition = $res1["plancondition"];
		$planfixedamount = $res1["planfixedamount"];
		$planpercentage = $res1["planpercentage"];
		$auto_number = $res1["auto_number"];
		$planexpirydate = $res1['planexpirydate'];
		
		$query2 = "select * from master_accountname where auto_number = '$accountnameanum'";
		$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		$res2 = mysql_fetch_array($exec2);
		$accountname = $res2['accountname'];
		
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
						<a href="addplanname1.php?st=activate&&anum=<?php echo $auto_number; ?>" class="bodytext3">
                          <div align="center" class="bodytext3">Activate</div>
                        </a></td>
                        <td width="29%" align="left" valign="top"  class="bodytext3"><?php echo $planname; ?></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $accountname; ?></td>
                        <td width="14%" align="left" valign="top"  class="bodytext3"><?php echo $planfixedamount; ?></td>
                        <td width="14%" align="left" valign="top"  class="bodytext3"><?php echo $planpercentage; ?></td>
                        <td width="14%" align="left" valign="top"  class="bodytext3"><?php echo $planexpirydate; ?></td>
        </tr>
                      <?php
		}
		?>
                      <tr>
                        <td align="middle" colspan="6" >&nbsp;</td>
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

