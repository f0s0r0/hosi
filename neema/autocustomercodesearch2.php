<?php
session_start();
include ("db/db_connect.php");
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$customersearch = $_REQUEST["customersearch"];
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
	$photoavailable = $res2['photoavailable'];
	
	$ipdue = $res2['ipdue'];
	
	$patientspent = $ipdue;
	
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
	$res4planstatus = $res5['recordstatus'];
	$res4planfixedamount = $res5['planfixedamount'];
	$res4planpercentage = $res5['planpercentage'];

	$planexpirydate = $res5["planexpirydate"];
	$visitlimit = $res5["ipvisitlimit"];
	$overalllimit = $res5["overalllimitip"];
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
	// $availablelimit = $overalllimit - $consultationfees1-$patientspent;
	 $availablelimit = $overalllimit - $patientspent;
	 }

		$query43="SELECT * FROM billing_ip WHERE patientcode = '$customersearch' AND patientbilltype = 'PAY LATER'";
		$exec43=mysql_query($query43) or die(mysql_error());
		$num43=mysql_num_rows($exec43);
		if($num43 > 0) {
			$billtotalamount1 = 0;
		while($res43=mysql_fetch_array($exec43))
	 {
	 $billnumber = $res43['billno'];
	 $billamount = $res43['totalamount'];
	 $visitcode= $res43['visitcode'];
	 $query3 = "SELECT SUM(totalamount) AS debitamount FROM ip_debitnote WHERE visitcode = '".$visitcode."' AND patientcode = '".$customersearch."' GROUP BY visitcode";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	$res3 = mysql_fetch_array($exec3);
	$debitamount = $res3['debitamount'];
	
	$query4 = "SELECT SUM(totalamount) AS creditamount FROM ip_creditnote WHERE visitcode = '".$visitcode."' AND patientcode = '".$customersearch."' GROUP BY visitcode";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	$res4 = mysql_fetch_array($exec4);
	$creditamount = $res4['creditamount'];
	$billtotalamount = $billamount + $debitamount - $creditamount;
	$billtotalamount1 += $billtotalamount;
	$availablelimit = $overalllimit - $patientspent;
	if($availablelimit<0){
		$availablelimit = 0.00;
	}
	//$patientspent = '0.00';
	/*$patientspent = $res3['cashamount1'] + $res3['onlineamount1'] + $res3['chequeamount1'] + $res3['cardamount1'] + $res3['tdsamount1'] + $res3['writeoffamount1'];
	$billamount = $billamount - $patientspent;
	$availablelimit = $overalllimit - $billamount;*/
	 }
		}
	/* $query43="SELECT (SUM(bi.totalamount)+ SUM(id.totalamount) - SUM(ic.totalamount)) AS grand FROM billing_ip AS bi LEFT JOIN ip_debitnote AS id ON bi.patientcode = id.patientcode LEFT JOIN ip_creditnote AS ic ON bi.patientcode = ic.patientcode WHERE bi.patientcode = '$customersearch' AND bi.patientbilltype = 'PAY LATER'  GROUP BY bi.patientcode";
	 $exec43=mysql_query($query43) or die(mysql_error());
	 $num43=mysql_num_rows($exec43);
	 $res43=mysql_fetch_array($exec43);
	 $netamount = $res43['grand'];
	 $availablelimit =  $netamount;
	 $patientspent = 0;
	 		if($num43 > 0)*/
	/* {
	 while($res43=mysql_fetch_array($exec43))
	 {
	 $billnumber = $res43['billno'];
	 $billtotalamount = $res43['totalamount'];
	 $query3 = "select * from ip_debitnote where patientcode = '$customersearch' and patientbilltype = 'PAY LATER'";
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
	}*/
	else
	{
//	$patientspent = "0.00";
	$patientspent = $patientspent;
	}
	$query5 = "select * from master_visitentry where patientcode = '$customercode' and recordstatus = ''";
	$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
	$rowcount5 = mysql_num_rows($exec5);
	$visitcount = $rowcount5 + 1;
	
	
	if ($searchresult == '')
	{
		$searchresult = ''.$customercode.'#'.$customername.'#'.$patientmiddlename.'#'.$patientlastname.'#'.$paymenttype.'#'.$subtype.'#'.$billtype.'#'.$accountname.'#'.$accountexpirydate.'#'.$planname.'#'.$planexpirydate.'#'.$visitlimit.'#'.$overalllimit.'#'.$res4paymenttype.'#'.$res4subtype.'#'.$res4accountname.'#'.$res4planname.'#'.$visitcount.'#'.$res4planfixedamount.'#'.$patientspent.'#'.$res4planpercentage.'#'.$availablelimit.'#'.$years.'#'.$gender.'#'.$recordstatus.'#'.$mrdno.'#'.$admissionfees.'#'.$res4planstatus.'#'.$photoavailable.'';
	}
	else
	{
		$searchresult = $searchresult.'#^#'.$customercode.'#'.$customername.'#'.$patientmiddlename.'#'.$patientlastname.'#'.$maintype.'#'.$subtype.'#'.$billtype.'#'.$accountname.'#'.$accountexpirydate.'#'.$planname.'#'.$planexpirydate.'#'.$visitlimit.'#'.$overalllimit.'#'.$res4paymenttype.'#'.$res4subtype.'#'.$res4accountname.'#'.$res4planname.'#'.$visitcount.'#'.$res4planfixedamount.'#'.$patientspent.'#'.$res4planpercentage.'#'.$availablelimit.'#'.$years.'#'.$gender.'#'.$recordstatus.'#'.$mrdno.'#'.$admissionfees.'#'.$res4planstatus.'#'.$photoavailable.'';
	}
	
}
if ($searchresult != '')
{
	echo $searchresult;
}

?>