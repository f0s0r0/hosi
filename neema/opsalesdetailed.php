<?php
session_start();
//echo session_id();
include ("db/db_connect.php");
include ("includes/loginverify.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username=$_SESSION["username"];
$registrationdate = date('Y-m-d');
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];

$locationcode1=$_REQUEST['locationcode'];
$ADate1=$_REQUEST['adate1'];
$ADate2=$_REQUEST['adate2'];


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

.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">

function process1login1()
{
	if (document.form1.username.value == "")
	{
		alert ("Pleae Enter Your Login.");
		document.form1.username.focus();
		return false;
	}
	else if (document.form1.password.value == "")
	{	
		alert ("Pleae Enter Your Password.");
		document.form1.password.focus();
		return false;
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

<body>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td width="99" colspan="10" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
  <td>&nbsp;</td>
  <td colspan="10">
   <?php
	  $query341 = "select * from master_employee where username = '$username' and statistics='on'";
				 $exec341 = mysql_query($query341) or die ("Error in Query34".mysql_error());
				 $res341 = mysql_fetch_array($exec341);
				 $rowcount341 = mysql_num_rows($exec341);
				 if($rowcount341 > 0)
				 {
	  ?>
<table width="680"  border="0" cellpadding="2" cellspacing="0">
<tr>
	<td>&nbsp;</td>
</tr>
  <tr>
    <td width="62" bgcolor="#ffffff" align="center" class="bodytext31"><strong>Sno</strong></td>
    <td width="84" bgcolor="#ffffff" class="bodytext31"><strong>Date</strong></td>
    <td width="97"  bgcolor="#ffffff" class="bodytext31"><strong>PatientCode</strong></td>
    <td width="114" bgcolor="#ffffff" class="bodytext31"><strong>Visitcode</strong></td>
    <td width="196" bgcolor="#ffffff" class="bodytext31"><strong>PatientName</strong></td>
    <td width="103" bgcolor="#ffffff" class="bodytext31"><strong>Amount</strong></td>
   
  </tr>
  <?php
  $sno=0;
  $colorloopcount = '';
  $paynowamount=0;
  $paylateramount=0;
  $newamount=0;
  $queryvisit="select patientvisitcode from billing_paynowpharmacy where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2' group by patientvisitcode";
  $execvisit = mysql_query($queryvisit) or die(mysql_error());
   while($resvisit = mysql_fetch_array($execvisit))
		  {
  			$newpatientvisitcode= $resvisit['patientvisitcode'];
   $querypaynow=  "select patientcode,patientvisitcode,patientname,billdate,sum(amount) as amount from billing_paynowpharmacy where locationcode='$locationcode1' and  billdate between '$ADate1' and '$ADate2' and patientvisitcode='$newpatientvisitcode'";
		  $execpaynow = mysql_query($querypaynow) or die(mysql_error());
		  while($respaynow = mysql_fetch_array($execpaynow))
		  {
		   $patientcode= $respaynow['patientcode'];
		   $patientvisitcode= $respaynow['patientvisitcode'];
		   $patientname= $respaynow['patientname'];
		   $billdate= $respaynow['billdate'];
		   $amount= $respaynow['amount'];
		   
		   $paynowamount+=$amount;
		   if($amount>0)
		   {
			   $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
			
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else

			{
				//echo "else";
				$colorcode = 'bgcolor="#D3EEB7"';
			}
			
			   
  ?>
  <tr <?php echo $colorcode; ?> class="bodytext31">
    <td align="center" width="62"><?php echo $sno+=1;?></td>
    <td width="84"><?php echo $billdate; ?></td>
    <td width="97"><?php echo $patientcode ;?></td>
    <td width="114"><?php echo $patientvisitcode; ?></td>
    <td width="196"><?php echo $patientname; ?></td>
    <td width="103"><?php echo $amount; ?></td>
    
  </tr>
  <?php }}}?>
  <?php
   $queryvisit1="select patientvisitcode from billing_paylaterpharmacy where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2' group by patientvisitcode";
  $execvisit1 = mysql_query($queryvisit1) or die(mysql_error());
   while($resvisit1 = mysql_fetch_array($execvisit1))
		  {
  			$newpatientvisitcode1= $resvisit1['patientvisitcode'];
     $querypaylater=  "select patientcode,patientvisitcode,patientname,billdate,sum(amount) as amount from billing_paylaterpharmacy where locationcode='$locationcode1' and  billdate between '$ADate1' and '$ADate2' and patientvisitcode='$newpatientvisitcode1'";
		  $execpaylater = mysql_query($querypaylater) or die(mysql_error());
		   $numrows=mysql_num_rows($execpaylater);
		  while($respaylater = mysql_fetch_array($execpaylater))
		  {
		    $patientcode1= $respaylater['patientcode'];
		   $patientvisitcode1= $respaylater['patientvisitcode'];
		   $patientname1= $respaylater['patientname'];
		   $billdate1= $respaylater['billdate'];
		   $amount1= $respaylater['amount'];
		   $paylateramount+=$amount1;
		   if($amount1>0)
		   {
			    $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			
			
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else

			{
				//echo "else";
				$colorcode = 'bgcolor="#D3EEB7"';
			}
  ?>
  <tr <?php echo $colorcode; ?> class="bodytext31">
    <td align="center" width="62"><?php echo $sno+=1;?></td>
    <td width="84"><?php echo $billdate1; ?></td>
    <td width="97"><?php echo $patientcode1; ?></td>
    <td width="114"><?php echo $patientvisitcode1; ?></td>
    <td width="196"><?php echo $patientname1; ?></td>
    <td width="103"><?php echo number_format($amount1); ?></td>
    
  </tr>
   <?php }} }?>
   <?php
   $newamount=$paynowamount+$paylateramount;
   
   ?>
  <tr class="bodytext31">
    <td colspan="4">&nbsp;</td>
    <td><strong>Total:</strong></td>
    <td><?php echo number_format($newamount,2,'.',',');?></td>
  </tr>
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

