<?php
session_start();
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$username=$_SESSION["username"];
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
	
	$total = $_REQUEST['total'];
	
		
	$query2 = "select * from master_mortuarypackage where packagename = '$packagename'";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	$res2 = mysql_num_rows($exec2);
	if ($res2 == 0)
	{
		$query1 = "insert into master_mortuarypackage (packagename,days,bedcharges,threshold,lab,rate,radiology,doctor,service, admin,total,ipaddress,username,rate3) 
		values('$packagename','$days','$bedcharges','$threshold','$lab','$rate','$radiology','$doctor','$service','$admin','$total','$ipaddress','$username','$rate3')";
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
		header("location:mortuarypackage.php?st=success");
		//header ("location:addcompany1.php?st=success&&cpynum=1");
	}
	else
	{
		header ("location:mortuarypackage.php?st=failed");
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
	$dateposted = $updatedatetime;
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_mortuarypackage set status = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
}

if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query13 = "update master_mortuarypackage set status = '' where auto_number = '$delanum'";
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
-->
</style>
</head>
<script language="javascript">

function from1submit1()
{
	
	
	 if (document.form1.packagename.value == "")
	{
		alert ("Package Name Cannot Be Empty.");
		document.form1.packagename.focus();
		return false;
	}

	

	

}

function totalcalc()
{
	
if(document.getElementById("rate").value != '')
{
var cashamount = document.getElementById("rate").value;
}
else
{
var cashamount = 0;
}
if(document.getElementById("threshold").value != '')
{
var threshold = document.getElementById("threshold").value;
}
else
{
var threshold = 0;
}
if(document.getElementById("rate3").value != '')
{
var rate3 = document.getElementById("rate3").value;
}
else
{
var rate3 = 0;
}


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
var total = parseInt(bedcharges) + parseInt(lab) + parseInt(radiology) + parseInt(service) + parseInt(doctor) + parseInt(admin)+ parseInt(cashamount) + parseInt(threshold) + parseInt(rate3);

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


      	  <form name="form1" id="form1" method="post" onKeyDown="return disableEnterKey()" action="" onSubmit="return from1submit1()">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="860"><table width="714" height="282" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
                <td bgcolor="#CCCCCC" class="bodytext3" colspan="2"><strong>Package - New </strong></td>
                <!--<td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                <td bgcolor="#CCCCCC" class="bodytext3" colspan="2">* Indicated Mandatory Fields. </td>
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
              <!--<tr bordercolor="#000000" >
                  <td  align="left" valign="middle"  class="bodytext3"  colspan="4"><strong>Registration</strong></font></div></td>
                </tr>-->
              <!--<tr>
                  <tr  bordercolor="#000000" >
                  <td  align="left" valign="middle"  class="bodytext3" colspan="4"><div align="right">* Indicates Mandatory</div></td>
                </tr>-->
				<tr>
                <td width="14%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><span class="bodytext32">Package Name   *</span></td>
                <td width="38%" align="left" valign="middle"  bgcolor="#FFFFFF"><input name="packagename" id="packagename" style="border: 1px solid #001E6A; text-transform:uppercase;" size="40"></td>
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
				   <input name="rate" id="rate" style="border: 1px solid #001E6A" onKeyUp="return totalcalc();"  size="20" />
			 
				   </font></td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Lab </td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF">
				<input name="lab" id="lab" value="<?php echo $lab; ?>" style="border: 1px solid #001E6A"  size="20" onKeyUp="return totalcalc();"/>		   </td>
				 </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Credit</td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input name="threshold" onKeyUp="return totalcalc();" id="threshold" style="border: 1px solid #001E6A;"  size="20" /></td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Radiology </td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF">
				<input name="radiology" id="radiology" style="border: 1px solid #001E6A"  size="20" onKeyUp="return totalcalc();"/>		   </td>
			      </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Rate3</td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF"><input type="text" name="rate3" id="rate3" onKeyUp="return totalcalc();" style="border: 1px solid #001E6A;" size="20"></td>
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
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Total </td>
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
                        <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Packages  </strong></td>
                        <td width="31%" bgcolor="#CCCCCC" class="bodytext3"><strong>Name</strong></td>
                        <td width="11%" bgcolor="#CCCCCC" class="bodytext3"><strong>Cash</strong></td>
                        <td width="11%" bgcolor="#CCCCCC" class="style1">Days</td>
                        <td width="11%" bgcolor="#CCCCCC" class="style1">Credit</td>
						 <td width="11%" bgcolor="#CCCCCC" class="style1">Rate3</td>
                        <td width="12%" bgcolor="#CCCCCC" class="bodytext3"><strong>Edit</strong></td>
                      </tr>
                      <?php
						$query21 = "select * from master_mortuarypackage where status <> 'DELETED' ";
						$exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
						while ($res21 = mysql_fetch_array($exec21))
						{
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
							<a href="mortuarypackage.php?st=del&&anum=<?php echo $res21packagenum; ?>" onClick="return funcDeletepackage('<?php echo $res21packagenum ?>')">
							<img src="images/b_drop.png" width="16" height="16" border="0" /></a>						</div>						</td>
							<td width="20%" align="left" valign="top" name = "packagecode" class="bodytext3">&nbsp;</td>
							<td width="31%" align="left" valign="top"  class="bodytext3"><?php echo $res21packagename; ?> </td>
							<td align="right" valign="top"  class="bodytext3"><?php echo number_format($res21rate,2,'.',','); ?></td>
							<td align="center" valign="top"  class="bodytext3"><?php echo $res21days; ?></td>
							<td align="right" valign="top"  class="bodytext3"><?php echo number_format($res21threshold,2,'.',','); ?></td>
							<td align="right" valign="top"  class="bodytext3"><?php echo number_format($rate3,2,'.',','); ?></td>
							<td align="left" valign="top"  class="bodytext3"><a href="editmortuarypackage.php?st=edit&&packcode=<?php echo $res21packagenum; ?>" style="text-decoration:none">Edit</a></td>
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
		
	    $query1 = "select * from master_mortuarypackage where status = 'deleted' order by packagename ";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		while ($res1 = mysql_fetch_array($exec1))
		{
		$packagename = $res1['packagename'];
		$packagenumber = $res1["auto_number"];
		
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
						<a href="mortuarypackage.php?st=activate&&anum=<?php echo $packagenumber; ?>" class="bodytext3">
                          <div align="center" class="bodytext3">Activate</div>
                        </a></td>
                        <td width="35%" align="left" valign="top"  class="bodytext3"><?php echo $packagename; ?></td>
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

