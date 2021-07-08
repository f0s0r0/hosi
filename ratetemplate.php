<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$currentdate = date("Y-m-d");
$errmsg='';
if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }



if($frm1submit1 == 'frm1submit1')
{
	if(isset($_REQUEST['labcheck']))
	{
		$labname = $_REQUEST['labname'];
		$query1 = "create TABLE $labname like master_lab";
		$exec1 = mysql_query($query1);
		$query2 = "INSERT INTO $labname SELECT * FROM master_lab";
		$exec2 = mysql_query($query2);
		$labnamereference = $labname.'_reference';
		$query101 = "create TABLE $labnamereference like master_labreference";
		$exec101 = mysql_query($query101);
		$query201 = "INSERT INTO $labnamereference SELECT * FROM master_labreference";
		$exec201 = mysql_query($query201);
		
		$query9 = "INSERT INTO master_testtemplate (templatename,testname,referencetable,ipaddress,username,recorddatetime,companyanum,companyname) values('$labname','lab','$labnamereference','$ipaddress','$username','$updatedatetime','$companyanum','$companyname')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
	}
	if(isset($_REQUEST['radcheck']))
	{
		$radname = $_REQUEST['radname'];
		$query3 = "create TABLE $radname like master_radiology";
		$exec3 = mysql_query($query3);
		$query4 = "INSERT INTO $radname SELECT * FROM master_radiology";
		$exec4 = mysql_query($query4);
		$query10 = "INSERT INTO master_testtemplate (templatename,testname,ipaddress,username,recorddatetime,companyanum,companyname) values('$radname','radiology','$ipaddress','$username','$updatedatetime','$companyanum','$companyname')";
		$exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());
	}
	if(isset($_REQUEST['sercheck']))
	{
		$sername = $_REQUEST['sername'];
		$query5 = "create TABLE $sername like master_services";
		$exec5 = mysql_query($query5);
		$query6 = "INSERT INTO $sername SELECT * FROM master_services";
		$exec6 = mysql_query($query6);
		$query11 = "INSERT INTO master_testtemplate (templatename,testname,ipaddress,username,recorddatetime,companyanum,companyname) values('$sername','services','$ipaddress','$username','$updatedatetime','$companyanum','$companyname')";
		$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
	}
	if(isset($_REQUEST['ipcheck']))
	{
		$ipname = $_REQUEST['ipname'];
		$query7 = "create TABLE $ipname like master_ippackage";
		$exec7 = mysql_query($query7);
		$query8 = "INSERT INTO $ipname SELECT * FROM master_ippackage";
		$exec8 = mysql_query($query8);
		$query12 = "INSERT INTO master_testtemplate (templatename,testname,ipaddress,username,recorddatetime,companyanum,companyname) values('$ipname','ippackage','$ipaddress','$username','$updatedatetime','$companyanum','$companyname')";
		$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
	}
	if(isset($_REQUEST['bedcheck']))
	{
		$bed = $_REQUEST['bed'];
		$query8 = "create TABLE $bed like master_bed";
		$exec8 = mysql_query($query8);
		$query9 = "INSERT INTO $bed SELECT * FROM master_bed";
		$exec9 = mysql_query($query9);
		
		$bedchargereference = $bed.'_charge';
		$query10 = "create TABLE $bedchargereference like master_bedcharge";
		$exec10 = mysql_query($query10);
		$query11 = "INSERT INTO $bedchargereference SELECT * FROM master_bedcharge GROUP BY bedanum,charge";
		$exec11 = mysql_query($query11);
		
	 	$query122 = "INSERT INTO master_testtemplate (templatename,testname,referencetable,ipaddress,username,recorddatetime,companyanum,companyname) values('$bedchargereference','bedcharge','$bed','$ipaddress','$username','$updatedatetime','$companyanum','$companyname')";   
		$exec122 = mysql_query($query122) or die ("Error in Query122".mysql_error()); 
		
	}
	header ("location:ratetemplate.php?st=success");
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == 'success')
{
		$errmsg = "Success. New Template Updated.";
}
else if ($st == 'failed')
{
		$errmsg = "Failed. Employee Already Exists.";
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
.number
{
padding-left:690px;
text-align:right;
font-weight:bold;
}
-->
</style>

<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">


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
function validation()
{
	var re = /[a-zA-Z0-9_]$/;
	if((!document.getElementById("labcheck").checked) && (!document.getElementById("radcheck").checked) && (!document.getElementById("sercheck").checked) && (!document.getElementById("ipcheck").checked)&& (!document.getElementById("bedcheck").checked))
	{
		alert("Please Select Any Check Box");
		return false;
	}
	if(document.getElementById("labcheck").checked)
	{
	 if(document.getElementById("labname").value=='')
	 {
		alert("Enter the lab template name");
		return false;
	 }	 
     else if (!re.test(document.getElementById("labname").value))
    {
        alert ("Special Characters are not allowed except the _");
        return false;
    }
	 
	}
	if(document.getElementById("radcheck").checked)
	{
	 if(document.getElementById("radname").value=='')
	 {
		alert("Enter the radiology template name");
		return false;
	 }
	 else if (!re.test(document.getElementById("radname").value))
    {
        alert ("Special Characters are not allowed except the _");
        return false;
    }
	}
	if(document.getElementById("sercheck").checked)
	{
	 if(document.getElementById("sername").value=='')
	 {
		alert("Enter the service template name");
		return false;
	 }
	  else if (!re.test(document.getElementById("sername").value))
    {
        alert ("Special Characters are not allowed except the _");
        return false;
    }
	}
	if(document.getElementById("ipcheck").checked)
	{
	 if(document.getElementById("ipname").value=='')
	 {
		alert("Enter the ip package template name");
		return false;
	 }
	  else if (!re.test(document.getElementById("ipname").value))
    {
        alert ("Special Characters are not allowed except the _");
        return false;
    }
	}
	if(document.getElementById("bedcheck").checked)
	{
	  if(document.getElementById("bed").value=='')
	 {
		alert("Enter the Bed template name");
		return false;
	 }
	  else if (!re.test(document.getElementById("bed").value))
    {
        alert ("Special Characters are not allowed except the _");
        return false;
    }
	}

	//return false;
}
function enabletextbox()
{
	if(document.getElementById("labcheck").checked)
	{
	 document.getElementById("labname").disabled='';
	}
	else if(!document.getElementById("labcheck").checked)
	{
	 document.getElementById("labname").disabled='true';
	}
	
	if(document.getElementById("radcheck").checked)
	{
	 document.getElementById("radname").disabled='';
	}
	else if(!document.getElementById("radcheck").checked)
	{
	 document.getElementById("radname").disabled='true';
	}
	
	if(document.getElementById("sercheck").checked)
	{
	 document.getElementById("sername").disabled='';
	}
	else if(!document.getElementById("sercheck").checked)
	{
	 document.getElementById("sername").disabled='true';
	}
	
	if(document.getElementById("ipcheck").checked)
	{
	 document.getElementById("ipname").disabled='';
	}
	else if(!document.getElementById("ipcheck").checked)
	{
	 document.getElementById("ipname").disabled='true';
	}
if(document.getElementById("bedcheck").checked)
	{
	 document.getElementById("bed").disabled='';
	}
	else if(!document.getElementById("bedcheck").checked)
	{
	 document.getElementById("bed").disabled='true';
	}
}

</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>

<body>

<form name="form1" id="form1" method="post" onSubmit="return validation();">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
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
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="300" 
            align="left" border="0">
          <tbody>
		   <tr>
                <td colspan="8" align="left" valign="middle"  
				bgcolor="<?php if ($errmsg == '') { echo '#E0E0E0'; } else { echo '#AAFF00'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
              </tr>
            <tr>
             
              <td colspan="9" bgcolor="#cccccc" class="bodytext31">
                
                <div align="left"><strong>Rate Tempalate</strong></div></td>
              </tr>
			  
						
            <tr>
              <td class="bodytext31" valign="center"  align="left" width="5%" 
                bgcolor="#ffffff"><div align="center"><strong>Select</strong></div></td>				 
				<td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Description</strong></div></td>
              	<td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Template Name</strong></div></td>             
              </tr>
			  
			  <tr bgcolor="#CBDBFA">
              <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" name="labcheck" id="labcheck" onChange="enabletextbox();" /></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			    <div align="center">Lab</div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><input type="text" name="labname" id="labname" disabled="disabled"/></div></td>
				</tr>
				
				<tr bgcolor="#D3EEB7">
              <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" name="radcheck" id="radcheck" onChange="enabletextbox();"/></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			    <div align="center">Radiology</div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><input type="text" name="radname" id="radname" disabled="disabled"/></div></td>
				</tr>
				
				<tr bgcolor="#CBDBFA">
              <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" name="sercheck" id="sercheck" onChange="enabletextbox();"/></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			    <div align="center">Services</div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><input type="text" name="sername" id="sername" disabled="disabled"/></div></td>
				</tr>
				
				<tr bgcolor="#D3EEB7">
              <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" name="ipcheck" id="ipcheck" onChange="enabletextbox();"/></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			    <div align="center">IP Package</div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><input type="text" name="ipname" id="ipname" disabled="disabled"/></div></td>
				</tr>
			   
                <tr bgcolor="#CBDBFA">
              <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" name="bedcheck" id="bedcheck" onChange="enabletextbox();"/></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			    <div align="center">Bed Charges</div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><input type="text" name="bed" id="bed" disabled="disabled"/></div></td>
				</tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">
				<input type="hidden" name="frm1submit1" id="frm1submit1" value="frm1submit1" />
				<input type="submit" name="save" id="save" value="Save" />
				
				</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              
            
              </tr>
			  
          </tbody>
        </table></td>
      </tr>
	  <tr>
	   <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
	  </tr>
	  
    </table>
</table>

<?php include ("includes/footer1.php"); ?>
</form>
</body>
</html>