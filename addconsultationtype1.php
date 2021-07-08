<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$docno = $_SESSION['docno'];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$subtype = "";
$paymenttype = "";
$recorddate = "";

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
 	
	$consultationtype = $_REQUEST["consultationtype"];
	$locationcode = $_REQUEST["location"];
	$department = $_REQUEST["department"];
	$consultationfees = $_REQUEST["consultationfees"];
	$default = isset($_REQUEST['default'])?$_REQUEST['default']:'';
	$paymenttype = $_REQUEST['paymenttype'];
	$subtype = $_REQUEST['subtype'];
	$consultationtype = strtoupper($consultationtype);
	$consultationtype = trim($consultationtype);
	$length=strlen($consultationtype);
	$loccode= explode('-',$locationcode);
	
	$location = $loccode[1];
	//$que="select * from master_location where auto_number='$location'";
//	$exe=mysql_query($que) or die ("Error in Query1".mysql_error());
//	while ($res = mysql_fetch_array($exe))
//	{
//		$locationcode=$res['locationcode'];
//	}
	
	if ($length<=100)
	{
	
		$query1 = "insert into master_consultationtype (consultationtype, department,consultationfees,ipaddress,recorddate,username,locationname,locationcode,condefault,paymenttype,subtype) values ('$consultationtype', '$department','$consultationfees','$ipaddress','$recorddate', '$username','$location','$locationcode','".$default."', '$paymenttype', '$subtype')"; 

		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$errmsg = "Success. New Consultation Type Updated.";
		$bgcolorcode = 'success';
		
	
	}
	else
	{
		$errmsg = "Failed. Only 100 Characters Are Allowed.";
		$bgcolorcode = 'failed';
	}

}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_consultationtype set recordstatus = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
}
if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_consultationtype set recordstatus = '' where auto_number = '$delanum'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
}
if ($st == 'default')
{
	$delanum = $_REQUEST["anum"];
	$query4 = "update master_consultationtype set defaultstatus = '' where cstid='$custid' and cstname='$custname'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());

	$query5 = "update master_consultationtype set defaultstatus = 'DEFAULT' where auto_number = '$delanum'";
	$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
}
if ($st == 'removedefault')
{
	$delanum = $_REQUEST["anum"];
	$query6 = "update master_consultationtype set defaultstatus = '' where auto_number = '$delanum'";
	$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
}


if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add Consultation Type To Proceed For Billing.";
	$bgcolorcode = 'failed';
}


?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
</style>
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script>
function funcPaymentTypeChange1()
{

	<?php 
	$query12 = "select * from master_paymenttype where recordstatus = ''";
	$exec12 = mysql_query($query12) or die ("Error in Query11".mysql_error());
	while ($res12 = mysql_fetch_array($exec12))
	{
	$res12paymenttypeanum = $res12["auto_number"];
	$res12paymenttype = $res12["paymenttype"];
	?>
	if(document.getElementById("paymenttype").value=="<?php echo $res12paymenttypeanum; ?>")
	{
		document.getElementById("subtype").options.length=null; 
		var combo = document.getElementById('subtype'); 	
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Sub Type", ""); 
		<?php
		$query10 = "select * from master_subtype where maintype = '$res12paymenttypeanum' and recordstatus = ''";
		$exec10 = mysql_query($query10) or die ("error in query10".mysql_error());
		while ($res10 = mysql_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10subtypeanum = $res10["auto_number"];
		$res10subtype = $res10["subtype"];
		?>
			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10subtype;?>", "<?php echo $res10subtypeanum;?>"); 
		<?php 
		}
		?>
	}
	<?php
	}
	?>	
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
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>
<script language="javascript">

function addward1process1()
{
	//alert ("Inside Funtion");
	if (document.form1.location.value == "")
	{
		alert ("Pleae Select Location.");
		document.form1.location.focus();
		return false;
	}

	
	if (document.form1.department.value == "")
	{
		alert ("Pleae Select Department.");
		document.form1.department.focus();
		return false;
	}


	if (document.form1.consultationtype.value == "")
	{
		alert ("Pleae Enter Consultation Type Name.");
		document.form1.consultationtype.focus();
		return false;
	}
	
	if (document.form1.consultationfees.value == "")
	{
		alert ("Pleae Enter Consultation Fees.");
		document.form1.consultationfees.focus();
		return false;
	}		
}

function funcDeleteconsultationtype1(varConsultationTypeAutoNumber)
{
     var varAccountNameAutoNumber = varConsultationTypeAutoNumber;
	 var fRet;
	fRet = confirm('Are you sure want to delete this Consultation Type '+varAccountNameAutoNumber+'?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("Consultation Type  Entry Delete Completed.");
		//return false;
	}
	if (fRet == false)
	{
		alert ("Consultation Type Entry Delete Not Completed.");
		return false;
	}

}
</script>
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
    <td width="97%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
            <tr>
              <td><form name="form1" id="form1" method="post" action="addconsultationtype1.php" onSubmit="return addward1process1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="1" bgcolor="#CCCCCC" class="bodytext3"><strong>Consultation Type Master - Add New </strong></td>
                        <td width="10%" align="right" bgcolor="#CCCCCC" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
                  <?php
						
						$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						$res1 = mysql_fetch_array($exec1);
						
						echo $res1location = $res1["locationname"];
						
						
						?>
						
						
                  
                  </td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                      <tr>
                      	<td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Location
                        </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="location" id="location" onChange="ajaxlocationfunction(this.value);" style="border: 1px solid #001E6A;">
                        <option value="" selected="selected">Select location</option>';
                        <?php
						
                            $query6 = "select * from master_location where status = '' order by locationname";
							$exec6 = mysql_query($query6) or die ("Error in Query5".mysql_error());
							while ($res6 = mysql_fetch_array($exec6))
							{
								$res6anum = $res6["auto_number"];
								$res6location = $res6["locationname"];
								$locationcode = $res6["locationcode"];
						?>
                          <option value="<?php echo $locationcode; ?>"><?php echo $res6location; ?></option>
                          <?php
				}
				?>
                
						
						</select></td></tr>
                        <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Department</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="department" id="department" style="border: 1px solid #001E6A;">
                          
		
					<option value="" selected="selected">Select department</option>';
					
				
				
				<?php
				$query5 = "select * from master_department where recordstatus = '' order by department";
				$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
				while ($res5 = mysql_fetch_array($exec5))
				{
				$res5anum = $res5["auto_number"];
				$res5department = $res5["department"];
				?>
                          <option value="<?php echo $res5anum; ?>"><?php echo $res5department; ?></option>
                          <?php
				}
				?>
                        </select></td>
                      </tr>
					 <tr>
				 <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Main Type</div></td>
				  <td align="left" valign="middle"  bgcolor="#FFFFFF"> 
				  
				  <select name="paymenttype" id="paymenttype" onChange="return funcPaymentTypeChange1();"  style="border: 1px solid #001E6A;">
                  <option value="" selected="selected">Select Type</option>  
				  <?php
				$query5 = "select * from master_paymenttype where recordstatus = '' order by paymenttype";
				$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
				while ($res5 = mysql_fetch_array($exec5))
				{
				$res5anum = $res5["auto_number"];
				$res5paymenttype = $res5["paymenttype"];
				?>
                    <option value="<?php echo $res5anum; ?>"><?php echo $res5paymenttype; ?></option>
                    <?php
				}
				?>
                  </select>
				  </td>
				  </tr>   
				    <tr>
				 <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Sub Type</div></td>
				  <td align="left" valign="middle"  bgcolor="#FFFFFF">
				  <select name="subtype" id="subtype" onChange="return funcSubTypeChange1()" style="border: 1px solid #001E6A;">
                    <option value="" selected="selected">Select Sub Type</option>
<!--					
					<?php
				if ($subtype == '')
				{
					echo '<option value="" selected="selected">Select Subtype</option>';
				}
				else
				{
					$query51 = "select * from master_subtype where recordstatus = ''";
					$exec51 = mysql_query($query51) or die ("Error in Query51".mysql_error());
					$res51 = mysql_fetch_array($exec51);
					$res51subtype = $res51["subtype"];
					echo '<option value="'.$res51subtype.'" selected="selected">'.$res51subtype.'</option>';
				}
				
				$query5 = "select * from master_subtype where recordstatus = '' order by subtype";
				$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
				while ($res5 = mysql_fetch_array($exec5))
				{
				$res5anum = $res5["auto_number"];
				$res5paymenttype = $res5["subtype"];
				?>
                    <option value="<?php echo $res5paymenttype; ?>"><?php echo $res5paymenttype; ?></option>
                    <?php
				}
				?>
-->				  
                  </select>				  </td>
				  </tr>    
			     <tr>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">
                          <div align="right">Add New Consultation Type </div>
                        </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="consultationtype" id="consultationtype" style="border: 1px solid #001E6A;text-transform: uppercase;" size="40" />                                      </td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Consultation Fees </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
                          <input name="consultationfees" type="text" id="consultationfees" style="border: 1px solid #001E6A;" size="10">                     </td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Default </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
                          <input name="default" type="checkbox" id="default" >  </td>
                      </tr>
                      <tr>
                        <td width="36%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td width="54%" align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="hidden" name="frmflag" value="addnew" />
                            <input type="hidden" name="frmflag1" value="frmflag1" />
                          <input type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A" /></td>
                      </tr>
                      <tr>
                        <td align="middle" colspan="2" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                <table width="800" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      
                      <tr bgcolor="#011E6A">
                      <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Location</strong></td>
                        <td bgcolor="#CCCCCC" class="bodytext3"><strong>Consultation Type Master</strong></td>
                        <td bgcolor="#CCCCCC" class="bodytext3"><strong>Department</strong> </td>                       
                       <!-- <td bgcolor="#CCCCCC" class="bodytext3"><strong>Main <strong>Type</strong></strong>-->
                        <td bgcolor="#CCCCCC" class="bodytext3"><strong>Sub Type</strong></td>
                       <td bgcolor="#CCCCCC" class="bodytext3"><strong>Consultation Fees</strong>
                        <td bgcolor="#CCCCCC" class="bodytext3"><strong>Edit</strong>
                        </tr>
        <?php
	    $query1 = "select * from master_consultationtype where recordstatus <> 'deleted' order by paymenttype ";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		while ($res1 = mysql_fetch_array($exec1))
		{
		$auto_number = $res1["auto_number"];
		$consultationtype = $res1["consultationtype"];
		$departmentanum = $res1["department"];
		$consultationfees = $res1["consultationfees"];
		//$res1paymenttype = $res1["paymenttype"];
		$res1subtype = $res1['subtype'];
		$res1location = $res1['locationname'];
		
		$query = "select * from master_location where auto_number='$res1location'";
		$exec = mysql_query($query) or die ("Error in Query2".mysql_error());
		$res = mysql_fetch_array($exec);
		$loc=$res['locationname'];
		
		$query2 = "select * from master_department where auto_number = '$departmentanum'";
		$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		$res2 = mysql_fetch_array($exec2);
		$department = $res2['department'];
		
		/*$query3 = "select * from master_paymenttype where auto_number = '$res1paymenttype'";
		$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
		$res3 = mysql_fetch_array($exec3);
		$res3paymenttype = $res3['paymenttype'];
		*/
		$query4 = "select * from master_subtype where auto_number = '$res1subtype'";
		$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		$res4 = mysql_fetch_array($exec4);
		$res4subtype = $res4['subtype'];
	
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
                        <td width="2%" align="left" valign="top"  class="bodytext3"><div align="center">
					<a href="addconsultationtype1.php?st=del&&anum=<?php echo $auto_number; ?>" onClick="return funcDeleteconsultationtype1('<?php echo $consultationtype;?>')">
					<img src="images/b_drop.png" width="8" height="11" border="0" /></a></div></td>
          <td width="22%" align="left" valign="top"  class="bodytext3"><?php echo $loc; ?></td>          
          <td width="22%" align="left" valign="top"  class="bodytext3"><?php echo $consultationtype; ?></td>
          <td width="17%" align="left" valign="top"  class="bodytext3"><?php echo $department; ?></td>
          <!--<td width="16%" align="left" valign="top"  class="bodytext3"><?php echo $res3paymenttype; ?></td>-->
		  <td width="15%" align="left" valign="top"  class="bodytext3"><?php echo $res4subtype; ?></td>
		  <td width="20%" align="left" valign="top"  class="bodytext3"><?php echo $consultationfees; ?></td>
          <td width="8%" align="left" valign="top"  class="bodytext3">
		  <a href="editconsultationtype1.php?st=edit&&anum=<?php echo $auto_number; ?>" style="text-decoration:none">Edit</a>		  </td> 
                        </tr>
                      <?php
		}
		?>
                      <tr>
                        <td align="middle" colspan="5" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <?php
		
	    $query1 = "select * from master_consultationtype where recordstatus = 'deleted' order by consultationtype ";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		while ($res1 = mysql_fetch_array($exec1))
		{
		$auto_number = $res1["auto_number"];
		$consultationtype = $res1["consultationtype"];
		$departmentanum = $res1["department"];
		$consultationfees = $res1["consultationfees"];
		
		$query2 = "select * from master_department where auto_number = '$departmentanum'";
		$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		$res2 = mysql_fetch_array($exec2);
		$department = $res2['department'];
		
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
                        <td colspan="4" align="left" valign="top" bgcolor="#CCCCCC"  class="bodytext3"><strong>Consultation Type Master - Deleted </strong></td>
                        </tr>
                      <tr <?php echo $colorcode; ?>>
          <td width="11%" align="left" valign="top"  class="bodytext3">
						<a href="addconsultationtype1.php?st=activate&&anum=<?php echo $auto_number; ?>" class="bodytext3">
                          <div align="center" class="bodytext3">Activate</div>
                        </a></td>
                        <td width="34%" align="left" valign="top"  class="bodytext3"><?php echo $consultationtype; ?></td>
						<td width="31%" align="left" valign="top"  class="bodytext3"><?php echo $department; ?></td>
                        <td width="24%" align="left" valign="top"  class="bodytext3"><?php echo $consultationfees; ?></td> 
                        </tr>
                      <?php
		}
		?>
                      <tr>
                        <td align="middle" colspan="2" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
              </form>
                </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
