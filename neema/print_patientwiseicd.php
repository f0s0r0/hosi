<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$updatedatetime = date('Y-m-d H:i:s');

$colorloopcount = '';
$sno = '';
$snocount = 0;

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="ICDReporting.xls"');
header('Cache-Control: max-age=80');

if (isset($_REQUEST["age"])) {  $searchage = $_REQUEST["age"]; } else { $searchage = ""; }
if (isset($_REQUEST["range"])) {  $searchrange = $_REQUEST["range"]; } else { $searchrange = ""; }
if (isset($_REQUEST["icdcode"])) { $searchicdcode = $_REQUEST["icdcode"]; } else { $searchicdcode = ""; }

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
?>
</head>

<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>
<body>
<table width="1900" border="0" cellspacing="0" cellpadding="2">
  
  <tr>
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      
      <tr>
        <td width="1900">
		  <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1231" 
            align="left" border="0">
          <tbody>
			<tr>
				<td width="4%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>No.</strong></td>
				<td width="6%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>Reg.No</strong></td>
				<td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>OP No</strong></td>
				<td width="6%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>OP Date</strong></td>
				<td width="6%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>Patient</strong></td>
				<td width="6%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>Gender</strong></td>
				<td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>Age</strong></td>
				<td width="8%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>Department</strong></td>
				<td width="11%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>Primary Diagnosis</strong></td>
				<td width="11%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>ICD Code</strong></td>
				<td width="17%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>Secondary Diagnosis</strong></td>
				<td width="21%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>ICD Code</strong></td>
			</tr>
			
			<?php
			 if ($searchrange == '')
		  {         
		  if($searchicdcode == '')
		  {
		 $query1 = "select * from consultation_icd where age like '%$searchage%' and primaryicdcode like '%$searchicdcode%' and secicdcode like '%$searchicdcode%' and consultationdate between '$ADate1' and '$ADate2' order by auto_number desc ";
		   }
		   else
		   {
		    $query1 = "select * from consultation_icd where age like '%$searchage%' and primaryicdcode='$searchicdcode' or secicdcode='$searchicdcode' and consultationdate between '$ADate1' and '$ADate2' order by auto_number desc ";
		   }
		  }
		  else if ($searchrange == 'equal')
		  { 
		  if($searchicdcode == '')
		  {
		  $query1 = "select * from consultation_icd where age = '$searchage' and primaryicdcode like '%$searchicdcode%' and secicdcode like '%$searchicdcode%' and consultationdate between '$ADate1' and '$ADate2' order by auto_number desc ";
		 }
		 else
		 {
		  $query1 = "select * from consultation_icd where age = '$searchage' and primaryicdcode='$searchicdcode' or secicdcode='$searchicdcode' and consultationdate between '$ADate1' and '$ADate2' order by auto_number desc ";
		 }
		  }
		  else if ($searchrange == 'greater')
		  {
		  if($searchicdcode == '')
		  {
		  $query1 = "select * from consultation_icd where age > '$searchage' and primaryicdcode like '%$searchicdcode%' and secicdcode like '%$searchicdcode%' and consultationdate between '$ADate1' and '$ADate2' order by auto_number desc ";
		  }
		  else
		  {
		   $query1 = "select * from consultation_icd where age > '$searchage' and primaryicdcode='$searchicdcode' or secicdcode='$searchicdcode' and consultationdate between '$ADate1' and '$ADate2' order by auto_number desc ";
		  }
		  }
		  else if ($searchrange == 'lesser')
		  {
		  if($searchicdcode == '')
		  {
		   $query1 = "select * from consultation_icd where age < '$searchage' and primaryicdcode like '%$searchicdcode%' and secicdcode like '%$searchicdcode%' and consultationdate between '$ADate1' and '$ADate2' order by auto_number desc ";
		  }
		  else
		  {
		  $query1 = "select * from consultation_icd where age < '$searchage' and primaryicdcode='$searchicdcode' or secicdcode='$searchicdcode' and consultationdate between '$ADate1' and '$ADate2' order by auto_number desc ";
		  }
		  }
		  else if ($searchrange == 'greaterequal')
		  {
		   if($searchicdcode == '')
		  {
		  $query1 = "select * from consultation_icd where age >= '$searchage' and primaryicdcode like '%$searchicdcode%' and secicdcode like '%$searchicdcode%' and consultationdate between '$ADate1' and '$ADate2' order by auto_number desc ";
		  }
		  else
		  {
		   $query1 = "select * from consultation_icd where age >= '$searchage' and primaryicdcode='$searchicdcode' or secicdcode='$searchicdcode' and consultationdate between '$ADate1' and '$ADate2' order by auto_number desc ";
		  }
		  }
		  else if ($searchrange == 'lesserequal')
		  {
		    if($searchicdcode == '')
		  {
		  $query1 = "select * from consultation_icd where age <= '$searchage' and primaryicdcode like '%$searchicdcode%' and secicdcode like '%$searchicdcode%' and consultationdate between '$ADate1' and '$ADate2' order by auto_number desc ";
		  }
		  else
		  {
		   $query1 = "select * from consultation_icd where age <= '$searchage' and primaryicdcode='$searchicdcode' or secicdcode='$searchicdcode' and consultationdate between '$ADate1' and '$ADate2' order by auto_number desc ";
		  }
		  }
			
			$exec1 = mysql_query($query1) or die ("Error in query1".mysql_error());
			while($res1 = mysql_fetch_array($exec1))
			 {
			$res1patientcode= $res1['patientcode'];
			$res1patientvisitcode= $res1['patientvisitcode'];
			$res1consultationdate= $res1['consultationdate'];
			$res1patientname= $res1['patientname'];
			$res1disease= $res1['primarydiag'];
			$res1diseasecode= $res1['primaryicdcode'];

            $query751 = "select * from master_customer where customercode = '$res1patientcode'";
			$exec751 = mysql_query($query751) or die(mysql_error());
			$res751 = mysql_fetch_array($exec751);
			$dob = $res751['dateofbirth'];
			
				$today = new DateTime();
				$diff = $today->diff(new DateTime($dob));
				
				if ($diff->y)
				{
				$res2age= $diff->y . ' Years';
				}
				elseif ($diff->m)
				{
				$res2age =$diff->m . ' Months';
				}
				else
				{
				$res2age =$diff->d . ' Days';
				}
							
			$query2 = "select * from master_visitentry where patientcode = '$res1patientcode' ";
			$exec2 = mysql_query($query2) or die ("Error in query2".mysql_error());
			$res2 = mysql_fetch_array($exec2);
			$res2gender= $res2['gender'];
			$res2consultationdate= $res2['consultationdate'];
			$res2department= $res2['departmentname'];
			
			$secondarydiagnosis = $res1['secondarydiag'];
			$secondarycode = $res1['secicdcode'];
			?>
			<tr>
				<td valign="center" align="left"><?php echo $snocount=$snocount+1; ?></td>
				<td valign="center"  align="left"><?php echo $res1patientcode; ?></td>
				<td align="left" valign="center"><?php echo $res1patientvisitcode; ?></td>
				<td valign="center"  align="left"><?php echo $res1consultationdate; ?></td>
				<td valign="center"  align="left"><?php echo $res1patientname; ?></td>
				<td valign="center"  align="left"><?php echo $res2gender; ?></td>
				<td valign="center" align="left"><?php echo $res2age; ?></td>
				<td valign="center"  align="left"><?php echo $res2department; ?></td>
				<td valign="center"  align="left"><?php echo $res1disease; ?></td>
				<td valign="center"  align="left"><?php echo $res1diseasecode; ?></td>
				<td valign="center"  align="left"><?php echo $secondarydiagnosis; ?></td>
				<td valign="center"  align="left"><?php echo $secondarycode; ?></td>
			</tr>
		   <?php 
		     }
           ?>
          </tbody>
        </table>
		</td>
      </tr>
    </table>
</table>
</body>
</html>

