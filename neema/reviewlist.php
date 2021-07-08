<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$timeonly = date('H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');
$department = '';

$location =isset( $_REQUEST['location'])?$_REQUEST['location']:'';
if(isset($_REQUEST['department']))
{
$department = $_REQUEST['department'];
}
if(isset($_POST['patient'])){$searchpatient = $_POST['patient'];}else{$searchpatient="";}
if(isset($_POST['patientcode'])){$searchpatientcode=$_POST['patientcode'];}else{$searchpatientcode="";}
if(isset($_POST['visitcode'])){$searchvisitcode = $_POST['visitcode'];}else{$searchvisitcode="";}
if(isset($_POST['ADate1'])){$fromdate = $_POST['ADate1'];}else{$fromdate=$transactiondatefrom;}
if(isset($_POST['ADate2'])){$todate = $_POST['ADate2'];}else{$todate=$transactiondateto;}

$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysql_query($query) or die ("Error in Query1".mysql_error());
$res = mysql_fetch_array($exec);
	
	 $locationname  = $res["locationname"];
	 $locationcode = $res["locationcode"];
	$res12locationanum = $res["auto_number"];
	
	 $locationcodeget=isset($_REQUEST['location'])?$_REQUEST['location']:$locationcode;
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
.number1
{
text-align:right;
padding-left:700px;
}
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">
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
					
//ajax to get location which is selected ends here

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
<script src="js/datetimepicker_css.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>

<body>
<?php $query12= "select * from master_triage where  triagestatus = 'completed' and overallpayment='' and consultationdate >= NOW() - INTERVAL 10 DAY order by consultationdate DESC";
			$exec12 = mysql_query($query12) or die ("Error in Query1".mysql_error());
			$res12=mysql_num_rows($exec12);
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
    <td width="99%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	    <tr>
	 <td width="860">
              <form name="cbform1" method="post" action="reviewlist.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                  <tr>
                  <td colspan="2" bgcolor="#CCCCCC" class="bodytext3" ><strong> Search Review List </strong>
                   <td colspan="2" align="right" bgcolor="#CCCCCC" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
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
					  <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
						<select name="location" id="location" onChange="ajaxlocationfunction(this.value);" style="border: 1px solid #001E6A;">
                  <?php
						
						$query = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec = mysql_query($query) or die ("Error in Query1".mysql_error());
						while ($res = mysql_fetch_array($exec))
						{
						$locationname = $res["locationname"];
						$locationcode = $res["locationcode"];
						?>
						<option value="<?php echo $locationcode; ?>" <?php if($location!=''){if($location == $locationcode){echo "selected";}}?>><?php echo $locationname; ?></option>
						<?php
						}
						?>
                  </select>
					  </span></td>
					  </tr>
                    <tr>
					  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Name</td>
					  <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
						<input name="patient" type="text" id="patient" value="" size="50" autocomplete="off">
					  </span></td>
					  </tr>
						<tr>
					  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Registration No</td>
					  <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
						<input name="patientcode" type="text" id="patient" value="" size="50" autocomplete="off">
					  </span></td>
					  </tr>
					   <tr>
					  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Visit No </td>
					  <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
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
              </form>		</td>
	 </tr>  
		        
      <tr>
	  <tr>
        <td><table width="100%" height="80" border="0" 
            align="left" cellpadding="2" cellspacing="0" 
            bordercolor="#666666" id="AutoNumber3" style="BORDER-COLLAPSE: collapse" >
          <tbody>
            <tr>
              <td colspan="6" bgcolor="#cccccc" class="bodytext31">
                <div align="left"><strong>Review List </strong></div></td>
				<td colspan="5" bgcolor="#cccccc" class="bodytext31" align="right"><label><strong> <a href="consultationlist1.php">Click to See Consultation List</a></strong></label></td>
			    </tr>
	
            <tr>
              
				 <td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>OP Date  </strong></div></td>
				<td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg.No</strong></div></td>
				<td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit No </strong></div></td>
              <td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> Patient</strong></div></td>
              <td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Gender </strong></div></td>
				  <td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Age </strong></div></td>
             <td width="17%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Dept</strong></div></td>
              <td width="17%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account</strong></div></td>
            <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong> Consultation Date</strong></td>
				<td width="10%"  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong> Consulted By</strong></td>
              <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Action</strong></div></td>
			  </tr>
			<?php
			
			$colorloopcount = '';
			$sno = '';
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
					
			$query1 = "select * from master_consultationlist where (patientfirstname like '%$searchpatient%' or patientmiddlename like '%$searchpatient%' or patientlastname like '%$searchpatient%') and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and date between '$fromdate' and '$todate' group by visitcode order by date DESC";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			while ($res1 = mysql_fetch_array($exec1))
			{
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['visitcode'];
			
			$patientfirstname = $res1['patientfirstname'];
			$patientmiddlename = $res1['patientmiddlename'];
			$patientlastname = $res1['patientlastname'];
			$consultingdoctorname = $res1['consultingdoctor'];
			$consultedby = $res1['username'];
			
			
			
			$query2 = "select * from master_employee where username = '$consultedby'";
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			$res2 = mysql_fetch_array($exec2);
			$consultedby1  = $res2['employeename'];
			
			$consultationdate = $res1['date'];
			
			
			
			$query43 = "select * from master_visitentry where visitcode='$visitcode'";
			$exec43 = mysql_query($query43) or die(mysql_error());
			$res43 = mysql_fetch_array($exec43);
			$age = $res43['age'];
			$gender = $res43['gender'];
			$department = $res43['departmentname'];
			$billtype = $res43['billtype'];
			$accountname= $res43['accountfullname'];

			
			$query21 = "select * from master_consultationlist where visitcode='$visitcode' order by auto_number";
			$exec21 = mysql_query($query21) or die(mysql_error());
			$num21 = mysql_num_rows($exec21);
			
			$res21 = mysql_fetch_array($exec21);
			$consultationdatetime = $res21['consultationdate'];
			$consultationdatetime2 = strtotime($consultationdatetime);
		    $consultationdatetime1 = strtotime($consultationdatetime . ' + 2 day');  
			$updatedatetime1 = strtotime($updatedatetime);  
			
			$consultationdate1 = date('Y-m-d', $consultationdatetime2);
			
			if($billtype == 'PAY LATER')
			{
			$query45 = "select * from master_visitentry where visitcode='$visitcode' and overallpayment=''"; 
			$exec45 = mysql_query($query45) or die(mysql_error());
			$num45 = mysql_fetch_array($exec45);
			}
			else
			{
			$num45 = '1';
			}
			
			if($consultationdatetime1 >= $updatedatetime1)
			{
			if($num45 > 0)
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
			    <div align="left"><?php echo substr($consultationdate, 0, 10); ?></div></td>
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
			    <div align="left">
			      <?php echo $department;?>			      </div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $accountname; ?></div></td>
              
			   <td class="bodytext31" valign="center"  align="center"><?php echo $consultationdate1; ?></td>
			   <td class="bodytext31" valign="center"  align="center"><?php echo $consultedby1; ?></td>
                          
			  <td class="bodytext31" valign="center"  align="right">
				  <?php if(strcmp(trim($department),"MCH  CONSULTATION")==0)
			       {
				   ?>								  
					  <div>
						  <a href="mchconsultationform.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">
						  <strong>Consult</strong>						                          </a>					  
					  </div>
			          <?php } else  if(strcmp(trim($department),"TB")==0){ ?>
					   
						   <a href="tbconsultationform.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">
						   <strong>Consult</strong>
						   </a>
					   <?php } else { ?>
					   <div>
						   <a href="consultationformreview.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">
						   <strong>Consult</strong>
						   </a>
					   <?php }?>
					   </div> 	  
				  </td>  
			  </tr>
			<?php
			}
			} 
			//echo $patientfirstname; 
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
		  
        </table>
      </td> 
	  <td width="98"><!--<iframe marginwidth="19" src="labtestscrolling.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcodenum; ?>&&date=<?php echo $consultationdate; ?>" frameborder="0" scrolling="no"></iframe>--></td>   
      </tr>
	  <tr>
	  <td>
	   <td width="98"><!--<iframe marginwidth="19" src="radiologytestscrolling.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcodenum; ?>&&date=<?php echo $consultationdate; ?>" frameborder="0" scrolling="no"></iframe>--></td>   
	   </tr>
	</table>
	  <div align="right"></div>
	
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

