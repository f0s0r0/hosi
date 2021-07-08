<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$query23 = "select * from master_employee where username='$username'";
$exec23 = mysql_query($query23) or die(mysql_error());
$res23 = mysql_fetch_array($exec23);
$res7locationanum = $res23['location'];

$query55 = "select * from master_location where auto_number='$res7locationanum'";
$exec55 = mysql_query($query55) or die(mysql_error());
$res55 = mysql_fetch_array($exec55);
$location = $res55['locationname'];


$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";



$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysql_query($query) or die ("Error in Query1".mysql_error());
$res = mysql_fetch_array($exec);
	
	 $locationname  = $res["locationname"];
	 $locationcode = $res["locationcode"];
	 $res12locationanum = $res["auto_number"];
	 
  $locationcode=isset($_REQUEST['location'])?$_REQUEST['location']:'';
  if($locationcode!='')
  {
  $query4 = "select locationname,locationcode from master_location where locationcode = '$locationcode'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	$res4 = mysql_fetch_array($exec4);
	  $locationnameget = $res4['locationname'];
	  $locationcodeget = $res4['locationcode'];
  }
   $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
   $storecode=isset($_REQUEST['store'])?$_REQUEST['store']:'';
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

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	$searchsuppliername = $_POST['medicinename'];
	//echo $searchsuppliername;
	if ($searchsuppliername != '')
	{
		$arraysupplier = explode("||", $searchsuppliername);
		$arraysuppliercode = $arraysupplier[0];
		$arraysuppliername = $arraysupplier[1];
		$arraysuppliername = trim($arraysuppliername);
		
		
		$query1 = "select * from master_supplier where suppliercode = '$arraysuppliercode'";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$res1 = mysql_fetch_array($exec1);
		$supplieranum = $res1['auto_number'];
		$openingbalance = $res1['openingbalance'];

		$cbsuppliername = $arraysuppliername;
		$suppliername = $arraysuppliername;
	}
	else
	{
		$cbsuppliername = $_REQUEST['cbsuppliername'];
		$suppliername = $_REQUEST['cbsuppliername'];
	}

	//$transactiondatefrom = $_REQUEST['ADate1'];
	//$transactiondateto = $_REQUEST['ADate2'];

}

if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

if ($frmflag2 == 'frmflag2')
{
	
	
	
    $itemname=$_REQUEST['itemname'];
	$itemcode=$_REQUEST['itemcode'];
	$remarks=$_REQUEST['remarks'];
	$store=$_REQUEST['storename'];
	$adjustmentdate=date('Y-m-d');
	
			$query31 = "select * from master_itempharmacy where itemcode = '$itemcode'"; 
			$exec31 = mysql_query($query31) or die ("Error in Query31".mysql_error());
			$res31 = mysql_fetch_array($exec31);
			$categoryname = $res31['categoryname'];

$paynowbillprefix = 'ADJ-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from master_stock where transactionmodule = 'ADJUSTMENT' order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["billnumber"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='ADJ-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billnumber"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'ADJ-'.$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
 $locationcodenew=isset($_REQUEST['locationcodenew'])?$_REQUEST['locationcodenew']:'';
			$query31 = "select locationname from master_location where locationcode = '$locationcodenew'"; 
			$exec31 = mysql_query($query31) or die ("Error in Query31".mysql_error());
			$res31 = mysql_fetch_array($exec31);
			$locationnamenew = $res31['locationname'];
	foreach($_POST['batch'] as $key => $value)
		{
		$batchnumber=$_POST['batch'][$key];
		$addstock=$_POST['addstock'][$key];
		$minusstock=$_POST['minusstock'][$key];
		$query40 = "select * from master_itempharmacy where itemcode = '$itemcode'";
	$exec40 = mysql_query($query40) or die ("Error in Query40".mysql_error());
	$res40 = mysql_fetch_array($exec40);
	$itemmrp = $res40['rateperunit'];
	
	$itemsubtotal = $itemmrp * $addstock;
	
		if($addstock != '')
		{
		$query65="insert into master_stock (itemcode, itemname, transactiondate, transactionmodule, 
	transactionparticular,  billnumber, quantity, remarks, 
	 username, ipaddress, rateperunit, totalrate, companyanum, companyname,batchnumber,location,store,categoryname,locationname,locationcode)
	values ('$itemcode', '$itemname', '$adjustmentdate', 'ADJUSTMENT', 
	'BY ADJUSTMENT ADD',  '$billnumbercode', '$addstock', '$remarks', 
	'$username', '$ipaddress', '$itemmrp', '$itemsubtotal', '$companyanum', '$companyname','$batchnumber','$location','$store','$categoryname','".$locationnamenew."','".$locationcodenew."')";
	$exec65=mysql_query($query65) or die(mysql_error());
		}
		else
		{
	 	$query65="insert into master_stock (itemcode, itemname, transactiondate, transactionmodule, 
	transactionparticular,  billnumber, quantity, remarks, 
	 username, ipaddress, rateperunit, totalrate, companyanum, companyname,batchnumber,location,store,categoryname,locationname,locationcode)
	values ('$itemcode', '$itemname', '$adjustmentdate', 'ADJUSTMENT', 
	'BY ADJUSTMENT MINUS', '$billnumbercode', '$minusstock', '$remarks', 
	'$username', '$ipaddress', '$itemmrp', '$itemsubtotal', '$companyanum', '$companyname','$batchnumber','$location','$store','$categoryname','".$locationnamenew."','".$locationcodenew."')";
	$exec65=mysql_query($query65) or die(mysql_error());
	
		}
		}
	header("location:stockadjustment.php");
	exit;
	
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

window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("medicinename"), new StateSuggestions());        
}



</script>
<?php //include("autocompletebuild_med.php"); ?>
<script type="text/javascript" src="js/autosuggestmed.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_med.js"></script>
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

function paymententry1process2()
{
	if (document.getElementById("location").value == "")
	{
		alert ("Please Select Location");
		document.getElementById("location").focus();
		return false;
	}
	if (document.getElementById("store").value == "")
	{
		alert ("Please Select Store");
		document.getElementById("store").focus();
		return false;
	}
	
	if (document.getElementById("medicinename").value == "")
	{
		alert ("Enter The Medicine Name");
		document.getElementById("medicinename").focus();
		return false;
	}
	
	if(confirm("Are You Want To Save The Record?")==false){return false;}
}


function funcPrintReceipt1()
{
	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}

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
	
	function functioncheklocationandstock()
	{
		if(document.getElementById("location").value=='')
		{
		alert('Please Select Location!');
		document.getElementById("location").focus();
		return false;
		}
		if(document.getElementById("store").value=='')
		{
		alert('Please Select Store!');
		document.getElementById("store").focus();
		return false;
		}
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
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="stockadjustment.php" onSubmit="return paymententry1process2()">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="1" bgcolor="#CCCCCC" class="bodytext3"><strong>Stock Adjustment </strong></td>
               <td colspan="3" align="right" bgcolor="#CCCCCC" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
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
						?>
						
						
                  
                  </td> 
              </tr>
            <tr>
              <td align="left" valign="middle" bgcolor="#FFFFFF"   class="bodytext3"><strong>Location</strong></td>
              <td   class="bodytext3"  colspan="3" bgcolor="#FFFFFF"><select name="location" id="location"  style="border: 1px solid #001E6A;" onChange="storefunction(this.value); ajaxlocationfunction(this.value);">
              
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
                   
                
                <input type="hidden" name="username" id="username" value="<?php echo $username; ?>">
             
              </tr>
		<tr>
		  <td width="104" align="left" bgcolor="#FFFFFF" valign="center" class="bodytext31"><strong>Store</strong> </td>
          <td width="680" align="left" bgcolor="#FFFFFF" valign="center"  class="bodytext31">
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
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Drug </td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="medicinename" type="text" id="medicinename" style="border: 1px solid #001E6A;" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">
              </span></td>
              </tr>
            <tr>
              <td width="18%"  align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"> Drug </td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input value="<?php echo $cbsuppliername; ?>" name="cbsuppliername" type="text" id="cbsuppliername" readonly onKeyDown="return disableEnterKey()" size="50" style="border: 1px solid #001E6A"></td>
              </tr>
			  <?php /*?><!--<tr>
              <td width="18%"  align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"> Store </td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">			  
			  <select name="store" id="store">
			   <?php
			$store = $_REQUEST['store'];
			if ($store != '')
			{
			?>
            <option value="<?php echo $store; ?>" selected="selected"><?php echo $store; ?></option>
            <option value=""> Select Store </option>
            <?php
			}
			else
			{
			?>
		  <option selected="selected" value="">Select Store</option>
		  <?php
		  }
		  ?>
		   <?php
		        $query44 = "select * from master_employee where status = 'Active' and username = '$username' ";
				$exec44 = mysql_query($query44) or die ("Error in Query44".mysql_error());
				$res44 = mysql_fetch_array($exec44);
			    $res44store = $res44['store'];
				$res44showlocations= $res44['showlocations'];
				
			 if($res44showlocations == 'on')
				  {
				$query42 = "select * from master_store where recordstatus <> 'DELETED' group by store order by store";
				  }
				  else
				  {	
				  $query42 = "select * from master_store where auto_number = '$res44store' and recordstatus <> 'DELETED' group by store order by store";
                  }				$exec42 = mysql_query($query42) or die ("Error in Query42".mysql_error());
				while ($res42 = mysql_fetch_array($exec42))
				{
				$stores = $res42['store'];
				$storecodes = $res42['storecode'];
				?>
            <option value="<?php echo $stores; ?>"><?php echo $stores; ?></option>
            <?php
				}
				?>
			  
			  </select>
			  </td>
              </tr>--><?php */?>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="border: 1px solid #001E6A; text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
              <input type="hidden" name="frmflag1" value="frmflag1">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  style="border: 1px solid #001E6A" type="submit" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton"  style="border: 1px solid #001E6A" value="Reset" /></td>
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
      
      <tr>
        <td>&nbsp;</td>
      </tr>
      
      <tr>
        <td>&nbsp;</td>
      </tr>
	  <tr>
        <td>
	<form name="form1" id="form1" method="post" action="stockadjustment.php">	
		<input type="hidden" name="locationcodenew" value="<?php echo $location;?>">
<?php
	$colorloopcount=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	$searchsuppliername = $_POST['medicinename'];
	//$searchsuppliername;
	if ($searchsuppliername != '')
	{
		$arraysupplier = explode("||", $searchsuppliername);
			$arraysuppliercode = $arraysupplier[0];
		$arraysuppliername = $arraysupplier[1];
		$arraysuppliername = trim($arraysuppliername);
		
		$query1 = "select * from master_supplier where suppliercode = '$arraysuppliercode'";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$res1 = mysql_fetch_array($exec1);
		$supplieranum = $res1['auto_number'];
		$openingbalance = $res1['openingbalance'];

		$cbsuppliername = $arraysuppliername;
		$suppliername = $arraysuppliername;
		$itemcode=$arraysuppliercode;
	}
	else
	{
		$cbsuppliername = $_REQUEST['cbsuppliername'];
		$suppliername = $_REQUEST['cbsuppliername'];
	}
	
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
            <tr>
              <td colspan="3" bgcolor="#cccccc" class="bodytext311"><strong><?php echo $suppliername; ?></strong></td>
              <td width="6%" bgcolor="#cccccc" class="bodytext311">&nbsp;</td>
              <td width="7%" bgcolor="#cccccc" class="bodytext311">&nbsp;</td>
              <td width="8%" bgcolor="#cccccc" class="bodytext311">&nbsp;</td>
              <td width="8%" bgcolor="#cccccc" class="bodytext311">&nbsp;</td>
           </tr>
            <tr>
              <td width="5%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext311"><strong>No.</strong></td>
				  <td width="6%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext311"><strong>Medicine Code</strong></td>
              <td width="20%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext311"><strong>Medicine </strong></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Batch </strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Stock </strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Add Stock </strong></div></td>
              <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Minus Stock </strong></div></td>
               </tr>
           <?php
             $sno=0;
			 $i=0;
					
			
			$query41="select * from purchase_details where itemcode='$itemcode' group by batchnumber";
			$exec41=mysql_query($query41);
			$numb41=mysql_num_rows($exec41);
			while($res41=mysql_fetch_array($exec41))
			{
			$batchname = $res41['batchnumber']; 
			$companyanum = $_SESSION["companyanum"];
			$itemcode = $itemcode;
			$batchname = $batchname;
	include ('autocompletestockbatch.php');
	$currentstock = $currentstock;

if($currentstock != 0 )
			{
			

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

			//if ($balanceamount != 0.00)
			//{
			?>
           <tr<?php echo $colorcode; ?>>
		     <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $sno = $sno + 1; ?></td>
			   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $itemcode; ?></td>
				<input type="hidden" name="itemcode" value="<?php echo $itemcode; ?>">
				<input type="hidden" name="storename" value="<?php echo $store; ?>">
				 <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $suppliername; ?></td>
				<input type="hidden" name="itemname" value="<?php echo $suppliername; ?>">
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $batchname; ?></td>
				<input type="hidden" name="batch[]" id="batch" value="<?php echo $batchname; ?>">
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $currentstock; ?></td>
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><input type="text" size="6" name="addstock[]" id="addstock"></td>
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><input type="text" size="6" name="minusstock[]" id="minusstock"></td>
			
		   </tr>
		   <?php 
		   } 
		   }
		   ?>
           
            <tr>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
             
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc"><div align="right"><strong>
                <?php //echo number_format($totalpurchaseamount, 2); ?>
              </strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc"><div align="right"><strong>
                <?php //echo number_format($netpaymentamount, 2); ?>
              </strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
      
			</tr>
			<tr>
			<td align="left" valign="middle" class="bodytext3">&nbsp;</td>
			<td align="left" valign="middle" class="bodytext3"><strong>Remarks</strong></td>
			<td align="left" valign="middle" class="bodytext3"><textarea cols="30" name="remarks"></textarea></td>
			</tr>
			<tr>
			
			  <td colspan="7" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right">  <input type="hidden" name="frmflag2" value="frmflag2">
                      <input name="Submit" type="submit"  value="Save" class="button" style="border: 1px solid #001E6A"/>
                  </td>
           
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

