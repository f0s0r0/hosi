<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$updatedate = date('Y-m-d');
$suppliername="";
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$locdocno = $_SESSION['docno'];

$query = "select * from login_locationdetails where username='$username' and docno='$locdocno' order by locationname";
$exec = mysql_query($query) or die ("Error in Query1".mysql_error());
$res = mysql_fetch_array($exec);
	
	$res12location = $res["locationname"];
	$res12locationcode = $res["locationcode"];
	$res12locationanum = $res["auto_number"];

//This include updatation takes too long to load for hunge items database.


if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select * from master_supplier where auto_number = '$getcanum'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	$res4 = mysql_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
$docnum = $_REQUEST['docno'];

foreach($_POST['billnum2'] as $key => $value)
		{
		$billnum2=$_POST['billnum2'][$key];
		
		foreach($_POST['acknow1'] as $check1)
		{
		$acknow1=$check1;
		
		if($acknow1==$billnum2)
		{
		 $query8="update master_transactionpaylater set recordstatus = 'deallocated', acc_flag = '1' where docno='$docnum' and billnumber='$billnum2'";
		$exec8=mysql_query($query8) or die(mysql_error());
		$query991="update billing_ipprivatedoctor set billstatus='unpaid' where docno='$billnum2'";
		$exec991=mysql_query($query991);
		$query84="update master_transactionpaylater set acc_flag = '0' where billnumber='$billnum2' and recordstatus <> 'deallocated'";
		$exec84=mysql_query($query84) or die(mysql_error());
		}
		}
		}
header("location:accountreceivableentry.php?docno=$docnum");
}

if (isset($_REQUEST["frmflag23"])) { $frmflag23 = $_REQUEST["frmflag23"]; } else { $frmflag23 = ""; }
//$frmflag2 = $_POST['frmflag2'];

if ($frmflag23 == 'frmflag23')
{

$docnum1 = $_REQUEST['docno1'];
$date1 = $_REQUEST['date1'];
$bankname1 = $_REQUEST['bankname1'];
$number1 = $_REQUEST['number1'];
$paymentmode = $_REQUEST['paymentmode'];
$receivableamount = $_REQUEST['receivableamount1'];
$receivableamount=str_replace(',', '', $receivableamount);
foreach($_POST['billnum'] as $key => $value)
		{
		$billnum=$_POST['billnum'][$key];
		$name=$_POST['name'][$key];
		$accountname=$_POST['accountname'][$key];
		$accountnameano=$_POST['accountnameano'][$key];
		$patientcode=$_POST['patientcode'][$key];
		$visitcode=$_POST['visitcode'][$key];
		$doctorname=$_POST['doctorname'][$key];
		//echo $doctorname;
		$balamount=$_POST['balamount'][$key];
		$balamount=str_replace(',', '', $balamount);
		$query55 = "select * from master_accountname where auto_number='$accountnameano'";
		$exec55 = mysql_query($query55) or die(mysql_error());
		$res55 = mysql_fetch_array($exec55);
		$paytype = $res55['paymenttype'];
		$subpaytype = $res55['subtype'];
		$querytype1=mysql_query("select * from master_paymenttype where auto_number='$paytype'");
		$exectype1=mysql_fetch_array($querytype1);
		$patienttype11=$exectype1['paymenttype'];
		
		$querysubtype1=mysql_query("select * from master_subtype where auto_number='$subpaytype'");
		$execsubtype1=mysql_fetch_array($querysubtype1);
		$patientsubtype11=$execsubtype1['subtype'];
		//echo $balamount;
		if($balamount == 0.00)
		{
		$billstatus='paid';
		}
		else
		{
		$billstatus='unpaid';
		}
		$billnumberprefix = '';
		$billnumber = '';
		$billanum = '';
		$remarks = '';
		$bankbranch = '';
		$transactionmodule = '';
		//echo $billstatus;
		$adjamount=$_POST['adjamount'][$key];
		$adjamount=str_replace(',', '', $adjamount);
		foreach($_POST['ack'] as $check)
		{
		$acknow=$check;
		if($acknow==$billnum)
		{
		$query99="update billing_paylater set billstatus='$billstatus' where billno='$billnum'";
		$exec99=mysql_query($query99);
		$query89="update refund_paylater set billstatus='$billstatus' where finalizationbillno='$billnum'";
		$exec99=mysql_query($query89);
		$query991="update billing_ipprivatedoctor set billstatus='$billstatus' where docno='$billnum'";
		$exec991=mysql_query($query991);
		
		$query9912="update master_transactionpaylater set acc_flag='1' where billnumber='$billnum'";
		$exec9912=mysql_query($query9912);
		
		$query87 ="select * from master_transactionpaylater where billnumber='$billnum' and transactiontype='PAYMENT' and docno='$docnum1' and recordstatus = 'allocated'";
		$exec87 = mysql_query($query87) or die(mysql_error());
		$num87 = mysql_num_rows($exec87);
		if($num87 == 0)
		{
		
		if($adjamount != 0)
		{
		
		if ($paymentmode == 'CASH')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CASH';
		$particulars = 'BY CASH '.$billnumberprefix.$billnumber.'';	
		
		$query9 = "insert into master_transactionpaylater (transactiondate, particulars, 
		transactionmode, transactiontype, transactionamount, cashamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,docno,billbalanceamount,recordstatus,receivableamount,paymenttype,subtype,username,accountnameano,accountnameid,locationcode,locationname) 
		values ('$updatedatetime', '$particulars', 
		'$transactionmode', '$transactiontype', '$adjamount', '$adjamount', 
		'$billnum',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule','$name','$patientcode','$visitcode','$accountname','$doctorname','$billstatus','$docnum1','$balamount','allocated','$receivableamount','$patienttype11','$patientsubtype11','$username','$accountnameano','$accountnameid','$res12locationcode','$res12location')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		}
		if ($paymentmode == 'ONLINE')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'ONLINE';
		$particulars = 'BY ONLINE '.$billnumberprefix.$billnumber.'';	
	
		$query9 = "insert into master_transactionpaylater (transactiondate, particulars,
		transactionmode, transactiontype, transactionamount, onlineamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,docno,billbalanceamount,recordstatus,receivableamount,paymenttype,subtype,username,accountnameano,accountnameid,locationcode,locationname) 
		values ('$updatedatetime','$particulars', 
		'$transactionmode', '$transactiontype', '$adjamount', '$adjamount', 
		'$billnum',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule','$name','$patientcode','$visitcode','$accountname','$doctorname','$billstatus','$docnum1','$balamount','allocated','$receivableamount','$patienttype11','$patientsubtype11','$username','$accountnameano','$accountnameid','$res12locationcode','$res12location')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());

		}
		if ($paymentmode == 'CHEQUE')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CHEQUE';
		$particulars = 'BY CHEQUE '.$billnumberprefix.$billnumber;		
	
		$query9 = "insert into master_transactionpaylater (transactiondate, particulars,
		transactionmode, transactiontype, transactionamount,
		chequeamount,chequenumber, billnumber, billanum, 
		chequedate, bankname, bankbranch, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,docno,billbalanceamount,recordstatus,receivableamount,paymenttype,subtype,username,accountnameano,accountnameid,locationcode,locationname) 
		values ('$updatedatetime', '$particulars', 
		'$transactionmode', '$transactiontype', '$adjamount',
		'$adjamount','$number1',  '$billnum',  '$billanum', 
		'$date1', '$bankname1', '$bankbranch','$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', 
		'$remarks', '$transactionmodule','$name','$patientcode','$visitcode','$accountname','$doctorname','$billstatus','$docnum1','$balamount','allocated','$receivableamount','$patienttype11','$patientsubtype11','$username','$accountnameano','$accountnameid','$res12locationcode','$res12location')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
	
		}
		if ($paymentmode == 'WRITEOFF')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'WRITEOFF';
		$particulars = 'BY WRITEOFF '.$billnumberprefix.$billnumber;		
		
		$query9 = "insert into master_transactionpaylater (transactiondate, particulars,  
		transactionmode, transactiontype, transactionamount, writeoffamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,docno,billbalanceamount,recordstatus,receivableamount,paymenttype,subtype,username,accountnameano,accountnameid,locationcode,locationname) 
		values ('$updatedatetime', '$particulars',
		'$transactionmode', '$transactiontype', '$adjamount', '$adjamount', 
		'$billnum',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule','$name','$patientcode','$visitcode','$accountname','$doctorname','$billstatus','$docnum1','$balamount','allocated','$receivableamount','$patienttype11','$patientsubtype11','$username','$accountnameano','$accountnameid','$res12locationcode','$res12location')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());

		}
		if ($paymentmode == 'By Credit Note')
		{
		$transactiontype = 'PAYMENT';
		$transactionmode = 'CREDIT NOTE';
		$particulars = 'BY CREDIT NOTE '.$billnumberprefix.$billnumber;		
	
		$query9 = "insert into master_transactionpaylater (transactiondate, particulars,  
		transactionmode, transactiontype, transactionamount, writeoffamount,
		billnumber, billanum, ipaddress, updatedate, balanceamount, companyanum, companyname, remarks, 
		transactionmodule,patientname,patientcode,visitcode,accountname,doctorname,billstatus,docno,billbalanceamount,recordstatus,receivableamount,paymenttype,subtype,username,accountnameano,accountnameid,locationcode,locationname) 
		values ('$updatedatetime', '$particulars',
		'$transactionmode', '$transactiontype', '$adjamount', '$adjamount', 
		'$billnum',  '$billanum', '$ipaddress', '$updatedate', '$balanceamount', '$companyanum', '$companyname', '$remarks', 
		'$transactionmodule','$name','$patientcode','$visitcode','$accountname','$doctorname','$billstatus','$docnum1','$balamount','allocated','$receivableamount','$patienttype11','$patientsubtype11','$username','$accountnameano','$accountnameid','$res12locationcode','$res12location')";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());

		}
		}
		}
		else
		{
		$totalaadjamount =0;
		$query67 = "select * from master_transactionpaylater where billnumber='$billnum' and transactiontype='PAYMENT' and docno='$docnum1'";
		$exec67 = mysql_query($query67) or die(mysql_error());
		while($res67 = mysql_fetch_array($exec67))
		{
		$existingamt = $res67['transactionamount'];
		$totalaadjamount = $totalaadjamount + $existingamt;
		}
		$restotalaadjamount = $totalaadjamount + $adjamount;
	
		if ($paymentmode == 'CASH')
		{
		$query45 = "update master_transactionpaylater set recordstatus='allocated',transactionamount='$restotalaadjamount',cashamount='$restotalaadjamount',billbalanceamount='$balamount',transactiondate='$updatedatetime',username='$username' where billnumber='$billnum' and transactiontype='PAYMENT' and docno='$docnum1'";
		$exec45 = mysql_query($query45) or die(mysql_error());
		}
		
		if ($paymentmode == 'ONLINE')
		{
		$query45 = "update master_transactionpaylater set recordstatus='allocated',transactionamount='$restotalaadjamount',onlineamount='$restotalaadjamount',billbalanceamount='$balamount',transactiondate='$updatedatetime',username='$username' where billnumber='$billnum' and transactiontype='PAYMENT' and docno='$docnum1'";
		$exec45 = mysql_query($query45) or die(mysql_error());
    	}
		if ($paymentmode == 'CHEQUE')
		{
		$query45 = "update master_transactionpaylater set recordstatus='allocated',transactionamount='$restotalaadjamount',chequeamount='$restotalaadjamount',billbalanceamount='$balamount',transactiondate='$updatedatetime',username='$username' where billnumber='$billnum' and transactiontype='PAYMENT' and docno='$docnum1'";
		$exec45 = mysql_query($query45) or die(mysql_error());
    
		}
		if ($paymentmode == 'WRITEOFF')
		{
		$query45 = "update master_transactionpaylater set recordstatus='allocated',transactionamount='$restotalaadjamount',writeoffamount='$restotalaadjamount',billbalanceamount='$balamount',transactiondate='$updatedatetime',username='$username' where billnumber='$billnum' and transactiontype='PAYMENT' and docno='$docnum1'";
		$exec45 = mysql_query($query45) or die(mysql_error());
    	
		}
		if ($paymentmode == 'By Credit Note')
		{
		$query45 = "update master_transactionpaylater set recordstatus='allocated',transactionamount='$restotalaadjamount',writeoffamount='$restotalaadjamount',billbalanceamount='$balamount',transactiondate='$updatedatetime',username='$username' where billnumber='$billnum' and transactiontype='PAYMENT' and docno='$docnum1'";
		$exec45 = mysql_query($query45) or die(mysql_error());
    	
		}
		$query9912="update master_transactionpaylater set acc_flag='0' where billnumber='$billnum' and recordstatus='allocated'";
		$exec9912=mysql_query($query9912);
		}
	}
	}
	}
	header("location:accountreceivableentry.php?docno=$docnum1");
}

include ("autocompletebuild_accounts1.php");

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == '1')
{
	$errmsg = "Success. Payment Entry Update Completed.";
}
if ($st == '2')
{
	$errmsg = "Failed. Payment Entry Not Completed.";
}
if(isset($_REQUEST['docno']))
{
$docno = $_REQUEST['docno'];
}
$totalamount=0;
$query5="select * from master_transactionpaylater where docno='$docno' group by docno";
$exec5 = mysql_query($query5) or die(mysql_error());
$res5 = mysql_fetch_array($exec5);
$entrydate = $res5['transactiondate'];
$totalamount = $res5['receivableamount'];		  
$receivableamount = $totalamount;
$paymentmode = $res5['transactionmode'];
if($paymentmode == '')
{
$paymentmode = 'By Credit Note';
}
$number = $res5['chequenumber'];
$date = $res5['chequedate'];
$bankname = $res5['bankname'];
$suppliername = $res5['accountname'];
$accountnameano = $res5['accountnameano'];
$accountnameid = $res5['accountnameid'];

$query91 = "select auto_number, id, accountname, subtype from master_accountname where id = '$accountnameid' and auto_number = '$accountnameano' and recordstatus <> 'deleted'";
$exec91 = mysql_query($query91) or die ("Error in Query91".mysql_error());
$res91 = mysql_fetch_array($exec91);
$subtypeanum = $res91['subtype'];
?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>

<script>
function updatebox1(varSerialNumber6,billamt6,totalcount6)
{

var grandtotalamt = 0;
var varSerialNumber6 = varSerialNumber6;
var totalcount6=totalcount6;
var billamt6 = billamt6;
  
  document.getElementById("amt"+varSerialNumber6+"").value='';
if(document.getElementById("acknow1"+varSerialNumber6+"").checked == true)
{
    
		var totalbillamt6=document.getElementById("totaladjamt1").value;
	if(totalbillamt6 == 0.00)
{
totalbillamt6=0;
}
				totalbillamt6=parseFloat(totalbillamt6)+parseFloat(billamt6);
			document.getElementById("amt"+varSerialNumber6+"").value=billamt6;
document.getElementById("totaladjamt1").value=totalbillamt6.toFixed(2);
}
else
{
//alert(totalcount1);
for(j=1;j<=totalcount6;j++)
{
var totalamt=document.getElementById("amt"+j+"").value;

if(totalamt == "")
{
totalamt=0;
}
grandtotalamt=grandtotalamt+parseFloat(totalamt);
}


document.getElementById("totaladjamt1").value=grandtotalamt.toFixed(2);

 }  
}

function updatebox(varSerialNumber,billamt,totalcount1)
{

var adjamount1;
var grandtotaladjamt2=0;

var varSerialNumber = varSerialNumber;
var totalcount1=document.getElementById("totalrow").value;

var billamt = billamt;
  var textbox = document.getElementById("adjamount"+varSerialNumber+"");
    textbox.value = "";
if(document.getElementById("acknowpending"+varSerialNumber+"").checked == true)
{

    if(document.getElementById("acknowpending"+varSerialNumber+"").checked) {
        textbox.value = billamt;
    }
	
	var balanceamt=billamt-billamt;
	if(balanceamt == 0.00)
	{
	balanceamt=0;
	}
	
	document.getElementById("balamount"+varSerialNumber+"").value=balanceamt.toFixed(2);
	
	var totalbillamt=document.getElementById("totaladjamt").value;
	
	if(totalbillamt == 0.00)
{
totalbillamt=0;
}
				totalbillamt=parseFloat(totalbillamt)+parseFloat(billamt);

document.getElementById("totaladjamt").value = totalbillamt.toFixed(2);

for(j=1;j<=totalcount1;j++)
{
var totaladjamount2=document.getElementById("adjamount"+j+"").value;

if(totaladjamount2 == "")
{
totaladjamount2=0;
}
grandtotaladjamt2=grandtotaladjamt2+parseFloat(totaladjamount2);
}
//alert(grandtotaladjamt);
grandtotaladjamt2=grandtotaladjamt2.toFixed(2);
grandtotaladjamt2 = grandtotaladjamt2.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
document.getElementById("totaladjamt").value=grandtotaladjamt2;
return false;

}
else
{

//alert(totalcount1);
for(j=1;j<=totalcount1;j++)
{
var totaladjamount2=document.getElementById("adjamount"+j+"").value;

if(totaladjamount2 == "")
{
totaladjamount2=0;
}
grandtotaladjamt2=grandtotaladjamt2+parseFloat(totaladjamount2);
}
//alert(grandtotaladjamt);

document.getElementById("totaladjamt").value=grandtotaladjamt2.toFixed(2);

 }  
}

function totalamountcheck(totalcount7,grandtotalamt1)
{
var totalcount7=totalcount7;
var grandtotalamt1=grandtotalamt1;
//alert(totalcount7);

document.getElementById("submit1").disabled=true;
var receivableamount = document.getElementById("receivableamount").value;

var checkamount= document.getElementById("totaladjamt").value;
checkamount = checkamount.replace(/,/g,'');
receivableamount = receivableamount.replace(/,/g,'');
if(checkamount == 0.00)
{
alert("Adjustable amount cannot be Zero");
document.getElementById("submit1").disabled=false;
return false;
}
//alert(receivableamount);
if((parseFloat(checkamount)) > (parseFloat(receivableamount)))
{
alert("Allocated amount is greater than Receivable amount");
document.getElementById("submit1").disabled=false;
return false;
}
var checkamount2 = parseInt(checkamount) + parseInt(grandtotalamt1);
var checkamount1= document.getElementById("receivableamount").value;
if(parseInt(checkamount2) > parseInt(checkamount1))
{
alert("Allocated amount is greater than Receivable amount");
document.getElementById("submit1").disabled=false;
return false;

}
FuncPopup();
document.form2.submit();
return true;
}

function checkboxcheck(varSerialNumber5)
{

if(document.getElementById("acknowpending"+varSerialNumber5+"").checked == false)
{
alert("Please click on the Select check box");
return false;
}
return true;
}
function balancecalc(varSerialNumber1,billamt1,totalcount)
{
var varSerialNumber1 = varSerialNumber1;
var billamt1 = billamt1;
var totalcount=document.getElementById("totalrow").value;
var grandtotaladjamt=0;

var adjamount=document.getElementById("adjamount"+varSerialNumber1+"").value;
var adjamount3=parseFloat(adjamount);
if(adjamount3 > billamt1)
{
alert("Please enter correct amount");
document.getElementById("totaladjamt").value = '0.00';
document.getElementById("adjamount"+varSerialNumber1+"").value = '0.00';
document.getElementById("balamount"+varSerialNumber1+"").value = billamt1;
document.getElementById("adjamount"+varSerialNumber1+"").focus();
return false;
}
var balanceamount=parseFloat(billamt1)-parseFloat(adjamount);

document.getElementById("balamount"+varSerialNumber1+"").value=balanceamount.toFixed(2);
for(i=1;i<=totalcount;i++)
{
var totaladjamount=document.getElementById("adjamount"+i+"").value;
if(totaladjamount == "")
{
totaladjamount=0;
}
grandtotaladjamt=grandtotaladjamt+parseFloat(totaladjamount);

}

grandtotaladjamt=grandtotaladjamt.toFixed(2);
grandtotaladjamt = grandtotaladjamt.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
document.getElementById("totaladjamt").value=grandtotaladjamt;

}
function balancecalc(varSerialNumber1,billamt1,totalcount)
{
var varSerialNumber1 = varSerialNumber1;
var billamt1 = billamt1;
var totalcount=document.getElementById("totalrow").value;
var grandtotaladjamt=0;

var adjamount=document.getElementById("adjamount"+varSerialNumber1+"").value;
var adjamount3=parseFloat(adjamount);
if(adjamount3 > billamt1)
{
alert("Please enter correct amount");
document.getElementById("totaladjamt").value = '0.00';
document.getElementById("adjamount"+varSerialNumber1+"").value = '0.00';
document.getElementById("balamount"+varSerialNumber1+"").value = billamt1;
document.getElementById("adjamount"+varSerialNumber1+"").focus();
return false;
}
var balanceamount=parseFloat(billamt1)-parseFloat(adjamount);
balanceamount=balanceamount.toFixed(2);
balanceamount = balanceamount.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
document.getElementById("balamount"+varSerialNumber1+"").value=balanceamount;
for(i=1;i<=totalcount;i++)
{
var totaladjamount=document.getElementById("adjamount"+i+"").value;
if(totaladjamount == "")
{
totaladjamount=0;
}
grandtotaladjamt=grandtotaladjamt+parseFloat(totaladjamount);

}

grandtotaladjamt=grandtotaladjamt.toFixed(2);
grandtotaladjamt = grandtotaladjamt.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
document.getElementById("totaladjamt").value=grandtotaladjamt;

}

</script>
<script type="text/javascript">


function disableEnterKey(varPassed)
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
	
	var key;
	if(window.event)
	{
		key = window.event.keyCode;     //IE
	}
	else
	{
		key = e.which;     //firefox
	}

	if(key == 13) // if enter key press
	{
		//alert ("Enter Key Press2");
		return false;
	}
	else
	{
		return true;
	}
}


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

function disableEnterKey()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
	
	var key;
	if(window.event)
	{
		key = window.event.keyCode;     //IE
	}
	else
	{
		key = e.which;     //firefox
	}
	
	if(key == 13) // if enter key press
	{
		return false;
	}
	else
	{
		return true;
	}

}

function paymententry1process2()
{
	if (document.getElementById("cbfrmflag1").value == "")
	{
		alert ("Search Bill Number Cannot Be Empty.");
		document.getElementById("cbfrmflag1").focus();
		document.getElementById("cbfrmflag1").value = "";
		return false;
	}
}


function funcPrintReceipt1()
{
	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}
function FuncPopup()
{
	window.scrollTo(0,0);
	document.getElementById("imgloader").style.display = "";
}
function acknowledgevalid()
{
	document.getElementById("submit0").disabled=true;	
	FuncPopup();
	document.cbform1.submit();
}

</script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
.bal
{
border-style:none;
background:none;
text-align:right;
}
.bali
{
text-align:right;
}
.imgloader { background-color:#FFFFFF; }
#imgloader1 {
    position: absolute;
    top: 158px;
    left: 487px;
    width: 28%;
    height: 24%;
}
</style>
</head>

<script src="js/datetimepicker_css.js"></script>

<body>
<div align="center" class="imgloader" id="imgloader" style="display:none;">
<div align="center" class="imgloader" id="imgloader1" style="display:;">
<p style="text-align:center;"><strong>Transaction in Progress <br><br> Please be patience...</strong></p>
<img src="images/ajaxloader.gif">
</div>
</div>
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
    <td colspan="10">&nbsp;</td>
  </tr>
  
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table border="0" cellspacing="0" cellpadding="0">
	
	
	
      <tr>
        <td width="709">
		
		
              <form name="cbform1" method="post" action="accountreceivableentry.php">
			<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="709" 
            align="left" border="0">
          <tbody>
		  
		  <tr>
	<td class="bodytext31" valign="center"  align="left" width="12%"><strong>DOC No
	  
	</strong></td>
	<td class="bodytext31" valign="center"  align="left"><input type="hidden" name="docnumbers" value="<?php echo $docno; ?>" size="6" class="bal"><?php echo $docno; ?></td>
	
	<td class="bodytext31" valign="center"  align="left"><strong>Account Name</strong></td>
	<td class="bodytext31" valign="center"  align="left" colspan="4"><?php echo $suppliername; ?></td>
	</tr>
	<tr>
	<td class="bodytext31" valign="center"  align="left" width="12%"><strong>Entry Date</strong></td>
	<td class="bodytext31" valign="center"  align="left"><input type="hidden" name="entrydate" value="<?php echo $entrydate; ?>" size="6" class="bal"><?php echo $entrydate; ?></td>
	<td class="bodytext31" valign="center"  align="left" width="14%"><strong>Amount</strong></td>
	<td class="bodytext31" valign="center"  align="left"><input type="hidden" name="receivableamount" id="receivableamount" value="<?php echo $receivableamount; ?>" size="6" class="bal"><?php echo number_format($receivableamount,2,'.',','); ?></td>
	<td class="bodytext31" valign="center"  align="left" width="14%"><strong>Payment Mode</strong></td>
	<td class="bodytext31" valign="center"  align="left"><input type="hidden" name="paymentmode" value="<?php echo $paymentmode; ?>" size="6" class="bal"><?php echo $paymentmode; ?></td>

	</tr>
	<tr>
	<td class="bodytext31" valign="center"  align="left" width="12%"><strong>Number</strong></td>
	<td class="bodytext31" valign="center"  align="left"><input type="hidden" name="number" value="<?php echo $number; ?>" size="6" class="bal"><?php echo $number; ?></td>
	<td class="bodytext31" valign="center"  align="left" width="14%"><strong>Date</strong></td>
	<td class="bodytext31" valign="center"  align="left"><input type="hidden" name="date" value="<?php echo $date; ?>" size="6" class="bal"><?php echo $date; ?></td>
	<td class="bodytext31" valign="center"  align="left" width="14%"><strong>Bank Name</strong></td>
	<td class="bodytext31" valign="center"  align="left"><input type="hidden" name="bankname" value="<?php echo $bankname; ?>" size="6" class="bal"><?php echo $bankname; ?></td>

	</tr>
	
             <tr>
			 <td colspan="8" bgcolor="#cccccc" class="bodytext311"><strong>Allocated Invoices</strong></td>
			 </tr>
           <tr>
                <td width="12%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>S.No</strong></td>
				<td width="25%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>Patient</strong></td>
                <td width="14%"align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bill No</strong></div></td>
                <td width="10%"align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bill Date</strong></div></td>
                <td width="15%"align="center" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Bill Amt</strong></td>
				<td width="14%"align="center" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Adj Amt</strong></td>
				<td width="20%"align="center" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Bal Amt</strong></td>
				  <td width="16%" align="center" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Select</strong></td>
                </tr>
			  <?php 
			  $colorloopcount = 0;
			  $totamount = 0;
            $query2 = "select * from master_transactionpaylater where docno='$docno' and recordstatus='allocated'";
			  $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			  $num2 = mysql_num_rows($exec2);
			 // echo $num2;
			  while ($res2 = mysql_fetch_array($exec2))
			  {
			 	  $billnumber = $res2['billnumber'];
				  $patientname = $res2['patientname'];
				  $visitcode = $res2['visitcode'];
				  if($patientname == '')
				  {
				  $query43 = "select * from master_visitentry where visitcode='$visitcode'";
				  $exec43 = mysql_query($query43) or die(mysql_error());
				  $res43 = mysql_fetch_array($exec43);
				  $patientname = $res43['patientfullname'];
				  }
				  
				  $query23 = "select * from billing_paylater where billno='$billnumber'";
				  $exec23 = mysql_query($query23) or die(mysql_error());
				  $res23 = mysql_fetch_array($exec23);
				  $billamount = $res23['totalamount'];
				  $transactiondate = $res2['transactiondate'];
				  $amount = $res2['transactionamount'];
				  $balanceamount = $res2['billbalanceamount'];
			  $totamount = $totamount + $amount;
			  
			  //$query3 = "select * from master_patientadmission where patientcode = '$res2customercode' order by auto_number desc limit 0, 1";
			  //$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
			  //$res3 = mysql_fetch_array($exec3);
			  //$res3ipnumber = $res3['ipnumber'];
			  
			  
			  $colorloopcount = $colorloopcount + 1;
			  $showcolor = ($colorloopcount & 1); 
			  $colorcode = '';
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
                <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
                <td class="bodytext31" valign="center"  align="left"><?php echo $patientname; ?>(<?php echo $visitcode; ?>)</td>
                    <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="center"><span class="bodytext32"><?php echo $billnumber; ?></span></div>
                </div></td><input type="hidden" name="billnum2[]" value="<?php echo $billnumber; ?>">
				<input type="hidden" name="docno" value="<?php echo $docno; ?>">
				  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="center"><span class="bodytext32"><?php echo $transactiondate; ?></span></div>
                </div></td>
				<td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="right"><span class="bodytext32"><?php echo $billamount; ?></span></div>
                </div></td>
					  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="right"><span class="bodytext32"><?php echo number_format($amount,2,'.',','); ?></span></div>
                </div></td><input type="hidden" name="amt" id="amt<?php echo $colorloopcount; ?>">
           <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="right"><span class="bodytext32"><?php echo number_format($balanceamount,2,'.',','); ?></span></div>
                </div></td>
                   <td class="bodytext31" valign="center"  align="left">
				  <div align="center"><input type="checkbox" name="acknow1[]" id="acknow1<?php echo $colorloopcount; ?>" value="<?php echo $billnumber; ?>" onClick="updatebox1('<?php echo $colorloopcount; ?>','<?php echo $amount; ?>','<?php echo $num2; ?>')"></div></td>
                </tr>
			  <?php
			  }
			  //}
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
                bgcolor="#cccccc">&nbsp;</td>
           	</tr>
			<tr>
			<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><strong>Total</strong>			</td>
			<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><input type="text" name="totaladjamt1" id="totaladjamt1" size="7"></td>
			</tr>
			
			<tr>
              <td class="bodytext31" align="right" valign="top" colspan="7">
                     <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
             	  <input name="Submit2223" type="submit" id="submit0" value="Save " onClick="return acknowledgevalid()" accesskey="b" class="button" style="border: 1px solid #001E6A"/>               </td>
            <td class="bodytext31" align="right" valign="top" colspan="7"><a target="_blank" href="print_accountremittances.php?docno=<?php echo $docno; ?>"> <img src="images/pdfdownload.jpg" width="30" height="30"></a></td> 
                                
		    </tr>
          </tbody>
        </table>
		</form>		</td></tr>
	  <tr>
	  <td>
	  <form action="accountreceivableentry.php" method="post" name="form2">
	  <table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="827" 
            align="left" border="0">
          <tbody>
            <tr>
              <td colspan="3" bgcolor="#cccccc" class="bodytext311"><strong>Pending Invoices</strong></td>
			  <input type="hidden" name="paymentmode" value="<?php echo $paymentmode; ?>" size="6" class="bal">
			    <input type="hidden" name="docno1" value="<?php echo $docno; ?>">
			  <input type="hidden" name="paymentmode1" value="<?php echo $paymentmode; ?>" size="6" class="bal">
			  <input type="hidden" name="date1" value="<?php echo $date; ?>" size="6" class="bal">
			  <input type="hidden" name="number1" value="<?php echo $number; ?>" size="6" class="bal">
			  <input type="hidden" name="bankname1" value="<?php echo $bankname; ?>" size="6" class="bal">
			  <input type="hidden" name="receivableamount1" id="receivableamount" value="<?php echo $receivableamount; ?>" size="6" class="bal">
      
              <td width="11%" bgcolor="#cccccc" class="bodytext311">&nbsp;</td>
              <td width="11%" bgcolor="#cccccc" class="bodytext311">&nbsp;</td>
              <td width="12%" bgcolor="#cccccc" class="bodytext311">&nbsp;</td>
              <td width="11%" bgcolor="#cccccc" class="bodytext311">&nbsp;</td>
             
          <td width="8%" bgcolor="#cccccc" class="bodytext311">&nbsp;</td>
            </tr>
            <tr>
              <td width="5%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext311"><strong>No.</strong></td>
				  <td width="5%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext311"><strong>Select</strong></td>
              <td width="37%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext311"><strong>Patient</strong></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="left"><strong>Bill No </strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" width="11%" 
                bgcolor="#ffffff"><div align="left"><strong>Bill Date </strong></div></td>
              <td width="12%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext311"><div align="right"><strong>Pending</strong></div></td>
				  <td class="bodytext31" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#ffffff"><div align="right"><strong> Adj Amt</strong></div></td>
              <td width="8%" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong> Bal Amt</strong></div></td>
            </tr>
            <?php
			$number = 0;
			$totalbalance = '';
			$sno = 0;
			
			 $cashamount21 = 0.00;
			$cardamount21 = '';
			$onlineamount21 = '';
			$chequeamount21 = '';
			$tdsamount21 = '';
			$writeoffamount21 = '';
		$totalrefundedamount=0;
			$totalnumbr='';
			$totalnumb=0;
			$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			$totalpurchase1=0;
			
			if (isset($_REQUEST["showbilltype"])) { $showbilltype = $_REQUEST["showbilltype"]; } else { $showbilltype = ""; }
			if ($showbilltype == 'All Bills')
			{
				$showbilltype = '';
			}			
			$num=0;
			$ssno = 0;
			
			$query89 = "select auto_number from master_subtype where auto_number = '$subtypeanum' and recordstatus <> 'deleted'";
			  $exec89 = mysql_query($query89) or die ("Error in Query89".mysql_error());
			  while($res89 = mysql_fetch_array($exec89))
			  {
			  $subtypeanum1 = $res89['auto_number'];
			  
			  $query90 = "select auto_number, id, accountname from master_accountname where subtype = '$subtypeanum1' and recordstatus <> 'deleted'";
			  $exec90 = mysql_query($query90) or die ("Error in Query90".mysql_error());
			  while($res90 = mysql_fetch_array($exec90))
			  {
			  $accountnameid = $res90['id'];
			  $accountnameano = $res90['auto_number'];
			  $accountname = $res90['accountname'];
			  
			$query2 = "select patientname, patientcode, visitcode, billnumber, docno, transactiondate, billbalanceamount from master_transactionpaylater where accountnameano = '$accountnameano' and transactionstatus <> 'onaccount' and acc_flag = '0'";
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			$rowcount2 = mysql_num_rows($exec2);
			
			while ($res2 = mysql_fetch_array($exec2))
			{
				$suppliername1 = $res2['patientname'];
				$patientcode = $res2['patientcode'];
				$visitcode = $res2['visitcode'];
				$doctorname='';
				$name = $suppliername1;
				$billnumber = $res2['billnumber'];
				if($billnumber == '')
				{
					$billnumber = $res2['docno'];
				}
				$billdate = $res2['transactiondate'];
				$billtotalamount = $res2['billbalanceamount'];
				$ssno = $ssno + 1;
				
				$balanceamount = $billtotalamount;
				$netpayment = '0.00';
				$billtotalamount = number_format($billtotalamount, 2, '.', '');
				$netpayment = number_format($netpayment, 2, '.', '');
				$balanceamount = number_format($balanceamount, 2, '.', '');
				
				$billstatus = $billtotalamount.'||'.$netpayment.'||'.$balanceamount;

			
			$billdate = substr($billdate, 0, 10);
			$date1 = $billdate;

			$dotarray = explode("-", $billdate);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$billdate = strtoupper(date("d-M-Y", mktime(0, 0, 0, $dotmonth, $dotday, $dotyear)));

			$billtotalamount = number_format($billtotalamount, 2, '.', '');
			$netpayment = number_format($netpayment, 2, '.', '');
			$balanceamount = number_format($balanceamount, 2, '.', '');
			
			//echo $balanceamount;
			if ($balanceamount != '0.00')
			{
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
			

			//if ($balanceamount != 0.00)
			//{
			?>
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><?php echo $sno = $sno + 1; ?></td>
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left">
			  <input type="checkbox" name="ack[]" id="acknowpending<?php echo $sno; ?>" value="<?php echo $billnumber; ?>" onClick="updatebox('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')"></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div class="bodytext311"><?php echo $name; ?>(<?php echo $visitcode; ?>)</div></td>
			  <input type="hidden" name="patientcode[]" id="patientcode" value="<?php echo $patientcode; ?>">
			  <input type="hidden" name="visitcode[]" id="visitcode" value="<?php echo $visitcode; ?>">
			  <input type="hidden" name="accountname[]" id="accountname" value="<?php echo $suppliername; ?>">
			  <input type="hidden" name="doctorname[]" value="<?php echo $doctorname; ?>">
			  <input type="hidden" name="docno1" value="<?php echo $docno; ?>">
			  <input type="hidden" name="paymentmode1" value="<?php echo $paymentmode; ?>" size="6" class="bal">
			  <input type="hidden" name="date1" value="<?php echo $date; ?>" size="6" class="bal">
			  <input type="hidden" name="number1" value="<?php echo $number; ?>" size="6" class="bal">
			  <input type="hidden" name="bankname1" value="<?php echo $bankname; ?>" size="6" class="bal">
              <input type="hidden" name="accountnameano[]" id="accountnameano" value="<?php echo $accountnameano; ?>">
			  <input type="hidden" name="receivableamount1" id="receivableamount" value="<?php echo $receivableamount; ?>" size="6" class="bal">
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $billnumber; ?></div></td>
              <input type="hidden" name="billnum[]" value="<?php echo $billnumber; ?>">
			  <input type="hidden" name="name[]" value="<?php echo $name; ?>">
			  <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="left"><?php echo $billdate; ?></div></td>
              
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left"><div align="right">
			  <input type="hidden" name="billamount" id="bill" value="<?php if ($billtotalamount != '0.00') echo $billtotalamount; ?>">
                <?php if ($balanceamount != '0.00') echo number_format($balanceamount,2,'.',','); //echo number_format($balanceamount, 2); ?>
              </div></td>
			      <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right"><input class="bali" type="text" name="adjamount[]" id="adjamount<?php echo $sno; ?>" size="7" onClick="checkboxcheck('<?php echo $sno; ?>')" onKeyUp="balancecalc('<?php echo $sno; ?>','<?php echo $balanceamount; ?>','<?php echo $number; ?>')"></td>
            <td class="bodytext311" valign="center" bordercolor="#f3f3f3"><input type="text" class="bal" name="balamount[]" id="balamount<?php echo $sno; ?>" size="7" readonly></td>
            </tr>
			
            <?php
				$totalbalance = $totalbalance + $balanceamount;
				}
				
				$cashamount21 = '0.00';
				$cardamount21 = '0.00';
				$onlineamount21 = '0.00';
				$chequeamount21 = '0.00';
				$tdsamount21 = '0.00';
				$writeoffamount21 = '0.00';

				$totalpayment = '0.00';
				$netpayment = '0.00';
				$balanceamount = '0.00';
				
				$billtotalamount = '0.00';
				$netpayment = '0.00';
				$balanceamount = '0.00';
				
				$billstatus = '0.00';
			}
			}
			}
			$cashamount21 = 0.00;
			$cardamount21 = '';
			$onlineamount21 = '';
			$chequeamount21 = '';
			$tdsamount21 = '';
			$writeoffamount21 = '';
		$totalrefundedamount=0;
			$totalnumbr='';
			$totalnumbipf=0;
			?>
            <tr>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
            
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc"><div align="right"><strong>
                <?php //echo number_format($netpaymentamount, 2); ?>
              </strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc"><div align="right"><strong><?php if ($totalbalance != '') echo number_format($totalbalance,2,'.',','); ?></strong></div></td>
             <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc"><input type="text" name="totaladjamt" id="totaladjamt" size="7" class="bal" readonly></td>
             <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;<input type="hidden" name="totalrow" id="totalrow" value="<?php echo $sno; ?>"></td>
			</tr>
          </tbody>
      </table>
	  
	  
	  <tr>
	  <td>&nbsp;	  </td>
	  </tr>
	  <tr>
	  <td width="709"align="right" valign="top"><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                      
                      <input type="hidden" name="frmflag23" value="frmflag23">
                      <input name="Submit" type="submit"  value="Save" class="button" id="submit1" onClick="return totalamountcheck('<?php echo $num2; ?>','<?php echo $totamount; ?>');"style="border: 1px solid #001E6A"/>
        </font></td>
	  </tr>
	 </form>
	  </table>
	
	</td>
	</tr>
  </table>
  
<?php include ("includes/footer1.php"); ?>
</body>
</html>

