<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$timeonly = date("H:i:s");
$username = $_SESSION["username"];
$docno = $_SESSION['docno'];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$currentdate = date("Y-m-d");
$updatedate=date("Y-m-d");
$titlestr = 'SALES BILL';



if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
	$paynowbillprefix = 'IPMP-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from ipmedicine_prescription where recordstatus = '' order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='IPMP-'.'1';
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
	
	
	$billnumbercode = 'IPMP-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}


	$billdate=$_REQUEST['billdate'];
	
	$paymentmode = $_REQUEST['billtype'];
		$patientname = $_REQUEST['customername'];
		$locationcode = $_REQUEST['location'];
		$patientcode = $_REQUEST['patientcode'];
		$visitcode = $_REQUEST['visitcode'];
		$billtype = $_REQUEST['billtypes'];
		$age=$_REQUEST['age'];
		$gender=$_REQUEST['gender'];
		$accountname = $_REQUEST['account'];
		$dischargemedicine = isset($_REQUEST["dischargemedicine"])? 'Yes' : 'No';
		$frompage = $_REQUEST['frompage'];
		$locationnameget=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';
		
		$locationcodeget=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
		$storecodeget=isset($_REQUEST['storecode'])?$_REQUEST['storecode']:'';
			
for ($p=1;$p<=20;$p++)
		{	
		    $medicinename = $_REQUEST['medicinename'.$p];
			$medicinename = addslashes($medicinename);
			$query77="select * from master_medicine where itemname='$medicinename'";
			$exec77=mysql_query($query77);
			$res77=mysql_fetch_array($exec77);
			$medicinecode=$res77['itemcode'];
			$rate=$res77['rateperunit'];
			$categoryname = $res77['categoryname'];
			
		
			$quantity = $_REQUEST['quantity'.$p];
			$frequency = $_REQUEST['frequency'.$p];
			$days = $_REQUEST['days'.$p];
			$dose = $_REQUEST['dose'.$p];
			$pharmfree = $_REQUEST['pharmfree'.$p];
			$instructions = $_REQUEST['instructions'.$p];
			$route = $_REQUEST['route'.$p];
			$hour = $_REQUEST['hour'.$p];
			$minute = $_REQUEST['minute'.$p];
			$sec = '00';
			$expirymonth = substr($expirydate, 0, 2);
			$expiryyear = substr($expirydate, 3, 2);
			$expiryday = '01';
			$expirydate = $expiryyear.'-'.$expirymonth.'-'.$expiryday;
			$starttime = $hour.':'.$minute.':'.$sec;
			$sess = $_REQUEST['sess'.$p];
			
			$amount = $quantity * $rate;
			
			$rates= $_REQUEST['rates'.$p];
			$amounts= $_REQUEST['amounts'.$p];
			
			
			//if ($medicinename != "" && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")
			if ($medicinename != "")// && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")
			{
			
			
			$query86 ="insert into ipmedicine_prescription(itemname,itemcode,quantity,prescribed_quantity,rateperunit,totalrate,batchnumber,companyanum,patientcode,visitcode,patientname,username,ipaddress,date,account,docno,billtype,expirydate,starttime,session,frequency,dose,days,freestatus,route,dischargemedicine,medicineissue,instructions,locationcode,locationname)values('$medicinename','$medicinecode','$quantity','$quantity','$rates','$amounts','$batch','$companyanum','$patientcode','$visitcode','$patientname','$username','$ipaddress','$dateonly','$accountname','$billnumbercode','$billtype','$expirydate','$starttime','$sess','$frequency','$dose','$days','$pharmfree','$route','$dischargemedicine','pending','$instructions','".$locationcodeget."','".$locationnameget."')"; 
			
			$exec86 = mysql_query($query86) or die(mysql_error());
		       }
			   }	
			if($frompage == 'newborn')
			{
			header("location:newbornactivity.php");
			}
			else if($frompage == 'otpatients')
			{
			header("location:otpatients.php");
			}
			else
			{
			header("location:activeinpatientlist.php");
			}
		    exit;

}


//to redirect if there is no entry in masters category or item or customer or settings



//To get default tax from autoitemsearch1.php and autoitemsearch2.php - for CST tax override.
if (isset($_REQUEST["defaulttax"])) { $defaulttax = $_REQUEST["defaulttax"]; } else { $defaulttax = ""; }
if(isset($_REQUEST['delete']))
{
$radiologyname=$_REQUEST['delete'];
mysql_query("delete from consultation_radiology where radiologyitemname='$radiologyname'");
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
if(isset($_REQUEST["patientcode"]))
{
$patientcode=$_REQUEST["patientcode"];
$visitcode=$_REQUEST["visitcode"];
}
if(isset($_REQUEST["frompage"])){$frompage = $_REQUEST["frompage"]; }else{$frompage ='';}

//This include updatation takes too long to load for hunge items database.


//To populate the autocompetelist_services1.js


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

if ($delbillst == "" && $delbillnumber == "")
{
	$res41customername = "";
	$res41customercode = "";
	$res41tinnumber = "";
	$res41cstnumber = "";
	$res41address1 = "";
	$res41deliveryaddress = "";
	$res41area = "";
	$res41city = "";
	$res41pincode = "";
	$res41billdate = "";
	$billnumberprefix = "";
	$billnumberpostfix = "";
}





?>

<?php
$Querylab=mysql_query("select * from master_customer where customercode='$patientcode'");
$execlab=mysql_fetch_array($Querylab);
 $patientage=$execlab['age'];
 $patientgender=$execlab['gender'];
 $patientname = $execlab['customerfullname'];
 $billtype = $execlab['billtype'];

$patienttype=$execlab['maintype'];
$querytype=mysql_query("select * from master_paymenttype where auto_number='$patienttype'");
$exectype=mysql_fetch_array($querytype);
$patienttype1=$exectype['paymenttype'];
$patientsubtype=$execlab['subtype'];
$querysubtype=mysql_query("select * from master_subtype where auto_number='$patientsubtype'");
$execsubtype=mysql_fetch_array($querysubtype);
$patientsubtype1=$execsubtype['subtype'];
$patientplan=$execlab['planname'];
$queryplan=mysql_query("select * from master_planname where auto_number='$patientplan'");
$execplan=mysql_fetch_array($queryplan);
$patientplan1=$execplan['planname'];

?>
<?php
$querylab1=mysql_query("select * from master_customer where customercode='$patientcode'");
$execlab1=mysql_fetch_array($querylab1);
$patientname=$execlab1['customerfullname'];
$patientaccount=$execlab1['accountname'];

$querylab2=mysql_query("select * from master_accountname where auto_number='$patientaccount'");
$execlab2=mysql_fetch_array($querylab2);
$patientaccount1=$execlab2['accountname'];


$Queryloc=mysql_query("select * from master_ipvisitentry where visitcode='$visitcode'");
$execloc=mysql_fetch_array($Queryloc);
 $locationcode=$execloc['locationcode'];
 $locationname=$execloc['locationname'];
 $patienttype=$execlab['maintype'];
 $packcharge = $execloc['packchargeapply'];

?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$paynowbillprefix = 'IPMP-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from ipmedicine_prescription where recordstatus = '' order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='IPMP-'.'1';
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
	
	
	$billnumbercode = 'IPMP-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
?>
<?php


$query231 = "select * from login_locationdetails where username='$username' and docno='".$docno."' order by locationname";
$exec231 = mysql_query($query231) or die(mysql_error());
$res231 = mysql_fetch_array($exec231);
$res7locationanum1 = $res231['locationcode'];
$location3 = $res231['locationname'];

if(isset($_REQUEST['storecode'])){ $defaultstore = $_REQUEST['storecode']; } else { $defaultstore = ''; }
if($defaultstore == '')
{
$query231 = "select * from master_employeelocation where username='$username' and locationcode='".$res7locationanum1."' and defaultstore = 'default' order by locationname";
}
else
{
$query231 = "select * from master_employeelocation where username='$username' and locationcode='".$res7locationanum1."' and storecode = '$defaultstore' order by locationname";
}
$exec231 = mysql_query($query231) or die(mysql_error());
$res231 = mysql_fetch_array($exec231);
$res7locationanum1 = $res231['locationcode'];
$location3 = $res231['locationname'];
$storeanum = $res231['storecode'];

/*$query551 = "select * from master_location where locationcode='$res7locationanum1'";
$exec551 = mysql_query($query551) or die(mysql_error());
$res551 = mysql_fetch_array($exec551);
$location3 = $res551['locationname'];

$res7storeanum1 = $res231['store'];
*/
$query751 = "select * from master_store where auto_number='$storeanum'";
$exec751 = mysql_query($query751) or die(mysql_error());
$res751 = mysql_fetch_array($exec751);
$store3 = $res751['store'];
$storecode = $res751['storecode'];

?>
<script language="javascript">



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

function funcOnLoadBodyFunctionCall()
{


 //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	 //To handle ajax dropdown list.

	funcPopupPrintFunctionCall();
	funcCustomerDropDownSearch4(); 
		
	
}



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


<?php include ("js/dropdownlist1newscriptingmedicine1.php"); ?>
<script type="text/javascript" src="js/autosuggestipmedicineissue2.js"></script> 
<script type="text/javascript" src="js/autocomplete_ipmedicineissue.js"></script>
<script type="text/javascript" src="js/automedicinecodesearchipmedicineissue1.js"></script>
<script type="text/javascript" src="js/autocomplete_batchnumberippharmacyissue.js"></script>
<script type="text/javascript" src="js/insertnewitemipreqmedicineissue1.js"></script>
<script type="text/javascript" src="js/autocomplete_expirydate1ipmedicineissue.js"></script>
<script type="text/javascript" src="js/autocomplete_stockipmedicineissue.js"></script>
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





</script>




<script language="javascript">
var totalamount=0;
var totalamount1=0;
var totalamount2=0;
var totalamount3=0;
var totalamount4=0;
var totalamount11;
var totalamount21;
var totalamount31;
var totalamount41;
var grandtotal=0;
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
function frequencyitem()
{
if(document.form1.frequency.value=="select")
{
alert("please select a frequency");
document.form1.frequency.focus();
return false;
}
return true;
}

function Functionfrequency()
{
var formula = document.getElementById("formula").value;
formula = formula.replace(/\s/g, '');
//alert(formula);
if(formula == 'INCREMENT')
{
var ResultFrequency;
 var frequencyanum = document.getElementById("frequency").value;
var medicinedose=document.getElementById("dose").value;
 var VarDays = document.getElementById("days").value; 
 if((frequencyanum != '') && (VarDays != ''))
 {
  ResultFrequency = medicinedose*frequencyanum * VarDays;
  //alert(ResultFrequency);
 }
 else
 {
 ResultFrequency =0;
 }
 var currentstock = document.getElementById("currentstock").value;
 if(parseInt(ResultFrequency) > parseInt(currentstock))
 {
 alert("Please Enter Lesser Quantity");
 document.getElementById("days").value = 0; 
 document.getElementById("quantity").value =0;
  document.getElementById("amount").value = '0.00';
 return false;
 }
 document.getElementById("quantity").value = ResultFrequency;
 
 
var VarRate = document.getElementById("rate").value;
var ResultAmount = parseFloat(VarRate * ResultFrequency);
  document.getElementById("amount").value = ResultAmount.toFixed(2);
}

else if(formula == 'CONSTANT')
{
var ResultFrequency;
var strength = document.getElementById("strength").value;
 var frequencyanum = document.getElementById("frequency").value;
var medicinedose=document.getElementById("dose").value;
 var VarDays = document.getElementById("days").value; 
 if((frequencyanum != '') && (VarDays != ''))
 {
  ResultFrequency = medicinedose*frequencyanum*VarDays/strength;
 }
 else
 {
 ResultFrequency =0;
 }
 //ResultFrequency = parseInt(ResultFrequency);

 ResultFrequency = Math.ceil(ResultFrequency);
 //alert(ResultFrequency);
 var currentstock = document.getElementById("currentstock").value;
 if(parseInt(ResultFrequency) > parseInt(currentstock))
 {
 alert("Please Enter Lesser Quantity");
 document.getElementById("days").value = 0; 
 return false;
 }
 document.getElementById("quantity").value = ResultFrequency;
 
 
var VarRate = document.getElementById("rate").value;
var ResultAmount = parseFloat(VarRate * ResultFrequency);
  document.getElementById("amount").value = ResultAmount.toFixed(2);
}
}
function processflowitem(varstate)
{
	//alert ("Hello World.");
	var varProcessID = varstate;
	//alert (varProcessID);
	var varItemNameSelected = document.getElementById("state").value;
	//alert (varItemNameSelected);
	ajaxprocess5(varProcessID);
	//totalcalculation();
}

function btnDeleteClick(delID)
{
	//alert ("Inside btnDeleteClick.");
	var newtotal4;
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

	var amountid='amounts'+delID+'';
	var varamount12= parseFloat(document.getElementById(amountid).value);
	var vartotal12= parseFloat(document.getElementById('total').value);
	
	vartotal12=vartotal12-varamount12;
	document.getElementById('total').value=vartotal12.toFixed(2);

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

function funcvalidcheck()
{
if(document.getElementById('request').value == '')
{
alert("Please Add Medicine");
return false;
}
}
</script>

<script type="text/javascript">
function Redirect(patientcode,visitcode,location)
{
var patientcode = patientcode;
var visitcode = visitcode;
var location = location;

var Store = document.getElementById("storecode").value;

<?php
$query10 = "select * from master_store";
$exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());
while($res10 = mysql_fetch_array($exec10))
{
$res10storecode = $res10['storecode'];
$res10storeanum = $res10['auto_number'];
?>
if(document.getElementById("storecode").value == "<?php echo $res10storecode; ?>")
{
//alert("<?php echo $res10storeanum; ?>");
var Storeanum = "<?php echo $res10storeanum; ?>";
window.location = "ipmedicineissue.php?patientcode="+patientcode+"&&visitcode="+visitcode+"&&searchlocation="+location+"&&storecode="+Storeanum;
}
<?php
}
?>
//window.location = "pharmacy1.php?patientcode="+patientcode+"&&visitcode="+visitcode+"&&loccode="+location+"&&store="+Store;

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
	font-size: 30px;
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
font-size: 30px;
	font-weight: bold;
	FONT-FAMILY: Tahoma
}
</style>

<script src="js/datetimepicker_css.js"></script>

</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="form1" id="frmsales" method="post" action="ipmedicineissue.php" onKeyDown="return disableEnterKey(event)" onSubmit="return funcvalidcheck()">
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
                <tr bgcolor="#011E6A">
                <td colspan="7" bgcolor="#CCCCCC" class="bodytext32"><strong>Patient Details</strong></td>
			 </tr>
		<tr>
                <td colspan="7" class="bodytext32"><strong>&nbsp;</strong></td>
			 </tr>
			
				<tr>
                <td width="17%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext32"> <strong>Patient Name</strong>  </span></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
				<input name="customername" id="customername" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A; text-transform:uppercase;" size="18" type="hidden"><?php echo $patientname; ?>
				<input type="hidden" name="nameofrelative" id="nameofrelative" value="<?php echo $nameofrelative; ?>" style="border: 1px solid #001E6A;" size="45"></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
				<strong>Patientcode</strong></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
				<input name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A; text-transform:uppercase;" size="18" type="hidden"><?php echo $patientcode; ?>
				<input name="frompage" id="frompage" value="<?php echo $frompage; ?>" type="hidden">
				</td>
				</tr>       
               
			   <tr>
			    <td width="17%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Visitcode</strong></td>
                <td align="left" valign="middle" class="bodytext3">
				<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" />	<?php echo $visitcode; ?></td>			
			   	  <td width="17%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Account</strong></td>
                <td align="left" valign="top" class="bodytext3">
				<input type="hidden" name="account" id="account" value="<?php echo $patientaccount1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" />		
				<input type="hidden" name="billtypes" id="billtypes" value="<?php echo $billtype; ?>" />
			<?php echo $patientaccount1; ?>	</td>	
 </tr>
				  <tr>
							 <td align="left" valign="middle" class="bodytext3"><strong> Date</strong></td>
				<td class="bodytext3"><input type="hidden" name="billdate" id="billdate" value="<?php echo $dateonly; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<?php echo $dateonly; ?>				</td>	
                 <td align="left" valign="middle" class="bodytext3"><strong>Doc No</strong></td>
				<td class="bodytext3"><input type="hidden" name="billno" id="billno" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>	
				<?php echo $billnumbercode; ?>							</td>
				  </tr>
                  			<tr>
							 <td align="left" valign="middle" class="bodytext3"><strong> Location</strong></td>
				<td class="bodytext3"><input type="hidden" name="location" id="location" value="<?php echo $location3; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<?php echo $location3; ?><input type="hidden" name="locationcode" id="locationcode" value="<?php echo $res7locationanum1;?>">
                <input type="hidden" name="locationnameget" id="locationnameget" value="<?php echo $location3;?>">
                				</td>	
                 <td align="left" valign="middle" class="bodytext3"><strong>Store</strong></td>
				<td class="bodytext3"><input type="hidden" name="store" id="store" value="<?php echo $store3; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				
				<input type="hidden" name="request" id="request" value="">
				
				<select name="storecode" id="storecode" onChange="return Redirect('<?php echo $patientcode; ?>','<?php echo $visitcode; ?>','<?php echo $res7locationanum1; ?>')">
				<?php if($storecode != '') { ?>
				<option value="<?php echo $storecode; ?>"><?php echo $store3; ?></option>
				<?php } ?>
				<?php 
				$query9 = "select * from master_employeelocation where username = '$username' and locationcode = '$locationcode'";
				$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
				while($res9 = mysql_fetch_array($exec9))
				{
				$res9anum = $res9['storecode'];
				$res9default = $res9['defaultstore'];
				
				$query10 = "select * from master_store where auto_number = '$res9anum'";
				$exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());
				$res10 = mysql_fetch_array($exec10);
				$res10storecode = $res10['storecode'];
				$res10store = $res10['store'];
				$res10anum = $res10['auto_number'];
				?>
				<option value="<?php echo $res10storecode; ?>"><?php echo $res10store; ?></option>
				<?php } ?>
				</select>		</td>
				  </tr>
                  <tr>
				<td align="left" valign="middle" class="bodytext3"><strong>Package</strong></td>
				<td class="bodytext3"><input type="hidden" name="packcharge" id="packcharge" value="<?php echo $packcharge; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>	
				<?php if($packcharge == 1) { echo 'Yes'; } else { echo 'No'; } ?></td>
                  </tr>
							<tr>
							
                <td colspan="7" class="bodytext32"><strong>&nbsp;</strong></td>
			 </tr>	
			
				 		<tr>
						  <td colspan="7" class="bodytext32" bgcolor="#CCCCCC"><strong>IP Medicine Issue</strong></td>
						</tr>
						 <tr>
						  <td colspan="7" class="bodytext32"><strong><input type="checkbox" name="dischargemedicine" id="dischargemedicine" value="1">Discharge Medicine</strong></td>
						</tr>	
				 <tr id="pressid">
				   <td colspan="11" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
				   <table id="presid" width="792" border="0" cellspacing="1" cellpadding="1">
                     <tr>
					<td width="200" class="bodytext3">Medicine Name</td>
                    <td width="35" class="bodytext3">Avl.Qty </td>
					<td width="40" class="bodytext3">Dose</td>
					<td width="40" class="bodytext3">Freq</td>
					<td width="40" class="bodytext3">Days</td>
					<td width="40" class="bodytext3">Quantity</td>
					<td width="43" class="bodytext3">Route</td>
					<td width="43" class="bodytext3">Instructions</td>
					<td width="35" class="bodytext3">Start </td>
					<td width="35" class="bodytext3">Time </td>
                    <td width="35" class="bodytext3">Free </td>
                    <td width="35" class="bodytext3"> </td>
                    <td width="35" class="bodytext3">Rate </td>
                    <td width="35" class="bodytext3">Amount </td>
                    
                     </tr>
					 <tr>
					 <div id="insertrow">					 </div></tr>
                     <tr>
					  <input type="hidden" name="serialnumber" id="serialnumber" value="1">
					  <input type="hidden" name="medicinecode" id="medicinecode" value="">
					   <input name="searchmedicinename1hiddentextbox" id="searchmedicinename1hiddentextbox" type="hidden" value="">
			           <input name="searchmedicineanum1" id="searchmedicineanum1" value="" type="hidden">
						
                       <td><input name="medicinename" type="text" id="medicinename" size="40" autocomplete="off">					   </td>
					    
					    
					<td>   <input type="text" name="currentstock" id="currentstock" size="5" readonly> </td>

					    <td><input name="dose" type="text" id="dose" size="4" onKeyUp="return Functionfrequency()"></td>
                       <td>
					   <select name="frequency" id="frequency" onChange="return Functionfrequency()">
					     <?php
				if ($frequncy == '')
				{
					echo '<option value="select" selected="selected">Select frequency</option>';
				}
				else
				{
					$query51 = "select * from master_frequency where recordstatus = ''";
					$exec51 = mysql_query($query51) or die ("Error in Query51".mysql_error());
					$res51 = mysql_fetch_array($exec51);
					$res51code = $res51["frequencycode"];
					$res51num = $res51['frequencynumber'];
					echo '<option value="'.$res51num.'" selected="selected">'.$res51code.'</option>';
				}
				$query5 = "select * from master_frequency where recordstatus = '' order by auto_number";
				$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
				while ($res5 = mysql_fetch_array($exec5))
				{
				$res5num = $res5["frequencynumber"];
				$res5code = $res5["frequencycode"];
				?>
                <option value="<?php echo $res5num; ?>"><?php echo $res5code; ?></option>
                 <?php
				}
				?>
               </select>				</td>	
                       <td><input name="days" type="text" id="days" size="4" onKeyUp="return Functionfrequency()" onFocus="return frequencyitem()"></td>
                       <td><input name="quantity" type="text" id="quantity" size="4" readonly></td>
                       <td>
					   <select name="route" id="route">
					   <option value="" selected="selected">Select Route</option>
					   <option value="Oral">Oral</option>
					   <option value="Sublingual">Sublingual</option>
					   <option value="Rectal">Rectal</option>
					   <option value="Vaginal">Vaginal</option>
					   <option value="Topical">Topical</option>
					   <option value="Intravenous">Intravenous</option>
					   <option value="Intramuscular">Intramuscular</option>
					   <option value="Subcutaneous">Subcutaneous</option>
					   <option value="Not Applicable">Not Applicable</option>
					    <option value="Intranasal">Intranasal </option>
						 <option value="Eye">Eye</option>
					   </select>					   </td>
					   <td>
					  <input type="text" name="instructions" id="instructions"> 
					   </td>
                     <td>
					 <input type="text" name="hour" id="hour" size="4" placeholder="HH"></td>
					<td>  <input type="text" name="minute" id="minute" size="4" placeholder="MM"></td>
                     <input type="hidden" name="pkg" id="pkg">
                    <td> <select name="pharmfree" id="pharmfree" width="10">
                     <option value="">Select</option>
                        <!--<option value="0">No</option>
                        <option value="1">Yes</option>-->
                      </select></td>
					 <td> <select name="sess" id="sess" width="10">
                        <option value="am">AM</option>
                        <option value="pm">PM</option>
                      </select></td>
					
                    <td>
                      <input type="text" name="rate" id="rate" value="" size="4" readonly>
                      </td>
					 <td>
                      <input type="text" name="amount" id="amount" size="4" readonly>
					 </td> 
                      	 
                         <input name="formula" type="hidden" id="formula" readonly size="8">
						 
                         <input name="strength" type="hidden" id="strength" readonly size="8">
                       <td width="49"><label>
                       <input type="button" name="Add" id="Add" value="Add" onClick="return insertitem()" class="button" style="border: 1px solid #001E6A">
                       </label></td>
					   </tr>
                     
					 <input type="hidden" name="h" id="h" value="0">
                 				  	<tr>
                    <td colspan="12"> </td>
                    <td  class="bodytext32">Total</td>
                <td class="bodytext32">
                  <input type="text" name="total" id="total" size="5" value="0.00" readonly/>
                </td>
                 
			 </tr>
             
                   </table>				  </td>
			     
                   </tr>

             
             
            </tbody>
        </table></td>
      </tr>
     
      
		
		<tr>
		<td>&nbsp;
		</td>
		</tr>
             
               <tr>
	  <td colspan="7" align="right" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
	   <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
	    <input name="Submit2223" type="submit" value="Save" accesskey="b" class="button" />
		</td>
	  </tr>
              
            </tbody>
        </table>
		</td>
		</tr>
     
    </table>

</form>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>
