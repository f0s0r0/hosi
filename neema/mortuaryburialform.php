<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
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



if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag2 = $_POST['frmflag2'];
if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if(isset($_REQUEST['docno'])) { $docno = $_REQUEST["docno"]; } else { $docno = ""; }
if(isset($_REQUEST['update'])) { echo $update = $_REQUEST["update"]; } else { $update = ""; }

if ($frmflag1 == 'frmflag1')
{

      $disease='hai';
	  
      $date=$_REQUEST['date'];
	  $docno=$_REQUEST['docno']; 
	  $bodyrelaseto= mysql_real_escape_string($_REQUEST['bodyrelaseto']);
	  $relationship= mysql_real_escape_string($_REQUEST['relationship']);
	  $placeofdeath= mysql_real_escape_string($_REQUEST['placeofdeath']);
	  $country1= mysql_real_escape_string($_REQUEST['country1']);
	  $country2= mysql_real_escape_string($_REQUEST['country2']);
	  $country3= mysql_real_escape_string($_REQUEST['country3']);
	  $country4= mysql_real_escape_string($_REQUEST['country4']);
	  $placeofburial= mysql_real_escape_string($_REQUEST['placeofburial']);
	  $constituency= mysql_real_escape_string($_REQUEST['constituency']);
	  $ward= mysql_real_escape_string($_REQUEST['ward']);
	  $location= mysql_real_escape_string($_REQUEST['location']);
	  $sublocation= mysql_real_escape_string($_REQUEST['sublocation']);
	  $village= mysql_real_escape_string($_REQUEST['village']);
	  $persontransportingdeceased= mysql_real_escape_string($_REQUEST['persontransportingdeceased']);
	  $firm= mysql_real_escape_string($_REQUEST['firm']);
	  $vehicleregno= mysql_real_escape_string($_REQUEST['vehicleregno']);
	  $type= mysql_real_escape_string($_REQUEST['type']);
	  $contact= mysql_real_escape_string($_REQUEST['contact']);
	  $humanremainsrelasedby= mysql_real_escape_string($_REQUEST['humanremainsrelasedby']);
	  $telephone= mysql_real_escape_string($_REQUEST['telephone']);
	  $trackno= mysql_real_escape_string($_REQUEST['trackno']);
	
		$query10 = "select docno from mortuary_burialdetails where docno='$docno'";
		$exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());
		$num10=mysql_num_rows($exec10);
		$res10 = mysql_fetch_array($exec10);
	if($num10==0)
	{		 
 $query38="insert into mortuary_burialdetails(date,docno,disease,bodyrelaseto,relationship,placeofdeath,country1,country2,country3,country4,placeofburial,constituency,ward,location,sublocation,village,persontransportingdeceased,firm,vehicleregno,type,contact,humanremainsrelasedby,telephone,trackno,username) 
 values('$date','$docno','$disease','$bodyrelaseto','$relationship','$placeofdeath','$country1','$country2','$country3','$country4','$placeofburial','$constituency','$ward','$location','$sublocation','$village','$persontransportingdeceased','$firm','$vehicleregno','$type','$contact','$humanremainsrelasedby','$telephone','$trackno','$username')";
	}
	else
	{
	  $query38="update mortuary_burialdetails set bodyrelaseto='$bodyrelaseto',relationship='$relationship',placeofdeath='$placeofdeath',country1='$country1',country2='$country2',country3='$country3',country4='$country4',placeofburial='$placeofburial',
	  constituency='$constituency',ward='$ward',location='$location',sublocation='$sublocation',village='$village',persontransportingdeceased='$persontransportingdeceased',firm='$firm',vehicleregno='$vehicleregno',type='$type',contact='$contact',
	  humanremainsrelasedby='$humanremainsrelasedby',telephone='$telephone',trackno='$trackno' where docno='$docno'";
	}
	   
	  $exec381=mysql_query($query38) or die(mysql_error());

/*		if(isset($_REQUEST['approved'])){
			$docno = $_REQUEST['docno'];
		 $docno; 	
   $query39=mysql_query("update mortuary_request set transferstatus='completed' where docno='$docno'") or die(mysql_error());
		}

		if($paymentstatus=='ipdeposit'){
			header("location:depositform.php?patientcode=$patientcode&&visitcode=$visitcode&&docno=$docno");
		}
		if($update=='update'){
			header("location:mortuaryshellallocation.php?patientcode=$patientcode&&visitcode=$visitcode&&docno=$docno");
		}
		else{
		header("location:mortuaryapprovallist.php");
		}
*/	
			header("location:mortuaryactivity.php");
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



?>
<style type="text/css">
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
if(document.getElementById("bed").value == '')
{
alert("Please Select Bed");
document.getElementById("bed").focus();
return false;
}
if(document.getElementById("ward").value == '')
{
alert("Please Select Ward");
document.getElementById("ward").focus();
return false;
}
if(form1.approved.checked==false)
{
alert('please select ready to transfer');
return false;
}


}





function funcRadio(id){
	
	if(document.getElementById("approved").id==id)
	{
	document.getElementById("ipdeposit").checked=false;
	}else if(document.getElementById("ipdeposit").id==id)
	{
	document.getElementById("approved").checked=false;
	}
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
</style>
</head>

<script>
function printmortuary()
 {
	
var popWin; 
popWin = window.open("print_mortuaryburiallist.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docno=<?php echo $docno; ?>","OriginalWindowA4",'width=600,height=700,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
 }
 
 function funcvalidation()
{
printmortuary();


}
 
</script>


<script src="js/datetimepicker_css.js"></script>

<body>
<form name="form1" id="form1" method="post" action="mortuaryburialform.php" onSubmit="return validcheck()">	
  <input type="hidden" name="frmflag1" value="frmflag1" />
  <table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="14" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="14" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="14" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="14">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      
	 
	
		<tr>
		<td>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1329" 
            align="left" border="0">
          <tbody>
             <tr>
			  <td colspan="2" align="left" valign="center" class="bodytext31"><strong>DocNo</strong></td>
			   <td colspan="1" width="170" align="left" valign="center" class="bodytext31"><input type="text" name="docno" id="docno" value="<?php echo $docno; ?>" size="10" readonly></td>
			  <td colspan="1" width="52"  align="left" valign="center" class="bodytext31"><strong>Date</strong></td>
			   <td colspan="2" width="103"  align="left" valign="center" class="bodytext31"> 
			   <input type="text" name="date" id="date" value="<?php echo $updatedate; ?>" size="10" readonly>
                      <strong><span class="bodytext312"> <img src="images2/cal.gif" onClick="javascript:NewCssCal('dateofbirth')" style="cursor:pointer"/> </span></strong>
               </td>
             </tr>
            <tr>
              
				 <td colspan="2"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center">
				   <label><strong> Patient Code</strong></label></div></td>
           
				 <td colspan="2"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Name  </strong></div></td>
				 <td width="103"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>IP Visit  </strong></div></td>
				 <td width="161"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Account</strong></div></td>
				 <td width="104"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Shelf</strong></div></td>
				<td width="161"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Package</strong></div></td>
              </tr>
			  
			  
			  
           <?php
            $colorloopcount ='';

	 
	
		$query1 = "select * from mortuary_allocation where patientcode='$patientcode' and visitcode='$visitcode' and docno ='$docno'";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		
		while($res1 = mysql_fetch_array($exec1))
		{
		$patientname=$res1['patientname'];
		$patientcode=$res1['patientcode'];
		$accountname = $res1['accountname'];
			 $requestno = $res1['requestno'];
		
	
		$query69 = "SELECT * FROM mortuary_request WHERE docno = '$requestno'";
		$exec69 = mysql_query($query69) or die(mysql_error());
		$num69 = mysql_num_rows($exec69);
		$res69 = mysql_fetch_array($exec69);
		$age = $res69['age'];
		$gender = $res69['gender'];
		$billtype = $res69['billtype'];
		
		$query32 = "select * from ip_discharge where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec32 = mysql_query($query32) or die(mysql_error());
		$num32 = mysql_num_rows($exec32);
		
		$query67 = "select * from master_accountname where auto_number='$accountname'";
		$exec67 = mysql_query($query67); 
		$res67 = mysql_fetch_array($exec67);
		$accname = $res67['accountname'];
		
		
		   $query63 = "select * from ip_bedallocation where patientcode='$patientcode' and visitcode='$visitcode'";
		   $exec63 = mysql_query($query63) or die(mysql_error());
		   $res63 = mysql_fetch_array($exec63);
		   $ward = $res63['ward'];
		   $bed = $res63['bed'];
		   
		   $query71 = "select * from ip_creditapproval where patientcode='$patientcode' and visitcode='$visitcode' order by auto_number desc";
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
						  
            $query34 = "SELECT * FROM mortuary_allocation WHERE docno='$docno'";
			$exec34 = mysql_query($query34) or die("Error in Query34: ".mysql_error());
			$res34 = mysql_fetch_array($exec34);
			 $shelf = $res34['shelve'];
			 $package = $res34['package'];
						  
						  
	 $query782="select * from mortuary_burialdetails where docno='$docno'";
	$exec782=mysql_query($query782) or die(mysql_error());
	$result=mysql_fetch_array($exec782);
	  $bodyrelaseto= mysql_real_escape_string($result['bodyrelaseto']);
	  $relationship= mysql_real_escape_string($result['relationship']);
	  $placeofdeath= mysql_real_escape_string($result['placeofdeath']);
	  $country1= mysql_real_escape_string($result['country1']);
	  $country2= mysql_real_escape_string($result['country2']);
	  $country3= mysql_real_escape_string($result['country3']);
	  $country4= mysql_real_escape_string($result['country4']);
	  $placeofburial= mysql_real_escape_string($result['placeofburial']);
	  $constituency= mysql_real_escape_string($result['constituency']);
	  $ward= mysql_real_escape_string($result['ward']);
	  $location= mysql_real_escape_string($result['location']);
	  $sublocation= mysql_real_escape_string($result['sublocation']);
	  $village= mysql_real_escape_string($result['village']);
	  $persontransportingdeceased= mysql_real_escape_string($result['persontransportingdeceased']);
	  $firm= mysql_real_escape_string($result['firm']);
	  $vehicleregno= mysql_real_escape_string($result['vehicleregno']);
	  $type= mysql_real_escape_string($result['type']);
	  $contact= mysql_real_escape_string($result['contact']);
	  $humanremainsrelasedby= mysql_real_escape_string($result['humanremainsrelasedby']);
	  $telephone= mysql_real_escape_string($result['telephone']);
	  $trackno= mysql_real_escape_string($result['trackno']);

	$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				echo "";
				$colorcode = 'bgcolor="#D3EEB7"';
			}
			?>
          <tr <?php echo $colorcode; ?>>
             
			  <td colspan="2"  align="left" valign="center" class="bodytext31">
			    <div align="center"><?php echo $patientcode; ?></div></td>
				<td colspan="2"  align="center" valign="center" class="bodytext31"><?php echo $patientname; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $visitcode; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $accname; ?></td>
				<input type="hidden" name="accname" id="accname" value="<?php echo $accname; ?>">
				<td  align="center" valign="center" class="bodytext31"><?php echo $shelf; ?></td>
                
				<td  align="center" valign="center" class="bodytext31"><?php echo $package; ?></td>
				<input type="hidden" name="wardanum" id="wardanum" value="<?php echo $ward; ?>">
				<input type="hidden" name="bedanum" id="bedanum" value="<?php echo $bed; ?>">
				<input type="hidden" name="patientname" id="patientname" value="<?php echo $patientname; ?>">
				 
				<input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>">
				<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>">
			
				<input type="hidden" name="accname" id="accname" value="<?php echo $accname; ?>">
				<input type="hidden" name="discharge" id="discharge" value="<?php echo $num32; ?>">

			   </tr>
			   <tr>
             	<td colspan="8" align="center" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#cccccc" class="bodytext3"><strong><u>BURIAL FORM</u></strong></td><td width="97" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#cccccc" class="bodytext311">&nbsp;</td>
            
             	<td width="196" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#cccccc" class="bodytext311">&nbsp;</td>
             	</tr>
 
			   
			  <tr>
			  <td colspan="30"align="center" valign="center" bgcolor="#E0E0E0" class="bodytext3" ><b>&nbsp;</b></td>
			  
			  </tr>
			 
			  <tr>
			  <td colspan="2" align="left" valign="left" class="bodytext3" bgcolor="#E0E0E0"><strong>Body Relase to:</strong></td>
			  <td><textarea name="bodyrelaseto" id="bodyrelaseto" placeholder="Body Relase to"><?php echo $bodyrelaseto;?></textarea></td>
			  <td colspan="2" align="left" valign="left" class="bodytext3" bgcolor="#E0E0E0"><strong>Realationship</strong></td>
			  <td><textarea name="relationship" id="relationship" placeholder="Realationship"><?php echo $relationship;?></textarea></td>
			  <td colspan="1"align="center" valign="middle" class="bodytext3"  bgcolor="#E0E0E0" width="104"><strong>Place of Death:</strong></td>
			  <td><textarea name="placeofdeath" id="placeofdeath" placeholder="Place of Death"><?php echo $placeofdeath;?></textarea></td>
			 <td colspan="1" align="right" valign="right" class="bodytext3" bgcolor="#E0E0E0" width="97"><strong>County:</strong></td>
			  <td width="196"><textarea name="country1" id="country1" placeholder="County"><?php echo $country1;?></textarea></td>
			  </tr>

			  <tr>
			  <td colspan="2" align="left" valign="left" class="bodytext3" bgcolor="#E0E0E0"><strong>Country</strong></td>
			  <td><textarea name="country2" id="country2" placeholder="Country"><?php echo $country2;?></textarea></td>
			  <td colspan="2" align="left" valign="left" class="bodytext3" bgcolor="#E0E0E0"><strong>Place of Burial:</strong></td>
			  <td><textarea name="placeofburial" id="placeofburial" placeholder="Place of Burial"><?php echo $placeofburial;?></textarea></td>
			  <td colspan="1"align="center" valign="middle" class="bodytext3"  bgcolor="#E0E0E0" width="104"><strong>County</strong></td>
			  <td><textarea name="country3" id="country3" placeholder="County"><?php echo $country3;?></textarea></td>
			 <td colspan="1" align="right" valign="right" class="bodytext3" bgcolor="#E0E0E0" width="97"><strong>Country:</strong></td>
			  <td><textarea name="country4" id="country4" placeholder="Country"><?php echo $country4;?></textarea></td>
			  </tr>

			  <tr>
			  <td colspan="2" align="left" valign="left" class="bodytext3" bgcolor="#E0E0E0"><strong>Constituency</strong></td>
			  <td><textarea name="constituency" id="constituency" placeholder="Constituency"><?php echo $constituency;?></textarea></td>
			  <td colspan="2" align="left" valign="left" class="bodytext3" bgcolor="#E0E0E0"><strong>Ward</strong></td>
			  <td><textarea name="ward" id="ward" placeholder="Ward"><?php echo $ward;?></textarea></td>
			  <td colspan="1"align="center" valign="middle" class="bodytext3"  bgcolor="#E0E0E0" width="104"><strong>Location</strong></td>
			  <td><textarea name="location" id="location" placeholder="Location"><?php echo $location;?></textarea></td>
			 <td colspan="1" align="right" valign="right" class="bodytext3" bgcolor="#E0E0E0" width="97"><strong>Sub-Location:</strong></td>
			  <td><textarea name="sublocation" id="sublocation" placeholder="Sub-Location"><?php echo $sublocation;?></textarea></td>
			  </tr>


			  <tr>
			  <td colspan="2" align="left" valign="left" class="bodytext3" bgcolor="#E0E0E0"><strong>Village</strong></td>
			  <td><textarea name="village" id="village" placeholder="Village"><?php echo $village;?></textarea></td>
			  <td colspan="2" align="left" valign="left" class="bodytext3" bgcolor="#E0E0E0"><strong>Person Transforting deceased:</strong></td>
			  <td><textarea name="persontransportingdeceased" id="persontransportingdeceased" placeholder="Person Transforting deceased"><?php echo $persontransportingdeceased;?></textarea></td>
			  <td colspan="1"align="center" valign="middle" class="bodytext3"  bgcolor="#E0E0E0" width="104"><strong>Firm</strong></td>
			  <td><textarea name="firm" id="firm" placeholder="Firm"><?php echo $firm;?></textarea></td>
			 <td colspan="1" align="right" valign="right" class="bodytext3" bgcolor="#E0E0E0" width="97"><strong>Vehicle Reg.No:</strong></td>
			  <td><textarea name="vehicleregno" id="vehicleregno" placeholder="Vehicle Reg.No"><?php echo $vehicleregno;?></textarea></td>
			  </tr>

			  <tr>
			  <td colspan="2" align="left" valign="left" class="bodytext3" bgcolor="#E0E0E0"><strong>Type</strong></td>
			  <td><textarea name="type" id="type" placeholder="Type"><?php echo $type;?></textarea></td>
			  <td colspan="2" align="left" valign="left" class="bodytext3" bgcolor="#E0E0E0"><strong>Contact</strong></td>
			  <td><textarea name="contact" id="contact" placeholder="Contact"><?php echo $contact;?></textarea></td>
			  <td colspan="1"align="center" valign="middle" class="bodytext3"  bgcolor="#E0E0E0" width="104"><strong>Human remains released by:</strong></td>
			  <td><textarea name="humanremainsrelasedby" id="humanremainsrelasedby" placeholder="Human remains released by"><?php echo $humanremainsrelasedby;?></textarea></td>
			 <td colspan="1" align="right" valign="right" class="bodytext3" bgcolor="#E0E0E0" width="97"><strong>Telephone:</strong></td>
			  <td><textarea name="telephone" id="telephone" placeholder="Telephone"><?php echo $telephone;?></textarea></td>
			  </tr>

			  <tr>
			  <td colspan="2" class="bodytext3">Track No.</td>
			  <td colspan=""><textarea id="trackno" name="trackno" placeholder="Track No"><?php echo $trackno?></textarea></td>
              
			  <td align="right">&nbsp;</td>
			  <td colspan="">&nbsp;</td>
              
			  <td colspan="3" align="right">&nbsp;</td>
			  <td colspan="">&nbsp;</td>
              </tr>
			  
		   <?php 
		  } 
		  
		   ?>
           
            <tr>
             	<td colspan="8" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#cccccc" class="bodytext311">&nbsp;</td><td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
            
             	<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
             	</tr>
          </tbody>
        </table>		</td>
		</tr>
		
		</table>		</td>
	</tr>
	
      <tr>
        <td width="70">&nbsp;</td>
      </tr>
<!--       <tr>
        <td>&nbsp;</td>
		 <td width="3%">&nbsp;</td>
		  <td width="3%">&nbsp;</td>
		<td width="26%" align="right" valign="center" class="bodytext311">Request for Approval</td>
		<td width="29%" align="left" valign="center" class="bodytext311">
        <input type="checkbox" name="requestforapproval" id="requestforapproval" value="1">
        
        </td>
      </tr>
-->	  <tr>
<td height="30">&nbsp;</td>
<td width="70">&nbsp;</td>
  	
<td width="96">&nbsp;</td>


	   
      <td width="174"><input type="submit" name="update" value="Submit" style="border: 1px solid #001E6A" onClick="return funcvalidation()"/></td>
	  <td colspan="1" align="left" valign="middle" width="891"><!--<a href="mortuaryshellallocation.php?docno=<?php echo $docno;?>&&patientcode=<?php echo $patientcode;?>&&visitcode=<?php echo $visitcode;?>"><strong><u>Back</u></strong></a>--></td>
</tr>
  </table>
  </table>
</form>
<?php include ("includes/footer1.php"); ?>



