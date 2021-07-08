<?php
if($module == 'consultationbilling')
			{
			$totalconsultation = 0;
		   $query81 = "select * from billing_consultation where billdate < '$ADate1' order by auto_number desc";
		   $exec81 = mysql_query($query81) or die(mysql_error());
		   while ($res81= mysql_fetch_array($exec81))
		  {
     	   $resconsultationdate = $res81['billdate'];
		   $resconsultationamount = $res81['consultation'];
		   $resconsultationcoa = $res81['consultationcoa'];
		   $resbillnumber = $res81['billnumber'];
		   
		   $query811 = "select * from master_accountname where id='$resconsultationcoa'";
		   $exec811 = mysql_query($query811) or die(mysql_error());
		   $res811 = mysql_fetch_array($exec811);
		   $resconsultationcoaname = $res811['accountname'];
		  	  
			  $totalconsultation = $totalconsultation + $resconsultationamount;
			  
			  }
			  $openingbalancecredit = $totalconsultation;
			  }
			  
			  
			  if($module == 'lab')
			{
			$grandlabamount7 = 0;
			$reslabcoaname7 = '';
		   $query21 = "select * from billing_externallab where billdate < '$ADate1' order by auto_number desc";
		   $exec21 = mysql_query($query21) or die(mysql_error());
		   while ($res21= mysql_fetch_array($exec21))
		  {
     	   $reslabdate = $res21['billdate'];
		   $reslabamount = $res21['labitemrate'];
		   $reslabcoa = $res21['labcoa'];
		   $reslabbillnumber = $res21['billnumber'];
		   
		   $query8175 = "select * from master_accountname where id='$reslabcoa'";
		   $exec8175 = mysql_query($query8175) or die(mysql_error());
		   $res8175 = mysql_fetch_array($exec8175);
		   $reslabcoaname7 = $res8175['accountname'];
		  	  
		   $grandlabamount7 = $grandlabamount7 + $reslabamount;
		   
		   }
		   
		    $query22 = "select * from billing_iplab where billdate < '$ADate1' order by auto_number desc";
		   $exec22 = mysql_query($query22) or die(mysql_error());
		   while ($res22= mysql_fetch_array($exec22))
		  {
     	   $reslabdate = $res22['billdate'];
		   $reslabamount = $res22['labitemrate'];
		   $reslabcoa = $res22['labcoa'];
		   $reslabbillnumber = $res22['billnumber'];
		   
		   $query221 = "select * from master_accountname where id='$reslabcoa'";
		   $exec221 = mysql_query($query221) or die(mysql_error());
		   $res221 = mysql_fetch_array($exec221);
		   $reslabcoaname7 = $res221['accountname'];
		  	  
		   $grandlabamount7 = $grandlabamount7 + $reslabamount;
		   
		   }
		   
		   $query23 = "select * from billing_paylaterlab where billdate < '$ADate1' order by auto_number desc";
		   $exec23 = mysql_query($query23) or die(mysql_error());
		   while ($res23= mysql_fetch_array($exec23))
		  {
     	   $reslabdate = $res23['billdate'];
		   $reslabamount = $res23['labitemrate'];
		   $reslabcoa = $res23['labcoa'];
		   $reslabbillnumber = $res23['billnumber'];
		   
		   $query231 = "select * from master_accountname where id='$reslabcoa'";
		   $exec231 = mysql_query($query231) or die(mysql_error());
		   $res231 = mysql_fetch_array($exec231);
		   $reslabcoaname7 = $res231['accountname'];
		  	  
		   $grandlabamount7 = $grandlabamount7 + $reslabamount;
		   
		   }
		   
		   $query24 = "select * from billing_paynowlab where billdate < '$ADate1' order by auto_number desc";
		   $exec24 = mysql_query($query24) or die(mysql_error());
		   while ($res24 = mysql_fetch_array($exec24))
		  {
     	   $reslabdate = $res24['billdate'];
		   $reslabamount = $res24['labitemrate'];
		   $reslabcoa = $res24['labcoa'];
		   $reslabbillnumber = $res24['billnumber'];
		   
		   $query241 = "select * from master_accountname where id='$reslabcoa'";
		   $exec241 = mysql_query($query241) or die(mysql_error());
		   $res241 = mysql_fetch_array($exec241);
		   $reslabcoaname7 = $res241['accountname'];
		  	  
		   $grandlabamount7 = $grandlabamount7 + $reslabamount;
		   
		   }
		     $openingbalancecredit = $grandlabamount7;
		   }
		   ?>