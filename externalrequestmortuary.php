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
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$paynowbillprefix = 'MR-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from mortuary_request order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);

if ($billnumber == '')
{
	$billnumbercode7 =$paynowbillprefix.'1';
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
	
	
	$billnumbercode7 = $paynowbillprefix .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}

		
	
		$patientfirstname = $_REQUEST["customername"];
		$patientfirstname = strtoupper($patientfirstname);
		$patientmiddlename = $_REQUEST['customermiddlename'];
		$patientmiddlename = strtoupper($patientmiddlename);
		$patientlastname = $_REQUEST["customerlastname"];
		$patientlastname = strtoupper($patientlastname);
		$patientname=$patientfirstname.' '.$patientmiddlename.' '.$patientlastname;
		
		$ambulancename = $_REQUEST['ambulancename'];
		$age=$_REQUEST['age'];
		$gender=$_REQUEST['gender'];
		$patientcode='walkin';
		$patientvisitcode='walkinvis';
		$comment= mysql_real_escape_string($_REQUEST['comments']);
		$status= $_REQUEST['approved'];
		$billtype='PAY NOW';
		
			
		if($status!="")
		{
		
		$query67 = "insert into mortuary_request(docno,patientname,patientcode,visitcode,recordtime,recorddate,ipaddress,username,age,gender,billtype,mode,paymentstatus)values('$billnumbercode7','$patientname','$patientcode','$patientvisitcode','$updatetime','$updatedate','$ipaddress','$username','$age','$gender','$billtype','external','')";
		$exec67 = mysql_query($query67) or die(mysql_error());
		
		}

	
		header("location:menupage1.php?mainmenuid=MM033");
		exit;

}




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

$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$paynowbillprefix = 'MR-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from mortuary_request order by auto_number desc limit 0, 1";
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

<!--<script type="text/javascript" src="js/insertnewitemipambulance.js"></script>-->



<script>
function funcitonSave()
{
if(document.getElementById("customername").value == '')
{
alert("Please enter the patientfirstname ");
document.getElementById("customername").focus();
return false;
}

if(document.getElementById("customermiddlename").value == '')
{
alert("Please enter the patientmiddlename ");
document.getElementById("customermiddlename").focus();
return false;
}

if(document.getElementById("customerlastname").value == '')
{
alert("Please enter the patientlastname");
document.getElementById("customerlastname").focus();
return false;
}
if(document.getElementById("age").value == '')
{
alert("Please enter the Age ");
document.getElementById("age").focus();
return false;
}
if(document.getElementById("gender").value == '')
{
alert("Please Select The Gender");
document.getElementById("gender").focus();
return false;
}
if(document.getElementById("approved").value == '')
{
alert("Please select the Checkbox");
document.getElementById("approved").focus();
return false;
}
if(document.getElementById("comments").value == '')
{
alert("Please enter the Comments");
document.getElementById("comments").focus();
return false;
}


}
function checkCheckBoxes(theForm) {
	if (theForm.approved.checked == false)
	 
	{
		alert ('Please select the Ambulance Checkbox!');
		document.getElementById("approved").focus();
		return false;
	} else { 	
		return true;
	}
}

</script>

<script>
//num,kms
function functionambulace(val)
{	
	var myarr = val.split(",");
	var ambnum=myarr[0];
	var ambkms=myarr[1];
	//alert(ambnum);
	//alert(ambkms);
	document.getElementById("rate4").value=  ambkms;
	document.getElementById("amount").value='';
	document.getElementById("units").value='';
	
	
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
<form name="form1" id="frmsales" method="post" action="externalrequestmortuary.php" onKeyDown="return disableEnterKey(event)" onSubmit="return checkCheckBoxes(this);">
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
        <td width="923"><table width="100%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
                <tr bgcolor="#011E6A">
                <td colspan="7" bgcolor="#CCCCCC" class="bodytext32"><strong>Patient Details</strong></td>
			 </tr>
		<tr>
                <td colspan="7" class="bodytext32"><strong>&nbsp;</strong></td>
			 </tr>
			<tr>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
				  <td width="22%" align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext32"> &nbsp;First Name   </span></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext32"> &nbsp;Middle Name   </span></td>
				  <td width="39%" align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext32"> &nbsp;Last Name   </span></td>
				  </tr>
				<tr>
                <td width="18%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext32"> <strong>Patient Name</strong>  </span></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="customername" id="customername" value="" style="text-transform:uppercase;" size="18">
				<input type="hidden" name="nameofrelative" id="nameofrelative" value="<?php echo $nameofrelative; ?>" style="border: 1px solid #001E6A;" size="45"></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
				<input name="customermiddlename" id="customermiddlename" value="" style="text-transform:uppercase;" size="18"></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="customerlastname" id="customerlastname" value="" style="text-transform:uppercase;" size="18"></td>
			 <input type="hidden" name="subtype" id="subtype"  value="" >  
				</tr>       
               
			   <tr>
			    <td width="18%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Age </strong></td>
                <td align="left" valign="top" class="bodytext3">
				<input type="text" name="age" id="age" value="" size="18" />	</td>			
			   	  <td width="21%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Gender</strong></td>
                <td align="left" valign="top" class="bodytext3">
				<select name="gender" id="gender">
				<option value="">Select </option>
				<option value="Male">Male </option>
				<option value="Female">Female </option>
				</select>		</td>	
 </tr>
				  <tr>
							 <td align="left" valign="middle" class="bodytext3"><strong>Doc Date</strong></td>
				<td><input type="text" name="billdate" id="billdate" value="<?php echo $dateonly; ?>" size="18" rsize="20" readonly/>				</td>	
                 <td align="left" valign="middle" class="bodytext3"><strong>Doc No</strong></td>
				<td><input type="text" name="billno" id="billno" value="<?php echo $billnumbercode; ?>" size="18" rsize="20" readonly/>								</td>
				  </tr>
                  		 
				 		
				 
				  	<tr>
                <td colspan="7" class="bodytext32"><strong>&nbsp;</strong></td>
			 </tr>
            </tbody>
        </table></td>
      </tr>
     
      <tr>
        <td>
		<table width="601" height="47" border="0" cellpadding="1" cellspacing="1" id="presid">
						<tr>
					     <td width="8" class="bodytext3">&nbsp;</td>
						  <td width="46" class="bodytext3">&nbsp;</td>
					     <td width="95" class="bodytext3">&nbsp;</td>
						  <td width="73" class="bodytext3">&nbsp;</td>
						</tr>    
                        
                                        
                     <tr>
                       <td class="bodytext3"></td>
                       <td colspan="2" class="bodytext32" align="right"><strong>Request For Mortuary</strong></td>
						  <td class="bodytext3"><input  type="checkbox"  name="approved" id="approved" value="approved" >
						</td>
                       <td colspan="2" class="bodytext32" align="right"><strong>&nbsp;</strong></td>
						  <td width="299" class="bodytext3">&nbsp;
						</td>
                     </tr>
					  <tr>
					 </tr>
                       
    
                       

				    </table>		</td></tr>
		
		<tr>
		<td>&nbsp;		</td>
        		<td width="57">&nbsp;		</td>

		</tr>
             
               <tr>
	  <td colspan="7" align="right" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
	   <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
	    <input name="Submit2223" type="submit" value="Save" accesskey="b" class="button"  onClick="return funcitonSave()"/>		</td>
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