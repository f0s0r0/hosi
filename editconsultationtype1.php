<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
 $username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
 $companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
    $accountnameanum = $_REQUEST['accountnameanum'];
	$consultationtype = $_REQUEST["consultationtype"];
	$department = $_REQUEST["department"];
	$consultationfees = $_REQUEST["consultationfees"];
	$paymenttype = $_REQUEST['paymenttype'];
	$subtype = $_REQUEST['subtype'];
	$consultationtype = strtoupper($consultationtype);
	$consultationtype = trim($consultationtype);
	$length=strlen($consultationtype);
	$recordstatus = $_REQUEST["recordstatus"];
	$ipaddress = $_REQUEST["ipaddress"];
	$recorddate = $_REQUEST["recorddate"];
	$location1=$_REQUEST["location"];
	
	$default = isset($_REQUEST['default'])?$_REQUEST['default']:'';
	//echo $length;
	
	if ($length<=100)
	{
	$query2 = "select * from master_consultationtype where auto_number = '$accountnameanum'";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	$res2 = mysql_num_rows($exec2);
	if ($res2 != 0)
	{
        $query1 = "update master_consultationtype set consultationtype = '$consultationtype',department = '$department',consultationfees = '$consultationfees',recordstatus = '$recordstatus',
		ipaddress = '$ipaddress',recorddate = '$recorddate', username = '$username', paymenttype = '$paymenttype', subtype = '$subtype',locationname='$location1',condefault='".$default."' where auto_number = '$accountnameanum'";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$errmsg = "Success. New Consultation Type Updated.";
		//$bgcolorcode = 'success';
		header ("location:addconsultationtype1.php");
		exit;
	}
	//exit();
	else
	{
		$errmsg = "Failed. Consultation Type Already Exists.";
		//$bgcolorcode = 'failed';
		header ("location:editconsultationtype1.php?bgcolorcode=failed&&st=edit&&anum=$accountnameanum");
		exit;
	}
	}
	else
	{
		$errmsg = "Failed. Only 100 Characters Are Allowed.";
		//$bgcolorcode = 'failed';
		header ("location:editconsultationtype1.php?bgcolorcode=failed&&st=edit&&anum=$accountnameanum");
		exit;
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

if (isset($_REQUEST["anum"])) { $anum = $_REQUEST["anum"]; } else { $anum = ""; }
if ($st == 'edit' && $anum != '')
{
    $query1 = "select * from master_consultationtype where auto_number = '$anum'";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	$res1 = mysql_fetch_array($exec1);
	$res1autonumber = $res1['auto_number'];
	$res1department = $res1['department'];
	$res1consultationtype = $res1['consultationtype'];
	$res1consultationfees = $res1['consultationfees'];
	$res1recordstatus = $res1['recordstatus'];
	$res1recorddate = $res1['recorddate'];
	$paymenttype = $res1['paymenttype'];
	$subtype = $res1['subtype'];
	$res1location = $res1['locationname'];
	
	$condefault = $res1['condefault'];
	
}

if (isset($_REQUEST["bgcolorcode"])) { $bgcolorcode = $_REQUEST["bgcolorcode"]; } else { $bgcolorcode = ""; }
if ($bgcolorcode == 'success')
{
	$errmsg = "Success. New Consultation Type Updated.";
}
if ($bgcolorcode == 'failed')
{
	$errmsg = "Failed. Consultation Type Already Exists.";
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
		alert ("Please Enter Consultation Fees.");
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
              <td><form name="form1" id="form1" method="post" action="editconsultationtype1.php" onSubmit="return addward1process1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Consultation Type Master - Add New </strong></td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                      <tr>
                        <td align="right" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"> Location
                          <div align="right"></div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="location" id="location" style="border: 1px solid #001E6A;">
                          <?php
				if ($res1location == '')
				{
					echo '<option value="" selected="selected">Select location</option>';
				}
				else
				{
					$query41 = "select * from master_location where auto_number = '$res1location'";
					$exec41 = mysql_query($query41) or die ("Error in Query4".mysql_error());
					$res41 = mysql_fetch_array($exec41);
					$res41locationanum = $res41['auto_number'];
					$res41location = $res41['locationname'];
					
					echo '<option value="'.$res41locationanum.'" selected="selected">'.$res41location.'</option>';
				}
				
				$query51 = "select * from master_location where status = '' order by locationname";
				$exec51 = mysql_query($query51) or die ("Error in Query5".mysql_error());
				while ($res51 = mysql_fetch_array($exec51))
				{
				echo $res51anum = $res51["auto_number"];
				echo $res51location = $res51["locationname"];
				?>
                          <option value="<?php echo $res51anum; ?>"><?php echo $res51location; ?></option>
                          <?php
				}
				?>
                        </select></td>
                      </tr>
					  
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Department</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="department" id="department" style="border: 1px solid #001E6A;">
                          <?php
				if ($res1department == '')
				{
					echo '<option value="" selected="selected">Select department</option>';
				}
				else
				{
					$query4 = "select * from master_department where auto_number = '$res1department'";
					$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
					$res4 = mysql_fetch_array($exec4);
					$res4departmentanum = $res4['auto_number'];
					$res4departmentname = $res4['department'];
					
					echo '<option value="'.$res4departmentanum.'" selected="selected">'.$res4departmentname.'</option>';
				}
				
				$query5 = "select * from master_department where recordstatus = '' order by department";
				$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
				while ($res5 = mysql_fetch_array($exec5))
				{
				echo $res5anum = $res5["auto_number"];
				echo $res5department = $res5["department"];
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
                    
				  <?php
				  
				  	if ($paymenttype == '')
				{
					echo '<option value="" selected="selected">Select Type</option>';
				}
				else
				{
					$query511 = "select * from master_paymenttype where auto_number = '$paymenttype' and recordstatus = ''";
					$exec511 = mysql_query($query511) or die ("Error in Query51".mysql_error());
					$res511 = mysql_fetch_array($exec511);
					$res511paymenttype = $res511["paymenttype"];
					echo '<option value="'.$res511paymenttype.'" selected="selected">'.$res511paymenttype.'</option>';
				}
				
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
                  
				
					<?php
				if ($subtype == '')
				{
					echo '<option value="" selected="selected">Select Subtype</option>';
				}
				else
				{
					$query51 = "select * from master_subtype where auto_number = '$subtype' and recordstatus = ''";
					$exec51 = mysql_query($query51) or die ("Error in Query51".mysql_error());
					$res51 = mysql_fetch_array($exec51);
					$res51subtype = $res51["subtype"];
					
					echo '<option value="'.$res51subtype.'" selected="selected">'.$res51subtype.'</option>';
				}
				
				?>
			  
                  </select>				  </td>
				  </tr>  
				  
                      <tr>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">
                          <div align="right">Add New Consultation Type </div>
                        </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF"><input name="consultationtype" id="consultationtype" value="<?php echo $res1consultationtype ?>" style="border: 1px solid #001E6A;text-transform: uppercase;" size="40" />                                      </td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Consultation Fees </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
                          <input name="consultationfees" type="text" id="consultationfees" style="border: 1px solid #001E6A;" value="<?php echo $res1consultationfees?>" size="10">                     </td>
                      </tr>
                       <tr>
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Default </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
                          <input name="default" type="checkbox" id="default" <?php if($condefault=='on'){echo "checked";}?> >  </td>
                      </tr>
                      <tr>
                        <td width="42%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td width="58%" align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="hidden" name="frmflag" value="addnew" />
                            <input type="hidden" name="frmflag1" value="frmflag1" />
							<input type="hidden" name="accountnameanum" id="accountnameanum" value="<?php echo $res1autonumber ?>">
                          <input type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A" /></td>
                      </tr>
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

