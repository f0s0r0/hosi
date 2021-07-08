<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysql_query($query) or die ("Error in Query1".mysql_error());
$res = mysql_fetch_array($exec);
	
	 $locationname  = $res["locationname"];
	 $locationcode = $res["locationcode"];
	$res12locationanum = $res["auto_number"];
	
$query55 = "select * from master_location where auto_number='$res12locationanum'";
$exec55 = mysql_query($query55) or die(mysql_error());
$res55 = mysql_fetch_array($exec55);
$location = $res55['locationname'];

$query23 = "select * from master_employeelocation where username='$username' and locationcode = '$locationcode' and defaultstore = 'default'";
$exec23 = mysql_query($query23) or die(mysql_error());
$res23 = mysql_fetch_array($exec23);
$res7locationanum = $res23['locationanum'];

$query55 = "select * from master_location where locationcode='$locationcode'";
$exec55 = mysql_query($query55) or die(mysql_error());
$res55 = mysql_fetch_array($exec55);
$location = $res55['locationname'];

$res7storeanum = $res23['storecode'];

$query75 = "select * from master_store where auto_number='$res7storeanum'";
$exec75 = mysql_query($query75) or die(mysql_error());
$res75 = mysql_fetch_array($exec75);
$storecode = $res75['storecode'];

$titlestr = 'SALES BILL';
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
$docno = $_REQUEST['docno'];
$location = $_REQUEST['location'];

if($_POST['discard'] != $docno)
{
  foreach($_POST['itemcode1'] as $key => $value)
		{
		$medicinename1=$_POST['medicinename1'][$key];
	    $itemcode=$_POST['itemcode1'][$key];
	//echo "<br>".$itemcode;
	    $reqqty=$_POST['reqqtyold'][$key];
		$pkgqty=$_POST['pkgqtyold'][$key];
		$amount=$_POST['amountold'][$key];
		$amount = str_replace( ',', '', $amount);
		foreach($_POST['app'] as $check)
		{
	   $acknow = $check;
		//echo "<br>".$acknow;
		if($itemcode == $acknow)
		{
		$status = 'approved';
				}
		
		}
		if($status == '')
		{
		$status = 'rejected';
		}
		
		$query45="update purchase_rfqrequest set approvalstatus='$status',quantity='$reqqty',packagequantity='$pkgqty',amount='$amount' where docno='$docno' and medicinecode='$itemcode'";
		$exec45 = mysql_query($query45) or die(mysql_error());		
		
		$status ='';
		}
		}
		else
		{
		$query46="update purchase_rfqrequest set approvalstatus='rejected' where docno='$docno'";
		$exec46 = mysql_query($query46) or die(mysql_error());		
	
		}
		
		for ($p=1;$p<=500;$p++)
		{	
		    //echo '<br>'.$i;
			//echo '<br>'.
			//$autonumber = $_REQUEST['autonumber'.$p];	
			//echo '<br>'.
		    $medicinename = $_REQUEST['medicinename'.$p];
			
			$query77="select * from master_medicine where itemname='$medicinename'";
			$exec77=mysql_query($query77);
			$res77=mysql_fetch_array($exec77);
			$medicinecode=$res77['itemcode'];
			$reqqty = $_REQUEST['reqqty'.$p];
		    $pkgqty = $_REQUEST['pkgqty'.$p];
			$rate = $_REQUEST['rate'.$p];
			$amount = $_REQUEST['amount'.$p];
			if($medicinecode != '')
			{
			//if ($medicinename != "" && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")
			if (($reqqty != "")&&($reqqty != 0))// && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")
			{
		     $query43="insert into purchase_rfqrequest(date,docno,medicinename,medicinecode,quantity,packagequantity,rate,amount,username,approvalstatus,status,companyanum,location,locationname,locationcode)values
		                 ('$dateonly','$docno','$medicinename','$medicinecode','$reqqty','$pkgqty','$rate','$amount','$username','approved','RFA','$companyanum','$locationname','$locationname','$locationcode')";
				$exec43 = mysql_query($query43) or die(mysql_error());		 
			
				}
				}
				}
				header("location:menupage1.php?mainmenuid=MM029");

}


//to redirect if there is no entry in masters category or item or customer or settings



//To get default tax from autoitemsearch1.php and autoitemsearch2.php - for CST tax override.
if (isset($_REQUEST["defaulttax"])) { $defaulttax = $_REQUEST["defaulttax"]; } else { $defaulttax = ""; }
if(isset($_REQUEST['delete']))
{
$referalname=$_REQUEST['delete'];
mysql_query("delete from consultation_referal where referalname='$referalname'");
}
//$defaulttax = $_REQUEST["defaulttax"];
if ($defaulttax == '')
{
	$_SESSION["defaulttax"] = '';
}
else
{
	$_SESSION["defaulttax"] = $defaulttax;
}



//To verify the edition and manage the count of bills.
$thismonth = date('Y-m-');
$query77 = "select * from master_edition where status = 'ACTIVE'";
$exec77 =  mysql_query($query77) or die ("Error in Query77".mysql_error());
$res77 = mysql_fetch_array($exec77);
$res77allowed = $res77["allowed"];



/*
$query99 = "select count(auto_number) as cntanum from master_quotation where quotationdate like '$thismonth%'";
$exec99 = mysql_query($query99) or die ("Error in Query99".mysql_error());
$res99 = mysql_fetch_array($exec99);
$res99cntanum = $res99["cntanum"];
$totalbillandquote = $res88cntanum + $res99cntanum; //total of bill and quote in current month.
if ($totalbillandquote > $res77allowed)
{
	//header ("location:usagelimit1.php"); // redirecting.
	//exit;
}
*/

//To Edit Bill
if (isset($_REQUEST["delbillst"])) { $delbillst = $_REQUEST["delbillst"]; } else { $delbillst = ""; }
//$delbillst = $_REQUEST["delbillst"];
if (isset($_REQUEST["delbillautonumber"])) { $delbillautonumber = $_REQUEST["delbillautonumber"]; } else { $delbillautonumber = ""; }
//$delbillautonumber = $_REQUEST["delbillautonumber"];
if (isset($_REQUEST["delbillnumber"])) { $delbillnumber = $_REQUEST["delbillnumber"]; } else { $delbillnumber = ""; }
//$delbillnumber = $_REQUEST["delbillnumber"];

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
//$frm1submit1 = $_REQUEST["frm1submit1"];




if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST["st"];
if (isset($_REQUEST["banum"])) { $banum = $_REQUEST["banum"]; } else { $banum = ""; }
//$banum = $_REQUEST["banum"];
if ($st == '1')
{
	$errmsg = "Success. New Bill Updated. You May Continue To Add Another Bill.";
	$bgcolorcode = 'success';
}
if ($st == '2')
{
	$errmsg = "Failed. New Bill Cannot Be Completed.";
	$bgcolorcode = 'failed';
}
if ($st == '1' && $banum != '')
{
	$loadprintpage = 'onLoad="javascript:loadprintpage1()"';
}

?>


<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$paynowbillprefix = 'PI-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from purchase_indent order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='PI-'.'1';
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
	
	
	$billnumbercode = 'PI-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
?>
<?php 
if(isset($_REQUEST['docno']))
{
$docno = $_REQUEST['docno'];
}

?>
<script language="javascript">
function deletevalid()
{
var del;
del=confirm("Do You want to delete this referal ?");
if(del == false)
{
return false;
}
}


<?php
if ($delbillst != 'billedit') // Not in edit mode or other mode.
{
?>
	//Function call from billnumber onBlur and Save button click.
	function billvalidation()
	{
		billnovalidation1();
	}
<?php
}
?>




function funcPopupPrintFunctionCall()
{

	///*
	//alert ("Auto Print Function Runs Here.");
	<?php
	if (isset($_REQUEST["src"])) { $src = $_REQUEST["src"]; } else { $src = ""; }
	//$src = $_REQUEST["src"];
	if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
	//$st = $_REQUEST["st"];
	if (isset($_REQUEST["billnumber"])) { $previousbillnumber = $_REQUEST["billnumber"]; } else { $previousbillnumber = ""; }
	//$previousbillnumber = $_REQUEST["billnumber"];
	if (isset($_REQUEST["billautonumber"])) { $previousbillautonumber = $_REQUEST["billautonumber"]; } else { $previousbillautonumber = ""; }
	//$previousbillautonumber = $_REQUEST["billautonumber"];
	if (isset($_REQUEST["companyanum"])) { $previouscompanyanum = $_REQUEST["companyanum"]; } else { $previouscompanyanum = ""; }
	//$previouscompanyanum = $_REQUEST["companyanum"];
	if ($src == 'frm1submit1' && $st == 'success')
	{
	$query1print = "select * from master_printer where defaultstatus = 'default' and status <> 'deleted'";
	$exec1print = mysql_query($query1print) or die ("Error in Query1print.".mysql_error());
	$res1print = mysql_fetch_array($exec1print);
	$papersize = $res1print["papersize"];
	$paperanum = $res1print["auto_number"];
	$printdefaultstatus = $res1print["defaultstatus"];
	if ($paperanum == '1') //For 40 Column paper
	{
	?>
		//quickprintbill1();
		quickprintbill1sales();
	<?php
	}
	else if ($paperanum == '2') //For A4 Size paper
	{
	?>
		loadprintpage1('A4');
	<?php
	}
	else if ($paperanum == '3') //For A4 Size paper
	{
	?>
		loadprintpage1('A5');
	<?php
	}
	}
	?>
	//*/


}

//Print() is at bottom of this page.

</script>
<?php include ("js/sales1scripting1.php"); ?>
<script type="text/javascript">

function loadprintpage1(varPaperSizeCatch)
{
	//var varBillNumber = document.getElementById("billnumber").value;
	var varPaperSize = varPaperSizeCatch;
	//alert (varPaperSize);
	//return false;
	<?php
	//To previous js error if empty. 
	if ($previousbillnumber == '') 
	{ 
		$previousbillnumber = 1; 
		$previousbillautonumber = 1; 
		$previouscompanyanum = 1; 
	} 
	?>
	var varBillNumber = document.getElementById("quickprintbill").value;
	var varBillAutoNumber = "<?php //echo $previousbillautonumber; ?>";
	var varBillCompanyAnum = "<?php echo $_SESSION["companyanum"]; ?>";
	if (varBillNumber == "")
	{
		alert ("Bill Number Cannot Be Empty.");//quickprintbill
		document.getElementById("quickprintbill").focus();
		return false;
	}
	
	var varPrintHeader = "INVOICE";
	var varTitleHeader = "ORIGINAL";
	if (varTitleHeader == "")
	{
		alert ("Please Select Print Title.");
		document.getElementById("titleheader").focus();
		return false;
	}
	
	//alert (varBillNumber);
	//alert (varPrintHeader);
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');

	if (varPaperSize == "A4")
	{
		window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&billnumber="+varBillNumber+"","OriginalWindowA4<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	}
	if (varPaperSize == "A5")
	{
		window.open("print_bill1_a5.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&billnumber="+varBillNumber+"","OriginalWindowA5<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	}
}

function cashentryonfocus1()
{

	if (document.getElementById("cashgivenbycustomer").value == "0.00")
	{
		document.getElementById("cashgivenbycustomer").value = "";
		document.getElementById("cashgivenbycustomer").focus();
	}
}

function funcDefaultTax1() //Function to CST Taxes if required.
{
	//alert ("Default Tax");
	<?php
	//delbillst=billedit&&delbillautonumber=13&&delbillnumber=1
	//To avoid change of bill number on edit option after selecting default tax.
	if (isset($_REQUEST["delbillst"])) { $delBillSt = $_REQUEST["delbillst"]; } else { $delBillSt = ""; }
	//$delBillSt = $_REQUEST["delbillst"];
	if (isset($_REQUEST["delbillautonumber"])) { $delBillAutonumber = $_REQUEST["delbillautonumber"]; } else { $delBillAutonumber = ""; }
	//$delBillAutonumber = $_REQUEST["delbillautonumber"];
	if (isset($_REQUEST["delbillnumber"])) { $delBillNumber = $_REQUEST["delbillnumber"]; } else { $delBillNumber = ""; }
	//$delBillNumber = $_REQUEST["delbillnumber"];
	
	?>
	var varDefaultTax = document.getElementById("defaulttax").value;
	if (varDefaultTax != "")
	{
		<?php
		if ($delBillSt == 'billedit')
		{
		?>
		window.location="sales1.php?defaulttax="+varDefaultTax+"&&delbillst=<?php echo $delBillSt; ?>&&delbillautonumber="+<?php echo $delBillAutonumber; ?>+"&&delbillnumber="+<?php echo $delBillNumber; ?>+"";
		<?php
		}
		else
		{
		?>
		window.location="sales1.php?defaulttax="+varDefaultTax+"";
		<?php
		}
		?>
	}
	else
	{
		window.location="sales1.php";
	}
	//return false;
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
</script>
<script>
function calc(serialnumber,totalcount)
{

var grandtotalamount = 0;
var serialnumber = serialnumber;

var totalcount = totalcount;
var reqqty=document.getElementById("reqqty"+serialnumber+"").value;
var packsize=document.getElementById("packsize"+serialnumber+"").value;

var packvalue=packsize.substring(0,packsize.length - 1);
var rate=document.getElementById("rate"+serialnumber+"").value;
var amount=parseFloat(reqqty) * parseFloat(rate);
document.getElementById("amount"+serialnumber+"").value=amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
var pkgqty=reqqty/packvalue;
packvalue=parseInt(packvalue);
if(reqqty < packvalue)
{
pkgqty=1;
}

document.getElementById("pkgqty"+serialnumber+"").value=Math.round(pkgqty);

for(i=1;i<=totalcount;i++)
{
var totalamount=document.getElementById("amount"+i+"").value;
totalamount = totalamount.replace(/,/g , "");

if(totalamount == "")
{
totalamount=0;
}
grandtotalamount=grandtotalamount+parseFloat(totalamount);

}
document.getElementById("totalamount").value=grandtotalamount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');

}
</script>
<script>
function calcul()
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
<script language="JavaScript">
	function selectAll(source) {
		checkboxes = document.getElementsByName('app[]');
		for(var i in checkboxes)
			checkboxes[i].checked = source.checked;
	}
	
	function acknowledgevalid()
{
var chks = document.getElementsByName('discard');
var hasChecked = false;
for (var i = 0; i < chks.length; i++)
{
if (chks[i].checked)
{
hasChecked = true;
}
}

var chks1 = document.getElementsByName('app[]');
hasChecked1 = false;
for(var j = 0; j < chks1.length; j++)
{
if(chks1[j].checked)
{
hasChecked1 = true;
}
}

if (hasChecked == false && hasChecked1 == false)
{
alert("Please either approve/discard items  or click back button on the browser to exit Review");
return false;
}
return true;
}
</script>
<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
.style1 {
	font-size: 36px;
	font-weight: bold;
}
.style2 {
	font-size: 18px;
	font-weight: bold;
}
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
.bal
{
border-style:none;
background:none;
text-align:right;
FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma;
}
</style>
<script type="text/javascript" src="js/insertnewitempurchaserequest.js"></script>
<script src="js/datetimepicker_css.js"></script>
<?php //include("autocompletebuild_medicine1.php"); ?>
<script type="text/javascript" src="js/autosuggestmedicine1.js"></script>
<?php include("js/dropdownlist1scriptingmedicine1.php"); ?>
<script type="text/javascript" src="js/autocomplete_medicine1.js"></script>
<script type="text/javascript" src="js/automedicinecodesearch5.js"></script>
</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="form1" id="frmsales" method="post" action="rfpapproval.php" onKeyDown="return disableEnterKey(event)" onSubmit="return acknowledgevalid()">
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
<!--  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
-->
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="980" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="3"><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr>
	  <td>&nbsp;
	  </td>
	  </tr>
			<tr>
              <td bgcolor="#CCCCCC" class="bodytext3" colspan="8"><strong>Review RFQ</strong></td>
			 
		</tr>
			 
		
			  <tr>
			    <td width="10%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>DOC No</strong></td>
                <td width="27%" align="left" valign="top" >
				<input name="docno" id="docno" value="<?php echo $docno; ?>" size="10" autocomplete="off" readonly style="background: #CCCCCC"/>                  </td>
                 <td width="11%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Date</strong></td>
                <td colspan="3" align="left" valign="top" >
				<input name="date" id="date" value="<?php echo $dateonly; ?>" size="10" rsize="20" readonly/>				</td>
             <td width="11%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Location</strong></td>
                <td width="17%" colspan="3" align="left" valign="top" >
				<input name="location" id="location" value="Main Stores" size="18" rsize="20" readonly/>				</td>
			    </tr>
            </tbody>
        </table></td>
      </tr>
      <tr>
	  <td colspan="3">&nbsp;	  </td>
	  </tr>
      <tr>
        <td colspan="3">
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="130%" 
            align="left" border="0">
          <tbody id="foo">
             <tr>
                       <td width="21%"  align="center" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Medicine Name</strong></td>
                       <td width="11%"  align="center" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Avl Qty</strong></td>
                       <td width="11%"  align="center" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Req Qty</strong></td>
                       <td width="13%"  align="center" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Pack Size</strong></td>
                       <td width="11%"  align="center" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Pkg Qty</strong></td>
                      
                       <td width="8%"  align="center" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Rate</strong></td>
                       <td width="17%"  align="center" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Amount</strong></td>
					   <td width="8%"  align="center" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Approve</strong></td>
                  </tr>
				  		<?php
			$colorloopcount = '';
			$sno = 0;
			$totalamount=0;			
			$query12 = "select * from purchase_rfqrequest where docno='$docno'";
			$exec12= mysql_query($query12) or die ("Error in Query1".mysql_error());
			$numb=mysql_num_rows($exec12);
			
			while($res12 = mysql_fetch_array($exec12))
         {
		$medicinename = $res12['medicinename'];
		$itemcode = $res12['medicinecode'];
		
		$reqqty = $res12['quantity'];
		
			$query2 = "select * from master_medicine where itemcode = '$itemcode'";
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			$res2 = mysql_fetch_array($exec2);
			$package = $res2['packagename'];
			
			$packagequantity = $res12['packagequantity'];
			$rate = $res12['rate'];
			$amount = $res12['amount']; 
			
			
			$query751 = "select * from master_store where storecode='$storecode'";
			$exec751 = mysql_query($query751) or die(mysql_error());
			$res751 = mysql_fetch_array($exec751);
			//$storecode = $res751['store'];
$storecodes = $res751['storecode'];
			$itemcode = $itemcode;
			
			$query1 = "select sum(batch_quantity) as cum_quantity from transaction_stock where itemcode='$itemcode' and locationcode='$locationcode' and batch_stockstatus='1' and storecode='$storecodes' order by auto_number desc";
			$exec1 = mysql_query($query1) or die(mysql_error());
			$res1 = mysql_fetch_array($exec1);
			$currentstock = intval($res1['cum_quantity']);
		//include ('autocompletestockcount1include1.php');
		$currentstock = $currentstock;
		
		$totalamount= $totalamount + $amount;
		$sno = $sno + 1;
		
?>
  <tr>
		
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $medicinename;?></div></td>
		<input type="hidden" name="medicinename1[]" value="<?php echo $medicinename;?>">
		<input type="hidden" name="itemcode1[]" value="<?php echo $itemcode; ?>">
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $currentstock;?></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="reqqtyold[]" id="reqqty<?php echo $sno ; ?>" value="<?php echo $reqqty;?>" size="6" onKeyUp="return calc('<?php echo $sno; ?>','<?php echo $numb; ?>');"></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="packsize1[]" id="packsize<?php echo $sno ; ?>" value="<?php echo $package;?>" size="6" class="bal" readonly></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="pkgqtyold[]" id="pkgqty<?php echo $sno ; ?>" size="6" value="<?php echo $packagequantity;?>" class="bal" readonly></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="rateold[]" id="rate<?php echo $sno ; ?>" value="<?php echo $rate;?>" size="6" class="bal" readonly></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="amountold[]" id="amount<?php echo $sno ; ?>" value="<?php echo number_format($amount,'2','.',',');?>" size="12" class="bal" readonly></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center">
        <input type="checkbox" name="app[]" value="<?php echo $itemcode; ?>"/></div></td>
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
				 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				 <td class="bodytext31" valign="center"  align="center" 
                bgcolor="#cccccc"><input type="text" name="totalamount" id="totalamount" value="<?php echo number_format($totalamount,'2','.',','); ?>" size="12" class="bal" readonly></td>
				 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
               </tr>
          </tbody>
        </table>		</td>
      </tr>
				    
				  <tr>
	  <td colspan="3">&nbsp;	  </td>
	  </tr>
      <tr>
	  <td colspan="3">
	  <table width="716">
     <tr>
	 <td width="66" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
	   <td width="111" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
	    <td width="47" align="center" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Discard</td>
	   <td width="60" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"> <input type="checkbox" name="discard" value="<?php echo $docno; ?>"></td>
	    <td width="47" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Approve All</td>
	   <td width="120" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"> <input type="checkbox" id="selectall" onClick="selectAll(this)"></td>
	 </tr>
		</table>		</td>
		</tr>
		 <tr>
				   <td colspan="3" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Add Medicine</strong></td>
			      </tr>	
				  <tr>
				   <td colspan="3" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			      </tr>	
		<tr id="pressid">
				   <td colspan="13" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
				   <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="150" class="bodytext3">Medicine Name</td>
					    <td width="48" class="bodytext3">Category</td>
						 <td width="48" class="bodytext3">Strength</td>
                       <td width="48" class="bodytext3">Avl Qty</td>
                       <td width="41" class="bodytext3">Req Qty</td>
                       <td width="48" class="bodytext3">Pack Size</td>
                       <td width="48" class="bodytext3">Pkg Qty</td>
                      
                       <td class="bodytext3">Rate</td>
                       <td width="48" class="bodytext3">Amount</td>
                     </tr>
					 <tr>
					 <div id="insertrow">					 </div></tr>
                     <tr>
					  <input type="hidden" name="serialnumber" id="serialnumber" value="1">
					  <input type="hidden" name="medicinecode" id="medicinecode" value="">
					  <input type="hidden" name="searchmedicinename1hiddentextbox" id="searchmedicinename1hiddentextbox" value="">
                       <td><input name="medicinename" type="text" id="medicinename" size="25" autocomplete="off" onKeyDown="return StateSuggestionspharm4()" onKeyUp="return funcCustomerDropDownSearch4()"></td>
                       <td><input name="category" type="text" id="category" size="8" readonly></td>
					    <td><input name="strength" type="text" id="strength" size="8" readonly></td>
					   <td><input name="avlqty" type="text" id="avlqty" size="8" readonly></td>
                        <td><input name="reqqty" type="text" id="reqqty" size="8" onKeyUp="return calcul();" autocomplete="off"></td>
                       <td><input name="packsize" type="text" id="packsize" size="8" readonly></td>
                       <td><input name="pkgqty" type="text" id="pkgqty" size="8" readonly></td>
                       <td width="48"><input name="rate" type="text" id="rate" readonly size="8"></td>
                       <td>
                         <input name="amount" type="text" id="amount" readonly size="8"></td>
                       <td><label>
                       <input type="button" name="Add" id="Add" value="Add" onClick="return insertitem10()" class="button" style="border: 1px solid #001E6A">
                       </label></td>
					   </tr>
                     
					 <input type="hidden" name="h" id="h" value="0">
                   </table>				  </td>
			       </tr>
				   
				    <tr>
				   <td colspan="10" align="right" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="style2">Total</span><input type="text" id="total" readonly size="7"></td>
			      </tr>				
		        
      <tr>
        
		 <td width="46" align="right" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
         <td width="90" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Username</strong></td>
         <td width="580" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><?php echo $username; ?></td>
         <td width="264" align="right" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="hidden" name="frm1submit1" value="frm1submit1" />
           <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
           <input name="Submit222" type="submit"  value="Save" class="button"/></td>
      </tr>
	  </table>
      </td>
      </tr>
    
  </table>
</form>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>