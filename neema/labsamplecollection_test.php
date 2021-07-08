<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");

$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$timeonly = date("H:i:s");
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$dateonly1 = date("Y-m-d");
$titlestr = 'SALES BILL';

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{   
$patientcode=$_REQUEST['patientcode'];
$visitcode=$_REQUEST['visitcode'];
$patientname=$_REQUEST['customername'];
//get locationcode and locationname for insertion
 $locationcodeget=isset($_REQUEST['locationcodeget'])?$_REQUEST['locationcodeget']:'';
 $locationnameget=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';

	$paynowbillprefix = 'LS-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from samplecollection_lab where patientcode <> 'walkin' order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docnumber"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='LS-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["docnumber"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'LS-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
$maxanum1=$maxanum;
$docnumber=$billnumbercode;

$dateonly = date("Y-m-d");
foreach($_POST['lab'] as $key => $value)
		{
		$sampleid = '';
		$labname=$_POST['lab'][$key];
		$itemcode=$_POST['code'][$key];
		$sample=$_POST['sample'][$key];
		$itemstatus=$_POST['status'][$key];
		$remarks=$_POST['remarks'][$key];
		$refno = $_POST['refno'][$key];
		$sno = $_POST['sno'][$key];
		
		if(isset($_POST['ack']))
		{
		$status='completed';
		}
		else
		{
		$status='pending';
		}
	foreach($_POST['ack'] as $check)
		{
		$acknow=$check;
	
		if($acknow == $sno)
		{
		$status='completed';
		$status2='norefund';
		break;
		}
		else
		{
		$status='pending';
		}
	}
$status1='norefund';
	foreach($_POST['ref'] as $check1)
	{
	$refund=$check1;
	if($refund == $sno)
	{
	$status1='refund';
	$status2='refund';
	$status='completed';
	break;
	}
	else
	{
	$status1='norefund';
	}
	}

	//echo $status1;
		
 // mysql_query("insert into master_stock(itemname,itemcode,quantity,batchnumber,rateperunit,totalrate,companyanum,transactionmodule,transactionparticular)values('$medicine','$itemcode','$quantity',' $batch','$rate','$amount','$companyanum','SALES','BY SALES (BILL NO: $billnumber )')");
if($labname != "")
   {
   
   if(($status == 'completed')&&($itemstatus == 'completed')&&($status1 != 'refund'))
   {
   $paynowbillprefix = 'OPS-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from samplecollection_lab where patientcode <> 'walkin' and sampleid <> '' order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$sampleidno = $res2["sampleid"];
$billdigit=strlen($sampleidno);
if ($sampleidno == '')
{
	$sampleid ='OPS-'.'1';
	$openingbalance = '0.00';
}
else
{
	$sampleidno = $res2["sampleid"];
	$sampleid = substr($sampleidno,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$sampleid = intval($sampleid);
	$sampleid = $sampleid + 1;

	$maxanum = $sampleid;	
	$sampleid = 'OPS-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
 
$sampleprefex = substr($sample,0,3);
$sampleid1 = $sampleprefex.'-'.$maxanum1;
   }
 
   $query26="insert into samplecollection_lab(patientname,patientcode,patientvisitcode,recorddate,recordtime,itemcode,itemname,sample,acknowledge,refund,docnumber,username,sampleid,status,remarks,locationcode,locationname)values('$patientname','$patientcode',
   '$visitcode','$dateonly','$timeonly','$itemcode','$labname','$sample','$status','$status1','$docnumber','$username','$sampleid','$itemstatus','$remarks','".$locationcodeget."','".$locationnameget."')";
//   $exec26=mysql_query($query26) or die(mysql_error());
  
   $query29="update consultation_lab set labsamplecoll='$status',labrefund='$status1',docnumber='$docnumber',sampleid='$sampleid',sampledatetime='".date('Y-m-d h:i:s')."' where labitemname='$labname' and patientvisitcode='$visitcode' and refno='$refno'";
  // $exec29 = mysql_query($query29);
   
   $getdob = "select dateofbirth,gender from master_customer where customercode like '$patientcode'";
  $execdob = mysql_query($getdob) or die(mysql_error());
  $resdob = mysql_fetch_array($execdob);
 $dateofbirth = $resdob['dateofbirth'];
 $gender = $resdob['gender'];
  list($year, $month, $day) = explode("-", $dateofbirth);
	if($dateofbirth=="0000-00-00" ||$dateofbirth>=date("Y-m-d"))
	{
    $age = 0;
	$duration = 'Days';
	}
	else{
	$age  = date("Y") - $year;
	$duration = 'Years';
	if($age == 0)
	{
	$age = date("m") - $month;
	$duration = 'Months';
	if($age == 0)
	{
	$age = date("d") - $day;
	$duration = 'Days';
	}
	}
	}
	$qrydpt = "select departmentname from master_visitentry where visitcode='$visitcode'";
	  $execdpt = mysql_query($qrydpt) or die(mysql_error()); 
 	$resdpt = mysql_fetch_array($execdpt);
	$dpt = $resdpt['departmentname'];
	$datetime = date('Y-m-d h:i:s');
 $qrygetparam = "select * from master_test_parameter where labcode like '$itemcode'";
  $execgetparam = mysql_query($qrygetparam) or die(mysql_error()); 
  while($resparam = mysql_fetch_array($execgetparam))
  {
  $parametername = $resparam['parametername'];
  $parametercode = $resparam['parametercode'];
  $qryparam = "INSERT INTO `pending_test_orders`( `patientname`,`patientcode`,`visitcode`, `testcode`, `testname`, `age`,`duration`, `gender`, `sample_id`, `sample_type`, `patient_from`,`ward`, `dob`, `samplecollectedby`, `sampledate`, `parametercode`, `parametername`) values ('$patientname','$patientcode','$visitcode','$itemcode','$labname','$age','$duration','$gender','$sampleid1','$sample','Out-Patient','$dpt','$dateofbirth','$username','$datetime','$parametercode','$parametername')";
mysql_query($qryparam) or die(mysql_error());
  } 
   
   
   
  
  	}
	
}
  
  header("location:collectedsampleview.php?patientcode=$patientcode&&visitcode=$visitcode&&docnumber=$docnumber");
  exit;
  
}

?>

<?php
$patientcode = $_REQUEST["patientcode"];
$visitcode = $_REQUEST["visitcode"];
?>

<?php
if (isset($_REQUEST["errcode"])) { $errcode = $_REQUEST["errcode"]; } else { $errcode = ""; }
if($errcode == 'failed')
{
	$errmsg="No Stock";
}
?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$paynowbillprefix = 'LS-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from samplecollection_lab where patientcode <> 'walkin' order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docnumber"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='LS-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["docnumber"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'LS-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
?>
<script>
 
 
  
function acknowledgevalid()
{
var chks = document.getElementsByName('ack[]');
var hasChecked = false;
for (var i = 0; i < chks.length; i++)
{
if (chks[i].checked)
{
hasChecked = true;
}
}
var chks1 = document.getElementsByName('ref[]');
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
alert("Please either acknowledge a sample  or click back button on the browser to exit sample collection");
return false;
}
for(n=1;n<10;n++)
	{
if(document.getElementById("status"+n+"").value == 'notcompleted')
{
if(document.getElementById("remarks"+n+"").value == '')
{
alert("Please Enter Remarks");
document.getElementById("remarks"+n+"").focus();
return false;
}
}
}

return true;
}

function checkboxcheck(varserialnumber)
{

var varserialnumber = varserialnumber;

if(document.getElementById("ack"+varserialnumber+"").checked == true)
{

document.getElementById("ref"+varserialnumber+"").disabled = true;
}
else
{
document.getElementById("ref"+varserialnumber+"").disabled = false;
}
}

function checkboxcheck1(varserialnumber1)
{

var varserialnumber1 = varserialnumber1;

if(document.getElementById("ref"+varserialnumber1+"").checked == true)
{

document.getElementById("ack"+varserialnumber1+"").disabled = true;
}
else
{
document.getElementById("ack"+varserialnumber1+"").disabled = false;
}
}

function funcOnLoadBodyFunctionCall()
{
funcremarkshide();

var varbilltype = document.getElementById("billtype").value
if(varbilltype =='PAY LATER')
{
for(i=1;i<=100;i++)
{
//alert('hi');
document.getElementById("ref"+i+"").disabled = true;
}
}
}

</script>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>

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
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
</style>
<?php
$patientcode = $_REQUEST["patientcode"];
$visitcode = $_REQUEST["visitcode"];
?>
<script src="js/datetimepicker_css.js"></script>
<?php
$query65= "select * from master_visitentry where patientcode='$patientcode'";
$exec65=mysql_query($query65) or die("error in query65".mysql_error());
$res65=mysql_fetch_array($exec65);
$Patientname=$res65['patientfullname'];


$query69="select * from master_customer where customercode='$patientcode'";
$exec69=mysql_query($query69) or die(mysql_error());
$res69=mysql_fetch_array($exec69);
$patientaccount=$res69['accountname'];
$photoavailable = $res69['photoavailable'];

$query78="select * from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$exec78=mysql_query($query78) or die(mysql_error());
$res78=mysql_fetch_array($exec78);
$patientage=$res78['age'];
$patientgender=$res78['gender'];

$query70="select * from master_accountname where auto_number='$patientaccount'";
$exec70=mysql_query($query70);
$res70=mysql_fetch_array($exec70);
$accountname=$res70['accountname'];

$query20 = "select * from master_triage where patientcode = '$patientcode' and visitcode='$visitcode'";
$exec20=mysql_query($query20);
$res20=mysql_fetch_array($exec20);
$res20consultingdoctor=$res20['consultingdoctor'];

$query612 = "select * from consultation_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' order by auto_number desc";
$exec612 = mysql_query($query612) or die(mysql_error());
$res612 = mysql_fetch_array($exec612);
$orderedby = $res612['username'];
$refno = $res612['refno'];
//get location code and name from table
  $locationcode=$res612['locationcode'];
  $locationname=$res612['locationname'];
 //get location end here

?>

</head>
<script>
function funcPrintBill()
 {
var patientcode;
patientcode = document.getElementById("customercode").value; 
var visitcode;
visitcode = document.getElementById("visitcode").value; 
var docnumber;
docnumber = document.getElementById("docnumber").value; 
var popWin; 
popWin = window.open("print_labtest_label.php?patientcode="+patientcode+"&&visitcode="+visitcode+"&&billnumber="+docnumber,"OriginalWindowA4",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
 }
 

function funcremarksshow(k)
{
var k = k;
//alert(k);
  if (document.getElementById("remarks1"+k+"") != null) 
     {
	 document.getElementById("remarks1"+k+"").style.display = 'none';
	}
	if (document.getElementById("remarks1"+k+"") != null) 
	  {
	  document.getElementById("remarks1"+k+"").style.display = '';
	 }
	 
  if (document.getElementById("remarks2") != null) 
     {
	 document.getElementById("remarks2").style.display = 'none';
	}
	if (document.getElementById("remarks2") != null) 
	  {
	  document.getElementById("remarks2").style.display = '';
	 }
	 
	
	
}

function funcremarkshide()
{		

 if (document.getElementById("remarks2") != null) 
	{
	document.getElementById("remarks2").style.display = 'none';
	}	
	for(i=1;i<10;i++)
	{
	if (document.getElementById("remarks1"+i+"") != null) 
	{
	document.getElementById("remarks1"+i+"").style.display = 'none';
	}
	}	
		
}

function funcstatus(j)
{
var j = j;
if(document.getElementById("status"+j+"").value == 'notcompleted')
{
funcremarksshow(j);
}
if(document.getElementById("status"+j+"").value == 'completed')
{
funcremarkshide();
}
}
function validcheck()
{

if(confirm("Do You Want To Save The Record?")==false){return false;}	
}

function ShowImage(imgval,flg)
{
	var imgval = document.getElementById('patientcode').value;
	if(imgval != '')
	{
		if(flg == 'Show Image') {
		var photoavailable = document.getElementById('photoavailable').value;
		if(photoavailable == 'YES') {
		document.getElementById('patientimage').src = 'patientphoto/'+imgval+'.JPG';
		} else {
		document.getElementById('patientimage').src = 'patientphoto/noimage.JPG';
		}
		document.getElementById('imgbtn').value = "Hide Image";
		} else {
		document.getElementById('patientimage').src = '';
		document.getElementById('imgbtn').value = "Show Image";
		}
	}
	else
	{
		alert("Patient Code is Empty");
	}
}
</script>  

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="frmsales" id="frmsales" method="post" action="labsamplecollection_test.php" onKeyDown="return disableEnterKey(event)" onSubmit=" return validcheck() && funcPrintBill1(); ">
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
    <td width="99%" valign="top"><table width="1223" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td colspan="4" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo 'red'; } ?>" class="bodytext3"><strong><?php echo $errmsg;?>&nbsp;</strong></td></tr>
      <tr>
        <td width="83%"><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
              
                    <input name="billnumberprefix" id="billnumberprefix" value="<?php echo $billnumberprefix; ?>" type="hidden" style="border: 1px solid #001E6A"  size="5" /> 
                    <input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>">
               <td bgcolor="#CCCCCC" class="bodytext3"><strong>Patient  * </strong></td>
	  <td class="bodytext3" width="25%" align="left" valign="middle" bgcolor="#CCCCCC">
				<input name="customername" type="hidden" id="customer" value="<?php echo $Patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/><?php echo $Patientname; ?>                  </td>
                          <td bgcolor="#CCCCCC" class="bodytext3"><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5"> <strong>Date </strong></td>
				
                  <input name="billnumberpostfix" id="billnumberpostfix" value="<?php echo $billnumberpostfix; ?>" style="border: 1px solid #001E6A"  size="5" type="hidden" />
                
                <td width="27%" bgcolor="#CCCCCC" class="bodytext3">
               
                  <input name="ADate" id="ADate" style="border: 1px solid #001E6A" value="<?php echo $dateonly1; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                  <img src="images2/cal.gif" style="cursor:pointer"/>				</td>
               
               <td width="9%" align="left" valign="middle"  bgcolor="#CCCCCC" class="bodytext3"><strong>Doc No</strong></td>
                <td width="23%" align="left" valign="middle" bgcolor="#CCCCCC" class="bodytext3">
			<input name="docnumber" id="docnumber" type="hidden" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="8" rsize="20" readonly/><?php echo $billnumbercode; ?>                  </td>
              </tr>
			 
		
			  <tr>
				 <td width="8%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Location </strong></td>
                 <td width="8%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong><?php echo $locationname;?> </strong></td>
                 <input type="hidden" name="locationcodeget" value="<?php echo $locationcode;?>">
                 <input type="hidden" name="locationnameget" value="<?php echo $locationname;?>">
			    <td width="8%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Visit Code</strong></td>
                <td class="bodytext3" width="25%" align="left" valign="middle" >
			<input name="visitcode" id="visitcode" type="hidden" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $visitcode; ?>                  </td>
                 <td width="8%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Patient code </strong></td>
                <td align="left" class="bodytext3" valign="top" >
				<input name="customercode" id="customercode" type="hidden" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $patientcode; ?>
				
				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>
             
			    
			  </tr>
				  <tr>
                  <td align="left" valign="top" class="bodytext3" ><strong>Ordered By </strong></td>
			    <td align="left" class="bodytext3" valign="top" ><?php echo $orderedby; ?></td>

			  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="style4"></span><strong>Age &amp; Gender </strong></td>
			    <td align="left" valign="middle" class="bodytext3">
				<input name="patientage" type ="hidden" id="patientage" value="<?php echo $patientage; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;" size="5" readonly><?php echo $patientage; ?>
				&
				<input name="patientgender" type="hidden" id="patientgender" value="<?php echo $patientgender; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $patientgender; ?>			        </td>
                <td width="8%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Account</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3">
				<input name="account" id="account" type="hidden" value="<?php echo $accountname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $accountname; ?>				  </tr>
			    
				  <tr>
				  <td width="8%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>&nbsp;</strong></td>
				  </tr>
            </tbody>
        </table></td>
		 <td width="17%" rowspan="6" align="center" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><br><strong>Patient Photo</strong>
		 <img width="150" height="150" id="patientimage" src="">
		  <br/> 
		  <input type="hidden" name="photoavailable" id="photoavailable" value="<?php echo $photoavailable; ?>" />
		  <input type="button" name="imgbtn" id="imgbtn" value="Show Image" onClick="return ShowImage('<?php echo $patientcode; ?>',this.value);"><br/>
		</td>	  
      </tr>
      
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
            <tr>
					<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Refund</strong></div></td>
              <td width="28%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Test Name</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Sample Type</strong></div></td>
				<td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Acknowledge</strong></div></td>
				<td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Status</strong></div></td>
				 <td width="23%" align="center" valign="center" bgcolor="#ffffff" class="bodytext311" id="remarks2"><strong>Remarks</strong></td>
			      </tr>
				  		<?php
			$colorloopcount = '';
			$sno = '';
			$ssno=0;
			$totalamount=0;			
			$query61 = "select * from consultation_lab where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and labsamplecoll='pending' and (labrefund='norefund' or labrefund='') and paymentstatus='completed' and labitemname <> '' and (billtype='PAY NOW' or (billtype='PAY LATER'))";
$exec61 = mysql_query($query61) or die ("Error in Query1".mysql_error());
$numb=mysql_num_rows($exec61);
while($res61 = mysql_fetch_array($exec61))
{
$labname =$res61["labitemname"];
$billtype = $res61["billtype"];
$refno = $res61['refno'];
 
$query68="select * from master_lab where itemname='$labname' and status <> 'deleted'";
$exec68=mysql_query($query68);
$res68=mysql_fetch_array($exec68);
$samplename=$res68['sampletype'];
$itemcode=$res68['itemcode'];
$externallab=$res68['externallab'];


if($externallab == 'on')
{
$colorcode = 'bgcolor="yellow"';
}
else
{
$colorcode = '';
}
$query41="select * from master_categorylab where categoryname='$labname'";
$exec41=mysql_query($query41);
$num41=mysql_num_rows($exec41);
if($num41 > 0)
{
$itemcode=$ssno;
$ssno=$ssno + 1;
}
$sno = $sno + 1;
?>
  <tr <?php echo $colorcode; ?>>
  <td class="bodytext31" valign="center"  align="left"><div align="center">
  		<input type="hidden" name="sno[]" value="<?php echo $sno; ?>"> 
        <input type="checkbox" name="ref[]" id="ref<?php echo $sno; ?>" value="<?php echo $sno; ?>" onClick="return checkboxcheck1('<?php echo $sno; ?>')"/></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labname;?></div></td>
		<input type="hidden" name="lab[]" value="<?php echo $labname;?>">
		<input type="hidden" name="code[]" value="<?php echo $itemcode; ?>">
		<input type="hidden" name="refno[]" value="<?php echo $refno; ?>">
		<input type="hidden" name="billtype" id="billtype" value="<?php echo $billtype; ?>">
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $samplename; ?>
       </div></td><input type="hidden" name="sample[]" value="<?php echo $samplename; ?>">
        <td class="bodytext31" valign="center"  align="left"><div align="center">
        <input type="checkbox" id="ack<?php echo $sno; ?>" name="ack[]" value="<?php echo $sno; ?>" onClick="return checkboxcheck('<?php echo $sno; ?>')"/></div></td>
		 <td class="bodytext31" valign="center"  align="left"><div align="center">
		 <select name="status[]" id="status<?php echo $sno; ?>" onChange="return funcstatus('<?php echo $sno; ?>');">
		 <option value="completed">Completed</option>
		 <option value="notcompleted">Not Completed</option>
		 </select>
		 </div></td>
		  <td align="center" valign="center" class="bodytext311" id="remarks1<?php echo $sno; ?>"><textarea name="remarks[]" id="remarks<?php echo $sno; ?>"></textarea></td>			
				  </tr>
			<?php 
		
			}
		?>
			
           
          </tbody>
        </table>		</td>
      </tr>
      
      
      
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr>
              <td width="54%" align="right" valign="top" >
                     <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
             	  <input name="Submit2223" type="submit" value="Save " onClick="return acknowledgevalid()" accesskey="b" class="button" />
               </td>
              
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
