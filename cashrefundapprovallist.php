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

<script type="text/javascript">

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
              <form name="cbform1" method="post" action="cashrefundapprovallist.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
				  <tr>
				  <td align="left" bgcolor="#CCCCCC" class="bodytext3" colspan="2"><strong>Cash Refund Approval</strong></td>
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
	?>
  <tr>   
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="900" 
            align="left" border="0">
          <tbody>
            <tr>
              <td colspan="7" bgcolor="#cccccc" class="bodytext31">
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
                <div align="left"><strong> Approval List</strong><label class="number">&nbsp;</label>
                </div></td>
              </tr>
            <tr>
              <td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>No.</strong></div></td>
              <td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> OP Date</strong></div></td>
              <td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg No </strong></div></td>
              <td width="11%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit No</strong></div></td>
              <td width="27%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient</strong></div></td>				
              <td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Account</strong></td>				
              <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Action</strong></div></td>
              </tr>		
			<?php
			$colorloopcount = '';
			$sno = '';
			$opvisitcode="'".''."'";
			$ipvisitcode="'".''."'";
			$triagedatefrom = date('Y-m-d', strtotime('-2 day'));
			$triagedateto = date('Y-m-d');
		
			$query1 = "select * from consultation_lab where patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and paymentstatus='completed' and billtype='PAY NOW' and (freestatus='' or freestatus='NO') and refundapproval='' and labrefund='refund' and consultationdate between '$fromdate' and '$todate' and patientvisitcode not in($opvisitcode) group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			while ($res1 = mysql_fetch_array($exec1))
			{
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['patientvisitcode'];
			$patientfullname = $res1['patientname'];
			$account = $res1['accountname'];
			$urgentstatus = $res1['urgentstatus'];
			$consultationdate = $res1['consultationdate'];
			$paymentstatus = $res1['paymentstatus'];
			$freestatus = $res1['freestatus'];
			if($opvisitcode=='')
			{
			$opvisitcode = "'".$visitcode."'";
			}
			else
			{
			$opvisitcode = $opvisitcode.",'".$visitcode."'";
			}
			$query111 = "select * from master_visitentry where visitcode='$visitcode'";
			$exec111 = mysql_query($query111) or die(mysql_error());
			$res111 = mysql_fetch_array($exec111);
			$age = $res111['age'];
			$gender = $res111['gender'];
			$department = $res111['departmentname'];
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
			$colorcode = 'bgcolor="#FFFF00"';
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
			   
              <td class="bodytext31" valign="center" align="left">
			    <div align="left"><a href="cashrefundapproval.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>"><strong>Approve</strong></a></div></td>
              </tr>
			<?php
			}    
			?>
		
			<?php
			$query1 = "select * from pharmacysalesreturn_details where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and billstatus='pending' and refundapprove='' and entrydate between '$fromdate' and '$todate' and visitcode not in($opvisitcode) group by visitcode order by entrydate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			while ($res1 = mysql_fetch_array($exec1))
			{
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['visitcode'];
			
			if($opvisitcode=='')
			{
			$opvisitcode = "'".$visitcode."'";
			}
			else
			{
			$opvisitcode = $opvisitcode.",'".$visitcode."'";
			}
		
		 $query23="select * from master_visitentry where patientfullname like '%$searchpatient%' and visitcode='$visitcode'";
		 $exec23=mysql_query($query23) or die(mysql_error());
		 $res23=mysql_fetch_array($exec23);
		 $patientfullname=$res23['patientfullname'];
		 $account=$res23['accountfullname'];
		
			
			$consultationdate = $res1['entrydate'];
			if($patientfullname != '')
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
              <td class="bodytext31" valign="center" align="left">
			    <div align="left"><a href="cashrefundapproval.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>"><strong>Approve</strong></a></div></td>
              </tr>
			<?php
			}
			}    
			?>
		
			<?php
			$query1 = "select * from consultation_radiology where patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and paymentstatus='completed' and billtype='PAY NOW' and radiologyrefund='refund' and refundapprove='' and consultationdate between '$fromdate' and '$todate' and patientvisitcode not in($opvisitcode) group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			while ($res1 = mysql_fetch_array($exec1))
			{
			$res1patientcode = $res1['patientcode'];
			$res1visitcode = $res1['patientvisitcode'];
			$res1patientfullname = $res1['patientname'];
			$res1account = $res1['accountname'];
			$res1consultationdate = $res1['consultationdate'];
			if($opvisitcode=='')
			{
			$opvisitcode = "'".$res1visitcode."'";
			}
			else
			{
			$opvisitcode = $opvisitcode.",'".$res1visitcode."'";
			}
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
              <td class="bodytext31" valign="center"  align="left"><?php echo $res1account; ?></td>
              <td class="bodytext31" valign="center" align="left">
			    <div align="left"><a href="cashrefundapproval.php?patientcode=<?php echo $res1patientcode; ?>&&visitcode=<?php echo $res1visitcode; ?>"><strong>Approve</strong></a></div></td>
              </tr>
			<?php
			}    
			?>
		
	
			<?php
			$query1 = "select * from consultation_services where patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and paymentstatus='completed' and billtype='PAY NOW' and servicerefund='refund' and refundapprove='' and consultationdate between '$fromdate' and '$todate' and patientvisitcode not in($opvisitcode) group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			while ($res1 = mysql_fetch_array($exec1))
			{
			$res1patientcode = $res1['patientcode'];
			$res1visitcode = $res1['patientvisitcode'];
			$res1patientfullname = $res1['patientname'];
			$res1account = $res1['accountname'];
			$res1consultationdate = $res1['consultationdate'];
			if($opvisitcode=='')
			{
			$opvisitcode = "'".$res1visitcode."'";
			}
			else
			{
			$opvisitcode = $opvisitcode.",'".$res1visitcode."'";
			}
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
              <td class="bodytext31" valign="center"  align="left"><?php echo $res1account; ?></td>
              <td class="bodytext31" valign="center" align="left">
			    <div align="left"><a href="cashrefundapproval.php?patientcode=<?php echo $res1patientcode; ?>&&visitcode=<?php echo $res1visitcode; ?>"><strong>Approve</strong></a></div></td>
              </tr>
			<?php
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
              </tr>
          </tbody>
        </table></td>
      </tr>
	  <?php } ?>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

