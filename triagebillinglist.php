<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
error_reporting(0);
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$frmflag2 ='';

if (isset($_REQUEST["department"])) { $department = $_REQUEST["department"]; } else { $department = ""; }
if(isset($_POST['patient'])){$searchpatient = $_POST['patient'];}else{$searchpatient="";}
if(isset($_POST['patientcode'])){$searchpatientcode=$_POST['patientcode'];}else{$searchpatientcode="";}
if(isset($_POST['visitcode'])){$searchvisitcode = $_POST['visitcode'];}else{$searchvisitcode="";}
$query112 = "select * from master_department where auto_number = '$department'";
$exec112 = mysql_query($query112) or die ("Error in Query112".mysql_error());
$res112 = mysql_fetch_array($exec112);
$res112department = $res112['department'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
if ($frmflag2 == 'frmflag2')
{
foreach($_POST['visit'] as $key => $value)
{
 $visit = $_POST['visit'][$key];
 
foreach($_POST['select'] as $check)
		{
		$acknow=$check;
		if($acknow == $visit)
		{
		
		$query33 = "update master_triage set daycare='1' where visitcode='$visit'";
		$exec33 = mysql_query($query33) or die(mysql_error());
		}
		}
		}

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
.number
{
padding-left:800px;
text-align:right;
font-weight:bold;
}
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">

function cbcustomername1()
{
	document.cbform1.submit();
}

</script>
<script type="text/javascript" src="js/autocomplete_customer1.js"></script>
<script type="text/javascript" src="js/autosuggest3.js"></script>
<script type="text/javascript">
/*
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchcustomername"), new StateSuggestions());        
}
*/

function disableEnterKey(varPassed)
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
	
	var key;
	if(window.event)
	{
		key = window.event.keyCode;     //IE
	}
	else
	{
		key = e.which;     //firefox
	}

	if(key == 13) // if enter key press
	{
		//alert ("Enter Key Press2");
		return false;
	}
	else
	{
		return true;
	}
}

function searchcheck()
{

var visitcode = document.getElementById("visitcode").value;
if(visitcode == '')
{
alert("Please Key In Visit Code");
return false;
}
}


</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>

<body>
<?php 

$querynw1 = "select * from master_billing where patientfullname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and paymentstatus = 'completed' and triagestatus='pending' order by auto_number desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execnw1 = mysql_query($querynw1) or die ("Error in Query1".mysql_error());
			$resnw1=mysql_num_rows($execnw1);
			$query1 = "select * from master_visitentry where  patientfullname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and planfixedamount='0.00' and planpercentage='0.00' and triagestatus='pending' order by auto_number desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$resnw2=mysql_num_rows($exec1);
		$resnw3=$resnw1+$resnw2;
			?>

<table width="103%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
   <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="105%" border="0" cellspacing="0" cellpadding="0">
	      
		  <tr>
        <td width="1152">
              <form name="cbform1" method="post" action="triagebillinglist.php" onSubmit="return searchcheck()">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
				  <input name="patient" type="hidden" id="patient" value="" size="50" autocomplete="off">
					 
												<input name="patientcode" type="hidden" id="patientcode" value="" size="50" autocomplete="off">
					 
					   <tr>
					  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Visit No </td>
					  <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
						<input name="visitcode" type="text" id="visitcode" value="" size="50" autocomplete="off">
					  </span></td>
             		 </tr>
					<tr>
			 <!--<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Department</td>
				  <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><strong>
				    <select name="department" id="department">
                      <option value="">Select Department</option>
                      <?php
				     $query51 = "select * from master_department where recordstatus <> 'deleted' ";
				     $exec51 = mysql_query($query51) or die ("Error in Query51".mysql_error());
				     while ($res51 = mysql_fetch_array($exec51))
				       {
				       $res51anum = $res51["auto_number"];
				       $res51department = $res51["department"];
				       ?>
					  
                      <option value="<?php echo $res51anum; ?>" ><?php echo $res51department; ?></option>
                      <?php
				     }
				  ?>
                    </select>
				  </strong></td>
			</tr>-->
			
			<tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
					  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input  type="submit" value="Search" name="Submit" />
                          <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>
                  </tr>
                  </tbody>
                </table>
            </form>		</td>
      </tr>
	  
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  <form name="form1" id="form1" method="post" action="triagebillinglist.php">	
  <?php
		  if ($searchvisitcode != '') {
		  
		  
		  ?>
          
  <tr>
    
    <td width="1152" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1124" 
            align="left" border="0">
          <tbody>
		    <tr>
              <td width="3%" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
              <td colspan="10" bgcolor="#cccccc" class="bodytext31"><script language="javascript">
				function printbillreport1()
				{
					window.open("print_collectionpendingreport1hospital.php?<?php echo $urlpath; ?>","Window1",'width=900,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
					//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
				}
				function printbillreport2()
				{
					window.location = "dbexcelfiles/CollectionPendingByPatientHospital.xls"
				}
				</script>
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
                <div align="left"><strong>Triage Billing</strong><label class="number">&nbsp;</label></div></td>
              </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>No.</strong></div></td>
				 <td width="7%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>OP Date </strong></div></td>
				<td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient code </strong></div></td>
					<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit code </strong></div></td>
              <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> Patient Name </strong></div></td>
              <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> Age </strong></div></td>
				 <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> Gender </strong></div></td>
              <td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Department </strong></div></td>
             
              <td width="7%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Status</strong></td>
              <td width="11%"  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Action</strong></div></td>
				 <td width="14%"  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Add Day Care</strong></div></td>
              </tr>
			<?php
			$colorloopcount = '';
			$sno = '';
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			
			

			$triagedatefrom = date('Y-m-d', strtotime('-2 day'));
			$triagedateto = date('Y-m-d');
			$query1 = "select * from master_billing where patientfullname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and paymentstatus = 'completed' order by auto_number desc";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			while ($res1 = mysql_fetch_array($exec1))
			{
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['visitcode'];
			$patientfirstname = $res1['patientfirstname'];
			$patientmiddlename=$res1['patientmiddlename'];
			$patientlastname = $res1['patientlastname'];
			$consultingdoctorname = $res1['consultingdoctor'];
			$department1111 = $res1['department'];
			
			$query1pay = "select * from master_visitentry where patientcode like '%$patientcode%' and visitcode like '%$visitcode%' and billtype <> 'PAY NOW' order by auto_number desc";
			$exec1pay = mysql_query($query1pay) or die ("Error in Query1pay".mysql_error());
			$nums1pay = mysql_num_rows($exec1pay);
			
			if($nums1pay == 0)
			{
			$query32 = "select * from master_visitentry where patientcode = '$patientcode'";
			$exec32 = mysql_query($query32) or die(mysql_error());
			$res32 = mysql_fetch_array($exec32);
			$age = $res32['age'];
			$gender = $res32['gender'];
			//$query2 = "select * from master_doctor where auto_number = '$consultingdoctoranum'";
			//$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			//$res2 = mysql_fetch_array($exec2);
			//$consultingdoctorname  = $res2['doctorname'];
			
			$consultationdate = $res1['consultationdate'];
			$consultationtime = $res1['consultationtime']; 
			$consultationfees = $res1['consultationfees'];
			$accountname=$res1['accountname'];	
			
			$query5 = "select * from master_employeedepartment where department = '$department1111' and username='$username'";
			$exec5 = mysql_query($query5) or die ("Error in Query2".mysql_error());
			$num5 = mysql_num_rows($exec5);
			
			
			if($num5 > 0)
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
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $consultationdate; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $patientfirstname.' '.$patientmiddlename.' '.$patientlastname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $age;?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo strtoupper($gender);?></div></td>
             <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $department1111;?></div></td>
             
              <td class="bodytext31" valign="center"  align="left"><strong>Pending</strong></td>
              <td class="bodytext31" valign="center"  align="left">
			   <?php if(strcmp(trim($department1111),"MCH  CONSULTATION")==0)
			  {?>
			    <div align="left"><a href="addretriage.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>"><strong>Re-Triage</strong></a>&nbsp;&nbsp;
				<a href="mchtriagebilling.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>"><strong>Billing</strong></a></div>
				<?php } else{?>
				<div align="left"><a href="addretriage.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>"><strong>Re-Triage</strong></a>&nbsp;&nbsp;
				<a href="triagebilling.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>"><strong>    Billing</strong></a></div>
				<?php }?>
				</td>
				<td class="bodytext31" valign="center"  align="center">
				<input type="hidden" name="visit[]" id="visit" value="<?php echo $visitcode; ?>">
				<input type="checkbox" name="select[]" id="select" value="<?php echo $visitcode; ?>"></td>
              </tr>
			<?php
			}    
			}
			}
			?>
			<?php
			
			$query1 = "select * from master_visitentry where billtype <> 'PAY NOW' and complaint <> '0' and consultationfees <> '0' and patientfullname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and planfixedamount='0.00' and planpercentage='0.00' order by auto_number desc";
			
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			while ($res1 = mysql_fetch_array($exec1))
			{
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['visitcode'];
			$patientfirstname = $res1['patientfirstname'];
			$patientmiddlename=$res1['patientmiddlename'];
			$patientlastname = $res1['patientlastname'];
			$consultingdoctorname = $res1['consultingdoctor'];
			$res1department = $res1['departmentname'];
			$age = $res1['age'];
			$gender = $res1['gender'];
			
			/*$query111 = "select * from master_department where auto_number='$res1department' and recordstatus=''";
			$exec111 = mysql_query($query111) or die(mysql_error());
			$res111 = mysql_fetch_array($exec111);
			$res111department = $res111['department'];*/
			
			$query32="select * from master_doctor where auto_number='$consultingdoctorname'";
			$exec32=mysql_query($query32) or die(mysql_error());
			$res32=mysql_fetch_array($exec32);
			$doctorname=$res32['doctorname'];
			
			//$query2 = "select * from master_doctor where auto_number = '$consultingdoctoranum'";
			//$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			//$res2 = mysql_fetch_array($exec2);
			//$consultingdoctorname  = $res2['doctorname'];
			
			$consultationdate = $res1['consultationdate'];
			$consultationtime = $res1['consultationtime']; 
			$consultationfees = $res1['consultationfees'];
			$accountname=$res1['accountname'];	
			$query33="select * from master_accountname where auto_number='$accountname'";
			$exec33=mysql_query($query33) or die(mysql_error());
			$res33=mysql_fetch_array($exec33);
			$accname=$res33['accountname'];
			
			$query5 = "select * from master_employeedepartment where department = '$res1department' and username='$username'";
			$exec5 = mysql_query($query5) or die ("Error in Query2".mysql_error());
			$num5 = mysql_num_rows($exec5);
			
			
			if($num5 > 0)
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
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $consultationdate; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $patientfirstname.' '.$patientmiddlename.' '.$patientlastname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $age;?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo strtoupper($gender);?></div></td>
             <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res1department;?></div></td>
             
              <td class="bodytext31" valign="center"  align="left"><strong>Pending</strong></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php 
			   if(strcmp(trim($res1department),"MCH  CONSULTATION")==0)
			  {?>
			    <div align="left"><a href="addretriage.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>"><strong>Re-Triage</strong></a>&nbsp;&nbsp;
				<a href="mchtriagebilling.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>"><strong> Billing</strong></a></div>
				<?php } else{?>
				<div align="left"><a href="addretriage.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>"><strong>Re-Triage</strong></a>&nbsp;&nbsp;
				<a href="triagebilling.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>"><strong> Billing</strong></a></div>
				<?php }?>
				</td>
				<td class="bodytext31" valign="center"  align="center">
				<input type="hidden" name="visit[]" id="visit" value="<?php echo $visitcode; ?>">
				<input type="checkbox" name="select[]" id="select" value="<?php echo $visitcode; ?>"></td>
              </tr>
			<?php
			}    
			}
			?>
			<?php
			
			$query1 = "select * from master_visitentry where patientfullname like '%$searchpatient%' and complaint <> '0' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and consultationfees='0' order by auto_number desc";
			
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			while ($res1 = mysql_fetch_array($exec1))
			{
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['visitcode'];
			$patientfirstname = $res1['patientfirstname'];
			$patientmiddlename=$res1['patientmiddlename'];
			$patientlastname = $res1['patientlastname'];
			$consultingdoctorname = $res1['consultingdoctor'];
			$res1department = $res1['departmentname'];
			$age = $res1['age'];
			$gender = $res1['gender'];
			
			/*$query111 = "select * from master_department where auto_number='$res1department' and recordstatus=''";
			$exec111 = mysql_query($query111) or die(mysql_error());
			$res111 = mysql_fetch_array($exec111);
			$res111department = $res111['department'];*/
			
			$query32="select * from master_doctor where auto_number='$consultingdoctorname'";
			$exec32=mysql_query($query32) or die(mysql_error());
			$res32=mysql_fetch_array($exec32);
			$doctorname=$res32['doctorname'];
			
			//$query2 = "select * from master_doctor where auto_number = '$consultingdoctoranum'";
			//$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			//$res2 = mysql_fetch_array($exec2);
			//$consultingdoctorname  = $res2['doctorname'];
			
			$consultationdate = $res1['consultationdate'];
			$consultationtime = $res1['consultationtime']; 
			$consultationfees = $res1['consultationfees'];
			$accountname=$res1['accountname'];	
			$query33="select * from master_accountname where auto_number='$accountname'";
			$exec33=mysql_query($query33) or die(mysql_error());
			$res33=mysql_fetch_array($exec33);
			$accname=$res33['accountname'];
			
			$query5 = "select * from master_employeedepartment where department = '$res1department' and username='$username'";
			$exec5 = mysql_query($query5) or die ("Error in Query2".mysql_error());
			$num5 = mysql_num_rows($exec5);
			
			
			if($num5 > 0)
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
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $consultationdate; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $patientfirstname.' '.$patientmiddlename.' '.$patientlastname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $age;?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo strtoupper($gender);?></div></td>
             <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res1department;?></div></td>
             
              <td class="bodytext31" valign="center"  align="left"><strong>Pending</strong></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php 
			   if(strcmp(trim($res1department),"MCH  CONSULTATION")==0)
			  {?>
			    <div align="left"><a href="addretriage.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>"><strong>Re-Triage</strong></a>&nbsp;&nbsp;
				<a href="mchtriagebilling.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>"><strong> Billing</strong></a></div>
				<?php } else{?>
				<div align="left"><a href="addretriage.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>"><strong>Re-Triage</strong></a>&nbsp;&nbsp;
				<a href="triagebilling.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>"><strong> Billing</strong></a></div>
				<?php }?>
				</td>
				<td class="bodytext31" valign="center"  align="center">
				<input type="hidden" name="visit[]" id="visit" value="<?php echo $visitcode; ?>">
				<input type="checkbox" name="select[]" id="select" value="<?php echo $visitcode; ?>"></td>
              </tr>
			<?php
			}    
			}
			
			?>
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
        </table></td>
      </tr>
    </table>
	</td>
	</tr>
	<tr>
	   <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
	  </tr>
	  <tr>
	  <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
	  <td width="241"  align="left" valign="center" class="bodytext31">
	   <input type="hidden" name="frmflag2" value="frmflag2" />
	  
	    <input type="submit" name="submit" value="Submit"></td>
	  </tr>
	   <?php
			  }
			  ?>
	</form>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

