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
$sumoftotalearnings = '0';

$month = date('M-Y');

$query81 = "select * from master_company where auto_number = '$companyanum'";
$exec81 = mysql_query($query81) or die ("Error in Query81".mysql_error());
$res81 = mysql_fetch_array($exec81);
$companycode = $res81['companycode'];
$companyname = $res81['companyname'];
function round_calc($value)
{
	$testval1 = explode(".",$value);
	$whole = $testval1[0];
	$decimal = $testval1[1];
	if($decimal > 0)
	{
		$whole = $whole + 1;
	}
	return $whole; 	 
}

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }
if (isset($_REQUEST["department"])) { $departmentname = $_REQUEST["department"]; } else { $departmentname = ""; }
if (isset($_REQUEST["type"])) { $type = $_REQUEST["type"]; } else { $type = ""; }
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
	<form name="form1" id="form1" method="post" action="payrollmonthwiseinterim.php" onSubmit="return from1submit1()">
	<table width="900" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#999999">
	<td colspan="30" align="left" class="bodytext3"><strong>Payroll Report</strong></td>
	</tr>
	<tr>
	<td width="104" align="left" class="bodytext3">Search Employee</td>
	<td colspan="4" align="left" class="bodytext3">
	<input type="hidden" name="autobuildemployee" id="autobuildemployee">
	<input type="hidden" name="searchemployeecode" id="searchemployeecode">
	<input type="text" name="searchemployee" id="searchemployee" autocomplete="off" value="<?php echo $searchemployee; ?>" size="50" style="border:solid 1px #001E6A;"></td>
	</tr>
	<tr>
	  <td align="left" class="bodytext3">Department</td>
	  <td colspan="4" align="left" class="bodytext3"><select name="department" id="department" style="border:solid 1px #001E6A;">
	  <option value="">All</option>
	  <?php
	  $query5 = "select * from master_department where recordstatus <> 'deleted' order by department";
	  $exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
	  while($res5 = mysql_fetch_array($exec5))
	  {
	  $departmentanum = $res5['auto_number'];
	  $department_name = $res5['department'];
	  ?>
	 <!-- <option value="<?php echo $departmentanum.'||'.$departmentname; ?>"><?php echo $departmentname; ?></option>-->
	 <option value="<?php echo $department_name; ?>" <?php if($departmentname == $department_name){?> selected="selected" <?php } ?>><?php echo $department_name; ?></option>

  <?php
	  }
	  ?>
	  </select></td>
	</tr>
	<tr>
	<td align="left" class="bodytext3">Search Month</td>
	<td width="58" align="left" class="bodytext3"><select name="searchmonth" id="searchmonth">
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
	<td width="63" align="left" class="bodytext3">Search Year</td>
	<td colspan="2" width="633" align="left" class="bodytext3"><select name="searchyear" id="searchyear">
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
	<td width="104" align="left" class="bodytext3">&nbsp;</td>
	<td colspan="4" width="58" align="left" class="bodytext3">
	<input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1">
	<input type="submit" name="Search" value="Submit" style="border:solid 1px #001E6A;"></td>
	</tr>
	<tr>
	<td align="left" colspan="5">&nbsp;</td>
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
		if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
		if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
		if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
		if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }

		$searchmonthyear = $searchmonth.'-'.$searchyear;
		
		$urlpath = "frmflag1=$frmflag1&&searchmonth=$searchmonth&&searchyear=$searchyear&&searchemployee=$searchemployee";
	?>
	<table border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#CCCCCC">
	<td colspan="30" align="left" class="bodytext3"><strong>PAYROLL INTERIM REPORT</strong></td>
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
	<td width="26" align="center" bgcolor="#CCCCCC" class="bodytext3"><strong>S.No</strong></td>
	<td width="101" align="center" bgcolor="#CCCCCC" class="bodytext3"><strong>EMPLOYEE CODE</strong></td>
	<td width="99" align="center" bgcolor="#CCCCCC" class="bodytext3"><strong>EMPLOYEE NAME</strong></td>
	<td width="99" align="center" bgcolor="#CCCCCC" class="bodytext3"><strong>DEPARTMENT NAME</strong></td>
	<?php
	$totalamount = '0.00';
	$totnhif10 = 0;
	$totloan = 0;
	$totgross = 0;
	$totdeduct = 0;
	$totnett = 0;	
	$datatotal['totgross'] = array();
	$datatotal['totloan'] = array();
	$datatotal['totdeduct'] = array();
	$datatotal['totnett'] = array();
	
	$query1 = "select auto_number,componentname from master_payrollcomponent where recordstatus <> 'deleted' and typecode = '10' order by typecode, auto_number";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	while($res1 = mysql_fetch_array($exec1))
	{
	$componentanum = $res1['auto_number'];
	$componentname = $res1['componentname'];
	
	$datatotal[$componentanum] = array();	
	?>
	<td align="center" bgcolor="#CCCCCC" class="bodytext3" width="184"><strong><?php echo $componentname; ?></strong></td>
	<?php
	}
	?>
	<td align="center" bgcolor="#CCCCCC" class="bodytext3" width="84"><strong>GROSS PAY</strong></td>
	<?php
	$query1d = "select auto_number,componentname from master_payrollcomponent where recordstatus <> 'deleted' and typecode = '20' order by typecode, auto_number";
	$exec1d = mysql_query($query1d) or die ("Error in Query1d".mysql_error());
	while($res1d = mysql_fetch_array($exec1d))
	{
	$componentanum1 = $res1d['auto_number'];
	$componentname1 = $res1d['componentname'];
	$datatotal[$componentanum1] = array();
	?>
	<td align="center" bgcolor="#CCCCCC" class="bodytext3" width="184"><strong><?php echo $componentname1; ?></strong></td>
	<?php
	}
	?>
	<td align="center" bgcolor="#CCCCCC" class="bodytext3" width="84"><strong><?php echo 'LOAN DEDUCTION'; ?></strong></td>
	<td align="center" bgcolor="#CCCCCC" class="bodytext3" width="84"><strong>DEDUCTIONS</strong></td>
	<td align="center" bgcolor="#CCCCCC" class="bodytext3" width="84"><strong>NETT PAY</strong></td>
	</tr>
	<?php
	$totalamount = '0.00';
	$res15amount = 0;
	$query2 = "select a.employeename as employeename,a.employeecode as employeecode,b.departmentname as departmentname,b.payrollno as payrollno from payroll_assign a,master_employee b where a.employeename  like '%$searchemployee%'  and b.departmentname LIKE '%$departmentname%' and  a.employeecode = b.employeecode and b.payrollstatus <> 'Inactive' and a.status <> 'deleted' group by a.employeecode order by b.payrollno";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	while($res2 = mysql_fetch_array($exec2))
	{	
		$searchemployeename = $res2['employeename'];
		$departmentname = $res2['departmentname'];
		$res2employeecode = $res2['employeecode'];
		$payrollno = $res2['payrollno'];
		
		$datatotal['gross'] = array();
		$datatotal['loan'] = array();
		$datatotal['deduct'] = array();
		$datatotal['nett'] = array();
		$totalpercentcalc = '0.00';
		$sumoftotalearningsfinal = '0.00';
		$sumoftotalearnings = '0.00';
		$totgrossamount = '0.00';
		$totdeductamount = '0.00';
		$totdeductamount1 = '0.00';
		$totnettpay = 0;
		
		$query777 = "select employeecode from payroll_assign where employeecode = '$res2employeecode'";
		$exec777 = mysql_query($query777) or die ("Error in Query777".mysql_error());
		$res777 = mysql_fetch_array($exec777);
		$res777employeecode = $res777['employeecode'];
		
		if($res777employeecode != '')
		{
		$res2employeename = $res2['employeename'];
		
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
	<td align="left" class="bodytext3"><?php echo $departmentname; ?></td>
	<?php
	$query3 = "select auto_number, componentname, amounttype, formula from master_payrollcomponent where recordstatus <> 'deleted' and typecode = '10' order by typecode, auto_number";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	while($res3 = mysql_fetch_array($exec3))
	{
		$componentanum = $res3['auto_number'];
		$employeesearch = $res2employeecode;
		$assignmonth = $searchmonthyear;
		
		if($employeesearch != '')
		{	
		
		$query4 = "select * from master_employee where employeecode = '$employeesearch'";
		$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		$res4 = mysql_fetch_array($exec4);
		$payrollstatus = $res4['payrollstatus'];
		if($payrollstatus == 'Active' || $payrollstatus == 'Prorata')
		{
			$query5 = "select `$componentanum` as componentvalue, auto_number, employeecode, employeename from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
			$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
			while ($res5 = mysql_fetch_array($exec5))
			{
				$anum = $res5['auto_number'];
				$componentanum = $componentanum;
				$employeecode = $res5['employeecode'];
				$employeename = $res5['employeename'];
				$componentname = $res3['componentname'];
				$componentvalue = $res5['componentvalue'];
				$amounttype = $res3['amounttype'];
				if($amounttype == 'Percent')
				{
					$formulafrom = $res3['formula'];
					if($formulafrom == '1')
					{
						$query6 = "select `$formulafrom` as componentvalue from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
						$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
						$res6 = mysql_fetch_array($exec6);
						$value = $res6['componentvalue'];
						
						$calc1 = $value * ($componentvalue/100);
						$calc1 = number_format($calc1,3,'.','');
						//$calc1 = round_calc($calc1);
						
						$query7 = "select notexceed from master_payrollcomponent where auto_number = '$componentanum'";
						$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
						$res7 = mysql_fetch_array($exec7);
						$notexceed = $res7['notexceed'];
						if($notexceed != '0.00')
						{
							if($calc1 > $notexceed)
							{
								$resamount = $notexceed;
							}
							else
							{
								$resamount = $calc1;
							}
						}
						else
						{
							$resamount = $calc1;
						}
						
					}
					else if($formulafrom == '1+2')
					{	
						$sumofcomponent = '';
						for($i=1;$i<=2;$i++)
						{
							$query9 = "select `$i` as componentamount from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
							$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
							$res9 = mysql_fetch_array($exec9);
							$res9value = $res9['componentamount'];
							$sumofcomponent = $sumofcomponent + $res9value;
						}
							$calc1 = $sumofcomponent * ($componentvalue / 100);
							$calc1 = number_format($calc1,3,'.','');
							//$calc1 = round_calc($calc1);
							
							$query10 = "select notexceed from master_payrollcomponent where auto_number = '$componentanum'";
							$exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());
							$res10 = mysql_fetch_array($exec10);
							$notexceed = $res10['notexceed'];
							if($notexceed != '0.00')
							{
								if($calc1 > $notexceed)
								{
									$resamount = $notexceed;
								}
								else
								{
									$resamount = $calc1;
								}
							}
							else
							{
								$resamount = $calc1;
							}
							
					}
					else if($formulafrom == 'Gross')
					{
						$totalgrossper = '0';
						$query121 = "select auto_number from master_payrollcomponent where typecode = '10' and recordstatus <> 'deleted'";
						$exec121 = mysql_query($query121) or die ("Error in Query121".mysql_error());
						while($res121 = mysql_fetch_array($exec121))
						{
							$auto_number = $res121['auto_number'];
							
							$query12 = "select `$auto_number` as componentamount from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
							$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
							$res12 = mysql_fetch_array($exec12);
						
							$res12value = $res12['componentamount'];
							$totalgrossper = $totalgrossper + $res12value;
						}
						$calc3 = $totalgrossper * ($componentvalue / 100);
						$calc3 = number_format($calc3,3,'.','');
						//$calc3 = round_calc($calc3);
						
						$query13 = "select notexceed from master_payrollcomponent where auto_number = '$componentanum'";
						$exec13 = mysql_query($query13) or die ("Error in Query13".mysql_error());
						$res13 = mysql_fetch_array($exec13);
						$notexceed = $res13['notexceed'];
						if($notexceed != '0.00')
						{
							if($calc3 > $notexceed)
							{
								$resamount = $notexceed;
							}
							else
							{
								$resamount = $calc3;
							}
						}
						else
						{
							$resamount = $calc3;
						}
							
					}
					else
					{
						
					}
				}	
				else
				{
					$calc1 = $componentvalue;
					$calc1 = number_format($calc1,3,'.','');
					//$calc1 = round_calc($calc1);
				}
				$sumofcomponent51 = '';
				$query16 = "select * from master_otcalculation where componentanum = '$componentanum' and status <> 'deleted'";
				$exec16 = mysql_query($query16) or die ("Error in Query16".mysql_error());
				$res16 = mysql_fetch_array($exec16);
				$rate = $res16['rate'];
				if($rate != '')
				{
					$totalhours = $res16['totalhours'];
					$totaldays = $res16['totaldays'];
					$res16formula = $res16['calculationanum'];
					if($res16formula == '1+2')
					{	
						for($j=1;$j<=2;$j++)
						{
							$query17 = "select `$j` as componentamount from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
							$exec17 = mysql_query($query17) or die ("Error in Query17".mysql_error());
							$res17 = mysql_fetch_array($exec17);
							$res17value = $res17['componentamount'];
							$sumofcomponent51 = $sumofcomponent51 + $res17value;
						}
					}
					else if($res16formula == '2')
					{
						$totalgrossper1 = '';
						$query781 = "select auto_number from master_payrollcomponent where typecode = '10' and auto_number NOT IN ('3','4') and recordstatus <> 'deleted'";
						$exec781 = mysql_query($query781) or die ("Error in Query781".mysql_error());
						while($res781 = mysql_fetch_array($exec781))
						{
							$auto_number = $res781['auto_number'];
							
							$query78 = "select `$auto_number` as componentamount from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
							$exec78 = mysql_query($query78) or die ("Error in Query78".mysql_error());
							$res78 = mysql_fetch_array($exec78);
						
							$res78value = $res78['componentamount'];
							$totalgrossper1 = $totalgrossper1 + $res78value;
						}
						
						$sumofcomponent51 = $totalgrossper1;
							
					}
					else if($res16formula == '1')
					{
						$query52 = "select `1` as componentamount from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
						$exec52 = mysql_query($query52) or die ("Error in Query52".mysql_error());
						$res52 = mysql_fetch_array($exec52);
						$res52value = $res52['componentamount'];
						$sumofcomponent51 = $sumofcomponent51 + $res52value;
					}
						$otcalculation = ($sumofcomponent51 / $totaldays / $totalhours) * $rate;
						$otcalculation = number_format($otcalculation,3,'.','');
						//$otcalculation = round_calc($otcalculation);
				}
				
				$sumofcomponent55 = '';
			
				$query18 = "select * from master_nssf where componentanum = '$componentanum' and status <> 'deleted'";
				$exec18 = mysql_query($query18) or die ("Error in Query18".mysql_error());
				$res18 = mysql_fetch_array($exec18);
				$res18amount = $res18['amount'];
				$res18percent = $res18['percent'];
				$res18basedon = $res18['basedon'];
				if($res18basedon == 'Amount')
				{	
					$res15amount = number_format($res18amount,3,'.','');
					//$res15amount = round_calc($res15amount);
					
					$query88 = "select * from master_employee where employeecode = '$employeesearch'";
					$exec88 = mysql_query($query88) or die ("Error in Query88".mysql_error());
					$res88 = mysql_fetch_array($exec88);
					$res88employeename = $res88['employeename'];
					$res88excludenssf = $res88['excludenssf'];
					
					if($res88excludenssf == 'Yes')
					{
					$res15amount = 0;
					$query59 = "update payroll_assign set `$componentanum` = '0.00' where employeecode = '$employeesearch' and status <> 'deleted'";
					$exec59 = mysql_query($query59) or die ("Error in Query59".mysql_error());
					}
					else
					{
					$query591 = "update payroll_assign set `$componentanum` = '$res15amount' where employeecode = '$employeesearch' and status <> 'deleted'";
					$exec591 = mysql_query($query591) or die ("Error in Query591".mysql_error());
					}
				}
				else if($res18basedon == 'Percent')
				{
					$totalgrossnssf1 = '';
					$query785 = "select componentamount, componentanum, monthly from payroll_assign where employeecode = '$employeesearch' and typecode = '10' and status <> 'deleted'";
					$exec785 = mysql_query($query785) or die ("Error in Query785".mysql_error());
					while($res785 = mysql_fetch_array($exec785))
					{
						$res785value = $res785['componentamount'];
						$res785anum = $res785['componentanum'];
						$res785month = $res785['monthly'];
						if($res785month == 'Yes')
						{
						$query234 = "select amount from payroll_assignmonthwise where componentanum = '$res785anum' and employeecode = '$employeesearch' and assignmonth = '$assignmonth' and status <> 'deleted'";
						$exec234 = mysql_query($query234) or die ("Error in Query234".mysql_error());
						$res234 = mysql_fetch_array($exec234);
						$monthvalue = $res234['amount'];
						$totalgrossnssf1 = $totalgrossnssf1 + $monthvalue;
						}
						else
						{
						$totalgrossnssf1 = $totalgrossnssf1 + $res785value;
						}
					}
					$totalgrossnssf1 = number_format($totalgrossnssf1,3,'.','');
					//$totalgrossnssf1 = round_calc($totalgrossnssf1);
					
					$res15amount = $totalgrossnssf1 * ($res18percent / 100);
					$res15amount = number_format($res15amount,3,'.','');
					//$res15amount = round_calc($res15amount);
					
					$query88 = "select * from master_employee where employeecode = '$employeesearch'";
					$exec88 = mysql_query($query88) or die ("Error in Query88".mysql_error());
					$res88 = mysql_fetch_array($exec88);
					$res88employeename = $res88['employeename'];
					$res88excludenssf = $res88['excludenssf'];
					
					if($res88excludenssf == 'Yes')
					{
					$res15amount = 0;
					$query59 = "update payroll_assign set `$componentanum` = '0.00' where employeecode = '$employeesearch' and status <> 'deleted'";
					$exec59 = mysql_query($query59) or die ("Error in Query59".mysql_error());
					}
					else
					{
					$query591 = "update payroll_assign set `$componentanum` = '$res15amount' where employeecode = '$employeesearch' and status <> 'deleted'";
					$exec591 = mysql_query($query591) or die ("Error in Query591".mysql_error());
					}			
				}
			}
			
			$taxableincome = '';
			//$totaldeductions = '0.00';
			$sumoftotalearningsfinal = '';
			$nssfamount = '';
			$nhifamount = '';  
			$netpay = '0.00';
			$res19absentamount = '0.00';
			$totaldeductearning = '0.00';
			$gratuity = '0.00';
			$totaldeductions = '0.00';
			
			$query311 = "select auto_number, monthly from master_payrollcomponent where auto_number = '$componentanum' and recordstatus <> 'deleted' and typecode = '10'";
			$exec311 = mysql_query($query311) or die ("Error in Query311".mysql_error());
			while ($res311 = mysql_fetch_array($exec311))
			{
				$auto_number = $res311['auto_number'];
				
				$query31 = "select `$auto_number` as componentamount from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
				$exec31 = mysql_query($query31) or die ("Error in Query31".mysql_error());
				$res31 = mysql_fetch_array($exec31);
			
				$res31componentanum = $componentanum;
				$res31monthly = $res311['monthly'];
				//$res31componentamount = $res31['componentamount'];
				if($res31monthly == 'Yes')
				{
					$query32 = "select * from payroll_assignmonthwise where componentanum = '$res31componentanum' and employeecode = '$employeesearch' and assignmonth = '$assignmonth' and status <> 'deleted' and typecode = '10'";
					$exec32 = mysql_query($query32) or die ("Error in Query32".mysql_error());
					$res32 = mysql_fetch_array($exec32);
					$rows32 = mysql_num_rows($exec32);
					$res32componentname = $res32['componentname'];
					
					if($res32componentname != '')
					{	
						$componentamount = $res32['amount'];
					}
					//else if($res31componentanum == '3' || $res31componentanum == '4')
					else
					{
						//$componentamount = $res31['componentamount'];
						$componentamount = '0.00';
					}
				}	
				else
				{
					$componentamount = $res31['componentamount'];
					//$componentamount = '0.00';
				}
				//echo '<br>'.$componentamount;	
				$sumoftotalearnings = $sumoftotalearnings + $componentamount;
			}
			
			$query671 = "select auto_number, monthly from master_payrollcomponent where auto_number = '$componentanum' and recordstatus <> 'deleted' and typecode = '10' and taxinclude = 'No'";
			$exec671 = mysql_query($query671) or die ("Error in Query671".mysql_error());
			while ($res671 = mysql_fetch_array($exec671))
			{
				$auto_number = $res671['auto_number'];
				$query67 = "select `$auto_number` as componentamount from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
				$exec67 = mysql_query($query67) or die ("Error in Query67".mysql_error());
				$res67 = mysql_fetch_array($exec67);
				
				$res67componentanum = $auto_number;
				$res67monthly = $res671['monthly'];
				//$res67componentamount = $res67['componentamount'];
				if($res67monthly == 'Yes')
				{
					$query68 = "select * from payroll_assignmonthwise where componentanum = '$res67componentanum' and employeecode = '$employeesearch' and assignmonth = '$assignmonth' and status <> 'deleted' and typecode = '10'";
					$exec68 = mysql_query($query68) or die ("Error in Query68".mysql_error());
					$res68 = mysql_fetch_array($exec68);
					$rows68 = mysql_num_rows($exec68);
					$res68componentname = $res68['componentname'];
					
					if($res68componentname != '')
					{	
						$componentamount1 = $res68['amount'];
					}
					//else if($res31componentanum == '3' || $res31componentanum == '4')
					else
					{
						//$componentamount = $res31['componentamount'];
						$componentamount1 = '0.00';
					}
				}	
				else
				{
					$componentamount1 = $res67['componentamount'];
					//$componentamount = '0.00';
				}
				//echo '<br>'.$componentamount;	
				$gratuity = $gratuity + $componentamount1;
			}
			
			$sumoftotalearnings = $sumoftotalearnings - $gratuity;
			
			$sumoftotalearnings;
			$res19absentamount = '';
			
			$query39 = "select `$componentanum` as componentamount from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
			$exec39 = mysql_query($query39) or die ("Error in Query39".mysql_error());
			while ($res39 = mysql_fetch_array($exec39))
			{
				$res39componentanum = $componentanum;
				$res39componentamount = $res39['componentamount'];
				
				$query20 = "select * from master_payrollcomponent where auto_number = '$res39componentanum'";
				$exec20 = mysql_query($query20) or die ("Error in Query20".mysql_error());
				$res20 = mysql_fetch_array($exec20);
				$res20deductearning = $res20['deductearning'];
				$res20monthly = $res20['monthly'];
				if($res20deductearning == 'Yes' && $res20monthly == 'Yes')
				{
					$query19 = "select * from payroll_assignmonthwise where componentanum = '$res39componentanum' and employeecode = '$employeesearch' and assignmonth = '$assignmonth' and status <> 'deleted'";
					$exec19 = mysql_query($query19) or die ("Error in Query19".mysql_error());
					$res19 = mysql_fetch_array($exec19);
					$rows19 = mysql_num_rows($exec19);
					$res19componentname = $res19['componentname'];
					$res19componentanum = $res19['componentanum'];
					
					if($res19componentname != '' && $res19componentanum == '5')
					{	
						$res19absentamount = $res19['amount'];
					}
					else if($res31componentanum == '5')
					{
						//$componentamount = $res31['componentamount'];
						$res19absentamount = '0.00';
					}
				}
				else if($res20deductearning == 'Yes')
				{
					$totaldeductearning = $totaldeductearning + $res39componentamount;
				}
			}
			$res19absentamount;
			$totaldeductearning;
			//echo '<br> Sum - '.$sumoftotalearnings;
			//echo '<br> abs - '.$res19absentamount;
			//echo '<br> dedu - '.$totaldeductearning;
			$sumoftotalearningsfinal = $sumoftotalearnings - $res19absentamount - $totaldeductearning;
			
			$grosspay = $sumoftotalearnings;
			$query71 = "select `7` as componentamount from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
			$exec71 = mysql_query($query71) or die ("Error in Query71".mysql_error());
			$res71 = mysql_fetch_array($exec71);
			$res71componentname = $res71['componentamount'];
			if($res71componentname != '')
			{
				$query34 = "select * from master_employee where employeecode = '$employeesearch'";
				$exec34 = mysql_query($query34) or die ("Error in Query34".mysql_error());
				$res34 = mysql_fetch_array($exec34);
				$res34excludenssf = $res34['excludenssf'];
				if($res34excludenssf == 'Yes')
				{
				$nssfamount = '0';
				}
				else
				{
				$nssfamount = $res71['componentamount'];
				}
			}
			
				$taxableincome = $sumoftotalearningsfinal - $nssfamount;
				//$taxableincome = $sumoftotalearningsfinal;
				$nhiftaxableincome = $sumoftotalearningsfinal;
				//$taxableincome = '8000';
				$totgrossamount = $taxableincome;
			
			$query72 = "select * from master_nhif where status <> 'deleted'";
			$exec72 = mysql_query($query72) or die ("Error in Query72".mysql_error());
			while($res72 = mysql_fetch_array($exec72))
			{
				$res72from = $res72['from1'];
				$res72to = $res72['to1'];
			
				if($nhiftaxableincome >= $res72from && $nhiftaxableincome <= $res72to)
				{
					$query341 = "select * from master_employee where employeecode = '$employeesearch'";
					$exec341 = mysql_query($query341) or die ("Error in Query341".mysql_error());
					$res341 = mysql_fetch_array($exec341);
					$res34excludenhif = $res341['excludenhif'];
					if($res34excludenhif == 'Yes')
					{
					$nhifamount = '0';
					}
					else
					{
					$nhifamount = $res72['amount'];
					}
				}
			}	
						
			$taxableincome;
		   $payetaxableincome = $taxableincome - $res15amount;
			$totalpercentcalc = '0.00';
			$balance = '';
			$totalbalance = 0;
			$j = '0';
			if($componentanum == '8')
			{
			
			}
			
			$totalpercentcalc;
			$taxrelief = '0.00';
			$insurancerelief = '0';
			
			//$totalpayeeamount = $totalpercentcalc - $taxrelief - $insurancerelief;
			$totalpayeeamount = $totalpercentcalc;
			$totalpayeeamount = number_format($totalpayeeamount,3,'.','');
			//$totalpayeeamount = round_calc($totalpayeeamount);
			
			$query341 = "select * from master_employee where employeecode = '$employeesearch'";
			$exec341 = mysql_query($query341) or die ("Error in Query341".mysql_error());
			$res341 = mysql_fetch_array($exec341);
			$res341excludepaye = $res341['excludepaye'];
			if($res341excludepaye == 'Yes')
			{	
				$query351 = "select * from master_dirpercent where status <> 'deleted'";
				$exec351 = mysql_query($query351) or die ("Error in Query351".mysql_error());
				$res351 = mysql_fetch_array($exec351);
				$res351dirpercent = $res351['finalamount'];
				
				$dirpercentamount = $taxableincome * ($res351dirpercent / 100);
				$totalpayeeamount = $dirpercentamount;
			}
			else
			{
				$totalpayeeamount = $totalpayeeamount;
			}
			
			if($totalpayeeamount < 0)
			{
				$totalpayeeamount = '0.00';	
			}
			else
			{
				$totalpayeeamount = $totalpayeeamount;	
			}
			
			$query74 = "select * from nhif_monthwise where status <> 'deleted' and employeecode = '$employeesearch' and assignmonth = '$assignmonth'";
			$exec74 = mysql_query($query74) or die ("Error in Query74".mysql_error());
			$res74 = mysql_fetch_array($exec74);
			$res74componentanum = $res74['componentanum'];
			if($res74componentanum == '')
			{
				$query88 = "select * from master_employee where employeecode = '$employeesearch'";
				$exec88 = mysql_query($query88) or die ("Error in Query88".mysql_error());
				$res88 = mysql_fetch_array($exec88);
				$res88employeename = $res88['employeename'];
				$res88excludenhif = $res88['excludenhif'];
				
				if($res88excludenhif == 'Yes')
				{
					$query75 = "insert into nhif_monthwise(componentanum, componentname, employeecode, employeename, assignmonth, componentamount, ipaddress, username, updatedatetime)
					values('6', 'NHIF', '$employeesearch', '$res88employeename', '$assignmonth', '0.00', '$ipaddress', '$username', '$updatedatetime')";
					$exec75 = mysql_query($query75) or die ("Error in Query75".mysql_error());
				}
				else
				{
					$query75 = "insert into nhif_monthwise(componentanum, componentname, employeecode, employeename, assignmonth, componentamount, ipaddress, username, updatedatetime)
					values('6', 'NHIF', '$employeesearch', '$res88employeename', '$assignmonth', '$nhifamount', '$ipaddress', '$username', '$updatedatetime')";
					$exec75 = mysql_query($query75) or die ("Error in Query75".mysql_error());
				}
			}
			else
			{	
				$query88 = "select * from master_employee where employeecode = '$employeesearch'";
				$exec88 = mysql_query($query88) or die ("Error in Query88".mysql_error());
				$res88 = mysql_fetch_array($exec88);
				$res88employeename = $res88['employeename'];
				$res88excludenhif = $res88['excludenhif'];
				
				if($res88excludenhif == 'Yes')
				{
					$query75 = "update nhif_monthwise set componentamount = '0.00', updatedatetime = '$updatedatetime' where componentanum = '6' and employeecode = '$employeesearch' and assignmonth = '$assignmonth'";
					$exec75 = mysql_query($query75) or die ("Error in Query75".mysql_error());
				}
				else
				{
					$query75 = "update nhif_monthwise set componentamount = '$nhifamount', updatedatetime = '$updatedatetime' where componentanum = '6' and employeecode = '$employeesearch' and assignmonth = '$assignmonth'";
					$exec75 = mysql_query($query75) or die ("Error in Query75".mysql_error());
				}
				
			}
			
			$query76 = "select * from paye_monthwise where status <> 'deleted' and employeecode = '$employeesearch' and assignmonth = '$assignmonth'";
			$exec76 = mysql_query($query76) or die ("Error in Query76".mysql_error());
			$res76 = mysql_fetch_array($exec76);
			$res76componentanum = $res76['componentanum'];
			if($res76componentanum == '')
			{	
				$query78 = "insert into paye_monthwise(componentanum, componentname, employeecode, employeename, assignmonth, componentamount, ipaddress, username, updatedatetime)
				values('8', 'PAYE', '$employeesearch', '$res88employeename', '$assignmonth', '$totalpayeeamount', '$ipaddress', '$username', '$updatedatetime')";
				$exec78 = mysql_query($query78) or die ("Error in Query78".mysql_error());
				
			}
			else
			{	
				$query77 = "update paye_monthwise set componentamount = '$totalpayeeamount', updatedatetime = '$updatedatetime' where componentanum = '8' and employeecode = '$employeesearch' and assignmonth = '$assignmonth'";
				$exec77 = mysql_query($query77) or die ("Error in Query77".mysql_error());
				
			}		
		}
		
		}
		
		$totaldeductions = '0.00';
		$query6612 = "select auto_number, monthly from master_payrollcomponent where recordstatus <> 'deleted' and typecode = '20'";
		$exec6612 = mysql_query($query6612) or die ("Error in Query6612".mysql_error());
		while ($res6612 = mysql_fetch_array($exec6612))
		{
			$auto_number = $res6612['auto_number'];
			$query661 = "select `$auto_number` as componentamount from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
			$exec661 = mysql_query($query661) or die ("Error in Query661".mysql_error());
			$res661 = mysql_fetch_array($exec661);
		
			$res661componentanum = $auto_number;
			//$res661componentamount = $res661['componentamount'];
			$res661monthly = $res6612['monthly'];
			if($res661monthly == 'Yes')
			{
				$query67 = "select * from payroll_assignmonthwise where componentanum = '$res661componentanum' and employeecode = '$employeesearch' and assignmonth = '$assignmonth' and status <> 'deleted' and typecode = '20'";
				$exec67 = mysql_query($query67) or die ("Error in Query67".mysql_error());
				$res67 = mysql_fetch_array($exec67);
				$rows67 = mysql_num_rows($exec67);
				$res67componentname = $res67['componentname'];
				
				if($res67componentname != '')
				{	
					$deductionamount = $res67['amount'];
				}
				else if($res661componentanum == '5')
				{
					//$componentamount = $res31['componentamount'];
					$deductionamount = '0.00';
				}
				else
				{
					//$componentamount = $res31['componentamount'];
					$deductionamount = '0.00';
				}
			}	
			else
			{
				$deductionamount = $res661['componentamount'];
				//$componentamount = '0.00';
			}
			
			$totaldeductions = $totaldeductions + $deductionamount;
		}
		
		$query2581 = "select * from master_payrollcomponent where auto_number = '$componentanum' and recordstatus <> 'deleted' order by typecode";
		$exec2581 = mysql_query($query2581) or die ("Error in Query2581".mysql_error());
		$res2581 = mysql_fetch_array($exec2581);
		$canum = $res2581['auto_number'];
		
		$query258 = "select `$canum` as componentvalue, employeecode, employeename from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
		$exec258 = mysql_query($query258) or die ("Error in Query258".mysql_error());
		$res258 = mysql_fetch_array($exec258);
		$employeecode = $res258['employeecode'];
		$componentname = $res2581['componentname'];
		$typecode = $res2581['typecode'];
		if($componentname != '')
		{
			$employeename = $res258['employeename'];
			$res258componentanum = $canum;
			
			$componentvalue = $res258['componentvalue'];	
			$res258monthly = $res2581['monthly'];
			if($res258monthly == 'Yes')
			{
				$query305 = "select * from payroll_assignmonthwise where componentanum = '$componentanum' and employeecode = '$employeesearch' and assignmonth = '$assignmonth' and status <> 'deleted' order by type desc";
				$exec305 = mysql_query($query305) or die ("Error in Query305".mysql_error());
				$res305 = mysql_fetch_array($exec305);
				$rows = mysql_num_rows($exec305);
				$res305componentname = $res305['componentname'];
				
				if($res305componentname != '')
				{	
					$componentrate = $res305['rate'];
					$componentunit = $res305['unit'];
					$componentamount = $res305['amount'];
				}
				//else if($res2componentanum == '3' || $res2componentanum == '4' || $res2componentanum == '5')
				else
				{
					$componentrate = $res258['componentvalue'];
					$componentunit = '0.00';
					$componentamount = '0.00';	
				}
			}	
			else
			{
				$componentrate = '0.00';
				$componentunit = '0.00';
				$componentamount = $res258['componentvalue'];
			}
			
			$query158 = "select * from nhif_monthwise where componentanum = '$componentanum' and status <> 'deleted' and employeecode = '$employeesearch' and assignmonth = '$assignmonth'";
			$exec158 = mysql_query($query158) or die ("Error in Query158".mysql_error());
			$res158 = mysql_fetch_array($exec158);
			$res158nhifamount = $res158['componentamount'];
			if($res158nhifamount != '')
			{
				$componentrate = '0.00';
				$componentunit = '0.00';
				$componentamount = $res158nhifamount;
			}
			else if($componentanum == '6')
			{
				$componentrate = '0.00';
				$componentunit = '0.00';
				$componentamount = '0.00';
			}
			
			$query188 = "select * from paye_monthwise where componentanum = '$componentanum' and status <> 'deleted' and employeecode = '$employeesearch' and assignmonth = '$assignmonth'";
			$exec188 = mysql_query($query188) or die ("Error in Query188".mysql_error());
			$res188 = mysql_fetch_array($exec188);
			$res188payeamount = $res188['componentamount'];
			if($res188payeamount != '')
			{
				$componentrate = '0.00';
				$componentunit = '0.00';
				$componentamount = $res188payeamount;
			}
			else if($componentanum == '8')
			{
				$componentrate = '0.00';
				$componentunit = '0.00';
				$componentamount = '0.00';
			}
			
			if($typecode == 10)
			{
				$totgrossamount = $totgrossamount + $componentamount;
			}
			else
			{
				$totdeductamount = $totdeductamount + $componentamount;
			}
		}
		else
		{
			$componentrate = '0.00';
			$componentunit = '0.00';
			$componentamount = '0.00';
		}	
		
		array_push($datatotal[$componentanum],$componentamount);
		array_push($datatotal['gross'],$componentamount);
		array_push($datatotal['totgross'],$componentamount);
	?>
	<td align="right" class="bodytext3" width="184"><?php if($componentamount > 0) { echo number_format($componentamount,0,'.',','); } ?></td>	
	<?php
	}	
	?>
	<td align="right" class="bodytext3" width="184"><?php if(array_sum($datatotal['gross']) > 0) { echo number_format(array_sum($datatotal['gross']),0,'.',','); } ?></td>	
	<?php
	$query3 = "select auto_number, componentname, amounttype, formula from master_payrollcomponent where recordstatus <> 'deleted' and typecode = '20' order by typecode, auto_number";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	while($res3 = mysql_fetch_array($exec3))
	{
		$componentanum = $res3['auto_number'];
		$employeesearch = $res2employeecode;
		$assignmonth = $searchmonthyear;
		
		if($employeesearch != '')
		{	
		
		$query4 = "select payrollstatus from master_employee where employeecode = '$employeesearch'";
		$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		$res4 = mysql_fetch_array($exec4);
		$payrollstatus = $res4['payrollstatus'];
		if($payrollstatus == 'Active' || $payrollstatus == 'Prorata')
		{
			$query5 = "select `$componentanum` as componentvalue, auto_number, employeecode, employeename from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
			$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
			while ($res5 = mysql_fetch_array($exec5))
			{
				$anum = $res5['auto_number'];
				$componentanum = $componentanum;
				$employeecode = $res5['employeecode'];
				$employeename = $res5['employeename'];
				$componentname = $res3['componentname'];
				$componentvalue = $res5['componentvalue'];
				$amounttype = $res3['amounttype'];
				if($amounttype == 'Percent')
				{
					$formulafrom = $res5['formula'];
					if($formulafrom == '1')
					{
						$query6 = "select `1` as componentvalue from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
						$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
						$res6 = mysql_fetch_array($exec6);
						$value = $res6['componentvalue'];
						
						$calc1 = $value * ($componentvalue/100);
						$calc1 = number_format($calc1,3,'.','');
						//$calc1 = round_calc($calc1);
						
						$query7 = "select notexceed from master_payrollcomponent where auto_number = '$componentanum'";
						$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
						$res7 = mysql_fetch_array($exec7);
						$notexceed = $res7['notexceed'];
						if($notexceed != '0.00')
						{
							if($calc1 > $notexceed)
							{
								$resamount = $notexceed;
							}
							else
							{
								$resamount = $calc1;
							}
						}
						else
						{
							$resamount = $calc1;
						}
						
					}
					else if($formulafrom == '1+2')
					{	
						$sumofcomponent = '';
						for($i=1;$i<=2;$i++)
						{
							$query9 = "select `$i` as componentamount from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
							$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
							$res9 = mysql_fetch_array($exec9);
							$res9value = $res9['componentamount'];
							$sumofcomponent = $sumofcomponent + $res9value;
						}
							$calc1 = $sumofcomponent * ($componentvalue / 100);
							$calc1 = number_format($calc1,3,'.','');
							//$calc1 = round_calc($calc1);
							
							$query10 = "select notexceed from master_payrollcomponent where auto_number = '$componentanum'";
							$exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());
							$res10 = mysql_fetch_array($exec10);
							$notexceed = $res10['notexceed'];
							if($notexceed != '0.00')
							{
								if($calc1 > $notexceed)
								{
									$resamount = $notexceed;
								}
								else
								{
									$resamount = $calc1;
								}
							}
							else
							{
								$resamount = $calc1;
							}
							
					}
					else if($formulafrom == 'Gross')
					{
						$totalgrossper = '';
						$query122 = "select auto_number from master_payrollcomponent where typecode = '10' and recordstatus <> 'deleted'";
						$exec122 = mysql_query($query122) or die ("Error in Query122".mysql_error());
						while($res122 = mysql_fetch_array($exec122))
						{
							$auto_number = $res122['auto_number'];
							$query12 = "select `$auto_number` as componentamount from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
							$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
							$res12 = mysql_fetch_array($exec12);
						
							$res12value = $res12['componentamount'];
							$totalgrossper = $totalgrossper + $res12value;
						}
						$calc3 = $totalgrossper * ($componentvalue / 100);
						$calc3 = number_format($calc3,3,'.','');
						//$calc3 = round_calc($calc3);
						
						$query13 = "select notexceed from master_payrollcomponent where auto_number = '$componentanum'";
						$exec13 = mysql_query($query13) or die ("Error in Query13".mysql_error());
						$res13 = mysql_fetch_array($exec13);
						$notexceed = $res13['notexceed'];
						if($notexceed != '0.00')
						{
							if($calc3 > $notexceed)
							{
								$resamount = $notexceed;
							}
							else
							{
								$resamount = $calc3;
							}
						}
						else
						{
							$resamount = $calc3;
						}
							
						
					}
					else
					{
						
					}
				}	
				else
				{
					$calc1 = $componentvalue;
					$calc1 = number_format($calc1,3,'.','');
					//$calc1 = round_calc($calc1);
				}
				$sumofcomponent51 = '';
				$query16 = "select * from master_otcalculation where componentanum = '$componentanum' and status <> 'deleted'";
				$exec16 = mysql_query($query16) or die ("Error in Query16".mysql_error());
				$res16 = mysql_fetch_array($exec16);
				$rate = $res16['rate'];
				if($rate != '')
				{
					$totalhours = $res16['totalhours'];
					$totaldays = $res16['totaldays'];
					$res16formula = $res16['calculationanum'];
					if($res16formula == '1+2')
					{	
						for($j=1;$j<=2;$j++)
						{
							$query17 = "select `$j` as componentamount from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
							$exec17 = mysql_query($query17) or die ("Error in Query17".mysql_error());
							$res17 = mysql_fetch_array($exec17);
							$res17value = $res17['componentamount'];
							$sumofcomponent51 = $sumofcomponent51 + $res17value;
						}
					}
					else if($res16formula == '2')
					{
						$totalgrossper1 = '';
						$query781 = "select auto_number from master_payrollcomponent where typecode = '10' and auto_number NOT IN ('3','4') and recordstatus <> 'deleted'";
						$exec781 = mysql_query($query781) or die ("Error in Query781".mysql_error());
						while($res781 = mysql_fetch_array($exec781))
						{
							$auto_number = $res781['auto_number'];
							$query78 = "select `$auto_number` as componentamount from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
							$exec78 = mysql_query($query78) or die ("Error in Query78".mysql_error());
							$res78 = mysql_fetch_array($exec78);
							$res78value = $res78['componentamount'];
							$totalgrossper1 = $totalgrossper1 + $res78value;
						}
						
						$sumofcomponent51 = $totalgrossper1;
							
					}
					else if($res16formula == '1')
					{
						$query52 = "select `1` as componentamount from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
						$exec52 = mysql_query($query52) or die ("Error in Query52".mysql_error());
						$res52 = mysql_fetch_array($exec52);
						$res52value = $res52['componentamount'];
						$sumofcomponent51 = $sumofcomponent51 + $res52value;
					}
						$otcalculation = ($sumofcomponent51 / $totaldays / $totalhours) * $rate;
						$otcalculation = number_format($otcalculation,3,'.','');
						//$otcalculation = round_calc($otcalculation);
				}
				
				$sumofcomponent55 = '';
			
				$query18 = "select * from master_nssf where componentanum = '$componentanum' and status <> 'deleted'";
				$exec18 = mysql_query($query18) or die ("Error in Query18".mysql_error());
				$res18 = mysql_fetch_array($exec18);
				$res18amount = $res18['amount'];
				$res18percent = $res18['percent'];
				$res18basedon = $res18['basedon'];
				if($res18basedon == 'Amount')
				{	
					$res15amount = number_format($res18amount,3,'.','');
					//$res15amount = round_calc($res15amount);
					
					$query88 = "select * from master_employee where employeecode = '$employeesearch'";
					$exec88 = mysql_query($query88) or die ("Error in Query88".mysql_error());
					$res88 = mysql_fetch_array($exec88);
					$res88employeename = $res88['employeename'];
					$res88excludenssf = $res88['excludenssf'];
					
					if($res88excludenssf == 'Yes')
					{
					$res15amount = 0;
					$query59 = "update payroll_assign set `$componentanum` = '0.00' where employeecode = '$employeesearch' and status <> 'deleted'";
					$exec59 = mysql_query($query59) or die ("Error in Query59".mysql_error());
					}
					else
					{
					$query591 = "update payroll_assign set `$componentanum` = '$res15amount' where employeecode = '$employeesearch' and status <> 'deleted'";
					$exec591 = mysql_query($query591) or die ("Error in Query591".mysql_error());
					}
				}
				else if($res18basedon == 'Percent')
				{
					$totalgrossnssf1 = '';
					$query7851 = "select auto_number as componentanum, monthly from master_payrollcomponent where typecode = '10' and recordstatus <> 'deleted'";
					$exec7851 = mysql_query($query7851) or die ("Error in Query7851".mysql_error());
					while($res7851 = mysql_fetch_array($exec7851))
					{
						$anum = $res7851['componentanum'];
						$query785 = "select `$anum` as componentamount from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
						$exec785 = mysql_query($query785) or die ("Error in Query785".mysql_error());
						$res785 = mysql_fetch_array($exec785);
						$res785value = $res785['componentamount'];
						$res785anum = $anum;
						$res785month = $res7851['monthly'];
						if($res785month == 'Yes')
						{
						$query234 = "select amount from payroll_assignmonthwise where componentanum = '$res785anum' and employeecode = '$employeesearch' and assignmonth = '$assignmonth' and status <> 'deleted'";
						$exec234 = mysql_query($query234) or die ("Error in Query234".mysql_error());
						$res234 = mysql_fetch_array($exec234);
						$monthvalue = $res234['amount'];
						$totalgrossnssf1 = $totalgrossnssf1 + $monthvalue;
						}
						else
						{
						$totalgrossnssf1 = $totalgrossnssf1 + $res785value;
						}
					}
					$totalgrossnssf1 = number_format($totalgrossnssf1,3,'.','');
					//$totalgrossnssf1 = round_calc($totalgrossnssf1);
					
					$res15amount = $totalgrossnssf1 * ($res18percent / 100);
					$res15amount = number_format($res15amount,3,'.','');
					//$res15amount = round_calc($res15amount);
					
					$query88 = "select employeename, excludenssf from master_employee where employeecode = '$employeesearch'";
					$exec88 = mysql_query($query88) or die ("Error in Query88".mysql_error());
					$res88 = mysql_fetch_array($exec88);
					$res88employeename = $res88['employeename'];
					$res88excludenssf = $res88['excludenssf'];
					
					if($res88excludenssf == 'Yes')
					{
					$res15amount = 0;
					$query59 = "update payroll_assign set `$componentanum` = '0.00' where employeecode = '$employeesearch' and status <> 'deleted'";
					$exec59 = mysql_query($query59) or die ("Error in Query59".mysql_error());
					}
					else
					{
					$query591 = "update payroll_assign set `$componentanum` = '$res15amount' where employeecode = '$employeesearch' and status <> 'deleted'";
					$exec591 = mysql_query($query591) or die ("Error in Query591".mysql_error());
					}			
				}
			}
			
			$taxableincome = '';
			//$totaldeductions = '0.00';
			$sumoftotalearningsfinal = '';
			$nssfamount = '';
			$nhifamount = '';  
			$netpay = '0.00';
			$res19absentamount = '0.00';
			$totaldeductearning = '0.00';
			$gratuity = '0.00';
			$totaldeductions = '0.00';
			$sumoftotalearnings = '0.00';
			$query7851 = "select auto_number as componentanum, monthly from master_payrollcomponent where typecode = '10' and recordstatus <> 'deleted'";
			$exec7851 = mysql_query($query7851) or die ("Error in Query7851".mysql_error());
			while($res7851 = mysql_fetch_array($exec7851))
			{
				$anum = $res7851['componentanum'];
				$query31 = "select `$anum` as componentamount from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
				$exec31 = mysql_query($query31) or die ("Error in Query31".mysql_error());
				$res31 = mysql_fetch_array($exec31);
				$res31componentanum = $anum;
				$res31monthly = $res7851['monthly'];
				//$res31componentamount = $res31['componentamount'];
				if($res31monthly == 'Yes')
				{
					$query32 = "select * from payroll_assignmonthwise where componentanum = '$res31componentanum' and employeecode = '$employeesearch' and assignmonth = '$assignmonth' and status <> 'deleted' and typecode = '10'";
					$exec32 = mysql_query($query32) or die ("Error in Query32".mysql_error());
					$res32 = mysql_fetch_array($exec32);
					$rows32 = mysql_num_rows($exec32);
					$res32componentname = $res32['componentname'];
					
					if($res32componentname != '')
					{	
						$componentamount = $res32['amount'];
					}
					//else if($res31componentanum == '3' || $res31componentanum == '4')
					else
					{
						//$componentamount = $res31['componentamount'];
						$componentamount = '0.00';
					}
				}	
				else
				{
					$componentamount = $res31['componentamount'];
					//$componentamount = '0.00';
				}
				//echo '<br>'.$componentamount;	
				$sumoftotalearnings = $sumoftotalearnings + $componentamount;
			}
			
			$query671 = "select auto_number from master_payrollcomponent where auto_number = '$componentanum' and recordstatus <> 'deleted' and typecode = '10' and taxinclude = 'No'";
			$exec671 = mysql_query($query671) or die ("Error in Query671".mysql_error());
			while ($res671 = mysql_fetch_array($exec671))
			{
				$auto_number = $res671['auto_number'];
				$query67 = "select `$auto_number` as componentamount from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
				$exec67 = mysql_query($query67) or die ("Error in Query67".mysql_error());
				$res67 = mysql_fetch_array($exec67);
				$res67componentanum = $auto_number;
				$res67monthly = $res671['monthly'];
				//$res67componentamount = $res67['componentamount'];
				if($res67monthly == 'Yes')
				{
					$query68 = "select * from payroll_assignmonthwise where componentanum = '$res67componentanum' and employeecode = '$employeesearch' and assignmonth = '$assignmonth' and status <> 'deleted' and typecode = '10'";
					$exec68 = mysql_query($query68) or die ("Error in Query68".mysql_error());
					$res68 = mysql_fetch_array($exec68);
					$rows68 = mysql_num_rows($exec68);
					$res68componentname = $res68['componentname'];
					
					if($res68componentname != '')
					{	
						$componentamount1 = $res68['amount'];
					}
					//else if($res31componentanum == '3' || $res31componentanum == '4')
					else
					{
						//$componentamount = $res31['componentamount'];
						$componentamount1 = '0.00';
					}
				}	
				else
				{
					$componentamount1 = $res67['componentamount'];
					//$componentamount = '0.00';
				}
				//echo '<br>'.$componentamount;	
				$gratuity = $gratuity + $componentamount1;
			}
			
			$sumoftotalearnings = $sumoftotalearnings - $gratuity;
			
			$sumoftotalearnings;
			$res19absentamount = '';
			
			$query39 = "select `$componentanum` as componentamount from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
			$exec39 = mysql_query($query39) or die ("Error in Query39".mysql_error());
			while ($res39 = mysql_fetch_array($exec39))
			{
				$res39componentanum = $componentanum;
				$res39componentamount = $res39['componentamount'];
				
				$query20 = "select * from master_payrollcomponent where auto_number = '$res39componentanum'";
				$exec20 = mysql_query($query20) or die ("Error in Query20".mysql_error());
				$res20 = mysql_fetch_array($exec20);
				$res20deductearning = $res20['deductearning'];
				$res20monthly = $res20['monthly'];
				if($res20deductearning == 'Yes' && $res20monthly == 'Yes')
				{
					$query19 = "select * from payroll_assignmonthwise where componentanum = '$res39componentanum' and employeecode = '$employeesearch' and assignmonth = '$assignmonth' and status <> 'deleted'";
					$exec19 = mysql_query($query19) or die ("Error in Query19".mysql_error());
					$res19 = mysql_fetch_array($exec19);
					$rows19 = mysql_num_rows($exec19);
					$res19componentname = $res19['componentname'];
					$res19componentanum = $res19['componentanum'];
					
					if($res19componentname != '' && $res19componentanum == '5')
					{	
						$res19absentamount = $res19['amount'];
					}
					else if($res31componentanum == '5')
					{
						//$componentamount = $res31['componentamount'];
						$res19absentamount = '0.00';
					}
				}
				else if($res20deductearning == 'Yes')
				{
					$totaldeductearning = $totaldeductearning + $res39componentamount;
				}
			}
			$res19absentamount;
			$totaldeductearning;
			//echo '<br> Sum - '.$sumoftotalearnings;
			//echo '<br> abs - '.$res19absentamount;
			//echo '<br> dedu - '.$totaldeductearning;
			$sumoftotalearningsfinal = $sumoftotalearnings - $res19absentamount - $totaldeductearning;
			
			$grosspay = $sumoftotalearnings;
			$query71 = "select `7` as componentamount from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
			$exec71 = mysql_query($query71) or die ("Error in Query71".mysql_error());
			$res71 = mysql_fetch_array($exec71);
			$res71componentname = $res71['componentamount'];
			if($res71componentname != '')
			{
				$query34 = "select excludenssf from master_employee where employeecode = '$employeesearch'";
				$exec34 = mysql_query($query34) or die ("Error in Query34".mysql_error());
				$res34 = mysql_fetch_array($exec34);
				$res34excludenssf = $res34['excludenssf'];
				if($res34excludenssf == 'Yes')
				{
				$nssfamount = '0';
				}
				else
				{
				$nssfamount = $res71['componentamount'];
				}
			}
			
				//$taxableincome = $sumoftotalearningsfinal - $nssfamount;
				$taxableincome = $sumoftotalearningsfinal;
				$nhiftaxableincome = $sumoftotalearningsfinal;
				//$taxableincome = '8000';
				$totgrossamount = $taxableincome;
			
			$query72 = "select * from master_nhif where status <> 'deleted'";
			$exec72 = mysql_query($query72) or die ("Error in Query72".mysql_error());
			while($res72 = mysql_fetch_array($exec72))
			{
				$res72from = $res72['from1'];
				$res72to = $res72['to1'];
			
				if($nhiftaxableincome >= $res72from && $nhiftaxableincome <= $res72to)
				{
					$query341 = "select excludenhif from master_employee where employeecode = '$employeesearch'";
					$exec341 = mysql_query($query341) or die ("Error in Query341".mysql_error());
					$res341 = mysql_fetch_array($exec341);
					$res34excludenhif = $res341['excludenhif'];
					if($res34excludenhif == 'Yes')
					{
					$nhifamount = '0';
					}
					else
					{
					$nhifamount = $res72['amount'];
					}
				}
			}	
						
			$taxableincome;
			$payetaxableincome = $taxableincome - $res15amount;
			$totalpercentcalc = '0.00';
			$balance = '';
			$totalbalance = 0;
			$j = '0';
			if($componentanum == '8')
			{
				
			$query73 = "select * from master_paye where status <> 'deleted'";
			$exec73 = mysql_query($query73) or die ("Error in Query73".mysql_error());
			while($res73 = mysql_fetch_array($exec73))
			{
				$res73from = $res73['from1'];
				$res73to = $res73['to1'];
				$res73percent = $res73['percent'];
				$template = 'Kenya';
				
				if($template == 'Kenya')
				{
					if($payetaxableincome >= $res73from && $payetaxableincome <= $res73to)
					{
						$difference = $res73['difference'];
						if($balance == "")
						{
							$payepercentcalc = $payetaxableincome * ($res73percent / 100);
						}
						else
						{
							$payepercentcalc = $balance * ($res73percent / 100);
						}
						$totalpercentcalc = $totalpercentcalc + $payepercentcalc;
						$j = '1';
					}
					else
					{
						if($j == '0')
						{
							$difference = $res73['difference'];
							if($balance == '')
							{
								$balance = $payetaxableincome - $difference;
							}
							else
							{
								$balance = $balance - $difference;
							}
							
							$payepercentcalc = $difference * ($res73percent / 100);
							$totalpercentcalc = $totalpercentcalc + $payepercentcalc;
						}
					}
				}
				else if($template == 'Uganda')
				{
					$res73add = $res73['addgross'];
					$res73deduct = $res73['deductgross'];
					if($payetaxableincome >= $res73from && $payetaxableincome <= $res73to)
					{
						$payepercentcalc = $res73add + (($payetaxableincome - $res73deduct) * ($res73percent / 100));   //10000+(Gross-335000)*20%
						$totalpercentcalc = $totalpercentcalc + $payepercentcalc;
					}
				}		
			}
			
				$query55 = "select * from master_taxrelief where status <> 'deleted'";
				$exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
				$res55 = mysql_fetch_array($exec55);
				$res55finalamount = $res55['finalamount'];
				if($res55finalamount != '')
				{
					$taxrelief = $res55finalamount;
				}
				$totalpercentcalc = number_format($totalpercentcalc,3,'.','');
				$totalpercentcalc = round_calc($totalpercentcalc);
				$totalpercentcalc = $totalpercentcalc - $taxrelief;
			}
			
			$totalpercentcalc;
			$taxrelief = '0.00';
			$insurancerelief = '0';
			
			//$totalpayeeamount = $totalpercentcalc - $taxrelief - $insurancerelief;
			$totalpayeeamount = $totalpercentcalc;
			$totalpayeeamount = number_format($totalpayeeamount,3,'.','');
			//$totalpayeeamount = round_calc($totalpayeeamount);
			
			$query341 = "select * from master_employee where employeecode = '$employeesearch'";
			$exec341 = mysql_query($query341) or die ("Error in Query341".mysql_error());
			$res341 = mysql_fetch_array($exec341);
			$res341excludepaye = $res341['excludepaye'];
			if($res341excludepaye == 'Yes')
			{	
				$query351 = "select * from master_dirpercent where status <> 'deleted'";
				$exec351 = mysql_query($query351) or die ("Error in Query351".mysql_error());
				$res351 = mysql_fetch_array($exec351);
				$res351dirpercent = $res351['finalamount'];
				
				$dirpercentamount = $taxableincome * ($res351dirpercent / 100);
				$totalpayeeamount = $dirpercentamount;
			}
			else
			{
				$totalpayeeamount = $totalpayeeamount;
			}
			
			if($totalpayeeamount < 0)
			{
				$totalpayeeamount = '0.00';	
			}
			else
			{
				$totalpayeeamount = $totalpayeeamount;	
			}
			
			$query74 = "select * from nhif_monthwise where status <> 'deleted' and employeecode = '$employeesearch' and assignmonth = '$assignmonth'";
			$exec74 = mysql_query($query74) or die ("Error in Query74".mysql_error());
			$res74 = mysql_fetch_array($exec74);
			$res74componentanum = $res74['componentanum'];
			if($res74componentanum == '')
			{
				$query88 = "select * from master_employee where employeecode = '$employeesearch'";
				$exec88 = mysql_query($query88) or die ("Error in Query88".mysql_error());
				$res88 = mysql_fetch_array($exec88);
				$res88employeename = $res88['employeename'];
				$res88excludenhif = $res88['excludenhif'];
				
				if($res88excludenhif == 'Yes')
				{
					$query75 = "insert into nhif_monthwise(componentanum, componentname, employeecode, employeename, assignmonth, componentamount, ipaddress, username, updatedatetime)
					values('6', 'NHIF', '$employeesearch', '$res88employeename', '$assignmonth', '0.00', '$ipaddress', '$username', '$updatedatetime')";
					$exec75 = mysql_query($query75) or die ("Error in Query75".mysql_error());
				}
				else
				{
					$query75 = "insert into nhif_monthwise(componentanum, componentname, employeecode, employeename, assignmonth, componentamount, ipaddress, username, updatedatetime)
					values('6', 'NHIF', '$employeesearch', '$res88employeename', '$assignmonth', '$nhifamount', '$ipaddress', '$username', '$updatedatetime')";
					$exec75 = mysql_query($query75) or die ("Error in Query75".mysql_error());
				}
			}
			else
			{	
				$query88 = "select * from master_employee where employeecode = '$employeesearch'";
				$exec88 = mysql_query($query88) or die ("Error in Query88".mysql_error());
				$res88 = mysql_fetch_array($exec88);
				$res88employeename = $res88['employeename'];
				$res88excludenhif = $res88['excludenhif'];
				
				if($res88excludenhif == 'Yes')
				{
					$query75 = "update nhif_monthwise set componentamount = '0.00', updatedatetime = '$updatedatetime' where componentanum = '6' and employeecode = '$employeesearch' and assignmonth = '$assignmonth'";
					$exec75 = mysql_query($query75) or die ("Error in Query75".mysql_error());
				}
				else
				{
					$query75 = "update nhif_monthwise set componentamount = '$nhifamount', updatedatetime = '$updatedatetime' where componentanum = '6' and employeecode = '$employeesearch' and assignmonth = '$assignmonth'";
					$exec75 = mysql_query($query75) or die ("Error in Query75".mysql_error());
				}
				
			}
			
			$query76 = "select * from paye_monthwise where status <> 'deleted' and employeecode = '$employeesearch' and assignmonth = '$assignmonth'";
			$exec76 = mysql_query($query76) or die ("Error in Query76".mysql_error());
			$res76 = mysql_fetch_array($exec76);
			$res76componentanum = $res76['componentanum'];
			if($res76componentanum == '')
			{	
				$query78 = "insert into paye_monthwise(componentanum, componentname, employeecode, employeename, assignmonth, componentamount, ipaddress, username, updatedatetime)
				values('8', 'PAYE', '$employeesearch', '$res88employeename', '$assignmonth', '$totalpayeeamount', '$ipaddress', '$username', '$updatedatetime')";
				$exec78 = mysql_query($query78) or die ("Error in Query78".mysql_error());
				
			}
			else
			{	
				$query77 = "update paye_monthwise set componentamount = '$totalpayeeamount', updatedatetime = '$updatedatetime' where componentanum = '8' and employeecode = '$employeesearch' and assignmonth = '$assignmonth'";
				$exec77 = mysql_query($query77) or die ("Error in Query77".mysql_error());
				
			}

		
		}
		
		}
		
		$totaldeductions = '0.00';
		$query6613 = "select auto_number, monthly from master_payrollcomponent where recordstatus <> 'deleted' and typecode = '20'";
		$exec6613 = mysql_query($query6613) or die ("Error in Query6613".mysql_error());
		while ($res6613 = mysql_fetch_array($exec6613))
		{
			$auto_number = $res6613['auto_number'];
			$query661 = "select `$auto_number` as componentamount from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
			$exec661 = mysql_query($query661) or die ("Error in Query661".mysql_error());
			$res661 = mysql_fetch_array($exec661);
			$res661componentanum = $auto_number;
			//$res661componentamount = $res661['componentamount'];
			$res661monthly = $res6613['monthly'];
			if($res661monthly == 'Yes')
			{
				$query67 = "select * from payroll_assignmonthwise where componentanum = '$res661componentanum' and employeecode = '$employeesearch' and assignmonth = '$assignmonth' and status <> 'deleted' and typecode = '20'";
				$exec67 = mysql_query($query67) or die ("Error in Query67".mysql_error());
				$res67 = mysql_fetch_array($exec67);
				$rows67 = mysql_num_rows($exec67);
				$res67componentname = $res67['componentname'];
				
				if($res67componentname != '')
				{	
					$deductionamount = $res67['amount'];
				}
				else if($res661componentanum == '5')
				{
					//$componentamount = $res31['componentamount'];
					$deductionamount = '0.00';
				}
				else
				{
					//$componentamount = $res31['componentamount'];
					$deductionamount = '0.00';
				}
			}	
			else
			{
				$deductionamount = $res661['componentamount'];
				//$componentamount = '0.00';
			}
			
			$totaldeductions = $totaldeductions + $deductionamount;
		}
		
		$query2581 = "select * from master_payrollcomponent where auto_number = '$componentanum' and recordstatus <> 'deleted' order by typecode";
		$exec2581 = mysql_query($query2581) or die ("Error in Query2581".mysql_error());
		$res2581 = mysql_fetch_array($exec2581);
		$anum = $res2581['auto_number'];
		
		$query258 = "select `$anum` as componentvalue, employeecode, employeename from payroll_assign where employeecode = '$employeesearch' and status <> 'deleted'";
		$exec258 = mysql_query($query258) or die ("Error in Query258".mysql_error());
		$res258 = mysql_fetch_array($exec258);
		$employeecode = $res258['employeecode'];
		$componentname = $res2581['componentname'];
		$typecode = $res2581['typecode'];
		if($componentname != '')
		{
			$employeename = $res258['employeename'];
			$res258componentanum = $anum;
			
			$componentvalue = $res258['componentvalue'];	
			$res258monthly = $res2581['monthly'];
			if($res258monthly == 'Yes')
			{
				$query305 = "select * from payroll_assignmonthwise where componentanum = '$componentanum' and employeecode = '$employeesearch' and assignmonth = '$assignmonth' and status <> 'deleted' order by type desc";
				$exec305 = mysql_query($query305) or die ("Error in Query305".mysql_error());
				$res305 = mysql_fetch_array($exec305);
				$rows = mysql_num_rows($exec305);
				$res305componentname = $res305['componentname'];
				
				if($res305componentname != '')
				{	
					$componentrate = $res305['rate'];
					$componentunit = $res305['unit'];
					$componentamount = $res305['amount'];
				}
				//else if($res2componentanum == '3' || $res2componentanum == '4' || $res2componentanum == '5')
				else
				{
					$componentrate = $res258['componentvalue'];
					$componentunit = '0.00';
					$componentamount = '0.00';	
				}
			}	
			else
			{
				$componentrate = '0.00';
				$componentunit = '0.00';
				$componentamount = $res258['componentvalue'];
			}
			
			$query158 = "select * from nhif_monthwise where componentanum = '$componentanum' and status <> 'deleted' and employeecode = '$employeesearch' and assignmonth = '$assignmonth'";
			$exec158 = mysql_query($query158) or die ("Error in Query158".mysql_error());
			$res158 = mysql_fetch_array($exec158);
			$res158nhifamount = $res158['componentamount'];
			if($res158nhifamount != '')
			{
				$componentrate = '0.00';
				$componentunit = '0.00';
				$componentamount = $res158nhifamount;
			}
			else if($componentanum == '6')
			{
				$componentrate = '0.00';
				$componentunit = '0.00';
				$componentamount = '0.00';
			}
			
			$query188 = "select * from paye_monthwise where componentanum = '$componentanum' and status <> 'deleted' and employeecode = '$employeesearch' and assignmonth = '$assignmonth'";
			$exec188 = mysql_query($query188) or die ("Error in Query188".mysql_error());
			$res188 = mysql_fetch_array($exec188);
			$res188payeamount = $res188['componentamount'];
			if($res188payeamount != '')
			{
				$componentrate = '0.00';
				$componentunit = '0.00';
				$componentamount = $res188payeamount;
			}
			else if($componentanum == '8')
			{
				$componentrate = '0.00';
				$componentunit = '0.00';
				$componentamount = '0.00';
			}
			
			if($typecode == 10)
			{
				$totgrossamount = $totgrossamount + $componentamount;
			}
			else
			{
				$totdeductamount = $totdeductamount + $componentamount;
			}
		}
		else
		{
			$componentrate = '0.00';
			$componentunit = '0.00';
			$componentamount = '0.00';
		}	
		
		array_push($datatotal[$componentanum],$componentamount);
		array_push($datatotal['deduct'],$componentamount);
		array_push($datatotal['totdeduct'],$componentamount);
	?>
	<td align="right" class="bodytext3" width="184"><?php if($componentamount > 0) { echo number_format($componentamount,0,'.',','); } ?></td>	
	<?php
	}	
	?>
	<?php
	$loanamount = 0;
	$res15amount = $res15amount;
	$query80 = "select sum(installmentamount) as loanamount from loan_assign where status <> 'deleted' and paymonth = '$assignmonth' and employeecode = '$employeesearch'";
	$exec80 = mysql_query($query80) or die ("Error in Query80".mysql_error());
	$res80 = mysql_fetch_array($exec80);
	$loanamount = $res80['loanamount'];	
	
	array_push($datatotal['loan'],$loanamount);
	array_push($datatotal['totloan'],$loanamount);
	$res92nettpay = array_sum($datatotal['gross']) - array_sum($datatotal['deduct']);
	
	$totloan += $loanamount;
	$totgross += $totgrossamount;
	$totdeduct += $totdeductamount;
	$totnett += $totnettpay;
	
	array_push($datatotal['nett'], $res92nettpay);
	array_push($datatotal['totnett'], $res92nettpay);
	?>
	<td align="right" class="bodytext3"><?php if($loanamount > 0){ echo number_format($loanamount,0,'.',','); } ?></td>	
	<td align="right" class="bodytext3"><?php if(array_sum($datatotal['deduct']) > 0) { echo number_format(array_sum($datatotal['deduct']),0,'.',','); } ?></td>	
	<td align="right" class="bodytext3"><?php if($res92nettpay > 0) { echo number_format($res92nettpay,0,'.',','); } ?></td>		
	<?php
	}
	}
	?>
	</tr>
	<tr bgcolor="#CCCCCC">
	<td colspan="4" align="right" class="bodytext3"><strong>Total :</strong></td>
	<?php
	$totalamount = '0.00';
	$query1 = "select auto_number from master_payrollcomponent where recordstatus <> 'deleted' and typecode = '10' order by typecode, auto_number";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	while($res1 = mysql_fetch_array($exec1))
	{
	$i = $res1['auto_number'];
	?>
	<td align="right" class="bodytext3"><strong><?php if(array_sum($datatotal[$i]) > 0) { echo number_format(array_sum($datatotal[$i]),0,'.',','); } ?></strong></td>	
	<?php
	}
	?>
	<td align="right" class="bodytext3"><strong><?php if(array_sum($datatotal['totgross']) > 0) { echo number_format(array_sum($datatotal['totgross']),0,'.',','); } ?></strong></td>
	<?php
	$query1de = "select auto_number from master_payrollcomponent where recordstatus <> 'deleted' and typecode = '20' order by typecode, auto_number";
	$exec1de = mysql_query($query1de) or die ("Error in Query1de".mysql_error());
	while($res1de = mysql_fetch_array($exec1de))
	{
	$j = $res1de['auto_number'];
	?>
	<td align="right" class="bodytext3"><strong><?php if(array_sum($datatotal[$j]) > 0) { echo number_format(array_sum($datatotal[$j]),0,'.',','); } ?></strong></td>	
	<?php
	}
	?>
	<td align="right" class="bodytext3"><strong><?php if(array_sum($datatotal['totloan']) > 0) { echo number_format(array_sum($datatotal['totloan']),0,'.',','); } ?></strong></td>
	<td align="right" class="bodytext3"><strong><?php if(array_sum($datatotal['totdeduct']) > 0) { echo number_format(array_sum($datatotal['totdeduct']),0,'.',','); } ?></strong></td>
	<td align="right" class="bodytext3"><strong><?php if(array_sum($datatotal['totnett']) > 0) { echo number_format(array_sum($datatotal['totnett']),0,'.',','); } ?></strong></td>
	</tr>
	<tr>
	<td class="bodytext31" valign="center"  align="right"><a href="print_payrollmonthwiseinterim.php?<?php echo $urlpath; ?>"><img  width="40" height="40" src="images/excel-xls-icon.png" style="cursor:pointer;"></a></td>
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

