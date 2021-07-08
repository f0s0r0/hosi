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
	$paynowbillprefix = 'IPD-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from ipprivate_doctor order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='IPD-'.'1';
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
	
	
	$billnumbercode = 'IPD-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}

	$billdate=$_REQUEST['billdate'];
	$frompage = $_REQUEST['frompage'];
	$paymentmode = $_REQUEST['billtype'];
		$patientfullname = $_REQUEST['customername'];
		$patientcode = $_REQUEST['patientcode'];
		$visitcode = $_REQUEST['visitcode'];
		$billtype = $_REQUEST['billtypes'];
		$locationcode=$_REQUEST['locationcode'];
		$age=$_REQUEST['age'];
		$gender=$_REQUEST['gender'];
		$account = $_REQUEST['account'];
		

		
		foreach($_POST['referalnew'] as $key=>$value){	
			//echo '<br>'.
		
		$pairs= $_POST['referalnew'][$key];
		$pairvar= $pairs;
	    $rate= $_POST['rate4new'][$key];
		
		
		$units =  $_POST['unitsnew'][$key];
		$amount = $_POST['amountnew'][$key];
		
		
		
		$description = $_POST['descriptionnew'][$key];
	
			
		if($pairvar!="")
		{
	
		 $query01="insert into ipprivate_doctor(docno,units,amount,patientcode,patientname,patientvisitcode,doctorname,rate,billtype,accountname,consultationdate,paymentstatus,consultationtime,username,ipaddress,remarks,locationcode)values('$billnumbercode','$units','$amount','$patientcode','$patientfullname','$visitcode','$pairvar','$rate','$billtype','$account','$dateonly','pending','$timeonly','$username','$ipaddress','$description','$locationcode')";  
	$referalquery1=mysql_query($query01) or die(mysql_error());
		
		}
}
		if($frompage == 'newborn')
		{
		header("location:newbornactivity.php");
		exit;
		}
		else
		{
		header("location:activeinpatientlist.php");
		exit;
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
$searchlocationcode=$_REQUEST["searchlocation"];
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
 
$query1 = "select * from master_location where locationcode='$searchlocationcode' and status='' order by locationname";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			$res1 = mysql_fetch_array($exec1);
			
						 $locationname = $res1["locationname"];
						 $locationcode = $res1["locationcode"];

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

?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
	$paynowbillprefix = 'IPD-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from ipprivate_doctor order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='IPD-'.'1';
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
	
	
	$billnumbercode = 'IPD-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}?>

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
funcCustomerDropDownSearch7();		
		
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

<?php include ("js/dropdownlist1scriptingipprivatedoctor.php"); ?>
<script type="text/javascript" src="js/autocomplete_ipprivatedoctor1a.js"></script>
<script type="text/javascript" src="js/autosuggestipprivatedoctor1a.js"></script>

<script type="text/javascript" src="js/insertnewitemipdoctor.js"></script>
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
function btnDeleteClick4(delID4)
{
	//alert ("Inside btnDeleteClick.");
	var newtotal;
	//alert(delID4);
	var varDeleteID4= delID4;
	//alert(varDeleteID4);
	
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
    var parent4 = document.getElementById('insertrow4'); // tbody name.
	document.getElementById ('insertrow4').removeChild(child4);
	
	var child4= document.getElementById('idTRaddtxt'+varDeleteID4);  //tr name
    var parent4 = document.getElementById('insertrow4'); // tbody name.
	
	if (child4 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow4').removeChild(child4);
	}

	
}


/*function funcamountcalc()
{

var units = 1;
var rate = document.getElementById("rate4").value;
var docfee = document.getElementById("docfee").value;

if(docfee == '')
{
docfee = 0;
}
var amount = units * rate;

var totalamount = parseFloat(docfee) + parseFloat(amount);

document.getElementById("amount").value = totalamount.toFixed(2);


}
*/
		function IsNumeric(evt)
		 {
		  var charCode = (evt.which) ? evt.which : event.keyCode
		  if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
			 return false;
		  return true;
		 }
		function unitChange()
		{
			if(document.getElementById("units").value=='')
			{
				alert("Enter the units");
				document.getElementById("units").focus();
				calculate();
				return false;
			}
			calculate();
			return true;
		}
		function rateChange()
		{
			if(document.getElementById("rate4").value=='')
			{
				alert("Enter the rate");
				document.getElementById("rate4").focus();
				calculate();
				return false;
			}
			calculate();
			return true;
		}
		function calculate()
		{
			var v1=parseFloat(document.getElementById("units").value);
			var v2=parseFloat(document.getElementById("rate4").value);
			if(!v1){ v1=0;}
			if(!v2) { v2=0; }
			document.getElementById("amount").value=(v1*v2).toFixed(2);
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
<form name="form1" id="frmsales" method="post" action="ipprivatedoctor.php" onKeyDown="return disableEnterKey(event)">
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
        <td width="792"><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
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
				<?php echo $billnumbercode; ?></td>
                				  </tr>
                  <tr>
                  <td align="left" valign="middle" class="bodytext3"><strong>Location</strong></td>
				<td class="bodytext3"><input type="hidden" name="locationcode" id="locationcode" value="<?php echo $searchlocationcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>	
				<?php echo $locationname; ?></td>
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
				   <td colspan="11" align="left" valign="middle"  bgcolor="#CCCCCC" class="bodytext3"><span class="bodytext32"><strong>IP Private Doctor </strong> </span></td>
		        </tr>
				<tr id="reffid">
				    <td colspan="11" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
				    <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="30" class="bodytext3">Doctor</td>
					   <td class="bodytext3"> Quantity</td>
					     <td class="bodytext3"> Rate</td>
                          <td class="bodytext3">Description</td>
						  <td class="bodytext3">Amount</td>
                     </tr>
					  <tr>
					 <div id="insertrow4">					 </div></tr>
					  <tr>
					  <input type="hidden" name="serialnumber4" id="serialnumber4" value="1">
					  <input type="hidden" name="referalcode" id="referalcode" value="">
                 <input type="hidden" name="referalname1hiddentextbox" id="referalname1hiddentextbox" value="">
                 
                      <input type="hidden" name="referalname" id="referalname" value="">
				   <td width="30"><input name="referal[]" type="text" id="referal" size="30"></td>
				<?php /* <td width="30"><select name="docfee[]" id="docfee" onChange="return funcamountcalc()">
				   <option value="">Select</option>
				   <option value="2500">2500</option>
				   <option value="4000">4000</option>
				   </select></td> */ ?>
                   <td>

				    <input name="units[]" type="text" id="units" size="8" value="" onBlur="return unitChange()" onChange="return unitChange()" onKeyPress="return IsNumeric(event);" > </td>
				    <td width="30"><input name="rate4[]" type="text" id="rate4" size="8" value="" onBlur="return rateChange()" onChange="return rateChange()"  onKeyPress="return IsNumeric(event);" ></td>
					 <td width="30"><input name="description[]" type="text" id="description" size="30"></td>
					  <td width="30"><input name="amount[]" type="text" id="amount" readonly size="8"></td>
					   <td><label>
                       <input type="button" name="Add4" id="Add4" value="Add" onClick="return insertitem5()" class="button" style="border: 1px solid #001E6A">
                       </label></td>
					   </tr>
					    </table></td>
		        </tr>
			
		
          </tbody>
        </table>		</td></tr>
		
		<tr>
		<td>&nbsp;		</td>
		</tr>
             
               <tr>
	  <td colspan="7" align="right" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
	   <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
	    <input name="Submit2223" type="submit" value="Save" accesskey="b" class="button" style="border: 1px solid #001E6A"/>		</td>
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