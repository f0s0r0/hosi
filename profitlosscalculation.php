<?php

include ("includes/loginverify.php");
include ("db/db_connect.php");
$ipfinaldiscount = '';
$ipfinaldiscountcreditapproved = '';
		  $query2 = "select sum(consultation) as consultationamount from billing_consultation where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		  $res2 = mysql_fetch_array($exec2);
		  $consultationamount = $res2['consultationamount'];
		  
		  $query3 = "select sum(totalamount) as paynowamount from billing_paynow where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec3 = mysql_query($query3) or die ("Error in Query2".mysql_error());
		  $res3 = mysql_fetch_array($exec3);
		  $paynowamount = $res3['paynowamount'];
		  
		 	  
		  $query10 = "select sum(totalamount) as paylateramount from billing_paylater where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec10 = mysql_query($query10) or die ("Error in Query2".mysql_error());
		  $res10 = mysql_fetch_array($exec10);
		  $paylateramount = $res10['paylateramount'];
		  
		  $query61 = "select sum(totalamount) as externalamount from billing_external where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec61 = mysql_query($query61) or die ("Error in Query2".mysql_error());
		  $res61 = mysql_fetch_array($exec61);
		  $externalamount = $res61['externalamount'];

		  
		  $query8 = "select sum(transactionamount) as expenseamount from expensesub_details where transactiondate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec8 = mysql_query($query8) or die ("Error in Query2".mysql_error());
		  $res8 = mysql_fetch_array($exec8);
		  $expenseamount = $res8['expenseamount'];
		  
		  $query9 = "select * from master_company";
		  $exec9 = mysql_query($query9) or die(mysql_error());
		  $res9 = mysql_fetch_array($exec9);
		  $incometax = $res9['incometax'];
		  
		  /*$query15 = "select sum(totalamount) as consultationamount from billing_paylaterconsultation where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec15= mysql_query($query15) or die ("Error in Query2".mysql_error());
		  $res15 = mysql_fetch_array($exec15);
		  $consultationamountpaylater = $res15['consultationamount'];
	*/	  
		  
		  $query16 = "select sum(transactionamount) as receiptamount from receiptsub_details where transactiondate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec16 = mysql_query($query16) or die ("Error in Query2".mysql_error());
		  $res16 = mysql_fetch_array($exec16);
		  $receiptamount = $res16['receiptamount'];
		  
		  $query17 = "select sum(consultation) as consultationrefundamount from refund_consultation where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec17 = mysql_query($query17) or die ("Error in Query2".mysql_error());
		  $res17 = mysql_fetch_array($exec17);
		  $consultationrefundamount = $res17['consultationrefundamount'];
		  
		   $query18 = "select sum(labitemrate) as paynowlabrefundamount from refund_paynowlab where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec18 = mysql_query($query18) or die ("Error in Query2".mysql_error());
		  $res18 = mysql_fetch_array($exec18);
		  $paynowlabrefundamount = $res18['paynowlabrefundamount'];
		  
   	      $query19 = "select sum(radiologyitemrate) as paynowradiologyrefundamount from refund_paynowradiology where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec19 = mysql_query($query19) or die ("Error in Query2".mysql_error());
		  $res19 = mysql_fetch_array($exec19);
		  $paynowradiologyrefundamount = $res19['paynowradiologyrefundamount'];
		  
		  $query20 = "select sum(servicesitemrate) as paynowservicesrefundamount from refund_paynowservices where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec20 = mysql_query($query20) or die ("Error in Query2".mysql_error());
		  $res20 = mysql_fetch_array($exec20);
		  $paynowservicesrefundamount = $res20['paynowservicesrefundamount'];
		  
    	  $query20 = "select sum(amount) as paynowpharmacyrefundamount from refund_paynowpharmacy where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec20 = mysql_query($query20) or die ("Error in Query2".mysql_error());
		  $res20 = mysql_fetch_array($exec20);
		  $paynowpharmacyrefundamount = $res20['paynowpharmacyrefundamount'];
		  
		  $query21 = "select sum(referalrate) as paynowreferalrefundamount from refund_paynowreferal where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec21 = mysql_query($query21) or die ("Error in Query2".mysql_error());
		  $res21 = mysql_fetch_array($exec21);
		  $paynowreferalrefundamount = $res21['paynowreferalrefundamount'];

		  $totalrefundpaynow = $paynowlabrefundamount + $paynowradiologyrefundamount + $paynowservicesrefundamount + $paynowpharmacyrefundamount + $paynowreferalrefundamount;

		  $query22 = "select sum(totalamount) as paylaterrefundamount from refund_paylater where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec22 = mysql_query($query22) or die ("Error in Query2".mysql_error());
		  $res22 = mysql_fetch_array($exec22);
		  $paylaterrefundamount = $res22['paylaterrefundamount'];
		  
		  	   $query32 = "select sum(labitemrate) as ipfinallabamount from billing_iplab where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec32 = mysql_query($query32) or die ("Error in Query32".mysql_error());
		  $res32 = mysql_fetch_array($exec32);
		  $ipfinallabamount = $res32['ipfinallabamount'];
		  
   	      $query33 = "select sum(radiologyitemrate) as ipfinalradiologyamount from billing_ipradiology where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec33 = mysql_query($query33) or die ("Error in Query33".mysql_error());
		  $res33 = mysql_fetch_array($exec33);
		  $ipfinalradiologyamount = $res33['ipfinalradiologyamount'];
		  
		  $query34 = "select sum(servicesitemrate) as ipfinalservicesamount from billing_ipservices where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec34 = mysql_query($query34) or die ("Error in Query34".mysql_error());
		  $res34 = mysql_fetch_array($exec34);
		  $ipfinalservicesamount = $res34['ipfinalservicesamount'];
		  
    	  $query35 = "select sum(amount) as ipfinalpharmacyamount from billing_ippharmacy where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec35 = mysql_query($query35) or die ("Error in Query35".mysql_error());
		  $res35 = mysql_fetch_array($exec35);
		  $ipfinalpharmacyamount = $res35['ipfinalpharmacyamount'];
		  
		  $query36 = "select sum(amount) as ipfinalprivatedoctoramount from billing_ipprivatedoctor where recorddate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec36 = mysql_query($query36) or die ("Error in Query36".mysql_error());
		  $res36 = mysql_fetch_array($exec36);
		  $ipfinalprivatedoctoramount = $res36['ipfinalprivatedoctoramount'];
		  
		  $query37 = "select sum(amount) as ipfinalotbillingamount from billing_ipotbilling where recorddate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec37 = mysql_query($query37) or die ("Error in Query37".mysql_error());
		  $res37 = mysql_fetch_array($exec37);
		  $ipfinalotbillingamount = $res37['ipfinalotbillingamount'];


		  $query38 = "select sum(amount) as ipfinalmiscbilling from billing_ipmiscbilling where recorddate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec38 = mysql_query($query38) or die ("Error in Query38".mysql_error());
		  $res38 = mysql_fetch_array($exec38);
		  $ipfinalmiscbilling = $res38['ipfinalmiscbilling'];

  		  $query39 = "select sum(amount) as ipfinalbedcharges from billing_ipbedcharges where recorddate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec39 = mysql_query($query39) or die ("Error in Query39".mysql_error());
		  $res39 = mysql_fetch_array($exec39);
		 $ipfinalbedcharges = $res39['ipfinalbedcharges'];

 		  $query40 = "select sum(amount) as ipfinalambulance from billing_ipambulance where recorddate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec40= mysql_query($query40) or die ("Error in Query40".mysql_error());
		  $res40 = mysql_fetch_array($exec40);
		 $ipfinalambulance = $res40['ipfinalambulance'];
		  
		  $query41 = "select sum(amount) as ipfinalnhif from billing_ipnhif where recorddate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec41= mysql_query($query41) or die ("Error in Query41".mysql_error());
		  $res41 = mysql_fetch_array($exec41);
		  $ipfinalnhif = $res41['ipfinalnhif'];


		  $query43 = "select sum(amount) as ipfinaladmissioncharge from billing_ipadmissioncharge where recorddate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec43= mysql_query($query43) or die ("Error in Query43".mysql_error());
		  $res43 = mysql_fetch_array($exec43);
			 $ipfinaladmissioncharge = $res43['ipfinaladmissioncharge'];
		  
		  if($ipfinaladmissioncharge != '')
		  {
		  
		  $query42 = "select sum(discount) as ipfinaldiscount,sum(deposit) as  ipfinaldeposit from billing_ip where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec42= mysql_query($query42) or die ("Error in Query42".mysql_error());
		  $res42 = mysql_fetch_array($exec42);
		  $ipfinaldiscount = $res42['ipfinaldiscount'];
		  $ipfinaldeposit = $res42['ipfinaldeposit'];
		  
		  $query421 = "select sum(discount) as ipfinaldiscount,sum(deposit) as  ipfinaldeposit from billing_ipcreditapproved where billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec421= mysql_query($query421) or die ("Error in Query42".mysql_error());
		  $res421 = mysql_fetch_array($exec421);
		  $ipfinaldiscountcreditapproved = $res421['ipfinaldiscount'];
		  $ipfinaldepositcreditapproved = $res421['ipfinaldeposit'];

		  }

					
			$totalipamount = $ipfinallabamount  + $ipfinaladmissioncharge  + $ipfinalambulance + $ipfinalbedcharges + $ipfinalmiscbilling + $ipfinalotbillingamount  + $ipfinalpharmacyamount + $ipfinalservicesamount +  $ipfinalradiologyamount - $ipfinaldiscount - $ipfinaldiscountcreditapproved;



		  include("costofgoodssoldcalculation.php");
		  $costofgoodssold = $grandtotalcogs;
		  $totalrevenue = $consultationamount  + $paynowamount + $paylateramount + $totalipamount + $externalamount;
		  $totalrevenue = $totalrevenue - $consultationrefundamount - $totalrefundpaynow + $paylaterrefundamount;
		  
		  $totalpaylaterpharmrefundamount = 0;
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
		  $totalrevenue = $totalrevenue - $totalpaylaterpharmrefundamount;
		  
		    $query661 = "select sum(costofsales) as labcogs from cogsentry where coa='02-2003' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec661 = mysql_query($query661) or die(mysql_error());
		  $res661 = mysql_fetch_array($exec661);
		  $labcogs = $res661['labcogs'];
		  
		  $query6611 = "select sum(costofsales) as labcogs from cogsentry where coa='02-2004' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec6611 = mysql_query($query6611) or die(mysql_error());
		  $res6611 = mysql_fetch_array($exec6611);
		  $labcogs1 = $res6611['labcogs'];
		  
		  $totallabcogs = $labcogs + $labcogs1;

		  
		  $query663 = "select sum(costofsales) as radiologycogs from cogsentry where coa='02-2007' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec663 = mysql_query($query663) or die(mysql_error());
		  $res663 = mysql_fetch_array($exec663);
		  $radiologycogs = $res663['radiologycogs'];
		  
		  $query6631 = "select sum(costofsales) as radiologycogs from cogsentry where coa='02-2008' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec6631 = mysql_query($query6631) or die(mysql_error());
		  $res6631 = mysql_fetch_array($exec6631);
		  $radiologycogs1 = $res6631['radiologycogs'];
		  
		  $totalradiologycogs = $radiologycogs + $radiologycogs1;


		  $query664 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2009' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec664 = mysql_query($query664) or die(mysql_error());
		  $res664 = mysql_fetch_array($exec664);
		  $servicecogs = $res664['servicecogs'];
		  
		   $query6641 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2002' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec6641 = mysql_query($query6641) or die(mysql_error());
		  $res6641 = mysql_fetch_array($exec6641);
		  $servicecogs1 = $res6641['servicecogs'];
		  
		   $query6642 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2006' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec6642 = mysql_query($query6642) or die(mysql_error());
		  $res6642 = mysql_fetch_array($exec6642);
		  $servicecogs2 = $res6642['servicecogs'];
		  
		  $query6643 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2008' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec6643 = mysql_query($query6643) or die(mysql_error());
		  $res6643 = mysql_fetch_array($exec6643);
		  $servicecogs3 = $res6643['servicecogs'];
		  
		  $query6644 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2010' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec6644 = mysql_query($query6644) or die(mysql_error());
		  $res6644 = mysql_fetch_array($exec6644);
		  $servicecogs4 = $res6644['servicecogs'];
		  
		  $query6645 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2011' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec6645 = mysql_query($query6645) or die(mysql_error());
		  $res6645 = mysql_fetch_array($exec6645);
		  $servicecogs5 = $res6645['servicecogs'];
		  
    	  $query6646 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2012' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec6646 = mysql_query($query6646) or die(mysql_error());
		  $res6646 = mysql_fetch_array($exec6646);
		  $servicecogs6 = $res6646['servicecogs'];
		  
		  $query6647 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2013' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec6647 = mysql_query($query6647) or die(mysql_error());
		  $res6647 = mysql_fetch_array($exec6647);
		  $servicecogs7 = $res6647['servicecogs'];
		  
		   $query6648 = "select sum(costofsales) as servicecogs from cogsentry where coa='02-2014' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec6648 = mysql_query($query6648) or die(mysql_error());
		  $res6648 = mysql_fetch_array($exec6648);
		  $servicecogs8 = $res6648['servicecogs'];
		  
		  $totalservicecogs = $servicecogs1 + $servicecogs2 + $servicecogs3 + $servicecogs4 + $servicecogs5 + $servicecogs6 + $servicecogs7 + $servicecogs8;


		  
		  $query662 = "select sum(staffexpenses) as staffexpenses,sum(utility) as utility,sum(misc) as misc from cogsentry where coa='01-1003' and transactiondate between '$ADate1' and '$ADate2'";
		  $exec662 = mysql_query($query662) or die(mysql_error());
		  $res662 = mysql_fetch_array($exec662);
		  $staffexpenses = $res662['staffexpenses'];
		   $utility = $res662['utility'];
		    $misc = $res662['misc'];
			$totalcogsentryvalue = $staffexpenses + $utility + $misc;

		  		$query663 = "select sum(assetvalue) as totalassets from depreciation_information where recorddate between '$ADate1' and '$ADate2'";
			$exec663 = mysql_query($query663) or die(mysql_error());
			$res663 = mysql_fetch_array($exec663);
			$totalfixedassets = $res663['totalassets'];
			
		    $currentyear = substr($currentdate,6,10);
			$totaldepreciation = 0;
			$query664 = "select * from depreciation_information where recorddate between '$ADate1' and '$ADate2'";
			$exec664 = mysql_query($query664) or die(mysql_error());
			while($res664 = mysql_fetch_array($exec664))
			{
			$startyear = $res664['startyear'];
			$depreciation = $res664['depreciation'];
			$differenceyear = $currentyear - $startyear;
			if($startyear != $currentyear)
			{
			$depreciation = $depreciation * $differenceyear;
			}
			$totaldepreciation = $totaldepreciation + $depreciation;
			}
			
			$netexpense = $totalfixedassets - $totaldepreciation;
	
		  $grossprofit = ($totalrevenue + $receiptamount) - $costofgoodssold - $totallabcogs - $totalradiologycogs - $totalservicecogs;
		  $incomefromoperations = $grossprofit - $expenseamount - $totalcogsentryvalue - $totaldepreciation;
		  $nonoperatingitems = 0;
		  $incomebeforetaxes = $incomefromoperations - $nonoperatingitems;
		  $taxamount = $incometax * $incomebeforetaxes;
		  $taxamount = $taxamount/100;
		  $netincome = $incomebeforetaxes - $taxamount;
		  
		  
?>