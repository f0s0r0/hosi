<html>
<?php 
session_start();
include ("db/db_connect.php"); ?>
<?php

$timeonly = date('H:i:s');
$updatedatetime = date('Y-m-d H:i:s');
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');
$username = $_SESSION['username'];

$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysql_query($query) or die ("Error in Query1".mysql_error());
$res = mysql_fetch_array($exec);
	
	 $locationname  = $res["locationname"];
	 $locationcode = $res["locationcode"];
	$res12locationanum = $res["auto_number"];
if(isset($_POST['patient'])){$searchpatient = $_POST['patient'];}else{$searchpatient="";}
if(isset($_POST['patientcode'])){$searchpatientcode=$_POST['patientcode'];}else{$searchpatientcode="";}
if(isset($_POST['visitcode'])){$searchvisitcode = $_POST['visitcode'];}else{$searchvisitcode="";}
if(isset($_POST['ADate1'])){$fromdate = $_POST['ADate1'];}else{$fromdate=$transactiondatefrom;}
if(isset($_POST['ADate2'])){$todate = $_POST['ADate2'];}else{$todate=$transactiondateto;}


?>

<?php
//get location for sort by location purpose
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
	if($location!='')
	{
		 $locationcode=$location;
		}
		//location get end here
		?>
<style>
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.linking
{
text-decoration:none;
}
.curdatt
{
position:absolute; left:350px;
font-weight:bold;
}
</style>
<script type="text/javascript">

function ajaxlocationfunction(val)
{ 
if (window.XMLHttpRequest)
					  {// code for IE7+, Firefox, Chrome, Opera, Safari
					  xmlhttp=new XMLHttpRequest();
					  }
					else
					  {// code for IE6, IE5
					  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
					  }
					xmlhttp.onreadystatechange=function()
					  {
					  if (xmlhttp.readyState==4 && xmlhttp.status==200)
						{
						document.getElementById("ajaxlocation").innerHTML=xmlhttp.responseText;
						}
					  }
					xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);
					xmlhttp.send();
}

function date_time1(id1)
{

        date1 = new Date;
        year1 = date1.getFullYear();
        month1 = date1.getMonth();
        months1 = new Array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        d1 = date1.getDate();
        day1 = date1.getDay();
        days1 = new Array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
        h1 = date1.getHours();
        if(h1<10)
        {
                h1 = "0"+h1;
        }
        m1 = date1.getMinutes();
        if(m1<10)
        {
                m1 = "0"+m1;
        }
        s1 = date1.getSeconds();
        if(s1<10)
        {
                s1 = "0"+s1;
        }
        result1 = ''+days1[day1]+', '+months1[month1]+' '+d1+', '+year1;
        document.getElementById(id1).innerHTML = result1;
        setTimeout('date_time1("'+id1+'");','1000');
        return true;
}
</script>
<script src="js/datetimepicker_css.js"></script>
<body>
<table>
<tr>
   
    <td width="99%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	 <tr>
	 <td width="860">
              <form name="cbform1" method="post" action="consultationlistiframe.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr>
					  <td colspan="1" align="left" valign="middle"  bgcolor="#cccccc" class="bodytext3"><strong>Consultation List<strong>
					  <span id="date_time1" class="curdatt"></span><script type="text/javascript">date_time1('date_time1');</script></td>
                       <td colspan="3" align="left" bgcolor="#CCCCCC" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
                  <?php
							
						if ($location!='')
						{
						$query12 = "select locationname from master_location where locationcode='$location' order by locationname";
						$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
						$res12 = mysql_fetch_array($exec12);
						
						echo $res1location = $res12["locationname"];
						//echo $location;
						}
						else
						{
						$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						$res1 = mysql_fetch_array($exec1);
						
						echo $res1location = $res1["locationname"];
						//$res1locationanum = $res1["locationcode"];
						}
						?>
						
						
                  
                  </td>
                      
				    </tr>
                     <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
               <select name="location" id="location" onChange="  ajaxlocationfunction(this.value);"  style="border: 1px solid #001E6A;">
                  <?php
						
						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						while ($res1 = mysql_fetch_array($exec1))
						{
						$res1location = $res1["locationname"];
						$res1locationanum = $res1["locationcode"];
						?>
						<option value="<?php echo $res1locationanum; ?>" <?php if($location!='')if($location==$res1locationanum){echo "selected";}?>><?php echo $res1location; ?></option>
						<?php
						}
						?>
                  </select>
              </span></td>
              </tr>
                    <tr>
					  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Name</td>
					  <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
						<input name="patient" type="text" id="patient" value="" size="50" autocomplete="off">
					  </span></td>
				    </tr>
						<tr>
					  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Registration No</td>
					  <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
						<input name="patientcode" type="text" id="patient" value="" size="50" autocomplete="off">
					  </span></td>
					  </tr>
					   <tr>
					  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Visit No </td>
					  <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
						<input name="visitcode" type="text" id="visitcode" value="" size="50" autocomplete="off">
					  </span></td>
             		 </tr>
					 <tr>
          <td width="100" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="137" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="68" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td width="263" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
            <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
          </tr>
			 			
				<tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
					  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input  type="submit" value="Search" name="Submit" />
                          <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>
                    </tr>
                  </tbody>
                </table>
              </form></td>
	 </tr>     
      
	  <tr>
        <td><table width="100%" height="80" border="0" 
            align="left" cellpadding="2" cellspacing="0" 
            bordercolor="#666666" id="AutoNumber3" style="BORDER-COLLAPSE: collapse" >
          <tbody>
			<tr>
				<td colspan="2" class="bodytext31">&nbsp;</td>
				<td colspan="4" class="bodytext31" align="right"><label><strong>&nbsp;</strong></label></td>
			</tr>
	
            <tr>
	              <td width="60%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> Patient</strong></div></td>
   				  <td width="12%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Department</strong></div></td>
              <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Consultant</strong></td>
			      <td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Status</strong></div></td>
				  <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong> Time(Mins)</strong></td>
              </tr>
			
			<?php
			
			$colorloopcount = '';
			$sno = '';
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			
			$query1 = "select * from master_triage where patientfullname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and triagestatus = 'completed' and ipconvert='' and daycare <> '1' and closesvisits = '' and registrationdate between '$fromdate' and '$todate' and locationcode='$locationcode' order by auto_number desc ";
			
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			while ($res1 = mysql_fetch_array($exec1))
			{
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['visitcode'];
			$patientfirstname = $res1['patientfirstname'];
			$patientmiddlename=$res1['patientmiddlename'];
			$patientlastname = $res1['patientlastname'];
			$patientfullname = $res1['patientfullname'];
			$consultingdoctorname = $res1['consultingdoctor'];
			$res1consultationdate = $res1['consultationdate'];
			$department = $res1['department'];
			$res1consultationdate = date('Y-m-d',strtotime($res1consultationdate));
			
			//$query2 = "select * from master_doctor where auto_number = '$consultingdoctoranum'";
			//$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			//$res2 = mysql_fetch_array($exec2);
			//$consultingdoctorname  = $res2['doctorname'];
			
			$consultationdate = $res1['consultationdate'];
			$consultationtime = $res1['consultationtime']; 
			$consultationfees = $res1['consultationfees'];
			$urgentstatus = $res1['urgentstatus'];
			$accountname= $res1['accountname'];
			$consultation=$res1['consultation'];
			$consultationtype=$res1['consultationtype'];
			$token = $res1['token'];
			
			
			if($consultation == 'incomplete')
			{
			$status = 'Pending';
			}
			if($consultation == 'Inprogress')
			{
			$status = 'Inprogress';
			}
			if($consultation == 'completed')
			{
			$status = 'Completed';
			}
			
			$waitingtime = (strtotime($timeonly) - strtotime($consultationtime))/60;
			$waitingtime = round($waitingtime);
			
			if($status == 'Pending')
			{
			
			$waitingtime1 = $waitingtime;
			}
			else
			{
			$waitingtime1 = '';
			}

			
			$query21 = "select * from master_consultationlist where visitcode='$visitcode'  order by auto_number";
			$exec21 = mysql_query($query21) or die(mysql_error());
			$num21 = mysql_num_rows($exec21);
			
			$res21 = mysql_fetch_array($exec21);
			$consultationdatetime = $res21['consultationdate'];
			$consultationdatetime = strtotime($consultationdatetime . ' + 1 day');
			$updatedatetime = strtotime($updatedatetime);
			
			$query22 = "select * from master_visitentry where visitcode='$visitcode' and locationcode='$locationcode'";
			$exec22 = mysql_query($query22) or die(mysql_error());
			$res22 = mysql_fetch_array($exec22);
			$age = $res22['age'];
			$gender = $res22['gender'];
			
			$query5 = "select * from master_employeedepartment where department = '$department' and username='$username'";
			$exec5 = mysql_query($query5) or die ("Error in Query2".mysql_error());
			$num5 = mysql_num_rows($exec5);
			
			
			if($num5 > 0)
			{
			
			
				if($num21 == 0)
				{
				
				
				
				if($status != 'Completed')
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
			
				if($urgentstatus == 1)
				{
				$colorcode = 'bgcolor="FFFF00"';
				}
				?>
				<tr <?php echo $colorcode; ?>>
				  <td class="bodytext31" valign="center"  align="left">
				  <?php if(strcmp(trim($department),"MCH �CONSULTATION") == 0)
			       {
				   ?>								  				
					  <div>
						  <a class="linking" target="_parent" href="mchconsultationform.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">
						  <strong><?php echo $patientfullname; ?> (<?php echo $patientcode; ?>,<?php echo $visitcode; ?>),<?php echo $gender; ?>,<?php echo $age; ?></strong>						                          </a>					  
					  </div>
			          <?php } else  if(strcmp(trim($department),"TB")==0){ ?>
					   
						   <a class="linking" target="_parent" href="tbconsultationform.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">
						   <strong><?php echo $patientfullname; ?> (<?php echo $patientcode; ?>,<?php echo $visitcode; ?>),<?php echo $gender; ?>,<?php echo $age; ?></strong>
						   </a>
					   <?php } else { ?>
					   <div>
						   <a class="linking" target="_parent" href="consultationform.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">
						   <strong><?php echo $patientfullname; ?> (<?php echo $patientcode; ?>,<?php echo $visitcode; ?>),<?php echo $gender; ?>,<?php echo $age; ?></strong>
						   </a>
					   <?php }?>
					   </div> 	  
				  </td>  
			 
				 	<td class="bodytext31" valign="center"  align="left">
					<div align="left"><?php echo $department; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($consultationtype); ?></td>
				  <td class="bodytext31" valign="center"  align="left">
					<div align="left"><strong><?php echo $status; ?></strong></div></td>
				   <td class="bodytext31" valign="center"  align="center" <?php if($waitingtime1 > 15){ ?> bgcolor=" #FF0040" <?php } ?>><strong><?php echo $waitingtime1; ?></strong></td>
				  </tr>
				<?php
				}
				}
			} 
		}	
			 
			?>
			<?php
				$query111 = "select * from master_visitentry where patientfullname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and referalconsultation <> 'completed' and paymentstatus = 'completed' and consultationdate between '$fromdate' and '$todate' and locationcode='$locationcode' order by auto_number desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec111 = mysql_query($query111) or die ("Error in Query1".mysql_error());
			$num111 = mysql_num_rows($exec111);
			while ($res111 = mysql_fetch_array($exec111))
			{
			$patientcode1 = $res111['patientcode'];
			$visitcode1 = $res111['visitcode'];
			$patientfullname = $res111['patientfullname'];
			$patientfirstname1 = $res111['patientfirstname'];
			$patientmiddlename1=$res111['patientmiddlename'];
			$patientlastname1 = $res111['patientlastname'];
			$consultingdoctorname1 = $res111['consultingdoctor'];
			$billtype = $res111['billtype'];
			$referalbill = $res111['referalbill'];
			$age = $res111['age'];
			$gender = $res111['gender'];
			$query321="select * from master_doctor where auto_number='$consultingdoctorname1' and locationcode='$locationcode'";
			$exec321=mysql_query($query321) or die(mysql_error());
			$res321=mysql_fetch_array($exec321);
			$doctorname1=$res321['doctorname'];
			
			//$query2 = "select * from master_doctor where auto_number = '$consultingdoctoranum'";
			//$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			//$res2 = mysql_fetch_array($exec2);
			//$consultingdoctorname  = $res2['doctorname'];
			
			$consultationdate1 = $res111['consultationdate'];
			$consultationtime1 = $res111['consultationtime']; 
			$consultationfees1 = $res111['consultationfees'];
			$accountname1=$res111['accountname'];	
			$query331="select * from master_accountname where auto_number='$accountname1' and locationcode='$locationcode'";
			$exec331=mysql_query($query331) or die(mysql_error());
			$res331=mysql_fetch_array($exec331);
			$accname1=$res331['accountname'];
			
			if($billtype == 'PAY NOW')
			{
			if($referalbill == 'completed')
			{
			$query12 = "select * from consultation_departmentreferal where patientvisitcode='$visitcode1' and referalcode = '1' and consultation = '' and paymentstatus = 'completed' and locationcode='$locationcode' order by auto_number desc";
			$exec12 = mysql_query($query12) or die(mysql_error());
			$res12 = mysql_fetch_array($exec12);
			$num12 = mysql_num_rows($exec12);
			$department = $res12['referalname'];
			$stat = $res12['status'];
			$consultant = $res12['consultant'];
			$consultationtime = $res12['consultationtime'];
			
				if($stat == '')
			{
			$status = 'Pending';
			}
			if($stat == 'Inprogress')
			{
			$status = 'Inprogress';
			}
			if($stat == 'completed')
			{
			$status = 'Completed';
			}
			
			
			$waitingtime = (strtotime($timeonly) - strtotime($consultationtime))/60;
			$waitingtime = round($waitingtime);
			
			if($status == 'Pending')
			{
			
			$waitingtime = $waitingtime;
			}
			else
			{
			$waitingtime = '';
			}
			
		
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
				  <td class="bodytext31" valign="center"  align="left">
					   <div>
						   <a class="linking" target="_parent" href="consultationform.php?patientcode=<?php echo $patientcode1; ?>&&visitcode=<?php echo $visitcode1; ?>">
						   <strong><?php echo $patientfullname; ?> (<?php echo $patientcode1; ?>,<?php echo $visitcode1; ?>),<?php echo $gender; ?>,<?php echo $age; ?></strong>
						   </a>
					  
					   </div> 	  
				  </td>  
			 
				 	<td class="bodytext31" valign="center"  align="left">
					<div align="left"><?php echo $department; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($consultant); ?></td>
				  <td class="bodytext31" valign="center"  align="left">
					<div align="left"><strong><?php echo $status; ?></strong></div></td>
				   <td class="bodytext31" valign="center"  align="center" <?php if($waitingtime > 15){ ?> bgcolor=" #FF0040" <?php } ?>><strong><?php echo $waitingtime; ?></strong></td>
				  </tr>
			<?php
			}    
			}
			}
					if($billtype == 'PAY LATER')
			{
			if($referalbill == '')
			{
			
			$query12 = "select * from consultation_departmentreferal where patientvisitcode='$visitcode1' and referalcode = '1' and consultation = '' and locationcode='$locationcode'";
			$exec12 = mysql_query($query12) or die(mysql_error());
			$res12 = mysql_fetch_array($exec12);
			$num12 = mysql_num_rows($exec12);
			$department = $res12['referalname'];
			$stat = $res12['status'];
			$consultant = $res12['consultant'];
			$consultationtime = $res12['consultationtime'];
		
				if($stat == '')
			{
			$status = 'Pending';
			}
			if($stat == 'Inprogress')
			{
			$status = 'Inprogress';
			}
			if($stat == 'completed')
			{
			$status = 'Completed';
			}
			
			
			$waitingtime = (strtotime($timeonly) - strtotime($consultationtime))/60;
			$waitingtime = round($waitingtime);
			
			if($status == 'Pending')
			{
			
			$waitingtime = $waitingtime;
			}
			else
			{
			$waitingtime = '';
			}
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
				  <td class="bodytext31" valign="center"  align="left">
					   <div>
						   <a class="linking" target="_parent" href="consultationform.php?patientcode=<?php echo $patientcode1; ?>&&visitcode=<?php echo $visitcode1; ?>">
						   <strong><?php echo $patientfullname; ?> (<?php echo $patientcode1; ?>,<?php echo $visitcode1; ?>),<?php echo $gender; ?>,<?php echo $age; ?></strong>
						   </a>
					  
					   </div> 	  
				  </td>  
			 
				 	<td class="bodytext31" valign="center"  align="left">
					<div align="left"><?php echo $department; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($consultant); ?></td>
				  <td class="bodytext31" valign="center"  align="left">
					<div align="left"><strong><?php echo $status; ?></strong></div></td>
				   <td class="bodytext31" valign="center"  align="center" <?php if($waitingtime > 15){ ?> bgcolor=" #FF0040" <?php } ?>><strong><?php echo $waitingtime; ?></strong></td>
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
				</tr>
          </tbody>
		  
        </table>
      </td> 
        </tr>
	  
	</table>
    </td>
  </tr>
</table>
</body>
</html>