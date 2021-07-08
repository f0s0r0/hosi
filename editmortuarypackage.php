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

$packcode = $_REQUEST["packcode"];

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
	$rate3  = $_REQUEST["rate3"];
	
	$radiology = $_REQUEST["radiology"];
	
	$doctor = $_REQUEST["doctor"];
	
	$admin = $_REQUEST["admin"];
	
	$service  = $_REQUEST["service"];
	
	$total = $_REQUEST['total'];
	
	 if ($packcode != 0)
	{
		$query1 = "update master_mortuarypackage set packagename='$packagename',days='$days',bedcharges='$bedcharges',threshold='$threshold',lab='$lab',rate='$rate',radiology='$radiology',doctor='$doctor',service='$service', admin='$admin',total='$total',ipaddress='$ipaddress',username='$username',rate3='$rate3' where auto_number = '$packcode' ";
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

if (isset($_REQUEST["packcode"])) { $packagecode = $_REQUEST["packcode"]; } else { $packagecode = ""; }
 
           if($packagecode != '')
		   {
		     $query2 = "select * from master_mortuarypackage where auto_number='$packagecode'";
			  $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			  $res2 = mysql_fetch_array($exec2);
			  $res2packagename = $res2['packagename'];
			  $res2packagecode = $res2['auto_number'];
			  $res2days= $res2['days'];
			  $res2bedcharges= $res2['bedcharges'];
			  $res2threshold= $res2['threshold'];
			  $res2lab= $res2['lab'];
			  $res2rate= $res2['rate'];
			  $res2radiology= $res2['radiology'];
			  $res2doctor= $res2['doctor'];
			  $res2admin= $res2['admin'];
			  $res2service= $res2['service'];
			  $res2total= $res2['total'];
			  $res2days= $res2['days'];
			  $rate3 = $res2['rate3'];
			  
    		}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
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
                <td width="42%" align="left" valign="middle"  bgcolor="#FFFFFF"><input name="packagename" id="packagename" style="border: 1px solid #001E6A;" size="40" value="<?php echo $res2packagename; ?>"></td>
                <td width="11%" align="right" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Costing</strong></td>  
				<input type="hidden" name="packcode" id="rate" style="border: 1px solid #001E6A"  size="20" value="<?php echo $packcode; ?>"/>
                <td width="33%" align="left" valign="middle"  bgcolor="#FFFFFF"></td>
				</tr>
			  <tr>
			    <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Days </td>
			    <td align="left" valign="middle"  bgcolor="#FFFFFF"><input name="days" id="days" value="<?php echo $res2days; ?>" style="border: 1px solid #001E6A;"  size="20" /></td>
                <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Bed Charges </td>
                <td align="left" valign="middle"  bgcolor="#FFFFFF"><input name="bedcharges" id="bedcharges" value="<?php echo $res2bedcharges; ?>" style="border: 1px solid #001E6A;"  size="20" onKeyUp="return totalcalc();"/></td>
			  </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Rate</td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF"><font size="2">
				   <input name="rate" id="rate" style="border: 1px solid #001E6A"  size="20" value="<?php echo $res2rate; ?>"/>
			 
				   </font></td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Lab </td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF">
				<input name="lab" id="lab" value="<?php echo $res2lab; ?>" style="border: 1px solid #001E6A"  size="20" onKeyUp="return totalcalc();"/>		   </td>
				 </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Threshold</td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input name="threshold" id="threshold" style="border: 1px solid #001E6A;"  size="20" value="<?php echo $res2threshold; ?>"/></td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Radiology </td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF">
				<input name="radiology" id="radiology" style="border: 1px solid #001E6A"  size="20" onKeyUp="return totalcalc();" value="<?php echo $res2radiology; ?>"/>		   </td>
			      </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Rate3</td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF"><input type="text" name="rate3" id="rate3" value="<?php echo $rate3; ?>" style="border: 1px solid #001E6A;" size="20"></td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Service</td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF"><input name="service" id="service" style="border: 1px solid #001E6A;"  size="20" onKeyUp="return totalcalc();" value="<?php echo $res2service; ?>"/></td>
				 </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF">&nbsp;                   </td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Doctor </td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF"><input name="doctor" id="doctor" value="<?php echo $res2doctor; ?>" style="border: 1px solid #001E6A;"  size="20" onKeyUp="return totalcalc();" ></td>
			      </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp; </td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Admin </td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF"><input name="admin" id="admin" value="<?php echo $res2admin; ?>" style="border: 1px solid #001E6A"  size="20" onKeyUp="return totalcalc();" ></td>
			      </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp; </td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Total </td>
				   <td align="left" valign="middle"  bgcolor="#FFFFFF"><input name="total" id="total" value="<?php echo $res2admin; ?>" style="border: 1px solid #001E6A"  size="20" onKeyUp="return totalcalc();" ></td>
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
                  </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
    </table>
	</form>

    </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

