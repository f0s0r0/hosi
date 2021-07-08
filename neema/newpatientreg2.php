<?php
session_start();
error_reporting(0);
//include ("includes/loginverify.php"); //to prevent indefinite loop, loginverify is disabled.
if (!isset($_SESSION["username"])) header ("location:index.php");
include ("includes/loginverify.php");
include ("db/db_connect.php");

$query55 = "select tillnumber from master_company where auto_number='1'";
$exec55 = mysql_query($query55) or die(mysql_error());
$res55 = mysql_fetch_array($exec55);

$url = 'https://med360-mtiba.tislive.com/queue_search.php';
$till_number = $res55['tillnumber'];
$mtiba_anum=3638;

$customercode="";
$m_registrationtype="";
$location ="";
$faxnumber2 ="";
$mrd_autono ="";
$mrd ="";
$insuranceid = "";
$salutation = "";
$subtype = "";
$mgender = "";
$mpatientname = "";
$res2age[0] = "";
$res2age[1] = "";
$midNumber = "";
$mdob = "";
$mmobileNumber = "";
$nationalidnumber = '';
$visitcode = '';
$transactionId = '';
$mtransactionId = '';
$mbalance = '';
$info = '';
$this_visit=0; 
//$json = '';
 
$ipaddress = $_SERVER["REMOTE_ADDR"];
$updatedatetime = date('Y-m-d H:i:s');
$errmsg = "";
$bgcolorcode = "";
$registrationdate = date('Y-m-d');
$registrationtime = date('H:i:s');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$companycode = $_SESSION['companycode'];
$searchpaymenttype= '';

	$query1111 = "select * from master_employee where username = '$username'";
    $exec1111 = mysql_query($query1111) or die ("Error in Query1111".mysql_error());
	while ($res1111 = mysql_fetch_array($exec1111))
	{
	$locationnumber = $res1111["location"];
	$query1112 = "select * from master_location where auto_number = '$locationnumber' and status <> 'deleted'";
    $exec1112 = mysql_query($query1112) or die ("Error in Query1112".mysql_error());
	while ($res1112 = mysql_fetch_array($exec1112))
	{
		 $locationname = $res1112["locationname"];		  
		 $locationcode = $res1112["locationcode"];
		$_SESSION['locationname'] = $locationname;
		$_SESSION['locationcode'] = $locationcode;
	}
	}



if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
if ($frmflag1 == 'frmflag1')
{
	
 	$query3 = "select * from master_location as ml LEFT JOIN login_locationdetails as ll ON ml.locationcode=ll.locationcode where ll.docno = '".$docno."' order by ml.locationname";
  	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	$res3 = mysql_fetch_array($exec3);
	$patientcodeprefix = $res3['prefix'];
	$patientcodeprefix ="RUNH";
	$suffix =  date('y');
 	$patientcodeprefix1=strlen($patientcodeprefix);


 	$query2 = "select * from master_customer order by auto_number desc limit 0, 1"; 
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	$res2 = mysql_fetch_array($exec2);
 	$res2customercode = $res2["customercode"];
	
	if ($res2customercode == ''){
		//$customercode = 'AMF00000001';
		$customercode = $patientcodeprefix.'-'.'1'.'-'.$suffix;  
		$openingbalance = '0.00';
	}else {
		$res2customercode = $res2["customercode"];
		$customercode11 = explode("-",$res2customercode);
		$customercode=$customercode11[1];
		$customercode = intval($customercode);
		$customercode = $customercode + 1;
		$maxanum = $customercode;
		//$customercode = 'AMF'.$maxanum1;
		$customercode = $patientcodeprefix.'-'.$maxanum.'-'.$suffix;
		$openingbalance = '0.00';
		//echo $companycode;
	}
	
	$customername = $_REQUEST["customername"];
	$customername = strtoupper($customername);
	$customername = trim($customername);
	$customername = addslashes($customername);
	
	$mothername=$_REQUEST['mothername'];
	$mothername = strtoupper($mothername);
	$mothername = trim($mothername);
	$mothername = addslashes($mothername);

	$customermiddlename = $_REQUEST['customermiddlename'];
	$customermiddlename = strtoupper($customermiddlename);
	$customermiddlename = trim($customermiddlename);
	$customermiddlename = addslashes($customermiddlename);
	
	$customerlastname = $_REQUEST['customerlastname'];
	$customerlastname = strtoupper($customerlastname);
	$customerlastname = trim($customerlastname);
	$customerlastname = addslashes($customerlastname);
	$customerfullname=$customername.' '.$customermiddlename.' '.$customerlastname;	

	$customercode=$_REQUEST['customercode'];
	$visitcode = $_REQUEST['visitcode'];		
	$gender = $_REQUEST["gender"];	
	$age = $_REQUEST["age"];
	$address1 = $_REQUEST["address1"];
	$address2 = $_REQUEST["address2"];
	$area = $_REQUEST["area"];
	$city = $_REQUEST["city"];
	$state = $_REQUEST["state"];
	$pincode = $_REQUEST["pincode"];
	$country = $_REQUEST["country"];
	$phonenumber1 = $_REQUEST["phonenumber1"];
	$phonenumber2 = $_REQUEST["phonenumber2"];
	$emailid1  = $_REQUEST["emailid1"];
	$emailid2 = $_REQUEST["emailid2"];
	$mrdno = $_REQUEST["mrdno"];
	$promotion = $_REQUEST["promotion"];
	$mobilenumber  = $_REQUEST["mobilenumber"];		
	$tinnumber = $_REQUEST["tinnumber"];
	$cstnumber = $_REQUEST["cstnumber"];
	$openingbalance = $_REQUEST["openingbalance"];
	$nameofrelative = $_REQUEST['nameofrelative'];
	$dateofbirth = $_REQUEST['dateofbirth'];
	$maritalstatus = $_REQUEST['maritalstatus'];
	$occupation = $_REQUEST['occupation'];
	$nationalidnumber = $_REQUEST['nationalidnumber']; 
	$ageduration = $_REQUEST['ageduration'];
	$bloodgroup = $_REQUEST['bloodgroup'];
	$registrationdate = $_REQUEST['registrationdate'];
	$registrationtime = $_REQUEST['registrationtime'];
	$kinname = $_REQUEST['kinname'];
	$kincontactnumber = $_REQUEST['kincontactnumber'];
	$availablelimit =$_REQUEST['availablelimit'];
	$consultingdoctor = $_REQUEST["consultingdoctor"];
	$consultingdoctorcode = $_REQUEST["consultingdoctorcode"];
	$consultationdate = date('Y-m-d');
	$consultationtime = $_REQUEST["consultationtime"];
	$consultationfees = $_REQUEST["consultationfees"];
	$consultationtype = $_REQUEST["consultationtype"]; 
	$transactionId = $_REQUEST['transactionId'];
	$visitcount = $_REQUEST["visitcount"];
	$locationcode=$_REQUEST['location'];
	$billtype = "PAY LATER";
	$paymentstatus = "completed";

	$accountname = $_REQUEST['searchaccountcode'];
	$accname = $_REQUEST['searchaccountname'];
	$accountexpirydate = $_REQUEST["accountexpirydate"];
	$subtype = $_REQUEST['subtype'];
	$paymenttype = $_REQUEST["paymenttype"];

	$planname = $_REQUEST["plannameautono"];
    $planvaliditystart = $_REQUEST['planvaliditystart'];
	$planexpirydate = $_REQUEST['planexpirydate'];
	$planfixedamount = $_REQUEST['planfixedamount'];
	$planpercentage = $_REQUEST['planpercentage'];
	$maintype =  $_REQUEST['maintype'];
	$visitlimit = $_REQUEST['visitlimit'];
	$overalllimit = $_REQUEST['overalllimit'];	

	$overalllimit = $availablelimit;
	$buttonname = $_REQUEST['Submit222'];
	
	$department = $_REQUEST["department"];
	
	$query43 = "select department from master_department where auto_number='$department'";
	$exec43 = mysql_query($query43) or die(mysql_error());
	$res43 = mysql_fetch_array($exec43);
	$departmentname = $res43['department'];

/*	$skiptriage = $res43['skiptriage'];
	$triagestatus= ($skiptriage=='1')?'completed':'pending'; 
*/	 
	$triagestatus= 'pending'; 

	$birthday = $_REQUEST["dateofbirth"]; 
	
	$age1 = calculate_age($_REQUEST['dateofbirth']);

	$ageexplode=explode(' ',$age1);
	$ageno=isset($ageexplode[0])?$ageexplode[0]:'';
	$ageduration=isset($ageexplode[1])?$ageexplode[1]:'';

	
	$remarks = '';
	$status = '';
	$insuranceid ='';
	$faxnumber = '';
	$typeofcustomer = '';
	$admitid ="";
	$smartbenefitno ="";
	$locationname ="";
	$hospitalfees =""; 
	$doctorfees ="";
	$triag =1;
	$patientspent ="";	
	$salutation = "";	

	if($billtype == 'PAY NOW')
	{
		$query3 = "select * from master_visitentry where patientcode = '$customercode' and  consultationdate = '$consultationdate'";
		$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
		$rowcount3 = mysql_num_rows($exec3);
		if ($rowcount3 != 0)
		{
			header ("location:newpatientreg2.php?errorcode=errorcode1failed");
			exit();
		}	
	}
	else
	{

	$query211 = "select * from master_visitentry where patientcode = '$customercode' and billtype = 'PAY LATER' order by auto_number desc limit 0,1";
	$exec211 = mysql_query($query211) or die ("Error in Query211".mysql_error());
	
		$rowcount33 = mysql_num_rows($exec211);
		if ($rowcount33 != 0)
		{
			$res211 = mysql_fetch_array($exec211);
			$oldvisitcode1 = $res211['visitcode'];

			if($oldvisitcode1 != '')
			{
				$query221 = "select * from billing_paylater where visitcode='$oldvisitcode1'";
				$exec221 = mysql_query($query221) or die(mysql_error());
				$res221 = mysql_num_rows($exec221);
				if ($res221 == 0)
				{

					header ("location:newpatientreg2.php?errorcode=errorcode2failed");
					exit();
					
				}
			}
		}

	}

  	$customercode_req=$_REQUEST['customercode'];

	$query21 = "select * from master_customer where customercode='$customercode_req'";
	$exec21 = mysql_query($query21) or die ("Error in Query2".mysql_error());
	$res2 = mysql_num_rows($exec21);
	
	if ($res2 == 0)
	{
		
		$date = date('Y-m-d-H-i-s');
		$uploaddir = "patientphoto";
		//$final_filename="$companyname.jpg";
		$final_filename = "$customercode.jpg";
		$uploadfile123 = $uploaddir . "/" . $final_filename;
		$target_path = $uploadfile123;
		$imagepath = $target_path;
			
		//$customercode=$_REQUEST['customercode'];
		//echo $_FILES['uploadedfile']['name'];
		 if ($_FILES['uploadedfile']['name'] != '')
		{	
			//echo 'success';
			if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) 
			{
			
				$query1 = "INSERT INTO master_customer (customercode,customername,customermiddlename, customerlastname,customerfullname,gender,mothername,age,typeofcustomer,address1,address2,
				area,city,state,country,pincode,phonenumber1,phonenumber2,mobilenumber,emailid1, emailid2,tinnumber, cstnumber, openingbalance,remarks, status, insuranceid,nameofrelative, dateofbirth, maritalstatus, bloodgroup, registrationdate, registrationtime, occupation, nationalidnumber, 
				ageduration,salutation,kinname, kincontactnumber, paymenttype,billtype,accountname,planname, 
				planvaliditystart,  visitlimit, maintype,subtype,accountexpirydate, planexpirydate, overalllimit, planfixedamount, planpercentage, mrdno, promotion,locationcode,username) 
				values('$customercode','$customername', '$customermiddlename','$customerlastname','$customerfullname','$gender','$mothername','$age','$typeofcustomer','$address1','$address2','$area','$city',
				'$state','$country','$pincode','$phonenumber1','$phonenumber2','$mobilenumber','$emailid1',
				'$emailid2','$tinnumber', '$cstnumber', '$openingbalance','$remarks','$status','$insuranceid', 
				  '$nameofrelative', '$dateofbirth', '$maritalstatus','$bloodgroup', '$registrationdate', '$registrationtime','$occupation', '$nationalidnumber','$ageduration','$salutation','$kinname', '$kincontactnumber', '$paymenttype','PAY LATER','$accountname','$planname','$planvaliditystart','$visitlimit','$maintype','$subtype','$accountexpirydate', '$planexpirydate', '$overalllimit', '$planfixedamount', '$planpercentage', '$mrdno', '$promotion','".$locationcode."','$username')";
				$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
				
				$query1 = "update master_customer set photoavailable = 'YES' where customercode = '$customercode'";
				$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
				
				 $query56="INSERT INTO master_visitentry(patientcode,visitcode,registrationdate, patientfirstname,patientmiddlename, patientlastname,patientfullname,paymenttype,subtype,billtype,accountname,accountexpirydate,planname,planexpirydate,overalllimit,availablelimit,consultingdoctor,consultingdoctorcode,department,departmentname,consultationdate,consultationtime,consultationfees,visitlimit,consultationtype,username,visitcount,planfixedamount,planpercentage,patientspent,triagestatus,age,gender,consultationrefund,accountfullname,locationcode,admitid,smartbenefitno,locationname1,paymentstatus,complaint,transactionId)values('$customercode','$visitcode','$registrationdate','$customername','$customermiddlename','$customerlastname','$customerfullname','$paymenttype','$subtype','PAY LATER','$accountname','$accountexpirydate','$planname','$planexpirydate','$overalllimit','$availablelimit','$consultingdoctor','$consultingdoctorcode','$department','$departmentname','$consultationdate','$consultationtime','$consultationfees','$visitlimit','$consultationtype','$username','$visitcount','$planfixedamount','$planpercentage','$patientspent','$triagestatus','$ageno','$gender','torefund','$accname','".$locationcode."','$admitid','$smartbenefitno','$locationname','$paymentstatus','$triag','$transactionId')";  
				//exit; 
				$exec56=mysql_query($query56) or die(mysql_error());
				
					if($paymenttype==1 && $consultationfees > 0){
						include "patient_billing.php";
					}
				
				$status = 'success';
			}
			else
			{
				$status = 'failed';
			}
		}else {
			
				$query1 = "INSERT INTO master_customer (customercode,customername,customermiddlename, customerlastname,customerfullname,gender,mothername,age,typeofcustomer,address1,address2,
				area,city,state,country,pincode,phonenumber1,phonenumber2,mobilenumber,emailid1, emailid2,tinnumber, cstnumber, openingbalance,remarks, status, insuranceid,nameofrelative, dateofbirth, maritalstatus, bloodgroup, registrationdate, registrationtime, occupation, nationalidnumber, 
				ageduration,salutation,kinname, kincontactnumber, paymenttype,billtype,accountname,planname, 
				planvaliditystart,  visitlimit, maintype,subtype,accountexpirydate, planexpirydate, overalllimit, planfixedamount, planpercentage, mrdno, promotion,locationcode,username) 
				values('$customercode','$customername', '$customermiddlename','$customerlastname','$customerfullname','$gender','$mothername','$age','$typeofcustomer','$address1','$address2','$area','$city',
				'$state','$country','$pincode','$phonenumber1','$phonenumber2','$mobilenumber','$emailid1',
				'$emailid2','$tinnumber', '$cstnumber', '$openingbalance','$remarks','$status','$insuranceid', 
				  '$nameofrelative', '$dateofbirth', '$maritalstatus','$bloodgroup', '$registrationdate', '$registrationtime','$occupation', '$nationalidnumber','$ageduration','$salutation','$kinname', '$kincontactnumber', '$paymenttype','PAY LATER','$accountname','$planname','$planvaliditystart','$visitlimit','$maintype','$subtype','$accountexpirydate', '$planexpirydate', '$overalllimit', '$planfixedamount', '$planpercentage', '$mrdno', '$promotion','".$locationcode."','$username')";
			    $exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
				
				 $query56="INSERT INTO master_visitentry(patientcode,visitcode,registrationdate, patientfirstname,patientmiddlename, patientlastname,patientfullname,paymenttype,subtype,billtype,accountname,accountexpirydate,planname,planexpirydate,overalllimit,availablelimit,consultingdoctor,consultingdoctorcode,department,departmentname,consultationdate,consultationtime,consultationfees,visitlimit,consultationtype,username,visitcount,planfixedamount,planpercentage,patientspent,triagestatus,age,gender,consultationrefund,accountfullname,locationcode,admitid,smartbenefitno,locationname,paymentstatus,complaint,transactionId)values('$customercode','$visitcode','$registrationdate','$customername','$customermiddlename','$customerlastname','$customerfullname','$paymenttype','$subtype','PAY LATER','$accountname','$accountexpirydate','$planname','$planexpirydate','$overalllimit','$availablelimit','$consultingdoctor','$consultingdoctorcode','$department','$departmentname','$consultationdate','$consultationtime','$consultationfees','$visitlimit','$consultationtype','$username','$visitcount','$planfixedamount','$planpercentage','$patientspent','$triagestatus','$ageno','$gender','torefund','$accname','".$locationcode."','$admitid','$smartbenefitno','$locationname','$paymentstatus','$triag','$transactionId')";  
				//exit;
			    $exec56=mysql_query($query56) or die(mysql_error());
			   

			   if($paymenttype==1 && $consultationfees > 0){
					include "patient_billing.php";
				}
				 $status = 'success';
				// exit;
		}
				
	}else{

  	$customercode=$_REQUEST['customercode'];
	$update_customer ="UPDATE master_customer set mobilenumber='$mobilenumber',mothername='$mothername',gender='$gender' where customercode='$customercode'";		
	
	$query56="INSERT INTO master_visitentry(patientcode,visitcode,registrationdate, patientfirstname,patientmiddlename, patientlastname,patientfullname,paymenttype,subtype,billtype,accountname,accountexpirydate,planname,planexpirydate,overalllimit,availablelimit,consultingdoctor,consultingdoctorcode,department,departmentname,consultationdate,consultationtime,consultationfees,visitlimit,consultationtype,username,visitcount,planfixedamount,planpercentage,patientspent,triagestatus,age,gender,consultationrefund,accountfullname,locationcode,admitid,smartbenefitno,locationname,paymentstatus,complaint,transactionId)values('$customercode','$visitcode','$registrationdate','$customername','$customermiddlename','$customerlastname','$customerfullname','$paymenttype','$subtype','PAY LATER','$accountname','$accountexpirydate','$planname','$planexpirydate','$overalllimit','$availablelimit','$consultingdoctor','$consultingdoctorcode','$department','$departmentname','$consultationdate','$consultationtime','$consultationfees','$visitlimit','$consultationtype','$username','$visitcount','$planfixedamount','$planpercentage','$patientspent','$triagestatus','$ageno','$gender','torefund','$accname','".$locationcode."','$admitid','$smartbenefitno','$locationname','$paymentstatus','$triag','$transactionId')";  
	//	exit;
		$exec56=mysql_query($query56) or die(mysql_error());
		
		if($paymenttype==1 && $consultationfees > 0){
			include "patient_billing.php";
		}
		 $status = 'success';
	 
		 $query102 = "select * from master_customer where registrationdate = '$registrationdate' and registrationtime = '$registrationtime' order by auto_number desc limit 0,1" ;
	    $exec102 = mysql_query($query102) or die ("Error in Query102".mysql_error());
		$res102 = mysql_fetch_array($exec102);
		$previouscustomercode = $res102['customercode'];
				
		//$dateposted = $updatedatetime;

		// new customer entry variables
		$mothername = '';
		$age = '';
		$typeofcustomer = '';
		$address1 = '';
		$address2 = '';
		$area = '';
		$city = '';
		$state = '';
		$country = '';
		$pincode='';
		$phonenumber1 = '';
		$phonenumber2 = '';
		//$mobilenumber = '';
		$emailid1 = '';
		$emailid2 = '';
		$tinnumber = '';
		$cstnumber ="";
		$openingbalance ="";
		$remarks ="";
		//$status ="";
		$insuranceid = '';
		$nameofrelative = '';
		$dateofbirth = '';
		$maritalstatus = '';
		$bloodgroup = '';
		$registrationtime = '';
		$occupation = '';
		//$nationalidnumber = '';
		$salutation = '';
		$kinname='';
		$kincontactnumber = '';
		$planvaliditystart = '';
		$maintype = '';
		$mrdno = '';
		
		// op visit entry variables
		$customercode="";
		
		$registrationdate="";
		$customername = '';
		$customermiddlename = '';
		$customerlastname = '';
		$customerfullname='';
		$paymenttype = '';
		$subtype  = '';
		$billtype  = '';
		$accountname  = '';
		$accountexpirydate = '';
		$planname = '';
		$planexpirydate  = '';
		$overalllimit = '';
		$availablelimit = '';
		$consultingdoctor  = '';
		$consultingdoctorcode = '';
		$department = '';
		$departmentname  = '';
		$consultationdate = '';
		$consultationtime = '';
		$consultationfees  = '';
		$visitlimit = '';
		$consultationtype = '';
		$username = '';
		$visitcount = '';
		$planfixedamount = '';
		$planpercentage  = '';
		$patientspent = '';
		$triagestatus = '';
		$ageno = '';
		$ageduration = '';
		$gender = '';
		$accname = '';
		$locationcode = '';
		$admitid = '';
		$smartbenefitno = '';
		$locationname = '';
		$hospitalfees = '';
		$kincontactnumber = '';
		$doctorfees = '';
		$triag = '';

		// **************************************************************************************************			
/* 		$fields_string ="";
		
		$url = 'https://med360-mtiba.tislive.com/visit_update.php';
		//$url = 'http://localhost/api/visit_update.php';		
		
		$fields = array(
		 'idNumber' => urlencode($nationalidnumber),
		 'visitCode' => urlencode($visitcode),
		 'tillNumber' => urlencode('456789')
		);
		
		//url-ify the data for the POST
		foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		rtrim($fields_string, '&');
		//open connection
		$ch = curl_init();
		
		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,0); 
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
		
		//execute post
		$result=curl_exec($ch);
		//print_r($result);
		
		if(curl_error($ch))
		{
		 $return_data['status']=0;
		 $return_data['response_message']=curl_error($ch);
		 $return_data['type']="MTIBA";
		   // return $return_data;
		}else{
		   
			$info = curl_getinfo($ch);
			$json = json_decode($result, true);
			//print_r($json);
			if($info['http_code']=='200' && count($json) > 0)
			{	
				print_r($json);
			}
		}
		//close connection
		curl_close($ch); */
// **************************************************************************************************
	}

// **************************** start by ganesh  *************************************		
	if($status == 'success'){
		$fields1 ="";	
		
		$fields1 = array(
		 'visitcode' => urlencode($visitcode),
		 'nationalId' => urlencode($nationalidnumber),
		 'phoneNo' => urlencode($mobilenumber),
		 'transactionId' => urlencode($transactionId)
		);	
		//print_r($fields1);
		
		$jsondata1 =  json_encode($fields1); 
		$curl = curl_init();
   
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://med360-mtiba.tislive.com/queue_visit_update.php",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => $jsondata1,
			CURLOPT_HTTPHEADER => array(
			"cache-control: no-cache",
			"content-type: application/json",
			),
		));
		 
		$response1 = curl_exec($curl);
		$err1 = curl_error($curl);
		
		curl_close($curl);
      
		if ($err1) {
			echo "No Internet Connection"; exit;
//			echo "cURL Error #:" . $err1;
		} else {
			//echo $response1;
		}

		header("location:data_mtiba.php?st=$status");
		exit;

	}
 // **************************** end by ganesh  *************************************	

/*	if($buttonname == "Save Registration (Alt+S)"){
		header("location:data_mtiba.php?st=$status");
		exit;
	}
	if($buttonname == "Save & Go OP Visit (Alt+O)"){
		header("location:newopvisit.php?patientcode=$previouscustomercode");
		exit;
	}
	if($buttonname == "Save & Go IP Visit (Alt+I)"){
		header("location:newipvisit.php?patientcode=$previouscustomercode");
		exit;
	} */	
//	exit;

}else{
		$mothername = '';
		$age = '';
		$typeofcustomer = '';
		$address1 = '';
		$address2 = '';
		$area = '';
		$city = '';
		$state = '';
		$country = '';
		$pincode='';
		$phonenumber1 = '';
		$phonenumber2 = '';
		$mobilenumber = '';
		$emailid1 = '';
		$emailid2 = '';
		$tinnumber = '';
		$cstnumber ="";
		$openingbalance ="";
		$remarks ="";
		$status ="";
		$insuranceid = '';
		$nameofrelative = '';
		$dateofbirth = '';
		$maritalstatus = '';
		$bloodgroup = '';
		//$registrationtime = '';
		$occupation = '';
		
		$salutation = '';
		$kinname='';
		$kincontactnumber = '';
		$planvaliditystart = '';
		$maintype = '';
		$mrdno = '';
		
		// op visit entry variables
		//$customercode="";
		$visitcode="";
		//$registrationdate="";
		$customername = '';
		$customermiddlename = '';
		$customerlastname = '';
		$customerfullname='';
		$paymenttype = '';
		$subtype  = '';
		$billtype  = '';
		$accountname  = '';
		$accountexpirydate = '';
		$planname = '';
		$planexpirydate  = '';
		$overalllimit = '';
		$availablelimit = '';
		$consultingdoctor  = '';
		$consultingdoctorcode = '';
		$department = '';
		$departmentname  = '';
		$consultationdate = '';
		$consultationtime = '';
		$consultationfees  = '';
		$visitlimit = '';
		$consultationtype = '';
		//$username = '';
		$visitcount = '';
		$planfixedamount = '';
		$planpercentage  = '';
		$patientspent = '';
		$triagestatus = '';
		$ageno = '';
		$ageduration = '';
		$gender = '';
		$accname = '';
		$locationcode = '';
		$admitid = '';
		$smartbenefitno = '';
		$locationname = '';
		$hospitalfees = '';
		$kincontactnumber = '';
		$doctorfees = '';
		$triag = '';
}

	if (isset($_REQUEST["st"])) { 
		$st = $_REQUEST["st"]; 
	}else {
		$st = "";
	}
	if ($st == 'success'){
		$errmsg = "Success. New Patient Updated.";
		if (isset($_REQUEST["cpynum"])) { $cpynum = $_REQUEST["cpynum"]; } else { $cpynum = ""; }
		if ($cpynum == 1){ //for first company.
			$errmsg = "Success. New Patient Updated.";
		}
		$bgcolorcode = 'success';
	}else if ($st == 'failed'){
		$errmsg = "Failed. Photo Upload Failed Or Patient Already Exists.";
		$bgcolorcode = 'failed';
    }
	if (isset($_REQUEST["cpycount"])) { $cpycount = $_REQUEST["cpycount"]; } else { $cpycount = ""; }
	if ($cpycount == 'firstcompany'){
		$errmsg = "Welcome. You Need To Add Your Company Details Before Proceeding.";
	}

	
	$query3 = "select * from login_locationdetails where docno = '".$docno."' and username = '$username' order by locationname";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	$res3 = mysql_fetch_array($exec3);
	$res3locationcode = $res3['locationcode'];
 	

	$query77 = "select * from master_location where locationcode = '$res3locationcode'";
	$exec77 = mysql_query($query77) or die ("Error in Query77".mysql_error());
	$res77 = mysql_fetch_array($exec77);
	$patientcodeprefix = $res77['prefix'];
	$suffix =  date('y');
	$patientcodeprefix ="RUNH";

 
    $query5 = "select * from master_visitentry where patientcode = '$customercode' and recordstatus = ''";
	$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
	$rowcount5 = mysql_num_rows($exec5);
	if($rowcount5=="0"){
		$rowcount51="1";
	}else{
	   $rowcount51 = $rowcount5 + 1;		
	}
	 $visitcount = $rowcount51;
 
    $query05 = "select patientcode from master_visitentry where patientcode = '$customercode' ";
	$exec05 = mysql_query($query05) or die ("Error in Query05".mysql_error());
	$rowcount05 = mysql_num_rows($exec05);
 
	$patientcodeprefix1=strlen($patientcodeprefix);
	$patientcodeprefix1=$patientcodeprefix1+1;
	
	$query2 = "select * from master_customer order by auto_number desc limit 0, 1";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	$res2 = mysql_fetch_array($exec2);
	$res2customercode = $res2["customercode"];
	$customercode11=array();
	if ($res2customercode == '')
	{
		//$customercode = 'AMF00000001';
		$customercode = $patientcodeprefix.'-'.'1'.'-'.$suffix;
		$openingbalance = '0.00';
	}
	else
	{    
		 $res2customercode = $res2["customercode"];
		$customercode11 = explode("-",$res2customercode);
		$customercode=$customercode11[1];
		$customercode = intval($customercode);
		$customercode = $customercode + 1;
		//echo $customercode;
		$maxanum = $customercode;
		$customercode = $patientcodeprefix.'-'.$maxanum.'-'.$suffix;
		$openingbalance = '0.00';
		//echo $companycode;
	}

	if (isset($_REQUEST["svccount"])) { $svccount = $_REQUEST["svccount"]; } else { $svccount = ""; }
	if ($svccount == 'firstentry')
	{
		$errmsg = "Please Add Patient To Proceed For Billing.";
		$bgcolorcode = 'failed';
	}

	function calculate_age($birthday){
		if($birthday=="0000-00-00"){
			return '0 DAYS';
		}else{
			$today = new DateTime();
			$diff = $today->diff(new DateTime($birthday));
			if ($diff->y)
			{
				return $diff->y.' YEARS';
			}
			elseif ($diff->m)
			{
				return $diff->m.' MONTHS';
			}
			else
			{
				return $diff->d.' DAYS';
			}
		}
	}

if (isset($_REQUEST["errorcode"])) { $errorcode = $_REQUEST["errorcode"]; } else { $errorcode = ""; }
//$patientcode = 'MSS00000009';
if ($errorcode == 'errorcode1failed')
{
	$errmsg = 'Patient Already Visited Today. Cannot Proceed With Visit Entry. Save Not Completed.';	
}
else if ($errorcode == 'errorcode2failed')
{
	$errmsg = 'Cannot Proceed With Visit Entry.Bill Is Not Finalized. Save Not Completed.';	
}

include ("autocompletebuild_paymenttype.php");
?>
<?php 
	$query = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
	$exec = mysql_query($query) or die ("Error in Query1".mysql_error());
	$res = mysql_fetch_array($exec);
		
		$res12location = $res["locationname"];
		$res12locationcode = $res['locationcode'];
		$res12locationanum = $res["auto_number"];

	$query3 = "select * from master_location where status = '' and locationname='$res12location'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	$res3 = mysql_fetch_array($exec3);
		$visitcodeprefix = $res3['prefix'];
		$visitcodeprefix1=strlen($visitcodeprefix);

	$query2 = "select * from master_visitentry order by auto_number desc limit 0, 1";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	$res2 = mysql_fetch_array($exec2);
	$res2visitcode = $res2["visitcode"];
	if($res2visitcode!='')
	{
	 $res2visitnum=strlen($res2visitcode);
	 $vvcode6=explode("-",$res2visitcode);
	 $testvalue= $vvcode6[1];
					  $value6=strlen($testvalue);
					  $visitcodepre6=$res2visitnum-$value6;
	}
	if ($res2visitcode == '')
	{
		$maxanum= '1';
		$visitcode =$visitcodeprefix.'-'.'1';
		$openingbalance = '0.00';
		
	}
	else
	{

		$res2visitcode = $res2["visitcode"];
		$visitcode = substr($res2visitcode,$visitcodepre6,$res2visitnum);
		$visitcode = intval($visitcode);
		
		$visitcode = $visitcode + 1;
		$maxanum = $visitcode;
		
		
		$visitcode = $visitcodeprefix.'-'.$maxanum;
		$openingbalance = '0.00';
		//echo $companycode;
	}
	
//	if(isset($_REQUEST['mtibaid'])) { $mtibaid = $_REQUEST['mtibaid']; } else { $mtibaid = ''; }
	if(isset($_REQUEST['txnid'])) { $txnId = $_REQUEST['txnid']; } else { $txnId = ''; }
	
	$fields_string ="";
		
	//$url = 'http://localhost/api/queue_search.php';	
	
	$fields = array(
//	 'idNumber' => urlencode($mtibaid),
	 'transactionId' => urlencode($txnId),
	 'tillNumber' => urlencode($till_number)
	);
	
	//url-ify the data for the POST
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string, '&');
	//open connection
	$ch = curl_init();
	//print_r($fields_string);
	//set the url, number of POST vars, POST data
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_POST, count($fields));
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,0); 
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
	
	//execute post
	$result=curl_exec($ch);
	
	if(curl_error($ch))
		{
		 $return_data['status']=0;
		 $return_data['response_message']=curl_error($ch);
		 $return_data['type']="MTIBA";
		   // return $return_data;
		}else{
			$info = curl_getinfo($ch);
			$json = json_decode($result,true);
			//print_r($json);
		}

		$mtibaid = 'MED***';
		$isminor = '0';


		$id_with = '';	
		$id_with_plus = '';	
		$id = '';	
		$id_no_mobile = '';	

		if($info['http_code']=='200' && count($json) > 0)
		{	
			$mtibaid = $json[0]['idNumber'];
			$isminor = $json[0]['isMinor'];

			$id_with = trim($mtibaid);	
			$id_with_plus = str_replace('-254','-+254', trim($mtibaid));	
			$id = str_replace('-254','-0', trim($mtibaid));	
			$id_no_mobile = substr(trim($mtibaid),0,-12);	

		}		


//	$customercode='';
		$isminor = 1;


	$query34 = "SELECT * FROM `master_customer` where concat(trim(`customername`),' ',trim(`customerlastname`),'-',trim(`dateofbirth`),'-',trim(`mobilenumber`))='$id_with' OR concat(trim(`customername`),' ',trim(`customerlastname`),'-',trim(`dateofbirth`),'-',trim(`mobilenumber`))='$id_with_plus' OR concat(trim(`customername`),' ',trim(`customerlastname`),'-',trim(`dateofbirth`),'-',trim(`mobilenumber`))='$id' OR concat(trim(`customername`),' ',trim(`customerlastname`),'-',trim(`dateofbirth`),'-',trim(`mobilenumber`))='$id_no_mobile' UNION ALL SELECT * FROM `master_customer` where `nationalidnumber` = '$mtibaid'";

	
	$exec34 = mysql_query($query34) or die ("Error in Query34".mysql_error());
	$res34 = mysql_fetch_array($exec34);
	$row34 = mysql_num_rows($exec34);
	if($row34 == 0)
    {
		if($info['http_code']=='200' && count($json) > 0)
		{	
			$mpatientname = $json[0]['names'];
			$namearray=explode(" ",$mpatientname,2);			
			$mpatientname = $namearray[0];
			$mpatientmiddlename = '';
			$mpatientlastname = $namearray[1];
			$mdob = $json[0]['dob'];
			$res2age1 = calculate_age($mdob);
			$res2age = explode(" ",$res2age1);
			$midNumber = "";
//			print_r($res2age);
			if($res2age[0]>="18" && $res2age[1]=="YEARS"){
				$midNumber = $mtibaid;
				$isminor = 0;
			}
			$mgender = $json[0]['gender'];
			$mbalance = $json[0]['balance'];
			$mmobileNumber = $json[0]['mobileNumber'];
			$mtransactionId = $json[0]['transactionId'];
		
		}	
    }
	else
	{
		$mpatientname = $res34['customername'];
		$mpatientmiddlename = $res34['customermiddlename'];
		$mpatientlastname = $res34['customerlastname'];
		$mdob = $res34['dateofbirth'];
		$res2age1 = calculate_age($mdob);
		$res2age = explode(" ",$res2age1);
		$midNumber = "";
		if($res2age[0]>="18" && $res2age[1]=="YEARS"){
			$midNumber = $mtibaid;
     		$isminor = 0;
		}
		$mgender = $res34['gender'];
		if($mgender == 'Male'){ $mgender = 'M'; }
		if($mgender == 'Female'){ $mgender = 'F'; }
		$customercode = $res34['customercode'];
		$mbalance = $json[0]['balance'];
		$mmobileNumber = $json[0]['mobileNumber'];
			$this_visit=1;
		$mtransactionId = $json[0]['transactionId'];
	}
	//close connection
	curl_close($ch);
	
    $url ="http://apiv1.prod.carepool.co.ke/users/".$mmobileNumber."/programs/40";
	
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => array(
		"authorization: Bearer  eyJhbGciOiJSUzUxMiJ9.eyJzdWIiOiJtZXNzYWdpbmciLCJncmFudHMiOnsiU3lzdGVtIjoiQXc9PSJ9fQ.hFJ9ImDWsdt42rUE-lRyBRTftfEt89Ev6MUUsht7j6UAVn_XzzQTK5lYXa0giGWR_hOUdjCp4WKK8pw9b1cO7zh6mKF32ep7DvMx0vlF-FFdNqcQ3jlSTz1BVg_fMKsafAHiDlLniNsPZv1HzY-eIXKDEgrCix38bcDUqzR9Alw",
		"content-type: application/json",
		
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);
	print_r($err);
	
	curl_close($curl);
	if ($err) {
			echo "No Internet Connection"; exit;

//	  echo "cURL Error #:" . $err;
	} else {
		//echo $response;
		$obj = json_decode($response,true); 
		if(isset($obj['balance'])){
			$mbalance = $obj['balance'];
				
		}
	}		

$mbalance = str_replace(',', '', $mbalance);
?>
<style type="text/css">
.ui-menu .ui-menu-item{ zoom:1 !important; }

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

.box{
    padding: 20px;
    display: none;
    margin-top: 20px;
    border: 1px solid #000;
}

body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
</style>

<link   rel="stylesheet"  href="autocomplete.css"  />  
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/autocustomercodesearch2op1.js"></script>


<script src="js/datetimepicker_css.js"></script>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script>

$(document).ready(function() {

	//$(".opvisit-hide").hide();
//	$(".personal-hide").hide();
//	$(".billing-hide").hide();
	//$(".misc -hide").hide();
	$(".contact-hide").hide();
	$(".cl").hide();
	$(".oldcl").hide();
	$(".profilepic").hide();
			
	
	$("#customercode1").hide();


	
	$("input:radio[name=choosetype]").click(function () {
		var val=this.value;
	    if(val=="1"){
			
			//$('form')[0].removeAttr();
			//window.open('newpatientreg2.php','_self');
	    	$("#oldpatient").hide();
			$("#oldpatient1").hide();
			$(".cl").hide();
			$("#customercode").show();
			$("#customercode1").hide();
			$("#patienttypeid").val(1);
			$(".oldcl").hide();
			$(".profilepic").hide();
			
			$('#ageno').prop("readonly", false);
			$('#ageduration').prop("readonly", false);
			$('#customername').prop("readonly", false);
			$('#customermiddlename').prop("readonly", false);
			$('#customerlastname').prop("readonly", false);
			$('#searchpaymenttype11').prop("readonly", false);
			$('#searchpaymenttype12').prop("readonly", false);
			$('#searchaccountname').prop("readonly", false);
			$('#mothername').prop("readonly", false);
			$('#mobilenumber').prop("readonly", false);
			$('#area').prop("readonly", false);
			$('#dateofbirth').prop("readonly", false);
			$('#nationalidnumber').prop("readonly", false);
			$('#mrdno').prop("readonly", false);
			document.getElementById('patientimage').src = 'patientphoto/noimage.jpg';
			$('form')[0].reset();
			
	    }else{
			//$('form')[0].reset();
			//window.open('newpatientreg2.php','_self');
	    	$("#oldpatient").show();
			$("#oldpatient1").show();
			$(".cl").show();
			$("#customercode").hide();
			$("#customercode1").show();
			$("#patienttypeid").val(2);
			$(".oldcl").show();
			$(".profilepic").show();
			document.getElementById('patientimage').src = 'patientphoto/noimage.jpg';
			
		}
	});


  
});

function funcCheckmtibalance(){
//alert(autono);
var phoneno = $("#mobilenumber").val();
var transId = $("#transactionId").val();
//alert(phoneno+""+transId);
	if(phoneno !="" && transId != ""){
	
	var data = "phoneNumber="+phoneno+"&&transactionId="+transId;
    //alert(data);
	$.ajax({
		type : "get",
		url : "ajaxUpdateAvailaleBalanceinReg.php",
		data : data,
		cache : false,
		success : function (data){
			
			if(data !=""){
				//alert(data);
				$("#availablelimit").val(data);
//				location.reload();
			} 				
		}
	   
	});
	}	
}

</script>

<script type="text/javascript" src="js/nationalidnovalidation1.js"></script>
<script type="text/javascript" src="js/nationalidnovalidation2.js"></script>


	
<script>

function GetDifference1()
{
	//To reset any existing values;
	document.getElementById("age").value = "";
	document.getElementById("ageduration").value = "";

	var dtFrom = document.getElementById("dateofbirth").value;
	var dtTo = document.getElementById("todaydate").value;

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
		//To Count Days.
	if (varMonthCount == 0)// || varMonthCount > 0)
	{
		//document.getElementById('ageduration').selectedIndex = 1; //To Select Month, index number 2 given.
		document.getElementById('ageduration').value = 'DAYS';
	
		var dtFrom = document.getElementById("dateofbirth").value;
		var dtTo = document.getElementById("todaydate").value;
		
		//To change format from YYYY-MM-DD to MM-DD-YYYY
		var mystr1 = dtFrom;
		var myarr1 = mystr1.split("-");
		
	    var dtFrom = myarr1[1] + "-" + myarr1[2] + "-" + myarr1[0];
		
		var mystr2 = dtTo;
		var myarr2 = mystr2.split("-");
	    var dtTo = myarr2[1] + "-" + myarr2[2] + "-" + myarr2[0];
		
		var dtFrom = new Date(dtFrom);
		var dtTo = new Date(dtTo);
		
		// 24 hours, 60 minutes, 60 seconds, 1000 milliseconds
		var varDaysCount = Math.round((dtTo - dtFrom) / (1000 * 60 * 60 * 24)); // round the amount of days
		
		document.getElementById("age").value = varDaysCount;

	}
	
	if (varMonthCount > 12)
	{
		var dtFrom = document.getElementById("dateofbirth").value;
		
		//To change format from YYYY-MM-DD to YYYYMMDD
		var mystr1 = dtFrom;
		var myarr1 = mystr1.split("-");
		var dtFrom = myarr1[0] + "" + myarr1[1] + "" + myarr1[2];
		
		//var dob='19800810';
		var dob = dtFrom;
		var year = Number( dob.substr(0,4) );
		var month = Number( dob.substr(4,2) ) - 1;
		var day = Number( dob.substr(6,2) );
		var today = new Date();
		var age = today.getFullYear() - year;
		if( today.getMonth() < month || ( today.getMonth() == month && today.getDate() < day )) { age--; }
		
		var varYearsCount = age;
		
		document.getElementById('ageduration').value = 'YEARS';
		document.getElementById("age").value = varYearsCount;
	}

idhide();	
}

function months_between(date1, date2)
{
	return date2.getMonth() - date1.getMonth() + (12 * (date2.getFullYear() - date1.getFullYear()));
}

function namevalid(key)
{
	var alpha = /^[a-zA-Z ]*$/; 
	
	if(!alpha.test(document.form1.customername.value))
	{
		alert ("Please Enter Alphabet First Name.");
		document.form1.customername.focus();
		return false;
	}
	if(!alpha.test(document.form1.customermiddlename.value))
	{
		alert ("Please Enter Alphabet Middle Name.");
		document.form1.customermiddlename.focus();
		return false;
	}
	if(!alpha.test(document.form1.customerlastname.value))
	{
		alert ("Please Enter Alphabet Last Name.");
		document.form1.customerlastname.focus();
		return false;
	}
	 var keycode = (key.which) ? key.which : key.keyCode;

	 if(!(keycode < 48 || keycode > 57))
	{
		return false;
	}
	
	if (isNaN(document.form1.age.value))
	{
		alert ("Please Enter Number to Age");
		document.form1.age.focus();
		return false;
	}
}
function validatenumerics(key) {
    //getting key code of pressed key
    var keycode = (key.which) ? key.which : key.keyCode;
    //comparing pressed keycodes
    if (keycode > 31 && (keycode < 48 || keycode > 57)) {
      //alert(" You can enter only characters 0 to 9 ");
      return false;
    }else {return true;}
}

function idhide(){
	//alert(document.getElementById("ageduration").value);
	if (document.getElementById("age").value < 18  || document.getElementById("ageduration").value!="YEARS" ){
		document.form1.nationalidnumber.disabled = true;
		document.form1.mothername.disabled = false;
	} else {
		document.form1.nationalidnumber.disabled = false;
		document.form1.mothername.disabled = true;
	}
}

function concatmiddledob(){
	var customermiddlename = document.getElementById("customerlastname").value;
	var dateofbirth	 = document.getElementById("dateofbirth").value;
	//document.getElementById("nationalidnumber").value=customermiddlename+dateofbirth;
}

function dobcalc(){
	var age=document.getElementById("age").value;
	document.getElementById('ageduration').value = 'YEARS';
	var year1= new Date();
	var yob=year1.getFullYear() - age;
	var dob= yob+"-"+"0"+1+"-"+"0"+1;
	document.getElementById("dateofbirth").value = dob;
	//alert(dob);
}

function process1()
{
	
	if(document.getElementById("availablelimit").value <= 0)
	{
		//alert ("Available Limit Cannot be Zero.");	
		alert("You Cannot Proceed Because No Available Balance");
		document.form1.availablelimit.focus();
		return false;		
  	}
	
	var alpha = /^[a-zA-Z ]*$/; 
	//alert ("Inside Function");

	if (document.form1.customername.value == "")
	{
		alert ("Please Enter First Name.");
		document.form1.customername.focus();
		return false;
	}

	if(!alpha.test(document.form1.customername.value))
	{
		alert ("Please Enter Alphabet First Name.");
		document.form1.customername.focus();
		return false;
	}
	if(!alpha.test(document.form1.customermiddlename.value))
	{
		alert ("Please Enter Alphabet Middle Name.");
		document.form1.customermiddlename.focus();
		return false;
	}

	if (document.form1.customerlastname.value == "")
	{
		alert ("Please Enter Last Name.");
		document.form1.customerlastname.focus();
		return false;
	}
	if(!alpha.test(document.form1.customerlastname.value))
	{
		alert ("Please Enter Alphabet Last Name.");
		document.form1.customerlastname.focus();
		return false;
	}


	if (document.form1.gender.value == "")
	{
		alert ("Please Select Gender");
		document.form1.gender.focus();
		return false;
	}
		if (document.form1.dateofbirth.value == "")
	{
		alert ("Please Select Date Of Birth.");
		document.form1.dateofbirth.focus();
		return false;
	}

	if (isNaN(document.form1.age.value))
	{
		alert ("Please Enter Number to Age");
		document.form1.age.focus();
		return false;

	}

	if (document.getElementById("age").value < 18)
	{
		if (document.form1.mothername.value == "")
		{
			alert ("Please Enter Guardian Name.");
			document.form1.mothername.focus();
			return false;
		}
	}
		
	if (document.getElementById("age").value >= 18  && document.getElementById("ageduration").value=="YEARS" )
	{	
		if (document.form1.nationalidnumber.value == "")
		{
			alert ("Please Enter ID/Digitika Card Number .");
			document.form1.nationalidnumber.focus();
			return false;
		}
			
	
	}	
	
	if (document.form1.mobilenumber.value == "")
	{
		alert ("Please Enter Mobile Number.");
		document.form1.mobilenumber.focus();
		return false;
	}
	
	var confirm1=confirm("Do You Want To Save The Record?");
	if(confirm1 == true) 
	{
		document.getElementById("submit").disabled=true;
		document.form1.submit();
	}
	else
	{
		return false;
	}

//return true;
}

function clearcode(idname){
	document.getElementById(idname).value='';
}

function collapsethis(getid){
//	$("."+getid).toggle();
}

</script>

<script>
function funcPopupOnLoad1(){
<?php 
if (isset($_REQUEST["savedpatientcode"])) { $savedpatientcode = $_REQUEST["savedpatientcode"]; } else { $savedpatientcode = ""; }
?>
var patientcodes;
var patientcodes = "<?php echo $savedpatientcode; ?>";
//alert(patientcodes);
if(patientcodes != "") 
{
	window.open("print_registration_label.php?previouspatientcode="+patientcodes+" ","OriginalWindowA4",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
}
}
</script>

<script>
function funcPopupOnLoad2()
{
<?php 
if (isset($_REQUEST["savedpatientcode1"])) { $savedpatientcode1 = $_REQUEST["savedpatientcode1"]; } else { $savedpatientcode1 = ""; }
?>
var patientcodes1;
var patientcodes1 = "<?php echo $savedpatientcode1; ?>";
//alert(patientcodes1);
if(patientcodes1 != "") 
{
	window.open("print_registration_label.php?previouspatientcode="+patientcodes1+" ","OriginalWindowA5",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
}
}
</script>

<script>
function funcPopupOnLoader()
{
funcPopupOnLoad1();
funcPopupOnLoad2();

}

function funcVistLimit()
{
var varaccountcode = document.getElementById("searchaccountcode").value;

	<?php
	$query11 = "select * from master_planname where recordstatus = 'ACTIVE'";
	$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
	while ($res111 = mysql_fetch_array($exec11))
	{
	$res11plannameanum = $res111['auto_number'];
		$res11planname = $res111["planname"];

	$accountname = $res111["accountname"];
	$res11planexpirydate = $res111['planexpirydate'];
	//$res11visitlimit = $res111['visitlimit'];
	//$res11overalllimit = $res111['overalllimit'];
	$res11planfixedamount = $res111['planfixedamount'];
	$res11planpercentage = $res111['planpercentage'];
	?>
	 	
		
		if( varaccountcode == "<?php echo $accountname; ?>")
		{
		
			document.getElementById("planexpirydate").value = "<?php echo $res11planexpirydate; ?>";
							document.getElementById("planname").value = "<?php echo $res11planname; ?>";

			//alert("hii"+"<?php echo $res11planexpirydate; ?>");
			document.getElementById("planfixedamount").value = "<?php echo $res11planfixedamount; ?>";
			document.getElementById("planpercentage").value = "<?php echo $res11planpercentage; ?>";
		}
	<?php
	}
	
	?>
	
}

</script>


<script type="text/javascript">
function ShowImage(flg)
{
	var imgval = document.getElementById('customercode1').value;
	
	if(imgval != '')
	{
		if(flg == 'Show Image') {
			
		var photoavailable = document.getElementById('photoavailable').value;
		if(photoavailable == 'YES') {
		document.getElementById('patientimage').src = 'patientphoto/'+imgval+'.jpg';
		} else {
		document.getElementById('patientimage').src = 'images/noimage.jpg';
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
<script>
function readURL(input) {
	
	if (input.files && input.files[0]) {
		var reader = new FileReader();
			reader.onload = function (e) {
			//document.getElementById('blah').src =e.target.result;
			 $('#patientimage').attr('src', e.target.result); 
			};
		reader.readAsDataURL(input.files[0]);
   }
}
</script>
<script>	
<?php 
if (isset($_REQUEST["consbillautonumber"])) { $consbillautonumbers = $_REQUEST["consbillautonumber"]; } else { $paynowpatientcoder = ""; }
?>
	var consbillautonumberr;
	var consbillautonumberr = "<?php echo $consbillautonumbers; ?>";
	//alert(refundbillnumber);
	if(consbillautonumberr != "") 
	{
		window.open("print_consultationbill_dmp4inch1.php?billautonumber="+consbillautonumberr+"","OriginalWindowA25",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
	}				
</script>

<!--
<script>
<?php 
if (isset($_REQUEST["refundbillnumber"])) { $refundbillnumbers = $_REQUEST["refundbillnumber"]; } else { $refundbillnumbers = ""; }
if (isset($_REQUEST["patientcode"])) { $refundpatientcode = $_REQUEST["patientcode"]; } else { $refundpatientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $refundvisitcode= $_REQUEST["visitcode"]; } else { $refundvisitcode = ""; }
if (isset($_REQUEST["locationode"])) { $refundlocationode= $_REQUEST["locationode"]; } else { $refundlocationode = ""; }
?>
	var refundbillnumber;
	var refundbillnumber = "<?php echo $refundbillnumbers; ?>";
	var refundpatientcodes;
	var refundpatientcodes = "<?php echo $refundpatientcode; ?>";
	var refundvisitcodes;
	var refundvisitcodes = "<?php echo $refundvisitcode; ?>";
	var refloccode;
	var refloccode = "<?php echo $refundlocationode; ?>";
	//alert(refundbillnumber);
	if(refundbillnumber != "") 
	{
		window.open("print_paynow_refund.php?billnumber="+refundbillnumber+"&&patientcode="+refundpatientcodes+"&&visitcode="+refundvisitcodes+"&&locationcode="+refloccode,"OriginalWindowA25",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
	}	
</script>
<script>
<?php 
if (isset($_REQUEST["otcbillnumber"])) { $otcbillnumbers = $_REQUEST["otcbillnumber"]; } else { $otcbillnumbers = ""; }
?>
	var otcbillnumberr;
	var otcbillnumberr = "<?php echo $otcbillnumbers; ?>";
	//alert(refundbillnumber);
	if(otcbillnumberr != "") 
	{
		window.open("print_otcbilling_dmp4inch1.php?billnumber="+otcbillnumberr,"OriginalWindowA25",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
	}	
</script>
<script>
<?php 
if (isset($_REQUEST["paynowpatientcode"])) { $paynowpatientcoder = $_REQUEST["paynowpatientcode"]; } else { $paynowpatientcoder = ""; }
if (isset($_REQUEST["paynowbillnumber"])) { $paynowbillnumbers = $_REQUEST["paynowbillnumber"]; } else { $paynowbillnumbers = ""; }
if (isset($_REQUEST["paynowpatientcode1"])) { $paynowpatientcoder1 = $_REQUEST["paynowpatientcode1"]; } else { $paynowpatientcoder1 = ""; }
if (isset($_REQUEST["waiverdocno"])) { $waiverdocno = $_REQUEST["waiverdocno"]; } else { $waiverdocno = ""; }
?>
	var paynowpatientcoderr;
	var paynowpatientcoderr = "<?php echo $paynowpatientcoder; ?>";
	
	
	
	var paynowbillnumberr;
	var paynowbillnumberr = "<?php echo $paynowbillnumbers; ?>";
	//copay
	var paynowpatientcoderr1;
	var paynowpatientcoderr1 = "<?php echo $paynowpatientcoder1; ?>";
	
	var waiverdoc = "<?php echo $waiverdocno; ?>";
	//alert(refundbillnumber);
	if(paynowpatientcoderr1 != "") 
	{
		window.open("print_billpaynowbill_dmp4inch_copay.php?waiverdoc="+waiverdoc+"&&billautonumber="+paynowbillnumberr+"&&patientcode="+paynowpatientcoderr+"","OriginalWindowA25",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
	}	
	else if(paynowpatientcoderr != "") 
	{
		window.open("print_billpaynowbill_dmp4inch1.php?waiverdoc="+waiverdoc+"&&billautonumber="+paynowbillnumberr+"&&patientcode="+paynowpatientcoderr+"","OriginalWindowA25",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
	}	
	
</script>

<script>	
<?php 
if (isset($_REQUEST["ipbillnumber"])) { $ipbillnumbers = $_REQUEST["ipbillnumber"]; } else { $ipbillnumbers = ""; }
if (isset($_REQUEST["ippatientcode"])) { $ippatientcodes = $_REQUEST["ippatientcode"]; } else { $ipbillnumbers = ""; }
?>
	var ipbillnumberr;
	var ipbillnumberr = "<?php echo $ipbillnumbers; ?>";
	var ippatientcoder;
	var ippatientcoder = "<?php echo $ippatientcodes; ?>";
	//alert(refundbillnumber);
	if(ipbillnumberr != "") 
	{
		window.open("print_depositcollection_dmp4inch1.php?billnumbercode="+ipbillnumberr+"&&patientcode="+ippatientcoder+"","OriginalWindowA25",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
	}				
</script>

by Ganesh 01/03/2017 print bill code now no need this code in future its used -->


<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
} 

</style>

<style type="text/css">

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
.style1 {
	color: #FF0000;
	font-weight: bold;
}
.style2 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #FF0000; FONT-FAMILY: Tahoma; text-decoration: none; }
.style5 {font-size: 11px; font-family: Tahoma;}
.style9 {COLOR: #000000; FONT-FAMILY: Tahoma; text-decoration: none; font-size: 11px;}

</style>
</head>
<body onLoad="funcPopupOnLoader()">
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
	    		 //	 include ("includes/menu2.php"); ?>	
	    </td>
  	</tr>
  	<tr>
    	<td colspan="10">&nbsp;</td>
  	</tr>
  	<tr>
    	<td width="1%">&nbsp;</td>
    	<td width="2%" valign="top">&nbsp;</td>
    	<td width="97%" valign="top">
	<form name="form1" id="form1" method="post" onKeyDown="return disableEnterKey()" enctype="multipart/form-data" action="newpatientreg2.php" onSubmit="return process1();">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>
          	<td width="860">
          	<table width="1316" height="282" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
            <tr bgcolor="#E0E0E0">
            	<td bgcolor="#E0E0E0" class="bodytext3 choosetype" colspan="3">
                	<input type="hidden" name="choosetype" id="newregradio" checked value="1" onChange="Radioredirection(1)"/> 
                	<label name="newreg" for="newregradio"><strong>  </strong></label>
			  		<input type="hidden" name="choosetype" id="oldregradio" value="2" onChange="Radioredirection(2)"/> 
                	<label name="newreg" for="oldregradio"><strong>  </strong></label>
					
                </td>
				
				<td align="left" bgcolor="#E0E0E0" class="bodytext3">&nbsp;</td>
              	<td  colspan="12" align="left" bgcolor="#E0E0E0" class="bodytext3" >
	            <?php
						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno'  group by locationname order by locationname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						$loccode=array();
						while ($res1 = mysql_fetch_array($exec1)){
							$res1location = $res1["locationname"];
							$locationcode = $res1["locationcode"];
						}
				?>
				Location : <strong><?php echo $res1location; ?></strong>
				<input type="hidden" name="location" id="location" value="<?php echo $locationcode;?>">
                </td>
                 <input type="hidden" name="patienttypeid" id="patienttypeid" readonly value="1">                
            </tr>
		<!--	<tr bgcolor="#011E6A" id="oldpatient1" style="display: none;" >
                
               
                 <td colspan="15" bgcolor="#E0E0E0" class="bodytext3" id="ajaxlocation"><strong> Search Sequence : First Name | Middle Name | Last Name | Mobile Number | National ID | Registration No   (*Use "|" symbol to skip sequence)</strong> </td>
               
              </tr> -->
            <tr>
                <td colspan="15" align="left" valign="middle"  
				bgcolor="<?php if ($errmsg == ''){ echo ''; }else { echo 'red'; } ?>" class="bodytext3"><p style="color:white;"> <?php echo $errmsg;?>&nbsp;</p></td>
            </tr>
			<tr id="oldpatient" style="display: none;" >
   			    <td colspan="12" width="8%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3" ><span class="style2">*Patient Search </span>
			      &nbsp;&nbsp; 
				    <input type = "text" name="customer" id="customer" size="60" autocomplete="off">
			    	<input type="hidden" name="photoavailable" id="photoavailable" autocomplete="off" value="<?php echo $photoavailable; ?>"> 
					<input type = "hidden" name="patientcode" id="patientcode" >
				  	<input type = "hidden" name="customerhiddentextbox" id="customerhiddentextbox" value="">
				  	<input type = "hidden" name="nationalid" id="nationalid" value = "" >
				  	<input type = "hidden" name="accountnames" id="accountnames" value="" >
				  	<input type = "hidden" name = "mobilenumber111" id="mobilenumber111" value="" >
 					<input type = "hidden" name="recordstatus" id="recordstatus">
				  	<input type = "hidden" name="billnumbercode" id="billnumbercode" value="<?php echo $billnumbercode;?>">	
					<input type = "hidden" name="ageno" id="ageno" value = "">
					<input type = "hidden" name="paymenttype" id="paymenttype" value="1">
					<input type = "hidden" name="accountnamename" id="accountnamename" value = "">
					<input type = "hidden" name="plannamename" id="plannamename">
					<input type = "hidden" name="patientspent" id="patientspent" value = "">
					<input type = "hidden" name="paymenttypename" id="paymenttypename">
					<input type = "hidden" name="subtypename" id="subtypename" value = "">
					<input type = "hidden" name="planpercentageamount" id="planpercentageamount">
					<input type = "hidden" name="availablelimit1" id="availablelimit1" value="<?php echo $mbalance; ?>">
					<input type = "hidden" name="lastvisitdate" id="lastvisitdate" value="<?php echo $lastvisitdate; ?>" >
					<input type = "hidden" name="visitdays" id="visitdays">
				  	<input name="apnum" id="apnum" value="<?php echo $apnum; ?>" type="hidden">
					<input type="hidden" name="mrd" id="mrd1" value="1" <?php if($mrdno == ''){ echo 'checked'; } ?> onChange="return fileCheck(this.value,'<?php echo $mrdno; ?>')"><label for="new"> </label>&nbsp;
				  	<input type="hidden" name="mrd" id="mrd0" value="0" <?php if($mrdno != ''){ echo 'checked'; } ?> onChange="return fileCheck(this.value,'<?php echo $mrdno; ?>')"><label for="old"> </label>
                  	<input type="hidden" name="ipfileno" id="ipfileno" value="<?php echo $mrdno; ?>">
				  	<input type="hidden" name="mrd_autono" id="mrd_autono" value="<?php echo $mrd_autono; ?>">
				  	<input type="hidden" name="mrdno2" id="mrdno1" value="<?php echo $mrdno; ?>" <?php if($mrdno != ''){ echo 'readonly'; } ?>>
                </td> 
				
				
			
				
			</tr> 
         	<tr>
                <td width="8%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3" ><span class="style2">*Type </span></td>
				
                <td width="15%"  align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3 " checked>
              		<input type="hidden" name="searchpaymenttype11" id="searchpaymenttype11" <?php if($m_registrationtype==1) echo 'checked'; ?> value="1" tabindex="1"> 
              		<label for="searchpaymenttype11"><strong></strong></label>
                	<input type="hidden" name="searchpaymenttype12" id="searchpaymenttype12" <?php if($m_registrationtype==2) ?> checked value="2"> 
                	<label for="searchpaymenttype12"><strong>CREDIT</strong></label>
                            	
				</td>

                <td width="8%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="style2"> *Account </span>
				 </td>
                 <td width="15%"  align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
   	
					<?php
						// Checking/ Getting account details 
						$query4 = "select subtype,paymenttype,expirydate,auto_number,accountname from master_accountname where auto_number = '$mtiba_anum' AND recordstatus = 'ACTIVE' "; ;
						$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
						$res4 = mysql_fetch_array($exec4);
						$accountnameanum = $res4['auto_number'];
						$accname = $res4['accountname'];
						$accountexpirydate = $res4["expirydate"];
						$subtype = $res4['subtype'];
						$paymenttype = $res4["paymenttype"];

						$query11 = "select auto_number,maintype,overalllimitop,opvisitlimit,planpercentage, planfixedamount , planexpirydate,planstartdate  from master_planname where recordstatus = 'ACTIVE' and accountname='$accountnameanum'";
						$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
						$res11 = mysql_fetch_array($exec11);
						$plannameautono = $res11["auto_number"];
						$planvaliditystart = $res11['planstartdate'];
						$planexpirydate = $res11['planexpirydate'];
						$planfixedamount = $res11['planfixedamount'];
						$planpercentage = $res11['planpercentage'];
						$maintype =  $res11['maintype'];
						$visitlimit = $res11['opvisitlimit'];
						$overalllimit = $res11['overalllimitop'];
				
					?>
					<input name="searchaccountname" type="text" id="searchaccountname" size="20"  autocomplete="off" readonly="" value="<?php echo $accname; ?>" tabindex="2">
					<input name="searchsuppliernamehiddentextbox" id="searchsuppliernamehiddentextbox" value="" type="hidden">
			  		<input name="searchaccountcode" id="searchaccountcode" value="<?php echo $accountnameanum; ?>" type="hidden">
					<input type="hidden" name="isfirstvisit" id="isfirstvisit"  value="<?php if($patientcode=='' || $rowcount05!='0'){ echo 0; } else{ echo 1; } ?>"   readonly="readonly" />
					
					<input type="hidden" name="searchsubtype" id="searchsubtype" value="<?php echo $accountnameanum; ?>" >
				  	<input type="hidden" name="searchsubcode" id="searchsubcode" >
				  	<input type="hidden" name="searchsuppliername1hiddentextbox" id="searchsuppliername1hiddentextbox" >
				   	<input type="hidden" name="billtype" id="billtype" value="PAY LATER">
				  	<input type="hidden" name="plannameautono" id="plannameautono" value="<?php echo $plannameautono; ?>" >
				  	<input type="hidden" name="planvaliditystart" id="planvaliditystart" value="<?php echo $planvaliditystart; ?>" >
				  	<input type="hidden" name="accountexpirydate" id="accountexpirydate" value="<?php echo $accountexpirydate; ?>" >
					<input type="hidden" name="planpercentage" id="planpercentage" value="<?php echo $planpercentage; ?>" >
				    <input type="hidden" name="planexpirydate" id="planexpirydate" value="<?php echo $planexpirydate; ?>" >
					<input type="hidden" name="overalllimit" id="overalllimit" value="<?php echo $overalllimit; ?>" >
					<input type="hidden" name="visitlimit" id="visitlimit" value="<?php echo $visitlimit; ?>" >
					<input type="hidden" name="maintype" id="maintype" value="<?php echo $maintype; ?>" >
					<input type="hidden" name="paymenttype" id="paymenttype" value="<?php echo $paymenttype; ?>" >
					<input type="hidden" name="subtype" id="subtype" value="<?php echo $subtype; ?>" >
					
					
					<input type="hidden" name="planfixedamount" id="planfixedamount"  value="0.00">
					<input type="hidden" name="planpercentageamount" id="planpercentageamount"  value="0.00"> 
					<input type="hidden" name="departmentname" id="departmentname"  value="<?php echo $departmentname;?>">
                    <input type="hidden" name="transactionId" id="transactionId" value="<?php echo $mtransactionId; ?>">
                </td>
                <td width="20%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Available Balance
				 </td>				
				<td width="8%" align="left" valign="middle" bgcolor="#E0E0E0">
					<input type="text" name="availablelimit" id="availablelimit" value="<?php echo $mbalance;  ?>" size="14" readonly style="background-color: transparent;"> <!--  -->
					<input name="fetch" type="button" value="FETCH" style="height:20px; width:58px; background-color:#FFCC00;" onClick="return funcCheckmtibalance()"/>
				</td>				

				<td colspan="3" width="15%" rowspan="6"  align="center" valign="middle" bgcolor="#E0E0E0" class="profilepic11"><img width="150" height="150" id="patientimage" src="">

				<!-- <td colspan="3" align="center" valign="middle" id="showfirstvist" class="oldcl" bgcolor="#FFF" style="display:<?php if($patientcode=='' || $rowcount05!='0'){ echo "none"; } else{ echo ""; } ?>";>
                  <label style="color:red;font-weight:bold;"> First time visit, Please collect Registration fee </label>
                </td>--> 
				
                	<!-- <input name="searchaccountname" type="text" id="searchaccountname1" value="" autocomplete="off" onChange="clearcode('searchaccountcode')" tabindex="1"> -->
            </tr>
            <tr>
				<td width="8%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
					<span class="style2"> *First Name  </span>
				</td>
                <td width="15%" align="left" valign="middle"  bgcolor="#E0E0E0">
                	<input name="customername" id="customername" value="<?php echo $mpatientname; ?>" style="text-transform:uppercase;" size="20" onKeyPress="return namevalid(event);" tabindex="3" <?php if($isminor=="0") echo "autofocus"; ?>>
                	<input type="hidden" name="nameofrelative" id="nameofrelative" value="<?php echo $nameofrelative; ?>" size="20">
                </td>
				<td width="8%"  align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
					<span class="">  Middel Name </span >
				</td> 
				<td width="15%" align="left" valign="middle"  bgcolor="#E0E0E0" >
					<input name="customermiddlename" id="customermiddlename" value="<?php echo $customermiddlename; ?>" style=" text-transform:uppercase;" size="20" onKeyPress="return namevalid(event);" onChange="concatmiddledob();" tabindex="4">
				</td>
				<td width="8%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
					<span class="style2"> *Surname</span>
				</td>
				<td width="15%" align="left" valign="middle" bgcolor="#E0E0E0">
					<input name="customerlastname" id="customerlastname" value="<?php echo $mpatientlastname; ?>" style="text-transform:uppercase;" size="23" onKeyPress="return namevalid(event);" tabindex="5">
				</td>
				
				<!-- <br/> <input type="button" name="imgbtn" id="imgbtn" value="Show Image" onClick="return ShowImage(this.value);"><br/>-->
				</td>
			</tr>
			<tr>
			    <td width="8%" align="left" valign="middle"  bgcolor="#E0E0E0" class="style2">*Sex </td>
			    <td width="15%" align="left" valign="middle"  bgcolor="#E0E0E0" class="">
				    <select name="gender" id="gender" tabindex="6">
						<option value="">Select Sex</option>
						<option value="Male" <?php if($mgender == 'M'){ echo "selected"; } ?>>Male</option>
						<option value="Female" <?php if($mgender == 'F'){ echo "selected"; } ?>>Female</option>
				    </select> 
				</td>
				<td width="8%" align="left" valign="middle" bgcolor="#E0E0E0" class="bodytext3">
					<span class="style1">*Age</span>
				</td>
			    <td width="15%" align="left" valign="middle" bgcolor="#E0E0E0">
			    	<input name="age" type="text" maxlength="3" id="age" value="<?php echo $res2age[0]; ?>" size="7" onKeyUp="return dobcalc();" onBlur="return idhide();" onKeyPress="return validatenumerics(event);" tabindex="7" onChange="concatmiddledob();">
                    <input name="ageduration" id="ageduration" value="<?php echo $res2age[1]; ?>" size="8" readonly>
					
                </td>

				<td width="8%"  align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
					<span class="style1">*DOB </span>
				</td>
			    <td width="15%" align="left" valign="middle"  bgcolor="#E0E0E0">
				  	<input type="text" name="dateofbirth" id="dateofbirth" value="<?php echo $mdob; ?>" onChange="return GetDifference1();concatmiddledob();" style="background-color:#FFFFFF;" readonly tabindex="">
                    <strong>
                    	<span class="bodytext312"> 
                    		<img src="images2/cal.gif" onClick="javascript:NewCssCal('dateofbirth')" style="cursor:pointer"/>
                    	</span>
                    </strong>
                    <input type="hidden" name="todaydate" id="todaydate" value="<?php echo date('Y-m-d'); ?>">
                </td>
			</tr>
			<tr>
				<td width="8%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="style2"> * National Id </span> </td>
				<td width="15%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
				   	<input name="nationalidnumber" id="nationalidnumber" value="<?php echo $midNumber; ?>"  onBlur="return funcNationalIDValidation1()" style="text-transform:uppercase;" tabindex="9" <?php if($isminor=="1") echo "disabled"; ?> />		
				</td>
   			    <td width="8%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3" ><span class="style2">*Guardian </span></td>
			    <td width="15%" align="left" valign="middle"  bgcolor="#E0E0E0"   >
			    	<label>
			        	<input name="mothername" type="text" id="mothername" value="" size="20"  tabindex="10" <?php if($isminor=="1") echo "autofocus"; ?>/>
                    </label>
                </td> 
				<td width="8%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
					<span class="style2"> * Mobile No </span>
				</td>
				<td width="15%" align="left" valign="middle"  bgcolor="#E0E0E0">
				   <input name="mobilenumber" id="mobilenumber" value="<?php echo $mmobileNumber; ?>" size="23" tabindex="11"/>
				</td>
			</tr>
			<tr>	
				<td width="8%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span >  MRD No. </span > </td>
				<td width="15%" align="left" valign="middle"  bgcolor="#E0E0E0">
					<input name="mrdno" id="mrdno" size="20"  tabindex="12">
				</td>
				<td width="8%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="">  Area </span> </td>
				<td width="15%" align="left" valign="middle"  bgcolor="#E0E0E0">
					<span class="bodytext31">
				     	<input name="area" id="area" value="<?php echo $location; ?>"    size="20"  tabindex="13"/>
				    </span>
				</td>
				<td width="8%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"> Visit ID </td>
				<td align="left" valign="middle"  bgcolor="#E0E0E0">
					<input name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" readonly size="23" />
				</td>
				
				
			</tr>
			<!-- OP VISIT ENTRY FILE -->
			<?php include "opvisit_patientreg.php";?>
			
			<!-- OP VISIT ENTRY  -->
				 <input type="hidden" name="visitcount" id="visitcount"  value="<?php echo $visitcount;?>">
			<tr onClick="collapsethis('personal-hide')" style="border-bottom: #fff 1px solid;" tabindex="25" >
				<td colspan="12" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
					<strong> Personal Details  <img src="images/plus1.gif" width="13" height="13"  ></strong>
				</td>
			</tr>
			<tr class="personal-hide">
 				<td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Status </td>
			    <td align="left" valign="middle"  bgcolor="#E0E0E0">
			    	<select name="maritalstatus" id="maritalstatus" style="width: 150px;" tabindex="26" >
                        <option value="" selected="selected">Select Marital Status</option>
                      	<option value="SINGLE">SINGLE</option>
                      	<option value="MARRIED">MARRIED</option>
                    </select>
                </td>
				<td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Blood Group </td>
			    <td align="left" valign="middle"  bgcolor="#E0E0E0">
				  	<select name="bloodgroup" id="bloodgroup" style="width: 150px;" tabindex="27" >
				  		<option value="" selected="selected">Select Blood Group</option>
				  	<?php
				  		$query55 = "select * from master_bloodgroup where recordstatus = '' order by bloodgroup";
						$exec55 = mysql_query($query55) or die ("Error in Query5".mysql_error());
						while ($res55 = mysql_fetch_array($exec55))
						{
						$res5anum = $res55["auto_number"];
						$res5bloodgroup = $res55["bloodgroup"];
					?>
                      	<option value="<?php echo $res5bloodgroup; ?>"><?php echo $res5bloodgroup; ?></option>
                    <?php } ?>
				  	</select>
				</td>
			    <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Address 1 </td>
			    <td width="16%" align="left" valign="middle"  bgcolor="#E0E0E0">
			    	<input name="address1" id="address1" value="<?php echo $address1; ?>" size="20" tabindex="28" />
			    </td>
				<td width="7%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Address 2 </td>
                <td width="33%" align="left" valign="middle"  bgcolor="#E0E0E0">
                	<input name="address2" id="address2" value="<?php echo $address2; ?>" size="20" tabindex="29"  />
                </td>
			</tr>
			   
			<tr  class="personal-hide">
				<td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Occupation</td>
			    <td align="left" valign="middle"  bgcolor="#E0E0E0">
			    	<input name="occupation" id="occupation" value="<?php echo $occupation; ?>" size="20" tabindex="30" />
			    </td>
			    <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">City </td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
					<input name="city" id="city" value="<?php echo $city; ?>" size="20" tabindex="31" />
				</td>
				<td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
					<span class="bodytext31"> <span class="bodytext32">State </span> </span>
				</td>
                <td align="left" valign="middle"  bgcolor="#E0E0E0">
					<input type="text" name="state" id="state" tabindex="32">
				    <input name="addpatientcountyhiddentextbox" id="addpatientcountyhiddentextbox" value="" type="hidden">
			  		<input name="searchcountycode" id="searchcountycode" value="" type="hidden">
			  	</td>
			    <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Post Box </td>
				<td align="left" valign="middle"  bgcolor="#E0E0E0">
					<input name="pincode" id="pincode" value="<?php echo $pincode; ?>" size="20" tabindex="33"/>
				</td>
            </tr>
            <tr class="personal-hide">
				<td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Citizenship</td>
				<td align="left" valign="middle"  bgcolor="#E0E0E0">
				    <select name="country" id="country"  style="width: 150px;" tabindex="34">
		              	<option value="">-Select Citizenship-</option>
		                <option value="NATIONAL" selected>National</option>
		                <option value="INTERNATIONAL">Inter National</option>
		            </select>
             	</td>
			</tr>
			
			<tr onClick="collapsethis('contact-hide')"  style="border-bottom: #fff 1px solid;" tabindex="35">
				<td colspan="12" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
					<strong> Contact Details <img src="images/plus1.gif" width="13" height="13"  ></strong>
				</td>
			</tr>
			<tr class="contact-hide">
			    <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Email Id 1 </td>
			    <td align="left" valign="middle"  bgcolor="#E0E0E0">
			   		<input name="emailid1" id="emailid1" value="<?php echo $emailid1; ?>" size="20" tabindex="36">
			        <input type="hidden" name="tinnumber" id="tinnumber" value="<?php echo $tinnumber; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="20" />
			    </td>
				<td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Next Of Kin </td>
				<td align="left" valign="middle"  bgcolor="#E0E0E0">
					<input name="kinname" id="kinname" value="<?php echo $kinname; ?>" size="20" tabindex="37" />
				</td>
			</tr>
		
			<tr class="contact-hide">
                <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"  hidden="true">Promotion </td>
			    <td align="left" valign="middle"  bgcolor="#E0E0E0" hidden="true">
			    	<select name="promotion" style="width: 150px;" hidden="true" tabindex="38">
                      	<option value="" selected="selected">Select Promotion</option>
                      	<option value="YES">YES</option>
                      	<option value="NO">NO</option>
                    </select>                  </td>
				<td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Additional No  </td>
				<td align="left" valign="middle"  bgcolor="#E0E0E0">
				   	<input name="phonenumber1" id="phonenumber1" value="<?php echo $phonenumber1; ?>"   size="20" tabindex="39"/>
				   	<input type="hidden" name="phonenumber2" id="phonenumber2" value="<?php echo $phonenumber2; ?>"    size="20">
				</td>
				<td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Email Id 2 </td>
				<td align="left" valign="middle"  bgcolor="#E0E0E0">
					<input name="emailid2" id="emailid2" value="<?php echo $emailid2; ?>" size="20" tabindex="40">
			        <input type="hidden" name="cstnumber" id="cstnumber" value="<?php echo $cstnumber; ?>" style="text-transform: uppercase;"  size="20" />
			    </td>
				<td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
					<span class="style">Next Of Kin</span>  Tel# 
				</td>
				<td align="left" valign="middle"  bgcolor="#E0E0E0">
					<input name="kincontactnumber" id="kincontactnumber" value="<?php echo $kincontactnumber; ?>" size="20" tabindex="41"/>
				</td>
			</tr>
			<tr >
				<td onClick="collapsethis1('misc-hide')" colspan="12" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3" >
					<span class="bodytext32"><strong>Misc  Details </strong></span>
				</td>
			</tr>
			<tr class="misc-hide">
				<td width="6%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Reg  Code </td>
				<td width="13%" align="left" valign="middle"  bgcolor="#E0E0E0">
					<strong>
						<span class="bodytext312">
                    		 <input name="customercode" id="customercode" value="<?php echo $customercode;?>" style="background-color:#FFFFFF;" size="16" readonly >
							 <input class="clcode1" name="customercode1" id="customercode1" style="background-color:#FFFFFF;" size="16" readonly >
                  		</span>
                  	</strong>
                </td>
				<td width="6%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Reg Date </td>
				<td width="13%" align="left" valign="middle"  bgcolor="#E0E0E0">
					<input type="text" name="registrationdate" id="registrationdate" value="<?php echo $registrationdate; ?>" readonly   style="background-color:#FFFFFF;" size="16">
                    <strong>
                    	<span class="bodytext312"> <img src="images2/cal.gif" style="cursor:pointer"/> 
                    	</span>
                    </strong>
                </td>
				<td width="6%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"> Reg Time </td>
				<td width="13%" align="left" valign="middle"  bgcolor="#E0E0E0">
					<input type="text" name="registrationtime" id="registrationtime" value="<?php echo $registrationtime; ?>"  style="background-color:#FFFFFF;">
			    	<input type="hidden" name="openingbalance" id="openingbalance" value="<?php echo $openingbalance; ?>" style="border: 1px solid #001E6A;" size="20">
			    </td>
					
				<td width="6%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Photo </td>
				<td width="13%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
                    <!--<input type="hidden" name="MAX_FILE_SIZE" value="100000">-->
                    <input type="file" name="uploadedfile" value="" tabindex="42" onChange="readURL(this);" />
                   <strong>Only JPG or JPEG Files. </strong> 
				</td>
			
			</tr>
			
			<tr>
                <td colspan="5" align="middle"  bgcolor="#E0E0E0">
                	<div align="right">
                		<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
                			<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
                				<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
                					<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
                						<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  							<input type="hidden" name="frmflag1" value="frmflag1" />
                  							<input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
				<?php 
				  $query1 = "select auto_number from master_employeerights where username = '$username' and submenuid = 'SM003'";
				  $exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
				  $rowcount1 = mysql_num_rows($exec1);
				  if ($rowcount1 != 0)
				  {
				  ?><?php
				  }
				  ?>
				  <?php 
				  $query1 = "select auto_number from master_employee where username = '$username' ";
				  $exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
				  $rowcount1 = mysql_num_rows($exec1);
				  if ($rowcount1 != 0)
				  {
				  ?>
                  <br>
<!-- 				  <input name="Submit222" type="submit"  id="submit1" value="Save & Go OP Visit (Alt+O)" accesskey="o" class="button"  tabindex="11" style="font-size:large"/>
					&nbsp;&nbsp;&nbsp;&nbsp;
 -->                  <?php
				  }
				  ?>
				  <?php 
				  $query1 = "select * from master_employee where username = '$username' ";
				  $exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
				  $rowcount1 = mysql_num_rows($exec1);
				  if ($rowcount1 != 0)
				  {
				  ?>
					<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
					  	<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
					  		<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
<!-- 					  			<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
					  				<input name="Submit222" type="submit" id="submit2" value="Save & Go IP Visit (Alt+I)" accesskey="i" class="button" tabindex="12" style="font-size:large"/>
									&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;  
					  			</font>
 -->					  		</font>
					  	</font>
					</font>
				  <?php
				  }
				  ?> 
				<font color="#000000" style="margin-left:2px" size="1" face="Verdana, Arial, Helvetica, sans-serif">
				  	<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
				  		<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
				  			<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                   				<!-- <input name="Submit222" type="submit" id="submit" value="Save  (Alt+S)" accesskey="s"  class="button"  style="font-size:large" /> -->
                   				<input name="Submit222" type="submit" 
                   				<?php
                   					if($this_visit=='1'){
                  						echo 'value="Create Visit"';		
                   					}else{
                   						echo 'value="Save Registration & Create Visit (Alt+S)"';		
                   					}
                   				?>

                   				  accesskey="s" class="button" id="submit" onClick="return expirydatewarning()" tabindex="43"/>
                   					<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                   						<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                   							<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">	<font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                   									<input name="Submit2223" type="hidden"  value="Reset (Alt+R)"  class="button"/>
                   								</font>
                   							</font>
                   						</font>
                   					</font>
                   			</font>
                   		</font>
                   	</font>
                </font>               
		               					</font>
		               				</font>
		               			</font>
		               		</font>
		               	</font>
		            </div>
		        </td>
            </tr>
            </tbody>
            </table>
            </td>
        </tr>
        <tr>
          	<td>&nbsp;</td>
        </tr>
    </table>
	</form>
	</td>
	</tr>
</table>


<script>


$(document).ready(function(e) {
//    $("#searchpaymenttype11").trigger('click');
	//$("#customername").focus();
	funcVistLimit();

<?php 
 if($m_registrationtype==1){?>
	$(".hideoncash").hide(); 
<?php }
 ?>

});
</script>


<?php //include ("includes/footer1.php"); ?>
</body>
</html>
