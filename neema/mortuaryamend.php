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
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$currentdate = date("Y-m-d");
$updatedate=date("Y-m-d");
$titlestr = 'SALES BILL';
$docno = $_SESSION['docno'];
$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
$exec = mysql_query($query) or die ("Error in Query1".mysql_error());
$res = mysql_fetch_array($exec);
	
	 $locationname  = $res["locationname"];
	 $locationcode = $res["locationcode"];
if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if (isset($_REQUEST["docno"])) { $docno = $_REQUEST["docno"]; } else { $docno = ""; }

if(isset($_REQUEST['delete']))
{
	
$autonumber=$_REQUEST['delete'];
$viscode=$_REQUEST['visitcode'];
//$docno=$_REQUEST['docno'];	


if($visitcode=='walkinvis')
{
	mysql_query("delete from mortuaryexternal_services where auto_number='$autonumber' and patientvisitcode='$viscode'");
	
}
else
{
mysql_query("delete from ipconsultation_services where auto_number='$autonumber' and patientvisitcode='$viscode'");
}
}
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
	$paynowbillprefix = 'TP-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from iptest_procedures order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='TP-'.'1';
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
	
	
	$billnumbercode = 'TP-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}

	$billdate=$_REQUEST['billdate'];
	
		$paymentmode = $_REQUEST['billtype'];
		$patientfullname = $_REQUEST['customername'];
		$patientcode = $_REQUEST['patientcode'];
		$visitcode = $_REQUEST['visitcode'];
		$billtype = $_REQUEST['billtypes'];
		$age=$_REQUEST['age'];
		$gender=$_REQUEST['gender'];
		$account = $_REQUEST['account'];
		$mortuarydocno = $_REQUEST['mortuarydocno'];
		

	    $rad= $_POST['radiology'];
		$rat=$_POST['rate8'];
		$items = array_combine($rad,$rat);
		$pairs = array();
		
		
		
			foreach($_POST['services'] as $key => $value)
		{
				    //echo '<br>'.$k;

		$servicesname=$_POST["services"][$key];
		$servicequery=mysql_query("select * from master_services where itemname='$servicesname'");
		$execservice=mysql_fetch_array($servicequery);
		$servicescode=$execservice['itemcode'];
		
		$servicesrate=$_POST["rate3"][$key];
		$servicesfree = $_POST["servicesfree"][$key];
		$quantityser=$_POST['quantityser3'][$key];
		$totalservice3=$_POST['totalservice3'][$key];

			if($patientcode=='walkin')
			{
			if(($servicesname!="")&&($servicesrate!=''))
		{

		$servicesquery1=mysql_query("insert into mortuaryexternal_services(patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,consultationdate,paymentstatus,mortuarydocno,consultationtime,freestatus,quantity,amount,username )values('$patientcode','$patientfullname','$visitcode','$servicescode','$servicesname','$servicesrate','$currentdate','pending','$mortuarydocno','$timeonly','$servicesfree','$quantityser','$totalservice3','$username')") or die(mysql_error());
		}
			}
			
			else
			{
		
		/*for($se=1;$se<=$quantityser;$se++)
		{*/		
		if(($servicesname!="")&&($servicesrate!=''))
		{
			
					
		$servicesquery1=mysql_query("insert into ipconsultation_services(patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,consultationdate,paymentstatus,process,iptestdocno,accountname,billtype,consultationtime,freestatus,qty, total)values('$patientcode','$patientfullname','$visitcode','$servicescode','$servicesname','$servicesrate','$currentdate','paid','pending','$billnumbercode','$account','$billtype','$timeonly','$servicesfree','$quantityser','$totalservice3')") or die(mysql_error()); 
		mysql_query("insert into iptest_procedures(docno,patientname,patientcode,visitcode,account,recorddate,ipaddress,recordtime,username,billtype)values('$billnumbercode','$patientfullname','$patientcode','$visitcode','$account','$currentdate','$ipaddress','$timeonly','$username','$billtype')") or die(mysql_error());
		}
		}
		//}
		}
		header("location:mortuaryactivity.php");
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
if (isset($_REQUEST["docno"])) { $docno = $_REQUEST["docno"]; } else { $docno = ""; }
//$ss="select * from mortuary_allocation where docno='$docno'";
$Querylab=mysql_query("select * from mortuary_allocation where docno='$docno'");
$execlab=mysql_fetch_array($Querylab);
 //$patientage=$execlab['age'];
 //$patientgender=$execlab['gender'];
 $patientname = $execlab['patientname'];
 $patientaccount=$execlab['accountname'];
 $requestno = $execlab['requestno'];

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
 
$querylab1=mysql_query("select * from mortuary_request where docno='$requestno'");
$execlab1=mysql_fetch_array($querylab1);
//echo $patientname=$execlab1['patientname'];

$billtype = $execlab1['billtype'];

$querylab2=mysql_query("select * from master_accountname where auto_number='$patientaccount'");
$execlab2=mysql_fetch_array($querylab2);
$patientaccount1=$execlab2['accountname'];

?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$paynowbillprefix = 'TP-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from iptest_procedures order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='TP-'.'1';
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
	
	
	$billnumbercode = 'TP-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
?>
<?php

/*include ("autocompletebuild_lab1.php");
include ("autocompletebuild_radiology1.php");*/
include ("autocompletebuild_mortuaryservices.php");

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
		funcCustomerDropDownSearch3();
	//funcCustomerDropDownSearch1();
	//funcCustomerDropDownSearch2();
		
		funcOnLoadBodyFunctionCall1();
	
}
function funcOnLoadBodyFunctionCall1()
{
    
	
	funcLabHideView();
	funcRadHideView();
	funcSerHideView();
	
}



function funcLabShowView()
{


 
  if (document.getElementById("labid") != null) 
     {
	 document.getElementById("labid").style.display = 'none';
	}
	if (document.getElementById("labid") != null) 
	  {
	  document.getElementById("labid").style.display = '';
	 }
	 
	return true;
	 return true;
}
	
function funcLabHideView()
{		
 if (document.getElementById("labid") != null) 
	{
	document.getElementById("labid").style.display = 'none';
	}		
	 
}

function funcRadShowView()
{


 
  if (document.getElementById("radid") != null) 
     {
	 document.getElementById("radid").style.display = 'none';
	}
	if (document.getElementById("radid") != null) 
	  {
	  document.getElementById("radid").style.display = '';
	 }
	 return true;
	 return true;
}
	
function funcSerHideView()
{		
 if (document.getElementById("serid") != null) 
	{
	document.getElementById("serid").style.display = 'none';
	}			
}
function funcSerShowView()
{

 
  if (document.getElementById("serid") != null) 
     {
	 document.getElementById("serid").style.display = 'none';
	}
	if (document.getElementById("serid") != null) 
	  {
	  document.getElementById("serid").style.display = '';
	 }
	 return true;
	 return true;
}
	
function funcRadHideView()
{		
 if (document.getElementById("radid") != null) 
	{
	document.getElementById("radid").style.display = 'none';
	}			
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





</script>


<?php //include ("js/dropdownlist1scriptinglab1.php"); ?>
<!--<script type="text/javascript" src="js/autocomplete_lab1.js"></script>
<script type="text/javascript" src="js/autosuggestlab1.js"></script> 
<script type="text/javascript" src="js/autolabcodesearch2.js"></script>-->


<?php //include ("js/dropdownlist1scriptingradiology1.php"); ?>
<!--<script type="text/javascript" src="js/autocomplete_radiology1.js"></script>
<script type="text/javascript" src="js/autosuggestradiology1.js"></script> 
<script type="text/javascript" src="js/autoradiologycodesearch2.js"></script>-->


<?php include ("js/dropdownlist1scriptingservices1.php"); ?>
<script type="text/javascript" src="js/autocomplete_mortuaryservices.js"></script>
<script type="text/javascript" src="js/autosuggestservices1.js"></script>
<script type="text/javascript" src="js/autoservicescodesearch2.js"></script>


<!--<script type="text/javascript" src="js/insertnewitem22iplab.js"></script>
<script type="text/javascript" src="js/insertnewitem33iprad.js"></script>-->
<script type="text/javascript" src="js/insertnewitemmortuaryser.js"></script>

<script language="javascript">

function deletevalid()
{
var del;
del=confirm("Do You want to delete this lab test ?");
if(del == false)
{
return false;
}
}


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
var ResultFrequency;
 var frequencyanum = document.getElementById("frequency").value;
var medicinedose=document.getElementById("dose").value;
 var VarDays = document.getElementById("days").value; 
 if((frequencyanum != '') && (VarDays != ''))
 {
  ResultFrequency = medicinedose*frequencyanum * VarDays;
 }
 else
 {
 ResultFrequency =0;
 }
 document.getElementById("quantity").value = ResultFrequency;
var VarRate = document.getElementById("rate").value;
var ResultAmount = parseFloat(VarRate * ResultFrequency);
  document.getElementById("amount").value = ResultAmount.toFixed(2);
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

function processflowitem1()
{
}
function btnDeleteClick(delID,pharmamount)
{
var pharmamount=pharmamount;
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
	var currenttotal4=document.getElementById('total').value;
	//alert(currenttotal);
	newtotal4= currenttotal4-pharmamount;
	
	//alert(newtotal);
	
	document.getElementById('total').value=newtotal4;
	
	var currentgrandtotal4=document.getElementById('total4').value;
	if(currentgrandtotal4 == '')
	{
	currentgrandtotal4=0;
	}
	
	if(document.getElementById('total1').value=='')
	{
	totalamount11=0;
	}
	else
	{
	totalamount11=document.getElementById('total1').value;
	}
	if(document.getElementById('total2').value=='')
	{
	totalamount21=0;
	}
	else
	{
	totalamount21=document.getElementById('total2').value;
	}
	if(document.getElementById('total3').value=='')
	{
	totalamount31=0;
	}
	else
	{
	totalamount31=document.getElementById('total3').value;
	}
	
	
	var newgrandtotal4=parseInt(newtotal4)+parseInt(totalamount11)+parseInt(totalamount21)+parseInt(totalamount31);
	
	//alert(newgrandtotal4);
	
	document.getElementById('total4').value=newgrandtotal4.toFixed(2);
	
	
	document.getElementById("totalamount").value=newgrandtotal4.toFixed(2);
	document.getElementById("subtotal").value=newgrandtotal4.toFixed(2);
	document.getElementById("subtotal1").value=newgrandtotal4.toFixed(2);
}
function btnDeleteClick1(delID1,vrate1)
{
var vrate1 = vrate1;

	var newtotal3;
	//alert(vrate1);
	var varDeleteID1 = delID1;
	//alert(varDeleteID1);
	var fRet4; 
	fRet4 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet4); 
	if (fRet4 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}
	
	var child1 = document.getElementById('idTR'+varDeleteID1); //tr name
    var parent1 = document.getElementById('insertrow1'); // tbody name.
	document.getElementById ('insertrow1').removeChild(child1);
	
	var child1= document.getElementById('idTRaddtxt'+varDeleteID1);  //tr name
    var parent1= document.getElementById('insertrow1'); // tbody name.
	//alert (child);
	if (child1 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow1').removeChild(child1);
	}
	
	var currenttotal3=document.getElementById('total1').value;
	//alert(currenttotal);
	newtotal3= currenttotal3-vrate1;
	newtotal3=newtotal3.toFixed(2);
	//alert(newtotal3);
	
	document.getElementById('total1').value=newtotal3;
	
	if(document.getElementById('total2').value=='')
	{
	 totalamount21=0;
	//alert(totalamount21);
	}
	else
	{
	totalamount2=document.getElementById('total2').value;
	}
	if(document.getElementById('total3').value=='')
	{
	 totalamount31=0;
	//alert(totalamount31);
	}
	else
	{
	 totalamount31=document.getElementById('total3').value;
	}
	
		 newgrandtotal3=parseInt(newtotal3)+parseInt(totalamount21)+parseInt(totalamount31);
	//alert(newgrandtotal3);
	document.getElementById('total4').value=newgrandtotal3.toFixed(2);
	
	
	
}

function btnDeleteClick5(delID5,radrate)
{
var radrate=radrate;
	//alert ("Inside btnDeleteClick.");
	var newtotal2;
	//alert(radrate);
	//alert(delID5);
	var varDeleteID2= delID5;
	//alert (varDeleteID2);
	var fRet5; 
	fRet5 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet5 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child2= document.getElementById('idTR'+varDeleteID2);  //tr name
	//alert(child2);
    var parent2 = document.getElementById('insertrow2'); // tbody name.
	//alert(parent2);
	document.getElementById ('insertrow2').removeChild(child2);
	
	var child2 = document.getElementById('idTRaddtxt'+varDeleteID2);  //tr name
    var parent2 = document.getElementById('insertrow2'); // tbody name.
	//alert (child);
	if (child2 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow2').removeChild(child2);
	}
	
	var currenttotal2=document.getElementById('total2').value;
	//alert(currenttotal);
	newtotal2= currenttotal2-radrate;
	
	//alert(newtotal);
	
	document.getElementById('total2').value=newtotal2;

	if(document.getElementById('total1').value=='')
	{
	totalamount21=0;
	}
	else
	{
	totalamount21=document.getElementById('total1').value;
	}
	if(document.getElementById('total3').value=='')
	{
	totalamount31=0;
	}
	else
	{
	totalamount31=document.getElementById('total3').value;
	}
	
	
	
    var newgrandtotal2=parseInt(totalamount21)+parseInt(newtotal2)+parseInt(totalamount31);
	
	//alert(newgrandtotal4);
	
	document.getElementById('total4').value=newgrandtotal2.toFixed(2);
	
	
	
		document.getElementById("subtotal").value=newgrandtotal2.toFixed(2);
	document.getElementById("subtotal1").value=newgrandtotal2.toFixed(2);

	document.getElementById("totalamount").value=newgrandtotal2.toFixed(2);

	
}
function btnDeleteClick3(delID3,vrate3)
{
var vrate3=vrate3;
	//alert ("Inside btnDeleteClick.");
	var newtotal1;
	var varDeleteID3= delID3;
	//alert (varDeleteID3);
	//alert(vrate3);
	var fRet6; 
	fRet6 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet6 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	var child3 = document.getElementById('idTR'+varDeleteID3);  
	//alert (child3);//tr name
    var parent3 = document.getElementById('insertrow3'); // tbody name.
	document.getElementById ('insertrow3').removeChild(child3);
	
	var child3= document.getElementById('idTRaddtxt'+varDeleteID3);  //tr name
    var parent3 = document.getElementById('insertrow3'); // tbody name.
	
	if (child3 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow3').removeChild(child3);
	}
var currenttotal1=document.getElementById('total3').value;
	//alert(currenttotal);
	newtotal1= currenttotal1-vrate3;
	
	//alert(newtotal);
	
	document.getElementById('total3').value=newtotal1;
	
	if(document.getElementById('total1').value=='')
	{
	totalamount21=0;
	}
	else
	{
	totalamount21=document.getElementById('total1').value;
	}
	if(document.getElementById('total2').value=='')
	{
	totalamount31=0;
	}
	else
	{
	totalamount31=document.getElementById('total2').value;
	}
	
	
	var newgrandtotal1=parseInt(totalamount21)+parseInt(totalamount31)+parseInt(newtotal1);
	
	//alert(newgrandtotal4);
	
	document.getElementById('total4').value=newgrandtotal1.toFixed(2);	
	document.getElementById("totalamount").value=newgrandtotal1.toFixed(2);
		document.getElementById("subtotal").value=newgrandtotal1.toFixed(2);
	document.getElementById("subtotal1").value=newgrandtotal1.toFixed(2);

}
function sertotal()
{
	var varquantityser = document.getElementById("quantityser3").value;
	var varserRates = document.getElementById("rate3").value;
	var totalservi = parseFloat(varquantityser) * parseFloat(varserRates);
	document.getElementById("totalservice3").value=totalservi.toFixed(2);
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
<form name="form1" id="frmsales" method="post" action="" onKeyDown="return disableEnterKey(event)">
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
				<input name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A; text-transform:uppercase;" size="18" type="hidden"><?php echo $patientcode; ?></td>
				</tr>       
               
			   <tr>
			    <td width="17%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Visitcode</strong></td>
                <td align="left" valign="middle" class="bodytext3">
				<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" />	<?php echo $visitcode; ?></td>			
			   	  <td width="17%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Account</strong></td>
                <td align="left" valign="top" class="bodytext3">
				<input type="hidden" name="account" id="account" value="<?php echo $patientaccount; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" />		
				<input type="hidden" name="billtypes" id="billtypes" value="<?php echo $billtype; ?>" />
				<input type="hidden" name="payment" id="payment" value="<?php echo $patienttype1; ?>">
				<input type="hidden" name="subtype" id="subtype" value="<?php echo $patientsubtype1; ?>">
				<input type="hidden" name="locationcode" id="locationcode" value="<?php echo $locationcode; ?>">
			<?php echo $patientaccount; ?>	</td>	
 </tr>
				  <tr>
							 <td align="left" valign="middle" class="bodytext3"><strong> Date</strong></td>
				<td class="bodytext3"><input type="hidden" name="billdate" id="billdate" value="<?php echo $dateonly; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<?php echo $dateonly; ?>				</td>	
                 <td align="left" valign="middle" class="bodytext3"><strong>Doc No</strong></td>
				<td class="bodytext3"><input type="hidden" name="billno" id="billno" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>	
                <input type="hidden" name="mortuarydocno" id="mortuarydocno" value="<?php echo $docno; ?>" >
				<?php echo $billnumbercode; ?>							</td>
				  </tr>
                  				
				 		
				 
				  	<tr>
                <td colspan="7" class="bodytext32"><strong>&nbsp;</strong></td>
			 </tr>
            </tbody>
        </table></td>
      </tr>
     
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
          
		        <tr>
				   <td colspan="11" align="left" valign="middle"  bgcolor="#CCCCCC" class="bodytext3"><span class="bodytext32"><strong>Services  </strong></span></td>
		        </tr>
                
                
                <tr>
              <td width="16%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				<td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Service Name </strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Quantity</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Rate </strong></div></td>
					<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount </strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Action </strong></div></td>
                  </tr>
				  		<?php
			$colorloopcount = '';
			$sno = '';
			$totalamount=0;
			
			if($patientcode=='walkin')
			{
				$query69 = "SELECT * FROM mortuaryexternal_services WHERE paymentstatus<>'completed' and  mortuarydocno='$docno' ";
				$exec69 = mysql_query($query69) or die(mysql_error());
				$num69 = mysql_num_rows($exec69);
				while($res69 = mysql_fetch_array($exec69))
				{
				$autonumber = $res69['auto_number'];
				$servicename = $res69['servicesitemname'];
				$rate = $res69['servicesitemrate'];
				$quantity = $res69['quantity'];
				$freestatus = $res69['freestatus'];
				
				$total=$quantity*$rate;
			
			
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
			$totalamount=$totalamount+$pharmitemrate;
			$totalamount=number_format($totalamount,2);
			?>
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $servicename; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $quantity; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $rate; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $total; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><a onClick="return deletevalid()" href="mortuaryamend.php?delete=<?php echo $autonumber; ?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docno=<?php echo $docno; ?>">Delete</a></div></td>
				
				</tr>
			<?php 
			
				}
				}
				else
				{
					$query69 = "SELECT * FROM ipconsultation_services WHERE patientcode='$patientcode' and  patientvisitcode='$visitcode' and process='pending'";
				$exec69 = mysql_query($query69) or die(mysql_error());
				$num69 = mysql_num_rows($exec69);
				while($res69 = mysql_fetch_array($exec69))
				{
				$autonumber = $res69['auto_number'];
				$servicename = $res69['servicesitemname'];
				$rate = $res69['servicesitemrate'];
				$quantity = $res69['qty'];
				$freestatus = $res69['freestatus'];
				$total=$quantity*$rate;
			
			
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
			$totalamount=$totalamount+$pharmitemrate;
			$totalamount=number_format($totalamount,2);
			?>
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $servicename; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $quantity; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $rate; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $total; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><a onClick="return deletevalid()" href="mortuaryamend.php?delete=<?php echo $autonumber; ?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">Delete</a></div></td>
				
				</tr>
			<?php 
			
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
             </tr>
           
               
                                      
				<tr >
				   <td colspan="11" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
				    <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">
                    
              		  <td width="30" class="bodytext3">Services</td>
					   <td width="30" class="bodytext3">Qty</td>
                       <td class="bodytext3">Rate</td>
					   <td width="30" class="bodytext3">Total</td>
                      <td width="30" class="bodytext3">Free</td>
               
                     
                     
					  <tr>
					 <div id="insertrow3">					 </div></tr>
					  <tr>
					  <input type="hidden" name="serialnumber3" id="serialnumber3" value="1">
					  <input type="hidden" name="servicescode" id="servicescode" value="">
					  <input type="hidden" name="baseunit" id="baseunit">
					  <input type="hidden" name="incrqty" id="incrqty">
					  <input type="hidden" name="incrrate" id="incrrate">
					  <input type="hidden" name="slab" id="slab">
					  <input type="hidden" name="pkg2" id="pkg2">
					  <input type="hidden" name="packcharge" id="packcharge">
				   <td width="30"><input name="services[]" type="text" id="services" size="69"></td>
				   <td width="30"><input name="quantityser3[]" type="text" id="quantityser3" onKeyUp="return sertotal()" size="8"></td>
				    <td width="30"><input name="rate3[]" type="text" id="rate3" readonly size="8"></td>
					<td width="30"><input name="totalservice3[]" type="text" id="totalservice3" readonly size="8"></td>
					 <td><select name="servicesfree[]" id="servicesfree">
					 <option value="">Select</option>
					  <option value="No">No</option>
					  <option value="Yes">Yes</option>
					  </select>
					  </td>
					   <td><label>
                       <input type="button" name="Add3" id="Add3" value="Add" onClick="return insertitem4()" class="button" style="border: 1px solid #001E6A">
                       </label></td>
					   </tr>
					    </table></td>
		       </tr>
			   <tr>
				   <td colspan="8" align="right" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Total</strong><input type="text" id="total3" readonly size="7"></td>
				 <input type="hidden" id="total4" readonly size="7">
				   </tr>
				            
          </tbody>
        </table>		</td></tr>
		
		<tr>
		<td>&nbsp;
		</td>
		</tr>
             
               <tr>
	  <td colspan="7" align="right" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
	   <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
	    <input name="Submit2223" type="submit" value="Save" accesskey="b" class="button" style="border: 1px solid #001E6A"/>
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