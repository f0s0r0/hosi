<?php
session_start();
error_reporting(0);
include ("includes/loginverify.php");
include ("db/db_connect.php");


$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$timeonly = date("H:i:s");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$errmsg = 0;

	$query1111 = "select * from master_employee where username = '$username'";
    $exec1111 = mysql_query($query1111) or die ("Error in Query1111".mysql_error());
	while ($res1111 = mysql_fetch_array($exec1111))
	{
	$username = $res1111["username"];
	$locationnumber = $res1111["location"];
	$query1112 = "select * from master_location where auto_number = '$locationnumber' and status <> 'deleted'";
    $exec1112 = mysql_query($query1112) or die ("Error in Query1112".mysql_error());
	while ($res1112 = mysql_fetch_array($exec1112))
	{
		 $locationname = $res1112["locationname"];		  
		 $locationcode = $res1112["locationcode"];
		 $prefix = $res1112["prefix"];
		 $suffix = $res1112["suffix"];
	}
	}


if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }

$titlestr = 'SALES BILL';
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
	$locationname1 = $_REQUEST['locationnamenew'];	
	$locationcode1 = $_REQUEST['locationcodenew'];	

	$patientcode = $_REQUEST["customercode"];
	$visitcode = $_REQUEST["visitcode"];
	$patientname = $_REQUEST['customername'];
	$patientfirstname = $_REQUEST['patientfirstname'];
	$patientmiddlename=$_REQUEST['patientmiddlename'];
	$patientlastname = $_REQUEST["patientlastname"];
	
	$locationcode = $_REQUEST['locationcode'];
	$locationname = $_REQUEST['locationname'];
	$patientname = $patientfirstname.' '.$patientmiddlename.' '.$patientlastname;
	
		
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$consultationprefix = $res3['consultationprefix'];


	$billnumbercode = '';
	
	//echo $billnumbercode;
	$consultationtype = $_REQUEST["consultationtype"];
	$billingdatetime  = $_REQUEST["ADate"];
	$consultingdoctor = $_REQUEST["consultingdoctor"];
	$accountname = $_REQUEST["account"];
	
	$paymenttype = $_REQUEST["paymenttype"];
	$subtype = $_REQUEST["subtype"];
	$planname = $_REQUEST["planname"];
	$fixedamountbalance = $_REQUEST["fixedamountbalance"];
	$patientbilltype = $_REQUEST['patientbilltype'];
		$billtype = $_REQUEST['billtype'];
	$billamount  = $_REQUEST["billamount"];
	
	$billentryby = $_REQUEST["billentryby"];
	
	$patientpaymentmode = $_REQUEST['patientpaymentmode'];
	$patientbillamount = $_REQUEST['patientbillamount'];
	$department = $_REQUEST['department'];
	
	$consultationdate = $_REQUEST['ADate'];
	
	$consultationfees = $_REQUEST['consultationfees'];
	
	
	$subtotalamount = $_REQUEST['subtotal'];
	$copayfixedamount = $_REQUEST['copayfixedamount'];
	$copaypercentageamount = $_REQUEST['copaypercentageamount'];
	$totalamountbeforediscount = $_REQUEST['totalamountbeforediscount'];
	$discountamount = $_REQUEST['totaldiscountamountonlyapply1'];
	$totalamount = $_REQUEST['totalamount'];
	$consultationcoa = $_REQUEST['consultationcoa'];
	$copaycoa = $_REQUEST['copaycoa'];
	$cashcoa = $_REQUEST['cashcoa'];
	$chequecoa = $_REQUEST['chequecoa'];
	$cardcoa = $_REQUEST['cardcoa'];
	$mpesacoa = $_REQUEST['mpesacoa'];
	$onlinecoa = $_REQUEST['onlinecoa'];
	$discamount = $_REQUEST['discamount'];
	$recordstatus = '';
	$copay = '';
	$remarks = $_REQUEST['remarks'];
	
	 $query2 = "select * from opconsultdiscount where patientcode = '$patientcode' and patientvisitcode = '$visitcode'";
	 $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
     $res2 = mysql_num_rows($exec2);
	if ($res2 == 0)
	{
		$query22 = "insert into opconsultdiscount(billdate,patientcode,patientname,patientvisitcode,consultation,consultationcoa,copay,copaycoa,accountname,billnumber,ipaddress,username,billtype,locationname,locationcode,totalamount,discamount,remarks)values('$consultationdate','$patientcode','$patientname','$visitcode','$patientbillamount','$consultationcoa','$copay','$copaycoa','$accountname','$billnumbercode','$ipaddress','$username','$patientbilltype','$locationname','$locationcode','$totalamount','$discamount','$remarks')";
		$exec22 = mysql_query($query22) or die(mysql_error());
		
		header("location:searchpatientopdiscount.php?st=success");
	}
	else
	{
		header("location:searchpatientopdiscount.php?st=failed");
	}

}
else
{
	$patientcode = '';
	$visitcode = '';
	$patientfirstname = '';
	$patientlastname = '';
	$billnumber = '';
	$consultationtype = '';
	$billingdatetime = '';
	$consultingdoctor = '';
	$accountname = '';
	$accountexpirydate = '';
	$paymenttype = '';
	$subtype = '';
	$planname = '';
	$planexpirydate = '';
	$visitlimit = '';
	$overalllimit = '';
	$paymenttype = '';
	$paymentmode = '';
	$billtype = '';
	$billamount = '';
	$billentryby = '';
	$consultationremarks = '';
	$visittype = '';
}

//to redirect if there is no entry in masters category or item or customer or settings



//To get default tax from autoitemsearch1.php and autoitemsearch2.php - for CST tax override.
if (isset($_REQUEST["defaulttax"])) { $defaulttax = $_REQUEST["defaulttax"]; } else { $defaulttax = ""; }
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
//include ("autocompletebuild_customer1.php");
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
 
 
?>
<?php
$querylab1=mysql_query("select * from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'");
$execlab1=mysql_fetch_array($querylab1);
$patientname=$execlab1['patientfullname'];
$patientfirstname = $execlab1['patientfirstname'];
	$patientmiddlename=$execlab1['patientmiddlename'];
	$patientlastname = $execlab1["patientlastname"];
	$locationcode=$execlab1['locationcode'];
	
$patientaccount=$execlab1['accountname'];
$patientbilltype = $execlab1['billtype'];

$planpercentage = $execlab1["planpercentage"];
//echo $planpercentage;
$planfixedamount = $execlab1["planfixedamount"]; 

$query5 = "select * from master_accountname where auto_number = '$patientaccount'";
$exec5 = mysql_query($query5) or die ("Error in Query2".mysql_error());
$res5 = mysql_fetch_array($exec5);
$accountname = $res5['accountname'];
$plan=$execlab1['planname'];
$type=$execlab1['paymenttype'];
$subtype=$execlab1['subtype'];
$opdate=$execlab1['consultationdate'];
$consultationfees  = $execlab1["consultationfees"];
$billamount = $consultationfees;
$billentryby = strtoupper($username);
$consultationtype = $execlab1['consultationtype'];
$query26 = "select * from master_consultationtype where auto_number = '$consultationtype'";
$exec26 = mysql_query($query26) or die ("Error in Query2".mysql_error());
$res26 = mysql_fetch_array($exec26);
$consultationtypes = $res26['consultationtype'];


$consultingdoctor= $execlab1['consultingdoctor'];
//echo $consultingdoctoranum;



$departmentanum = $execlab1['department'];
//echo $departmentanum;

$query5 = "select * from master_department where auto_number = '$departmentanum'";
$exec5 = mysql_query($query5) or die ("Error in Query2".mysql_error());
$res5 = mysql_fetch_array($exec5);
$department = $res5['department'];

//echo $department;

$query45="select * from master_planname where auto_number='$plan'";
$exec45=mysql_query($query45) or die(mysql_error());
$res45=mysql_fetch_array($exec45);
$planname=$res45['planname'];



$query46="select * from master_paymenttype where auto_number='$type'";
$exec46=mysql_query($query46) or die(mysql_error());
$res46=mysql_fetch_array($exec46);
$paymenttype=$res46['paymenttype'];

$query47="select * from master_subtype where auto_number='$subtype'";
$exec47=mysql_query($query47) or die(mysql_error());
$res47=mysql_fetch_array($exec47);
$subtype=$res47['subtype'];

$query76 = "select * from master_financialintegration where field='consultationfee'";
$exec76 = mysql_query($query76) or die(mysql_error());
$res76 = mysql_fetch_array($exec76);
$consultationcoa = $res76['code'];

$query761 = "select * from master_financialintegration where field='copay'";
$exec761 = mysql_query($query761) or die(mysql_error());
$res761 = mysql_fetch_array($exec761);

$copaycoa = $res761['code'];

$query765 = "select * from master_financialintegration where field='cashconsultation'";
$exec765 = mysql_query($query765) or die(mysql_error());
$res765= mysql_fetch_array($exec765);

$cashcoa = $res765['code'];


$query766 = "select * from master_financialintegration where field='chequeconsultation'";
$exec766 = mysql_query($query766) or die(mysql_error());
$res766 = mysql_fetch_array($exec766);

$chequecoa = $res766['code'];


$query767 = "select * from master_financialintegration where field='mpesaconsultation'";
$exec767 = mysql_query($query767) or die(mysql_error());
$res767 = mysql_fetch_array($exec767);

$mpesacoa = $res767['code'];

$query768 = "select * from master_financialintegration where field='cardconsultation'";
$exec768 = mysql_query($query768) or die(mysql_error());
$res768 = mysql_fetch_array($exec768);

$cardcoa = $res768['code'];

$query769 = "select * from master_financialintegration where field='onlineconsultation'";
$exec769 = mysql_query($query769) or die(mysql_error());
$res769 = mysql_fetch_array($exec769);

$onlinecoa = $res769['code'];


?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$consultationprefix = $res3['consultationprefix'];

$query2 = "select * from master_billing order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["billnumber"];
if ($billnumber == '')
{
	$billnumbercode =$consultationprefix.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billnumber"];
	$billnumbercode = substr($billnumber, 3, 8);
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = $consultationprefix.$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
?>
<?php 
if($patientbilltype == 'PAY NOW')
{
	$billamountpatient = $billamount;
	$billamountpatient = number_format($billamountpatient,2,'.','');
}


if($planfixedamount != 0)
{
	if($planfixedamount >= $billamount)
	{
		 $billamountpatient =  $billamount ;
		
	}
	else 
	{
		 $billamountpatient = $planfixedamount;
		 
	}
}

if($planpercentage != 0)
{
	//echo "hi";
	$percentageamount = $planpercentage /100;
	$percentagebalanceamount = $billamount * $percentageamount ;
	$billamountpatient = $percentagebalanceamount;
}

?>

<script>
function printConsultationBill()
 {}
</script>

<script language="javascript">

function funcOnLoadBodyFunctionCall()
{

	funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	funcCustomerDropDownSearch1(); //To handle ajax dropdown list.
	
	funcPopupPrintFunctionCall();
	
}

function funcPopupPrintFunctionCall()
{}

//Print() is at bottom of this page.

</script>
<script type="text/javascript">

function quickprintbill2sales()
{
}

function loadprintpage1(varPaperSizeCatch)
{}

function cashentryonfocus1()
{}

function funcDefaultTax1() //Function to CST Taxes if required.
{}

function balancecalc()
{
	var Disc = document.getElementById("discamount").value;
	var stot = document.getElementById("subtotal").value;
	if(Disc == '') { Disc = '0.00'; }
	if(parseFloat(Disc) > parseFloat(stot))
	{
		alert("Discount amount greater than Bill amount");
		document.getElementById("totalamount").value = stot;
		document.getElementById("discamount").value = '0.00';
		return false;
	}
	var tot = parseFloat(stot) - parseFloat(Disc); 
	var tot = parseFloat(tot);
	document.getElementById("totalamount").value = tot.toFixed(2);
}

function Process1()
{
	if(document.getElementById("discamount").value == '')
	{
		alert("Enter Disc Amount");
		document.getElementById("discamount").focus();
		return false;
	}
	if(document.getElementById("remarks").value == '')
	{
		alert("Enter Remarks");
		document.getElementById("remarks").focus();
		return false;
	}
}
</script>
<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext4 {	FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
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

</style>

<script src="js/datetimepicker_css.js"></script>

</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="frmsales" id="frmsales" method="post" action="consultationopdiscount.php" onKeyDown="return disableEnterKey(event);" onSubmit="return Process1()">
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
			<tr>
			<td colspan="5" align="left" valign="middle"  bgcolor="#CCCCCC" class="bodytext4"><strong>Patient Details</strong>			</td>
			</tr>
             <?php $query="select locationcode,locationname from master_location where locationcode = '".$locationcode."' and status = ''";
			 
			 $exec1print = mysql_query($query) or die ("Error in Query1print.".mysql_error());
				$res1print = mysql_fetch_array($exec1print);
				$locationname = $res1print["locationname"];
	?>
                <tr><td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Location </td>
              <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"> <?php  echo $locationname; ?></td>
			  
                </tr>
              <tr>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Patient  * </strong></td>
                <td align="left" valign="middle" class="bodytext3">
				<input name="customername" id="customer" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly type="hidden"/><?php echo $patientname; ?>
                <input type="hidden" name="patientfirstname" value="<?php echo $patientfirstname; ?>">
				<input type="hidden" name="patientmiddlename" value="<?php echo $patientmiddlename; ?>">
				<input type="hidden" name="patientlastname" value="<?php echo $patientlastname; ?>">				  </td>
                    
                 <input type="hidden" name="consultationcoa" value="<?php echo $consultationcoa; ?>">
				<input type="hidden" name="copaycoa" value="<?php echo $copaycoa; ?>">
				<input type="hidden" name="cashcoa" value="<?php echo $cashcoa; ?>">
				<input type="hidden" name="chequecoa" value="<?php echo $chequecoa; ?>">
				<input type="hidden" name="mpesacoa" value="<?php echo $mpesacoa; ?>">
				<input type="hidden" name="cardcoa" value="<?php echo $cardcoa; ?>">
				<input type="hidden" name="onlinecoa" value="<?php echo $onlinecoa; ?>">
                <input type="hidden" name="locationcode" value="<?php echo $locationcode; ?>">
                <input type="hidden" name="locationname" value="<?php  echo $locationname; ?>">
		
                  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Type</strong></td>
                <td class="bodytext3" align="left" valign="middle" >
				<input name="paymenttype" id="paymenttype" type="hidden" value="<?php echo $paymenttype; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $paymenttype; ?>				</td>
              </tr>
			 
		
			  <tr>
			   
                 <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Patient code </strong></td>
                <td align="left" valign="middle" class="bodytext3">
				<input name="customercode" id="customercode" type="hidden" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $patientcode; ?>
				
				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>
               <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Sub Type</strong></td>
                <td align="left" valign="top" class="bodytext3">
				<input name="subtype" id="subtype" type="hidden" value="<?php echo $subtype; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $subtype; ?>				</td>
			    </tr>
			   <tr>
			     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Visit Code</strong></td>
                <td align="left" valign="middle" class="bodytext3">
				<input name="visitcode" id="visitcode" type="hidden" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $visitcode; ?>				</td>
					    <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Account</strong></td>
                <td class="bodytext3" align="left" valign="middle" >
				<input name="account" id="account" type="hidden" value="<?php echo $accountname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $accountname; ?></td>
				  </tr>
				  <tr>
				     <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>OP Date</strong></td>
                <td align="left" valign="middle" class="bodytext3">
				<input name="opdate" id="opdate" type="hidden" value="<?php echo $opdate; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $opdate; ?>				</td>
			
				    
     	<td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Plan Name</strong></td>
                <td class="bodytext3" align="left" valign="top" >
				<input name="planname" id="planname" type="hidden" value="<?php echo $planname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $planname; ?>				</td>
				  </tr>
				  <tr>
				    <td class="bodytext3"><strong>    Bill No. </strong></td>
	 <td class="bodytext3"> <input name="billnumber" id="billnumber" value="<?php echo $billnumbercode; ?>" <?php echo $billnumbertextboxvalidation; ?> style="border: 1px solid #001E6A; text-align:left" size="18" readonly type="hidden"/><?php echo $billnumbercode; ?></td>
                  <td class="bodytext3"><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5"> <strong>Bill Date </strong></td>
				
                  <input name="billnumberpostfix" id="billnumberpostfix" value="<?php echo $billnumberpostfix; ?>" style="border: 1px solid #001E6A"  size="5" type="hidden" />
             
				     <td class="bodytext3">
               
                  <input name="ADate" id="ADate" style="border: 1px solid #001E6A" value="<?php echo $dateonly; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                  <img src="images2/cal.gif" style="cursor:pointer"/>				</td>
				  </tr>
            </tbody>
        </table></td>
      </tr>
      <tr>
			<td align="left" valign="middle"  bgcolor="#CCCCCC" class="bodytext4"><strong>Transaction Details</strong>
			</td>
			</tr>
			
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
            <tr>
              <td width="16%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Dept</strong></div></td>
				<td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Consulting Doctor </strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Consultation Type</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Consultation Fees </strong></div></td>
					<td width="13%"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Disc Amount </strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong></strong></div></td>
              
                  </tr>
	
			  <tr bgcolor="#D3EEB7">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $department; ?></div></td>
			 <input type="hidden" name="department" value="<?php echo $department; ?>">
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultingdoctor; ?></div></td>
				<input type="hidden" name="consultingdoctor" value="<?php echo $consultingdoctor; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationtypes; ?></div></td>
			 <input type="hidden" name="consultationtype" value="<?php echo $consultationtypes; ?>">
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationfees; ?></div></td>
				<input type="hidden" name="consultationfees" value="<?php echo $consultationfees; ?>">
				<input type="hidden" name="patientbilltype" value="<?php echo $patientbilltype; ?>">
				<input type="hidden" name="billamount" value="<?php echo $consultationfees; ?>">
				<input type="hidden" name="patientbillamount" value="<?php echo $billamountpatient; ?>">
				 <input type="hidden" name="billentryby" id="billentryby" value="<?php echo $billentryby; ?>" readonly style="border: 1px solid #001E6A;">
				 <td class="bodytext31" valign="center"  align="left"><div align="center">
				 <input type="text" name="discamount" id="discamount" size="8" onKeyUp="return balancecalc()" />
				 <input type="hidden" name="totalamount" id="totalamount" size="8" />
				 <input type="hidden" name="subtotal" id="subtotal" value="<?php echo $consultationfees; ?>">
				 </div></td>
				 <input type="hidden" name="copayfixedamount" value="<?php echo $planfixedamount; ?>">
				  <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
				  <input type="hidden" name="copaypercentageamount" value="<?php echo $planpercentage; ?>">
				   <input name="totalamountbeforediscount" type="hidden" id="totalamountbeforediscount" value="<?php echo $billamountpatient; ?>" readonly style="border: 1px solid #001E6A; background-color:#E0E0E0; text-align:right" size="10">
				</tr>
			
			  <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="center" 
                bgcolor="#cccccc"><strong>Remarks</strong></td>
              <td colspan="3" class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc"><textarea cols="40" rows="4" name="remarks" id="remarks"></textarea></td>            
             <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
			 </tr>
           
          </tbody>
        </table>		</td>
      </tr>
     
      <tr>
        <td>
		<table width="99%" border="0" 
            align="left" cellpadding="2" cellspacing="0" 
            bordercolor="#666666" bgcolor="" id="AutoNumber3" style="BORDER-COLLAPSE: collapse">
            <tbody id="foo">
              <tr>
                <td colspan="14" align="left" valign="center"  
                bgcolor="#CCCCCC" class="bodytext31"><div align="right"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
                  <input name="delbillst" id="delbillst" type="hidden" value="billedit">
                  <input name="delbillautonumber" id="delbillautonumber" type="hidden" value="<?php echo $delbillautonumber;?>">
                  <input name="delbillnumber" id="delbillnumber" type="hidden" value="<?php echo $delbillnumber;?>">

				  <input name="Submit2223" type="submit" value="Save Discount" accesskey="s" class="button"/>
                </font></font></font></font></font></div></td>
              </tr>
			  
            </tbody>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr>
              <td width="54%" align="left" valign="top" ><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
               <strong>User Name</strong><input type="text" name="username" value="<?php echo $username; ?>" size="5">
			    <input name="Button1" type="hidden" class="button" id="Button1" accesskey="c" style="border: 1px solid #001E6A" onClick="return funcRedirectWindow1()" value="Clear All"/>
                <input type="hidden" name="customersearch2" onClick="javascript:customersearch1('sales')" value="Customer Alt+M" accesskey="m" style="border: 1px solid #001E6A">
                <span class="bodytext31">
                <input type="hidden" name="itemsearch22" onClick="javascript:itemsearch1('sales')" style="border: 1px solid #001E6A">
                <span class="bodytext3">
				<?php
				if (isset($_REQUEST["src"])) { $src = $_REQUEST["src"]; } else { $src = ""; }
				//$src = $_REQUEST["src"];
				if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
				//$st = $_REQUEST["st"];
				if (isset($_REQUEST["billnumber"])) { $previousbillnumber = $_REQUEST["billnumber"]; } else { $previousbillnumber = ""; }
				//$previousbillnumber = $_REQUEST["billnumber"];
				
				if ($src == 'frm1submit1' && $st == 'success')
				{
				?>
				<!--
                <input onClick="return loadprintpage1('<?php echo $previousbillnumber; ?>')" value="A4 View Bill <?php echo $previousbillnumber; ?>" name="Button12" type="button" class="button" id="Button12" style="border: 1px solid #001E6A"/>
				-->
				<?php
				}
				?>
                </span></span></font></font></font></font></font></td>
            
			
            </tr>
          </tbody>
        </table></td>
      </tr>
    </table>
  </table>
</form>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>