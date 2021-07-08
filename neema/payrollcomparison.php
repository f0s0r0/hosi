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
$companyanum = $_SESSION['companyanum'];
$companycode = $_SESSION['companycode'];
$companyname = $_SESSION['companyname'];
$errmsg = '';
$bgcolorcode = "";
$colorloopcount = "";
$totalbenefit = "0.00";
$nettotalbenefit = "0.00";

$month = date('M-Y');

$query81 = "select * from master_company where auto_number = '$companyanum'";
$exec81 = mysql_query($query81) or die ("Error in Query81".mysql_error());
$res81 = mysql_fetch_array($exec81);
$companycode = $res81['companycode'];
$companyname = $res81['companyname'];


if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M',strtotime('-1 month')); }
if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }
if (isset($_REQUEST["searchmonth1"])) { $searchmonth1 = $_REQUEST["searchmonth1"]; } else { $searchmonth1 = date('M'); }
if (isset($_REQUEST["searchyear1"])) { $searchyear1 = $_REQUEST["searchyear1"]; } else { $searchyear1 = date('Y'); }
if (isset($_REQUEST["department"])) { $departmentname = $_REQUEST["department"]; } else { $departmentname = ""; }
if (isset($_REQUEST["type"])) { $type = $_REQUEST["type"]; } else { $type = "Summary"; }
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

window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchemployee"), new StateSuggestions());
  	
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
	<form name="form1" id="form1" method="post" action="payrollcomparison.php" onSubmit="return from1submit1()">
	<table width="900" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#999999">
	<td colspan="30" align="left" class="bodytext3"><strong>Payroll Comparison</strong></td>
	</tr>
	<tr>
	<td width="115" align="left" class="bodytext3">Search Employee</td>
	<td colspan="3" align="left" class="bodytext3">
	<input type="hidden" name="autobuildemployee" id="autobuildemployee">
	<input type="hidden" name="searchemployeecode" id="searchemployeecode">
	<input type="text" name="searchemployee" id="searchemployee" autocomplete="off" value="<?php echo $searchemployee; ?>" size="50" style="border:solid 1px #001E6A;"></td>
	</tr>
	<tr>
	  <td align="left" class="bodytext3">Department</td>
	  <td colspan="3" align="left" class="bodytext3"><select name="department" id="department" style="border:solid 1px #001E6A;">
	  <option value="">All</option>
	  <?php
	  $query5 = "select * from master_department where recordstatus <> 'deleted' order by department";
	  $exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
	  while($res5 = mysql_fetch_array($exec5))
	  {
	  $departmentanum = $res5['auto_number'];
	  $department_name = $res5['department'];
	  ?>
	  <option value="<?php echo $department_name; ?>" <?php if($departmentname == $department_name){?> selected="selected" <?php } ?>><?php echo $department_name; ?></option>
	  <?php
	  }
	  ?>
	  </select></td>
	</tr>
	<tr>
	<td align="left" class="bodytext3">Month 1</td>
	<td align="left" class="bodytext3"><select name="searchmonth" id="searchmonth">
	<?php if($searchmonth != '') { ?>
	<option value="<?php echo $searchmonth; ?>"><?php echo $searchmonth; ?></option>
	<?php } ?>
	<?php
	$arraymonth = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
	$monthcount = count($arraymonth);
	for($i=0;$i<$monthcount;$i++)
	{
	?>
	<option value="<?php echo $arraymonth[$i]; ?>"><?php echo $arraymonth[$i]; ?></option>
	<?php
	}
	?>
	</select>
	</td>
	<td width="44" align="left" class="bodytext3">Year</td>
	<td width="618" align="left" class="bodytext3"><select name="searchyear" id="searchyear">
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
	</tr>
	<tr>
	<td align="left" class="bodytext3">Month 2</td>
	<td width="91" align="left" class="bodytext3"><select name="searchmonth1" id="searchmonth1">
	<?php if($searchmonth1 != '') { ?>
	<option value="<?php echo $searchmonth1; ?>"><?php echo $searchmonth1; ?></option>
	<?php } ?>
	<?php
	$arraymonth = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
	$monthcount = count($arraymonth);
	for($i=0;$i<$monthcount;$i++)
	{
	?>
	<option value="<?php echo $arraymonth[$i]; ?>"><?php echo $arraymonth[$i]; ?></option>
	<?php
	}
	?>
	</select>
	</td>
	<td width="44" align="left" class="bodytext3">Year</td>
	<td width="618" align="left" class="bodytext3"><select name="searchyear1" id="searchyear1">
	<?php if($searchyear1 != '') { ?>
	<option value="<?php echo $searchyear1; ?>"><?php echo $searchyear1; ?></option>
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
	</tr>
	<tr>
	<td align="left" class="bodytext3">&nbsp;</td>
	<td colspan="3" align="left" class="bodytext3">
	<input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1">
	<input type="submit" name="Search" value="Submit" style="border:solid 1px #001E6A;"></td>
	</tr>
	<tr>
	<td align="left" colspan="4">&nbsp;</td>
	</tr>
	</tbody>
	</table>
	</form>
	</td>
	</tr>
  <tr>
   <td width="1%" align="left" valign="top">&nbsp;</td>
    <td  valign="top">
	<?php
	if ($frmflag1 == 'frmflag1')
	{	
		$searchmonthyear = $searchmonth.'-'.$searchyear;
		$searchmonthyear1 = $searchmonth1.'-'.$searchyear1;
		
		$url = "frmflag1=$frmflag1&&searchmonth=$searchmonth&&searchyear=$searchyear&&searchemployee=$searchemployee&&searchemployeecode=&&department=$departmentname&&companycode=$companycode&&type=$type";
	?>
	<table border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#CCCCCC">
	<td colspan="30" align="left" class="bodytext3"><strong>PAYROLL REPORT</strong></td>
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
	<tr>
	<td width="26" align="center" bgcolor="#CCCCCC" class="bodytext3"><strong>&nbsp;</strong></td>
	<td width="101" align="center" bgcolor="#CCCCCC" class="bodytext3"><strong>&nbsp;</strong></td>
	<td width="99" align="center" bgcolor="#CCCCCC" class="bodytext3"><strong>MONTH</strong></td>
	<td width="99" align="center" bgcolor="#CCCCCC" class="bodytext3"><strong>&nbsp;</strong></td>
	<?php
	$totalamount = '0.00';
	
	$query1 = "select auto_number,componentname from master_payrollcomponent where recordstatus <> 'deleted' order by typecode, auto_number";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	while($res1 = mysql_fetch_array($exec1))
	{
	$componentanum = $res1['auto_number'];
	$componentname = $res1['componentname'];
	?>
	<td align="center" bgcolor="#CCCCCC" class="bodytext3" width="184"><strong><?php echo $componentname; ?></strong></td>
	<?php
	}
	?>
	<td align="center" bgcolor="#CCCCCC" class="bodytext3" width="84"><strong>INSURANCE</strong></td>
	<td align="center" bgcolor="#CCCCCC" class="bodytext3" width="84"><strong>GROSS PAY</strong></td>
	<td align="center" bgcolor="#CCCCCC" class="bodytext3" width="84"><strong>DEDUCTIONS</strong></td>
	<td align="center" bgcolor="#CCCCCC" class="bodytext3" width="84"><strong>NOTIONAL BENEFIT</strong></td>
	<td align="center" bgcolor="#CCCCCC" class="bodytext3" width="84"><strong>NETT PAY</strong></td>
	</tr>
	<?php
	$totalamount = '0.00';
	
	if($type=='Summary')
	{
	?>
	<tr bgcolor="#D3EEB7">
	<td colspan="3" align="right" class="bodytext3"><strong><?php echo $searchmonthyear; ?></strong></td>
	<td align="right" class="bodytext3"><strong>&nbsp;</strong></td>
	<?php
	
	$totalamount = '0.00';
	 $query1 = "select auto_number from master_payrollcomponent where recordstatus <> 'deleted' order by typecode, auto_number";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	while($res1 = mysql_fetch_array($exec1))
	{
	$componentanum = $res1['auto_number'];
	$totalamount = '0.00';
	
		$query23 = "select a.employeename,a.employeecode from payroll_assign a,master_employee b where a.employeename  like '%$searchemployee%'  and b.departmentname LIKE '%$departmentname%' and  a.employeecode = b.employeecode  and a.status <> 'deleted' group by a.employeename";
		$exec23 = mysql_query($query23) or die ("Error in Query23".mysql_error());
		while($res23 = mysql_fetch_array($exec23))
		{	
			$searchemployeename3 = $res23['employeename'];
			$searchemployeecode3 = $res23['employeecode'];
			
			$query31 = "select employeecode from details_employeepayroll where employeecode = '$searchemployeecode3' and  paymonth = '$searchmonthyear' and status <> 'deleted'";
			$exec31 = mysql_query($query31) or die ("Error in Query31".mysql_error());
			$res31 = mysql_fetch_array($exec31);
			$res31employeecode = $res31['employeecode'];
			
			if($res31employeecode != '')
			{
	
			$query3 = "select componentamount from details_employeepayroll where employeecode = '$res31employeecode' and  paymonth = '$searchmonthyear' and componentanum = '$componentanum' and status <> 'deleted'";
			$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
			while($res3 = mysql_fetch_array($exec3))
			{
			 $totalcomponentamount = $res3['componentamount'];
			 $totalamount = $totalamount + $totalcomponentamount;
			}
			
			}
		}	
	?>
	<td align="right" class="bodytext3" width="26"><strong><?php if($totalamount > 0) { echo number_format($totalamount,0,'.',','); } ?></strong></td>	
	<?php
	}
	?>
	<?php
	$totalinsurance = '';
	$query63 = "select insurancename from insurance_relief where employeename like '%$searchemployee%' and  status <> 'deleted' and insurancename <> ''";
	$exec63 = mysql_query($query63) or die ("Error in Query63".mysql_error());
	while($res63 = mysql_fetch_array($exec63))
	{
	$insurancename = $res63['insurancename'];
	$query60 = "select componentamount from details_employeepayroll where employeename like '%$searchemployee%' and  paymonth = '$searchmonthyear' and componentname = '$insurancename' and status <> 'deleted'";
	$exec60 = mysql_query($query60) or die ("Error in Query60".mysql_error());
	$res60 = mysql_fetch_array($exec60);
	$res60componentamount = $res60['componentamount'];
	$totalinsurance = $totalinsurance + $res60componentamount;
	}
	?>
	<td align="right" class="bodytext3" width="26"><strong><?php if($totalinsurance > 0) { echo number_format($totalinsurance,0,'.',','); } ?></strong></td>
	<?php
	$query1 = "select auto_number from master_payrollcomponent where recordstatus <> 'deleted' order by typecode, auto_number";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	while($res1 = mysql_fetch_array($exec1))
	{
	$componentanum = $res1['auto_number'];
	$totalamount = '0.00';
	$res60grosspay = '0.00';
	$res61totaldeduct = '0.00';
	
		$query23 = "select a.employeename,a.employeecode from payroll_assign a,master_employee b where a.employeename  like '%$searchemployee%'  and b.departmentname LIKE '%$departmentname%' and  a.employeecode = b.employeecode  and a.status <> 'deleted' group by a.employeename";
		$exec23 = mysql_query($query23) or die ("Error in Query23".mysql_error());
		while($res23 = mysql_fetch_array($exec23))
		{	
			$searchemployeename3 = $res23['employeename'];
			$searchemployeecode3 = $res23['employeecode'];
			
			$query31 = "select employeecode from details_employeepayroll where employeecode = '$searchemployeecode3' and  paymonth = '$searchmonthyear' and status <> 'deleted'";
			$exec31 = mysql_query($query31) or die ("Error in Query31".mysql_error());
			$res31 = mysql_fetch_array($exec31);
			$res31employeecode = $res31['employeecode'];
			
			if($res31employeecode != '')
			{
				$query60 = "select sum(componentamount) as totalgross from details_employeepayroll where employeecode = '$res31employeecode' and  paymonth = '$searchmonthyear' and typecode = '10' and status <> 'deleted'";
				$exec60 = mysql_query($query60) or die ("Error in Query60".mysql_error());
				while($res60 = mysql_fetch_array($exec60))
				{
				$res60grosspay = $res60grosspay + $res60['totalgross'];
				}
				
				$query61 = "select sum(componentamount) as totaldeduct from details_employeepayroll where employeecode = '$res31employeecode' and  paymonth = '$searchmonthyear' and typecode = '20' and status <> 'deleted'";
				$exec61 = mysql_query($query61) or die ("Error in Query61".mysql_error());
				while($res61 = mysql_fetch_array($exec61))
				{
				$res61totaldeduct = $res61totaldeduct + $res61['totaldeduct'];
				}
			}
		}	
	}		
	?>
	<td align="right" class="bodytext3" width="26"><strong><?php if($res60grosspay > 0) { echo number_format($res60grosspay,0,'.',','); } ?></strong></td>	
	<td align="right" class="bodytext3" width="26"><strong><?php if($res61totaldeduct > 0) { echo number_format($res61totaldeduct,0,'.',','); } ?></strong></td>	
	<?php
	$query912 = "select auto_number from master_payrollcomponent where notional = 'Yes' and recordstatus <> 'deleted'";
	$exec912 = mysql_query($query912) or die ("Error in Query912".mysql_error());
	while($res912 = mysql_fetch_array($exec912))
	{
	$benefitanum = $res912['auto_number'];
	$query611 = "select sum(componentamount) as totalbenefits from details_employeepayroll where employeename like '%$searchemployee%' and  componentanum = '$benefitanum' and paymonth = '$searchmonthyear' and status <> 'deleted'";
	$exec611 = mysql_query($query611) or die ("Error in Query611".mysql_error());
	$res611 = mysql_fetch_array($exec611);
	$res611benefits = $res611['totalbenefits'];
	$nettotalbenefit = $nettotalbenefit + $res611benefits;
	}
	?>
	<td align="right" class="bodytext3"><strong><?php if($nettotalbenefit > 0) { echo number_format($nettotalbenefit,0,'.',','); } ?></strong></td>	
	<?php
	$res62totalnett = $res60grosspay - $res61totaldeduct;
	?>
	<td align="right" class="bodytext3" width="26" colspan="2"><strong><?php if($res62totalnett > 0) { echo number_format($res62totalnett-$nettotalbenefit,0,'.',','); } ?></strong></td>
	</tr>
	<?php
	// 2nd month
	
	?>
	<tr bgcolor="#CBDBFA">
	<td colspan="3" align="right" class="bodytext3"><strong><?php echo $searchmonthyear1; ?></strong></td>
	<td align="right" class="bodytext3"><strong>&nbsp;</strong></td>
	<?php
	
	$totalamount = '0.00';
	 $query51 = "select auto_number from master_payrollcomponent where recordstatus <> 'deleted' order by typecode, auto_number";
	$exec51 = mysql_query($query51) or die ("Error in Query51".mysql_error());
	while($res51 = mysql_fetch_array($exec51))
	{
	$componentanum = $res51['auto_number'];
	$totalamount = '0.00';
	
		$query235 = "select a.employeename,a.employeecode from payroll_assign a,master_employee b where a.employeename  like '%$searchemployee%'  and b.departmentname LIKE '%$departmentname%' and  a.employeecode = b.employeecode  and a.status <> 'deleted' group by a.employeename";
		$exec235 = mysql_query($query235) or die ("Error in Query235".mysql_error());
		while($res235 = mysql_fetch_array($exec235))
		{	
			$searchemployeename35 = $res235['employeename'];
			$searchemployeecode35 = $res235['employeecode'];
			
			$query315 = "select employeecode from details_employeepayroll where employeecode = '$searchemployeecode35' and  paymonth = '$searchmonthyear1' and status <> 'deleted'";
			$exec315 = mysql_query($query315) or die ("Error in Query315".mysql_error());
			$res315 = mysql_fetch_array($exec315);
			$res315employeecode = $res315['employeecode'];
			
			if($res315employeecode != '')
			{
	
			$query316 = "select componentamount from details_employeepayroll where employeecode = '$res315employeecode' and  paymonth = '$searchmonthyear1' and componentanum = '$componentanum' and status <> 'deleted'";
			$exec316 = mysql_query($query316) or die ("Error in Query316".mysql_error());
			while($res316 = mysql_fetch_array($exec316))
			{
			 $totalcomponentamount = $res316['componentamount'];
			 $totalamount = $totalamount + $totalcomponentamount;
			}
			
			}
		}	
	?>
	<td align="right" class="bodytext3" width="26"><strong><?php if($totalamount > 0) { echo number_format($totalamount,0,'.',','); } ?></strong></td>	
	<?php
	}
	?>
	<?php
	$totalinsurance = '0';
	$query631 = "select insurancename from insurance_relief where employeename like '%$searchemployee%' and  status <> 'deleted' and insurancename <> ''";
	$exec631 = mysql_query($query631) or die ("Error in Query631".mysql_error());
	while($res631 = mysql_fetch_array($exec631))
	{
	$insurancename = $res631['insurancename'];
	$query601 = "select componentamount from details_employeepayroll where employeename like '%$searchemployee%' and  paymonth = '$searchmonthyear1' and componentname = '$insurancename' and status <> 'deleted'";
	$exec601 = mysql_query($query601) or die ("Error in Query601".mysql_error());
	$res601 = mysql_fetch_array($exec601);
	$res601componentamount = $res601['componentamount'];
	$totalinsurance = $totalinsurance + $res601componentamount;
	}
	?>
	<td align="right" class="bodytext3" width="26"><strong><?php if($totalinsurance > 0) { echo number_format($totalinsurance,0,'.',','); } ?></strong></td>
	<?php
	$query225 = "select auto_number from master_payrollcomponent where recordstatus <> 'deleted' order by typecode, auto_number";
	$exec225 = mysql_query($query225) or die ("Error in Query225".mysql_error());
	while($res225 = mysql_fetch_array($exec225))
	{
	$componentanum = $res225['auto_number'];
	$totalamount = '0.00';
	$res60grosspay = '0.00';
	$res61totaldeduct = '0.00';
	
		$query238 = "select a.employeename,a.employeecode from payroll_assign a,master_employee b where a.employeename  like '%$searchemployee%'  and b.departmentname LIKE '%$departmentname%' and  a.employeecode = b.employeecode  and a.status <> 'deleted' group by a.employeename";
		$exec238 = mysql_query($query238) or die ("Error in Query238".mysql_error());
		while($res238 = mysql_fetch_array($exec238))
		{	
			$searchemployeename38 = $res238['employeename'];
			$searchemployeecode38 = $res238['employeecode'];
			
			$query318 = "select employeecode from details_employeepayroll where employeecode = '$searchemployeecode38' and  paymonth = '$searchmonthyear1' and status <> 'deleted'";
			$exec318 = mysql_query($query318) or die ("Error in Query318".mysql_error());
			$res318 = mysql_fetch_array($exec318);
			$res318employeecode = $res318['employeecode'];
			
			if($res318employeecode != '')
			{
				$query608 = "select sum(componentamount) as totalgross from details_employeepayroll where employeecode = '$res318employeecode' and  paymonth = '$searchmonthyear1' and typecode = '10' and status <> 'deleted'";
				$exec608 = mysql_query($query608) or die ("Error in Query608".mysql_error());
				while($res608 = mysql_fetch_array($exec608))
				{
				$res60grosspay = $res60grosspay + $res608['totalgross'];
				}
				
				$query618 = "select sum(componentamount) as totaldeduct from details_employeepayroll where employeecode = '$res318employeecode' and  paymonth = '$searchmonthyear1' and typecode = '20' and status <> 'deleted'";
				$exec618 = mysql_query($query618) or die ("Error in Query618".mysql_error());
				while($res618 = mysql_fetch_array($exec618))
				{
				$res61totaldeduct = $res61totaldeduct + $res618['totaldeduct'];
				}
			}
		}	
	}		
	?>
	<td align="right" class="bodytext3" width="26"><strong><?php if($res60grosspay > 0) { echo number_format($res60grosspay,0,'.',','); } ?></strong></td>	
	<td align="right" class="bodytext3" width="26"><strong><?php if($res61totaldeduct > 0) { echo number_format($res61totaldeduct,0,'.',','); } ?></strong></td>	
	<?php
	$query9128 = "select auto_number from master_payrollcomponent where notional = 'Yes' and recordstatus <> 'deleted'";
	$exec9128 = mysql_query($query9128) or die ("Error in Query9128".mysql_error());
	while($res9128 = mysql_fetch_array($exec9128))
	{
	$benefitanum = $res9128['auto_number'];
	$query6118 = "select sum(componentamount) as totalbenefits from details_employeepayroll where employeename like '%$searchemployee%' and  componentanum = '$benefitanum' and paymonth = '$searchmonthyear1' and status <> 'deleted'";
	$exec6118 = mysql_query($query6118) or die ("Error in Query6118".mysql_error());
	$res6118 = mysql_fetch_array($exec6118);
	$res611benefits = $res6118['totalbenefits'];
	$nettotalbenefit = $nettotalbenefit + $res611benefits;
	}
	?>
	<td align="right" class="bodytext3"><strong><?php if($nettotalbenefit > 0) { echo number_format($nettotalbenefit,0,'.',','); } ?></strong></td>	
	<?php
	$res62totalnett = $res60grosspay - $res61totaldeduct;
	?>
	<td align="right" class="bodytext3" width="26" colspan="2"><strong><?php if($res62totalnett > 0) { echo number_format($res62totalnett-$nettotalbenefit,0,'.',','); } ?></strong></td>
	</tr>
	<?php
	}
	
	$totalamount = '0.00';
	$totalamount1 = '0.00';
	$emp = array();
	$companum = array();
	
	$query22 = "select auto_number from master_payrollcomponent where recordstatus <> 'deleted' order by typecode, auto_number";
	$exec22 = mysql_query($query22) or die ("Error in Query22".mysql_error());
	while($res22 = mysql_fetch_array($exec22))
	{
	$componentanum = $res22['auto_number'];
	$totalamount = '0.00';
	$totalamount1 = '0.00';
	
		$query237 = "select a.employeename,a.employeecode from payroll_assign a,master_employee b where a.employeename  like '%$searchemployee%'  and b.departmentname LIKE '%$departmentname%' and  a.employeecode = b.employeecode  and a.status <> 'deleted' group by a.employeename";
		$exec237 = mysql_query($query237) or die ("Error in Query237".mysql_error());
		while($res237 = mysql_fetch_array($exec237))
		{	
			$searchemployeename37 = $res237['employeename'];
			$searchemployeecode37 = $res237['employeecode'];
			
			$query317 = "select employeecode from details_employeepayroll where employeecode = '$searchemployeecode37' and  paymonth = '$searchmonthyear' and status <> 'deleted'";
			$exec317 = mysql_query($query317) or die ("Error in Query317".mysql_error());
			$res317 = mysql_fetch_array($exec317);
			$res317employeecode = $res317['employeecode'];
			
			if($res317employeecode != '')
			{
				$query37 = "select SUM(componentamount) as componentamount from details_employeepayroll where employeecode = '$res317employeecode' and  paymonth = '$searchmonthyear' and componentanum = '$componentanum' and status <> 'deleted'";
				$exec37 = mysql_query($query37) or die ("Error in Query37".mysql_error());
				$res37 = mysql_fetch_array($exec37);	
				$totalcomponentamount = $res37['componentamount'];
				
				$query375 = "select SUM(componentamount) as componentamount from details_employeepayroll where employeecode = '$res317employeecode' and  paymonth = '$searchmonthyear1' and componentanum = '$componentanum' and status <> 'deleted'";
				$exec375 = mysql_query($query375) or die ("Error in Query375".mysql_error());
				$res375 = mysql_fetch_array($exec375);
				$totalcomponentamount1 = $res375['componentamount'];
				
				if($totalcomponentamount != $totalcomponentamount1)
				{
					if (!in_array($res317employeecode, $emp))
					{
					array_push($emp, $res317employeecode);
					}
					
					if (!in_array($componentanum, $companum))
					{
					array_push($companum, $componentanum);
					}					
				}
			}
		}
	}	
	//print_r($emp);
	//print_r($companum);
	$employeebuild = implode($emp,"','");
	$employeebuild = "'".$employeebuild."'";
	$companumbuild = implode($companum,"','");
	$companumbuild = "'".$companumbuild."'";
	?>
	<!-- end of emp build -->
	<tr bgcolor="#CCC">
	<td align="center" bgcolor="#fff" colspan="30">
	<table border="0" width="50%" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tr>
	<td colspan="5" align="left" class="bodytext3"><strong>&nbsp;</strong></td>
	</tr>
	<tr bgcolor="#CCC">
	<td colspan="5" align="left" class="bodytext3"><strong>Payroll Comparison</strong></td>
	</tr>
	<tr bgcolor="#FFF">
	<td width="14%" align="left" class="bodytext3"><strong><?php echo 'Employeecode'; ?></strong></td>
	<td width="29%" align="left" class="bodytext3"><strong><?php echo 'Employeename'; ?></strong></td>
	<td width="41%" align="left" class="bodytext3"><strong><?php echo 'Description'; ?></strong></td>
	<td width="41%" align="right" class="bodytext3"><strong><?php echo 'Amount'; ?></strong></td>
	</tr>
	<tr bgcolor="#D3EEB7">
	<td colspan="5" align="center" class="bodytext3" style="border-bottom:solid 1px #000;"><strong><?php echo $searchmonthyear; ?></strong></td>
	</tr>
	<tr>
	<?php
	$query775 = "select employeecode,employeename,componentanum,componentname,componentamount from details_employeepayroll where employeecode IN ($employeebuild) and componentanum IN ($companumbuild) and paymonth = '$searchmonthyear' and  status <> 'deleted'";
	$exec775 = mysql_query($query775) or die ("Error in Query775".mysql_error());
	while($res775 = mysql_fetch_array($exec775))
	{
	$employeecode = $res775['employeecode'];
	$employeename = $res775['employeename'];
	$componentanum = $res775['componentanum'];
	$componentname = $res775['componentname'];
	$componentamount = $res775['componentamount'];
	?>
	<tr bgcolor="#D3EEB7">
	<td align="left" class="bodytext3"><?php echo $employeecode; ?></td>
	<td align="left" class="bodytext3"><?php echo $employeename; ?></td>
	<td align="left" class="bodytext3"><?php echo $componentname; ?></td>
	<td align="right" class="bodytext3"><?php echo $componentamount; ?></td>
	</tr>
	<?php
	}
	?>
	<tr bgcolor="#CBDBFA">
	<td colspan="5" align="center" class="bodytext3" style="border-bottom:solid 1px #000;"><strong><?php echo $searchmonthyear1; ?></strong></td>
	</tr>
	<?php
	$query775 = "select employeecode,employeename,componentanum,componentname,componentamount from details_employeepayroll where employeecode IN ($employeebuild) and componentanum IN ($companumbuild) and paymonth = '$searchmonthyear1' and  status <> 'deleted'";
	$exec775 = mysql_query($query775) or die ("Error in Query775".mysql_error());
	while($res775 = mysql_fetch_array($exec775))
	{
	$employeecode = $res775['employeecode'];
	$employeename = $res775['employeename'];
	$componentanum = $res775['componentanum'];
	$componentname = $res775['componentname'];
	$componentamount = $res775['componentamount'];
	?>
	<tr bgcolor="#CBDBFA">
	<td align="left" class="bodytext3"><?php echo $employeecode; ?></td>
	<td align="left" class="bodytext3"><?php echo $employeename; ?></td>
	<td align="left" class="bodytext3"><?php echo $componentname; ?></td>
	<td align="right" class="bodytext3"><?php echo $componentamount; ?></td>
	</tr>
	<?php
	}
	?>
	</table>
	</td>
	</tr>
	
	<tr>
	<td colspan="30" align="left" class="bodytext3">
	<!--<a href="print_payrollreportxl.php?<?php echo $url; ?>"><img src="images/excel-xls-icon.png" width="40" height="40"></a>-->
	</td>
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