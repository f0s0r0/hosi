<?php
session_start();
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$pagename ='';
$colorloopcount = "";

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
	
	$packagename = $_REQUEST["packagename"];
	//$packagename = strtoupper($packagename);
	$packagename = trim($packagename);
	$packagename = addslashes($packagename);
	$selectedlocationcode=$_REQUEST["location"];
	$days=$_REQUEST["days"];
	$bedcharges=$_REQUEST["bedcharges"];
	$threshold = $_REQUEST["threshold"];
	$lab  = $_REQUEST["lab"];
	$rate  = $_REQUEST["rate"];
	$rate3 = $_REQUEST['rate3'];
	
	$radiology = $_REQUEST["radiology"];
	
	$doctor = $_REQUEST["doctor"];
	
	$admin = $_REQUEST["admin"];
	
	$service  = $_REQUEST["service"];
	
	$pharmacy  = $_REQUEST["pharmacy"];
	$panaestetist  = $_REQUEST["panaestetist"];
	$ppeaditrician  = $_REQUEST["ppeaditrician"];
	$pgynaecologyst  = $_REQUEST["pgynaecologyst"];
	$ranaestetist  = $_REQUEST["ranaestetist"];
	$rpeaditrician  = $_REQUEST["rpeaditrician"];
	$rgynaecologyst  = $_REQUEST["rgynaecologyst"];
	
	$total = $_REQUEST['total'];
	
	 $query31 = "select * from master_location where locationcode = '$selectedlocationcode' and status = '' " ;
	$exec31 = mysql_query($query31) or die ("Error in Query31".mysql_error());
	$res31 =(mysql_fetch_array($exec31));
	 $selectedlocation = $res31["locationname"];
	
		
	$query2 = "select * from master_ippackage where packagename = '$packagename'";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	$res2 = mysql_num_rows($exec2);
	if ($res2 == 0)
	{
		$query1 = "insert into master_ippackage (locationname,locationcode,packagename,days,bedcharges,threshold,surgeon,rate,radiology,doctor,service, admin,total,ipaddress,username,rate3,`pharmacy`, `private_anaestetist`, `private_peaditrician`, `private_gynaecologyst`, `resident_anaestetist`, `resident_peaditrician`, `resident_gynaecologyst`) 
		values('$selectedlocation','$selectedlocationcode','$packagename','$days','$bedcharges','$threshold','$lab','$rate','$radiology','$doctor','$service','$admin','$total','$ipaddress','$username','$rate3','".$pharmacy."','".$panaestetist."','".$ppeaditrician."','".$pgynaecologyst."','".$ranaestetist."','".$rpeaditrician."','".$rgynaecologyst."')";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		
			
		$companyname = '';
		$title1  = '';
		$title2  = '';
		$contactperson1  = '';
		$contactperson2 = '';
		$designation1 = '';
		$designation2  = '';
		$phonenumber1 = '';
		$doctor = '';
		$emailid1  = '';
		$admin = '';
		$faxnumber1 = '';
		$faxnumber2  = '';
		$address = '';
		$location = '';
		$lab  = '';
		$state = '';
		$pincode = '';
		$radiology = '';
		$tinnumber = '';
		$cstnumber = '';
		$companystatus  = '';
		$openingbalance = '0.00';
		$remarks = "";
		$dateposted = $updatedatetime;
		
		$pharmacy  = '';
		$panaestetist  = '';
		$ppeaditrician  = '';
		$pgynaecologyst  = '';
		$ranaestetist  = '';
		$rpeaditrician  = '';
		$rgynaecologyst  = '';
		header("location:addippackage.php?st=success");
		//header ("location:addcompany1.php?st=success&&cpynum=1");
	}
	else
	{
		//header ("location:addippackage.php?st=failed");
	}

}
else
{
	$companyname = "";
	//$companyname = strtoupper($companyname);
	$title1  = "";
	$title2  = "";
	$contactperson1  = "";
	$contactperson2 = "";
	$designation1 = "";
	$designation2  = "";
	$phonenumber1 = "";
	$doctor = "";
	$emailid1  = "";
	$admin = "";
	$faxnumber1 = "";
	$faxnumber2  = "";
	$days = "";
	$bedcharges = "";
	$location = "";
	$lab  = "";
	$pincode = "";
	$radiology = "";
	$state = "";
	$tinnumber = "";
	$cstnumber = "";
	$companystatus  = "";
	$openingbalance = "";
	$remarks = "";
	
	
		$pharmacy  = '';
		$panaestetist  = '';
		$ppeaditrician  = '';
		$pgynaecologyst  = '';
		$ranaestetist  = '';
		$rpeaditrician  = '';
		$rgynaecologyst  = '';
	$dateposted = $updatedatetime;
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_ippackage set status = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
}

if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query13 = "update master_ippackage set status = '' where auto_number = '$delanum'";
	$exec13 = mysql_query($query13) or die ("Error in Query13".mysql_error());
}

if ($st == 'success')
{
		$errmsg = "Success. New Supplier Updated.";
		if (isset($_REQUEST["cpynum"])) { $cpynum = $_REQUEST["cpynum"]; } else { $cpynum = ""; }
		if ($cpynum == 1) //for first company.
		{
			$errmsg = "Success. New Supplier Updated.";
		}
}
if ($st == 'failed')
{
		$errmsg = "Failed. Supplier Already Exists.";
}



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
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script language="javascript">


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

function onloadfunction1()
{
	document.form1.packagename.focus();	
}

					 
function funcDeletepackage(varpackageAutoNumber)
{
     var varpackageAutoNumber = varpackageAutoNumber;
	 var fRet;
	fRet = confirm('Are you sure want to delete this Package Type '+varpackageAutoNumber+'?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("Package Entry Delete Completed.");
		//return false;
	}
	if (fRet == false)
	{
		alert ("Package Entry Delete Not Completed.");
		return false;
	}

function funclocationChange2()
{
 	if(document.getElementById("packagename").value =="")
	{
	alert("Package Name Cannot Be Empty");
	packagename.focus();
	return false;
	}
}

</script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
.style2 {COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none; font-size: 11px;}
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

function from1submit1()
{
	if (document.form1.location.value == "")
	{
		alert ("Location Cannot Be Empty.");
		document.form1.location.focus();
		return false;
	}

	 if (document.form1.packagename.value == "")
	{
		alert ("Package Name Cannot Be Empty.");
		document.form1.packagename.focus();
		return false;
	}
}

function totalcalc()
{

if(document.getElementById("bedcharges").value != '')
{
var bedcharges = document.getElementById("bedcharges").value;
}
else
{
var bedcharges = 0;
}
if(document.getElementById("lab").value != '')
{
var lab = document.getElementById("lab").value;
}
else
{
var lab = 0;
}
if(document.getElementById("radiology").value != '')
{
var radiology = document.getElementById("radiology").value;
}
else
{
var radiology = 0;
}
if(document.getElementById("service").value != '')
{
var service = document.getElementById("service").value;
}
else
{
var service = 0;
}
if(document.getElementById("doctor").value != '')
{
var doctor = document.getElementById("doctor").value;
}
else
{
var doctor = 0;
}
if(document.getElementById("admin").value != '')
{
var admin = document.getElementById("admin").value;
}
else
{
var admin = 0;
}




if(document.getElementById("pharmacy").value != '')
{
var pharmacy = document.getElementById("pharmacy").value;
}
else
{
var pharmacy = 0;
}
if(document.getElementById("panaestetist").value != '')
{
var panaestetist = document.getElementById("panaestetist").value;
}
else
{
var panaestetist = 0;
}
if(document.getElementById("ppeaditrician").value != '')
{
var ppeaditrician = document.getElementById("ppeaditrician").value;
}
else
{
var ppeaditrician = 0;
}
if(document.getElementById("pgynaecologyst").value != '')
{
var pgynaecologyst = document.getElementById("pgynaecologyst").value;
}
else
{
var pgynaecologyst = 0;
}
if(document.getElementById("ranaestetist").value != '')
{
var ranaestetist = document.getElementById("ranaestetist").value;
}
else
{
var ranaestetist = 0;
}
if(document.getElementById("rpeaditrician").value != '')
{
var rpeaditrician = document.getElementById("rpeaditrician").value;
}
else
{
var rpeaditrician = 0;
}
if(document.getElementById("rgynaecologyst").value != '')
{
var rgynaecologyst = document.getElementById("rgynaecologyst").value;
}
else
{
var rgynaecologyst = 0;
}
var total = parseInt(bedcharges) + parseInt(lab) + parseInt(radiology) + parseInt(service) + parseInt(doctor) + parseInt(admin) + parseInt(pharmacy) + parseInt(panaestetist) + parseInt(ppeaditrician) + parseInt(pgynaecologyst) + parseInt(ranaestetist) + parseInt(rpeaditrician) + parseInt(rgynaecologyst);

document.getElementById("total").value = total.toFixed(2);
}
</script>
<body onLoad="return onloadfunction1()">
<table width="103%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#E0E0E0">
	<?php 
	
		include ("includes/menu1.php"); 
	
	//	include ("includes/menu2.php"); 
	
	?>	</td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top">


      	  <form name="form1" id="form1" method="post" onKeyDown="return disableEnterKey()" action="addippackage.php" onSubmit="return from1submit1()">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="860"><table width="714" height="282" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
                <td bgcolor="#CCCCCC" class="bodytext3" colspan="1"><strong>Package - New </strong></td>
                <!--<td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                <td bgcolor="#CCCCCC" class="bodytext3" align="right" colspan="2">* Indicated Mandatory Fields. </td>
                 <td width="10%" align="right" bgcolor="#CCCCCC" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
                  <?php
						
						$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						$res1 = mysql_fetch_array($exec1);
						
						echo $res1location = $res1["locationname"];
						
						?>
						
						
                  
                  </td>
              </tr>
			  <?php
			  if ($errmsg != '')
			  {
			  ?>
             <tr>
                <td colspan="8" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
              </tr>
			  <?php
			  }
			  ?>
				<tr>
                <td width="14%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><span class="bodytext32">Location   *</span></td>
                <td width="38%" align="left" valign="middle"  bgcolor="#FFFFFF">
                <select name="location" id="location" onChange="return  ajaxlocationfunction(this.value);"  style="border: 1px solid #001E6A;">
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
                <td width="11%" align="right" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
                <td width="33%" align="left" valign="middle"  bgcolor="#FFFFFF"></td>
				</tr>
				<tr>
                <td width="14%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><span class="bodytext32">Package Name   *</span></td>
                <td width="38%" align="left" valign="middle"  bgcolor="#FFFFFF"><input name="packagename" id="packagename" onChange  style="border: 1px solid #001E6A; text-transform:uppercase" size="40"></td>
                <td width="11%" align="right" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Costing</strong></td>
                <td width="33%" align="left" valign="middle"  bgcolor="#FFFFFF"></td>
				</tr>
			  <tr>
			    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Days </td>
			    <td align="left" valign="middle"  bgcolor="#FFFFFF"><input name="days" id="days" value="<?php echo $days; ?>" style="border: 1px solid #001E6A;"  size="20" /></td>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Bed Charges </td>
                <td align="left" valign="middle"  bgcolor="#FFFFFF"><input name="bedcharges" id="bedcharges" value="<?php echo $bedcharges; ?>" style="border: 1px solid #001E6A;"  size="20" onKeyUp="return totalcalc();"/></td>
			  </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Cash</td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF"><font size="2">
				   <input name="rate" id="rate" style="border: 1px solid #001E6A"  size="20" />
			 
				   </font></td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Surgeon </td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF">
				<input name="lab" id="lab" value="<?php echo $lab; ?>" style="border: 1px solid #001E6A"  size="20" onKeyUp="return totalcalc();"/>		   </td>
				 </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Credit</td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input name="threshold" id="threshold" style="border: 1px solid #001E6A;"  size="20" /></td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Radiology </td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF">
				<input name="radiology" id="radiology" style="border: 1px solid #001E6A"  size="20" onKeyUp="return totalcalc();"/>		   </td>
			      </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Rate3</td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF"><input type="text" name="rate3" id="rate3" style="border: 1px solid #001E6A;" size="20"></td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Service</td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF"><input name="service" id="service" style="border: 1px solid #001E6A;"  size="20" onKeyUp="return totalcalc();"/></td>
				 </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF">&nbsp;                   </td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Doctor </td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF"><input name="doctor" id="doctor" value="<?php echo $doctor; ?>" style="border: 1px solid #001E6A;"  size="20" onKeyUp="return totalcalc();"></td>
			      </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp; </td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Admin </td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF"><input name="admin" id="admin" value="<?php echo $admin; ?>" style="border: 1px solid #001E6A"  size="20" onKeyUp="return totalcalc();"></td>
			      </tr>
                  
                  
                  
                  
                   <tr>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp; </td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Pharmacy </td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF"><input name="pharmacy" id="pharmacy" value="<?php echo $pharmacy; ?>" style="border: 1px solid #001E6A"  size="20" onKeyUp="return totalcalc();"></td>
			      </tr>
                   <tr>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp; </td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Private Anaestetist </td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF"><input name="panaestetist" id="panaestetist" value="<?php echo $panaestetist; ?>" style="border: 1px solid #001E6A"  size="20" onKeyUp="return totalcalc();"></td>
			      </tr>
                   <tr>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp; </td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Private Peaditrician</td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF"><input name="ppeaditrician" id="ppeaditrician" value="<?php echo $ppeaditrician; ?>" style="border: 1px solid #001E6A"  size="20" onKeyUp="return totalcalc();"></td>
			      </tr>
                   <tr>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp; </td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="style2">Private Surgeon </td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF"><input name="pgynaecologyst" id="pgynaecologyst" value="<?php echo $pgynaecologyst; ?>" style="border: 1px solid #001E6A"  size="20" onKeyUp="return totalcalc();"></td>
			      </tr>
                   <tr>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp; </td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Resident Anaestetist</td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF"><input name="ranaestetist" id="ranaestetist" value="<?php echo $ranaestetist; ?>" style="border: 1px solid #001E6A"  size="20" onKeyUp="return totalcalc();"></td>
			      </tr>
                   <tr>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp; </td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Resident Peaditrician</td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF"><input name="rpeaditrician" id="rpeaditrician" value="<?php echo $rpeaditrician; ?>" style="border: 1px solid #001E6A"  size="20" onKeyUp="return totalcalc();"></td>
			      </tr>
                   <tr>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp; </td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Resident Surgeon </td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF"><input name="rgynaecologyst" id="rgynaecologyst" value="<?php echo $rgynaecologyst; ?>" style="border: 1px solid #001E6A"  size="20" onKeyUp="return totalcalc();"></td>
			      </tr>
                  
                  
                  
                  
                  
                  
                  
                  
                  
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp; </td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="style1">Total </td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF"><input name="total" id="total" value="<?php echo $admin; ?>" style="border: 1px solid #001E6A"  size="20" onKeyUp="return totalcalc();"></td>
			      </tr>
				 
                 <tr>
                <td colspan="2" align="middle"  bgcolor="#FFFFFF"><div align="right"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input type="hidden" name="frmflag1" value="frmflag1" />
                  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
                  <input name="Submit222" type="submit"  value="Submit" class="button" style="border: 1px solid #001E6A"/>
                </font></font></font></font></font></div></td>
				<td colspan="2" align="middle"  bgcolor="#FFFFFF">&nbsp;</td>
				</tr>
				
				<tr>
					<td align="middle" colspan="2" >&nbsp;</td><td align="middle" colspan="2" >&nbsp;</td>
				</tr>
                </tbody>
                  </table>
                <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                      
                        <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Packages</strong></td>
                        <td bgcolor="#CCCCCC" class="bodytext3"><strong>Location</strong></td>
                        <td width="31%" bgcolor="#CCCCCC" class="bodytext3"><strong>Name</strong></td>
                        <td width="11%" bgcolor="#CCCCCC" class="bodytext3"><strong>Cash</strong></td>
                        <td width="11%" bgcolor="#CCCCCC" class="style1">Days</td>
                        <td width="11%" bgcolor="#CCCCCC" class="style1">Credit</td>
						 <td width="11%" bgcolor="#CCCCCC" class="style1">Rate3</td>
                        <td width="12%" bgcolor="#CCCCCC" class="bodytext3"><strong>Edit</strong></td>
                      </tr>
                      <?php
						$query21 = "select * from master_ippackage where status <> 'DELETED' ";
						$exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
						while ($res21 = mysql_fetch_array($exec21))
						{
						$res21location = $res21['locationname'];
						$res21locationcode = $res21['locationcode'];
						$res21packagename = $res21['packagename'];
						$res21packagenum = $res21['auto_number'];
						$res21days = $res21['days'];
					    $res21threshold = $res21['threshold'];
						$res21rate = $res21['rate'];
						$rate3 = $res21['rate3'];
						
						$res21updatedatetime = $res21['updatedatetime'];
						$res21arraysupplierdate = explode(" ", $updatedatetime);
			
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
							<td width="4%" align="left" valign="top" class="bodytext3">
							<div align="center">
							<a href="addippackage.php?st=del&&anum=<?php echo $res21packagenum; ?>" onClick="return funcDeletepackage('<?php echo $res21packagenum ?>')">
							<img src="images/b_drop.png" width="16" height="16" border="0" /></a>						</div>						</td>
							<td width="20%" align="left" valign="top" name = "packagecode" class="bodytext3">&nbsp;</td>
							<td width="31%" align="left" valign="top"  class="bodytext3"><?php echo $res21location.' ('.$res21locationcode.')'; ?> </td>
							<td width="31%" align="left" valign="top"  class="bodytext3"><?php echo $res21packagename; ?> </td>
							<td align="right" valign="top"  class="bodytext3"><?php echo number_format($res21rate,2,'.',','); ?></td>
							<td align="center" valign="top"  class="bodytext3"><?php echo $res21days; ?></td>
							<td align="right" valign="top"  class="bodytext3"><?php echo number_format($res21threshold,2,'.',','); ?></td>
							<td align="right" valign="top"  class="bodytext3"><?php echo number_format($rate3,2,'.',','); ?></td>
							<td align="left" valign="top"  class="bodytext3"><a href="editippackage.php?st=edit&&packcode=<?php echo $res21packagenum; ?>" style="text-decoration:none">Edit</a></td>
						</tr>
                      <?php
							}
						?>
                        <tr>
                        <td align="middle" colspan="7" >&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
				   <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="3" bgcolor="#CCCCCC" class="bodytext3"><strong>Bed Master - Deleted </strong></td>
                      </tr>
                      <?php
		
	    $query1 = "select * from master_ippackage where status = 'deleted' order by packagename ";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		while ($res1 = mysql_fetch_array($exec1))
		{
		$packagename = $res1['packagename'];
		$packagenumber = $res1["auto_number"];
		$res1location = $res1['locationname'];
		
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
                        <td width="11%" align="left" valign="top"  class="bodytext3">
						<a href="addippackage.php?st=activate&&anum=<?php echo $packagenumber; ?>" class="bodytext3">
                          <div align="center" class="bodytext3">Activate</div>
                        </a></td>
                        <td width="35%" align="left" valign="top"  class="bodytext3"><?php echo $packagename; ?>
                        <td width="35%" align="left" valign="top"  class="bodytext3"><?php echo $res1location; ?>
                        </td>
                      </tr>
                      <?php
		}
		?>
            </tbody>
          </table>
        	
       
    </table>
</form>	
	</table>

<?php include ("includes/footer1.php"); ?>
</body>
</html>

