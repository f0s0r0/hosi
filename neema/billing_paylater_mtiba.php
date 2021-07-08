<?php
session_start();
//error_reporting(0);

//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$currentdate = date("Y-m-d");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$companyanum = $_SESSION["companyanum"];
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];
$docno=$_SESSION["docno"];
$totalcopayfixedamount='';
$totalcopay='';

$other_icdcode = "0";
$other_medicinecode = "0";
$other_labitemcode = "0";
$other_radiologyitemcode = "0";
$other_servicesitemcode = "0";

if(isset($_REQUEST["billautonumber"])) { $billautonumber = $_REQUEST["billautonumber"]; } else { $billautonumber = ""; }
if(isset($_REQUEST["visitcode"])) { $vcode = $_REQUEST["visitcode"]; } else { $vcode = ""; }

if($billautonumber !=""){

	
	$query = "select patientcode,visitcode from billing_paylater where billno = '$billautonumber' AND visitcode = '$vcode'";
	$exec = mysql_query($query) or die ("Error in Query".mysql_error());
    $rows = mysql_num_rows($exec);
	if ($rows != 0)
	{
		$res1 = mysql_fetch_array($exec);
		$patientcode = $res1['patientcode'];
		$visitcode = $res1['visitcode'];
		
		// ******************************************* Master Visit Entry **************************************************
		
		$query10 = "select transactionId,patientfullname,locationcode from master_visitentry where visitcode='$visitcode' and patientcode='$patientcode'";
		$exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());
		$res20 = mysql_fetch_array($exec10);
		$transactionId = $res20['transactionId'];
		$patientname = $res20['patientfullname'];
		$locationcode = $res20['locationcode'];

		$fields = array(
			'transaction_id' => urlencode($transactionId),
			'transactions' => array(),
			'diagnosis' => array(),
			'visit_id' => urlencode($visitcode)
		);		

		// ******************************************* End Master Visit Entry *********************************************	
		
		// ******************************************* Consultation ICD ***************************************************
		
		$query12 = "select * from consultation_icd where patientvisitcode='$visitcode' and patientcode='$patientcode' and primaryicdcode <>'' order by auto_number DESC";
		$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
		$num12=mysql_num_rows($exec12);		
		
		if($num12 > 0 ){
			 
			while($res12 = mysql_fetch_array($exec12))
			{ 
				$recorddate = $res12['consultationdate']; 
				$icdescrip = trim($res12['primarydiag']);
				$icdcode = trim($res12['primaryicdcode']);
				$res_icd=mysql_fetch_array(mysql_query("select auto_number,chapter from master_icd where icdcode='$icdcode'"));
				
				if($res_icd){
					$icdcode =(trim($res_icd['chapter'])!=""?trim($res_icd['chapter']):$icdcode);
				}else{
					$icdcode =$icdcode;
				}

				$diagno = array('icd10Code' =>$icdcode ,'description' =>$icdescrip );

				array_push($fields["diagnosis"], $diagno);
			
			}
			
		}else{
				$icdcode ="NOICD";
				$icdescrip = "No ICD";
				$diagno = array('icd10Code' =>$icdcode ,'description' =>$icdescrip );
				array_push($fields["diagnosis"], $diagno);
		}

		// ******************************************* End Consultation ICD *****************************************		


		// *************************** Consultation, Referal and Department Referal Price ***************************
		
		$query7 = "select sum(referalrate) as referalrate1 from billing_paylaterreferal where patientvisitcode='$visitcode' and patientcode='$patientcode'";
		$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
		$num7=mysql_num_rows($exec7);		
		if($num7 > 0 ){
			$res8 = mysql_fetch_array($exec7);
			$referalrate  = $res8['referalrate1'];
		}else{
			$referalrate = 0;
		}	
		
		$query8 = "select * from billing_paylaterconsultation where visitcode='$visitcode' and patientcode='$patientcode' ";
		$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
		$num8=mysql_num_rows($exec8);		

		if($num8 > 0 ){
			$res9 = mysql_fetch_array($exec8);
			$rateconsul = $res9['totalamount'];
		}else{
			$rateconsul=0;
		}

		$itemname = 'Consultation clinical officer';
		$itemcode = $visitcode;
		$itemcode = "PO-A99.0-001-000-Z-002-008";
		$totalrate = number_format($referalrate + $rateconsul,2,'.','');
		$quantity = '1';
		$category = 'procedure';
		
		$arrconsul = array('itemName' =>$itemname ,'itemCode' =>$itemcode ,'itemPrice' =>$totalrate ,'quantity' =>$quantity ,'category' =>$category);
		
		array_push($fields["transactions"], $arrconsul);
				
		// *************************** End Consultation, Referal and Department Referal Price ***************************	

		// ******************************************* pharmacy medicien ************************************************
		
		$query3 = "select *,sum(quantity) as sum_quantity from master_consultationpharm where patientvisitcode='$visitcode' and patientcode='$patientcode' group by medicinecode";
		$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
		$num3=mysql_num_rows($exec3);		
		
		if($num3 > 0 ){
			
			while($res4 = mysql_fetch_array($exec3))
			{
				$recorddate  = $res4['recorddate']; 
				$refno  = $res4['refno'];
				$medicinename  = $res4['medicinename'];
				$medicinecode  = $res4['medicinecode'];

				$query3a = "select mtiba_code from master_medicine where itemcode='$medicinecode'";
				$exec3a = mysql_query($query3a) or die ("Error in Query3a".mysql_error());
				if($res3a = mysql_fetch_array($exec3a)){
					$medicinecode  = ($res3a['mtiba_code']=="")?$medicinecode:$res3a['mtiba_code'];
				}else{
					$medicinecode  = $medicinecode;
				}

				$rate  = $res4['rate'];
				$quantity  = number_format($res4['sum_quantity'],0, '.', '');
				$category  = 'medicine';
				
				$arrpharma = array('itemName' =>$medicinename ,'itemCode' =>$medicinecode ,'itemPrice' =>$rate ,'quantity' =>$quantity ,'category' =>$category );
				if($quantity>0){
					array_push($fields["transactions"], $arrpharma);
				}
					    
			}
			
		}

		// ******************************************* End pharmacy medicien ********************************************* 
		
		// ******************************************* Lab ***************************************************************
		
		$query4 = "select * from billing_paylaterlab where patientvisitcode='$visitcode' and patientcode='$patientcode' group by labitemcode";
		$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		$num4=mysql_num_rows($exec4);		
		
		if($num4 > 0 ){
				$i=0;
			while($res5 = mysql_fetch_array($exec4))
			{
				$recorddate  = $res5['billdate']; 
				$labitemname  = $res5['labitemname'];
				$labitemcode  = $res5['labitemcode'];

				$quantity  = mysql_num_rows(mysql_query("select auto_number from billing_paylaterlab where patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemcode='$labitemcode'"));
				

				$query3a = "select mtiba_code from master_lab where itemcode='$labitemcode'";
				$exec3a = mysql_query($query3a) or die ("Error in Query3a".mysql_error());
				if($res3a = mysql_fetch_array($exec3a)){
					$labitemcode  = ($res3a['mtiba_code']=="")?$labitemcode:$res3a['mtiba_code'];
				}else{
					$labitemcode  = $labitemcode;
				}

				$rate  = $res5['labitemrate'];

				$quantity  = number_format($quantity,0, '.', '');

				$category  = 'procedure';
				
				$arrlab = array('itemName' =>$labitemname ,'itemCode' =>$labitemcode ,'itemPrice' =>$rate ,'quantity' =>$quantity ,'category' =>$category);
				if($quantity>0){
					array_push($fields["transactions"], $arrlab);	
				}					    
			}
			
		}

		// ******************************************* End Lab **********************************************************	

		// ******************************************* Radiology ********************************************************
		
		$query5 = "select * from billing_paylaterradiology where patientvisitcode='$visitcode' and patientcode='$patientcode' group by radiologyitemcode";
		$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
		$num5=mysql_num_rows($exec5);		
		
		if($num5 > 0 ){
			$i=0;
			while($res6 = mysql_fetch_array($exec5))
			{  
				$recorddate  = $res6['billdate']; 
				$radiologyitemname  = $res6['radiologyitemname'];
				$radiologyitemcode  = $res6['radiologyitemcode'];


				$quantity  = mysql_num_rows(mysql_query("select auto_number from billing_paylaterradiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemcode='$radiologyitemcode'"));

				$query3a = "select mtiba_code from master_radiology where itemcode='$radiologyitemcode'";
				$exec3a = mysql_query($query3a) or die ("Error in Query3a".mysql_error());
				if($res3a = mysql_fetch_array($exec3a)){
					$radiologyitemcode  = ($res3a['mtiba_code']=="")?$radiologyitemcode:$res3a['mtiba_code'];
				}else{
					$radiologyitemcode  = $radiologyitemcode;
				}

				$rate  = $res6['radiologyitemrate'];
				$quantity  = number_format($quantity,0, '.', '');
				$category  = 'test';
				
				$arrradiology = array('itemName' =>$radiologyitemname ,'itemCode' =>$radiologyitemcode ,'itemPrice' =>$rate ,'quantity' =>$quantity ,'category' =>$category);
				if($quantity>0){
					array_push($fields["transactions"], $arrradiology);
				}

			}
			
		}

		// ******************************************* End Radiology ******************************************************	

		// ******************************************* Services ***********************************************************
		
		$query6 = "select *,sum(serviceqty) as sum_quantity from billing_paylaterservices where patientvisitcode='$visitcode' and patientcode='$patientcode' group by servicesitemcode";
		$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
		$num6=mysql_num_rows($exec6);		
		
		if($num6 > 0 ){
			
			while($res7 = mysql_fetch_array($exec6))
			{
				$recorddate  = $res7['billdate']; 
				$servicesitemname  = $res7['servicesitemname'];
				$servicesitemcode  = $res7['servicesitemcode'];


				$query3a = "select mtiba_code from master_services where itemcode='$servicesitemcode'";
				$exec3a = mysql_query($query3a) or die ("Error in Query3a".mysql_error());
				if($res3a = mysql_fetch_array($exec3a)){
					$servicesitemcode  = ($res3a['mtiba_code']=="")?$servicesitemcode:$res3a['mtiba_code'];
				}else{
					$servicesitemcode  = $servicesitemcode;
				}

				$rate  = $res7['servicesitemrate'];
				$quantity  = number_format($res7['sum_quantity'],0, '.', ''); 
				$category  = 'procedure';
				
				$arrservices = array('itemName' =>$servicesitemname ,'itemCode' =>$servicesitemcode ,'itemPrice' =>$rate ,'quantity' =>$quantity ,'category' =>$category);
				if($quantity>0){
					array_push($fields["transactions"], $arrservices);
				}								
			}
			
		}

		// ******************************************* End Services ******************************************************
	
	$transactionsid = $fields["transaction_id"]; 


	 // **************************** start by ganesh for update billnumber into queue table ******************************	
	 
		
		$fields1 ="";	
		
		$fields1 = array(
		 'billno' => urlencode($billautonumber),
		 'transactionId' => urlencode($transactionsid)
		);	
		//print_r($fields1);
		
		$jsondata1 =  json_encode($fields1); 

		$curl = curl_init();
   
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://med360-mtiba.tislive.com/api/queue_billno_update.php",
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
		  echo "cURL Error #:" . $err1;
		} else {
			//echo $response1;
		}

	 // **************************** end by ganesh  *************************************			
	//exit;   

	 $jsondata =  "[".json_encode($fields)."]";

print_r($jsondata);
//	exit;

	$curl = curl_init();
   //exit;
	curl_setopt_array($curl, array(
		CURLOPT_URL => "http://apiv1.prod.carepool.co.ke/integrations/invoices",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => $jsondata,
		CURLOPT_HTTPHEADER => array(
		"authorization: Bearer eyJhbGciOiJSUzUxMiJ9.eyJzdWIiOiJtZXNzYWdpbmciLCJncmFudHMiOnsiU3lzdGVtIjoiQXc9PSJ9fQ.hFJ9ImDWsdt42rUE-lRyBRTftfEt89Ev6MUUsht7j6UAVn_XzzQTK5lYXa0giGWR_hOUdjCp4WKK8pw9b1cO7zh6mKF32ep7DvMx0vlF-FFdNqcQ3jlSTz1BVg_fMKsafAHiDlLniNsPZv1HzY-eIXKDEgrCix38bcDUqzR9Alw",
		"cache-control: no-cache",
		"content-type: application/json",
		
		),
	));

	$response = curl_exec($curl);



	$err = curl_error($curl);

	curl_close($curl);
      
	if ($err) {
	  echo "cURL Error #:" . $err;
	} else {
		//echo $response;
		$obj = json_decode($response,true); 
		$status = $obj['status'];
	  
		if($status === true){

			$status  = 'success';
			$message = $obj['message'];
			
			$sqlupdate = "UPDATE `billing_paylater` SET sync_status = '1' WHERE billno = '$billautonumber' AND visitcode = '$visitcode' ";
			mysql_query($sqlupdate) or die(mysql_error()); 
			
			
		}else{
			$error = $obj['error'];
			$message = $error."( ".$obj['message'].") ";
		}
			
		mysql_query("INSERT INTO `temp_mtibatransaction` (transactionsid,billno,patientname,patientcode,visitcode,status,response,entrydate,locationcode,ipaddress,username)values('$transactionsid','$billautonumber','$patientname','$patientcode','$visitcode','$status','$message','$currentdate','$locationcode','$ipaddress','$username')") or die(mysql_error()); 
		
	}

		header("location:billing_pending_op2.php?billautonumber=$billautonumber");  

	}
	
}

?>