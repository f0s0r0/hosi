<?php
session_start();
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Hospitalrevenuereportdetailed.xls"');
header('Cache-Control: max-age=80');

$locationcode1=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
 $location=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
 
  $transactiondatefrom=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:'';
   $transactiondateto=isset($_REQUEST['ADate2'])?$_REQUEST['ADate2']:'';
   if($transactiondatefrom=='')
   {
   $transactiondatefrom = date('Y-m-d', strtotime('-1 month')); }
    if($transactiondateto==''){
   $transactiondateto =  date('Y-m-d');}
 
?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #FFF;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
<style type="text/css">
<!--
.bodytext3 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
-->
.bal
{
border-style:none;
background:none;
text-align:right;
}
.number
{
padding-left:900px;
text-align:right;
font-weight:bold;
}
.bali
{
text-align:right;
}
.style1 {font-weight: bold}
.style2 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
</style>
</head>

<body>
	
<?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

if ($cbfrmflag1 == 'cbfrmflag1')
{

	$fromdate=$_REQUEST['ADate1'];
	$todate=$_REQUEST['ADate2'];

	
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1415" 
            align="left" border="0">
          <tbody>
             <tr>
			 <td colspan="19" bgcolor="#FFF" class="bodytext31" align="left" valign="middle"><strong>Hospital Detail Revenue From : <?php echo $fromdate; ?> To : <?php echo $todate; ?></strong></td>
			 </tr>
			  <tr>
				    <td width="30" class="bodytext31" valign="center"  align="left" 
					bgcolor="#ffffff"><div align="center"><strong>S.No. </strong></div></td>
  				    <td width="97" class="bodytext31" valign="center"  align="left" 
					bgcolor="#ffffff"><div align="center"><strong>Patient</strong></div></td>
  				    <td width="99" class="bodytext31" valign="center"  align="left" 
					bgcolor="#ffffff"><div align="center"><strong>Reg No. </strong></div></td>
  				    <td width="99"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="center">IP&nbsp;No</div></td>
  				    <td width="99"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="right">Adm Fee </div></td>
                    <td width="99"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="right">IP&nbsp;Package</div></td>
  				    <td width="99"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="right">Bed</div></td>
  				    <td width="99"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="right">Nursing</div></td>
  				    <td width="99"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="right">RMO</div></td>
  				    <td width="99"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="right">Lab</div></td>
  				    <td width="99"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="right">Rad</div></td>
  				    <td width="99"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="right">Pharma</div></td>
  				    <td width="99"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="right">Services</div></td>
                    <!--VENU-- REMOVE OT-->
  				  <!--  <td width="23"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="right">OT</div></td>-->
                    <!--ENDS-->
  				    <td width="99"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Ambulance</strong></div></td>
                     <td width="99"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Homecare</strong></div></td>
				    <td width="99"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="right">Pvt Dr.</div></td>
                    <!--VENU -- REMOVE DEPOSIT-->
				   <!-- <td width="77"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="right">Deposit</div></td>
                    -->
                    <!--VENU -- REMOVE DISCOUNT-->
					<!--<td width="61"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="right">Discount</div></td>-->
                    <!--VENU -- REMOVE IP REFUND-->
                    <!--<td width="86"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="right">IP&nbsp;Refund</div></td>-->
                    <!--VENU -- RMEOVE NHIF-->
                    <!--<td width="57"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="right">NHIF</div></td>-->
                    <!--ENDS-->
					<td width="90"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="right">Misc&nbsp;Billing</div></td>
					<td width="64"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="right">Others</div></td>
					<td width="74"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="right">Total</div></td>
              </tr>					
        <?php
		$admissionamount=0.00;
		$ipdiscountamount = 0.00;
		$totaladmissionamount = 0.00;
		$totallabamount = 0.00;
		$totalpharmacyamount = 0.00;
		$totalradiologyamount = 0.00;
		$totalservicesamount = 0.00;
		//$totalotamount = 0.00;
		$totalambulanceamount = 0.00;
		$totalprivatedoctoramount = 0.00;
		$totalipbedcharges = 0.00;
		$totalipnursingcharges = 0.00;
		$totaliprmocharges = 0.00;
		$totalipdiscountamount = 0.00;
		$totalipmiscamount = 0.00;
		$totaltransactionamount = 0.00;
		$colorcode = '';
		$transactionamount = 0.00;
		$totalhospitalrevenue = '0.00';
		$totalpackagecharge=0.00;
		$totalhomecareamount=0.00;
		$totalotamount=0.00;
		$totaliprefundamount=0.00;
		$totalnhifamount =0.00;
		
		//VARIABLES FOR -- CREDITNOTE--
		
		
		$bedchgsdiscount=0;
		$labchgsdiscount=0;
		$nursechgsdiscount=0;
		$pharmachgsdiscount=0;
		$radchgsdiscount = 0;
		$rmochgsdiscount = 0;
		$servchgsdiscount = 0;
		
		$totbedchgdisc=0;
		$totlabchgdisc=0;
		$totnursechgdisc=0;
		$totpharmachgdisc=0;
		$totradchgdisc=0;
		$totrmochgdisc=0;
		$totservchgdisc=0;
		
		$brfbedchgsdiscount = 0;
		$brflabchgsdiscount = 0;
		$brfnursechgsdiscount = 0;
		$brfpharmachgsdiscount=0;
		$brfradchgsdiscount=0;
		$brfrmochgsdiscount = 0;
		$brfservchgsdiscount  = 0;
		
		$totbrfbeddisc=0;
		$totbrflabdisc=0;
		$totbrfnursedisc=0;
		$totbrfpharmadisc=0;
		$totbrfraddisc=0;
		$totbrfrmodisc=0;
		$totbrfservdisc=0;
		
		$totcreditnotebedchgs = 0;
		$totcreditnotelabchgs = 0; 
		$totcreditnotenursechgs = 0;
		$totcreditnotepharmachgs = 0; 
		$totcreditnoteradchgs = 0;
		$totcreditnotermochgs = 0;
		$totcreditnoteservchgs = 0;
		$totalbrfotherdisc = 0;
		
		$rowtotfinal = 0;
		
		
		
		//QUERY TO GET PATIENT DETAILS TO PASS
	   $query1 = "select  patientname,patientcode,visitcode from billing_ip where patientbilltype <> '' and locationcode='$locationcode1' and billdate between '$fromdate' and '$todate' group by visitcode  order by auto_number DESC ";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		
		while($res1 = mysql_fetch_array($exec1))
		{
		$patientname=$res1['patientname'];
		$patientcode=$res1['patientcode'];
		$visitcode=$res1['visitcode'];
		
	   	
		//VENU -- CHANGE QUERY
		 //$query112 = "select  sum(packagecharge)  from master_ipvisitentry where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and consultationdate between '$fromdate' and '$todate'  ";
		
		//TO GET TOTAL IP PACKAGE CHARGES AMOUNT  
		 $query112 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description!='Resident Doctor Charges' and description!='Ward Dispensing Charges' and description!='bed charges' and recorddate between '$fromdate' and '$todate' ";
		  
		$exec112 = mysql_query($query112) or die ("Error in Query112".mysql_error());
		$num112=mysql_num_rows($exec112);
		$res112 = mysql_fetch_array($exec112);
		 $packagecharge=$res112['sum(amount)'];
		$totalpackagecharge=$totalpackagecharge + $packagecharge; 

		//TO GET TOTAL ADMIN FEE
	     $query2 = "select  amount  from billing_ipadmissioncharge where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		 
		$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		$num2=mysql_num_rows($exec2);
		$res2 = mysql_fetch_array($exec2);				
		$admissionamount=$res2['amount'];
	    $totaladmissionamount=$totaladmissionamount + $admissionamount; 
		
		//TO GET TOTAL LAB AMOUNT
		  $query3 = "select sum(labitemrate) from billing_iplab where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
		$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
		$num3=mysql_num_rows($exec3);
	    $res3 = mysql_fetch_array($exec3);
		$labamount=$res3['sum(labitemrate)'];
		 $totallabamount=$totallabamount + $labamount;
		
		//TO GET TOTAL RADIOLOGY CHARGES AMOUNT
		  $query4 = "select sum(radiologyitemrate) from billing_ipradiology where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
		$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		$num4=mysql_num_rows($exec4);
		$res4 = mysql_fetch_array($exec4);
		$radiologyamount=$res4['sum(radiologyitemrate)'];
	   $totalradiologyamount=$totalradiologyamount + $radiologyamount;

		 //TO GET TOTAL PHARMACY CHARGES AMOUNT
		 $query5 = "select sum(amount) from billing_ippharmacy where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
		$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
		$num5=mysql_num_rows($exec5);
		$res5 = mysql_fetch_array($exec5);
		$pharmacyamount=$res5['sum(amount)'];
		 $totalpharmacyamount=$totalpharmacyamount + $pharmacyamount;
	
		//TO GET TOTAL SERVICE CHARGES AMOUNT
	    $query6 = "select sum(servicesitemrate) from billing_ipservices where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
		$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
		$num6=mysql_num_rows($exec6);
		$res6 = mysql_fetch_array($exec6);
		$servicesamount=$res6['sum(servicesitemrate)'];
           $totalservicesamount=$totalservicesamount + $servicesamount;
		
		//VENU -- REMOVE OT
		/* $query7 = "select sum(amount) from billing_ipotbilling where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
		$num7=mysql_num_rows($exec7);
		$res7 = mysql_fetch_array($exec7);
		$otamount=$res7['sum(amount)'];
		 $totalotamount=$totalotamount + $otamount;*/
	     
		 //TO GET TOTAL AMBULANCE CHARGES AMOUNT
	     $query8 = "select sum(amount) from billing_ipambulance where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
		$num8=mysql_num_rows($exec8);
		$res8 = mysql_fetch_array($exec8);
		$ambulanceamount=$res8['sum(amount)'];
		 $totalambulanceamount=$totalambulanceamount + $ambulanceamount;
		 
		 
		 //TO GET TOTAL HOME CARE CHARGES AMOUNT
		 $query81 = "select sum(amount) from billing_iphomecare where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		$exec81 = mysql_query($query81) or die ("Error in Query81".mysql_error());
		$num81=mysql_num_rows($exec81);
		$res81 = mysql_fetch_array($exec81);
		$homecareamount=$res81['sum(amount)'];
		 $totalhomecareamount=$totalhomecareamount + $homecareamount;
		
		//VENU -- CHANGE THE QUERY
		// $query8 = "select sum(amount) from billing_ipprivatedoctor where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		
		//TO GET TOTAL PRIVATE DOCTER CHARGES AMOUNT
		$query8 = "select sum(amount) from billing_ipprivatedoctor where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and billtype <>'' and recorddate between '$fromdate' and '$todate'  ";
		$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
		$num8=mysql_num_rows($exec8);
		$res8 = mysql_fetch_array($exec8);
		$privatedoctoramount=$res8['sum(amount)'];
		$totalprivatedoctoramount=$totalprivatedoctoramount + $privatedoctoramount;
		
		 //TO GET TOTAL BED CHARGES AMOUNT
		 $query9 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'bed charges' and recorddate between '$fromdate' and '$todate' ";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		 $num9=mysql_num_rows($exec9);
		$res9 = mysql_fetch_array($exec9);
		$ipbedcharges=$res9['sum(amount)'];
		$totalipbedcharges=$totalipbedcharges + $ipbedcharges;
		
    
		//VENU -- CHANGE THE QUERY
		
		//TO GET TOTAL IP NURSE CHARGES AMOUNT
	    $query10 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'Ward Dispensing Charges' and recorddate between '$fromdate' and '$todate' ";
		$exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());
		$num10=mysql_num_rows($exec10);
		$res10 = mysql_fetch_array($exec10);
		$ipnursingcharges=$res10['sum(amount)'];
		$totalipnursingcharges=$totalipnursingcharges + $ipnursingcharges;
		
		//VENU-CHANGING QUERY
		//$query11 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'RMO charges' and recorddate between '$fromdate' and '$todate' ";
		
		//TO GET TOTAL RMO CHARGES AMOUNT
		$query11 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'Resident Doctor Charges' and recorddate between '$fromdate' and '$todate' ";
		$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
		$num11=mysql_num_rows($exec11);
		$res11 = mysql_fetch_array($exec11);
		$iprmocharges=$res11['sum(amount)'];
		$totaliprmocharges=$totaliprmocharges + $iprmocharges;
		
		//VENU-- REMOVE DEPOSIT AMOUNT
		/*$query13 = "select sum(rate) from ip_discount where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and consultationdate between '$fromdate' and '$todate' ";
		$exec13 = mysql_query($query13) or die ("Error in Query13".mysql_error());
		$num13=mysql_num_rows($exec13);
		$res13 = mysql_fetch_array($exec13);
		$ipdiscountamount=$res13['sum(rate)'];
		
		$totalipdiscountamount=$totalipdiscountamount + $ipdiscountamount;*/
		//ENDS
		
		//VENU -- REMOVE IP REFUND
		/*$query133 = "select sum(amount) from deposit_refund where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";
		$exec133 = mysql_query($query133) or die ("Error in Query133".mysql_error());
		$num133=mysql_num_rows($exec133);
		$res133 = mysql_fetch_array($exec133);
		$iprefundamount=$res133['sum(amount)'];
		
		$totaliprefundamount=$totaliprefundamount + $iprefundamount;*/
		//ENDS
		
		//VENU -- REMOVE NHIF
		/*$query1333 = "select sum(nhifclaim) from ip_nhifprocessing where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and consultationdate between '$fromdate' and '$todate' ";
		$exec1333 = mysql_query($query1333) or die ("Error in Query1333".mysql_error());
		$num1333=mysql_num_rows($exec1333);
		$res1333 = mysql_fetch_array($exec1333);
		$nhifamount=$res1333['sum(nhifclaim)'];
		
		$totalnhifamount=$totalnhifamount + $nhifamount;*/
		//ENDS
		
		//TO GET TOTAL IP MISC BILL AMOUNT
		$query14 = "select sum(amount) from billing_ipmiscbilling where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";
		$exec14 = mysql_query($query14) or die ("Error in Query14".mysql_error());
		$num14=mysql_num_rows($exec14);
		$res14 = mysql_fetch_array($exec14);
		$ipmiscamount=$res14['sum(amount)'];
		$totalipmiscamount=$totalipmiscamount + $ipmiscamount;
		
		
		//TO GET PATIEN NAME, PATIENT REGISTER NUMBER, PATIEN VISIT CODE
		 $query15 = "select patientname,patientcode,visitcode from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";
		$exec15 = mysql_query($query15) or die ("Error in Query15".mysql_error());
		$num15=mysql_num_rows($exec15);
		
		$res15 = mysql_fetch_array($exec15);
		
		$res15patientname=$res1['patientname'];
		$res15patientcode=$res1['patientcode'];
		$res15visitcode=$res1['visitcode'];
		
		
		
		
		//TO GET TOTAL TRANSACTION AMOUNT
		$query12 = "select transactionamount,docno from master_transactionipdeposit where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and transactiondate between '$fromdate' and '$todate' ";
		$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
		$num12=mysql_num_rows($exec12);
		
		while($res12 = mysql_fetch_array($exec12))
		{
			 $transactionamount=$res12['transactionamount'];
			 $referencenumber=$res12['docno'];
			 $totaltransactionamount=$totaltransactionamount + $transactionamount;
		} 	
		
		$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#FFF"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#FFF"';
			}
			?>
          <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center">
			    <div align="center"><?php echo $res15patientname; ?></div>
			  </div></td>
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $res15patientcode; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left">
			      <div align="center"><?php echo $res15visitcode; ?></div></td>	
            
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($admissionamount,2,'.',','); ?></div></td>
                 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($packagecharge,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($ipbedcharges,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($ipnursingcharges,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($iprmocharges,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			      <div align="right"><?php echo number_format($labamount,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			      <div align="right"><?php echo number_format($radiologyamount,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			      <div align="right"><?php echo number_format($pharmacyamount,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			        <div align="right"><?php echo number_format($servicesamount,2,'.',','); ?></div></td>
                    <!--VENU -- REMOVE OT-->
				    <!--<td class="bodytext31" valign="center"  align="left">
			          <div align="right"><?php //echo number_format($otamount,2,'.',','); ?></div></td>-->
                    <!--ENDS-->  
				  <td class="bodytext31" valign="center"  align="left">
			        <div align="right"><?php echo number_format($ambulanceamount,2,'.',','); ?></div></td>
                    <td class="bodytext31" valign="center"  align="left">
			        <div align="right"><?php echo number_format($homecareamount,2,'.',','); ?></div></td>
				   <td class="bodytext31" valign="center"  align="left">
			         <div align="right"><?php echo number_format($privatedoctoramount,2,'.',','); ?></div></td>
                     
                     <!--VENU -- REMOVE DISCOUNT-->
				   <!-- <td class="bodytext31" valign="center"  align="left">
			         <div align="right"><?php //echo number_format($transactionamount,2,'.',','); ?></div></td>-->
				     <!--VENU -- REMOVE DISCOUNT-->
                     <!-- <td class="bodytext31" valign="center"  align="left">
                      <div align="right"><?php //echo number_format($ipdiscountamount,2,'.',','); ?></div></td>-->
                      <!--VENU REMOVE IPREFUND-->
                       <!--<td  align="left" valign="center" class="bodytext31"><div align="right"><?php //echo number_format($iprefundamount,2,'.',','); ?></div></td>-->
                       <!--VENU REMOVE NHIF-->
                        <!--<td  align="left" valign="center" class="bodytext31"><div align="right"><?php //echo number_format($nhifamount,2,'.',','); ?></div></td>-->
                      <!--ENDS-->  
				  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($ipmiscamount,2,'.',','); ?></div></td>
                  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format(0,2,'.',','); ?></div></td>
				  <?php
				  $rowtot1 = 0;
				  $rowtot1 = $admissionamount+$packagecharge+$ipbedcharges+$ipnursingcharges+$iprmocharges+$labamount+$radiologyamount+$pharmacyamount+$servicesamount+$ambulanceamount+
				  			 $homecareamount+$privatedoctoramount+$ipmiscamount;
				  $rowtotfinal = $rowtotfinal + $rowtot1;			 
				  ?>
				  <td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo number_format($rowtot1,2,'.',','); ?></strong></div></td>
                  </tr>
                  
                
				  
                  <!--ENDS-->
                  
                    <!--DISPLAY ROW DETAIL FOR DISCOUNT FROM ip_creditbrief -- BRIEF DATA-->
                  <?php
				  /*if($briefcreditpatientcount>0)
				  {
					*/ 
				?>
             
                 <?php   	
				 // }//ends if($briefcreditpatientcount>0)
				  ?>
                  <!--ENDS BRIEF DISCOUNT SHOW-->
		   <?php 
		    
		     }
			 
			$query186 = "select  patientname,patientcode,visitcode from billing_ipcreditapproved where locationcode='$locationcode1' and billdate between '$fromdate' and '$todate' group by visitcode  order by auto_number DESC ";
		$exec186 = mysql_query($query186) or die ("Error in Query186".mysql_error());
		$num186=mysql_num_rows($exec186);
		
		while($res186 = mysql_fetch_array($exec186))
		{ 
			 
		$patientname=$res186['patientname'];
		$patientcode=$res186['patientcode'];
		$visitcode=$res186['visitcode'];
		
	   	
		//VENU -- CHANGE QUERY
		 //$query112 = "select  sum(packagecharge)  from master_ipvisitentry where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and consultationdate between '$fromdate' and '$todate'  ";
		
		//TO GET TOTAL IP PACKAGE CHARGES AMOUNT  
		 $query112 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description!='Resident Doctor Charges' and description!='Ward Dispensing Charges' and description!='bed charges' and recorddate between '$fromdate' and '$todate' ";
		  
		$exec112 = mysql_query($query112) or die ("Error in Query112".mysql_error());
		$num112=mysql_num_rows($exec112);
		$res112 = mysql_fetch_array($exec112);
		 $packagecharge=$res112['sum(amount)'];
		$totalpackagecharge=$totalpackagecharge + $packagecharge; 

		//TO GET TOTAL ADMIN FEE
	     $query2 = "select  amount  from billing_ipadmissioncharge where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		 
		$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		$num2=mysql_num_rows($exec2);
		$res2 = mysql_fetch_array($exec2);				
		$admissionamount=$res2['amount'];
	    $totaladmissionamount=$totaladmissionamount + $admissionamount; 
		
		//TO GET TOTAL LAB AMOUNT
		  $query3 = "select sum(labitemrate) from billing_iplab where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
		$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
		$num3=mysql_num_rows($exec3);
	    $res3 = mysql_fetch_array($exec3);
		$labamount=$res3['sum(labitemrate)'];
		 $totallabamount=$totallabamount + $labamount;
		
		//TO GET TOTAL RADIOLOGY CHARGES AMOUNT
		  $query4 = "select sum(radiologyitemrate) from billing_ipradiology where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
		$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		$num4=mysql_num_rows($exec4);
		$res4 = mysql_fetch_array($exec4);
		$radiologyamount=$res4['sum(radiologyitemrate)'];
	   $totalradiologyamount=$totalradiologyamount + $radiologyamount;

		 //TO GET TOTAL PHARMACY CHARGES AMOUNT
		 $query5 = "select sum(amount) from billing_ippharmacy where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
		$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
		$num5=mysql_num_rows($exec5);
		$res5 = mysql_fetch_array($exec5);
		$pharmacyamount=$res5['sum(amount)'];
		 $totalpharmacyamount=$totalpharmacyamount + $pharmacyamount;
	
		//TO GET TOTAL SERVICE CHARGES AMOUNT
	    $query6 = "select sum(servicesitemrate) from billing_ipservices where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
		$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
		$num6=mysql_num_rows($exec6);
		$res6 = mysql_fetch_array($exec6);
		$servicesamount=$res6['sum(servicesitemrate)'];
           $totalservicesamount=$totalservicesamount + $servicesamount;
		
		//VENU -- REMOVE OT
		/* $query7 = "select sum(amount) from billing_ipotbilling where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
		$num7=mysql_num_rows($exec7);
		$res7 = mysql_fetch_array($exec7);
		$otamount=$res7['sum(amount)'];
		 $totalotamount=$totalotamount + $otamount;*/
	     
		 //TO GET TOTAL AMBULANCE CHARGES AMOUNT
	     $query8 = "select sum(amount) from billing_ipambulance where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
		$num8=mysql_num_rows($exec8);
		$res8 = mysql_fetch_array($exec8);
		$ambulanceamount=$res8['sum(amount)'];
		 $totalambulanceamount=$totalambulanceamount + $ambulanceamount;
		 
		 
		 //TO GET TOTAL HOME CARE CHARGES AMOUNT
		 $query81 = "select sum(amount) from billing_iphomecare where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		$exec81 = mysql_query($query81) or die ("Error in Query81".mysql_error());
		$num81=mysql_num_rows($exec81);
		$res81 = mysql_fetch_array($exec81);
		$homecareamount=$res81['sum(amount)'];
		 $totalhomecareamount=$totalhomecareamount + $homecareamount;
		
		//VENU -- CHANGE THE QUERY
		// $query8 = "select sum(amount) from billing_ipprivatedoctor where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		
		//TO GET TOTAL PRIVATE DOCTER CHARGES AMOUNT
		$query8 = "select sum(amount) from billing_ipprivatedoctor where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and billtype <>'' and recorddate between '$fromdate' and '$todate'  ";
		$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
		$num8=mysql_num_rows($exec8);
		$res8 = mysql_fetch_array($exec8);
		$privatedoctoramount=$res8['sum(amount)'];
		$totalprivatedoctoramount=$totalprivatedoctoramount + $privatedoctoramount;
		
		 //TO GET TOTAL BED CHARGES AMOUNT
		 $query9 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'bed charges' and recorddate between '$fromdate' and '$todate' ";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		 $num9=mysql_num_rows($exec9);
		$res9 = mysql_fetch_array($exec9);
		$ipbedcharges=$res9['sum(amount)'];
		$totalipbedcharges=$totalipbedcharges + $ipbedcharges;
		
    
		//VENU -- CHANGE THE QUERY
		
		//TO GET TOTAL IP NURSE CHARGES AMOUNT
	    $query10 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'Ward Dispensing Charges' and recorddate between '$fromdate' and '$todate' ";
		$exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());
		$num10=mysql_num_rows($exec10);
		$res10 = mysql_fetch_array($exec10);
		$ipnursingcharges=$res10['sum(amount)'];
		$totalipnursingcharges=$totalipnursingcharges + $ipnursingcharges;
		
		//VENU-CHANGING QUERY
		//$query11 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'RMO charges' and recorddate between '$fromdate' and '$todate' ";
		
		//TO GET TOTAL RMO CHARGES AMOUNT
		$query11 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'Resident Doctor Charges' and recorddate between '$fromdate' and '$todate' ";
		$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
		$num11=mysql_num_rows($exec11);
		$res11 = mysql_fetch_array($exec11);
		$iprmocharges=$res11['sum(amount)'];
		$totaliprmocharges=$totaliprmocharges + $iprmocharges;
		
		//VENU-- REMOVE DEPOSIT AMOUNT
		/*$query13 = "select sum(rate) from ip_discount where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and consultationdate between '$fromdate' and '$todate' ";
		$exec13 = mysql_query($query13) or die ("Error in Query13".mysql_error());
		$num13=mysql_num_rows($exec13);
		$res13 = mysql_fetch_array($exec13);
		$ipdiscountamount=$res13['sum(rate)'];
		
		$totalipdiscountamount=$totalipdiscountamount + $ipdiscountamount;*/
		//ENDS
		
		//VENU -- REMOVE IP REFUND
		/*$query133 = "select sum(amount) from deposit_refund where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";
		$exec133 = mysql_query($query133) or die ("Error in Query133".mysql_error());
		$num133=mysql_num_rows($exec133);
		$res133 = mysql_fetch_array($exec133);
		$iprefundamount=$res133['sum(amount)'];
		
		$totaliprefundamount=$totaliprefundamount + $iprefundamount;*/
		//ENDS
		
		//VENU -- REMOVE NHIF
		/*$query1333 = "select sum(nhifclaim) from ip_nhifprocessing where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and consultationdate between '$fromdate' and '$todate' ";
		$exec1333 = mysql_query($query1333) or die ("Error in Query1333".mysql_error());
		$num1333=mysql_num_rows($exec1333);
		$res1333 = mysql_fetch_array($exec1333);
		$nhifamount=$res1333['sum(nhifclaim)'];
		
		$totalnhifamount=$totalnhifamount + $nhifamount;*/
		//ENDS
		
		//TO GET TOTAL IP MISC BILL AMOUNT
		$query14 = "select sum(amount) from billing_ipmiscbilling where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";
		$exec14 = mysql_query($query14) or die ("Error in Query14".mysql_error());
		$num14=mysql_num_rows($exec14);
		$res14 = mysql_fetch_array($exec14);
		$ipmiscamount=$res14['sum(amount)'];
		$totalipmiscamount=$totalipmiscamount + $ipmiscamount;
		
		
		//TO GET PATIEN NAME, PATIENT REGISTER NUMBER, PATIEN VISIT CODE
		 $query15 = "select patientname,patientcode,visitcode from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";
		$exec15 = mysql_query($query15) or die ("Error in Query15".mysql_error());
		$num15=mysql_num_rows($exec15);
		
		$res15 = mysql_fetch_array($exec15);
		
		$res15patientname=$res1['patientname'];
		$res15patientcode=$res1['patientcode'];
		$res15visitcode=$res1['visitcode'];
		
		
		
		
		//TO GET TOTAL TRANSACTION AMOUNT
		$query12 = "select transactionamount,docno from master_transactionipdeposit where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and transactiondate between '$fromdate' and '$todate' ";
		$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
		$num12=mysql_num_rows($exec12);
		
		while($res12 = mysql_fetch_array($exec12))
		{
			 $transactionamount=$res12['transactionamount'];
			 $referencenumber=$res12['docno'];
			 $totaltransactionamount=$totaltransactionamount + $transactionamount;
		} 	
		
		$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#FFF"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#FFF"';
			}
			?>
          <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center">
			    <div align="center"><?php echo $patientname; ?></div>
			  </div></td>
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientcode; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left">
			      <div align="center"><?php echo $visitcode; ?></div></td>	
            
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($admissionamount,2,'.',','); ?></div></td>
                 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($packagecharge,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($ipbedcharges,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($ipnursingcharges,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($iprmocharges,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			      <div align="right"><?php echo number_format($labamount,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			      <div align="right"><?php echo number_format($radiologyamount,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			      <div align="right"><?php echo number_format($pharmacyamount,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			        <div align="right"><?php echo number_format($servicesamount,2,'.',','); ?></div></td>
                    <!--VENU -- REMOVE OT-->
				    <!--<td class="bodytext31" valign="center"  align="left">
			          <div align="right"><?php //echo number_format($otamount,2,'.',','); ?></div></td>-->
                    <!--ENDS-->  
				  <td class="bodytext31" valign="center"  align="left">
			        <div align="right"><?php echo number_format($ambulanceamount,2,'.',','); ?></div></td>
                    <td class="bodytext31" valign="center"  align="left">
			        <div align="right"><?php echo number_format($homecareamount,2,'.',','); ?></div></td>
				   <td class="bodytext31" valign="center"  align="left">
			         <div align="right"><?php echo number_format($privatedoctoramount,2,'.',','); ?></div></td>
                     
                     <!--VENU -- REMOVE DISCOUNT-->
				   <!-- <td class="bodytext31" valign="center"  align="left">
			         <div align="right"><?php //echo number_format($transactionamount,2,'.',','); ?></div></td>-->
				     <!--VENU -- REMOVE DISCOUNT-->
                     <!-- <td class="bodytext31" valign="center"  align="left">
                      <div align="right"><?php //echo number_format($ipdiscountamount,2,'.',','); ?></div></td>-->
                      <!--VENU REMOVE IPREFUND-->
                       <!--<td  align="left" valign="center" class="bodytext31"><div align="right"><?php //echo number_format($iprefundamount,2,'.',','); ?></div></td>-->
                       <!--VENU REMOVE NHIF-->
                        <!--<td  align="left" valign="center" class="bodytext31"><div align="right"><?php //echo number_format($nhifamount,2,'.',','); ?></div></td>-->
                      <!--ENDS-->  
				  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($ipmiscamount,2,'.',','); ?></div></td>
                  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format(0,2,'.',','); ?></div></td>
				  <?php
				  $rowtot2 = 0;
				  $rowtot2 = $admissionamount+$packagecharge+$ipbedcharges+$ipnursingcharges+$iprmocharges+$labamount+$radiologyamount+$pharmacyamount+$servicesamount+$ambulanceamount+
				  			 $homecareamount+$privatedoctoramount+$ipmiscamount;
							 
				  $rowtotfinal = $rowtotfinal + $rowtot2;			 
				  ?>
				  <td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo number_format($rowtot2,2,'.',','); ?></strong></div></td>
                  </tr>
                  
                
				  
                  <!--ENDS-->
                  
                    <!--DISPLAY ROW DETAIL FOR DISCOUNT FROM ip_creditbrief -- BRIEF DATA-->
                  <?php
				  /*if($briefcreditpatientcount>0)
				  {
					*/ 
				?>
             
                 <?php   	
				 // }//ends if($briefcreditpatientcount>0)
				  ?>
                  <!--ENDS BRIEF DISCOUNT SHOW-->
		   <?php 
		    
		     }
		   ?>
          
          <tr>
             <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td colspan="18" class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc"><strong>IP Credit</strong></td>
          </tr>    
          <!--CODE FOR CREDIT NOTE FROM ip_creditnotebrief -->
         
          <?php
         $qrycreditbrf = "select patientcode, patientvisitcode,patientname from ip_creditnotebrief where locationcode = '$locationcode1' and consultationdate between '$fromdate' and '$todate' group by patientcode";
		  $execcredibrf = mysql_query($qrycreditbrf) or die ("Error in qrycreditbrf".mysql_error());
	
		while($rescreditbrf = mysql_fetch_array($execcredibrf))
		{
   			$pcode = $rescreditbrf["patientcode"];
   			$vcode =$rescreditbrf["patientvisitcode"]; 
			$patienname = $rescreditbrf["patientname"];
		  
		  //TO GET DISCOUT FOR BED CHGS -- ip_creditnotebrief
		  $qrybrfbedchgsdisc = "select sum(rate) as brfbedchgsdisc from ip_creditnotebrief where description='Bed Charges'  AND patientcode = '$pcode' AND patientvisitcode = '$vcode'  and locationcode = '$locationcode1' and consultationdate between '$fromdate' and '$todate'";
		   $execbrfbedchgsdisc = mysql_query($qrybrfbedchgsdisc) or die ("Error in qrybrfbedchgsdisc".mysql_error());
		   $rescbrfbedchgsdisc= mysql_fetch_array($execbrfbedchgsdisc);
		   $brfbedchgsdiscount = $rescbrfbedchgsdisc['brfbedchgsdisc'];
		   
		   $totbrfbeddisc = $totbrfbeddisc + $brfbedchgsdiscount;
		   
		   	//TO GET DISCOUT FOR LAB CHGS -- ip_creditnotebrief
			$qrybrflabchgsdisc = "SELECT sum(rate) AS brflabchgsdisc FROM ip_creditnotebrief WHERE description='Lab'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$fromdate' and '$todate'";
			$execbrflabchgsdisc = mysql_query($qrybrflabchgsdisc) or die ("Error in qrybrflabchgsdisc".mysql_error());
			$rescbrflabchgsdisc= mysql_fetch_array($execbrflabchgsdisc);
			$brflabchgsdiscount = $rescbrflabchgsdisc['brflabchgsdisc'];
				
			$totbrflabdisc = $totbrflabdisc + $brflabchgsdiscount;
			
			//TO GET DISCOUT FOR NURSING CHGS -- ip_creditnotebrief
			$qrybrfnursechgsdisc = "SELECT sum(rate) AS brfnursechgsdisc FROM ip_creditnotebrief WHERE description='Nursing Charges'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$fromdate' and '$todate'";
			$execbrfnursechgsdisc = mysql_query($qrybrfnursechgsdisc) or die ("Error in qrybrfnursechgsdisc".mysql_error());
			$rescbrfnursechgsdisc= mysql_fetch_array($execbrfnursechgsdisc);
			$brfnursechgsdiscount = $rescbrfnursechgsdisc['brfnursechgsdisc'];
				
			$totbrfnursedisc = $totbrfnursedisc + $brfnursechgsdiscount;
			
			//TO GET DISCOUT FOR PHARMACY CHGS  -- ip_creditnotebrief
			$qrybrfpharmachgsdisc = "SELECT sum(rate) AS brfpharmachgsdisc FROM ip_creditnotebrief WHERE description='Pharmacy'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$fromdate' and '$todate'";
			$execbrfpharmachgsdisc = mysql_query($qrybrfpharmachgsdisc) or die ("Error in qrybrfpharmachgsdisc".mysql_error());
			$rescbrfpharmachgsdisc= mysql_fetch_array($execbrfpharmachgsdisc);
			$brfpharmachgsdiscount = $rescbrfpharmachgsdisc['brfpharmachgsdisc'];
				
			$totbrfpharmadisc = $totbrfpharmadisc + $brfpharmachgsdiscount ;
			
			
			//TO GET DISCOUT FOR RADIOLOGY CHGS  -- ip_creditnotebrief
			$qrybrfradchgsdisc = "SELECT sum(rate) AS brfradchgsdisc FROM ip_creditnotebrief WHERE description='Radiology'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$fromdate' and '$todate'";
			$execbrfradchgsdisc = mysql_query($qrybrfradchgsdisc) or die ("Error in qrybrfradchgsdisc".mysql_error());
			$rescbrfradchgsdisc= mysql_fetch_array($execbrfradchgsdisc);
			$brfradchgsdiscount = $rescbrfradchgsdisc['brfradchgsdisc'];
				
			$totbrfraddisc = $totbrfraddisc + $brfradchgsdiscount;
			
			//TO GET DISCOUT FOR RMO CHGS -- ip_creditnotebrief
			$qrybrfrmochgsdisc = "SELECT sum(rate) AS brfrmochgsdisc FROM ip_creditnotebrief WHERE description='RMO Charges'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$fromdate' and '$todate'";
			$execbrfrmochgsdisc = mysql_query($qrybrfrmochgsdisc) or die ("Error in qrybrfrmochgsdisc".mysql_error());
			$rescbrfrmochgsdisc= mysql_fetch_array($execbrfrmochgsdisc);
			$brfrmochgsdiscount = $rescbrfrmochgsdisc['brfrmochgsdisc'];
				
			$totbrfrmodisc = $totbrfrmodisc + $brfrmochgsdiscount;
			
			//TO GET DISCOUT FOR SERVICEE CHGS-- ip_creditnotebrief
			$qrybrfservchgsdisc = "SELECT sum(rate) AS brfservchgsdisc FROM ip_creditnotebrief WHERE description='Service'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$fromdate' and '$todate'";
			$execbrfservchgsdisc = mysql_query($qrybrfservchgsdisc) or die ("Error in qrybrfservchgsdisc".mysql_error());
			$rescbrfservchgsdisc= mysql_fetch_array($execbrfservchgsdisc);
			$brfservchgsdiscount = $rescbrfservchgsdisc['brfservchgsdisc'];
				
			$totbrfservdisc = $totbrfservdisc + $brfservchgsdiscount;
			
			$qrybrfotherdisc = "SELECT sum(rate) AS brfotherdisc FROM ip_creditnotebrief WHERE description='Others'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$fromdate' and '$todate'";
			$execbrfotherdisc = mysql_query($qrybrfotherdisc) or die ("Error in qrybrfotherdisc".mysql_error());
			$rescbrfotherdisc= mysql_fetch_array($execbrfotherdisc);
			$brfotherdisc = $rescbrfotherdisc['brfotherdisc'];
			
			$totalbrfotherdisc = $totalbrfotherdisc + $brfotherdisc;
			
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#FFF"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#FFF"';
			}
		 
		 ?>
         <!--DISPLAY CREDITNOTE DETAILS-->
            
          <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center">
			    <div align="center"><?php echo $patienname; ?></div>
			  </div></td>
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $pcode; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left">
			      <div align="center"><?php echo $vcode; ?></div></td>	
            
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format($admissionamount,2,'.',','); ?>0.00</div></td>
                 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format($packagecharge,2,'.',','); ?>0.00</div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php if($brfbedchgsdiscount!=0){echo "-".number_format($brfbedchgsdiscount,2,'.',',');} else { echo number_format($brfbedchgsdiscount,2,'.',','); } ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php if($brfnursechgsdiscount!=0){echo "-".number_format($brfnursechgsdiscount,2,'.',',');}else{ echo number_format($brfnursechgsdiscount,2,'.',',');} ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php if($brfrmochgsdiscount!=0){echo "-".number_format($brfrmochgsdiscount,2,'.',',');}else{echo number_format($brfrmochgsdiscount,2,'.',',');} ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php if($brflabchgsdiscount!=0){echo  "-".number_format($brflabchgsdiscount,2,'.',',');}else{echo  number_format($brflabchgsdiscount,2,'.',',');} ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="right"><?php if($brfradchgsdiscount!=0){echo "-".number_format($brfradchgsdiscount,2,'.',',');}else{echo number_format($brfradchgsdiscount,2,'.',',');} ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="right"><?php if($brfpharmachgsdiscount!=0){echo "-".number_format($brfpharmachgsdiscount,2,'.',',');} else { echo number_format($brfpharmachgsdiscount,2,'.',','); } ?></div></td>
				  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php if($brfservchgsdiscount!=0){echo "-".number_format($brfservchgsdiscount,2,'.',',');}else{ echo number_format($brfservchgsdiscount,2,'.',',');} ?></div></td>
                    <!--VENU -- REMOVE OT-->
				    <!--<td class="bodytext31" valign="center"  align="left">
			          <div align="right"><?php //echo number_format($otamount,2,'.',','); ?></div></td>-->
                    <!--ENDS-->  
				  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format($ambulanceamount,2,'.',','); ?>0.00</div></td>
                    <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format($homecareamount,2,'.',','); ?>0.00</div></td>
				   <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format($privatedoctoramount,2,'.',','); ?>0.00</div></td>
                     
                     <!--VENU -- REMOVE DISCOUNT-->
				   <!-- <td class="bodytext31" valign="center"  align="left">
			         <div align="right"><?php //echo number_format($transactionamount,2,'.',','); ?></div></td>-->
				     <!--VENU -- REMOVE DISCOUNT-->
                     <!-- <td class="bodytext31" valign="center"  align="left">
                      <div align="right"><?php //echo number_format($ipdiscountamount,2,'.',','); ?></div></td>-->
                      <!--VENU REMOVE IPREFUND-->
                       <!--<td  align="left" valign="center" class="bodytext31"><div align="right"><?php //echo number_format($iprefundamount,2,'.',','); ?></div></td>-->
                       <!--VENU REMOVE NHIF-->
                        <!--<td  align="left" valign="center" class="bodytext31"><div align="right"><?php //echo number_format($nhifamount,2,'.',','); ?></div></td>-->
                      <!--ENDS-->  
				  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php //echo number_format($ipmiscamount,2,'.',','); ?>0.00</div></td>
                  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo '-'.number_format($brfotherdisc,2,'.',','); ?></div></td>
				  <?php
				  //$rowtot3 = 0;
				  $rowtot3 = $brfbedchgsdiscount+$brfnursechgsdiscount+$brfrmochgsdiscount+$brflabchgsdiscount+$brfradchgsdiscount+$brfpharmachgsdiscount+$brfservchgsdiscount+$brfotherdisc;
				  $rowtot3 = 0 - $rowtot3;
				  
				  $rowtotfinal = $rowtotfinal + $rowtot3;
				  ?>
				  <td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo number_format($rowtot3,2,'.',','); ?></strong></div></td>
                  </tr>
         <!--DISPLAY ENDS-->
        <?php   
		}
		?>

  <!--<tr>
<td>patient details from $query1</td>
</tr>-->

          <!--ENDS-->
           
            <tr>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc"><div align="right">
				
				<?php 
				
				
				//VENU--CHANGE GRAND TOTAL ACC TO REMOVED FIELDS
				/*$grandtotal = $totaladmissionamount + $totalipbedcharges + $totalipnursingcharges + $totaliprmocharges + $totallabamount + $totalradiologyamount
				+ $totalpharmacyamount + $totalservicesamount + $totalotamount + $totalambulanceamount+ $totalprivatedoctoramount + $totalipmiscamount + $totalpackagecharge + $totalhomecareamount - $totaliprefundamount - $totalipdiscountamount - $totalnhifamount -$totaltransactionamount; */
				
				//VENU --CALCULATIONS FOR TOTALDISC-CREITNOTE
				$totbedchgs = $totalipbedcharges - $totbrfbeddisc;
				$totnursechgs = $totalipnursingcharges - $totbrfnursedisc;
				$totrmochgs =  $totaliprmocharges - $totbrfrmodisc;
				$totlabchgs = $totallabamount - $totbrflabdisc;
				$totradchgs = $totalradiologyamount - $totbrfraddisc;
				$totpharmchgs = $totalpharmacyamount - $totbrfpharmadisc;
				$totservchgs = $totalservicesamount - $totbrfservdisc;
				$totalbrfotherdisc = 0 - $totalbrfotherdisc;
				
				/*$grandtotal = $totaladmissionamount + $totalipbedcharges + $totalipnursingcharges + $totaliprmocharges + $totallabamount + $totalradiologyamount
				+ $totalpharmacyamount + $totalservicesamount + $totalambulanceamount+ $totalprivatedoctoramount + $totalipmiscamount + $totalpackagecharge + $totalhomecareamount ; */
				
				//--VENU -- GRAND TOTAL ACC TO CREDIT NOTE CHANGES
				$grandtotal = $totaladmissionamount + $totbedchgs + $totnursechgs + $totrmochgs + $totlabchgs + $totradchgs
				+ $totpharmchgs + $totservchgs + $totalambulanceamount+ $totalprivatedoctoramount + $totalipmiscamount + $totalpackagecharge + $totalhomecareamount + $totalbrfotherdisc;
				
				?>
				
                  <strong>Grand Total:</strong> </div></td>
                   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc"><div align="right">
                <strong><?php echo number_format($grandtotal,2,'.',','); ?></strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totaladmissionamount,2,'.',','); ?></strong></td>
                <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totalpackagecharge,2,'.',','); ?></strong></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totbedchgs,2,'.',','); ?></strong></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totnursechgs,2,'.',','); ?></strong></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totrmochgs,2,'.',','); ?></strong></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc"><div align="right"><strong><?php echo number_format($totlabchgs,2,'.',','); ?></strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc"><div align="right"><strong><?php echo number_format($totradchgs,2,'.',','); ?></strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc"><div align="right"><strong><?php echo number_format($totpharmchgs,2,'.',','); ?></strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totservchgs,2,'.',','); ?></strong></td>
                <!--VENU -- REMOVE total ot amount -->
              <!--<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                bgcolor="#cccccc"><strong><?php //echo number_format($totalotamount,2,'.',','); ?></strong></td>-->
                <!--ends-->
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totalambulanceamount,2,'.',','); ?></strong></td>
                <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totalhomecareamount,2,'.',','); ?></strong></td> 
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totalprivatedoctoramount,2,'.',','); ?></strong></td>
                
                <!--VENU --  REMOVE DISCOUNT-->
              <!--<td align="right" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#cccccc" class="style2">-<?php //echo number_format($totaltransactionamount,2,'.',','); ?></td>-->
                
              <!--VENU -- REMOVE DEPOSIT-->  
              <!--<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                bgcolor="#cccccc"><strong>-<?php //echo number_format($totalipdiscountamount,2,'.',','); ?></strong></td>-->
                <!--VENU -- REMOVE IP REFUND-->
                <!-- <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                bgcolor="#cccccc"><strong>-<?php //echo number_format($totaliprefundamount,2,'.',','); ?></strong></td>-->
                <!--VENU-- REMOVE NHIF-->
                  <!--<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                bgcolor="#cccccc"><strong>-<?php // echo number_format($totalnhifamount,2,'.',','); ?></strong></td>-->
                <!--ENDS-->
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totalipmiscamount,2,'.',','); ?></strong></td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totalbrfotherdisc,2,'.',','); ?></strong></td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($rowtotfinal,2,'.',','); ?></strong></td>
                </tr>

              </tbody>
        </table>
<?php
}
?>	
