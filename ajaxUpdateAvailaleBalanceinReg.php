<?php
 
session_start();
//error_reporting(0);

include ("db/db_connect.php");

$phoneNumber = $_REQUEST['phoneNumber']; //'254724951505';//
$transId = $_REQUEST['transactionId'];

    $url ="http://apiv1.prod.carepool.co.ke/users/".$phoneNumber."/programs/40";
	
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
		"authorization: Bearer eyJhbGciOiJSUzUxMiJ9.eyJzdWIiOiJtZXNzYWdpbmciLCJncmFudHMiOnsiU3lzdGVtIjoiQXc9PSJ9fQ.hFJ9ImDWsdt42rUE-lRyBRTftfEt89Ev6MUUsht7j6UAVn_XzzQTK5lYXa0giGWR_hOUdjCp4WKK8pw9b1cO7zh6mKF32ep7DvMx0vlF-FFdNqcQ3jlSTz1BVg_fMKsafAHiDlLniNsPZv1HzY-eIXKDEgrCix38bcDUqzR9Alw",
		"content-type: application/json",
		
		),
	));

	$response = curl_exec($curl);
//	print_r($response);

//exit;
	$err = curl_error($curl);

	curl_close($curl);
      
	if ($err) {
	  echo 0;
	} else {
		//echo $response;
		$obj = json_decode($response,true); 
		//$status = $obj['status'];
	  
		if(isset($obj['balance'])){
			$mtibalance = $obj['balance'];
			$mtibalance = str_replace(',', '', $mtibalance);
			echo $mtibalance; 
		}else{
			  echo 0.00;
		}
	}

?>