<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$sno = '';

//to redirect if there is no entry in masters category or item.



if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
	for($i=1;$i<20;$i++)
	{	
		if(isset($_REQUEST['chk'.$i]))
		{	
			$serialno = $_REQUEST['chk'.$i];
			if($serialno != '')
			{	
				$locationcode = $_REQUEST['chk'.$i];
				$rateperunit = $_REQUEST['rateperunit'.$i];
			
		foreach($_POST['reference'] as $key => $value)
	{
	$reference = $_POST['reference'][$key];
	$units = $_POST['units'][$key];
	$range = $_POST['range'][$key];
	$criticallow = $_POST['criticallow'][$key];
	$criticalhigh = $_POST['criticalhigh'][$key];
	
	$itemcode = $_REQUEST['itemcode'];		
	$itemname = $_REQUEST["itemname"];
	$displayname = $_REQUEST["displayname"];
	//$itemname = strtoupper($itemname);
	$itemname = trim($itemname);
	$displayname = trim($displayname);
	//echo "simple";
	$length1=strlen($itemcode);
	$length2=strlen($itemname);
	//! ^ + = [ ] ; , { } | \ < > ? ~
	//if (preg_match ('/[+,|,=,{,},(,)]/', $itemname))
	if (preg_match ('/[!,^,+,=,[,],;,,,{,},|,\,<,>,?,~]/', $itemname))
	{  
		//echo "inside if";
		$bgcolorcode = 'fail';
		$errmsg="Sorry. lab Item Not Added";
		
		header("location:labitem1.php?st=1");
		exit();
	}
	$itemname = addslashes($itemname);
	$displayname = addslashes($displayname);
	
	$categoryname = $_REQUEST["categoryname"];
	$purchaseprice  = $_REQUEST["purchaseprice"];
	//$rateperunit  = $_REQUEST["rateperunit"];
	$expiryperiod = '';
	$description=$_REQUEST["description"];
	$sampletype=$_REQUEST["sampletype"];
	$referencevalue = $_REQUEST["referencevalue"];
	$itemname_abbreviation = $_REQUEST["unitname_abbreviation"];
	$taxanum = $_REQUEST["taxanum"];
	
	$query4 = "select * from master_tax where auto_number = '$taxanum'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	$res4 = mysql_fetch_array($exec4);
	
	$res4taxname = $res4["taxname"];
	
	$ipmarkup = $_REQUEST["ipmarkup"];
	//$location = $_REQUEST["location"];
	$querynw21 = "select * from master_location where locationcode = '$locationcode'";//
	$execnw21 = mysql_query($querynw21) or die ("Error in Query21".mysql_error());
	$numnw21 = mysql_num_rows($execnw21);
	$resnw21 = mysql_fetch_array($execnw21);
	$locationname = $resnw21['locationname'];
	$rate2 = $_REQUEST['rate2'];
	$rate3 = $_REQUEST['rate3'];
	if(isset($_REQUEST['externallab'])) { $externallab = $_REQUEST['externallab']; } else { $externallab = 'no'; }
	if(isset($_REQUEST['exclude'])) { $exclude = $_REQUEST['exclude']; } else { $exclude = 'no'; }
	
	if ($length1<25 && $length2<255)
	{
		if($reference != '')
		{	
			$query25 = "select * from master_labreference where itemcode = '$itemcode' and referencename = '$reference'";// or itemname = '$itemname'";
			$exec25 = mysql_query($query25) or die ("Error in Query25".mysql_error());
			$res25 = mysql_num_rows($exec25);
			if($res25 == 0)
			{
				$query1 = "insert into master_labreference (itemcode, itemname, categoryname, itemname_abbreviation, rateperunit, expiryperiod, taxanum, taxname, ipaddress, updatetime, description, purchaseprice, referencevalue,ipmarkup,sampletype,location,locationname,referencename,referenceunit,referencerange,rate2,rate3,criticallow,criticalhigh,displayname) 
				values ('$itemcode', '$itemname', '$categoryname', '$itemname_abbreviation', '', '', '', '', '$ipaddress', '$updatedatetime','', '', '$referencevalue','$ipmarkup','$sampletype','','','$reference','$units','$range','$rate2','$rate3','$criticallow','$criticalhigh','$displayname')";
				$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());	
			}	
		}
		$query24 = "select * from master_lab where itemcode = '$itemcode' and location = '$locationcode'";// or itemname = '$itemname'";
		$exec24 = mysql_query($query24) or die ("Error in Query24".mysql_error());
		$res24 = mysql_num_rows($exec24);
		if($res24 == 0)
		{
			$query1 = "insert into master_lab (itemcode, itemname, categoryname, itemname_abbreviation, rateperunit, expiryperiod, taxanum, taxname, ipaddress, updatetime, description, purchaseprice, referencevalue,ipmarkup,sampletype,location,locationname,rate2,rate3,displayname,externallab,exclude) 
			values ('$itemcode', '$itemname', '$categoryname', '$itemname_abbreviation', '$rateperunit', '$expiryperiod', '$taxanum', '$res4taxname', '$ipaddress', '$updatedatetime','$description', '$purchaseprice', '$referencevalue','$ipmarkup','$sampletype','$locationcode','$locationname','$rate2','$rate3','$displayname','$externallab','$exclude')";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		}
	
		 
			$errmsg = "Success. New Lab Item Updated.";
			$bgcolorcode = 'success';
			$itemcode = '';
			$itemname = '';
			$rateperunit  = '0.00';
			$purchaseprice  = '0.00';
			$description = '';
			$referencevalue = '';

			//$itemcode = '';		
	
	}
	else
	{
		$errmsg = "Failed. lab Item Code Should Be 25 Characters And Name Should Be 255 Characters.";
		$bgcolorcode = 'failed';
	}
}	

			}	
		}
	}	

}
else
{
	$itemname = '';
	$rateperunit  = '0.00';
	$purchaseprice  = '0.00';
	$description='';
	$referencevalue = '';
	}
	
	//$itemcode = '';
	$query1 = "select * from master_lab order by auto_number desc limit 0, 1";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	$rowcount1 = mysql_num_rows($exec1);
	if ($rowcount1 == 0)
	{
		$itemcode = 'LAB001';
	}
	else
	{
		$res1 = mysql_fetch_array($exec1);
	    $res1itemcode = $res1['itemcode'];
		$res1itemcode = substr($res1itemcode, 3, 7);
		$res1itemcode = intval($res1itemcode);
		$res1itemcode = $res1itemcode + 1;
	
		/*
		$maxanum = $res1itemcode;
		if (strlen($maxanum) == 1)
		{
			$maxanum1 = '0000000'.$maxanum;
		}
		else if (strlen($maxanum) == 2)
		{
			$maxanum1 = '000000'.$maxanum;
		}
		else if (strlen($maxanum) == 3)
		{
			$maxanum1 = '00000'.$maxanum;
		}
		else if (strlen($maxanum) == 4)
		{
			$maxanum1 = '0000'.$maxanum;
		}
		else if (strlen($maxanum) == 5)
		{
			$maxanum1 = '000'.$maxanum;
		}
		else if (strlen($maxanum) == 6)
		{
			$maxanum1 = '00'.$maxanum;
		}
		else if (strlen($maxanum) == 7)
		{
			$maxanum1 = '0'.$maxanum;
		}
		else if (strlen($maxanum) == 8)
		{
			$maxanum1 = $maxanum;
		}
		*/
		
		$res1itemcode = $res1itemcode;
		if (strlen($res1itemcode) == 2)
		{
			$res1itemcode = '0'.$res1itemcode;
		}
		if (strlen($res1itemcode) == 1)
		{
			$res1itemcode = '00'.$res1itemcode;
		}
		$itemcode = 'LAB'.$res1itemcode;
	
		//echo $employeecode;
	}
		
	


if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_lab set status = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
}
if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_lab set status = '' where auto_number = '$delanum'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
}


if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add lab Item To Proceed For Billing.";
	$bgcolorcode = 'failed';
}

if (isset($_REQUEST["searchflag1"])) { $searchflag1 = $_REQUEST["searchflag1"]; } else { $searchflag1 = ""; }
if (isset($_REQUEST["searchflag2"])) { $searchflag2 = $_REQUEST["searchflag2"]; } else { $searchflag2 = ""; }
if (isset($_REQUEST["search1"])) { $search1 = $_REQUEST["search1"]; } else { $search1 = ""; }
if (isset($_REQUEST["search2"])) { $search2 = $_REQUEST["search2"]; } else { $search2 = ""; }
?>

<link rel="stylesheet" href="main.css" type="text/css" />
<link href="../hospitalmillennium/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.pagination{float:right;}
-->
</style>
</head>
<script type="text/javascript" src="js/insertnewitemlab.js"></script>
<script language="javascript">

function additem1process1()
{
	//alert ("Inside Funtion");
	if (document.form1.categoryname.value == "")
	{	
		alert ("Please Select Category Name.");
		document.form1.categoryname.focus();
		return false;
	}
	if (document.form1.itemcode.value == "")
	{	
		alert ("Please Enter lab Item Code or ID.");
		document.form1.itemcode.focus();
		return false;
	}
	if (document.form1.itemcode.value != "")
	{	
		var data = document.form1.itemcode.value;
		//alert(data);
		// var iChars = "!%^&*()+=[];,.{}|\:<>?~"; //All special characters.*
		var iChars = "!^+=[];,{}|\<>?~$'\"@#%&*()-_`. "; 
		for (var i = 0; i < data.length; i++) 
		{
			if (iChars.indexOf(data.charAt(i)) != -1) 
			{
				//alert ("Your lab Item Name Has Blank White Spaces Or Special Characters. Like ! ^ + = [ ] ; , { } | \ < > ? ~ $ ' \" These are not allowed.");
				alert ("Your lab Item Code Has Blank White Spaces Or Special Characters. These Are Not Allowed.");
				return false;
			}
		}
	}
	if (document.form1.itemname.value == "")
	{
		alert ("Pleae Enter lab Item Name.");
		document.form1.itemname.focus();
		return false;
	}
	/*
	if (document.form1.itemname_abbreviation.value == "")
	{
		alert ("Pleae Select Unit Name.");
		document.form1.itemname_abbreviation.focus();
		return false;
	}
	*/
	if (document.form1.purchaseprice.value == "")
	{	
		alert ("Please Enter Purchase Price Per Unit.");
		document.form1.purchaseprice.focus();
		return false;
	}
	if (document.form1.rateperunit.value == "")
	{	
		alert ("Please Enter Selling Price Per Unit.");
		document.form1.rateperunit.focus();
		return false;
	}
	if (isNaN(document.form1.rateperunit.value) == true)
	{	
		alert ("Please Enter Rate Per Unit In Numbers.");
		document.form1.rateperunit.focus();
		return false;
	}
	if (document.form1.rateperunit.value == "0.00")
	{
		var fRet; 
		fRet = confirm('Rate Per Unit Is 0.00, Are You Sure You Want To Continue To Save?'); 
		//alert(fRet);  // true = ok , false = cancel
		if (fRet == false)
		{
			return false;
		}
/*		else if (document.form1.itemname_abbreviation.value == "SR")
		{
			if (document.form1.expiryperiod.value == "")
			{	
				alert ("Please Select Expiry Period.");
				document.form1.expiryperiod.focus();
				return false;
			}
		}
*/	}
/*	else if (document.form1.itemname_abbreviation.value == "SR")
	{
		if (document.form1.expiryperiod.value == "")
		{	
			alert ("Please Select Expiry Period.");
			document.form1.expiryperiod.focus();
			return false;
		}
	}
*/}

/*
function process1()
{
	//alert (document.form1.itemname.value);
	if (document.form1.itemname_abbreviation.value == "SR")
	{
		document.getElementById('expiryperiod').style.visibility = '';
	}
	else
	{
		document.getElementById('expiryperiod').style.visibility = 'hidden';
	}
}
*/
function spl()
{
	var data=document.form1.itemname.value ;
	//alert(data);
	// var iChars = "!%^&*()+=[];,.{}|\:<>?~"; //All special characters.
	var iChars = "!^+=[];,{}|\<>?~"; 
	for (var i = 0; i < data.length; i++) 
	{
		if (iChars.indexOf(data.charAt(i)) != -1) 
		{
			alert ("Your lab Item Name Has Special Characters. Like ! ^ + = [ ] ; , { } | \ < > ? ~ These are not allowed.");
			document.form1.itemname.focus();
			return false;
		}
	}

}

function AddDisplayname()
{
	var Name = document.getElementById("itemname").value;
	
	document.getElementById("displayname").value = Name;
}

function process2()
{
	//document.getElementById('expiryperiod').style.visibility = 'hidden';
}

function process1backkeypress1()
{
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
		return false;
	}
	else
	{
		return true;
	}

}

function btnDeleteClick10(delID)
{
	//alert ("Inside btnDeleteClick.");
	var varDeleteID = delID;
	//alert (varDeleteID);
	var fRet3; 
	fRet3 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet3 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child = document.getElementById('idTR'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow'); // tbody name.
	document.getElementById ('insertrow').removeChild(child);
	
	var child = document.getElementById('idTRaddtxt'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow'); // tbody name.
	//alert (child);
	if (child != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow').removeChild(child);
		
		
	}
		

}

</script>
<?php include ("includes/header.php"); ?>
<body onLoad="return process2()">
<table width="101%" border="0" cellspacing="0" cellpadding="2">

  <tr>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
            <tr>
              <td><form name="form1" id="form1" method="post" action="labitem1.php" onSubmit="return additem1process1()">
                  <table width="900" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr>
                        <td colspan="4" class="bodytext11"><strong>Lab Item Master - Add New </strong></td>
                      </tr>
					  <?php if ($st==1)
					  {?>
					  <tr>
                        <td colspan="4" align="left" valign="middle" bgcolor="#AAFF00"><font size="2">Sorry Special Characters Are Not Allowed</font></div></td>
                      </tr>
					  <?php }?>
                      <tr>
                        <td colspan="4" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; }else if ($bgcolorcode == 'fail') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?>&nbsp;</div></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"   class="bodytext21"><div align="left">Select Category Name  </div></td>
                        <td align="left" valign="top" class="bodytext21" >
                          <select id="categoryname" name="categoryname" >
                            <?php
						if ($categoryname != '')
						{
						?>
                            <option value="<?php echo $categoryname; ?>" selected="selected"><?php echo $categoryname; ?></option>
                            <?php
						}
						else
						{
						?>
                            <option value="" selected="selected">Select Category</option>
                            <?php
						}
						$query1 = "select * from master_categorylab where status <> 'deleted' order by categoryname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						while ($res1 = mysql_fetch_array($exec1))
						{
						$res1categoryname = $res1["categoryname"];
						?>
                            <option value="<?php echo $res1categoryname; ?>"><?php echo $res1categoryname; ?></option>
                            <?php
						}
						?>
                          </select>
                          <a href="labcategory1.php"><font  class="bodytext21" color="#000000">(Click Here To Add New Category)</font></a>
                          </td>
                        <td align="left" valign="top"   class="bodytext21">External Lab</td>
                        <td align="left" valign="top" class="bodytext21" ><input type="checkbox" name="externallab" value="yes">						</td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"   class="bodytext21"> <div align="left">New Lab Item Code </div></td>
                        <td align="left" valign="top"  class="bodytext21"><input name="itemcode" value="<?php echo $itemcode; ?>" id="itemcode" readonly="readonly" onKeyDown="return process1backkeypress1()" style=" border:none;" size="20" maxlength="100" /><span class="bodytext21">( Example : PRD1234567890 ) </span></td>
                        
                        <td align="left" valign="top"   class="bodytext21">Exclude</td>
                        <td align="left" valign="top" class="bodytext21" ><input type="checkbox" name="exclude" value="yes">	</td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"   class="bodytext21"><div align="left">Add New Lab Item Name </div></td>
                        <td align="left" valign="top" class="bodytext21"><input name="itemname" type="text" id="itemname" onChange="return spl()" onKeyUp="return AddDisplayname()" value="<?php echo $itemname; ?>" size="45"></td>
                        <td align="left" valign="top"   class="bodytext21">IP Mark up</td>
                        <td align="left" valign="top"  class="bodytext21"><input type="text" name="ipmarkup" ></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"   class="bodytext21"><div align="left">Lab Item Display Name </div></td>
                        <td align="left" valign="top" class="bodytext21"><input name="displayname" type="text" id="displayname" value="" size="45"></td>
                        <td colspan="2" align="left" valign="top"   class="bodytext21">&nbsp;</td>
                      </tr>
					   <tr>
                        <td align="left" valign="middle"   class="bodytext21"><div align="left">Select Lab Item Unit (Optional)  </div></td>
                        <td align="left" valign="top"  class="bodytext21"><input name="unitname_abbreviation" type="text" id="unitname_abbreviation" value="" size="20"></td>
                        <td align="left" valign="top"   class="bodytext21">Sample Type</td>
                        <td align="left" valign="top" class="bodytext21" ><input name="sampletype" id="sampletype" value="" size="20" /></td></tr>
				    <tr>
                        <td align="left" valign="middle"   class="bodytext21"><div align="left">Lab Item Reference Value (Optional) </div></td>
                        <td align="left" valign="top" class="bodytext21" ><textarea name="referencevalue" cols="35" id="referencevalue" ><?php echo $referencevalue; ?></textarea>
                          <input name="description" type="hidden" id="description" style="border: 1px solid #001E6A" value="<?php echo $description; ?>" size="60"></td>
                     <td align="left" valign="top"   class="bodytext21">&nbsp;</td>
                        <td align="left" valign="top" class="bodytext21" >
						<!--<select name="location" id="location">
						<?php
						$querynw2 = "select * from master_locationstore where username = '$username' and locationcode <> ''";//
						$execnw2 = mysql_query($querynw2) or die ("Error in Query2".mysql_error());
						$numnw2=mysql_num_rows($execnw2);
						while($resnw2 = mysql_fetch_array($execnw2))
						{
						?>
						<option value="<?php echo $resnw2['locationcode'];?>"><?php echo $resnw2['locationname'];?></option>		
						<?php 
						}?>		
						</select>-->
						</td>
                       </tr>
					  <tr>
                        <td align="left" valign="middle"   class="bodytext21"><div align="left">Select Applicable Tax </div></td>
                        <td align="left" valign="top" class="bodytext21" ><select id="taxanum" name="taxanum">
                          <option value="">Select Tax</option>
                          <?php
						$query1 = "select * from master_tax where status <> 'deleted' order by taxname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						while ($res1 = mysql_fetch_array($exec1))
						{
						$res1taxname = $res1["taxname"];
						$res1taxpercent = $res1["taxpercent"];
						$res1anum = $res1["auto_number"];
						?>
                          <option value="<?php echo $res1anum; ?>"><?php echo $res1taxname.' ( '.$res1taxpercent.'% ) '; ?></option>
                          <?php
						}
						?>
                        </select></td>
                        <td align="left" valign="top" class="bodytext21" >&nbsp;</td>
                        <td align="left" valign="top" class="bodytext21" >&nbsp;</td>
                      </tr>
                
                    <tr>
					<td align="left" class="bodytext12">&nbsp;</td>
					<td align="left" class="bodytext12"><strong>Location Rate</strong></td>
					</tr>
					<tr>
					<td align="left" class="bodytext12">&nbsp;</td>
					<td colspan="3" align="left" class="bodytext12">
					<table border="0" width="300" cellpadding="1" cellspacing="1">
					<?php
					$query12 = "select * from master_location where status <> 'deleted' order by locationname";
					$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
					while($res12 = mysql_fetch_array($exec12))
					{
					$sno = $sno + 1;
					$locationcode = $res12['locationcode'];
					$locationname = $res12['locationname'];
					?>
					<tr>
					<td align="left" class="bodytext12"><input type="checkbox" name="chk<?php echo $sno; ?>" id="chk<?php echo $sno; ?>" value="<?php echo $locationcode; ?>">&nbsp;&nbsp;<?php echo $locationname; ?></td>
					<td align="left" class="bodytext12"><input type="text" name="rateperunit<?php echo $sno; ?>" id="rateperunit<?php echo $sno; ?>" value="<?php //echo $rate2; ?>" size="10" /></td>
					</tr>
					<?php } ?>
					</table>
					</td>
					</tr>
					
					<input type="hidden" name="rate2" id="rate2" value="<?php echo $rate2; ?>" size="20" />
                    <input type="hidden" name="rate3" id="rate3" value="<?php echo $rate3; ?>" size="20" />
					<input type="hidden" name="purchaseprice" id="purchaseprice" value="<?php echo $purchaseprice; ?>" size="20" />
					 <tr>
	   <td colspan="4" width="9%" align="left" valign="middle"   class="bodytext21"><strong>Add Reference</strong></td>
	 
	  </tr> 
	  <tr id="pressid">
				   <td colspan="11" align="left" valign="middle"   class="bodytext21">
				   <table id="presid" width="400" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="150" class="bodytext21">Reference</td>
                       <td width="48" class="bodytext21">Unit</td>
					   <td width="41" class="bodytext21">Low</td>
					   <td width="41" class="bodytext21">High</td>
                       <td width="41" class="bodytext21">Range &nbsp;(add # for separation )</td>
                     </tr>
					 <tr>
					 <div id="insertrow">					 </div></tr>
                     <tr>
					  <input type="hidden" name="serialnumber" id="serialnumber" value="1">
					  <input type="hidden" name="medicinecode" id="medicinecode" value="">
                       <td><input name="reference[]" type="text" id="reference" size="25" autocomplete="off"></td>
                       <td><input name="units[]" type="text" id="units" size="8" autocomplete="off"></td>
   
                       <td><input name="criticallow[]" type="text" id="criticallow" size="8" autocomplete="off"></td>
						<td><input name="criticalhigh[]" type="text" id="criticalhigh" size="8" autocomplete="off"></td>
						<td><textarea rows="2" cols="15" name="range[]" id="range"></textarea></td>
                       <td><label>
                       <input type="button" name="Add" id="Add" value="Add" onClick="return insertitem10()" class="button">
                       </label></td>
					   </tr>
                     
					 <input type="hidden" name="h" id="h" value="0">
                   </table>				  </td>
			       </tr>
	   <tr>
                        <td width="21%" align="left" valign="top"   class="bodytext21">&nbsp;</td>
                        <td width="37%" align="left" valign="top"  class="bodytext21">&nbsp;</td>
                        <td width="14%" align="left" valign="top" class="bodytext21" >&nbsp;</td>
                        <td width="28%" align="left" valign="top"  class="bodytext21"><input type="hidden" name="frmflag" value="addnew" />
                          <input type="hidden" name="frmflag1" value="frmflag1" />
                          <input type="submit" name="Submit" value="Save Lab Item" /></td>
                      </tr>
                    </tbody>
                  </table>
				  </form>
				  <form>
                <table width="1200" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr>
                        <td colspan="12" class="bodytext11"><strong>Lab Item Master - Existing List - Latest 100 Lab Items </strong></td>
						<td colspan="4" class="bodytext11"><span class="bodytext11">
						<?php //error_reporting(0);
						if($searchflag1 != 'searchflag1'){
							$tbl_name="master_lab";		//your table name
							// How many adjacent pages should be shown on each side?
							$adjacents = 3;
							
							/* 
							   First get total number of rows in data table. 
							   If you have a WHERE clause in your query, make sure you mirror it here.
							*/
							$query111 = "select * from master_lab where status <> 'deleted' group by itemcode order by auto_number desc";
							$exec111 = mysql_query($query111) or die ("Error in Query111".mysql_error());
							$res111 = mysql_fetch_array($exec111);
							$total_pages = mysql_num_rows($exec111);
												
							/*$query = "SELECT * FROM $tbl_name";
							$total_pages = mysql_fetch_array(mysql_query($query));
							echo $numrow = mysql_num_rows($total_pages);*/
							
							/* Setup vars for query. */
							$targetpage = $_SERVER['PHP_SELF']; 	//your file name  (the name of this file)
							$limit = 50; 								//how many items to show per page
							if(isset($_REQUEST['page'])){ $page=$_REQUEST['page'];} else { $page="";}
							if($page) 
								$start = ($page - 1) * $limit; 			//first item to display on this page
							else
								$start = 0;								//if no page var is given, set start to 0
							
							/* Setup page vars for display. */
							if ($page == 0) $page = 1;					//if no page var is given, default to 1.
							$prev = $page - 1;							//previous page is page - 1
							$next = $page + 1;							//next page is page + 1
							$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
							$lpm1 = $lastpage - 1;						//last page minus 1
							
							/* 
								Now we apply our rules and draw the pagination object. 
								We're actually saving the code to a variable in case we want to draw it more than once.
							*/
							$pagination = "";
							if($lastpage >= 1)
							{	
								$pagination .= "<div class=\"pagination\">";
								//previous button
								if ($page > 1) 
									$pagination.= "<a href=\"$targetpage?page=$prev\" style='color:#3b3b3c;'>previous</a>";
								else
									$pagination.= "<span class=\"disabled\">previous</span>";	
								
								//pages	
								if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
								{	
									for ($counter = 1; $counter <= $lastpage; $counter++)
									{
										if ($counter == $page)
											$pagination.= "<span class=\"current\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</span>";
										else
											$pagination.= "<a href=\"$targetpage?page=$counter\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					
									}
								}
								elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
								{
									//close to beginning; only hide later pages
									if($page < 1 + ($adjacents * 2))		
									{
										for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
										{
											if ($counter == $page)
												$pagination.= "<span class=\"current\" style='margin:0 0 0 2px;' color:#3b3b3c;>$counter</span>";
											else
												$pagination.= "<a href=\"$targetpage?page=$counter\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					
										}
										$pagination.= "...";
										$pagination.= "<a href=\"$targetpage?page=$lpm1\"style='margin:0 0 0 2px; color:#3b3b3c;'>$lpm1</a>";
										$pagination.= "<a href=\"$targetpage?page=$lastpage\"style='margin:0 0 0 2px; color:#3b3b3c;'>$lastpage</a>";		
									}
									//in middle; hide some front and some back
									elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
									{
										$pagination.= "<a href=\"$targetpage?page=1\" style='margin:0 0 0 2px; color:#3b3b3c;'>1</a>";
										$pagination.= "<a href=\"$targetpage?page=2\" style='margin:0 0 0 2px; color:#3b3b3c;'>2</a>";
										$pagination.= "...";
										for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
										{
											if ($counter == $page)
												$pagination.= "<span class=\"current\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</span>";
											else
												$pagination.= "<a href=\"$targetpage?page=$counter\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					
										}
										$pagination.= "...";
										$pagination.= "<a href=\"$targetpage?page=$lpm1\" style='margin:0 0 0 2px; color:#3b3b3c;'>$lpm1</a>";
										$pagination.= "<a href=\"$targetpage?page=$lastpage\" style='margin:0 0 0 2px; color:#3b3b3c;'>$lastpage</a>";		
									}
									//close to end; only hide early pages
									else
									{
										$pagination.= "<a href=\"$targetpage?page=1\" style='margin:0 0 0 2px; color:#3b3b3c;'>1</a>";
										$pagination.= "<a href=\"$targetpage?page=2\" style='margin:0 0 0 2px; color:#3b3b3c;'>2</a>";
										$pagination.= "...";
										for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
										{
											if ($counter == $page)
												$pagination.= "<span class=\"current\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</span>";
											else
												$pagination.= "<a href=\"$targetpage?page=$counter\" style='margin:0 0 0 2px; color:#3b3b3c;'>$counter</a>";					
										}
									}
								}
								
								//next button
								if ($page < $counter - 1) 
									$pagination.= "<a href=\"$targetpage?page=$next\" style='margin:0 0 0 2px; color:#3b3b3c;'>next</a>";
								else
									$pagination.= "<span class=\"disabled\" style='margin:0 0 0 2px; color:#3b3b3c;'>next</span>";
								echo $pagination.= "</div>\n";		
							}
						}
						?>
						</span></td>
                      </tr>
                      <tr>
                        <td colspan="16" class="bodytext13">
						<input name="search1" type="text" id="search1" size="40" value="<?php echo $search1; ?>">
						<input type="hidden" name="searchflag1" id="searchflag1" value="searchflag1">
                          <input type="submit" name="Submit2" value="Search" /></td>
                        </tr>
                      <tr>
                        <td width="5%"  class="bodytext12"><div align="center"><strong>Delete</strong></div></td>
                        <td width="7%"  class="bodytext12"><strong>ID / Code </strong></td>
                        <td width="14%"  class="bodytext12"><strong>Category</strong></td>
                        <td width="27%"  class="bodytext12"><strong>lab Item</strong></td>
                        <td width="4%"  class="bodytext12"><strong>Unit</strong></td>
                        <td width="9%"  class="bodytext12"><strong>Sample Type</strong></td>
						 <td width="9%"  class="bodytext12"><strong>Reference</strong></td>
						  <td width="9%"  class="bodytext12"><strong>Ref.Unit</strong></td>
						   <td width="9%"  class="bodytext12"><strong>Range</strong></td>
                        <td width="9%"  class="bodytext12"><div align="center"><strong>Tax%</strong></div></td>
						 <td width="9%"  class="bodytext12"><div align="center"><strong>IP Markup</strong></div></td>
                        <td width="10%"  class="bodytext12"><div align="center"><strong>Charges</strong></div></td>
						 <td width="10%"  class="bodytext12"><div align="center"><strong>Rate2</strong></div></td>
						  <td width="10%"  class="bodytext12"><div align="center"><strong>Rate3</strong></div></td>
						 <td width="10%"  class="bodytext12"><div align="center"><strong>Location</strong></div></td>
                        <td width="4%"  class="bodytext12"><div align="center"><strong>Edit</strong></div></td>
                      </tr>
                      <?php
	  if ($searchflag1 == 'searchflag1')
	  {
					  
		$search1 = $_REQUEST["search1"];			  
	    $query1 = "select * from master_lab where itemname like '%$search1%' or categoryname like '%$search1%' and status <> 'deleted' group by itemcode order by auto_number desc LIMIT 100";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		while ($res1 = mysql_fetch_array($exec1))
		{
		$itemcode = $res1["itemcode"];
		$itemname = $res1["itemname"];
		$categoryname = $res1["categoryname"];
		$purchaseprice = $res1["purchaseprice"];
		$sampletype= $res1["sampletype"];
		$rateperunit = $res1["rateperunit"];
		$expiryperiod = $res1["expiryperiod"];
		$auto_number = $res1["auto_number"];
		$itemname_abbreviation = $res1["itemname_abbreviation"];
		$taxname = $res1["taxname"];
		$taxanum = $res1["taxanum"];
		$ipmarkup = $res1["ipmarkup"];
		$location = $res1["locationname"];
		$referencename = $res1['referencename'];
		$referenceunit = $res1['referenceunit'];
		$referencerange = $res1['referencerange'];
		$rate2 = $res1['rate2'];
		$rate3 = $res1['rate3'];
		if ($expiryperiod != '0') 
		{ 
			$expiryperiod = $expiryperiod.' Months'; 
		}
		else
		{
			$expiryperiod = ''; 
		}
	 
		$query6 = "select * from master_tax where auto_number = '$taxanum'";
		$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
		$res6 = mysql_fetch_array($exec6);
		$res6taxpercent = $res6["taxpercent"];
		
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
                        <td align="left" valign="top" class="bodytext13"><div align="center"><a href="labitem1.php?st=del&&anum=<?php echo $auto_number; ?>"><img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>
                        <td align="left" valign="top"  class="bodytext13"><?php echo $itemcode; ?> </td>
                        <td align="left" valign="top"  class="bodytext13"><?php echo $categoryname; ?> </td>
                        <td align="left" valign="top"  class="bodytext13"><?php echo $itemname; ?> </td>
                        <td align="left" valign="top"  class="bodytext13"><?php echo $itemname_abbreviation; ?> </td>
						 <td align="left" valign="top"  class="bodytext13"><?php echo $sampletype; ?> </td>
						  <td align="left" valign="top"  class="bodytext13"><?php echo $referencename; ?> </td>
						   <td align="left" valign="top"  class="bodytext13"><?php echo $referenceunit; ?> </td>
						    <td align="left" valign="top"  class="bodytext13"><?php echo $referencerange; ?> </td>
                      <td align="left" valign="top"  class="bodytext13"><?php echo $res6taxpercent; ?> </td>
					   <td align="left" valign="top"  class="bodytext13"><?php echo $ipmarkup; ?> </td>
                       
                        <td align="left" valign="top"  class="bodytext13"><div align="right"><?php echo $rateperunit; ?></div></td>
						<td align="left" valign="top"  class="bodytext13"><div align="right"><?php echo $rate2; ?></div></td>
						<td align="left" valign="top"  class="bodytext13"><div align="right"><?php echo $rate3; ?></div></td>
						 <td align="left" valign="top"  class="bodytext13"><div align="right"><?php echo $location; ?></div></td>
                        <td width="4%" align="left" valign="top"  class="bodytext13">
						  <div align="center">
						  <a href="edititem1lab.php?sanum=<?php echo $auto_number; ?>&&itemcode=<?php echo $itemcode; ?>" class="bodytext13">Edit</a></div></td>
                      </tr>
                      <?php
		}
	}
	else
	{
	$query1 = "select * from master_lab where status <> 'deleted' group by itemcode order by auto_number desc LIMIT $start , $limit";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		while ($res1 = mysql_fetch_array($exec1))
		{
		$itemcode = $res1["itemcode"];
		$itemname = $res1["itemname"];
		$categoryname = $res1["categoryname"];
		$purchaseprice = $res1["purchaseprice"];
		$sampletype= $res1["sampletype"];
		$rateperunit = $res1["rateperunit"];
		$expiryperiod = $res1["expiryperiod"];
		$auto_number = $res1["auto_number"];
		$itemname_abbreviation = $res1["itemname_abbreviation"];
		$taxname = $res1["taxname"];
		$taxanum = $res1["taxanum"];
		$ipmarkup = $res1["ipmarkup"];
		$location = $res1["locationname"];
		$referencename = $res1['referencename'];
		$referenceunit = $res1['referenceunit'];
		$referencerange = $res1['referencerange'];
		$rate2 = $res1['rate2'];
		$rate3 = $res1['rate3'];
		if ($expiryperiod != '0') 
		{ 
			$expiryperiod = $expiryperiod.' Months'; 
		}
		else
		{
			$expiryperiod = ''; 
		}
		
		 $query6 = "select * from master_tax where auto_number = '$taxanum'";
		$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
		$res6 = mysql_fetch_array($exec6);
		$res6taxpercent = $res6["taxpercent"];
		
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
                        <td align="left" valign="top"  class="bodytext13"><div align="center"><a href="labitem1.php?st=del&&anum=<?php echo $auto_number; ?>"><img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>
                        <td align="left" valign="top"  class="bodytext13"><?php echo $itemcode; ?> </td>
                        <td align="left" valign="top"  class="bodytext13"><?php echo $categoryname; ?> </td>
                        <td align="left" valign="top"  class="bodytext13"><?php echo $itemname; ?> </td>
                        <td align="left" valign="top"  class="bodytext13"><?php echo $itemname_abbreviation; ?> </td>
                        <td align="left" valign="top"  class="bodytext13"><?php echo $sampletype; ?> </td>
						  <td align="left" valign="top"  class="bodytext13"><?php echo $referencename; ?> </td>
						   <td align="left" valign="top"  class="bodytext13"><?php echo $referenceunit; ?> </td>
						    <td align="left" valign="top"  class="bodytext13"><?php echo $referencerange; ?> </td>
                     
						 <td align="left" valign="top"  class="bodytext13"><?php echo $res6taxpercent; ?> </td>
					   <td align="left" valign="top"  class="bodytext13"><?php echo $ipmarkup; ?> </td>
                   
                        
                        <td align="left" valign="top"  class="bodytext13"><div align="right"><?php echo $rateperunit; ?></div></td>
						<td align="left" valign="top"  class="bodytext13"><div align="right"><?php echo $rate2; ?></div></td>
						<td align="left" valign="top"  class="bodytext13"><div align="right"><?php echo $rate3; ?></div></td>
						<td align="left" valign="top"  class="bodytext13"><div align="right"><?php echo $location; ?></div></td>
                        <td align="left" valign="top"  class="bodytext13">
						  <div align="center">
						  <a href="edititem1lab.php?sanum=<?php echo $auto_number; ?>&&itemcode=<?php echo $itemcode; ?>" class="bodytext13">Edit</a></div></td>
                      </tr>
                      <?php
		}
	}
		?>
                    </tbody>
                  </table>
				  </form>
				  <br>
				  
 				  <form>
                <table width="1200" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr>
                        <td colspan="15" class="bodytext11"><strong>Lab Item Master - Deleted </strong></td>
                      </tr>
                      <tr>
                        <td colspan="15" class="bodytext13"><span class="bodytext13">
                          <input name="search2" type="text" id="search2" size="40" value="<?php echo $search2; ?>">
                          <input type="hidden" name="searchflag2" id="searchflag2" value="searchflag2">
                          <input type="submit" name="Submit22" value="Search"/>
                        </span></td>
                        </tr>
                      <tr>
						<td width="6%"  class="bodytext12"><div align="center"><strong>Activate</strong></div></td>
						<td width="10%"  class="bodytext12"><strong>ID / Code </strong></td>
						<td width="13%"  class="bodytext12"><strong>Category</strong></td>
						<td width="17%"  class="bodytext12"><strong>lab Item</strong></td>
						<td width="6%"  class="bodytext12"><strong>Unit</strong></td>
						<td width="9%"  class="bodytext12"><strong>Sample Type</strong></td>
						<td width="9%"  class="bodytext12"><strong>Reference</strong></td>
						<td width="9%"  class="bodytext12"><strong>Ref.Unit</strong></td>
						<td width="9%"  class="bodytext12"><strong>Range</strong></td>
						<td width="9%"  class="bodytext12"><div align="center"><strong>Tax%</strong></div></td>
						<td width="9%"  class="bodytext12"><div align="center"><strong>IP Markup</strong></div></td>
						<td width="8%"  class="bodytext12"><strong>Charges</strong></td>
						<td width="10%"  class="bodytext12"><div align="center"><strong>Rate2</strong></div></td>
						<td width="10%"  class="bodytext12"><div align="center"><strong>Rate3</strong></div></td>
						<td width="11%"  class="bodytext12"><strong>Location</strong></td>
                      </tr>
                      <?php
		if (isset($_REQUEST["searchflag2"])) { $searchflag2 = $_REQUEST["searchflag2"]; } else { $searchflag2 = ""; }
	  if ($searchflag2 == 'searchflag2')
	  {
					  
		$search2 = $_REQUEST["search2"];			  
	    $query1 = "select * from master_lab where itemname like '%$search2%' or categoryname like '%$search1%' and status = 'deleted' group by itemcode order by auto_number desc LIMIT 100";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		while ($res1 = mysql_fetch_array($exec1))
		{
		$itemcode = $res1["itemcode"];
		$itemname = $res1["itemname"];
		$categoryname = $res1["categoryname"];
		$purchaseprice = $res1["purchaseprice"];
		$sampletype= $res1["sampletype"];
		$rateperunit = $res1["rateperunit"];
		$expiryperiod = $res1["expiryperiod"];
		$auto_number = $res1["auto_number"];
		$itemname_abbreviation = $res1["itemname_abbreviation"];
		$taxname = $res1["taxname"];
		$taxanum = $res1["taxanum"];
		$ipmarkup = $res1["ipmarkup"];
		$location = $res1["locationname"];
		$referencename = $res1['referencename'];
		$referenceunit = $res1['referenceunit'];
		$referencerange = $res1['referencerange'];
		$rate2 = $res1['rate2'];
		$rate3 = $res1['rate3'];
		if ($expiryperiod != '0') 
		{ 
			$expiryperiod = $expiryperiod.' Months'; 
		}
		else
		{
			$expiryperiod = ''; 
		}
		
		$query6 = "select * from master_tax where auto_number = '$taxanum'";
		$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
		$res6 = mysql_fetch_array($exec6);
		$res6taxpercent = $res6["taxpercent"];
		
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
		<td align="left" valign="top"  class="bodytext13">
		<a href="labitem1.php?st=activate&&anum=<?php echo $auto_number; ?>" class="bodytext13">
		<div align="center" class="bodytext13">Activate</div>
		</a></td>
		<td align="left" valign="top"  class="bodytext13"><?php echo $itemcode; ?> </td>
		<td align="left" valign="top"  class="bodytext13"><?php echo $categoryname; ?> </td>
		<td align="left" valign="top"  class="bodytext13"><?php echo $itemname; ?></td>
		<td align="left" valign="top"  class="bodytext13"><?php echo $itemname_abbreviation; ?></td>
		
		<td align="left" valign="top"  class="bodytext13"><?php echo $sampletype; ?></td>
		<td align="left" valign="top"  class="bodytext13"><?php echo $referencename; ?> </td>
		<td align="left" valign="top"  class="bodytext13"><?php echo $referenceunit; ?> </td>
		<td align="left" valign="top"  class="bodytext13"><?php echo $referencerange; ?> </td>
		
		<td align="left" valign="top"  class="bodytext13"><?php echo $res6taxpercent; ?> </td>
		<td align="left" valign="top"  class="bodytext13"><?php echo $ipmarkup; ?> </td>
		
		<td align="left" valign="top"  class="bodytext13"><div align="right"><span class="bodytext13"><?php echo $rateperunit; ?></span></div></td>
		<td align="left" valign="top"  class="bodytext13"><div align="right"><?php echo $rate2; ?></div></td>
		<td align="left" valign="top"  class="bodytext13"><div align="right"><?php echo $rate3; ?></div></td>
		<td align="left" valign="top"  class="bodytext13"><?php echo $location; ?> </td>
		</tr>
                      <?php
		}
	}
	else
	{
		
	    $query1 = "select * from master_lab where status = 'deleted' group by itemcode order by auto_number desc LIMIT 100";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		while ($res1 = mysql_fetch_array($exec1))
		{
		$itemcode = $res1["itemcode"];
		$itemname = $res1["itemname"];
		$categoryname = $res1["categoryname"];
		$purchaseprice = $res1["purchaseprice"];
		$sampletype= $res1["sampletype"];
		$rateperunit = $res1["rateperunit"];
		$expiryperiod = $res1["expiryperiod"];
		$auto_number = $res1["auto_number"];
		$itemname_abbreviation = $res1["itemname_abbreviation"];
		$ipmarkup = $res1["ipmarkup"];
		$location = $res1["locationname"];
		$referencename = $res1['referencename'];
		$referenceunit = $res1['referenceunit'];
		$referencerange = $res1['referencerange'];
		$rate2 = $res1['rate2'];
		$rate3 = $res1['rate3'];
		$taxname = $res1["taxname"];
		$taxanum = $res1["taxanum"];
		if ($expiryperiod != '0') 
		{ 
			$expiryperiod = $expiryperiod.' Months'; 
		}
		else
		{
			$expiryperiod = ''; 
		}
		
		$query6 = "select * from master_tax where auto_number = '$taxanum'";
		$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
		$res6 = mysql_fetch_array($exec6);
		$res6taxpercent = $res6["taxpercent"];
		
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
		<td align="left" valign="top" class="bodytext13">
		<a href="labitem1.php?st=activate&&anum=<?php echo $auto_number; ?>" class="bodytext13">
		<div align="center" class="bodytext13">Activate</div>
		</a></td>
		<td align="left" valign="top"  class="bodytext13"><?php echo $itemcode; ?> </td>
		<td align="left" valign="top"  class="bodytext13"><?php echo $categoryname; ?> </td>
		<td align="left" valign="top"  class="bodytext13"><?php echo $itemname; ?></td>
		<td align="left" valign="top"  class="bodytext13"><?php echo $itemname_abbreviation; ?></td>
		
		<td align="left" valign="top"  class="bodytext13"><?php echo $sampletype; ?></td>
		<td align="left" valign="top"  class="bodytext13"><?php echo $referencename; ?> </td>
		<td align="left" valign="top"  class="bodytext13"><?php echo $referenceunit; ?> </td>
		<td align="left" valign="top"  class="bodytext13"><?php echo $referencerange; ?> </td>
		
		<td align="left" valign="top"  class="bodytext13"><?php echo $res6taxpercent; ?> </td>
		<td align="left" valign="top"  class="bodytext13"><?php echo $ipmarkup; ?> </td>
		
		<td align="left" valign="top"  class="bodytext13"><div align="right"><span class="bodytext132"><?php echo $rateperunit; ?></span></div></td>
		<td align="left" valign="top"  class="bodytext13"><div align="right"><?php echo $rate2; ?></div></td>
		<td align="left" valign="top"  class="bodytext13"><div align="right"><?php echo $rate3; ?></div></td>
		<td align="left" valign="top"  class="bodytext13"><?php echo $location; ?> </td>
		</tr>
                      <?php
		}
	}
		?>
                      <tr>
                        <td colspan="9" align="middle" >&nbsp;</td>
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

