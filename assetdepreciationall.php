<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$location =isset( $_REQUEST['location'])?$_REQUEST['location']:'';

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

//This include updatation takes too long to load for hunge items database.


if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select * from master_supplier where auto_number = '$getcanum'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	$res4 = mysql_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}

if(isset($_REQUEST['searchitem'])) { $searchitem = $_REQUEST['searchitem']; } else { $searchitem = ""; }

if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];
if (isset($_REQUEST["assignmonth"])) { $assignmonth = $_REQUEST["assignmonth"]; } else { $assignmonth = date('M-Y'); }

if (isset($_REQUEST["frmflag56"])) { $frmflag56 = $_REQUEST["frmflag56"]; } else { $frmflag56 = ""; }

if ($frmflag56 == 'frmflag56')
{
	$assignmonth = $_REQUEST["assignmonth"];
	$totalcount = $_REQUEST['totalcount'];
	for($i=1;$i<=$totalcount;$i++)
	{
		if(isset($_REQUEST['checkanum'.$i]))
		{
			$checkanum = $_REQUEST['checkanum'.$i];
			if($checkanum != '')
			{
				$assetanum = $_REQUEST['assetanum'.$i];
				$depreciation = $_REQUEST['depreciation'.$i];
				$depreciation = str_replace(',','',$depreciation);
				$assetid = $_REQUEST['assetid'.$i];
				//echo $assetanum.'->'.$depreciation;
				
				$query66 = "SELECT * FROM assets_depreciation WHERE asset_id = '$assetid' AND processmonth = '$assignmonth'";
				$exec66 = mysql_query($query66) or die ("Error in Query66".mysql_error());
				$row66 = mysql_num_rows($exec66);
				if($row66 == 0)
				{
					$query78 = "INSERT INTO `assets_depreciation`(`bill_autonumber`, `companyanum`, `billnumber`, `categoryname`, `itemanum`, `itemcode`, `itemname`, `itemdescription`,
					`unit_abbreviation`, `rate`, `quantity`, `subtotal`, `free`, `itemtaxpercentage`, `itemtaxamount`, `discountpercentage`, `discountrupees`, `openingstock`, 
					`closingstock`, `totalamount`, `coa`, `discountamount`, `recordstatus`, `username`, `ipaddress`, `entrydate`, `batchnumber`, `costprice`, `salesprice`, 
					`expirydate`, `itemfreequantity`, `itemtotalquantity`, `packageanum`, `packagename`, `quantityperpackage`, `allpackagetotalquantity`, `manufactureranum`, 
					`manufacturername`, `suppliername`, `suppliercode`, `supplieranum`, `supplierbillnumber`, `typeofpurchase`, `ponumber`, `itemstatus`, `locationcode`, `store`, 
					`location`, `fifo_code`, `currency`, `fxrate`, `totalfxamount`, `deliverybillno`, `mrnno`, `fxpkrate`, `fxtotamount`, `assetledger`, `assetledgercode`, 
					`assetledgeranum`, `priceperpk`, `fxamount`, `asset_id`, `asset_class`, `asset_category`, `dep_percent`, `asset_department`, `asset_unit`, `asset_period`, 
					`startyear`, `depreciationledger`, `depreciationledgercode`, `accdepreciationledger`, `accdepreciationledgercode`, `accdepreciation`) 
					SELECT `bill_autonumber`, `companyanum`, `billnumber`, `categoryname`, `itemanum`, `itemcode`, `itemname`, `itemdescription`,
					`unit_abbreviation`, `rate`, `quantity`, `subtotal`, `free`, `itemtaxpercentage`, `itemtaxamount`, `discountpercentage`, `discountrupees`, `openingstock`, 
					`closingstock`, `totalamount`, `coa`, `discountamount`, `recordstatus`, `username`, `ipaddress`, `entrydate`, `batchnumber`, `costprice`, `salesprice`, 
					`expirydate`, `itemfreequantity`, `itemtotalquantity`, `packageanum`, `packagename`, `quantityperpackage`, `allpackagetotalquantity`, `manufactureranum`, 
					`manufacturername`, `suppliername`, `suppliercode`, `supplieranum`, `supplierbillnumber`, `typeofpurchase`, `ponumber`, `itemstatus`, `locationcode`, `store`, 
					`location`, `fifo_code`, `currency`, `fxrate`, `totalfxamount`, `deliverybillno`, `mrnno`, `fxpkrate`, `fxtotamount`, `assetledger`, `assetledgercode`, 
					`assetledgeranum`, `priceperpk`, `fxamount`, `asset_id`, `asset_class`, `asset_category`, `dep_percent`, `asset_department`, `asset_unit`, `asset_period`, 
					`startyear`, `depreciationledger`, `depreciationledgercode`, `accdepreciationledger`, `accdepreciationledgercode`, `accdepreciation` FROM `assets_register` WHERE `auto_number` = '$assetanum'";
					$exec78 = mysql_query($query78) or die ("Error in Query78".mysql_error());
					$insertid = mysql_insert_id();
			
					$query79 = "UPDATE assets_depreciation SET depreciation = '$depreciation', processmonth = '$assignmonth', entrydate = '$updatedatetime', username = '$username', ipaddress = '$ipaddress' WHERE auto_number = '$insertid'";
					$exec79 = mysql_query($query79) or die ("Error in Query79".mysql_error());
					
				}	
			}
		}
	}
	
	header("location:assetdepreciationall.php?st=success");
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == '1')
{
	$errmsg = "Success. Payment Entry Update Completed.";
}
if ($st == '2')
{
	$errmsg = "Failed. Payment Entry Not Completed.";
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
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<?php include ("js/dropdownlistipbilling.php"); ?>
<script type="text/javascript" src="js/autosuggestipbilling.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_customeripbilling.js"></script>
<script>	
<?php 
if (isset($_REQUEST["ipbillnumber"])) { $ipbillnumbers = $_REQUEST["ipbillnumber"]; } else { $ipbillnumbers = ""; }
if (isset($_REQUEST["ippatientcode"])) { $ippatientcodes = $_REQUEST["ippatientcode"]; } else { $ipbillnumbers = ""; }
?>
	var ipbillnumberr;
	var ipbillnumberr = "<?php echo $ipbillnumbers; ?>";
	var ippatientcoder;
	var ippatientcoder = "<?php echo $ippatientcodes; ?>";
	//alert(refundbillnumber);
	if(ipbillnumberr != "") 
	{
		window.open("print_depositcollection_dmp4inch1.php?billnumbercode="+ipbillnumberr+"&&patientcode="+ippatientcoder+"","OriginalWindowA25",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
	}				
</script>
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




function cbsuppliername1()
{
	document.cbform1.submit();
}

function funcOnLoadBodyFunctionCall()
{ 
	//alert ("Inside Body On Load Fucntion.");
	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	funcCustomerDropDownSearch1(); //To handle ajax dropdown list.
	funcPopupOnLoad1();
}



</script>
<script type="text/javascript">


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

function disableEnterKey()
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
		return false;
	}
	else
	{
		return true;
	}

}


function funcPrintReceipt1()
{
	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}

</script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
.bal
{
border-style:none;
background:none;
text-align:right;
}
.bali
{
text-align:right;
}
</style>
</head>

<script>
function funcPopupOnLoad1()
{
<?php  
if (isset($_REQUEST["savedpatientcode"])) { $savedpatientcode = $_REQUEST["savedpatientcode"]; } else { $savedpatientcode = ""; }
if (isset($_REQUEST["savedvisitcode"])) { $savedvisitcode = $_REQUEST["savedvisitcode"]; } else { $savedvisitcode = ""; }
if (isset($_REQUEST["billnumber"])) { $billnumbers = $_REQUEST["billnumber"]; } else { $billnumbera = ""; }
?>
var patientcodes = "<?php echo $_REQUEST['savedpatientcode']; ?>";
var visitcodes = "<?php echo $_REQUEST['savedvisitcode']; ?>";
var billnumbers = "<?php echo $_REQUEST['billnumber']; ?>";
//alert(billnumbers);
	if(patientcodes != "") 
	{
		window.open("print_ipfinalinvoice1.php?patientcode="+patientcodes+"&&visitcode="+visitcodes+"&&billnumber="+billnumbers,"OriginalWindowA4",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
	}
}  
</script>

<script src="js/datetimepicker1_css.js"></script>

<body onLoad="return funcOnLoadBodyFunctionCall()">
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
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="assetdepreciationall.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Assets Depreciation </strong></td>
              <td width="83%" colspan="2" align="right" bgcolor="#CCCCCC" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
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
						?>                  </td>

              </tr>
          <tr>
          				  <td width="18%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Location</td>
				  <td colspan="3" align="left" valign="middle"  bgcolor="#E0E0E0">
                  <select name="location" id="location"  onChange="ajaxlocationfunction(this.value);" style="border: 1px solid #001E6A;">
                  <?php
						
						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						while ($res1 = mysql_fetch_array($exec1))
						{
						$locationname = $res1["locationname"];
						$locationcode = $res1["locationcode"];
						?>
						<option value="<?php echo $locationcode; ?>" <?php if($location!=''){if($location == $locationcode){echo "selected";}}?>><?php echo $locationname; ?></option>
						<?php
						}
						?>
                  </select>
                  </td>
				  </tr>

           <tr>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Process Month </td>
				  <td colspan="3" align="left" valign="middle"  bgcolor="#E0E0E0">
				  <input type="text" name="assignmonth" id="assignmonth" readonly value="<?php echo $assignmonth; ?>" size="10">
				  <img src="images2/cal.gif" onClick="javascript:NewCssCal('assignmonth','MMMYYYY')" style="cursor:pointer">
				  <input type="hidden" name="searchitem" id="searchitem" value="<?php echo $searchitem; ?>" size="60" autocomplete="off">
				  <input name="customercode" id="customercode" value="" type="hidden">
				<input type="hidden" name="recordstatus" id="recordstatus">
				  <input type="hidden" name="billnumbercode" id="billnumbercode" value="<?php echo $billnumbercode; ?>" readonly style="border: 1px solid #001E6A;"></td>
			</tr>	
             <tr>
			 <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
              <td colspan="3" align="left" valign="top"  bgcolor="#E0E0E0"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input   type="submit" value="Search" name="Submit" onClick="return funcvalidcheck();"/>
            </td>
            </tr>
			    
             </tbody>
        </table>
		</form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      
	  <form name="form11" id="form11" method="post" action="">	
	  <tr>
        <td>
	
		
<?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{
$searchpatient = '';		
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1150" 
            align="left" border="0">
          <tbody>
             
            <tr>
              <td width="3%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				<td width="3%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Check</strong></div></td>
              <td width="5%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Asset ID</strong></div></td>
				    <td width="26%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Asset Name</strong></div></td>
				 <td width="7%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Cost </strong></div></td>
				  <td width="8%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Date</strong></div></td>
				 <td width="5%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Years</strong></div></td>
				  <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Year From</strong></div></td>
				 <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Category</strong></div></td>
			 <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Location </strong></div></td>
			 <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Depreciation </strong></div></td>
			 </tr>
           <?php
		 	$sno = 0;
           $query34 = "select * from assets_register where itemname like '%$searchitem%'";
		   $exec34 = mysql_query($query34) or die(mysql_error());
		   while($res34 = mysql_fetch_array($exec34))
		   {
		   $sno = $sno + 1;
		   $itemname = $res34['itemname'];
		   $itemcode = $res34['itemcode'];
		   $totalamount = $res34['totalamount'];
		   $entrydate = $res34['entrydate'];
		   $suppliercode = $res34['suppliercode'];
		   $suppliername = $res34['suppliername'];
		   $anum = $res34['auto_number'];
		   $asset_id = $res34['asset_id'];
			$asset_category = $res34['asset_category'];
			$asset_class = $res34['asset_class'];
			$asset_department = $res34['asset_department'];
			$asset_unit = $res34['asset_unit'];
			$asset_period = $res34['asset_period'];
			$startyear = $res34['startyear'];
			$accdepreciationvalue = $res34['accdepreciation'];
			$dep_percent = $res34['dep_percent'];
			$depreciationledgercode = $res34['depreciationledgercode'];
			$depreciation = $totalamount * ($dep_percent / 100);
			$accdepreciation = $depreciation * $asset_period;
			$depreciationmonth = $depreciation / 12;
			$depreciationmonth = number_format($depreciationmonth,2);

		   	$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#D3EEB7"';
			}
			?>
			
          <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center">
			  <input type="checkbox" name="checkanum<?php echo $sno; ?>" id="checkanum<?php echo $sno; ?>" value="<?php echo $anum; ?>" <?php if($depreciationledgercode == '') { echo "disabled"; } ?>>
			  </div></td>
              <td class="bodytext31" valign="center"  align="left"><div align="center">
			  <input type="hidden" name="assetanum<?php echo $sno; ?>" id="assetanum<?php echo $sno; ?>" value="<?php echo $anum; ?>">
			  <input type="hidden" name="assetid<?php echo $sno; ?>" id="assetid<?php echo $sno; ?>" value="<?php echo $asset_id; ?>">
			  <?php echo $asset_id; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $itemname; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo number_format($totalamount,2); ?></div></td>
					  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $entrydate; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $asset_period; ?></div></td>
					  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $startyear; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $asset_class; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $asset_department; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center">
				<input type="hidden" name="accdepreciationvalue<?php echo $sno; ?>" id="accdepreciationvalue<?php echo $sno; ?>" value="<?php echo $accdepreciation; ?>">
				<input type="text" name="depreciation<?php echo $sno; ?>" id="depreciation<?php echo $sno; ?>" value="<?php echo $depreciationmonth; ?>">
				</div></td>
				</tr>
		  <?php
		  }
           ?>
            <tr>
              <td colspan="11" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;
				<input type="hidden" name="totalcount" value="<?php echo $sno; ?>"></td>
			</tr>
			<tr>
              <td colspan="11" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="">&nbsp;
				<input type="hidden" name="assignmonth" id="assignmonth" value="<?php echo $assignmonth; ?>">
				<input type="hidden" name="frmflag56" value="frmflag56">
				<input type="submit" name="submit56" value="Submit"></td>
			</tr>
          </tbody>
        </table>
<?php
}
?>	
		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
	  
	  </form>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

