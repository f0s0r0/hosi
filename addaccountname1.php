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
$dummy = '';

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{

	$accountname = $_REQUEST["accountname"];
	$accountname = strtoupper($accountname);
	$accountname = trim($accountname);
	$length=strlen($accountname);
	$paymenttype = $_REQUEST['paymenttype'];
	$subtype = $_REQUEST['subtype'];
	$expirydate = $_REQUEST['expirydate'];
	$recordstatus = $_REQUEST['recordstatus'];
	$address = $_REQUEST['address'];
	$accountsmaintype = $_REQUEST['accountsmaintype'];
	$accountssub = $_REQUEST['accountssub'];
	$openingbalancecredit = $_REQUEST['openingbalancecredit'];
	$openingbalancedebit = $_REQUEST['openingbalancedebit'];
	$id = $_REQUEST['id'];
	$contact = $_REQUEST['contact'];
	$locationcode = $_REQUEST['location'];
	$is_subtype = isset($_REQUEST['is_subtype']) ? $_REQUEST['is_subtype'] : "";
	
	$query8 = "select * from master_location where locationcode = '$locationcode'";
	$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
	$res8 = mysql_fetch_array($exec8);
	$locationname = $res8['locationname'];
	
	//echo $length;
	if ($length<=100)
	{
	$query2 = "select * from master_accountname where (accountname = '$accountname' or id = '$id')";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	$res2 = mysql_num_rows($exec2);
	if ($res2 == 0)
	{
		$query1 = "insert into master_accountname (accountname,recordstatus, paymenttype, subtype, expirydate, ipaddress, recorddate, username,address,accountsmain,accountssub,openingbalancecredit,openingbalancedebit,id, contact,locationcode,locationname,is_subtype) 
		values ('$accountname', '$recordstatus','$paymenttype', '$subtype', '$expirydate','$ipaddress', '$updatedatetime', '$username','$address','$accountsmaintype','$accountssub','$openingbalancecredit','$openingbalancedebit','$id','$contact','$locationcode','$locationname','$is_subtype')";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$errmsg = "Success. New Account Name Updated.";
		$bgcolorcode = 'success';
		
	}
	//exit();
	else
	{
		$errmsg = "Failed. Account Name or ID Already Exists.";
		$bgcolorcode = 'failed';
	}
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
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />

<style type="text/css">

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}

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
<script src="js/autoaccountanumsearch.js"></script>

<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
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
	if(document.getElementById("accountsmaintype").value=="<?php echo $res12accountsmainanum; ?>")
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

function funcaccountsearch()
{
	var serialno = $("#serialno").val();
	var accountsearch = $("#accountsearch").val();
	var sortfiled='';
	var sortfunc='';
	if(accountsearch=='')
	{
		alert('Enter The Account Name');
		return false;
	}
	var dataString = 'serialno='+serialno+'&&action=searchcoafunction&&textid='+sortfiled+'&&sortfunc='+sortfunc+'&&accountsearch='+accountsearch;
	
	$.ajax({
		type: "POST",
		url: "policyaccountupdateajaxphp.php",
		data: dataString,
		cache: true,
		//delay:100,
		success: function(html){
		//alert(html);
			$("#insertchartofaccounts").empty();
			$("#insertchartofaccounts").append(html);
			$("#hiddenaccountsearch").val('Searched');
			
		}
	});
}
$(window).scroll(function() {
	   if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
		  // alert("near bottom!");
		 // alert($(window).scrollTop());
		  //alert($(window).height());
		  //alert($(document).height());
		   var hiddenaccountsearch = $("#hiddenaccountsearch").val();
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
			if(hiddenaccountsearch=='')
			{
			   if(scrollfunc=='getdata')
			   {
					var serialno = $("#serialno").val();
					
					var dataString = 'serialno='+serialno+'&&action=scrollcoafunction&&textid='+sortfiled+'&&sortfunc='+sortfunc;
					
					$.ajax({
						type: "POST",
						url: "policyaccountupdateajaxphp.php",
						data: dataString,
						cache: true,
						//delay:100,
						success: function(html){
						//alert(html);
							serialno = parseFloat(serialno)+25;
							$("#insertchartofaccounts").append(html);
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
              <td><form name="form1" id="form1" method="post" action="addaccountname1.php" onSubmit="return Process()">
                  <table width="956" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="4" bgcolor="#CCCCCC" class="bodytext3"><strong>Account Name Master - Add New </strong></td>
                      </tr>
					  <tr>
                        <td colspan="4" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#AAFF00'; } else if ($bgcolorcode == 'failed') { echo 'red'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Location</div></td>
                        <td width="28%" align="left" valign="top"  bgcolor="#FFFFFF"><strong>
						<select name="location" id="location">
						<option value="" selected="selected">Select Location</option>
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
                        <td width="28%" align="left" valign="top"  bgcolor="#FFFFFF"><strong>
						<select name="accountsmaintype" id="accountsmaintype" onChange="return funcAccountsMainTypeChange1()">
						<option value="" selected="selected">Select Type</option>
						<?php
						$query5 = "select * from master_accountsmain where recordstatus = '' order by accountsmain";
						$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
						while ($res5 = mysql_fetch_array($exec5))
						{
						$res5accountsmainanum = $res5["auto_number"];
						$res5accountsmain = $res5["accountsmain"];
						?>
						<option value="<?php echo $res5accountsmainanum; ?>"><?php echo $res5accountsmain; ?></option>
						<?php
						}
						?>
						</select>
                        </strong></td>
                        <td width="20%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Main Type </div></td>
                        <td width="23%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><strong>
						<select name="paymenttype" id="paymenttype" onChange="return funcPaymentTypeChange1()">
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
                        </strong></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Account Sub Type </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF"><strong>
                          <select name="accountssub" id="accountssub" onChange="return accountsearchanum()">
                            <option value="" selected="selected">Select Sub Type</option>
                          </select>
                        </strong></td>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Select Sub Type </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><strong>
                          <select name="subtype" id="subtype">
                            <option value="" selected="selected">Select Sub Type</option>
                          </select>
                        </strong></td>
                      </tr>
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">ID </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="id" id="id" style="text-transform:uppercase" readonly size="40" /></td>
                        <td align="right" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Opg.Bal Dr</td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF"><input type="text" name="openingbalancedebit" id="openingbalancedebit"></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Add New Account Name </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="accountname" id="accountname" style="text-transform:uppercase" size="40" /></td>
                        <td align="right" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Opg.Bal Cr</td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><input type="text" name="openingbalancecredit" id="openingbalancecredit"></td>
                      </tr>
                      
                      <tr>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Account Status </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF"><label>
                          <select name="recordstatus" id="recordstatus" style="text-transform:uppercase">
						  <option value="" selected="selected">Select Account Status</option>
                            <option value="ACTIVE">ACTIVE</option>
                            <option value="DELETED">INACTIVE</option>
                          </select>
                        </label></td>
                        <td align="right" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Receivable Account</td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><input type="checkbox" name="is_subtype" id="is_subtype" value="1"></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Account Validity End </div></td>
                        <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
                          <input type="text" name="expirydate" id="expirydate" value="<?php echo "2015-01-01"; ?>"   onFocus="return funcexpiry();" readonly  >
						   <strong><span class="bodytext312"> <img src="images2/cal.gif" onClick="javascript:NewCssCal('expirydate')" style="cursor:pointer"/> </span></strong></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Address </div></td>
                        <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
						<textarea name="address" id="address" style="text-transform:uppercase" rows="3" cols="20"></textarea></td>
                      </tr>
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Contact </div></td>
                        <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="text" name="contact" id="contact" style="border: 1px solid #001E6A;text-transform:uppercase" size="30"></td>
                      </tr>
                      <tr>
                        <td width="29%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="hidden" name="frmflag" value="addnew" />
                            <input type="hidden" name="frmflag1" value="frmflag1" />
                            <input type="hidden" name="scrollfunc" id="scrollfunc" value="getdata">
                            <input type="hidden" name="serialno" id="serialno" value="50">
                          <input type="submit" name="Submit" value="Submit" /></td>
                      </tr>
                      <tr>
                        <td align="middle" colspan="4" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                <table width="955" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="11" bgcolor="#CCCCCC" class="bodytext3"><strong>Chart of Accounts - List </strong></td>
                      </tr>
                      <tr bgcolor="#011E6A">
                        <td colspan="11" bgcolor="#CCCCCC" class="bodytext3"><strong><input type="text" id="accountsearch" name="accountsearch" value="" size="30" placeholder="Account Search">
                        <input type="hidden" id="hiddenaccountsearch" name="hiddenaccountsearch" value="">
                        <input type="button" id="accountsearchbutton" name="accountsearchbutton" value="Search" size="30" placeholder="Account Search" onClick="return funcaccountsearch();"></strong></td>
                      </tr>
                        <tr>
                        <td align="left" valign="top"  class="bodytext3">&nbsp;</td>
                        <td width="6%" align="left" valign="top"  class="bodytext3"><strong>Code</strong></td>
                        <td width="13%" align="left" valign="top"  class="bodytext3"><strong>Accounts Main</strong></td>
                        <td width="7%" align="left" valign="top"  class="bodytext3"><strong>Code</strong></td>
                        <td width="13%" align="left" valign="top"  class="bodytext3"><strong>Accounts Sub</strong></td>
                        <td width="10%" align="left" valign="top"  class="bodytext3"><strong>ID</strong></td>
						 <td align="left" valign="top"  class="bodytext3"><strong>Account Name </strong></td>
                        <td width="13%" align="left" valign="top"  class="bodytext3"><span class="bodytext32"><strong>Main Type </strong></span></td>
                        <td align="left" valign="top"  class="bodytext3"><strong>Sub Type </strong></td>
                       
                        
                        <td align="left" valign="top"  class="bodytext3"><strong>Edit</strong></td>
                        </tr>
                        <tbody id='insertchartofaccounts'>
                    <?php
	    $query1 = "select * from master_accountname where recordstatus <> 'deleted' order by accountssub limit 50";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		while ($res1 = mysql_fetch_array($exec1))
		{
		$auto_number = $res1['auto_number'];
		$accountname = $res1["accountname"];
		$auto_number = $res1["auto_number"];
		$paymenttypeanum = $res1['paymenttype'];
		$subtypeanum = $res1['subtype'];
		$expirydate = $res1['expirydate'];
		$accountsmain = $res1['accountsmain'];
		$accountssub = $res1['accountssub'];
		$id = $res1['id'];
		
		$query6 = "select * from master_accountsmain where auto_number = '$accountsmain' and recordstatus <> 'deleted'";
		$exec6 = mysql_query($query6) or die(mysql_error());
		$res6 = mysql_fetch_array($exec6);
		$maincode = $res6['id'];
		$accountsmainname = $res6['accountsmain'];
		
		$query8 = "select * from master_accountssub where auto_number = '$accountssub' and recordstatus <> 'deleted'";
		$exec8 = mysql_query($query8) or die(mysql_error());
		$res8 = mysql_fetch_array($exec8);
		$subcode = $res8['id'];
		$accountssubname = $res8['accountssub'];
		
		//$defaultstatus = $res1["defaultstatus"];
		
		$query2 = "select * from master_paymenttype where auto_number = '$paymenttypeanum'";
		$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		$res2 = mysql_fetch_array($exec2);
		$paymenttype = $res2['paymenttype'];
		
		$query3 = "select * from master_subtype where auto_number = '$subtypeanum'";
		$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
		$res3 = mysql_fetch_array($exec3);
		$subtype = $res3['subtype'];
	
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
                        <td width="4%" align="left" valign="top"  class="bodytext3">
						<div align="center">
						<a href="addaccountname1.php?st=del&&anum=<?php echo $auto_number; ?>" onClick="return funcDeleteAccountName1('<?php echo $accountname;?>')">
						<img src="images/b_drop.png" width="16" height="16" border="0" />						</a>						</div>						</td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $maincode; ?></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $accountsmainname; ?></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $subcode; ?></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $accountssubname; ?></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $id; ?></td>
						 <td width="17%" align="left" valign="top"  class="bodytext3"><span class="bodytext32"><?php echo $accountname; ?></span></td>
                        <td align="left" valign="top"  class="bodytext3"><span class="bodytext32"><?php echo $paymenttype; ?></span></td>
                        <td width="12%" align="left" valign="top"  class="bodytext3"><span class="bodytext32"><?php echo $subtype; ?></span></td>
                       
                        
                        <td width="5%" align="left" valign="top"  class="bodytext3">
						<a href="editaccountname1.php?st=edit&&anum=<?php echo $auto_number; ?>" style="text-decoration:none">Edit</a>						</td>
                      </tr>
                      <?php
		}
		?>
        </tbody>
                      <tr>
                        <td align="middle" colspan="11" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                <table width="958" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="6" bgcolor="#CCCCCC" class="bodytext3"><strong>Account Name Master - Deleted </strong></td>
                      </tr>
                      <?php
		
	    $query1 = "select * from master_accountname where recordstatus = 'deleted' order by paymenttype ";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		while ($res1 = mysql_fetch_array($exec1))
		{
		$accountname = $res1["accountname"];
		$auto_number = $res1["auto_number"];
		$paymenttypeanum = $res1['paymenttype'];
		$subtypeanum = $res1['subtype'];
		$expirydate = $res1['expirydate'];
		
		$query2 = "select * from master_paymenttype where auto_number = '$paymenttypeanum'";
		$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		$res2 = mysql_fetch_array($exec2);
		$paymenttype = $res2['paymenttype'];
		
		$query3 = "select * from master_subtype where auto_number = '$subtypeanum'";
		$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
		$res3 = mysql_fetch_array($exec3);
		$subtype = $res3['subtype'];

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
						<a href="addaccountname1.php?st=activate&&anum=<?php echo $auto_number; ?>" class="bodytext3">
                          <div align="center" class="bodytext3">Activate</div>
                        </a></td>
                        <td width="17%" align="left" valign="top"  class="bodytext3"><span class="bodytext32"><?php echo $paymenttype; ?></span></td>
                        <td width="23%" align="left" valign="top"  class="bodytext3"><span class="bodytext32"><?php echo $accountname; ?></span></td>
                        <td width="22%" align="left" valign="top"  class="bodytext3"><span class="bodytext32"><?php echo $subtype; ?></span></td>
                        <td width="21%" align="left" valign="top"  class="bodytext3"><span class="bodytext32"><?php echo $expirydate; ?></span></td>
                        <td width="9%" align="left" valign="top"  class="bodytext3"><span class="bodytext32">
						<a href="editaccountname1.php" style="text-decoration:none">Edit</a>
						</span></td>
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

