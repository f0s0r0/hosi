<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$updatetime = date('H:i:s');

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

if (isset($_POST["frmflag1"])) { $frmflag1 = $_POST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{


       //get locationcode and locationname for inserting
 $locationcodeget=isset($_REQUEST['locationcodeget'])?$_REQUEST['locationcodeget']:'';
 $locationnameget=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';
//get ends here
$patientname = $_REQUEST['patientname'];
$patientcode = $_REQUEST['patientcode'];
$visitcode = $_REQUEST['visitcode'];
$accname = $_REQUEST['accname'];
$remarks = $_REQUEST['remarks'];
$docno = $_REQUEST['docno'];
$query43 = "select * from master_accountname where accountname = '$accname'";
$exec43 = mysql_query($query43) or die(mysql_error());
$res43 = mysql_fetch_array($exec43);
$acccode = $res43['id'];
$refundamount = $_REQUEST['refundamount'];

	$paynowbillprefix = "PDP-";
	$paynowbillprefix1=strlen($paynowbillprefix);
	$query2 = "select * from deposit_refund order by auto_number desc limit 0, 1";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	$res2 = mysql_fetch_array($exec2);
	$billnumber = $res2["docno"];
	$billdigit=strlen($billnumber);
	
	if ($billnumber == '')
	{
		$billnumbercode =$paynowbillprefix.'1';
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
		$billnumbercode = $paynowbillprefix .$maxanum;
		$openingbalance = '0.00';
		//echo $companycode;
	}
	
	$query765 = "select * from master_financialintegration where field='cashipfinal'";
$exec765 = mysql_query($query765) or die(mysql_error());
$res765= mysql_fetch_array($exec765);

$cashcoa = $res765['code'];


$query766 = "select * from master_financialintegration where field='chequeipfinal'";
$exec766 = mysql_query($query766) or die(mysql_error());
$res766 = mysql_fetch_array($exec766);

$chequecoa = $res766['code'];


$query767 = "select * from master_financialintegration where field='mpesaipfinal'";
$exec767 = mysql_query($query767) or die(mysql_error());
$res767 = mysql_fetch_array($exec767);

$mpesacoa = $res767['code'];

$query768 = "select * from master_financialintegration where field='cardipfinal'";
$exec768 = mysql_query($query768) or die(mysql_error());
$res768 = mysql_fetch_array($exec768);

$cardcoa = $res768['code'];

$query769 = "select * from master_financialintegration where field='onlineipfinal'";
$exec769 = mysql_query($query769) or die(mysql_error());
$res769 = mysql_fetch_array($exec769);

$onlinecoa = $res769['code'];

$query764 = "select * from master_financialintegration where field='ipdeposits'";
$exec764 = mysql_query($query764) or die(mysql_error());
$res764 = mysql_fetch_array($exec764);

$ipdepositscoa = $res764['code'];

   $cash = $_REQUEST['cash'];
	if($cash == '')
	{
	$cash = 0;
	}
	else
	{
	$query37 = "insert into paymentmodecredit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,cash,cashcoa,source,transactionamount,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accname','$billnumbercode','$updatedate','$ipaddress','$username','$cash','$cashcoa','ipdepositrefund','$cash','".$locationnameget."','".$locationcodeget."')";
    $exec37 = mysql_query($query37) or die(mysql_error());
	
	$query551 = "select * from financialaccount where transactionmode = 'CASH'";
	 $exec551 = mysql_query($query551) or die ("Error in Query551".mysql_error());
	 $res551 = mysql_fetch_array($exec551);
	 $cashcode = $res551['ledgercode'];
	 
	$query32 = "insert into deposit_refund(patientname,patientcode,visitcode,accountname,amount,docno,recorddate,recordtime,ipaddress,username,coa,remarks,locationname,locationcode,cashcode,cashamount)values('$patientname','$patientcode','$visitcode','$accname','$refundamount','$billnumbercode','$updatedate','$updatetime','$ipaddress','$username','$ipdepositscoa','$remarks','".$locationnameget."','".$locationcodeget."','$cashcode','$refundamount')";
    $exec32 = mysql_query($query32) or die(mysql_error());
	}
	$cheque = $_REQUEST['cheque'];
	if($cheque == '')
	{
	$cheque = 0;
	}
	else
	{
	$query37 = "insert into paymentmodecredit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,cheque,chequecoa,source,transactionamount,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accname','$billnumbercode','$updatedate','$ipaddress','$username','$cheque','$chequecoa','ipdepositrefund','$cheque','".$locationnameget."','".$locationcodeget."')";
    $exec37 = mysql_query($query37) or die(mysql_error());
	
	$query551 = "select * from financialaccount where transactionmode = 'CHEQUE'";
	 $exec551 = mysql_query($query551) or die ("Error in Query551".mysql_error());
	 $res551 = mysql_fetch_array($exec551);
	 $bankcode = $res551['ledgercode'];
	 
	$query32 = "insert into deposit_refund(patientname,patientcode,visitcode,accountname,amount,docno,recorddate,recordtime,ipaddress,username,coa,remarks,locationname,locationcode,bankcode,chequeamount)values('$patientname','$patientcode','$visitcode','$accname','$refundamount','$billnumbercode','$updatedate','$updatetime','$ipaddress','$username','$ipdepositscoa','$remarks','".$locationnameget."','".$locationcodeget."','$bankcode','$refundamount')";
    $exec32 = mysql_query($query32) or die(mysql_error());
	}
	$chequenumber = $_REQUEST['chequenumber1'];
	if($chequenumber == '')
	{
	$chequenumber = 0;
	}
	
	$online = $_REQUEST['online'];
	if($online == '')
	{
	$online = 0;
	}
	else
	{
	$query37 = "insert into paymentmodecredit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,online,onlinecoa,source,transactionamount,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accname','$billnumbercode','$updatedate','$ipaddress','$username','$online','$onlinecoa','ipdepositrefund','$online','".$locationnameget."','".$locationcodeget."')";
    $exec37 = mysql_query($query37) or die(mysql_error());
	
	$query551 = "select * from financialaccount where transactionmode = 'ONLINE'";
	 $exec551 = mysql_query($query551) or die ("Error in Query551".mysql_error());
	 $res551 = mysql_fetch_array($exec551);
	 $bankcode = $res551['ledgercode'];
	 
	$query32 = "insert into deposit_refund(patientname,patientcode,visitcode,accountname,amount,docno,recorddate,recordtime,ipaddress,username,coa,remarks,locationname,locationcode,bankcode,onlineamount)values('$patientname','$patientcode','$visitcode','$accname','$refundamount','$billnumbercode','$updatedate','$updatetime','$ipaddress','$username','$ipdepositscoa','$remarks','".$locationnameget."','".$locationcodeget."','$bankcode','$refundamount')";
    $exec32 = mysql_query($query32) or die(mysql_error());
	}
	$onlinenumber = $_REQUEST['onlinenumber1'];
	if($onlinenumber == '')
	{
	$onlinenumber = 0;
	}
	$creditcard = $_REQUEST['creditcard'];
	if($creditcard == '')
	{
	$creditcard = 0;
	}
	else
	{
	$query37 = "insert into paymentmodecredit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,card,cardcoa,source,transactionamount,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accname','$billnumbercode','$updatedate','$ipaddress','$username','$creditcard','$cardcoa','ipdepositrefund','$creditcard','".$locationnameget."','".$locationcodeget."')";
    $exec37 = mysql_query($query37) or die(mysql_error());
	
	$query551 = "select * from financialaccount where transactionmode = 'CREDITCARD'";
	 $exec551 = mysql_query($query551) or die ("Error in Query551".mysql_error());
	 $res551 = mysql_fetch_array($exec551);
	 $bankcode = $res551['ledgercode'];
	 
	$query32 = "insert into deposit_refund(patientname,patientcode,visitcode,accountname,amount,docno,recorddate,recordtime,ipaddress,username,coa,remarks,locationname,locationcode,bankcode,cardamount)values('$patientname','$patientcode','$visitcode','$accname','$refundamount','$billnumbercode','$updatedate','$updatetime','$ipaddress','$username','$ipdepositscoa','$remarks','".$locationnameget."','".$locationcodeget."','$bankcode','$refundamount')";
    $exec32 = mysql_query($query32) or die(mysql_error());
	
	}
	$creditcardnumber = $_REQUEST['creditcardnumber1'];
	if($creditcardnumber == '')
	{
	$creditcardnumber = 0;
	}
	$mpesa = $_REQUEST['mpesa'];
	if($mpesa == '')
	{
	$mpesa = 0;
	}
	else
	{
	$query37 = "insert into paymentmodecredit(patientname,patientcode,patientvisitcode,accountname,billnumber,billdate,ipaddress,username,mpesa,mpesacoa,source,transactionamount,locationname,locationcode)values('$patientname','$patientcode','$visitcode','$accname','$billnumbercode','$updatedate','$ipaddress','$username','$mpesa','$mpesacoa','ipdepositrefund','$mpesa','".$locationnameget."','".$locationcodeget."')";
    $exec37 = mysql_query($query37) or die(mysql_error());
	
	$query551 = "select * from financialaccount where transactionmode = 'MPESA'";
	 $exec551 = mysql_query($query551) or die ("Error in Query551".mysql_error());
	 $res551 = mysql_fetch_array($exec551);
	 $mpesacode = $res551['ledgercode'];
	 
	$query32 = "insert into deposit_refund(patientname,patientcode,visitcode,accountname,amount,docno,recorddate,recordtime,ipaddress,username,coa,remarks,locationname,locationcode,mpesacode,creditamount)values('$patientname','$patientcode','$visitcode','$accname','$refundamount','$billnumbercode','$updatedate','$updatetime','$ipaddress','$username','$ipdepositscoa','$remarks','".$locationnameget."','".$locationcodeget."','$mpesacode','$refundamount')";
    $exec32 = mysql_query($query32) or die(mysql_error());
	
	}
	$mpesanumber = $_REQUEST['mpesanumber1'];
	if($mpesanumber == '')
	{
	$mpesanumber = 0;
	}
	

	$query33 = "update depositrefund_request set recordstatus = 'completed' where docno='$docno'";
	$exec33 = mysql_query($query33) or die(mysql_error());
	header("location:depositrefundrequestlist.php");
}

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


?>

<?php

if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if(isset($_REQUEST['docno'])) { $docno = $_REQUEST["docno"]; } else { $docno = ""; }
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
<script>
function funcSaveBill13()
{

var balance = document.getElementById("balance").value;
if(balance == '')
{
alert("Please Enter the Amount");
return false;
}
if(balance != 0.00)
{
alert("Balance is still pending, Pl collect fully before saving");
return false;
}

var varUserChoice; 
	varUserChoice = confirm('Are You Sure Want To Save This Entry?'); 
	//alert(fRet); 
	if (varUserChoice == false)
	{
		alert ("Entry Not Saved.");
		return false;
	}
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
</style>
</head>
<script type="text/javascript">
function balancecalc()
{

var netpayable = document.getElementById("refundamount").value;
var cash = document.getElementById("cash").value;

var cheque = document.getElementById("cheque").value;
if(cheque != '')
{
	funcchequenumbershow();
}
else
{
	funcchequenumberhide();
}
var online = document.getElementById("online").value;
if(online != '')
{
	funconlinenumbershow();
}
else
{
	funconlinenumberhide();
}
var mpesa = document.getElementById("mpesa").value;
if(mpesa != '')
{
	funcmpesanumbershow();
}
else
{
	funcmpesanumberhide();
}
var creditcard = document.getElementById("creditcard").value;
if(creditcard != '')
{
	funccreditcardnumbershow();
}
else
{
	funccreditcardnumberhide();
}

if(cash == '')
{
cash = 0;
}
if(cheque == '')
{
cheque = 0;
}
if(online == '')
{
online = 0;
}
if(mpesa == '')
{
mpesa = 0;
}
if(creditcard == '')
{
creditcard = 0;
}

var balance = netpayable - (parseFloat(cash)+parseFloat(cheque)+parseFloat(online)+parseFloat(mpesa)+parseFloat(creditcard));


if(balance < 0)
{
alert("Entered Amount is greater than Net Payable");
document.getElementById("balance").value = "";
return false;
}

document.getElementById("balance").value = balance.toFixed(2);
}

function funcchequenumbershow()
{

  if (document.getElementById("chequenumber") != null) 
     {
	 document.getElementById("chequenumber").style.display = 'none';
	}
	if (document.getElementById("chequenumber") != null) 
	  {
	  document.getElementById("chequenumber").style.display = '';
	 }
	  if (document.getElementById("chequenumber1") != null) 
     {
	 document.getElementById("chequenumber1").style.display = 'none';
	}
	if (document.getElementById("chequenumber1") != null) 
	  {
	  document.getElementById("chequenumber1").style.display = '';
	 }
}

function funcchequenumberhide()
{		
 if (document.getElementById("chequenumber") != null) 
	{
	document.getElementById("chequenumber").style.display = 'none';
	}	
	if (document.getElementById("chequenumber1") != null) 
	{
	document.getElementById("chequenumber1").style.display = 'none';
	}	
}

function funconlinenumbershow()
{

  if (document.getElementById("onlinenumber") != null) 
     {
	 document.getElementById("onlinenumber").style.display = 'none';
	}
	if (document.getElementById("onlinenumber") != null) 
	  {
	  document.getElementById("onlinenumber").style.display = '';
	 }
	  if (document.getElementById("onlinenumber1") != null) 
     {
	 document.getElementById("onlinenumber1").style.display = 'none';
	}
	if (document.getElementById("onlinenumber1") != null) 
	  {
	  document.getElementById("onlinenumber1").style.display = '';
	 }
}

function funconlinenumberhide()
{		
 if (document.getElementById("onlinenumber") != null) 
	{
	document.getElementById("onlinenumber").style.display = 'none';
	}	
	if (document.getElementById("onlinenumber1") != null) 
	{
	document.getElementById("onlinenumber1").style.display = 'none';
	}	
}

function funccreditcardnumbershow()
{

  if (document.getElementById("creditcardnumber") != null) 
     {
	 document.getElementById("creditcardnumber").style.display = 'none';
	}
	if (document.getElementById("creditcardnumber") != null) 
	  {
	  document.getElementById("creditcardnumber").style.display = '';
	 }
	  if (document.getElementById("creditcardnumber1") != null) 
     {
	 document.getElementById("creditcardnumber1").style.display = 'none';
	}
	if (document.getElementById("creditcardnumber1") != null) 
	  {
	  document.getElementById("creditcardnumber1").style.display = '';
	 }
}

function funccreditcardnumberhide()
{		
 if (document.getElementById("creditcardnumber") != null) 
	{
	document.getElementById("creditcardnumber").style.display = 'none';
	}	
	if (document.getElementById("creditcardnumber1") != null) 
	{
	document.getElementById("creditcardnumber1").style.display = 'none';
	}	
}

function funcmpesanumbershow()
{

  if (document.getElementById("mpesanumber") != null) 
     {
	 document.getElementById("mpesanumber").style.display = 'none';
	}
	if (document.getElementById("mpesanumber") != null) 
	  {
	  document.getElementById("mpesanumber").style.display = '';
	 }
	  if (document.getElementById("mpesanumber1") != null) 
     {
	 document.getElementById("mpesanumber1").style.display = 'none';
	}
	if (document.getElementById("mpesanumber1") != null) 
	  {
	  document.getElementById("mpesanumber1").style.display = '';
	 }
}

function funcmpesanumberhide()
{		
 if (document.getElementById("mpesanumber") != null) 
	{
	document.getElementById("mpesanumber").style.display = 'none';
	}	
	if (document.getElementById("mpesanumber1") != null) 
	{
	document.getElementById("mpesanumber1").style.display = 'none';
	}	
}

function funcOnLoadBodyFunctionCall()
{
funcchequenumberhide();
funconlinenumberhide();
funccreditcardnumberhide();
funcmpesanumberhide();
}
</script>
<script src="js/datetimepicker_css.js"></script>

<body onLoad="return funcOnLoadBodyFunctionCall()">
<form name="form1" id="form1" method="post" action="approvedepositrefund.php" onSubmit="return funcSaveBill13()">	
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="15" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="15" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="15" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="15">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
   
    <td colspan="6" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      
	 
	
		<tr>
		<td colspan="7">

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
           <?php
		  
		  $locationnameget=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';
		   $query1 = "select locationcode from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		
		while($res1 = mysql_fetch_array($exec1))
		{
		
		
		$locationcodeget = $res1['locationcode'];
		$query551 = "select * from master_location where locationcode='".$locationcodeget."'";
		$exec551 = mysql_query($query551) or die(mysql_error());
		$res551 = mysql_fetch_array($exec551);
		$locationnameget = $res551['locationname'];
		}?>
             <tr>
						  <td colspan="4" class="bodytext31" bgcolor="#CCCCCC"><strong>Approve Deposit Refunds</strong></td>
                          <td colspan="3" class="bodytext31" bgcolor="#CCCCCC"><strong>Location &nbsp;</strong><?php echo $locationnameget;?></td>
                  <input type="hidden" name="locationcodeget" value="<?php echo $locationcodeget?>">
				<input type="hidden" name="locationnameget" value="<?php echo $locationnameget?>">
						</tr>
            <tr>
              
				 <td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient Name</strong></div></td>
           
				 <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Code  </strong></div></td>
				 <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>IP Visit  </strong></div></td>
				 <td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bill Type</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Account</strong></div></td>
              </tr>
           <?php
            $colorloopcount ='';
		
		$query1 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		
		while($res1 = mysql_fetch_array($exec1))
		{
		$patientname=$res1['patientfullname'];
		$patientcode=$res1['patientcode'];
		$accountname = $res1['accountname'];
		$billtype = $res1['billtype'];
		$gender = $res1['gender'];
		$age = $res1['age'];
		
		
		$query813 = "select * from ip_discharge where visitcode='$visitcode' and patientcode='$patientcode'";
		$exec813 = mysql_query($query813) or die(mysql_error());
		$res813 = mysql_fetch_array($exec813);
		$num813 = mysql_num_rows($exec813);
		if($num813 > 0)
		{
		$updatedate=$res813['recorddate'];
		}
			
		
		$query67 = "select * from master_accountname where auto_number='$accountname'";
		$exec67 = mysql_query($query67); 
		$res67 = mysql_fetch_array($exec67);
		$accname = $res67['accountname'];
		
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
             
			  <td align="left" valign="center" class="bodytext31">
			    <div align="center"><?php echo $patientname; ?></div></td>
				<td align="center" valign="center" class="bodytext31"><?php echo $patientcode; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $visitcode; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $updatedate; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $billtype; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $accname; ?></td>
			<input type="hidden" name="patientname" id="patientname" value="<?php echo $patientname; ?>">
				 
				<input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>">
				<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>">
			<input type="hidden" name="docno" id="docno" value="<?php echo $docno; ?>">
				<input type="hidden" name="accname" id="accname" value="<?php echo $accname; ?>">
			   </tr>
		   <?php 
		   } 
		$query65  = "select * from depositrefund_request where docno='$docno'";
		$exec65 = mysql_query($query65) or die(mysql_error());
		$res65 = mysql_fetch_array($exec65);
		$amount = $res65['amount'];
		$user = $res65['username'];
		   ?>
           
            <tr>
             	<td colspan="6" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#cccccc" class="bodytext311">&nbsp;</td>
             	</tr>
          </tbody>
        </table>		</td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		</tr>
		<tr>
		<td width="18%" align="right" valign="center" class="bodytext311">Deposit to Refund</td>
		<td width="20%" align="left" valign="center" class="bodytext311">&nbsp;&nbsp;&nbsp;
		  <input type="text" name="refundamount" id="refundamount" size="10" value="<?php echo number_format($amount,2,'.',''); ?> " readonly></td>
		<td width="21%" align="left" valign="center" class="bodytext311">&nbsp;</td>
		<td width="41%" align="left" valign="center" class="bodytext311">&nbsp;</td>
		<td width="26%" align="left" valign="center" class="bodytext311">&nbsp;</td>
		<td width="7%" align="left" valign="center" class="bodytext311">&nbsp;</td>
		<td width="7%" align="left" valign="center" class="bodytext311">&nbsp;</td>
		<td width="1%" align="left" valign="center" class="bodytext311">&nbsp;</td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		</tr>
		<tr>
			
			<td class="bodytext31" align="center">&nbsp;</td>
			<td colspan="3">
			<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
		  <tr>
			<td width="29%" align="right" class="bodytext31"><strong>Cash</strong></td>
			 
	
			<td width="13%" align="center" class="bodytext31"><input type="text" name="cash" id="cash" size="10" onKeyUp="return balancecalc();"></td>
		    <td width="16%" align="right" class="bodytext31"><strong>Balance</strong></td>
		    <td width="15%" align="center" class="bodytext31"><input type="text" name="balance" id="balance" size="8" class="bal" readonly></td>
		  </tr>
			<tr>
			<td align="right" class="bodytext31"><strong>Cheque</strong></td>
			 <td class="bodytext31" align="center"><input type="text" name="cheque" id="cheque" size="10" onKeyUp="return balancecalc();"></td>
			 <td class="bodytext31" align="right" id="chequenumber"><strong>Cheque Number</strong></td>
			 <td class="bodytext31" align="center"><input type="text" name="chequenumber1" id="chequenumber1" size="10"></td>
			 <td width="15%" align="center" class="bodytext31">&nbsp;</td>
	     <td width="6%" align="center" class="bodytext31">&nbsp;</td>
		 <td width="6%" align="center" class="bodytext31">&nbsp;</td>
			</tr>
			<tr>
			<td class="bodytext31" align="right"><strong>Online</strong></td>
			 <td class="bodytext31" align="center"><input type="text" name="online" id="online" size="10" onKeyUp="return balancecalc();"></td>
		 <td class="bodytext31" align="right" id="onlinenumber"><strong>Online Number</strong></td>
			 <td class="bodytext31" align="center"><input type="text" name="onlinenumber1" id="onlinenumber1" size="10"></td>
				 <td class="bodytext31" align="center">&nbsp;</td>
	     <td class="bodytext31" align="center">&nbsp;</td>
		 <td class="bodytext31" align="center">&nbsp;</td>
			</tr>
			<tr>
			<td class="bodytext31" align="right"><strong>Credit Card</strong></td>
			 <td class="bodytext31" align="center"><input type="text" name="creditcard" id="creditcard" size="10" onKeyUp="return balancecalc();"></td>
			 <td class="bodytext31" align="right" id="creditcardnumber"><strong>Credit Card Number</strong></td>
			 <td class="bodytext31" align="center"><input type="text" name="creditcardnumber1" id="creditcardnumber1" size="10"></td>
		 <td class="bodytext31" align="center">&nbsp;</td>
	     <td class="bodytext31" align="center">&nbsp;</td>
		 <td class="bodytext31" align="center">&nbsp;</td>
			</tr>
			<tr>
			<td class="bodytext31" align="right"><strong>MPESA</strong></td>
			 <td class="bodytext31" align="center"><input type="text" name="mpesa" id="mpesa" size="10" onKeyUp="return balancecalc();"></td>
			 <td class="bodytext31" align="right" id="mpesanumber"><strong>MPESA Number</strong></td>
			 <td class="bodytext31" align="center"><input type="text" name="mpesanumber1" id="mpesanumber1" size="10"></td>
		 <td class="bodytext31" align="center">&nbsp;</td>
	     <td class="bodytext31" align="center">&nbsp;</td>
		 <td class="bodytext31" align="center">&nbsp;</td>
			</tr>
			</tbody>
			</table>			</td>
			</tr>
		<tr>
		<td width="18%" align="right" valign="center" class="bodytext311">remarks</td>
		<td width="41%" colspan="3" align="left" valign="center" class="bodytext311">&nbsp;&nbsp;&nbsp;
		  <textarea name="remarks" id="remarks"></textarea></td>
		<td width="26%" align="left" valign="center" class="bodytext311">&nbsp;</td>
		<td width="7%" align="left" valign="center" class="bodytext311">&nbsp;</td>
		<td width="7%" align="left" valign="center" class="bodytext311">&nbsp;</td>
		<td width="1%" align="left" valign="center" class="bodytext311">&nbsp;</td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		</tr>
		<tr>
		<td width="18%" align="right" valign="center" class="bodytext311"><strong>Approved By</strong></td>
		<td width="0%" align="left" valign="center" class="bodytext311">&nbsp;&nbsp;&nbsp;<?php echo $user; ?></td>
		<td width="0%" align="left" valign="center" class="bodytext311"><a target="_blank" href="ipinteriminvoiceserver.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">Click to See Interim</a></td>
		<td width="41%" align="center" valign="center" class="bodytext311"><input type="hidden" name="frmflag1" value="frmflag1" />
		  <input type="submit" name="Submit" value="Submit" /></td>
		<td width="26%" align="left" valign="center" class="bodytext311">&nbsp;</td>
		<td width="7%" align="left" valign="center" class="bodytext311">&nbsp;</td>
		<td width="7%" align="left" valign="center" class="bodytext311">&nbsp;</td>
		<td width="1%" align="left" valign="center" class="bodytext311">&nbsp;</td>
		</tr>
		</table>		</td>
		</tr>
		
	
		  
    </table>
  </table>
</form>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

