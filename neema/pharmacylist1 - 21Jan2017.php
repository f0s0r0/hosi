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
if(isset($_POST['ADate1'])){$fromdate = $_POST['ADate1'];}else{$fromdate=$transactiondatefrom;}
if(isset($_POST['ADate2'])){$todate = $_POST['ADate2'];}else{$todate=$transactiondateto;}

$docno = $_SESSION['docno'];
 //get location for sort by location purpose
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
	if($location!='')
	{
		  $locationcode=$location;
		}
		//location get end here
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
<script>
function funcPopupOnLoad1()
{
<?php 
if (isset($_REQUEST["patientcode"])) { $savedpatientcode = $_REQUEST["patientcode"]; } else { $savedpatientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $savedvisitcode = $_REQUEST["visitcode"]; } else { $savedvisitcode = ""; }
if (isset($_REQUEST["billnumber"])) { $savedbillnumber = $_REQUEST["billnumber"]; } else { $savedbillnumber = ""; }
?>
var patientcodes;
var patientcodes = "<?php echo $savedpatientcode; ?>";
var visitcodes;
var visitcodes = "<?php echo $savedvisitcode; ?>";
var billnumbers;
var billnumbers = "<?php echo $savedbillnumber; ?>";
//alert(patientcodes);
if(patientcodes != "") 
{
	window.open("print_medicine_label.php?patientcode="+patientcodes+"&&visitcode="+visitcodes+"&&billnumber="+billnumbers+"","OriginalWindowA4",'width=450,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
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
<body onLoad="funcPopupOnLoad1()">
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
        <td width="860">
              <form name="cbform1" method="post" action="pharmacylist1.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                  <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong> Medicine Issue </strong></td>
              <td colspan="3" align="right" bgcolor="#CCCCCC" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
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
               <select name="location" id="location" onChange="ajaxlocationfunction(this.value);"  style="border: 1px solid #001E6A;">
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
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Visitcode</td>
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
              </form>		</td>
      </tr>
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  <?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	$searchpatient = $_POST['patient'];
	$searchpatientcode=$_POST['patientcode'];
	$searchvisitcode = $_POST['visitcode'];
	$fromdate=$_POST['ADate1'];
	$todate=$_POST['ADate2'];



	//echo $searchpatient;
		//$transactiondatefrom = $_REQUEST['ADate1'];
	//$transactiondateto = $_REQUEST['ADate2'];


	
?>
  <tr>
    
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="900" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="5%" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
              <td colspan="8" bgcolor="#cccccc" class="bodytext31">
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
                <div align="left"><strong>Pharmacy </strong></div></td>
              </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>No.</strong></div></td>
              <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> OP Date</strong></div></td>
              <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patientcode </strong></div></td>
              <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visitcode</strong></div></td>
              <td width="21%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient</strong></div></td>
              <td width="21%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Account</strong></td>
				 <td width="19%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Subtype</strong></td>
              <td width="8%"  align="left" valign="center" 
              bgcolor="#ffffff" class="bodytext31"><strong>Doctor</strong></td>
              <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Action</strong></div></td>
              </tr>
			<?php
			$colorloopcount = '';
			$sno = '';
			
			$triagedatefrom = date('Y-m-d', strtotime('-2 day'));
			$triagedateto = date('Y-m-d');
			
			//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
			 $query1 = "select * from master_consultationpharm where  locationcode='".$locationcode."' AND patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and pharmacybill='completed' and medicineissue='pending' and billtype='PAY NOW' and recorddate between '$fromdate' and '$todate' group by patientvisitcode order by recorddate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			while ($res1 = mysql_fetch_array($exec1))
			{ 
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['patientvisitcode'];
			$patientfullname = $res1['patientname'];
			$account = $res1['accountname'];
			$billnumber = $res1['billnumber'];
			$username1 = $res1['username'];
			$medcode = $res1['medicinecode'];
		    // 	$employeename = $res1['employeename'];
			
			$query238="select sum(quantity) as quantity from master_consultationpharmissue where patientcode = '$patientcode' and patientvisitcode='$visitcode'";
		 	$exec238=mysql_query($query238) or die(mysql_error());
		 	$res238=mysql_fetch_array($exec238);
			$medquantity=$res238['quantity'];
			if($medquantity > 0)
			{	
		 
		 	$query23="select * from master_visitentry where patientcode = '$patientcode' and visitcode='$visitcode'";
		 	$exec23=mysql_query($query23) or die(mysql_error());
		 	$res23=mysql_fetch_array($exec23);
			$subtype=$res23['subtype'];
			 
		 if($patientcode=='walkin')
			{
			$query11="select * from billing_external where billno='$billnumber'";
			$exec11=mysql_query($query11) or die(mysql_error());
			$res11=mysql_fetch_array($exec11);
			$res11age=$res11['age'];
			$res11gender= $res11['gender'];
			$res1111department = 'External';
			$visitcode =$res1['billnumber'];
			//$res1account = 'External';
			}
			
		 $query24 = "select * from master_subtype where auto_number='$subtype'";
		 $exec24 = mysql_query($query24) or die(mysql_error());
		 $res24 = mysql_fetch_array($exec24);
		 $subtypename = $res24['subtype'];
		
		if($patientfullname == '')
		{
		 $query23="select * from master_visitentry where patientcode = '$patientcode' and visitcode='$visitcode'";
		 $exec23=mysql_query($query23) or die(mysql_error());
		 $res23=mysql_fetch_array($exec23);
		 $patientfullname=$res23['patientfullname'];
		 $account=$res23['accountfullname'];
		 $subtype=$res23['subtype'];
		 
		 $query24 = "select * from master_subtype where auto_number='$subtype'";
		 $exec24 = mysql_query($query24) or die(mysql_error());
		 $res24 = mysql_fetch_array($exec24);
		 $subtypename = $res24['subtype'];
		 
		}
		  
			
			$query25 = "select * from master_employee where username='$username1'";
		 	$exec25 = mysql_query($query25) or die(mysql_error());
		 	$res25 = mysql_fetch_array($exec25);
		 	//$subtypename = $res24['subtype'];
		    $employeename = $res25['employeename'];

		
		
		 
			//$query2 = "select * from master_doctor where auto_number = '$consultingdoctoranum'";
			//$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			//$res2 = mysql_fetch_array($exec2);
			//$consultingdoctorname  = $res2['doctorname'];
			
			$consultationdate = $res1['recorddate'];
			
			
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
			  <div class="bodytext31"><?php echo $consultationdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $patientcode;?>			      </div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientfullname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $account; ?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $subtypename; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $employeename; ?></td>
              <td class="bodytext31" valign="center" align="left">
			    <div align="left"><?php if($patientcode!='walkin'){?><a href="pharmacy1.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&loccode=<?php echo $locationcode;?>"><strong>Issue</strong></a><?php }else{?><a href="externalpharmacy1.php?billnumber=<?php echo $billnumber; ?>&loccode=<?php echo $locationcode;?>"><strong>Issue</strong></a>
				<?php }?></div></td>
              </tr>
			<?php
			} 
			}   
			?>
            
           	<?php
			$colorloopcount = '';
			$sno = '';
			
			$triagedatefrom = date('Y-m-d', strtotime('-2 day'));
			$triagedateto = date('Y-m-d');
			
			//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
			 $query1 = "select * from master_consultationpharm where  locationcode='".$locationcode."' AND patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and pharmacybill='completed' and medicineissue='pending' and billtype='' and recorddate between '$fromdate' and '$todate' group by billnumber order by recorddate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			while ($res1 = mysql_fetch_array($exec1))
			{
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['patientvisitcode'];
			$patientfullname = $res1['patientname'];
			$account = $res1['accountname'];
			$billnumber = $res1['billnumber'];
			$username1 = $res1['username'];
			$medcode = $res1['medicinecode'];
			
			$query238="select sum(quantity) as quantity from master_consultationpharmissue where patientcode = '$patientcode' and patientvisitcode='$visitcode'";
		 	$exec238=mysql_query($query238) or die(mysql_error());
		 	$res238=mysql_fetch_array($exec238);
			$medquantity=$res238['quantity'];
			if($medquantity > 0)
			{	
			
		 $query23="select * from master_visitentry where patientcode = '$patientcode' and visitcode='$visitcode'";
		 $exec23=mysql_query($query23) or die(mysql_error());
		 $res23=mysql_fetch_array($exec23);
			$subtype=$res23['subtype'];
			
			$query25 = "select * from master_employee where username='$username1'";
		 	$exec25 = mysql_query($query25) or die(mysql_error());
		 	$res25 = mysql_fetch_array($exec25);
		 	//$subtypename = $res24['subtype'];
			$employeename = $res25['employeename'];


			 
		 if($patientcode=='walkin')
			{
			$query11="select * from billing_external where billno='$billnumber'";
			$exec11=mysql_query($query11) or die(mysql_error());
			$res11=mysql_fetch_array($exec11);
			$res11age=$res11['age'];
			$res11gender= $res11['gender'];
			$res1111department = 'External';
			$visitcode =$res1['billnumber'];
			//$res1account = 'External';
			}
			
		 $query24 = "select * from master_subtype where auto_number='$subtype'";
		 $exec24 = mysql_query($query24) or die(mysql_error());
		 $res24 = mysql_fetch_array($exec24);
		 $subtypename = $res24['subtype'];
		
		if($patientfullname == '')
		{
		 $query23="select * from master_visitentry where patientcode = '$patientcode' and visitcode='$visitcode'";
		 $exec23=mysql_query($query23) or die(mysql_error());
		 $res23=mysql_fetch_array($exec23);
		 $patientfullname=$res23['patientfullname'];
		 $account=$res23['accountfullname'];
		 $subtype=$res23['subtype'];
		 
		 $query24 = "select * from master_subtype where auto_number='$subtype'";
		 $exec24 = mysql_query($query24) or die(mysql_error());
		 $res24 = mysql_fetch_array($exec24);
		 $subtypename = $res24['subtype'];
		 
		 $query25 = "select * from master_employee where username='$username1'";
		 	$exec25 = mysql_query($query25) or die(mysql_error());
		 	$res25 = mysql_fetch_array($exec25);
		 	//$subtypename = $res24['subtype'];
			$employeename = $res25['employeename'];


		 
		 
		}
			//$query2 = "select * from master_doctor where auto_number = '$consultingdoctoranum'";
			//$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			//$res2 = mysql_fetch_array($exec2);
			//$consultingdoctorname  = $res2['doctorname'];
			
			$consultationdate = $res1['recorddate'];
			
			
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
			  <div class="bodytext31"><?php echo $consultationdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $patientcode;?>			      </div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientfullname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $account; ?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $subtypename; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $employeename; ?></td>
              <td class="bodytext31" valign="center" align="left">
			    <div align="left"><?php if($patientcode!='walkin'){?><a href="pharmacy1.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&loccode=<?php echo $locationcode;?>"><strong>Issue</strong></a><?php }else{?><a href="externalpharmacy1.php?billnumber=<?php echo $billnumber; ?>&loccode=<?php echo $locationcode;?>"><strong>Issue</strong></a>
				<?php }?></div></td>
              </tr>
			<?php
			} 
			}   
			?> 
            
			<?php
			$vis = '675';
			//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
			$query1 = "select * from master_consultationpharm where locationcode='".$locationcode."' AND patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and medicineissue='pending' and billtype='PAY LATER' and pharmacybill='completed'  and recorddate between '$fromdate' and '$todate' group by patientvisitcode  order by recorddate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			while ($res1 = mysql_fetch_array($exec1))
			{
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['patientvisitcode'];
			$patientfullname = $res1['patientname'];
			$account = $res1['accountname'];
			$excludestatus=$res1['excludestatus'];
			$excludebill = $res1['excludebill'];
			$consultationdate = $res1['recorddate'];	
			$billnumber = $res1['billnumber'];
			$username1 = $res1['username'];
			$medcode = $res1['medicinecode'];
			
			$query238="select sum(quantity) as quantity from master_consultationpharmissue where patientcode = '$patientcode' and patientvisitcode='$visitcode'";
		 	$exec238=mysql_query($query238) or die(mysql_error());
		 	$res238=mysql_fetch_array($exec238);
			$medquantity=$res238['quantity'];
			if($medquantity > 0)
			{	

			$query25 = "select * from master_employee where username='$username1'";
		 	$exec25 = mysql_query($query25) or die(mysql_error());
		 	$res25 = mysql_fetch_array($exec25);
		 	//$subtypename = $res24['subtype'];
			$employeename = $res25['employeename'];
			
		 	$query23="select * from master_visitentry where patientcode = '$patientcode' and visitcode='$visitcode'";
		 	$exec23=mysql_query($query23) or die(mysql_error());
		 	$res23=mysql_fetch_array($exec23);
			
			$subtype=$res23['subtype'];
			
		 $query24 = "select * from master_subtype where auto_number='$subtype'";
		 $exec24 = mysql_query($query24) or die(mysql_error());
		 $res24 = mysql_fetch_array($exec24);
		 $subtypename = $res24['subtype'];
		 
		 
		 if($patientcode=='walkin')
			{
			$query11="select * from billing_external where billno='$billnumber'";
			$exec11=mysql_query($query11) or die(mysql_error());
			$res11=mysql_fetch_array($exec11);
			$res11age=$res11['age'];
			$res11gender= $res11['gender'];
			$res1111department = 'External';
			$visitcode =$res1['billnumber'];
			//$res1account = 'External';
			}
			
			if((($excludestatus == '')&&($excludebill == ''))||(($excludestatus == 'excluded')&&($excludebill == 'completed')))
			{
			
			
			if($vis != $visitcode)
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
			  <div class="bodytext31"><?php echo $consultationdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $patientcode;?>			      </div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $patientfullname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $account; ?></td>
			  <td class="bodytext31" valign="center"  align="left"><?php echo $subtypename; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $employeename; ?></td>
              <td class="bodytext31" valign="center" align="left">
			    <div align="left"><?php if($patientcode!='walkin'){?><a href="pharmacy1.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&loccode=<?php echo $locationcode;?>"><strong>Issue</strong></a><?php }else{?><a href="externalpharmacy1.php?billnumber=<?php echo $billnumber; ?>&loccode=<?php echo $locationcode;?>"><strong>Issue</strong></a>
				<?php }?></div></td>
              </tr>
			<?php
			}
			}
			$vis = $visitcode;
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
              </tr>
          </tbody>
        </table></td>
      </tr>
    </table>
	</td>
	</tr>
	<?php
	}
	?>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

