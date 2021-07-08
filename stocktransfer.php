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
$dateonly = date("Y-m-d");
$timeonly = date("H:i:s");
$datetimeonly = date("Y-m-d H:i:s");
$i='';
$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
$res1 = mysql_fetch_array($exec1);
$res1location = $res1["locationname"];
$locationname = $res1location;
$locationcode = $res1["locationcode"];
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if ($cbfrmflag1 == 'cbfrmflag1')
{

$requestdocno = $_REQUEST['requestdocno'];
$fromstore = $_REQUEST['fromstore'];
$tostore = $_REQUEST['tostore'];
$locationcode = $_REQUEST['locationcode'];
$typetransfer = $_REQUEST['typetransfer'];
if($typetransfer == 'Consumable')
{
$tostore = $_REQUEST['expense'];
}
$fromlocationcode=$locationcode;
$tolocationcode=$locationcode;

$paynowbillprefix1 = 'ITRN-';
$paynowbillprefix12=strlen($paynowbillprefix1);
$query23 = "select * from master_stock_transfer order by auto_number desc limit 0, 1";
$exec23= mysql_query($query23) or die ("Error in Query2".mysql_error());
$res23 = mysql_fetch_array($exec23);
$billnumber1 = $res23["docno"];
$billdigit1=strlen($billnumber1);
if ($billnumber1 == '')
{
	$billnumbercode1 ='ITRN-'.'1';
	$openingbalance1 = '0.00';
}
else
{
	$billnumber1 = $res23["docno"];
	$billnumbercode1 = substr($billnumber1,$paynowbillprefix12, $billdigit1);
	//echo $billnumbercode;
	$billnumbercode1 = intval($billnumbercode1);
	$billnumbercode1 = $billnumbercode1 + 1;

	$maxanum1 = $billnumbercode1;
	
	
	$billnumbercode1 = 'ITRN-'.$maxanum1;
	$openingbalance1 = '0.00';
	//echo $companycode;
}

foreach($_POST['itemname'] as $key => $value)
		{
				   
		$medicinename=$_REQUEST['itemname'][$key];

		$medicinename=trim($medicinename);
		$medicinecode=$_REQUEST['itemcode'][$key];
		$transferquantity = $_REQUEST['transferqty'][$key];
		$batch = $_REQUEST['batch'][$key];
		$rate = $_REQUEST['cost'][$key];
		$amount = $_REQUEST['amount'][$key];
		$ledgercode=$_REQUEST['legdercode'][$key];
		$ledgername=$_REQUEST['legdername'][$key];
		$ledgeranum=$_REQUEST['ledgeranum'][$key];
		$itemcode = $medicinecode;
		$store = $fromstore;
		$batchname = $batch;
		
		$fifo_code=$batch;
		$querycumstock21 = "select batchnumber from transaction_stock where  fifo_code='$batch'";
		$execcumstock21 = mysql_query($querycumstock21) or die ("Error in CumQuery21".mysql_error());
		$rescumstock21 = mysql_fetch_array($execcumstock21);
		$batchnumber = $rescumstock21["batchnumber"];
		/*include('autocompletestockbatch.php');
		$currentstock = $currentstock;
		$fromstorequantitybeforetransfer = $currentstock;
		$fromstorequantityaftertransfer = $currentstock - $transferquantity;
		*/
		$store = $tostore;
		$itemcode = $itemcode;
		
		
		$tnxquantity = $transferquantity;
		
			$query31 = "select * from master_itempharmacy where itemcode = '$medicinecode'"; 
			$exec31 = mysql_query($query31) or die ("Error in Query31".mysql_error());
			$res31 = mysql_fetch_array($exec31);
			
			$categoryname = $res31['categoryname'];
		
			if($medicinename!="" && $batchname!='' && $transferquantity>'0')
		{
		 $querycumstock21 = "select sum(batch_quantity) as cum_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$fromlocationcode'";
		$execcumstock21 = mysql_query($querycumstock21) or die ("Error in CumQuery21".mysql_error());
		$rescumstock21 = mysql_fetch_array($execcumstock21);
		$cum_quantity = $rescumstock21["cum_quantity"];
		$cum_quantity = $cum_quantity-$tnxquantity;
		
		if($cum_quantity=='0'){ $cum_stockstatus='0'; }else{$cum_stockstatus='1';}
		if($cum_quantity>='0')
		{
		$querybatstock21 = "select batch_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$fromlocationcode' and fifo_code='$fifo_code' and storecode ='$fromstore'";
		$execbatstock21 = mysql_query($querybatstock21) or die ("Error in batQuery21".mysql_error());
		$resbatstock21 = mysql_fetch_array($execbatstock21);
		$bat_quantity = $resbatstock21["batch_quantity"];
		$bat_quantity = $bat_quantity-$tnxquantity;
		$fromstorequantitybeforetransfer = $bat_quantity;
		$fromstorequantityaftertransfer = $bat_quantity - $tnxquantity;
		if($bat_quantity=='0'){ $batch_stockstatus='0'; }else{$batch_stockstatus='1';}
		if($bat_quantity>='0')
		{
		$queryupdatebatstock21 = "update transaction_stock set cum_stockstatus='0' ,batch_stockstatus='0' where itemcode='$itemcode' and locationcode='$fromlocationcode' and storecode='$fromstore' and fifo_code='$fifo_code'";
		$execupdatebatstock21 = mysql_query($queryupdatebatstock21) or die ("Error in updatebatQuery21".mysql_error());
		
		//$queryupdatebatstock21 = "update transaction_stock set cum_stockstatus='0' where itemcode='$medicinecode' and locationcode='$fromlocationcode'";
		//$execupdatebatstock21 = mysql_query($queryupdatebatstock21) or die ("Error in updatebatQuery21".mysql_error());
			
		 $stockquery21="insert into transaction_stock (fifo_code,tablename,itemcode, itemname, transaction_date,transactionfunction,description,
			batchnumber, batch_quantity, 
			transaction_quantity, cum_quantity, entrydocno, docstatus, cum_stockstatus, batch_stockstatus,locationcode,locationname,storecode,storename,username,ipaddress,recorddate,recordtime,updatetime,rate,totalprice,ledgercode,ledgername,ledgeranum)
			values ('$fifo_code','master_stock_transfer','$medicinecode', '$medicinename', '$dateonly','0', 'Stock Transfer From', 
			'$batchnumber', '$bat_quantity', '$tnxquantity', 
			'$cum_quantity', '$billnumbercode1', '','$cum_stockstatus','$batch_stockstatus', '$fromlocationcode','','$fromstore', '', '$username', '$ipaddress','$dateonly','$timeonly','$datetimeonly','$rate','$amount','$ledgercode','$ledgername','$ledgeranum')";
			
		$stockexecquery21=mysql_query($stockquery21) or die(mysql_error());
		
		
		
		if($typetransfer=='Transfer')
		{
			//$querycumstock2 = "select cum_quantity from transaction_stock where cum_stockstatus='1' and itemcode='$itemcode' and locationcode='$fromlocationcode'";
			//$execcumstock2 = mysql_query($querycumstock2) or die ("Error in CumQuery2".mysql_error());
			//$rescumstock2 = mysql_fetch_array($execcumstock2);
			//$cum_quantity = $rescumstock2["cum_quantity"];
			$cum_quantity = $cum_quantity+$tnxquantity;
			
			$querybatstock2 = "select batch_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$fromlocationcode' and fifo_code='$fifo_code' and storecode ='$tostore'";
			$execbatstock2 = mysql_query($querybatstock2) or die ("Error in batQuery2".mysql_error());
			$resbatstock2 = mysql_fetch_array($execbatstock2);
			$bat_quantity = $resbatstock2["batch_quantity"];
			$bat_quantity = $bat_quantity+$tnxquantity;
			$tostorequantitybeforetransfer = $bat_quantity;
			$tostorequantityaftertransfer = $bat_quantity + $tnxquantity;
			$queryupdatebatstock2 = "update transaction_stock set cum_stockstatus='0' ,batch_stockstatus='0' where itemcode='$itemcode' and locationcode='$fromlocationcode' and storecode='$tostore' and fifo_code='$fifo_code'";
			$execupdatebatstock2 = mysql_query($queryupdatebatstock2) or die ("Error in updatebatQuery2".mysql_error());
			
			//$queryupdatebatstock2 = "update transaction_stock set cum_stockstatus='0' where itemcode='$medicinecode' and locationcode='$fromlocationcode'";
			//$execupdatebatstock2 = mysql_query($queryupdatebatstock2) or die ("Error in updatebatQuery2".mysql_error());
			
			 $stockquery2="insert into transaction_stock (fifo_code,tablename,itemcode, itemname, transaction_date,transactionfunction,description,
				batchnumber, batch_quantity, 
				transaction_quantity, cum_quantity, entrydocno, docstatus, cum_stockstatus, batch_stockstatus,locationcode,locationname,storecode,storename,username,ipaddress,recorddate,recordtime,updatetime,rate,totalprice,ledgercode,ledgername,ledgeranum)
				values ('$fifo_code','master_stock_transfer','$medicinecode', '$medicinename', '$dateonly','1', 'Stock Transfer To', 
				'$batchnumber', '$bat_quantity', '$tnxquantity', 
				'$cum_quantity', '$billnumbercode1', '','1','1', '$fromlocationcode','','$tostore', '', '$username', '$ipaddress','$dateonly','$timeonly','$datetimeonly','$rate','$amount','$ledgercode','$ledgername','$ledgeranum')";
				
			$stockexecquery2=mysql_query($stockquery2) or die(mysql_error());
		}
	 $medicinequery2="insert into master_stock_transfer(fifo_code,docno,fromstore,tostore,itemcode,itemname,transferquantity,batch,fromstorequantitybeforetransfer,fromstorequantityaftertransfer,tostorequantitybeforetransfer,tostorequantityaftertransfer,rate,amount,username,ipaddress,companyanum,locationcode,recordstatus,entrydate,categoryname,typetransfer,locationname)values('$fifo_code','$billnumbercode1','$fromstore','$tostore','$medicinecode','$medicinename','$transferquantity','$batchnumber','$fromstorequantitybeforetransfer','$fromstorequantityaftertransfer','$tostorequantitybeforetransfer','$tostorequantityaftertransfer','$rate','$amount','$username','$ipaddress','$companyanum','$locationcode','completed','$updatedatetime','$categoryname','$typetransfer','$locationname')";
	
	$execquery2=mysql_query($medicinequery2) or die(mysql_error());
		if($typetransfer=='Consumable')
			{
				$medicinequery2="insert into consumedstock(docno,typetransfer,fromstore,toaccountcode,itemcode,itemname,transferquantity,batch,fromstorequantitybeforetransfer,fromstorequantityaftertransfer,tostorequantitybeforetransfer,tostorequantityaftertransfer,rate,amount,username,ipaddress,companyanum,recordstatus,entrydate,categoryname,locationname,locationcode,tolocationname,tolocationcode,fifo_code)
				values('$billnumbercode1','$typetransfer','$fromstore','$tostore','$medicinecode','$medicinename','$tnxquantity','$batchnumber','$fromstorequantitybeforetransfer','$fromstorequantityaftertransfer','$tostorequantitybeforetransfer','$tostorequantityaftertransfer','$rate','$amount','$username','$ipaddress','$companyanum','completed','$updatedatetime','$categoryname','$fromlocationname','$fromlocationcode','$tolocationname','$tolocationcode','$fifo_code')";
				
				$execquery2=mysql_query($medicinequery2) or die(mysql_error());
			}
			
		$query55 = "update master_internalstockrequest set recordstatus = 'completed' where docno = '$requestdocno' and itemcode='$medicinecode' ";
		$exec55 = mysql_query($query55) or die(mysql_error());
		}
		}
		}
		/*else
		{
			$query55 = "update master_internalstockrequest set recordstatus = 'discarded' and itemcode='$medicinecode' where docno = '$requestdocno'";
			$exec55 = mysql_query($query55) or die(mysql_error());
		}*/
		}
		header("location:mainmenu1.php");
		exit;
}

?>
<?php

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
$docno = $_REQUEST['docno'];
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	
	$query3 = "update master_internalstockrequest set recordstatus = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	
	header("location:stocktransfer.php?docno=$docno");

}

?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$paynowbillprefix = 'ITRN-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from master_stock_transfer order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='ITRN-'.'1';
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
	
	
	$billnumbercode = 'ITRN-'.$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
?>
<?php
if(isset($_REQUEST['docno']))
{
$docno = $_REQUEST['docno'];

$query43 = "select * from master_internalstockrequest where docno='$docno'";
$exec43 = mysql_query($query43) or die(mysql_error()); 
$res43 = mysql_fetch_array($exec43);
$from = $res43['fromstore'];
$to = $res43['tostore'];
$typetransfer = $res43['typetransfer'];
if($typetransfer=='transfer')
{
	$typetransfer='Transfer';
}
else
{
	$typetransfer='Consumable';
}



$queryfrom751 = "select store from master_store where storecode='$from'";
$execfrom751 = mysql_query($queryfrom751) or die(mysql_error());
$resfrom751 = mysql_fetch_array($execfrom751);
$fromname = $resfrom751['store'];

$queryto751 = "select store from master_store where storecode='$to'";
$execto751 = mysql_query($queryto751) or die(mysql_error());
$resto751 = mysql_fetch_array($execto751);
$toname = $resto751['store'];
}
?>
<script>
function funcOnLoadBodyFunctionCall()
{

		funcstoreDropDownSearch4();
		funcCustomerDropDownSearch4();
	
	
}
function btnDeleteClick10(delID)
{
	//alert ("Inside btnDeleteClick.");
	
	//alert(pharmamount);
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
<script>
function medicinecheck()
{
if(document.cbform1.typetransfer.value=="Consumable"){

	if(document.cbform1.expense.value=="")
	{
		alert("Please Select the Expense Ledger");
		document.cbform1.expense.focus();
		return false;
	}

}else{

	if(document.cbform1.tostore.value=="")
	{
		alert("Please Select the store");
		document.cbform1.tostore.focus();
		return false;
	}

}

	varUserChoice = confirm('Are You Sure Want To Save This Entry?'); 
	//alert(fRet); 
	if (varUserChoice == false)
	{
		alert ("Entry Cancelled");
		return false;
	}
//        form.cbform1.submit();
document.getElementById("cbform1").submit();
	document.getElementById("savebutton").disabled = true;
	return true;
	
}
function amountcalc(serial)
{
var serial = serial;
var transferqty = document.getElementById("transferqty"+serial+"").value;
var batch = document.getElementById("batch"+serial+"").value;
if(batch == '')
{
alert("Please Select Batch");
document.getElementById("transferqty"+serial+"").value = 0;

document.getElementById("amount"+serial+"").value = 0.00;

return false;
}
var reqquantity = document.getElementById("reqquantity"+serial+"").value;
if(parseInt(transferqty) > parseInt(reqquantity))
{
alert("Transfer Quantity cannot be morethan Requested Quantity");
document.getElementById("transferqty"+serial+"").value = 0;

document.getElementById("amount"+serial+"").value = 0.00;

return false;
}

var availqty = document.getElementById("availablestock"+serial+"").value;
if(parseInt(transferqty) > parseInt(availqty))
{
alert("Transfer Quantity cannot be morethan Available Quantity");
document.getElementById("transferqty"+serial+"").value = 0;

document.getElementById("amount"+serial+"").value = 0.00;

return false;
}

var costprice = document.getElementById("cost"+serial+"").value;
var amount = parseFloat(transferqty) * parseFloat(costprice);
document.getElementById("amount"+serial+"").value = amount.toFixed(2);
}
function valid()
{
//alert("hi");
var numrows = document.getElementById("numrows").value;
for(i=1;i<=numrows;i++)
{
	var batch = document.getElementById("batch"+i+"").value;
	if(batch=='')
	{
	 alert("Select Batch");
	 return false;
	}
}
//return false;
}

function funcDeleteMedicine(varPaymentTypeAutoNumber)
{
    var varPaymentTypeAutoNumber = varPaymentTypeAutoNumber;
	var fRet;
	fRet = confirm('Are you sure want to delete this account name '+varPaymentTypeAutoNumber+'?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("Payment Type Entry Delete Completed.");
		//return false;
	}
	if (fRet == false)
	{
		alert ("Payment Type Entry Delete Not Completed.");
		return false;
	}
	//return false;

}

</script>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
..bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<?php include("js/dropdownlist1scriptingtostore.php"); ?>
<script type="text/javascript" src="js/autocomplete_store.js"></script>
<script type="text/javascript" src="js/autosuggeststore.js"></script>

<?php include ("js/dropdownlist1scriptingrequestmedicine.php"); ?>
<script type="text/javascript" src="js/autosuggestrequestmedicine.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_requestmedicine.js"></script>


<?php include ("js/dropdownlist1scriptingrequestmedicine.php"); ?>
<script type="text/javascript" src="js/autosuggestrequestmedicine.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_requestmedicine.js"></script>

<script type="text/javascript" src="js/insertnewitemrequestmedicine.js"></script>
<script type="text/javascript" src="js/batchselectionscript.js"></script>
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
text-align:center;
FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bali
{
text-align:right;
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
</style>
</head>

<script src="js/datetimepicker_css.js"></script>

<body onLoad="return funcOnLoadBodyFunctionCall();">
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
		
		
              <form name="cbform1" id="cbform1" method="post" action="stocktransfer.php">
                <table width="1197" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr bgcolor="#011E6A">
                      <td colspan="9" bgcolor="#E0E0E0" class="bodytext32"><strong> Stock transfer </strong></td>
                    </tr>
                    <tr>
                      <td width="35" align="left" valign="middle"  class="bodytext32"><strong>Doc No</strong></td>
                      <td width="217" align="left" valign="middle"><span class="bodytext32">
                        <input name="docnumber" type="text" id="docnumber" style="border: 1px solid #001E6A;" value="<?php echo $billnumbercode; ?>" size="8" autocomplete="off" readonly>
                        <input type="hidden" name="location" id="location" value="<?php echo $res7locationanum; ?>">
                        <input type="hidden" name="requestdocno" value="<?php echo $docno; ?>">
                        <input type="hidden" name="locationcode" id="locationcode" value="<?php echo $locationcode; ?>">
                        <input type="hidden" name="typetransfer" id="typetransfer" value="<?php echo $typetransfer; ?>">
                        
                      </span></td>
                      <td width="47" align="left" valign="middle" class="bodytext32"><strong>From </strong></td>
                      
                      <?php
					  
				$trans_status=0;	  
				$query2a = "select storecode,defaultstore from master_employeelocation WHERE username='$username' and defaultstore='default'"; 
				$exec2a = mysql_query($query2a) or die ("Error in Query2a".mysql_error());
				while ($res2a = mysql_fetch_array($exec2a))
				{
					$storecodeanuma = $res2a['storecode'];
					$defaultstorea = $res2a['defaultstore'];
					$query751a = "select store,storecode from master_store where auto_number='$storecodeanuma'";
					$exec751a = mysql_query($query751a) or die(mysql_error());
					$res751a = mysql_fetch_array($exec751a);
					$res2storea = $res751a['store'];
					$storecodea = $res751a['storecode'];

					if($to==$storecodea){
						$trans_status=1;	  
					}
				}
					  ?>
                      <td width="108" align="left" valign="middle" class="bodytext32"><?php 					  
  						if($trans_status==0){
							echo "<span class='bodytext32' style='color:red'> Can't Process </span>";
						}else{	
					  		echo $toname;
						}
						?>
                      <input type="hidden" name="fromstore" id="fromstore" value="<?php echo $to; ?>">
                      
                      </td>
                      <td width="55" align="middle" valign="middle" class="bodytext32"><strong>To </strong></td>
                      <td colspan="2" align="left" valign="middle" class="bodytext32"><?php echo $fromname; ?>
                          <input type="hidden" name="tostore" id="tostore" size="18" autocomplete="off" value="<?php echo $from; ?>"></td>
                      <input name="searchtostore1hiddentextbox" id="searchtostore1hiddentextbox" type="hidden" value="">
                      <input name="searchtostoreanum1" id="searchtostoreanum1" value="" type="hidden">
                      <td width="120" align="middle" valign="middle"><span class="bodytext32"><strong>Date</strong></span></td>
					  <td align="left" valign="top"><span class="bodytext32">&nbsp;
					    <input name="date" type="text" id="date" style="border: 1px solid #001E6A;" value="<?php echo $updatedatetime; ?>" size="8" autocomplete="off" readonly>
					  </span></td>
					  <td width="389" rowspan="2" align="left" valign="top"><span class="bodytext32">
					  <font color="blue"><strong>Please note:</strong> The items with proper batches will only affect the stock  transfers, items with out batches will be rejected automatically. </font>
  
					  </span></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top" class="bodytext32"><strong>Type Transfe</strong>r</td>
                      <td align="left" valign="top" class="bodytext32"><?php echo $typetransfer; ?></td>
					  <?php 
					  if($typetransfer == 'Consumable')
					  {
					  ?>
					  <td align="left" valign="top" class="bodytext32"><strong>Select Expense</strong></td>
					  <td align="left" valign="top" class="bodytext32">
					  <select name="expense" id="expense">
			  <option value="">Select Expense</option>
					<?php  $query2 = "select accountname,accountsmain,id from master_accountname where accountsmain IN  ('4') and recordstatus <> 'deleted'  order by accountname  ";
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			while ($res2 = mysql_fetch_array($exec2))
			{
				$id = $res2["id"];
				$accountname = $res2["accountname"];
				$accountsmain = $res2["accountsmain"];	
				?>			
				<option value="<?php echo $id;?>"><?php echo $accountname;?></option>
				<?php
			}
			?>
			</select>
			</td>
			<?php
			}
			?> 
			</tr>
             <tr>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ffffff"><strong>NO</strong></td>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ffffff"><strong>Item</strong></td>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ffffff"><strong>Req.Qty</strong></td>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ffffff"><strong>Batch</strong></td>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#ffffff"><strong>Exp.Dt</strong></td>
                      <td width="52" align="left" valign="middle" bgcolor="#ffffff" class="bodytext32"><strong>Avl.Qty</strong></td>
                      <td width="44" align="left" valign="middle" bgcolor="#ffffff" class="bodytext32"><strong>Trn.Qty</strong></td>
                      <td align="center" valign="middle" class="bodytext32" bgcolor="#ffffff"><strong>Cost</strong></td>
                      <td width="25" align="left" valign="middle" bgcolor="#ffffff" class="bodytext32"><strong>Amount</strong></td>
					  <td width="25" align="left" valign="middle" bgcolor="#ffffff" class="bodytext32"><strong>Delete</strong></td>					  
                    </tr>
                    <?php
					$sno ='';
					
					$query34 = "select * from master_internalstockrequest where docno='$docno' and recordstatus = 'pending'";
					$exec34 = mysql_query($query34) or die(mysql_error());
					$nums34 = mysql_num_rows($exec34);
					while($res34 = mysql_fetch_array($exec34))
					{
					$itemname = $res34['itemname'];
					$reqquantity = $res34['quantity'];
					$itemcode = $res34['itemcode'];
					$frommstore = $res34['fromstore'];
					$toostore = $res34['tostore'];
					$anum = $res34['auto_number'];
					$requestdocno = $res34['docno'];
					
					$query751 = "select * from master_store where storecode='$toostore'";
					$exec751 = mysql_query($query751) or die(mysql_error());
					$res751 = mysql_fetch_array($exec751);
					$locationnumber = $res751['location'];
					
					$query551 = "select * from master_location where auto_number='$locationnumber'";
					$exec551 = mysql_query($query551) or die(mysql_error());
					$res551 = mysql_fetch_array($exec551);
					$location = $res551['locationname'];
					$locationcode = $res551['locationcode'];
					
					$store = $frommstore;
					
									
					$companyanum = $_SESSION["companyanum"];
					$itemcode = $itemcode;
					
	//include ('autocompletestockcount1include1.php');
							
					
					$query67 = "select purchaseprice from master_medicine where itemcode='$itemcode'";
					$exec67 = mysql_query($query67) or die(mysql_error());
					$res67 = mysql_fetch_array($exec67);
					$costprice = $res67['purchaseprice'];
					$legdercode = '';
					$legdername = '';
					$ledgeranum = '';
					$sno = $sno + 1;
					?>
                    <tr>
                      <td align="left" valign="middle" class="bodytext32"><?php echo $sno; ?>
					  <input type="hidden" name="numrows" id="numrows" value="<?php echo $nums34; ?>">
					  </td>
                      <td align="left" valign="middle" class="bodytext32"><?php echo $itemname; ?>
				<input name="searchmedicinename1hiddentextbox" id="searchmedicinename1hiddentextbox" type="hidden" value="">
			  <input name="searchmedicineanum1" id="searchmedicineanum1" value="" type="hidden">

					  
                          <input type="hidden" name="itemname[]" id="itemname" value="<?php echo $itemname; ?>">
                          <input type="hidden" name="itemcode[]" id="itemcode<?php echo $sno; ?>" value="<?php echo $itemcode; ?>">
                          <input type="hidden" name="legdercode[]" id="legdercode<?php echo $sno; ?>" value="<?php echo $legdercode; ?>">
                          <input type="hidden" name="legdername[]" id="legdername<?php echo $sno; ?>" value="<?php echo $legdername; ?>">
                          <input type="hidden" name="ledgeranum[]" id="ledgeranum<?php echo $sno; ?>" value="<?php echo $ledgeranum; ?>">
                          
                          <input type="hidden" name="cost[]" id="cost<?php echo $sno; ?>" value="<?php echo $costprice; ?>"></td>
                      <td align="left" valign="middle" class="bodytext32"><?php echo $reqquantity; ?>
                          <input type="hidden" name="reqquantity[]" id="reqquantity<?php echo $sno; ?>" value="<?php echo $reqquantity; ?>"></td>
                      <td align="left" valign="top"><select name="batch[]" id="batch<?php echo $sno; ?>" onChange="return funcbatchselection('<?php echo $sno; ?>')">
                    
                          <option value="" selected="selected">Select Batch</option>
                          
                          <?php
			 

			$query44="select itemcode,batchnumber,batch_quantity,description,fifo_code from transaction_stock where storecode='".$toostore."' AND locationcode='".$locationcode."' AND itemcode = '$itemcode' and batch_stockstatus='1' and (batchnumber in(select batchnumber from materialreceiptnote_details where expirydate>now() and itemcode ='$itemcode') or batchnumber in(select batchnumber from purchase_details where expirydate>now() and itemcode ='$itemcode'))";
$exec44=mysql_query($query44);
$numb44=mysql_num_rows($exec44);
while($res44=mysql_fetch_array($exec44))
{

$itemcode = $res44['itemcode'];
$batchname = $res44['batchnumber']; 
$currentstock = $res44["batch_quantity"];
$itemcode = $itemcode;
$batchname = $batchname;
$description = $res44["description"];
$fifo_code = $res44["fifo_code"];
if($currentstock > 0 )
			{
echo '<option value="'.$fifo_code.'">'.$batchname.'('.$currentstock.')</option>';
			}
			}
			  ?>
                      </select></td>
                      
                      <td align="left" valign="middle"><input type="text" name="expirydate" id="expirydate<?php echo $sno; ?>" class="bal" size="10" readonly></td>
                      <td align="left" valign="middle"><input type="text" name="availablestock" id="availablestock<?php echo $sno; ?>" class="bal" size="10" readonly></td>
                      <td align="left" valign="middle" class="bodytext32"><input type="text" name="transferqty[]" id="transferqty<?php echo $sno; ?>" size="6" onKeyUp="return amountcalc('<?php echo $sno; ?>');"></td>
                      <td align="left" valign="middle" class="bodytext32"><input type="text" id="costprice<?php echo $sno; ?>" name="cost[]" class="bal" value="<?php echo $costprice; ?>" readonly></td>
                      <td align="left" valign="middle"><input type="text" name="amount[]" id="amount<?php echo $sno; ?>" class="bal" size="10" readonly></td>
					 <td> 
					  <a href="stocktransfer.php?st=del&&anum=<?php echo $anum;?>&&docno=<?php echo $docno;?>" class="bodytext32"  onClick="return funcDeleteMedicine('<?php echo $itemname;?>')">
					<font color="blue"><strong>Delete</strong></font></a></div></td>
						
                      <?php
			  
	?>
                    </tr>
                    <?php
					}
					?>
                    <tr>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#cccccc">&nbsp;</td>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#cccccc">&nbsp;</td>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#cccccc">&nbsp;</td>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#cccccc">&nbsp;</td>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#cccccc">&nbsp;</td>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#cccccc">&nbsp;</td>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#cccccc">&nbsp;</td>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#cccccc">&nbsp;</td>
					  <td align="left" valign="middle" class="bodytext32" bgcolor="#cccccc">&nbsp;</td>
                      <td width="50" align="left" valign="middle" bgcolor="#cccccc" class="bodytext32">&nbsp;</td>
                    </tr>
                  <td align="left" valign="middle" class="bodytext32"></td>
                      <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">
					<input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                    <?php
					if($trans_status==1){ ?>
                          <input  style="border: 1px solid #001E6A" type="submit" value="Save" name="Submit" id="savebutton" onClick="return medicinecheck();"/>
                    <?php } ?>      
                    </td>
					<td align="left" valign="top">
					<a href="editstocrequest.php?docno=<?php echo $docno;?>" class="bodytext32"><font color="blue"><strong>Add New</strong></font> </a> &nbsp;&nbsp;
                  
                  <a href="print_stockrequest.php?docno=<?php echo $docno;?>" target="_blank" class="bodytext32"><img src="images25/pdfdownload.jpg" width="40"></a>
                  
                  </tr>
                </table>
              </form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
   
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

