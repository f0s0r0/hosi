<?php
session_start();

//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];

$titlestr = 'SALES BILL';
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
	//get locationcode and locationname for inserting
//$locationcodeget=isset($_REQUEST['locationcodeget'])?$_REQUEST['locationcodeget']:'';
//$locationnameget=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';
//get ends here
    $visitcode=$_REQUEST["visitcode"];
	$patientcode = $_REQUEST["customercode"];
	$patientname = $_REQUEST["customername"];
	$consultationdate = date("Y-m-d");
	$accountname = $_REQUEST["account"];
	
	for($i=0;$i<20;$i++)
					{
				if(isset($_POST['pharmacycheck'][$i]))
		{
		$pharmacyanum = $_POST['pharmacyanum'][$i];
		$pharmacyitemcode= $_POST['pharmacyitemcode'][$i];
		$pharmacyanumcheck = $pharmacyanum;
		
		if($pharmacyanum == $pharmacyanumcheck)
	    {	
			
		if(($pharmacyanum!="")&&($pharmacyitemcode!=""))
		{
		
		$pharmacyquery1="update pharmacysalesreturn_details set refundapprove='approved' where auto_number='$pharmacyanum' and visitcode='$visitcode'";
		$pharmacyquery2=mysql_query($pharmacyquery1) or die(mysql_error());
		
		$query39=mysql_query("update master_visitentry set itemrefund='refund' where visitcode='$visitcode'") or die(mysql_error());

		}
		}
		}
		}
	
		for($i=0;$i<20;$i++)
					{
				if(isset($_POST['labcheck'][$i]))
		{
		$labanum = $_POST['labanum'][$i];
		$labitemcode= $_POST['labitemcode'][$i];
		$labanumcheck = $labanum;
		
		if($labanum == $labanumcheck)
	    {	
			
		if(($labanum!="")&&($labitemcode!=""))
		{
		
		$labquery1="update consultation_lab set refundapproval='approved' where auto_number='$labanum' and patientvisitcode='$visitcode'";
		$labquery1=mysql_query($labquery1) or die(mysql_error());
		
		$query39=mysql_query("update master_visitentry set itemrefund='refund' where visitcode='$visitcode'") or die(mysql_error());

		}
		}
		}
		}
		for($i=0;$i<20;$i++)
		{			
		if(isset($_POST['radcheck'][$i]))
		{ 
		$radanum = $_POST['radanum'][$i];
		$raditemcode= $_POST['raditemcode'][$i];
		$radanumcheck = $radanum;
		if($radanum == $radanumcheck)
	    {	
		
		if(($radanum!="")&&($raditemcode!=""))
		{
		$radiologyquery1="update consultation_radiology set refundapprove='approved' where auto_number='$radanum' and patientvisitcode='$visitcode'";
		$radiologyexecquery1=mysql_query($radiologyquery1) or die(mysql_error());
		
		$query39=mysql_query("update master_visitentry set itemrefund='refund' where visitcode='$visitcode'") or die(mysql_error());

		}
		}
		}
		}
		for($i=0;$i<20;$i++)
		{
		if(isset($_POST['servicescheck'][$i]))
		{ 
		$servicesanum = $_POST['servicesanum'][$i];
		$servicesitemcode= $_POST['servicesitemcode'][$i];
		
		$servicesanumcheck = $servicesanum;
		if($servicesanum == $servicesanumcheck)
	    {	
			
		if(($servicesanum!="")&&($servicesitemcode!=""))
		{
		
		$servicesquery1="update consultation_services set refundapprove='approved' where auto_number='$servicesanum' and patientvisitcode='$visitcode'";
		$servicesquery1=mysql_query($servicesquery1) or die(mysql_error());
		
		$query39=mysql_query("update master_visitentry set itemrefund='refund' where visitcode='$visitcode'") or die(mysql_error());

		
		}
		}
		}
		}
		header("location:cashrefundapprovallist.php");
		exit;

}

if(isset($_REQUEST["patientcode"]))
{
$patientcode=$_REQUEST["patientcode"];
$visitcode=$_REQUEST["visitcode"];
}
?>

<?php
$query78="select * from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$exec78=mysql_query($query78) or die(mysql_error());
$res78=mysql_fetch_array($exec78);
$patientage=$res78['age'];
$patientgender=$res78['gender'];

$res111paymenttype = $res78['paymenttype'];
 $locationcodeget=$res78['locationcode'];
$query33 = "select locationname from master_location where locationcode='".$locationcodeget."'";
$exec33 = mysql_query($query33) or die(mysql_error());
$res33 = mysql_fetch_array($exec33);
 $locationnameget = $res33['locationname'];


$query121 = "select * from master_paymenttype where auto_number = '$res111paymenttype'";
$exec121 = mysql_query($query121) or die (mysql_error());
$res121 = mysql_fetch_array($exec121);
$res121paymenttype = $res121['paymenttype'];
?>
<?php
$querylab1=mysql_query("select * from master_customer where customercode='$patientcode'");
$execlab1=mysql_fetch_array($querylab1);
$patientname=$execlab1['customerfullname'];
$patientaccount=$execlab1['accountname'];
$billtype=$execlab1['billtype'];

$querylab2=mysql_query("select * from master_accountname where auto_number='$patientaccount'");
$execlab2=mysql_fetch_array($querylab2);
$patientaccount1=$execlab2['accountname'];

?>
<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
.style1 {
	font-size: 36px;
	font-weight: bold;
}
.style2 {
	font-size: 18px;
	font-weight: bold;
}
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }

</style>


</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body>
<form name="form1" id="frmsales" method="post" action="cashrefundapproval.php" onKeyDown="return disableEnterKey(event)">
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
<!--  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
-->
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="980" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr>
				  <td colspan="4" align="left" valign="middle"  bgcolor="#CCCCCC" class="bodytext3"><strong>Cash Refund Approval</strong></td>
				  </tr>	
				  <tr>
				  <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
				  </tr>			
			  <tr>
			    <td width="15%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Patient </strong></td>
                <td width="36%" align="left" valign="middle" class="bodytext3">
				<input name="customername" id="customer" type="hidden" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/><?php echo $patientname; ?>
                  </td>
                 <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Patient code </strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3">
				<input name="customercode" id="customercode" type="hidden" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $patientcode; ?>
				
				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>
             
			    </tr>
			   <tr>
			    <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="style4"></span><strong>Age &amp; Gender </strong></td>
			    <td align="left" valign="middle" class="bodytext3">
				<input type="hidden" name="patientage" id="patientage" value="<?php echo $patientage; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $patientage; ?>
				&
				<input type="hidden" name="patientgender" id="patientgender" value="<?php echo $patientgender; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $patientgender; ?>
				<input type="hidden" name="address1" id="address1" value="<?php echo $res41address1; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;" size="30" />
			      <span class="style4"><!--Area--> </span>
			      <input type="hidden" name="area" id="area" value="<?php echo $res41area; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="10" />
				  </td>
				    <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Account</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3">
				<input name="account" id="account" type="hidden" value="<?php echo $patientaccount1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $patientaccount1; ?>
				
				  </tr>
				  <tr>
				  <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Visit Code</strong></td>
                <td colspan="1" align="left" valign="middle" class="bodytext3">
				<input name="visitcode" id="visitcode" type="hidden" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $visitcode; ?>
				<input type="hidden" name="billtype" id="billtypes" value="<?php echo $billtype; ?>">
			 <input type="hidden" name="paymenttype" id="payment" value="<?php echo $res121paymenttype; ?>" readonly   size="20" />		
				   <td width="10%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Location</strong></td>
                <td colspan="1" align="left" valign="middle" class="bodytext3" ><?php echo $locationnameget?></td>
                <input type="hidden" name="locationcodeget" value="<?php echo $locationcodeget?>">
				<input type="hidden" name="locationnameget" value="<?php echo $locationnameget?>">
                  </tr>
				  <tr>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
				  </tr>
            </tbody>
        </table></td>
      </tr>
      
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
		    <?php
		  $query20num = "select * from pharmacysalesreturn_details where visitcode='$visitcode' and patientcode='$patientcode' and billstatus='pending' and refundapprove=''";
		  $exec20num = mysql_query($query20num) or die ("Error in query19num".mysql_error());
		  $num20num = mysql_num_rows($exec20num);
		  if($num20num > 0)
		  {
		  ?>
		   <tr>
				  <td colspan="6" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
				  </tr>	
		  <tr>
				  <td colspan="6" align="left" valign="middle"  bgcolor="#CCCCCC" class="bodytext3"><strong>Pharmacy</strong></td>
				  </tr>	
            <tr>
              <td width="16%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				<td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Code </strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Pharmacy</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate  </strong></div></td>
					<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount </strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Select </strong></div></td>
              
                  </tr>
				  		<?php
						}
			$colorloopcount = '';
			$sno = '';
			$totalamount=0;
		
			$query20 = "select * from pharmacysalesreturn_details where visitcode='$visitcode' and patientcode='$patientcode' and billstatus='pending' and refundapprove=''";
			$exec20 = mysql_query($query20) or die ("Error in Query1".mysql_error());
			while ($res20 = mysql_fetch_array($exec20))
			{
			
			$pharmacyitemname=$res20['itemname'];
			$pharmacyitemcode=$res20['itemcode'];
			$pharmacyitemrate=$res20['rate'];
			$pharmacyitemamount=$res20['totalamount'];
			$pharmacyanum=$res20['auto_number'];
			
		
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
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			 <input type="hidden" name="pharmacyanum[<?php echo $sno; ?>]" value="<?php echo $pharmacyanum; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmacyitemcode; ?></div></td>
			 <input type="hidden" name="pharmacyitemcode[<?php echo $sno; ?>]" value="<?php echo $pharmacyitemcode; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmacyitemname; ?></div></td>
			 <input type="hidden" name="pharmacyitemname[<?php echo $sno; ?>]" value="<?php echo $pharmacyitemname; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmacyitemrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmacyitemamount; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" name="pharmacycheck[<?php echo $sno; ?>]" value="<?php echo $pharmacyanum; ?>"></div></td>
				
				</tr>
			<?php } ?>
		    <?php
		  $query19num = "select * from consultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='completed' and (freestatus='' or freestatus='NO') and refundapproval='' and labrefund='refund'";
		  $exec19num = mysql_query($query19num) or die ("Error in query19num".mysql_error());
		  $num19num = mysql_num_rows($exec19num);
		  if($num19num > 0)
		  {
		  ?>
		   <tr>
				  <td colspan="6" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
				  </tr>	
		  <tr>
				  <td colspan="6" align="left" valign="middle"  bgcolor="#CCCCCC" class="bodytext3"><strong>Lab</strong></td>
				  </tr>	
            <tr>
              <td width="16%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				<td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Code </strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Lab</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate  </strong></div></td>
					<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount </strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Select </strong></div></td>
              
                  </tr>
				  		<?php
						}
			$colorloopcount = '';
			
			$totalamount=0;
		
			$query19 = "select * from consultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='completed' and (freestatus='' or freestatus='NO') and refundapproval='' and labrefund='refund'";
			$exec19 = mysql_query($query19) or die ("Error in Query1".mysql_error());
			while ($res19 = mysql_fetch_array($exec19))
			{
			
			$labitemname=$res19['labitemname'];
			$labitemcode=$res19['labitemcode'];
			$labitemrate=$res19['labitemrate'];
			$labanum=$res19['auto_number'];
			
		
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
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			 <input type="hidden" name="labanum[<?php echo $sno; ?>]" value="<?php echo $labanum; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labitemcode; ?></div></td>
			 <input type="hidden" name="labitemcode[<?php echo $sno; ?>]" value="<?php echo $labitemcode; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labitemname; ?></div></td>
			 <input type="hidden" name="labitemname[<?php echo $sno; ?>]" value="<?php echo $labitemname; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labitemrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labitemrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" name="labcheck[<?php echo $sno; ?>]" value="<?php echo $labanum; ?>"></div></td>
				
				</tr>
			<?php } ?>
		  <?php
		  $query17num = "select * from consultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='completed' and radiologyrefund='refund' and refundapprove=''";
		  $exec17num = mysql_query($query17num) or die ("Error in query17num".mysql_error());
		  $num17num = mysql_num_rows($exec17num);
		  if($num17num > 0)
		  {
		  ?>
		   <tr>
				  <td colspan="6" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
				  </tr>	
		  <tr>
				  <td colspan="6" align="left" valign="middle"  bgcolor="#CCCCCC" class="bodytext3"><strong>Radiology</strong></td>
				  </tr>	
            <tr>
              <td width="16%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				<td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Code </strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Radiology</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate  </strong></div></td>
					<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount </strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Select </strong></div></td>
              
                  </tr>
				  		<?php
						}
			$colorloopcount = '';
			
			$totalamount=0;
		
			$query17 = "select * from consultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='completed' and radiologyrefund='refund' and refundapprove=''";
			$exec17 = mysql_query($query17) or die ("Error in Query1".mysql_error());
			while ($res17 = mysql_fetch_array($exec17))
			{
			
			$paharmitemname=$res17['radiologyitemname'];
			$pharmitemcode=$res17['radiologyitemcode'];
			$pharmitemrate=$res17['radiologyitemrate'];
			$radanum=$res17['auto_number'];
			
		
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
			$totalamount=$totalamount+$pharmitemrate;
			$totalamount=number_format($totalamount,2);
			?>
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			 <input type="hidden" name="radanum[<?php echo $sno; ?>]" value="<?php echo $radanum; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemcode; ?></div></td>
			 <input type="hidden" name="raditemcode[<?php echo $sno; ?>]" value="<?php echo $pharmitemcode; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $paharmitemname; ?></div></td>
			 <input type="hidden" name="raditemname[<?php echo $sno; ?>]" value="<?php echo $paharmitemname; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" name="radcheck[<?php echo $sno; ?>]" value="<?php echo $radanum; ?>"></div></td>
				
				</tr>
			<?php } ?>
			  <?php
		  $query18num = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='completed' and servicerefund='refund' and refundapprove=''";
		  $exec18num = mysql_query($query18num) or die ("Error in query17num".mysql_error());
		  $num18num = mysql_num_rows($exec18num);
		  if($num18num > 0)
		  {
		  ?>
		   <tr>
				  <td colspan="6" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
				  </tr>	
		  <tr>
				  <td colspan="6" align="left" valign="middle"  bgcolor="#CCCCCC" class="bodytext3"><strong>Service</strong></td>
				  </tr>	
            <tr>
              <td width="16%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				<td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Code </strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Service</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate  </strong></div></td>
					<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount </strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Select </strong></div></td>
              
                  </tr>
				  		<?php
						}
			$colorloopcount = '';
			
			$totalamount=0;
		
			$query18 = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='completed' and servicerefund='refund' and refundapprove=''";
			$exec18 = mysql_query($query18) or die ("Error in Query1".mysql_error());
			while ($res18 = mysql_fetch_array($exec18))
			{
			
			$servicesitemname=$res18['servicesitemname'];
			$servicesitemcode=$res18['servicesitemcode'];
			$servicesitemrate=$res18['servicesitemrate'];
			$servicesanum=$res18['auto_number'];
			
		
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
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			 <input type="hidden" name="servicesanum[<?php echo $sno; ?>]" value="<?php echo $servicesanum; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $servicesitemcode; ?></div></td>
			 <input type="hidden" name="servicesitemcode[<?php echo $sno; ?>]" value="<?php echo $servicesitemcode; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $servicesitemname; ?></div></td>
			 <input type="hidden" name="servicesitemname[<?php echo $sno; ?>]" value="<?php echo $servicesitemname; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $servicesitemrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $servicesitemrate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" name="servicescheck[<?php echo $sno; ?>]" value="<?php echo $servicesanum; ?>"></div></td>
				
				</tr>
			<?php } ?>
			  <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
             </tr>
           
          </tbody>
        </table>		</td>
      </tr>
          
      <tr>
        
		 <td colspan="2" align="right" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
		  <input type="hidden" name="frm1submit1" value="frm1submit1" />
                  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
               <input name="Submit222" type="submit"  value="Approve" class="button"/>
		 </td>
      </tr>
	  </table>
      </td>
      </tr>
    
  </table>
</form>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>