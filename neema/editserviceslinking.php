<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];

$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysql_query($query) or die ("Error in Query1".mysql_error());
$res = mysql_fetch_array($exec);
	
	 $locationname  = $res["locationname"];
	 $locationcode = $res["locationcode"];

$querysto = "select storecode,locationanum from master_employeelocation where username='$username' AND locationcode = '".$locationcode."' and defaultstore='default' order by  storecode desc";
$execsto = mysql_query($querysto) or die(mysql_error());
$ressto = mysql_fetch_array($execsto);
    $res7storeanum = $ressto['storecode'];
	$res7locationanum = $ressto['locationanum'];

$query55 = "select * from master_location where auto_number='$res7locationanum'";
$exec55 = mysql_query($query55) or die(mysql_error());
$res55 = mysql_fetch_array($exec55);
$locationname = $res55['locationname']; 
$locationcode = $res55['locationcode']; 

//$res7storeanum = $res23['store'];

$query75 = "select ms.store,ms.storecode from master_store as ms where auto_number='$res7storeanum'";
$exec75 = mysql_query($query75) or die(mysql_error());
$res75 = mysql_fetch_array($exec75);
   $store = $res75['store'];
   $storecode = $res75['storecode'];
   
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if ($cbfrmflag1 == 'cbfrmflag1')
{
$services = $_REQUEST['services'];
$servicescode = $_REQUEST['servicescode'];
$serial = $_REQUEST['serialnumber'];
$number = $serial - 1;

$query78 = "update master_serviceslinking set recordstatus='deleted' where servicecode='$servicescode'";
$exec78 = mysql_query($query78) or die(mysql_error());


for ($p=1;$p<=$number;$p++)
		{
				   
		 $medicinename=$_REQUEST['medicinename'.$p];
		$medicinename=trim($medicinename);
		$query77="select * from master_medicine where itemname='$medicinename'";
			$exec77=mysql_query($query77);
			$num77=mysql_num_rows($exec77);
			//echo $num77;
			$res77=mysql_fetch_array($exec77);
			$medicinecode=$res77['itemcode'];
			
		$quantity=$_REQUEST['quantity'.$p];
		
	  	
		if($medicinename!="")
		{
		
	$medicinequery2="insert into master_serviceslinking (servicecode,servicename, itemcode, itemname, quantity,username, ipaddress,date)
	values ('$servicescode','$services','$medicinecode', '$medicinename','$quantity','$username', '$ipaddress','$updatedatetime')";
	
	$execquery2=mysql_query($medicinequery2) or die(mysql_error());
	}
		}
foreach($_POST['itemname'] as $key => $value)
		{
				   
		 $itemname=$_POST['itemname'][$key];
		$itemname=trim($itemname);
		$query77="select * from master_medicine where itemname='$itemname'";
			$exec77=mysql_query($query77);
			$num77=mysql_num_rows($exec77);
			//echo $num77;
			$res77=mysql_fetch_array($exec77);
			$itemcode=$res77['itemcode'];
			
		$quantity=$_POST['itemquantity'][$key];
		
	  	
		if($itemname!="")
		{
		
	$medicinequery2="insert into master_serviceslinking (servicecode,servicename, itemcode, itemname, quantity,username, ipaddress,date)
	values ('$servicescode','$services','$itemcode', '$itemname','$quantity','$username', '$ipaddress','$updatedatetime')";
	
	$execquery2=mysql_query($medicinequery2) or die(mysql_error());
	}
	
		}
		
		
		header("location:mainmenu1.php");
		exit;
}

if (isset($_REQUEST["code"])) { $code = $_REQUEST["code"]; } else { $code = ""; }
?>
<?php
$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
include ("autocompletebuild_services1.php");
?>
<?php
$query23 = "select * from master_employee where username='$username'";
$exec23 = mysql_query($query23) or die(mysql_error());
$res23 = mysql_fetch_array($exec23);
$res7locationanum = $res23['location'];

$query55 = "select * from master_location where auto_number='$res7locationanum'";
$exec55 = mysql_query($query55) or die(mysql_error());
$res55 = mysql_fetch_array($exec55);
$location = $res55['locationname'];
$locationcode = $res55['locationcode'];

$res7storeanum = $res23['store'];

$query75 = "select * from master_store where auto_number='$res7storeanum'";
$exec75 = mysql_query($query75) or die(mysql_error());
$res75 = mysql_fetch_array($exec75);
$store = $res75['store'];

$query31 = "select * from master_serviceslinking where servicecode = '$code' group by servicecode";
$exec31 = mysql_query($query31) or die(mysql_error());
$res31 = mysql_fetch_array($exec31);
$servicename = $res31['servicename'];
?>
<script>
function funcOnLoadBodyFunctionCall()
{

	funcCustomerDropDownSearch4();
	funcCustomerDropDownSearch3();
	
	
}
function btnDeleteClick10(delID)
{
	//alert ("Inside btnDeleteClick.");
	
	//alert(pharmamount);
	var varDeleteID = delID;
	
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
function validcheck()
{
if(confirm("Do You Want To Save The Record? ")==false) {return false;}	
}
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

<?php include ("js/dropdownlist1scriptingservices1.php"); ?>
<script type="text/javascript" src="js/autocomplete_services1.js"></script>
<script type="text/javascript" src="js/autosuggestservices1.js"></script>

<?php include ("js/dropdownlist1scriptingrequestmedicine.php"); ?>
<script type="text/javascript" src="js/autosuggestrequestmedicine.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_requestmedicine.js"></script>

<script type="text/javascript" src="js/insertnewitemserviceslinking.js"></script>
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
		
		
              <form name="cbform1" method="post" action="editserviceslinking.php" onSubmit="return validcheck()">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
		   <tr>
              <td colspan="8" bgcolor="#CCCCCC" class="bodytext3"><strong>Edit Services Linking </strong></td>
              </tr>
            <tr>
              <td colspan="2" class="bodytext3"><strong> Select Service </strong></td>
			   <td colspan="6" class="bodytext3"><input name="services" type="text" id="services" size="69" readonly value="<?php echo $servicename; ?>">
			   <input type="hidden" name="servicescode" id="servicescode" value="<?php echo $code; ?>">
			   <input name="rate3[]" type="hidden" id="rate3" readonly size="8">
			   <input type="hidden" name="location" id="location" value="<?php echo $locationcode; ?>">
				<input type="hidden" name="fromstore" id="fromstore" value="<?php echo $storecode; ?>"></td>
              </tr>
          
           
	  <tr id="pressid">
				   <td colspan="15" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
				   <table id="presid" width="500" border="0" cellspacing="1" cellpadding="1">
				   <tbody id="insertrow">
                     <tr>
                       <td class="bodytext3">Item</td>
                       <td class="bodytext3">Qty</td>
                     
                     </tr>
					 <?php
				$itemcount = "";
				//To populate items already in the bill if in edit mode.
				$query23 = "select * from master_serviceslinking where servicecode = '$code' and recordstatus <> 'deleted'";
$exec23 = mysql_query($query23) or die(mysql_error());
while($res23 = mysql_fetch_array($exec23))
{
$itemcount = $itemcount + 1;
$itemcode = $res23['itemcode'];
$itemname = $res23['itemname'];
$quantity = $res23['quantity'];

?>
<TR id="idTR<?php echo $itemcount; ?>">
<td id="idTD1<?php echo $itemcount; ?>" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">
<input name="itemname[]" value="<?php echo $itemname; ?>" id="serialnumber<?php echo $itemcount; ?>" readonly style="border: 0px solid #001E6A; text-align:left" size="40" />
 <input type="hidden" name="itemcode[]" id="medicinecode<?php echo $itemcount; ?>" value="<?php echo $itemcode; ?>">
</td>
<td id="idTD2<?php echo $itemcount; ?>" align="left" valign="top"  bgcolor="#FFFFFF" class="bodytext3">
<input name="itemquantity[]" value="<?php echo $quantity; ?>" id="itemcode<?php echo $itemcount; ?>" style="border: 0px solid #001E6A; text-align:left" size="10" readonly />
</td>

<td id="idTD3<?php echo $itemcount; ?>" align="right" valign="top"  bgcolor="#FFFFFF" class="bodytext3">
<!--<input onClick="return btnFreeClick(<?php echo $itemcount; ?>)" name="btnfree<?php echo $itemcount; ?>" id="btnfree<?php echo $itemcount; ?>" type="hidden" value="Free" class="button" style="border: 1px solid #001E6A"/>-->
<input onClick="return btnDeleteClick10(<?php echo $itemcount; ?>)" name="btndelete<?php echo $itemcount; ?>" id="btndelete<?php echo $itemcount; ?>" type="button" value="Del" class="button" style="border: 1px solid #001E6A"/>
</td>
</TR>
<?php }

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
					  <input type="hidden" name="medicinecode1" id="medicinecode" value="">
                        <td><input name="medicinename" type="text" id="medicinename" size="35" autocomplete="off" onKeyDown="return StateSuggestionspharm4()" onKeyUp="return funcCustomerDropDownSearch4()"></td>
								   <input name="searchmedicinename1hiddentextbox" id="searchmedicinename1hiddentextbox" type="hidden" value="">
			  <input name="searchmedicineanum1" id="searchmedicineanum1" value="" type="hidden">
			
						<td><input type="text" name="quantity" id="quantity" size="8" /></td>
						<input name="avlquantity" type="hidden" id="avlquantity" size="8">
						<input name="locationcode" type="hidden" id="locationcode" size="8">
						
						<td width="224"><label>
                       <input type="button" name="Add" id="Add" value="Add" onClick="return insertitem10()" class="button" style="border: 1px solid #001E6A">
                       </label></td>
					   </tr>
                     
					 <input type="hidden" name="h" id="h" value="0">
					 </tbody>
                   </table>				  </td>
			       </tr>
				    <tr>
              <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
              <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
              <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
              <td colspan="2" align="left" valign="middle" class="bodytext3">&nbsp;</td>
              <td align="left" valign="top">			              </td>
            </tr>
			   <tr>
              <td align="left" valign="middle" class="bodytext3"></td>
              <td align="left" valign="top">&nbsp;</td>
              <td align="left" valign="top">&nbsp;</td>
              <td align="left" valign="top">&nbsp;</td>
              <td align="left" valign="top">&nbsp;</td>
              <td align="left" valign="top">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  style="border: 1px solid #001E6A" type="submit" value="Save" name="Submit" onClick="return medicinecheck();"/>                 </td>
            </tr>
			 
                     <tr>
                        <td align="middle" colspan="2" >&nbsp;</td>
                      </tr>
          </tbody>
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

