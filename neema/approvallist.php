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

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//echo $ADate2;

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

<table width="103%" border="0" cellspacing="0" cellpadding="2"><!--maintable  -->
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
<tr><!--maintable5throwstart  -->
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><!--maintable2tdstarthere  -->
	   <table width="105%" border="0" cellspacing="0" cellpadding="0"><!--2ndtablestarthere  -->
	
	      
		  <tr><!--2ndtable-1strow start here  -->
				<td width="860"><!--2ndtable-1sttd start here  -->
					<form name="cbform1" method="post" action="approvallist.php">
<!--3rd table start here --><table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
						<tbody><!--3rd table tbody start here -->
							<tr><!--3rd table 1st row start here -->
								<td align="left" bgcolor="#CCCCCC" class="bodytext3" colspan="2"><strong>Approval  List </strong></td>
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
							</tr><!--3rd table 1st row end here -->
							<tr><!--3rd table 2nd row start here -->
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
             
							</tr><!--3rd table 2nd row end here -->
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
								<td width="100" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong>
								</td>
								<td width="137" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">
								<input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
								<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			
								</td>
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
									<input name="resetbutton" type="reset" id="resetbutton"  value="Reset" />
								</td>
							</tr>
						</tbody><!--3rd table tbody end here -->
					</table><!--3rd table end here -->
					</form>	<!--3rd table form end here -->	
				</td><!--2ndtable-1sttd end here  -->
			</tr><!--2ndtable-1st tr end here  -->
			<tr><!--2ndtable-2nd tr start here  -->
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
			<tr><!--2ndtable-3rd tr start here  -->   
						<td width="99%" valign="top"><!--2ndtable-3rd tr 1st td start here  --> 
						   <table width="116%" border="0" cellspacing="0" cellpadding="0"><!--3rdtable start here  --> 
								<tr><!--3rdtable 1st tr start here  --> 
									<td><!--3rdtable 1st td start here  --> 
	<!--4rth table   start here  -->	<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
												bordercolor="#666666" cellspacing="0" cellpadding="4" width="900" align="left" border="0">
											<tbody><!--4rth table tbody  start here  -->
													<tr><!--4rth table 1st tr  start here  -->
															<td colspan="6" bgcolor="#cccccc" class="bodytext31">
																<!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
																<div align="left"><strong> Approval List</strong><label class="number">&nbsp;</label>
																</div>
															</td>
													  </tr>
													  <tr><!--4rth table 2nd tr  start here  -->
													  <td width="10%"  align="left" valign="center" 
																bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>s.no</strong></div></td>
															  <td width="10%"  align="left" valign="center" 
																bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>patientcode</strong></div></td>
															  <td width="10%"  align="left" valign="center" 
																bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>visitcode</strong></div></td>
															  <td width="5%"  align="left" valign="center" 
																bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>patientname</strong></div></td>
															  <td width="15%"  align="left" valign="center" 
																bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>consultationdate</strong></div></td>
															 				
															  <td width="10%"  align="left" valign="center" 
																bgcolor="#ffffff" class="bodytext31"><strong>Action</strong></td>				
              
													   </tr>		
														
														<?php
														
												        $i=1;
													
												
													
														$sql1 = "select * from master_consultation where patientname like '%$searchpatient%' and patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and approval = '1'   and recorddate between '$fromdate' and '$todate' and locationcode='$locationcode' GROUP BY patientvisitcode  order by auto_number desc ";
														$result = mysql_query($sql1);
														while ($row = mysql_fetch_array($result))
														{
															$patientcode=$row['patientcode'];
															$patientvisitcode=$row['patientvisitcode'];
															
																$sql15 = "select auto_number from master_transactionpaylater where  patientcode = '".$patientcode."' and visitcode = '".$patientvisitcode."'";
														$result5 = mysql_query($sql15);
														$row5 = mysql_num_rows($result5);
														if($row5==0)
														{
														?>
														<?php
														

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
														
														<tr <?php echo $colorcode; ?>><!--4rth table 3rd tr  start here  -->
															 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo  $i;?></div></td>
															  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $row['patientcode'] ;?></div></td>
															  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $row['patientvisitcode'] ;?></div></td>
															  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $row['patientname'];?></div></td>
															  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $row['recorddate']. $row['consultationtime'] ;?></div></td>
															 
															  <td class="bodytext31" valign="center"  align="left"><div align="left"><a href="opamend.php?patientcode=<?php echo $row['patientcode'] ;?>&&visitcode=<?php echo $row['patientvisitcode'] ;?>">Approve</a></div></td>
														</tr>
														<?php
														$i++;
														}
														}
														
														?>	
														<tr><!--4rth table 4rth tr  start here  -->
															  <td class="bodytext31" valign="center"  align="left" bgcolor="#cccccc">&nbsp;</td>
															  <td class="bodytext31" valign="center"  align="left" bgcolor="#cccccc">&nbsp;</td>
															  <td class="bodytext31" valign="center"  align="left" bgcolor="#cccccc">&nbsp;</td>
															  <td class="bodytext31" valign="center"  align="left" bgcolor="#cccccc">&nbsp;</td>
															  <td class="bodytext31" valign="center"  align="left" bgcolor="#cccccc">&nbsp;</td>
															  <td class="bodytext31" valign="center"  align="left" bgcolor="#cccccc">&nbsp;</td>
																	
														</tr>
											</tbody><!--4rth table tbody end here  -->
						<?php
							}//ifendhere
						?>
										</table><!--4rth table   end here  -->
								   </td><!--3rdtable 1st td end here  --> 
							    </tr><!--3rdtable 1st tr end here  --> 

							</table><!--3rdtable end here  --> 
						</td><!--2ndtable-3rd tr 1st td end here  --> 
						</tr><!--2ndtable-3rd tr end here  --> 
     </table><!--2ndtable  end here  -->
	 </td><!--maintable2td end here  -->
	 </tr><!--maintable5throwstarthere  -->
</table><!--maintableendhere  -->
<?php include ("includes/footer1.php"); ?>
</body>
</html>

