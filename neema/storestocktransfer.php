<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$dateonly = date("Y-m-d");
$timeonly = date("H:i:s");
$datetimeonly = date("Y-m-d H:i:s");
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];


$docno = $_SESSION['docno'];
 //get location for sort by location purpose
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
	if($location!='')
	{
		  $locationcode=$location;
		}
		//location get end here
		
						
$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
$res1 = mysql_fetch_array($exec1);

$res1location = $res1["locationname"];
$locationcode = $res1["locationcode"];
$query2 = "select ms.store,ms.storecode from master_store AS ms LEFT JOIN master_location AS ml ON ms.location=ml.auto_number WHERE ml.locationcode = '".$locationcode."'";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);

 $res2storename = $res2["store"];
 $res2storecode = $res2["storecode"];


if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if ($cbfrmflag1 == 'cbfrmflag1')
{
//here get location name and code for inserting
$locationnameget=isset($_REQUEST['locationname'])?$_REQUEST['locationname']:'';
$locationcodeget=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
$storecode=isset($_REQUEST['tostore'])?$_REQUEST['tostore']:'';

//ends here
$requestdocno = $_REQUEST['requestdocno'];
$typetransfer = $_REQUEST['typetransfer'];

$query23 = "select * from master_employee where username='$username'";
$exec23 = mysql_query($query23) or die(mysql_error());
$res23 = mysql_fetch_array($exec23);
$res7locationanum = $res23['location'];

$query55 = "select * from master_location where auto_number='$res7locationanum'";
$exec55 = mysql_query($query55) or die(mysql_error());
$res55 = mysql_fetch_array($exec55);
$location = $res55['locationname'];

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
	
	$fromlocationcode = $_REQUEST['location'];
	
	$query56 = "select * from master_location where locationcode='$fromlocationcode'";
	$exec56 = mysql_query($query56) or die(mysql_error());
	$res56 = mysql_fetch_array($exec56);
	$fromlocationname = $res56['locationname'];

	//$tolocationcode = $_REQUEST['tolocation'];
	$tolocationcode = '';
	
	$query56 = "select * from master_location where locationcode='$tolocationcode'";
	$exec56 = mysql_query($query56) or die(mysql_error());
	$res56 = mysql_fetch_array($exec56);
	$tolocationname = $res56['locationname'];

	$fromstore = $_REQUEST['fromstore'];
	$tostore = $_REQUEST['tostore'];
	
	for($j=1;$j<50;$j++)
	{	
		if(isset($_REQUEST['serialnumber'.$j]))
		{
			$serialnumber = $_REQUEST['serialnumber'.$j];
		
			if($serialnumber != '')
			{
			   
		$medicinename=$_REQUEST['medicinename'.$j];
		$medicinename=trim($medicinename);
		$medicinecode=$_REQUEST['medicinecode'.$j];
		//$transferquantity = $_REQUEST['transferqty'.$j];
		$batch = $_REQUEST['batch'.$j];
		$expdate = $_REQUEST['expdate'.$j];
		$avlquantity = $_REQUEST['avlquantity'.$j];
		$tnxquantity = $_REQUEST['tnxquantity'.$j];
		$rate = $_REQUEST['costprice'.$j];
		$amount = $_REQUEST['amount'.$j];
		$itemcode = $medicinecode;
		$store = $fromstore;
		$fifo_code = $batch;
		
		//include('autocompletestockbatch.php');
		$querybatstock2 = "select batch_quantity,batchnumber from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$fromlocationcode' and fifo_code='$fifo_code' and storecode ='$store'";
		$execbatstock2 = mysql_query($querybatstock2) or die ("Error in batQuery2".mysql_error());
		$resbatstock2 = mysql_fetch_array($execbatstock2);
		$bat_quantity = $resbatstock2["batch_quantity"];
		$batchnumber = $resbatstock2["batchnumber"];
		$currentstock = $bat_quantity;
		$fromstorequantitybeforetransfer = $currentstock;
		$fromstorequantityaftertransfer = $currentstock - $tnxquantity;
		
		$store = $tostore;
		$itemcode = $itemcode;
		$querybatstock2 = "select batch_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$fromlocationcode' and fifo_code='$fifo_code' and storecode ='$store'";
		$execbatstock2 = mysql_query($querybatstock2) or die ("Error in batQuery2".mysql_error());
		$resbatstock2 = mysql_fetch_array($execbatstock2);
		$bat_quantity = $resbatstock2["batch_quantity"];
		$currentstock = $bat_quantity;
		$currentstock = $currentstock;
		$tostorequantitybeforetransfer = $currentstock;
		$tostorequantityaftertransfer = $currentstock + $tnxquantity;
		
			$query31 = "select * from master_itempharmacy where itemcode = '$medicinecode'"; 
			$exec31 = mysql_query($query31) or die ("Error in Query31".mysql_error());
			$res31 = mysql_fetch_array($exec31);
			
			$categoryname = $res31['categoryname'];
		$batchname=$batchnumber;
			if($medicinename!="" && $batchname!='' && $tnxquantity>'0')
		{
			
		$querycumstock2 = "select cum_quantity from transaction_stock where cum_stockstatus='1' and itemcode='$itemcode' and locationcode='$fromlocationcode'";
		$execcumstock2 = mysql_query($querycumstock2) or die ("Error in CumQuery2".mysql_error());
		$rescumstock2 = mysql_fetch_array($execcumstock2);
		$cum_quantity = $rescumstock2["cum_quantity"];
		$cum_quantity = $cum_quantity-$tnxquantity;
		
		if($cum_quantity=='0'){ $cum_stockstatus='0'; }else{$cum_stockstatus='1';}
		$aa = 'tnx';
		if($aa=='tnx')
		{
		$querybatstock2 = "select batch_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$fromlocationcode' and fifo_code='$fifo_code' and storecode ='$fromstore'";
		$execbatstock2 = mysql_query($querybatstock2) or die ("Error in batQuery2".mysql_error());
		$resbatstock2 = mysql_fetch_array($execbatstock2);
		$bat_quantity = $resbatstock2["batch_quantity"];
		$bat_quantity = $bat_quantity-$tnxquantity;
		
		if($bat_quantity=='0'){ $batch_stockstatus='0'; }else{$batch_stockstatus='1';}
		if($bat_quantity>='0')
		{
		$queryupdatebatstock2 = "update transaction_stock set cum_stockstatus='0' ,batch_stockstatus='0' where itemcode='$itemcode' and locationcode='$fromlocationcode' and storecode='$fromstore' and fifo_code='$fifo_code'";
		$execupdatebatstock2 = mysql_query($queryupdatebatstock2) or die ("Error in updatebatQuery2".mysql_error());
		
			
		$stockquery2="insert into transaction_stock (fifo_code,tablename,itemcode, itemname, transaction_date,transactionfunction,description,
			batchnumber, batch_quantity, 
			transaction_quantity, cum_quantity, entrydocno, docstatus, cum_stockstatus, batch_stockstatus,locationcode,locationname,storecode,storename,username,ipaddress,recorddate,recordtime,updatetime,rate,totalprice)
			values ('$fifo_code','master_stock_transfer','$medicinecode', '$medicinename', '$dateonly','0', 'Stock Transfer From', 
			'$batchnumber', '$bat_quantity', '$tnxquantity', 
			'$cum_quantity', '$billnumbercode1', '','$cum_stockstatus','$batch_stockstatus', '$fromlocationcode','','$fromstore', '', '$username', '$ipaddress','$dateonly','$timeonly','$datetimeonly','$rate','$amount')";
			
		$stockexecquery2=mysql_query($stockquery2) or die(mysql_error());
		
		
		
		if($typetransfer=='Transfer')
		{
			$querycumstock2 = "select cum_quantity from transaction_stock where cum_stockstatus='1' and itemcode='$itemcode' and locationcode='$fromlocationcode'";
			$execcumstock2 = mysql_query($querycumstock2) or die ("Error in CumQuery2".mysql_error());
			$rescumstock2 = mysql_fetch_array($execcumstock2);
			$cum_quantity = $rescumstock2["cum_quantity"];
			$cum_quantity = $cum_quantity+$tnxquantity;
			
			$querybatstock2 = "select batch_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$fromlocationcode' and fifo_code='$fifo_code' and storecode ='$tostore'";
			$execbatstock2 = mysql_query($querybatstock2) or die ("Error in batQuery2".mysql_error());
			$resbatstock2 = mysql_fetch_array($execbatstock2);
			$bat_quantity = $resbatstock2["batch_quantity"];
			$bat_quantity = $bat_quantity+$tnxquantity;
			
			$queryupdatebatstock2 = "update transaction_stock set cum_stockstatus='0' ,batch_stockstatus='0' where itemcode='$itemcode' and locationcode='$fromlocationcode' and storecode='$tostore' and fifo_code='$fifo_code'";
			$execupdatebatstock2 = mysql_query($queryupdatebatstock2) or die ("Error in updatebatQuery2".mysql_error());
			
			
			$stockquery2="insert into transaction_stock (fifo_code,tablename,itemcode, itemname, transaction_date,transactionfunction,description,
				batchnumber, batch_quantity, 
				transaction_quantity, cum_quantity, entrydocno, docstatus, cum_stockstatus, batch_stockstatus,locationcode,locationname,storecode,storename,username,ipaddress,recorddate,recordtime,updatetime,rate,totalprice)
				values ('$fifo_code','master_stock_transfer','$medicinecode', '$medicinename', '$dateonly','1', 'Stock Transfer To', 
				'$batchnumber', '$bat_quantity', '$tnxquantity', 
				'$cum_quantity', '$billnumbercode1', '','1','1', '$fromlocationcode','','$tostore', '', '$username', '$ipaddress','$dateonly','$timeonly','$datetimeonly','$rate','$amount')";
				
			$stockexecquery2=mysql_query($stockquery2) or die(mysql_error());
		}
			
			$medicinequery2="insert into master_stock_transfer(docno,typetransfer,fromstore,tostore,itemcode,itemname,transferquantity,batch,fromstorequantitybeforetransfer,fromstorequantityaftertransfer,tostorequantitybeforetransfer,tostorequantityaftertransfer,rate,amount,username,ipaddress,companyanum,recordstatus,entrydate,categoryname,locationname,locationcode,tolocationname,tolocationcode,fifo_code)
			values('$billnumbercode1','$typetransfer','$fromstore','$tostore','$medicinecode','$medicinename','$tnxquantity','$batchnumber','$fromstorequantitybeforetransfer','$fromstorequantityaftertransfer','$tostorequantitybeforetransfer','$tostorequantityaftertransfer','$rate','$amount','$username','$ipaddress','$companyanum','completed','$updatedatetime','$categoryname','$fromlocationname','$fromlocationcode','$tolocationname','$tolocationcode','$fifo_code')";
			
			$execquery2=mysql_query($medicinequery2) or die(mysql_error());
			if($typetransfer=='Consumable')
			{
				$medicinequery2="insert into consumedstock(docno,typetransfer,fromstore,toaccountcode,itemcode,itemname,transferquantity,batch,fromstorequantitybeforetransfer,fromstorequantityaftertransfer,tostorequantitybeforetransfer,tostorequantityaftertransfer,rate,amount,username,ipaddress,companyanum,recordstatus,entrydate,categoryname,locationname,locationcode,tolocationname,tolocationcode,fifo_code)
				values('$billnumbercode1','$typetransfer','$fromstore','$tostore','$medicinecode','$medicinename','$tnxquantity','$batchnumber','$fromstorequantitybeforetransfer','$fromstorequantityaftertransfer','$tostorequantitybeforetransfer','$tostorequantityaftertransfer','$rate','$amount','$username','$ipaddress','$companyanum','completed','$updatedatetime','$categoryname','$fromlocationname','$fromlocationcode','$tolocationname','$tolocationcode','$fifo_code')";
				
				$execquery2=mysql_query($medicinequery2) or die(mysql_error());
			}
		}
		}
	
		//$query55 = "update master_internalstockrequest set recordstatus = 'completed' where docno = '$requestdocno' and itemcode='$medicinecode' ";
		//$exec55 = mysql_query($query55) or die(mysql_error());
		}
		
		}
		
		}
		/*else
		{
			$query55 = "update master_internalstockrequest set recordstatus = 'discarded' and itemcode='$medicinecode' where docno = '$requestdocno'";
			$exec55 = mysql_query($query55) or die(mysql_error());
		}*/
		}
		
		//header("location:mainmenu1.php");
}

?>
<?php

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$docno = $_REQUEST['docno'];
if ($st == 'del')
{
	$delanum = $_REQUEST["anum"];
	
	$query3 = "update master_internalstockrequest set recordstatus = 'deleted' where auto_number = '$delanum'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	
	header("location:storestocktransfer.php");

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
/*$query23 = "select * from master_employee where username='$username'";
$exec23 = mysql_query($query23) or die(mysql_error());
$res23 = mysql_fetch_array($exec23);
$res7locationanum = $res23['location'];*/
$query23 = "select * from master_employeelocation where username='$username' and locationcode = '$locationcode'";
$exec23 = mysql_query($query23) or die(mysql_error());
$res23 = mysql_fetch_array($exec23);
$res7locationanum = $res23['locationcode'];
$location = $res23['locationname'];
$locationanum = $res23['locationanum'];

/*$query55 = "select * from master_location where auto_number='$res7locationanum'";
$exec55 = mysql_query($query55) or die(mysql_error());
$res55 = mysql_fetch_array($exec55);
$location = $res55['locationname'];
*/
$res7storeanum = $res23['storecode'];

$query75 = "select * from master_store where auto_number='$res7storeanum'";
$exec75 = mysql_query($query75) or die(mysql_error());
$res75 = mysql_fetch_array($exec75);
$store = $res75['store'];
$storecode = $res75['storecode'];

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
if(document.cbform1.tostore.value=="")
	{
		alert("Please Select the store");
		document.cbform1.tostore.focus();
		return false;
	}

	
	
	return true;
	
}
function amountcalc(serial)
{
var serial = serial;
var transferqty = document.getElementById("transferqty").value;
var batch = document.getElementById("batch").value;
if(batch == '')
{
alert("Please Select Batch");
document.getElementById("transferqty").value = 0;

document.getElementById("amount").value = 0.00;

return false;
}
var reqquantity = document.getElementById("reqquantity").value;
if(parseInt(transferqty) > parseInt(reqquantity))
{
alert("Transfer Quantity cannot be morethan Requested Quantity");
document.getElementById("transferqty").value = 0;

document.getElementById("amount").value = 0.00;

return false;
}

var availqty = document.getElementById("availablestock").value;
if(parseInt(transferqty) > parseInt(availqty))
{
alert("Transfer Quantity cannot be morethan Available Quantity");
document.getElementById("transferqty").value = 0;

document.getElementById("amount").value = 0.00;

return false;
}

var costprice = document.getElementById("costprice").value;
if(costprice == "")
{
var costprice = 0.00;
}
var amount = parseFloat(transferqty) * parseFloat(costprice);
document.getElementById("amount").value = amount.toFixed(2);
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

function functioncheckstore()
{
	if(document.getElementById("fromstore").value=='')
	{
		alert("Please Select From Store");
		document.getElementById("fromstore").focus();
		return false;
		}
	}

function functiontostock(id)
{
	var tostore= document.getElementById('tostore').value;
	var fromstore = document.getElementById('fromstore').value;
	if(fromstore == tostore)
	{
		alert("From and To Store should not be same");
		document.getElementById('tostore').value = "";
		return false;
	}
	}

</script>
<script type="text/javascript">

function funcSelectFromStore(id)
{ 
	if(document.getElementById("typetransfer").value=='')
	{
		alert('please Select Type');
		document.getElementById("location").value='';
	}
	if(document.getElementById("typetransfer").value=="Transfer")
	{
		<?php 
		$query12 = "select * from master_location where status <> 'deleted'";
		$exec12 = mysql_query($query12) or die ("Error in Query11".mysql_error());
		while ($res12 = mysql_fetch_array($exec12))
		{
		$res12anum = $res12["auto_number"];
		$res12locationcode = $res12["locationcode"];
		?>
		if(document.getElementById("location").value=="<?php echo $res12locationcode; ?>")
		{
			document.getElementById("fromstore").options.length=null; 
			var combo = document.getElementById('fromstore'); 
			document.getElementById("tostore").options.length=null; 
			var comboto = document.getElementById('tostore'); 	
			<?php
			$loopcount=0;
			?>
			combo.options[<?php echo $loopcount;?>] = new Option ("Select Store", ""); 
			comboto.options[<?php echo $loopcount;?>] = new Option ("Select Store", ""); 
			<?php
			$query10 = "select * from master_store where location = '$res12anum' and recordstatus = ''";
			$exec10 = mysql_query($query10) or die ("error in query10".mysql_error());
			while ($res10 = mysql_fetch_array($exec10))
			{
			$loopcount = $loopcount+1;
			$res10anum = $res10["storecode"];
			$res10store = $res10["store"];
			?>
				combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10store;?>", "<?php echo $res10anum;?>"); 
				comboto.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10store;?>", "<?php echo $res10anum;?>"); 
			<?php 
			}
			?>
		}
		<?php
		}
		?>
	}
	else if(document.getElementById("typetransfer").value=="Consumable")
	{
		document.getElementById("fromstore").options.length=null; 
		var combo = document.getElementById('fromstore'); 
		document.getElementById("tostore").options.length=null; 
		var comboto = document.getElementById('tostore'); 
		combo.options[0] = new Option ("Select Store", ""); 
		<?php 
		$query12 = "select * from master_location where status <> 'deleted'";
		$exec12 = mysql_query($query12) or die ("Error in Query11".mysql_error());
		while ($res12 = mysql_fetch_array($exec12))
		{
		$res12anum = $res12["auto_number"];
		$res12locationcode = $res12["locationcode"];
		?>
		if(document.getElementById("location").value=="<?php echo $res12locationcode; ?>")
		{
				
			<?php
			$loopcount=0;
			?>
			combo.options[<?php echo $loopcount;?>] = new Option ("Select Store", ""); 
			//comboto.options[<?php echo $loopcount;?>] = new Option ("Select Store", ""); 
			<?php
			$query10 = "select * from master_store where location = '$res12anum' and recordstatus = ''";
			$exec10 = mysql_query($query10) or die ("error in query10".mysql_error());
			while ($res10 = mysql_fetch_array($exec10))
			{
			$loopcount = $loopcount+1;
			$res10anum = $res10["storecode"];
			$res10store = $res10["store"];
			?>
				combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10store;?>", "<?php echo $res10anum;?>"); 
				//comboto.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10store;?>", "<?php echo $res10anum;?>"); 
			<?php 
			}
			?>
		}
		<?php
		}
			$loopcount=0;
			?>
			comboto.options[<?php echo $loopcount;?>] = new Option ("Select Expenses", ""); 
			<?php
			$query2 = "select accountname,accountsmain,id from master_accountname where accountsmain IN  ('4') and recordstatus <> 'deleted'  order by accountname  ";
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			while ($res2 = mysql_fetch_array($exec2))
			{
				$id = $res2["id"];
				$accountname = $res2["accountname"];
				$accountsmain = $res2["accountsmain"];	
				$loopcount = $loopcount+1;
				?>			
				
				comboto.options[<?php echo $loopcount;?>] = new Option ("<?php echo $accountname;?>", "<?php echo $id;?>"); 
				<?php
			}
		?>
		
	}
	
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

<?php //include ("js/dropdownlist1scriptingrequestmedicine.php"); ?>
<!--<script type="text/javascript" src="js/autosuggestrequestmedicine.js"></script> 
<script type="text/javascript" src="js/autocomplete_requestmedicine.js"></script>-->


<?php include ("js/dropdownlist1scriptingrequestmedicine.php"); ?>
<script type="text/javascript" src="js/autosuggestrequestmedicine_1.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_requestmedicine.js"></script>
<script type="text/javascript" src="js/autosuggestbatch1.js"></script>

<script type="text/javascript" src="js/insertnewitemrequestmedicine_1.js"></script>
<script type="text/javascript" src="js/batchselectionscript_1.js"></script>
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
		
		
              <form name="cbform1" method="post" action="storestocktransfer.php">
                <table width="1197" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr bgcolor="#011E6A">
                      <td colspan="8" bgcolor="#E0E0E0" class="bodytext32"><strong>Store Stock transfer </strong></td>
                      <td colspan="5" bgcolor="#E0E0E0" class="bodytext32">&nbsp;</td>
                    </tr>
                    <tr bgcolor="#011E6A">
                      <td colspan="1" bgcolor="#E0E0E0" class="bodytext32"><strong>Type</strong></td>
                      <td colspan="12" bgcolor="#E0E0E0" class="bodytext32"><select name="typetransfer" id="typetransfer" onChange="return funcSelectFromStore(this.value)">
                      <option value="">Select Type</option>
                      <option value="Transfer">Transfer</option>
                      <option value="Consumable">Consumable</option>
                      </select></td>
                    </tr>
                    <tr>
                      <td width="50" align="left" valign="middle"  class="bodytext32"><strong>Doc No</strong></td>
                      <td align="left" class="bodytext3">
                        <input name="docnumber" type="text" id="docnumber" style="border: 1px solid #001E6A;" value="<?php echo $billnumbercode; ?>" size="8" autocomplete="off" readonly>
                        <input type="hidden" name="locationanum" id="locationanum" value="<?php echo $res7locationanum; ?>">
                        <input type="hidden" name="locationcode" id="locationcode" value="<?php echo $locationcode; ?>">
                        <input type="hidden" name="locationname" id="locationname" value="<?php echo $res1location; ?>">
                        <input type="hidden" name="requestdocno" value="<?php echo $docno; ?>">
                      </span></td>
					  <td align="left" class="bodytext3"><strong> Location</strong></td>
					  <td align="left" class="bodytext3"><select name="location" id="location" onChange="return funcSelectFromStore(this.value)"  style="border: 1px solid #001E6A;">
					  <option value="">Select Location</option>
                  <?php
						
						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						while ($res1 = mysql_fetch_array($exec1))
						{
						$res1location = $res1["locationname"];
						$res1locationanum = $res1["locationcode"];
						?>
						<option value="<?php echo $res1locationanum; ?>"><?php echo $res1location; ?></option>
						<?php
						}
						?>
                  </select></td>
                      <td width="77" align="left" valign="middle" class="bodytext32"><strong>From Store</strong></td>
                      <td width="112" align="left" valign="middle" class="bodytext32">
                       <select name="fromstore" id="fromstore" onChange="return functiontostock(this.value);">
                      <option value="">Select Store</option>
                      </select>
             </td>
			 <td align="left" class="bodytext3"><strong></strong></td>
					  <td align="left" class="bodytext3"></td>
                      <td width="55" align="middle" valign="middle" class="bodytext32"><strong>To Store</strong></td>
                      <td colspan="2" align="left" valign="middle" class="bodytext32">
                         <select name="tostore" id="tostore" onChange="return functiontostock(this.value);">
                          <option value="" >Select Store</option>
                          </select>
						 </td>
                      <input name="searchtostore1hiddentextbox" id="searchtostore1hiddentextbox" type="hidden" value="">
                      <input name="searchtostoreanum1" id="searchtostoreanum1" value="" type="hidden">
                      <td width="" align="middle" valign="middle"><span class="bodytext32"><strong>Date</strong></span></td>
					  <td align="left" valign="top"><span class="bodytext32">&nbsp;
					    <input name="date" type="text" id="date" style="border: 1px solid #001E6A;" value="<?php echo $updatedatetime; ?>" size="8" autocomplete="off" readonly>
					  </span></td>
                    </tr>
					</tbody>
					</table>
                <table width="1197" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                    <tr>
                      <td align="left" valign="left" class="bodytext32" bgcolor="#cccccc"><strong>Item</strong></td>
                      <td align="left" valign="left" class="bodytext32" bgcolor="#cccccc"><strong>Batch</strong></td>
                      <td align="left" valign="left" class="bodytext32" bgcolor="#cccccc"><strong>Exp.Dt</strong></td>
                      <td width="52" align="left" valign="left" bgcolor="#cccccc" class="bodytext32"><strong>Avl.Qty</strong></td>
                      <td width="44" align="left" valign="left" bgcolor="#cccccc" class="bodytext32"><strong>Trn.Qty</strong></td>
                      <td align="center" valign="left" class="bodytext32" bgcolor="#cccccc"><strong>Cost</strong></td>
                      <td width="50" align="left" valign="left" bgcolor="#cccccc" class="bodytext32"><strong>Amount</strong></td>
					  <td align="center" valign="left" class="bodytext32" bgcolor="#cccccc"><strong></strong></td>
                    </tr>
					<tbody id="insertrow">
					</tbody>
                   <tr>
					  <input type="hidden" name="serialnumberinc" id="serialnumberinc" value="1">
					  <input type="hidden" name="medicinecode" id="medicinecode" value="">
                        <td><input name="medicinename" type="text" id="medicinename" size="35" autocomplete="off" onKeyDown="return StateSuggestionspharm4()" onKeyUp="return funcCustomerDropDownSearch4()" onClick="functioncheckstore()"></td>
								   <input name="searchmedicinename1hiddentextbox" id="searchmedicinename1hiddentextbox" type="hidden" value="">
			  <input name="searchmedicineanum1" id="searchmedicineanum1" value="" type="hidden">
			
						<input name="avlquantity" type="hidden" id="avlquantity" size="8"></td>
                      <td align="left" valign="top"><select name="batch[]" id="batch" 
                      onChange="return funcbatchselection(this.value)">
                          <option value="" selected="selected">Select Batch</option>
                      </select></td>
                      <td align="left" valign="left"><input type="text" name="expirydate[]" id="expirydate" class="bal" size="10" readonly></td>
					  <td align="left" valign="left"><input type="text" name="availablestock[]" id="availablestock" class="bal" size="10" readonly></td>
                      <td align="left" valign="left"><input type="hidden" name="reqquantity[]" id="reqquantity" class="bal" size="10" readonly>
                     <input type="text" name="transferqty[]" id="transferqty" size="6" onKeyUp="return amountcalc();"></td>
                      <td align="left" valign="left" class="bodytext32"><input type="text" id="costprice" name="cost[]" class="bal" value="" readonly></td>
                      <td align="left" valign="left"><input type="text" name="amount[]" id="amount" class="bal" size="10" readonly></td>
					<td width="118"><label>
                       <input type="button" name="Add" id="Add" value="Add" onClick="return insertitem10()" class="button" style="border: 1px solid #001E6A">
                       </label></td>
					
					 </tr>
                    
                    <tr>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#cccccc">&nbsp;</td>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#cccccc">&nbsp;</td>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#cccccc">&nbsp;</td>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#cccccc">&nbsp;</td>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#cccccc">&nbsp;</td>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#cccccc">&nbsp;</td>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#cccccc">&nbsp;</td>
                      <td align="left" valign="middle" class="bodytext32" bgcolor="#cccccc">&nbsp;</td>
					 </tr>
                  <td align="left" valign="middle" class="bodytext32"></td>
                      <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                   
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">
					<input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input  style="border: 1px solid #001E6A" type="submit" value="Save" name="Submit" onClick="return medicinecheck();"/>
						                        </td>
					<td align="left" valign="top">
				</td>
                  </tr>
                </table>
              </form>		</td>
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

