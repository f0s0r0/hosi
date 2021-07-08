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
$docno = $_SESSION['docno'];
?>
<?php
//get location for sort by location purpose
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
	if($location!='')
	{
		 $locationcode=$location;
		}
		//location get end here
		
$query1 = "select locationcode,locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
$res1 = mysql_fetch_array($exec1);
$locationcode = $res1["locationcode"];
$locationname = $res1["locationname"];

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
<script src="js/datetimepicker_css.js"></script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
<script language="javascript">
function funcOnLoadBodyFunctionCall()
{
	process1();
}
	</script>
	<script type="text/javascript">
			 function process1()
			{
			var patientcode = '<?php echo $_REQUEST['docnumber']; ?>';
			
		var popWin; 
		popWin = window.open("print_labsample_label.php?docnumber="+patientcode,"OriginalWindowA4",'width=800,height=800,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
			
			}
           </script>
</head>
<body onLoad="return funcOnLoadBodyFunctionCall();">

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
        <td width="860">
              <form name="cbform1" method="post" action="iplabsamplecollectionlist.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
				   <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
               <select name="location" id="location" onChange=" ajaxlocationfunction(this.value);" style="border: 1px solid #001E6A;">
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
					<tr>
					<td colspan="4">&nbsp;</td>
					</tr>
                  </tbody>
                </table>
              </form>		</td>
      </tr>
	  <?php  if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
		//$cbfrmflag1 = $_POST['cbfrmflag1'];
		if ($cbfrmflag1 == 'cbfrmflag1')
		{
		
			$searchpatient = $_POST['patient'];
			$searchpatientcode=$_POST['patientcode'];
			$searchvisitcode = $_POST['visitcode'];
			$fromdate=$_POST['ADate1'];
			$todate=$_POST['ADate2'];
?>
<?php $querynw1 = "select * from ipconsultation_lab where patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and labsamplecoll='pending' and billtype='PAY NOW' and consultationdate between '$fromdate' and '$todate' and locationcode = '$locationcode' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execnw1 = mysql_query($querynw1) or die ("Error in Query1".mysql_error());
			$resnw1=mysql_num_rows($execnw1);
			$query1 = "select * from ipconsultation_lab where patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and labsamplecoll='pending' and billtype='PAY LATER' and consultationdate between '$fromdate' and '$todate' and locationcode = '$locationcode' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$resnw2=mysql_num_rows($exec1);
		$resnw3=$resnw1+$resnw2;
			?>
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="900" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="5%" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
              <td colspan="9" bgcolor="#cccccc" class="bodytext31">
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
                <div align="left"><strong>IP Lab Sample Collection</strong><label class="number"><<<?php echo $resnw3;?>>></label></div></td>
              </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="left"><strong>No.</strong></div></td>
              <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong> OP Date</strong></div></td>
              <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patientcode </strong></div></td>
              <td width="11%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visitcode</strong></div></td>
              <td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient</strong></div></td>
              <td width="8%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Ward</strong></div></td>
			 <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bed No </strong></div></td>
              <td width="11%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Account</strong></td>
				<td width="11%"  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Time</strong></td>
              <td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Action</strong></div></td>
              </tr>
		
			<?php
			$colorloopcount = '';
			$sno = '';
			$timeonly = date('H:i:s');
			
			$triagedatefrom = date('Y-m-d', strtotime('-2 day'));
			$triagedateto = date('Y-m-d');
		
				//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
			$query1 = "select * from ipconsultation_lab where patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and labsamplecoll='pending' and billtype='PAY NOW' and locationcode = '$locationcode' and consultationdate between '$fromdate' and '$todate' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			while ($res1 = mysql_fetch_array($exec1))
			{
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['patientvisitcode'];
			$patientfullname = $res1['patientname'];
			$account = $res1['accountname'];
				$urgentstatus = $res1['urgentstatus'];
			$consultationdate = $res1['consultationdate'];
			
			
			$waitingtime='';
			$recordtime = $res1['consultationtime'];
			
			$waitingtime = (strtotime($timeonly) - strtotime($recordtime))/60;
			$waitingtime = round($waitingtime);
			
			$waitingtime1 = $waitingtime;
			
			$query2 = "select ward,bed,recordstatus from ip_bedallocation where visitcode = '$visitcode'";
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			$res2 = mysql_fetch_array($exec2);
			$recordstatus = $res2['recordstatus'];
			if($recordstatus == 'transfered')
			{
				$query21 = "select ward,bed from ip_bedtransfer where visitcode = '$visitcode'";
			 	$exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
				$res21 = mysql_fetch_array($exec21);
				$bed = $res21['bed'];
				$ward = $res21['ward'];
				
			}
			else
			{
				$bed = $res2['bed'];
				$ward = $res2['ward'];
			}
			$query3 = "select bed from master_bed where auto_number = '$bed'" ;
			$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
			$res3 = mysql_fetch_array($exec3);
			$bed1 = $res3['bed'];
			$query4 = "select ward from master_ward where auto_number = '$ward'";
			$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
			$res4 = mysql_fetch_array($exec4);
			$ward1 = $res4['ward'];
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
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $ward1; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo  $bed1; ?></div></td>                
              <td class="bodytext31" valign="center"  align="left"><?php echo $account; ?></td>
			<td align="left" valign="center" class="bodytext31" <?php if($waitingtime1 > 15){ ?> bgcolor=" #FF0040" <?php } ?>><div align="center"><strong><?php echo $waitingtime1; ?></strong></div></td> 
              <td class="bodytext31" valign="center" align="left">
              
			    <div align="left"><a href="iplabsamplecollection.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>"><strong>Collect</strong></a></div></td>
              </tr>
			<?php
			}    
			?>
			<?php
			//$query1 = "select * from master_billing where paymentstatus = 'completed' and consultationdate >= NOW() - INTERVAL 6 DAY order by consultationdate";
			$query1 = "select * from ipconsultation_lab where patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and labsamplecoll='pending' and billtype='PAY LATER' and locationcode = '$locationcode' and consultationdate between '$fromdate' and '$todate' group by patientvisitcode order by consultationdate desc";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			while ($res1 = mysql_fetch_array($exec1))
			{
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['patientvisitcode'];
			$patientfullname = $res1['patientname'];
			$account = $res1['accountname'];
			
			$consultationdate = $res1['consultationdate'];
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
				$urgentstatus = $res1['urgentstatus'];
				
				$waitingtime='';
			$recordtime = $res1['consultationtime'];
			
			$waitingtime = (strtotime($timeonly) - strtotime($recordtime))/60;
			$waitingtime = round($waitingtime);
			
			$waitingtime1 = $waitingtime;
			
				$query2 = "select ward,bed,recordstatus from ip_bedallocation where visitcode = '$visitcode'";
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			$res2 = mysql_fetch_array($exec2);
			$recordstatus = $res2['recordstatus'];
			if($recordstatus == 'transfered')
			{
				$query21 = "select ward,bed from ip_bedtransfer where visitcode = '$visitcode'";
			 	$exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
				$res21 = mysql_fetch_array($exec21);
				$bed = $res21['bed'];
				$ward = $res21['ward'];
				
			}
			else
			{
				$bed = $res2['bed'];
				$ward = $res2['ward'];
			}
			$query3 = "select bed from master_bed where auto_number = '$bed'" ;
			$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
			$res3 = mysql_fetch_array($exec3);
			$bed1 = $res3['bed'];
			$query4 = "select ward from master_ward where auto_number = '$ward'";
			$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
			$res4 = mysql_fetch_array($exec4);
			$ward1 = $res4['ward'];
			
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
                 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $ward1; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo  $bed1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo $account; ?></td>
			  <td align="left" valign="center" class="bodytext31" <?php if($waitingtime1 > 15){ ?> bgcolor=" #FF0040" <?php } ?>><div align="center"><strong><?php echo $waitingtime1; ?></strong></div></td> 
              <td class="bodytext31" valign="center" align="left">
			    <div align="left"><a href="iplabsamplecollection.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>"><strong>Collect</strong></a></div></td>
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

