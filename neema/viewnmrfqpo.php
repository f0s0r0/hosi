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
$currenttime = date("H:i:s");

$totalsum = 0;

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["billnumber"])) { $billnumber = $_REQUEST["billnumber"]; } else { $billnumber = ""; }
//$st = $_REQUEST['st'];
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
$pono = $_REQUEST['pono'];
$suppliercode = $_REQUEST['suppliercode'];
$suppliername = $_REQUEST['suppliername'];

foreach($_POST['itemname'] as $key => $value)
{
$itemname = $_POST['itemname'][$key];

$remarks = $_POST['remarks'][$key];
$amount = $_POST['amountval'][$key];
$packagequantity = $_POST['packagequantity'][$key];

$query34 = "update master_nmrfq set quantity='$packagequantity',amount = '$amount' where suppliercode='$suppliercode' and status = 'generated'";
$exec34 = mysql_query($query34) or die(mysql_error()); 
}
		

header("location:nmrfqviewpurchaseorders.php");

}

?>
<?php 
if(isset($_REQUEST['itemname']))
{
$item=$_REQUEST['itemname'];
$bill=$_REQUEST['billnumber'];
$query23 = "update master_nmrfqpurchaseorder set recordstatus='deleted' where itemcode='$item' and billnumber='$bill'";
$exec23 = mysql_query($query23) or die(mysql_error());

}
?>
<?php
if(isset($_REQUEST['billnumber']))
{
$pono = $_REQUEST['billnumber'];
$query55 = "select * from master_nmrfqpurchaseorder where billnumber='$pono' and goodsstatus = ''";
$exec55=mysql_query($query55) or die(mysql_error());
$res55=mysql_fetch_array($exec55);
$suppliername = $res55['suppliername'];
$suppliercode = $res55['suppliercode'];


$query66 = "select * from master_supplier where suppliercode='$suppliercode'";
$exec66 = mysql_query($query66) or die(mysql_error());
$res66 = mysql_fetch_array($exec66);
$addressname = $res66['address1'];
$address = $addressname;
$addressname1 = $res66['address2'];
if($addressname1 != '')
{
$address = $address.','.$addressname1;
}
$area = $res66['area'];
if($area != '')
{
$address = $address.','.$area;
}
$city = $res66['city'];
if($city !='')
{
$address = $address.','.$city;
}
$state = $res66['state'];
if($state !='')
{
$address = $address.','.$state;
}
$country = $res66['country'];
if($country !='')
{
$address = $address.','.$country;
}
$telephone2 = $res66['mobilenumber'];
$tele=$telephone2;
$telephone = $res66['phonenumber1'];
if($telephone != '')
{
$tele=$tele.','.$telephone;
}
$telephone1 = $res66['phonenumber2'];
if($telephone1 != '')
{
$tele=$tele.','.$telephone1;
}

$email = $res66['emailid1'];
$email1 = $res66['emailid2'];
if($email1 != '')
{
$email = $email.','.$email1;
}
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
<?php include("autocompletebuild_medicine1.php"); ?>
<script type="text/javascript" src="js/autosuggestmedicine1.js"></script>
<?php include("js/dropdownlist1scriptingmedicine1.php"); ?>
<script type="text/javascript" src="js/autocomplete_medicine1.js"></script>
<script type="text/javascript" src="js/automedicinecodesearch5.js"></script>
<script type="text/javascript" src="js/insertnewitem32.js"></script>
<script language="javascript">

function cbcustomername1()
{
	document.cbform1.submit();
}
function calc()
{
var reqqty=document.getElementById("reqqty").value;
var packsize=document.getElementById("packsize").value;

var packvalue=packsize.substring(0,packsize.length - 1);
var rate=document.getElementById("rate").value;
var amount=parseFloat(reqqty) * parseFloat(rate);
document.getElementById("amount").value=amount.toFixed(2);
var pkgqty=reqqty/packvalue;
packvalue=parseInt(packvalue);
if(reqqty < packvalue)
{
pkgqty=1;
}


document.getElementById("pkgqty").value=Math.round(pkgqty);
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


function loadprintpage1(banum)
{
	var banum = banum;
	window.open("print_bill1_op1.php?billautonumber="+banum+"","Window"+banum+"",'width=722,height=950,toolbar=0,scrollbars=1,location=0,bar=0,menubar=1,resizable=1,left=25,top=25');
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
}
function funcOnLoadBodyFunctionCall()
{


	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	 //To handle ajax dropdown list.
	funcCustomerDropDownSearch4();
	funcPopupPrintFunctionCall();
	
}
function btnDeleteClick10(delID4,vrate4)
{
	//alert ("Inside btnDeleteClick.");
	var newtotal;
	//alert(delID4);
	var varDeleteID4= delID4;
	//alert(vrate4);
	
	//alert(rateref);
	//alert (varDeleteID3);
	var fRet7; 
	fRet7 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet7 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child4 = document.getElementById('idTR'+varDeleteID4);  
	//alert (child3);//tr name
    var parent4 = document.getElementById('insertrow'); // tbody name.
	document.getElementById ('insertrow').removeChild(child4);
	
	var child4= document.getElementById('idTRaddtxt'+varDeleteID4);  //tr name
    var parent4 = document.getElementById('insertrow'); // tbody name.
	
	if (child4 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow').removeChild(child4);
	}

	var currenttotal=document.getElementById('total').value;
	//alert(currenttotal);
	newtotal= currenttotal-vrate4;
	
	//alert(newtotal);
	
	document.getElementById('total').value=newtotal.toFixed(2);
		
}
function amountcalc(varserialnumber)
{
var varserialnumber= varserialnumber;
var receivedquantity = document.getElementById("packagequantity"+varserialnumber+"").value;
var rate = document.getElementById("rate"+varserialnumber+"").value;
if(receivedquantity != '')
{
var amount = parseFloat(receivedquantity) * parseFloat(rate);
}
document.getElementById("amount"+varserialnumber+"").value = amount.toFixed(2);
}

function deletevalid()
{
var del;
del=confirm("Do You want to delete this medicine ?");
if(del == false)
{
return false;
}
}
</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bal
{
border-style:none;
background:none;
text-align:right;
FONT-FAMILY: Tahoma;
FONT-SIZE: 11px;
}
-->
</style>
</head>

<body onLoad="return funcOnLoadBodyFunctionCall();">
<form method="post" name="form1" action="viewnmrfqpo.php">

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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="900" 
            align="left" border="0">
          <tbody>
            
			<?php
			if ($st == 'success' && $billautonumber != '')
			{
			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff">&nbsp;</td>
              <td colspan="10"  align="left" valign="center" bgcolor="#FFFF00" class="bodytext31">&nbsp;
			  * Success. Bill Saved. &nbsp;&nbsp;&nbsp;
			  <input name="billprint" type="button" onClick="return loadprintpage1('<?php echo $billautonumber; ?>')" value="Click Here To Print Invoice" class="button" style="border: 1px solid #001E6A"/>			  </td>
              <td width="1%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
            </tr>
			<?php
			}
			?>
			  <tr>
			    <td width="7%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>PO No</strong></td>
                <td width="25%" align="left" valign="top" class="bodytext3"><?php echo $pono; ?>
				<input type="hidden" name="pono" id="pono" value="<?php echo $pono; ?>" style="border: 1px solid #001E6A;" size="10" autocomplete="off" readonly="readonly"/>                  </td>
                 <td width="15%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Date</strong></td>
                <td colspan="3" align="left" valign="top" class="bodytext3"><?php echo $currentdate; ?>
				<input type="hidden" name="date" id="date" value="<?php echo $currentdate; ?>" style="border: 1px solid #001E6A" size="10" rsize="20" readonly="readonly"/>				</td>
			    </tr>
				<tr>
			    <td width="7%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Supplier</strong></td>
                <td width="25%" align="left" valign="top" class="bodytext3"><?php echo $suppliername; ?> & <?php echo $suppliercode; ?>
				<input type="hidden" name="suppliercode" id="suppliercode" value="<?php echo $suppliercode; ?>" />
				<input type="hidden" name="suppliername" id="suppliername" value="<?php echo $suppliername; ?>" style="border: 1px solid #001E6A;" size="20" autocomplete="off" readonly="readonly"/>                  </td>
                 <td width="15%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Telephone</strong></td>
                <td width="15%" align="left" valign="top" class="bodytext3"><?php echo $tele; ?>
				<input type="hidden" name="telephone" id="telephone" value="<?php echo $tele; ?>" style="border: 1px solid #001E6A;" size="20" autocomplete="off" readonly="readonly"/>                  </td>
			    </tr>
				<tr>
			   <td width="7%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Address</strong></td>
                <td width="25%" align="left" valign="top" class="bodytext3"><?php echo $address; ?>
				<input type="hidden" name="address" value="<?php echo $address; ?>"></td>
				   <td width="15%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Email</strong></td>
				  <td width="15%" align="left" valign="top" class="bodytext3"><?php echo $email; ?>
				<input type="hidden" name="email" id="email" value="<?php echo $email; ?>" style="border: 1px solid #001E6A;" size="20" autocomplete="off" readonly="readonly"/>                  </td>
			    </tr>
				<tr>
				  <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
				</tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				 <td width="25%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Item</strong></div></td>
				<td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Ord.Qty</strong></div></td>
				<td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate</strong></div></td>
				

				<td width="17%"  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount</strong></div></td>
				<td width="17%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Delete</strong></div></td>
				<td width="14%" align="left" valign="center" bgcolor="#E0E0E0" class="bodytext31">&nbsp;</td>
				<td width="14%" align="left" valign="center" bgcolor="#E0E0E0" class="bodytext31"><a target="_blank" href="viewnmrfqpoinexcel.php?billnumber=<?php echo $billnumber; ?>"><img src="images/excel-xls-icon.png" width="30" height="30" border="0"></a></td>
              </tr>
			
            
			<?php
			$colorloopcount = '';
			$sno = '';
		$query34="select * from master_nmrfqpurchaseorder where billnumber='$pono' and recordstatus='generated' and goodsstatus = '' group by itemname";
		$exec34=mysql_query($query34) or die(mysql_error());
		$num34 = mysql_num_rows($exec34);
		while($res34=mysql_fetch_array($exec34))
			{
			$totalquantity =0;
			$amount = 0;
			$itemname=$res34['itemname'];
			//$itemcode=$res34['itemcode'];
			$suppliercode = $res34['suppliercode'];
		
		$query35="select * from master_nmrfq where suppliercode='$suppliercode' and status='generated' and itemname='$itemname' order by auto_number desc";
		$exec35=mysql_query($query35) or die(mysql_error());
		$res35=mysql_fetch_array($exec35);
		$totalquantity = $res35['quantity'];
		$rate = $res35['rate'];
		$amount = $res35['amount'];
		$totalsum = $totalsum + $amount;
		//$packsize = $res35['packsize'];
		
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
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $itemname; ?></div></td>
				<input type="hidden" name="itemname[]" value="<?php echo $itemname; ?>">
				
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><input type="text" name="packagequantity[]" id="packagequantity<?php echo $sno ;?>" size="6" value="<?php echo $totalquantity; ?>" onKeyUp="return amountcalc('<?php echo $sno ;?>');"></div></td>
				<td class="bodytext31" valign="center"  align="center"><?php echo $rate; ?></td>
				
				<td class="bodytext31" valign="center"  align="left"> <div align="right"><?php echo number_format($amount,2,'.',','); ?><input type="hidden" size="6" name="amountval[]" id="amount<?php echo $sno ;?>" value="<?php echo $amount; ?>" class="bal" readonly="readonly"></div></td>
				<td  align="left" valign="center" class="bodytext31"><input type="hidden" name="rate[]" id="rate<?php echo $sno; ?>" value="<?php echo $rate; ?>">
                    <div align="center"><a onClick="return deletevalid()" href="viewrfqpo.php?itemname=<?php echo $itemname; ?>&&billnumber=<?php echo $pono; ?>">Delete</a></div></td>
				<td class="bodytext31" valign="center" bgcolor="e0e0e0" align="left">&nbsp;</td>
				<td class="bodytext31" valign="center" bgcolor="e0e0e0" align="left">&nbsp;</td>
                       </tr>
			  <?php
			}
			?>
            <tr>
              
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				<td  align="right" valign="center" 
                bgcolor="#cccccc" class="bodytext31"><strong>Total</strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totalsum,2,'.',','); ?></strong></td>
				<td  align="left" valign="center" 
                bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#e0e0e0">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#e0e0e0">&nbsp;</td>
              </tr>
          </tbody>
        </table></td>
      </tr>
	 
	  <tr>
	   <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
	  </tr>
	  <tr>
	   <td class="bodytext31" valign="center"  align="left"><strong>User Name</strong>
	    <?php echo $username; ?></td>
	    <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
	  </tr>
	  <tr>
	   <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
	  </tr>
	  <tr>
	   <td class="bodytext31" valign="center"  align="left"><strong>Time</strong>
	    <?php echo $currenttime; ?></td>
	    <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
	  </tr>
	  <tr>
	  <td class="bodytext31" valign="center"  align="center">
	   <input type="hidden" name="frm1submit1" value="frm1submit1" />
	   <input type="hidden" name="doccno" value="<?php echo $pono; ?>">
	    <input type="submit" name="submit" value="Save"></td>
	  </tr>
    </table>
</table>
</form>
<?php include ("includes/footer1.php"); ?>

</body>
</html>

