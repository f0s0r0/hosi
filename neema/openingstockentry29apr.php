<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
 $username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
 $query23 = "select * from master_employee where username='$username'";
$exec23 = mysql_query($query23) or die(mysql_error());
$res23 = mysql_fetch_array($exec23);
 $res7locationanum = $res23['location'];
 $query5 = "select * from master_store where location = '$res7locationanum' and recordstatus = ''";
$query55 = "select * from master_location where auto_number='$res7locationanum'";
$exec55 = mysql_query($query55) or die(mysql_error());
$res55 = mysql_fetch_array($exec55);
$location = $res55['locationname'];

$res7storeanum = $res23['store'];

$query75 = "select * from master_store where auto_number='$res7storeanum'";
$exec75 = mysql_query($query75) or die(mysql_error());
$res75 = mysql_fetch_array($exec75);
$store = $res75['store'];
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if ($cbfrmflag1 == 'cbfrmflag1')
{
$billnumber=$_REQUEST['docnumber'];
$serial = $_REQUEST['serialnumber'];

 $store = $_REQUEST['store'];

$number = $serial - 1;
for ($p=1;$p<=$number;$p++)
		{
				   
		 $medicinename=$_REQUEST['medicinename'.$p];
		 $medicinecode=$_REQUEST['medicinecode'.$p];
			
			$query23 = "select * from master_itempharmacy where itemcode = '$medicinecode'";
			$exec23 = mysql_query($query23) or die(mysql_error());
			$res23 = mysql_fetch_array($exec23);
			$categoryname = $res23['categoryname'];
		
		//echo $medicinecode;
		$salesrate=$_REQUEST['salesrate'.$p];
		
		$quantity=$_REQUEST['quantity'.$p];
		
	    $batch=$_REQUEST['batch'.$p];
		
		$expirydate=$_REQUEST['expirydate'.$p];
		
		$expirymonth = substr($expirydate, 0, 2);
			$expiryyear = substr($expirydate, 3, 2);
			$expiryday = '01';
			$expirydate = $expiryyear.'-'.$expirymonth.'-'.$expiryday;
		
		$itemsubtotal=$salesrate * $quantity;
		
		
		if($medicinename!="")
		{
	$medicinequery1="insert into purchase_details (itemcode, itemname, entrydate,suppliername,suppliercode,
	 quantity,allpackagetotalquantity,totalamount,
	 username, ipaddress, rate, subtotal, companyanum,batchnumber,expirydate,locationname,store,billnumber,categoryname)
	values ('$medicinecode', '$medicinename', '$updatedatetime', 'OPENINGSTOCK','OPSE-1',
	'$quantity','$quantity','$itemsubtotal',
	'$username', '$ipaddress', '$salesrate','$itemsubtotal','$companyanum','$batch','$expirydate','$location','$store','$billnumber','$categoryname')"; 
	
	$execquery1=mysql_query($medicinequery1) or die(mysql_error());
	
	$medicinequery2="insert into openingstock_entry (itemcode, itemname, transactiondate,transactionmodule,transactionparticular,
	 billnumber, quantity, 
	 username, ipaddress, rateperunit, totalrate, companyanum, companyname,batchnumber,expirydate,store,location)
	values ('$medicinecode', '$medicinename', '$updatedatetime', 'OPENINGSTOCK', 
	'BY STOCK ADD', '$billnumber', '$quantity', 
	'$username', '$ipaddress', '$salesrate','$itemsubtotal','$companyanum', '$companyname','$batch','$expirydate', '$store', '$location')";
	
	$execquery2=mysql_query($medicinequery2) or die(mysql_error());
	}
		}
		//header("location:mainmenu1.php");
}

?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$paynowbillprefix = 'OPS-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from openingstock_entry order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["billnumber"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='OPS-'.'1';
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
	
	
	$billnumbercode = 'OPS-'.$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
?>
<script>
function funcOnLoadBodyFunctionCall()
{


	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	 //To handle ajax dropdown list.
	funcCustomerDropDownSearch4();
	funcPopupPrintFunctionCall();
	
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

function validcheck()
{

if(document.getElementById("codevalue").value == 0)
{
alert("Please Add an Item");
return false;
}
	if(confirm("Are You Want To Save The Record?")==false){return false;}
}
</script>
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
<?php include("autocompletebuild_stockmedicine.php"); ?>
<script type="text/javascript" src="js/autosuggeststockmedicine1.js"></script>
<?php include("js/dropdownlist1scriptingstockmedicine.php"); ?>
<script type="text/javascript" src="js/autocomplete_stockmedicine.js"></script>
<script type="text/javascript" src="js/insertnewitem41.js"></script>
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
		
		
              <form name="cbform1" method="post" action="openingstockentry.php" onSubmit="return validcheck()">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="6" bgcolor="#CCCCCC" class="bodytext3"><strong>Opening Stock Entry </strong></td>
              </tr>
          
            <tr>
              <td width="23" align="left" valign="middle"  class="bodytext3">Date</td>
              <td width="175" align="left" valign="middle"><span class="bodytext3"><?php echo $updatedatetime; ?>
                <input name="date" type="hidden" id="date" style="border: 1px solid #001E6A;" value="<?php //echo $updatedatetime; ?>" size="8" autocomplete="off">
              </span></td>
			    <td width="44" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Store</td>
                <td width="209" align="left" valign="middle" class="bodytext3">
				  <select name="store" id="store">
               <option value=""> Select Store</option>
                 <?php
				$query5 = "select * from master_store where location = '$res7locationanum' and recordstatus = ''";
				$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
				while ($res5 = mysql_fetch_array($exec5))
				{
				
				$store = $res5["store"];
				?>
                  <option value="<?php echo $store; ?>"><?php echo $store; ?></option>
                  <?php
				}
				?>
                </select></td>
			    <td width="46" align="left" valign="middle"  class="bodytext3">Doc No</td>
              <td width="255" align="left" valign="middle"><span class="bodytext3"><?php echo $billnumbercode; ?>
                <input name="docnumber" type="hidden" id="docnumber" style="border: 1px solid #001E6A;" value="<?php echo $billnumbercode; ?>" size="8" autocomplete="off">
              </span></td>
              </tr>
	  <tr id="pressid">
				   <td colspan="12" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
				   <table id="presid" width="500" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="150" class="bodytext3">Medicine Name</td>
                       <td width="48" class="bodytext3">Sales Rate</td>
                       <td width="120" class="bodytext3">Quantity</td>
                      <td width="48" class="bodytext3">Batch</td>
                       <td width="48" class="bodytext3">Exp Date</td>
                     </tr>
					 <tr>
					 <div id="insertrow">					 </div></tr>
                     <tr>
					  <input type="hidden" name="serialnumber" id="serialnumber" value="1">
					  <input type="hidden" name="medicinecode" id="medicinecode" value="">
                        <td><input name="medicinename" type="text" id="medicinename" size="25" autocomplete="off" onKeyDown="return StateSuggestionspharm4()" onKeyUp="return funcCustomerDropDownSearch4()"></td>
						<td><input name="salesrate" type="text" id="salesrate" size="8"></td>
						<td><input name="quantity" type="text" id="quantity" size="8"></td>
						<td><input name="batch" type="text" id="batch" size="8"></td>
						<td><input name="expirydate" type="text" id="expirydate" size="8"></td>
						<td><label>
                       <input type="button" name="Add" id="Add" value="Add" onClick="return insertitem10()" class="button" style="border-radius:20px;">
                       </label></td>
					   </tr>
                     <input type="hidden" name="codevalue" id="codevalue" value="0">
					 <input type="hidden" name="h" id="h" value="0">
                   </table>				  </td>
			       </tr>
			   <tr>
              <td align="left" valign="middle" class="bodytext3"></td>
              <td colspan="2" align="left" valign="top">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input type="submit" value="Save" name="Submit" />                 </td>
            </tr>
          </tbody>
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

