<?php
session_start();
error_reporting(0);
set_time_limit(0);
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

$titlestr = 'SALES BILL';
if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{ //exit(); 
    $visitcode=$_REQUEST["visitcode"];
	$patientcode = $_REQUEST["customercode"];
	$patientname = $_REQUEST["customername"];
	$consultationdate = date("Y-m-d");
	$accountname = $_REQUEST["account"];
	$billtype = $_REQUEST['billtype'];
	$patientage = $_REQUEST['patientage'];
	$patientgender = $_REQUEST['patientgender'];
	$dispensingfee = $_REQUEST['dispensingfee'];
	$locationname = $_REQUEST['locationname'];
	$locationcode = $_REQUEST['locationcode'];
	$approvecomment = isset($_REQUEST['approvecomment'])?$_REQUEST['approvecomment']:'';
	$override = isset($_REQUEST['approve'])?$_REQUEST['approve']:'';
	$schemecode = isset($_REQUEST['approvecomment'])?$_REQUEST['approvecomment']:'';
	$approvallimit = isset($_REQUEST['approvallimit'])?$_REQUEST['approvallimit']:'';
	$availablelimit = isset($_REQUEST['availablelimit'])?$_REQUEST['availablelimit']:'';
	
	$counter='';
	
/*	$queryapprove = "INSERT INTO completed_billingpaylater(override,comments,schemecode,netbillamount, availablelimit) VALUES($override, $schemecode, $approvallimit, $availablelimit)";
	$execapprove = mysql_query($queryapprove) or die ("Error in Queryapprove".mysql_error());
*/	
	 $query221 = "select * from master_consultation where patientcode='$patientcode' and patientvisitcode='$visitcode' ";
	 $exec221 = mysql_query($query221) or die ("Error in Query221".mysql_error());
	 $rowcount221 = mysql_num_rows($exec221);
	 $res221=mysql_fetch_array($exec221);
	 $patientauto_number=$res221['patientauto_number'];
	 $patientvisitauto_number=$res221['patientvisitauto_number'];
	 $consultationid=$res221['consultation_id'];
	
	
	mysql_query("update master_consultation set approvalstatus='completed', approval='0' where patientcode='$patientcode' and patientvisitcode='$visitcode' ");
	
	if($billtype =='PAY NOW')
	{
	$status='pending';
	}
	else
	{
	$status='completed';
	}
	
	$query2 = "select * from master_consultationpharm where patientcode='$patientcode' and patientvisitcode='$visitcode' order by auto_number desc limit 0, 1";
	$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	$res2 = mysql_fetch_array($exec2);
	$medrefnonumber = $res2["refno"];

	foreach($_POST['aitemcode'] as $key => $value)
	{
	$aitemcode = $_POST['aitemcode'][$key];
	$adays = $_POST['adays'][$key];
	$adose = $_POST['adose'][$key];
	$aquantity = $_POST['aquantity'][$key];
	$aroute = $_POST['aroute'][$key];
	$ainstructions = $_POST['ainstructions'][$key];
	$aamount =  $_POST['aamount'][$key];
	$afrequency = $_POST['afrequency'][$key];
	
	$sele=mysql_query("select * from master_frequency where frequencycode='$afrequency'") or die(mysql_error());
	$ress=mysql_fetch_array($sele);
	$frequencyautonumber=$ress['auto_number'];
	$frequencycode=$ress['frequencycode'];
	
	$query34 = "update master_consultationpharm set days='$adays',dose='$adose',quantity='$aquantity',route='$aroute',instructions='$ainstructions',amount='$aamount',frequencyauto_number='$frequencyautonumber',frequencycode='$frequencycode',frequencynumber='$afrequency' where patientcode='$patientcode' and patientvisitcode='$visitcode' and medicinecode='$aitemcode'";
	$exec34 = mysql_query($query34) or die(mysql_error()); 
	
	$query35 = "update master_consultationpharmissue set days='$adays',dose='$adose',prescribed_quantity='$aquantity',quantity='$aquantity',route='$aroute',instructions='$ainstructions',amount='$aamount',frequencyauto_number='$frequencyautonumber',frequencycode='$frequencycode',frequencynumber='$afrequency' where patientcode='$patientcode' and patientvisitcode='$visitcode' and medicinecode='$aitemcode'";
	$exec35 = mysql_query($query35) or die(mysql_error()); 
	
	}

	
	/*for ($p=1;$p<=20;$p++)
	{*/
	foreach($_POST['medicinename'] as $key => $value)
	{	
	
	 $key;
		
		
		$medicinename = $_REQUEST['medicinename'][$key];
		$query77="select * from master_medicine where itemname='$medicinename'";
		$exec77=mysql_query($query77);
		$res77=mysql_fetch_array($exec77);
		$medicinecode=$res77['itemcode'];
		$dose = $_REQUEST['dose'][$key];
		$frequency = $_REQUEST['frequency'][$key];
		$sele=mysql_query("select * from master_frequency where frequencycode='$frequency'") or die(mysql_error());
		$ress=mysql_fetch_array($sele);
		$frequencyautonumber=$ress['auto_number'];
		$frequencycode=$ress['frequencycode'];
		$frequencynumber=$ress['frequencynumber'];
		$days = $_REQUEST['days'][$key];
		$quantity = $_REQUEST['quantity'][$key];
		$route = $_REQUEST['route'][$key];
		$instructions = $_REQUEST['instructions'][$key];
		$rate = $_REQUEST['rates'][$key];
		$amount = $_REQUEST['amount'][$key];
		$exclude = $_REQUEST['exclude'][$key];
		
		
		
		$serquery=mysql_query("select * from master_consultationpharm where  patientcode='$patientcode' and patientvisitcode='$visitcode'");
		$execser=mysql_fetch_array($serquery);
		$consultationtime=$execser['consultationtime'];
		$refno=$execser['refno'];
		$consultingdoctor=$execser['consultingdoctor'];
		
		$pharamapprovalstatus = isset($_REQUEST['pharamcheck'][$key]);
		$pharamapprovalstatus1 = isset($_REQUEST['pharamlatertonow'][$key]);
		 
		if ($medicinename != "")
		{
		
		 if($pharamapprovalstatus=='1')
		{
			$status='completed';
			$approvalstatus=1;
			
		 $query2 = "insert into master_consultationpharm(consultation_id,patientcode,patientauto_number,patientname,patientvisitauto_number,patientvisitcode,medicinename,dose,frequencyauto_number,frequencycode,frequencynumber,days,quantity,instructions,rate,amount,recordstatus,recorddate,ipaddress,consultingdoctor,billtype,accountname,paymentstatus,medicinecode,refno,pharmacybill,medicineissue,source,route,approvalstatus,excludestatus,locationname, locationcode) 
			values('$consultationid','$patientcode','$patientauto_number','$patientname','$patientvisitauto_number','$visitcode','$medicinename','$dose','$frequencyautonumber','$frequencycode','$frequencynumber','$days','$quantity','$instructions','$rate','$amount','completed','$consultationdate','$ipaddress','$consultingdoctor','$billtype','$accountname','pending','$medicinecode','$medrefnonumber','$status','pending','doctorconsultation','$route','$approvalstatus','$exclude','$locationname', '$locationcode')";   
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			
			$query29 = "insert into master_consultationpharmissue(consultation_id,patientcode,patientauto_number,patientname,patientvisitauto_number,patientvisitcode,medicinename,dose,frequencyauto_number,frequencycode,frequencynumber,days,quantity,instructions,rate,amount,recordstatus,recorddate,ipaddress,consultingdoctor,billtype,accountname,paymentstatus,medicinecode,refno,prescribed_quantity,source,route,approvalstatus,excludestatus,locationname, locationcode) 
			values('$consultationid','$patientcode','$patientauto_number','$patientname','$patientvisitauto_number','$visitcode','$medicinename','$dose','$frequencyautonumber','$frequencycode','$frequencynumber','$days','$quantity','$instructions','$rate','$amount','completed','$consultationdate','$ipaddress','$consultingdoctor','$billtype','$accountname','$status','$medicinecode','$medrefnonumber','$quantity','doctorconsultation','$route','$approvalstatus','$exclude','$locationname', '$locationcode')";
			$exec29 = mysql_query($query29) or die ("Error in Query29".mysql_error());
		$counter=$counter + 1;
			
		}
		else if($pharamapprovalstatus1=='1')
		{ 
			$status='pending';
			$approvalstatus=2;
		
		//if ($medicinename != "" && $dose != "" && $frequency != "" && $days != "" && $quantity != "" && $instructions != "" && $rate != "" && $amount != "")
		
			//echo '<br>'. 
			$query2 = "insert into master_consultationpharm(consultation_id,patientcode,patientauto_number,patientname,patientvisitauto_number,patientvisitcode,medicinename,dose,frequencyauto_number,frequencycode,frequencynumber,days,quantity,instructions,rate,amount,recordstatus,recorddate,ipaddress,consultingdoctor,billtype,accountname,paymentstatus,medicinecode,refno,pharmacybill,medicineissue,source,route,approvalstatus,excludestatus,locationname, locationcode) 
			values('$consultationid','$patientcode','$patientauto_number','$patientname','$patientvisitauto_number','$visitcode','$medicinename','$dose','$frequencyautonumber','$frequencycode','$frequencynumber','$days','$quantity','$instructions','$rate','$amount','completed','$consultationdate','$ipaddress','$consultingdoctor','$billtype','$accountname','pending','$medicinecode','$medrefnonumber','$status','pending','doctorconsultation','$route','$approvalstatus','$exclude','$locationname', '$locationcode')";   
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			
			$query29 = "insert into master_consultationpharmissue(consultation_id,patientcode,patientauto_number,patientname,patientvisitauto_number,patientvisitcode,medicinename,dose,frequencyauto_number,frequencycode,frequencynumber,days,quantity,instructions,rate,amount,recordstatus,recorddate,ipaddress,consultingdoctor,billtype,accountname,paymentstatus,medicinecode,refno,prescribed_quantity,source,route,approvalstatus,excludestatus,locationname, locationcode) 
			values('$consultationid','$patientcode','$patientauto_number','$patientname','$patientvisitauto_number','$visitcode','$medicinename','$dose','$frequencyautonumber','$frequencycode','$frequencynumber','$days','$quantity','$instructions','$rate','$amount','completed','$consultationdate','$ipaddress','$consultingdoctor','$billtype','$accountname','$status','$medicinecode','$medrefnonumber','$quantity','doctorconsultation','$route','$approvalstatus','$exclude','$locationname', '$locationcode')";
		$exec29 = mysql_query($query29) or die ("Error in Query29".mysql_error());
		$counter=$counter + 1;
		}
		} 
	} 
	for($i=1;$i<20;$i++)
	{		
	
	    $pharamapprovalstatus = isset($_POST['pharamcheck'][$i])?'1':'0';
		$pharamapprovalstatus = isset($_POST['pharamlatertonow'][$i])?'2':$pharamapprovalstatus; 
		$pharamcheck=trim($_POST['pharamanum'][$i]);  
		
		if($pharamcheck!='' && $pharamapprovalstatus=='0')
		{ //echo "update master_consultationpharmissue set approvalstatus='$pharamapprovalstatus',paymentstatus='pending'  where medicinecode='$pharamcheck' and patientvisitcode='$visitcode'";
			mysql_query("update master_consultationpharmissue set approvalstatus='$pharamapprovalstatus',paymentstatus='pending'  where medicinecode='$pharamcheck' and patientvisitcode='$visitcode'");
			mysql_query("update master_consultationpharm set approvalstatus='$pharamapprovalstatus', paymentstatus='pending', pharmacybill='pending'  where medicinecode='$pharamcheck' and patientvisitcode='$visitcode'");
			$counter=$counter + 1;
		}
		
	else if($pharamcheck!='' && $pharamapprovalstatus=='1')
		{ 
			mysql_query("update master_consultationpharmissue set approvalstatus='$pharamapprovalstatus',paymentstatus='completed'  where medicinecode='$pharamcheck' and patientvisitcode='$visitcode'");
			mysql_query("update master_consultationpharm set approvalstatus='$pharamapprovalstatus', paymentstatus='completed',pharmacybill='$status'  where medicinecode='$pharamcheck' and patientvisitcode='$visitcode'");
			$counter=$counter + 1;
		}
		else if($pharamcheck!='' && $pharamapprovalstatus=='2')
		{ //echo "update master_consultationpharmissue set approvalstatus='$pharamapprovalstatus',paymentstatus='pending'  where medicinecode='$pharamcheck' and patientvisitcode='$visitcode'";
			mysql_query("update master_consultationpharmissue set approvalstatus='$pharamapprovalstatus',paymentstatus='pending'  where medicinecode='$pharamcheck' and patientvisitcode='$visitcode'");
			mysql_query("update master_consultationpharm set approvalstatus='$pharamapprovalstatus',pharmacybill='pending'  where medicinecode='$pharamcheck' and patientvisitcode='$visitcode'");
			$counter=$counter + 1;
		}
	}  
	foreach($_POST['labanum'] as $key => $value)
	{
	
					 $key;
		$labname=$_POST['lab'][$key];
		$labquery=mysql_query("select * from master_lab where itemname='$labname'");
		$execlab=mysql_fetch_array($labquery);
		$labcode=$execlab['itemcode'];
		$labrate=$_POST['rate5'][$key];
		
		$labchecknow = isset($_POST['labcheck'][$key]);
		$lablater = isset($_POST['lablatertonow'][$key]);
		//if($labapprovalstatus1==1){echo $labapprovalstatus1=2;} 
		
		
		$serquery=mysql_query("select * from consultation_lab where  patientcode='$patientcode' and patientvisitcode='$visitcode'");
		$execser=mysql_fetch_array($serquery);
		$consultationtime=$execser['consultationtime'];
		$refno=$execser['refno'];
		 
		
		if(($labname!='')&&($labrate!=''))
		{
		
		
		 if($labchecknow==1)
		{
			$status='completed';
			$approvalstatus=1;
			
		
				  
		$labquery1=mysql_query("insert into consultation_lab(consultationid,patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,billtype,accountname,consultationdate,paymentstatus,labsamplecoll,resultentry,labrefund,approvalstatus,locationname, locationcode,username,refno,consultationtime)values('$consultationid','$patientcode','$patientname','$visitcode','$labcode','$labname','$labrate','$billtype','$accountname','$consultationdate','$status','pending','pending','norefund','$approvalstatus', '$locationname', '$locationcode','$username','$refno','$consultationtime')") or die(mysql_error());
		$counter=$counter + 1;
			
		}
		else if($lablater=='1')
		{ 
			$status='pending';
			$approvalstatus=2;
		
		$labquery1=mysql_query("insert into consultation_lab(consultationid,patientcode,patientname,patientvisitcode,labitemcode,labitemname,labitemrate,billtype,accountname,consultationdate,paymentstatus,labsamplecoll,resultentry,labrefund,approvalstatus,locationname, locationcode,username,refno,consultationtime)values('$consultationid','$patientcode','$patientname','$visitcode','$labcode','$labname','$labrate','$billtype','$accountname','$consultationdate','$status','pending','pending','norefund','$approvalstatus', '$locationname', '$locationcode','$username','$refno', '$consultationtime')") or die(mysql_error());
		$counter=$counter + 1;
		}
		}
	}   
	for($i=0;$i<20;$i++)
	{		
		$labapprovalstatus = isset($_POST['labcheck'][$i])?'1':'0';
		$labapprovalstatus = isset($_POST['lablatertonow'][$i])?'2':$labapprovalstatus;
		$labcheck=$_POST['labanum'][$i];
		if($labcheck!='' && $labapprovalstatus=='0')
		{ 
			mysql_query("update consultation_lab set approvalstatus='$labapprovalstatus',paymentstatus='pending'  where auto_number='$labcheck' and patientvisitcode='$visitcode'");		
			$counter=$counter + 1;
		}
		if($labcheck!='' && $labapprovalstatus=='1')
		{ 
			mysql_query("update consultation_lab set approvalstatus='$labapprovalstatus',paymentstatus='$status'  where auto_number='$labcheck' and patientvisitcode='$visitcode'");		
			$counter=$counter + 1;
		}
		
		else if($labcheck!='' && $labapprovalstatus=='2')
		{   
			mysql_query("update consultation_lab set approvalstatus='$labapprovalstatus',paymentstatus='pending' where auto_number='$labcheck' and patientvisitcode='$visitcode'");		
			$counter=$counter + 1;
		}
	} 
	foreach($_POST['radiology'] as $key=>$value)
	{	
			//echo '<br>'.
		$pairs= $_POST['radiology'][$key];
		$pairvar= $pairs;
	    $pairs1= $_POST['rate8'][$key];
		$pairvar1= $pairs1;
		
		$radiologyquery=mysql_query("select * from master_radiology where itemname='$pairvar'");
		$execradiology=mysql_fetch_array($radiologyquery);
		$radiologycode=$execradiology['itemcode'];
		
		$serquery=mysql_query("select * from consultation_radiology where  patientcode='$patientcode' and patientvisitcode='$visitcode'");
		$execser=mysql_fetch_array($serquery);
		$consultationtime=$execser['consultationtime'];
		$refno=$execser['refno'];
		
		$radapprovalstatus = isset($_POST['radcheck'][$key]);
		$radapprovalstatus1 = isset($_POST['radlatertonow'][$key]);
		
		
		if(($pairvar!="")&&($pairvar1!=""))
		{
		 if( $radapprovalstatus=='1')
		{ 
			$status='completed';
			$approvalstatus=1;
			
			$radiologyquery1="insert into consultation_radiology(consultationid,patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,billtype,accountname,consultationdate,paymentstatus,resultentry,approvalstatus,locationname, locationcode,username,refno,consultationtime)values('$consultationid','$patientcode','$patientname','$visitcode','$radiologycode','$pairvar','$pairvar1','$billtype','$accountname','$consultationdate','$status','pending','$approvalstatus','$locationname', '$locationcode','$username','$refno', '$consultationtime')";
		$radiologyexecquery1=mysql_query($radiologyquery1) or die(mysql_error());
		$radiologyquery2=mysql_query("update master_visitentry set radiologybill='pending' where visitcode='$visitcode'");
		$counter=$counter + 1;
		}
		else if( $radapprovalstatus1=='1')
		{
			$status='pending';
			$approvalstatus=2;
		
		
		$radiologyquery1="insert into consultation_radiology(consultationid,patientcode,patientname,patientvisitcode,radiologyitemcode,radiologyitemname,radiologyitemrate,billtype,accountname,consultationdate,paymentstatus,resultentry,approvalstatus,locationname, locationcode,username,refno,consultationtime)values('$consultationid','$patientcode','$patientname','$visitcode','$radiologycode','$pairvar','$pairvar1','$billtype','$accountname','$consultationdate','$status','pending','$approvalstatus','$locationname', '$locationcode','$username','$refno', '$consultationtime' )";
		$radiologyexecquery1=mysql_query($radiologyquery1) or die(mysql_error());
		$radiologyquery2=mysql_query("update master_visitentry set radiologybill='pending' where visitcode='$visitcode'");
		$counter=$counter + 1;
		}
		}
	}
	for($i=0;$i<20;$i++)
	{		
		$radapprovalstatus = isset($_POST['radcheck'][$i])?'1':'0';
		$radapprovalstatus = isset($_POST['radlatertonow'][$i])?'2':$radapprovalstatus;
		$radcheck=$_POST['radanum'][$i];
		if($radcheck!='' && $radapprovalstatus=='0')
		{ 
			mysql_query("update consultation_radiology set approvalstatus='$radapprovalstatus',paymentstatus='pending'  where auto_number='$radcheck' and patientvisitcode='$visitcode'");
			$counter=$counter + 1;
		}
		
		else if($radcheck!='' && $radapprovalstatus=='1')
		{ 
			mysql_query("update consultation_radiology set approvalstatus='$radapprovalstatus',paymentstatus='$status'  where auto_number='$radcheck' and patientvisitcode='$visitcode'");
			$counter=$counter + 1;
		}
		else if($radcheck!='' && $radapprovalstatus=='2')
		{  
			mysql_query("update consultation_radiology set approvalstatus='$radapprovalstatus',paymentstatus='pending'  where auto_number='$radcheck' and patientvisitcode='$visitcode'");
			$counter=$counter + 1;
		}
	} 
	foreach($_POST['services'] as $key => $value)
	{
				    //echo '<br>'.$k;
		$servicesname=$_POST["services"][$key];
		$servicequery=mysql_query("select * from master_services where itemname='$servicesname'");
		$execservice=mysql_fetch_array($servicequery);
		$servicescode=$execservice['itemcode'];
		
		$serquery=mysql_query("select * from consultation_services where  patientcode='$patientcode' and patientvisitcode='$visitcode'");
		$execser=mysql_fetch_array($serquery);
		$consultationtime=$execser['consultationtime'];
		$refno=$execser['refno'];
		
		$servicesrate=$_POST["rate3"][$key];
		$serviceqty=$_POST['serviceqty'][$key];
		$seramount=$serviceqty*$servicesrate;
		
		$serapprovalstatus = isset($_POST['sercheck'][$key]);
		$serapprovalstatus1 = isset($_POST['serlatertonow'][$key]);
		$sercheck=$_POST['seranum'][$i];
		
		/*for($se=1;$se<=$serviceqty;$se++)
		{
		*/
		if(($servicesname!="")&&($servicesrate!=''))
		{
		
		 if( $serapprovalstatus=='1')
		{
			$status='completed';
			$approvalstatus=1;
			
			$servicesquery1=mysql_query("insert into consultation_services(consultationid,patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,billtype,accountname,consultationdate,paymentstatus,process,approvalstatus,locationname, locationcode, serviceqty,amount,username,refno,consultationtime)values('$consultationid','$patientcode','$patientname','$visitcode','$servicescode','$servicesname','$servicesrate','$billtype','$accountname','$consultationdate','$status','pending','$approvalstatus', '$locationname', '$locationcode','$serviceqty','$seramount','$username','$refno', '$consultationtime')") or die(mysql_error());
		$servicesquery2=mysql_query("update master_visitentry set servicebill='pending' where visitcode='$visitcode'") or die(mysql_error());
			$counter=$counter + 1;
			
		}
		else if( $serapprovalstatus1=='1')
		{
			$status='pending';
			$approvalstatus=2;
		
		
			$servicesquery1=mysql_query("insert into consultation_services(consultationid,patientcode,patientname,patientvisitcode,servicesitemcode,servicesitemname,servicesitemrate,billtype,accountname,consultationdate,paymentstatus,process,approvalstatus,locationname, locationcode,serviceqty,amount,username,refno,consultationtime)values('$consultationid','$patientcode','$patientname','$visitcode','$servicescode','$servicesname','$servicesrate','$billtype','$accountname','$consultationdate','$status','pending','$approvalstatus', '$locationname', '$locationcode','$serviceqty','$seramount','$username','$refno', '$consultationtime')") or die(mysql_error());
		$servicesquery2=mysql_query("update master_visitentry set servicebill='pending' where visitcode='$visitcode'") or die(mysql_error());
			$counter=$counter + 1;
		}
		}
		//}
	}
	for($i=0;$i<20;$i++)
	{
		$serapprovalstatus = isset($_POST['sercheck'][$i])?'1':'0';
		$serapprovalstatus = isset($_POST['serlatertonow'][$i])?'2':$serapprovalstatus;
		$sercheck=$_POST['seranum'][$i];
		if($sercheck!='' && $serapprovalstatus=='0')
		{
			mysql_query("update consultation_services set approvalstatus='$serapprovalstatus',paymentstatus='pending'  where auto_number='$sercheck' and patientvisitcode='$visitcode'");		
			$counter=$counter + 1;
		}
		
		else if($sercheck!='' && $serapprovalstatus=='1')
		{
			mysql_query("update consultation_services set approvalstatus='$serapprovalstatus',paymentstatus='$status'  where auto_number='$sercheck' and patientvisitcode='$visitcode'");		
			$counter=$counter + 1;
		}
		else if($sercheck!='' && $serapprovalstatus=='2')
		{
			mysql_query("update consultation_services set approvalstatus='$serapprovalstatus',paymentstatus='pending'  where auto_number='$sercheck' and patientvisitcode='$visitcode'");		
			$counter=$counter + 1;
		}
	}
	
	//this is for referal
	foreach($_POST['ref'] as $key=>$value)
	{	
			//echo '<br>'.
		$pairs= $_POST['ref'][$key];
		$pairvar= $pairs;
	    $pairs1= $_POST['rate4'][$key];
		$pairvar1= $pairs1;
		
		$refcode= $_POST['refcode'][$key];
		
	//	$radiologyquery=mysql_query("select * from master_radiology where itemname='$pairvar'");
	//	$execradiology=mysql_fetch_array($radiologyquery);
	//	$radiologycode=$execradiology['itemcode'];
		
		$serquery=mysql_query("select * from consultation_referal where  patientcode='$patientcode' and patientvisitcode='$visitcode'");
		$execser=mysql_fetch_array($serquery);
		$consultationtime=$execser['consultationtime'];
		$refno=$execser['refno'];
		
		$refapprovalstatus = isset($_POST['refcheck'][$key]);
		$refapprovalstatus1 = isset($_POST['reflatertonow'][$key]);
		
		
		if(($pairvar!="")&&($pairvar1!=""))
		{
		 if( $refapprovalstatus=='1')
		{ 
			$status='completed';
			$approvalstatus=1;
			
			$radiologyquery1="insert into consultation_referal(consultationid,patientcode,patientname,patientvisitcode,referalcode,referalname,referalrate,billtype,accountname,consultationdate,paymentstatus,approvalstatus,locationname, locationcode,username,refno,consultationtime)values('$consultationid','$patientcode','$patientname','$visitcode','$refcode','$pairvar','$pairvar1','$billtype','$accountname','$consultationdate','$status','$approvalstatus','$locationname', '$locationcode','$username','$refno', '$consultationtime')";
		$radiologyexecquery1=mysql_query($radiologyquery1) or die(mysql_error());
		$radiologyquery2=mysql_query("update master_visitentry set radiologybill='pending' where visitcode='$visitcode'");
		$counter=$counter + 1;
		}
		else if( $refapprovalstatus1=='1')
		{
			$status='pending';
			$approvalstatus=2;
		
		
		$radiologyquery1="insert into consultation_referal(consultationid,patientcode,patientname,patientvisitcode,referalcode,referalname,referalrate,billtype,accountname,consultationdate,paymentstatus,approvalstatus,locationname, locationcode,username,refno,consultationtime)values('$consultationid','$patientcode','$patientname','$visitcode','$refcode','$pairvar','$pairvar1','$billtype','$accountname','$consultationdate','$status','$approvalstatus','$locationname', '$locationcode','$username','$refno', '$consultationtime')";
		$radiologyexecquery1=mysql_query($radiologyquery1) or die(mysql_error());
		$radiologyquery2=mysql_query("update master_visitentry set radiologybill='pending' where visitcode='$visitcode'");
		$counter=$counter + 1;
		}
		}
	}
	for($i=0;$i<20;$i++)
	{		
		$refapprovalstatus = isset($_POST['refcheck'][$i])?'1':'0';
		$refapprovalstatus = isset($_POST['reflatertonow'][$i])?'2':$refapprovalstatus;
		$refcheck=$_POST['refanum'][$i];
		if($refcheck!='' && $refapprovalstatus=='0')
		{ 
			mysql_query("update consultation_referal set approvalstatus='$refapprovalstatus',paymentstatus='pending'  where auto_number='$refcheck' and patientvisitcode='$visitcode'");
			$counter=$counter + 1;
		}
		
		else if($refcheck!='' && $refapprovalstatus=='1')
		{ 
			mysql_query("update consultation_referal set approvalstatus='$refapprovalstatus',paymentstatus='$status'  where auto_number='$refcheck' and patientvisitcode='$visitcode'");
			$counter=$counter + 1;
		}
		else if($refcheck!='' && $refapprovalstatus=='2')
		{  
			mysql_query("update consultation_referal set approvalstatus='$refapprovalstatus',paymentstatus='pending'  where auto_number='$refcheck' and patientvisitcode='$visitcode'");
			$counter=$counter + 1;
		}
	} 
	
	//this is for dep ref
	for($i=0;$i<20;$i++)
	{		
		$deprefapprovalstatus = isset($_POST['deprefcheck'][$i])?'1':'0';
		$deprefapprovalstatus = isset($_POST['depreflatertonow'][$i])?'2':$deprefapprovalstatus;
		$deprefcheck=$_POST['deprefanum'][$i];
		if($deprefcheck!='' && $deprefapprovalstatus=='0')
		{ 
			mysql_query("update consultation_departmentreferal set approvalstatus='$deprefapprovalstatus',paymentstatus='pending'  where auto_number='$deprefcheck' and patientvisitcode='$visitcode'");
			$counter=$counter + 1;
		}
		
		else if($deprefcheck!='' && $deprefapprovalstatus=='1')
		{ 
			mysql_query("update consultation_departmentreferal set approvalstatus='$deprefapprovalstatus',paymentstatus='$status'  where auto_number='$deprefcheck' and patientvisitcode='$visitcode'");
			$counter=$counter + 1;
		}
		else if($deprefcheck!='' && $deprefapprovalstatus=='2')
		{  
			mysql_query("update consultation_departmentreferal set approvalstatus='$deprefapprovalstatus',paymentstatus='pending'  where auto_number='$deprefcheck' and patientvisitcode='$visitcode'");
			$counter=$counter + 1;
		}
	} 
	//exit();
	//referal ends here
	
	if($counter>0)
	{
		$query2bill = "select * from approvalstatus order by auto_number desc limit 0, 1";
		$exec2bill = mysql_query($query2bill) or die ("Error in Query2bill".mysql_error());
		$res2bill = mysql_fetch_array($exec2bill);
		$billnumber = $res2bill["docno"];
		if ($billnumber == '')
		{
			$billnumbercode ='APP-'.'1';
			$openingbalance = '0.00';
		}
		else
		{
			$billnumber = $res2bill["docno"];
			$billnumbercode = substr($billnumber, 4, 8);
			$billnumbercode = intval($billnumbercode);
			$billnumbercode = $billnumbercode + 1;		
			$maxanum = $billnumbercode;						
			$billnumbercode = 'APP-' .$maxanum;
			$openingbalance = '0.00';
			//echo $companycode;
		}
		/*$queryapprove = "INSERT INTO completed_billingpaylater(override,comments,schemecode,netbillamount, availablelimit) VALUES($override, $schemecode, $approvallimit, $availablelimit)";
	$execapprove = mysql_query($queryapprove) or die ("Error in Queryapprove".mysql_error());*/
	
	if($override==1)
	{
		$query2bill1 = "select auto_number from master_planname where accountname = '".$accountname."'";
		$exec2bill1 = mysql_query($query2bill1) or die ("Error in Query2bill".mysql_error());
		$res2bill1 = mysql_fetch_array($exec2bill1);
		$schemecode = $res2bill1["auto_number"];
		}
	
		$queryinsert = "insert into approvalstatus (recorddate,recordtime,docno,patientname,visitcode,patientcode,age,gender,billtype,accountname,ipaddress,username,override,comments,schemecode,netbilledamount, availablelimit,locationname,locationcode) values
		('$dateonly','$timeonly','$billnumbercode','$patientname','$visitcode','$patientcode','$patientage','$patientgender','$billtype','$accountname','$ipaddress','$username','$override','$approvecomment', '$schemecode', '$approvallimit', '$availablelimit','".$locationname."','".$locationcode."')";
		mysql_query($queryinsert) or die ("Error in Queryinsert".mysql_error());
		
	}
	if($dispensingfee != '')
	{
	    $query2bill1 = "select * from dispensingfee order by auto_number desc limit 0, 1";
		$exec2bill1 = mysql_query($query2bill1) or die ("Error in Query2bill".mysql_error());
		$res2bill1 = mysql_fetch_array($exec2bill1);
		$billnumber1 = $res2bill1["docno"];
		if ($billnumber1 == '')
		{
			$billnumbercode1 ='DSF-'.'1';
			$openingbalance = '0.00';
		}
		else
		{
			$billnumber1 = $res2bill1["docno"];
			$billnumbercode1 = substr($billnumber1, 4, 8);
			$billnumbercode1 = intval($billnumbercode1);
			$billnumbercode1 = $billnumbercode1 + 1;		
			$maxanum1 = $billnumbercode1;						
			$billnumbercode1 = 'DSF-' .$maxanum1;
			$openingbalance = '0.00';
			//echo $companycode;
		}
	   $queryinsert1 = "insert into dispensingfee (recorddate,recordtime,patientname,visitcode,patientcode,age,gender,billtype,accountname,ipaddress,username,dispensingfee,docno) values
		('$dateonly','$timeonly','$patientname','$visitcode','$patientcode','$patientage','$patientgender','$billtype','$accountname','$ipaddress','$username','$dispensingfee','$billnumbercode1')";
		mysql_query($queryinsert1) or die ("Error in Queryinsert1".mysql_error());
		}
		header("location:approvallist.php");
		exit;
}


//to redirect if there is no entry in masters category or item or customer or settings



//To get default tax from autoitemsearch1.php and autoitemsearch2.php - for CST tax override.
if (isset($_REQUEST["defaulttax"])) { $defaulttax = $_REQUEST["defaulttax"]; } else { $defaulttax = ""; }
if(isset($_REQUEST['delete']))
{
$auto_number=$_REQUEST['delete'];
$viscode=$_REQUEST['visitcode'];
$remove=$_REQUEST['remove'];
if($remove=='pharm'){
mysql_query("delete from master_consultationpharm where auto_number='$auto_number' and patientvisitcode='$viscode'");
mysql_query("delete from master_consultationpharmissue where auto_number='$auto_number' and patientvisitcode='$viscode'");
}
if($remove=='lab'){
mysql_query("delete from consultation_lab where auto_number='$auto_number' and patientvisitcode='$viscode'");
}
if($remove=='radiology'){
mysql_query("delete from consultation_radiology where auto_number='$auto_number' and patientvisitcode='$viscode'");
}
if($remove=='service'){
mysql_query("delete from consultation_services where auto_number='$auto_number' and patientvisitcode='$viscode'");
}

if($remove=='referal'){
mysql_query("delete from consultation_referal where auto_number='$auto_number' and patientvisitcode='$viscode'");
}

if($remove=='defreferal'){
mysql_query("delete from consultation_departmentreferal where auto_number='$auto_number' and patientvisitcode='$viscode'");
}
}
//$defaulttax = $_REQUEST["defaulttax"];
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


//This include updatation takes too long to load for hunge items database.


//To populate the autocompetelist_services1.js


//To verify the edition and manage the count of bills.
$thismonth = date('Y-m-');
$query77 = "select * from master_edition where status = 'ACTIVE'";
$exec77 =  mysql_query($query77) or die ("Error in Query77".mysql_error());
$res77 = mysql_fetch_array($exec77);
$res77allowed = $res77["allowed"];



/*
$query99 = "select count(auto_number) as cntanum from master_quotation where quotationdate like '$thismonth%'";
$exec99 = mysql_query($query99) or die ("Error in Query99".mysql_error());
$res99 = mysql_fetch_array($exec99);
$res99cntanum = $res99["cntanum"];
$totalbillandquote = $res88cntanum + $res99cntanum; //total of bill and quote in current month.
if ($totalbillandquote > $res77allowed)
{
	//header ("location:usagelimit1.php"); // redirecting.
	//exit;
}
*/

//To Edit Bill
if (isset($_REQUEST["delbillst"])) { $delbillst = $_REQUEST["delbillst"]; } else { $delbillst = ""; }
//$delbillst = $_REQUEST["delbillst"];
if (isset($_REQUEST["delbillautonumber"])) { $delbillautonumber = $_REQUEST["delbillautonumber"]; } else { $delbillautonumber = ""; }
//$delbillautonumber = $_REQUEST["delbillautonumber"];
if (isset($_REQUEST["delbillnumber"])) { $delbillnumber = $_REQUEST["delbillnumber"]; } else { $delbillnumber = ""; }
//$delbillnumber = $_REQUEST["delbillnumber"];

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
$query78="select * from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'";
$exec78=mysql_query($query78) or die(mysql_error());
$res78=mysql_fetch_array($exec78);
$patientage=$res78['age'];
$patientgender=$res78['gender'];
$subtypeanum = $res78['subtype'];
$availableilimit = $res78['availableilimit'];
$patientname=$res78['patientfullname'];
$patientaccount=$res78['accountfullname'];
$res111paymenttype = $res78['paymenttype'];
$locationcode = $res78['locationcode'];



$query1211 = "select * from master_location where locationcode = '$locationcode'";
$exec1211 = mysql_query($query1211) or die (mysql_error());
$res1211 = mysql_fetch_array($exec1211);
 $locationname = $res1211['locationname'];


$query121 = "select * from master_paymenttype where auto_number = '$res111paymenttype'";
$exec121 = mysql_query($query121) or die (mysql_error());
$res121 = mysql_fetch_array($exec121);
$res121paymenttype = $res121['paymenttype'];

$query131 = "select * from master_subtype where auto_number = '$subtypeanum'";
$exec131 = mysql_query($query131) or die ("Error in Query131".mysql_error());
$res131 = mysql_fetch_array($exec131);
$res131subtype = $res131['subtype'];
?>

<?php
$querylab7=mysql_query("select * from master_visitentry where patientcode='$patientcode' and visitcode='$visitcode'");
$execlab7=mysql_fetch_array($querylab7);
$billtype=$execlab7['billtype'];

?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$labprefix = $res3['labprefix'];

$query2 = "select * from approvalstatus order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docno"];

if ($billnumber == '')
{
	$billnumbercode ='APP-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["docno"];
	$billnumbercode = substr($billnumber, 4, 8);
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'APP-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}


?>

<script language="javascript">
function frequencyitem()
{
if(document.form1.frequency.value=="select")
{
alert("please select a frequency");
document.form1.frequency.focus();
return false;
}
return true;
}

function Functionfrequency(i)
{
var i = i;

var formula = document.getElementById("aformula"+i+"").value;
formula = formula.replace(/\s/g, '');
//alert(formula);
if(formula == 'INCREMENT')
{
var ResultFrequency;
 var frequencyanum = document.getElementById("afrequency"+i+"").value;
var medicinedose=document.getElementById("adose"+i+"").value;
 var VarDays = document.getElementById("adays"+i+"").value; 

 if((frequencyanum != '') && (VarDays != ''))
 {
  ResultFrequency = medicinedose*frequencyanum * VarDays;
 }
 else
 {
 ResultFrequency =0;
 }
 document.getElementById("aquantity"+i+"").value = ResultFrequency;
var VarRate = document.getElementById("arate"+i+"").value;
var ResultAmount = parseFloat(VarRate * ResultFrequency);
  document.getElementById("aamount"+i+"").value = ResultAmount.toFixed(2);
}

else if(formula == 'CONSTANT')
{
var ResultFrequency;
var strength = document.getElementById("astrength"+i+"").value;
 var frequencyanum = document.getElementById("afrequency"+i+"").value;
var medicinedose=document.getElementById("adose"+i+"").value;
 var VarDays = document.getElementById("adays"+i+"").value; 
 if((frequencyanum != '') && (VarDays != ''))
 {
  ResultFrequency = medicinedose*frequencyanum*VarDays/strength;
 }
 else
 {
 ResultFrequency =0; 
 }
 //ResultFrequency = parseInt(ResultFrequency);

 ResultFrequency = Math.ceil(ResultFrequency);
 //alert(ResultFrequency);
 document.getElementById("aquantity"+i+"").value = ResultFrequency;
 
 
var VarRate = document.getElementById("arate"+i+"").value;
var ResultAmount = parseFloat(VarRate * ResultFrequency);
  document.getElementById("aamount"+i+"").value = ResultAmount.toFixed(2);
}
}

function Functionfrequency1()
{
var formula = document.getElementById("formula").value;
formula = formula.replace(/\s/g, '');
//alert(formula);
if(formula == 'INCREMENT')
{
var ResultFrequency;
 var frequencyanum = document.getElementById("frequency").value;
var medicinedose=document.getElementById("dose").value;
 var VarDays = document.getElementById("days").value; 
 if((frequencyanum != '') && (VarDays != ''))
 {
  ResultFrequency = medicinedose*frequencyanum * VarDays;
 }
 else
 {
 ResultFrequency =0;
 }
 document.getElementById("quantity").value = ResultFrequency;
var VarRate = document.getElementById("rates").value;
var ResultAmount = parseFloat(VarRate * ResultFrequency);
  document.getElementById("amount").value = ResultAmount.toFixed(2);
}

else if(formula == 'CONSTANT')
{
var ResultFrequency;
var strength = document.getElementById("strength").value;
 var frequencyanum = document.getElementById("frequency").value;
var medicinedose=document.getElementById("dose").value;
 var VarDays = document.getElementById("days").value; 
 if((frequencyanum != '') && (VarDays != ''))
 {
  ResultFrequency = medicinedose*frequencyanum*VarDays/strength;
 }
 else
 {
 ResultFrequency =0;
 }
 //ResultFrequency = parseInt(ResultFrequency);

 ResultFrequency = Math.ceil(ResultFrequency);
 //alert(ResultFrequency);
 document.getElementById("quantity").value = ResultFrequency;
 
 
var VarRate = document.getElementById("rates").value;
var ResultAmount = parseFloat(VarRate * ResultFrequency);
  document.getElementById("amount").value = ResultAmount.toFixed(2);
}
}

function deletevalid()
{
var del;
del=confirm("Do You want to delete this item ?");
if(del == false)
{
return false;
}
}
function btnDeleteClick10(delID,pharmamount, nam)
{
	//alert ("Inside btnDeleteClick.");
	var newtotal4;
	//alert(pharmamount);
	var varDeleteID = delID;
	var amount=pharmamount;
	//alert (varDeleteID);
	var fRet3; 
	fRet3 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet3 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}

	if(document.getElementById(nam).checked==true)
	{
		//alert(amount);
		document.getElementById("approvallimit").value=parseFloat(document.getElementById("approvallimit").value)-parseFloat(amount);
		
		}

	var child = document.getElementById('idTR'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow'); // tbody name.
	document.getElementById ('insertrow').removeChild(child);
	
	var child = document.getElementById('idTRaddtxt'+varDeleteID);  //tr name
    var parent = document.getElementById('insertrow'); // tbody name.
	//alert (child);
	if (child != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow').removeChild(child);
		
		
	}
	var currenttotal4=document.getElementById('total').value;
	//alert(currenttotal);
	newtotal4= currenttotal4-pharmamount;
	
	//alert(newtotal);
	
	document.getElementById('total').value=newtotal4;
	
	grandtotalminus(pharmamount);
}
function btnDeleteClick6(delID1,vrate1, nam)
{
	//alert ("Inside btnDeleteClick.");
	var newtotal3;
	//alert(vrate1);
	var varDeleteID1 = delID1;
	var amount=vrate1;
	//alert(varDeleteID1);
	var fRet4; 
	fRet4 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet4); 
	if (fRet4 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}
	
	if(document.getElementById(nam).checked==true)
	{
		//alert(amount);
		document.getElementById("approvallimit").value=parseFloat(document.getElementById("approvallimit").value)-parseFloat(amount);
		
		}
	
//alert(varDeleteID1);
	var child1 = document.getElementById('labidTR'+varDeleteID1);  //tr name
    var parent1 = document.getElementById('insertrow1'); // tbody name.
	document.getElementById ('insertrow1').removeChild(child1);
	
	var child1= document.getElementById('idTRaddtxt'+varDeleteID1);  //tr name
    var parent1= document.getElementById('insertrow1'); // tbody name.
	//alert (child);
	if (child1 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow1').removeChild(child1);
	}
	
	var currenttotal3=document.getElementById('total1').value;
	//alert(currenttotal);
	newtotal3= currenttotal3-vrate1;
	
	//alert(newtotal3);
	
	document.getElementById('total1').value=newtotal3.toFixed(2);
	
	grandtotalminus(vrate1);

}
function btnDeleteClick9(delID5,radrate, nam)
{
	//alert ("Inside btnDeleteClick.");
	var newtotal2;
	//alert(radrate);
	var varDeleteID2= delID5;
	var amount=radrate;
	//alert (varDeleteID2);
	var fRet5; 
	fRet5 = confirm('Are You Sure Want To Delete This Entry?'); 
	
	
	//alert(fRet); 
	if (fRet5 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}
	
	if(document.getElementById(nam).checked==true)
	{
		//alert(amount);
		document.getElementById("approvallimit").value=parseFloat(document.getElementById("approvallimit").value)-parseFloat(amount);
		
		}
	

	var child2= document.getElementById('radidTR'+varDeleteID2);  //tr name
    var parent2 = document.getElementById('insertrow2'); // tbody name.
	document.getElementById ('insertrow2').removeChild(child2);
	
	var child2 = document.getElementById('idTRaddtxt'+varDeleteID2);  //tr name
    var parent2 = document.getElementById('insertrow2'); // tbody name.
	//alert (child);
	if (child2 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow2').removeChild(child2);
	}
	
	var currenttotal2=document.getElementById('total2').value;
	//alert(currenttotal);
	newtotal2= currenttotal2-radrate;
	
	//alert(newtotal);
	
	document.getElementById('total2').value=newtotal2;
	
	grandtotalminus(radrate);
	

	
}



function btnDeleteClick91(delID6,refrate, nam)
{
	//alert ("Inside btnDeleteClick.");
	var newtotal2;
	//alert(refrate);
	var varDeleteID2= delID6;
	var amount=refrate;
	//alert (varDeleteID2);
	var fRet5; 
	fRet5 = confirm('Are You Sure Want To Delete This Entry?'); 
	
	
	//alert(fRet); 
	if (fRet5 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}
	
	if(document.getElementById(nam).checked==true)
	{
		//alert(amount);
		document.getElementById("approvallimit").value=parseFloat(document.getElementById("approvallimit").value)-parseFloat(amount);
		
		}
	

	var child2= document.getElementById('refidTR'+varDeleteID2);  //tr name
    var parent2 = document.getElementById('insertrow51'); // tbody name.
	document.getElementById ('insertrow51').removeChild(child2);
	
	var child2 = document.getElementById('idTRaddtxt'+varDeleteID2);  //tr name
    var parent2 = document.getElementById('insertrow51'); // tbody name.
	//alert (child);
	if (child2 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow51').removeChild(child2);
	}
	
	var currenttotal21=document.getElementById('total21').value;
	//alert(currenttotal);
	newtotal21= currenttotal21-refrate;
	
	//alert(newtotal);
	
	document.getElementById('total21').value=newtotal21;
	
	grandtotalminus(refrate);
	

	
}

function btnDeleteClick12(delID3,vrate3, nam)
{
	//alert (nam);
	var newtotal1;
	var varDeleteID3= delID3;
	var amount=vrate3;
	//alert (varDeleteID3);
	//alert(vrate3);
	var fRet6; 
	fRet6 = confirm('Are You Sure Want To Delete This Entry?'); 
	//alert(fRet); 
	if (fRet6 == false)
	{
		//alert ("Item Entry Not Deleted.");
		return false;
	}
if(document.getElementById(nam).checked==true)
	{
		//alert(amount);
		document.getElementById("approvallimit").value=parseFloat(document.getElementById("approvallimit").value)-parseFloat(amount);
		
		}
	
	var child3 = document.getElementById('seridTR'+varDeleteID3);  
	//alert (child3);//tr name
    var parent3 = document.getElementById('insertrow3'); // tbody name.
	document.getElementById ('insertrow3').removeChild(child3);
	
	var child3= document.getElementById('idTRaddtxt'+varDeleteID3);  //tr name
    var parent3 = document.getElementById('insertrow3'); // tbody name.
	
	if (child3 != null) 
	{
		//alert ("Row Exsits.");
		document.getElementById ('insertrow3').removeChild(child3);
	}
var currenttotal1=document.getElementById('total3').value;
	//alert(currenttotal);
	newtotal1= currenttotal1-vrate3;
	
	//alert(newtotal);
	
	document.getElementById('total3').value=newtotal1;
	grandtotalminus(vrate3);
	
	
}


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


	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	// To handle ajax dropdown list.
	funcCustomerDropDownSearch4();
	funcPopupPrintFunctionCall();
	funcCustomerDropDownSearch1(); //To handle ajax dropdown list.	
	funcPopupPrintFunctionCall();
	funcCustomerDropDownSearch2(); 
	funcCustomerDropDownSearch3();
	funcCustomerDropDownSearch7();
	funcCustomerDropDownSearch10();
	funcCustomerDropDownSearch15();
	
	/*funcCustomerDropDownSearch1();
	funcCustomerDropDownSearch2();	
	funcCustomerDropDownSearch3();
	funcCustomerDropDownSearch4(); 
	//funcCustomerDropDownSearch7();
	//funcCustomerDropDownSearch10();
	//funcCustomerDropDownSearch15();
	//funcOnLoadBodyFunctionCall1();//To handle ajax dropdown list.*/

		
}

function sertotal()
{
	var varquantityser = document.getElementById("serviceqty").value;
	var varserRates = document.getElementById("rate3").value;
	var totalservi = parseFloat(varquantityser) * parseFloat(varserRates);
	document.getElementById("serviceamount").value=totalservi.toFixed(2);
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
<script type="text/javascript">

function loadprintpage1(varPaperSizeCatch)
{
	//var varBillNumber = document.getElementById("billnumber").value;
	var varPaperSize = varPaperSizeCatch;
	//alert (varPaperSize);
	//return false;
	<?php
	//To previous js error if empty. 
	if ($previousbillnumber == '') 
	{ 
		$previousbillnumber = 1; 
		$previousbillautonumber = 1; 
		$previouscompanyanum = 1; 
	} 
	?>
	var varBillNumber = document.getElementById("quickprintbill").value;
	var varBillAutoNumber = "<?php //echo $previousbillautonumber; ?>";
	var varBillCompanyAnum = "<?php echo $_SESSION["companyanum"]; ?>";
	if (varBillNumber == "")
	{
		alert ("Bill Number Cannot Be Empty.");//quickprintbill
		document.getElementById("quickprintbill").focus();
		return false;
	}
	
	var varPrintHeader = "INVOICE";
	var varTitleHeader = "ORIGINAL";
	if (varTitleHeader == "")
	{
		alert ("Please Select Print Title.");
		document.getElementById("titleheader").focus();
		return false;
	}
	
	//alert (varBillNumber);
	//alert (varPrintHeader);
	//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');

	if (varPaperSize == "A4")
	{
		window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&billnumber="+varBillNumber+"","OriginalWindowA4<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	}
	if (varPaperSize == "A5")
	{
		window.open("print_bill1_a5.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&billnumber="+varBillNumber+"","OriginalWindowA5<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	}
}

function cashentryonfocus1()
{
	if (document.getElementById("cashgivenbycustomer").value == "0.00")
	{
		document.getElementById("cashgivenbycustomer").value = "";
		document.getElementById("cashgivenbycustomer").focus();
	}
}

function funcDefaultTax1() //Function to CST Taxes if required.
{
	//alert ("Default Tax");
	<?php
	//delbillst=billedit&&delbillautonumber=13&&delbillnumber=1
	//To avoid change of bill number on edit option after selecting default tax.
	if (isset($_REQUEST["delbillst"])) { $delBillSt = $_REQUEST["delbillst"]; } else { $delBillSt = ""; }
	//$delBillSt = $_REQUEST["delbillst"];
	if (isset($_REQUEST["delbillautonumber"])) { $delBillAutonumber = $_REQUEST["delbillautonumber"]; } else { $delBillAutonumber = ""; }
	//$delBillAutonumber = $_REQUEST["delbillautonumber"];
	if (isset($_REQUEST["delbillnumber"])) { $delBillNumber = $_REQUEST["delbillnumber"]; } else { $delBillNumber = ""; }
	//$delBillNumber = $_REQUEST["delbillnumber"];
	
	?>
	var varDefaultTax = document.getElementById("defaulttax").value;
	if (varDefaultTax != "")
	{
		<?php
		if ($delBillSt == 'billedit')
		{
		?>
		window.location="sales1.php?defaulttax="+varDefaultTax+"&&delbillst=<?php echo $delBillSt; ?>&&delbillautonumber="+<?php echo $delBillAutonumber; ?>+"&&delbillnumber="+<?php echo $delBillNumber; ?>+"";
		<?php
		}
		else
		{
		?>
		window.location="sales1.php?defaulttax="+varDefaultTax+"";
		<?php
		}
		?>
	}
	else
	{
		window.location="sales1.php";
	}
	//return false;
}

function selectall() {
//alert("check");
if(document.getElementById('selectalll').checked==true)
{
	for (i=1;i<20;i++){	
	if(document.getElementById('pharamcheck'+i))
	{
		if(document.getElementById('pharamcheck'+i).checked==false)
		{
   		 	pharamcheck = document.getElementById('pharamcheck'+i).checked = true ; 
			document.getElementById('pharamlatertonow'+i).checked = false;
			document.getElementById('pharamlatertonow'+i).disabled = true;
			var x = document.getElementById('pharamcheck'+i);
			if(x.hasAttribute("onclick")){
			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);
			}else{
			var y = document.getElementById('amount'+i).value ;
			}
			approvalfunction(x.id,y);   		
		}
	}
	}
	for (i=1;i<20;i++){	
	if(document.getElementById('labcheck'+i))
	{
		if(document.getElementById('labcheck'+i).checked==false)
		{
			labcheck = document.getElementById('labcheck'+i).checked = true;
			document.getElementById('lablatertonow'+i).checked = false;
			document.getElementById('lablatertonow'+i).disabled = true;
			var x = document.getElementById('labcheck'+i);
			if(x.hasAttribute("onclick")){
			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);
			}else{
			var y = document.getElementById('rate5'+i).value ;
			}
			approvalfunction(x.id,y);
		}
	}	
	}
	for (i=1;i<20;i++){	
	if(document.getElementById('radcheck'+i))
	{
		if(document.getElementById('radcheck'+i).checked==false)
		{
			radcheck = document.getElementById('radcheck'+i).checked = true;
			document.getElementById('radlatertonow'+i).checked = false;
			document.getElementById('radlatertonow'+i).disabled = true;
			var x = document.getElementById('radcheck'+i);
			if(x.hasAttribute("onclick")){
			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);
			}else{
			var y = document.getElementById('rate8'+i).value ;
			}
			approvalfunction(x.id,y);	
		}
	}
	}
	for (i=1;i<20;i++){	
	if(document.getElementById('sercheck'+i))
	{
		if(document.getElementById('sercheck'+i).checked==false)
		{
			sercheck = document.getElementById('sercheck'+i).checked = true;
			document.getElementById('serlatertonow'+i).checked = false;
			document.getElementById('serlatertonow'+i).disabled = true;
			var x = document.getElementById('sercheck'+i);
			if(x.hasAttribute("onclick")){
			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);
			}else{
			var y = document.getElementById('serviceamount'+i).value ;
			}
			approvalfunction(x.id,y);
		}
	}	
	}
	
		for (i=1;i<20;i++){	
	if(document.getElementById('refcheck'+i))
	{
		if(document.getElementById('refcheck'+i).checked==false)
		{
			radcheck = document.getElementById('refcheck'+i).checked = true;
			document.getElementById('reflatertonow'+i).checked = false;
			document.getElementById('reflatertonow'+i).disabled = true;
			var x = document.getElementById('refcheck'+i);
			if(x.hasAttribute("onclick")){
			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);
			}else{
			var y = document.getElementById('rate8'+i).value ;
			}
			approvalfunction(x.id,y);	
		}
	}
	}
	
	//this is for dep ref
	for (i=1;i<20;i++){	
	if(document.getElementById('deprefcheck'+i))
	{
		if(document.getElementById('deprefcheck'+i).checked==false)
		{
			radcheck = document.getElementById('deprefcheck'+i).checked = true;
			document.getElementById('depreflatertonow'+i).checked = false;
			document.getElementById('depreflatertonow'+i).disabled = true;
			var x = document.getElementById('deprefcheck'+i);
			if(x.hasAttribute("onclick")){
			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);
			}else{
			var y = document.getElementById('rate8'+i).value ;
			}
			approvalfunction(x.id,y);	
		}
	}
	}
	//ends here
	
	if(document.getElementById("availablelimit").value<document.getElementById("approvallimit").value)
	{
		if(document.getElementById("approve").checked == false){
		alert("Approval Limit is exceeded Available Limit");
		
		}
	}
	if(parseFloat(document.getElementById("availablelimit").value.replace(",","")) < parseFloat(document.getElementById("approvallimit").value))
	{
		if(document.getElementById("approve").checked ==false){
			alert("Approval limit is greater than Available limit");
			document.getElementById("approvallimit").value = '';
			
			for (i=1;i<20;i++){
				if(document.getElementById('pharamcheck'+i))
			{
			document.getElementById('pharamcheck'+i).checked=false;
			}
			}
			
			for (i=1;i<20;i++){
				if(document.getElementById('labcheck'+i))
			{
			document.getElementById('labcheck'+i).checked=false;
			}
			}
			
			for (i=1;i<20;i++){
				if(document.getElementById('radcheck'+i))
			{
			document.getElementById('radcheck'+i).checked=false;
			}
			}
			
			for (i=1;i<20;i++){
				if(document.getElementById('sercheck'+i))
			{
			document.getElementById('sercheck'+i).checked=false;
			}
			}
			document.getElementById('selectalll'+i).checked=false;
		}
	}
}
else
{
	for (i=1;i<20;i++){	
	if(document.getElementById('pharamcheck'+i))
	{
   		 if(document.getElementById('pharamcheck'+i).checked==false)
		{
		 	pharamcheck = document.getElementById('pharamcheck'+i).checked = false ;   
			document.getElementById('pharamlatertonow'+i).disabled = false;
			var x = document.getElementById('pharamcheck'+i);
			if(x.hasAttribute("onclick")){
			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);
			}else{
			var y = document.getElementById('amount'+i).value ;
			}
			approvalfunction(x.id,y); 		
		}
	}
	}
	for (i=1;i<20;i++){	
	if(document.getElementById('labcheck'+i))
	{
		if(document.getElementById('labcheck'+i).checked==false)
		{
			labcheck = document.getElementById('labcheck'+i).checked = false;
			document.getElementById('lablatertonow'+i).disabled = false;
			var x = document.getElementById('labcheck'+i);
			if(x.hasAttribute("onclick")){
			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);
			}else{
			var y = document.getElementById('rate5'+i).value ;
			}
			approvalfunction(x.id,y);
		}
	}	
	}
	for (i=1;i<20;i++){	
	if(document.getElementById('radcheck'+i))
	{
		if(document.getElementById('radcheck'+i).checked==false)
		{
			radcheck = document.getElementById('radcheck'+i).checked = false;
			document.getElementById('radlatertonow'+i).disabled = false;
			var x = document.getElementById('radcheck'+i);
			if(x.hasAttribute("onclick")){
			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);
			}else{
			var y = document.getElementById('rate8'+i).value ;
			}
			approvalfunction(x.id,y);
		}	
	}
	}
	for (i=1;i<20;i++){	
	if(document.getElementById('sercheck'+i))
	{
		if(document.getElementById('sercheck'+i).checked==false)
		{
			sercheck = document.getElementById('sercheck'+i).checked = false;
			document.getElementById('serlatertonow'+i).disabled = false;
			var x = document.getElementById('sercheck'+i);
			if(x.hasAttribute("onclick")){
			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);
			}else{
			var y = document.getElementById('serviceamount'+i).value ;
			}
			approvalfunction(x.id,y);
		}
	}	
	}
	
		for (i=1;i<20;i++){	
	if(document.getElementById('refcheck'+i))
	{
		if(document.getElementById('refcheck'+i).checked==false)
		{
			radcheck = document.getElementById('refcheck'+i).checked = false;
			document.getElementById('reflatertonow'+i).disabled = false;
			var x = document.getElementById('refcheck'+i);
			if(x.hasAttribute("onclick")){
			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);
			}else{
			var y = document.getElementById('rate4'+i).value ;
			}
			approvalfunction(x.id,y);
		}	
	}
	}
}
}
function approvecheck(){
	if(document.getElementById('approve').checked==true)
{
	for (i=1;i<20;i++){	
	if(document.getElementById('pharamcheck'+i))
	{
		if(document.getElementById('pharamcheck'+i).checked==false)
		{
   		 	pharamcheck = document.getElementById('pharamcheck'+i).checked = true ; 
			document.getElementById('pharamlatertonow'+i).checked = false; 
			document.getElementById('pharamlatertonow'+i).disabled = true; 
			var x = document.getElementById('pharamcheck'+i);
			if(x.hasAttribute("onclick")){
			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);
			}else{
			var y = document.getElementById('amount'+i).value ;
			}
			approvalfunction(x.id,y); 		
		}
	}
	}
	for (i=1;i<20;i++){	
	if(document.getElementById('labcheck'+i))
	{
		if(document.getElementById('labcheck'+i).checked==false)
		{
			labcheck = document.getElementById('labcheck'+i).checked = true;
			document.getElementById('lablatertonow'+i).checked = false;
			document.getElementById('lablatertonow'+i).disabled = true;
			var x = document.getElementById('labcheck'+i);
			if(x.hasAttribute("onclick")){
			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);
			}else{
			var y = document.getElementById('rate5'+i).value ;
			}
			approvalfunction(x.id,y);
		}
	}	
	}
	for (i=1;i<20;i++){	
	if(document.getElementById('radcheck'+i))
	{
		if(document.getElementById('radcheck'+i).checked==false)
		{
			radcheck = document.getElementById('radcheck'+i).checked = true;
			document.getElementById('radlatertonow'+i).checked = false;	
			document.getElementById('radlatertonow'+i).disabled = true;	
			var x = document.getElementById('radcheck'+i);
			if(x.hasAttribute("onclick")){
			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);
			}else{
			var y = document.getElementById('rate8'+i).value ;
			}
			approvalfunction(x.id,y);
		}
	}
	}
	for (i=1;i<20;i++){	
	if(document.getElementById('sercheck'+i))
	{
		if(document.getElementById('sercheck'+i).checked==false)
		{
			sercheck = document.getElementById('sercheck'+i).checked = true;
			document.getElementById('serlatertonow'+i).checked = false;
			document.getElementById('serlatertonow'+i).disabled = true;
			var x = document.getElementById('sercheck'+i);
			if(x.hasAttribute("onclick")){
			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);
			}else{
			var y = document.getElementById('serviceamount'+i).value ;
			}
			approvalfunction(x.id,y);
		}
	}	
	}
	
		for (i=1;i<20;i++){	
	if(document.getElementById('refcheck'+i))
	{
		if(document.getElementById('refcheck'+i).checked==false)
		{
			radcheck = document.getElementById('refcheck'+i).checked = true;
			document.getElementById('reflatertonow'+i).checked = false;	
			document.getElementById('reflatertonow'+i).disabled = true;	
			var x = document.getElementById('refcheck'+i);
			if(x.hasAttribute("onclick")){
			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);
			}else{
			var y = document.getElementById('rate4'+i).value ;
			}
			approvalfunction(x.id,y);
		}
	}
	}
	
			for (i=1;i<20;i++){	
	if(document.getElementById('deprefcheck'+i))
	{
		if(document.getElementById('deprefcheck'+i).checked==false)
		{
			radcheck = document.getElementById('deprefcheck'+i).checked = true;
			document.getElementById('depreflatertonow'+i).checked = false;	
			document.getElementById('depreflatertonow'+i).disabled = true;	
			var x = document.getElementById('deprefcheck'+i);
			if(x.hasAttribute("onclick")){
			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);
			}else{
			var y = document.getElementById('deprate4'+i).value ;
			}
			approvalfunction(x.id,y);
		}
	}
	}
	
	
	document.getElementById('approvecomment').style.display = '';
}
else
{
	for (i=1;i<20;i++){	
	if(document.getElementById('pharamcheck'+i))
	{
   		 if(document.getElementById('pharamcheck'+i).disabled==false)
		{
		 	pharamcheck = document.getElementById('pharamcheck'+i).checked = false ;   
			document.getElementById('pharamlatertonow'+i).disabled = false; 
			var x = document.getElementById('pharamcheck'+i);
			if(x.hasAttribute("onclick")){
			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);
			}else{
			var y = document.getElementById('amount'+i).value ;
			}
			approvalfunction(x.id,y);		
		}
	}
	}
	for (i=1;i<20;i++){	
	if(document.getElementById('labcheck'+i))
	{
		if(document.getElementById('labcheck'+i).disabled==false)
		{
			labcheck = document.getElementById('labcheck'+i).checked = false;
			document.getElementById('lablatertonow'+i).disabled = false;
			var x = document.getElementById('labcheck'+i);
			if(x.hasAttribute("onclick")){
			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);
			}else{
			var y = document.getElementById('rate5'+i).value ;
			}
			approvalfunction(x.id,y);
		}
	}	
	}
	for (i=1;i<20;i++){	
	if(document.getElementById('radcheck'+i))
	{
		if(document.getElementById('radcheck'+i).disabled==false)
		{
			radcheck = document.getElementById('radcheck'+i).checked = false;
			document.getElementById('radlatertonow'+i).disabled = false;
			var x = document.getElementById('radcheck'+i);
			if(x.hasAttribute("onclick")){
			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);
			}else{
			var y = document.getElementById('rate8'+i).value ;
			}
			approvalfunction(x.id,y);
		}	
	}
	}
	for (i=1;i<20;i++){	
	if(document.getElementById('sercheck'+i))
	{
		if(document.getElementById('sercheck'+i).disabled==false)
		{
			sercheck = document.getElementById('sercheck'+i).checked = false;
			document.getElementById('serlatertonow'+i).disabled = false;
			var x = document.getElementById('sercheck'+i);
			if(x.hasAttribute("onclick")){
			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);
			}else{
			var y = document.getElementById('serviceamount'+i).value ;
			}
			approvalfunction(x.id,y);
		}
	}	
	}
	
		for (i=1;i<20;i++){	
	if(document.getElementById('refcheck'+i))
	{
		if(document.getElementById('refcheck'+i).disabled==false)
		{
			radcheck = document.getElementById('refcheck'+i).checked = false;
			document.getElementById('reflatertonow'+i).disabled = false;
			var x = document.getElementById('refcheck'+i);
			if(x.hasAttribute("onclick")){
			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);
			}else{
			var y = document.getElementById('rate4'+i).value ;
			}
			approvalfunction(x.id,y);
		}	
	}
	}
	
	for (i=1;i<20;i++){	
	if(document.getElementById('deprefcheck'+i))
	{
		if(document.getElementById('deprefcheck'+i).disabled==false)
		{
			radcheck = document.getElementById('deprefcheck'+i).checked = false;
			document.getElementById('depreflatertonow'+i).disabled = false;
			var x = document.getElementById('deprefcheck'+i);
			if(x.hasAttribute("onclick")){
			var y = x.getAttribute("onclick").split(",")[3].substr(0,x.getAttribute("onclick").split(",")[3].length-1);
			}else{
			var y = document.getElementById('deprate4'+i).value ;
			}
			approvalfunction(x.id,y);
		}	
	}
	}
	
	document.getElementById('approvecomment').style.display = "none";

}
	
}
function selectcash(checkname,sno)
{

var sno = sno;

if(checkname=='pharam')
{
	if(document.getElementById('pharamlatertonow'+sno).checked == true)
	{
		document.getElementById('pharamcheck'+sno).checked =false;
		
	}
	else
	{
		//alert(sno);
		document.getElementById('pharamcheck'+sno).disabled =false;
	}
}
if(checkname=='lab')
{
	if(document.getElementById('lablatertonow'+sno).checked == true)
	{
		document.getElementById('labcheck'+sno).checked =false;
	}
	else
	{
		document.getElementById('labcheck'+sno).disabled=false;
	}
}
if(checkname=='rad')
{
	if(document.getElementById('radlatertonow'+sno).checked == true)
	{
		document.getElementById('radcheck'+sno).checked =false;
	}
	else
	{
		document.getElementById('radcheck'+sno).disabled=false;
	}
}
if(checkname=='ser')
{
	if(document.getElementById('serlatertonow'+sno).checked == true)
	{
		document.getElementById('sercheck'+sno).checked =false;
	}
	else
	{
		document.getElementById('sercheck'+sno).disabled=false;
	}
}

if(checkname=='ref')
{
	if(document.getElementById('reflatertonow'+sno).checked == true)
	{
		document.getElementById('refcheck'+sno).checked =false;
	}
	else
	{
		document.getElementById('refcheck'+sno).disabled=false;
	}
}

if(checkname=='depref')
{
	if(document.getElementById('depreflatertonow'+sno).checked == true)
	{
		document.getElementById('deprefcheck'+sno).checked =false;
	}
	else
	{
		document.getElementById('deprefcheck'+sno).disabled=false;
	}
}

}
function selectselect(checkname,sno)
{
	
var sno = sno;
if(checkname=='pharam')
{
	if(document.getElementById('pharamcheck'+sno).checked == true)
	{
		//alert(sno);
		document.getElementById('pharamlatertonow'+sno).checked = false;
		document.getElementById('pharamlatertonow'+sno).disabled=true;
		
	}
	else
	{
		document.getElementById('pharamlatertonow'+sno).disabled=false;
		document.getElementById('selectalll').checked = false;
	}
}
if(checkname=='lab')
{
	if(document.getElementById('labcheck'+sno).checked == true)
	{
		document.getElementById('lablatertonow'+sno).checked = false;
		document.getElementById('lablatertonow'+sno).disabled=true;
		
		
	}
	else
	{
		document.getElementById('lablatertonow'+sno).disabled=false;
		document.getElementById('selectalll').checked = false;
	}
}
if(checkname=='rad')
{
	if(document.getElementById('radcheck'+sno).checked == true)
	{
		document.getElementById('radlatertonow'+sno).checked = false;
		document.getElementById('radlatertonow'+sno).disabled=true;
		
	}
	else
	{
		document.getElementById('radlatertonow'+sno).disabled=false;
		document.getElementById('selectalll').checked = false;
	}
}
if(checkname=='ser')
{ //alert('ok');
	if(document.getElementById('sercheck'+sno).checked == true)
	{
		document.getElementById('serlatertonow'+sno).checked = false;
		document.getElementById('serlatertonow'+sno).disabled=true;
		//alert(document.getElementById("availablelimit").value);
		
	}
	else
	{
		document.getElementById('serlatertonow'+sno).disabled=false;
		document.getElementById('selectalll').checked = false;
	}
	
}
if(checkname=='ref')
{ //alert(sno);
	if(document.getElementById('refcheck'+sno).checked == true)
	{
		document.getElementById('reflatertonow'+sno).checked = false;
		document.getElementById('reflatertonow'+sno).disabled = true;
		
	}
	else
	{
		document.getElementById('reflatertonow'+sno).disabled=false;
		document.getElementById('selectalll').checked = false;
	}
}
//this is for dep ref
if(checkname=='depref')
{ //alert(sno);
	if(document.getElementById('deprefcheck'+sno).checked == true)
	{
		
		document.getElementById('depreflatertonow'+sno).checked = false;
		document.getElementById('depreflatertonow'+sno).disabled = true;
		
	}
	else
	{
		document.getElementById('depreflatertonow'+sno).disabled=false;
		document.getElementById('selectalll').checked = false;
	}
}

}
function grandtotl(vrate)
{
var varserRate=vrate;

if(document.getElementById('grandtotal').value=='')
	{
	grandtotal=0;
	}
	else
	{
	grandtotal=document.getElementById('grandtotal').value;
	}
	grandtotal=grandtotal.replace(/,/g,'');
	grandtotal=parseInt(grandtotal,10);
	grandtotal=parseInt(grandtotal) + parseInt(varserRate);
	document.getElementById("grandtotal").value=grandtotal.toFixed(2);
}
function grandtotalminus(vrate)
{
var varserRate=vrate;

	grandtotal=document.getElementById('grandtotal').value;
	grandtotal=grandtotal.replace(/,/g,'');
	grandtotal=parseInt(grandtotal,10);
	grandtotal=parseInt(grandtotal) - parseInt(varserRate);
	document.getElementById("grandtotal").value=grandtotal.toFixed(2);
}
function calculate()
{
var dispensingfee = document.getElementById("dispensingfee").value;
var grandtotal = document.getElementById("hidgrandtotal").value;
grandtotal=grandtotal.replace(/,/g,'');
var newgrandtotal = parseFloat(dispensingfee) + parseFloat(grandtotal);
if(dispensingfee != '')
{
document.getElementById("grandtotal").value = newgrandtotal.toFixed(2);
}
else
{
document.getElementById("grandtotal").value = grandtotal;
}
}

/*function alertfun()
{	
    var r;
	r=confirm("Please Ensure All The Checkbox Are Selected..!");
	if(r == false)
	{
		alert(r);
	return false;
	}
}*/
function alertfun() { 
	var pharmsno=document.getElementById("pharmacysno").value; 
	//alert(pharmsno); 
	//return false;
	for(i=1;i<=pharmsno;i++)
	{
		var s=i;
		
		
	if(document.getElementById("pharamcheck"+s).checked==false && document.getElementById("pharamlatertonow"+s).checked==false)
	{
		alert("You have to select all");
				return false;

	}
	
	}
	
	
	var labasno=document.getElementById("labsno").value;
	//alert(pharmsno); 
	//return false;
	for(i=1;i<=labasno;i++)
	{
		var s=i;
	if(document.getElementById("labcheck"+s).checked==false && document.getElementById("lablatertonow"+s).checked==false)
	{
		alert("You have to select all");
				return false;

	}
	}

	var radisno=document.getElementById("radsno").value;
	//alert(pharmsno); 
	//return false;
	for(i=1;i<=radisno;i++)
	{
		var s=i;
	if(document.getElementById("radcheck"+s).checked==false && document.getElementById("radlatertonow"+s).checked==false)
	{
		alert("You have to select all");
				return false;

	}
	}
	
	

	var servicesno=document.getElementById("sersno").value; 
	//alert(servicesno); 
	//return false;
	for(i=1;i<=servicesno;i++)
	{
		var s=i;
	if(document.getElementById("sercheck"+s).checked==false && document.getElementById("serlatertonow"+s).checked==false)
	{
		alert("You have to select all");
				return false;

	}
	}
	
//	alert();
	var refsno=document.getElementById("refsno").value;
	//alert(refsno); 
	//return false;
	for(i=1;i<=refsno;i++)
	{
		var s=i;
	if(document.getElementById("refcheck"+s).checked==false && document.getElementById("reflatertonow"+s).checked==false)
	{
		alert("You have to select all");
				return false;

	}
	}
	
	var deprefsno=document.getElementById("deprefsno").value;
	//alert(refsno); 
	//return false;
	for(i=1;i<=deprefsno;i++)
	{
		var s=i;
	if(document.getElementById("deprefcheck"+s).checked==false && document.getElementById("depreflatertonow"+s).checked==false)
	{
		alert("You have to select all");
				return false;

	}
	}
	/*var referalno=document.getElementById("refsno").value; 
	alert(referalno); 
	//return false;
	for(i=1;i<=referalno;i++)
	{
		var s=i;
	if(document.getElementById("refcheck"+s).checked==false && document.getElementById("reflatertonow"+s).checked==false)
	{
		alert("You have to select all");
				return false;

	}
	}*/
	
	
	if(parseFloat(document.getElementById("availablelimit").value.replace(',',''))<parseFloat(document.getElementById("approvallimit").value))
		{
	if(document.getElementById("approve").checked==true){
		if(document.getElementById("approvecomment").value == ''){
			alert("Please Enter the approval comment");
			
			document.getElementById("approvecomment").focus();
			return false;
		}
	}
		}
	
}

function approvalfunction(nam,amount)
{//alert(nam);
	if(document.getElementById(nam).checked==true)
	{
		//alert(amount);
		document.getElementById("approvallimit").value=parseFloat(document.getElementById("approvallimit").value)+parseFloat(amount);
		
		//alert(document.getElementById("availablelimit").value);
		//alert(document.getElementById("approvallimit").value);
		if(document.getElementById("approve").checked==false){
		if(parseFloat(document.getElementById("availablelimit").value.replace(',',''))<parseFloat(document.getElementById("approvallimit").value))
		{	
			alert("Approval Limit is greater than Available Limit");
			document.getElementById("approvallimit").value=parseFloat(document.getElementById("approvallimit").value)-parseFloat(amount);
			document.getElementById(nam).checked = false;
			if(document.getElementById("selectalll").checked == true){
				document.getElementById("selectalll").checked =false;
				}
			}
		}
		/*if(document.getElementById(nam).value==delete)
		{
		document.getElementById("approvallimit").value=parseFloat(document.getElementById("approvallimit").value)-parseFloat(amount);	
		}*/
		//alert(document.getElementById("availablelimit").value);
		//alert(document.getElementById("approvallimit").value);
		
		}
	else
	{
		//alert(amount);
		document.getElementById("approvallimit").value=parseFloat(document.getElementById("approvallimit").value)-parseFloat(amount);
		}
	//var rate=amount;
	//alert(rate);
	
}

function approvalfunction1(nam,amount)
{//alert(nam);
	if(document.getElementById(nam).checked==true)
	{
		//alert(amount);
		document.getElementById("approvallimit").value=parseFloat(document.getElementById("approvallimit").value)-parseFloat(amount);
		/*if(document.getElementById(nam).value==delete)
		{
		document.getElementById("approvallimit").value=parseFloat(document.getElementById("approvallimit").value)-parseFloat(amount);	
		}*/
		}
	
	
}


</script>

<?php $locationcode; ?>

<?php include ("js/dropdownlist1newscriptingmedicine1.php"); ?>
<script type="text/javascript" src="js/autosuggestnewmedicine1.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_newmedicineq.js"></script>
<script type="text/javascript" src="js/automedicinecodesearch2.js"></script>
<script type="text/javascript" src="js/insertnewitemforallamendpharam1.js"></script>
<?php  include ("autocompletebuild_lab1.php"); ?>
<?php include ("js/dropdownlist1scriptinglab1.php"); ?>
<script type="text/javascript" src="js/autocomplete_lab1.js"></script>
<script type="text/javascript" src="js/autosuggestlab1.js"></script> 
<script type="text/javascript" src="js/autolabcodesearch22.js"></script>
<script type="text/javascript" src="js/insertnewitemforallamendlab1.js"></script>
<?php include ("js/dropdownlist1scriptingradiology1.php"); ?>
<?php include("autocompletebuild_radiology1.php"); ?>
<script type="text/javascript" src="js/autocomplete_radiology1.js"></script>
<script type="text/javascript" src="js/autosuggestradiology1.js"></script> 
<script type="text/javascript" src="js/autoradiologycodesearch22.js"></script>
<script type="text/javascript" src="js/insertnewitemforallamendrad1.js"></script>
<?php include ("js/dropdownlist1scriptingservices1.php"); ?>
<?php include ("autocompletebuild_services1.php");?>
<script type="text/javascript" src="js/autocomplete_services1.js"></script>
<script type="text/javascript" src="js/autosuggestservices1.js"></script>
<script type="text/javascript" src="js/autoservicescodesearch22.js"></script>
<script type="text/javascript" src="js/insertnewitemforallamend1.js"></script>

<?php include ("js/dropdownlist1scriptingreferal.php"); ?>
<?php include ("autocompletebuild_referal.php"); ?>
<script type="text/javascript" src="js/autocomplete_referal.js"></script>
<script type="text/javascript" src="js/autosuggestreferal1.js"></script>
<script type="text/javascript" src="js/autoreferalcodesearch2.js"></script>

<script type="text/javascript" src="js/insertnewitemforallamendref1.js"></script>






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
.style2 {
	font-size: 18px;
	font-weight: bold;
}
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.bal
{
border-style:none;
background:none;
text-align:right;
FONT-FAMILY: Tahoma;
FONT-SIZE: 11px;
}
</style>

<script src="js/datetimepicker_css.js"></script>

</head>
 <link rel="stylesheet" type="text/css" href="css/autosuggest.css" />  
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="form1" id="frmsales" method="post" action="opamend.php">
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
    <td width="99%" valign="top"><table width="1031" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              
			 
		
			  <tr>
			    <td width="15%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Patient</strong></td>
                <td width="36%" align="left" valign="middle" class="bodytext3">
				<input name="customername" id="customer" type="hidden" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/><?php echo $patientname; ?>
                  </td>
                 <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Patient code </strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3">
				<input name="customercode" id="customercode" type="hidden" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $patientcode; ?>
				
				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>
             
			    </tr>
			   <tr>
			    <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="style4"></span><strong>Age &amp; Gender </strong></td>
			    <td align="left" valign="middle" class="bodytext3">
				<input name="patientage" type="hidden" id="patientage" value="<?php echo $patientage; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $patientage; ?>
				&
				<input type="hidden" name="patientgender" id="patientgender" value="<?php echo $patientgender; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly><?php echo $patientgender; ?>
				<input type="hidden" name="address1" id="address1" value="<?php echo $res41address1; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;" size="30" />
                <input type="hidden" name="locationcode" id="locationcode" value="<?php echo $locationcode; ?>" >
                <input type="hidden" name="locationname" id="locationname" value="<?php echo $locationname; ?>" >
			      <span class="style4"><!--Area--> </span>
			      <input type="hidden" name="area" id="area" value="<?php echo $res41area; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="10" />
				  <input type="hidden" name="subtype" id="subtype" value="<?php echo $res131subtype; ?>">
				  </td>
				    <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Account</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3">
				<input name="account" id="account" type="hidden" value="<?php echo $patientaccount; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $patientaccount; ?>
				<input type="hidden" name="billtype" value="<?php echo $billtype; ?>">		
				<input type="hidden" name="billtypes" id="billtypes" value="<?php echo $billtype; ?>">	
				
				<input type="hidden" name="paymenttype" id="payment" value="<?php echo $res121paymenttype; ?>" readonly   size="20" />			  		  </tr>
				  <tr>
				  <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Visit Code</strong></td>
                <td colspan="1" align="left" valign="top" class="bodytext3" >
				<input name="visitcode" id="visitcode" type="hidden" value="<?php echo $visitcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/><?php echo $visitcode; ?>
				<td colspan="1" align="left" valign="top" class="bodytext3" ><strong>Doc Number</strong></td>
				<td colspan="1" align="left" valign="top" class="bodytext3" ><?php echo $billnumbercode; ?></td>
				  </tr>
            
           <?php 
            $selecttotal=0;
			
             $availablelimit1=0;
				   $consultationfees=0;
				   $planfixedamount=0;
				   $visitlimit1=0;
				   $overalllimit1=0;
				  $query223="select * from master_visitentry where patientcode = '$patientcode' and visitcode='$visitcode'";
					$exec223=mysql_query($query223) or die(mysql_error());
					$res223=mysql_fetch_array($exec223);
					 mysql_num_rows($exec223);
					 
				   $availablelimit1=$res223['availablelimit'];
				   $overalllimit1=$res223['overalllimit'];
				   
				   $planname=$res223['planname'];
				   $consultationfees=$res223['consultationfees'];
				   
				   //$availableilimit = 
				   $query222 = "select * from master_planname where auto_number = '$planname'";
				   $exec222=mysql_query($query222) or die(mysql_error());
					$res222=mysql_fetch_array($exec222);
					$planfixedamount=$res222['planfixedamount'];
					$visitlimit1=$res222['opvisitlimit'];
					if($visitlimit1 > 0)
					{
					$availablelimit1 = $visitlimit1;
					}
				  // echo $planfixedamount;
				   $availablelimit=$availablelimit1+$planfixedamount-($consultationfees);
				   $viscode = $visitcode;
				      
					    $billedrate=0;
				    $querybilrad="select sum(radiologyitemrate) as radiologyrate from consultation_radiology where patientcode = '$patientcode' and patientvisitcode='$viscode' and paymentstatus = 'completed' and approvalstatus <> '2' and radiologyrefund <> 'refund'";
					$execbilrad=mysql_query($querybilrad) or die(mysql_error());
					$resbilrad=mysql_fetch_array($execbilrad);
					$radrate=$resbilrad['radiologyrate'];
					$billedrate = $billedrate+$radrate;
				
				 
				    $querybilref="select sum(referalrate) as referalrate from consultation_referal where patientcode = '$patientcode' and patientvisitcode='$viscode' and paymentstatus = 'completed' and referalrefund <> 'refund'";
					$execbilref=mysql_query($querybilref) or die(mysql_error());
					$resbilref=mysql_fetch_array($execbilref);
					$refrate=$resbilref['referalrate'];
					$billedrate = $billedrate+$refrate;
				
				  $querybilref1="select sum(referalrate) as referalrate from consultation_departmentreferal where patientcode = '$patientcode' and patientvisitcode='$viscode' and paymentstatus = 'completed' and referalrefund <> 'refund'";
					$execbilref1=mysql_query($querybilref1) or die(mysql_error());
					$resbilref1=mysql_fetch_array($execbilref1);
					$refrate1=$resbilref1['referalrate'];
					$billedrate = $billedrate+$refrate1;
				
				$serrate=0;
				  $querybilser="select servicesitemrate*(serviceqty-refundquantity) as servicerate from consultation_services where patientcode = '$patientcode' and patientvisitcode='$viscode' and paymentstatus = 'completed' and approvalstatus <> '2' ";
					$execbilser=mysql_query($querybilser) or die(mysql_error());
					while($resbilser=mysql_fetch_array($execbilser))
					{
					$serrate1=$resbilser['servicerate'];
					$serrate=$serrate+$serrate1;
					}
					$billedrate = $billedrate+$serrate;
				
				   $querybillab="select sum(labitemrate) as labrate from consultation_lab where patientcode = '$patientcode' and patientvisitcode='$viscode' and paymentstatus = 'completed' and approvalstatus <> '2' and labrefund <> 'refund'";
					$execbillab=mysql_query($querybillab) or die(mysql_error());
					$resbillab=mysql_fetch_array($execbillab);
					$labrate=$resbillab['labrate'];
					$billedrate = $billedrate+$labrate;
				
					$pharmrefund=0;
					 $querybilpharm="select amount as pharmrate,medicinecode from master_consultationpharm  where patientcode = '$patientcode' and  patientvisitcode='$viscode' and  paymentstatus = 'completed' and  approvalstatus <> '2' ";
					$execbilpharm=mysql_query($querybilpharm) or die(mysql_error());
					while ($resbilpharm=mysql_fetch_array($execbilpharm))
					{
					$pharmrate=$resbilpharm['pharmrate'];
					$medicinecode=$resbilpharm['medicinecode'];
					 $querybilpharm1="select totalamount as refundpharm from pharmacysalesreturn_details  where patientcode = '$patientcode' and  visitcode='$viscode' and itemcode ='".$medicinecode."' ";
					 $execbilpharm1=mysql_query($querybilpharm1) or die(mysql_error());
					while ($resbilpharm1=mysql_fetch_array($execbilpharm1))
					{
						$pharmrate1=$resbilpharm1['refundpharm'];
						$pharmrefund=$pharmrefund+$pharmrate1;
						}
						$pharmcalcrate=$pharmcalcrate+($pharmrate-$pharmrefund);
					}
					
				 	$billedrate = $billedrate+$pharmcalcrate;
					$availablelimit;
				 
					 $availablelimit=$availablelimit-$billedrate;
				
            ?>
      
	  
	  <tr>
	  <td  colspan="1" class="bodytext3">Select All <input type="checkbox" value="selectall" name="selectalll" id="selectalll" onClick="selectall();"> </td>
    
	    <td class="bodytext3"><strong>Available limit:</strong>
        
        <input size="8" type="text" name="availablelimit" id="availablelimit"  value="<?php echo number_format($availablelimit, 2, '.', ','); ?>" readonly ><span class="style2" align="right">Grand Total</span></td>
        
		 	  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><input type="text" id="grandtotal" value="<?php echo number_format($grandtotal,2,'.',','); ?>" readonly size="7"></td>
		   <input type="hidden" name="hidgrandtotal" id="hidgrandtotal" value="<?php echo number_format($grandtotal,2,'.',','); ?>">
        <td class="bodytext3"><strong>Approval limit:</strong></td>
        <td class="bodytext3">
        <input size="8" type="text" name="approvallimit" id="approvallimit"  value="<?php echo number_format($approvallimit, 2, '.', ','); ?>" readonly  ></td>
     	
	  </tr>
      </tbody>
        </table></td>
	
	  <?php
	  if($billtype == 'PAY NOW')
			{
				$status='pending';
			}
			else
			{
				$status='pending';
			}
		$query171nums = "select * from master_consultationpharm where patientvisitcode='$visitcode' and patientcode='$patientcode' and medicineissue='pending' and paymentstatus!='completed' and approvalstatus<>'2'";
		$exec171nums = mysql_query($query171nums) or die ("Error in Query171nums".mysql_error());
		$nums171 = mysql_num_rows($exec171nums);
		$query172nums = "select * from master_consultationpharm where patientvisitcode='$visitcode' and patientcode='$patientcode' and medicineissue='pending' and pharmacybill='pending' and approvalstatus='2'";
		$exec172nums = mysql_query($query172nums) or die ("Error in Query172nums".mysql_error());
		$nums172=mysql_num_rows($exec172nums);
		$query173nums = "select * from master_consultationpharm where patientvisitcode='$visitcode' and patientcode='$patientcode' and medicineissue='pending' and paymentstatus='completed' and approvalstatus='1'";
		$exec173nums = mysql_query($query173nums) or die ("Error in Query173nums".mysql_error());
		$nums173 = mysql_num_rows($exec173nums);
		$nums17pharam = $nums171 + $nums172 + $nums173;
	  ?>
	 
	  <tr>
	  <td width="90%" bgcolor="#CCCCCC" class="bodytext3"><strong>Prescription </strong></td>
	  </tr>
       <?php
	  if($nums17pharam>0)
	  {
	  ?>
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
            <tr>
			<?php if($billtype == 'PAY LATER')
				{
				?>
			<td width="6%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Select</strong></div></td>
				<?php } ?>
              <td width="6%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				
				<td width="12%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Medicine Name</strong></div></td>
				<td width="12%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Dose</strong></div></td>
			
			<td width="12%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Freq</strong></div></td>
			
			<td width="12%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Days </strong></div></td>
				<td width="12%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Quantity </strong></div></td>
			<td width="12%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Route </strong></div></td>
				<td width="12%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Instructions </strong></div></td>

				<td width="12%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate  </strong></div></td>
					<td width="12%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount </strong></div></td>
				<td width="12%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Action </strong></div></td>
				<?php if($billtype == 'PAY LATER')
				{
				?>
				<td width="18%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Cash </strong></div></td>
				<?php } ?>
                  </tr>
				  
			<?php
			
			$grandtotal='';
			$colorloopcount = '';
			$sno = '';
			$totalamount=0;
			
			if($billtype == 'PAY NOW')
			{
				$status='pending';
			}
			else
			{
				$status='pending';
			}
	
			$query17 = "select * from master_consultationpharm where patientvisitcode='$visitcode' and patientcode='$patientcode' and medicineissue='pending' and  ((billing <> 'completed' and approvalstatus <> '1') OR (approvalstatus <> '2'))";
			$exec17 = mysql_query($query17) or die ("Error in Query1".mysql_error());
			$nums=mysql_num_rows($exec17);
			while ($res17 = mysql_fetch_array($exec17))
			{
			
				$paharmitemname=$res17['medicinename'];
				$pharmitemcode=$res17['medicinecode'];
				$pharmdose=$res17['dose'];
				$pharmfrequency=$res17['frequencynumber'];
				$pharmdays=$res17['days'];
				$pharmquantity=$res17['quantity'];
				$pharmitemrate=$res17['rate'];
				$pharmamount=$res17['amount'];
				$route = $res17['route'];
				$instructions = $res17['instructions'];
				$medanum = $res17['medicinecode'];
				$excludestatus=$res17['excludestatus'];
				$excludebill = $res17['excludebill'];
				$approvalstatus=$res17['approvalstatus'];
				$pharmacybill = $res17['pharmacybill'];
				$query77="select * from master_medicine where itemcode='$pharmitemcode'";
				$exec77=mysql_query($query77);
				$res77=mysql_fetch_array($exec77);
				$formula = $res77['formula'];
				$strength = $res77['roq'];
			
		if((($excludestatus == '')&&($excludebill == ''))||(($excludestatus == 'excluded')&&($excludebill == '')))
			{
			$grandtotal = $grandtotal + $pharmamount;
			$colorloopcount = $colorloopcount + 1;
			$sno = $sno + 1;
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
			if($excludestatus == 'excluded'){$colorcode = 'bgcolor="#FF99FF"';}
			$totalamount=$totalamount+$pharmitemrate;
			$totalamount=number_format($totalamount,2);
			?>
			  <tr <?php echo $colorcode; ?>>
			  <?php if($billtype == 'PAY LATER')
				{
				?>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" id="pharamcheck<?php echo $sno; ?>" name="pharamcheck[<?php echo $sno; ?>]" value="<?php echo $medanum; ?>" <?php if($approvalstatus=='1'){ echo "checked=checked";}?> onClick="selectselect('pharam','<?php echo $sno; ?>'), approvalfunction(this.id,<?php echo $pharmamount; ?>)"/>
			  <input type="hidden" name="pharamanum[<?php echo $sno; ?>]" id="pharamanum<?php echo $sno; ?>"  value="<?php echo $medanum; ?>">
			  </div></td>
			  <?php } ?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno; ?></div></td>
			    <input type="hidden" name="aitemcode[]" id="aitemcode<?php echo $sno; ?>" value="<?php echo $pharmitemcode; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $paharmitemname; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="adose[]" id="adose<?php echo $sno; ?>" onKeyUp="return Functionfrequency('<?php echo $sno; ?>')" value="<?php echo $pharmdose; ?>" size="8" style="text-align:center;"></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center">
				 <input type="hidden" name="aformula" id="aformula<?php echo $sno; ?>" value="<?php echo $formula; ?>">
				 <input type="hidden" name="astrength" id="astrength<?php echo $sno; ?>" value="<?php echo $strength; ?>">
				 <input type="hidden" name="genericname" id="genericname">	
				  <input type="hidden" name="drugallergy" id="drugallergy">
				  <input type="hidden" name="exclude" id="exclude">	
				 <select name="afrequency[]" id="afrequency<?php echo $sno; ?>" onChange="return Functionfrequency('<?php echo $sno; ?>')">
				  <?php
				if ($pharmfrequency == '')
				{
					echo '<option value="select" selected="selected">Select frequency</option>';
				}
				else
				{
					$query51 = "select * from master_frequency where frequencynumber='$pharmfrequency' and recordstatus = ''";
					$exec51 = mysql_query($query51) or die ("Error in Query51".mysql_error());
					$res51 = mysql_fetch_array($exec51);
					$res51code = $res51["frequencycode"];
					$res51num = $res51['frequencynumber'];
					echo '<option value="'.$res51num.'" selected="selected">'.$res51code.'</option>';
				}
				$query5 = "select * from master_frequency where recordstatus = '' order by auto_number";
				$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
				while ($res5 = mysql_fetch_array($exec5))
				{
				$res5num = $res5["frequencynumber"];
				$res5code = $res5["frequencycode"];
				?>
                <option value="<?php echo $res5num; ?>"><?php echo $res5code; ?></option>
                 <?php
				}
				?>
				</select>
				 </div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="adays[]" id="adays<?php echo $sno; ?>" onKeyUp="return Functionfrequency('<?php echo $sno; ?>')" value="<?php echo $pharmdays; ?>" size="8" style="text-align:center;"></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="aquantity[]" id="aquantity<?php echo $sno; ?>" value="<?php echo $pharmquantity; ?>" size="8" class="bal" readonly></div></td>
				<td class="bodytext31" valign="center"  align="left">
			<select name="aroute[]" id="aroute">
			  <?php
				if ($route == '')
				{
					echo '<option value="select" selected="selected">Select Route</option>';
				}
				else
				{
				
				echo '<option value="'.$route.'" selected="selected">'.$route.'</option>';
				}
				?>
					  
					   <option value="Oral">Oral</option>
					   <option value="Sublingual">Sublingual</option>
					   <option value="Rectal">Rectal</option>
					   <option value="Vaginal">Vaginal</option>
					   <option value="Topical">Topical</option>
					   <option value="Intravenous">Intravenous</option>
					   <option value="Intramuscular">Intramuscular</option>
					   <option value="Subcutaneous">Subcutaneous</option>  
					   </select>	
				</td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="ainstructions[]" id="ainstructions<?php echo $sno; ?>" value="<?php echo $instructions; ?>" size="15"></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="arate[]" id="arate<?php echo $sno; ?>" value="<?php echo $pharmitemrate; ?>" size="8" class="bal" readonly></div></td>
				
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="aamount[]" id="aamount<?php echo $sno; ?>" value="<?php echo $pharmamount; ?>" size="8" class="bal" readonly></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center">
				 <a onClick="return deletevalid()" href="opamend.php?delete=<?php echo $medanum; ?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&remove=pharm">Delete</a>
				 </div></td>
				 <?php if($billtype == 'PAY LATER')
				{
				?>
				<td class="bodytext31" valign="center"  align="left"><div align="center">
				<input type="checkbox" name="pharamlatertonow[<?php echo $sno; ?>]" id="pharamlatertonow<?php echo $sno; ?>" value="<?php echo $medanum; ?>" onClick="selectcash('pharam','<?php echo $sno; ?>')" <?php if($approvalstatus=='1'){ echo "disabled=disabled";} if($approvalstatus=='2'){ echo "checked=checked";}?>>
				</div></td>
				<?php } ?>
				</tr>
			<?php 
			} 
			}?>
            				  	

			<!--<?php 
			$query17 = "select * from master_consultationpharm where patientvisitcode='$visitcode' and patientcode='$patientcode' and medicineissue='pending' and pharmacybill='pending' and approvalstatus='2'";
			$exec17 = mysql_query($query17) or die ("Error in Query1".mysql_error());
			$nums=mysql_num_rows($exec17);
			while ($res17 = mysql_fetch_array($exec17))
			{
			
				$paharmitemname=$res17['medicinename'];
				$pharmitemcode=$res17['medicinecode'];
				$pharmdose=$res17['dose'];
				$pharmfrequency=$res17['frequencynumber'];
				$pharmdays=$res17['days'];
				$pharmquantity=$res17['quantity'];
				$pharmitemrate=$res17['rate'];
				$pharmamount=$res17['amount'];
				$route = $res17['route'];
				$instructions = $res17['instructions'];
				$medanum = $res17['medicinecode'];
				$excludestatus=$res17['excludestatus'];
				$excludebill = $res17['excludebill'];
				$approvalstatus=$res17['approvalstatus'];
				$pharmacybill = $res17['pharmacybill'];
				$query77="select * from master_medicine where itemcode='$pharmitemcode'";
				$exec77=mysql_query($query77);
				$res77=mysql_fetch_array($exec77);
				$formula = $res77['formula'];
				$strength = $res77['roq'];
			
		if((($excludestatus == '')&&($excludebill == ''))||(($excludestatus == 'excluded')&&($excludebill == '')))
			{
			$grandtotal = $grandtotal + $pharmitemrate;
			$colorloopcount = $colorloopcount + 1;
			$sno=$sno+1;
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
			if($excludestatus == 'excluded'){$colorcode = 'bgcolor="#FF99FF"';}
			$totalamount=$totalamount+$pharmamount;
			$totalamount=number_format($totalamount,2);
			?>
			  <tr <?php echo $colorcode; ?>>
			  <?php if($billtype == 'PAY LATER')
				{
				?>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" id="pharamcheck<?php echo $sno; ?>" name="pharamcheck[<?php echo $sno; ?>]" value="<?php echo $medanum; ?>" <?php if($approvalstatus=='2'){ echo "disabled=disabled";}?> onClick="selectselect('pharam','<?php echo $sno; ?>')"/>
			  <input type="hidden" name="pharamanum[<?php echo $sno; ?>]" id="pharamanum<?php echo $sno; ?>"  value="<?php echo $medanum; ?>">
			  </div></td>
			  <?php } ?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno; ?></div></td>
			    <input type="hidden" name="aitemcode[]" id="aitemcode<?php echo $sno; ?>" value="<?php echo $pharmitemcode; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $paharmitemname; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="adose[]" id="adose<?php echo $sno; ?>" onKeyUp="return Functionfrequency('<?php echo $sno; ?>')" value="<?php echo $pharmdose; ?>" size="8" style="text-align:center;"></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center">
				 <input type="hidden" name="aformula" id="aformula<?php echo $sno; ?>" value="<?php echo $formula; ?>">
				 <input type="hidden" name="astrength" id="astrength<?php echo $sno; ?>" value="<?php echo $strength; ?>">

				  
				 <select name="afrequency[]" id="afrequency<?php echo $sno; ?>" onChange="return Functionfrequency('<?php echo $sno; ?>')">
				  <?php
				if ($pharmfrequency == '')
				{
					echo '<option value="select" selected="selected">Select frequency</option>';
				}
				else
				{
					$query51 = "select * from master_frequency where frequencynumber='$pharmfrequency' and recordstatus = ''";
					$exec51 = mysql_query($query51) or die ("Error in Query51".mysql_error());
					$res51 = mysql_fetch_array($exec51);
					$res51code = $res51["frequencycode"];
					$res51num = $res51['frequencynumber'];
					echo '<option value="'.$res51num.'" selected="selected">'.$res51code.'</option>';
				}
				$query5 = "select * from master_frequency where recordstatus = '' order by auto_number";
				$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
				while ($res5 = mysql_fetch_array($exec5))
				{
				$res5num = $res5["frequencynumber"];
				$res5code = $res5["frequencycode"];
				?>
                <option value="<?php echo $res5num; ?>"><?php echo $res5code; ?></option>
                 <?php
				}
				?>
				</select>
				 </div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="adays[]" id="adays<?php echo $sno; ?>" onKeyUp="return Functionfrequency('<?php echo $sno; ?>')" value="<?php echo $pharmdays; ?>" size="8" style="text-align:center;"></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="aquantity[]" id="aquantity<?php echo $sno; ?>" value="<?php echo $pharmquantity; ?>" size="8" class="bal" readonly></div></td>
				<td class="bodytext31" valign="center"  align="left">
			<select name="aroute[]" id="aroute">
			  <?php
				if ($route == '')
				{
					echo '<option value="select" selected="selected">Select Route</option>';
				}
				else
				{
				
				echo '<option value="'.$route.'" selected="selected">'.$route.'</option>';
				}
				?>
					  
					   <option value="Oral">Oral</option>
					   <option value="Sublingual">Sublingual</option>
					   <option value="Rectal">Rectal</option>
					   <option value="Vaginal">Vaginal</option>
					   <option value="Topical">Topical</option>
					   <option value="Intravenous">Intravenous</option>
					   <option value="Intramuscular">Intramuscular</option>
					   <option value="Subcutaneous">Subcutaneous</option>
					   </select>	
				</td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="ainstructions[]" id="ainstructions<?php echo $sno; ?>" value="<?php echo $instructions; ?>" size="15"></div></td>

				 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="arate[]" id="arate<?php echo $sno; ?>" value="<?php echo $pharmitemrate; ?>" size="8" class="bal" readonly></div></td>
				
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="text" name="aamount[]" id="aamount<?php echo $sno; ?>" value="<?php echo $pharmamount; ?>" size="8" class="bal" readonly></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center">
				 <a onClick="return deletevalid()" href="opamend.php?delete=<?php echo $medanum; ?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&remove=pharm">Delete</a>
				 </div></td>
				 <?php if($billtype == 'PAY LATER')
				{
				?>
				<td class="bodytext31" valign="center"  align="left"><div align="center">
				<input type="checkbox" name="pharamlatertonow[<?php echo $sno; ?>]" id="pharamlatertonow<?php echo $sno; ?>" value="<?php echo $medanum; ?>" onClick="selectcash('pharam','<?php echo $sno; ?>')" <?php if($approvalstatus=='2'){ echo "checked=checked";}?>>
				</div></td>
				<?php } ?>
				</tr>
			<?php 
			} 
			}?>-->
			  
           
          </tbody>
        </table>		</td>
      </tr>
	  <?php } ?> <input type="hidden" name="pharmacysno" id="pharmacysno" value="<?php echo $sno; ?>">
      <tr>
	   <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Prescribe Medicine</strong></td>
	 
	  </tr>
     <tr id="pressid">
				   <td colspan="11" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
				   <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="150" class="bodytext3">Medicine Name</td>
                       <td width="48" class="bodytext3">Dose</td>
                       <td width="41" class="bodytext3">Freq</td>
                       <td width="48" class="bodytext3">Days</td>
                       <td width="48" class="bodytext3">Quantity</td>
					    <td width="48" class="bodytext3">Route</td>
                       <td width="120" class="bodytext3">Instructions</td>
                       <td class="bodytext3">Rate</td>
                       <td width="48" class="bodytext3">Amount</td>
                       <td width="42" class="bodytext3">&nbsp;</td>
                     </tr>
					 <tr>
					 <div id="insertrow">					 </div></tr>
                     <tr>
					  <input type="hidden" name="serialnumber" id="serialnumber" value="1">
					  <input type="hidden" name="medicinecode" id="medicinecode" value="">
					     <input name="searchmedicinename1hiddentextbox" id="searchmedicinename1hiddentextbox" type="hidden" value="">
			           <input name="searchmedicineanum1" id="searchmedicineanum1" value="" type="hidden">
					   <input type="hidden" name="genericname" id="genericname">	
				  		<input type="hidden" name="drugallergy" id="drugallergy">
						<input type="hidden" name="exclude[]" id="exclude">	
                       <td><input name="medicinename[]" type="text" id="medicinename" size="40" autocomplete="off" onKeyDown="return StateSuggestionspharm4()" onKeyUp="return funcCustomerDropDownSearch4()"></td>
                       <td><input name="dose" type="text" id="dose" size="8" onKeyUp="return Functionfrequency1()"></td>
                       <td>
					    <input name="formula" type="hidden" id="formula" readonly size="8">
						<input name="strength" type="hidden" id="strength" readonly size="8">
					   <select name="frequency[]" id="frequency" onChange="return Functionfrequency1()">
					     <?php
				if ($frequncy == '')
				{
					echo '<option value="select" selected="selected">Select frequency</option>';
				}
				else
				{
					$query51 = "select * from master_frequency where recordstatus = ''";
					$exec51 = mysql_query($query51) or die ("Error in Query51".mysql_error());
					$res51 = mysql_fetch_array($exec51);
					$res51code = $res51["frequencycode"];
					$res51num = $res51['frequencynumber'];
					echo '<option value="'.$res51num.'" selected="selected">'.$res51code.'</option>';
				}
				$query5 = "select * from master_frequency where recordstatus = '' order by auto_number";
				$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
				while ($res5 = mysql_fetch_array($exec5))
				{
				$res5num = $res5["frequencynumber"];
				$res5code = $res5["frequencycode"];
				?>
                <option value="<?php echo $res5num; ?>"><?php echo $res5code; ?></option>
                 <?php
				}
				?>
               </select>				</td>	
                       <td><input name="days[]" type="text" id="days" size="8" onKeyUp="return Functionfrequency1()" onFocus="return frequencyitem()"></td>
                       <td><input name="quantity[]" type="text" id="quantity" size="8" readonly></td>
					    <td><select name="route" id="route">
					   <option value="">Select Route</option>
					   <option value="Oral">Oral</option>
					   <option value="Sublingual">Sublingual</option>
					   <option value="Rectal">Rectal</option>
					   <option value="Vaginal">Vaginal</option>
					   <option value="Topical">Topical</option>
					   <option value="Intravenous">Intravenous</option>
					   <option value="Intramuscular">Intramuscular</option>
					   <option value="Subcutaneous">Subcutaneous</option>
					   </select></td>
                       <td><input name="instructions[]" type="text" id="instructions" size="20"></td>
                       <td width="48"><input name="rates[]" type="text" id="rates" readonly size="8"></td>
                       <td>
                         <input name="amount[]" type="text" id="amount" readonly size="8"></td>
                       <td><label>
                       <input type="button" name="Add" id="Add" value="Add" onClick="return insertitem10()" class="button" >
                       </label></td>
				     </tr>
                     
					 <input type="hidden" name="h" id="h" value="0">
                   </table>				  </td>
          </tr>
		  <tr>
				   <td colspan="8" align="right" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="style2">Dispensing Fee</span><input type="text" name="dispensingfee" id="dispensingfee" size="7" onKeyUp="return calculate();"></td>
			      </tr>
				    <tr>
				   <td colspan="8" align="right" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="style2">Total Amount</span><input type="text" id="total" readonly size="7"></td>
			      </tr>
				  
				 <?php
				if($billtype == 'PAY NOW')
				{
				$status='pending';
				}
				else
				{
				$status='pending';
				}
				 $query171lab = "select * from consultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='$status' and labsamplecoll='pending' and approvalstatus<>'2'";
				 $exec171lab = mysql_query($query171lab) or die ("Error in Query171lab".mysql_error());
				 $num171lab = mysql_num_rows($exec171lab);
				 $query172lab = "select * from consultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='pending' and labsamplecoll='pending' and approvalstatus='2'";
				 $exec172lab = mysql_query($query172lab) or die ("Error in Query172lab".mysql_error());
				 $num172lab = mysql_num_rows($exec172lab);
				  $query173lab = "select * from consultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='completed' and labsamplecoll='pending' and approvalstatus='1'";
				 $exec173lab = mysql_query($query173lab) or die ("Error in Query173lab".mysql_error());
				 $num173lab = mysql_num_rows($exec173lab);
				 $num17lab = $num171lab + $num172lab + $num173lab;
				 ?>
				 
		 <tr>
	  <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Lab </strong></td>
	  </tr>
				  <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
		  <?php if($num17lab > 0) {?>
            <tr>
			<?php if($billtype == 'PAY LATER')
				{
				?>
			<td width="6%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Select</strong></div></td>
				<?php } ?>
              <td width="8%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				
				<td width="22%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Lab</strong></div></td>
				<td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate  </strong></div></td>
					<td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount </strong></div></td>
				<td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Action </strong></div></td>
				<?php if($billtype == 'PAY LATER')
				{
				?>
				<td width="19%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Cash </strong></div></td>
				<?php } ?>
                  </tr>
				  		<?php
			$colorloopcount = '';
			$sno = '';
			$totalamount=0;
			if($billtype == 'PAY NOW')
			{
			$status='pending';
			}
			else
			{
			$status='pending';
			}
			$query17 = "select * from consultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode'  and labsamplecoll='pending' and ((paymentstatus = 'pending' and approvalstatus <> '1') OR (approvalstatus <> '2'))"; 
			$exec17 = mysql_query($query17) or die ("Error in Query1".mysql_error());
			while ($res17 = mysql_fetch_array($exec17))
			{
			
				$paharmitemname=$res17['labitemname'];				
				$pharmitemcode=$res17['labitemcode'];
				$pharmitemrate=$res17['labitemrate'];
				$labamount=$res17['pharmitemrate'];
				$labanum=$res17['auto_number'];
				$approvalstatus=$res17['approvalstatus'];
			$grandtotal = $grandtotal + $pharmitemrate;
			$colorloopcount = $colorloopcount + 1;
			$sno=$sno+1;
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
			$totalamount=$totalamount+$pharmitemrate;
			$totalamount=number_format($totalamount,2);
			?>
			  <tr <?php echo $colorcode; ?>>
			  <?php if($billtype == 'PAY LATER')
				{
				?>
			   <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" id="labcheck<?php echo $sno; ?>" name="labcheck[<?php echo $sno; ?>]" value="<?php echo $labanum; ?>"  <?php if($approvalstatus=='1'){ echo "checked=checked"; $selecttotal=$selecttotal+$pharmitemrate;}?> onClick="selectselect('lab','<?php echo $sno; ?>'),approvalfunction(this.id,<?php echo $pharmitemrate; ?>)"/>
			   <input type="hidden" name="labanum[<?php echo $sno; ?>]" id="labanum<?php echo $sno; ?>"  value="<?php echo $labanum; ?>">
			   </div></td>
			   <?php } ?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno; ?></div></td>
			    
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $paharmitemname; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><a onClick="return deletevalid()" href="opamend.php?delete=<?php echo $labanum; ?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&remove=lab">Delete</a></div></td>
				<?php if($billtype == 'PAY LATER')
				{
				?> 
				<td class="bodytext31" valign="center"  align="left"><div align="center">
				<input type="checkbox" name="lablatertonow[<?php echo $sno; ?>]" id="lablatertonow<?php echo $sno; ?>"  onClick="selectcash('lab','<?php echo $sno; ?>')" <?php if($approvalstatus=='1'){ echo "disabled=disabled";}if($approvalstatus=='2'){ echo "checked=checked";}?>>
				</div></td>
				<?php } ?>
				</tr>
			<?php } ?>
            
			<!--<?php
			$query17 = "select * from consultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='pending' and labsamplecoll='pending' and approvalstatus='2'";
			$exec17 = mysql_query($query17) or die ("Error in Query1".mysql_error());
			while ($res17 = mysql_fetch_array($exec17))
			{
			
				$paharmitemname=$res17['labitemname'];				
				$pharmitemcode=$res17['labitemcode'];
				$pharmitemrate=$res17['labitemrate'];
				$labanum=$res17['auto_number'];
				$approvalstatus=$res17['approvalstatus'];
			$grandtotal = $grandtotal + $pharmitemrate;
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$sno=$sno+1;
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
			$totalamount=$totalamount+$pharmitemrate;
			$totalamount=number_format($totalamount,2);
			?>
			  <tr <?php echo $colorcode; ?>>
			  <?php if($billtype == 'PAY LATER')
				{
				?>
			   <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" id="labcheck<?php echo $sno; ?>" name="labcheck[<?php echo $sno; ?>]" value="<?php echo $labanum; ?>"  <?php if($approvalstatus=='1'){ echo "checked=checked";}?> <?php if($approvalstatus=='2'){ echo "disabled=disabled";}?> onClick="selectselect('lab','<?php echo $sno; ?>')"/>
			   <input type="hidden" name="labanum[<?php echo $sno; ?>]" id="labanum<?php echo $sno; ?>"  value="<?php echo $labanum; ?>">
			   </div></td>
			   <?php } ?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno; ?></div></td>
			    
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $paharmitemname; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><a onClick="return deletevalid()" href="opamend.php?delete=<?php echo $labanum; ?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&remove=lab">Delete</a></div></td>
				<?php if($billtype == 'PAY LATER')
				{
				?>
				<td class="bodytext31" valign="center"  align="left"><div align="center">
				<input type="checkbox" name="lablatertonow[<?php echo $sno; ?>]" id="lablatertonow<?php echo $sno; ?>"  onClick="selectcash('lab','<?php echo $sno; ?>')" <?php if($approvalstatus=='2'){ echo "checked=checked";}?>>
				</div></td>
				<?php } ?>
				</tr>
			<?php } ?> -->
			 <tr>
			<?php } ?> <input type="hidden" name="labsno" id="labsno" value="<?php echo $sno; ?>">
	   <td colspan="7" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Add Lab Tests</strong></td>
	 
	  </tr>
			<tr id="labid">
				   <td colspan="9" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
				     <table width="621" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="30" class="bodytext3">Laboratory Test</td>
                       <td class="bodytext3">Rate</td>
                       <td width="30" class="bodytext3">&nbsp;</td>
                     </tr>
					  <tr>
					 <div id="insertrow1">					 </div></tr>
					  <tr>
					  <input type="hidden" name="serialnumber1" id="serialnumber1" value="1">
					  <input type="hidden" name="labcode" id="labcode" value="">
				      <td width="30"><input name="lab[]" id="lab" type="text" size="69" autocomplete="off" ></td>
				      <td width="30"><input name="rate5[]" type="text" id="rate5" readonly size="8"></td>
					  <td><label>
                       <input type="button" name="Add1" id="Add1" value="Add" onClick="return insertitem6()" class="button" >
                       </label></td>
					   </tr>
					    </table>	  </td> 
					
				      </tr>
					  <tr>
				   <td colspan="8" align="right" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="style2">Total Amount</span><input type="text" id="total1" readonly size="7"></td>
				  </tr>
			             
          </tbody>
        </table>		</td>
      </tr>
	  <?php 
	  if($billtype == 'PAY NOW')
	{
		$status='pending';
	}
	else
	{
		$status='pending';
	}
		$query171rad = "select * from consultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='$status' and resultentry='pending' and approvalstatus<>'2'";
		$exec171rad = mysql_query($query171rad) or die ("Error in Query171rad".mysql_error());
		$num171rad  = mysql_num_rows($exec171rad);
		$query172rad = "select * from consultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='pending' and resultentry='pending' and approvalstatus='2'";
		$exec172rad = mysql_query($query172rad) or die ("Error in Query1".mysql_error());
		$num172rad  = mysql_num_rows($exec172rad);
		$query173rad = "select * from consultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='completed' and resultentry='pending' and approvalstatus='1'";
		$exec173rad = mysql_query($query173rad) or die ("Error in Query1".mysql_error());
		$num173rad  = mysql_num_rows($exec173rad);
		$num17rad = $num171rad + $num172rad + $num173rad;
	  ?>
	   <tr>
	  <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Radiology </strong></td>
	  </tr>
	  <?php if($num17rad>0)
	  { ?>
	  <tr>	  
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
            <tr>
			<?php if($billtype == 'PAY LATER')
				{
				?>
			<td width="5%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Select</strong></div></td>
				<?php }?>
              <td width="7%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				
				<td width="21%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Radiology</strong></div></td>
				<td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate  </strong></div></td>
					<td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount </strong></div></td>
				<td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Action </strong></div></td>
				<?php if($billtype == 'PAY LATER')
				{
				?>
              	<td width="18%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Cash </strong></div></td>
				<?php } ?>
                  </tr>
				  		<?php 
			$colorloopcount = '';
			$sno = '';
			$totalamount=0;
			if($billtype == 'PAY NOW')
			{
			$status='pending';
			}
			else
			{
			$status='pending';
			}
			$query17 = "select * from consultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode'  and resultentry='pending' and ((paymentstatus = 'pending' and approvalstatus <> '1') OR (approvalstatus <> '2'))";
			$exec17 = mysql_query($query17) or die ("Error in Query1".mysql_error());
			while ($res17 = mysql_fetch_array($exec17))
			{
			
			$paharmitemname=$res17['radiologyitemname'];				
			$pharmitemcode=$res17['radiologyitemcode'];
			$pharmitemrate=$res17['radiologyitemrate'];
			$radanum=$res17['auto_number'];
			$approvalstatus=$res17['approvalstatus'];	
			$grandtotal = $grandtotal + $pharmitemrate;
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$sno=$sno+1;
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
			$totalamount=$totalamount+$pharmitemrate;
			$totalamount=number_format($totalamount,2);
			?>
			  <tr <?php echo $colorcode; ?>>
			  <?php if($billtype == 'PAY LATER')
				{
				?>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" id="radcheck<?php echo $sno; ?>" name="radcheck[<?php echo $sno; ?>]" value="<?php echo $radanum; ?>"  <?php if($approvalstatus=='1'){ echo "checked=checked";  $selecttotal=$selecttotal+$pharmitemrate;}?> onClick="selectselect('rad','<?php echo $sno; ?>'), approvalfunction(this.id,<?php echo $pharmitemrate; ?>)"/>
			  <input type="hidden" name="radanum[<?php echo $sno; ?>]" id="radanum<?php echo $sno; ?>"  value="<?php echo $radanum; ?>">
			  </div></td>
			  <?php } ?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno; ?></div></td>
			   
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $paharmitemname; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left"><div align="center"><a onClick="return deletevalid()" href="opamend.php?delete=<?php echo $radanum; ?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&remove=radiology">Delete</a></div></td>
				<?php if($billtype == 'PAY LATER')
				{
				?>  
				<td class="bodytext31" valign="center"  align="left"><div align="center">
				<input type="checkbox" name="radlatertonow[<?php echo $sno; ?>]" id="radlatertonow<?php echo $sno; ?>" onClick="selectcash('rad','<?php echo $sno; ?>')" <?php if($approvalstatus=='1'){ echo "disabled=disabled";}if($approvalstatus=='2'){ echo "checked=checked";}?>>
				</div></td>
				<?php } ?>
				</tr>
			<?php } ?> 
			<!-- <?php
            $query17 = "select * from consultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='pending' and resultentry='pending' and approvalstatus='2'";
			$exec17 = mysql_query($query17) or die ("Error in Query1".mysql_error());
			while ($res17 = mysql_fetch_array($exec17))
			{
			
			$paharmitemname=$res17['radiologyitemname'];				
			$pharmitemcode=$res17['radiologyitemcode'];
			$pharmitemrate=$res17['radiologyitemrate'];
			$radanum=$res17['auto_number'];
			$approvalstatus=$res17['approvalstatus'];	
			$grandtotal = $grandtotal + $pharmitemrate;
			$colorloopcount = $colorloopcount + 1;
			$sno=$sno+1;
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
			$totalamount=$totalamount+$pharmitemrate;
			$totalamount=number_format($totalamount,2);
			?>
			  <tr <?php echo $colorcode; ?>>
			  <?php if($billtype == 'PAY LATER')
				{
				?>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" id="radcheck<?php echo $sno; ?>" name="radcheck[<?php echo $sno; ?>]" value="<?php echo $radanum; ?>"  <?php if($approvalstatus=='1'){ echo "checked=checked";}?> <?php if($approvalstatus=='2'){ echo "disabled=disabled";}?> onClick="selectselect('rad','<?php echo $sno; ?>')"/>
			  <input type="hidden" name="radanum[<?php echo $sno; ?>]" id="radanum<?php echo $sno; ?>"  value="<?php echo $radanum; ?>">
			  </div></td>
			  <?php } ?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno; ?></div></td>
			   
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $paharmitemname; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left"><div align="center"><a onClick="return deletevalid()" href="opamend.php?delete=<?php echo $radanum; ?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&remove=radiology">Delete</a></div></td>
				<?php if($billtype == 'PAY LATER')
				{
				?>
				<td class="bodytext31" valign="center"  align="left"><div align="center">
				<input type="checkbox" name="radlatertonow[<?php echo $sno; ?>]" id="radlatertonow<?php echo $sno; ?>" onClick="selectcash('rad','<?php echo $sno; ?>')" <?php if($approvalstatus=='2'){ echo "checked=checked";}?>>
				</div></td>
				<?php } ?>
				</tr>
			<?php } ?>-->
          </tbody>
        </table>		</td>
      </tr>
	  <?php } ?> <input type="hidden" name="radsno" id="radsno" value="<?php echo $sno; ?>">
      <tr>
	   <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Add Radiology Tests</strong></td>
	 
	  </tr>
     <tr id="radid">
				   <td colspan="9" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
				    <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="30" class="bodytext3">Radiology Test</td>
                       <td class="bodytext3">Rate</td>
                       <td width="30" class="bodytext3">&nbsp;</td>
                     </tr>
					  <tr>
					 <div id="insertrow2">					 </div></tr>
					  <tr>
					  <input type="hidden" name="serialnumber2" id="serialnumber2" value="1">
					  <input type="hidden" name="radiologycode" id="radiologycode" value="">
				   <td width="30"> <input name="radiology[]" id="radiology" type="text" size="69" autocomplete="off"></td>
				      <td width="30"><input name="rate8[]" type="text" id="rate8" readonly size="8"></td>
					   <td><label>
                       <input type="button" name="Add2" id="Add2" value="Add" onClick="return insertitem7()" class="button" >
                       </label></td>
					   </tr>
					    </table>
						</td>
						
		       </tr>
				
				 <tr>
				   <td colspan="6" align="right" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="style2">Total Amount</span><input type="text" id="total2" readonly size="7"></td>
				   </tr>
				   <?php 
			   if($billtype == 'PAY NOW')
				{
					$status='pending';
				}
				else
				{
					$status='pending';
				}
			$query171ser = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='$status' and process='pending' and approvalstatus<>'2'";
			$exec171ser = mysql_query($query171ser) or die ("Error in Query1".mysql_error());
			$num171ser = mysql_num_rows($exec171ser);
			$query172ser = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='pending' and process='pending' and approvalstatus='2'";
			$exec172ser = mysql_query($query172ser) or die ("Error in Query1".mysql_error());
			$num172ser = mysql_num_rows($exec172ser);
			$query173ser = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='completed' and process='pending' and approvalstatus='1'";
			$exec173ser = mysql_query($query173ser) or die ("Error in Query1".mysql_error());
			$num173ser = mysql_num_rows($exec173ser);
			$num17ser = $num171ser + $num172ser;
			?>
			 <tr>
	  <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Services </strong></td>
	  </tr>
	  <?php
	  if($num17ser>0)
	  {
	  ?>
		<tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
            <tr>
			<?php if($billtype == 'PAY LATER')
				{
				?>
			<td width="5%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Select</strong></div></td>
				<?php } ?>
              <td width="7%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				
				<td width="21%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Services</strong></div></td>
				<td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate  </strong></div></td>
                <td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Service Qty  </strong></div></td>
					<td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount </strong></div></td>
				<td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Action </strong></div></td>
				<?php if($billtype == 'PAY LATER')
				{
				?>
              	<td width="18%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Cash </strong></div></td>
				<?php } ?>
                  </tr>
				  		<?php
						
			$colorloopcount = '';
			$sno = '';
			$snos = '';
			$totalamount=0;
			if($billtype == 'PAY NOW')
			{
			$status='pending';
			}
			else
			{
			$status='pending';
			}
			$query17 = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode'  and process='pending' and ((paymentstatus = 'pending' and approvalstatus <> '1') OR (approvalstatus <> '2'))";
			$exec17 = mysql_query($query17) or die ("Error in Query1".mysql_error());
			while ($res17 = mysql_fetch_array($exec17))
			{
			
			$paharmitemname=$res17['servicesitemname'];
			$pharmitemcode=$res17['servicesitemcode'];
			$pharmitemrate=$res17['servicesitemrate'];
			$seranum = $res17['auto_number'];
			$serqty = $res17['serviceqty'];
			$amount11 = $res17['amount'];
			$approvalstatus=$res17['approvalstatus'];
			$pharmitemrate1=$pharmitemrate*$serqty;
			$grandtotal = $grandtotal + $pharmitemrate1;
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$sno=$sno+1;
			$snos=$snos+1;
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
			$totalamount=$totalamount+$amount11;
			$totalamount=number_format($totalamount,2);
		
			?>
			  <tr <?php echo $colorcode; ?>>
			  <?php if($billtype == 'PAY LATER')
				{
				?>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" id="sercheck<?php echo $sno; ?>" name="sercheck[<?php echo $sno; ?>]" value="<?php echo $seranum; ?>"  <?php if($approvalstatus=='1'){ echo "checked=checked"; $selecttotal=$selecttotal+$amount11;}?> onClick="selectselect('ser','<?php echo $sno; ?>'), approvalfunction(this.id,<?php echo $amount11; ?>)"/>
			  <input type="hidden" name="seranum[<?php echo $sno; ?>]" id="seranum<?php echo $sno; ?>" value="<?php echo $seranum; ?>">
	
			  </div></td>
			  <?php } ?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno; ?></div></td>
			    
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $paharmitemname; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serqty; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $amount11; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><a onClick="return deletevalid()" href="opamend.php?delete=<?php echo $seranum; ?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&remove=service">Delete</a></div></td>
				<?php if($billtype == 'PAY LATER')
				{
				?> 
				<td class="bodytext31" valign="center"  align="left"><div align="center">
				<input type="checkbox" name="serlatertonow[<?php echo $sno; ?>]" id="serlatertonow<?php echo $sno; ?>"  onClick="selectcash('ser','<?php echo $sno; ?>')" <?php if($approvalstatus=='1'){ echo "disabled=disabled";}if($approvalstatus=='2'){ echo "checked=checked";}?>>
				</div></td>
				<?php }?>
				</tr>
			<?php } ?> 
			 <!-- <?php
			  $query17 = "select * from consultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='pending' and process='pending' and approvalstatus='2'";
			$exec17 = mysql_query($query17) or die ("Error in Query1".mysql_error());
			while ($res17 = mysql_fetch_array($exec17))
			{
			
			$paharmitemname=$res17['servicesitemname'];
			$pharmitemcode=$res17['servicesitemcode'];
			$pharmitemrate=$res17['servicesitemrate'];
			$seranum = $res17['auto_number'];
			$serqty = $res17['serviceqty'];
			$amount1 = $res17['amount'];
			$approvalstatus=$res17['approvalstatus'];
			$grandtotal = $grandtotal + $pharmitemrate;
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$sno=$sno+1;
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
			$totalamount=$totalamount+$amount1;
			$totalamount=number_format($totalamount,2);
		
			?>
			  <tr <?php echo $colorcode; ?>>
			  <?php if($billtype == 'PAY LATER')
				{
				?>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" id="sercheck<?php echo $sno; ?>" name="sercheck[<?php echo $sno; ?>]" value="<?php echo $seranum; ?>"  <?php if($approvalstatus=='1'){ echo "checked=checked";}?> <?php if($approvalstatus=='2'){ echo "disabled=disabled";}?> onClick="selectselect('ser','<?php echo $sno; ?>')"/>
			  <input type="hidden" name="seranum[<?php echo $sno; ?>]" id="seranum<?php echo $sno; ?>" value="<?php echo $seranum; ?>">
	
			  </div></td>
			  <?php } ?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno; ?></div></td>
			    
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $paharmitemname; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>
                 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serqty; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $amount1; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><a onClick="return deletevalid()" href="opamend.php?delete=<?php echo $seranum; ?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&remove=service">Delete</a></div></td>
				<?php if($billtype == 'PAY LATER')
				{
				?>
				<td class="bodytext31" valign="center"  align="left"><div align="center">
				<input type="checkbox" name="serlatertonow[<?php echo $sno; ?>]" id="serlatertonow<?php echo $sno; ?>"  onClick="selectcash('ser','<?php echo $sno; ?>')"  <?php if($approvalstatus=='2'){ echo "checked=checked";}?>>
				</div></td>
				<?php }?>
				</tr>
			<?php } ?>-->
           
          </tbody>
        </table>		</td>
      </tr>
	  <?php } ?> <input type="hidden" name="sersno" id="sersno" value="<?php echo $snos; ?>">
      <tr>
	   <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Add Service</strong></td>
	 
	  </tr>
     <tr id="serid">
				   <td colspan="9" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
				    <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="30" class="bodytext3">Services</td>
					    <td width="30" class="bodytext3">Qty</td>
                       <td class="bodytext3">Rate</td>
                       <td width="30" class="bodytext3">Amount</td>
                     </tr>
					  <tr>
					 <div id="insertrow3">					 </div></tr>
					  <tr>
					  <input type="hidden" name="serialnumber3" id="serialnumber3" value="1">
					  <input type="hidden" name="servicescode" id="servicescode" value="">
				   <td width="30"><input name="services[]" type="text" id="services" size="69" autocomplete="off"></td>
				    <td width="30"><input name="serviceqty[]" type="text" id="serviceqty" size="8" autocomplete="off" onKeyUp="return sertotal()"></td>
				    <td width="30"><input name="rate3[]" type="text" id="rate3" readonly size="8"></td>
					<td width="30"><input name="serviceamount[]" type="text" id="serviceamount" readonly size="8"></td>
					   <td><label>
                       <input type="button" name="Add3" id="Add3" value="Add" onClick="return insertitem8()" class="button">
                       </label></td>
					   </tr>
					    </table></td>
		       </tr>				 
				 <tr>
				   <td colspan="6" align="right" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="style2">Total Amount</span><input type="text" id="total3" readonly size="7"></td>
				   </tr>
                   
                   
                   
	   <tr>
	  <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>External Referral </strong></td>
	  </tr>
	  <?php if($num17rad>0)
	  { ?>
	  <tr>	  
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
            <tr>
			<?php if($billtype == 'PAY LATER')
				{
				?>
			<td width="5%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Select</strong></div></td>
				<?php }?>
              <td width="7%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				
				<td width="21%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Referal</strong></div></td>
				<td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate  </strong></div></td>
					<td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount </strong></div></td>
				<td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Action </strong></div></td>
				<?php if($billtype == 'PAY LATER')
				{
				?>
              	<td width="18%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Cash </strong></div></td>
				<?php } ?>
                  </tr>
				  		<?php 
			$colorloopcount = '';
			$sno = '';
			$totalamount=0;
			if($billtype == 'PAY NOW')
			{
			$status='pending';
			}
			else
			{
			$status='pending';
			}
	
	//	$query17 = "select * from consultation_referal where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus = 'pending'";
		$query17 = "select * from consultation_referal where patientvisitcode='$visitcode' and patientcode='$patientcode'  and  ((paymentstatus = 'pending' and approvalstatus <> '1') OR (approvalstatus <> '2'))";
			$exec17 = mysql_query($query17) or die ("Error in Query1".mysql_error());
			while ($res17 = mysql_fetch_array($exec17))
			{
			
			$paharmitemname=$res17['referalname'];				
			$pharmitemcode=$res17['referalcode'];
			$pharmitemrate=$res17['referalrate'];
			$refanum=$res17['auto_number'];
			$approvalstatus=$res17['approvalstatus'];	
			$grandtotal = $grandtotal + $pharmitemrate;
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$sno=$sno+1;
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
			$totalamount=$totalamount+$pharmitemrate;
			$totalamount=number_format($totalamount,2);
			?>
			  <tr <?php echo $colorcode; ?>>
			  <?php if($billtype == 'PAY LATER')
				{
				?>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" id="refcheck<?php echo $sno; ?>" name="refcheck[<?php echo $sno; ?>]" value="<?php echo $refanum; ?>"  <?php if($approvalstatus=='1'){ echo "checked=checked";  $selecttotal=$selecttotal+$pharmitemrate;}?> onClick="selectselect('ref','<?php echo $sno; ?>'), approvalfunction(this.id,<?php echo $pharmitemrate; ?>)"/>
			  <input type="hidden" name="refanum[<?php echo $sno; ?>]" id="refanum<?php echo $sno; ?>"  value="<?php echo $refanum; ?>">
			  </div></td>
			  <?php } ?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno; ?></div></td>
			   
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $paharmitemname; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left"><div align="center"><a onClick="return deletevalid()" href="opamend.php?delete=<?php echo $refanum; ?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&remove=referal">Delete</a></div></td>
				<?php if($billtype == 'PAY LATER')
				{
				?>  
				<td class="bodytext31" valign="center"  align="left"><div align="center">
				<input type="checkbox" name="reflatertonow[<?php echo $sno; ?>]" id="reflatertonow<?php echo $sno; ?>" onClick="selectcash('ref','<?php echo $sno; ?>')" <?php if($approvalstatus=='1'){ echo "disabled=disabled";}if($approvalstatus=='2'){ echo "checked=checked";}?>>
				</div></td>
				<?php } ?>
				</tr>
			<?php } ?> 
			<!-- <?php
            $query17 = "select * from consultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus='pending' and resultentry='pending' and approvalstatus='2'";
			$exec17 = mysql_query($query17) or die ("Error in Query1".mysql_error());
			while ($res17 = mysql_fetch_array($exec17))
			{
			
			$paharmitemname=$res17['radiologyitemname'];				
			$pharmitemcode=$res17['radiologyitemcode'];
			$pharmitemrate=$res17['radiologyitemrate'];
			$radanum=$res17['auto_number'];
			$approvalstatus=$res17['approvalstatus'];	
			$grandtotal = $grandtotal + $pharmitemrate;
			$colorloopcount = $colorloopcount + 1;
			$sno=$sno+1;
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
			$totalamount=$totalamount+$pharmitemrate;
			$totalamount=number_format($totalamount,2);
			?>
			  <tr <?php echo $colorcode; ?>>
			  <?php if($billtype == 'PAY LATER')
				{
				?>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" id="radcheck<?php echo $sno; ?>" name="radcheck[<?php echo $sno; ?>]" value="<?php echo $radanum; ?>"  <?php if($approvalstatus=='1'){ echo "checked=checked";}?> <?php if($approvalstatus=='2'){ echo "disabled=disabled";}?> onClick="selectselect('rad','<?php echo $sno; ?>')"/>
			  <input type="hidden" name="radanum[<?php echo $sno; ?>]" id="radanum<?php echo $sno; ?>"  value="<?php echo $radanum; ?>">
			  </div></td>
			  <?php } ?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno; ?></div></td>
			   
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $paharmitemname; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left"><div align="center"><a onClick="return deletevalid()" href="opamend.php?delete=<?php echo $radanum; ?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&remove=radiology">Delete</a></div></td>
				<?php if($billtype == 'PAY LATER')
				{
				?>
				<td class="bodytext31" valign="center"  align="left"><div align="center">
				<input type="checkbox" name="radlatertonow[<?php echo $sno; ?>]" id="radlatertonow<?php echo $sno; ?>" onClick="selectcash('rad','<?php echo $sno; ?>')" <?php if($approvalstatus=='2'){ echo "checked=checked";}?>>
				</div></td>
				<?php } ?>
				</tr>
			<?php } ?>-->
          </tbody>
        </table>		</td>
      </tr>
	  <?php } ?> <input type="hidden" name="refsno" id="refsno" value="<?php echo $sno; ?>">
      
      <tr>
	   <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Add External Referral</strong></td>
	 
	  </tr>
     <tr id="radid">
				   <td colspan="9" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">
				    <table id="presid" width="621" border="0" cellspacing="1" cellpadding="1">
                     <tr>
                       <td width="30" class="bodytext3">Doctor</td>
                       <td class="bodytext3">Rate</td>
                       <td width="30" class="bodytext3">&nbsp;</td>
                     </tr>
					  <tr>
					 <div id="insertrow51">		 </div></tr>
					  <tr>
					  <input type="hidden" name="serialnumber4" id="serialnumber4" value="1">
					  <input type="hidden" name="referalcode" id="referalcode" value="">
				      <td width="30"> <input name="referal[]" id="referal" type="text" size="69" autocomplete="off"></td>
				      <td><input name="rate4[]" type="text" id="rate4" size="8" readonly></td>
					   
                     <td>  <input type="button" name="Add4" id="Add4" value="Add" onClick="(insertitem71(),fortreatment())" class="button">
                  </td>
					   </tr>
					    </table>
						</td>
						
		       </tr> 
               
               
          
               
               
               
               
               
               
                                 
		 <tr>
				   <td colspan="8" align="right" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="style2">Total Amount</span>
                   <input type="text" id="total21" readonly size="7"></td>
				  </tr>
                  
                  
                  
                       <!--this is for internal referal-->
                 <tr>
	  <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Internal Referral </strong></td>
	  </tr>
	  <?php if($num17rad>0)
	  { ?>
	  <tr>	  
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
            <tr>
			<?php if($billtype == 'PAY LATER')
				{
				?>
			<td width="5%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Select</strong></div></td>
				<?php }?>
              <td width="7%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				
				<td width="21%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Referal</strong></div></td>
				<td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Rate  </strong></div></td>
					<td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount </strong></div></td>
				<td width="14%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Action </strong></div></td>
				<?php if($billtype == 'PAY LATER')
				{
				?>
              	<td width="18%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Cash </strong></div></td>
				<?php } ?>
                  </tr>
				  		<?php 
			$colorloopcount = '';
			$sno = '';
			$totalamount=0;
			if($billtype == 'PAY NOW')
			{
			$status='pending';
			}
			else
			{
			$status='pending';
			}
	
	//	$query17 = "select * from consultation_referal where patientvisitcode='$visitcode' and patientcode='$patientcode' and paymentstatus = 'pending'";
		$query17 = "select * from consultation_departmentreferal where patientvisitcode='$visitcode' and patientcode='$patientcode'  and  ((paymentstatus = 'pending' and approvalstatus <> '1') OR (approvalstatus <> '2'))";
			$exec17 = mysql_query($query17) or die ("Error in Query1".mysql_error());
			while ($res17 = mysql_fetch_array($exec17))
			{
			
			$paharmitemname=$res17['referalname'];				
			$pharmitemcode=$res17['referalcode'];
			$pharmitemrate=$res17['referalrate'];
			$refanum=$res17['auto_number'];
			$approvalstatus=$res17['approvalstatus'];	
			$grandtotal = $grandtotal + $pharmitemrate;
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			$sno=$sno+1;
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
			$totalamount=$totalamount+$pharmitemrate;
			$totalamount=number_format($totalamount,2);
			?>
			  <tr <?php echo $colorcode; ?>>
			  <?php if($billtype == 'PAY LATER')
				{
				?>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><input type="checkbox" id="deprefcheck<?php echo $sno; ?>" name="deprefcheck[<?php echo $sno; ?>]" value="<?php echo $refanum; ?>"  <?php if($approvalstatus=='1'){ echo "checked=checked";  $selecttotal=$selecttotal+$pharmitemrate;}?> onClick="selectselect('depref','<?php echo $sno; ?>'), approvalfunction(this.id,<?php echo $pharmitemrate; ?>)"/>
			  <input type="hidden" name="deprefanum[<?php echo $sno; ?>]" id="deprefanum<?php echo $sno; ?>"  value="<?php echo $refanum; ?>">
			  </div></td>
			  <?php } ?>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno; ?></div></td>
			   
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $paharmitemname; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pharmitemrate; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left"><div align="center"><a onClick="return deletevalid()" href="opamend.php?delete=<?php echo $refanum; ?>&&patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&remove=defreferal">Delete</a></div></td>
				<?php if($billtype == 'PAY LATER')
				{
				?>  
				<td class="bodytext31" valign="center"  align="left"><div align="center">
				<input type="checkbox" name="depreflatertonow[<?php echo $sno; ?>]" id="depreflatertonow<?php echo $sno; ?>" onClick="selectcash('depref','<?php echo $sno; ?>')" <?php if($approvalstatus=='1'){ echo "disabled=disabled";}if($approvalstatus=='2'){ echo "checked=checked";}?>>
				</div></td>
				<?php } ?>
				</tr>
			<?php } ?> 
			
            
          </tbody>
        </table>		</td>
      </tr>
	  <?php } ?> <input type="hidden" name="deprefsno" id="deprefsno" value="<?php echo $sno; ?>">
               
               
               
               
               
               
                  
      <tr>        
		 <td colspan="2" align="right" valign="top"  bgcolor="#E0E0E0" class="bodytext3">
		 <textarea name="approvecomment" id="approvecomment" style="display:none"></textarea>
		 Approve check <input type="checkbox" value="1"  name="approve" id="approve" onClick="approvecheck();"> 
		  <input type="hidden" name="frm1submit1" value="frm1submit1" />
                  <input type="hidden" name="loopcount" value="<?php echo $i - 1; ?>" />
               <input name="Submit222" type="submit"  value="Approve" onClick="return alertfun()" class="button" />
		 </td>
      </tr>
	  </table>
      </td>
      </tr>    
  </table>
</form>
<?php  echo "<script>document.getElementById('approvallimit').value=".$selecttotal."</script>";?>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>