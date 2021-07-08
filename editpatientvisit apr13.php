<?php 
session_start();
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("db/db_connect.php");

$errmsg = "";
$bgcolorcode = "";
$pagename = "";
$consultationfees1 = '';
$availablelimit = '';
//This include updatation takes too long to load for hunge items database.
//include ("autocompletebuild_customer1.php");

if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
$ipaddress = $_SERVER["REMOTE_ADDR"];
$username = $_SESSION['username'];

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
		 $locationname = $res1112["locationname"];		  
		  $locationcode = $res1112["locationcode"];
		   $prefix = $res1112["prefix"];
		    $suffix = $res1112["suffix"];
	}
	}
	$patientcode=$_REQUEST["patientcode"];
	$visitcode = $_REQUEST["visitcode"];
	
	$patientfirstname = $_REQUEST["patientfirstname"];
	$patientfirstname = strtoupper($patientfirstname);
	$patientmiddlename = $_REQUEST['patientmiddlename'];
	$patientmiddlename = strtoupper($patientmiddlename);
	$patientlastname = $_REQUEST["patientlastname"];
	$patientlastname = strtoupper($patientlastname);
	$patientfullname=$patientfirstname.' '.$patientmiddlename.' '.$patientlastname;
	$consultingdoctor = $_REQUEST["consultingdoctor"];
	
	$department = $_REQUEST["department"];
	
	$query43 = "select * from master_department where auto_number='$department'";
	$exec43 = mysql_query($query43) or die(mysql_error());
	$res43 = mysql_fetch_array($exec43);
	$departmentname = $res43['department'];
	
		$billnumbercode=$_REQUEST['billnumbercode'];
	
	$paymenttype = $_REQUEST["paymenttype"];
	$subtype = $_REQUEST["subtype"];
	$billtype = $_REQUEST["billtype"];
	$accountname = $_REQUEST["accountname"];
	$query87="select * from master_accountname where auto_number='$accountname'";
	$exec87=mysql_query($query87);
	$res87=mysql_fetch_array($exec87);
	$accname=$res87['accountname'];
	$accountexpirydate = $_REQUEST["accountexpirydate"];
	$planname = $_REQUEST["planname"];
	$planexpirydate = $_REQUEST["planexpirydate"];
	$consultationdate = $_REQUEST["consultationdate"];
	$consultationtime  = $_REQUEST["consultationtime"];
	$consultationtype = $_REQUEST["consultationtype"];
	$consultationfees  = $_REQUEST["consultationfees"];
	$referredby = $_REQUEST["referredby"];
	$consultationremarks = $_REQUEST["consultationremarks"];
	$complaint = $_REQUEST["complaint"];
	$registrationdate = $_REQUEST["registrationdate"];
	$visittype = $_REQUEST["visittype"];
	$visitlimit = $_REQUEST["visitlimit"];
	$overalllimit = $_REQUEST["overalllimit"];
	$visitcount = $_REQUEST["visitcount"];
	$planfixedamount = $_REQUEST["planfixedamount"];
	$planpercentageamount = $_REQUEST["planpercentageamount"];
	$updatedatetime = date('Y-m-d H:i:s');
	
	$patientspent=$_REQUEST['patientspent'];
	
	if(($planfixedamount =='0.00' && $planpercentageamount =='0.00') && ($consultationfees =='0'))
	{
	 $query1 = "update master_visitentry set patientcode='$patientcode',visitcode='$visitcode',patientfirstname='$patientfirstname',patientmiddlename='$patientmiddlename',patientlastname='$patientlastname',patientfullname='$patientfullname',consultingdoctor='$consultingdoctor',
		department='$department',paymenttype='$paymenttype',subtype='$subtype',billtype='$billtype',accountname='$accountname',accountexpirydate='$accountexpirydate',planname='$planname',planexpirydate='$planexpirydate',consultationdate='$consultationdate', 
		consultationtime='$consultationtime',consultationtype='$consultationtype',consultationfees='$consultationfees',referredby='$referredby',consultationremarks='$consultationremarks',complaint='$complaint',registrationdate='$registrationdate',visittype='$visittype',visitlimit='$visitlimit',overalllimit='$overalllimit',visitcount='$visitcount',patientspent='$patientspent',planpercentage='$planpercentageamount',planfixedamount='$planfixedamount',
		paymentstatus='completed',triagestatus='',departmentname='$departmentname',accountfullname='$accname',locationcode='$locationcode',locationname='$locationname' where patientcode='$patientcode' and visitcode='$visitcode'";
		
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	
	
	}
else if($planfixedamount =='0.00' && $planpercentageamount =='0.00')
{
	    $query1 = "update master_visitentry set patientcode='$patientcode',visitcode='$visitcode',patientfirstname='$patientfirstname',patientmiddlename='$patientmiddlename',patientlastname='$patientlastname',patientfullname='$patientfullname',consultingdoctor='$consultingdoctor',
		department='$department',paymenttype='$paymenttype',subtype='$subtype',billtype='$billtype',accountname='$accountname',accountexpirydate='$accountexpirydate',planname='$planname',planexpirydate='$planexpirydate',consultationdate='$consultationdate', 
		consultationtime='$consultationtime',consultationtype='$consultationtype',consultationfees='$consultationfees',referredby='$referredby',consultationremarks='$consultationremarks',complaint='$complaint',registrationdate='$registrationdate',visittype='$visittype',visitlimit='$visitlimit',overalllimit='$overalllimit',visitcount='$visitcount',patientspent='$patientspent',planpercentage='$planpercentageamount',planfixedamount='$planfixedamount',
		paymentstatus='completed',triagestatus='pending',departmentname='$departmentname',accountfullname='$accname',locationcode='$locationcode',locationname='$locationname' where patientcode='$patientcode' and visitcode='$visitcode'";
		
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			
			}
			else if($consultationfees =='0')
			{
			 $query1 = "update master_visitentry set patientcode='$patientcode',visitcode='$visitcode',patientfirstname='$patientfirstname',patientmiddlename='$patientmiddlename',patientlastname='$patientlastname',patientfullname='$patientfullname',consultingdoctor='$consultingdoctor',
		department='$department',paymenttype='$paymenttype',subtype='$subtype',billtype='$billtype',accountname='$accountname',accountexpirydate='$accountexpirydate',planname='$planname',planexpirydate='$planexpirydate',consultationdate='$consultationdate', 
		consultationtime='$consultationtime',consultationtype='$consultationtype',consultationfees='$consultationfees',referredby='$referredby',consultationremarks='$consultationremarks',complaint='$complaint',registrationdate='$registrationdate',visittype='$visittype',visitlimit='$visitlimit',overalllimit='$overalllimit',visitcount='$visitcount',patientspent='$patientspent',planpercentage='$planpercentageamount',planfixedamount='$planfixedamount',
		paymentstatus='completed',triagestatus='pending',departmentname='$departmentname',accountfullname='$accname',locationcode='$locationcode',locationname='$locationname' where patientcode='$patientcode' and visitcode='$visitcode'";
		
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	
			}
			else
			{
				 $query1 = "update master_visitentry set patientcode='$patientcode',visitcode='$visitcode',patientfirstname='$patientfirstname',patientmiddlename='$patientmiddlename',patientlastname='$patientlastname',patientfullname='$patientfullname',consultingdoctor='$consultingdoctor',
		department='$department',paymenttype='$paymenttype',subtype='$subtype',billtype='$billtype',accountname='$accountname',accountexpirydate='$accountexpirydate',planname='$planname',planexpirydate='$planexpirydate',consultationdate='$consultationdate', 
		consultationtime='$consultationtime',consultationtype='$consultationtype',consultationfees='$consultationfees',referredby='$referredby',consultationremarks='$consultationremarks',complaint='$complaint',registrationdate='$registrationdate',visittype='$visittype',visitlimit='$visitlimit',overalllimit='$overalllimit',visitcount='$visitcount',patientspent='$patientspent',planpercentage='$planpercentageamount',planfixedamount='$planfixedamount',paymentstatus='',triagestatus='',departmentname='$departmentname',accountfullname='$accname',locationcode='$locationcode',locationname='$locationname' where patientcode='$patientcode' and visitcode='$visitcode'";
		
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());

			}
		//$patientcode = '';
		//$visitcode = '';
		$patientfirstname = '';
		$patientmiddlename = '';
		$patientlastname = '';
		$consultingdoctor = '';
		$department = '';
		$paymenttype = '';
		$subtype = '';
		$accountname = '';
		$accountexpirydate = '';
		$planname = '';
		$planexpirydate = '';
		$consultationdate = '';
		$consultationtime = '';
		$consultationtype = '';
		$consultationfees = '';
		$referredby = '';
		$consultationremarks = '';
		$complaint = '';
		$registrationdate = '';
		$visittype = '';
		$visitlimit ='';
		$overalllimit = '';
		$planfixedamount = '';
		$planpercentageamount = '';
		$billtype ='';
		$patientspent='';
		$visitcount='';
		header("location:searchpatientvisit.php");
		//header ("location:addcompany1.php?st=success&&cpynum=1");
		
	

}
else
{
	$patientcode = '';
	$visitcode = '';
	$patientfirstname = '';
	$patientmiddlename = '';
	$patientlastname = '';
	$consultingdoctor = '';
	$department = '';
	$paymenttype = '';
	$subtype = '';
	$accountname = '';
	$accountexpirydate = '';
	$planname = '';
	$planexpirydate = '';
	$consultationdate = '';
	$consultationtime = '';
	$consultationtype = '';
	$consultationfees = '';
	$referredby = '';
	$consultationremarks = '';
	$complaint = '';
	$registrationdate = '';
	$visittype = '';
	$visitlimit = '';
	$overalllimit = '';
	$planfixedamount = '';
	$planpercentageamount = '';
	$billtype = '';
	$patientspent='';
	$visitcount='';
}

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
if ($st == 'success')
{
		$errmsg = "Success. New Visit Updated.";
		if (isset($_REQUEST["cpynum"])) { $cpynum = $_REQUEST["cpynum"]; } else { $cpynum = ""; }
		if ($cpynum == 1) //for first company.
		{
			$errmsg = "Success. New Visit Updated.";
		}
}
else if ($st == 'failed')
{
		$errmsg = "Failed. Visit Code Already Exists.";
}


$query31 = "select * from master_company where companystatus = 'Active'";
$exec31 = mysql_query($query31) or die ("Error in Query3".mysql_error());
$res31 = mysql_fetch_array($exec31);
$consultationprefix = $res31['consultationprefix'];

$query21 = "select * from master_billing order by auto_number desc limit 0, 1";
$exec21 = mysql_query($query21) or die ("Error in Query2".mysql_error());
$res21 = mysql_fetch_array($exec21);
$billnumber = $res21["billnumber"];
if ($billnumber == '')
{
	$billnumbercode =$consultationprefix.'00000001';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res21["billnumber"];
	$billnumbercode = substr($billnumber, 3, 8);
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	if (strlen($maxanum) == 1)
	{
		$maxanum1 = '0000000'.$maxanum;
	}
	else if (strlen($maxanum) == 2)
	{
		$maxanum1 = '000000'.$maxanum;
	}
	else if (strlen($maxanum) == 3)
	{
		$maxanum1 = '00000'.$maxanum;
	}
	else if (strlen($maxanum) == 4)
	{
		$maxanum1 = '0000'.$maxanum;
	}
	else if (strlen($maxanum) == 5)
	{
		$maxanum1 = '000'.$maxanum;
	}
	else if (strlen($maxanum) == 6)
	{
		$maxanum1 = '00'.$maxanum;
	}
	else if (strlen($maxanum) == 7)
	{
		$maxanum1 = '0'.$maxanum;
	}
	else if (strlen($maxanum) == 8)
	{
		$maxanum1 = $maxanum;
	}
	
	$billnumbercode = $consultationprefix.$maxanum1;
	$openingbalance = '0.00';
	//echo $companycode;
}
	function arrayHasOnlyInts($array)
{
$count=0;
$count1=0;
    foreach ($array as $key => $value)
    {
        if (is_numeric($value)) // there are several ways to do this
        {
		$count1++;    
		
        }
		else
		{
		$count=$count+1;
		
		}
    }
    return $count1; 
}	
if (isset($_REQUEST["patientcode"])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
//$patientcode = 'MSS000000014';

if ($patientcode != '')
{
	//echo 'Inside Patient Code Condition.';
	$query3 = "select * from master_customer where customercode = '$patientcode'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	$res3 = mysql_fetch_array($exec3);
	
	$patientfirstname = $res3['customername'];
	$patientfirstname = strtoupper($patientfirstname);

	$patientmiddlename = $res3['customermiddlename'];
	$patientmiddlename = strtoupper($patientmiddlename);

	$patientlastname = $res3['customerlastname'];
	$patientlastname = strtoupper($patientlastname);
	
	$patientfullname = $res3['customerfullname'];
	$patientfullname = strtoupper($patientfullname);
		
	
	
	
	$query56="select * from master_visitentry where patientcode = '$patientcode' and visitcode = '$visitcode'";
	$exec56=mysql_query($query56) or die(mysql_error());
	$res56=mysql_fetch_array($exec56);
	$departmentanum = $res56['department'];
	$visitlimit = $res56['visitlimit'];	
	$overalllimit = $res56['overalllimit'];
	$planfixedamount = $res56['planfixedamount'];
	$planpercentageamount = $res56['planpercentage'];
	$billtype = $res56['billtype'];
	if($billtype == 'PAY NOW')
	{
	if($planfixedamount == '0.00')
	{
	$planfixedamount = '';
	}
	
	if($planpercentageamount == '0.00')
	{
	$planpercentageamount = '';
	}
	}
	$visitcount = $res56['visitcount'];
	$consultationdate = $res56['consultationdate'];
$consultationtime = $res56['consultationtime'];
$age = $res56['age'];
$gender = $res56['gender']; 
$referredby = $res56['referredby'];
$patientspent = $res56['patientspent'];
$paymenttype = $res56['paymenttype'];
	$query4 = "select * from master_paymenttype where auto_number = '$paymenttype'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	$res4 = mysql_fetch_array($exec4);
	$paymenttypeanum = $res4['auto_number'];
	$paymenttype = $res4['paymenttype'];
	
$subtype = $res56['subtype'];
	$query4 = "select * from master_subtype where auto_number = '$subtype'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	$res4 = mysql_fetch_array($exec4);
	$subtypeanum = $res4['auto_number'];
	$subtype = $res4['subtype'];
	$billtype = $res56['billtype'];

$accountname = $res56['accountname'];
	$query4 = "select * from master_accountname where auto_number = '$accountname'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	$res4 = mysql_fetch_array($exec4);
	$accountnameanum = $res4['auto_number'];
	$accountname = $res4['accountname'];

	$accountexpirydate = $res56['accountexpirydate'];
	
	 $planname = $res56['planname'];
	 $query4 = "select * from master_planname where auto_number = '$planname'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	$res4 = mysql_fetch_array($exec4);
	$plannameanum = $res4['auto_number'];
	$planname = $res4['planname'];
	
	$planexpirydate = $res56['planexpirydate'];
	$registrationdate = $res56['registrationdate'];
	

	$query66="select * from master_department where auto_number='$departmentanum'";
	$exec66=mysql_query($query66) or die(mysql_error());
	$res66=mysql_fetch_array($exec66);
	$department=$res66['department'];
	
	$consultingdoctoranum = $res56['consultingdoctor'];
	
	$query67="select * from master_doctor where auto_number='$consultingdoctoranum'";
	$exec67=mysql_query($query67) or die(mysql_error());
	$res67=mysql_fetch_array($exec67);
	$doctor=$res67['doctorname'];
	
	$consultingtypeanum = $res56['consultationtype'];
	
	$query68="select * from master_consultationtype where auto_number='$consultingtypeanum'";
	$exec68=mysql_query($query68) or die(mysql_error());
	$res68=mysql_fetch_array($exec68);
	$consultingtype=$res68['consultationtype'];
	$consultationfees=$res68['consultationfees'];
	
	if($visitcount == 1)
	{
	$availablelimit=$overalllimit ;
	}
	else
	{
	$availablelimit=$overalllimit-$planfixedamount;
	}
	
    $query51 = "select * from master_visitentry where patientcode = '$patientcode' and consultationdate < '$consultationdate' and recordstatus = '' order by auto_number desc limit 0,1";
	$exec51 = mysql_query($query51) or die ("Error in Query51".mysql_error());
	$res51 = mysql_fetch_array($exec51);

     $lastvisitdate = $res51['consultationdate'];
	
	if($lastvisitdate == '')
	{
	$lastvisitdate = $consultationdate;
	}
	
	$todaysdatetime = strtotime($consultationdate);
	$lastvisitdatetime = strtotime($lastvisitdate);
	$datediff = $todaysdatetime - $lastvisitdatetime;
	$visitdays = floor($datediff/(60*60*24));
	
	
	
}


$registrationdate = date('Y-m-d');

 
//$consultationfees = '500';

if (isset($_REQUEST["errorcode"])) { $errorcode = $_REQUEST["errorcode"]; } else { $errorcode = ""; }
//$patientcode = 'MSS00000009';
if ($errorcode == 'errorcode1failed')
{
	$errmsg = 'Patient Already Visited Today. Cannot Proceed With Visit Entry. Save Not Completed.';	
}


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
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
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

/*
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

function processflowitem1()
{
}

*/
</script>
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
</head>
<script language="javascript">

function process1()
{
	
	//alert ("Before Function");
	//To validate patient is not registered for the current date.
	//funcVisitEntryPatientCodeValidation1();
	//return false;


	/*if (document.form1.patientcode.value == "")
	{
		alert ("Please Search & Select Patient To Proceed.");
		document.form1.visittype.focus();
		return false;
	}
	if (document.form1.patientfirstname.value == "")
	{
		alert ("Please Enter Patient First Name.");
		document.form1.patientfirstname.focus();
		return false;
	}
	if(document.getElementById("billtype").value = "PAY LATER")
	{
	  if(document.getElementById("accountname").value == "")
	   {
	    alert("Account Name Cannot be Empty");
		document.form1.accountname.focus();
		return false;
	   }
	}
	
	if(document.getElementById("billtype").value = "PAY LATER")
	 {
	  if(document.getElementById("planname").value == "")
	   {
	    alert("Plan Name Cannot be Empty");
		document.form1.planname.focus();
		return false;
		}
	}
	
	*/
/*	if (document.form1.visittype.value == "")
	{
		alert ("Please Select Visit Type.");
		document.form1.visittype.focus();
		return false;
	}*/
	if(document.getElementById("paymenttypename").value != "CASH" && document.getElementById("subtypename").value !="CASH")
	{
		 var VarVisitLimit = document.getElementById("visitlimit").value;
		 var VarVisitCount = document.getElementById("visitcount").value;
		 
		/*<!-- if(VarVisitCount > VarVisitLimit)
		 {
			alert("Your Visit Limit Is Finished .You Cannot Proceed");
			document.getElementById("department").focus();
			return false;
		}-->
			*/
	if (document.form1.availablelimit.value == 0)
	  {
		alert ("Available Limit Cannot be Empty.");
		document.form1.availablelimit.focus();
		return false;
	  }		
  }
	
	if (document.form1.department.value == "")
	{
		alert ("Please Select Department.");
		document.form1.department.focus();
		return false;
	}
	
	if (document.form1.consultingdoctor.value == "")
	{
		alert ("Please Select Consulting Doctor.");
		document.form1.consultingdoctor.focus();
		return false;
	}	
	
	if (document.form1.consultationtype.value == "")
	{
		alert ("Please Select Consultation Type.");
		document.form1.consultationtype.focus();
		return false;
	}
	
	
	if (document.getElementById("accountexpirydate").value != "")
	{
		<?php $date = mktime(0,0,0,date("m"),date("d")-1,date("Y")); 
		$currentdate = date("Y/m/d",$date);
		?>
		var currentdate = "<?php echo $currentdate; ?>";
		var expirydate = document.getElementById("accountexpirydate").value; 
		var currentdate = Date.parse(currentdate);
		var expirydate = Date.parse(expirydate);
		
		if( expirydate < currentdate)
		{
			alert("Please Select Correct Account Expiry date");
			//document.getElementById("accountexpirydate").focus();
			return false;
		}
	}
	
    if(document.getElementById("paymenttypename").value != "CASH" && document.getElementById("subtypename").value != "CASH")
	   {
		 /*if (document.getElementById("planfixedamount").value == 0)
		  {
			alert ("For Consultation Visit Entry, Plan Fixed Amount Cannot Be Zero. Please Refer Your Plan Details.");
			return false;
		 }*/
		
		/*if (parseFloat(document.getElementById("visitlimit").value) < parseFloat(document.getElementById("consultationfees").value))
		 {
			alert ("Consultation Fees Crossed Visit Limit Amount Level. Cannot Proceed.");
			return false;
		 }*/
		//return false;
		 var VarVisitLimit = document.getElementById("visitlimit").value;
		 var VarVisitCount = document.getElementById("visitcount").value;
		 
		/* if(VarVisitCount > VarVisitLimit)
		  {
			alert("Your Visit Limit Is Finished .You Cannot Proceed");
			document.getElementById("department").focus();
			return false;
		 }

		*/
		
		var VarOverallLimit = document.getElementById("overalllimit").value;
		var Varavaliablelimit = document.getElementById("availablelimit").value;
		
		if(Varavaliablelimit == 0)
		{
			alert("You Cannot Proceed Because No Available Balance");
			document.getElementById("department").focus();
			return false;
		}	
	}
}


/*
function funcVisitLimt()
{
<?php
	$query11 = "select * from master_customer where status = 'ACTIVE'";
	$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
	while ($res11 = mysql_fetch_array($exec11))
	{
	$res11customername = $res11["customername"];
	$res11visitlimit = $res11['visitlimit'];
	$res11patientfirstname=$res11patientfirstname['patientfirstname'];
		?>
		if(document.getElementById("customername").value == "<?php echo $res11customername; ?>")
		{
			document.getElementById("visitlimit").value = <?php echo $res11visitlimit; ?>;
			document.getElementById("patientfirstname").value = <?php echo $res11patientfirstname; ?>;
			document.getElementById("customername").value = <?php echo $res11customername; ?>;
	
			return false;
		}
	<?php
	}
	?>
}
*/

function funcDepartmentChange()
{


	<?php
	$query11 = "select * from master_department where recordstatus = ''";
    $exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
	while ($res11 = mysql_fetch_array($exec11))
	{
	$res11departmentanum = $res11['auto_number'];
	$res11department = $res11["department"];
	
	$query4 = "select * from master_subtype where recordstatus = ''";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	while($res4 = mysql_fetch_array($exec4))
	{
	
	$res4subtypeanum = $res4['auto_number'];
	$res4subtype = $res4['subtype'];
	?>
		if(document.getElementById("department").value == "<?php echo $res11departmentanum; ?>")
		{
		if(document.getElementById("subtype").value == "<?php echo $res4subtypeanum; ?>")
		{
		document.getElementById("consultationtype").options.length=null; 
		var combo = document.getElementById('consultationtype'); 
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Consultation Type", ""); 
		<?php
		$query10 = "select * from master_consultationtype where department = '$res11departmentanum' and subtype = '$res4subtypeanum' order by consultationtype";
		$exec10 = mysql_query($query10) or die ("error in query10".mysql_error());
		while ($res10 = mysql_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10consultationtypeanum = $res10['auto_number'];
		$res10consultationtype = $res10["consultationtype"];
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10consultationtype;?>", "<?php echo $res10consultationtypeanum;?>"); 
		<?php 
		}
		?>
		}
		}
	<?php
	}
	}
	?>
 

}
function funcConsultationTypeChange()
{
//alert(document.getElementById("consultationtype").value);
	<?php
	$query11 = "select * from master_consultationtype where recordstatus = ''";
    $exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
	while ($res11 = mysql_fetch_array($exec11))
	{
	$res11consultationanum = $res11["auto_number"];
	$res11consultationtype = $res11["consultationtype"];
	$res11consultationfees = $res11["consultationfees"];
	?>
		if(document.getElementById("consultationtype").value == "<?php echo $res11consultationanum; ?>")
		{
			document.getElementById("consultationfees").value = <?php echo $res11consultationfees; ?>;
			document.getElementById("consultationfees").focus();
		}
	<?php
	}
	?>
}


function funcOnLoadBodyFunctionCall()
{ 
	//alert ("Inside Body On Load Fucntion.");
	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	funcCustomerDropDownSearch1(); //To handle ajax dropdown list.
}


function funcaccountexpiry()
{
    <?php $date = mktime(0,0,0,date("m"),date("d")-1,date("Y")); 
	$currentdate = date("Y/m/d",$date);
	?>
	var currentdate = "<?php echo $currentdate; ?>";
	var expirydate = document.getElementById("expirydate").value; 
	var currentdate = Date.parse(currentdate);
	var expirydate = Date.parse(expirydate);
	
	if( expirydate > currentdate)
	{
	alert("Please Select Correct Account Expiry date");
	document.getElementById("expirydate").focus();
	return false;
	}
}

</script>
<?php include ("js/dropdownlist1newscripting1.php"); ?>
<script type="text/javascript" src="js/autosuggestnew1.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_newcustomer.js"></script>
<script type="text/javascript" src="js/autocustomercodesearch2editop.js"></script>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>


<script src="js/datetimepicker_css.js"></script>

<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall()">
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
	
	//	include ("includes/menu2.php"); 
	
	?>	</td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top">&nbsp;</td>
    <td width="97%" valign="top">


      	  <form name="form1" id="form1" method="post" action="editpatientvisit.php" onKeyDown="return disableEnterKey(event)" onSubmit="return process1()">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="860"><table width="1132" height="282" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
                <td bgcolor="#CCCCCC" class="bodytext3" colspan="2"><strong>Edit Visit Entry </strong></td>
                <!--<td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                <td bgcolor="#CCCCCC" class="bodytext3" colspan="4">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="10" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo 'red'; } ?>" class="bodytext3"><?php echo $errmsg;?>&nbsp;</td>
              </tr>
              <!--<tr bordercolor="#000000" >
                  <td  align="left" valign="middle"  class="bodytext3"  colspan="4"><strong>Registration</strong></font></div></td>
                </tr>-->
              <!--<tr>
                  <tr  bordercolor="#000000" >
                  <td  align="left" valign="middle"  class="bodytext3" colspan="4"><div align="right">* Indicates Mandatory</div></td>
                </tr>-->
				<tr>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Patient Search </td>
				  <td colspan="5" align="left" valign="middle"  bgcolor="#E0E0E0">
				  <input name="customer" id="customer" size="60" autocomplete="off">
				   <input name="customerhiddentextbox" id="customerhiddentextbox" value="" type="hidden">
				  <input name="customercode" id="customercode" value="" type="hidden">
				   <input name="nationalid" id="nationalid" value = "" type = "hidden">
				  <input name="accountnames" id="accountnames" value="" type="hidden">
				  <input name = "mobilenumber111" id="mobilenumber111" value="" type="hidden">
 				<input type="hidden" name="recordstatus" id="recordstatus">
				  <input type="hidden" name="billnumbercode" id="billnumbercode" value="<?php echo $billnumbercode; ?>" readonly ></td>
				 
				  </tr>
				
				<tr>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
				  <td width="18%" align="left" valign="middle"  bgcolor="#E0E0E0">&nbsp;</td>
				  <td width="16%" align="left" valign="middle"  bgcolor="#E0E0E0">&nbsp;</td>
				  <td width="18%" align="left" valign="middle"  bgcolor="#E0E0E0">&nbsp;</td>
				  <td width="15%" align="left" valign="middle"  bgcolor="#E0E0E0">&nbsp;</td>
				  <td width="17%" align="left" valign="middle"  bgcolor="#E0E0E0">&nbsp;</td>
				  </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Patient</td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0">
				  <input name="patientfirstname" id="patientfirstname" value="<?php echo $patientfirstname; ?>" readonly size="20" /></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0">
				  <input name="patientmiddlename" id="patientmiddlename" value="<?php echo $patientmiddlename; ?>" readonly size="20" /></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><input name="patientlastname" id="patientlastname" value="<?php echo $patientlastname; ?>" readonly size="20" /></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Age</td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><input type="text" name="age" id="age" value="<?php echo $age; ?>" readonly ></td>
				 </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"> Reg No </td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0">
				  <input name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>" size="20" /></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext32">Visit  Date </span></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><input type="text" name="registrationdate" id="registrationdate" value="<?php echo $consultationdate; ?>" ></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Gender</td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><input type="text" name="gender" value="<?php echo $gender; ?>" id="gender" readonly></td>
				  </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Type</td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0">
				    <input type="text" name="paymenttypename" id="paymenttypename"  value="<?php echo $paymenttype;?>" readonly >				
				    <input type="hidden" name="paymenttype" id="paymenttype"  value="<?php echo $paymenttypeanum;?>" readonly >					</td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext32">Visit ID </span></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><input name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" readonly size="20" /></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext32">Account  </span></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><input type="text" name="accountnamename" id="accountnamename"  value="<?php echo $accountname;?>"  readonly="readonly" style="width: 250px">
				    <input type="hidden" name="accountname" id="accountname"  value="<?php echo $accountnameanum;?>"  readonly="readonly" ></td>
				</tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Sub Type </td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><label>
                    <input type="text" name="subtypename" id="subtypename"  value="<?php echo $subtype;?>"  readonly="readonly" >
				    <input type="hidden" name="subtype" id="subtype"  value="<?php echo $subtypeanum;?>"  readonly="readonly"  style="border: 1px solid #001E6A;">
				  </label></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext32">Bill Type </span></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><input type="text" name="billtype" id="billtype"  value="<?php echo $billtype;?>"  readonly="readonly"></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext32">Account Expiry </span></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><input type="text" name="accountexpirydate" id="accountexpirydate"  value="<?php echo $accountexpirydate;?>"  readonly="readonly"  style="border: 1px solid #001E6A;"></td>
				  </tr>
				
				<tr>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Plan Name </td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><label>
                    <input type="text" name="plannamename" id="plannamename"  value="<?php echo $planname;?>"   readonly="readonly">
                    <input type="hidden" name="planname" id="planname"  value="<?php echo $plannameanum;?>"   readonly="readonly" >
                  </label></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Plan Expiry </td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><input type="text" name="planexpirydate" id="planexpirydate"  value="<?php echo $planexpirydate;?>"   readonly="readonly"></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext32">Last Visit</span></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><label>
				  <input type="text" name="lastvisitdate" id="lastvisitdate" value="<?php echo $lastvisitdate; ?>">
 				    <input type="hidden" name="visitlimit" id="visitlimit"  value="<?php echo $visitlimit;?>"   readonly="readonly">
				  </label></td>
				  </tr>
				<tr>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext32">Fixed Amount </span></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><label>
				  <input type="text" name="planfixedamount" id="planfixedamount"  value="<?php echo $planfixedamount;?>"   readonly="readonly">
				  </label></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Overall Limit </td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><input type="text" name="overalllimit" id="overalllimit"  value="<?php echo $overalllimit;?>"   readonly="readonly" ></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext32">Patient Due</span></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><label>
				    <input type="text" name="patientspent" id="patientspent"  value="<?php echo $patientspent;?>"   readonly="readonly">
				  </label></td>
				  </tr>
				
				<tr>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Percentage</td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><label>
				 <input type="text" name="planpercentageamount" id="planpercentageamount"  value="<?php echo $planpercentageamount;?>"   readonly="readonly" ></label> </td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Available Limit (Amount) </td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><input type="text" name="availablelimit" id="availablelimit"  value="<?php echo $availablelimit;?>"   readonly="readonly"></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext32">Visit Days </span></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><label><strong>
				   <input type="text" name="visitdays" id="visitdays" value="<?php echo $visitdays; ?>" readonly>
				  <input name="visittype" id="visittype" value="" type="hidden">
				  <input type="hidden" name="visitcount" id="visitcount"  value="<?php echo $visitcount;?>"   readonly="readonly">
				  </strong></label></td>
				</tr>
				
				<tr>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext32">Department</span></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><strong><!--				   
				    <select name="hidden" id="visittype" >
                      <?php
				if ($visittype == '')
				{
					echo '<option value="" selected="selected">Select Visit Type</option>';
				}
				else
				{
					$query51 = "select * from master_visittype where recordstatus = ''";
					$exec51 = mysql_query($query51) or die ("Error in Query51".mysql_error());
					$res51 = mysql_fetch_array($exec51);
					$res51visittype = $res51["visittype"];
					//echo '<option value="">Select Normal Tax</option>';
					echo '<option value="'.$res51visittype.'" selected="selected">'.$res51visittype.'</option>';
				}
				
				$query5 = "select * from master_visittype where recordstatus = '' order by visittype";
				$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
				while ($res5 = mysql_fetch_array($exec5))
				{
				$res5anum = $res5["auto_number"];
				$res5visittype = $res5["visittype"];
				?>
                      <option value="<?php echo $res5visittype; ?>"><?php echo $res5visittype; ?></option>
                      <?php
				}
				?>
                    </select>
-->					
				      <select name="department" id="department" onChange="return funcDepartmentChange()">
                        <?php
						if ($department != '')
						{
						?>
                        <option value="<?php echo $departmentanum; ?>" selected="selected"><?php echo $department; ?></option>
                        <?php
						}
						else
						{
						?>
                        <option value="" selected="selected">Department</option>
                        <?php
						}
						$query1 = "select * from master_department where recordstatus <> 'deleted' order by department";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						while ($res1 = mysql_fetch_array($exec1))
						{
						$res1department = $res1["department"];
						$res1departmentanum = $res1["auto_number"];
						?>
                        <option value="<?php echo $res1departmentanum; ?>"><?php echo $res1department; ?></option>
                        <?php
						}
						?>
                      </select>
				  </strong></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext32">Consulting Doctor</span></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><strong>
				    <select name="consultingdoctor" id="consultingdoctor">
                     
						
                      <option value="OP DOCTOR" selected="selected">OP DOCTOR</option>
                     
                    </select>
				  </strong></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext32"> Fee Type</span></td>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0">
				  <!--<input type="hidden" name="department" id="department" value="<?php echo $department; ?>" style="border: 1px solid #001E6A;"  size="20" />-->
				  <strong>
				  <select name="consultationtype" id="consultationtype" onChange="return funcConsultationTypeChange()">
                    <option value="" selected="selected">Select Consultation Type</option>
                    <?php
						if ($consultingtype != '')
						{
						?>
                    <option value="<?php echo $consultingtypeanum; ?>" selected="selected"><?php echo $consultingtype; ?></option>
                    <?php
						}
			?>
                  </select>
				  </strong></td>
				</tr>
				<tr>
                <td width="16%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="bodytext32"> Visit Date</span></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0"><input type="text" name="consultationdate" id="consultationdate" value="<?php echo $consultationdate; ?>" readonly></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext32">Time </span></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0"><input name="consultationtime" id="consultationtime" value="<?php echo $consultationtime; ?>" readonly size="10" />
                  <span class="bodytext32">(Ex: HH:MM)</span></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0"><span class="bodytext32">Consultation  Fees </span></td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0"><input name="consultationfees" id="consultationfees" value="<?php echo $consultationfees; ?>" onFocus="return funcVisitEntryPatientCodeValidation1()"size="20" readonly/></td>
				</tr>
				 
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0"><input name="referredby"  type="hidden" id="referredby" value="<?php echo $referredby; ?>" size="20" /></td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0">&nbsp;</td>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0">&nbsp;</td>
				 </tr>
				 
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
				   <td colspan="5" align="left" valign="middle"  bgcolor="#E0E0E0"><input name="complaint"  type="hidden" id="complaint" value="<?php echo $complaint; ?>" style="border: 1px solid #001E6A;"  size="75" /></td>
			      </tr>
				 <tr>
				   <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
				   <td colspan="5" align="left" valign="middle"  bgcolor="#E0E0E0">
				   <input type="hidden" name="consultationremarks" id="consultationremarks" value="<?php echo $consultationremarks; ?>" style="border: 1px solid #001E6A;"  size="75" /></td>
			      </tr>
				 <tr>
				   <td colspan="6" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
			      </tr>
                 <tr>
                <td colspan="6" align="middle"  bgcolor="#E0E0E0"><div align="right"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> <font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <input type="hidden" name="frmflag1" value="frmflag1" />
                  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
                  <input name="Submit222" type="submit"  value="Save Visit Entry (Alt+S)" accesskey="s" class="button"/>
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
<script language="javascript">
</script>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>