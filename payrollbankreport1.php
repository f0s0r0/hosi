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
$companyanum = $_SESSION['companyanum'];
$errmsg = '';
$bgcolorcode = "";
$colorloopcount = "";

$month = date('M-Y');

$query81 = "select * from master_company where auto_number = '$companyanum'";
$exec81 = mysql_query($query81) or die ("Error in Query81".mysql_error());
$res81 = mysql_fetch_array($exec81);
$companycode = $res81['companycode'];
$companyname = $res81['companyname'];

if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
if (isset($_REQUEST["searchbank"])) { $searchbank = $_REQUEST["searchbank"]; } else { $searchbank = ""; }
if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }

//$frmflag1 = $_REQUEST['frmflag1'];
if ($frmflag1 == 'frmflag1')
{
	
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == 'success')
{
		$errmsg = "";
}
else if ($st == 'failed')
{
		$errmsg = "";
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
<!--<script type="text/javascript" src="js/autoemployeecodesearch6.js"></script> -->
<script type="text/javascript" src="js/autosuggestemployeereportsearch1.js"></script>
<script type="text/javascript" src="js/autocomplete_jobdescription2.js"></script>
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
	var oTextbox = new AutoSuggestControl(document.getElementById("searchemployee"), new StateSuggestions());
  	
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

function from1submit1()
{

}

</script>
<script src="js/datetimepicker1_css.js"></script>
<body>
<table width="101%" align="left" border="0" cellspacing="0" cellpadding="2">
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
    <td height="25" colspan="10">&nbsp;</td>
  </tr>
  <tr>
   <td width="1%" align="left" valign="top">&nbsp;</td>
    <td  valign="top">
	<form name="form1" id="form1" method="post" action="payrollbankreport1.php" onSubmit="return from1submit1()">
	<table width="900" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#999999">
	<td colspan="30" align="left" class="bodytext3"><strong>Search Report</strong></td>
	</tr>
	<tr>
	<td width="95" align="left" class="bodytext3">Search Employee</td>
	<td colspan="4" align="left" class="bodytext3">
	<input type="hidden" name="autobuildemployee" id="autobuildemployee">
	<input type="hidden" name="searchemployeecode" id="searchemployeecode">
	<input type="text" name="searchemployee" id="searchemployee" autocomplete="off" value="<?php echo $searchemployee; ?>" size="50" style="border:solid 1px #001E6A;"></td>
	</tr>
	<tr>
	<td width="95" align="left" class="bodytext3">Search Bank</td>
	<td colspan="4" align="left" class="bodytext3">
	<input type="text" name="searchbank" id="searchbank" autocomplete="off" value="<?php echo $searchbank; ?>" size="50" style="border:solid 1px #001E6A;"></td>
	</tr>
	<tr>
	<td align="left" class="bodytext3">Search Month</td>
	<td width="63" align="left" class="bodytext3"><select name="searchmonth" id="searchmonth">
	<?php if($searchmonth != '') { ?>
	<option value="<?php echo $searchmonth; ?>"><?php echo $searchmonth; ?></option>
	<?php } ?>
	<?php
	$arraymonth = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
	$monthcount = count($arraymonth);
	for($i=0;$i<$monthcount;$i++)
	{
	?>
	<option value="<?php echo $arraymonth[$i]; ?>"><?php echo $arraymonth[$i]; ?></option>
	<?php
	}
	?>
	</select></td>
	<td width="74" align="left" class="bodytext3">Search Year</td>
	<td width="56" align="left" class="bodytext3"><select name="searchyear" id="searchyear">
	<?php if($searchyear != '') { ?>
	<option value="<?php echo $searchyear; ?>"><?php echo $searchyear; ?></option>
	<?php } ?>
	<?php
	for($j=2010;$j<=date('Y');$j++)
	{
	?>
	<option value="<?php echo $j; ?>"><?php echo $j; ?></option>
	<?php
	}
	?>
	</select></td>
	<td width="560" align="left" class="bodytext3">
	<input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1">
	<input type="submit" name="Search" value="Submit" style="border:solid 1px #001E6A;"></td>
	</tr>
	<tr>
	<td align="left" colspan="5">&nbsp;</td>
	</td>
	</tbody>
	</table>
	</form>
	</td>
	</tr>
	<tr>
   <td width="1%" align="left" valign="top">&nbsp;</td>
    <td  valign="top">
	<?php
	$totalamount = '0.00';
	if($frmflag1 == 'frmflag1')
	{	
		if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
		if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
		if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
		if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }

		$searchmonthyear = $searchmonth.'-'.$searchyear; 
		
		$url = "frmflag1=$frmflag1&&searchmonth=$searchmonth&&searchyear=$searchyear&&searchemployee=$searchemployee&&searchbank=$searchbank";

	?>	
	<table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#CCCCCC">
	<td colspan="30" align="left" class="bodytext3"><strong>BANK Report</strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="30" align="left" class="bodytext3"><strong>EMPLOYER'S CODE : <?php echo $companycode; ?></strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="30" align="left" class="bodytext3"><strong>EMPLOYER'S NAME : <?php echo $companyname; ?></strong></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	<td colspan="30" align="left" class="bodytext3"><strong>MONTH OF CONTRIBUTION : <?php echo $searchmonthyear; ?></strong></td>
	</tr>
	<tr bgcolor="#E0E0E0">
	<td colspan="30" align="left" class="bodytext3"><strong>&nbsp;</strong></td>
	</tr>
	<tr>
	<td width="25" align="center" bgcolor="#CCCCCC" class="bodytext3"><strong>S.No</strong></td>
	<td width="25" align="left" bgcolor="#CCCCCC" class="bodytext3"><strong>PAYROLL NO</strong></td>
	<td width="217" align="left" bgcolor="#CCCCCC" class="bodytext3"><strong>EMPLOYEE NAME</strong></td>
	<td width="105" align="left" bgcolor="#CCCCCC" class="bodytext3"><strong>BRANCH NAME</strong></td>
	<td width="25" align="left" bgcolor="#CCCCCC" class="bodytext3"><strong>ACCOUNT NO</strong></td>
	<td align="right" bgcolor="#CCCCCC" class="bodytext3" width="77"><strong>AMOUNT</strong></td>
	<td align="left" bgcolor="#CCCCCC" class="bodytext3" width="47">&nbsp;</td>
	</tr>
	<?php
	$totalamount = '0.00';
	$query9 = "select * from master_employeeinfo where bankname like '%$searchbank%' and bankname <> '' group by bankname order by bankname";
	$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
	while($res9 = mysql_fetch_array($exec9))
	{
	$res9bankname = $res9['bankname'];
	?>
	<tr>
	<td colspan="7" align = "left" class="bodytext3" bgcolor="#FFFFFF"><strong><?php echo $res9bankname; ?></strong></td>
	</tr>
	<?php
	$query2 = "select a.employeename as employeename,a.employeecode as employeecode,b.departmentname as departmentname,b.payrollno as payrollno from payroll_assign a,master_employee b where a.employeename  like '%$searchemployee%' and a.employeecode = b.employeecode and b.payrollstatus = 'Active' and a.status <> 'deleted' group by a.employeecode order by b.payrollno";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	while($res2 = mysql_fetch_array($exec2))
	{
	$res2employeecode = $res2['employeecode'];
	$res2employeename = $res2['employeename'];
	$payrollno = $res2['payrollno'];
	
	$query6 = "select * from master_employeeinfo where employeecode = '$res2employeecode' and bankname = '$res9bankname'";
	$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
	$res6 = mysql_fetch_array($exec6);
	$bankbranch = $res6['bankbranch'];
	$accountnumber = $res6['accountnumber'];
	
	if($accountnumber != '')
	{ 

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
	<td align="center" class="bodytext3"><?php echo $colorloopcount; ?></td>
	<td align="left" class="bodytext3"><?php echo $payrollno; ?></td>
	<td align="left" class="bodytext3"><?php echo $res2employeename; ?></td>
	<td align="left" class="bodytext3"><?php echo $bankbranch; ?></td>
	<td align="left" class="bodytext3"><?php echo $accountnumber; ?></td>
	<?php
	$componentamount = 0;
	$componentamount4 = 0;
	$query7 = "select auto_number, typecode from master_payrollcomponent where recordstatus <> 'deleted'";
	$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
	while($res7 = mysql_fetch_array($exec7))
	{
		$auto_number = $res7['auto_number'];
		$typecode = $res7['typecode'];
	
		$query3 = "select SUM(`$auto_number`) as componentamount from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
		$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
		$res3 = mysql_fetch_array($exec3);
		$componentamount1 = $res3['componentamount'];
		
		if($typecode == '10')
		{
			$componentamount = $componentamount + $componentamount1;
		}
		else
		{
			$componentamount4 = $componentamount4 + $componentamount1;
		}
		
	}
	$nettpay = $componentamount - $componentamount4;
	$totalamount = $totalamount + $nettpay;
	?>
	<td align="right" class="bodytext3" width="77"><?php echo number_format($nettpay,2,'.',','); ?></td>
	<td align="right" class="bodytext3" width="47">&nbsp;</td>	
	<?php
	}
	}
	}
	?>
	</tr>
	<tr>
	<td colspan="5" bgcolor="#CCCCCC" align="right" class="bodytext3"><strong>Total :</strong></td>
	<td bgcolor="#CCCCCC" align="right" class="bodytext3"><strong><?php echo number_format($totalamount,2,'.',','); ?></strong></td>
	<td align="left" bgcolor="#CCCCCC" class="bodytext3" width="47">&nbsp;</td>
	</tr>
	<tr>
	<td colspan="7" align="right" class="bodytext3"><a href="print_bankreport.php?<?php echo $url; ?>" target="_blank"><img src="images/pdfdownload.jpg" height="40" width="40"></a></td>
	</tr>
	</tbody>
	</table> 
	<?php
	}
	?>
	</td>
  	</tr>
    </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

