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

$titlestr = 'SALES BILL';

$getdocnumber=isset($_REQUEST['docnumber'])?$_REQUEST['docnumber']:'';
$getsalseautonumber=isset($_REQUEST['salseautonumber'])?$_REQUEST['salseautonumber']:'';

$query231 = "select * from master_employee where username='$username'";
$exec231 = mysql_query($query231) or die(mysql_error());
$res231 = mysql_fetch_array($exec231);
$res7locationanum1 = $res231['location'];

$query551 = "select * from master_location where auto_number='$res7locationanum1'";
$exec551 = mysql_query($query551) or die(mysql_error());
$res551 = mysql_fetch_array($exec551);
$location1 = $res551['locationname'];

$res7storeanum1 = $res231['store'];

$query751 = "select * from master_store where auto_number='$res7storeanum1'";
$exec751 = mysql_query($query751) or die(mysql_error());
$res751 = mysql_fetch_array($exec751);
$store1 = $res751['store'];

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{   
$query21 = "select docno from medicine_return_request order by auto_number desc limit 0, 1";
	 $exec21 = mysql_query($query21) or die ("Error in Query1".mysql_error());
	 $rowcount21 = mysql_num_rows($exec21);
	if ($rowcount21 == 0)
	{
		$consultationcode = 'MRC001';
	}
	else
	{
		$res21 = mysql_fetch_array($exec21);
		 $consultationcode = $res21['docno'];
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
			$consultationcode = 'MRC'.$consultationcode;
		}
//get locationcode and storecode
$getlocationcode=isset($_REQUEST['getlocationcode'])?$_REQUEST['getlocationcode']:'';
$getlocationname=isset($_REQUEST['getlocationname'])?$_REQUEST['getlocationname']:'';
$getstorecode=isset($_REQUEST['getstorecode'])?$_REQUEST['getstorecode']:'';
//end here

$patientcode=$_REQUEST['patientcode'];
$visitcode=$_REQUEST['visitcode'];
$pharmacycoa = $_REQUEST['pharmacycoa'];
$patientname=$_REQUEST['customername'];
$Querylab=mysql_query("select * from master_customer where customercode='$patientcode'");
$execlab=mysql_fetch_array($Querylab);
$patienttype=$execlab['maintype'];
$querytype=mysql_query("select * from master_paymenttype where auto_number='$patienttype'");
$exectype=mysql_fetch_array($querytype);
$patienttype1=$exectype['paymenttype'];
$patientsubtype=$execlab['subtype'];
$querysubtype=mysql_query("select * from master_subtype where auto_number='$patientsubtype'");
$execsubtype=mysql_fetch_array($querysubtype);
$patientsubtype1=$execsubtype['subtype'];

$query77 = "select * from master_visitentry where visitcode='$visitcode'";
		$exec77 = mysql_query($query77) or die(mysql_error());
		$res77 = mysql_fetch_array($exec77);
		$doctor = $res77['consultingdoctor'];
		
		$query78 = "select * from master_doctor where auto_number='$doctor'";
		$exec78 = mysql_query($query78) or die(mysql_error());
		$res78 = mysql_fetch_array($exec78);
		$doctorname = $res78['doctorname'];
	
$billnumber=$_REQUEST['billnumber'];
$dateonly = date("Y-m-d");
 $accountname = $_REQUEST['account'];
$totalrefundamount = $_REQUEST['totalamt'];
$accountnameano= $_REQUEST['accountnameano'];
$accountnameid= $_REQUEST['accountnameid'];
foreach($_POST['med'] as $key => $value)
{
$medicinename=$_POST['med'][$key]; 
$itemcode=$_POST['code'][$key];
$rate=$_POST['rate'][$key];
		$quantity=$_POST['quantity'][$key];
		$returnquantity=$_POST['returnquantity'][$key];
		$batchnumber=$_POST['batch'][$key];
		$amount=$_POST['amount'][$key];
		$docnoget=$_POST['docnoget'][$key];
		$refnoget=$_POST['refnoget'][$key];
		$issuequantity=$_POST['issuequantity'][$key];
		$rateperunit=$_POST['rateperunit'][$key];
		$returnamount=$issuequantity*$rateperunit;
		$freestatus=$_POST['freestatus'][$key];
		$fifo_code = $_POST['fifo_code'][$key];
		//get docno hrere
$docnumber=$_REQUEST['docnumber'][$key];

//ends here
//get docno hrere
$salseautonumber=$_REQUEST['salseautonumber'][$key];
//ends here
		
			$query31 = "select * from master_itempharmacy where itemcode = '$itemcode'"; 
			$exec31 = mysql_query($query31) or die ("Error in Query31".mysql_error());
			$res31 = mysql_fetch_array($exec31);
			 $categoryname = $res31['categoryname'];
		
			foreach($_POST['ref'] as $check1)
			{
			 $refund=$check1;
		
	if($refund == $itemcode)
	{
	if($returnquantity !='')
	{
	if($visitcode!='walkinvis')
	{ //echo 'in';
		$query76 = "select * from master_ipvisitentry where billtype='PAY LATER' and overallpayment='completed' and visitcode='$visitcode'";
		$exec76 = mysql_query($query76) or die(mysql_error());
		$num76 = mysql_num_rows($exec76);
		if($num76 == 0)
		{ //echo 'll';
		
		$querycumstock2 = "select cum_quantity from transaction_stock where cum_stockstatus='1' and itemcode='$itemcode' and locationcode='$getlocationcode'";
		$execcumstock2 = mysql_query($querycumstock2) or die ("Error in CumQuery2".mysql_error());
		$rescumstock2 = mysql_fetch_array($execcumstock2);
		$cum_quantity = $rescumstock2["cum_quantity"];
		$cum_quantity = $cum_quantity+$returnquantity;
		
		$querybatstock2 = "select batch_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$getlocationcode' and fifo_code='$fifo_code' and storecode ='$getstorecode'";
		$execbatstock2 = mysql_query($querybatstock2) or die ("Error in batQuery2".mysql_error());
		$resbatstock2 = mysql_fetch_array($execbatstock2);
		$bat_quantity = $resbatstock2["batch_quantity"];
		$bat_quantity = $bat_quantity+$returnquantity;
		
		$queryupdatebatstock2 = "update transaction_stock set cum_stockstatus='0' ,batch_stockstatus='0' where itemcode='$itemcode' and locationcode='$getlocationcode' and storecode='$getstorecode' and fifo_code='$fifo_code'";
		$execupdatebatstock2 = mysql_query($queryupdatebatstock2) or die ("Error in updatebatQuery2".mysql_error());
		
		//$queryupdatebatstock2 = "update transaction_stock set cum_stockstatus='0' where itemcode='$itemcode' and locationcode='$getlocationcode'";
		//$execupdatebatstock2 = mysql_query($queryupdatebatstock2) or die ("Error in updatebatQuery2".mysql_error());
		
		$stockquery2="insert into transaction_stock (fifo_code,tablename,itemcode, itemname, transaction_date,transactionfunction,description,
			batchnumber, batch_quantity, 
			transaction_quantity, cum_quantity, entrydocno, docstatus, cum_stockstatus, batch_stockstatus,locationcode,locationname,storecode,storename,username,ipaddress,recorddate,recordtime,updatetime,patientcode,patientvisitcode,patientname,rate,totalprice)
			values ('$fifo_code','pharmacysalesreturn_details','$itemcode', '$medicinename', '$dateonly','1', 'IP Sales Return', 
			'$batchnumber', '$bat_quantity', '$returnquantity', 
			'$cum_quantity', '$billnumber', '','1','1', '$getlocationcode','','$getstorecode', '', '$username', '$ipaddress','$dateonly','$timeonly','$datetimeonly','$patientcode','$visitcode','$patientname','$rate','$amount')";
			
		$stockexecquery2=mysql_query($stockquery2) or die(mysql_error());
		
		$query43="insert into pharmacysalesreturn_details(fifo_code,patientcode,visitcode,companyanum,billnumber,itemcode,itemname,rate,quantity,totalamount,username,ipaddress,entrydate,batchnumber,billstatus,location,pharmacycoa,categoryname,locationname,locationcode,store,docnumber,salseautonumber)values('$fifo_code','$patientcode','$visitcode','$companyanum','$billnumber','$itemcode','$medicinename','$rate','$returnquantity','$amount','$username','$ipaddress','$dateonly','$batchnumber','pending','$location1','$pharmacycoa','$categoryname','".$getlocationname."','".$getlocationcode."','".$getstorecode."','".$docnumber."','".$salseautonumber."')"; 
		$exec43=mysql_query($query43) or die(mysql_error());
		
		$query55 = "insert into paylaterpharmareturns(patientcode,patientvisitcode,patientname,medicinecode,medicinename,rate,quantity,amount,pharmacycoa,username,ipaddress,billdate,accountname,billnumber,locationname,locationcode,accountnameano,accountnameid,subtypeano)values('$patientcode','$visitcode','$patientname','$itemcode','$medicinename','$rate','$returnquantity','$amount','$pharmacycoa','$username','$ipaddress','$dateonly','$accountname','$billnumber','".$getlocationname."','".$getlocationcode."','$accountnameano','$accountnameid','$patientsubtype')";
		$exec55 = mysql_query($query55) or die(mysql_error());
	
		$queryupdate = "UPDATE medicine_return_request SET completestatus='complete' where itemcode='".$itemcode."' and  visitcode='".$visitcode."' and refno='".$refnoget."' and refundstatus <> 'refund'";
		$execupdate = mysql_query($queryupdate) or die(mysql_error());
		
		$queryupdate1 = "update  medicine_return_request SET return_quantity='".$returnquantity."',refundstatus='refund', itemcode='".$itemcode."' ,  visitcode='".$visitcode."',
		itemname='".$medicinename."' ,date='".$dateonly."',docno='".$consultationcode."',refno='".$refnoget."',issue_quantity='".$issuequantity."',rateperunit='".$rateperunit."',return_amount='".$returnamount."',patientcode='".$patientcode."',patientname='".$patientname."',locationname='".$getlocationname."',locationcode='".$getlocationcode."',username='".$username."',ipaddress='".$ipaddress."',freestatus='".$freestatus."'";
		//$execupdate1 = mysql_query($queryupdate1) or die(mysql_error());
	
		}
		else
		{//echo 'jj';
		
		$querycumstock2 = "select cum_quantity from transaction_stock where cum_stockstatus='1' and itemcode='$itemcode' and locationcode='$getlocationcode'";
		$execcumstock2 = mysql_query($querycumstock2) or die ("Error in CumQuery2".mysql_error());
		$rescumstock2 = mysql_fetch_array($execcumstock2);
		$cum_quantity = $rescumstock2["cum_quantity"];
		$cum_quantity = $cum_quantity+$returnquantity;
		
		$querybatstock2 = "select batch_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$getlocationcode' and fifo_code='$fifo_code' and storecode ='$getstorecode'";
		$execbatstock2 = mysql_query($querybatstock2) or die ("Error in batQuery2".mysql_error());
		$resbatstock2 = mysql_fetch_array($execbatstock2);
		$bat_quantity = $resbatstock2["batch_quantity"];
		$bat_quantity = $bat_quantity+$returnquantity;
		
		$queryupdatebatstock2 = "update transaction_stock set cum_stockstatus='0' ,batch_stockstatus='0' where itemcode='$itemcode' and locationcode='$getlocationcode' and storecode='$getstorecode' and fifo_code='$fifo_code'";
		$execupdatebatstock2 = mysql_query($queryupdatebatstock2) or die ("Error in updatebatQuery2".mysql_error());
		
		//$queryupdatebatstock2 = "update transaction_stock set cum_stockstatus='0' where itemcode='$itemcode' and locationcode='$getlocationcode'";
		//$execupdatebatstock2 = mysql_query($queryupdatebatstock2) or die ("Error in updatebatQuery2".mysql_error());
		
		$stockquery2="insert into transaction_stock (fifo_code,tablename,itemcode, itemname, transaction_date,transactionfunction,description,
			batchnumber, batch_quantity, 
			transaction_quantity, cum_quantity, entrydocno, docstatus, cum_stockstatus, batch_stockstatus,locationcode,locationname,storecode,storename,username,ipaddress,recorddate,recordtime,updatetime,patientcode,patientvisitcode,patientname,rate,totalprice)
			values ('$fifo_code','pharmacysalesreturn_details','$itemcode', '$medicinename', '$dateonly','1', 'Sales Return', 
			'$batchnumber', '$bat_quantity', '$returnquantity', 
			'$cum_quantity', '$billnumber', '','1','1', '$getlocationcode','','$getstorecode', '', '$username', '$ipaddress','$dateonly','$timeonly','$datetimeonly','$patientcode','$visitcode','$patientname','$rate','$amount')";
			
		$stockexecquery2=mysql_query($stockquery2) or die(mysql_error());
		
		$query43="insert into pharmacysalesreturn_details(fifo_code,patientcode,visitcode,companyanum,billnumber,itemcode,itemname,rate,quantity,totalamount,username,ipaddress,entrydate,batchnumber,billstatus,pharmacycoa,location,categoryname,locationname,locationcode,store,docnumber,salseautonumber)values('$fifo_code','$patientcode','$visitcode','$companyanum','$billnumber','$itemcode','$medicinename','$rate','$returnquantity','$amount','$username','$ipaddress','$dateonly','$batchnumber','completed','$pharmacycoa','$location1','$categoryname','".$getlocationname."','".$getlocationcode."','".$getstorecode."','".$docnumber."','".$salseautonumber."')";
		$exec43=mysql_query($query43) or die(mysql_error());
		
		$query55 = "insert into paylaterpharmareturns(patientcode,patientvisitcode,patientname,medicinecode,medicinename,rate,quantity,amount,pharmacycoa,username,ipaddress,billdate,accountname,billnumber,locationname,locationcode,accountnameano,accountnameid,subtypeano)values('$patientcode','$visitcode','$patientname','$itemcode','$medicinename','$rate','$returnquantity','$amount','$pharmacycoa','$username','$ipaddress','$dateonly','$accountname','$billnumber','".$getlocationname."','".$getlocationcode."','$accountnameano','$accountnameid','$patientsubtype')";
		$exec55 = mysql_query($query55) or die(mysql_error());
		
		
		
		$queryupdate = "UPDATE medicine_return_request SET completestatus='complete' where itemcode='".$itemcode."' and  visitcode='".$visitcode."' and refno='".$refnoget."' and refundstatus <> 'refund'";
		$execupdate = mysql_query($queryupdate) or die(mysql_error());
		
		$queryupdate1 = "update medicine_return_request SET return_quantity='".$returnquantity."',refundstatus='refund', itemcode='".$itemcode."' ,  visitcode='".$visitcode."',
		itemname='".$medicinename."' ,date='".$dateonly."',docno='".$consultationcode."',refno='".$refnoget."',issue_quantity='".$issuequantity."',rateperunit='".$rateperunit."',return_amount='".$returnamount."',patientcode='".$patientcode."',patientname='".$patientname."',locationname='".$getlocationname."',locationcode='".$getlocationcode."',username='".$username."',ipaddress='".$ipaddress."',freestatus='".$freestatus."'";
		//$execupdate1 = mysql_query($queryupdate1) or die(mysql_error());
	
		}
	}
	else
	{ //echo 'ii';
		$query43="insert into pharmacysalesreturn_details(patientcode,visitcode,companyanum,billnumber,itemcode,itemname,rate,quantity,totalamount,username,ipaddress,entrydate,batchnumber,billstatus,pharmacycoa,location,categoryname,locationname,locationcode,store,docnumber,salseautonumber)values('$patientcode','$visitcode','$companyanum','$billnumber','$itemcode','$medicinename','$rate','$returnquantity','$amount','$username','$ipaddress','$dateonly','$batchnumber','pending','$pharmacycoa','$location1','$categoryname','".$getlocationname."','".$getlocationcode."','".$getstorecode."','".$docnumber."','".$salseautonumber."')";
		$exec43=mysql_query($query43) or die(mysql_error());
		
		$query55 = "insert into paylaterpharmareturns(patientcode,patientvisitcode,patientname,medicinecode,medicinename,rate,quantity,amount,pharmacycoa,username,ipaddress,billdate,accountname,billnumber,locationname,locationcode,accountnameano,accountnameid,subtypeano)values('$patientcode','$visitcode','$patientname','$itemcode','$medicinename','$rate','$returnquantity','$amount','$pharmacycoa','$username','$ipaddress','$dateonly','$accountname','$billnumber','".$getlocationname."','".$getlocationcode."','$accountnameano','$accountnameid','$patientsubtype')";
		$exec55 = mysql_query($query55) or die(mysql_error());
	}
	}
	}
			}
	
}
$query83="insert into master_transactionpaylater(patientname,patientcode,visitcode,transactiondate,accountname,docno,ipaddress,companyanum,companyname,financialyear,transactiontype,paymenttype,subtype,transactionamount,receivableamount,doctorname,locationname,locationcode,accountnameano,accountnameid,subtypeano)values('$patientname',
	          '$patientcode','$visitcode','$dateonly','$accountname','$billnumber','$ipaddress','$companyanum','$companyname','$financialyear','pharmacycredit','$patienttype1','$patientsubtype1','$totalrefundamount','$totalrefundamount','$doctorname','".$getlocationname."','".$getlocationcode."','$accountnameano','$accountnameid','$patientsubtype')";
	$exec83=mysql_query($query83) or die("error in query83".mysql_error());		  

	
  header("location:medicineissuelist.php");
  exit;
}

?>

<?php
if (isset($_REQUEST["errcode"])) { $errcode = $_REQUEST["errcode"]; } else { $errcode = ""; }
if($errcode == 'failed')
{
	$errmsg="No Stock";
}
?>
<script>
function validcheck()
{
if(confirm("Are You Want To Save The Record?")==false){return false;}	
}
function acknowledgevalid(varSerialNumber2)
{
var varSerialNumber2=varSerialNumber2;

var hasChecked = false;
if (document.getElementById("ref"+varSerialNumber2+"").checked)
{
hasChecked = true;
}

if (hasChecked == false)
{
alert("Please either refund a drug  or click back button on the browser to exit sample collection");
document.getElementById("returnquantity"+varSerialNumber2+"").value = 0;
return false;
}
return true;

}
function balancecalc(varSerialNumber1,qnty1,totalcount)
{
var varSerialNumber1 = varSerialNumber1;
var qnty1 = qnty1;
var totalcount=totalcount;
//alert(totalcount);
var grandtotal=0;

var abc=acknowledgevalid(varSerialNumber1);
if(abc == true)
{

var returnquantity=document.getElementById("returnquantity"+varSerialNumber1+"").value;
returnquantity = parseInt(returnquantity);
qnty1 = parseInt(qnty1);
if(returnquantity>qnty1)
{
alert("Please Enter a Lesser Quantity");
document.getElementById("balamount"+varSerialNumber1+"").value=0.00;
document.getElementById("totalamt").value=0.00;
document.getElementById("amount"+varSerialNumber1+"").value=0.00;
document.getElementById("returnquantity"+varSerialNumber1+"").value = 0;
document.getElementById("returnquantity"+varSerialNumber1+"").focus();
return false;
}
if(returnquantity <= qnty1)
{
var balancequantity=parseFloat(qnty1)-parseFloat(returnquantity);

document.getElementById("balamount"+varSerialNumber1+"").value=balancequantity;

var rate=document.getElementById("rate"+varSerialNumber1+"").value;

var newamount=rate * returnquantity;
document.getElementById("amount"+varSerialNumber1+"").value=newamount.toFixed(2);
for(i=1;i<=totalcount;i++)
{
var totalamount=document.getElementById("amount"+i+"").value;

if(totalamount == "")
{
totalamount=0;
}
//alert(totalamount);
grandtotal=parseFloat(grandtotal)+parseFloat(totalamount);

}
//alert(grandtotal);
document.getElementById("totalamt").value=grandtotal.toFixed(2);
}
return true;
}

}
function updatebox(varSerialNumber3,qnty1,totalcount1)
{
var varSerialNumber3 = varSerialNumber3;
var qnty1 = qnty1;
var totalcount1=totalcount1;
var grandtotal=0;
if(document.getElementById("ref"+varSerialNumber3+"").checked == true)
{
var returnquantity=document.getElementById("returnquantity"+varSerialNumber3+"").value;

if(returnquantity !='')
{
returnquantity = parseInt(returnquantity);
qnty1 = parseInt(qnty1);
if(returnquantity>qnty1)
{
alert("Please Enter a Lesser Quantity");
document.getElementById("balamount"+varSerialNumber3+"").value=0.00;
document.getElementById("totalamt").value=0.00;
document.getElementById("amount"+varSerialNumber3+"").value=0.00;
document.getElementById("returnquantity"+varSerialNumber3+"").value = 0;
document.getElementById("returnquantity"+varSerialNumber3+"").focus();
return false;
}
if(returnquantity <= qnty1)
{
var balancequantity=parseFloat(qnty1)-parseFloat(returnquantity);

document.getElementById("balamount"+varSerialNumber3+"").value=balancequantity;

var rate=document.getElementById("rate"+varSerialNumber3+"").value;

var newamount=rate * returnquantity;
document.getElementById("amount"+varSerialNumber3+"").value=newamount.toFixed(2);
for(i=1;i<=totalcount1;i++)
{
var totalamount=document.getElementById("amount"+i+"").value;

if(totalamount == "")
{
totalamount=0;
}
//alert(totalamount);
grandtotal=parseFloat(grandtotal)+parseFloat(totalamount);

}
//alert(grandtotal);
document.getElementById("totalamt").value=grandtotal.toFixed(2);
return true;
}
}
}
else
{
var dum=0;
document.getElementById("balamount"+varSerialNumber3+"").value=0;
document.getElementById("amount"+varSerialNumber3+"").value=dum.toFixed(2);
for(i=1;i<=totalcount1;i++)
{
var totalamount=document.getElementById("amount"+i+"").value;

if(totalamount == "")
{
totalamount=0;
}
grandtotal=parseFloat(grandtotal)+parseFloat(totalamount);
}
document.getElementById("totalamt").value=grandtotal.toFixed(2);
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
.style1 {
	font-size: 36px;
	font-weight: bold;
}
.style2 {
	font-size: 18px;
	font-weight: bold;
}
.bal
{
border-style:none;
background:none;
text-align:right;
}
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }

</style>
<?php
$patientcode = $_REQUEST["patientcode"];
$visitcode = $_REQUEST["visitcode"];
$docnumber=$_REQUEST['docnumber'];
?>
<script src="js/datetimepicker_css.js"></script>
<?php
if($visitcode!='walkinvis')
{
$query65= "select * from master_ipvisitentry where patientcode='$patientcode'";
$exec65=mysql_query($query65) or die("error in query65".mysql_error());
$res65=mysql_fetch_array($exec65);
$Patientname=$res65['patientfullname'];

$query69="select * from master_customer where customercode='$patientcode'";
$exec69=mysql_query($query69) or die(mysql_error());
$res69=mysql_fetch_array($exec69);
$patientage=$res69['age'];
$patientgender=$res69['gender'];
$patientaccount=$res69['accountname'];

$query70="select * from master_accountname where auto_number='$patientaccount'";
$exec70=mysql_query($query70);
$res70=mysql_fetch_array($exec70);
$accountname=$res70['accountname'];
$accountnameid=$res70['id'];
}
else
{
$query65= "select * from master_consultationpharmissue where docnumber='$docnumber'";
$exec65=mysql_query($query65) or die("error in query65".mysql_error());
$res65=mysql_fetch_array($exec65);
$billno=$res65['billnumber'];
$query69="select * from prescription_externalpharmacy where billnumber='$billno'";
$exec69=mysql_query($query69) or die(mysql_error());
$res69=mysql_fetch_array($exec69);
$Patientname=$res69['patientname'];
$patientage=$res69['age'];
$patientgender=$res69['gender'];
$patientaccount=$res69['accountname'];
}
$query764 = "select * from master_financialintegration where field='pharmacypaylaterrefund'";
$exec764 = mysql_query($query764) or die(mysql_error());
$res764 = mysql_fetch_array($exec764);

$pharmacycoa = $res764['code'];


$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$paynowbillprefix = 'PRF-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from pharmacysalesreturn_details where ipdocno = '' order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["billnumber"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='PRF-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["billnumber"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'PRF-'.$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}

/*echo $queryget = "select pd.locationname,pd.locationcode,ms.storecode FROM pharmacysales_details as pd LEFT JOIN master_store as ms ON pd.store = ms.store WHERE pd.patientcode = '".$patientcode."' AND pd.visitcode = '".$visitcode."'";*/
 $queryget = "select locationname,locationcode,store FROM pharmacysales_details WHERE patientcode = '".$patientcode."' AND visitcode = '".$visitcode."' and ipdocno = '".$getdocnumber."'";

$execget = mysql_query($queryget) or die(mysql_error());
$resget = mysql_fetch_array($execget);

 $getlocationname = $resget['locationname'];
 $getlocationcode = $resget['locationcode'];
//echo $getstorename = $resget['store'];
  $getstorecode = $resget['store'];
 $queryget1 = "select store FROM master_store  WHERE storecode='".$getstorecode."'";

$execget1 = mysql_query($queryget1) or die(mysql_error());
$resget1 = mysql_fetch_array($execget1);

  $getstorename = $resget1['store'];
?>
</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="frmsales" id="frmsales" method="post" action="ipmedicinereturn.php" onKeyDown="return disableEnterKey(event)" onSubmit="return validcheck()">
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
    <td colspan="4" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo 'red'; } ?>" class="bodytext3"><strong><?php echo $errmsg;?>&nbsp;</strong></td></tr>
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
              
                    <input name="billnumberprefix" id="billnumberprefix" value="<?php echo $billnumberprefix; ?>" type="hidden" style="border: 1px solid #001E6A"  size="5" /> 
                    <input type="hidden" name="patientcode" value="<?php echo $patientcode; ?>">
               <td bgcolor="#CCCCCC" class="bodytext3"><strong>Patient  * </strong></td>
	  <td width="25%" align="left" valign="top" bgcolor="#CCCCCC">
				<input name="customername" id="customer" value="<?php echo $Patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/>
                  </td>
                          <td bgcolor="#CCCCCC" class="bodytext3"><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5"> <strong>Date </strong></td>
				
                  <input name="billnumberpostfix" id="billnumberpostfix" value="<?php echo $billnumberpostfix; ?>" style="border: 1px solid #001E6A"  size="5" type="hidden" />
                
                <td  colspan="5" bgcolor="#CCCCCC" class="bodytext3">
               
                  <input name="ADate" id="ADate" style="border: 1px solid #001E6A" value="<?php echo $dateonly; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                  <img src="images2/cal.gif" style="cursor:pointer"/>
				</td>
               
               
              </tr>
			 
		
			  <tr>

			    <td width="5%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Visit Code</strong></td>
                <td width="25%" align="left" valign="top" >
			<input name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
                  </td>
                 <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Patient code </strong></td>
                <td colspan="3" align="left" valign="top" >
				<input name="customercode" id="customercode" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				
				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>
                 <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Location </strong></td>
                <td width="12%" colspan="3" align="left" valign="top" >
				<input name="customercode" id="customercode" value="<?php echo $getlocationname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>		<input type="hidden" name="getlocationcode" value="<?php echo $getlocationcode; ?>">
                <input type="hidden" name="getlocationname" value="<?php echo $getlocationname; ?>">
				
				</td>
             
			    </tr>
				  <tr>

			  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="style4"></span><strong>Age &amp; Gender </strong></td>
			    <td align="left" valign="middle" >
				<input type="text" name="patientage" id="patientage" value="<?php echo $patientage; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly>
				&
				<input type="text" name="patientgender" id="patientgender" value="<?php echo $patientgender; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly>
				     </td>
                <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Account</strong></td>
                <td colspan="3" align="left" valign="top" >
				<input name="account" id="account" value="<?php echo $accountname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
                <input type="hidden" name="accountnameid" id="accountnameid" value="<?php echo $accountnameid; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
                <input type="hidden" name="accountnameano" id="accountnameano" value="<?php echo $patientaccount; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
                
				<input type="hidden" name="pharmacycoa" value="<?php echo $pharmacycoa; ?>"></td>
                 <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Store</strong></td>
                <td colspan="3" align="left" valign="top" >
				<input  value="<?php echo $getstorename; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<input type="hidden" name="getstorecode" value="<?php echo $getstorecode; ?>"></td>
				
				  </tr>
				  <tr>
				      <td width="5%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Return No </strong></td>
                <td colspan="3" align="left" valign="top" >
				<input name="billnumber" id="billnumber" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
			</td>
				  </tr>
				  
			   
			   
				  <tr>
				  <td width="5%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>&nbsp;</strong></td>
              
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
					<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Refund</strong></div></td>
              <td width="18%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Medicine</strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Batch No</strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Avl. Qty</strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Iss. Qty</strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Ret. Qty</strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Ref. Qty</strong></div></td>
			<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bal. Qty</strong></div></td>
			<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate</strong></div></td>
			<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount</strong></div></td>
			
			      </tr>
				  		<?php
						/* $ippharmauotnum=$_REQUEST['ippharmauotnum'];
						 $salseautonumber=$_REQUEST['salseautonumber'];
						 $locationcode=$_REQUEST['location'];*/
						$queryentry = "select locationname,locationcode from master_ipvisitentry where patientcode = '$patientcode' and visitcode = '$visitcode' ";
						   $execentry = mysql_query($queryentry) or die(mysql_error());
						   $resentry = mysql_fetch_array($execentry);
							$locationname = $resentry['locationname'];
							$locationcode = $resentry['locationcode'];

			$colorloopcount = '';
			$sno = '';
			$ssno=0;
			$nno=0;
			$totalamount=0;		
			$totalavaquantity=0;
			$totalavaquantity1=0;
			$query71 = "select * from pharmacysales_details where locationcode='".$locationcode."' and  patientcode = '$patientcode' and visitcode = '$visitcode' and ipdocno='$docnumber' ";
$exec71 = mysql_query($query71) or die ("Error in Query1".mysql_error());
$numb=mysql_num_rows($exec71);
//echo $numb;
while($res71 = mysql_fetch_array($exec71))
	{
	$totalavaquantity1=0;
	$itemcode=$res71["itemcode"];
$batchnumber=$res71["batchnumber"];
$quantity=$res71["quantity"];
$patientnames=$res71["patientname"];
$fifo_code=$res71["fifo_code"];
 $query721 = "select * from paylaterpharmareturns where locationcode='".$locationcode."' and patientname='$patientnames' and patientvisitcode = '$visitcode' and medicinecode='$itemcode'";
$exec721 = mysql_query($query721) or die ("Error in Query721".mysql_error());
 $numbr1=mysql_num_rows($exec721);
 $res721 = mysql_fetch_array($exec721);
 $billnumber=$res721['billnumber'];
 $query72 = "select * from pharmacysalesreturn_details where locationcode='".$locationcode."' and  patientcode = '$patientcode' and visitcode = '$visitcode' and itemcode='$itemcode' and batchnumber='$batchnumber' and docnumber='".$docnumber."' and salseautonumber='".$salseautonumber."'";
$exec72 = mysql_query($query72) or die ("Error in Query1".mysql_error());
$numbr=mysql_num_rows($exec72);
//echo $numbr;
while($res72 = mysql_fetch_array($exec72))
{
$avaquantity1=$res72['quantity'];
$totalavaquantity1=$totalavaquantity1+$avaquantity1;
}
$resquantity=$quantity - $totalavaquantity1;
//echo $resquantity;


$nno=$nno+1;
	
	}	
	//echo $nno;
			$query61 = "select * from pharmacysales_details where locationcode='".$locationcode."' and patientcode = '$patientcode' and visitcode = '$visitcode' and ipdocno='$docnumber'";
$exec61 = mysql_query($query61) or die ("Error in Query1".mysql_error());
$num=mysql_num_rows($exec61);
//echo $num;
while($res61 = mysql_fetch_array($exec61))
{
$totalavaquantity=0;
 $itemname =$res61["itemname"];
$itemcode=$res61["itemcode"];
$batchnumber=$res61["batchnumber"];
$quantity=$res61["quantity"];
$rate=$res61["rate"];
$patientnames=$res61["patientname"];
$fifo_code=$res61["fifo_code"];
$query621 = "select * from paylaterpharmareturns where locationcode='".$locationcode."' and  patientname='$patientnames' and patientvisitcode = '$visitcode' and medicinecode='$itemcode'";
$exec621 = mysql_query($query621) or die ("Error in Query621".mysql_error());
$numbr621=mysql_num_rows($exec621);
$res621 = mysql_fetch_array($exec621);
$billnumber=$res621['billnumber'];
$query62 = "select * from pharmacysalesreturn_details where locationcode='".$locationcode."' and  patientcode = '$patientcode' and visitcode = '$visitcode' and itemcode='$itemcode' and batchnumber='$batchnumber' and docnumber='".$docnumber."' and salseautonumber='".$salseautonumber."'";
$exec62 = mysql_query($query62) or die ("Error in Query1".mysql_error());
$numbr=mysql_num_rows($exec62);
//echo $numbr;
while($res62 = mysql_fetch_array($exec62))
{
$avaquantity=$res62['quantity'];
 $totalavaquantity=$totalavaquantity+$avaquantity;
}
$resquantity=$quantity - $totalavaquantity;
 $refundedquantity=$totalavaquantity;
 $balanceqty=$quantity-$refundedquantity;
$sno=$sno+1;
$quantity=intval($quantity);

 $returnqty='';
		   $queryrefund = "select sum(return_quantity) as return_total,docno,refno,issue_quantity,rateperunit,freestatus from medicine_return_request where patientcode = '$patientcode' and visitcode = '$visitcode' and itemcode='".$itemcode."' and refno='".$docnumber."' and refundstatus <> 'refund'  and completestatus <> 'complete'";
		   $execrefund = mysql_query($queryrefund) or die(mysql_error());
		   while($resrefund = mysql_fetch_array($execrefund))
		   {
		   $returnqty = $resrefund['return_total'];
		   $docnoget = $resrefund['docno'];
		   $refnoget = $resrefund['refno'];
		   $issuequantity=$resrefund['issue_quantity'];
		   $rateperunit=$resrefund['rateperunit'];
		   $freestatus=$resrefund['freestatus'];

 $query02 = "select batch_quantity from transaction_stock where storecode='".$storecode."' AND locationcode='".$locationcode."' AND itemcode = '$itemcode' and batch_stockstatus='1'"; 
 $res02=mysql_query($query02);
$num02=mysql_fetch_array($res02);
$qty=$num02['batch_quantity'];
		   
?>
  <tr>
  <td class="bodytext31" valign="center"  align="left"><div align="center">
        <input type="checkbox" name="ref[]" id="ref<?php echo $sno; ?>" value="<?php echo $itemcode; ?>" onClick="updatebox('<?php echo $sno; ?>','<?php echo $resquantity;?>','<?php echo $nno; ?>')"/></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $itemname;?></div></td>
		<input type="hidden" name="med[]" value="<?php echo $itemname;?>">
		<input type="hidden" name="code[]" value="<?php echo $itemcode; ?>">
        <input type="hidden" name="fifo_code[]" value="<?php echo $fifo_code; ?>">
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $batchnumber;?></div></td>
			<input type="hidden" name="batch[]" value="<?php echo $batchnumber;?>">
            <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $qty;?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $quantity;?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="returnquantity[]" id="returnquantity<?php echo $sno; ?>" onKeyUp="balancecalc('<?php echo $sno; ?>','<?php echo $resquantity;?>','<?php echo $nno; ?>')"size="7" value="<?php echo $returnqty;?>"></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refundedquantity;?>
            
            <input type="hidden" class="bal" name="docnoget[]" id="docnoget<?php echo $sno; ?>" size="7" readonly value="<?php echo $docnoget; ?>">
            <input type="hidden" class="bal" name="refnoget[]" id="refnoget<?php echo $sno; ?>" size="7" readonly value="<?php echo $refnoget; ?>">
            <input type="hidden" class="bal" name="issuequantity[]" id="issuequantity<?php echo $sno; ?>" size="7" readonly value="<?php echo $issuequantity; ?>">
            <input type="hidden" class="bal" name="rateperunit[]" id="rateperunit<?php echo $sno; ?>" size="7" readonly value="<?php echo $rateperunit; ?>">
            <input type="hidden" class="bal" name="freestatus[]" id="freestatus<?php echo $sno; ?>" size="7" readonly value="<?php echo $freestatus; ?>">
            </div></td>
			<input type="hidden" name="quantity[]" value="<?php echo $resquantity;?>">
		   <td class="bodytext31" valign="center" bordercolor="#f3f3f3"><input type="text" class="bal" name="balamount[]" id="balamount<?php echo $sno; ?>" size="7" readonly value="<?php echo $balanceqty; ?>"></td>
         <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $rate;?><input type="hidden" name="rate[]" id="rate<?php echo $sno; ?>" value="<?php echo $rate;?>"></div></td>
		 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" class="bal" name="amount[]" id="amount<?php echo $sno; ?>" size="7" readonly></div></td>
		 <input type="hidden" name="docnumber[]" value="<?php echo $docnumber;?>">
           <input type="hidden" name="salseautonumber[]" value="<?php echo $salseautonumber;?>">
						</tr>
			<?php 
		}}
		
			
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
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc"><strong>Total Refund</strong></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc"><strong>Total Refund</strong></td>
              <td class="bodytext31" valign="center"  align="center" 
                bgcolor="#cccccc"><input type="text" name="totalamt" id="totalamt" size="7" class="bal"></td>
         
             </tr>
           
          </tbody>
        </table>		</td>
      </tr>
       
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr>
              <td width="54%" align="right" valign="top" >
                     <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
             	  <input name="Submit2223" type="submit" value="Save" onClick="return check();" accesskey="b" class="button" style="border: 1px solid #001E6A"/>
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