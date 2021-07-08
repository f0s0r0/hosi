<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
$username = $_SESSION["username"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];

$docno = $_SESSION['docno'];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$colorloopcount = "";
$docno = $_SESSION['docno'];
$locationdetails="select locationcode, locationname from login_locationdetails where username='$username' and docno='$docno'";
$exeloc=mysql_query($locationdetails);
$resloc=mysql_fetch_array($exeloc);
$locationcode=$resloc['locationcode'];
$locationname = $resloc['locationname'];

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
	$itemname = $_REQUEST['itemname'];
	$itemname = strtoupper($itemname);
	$assetid = $_REQUEST['assetid'];
	$costprice = $_REQUEST['costprice'];
	$costprice = str_replace(',','',$costprice);
	$entrydate = $_REQUEST['entrydate'];
	$category1 = $_REQUEST['category'];
	$categorysp = explode('||',$category1);
	$dep_percent = $categorysp[0];
	$category = $categorysp[1];
	$department = $_REQUEST['department'];
	$department = ucfirst($department);
	$assetclass = $_REQUEST['assetclass'];
	$assetclass = ucfirst($assetclass);
	$assetclassid = $_REQUEST['assetclassid'];
	$unit = $_REQUEST['unit'];
	$period = $_REQUEST['period'];
	$startyear = $_REQUEST['startyear'];
	$startyear = strtoupper($startyear);
	$assetanum = $_REQUEST['assetanum'];
	$assetledger = $_REQUEST['assetledger'];
	$assetledgercode = $_REQUEST['assetledgercode'];
	$depreciation = $_REQUEST['depreciation'];
	$depreciationcode = $_REQUEST['depreciationcode'];
	$accdepreciation = $_REQUEST['accdepreciation'];
	$accdepreciationcode = $_REQUEST['accdepreciationcode'];
	$accdepreciationvalue = $_REQUEST['accdepreciationvalue'];
	$accdepreciationvalue = str_replace(',','',$accdepreciationvalue);
	
	//$qq = "SELECT Auto_increment FROM information_schema.tables WHERE table_name='assets_register' AND table_schema='neema17'";
	
	$query32 = "select auto_number from assets_register order by auto_number desc limit 0,1";
	$exec32 = mysql_query($query32) or die ("Error in Query32".mysql_error());
	$res32 = mysql_fetch_array($exec32);
	$anum = $res32['auto_number'];
	$anum = $anum + 1;
	$anumlen = strlen($anum);
	if($anumlen == 1) { $anum = '000'.$anum; }
	else if($anumlen == 2) { $anum = '00'.$anum; }
	else if($anumlen == 3) { $anum = '0'.$anum; }
	else { $anum = $anum; }
	//echo $anum;
	$assetid = $assetclassid.$anum;
	
	$query33 = "select asset_id from assets_register where asset_id = '$assetid'";
	$exec33 = mysql_query($query33) or die ("Error in Query33".mysql_error());
	$row33 = mysql_num_rows($exec33);
	if($row33 == 0)
	{ 
		$billnumber = 'FAP-'.$assetanum;
		$query88 = "INSERT INTO assets_register SET `billnumber` = '$billnumber', `itemname` = '$itemname', `asset_id` = '$assetid', `asset_category` = '$category', `asset_department` = '$department', `asset_unit` = '$unit', `asset_period` = '$period', companyanum = '$companyanum',
		`startyear` = '$startyear', asset_class = '$assetclass', dep_percent = '$dep_percent', `depreciationledger` = '$depreciation', `depreciationledgercode` = '$depreciationcode', `accdepreciationledger` = '$accdepreciation',
		`accdepreciationledgercode` = '$accdepreciationcode', `accdepreciation` = '$accdepreciationvalue', `rate` = '$costprice', `quantity` = '1', `subtotal` = '$costprice', `totalamount` = '$costprice', `coa` = '$assetledgercode', 
		`username` = '$username', `ipaddress` = '$ipaddress', `entrydate` = '$entrydate', `itemtotalquantity` = '1', `typeofpurchase` = 'Manual', `locationcode` = '$locationcode', `location` = '$locationname', `assetledger` = '$assetledger', `assetledgercode` = '$assetledgercode'";
		$exec88 = mysql_query($query88) or die ("Error in Query88".mysql_error());
		$assetanum = mysql_insert_id();
		
		$query881 = "INSERT INTO purchase_details SET `billnumber` = '$billnumber', `itemname` = '$itemname', companyanum = '$companyanum',
		`rate` = '$costprice', `quantity` = '1', `subtotal` = '$costprice', `totalamount` = '$costprice', `costprice` = '$costprice', `coa` = '$assetledgercode', 
		`username` = '$username', `ipaddress` = '$ipaddress', `entrydate` = '$entrydate', `itemtotalquantity` = '1', `typeofpurchase` = 'Manual', `purchasetype` = 'Asset',
		`locationcode` = '$locationcode', `location` = '$locationname', `expense` = '$assetledger', `expensecode` = '$assetledgercode', `accdepreciation_ledger` = 'Opening Balance Equity', `accdepreciation_code` = '05-5002'";
		$exec881 = mysql_query($query881) or die ("Error in Query881".mysql_error());
		
		header("location:assetregister.php?st=success&&assetanum=$assetanum");
		exit;
	}	
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if (isset($_REQUEST["assetanum"])) { $assetanum = $_REQUEST["assetanum"]; } else { $assetanum = ""; }
if($st == 'error')
{
	$errmsg = "Asset ID already exists";
}
if($st == 'success')
{
?>
<script>
window.open("print_assetlable.php?assetanum="+<?= $assetanum;?>+"","Window",'width=500,height=300,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');
</script>
<?php
}
if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add Store To Proceed For Billing.";
	$bgcolorcode = 'failed';
}

$query32 = "select auto_number from assets_register order by auto_number desc limit 0,1";
	$exec32 = mysql_query($query32) or die ("Error in Query32".mysql_error());
	$res32 = mysql_fetch_array($exec32);
	$anum = $res32['auto_number'];
	$assetanum = $anum + 1;
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

function addward1process1()
{
	//alert ("Inside Funtion");
	if (document.form1.itemname.value == "")
	{
		alert ("Please Enter Itemname.");
		document.form1.itemname.focus();
		return false;
	}
	if (document.form1.assetid.value == "")
	{
		alert ("Please Enter Asset ID.");
		document.form1.assetid.focus();
		return false;
	}
	if (document.form1.costprice.value == "")
	{
		alert ("Please Enter Costprice.");
		document.form1.costprice.focus();
		return false;
	}
	if (document.form1.assetclassid.value == "")
	{
		alert ("Please Select Asset Class From Search List.");
		document.form1.assetclass.focus();
		return false;
	}
	if (document.form1.department.value == "")
	{
		alert ("Please Select Department");
		document.form1.department.focus();
		return false;
	}
	if (document.form1.period.value == "")
	{
		alert ("Please Enter Life.");
		document.form1.period.focus();
		return false;
	}
	if (document.form1.category.value == "")
	{
		alert ("Please Select Category.");
		document.form1.category.focus();
		return false;
	}
	if (document.form1.assetledgercode.value == "")
	{
		alert ("Please Enter Asset Ledger");
		document.form1.assetledgercode.focus();
		return false;
	}
	if (document.form1.depreciationcode.value == "")
	{
		alert ("Please Enter Depreciation Ledger");
		document.form1.depreciation.focus();
		return false;
	}
	if (document.form1.accdepreciationcode.value == "")
	{
		alert ("Please Enter Accu Depreciation Ledger");
		document.form1.accdepreciation.focus();
		return false;
	}
}
</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />
<link rel="stylesheet" type="text/css" href="css/autocomplete.css" />        

<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/jquery.min-autocomplete.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript">
$(function() {
$('#assetledger').autocomplete({
	source:'autoassetledgersearch.php?requestfrm=asset&', 
	select: function(event,ui){
			var code = ui.item.id;
			var anum = ui.item.anum;
			$('#assetledgercode').val(code);
			},
	html: true
    });
	
$('#depreciation').autocomplete({
	source:'autoassetledgersearch.php?requestfrm=depreciation&', 
	select: function(event,ui){
			var code = ui.item.id;
			var anum = ui.item.anum;
			$('#depreciationcode').val(code);
			},
	html: true
    });	
	
$('#accdepreciation').autocomplete({
	source:'autoassetledgersearch.php?requestfrm=accdepreciation&', 
	select: function(event,ui){
			var code = ui.item.id;
			var anum = ui.item.anum;
			$('#accdepreciationcode').val(code);
			},
	html: true
    });	
	$('#assetclass').autocomplete({
	source:'autoassetclasssearch.php', 
	select: function(event,ui){
			var code = ui.item.id;
			var anum = ui.item.anum;
			$('#assetclassid').val(code);
			var assetano = $('#assetanum').val();
			while(assetano.length < 4)
			{
			assetano = '0'+assetano;
			}
			assetid = code+assetano;
			$('#assetid').val(assetid);
			},
	html: true
    });	
	
});
</script>
<script src="js/datetimepicker_css.js"></script>
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
              <td><form name="form1" id="form1" method="post" action="asset_newentry.php" onSubmit="return addward1process1()">
                  <table width="600" border="0" align="center" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tbody>
                      <tr bgcolor="#011E6A">
                        <td colspan="" bgcolor="#CCCCCC" class="bodytext3"><strong>Asset Entry </strong></td>
                         <td width="77%" align="right" bgcolor="#CCCCCC" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
                  <?php
						
						$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						$res1 = mysql_fetch_array($exec1);
						
						echo $res1location = $res1["locationname"];
						
						?>                  </td>
                      </tr>
					  <tr>
                        <td colspan="2" align="left" valign="middle"   
						bgcolor="<?php if ($bgcolorcode == '') { echo '#FFFFFF'; } else if ($bgcolorcode == 'success') { echo '#FFBF00'; } else if ($bgcolorcode == 'failed') { echo '#AAFF00'; } ?>" class="bodytext3"><div align="left"><?php echo $errmsg; ?></div></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Location </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="location" id="location" onChange="ajaxlocationfunction(this.value);"   style="border: 1px solid #001E6A;">
						
                          <?php
				$query5 = "select * from master_location where status = '' order by locationname";
				$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
				while ($res5 = mysql_fetch_array($exec5))
				{
				$locationcode = $res5["locationcode"];
				$res5location = $res5["locationname"];
				?>
                          <option value="<?php echo $locationcode; ?>"><?php echo $res5location; ?></option>
                          <?php
				}
				?>
                        </select>
						</td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Asset Category</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="category" id="category" style="border: 1px solid #001E6A;">
						<option value="">Select</option>
						<?php 
						$query61 = "select * from master_assetcategory where recordstatus <> 'deleted'";
						$exec61 = mysql_query($query61) or die ("Error in Query61".mysql_error());
						while($res61 = mysql_fetch_array($exec61))
						{
						$category = $res61['category'];
						$salvage = $res61['salvage'];
						$canum = $res61['auto_number'];
						?>
						<option value="<?php echo $salvage.'||'.$category; ?>"><?php echo $category; ?></option>
						<?php 
						}
						?>
						</select></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Class </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="assetclass" id="assetclass" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" value="<?php //echo $asset_class; ?>"/>
						<input type="hidden" name="assetclassid" id="assetclassid" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" value="<?php //echo $asset_class; ?>"/></td>
                      </tr>
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Asset ID </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input readonly name="assetid" id="assetid" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" value="<?php //echo $asset_id; ?>"/></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Asset Name</div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="itemname" id="itemname" value="<?php //echo $itemname; ?>" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" /></td>
                      </tr>
                      
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Cost </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="costprice" id="costprice" value="<?php //echo $totalamount; ?>" style="border: 1px solid #001E6A; text-transform:uppercase" size="40"/></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Acquisition Date </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="entrydate" id="entrydate" value="<?php echo date('Y-m-d'); ?>" readonly style="border: 1px solid #001E6A;"/>
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('entrydate')" style="cursor:pointer">
                        </td>
                      </tr>
					  
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Department </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<select name="department" id="department" style="border: 1px solid #001E6A;">
						<option value="">Select</option>
						<option value="Finance">Finance</option>
						<option value="Medical">Medical</option>
						<option value="Operations">Operations</option>
						</select></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Unit </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="unit" id="unit" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" value="<?php //echo $asset_unit; ?>"/></td>
                      </tr>
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Life </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="period" id="period" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" value="<?php //echo $asset_period; ?>"/></td>
                      </tr>
					   <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Depreciation Start Year </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="startyear" id="startyear" style="border: 1px solid #001E6A; text-transform:uppercase" size="40" value="<?php echo date('M-Y'); ?>"/></td>
                      </tr>
					   
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Asset Ledger </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="assetledger" id="assetledger" value="" style="border: 1px solid #001E6A; text-transform:uppercase" size="40"/>
						<input type="hidden" name="assetledgercode" id="assetledgercode" value=""></td>
                      </tr>
                      <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Depreciation Ledger </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="depreciation" id="depreciation" value="<?php //echo $depreciationledger; ?>" style="border: 1px solid #001E6A; text-transform:uppercase" size="40"/>
						<input type="hidden" name="depreciationcode" id="depreciationcode" value="<?php //echo $depreciationledgercode; ?>"></td>
                      </tr>
					  <tr>
                        <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><div align="right">Accu Depreciation Ledger </div></td>
                        <td align="left" valign="top"  bgcolor="#FFFFFF">
						<input name="accdepreciation" id="accdepreciation" value="<?php //echo $accdepreciationledger; ?>" style="border: 1px solid #001E6A; text-transform:uppercase" size="40"/>
						<input type="hidden" name="accdepreciationcode" id="accdepreciationcode" value="<?php //echo $accdepreciationledgercode; ?>">
						<input type="hidden" name="accdepreciationvalue" id="accdepreciationvalue" value="<?php //echo $accdepreciation; ?>" style="border: 1px solid #001E6A; text-transform:uppercase" size="40"/></td>
                      </tr>
					  
                      <tr>
                        <td width="23%" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                        <td width="77%" align="left" valign="top"  bgcolor="#FFFFFF">
						<input type="hidden" name="frmflag" value="addnew" />
						<input type="hidden" name="assetanum" id="assetanum" value="<?php echo $assetanum; ?>">
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

