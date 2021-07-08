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

include ("autocompletebuild_payroll.php");

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{

	$componentname = $_REQUEST["componentname"];
	$componentname = strtoupper($componentname);
	$componentname = trim($componentname);
	$typeexplode = $_REQUEST['type'];
	$typesplit = explode('||',$typeexplode);
	$typecode = $typesplit[0];
	$type = $typesplit[1];
	$amounttype = $_REQUEST['amounttype'];
	if(isset($_REQUEST['monthly']))
	{
		$monthly = $_REQUEST['monthly'];
	}
	else
	{
		$monthly = 'No';
	}
	if(isset($_REQUEST['notional']))
	{
		$notional = $_REQUEST['notional'];
	}
	else
	{
		$notional = 'No';
	}
	$deductearning = $_REQUEST['deductearning'];
	$maxvalue = $_REQUEST['maxvalue'];
	
	$searchsuppliername = $_REQUEST['searchsuppliername'];
	$searchsuppliercode = $_REQUEST['searchsuppliercode'];
	
	if(isset($_REQUEST['formula'])) { $formula = $_REQUEST['formula']; } else{ $formula = ''; }
	if($amounttype != 'Percent')
	{
		$formula = '';
	}
	$length=strlen($componentname);
	if(isset($_REQUEST['taxinclude'])) { $taxinclude = $_REQUEST['taxinclude']; } else { $taxinclude = ''; }
	//echo $length;
	if ($length<=100)
	{
	$query2 = "select * from master_payrollcomponent where componentname = '$componentname'";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	$res2 = mysql_num_rows($exec2);
	if ($res2 == 0)
	{
		$query1 = "insert into master_payrollcomponent (componentname, typecode, type, monthly, amounttype, ipaddress, updatetime, username, formula, notional,deductearning , notexceed, taxinclude, ledgercode, ledger) 
		values ('$componentname', '$typecode', '$type', '$monthly', '$amounttype', '$ipaddress', '$updatedatetime', '$username', '$formula', '$notional', '$deductearning', '$maxvalue', '$taxinclude','$searchsuppliercode','$searchsuppliername')";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$insertid = mysql_insert_id();
		
		$query7 = "ALTER TABLE `payroll_assign` ADD `$insertid` DECIMAL(13,2) NOT NULL";  
		$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
		
		$query72 = "ALTER TABLE `details_employeepayroll` ADD `$insertid` DECIMAL(13,2) NOT NULL";  
		$exec72 = mysql_query($query72) or die ("Error in Query72".mysql_error());
		
		$errmsg = "Success. New Payroll Component Added.";
		$bgcolorcode = 'success';
		
		header("location:addpayrollcomponent1.php?st=success");
		
	}
	//exit();
	else
	{
		$errmsg = "Failed. Payroll Component Already Exists.";
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
	$query6 = "select * from payroll_assign where componentanum = '$delanum' and status <> 'deleted'";
	$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
	$res6 = mysql_fetch_array($exec6);
	$res6componentanum = $res6['componentanum'];
	if($res6componentanum == '')
	{
		$query3 = "update master_payrollcomponent set recordstatus = 'deleted' where auto_number = '$delanum'";
		$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	}
	else
	{
		$errmsg = "Failed. Payroll Component already Assigned to Employee.";
		$bgcolorcode = 'failed';
	}
}
if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_payrollcomponent set recordstatus = '' where auto_number = '$delanum'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
}
?>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" /> 
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<link href="css/autocomplete.css" rel="stylesheet">
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
	if (document.form1.componentname.value == "")
	{
		alert ("Pleae Enter Componentname.");
		document.form1.componentname.focus();
		return false;
	}
	if (document.form1.type.value == "")
	{
		alert ("Pleae Select Type.");
		document.form1.type.focus();
		return false;
	}
	if(document.getElementById("amounttype").value == "")
	{
		alert("Please select Amount Type");
		document.getElementById("amounttype").focus();
		return false;
	}
	if(document.getElementById("amounttype").value == "Percent")
	{
		if(document.getElementById("formula").value == "")
		{
			alert("Please select Percent From");
			document.getElementById("formula").focus();
			return false;
		}
	}
}

function SelectRate()
{
	var chk1 = document.getElementById("monthly").checked;
	if(chk1 == true)
	{
		document.getElementById("amounttype").value = 'Rate';
	}
	else
	{
		document.getElementById("amounttype").value = '';
	}
}
/*function funcDeletePaymentType(varPaymentTypeAutoNumber)
{
    var varPaymentTypeAutoNumber = varPaymentTypeAutoNumber;
	var fRet;
	fRet = confirm('Are you sure want to delete this account name '+varPaymentTypeAutoNumber+'?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("Payment Type Entry Delete Completed.");
		//return false;
	}
	if (fRet == false)
	{
		alert ("Payment Type Entry Delete Not Completed.");
		return false;
	}
	//return false;

}*/
function HideFormula1()
{
	document.getElementById("formulatr").style.display = "none";
	document.getElementById("formulatr1").style.display = "none";
	document.getElementById("deduct1").style.display = "none";
	document.getElementById("earn1").style.display = "none";
}

function Formula1()
{
	if(document.getElementById("amounttype").value == "Percent")
	{
		document.getElementById("formulatr").style.display = "";
		document.getElementById("formulatr1").style.display = "";
	}
	else
	{
		document.getElementById("formulatr").style.display = "none";
		document.getElementById("formulatr1").style.display = "none";
	}
}

function ShowDeduct()
{
	if(document.getElementById("type").value == "20||Deduction")
	{
		document.getElementById("deduct1").style.display = "";
	}
	else
	{
		document.getElementById("deduct1").style.display = "none";
	}
	if(document.getElementById("type").value == "10||Earning")
	{
		document.getElementById("earn1").style.display = "";
	}
	else
	{
		document.getElementById("earn1").style.display = "none";
	}
	
}

function TotalDeduction()
{

}

$(document).ready(function(){
	$('.earningledger').autocomplete({
	source:"ajaxpayrollledger.php?type=30",
	//alert(source);
	minLength:0,
	html: true, 
		select: function(event,ui){
			var code = ui.item.id;
			var billwise = ui.item.billwise;
			if(code != '') {
				var textid = $(this).attr('id');
				$("#searchsuppliercode").val(code);
			}
			},
    });
});	
</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        

<body onLoad="return HideFormula1()">
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#6487DC"><?php eval(base64_decode('IGluY2x1ZGUgKCJpbmNsdWRlcy9hbGVydG1lc3NhZ2VzMS5waHAiKTsg')); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#8CAAE6"><?php eval(base64_decode('IGluY2x1ZGUgKCJpbmNsdWRlcy90aXRsZTEucGhwIik7IA==')); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#E0E0E0"><?php eval(base64_decode('IGluY2x1ZGUgKCJpbmNsdWRlcy9tZW51MS5waHAiKTsg')); ?></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php eval(base64_decode('IC8vaW5jbHVkZSAoImluY2x1ZGVzL21lbnU0LnBocCIpOyA=')); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
            <tr>
              <td><form name="form1" id="form1" method="post" action="addpayrollcomponent1.php" onSubmit="return addward1process1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Payroll Component - Add New </strong></td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php  if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; }  ?>" class="bodytext3"><div align="left"><?php eval(base64_decode('IGVjaG8gJGVycm1zZzsg')); ?></div></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Add New Component </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="componentname" id="componentname" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" /></td>
                      </tr>
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Type </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="type" id="type" onChange="return ShowDeduct()" style="border: 1px solid #001E6A;" title="Earning or Deduction">
						<option value="">Select</option>
						<option value="10||Earning">Earning</option>
						<option value="20||Deduction">Deduction</option>
						</select></td>
                      </tr>
					   <tr id="deduct1">
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Deduct from Taxable Earnings </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="deductearning" id="deductearning" style="border: 1px solid #001E6A;" title="Deduct before PAYE Calculation">
						<option value="No">No</option>
						<option value="Yes">Yes</option>
						</select></td>
                      </tr>
                      <tr id="earn1">
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Include in Taxable Income </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="taxinclude" id="taxinclude" style="border: 1px solid #001E6A;" title="Include in Taxable Income">
						<option value="Yes">Yes</option>
                        <option value="No">No</option>
						</select></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right"> Notional  </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="notional" id="notional" style="border: 1px solid #001E6A;" title="If Yes include only for Tax calculation">
						<option value="No">No</option>
						<option value="Yes">Yes</option>
						</select></td>
                      </tr>
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Amount </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="amounttype" id="amounttype" style="border: 1px solid #001E6A;" onChange="return Formula1()" title="Fixed value or Percent">
						<option value="">Select</option>
						<option value="Fixed">Fixed</option>
						<option value="Percent">Percent</option>
						</select></td>
                      </tr>
					   <tr id="formulatr">
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">From </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="formula" id="formula" style="border: 1px solid #001E6A;" title="From BASIC or GROSS">
						<option value="">Select</option>
						<option value="1">BASIC</option>
						<option value="1+2">BASIC+HRA</option>
						<option value="Gross">TOTAL GROSS</option>
						</select></td>
                      </tr>
					  <tr id="formulatr1">
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Max Value</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="text" name="maxvalue" id="maxvalue" size="10" style="border: 1px solid #001E6A;" title="% amount should not exceed this value if not leave empty"></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Change value every month </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="monthly" id="monthly" style="border: 1px solid #001E6A;" title="Changes every Month">
						<option value="No">No</option>
						<option value="Yes">Yes</option>
						</select></td>
                      </tr>
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Ledger Name </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="text" class="earningledger" name="searchsuppliername" id="searchsuppliername" autocomplete="off" size="40" style="border: 1px solid #001E6A;" title="Account Ledger">
						<input type="hidden" name="searchsuppliercode" id="searchsuppliercode" value="">
						</td>
                      </tr>
                      <tr>
                        <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td width="70%" align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="hidden" name="frmflag" value="addnew" />
                            <input type="hidden" name="frmflag1" value="frmflag1" />
                          <input type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A" /></td>
                      </tr>
                      <tr>
                        <td align="middle" colspan="2" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                <table width="835" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="8" bgcolor="#CCCCCC" class="bodytext3"><strong> Payment Component - Existing List </strong></td>
                      </tr>
					  <tr>
					  <td align="left" class="bodytext3"><strong>Delete</strong></td>
					  <td align="left" class="bodytext3"><strong>Component Name</strong></td>
					  <td align="left" class="bodytext3"><strong>Type</strong></td>
					  <td align="left" class="bodytext3"><strong>Amount</strong></td>
					  <td align="left" class="bodytext3"><strong>Monthly</strong></td>
					  <td align="left" class="bodytext3"><strong>Notional</strong></td>
					  <td align="left" class="bodytext3"><strong>Ledgername</strong></td>
					  <td align="left" class="bodytext3"><strong>Edit</strong></td>
					  </tr>
                      <?php 
	    $query1 = "select * from master_payrollcomponent where recordstatus <> 'deleted' order by auto_number";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		while ($res1 = mysql_fetch_array($exec1))
		{
		$componentname = $res1["componentname"];
		$auto_number = $res1["auto_number"];
		$type = $res1['type'];
		$amounttype = $res1['amounttype'];
		$monthly = $res1['monthly'];
		$notional = $res1["notional"];
		$ledger = $res1['ledger'];

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
        <tr <?php eval(base64_decode('IGVjaG8gJGNvbG9yY29kZTsg')); ?>>
		<td width="5%" align="left" valign="top"  class="bodytext3">
		<div align="center">	
		<a href="addpayrollcomponent1.php?st=del&&anum=<?php eval(base64_decode('IGVjaG8gJGF1dG9fbnVtYmVyOyA=')); ?>"> 
		<img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>
		<td width="19%" align="left" valign="top"  class="bodytext3"><?php eval(base64_decode('IGVjaG8gJGNvbXBvbmVudG5hbWU7IA==')); ?> </td>
		<td width="9%" align="left" valign="top"  class="bodytext3"><?php eval(base64_decode('IGVjaG8gJHR5cGU7IA==')); ?> </td>
		<td width="9%" align="left" valign="top"  class="bodytext3"><?php eval(base64_decode('IGVjaG8gJGFtb3VudHR5cGU7IA==')); ?> </td>
		<td width="9%" align="left" valign="top"  class="bodytext3"><?php eval(base64_decode('IGVjaG8gJG1vbnRobHk7IA==')); ?> </td>
		<td width="9%" align="left" valign="top"  class="bodytext3"><?php eval(base64_decode('IGVjaG8gJG5vdGlvbmFsOyA=')); ?> </td>
		<td width="31%" align="left" valign="top"  class="bodytext3"><?php echo $ledger; ?> </td>
		<td width="9%" align="left" valign="top"  class="bodytext3">
		<a href="editpayrollcomponent1.php?st=edit&&anum=<?php eval(base64_decode('IGVjaG8gJGF1dG9fbnVtYmVyOyA=')); ?>" style="text-decoration:none">Edit</a>		</td>
	  </tr>
	  <?php 
		}
		 ?>
		  <tr>
			<td align="middle" colspan="3" >&nbsp;</td>
		  </tr>
		</tbody>
	  </table>
	<table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
		<tbody>
		  <tr bgcolor="#011E6A">
			<td colspan="6" bgcolor="#CCCCCC" class="bodytext3"><strong> Payroll Component - Deleted </strong></td>
		  </tr>
		  <tr>
		  <td align="left" class="bodytext3"><strong>Activate</strong></td>
		  <td align="left" class="bodytext3"><strong>Component Name</strong></td>
		  <td align="left" class="bodytext3"><strong>Type</strong></td>
		  <td align="left" class="bodytext3"><strong>Amount</strong></td>
		  <td align="left" class="bodytext3"><strong>Monthly</strong></td>
		  <td align="left" class="bodytext3"><strong>Notional</strong></td>
		  </tr>
		  <?php 
		
	    $query1 = "select * from master_payrollcomponent where recordstatus = 'deleted' order by componentname ";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		while ($res1 = mysql_fetch_array($exec1))
		{
		$componentname = $res1["componentname"];
		$auto_number = $res1["auto_number"];
		$type = $res1['type'];
		$amounttype = $res1['amounttype'];
		$monthly = $res1['monthly'];
		$notional = $res1['notional'];

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
        <tr <?php eval(base64_decode('IGVjaG8gJGNvbG9yY29kZTsg')); ?>>
                        <td width="11%" align="left" valign="top"  class="bodytext3">
						<a href="addpayrollcomponent1.php?st=activate&&anum=<?php eval(base64_decode('IGVjaG8gJGF1dG9fbnVtYmVyOyA=')); ?>" class="bodytext3">
                          <div align="center" class="bodytext3">Activate</div>
                        </a></td>
                        <td align="left" valign="top"  class="bodytext3"><?php eval(base64_decode('IGVjaG8gJGNvbXBvbmVudG5hbWU7IA==')); ?></td>
						<td align="left" valign="top"  class="bodytext3"><?php eval(base64_decode('IGVjaG8gJHR5cGU7IA==')); ?></td>
						<td align="left" valign="top"  class="bodytext3"><?php eval(base64_decode('IGVjaG8gJGFtb3VudHR5cGU7IA==')); ?></td>
						<td align="left" valign="top"  class="bodytext3"><?php eval(base64_decode('IGVjaG8gJG1vbnRobHk7IA==')); ?></td>
						<td align="left" valign="top"  class="bodytext3"><?php eval(base64_decode('IGVjaG8gJG5vdGlvbmFsOyA=')); ?></td>
                        </tr>
        <?php 
		}
		 ?>
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
<?php eval(base64_decode('IGluY2x1ZGUgKCJpbmNsdWRlcy9mb290ZXIxLnBocCIpOyA=')); ?>
</body>
</html>

