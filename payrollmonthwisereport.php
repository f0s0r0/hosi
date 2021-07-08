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
	<form name="form1" id="form1" method="post" action="payrollmonthwisereport.php" onSubmit="return from1submit1()">
	<table width="900" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#999999">
	<td colspan="30" align="left" class="bodytext3"><strong>Payroll Report</strong></td>
	</tr>
	<tr>
	<td width="130" align="left" class="bodytext3">Search Employee</td>
	<td colspan="4" align="left" class="bodytext3">
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
			 <!-- <option value="<?php echo $departmentanum.'||'.$departmentname; ?>"><?php echo $departmentname; ?></option>-->
			 			 <option value="<?php echo $department_name; ?>" <?php if($departmentname == $department_name){?> selected="selected" <?php } ?>><?php echo $department_name; ?></option>

		  <?php
			  }
			  ?>
			  </select></td>
	</tr>
	<tr>
	<td align="left" class="bodytext3">Type</td>
	<td colspan="3" align="left" class="bodytext3"><select name="type" id="type" style="border:solid 1px #001E6A;">
			  <option value="Detail" <?php if($type=='Detail'){?> selected="selected" <?php }?>>Detail</option>
			  <option value="Summary" <?php if($type=='Summary'){?> selected="selected" <?php }?>>Summary</option></select></td>
			  </tr>
	<tr>
	<td align="left" class="bodytext3">Search Month</td>
	<td width="79" align="left" class="bodytext3"><select name="searchmonth" id="searchmonth">
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
	</select></td>
	<td width="61" align="left" class="bodytext3">Search Year</td>
	<td width="598" align="left" class="bodytext3"><select name="searchyear" id="searchyear">
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
	<td align="left">&nbsp;</td>
	<td colspan="3" align="left" class="bodytext3">
	<input type="hidden" name="frmflag1" id="frmflag1" value="frmflag1">
	<input type="submit" name="Search" value="Submit" style="border:solid 1px #001E6A;"></td>
	</tr>
	<tr>
	<td align="left" colspan="5">&nbsp;</td>
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
		if (isset($_REQUEST["searchemployeecode"])) { $searchemployeecode = $_REQUEST["searchemployeecode"]; } else { $searchemployeecode = ""; }
		if (isset($_REQUEST["department"])) { $departmentname = $_REQUEST["department"]; } else { $departmentname = ""; }
		if (isset($_REQUEST["type"])) { $type = $_REQUEST["type"]; } else { $type = ""; }
		if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
		if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }
        
		$searchmonthyear = $searchmonth.'-'.$searchyear;
		
		$url = "frmflag1=$frmflag1&&searchmonth=$searchmonth&&searchyear=$searchyear&&searchemployee=$searchemployee&&searchemployeecode=$searchemployeecode&&department=$departmentname&&companycode=$companycode&&type=$type";
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
	
  if($type=='Detail')
  {  
    $query2 = "select a.employeename as employeename,a.employeecode as employeecode,b.departmentname as departmentname,b.payrollno as payrollno from payroll_assign a,master_employee b where a.employeename  like '%$searchemployee%'  and b.departmentname LIKE '%$departmentname%' and  a.employeecode = b.employeecode and b.payrollstatus <> 'Inactive' and a.status <> 'deleted' group by a.employeecode order by b.payrollno";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	while($res2 = mysql_fetch_array($exec2))
	{	
		$searchemployeename = $res2['employeename'];
		$searchemployeecode = $res2['employeecode'];
		$departmentname = $res2['departmentname'];
		$payrollno = $res2['payrollno'];
		
		$datatotal['gross'] = array();
		$datatotal['loan'] = array();
		$datatotal['deduct'] = array();
		$datatotal['nett'] = array();
	
		$query31 = "select employeecode,employeename from details_employeepayroll where employeecode = '$searchemployeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
		$exec31 = mysql_query($query31) or die ("Error in Query31".mysql_error());
		$res31 = mysql_fetch_array($exec31);
		$res31employeecode = $res31['employeecode'];
		
		if($res31employeecode != '')
		{	
		$res2employeecode = $res2['employeecode'];
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
	$query1 = "select auto_number from master_payrollcomponent where recordstatus <> 'deleted' and typecode = '10' order by typecode, auto_number";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	while($res1 = mysql_fetch_array($exec1))
	{
	$componentanum = $res1['auto_number'];

	$query3 = "select employeecode,employeename, `$componentanum` as componentamount from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	$res3 = mysql_fetch_array($exec3);
	$componentamount = $res3['componentamount'];
	
	array_push($datatotal[$componentanum], $componentamount);
	array_push($datatotal['gross'], $componentamount);
	array_push($datatotal['totgross'], $componentamount);
	?>
	<td align="right" class="bodytext3" width="184"><?php if($componentamount > 0) { echo number_format($componentamount,0,'.',','); } ?></td>	
	<?php
	}
	?>
	<td align="right" class="bodytext3" width="184"><?php if(true) { echo number_format(array_sum($datatotal['gross']),0,'.',','); } ?></td>
	<?php
	$query1dd = "select auto_number from master_payrollcomponent where recordstatus <> 'deleted' and typecode = '20' order by typecode, auto_number";
	$exec1dd = mysql_query($query1dd) or die ("Error in Query1dd".mysql_error());
	while($res1dd = mysql_fetch_array($exec1dd))
	{
	$componentanum = $res1dd['auto_number'];

	$query3 = "select employeecode,employeename, `$componentanum` as componentamount from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	$res3 = mysql_fetch_array($exec3);
	$componentamount = $res3['componentamount'];
	
	array_push($datatotal[$componentanum], $componentamount);
	array_push($datatotal['deduct'], $componentamount);
	array_push($datatotal['totdeduct'], $componentamount);
	?>
	<td align="right" class="bodytext3" width="184"><?php if($componentamount > 0) { echo number_format($componentamount,0,'.',','); } ?></td>	
	<?php
	}
	?>
	<?php
	/*$query63 = "select insurancename from insurance_relief where employeecode = '$res2employeecode' and status <> 'deleted' and insurancename <> ''";
	$exec63 = mysql_query($query63) or die ("Error in Query63".mysql_error());
	$res63 = mysql_fetch_array($exec63);
	$insurancename = $res63['insurancename'];
	$query31 = "select employeecode,employeename,componentanum,componentname,componentamount from details_employeepayroll where employeecode = '$res2employeecode' and componentname = '$insurancename' and paymonth = '$searchmonthyear' and status <> 'deleted'";
	$exec31 = mysql_query($query31) or die ("Error in Query31".mysql_error());
	$res31 = mysql_fetch_array($exec31);
	
	$employeecode = $res31['employeecode'];
	$employeename = $res31['employeename'];
	$componentanum = $res31['componentanum'];
	$componentname = $res31['componentname'];
	$componentamount3 = $res31['componentamount'];*/
	$loanamount = 0;
	$query80 = "select sum(installmentamount) as loanamount from loan_assign where status <> 'deleted' and paymonth = '$searchmonthyear' and employeecode = '$res2employeecode'";
	$exec80 = mysql_query($query80) or die ("Error in Query80".mysql_error());
	$res80 = mysql_fetch_array($exec80);
	$loanamount = $res80['loanamount'];	
	array_push($datatotal['loan'],$loanamount);
	array_push($datatotal['deduct'],$loanamount);
	array_push($datatotal['totdeduct'], $loanamount);
	array_push($datatotal['totloan'], $loanamount);
	?>
	<td align="right" class="bodytext3" width="184"><?php if($loanamount > 0) { echo number_format($loanamount,0,'.',','); } ?></td>	
	<td align="right" class="bodytext3" width="184"><?php if(true) { echo number_format(array_sum($datatotal['deduct']),0,'.',','); } ?></td>	
	<?php
	$totalbenefit = '0';
	$query912 = "select auto_number from master_payrollcomponent where notional = 'Yes' and recordstatus <> 'deleted'";
	$exec912 = mysql_query($query912) or die ("Error in Query912".mysql_error());
	while($res912 = mysql_fetch_array($exec912))
	{
	$benefitanum = $res912['auto_number'];
	$query911 = "select `$benefitanum` as componentamount from details_employeepayroll where employeecode = '$res2employeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
	$exec911 = mysql_query($query911) or die ("Error in Query911".mysql_error());
	$res911 = mysql_fetch_array($exec911);
	$res911benefits = $res911['componentamount'];
	$totalbenefit = $totalbenefit + $res911benefits;
	}
	?>
	<?php
	$res92nettpay = array_sum($datatotal['gross']) - array_sum($datatotal['deduct']);
	array_push($datatotal['nett'], $res92nettpay);
	array_push($datatotal['totnett'], $res92nettpay);
	?>
	<td align="right" class="bodytext3"><?php if($res92nettpay > 0) { echo number_format($res92nettpay-$totalbenefit,0,'.',','); } ?></td>	
	<?php
	}
	}
	?>
	</tr>
	<?php 
	?>
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
	<?php 
	}
	else if($type=='Summary')
	{
	?>
	<tr bgcolor="#D3EEB7">
	<td colspan="4" align="right" class="bodytext3"><strong>Total :</strong></td>
	<?php
	$totalamount = '0.00';
	$query1 = "select auto_number from master_payrollcomponent where recordstatus <> 'deleted' and typecode = '10' order by typecode, auto_number";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	while($res1 = mysql_fetch_array($exec1))
	{
	$i = $res1['auto_number'];
	
	$query3 = "select SUM(`$i`) as componentamount from details_employeepayroll where employeename LIKE '%$searchemployee%' and paymonth = '$searchmonthyear' and status <> 'deleted'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	$res3 = mysql_fetch_array($exec3);
	$componentamount = $res3['componentamount'];
	$totgross = $totgross + $componentamount;
	?>
	<td align="right" class="bodytext3"><strong><?php if($componentamount > 0) { echo number_format($componentamount,0,'.',','); } ?></strong></td>	
	<?php
	}
	?>
	<td align="right" class="bodytext3"><strong><?php if($totgross > 0) { echo number_format($totgross,0,'.',','); } ?></strong></td>
	<?php
	$query1de = "select auto_number from master_payrollcomponent where recordstatus <> 'deleted' and typecode = '20' order by typecode, auto_number";
	$exec1de = mysql_query($query1de) or die ("Error in Query1de".mysql_error());
	while($res1de = mysql_fetch_array($exec1de))
	{
	$j = $res1de['auto_number'];
	$query3 = "select SUM(`$j`) as componentamount from details_employeepayroll where employeename LIKE '%$searchemployee%' and paymonth = '$searchmonthyear' and status <> 'deleted'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	$res3 = mysql_fetch_array($exec3);
	$componentamount = $res3['componentamount'];
	$totdeduct = $totdeduct + $componentamount;
	?>
	<td align="right" class="bodytext3"><strong><?php if($componentamount > 0) { echo number_format($componentamount,0,'.',','); } ?></strong></td>	
	<?php
	}
	$loanamount = 0;
	$query80 = "select sum(installmentamount) as loanamount from loan_assign where status <> 'deleted' and paymonth = '$searchmonthyear' and employeename LIKE '%$searchemployee%'";
	$exec80 = mysql_query($query80) or die ("Error in Query80".mysql_error());
	$res80 = mysql_fetch_array($exec80);
	$loanamount = $res80['loanamount'];	
	
	$totnett = $totgross - $totdeduct - $loanamount;
	?>
	<td align="right" class="bodytext3"><strong><?php if($loanamount > 0) { echo number_format($loanamount,0,'.',','); } ?></strong></td>
	<td align="right" class="bodytext3"><strong><?php if($totdeduct > 0) { echo number_format($totdeduct,0,'.',','); } ?></strong></td>
	<td align="right" class="bodytext3"><strong><?php if($totnett > 0) { echo number_format($totnett,0,'.',','); } ?></strong></td>
	</tr>
	<?php
	}
	?>	
	<tr>
	<td colspan="30" align="left" class="bodytext3">
	<!--<a href="print_payrollmonthwisereport.php?<?php echo $url; ?>"><img src="images/pdfdownload.jpg" height="40" width="40"></a>-->
	<a href="print_payrollreportxl.php?<?php echo $url; ?>"><img src="images/excel-xls-icon.png" width="40" height="40"></a></td>
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

