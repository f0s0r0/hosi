<?php
session_start();
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$pagename = "";

$docno = $_SESSION['docno'];
$username = $_SESSION["username"];
$query = "select * from master_location where  status <> 'deleted' order by locationname";
$exec = mysql_query($query) or die ("Error in Query1".mysql_error());
$res = mysql_fetch_array($exec);
	
	 $locationname  = $res["locationname"];
	 $locationcode = $res["locationcode"];
	 $res12locationanum = $res["auto_number"];
	 
	 
//get location for sort by location purpose
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
	if($location!='')
	{
		 $locationcode=$location;
		}
		//location get end here
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
	$doctorcode=$_REQUEST["doctorcode"];
	$locationcode =$_REQUEST['location'];
	$query = "select * from master_location where locationcode = '$locationcode'";
	$exec = mysql_query($query) or die ("Error in Query1".mysql_error());
	$res = mysql_fetch_array($exec);
	
	$locationname  = $res["locationname"];
	$doctorname = $_REQUEST["doctorname"];
	$doctorname = strtoupper($doctorname);
	$doctorname = trim($doctorname);
	$typeofdoctor=$_REQUEST["typeofdoctor"];
	$address1=$_REQUEST["address1"];
	$address2=$_REQUEST["address2"];
	$area = $_REQUEST["area"];
	$city  = $_REQUEST["city"];
	$state  = $_REQUEST["state"];
	$pincode = $_REQUEST["pincode"];
	$country = $_REQUEST["country"];
	$phonenumber1 = $_REQUEST["phonenumber1"];
	$phonenumber2 = $_REQUEST["phonenumber2"];
	$emailid1  = $_REQUEST["emailid1"];
	$emailid2 = $_REQUEST["emailid2"];
	$faxnumber = $_REQUEST["faxnumber"];
	$mobilenumber  = $_REQUEST["mobilenumber"];
	$remarks=$_REQUEST["remarks"];
	$tinnumber=$_REQUEST["tinnumber"];
	$cstnumber=$_REQUEST["cstnumber"];
	$ipdoctor=$_REQUEST["ipdoctor"];
	$openingbalance = $_REQUEST["openingbalance"];
	$department = $_REQUEST["department"];
	$consultationfees = $_REQUEST["consultationfees"];
	$hospitalfees = '';
	$doctorfees = '';
	
	$resdoccharge = isset($_REQUEST["resdoccharge"])?$_REQUEST["resdoccharge"]:'';
	$pridoccharge = isset($_REQUEST["pridoccharge"])?$_REQUEST["pridoccharge"]:'';
		
	$query2 = "select * from master_doctor where auto_number= '$doctorcode'";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	$res2 = mysql_num_rows($exec2);
	if ($res2 != 0)
	{
		$query1 = "update master_doctor set doctorname = '$doctorname', 
		typeofdoctor = '$typeofdoctor', address1 = '$address1', address2 = '$address2',
		area = '$area', city = '$city', state = '$state', country = '$country', 
		pincode = '$pincode', phonenumber1 = '$phonenumber1', phonenumber2 = '$phonenumber2', faxnumber = '$faxnumber', 
		mobilenumber = '$mobilenumber', emailid1 = '$emailid1', emailid2 = '$emailid2',
		remarks = '$remarks', status = '$status', tinnumber = '$tinnumber', cstnumber = '$cstnumber', 
		openingbalance = '$openingbalance', department = '$department', consultationfees = '$consultationfees', ipdoctor = '$ipdoctor', resdoc_charge = '$resdoccharge', pridoc_charge = '$pridoccharge', locationcode = '$locationcode', locationname = '$locationname' where auto_number  = '$doctorcode'"; 
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		
			
		$companyname = '';
		$title1  = '';
		$title2  = '';
		$contactperson1  = '';
		$contactperson2 = '';
		$designation1 = '';
		$designation2  = '';
		$phonenumber1 = '';
		$phonenumber2 = '';
		$emailid1  = '';
		$emailid2 = '';
		$faxnumber1 = '';
		$faxnumber2  = '';
		$address = '';
		$location = '';
		$city  = '';
		$state = '';
		$pincode = '';
		$country = '';
		$tinnumber = '';
		$cstnumber = '';
		$companystatus  = '';
		$openingbalance = '0.00';
		$dateposted = $updatedatetime;
		$department = '';
		$consultationfees = '';
		
		header("location:adddoctor1.php?st=success");
		//header ("location:addcompany1.php?st=success&&cpynum=1");
	}
	else
	{
		header ("location:adddoctor1.php?st=failed");
	}

}

else
{
	$doctorcode=$_REQUEST["doctorcode"];
	$query2 = "select * from master_doctor where auto_number = '$doctorcode' order by auto_number desc limit 0, 1";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	$res2 = mysql_fetch_array($exec2);
	
	//$doctorcode = $res2["doctorcode"];
	$doctorname = $res2["doctorname"];
	//$doctorname = strtoupper($doctorname);
	$doctorname = trim($doctorname);
	$typeofdoctor = $res2["typeofdoctor"];
	$address1 = $res2["address1"];
	$address2 = $res2["address2"];
	$area = $res2["area"];
	$city  = $res2["city"];
	$state  = $res2["state"];
	$pincode = $res2["pincode"];
	$country = $res2["country"];
	$phonenumber1 = $res2["phonenumber1"];
	$phonenumber2 = $res2["phonenumber2"];
	$emailid1  = $res2["emailid1"];
	$emailid2 = $res2["emailid2"];
	$faxnumber = $res2["faxnumber"];
	$mobilenumber  = $res2["mobilenumber"];
	$remarks=$res2["remarks"];
	$tinnumber=$res2["tinnumber"];
	$cstnumber=$res2["cstnumber"];
	$openingbalance=$res2["openingbalance"];
	$dateposted=$res2["dateposted"];
	$department = $res2['department'];
    $ipdoctor = $res2['ipdoctor'];
	$locationcode = $res2['locationcode'];
	$locationname = $res2['locationname'];
	$resdoccharge = $res2['resdoc_charge'];
	$pridoccharge = $res2['pridoc_charge'];
	$faxnumber2 = '';
	
	$query22 = "select * from master_department where auto_number = '$department'";
	$exec22 = mysql_query($query22) or die ("Error in Query22".mysql_error());
	$res22 = mysql_fetch_array($exec22);
	
	$departmentname=$res22['department'];

	$consultationfees = $res2['consultationfees'];
	$hospitalfees = '';
	$doctorfees = '';
	
	$dateposted = $updatedatetime;

}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'success')
{
		$errmsg = "Success. New Doctor Updated.";
		if (isset($_REQUEST["cpynum"])) { $cpynum = $_REQUEST["cpynum"]; } else { $cpynum = ""; }
		if ($cpynum == 1) //for first company.
		{
			$errmsg = "Success. New Doctor Updated.";
		}
}
else if ($st == 'failed')
{
		$errmsg = "Failed. Doctor Already Exists.";
}

if (isset($_REQUEST["cpycount"])) { $cpycount = $_REQUEST["cpycount"]; } else { $cpycount = ""; }
if ($cpycount == 'firstcompany')
{
	$errmsg = "Welcome. You Need To Add Your Company Details Before Proceeding.";
}

if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add Doctor To Proceed For Billing.";
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
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
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
	document.form1.doctorname.focus();	
}


function processflowitem(varstate)
{
	//alert ("Hello World.");
	var varProcessID = varstate;
	//alert (varProcessID);
	var varItemNameSelected = document.getElementById("state").value;
	//alert (varItemNameSelected);
	ajaxprocess5(varProcessID);
	//totalcalculation();
}

function processflowitem1()
{
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
-->
</style>
</head>
<script language="javascript">

function process1()
{

	if (document.form1.doctorcode.value == "")
	{
		alert ("Doctor Code Cannot Be Empty.");
		document.form1.doctorcode.focus();
		return false;
	}
	if (document.form1.doctorname.value == "")
	{
		alert ("Doctor Name Cannot Be Empty.");
		document.form1.doctorname.focus();
		return false;
	}
/*	else if (document.form1.address1.value == "")
	{
		alert ("Address1  Cannot Be Empty.");
		document.form1.address1.focus();
		return false;
	}
*/
/*
	else if (document.form1.state.value == "")
	{
		alert ("State Cannot Be Empty.");
		document.form1.state.focus();
		return false;
	}
	else if (document.form1.city.value == "")
	{
		alert ("City Cannot Be Empty.");
		document.form1.city.focus();
		return false;
	}
*/
/*
	else if (isNaN(document.getElementById("pincode").value))
	{
		alert ("Pincode Can Only Be Numbers");
		return false;
	}
	else if (document.form1.emailid1.value != "")
	{
		if (document.form1.emailid1.value.indexOf('@')<= 0 || document.form1.emailid1.value.indexOf('.')<= 0)
		{
			window.alert ("Please Enter valid Mail Id");
			document.form1.emailid1.value = "";
			document.form1.emailid1.focus();
			return false;
		}
	}
	else if (document.form1.emailid2.value != "")
	{
		if (document.form1.emailid2.value.indexOf('@')<= 0 || document.form1.emailid2.value.indexOf('.')<= 0)
		{
			window.alert ("Please Enter valid Mail Id");
			document.form1.emailid2.value = "";
			document.form1.emailid2.focus();
			return false;
		}
	}
*/
/*
	if (document.form1.openingbalance.value == "")
	{
		alert ("Opening Balance Cannot Be Empty.");
		document.form1.openingbalance.value = "0.00";
		document.form1.openingbalance.focus();
		return false;
	}
	if (isNaN(document.form1.openingbalance.value))
	{
		alert ("Opening Balance Can Only Be Numbers.");
		document.form1.openingbalance.focus();
		return false;
	}
*/
	if (document.form1.consultationfees.value == "")
	{
		alert ("Consultation Fees Cannot Be Empty.");
		document.form1.consultationfees.value = "0.00";
		document.form1.consultationfees.focus();
		return false;
	}
	if (isNaN(document.form1.consultationfees.value))
	{
		alert ("Consultation Fees Can Only Be Numbers.");
		document.form1.consultationfees.focus();
		return false;
	}
	if (document.form1.department.value == "")
	{
		alert ("Department Cannot Be Empty.");
		document.form1.department.value = "0.00";
		document.form1.department.focus();
		return false;
	}
	//return false;
}

</script>
<script>
                 function showdoctorscharge()
				 {
					 if(document.getElementById("ipdoctor").checked==true)
					 {
					document.getElementById("residentdoc").hidden=false;
					document.getElementById("privatedoc").hidden=false;
					 }
					 else
					 {
					document.getElementById("residentdoc").hidden=true;
					document.getElementById("privatedoc").hidden=true;
					document.getElementById("resdoccharge").value='';
					document.getElementById("pridoccharge").value='';
						 }
					 }
					 
					 function selectcharge(val)
				 {
					 if(val=='res')
					 {
						 document.getElementById("pridoccharge").disabled=true;
						 document.getElementById("pridoccharge").value='';
						 document.getElementById("resdoccharge").disabled=false;
						 }
						 
						 else
					 {
						 document.getElementById("pridoccharge").disabled=false;
						 document.getElementById("resdoccharge").disabled=true;
						 document.getElementById("resdoccharge").value='';
						 }
					 
					 }
                 </script>
<script>
function coasearch(varCallFrom)
{
	var varCallFrom = varCallFrom;
	window.open("popup_coasearchdoctor.php?callfrom="+varCallFrom,"Window2",'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=750,height=350,left=100,top=100');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}

function ajaxdepartment(str)
{
var xmlhttp;
if (str=="")
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  }
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
    document.getElementById("department").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","ajax/ajaxdepartment.php?loc="+str,true);
xmlhttp.send();
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
function consult()
{
	var drfees = document.getElementById("hospitalfees").value;
	if(drfees == "") { drfees = "0.00"; }
	var hospfees = document.getElementById("doctorfees").value;
	if(hospfees == "") { hospfees = "0.00"; }
	var consultation = parseFloat(drfees) + parseFloat(hospfees);
	var consultation = consultation.toFixed(2);
	document.getElementById("consultationfees").value = consultation;
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
    <td colspan="10" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); 	//	include ("includes/menu2.php"); ?>	</td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top">


      	  <form name="form1" id="form1" method="post" onKeyDown="return disableEnterKey()" action="editdoctor1.php" onSubmit="return process1()">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="860"><table width="924" height="282" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
                <td bgcolor="#CCCCCC" class="bodytext3" colspan=""><strong>Doctor - Edit </strong></td>
                <td bgcolor="#CCCCCC" class="bodytext3" colspan="">* Indicated Mandatory Fields. </td>
                
                <!--<td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                              
                <td  colspan="2" bgcolor="#CCCCCC" class="bodytext3" id="ajaxlocation"><strong> Location: </strong>
             
            
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
                <td colspan="8" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
              </tr>
              <!--<tr bordercolor="#000000" >
                  <td  align="left" valign="middle"  class="bodytext3"  colspan="4"><strong>Registration</strong></font></div></td>
                </tr>-->
              <!--<tr>
                  <tr  bordercolor="#000000" >
                  <td  align="left" valign="middle"  class="bodytext3" colspan="4"><div align="right">* Indicates Mandatory</div></td>
                </tr>-->
                <tr>
              <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Location</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#E0E0E0"><span class="bodytext3">
               <select name="location" id="location" <?php /*?>onChange="return funclocationChange1();"<?php */?>
                onChange="ajaxdepartment(this.value);ajaxlocationfunction(this.value);"  style="border: 1px solid #001E6A;">
						<option value="<?php echo $locationcode; ?>" ><?php echo $locationname; ?></option>
						 <option value="">-Select Location-</option>
				  <?php
						
						$query1 = "select * from master_location where  status <> 'deleted' order by locationname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						while ($res1 = mysql_fetch_array($exec1))
						{
						$res1location = $res1["locationname"];
						$res1locationanum = $res1["locationcode"];
						?>
						<option value="<?php echo $res1locationanum; ?>" ><?php echo $res1location; ?></option>
						<?php
						}
						?>
                  </select>
              </span></td>
              </tr>
				<tr>
                <td width="16%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext32">Doctor Name   *</span></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				  <input type="text" name="doctorname" id="paynowcashcoa" value="<?php echo $doctorname; ?>" size="40"/>
						 <input type="hidden" onClick="javascript:coasearch('6')" value="Map" accesskey="m" style="border: 1px solid #001E6A">
						 <input type="hidden" name="paynowlabtype6" id="paynowcashtype" size="10"/>
						
</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext32">Department</span></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<!--<input type="hidden" name="department" id="department" value="<?php echo $department; ?>" style="border: 1px solid #001E6A;"  size="20" />-->
				<strong>
				<select name="department" id="department">
                <option value="<?php echo $department; ?>" selected="selected"><?php echo $departmentname; ?></option>
                </select>
				</strong></td>
				</tr>
			    <tr>
			       <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Consultation Fees  </td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0"><input name="consultationfees" id="consultationfees" value="<?php echo $consultationfees; ?>" style="border: 1px solid #001E6A; background-color:#FFFFFF;"  size="20" /></td>
			        <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Doctor Code   </td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0"><input name="doctorcode" id="paynowcashcode" value="<?php echo $doctorcode; ?>"  readonly style="border: 1px solid #001E6A; background-color:#CCCCCC" size="20"></td>
		          </tr>
			
			    <tr>
			    <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Address 1 </td>
			    <td width="61%" align="left" valign="middle"  bgcolor="#E0E0E0"><input name="address1" id="address1" value="<?php echo $address1; ?>" style="border: 1px solid #001E6A;"  size="60" /></td>
                <td width="12%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Speciality</td>
                <td width="31%" align="left" valign="middle"  bgcolor="#E0E0E0"><input name="address2" id="address2" value="<?php echo $address2; ?>" style="border: 1px solid #001E6A;"  size="50" /></td>
			  </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext31"><span class="bodytext32">County </span></span></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="state" id="state" value="<?php echo $state; ?>" style="border: 1px solid #001E6A"  size="20" />
<!--				
				<select name="state" id="state" onChange="return processflowitem1()">
                  <?php
		 			 	if ($state != '') 
		  	{
			  echo '<option value="'.$state.'" selected="selected">'.$state.'</option>';
		 	}
			else
			{
			  echo '<option value="" selected="selected">Select</option>';
			}
		
			$query1 = "select * from master_state where status <> 'deleted' order by state";
			$exec1 = mysql_query($query1) or die ("Error in Query1.state".mysql_error());
			while ($res1 = mysql_fetch_array($exec1))
			{
			$state = $res1["state"];
			?>
                  <option value="<?php echo $state; ?>"><?php echo $state; ?></option>
                  <?php
			  }
			  ?>
                </select>
-->				</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">City</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="city" id="city" value="<?php echo $city; ?>" style="border: 1px solid #001E6A"  size="20" />
<!--				
				<select name="city" id="city" >
                  <option value="">Select City</option>
                </select>
-->				   </td>
              </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext32">Area</span></td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext31">
				     <input name="area" id="area" value="<?php echo $location; ?>" style="border: 1px solid #001E6A;"  size="20" />
				   </span></td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Country </td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="country" id="country" value="<?php echo $country; ?>" style="border: 1px solid #001E6A"  size="20" />
<!--				
				<select name="country" id="select">
                    <?php
		 	if ($country != '') 
		  	{
			  echo '<option value="'.$country.'" selected="selected">'.$country.'</option>';
		 	}
			else
			{
			  echo '<option value="" selected="selected">Select</option>';
			}
		
			$query1 = "select * from master_country where status <> 'deleted' order by country";
			$exec1 = mysql_query($query1) or die ("Error in Query1.country".mysql_error());
			while ($res1 = mysql_fetch_array($exec1))
			{
			$country = $res1["country"];
			if ($country == 'India') { $selectedcountry = 'selected="selected"'; }
			?>
                    <option <?php echo $selectedcountry; ?> value="<?php echo $country; ?>"><?php echo $country; ?></option>
                    <?php
			  $selectedcountry = '';
				  
			  }
			  ?>
                  </select>                
-->				   </td>
			      </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Post Box </td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0"><input name="pincode" id="pincode" value="<?php echo $pincode; ?>" style="border: 1px solid #001E6A;"  size="20" /></td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Mobile Number </td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0"><input name="mobilenumber" id="mobilenumber" value="<?php echo $faxnumber2; ?>" style="border: 1px solid #001E6A;"  size="20" /></td>
				 </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Phone Number 1  </td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0"><input name="phonenumber1" id="phonenumber1" value="<?php echo $phonenumber1; ?>" style="border: 1px solid #001E6A;" size="20" /></td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Phone Number 2 </td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0"><input name="phonenumber2" id="phonenumber2" value="<?php echo $phonenumber2; ?>" style="border: 1px solid #001E6A;"  size="20"></td>
			      </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Email Id 1 </td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0"><input name="emailid1" id="emailid1" value="<?php echo $emailid1; ?>" style="border: 1px solid #001E6A"  size="20">
			        <input type="hidden" name="tinnumber" id="tinnumber" value="<?php echo $tinnumber; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="20" /></td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Email Id 2 </td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0"><input name="emailid2" id="emailid2" value="<?php echo $emailid2; ?>" style="border: 1px solid #001E6A"  size="20">
			        <input type="hidden" name="cstnumber" id="cstnumber" value="<?php echo $cstnumber; ?>" style="border: 1px solid #001E6A; text-transform: uppercase;"  size="20" /></td>
			      </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Opening Balance  </td>
			        <td><input type="text" name="openingbalance" id="openingbalance" value="<?php echo $openingbalance; ?>" style="border: 1px solid #001E6A; text-align:right" size="20"></td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Is IP doctor ? </td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0"><input type="checkbox" name="ipdoctor" id="ipdoctor" value="1" onClick="showdoctorscharge()" <?php if($ipdoctor == 1) { echo 'checked'; } ?>></td>
				 </tr>
                  <tr id="residentdoc" <?php if($ipdoctor == 1) { echo ''; } else { echo 'hidden="true"'; } ?>>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Resident Doctor Charge </td>
			        <td><input type="text" name="resdoccharge" id="resdoccharge" value="<?php echo $resdoccharge; ?>" style="border: 1px solid #001E6A; text-align:left" <?php if($resdoccharge == '0.00') { echo 'disabled'; } ?> size="15"><input name="chargerad" type="radio"  onClick="selectcharge('res')" <?php if($resdoccharge != '0.00') { echo 'checked'; } ?>></td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0">&nbsp;</td>
				 </tr>
                 <tr  id="privatedoc" <?php if($ipdoctor == 1) { echo ''; } else { echo 'hidden="true"'; } ?>>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Private Doctor Charge </td>
			        <td><input type="text" name="pridoccharge" id="pridoccharge" value="<?php echo $pridoccharge; ?>" style="border: 1px solid #001E6A; text-align:left" <?php if($pridoccharge == '0.00') { echo 'disabled'; } ?>  size="15" ><input type="radio"  name="chargerad"   onClick="selectcharge('pri')" <?php if($pridoccharge != '0.00') { echo 'checked'; } ?>></td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0">&nbsp;</td>
				 </tr>
                 
				 <tr>
				   <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			      </tr>
                 <tr>
                <td colspan="4" align="middle"  bgcolor="#E0E0E0"><div align="right"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input type="hidden" name="frmflag1" value="frmflag1" />
                  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
                  <input name="Submit222" type="submit"  value="Save Doctor" class="button" style="border: 1px solid #001E6A"/>
                </font></font></font></font></font></div></td>
              </tr>
            </tbody>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
    </table>
	</form>
<script language="javascript">


</script>
    </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

