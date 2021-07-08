<?php
session_start();
include ("db/db_connect.php");
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$customersearch = $_REQUEST["customersearch"];
$consultationdate = date('Y-m-d');
$lastvisitdate = '';
//$customersearch = strtoupper($customersearch);
$searchresult = "";
$availablelimit = "";
 $query2 = "select * from master_customer where customercode = '$customersearch' order by customername";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
while ($res2 = mysql_fetch_array($exec2))
{
	$customercode = $res2["customercode"];
	$customername = $res2["customername"];
	$customername = strtoupper($customername);
	
	$patientmiddlename = $res2["customermiddlename"];
	$patientmiddlename = strtoupper($patientmiddlename);

	$patientlastname = $res2["customerlastname"];
	$patientlastname = strtoupper($patientlastname);
	
    $maintype = $res2['maintype'];
	$mrdno = $res2['mrdno'];
	$paymenttype = $res2["paymenttype"];
	
	$subtype = $res2["subtype"];
	
    $query4 = "select * from master_paymenttype where auto_number = '$paymenttype'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	$res4 = mysql_fetch_array($exec4);
	//$paymenttypeanum = $res4['auto_number'];
	$res4paymenttype = $res4['paymenttype'];
	$res4auto_number = $res4['auto_number'];
	
	
	
	$query4 = "select * from master_subtype where auto_number = '$subtype'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	$res4 = mysql_fetch_array($exec4);
	//$subtypeanum = $res4['auto_number'];
	$res4subtype = $res4['subtype'];

	$billtype = $res2["billtype"];
	
	$query39 = "select * from master_company";
	$exec39 = mysql_query($query39) or die(mysql_error());
	$res39 = mysql_fetch_array($exec39);
	$ipadmissionfees = $res39['ipadmissionfees'];
	$creditipadmissionfees = $res39['creditipadmissionfees'];
	
	if($billtype == 'PAY NOW')
	{
	$admissionfees = $ipadmissionfees;
	}
	else
	{
	$admissionfees = $creditipadmissionfees;
	}
	$gender = $res2["gender"];
	$dateofbirth = $res2["dateofbirth"];
	$todate = date("Y-m-d");
	$diff = abs(strtotime($todate) - strtotime($dateofbirth));
	$years = floor($diff / (365*60*60*24));
	$years = $years.' '.'Years';
	
	$accountname = $res2["accountname"];
	
	$query4 = "select * from master_accountname where auto_number = '$accountname'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	$res4 = mysql_fetch_array($exec4);
	//$accountnameanum = $res4['auto_number'];
	$res4accountname = $res4['accountname'];
	$recordstatus = $res4['recordstatus'];
	$accountexpirydate = $res4["expirydate"];
	$planname = $res2["planname"];
	
	$query5 = "select * from master_planname where auto_number = '$planname'";
	$exec5 = mysql_query($query5) or die ("Error in Query4".mysql_error());
	$res5 = mysql_fetch_array($exec5);
	//$plannameanum = $res4['auto_number'];
	$res4planname = $res5['planname'];
	$res4planfixedamount = $res5['planfixedamount'];
	$res4planpercentage = $res5['planpercentage'];

	$planexpirydate = $res5["planexpirydate"];
	//$visitlimit = $res5["visitlimit"];
	//$overalllimit = $res5["overalllimit"];
	$visitlimit = $res5["opvisitlimit"];
	$overalllimit = $res5["overalllimitop"];
	if($overalllimit == '0')
	{
	    $overalllimit = $visitlimit;
	}
	$consultationfees1=0;
	$cashamount21=0;
	$cardamount21=0;
	$onlineamount21=0;
	$chequeamount21=0;
	$tdsamount21=0;
	$writeoffamount21=0;

	$query55 = "select * from master_billing where patientcode = '$customersearch' and billtype = 'PAY LATER' ";
	$exec55 = mysql_query($query55) or die("Error in Query55".mysql_error());
	while($res55 = mysql_fetch_array($exec55))
	{
		 $consultationfees = $res55["consultationfees"];
		 $consultationfees1 = $consultationfees1 + $consultationfees;
	}
	
	if($billtype == 'PAY LATER')
	{
	 $availablelimit = $overalllimit - $consultationfees1;
	 }
	 
	 $query43="select * from billing_paylater where patientcode = '$customersearch' and billstatus = 'unpaid'";
	 $exec43=mysql_query($query43) or die(mysql_error());
	 $num43=mysql_num_rows($exec43);
	 		if($num43 > 0)
	 {
	 while($res43=mysql_fetch_array($exec43))
	 {
	 $billnumber = $res43['billno'];

	 $billtotalamount = $res43['totalamount'];
	 $query3 = "select * from master_transactionpaylater where billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = ''";
				$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	while ($res3 = mysql_fetch_array($exec3))
				{
					//echo $res3['auto_number'];
				    $cashamount1 = $res3['cashamount'];
					$onlineamount1 = $res3['onlineamount'];
					$chequeamount1 = $res3['chequeamount'];
					$cardamount1 = $res3['cardamount'];
					$tdsamount1 = $res3['tdsamount'];
					$writeoffamount1 = $res3['writeoffamount'];
					//echo $cashamount1;
					$cashamount21 = $cashamount21 + $cashamount1;
					
					$cardamount21 = $cardamount21 + $cardamount1;
					$onlineamount21 = $onlineamount21 + $onlineamount1;
					$chequeamount21 = $chequeamount21 + $chequeamount1;
					$tdsamount21 = $tdsamount21 + $tdsamount1;
					$writeoffamount21 = $writeoffamount21 + $writeoffamount1;
				}
			
				$totalpayment = $cashamount21 + $chequeamount21 + $onlineamount21 + $cardamount21;
				$netpayment = $totalpayment + $tdsamount21 + $writeoffamount21;
				 $patientspent = $billtotalamount - $netpayment;
				 $availablelimit = $overalllimit - $patientspent;
		
	}
	}
	else
	{
	$patientspent = "0.00";
	}
	$query5 = "select * from master_visitentry where patientcode = '$customercode' and recordstatus = ''";
	$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
	$rowcount5 = mysql_num_rows($exec5);
	$visitcount = $rowcount5 + 1;
	
	$query51 = "select * from master_visitentry where patientcode = '$customercode' and consultationdate < '$consultationdate' and recordstatus = '' order by auto_number desc limit 0,1";
	$exec51 = mysql_query($query51) or die ("Error in Query51".mysql_error());
	while($res51 = mysql_fetch_array($exec51))
	{
    $lastvisitdate = $res51['consultationdate'];
	}

	$todaysdatetime = strtotime($consultationdate);
	$lastvisitdatetime = strtotime($lastvisitdate);
	$datediff = $todaysdatetime - $lastvisitdatetime;
	$visitdays = floor($datediff/(60*60*24));
	
	$query66 = "select * from master_consultationtype where subtype = '$subtype' and recordstatus = ''";
	$exec66 = mysql_query($query66) or die ("Error in Query66".mysql_error());
	$res66 = mysql_fetch_array($exec66);
	//while($res66 = mysql_fetch_array($exec66))
	//{
	 $paymenttypeanum = $res66['auto_number'];
	$res66consultationtype = $res66['consultationtype'];
	
	if ($searchresult == '')
	{
		$searchresult = ''.$customercode.'#'.$customername.'#'.$patientmiddlename.'#'.$patientlastname.'#'.$paymenttype.'#'.$subtype.'#'.$billtype.'#'.$accountname.'#'.$accountexpirydate.'#'.$planname.'#'.$planexpirydate.'#'.$visitlimit.'#'.$overalllimit.'#'.$res4paymenttype.'#'.$res4subtype.'#'.$res4accountname.'#'.$res4planname.'#'.$visitcount.'#'.$res4planfixedamount.'#'.$patientspent.'#'.$res4planpercentage.'#'.$availablelimit.'#'.$years.'#'.$gender.'#'.$recordstatus.'#'.$res66consultationtype.'#'.$paymenttypeanum.'#'.$mrdno.'#'.$admissionfees.'#'.$lastvisitdate.'#'.$visitdays.'';
	}
	else
	{
		$searchresult = $searchresult.'#^#'.$customercode.'#'.$customername.'#'.$patientmiddlename.'#'.$patientlastname.'#'.$maintype.'#'.$subtype.'#'.$billtype.'#'.$accountname.'#'.$accountexpirydate.'#'.$planname.'#'.$planexpirydate.'#'.$visitlimit.'#'.$overalllimit.'#'.$res4paymenttype.'#'.$res4subtype.'#'.$res4accountname.'#'.$res4planname.'#'.$visitcount.'#'.$res4planfixedamount.'#'.$patientspent.'#'.$res4planpercentage.'#'.$availablelimit.'#'.$years.'#'.$gender.'#'.$recordstatus.'#'.$res66consultationtype.'#'.$paymenttypeanum.'#'.$mrdno.'#'.$admissionfees.'#'.$lastvisitdate.'#'.$visitdays.'';
	}
	
	//}
}
if ($searchresult != '')
{
	echo $searchresult;
}

?>
