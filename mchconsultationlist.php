<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = $transactiondatefrom; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = $transactiondateto; }
if (isset($_REQUEST["patientname1"])) { $patientname1 = $_REQUEST["patientname1"]; } else { $patientname1 = ''; }
if (isset($_REQUEST["patientcode1"])) { $patientcode1 = $_REQUEST["patientcode1"]; } else { $patientcode1 = ''; }
if (isset($_REQUEST["visitcode1"])) { $visitcode1 = $_REQUEST["visitcode1"]; } else { $visitcode1 = ''; }
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
}
-->
</style>
<script src="js/datetimepicker_css.js"></script>
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
	$query1 = "select * from master_visitentry where department='3' and doctorconsultation <> 'completed' order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			$resnw3=mysql_num_rows($exec1);
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
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
		  <form name="cbform1" method="post" action="mchconsultationlist.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#CCCCCC" class="bodytext3"><strong>MCH Consultation List</strong></td>
            </tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Name</td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="patientname1" type="text" id="patientname1" value="" size="50" autocomplete="off">
              </span></td>
            </tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Registration No</td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="patientcode1" type="text" id="patientcode1" value="" size="50" autocomplete="off">
              </span></td>
            </tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Visitcode</td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="visitcode1" type="text" id="visitcode1" value="" size="50" autocomplete="off">
              </span></td>
            </tr>
            <tr>
              <td width="13%"  align="left" valign="center" 
                bgcolor="#FFFFFF" class="bodytext31">Date From </td>
              <td width="38%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                  <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
              <td width="11%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">Date To </td>
              <td width="38%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
            </tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			       <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
            </tr>
          </tbody>
        </table>
		 </form>
		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="900" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>No.</strong></div></td>
				 <td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>OP Date </strong></div></td>
				<td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient code </strong></div></td>
					<td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit code </strong></div></td>
              <td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> Patient Name </strong></div></td>
              <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Gender </strong></div></td>
				  <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Age </strong></div></td>
             
              <td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account</strong></div></td>
              <td width="11%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Status</strong></td>
              <td width="11%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Action</strong></div></td>
              </tr>
	
			<?php
			
			
			$colorloopcount = '';
			$sno = '';
			
			$triagedatefrom = date('Y-m-d', strtotime('-2 day'));
			$triagedateto = date('Y-m-d');
		
			$query1 = "select * from master_visitentry where patientcode like '%$patientcode1' and visitcode like '%$visitcode1%' and patientfullname like '%$patientname1%' and consultationdate between '$ADate1' and '$ADate2' and department='7' and doctorconsultation <> 'completed' order by auto_number desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			while ($res1 = mysql_fetch_array($exec1))
			{
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['visitcode'];
			$patientfirstname = $res1['patientfirstname'];
			$patientmiddlename=$res1['patientmiddlename'];
			$patientlastname = $res1['patientlastname'];
			$consultingdoctorname = $res1['consultingdoctor'];
			$age = $res1['age'];
			$gender = $res1['gender'];
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
			
			$query11 = "select * from master_triage where visitcode='$visitcode' and closesvisits = ''";
			$exec11 = mysql_query($query11) or die(mysql_query());
			$num11 = mysql_num_rows($exec11);
			
			if($num11 > 0)
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
			    <div align="left">
			      <?php echo $gender;?>			      </div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $age;?>			      </div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $accname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><strong>Pending</strong></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><a href="mchconsultationform.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>"><strong>Consult</strong></a></div></td>
              </tr>
			<?php
			}    
			}
			?>
			<?php
				$query11 = "select * from master_visitentry where patientcode like '%$patientcode1' and visitcode like '%$visitcode1%' and patientfullname like '%$patientname1%' and consultationdate between '$ADate1' and '$ADate2' and referalconsultation <> 'completed' order by auto_number desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec11 = mysql_query($query11) or die ("Error in Query1".mysql_error());
			while ($res11 = mysql_fetch_array($exec11))
			{
			$patientcode1 = $res11['patientcode'];
			$visitcode1 = $res11['visitcode'];
			$patientfirstname1 = $res11['patientfirstname'];
			$patientmiddlename1=$res11['patientmiddlename'];
			$patientlastname1 = $res11['patientlastname'];
			$consultingdoctorname1 = $res11['consultingdoctor'];
			$billtype = $res11['billtype'];
			$referalbill = $res11['referalbill'];
			$age = $res11['age'];
			$gender = $res11['gender'];
			$query321="select * from master_doctor where auto_number='$consultingdoctorname1'";
			$exec321=mysql_query($query321) or die(mysql_error());
			$res321=mysql_fetch_array($exec321);
			$doctorname1=$res321['doctorname'];
			
			//$query2 = "select * from master_doctor where auto_number = '$consultingdoctoranum'";
			//$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			//$res2 = mysql_fetch_array($exec2);
			//$consultingdoctorname  = $res2['doctorname'];
			
			$consultationdate1 = $res11['consultationdate'];
			$consultationtime1 = $res11['consultationtime']; 
			$consultationfees1 = $res11['consultationfees'];
			$accountname1=$res11['accountname'];	
			$query331="select * from master_accountname where auto_number='$accountname1'";
			$exec331=mysql_query($query331) or die(mysql_error());
			$res331=mysql_fetch_array($exec331);
			$accname1=$res331['accountname'];
			
			if($billtype == 'PAY NOW')
			{
			if($referalbill == 'completed')
			{
			
			$query12 = "select * from consultation_departmentreferal where patientvisitcode='$visitcode1' and referalcode = '7' and consultation = '' and paymentstatus = 'completed'";
			$exec12 = mysql_query($query12) or die(mysql_error());
			$num12 = mysql_num_rows($exec12);
		
		if($num12 > 0)
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
			    <div align="left"><?php echo $consultationdate1; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientcode1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $visitcode1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $patientfirstname1.' '.$patientmiddlename1.' '.$patientlastname1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $gender;?>			      </div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $age;?>			      </div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $accname1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><strong>Pending</strong></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><a href="mchconsultationform.php?patientcode=<?php echo $patientcode1; ?>&&visitcode=<?php echo $visitcode1; ?>"><strong>Consult</strong></a></div></td>
              </tr>
			<?php
			}
			}
			}    
			if($billtype == 'PAY LATER')
			{
			if($referalbill == '')
			{
			
			$query12 = "select * from consultation_departmentreferal where patientvisitcode='$visitcode1' and referalcode = '7' and consultation = ''";	
			$exec12 = mysql_query($query12) or die(mysql_error());
			$num12 = mysql_num_rows($exec12);
		
		if($num12 > 0)
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
			    <div align="left"><?php echo $consultationdate1; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientcode1; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $visitcode1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $patientfirstname1.' '.$patientmiddlename1.' '.$patientlastname1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $gender;?>			      </div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $age;?>			      </div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $accname1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><strong>Pending</strong></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><a href="mchconsultationform.php?patientcode=<?php echo $patientcode1; ?>&&visitcode=<?php echo $visitcode1; ?>"><strong>Consult</strong></a></div></td>
              </tr>
			<?php
			}
			}
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
              </tr>
          </tbody>
        </table></td>
      </tr>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

