<?php

		  $totalservice = 0;
		  $query2 = "select * from master_services group by itemname"; 
		  $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		  while ($res2 = mysql_fetch_array($exec2))
		  {
     	  $res2itemname = $res2['itemname'];
		  $res2rate = $res2['rateperunit'];
	
		  $query3 = "select * from billing_externalservices where servicesitemname = '$res2itemname' and billdate between '$transactiondatefrom' and '$transactiondateto'";
		  $exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
		  $num1 = mysql_num_rows($exec3);
		  //echo $num1;
		  $res3 = mysql_fetch_array($exec3);
		  
		  $query4 = "select * from billing_paylaterservices where servicesitemname = '$res2itemname' and billdate between '$transactiondatefrom' and '$transactiondateto' ";
		  $exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		  $num2 = mysql_num_rows($exec4);
		  //echo $num2;
		  $res4 = mysql_fetch_array($exec4);
		  
		  $query5 = "select * from billing_paynowservices where servicesitemname = '$res2itemname' and billdate between '$transactiondatefrom' and '$transactiondateto' ";
		  $exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
		  $num3 = mysql_num_rows($exec5);
		  //echo $num3;
		  $res5 = mysql_fetch_array($exec5);
		  
    	  $query6 = "select * from billing_ipservices where servicesitemname = '$res2itemname' and billdate between '$transactiondatefrom' and '$transactiondateto' ";
		  $exec6 = mysql_query($query6) or die ("Error in Query5".mysql_error());
		  $num6 = mysql_num_rows($exec6);
		  //echo $num3;
		  $res6 = mysql_fetch_array($exec6);

		  
		  $num4 = $num1 + $num2 + $num3 + $num6;
		  //$num4 = number_format($num4, '2', '.' ,''); 
		  
		  $amount = $num4 * $res2rate;
		  
		  
		  $totalservice = $totalservice + $amount;
		  
		  }
?>
