<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysql_query($query) or die ("Error in Query1".mysql_error());
$res = mysql_fetch_array($exec);
	
	 $locationname  = $res["locationname"];
	 $locationcode = $res["locationcode"];
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
padding-left:650px;
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

<script type="text/javascript">
function pharmacy(patientcode,visitcode)
{
	var patientcode = patientcode;
	var visitcode = visitcode;
	var url="pharmacy1.php?RandomKey="+Math.random()+"&&patientcode="+patientcode+"&&visitcode="+visitcode;
	
window.open(url,"Pharmacy",'width=600,height=400');
}
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
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; }
-->
</style>
</head>
<body>

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
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1042" 
            align="left" border="0">
          <tbody>
            <tr>
              <td colspan="10" bgcolor="#cccccc" class="bodytext31">
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
                <div align="left"><strong>New Born Activity</strong><label class="number"></label>
                </div></td>
              </tr>
            <tr>
              <td width="2%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>No.</strong></div></td>
				 <td width="8%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Date</strong></div></td>
         
             <td width="17%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient</strong></div></td>
              <td width="7%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Age</strong></td>
              <td width="7%"  align="left" valign="center" 
                bgcolor="#ffffff" class="style1">Gender</td>
              <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patientcode </strong></div></td>
              <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visitcode</strong></div></td>
              <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Dept.</strong></div></td>
              <td width="17%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Account</strong></td>
              <td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Action</strong></div></td>
              </tr>
		
			<?php
			$colorloopcount = '';
			$sno = '';
			
			$triagedatefrom = date('Y-m-d', strtotime('-2 day'));
			$triagedateto = date('Y-m-d');
		
				//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
				$query55 = "select ip_dept from master_employee where username = '$username'";
				$exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
				$res55 = mysql_fetch_array($exec55);
				 $userdept = $res55["ip_dept"];
				
			if($userdept=='all')
			{	
				
		//	$query1 = "select * from master_ipvisitentry where (deposit='' or deposit='notapplicable') and paymentstatus = '' and discharge = '' group by visitcode order by auto_number desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			
	
			$query1 = "select * from master_ipvisitentry where paymentstatus = '' and discharge = '' group by visitcode order by auto_number desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			
}
			else
			{
			//$query1 = "select * from master_ipvisitentry where department='$userdept' and (deposit='' or deposit='notapplicable') and paymentstatus = '' and discharge = '' group by visitcode order by auto_number desc";// and (billingdatetime between '$triagedatefrom' and '$triageda//teto')";//
			$query1 = "select * from master_ipvisitentry where department='$userdept' and paymentstatus = '' and discharge = '' group by visitcode order by auto_number desc";// and (billingdatetime between '$triagedatefrom' and '$triageda//teto')";//

			}
			//echo $query1;
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			while ($res1 = mysql_fetch_array($exec1))
			{
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['visitcode'];
			$patientfullname = $res1['patientfullname'];
			$account = $res1['accountname'];
			$date = $res1['consultationdate'];
			$departmentanum = $res1['department'];
			
				$query505 = "select department from master_ipadmdept where recordstatus = '' and deptid='$departmentanum'";
				$exec505 = mysql_query($query505) or die ("Error in Query505".mysql_error());
				$res505 = mysql_fetch_array($exec505);
				
				$department = $res505["department"];
			
			$querys = "SELECT * FROM master_customer where customercode = '$patientcode' ";
			$execs = mysql_query($querys) or die ("Error in Query4".mysql_error());
			$ress = mysql_fetch_array($execs);
			$dob = $ress['dateofbirth'];
			$res10age = $ress['age'];
			$res10gender = $ress['gender'];
			$days = (strtotime($date) - strtotime($dob))/86400;
			if($days <= 5)
			{
					
				$query4 = "select * from master_accountname where auto_number = '$account'";
				$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
				$res4 = mysql_fetch_array($exec4);
				$accountnameanum = $res4['auto_number'];
				$accountname = $res4['accountname'];
				
				
				$query51 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode' and bedallocation='completed'";
				$exec51 = mysql_query($query51) or die(mysql_error());
				$num51 = mysql_num_rows($exec51);
				if($num51 > 0)
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
						   <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $date; ?></div></td>
							 <td class="bodytext31" valign="center"  align="left">
							<div align="left"><?php echo $patientfullname; ?></div></td>
					
							 <td class="bodytext31" valign="center"  align="left"><?php echo $res10age; ?></td>
							 <td class="bodytext31" valign="center"  align="left"><?php echo $res10gender; ?></td>
							 <td class="bodytext31" valign="center"  align="left">
							<div align="left">
							  <?php echo $patientcode;?>			      </div></td>
						  <td class="bodytext31" valign="center"  align="left">
							<a href="ipquickview.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>" target="_blank"><div align="left"><?php echo $visitcode; ?></div></a></td>
							 <td class="bodytext31" valign="center"  align="left"><?php echo $department; ?></td>
							 <td class="bodytext31" valign="center"  align="left"><?php echo $accountname; ?></td>
						  <td class="bodytext31" valign="center" align="left">
							<select name="order" id="order" onChange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
									<option>Select Order</option>
									<option value="ipmedicineissue.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&patientlocation=<?php echo $locationcode; ?>&&frompage=newborn">Medicine Issue</option>
									<option value="newborniptests.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&patientlocation=<?php echo $locationcode; ?>&&frompage=newborn">Tests and Procedures</option>
									<option value="ipotbilling.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&patientlocation=<?php echo $locationcode; ?>&&frompage=newborn">OT Billing</option>
									<option value="ipprivatedoctor.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&patientlocation=<?php echo $locationcode; ?>&&frompage=newborn">Private Doctor</option>
									<option value="ipdrugchart.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&patientlocation=<?php echo $locationcode; ?>&&frompage=newborn">Drug Chart</option>
									<!--<option value="vitalio.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&patientlocation=<?php echo $locationcode; ?>&&frompage=newborn">Vital I/O</option>-->
									<option value="newbornvitals.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&patientlocation=<?php echo $locationcode; ?>&&frompage=newborn">Vitals</option>
									<option value="newbornfluidbalance.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&patientlocation=<?php echo $locationcode; ?>&&frompage=newborn">Input / Output</option>
									<option value="ipprogressnotes.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&patientlocation=<?php echo $locationcode; ?>&&frompage=newborn">Nursing Cardex</option>
									<option value="ipdoctornotes.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&patientlocation=<?php echo $locationcode; ?>&&frompage=newborn">Doctors Notes</option>
									<option value="ipotrequest.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&patientlocation=<?php echo $locationcode; ?>&&frompage=newborn">OT Request</option>
									<option value="ipdischarge.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&patientlocation=<?php echo $locationcode; ?>&&frompage=newborn">Discharge</option>
							</select></td>
			    </tr>
						<?php
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

