<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$fromdate=$_REQUEST['ADate1'];
	$todate=$_REQUEST['ADate2'];
	$searchlocationcode=$_REQUEST['locationcode'];


  
  
 
$totalhospitalrevenue = '0.00';


header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="hospitalrevenuereport.xls"');
header('Cache-Control: max-age=80');
?>
<style>
.xlText {
    mso-number-format: "\@";
}
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
	$searchlocationcode=$_REQUEST['locationcode'];
	$querylocname = "select locationname from master_location where locationcode='$searchlocationcode' order by locationname";
	$execlocname = mysql_query($querylocname) or die ("Error in querylocname".mysql_error());
	$reslocname = mysql_fetch_assoc($execlocname);
	$locationname = $reslocname['locationname'];
}
?>
		
<?php



?>	
<table width="auto" id="AutoNumber3" style="BORDER-COLLAPSE: collapse"  bordercolor="#666666" cellspacing="0" cellpadding="4"  align="left" border="1">
            <tr>
          	  <td colspan="7"><strong>Hospital Revenue Report: </strong><?php echo  ' '.$fromdate.' To '.$todate;?></td>
 		      <td>
              <?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				
					?>
               </td>
            </tr>
            <tr>
            	<td colspan="7"><strong>Location: </strong><?php echo  $locationname;?></td>
            </tr>
            
		    <tr <?php //echo $colorcode; ?> margin='10'>
              <td width="7%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"  ></td>
              <td width="7%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"  ><strong>Admn Fee</strong></td>
              <td width="7%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Bed Charge</strong></td>
              <td width="7%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Ward</strong></td>
              <td width="7%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>RMO</strong></td>
              <td width="7%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Pvt dr</strong></td>
              <td width="7%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Pharmacy</strong></td>
              <td width="7%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Laboratry</strong></td>
              <td width="7%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Radiology</strong></td>
              <td width="7%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Service</strong></td>
              <td width="7%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Pkg</strong></td>
              <td width="7%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Recovery</strong></td>
              <td width="7%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Resuce</strong></td>
              <td width="7%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Homecare</strong></td>
              <td width="7%" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Misc</strong></td>
             </tr>
            <?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					$transactiondatefrom = $_REQUEST['ADate1'];
					$transactiondateto = $_REQUEST['ADate2'];
					$locationcode = $_REQUEST['locationcode'];
					
		        if($locationcode!='All')
				{
			//this query for consultation
			
			$query111 = "select sum(amount) from billing_ipadmissioncharge where locationcode='$locationcode' and recorddate between '$transactiondatefrom' and '$transactiondateto' ";
			$exec111 = mysql_query($query111) or die ("Error in Query111".mysql_error());
			$num111=mysql_num_rows($exec111);
			$res111 = mysql_fetch_array($exec111);
			$totalipadmissionamount =$res111['sum(amount)'];
			
			$query113 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode' and description='bed charges' and recorddate between '$transactiondatefrom' and '$transactiondateto' ";
			$exec113 = mysql_query($query113) or die ("Error in Query4".mysql_error());
			$num113 = mysql_num_rows($exec113);
			$res113 = mysql_fetch_array($exec113);
			$totalbedcharges =$res113['sum(amount)'];
			
			$query115 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode' and description='Ward Dispensing Charges' and recorddate between '$transactiondatefrom' and '$transactiondateto' ";
			$exec115 = mysql_query($query115) or die ("Error in Query115".mysql_error());
			$num115 = mysql_num_rows($exec115);
			$res115 = mysql_fetch_array($exec115);
			$totalwardcharges =$res115['sum(amount)'];
			
			
			$query117 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode' and description='Resident Doctor Charges' and recorddate between '$transactiondatefrom' and '$transactiondateto' ";
			$exec117 = mysql_query($query117) or die ("Error in Query117".mysql_error());
			$num117 = mysql_num_rows($exec117);
			$res117 = mysql_fetch_array($exec117);
			$totalrmocharges =$res117['sum(amount)'];
			
			$query118 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode' and description!='Resident Doctor Charges' and description!='Ward Dispensing Charges' and description!='bed charges' and recorddate between '$transactiondatefrom' and '$transactiondateto' ";
			$exec118 = mysql_query($query118) or die ("Error in Query118".mysql_error());
			$num118 = mysql_num_rows($exec118);
			$res118 = mysql_fetch_array($exec118);
			$totalpkgcharges =$res118['sum(amount)'];
			
			$query119 = "select sum(amount) from billing_ipprivatedoctor where billtype='PAY NOW' and recorddate between '$transactiondatefrom' and '$transactiondateto' and locationcode='$locationcode' ";
			$exec119 = mysql_query($query119) or die ("Error in Query119".mysql_error());
			$num119=mysql_num_rows($exec119);
	        $res119 = mysql_fetch_array($exec119);
			$totalipprivatedoctoramount=$res119['sum(amount)'];
			
			$query121 = "select sum(amount) as pharmamount from billing_ippharmacy where billtype='PAY NOW' and locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec121 = mysql_query($query121) or die ("Error in query121".mysql_error());
			$res121 = mysql_fetch_array($exec121);
			$res121pharmamount= $res121['pharmamount'];
			
			$query123 = "select sum(labitemrate) as labitemrate1 from billing_iplab where billtype='PAY NOW' and locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec123 = mysql_query($query123) or die ("Error in query123".mysql_error());
			$res123 = mysql_fetch_array($exec123);
			$res123labitemrate = $res123['labitemrate1'];
			
			$query125 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_ipradiology where billtype='PAY NOW' and locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec125 = mysql_query($query125) or die ("Error in query125".mysql_error());
			$res125 = mysql_fetch_array($exec125);
			$res125radiologyitemrate = $res125['radiologyitemrate1'];
			
			$query127 = "select sum(servicesitemrate) as servicesitemrate1 from billing_ipservices where billtype='PAY NOW' and locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec127 = mysql_query($query127) or die ("Error in Query127".mysql_error());
			$res127 = mysql_fetch_array($exec127);
			$res127servicesitemrate = $res127['servicesitemrate1'];
			
			 $query135 = "select sum(amount) as homecareamountip from billing_iphomecare where locationcode='$locationcode' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
			$exec135 = mysql_query($query135) or die ("Error in query135".mysql_error());
			$res135= mysql_fetch_array($exec135);
		    $res135iphomecare = $res135['homecareamountip'];
			
			//VENU -- GETTING DATA FOR CASH MISLENOUS BILLING
			$querymisc = "SELECT sum(amount) AS miscamount FROM billing_ipmiscbilling where locationcode='$locationcode' and recorddate between '$transactiondatefrom' and '$transactiondateto'";
			$execmisc =  mysql_query($querymisc) or die ("Error in querymisc".mysql_error());
			$resmisc = mysql_fetch_array($execmisc);
			$misccashamount = $resmisc['miscamount'];
			//ENDS
			
			//this code for credit
			$query137 = "select sum(amount) from billing_ipprivatedoctor where billtype='PAY LATER' and recorddate between '$transactiondatefrom' and '$transactiondateto' and locationcode='$locationcode' ";
			$exec137 = mysql_query($query137) or die ("Error in Query119".mysql_error());
			$num137=mysql_num_rows($exec137);
	        $res137 = mysql_fetch_array($exec137);
			$totalipprivatedoctoramount_credit=$res137['sum(amount)'];
			
			$query138 = "select sum(amount) as pharmamount from billing_ippharmacy where billtype='PAY LATER' and locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec138 = mysql_query($query138) or die ("Error in query121".mysql_error());
			$res138 = mysql_fetch_array($exec138);
			$pharmamount_credit= $res138['pharmamount'];
			
			$query139 = "select sum(labitemrate) as labitemrate1 from billing_iplab where billtype='PAY LATER' and locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec139 = mysql_query($query139) or die ("Error in query123".mysql_error());
			$res139= mysql_fetch_array($exec139);
			$labitemrate_credit = $res139['labitemrate1'];
			
			$query140 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_ipradiology where billtype='PAY LATER' and locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec140 = mysql_query($query140) or die ("Error in query125".mysql_error());
			$res140 = mysql_fetch_array($exec140);
			$radiologyitemrate_credit = $res140['radiologyitemrate1'];
			
			$query141 = "select sum(servicesitemrate) as servicesitemrate1 from billing_ipservices where billtype='PAY LATER' and locationcode='$locationcode' and billdate between '$transactiondatefrom' and '$transactiondateto'";
			$exec141 = mysql_query($query141) or die ("Error in Query127".mysql_error());
			$res141= mysql_fetch_array($exec141);
			$servicesitemrate_credit = $res141['servicesitemrate1'];
			
			//VENU-- GETTING DETAILS FOR CREDIT NOTE
			//--CREDIT NOTE FOR BED CHARGES
			//For Credit Note-- Bed Charges from ip_creditnotebrief
			$qrybedchgs = "SELECT sum(rate) AS bedchgs FROM ip_creditnotebrief WHERE description='Bed Charges' AND locationcode='$locationcode' AND consultationdate BETWEEN '$transactiondatefrom' and '$transactiondateto'";
			$execbedchgs = mysql_query($qrybedchgs) or die ("Error in qrybedchgs".mysql_error());
			$rescbedchgs= mysql_fetch_array($execbedchgs);
			$bedchgs = $rescbedchgs['bedchgs'];
			
			/*//For Credit Note Bed Charges -- discount from ip_discount
			$qrybedchgsdisc = "SELECT sum(rate) AS bedchgsdisc FROM ip_discount WHERE description='Bed Charges' AND locationcode='$locationcode' AND consultationdate BETWEEN '$transactiondatefrom' and '$transactiondateto'";
			$execbedchgsdisc = mysql_query($qrybedchgsdisc) or die ("Error in qrybedchgsdisc".mysql_error());
			$rescbedchgsdisc= mysql_fetch_array($execbedchgsdisc);
			$bedchgsdiscount = $rescbedchgsdisc['bedchgsdisc'];
			
			$bedchgcreditnote = $bedchgs + $bedchgsdiscount;*/
			$bedchgcreditnote = $bedchgs;
			
			//--CREDIT NOTE FOR WARD
			//For Credit Note-- Nursing Charges from ip_creditnotebrief
			$qrywardchgs = "SELECT sum(rate) AS wardchgs FROM ip_creditnotebrief WHERE description='Nursing Charges' AND locationcode='$locationcode' AND consultationdate BETWEEN '$transactiondatefrom' and '$transactiondateto'";
			$execwardchgs = mysql_query($qrywardchgs) or die ("Error in qrywardchgs".mysql_error());
			$rescwardchgs= mysql_fetch_array($execwardchgs);
			$wardchgs = $rescwardchgs['wardchgs'];
			
			//For Credit Note Nursing Charges  -- discount from ip_discount
			/*$qrywardchgsdisc = "SELECT sum(rate) AS wardchgsdisc FROM ip_discount WHERE description='Nursing Charges' AND locationcode='$locationcode' AND consultationdate BETWEEN '$transactiondatefrom' and '$transactiondateto'";
			$execwardchgsdisc = mysql_query($qrywardchgsdisc) or die ("Error in qrywardchgsdisc".mysql_error());
			$rescwardchgsdisc= mysql_fetch_array($execwardchgsdisc);
			$wardchgsdiscount = $rescwardchgsdisc['wardchgsdisc'];
			
			$wardchgcreditnote = $wardchgs + $wardchgsdiscount;*/
			$wardchgcreditnote = $wardchgs;
			
			//--CREDIT NOTE FOR RMO
			//For Credit Note-- RMO Charges from ip_creditnotebrief
			$qryrmochgs = "SELECT sum(rate) AS rmochgs FROM ip_creditnotebrief WHERE description='RMO Charges' AND locationcode='$locationcode' AND consultationdate BETWEEN '$transactiondatefrom' and '$transactiondateto'";
			$execrmochgs = mysql_query($qryrmochgs) or die ("Error in qryrmochgs".mysql_error());
			$resrmochgs= mysql_fetch_array($execrmochgs);
			$rmochgs = $resrmochgs['rmochgs'];
			
			/*//For Credit Note RMO Charges  -- discount from ip_discount
			$qryrmochgsdisc = "SELECT sum(rate) AS rmochgsdisc FROM ip_discount WHERE description='RMO Charges' AND locationcode='$locationcode' AND consultationdate BETWEEN '$transactiondatefrom' and '$transactiondateto'";
			$execrmochgsdisc = mysql_query($qryrmochgsdisc) or die ("Error in qryrmochgsdisc".mysql_error());
			$rescrmochgsdisc= mysql_fetch_array($execrmochgsdisc);
			$rmochgsdiscount = $rescrmochgsdisc['rmochgsdisc'];
			
			$rmochgcreditnote = $rmochgs + $rmochgsdiscount;*/
			$rmochgcreditnote = $rmochgs;
			
			//--CREDIT NOTE FOR LAB
			//For Credit Note-- Lab Charges from ip_creditnotebrief
			$qrylabchgs = "SELECT sum(rate) AS labchgs FROM ip_creditnotebrief WHERE description='Lab' AND locationcode='$locationcode' AND consultationdate BETWEEN '$transactiondatefrom' and '$transactiondateto'";
			$execlabchgs = mysql_query($qrylabchgs) or die ("Error in qrylabchgs".mysql_error());
			$reslabchgs= mysql_fetch_array($execlabchgs);
			$labchgs = $reslabchgs['labchgs'];
			
			/*//For Credit Note Lab Charges  -- discount from ip_discount
			$qrylabchgsdisc = "SELECT sum(rate) AS labchgsdisc FROM ip_discount WHERE description='Lab' AND locationcode='$locationcode' AND consultationdate BETWEEN '$transactiondatefrom' and '$transactiondateto'";
			$execlabchgsdisc = mysql_query($qrylabchgsdisc) or die ("Error in qrylabchgsdisc".mysql_error());
			$reslabchgsdisc= mysql_fetch_array($execlabchgsdisc);
			$labchgsdiscount = $reslabchgsdisc['labchgsdisc'];
			
			$labchgcreditnote = $labchgs + $labchgsdiscount;*/
			
			$labchgcreditnote = $labchgs;
			
			//--CREDIT NOTE FOR RADIOLOGY
			//For Credit Note-- Radiology Charges from ip_creditnotebrief
			$qryradchgs = "SELECT sum(rate) AS radchgs FROM ip_creditnotebrief WHERE description='Radiology' AND locationcode='$locationcode' AND consultationdate BETWEEN '$transactiondatefrom' and '$transactiondateto'";
			$execradchgs = mysql_query($qryradchgs) or die ("Error in qryradchgs".mysql_error());
			$resradchgs= mysql_fetch_array($execradchgs);
			$radchgs = $resradchgs['radchgs'];
			
			//For Credit Note Radiology Charges  -- discount from ip_discount
			/*$qryradchgsdisc = "SELECT sum(rate) AS radchgsdisc FROM ip_discount WHERE description='Radiology' AND locationcode='$locationcode' AND consultationdate BETWEEN '$transactiondatefrom' and '$transactiondateto'";
			$execradchgsdisc = mysql_query($qryradchgsdisc) or die ("Error in qryradchgsdisc".mysql_error());
			$resradchgsdisc= mysql_fetch_array($execradchgsdisc);
			$radchgsdiscount = $resradchgsdisc['radchgsdisc'];
			
			$radchgcreditnote = $radchgs + $radchgsdiscount;
			*/
			$radchgcreditnote = $radchgs;
			
			//--CREDIT NOTE FOR SERVICES
			//For Credit Note-- Service Charges from ip_creditnotebrief
			$qryservchgs = "SELECT sum(rate) AS servchgs FROM ip_creditnotebrief WHERE description='Service' AND locationcode='$locationcode' AND consultationdate BETWEEN '$transactiondatefrom' and '$transactiondateto'";
			$execservchgs = mysql_query($qryservchgs) or die ("Error in qryservchgs".mysql_error());
			$resservchgs= mysql_fetch_array($execservchgs);
			$servchgs = $resservchgs['servchgs'];
			
			//For Credit Note Service Charges  -- discount from ip_discount
			/*$qryservchgsdisc = "SELECT sum(rate) AS servchgsdisc FROM ip_discount WHERE description='Service' AND locationcode='$locationcode' AND consultationdate BETWEEN '$transactiondatefrom' and '$transactiondateto'";
			$execservchgsdisc = mysql_query($qryservchgsdisc) or die ("Error in qryservchgsdisc".mysql_error());
			$resservchgsdisc= mysql_fetch_array($execservchgsdisc);
			$servchgsdiscount = $resservchgsdisc['servchgsdisc'];
			
			$servchgcreditnote = $servchgs + $servchgsdiscount;*/
			$servchgcreditnote = $servchgs;
			
			
			
			//ENDS
			
			//code for total 
			$admnfee=0;
			$totaladmnfee=$totalipadmissionamount+$admnfee;
			$bedcharge=0;
			//substract creditnote bed chgs
			$totalbedcharge=$totalbedcharges+$bedcharge-$bedchgcreditnote;
			$ward=0;
			//Substract creditnote ward chgs
			$totalward=$totalwardcharges+$ward-$wardchgcreditnote;
			$rmo=0;
			//Substract creditnote rmo chgs
			$totalrmo=$totalrmocharges+$rmo-$rmochgcreditnote;
			$totalpvtdr=$totalipprivatedoctoramount+$totalipprivatedoctoramount_credit;
			$totalpharmacy=$res121pharmamount+$pharmamount_credit;
			//Substract creditnote lab chgs
			$totallaboratry=$res123labitemrate+$labitemrate_credit-$labchgcreditnote; 
			//Substract creditnote Radiology chgs
			$totalradiology=$res125radiologyitemrate+$radiologyitemrate_credit-$radchgcreditnote;
			//Substract creditnote Sevice chgs
			$totalservice=$res127servicesitemrate+$servicesitemrate_credit-$servchgcreditnote;
			$pkg=0;
			$totalpkg=$totalpkgcharges+$pkg;
			$recovery=0;
			$resuce=0;
			$homecare=0;
			$totalhomecare=$res135iphomecare+$homecare;
			//MISC TOTAL (CASH+CREDIT)
			$misccreditamount = 0;
			$totmisc = $misccashamount + $misccreditamount;
			
			/*$snocount = $snocount + 1;
			$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
			if ($showcolor == 0)
			{
				//echo "if";
				$colorcode = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode = 'bgcolor="#D3EEB7"';
			}*/

			?>
              <tr>
              	  <td class="bodytext31" valign="center"  align="left"><strong>Cash</strong></td>	
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($totalipadmissionamount,2,'.',',');  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($totalbedcharges,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($totalwardcharges,2,'.',',');  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($totalrmocharges,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($totalipprivatedoctoramount,2,'.',',');  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res121pharmamount,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res123labitemrate,2,'.',',');  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res125radiologyitemrate,2,'.',',');  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res127servicesitemrate,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($totalpkgcharges,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($res135iphomecare,2,'.',',');  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($misccashamount,2,'.',',');  ?></div></td>
              </tr>
              
              <tr>
              	  <td class="bodytext31" valign="center"  align="left"><strong>Credit</strong></td>	
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php   ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($totalipprivatedoctoramount_credit,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($pharmamount_credit,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($labitemrate_credit,2,'.',',');  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($radiologyitemrate_credit,2,'.',',');  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php echo number_format($servicesitemrate_credit,2,'.',',');  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  ?></div></td>
              </tr>
              
                <!-- VENU -- DATA DISPLAY FOR IP CREDIT-->
               <tr>
              	  <td class="bodytext31" valign="center"  align="left"><strong>IP Credit</strong></td>	
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  echo "-".number_format($bedchgcreditnote,2,'.',',');  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  echo "-".number_format($wardchgcreditnote ,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  echo "-".number_format($rmochgcreditnote ,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  echo "-".number_format($labchgcreditnote ,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  echo "-".number_format($radchgcreditnote  ,2,'.',','); ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  echo "-".number_format($servchgcreditnote  ,2,'.',',');?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  ?></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><?php  ?></div></td>
              </tr>
              <!--ENDS-->
              
              <tr>
              	  <td class="bodytext31" valign="center"  align="left"><strong>Total</strong></td>	
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totaladmnfee,2,'.',',');  ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totalbedcharge,2,'.',',');  ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totalward,2,'.',',');  ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totalrmo,2,'.',',');  ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totalpvtdr,2,'.',','); ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totalpharmacy,2,'.',','); ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totallaboratry,2,'.',',');  ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totalradiology,2,'.',',');  ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totalservice,2,'.',',');  ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totalpkg,2,'.',',');  ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($recovery,2,'.',',');  ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($resuce,2,'.',',');  ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totalhomecare,2,'.',',');  ?></strong></div></td>
                  <td class="bodytext31" valign="center"  align="right"><div class="bodytext31"><strong><?php echo number_format($totmisc,2,'.',',');  ?></strong></div></td>
              </tr>
              
           <?php
				}
				}
			
			?>
          </tbody>
        </table>
	  
</body>
</html>



