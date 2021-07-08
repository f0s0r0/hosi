<?php

include ("includes/loginverify.php");
include ("db/db_connect.php");
$grandtotal = '';
$grandtotal1 = "0.00";
$balanceamount1 = '';
		$query28 = "select * from paymentmodecredit where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		$exec28 = mysql_query($query28) or die ("Error in Query2".mysql_error());
		while ($res28= mysql_fetch_array($exec28))
		{
		$res2transactiondate8 = $res28['billdate'];
		$res2billnumber8 = $res28['billnumber'];
		$res2accountname = $res28['accountname'];
		$cashamount28 = $res28['cash']; 
		$cardamount28 = $res28['card'];
		$chequeamount28 = $res28['cheque'];
		$onlineamount28 = $res28['online'];
		$mpesaamount28 = $res28['mpesa'];
		$totalamount38 = $cashamount28 + $cardamount28 + $chequeamount28 + $onlineamount28 + $mpesaamount28;
		$grandtotal1 = $grandtotal1 + $totalamount38;
		?>
		
		<?php
		}
		
		?>
<?php
				$query1 = "select sum(cash) as cash,sum(cheque) as cheque,sum(card) as card,sum(online) as online,sum(mpesa) as mpesa from paymentmodedebit where billdate < '$ADate1'";
		  $exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		  $res1 = mysql_fetch_array($exec1);
		  $num1 = mysql_num_rows($exec1);
		  $cashamount = $res1['cash'];
		  $cardamount = $res1['card'];
		  $chequeamount = $res1['cheque'];
		  $onlineamount = $res1['online'];
		  $mpesaamount = $res1['mpesa'];
		  $totalamount = $cashamount + $cardamount + $chequeamount + $onlineamount + $mpesaamount;
		  
		  $query4 = "select sum(cash) as cash,sum(cheque) as cheque,sum(card) as card,sum(online) as online,sum(mpesa) as mpesa from paymentmodecredit where billdate < '$ADate1'";
		  $exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		  $res4 = mysql_fetch_array($exec4);
		  $num4 = mysql_num_rows($exec4);
		  $cashamount1 = $res4['cash'];
		  $cardamount1 = $res4['card'];
		  $chequeamount1 = $res4['cheque'];
		  $onlineamount1 = $res4['online'];
		  $mpesaamount1 = $res4['mpesa'];
		  $totalamount1 = $cashamount1 + $cardamount1 + $chequeamount1 + $onlineamount1 + $mpesaamount1;
		  
		 $openingbalance = $totalamount;
				?>
				
				<?php
				  $query2 = "select * from paymentmodedebit where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		  while ($res2 = mysql_fetch_array($exec2))
		  {
     	  $res2transactiondate = $res2['billdate'];
		  $res2billnumber = $res2['billnumber'];
		  $cashamount2 = $res2['cash'];
		  $cashcoa =  $res2['cashcoa'];
		  $cardamount2 = $res2['card'];
		  $cardcoa =  $res2['cardcoa'];
		  $chequeamount2 = $res2['cheque'];
		  $chequecoa =  $res2['chequecoa'];
		  $onlineamount2 = $res2['online'];
		  $onlinecoa =  $res2['onlinecoa'];
		  $mpesaamount2 = $res2['mpesa'];
		  $mpesacoa =  $res2['mpesacoa'];
		  $query21 = "select * from master_accountname where id='$cashcoa' or id='$cardcoa' or id='$chequecoa' or id='$onlinecoa' or id='$mpesacoa'";
		  $exec21 = mysql_query($query21) or die(mysql_error());
		  $res21 = mysql_fetch_array($exec21);
		  $accountssub = $res21['accountssub'];
		  
		  $query212 = "select * from master_accountssub where auto_number='$accountssub'";
		  $exec212 = mysql_query($query212) or die(mysql_error());
		  $res212 = mysql_fetch_array($exec212);
		  $accountssubname = $res212['accountssub'];
		  
		   $totalamount3 = $cashamount2 + $cardamount2 + $chequeamount2 + $onlineamount2 + $mpesaamount2;
		
		 
			$grandtotal = $grandtotal + $totalamount3;
	
			?>
			
         
			<?php
			}
			$grandtotal = $grandtotal + $openingbalance
			?>
			<?php
			$totalbalanceamount = '';
			$query2 = "select * from master_transactionpaylater where transactiontype = 'finalize'";
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			while ($res2 = mysql_fetch_array($exec2))
			{
			$cardamount21 = '';
			$onlineamount21 = '';
			$chequeamount21 = '';
			$tdsamount21 = '';
			$writeoffamount21 = '';
			$cashamount21 = 0.00;
			$billnumber = $res2['billnumber'];
			$billtotalamount = $res2['transactionamount'];
			
			    $query3 = "select * from master_transactionpaylater where billnumber = '$billnumber' and transactiontype = 'PAYMENT' and transactionmodule = 'PAYMENT' and companyanum='$companyanum' and recordstatus <>'deallocated'";
				$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
				$numbr=mysql_num_rows($exec3);
				//echo $numbr;
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
				$balanceamount = $billtotalamount - $netpayment;
				$totalbalanceamount = $totalbalanceamount + $balanceamount;
			}
		  $query72 = "select sum(transactionamount) as onaccountamount from master_transactionpaylater where transactionstatus = 'onaccount' and transactiondate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec72 = mysql_query($query72) or die ("Error in Query72".mysql_error());
		  $res72 = mysql_fetch_array($exec72);
		  $onaccountamount = $res72['onaccountamount'];
		  
		  
		  $totalbalanceamount = $totalbalanceamount - $onaccountamount;
			?>

	<?php
			$query894 = "select sum(amount) as totalnhif from billing_ipnhif where recorddate between '$ADate1' and '$ADate2'";
			$exec894 = mysql_query($query894) or die(mysql_error());
			while($res894 = mysql_fetch_array($exec894))
			{
			
			 $totalnhif = $res894['totalnhif'];
			 $totalnhif = -($totalnhif);
		
			}
	?>
	  <?php
	  $grandtot = $grandtotal - $grandtotal1;
	  $cashflowamount = $grandtot;
	  $grandtot = $grandtot + $totalbalanceamount + $totalnhif;
	 
	  ?>
	  
	  <?php
	  $grandbillamount = 0;
	  $query2 = "select * from master_purchase where recordstatus <> 'deleted' and companyanum = '$companyanum';";
			//$query2 = "select * from master_transaction where transactiontype = 'PAYMENT' and transactionmode <> 'CREDIT' and transactionmodule = 'SALES' and billnumber = '$billnumber' and companyanum='$companyanum' and recordstatus = ''";
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			$rowcount2 = mysql_num_rows($exec2);
			
			while ($res2 = mysql_fetch_array($exec2))
			{
			$cashamount21 = '';
			$cardamount21 = '';
			$onlineamount21 = '';
			$chequeamount21 = '';
			$tdsamount21 = '';
			$writeoffamount21 = '';
			$taxamount21 = '';
			
				$suppliername = $res2['suppliername'];
				$billnumber = $res2['billnumber'];
				$supplierbillnumber=$res2['supplierbillnumber'];
				$billnumberprefix = $res2['billnumberprefix'];
				$billnumberpostfix = $res2['billnumberpostfix'];
				$billdate = $res2['billdate'];
				$billtotalamount = $res2['totalamount'];
	
				    
				$grandbillamount = $grandbillamount + $billtotalamount;
				
			}
			
				$query51="select sum(transactionamount) as transactionamount from paymentmodecredit where source='supplierpaymententry'";
				$exec51 = mysql_query($query51) or die(mysql_error());
				$res51 = mysql_fetch_array($exec51);
				$netpayment = $res51['transactionamount'];  

			
			$balanceamount1 = $grandbillamount - $netpayment;
						$totalpaylaterpharmrefundamount = 0;		 
		  $query22 = "select sum(totalamount) as paylaterrefundamount from refund_paylater where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec22 = mysql_query($query22) or die ("Error in Query2".mysql_error());
		  $res22 = mysql_fetch_array($exec22);
		  $paylaterrefundamount = $res22['paylaterrefundamount'];
          $grandtot = $grandtot + $paylaterrefundamount;
		  
		   $query23 = "select * from pharmacysalesreturn_details where billstatus = 'completed' and entrydate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec23 = mysql_query($query23) or die ("Error in Query2".mysql_error());
		  while($res23 = mysql_fetch_array($exec23))
		  {
		  $paylaterpharmrefundpatientcode = $res23['patientcode'];
		  
		  $query231 = "select * from master_customer where customercode = '$paylaterpharmrefundpatientcode'";
		  $exec231 = mysql_query($query231) or die ("Error in Query2".mysql_error());
		  $res231 = mysql_fetch_array($exec231);
		  $patientrefundtype = $res231['billtype'];
		  
		  if($patientrefundtype == 'PAY LATER')
		  {
		  $paylaterpharmrefundamount = $res23['totalamount'];
		  $totalpaylaterpharmrefundamount = $totalpaylaterpharmrefundamount + $paylaterpharmrefundamount;
		  }
		  }
	$grandtot = $grandtot - $totalpaylaterpharmrefundamount;

	  ?>