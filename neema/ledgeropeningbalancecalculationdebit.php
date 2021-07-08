<?php

	 if($module == 'consultationbilling')
			{
			$totalconsultationrefund = 0;
		   $query82 = "select * from refund_consultation where billdate < '$ADate1' order by auto_number desc";
		   $exec82 = mysql_query($query82) or die(mysql_error());
		   while ($res82= mysql_fetch_array($exec82))
		  {
     	   $resconsultationrefunddate = $res82['billdate'];
		   $resconsultationrefundamount = $res82['consultation'];
		   $resconsultationrefundcoa = $res82['consultationcoa'];
		   $resbillnumberrefund = $res82['billnumber'];
		   
		   $query821 = "select * from master_accountname where id='$resconsultationrefundcoa'";
		   $exec821 = mysql_query($query821) or die(mysql_error());
		   $res821 = mysql_fetch_array($exec821);
		   $resconsultationrefundcoaname = $res821['accountname'];
		  	  
		   $totalconsultationrefund = $totalconsultationrefund + $resconsultationrefundamount;
		   }
		   $openingbalancedebit = $totalconsultationrefund;
		   }
		   
		    if($module == 'lab')
			{
			$totallabrefund = 0;
		   $query25= "select * from refund_paylaterlab where billdate < '$ADate1' order by auto_number desc";
		   $exec25 = mysql_query($query25) or die(mysql_error());
		   while ($res25= mysql_fetch_array($exec25))
		  {
     	   $reslabrefunddate = $res25['billdate'];
		   $reslabrefundamount = $res25['labitemrate'];
		   $reslabrefundcoa = $res25['labcoa'];
		   $resbillnumberlabrefund = $res25['billnumber'];
		   
		   $query251 = "select * from master_accountname where id='$reslabrefundcoa'";
		   $exec251 = mysql_query($query251) or die(mysql_error());
		   $res251 = mysql_fetch_array($exec251);
		   $reslabrefundcoaname = $res251['accountname'];
		  	  
		   $totallabrefund = $totallabrefund + $reslabrefundamount;
		   
		   }
		   
		   	
		   $query26= "select * from refund_paynowlab where billdate < '$ADate1' order by auto_number desc";
		   $exec26 = mysql_query($query26) or die(mysql_error());
		   while ($res26= mysql_fetch_array($exec26))
		  {
     	   $reslabrefunddate = $res26['billdate'];
		   $reslabrefundamount = $res26['labitemrate'];
		   $reslabrefundcoa = $res26['labcoa'];
		   $resbillnumberlabrefund = $res26['billnumber'];
		   
		   $query261 = "select * from master_accountname where id='$reslabrefundcoa'";
		   $exec261 = mysql_query($query261) or die(mysql_error());
		   $res261 = mysql_fetch_array($exec261);
		   $reslabrefundcoaname = $res261['accountname'];
		  	  
		   $totallabrefund = $totallabrefund + $reslabrefundamount;
		   
		   }
		    $openingbalancedebit = $totallabrefund;
		   }
?>