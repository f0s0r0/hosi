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
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$currentdate = date("Y-m-d");
$updatedate=date("Y-m-d");

$transactiondatefrom = date('Y-m-d', strtotime('-4 day'));
$transactiondateto = date('Y-m-d');

$titlestr = 'SALES BILL';
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
	$paynowbillprefix = 'VS-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from ip_vitalio order by auto_number desc limit 0, 1";
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
		
	
			
	  	
		$referalquery1=mysql_query("insert into ip_vitalio(docno,patientcode,patientname,visitcode,billtype,accountname,recorddate,recordtime,username,ipaddress,systolic,diastolic,pulse,resp,tempc,tempf,iv,fluids,vomitus,urine,secretion,vitalipdate,vitaliptime,iodate,iotime)values('$billnumbercode','$patientcode','$patientfullname','$visitcode','$billtype','$account','$dateonly','$timeonly','$username','$ipaddress','$systolic','$diastolic','$pulse','$respiration','$celsius','$fahrenheit','$iv','$fluids','$vomitus','$urine','$secretion','$vitalipdate','$vitaliptime','$iodate','$iotime')") or die(mysql_error());
		
		header("location:inpatientactivity.php");
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
$Querylab=mysql_query("select * from ip_bedallocation where patientcode='$patientcode'");
$execlab=mysql_fetch_array($Querylab);
$patientname = $execlab['patientname'];
$bedno = $execlab['bed'];
$accountname = $execlab['accountname'];
$patienttype=$execlab['maintype'];

$query10 = "select * from master_customer where customercode='$patientcode' ";
$exec10 = mysql_query($query10) or die(mysql_error());
$res10 = mysql_fetch_array($exec10);
$res10age = $res10['age'];
$res10gender = $res10['gender'];
		
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

$query2 = "select * from ip_vitalio order by auto_number desc limit 0, 1";
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


<style type="text/css">
.bodytext313 {	FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
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
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
</style>

<script src="js/datetimepicker_css.js"></script>

</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body>
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
    <td colspan="11">&nbsp;</td>
  </tr>
  <tr>
    <td width="0%">&nbsp;</td>
    <td width="0%" valign="top">&nbsp;</td>
    <td colspan="2" valign="top">



<table width="100%" border="0" align="left" cellpadding="2" cellspacing="0">
	<tr>
		<td colspan="13" class="bodytext32"><strong>&nbsp;</strong></td>
	</tr>
	
	<tr>
		<td width="13%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext32"> <strong>Patient Name</strong>  </span></td>
		
		<td width="14%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Visitcode</strong></td>
		<td width="7%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Age</strong></td>
		<td width="8%" align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">Gender</td>
		<td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
		<strong>Patientcode</strong></td>
		<td width="7%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Bed No. </strong></td>
		<td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="style1">Account</span></td>
		</tr>       
	
	<tr>
		<td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><?php echo $patientname; ?></td>
		
		<td align="left" valign="middle" class="bodytext3"><?php echo $visitcode; ?></td>
		<td align="left" valign="middle" class="bodytext3"><?php echo $res10age; ?></td>
		<td align="left" valign="middle" class="bodytext3"><?php echo $res10gender; ?></td>
		<td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><?php echo $patientcode; ?></td>
		<td align="left" valign="top" class="bodytext3"><?php echo $bedno; ?></td>
		<td colspan="2" align="left" valign="top" class="bodytext3"><?php echo $accountname; ?></td>
		</tr>
	<tr>
		<td width="13%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
		<td colspan="3" align="left" valign="middle" class="bodytext3">&nbsp;</td>
		<td colspan="2" align="left" valign="middle" class="bodytext3">&nbsp;</td>			
		<td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
		</tr>
	
	<tr>
		<td colspan="13" class="bodytext31"><strong><u>Key Information</u></strong></td>
	</tr>
	
	<tr>
	  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
	  <td colspan="3" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
	  <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
	  <td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
  </tr>
	<tr>
	<?php 
		$query22=mysql_query("select * from master_iptriage where patientcode='$patientcode' and visitcode='$visitcode' ");
		$exec22=mysql_fetch_array($query22);
		$foodallergy = $exec22['foodallergy'];
		$drugallergy = $exec22['drugallergy'];
		$foodallergy = $exec22['foodallergy'];
		$emergencycontact = $exec22['emergencycontact'];
		$privatedoctor = $exec22['privatedoctor'];
		$weight = $exec22['weight'];
		$height = $exec22['height'];
		$bmi = $exec22['bmi'];
		$doctornotes = $exec22['notes'];
	    $ipconsultationdate = $exec22['consultationdate'];
		
		
		
	?>
	
		<td width="13%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext32"> <strong>Drug Allergy </strong>  </span></td>
		<td width="29%" colspan="3" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><?php echo $drugallergy; ?></td>
		<td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext313"><strong>Emergency Contact </strong></td>
		<td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><?php echo $emergencycontact; ?></td>
	</tr>       
	
	<tr>
		<td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Food  Allergy </strong></td>
		<td colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $foodallergy; ?></td>
		<td colspan="2" align="left" valign="middle" class="style1">Private Doctor </td>
		<td colspan="2" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><?php echo $privatedoctor; ?></td>
	</tr>
	<tr>
	  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Weight</strong></td>
	  <td colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $weight; ?></td>
	  <td width="8%" align="left" valign="middle" class="style1">Height</td>
	  <td width="5%" align="left" valign="middle" class="bodytext3"><?php echo $height; ?></td>
	  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="style1">BMI</td>
	  <td width="36%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><?php echo $bmi; ?></td>
  </tr>
	<tr>
	  <td colspan="8" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
  </tr>
	<tr>
	  <td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><table width="433">
        <tr>
	  <td colspan="9" align="center" valign="middle"  bgcolor="#CCCCCC" class="bodytext3">
				 <strong>VITALS INPUT </strong></td> 
     </tr>
				  
				   <tr>
		    <td width="69" class="bodytext3" valign="center"  align="center" 
                bgcolor="#ffffff"><strong>Date</strong></td>
			<td width="65"  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext3"><strong>Time</strong></td>
			<td width="58"  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext3"><strong>Systolic</strong></td>
			<td width="62"  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext3"><strong>Diastolic</strong></td>
			<td width="56"  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext3"><strong>Pulse</strong></td>
			<td width="56"  align="center" valign="center" 
				bgcolor="#ffffff" class="bodytext3"><strong>Resp</strong></td>
	 </tr>
				  
       <?php
	   
	  $query31="select * from ip_vitalio where patientcode = '$patientcode' and visitcode='$visitcode' and otvitalstatus ='' and recorddate between '$transactiondatefrom' and '$transactiondateto' ";
	  $exec31=mysql_query($query31);
	  $num=mysql_num_rows($exec31);
	  while($res31=mysql_fetch_array($exec31))
	  { 
       $recorddate=$res31['recorddate'];
	   $recorddate=date("d/m/Y", strtotime($recorddate));
	   $recordtime=$res31['recordtime'];
	 
	   $systolic=$res31['systolic'];
	   $stolic_array[] =$systolic;
	   $highstolic=rsort($stolic_array);
	   $highstolic[0];
	  
	   $diastolic=$res31['diastolic'];
	   $diastolic_array[]=$diastolic;
	   $diasort[]=sort($diastolic_array);
	   $diasort[6];
	   //echo end($diastolic_array);
	   $lastIndex = key($diastolic_array);  
	   $last[] = $diastolic_array[$lastIndex];
	 
	   $resp=$res31['resp'];
	   $pulse=$res31['pulse'];
	   $tempc=$res31['tempc'];
	   $tempf=$res31['tempf'];
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
		 
		  <td height="25" width="69" class="bodytext3" valign="center"  align="center" 
               ><?php echo $recorddate; ?></td>
		   <td width="65" class="bodytext3" valign="center"  align="center" 
               ><?php echo $recordtime; ?></td>
		  <td width="58" class="bodytext3" valign="center"  align="center" 
               ><?php echo $systolic; ?></td>
		  <td width="62" class="bodytext3" valign="center"  align="center"><?php echo $diastolic; ?>
	      <td width="56" class="bodytext3" valign="center"  align="center" 
               ><?php echo $resp; ?></td>
		  <td width="56" class="bodytext3" valign="center"  align="center" 
               ><?php echo $pulse; ?></td>    
	    </tr>
		  <?php
		 }
		 ?>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table></td>
	  <td colspan="4" align="left" valign="middle" class="bodytext3"><table width="433">
      <tr>
          <td colspan="10" align="center" valign="middle"  bgcolor="#CCCCCC" class="bodytext3"><strong>INPUT / OUTPUT </strong></td>
        </tr>
        <tr>
          <td class="bodytext3" valign="center"  align="center" 
                bgcolor="#ffffff"><strong>Date</strong></td>
          <td  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext3"><strong>Time</strong></td>
                    <td  align="center" valign="center" 
                bgcolor="#ffffff" class="bodytext3"><strong>Vomitus</strong></td>
          <td  align="center" valign="center" 
				bgcolor="#ffffff" class="bodytext3"><strong>Urine</strong></td>
          <td  align="center" valign="center" 
				bgcolor="#ffffff" class="bodytext3"><strong>Diarrhea</strong></td>
          <td  align="center" valign="center" 
				bgcolor="#ffffff" class="bodytext3"><strong>N/Gast</strong></td>
          <td  align="center" valign="center" 
				bgcolor="#ffffff" class="bodytext3"><strong>Drains</strong></td>
          <td  align="center" valign="center" 
				bgcolor="#ffffff" class="bodytext3"><strong>Infused</strong></td>  
          <td  align="center" valign="center" 
				bgcolor="#ffffff" class="bodytext3"><strong>Others</strong></td>           
          </tr>
        <?php
	   
	  $query32="select * from fluidbalance where patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$transactiondatefrom' and '$transactiondateto' ";
	  $exec32=mysql_query($query32);
	  $num=mysql_num_rows($exec32);
	  while($res32=mysql_fetch_array($exec32))
	  { 
       $fluids=$res32['fluids'];
	   $recorddate=date("d/m/Y", strtotime($res32['recorddate']));
	   $recordtime=$res32['recordtime'];
	   $vomitus=$res32['vomitus'];
	   $urine=$res32['urine'];
	   $drains=$res32['drains'];
       $diarrhea=$res32['diarrhea'];
	   $ngast=$res32['ngast'];
	   $bottle=$res32['bottle'];
	   $amount=$res32['amount'];
	   $infused=$res32['infused'];
	   $others=$res32['others'];


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
          <td height="10" class="bodytext3" valign="center"  align="center" 
               ><?php echo $recorddate; ?></td>
          <td class="bodytext3" valign="center"  align="center" 
               ><?php echo $recordtime; ?></td>
                   <td class="bodytext3" valign="center"  align="center" 
               ><?php echo $vomitus; ?></td>
          <td class="bodytext3" valign="center"  align="center" 
               ><?php echo $urine; ?></td>
          <td  align="center" valign="center" 
				class="bodytext3"><?php echo $diarrhea; ?></td>
           <td class="bodytext3" valign="center"  align="center" 
               ><?php echo $ngast; ?></td>
          <td  align="center" valign="center" 
				class="bodytext3"><?php echo $drains; ?></td> 
           <td  align="center" valign="center" 
				class="bodytext3"><?php echo $infused; ?></td>    
           <td  align="center" valign="center" 
				class="bodytext3"><?php echo $others; ?></td>                 
        </tr>
        <?php
		 }
		 ?>
        <tr>
          <td>&nbsp;</td>
        </tr>
              </table></td>
  </tr>
	
	<tr>
		<td colspan="4" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><table width="433">
         <tr>
	  <td colspan="8" align="center" valign="middle"  bgcolor="#CCCCCC" class="bodytext3">
				 <strong>LAB TESTS </strong></td> 
     </tr>
	
				  <?php
      $query33="select * from  ipresultentry_lab where patientvisitcode = '$visitcode' and recorddate between '$transactiondatefrom' and '$transactiondateto' group by itemname " ;
	  $exec33=mysql_query($query33);
	  $num=mysql_num_rows($exec33);
	  while($res33=mysql_fetch_array($exec33))
	  { 
		
		$itemname='';
		//$itemname=$res33['itemname'];
		$labdocnumber=$res33['docnumber'];
		$itemname=$res33['itemname'];
		$itemdate=$res33['recorddate'];
         
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
		 
		  <td height="10" width="12%" class="bodytext3" valign="center"  align="center" 
               ><?php echo $itemname; ?></td>
			   <td height="10" width="12%" class="bodytext3" valign="center"  align="center" 
               ><?php echo $itemdate; ?></td>
		   <td width="10%" class="bodytext3" valign="center"  align="center" 
               ><a href="iplabresultsview.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docnumber=<?php echo $labdocnumber; ?>" target="_blank"><strong>View</strong></a></td>
		</tr>
		   <?php
		
		 
		 }
		 ?>
        </table></td>
       
	    <td colspan="4" align="left" valign="middle" class="bodytext3"><table width="434">
          <tr>
	  <td colspan="8" align="center" valign="middle"  bgcolor="#CCCCCC" class="bodytext3">
				 <strong>RADIOLOGY TESTS </strong></td> 
     </tr>
				  <?php
  				  $query1 = "select * from master_ipvisitentry where patientcode = '$patientcode' and visitcode='$visitcode' order by auto_number desc";
				  $exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
				  while ($res1 = mysql_fetch_array($exec1))
				  {
				  $visitcode = $res1['visitcode'];
				  $visitdate = $res1['registrationdate'];
				  ?>
                  <tr>
				  <?php 
				  if($searchpatient!= '') { ?> 
                    <td width="264" bgcolor="#ffffff" class="bodytext3"><?php echo $visitcode; ?>&nbsp;</td>
                    <td width="158" bgcolor="#ffffff" class="bodytext3"><?php echo $visitdate; ?>&nbsp;</td>
                  <?php } ?>
				  </tr>
				  <?php
				  $query2 = "select * from ipresultentry_lab where patientvisitcode = '$visitcode' and recorddate between '$transactiondatefrom' and '$transactiondateto' group by itemname ";
				  $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
				  while ($res2 = mysql_fetch_array($exec2))
				  {
				  $labtestname = $res2['itemname'];
				  $labdocnumber = $res2['docnumber'];
				  
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
				  
			<?php }  }?>	  
</table>	
      </table>
  <tr>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td colspan="2" valign="top">  
  <tr>
    <td width="0%" rowspan="2">&nbsp;</td>
    <td width="0%" rowspan="2" valign="top">&nbsp;</td>
    <td width="43%" rowspan="2" valign="top"><table width="433">
      <tr>
        <td colspan="8" align="center" valign="middle"  bgcolor="#CCCCCC" class="style1">Nursing Cardex </td>
      </tr>
	  
	 <?php
	  $query36="select * from  ip_progressnotes where visitcode = '$visitcode' order by auto_number desc limit 0, 1";
	  $exec36=mysql_query($query36);
	  $res36=mysql_fetch_array($exec36);
	  $pastmed = $res36['pastmed'];
	  $familyhistory = $res36['familyhistory'];
	  $presentmed = $res36['presentmed'];
	  
	 ?>
	 <tr>
        <td colspan="8" align="left" valign="middle"  class="style1"  bgcolor="#D3EEB7">Past Med/Surg/OBS </td>
      </tr>
	  <tr>
        <td colspan="8" align="left" valign="middle"  class="bodytext3"><?php echo $pastmed; ?></td>
      </tr>
	  <tr>
        <td colspan="8" align="left" valign="middle"  class="style1"  bgcolor="#CBDBFA">Family Social History</td>
      </tr>
	  <tr>
        <td colspan="8" align="left" valign="middle"  class="bodytext3"><?php echo $familyhistory; ?></td>
      </tr>
	  <tr>
        <td colspan="8" align="left" valign="middle"  class="style1"  bgcolor="#D3EEB7">Present Med/Surg/OBS </td>
      </tr>
	  <tr>
        <td colspan="8" align="left" valign="middle"  class="bodytext3"><?php echo $presentmed; ?></td>
      </tr>
      <?php
      $query34="select * from  ip_progressnotes where visitcode = '$visitcode' and recorddate between '$transactiondatefrom' and '$transactiondateto'" ;
	  $exec34=mysql_query($query34);
	  $num=mysql_num_rows($exec34);
	  while($res34=mysql_fetch_array($exec34))
	  { 
		$notes=$res34['notes'];
		$recorddate=$res34['recorddate'];
		$recordtime=$res34['recordtime'];
		
		
		
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
	     <td width="120"  align="left" valign="center"  class="bodytext3" 
               ><?php echo  date("d/m/Y", strtotime($recorddate))." ".$recordtime; ?></td>
        <td width="301"  align="center" valign="center"  class="bodytext3" 
               ><div align="left"><?php echo $notes; ?></div></td>
	  </tr>
	  
	   <?php
		 } 
		 ?>
		
	   <tr>
        <td colspan="8" align="center" valign="middle"  bgcolor="#CCCCCC" class="style1">DOCTOR NOTES </td>
      </tr>
	  <?php 
	      $query35="select * from  ip_doctornotes where visitcode = '$visitcode' and recorddate between '$transactiondatefrom' and '$transactiondateto'" ;
	  $exec35=mysql_query($query35);
	  $num=mysql_num_rows($exec35);
	  while($res35=mysql_fetch_array($exec35))
	  { 
		$ipdoctornotes=$res35['notes'];
		$iprecorddate=$res35['recorddate'];
		
		
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
         <td class="bodytext3" valign="center"  align="center"><?php echo  date("d/m/Y", strtotime($iprecorddate)); ?>
         <td  class="bodytext3" valign="center"  align="center" 
               ><div align="left"><?php echo $ipdoctornotes; ?></div></td>
      </tr>
      <?php } ?>
		 
		
    </table>	  
	<td width="57%" valign="top"><table width="442">
      <tr>
        <td width="434" colspan="8" align="center" valign="middle"  bgcolor="#CCCCCC" class="style1"><a href="ipdrugstatement1.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>" target="_blank">IP Drug Statement</a></td>
      </tr>
	  <?php
		$query40="select * from  preop where patientcode = '$patientcode' and visitcode = '$visitcode' and recorddate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc " ;
		$exec40=mysql_query($query40);
		while($res40=mysql_fetch_array($exec40))
		 {
		$res40docno=$res40['docno'];
	  ?>
	  <tr>
        <td colspan="8" align="center" valign="middle"  bgcolor="#CCCCCC" class="style1"><a href="preopview.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docno=<?php echo $res40docno; ?>" target="_blank">Pre-OP (<?php echo $res40docno; ?>)</a></td>
      </tr>
	  <?php
	     }
	  ?>
	  
	  <?php
		$query41="select * from  postop where patientcode = '$patientcode' and visitcode = '$visitcode' and recorddate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc " ;
		$exec41=mysql_query($query41);
		while($res41=mysql_fetch_array($exec41))
		 {
		$res41docno=$res41['docno'];
	  ?>
	  <tr>
        <td colspan="8" align="center" valign="middle"  bgcolor="#CCCCCC" class="style1"><a href="postopview.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docno=<?php echo $res41docno; ?>" target="_blank">Post-OP (<?php echo $res41docno; ?>)</a></td>
      </tr>
	  <?php
	     }
	  ?>
      
       <?php
		$query42="select * from  ipconsentform where patientcode = '$patientcode' and visitcode = '$visitcode' and recorddate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc " ;
		$exec42=mysql_query($query42);
		while($res42=mysql_fetch_array($exec42))
		 {
		$res42docno=$res42['docno'];
	  ?>
	  <tr>
        <td colspan="8" align="center" valign="middle"  bgcolor="#CCCCCC" class="style1"><a href="ipconsentformview.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docno=<?php echo $res42docno; ?>" target="_blank">Consent-Form<?php //echo $res42docno; ?></a></td>
      </tr>
	  <?php
	     }
	  ?>
    
    </table>    
  <tr>
    <td valign="top"><table width="440" border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td colspan="2" align="center" valign="middle"  bgcolor="#CCCCCC" class="bodytext3"><strong>ICD</strong></td>
        </tr>
		<?php 
		$query141 = "select * from  consultation_icd where patientcode='$patientcode' and patientvisitcode='$visitcode' and primarydiag <> ''  order by auto_number desc limit 0,1";
		$exec141 = mysql_query($query141) or die ("Error in Query141".mysql_error());
		$res141 = mysql_fetch_array($exec141);
		$primarydiag = $res141['primarydiag'];
		$primaryicdcode = $res141['primaryicdcode'];
		if($primarydiag != '')
		{
		?>
      <tr>
        <td width="93" align="center" valign="middle"  bgcolor="#CCCCCC" class="bodytext3"><strong>Primary Code</strong></td>
        <td width="325" align="center" valign="middle"  bgcolor="#CCCCCC" class="bodytext3"><strong>Primary Name</strong></td>
      </tr>
      <tr>
        <td width="93" align="center" valign="middle"  bgcolor="#CBDBFA" class="bodytext3"><?php echo $primaryicdcode; ?></td>
        <td width="93" align="center" valign="middle"  bgcolor="#CBDBFA" class="bodytext3"><?php echo $primarydiag; ?></td>
      </tr>
	  <?php 
	  }
	  $query142 = "select * from  consultation_icd where patientcode='$patientcode' and patientvisitcode='$visitcode' and secondarydiag <> ''  order by auto_number desc limit 0,1";
	  $exec142 = mysql_query($query142) or die ("Error in Query142".mysql_error());
	  $res142 = mysql_fetch_array($exec142);
	  $secondarydiag = $res142['secondarydiag'];
	  $secicdcode = $res142['secicdcode'];
	  if($secondarydiag != '')
		{
	  ?>
      <tr>
        <td align="center" valign="middle"  bgcolor="#CCCCCC" class="bodytext3"><strong>Secondary Code</strong></td>
        <td align="center" valign="middle"  bgcolor="#CCCCCC" class="bodytext3"><strong>Secondary Name</strong></td>
      </tr>
      <tr>
        <td width="93" align="center" valign="middle"  bgcolor="#D3EEB7" class="bodytext3"><?php echo $secicdcode; ?></td>
        <td width="93" align="center" valign="middle"  bgcolor="#D3EEB7" class="bodytext3"><?php echo $secondarydiag; ?></td>
		<?php } ?>
      </tr>
    </table>  
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>