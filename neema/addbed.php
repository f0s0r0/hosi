<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$date = date('Y-m-d');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$licensedbed='100';
if (isset($_REQUEST["bedtemplate"])) {  $bedtemplate = $_REQUEST["bedtemplate"]; $_SESSION['bedtablename']=$bedtemplate; } else { $bedtemplate = ''; }
if (!isset($_SESSION['bedtablename'])){$_SESSION['bedtablename']='master_bedcharge';}
if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
	$bed = $_REQUEST["bed"];
	$bedcharge=$_REQUEST['bedtemp'];
	
	$query23 = "select auto_number from master_bed order by auto_number desc";
	$exec23 = mysql_query($query23) or die(mysql_error());
	$res23 = mysql_fetch_array($exec23);
	$bedanum = $res23['auto_number'];
	 $bedanum1 = $bedanum + 1;
	
	//$bed = strtoupper($bed);
	$bed = trim($bed);
	$length=strlen($bed);
	$ward = $_REQUEST["ward"];
	$threshold = $_REQUEST['threshold'];
	
	$selectedlocationcode=$_REQUEST["location"];
	
	$query31 = "select * from master_location where locationcode = '$selectedlocationcode' and status = '' " ;
	$exec31 = mysql_query($query31) or die ("Error in Query31".mysql_error());
	$res31 =(mysql_fetch_array($exec31));
	$selectedlocation = $res31["locationname"];
	
/*	$query32 = "select * from master_ward where auto_number = '$ward1' and recordstatus = '' " ;
	$exec32 = mysql_query($query32) or die ("Error in Query31".mysql_error());
	$res32 =(mysql_fetch_array($exec32));
	$ward = $res32["ward"];
*/	
	$accommodationcharges = $_REQUEST['accommodationcharges'];
	$cafetariacharges = $_REQUEST['cafetariacharges'];
	
	
	$bedcharges = $_REQUEST['bedcharges'];
	$nursingcharges = $_REQUEST['nursingcharges'];
	$rmocharges = $_REQUEST['rmocharges'];
	//echo $length;
	if ($length<=100)
	{
		$query2 = "select * from master_bed where bed = '$bed' and ward = '$ward'";
		$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		$res2 = mysql_num_rows($exec2);
		if ($res2 == 0)
		{
			$query1 = "insert into master_bed (bed, ward, ipaddress, recorddate,locationname,locationcode,username,threshold,bedcharges,nursingcharges,rmocharges,accommodationcharges,cafetariacharges) 
			values ('$bed','$ward', '$ipaddress', '$updatedatetime','$selectedlocation','$selectedlocationcode', '$username','$threshold','$bedcharges','$nursingcharges','$rmocharges','$accommodationcharges','$cafetariacharges')";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			$errmsg = "Success. New bed Updated.";
			$bgcolorcode = 'success';
			
			for($i=1;$i<6;$i++)	
				{
				if($i == 1)
				{
				$charge="Bed Charges";
				$rate = $bedcharges;
				
					}
				if($i == 2)
				{
				$charge="Nursing Charges";
				$rate = $nursingcharges;
				}
				if($i == 3)
				{
				$charge="RMO Charges";
				$rate = $rmocharges;
			
				}
				if($i == 4)
				{
				$charge="Accommodation Charges";
				$rate = $accommodationcharges;
			
				}
				if($i == 5)
				{
				$charge="Cafetaria Charges";
				$rate = $cafetariacharges;
			
				}
				
				if($rate == '')
				{
				$rate = 0.00;
				}
		
			$chargequery1="insert into master_bedcharge(bed,bedanum,charge,rate,ipaddress,recorddate,locationname,locationcode,username)values('$bed','$bedanum1','$charge','$rate','$ipaddress','$date','$selectedlocation','$selectedlocationcode','$username')";
			$chargeexecquery1=mysql_query($chargequery1) or die(mysql_error());
			}
			
		}
		//exit();
		else
		{
			$errmsg = "Failed. bed Already Exists.";
			$bgcolorcode = 'failed';
		}
		$query10 = "select * from master_testtemplate where testname = 'bedcharge' and referencetable!='' order by templatename";
		$exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());
		while($res10 = mysql_fetch_array($exec10))
		{
			$bedchargetemplate = $res10["templatename"];
			$bedtemplate = $res10["referencetable"];
			
			$query2 = "select * from $bedtemplate where bed = '$bed' and ward = '$ward'";
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			$res2 = mysql_num_rows($exec2);
			if ($res2 == 0)
			{
				$query1 = "insert into $bedtemplate (bed, ward, ipaddress, recorddate,locationname,locationcode,username,threshold,bedcharges,nursingcharges,rmocharges,accommodationcharges,cafetariacharges) 
				values ('$bed','$ward', '$ipaddress', '$updatedatetime','$selectedlocation','$selectedlocationcode', '$username','$threshold','$bedcharges','$nursingcharges','$rmocharges','$accommodationcharges','$cafetariacharges')";
				$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
				$errmsg = "Success. New bed Updated.";
				$bgcolorcode = 'success';
				
				for($i=1;$i<6;$i++)	
					{
					if($i == 1)
					{
					$charge="Bed Charges";
					$rate = $bedcharges;
					
						}
					if($i == 2)
					{
					$charge="Nursing Charges";
					$rate = $nursingcharges;
					}
					if($i == 3)
					{
					$charge="RMO Charges";
					$rate = $rmocharges;
				
					}
					if($i == 4)
					{
					$charge="Accommodation Charges";
					$rate = $accommodationcharges;
				
					}
					if($i == 5)
					{
					$charge="Cafetaria Charges";
					$rate = $cafetariacharges;
				
					}
					
					if($rate == '')
					{
					$rate = 0.00;
					}
			
				$chargequery1="insert into $bedchargetemplate(bed,bedanum,charge,rate,ipaddress,recorddate,locationname,locationcode,username)values('$bed','$bedanum1','$charge','$rate','$ipaddress','$date','$selectedlocation','$selectedlocationcode','$username')";
				$chargeexecquery1=mysql_query($chargequery1) or die(mysql_error());
				}
				
			}
			//exit();
			else
			{
				$errmsg = "Failed. bed Already Exists.";
				$bgcolorcode = 'failed';
			}
		}
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
	$query3 = "update master_bed set recordstatus = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
}
if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_bed set recordstatus = '' where auto_number = '$delanum'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
}
if ($st == 'default')
{
	$delanum = $_REQUEST["anum"];
	$query4 = "update master_bed set defaultstatus = '' where cstid='$custid' and cstname='$custname'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());

	$query5 = "update master_bed set defaultstatus = 'DEFAULT' where auto_number = '$delanum'";
	$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
}
if ($st == 'removedefault')
{
	$delanum = $_REQUEST["anum"];
	$query6 = "update master_bed set defaultstatus = '' where auto_number = '$delanum'";
	$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
}


if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add bed To Proceed For Billing.";
	$bgcolorcode = 'failed';
}
$query1bed = "select * from master_bed where recordstatus <> 'deleted' order by bed ";
$exec1bed = mysql_query($query1bed) or die ("Error in Query1bed".mysql_error());
$nums1bed = mysql_num_rows($exec1bed);
$remainbed = $licensedbed - $nums1bed;
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
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>

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

function funcSubTypeChange1()
{
	<?php 
	$query12 = "select * from master_location";
	$exec12 = mysql_query($query12) or die ("Error in Query11".mysql_error());
	while ($res12 = mysql_fetch_array($exec12))
	{
	 $res12subtypeanum = $res12["auto_number"];
	$res12locationname = $res12["locationname"];
	$res12locationcode = $res12["locationcode"];
	?>
	if(document.getElementById("location").value=="<?php echo $res12locationcode; ?>")
	{
		
		document.getElementById("ward").options.length=null; 
		var combo = document.getElementById('ward'); 	
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Ward", ""); 
		<?php
		$query10 = "select * from master_ward where locationname = '$res12locationname' and recordstatus = '' order by ward";
		$exec10 = mysql_query($query10) or die ("error in query10".mysql_error());
		while ($res10 = mysql_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10accountnameanum = $res10["auto_number"];
		$ward = $res10["ward"];
		?>
			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $ward;?>", "<?php echo $res10accountnameanum;?>"); 
		<?php 
		}
		?>
	}
	<?php
	}
	?>	
}


function addbedprocess1()
{
	//alert ("Inside Funtion");
	if (document.form1.remainbed.value == "0")
	{
		alert (" LICENSE BEDS ARE COMPLETE.");
		return false;
	}
	if(document.form1.location.value=="")
	{
		alert("Location Cannot Be Empty");
		document.form1.location.focus();
		return false;
	}
	
	if (document.form1.bed.value == "")
	{
		alert ("Please Enter bed Name.");
		document.form1.bed.focus();
		return false;
	}
	if (document.form1.ward.value == "")
	{
		alert ("Please Select ward.");
		document.form1.ward.focus();
		return false;
	}
	
	
	if (document.form1.accommodationcharges.value == "")
	{
		alert ("Please Enter Accommodation Charge.");
		document.form1.accommodationcharges.focus();
		return false;
	}
	
	
	if (document.form1.cafetariacharges.value == "")
	{
		alert ("Please Enter Cafetaria Charge.");
		document.form1.cafetariacharges.focus();
		return false;
	}
	
}
function btnDeleteClick9(delID5)
{
	//alert ("Inside btnDeleteClick.");
	var newtotal2;
	//alert(radrate);
	var varDeleteID2= delID5;
	//alert (varDeleteID2);
	var fRet5; 
	fRet5 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet5 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child2= document.getElementById('idTR'+varDeleteID2);  //tr name
    var parent2 = document.getElementById('insertrow2'); // tbody name.
	document.getElementById ('insertrow2').removeChild(child2);
	
	var child2 = document.getElementById('idTRaddtxt'+varDeleteID2);  //tr name
    var parent2 = document.getElementById('insertrow2'); // tbody name.
	//alert (child);
	if (child2 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow2').removeChild(child2);
	}
}

function funcDeletebed(varbedAutoNumber)
{
     var varbedAutoNumber = varbedAutoNumber;
	 var fRet;
	fRet = confirm('Are you sure want to delete this bed Type '+varbedAutoNumber+'?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("bed Entry Delete Completed.");
		//return false;
	}
	if (fRet == false)
	{
		alert ("bed Entry Delete Not Completed.");
		return false;
	}

}

function funcactivatebed()
{
	if (document.form1.remainbed.value == "0")
	{
		alert (" LICENSE BEDS ARE COMPLETE.");
		return false;
	}
}


function keypressdigit(evt)
{
	 var charCode = (evt.which) ? evt.which : event.keyCode;
	      if (charCode > 31 && charCode != 46 && (charCode < 48 || charCode > 57))
            return false;
		else		
			return true;
}

function charges()
{
			var var1=0;
			var var2=0;
		
			if((document.getElementById('accommodationcharges').value).trim()!="")
			 var1=parseFloat(document.getElementById('accommodationcharges').value);
			if((document.getElementById('cafetariacharges').value).trim()!="")
			 var2=parseFloat(document.getElementById('cafetariacharges').value);
			document.getElementById('bedcharges').value=(var1+var2).toFixed(2);
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
              <td><form name="form1" id="form1" method="post" action="addbed.php" onSubmit="return addbedprocess1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="" bgcolor="#CCCCCC"  class="bodytext3"><strong>Bed Master - Add New  &nbsp;
						Licensed Beds:<?php echo $licensedbed; ?>&nbsp;<span style="margin-left:10px">Remaining Beds:<?php echo $remainbed; ?></span></strong>
						<input type="hidden" name="licensedbed" id="licensedbed" value="<?php echo $licensedbed; ?>">
						<input type="hidden" name="remainbed" id="remainbed" value="<?php echo $remainbed; ?>">
						</td>
                        
                        <td  align="right" bgcolor="#CCCCCC" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
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
                <td width="58%" align="right" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><span class="bodytext32">Location   *</span></td>
                <td width="42%" align="left" valign="middle"  bgcolor="#FFFFFF">
                <select name="location" id="location" onChange=" funcSubTypeChange1(); ajaxlocationfunction(this.value);"  style="border: 1px solid #001E6A;">
                						<option value="">Select</option>
                  <?php
						$query1 = "select * from master_location where status <> 'deleted' order by locationname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						while ($res1 = mysql_fetch_array($exec1))
						{
						$res1location = $res1["locationname"];
						$res1locationanum = $res1["locationcode"];
						?>
						<option value="<?php echo $res1locationanum; ?>"><?php echo $res1location; ?></option>
						<?php
						}
						?>
                </select>
                </td>
				</tr>
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
						<div align="right">Select Ward </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="ward" id="ward">
                          <option value=""> Select Ward</option>
						  <?php
						if ($wardanum != '')
						{
						?>
                    <option value="<?php echo $wardanum; ?>" selected="selected"><?php echo $wardfullname; ?></option>
                    <?php
						}
						else
						{
						?>
                    <option value="" selected="selected">Select Ward</option>
                    <?php
						}
						$query1 = "select * from master_ward where recordstatus <> 'deleted'";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						while ($res1 = mysql_fetch_array($exec1))
						{
						$res1ward = $res1["ward"];
						$res1anum = $res1['auto_number'];
						
						?>
                    <option value="<?php echo $res1anum; ?>"><?php echo $res1ward; ?></option>
                    <?php
						}
						?>
           
                        </select></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Add New Bed </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="bed" id="bed" style="border: 1px solid #001E6A; text-transform:uppercase;" size="40" />
						<input type="hidden" name="bedanum" id="bedanum" value="<?php echo $anum; ?>"></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Accommodation Charges *</div></td>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
						<input name="accommodationcharges" id="accommodationcharges" style="border: 1px solid #001E6A;" size="10" onKeyPress="return keypressdigit(event)" onKeyUp="charges()" /></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Cafetaria Charges *</div></td>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
						<input name="cafetariacharges" id="cafetariacharges" style="border: 1px solid #001E6A;" onKeyPress="return keypressdigit(event)" onKeyUp="charges()" size="10" /></td>
                      </tr>                      
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Bed Charges</div></td>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
						<input name="bedcharges" id="bedcharges" readonly style="border: 1px solid #001E6A;" size="10" value="0" /></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Nursing Charges</div></td>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
						<input name="nursingcharges" id="nursingcharges" style="border: 1px solid #001E6A;" size="10" /></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">RMO Charges</div></td>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
						<input name="rmocharges" id="rmocharges" style="border: 1px solid #001E6A;" size="10" /></td>
                      </tr>
					  
			    <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Threshold</div></td>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
						<input name="threshold" id="threshold" style="border: 1px solid #001E6A;" size="10" />in %</td>
                      </tr>
                    <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Bed Template</div></td>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
                        <select name="bedtemp" id="bedtemp"  style="border: 1px solid #001E6A;">
					
						<option value="" selected="selected">Select Bedcharge</option>
						
						<option value="master_bed" >Master Bed</option>						
						<?php
							$query10 = "select * from master_testtemplate where testname = 'bedcharge' order by templatename";
							$exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());
							while ($res10 = mysql_fetch_array($exec10))
							{							
								$templatename = $res10["templatename"];
								if($templatename != $bedtemplate)
								{
								?>
								<option value="<?php echo $templatename; ?>"><?php echo $templatename; ?></option>
								<?php
								}
							}
						?>
                        </select></td>
               </tr>
				<!-- <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Grace </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="grace" id="grace" style="border: 1px solid #001E6A;" size="10" /></td>
                      </tr>
                -->      <tr>
                        <td width="58%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td width="42%" align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="hidden" name="frmflag" value="addnew" />
                            <input type="hidden" name="frmflag1" value="frmflag1" />
                          <input type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A" /></td>
                      </tr>
                      <tr>
                        <td align="middle" colspan="2" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                   </form>
                <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                       <form action="addbed.php" method="post" name="bedsearch" id="bedsearch">
                      <tr bgcolor="#011E6A">
                        
						  <td colspan="13" bgcolor="#FFFFFF" class="bodytext3">
						<select name="bedtemplate" id="bedtemplate"  style="border: 1px solid #001E6A;">
						<?php
						if($bedtemplate!='')
						{?>
						<option value="<?php echo $bedtemplate; ?>"><?php echo $bedtemplate; ?></option>
						<?php } else
						{?>
						<option value="" selected="selected">Select Bedcharge</option>
						<?php }
						if($bedtemplate != 'master_bedcharge'){
						?>
						<option value="master_bedcharge" >Master Bedcharge</option>						
						<?php
						}
							$query10 = "select * from master_testtemplate where testname = 'bedcharge' and referencetable!='' order by templatename";
							$exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());
							while ($res10 = mysql_fetch_array($exec10))
							{							
								$templatename = $res10["referencetable"];
								if($templatename != $bedtemplate)
								{
								?>
								<option value="<?php echo $templatename; ?>"><?php echo $templatename; ?></option>
								<?php
								}
							}
						?>
                        </select>
                          <input type="submit" id="Submit2" name="Submit2" value="Search" style="border: 1px solid #001E6A" /></td>
                        </tr>
                      </form>    
                      <?php
					  if(isset($_POST['Submit2']) == 'Search')
					  {
						 $bedtemp=  $_REQUEST['bedtemplate'];
					  ?>  
                      <tr bgcolor="#011E6A">
                        <td colspan="3" bgcolor="#CCCCCC" class="bodytext3"><strong>bed Bed - Existing List </strong></td>
                        <td width="26%" bgcolor="#CCCCCC" class="bodytext3"><strong>ward</strong></td>
                        <td width="26%" bgcolor="#CCCCCC" class="bodytext3"><strong>Location</strong></td>
                        <td width="9%" bgcolor="#CCCCCC" class="bodytext3"><strong>Edit</strong></td>
                      </tr>
                      <?php
	    $query1 = "select * from master_bed where recordstatus <> 'deleted' order by locationname ";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		while ($res1 = mysql_fetch_array($exec1))
		{
		$bed = $res1["bed"];
		$ward = $res1['ward'];
		$res1locationname = $res1['locationname'];
		$auto_number = $res1["auto_number"];
		
		$query55 = "select * from master_ward where auto_number='$ward'";
						  $exec55 = mysql_query($query55) or die(mysql_error());
						  $res55 = mysql_fetch_array($exec55);
						  $wardfullname = $res55['ward'];
			
		//$defaultstatus = $res1["defaultstatus"];

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
						<td width="6%" align="left" valign="top"  class="bodytext3"><?php echo $colorloopcount; ?></td>
                        <td width="6%" align="left" valign="top"  class="bodytext3">
						<div align="center">
						<a href="addbed.php?st=del&&anum=<?php echo $auto_number; ?>&&bedtemp=<?= $bedtemp ?>" onClick="return funcDeletebed('<?php echo $bed ?>')">
						<img src="images/b_drop.png" width="16" height="16" border="0" /></a>						</div>						</td>
                        <td width="39%" align="left" valign="top"  class="bodytext3"><?php echo $bed; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $wardfullname; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $res1locationname; ?> </td>
                        <td align="left" valign="top"  class="bodytext3">
						<a href="editbed.php?st=edit&&anum=<?php echo $auto_number; ?>&&bedtemp=<?= $bedtemp ?>" style="text-decoration:none">Edit</a></td>
        </tr>
                      <?php
		}
		?>
           <tr>
                        <td align="middle" colspan="4" >&nbsp;</td>
                      </tr>
                    </tbody>
  </table>
  
                <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="5" bgcolor="#CCCCCC" class="bodytext3"><strong>Bed Master - Deleted </strong></td>
                      </tr>
                      <?php
		$colorloopcount = '';
	    $query1 = "select * from master_bed where recordstatus = 'deleted' order by bed ";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		while ($res1 = mysql_fetch_array($exec1))
		{
		$bed = $res1['bed'];
		$ward = $res1['ward'];
		$res1locationname = $res1['locationname'];
		$auto_number = $res1["auto_number"];
		
		$query55 = "select * from master_ward where auto_number='$ward'";
						  $exec55 = mysql_query($query55) or die(mysql_error());
						  $res55 = mysql_fetch_array($exec55);
						  $wardfullname = $res55['ward'];
		

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
                        <td width="5%" align="left" valign="top"  class="bodytext3"><?php echo $colorloopcount; ?></td>
						<td width="10%" align="left" valign="top"  class="bodytext3">
						<a href="addbed.php?st=activate&&anum=<?php echo $auto_number; ?>" class="bodytext3" onClick="return funcactivatebed()">
                          <div align="center" class="bodytext3">Activate</div>
                        </a></td>
                        <td width="35%" align="left" valign="top"  class="bodytext3"><?php echo $bed; ?></td>
                        <td width="25%" align="left" valign="top"  class="bodytext3"><?php echo $wardfullname; ?></td>
                        <td width="25%" align="left" valign="top"  class="bodytext3"><?php echo $res1locationname; ?></td>
        </tr>
                      <?php
		}
					  }
		?>
                      <tr>
                        <td align="middle" colspan="3" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
            
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

