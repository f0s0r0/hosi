<?php
session_start();
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$updatetime = date('H:i:s');
$updatedate = date('Y-m-d');
$currentdate = date('Y-m-d');
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";


if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
$visitcode=isset($_REQUEST['visitcode'])?$_REQUEST['visitcode']:'';
$patientcode=isset($_REQUEST['patientcode'])?$_REQUEST['patientcode']:'';
 $query1 = "select mipv.patientcode,mipv.accountname,mipv.visitcode,mipv.patientfullname,mipp.packagename,mipv.package,mipp.rate,mipv.billtype,mipv.locationcode,mipv.locationname from master_ippackage as mipp  LEFT JOIN master_ipvisitentry as mipv ON mipv.package = mipp.auto_number where visitcode = '".$visitcode."'  AND mipv.visitcode NOT IN (SELECT visitcode FROM billing_ip )  order by patientfullname ";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
$res1 = mysql_fetch_array($exec1);

	$res1customercode = $res1['patientcode'];
	$res1patientfullname=$res1['patientfullname'];
	$res1accountname = $res1['accountname'];
	
	$res1visitcode = $res1['visitcode'];
	$res1packagename = $res1['packagename'];
	$res1package = $res1['package'];
	$res1rate = $res1['rate'];
	$res1billtype = $res1['billtype'];
	$locationcode = $res1['locationcode'];
	$locationname = $res1['locationname'];
	
	$query111 = "select * from master_accountname where auto_number = '$res1accountname'";
	$exec111 = mysql_query($query111) or die ("Error in Query111".mysql_error());
	$res111 = mysql_fetch_array($exec111);
	$res111accountname = $res111['accountname'];

?>

<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #FFFFFF;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
<script src="js/jquery.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
.bal
{
border-style:none;
background:none;
text-align:right;
font-weight:bold;
}
.bal1
{
border-style:none;
background:none;
text-align:center;
font-weight:bold;
}
.bali
{
text-align:right;
}
</style>
</head>


<script src="js/datetimepicker_css.js"></script>
<table width="100%" border="0" cellspacing="0" cellpadding="2" style="border:solid 1px #000000;">
<tr><td colspan="5" class="bodytext3"><strong>Package Doctors</strong></td></tr>
<tr>
<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Name</td>
<td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
<?php echo $res1patientfullname;?>
</span></td>
</tr>
<tr>
<tr>
<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Code</td>
<td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
<?php echo $res1customercode;?>
</span></td>
</tr>
<tr>
<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Visitcode</td>
<td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
<?php echo $res1visitcode;?>
</span></td>
</tr>
<tr>
<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Package</td>
<td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
<?php echo $res1packagename;?>
</span></td>
</tr>
<tr>
<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Package Cost</td>
<td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
<?php echo $res1rate;?>
</span></td>
</tr>
<tr>
<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Account</td>
<td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
<?php echo $res111accountname;?>
</span></td>
</tr>
<tr>
<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Bill Type</td>
<td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
<?php echo $res1billtype;?>
</span></td>
</tr>
<tr><td colspan="5">&nbsp;</td></tr>
<tr><td colspan="5" class="bodytext3"><strong>Private Doctor</strong></td></tr>
<?php
$query112 = "select * from privatedoctor_billing where patientcode='$patientcode' and visitcode='$visitcode'";
$exec112 = mysql_query($query112) or die(mysql_error());
$privno = mysql_num_rows($exec112);
while($res112 = mysql_fetch_array($exec112))
{
$desc = $res112['description'];
$quantity = $res112['quantity'];
$rate = $res112['rate'];
$amount = $res112['amount'];
?>
<tr>
<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
<td align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
<?php echo $desc;?>
</span></td>
<td align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
<?php echo number_format($amount,2);?>
</span></td>
</tr>
<?php
}
?>		
<tr><td colspan="5">&nbsp;</td></tr>
<tr><td colspan="5" class="bodytext3"><strong>Resident Doctor</strong></td></tr>
<?php
$query132 = "select * from residentdoctor_billing where patientcode='$patientcode' and visitcode='$visitcode'";
$exec132 = mysql_query($query132) or die(mysql_error());
$privno1 = mysql_num_rows($exec132);
while($res132 = mysql_fetch_array($exec132))
{
$desc1 = $res132['description'];
$quantity1 = $res132['quantity'];
$rate1 = $res132['rate'];
$amount1 = $res132['amount'];
?>
<tr>
<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
<td align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
<?php echo $desc1;?>
</span></td>
<td align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
<?php echo number_format($amount1,2);?>
</span></td>
</tr>
<?php
}
?>			
</table>		
</body>
</html>

