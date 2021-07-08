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
 //get location for sort by location purpose
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
	if($location!='')
	{
		  $locationcode=$location;
		}
		//location get end here
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
	//get location name and code
	$locationnameget=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';
	$locationcodeget=isset($_REQUEST['locationcodeget'])?$_REQUEST['locationcodeget']:'';
	//get location ends here
	$paynowbillprefix = 'IPCr-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from ip_creditnote order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["billno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='IPCr-'.'1';
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
	
	
	$billnumbercode = 'IPCr-' .$maxanum;
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
	/*	$bedcharges = $_REQUEST['bed'];
		$nursingcharges = $_REQUEST['nursing'];
		$rmocharges = $_REQUEST['rmo'];
		$lab = $_REQUEST['lab'];
		$radiology = $_REQUEST['radiology'];
		$service = $_REQUEST['service'];
		$others = $_REQUEST['others'];
		$remarks = $_REQUEST['remarks'];*/
		//$totalamount = $_REQUEST['total'];
		
		$accountnameano= $_REQUEST['accountnameano'];
		$accountnameid= $_REQUEST['accountnameid'];
		$subtypeano = $_REQUEST['subtypeano'];
		$subtype = $_REQUEST['subtype'];
		
	 $oporip=substr($visitcode,-1);
		if($oporip=='P')
		{
			 $oporip="IP";
		}
		else
		{
			 $oporip="OP";
		}
		$totalamount =0;
		foreach($_POST['referal'] as $key=>$value){	
			//echo '<br>'.
		
		$pairs= $_POST['referal'][$key];
		$pairvar= $pairs;
	    $pairs1= $_POST['rate4'][$key];
		$pairvar1= $pairs1;
		
		
		$units = $_POST['units'][$key];
		$amount = $_POST['amount'][$key];
		$totalamount += $amount;
	 	$accountname=$_POST['accountname'][$key];
	 	$accountcode=$_POST['accountcode'][$key];
	
			
		if($pairvar!="")
		{
		$referalquery1=mysql_query("insert into ip_creditnotebrief(docno,patientcode,patientname,patientvisitcode,description,rate,billtype,accountname,consultationdate,paymentstatus,consultationtime,username,ipaddress,locationname,locationcode,unit,amount,accountcode,selaccountname)values('$billnumbercode','$patientcode','$patientfullname','$visitcode','$pairvar','$pairvar1','$billtype','$account','$dateonly','pending','$timeonly','$username','$ipaddress','".$locationnameget."','".$locationcodeget."','$units','$amount','$accountcode','$accountname')") or die(mysql_error());
		}
		
		}
		
		mysql_query("insert into ip_creditnote(billno,patientname,patientcode,visitcode,totalamount,billdate,accountname,subtype,remarks,locationname,locationcode,accountnameano,accountnameid,subtypeano,patienttype)values('$billnumbercode','$patientfullname','$patientcode','$visitcode','$totalamount','$currentdate','$account','$subtype','$remarks','".$locationnameget."','".$locationcodeget."','$accountnameano','$accountnameid','$subtypeano','$oporip')") or die(mysql_error());
		
	 	$query83="insert into master_transactionpaylater(patientname,patientcode,visitcode,transactiondate,accountname,docno,ipaddress,companyanum,companyname,financialyear,transactiontype,paymenttype,subtype,transactionamount,receivableamount,doctorname,locationname,locationcode,accountnameano,accountnameid,subtypeano,username,transactiontime)values('$patientfullname',
	          '$patientcode','$visitcode','$dateonly','$account','$billnumbercode','$ipaddress','$companyanum','$companyname','$financialyear','paylatercredit','$patienttype1','$subtype','$totalamount','$totalamount','$doctorname','".$locationnameget."','".$locationcodeget."','$accountnameano','$accountnameid','$subtypeano','$username','$timeonly')";
			 
	    $exec83=mysql_query($query83) or die("error in query83".mysql_error());		  

	
		
		header("location:creditnotelist.php?billno=".$billnumbercode."&&visitcode=".$visitcode."&&patientcode=".$patientcode."");
		exit;

}


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


//include ("autocompletebuild_accounts1.php");

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

$query52 = "select * from billing_ip where patientcode='$patientcode' and visitcode='$visitcode'";
$exec52 = mysql_query($query52) or die(mysql_error());
$num52 = mysql_num_rows($exec52);
if($num52 != 0)
{
$res52 = mysql_fetch_array($exec52);
$finalbillamount = $res52['totalamount'];
}
else
{
$query53 = "select * from billing_ipcreditapproved where patientcode='$patientcode' and visitcode='$visitcode'";
$exec53 = mysql_query($query53) or die(mysql_error());
$res53 = mysql_fetch_array($exec53);
$finalbillamount = $res53['totalamount'];
}

?>
<?php
$querylab1=mysql_query("select * from master_customer where customercode='$patientcode'");
$execlab1=mysql_fetch_array($querylab1);
$patientname=$execlab1['customerfullname'];
$patientaccount=$execlab1['accountname'];

$querylab2=mysql_query("select * from master_accountname where auto_number='$patientaccount'");
$execlab2=mysql_fetch_array($querylab2);
$patientaccount1=$execlab2['accountname'];
$patientaccountid=$execlab2['id'];
$queryy53 = "select locationname,locationcode from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$execy53 = mysql_query($queryy53) or die(mysql_error());
$row=mysql_num_rows($execy53);
if($row==0)
{
	 $queryy53 = "select locationname,locationcode from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$execy53 = mysql_query($queryy53) or die(mysql_error());
	}
$resy53 = mysql_fetch_array($execy53);
 $locationnameget = $resy53['locationname'];
 $locationcodeget = $resy53['locationcode'];


?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
	$paynowbillprefix = 'IPCr-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from ip_creditnote order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["billno"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='IPCr-'.'1';
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
	
	
	$billnumbercode = 'IPCr-' .$maxanum;
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


funcCustomerDropDownSearch7();		
		
		}


</script>

<script type="text/javascript" src="js/insertnewitemipmiscbilling.js"></script>
<script type="text/javascript" src="js/autosuggesaccountsearch1misc.js"></script>
<script type="text/javascript" src="js/autocomplete_jobdescription2.js"></script>


<script language="javascript">

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
//alert();
//var total = document.getElementById("total").value;
//var finalbillamount = document.getElementById("finalbillamount").value;
/*if(parseFloat(total) > parseFloat(finalbillamount))
{
alert("Please Check the amount entered");
return false;
}
*/
document.getElementById('Submit2223').disabled =true;
if(confirm("Do You Want To Save The Record?")==false){
document.getElementById('Submit2223').disabled =false;
return false;}
}

function totalcalc()
{
var bed = document.getElementById("bed").value;
if(bed == '')
{
bed = 0;
}
var nursing = document.getElementById("nursing").value;
if(nursing == '')
{
nursing = 0;
}
var rmo = document.getElementById("rmo").value;
if(rmo == '')
{
rmo = 0;
}
var lab = document.getElementById("lab").value;
if(lab == '')
{
lab = 0;
}
var radiology = document.getElementById("radiology").value;
if(radiology == '')
{
radiology = 0;
}
var service = document.getElementById("service").value;
if(service == '')
{
service = 0;
}
var others = document.getElementById("others").value;
if(others == '')
{
others = 0;
}

var total = parseInt(bed)+parseInt(nursing)+parseInt(rmo)+parseInt(lab)+parseInt(radiology)+parseInt(service)+parseInt(others);
document.getElementById("total").value = total.toFixed(2);
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
<script>

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

window.onload = function() 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchaccountname"), new StateSuggestions());
	funcOnLoadBodyFunctionCall();
}
</script>
<script src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
$("#searchaccountname").keydown(function()
{
$("#searchaccountcode").val('');
});

});
</script>

</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body >
<form name="form1" id="frmsales" method="post" action="creditnote.php" onKeyDown="return disableEnterKey(event)" onSubmit="return validcheck()">
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
                <td colspan="2" bgcolor="#CCCCCC" class="bodytext32"><strong>Patient Details</strong></td>
                 <td colspan="2" bgcolor="#CCCCCC" class="bodytext32"><strong>Loation &nbsp;</strong><?php echo $locationnameget?></td>
                <input type="hidden" value="<?php echo $locationnameget?>" name="locationnameget">
                <input type="hidden" value="<?php echo $locationcodeget?>" name="locationcodeget">
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
				<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" />	<?php echo $visitcode; ?>
                <input type="hidden" name="subtypeano" id="subtypeano" value="<?php echo $patientsubtype; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
                <input type="hidden" name="subtype" id="subtype" value="<?php echo $patientsubtype1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
                </td>			
			   	  <td width="17%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Account</strong></td>
                <td align="left" valign="top" class="bodytext3">
				<input type="hidden" name="account" id="account" value="<?php echo $patientaccount1; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" />		
                <input type="hidden" name="accountnameano" id="accountnameano" value="<?php echo $patientaccount; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
                <input type="hidden" name="accountnameid" id="accountnameid" value="<?php echo $patientaccountid; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<input type="hidden" name="billtypes" id="billtypes" value="<?php echo $billtype; ?>" />
			<?php echo $patientaccount1; ?>	</td>	
 </tr>
				  <tr>
							 <td align="left" valign="middle" class="bodytext3"><strong> Date</strong></td>
				<td class="bodytext3"><input type="hidden" name="billdate" id="billdate" value="<?php echo $dateonly; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				<?php echo $dateonly; ?>				</td>	
                 <td align="left" valign="middle" class="bodytext3"><strong>Doc No</strong></td>
				<td class="bodytext3"><input type="hidden" name="billno" id="billno" value="<?php echo $billnumbercode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>	
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
	<!--	<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
          
				        <tr>
				   <td colspan="13" align="left" valign="middle"  bgcolor="#CCCCCC" class="bodytext3"><span class="bodytext32"><strong> Credit Note </strong> </span></td>
		        </tr>
				<tr>
				 <td width="24%" align="center" valign="middle" class="bodytext3">Bed</td>
				  <td width="24%" align="left" valign="middle" class="bodytext3"><input type="text" name="bed" id="bed" size="8" onKeyUp="return totalcalc()"></td>
				  <td width="12%" align="left" valign="middle" class="bodytext3">&nbsp;</td>
				  <td width="40%" align="left" valign="middle" class="bodytext3"><input name="accountname" type="hidden" id="accountname" value="" size="32" autocomplete="off"></td>
				</tr>
				<tr>
				 <td align="center" valign="middle" class="bodytext3">Nursing</td>
				  <td colspan="3" align="left" valign="middle" class="bodytext3"><input type="text" name="nursing" id="nursing" size="8" onKeyUp="return totalcalc()"></td>
				</tr>
				<tr>
				 <td align="center" valign="middle" class="bodytext3">RMO</td>
				  <td colspan="3" align="left" valign="middle" class="bodytext3"><input type="text" name="rmo" id="rmo" size="8" onKeyUp="return totalcalc()"></td>
				</tr>
				<tr>
				 <td align="center" valign="middle" class="bodytext3">Lab</td>
				  <td colspan="3" align="left" valign="middle" class="bodytext3"><input type="text" name="lab" id="lab" size="8" onKeyUp="return totalcalc()"></td>
				</tr>
				<tr>
				 <td align="center" valign="middle" class="bodytext3">Radiology</td>
				  <td colspan="3" align="left" valign="middle" class="bodytext3"><input type="text" name="radiology" id="radiology" size="8" onKeyUp="return totalcalc()"></td>
				</tr>
				<tr>
				 <td align="center" valign="middle" class="bodytext3">Service</td>
				  <td colspan="3" align="left" valign="middle" class="bodytext3"><input type="text" name="service" id="service" size="8" onKeyUp="return totalcalc()"></td>
				</tr>
				<tr>
				 <td align="center" valign="middle" class="bodytext3">Others</td>
				  <td colspan="3" align="left" valign="middle" class="bodytext3"><input type="text" name="others" id="others" size="8" onKeyUp="return totalcalc()">
				  <input type="hidden" name="total" id="total">
				   <input type="hidden" name="finalbillamount" id="finalbillamount" value="<?php echo $finalbillamount; ?>"></td>
				</tr>
			<tr>
		<td>&nbsp;		</td>
		</tr>
		<tr>
				 <td align="center" valign="middle" class="bodytext3">Remarks</td>
				  <td colspan="3" align="left" valign="middle" class="bodytext3"><textarea name="remarks" id="remarks"></textarea></td>
				</tr>
		       </tbody>
        </table> -->
		
		
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
          
				        <tr>
				   <td colspan="11" align="left" valign="middle"  bgcolor="#CCCCCC" class="bodytext3"><span class="bodytext32"><strong>IP Credit</strong> </span></td>
		        </tr>
				<tr id="reffid">
				    <td colspan="11" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
				    <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                                      <td width="30" class="bodytext3">Account</td>
                       <td width="30" class="bodytext3">Description</td>
                       <td class="bodytext3">Unit</td>
					     <td class="bodytext3">Rate</td>
						  <td class="bodytext3">Amount</td>
                     </tr>
					  <tr>
					 <div id="insertrow4">					 </div></tr>
					  <tr>
					  <input type="hidden" name="serialnumber4" id="serialnumber4" value="1">
					  <input type="hidden" name="referalcode" id="referalcode" value="">
                       <td width="30">
                   <input name="autobuildaccount" type="hidden" value="" id="autobuildaccount" size="30">
                   <input name="searchaccountcode" type="hidden" value="" id="searchaccountcode" size="30">
                   <input name="searchaccountname" type="text" value="" id="searchaccountname" size="30"  onKeyPress="return changecode()"></td>
				   <td width="30"><input name="referal[]" type="text" id="referal" size="30"></td>
				    <td width="30"><input name="units[]" type="text" id="units" size="8"></td>
				    <td width="30"><input name="rate4[]" type="text" id="rate4" size="8" onKeyUp="return funcamountcalc()"></td>
					  <td width="30"><input name="amount[]" type="text" id="amount" readonly size="8"></td>
					   <td><label>
                       <input type="button" name="Add4" id="Add4" value="Add" onClick="return insertitem5()" class="button">
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
			   <td>&nbsp;</td>
	  <td colspan="1" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
	   <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
	    <input name="Submit2223" id="Submit2223" type="submit" value="Save" accesskey="b" class="button" style="border: 1px solid #001E6A"/>		</td>
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
