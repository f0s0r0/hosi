<?php
$lastupdate = date('Y-m-d H:i:s');
$billtime = date("H:i:s");

//$financialyear = $_SESSION["financialyear"];

	$query6 = "select * from master_company where auto_number = '$companyanum'";
	$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
	$res6 = mysql_fetch_array($exec6);
	$res6companycode = $res6["companycode"];
	
	$query7 = "select * from master_settings where companycode = '$res6companycode' and modulename = 'SETTINGS' and 
	settingsname = 'CURRENT_FINANCIAL_YEAR'";
	$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
	$res7 = mysql_fetch_array($exec7);
	$financialyear = $res7["settingsvalue"];
	$_SESSION["financialyear"] = $financialyear;
	//echo $_SESSION['financialyear'];



$balanceamount = '';


if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
//$frm1submit1 = $_REQUEST["frm1submit1"];
if (isset($_REQUEST["delbillst"])) { $delbillst = $_REQUEST["delbillst"]; } else { $delbillst = ""; }
if (isset($_REQUEST["delbillsummarynumber"])) { $delbillsummarynumber = $_REQUEST["delbillsummarynumber"]; } else { $delbillsummarynumber = ""; }
//$frm1submit1 = $_REQUEST["frm1submit1"];
if ($frm1submit1 == 'frm1submit1')
{
	if ($delbillst == 'billedit' && $delbillsummarynumber != '')
	{
		$query201 = "select * from master_dischargesummary where summarynumber = '$delbillsummarynumber' and status <> 'DELETED'";
		$exec201 = mysql_query($query201) or die ("Error in Query201".mysql_error());
		$rowcount201 = mysql_num_rows($exec201);
		if ($rowcount201 != 0) 
		{
			$summaryanum = $_REQUEST["auto_number"];
			$summarynumber = $_REQUEST["summarynumber"];
			$summarydate = $_REQUEST["ADate"];
			$patientname = $_REQUEST["patientname"];
		    $visitcode = $_REQUEST['visitcode'];
			$patientcode = $_REQUEST["patientcode"];
			$patientage = $_REQUEST["patientage"];
			$patientgender = $_REQUEST["patientgender"];
			$address1 = $_REQUEST["address1"];
			$address2 = $_REQUEST["address2"];
			$area = $_REQUEST["area"];
			$city = $_REQUEST["city"];
			$pincode = $_REQUEST["pincode"];
			$admissiondate = $_REQUEST["dateofadmission"];
			$dischargedate = $_REQUEST["dateofdischarge"];
			$admissiontime = $_REQUEST["admissiontime"];
			$dischargetime = $_REQUEST["dischargetime"];
			$ipnumber = $_REQUEST['ipnumber'];
			
			$doctorcode = $_REQUEST["doctorcode"];
			$query4 = "select * from master_doctor where doctorcode = '$doctorcode'";
			$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
			$res4 = mysql_fetch_array($exec4);
			$doctorname = $res4["doctorname"];
			
			$drugallergies = $_REQUEST["drugallergies"];
			$finaldiagnosis = $_REQUEST["finaldiagnosis"];
			$chiefcomplaints = $_REQUEST["chiefcomplaints"];
			$temperature = $_REQUEST["temperature"];
			$pulse = $_REQUEST["pulse"];
			$bloodpressure = $_REQUEST["bloodpressure"];
			$investigationdetails = $_REQUEST["investigationdetails"];
			$treatmentgiven = $_REQUEST["treatmentgiven"];
			$diet = $_REQUEST["diet"];
			$physicalactivity = $_REQUEST["physicalactivity"];
			$status = '';
			$username = $username;
			$updatetime = $updatedatetime;
			$ipaddress = $ipaddress;
			$wardname = $_REQUEST["wardname"];
			$bednumber = $_REQUEST["bednumber"];
			$surgerydate = $_REQUEST["surgerydate"];
			$patienthistory =$_REQUEST["patienthistory"];
			$consultationreferral = $_REQUEST["consultationreferral"];
			$conditionatdischarge = $_REQUEST["conditionatdischarge"];
			$medication = $_REQUEST["medication"];
			$followup = $_REQUEST["followup"];
			$clinicalexamination = $_REQUEST["clinicalexamination"];
	
			$medicalofficer = $_REQUEST['medicalofficer'];
			$consultantofficer = $_REQUEST['consultantofficer'];
			
			$drugallergies = addslashes($drugallergies);
			$finaldiagnosis = addslashes($finaldiagnosis);
			$chiefcomplaints = addslashes($chiefcomplaints);
			$temperature = addslashes($temperature);
			$pulse = addslashes($pulse);
			$bloodpressure = addslashes($bloodpressure);
			$investigationdetails = addslashes($investigationdetails);
			$treatmentgiven = addslashes($treatmentgiven);
			$diet = addslashes($diet);
			$physicalactivity = addslashes($physicalactivity);
			$patienthistory = addslashes($patienthistory);
			$consultationreferral = addslashes($consultationreferral);
			$conditionatdischarge = addslashes($conditionatdischarge);
			$medication = addslashes($medication);
			$followup = addslashes($followup);
			$clinicalexamination = addslashes($clinicalexamination);
			
			$query201 = "select * from master_dischargesummary where summarynumber = '$delbillsummarynumber' and status <> 'DELETED'";
			$exec201 = mysql_query($query201) or die ("Error in Query201".mysql_error());
			$res201 = mysql_fetch_array($exec201);
			$summarynumber = $res201['summarynumber'];
			
			$query201 = "update master_dischargesummary set status = 'deleted' where summarynumber = '$summarynumber' and status <> 'DELETED'";
			$exec201 = mysql_query($query201) or die ("Error in Query201".mysql_error());
			
			$query3 = "INSERT INTO master_dischargesummary (summarynumber,	summarydate, patientname, patientcode, patientage,
			patientgender, address1, address2, area, city, pincode, admissiondate, dischargedate, admissiontime, dischargetime,
			doctorname, doctorcode, drugallergies, finaldiagnosis, chiefcomplaints, temperature, pulse,	bloodpressure,
			investigationdetails, treatmentgiven, diet, physicalactivity, status, username, updatetime,	ipaddress, wardname, bednumber,
			surgerydate, patienthistory, consultationreferral, conditionatdischarge, medication, followup, clinicalexamination, ipnumber, 
			medicalofficer, consultantofficer,visitcode) 
			values ('$summarynumber', '$summarydate', '$patientname', '$patientcode', '$patientage',
			'$patientgender', '$address1', '$address2',	'$area', '$city', '$pincode', '$admissiondate',	'$dischargedate', '$admissiontime', '$dischargetime',
			'$doctorname', '$doctorcode', '$drugallergies', '$finaldiagnosis', '$chiefcomplaints', '$temperature', '$pulse', '$bloodpressure',
			'$investigationdetails', '$treatmentgiven', '$diet', '$physicalactivity', '$status', '$username', '$updatetime', '$ipaddress', '$wardname', '$bednumber', 
			'$surgerydate', '$patienthistory', '$consultationreferral', '$conditionatdischarge', '$medication', '$followup', '$clinicalexamination', '$ipnumber', 
			'$medicalofficer', '$consultantofficer', '$visitcode')";
			$exec3 = mysql_query($query3) or die ("Error in Query4".mysql_error());
			
			header ("location:summary.php?delbillst=billedit&&st=1&&delbillsummarynumber=$summarynumber&&summarynumber=$summarynumber");
			exit;
		}
		else
		{
			header ("location:summary.php?delbillst=billedit&&delbillsummarynumber=$summarynumber&&st=2&&summarynumber=$summarynumber");
			exit;
		}
	}
}


//echo $companyanum;
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
//$frm1submit1 = $_REQUEST["frm1submit1"];
if ($frm1submit1 == 'frm1submit1' && $delbillst == '' && $delbillsummarynumber == '')
{
	$summarynumber = $_REQUEST["summarynumber"];

	//bill number for bill save.
	$query201 = "select * from master_dischargesummary where summarynumber = '$summarynumber' and status <> 'DELETED'";// and companyanum = '$companyanum' and financialyear = '$financialyear'";
	$exec201 = mysql_query($query201) or die ("Error in Query201".mysql_error());
	$rowcount201 = mysql_fetch_array($exec201);
	if ($rowcount201 != 0) //If bill number already present, go for the latest bill number.
	{
		$query2 = "select max(summarynumber) as maxsummarynumber from master_dischargesummary";// where companyanum = '$companyanum' and financialyear = '$financialyear'";// order by auto_number desc limit 0, 1";
		$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		$res2 = mysql_fetch_array($exec2);
		$res2summarynumber = $res2["maxsummarynumber"];
		if ($res2summarynumber == '')
		{
			$summarynumber = '1';
		}
		else
		{
			$summarynumber = $res2["maxsummarynumber"];
			$summarynumber = $summarynumber + 1;
		}
	}

	$billdate = $_REQUEST["ADate"];
	/*
	$dotarray = explode("-", $billdate);
	//print_r($dotarray);
	$billyear = $dotarray[2];
	$billyear = substr($billyear, 0, 4);
	$billmonth = $dotarray[1];
	$billday = $dotarray[0];
	$billtime = date("H:i:s");
	$billdate = $billyear.'-'.$billmonth.'-'.$billday.' '.$billtime;
	$billdate = $billdate.' '.$billtime;
	*/
	
	
	if (isset($_REQUEST["customertype"])) { $customertype = $_REQUEST["customertype"]; } else { $customertype = ""; }
	//$customertype = $_REQUEST["customertype"];
	if (isset($_REQUEST["customercode"])) { $customercode = $_REQUEST["customercode"]; } else { $customercode = ""; }
	//$customercode = $_REQUEST["customercode"];
	
	$summarynumber = $_REQUEST["summarynumber"];
	$summarydate = $_REQUEST["ADate"];
	$patientname = $_REQUEST["patientname"];
	$patientcode = $_REQUEST["patientcode"];
	$patientage = $_REQUEST["patientage"];
	$patientgender = $_REQUEST["patientgender"];
	$address1 = $_REQUEST["address1"];
	$address2 = $_REQUEST["address2"];
	$area = $_REQUEST["area"];
	$city = $_REQUEST["city"];
	$pincode = $_REQUEST["pincode"];
	$admissiondate = $_REQUEST["dateofadmission"];
	$dischargedate = $_REQUEST["dateofdischarge"];
	$admissiontime = $_REQUEST["admissiontime"];
	$dischargetime = $_REQUEST["dischargetime"];
	$ipnumber = $_REQUEST["ipnumber"];
	
	$doctorcode = $_REQUEST["doctorcode"];
	$query4 = "select * from master_doctor where doctorcode = '$doctorcode'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	$res4 = mysql_fetch_array($exec4);
	$doctorname = $res4["doctorname"];
	
	$drugallergies = $_REQUEST["drugallergies"];
	$finaldiagnosis = $_REQUEST["finaldiagnosis"];
	$chiefcomplaints = $_REQUEST["chiefcomplaints"];
	$temperature = $_REQUEST["temperature"];
	$pulse = $_REQUEST["pulse"];
	$bloodpressure = $_REQUEST["bloodpressure"];
	$investigationdetails = $_REQUEST["investigationdetails"];
	$treatmentgiven = $_REQUEST["treatmentgiven"];
	$diet = $_REQUEST["diet"];
	$physicalactivity = $_REQUEST["physicalactivity"];
	$status = '';
	$username = $username;
	$updatetime = $updatedatetime;
	$ipaddress = $ipaddress;
	$wardname = $_REQUEST["wardname"];
	$bednumber = $_REQUEST["bednumber"];
	$surgerydate = $_REQUEST["surgerydate"];
	$patienthistory =$_REQUEST["patienthistory"];
	$consultationreferral = $_REQUEST["consultationreferral"];
	$conditionatdischarge = $_REQUEST["conditionatdischarge"];
	$medication = $_REQUEST["medication"];
	$followup = $_REQUEST["followup"];
	$clinicalexamination = $_REQUEST["clinicalexamination"];
	
	$medicalofficer = $_REQUEST['medicalofficer'];
	$consultantofficer = $_REQUEST['consultantofficer'];
			
	$drugallergies = addslashes($drugallergies);
	$finaldiagnosis = addslashes($finaldiagnosis);
	$chiefcomplaints = addslashes($chiefcomplaints);
	$temperature = addslashes($temperature);
	$pulse = addslashes($pulse);
	$bloodpressure = addslashes($bloodpressure);
	$investigationdetails = addslashes($investigationdetails);
	$treatmentgiven = addslashes($treatmentgiven);
	$diet = addslashes($diet);
	$physicalactivity = addslashes($physicalactivity);
	$patienthistory = addslashes($patienthistory);
	$consultationreferral = addslashes($consultationreferral);
	$conditionatdischarge = addslashes($conditionatdischarge);
	$medication = addslashes($medication);
	$followup = addslashes($followup);
	$clinicalexamination = addslashes($clinicalexamination);
			
	$query3 = "INSERT INTO master_dischargesummary (summarynumber, summarydate, patientname, patientcode, patientage, patientgender,
	address1, address2, area, city, pincode, admissiondate, dischargedate, admissiontime, dischargetime, doctorname, doctorcode, drugallergies,
	finaldiagnosis,	chiefcomplaints, temperature, pulse, bloodpressure, investigationdetails, treatmentgiven, diet, physicalactivity,
	status,	username, updatetime, ipaddress, wardname, bednumber, surgerydate, patienthistory, consultationreferral, conditionatdischarge, 
	medication, followup, clinicalexamination, ipnumber, medicalofficer, consultantofficer)
	values ('$summarynumber', '$summarydate', '$patientname', '$patientcode', '$patientage', '$patientgender', 
	'$address1', '$address2', '$area', '$city', '$pincode', '$admissiondate', '$dischargedate', '$admissiontime', '$dischargetime', '$doctorname', '$doctorcode', '$drugallergies', 
	'$finaldiagnosis', '$chiefcomplaints', '$temperature', '$pulse', '$bloodpressure', '$investigationdetails', '$treatmentgiven', '$diet', '$physicalactivity',
	'$status', '$username', '$updatetime', '$ipaddress', '$wardname', '$bednumber', '$surgerydate', '$patienthistory', '$consultationreferral', '$conditionatdischarge', 
	'$medication', '$followup', '$clinicalexamination', '$ipnumber', '$medicalofficer', '$consultantofficer')";
	$exec3 = mysql_query($query3) or die ("Error in Query4".mysql_error());
	


	header ("location:summary.php?src=frm1submit1&&st=1&&summarynumber=$summarynumber&&billautonumber=$billautonumber&&companyanum=$companyanum&&titlestr=SALES BILL");
	exit;


}

//bill number for bill save.
$paynowbillprefix = 'SUM-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from master_dischargesummary order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["summarynumber"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$summarynumber ='SUM-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["summarynumber"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$summarynumber = 'SUM-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}


?>