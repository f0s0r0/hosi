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
	$res12locationanum = $res["auto_number"];						
						
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
	


$paynowbillprefix = 'EB-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select billno from billing_external order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
 $billnumber = $res2["billno"]; 
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='EB-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billno"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'EB-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}




		//get locationcode and locationname here for insert
		$locationcodeget=$_REQUEST['locationcodeget'];
		$locationnameget=$_REQUEST['locationnameget'];
		//get locationcode ends here
		$billnumber=$billnumbercode;
		$consultationid=$billnumber;
		$billdate=$_REQUEST['billdate'];
		$referalname=$_REQUEST['referalname'];
		$billingtype = $_REQUEST['billtype'];

		$patientfirstname = $_REQUEST["customername"];
		$patientfirstname = strtoupper($patientfirstname);
		$patientmiddlename = $_REQUEST['customermiddlename'];
		$patientmiddlename = strtoupper($patientmiddlename);
		$patientlastname = $_REQUEST["customerlastname"];
		$patientlastname = strtoupper($patientlastname);
		$patientfullname=$patientfirstname.' '.$patientmiddlename.' '.$patientlastname;
		$age=$_REQUEST['age'];
		$gender=$_REQUEST['gender']; 
		$visitcode=$_REQUEST['visitcode'];
		$patientcode=$_REQUEST['patientcode'];
		$accountname=$_REQUEST['accountname'];
		$timestamp=date('H:i:s');
		$totalamount=$_REQUEST['total2'];

		$billnumbercode='';

		if($billingtype =='PAY NOW')
	{
	$status1='pending';
	}
	else
	{
	$status1='completed';
	}
	
		$quer=mysql_query("select auto_number from master_customer where customercode='$patientcode'");
		$result=mysql_fetch_array($quer);
		$patientauto_number=$result['auto_number'];

	$queryy=mysql_query("select auto_number,department from master_visitentry where visitcode='$visitcode'");
	$res6=mysql_fetch_array($queryy);
	$patientvisit=$res6['auto_number'];
	$department = $_REQUEST["department"];

$curdate=date('Y-m-d');		

	$query21 = "select consultation_id from master_consultation order by auto_number desc limit 0, 1";
	 $exec21 = mysql_query($query21) or die ("Error in Query1".mysql_error());
	 $rowcount21 = mysql_num_rows($exec21);
	if ($rowcount21 == 0)
	{
		$consultationcode = 'CON001';
	}
	else
	{
		$res21 = mysql_fetch_array($exec21);
		 $consultationcode = $res21['consultation_id'];
		 $consultationcode = substr($consultationcode, 3, 7);
		$consultationcode= intval($consultationcode);
		$consultationcode = $consultationcode + 1;
		if (strlen($consultationcode) == 2)
		{
			$consultationcode= '0'.$consultationcode;
		}
		if (strlen($consultationcode) == 1)
		{
			$consultationcode= '00'.$consultationcode;
		}
		$consultationcode = 'CON'.$consultationcode;
		}
	$consultationid1=$consultationcode;

   $query1 = "insert into master_consultationlist (patientcode,visitcode,patientfirstname,patientmiddlename,patientlastname,consultingdoctor,consultationtype,department,consultationdate,consultationtime,consultationfees,referredby,consultationremarks,visitcount,complaints,registrationdate,recordstatus,pulse,consultation,labitems,radiologyitems,serviceitems,refferal,consultationstatus,username,templatedata,date) 
		values('$patientcode','$visitcode','$patientfirstname','$patientmiddlename','$patientlastname','$consultingdoctor','$consultationtype','$department','$updatedatetime','$consultationtime','$consultationfees','$referredby','$consultationremarks','$visitcount','$complaints','$registrationdate','$recordstatus','$pulse','$consultation','$labitems','$radiologyitems','$serviceitems','$refferal','completed','$username','$getdata','$curdate')";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		
		$query88 = "insert into master_consultation(consultation_id,patientcode,patientauto_number,patientname,patientvisitauto_number,patientvisitcode,recordstatus,recorddate,ipaddress,consultingdoctor,billtype,accountname,paymentstatus,sys,dia,pulse,temp,complaint,drugallergy,foodallergy,consultationtime) 
				values('$consultationid1','$patientcode','$patientauto_number','$patientfullname','$patientvisit','$visitcode','completed','$currentdate','$ipaddress','$consultingdoctor','$billingtype','$accountname','$status1','$bpsystolic','$bpdiastolic','$pulse','$celsius','$complaint','$drugallergy','$foodallergy','$timestamp')";
				$exec88 = mysql_query($query88) or die ("Error in Query88".mysql_error());

		$newquery1=mysql_query("update master_visitentry set overallpayment='',doctorconsultation='completed' where visitcode='$visitcode'");
				


$query3 = "select serrefnoprefix from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$labrefnoprefix = $res3['serrefnoprefix'];
$labrefnoprefix1=strlen($labrefnoprefix);
$query2 = "select refno from consultation_services order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$labrefnonumber = $res2["refno"];
$billdigit=strlen($labrefnonumber);
if ($labrefnonumber == '')
{
	$labrefcode =$labrefnoprefix.'1';
	$openingbalance = '0.00';
}
else
{
	$labrefnonumber = $res2["refno"];
	$labrefcode = substr($labrefnonumber,$labrefnoprefix1, $billdigit);
	$labrefcode = intval($labrefcode);
	$labrefcode = $labrefcode + 1;
	$maxanum = $labrefcode;
	$labrefcode = $labrefnoprefix.$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
		foreach($_POST['services'] as $key=>$value)
		{ 
				    //echo '<br>'.$k;
		
		$labname=$_POST['services'][$key];
   	    $labquery=mysql_query("select * from master_services where itemname='$labname' and status <> 'deleted'");
		$execlab=mysql_fetch_array($labquery);
		$labcode=$execlab['itemcode'];
		$labrate=$_POST['rate3'][$key];
	//	$serviceqty=$_POST['qty3'][$key];		
		//$serviceqty=$_POST['serviceqty'][$key];
//		$serviceamount1=$_POST['amount3'][$key];
//		$serviceamount=(int)preg_replace('[,]','',$serviceamount1);
		$labrate=(int)preg_replace('[,]','',$labrate);
		
		if($labname!="")
		{
			$query001 ="insert into consultation_services(consultationid,patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,consultationdate,paymentstatus,process,billnumber,refno,billtype,accountname,serviceqty,amount)values('$consultationid1','$patientcode','$patientfullname','$visitcode','$labcode','$labname','$labrate','$currentdate','$status1','pending','$consultationid','$labrefcode','$billingtype','$accountname','1','$labrate')"; 
		 $labquery1=mysql_query($query001) or die(mysql_error());
		}
        		
		}
		
//		mysql_query("insert into billing_external_request(billno,patientname,patientcode,visitcode,totalamount,billdate,age,gender,username,locationname,locationcode,bankrefno,banktrnno,billtime)values('$consultationid','$patientfullname','$patientcode','$visitcode','$totalamount','$currentdate','$age','$gender','$username','".$locationnameget."','".$locationcodeget."','$billnumbercode','','".date('H:i:s')."')") or die(mysql_error());	



		header("location:services_externalbilling_request.php");
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
function is_connected()
{
    $connected = @fsockopen("www.google.com", 80); 
                                        //website, port  (try 80 or 443)
    if ($connected){
        $is_conn = true; //action when connected
        fclose($connected);
    }else{
        $is_conn = false; //action in connection failure
    }
    return $is_conn;

}
?>
<?php

$paynowbillprefix = 'EB-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select billno from billing_external order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
 $billnumber = $res2["billno"]; 
 $billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='EB-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billno"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'EB-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
?>

<?php

include ("autocompletebuild_services1.php");

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


	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	 //To handle ajax dropdown list.
	
	funcPopupPrintFunctionCall();
	
	
	funcCustomerDropDownSearch3();

		
		funcOnLoadBodyFunctionCall1();
	
}
function funcOnLoadBodyFunctionCall1()
{
    
	
/*	funcLabHideView();
	funcRadHideView();
	funcSerHideView();
	*/
}


function funcLabShowView()
{
if (document.getElementById("customername").value == '') 
     {
	 alert("Please Enter First Name");
	 document.getElementById("customername").focus();
	 return false;
	 }

if (document.getElementById("customerlastname").value == '') 
     {
	 alert("Please Enter Last Name");
	 document.getElementById("customerlastname").focus();
	 return false;
	 }

 
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
if (document.getElementById("customername").value == '') 
     {
	 alert("Please Enter First Name");
	 document.getElementById("customername").focus();
	 return false;
	 }
if (document.getElementById("customerlastname").value == '') 
     {
	 alert("Please Enter Last Name");
	 document.getElementById("customerlastname").focus();
	 return false;
	 }

 
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
if (document.getElementById("customername").value == '') 
     {
	 alert("Please Enter First Name");
	 document.getElementById("customername").focus();
	 return false;
	 }
if (document.getElementById("customerlastname").value == '') 
     {
	 alert("Please Enter Last Name");
	 document.getElementById("customerlastname").focus();
	 return false;
	 }

 
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

<script src="js/jquery-1.11.1.min.js"></script>
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



</script>




<?php include ("js/dropdownlist1scriptingservices1.php"); ?>
<script type="text/javascript" src="js/autocomplete_services1.js"></script>
<script type="text/javascript" src="js/autosuggestservices1.js"></script>
<script type="text/javascript" src="js/autoservicescodesearchexternal.js"></script>
<script type="text/javascript" src="js/insertnewitem444.js"></script>

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
	
//	alert(currenttotal);
	newtotal1= parseInt(currenttotal1)-vrate3;
	
	//alert(newtotal1);
	
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
	
	//alert(newgrandtotal1);
	document.getElementById('total4').value=newgrandtotal1.toFixed(2);	

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

.ui-menu .ui-menu-item{ zoom:2 !important; }

</style>

<script src="js/datetimepicker_css.js"></script>


</head>

<script>
function printConsultationBill()
 {
  if (document.getElementById("nettamount").value != "0.00")
	{
var popWin; 
popWin = window.open("print_external_bill.php?billnumber=<?php echo $billnumbercode; ?>","OriginalWindowA4",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
    }
 }
</script>



<link href="css/autocomplete.css" rel="stylesheet">

<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>

<script>
$(function() {
	
$('#customer').autocomplete({
		
	source:'ajaxexternalcustomernewsearch_service.php', 
	//alert(source);
	minLength:3,
	delay: 0,
	html: true, 
		select: function(event,ui){
			var code = ui.item.id;
			var customercode = ui.item.customercode;
			var accountname = ui.item.accountname;
			var patientfirstname = ui.item.patientfirstname;
			var patientmiddlename = ui.item.patientmiddlename;
			var patientlastname = ui.item.patientlastname;
			var age = ui.item.age;
			var gender = ui.item.gender;
			var billtype = ui.item.billtype;
			var visitcode = ui.item.visitcode;						
			var planfixedamount = ui.item.planfixedamount;
			var planpercentageamount = ui.item.planpercentageamount;
			var paymenttype = ui.item.paymenttype;
			var subtype = ui.item.subtype;						
			$('#customername').val(patientfirstname);
			$('#customermiddlename').val(patientmiddlename);
			$('#customerlastname').val(patientlastname);
			$('#customercode').val(customercode);
			$('#accountname').val(accountname);
			$('#patientcode').val(customercode);
			$('#age').val(age);
			$('#gender').val(gender);			
			$('#billtype').val(billtype);
			$('#visitcode').val(visitcode);	
			$('#planfixedamount').val(planfixedamount);
			$('#planpercentageamount').val(planpercentageamount);			
			$('#paymenttype').val(paymenttype);
			$('#subtype').val(subtype);
			
			
			}
    });
});

function FuncPopup()
{
	window.scrollTo(0,0);
	document.body.style.overflow='auto';
	document.getElementById("imgloader").style.display = "";
	//return false;
}
 
function validcheck()
{
if (document.getElementById("customercode").value == '') 
     {
	 alert("Please Select Patient");
	 document.getElementById("customer").focus();
	 return false;
	 }	

if (document.getElementById("total3").value == '' || parseFloat(document.getElementById("total1").value)<=0) 
     {
	 alert("Please Select Service");
	// document.getElementById("customer").focus();
	 return false;
	 }	


	document.getElementById("Submit222").disabled=true;
	var varUserChoice; 
	varUserChoice = confirm('Are You Sure Want To Save This Entry?'); 
	//alert(fRet); 
	if (varUserChoice == false)
	{
		document.getElementById("Submit222").disabled=false;
		return false;
	}
	else
	{
		FuncPopup();
		document.form1.submit();		
		
	}

}

function collapsethis(getid){
if (document.getElementById("customercode").value == '') 
     {
	 alert("Please Select Patient");
	 document.getElementById("customer").focus();
	 return false;
	 }	
	
$("#"+getid).toggle();

}

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function sertotal()
{
	var varquan = document.getElementById("serviceqty").value;
	var varquantityser =Number(varquan.replace(/[^0-9\.]+/g,""));
	
	var  varser= document.getElementById("rate3").value;
	var varserRates=Number(varser.replace(/[^0-9\.]+/g,""));
	
	var varserbase = 0;
	var varserBaseunit=0;
	
	var varserqty = 0;
	var varserIncrqty=0;
	
	var varinc = 0;
	var varserIncrrate=0;
	
	var varserSlab = 0;
	//alert(varquantityser+varserBaseunit);
	//alert(document.getElementById("slab").value);
	if(varserSlab=='')
	{
		if(parseInt(varquantityser)==0)
		{document.getElementById("serviceamount").value=0}
		if(parseInt(varquantityser)>0)
		{
		var seram=(parseInt(varserRates)*parseInt(varquantityser)).toFixed(2);
		document.getElementById("serviceamount").value=(seram);
		}
		}
	if(parseInt(varserSlab)==1)
	{
		if(parseInt(varquantityser)==0)
		{document.getElementById("serviceamount").value=0}
		if(parseInt(varquantityser)>0)
		{
		if(parseInt(varquantityser) <= parseInt(varserBaseunit))
		{ document.getElementById("serviceamount").value=(varserRates);
		
			
		}
		//parseInt(varquantityser)+parseInt(varserIncrqty);
		if (parseInt(varquantityser) > parseInt(varserBaseunit))
		{
			var result11 = parseInt(varquantityser) - parseInt(varserBaseunit);
			var rem = parseInt(result11)/parseInt(varserIncrqty);
			var rem= Math.ceil(rem);
			//alert(rem);
			var resultfinal =parseInt(rem)*parseInt(varserIncrrate);//alert(resultfinal);
			var seram2=parseInt(varserRates)+parseInt(resultfinal);
			document.getElementById("serviceamount").value=(seram2);
		}
	}
	/*var totalservi = parseFloat(varquantityser) * parseFloat(varserRates);
	document.getElementById("serviceamount").value=totalservi.toFixed(2);*/
}
}

</script>

<style>
.imgloader { background-color:#FFFFFF; }
#imgloader1 {
    position: absolute;
    top: 158px;
    left: 487px;
    width: 28%;
    height: 24%;
}
</style>




<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">

<div align="center" class="imgloader" id="imgloader" style="display:none;">
<div align="center" class="imgloader" id="imgloader1" style="display:;">
<p style="text-align:center;"><strong>Saving <br><br> Please Wait...</strong></p>
<img src="images/ajaxloader.gif">
</div>
</div>

<form name="form1" id="frmsales" method="post" action="services_externalbilling_request.php" onSubmit="return validcheck()">
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
                <td colspan="3" bgcolor="#CCCCCC" class="bodytext32"><strong>Patient Details</strong></td>
	          <td width="19%" align="left" colspan="3" valign="middle"  bgcolor="#CCCCCC" class="bodytext3"> <strong>Location : </strong> <?php  echo $locationname; ?></td>

                <td width="24%" colspan="1" bgcolor="#CCCCCC" class="bodytext32"><strong>&nbsp;</strong>

           <input type="hidden" name="opdate" id="opdate" value="<?= date('Y-m-d') ?>">
            <input type="hidden" name="ipaddress" id="ipaddress" value="<?php echo $ipaddress; ?>">
                <input type="hidden" name="entrytime" id="entrytime" value="<?php echo $timeonly; ?>">   
            
                <input type="hidden" name="locationnameget" id="locationname" value="<?php echo $locationname;?>">
                <input type="hidden" name="locationcodeget" id="locationcode" value="<?php echo $locationcode;?>">
                </td>
                
			 </tr>

             <tr bgcolor="#CCCCCC">
             <td colspan="8" bgcolor="#CCCCCC"></td>
             </tr>
             <tr bgcolor="#011E6A">
                
               
                 <td colspan="8" bgcolor="#CCCCCC" class="bodytext3" id="ajaxlocation"><strong> Search Sequence : First Name | Middle Name | Last Name| Registration No   (*Use "|" symbol to skip sequence)</strong>
 
              </tr>
  
              <tr>
                <td colspan="11" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo 'red'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
               
              </tr>
              
                <tr>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Patient Search </td>
				  <td colspan="6" align="left" valign="middle"  bgcolor="#E0E0E0">
				  <input type="hidden" name="photoavailable" id="photoavailable" size="10" autocomplete="off" value="<?php echo $photoavailable; ?>">
				  <input name="customer" id="customer" size="60" autocomplete="off">
				  <input name="customerhiddentextbox" id="customerhiddentextbox" value="" type="hidden">
				  <input name="customercode" id="customercode" value="" type="hidden">
				  <input name="patientcode" id="patientcode" value = "" type = "hidden">
				  <input name="visitcode" id="visitcode" value = "" type = "hidden">
				  <input name="billtype" id="billtype" value = "" type = "hidden">
				  <input name="planfixedamount" id="planfixedamount" value="" type="hidden">
				  <input name="planpercentageamount" id="planpercentageamount" value="" type="hidden">
				  <input name="paymenttype" id="paymenttype" value="" type="hidden">
				  <input name="subtype" id="subtype" value="" type="hidden">
				  <input name="accountname" id="accountname" value="" type="hidden">
				</td>
				</tr>
		
            <tr>
                        
              <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong></strong> </td>
              <td width="23%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong></strong> </td>
              
            </tr>
                        
        	<tr>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext32"> &nbsp;First Name   </span></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext32"> &nbsp;Middle Name   </span></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext32"> &nbsp;Last Name   </span></td>
				  </tr>
				<tr>
                <td width="17%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext32"> <strong>Patient Name</strong>  </span></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="customername" id="customername" value="" style="text-transform:uppercase;" size="18" readonly>
				<input type="hidden" name="nameofrelative" id="nameofrelative" value="<?php echo $nameofrelative; ?>"size="45"></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
				<input name="customermiddlename" id="customermiddlename" value="" style="text-transform:uppercase;" size="18" readonly></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="customerlastname" id="customerlastname" value="" style="text-transform:uppercase;" size="18" readonly></td>
				</tr>       
               
			   <tr>
			    <td width="17%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Age </strong></td>
                <td align="left" valign="top" class="bodytext3">
				<input type="text" name="age" id="age" value="" size="18"  readonly/>	</td>			
			   	  <td width="17%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Gender</strong></td>
                <td align="left" valign="top" class="bodytext3">
				<input type="text" name="gender" id="gender" value="" size="18"  readonly/>
               </td>	
                </tr>
				  <tr>
							 <td align="left" valign="middle" class="bodytext3"><strong>Bill Date</strong></td>
				<td><input type="text" name="billdate" id="billdate" value="<?php echo $dateonly; ?>" size="18" rsize="20" readonly/>				</td>	
                 <td align="left" valign="middle" class="bodytext3" style="display:none"><strong>Bill No</strong></td>
				<td><input type="hidden" name="billno" id="billno" value="<?php echo $billnumbercode; ?>" size="18" rsize="20" readonly/></td>
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
         		<tr > 
				 <td colspan="11" align="left" valign="middle"  bgcolor="#CCCCCC" class="bodytext3"><span class="bodytext32"><strong>Services <img src="images/plus1.gif" width="13" height="13"> </strong></span></td>
		   </tr>
				<tr id="serid">
				   <td colspan="11" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
				    <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="30" class="bodytext3">Services</td>
                       <td class="bodytext3">Rate</td>
                       <td width="30" class="bodytext3">&nbsp;</td>
                     </tr>
					  <tr>
					 <div id="insertrow3">					 </div></tr>
					  <tr>
					  <input type="hidden" name="serialnumber3" id="serialnumber3" value="1">
					  <input type="hidden" name="servicescode" id="servicescode" value="">

				   <td width="30"><input name="servicesa1" type="text" id="services" size="69"></td>

				    <td width="30">
                    <input name="rate31" type="text" id="rate3" readonly size="8">
                    <input name="serviceqty" type="hidden" id="serviceqty" size="8" autocomplete="off" onKeyPress="return isNumber(event)" onKeyUp="return sertotal()">
                  <input name="serviceamount" type="hidden" id="serviceamount" readonly size="8">
                    </td>
                       <td>
                       <label>
                       <input type="button" name="Add3" id="Add3" value="Add" onClick="return insertitem4()" class="button">
                       </label></td>
					   </tr>
					    </table></td>
		       </tr>
			   <tr>
				   <td colspan="8" align="right" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Total</strong>
                   <input type="hidden"  id="total1" readonly size="7">  <input type="hidden" id="total2" readonly size="7"><input type="text" id="total3" name="total2" readonly size="7"><input type="hidden" id="total4" readonly size="7">
                   
                 </td>
			
				   </tr>
				            
          </tbody>
        </table>		</td>
			<tr>
		 <td colspan="7" class="bodytext31" valign="center"  align="left" >&nbsp;</td>
		</tr>
		
        
                      <tr>
                
                <td colspan="14" align="left" valign="center"  
                bgcolor="#CCCCCC" class="bodytext31"><div align="right"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
                  <input name="delbillst" id="delbillst" type="hidden" value="billedit">
                  <input name="delbillautonumber" id="delbillautonumber" type="hidden" value="<?php echo $delbillautonumber;?>">
                  <input name="delbillnumber" id="delbillnumber" type="hidden" value="<?php echo $delbillnumber;?>">

				  <input name="Submit2223" id="Submit222" type="submit"  value="Save Bill(ALT+S)" accesskey="s" class="button"/>
                </font></font></font></font></font></div></td>
              </tr>
        
 
    </table>

</form>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>

<script>

$(document).ready(function(e) {

	//alert();
	$('#customer').focus();
   // $("#radid").toggle();
});
</script>

</body>
</html>
