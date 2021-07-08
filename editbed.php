<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$date = date('Y-m-d');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$bedtemplate=isset($_REQUEST['bedtemp'])?$_REQUEST['bedtemp']:'';
$bedtable=$bedtemplate;
$query10 = "select * from master_testtemplate where testname = 'bedcharge' and referencetable='$bedtemplate' order by templatename";
$exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());
$res10 = mysql_fetch_array($exec10);
$bedtemplate = $res10["templatename"];
if($bedtemplate=='')
{
	$bedtable='master_bed';
	$bedtemplate='master_bedcharge';
}
if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
	
	$bedtemplate=$_REQUEST['bedtemplate1'];
	$bedtable=$_REQUEST['bedtable'];
	$bed = $_REQUEST["bed"];
	$bedanum1 = $_REQUEST['bedanum'];
	//$bed = strtoupper($bed);
	$bed = trim($bed);
	
	$length=strlen($bed);
	$ward = $_REQUEST["ward"];
	$threshold = $_REQUEST['threshold'];
	$nursingcharges = $_REQUEST['nursingcharges'];
	$bedcharges = $_REQUEST['bedcharges'];
	$rmocharges = $_REQUEST['rmocharges'];
	$selectedlocationcode=$_REQUEST["location"];
	
	$accommodationcharges = $_REQUEST['accommodationcharges'];
	$cafetariacharges = $_REQUEST['cafetariacharges'];
	
		 $query31 = "select * from master_location where locationcode = '$selectedlocationcode' and status = '' " ;
	$exec31 = mysql_query($query31) or die ("Error in Query31".mysql_error());
	$res31 =(mysql_fetch_array($exec31));
	 $selectedlocation = $res31["locationname"];

	 $length;
	
	if ($length<=100)
	{
	$query1 = "update $bedtable set locationname='$selectedlocation',locationcode='$selectedlocationcode',bed='$bed', ward='$ward',threshold='$threshold',bedcharges='$bedcharges',nursingcharges='$nursingcharges',rmocharges='$rmocharges',accommodationcharges='$accommodationcharges',cafetariacharges='$cafetariacharges' where auto_number='$bedanum1'";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	// $s="select bed from $bedtemplate where bedanum='$bedanum1' and charge='Bed Charges'";
	 $query7 = mysql_query("select bed from $bedtemplate where bedanum='$bedanum1' and charge='Bed Charges'") or die ("Error in Query7".mysql_error());
	$row7 = mysql_num_rows($query7);
	if($row7 > 0) {	
	 $query22 = "update $bedtemplate set locationname='$selectedlocation',locationcode='$selectedlocationcode', bed='$bed',rate='$bedcharges' where bedanum='$bedanum1' and charge='Bed Charges'";
	$exec22 = mysql_query($query22)	or die(mysql_error());
	} else {
	$query22 = "INSERT INTO $bedtemplate set locationname='$selectedlocation',locationcode='$selectedlocationcode', bed='$bed',rate='$bedcharges', bedanum='$bedanum1', charge='Bed Charges'";
	$exec22 = mysql_query($query22)	or die(mysql_error());
	}
	
	$query71 = mysql_query("select bed from $bedtemplate where bedanum='$bedanum1' and charge='Nursing Charges'") or die ("Error in Query7".mysql_error());
	$row71 = mysql_num_rows($query71);
	if($row71 > 0) {	
	$query23 = "update $bedtemplate set locationname='$selectedlocation',locationcode='$selectedlocationcode', bed='$bed',rate='$nursingcharges' where bedanum='$bedanum1' and charge='Nursing Charges'";
	$exec23 = mysql_query($query23)	or die(mysql_error());
	} else {
	$query23 = "INSERT INTO $bedtemplate set locationname='$selectedlocation',locationcode='$selectedlocationcode', bed='$bed',rate='$nursingcharges', bedanum='$bedanum1', charge='Nursing Charges'";
	$exec23 = mysql_query($query23)	or die(mysql_error());
	}
	
	$query72 = mysql_query("select bed from $bedtemplate where bedanum='$bedanum1' and charge='RMO Charges'") or die ("Error in Query7".mysql_error());
	$row72 = mysql_num_rows($query72);
	if($row72 > 0) {	
	$query21 = "update $bedtemplate set locationname='$selectedlocation',locationcode='$selectedlocationcode', bed='$bed',rate='$rmocharges' where bedanum='$bedanum1' and charge='RMO Charges'";
	$exec21 = mysql_query($query21)	or die(mysql_error());
	} else { 
	$query21 = "INSERT INTO $bedtemplate set locationname='$selectedlocation',locationcode='$selectedlocationcode', bed='$bed',rate='$rmocharges', bedanum='$bedanum1', charge='RMO Charges'";
	$exec21 = mysql_query($query21)	or die(mysql_error());
	}
	
	$query73 = mysql_query("select bed from $bedtemplate where bedanum='$bedanum1' and charge='Accommodation Charges'") or die ("Error in Query7".mysql_error());
	$row73 = mysql_num_rows($query73);
	if($row73 > 0) {	
	$query20 = "update $bedtemplate set locationname='$selectedlocation',locationcode='$selectedlocationcode', bed='$bed',rate='$accommodationcharges' where bedanum='$bedanum1' and charge='Accommodation Charges'";
	$exec20 = mysql_query($query20)	or die(mysql_error());
	} else {
	$query20 = "INSERT INTO $bedtemplate set locationname='$selectedlocation',locationcode='$selectedlocationcode', bed='$bed',rate='$accommodationcharges', bedanum='$bedanum1', charge='Accommodation Charges'";
	$exec20 = mysql_query($query20)	or die(mysql_error());
	}
	
	$query74 = mysql_query("select bed from $bedtemplate where bedanum='$bedanum1' and charge='Cafetaria Charges'") or die ("Error in Query7".mysql_error());
	$row74 = mysql_num_rows($query74);
	if($row74 > 0) {	
	$query19 = "update $bedtemplate set locationname='$selectedlocation',locationcode='$selectedlocationcode', bed='$bed',rate='$cafetariacharges' where bedanum='$bedanum1' and charge='Cafetaria Charges'";
	$exec19 = mysql_query($query19)	or die(mysql_error());
	} else {
	$query19 = "INSERT INTO $bedtemplate set locationname='$selectedlocation',locationcode='$selectedlocationcode', bed='$bed',rate='$cafetariacharges', bedanum='$bedanum1', charge='Cafetaria Charges'";
	$exec19 = mysql_query($query19)	or die(mysql_error());
	}

		$errmsg = "Success. New bed Updated.";
		$bgcolorcode = 'success';
	
	//exit();
		
		}
	
	
	else
	{
		$errmsg = "Failed. Only 100 Characters Are Allowed.";
		$bgcolorcode = 'failed';
	}
header("location:addbed.php");
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
if (isset($_REQUEST["anum"])) { $anum = $_REQUEST["anum"]; } else { $anum = ""; }

 $query74 = "select * from $bedtable where auto_number='$anum'";
$exec74 = mysql_query($query74) or die(mysql_error());
$res74 = mysql_fetch_array($exec74);
$wardanum = $res74['ward'];
$res74locationname = $res74['locationname'];
$res74locationcode = $res74['locationcode'];
$bed = $res74['bed'];
$threshold = $res74['threshold'];
$threshold = intval($threshold);
$accommodationcharges = $res74['accommodationcharges'];
$cafetariacharges = $res74['cafetariacharges'];

$query741 = "select * from $bedtemplate where bed='$bed' and charge='Bed Charges'";
$exec741 = mysql_query($query741) or die(mysql_error());
$res741 = mysql_fetch_array($exec741);
$bedcharges = $res741['rate'];

$query742 = "select * from $bedtemplate where bed='$bed' and charge='Nursing Charges'";
$exec742 = mysql_query($query742) or die(mysql_error());
$res742 = mysql_fetch_array($exec742);
$nursingcharges = $res742['rate'];

$query743 = "select * from $bedtemplate where bed='$bed' and charge='RMO Charges'";
$exec743 = mysql_query($query743) or die(mysql_error());
$res743 = mysql_fetch_array($exec743);
$rmocharges = $res743['rate'];

$grace = $res74['grace'];
$grace = intval($grace);
$query55 = "select * from master_ward where auto_number='$wardanum'";
						  $exec55 = mysql_query($query55) or die(mysql_error());
						  $res55 = mysql_fetch_array($exec55);
						  $wardfullname = $res55['ward'];
	
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
<script type="text/javascript" src="js/insertnewitembed.js"></script>
<script language="javascript">

function addbedprocess1()
{
	//alert ("Inside Funtion");
	if (document.form1.location.value == "")
	{
		alert ("Location Cannot Be Empty.");
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
              <td><form name="form1" id="form1" method="post" action="editbed.php" onSubmit="return addbedprocess1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="1" bgcolor="#CCCCCC" class="bodytext3"><strong>Bed Master - Add New </strong></td>
                        <td colspan="2" bgcolor="#CCCCCC" class="bodytext3" align="right"><strong>Table: <?= $bedtemplate ?></strong></td>
                      </tr>
                      
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                                            				<tr>
                <td width="14%" align="right" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><span class="bodytext32">Location   *</span></td>
                <td width="38%" align="left" valign="middle"  bgcolor="#FFFFFF">
                <select name="location" id="location" onChange="return funclocationChange1();"  style="border: 1px solid #001E6A;">
                						
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
						<input name="bed" id="bed" style="border: 1px solid #001E6A;" size="40" value="<?php echo $bed; ?>" />
						<input type="hidden" name="bedanum" id="bedanum" value="<?php echo $anum; ?>"></td>
                      </tr>
                      
  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Accommodation Charges *</div></td>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
						<input name="accommodationcharges" id="accommodationcharges" style="border: 1px solid #001E6A;" size="10" onKeyPress="return keypressdigit(event)" onKeyUp="charges()" value="<?php echo $accommodationcharges; ?>" /></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Cafetaria Charges *</div></td>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
						<input name="cafetariacharges" id="cafetariacharges" style="border: 1px solid #001E6A;" onKeyPress="return keypressdigit(event)" onKeyUp="charges()" size="10" value="<?php echo $cafetariacharges; ?>" /></td>
                      </tr> 
                                            
                   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Bed Charges</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="bedcharges" id="bedcharges" style="border: 1px solid #001E6A;" size="10" value="<?php echo $bedcharges; ?>" readonly/></td>
                      </tr><tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Nursing Charges</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="nursingcharges" id="nursingcharges" style="border: 1px solid #001E6A;" size="10" value="<?php echo $nursingcharges; ?>"/></td>
                      </tr><tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">RMO Charges</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="rmocharges" id="rmocharges" style="border: 1px solid #001E6A;" size="10" value="<?php echo $rmocharges; ?>"/></td>
                      </tr>
				
			    <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Threshold</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="threshold" id="threshold" style="border: 1px solid #001E6A;" size="10" value="<?php echo $threshold; ?>"/><input type="hidden" name="bedtemplate1" id="bedtemplate1" value="<?= $bedtemplate ?>">
                        <input type="hidden" name="bedtable" id="bedtable" value="<?= $bedtable ?>">
                        </td>
                      </tr>
					   <!--<tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Grace </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="grace" id="grace" style="border: 1px solid #001E6A;" size="10" value="<?php echo $grace; ?>"/></td>
                      </tr>-->
                      <tr>
                        <td width="42%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td width="58%" align="left" valign="top"  bgcolor="#FFFFFF">
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

