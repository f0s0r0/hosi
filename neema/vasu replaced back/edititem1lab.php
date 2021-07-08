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
$query90 = "select count(auto_number) as masterscount from master_lab";
$exec90 = mysql_query($query90) or die ("Error in Query90".mysql_error());
$res90 = mysql_fetch_array($exec90);
$res90count = $res90["masterscount"];
if ($res90count == 0)
{
	header ("location:addcategory1lab.php?svccount=firstentry");
}


if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
$code = $_REQUEST['itemcode'];
$query78 = "update master_lab set status='deleted' where itemcode='$code'";
$exec78 = mysql_query($query78) or die(mysql_error());

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
	if (isset($_REQUEST["externallab"])) { $externallab = $_REQUEST["externallab"]; } else { $externallab = ""; }
	$externallabrate = $_REQUEST['extrate'];
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
	if ($length1<25 && $length2<255)
	{
		if($reference != '')
	{
			$query11 = "insert into master_lab (itemcode, itemname, categoryname, itemname_abbreviation, rateperunit, expiryperiod, taxanum, taxname, ipaddress, updatetime, description, purchaseprice, referencevalue,ipmarkup,sampletype,location,referencename,referenceunit,referencerange,rate2,rate3,externallab,externalrate) 
			values ('$itemcode', '$itemname', '$categoryname', '$itemname_abbreviation', '$rateperunit', '$expiryperiod', '$taxanum', '$taxanum', '$ipaddress', '$updatedatetime','$description', '$purchaseprice', '$referencevalue','$ipmarkup','$sampletype','$location','$reference','$units','$range','$rate2','$rate3','$externallab','$externallabrate')";
			$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());	

	
			$query1 = "update master_lab set itemname='$itemname', categoryname='$categoryname', itemname_abbreviation='$itemname_abbreviation', rateperunit='$rateperunit', expiryperiod='$expiryperiod', taxanum='$taxanum', taxname='$taxanum', ipaddress='$ipaddress', updatetime='$updatedatetime',purchaseprice='$purchaseprice', referencevalue='$referencevalue',ipmarkup='$ipmarkup',sampletype='$sampletype',location='$location',rate2='$rate2',rate3='$rate3' where itemcode='$itemcode'";
	
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());	
	}
	else
	{

			$query1 = "update master_lab set itemname='$itemname', categoryname='$categoryname', itemname_abbreviation='$itemname_abbreviation', rateperunit='$rateperunit', expiryperiod='$expiryperiod', taxanum='$taxanum', taxname='$taxanum', ipaddress='$ipaddress', updatetime='$updatedatetime',purchaseprice='$purchaseprice', referencevalue='$referencevalue',ipmarkup='$ipmarkup',sampletype='$sampletype',location='$location',rate3='$rate3' where itemcode='$itemcode'";
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
			

		header("location:labitem1.php");
		
	
	}
	else
	{
		$errmsg = "Failed. lab Item Code Should Be 25 Characters And Name Should Be 255 Characters.";
		$bgcolorcode = 'failed';
	}
}	
//header("location:labitem1.php");
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
if (isset($_REQUEST["itemcode"])) { $itemcode = $_REQUEST["itemcode"]; } else { $itemcode = ""; }
		
	$query67 = "select * from master_lab where itemcode='$itemcode' and status <> 'deleted'";
	$exec67 = mysql_query($query67) or die(mysql_error());
	$res67 = mysql_fetch_array($exec67);
	$itemname = $res67['itemname'];
	$rate1 = $res67['rateperunit'];
	$rate2 = $res67['rate2'];
	$rate3 = $res67['rate3'];
	$ipmarkup = $res67['ipmarkup'];
	$location = $res67['location'];
	$sampletype = $res67['sampletype'];
    $unit = $res67['itemname_abbreviation'];
	$category= $res67['categoryname'];
	$taxanum = $res67['taxanum'];
	$taxname= $res67['taxname'];
	$externallab = $res67['externallab'];
	$externallabrate = $res67['externalrate'];

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
<link href="datepickerstyle.css" rel="stylesheet" type="text/css" />
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
	document.getElementById('insertrow').removeChild(child);
		
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
              <td><form name="form1" id="form1" method="post" action="edititem1lab.php" onSubmit="return additem1process1()">
                  <table width="900" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="4" bgcolor="#CCCCCC" class="bodytext3"><strong>Lab Item Master - Edit </strong></td>
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
                       <option value="" selected="selected">Select Category</option>
                    <?php
						if ($category != '')
						{
						?>
                    <option value="<?php echo $category; ?>" selected="selected"><?php echo $category; ?></option>
                    <?php
						}
						else
						{
						?>
                    <option value="" selected="selected">Select Category</option>
                    <?php
						}
						$query1 = "select * from master_lab where status <> 'deleted' group by categoryname order by categoryname";
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
						  <?php
						  if($externallab == 'on')
						  {
						  $externallab1 = "checked='checked'";
						  }
						  else
						  {
						  $externallab1 = '';
						  }
						  ?>
                        <td align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext32">External Lab</span></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><input type="checkbox" name="externallab" <?php echo $externallab1; ?>>						</td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"> <div align="left">New Lab Item Code </div></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><input name="itemcode" value="<?php echo $itemcode; ?>" id="itemcode" readonly="readonly" onKeyDown="return process1backkeypress1()" style="border: 1px solid #001E6A; background-color:#CCCCCC" size="20" maxlength="100" />
                          <span class="bodytext32">( Example : PRD1234567890 ) </span></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3">Ext Rate </td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><input name="extrate" id="extrate" style="border: 1px solid #001E6A" size="20" value="<?php echo $externallabrate; ?>"/></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><div align="left">Add New Lab Item Name </div></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><input name="itemname" type="text" id="itemname" style="border: 1px solid #001E6A" onChange="return spl()" value="<?php echo $itemname; ?>" size="45"></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext32">Exclude</span></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><input type="checkbox" name="exclude"></td>
                      </tr>
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><div align="left">Select Lab Item Unit (Optional)  </div></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><input name="unitname_abbreviation" type="text" id="unitname_abbreviation" size="20" style="border: 1px solid #001E6A" value="<?php echo $unit; ?>"></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext32">IP Mark up</span></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><input type="text" name="ipmarkup" style="border: 1px solid #001E6A; " value="<?php echo $ipmarkup; ?>"></td></tr>
				    <tr>
                        <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><div align="left">Lab Item Reference Value (Optional) </div></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><textarea name="referencevalue" cols="35" id="referencevalue" style="border: 1px solid #001E6A"><?php echo $referencevalue; ?></textarea>
                          <input name="description" type="hidden" id="description" style="border: 1px solid #001E6A" value="<?php echo $description; ?>" size="60"></td>
                     <td align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext32">Sample Type</span></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><input name="sampletype" id="sampletype" style="border: 1px solid #001E6A" value="<?php echo $sampletype ; ?>" size="20" /></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><div align="left">Select Applicable Tax </div></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><select id="taxanum" name="taxanum">
                         <option value="" selected="selected">Select Tax</option>
                    <?php
						if ($taxname != '')
						{
						?>
                    <option value="<?php echo $taxname; ?>" selected="selected"><?php echo $taxname; ?></option>
                    <?php
						}
						else
						{
						?>
                    <option value="" selected="selected">Select Tax</option>
                    <?php
						}
						$query2 = "select * from master_tax where status <> 'deleted' group by taxname order by taxname";
						$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
						while ($res2 = mysql_fetch_array($exec2))
						{
						$res1taxname = $res2["taxname"];
						
						?>
                    <option value="<?php echo $res1taxname; ?>"><?php echo $res1taxname; ?></option>
                    <?php
						}
						?>
                        </select></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><span class="bodytext32">Location</span></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><input type="text" name="location" style="border: 1px solid #001E6A" value="<?php echo $location; ?>"></td>
                      </tr>
                
                     <tr>
                        <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><div align="left">Charge  Price  Per Unit </div></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><input name="rateperunit" id="rateperunit" style="border: 1px solid #001E6A" value="<?php echo $rate1; ?>" size="20" />
                          <input type="hidden" name="purchaseprice" id="purchaseprice" style="border: 1px solid #001E6A" value="<?php echo $purchaseprice; ?>" size="20" /></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0">&nbsp;</td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0">&nbsp;</td>
                      </tr>
					 <tr>
                        <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><div align="left">Rate2 </div></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><input name="rate2" id="rate2" style="border: 1px solid #001E6A" value="<?php echo $rate2; ?>" size="20" />                          </td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0">&nbsp;</td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0">&nbsp;</td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><div align="left">Rate3 </div></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><input name="rate3" id="rate3" style="border: 1px solid #001E6A" value="<?php echo $rate3; ?>" size="20" /></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0">&nbsp;</td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0">&nbsp;</td>
                      </tr>
					 <tr>
	   <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Add Reference</strong></td>
	  </tr> 
	  
	  <tr id="pressid">
				   <td colspan="11" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
				   <table id="presid" width="300" border="0" cellspacing="1" cellpadding="1">
				   <tbody id="insertrow">
                     <tr>
                       <td width="150" class="bodytext3">Reference</td>
                       <td width="48" class="bodytext3">Unit</td>
                       <td width="41" class="bodytext3">Range</td>
                     </tr>
					 
					 <?php
				$itemcount = "";
				//To populate items already in the bill if in edit mode.
				include ('lab_edit1listing1.php');
				//value to initiate serial number if in edit mode.
				$itemcount = $itemcount;
				?>
				</tbody>
				</table>
				<tr>
				<td colspan="11" bgcolor="#E0E0E0" class="bodytext3">
				 <table border="0" cellspacing="1" cellpadding="1">
				 <tbody>
                     <tr>
					  <input type="hidden" name="serialnumber" id="serialnumber" value="<?php echo $itemcount+1; ?>">
					  <input type="hidden" name="medicinecode" id="medicinecode" value="">
                       <td><input name="reference[]" type="text" id="reference" size="25" autocomplete="off"></td>
                       <td><input name="units[]" type="text" id="units" size="8" autocomplete="off"></td>
                       	
                       <td><input name="range[]" type="text" id="range" size="8" autocomplete="off"></td>
                       
                       <td><label>
                       <input type="button" name="Add" id="Add" value="Add" onClick="return insertitem10()" class="button" style="border: 1px solid #001E6A">
                       </label></td>
					   </tr>
					 <input type="hidden" name="h" id="h" value="0">
					 </tbody>
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

