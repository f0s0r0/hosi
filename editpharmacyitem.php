<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$pkg=isset($_REQUEST['pkg'])?$_REQUEST['pkg']:'no';

//to redirect if there is no entry in masters category or item.
$query90 = "select count(auto_number) as masterscount from master_medicine";
$exec90 = mysql_query($query90) or die ("Error in Query90".mysql_error());
$res90 = mysql_fetch_array($exec90);
$res90count = $res90["masterscount"];
if ($res90count == 0)
{
	header ("location:addcategory1radiology.php?svccount=firstentry");
}


if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{

	$itemcode = $_REQUEST["itemcode"];
	$itemcode = strtoupper($itemcode);
	$itemcode = trim($itemcode);
	$itemname = $_REQUEST["itemname"];
	$genericname = $_REQUEST['genericname'];
	$disease = $_REQUEST['disease'];
	
	$minimumstock = $_REQUEST['minimumstock'];
	$maximumstock = $_REQUEST['maximumstock'];
	//$manufacturername = $_REQUEST['manufactureranum'];
	$rol = $_REQUEST['rol'];
	$roq = $_REQUEST['roq'];
	$ipmarkup = $_REQUEST['ipmarkup'];
	$spmarkup = $_REQUEST['spmarkup'];
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
		$errmsg="Sorry. pharmacy Item Not Added";
		
		header("location:pharmacyitem1.php?st=1");
		exit();
	}
	$itemname = addslashes($itemname);
	
	$categoryname = $_REQUEST["categoryname"];
	$purchaseprice  = $_REQUEST["costprice"];
	$rateperunit  = $_REQUEST["rateperunit2"];
	$expiryperiod = '';
	$description=$_REQUEST["description"];
	$itemname_abbreviation = $_REQUEST['packageanum'];
	$taxanum = $_REQUEST["taxanum"];
	$formula = $_REQUEST['formula'];
	$transfertype = $_REQUEST['transfertype'];
	$medtype = $_REQUEST['medtype'];
	$inventorytype = $_REQUEST['inventorytype'];
	
	if ($length1<25 && $length2<255)
	{
	$query4 = "select * from master_tax where auto_number = '$taxanum'";// and cstid='$custid' and cstname='$custname'";
		$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		$res4 = mysql_fetch_array($exec4);
		$res4taxname = $res4["taxname"];

		
		$res4packagename = $itemname_abbreviation;
		
		/*$query54 = "select * from master_manufacturerpharmacy where auto_number = '$manufacturername'";// and cstid='$custid' and cstname='$custname'";
		$exec54 = mysql_query($query54) or die ("Error in Query4".mysql_error());
		$res54 = mysql_fetch_array($exec54);
		$res4manufacturername = $res54["manufacturername"];*/

	
			$query1 = "update master_medicine set itemcode='$itemcode', itemname='$itemname', categoryname='$categoryname', unitname_abbreviation='$res4packagename', packagename='$res4packagename',rateperunit='$rateperunit', expiryperiod='$expiryperiod',
			 taxanum='$taxanum', taxname='$res4taxname', ipaddress='$ipaddress', updatetime='$updatedatetime', description='$description', purchaseprice='$purchaseprice',genericname='$genericname',exclude='$exclude',
			 minimumstock='$minimumstock',maximumstock='$maximumstock',rol='$rol',roq='$roq',ipmarkup='$ipmarkup',spmarkup='$spmarkup',formula='$formula',disease='$disease',pkg='".$pkg."', transfertype = '$transfertype', type = '$medtype', inventorytype='$inventorytype' where itemcode='$itemcode'";
			
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	
	       $query2 = "update master_itempharmacy set itemcode='$itemcode', itemname='$itemname', categoryname='$categoryname', unitname_abbreviation='$res4packagename', packagename='$res4packagename', rateperunit='$rateperunit', expiryperiod='$expiryperiod',
			 taxanum='$taxanum', taxname='$res4taxname', ipaddress='$ipaddress', updatetime='$updatedatetime', description='$description', purchaseprice='$purchaseprice',genericname='$genericname',exclude='$exclude',			 minimumstock='$minimumstock',maximumstock='$maximumstock',rol='$rol',roq='$roq',ipmarkup='$ipmarkup',spmarkup='$spmarkup',formula='$formula',disease='$disease',pkg='".$pkg."' where itemcode='$itemcode'";
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			
			$query2 = "update master_itempharmacy set itemcode='$itemcode', itemname='$itemname', categoryname='$categoryname', unitname_abbreviation='$res4packagename', packagename='$res4packagename', rateperunit='$rateperunit', expiryperiod='$expiryperiod',
			 taxanum='$taxanum', taxname='$res4taxname', ipaddress='$ipaddress', updatetime='$updatedatetime', description='$description', purchaseprice='$purchaseprice',genericname='$genericname',exclude='$exclude',			 minimumstock='$minimumstock',maximumstock='$maximumstock',rol='$rol',roq='$roq',ipmarkup='$ipmarkup',spmarkup='$spmarkup',formula='$formula',disease='$disease',pkg='".$pkg."' where itemcode='$itemcode'";
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			
			$query5 = "update master_itemtosupplier set itemname='$itemname' where itemcode='$itemcode'"; 
			$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
			
			$loccountloop=isset($_REQUEST['locationcount'])?$_REQUEST['locationcount']:'0';
			for($i=1; $i<=$loccountloop; $i++)
			{
				 $loccodeget=isset($_REQUEST['lcheck'.$i])?$_REQUEST['lcheck'.$i]:'';
				 $locrateget=isset($_REQUEST['locrate'.$i])?$_REQUEST['locrate'.$i]:'';	
				 			 
				 if($loccodeget!='')
				 {
					 $locationcolumn=$loccodeget.'_rateperunit';
					 $queryupdate1 = "UPDATE `master_medicine` SET  `$locationcolumn`= '$rateperunit' WHERE `master_medicine`.`itemcode` = '$itemcode'";
					 $execupdate1 = mysql_query($queryupdate1) or die ("Error in queryupdate1".mysql_error());
				 }
			}
		 /*<?php?>$query1 = "insert into master_renewal (itemcode, itemname, renewalmonths, ipaddress, updatetime) 
			values ('$itemcode', '$itemname', '0', '$ipaddress', '$updatedatetime')";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());<?php ?>*/
	
			$errmsg = "Success. pharmacy Item Updated.";
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
		$errmsg = "Failed. pharmacy Item Code Should Be 25 Characters And Name Should Be 255 Characters.";
		$bgcolorcode = 'failed';
	}
	header("location:pharmacyitem1.php");

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

	


if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_medicine set status = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
}
if ($st == 'activate')
{
	$delanum = $_REQUEST["anum"];
	$query3 = "update master_medicine set status = '' where auto_number = '$delanum'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
}


if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add pharmacy Item To Proceed For Billing.";
	$bgcolorcode = 'failed';
}

if (isset($_REQUEST["searchflag1"])) { $searchflag1 = $_REQUEST["searchflag1"]; } else { $searchflag1 = ""; }
if (isset($_REQUEST["searchflag2"])) { $searchflag2 = $_REQUEST["searchflag2"]; } else { $searchflag2 = ""; }
if (isset($_REQUEST["search1"])) { $search1 = $_REQUEST["search1"]; } else { $search1 = ""; }
if (isset($_REQUEST["search2"])) { $search2 = $_REQUEST["search2"]; } else { $search2 = ""; }


if (isset($_REQUEST["itemcode"])) { $itemcode = $_REQUEST["itemcode"]; } else { $itemcode = ""; }
$query65 = "select * from master_medicine where itemcode='$itemcode'";
$exec65 = mysql_query($query65) or die(mysql_error());
$res65 = mysql_fetch_array($exec65);
$itemname = $res65["itemname"];
		$categoryname = $res65["categoryname"];
		$purchaseprice = $res65["purchaseprice"];
		$rateperunit = $res65["rateperunit"];
		$expiryperiod = $res65["expiryperiod"];
		$auto_number = $res65["auto_number"];
		$itemname_abbreviation = $res65["unitname_abbreviation"];
		$taxname = $res65["taxname"];
		//$manufacturername = $res65["manufacturername"];
		$genericname = $res65["genericname"];
		$minimumstock = $res65["minimumstock"];
		$maximumstock = $res65["maximumstock"];
		$rol = $res65["rol"];
		$roq = $res65["roq"];
		$pkg = $res65["pkg"];
		$ipmarkup = $res65["ipmarkup"];
		$spmarkup = $res65["spmarkup"];
		$disease = $res65["disease"];
		$formula1 = $res65['formula'];
		$transfertype = $res65['transfertype'];
		$medtype = $res65['type'];
		$inventorytype = $res65['inventorytype'];
		
		$query11 = "select * from master_tax where taxname='$taxname' and status <> 'deleted' order by taxname";
						$exec11 = mysql_query($query11) or die ("Error in Query1".mysql_error());
						$res11 = mysql_fetch_array($exec11);
						
						$res11taxpercent = $res11["taxpercent"];
						$res11anum = $res11["auto_number"];
						
					


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
-->
</style>
</head>
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
		alert ("Please Enter pharmacy Item Code or ID.");
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
				//alert ("Your radiology Item Name Has Blank White Spaces Or Special Characters. Like ! ^ + = [ ] ; , { } | \ < > ? ~ $ ' \" These are not allowed.");
				alert ("Your pharmacy Item Code Has Blank White Spaces Or Special Characters. These Are Not Allowed.");
				//return false;
			}
		}
	}
	if (document.form1.itemname.value == "")
	{
		alert ("Pleae Enter pharmacy Item Name.");
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
	if (document.form1.packageanum.value == "")
	{	
		alert ("Please Select Package.");
		document.form1.packageanum.focus();
		return false;
	}
	if (document.form1.packageanum.value == "NOS")
	{	
		alert ("Please Select Package.");
		document.form1.packageanum.focus();
		return false;
	}
	if (document.form1.rol.value == 0)
	{	
		alert ("Please Enter ROL value.");
		document.form1.rol.focus();
		return false;
	}
	if(isNaN(document.form1.rol.value))
	{
	   alert("Please Enter ROL value in Numbers");
	   document.form1.rol.focus();
		return false;
	}
	if (document.form1.maximumstock.value == 0)
	{	
		alert ("Please Enter Maximum Stock value.");
		document.form1.maximumstock.focus();
		return false;
	}
	if(isNaN(document.form1.maximumstock.value))
	{
	   alert("Please Enter Maximum Stock value in Numbers");
	   document.form1.maximumstock.focus();
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
		fRet = confirm(' Are You Sure You Want To Continue To Save?'); 
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
			alert ("Your pharmacy Item Name Has Special Characters. Like ! ^ + = [ ] ; , { } | \ < > ? ~ These are not allowed.");
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

function calculatepersent(val)
{
	//alert(val);
	var original=document.getElementById("costprice").value;
	var newnumber=document.getElementById("rateperunit2").value;// alert(newnumber);
	var decrease=parseFloat(original)-parseFloat(newnumber);
	var persent=(parseFloat(decrease)/parseFloat(original))*100;
	//alert(persent);
	document.getElementById("spmarkup").value=Math.abs(persent).toFixed(2);
	//alert(val);
//alert(val);
}

jQuery('#some_text_box').on('input propertychange paste', function() {
    // do your stuff
});
</script>
<body onLoad="return process2()">
<table width="101%" border="0" cellspacing="0" cellpadding="2">
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
    <td width="97%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablebackgroundcolor1">
            <tr>
              <td><form name="form1" id="form1" method="post" action="editpharmacyitem.php" onSubmit="return additem1process1()">
                  <table width="1072" border="0" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="4" bgcolor="#CCCCCC" class="bodytext3"><strong>Pharmacy Item Master - Add New </strong></td>
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
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><select id="categoryname" name="categoryname" >
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
						$query1 = "select * from master_categorypharmacy where status <> 'deleted' order by categoryname";
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
                          <a href="pharmacycategory1.php"><font  class="bodytext32" color="#000000">(Click Here To Add New Category)</font></a></td>
                         <td align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3">Generic Name</td>
                         <td align="left" valign="top"  bgcolor="#E0E0E0"><a href="pharmacycategory1.php"></a>
                           <select id="genericname" name="genericname">
						     <?php
						if ($genericname != '')
						{
						?>
                          <option value="<?php echo $genericname; ?>" selected="selected"><?php echo $genericname; ?></option>
                          <?php
						}
						else
						{
						?>
                             <option value="" selected="selected">Select Generic Name</option>
                             <?php
							 }
						$query111 = "select * from master_genericname where recordstatus = '' ";
						$exec111 = mysql_query($query111) or die ("Error in Query111".mysql_error());
						while ($res111 = mysql_fetch_array($exec111))
						{
						$res111genericname = $res111['genericname'];
						?>
                             <option value="<?php echo $res111genericname; ?>"><?php echo $res111genericname; ?></option>
                             <?php
						  }
						  ?>
                           </select></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"> <div align="left">New Pharmacy Item Code </div></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><input name="itemcode" value="<?php echo $itemcode; ?>" id="itemcode" readonly onKeyDown="return process1backkeypress1()" style="border: 1px solid #001E6A; background-color:#CCCCCC" size="20" maxlength="100" />
                          <span class="bodytext32">( Example : PRD1234567890 ) </span></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3">Exclude</td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><input type="checkbox" name="exclude"></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><div align="left">Add New Pharmacy Item Name </div></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><input name="itemname" type="text" id="itemname" style="border: 1px solid #001E6A" onChange="return spl()" value="<?php echo $itemname; ?>" size="60"></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3">Min Stock</td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><input type="text" name="minimumstock" id="minimumstock" style="border: 1px solid #001E6A" value="<?php echo $minimumstock; ?>"></td>
                      </tr>
                   
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><div align="left">Sales Price</div></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><input name="rateperunit2" id="rateperunit2" style="border: 1px solid #001E6A" value="<?php echo $rateperunit; ?>" size="20" onKeyUp="calculatepersent(this.value)"/>                         </td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3">Max Stock</td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><input type="text" name="maximumstock" id="maximumstock" style="border: 1px solid #001E6A" value="<?php echo $maximumstock; ?>"></td>
                      </tr>
				  
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><div align="left">Formula</div></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><select id="formula" name="formula">
                          <?php
						if ($formula1 != '')
						{
						?>
                          <option value="<?php echo $formula1; ?>" selected="selected"><?php echo $formula1; ?></option>
                          <?php
						}
						else
						{
						?>
                          <option value="" selected="selected">Select Formula</option>
                          <?php
						}
						
                         ?>
						 <option value="CONSTANT">CONSTANT</option>
						  <option value="INCREMENT">INCREMENT</option>
                        </select></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3">ROL</td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><input type="text" name="rol" style="border: 1px solid #001E6A" value="<?php echo $rol; ?>"></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><div align="left">Select Pharmacy Package </div></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><select id="packageanum" name="packageanum">
                          <option value="">Select Pack</option>
						  	  <?php
						if ($itemname_abbreviation != '')
						{
						?>
                          <option value="<?php echo $itemname_abbreviation; ?>" selected="selected"><?php echo $itemname_abbreviation; ?></option>
                          <?php
						}
						else
						{
						?>
						<option value="">Select Pack</option>
                          <?php
						  }
						$query1 = "select * from master_packagepharmacy where status <> 'deleted' order by packagename";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						while ($res1 = mysql_fetch_array($exec1))
						{
						$res1anum = $res1['auto_number'];
						$res1packagename = $res1["packagename"];
						$res1packagename = stripslashes($res1packagename);
						$quantityperpackage = $res1["quantityperpackage"];
						$quantityperpackage = round($quantityperpackage);
						?>
                          <option value="<?php echo $res1packagename; ?>"><?php echo $res1packagename.' ( '.$quantityperpackage.' ) '; ?></option>
                          <?php
						}
						?>
                        </select></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3">Strength</td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><input type="text" name="roq" style="border: 1px solid #001E6A" value="<?php echo $roq; ?>"></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><div align="left">Select Applicable Tax </div></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><select id="taxanum" name="taxanum">
                          <option value="">Select Tax</option>
						  <?php
						  if ($taxname != '')
						{
						?>
						 <option value="<?php echo $res11anum; ?>" selected="selected"><?php echo $taxname.' ( '.$res11taxpercent.'% ) '; ?></option>
						     <?php
						}
						else
						{
						?>
						<option value="">Select Tax</option>
                          <?php
						  }
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
                        </select>
                          <input name="rateperunit" type="hidden" id="rateperunit" style="border: 1px solid #001E6A" value="<?php echo $rateperunit; ?>" size="20" />
                          <input type="hidden" name="purchaseprice" id="purchaseprice" style="border: 1px solid #001E6A" value="<?php echo $purchaseprice; ?>" size="20" />
                          <input name="description" type="hidden" id="description" style="border: 1px solid #001E6A" value="<?php echo $description; ?>" size="50">
                          <input type="hidden" name="unitname_abbreviation" id="unitname_abbreviation" value="NOS"></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3">IP Mark up</td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><input type="text" name="ipmarkup" style="border: 1px solid #001E6A" value="<?php echo $ipmarkup; ?>"></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3">Cost Price</td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><input type="text" name="costprice" id="costprice" style="border: 1px solid #001E6A" value="<?php echo $purchaseprice; ?>"></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3">SP Mark up</td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><input type="text" name="spmarkup" id="spmarkup" style="border: 1px solid #001E6A" value="<?php echo $spmarkup; ?>"></td>
                      </tr>
					   <tr>
                        <td align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3">Disease</td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><input type="text" name="disease" id="disease" style="border: 1px solid #001E6A" value="<?php echo $disease; ?>"></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3">Package</td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><input type="checkbox" name="pkg" <?php if($pkg=='yes'){echo "checked";}?> value="yes"></td>
                      </tr>
					  <tr>
                        <td align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3">Type</td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><select name="medtype" id="medtype">
						<?php if($medtype != '') { ?>
						<option value="<?php echo $medtype; ?>"><?php echo ucfirst($medtype); ?></option>
						<?php } ?>
						<option value="drugs">Drugs</option>
						<option value="medical">Medical</option>
						<option value="non-medical">Expenses</option>
						<option value="sundries">Sundries</option>
						<option value="other_medical">Other Medical</option>
						<option value="general_stores">General Stores</option>
						<option value="assets">Assets</option>
						</select>
						</td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3">Transfer Type</td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><select name="transfertype" id="transfertype">
						<?php if($transfertype != '') { ?>
						<option value="<?php echo $transfertype; ?>"><?php echo ucfirst($transfertype); ?></option>
						<?php } ?>
						<option value="transfer">Transfer</option>
						<option value="consumable">Consumable</option>
						</select></td>
                      </tr>
                      <tr>
					  <td align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
					  <td align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
					  <td align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3">Inventory Type</td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"><select name="inventorytype" id="inventorytype">
						<?php if($inventorytype != '') { ?>
						<option value="<?php echo $inventorytype; ?>"><?php echo ucfirst($inventorytype); ?></option>
						<?php } ?>
						<option value="medical">Medical</option>
						<option value="consumable">Consumable</option>
						<option value="non-medical">Non Medical</option>
						</select></td>
					</tr>	
                       <?php $query1 = "select locationcode,locationname,prefix,suffix from master_location where status <> 'deleted' order by locationname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						$incr=0;
						while ($res1 = mysql_fetch_array($exec1))
						{
						$locationcode = $res1["locationcode"];
						$locationname = $res1["locationname"];
						
						$locationrateperunit = $res65[$locationcode."_rateperunit"];
						//$res1anum = $res1["auto_number"];
						 $incr=$incr+1;
						?>
      <tr>
	   <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
        <td width="10px" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3" ><input type="checkbox" checked="checked" name="lcheck<?php echo $incr;?>" id="lcheck<?php echo $incr;?>" style="float:left" value="<?php echo $locationcode;?>"><input type="hidden" name="checklocval" value=<?php echo $locationcode;?>"">
        &nbsp;<span style="width:100px;float:left;line-height:20px"><?php echo $locationname;?></span>&nbsp;<input type="text" name="locrate<?php echo $incr;?>" value="<?php echo $locationrateperunit; ?>" style="width:90px;"></td>
	  </tr> 
      <?php }?><input type="hidden" name="locationcount" value="<?php echo  $incr;?>">
                      <tr>
                       <td align="left" valign="top"  bgcolor="#E0E0E0" class="bodytext3"></td>
                        <td align="left" valign="top"  bgcolor="#E0E0E0"></td>
                       
                        <td width="13%" align="left" valign="top"  bgcolor="#E0E0E0">&nbsp;</td>
                        <td width="33%" align="left" valign="top"  bgcolor="#E0E0E0"><input type="hidden" name="frmflag1" value="frmflag1" />
                          <input type="hidden" name="frmflag" value="addnew" />
                          <input type="submit" name="Submit" value="Save Pharmacy Item" style="border: 1px solid #001E6A" /></td>
                      </tr>
                    </tbody>
                  </table>
				  </form>
					                  </td>
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

