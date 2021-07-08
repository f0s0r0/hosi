<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');

$searchsuppliername = "";
$res1username = '';
$res2username = '';
$res3username = '';
$res4username = '';
$res5username = '';
$res6username = '';
$res7username = '';
ini_set('max_execution_time', 300);
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
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
</style>

<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
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

function process1backkeypress1()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
}

function disableEnterKey()
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
		return false;
	}
	else
	{
		return true;
	}

}
</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<script src="js/datetimepicker_css.js"></script>
</head>
<body>
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><form name="cbform1" method="post" action="patienthandledby.php">
          <table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#CCCCCC" class="bodytext3"><strong>Patient Handled By</strong></td>
              </tr>
          
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Patient</td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="patient" type="text" id="patient" value="" size="50" autocomplete="off">              </td>
              </tr>
			    <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Registration No</td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="patientcode" type="text" id="patient" value="" size="50" autocomplete="off">              </td>
              </tr>
			   <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Visitcode</td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="visitcode" type="text" id="visitcode" value="" size="50" autocomplete="off">              </td>
              </tr>
			  <tr>
          <td width="136" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="131" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="76" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></td>
          <td width="425" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
            <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>		  </td>
          </tr>
			   <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
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
        <td>&nbsp;</td>
      </tr>
	  <tr>
        <td>
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
<form name="form1" id="form1" method="post" action="patienthandledby.php">	
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1226" 
            align="left" border="0">
          <tbody>
		   <tr>
              <td width="2%" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
              <td colspan="15" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>  
            </tr>
           <tr>
                <td width="20"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
                               <td width="173"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Patient Name </strong></td>
                               <td width="62" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Reg Code</strong></td>
				  <td width="66" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Visit Code</strong></td>
					  <td width="73" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Visit  Date</strong></td>
			          <td width="94" align="left" valign="center"  
                bgcolor="#ffffff" class="style1">Visit By </td>
		              <td width="105" align="left" valign="center"  
                bgcolor="#ffffff" class="style1">Triaged By </td>
	                <td width="99" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Consulted By </strong></td>
                           <td width="97"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Pharmacy By </strong></td>
                           <td width="104"  align="left" valign="center" 
                bgcolor="#ffffff" class="style1">Sampled By </td>
                           <td width="101"  align="left" valign="center" 
                bgcolor="#ffffff" class="style1">Service By </td>
                           <td width="110"  align="left" valign="center" 
                bgcolor="#ffffff" class="style1">Radiology By </td>
           </tr>
			  <?php 
           $query1 = "select * from master_visitentry where patientfullname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and consultationdate between '$fromdate' and '$todate' order by auto_number desc";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			$num1 = mysql_num_rows($exec1);
			while ($res1 = mysql_fetch_array($exec1))
			{
			$res1patientcode = $res1['patientcode'];
			$res1visitcode = $res1['visitcode'];
			$res1patientfullname = $res1['patientfullname'];
			$res1consultationdate = $res1['consultationdate'];
			$res1username = $res1['username'];
			
			$query2 = "select * from master_triage where patientcode = '$res1patientcode' and visitcode='$res1visitcode' and registrationdate between '$fromdate' and '$todate' group by visitcode order by auto_number desc";
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			$num2 = mysql_num_rows($exec2);
			while ($res2 = mysql_fetch_array($exec2))
			{
			$res2username = $res2['user'];
			}
			$query3 = "select * from master_consultationlist where patientcode = '$res1patientcode' and visitcode='$res1visitcode' and DATE(consultationdate) between '$fromdate' and '$todate' group by visitcode  order by auto_number desc";
			$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
			while ($res3 = mysql_fetch_array($exec3))
			{
			 $res3username  = $res3['username'];
			}
		    $query4 = "select * from pharmacysales_details where patientcode = '$res1patientcode' and visitcode='$res1visitcode' and entrydate between '$fromdate' and '$todate' group by visitcode  order by auto_number desc";
			$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
			while ($res4 = mysql_fetch_array($exec4))
			{
			$res4username  = $res4['username'];
			}
		   $query5 = "select * from resultentry_lab where patientcode = '$res1patientcode' and patientvisitcode='$res1visitcode' and recorddate between '$fromdate' and '$todate' group by patientvisitcode  order by auto_number desc";
			$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
			while ($res5 = mysql_fetch_array($exec5))
			{
			$res5username  = $res5['username'];
			}
			$query6 = "select * from process_service where patientcode = '$res1patientcode' and patientvisitcode='$res1visitcode' and recorddate between '$fromdate' and '$todate' group by patientvisitcode  order by auto_number desc";
			$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
			while ($res6 = mysql_fetch_array($exec6))
			{
			$res6username  = $res6['username'];
			}
			
		    $query7 = "select * from resultentry_radiology where patientcode = '$res1patientcode' and patientvisitcode='$res1visitcode' and recorddate between '$fromdate' and '$todate' group by patientvisitcode  order by auto_number desc";
			$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
			while ($res7 = mysql_fetch_array($exec7))
			{
			$res7username= $res7['username'];
			}
			
						  
			  $colorloopcount = $colorloopcount + 1;
			  $showcolor = ($colorloopcount & 1); 
			  $colorcode = '';
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
					<td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
					<td  align="left" valign="center" class="bodytext31"><?php echo $res1patientfullname; ?></td>
					<td  align="left" valign="center" class="bodytext31"><?php echo $res1patientcode; ?></td>
					<td  align="left" valign="center" class="bodytext31"><?php echo $res1visitcode; ?></td>
					<td  align="left" valign="center" class="bodytext31"><?php echo $res1consultationdate; ?></td>
					<td  align="left" valign="center" class="bodytext31"><?php echo strtoupper($res1username); ?></td>
					<td  align="left" valign="center" class="bodytext31"><?php echo strtoupper($res2username); ?></td>
					<td  align="left" valign="center" class="bodytext31"><?php echo strtoupper($res3username); ?></td>
					<td  align="left" valign="center" class="bodytext31"> <?php echo strtoupper($res4username); ?></td>
					<td  align="left" valign="center" class="bodytext31"><?php echo strtoupper($res5username); ?></td>
					<td  align="left" valign="center" class="bodytext31"><?php echo strtoupper($res6username); ?></td>
					<td  align="left" valign="center" class="bodytext31"><?php echo strtoupper($res7username); ?></td>
				</tr>
			  <?php  
			    
				$res1username = '';
				$res2username = '';
				$res3username = '';
				$res4username = '';
				$res5username = '';
				$res6username = '';
				$res7username = '';
				}	
				
				
			  

			  ?>
			 
			<tr>
				<td class="bodytext31" valign="center"  align="left" 
				bgcolor="#cccccc">&nbsp;</td>
				<td  align="left" valign="center" 
				bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
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
		 </form>
		 
		 <?php
		 }
		 ?></td>
      </tr>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

