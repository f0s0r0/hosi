<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';
 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
$ward=isset($_REQUEST['ward'])?$_REQUEST['ward']:'';
$ADate1=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:date('Y-m-d', strtotime('-1 month'));
$ADate2=isset($_REQUEST['ADate2'])?$_REQUEST['ADate2']:date('Y-m-d');
$fromdate=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:date('Y-m-d', strtotime('-1 month'));
$todate=isset($_REQUEST['ADate2'])?$_REQUEST['ADate2']:date('Y-m-d');


header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="bedoccupancy-summary.xls"');
header('Cache-Control: max-age=80');

$query77 = mysql_query("select locationname from master_location where locationcode = '$locationcode1'");
$res77 = mysql_fetch_array($query77);
$locationname = $res77['locationname'];
?>
<style type="text/css">
<!--
body {

}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
      
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
}
.number
{
padding-left:900px;
text-align:right;
font-weight:bold;
}
.bali
{
text-align:right;
}
.style1 {font-weight: bold}
</style>
</head>
<body>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse; float:none" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1035" 
            align="left" border="1">
          <tbody>
             <tr>
			 <td colspan="4" bgcolor="#FFF" class="bodytext31"><div align="center"><strong>Bed Occupancy Summary</strong></div></td>
			 </tr>
			 <tr>
			 <td colspan="4" bgcolor="#FFF" class="bodytext31"><div align="center"><strong><?php echo $locationname; ?></strong></div></td>
			 </tr>
			 <tr>
			 <td colspan="4" bgcolor="#FFF" class="bodytext31"><div align="center"><strong>From <?php echo date('d-m-Y',strtotime($fromdate)); ?> To <?php echo date('d-m-Y',strtotime($todate)); ?></strong></div></td>
			 </tr>
            <tr>
              <td width="281"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Ward Name</strong></div></td>
				<td width="211"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Total Patients</strong></div></td>
                  <td width="143"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Total Days </strong></div></td>
				<td width="142"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bed Days </strong></div></td>
             </tr>
           <?php	
			$totaldays = 0;
			$totalbeddays = 0;
			$totalwarddays = 0;
			$totalwardbeddays = 0;
			$totalpatients = 0;
			$colorloopcount = 0;
			$totalday='0';
			$totalbedday = '0';
			
			$searchward = $ward;
			if($ward == ''){
			$query56 = "select auto_number, ward from master_ward where locationcode = '$locationcode1' and recordstatus <> 'deleted'";
			} else {
			$query56 = "select auto_number, ward from master_ward where auto_number = '$ward' and locationcode = '$locationcode1' and recordstatus <> 'deleted'";
			}
			$exec56 = mysql_query($query56) or die ("Error in Query56".mysql_error());
			while($res56 = mysql_fetch_array($exec56))
			{
			$ward = $res56['auto_number'];
			$wardname = $res56['ward'];
			
			$totalwarddays = 0;
			$totalwardbeddays = 0;
			$patients = 0;
			
			
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#FFF"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#FFF"';
			}
			
			if($ward == ''){
  			$querynw1 = "select visitcode,patientcode,recorddate from ip_bedallocation where locationcode='$locationcode1' and recordstatus <> 'transfered' and recorddate between '$fromdate' and '$todate'";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			} else {
			$querynw1 = "select visitcode,patientcode,recorddate from ip_bedallocation where locationcode='$locationcode1' and recordstatus <> 'transfered' and ward = '$ward' and recorddate between '$fromdate' and '$todate'";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			}
			$execnw1 = mysql_query($querynw1) or die ("Error in Querynw1".mysql_error());
			$resnw1=mysql_num_rows($execnw1);
				
			$formvar='';
			$i1=0;			
			while($getmw=mysql_fetch_array($execnw1))
			{ 
				$patientcode=$getmw['patientcode'];
				$visitcode=$getmw['visitcode'];
				$res2consultationdate=$getmw['recorddate'];
				$admissiondate = $getmw['recorddate'];
				
			$query02="select patientfullname,gender from master_ipvisitentry where patientcode='$patientcode' and  visitcode='$visitcode'";
			$exec02=mysql_query($query02);
			$res02=mysql_fetch_array($exec02);
			
			$patientname=$res02['patientfullname'];
		   $gender=$res02['gender'];
		
					$query751 = "select dateofbirth from master_customer where customercode = '$patientcode'";
		$exec751 = mysql_query($query751) or die(mysql_error());
		$res751 = mysql_fetch_array($exec751);
		$dob = $res751['dateofbirth'];
			
				$today = new DateTime();
				$diff = $today->diff(new DateTime($dob));
				
				if ($diff->y)
				{
				$age= $diff->y . ' Years';
				}
				elseif ($diff->m)
				{
				$age =$diff->m . ' Months';
				}
				else
				{
				$age =$diff->d . ' Days';
				}
		
			$query3 = "select recorddate from ip_discharge where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode' and req_status = 'discharge'";
			$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
			$num3=mysql_num_rows($exec3);
			$res3 = mysql_fetch_array($exec3);
			
			$res3recorddate=$res3['recorddate'];
			$dischargedate = $res3['recorddate'];
			$ll = 0;
			if(strtotime($dischargedate)>strtotime($todate))
			{	
				$ll = 1;
				$dischargedate= $todate;
			}
			if($num3 == 0)
			{
				$ll = 1;
				$dischargedate= $todate;
			}
						
			$registrationdate   = strtotime($admissiondate);
			$dischargedate1 = strtotime($dischargedate);
			$today = date('Y-m-d');
			$today1 = strtotime($today);
			$totalbeddays = ceil(($dischargedate1 - $registrationdate) / 86400);
			$totaldays = ceil(($today1 - $registrationdate) / 86400);
			if($totaldays == 0)
			{
			$totaldays = 1;
			}
			else
			{
			$totaldays = $totaldays + 1;
			}
			if($totalbeddays == 0)
			{
			$totalbeddays = 1;
			}
			else
			{
			$totalbeddays = $totalbeddays + 1;
			}
			$totalday +=$totaldays;
			$totalbedday +=$totalbeddays;
			$totalwarddays += $totaldays;
			$totalwardbeddays += $totalbeddays;
			$patients += 1;
			$totalpatients += 1;
			
			}
			
			if($ward == ''){
  			$querynw1 = "select visitcode,patientcode,recorddate from ip_bedtransfer where locationcode='$locationcode1' and recordstatus <> 'transfered' and recorddate between '$fromdate' and '$todate'";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			} else {
			$querynw1 = "select visitcode,patientcode,recorddate from ip_bedtransfer where locationcode='$locationcode1' and recordstatus <> 'transfered' and ward = '$ward' and recorddate between '$fromdate' and '$todate'";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			}
			$execnw1 = mysql_query($querynw1) or die ("Error in Querynw1".mysql_error());
			$resnw1=mysql_num_rows($execnw1);
				
			$formvar='';
			$i1=0;			
			while($getmw=mysql_fetch_array($execnw1))
			{ 
				$patientcode=$getmw['patientcode'];
				$visitcode=$getmw['visitcode'];
				
				$query1 = mysql_query("select recorddate from ip_bedallocation where visitcode = '$visitcode'");
				$getrd=mysql_fetch_array($query1);
				
				$res2consultationdate=$getrd['recorddate'];
				$admissiondate = $getrd['recorddate'];
				
			$query02="select patientfullname,gender from master_ipvisitentry where patientcode='$patientcode' and  visitcode='$visitcode'";
			$exec02=mysql_query($query02);
			$res02=mysql_fetch_array($exec02);
			
			$patientname=$res02['patientfullname'];
		   $gender=$res02['gender'];
		
					$query751 = "select dateofbirth from master_customer where customercode = '$patientcode'";
		$exec751 = mysql_query($query751) or die(mysql_error());
		$res751 = mysql_fetch_array($exec751);
		$dob = $res751['dateofbirth'];
			
				$today = new DateTime();
				$diff = $today->diff(new DateTime($dob));
				
				if ($diff->y)
				{
				$age= $diff->y . ' Years';
				}
				elseif ($diff->m)
				{
				$age =$diff->m . ' Months';
				}
				else
				{
				$age =$diff->d . ' Days';
				}
		
			$query3 = "select recorddate from ip_discharge where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode' and req_status = 'discharge'";
			$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
			$num3=mysql_num_rows($exec3);
			$res3 = mysql_fetch_array($exec3);
			
			$res3recorddate=$res3['recorddate'];
			$dischargedate = $res3['recorddate'];
			$ll = 0;
			if(strtotime($dischargedate)>strtotime($todate))
			{	
				$ll = 1;
				$dischargedate= $todate;
			}
			if($num3 == 0)
			{
				$ll = 1;
				$dischargedate= $todate;
			}
						
			$registrationdate   = strtotime($admissiondate);
			$dischargedate1 = strtotime($dischargedate);
			$today = date('Y-m-d');
			$today1 = strtotime($today);
			$totalbeddays = ceil(($dischargedate1 - $registrationdate) / 86400);
			$totaldays = ceil(($today1 - $registrationdate) / 86400);
			if($totaldays == 0)
			{
			$totaldays = 1;
			}
			else
			{
			$totaldays = $totaldays + 1;
			}
			if($totalbeddays == 0)
			{
			$totalbeddays = 1;
			}
			else
			{
			$totalbeddays = $totalbeddays + 1;
			}
			$totalday +=$totaldays;
			$totalbedday +=$totalbeddays;
			$totalwarddays += $totaldays;
			$totalwardbeddays += $totalbeddays;
			$patients += 1;
			$totalpatients += 1;
			}
			
	       if($ward == ''){
  			$querynw2 = "select visitcode,patientcode,recorddate from ip_bedallocation where locationcode='$locationcode1' and recordstatus <> 'transfered' and recorddate < '$fromdate' and visitcode IN (select visitcode from ip_discharge where recorddate between '$fromdate' and '$todate' and req_status = 'discharge')";
			} else {
			$querynw2 = "select visitcode,patientcode,recorddate from ip_bedallocation where locationcode='$locationcode1' and recordstatus <> 'transfered' and ward = '$ward' and recorddate < '$fromdate' and visitcode IN (select visitcode from ip_discharge where recorddate between '$fromdate' and '$todate' and req_status = 'discharge')";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			}
			$execnw2 = mysql_query($querynw2) or die ("Error in Querynw2".mysql_error());
			$resnw2=mysql_num_rows($execnw2);
				
			$formvar='';
			$i1=0;			
			while($getmw2=mysql_fetch_array($execnw2))
			{ 
				$patientcode=$getmw2['patientcode'];
				$visitcode=$getmw2['visitcode'];
				$res2consultationdate=$getmw2['recorddate'];
				$admissiondate = $getmw2['recorddate'];
				
		
			$query021="select patientfullname,gender from master_ipvisitentry where patientcode='$patientcode' and  visitcode='$visitcode'";
			$exec021=mysql_query($query021);
			$res021=mysql_fetch_array($exec021);
			
			$patientname=$res021['patientfullname'];
		   $gender=$res021['gender'];
		
					$query752 = "select dateofbirth from master_customer where customercode = '$patientcode'";
		$exec752 = mysql_query($query752) or die(mysql_error());
		$res752 = mysql_fetch_array($exec752);
		$dob = $res752['dateofbirth'];
			
				$today = new DateTime();
				$diff = $today->diff(new DateTime($dob));
				
				if ($diff->y)
				{
				$age= $diff->y . ' Years';
				}
				elseif ($diff->m)
				{
				$age =$diff->m . ' Months';
				}
				else
				{
				$age =$diff->d . ' Days';
				}
		
			$query31 = "select recorddate from ip_discharge where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode' and req_status = 'discharge'";
			$exec31 = mysql_query($query31) or die ("Error in Query31".mysql_error());
			$num31=mysql_num_rows($exec31);
			$res31 = mysql_fetch_array($exec31);
			
			$res31recorddate=$res31['recorddate'];
			$dischargedate = $res31['recorddate'];
			$ll = 0;
			if(strtotime($dischargedate)>strtotime($todate))
			{	
				$ll = 1;
				$dischargedate= $todate;
			}
			if($num31 == 0)
			{
				$ll = 1;
				$dischargedate= $todate;
			}
						
			$registrationdate   = strtotime($fromdate);
			$dischargedate1 = strtotime($dischargedate);
			$today = date('Y-m-d');
			$today1 = strtotime($today);
			$totalbeddays = ceil(($dischargedate1 - $registrationdate) / 86400);
			$totaldays = ceil(($today1 - $registrationdate) / 86400);
			if($totaldays == 0)
			{
			$totaldays = 1;
			}
			else
			{
			$totaldays = $totaldays + 1;
			}
			if($totalbeddays == 0)
			{
			$totalbeddays = 1;
			}
			else
			{
			$totalbeddays = $totalbeddays + 1;
			}
			$totalday +=$totaldays;
			$totalbedday +=$totalbeddays;
			$totalwarddays += $totaldays;
			$totalwardbeddays += $totalbeddays;
			$patients += 1;
			$totalpatients += 1;
			}
			
			if($ward == ''){
  			$querynw2 = "select visitcode,patientcode,recorddate from ip_bedtransfer where locationcode='$locationcode1' and recordstatus <> 'transfered' and recorddate < '$fromdate' and visitcode IN (select visitcode from ip_discharge where recorddate between '$fromdate' and '$todate' and req_status = 'discharge')";
			} else {
			$querynw2 = "select visitcode,patientcode,recorddate from ip_bedtransfer where locationcode='$locationcode1' and recordstatus <> 'transfered' and ward = '$ward' and recorddate < '$fromdate' and visitcode IN (select visitcode from ip_discharge where recorddate between '$fromdate' and '$todate' and req_status = 'discharge')";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			}
			$execnw2 = mysql_query($querynw2) or die ("Error in Querynw2".mysql_error());
			$resnw2=mysql_num_rows($execnw2);
				
			$formvar='';
			$i1=0;			
			while($getmw2=mysql_fetch_array($execnw2))
			{ 
				$patientcode=$getmw2['patientcode'];
				$visitcode=$getmw2['visitcode'];
				
				$query1 = mysql_query("select recorddate from ip_bedallocation where visitcode = '$visitcode'");
				$getrd=mysql_fetch_array($query1);
				
				$res2consultationdate=$getrd['recorddate'];
				$admissiondate = $getrd['recorddate'];
				
				
			$query021="select patientfullname,gender from master_ipvisitentry where patientcode='$patientcode' and  visitcode='$visitcode'";
			$exec021=mysql_query($query021);
			$res021=mysql_fetch_array($exec021);
			
			$patientname=$res021['patientfullname'];
		   $gender=$res021['gender'];
		
					$query752 = "select dateofbirth from master_customer where customercode = '$patientcode'";
		$exec752 = mysql_query($query752) or die(mysql_error());
		$res752 = mysql_fetch_array($exec752);
		$dob = $res752['dateofbirth'];
			
				$today = new DateTime();
				$diff = $today->diff(new DateTime($dob));
				
				if ($diff->y)
				{
				$age= $diff->y . ' Years';
				}
				elseif ($diff->m)
				{
				$age =$diff->m . ' Months';
				}
				else
				{
				$age =$diff->d . ' Days';
				}
		
			$query31 = "select recorddate from ip_discharge where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode' and req_status = 'discharge'";
			$exec31 = mysql_query($query31) or die ("Error in Query31".mysql_error());
			$num31=mysql_num_rows($exec31);
			$res31 = mysql_fetch_array($exec31);
			
			$res31recorddate=$res31['recorddate'];
			$dischargedate = $res31['recorddate'];
			$ll = 0;
			if(strtotime($dischargedate)>strtotime($todate))
			{	
				$ll = 1;
				$dischargedate= $todate;
			}
			if($num31 == 0)
			{
				$ll = 1;
				$dischargedate= $todate;
			}
						
			$registrationdate   = strtotime($fromdate);
			$dischargedate1 = strtotime($dischargedate);
			$today = date('Y-m-d');
			$today1 = strtotime($today);
			$totalbeddays = ceil(($dischargedate1 - $registrationdate) / 86400);
			$totaldays = ceil(($today1 - $registrationdate) / 86400);
			if($totaldays == 0)
			{
			$totaldays = 1;
			}
			else
			{
			$totaldays = $totaldays + 1;
			}
			if($totalbeddays == 0)
			{
			$totalbeddays = 1;
			}
			else
			{
			$totalbeddays = $totalbeddays + 1;
			}
			$totalday +=$totaldays;
			$totalbedday +=$totalbeddays;
			$totalwarddays += $totaldays;
			$totalwardbeddays += $totalbeddays;
			$patients += 1;
			$totalpatients += 1;
			}
			
			if($ward == ''){
  			$querynw8 = "select visitcode,patientcode,recorddate from ip_bedallocation where locationcode='$locationcode1' and recordstatus <> 'transfered' and recorddate < '$fromdate' and visitcode IN (select visitcode from ip_discharge where recorddate > '$todate' and req_status = 'discharge')";
			} else {
			$querynw8 = "select visitcode,patientcode,recorddate from ip_bedallocation where locationcode='$locationcode1' and recordstatus <> 'transfered' and ward = '$ward' and recorddate < '$fromdate' and visitcode IN (select visitcode from ip_discharge where recorddate > '$todate' and req_status = 'discharge')";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			}
			$execnw8 = mysql_query($querynw8) or die ("Error in Querynw8".mysql_error());
			$resnw8=mysql_num_rows($execnw8);
				
			$formvar='';
			$i1=0;			
			while($getmw8=mysql_fetch_array($execnw8))
			{ 
				$patientcode=$getmw8['patientcode'];
				$visitcode=$getmw8['visitcode'];
				$res2consultationdate=$getmw8['recorddate'];
				$admissiondate = $getmw8['recorddate'];
				
		
			$query081="select patientfullname,gender from master_ipvisitentry where patientcode='$patientcode' and  visitcode='$visitcode'";
			$exec081=mysql_query($query081);
			$res081=mysql_fetch_array($exec081);
			
			$patientname=$res081['patientfullname'];
		   $gender=$res081['gender'];
		
					$query758 = "select dateofbirth from master_customer where customercode = '$patientcode'";
		$exec758 = mysql_query($query758) or die(mysql_error());
		$res758 = mysql_fetch_array($exec758);
		$dob = $res758['dateofbirth'];
			
				$today = new DateTime();
				$diff = $today->diff(new DateTime($dob));
				
				if ($diff->y)
				{
				$age= $diff->y . ' Years';
				}
				elseif ($diff->m)
				{
				$age =$diff->m . ' Months';
				}
				else
				{
				$age =$diff->d . ' Days';
				}
		
			$query33 = "select recorddate from ip_discharge where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode' and req_status = 'discharge'";
			$exec33 = mysql_query($query33) or die ("Error in Query33".mysql_error());
			$num33=mysql_num_rows($exec33);
			$res33 = mysql_fetch_array($exec33);
			
			$res33recorddate=$res33['recorddate'];
			$dischargedate = $res33['recorddate'];
			$ll = 0;
			if(strtotime($dischargedate)>strtotime($todate))
			{	
				$ll = 1;
				$dischargedate= $todate;
			}
			if($num33 == 0)
			{
				$ll = 1;
				$dischargedate= $todate;
			}
						
			$registrationdate   = strtotime($admissiondate);
			$dischargedate1 = strtotime($dischargedate);
			$today = date('Y-m-d');
			$today1 = strtotime($today);
			$totalbeddays = ceil(($dischargedate1 - $registrationdate) / 86400);
			$totaldays = ceil(($today1 - $registrationdate) / 86400);
			if($totaldays == 0)
			{
			$totaldays = 1;
			}
			else
			{
			$totaldays = $totaldays + 1;
			}
			if($totalbeddays == 0)
			{
			$totalbeddays = 1;
			}
			else
			{
			$totalbeddays = $totalbeddays + 1;
			}
			$totalday +=$totaldays;
			$totalbedday +=$totalbeddays;

			$totalwarddays += $totaldays;
			$totalwardbeddays += $totalbeddays;
			$patients += 1;
			$totalpatients += 1;
			 }
			
			if($ward == ''){
  			$querynw8 = "select visitcode,patientcode,recorddate from ip_bedtransfer where locationcode='$locationcode1' and recordstatus <> 'transfered' and recorddate < '$fromdate' and visitcode IN (select visitcode from ip_discharge where recorddate > '$todate' and req_status = 'discharge')";
			} else {
			$querynw8 = "select visitcode,patientcode,recorddate from ip_bedtransfer where locationcode='$locationcode1' and recordstatus <> 'transfered' and ward = '$ward' and recorddate < '$fromdate' and visitcode IN (select visitcode from ip_discharge where recorddate > '$todate' and req_status = 'discharge')";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			}
			$execnw8 = mysql_query($querynw8) or die ("Error in Querynw8".mysql_error());
			$resnw8=mysql_num_rows($execnw8);
				
			$formvar='';
			$i1=0;			
			while($getmw8=mysql_fetch_array($execnw8))
			{ 
				$patientcode=$getmw8['patientcode'];
				$visitcode=$getmw8['visitcode'];
				
				$query1 = mysql_query("select recorddate from ip_bedallocation where visitcode = '$visitcode'");
				$getrd=mysql_fetch_array($query1);
				
				$res2consultationdate=$getrd['recorddate'];
				$admissiondate = $getrd['recorddate'];
				
				
			$query081="select patientfullname,gender from master_ipvisitentry where patientcode='$patientcode' and  visitcode='$visitcode'";
			$exec081=mysql_query($query081);
			$res081=mysql_fetch_array($exec081);
			
			$patientname=$res081['patientfullname'];
		   $gender=$res081['gender'];
		
					$query758 = "select dateofbirth from master_customer where customercode = '$patientcode'";
		$exec758 = mysql_query($query758) or die(mysql_error());
		$res758 = mysql_fetch_array($exec758);
		$dob = $res758['dateofbirth'];
			
				$today = new DateTime();
				$diff = $today->diff(new DateTime($dob));
				
				if ($diff->y)
				{
				$age= $diff->y . ' Years';
				}
				elseif ($diff->m)
				{
				$age =$diff->m . ' Months';
				}
				else
				{
				$age =$diff->d . ' Days';
				}
		
			$query33 = "select recorddate from ip_discharge where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode' and req_status = 'discharge'";
			$exec33 = mysql_query($query33) or die ("Error in Query33".mysql_error());
			$num33=mysql_num_rows($exec33);
			$res33 = mysql_fetch_array($exec33);
			
			$res33recorddate=$res33['recorddate'];
			$dischargedate = $res33['recorddate'];
			$ll = 0;
			if(strtotime($dischargedate)>strtotime($todate))
			{	
				$ll = 1;
				$dischargedate= $todate;
			}
			if($num33 == 0)
			{
				$ll = 1;
				$dischargedate= $todate;
			}
						
			$registrationdate   = strtotime($admissiondate);
			$dischargedate1 = strtotime($dischargedate);
			$today = date('Y-m-d');
			$today1 = strtotime($today);
			$totalbeddays = ceil(($dischargedate1 - $registrationdate) / 86400);
			$totaldays = ceil(($today1 - $registrationdate) / 86400);
			if($totaldays == 0)
			{
			$totaldays = 1;
			}
			else
			{
			$totaldays = $totaldays + 1;
			}
			if($totalbeddays == 0)
			{
			$totalbeddays = 1;
			}
			else
			{
			$totalbeddays = $totalbeddays + 1;
			}
			$totalday +=$totaldays;
			$totalbedday +=$totalbeddays;
			$totalwarddays += $totaldays;
			$totalwardbeddays += $totalbeddays;
			$patients += 1;
			$totalpatients += 1;
			 }
			
			if($ward == ''){
  			$querynw3 = "select visitcode,patientcode,recorddate from ip_bedallocation where locationcode='$locationcode1' and recordstatus <> 'transfered' and recorddate < '$fromdate' and visitcode NOT IN (select visitcode from ip_discharge where req_status = 'discharge')";
			} else {
			$querynw3 = "select visitcode,patientcode,recorddate from ip_bedallocation where locationcode='$locationcode1' and recordstatus <> 'transfered' and ward = '$ward' and recorddate < '$fromdate' and visitcode NOT IN (select visitcode from ip_discharge where req_status = 'discharge')";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			}
			$execnw3 = mysql_query($querynw3) or die ("Error in Querynw3".mysql_error());
			$resnw3=mysql_num_rows($execnw3);
				
			$formvar='';
			$i1=0;			
			while($getmw3=mysql_fetch_array($execnw3))
			{
				$patientcode=$getmw3['patientcode'];
				$visitcode=$getmw3['visitcode'];
				$res2consultationdate=$getmw3['recorddate'];
				$admissiondate = $getmw3['recorddate'];
				
		
			$query022="select patientfullname,gender from master_ipvisitentry where patientcode='$patientcode' and  visitcode='$visitcode'";
			$exec022=mysql_query($query022);
			$res022=mysql_fetch_array($exec022);
			
			$patientname=$res022['patientfullname'];
		   $gender=$res022['gender'];
		
					$query753 = "select dateofbirth from master_customer where customercode = '$patientcode'";
		$exec753 = mysql_query($query753) or die(mysql_error());
		$res753 = mysql_fetch_array($exec753);
		$dob = $res753['dateofbirth'];
			
				$today = new DateTime();
				$diff = $today->diff(new DateTime($dob));
				
				if ($diff->y)
				{
				$age= $diff->y . ' Years';
				}
				elseif ($diff->m)
				{
				$age =$diff->m . ' Months';
				}
				else
				{
				$age =$diff->d . ' Days';
				}
		
			$query311 = "select recorddate from ip_discharge where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode' and req_status = 'discharge'";
			$exec311 = mysql_query($query311) or die ("Error in Query311".mysql_error());
			$num311=mysql_num_rows($exec311);
			$res311 = mysql_fetch_array($exec311);
			
			$res311recorddate=$res311['recorddate'];
			$dischargedate = $res311['recorddate'];
			$ll = 0;
			if(strtotime($dischargedate)>strtotime($todate))
			{	
				$ll = 1;
				$dischargedate= $todate;
			}
			if($num311 == 0)
			{
				$ll = 1;
				$dischargedate= $todate;
			}
						
			$registrationdate   = strtotime($fromdate);
			$dischargedate1 = strtotime($dischargedate);
			$today = date('Y-m-d');
			$today1 = strtotime($today);
			$totalbeddays = ceil(($dischargedate1 - $registrationdate) / 86400);
			$totaldays = ceil(($today1 - $registrationdate) / 86400);
			if($totaldays == 0)
			{
			$totaldays = 1;
			}
			else
			{
			$totaldays = $totaldays + 1;
			}
			if($totalbeddays == 0)
			{
			$totalbeddays = 1;
			}
			else
			{
			$totalbeddays = $totalbeddays + 1;
			}
			$totalday +=$totaldays;
			$totalbedday +=$totalbeddays;
			$totalwarddays += $totaldays;
			$totalwardbeddays += $totalbeddays;
			$patients += 1;
			$totalpatients += 1;
			}
			
			if($ward == ''){
  			$querynw3 = "select visitcode,patientcode,recorddate from ip_bedtransfer where locationcode='$locationcode1' and recordstatus <> 'transfered' and recorddate < '$fromdate' and visitcode NOT IN (select visitcode from ip_discharge where req_status = 'discharge')";
			} else {
			$querynw3 = "select visitcode,patientcode,recorddate from ip_bedtransfer where locationcode='$locationcode1' and recordstatus <> 'transfered' and ward = '$ward' and recorddate < '$fromdate' and visitcode NOT IN (select visitcode from ip_discharge where req_status = 'discharge')";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			}
			$execnw3 = mysql_query($querynw3) or die ("Error in Querynw3".mysql_error());
			$resnw3=mysql_num_rows($execnw3);
				
			$formvar='';
			$i1=0;			
			while($getmw3=mysql_fetch_array($execnw3))
			{
				$patientcode=$getmw3['patientcode'];
				$visitcode=$getmw3['visitcode'];
				
				$query1 = mysql_query("select recorddate from ip_bedallocation where visitcode = '$visitcode'");
				$getrd=mysql_fetch_array($query1);
				
				$res2consultationdate=$getrd['recorddate'];
				$admissiondate = $getrd['recorddate'];
				
				
			$query022="select patientfullname,gender from master_ipvisitentry where patientcode='$patientcode' and  visitcode='$visitcode'";
			$exec022=mysql_query($query022);
			$res022=mysql_fetch_array($exec022);
			
			$patientname=$res022['patientfullname'];
		   $gender=$res022['gender'];
		

					$query753 = "select dateofbirth from master_customer where customercode = '$patientcode'";
		$exec753 = mysql_query($query753) or die(mysql_error());
		$res753 = mysql_fetch_array($exec753);
		$dob = $res753['dateofbirth'];
			
				$today = new DateTime();
				$diff = $today->diff(new DateTime($dob));
				
				if ($diff->y)
				{
				$age= $diff->y . ' Years';
				}
				elseif ($diff->m)
				{
				$age =$diff->m . ' Months';
				}
				else
				{
				$age =$diff->d . ' Days';
				}
		
			$query311 = "select recorddate from ip_discharge where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode' and req_status = 'discharge'";
			$exec311 = mysql_query($query311) or die ("Error in Query311".mysql_error());
			$num311=mysql_num_rows($exec311);
			$res311 = mysql_fetch_array($exec311);
			
			$res311recorddate=$res311['recorddate'];
			$dischargedate = $res311['recorddate'];
			$ll = 0;
			if(strtotime($dischargedate)>strtotime($todate))
			{	
				$ll = 1;
				$dischargedate= $todate;
			}
			if($num311 == 0)
			{
				$ll = 1;
				$dischargedate= $todate;
			}
						
			$registrationdate   = strtotime($fromdate);
			$dischargedate1 = strtotime($dischargedate);
			$today = date('Y-m-d');
			$today1 = strtotime($today);
			$totalbeddays = ceil(($dischargedate1 - $registrationdate) / 86400);
			$totaldays = ceil(($today1 - $registrationdate) / 86400);
			if($totaldays == 0)
			{
			$totaldays = 1;
			}
			else
			{
			$totaldays = $totaldays + 1;
			}
			if($totalbeddays == 0)
			{
			$totalbeddays = 1;
			}
			else
			{
			$totalbeddays = $totalbeddays + 1;
			}
			$totalday +=$totaldays;
			$totalbedday +=$totalbeddays;
			$totalwarddays += $totaldays;
			$totalwardbeddays += $totalbeddays;
			$patients += 1;
			$totalpatients += 1;
			}
	      ?>
          <tr <?php echo $colorcode; ?>>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $wardname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patients; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $totalwarddays; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $totalwardbeddays; ?></div></td>  
              </tr>
		   <?php 
			}
	      ?>
        <tr>
        <td>&nbsp;</td>
        </tr>
         <tr>
             <?php if($totalpatients > 0) { $avgstay= $totalbedday/$totalpatients ; } else { $avgstay = '0.00'; } ?>
			  
               <td width="57"  align="left" valign="center" class="bodytext31"><div align="left"><strong>Total Patients:</strong> <?php echo $totalpatients ?></div></td>
               
			  <td width="143"  align="left" valign="center" class="bodytext31">
			    <div align="left"><strong>Total Days :</strong> <?php echo $totalday ?></div></td>
				  <td width="143"  align="left" valign="center" class="bodytext31">
			    <div align="left"><strong>Total Bed Days :</strong> <?php echo $totalbedday ?></div></td>
				 <td width="156"  align="left" valign="center" class="bodytext31">
			    <div align="left"><strong>Average Length of Stay :</strong> <?php echo number_format($avgstay); ?></div></td>
      </tr> 
		
          </tbody>
        </table>
		
	  <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
	  
	  
	  
	  
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

