<?php
session_start();
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$registrationdate = date('Y-m-d');
$registrationtime = date('H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$companycode = $_SESSION['companycode'];
$searchpaymenttype= '';
	
	$query1111 = "select * from master_employee where username = '$username'";
    $exec1111 = mysql_query($query1111) or die ("Error in Query1111".mysql_error());
	while ($res1111 = mysql_fetch_array($exec1111))
	{
	 $username = $res1111["username"];
	 $locationnumber = $res1111["location"];
	  $query1112 = "select * from master_location where auto_number = '$locationnumber'";
    $exec1112 = mysql_query($query1112) or die ("Error in Query1112".mysql_error());
	while ($res1112 = mysql_fetch_array($exec1112))
	{
		 $locationname1 = $res1112["locationname"];		  
		  $locationcode1 = $res1112["locationcode"];
		   $prefix = $res1112["prefix"];
		    $suffix = $res1112["suffix"];
	}
	}
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
   $customercode = $_REQUEST['customercode'];
	$customername = $_REQUEST["customername"];
	$customername = strtoupper($customername);
	$customername = trim($customername);
	$customername = addslashes($customername);
	$gender = $_REQUEST["gender"];
	
	$mothername=$_REQUEST['mothername'];
	$mothername = strtoupper($mothername);
	$mothername = trim($mothername);
	$mothername = addslashes($mothername);
	
	$age = $_REQUEST["age"];
	$typeofcustomer='';
	$address1=$_REQUEST["address1"];
	$address2=$_REQUEST["address2"];
	$area = $_REQUEST["area"];
	$city  = $_REQUEST["city"];
	$state  = $_REQUEST["state"];
	$pincode = $_REQUEST["pincode"];
	$country = $_REQUEST["country"];
	$phonenumber1 = $_REQUEST["phonenumber1"];
	$phonenumber2 = $_REQUEST["phonenumber2"];
	$emailid1  = $_REQUEST["emailid1"];
	$emailid2 = $_REQUEST["emailid2"];
	$faxnumber = '';
	$mobilenumber  = $_REQUEST["mobilenumber"];
	$remarks ='';
	$status ='';
	$tinnumber =$_REQUEST["tinnumber"];
	$cstnumber =$_REQUEST["cstnumber"];
	$openingbalance =$_REQUEST["openingbalance"];
	$insuranceid =$_REQUEST["insuranceid"];
	$nameofrelative = $_REQUEST['nameofrelative'];
	$dateofbirth = $_REQUEST['dateofbirth'];
	$maritalstatus = $_REQUEST['maritalstatus'];
	$occupation = $_REQUEST['occupation'];
	$mrdno = $_REQUEST['mrdno'];
	$promotion = $_REQUEST['promotion'];
	$nationalidnumber = $_REQUEST['nationalidnumber'];
	$ageduration = $_REQUEST['ageduration'];
	$bloodgroup = $_REQUEST['bloodgroup'];
	$registrationdate = $_REQUEST['registrationdate'];
	$registrationtime = $_REQUEST['registrationtime'];
	
	$customermiddlename = $_REQUEST['customermiddlename'];
	$customermiddlename = strtoupper($customermiddlename);
	$customermiddlename = trim($customermiddlename);
	$customermiddlename = addslashes($customermiddlename);
	
	$customerlastname = $_REQUEST['customerlastname'];
	$customerlastname = strtoupper($customerlastname);
	$customerlastname = trim($customerlastname);
	$customerlastname = addslashes($customerlastname);
	$customerfullname=$customername.' '.$customermiddlename.' '.$customerlastname;

	$kinname = $_REQUEST['kinname'];
	$kincontactnumber = $_REQUEST['kincontactnumber'];
	$salutation = $_REQUEST['salutation'];
	
	$paymenttype = $_REQUEST['searchpaymentcode'];
	$subtype = $_REQUEST['searchsubcode'];
	$billtype = $_REQUEST['billtype'];
	$accountname = $_REQUEST['searchaccountcode'];
	//echo $accountname;
	$planname = $_REQUEST['planname'];
	$planvaliditystart = $_REQUEST['planvaliditystart'];
	$planexiprydate = $_REQUEST['planexpirydate'];
	$visitlimit = $_REQUEST['visitlimit'];	
	
	$maintype = $_REQUEST['searchpaymentcode'];
	//echo $maintype;
	$subtype = $_REQUEST['searchsubcode'];
	//echo $subtype;
	$accountexpirydate = $_REQUEST['accountexpirydate'];
	$planexpirydate = $_REQUEST['planexpirydate'];
	$overalllimit = $_REQUEST['overalllimit'];
	
	$planfixedamount = $_REQUEST["planfixedamount"];
	$planpercentage = $_REQUEST["planpercentage"];
	$locationcode = $_REQUEST['locationcode'];
	$locationname = $_REQUEST['locationname'];
	
		
		$date = date('Y-m-d-H-i-s');
		$uploaddir = "patientphoto";
		//$final_filename="$companyname.jpg";
		$final_filename = "$customercode.jpg";
		$uploadfile123 = $uploaddir . "/" . $final_filename;
		$target_path = $uploadfile123;
		$imagepath = $target_path;
		
		//echo $_FILES['uploadedfile']['name'];
	if ($_FILES['uploadedfile']['name'] != '')
		{
			if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) 
			{
			
				$query1 = "update master_customer set customername='$customername',typeofcustomer='$typeofcustomer',address1='$address1',address2='$address2',
				area='$area',city='$city',state='$state',country='$country',pincode='$pincode',phonenumber1='$phonenumber1',phonenumber2='$phonenumber2',faxnumber='$faxnumber',mobilenumber='$mobilenumber',emailid1='$emailid1', emailid2='$emailid2',
				remarks='$remarks', status='$status', tinnumber='$tinnumber', cstnumber='$cstnumber', openingbalance='$openingbalance', insuranceid='$insuranceid', 
				gender='$gender',mothername='$mothername',age='$age',nameofrelative='$nameofrelative',dateofbirth='$dateofbirth',maritalstatus='$maritalstatus',occupation='$occupation',mrdno = '$mrdno',promotion = '$promotion',nationalidnumber='$nationalidnumber', 
				ageduration='$ageduration',salutation='$salutation',bloodgroup='$bloodgroup',registrationdate='$registrationdate',registrationtime='$registrationtime',customerlastname='$customerlastname',customerfullname='$customerfullname',
				kinname='$kinname',kincontactnumber='$kincontactnumber',paymenttype='$paymenttype',subtype='$subtype',planname='$planname', 
				planvaliditystart='$planvaliditystart',accountname='$accountname',customermiddlename='$customermiddlename',visitlimit='$visitlimit', 
				maintype='$maintype',billtype='$billtype',accountexpirydate='$accountexpirydate',planexpirydate='$planexpirydate',overalllimit='$overalllimit',planfixedamount='$planfixedamount',planpercentage='$planpercentage',locationcode='$locationcode',locationname='$locationname' where customercode='$customercode'";
				$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		
			
				$query1 = "update master_customer set photoavailable = 'YES' where customercode = '$customercode'";
				$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
				
				$status = 'success';
			}
			else
			{
				//echo $errmsg = "Failed. Photo Upload Not Completed. File Size More Than 100 KB Not Accepted.";
				$status = 'failed';
			}
		}
		else
		{
				$query1 = "update master_customer set customername='$customername',typeofcustomer='$typeofcustomer',address1='$address1',address2='$address2',
				area='$area',city='$city',state='$state',country='$country',pincode='$pincode',phonenumber1='$phonenumber1',phonenumber2='$phonenumber2',faxnumber='$faxnumber',mobilenumber='$mobilenumber',emailid1='$emailid1', emailid2='$emailid2',
				remarks='$remarks', status='$status', tinnumber='$tinnumber', cstnumber='$cstnumber', openingbalance='$openingbalance', insuranceid='$insuranceid', 
				gender='$gender',mothername='$mothername',age='$age',nameofrelative='$nameofrelative',dateofbirth='$dateofbirth',maritalstatus='$maritalstatus',occupation='$occupation',nationalidnumber='$nationalidnumber', 
				ageduration='$ageduration',salutation='$salutation',bloodgroup='$bloodgroup',registrationdate='$registrationdate',registrationtime='$registrationtime',customerlastname='$customerlastname',customerfullname='$customerfullname',
				kinname='$kinname',kincontactnumber='$kincontactnumber',paymenttype='$paymenttype',subtype='$subtype',planname='$planname', 
				planvaliditystart='$planvaliditystart',accountname='$accountname',customermiddlename='$customermiddlename',visitlimit='$visitlimit', 
				maintype='$maintype',billtype='$billtype',accountexpirydate='$accountexpirydate',planexpirydate='$planexpirydate',overalllimit='$overalllimit',planfixedamount='$planfixedamount',planpercentage='$planpercentage',locationcode='$locationcode',locationname='$locationname' where customercode='$customercode'";
				$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	}
			
		$customername = '';
		$companyname = '';
		$gender = '';
		$mothername='';
		$age = '';
		$title1  = '';
		$title2  = '';
		$contactperson1  = '';
		$contactperson2 = '';
		$designation1 = '';
		$designation2  = '';
		$phonenumber1 = '';
		$phonenumber2 = '';
		$emailid1  = '';
		$emailid2 = '';
		$faxnumber1 = '';
		$faxnumber2  = '';
		$address = '';
		$location = '';
		$city  = '';
		$state = '';
		$pincode = '';
		$country = '';
		$tinnumber = '';
		$cstnumber = '';
		$companystatus  = '';
		$openingbalance = '0.00';
		$insuranceid = '';
		$nameofrelative = '';
		$dateposted = $updatedatetime;
		$dateofbirth = '';
		$maritalstatus = '';
		$occupation = '';
		$nationalidnumber = '';
		$ageduration = '';
		$bloodgroup = '';
		$customerlastname = '';
		$kinname = '';
		$kincontactnumber = '';
		$salutation = '';
	
		$customername = '';
		$customermiddlename = '';
		$customerlastname = '';
		$paymenttype = '';
		$subtype = '';
		$billtype = '';
		$accountname = '';
		$planname = '';
		$planvaliditystart = '';
		$planvalidityend = '';
		$visitlimit='';
	
		$maintype = '';
		$subtype = '';
		$accountexpirydate = '';
		$planexpirydate = '';
		$overalllimit = '';
	
		$planfixedamount = '';
		$planpercentage = '';
		
		header("location:searchprepaidpatient.php?patientcode=$customercode"); 
		
		exit;
		
}
else
{
	$customername = '';
	$companyname = "";
	$gender = '';
	$mothername='';
	$age = '';
	$title1  = "";
	$title2  = "";
	$contactperson1  = "";
	$contactperson2 = "";
	$designation1 = "";
	$designation2  = "";
	$phonenumber1 = "";
	$phonenumber2 = "";
	$emailid1  = "";
	$emailid2 = "";
	$faxnumber1 = "";
	$faxnumber2  = "";
	$address1 = "";
	$address2 = "";
	$location = "";
	$city  = "";
	$pincode = "";
	$country = "";
	$state = "";
	$tinnumber = "";
	$cstnumber = "";
	$companystatus  = "";
	$openingbalance = "";
	$insuranceid = "";
	$nameofrelative = '';
	$dateposted = $updatedatetime;
	$dateofbirth = '';
	$maritalstatus = '';
	$occupation = '';
	$nationalidnumber = '';
	$ageduration = '';
	$bloodgroup = '';
	$customerlastname = '';
	$kinname = '';
	$kincontactnumber = '';
	$salutation = '';

	$customername = '';
	$customermiddlename = '';
	$customerlastname = '';
	$paymenttype = '';
	$subtype = '';
	$billtype = '';
	$accountname = '';
	$planname = '';
	$planvaliditystart = '';
	$planexpiredate = '';
	$visitlimit = '';
	
	$maintype = '';
	$subtype = '';
	$accountexpirydate = '';
	$planexpirydate = '';
	$overalllimit = '';
	
	$planfixedamount = '';
	$planpercentage = '';
	
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'success')
{
		$errmsg = "Success. New Patient Updated.";
		if (isset($_REQUEST["cpynum"])) { $cpynum = $_REQUEST["cpynum"]; } else { $cpynum = ""; }
		if ($cpynum == 1) //for first company.
		{
			$errmsg = "Success. New Patient Updated.";
		}
		$bgcolorcode = 'success';
}
else if ($st == 'failed')
{
		$errmsg = "Failed. Photo Upload Failed Or Patient Already Exists.";
		$bgcolorcode = 'failed';
}

if (isset($_REQUEST["cpycount"])) { $cpycount = $_REQUEST["cpycount"]; } else { $cpycount = ""; }
if ($cpycount == 'firstcompany')
{
	$errmsg = "Welcome. You Need To Add Your Company Details Before Proceeding.";
}




if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
 
           if($patientcode != '')
		   {
		     $query2 = "select * from master_customer where customercode='$patientcode'";
			  $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			  $res2 = mysql_fetch_array($exec2);
			  
			  $res2customercode = $res2['customercode'];
			 $res2maritalstatus = $res2['maritalstatus'];
			 $res2county = $res2['state'];
			 $res2country = $res2['country'];
			  $res2customerfirstname = $res2['customername'];
			  $res2mrdno = $res2['mrdno'];
			    $res2customermiddlename = $res2['customermiddlename'];
				  $res2customerlastname = $res2['customerlastname'];
			  $res2occupation = $res2['occupation'];
			  $res2customercode = $res2['customercode'];
			  //$res2contactperson1 = $res2['contactperson1'];
			  $paymenttypeanum = $res2['paymenttype'];
			  $locationcode = $res2['locationcode'];
			   
			  $query3 = "select * from master_paymenttype where auto_number = '$paymenttypeanum'";
			  $exec3 = mysql_query($query3) or die ("Error in Query5".mysql_error());
			  $res3 = mysql_fetch_array($exec3);
			  $res3paymenttype = $res3['paymenttype'];
			  $res3paymentanum = $res3['auto_number']; 
			  
			  $subtypeanum = $res2['subtype'];
			  
			  $query4 = "select * from master_subtype where auto_number = '$subtypeanum'";
			  $exec4 = mysql_query($query4) or die ("Error in Query5".mysql_error());
			  $res4 = mysql_fetch_array($exec4);
			  $res4subtype = $res4['subtype'];
			  $res4subanum = $res4['auto_number'];
			  $res2billtype = $res2['billtype'];
			  $accountnameanum = $res2['accountname'];
	          $query5 = "select * from master_accountname where auto_number = '$accountnameanum'";
			  $exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
			  $res5 = mysql_fetch_array($exec5);
			  $res5accountname = $res5['accountname'];
			  $res5accountanum = $res5['auto_number'];
			  $res2accountexpirydate = $res2['accountexpirydate'];
			  $plannameanum = $res2['planname'];
			  $query6 = "select * from master_planname where auto_number = '$plannameanum'";
			  $exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
			  $res6 = mysql_fetch_array($exec6);
			  $res6planname = $res6['planname'];
			  $res6salutation = $res2['salutation'];
			  $res2planexpirydate = $res2['planexpirydate'];
			  $res2visitlimit = $res2['visitlimit'];
			  $res2overalllimit = $res2['overalllimit'];
			  $res2customername	= $res2['customerfullname'];
			  $res2age = $res2['age'];
			  $res2gender = $res2['gender'];
			  $res2mothername = $res2['mothername'];
			  $res2bloodgroup = $res2['bloodgroup'];
			  $res2area = $res2['area'];
			  $res2nationalidnumber = $res2['nationalidnumber'];
			 
			  $res2pincode = $res2['pincode'];
			  $res2mobilenumber = $res2['mobilenumber'];
			  $res2phonenumber1 = $res2['phonenumber1'];
			  $res2phonenumber2 = $res2['phonenumber2'];
			  $res2emailid1 = $res2['emailid1'];
			   $res2emailid2 = $res2['emailid2'];
			  $res2kinname = $res2['kinname'];
			  $res2kincontact = $res2['kincontactnumber'];
			  $res2emailid2 = $res2['emailid2'];
			  $res2faxnumber1 = $res2['faxnumber'];
			  $res2faxnumber2 = '';
			  $res2anum = $res2['auto_number'];
			  $res2address1 = $res2['address1'];
			  $res2address2 = $res2['address2'];
			  //$res2occupation = $res2['occupation'];
			  $res2city = $res2['city'];
			  $res2dob = $res2['dateofbirth'];
			   $res2planfixedamount = $res2['planfixedamount'];
			   $res2planpercentage = $res2['planpercentage'];
			  $res2openingbalance1 = $res2['openingbalance'];
			  $res2insuranceid = $res2['insuranceid'];
			  $res2registrationdate = $res2['registrationdate'];
			  
			  if ($res2registrationdate == '0000-00-00') $res2registrationdate = '';
			  $res2registrationtime = $res2['registrationtime'];
			  $res2consultingdoctor = $res2['consultingdoctor'];
			  $query201 = "select * from master_doctor where doctorcode = '$res2consultingdoctor'";
			  $exec201 = mysql_query($query201) or die ("Error in Query201".mysql_error());
			  $res201 = mysql_fetch_array($exec201);
			  $res2consultingdoctor = $res201['doctorname'];
			  
			  $query1112 = "select * from master_location where locationcode = '$locationcode'";
				$exec1112 = mysql_query($query1112) or die ("Error in Query1112".mysql_error());
				$res1112 = mysql_fetch_array($exec1112);
			 $locationname = $res1112["locationname"];		
			  
			}  //$query3 = "select * from master_patientadmission where patientcode = '$res2customercode' order by auto_number desc limit 0, 1";
			  //$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
			  //$res3 = mysql_fetch_array($exec3);
			  //$res3ipnumber = $res3['ipnumber'];
			
			  
if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
if ($svccount == 'firstentry')
{
	$errmsg = "Please Add Patient To Proceed For Billing.";
	$bgcolorcode = 'failed';
}


include ("autocompletebuild_prepaidpaymenttype.php");

?>
<head>
<script type="text/javascript" src="js/autocomplete_paymenttype.js"></script>
<script type="text/javascript" src="js/autosuggestpaymenttype_edit.js"></script>
<script type="text/javascript" src="js/autocomplete_subtypes.js"></script>
<script type="text/javascript" src="js/autosuggestsubtypes.js"></script>
<script type="text/javascript" src="js/autocomplete_account.js"></script>
<script type="text/javascript" src="js/autosuggestaccount.js"></script>
<script type="text/javascript">
window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchpaymenttype"), new StateSuggestions());
	var oTextbox = new AutoSuggestControl1(document.getElementById("searchsubtype"), new StateSuggestions1());
	var oTextbox = new AutoSuggestControl2(document.getElementById("searchaccountname"), new StateSuggestions2());        
}
</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />  
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
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
-->
</style>

<script language="javascript">





function GetDifference1()
{
	//To reset any existing values;
	document.getElementById("age").value = "";
	document.getElementById("ageduration").value = "";

	var dtFrom = document.getElementById("dateofbirth").value;
	var dtTo = document.getElementById("todaydate").value;
	//alert(dtFrom);
	//alert(dtTo);

   //To change format from YYYY-MM-DD to MM-DD-YYYY
    var mystr1 = dtFrom;
    var myarr1 = mystr1.split("-");
    var dtFrom = myarr1[1] + "-" + myarr1[2] + "-" + myarr1[0];
    
    var mystr2 = dtTo;
    var myarr2 = mystr2.split("-");
    var dtTo = myarr2[1] + "-" + myarr2[2] + "-" + myarr2[0];
    
	var dtFrom = new Date(dtFrom);
	var dtTo = new Date(dtTo);
    
	//document.getElementById("totalmonths1").value = months_between(dtFrom, dtTo);
	var varMonthCount = months_between(dtFrom, dtTo);
	var varMonthCount = parseInt(varMonthCount);
	if (varMonthCount <= 12)// || varMonthCount > 0)
	{
		//document.getElementById('ageduration').selectedIndex = 1; //To Select Month, index number 2 given.
		document.getElementById("age").value = varMonthCount;
		document.getElementById('ageduration').value = 'MONTHS';
	}
	
	//alert (varMonthCount);
	//To Count Days.
	if (varMonthCount == 0)// || varMonthCount > 0)
	{
		//document.getElementById('ageduration').selectedIndex = 1; //To Select Month, index number 2 given.
		document.getElementById('ageduration').value = 'DAYS';
	
		var dtFrom = document.getElementById("dateofbirth").value;
		var dtTo = document.getElementById("todaydate").value;
		
		///*
		//To change format from YYYY-MM-DD to MM-DD-YYYY
		var mystr1 = dtFrom;
		var myarr1 = mystr1.split("-");
		//alert (myarr1);
	    var dtFrom = myarr1[1] + "-" + myarr1[2] + "-" + myarr1[0];
		
		var mystr2 = dtTo;
		var myarr2 = mystr2.split("-");
	    var dtTo = myarr2[1] + "-" + myarr2[2] + "-" + myarr2[0];
		
		//alert (dtFrom);
		//alert (dtTo);
		
		var dtFrom = new Date(dtFrom);
		var dtTo = new Date(dtTo);
		
		//alert (dtFrom);
		//alert (dtTo);
		
		//*/
		
		// 24 hours, 60 minutes, 60 seconds, 1000 milliseconds
		var varDaysCount = Math.round((dtTo - dtFrom) / (1000 * 60 * 60 * 24)); // round the amount of days
		//alert (varDaysCount);
		document.getElementById("age").value = varDaysCount;

	}
	
	if (varMonthCount > 12)
	{
		var dtFrom = document.getElementById("dateofbirth").value;
		//alert(dtFrom);
	
	   //To change format from YYYY-MM-DD to YYYYMMDD
		var mystr1 = dtFrom;
		var myarr1 = mystr1.split("-");
		var dtFrom = myarr1[0] + "" + myarr1[1] + "" + myarr1[2];
		//alert (dtFrom);
		
		//var dob='19800810';
		var dob = dtFrom;
		var year = Number( dob.substr(0,4) );
		var month = Number( dob.substr(4,2) ) - 1;
		var day = Number( dob.substr(6,2) );
		var today = new Date();
		var age = today.getFullYear() - year;
		if( today.getMonth() < month || ( today.getMonth() == month && today.getDate() < day )) { age--; }
		//alert(age);
		var varYearsCount = age;
		
		document.getElementById('ageduration').value = 'YEARS';
		document.getElementById("age").value = varYearsCount;
	}
	
}

function months_between(date1, date2)
{
	return date2.getMonth() - date1.getMonth() + (12 * (date2.getFullYear() - date1.getFullYear()));
}

function dobcalc()
{
var age=document.getElementById("age").value;
document.getElementById('ageduration').value = 'YEARS';
var year1= new Date();
var yob=year1.getFullYear() - age;
var dob= yob+"-"+"0"+1+"-"+"0"+1;
document.getElementById("dateofbirth").value = dob;
//alert(dob);
}
function process1backkeypress1()
{
	
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
}

function funcGenderAutoSelect1()
{
	
	<?php
	$query11 = "select * from master_salutation where recordstatus = ''";
	$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
	while ($res11 = mysql_fetch_array($exec11))
	{
	$res11salutation = $res11["salutation"];
	$res11gender = $res11['gender'];
	?>
		if(document.form1.salutation.value == "<?php echo $res11salutation; ?>")
		{
			document.getElementById("gender").value = "<?php echo $res11gender; ?>";
		}
	<?php
	}
	
	?>
	
}
function funcVistLimit()
{
	<?php
	$query11 = "select * from master_planname where recordstatus = 'ACTIVE'";
	$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
	while ($res11 = mysql_fetch_array($exec11))
	{
	$res11plannameanum = $res11['auto_number'];
	$res11planname = $res11["planname"];
	$res11planexpirydate = $res11['planexpirydate'];
	//$res11visitlimit = $res11['visitlimit'];
	//$res11overalllimit = $res11['overalllimit'];
	$res11planfixedamount = $res11['planfixedamount'];
	$res11planpercentage = $res11['planpercentage'];
	?>
	 	var varPlanName = document.getElementById("planname").value;
		if( varPlanName == "<?php echo $res11plannameanum; ?>")
		{
			document.getElementById("planexpirydate").value = "<?php echo $res11planexpirydate; ?>";	
			document.getElementById("visitlimit").value = "";
			document.getElementById("overalllimit").value = "";
			document.getElementById("planfixedamount").value = "<?php echo $res11planfixedamount; ?>";
			document.getElementById("planpercentage").value = "<?php echo $res11planpercentage; ?>";
		}
	<?php
	}
	
	?>
	
}


function funcPaymentTypeChange1()
{
	document.getElementById("billtype").value = "";
	
	//alert (document.form1.paymenttype.value);

	if(document.form1.paymenttype.value == "1") // For CASH
	{	
		document.getElementById("billtype").value = "PAY NOW";
	}
	else
	{
		document.getElementById("billtype").value = "PAY LATER";
	}	
	
	<?php 
	$query12 = "select * from master_paymenttype where recordstatus = ''";
	$exec12 = mysql_query($query12) or die ("Error in Query11".mysql_error());
	while ($res12 = mysql_fetch_array($exec12))
	{
	$res12paymenttypeanum = $res12["auto_number"];
	$res12paymenttype = $res12["paymenttype"];
	?>
	if(document.getElementById("searchpaymentcode").value=="<?php echo $res12paymenttypeanum; ?>")
	{
		document.getElementById("subtype").options.length=null; 
		var combo = document.getElementById('subtype'); 	
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Sub Type", ""); 
		<?php
		$query10 = "select * from master_subtype where maintype = '$res12paymenttypeanum' and recordstatus = '' order by subtype";
		$exec10 = mysql_query($query10) or die ("error in query10".mysql_error());
		while ($res10 = mysql_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10subtypeanum = $res10["auto_number"];
		$res10subtype = $res10["subtype"];
		?>
			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10subtype;?>", "<?php echo $res10subtypeanum;?>"); 
		<?php 
		}
		?>
	}
	<?php
	}
	?>	
}


function funcSubTypeChange1()
{
	<?php 
	$query12 = "select * from master_subtype where recordstatus = ''";
	$exec12 = mysql_query($query12) or die ("Error in Query11".mysql_error());
	while ($res12 = mysql_fetch_array($exec12))
	{
	$res12subtypeanum = $res12["auto_number"];
	$res12subtype = $res12["subtype"];
	?>
	if(document.getElementById("subtype").value=="<?php echo $res12subtypeanum; ?>")
	{
		document.getElementById("accountname").options.length=null; 
		var combo = document.getElementById('accountname'); 	
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Account Name", ""); 
		<?php
		$query10 = "select * from master_accountname where subtype = '$res12subtypeanum' and recordstatus = 'ACTIVE' and expirydate > NOW() order by accountname";
		$exec10 = mysql_query($query10) or die ("error in query10".mysql_error());
		while ($res10 = mysql_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10accountnameanum = $res10["auto_number"];
		$res10accountname = $res10["accountname"];
		?>
			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10accountname;?>", "<?php echo $res10accountnameanum;?>"); 
		<?php 
		}
		?>
	}
	<?php
	}
	?>	
}


	
function process1()
{

	//alert ("Inside Function");
	if (document.form1.searchpaymentcode.value == "")
	{
		alert ("Please Select Plan Type.");
		document.form1.paymenttype.focus();
		return false;
	}
	if (document.form1.searchsubcode.value == "")
	{
		alert ("Please Select Sub Type.");
		document.form1.subtype.focus();
		return false;
	}
	if (document.form1.billtype.value == "PAY LATER")
	{
		if (document.form1.searchaccountcode.value == "")
		{
			alert ("Please Select Account Name.");
			document.form1.accountname.focus();
			return false;
		}
		if (document.form1.planname.value == "")
		{
			alert ("Please Select Plan Name.");
			document.form1.planname.focus();
			return false;
		}
	}
	
	if (document.form1.customername.value == "")
	{
		alert ("Please Enter First Name.");
		document.form1.customername.focus();
		return false;
	}
	if (document.form1.dateofbirth.value == "")
	{
		alert ("Please Select Date Of Birth.");
		document.form1.dateofbirth.focus();
		return false;
	}
	
	if (document.form1.gender.value == "")
	{
		alert ("Please Select Gender");
		document.form1.gender.focus();
		return false;
	}
	
	
	if (document.getElementById("age").value < 18)
	{
		if (document.form1.mothername.value == "")
		{
			alert ("Please Enter Guardian Name.");
			//document.form1.mothername.focus();
			return false;
		}
	}
		
	if (document.getElementById("age").value >= 18)
	{	
		if (document.form1.nationalidnumber.value == "")
		{
			alert ("Please Enter NationalId Number .");
			//document.form1.nationalidnumber.focus();
			return false;
		}	
	}
	
}




</script>

<script src="js/datetimepicker_css.js"></script>

<script type="text/javascript" src="js/nationalidnovalidation1.js"></script>
<script type="text/javascript" src="js/nationalidnovalidation2.js"></script>

</head>

<body>
<table width="103%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#E0E0E0">
	<?php 
	
		include ("includes/menu1.php"); 
	
	
	
	?>	</td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top">


      	  <form name="form1" id="form1" method="post" onKeyDown="return disableEnterKey()" enctype="multipart/form-data" action="editprepaidpatient.php" onSubmit="return process1()">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
		
          <td width="1311"><table width="1300" height="282" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
                <td bgcolor="#CCCCCC" class="bodytext3" colspan="2"><strong> Edit Patient Registration </strong></td>
                <!--<td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                <td bgcolor="#CCCCCC" class="bodytext3" colspan="8">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="15" align="left" valign="middle"  
				bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else  { echo 'red'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
              </tr>
              <!--<tr bordercolor="#000000" >
                  <td  align="left" valign="middle"  class="bodytext3"  colspan="4"><strong>Registration</strong></font></div></td>
                </tr>-->
              <!--<tr>
                  <tr  bordercolor="#000000" >
                  <td  align="left" valign="middle"  class="bodytext3" colspan="4"><div align="right">* Indicates Mandatory</div></td>
                </tr>-->
				
				<tr>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Type </td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"> 
				  <input type="hidden" name="locationcode" id="locationcode" value="<?php echo $locationcode; ?>">
				  <input type="hidden" name="locationname" id="locationname" value="<?php echo $locationname; ?>">
				  <input type="text" name="searchpaymenttype" id="searchpaymenttype" value="<?php echo $res3paymenttype; ?>" autocomplete="off" tabindex="1">
				  <input type="hidden" name="searchpaymentcode" id="searchpaymentcode">
				  <select name="paymenttype" id="paymenttype" onChange="return funcPaymentTypeChange1();"  style="width: 150px; display:none;">
                  <option value="" selected="selected">Select Type</option>  
				  <?php
				$query5 = "select * from master_paymenttype where recordstatus = ''";
				$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
				while ($res5 = mysql_fetch_array($exec5))
				{
				$res5anum = $res5["auto_number"];
				$res5paymenttype = $res5["paymenttype"];
				?>
                    <option value="<?php echo $res5anum; ?>"><?php echo $res5paymenttype; ?></option>
                    <?php
				}
				?>
                  </select></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Sub Type </td>
				  <td width="14%" align="left" valign="middle"  bgcolor="#E0E0E0">
				  <input type="text" name="searchsubtype" id="searchsubtype" value="<?php echo $res4subtype; ?>" autocomplete="off" tabindex="2">
				  <input type="hidden" name="searchsubcode" id="searchsubcode">
				  <input name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox" type="hidden" value="">
				  <select name="subtype" id="subtype" onChange="return funcSubTypeChange1()" style="display:none">
                    <option value="" selected="selected">Select Subtype</option>
<!--					
					<?php
				if ($subtype == '')
				{
					echo '<option value="" selected="selected">Select Subtype</option>';
				}
				else
				{
					$query51 = "select * from master_subtype where recordstatus = ''";
					$exec51 = mysql_query($query51) or die ("Error in Query51".mysql_error());
					$res51 = mysql_fetch_array($exec51);
					$res51subtype = $res51["subtype"];
					echo '<option value="'.$res51subtype.'" selected="selected">'.$res51subtype.'</option>';
				}
				
				$query5 = "select * from master_subtype where recordstatus = '' order by subtype";
				$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
				while ($res5 = mysql_fetch_array($exec5))
				{
				$res5anum = $res5["auto_number"];
				$res5paymenttype = $res5["subtype"];
				?>
                    <option value="<?php echo $res5paymenttype; ?>"><?php echo $res5paymenttype; ?></option>
                    <?php
				}
				?>
-->				  
                  </select>				  </td>
				  <td width="7%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext32">Account </span></td>
				  <td width="15%" align="left" valign="middle"  bgcolor="#E0E0E0"><strong>
				  <input name="searchaccountname" type="text" id="searchaccountname" value="<?php echo $res5accountname; ?>" autocomplete="off" tabindex="3">
              <input name="searchsuppliernamehiddentextbox" id="searchsuppliernamehiddentextbox" value="" type="hidden">
			  <input name="searchaccountcode" id="searchaccountcode" value="" type="hidden">
						<select name="accountname" id="accountname" onChange="return funcAccountNameChange1()" style="display:none;">
                      <option value="" selected="selected">Select Account Name</option>
<!--					  
					  <?php
				if ($accountname == '')
				{
					echo '<option value="" selected="selected">Select Account Name</option>';
				}
				else
				{
					$query51 = "select * from master_accountname where recordstatus = ''";
					$exec51 = mysql_query($query51) or die ("Error in Query51".mysql_error());
					$res51 = mysql_fetch_array($exec51);
					$res51accountname = $res51["accountname"];
					//echo '<option value="">Select Normal Tax</option>';
					echo '<option value="'.$res51accountname.'" selected="selected">'.$res51accountname.'</option>';
				}
				
				$query5 = "select * from master_accountname where recordstatus = '' order by accountname";
				$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
				while ($res5 = mysql_fetch_array($exec5))
				{
				$res5anum = $res5["auto_number"];
				$res5accountname = $res5["accountname"];
				?>
                      <option value="<?php echo $res5accountname; ?>"><?php echo $res5accountname; ?></option>
                      <?php
				}
				?>
-->				
                    </select>
				    </strong></td>
					<td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext32"> Validity</span></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><input type="text" name="accountexpirydate" id="accountexpirydate" value="<?php echo $res2accountexpirydate; ?>" readonly ></td>
				</tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext32">Plan</span></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0">
				  <input type="hidden" name="planvaliditystart" id="planvaliditystart" value="<?php echo $registrationdate; ?>" readonly>
                      <strong><span class="bodytext312"> 
					  <!--<img src="images2/cal.gif" onClick="javascript:NewCssCal('insurancevaliditystart')" style="cursor:pointer"/>-->
					  <input type="hidden" name="insuranceid" id="insuranceid" value="<?php echo $insuranceid; ?>" size="20">
                      </span>
                      <select name="planname" id="planname"  onChange="return funcVistLimit()" style="width: 150px;">
                        <option value="" selected="selected">Select Plan Name</option>
                        <?php
						if ($res6planname != '')
						{
						?>
                        <option value="<?php echo $plannameanum; ?>" selected="selected"><?php echo $res6planname; ?></option>
                        <?php
						}
						?>
                      </select>
                      </strong></td>
					  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Copay</td>
				      <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="planfixedamount" id="planfixedamount" readonly value="<?php echo $res2planfixedamount; ?>" ></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext32">Bill Type </span></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><strong>
				  <input name="tpacompany" id="tpacompany" value="" type="hidden">
<!--				  
					<select name="tpacompany" id="tpacompany">
					<?php
					if ($tpacompany == '')
					{
					echo '<option value="" selected="selected">Select TPA Company</option>';
					}
					else
					{
					$query51 = "select * from master_tpacompany where recordstatus = ''";
					$exec51 = mysql_query($query51) or die ("Error in Query51".mysql_error());
					$res51 = mysql_fetch_array($exec51);
					$res51tpacompany = $res51["tpacompany"];
					//echo '<option value="">Select Normal Tax</option>';
					echo '<option value="'.$res51tpacompany.'" selected="selected">'.$res51tpacompany.'</option>';
					}
					
					$query5 = "select * from master_tpacompany where recordstatus = '' order by tpacompany";
					$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
					while ($res5 = mysql_fetch_array($exec5))
					{
					$res5anum = $res5["auto_number"];
					$res5tpacompany = $res5["tpacompany"];
					?>
					<option value="<?php echo $res5tpacompany; ?>"><?php echo $res5tpacompany; ?></option>
					<?php
					}
					?>
					</select>
-->
				  <input type="text" name="billtype" id="billtype" readonly value="<?php echo $res2billtype; ?>">
				  </strong></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"> Limit </td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" name="overalllimit" id="overalllimit" readonly value="<?php echo $res2overalllimit; ?>">                  </td>
				  </tr>
				<tr>				</tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Salutation</td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><strong>
				    <select name="salutation" id="salutation" onChange="return funcGenderAutoSelect1()" style="width: 150px;">
                   <?php
						if ($res6salutation != '')
						{
						?>
						<option value="<?php echo $res6salutation; ?>" selected="selected"><?php echo $res6salutation; ?></option>
						<?php
						}
						else
						{
						?>
						<option value="" selected="selected">Select Salutation</option>
						<?php
						}
						$query1 = "select * from master_salutation where recordstatus <> 'deleted' order by salutation";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						while ($res1 = mysql_fetch_array($exec1))
						{
						$res1salutation = $res1["salutation"];
						?>
						<option value="<?php echo $res1salutation; ?>"><?php echo $res1salutation; ?></option>
						<?php
						}
						?>
                    </select>
				  </strong></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Gender</td>
			      <td align="left" valign="middle"  bgcolor="#E0E0E0">
				  <input name="gender" id="gender" value="<?php echo $res2gender; ?>" readonly>
<!--				  
				  <select name="gender">
                      <option value="" selected="selected">Select Gender</option>
                      <option value="MALE">MALE</option>
                      <option value="FEMALE">FEMALE</option>
                    </select>  
-->					</td>
<td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">DOB </td>
			      <td align="left" valign="middle"  bgcolor="#E0E0E0">
				  <input type="text" name="dateofbirth" id="dateofbirth" value="<?php echo $res2dob; ?>" onChange="return GetDifference1()" style=" background-color:#E0E0E0;">
                      <strong><span class="bodytext312"> <img src="images2/cal.gif" onClick="javascript:NewCssCal('dateofbirth')" style="cursor:pointer"/> </span></strong>
                      <input type="hidden" name="todaydate" id="todaydate" value="<?php echo date('Y-m-d'); ?>"></td>
			      <td align="left" valign="middle" bgcolor="#E0E0E0" class="bodytext3">Age</td>
			      <td align="left" valign="middle" bgcolor="#E0E0E0"><input name="age" type="text" id="age" value="<?php echo $res2age; ?>" size="5" onKeyUp="return dobcalc();" style="background-color:#E0E0E0;">
                      <!--				  
				  <select name="age">
                    <option value="">Select Age</option>
					<?php
					for ($i=0;$i<=125;$i++)
					{
					?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php
					}
					?>
                  </select>
-->
                      <input name="ageduration" id="ageduration" value="YEARS" size="5" readonly style="background-color:#E0E0E0;">
					  <input type="hidden" name="planexpirydate" id="planexpirydate" value="<?php echo $res2planexpirydate; ?>" readonly>
                      <!--					 
					 <select name="ageduration" id="ageduration">
                        <option value="YEARS" selected="selected">YEARS</option>
                        <option value="MONTHS">MONTHS</option>
                        <option value="DAYS">DAYS</option>
                      </select>
-->                  </td>
				</tr>
				<tr>
				<td width="5%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext32"> First Name   </span></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="customername" id="customername" value="<?php echo $res2customerfirstname; ?>" style="text-transform:uppercase;" >
				<input type="hidden" name="nameofrelative" id="nameofrelative" value="<?php echo $nameofrelative; ?>" size="45"></td>
				<td width="6%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext32"> Middle Name   </span></td>
				<td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
				<input name="customermiddlename" id="customermiddlename" value="<?php echo $res2customermiddlename; ?>" style="text-transform:uppercase;"></td>
				<td width="6%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext32"> Last Name   </span></td>
				<td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="customerlastname" id="customerlastname" value="<?php echo $res2customerlastname; ?>" style="text-transform:uppercase;" ></td>
				<td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">National ID</td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0">
				   <input name="nationalidnumber" id="nationalidnumber" value="<?php echo $res2nationalidnumber; ?>"  onBlur="return funcNationalIDValidation1()" size="20"/>
				   <input type="hidden" name="visitlimit" id="visitlimit" value="<?php echo $res2visitlimit; ?>" readonly>
				   <input type="hidden" name="planpercentage" id="planpercentage" readonly value="<?php echo $res2planpercentage; ?>"></td> 
				</tr>
				
				<tr>
				  <td colspan="15" align="left" valign="middle"  bgcolor="#CCCCCC" class="bodytext3"><strong> Personal Details </strong></td>
				  </tr>
			    <tr>
			      <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext32">Guardian</span></td>
			      <td align="left" valign="middle"  bgcolor="#E0E0E0"><label>
			        <input name="mothername" type="text" id="mothername" value="<?php echo $res2mothername; ?>" size="20" />
			      </label></td>
                  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"> Status </td>
			      <td align="left" valign="middle"  bgcolor="#E0E0E0"><select name="maritalstatus" style="width: 150px;">
                      <option value="" selected="selected">Select Marital Status</option>
                       <?php
						if ($res2maritalstatus != '')
						{
						?>
						<option value="<?php echo $res2maritalstatus; ?>" selected="selected"><?php echo $res2maritalstatus; ?></option>
						<?php
						}
						else
						{
						?>
						<option value="" selected="selected">Select Marital Status</option>
						<?php
						}
						?> 
						<option value="SINGLE">SINGLE</option>
						<option value="MARRIED">MARRIED</option>
						    </select>                  </td>
							<td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Blood Group </td>
			      <td align="left" valign="middle"  bgcolor="#E0E0E0">
				   <select name="bloodgroup" id="bloodgroup" style="width: 150px;">
                   <?php
						if ($res2bloodgroup != '')
						{
						?>
						<option value="<?php echo $res2bloodgroup; ?>" selected="selected"><?php echo $res2bloodgroup; ?></option>
						<?php
						}
						else
						{
						?>
						<option value="" selected="selected">Select Blood Group</option>
						<?php
						}
						$query15 = "select * from master_bloodgroup where recordstatus <> 'deleted' order by bloodgroup";
						$exec15 = mysql_query($query15) or die ("Error in Query15".mysql_error());
						while ($res15 = mysql_fetch_array($exec15))
						{
						$res1bloodgroup = $res15["bloodgroup"];
						?>
						<option value="<?php echo $res1bloodgroup; ?>"><?php echo $res1bloodgroup; ?></option>
						<?php
						}
						?>
                    </select>					</td>
					<td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Address 1 </td>
			    <td width="30%" align="left" valign="middle"  bgcolor="#E0E0E0"><input name="address1" id="address1" value="<?php echo $res2address1; ?>" size="20" /></td>
	    	      </tr>
			    
			    <tr>
				 <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Occupation</td>
			      <td align="left" valign="middle"  bgcolor="#E0E0E0"><input name="occupation" id="occupation" value="<?php echo $res2occupation; ?>" size="20" /></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">City </td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<input name="city" id="city" value="<?php echo $city; ?>" size="20" />
<!--				
				<select name="city" id="city" >
                  <option value="">Select City</option>
                </select>
-->				   </td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext31"><span class="bodytext32">County </span></span></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<!--<input name="state" id="state" value="<?php echo $state; ?>" style="border: 1px solid #001E6A"  size="20" />-->
				
				<select name="state" id="state" onChange="return processflowitem1()" style="width: 150px;" >
          <?php
						if ($res2county != '')
						{
						?>
						<option value="<?php echo $res2county; ?>" selected="selected"><?php echo $res2county; ?></option>
						<?php
						}
						else
						{
						?>
						<option value="" selected="selected">Select</option>
						<?php
						}
						$query1 = "select * from master_state where status <> 'deleted' order by state";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						while ($res1 = mysql_fetch_array($exec1))
						{
						$res1state = $res1["state"];
						?>
						<option value="<?php echo $res1state; ?>"><?php echo $res1state; ?></option>
						<?php
						}
						?>
                </select>			</td>
				  
                 <td width="7%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Address 2 </td>
                <td width="30%" align="left" valign="middle"  bgcolor="#E0E0E0"><input name="address2" id="address2" value="<?php echo $res2address2; ?>" size="20" /></td>
		          </tr>
		
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext32">Area</span></td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext31">
				     <input name="area" id="area" value="<?php echo $res2area; ?>" size="20" />
				   </span></td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Post Box </td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0"><input name="pincode" id="pincode" value="<?php echo $res2pincode; ?>" size="20" /></td>
			       <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Country </td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0">
				<!--<input name="country" id="country" value="<?php echo 'KENYA'; ?>" style="border: 1px solid #001E6A"  size="20" />-->
			  <select name="country" id="country" style="width: 150px;">
          <?php
						if ($res2country != '')
						{
						?>
						<option value="<?php echo $res2country; ?>" selected="selected"><?php echo $res2country; ?></option>
						<?php
						}
						else
						{
						?>
						<option value="">Select</option>
						<?php
						}
						$query1 = "select * from master_country where status <> 'deleted' order by country";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						while ($res1 = mysql_fetch_array($exec1))
						{
						$res1country = $res1["country"];
						?>
						<option value="<?php echo $res1country; ?>"><?php echo $res1country; ?></option>
						<?php
						}
						?>
                </select>				</td>
				  </tr>
			
				 <tr>
				   <td colspan="10" align="left" valign="middle"  bgcolor="#CCCCCC" class="bodytext3"><strong> Contact Details </strong></td>
			      </tr>
				 <tr>
				 <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">MRD No. </td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0"><input name="mrdno" id="mrdno" value="<?php echo $res2mrdno; ?>" size="20">			        </td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext32">Mobile No </span></td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0">
				   <input name="mobilenumber" id="mobilenumber" value="<?php echo $res2mobilenumber; ?>" size="20" /></td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Email Id 1 </td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0"><input name="emailid1" id="emailid1" value="<?php echo $res2emailid1; ?>" size="20">
			        <input type="hidden" name="tinnumber" id="tinnumber" value="<?php echo $tinnumber; ?>" style="text-transform: uppercase;"  size="20" /></td>
					<td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Next Kin Name </td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0"><input name="kinname" id="kinname" value="<?php echo $res2kinname; ?>" size="20" /></td>
			      </tr>
				 <tr>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Promotion </td>
			      <td align="left" valign="middle"  bgcolor="#E0E0E0"><select name="promotion" style="width: 150px;">
                      <option value="" selected="selected">Select Promotion</option>
                      <option value="YES">YES</option>
                      <option value="NO">NO</option>
                    </select>                  </td> 
					<td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Additional  No</td>
				    <td align="left" valign="middle"  bgcolor="#E0E0E0">
				   <input name="phonenumber1" id="phonenumber1" value="<?php echo $res2phonenumber1; ?>" size="20" />
				   <input type="hidden" name="phonenumber2" id="phonenumber2" value="<?php echo $phonenumber2; ?>" size="20"></td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Email Id 2 </td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0"><input name="emailid2" id="emailid2" value="<?php echo $res2emailid2; ?>" size="20">
			        <input type="hidden" name="cstnumber" id="cstnumber" value="<?php echo $cstnumber; ?>" style="text-transform: uppercase;"  size="20" /></td>
			      <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Kin Contact Nor </td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0"><input name="kincontactnumber" id="kincontactnumber" value="<?php echo $res2kincontact; ?>" size="20" /></td>
				  </tr>
				
				 <tr>
				   <td colspan="10" align="left" valign="middle"  bgcolor="#CCCCCC" class="bodytext3"><span class="bodytext32"><strong>Misc  Details </strong></span></td>
			      </tr>
				 <tr>
				 <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Reg Code </td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><strong><span class="bodytext312">
                    <!--<img src="images2/cal.gif" onClick="javascript:NewCssCal('insurancevalidityend')" style="cursor:pointer"/>-->
                    <input  name="customercode" id="customercode" value="<?php echo $patientcode; ?>" readonly style="border: 1px solid #001E6A; background-color:#E0E0E0;" size="20">
                  </span></strong></td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Reg Date </td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0"><input type="text" name="registrationdate" id="registrationdate" value="<?php echo $res2registrationdate; ?>" readonly style="background-color:#E0E0E0;">
                       <strong><span class="bodytext312"> <img src="images2/cal.gif" onClick="javascript:NewCssCal('registrationdate')" style="cursor:pointer"/> </span></strong></td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Reg Time </td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0"><input type="text" name="registrationtime" id="registrationtime" value="<?php echo $registrationtime; ?>" style="background-color:#E0E0E0;">
			        <input type="hidden" name="openingbalance" id="openingbalance" value="<?php echo $openingbalance; ?>" style="text-align:right" size="20"></td>
				 <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Photo </td>
				   <td colspan="3" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
                     <input type="file" name="uploadedfile" value="" size="20"/>
                    <strong>Only JPG or JPEG Files. </strong></td>
				 </tr>
				 
                 <tr>
                <td colspan="4" align="middle"  bgcolor="#E0E0E0"><div align="right"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input type="hidden" name="frmflag1" value="frmflag1" />
                  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
                  <input name="Submit222" type="submit" id="submit" value="Save Registration" accesskey="s" class="button"/>
				      </font></font></font></font></font></div></td>
              </tr>
            </tbody>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
    </table>
	</form>

</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

