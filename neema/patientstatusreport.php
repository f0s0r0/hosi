<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$errmsg = "";
$snocount = "";
$colorloopcount="";
$searchsuppliername = "";
//This include updatation takes too long to load for hunge items database.
//include ("autocompletebuild_patientstatus.php");
 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';

if (isset($_REQUEST["location"])) { $locationcode1 = $_REQUEST["location"]; }
else if(isset($_REQUEST["locationcode1"]))
{
	$locationcode1=$_REQUEST["locationcode1"];
}
else { $locationcode1 = ""; }

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }

	if (isset($_REQUEST["searchsuppliercode"])) 
	{
	 $searchsuppliercode = $_REQUEST["searchsuppliercode"]; 
	}
	else { $searchsuppliercode = ""; }
	
if (isset($_REQUEST["searchvisitcode"])) { $searchvisitcode = $_REQUEST["searchvisitcode"]; }
else if(isset($_REQUEST["visitcode"]))
	{ 
$searchvisitcode = $_REQUEST["visitcode"]; 
}
 else { $searchvisitcode = ""; }

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
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
<script src="js/datetimepicker_css.js"></script>
<script type="text/javascript" src="js/autocomplete_patientstatus.js"></script>
<script type="text/javascript" src="js/autosuggestpatientstatus1.js"></script>
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


window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
}
</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 12px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>
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
        <td width="860">
		
		
              <form name="cbform1" method="post" action="patientstatusreport.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Patient Status Report</strong></td>
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
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Patient</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
              <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">
			  <input name="searchsuppliercode" id="searchsuppliercode" value="<?php echo $searchsuppliercode; ?>" type="hidden">
			  <input name="searchvisitcode" id="searchvisitcode" value="<?php echo $searchvisitcode; ?>" type="hidden">
			  <input name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox" type="hidden" value="">
			  
              </span></td>
           </tr>
		   
			  <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>	
						<tr>
  			  <td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
			 
				 <select name="location" id="location" onChange="ajaxlocationfunction(this.value);">
                    <?php
						
						$query1 = "select * from login_locationdetails where   username='$username' and docno='$docno' order by locationname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						$loccode=array();
						while ($res1 = mysql_fetch_array($exec1))
						{
						$locationname = $res1["locationname"];
						$locationcode = $res1["locationcode"];
						
						?>
						 <option value="<?php echo $locationcode; ?>" <?php if($location!='')if($location==$locationcode){echo "selected";}?>><?php echo $locationname; ?></option>
						<?php
						} 
						?>
                      </select>
					 
              </span></td>
			   <td width="10%" align="left" colspan="2" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
			  </tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
			  <input type="submit" value="Search" name="Submit" />
			  <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
            </tr>
          </tbody>
        </table>
		</form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
       <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="682" 
            align="left" border="0">
          <tbody>
            
    		<?php
			 
			 if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
		  $query21 = "select * from master_visitentry where locationcode='$locationcode1' and visitcode = '$searchvisitcode' order by auto_number desc ";
		  $exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
		  while ($res21 = mysql_fetch_array($exec21))
		  {
     	  $res21patientfullname = $res21['patientfullname'];
		  $res21patientcode = $res21['patientcode'];
		  $res21visitcode = $res21['visitcode'];
		  $res21billtype = $res21['billtype'];
		  $res21age = $res21['age'];
		  $res21gender= $res21['gender'];
  		  $res21billtype= $res21['billtype'];
		  $res21departmentname= $res21['departmentname'];
		  
		  $query1 = "select * from billing_consultation where locationcode='$locationcode1' and patientcode='$res21patientcode' and patientvisitcode = '$res21visitcode' ";
		  $exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		  $num1 = mysql_num_rows($exec1);
		  
		  $query2 = "select * from master_triage where locationcode='$locationcode1' and  patientcode='$res21patientcode' and  visitcode = '$res21visitcode' and triagestatus ='completed' ";
		  $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		  $num2 = mysql_num_rows($exec2);
		  
		  $query3 = "select * from master_consultation where locationcode='$locationcode1' and  patientcode='$res21patientcode' and  patientvisitcode = '$res21visitcode' and recordstatus='completed' ";
		  $exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
		  $num3 = mysql_num_rows($exec3);
		  
		  $query4 = "select * from billing_paynow where locationcode='$locationcode1' and  patientcode='$res21patientcode' and  visitcode = '$res21visitcode' and billstatus ='paid' ";
		  $exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		  $num4 = mysql_num_rows($exec4);
		  
		  $query5 = "select * from billing_paylater where locationcode='$locationcode1' and  patientcode='$res21patientcode' and  visitcode = '$res21visitcode' ";
		  $exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
		  $num5 = mysql_num_rows($exec5);
		  
		  $query16 = "select * from master_consultationpharm where patientcode='$res21patientcode' and  patientvisitcode = '$res21visitcode' ";
		  $exec16 = mysql_query($query16) or die ("Error in Query16".mysql_error());
		  $num16 = mysql_num_rows($exec16);
		  
		  $query26 = "select * from pharmacysales_details where locationcode='$locationcode1' and patientcode='$res21patientcode' and  visitcode = '$res21visitcode' ";
		  $exec26 = mysql_query($query26) or die ("Error in Query26".mysql_error());
		  $num26 = mysql_num_rows($exec26);

          $query7 = "select * from samplecollection_lab where locationcode='$locationcode1' and patientcode='$res21patientcode' and patientvisitcode = '$res21visitcode' ";
		  $exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
		  $num7 = mysql_num_rows($exec7);
		  
		  $query17 = "select * from samplecollection_lab where locationcode='$locationcode1' and patientcode='$res21patientcode' and  patientvisitcode = '$res21visitcode' and status='completed'  ";
		  $exec17 = mysql_query($query17) or die ("Error in Query17".mysql_error());
		  $num17 = mysql_num_rows($exec17);
		  
		  $query8 = "select * from consultation_radiology where locationcode='$locationcode1' and patientcode='$res21patientcode' and patientvisitcode = '$res21visitcode' and paymentstatus ='completed' and resultentry='completed' ";
		  $exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
		  $num8 = mysql_num_rows($exec8);
		  
		  $query18 = "select * from consultation_radiology where locationcode='$locationcode1' and patientcode='$res21patientcode' and patientvisitcode = '$res21visitcode' and paymentstatus ='completed' and resultentry='pending'";
		  $exec18 = mysql_query($query18) or die ("Error in Query18".mysql_error());
		  $num18 = mysql_num_rows($exec18);
		  
          $query9 = "select * from resultentry_lab where locationcode='$locationcode1' and patientcode='$res21patientcode' and patientvisitcode = '$res21visitcode' ";
		  $exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		  $num9 = mysql_num_rows($exec9);
		  
		  $query19 = "select * from resultentry_lab where locationcode='$locationcode1' and patientcode='$res21patientcode' and  patientvisitcode = '$res21visitcode' and resultstatus='completed'  ";
		  $exec19 = mysql_query($query19) or die ("Error in Query19".mysql_error());
		  $num19 = mysql_num_rows($exec19);
		  
		  $query29 = "select * from resultentry_lab where locationcode='$locationcode1' and patientcode='$res21patientcode' and patientvisitcode = '$res21visitcode' ";
		  $exec29 = mysql_query($query29) or die ("Error in Query29".mysql_error());
		  $num29 = mysql_num_rows($exec29);
		  
		  $query219 = "select * from resultentry_lab where locationcode='$locationcode1' and patientcode='$res21patientcode' and  patientvisitcode = '$res21visitcode' and publishstatus='completed'  ";
		  $exec219 = mysql_query($query219) or die ("Error in Query219".mysql_error());
		  $num219 = mysql_num_rows($exec219);
		  
		  		  
		    $snocount = $snocount + 1;
			
			//echo $cashamount;
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
	        <tr bgcolor="#FFFFFF">
               <td colspan="3"  align="left" valign="center" class="bodytext31"><strong><?php echo $res21patientfullname; ?>,<?php echo $res21patientcode; ?>,<?php echo $res21visitcode; ?></strong></td>
               </tr>
	        <tr>
	          <td width="217" align="left" valign="center" class="bodytext31"><strong>Description </strong></td>
	          <td width="243" align="left" valign="center" class="style1">Status</td>
	          <td width="198" align="left" valign="center" class="style1">Remarks</td>
	          </tr>		
   		   <?php if($res21billtype != 'PAY LATER') { ?>
           <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left">Consultation Bill</td>
               <td class="bodytext31" valign="center"  align="left"><?php if($num1 != '0') { echo 'Completed'; } else { echo 'Pending'; } ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res21departmentname; ?></td>
           </tr>
           <?php } ?>
           <tr <?php echo $colorcode; ?>>
             <td class="bodytext31" valign="center"  align="left">Triage</td>
             <td class="bodytext31" valign="center"  align="left"><?php if($num2 != '0') { echo 'Completed'; } else { echo 'Pending'; } ?></td>
             <td class="bodytext31" valign="center"  align="left"><?php echo $res21departmentname; ?></td>
           </tr>
		   <tr <?php echo $colorcode; ?>>
             <td class="bodytext31" valign="center"  align="left">Consultation</td>
             <td class="bodytext31" valign="center"  align="left"><?php if($num3 != '0') { echo 'Completed'; } else { echo 'Pending'; } ?></td>
             <td class="bodytext31" valign="center"  align="left"><?php echo $res21departmentname; ?></td>
           </tr>
		   <?php if($res21billtype != 'PAY LATER') { ?>
		   <tr <?php echo $colorcode; ?>>
             <td class="bodytext31" valign="center"  align="left">Pay Now Bill</td>
             <td class="bodytext31" valign="center"  align="left"><?php if($num4 != '0') { echo 'Completed'; } else { echo 'Pending'; } ?></td>
             <td class="bodytext31" valign="center"  align="left"><?php echo $res21departmentname; ?></td>
           </tr>
		   
		   <?php } else { ?>
		  <!-- <tr <?php echo $colorcode; ?>>
             <td class="bodytext31" valign="center"  align="left">Pay Later Bill</td>
             <td class="bodytext31" valign="center"  align="left"><?php if($num5 != '0') { echo 'Completed'; } else { echo 'Pending'; } ?></td>
             <td class="bodytext31" valign="center"  align="left"><?php echo $res21departmentname; ?></td>
           </tr>-->
		   
		    <tr <?php echo $colorcode; ?>>
             <td class="bodytext31" valign="center"  align="left">Pay Now Bill</td>
             <td class="bodytext31" valign="center"  align="left"><?php echo 'N/A'; ?></td>
             <td class="bodytext31" valign="center"  align="left"><?php echo $res21departmentname; ?></td>
           </tr>
		   <?php } ?>
		   <tr <?php echo $colorcode; ?>>
             <td class="bodytext31" valign="center"  align="left">Pharmacy</td>
             <td class="bodytext31" valign="center"  align="left">
			 <?php 
			 if($num16 != '0')  
			 { 
			   if($num26 != '0')
			    {
			     echo 'Completed'; 
			    } 
			    else
				{
				 echo 'Not Done'; 
			    } 
			 }else
			  {
			   echo 'N/A'; 
			  } 
			 ?>			 </td>
             <td class="bodytext31" valign="center"  align="left"><?php echo $res21departmentname; ?></td>
           </tr>
		   
		    <tr <?php echo $colorcode; ?>>
             <td class="bodytext31" valign="center"  align="left">Lab Sample</td>
             <td class="bodytext31" valign="center"  align="left">
			 <?php 
			 if($num7 != '0')  
			 { 
			   if($num17 != '0')
			    {
			     echo 'Completed'; 
			    } 
			    else
				{
				 echo 'Not Done'; 
			    } 
			 }else
			  {
			   echo 'N/A'; 
			  } 
			 ?>			 </td>
             <td class="bodytext31" valign="center"  align="left"><?php echo $res21departmentname; ?></td>
           </tr>
		   
           <tr <?php echo $colorcode; ?>>
             <td class="bodytext31" valign="center"  align="left">Lab Result</td>
             <td class="bodytext31" valign="center"  align="left">
			 <?php 
			 if($num9 != '0')  
			 { 
			   if($num19 != '0')
			    {
			     echo 'Completed'; 
			    } 
			    else
				{
				 echo 'Not Done'; 
			    } 
			 }else
			  {
			   echo 'N/A'; 
			  } 
			 ?>			 </td>
             <td class="bodytext31" valign="center"  align="left"><?php echo $res21departmentname; ?></td>
           </tr>
           
            <tr <?php echo $colorcode; ?>>
             <td class="bodytext31" valign="center"  align="left">Lab Publish</td>
             <td class="bodytext31" valign="center"  align="left">
			 <?php 
			 if($num29 != '0')  
			 { 
			   if($num219 != '0')
			    {
			     echo 'Completed'; 
			    } 
			    else
				{
				 echo 'Not Done'; 
			    } 
			 }else
			  {
			   echo 'N/A'; 
			  } 
			 ?>			 </td>
             <td class="bodytext31" valign="center"  align="left"><?php echo $res21departmentname; ?></td>
           </tr>
           
           
		   <tr <?php echo $colorcode; ?>>
             <td class="bodytext31" valign="center"  align="left">Radiology </td>
             <td class="bodytext31" valign="center"  align="left">
			 <?php 
			 if($num8 != '0')  
			 { 
			   if($num18 != '0')
			    {
			     echo 'Completed'; 
			    } 
			    else
				{
				 echo 'Pending'; 
			    } 
			 }else
			  {
			   echo 'N/A'; 
			  } 
			 ?>			 </td>
             <td class="bodytext31" valign="center"  align="left"><?php echo $res21departmentname; ?></td>
           </tr>
			<?php
			}
		   	
			?>
            <tr>
              <td colspan="4"  align="left" valign="center" 
                bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
              </tr>
			  <?php
			  }
			  ?>
          </tbody>
        </table></td>
      </tr>
	  
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
