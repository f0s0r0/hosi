<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$currentdate = date("Y-m-d");
$docno = $_SESSION['docno'];

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if (isset($_REQUEST["frmflag45"])) { $frmflag45 = $_REQUEST["frmflag45"]; } else { $frmflag45 = ""; }
if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; }
$query12 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
			$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
			$res12 = mysql_fetch_array($exec12);
			$res1location2 = $res12["locationname"];
			$res1locationanum2 = $res12["locationcode"];
			
			$storecode=isset($_REQUEST['store'])?$_REQUEST['store']:'';

//echo $location;
if ($frm1submit1 == 'frm1submit1')
{
$locationcode = $_REQUEST['locationcode'];

$query7 = "select * from master_location where locationcode = '$locationcode'";
$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
$res7 = mysql_fetch_array($exec7);
$locationname = $res7['locationname'];

foreach($_POST['itemname'] as $key => $value)
{
$itemcode = $_POST['itemcode'][$key];
$itemname = $_POST['itemname'][$key];
$requiredquantity = $_POST['requiredquantity'][$key];
foreach($_POST['select'] as $check)
		{
		$acknow=$check;
		if($acknow == $itemcode)
		{
		
		
  $query45 = "select * from master_itemtosupplier where itemcode='$itemcode' and locationcode = '$locationcode'";
  $exec45 = mysql_query($query45) or die(mysql_error());
  $res45 = mysql_fetch_array($exec45);
  $suppliername=$res45['suppliername'];
  $suppliercode=$res45['suppliercode'];

  $query25 = "select * from master_medicine where itemcode='$itemcode'";
  $exec25 = mysql_query($query25) or die(mysql_error());
  $res25 = mysql_fetch_array($exec25);
  $rate = $res25['purchaseprice'];
  $package = $res25['packagename'];
 
 $packagequantity1 = preg_replace("/[^0-9,.]/", "", $package);
	
	$packagequantity = $requiredquantity / $packagequantity1;
	$packagequantity = round($packagequantity);
	
  $amount = $rate * $requiredquantity;


$paynowbillprefix = 'APO-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query3 = "select * from master_purchaseorder order by auto_number desc limit 0, 1";
$exec3 = mysql_query($query3) or die(mysql_error());
$num3 = mysql_num_rows($exec3);
$res3 = mysql_fetch_array($exec3);
$billnumber = $res3['billnumber'];
$billdigit=strlen($billnumber);
if($num3 >0)
{
$query2 = "select * from master_purchaseorder where suppliercode = '$suppliercode' and billdate = '$currentdate' order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$num2 = mysql_num_rows($exec2);
 
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["billnumber"];

$billdigit=strlen($billnumber);
	if($billnumber != '')
	{
	 $billnumbercode = $billnumber;
	}
	else
	{
$query24 = "select * from master_purchaseorder where recordstatus='autogenerated' or recordstatus='autoprocess' order by auto_number desc limit 0, 1";
$exec24 = mysql_query($query24) or die ("Error in Query2".mysql_error());
$res24 = mysql_fetch_array($exec24);
$billnumber = $res24['billnumber'];
$billdigit=strlen($billnumber);
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	
	 $billnumbercode = intval($billnumbercode);

	$billnumbercode = $billnumbercode + 1;
     
	$maxanum = $billnumbercode;
	
	
	$billnumbercode = $paynowbillprefix .$maxanum;
	$openingbalance = '0.00';
	}
}
else
{
$query2 = "select * from master_purchaseorder order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["billnumber"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode =$paynowbillprefix.'1';
	$openingbalance = '0.00';
}
}
$query7 = "select * from master_purchaseorder where suppliercode = '$suppliercode' and billdate = '$currentdate'";
$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
$res7 = mysql_num_rows($exec7);
if($res7 == 0)
{
$query57 = "insert into master_purchaseorder (billnumber,suppliercode,suppliername,recordstatus,companyanum,billdate,username,ipaddress,locationcode,locationname) values('$billnumbercode','$suppliercode','$suppliername','autoprocess','$companyanum','$currentdate','$username','$ipaddress','$locationcode','$locationname')";
$exec57 = mysql_query($query57) or die ("Error in Query57".mysql_error());
}
$query56="insert into purchaseorder_details(companyanum,billnumber,itemcode,itemname,rate,quantity,totalamount,username, ipaddress, billdate,suppliername,suppliercode,packagequantity,recordstatus,locationcode,locationname)values('$companyanum','$billnumbercode','$itemcode','$itemname','$rate','$requiredquantity','$amount','$username','$ipaddress','$currentdate','$suppliername','$suppliercode','$packagequantity','autoprocess','$locationcode','$locationname')";
$exec56 = mysql_query($query56) or die(mysql_error());		

 
}
}
}
foreach($_POST['itemcode'] as $key => $value)
{
$itemcode = $_POST['itemcode'][$key];

foreach($_POST['select'] as $check)
		{
		$acknow=$check;
		if($acknow == $itemcode)
		{
$query53="update purchaseorder_details set recordstatus='autogenerated' where itemcode='$itemcode' and recordstatus='autoprocess'";
$exec53=mysql_query($query53) or die(mysql_error());
}
}
}
header("location:mainmenu1.php");
exit;
}

?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$paynowbillprefix = 'PO-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from purchase_ordergeneration order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='PO-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["docno"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'PO-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}

$query231 = "select * from master_employee where username='$username'";
$exec231 = mysql_query($query231) or die(mysql_error());
$res231 = mysql_fetch_array($exec231);
$res7locationanum1 = $res231['location'];

$query551 = "select * from master_location where auto_number='$res7locationanum1'";
$exec551 = mysql_query($query551) or die(mysql_error());
$res551 = mysql_fetch_array($exec551);
$location = $res551['locationname'];

$res7storeanum1 = $res231['store'];

$query751 = "select * from master_store where auto_number='$res7storeanum1'";
$exec751 = mysql_query($query751) or die(mysql_error());
$res751 = mysql_fetch_array($exec751);
$store = $res751['store'];
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
.number
{
padding-left:690px;
text-align:right;
font-weight:bold;
}
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">

function cbcustomername1()
{
	document.cbform1.submit();
}

</script>
<script type="text/javascript" src="js/autocomplete_customer1.js"></script>
<script type="text/javascript" src="js/autosuggest3.js"></script>
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchcustomername"), new StateSuggestions());        
}


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


function loadprintpage1(banum)
{
	var banum = banum;
	window.open("print_bill1_op1.php?billautonumber="+banum+"","Window"+banum+"",'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}
function itemcheck(totalcount)
{
var totalcount = totalcount;


for(i=1;i<=totalcount;i++)
{
var supplier=document.getElementById("supplier"+i+"").value;
var itemname = document.getElementById("itemname"+i+"").value;
var packsize = document.getElementById("packsize"+i+"").value;
var requiredquantity = document.getElementById("requiredquantity"+i+"").value;

if(document.getElementById("select"+i+"").checked == true)
{
if(supplier == '')
{
alert(itemname+" "+"is not mapped to supplier");
return false;
}
if(packsize == '')
{
alert("Pack Size for"+" "+itemname+" "+"is empty");
return false; 
}
if(requiredquantity == 0)
{
alert("Required Quantity for"+" "+itemname+" "+"Zero");
return false;
}
if(requiredquantity < 0)
{
alert("Required Quantity for"+" "+itemname+" "+"is Negative");
return false;
}
}
}

	
}
function Val2()
{
	var varUserChoice; 
	varUserChoice = confirm('Are You Sure Want To Save This Entry?'); 

	if (varUserChoice == false)
	{
		 
			return false;

	}

    document.getElementById('submit1').disabled="true";
	return ture;
}

function Valid1()
{
	
	if(document.getElementById("location").value == "")
	{
		alert("Select Location");
		document.getElementById("location").focus();
		return false;
	}
	
	if(document.getElementById("store").value == "")
	{
		alert("Select store");
		document.getElementById("store").focus();
		return false;
	}


}

function Uncheckall()
{
var inputs = document.getElementsByClassName('selectall');
var chklength = inputs.length;
//alert(chklength);
if(document.getElementById('chkall').innerHTML == "Check"){
for(var i=1;i<=chklength;i++){
document.getElementById('select'+i).checked = true;
document.getElementById('chkall').innerHTML = "Uncheck";}
}else{
for(var i=1;i<=chklength;i++){document.getElementById('select'+i).checked = false;
document.getElementById('chkall').innerHTML = "Check"; }
}
}
</script>


<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>
</head>

<body>

<table width="100%" border="0" cellspacing="0" cellpadding="2">
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
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
            <tr>
             
              <td colspan="10" bgcolor="#cccccc" class="bodytext31"><script language="javascript">
				function printbillreport1()
				{
					window.open("print_collectionpendingreport1hospital.php?<?php echo $urlpath; ?>","Window1",'width=900,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
					//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
				}
				function printbillreport2()
				{
					window.location = "dbexcelfiles/CollectionPendingByPatientHospital.xls"
				}
				</script>
                <!--<input onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" value="Print Report" />-->
                </td>
              </tr>
			  <form method="post" name="form2" id="form2" action="automaticpo.php" onSubmit="return Valid1();">
			   <tr>
              <td class="bodytext31" valign="center"  align="left" bgcolor="#CCCCCC"><strong>Location</strong></td>
              <td align="left" valign="center" bgcolor="#CCCCCC" class="bodytext31">
			  <?php if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; } ?>
			  <select name="location" id="location">
			  <option value="">Select Location</option>
			  <?php		
			$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			while ($res1 = mysql_fetch_array($exec1))
			{
			$res1location = $res1["locationname"];
			$res1locationanum = $res1["locationcode"];
			?>
			<option value="<?php echo $res1locationanum; ?>" <?php if($location!='')if($location==$res1locationanum){echo "selected";}?>><?php echo $res1location; ?></option>
			<?php
			}
			?>
			  </select>
			  </td>
              <td class="bodytext31" valign="center"  align="left" bgcolor="#CCCCCC"><strong>Store</strong></td>
              <td align="left" valign="center" bgcolor="#CCCCCC" class="bodytext31">
			  <?php if (isset($_REQUEST["location"])) { $location = $_REQUEST["location"]; } else { $location = ""; } ?>
			  <select name="store" id="store">
			  <option value="">Select Store</option>
			  <?php		
			$query1 = "select * from master_store where  locationcode='$res1locationanum2' and recordstatus <> 'deleted' group by storecode  order by store";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			while ($res1 = mysql_fetch_array($exec1))
			{
			$storename1 = $res1["store"];
			$storecode1 = $res1["storecode"];
			?>
			<option value="<?php echo $storecode1; ?>" <?php if($storecode1!='')if($storecode==$storecode1){echo "selected";}?>><?php echo $storename1; ?></option>
			<?php
			}
			?>
			  </select>
			  </td>
             
           <td colspan="9" bgcolor="#CCCCCC" align="left" class="bodytext3"><input type="hidden" name="frmflag45" id="frmflag45" value="frmflag45">
		   <input type="submit" value="Search" name="submit56">&nbsp;<span class="bodytext3"><strong>Date</strong></span>&nbsp;
		   <input type="text" name="ADate1" id="ADate1" readonly value="<?php echo date('Y-m-d'); ?>" size="10"></td>
            </tr>
			</form>
			<?php
			if ($st == 'success' && $billautonumber != '')
			{
			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff">&nbsp;</td>
              <td colspan="10"  align="left" valign="center" bgcolor="#FFFF00" class="bodytext31">&nbsp;
			  * Success. Bill Saved. &nbsp;&nbsp;&nbsp;
			  <input name="billprint" type="button" onClick="return loadprintpage1('<?php echo $billautonumber; ?>')" value="Click Here To Print Invoice" class="button" style="border: 1px solid #001E6A"/>
			  </td>
              <td  align="left" valign="center" bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
            </tr>
			<?php
			}
			?>
			<?php
			if($frmflag45 == 'frmflag45')
			{ ?>
			<form method="post" name="form1" action="automaticpo.php" onSubmit="return Val2();">
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				 <td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>ItemName </strong></div></td>
				<td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Avl.Stock</strong></div></td>
				<td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>ROL</strong></div></td>
				<td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Min</strong></div></td>
				<td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Max</strong></div></td>
              <td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>ROQ</strong></div></td>
				 <td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Supplier</strong></div></td>
			
			 <td width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Pack Size</strong></div></td>
			
				<td width="10%" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><a href="javascript:Uncheckall();"><div align="center" id="chkall"><strong>Uncheck</strong></div></a></td>
              
              </tr>
			
            
			<?php
			$colorloopcount = '';
			$sno = '';
			$location = $_REQUEST['location'];
			$query11 = "select itemcode,itemname,rol,minimum,maximum from master_itemtosupplier where recordstatus <> 'Deleted' and locationcode = '$location' and rol <> '0' group by itemcode order by itemname";
			$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
			$num11 = mysql_num_rows($exec11);
			while($res11=mysql_fetch_array($exec11))
			{
			
			$itemcode = $res11['itemcode'];
			$itemname = $res11['itemname'];
			$rol = $res11['rol'];
			$min = $res11['minimum'];
			$max = $res11['maximum'];
			
			$query12 = "select packagename from master_medicine where itemcode = '$itemcode' and status <> 'deleted'";
			$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
			$num12 = mysql_num_rows($exec12);
			$res12=mysql_fetch_array($exec12);
			if($num12==0)
			{
			//echo  '<br>'.$itemcode;
			}
			$packsize = $res12['packagename'];
			
			$query65 = "select suppliercode,suppliername from master_itemtosupplier where itemcode='$itemcode' and locationcode = '$location'";
			$exec65 = mysql_query($query65) or die(mysql_error());
			$res65 = mysql_fetch_array($exec65);
			$suppliername1=$res65['suppliername'];
			$suppliercode1=$res65['suppliercode'];
			$locationcode = $location;
			
			$query8 = "select itemcode,billdate from purchaseorder_details where itemcode = '$itemcode' and locationcode = '$location' and billdate ='$currentdate'";
			$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
			$res8 = mysql_fetch_array($exec8);
			$res8itemcode = $res8['itemcode'];
			$billdate = $res8['billdate'];
			if($res8itemcode == '')
			{
			
			$itemcode = $itemcode;
			//include ('autocompletestockcount1include5.php');
			$reorderquery1 = "select sum(batch_quantity) as cum_quantity from transaction_stock where itemcode = '$itemcode' and batch_stockstatus='1' and locationcode = '$location' and storecode='$storecode'";
			$reorderexec1 = mysql_query($reorderquery1) or die ("Error in Query1".mysql_error());
			$reordernum1 = mysql_num_rows($reorderexec1);
			$reorderres1=mysql_fetch_array($reorderexec1);
		 	$currentstock = $reorderres1['cum_quantity'];	
			if($currentstock=='')
			{
			$currentstock='0';
			}
			$currentstock = $currentstock;
			//echo $rol;
			$roq = $max - $currentstock;
			
			if($currentstock <= $rol)
			{
			if($roq > 0)
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
			?>
			  <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div>
			  <input type="hidden" name="locationcode" id="locationcode" value="<?php echo $location; ?>"></td>
			   <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $itemname; ?><input type="hidden" name="itemname[]" value="<?php echo $itemname; ?>" id="itemname<?php echo $sno; ?>"></div></td>
				<input type="hidden" name="itemcode[]" value="<?php echo $itemcode; ?>">
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $currentstock; ?></div></td>
					<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $rol; ?></div></td>
				<input type="hidden" name="rol[]" id="rol<?php echo $sno; ?>" value="<?php echo $rol; ?>">
			
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $min; ?></div></td>
				
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $max; ?></div></td>
			  <input type="hidden" name="max[]" id="max<?php echo $sno; ?>" value="<?php echo $max; ?>">
			  <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $roq; ?></div></td>
			<input type="hidden" name="requiredquantity[]" id="requiredquantity<?php echo $sno; ?>" value="<?php echo $roq; ?>">
			   <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $suppliername1; ?></div></td>
			  <input type="hidden" name="supplier[]" id="supplier<?php echo $sno; ?>" value="<?php echo $suppliername1; ?>">
		   <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $packsize; ?></div></td>
		<input type="hidden" name="packsize[]" id="packsize<?php echo $sno; ?>" value="<?php echo $packsize; ?>">
			   <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><input type="checkbox" class="selectall" name="select[]" id="select<?php echo $sno; ?>" checked="checked" value="<?php echo $itemcode; ?>"></div></td>
                       </tr>
			  <?php
			}
			}
			
			
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
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
           	 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
           
             		 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
           	
              </tr>
          </tbody>
        </table></td>
      </tr>
	  <tr>
	   <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
	  </tr>
	  <tr>
	  <td class="bodytext31" valign="center"  align="center">
	   <input type="hidden" name="frm1submit1" value="frm1submit1" />
	   <input type="hidden" name="doccno" value="<?php echo $billnumbercode; ?>">
	    <input type="submit" id="submit1" name="submit" value="Generate PO" onClick="return itemcheck('<?php echo $sno; ?>');"></td>
	  </tr>
	  </form>
	  <?php } ?>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>

</body>
</html>

