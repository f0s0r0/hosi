<?php
$cashamount31='';
$cardamount31='';
$onlineamount31='';
$chequeamount31='';
$tdsamount31='';
$writeoffamount31='';
$number=0;

	$query29 = "select * from billing_paylater where accountname like '%$suppliername%'";
	$exec29 = mysql_query($query29) or die ("Error in Query29".mysql_error());
	while ($res29 = mysql_fetch_array($exec29))
	{
	$billnumber1 = $res29['billno'];
	$billtotalamount1 = $res29['totalamount'];
	
	$query39 = "select * from master_transactionpaylater where billnumber = '$billnumber1' and companyanum='$companyanum' and recordstatus <>'deallocated'";
				$exec39 = mysql_query($query39) or die ("Error in Query3".mysql_error());
			while ($res39 = mysql_fetch_array($exec39))
			{
			        $cashamount1 = $res39['cashamount'];
					$onlineamount1 = $res39['onlineamount'];
					$chequeamount1 = $res39['chequeamount'];
					$cardamount1 = $res39['cardamount'];
					$tdsamount1 = $res39['tdsamount'];
					$writeoffamount1 = $res39['writeoffamount'];
					
					$cashamount31 = $cashamount31 + $cashamount1;
					//echo $cashamount21;
					$cardamount31 = $cardamount31 + $cardamount1;
					$onlineamount31 = $onlineamount31 + $onlineamount1;
					$chequeamount31 = $chequeamount31 + $chequeamount1;
					$tdsamount31 = $tdsamount31 + $tdsamount1;
					$writeoffamount31 = $writeoffamount31 + $writeoffamount1;
			
			}
			
			$totalpayment3 = $cashamount31 + $chequeamount31 + $onlineamount31 + $cardamount31;
				$netpayment3 = $totalpayment3 + $tdsamount31 + $writeoffamount31;
				$balanceamount3 = $billtotalamount1 - $netpayment3;
				
		
			
				$billtotalamount1 = number_format($billtotalamount1, 2, '.', '');
				$netpayment3 = number_format($netpayment3, 2, '.', '');
				$balanceamount3 = number_format($balanceamount3, 2, '.', '');
			if ($balanceamount3 != '0.00')
			{
			$number=$number+1;
			}
			
			//echo $balanceamount3;
			$cashamount31 = '0.00';
				$cardamount31 = '0.00';
				$onlineamount31 = '0.00';
				$chequeamount31 = '0.00';
				$tdsamount31 = '0.00';
				$writeoffamount31 = '0.00';

				$totalpayment3 = '0.00';
				$netpayment3 = '0.00';
				$balanceamount3 = '0.00';
				
				$billtotalamount1 = '0.00';
				$netpayment3 = '0.00';
				$balanceamount3 = '0.00';
				
				$billstatus = '0.00';
				
				
	}
	
	$queryipf29 = "select * from billing_ip where accountname like '%$suppliername%'";
	$execipf29 = mysql_query($queryipf29) or die ("Error in Query29".mysql_error());
	while ($resipf29 = mysql_fetch_array($execipf29))
	{
	$billnumber1 = $resipf29['billno'];
	$billtotalamount1 = $resipf29['totalamount'];
	
	$queryipf39 = "select * from master_transactionpaylater where billnumber = '$billnumber1' and companyanum='$companyanum' and recordstatus <>'deallocated'";
				$execipf39 = mysql_query($queryipf39) or die ("Error in Query3".mysql_error());
			while ($resipf39 = mysql_fetch_array($execipf39))
			{
			        $cashamount1 = $resipf39['cashamount'];
					$onlineamount1 = $resipf39['onlineamount'];
					$chequeamount1 = $resipf39['chequeamount'];
					$cardamount1 = $resipf39['cardamount'];
						
					$cashamount31 = $cashamount31 + $cashamount1;
					//echo $cashamount21;
					$cardamount31 = $cardamount31 + $cardamount1;
					$onlineamount31 = $onlineamount31 + $onlineamount1;
					$chequeamount31 = $chequeamount31 + $chequeamount1;
					
			}
			
			$totalpayment3 = $cashamount31 + $chequeamount31 + $onlineamount31 + $cardamount31;
				$netpayment3 = $totalpayment3;
				$balanceamount3 = $billtotalamount1 - $netpayment3;
				
		
			
				$billtotalamount1 = number_format($billtotalamount1, 2, '.', '');
				$netpayment3 = number_format($netpayment3, 2, '.', '');
				$balanceamount3 = number_format($balanceamount3, 2, '.', '');
			if ($balanceamount3 != '0.00')
			{
			$number=$number+1;
			}
			
			//echo $balanceamount3;
			$cashamount31 = '0.00';
				$cardamount31 = '0.00';
				$onlineamount31 = '0.00';
				$chequeamount31 = '0.00';
				$tdsamount31 = '0.00';
				$writeoffamount31 = '0.00';

				$totalpayment3 = '0.00';
				$netpayment3 = '0.00';
				$balanceamount3 = '0.00';
				
				$billtotalamount1 = '0.00';
				$netpayment3 = '0.00';
				$balanceamount3 = '0.00';
				
				$billstatus = '0.00';
				
				
	}
	
	$queryipfc29 = "select * from billing_ipcreditapprovedtransaction where accountname like '%$suppliername%'";
	$execipfc29 = mysql_query($queryipfc29) or die ("Error in Query29".mysql_error());
	while ($resipfc29 = mysql_fetch_array($execipfc29))
	{
	$billnumber1 = $resipfc29['billno'];
	$billtotalamount1 = $resipfc29['totalamount'];
	
	$queryipfc39 = "select * from master_transactionpaylater where billnumber = '$billnumber1' and companyanum='$companyanum' and recordstatus <>'deallocated'";
				$execipfc39 = mysql_query($queryipfc39) or die ("Error in Query3".mysql_error());
			while ($resipfc39 = mysql_fetch_array($execipfc39))
			{
			        $cashamount1 = $resipfc39['cashamount'];
					$onlineamount1 = $resipfc39['onlineamount'];
					$chequeamount1 = $resipfc39['chequeamount'];
					$cardamount1 = $resipfc39['cardamount'];
						
					$cashamount31 = $cashamount31 + $cashamount1;
					//echo $cashamount21;
					$cardamount31 = $cardamount31 + $cardamount1;
					$onlineamount31 = $onlineamount31 + $onlineamount1;
					$chequeamount31 = $chequeamount31 + $chequeamount1;
					
			}
			
			$totalpayment3 = $cashamount31 + $chequeamount31 + $onlineamount31 + $cardamount31;
				$netpayment3 = $totalpayment3;
				$balanceamount3 = $billtotalamount1 - $netpayment3;
				
		
			
				$billtotalamount1 = number_format($billtotalamount1, 2, '.', '');
				$netpayment3 = number_format($netpayment3, 2, '.', '');
				$balanceamount3 = number_format($balanceamount3, 2, '.', '');
			if ($balanceamount3 != '0.00')
			{
			$number=$number+1;
			}
			
			//echo $balanceamount3;
			$cashamount31 = '0.00';
				$cardamount31 = '0.00';
				$onlineamount31 = '0.00';
				$chequeamount31 = '0.00';
				$tdsamount31 = '0.00';
				$writeoffamount31 = '0.00';

				$totalpayment3 = '0.00';
				$netpayment3 = '0.00';
				$balanceamount3 = '0.00';
				
				$billtotalamount1 = '0.00';
				$netpayment3 = '0.00';
				$balanceamount3 = '0.00';
				
				$billstatus = '0.00';
				
				
	}
	
	$queryipfcdebit29 = "select * from ip_debitnote where accountname like '%$suppliername%'";
	$execipfcdebit29 = mysql_query($queryipfcdebit29) or die ("Error in Query29".mysql_error());
	while ($resipfcdebit29 = mysql_fetch_array($execipfcdebit29))
	{
	$billnumber1 = $resipfcdebit29['billno'];
	$billtotalamount1 = $resipfcdebit29['totalamount'];
	
	$queryipfcdebit39 = "select * from master_transactionpaylater where billnumber = '$billnumber1' and companyanum='$companyanum' and recordstatus <>'deallocated'";
				$execipfcdebit39 = mysql_query($queryipfcdebit39) or die ("Error in Query3".mysql_error());
			while ($resipfcdebit39 = mysql_fetch_array($execipfcdebit39))
			{
			        $cashamount1 = $resipfcdebit39['cashamount'];
					$onlineamount1 = $resipfcdebit39['onlineamount'];
					$chequeamount1 = $resipfcdebit39['chequeamount'];
					$cardamount1 = $resipfcdebit39['cardamount'];
						
					$cashamount31 = $cashamount31 + $cashamount1;
					//echo $cashamount21;
					$cardamount31 = $cardamount31 + $cardamount1;
					$onlineamount31 = $onlineamount31 + $onlineamount1;
					$chequeamount31 = $chequeamount31 + $chequeamount1;
					
			}
			
			$totalpayment3 = $cashamount31 + $chequeamount31 + $onlineamount31 + $cardamount31;
				$netpayment3 = $totalpayment3;
				$balanceamount3 = $billtotalamount1 - $netpayment3;
				
		
			
				$billtotalamount1 = number_format($billtotalamount1, 2, '.', '');
				$netpayment3 = number_format($netpayment3, 2, '.', '');
				$balanceamount3 = number_format($balanceamount3, 2, '.', '');
			if ($balanceamount3 != '0.00')
			{
			$number=$number+1;
			}
			
			//echo $balanceamount3;
			$cashamount31 = '0.00';
				$cardamount31 = '0.00';
				$onlineamount31 = '0.00';
				$chequeamount31 = '0.00';
				$tdsamount31 = '0.00';
				$writeoffamount31 = '0.00';

				$totalpayment3 = '0.00';
				$netpayment3 = '0.00';
				$balanceamount3 = '0.00';
				
				$billtotalamount1 = '0.00';
				$netpayment3 = '0.00';
				$balanceamount3 = '0.00';
				
				$billstatus = '0.00';
				
				
	}

	
	

?>