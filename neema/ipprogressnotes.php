<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$updatetime = date('H:i:s');

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";



if (isset($_REQUEST["locationcode"])) { $locationcode = $_REQUEST["locationcode"]; } else { $locationcode = ""; }	

$query1 = "select * from master_location where locationcode='$locationcode' ";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			while ($res1 = mysql_fetch_array($exec1))
			{
						 $locationname = $res1["locationname"];
					
			}


	
		
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag2 = $_POST['frmflag2'];

if ($frmflag1 == 'frmflag1')
{
       
		$paynowbillprefix7 = 'PN-';
$paynowbillprefix17=strlen($paynowbillprefix7);
$query27 = "select * from ip_progressnotes order by auto_number desc limit 0, 1";
$exec27 = mysql_query($query27) or die ("Error in Query27".mysql_error());
$res27 = mysql_fetch_array($exec27);
$billnumber7 = $res27["docno"];
$billdigit7=strlen($billnumber7);

if ($billnumber7 == '')
{
	$billnumbercode7 =$paynowbillprefix7.'1';
		$openingbalance = '0.00';

}
else
{
	$billnumber7 = $res27["docno"];
	$billnumbercode7 = substr($billnumber7,$paynowbillprefix17, $billdigit7);
	//echo $billnumbercode;
	$billnumbercode7 = intval($billnumbercode7);
	$billnumbercode7 = $billnumbercode7 + 1;

	$maxanum7 = $billnumbercode7;
	
	
	$billnumbercode7 = $paynowbillprefix7 .$maxanum7;
		}
		$patientname = $_REQUEST['patientname'];
		$patientcode = $_REQUEST['patientcode'];
		$visitcode = $_REQUEST['visitcode'];
		$accname = $_REQUEST['accname'];
		$ward1 = $_REQUEST['wardanum'];
		$bed1 = $_REQUEST['bedanum'];
		$notes = $_REQUEST['notes'];
		$locationcode1= $_REQUEST['locationno'];
		$patientlocationcode = $_REQUEST['locationcod'];
		$notes=mysql_real_escape_string($notes);
		$pastmed = $_REQUEST['pastmed'];
		$pastmed=mysql_real_escape_string($pastmed);
		$familyhistory = $_REQUEST['familyhistory'];
		$familyhistory=mysql_real_escape_string($familyhistory);
		$presentmed = $_REQUEST['presentmed'];
		$presentmed=mysql_real_escape_string($presentmed);
		$diagnosis = $_REQUEST['diagnosis'];
		$procedure1 = $_REQUEST['procedure1'];
		$dop = $_REQUEST['dop'];
		$weightofbaby = $_REQUEST['weightofbaby'];
		$notification = $_REQUEST['notification'];
		$condition = $_REQUEST['condition'];

		$frompage = $_REQUEST['frompage'];	
		$query33 = "select * from ip_progressnotes where docno='$billnumbercode7'";
		$exec33 = mysql_query($query33) or die(mysql_error());
		$num33 = mysql_num_rows($exec33);
		if($num33 == 0)
		{
		if($notes != '')
		{$query67 = "insert into ip_progressnotes(docno,patientname,patientcode,visitcode,accountname,ward,bed,recordtime,recorddate,ipaddress,username,notes,pastmed,familyhistory,presentmed,diagnosis,procedure1,dop,weightofbaby,
	notification,condition1,locationcode)values('$billnumbercode7','$patientname','$patientcode','$visitcode','$accname','$ward1','$bed1','$updatetime','$updatedate','$ipaddress','$username','$notes','$pastmed','$familyhistory','$presentmed','$diagnosis','$procedure1','$dop','$weightofbaby','$notification','$condition','$locationcode1')";
		$exec67 = mysql_query($query67) or die(mysql_error());
		}
			}
		if($frompage == 'newborn')
		{
		header("location:newbornactivity.php");
		exit;
		}
		else
		{
		header("location:inpatientactivity.php");
		exit;
		}
		exit;

}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == '1')
{
	$errmsg = "Success. Payment Entry Update Completed.";
}
if ($st == '2')
{
	$errmsg = "Failed. Payment Entry Not Completed.";
}


?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$paynowbillprefix = 'PN-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from ip_progressnotes order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);

if ($billnumber == '')
{
	$billnumbercode =$paynowbillprefix.'1';
		$openingbalance = '0.00';

}
else
{
	$billnumber = $res2["docno"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = $paynowbillprefix .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
?>
<?php

if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if(isset($_REQUEST["frompage"])){$frompage = $_REQUEST["frompage"]; }else{$frompage ='';}

$query21 = "select * from ip_progressnotes where visitcode = '$visitcode' order by auto_number desc limit 0, 1";
$exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
$res21 = mysql_fetch_array($exec21);
$pastmed = $res21['pastmed'];
$familyhistory = $res21['familyhistory'];
$presentmed = $res21['presentmed'];
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

<script>


function validcheck()
{
if(document.getElementById("notes").value == '')
{
alert("Please Enter Notes");
document.getElementById("notes").focus();
return false;
}

}



function funcwardChange1()
{
	/*if(document.getElementById("ward").value == "1")
	{
		alert("You Cannot Add Account For CASH Type");
		document.getElementById("ward").focus();
		return false;
	}*/
	<?php 
	$query12 = "select * from master_ward where recordstatus=''";
	$exec12 = mysql_query($query12) or die ("Error in Query11".mysql_error());
	while ($res12 = mysql_fetch_array($exec12))
	{
	$res12wardanum = $res12["auto_number"];
	$res12ward = $res12["ward"];
	?>
	if(document.getElementById("ward").value=="<?php echo $res12wardanum; ?>")
	{
		document.getElementById("bed").options.length=null; 
		var combo = document.getElementById('bed'); 	
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Sub Type", ""); 
		<?php
		$query10 = "select * from master_bed where ward = '$res12wardanum' and recordstatus = ''";
		$exec10 = mysql_query($query10) or die ("error in query10".mysql_error());
		while ($res10 = mysql_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10bedanum = $res10['auto_number'];
		$res10bed = $res10["bed"];
		
		
		
		?>
			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10bed;?>", "<?php echo $res10bedanum;?>"); 
		<?php 
		
		}
		?>
	}
	<?php
	}
	?>	
}


</script>


<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
.bal
{
border-style:none;
background:none;
text-align:right;
}
.bali
{
text-align:right;
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
</style>
</head>

<script src="js/datetimepicker_css.js"></script>

<body>
<form name="form1" id="form1" method="post" action="ipprogressnotes.php" onSubmit="return validcheck()">	
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="15" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="15" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="15" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="15">&nbsp;</td>
  </tr>
  <tr>
    <td width="0%">&nbsp;</td>
   
    <td colspan="6" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      
	 
	
		<tr>
		<td>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
             <tr>
			  <td width="12%" align="center" valign="center" class="bodytext31"><strong> Doc No</strong></td>
			   <td width="13%" align="center" valign="center" class="bodytext31"><input type="text" name="docno" id="docno" value="<?php echo $billnumbercode; ?>" size="10" readonly></td>
			   <td width="8%"  align="center" valign="center" class="bodytext31"><strong>Date</strong></td>
			   <td width="13%"  align="center" valign="center" class="bodytext31"> 
			   <input type="text" name="date" id="date" value="<?php echo $updatedate; ?>" size="10" readonly>
                    <strong><span class="bodytext312"> <img src="images2/cal.gif" onClick="javascript:NewCssCal('dateofbirth')" style="cursor:pointer"/> </span></strong>               </td>
					  <td width="10%" align="center" valign="center" class="bodytext31"><strong>Time</strong></td>
                      <td colspan="2" align="left" valign="center" class="bodytext31"> <input type="text" name="time" id="time" value="<?php echo $updatetime; ?>" size="10" readonly></td>
            <td width="10%" align="center" valign="center" class="bodytext31"><strong>Location</strong></td>
			<td width="30%" colspan="4" align="left"  valign="center"  ><span class="bodytext31">
               <?php
		  $query131 = "select * from master_location where locationcode = '$locationcode'";
          $exec131 = mysql_query($query131) or die ("Error in Query131".mysql_error());
          $res131 = mysql_fetch_array($exec131);
          $locationname = $res131['locationname'];
	     ?>
                      <?php echo $locationname; ?>   </span></td>
					 <td width="30%" colspan="4" align="left"  valign="center"  ><input type="hidden" name="locationno" id="locationno" value="<?php echo $locationcode; ?>" ></td>
			</tr>
            <tr>
              
				 <td colspan="2"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient Name</strong></div></td>
           
				 <td colspan="2"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Code  </strong></div></td>
				 <td colspan="2"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>IP Visit  </strong></div></td>
				 <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Ward</strong></div></td>
				<td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bed</strong></div></td>
				<td width="21%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Account</strong></div></td>
              </tr>
           <?php
            $colorloopcount ='';
		
		$query1 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode' and paymentstatus =''";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		
		while($res1 = mysql_fetch_array($exec1))
		{
		$patientname=$res1['patientfullname'];
		$patientcode=$res1['patientcode'];
		$accountname = $res1['accountname'];
		$gender = $res1['gender'];
		$age = $res1['age'];
	
		
		$query67 = "select * from master_accountname where auto_number='$accountname'";
		$exec67 = mysql_query($query67); 
		$res67 = mysql_fetch_array($exec67);
		$accname = $res67['accountname'];
		
		
		   $query63 = "select * from ip_bedallocation where patientcode='$patientcode' and visitcode='$visitcode' and recordstatus=''";
		   $exec63 = mysql_query($query63) or die(mysql_error());
		   $res63 = mysql_fetch_array($exec63);
		   $num63 = mysql_num_rows($exec63);
		   if($num63 > 0)
		   {
		   $ward = $res63['ward'];
		   $bed = $res63['bed'];
		   }
		   
		   $query65 = "select * from ip_bedtransfer where patientcode='$patientcode' and visitcode='$visitcode' and recordstatus=''";
		   $exec65 = mysql_query($query65) or die(mysql_error());
		   $res65 = mysql_fetch_array($exec65);
		    $num65 = mysql_num_rows($exec65);
		   if($num65 > 0)
		   {
		   $ward = $res65['ward'];
		   $bed = $res65['bed'];
		   }
		   
		   $query71 = "select * from ip_discharge where patientcode='$patientcode' and visitcode='$visitcode' order by auto_number desc";
		   $exec71 = mysql_query($query71) or die(mysql_error());
		   $res71 = mysql_fetch_array($exec71);
		   $num71 = mysql_num_rows($exec71);
		   if($num71 > 0)
		   {
		    $ward = $res71['ward'];
		    $bed = $res71['bed'];
		   }
		
		$query7811 = "select * from master_ward where auto_number='$ward' and recordstatus=''";
						  $exec7811 = mysql_query($query7811) or die(mysql_error());
						  $res7811 = mysql_fetch_array($exec7811);
						  $wardname1 = $res7811['ward'];
						  
						  $query50 = "select * from master_bed where auto_number='$bed'";
		                  $exec50 = mysql_query($query50) or die(mysql_error());
						  $res50 = mysql_fetch_array($exec50);
						  $bedname = $res50['bed'];
	

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
             
			  <td colspan="2"  align="left" valign="center" class="bodytext31">
			    <div align="center"><?php echo $patientname; ?></div></td>
				<td colspan="2"  align="center" valign="center" class="bodytext31"><?php echo $patientcode; ?></td>
				<td colspan="2"  align="center" valign="center" class="bodytext31"><?php echo $visitcode; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $wardname1; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $bedname; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $accname; ?></td>
				<input type="hidden" name="wardanum" id="wardanum" value="<?php echo $ward; ?>">
				<input type="hidden" name="bedanum" id="bedanum" value="<?php echo $bed; ?>">
				<input type="hidden" name="patientname" id="patientname" value="<?php echo $patientname; ?>">
				 
				<input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>">
				<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>">
				<input name="frompage" id="frompage" value="<?php echo $frompage; ?>" type="hidden">
				<input type="hidden" name="accname" id="accname" value="<?php echo $accname; ?>">
			   </tr>
		   <?php 
		   } 
		  
		   ?>
           
            <tr>
             	<td colspan="7" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#cccccc" class="bodytext311">&nbsp;</td><td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
            
             	<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
             	</tr>
          </tbody>
        </table>		</td>
		<td>&nbsp;</td>
		</tr>
		
		</table>		</td>
	</tr>
	
      <tr>
        <td>&nbsp;</td>
      </tr>
       <tr>
        <td>&nbsp;</td>
		 <td width="1%">&nbsp;</td>
		  <td width="12%" align="left" valign="center" class="bodytext311"><strong>Past Med/Surg/OBS</strong></td>
		<td width="41%" align="left" valign="center" class="bodytext311"><textarea name="pastmed" id="pastmed" rows="5" cols="40"><?php echo $pastmed; ?></textarea></td>
		<td width="12%" align="left" valign="center" class="bodytext311"><strong>Family Social History</strong></td>
		
		<td width="25%" align="left" valign="center" class="bodytext311"><textarea name="familyhistory" id="familyhistory" rows="5" cols="40"><?php echo $familyhistory; ?></textarea></td>
      </tr>
	  <tr>
        <td>&nbsp;</td>
		 <td width="1%">&nbsp;</td>
		  <td width="12%" align="left" valign="center" class="bodytext311"><strong>Present Med/Surg/OBS</strong></td>
		<td width="41%" align="left" valign="center" class="bodytext311"><textarea name="presentmed" id="presentmed" rows="5" cols="40"><?php echo $presentmed; ?></textarea></td>
		<td width="12%" align="left" valign="center" class="bodytext311"><strong>Notes</strong></td>
		
		<td width="25%" align="left" valign="center" class="bodytext311"><textarea name="notes" id="notes" rows="5" cols="40"></textarea></td>
      </tr>
	    <tr>
        <td>&nbsp;</td>
	</tr>
	  <tr>
        <td rowspan="3">&nbsp;</td>
		 <td width="1%" rowspan="3">&nbsp;</td>
		  <td colspan="2" rowspan="3" align="center" valign="center" class="bodytext311"><strong></strong>
		    <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="3" bgcolor="#CCCCCC" class="bodytext3"><strong>Previous Notes</strong></td>
                      </tr>
                      <?php
		
	    $query14 = "select * from ip_progressnotes where patientcode='$patientcode' and visitcode='$visitcode' and recordstatus = '' order by auto_number desc ";
		$exec14 = mysql_query($query14) or die ("Error in Query14".mysql_error());
		while ($res14 = mysql_fetch_array($exec14))
		{
		$date = $res14["recorddate"];
		$previousnotes = $res14["notes"];
		$res14username = $res14["username"];
		$res14recordtime = $res14["recordtime"];
		
		$colorloopcount = $colorloopcount + 1;
		$showcolor = ($colorloopcount & 1); 
		if ($showcolor == 0)
		{
			$colorcode = 'bgcolor="#CBDBFA"';
		}
		else  
		{
			$colorcode = 'bgcolor="#D3EEB7"';
		}
		?>
        <tr <?php echo $colorcode; ?>>
                        <td width="11%" align="left" valign="bottom"  class="bodytext3">
				   <?php echo $date; ?>                        </td>
                        <td width="8%" align="left" valign="bottom"  class="bodytext3"><?php echo $res14recordtime; ?></td>
				        <td align="left" valign="bottom"  class="bodytext3"><?php echo $previousnotes; ?> - <?php echo strtoupper($res14username); ?></td>
                      </tr>
                      <?php
		}
		?>
                      <tr>
                        <td align="middle" colspan="2" >&nbsp;</td>
                      </tr>
                    </tbody>
            </table></td>
		<td align="left" valign="center" class="style1">Diagnosis</td>
        <td align="left" valign="center" class="bodytext311"><span class="bodytext31">
          <input type="text" name="diagnosis" id="diagnosis" value="" size="20" style="text-transform:uppercase">
        </span></td>
	  </tr>
	  <tr>
	    <td align="left" valign="center" class="bodytext311"><strong>Procedure</strong></td>
        <td align="left" valign="center" class="bodytext311"><span class="bodytext31">
          <input type="text" name="procedure1" id="procedure1" value="" size="20" style="text-transform:uppercase">
        </span></td>
    </tr>
	  <tr>
	    <td align="left" valign="center" class="bodytext311"><strong>D.O.P</strong></td>
        <td align="left" valign="center" class="bodytext311"><span class="bodytext31">
          <input type="text" name="dop" id="dop" value="" size="10" readonly>
        <strong><span class="bodytext312"><img src="images2/cal.gif" onClick="javascript:NewCssCal('dop')" style="cursor:pointer"/></span></strong></span></td>
    </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td colspan="2" align="center" valign="center" class="bodytext311">&nbsp;</td>
	    <td align="left" valign="center" class="style1">Weight of Baby </td>
	    <td align="left" valign="center" class="bodytext311"><span class="bodytext31">
	      <input type="text" name="weightofbaby" id="weightofbaby" value="" size="20" >
	    </span></td>
    </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td colspan="2" align="center" valign="center" class="bodytext311">&nbsp;</td>
	    <td align="left" valign="center" class="style1">Notification</td>
	    <td align="left" valign="center" class="bodytext311"><span class="bodytext31">
	      <input type="text" name="notification" id="notification" value="" size="20" >
	    </span></td>
    </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td colspan="2" align="center" valign="center" class="bodytext311">&nbsp;</td>
	    <td align="left" valign="center" class="style1">Condition</td>
	    <td align="left" valign="center" class="bodytext311"><span class="bodytext31">
	      <input type="text" name="condition" id="condition" value="" size="20" style="text-transform:uppercase">
		  <input type="hidden" name="location" id="location"  value="<?php echo $patientlocation; ?>">
		  <input type="hidden" name="locationcod" id="locationcod"  value="<?php echo $patientlocationcode; ?>">
	    </span></td>
    </tr>
	  <tr>
        <td>&nbsp;</td>
		 <td>&nbsp;</td>
		  <td>&nbsp;</td>
		<td>&nbsp;</td>
		<td colspan="2" align="left" valign="center" class="bodytext311">&nbsp;</td>
		<td width="26%" align="center" valign="center" class="bodytext311">         <input type="hidden" name="frmflag1" value="frmflag1" />
        <input type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A"/></td>
      </tr>
  </table>
  </table>
</form>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

