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
$docno1 = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno1' group by locationname order by locationname";
$exec = mysql_query($query) or die ("Error in Query1".mysql_error());
$res = mysql_fetch_array($exec);
$locationname = $res["locationname"];
$location = $res["locationname"];
$locationcode = $res["locationcode"];
$titlestr = 'SALES BILL';
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{

$docno = $_REQUEST['docno'];
$remarks = addslashes($_REQUEST['remarks']);
$project=$_REQUEST['project'];
$budgetline=$_REQUEST['budgetline'];
$budgetcode=$_REQUEST['budgetcode'];
$warrenty=$_REQUEST['warrenty'];
$deliveryortransport=$_REQUEST['deliveryortransport'];
$payment=$_REQUEST['payment'];
$address=$_REQUEST['address'];
$authorisedby=$_REQUEST['authorisedby'];
$quotationnum=$_REQUEST['quotationnum'];
$lpovalidity=$_REQUEST['lpovalidity'];
$expenditure=$_REQUEST['expenditure'];
$vatpercent=$_REQUEST['vatpercent'];
//$_POST['discard'];
if($_POST['discard'] != $docno)
{
	foreach($_POST['medicinenamear'] as $key => $value)
	{
		$medicinename=$_POST['medicinenamear'][$key]; 
		$itemcode=$_POST['itemcodear'][$key];
		//echo "<br>".$itemcode;
		$reqqty=str_replace(',','',$_POST['reqqtyar'][$key]);
		$pkgqty=$_POST['pkgqtyar'][$key];
		$amount=str_replace(',','',$_POST['amountar'][$key]);
		$purchasetype=strtolower($_POST['purchasetypear'][$key]);
		//echo '->'.$medicinename.'=>'.isset($_POST['appar'][$key]);
		$storecode = $_REQUEST['storecode'];
		$query71 = "select * from master_store where storecode = '$storecode'";
		$exec71 = mysql_query($query71) or die ("Error in Query71".mysql_error());
		$res71 = mysql_fetch_array($exec71);
		$storename = $res71['store'];
		if(true) //isset($_POST['appar'][$key])
		{
			//$medicinename;
			$status = '';
			$query88 = "select medicinecode from purchase_indent where docno='$docno' and medicinecode='$itemcode'";
			$exec88 = mysql_query($query88) or die(mysql_error());
			$row88 = mysql_num_rows($exec88);
			if($row88 > 0)
			{
				$query45="update purchase_indent set approvalstatus='$status',quantity='$reqqty',packagequantity='$pkgqty',amount='$amount', remarks='$remarks',baremarks='$remarks',bausername='$username',
				project='$project', budgetline='$budgetline', budgetcode='$budgetcode', warrenty='$warrenty', deliveryortransport='$deliveryortransport', payment='$payment', address='$address', authorisedby='$authorisedby',
				quotationnum='$quotationnum', lpovalidity='$lpovalidity', expenditure='$expenditure', vatpercent='$vatpercent'  where docno='$docno' and medicinecode='$itemcode'"; 
				$exec45 = mysql_query($query45) or die(mysql_error());	
				$actionstatus='approve'; 
			}
			else
			{			
				$query45 = "select * from master_itemtosupplier where itemcode='$itemcode' and locationcode = '$locationcode' and storecode = '$storecode'";
				$exec45 = mysql_query($query45) or die(mysql_error());
				$res45 = mysql_fetch_array($exec45);
				$suppliername=$res45['suppliername'];
				$suppliercode=$res45['suppliercode'];				
				$query25 = "select * from master_medicine where itemcode='$itemcode' and status <> 'deleted'";
				$exec25 = mysql_query($query25) or die(mysql_error());
				$res25 = mysql_fetch_array($exec25);
				$rate = $res25['purchaseprice'];
				$package = $res25['packagename'];				
				$packagequantity1 = preg_replace("/[^0-9,.]/", "", $package);				
				$packagequantity = $requiredquantity / $packagequantity1;
				$packagequantity = round($packagequantity);				
				$amount = $rate * $reqqty;	
				
				$query43="insert into purchase_indent(date,docno,medicinename,medicinecode,quantity,packagequantity,rate,amount,username,status,remarks,companyanum,locationname,locationcode,storecode,storename,purchasetype,currency,fxamount,suppliername,suppliercode,approvalstatus,bausername,
				project,budgetline,budgetcode,warrenty,deliveryortransport,payment,address,authorisedby,quotationnum,lpovalidity,expenditure,vatpercent)values('$dateonly','$docno','$medicinename','$itemcode','$reqqty','$pkgqty','$rate','$amount','$username','RFA','$remarks','$companyanum','".$locationname."','".$locationcode."','".$storecode."','".$storename."','Medical','KSH','1','$suppliername','$suppliercode','$status','$username','$project','$budgetline','$budgetcode','$warrenty','$deliveryortransport','$payment','$address','$authorisedby','$quotationnum','$lpovalidity','$expenditure','$vatpercent')";
				$exec43 = mysql_query($query43) or die(mysql_error());			 
			}
		}
	}
}
else
{
	foreach($_POST['medicinenamear'] as $key => $value)
	{
		$medicinename=$_POST['medicinenamear'][$key]; 
		$itemcode=$_POST['itemcodear'][$key];
		//echo "<br>".$itemcode;
		$reqqty=str_replace(',','',$_POST['reqqtyar'][$key]);
		$pkgqty=$_POST['pkgqtyar'][$key];
		$amount=str_replace(',','',$_POST['amountar'][$key]);
		$purchasetype=strtolower($_POST['purchasetypear'][$key]);
		//echo '->'.$medicinename.'=>'.isset($_POST['appar'][$key]);
		$storecode = $_REQUEST['storecode'];
		$query71 = "select * from master_store where storecode = '$storecode'";
		$exec71 = mysql_query($query71) or die ("Error in Query71".mysql_error());
		$res71 = mysql_fetch_array($exec71);
		$storename = $res71['store'];
		$status = 'reject';
		
		$query45="update purchase_indent set approvalstatus='$status',quantity='$reqqty',packagequantity='$pkgqty',amount='$amount', remarks='$remarks',baremarks='$remarks',bausername='$username',
		project='$project', budgetline='$budgetline', budgetcode='$budgetcode', warrenty='$warrenty', deliveryortransport='$deliveryortransport', payment='$payment', address='$address', authorisedby='$authorisedby',
		quotationnum='$quotationnum', lpovalidity='$lpovalidity', expenditure='$expenditure', vatpercent='$vatpercent' where docno='$docno' and medicinecode='$itemcode'"; 
		$exec45 = mysql_query($query45) or die(mysql_error());	
		$actionstatus='reject'; 
	}		
}
	header("location:viewpurchaseindent.php");
}

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

 $query = "select * from login_locationdetails where username='$username' and docno='$docno1' order by locationname";
$exec = mysql_query($query) or die ("Error in Query1".mysql_error());
$res = mysql_fetch_array($exec);
	
	 $locationname  = $res["locationname"];
	 $locationcode = $res["locationcode"];

$query23 = "select * from master_employeelocation where username='$username' and defaultstore='default' and locationcode='".$locationcode."'";
$exec23 = mysql_query($query23) or die(mysql_error());
$res23 = mysql_fetch_array($exec23);

$res7storeanum = $res23['storecode'];
$query75 = "select * from master_store where auto_number='$res7storeanum'";
$exec75 = mysql_query($query75) or die(mysql_error());
$res75 = mysql_fetch_array($exec75);
$store = $res75['store'];
$storecode = $res75['storecode'];
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


</script>
<script>
function funqty(id)
{
//alert(id);
if(document.getElementById(id) == document.activeElement)
{
document.getElementById(id).value=document.getElementById(id).value.replace(/[^0-9\.]+/g,"");
}
else
{
document.getElementById(id).value=document.getElementById(id).value.replace(/[^0-9\.]+/g,"").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
}
}
function calc(serialnumber,totalcount)
{

var grandtotalamount = 0;
var serialnumber = serialnumber;

var totalcount = totalcount;
var reqqty=document.getElementById("reqqty"+serialnumber+"").value;
var packsize=document.getElementById("packsize"+serialnumber+"").value;
var purchasetype=document.getElementById("purchasetype").value;
var fxamount=document.getElementById("fxamount").value;
var packvalue=packsize.substring(0,packsize.length - 1);
if(purchasetype!='non-medical')
{
	rate = parseFloat(rate)/parseFloat(fxamount);
}
var rate=document.getElementById("rate"+serialnumber+"").value.replace(/[^0-9\.]+/g,"");
var amount=parseFloat(reqqty) * parseFloat(rate);
//alert(amount);
document.getElementById("amount"+serialnumber+"").value=formatMoney(amount.toFixed(2));
var pkgqty=reqqty/packvalue;
packvalue=parseInt(packvalue);
if(reqqty < packvalue)
{
pkgqty=1;
}

if(purchasetype!='non-medical')
{
	document.getElementById("pkgqty"+serialnumber+"").value=Math.round(pkgqty);
}

for(i=1;i<=totalcount;i++)
{
var totalamount=document.getElementById("amount"+i+"").value.replace(/[^0-9\.]+/g,"");
if(totalamount == "")
{
totalamount=0;
}
grandtotalamount=grandtotalamount+parseFloat(totalamount);

}
document.getElementById("totalamount").value=formatMoney(grandtotalamount.toFixed(2));
}

function calcad()
{

var grandtotalamount = 0;
var serialnumber = document.getElementById("serialnumber").value;

var totalcount = serialnumber;
var reqqty=document.getElementById("reqqty").value;
var packsize=document.getElementById("packsize").value;
var purchasetype=document.getElementById("purchasetype").value;
var fxamount=document.getElementById("fxamount").value;
var packvalue=packsize.substring(0,packsize.length - 1);
if(purchasetype!='non-medical')
{
	rate = parseFloat(rate)/parseFloat(fxamount);
}
var rate=document.getElementById("rate").value.replace(/[^0-9\.]+/g,"");
var amount=parseFloat(reqqty) * parseFloat(rate);
//alert(amount);
document.getElementById("amount").value=formatMoney(amount.toFixed(2));
var pkgqty=reqqty/packvalue;
packvalue=parseInt(packvalue);
if(reqqty < packvalue)
{
pkgqty=1;
}

if(purchasetype!='non-medical')
{
	document.getElementById("pkgqty").value=Math.round(pkgqty);
}

for(i=1;i<totalcount;i++)
{
var totalamount=document.getElementById("amount"+i+"").value.replace(/[^0-9\.]+/g,"");
if(totalamount == "")
{
totalamount=0;
}
grandtotalamount=grandtotalamount+parseFloat(totalamount);

}
grandtotalamount=grandtotalamount+parseFloat(document.getElementById("amount").value.replace(/[^0-9\.]+/g,""));
document.getElementById("totalamount").value=formatMoney(grandtotalamount.toFixed(2));
}

function formatMoney(number, places, thousand, decimal) {
	number = number || 0;
	places = !isNaN(places = Math.abs(places)) ? places : 2;
	
	thousand = thousand || ",";
	decimal = decimal || ".";
	var negative = number < 0 ? "-" : "",
	    i = parseInt(number = Math.abs(+number || 0).toFixed(places), 10) + "",
	    j = (j = i.length) > 3 ? j % 3 : 0;
	return  negative + (j ? i.substr(0, j) + thousand : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousand) + (places ? decimal + Math.abs(number - i).toFixed(places).slice(2) : "");

}
</script>
<script language="JavaScript">
	function discardchk() {
		if(document.getElementById("discard").checked == true)
		{
			document.getElementById("selectall").checked = false;
		}
	}
	function selectAll(source) {
		
		if(document.getElementById("selectall").checked == true)
		{
			document.getElementById("discard").checked = false;
		}
		
		checkboxes = document.getElementsByName('appar[]');
		for(var i in checkboxes)
			checkboxes[i].checked = source.checked;
	}
	function process()
	{
		
			if(document.getElementById("remarks").value=='')
			{
				alert('Enter Remarks');
				document.getElementById("remarks").focus();
				return false;
			}
		
		/*if(document.getElementById("discard").checked==false && document.getElementById("selectall").checked==false)
		{
			alert('Select Approve or Reject Checkbox');
			return false;
		}
		if(document.getElementById("discard").checked==true && document.getElementById("selectall").checked==true)
		{
			alert('Select Any One Approve or Reject Checkbox');
			return false;
		}*/
		document.getElementById("saveindent").disabled=true;
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

	var currenttotal=document.getElementById('total').value.replace(/[^0-9\.]+/g,"");
	//alert(currenttotal);
	newtotal= currenttotal-vrate4;
	
	//alert(newtotal);
	
	document.getElementById('total').value=formatMoney(newtotal.toFixed(2));
	//currencyfix();	
}
</script>
<script type="text/javascript" src="js/insertnewitem32_in.js"></script>

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
#remarks{
	border-color:red;
	}
</style>

<script src="js/datetimepicker_css.js"></script>
</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />  
<link rel="stylesheet" type="text/css" href="css/autocomplete.css" />  
 
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/autocomplete_medicine1.js"></script>
<script type="text/javascript" src="js/automedicinecodesearch5kiambu.js"></script>
<script type="text/javascript" src="js/jquery.min-autocomplete.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript">
$(function() { 
$("#medicinename").autocomplete({
	source: "ajax/ajaxmedicine.php?purchasetype=drugs",
	minLength: 2,
        select: function(event, ui) {
		    $("#medicinecode").val(ui.item.itemcode) ;
			$("#medicinenamel").val(ui.item.value);
			funcmedicinesearch4()
        },
 		//funcmedicinesearch4()
        html: true
	 
	});
	$("#medicinename").keyup(function()
	{
	//alert();
	if($("#medicinename").val().trim()!=$("#medicinenamel").val().trim())
	{
	//alert();
	$("#medicinecode").val('');
	$("#rate").val('');
	$("#fxrate").val('');
	$("#amount").val('');
	}
	});  
});
</script>	  
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="form1" id="frmsales" method="post" action="purchaseindentapproval.php" onSubmit="return process()">
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
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              
			 <?php 
			if(isset($_REQUEST['docno']))
			{
				$docno = $_REQUEST['docno'];
				$query12 = "select suppliername,purchasetype,currency,fxamount,pimailfrom,bamailfrom,bamailcc,locationcode,storecode,project,budgetline,budgetcode,warrenty,deliveryortransport,payment,address,authorisedby,quotationnum,lpovalidity,expenditure,vatpercent from purchase_indent where docno='$docno' and (approvalstatus='' or approvalstatus='rejected1') order by project desc";
				$exec12= mysql_query($query12) or die ("Error in Query1".mysql_error());
				$numb=mysql_num_rows($exec12);				
				while($res12 = mysql_fetch_array($exec12))
				{
					$suppliername = $res12['suppliername'];
					$purchasetype = $res12['purchasetype'];				
					$currency = $res12['currency'];
					$fxamount = $res12['fxamount'];
					$pimailfrom = $res12['pimailfrom'];
					$bamailfrom = $res12['bamailfrom'];
					$bamailcc = $res12['bamailcc'];
					$locationcode = $res12['locationcode'];
					$storecode = $res12['storecode'];
					$project=$res12['project'];
					$budgetline=$res12['budgetline'];
					$budgetcode=$res12['budgetcode'];
					$warrenty=$res12['warrenty'];
					$deliveryortransport=$res12['deliveryortransport'];
					$payment=$res12['payment'];
					$address=$res12['address'];
					$authorisedby=$res12['authorisedby'];
					$quotationnum=$res12['quotationnum'];
					$lpovalidity=$res12['lpovalidity'];
					$expenditure=$res12['expenditure'];
					$vatpercent=$res12['vatpercent'];
				}
			}
			
			?>
		
			  <tr>
			    <td width="10%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Doc No</strong></td>
                <td width="27%" align="left" valign="top" >
				<input name="docno" id="docno" value="<?php echo $docno; ?>"  size="10" autocomplete="off" readonly/>                  </td>
                 <td width="11%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Date</strong></td>
                <td  align="left" valign="top" >
				<input name="date" id="date" value="<?php echo $dateonly; ?>"  size="10" rsize="20" readonly/>				</td>
                
             <td width="11%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Store</strong></td>
                <td width="17%" align="left" valign="top" >
				<input name="store" id="store" value="<?php echo $store;?>" size="18" rsize="20" readonly/>	
				<input type="hidden" name="storecode" id="storecode" value="<?php echo $storecode;?>" size="18" rsize="20" readonly/>				</td>
                
                 <td width="11%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Location</strong></td>
                <td width="17%" align="left" valign="top" >
				<input name="location" id="location" value="<?php echo $locationname;?>" size="18" rsize="20" readonly/>				</td>
			    </tr>
                <tr>
			    <td width="10%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Purchase Type</strong></td>
                <td width="27%" align="left" valign="middle" >
				<input name="purchasetype" id="purchasetype" value="<?php echo $purchasetype; ?>" size="10" autocomplete="off" readonly/>                  </td>
                 <td width="11%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Currency</strong></td>
                <td align="left" valign="middle" >
				<input name="currency" id="currency" value="<?php echo $currency; ?>" size="10" rsize="20" readonly/>				</td>
                
             <td width="11%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Exchange Rate</strong></td>
                <td width="17%" align="left" valign="middle" >
				<input name="fxamount" id="fxamount" value="<?php echo $fxamount;?>"size="18" rsize="20" readonly/>				</td>
                
                 <td width="11%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Supplier</strong></td>
                <td width="17%" align="left" valign="middle"  class="bodytext3"><?php echo $suppliername;?>
				</td>
			    </tr>
                <?php 
				$query1mail = "select emailto,emailcc from master_email where recordstatus <> 'deleted' and module='Budget Approval' order by auto_number desc";
				$exec1mail = mysql_query($query1mail) or die ("Error in Query1mail".mysql_error());
				while ($res1mail = mysql_fetch_array($exec1mail))
				{
					$emailto = $res1mail["emailto"];
					$emailcc = $res1mail["emailcc"];
				}
				?>
                
            </tbody>
        </table></td>
      </tr>
      <tr>
	  <td>&nbsp;
	  </td>
	  </tr>
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody>
             <tr>
                       <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Medicine Name</strong></td>
                       <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Original Qty</strong></td>
                       <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Req Qty</strong></td>
                       <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Pack Size</strong></td>
                       <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Pkg Qty</strong></td>
                       <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Rate</strong></td>
					   <!--<td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Original Amount</strong></td>-->
                       <td bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>Amount</strong></td>
					   
                     </tr>
				  		<?php
			$colorloopcount = '';
			$sno = 0;
			$totalamount=0;			
			$query12 = "select * from purchase_indent where docno='$docno' and (approvalstatus='' or approvalstatus='rejected1') and pogeneration <> 'completed'";
			$exec12= mysql_query($query12) or die ("Error in Query1".mysql_error());
			$numb=mysql_num_rows($exec12);
			
			while($res12 = mysql_fetch_array($exec12))
         {
		$medicinename = $res12['medicinename'];
		$itemcode = $res12['medicinecode'];
		$purchasetype = $res12['purchasetype'];
		$reqqty = $res12['quantity'];
		$originalqty= $res12['originalqty'];
		$originalamt=$res12['originalamt'];
		if(trim($purchasetype)=='non-medical')
		{
			$itemcode = $res12['auto_number'];
		}
		$query231 = "select * from master_employeelocation where username='$username' and defaultstore='default'";
		$exec231 = mysql_query($query231) or die(mysql_error());
		$res231 = mysql_fetch_array($exec231);
		 $res7locationanum1 = $res231['locationcode'];
		
		/*$query551 = "select * from master_location where auto_number='$res7locationanum1'";
		$exec551 = mysql_query($query551) or die(mysql_error());
		$res551 = mysql_fetch_array($exec551);
		$location = $res231['locationname'];*/
		
		 $res7storeanum1 = $res231['storecode'];
		
		$query751 = "select * from master_store where auto_number='$res7storeanum1'";
		$exec751 = mysql_query($query751) or die(mysql_error());
		$res751 = mysql_fetch_array($exec751);
		$store = $res751['store'];
		$storecode = $res751['storecode'];
		
			$query2 = "select * from master_medicine where itemcode = '$itemcode'";
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			$res2 = mysql_fetch_array($exec2);
			$package = $res2['packagename'];
			
			$packagequantity = $res12['packagequantity'];
			$rate = $res12['rate'];
			$amount = $res12['amount']; 
			$itemcode = $itemcode;
		//include ('autocompletestockcount1include1.php');
		//$querystock1 = "select sum(batch_quantity) as currentstock from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$locationcode' and storecode ='$storecode'";
//		$execstock1 = mysql_query($querystock1) or die ("Error in Querystock1".mysql_error());
//		$resstock1 = mysql_fetch_array($execstock1);
//		$currentstock = $resstock1['currentstock'];
//		$currentstock = $currentstock;
		
		$totalamount= $totalamount + $amount;
		$sno = $sno + 1;
		
?>
  <tr>
		
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $medicinename;?></div></td>
		<input type="hidden" name="medicinenamear[]" value="<?php echo $medicinename;?>">
		<input type="hidden" name="itemcodear[]" value="<?php echo $itemcode; ?>">
        <input type="hidden" name="purchasetypear[]" value="<?php echo $purchasetype; ?>">
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $originalqty;?></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="reqqtyar[]" id="reqqty<?php echo $sno ; ?>" value="<?php echo number_format($reqqty);?>" size="6" onKeyUp="return calc('<?php echo $sno; ?>','<?php echo $numb; ?>');" onFocus="funqty(this.id)" onBlur="funqty(this.id)"></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="packsizear[]" id="packsize<?php echo $sno ; ?>" value="<?php echo $package;?>" size="6" class="bal" readonly></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="pkgqtyar[]" id="pkgqty<?php echo $sno ; ?>" size="6" value="<?php echo $packagequantity;?>" class="bal" readonly></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="ratear[]" id="rate<?php echo $sno ; ?>" value="<?php echo number_format($rate,'2','.',',');?>" size="6" class="bal" readonly></div></td>
		<!--<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo number_format($originalamt,'2','.',',');?></div></td>-->
		<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="amountar[]" id="amount<?php echo $sno ; ?>" value="<?php echo number_format($amount,'2','.',',');?>" size="10" class="bal" readonly>
        <input type="checkbox" name="appar[]" value="<?php echo $itemcode; ?>" style="display:none;"/>
        </div></td>
				</tr>
			<?php 
		
			}
		?>
		</tbody>
		<tr>
		   <td colspan="7" bgcolor="#ffffff" class="bodytext31" valign="center"  align="center"><strong>&nbsp;</strong></td>
		</tr>   
		<tr>
		   <td bgcolor="#ccc" class="bodytext31" valign="center"  align="center"><strong>Medicine Name</strong></td>
		   <td bgcolor="#ccc" class="bodytext31" valign="center"  align="left"><strong>Original Qty</strong></td>
		   <td bgcolor="#ccc" class="bodytext31" valign="center"  align="left"><strong>Req Qty</strong></td>
		   <td bgcolor="#ccc" class="bodytext31" valign="center"  align="left"><strong>Pack Size</strong></td>
		   <td bgcolor="#ccc" class="bodytext31" valign="center"  align="left"><strong>Pkg Qty</strong></td>
		   <td bgcolor="#ccc" class="bodytext31" valign="center"  align="left"><strong>Rate</strong></td>
		   <td bgcolor="#ccc" class="bodytext31" valign="center"  align="left"><strong>Amount</strong></td> 
		 </tr>
		 <tbody id="insertrow">
		 </tbody>
		 <tr>
		  <input type="hidden" name="serialnumber" id="serialnumber" value="<?php echo $sno + 1; ?>">
		  <input type="hidden" name="medicinecode" id="medicinecode" value="">
		   <td><input name="medicinename" type="text" id="medicinename" size="25" autocomplete="off">
		   <input type="hidden" name="medicinenamel" id="medicinenamel" value="">
		   </td>
		   <td><input name="avlqty" type="text" id="avlqty" size="8" readonly></td>
			<td><input name="reqqty" type="text" id="reqqty" size="8" onKeyUp="return calcad();" autocomplete="off"></td>
		   <td><input name="packsize" type="text" id="packsize" size="8" readonly></td>
		   <td><input name="pkgqty" type="text" id="pkgqty" size="8" readonly></td>
		   <td width="48"><input name="rate" type="text" id="rate" readonly size="8" onKeyUp="return calcad();" autocomplete="off">
		   <input name="fxrate" type="hidden" id="fxrate" readonly size="8"></td>
		   <td>
			 <input name="amount" type="text" id="amount" readonly size="8"></td>
		   <td><label>
		   <input type="button" name="Add" id="Add" value="Add" onClick="return insertitem10()" class="button" style="border: 1px solid #001E6A">
		   </label></td>
		   </tr>
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
                bgcolor="#cccccc">
				<input type="hidden" name="total" id="total">
				<input type="text" name="totalamount" id="totalamount" value="<?php echo number_format($totalamount,'2','.',','); ?>" size="10" class="bal" readonly></td>
				 
               </tr>
           
          </tbody>
        </table>		</td>
      </tr>
				    
				  <tr>
	  <td>&nbsp;
	  </td>
	  </tr>
	  <tr>
	  <td colspan="3">
	  <table width="48%" border="0">
	  <tr>
	  <td width="48%" align="left" valign="center"  
				bgcolor="#F3F3F3" class="bodytext31"><div align="right"><span class="bodytext311"><strong>Project </strong></span></div></td>
				<td width="52%" bgcolor="#F3F3F3"> <input name="project" id="project" style="text-align:left;" value="<?php echo $project; ?>" size="" /></td>
				<tr>
				<td width="48%" align="left" valign="center"  
				bgcolor="#F3F3F3" class="bodytext31"><div align="right"><span class="bodytext311"><strong>Budget Line</strong></span></div></td>
				<td bgcolor="#F3F3F3"> <input name="budgetline" id="budgetline" style="text-align:left;" value="<?php echo $budgetline; ?>" size="" /></td></tr>
				<tr><td width="48%" align="left" valign="center"  
				bgcolor="#F3F3F3" class="bodytext31"><div align="right"><span class="bodytext311"><strong>Budget Code</strong></span></div></td>
				<td bgcolor="#F3F3F3"> <input name="budgetcode" id="budgetcode" style="text-align:left;" value="<?php echo $budgetcode; ?>" size="" /></td></tr>
				<tr><td width="48%" align="left" valign="center"  
				bgcolor="#F3F3F3" class="bodytext31"><div align="right"><span class="bodytext311"><strong>Warranty</strong></span></div></td>
				<td bgcolor="#F3F3F3"> <input name="warrenty" id="warrenty" style="text-align:left;" value="<?php echo $warrenty; ?>" size="" /></td></tr>
				<tr> <td width="48%" align="left" valign="center"  
				bgcolor="#F3F3F3" class="bodytext31"><div align="right"><span class="bodytext311"><strong>Delivery/Transport</strong></span></div></td>
				<td bgcolor="#F3F3F3"> <input name="deliveryortransport" id="deliveryortransport" style="text-align:left;" value="<?php echo $deliveryortransport; ?>" size="" /></td></tr>
				<tr><td width="48%" align="left" valign="center"  
				bgcolor="#F3F3F3" class="bodytext31"><div align="right"><span class="bodytext311"><strong>Terms of Payment</strong></span></div></td>
				<td bgcolor="#F3F3F3"> <input name="payment" id="payment" style="text-align:left;" value="<?php echo $payment; ?>" size="" /></td></tr>
				<tr>  <td width="48%" align="left" valign="center"  
				bgcolor="#F3F3F3" class="bodytext31"><div align="right"><span class="bodytext311"><strong>Quotation Number/Date</strong></span></div></td>
				<td bgcolor="#F3F3F3"><input type="text" name="quotationnum" id="quotationnum" value="<?php echo $quotationnum; ?>"></td></tr>
				<tr>  <td width="48%" align="left" valign="center"  
				bgcolor="#F3F3F3" class="bodytext31"><div align="right"><span class="bodytext311"><strong>LPO Validity</strong></span></div></td>
				<td bgcolor="#F3F3F3"><input type="text" name="lpovalidity" id="lpovalidity" value="<?php echo $lpovalidity; ?>"></td></tr>
				<tr>  <td width="48%" align="left" valign="center"  
				bgcolor="#F3F3F3" class="bodytext31"><div align="right"><span class="bodytext311"><strong>Reason for Expenditure</strong></span></div></td>
				<td bgcolor="#F3F3F3"><input type="text" name="expenditure" id="expenditure" value="<?php echo $expenditure; ?>"></td></tr>
				<tr>  <td width="48%" align="left" valign="center"  
				bgcolor="#F3F3F3" class="bodytext31"><div align="right"><span class="bodytext311"><strong>VAT @16%</strong></span></div></td>
				<td bgcolor="#F3F3F3"><input type="text" name="vatpercent" id="vatpercent" value="<?php echo $vatpercent; ?>"></td></tr>
				<td width="48%" align="left" valign="center"  
				bgcolor="#F3F3F3" class="bodytext31"><div align="right"><span class="bodytext311"><strong>Address</strong></span></div></td>
				<td bgcolor="#F3F3F3"> <textarea rows="2" cols="22" name="address" id="address"><?php echo $address; ?></textarea></td>
				<tr>
				<td width="48%" align="left" valign="center"  
				bgcolor="#F3F3F3" class="bodytext31"><div align="right"><span class="bodytext311"><strong>Authorised By</strong></span></div></td>
				<td bgcolor="#F3F3F3"> <input name="authorisedby" id="authorisedby" style="text-align:left;" value="<?php echo $authorisedby; ?>" size="" /></td></tr>
              </table>
	  </td>
	  </tr>
      <tr>
	  <td>
	  <table width="100%">
     <tr>
	 <td width="66" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">User Name</td>
	   <td width="111" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"> <input type="text" name="username" value="<?php echo $username; ?>" size="10"></td>
	    <td width="47" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"></td>
	   <td width="60" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"> <input type="checkbox" id="discard" name="discard"   onClick="discardchk()" value="<?php echo $docno; ?>" style="display:none;"> </td>
       <td width="84" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Remarks</td>
	    <td width="260" valign="middle"  bgcolor="#E0E0E0" class="bodytext3" calign="left"><textarea name="remarks" id="remarks"></textarea></td>
	    <td width="47" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"></td>
	   <td width="120" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"> <input type="checkbox" id="selectall" onClick="selectAll(this)" style="display:none;"></td>
	  <td align="left"></td>
     </tr>
		</table>
		</td>
		</tr>				
		        
      <tr>
        <td align="left">
               <a href="print_generaterpia.php?docnumber=<?php echo $docno; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a>
               </td>
		 <td colspan="1" align="right" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
		  <input type="hidden" name="frm1submit1" value="frm1submit1" />
                  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
               <input name="Submit222" type="submit"  value="Save" class="button" id="saveindent">		 </td>
              
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
