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
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
	$paynowbillprefix = 'VS-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from dc_vitalio order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='VS-'.'1';
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
	
	
	$billnumbercode = 'VS-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}

	    $billdate=$_REQUEST['billdate'];
	
	    $paymentmode = $_REQUEST['billtype'];
		$patientfullname = $_REQUEST['customername'];
		$patientcode = $_REQUEST['patientcode'];
		$visitcode = $_REQUEST['visitcode'];
		$billtype = $_REQUEST['billtypes'];
		
		$account = $_REQUEST['account'];
		$vitalipdate =  $_REQUEST['vitalipdate'];
		$vitaliptime =  $_REQUEST['vitaliptime'];
		$iodate = $_REQUEST['iodate'];
		$iotime = $_REQUEST['iotime'];
		$systolic = $_REQUEST['bpsystolic'];
		$diastolic = $_REQUEST['bpdiastolic'];
		$respiration = $_REQUEST['respiration'];
		$pulse = $_REQUEST['pulse'];
		$celsius = $_REQUEST['celsius'];
		$fahrenheit = $_REQUEST['fahrenheit'];
		$iv = $_REQUEST['ivquantity'];
		$fluids = $_REQUEST['fluidsquantity'];
		$vomitus = $_REQUEST['vomitusquantity'];
		$urine = $_REQUEST['urinequantity'];
		$secretion = $_REQUEST['secretionquantity'];
		$bloodtransfusion = $_REQUEST['bloodquantity'];
	
			
	  	
		$referalquery1=mysql_query("insert into dc_vitalio(docno,patientcode,patientname,visitcode,billtype,accountname,recorddate,recordtime,username,ipaddress,systolic,diastolic,pulse,resp,tempc,tempf,iv,fluids,vomitus,urine,secretion,vitalipdate,vitaliptime,iodate,iotime,bloodtransfusion)values('$billnumbercode','$patientcode','$patientfullname','$visitcode','$billtype','$account','$dateonly','$timeonly','$username','$ipaddress','$systolic','$diastolic','$pulse','$respiration','$celsius','$fahrenheit','$iv','$fluids','$vomitus','$urine','$secretion','$vitalipdate','$vitaliptime','$iodate','$iotime','$bloodtransfusion')") or die(mysql_error());
		
		header("location:daycarelist.php");
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
$docnumber=$_REQUEST["docnumber"];
}


if (isset($_REQUEST["errorcode"])) { $errorcode = $_REQUEST["errorcode"]; } else { $errorcode = ""; }
//$patientcode = 'MSS00000009';
if ($errorcode == 'errorcode1failed')
{
	$errmsg = 'NHIF is already processed.';	
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


$query66 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$exec66 = mysql_query($query66) or die(mysql_error());
$res66 = mysql_fetch_array($exec66);
$ipdate = $res66['consultationdate'];
$nhifrebate = $res66['nhifrebate'];

$datediff = abs(strtotime($currentdate) - strtotime($ipdate));

$years5 = floor($datediff / (365*60*60*24));
$months5 = floor(($datediff - $years5 * 365*60*60*24) / (30*60*60*24));
$days5 = floor(($datediff - $years5 * 365*60*60*24 - $months5*30*60*60*24)/ (60*60*24));
if($days5 == '0')
{
$days5 = 1;
}
$nhifrebateamount = $nhifrebate * $days5;

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
	$paynowbillprefix = 'VS-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from dc_vitalio order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='VS-'.'1';
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
	
	
	$billnumbercode = 'VS-' .$maxanum;
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


//Print() is at bottom of this page.

</script>



<script language="javascript">

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
function validcheck()
{
if(document.form1.nhifclaim.value == '0.00')
{
alert("NHIF not applicable for this patient");
document.getElementById("nhifclaim").focus();
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


function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        alert("Please enter a whole number");
		return false;
    }
    return true;
}

function MinimumBP()
{
	if(document.form1.bpsystolic.value > 120 && document.form1.bpsystolic.value !="")
	{
		document.form1.bpsystolic.style.background="#FFFF66";
	}
	else
	{
		document.form1.bpsystolic.style.background="#FFFFFF";
	}
}
function MaximumBP()
{
	if(document.form1.bpdiastolic.value < 80)
	{
		document.form1.bpdiastolic.style.background="#FFFF66";
	}
	else
	{
		document.form1.bpdiastolic.style.background="#FFFFFF";
	}
}

function funcamountcalc()
{

if(document.getElementById("units").value != '')
{
var units = document.getElementById("units").value;
var rate = document.getElementById("rate4").value;
var amount = units * rate;

document.getElementById("amount").value = amount.toFixed(2);
}
}

function FunctionTemperature()
{
	if(document.form1.celsius.value != "" )
	{
		var fahrenheit = document.getElementById("fahrenheit").value;
		var celsius = document.getElementById("celsius").value;
		var fahrenheit = Math.round(1.8 * celsius + 32);
		document.getElementById("fahrenheit").value = fahrenheit;
	}
	
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
.bal1
{
border-style:none;
background:none;
text-align:center;
font-weight:bold;
}
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
<body>
<form name="form1" id="frmsales" method="post" action="dcvitalio.php" onKeyDown="return disableEnterKey(event)" onSubmit="return validcheck()">
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
                <td colspan="8" bgcolor="#CCCCCC" class="bodytext32"><strong>Patient Details</strong></td>
			 </tr>
			 <tr>
                <td colspan="12" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo 'red'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
              </tr>
		<tr>
                <td colspan="8" class="bodytext32"><strong>&nbsp;</strong></td>
			 </tr>
			
				<tr>
                <td width="17%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext32"> <strong>Patient Name</strong>  </span></td>
                <td width="26%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
				<input name="customername" id="customername" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A; text-transform:uppercase;" size="18" type="hidden"><?php echo $patientname; ?>
				<input type="hidden" name="nameofrelative" id="nameofrelative" value="<?php echo $nameofrelative; ?>" style="border: 1px solid #001E6A;" size="45"></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
				<strong>Patientcode</strong></td>
                <td width="27%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
				<input name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A; text-transform:uppercase;" size="18" type="hidden"><?php echo $patientcode; ?><a target="_blank" href="addiptriage.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docnumber=<?php echo $billnumber; ?>"></a></td>
				<td width="13%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"></td>
				</tr>       
               
			   <tr>
			    <td width="17%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Visitcode</strong></td>
                <td align="left" valign="middle" class="bodytext3">
				<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" />	<?php echo $visitcode; ?></td>			
			   	  <td width="17%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Account</strong></td>
                <td colspan="2" align="left" valign="top" class="bodytext3">
				<input type="hidden" name="account" id="account" value="<?php echo $patientaccount1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" />		
				<input type="hidden" name="billtypes" id="billtypes" value="<?php echo $billtype; ?>" />
			<?php echo $patientaccount1; ?>	</td>	
 </tr>
				  <tr>
							 <td align="left" valign="middle" class="bodytext3"><strong> Date</strong></td>
				<td class="bodytext3"><input type="hidden" name="billdate" id="billdate" value="<?php echo $dateonly; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<?php echo $dateonly; ?>				</td>	
                 <td align="left" valign="middle" class="bodytext3"><strong>Doc No</strong></td>
				<td colspan="2" class="bodytext3"><input type="hidden" name="billno" id="billno" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>	
				<?php echo $billnumbercode; ?>							</td>
				  </tr>
                  				
				 		
				 
				  	<tr>
                <td colspan="8" class="bodytext32"><strong>&nbsp;</strong></td>
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
				   <td width="21%" align="right" valign="middle"  bgcolor="#CCCCCC" class="bodytext3"><span class="bodytext32"><strong> Vital Inputs </strong> </span></td>
		           <td width="16%" align="left" valign="middle"  bgcolor="#CCCCCC" class="bodytext3">&nbsp;</td>
		           <td width="12%" align="left" valign="middle" class="bodytext3">&nbsp;</td>
		           <td width="21%" align="right" valign="middle" bgcolor="#CCCCCC" class="bodytext3"><span class="bodytext32"><strong>Input / Output	</strong></span>	</td>
		           <td align="left" valign="middle" bgcolor="#CCCCCC" class="bodytext3">&nbsp;</td>
		           <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
		          </tr>
				  <tr>
				 <td align="left" valign="middle" class="bodytext3">Date&nbsp;&nbsp;&nbsp;
				   <input type="text" name="vitalipdate" id="vitalipdate" value="<?php echo $dateonly; ?>" size="7" readonly="readonly">
                    <strong><span class="bodytext312">  <img src="images2/cal.gif" onClick="javascript:NewCssCal('vitalipdate')" style="cursor:pointer"/> </span></strong></td>
				  
				 <td align="left" valign="middle" class="bodytext3">Time&nbsp;&nbsp;&nbsp;
				   <input type="text" name="vitaliptime" id="vitaliptime" value="<?php echo $timeonly; ?>" size="7">				  </td>
				  <td align="left" valign="middle" class="bodytext3"><p><a target="_blank" href="dcviewvitalinputs.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docnumber=<?php echo $billnumber; ?>"><strong>View Vitals </strong></a></p>
				    <p><a target="_blank" href="addiptriage.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docnumber=<?php echo $billnumber; ?>"></a></p></td>
				  <td align="left" valign="middle" class="bodytext3">		Date	&nbsp;&nbsp;&nbsp;		  
				    <input type="text" name="iodate" id="iodate" value="<?php echo $dateonly; ?>" size="7" readonly="readonly">
					<strong><span class="bodytext312">  <img src="images2/cal.gif" onClick="javascript:NewCssCal('iodate')" style="cursor:pointer"/> </span></strong></td>
				    <td width="17%" align="left" valign="middle" class="bodytext3">Time&nbsp;&nbsp;&nbsp;
			        <input type="text" name="iotime" id="iotime" value="<?php echo $timeonly; ?>" size="7"></td>
				    <td width="13%" align="left" valign="middle" class="bodytext3"><p><a target="_blank" href="dcviewvitalinputoutput.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docnumber=<?php echo $billnumber; ?>"><strong>View I/O </strong></a></p>
			        <p><a target="_blank" href="viewvitalinputoutput.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docnumber=<?php echo $billnumber; ?>"></a></p></td>
				  </tr>
				  <tr>
				 <td colspan="6" align="center" valign="middle" class="bodytext3">&nbsp;</td>
				</tr>
				<tr>
				 <td align="center" valign="middle" class="bodytext3">Systolic</td>
				  <td align="left" valign="middle" class="bodytext3">
				   <input name="bpsystolic" type="text" id="bpsystolic" onKeyUp="return MinimumBP()" onKeyPress="return isNumber(event)" size="8">            </td>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td align="center" valign="middle" class="bodytext3">IV</td>
				  <td colspan="2" align="left" valign="middle" class="bodytext3"><input type="text" name="ivquantity" id="ivquantity" value="" size="8"></td>
				</tr>
				<tr>
				 <td align="center" valign="middle" class="bodytext3">Diastolic</td>
				  <td align="left" valign="middle" class="bodytext3">
				 <input name="bpdiastolic" type="text" id="bpdiastolic" onKeyUp="return MaximumBP()" onKeyPress="return isNumber(event)" size="8">      </td>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td align="center" valign="middle" class="bodytext3">Fluids</td>
				  <td colspan="2" align="left" valign="middle" class="bodytext3"><input type="text" name="fluidsquantity" id="fluidsquantity" value="" size="8"></td>
				</tr>
				<tr>
				 <td align="center" valign="middle" class="bodytext3">Resp</td>
				  <td align="left" valign="middle" class="bodytext3"><input name="respiration" type="text" id="respiration" onKeyPress="return isNumber(event)" size="8"></td>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td align="center" valign="middle" class="bodytext3">Vomitus</td>
				  <td colspan="2" align="left" valign="middle" class="bodytext3"><input type="text" name="vomitusquantity" id="vomitusquantity" size="8" value="" style="text-align:left"></td>
				</tr>
				<tr>
				 <td align="center" valign="middle" class="bodytext3">Pulse</td>
				  <td align="left" valign="middle" class="bodytext3"><input name="pulse" type="text" id="pulse" onKeyPress="return isNumber(event)" size="8"></td>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td align="center" valign="middle" class="bodytext3">Urine</td>
				  <td colspan="2" align="left" valign="middle" class="bodytext3"><input type="text" name="urinequantity" id="urinequantity" size="8" value="" style="text-align:left"></td>
				</tr>
				<tr>
				 <td align="center" valign="middle" class="bodytext3">Temp (C)</td>
				  <td align="left" valign="middle" class="bodytext3"> <input name="celsius" type="text" id="celsius" onKeyUp="return FunctionTemperature()" onKeyPress="return iisNumber(event)" size="8"></td>
				  <td align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td align="center" valign="middle" class="bodytext3">Secretion</td>
				  <td align="left" valign="middle" class="bodytext3"><input type="text" name="secretionquantity" id="secretionquantity" size="8" value="" style="text-align:left"></td>
				  <td align="left" valign="middle" class="bodytext3"><a target="_blank" href="viewvitalinputoutput.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docnumber=<?php echo $billnumber; ?>"></a></td>
				</tr>
				<tr>
				 <td align="center" valign="middle" class="bodytext3">Temp (F)</td>
				  <td align="left" valign="middle" class="bodytext3"><input name="fahrenheit" id="fahrenheit"  size="8"></td>
				  <td align="left" valign="middle" class="bodytext3"><a target="_blank" href="viewvitalinputs.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docnumber=<?php echo $billnumber; ?>"></a></td>
				  <td align="center" valign="middle" class="bodytext3">Blood transfusion</td>
				  <td colspan="2" align="left" valign="middle" class="bodytext3"><input type="text" name="bloodquantity" id="bloodquantity" size="8" value="" style="text-align:left"></td>
				</tr>
				
			<tr>
		<td>&nbsp;		</td>
		</tr>
		       </tbody>
        </table>		</td></tr>
		
		<tr>
		 <td width="1%" class="bodytext31" align="left">User Name: &nbsp;&nbsp;<input type="hidden" name="username" id="username" value="" class="bal1"><strong><?php echo strtoupper($username); ?></strong></td>		
		</tr>
             
               <tr>
	  <td colspan="6" align="right" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
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