<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";

//to redirect if there is no entry in masters category or item.



if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{

		foreach($_POST['reference'] as $key => $value)
	{
	$reference = $_POST['reference'][$key];
	$units = $_POST['units'][$key];
	$range = $_POST['range'][$key];
	
	$itemcode = $_REQUEST['itemcode'];		
	$itemname = $_REQUEST["itemname"];
	//$itemname = strtoupper($itemname);
	$itemname = trim($itemname);
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
	
	$categoryname = $_REQUEST["categoryname"];
	$purchaseprice  = $_REQUEST["purchaseprice"];
	$rateperunit  = $_REQUEST["rateperunit"];
	$expiryperiod = '';
	$description=$_REQUEST["description"];
	$sampletype=$_REQUEST["sampletype"];
	$referencevalue = $_REQUEST["referencevalue"];
	$itemname_abbreviation = $_REQUEST["unitname_abbreviation"];
	$taxanum = $_REQUEST["taxanum"];
	$ipmarkup = $_REQUEST["ipmarkup"];
	$location = $_REQUEST["location"];
	$rate2 = $_REQUEST['rate2'];
	$rate3 = $_REQUEST['rate3'];
	$extrate = $_REQUEST['extrate'];
	if (isset($_REQUEST["externallab"])) { $externallab = $_REQUEST["externallab"]; } else { $externallab = ""; }
	
	$query1 = "select * from master_tax where auto_number = '$taxanum' and status <> 'deleted' order by taxname";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	$res1 = mysql_fetch_array($exec1);
	$res4taxname = $res1["taxname"];
	
	if ($length1<25 && $length2<255)
	{
		if($reference != '')
	{
	$query1 = "insert into master_lab (itemcode, itemname, categoryname, itemname_abbreviation, rateperunit, expiryperiod, taxanum, taxname, ipaddress, updatetime, description, purchaseprice, referencevalue,ipmarkup,sampletype,location,referencename,referenceunit,referencerange,rate2,rate3,externallab,externalrate) 
			values ('$itemcode', '$itemname', '$categoryname', '$itemname_abbreviation', '$rateperunit', '$expiryperiod', '$taxanum', '$res4taxname', '$ipaddress', '$updatedatetime','manual', '$purchaseprice', '$referencevalue','$ipmarkup','$sampletype','$location','$reference','$units','$range','$rate2','$rate3','$externallab','$extrate')";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());	
	}
	$query24 = "select * from master_lab where itemcode = '$itemcode'";// or itemname = '$itemname'";
		$exec24 = mysql_query($query24) or die ("Error in Query24".mysql_error());
		$res24 = mysql_num_rows($exec24);
		if($res24 == 0)
	{
		$query1 = "insert into master_lab (itemcode, itemname, categoryname, itemname_abbreviation, rateperunit, expiryperiod, taxanum, taxname, ipaddress, updatetime, description, purchaseprice, referencevalue,ipmarkup,sampletype,location,rate2,rate3,externallab,externalrate) 
			values ('$itemcode', '$itemname', '$categoryname', '$itemname_abbreviation', '$rateperunit', '$expiryperiod', '$taxanum', '$res4taxname', '$ipaddress', '$updatedatetime','manual', '$purchaseprice', '$referencevalue','$ipmarkup','$sampletype','$location','$rate2','$rate3','$externallab','$extrate')";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		}
	
		 /*<?php?>$query1 = "insert into master_renewal (itemcode, itemname, renewalmonths, ipaddress, updatetime) 
			values ('$itemcode', '$itemname', '0', '$ipaddress', '$updatedatetime')";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());<?php ?>*/
	
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
else
{
	$itemname = '';
	$rateperunit  = '0.00';
	$purchaseprice  = '0.00';
	$description='';
	$referencevalue = '';
	}
	
	//$itemcode = '';
	$query1 = "select * from master_lab where description='manual' order by auto_number desc limit 0, 1";
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
			return false;
		}
	}
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
<body onLoad="return process2()">
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
              <td><form name="form1" id="form1" method="post" action="labitem1.php" onSubmit="return additem1process1()">
                  <table width="900" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="4" bgcolor="#CCCCCC" class="bodytext3"><strong>Lab Item Master - Add New </strong></td>
                      </tr>
					  <?php if ($st==1)
					  {?>
					  <tr>
                        <td colspan="4" align="left" valign="middle"   bgcolor="#AAFF00"><font size="2">Sorry Special Characters Are Not Allowed</font></div></td>
                      </tr>
					  <?php }?>
                      <tr>
                        <td colspan="4" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; }else if ($bgcolorcode == 'fail') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?>&nbsp;</div></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><div align="left">Select Category Name  </div></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0">
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
                          <a href="labcategory1.php"><font  class="bodytext32" color="#000000">(Click Here To Add New Category)</font></a>                          </td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3">External Lab</td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><input type="checkbox" name="externallab"></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"> <div align="left">New Lab Item Code </div></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><input name="itemcode" value="<?php echo $itemcode; ?>" id="itemcode" readonly="readonly" onKeyDown="return process1backkeypress1()" style="border: 1px solid #001E6A; background-color:#CCCCCC" size="20" maxlength="100" />
                          <span class="bodytext32">( Example : PRD1234567890 ) </span></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3">Ext Rate </td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><input name="extrate" id="extrate" style="border: 1px solid #001E6A" size="20" /></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><div align="left">Add New Lab Item Name </div></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><input name="itemname" type="text" id="itemname" style="border: 1px solid #001E6A" onChange="return spl()" value="<?php echo $itemname; ?>" size="45"></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext32">Exclude</span></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><input type="checkbox" name="exclude"></td>
                      </tr>
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><div align="left">Select Lab Item Unit (Optional)  </div></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><input name="unitname_abbreviation" type="text" id="unitname_abbreviation" value="" size="20" style="border: 1px solid #001E6A"></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext32">IP Mark up</span></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><input type="text" name="ipmarkup" style="border: 1px solid #001E6A; "></td></tr>
				    <tr>
                        <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><div align="left">Lab Item Reference Value (Optional) </div></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><textarea name="referencevalue" cols="35" id="referencevalue" style="border: 1px solid #001E6A"><?php echo $referencevalue; ?></textarea>
                          <input name="description" type="hidden" id="description" style="border: 1px solid #001E6A" value="<?php echo $description; ?>" size="60"></td>
                     <td align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext32">Sample Type</span></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><input name="sampletype" id="sampletype" style="border: 1px solid #001E6A" value="" size="20" /></td>
                       </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><div align="left">Select Applicable Tax </div></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><select id="taxanum" name="taxanum">
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
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><span class="bodytext32">Location</span></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><input type="text" name="location" style="border: 1px solid #001E6A"></td>
                      </tr>
                
                     <tr>
                        <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><div align="left">Charge  Price  Per Unit </div></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><input name="rateperunit" id="rateperunit" style="border: 1px solid #001E6A" value="<?php echo $rateperunit; ?>" size="20" />
                          <input type="hidden" name="purchaseprice" id="purchaseprice" style="border: 1px solid #001E6A" value="<?php echo $purchaseprice; ?>" size="20" /></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0">&nbsp;</td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0">&nbsp;</td>
                      </tr>
					 <tr>
                        <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><div align="left">Rate2 </div></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><input name="rate2" id="rate2" style="border: 1px solid #001E6A" value="<?php echo $rateperunit; ?>" size="20" />                          </td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0">&nbsp;</td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0">&nbsp;</td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><div align="left">Rate3 </div></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><input name="rate3" id="rate3" style="border: 1px solid #001E6A" value="<?php echo $rateperunit; ?>" size="20" />                          </td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0">&nbsp;</td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0">&nbsp;</td>
                      </tr>

					 <tr>
	   <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Add Reference</strong></td>
	  </tr> 
	  <tr id="pressid">
				   <td colspan="11" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
				   <table id="presid" width="400" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="150" class="bodytext3">Reference</td>
                       <td width="48" class="bodytext3">Unit</td>
                       <td width="41" class="bodytext3">Range</td>
                     </tr>
					 <tr>
					 <div id="insertrow">					 </div></tr>
                     <tr>
					  <input type="hidden" name="serialnumber" id="serialnumber" value="1">
					  <input type="hidden" name="medicinecode" id="medicinecode" value="">
                       <td><input name="reference[]" type="text" id="reference" size="25" autocomplete="off"></td>
                       <td><input name="units[]" type="text" id="units" size="8" autocomplete="off"></td>
                       	
                       <td><input name="range[]" type="text" id="range" size="8" autocomplete="off"></td>
                       
                       <td><label>
                       <input type="button" name="Add" id="Add" value="Add" onClick="return insertitem10()" class="button" style="border: 1px solid #001E6A">
                       </label></td>
					   </tr>
                     
					 <input type="hidden" name="h" id="h" value="0">
                   </table>				  </td>
			       </tr>
	   <tr>
                        <td width="21%" align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
                        <td width="37%" align="left" valign="top"  bgcolor="#E0E0E0"><input type="hidden" name="frmflag" value="addnew" />
                          <input type="hidden" name="frmflag1" value="frmflag1" />
                          <input type="submit" name="Submit" value="Save Lab Item" style="border: 1px solid #001E6A" /></td>
                        <td width="14%" align="left" valign="top"  bgcolor="#E0E0E0">&nbsp;</td>
                        <td width="28%" align="left" valign="top"  bgcolor="#E0E0E0">&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
				  </form>
				  <form>
                <table width="1300" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="12" bgcolor="#CCCCCC" class="bodytext3"><span class="bodytext32"><strong>Lab Item Master - Existing List - Latest 100 Lab Items </strong></span></td>
						<td colspan="6" bgcolor="#CCCCCC" class="bodytext3"><span class="bodytext32">
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
                      <tr bgcolor="#011E6A">
                        <td colspan="18" bgcolor="#FFFFFF" class="bodytext3">
						<input name="search1" type="text" id="search1" size="40" value="<?php echo $search1; ?>">
						<input type="hidden" name="searchflag1" id="searchflag1" value="searchflag1">
                          <input type="submit" name="Submit2" value="Search" style="border: 1px solid #001E6A" /></td>
                        </tr>
                      <tr bgcolor="#011E6A">
                        <td width="5%" bgcolor="#CCCCCC" class="bodytext3"><div align="center"><strong>Delete</strong></div></td>
                        <td width="7%" bgcolor="#CCCCCC" class="bodytext3"><strong>ID / Code </strong></td>
                        <td width="14%" bgcolor="#CCCCCC" class="bodytext3"><strong>Category</strong></td>
                        <td width="27%" bgcolor="#CCCCCC" class="bodytext3"><strong>lab Item</strong></td>
                        <td width="4%" bgcolor="#CCCCCC" class="bodytext3"><strong>Unit</strong></td>
                        <td width="9%" bgcolor="#CCCCCC" class="bodytext3"><strong>Sample Type</strong></td>
						 <td width="9%" bgcolor="#CCCCCC" class="bodytext3"><strong>Reference</strong></td>
						  <td width="9%" bgcolor="#CCCCCC" class="bodytext3"><strong>Ref.Unit</strong></td>
						   <td width="9%" bgcolor="#CCCCCC" class="bodytext3"><strong>Range</strong></td>
                        <td width="9%" bgcolor="#CCCCCC" class="bodytext3"><div align="center"><strong>Tax%</strong></div></td>
						 <td width="9%" bgcolor="#CCCCCC" class="bodytext3"><div align="center"><strong>IP Markup</strong></div></td>
                        <td width="10%" bgcolor="#CCCCCC" class="bodytext3"><div align="center"><strong>Charges</strong></div></td>
						 <td width="10%" bgcolor="#CCCCCC" class="bodytext3"><div align="center"><strong>Rate2</strong></div></td>
						  <td width="10%" bgcolor="#CCCCCC" class="bodytext3"><div align="center"><strong>Rate3</strong></div></td>
						 <td width="10%" bgcolor="#CCCCCC" class="bodytext3"><div align="center"><strong>Location</strong></div></td>
						  <td width="10%" bgcolor="#CCCCCC" class="bodytext3"><div align="center"><strong>External</strong></div></td>
						  <td width="10%" bgcolor="#CCCCCC" class="bodytext3"><div align="center"><strong>Ext Rate</strong></div></td>
                        <td width="4%" bgcolor="#CCCCCC" class="bodytext3"><div align="center"><strong>Edit</strong></div></td>
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
		$location = $res1["location"];
		$referencename = $res1['referencename'];
		$referenceunit = $res1['referenceunit'];
		$referencerange = $res1['referencerange'];
		$rate2 = $res1['rate2'];
		$rate3 = $res1['rate3'];
		$externallab = $res1['externallab'];
		if($externallab == 'on')
		{
		$externallab = 'Yes';
		}
		else
		{
		$externallab = 'No';
		}
		$externalrate = $res1['externalrate'];
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
		<td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="center"><a href="labitem1.php?st=del&&anum=<?php echo $auto_number; ?>"><img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $itemcode; ?> </td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $categoryname; ?> </td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $itemname; ?> </td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $itemname_abbreviation; ?> </td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $sampletype; ?> </td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $referencename; ?> </td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $referenceunit; ?> </td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $referencerange; ?> </td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $res6taxpercent; ?> </td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $ipmarkup; ?> </td>
		
		<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rateperunit; ?></div></td>
		<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rate2; ?></div></td>
		<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rate3; ?></div></td>
		<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $location; ?></div></td>
		<td align="left" valign="top"  class="bodytext3"><div align="left"><?php echo $externallab; ?></div></td>
		<td align="left" valign="top"  class="bodytext3"><div align="left"><?php echo $externalrate; ?></div></td>
		<td width="4%" align="left" valign="top"  class="bodytext3">
						  <div align="center">
						  <a href="edititem1lab.php?sanum=<?php echo $auto_number; ?>&&itemcode=<?php echo $itemcode; ?>" class="bodytext3">Edit</a></div></td>
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
		$location = $res1["location"];
		$referencename = $res1['referencename'];
		$referenceunit = $res1['referenceunit'];
		$referencerange = $res1['referencerange'];
		$rate2 = $res1['rate2'];
		$rate3 = $res1['rate3'];
		$externallab = $res1['externallab'];
		if($externallab == 'on')
		{
		$externallab = 'Yes';
		}
		else
		{
		$externallab = 'No';
		}
		$externalrate = $res1['externalrate'];
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
                        <td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3"><div align="center"><a href="labitem1.php?st=del&&anum=<?php echo $auto_number; ?>"><img src="images/b_drop.png" width="16" height="16" border="0" /></a></div></td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemcode; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $categoryname; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemname; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $itemname_abbreviation; ?> </td>
                        <td align="left" valign="top"  class="bodytext3"><?php echo $sampletype; ?> </td>
						  <td align="left" valign="top"  class="bodytext3"><?php echo $referencename; ?> </td>
						   <td align="left" valign="top"  class="bodytext3"><?php echo $referenceunit; ?> </td>
						    <td align="left" valign="top"  class="bodytext3"><?php echo $referencerange; ?> </td>
                     
						 <td align="left" valign="top"  class="bodytext3"><?php echo $res6taxpercent; ?> </td>
					   <td align="left" valign="top"  class="bodytext3"><?php echo $ipmarkup; ?> </td>
                   
                        
                        <td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rateperunit; ?></div></td>
						<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rate2; ?></div></td>
						<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rate3; ?></div></td>
						<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $location; ?></div></td>
						<td align="left" valign="top"  class="bodytext3"><div align="left"><?php echo $externallab; ?></div></td>
						<td align="left" valign="top"  class="bodytext3"><div align="left"><?php echo $externalrate; ?></div></td>
                        <td align="left" valign="top"  class="bodytext3">
						  <div align="center">
						  <a href="edititem1lab.php?sanum=<?php echo $auto_number; ?>&&itemcode=<?php echo $itemcode; ?>" class="bodytext3">Edit</a></div></td>
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
                <table width="1300" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="17" bgcolor="#CCCCCC" class="bodytext3"><strong>lab Item Master - Deleted </strong></td>
                      </tr>
                      <tr bgcolor="#011E6A">
                        <td colspan="17" bgcolor="#FFFFFF" class="bodytext3"><span class="bodytext32">
                          <input name="search2" type="text" id="search2" size="40" value="<?php echo $search2; ?>">
                          <input type="hidden" name="searchflag2" id="searchflag2" value="searchflag2">
                          <input type="submit" name="Submit22" value="Search" style="border: 1px solid #001E6A" />
                        </span></td>
                        </tr>
                      <tr bgcolor="#011E6A">
						<td width="6%" bgcolor="#CCCCCC" class="bodytext3"><div align="center"><strong>Activate</strong></div></td>
						<td width="10%" bgcolor="#CCCCCC" class="bodytext3"><strong>ID / Code </strong></td>
						<td width="13%" bgcolor="#CCCCCC" class="bodytext3"><strong>Category</strong></td>
						<td width="17%" bgcolor="#CCCCCC" class="bodytext3"><strong>lab Item</strong></td>
						<td width="6%" bgcolor="#CCCCCC" class="bodytext3"><strong>Unit</strong></td>
						<td width="9%" bgcolor="#CCCCCC" class="bodytext3"><strong>Sample Type</strong></td>
						<td width="9%" bgcolor="#CCCCCC" class="bodytext3"><strong>Reference</strong></td>
						<td width="9%" bgcolor="#CCCCCC" class="bodytext3"><strong>Ref.Unit</strong></td>
						<td width="9%" bgcolor="#CCCCCC" class="bodytext3"><strong>Range</strong></td>
						<td width="9%" bgcolor="#CCCCCC" class="bodytext3"><div align="center"><strong>Tax%</strong></div></td>
						<td width="9%" bgcolor="#CCCCCC" class="bodytext3"><div align="center"><strong>IP Markup</strong></div></td>
						<td width="8%" bgcolor="#CCCCCC" class="bodytext3"><strong>Charges</strong></td>
						<td width="10%" bgcolor="#CCCCCC" class="bodytext3"><div align="center"><strong>Rate2</strong></div></td>
						<td width="10%" bgcolor="#CCCCCC" class="bodytext3"><div align="center"><strong>Rate3</strong></div></td>
						<td width="11%" bgcolor="#CCCCCC" class="bodytext3"><strong>Location</strong></td>
						<td width="11%" bgcolor="#CCCCCC" class="bodytext3"><strong>External</strong></td>
						<td width="11%" bgcolor="#CCCCCC" class="bodytext3"><strong>Ext Rate</strong></td>
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
		$location = $res1["location"];
		$referencename = $res1['referencename'];
		$referenceunit = $res1['referenceunit'];
		$referencerange = $res1['referencerange'];
		$rate2 = $res1['rate2'];
		$rate3 = $res1['rate3'];
		$externallab = $res1['externallab'];
		if($externallab == 'on')
		{
		$externallab = 'Yes';
		}
		else
		{
		$externallab = 'No';
		}
		if ($expiryperiod != '0') 
		{ 
			$expiryperiod = $expiryperiod.' Months'; 
		}
		else
		{
			$expiryperiod = ''; 
		}
		$externalrate = $res1['externalrate'];
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
		<td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">
		<a href="labitem1.php?st=activate&&anum=<?php echo $auto_number; ?>" class="bodytext3">
		<div align="center" class="bodytext3">Activate</div>
		</a></td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $itemcode; ?> </td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $categoryname; ?> </td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $itemname; ?></td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $itemname_abbreviation; ?></td>
		
		<td align="left" valign="top"  class="bodytext3"><?php echo $sampletype; ?></td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $referencename; ?> </td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $referenceunit; ?> </td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $referencerange; ?> </td>
		
		<td align="left" valign="top"  class="bodytext3"><?php echo $res6taxpercent; ?> </td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $ipmarkup; ?> </td>
		
		<td align="left" valign="top"  class="bodytext3"><div align="right"><span class="bodytext32"><?php echo $rateperunit; ?></span></div></td>
		<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rate2; ?></div></td>
		<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rate3; ?></div></td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $location; ?> </td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $externallab; ?> </td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $externalrate; ?> </td>
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
		$location = $res1["location"];
		$referencename = $res1['referencename'];
		$referenceunit = $res1['referenceunit'];
		$referencerange = $res1['referencerange'];
		$rate2 = $res1['rate2'];
		$rate3 = $res1['rate3'];
		$externallab = $res1['externallab'];
		if($externallab == 'on')
		{
		$externallab = 'Yes';
		}
		else
		{
		$externallab = 'No';
		}
	    
		if ($expiryperiod != '0') 
		{ 
			$expiryperiod = $expiryperiod.' Months'; 
		}
		else
		{
			$expiryperiod = ''; 
		}
		$externalrate = $res1['externalrate'];
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
		<td align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">
		<a href="labitem1.php?st=activate&&anum=<?php echo $auto_number; ?>" class="bodytext3">
		<div align="center" class="bodytext3">Activate</div>
		</a></td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $itemcode; ?> </td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $categoryname; ?> </td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $itemname; ?></td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $itemname_abbreviation; ?></td>
		
		<td align="left" valign="top"  class="bodytext3"><?php echo $sampletype; ?></td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $referencename; ?> </td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $referenceunit; ?> </td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $referencerange; ?> </td>
		
		<td align="left" valign="top"  class="bodytext3"><?php echo $res6taxpercent; ?> </td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $ipmarkup; ?> </td>
		
		<td align="left" valign="top"  class="bodytext3"><div align="right"><span class="bodytext32"><?php echo $rateperunit; ?></span></div></td>
		<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rate2; ?></div></td>
		<td align="left" valign="top"  class="bodytext3"><div align="right"><?php echo $rate3; ?></div></td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $location; ?> </td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $externallab; ?> </td>
		<td align="left" valign="top"  class="bodytext3"><?php echo $externalrate; ?> </td>
		</tr>
                      <?php
		}
	}
		?>
                      <tr>
                        <td colspan="11" align="middle" >&nbsp;</td>
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

