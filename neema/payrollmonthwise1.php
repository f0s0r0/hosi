<?php
session_start();
$pagename = '';
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION['username'])) header ("location:index.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$sessionusername = $_SESSION['username'];
$username = $_SESSION['username'];
$errmsg = '';
$bgcolorcode = '';
$colorloopcount = '';
$month = date('M-Y');
$sno = '';
$docno = $_SESSION['docno'];

function readCSV($csvFile){
    $file_handle = fopen($csvFile, 'r');
    while (!feof($file_handle) ) {
        $line_of_text[] = fgetcsv($file_handle, 1024);
    }
    fclose($file_handle);
    return $line_of_text;
}

	$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	$res1 = mysql_fetch_array($exec1);
	$locationname = $res1["locationname"];
	$locationcode = $res1["locationcode"];  

if (isset($_REQUEST["searchsuppliername"])) {  $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
if (isset($_REQUEST["searchdescription"])) {   $searchdescription = $_REQUEST["searchdescription"]; } else { $searchdescription = ""; }
if (isset($_REQUEST["searchemployeecode"])) { $searchemployeecode = $_REQUEST["searchemployeecode"]; } else { $searchemployeecode = ""; }
if (isset($_REQUEST["searchcomponent"])) { $searchcomponent = $_REQUEST["searchcomponent"]; } else { $searchcomponent = ""; }
if($searchcomponent != '')
{
	$comsplit = explode('|',$searchcomponent);
	$component = $comsplit[0];
	$componentname = $comsplit[1];
}
else
{
	$component = '';
 	$componentname = '';
}

if (isset($_REQUEST["assignmonth"])) { $assignmonth = $_REQUEST["assignmonth"]; } else { $assignmonth = date('M-Y'); }
if (isset($_REQUEST["frmflag_upload"])) { $frmflag_upload = $_REQUEST["frmflag_upload"]; } else { $frmflag_upload = ""; }
if (isset($_REQUEST["frmflag34"])) { $frmflag34 = $_REQUEST["frmflag34"]; } else { $frmflag34 = ""; }

if($frmflag_upload == 'frmflag_upload')
{
	$component1 = $_REQUEST["component"];
	$assignmonth1 = $_REQUEST["assignmonth"];
	if(!empty($_FILES['upload_file']))
	{
		$csvFile = $_FILES['upload_file']['tmp_name'];
		//print_r($_FILES['upload_file']);
		$extension = substr(strrchr($_FILES['upload_file']['name'], "."), 1);
		if($extension == 'csv')
		{
			$csv = readCSV($csvFile);
			$count = count($csv);
			for($i=1;$i<$count;$i++)
			{
				$employeecode = $csv[$i][0];
				$employeename = $csv[$i][1];
				$componentanum = $csv[$i][2];
				$componentname = $csv[$i][3];
				$amount = $csv[$i][4];
				if($amount == '')
				{
					$amount = 0;
				}
				
				$query34 = "select typecode, type, amounttype, monthly from master_payrollcomponent where auto_number = '$componentanum'";
				$exec34 = mysql_query($query34) or die ("Error in Query34".mysql_error());
				$res34 = mysql_fetch_array($exec34);
				$typecode = $res34['typecode'];
				$type = $res34['type'];
				$amounttype = $res34['amounttype'];
				$monthly = $res34['monthly'];
				
				if($employeecode != '' && $component1 == $componentanum)
				{
					$query35 = "select employeecode from payroll_assignmonthwise where employeecode = '$employeecode' and componentanum = '$componentanum' and assignmonth = '$assignmonth1'";
					$exec35 = mysql_query($query35) or die ("Error in Query35".mysql_error());
					$row35 = mysql_num_rows($exec35);
					if($row35 == 0)
					{
						$query_insert = "INSERT INTO `payroll_assignmonthwise`(`employeecode`, `employeename`, `componentanum`, `componentname`, `typecode`, `type`, `amounttype`, `monthly`, `assignmonth`, `rate`, `unit`, `amount`, `status`, `ipaddress`, `username`, `updatetime`) 
						VALUES ('$employeecode','$employeename','$componentanum','$componentname','$typecode','$type','$amounttype','$monthly','$assignmonth1','$amount','1','$amount','','$ipaddress','$username','$updatedatetime')";
						$execinsert = mysql_query($query_insert) or die ("Error in Query_insert".mysql_error());
					}
					else
					{
						$query351 = "update payroll_assignmonthwise set `rate` = '$amount', `unit` = '1', `amount` = '$amount' where employeecode = '$employeecode' and componentanum = '$componentanum' and assignmonth = '$assignmonth1'";
						$exec351 = mysql_query($query351) or die ("Error in Query351".mysql_error());
					}
				}							 
			}
			
			header("location:payrollmonthwise1.php?st=success_upload");
		}
		else
		{
			header("location:payrollmonthwise1.php?st=error_upload");
		}	
	}
	else
	{
		header("location:payrollmonthwise1.php?st=error_upload");
	}
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == 'success_upload')
{
		$errmsg = "Uploaded Successfully";
}
else if ($st == 'error_upload')
{
		$errmsg = "Upload Failed";
}
?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" /> 
<script type="text/javascript" src="js/autocomplete_jobdescription2.js"></script>
<script type="text/javascript" src="js/autosuggestemployeesearch13.js"></script>
<script type="text/javascript" src="js/autoemployeeloandetails1.js"></script>
<!--<script type="text/javascript" src="js/autoemployeecodesearch5.js"></script> don't activate-->
<script type="text/javascript" src="js/autoemployeepayroll2.js"></script>

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

window.onload = function () 
{
	//var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());
  	
}

function LoanHold(k)
{
	var k = k;
	//alert(k);
	var MonthInterest = document.getElementById("monthinterest"+k).value;
	var MonthAmount = document.getElementById("monthamount"+k).value;
	var MonthPay = document.getElementById("monthpay"+k).value;
	if(document.getElementById("hold"+k).checked == true)
	{
		document.getElementById("monthpay"+k).value = MonthInterest;
	}
	if(document.getElementById("hold"+k).checked == false)
	{
		var MonthNett = parseFloat(MonthAmount) + parseFloat(MonthInterest);
		var MonthNett = MonthNett.toFixed(2);
		document.getElementById("monthpay"+k).value = MonthNett;
	}
}

</script>

<script language="javascript">

function captureEscapeKey1()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		//alert ("Escape Key Press.");
		//event.keyCode=0; 
		//return event.keyCode 
		//return false;
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

function Process1()
{
	if(document.getElementById("assignmonth").value == "")
	{
		alert("Select Month");
		return false;
	}
	if(document.getElementById("searchcomponent").value == "")
	{
		alert("Select Componentname");
		document.getElementById("searchcomponent").focus();
		return false;
	}
	
	var searchcomponent = document.getElementById("searchcomponent").value;
	var assignmonth = document.getElementById("assignmonth").value;
	window.open("payrollmonthwise_csv.php?frmflag34=frmflag34&&searchcomponent="+searchcomponent+"&&assignmonth="+assignmonth, "_blank");
}

function Process2()
{
	if (document.getElementById('upload_file').value == '') 
	{
		 alert('Select CSV file to Upload');
		 return false;
	} 
}

function Amtcalc(id)
{
	var Rate = document.getElementById("rate"+id).value;

	if(isNaN(document.getElementById("unit"+id).value))
	{
		alert("Enter Numbers");
		document.getElementById("unit"+id).focus();
		return false;
	}
	else
	{
		var Unit = document.getElementById("unit"+id).value;
		if(Unit.length > 0)
		{
		var Amount = parseFloat(Rate) * parseFloat(Unit);
		document.getElementById("amount"+id).value = Amount.toFixed(3);
		document.getElementById("serialnumbermonth"+id).checked = true;
		}
		else
		{
		document.getElementById("amount"+id).value = "0.00";
		document.getElementById("serialnumbermonth"+id).checked = false;
		}
	}
}
</script>
<script src="js/datetimepicker1_css.js"></script>
<body>
<table width="101%" align="left" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#6487DC"><?php eval(base64_decode('IGluY2x1ZGUgKCJpbmNsdWRlcy9hbGVydG1lc3NhZ2VzMS5waHAiKTsg')); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#8CAAE6"><?php eval(base64_decode('IGluY2x1ZGUgKCJpbmNsdWRlcy90aXRsZTEucGhwIik7IA==')); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#E0E0E0">
	<?php eval(base64_decode('IA0KCQ0KCQlpbmNsdWRlICgiaW5jbHVkZXMvbWVudTEucGhwIik7IA0KCQ0KCS8vCWluY2x1ZGUgKCJpbmNsdWRlcy9tZW51Mi5waHAiKTsgDQoJDQoJ')); ?>	</td>
  </tr>
  <tr>
    <td height="25" colspan="10">&nbsp;</td>
  </tr>
  <tr>
   <td width="1%" align="left" valign="top">&nbsp;</td>
    <td width="80%" valign="top">
	<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#CCC">
	<td colspan="2" align="left" class="bodytext3"><strong>Payroll Monthwise Assign</strong></td>
	</tr>
	<?php if($errmsg != '') { ?>
	<tr bgcolor="#FF6600">
	<td colspan="2" align="left" class="bodytext3" style="color:#FFF"><strong><?php echo $errmsg; ?></strong></td>
	</tr>
	<?php } ?>
	<tr>
	<td width="432" align="left" valign="top" class="bodytext3">
	<table width="100%" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<form name="form1" id="form1" method="post" action="payrollmonthwise1.php">
	<thead>
	<tr bgcolor="#FFFFFF">
	<td width="18%" align="left" class="bodytext3"><strong>Select Month</strong></td>
	<td colspan="2" width="82%" align="left" class="bodytext3">
	<input type="text" name="assignmonth" id="assignmonth" readonly="readonly" value="<?php echo $assignmonth; ?>" size="10">
	<img src="images2/cal.gif" onClick="javascript:NewCssCal('assignmonth','MMMYYYY')" style="cursor:pointer"/>
	</td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td align="left" class="bodytext3"><strong>Select Component</strong></td>
	<td colspan="2" align="left" class="bodytext3">
	<select name="searchcomponent" id="searchcomponent">
	<option value="">Select</option>
	<?php
	$query4 = "select auto_number, componentname from master_payrollcomponent where monthly = 'Yes' and recordstatus <> 'deleted' order by auto_number";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	while($res4 = mysql_fetch_array($exec4))
	{
	$canum = $res4['auto_number'];
	$componentname1 = $res4['componentname'];
	?>
	<option value="<?php echo $canum.'|'.$componentname1; ?>" <?php if($searchcomponent == $canum.'|'.$componentname1) { echo "selected"; } ?>><?php echo $componentname1; ?></option>
	<?php 
	}
	?>
	</select>
	</td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td>&nbsp;</td>
	<td colspan="2">
	<input type="hidden" name="frmflag34" id="frmflag34" value="frmflag34">
	<input type="submit" name="frmsubmit" value="Submit" onClick="return Process1()">
	</td>
  	</tr>
 	</thead>
	</form>
	
	<?php 
	if($frmflag34 == 'frmflag34') {
	$componentname = str_replace(' ','_',$componentname);
	?>
	<form name="form_upload" method="post" action="payrollmonthwise1.php" enctype="multipart/form-data">
	<tbody id="tblrowinsert" bgcolor="#D3EEB7">
	<tr>
	<td colspan="3">&nbsp;</td>
	</tr>
	<tr>
	<td>&nbsp;</td>
	<td colspan="2" align="left" class="bodytext3">
	<strong>Upload CSV File </strong>
	</td>
	</tr>
	<tr>
	<td>&nbsp;</td>
	<td colspan="2"><input type="file" name="upload_file" id="upload_file"></td>
	</tr>
	<tr>
	<td>&nbsp;</td>
	<td colspan="2">
	<input type="hidden" name="component" id="component1" value="<?= $component; ?>">
	<input type="hidden" name="assignmonth" id="assignmonth1" value="<?= $assignmonth; ?>">
	<input type="hidden" name="frmflag_upload" id="frmflag_upload" value="frmflag_upload">
	<input type="submit" name="frmsubmit1" value="Upload CSV" onClick="return Process2()">
	</td>
	</tr>
	</tbody>
	</form>	
	<?php } ?>
	</table>
	</td>
	</tr>
	</table>
	
   
<?php eval(base64_decode('IGluY2x1ZGUgKCJpbmNsdWRlcy9mb290ZXIxLnBocCIpOyA=')); ?>
</body>
</html>

