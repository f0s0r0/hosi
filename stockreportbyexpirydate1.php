<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$errmsg = "";
$totalitemrate1 = '';
$docno = $_SESSION['docno'];


$query23 = "select * from master_employee where username='$username'";
$exec23 = mysql_query($query23) or die(mysql_error());
$res23 = mysql_fetch_array($exec23);
$res7locationanum = $res23['location'];

$query55 = "select * from master_location where auto_number='$res7locationanum'";
$exec55 = mysql_query($query55) or die(mysql_error());
$res55 = mysql_fetch_array($exec55);
$location = $res55['locationname'];
$locationcode=$res55['locationcode'];

$storecode = $res23['store'];

 
$query75 = "select * from master_store where auto_number='$storecode'";
$exec75 = mysql_query($query75) or die(mysql_error());
$res75 = mysql_fetch_array($exec75);
 $store = $res75['store'];
//To populate the autocompetelist_services1.js

$locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
if (isset($_REQUEST["store"])) { $store = $_REQUEST["store"]; } else { $store = ""; }

include ("autocompletebuild_item1pharmacy.php");

$transactiondatefrom = date('Y-m-d', strtotime('-1 week'));
$transactiondateto = date('Y-m-d');
	
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

if ($ADate1 != '' && $ADate2 != '')
{
	$transactiondatefrom = $_REQUEST['ADate1'];
	$transactiondateto = $_REQUEST['ADate2'];
}
else
{
	$transactiondatefrom = date('Y-m-d', strtotime('-1 week'));
	$transactiondateto = date('Y-m-d');
}

if (isset($_REQUEST["itemcode"])) { $itemcode = $_REQUEST["itemcode"]; } else { $itemcode = ""; }
//$itemcode = $_REQUEST['itemcode'];
if (isset($_REQUEST["servicename"])) { $servicename = $_REQUEST["servicename"]; } else { $servicename = ""; }
//$servicename = $_REQUEST['servicename'];

if ($servicename == '') $servicename = 'ALL';

if (isset($_REQUEST["itemname"])) { $searchitemname = $_REQUEST["itemname"]; } else { $searchitemname = ""; }
//$searchitemname = $_REQUEST['itemname'];
if ($searchitemname != '')
{
	$arraysearchitemname = explode('||', $searchitemname);
	$itemcode = $arraysearchitemname[0];
	$itemcode = trim($itemcode);
}


if (isset($_REQUEST["expiryyear"])) { $expiryyear = $_REQUEST["expiryyear"]; } else { $expiryyear = ""; }
if (isset($_REQUEST["expirymonth"])) { $expirymonth = $_REQUEST["expirymonth"]; } else { $expirymonth = ""; }


$ADate1=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:'';
	$ADate2=isset($_REQUEST['ADate2'])?$_REQUEST['ADate2']:'';
//echo $expirymonth;
//echo $expiryyear;


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
<!--<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>-->
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; }
-->
</style>
</head>
<script language="javascript">

</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<?php include ("js/dropdownlist1scripting1stock1.php"); ?>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script type="text/javascript" src="js/autosuggest1itemstock2.js"></script>
<script type="text/javascript" src="js/autocomplete_item1pharmacy.js"></script>

<script type="text/javascript">
//ajax function to get store for corrosponding location
function storefunction(loc)
{
	var username=document.getElementById("username").value;
	
var xmlhttp;

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
    document.getElementById("store").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","ajax/ajaxstore.php?loc="+loc+"&username="+username,true);
xmlhttp.send();

	}
	
	//this is end here
function process1()
{
	if (document.stockinward.searchoption1.value == "")
	{
		alert ("Please Select Search Option.")
		return false;
	}
}


function stockinwardvalidation1()
{
	
	if (document.stockinward.itemcode.value == "")
	{
		alert ("Please Select Item Name.")
		return false;
	}
	else if (document.stockinward.servicename.value == "")
	{
		alert ("Please Select Item Name.")
		document.stockinward.servicename.focus();
		return false;
	}
	else if (document.stockinward.stockquantity.value == "")
	{
		alert ("Please Enter Stock Quantity.")
		document.stockinward.stockquantity.focus();
		return false;
	}
	else if (isNaN(document.stockinward.stockquantity.value))
	{
		alert ("Please Enter Only Numbers Stock Quantity.")
		document.stockinward.stockquantity.focus();
		return false;
	}
	else if (document.stockinward.stockquantity.value == "0")
	{
		alert ("Please Enter Stock Quantity.")
		document.stockinward.stockquantity.focus();
		return false;
	}
	else if (document.stockinward.stockquantity.value == "0.0")
	{
		alert ("Please Enter Stock Quantity.")
		document.stockinward.stockquantity.focus();
		return false;
	}
	else if (document.stockinward.stockquantity.value == "0.00")
	{
		alert ("Please Enter Stock Quantity.")
		document.stockinward.stockquantity.focus();
		return false;
	}
	else if (document.stockinward.stockquantity.value == "0.000")
	{
		alert ("Please Enter Stock Quantity.")
		document.stockinward.stockquantity.focus();
		return false;
	}

}


function itemcodeentry2()
{
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
		//itemcodeentry1();
		return false;
	}
	else
	{
		return true;
	}
}




</script>
<script src="js/datetimepicker_css.js"></script>
<body onLoad="return funcCustomerDropDownSearch1();">
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
    <td width="1%" rowspan="3">&nbsp;</td>
    <td width="2%" rowspan="3" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td valign="top"><table width="98%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
		
		
			<form name="stockinward" action="stockreportbyexpirydate1.php" method="post" onKeyDown="return disableEnterKey()" onSubmit="return process1()">
			  <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 
            align="left" border="0">
      <tbody id="foo">
        <tr>
          <td colspan="5" bgcolor="#cccccc" class="bodytext31"><strong>Expiry Stock Report</strong></td>
          </tr>
        <tr>
          <td colspan="5" align="left" valign="center"  
                 bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo '#FFCC99'; } ?>" class="bodytext31"><?php echo $errmsg; ?>&nbsp;</td>
          </tr>
        <script language="javascript">

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
		//alert ("Enter Key Press2");
		return false;
	}
	else
	{
		return true;
	}
	

}


function process1rateperunit()
{
	servicenameonchange1();
}


function deleterecord1(varEntryNumber,varAutoNumber)
{
	var varEntryNumber = varEntryNumber;
	var varAutoNumber = varAutoNumber;
	var fRet;
	fRet = confirm('Are you sure want to delete the stock entry no. '+varEntryNumber+' ?');
	//alert(fRet);
	if (fRet == false)
	{
		alert ("Stock Entry Delete Not Completed.");
		return false;
	}
	else
	{
		window.location="stockreport2.php?task=del&&delanum="+varAutoNumber;		
	}
}


</script>

			<tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><strong>Location</strong></td>
              <td  bgcolor="#FFFFFF" class="bodytext3"  colspan="4" ><select name="location" id="location" style="border: 1px solid #001E6A;" onChange="storefunction(this.value)">
              <option value="">-Select Location-</option>
                  <?php
						
						$query = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec = mysql_query($query) or die ("Error in Query1".mysql_error());
						while ($res = mysql_fetch_array($exec))
						{
						$reslocation = $res["locationname"];
						$reslocationanum = $res["locationcode"];
						?>
						<option value="<?php echo $reslocationanum; ?>" <?php if($location!='')if($location==$reslocationanum){echo "selected";}?>><?php echo $reslocation; ?></option>
						<?php 
						}
						?>
                  </select></td>
                   
                  <input type="hidden" name="locationnamenew" value="<?php echo $locationname; ?>">
                <input type="hidden" name="locationcodenew" value="<?php echo $res1locationanum; ?>">
                <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
             
              </tr>
              
              
              <tr>
		  <td width="52" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><strong>Store</strong> </td>
          <td width="162" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"  colspan="4" >
		  <?php  $loc=isset($_REQUEST['location'])?$_REQUEST['location']:'';
 				 $username=isset($_REQUEST['username'])?$_REQUEST['username']:'';
 				 $frmflag1=isset($_REQUEST['frmflag1'])?$_REQUEST['frmflag1']:'';
				 $store=isset($_REQUEST['store'])?$_REQUEST['store']:'';?>  
                 <select name="store" id="store">
		   <option value="">-Select Store-</option>
           <?php if ($frmflag1 == 'frmflag1')
{$loc=isset($_REQUEST['location'])?$_REQUEST['location']:'';
$username=isset($_REQUEST['username'])?$_REQUEST['username']:'';
$query5 = "select ms.auto_number,ms.storecode,ms.store from master_employeelocation as me LEFT JOIN master_store as ms ON me.storecode=ms.auto_number where me.locationcode = '".$loc."' AND me.username= '".$username."'";
				$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
				while ($res5 = mysql_fetch_array($exec5))
				{
				$res5anum = $res5["storecode"];
				$res5name = $res5["store"];
				//$res5department = $res5["department"];
?>
<option value="<?php echo $res5anum;?>" <?php if($store==$res5anum){echo 'selected';}?>><?php echo $res5name;?></option>
<?php }}?>
		  </select>
		  </td>
		  </tr>
              
              
        <!--<tr>
          <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Category</strong></td>
          <td colspan="4" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">
		  <select name="categoryname" id="categoryname">
            <?php
			$categoryname = $_REQUEST['categoryname'];
			if ($categoryname != '')
			{
			?>
            <option value="<?php echo $categoryname; ?>" selected="selected"><?php echo $categoryname; ?></option>
            <option value="">Show All Category</option>
            <?php
			}
			else
			{
			?>
            <option selected="selected" value="">Show All Category</option>
            <?php
			}
			?>
            <?php
			$query42 = "select * from master_categorypharmacy where status = '' order by categoryname";
			$exec42 = mysql_query($query42) or die ("Error in Query42".mysql_error());
			while ($res42 = mysql_fetch_array($exec42))
			{
			$categoryname = $res42['categoryname'];
			?>
            <option value="<?php echo $categoryname; ?>"><?php echo $categoryname; ?></option>
            <?php
			}
			?>
          </select></td>
        </tr>-->
		
        <tr>
          <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Search</strong></td>
          <td colspan="4" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="itemname" type="text" id="itemname" style="border: 1px solid #001E6A; text-align:left" size="50" autocomplete="off">
            <input name="searchbutton12" type="submit" id="searchbutton12" style="border: 1px solid #001E6A" value="Search Item Name" /></td>
        </tr>
        <tr>
          <td width="52" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Item Name </strong></td>
          <td colspan="4" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">
		  <select name="itemcode" id="itemcode">
            <option selected="selected" value="">All Items</option>
 				<?php
				if ($itemcode != '')
				{
				$query43 = "select * from master_itempharmacy where itemcode like '%$itemcode%' and status <> 'DELETED'";
				$exec43 = mysql_query($query43) or die ("Error in Query43".mysql_error());
				$res43 = mysql_fetch_array($exec43);
				?>
				<option value="<?php echo $itemcode; ?>" selected="selected"><?php echo $res43['itemcode'].' - '.$res43['itemname']; ?></option>
				<?php
				}
				else
				{
				?>
				<option selected="selected" value="">All Items</option>
				<?php
				}
				?>
           <?php
				$query42 = "select itemcode, itemname from master_itempharmacy where status <> 'DELETED' order by itemname";
				$exec42 = mysql_query($query42) or die ("Error in Query42".mysql_error());
				while ($res42 = mysql_fetch_array($exec42))
				{
				$itemcode42 = $res42['itemcode'];
				$itemname42 = $res42['itemname'];
				?>
            <option value="<?php echo $itemcode42; ?>"><?php echo $itemcode42.' - '.$itemname42; ?></option>
            <?php
				}
				?>
          </select>		  </td></tr>
		  <!--<tr>
          <td width="52" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Expiry Month / Year </strong></td>
          <td width="162" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">
		  <select name="expirymonth" id="expirymonth">
            <?php
				if ($expirymonth != '')
				{
				?>
            <option value="<?php echo $expirymonth; ?>" selected="selected"><?php echo $expirymonth; ?></option>
            <?php
				}
				else
				{
				?>
            <option value="<?php echo date('m'); ?>"><?php echo date('m'); ?></option>
            <?php
				}
				?>
            <option value="01">01</option>
            <option value="02">02</option>
            <option value="03">03</option>
            <option value="04">04</option>
            <option value="05">05</option>
            <option value="06">06</option>
            <option value="07">07</option>
            <option value="08">08</option>
            <option value="09">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
          </select></td>
          <td width="6" align="left" valign="center"  bgcolor="#FFFFFF" class="style1">/</td>
          <td width="143" align="left" valign="center"  bgcolor="#ffffff"><span class="style1"><span class="bodytext31">
            <select name="expiryyear" id="expiryyear">
              <?php
				if ($expiryyear != '')
				{
				?>
              <option value="<?php echo $expiryyear; ?>" selected="selected"><?php echo $expiryyear; ?></option>
              <?php
				}
				else
				{
				?>
              <option value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
              <?php
				}
				?>
              <?php
				for ($i=2013; $i<=2020; $i++)
				{
				?>
              <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
              <?php
				}
				?>
            </select>
          </span></span></td>
         <td width="397" align="left" valign="center"  bgcolor="#ffffff">&nbsp;</td>
        </tr>-->
        
        
        <tr>
          <td width="136" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="131" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="76" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td width="425" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
            <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
          </tr>
        
        
        
		 <tr>
		 <td align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><div align="right">
		  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
		  <input type="hidden" name="frmflag1" value="frmflag1" id="frmflag1"></div></td>
        <td colspan="4" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input  style="border: 1px solid #001E6A" type="submit" value="Search" name="Submit" />
          <input name="resetbutton" type="reset" id="resetbutton"  style="border: 1px solid #001E6A" value="Reset" /></td></tr>
        <tr>
          <td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><input type="hidden" name="itemcode2" id="itemcode2" style="border: 1px solid #001E6A; text-align:left" onKeyDown="return disableEnterKey()" value="<?php echo $itemcode; ?>" size="10" readonly /></td>
          <td colspan="4" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
          </tr>
      </tbody>
    </table>
    </form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1043" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="4%" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
              <td width="7%" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
              <td width="22%" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
              <td width="8%" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
              <td width="9%" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
              <td width="16%" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
              <td width="9%" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
              </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Item Code </strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Item Name </strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Batch No </strong></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="style1">Expiry Date </td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Supplier Name </strong></div></td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Quantity. </strong></div></td>
              </tr>
			
			
			
            <?php
			if (isset($_REQUEST["expiryyear"])) { $expiryyear = $_REQUEST["expiryyear"]; } else { $expiryyear = ""; }
if (isset($_REQUEST["expirymonth"])) { $expirymonth = $_REQUEST["expirymonth"]; } else { $expirymonth = ""; }

			if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
			if ($frmflag1 == 'frmflag1')
			{		
				$sno = '';	
			$colorloopcount = '';
		/*	if (isset($_REQUEST["categoryname"])) { $categoryname = $_REQUEST["categoryname"]; } else { $categoryname = ""; }
			//$categoryname = $_REQUEST['categoryname'];
			$expirydate = '';
			$colorloopcount = '';
			$sno = '';
			$totalquantity = '';
			$stockdate = '';
			$transactionparticular = '';
			$stockremarks = '';
			$suppliername = '';
			$batchnumber = '';

			$salesquantity = '';
			$salesreturnquantity = '';
			$purchasequantity = '';
			$purchasereturnquantity = '';
			$adjustmentaddquantity = '';
			$adjustmentminusquantity = '';
			$totalsalesquantity = '';
			$totalsalesreturnquantity = '';
			$totalpurchasequantity = '';
			$totalpurchasereturnquantity = '';
			$totaladjustmentaddquantity = '';
			$totaladjustmentminusquantity = '';
			
			$totalpurchaseprice1 = '';
			$totalitemrate1 = '';
			$totalcurrentstock1  = '';

			//$query2 = "select * from master_stock where itemcode like '%$itemcode%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";// and cstid='$custid' and cstname='$custname'";
			$query2 = "select * from master_itempharmacy where itemcode like '%$itemcode%' and status <> 'DELETED' order by itemname";// limit 0,100 ";//limit 0,100";// and companyanum = '$companyanum'";// and cstid='$custid' and cstname='$custname'";
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			while ($res2 = mysql_fetch_array($exec2))
			{
			
			$res2anum = $res2['auto_number'];
			$itemcode = $res2['itemcode'];
			$itemname = $res2['itemname'];
			$res2categoryname = $res2['categoryname'];
			$purchaseprice = $res2['purchaseprice']; //Unit price is calculated below.
			$itemrate = $res2['rateperunit']; //Unit price is calculated below.
			//$stockdate = $res2['transactiondate'];
			//$stockremarks = $res2['remarks'];
			//$transactionparticular = $res2['transactionparticular'];
			$itempackageanum = $res2['packageanum'];
			$res2packagename = $res2['packagename'];
			$res2packagename = stripslashes($res2packagename);
			}
			
			//To calculate price for packaged items to divide by number of items count.
			$query31 = "select * from master_packagepharmacy where auto_number = '$itempackageanum'";
			$exec31 = mysql_query($query31) or die ("Error in Query31".mysql_error());
			$res31 = mysql_fetch_array($exec31);
			$quantityperpackage = $res31['quantityperpackage']; //Value called for purchase calc.
			
			@$itemrate = $itemrate / $quantityperpackage;
			$itemrate = number_format($itemrate, 2, '.', '');
			@$itempurchaserate = $purchaseprice / $quantityperpackage;
			$itempurchaserate = number_format($itempurchaserate, 2, '.', '');
		
			$query1 = "select sum(quantity) as sumsales from pharmacysales_details where itemcode = '$itemcode' and  recordstatus <> 'DELETED' and companyanum = '$companyanum'";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			$res1 = mysql_fetch_array($exec1);
			$totalsales = $res1['sumsales'];
			
			$query1 = "select sum(quantity) as sumsalesreturn from pharmacysalesreturn_details where itemcode = '$itemcode' and  recordstatus <> 'DELETED' and companyanum = '$companyanum'";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			$res1 = mysql_fetch_array($exec1);
			$totalsalesreturn = $res1['sumsalesreturn'];
			
			$query1 = "select sum(quantity) as sumpurchase from purchase_details where itemcode = '$itemcode' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			$res1 = mysql_fetch_array($exec1);
			$totalpurchase = $res1['sumpurchase'];
			$totalpurchase = $totalpurchase * $quantityperpackage;
			
			$query1 = "select sum(quantity) as sumpurchasereturn from purchasereturn_details where itemcode = '$itemcode' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			$res1 = mysql_fetch_array($exec1);
			$totalpurchasereturn = $res1['sumpurchasereturn'];
			
			$query1 = "select sum(quantity) as sumdccustomer from dccustomer_details where itemcode = '$itemcode' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			$res1 = mysql_fetch_array($exec1);
			$totaldccustomer = $res1['sumdccustomer'];
			
			$query1 = "select sum(quantity) as sumdcsupplier from dcsupplier_details where itemcode = '$itemcode' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			$res1 = mysql_fetch_array($exec1);
			$totaldcsupplier = $res1['sumdcsupplier'];
			
			$query1 = "select sum(quantity) as sumadjustmentadd from master_stock where itemcode = '$itemcode' and 
			transactionmodule = 'ADJUSTMENT' and transactionparticular = 'BY ADJUSTMENT ADD' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			$res1 = mysql_fetch_array($exec1);
			$totalsumadjustmentadd = $res1['sumadjustmentadd'];
			
			$query1 = "select sum(quantity) as sumadjustmentminus from master_stock where itemcode = '$itemcode' and 
			transactionmodule = 'ADJUSTMENT' and transactionparticular = 'BY ADJUSTMENT MINUS' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			$res1 = mysql_fetch_array($exec1);
			$totalsumadjustmentminus = $res1['sumadjustmentminus'];
			
			$query1 = "select*from master_stock where itemcode = '$itemcode' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			$res1 = mysql_fetch_array($exec1);
			$suppliername = $res1['suppliername'];
			
			$currentstock = $totalpurchase;
			$currentstock = $currentstock - $totalpurchasereturn;
			$currentstock = $currentstock - $totalsales;
			$currentstock = $currentstock + $totalsalesreturn;
			$currentstock = $currentstock - $totaldccustomer;
			$currentstock = $currentstock + $totaldcsupplier;
			$currentstock = $currentstock + $totalsumadjustmentadd;
			$currentstock = $currentstock - $totalsumadjustmentminus;
			
			
						if (isset($_REQUEST["itemcode"])) { $itemcode = $_REQUEST["itemcode"]; } else { $itemcode = ""; }

			//To Find Expiry Drugs On Current Stock.
		echo	$query1batch = "select * from purchase_details where recordstatus <> 'DELETED' and companyanum = '$companyanum' group by batchnumber";
			$exec1batch = mysql_query($query1batch) or die ("Error in Query1batch".mysql_error());
			while ($res1batch = mysql_fetch_array($exec1batch))
			{
				$res1batchnumber = $res1batch['batchnumber'];
				$res1expirydate = $res1batch['expirydate'];
				$res1expirydatearray = explode('-', $res1expirydate);
				$res1expiryyear = $res1expirydatearray[0];
				$res1expirymonth = $res1expirydatearray[1];
				$res1expirydate = $res1expirymonth.'/'.$res1expiryyear;
				
				
				$query2batch = "select sum(allpackagetotalquantity) as sumpurchasetotalquantity from purchase_details where itemcode = '$itemcode' and batchnumber ='$res1batchnumber' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";
				$exec2batch = mysql_query($query2batch) or die ("Error in Query2batch".mysql_error());
				$res2batch = mysql_fetch_array($exec2batch);
				$sumpurchasetotalquantity = $res2batch['sumpurchasetotalquantity'];
				
				$query2batch = "select sum(quantity) as sumpurchasereturntotalquantity from purchasereturn_details where itemcode = '$itemcode' and batchnumber ='$res1batchnumber' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";
				$exec2batch = mysql_query($query2batch) or die ("Error in Query2batch".mysql_error());
				$res2batch = mysql_fetch_array($exec2batch);
				$sumpurchasereturntotalquantity = $res2batch['sumpurchasereturntotalquantity'];
				
				$query2batch = "select sum(quantity) as sumsalestotalquantity from pharmacysales_details where itemcode = '$itemcode' and batchnumber ='$res1batchnumber' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";
				$exec2batch = mysql_query($query2batch) or die ("Error in Query2batch".mysql_error());
				$res2batch = mysql_fetch_array($exec2batch);
				$sumsalestotalquantity = $res2batch['sumsalestotalquantity'];
				
				$query2batch = "select sum(quantity) as sumsalesreturntotalquantity from pharmacysalesreturn_details where itemcode = '$itemcode' and batchnumber ='$res1batchnumber' and recordstatus <> 'DELETED' and companyanum = '$companyanum'";
				$exec2batch = mysql_query($query2batch) or die ("Error in Query2batch".mysql_error());
				$res2batch = mysql_fetch_array($exec2batch);
				$sumsalesreturntotalquantity = $res2batch['sumsalesreturntotalquantity'];
				
				$batchtotalsales = $sumsalestotalquantity - $sumsalesreturntotalquantity;
				$batchtotalpurchase = $sumpurchasetotalquantity - $sumpurchasereturntotalquantity;
				
				$batchcurrentstock = $batchtotalpurchase - $batchtotalsales;
			}
			
			
			$totalitemrate = $itemrate * $currentstock;
			$totalitemrate = number_format($totalitemrate, 2, '.', '');
			
			//$totalpurchaseprice = $purchaseprice * $currentstock;
			$totalpurchaseprice = $itempurchaserate * $currentstock;
			$totalpurchaseprice = number_format($totalpurchaseprice, 2, '.', '');
			
			$totalcurrentstock1 = $totalcurrentstock1 + $currentstock;
			
			$totalitemrate1 = $totalitemrate1 + $totalitemrate;
			$totalitemrate1 = number_format($totalitemrate1, 2, '.', '');
			
			$totalpurchaseprice1 = $totalpurchaseprice1 + $totalpurchaseprice;
			$totalpurchaseprice1 = number_format($totalpurchaseprice1, 2, '.', '');
			
			$query50 = "select * from purchase_details where itemname = '$itemname' and recordstatus <> 'DELETED' and companyanum = '$companyanum' group by batchnumber";
			$exec50= mysql_query($query50) or die ("Error in Query50".mysql_error());
			$res50 = mysql_fetch_array($exec50);
			$batchnumber = $res50['batchnumber']; */
			$query99 = "select ts.itemcode as itemcode,pd.expirydate as expirydate,pd.suppliername as suppliername,ts.batchnumber as batchnumber,ts.itemname as itemname,ts.batch_quantity as batch_quantity from transaction_stock as ts LEFT JOIN purchase_details as pd ON ts.fifo_code = pd.fifo_code where ts.batch_stockstatus = 1 and ts.locationcode = '".$locationcode."' and ts.storecode ='".$store."'  and pd.expirydate BETWEEN '".$ADate1."' and '".$ADate2."' and pd.companyanum = '$companyanum' ";
	
	if($searchitemname!='')
	{
				$query99 .= " and ts.itemname like '%".$searchitemname."%'";
	}
	if($itemcode!='')
	{
				$query99 .= " and ts.itemcode = '".$itemcode."'";
	}
	
	$query99 .= " group by ts.batchnumber";
	//itemname = '".$searchitemname."'
		//	$query99 = "select * from purchase_details where recordstatus <> 'DELETED' and companyanum = '$companyanum' and locationcode = '".$locationcode."' and store ='".$store."'  group by batchnumber";
		
			$exec99 = mysql_query($query99) or die ("Error in Query99".mysql_error());
		//	echo mysql_num_rows($exec99);
			while ($res99 = mysql_fetch_array($exec99))
			{
			    $res99itemcode = $res99['itemcode'];
		      	$res99expirydate = $res99['expirydate'];
		      /*  $res99expirydatearray = explode('-', $res99expirydate);
				$res99expiryyear = $res99expirydatearray[0];
				$res99expirymonth = $res99expirydatearray[1];
				$res99expirydate = $res99expirymonth.'/'.$res99expiryyear;*/
			
			
		  
			$res59suppliername = $res99['suppliername'];
			$res59batchnumber = $res99['batchnumber'];
			$res59itemname = $res99['itemname'];
			$batch_quantity = $res99['batch_quantity'];
			
		//	$itemcode = $res99itemcode;
		//	$batchname = $res59batchnumber;
			
	//		$locationcode=$location;
	//		$storecode=$store;
			
	//		include ('autocompletestockbatch.php');
	  //      $currentstock1 = $currentstock;
			
	//		$expirymonth = $expirymonth;
		/*	if ($expirymonth == '') $expirymonth = date('m');
			$expiryyear = $expiryyear;
			if ($expiryyear == '') $expiryyear = date('Y');
			$expirymonthyear = $expirymonth.'/'.$expiryyear;*/
			//echo $expirymonthyear;
			//echo $res1expirydate;
			//echo '<br>';
			
			/*if ($res99expirydate == $expirymonthyear)
			{
			*/
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
			$sno = $sno + 1;
			?>
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left" 
                ><?php echo $sno; ?></td>
              <td align="left" valign="center"  
                 class="bodytext31"><div class="bodytext31"><?php echo $res99itemcode; ?></div></td>
              <td align="left" valign="center"  
                 class="bodytext31"><div class="bodytext31"><?php echo $res59itemname; ?></div></td>
              <td align="left" valign="center"  
                 class="bodytext31"><div class="bodytext31">
                <div align="left"><?php echo $res59batchnumber; ?>&nbsp;</div>
              </div></td>
              <td align="left" valign="center"  
                 class="bodytext31"><div class="bodytext31">
                <div align="left"><?php echo $res99expirydate; ?>&nbsp;</div>
              </div></td>
              <td align="left" valign="center"  
                 class="bodytext31"><div align="right">
                <div class="bodytext31">
                  <div align="left"><?php echo $res59suppliername; ?>&nbsp;</div>
                </div>
              </div></td>
              <td align="left" valign="center"  
                 class="bodytext31"><div class="bodytext31">
                <div align="left"><?php echo $batch_quantity; ?>&nbsp;</div>
              </div></td>
              </tr>
          
			<?php
			//}
			
			}
			
			}
			
			
			
			?>

            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc"><div align="right"><strong>
                <?php //echo $totalcurrentstock1; ?>&nbsp;</strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc"><div align="right"><strong>
                <?php //echo $totalitemrate1; ?>&nbsp;</strong></div></td>
              </tr>
          </tbody>
        </table>	</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>    
  <tr>
    <td valign="top">    
  <tr>
    <td width="97%" valign="top">    
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>