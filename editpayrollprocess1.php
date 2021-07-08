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
$bgcolorcode = "";
$colorloopcount = "";

$month = date('M-Y');

if (isset($_REQUEST["searchemployee"])) { $searchemployee = $_REQUEST["searchemployee"]; } else { $searchemployee = ""; }
if (isset($_REQUEST["searchemployeecode"])) { $searchemployeecode = $_REQUEST["searchemployeecode"]; } else { $searchemployeecode = ""; }
if (isset($_REQUEST["searchmonth"])) { $searchmonth = $_REQUEST["searchmonth"]; } else { $searchmonth = date('M'); }
if (isset($_REQUEST["searchyear"])) { $searchyear = $_REQUEST["searchyear"]; } else { $searchyear = date('Y'); }

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }

//$frmflag1 = $_REQUEST['frmflag1'];
if ($frmflag1 == 'frmflag1')
{
	
}

if($frmflag2 == 'frmflag2')
{
	$employeecode = $_REQUEST['employeecode'];
	$employeename = $_REQUEST['employeename'];
	$editmonthyear = $_REQUEST['editmonthyear'];
	
	for($k=1;$k<100;$k++)
	{
		if(isset($_REQUEST['serialnumber'.$k]))
		{	
			$serialnumber = $_REQUEST['serialnumber'.$k];
			
			if($serialnumber != '')
			{
				$componentname = $_REQUEST['componentname'.$k];
				$componentrate = $_REQUEST['componentrate'.$k];
				$componentunit = $_REQUEST['componentunit'.$k];
				$componentamount = $_REQUEST['componentamount'.$k];
				
				
			}
			
		}
		
	}
	
	header('location:editpayrollprocess1.php?st=success');
	
}			



if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == 'del')
{
	$delanum = $_REQUEST['anum'];
	$query5 = "delete from details_employeepayroll where auto_number = '$delanum'";
	$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
}
if ($st == 'activate')
{
	$anum = $_REQUEST['anum'];
	$query6 = "update details_employeepayroll set status = '' where auto_number = '$anum'";
	$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
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
<script type="text/javascript" src="js/autosuggestemployeereportsearch2.js"></script>
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
	<form name="form1" id="form1" method="post" action="editpayrollprocess1.php" onSubmit="return from1submit1()">
	<table width="900" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#999999">
	<td colspan="30" align="left" class="bodytext3"><strong>Edit Payroll Process</strong></td>
	</tr>
	<tr>
	<td width="95" align="left" class="bodytext3">Search Employee</td>
	<td colspan="4" align="left" class="bodytext3">
	<input type="hidden" name="autobuildemployee" id="autobuildemployee">
	<input type="hidden" name="searchemployeecode" id="searchemployeecode" value="<?php echo $searchemployeecode; ?>">
	<input type="text" name="searchemployee" id="searchemployee" autocomplete="off" value="<?php echo $searchemployee; ?>" size="50" style="border:solid 1px #001E6A;"></td>
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
	if($frmflag1 == 'frmflag1')
	{
		$searchmonthyear = $searchmonth.'-'.$searchyear; 
		
		$url = "searchmonth=$searchmonth&&searchyear=$searchyear&&frmflag1=$frmflag1&&searchemployeecode=$searchemployeecode";
	?>
	<form name="form2" action="editpayrollprocess1.php" method="post">	
	<table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#999999">
	<td colspan="30" align="left" class="bodytext3"><strong>Payroll Components</strong></td>
	</tr>
	<tr>
	<td width="24" align="center" bgcolor="#CCCCCC" class="bodytext3"><strong>&nbsp;</strong></td>
	<td width="290" align="left" bgcolor="#CCCCCC" class="bodytext3"><strong>Description</strong></td>
	<td width="69" align="center" bgcolor="#CCCCCC" class="bodytext3"><strong>Rate</strong></td>
	<td width="56" align="center" bgcolor="#CCCCCC" class="bodytext3"><strong>Unit</strong></td>
	<td width="62" align="center" bgcolor="#CCCCCC" class="bodytext3"><strong>Amount</strong></td>
	<td width="37" align="center" bgcolor="#CCCCCC" class="bodytext3"><strong>Delete</strong></td>
	</tr>
	<input type="hidden" name="employeecode" id="employeecode" value="<?php echo $searchemployeecode;?>">
	<input type="hidden" name="employeename" id="employeename" value="<?php echo $searchemployee;?>">
	<input type="hidden" name="editmonthyear" id="editmonthyear" value="<?php echo $searchmonthyear;?>">
	<?php
	$totalamount = '0.00';
	$sno = '';
	$query3 = "select * from details_employeepayroll where employeecode = '$searchemployeecode' and paymonth = '$searchmonthyear' and status <> 'deleted'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	while($res3 = mysql_fetch_array($exec3))
	{
	$sno = $sno + 1;
	$auto_number = $res3['auto_number'];
	$employeecode = $res3['employeecode'];
	$employeename = $res3['employeename'];
	$componentanum = $res3['componentanum'];
	$componentname = $res3['componentname'];
	$componentrate = $res3['componentrate'];
	$componentunit = $res3['componentunit'];
	$componentamount = $res3['componentamount'];
	
	$totalamount = $totalamount + $componentamount;
	?>
	<tr bgcolor="#FFFFFF">
	<td align="left" class="bodytext3"><input type="hidden" name="serialnumber<?php echo $sno; ?>" id="serialnumber<?php echo $sno; ?>" value="<?php echo $auto_number; ?>" size="1" readonly="readonly" style="border:none;text-align:center;"></td>
	<td align="left" class="bodytext3"><input type="text" name="componentname<?php echo $sno; ?>" id="componentname<?php echo $sno; ?>" value="<?php echo $componentname; ?>" size="30" readonly="readonly" style="border:none;text-align:left;"></td>
	<td align="right" class="bodytext3"><input type="text" name="componentrate<?php echo $sno; ?>" id="componentrate<?php echo $sno; ?>" value="<?php echo $componentrate; ?>" size="6" style="border:solid 1px #001E6A;text-align:right;"></td>
	<td align="right" class="bodytext3"><input type="text" name="componentunit<?php echo $sno; ?>" id="componentunit<?php echo $sno; ?>" value="<?php echo $componentunit; ?>" size="2" style="border:solid 1px #001E6A;text-align:right;"></td>
	<td align="right" class="bodytext3"><input type="text" name="componentamount<?php echo $sno; ?>" id="componentamount<?php echo $sno; ?>" value="<?php echo $componentamount; ?>" size="8" style="border:solid 1px #001E6A;text-align:right;"></td>
	<td align="right" class="bodytext3"><div align="center"><a href="editpayrollprocess1.php?st=del&&anum=<?php echo $auto_number; ?>&&<?php echo $url; ?>"><img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>
	</tr>
	<?php
	}
	?>
	<tr>
	<td colspan="6" align="left" class="bodytext3">&nbsp;</td>
	</tr>
	<tr>
	<td colspan="6" align="left" class="bodytext3">
	<input type="hidden" name="frmflag2" id="frmflag2" value="frmflag2">
	<input type="submit" name="submit123" value="Submit" style="border:solid 1px #001E6A;"></td>
	</tr>
	<tr>
	<td colspan="6" align="left" class="bodytext3">&nbsp;</td>
	</tr>
	</tbody>
	</table> 
	<table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
	<tbody>
	<tr bgcolor="#999999">
	<td colspan="30" align="left" class="bodytext3"><strong>Payroll Components - Deleted</strong></td>
	</tr>
	<tr>
	<td width="24" align="center" bgcolor="#CCCCCC" class="bodytext3"><strong>S.No</strong></td>
	<td width="290" align="left" bgcolor="#CCCCCC" class="bodytext3"><strong>Description</strong></td>
	<td width="69" align="right" bgcolor="#CCCCCC" class="bodytext3"><strong>Rate</strong></td>
	<td width="56" align="right" bgcolor="#CCCCCC" class="bodytext3"><strong>Unit</strong></td>
	<td width="62" align="right" bgcolor="#CCCCCC" class="bodytext3"><strong>Amount</strong></td>
	<td width="37" align="right" bgcolor="#CCCCCC" class="bodytext3"><strong>Activate</strong></td>
	</tr>
	<?php
	$totalamount = '0.00';
	$dno = '';
	$query4 = "select * from details_employeepayroll where employeecode = '$searchemployeecode' and paymonth = '$searchmonthyear' and status = 'deleted'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	while($res4 = mysql_fetch_array($exec4))
	{
	$dno = $dno + 1;
	$anum = $res4['auto_number'];
	$employeecode = $res4['employeecode'];
	$employeename = $res4['employeename'];
	$componentanum = $res4['componentanum'];
	$componentname = $res4['componentname'];
	$componentrate = $res4['componentrate'];
	$componentunit = $res4['componentunit'];
	$componentamount = $res4['componentamount'];
	
	$totalamount = $totalamount + $componentamount;
	?>
	<tr bgcolor="#FFFFFF">
	<td align="left" class="bodytext3"><?php echo $dno; ?></td>
	<td align="left" class="bodytext3"><?php echo $componentname; ?></td>
	<td align="right" class="bodytext3"><?php echo $componentrate; ?></td>
	<td align="right" class="bodytext3"><?php echo $componentunit; ?></td>
	<td align="right" class="bodytext3"><?php echo $componentamount; ?></td>
	<td align="right" class="bodytext3"><div align="center"><a href="editpayrollprocess1.php?st=activate&&anum=<?php echo $anum; ?>&&<?php echo $url; ?>">Activate</a></div></td>
	</tr>
	<?php
	}
	?>
	<tr>
	<td colspan="6" align="left" class="bodytext3">&nbsp;</td>
	</tr>
	</tbody>
	</table> 
	</form>
	<?php
	}
	?>
	</td>
  	</tr>
    </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

