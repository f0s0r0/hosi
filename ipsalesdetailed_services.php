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

if (isset($_REQUEST["category"])) { $scategory = $_REQUEST["category"]; } else { $scategory = ""; }


$categoryanum='';
$add_query='';
					$query02="select auto_number from  master_categoryservices where categoryname = '$scategory' ";
					$exec02=mysql_query($query02) or die("q1".mysql_error());
					if($res02=mysql_fetch_array($exec02)){
						$categoryanum=$res02['auto_number'];	
					
					$add_query=" and servicecategory = '$categoryanum'";
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
    <td colspan="10" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
  <td width="1">&nbsp;</td>
  <td width="999" colspan="10">
   <?php
	  $query341 = "select auto_number from master_employee where username = '$username' and statistics='on'";
				 $exec341 = mysql_query($query341) or die ("Error in Query34".mysql_error());
				 $res341 = mysql_fetch_array($exec341);
				 $rowcount341 = mysql_num_rows($exec341);
				 if($rowcount341 > 0)
				 {
	  ?>
<table width="951"  border="0" cellpadding="2" cellspacing="0">
<tr>
	<td>&nbsp;</td>
</tr>

 <tr>
	<td colspan="10" bgcolor="#fff"  class="bodytext31" > <strong> <?= $scategory ?></strong></td>
</tr>	

<tr>
	<td colspan="10" bgcolor="#fff"  class="bodytext31" > <strong> Cash Patients</strong></td>
</tr>

  <tr>
    <td width="40" bgcolor="#ffffff" align="center" class="bodytext31"><strong>Sno</strong></td>
    <td width="72" bgcolor="#ffffff" class="bodytext31"><strong>Date</strong></td>
    <td width="139" bgcolor="#ffffff" class="bodytext31"><strong>Patient Name</strong></td>
    <td width="83"  bgcolor="#ffffff" class="bodytext31"><strong>Patient Code</strong></td>
    <td width="91" bgcolor="#ffffff" class="bodytext31"><strong>Visit Code</strong></td>
    <td width="130" bgcolor="#ffffff" class="bodytext31"><strong>Account</strong></td>
    <td width="163" bgcolor="#ffffff" class="bodytext31"><strong>Test Name</strong></td>
    <td width="76" bgcolor="#ffffff" class="bodytext31" align="right"><strong>Rate</strong></td>
    <td width="46" bgcolor="#ffffff" class="bodytext31" align="right"><strong>Qty</strong></td>
    <td width="71" bgcolor="#ffffff" class="bodytext31" align="right"><strong>Amount</strong></td>
   
  </tr>

  <?php
  $sno=0;
  $colorloopcount = '';
  $paynowamount=0;
  $paylateramount=0;
  $newamount=0;
  $querypaynow="select servicesitemrate as amount,servicesitemrate,patientcode,patientvisitcode,patientname,billdate,accountname,servicesitemname from  billing_ipservices where billdate between '$ADate1' and '$ADate2' ";
		  $execpaynow = mysql_query($querypaynow) or die(mysql_error());
		  while($respaynow = mysql_fetch_array($execpaynow))
		  {
		   $patientcode= $respaynow['patientcode'];
		   $patientvisitcode1= $respaynow['patientvisitcode'];
		   $patientname= $respaynow['patientname'];
		   $billdate= $respaynow['billdate'];
		   $accountname= $respaynow['accountname'];
   		   $servicesitemname=$respaynow['servicesitemname'];
		   $amount= $respaynow['amount'];
		   $servicesitemrate= $respaynow['servicesitemrate'];
		   $serviceqty= 1;
			 $qry=mysql_query("select billtype from master_ipvisitentry where visitcode='$patientvisitcode1' group by visitcode") or die("Error in qry".mysql_error());
		$exeqry=mysql_fetch_array($qry);		   
		$billtype=$exeqry['billtype'];
		if($billtype=="PAY NOW")
		{	   	   
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
    <td align="center" width="40"><?php echo $sno+=1;?></td>
    <td width="72"><?php echo $billdate; ?></td>
    <td width="139"><?php echo $patientname; ?></td>
    <td width="83"><?php echo $patientcode ;?></td>
    <td width="91"><?php echo $patientvisitcode1; ?></td>
    <td width="130"><?php echo $accountname; ?></td>
    <td width="163"><?php echo $servicesitemname; ?></td>
    <td width="76" align="right"><?php echo number_format($servicesitemrate); ?></td>
    <td width="46" align="right"><?php echo number_format($serviceqty,0); ?></td>    
    
    <td width="71" align="right"><?php echo $amount; ?></td>
    
  </tr>
  <?php }} }?>

   <tr class="bodytext31">
    <td colspan="7">&nbsp;</td>
    <td colspan="2"><strong>Cash Total:</strong></td>
    <td align="right"><?php echo number_format($paynowamount,2,'.',',');?></td>
  </tr>
		
<tr>
	<td colspan="10" bgcolor="#fff"  class="bodytext31" > <strong> Credit Patients </strong></td>
</tr>

  <tr>
    <td width="40" bgcolor="#ffffff" align="center" class="bodytext31"><strong>Sno</strong></td>
    <td width="72" bgcolor="#ffffff" class="bodytext31"><strong>Date</strong></td>
    <td width="139" bgcolor="#ffffff" class="bodytext31"><strong>Patient Name</strong></td>
    <td width="83"  bgcolor="#ffffff" class="bodytext31"><strong>Patient Code</strong></td>
    <td width="91" bgcolor="#ffffff" class="bodytext31"><strong>Visit Code</strong></td>
    <td width="130" bgcolor="#ffffff" class="bodytext31"><strong>Account</strong></td>
    <td width="163" bgcolor="#ffffff" class="bodytext31"><strong>Test Name</strong></td>
    <td width="76" bgcolor="#ffffff" class="bodytext31" align="right"><strong>Rate</strong></td>
    <td width="46" bgcolor="#ffffff" class="bodytext31" align="right"><strong>Qty</strong></td>
    <td width="71" bgcolor="#ffffff" class="bodytext31" align="right"><strong>Amount</strong></td>
   
  </tr>

  <?php
     $querypaylater="select servicesitemrate as amount,servicesitemrate,patientcode,patientvisitcode,patientname,billdate,accountname,servicesitemname from  billing_ipservices where billdate between '$ADate1' and '$ADate2' "; 
		  $execpaylater = mysql_query($querypaylater) or die(mysql_error());
		   $numrows=mysql_num_rows($execpaylater);
		  while($respaylater = mysql_fetch_array($execpaylater))
		  {
		    $patientcode1= $respaylater['patientcode'];
		   $patientvisitcode1= $respaylater['patientvisitcode'];
		   $patientname1= $respaylater['patientname'];
		   $billdate1= $respaylater['billdate'];
		   $amount1= $respaylater['amount'];
$qry1=mysql_query("select billtype from master_ipvisitentry where visitcode='$patientvisitcode1' group by visitcode") or die("Error in qry".mysql_error());
		$exeqry1=mysql_fetch_array($qry1);		   
		$billtype1=$exeqry1['billtype'];
		if($billtype1<>"PAY NOW")
		{
		   
		     $accountname= $respaylater['accountname'];
   		   $servicesitemname=$respaylater['servicesitemname'];
		   $servicesitemrate= $respaylater['servicesitemrate'];
		   $serviceqty= 1;

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
    <td align="center" width="40"><?php echo $sno+=1;?></td>
    <td width="72"><?php echo $billdate1; ?></td>
    <td width="139"><?php echo $patientname1; ?></td>
    <td width="83"><?php echo $patientcode1; ?></td>
    <td width="91"><?php echo $patientvisitcode1; ?></td>
    <td width="130"><?php echo $accountname; ?></td>
    <td width="163"><?php echo $servicesitemname; ?></td>
    <td width="76" align="right"><?php echo number_format($servicesitemrate); ?></td>
    <td width="46" align="right"><?php echo number_format($serviceqty,0); ?></td>    
    <td width="71" align="right"><?php echo number_format($amount1); ?></td>
    
  </tr>
   <?php }} }?>

   <?php
   $newamount=$paynowamount+$paylateramount;
   
   ?>
   <tr class="bodytext31">
    <td colspan="7">&nbsp;</td>
    <td colspan="2"><strong>Credit Total:</strong></td>
    <td align="right"><?php echo number_format($paylateramount,2,'.',',');?></td>
  </tr>
  
  <tr class="bodytext31" bgcolor="#fff">
    <td colspan="8">&nbsp;</td>
    <td><strong>Grand Total:</strong></td>
    <td align="right"><?php echo number_format($newamount,2,'.',',');?></td>
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

