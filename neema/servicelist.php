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
$consultationdate = '';	
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
//$locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';
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
padding-left:900px;
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

</script>
<script src="js/datetimepicker_css.js"></script>
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
    <td width="99%" valign="top"><table width="105%" border="0" cellspacing="0" cellpadding="0">
	      
		  <tr>
        <td width="860">
              <form name="cbform1" method="post" action="servicelist.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                   <tr>
          <td colspan="3" bgcolor="#cccccc" class="bodytext31"><strong>Service List</strong></td>
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
              <td  bgcolor="#FFFFFF" class="bodytext3"  colspan="3" ><select name="location" id="location" onChange=" ajaxlocationfunction(this.value);" style="border: 1px solid #001E6A;">
                  <?php
						
						$query = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec = mysql_query($query) or die ("Error in Query1".mysql_error());
						while ($res = mysql_fetch_array($exec))
						{
						$reslocation = $res["locationname"];
						$reslocationanum = $res["locationcode"];
						?>
						<option value="<?php echo $reslocationanum; ?>" <?php if($location!='')if($location==$reslocationanum){echo "selected";}?>><?php echo $reslocation; ?></option>
						<?php
						}
						?>
                  </select></td>
                   
                  <input type="hidden" name="locationnamenew" value="<?php echo $locationname; ?>">
                <input type="hidden" name="locationcodenew" value="<?php echo $res1locationanum; ?>">
             
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
  <tr>
   
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
	<?php if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	$searchpatient = $_POST['patient'];
	$searchpatientcode=$_POST['patientcode'];
	$searchvisitcode = $_POST['visitcode'];
	$fromdate=$_POST['ADate1'];
	$todate=$_POST['ADate2'];?>
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1127" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="5%" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
              <td colspan="11" bgcolor="#cccccc" class="bodytext31">
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
                <div align="left"><strong>Process Service</strong>
                <label class="number"> </label>
                </div></td>
              </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>No.</strong></div></td>
              <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> OP Date</strong></div></td>
              <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patientcode </strong></div></td>
              <td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visitcode</strong></div></td>
              <td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient</strong></div></td>
              <td width="7%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Age</strong></td>
              <td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="style1">Gender</td>
              <td width="18%"  align="left" valign="center" 
                bgcolor="#ffffff" class="style1">Department</td>
              <td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Account</strong></td>
              <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Action</strong></div></td>
              </tr>
			<?php
			$colorloopcount = '';
			$sno = '';
			
			$triagedatefrom = date('Y-m-d', strtotime('-2 day'));
			$triagedateto = date('Y-m-d');
			
			//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
			$query1 = "select * from consultation_services where patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and (paymentstatus='completed' OR paymentstatus='paid') and billtype='PAY NOW' and process='pending' and consultationdate between '$fromdate' and '$todate' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			while ($res1 = mysql_fetch_array($exec1))
			{
			$res1patientcode = $res1['patientcode'];
			$res1visitcode = $res1['patientvisitcode'];
			$res1patientfullname = $res1['patientname'];
			$res1account = $res1['accountname'];
			$res1consultationdate = $res1['consultationdate'];
			 $billnumber=$res1['billnumber'];
			
			$query11 = "select * from master_customer where customercode = '$res1patientcode' and status = '' ";
			$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
			$res11 = mysql_fetch_array($exec11);
			$res11age = $res11['age'];
			$res11gender= $res11['gender'];
			
			$query111 = "select * from master_visitentry where patientcode = '$res1patientcode' ";
			$exec111 = mysql_query($query111) or die ("Error in Query111".mysql_error());
			$res111 = mysql_fetch_array($exec111);
			$res111consultingdoctor = $res111['consultingdoctor'];
			$res1111department = $res111['departmentname'];
			//check that patient is a external patient
			if($res1patientcode=='walkin')
			{
			$query11="select * from billing_external where billno='$billnumber'";
			$exec11=mysql_query($query11) or die(mysql_error());
			$res11=mysql_fetch_array($exec11);
			$res11age=$res11['age'];
			$res11gender= $res11['gender'];
			$res1111department = 'External';
			$res1visitcode =$res1['billnumber'];
			//$res1account = 'External';
			}

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
			  <div class="bodytext31"><?php echo $res1consultationdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $res1patientcode;?>			      </div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res1visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res1patientfullname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $res11age; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $res11gender; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $res1111department; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $res1account; ?></td>
              <td class="bodytext31" valign="center" align="left">
			    <div align="left"><?php if($res1patientcode!='walkin'){?><a href="processservice.php?patientcode=<?php echo $res1patientcode; ?>&&visitcode=<?php echo $res1visitcode; ?>"><strong>PROCESS</strong></a><?php }else{?><a href="externalprocessservice.php?billnumber=<?php echo $billnumber; ?>"><strong>PROCESS</strong></a><?php }?></div></td>
              </tr>
			<?php
			}    
			?>
			<?php
			//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
			$query2 = "select * from consultation_services where patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and paymentstatus='completed' and billtype='PAY LATER' and process='pending' and consultationdate between '$fromdate' and '$todate'  group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec2 = mysql_query($query2) or die ("Error in Query1".mysql_error());
			while ($res2 = mysql_fetch_array($exec2))
			{
			$res2patientcode = $res2['patientcode'];
			$res2visitcode = $res2['patientvisitcode'];
			$res2patientfullname = $res2['patientname'];
			$res2account = $res2['accountname'];
			$res2consultationdate = $res2['consultationdate'];
			
			$query12 = "select * from master_customer where customercode = '$res2patientcode' and status = '' ";
			$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
			$res12 = mysql_fetch_array($exec12);
			$res12age = $res12['age'];
			$res12gender= $res12['gender'];
			
			$query112 = "select * from master_visitentry where patientcode = '$res2patientcode' ";
			$exec112 = mysql_query($query112) or die ("Error in Query112".mysql_error());
			$res112 = mysql_fetch_array($exec112);
			$res112consultingdoctor = $res112['consultingdoctor'];
			$res1112department = $res112['departmentname'];
			$res1112plannumber = $res112['planname'];
			$res1112planpercentage = $res112['planpercentage'];

			$querypl = "select forall from master_planname where auto_number = '$res1112plannumber' ";
			$execpl = mysql_query($querypl) or die ("Error in Querypl".mysql_error());
			$respl = mysql_fetch_array($execpl);
			$resplforall = $respl['forall'];
			
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
			if($res1112planpercentage==0.00 ){
			?>
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $res2consultationdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $res2patientcode;?>			      </div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientfullname; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res12age; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $res12gender; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $res1112department; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $res2account; ?></td>
              <td class="bodytext31" valign="center" align="left">
			    <div align="left"><?php if($res2patientcode!='walkin'){?><a href="processservice.php?patientcode=<?php echo $res2patientcode; ?>&&visitcode=<?php echo $res2visitcode; ?>"><strong>PROCESS</strong></a><?php }else{?><a href="externalprocessservice.php?billnumber=<?php echo $billnumber; ?>"><strong>PROCESS</strong></a><?php }?></div></td>
              </tr>
			<?php
			}  }  
			?>
            <?php
			//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
			$query2 = "select * from consultation_services where patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and paymentstatus='pending' and billtype='PAY LATER' and approvalstatus!='0' and process='pending' and consultationdate between '$fromdate' and '$todate'  group by billnumber order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec2 = mysql_query($query2) or die ("Error in Query1".mysql_error());
			while ($res2 = mysql_fetch_array($exec2))
			{
			$res2patientcode = $res2['patientcode'];
			$res2visitcode = $res2['patientvisitcode'];
			 $res2patientfullname = $res2['patientname'];
			$res2account = $res2['accountname'];
			$res2consultationdate = $res2['consultationdate'];
			
			$query12 = "select * from master_customer where customercode = '$res2patientcode' and status = '' ";
			$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
			$res12 = mysql_fetch_array($exec12);
			$res12age = $res12['age'];
			$res12gender= $res12['gender'];
			
			$query112 = "select * from master_visitentry where patientcode = '$res2patientcode' ";
			$exec112 = mysql_query($query112) or die ("Error in Query112".mysql_error());
			$res112 = mysql_fetch_array($exec112);
			$res112consultingdoctor = $res112['consultingdoctor'];
			$res1112department = $res112['departmentname'];
			$planfixedamount = $res112['planfixedamount'];
			
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
			if($planfixedamount==0.00)
			{
			?>
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $res2consultationdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $res2patientcode;?>			      </div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientfullname; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res12age; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $res12gender; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $res1112department; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $res2account; ?></td>
              <td class="bodytext31" valign="center" align="left">
			    <div align="left">Collect Copay</div></td>
              </tr>
			<?php
			}  
			}
			?>
            <?php
			//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
			$query2 = "select * from consultation_services where patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and paymentstatus='completed' and billtype='PAY LATER' and process='pending' and consultationdate between '$fromdate' and '$todate'  group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec2 = mysql_query($query2) or die ("Error in Query1".mysql_error());
			while ($res2 = mysql_fetch_array($exec2))
			{
			$res2patientcode = $res2['patientcode'];
			$res2visitcode = $res2['patientvisitcode'];
			 $res2patientfullname = $res2['patientname'];
			$res2account = $res2['accountname'];
			$res2consultationdate = $res2['consultationdate'];
			
			$query12 = "select * from master_customer where customercode = '$res2patientcode' and status = '' ";
			$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
			$res12 = mysql_fetch_array($exec12);
			$res12age = $res12['age'];
			$res12gender= $res12['gender'];
			
			$query112 = "select * from master_visitentry where patientcode = '$res2patientcode' ";
			$exec112 = mysql_query($query112) or die ("Error in Query112".mysql_error());
			$res112 = mysql_fetch_array($exec112);
			$res112consultingdoctor = $res112['consultingdoctor'];
			$res1112department = $res112['departmentname'];
			$res1112plannumber = $res112['planname'];
			$planfixedamount = $res112['planfixedamount'];

			$querypl = "select forall from master_planname where auto_number = '$res1112plannumber' ";
			$execpl = mysql_query($querypl) or die ("Error in Querypl".mysql_error());
			$respl = mysql_fetch_array($execpl);
			$resplforall = $respl['forall'];
			
			
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
			if($resplforall=='yes' && $planfixedamount==0.00){
			?>
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $res2consultationdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $res2patientcode;?>			      </div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientfullname; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res12age; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $res12gender; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $res1112department; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $res2account; ?></td>
              <td class="bodytext31" valign="center" align="left">
			    <div align="left"><?php if($res2patientcode!='walkin'){?><a href="processservice.php?patientcode=<?php echo $res2patientcode; ?>&&visitcode=<?php echo $res2visitcode; ?>"><strong>PROCESS</strong></a><?php }else{?><a href="externalprocessservice.php?billnumber=<?php echo $billnumber; ?>"><strong>PROCESS</strong></a><?php }?></div></td>
              </tr>
			<?php
			}  }  
			?>
            	<?php
			//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
			$query2 = "select * from consultation_services where patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and paymentstatus='completed' and billtype='PAY LATER' and process='pending' and consultationdate between '$fromdate' and '$todate'  group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec2 = mysql_query($query2) or die ("Error in Query1".mysql_error());
			while ($res2 = mysql_fetch_array($exec2))
			{
			$res2patientcode = $res2['patientcode'];
			$res2visitcode = $res2['patientvisitcode'];
			$res2patientfullname = $res2['patientname'];
			$res2account = $res2['accountname'];
			$res2consultationdate = $res2['consultationdate'];
			
			$query12 = "select * from master_customer where customercode = '$res2patientcode' and status = '' ";
			$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
			$res12 = mysql_fetch_array($exec12);
			$res12age = $res12['age'];
			$res12gender= $res12['gender'];
			
			$query112 = "select * from master_visitentry where patientcode = '$res2patientcode' ";
			$exec112 = mysql_query($query112) or die ("Error in Query112".mysql_error());
			$res112 = mysql_fetch_array($exec112);
			$res112consultingdoctor = $res112['consultingdoctor'];
			$res1112department = $res112['departmentname'];
			$res1112plannumber = $res112['planname'];
			$res1112planpercentage = $res112['planpercentage'];
			$planfixedamount = $res112['planfixedamount'];

			$querypl = "select forall from master_planname where auto_number = '$res1112plannumber' ";
			$execpl = mysql_query($querypl) or die ("Error in Querypl".mysql_error());
			$respl = mysql_fetch_array($execpl);
			$resplforall = $respl['forall'];
			
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
			if($res1112planpercentage!=0.00 && $resplforall=='' && $planfixedamount==0.00){ 
			?>
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31"><?php echo $res2consultationdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left">
			      <?php echo $res2patientcode;?>			      </div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientfullname; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res12age; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $res12gender; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $res1112department; ?></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $res2account; ?></td>
              <td class="bodytext31" valign="center" align="left">
			    <div align="left"><?php if($res2patientcode!='walkin'){?><a href="processservice.php?patientcode=<?php echo $res2patientcode; ?>&&visitcode=<?php echo $res2visitcode; ?>"><strong>PROCESS</strong></a><?php }else{?><a href="externalprocessservice.php?billnumber=<?php echo $billnumber; ?>"><strong>PROCESS</strong></a><?php }?></div></td>
              </tr>
			<?php
			}  }  
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
	  <?php }?>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

