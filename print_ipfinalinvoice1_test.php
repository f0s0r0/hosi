<?php
session_start();
//include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$updatetime = date('H:i:s');
$updatedate = date('Y-m-d');
$currentdate = date('Y-m-d');
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$temp = 0;
$docno=$_SESSION["docno"];
ob_start();

$query = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname ";
	$exec = mysql_query($query) or die ("Error in Query1".mysql_error());
	$res = mysql_fetch_array($exec);
	
 	$locationname = $res["locationname"];
	$locationcode = $res["locationcode"];
//$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
if (isset($_REQUEST["billnumber"])) { $billnumbers = $_REQUEST["billnumber"]; } else { $billnumbers = ""; }
if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }

$Querylab=mysql_query("select * from master_customer where locationcode='$locationcode' and customercode='$patientcode'");
$execlab=mysql_fetch_array($Querylab);
 $patientage=$execlab['age'];
 $patientgender=$execlab['gender'];

$patienttype=$execlab['maintype'];
$querytype=mysql_query("select * from master_paymenttype where locationcode='$locationcode' and auto_number='$patienttype'");
$exectype=mysql_fetch_array($querytype);
$patienttype1=$exectype['paymenttype'];
$patientsubtype=$execlab['subtype'];
$querysubtype=mysql_query("select * from master_subtype where locationcode='$locationcode' and auto_number='$patientsubtype'");
$execsubtype=mysql_fetch_array($querysubtype);
$patientsubtype1=$execsubtype['subtype'];

$query32 = "select * from ip_discharge where locationcode='$locationcode' and patientcode='$patientcode' and visitcode='$visitcode'";
$exec32 = mysql_query($query32) or die(mysql_error());
$num32 = mysql_num_rows($exec32);
$res32 = mysql_fetch_array($exec32);
$dischargedby = $res32['username'];
$dischargedate = $res32['recorddate'];

$query33 = "select * from master_employee where username = '$dischargedby'";
$exec33 = mysql_query($query33) or die(mysql_error());
$res33 = mysql_fetch_array($exec33);
$employeename = $res33['employeename'];

?>

<?php
function roundTo($number, $to){ 
    return round($number/$to, 0)* $to; 
} 

?>

<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; 
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 15px; COLOR: #000000; 
}
.bodytexthead {FONT-WEIGHT: bold; FONT-SIZE: 30px; COLOR: #000000; font-family:"Times New Roman", Times, serif;
}

.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000;  text-decoration:none
}
.bodytext365 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #000000;  text-decoration:none
}
.bodytext366 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #000000;  text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; 
}
.bodytext32 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000; 
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; 
}
.bodytext33 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;
}
.bodytext34 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;
}
.bodytext35 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #FFFFFF;
	font-family:Arial, Helvetica, sans-serif;
}
.underline {text-decoration: underline;}

.page_footer{
    display: table;
    text-align: center;
    margin-left: auto;
    margin-right: auto;
}
hr.style8 {
	border-top: 1px dashed #8c8b8b;
	border-bottom: 1px dashed #fff;
}
hr.style8:after {
	content: '';
	display: block;
	margin-top: 2px;
	border-top: 1px solid #8c8b8b;
	border-bottom: 1px solid #fff;
}
hr{
border-top: 1px dashed #8c8b8b;	
	border-bottom: 1px dashed #fff;

}
hr:after {
	content: '';
	display: block;
	margin-top: 2px;
	border-top: 1px solid #8c8b8b;
	border-bottom: 1px solid #fff;
}
.wrap { 
   white-space: pre-wrap;      /* CSS3 */   
   white-space: -moz-pre-wrap; /* Firefox */    
   white-space: -pre-wrap;     /* Opera <7 */   
   white-space: -o-pre-wrap;   /* Opera 7 */    
   word-wrap: break-word;      /* IE */
}
</style>

<?php
		$query2 = "select * from master_location where locationcode = '$locationcode'";
		$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		$res2 = mysql_fetch_array($exec2);
		//$companyname = $res2["companyname"];
		$address1 = $res2["address1"];
		$address2 = $res2["address2"];
//		$area = $res2["area"];
//		$city = $res2["city"];
//		$pincode = $res2["pincode"];
		$emailid1 = $res2["email"];
		$phonenumber1 = $res2["phone"];
		$locationcode = $res2["locationcode"];
//		$phonenumber2 = $res2["phonenumber2"];
//		$tinnumber1 = $res2["tinnumber"];
//		$cstnumber1 = $res2["cstnumber"];
	//	$locationname =  $res2["locationname"];
		$prefix = $res2["prefix"];
		$suffix = $res2["suffix"];
?>

           <?php
 		$query1 = "select * from master_ipvisitentry where locationcode='$locationcode' and patientcode='$patientcode' and visitcode='$visitcode'";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		
		while($res1 = mysql_fetch_array($exec1))
		{
		$patientname=$res1['patientfullname'];
		$patientcode=$res1['patientcode'];
		$accountname = $res1['accountname'];
		$billtype = $res1['billtype'];
		$gender = $res1['gender'];
		$age = $res1['age'];
		$consultingdoctor = $res1['consultingdoctor'];
		$nhifid = $res1['nhifid'];
		$subtypeanum = $res1['subtype'];
		$type = $res1['type'];
	
		$query13 = "select * from master_subtype where  auto_number = '$subtypeanum'";
		$exec13 = mysql_query($query13) or die("Error in Query13".mysql_error());
		$res13 = mysql_fetch_array($exec13);
		$subtype = $res13['subtype'];
		//$fxrate=$res13['fxrate'];
//		$currency=$res13['currency'];
		$bedtemplate=$res13['bedtemplate'];
		$labtemplate=$res13['labtemplate'];
		$radtemplate=$res13['radtemplate'];
		$sertemplate=$res13['sertemplate'];
		$querytt32 = "select * from master_testtemplate where templatename='$bedtemplate'";
		$exectt32 = mysql_query($querytt32) or die(mysql_error());
		$numtt32 = mysql_num_rows($exectt32);
		$exectt=mysql_fetch_array($exectt32);
		$bedtable=$exectt['referencetable'];
		if($bedtable=='')
		{
			$bedtable='master_bed';
		}
		$bedchargetable=$exectt['templatename'];
		if($bedchargetable=='')
		{
			$bedchargetable='master_bedcharge';
		}
		
		$query813 = "select * from ip_discharge where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode'";
		$exec813 = mysql_query($query813) or die(mysql_error());
		$res813 = mysql_fetch_array($exec813);
		$num813 = mysql_num_rows($exec813);
		if($num813 > 0)
		{
		$updatedate=$res813['recorddate'];
		}
		
		$query67 = "select * from master_accountname where auto_number='$accountname'";
		$exec67 = mysql_query($query67); 
		$res67 = mysql_fetch_array($exec67);
		$accname = $res67['accountname'];
	     }
		 
		$query2 = "select * from ip_bedallocation where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode'";
		$exec2 = mysql_query($query2) or die(mysql_error());
		$res2 = mysql_fetch_array($exec2);
		$admissiondate = $res2['recorddate'];
		$wardanum = $res2['ward'];
		$bed = $res2['bed'];
		
		$query121 = "select bed from `$bedtable` where auto_number = '$bed'";
		$exec121 = mysql_query($query121) or die ("Error in Query121".mysql_error());
		$res121 = mysql_fetch_array($exec121);
		$bed1 = $res121['bed'];
		
		
		$query12 = "select * from master_ward where locationcode='$locationcode' and auto_number = '$wardanum'";
		$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
		$res12 = mysql_fetch_array($exec12);
		$wardname = $res12['ward'];
		//No. of days calculation
		$startdate = strtotime($admissiondate);
		$enddate = strtotime($updatedate);
		$nbOfDays = $enddate - $startdate;
		$nbOfDays = ceil($nbOfDays/60/60/24);
		if($nbOfDays == 0)
		{
			$nbOfDays = 1;
		}
		//billno
		$querybill = "select billno from billing_ip where locationcode='$locationcode' and patientcode = '$patientcode' and visitcode = '$visitcode'";
		$execbill = mysql_query($querybill) or die ("Error in querybill".mysql_error());
		$resbill = mysql_fetch_array($execbill);
		$billno = $resbill['billno'];
		?>

<page pagegroup="new" backtop="12mm" backbottom="20mm" backleft="2mm" backright="3mm">
 <?php  include('print_header_invoice.php'); ?>
    
<!--<page_footer>
 <hr class="style8" />
  <div class="page_footer" >
                   <h4>"WE CARE, GOD HEALS"</h4>
    </div>            
    </page_footer>-->


  <table width="717"  border="0" align="center" cellpadding="2" cellspacing="2">
 
		  <tr><td colspan="6">&nbsp;</td></tr>
		   <tr>

		     <td align="left" valign="center" width="96" bgcolor="#ffffff" class="bodytext31"><strong>Invoice No: </strong></td> 
		     <td  align="left" valign="center"   width="282" class="bodytext31"><?php echo  $billno; ?></td>
	         <td align="left" valign="center"  width="152" bgcolor="#ffffff" class="bodytext31"><strong>Bill Date : </strong></td> 
		     <td width="161"  align="left" valign="center" class="bodytext31"><?php echo  date("d/m/Y", strtotime($currentdate)); ?></td>
          </tr>
		  
	       <tr>
             <td align="left" valign="center" width="96" bgcolor="#ffffff" class="bodytext31"><strong>Name : </strong></td> 
		     <td align="left" valign="center" width="282" class="bodytext31"><?php echo $patientname; ?></td>
             <td align="left" valign="center"  width="152" bgcolor="#ffffff" class="bodytext31"><strong>Reg. No. : </strong></td>
	         <td align="left" valign="center"  class="bodytext31"><?php echo $patientcode; ?></td>

         </tr>
          <tr>
             <td align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Bill Type : </strong></td>
	         <td align="left" valign="center"  width="282" class="bodytext31"><?php echo $billtype; ?></td>
	        <td  align="left" valign="center" width="152" bgcolor="#ffffff" class="bodytext31"><strong>IP Visit No. : </strong></td>
			<td  align="auto" valign="left" class="bodytext31"><?php echo $visitcode; ?></td>
         </tr>
        <tr>
			<td  align="left" rowspan= "1" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Account : </strong></td>
			<td align="left" valign="center"  width="282" class="bodytext31 wrap">
			<?php
			
			//$accname.=" shgdjsgdhjsdsdkjsdhshgdjsgdhjsdsdkjsdhshgdjsgdhjsdsdkjsdhsdsdkjsdhshgdjsgdhjsdsdkjsdhsdsdkjsdhshgdjsgdhjsdsdkjsdh shgdjsgdhjsd sdkjsdh shgdjsgdhjsd sdkjsdh shgdjsgdhjsd sdkjsdh shgdjsgdhjsd sdkjsdh shgdjsgdhjsd sdkjsdh shgdjsgdhjsd sdkjsdh shgdjsgdhjsd sdkjsdh shgdjsgdhjsd sdkjsdh shgdjsgdhjsd sdkjsdh shgdjsgdhjsd sdkjsdh shgdjsgdhjsd sdkjsdh shgdjsgdhjsd sdkjsdh ";
			 echo wordwrap($accname, 40, "\n", true); ?>		  </td>
           
			 	<td  align="left" valign="center" width="152" bgcolor="#ffffff" class="bodytext31"><strong>Admission Date : </strong></td> 
	         <td  align="left" valign="center" class="bodytext31"><?php echo  date("d/m/Y", strtotime($admissiondate)); ?></td>
		</tr>
        <tr>
        
         	<td  align="left" rowspan= "1" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Catagory : </strong></td>
			<td align="left" valign="center" rowspan= "1"  width="282" class="bodytext31"><?php echo $subtype; ?></td>
            <td  align="left" valign="center" width="152" bgcolor="#ffffff" class="bodytext31"><strong>Discharge Date : </strong></td>
			<td align="left" valign="center" class="bodytext31"><?php echo date("d/m/Y", strtotime($updatedate));; ?></td>
		</tr>
		 <tr>
         	<td colspan="2"></td>
            <td  align="left" valign="center" width="152" bgcolor="#ffffff" class="bodytext31"><strong>No of Days : </strong></td>
			<td width="161"  align="left" valign="left" class="bodytext31"><?php echo $nbOfDays; ?></td>
    </tr>
         <tr>
        	<td colspan="2"></td>
			<td  align="left" valign="center" width="152" bgcolor="#ffffff" class="bodytext31"><strong>Type : </strong></td>
			<td  align="left" valign="left"  class="bodytext31"><?php echo $type; ?></td>
    </tr>
          <tr>
         	<td colspan="2"></td>
			<td  align="left" valign="center" width="152" bgcolor="#ffffff" class="bodytext31"><strong>Bed No : </strong></td>
			<td align="left" valign="center" class="bodytext31"><?php echo $bed1;?></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid black;" colspan="6">&nbsp;</td>
		</tr>
</table>
		  <table width="100%"  border="0" align="center" cellpadding="2" cellspacing="2">
	<tr>
			 	<td colspan="6" align="center"><span class="underline">FINAL INVOICE</span></td>
			</tr>
		
			<tr>
				<td  align="left" valign="center" width="79"
				bgcolor="#ffffff" class="bodytext31"><strong>BILL DATE</strong></td>
				<td  align="left" valign="center" width="77"
				bgcolor="#ffffff" class="bodytext31"><strong>Ref.No</strong></td>
				<td  align="left" valign="center" style="white-space:normal" width="267"
				bgcolor="#ffffff" class="bodytext31"><strong>Description</strong></td>
				<td  align="right" valign="center" width="36"
				bgcolor="#ffffff" class="bodytext31"><strong>Qty</strong></td>
				<td  align="right" valign="center" width="66"
				bgcolor="#ffffff" class="bodytext31"><strong>Rate</strong></td>
				<td  align="right" valign="center" width="63"
				bgcolor="#ffffff" class="bodytext31"><strong>Amount</strong></td>
			</tr>
           
            <tbody>
            <?php
			$colorloopcount = '';
			$sno = '';
			$totalamount=0;
			$totalquantity = 0;
			$totalop =0;
			$query17 = "select * from master_ipvisitentry where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode'";
			$exec17 = mysql_query($query17) or die ("Error in Query1".mysql_error());
			$res17 = mysql_fetch_array($exec17);
			$consultationfee=$res17['admissionfees'];
			$packageanum1 = $res17['package'];
			$consultationfee = number_format($consultationfee,2,'.','');
			$viscode=$res17['visitcode'];
			$consultationdate=$res17['consultationdate'];
			$packchargeapply = $res17['packchargeapply'];
			$accountnum = $res17['accountname'];
			
			$querycop = "select lab_copay,radiology_copay,service_copay,pharmacy_copay,bed_copay,nursing_copay,rmo_copay,package_copay,misc_copay,ambulance_copay,mortuary_copay from master_copayaccount where accountnameano='$accountnum' and recordstatus <>'DELETED'";
			$execcop = mysql_query($querycop) or die(mysql_error());
			$rescop = mysql_fetch_array($execcop);
			$lab_copay = $rescop['lab_copay'];
			$radiology_copay = $rescop['radiology_copay'];
			$service_copay = $rescop['service_copay'];
			$pharmacy_copay = $rescop['pharmacy_copay'];
			$bed_copay = $rescop['bed_copay'];
			$nursing_copay = $rescop['nursing_copay'];
			$rmo_copay = $rescop['rmo_copay'];
			$package_copay = $rescop['package_copay'];
			$misc_copay = $rescop["misc_copay"];
			$ambulance_copay = $rescop["ambulance_copay"];
			$mortuary_copay = $rescop["mortuary_copay"];
			$copayyes = $lab_copay+$radiology_copay+$service_copay+$pharmacy_copay+$bed_copay+$nursing_copay+$rmo_copay+$package_copay+$misc_copay+$ambulance_copay+$mortuary_copay;
			
			$query53 = "select * from ip_bedallocation where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode'";
			$exec53 = mysql_query($query53) or die(mysql_error());
			$res53 = mysql_fetch_array($exec53);
			$refno = $res53['docno'];
			
			if($packageanum1 != 0)
			{
			if($packchargeapply == 1)
		{
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
			}
			$totalop=$consultationfee;
			?>
            <tr><td colspan="6"><strong>ADMISSION FEE</strong></td></tr>
			  <tr>
			 
			    <td class="bodytext31" valign="center"  align="left"><?php echo date('d-m-Y',strtotime($consultationdate));?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $refno; ?></td>
			 <td class="bodytext31" valign="center"  align="left"  width="267"><?php echo 'Admission Charge'; ?></td>
			     <td class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>
                <td class="bodytext31" valign="center"  align="right"><?php echo number_format($consultationfee,2,'.',','); ?></td>
				 <td class="bodytext31" valign="center"  align="right"><?php echo $consultationfee; ?></td>
				
           	</tr>
			<?php
			}
			}
			else
			{
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
			}
			$totalop=$consultationfee;
			?>
            <tr><td colspan="6"><strong>ADMISSION FEE</strong></td></tr>
			  <tr>
			 
			    <td width="79" class="bodytext31" valign="center"  align="left"><?php echo date('d-m-Y', strtotime($consultationdate)); ?></td>
				<td width="77"class="bodytext31" valign="center"  align="left"><?php echo $refno; ?></td>
			 <td class="bodytext31" valign="center"  align="left" width="267"><?php echo 'Admission Charge'; ?></td>
			     <td width="36"class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>
                <td width="66"class="bodytext31" valign="center"  align="right"><?php echo number_format($consultationfee,2,'.',','); ?></td>
				 <td width="63"class="bodytext31" valign="center"  align="right"><?php echo number_format($consultationfee,2,'.',','); ?></td>
				
           	</tr>
			<?php
			}
			?>
			<?php

					  $packageamount = 0;
			 $query731 = "select * from master_ipvisitentry where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode'";
			$exec731 = mysql_query($query731) or die(mysql_error());
			$res731 = mysql_fetch_array($exec731);
			$packageanum1 = $res731['package'];
			$packagedate1 = $res731['consultationdate'];
			$packageamount = $res731['packagecharge'];
			
			$query741 = "select * from master_ippackage where locationcode='$locationcode' and auto_number='$packageanum1'";
			$exec741 = mysql_query($query741) or die(mysql_error());
			$res741 = mysql_fetch_array($exec741);
			$packdays1 = $res741['days'];
			$packagename = $res741['packagename'];
			
			
			if($packageanum1 != 0)
	{
	
	 $reqquantity = $packdays1;
	 
	 $reqdate = date('Y-m-d',strtotime($packagedate1) + (24*3600*$reqquantity));
	 
			  $colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
		
			  ?>
              <tr><td colspan="6"><strong>PACKAGE CHARGE</strong></td></tr>
		<tr>
			
			<td width="79"class="bodytext31" valign="center"  align="left"><?php echo  date('d-m-Y', strtotime($packagedate1)); ?></td>
			<td width="77"class="bodytext31" valign="center"  align="left"><?php echo $visitcode; ?></td>
			<td class="bodytext31" valign="center"  align="left" width="267"><?php echo $packagename; ?></td>
			<td width="36"class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>
			<td width="66"class="bodytext31" valign="center"  align="right"><?php echo number_format($packageamount,2,'.',','); ?></td>
			<td width="63"class="bodytext31" valign="center"  align="right"><?php echo number_format($packageamount,2,'.',','); ?></td>
		</tr>
			  <?php
			  }
			  ?>
						<?php 
						$mortuaryupdatedate = $updatedate;
			$totalbedallocationamount = 0;
			
			 $requireddate = '';
			 $quantity = '';
			 $allocatenewquantity = '';
			$totalbedallocationamount=0;
				$query18 = "select ward,bed,docno,recorddate,leavingdate,recordstatus from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";
				$exec18 = mysql_query($query18) or die ("Error in Query1".mysql_error());
				while($res18 = mysql_fetch_array($exec18))
				{
					$querybedtr = "select visitcode from ip_bedtransfer where visitcode='$visitcode' and patientcode='$patientcode'";
					$execbedtr = mysql_query($querybedtr) or die ("Error in Querybedtr".mysql_error());
					$rowbedtr = mysql_num_rows($execbedtr);
					
					$ward = $res18['ward'];
					$allocateward = $res18['ward'];			
					$bed = $res18['bed'];
					$refno = $res18['docno'];
					$date = $res18['recorddate'];
					$bedallocateddate = $res18['recorddate'];
					$packagedate = $res18['recorddate'];
					$leavingdate = $res18['leavingdate'];
					
					$recordstatus = $res18['recordstatus'];
					if($leavingdate=='0000-00-00')
					{
						$leavingdate=$updatedate;
					}
					$query51 = "select bed,threshold from `$bedtable` where auto_number='$bed'";
					$exec51 = mysql_query($query51) or die(mysql_error());
					$res51 = mysql_fetch_array($exec51);
					$bedname = $res51['bed'];
					$threshold = $res51['threshold'];
					$thresholdvalue = $threshold/100;
					$time1 = new DateTime($bedallocateddate);
					$time2 = new DateTime($leavingdate);
					$interval = $time1->diff($time2);			  
					$quantity1 = $interval->format("%a");
					if($packdays1>$quantity1)
					{
						$quantity1=$quantity1-$packdays1; 
						$packdays1=$packdays1-$quantity1;
					}
					else
					{
						$quantity1=$quantity1-$packdays1;
						$packdays1=0;
					}
					$quantity='0';
					$diff = abs(strtotime($leavingdate) - strtotime($bedallocateddate));
					$query91 = "select charge,rate from `$bedchargetable` where bedanum='$bed' and recordstatus ='' and charge not in ('Accommodation Charges','Cafetaria Charges')";
					$exec91 = mysql_query($query91) or die(mysql_error());
					$num91 = mysql_num_rows($exec91);
					while($res91 = mysql_fetch_array($exec91))
					{
						$charge = $res91['charge'];
						$rate = $res91['rate'];	
						
						if($charge!='Bed Charges')
						{
							$quantity=$quantity1+1;
						}
						else
						{
							if($recordstatus=='discharged')
							{
								if($bedallocateddate==$leavingdate)
								{
									$quantity=$quantity1+1;
								}
								else
								{
									$quantity=$quantity1;
								}
							}
							else
							{
								$quantity=$quantity1;
							}
						}
						$amount = $quantity * $rate;						
						$allocatequantiy = $quantity;
						$allocatenewquantity = $quantity;
						if($quantity>0)
						{
							if($type=='hospital'||$charge!='Resident Doctor Charges')
							{
								$colorloopcount = $sno + 1;
								$showcolor = ($colorloopcount & 1); 
								if ($showcolor == 0)
								{
									//echo "if";
									$colorcode = 'bgcolor="#FFFFFF"';
								}
								else
								{
									//echo "else";
									$colorcode = 'bgcolor="#FFFFFF"';
								}
								
								
					  ?>
					  <?php if($rowbedtr == 0) { $totalbedallocationamount=$totalbedallocationamount+$amount; ?>
								<tr>
									<td class="bodytext31" valign="center"  align="left" width="79"><?php echo date("d-m-Y", strtotime($date)); ?></td>
									<td class="bodytext31" valign="center"  align="left"width="77"><?php echo $refno; ?></td>
									<td class="bodytext31" valign="center"  align="left"  width="267"><?php echo $charge; ?> (<?php echo $bedname; ?>)</td>
									<td class="bodytext31" valign="center"  align="right"width="36"><?php echo $quantity; ?></td>
									
									<td class="bodytext31" valign="center"  align="right"width="66"><?php echo number_format($rate,2,'.',','); ?></td>
									<td class="bodytext31" valign="center"  align="right"width="63"><?php echo number_format($amount,2,'.',','); ?></td>
								</tr>              
					   <?php } ?>
					   <?php 
							}
						}
					}
				}
				
				$bedalloc_qty = $quantity-1;
				$totalbedtransferamount=0;
				$query18 = "select ward,bed,docno,recorddate,leavingdate,recordstatus from ip_bedtransfer where visitcode='$visitcode' and patientcode='$patientcode'";
				$exec18 = mysql_query($query18) or die ("Error in Query1".mysql_error());
				while($res18 = mysql_fetch_array($exec18))
				{
					$quantity1=0;
					$ward = $res18['ward'];
					$allocateward = $res18['ward'];			
					$bed = $res18['bed'];
					$refno = $res18['docno'];
					$date = $res18['recorddate'];
					//$bedallocateddate = $res18['recorddate'];
					$packagedate = $res18['recorddate'];
					$leavingdate = $res18['leavingdate'];
					$recordstatus = $res18['recordstatus'];
					if($leavingdate=='0000-00-00')
					{
						$leavingdate=$updatedate;
					}
					$query51 = "select bed,threshold from `$bedtable` where auto_number='$bed'";
					$exec51 = mysql_query($query51) or die(mysql_error());
					$res51 = mysql_fetch_array($exec51);
					$bedname = $res51['bed'];
					$threshold = $res51['threshold'];
					$thresholdvalue = $threshold/100;
					$time1 = new DateTime($date);
					$time2 = new DateTime($leavingdate);
					$interval = $time1->diff($time2);			  
					$quantity1 = $interval->format("%a");
					if($packdays1>$quantity1)
					{
						$quantity1=$quantity1-$packdays1; 
						$packdays1=$packdays1-$quantity1;
					}
					else
					{
						$quantity1=$quantity1-$packdays1;
						$packdays1=0;
					}
					$bedcharge='0';
					$quantity='0';
					$diff = abs(strtotime($leavingdate) - strtotime($bedallocateddate));
					$query91 = "select charge,rate from `$bedchargetable` where bedanum='$bed' and recordstatus ='' and charge not in ('Accommodation Charges','Cafetaria Charges')";
					$exec91 = mysql_query($query91) or die(mysql_error());
					$num91 = mysql_num_rows($exec91);
					while($res91 = mysql_fetch_array($exec91))
					{
						$charge = $res91['charge'];
						$rate = $res91['rate'];	
						
						if($charge!='Bed Charges')
						{
							$quantity=$quantity1+1;
						}
						else
						{
							if($recordstatus=='discharged')
							{
								if($bedallocateddate==$leavingdate)
								{
									$quantity=$quantity1+1;
								}
								else
								{
									$quantity=$quantity1;
								}
							}
							else
							{
								$quantity=$quantity1;
							}
						}
						
						$quantity = $quantity+$bedalloc_qty;
						$amount = $quantity * $rate;						
						$allocatequantiy = $quantity;
						$allocatenewquantity = $quantity;
						if($bedcharge=='0')
						{
							if($quantity>0)
							{
								if($type=='hospital'||$charge!='Resident Doctor Charges')
								{
									$colorloopcount = $sno + 1;
									$showcolor = ($colorloopcount & 1); 
									if ($showcolor == 0)
									{
										//echo "if";
										$colorcode = 'bgcolor="#FFFFFF"';
									}
									else
									{
										//echo "else";
										$colorcode = 'bgcolor="#FFFFFF"';
									}
									$totalbedtransferamount=$totalbedtransferamount+$amount;
						  ?>
									<tr>
										<td class="bodytext31" valign="center"  align="left"width="79"><?php echo date("d-m-Y", strtotime($date)); ?></td>
										<td class="bodytext31" valign="center"  align="left"width="77"><?php echo $refno; ?></td>
										<td class="bodytext31" valign="center"  align="left"  width="267"><?php echo $charge; ?> (<?php echo $bedname; ?>)</td>
										<td class="bodytext31" valign="center"  align="right"width="36"><?php echo $quantity; ?></td>
										
										<td class="bodytext31" valign="center"  align="right"width="66"><?php echo number_format($rate,2,'.',','); ?></td>
										<td class="bodytext31" valign="center"  align="right"width="63"><?php echo number_format($amount,2,'.',','); ?></td>
									</tr>              
						 
						   <?php 
								}
							}
							else
							{
								if($charge=='Bed Charges')
								{
									$bedcharge='1';
								}
							}
						}
					}
				}
			  ?>
			 <?php
			$totalnhifamount = 0;
			$originalmor=0;
			$copaytotalbed = 0;
			$totalshelfamount = 0;
			$query641 = "select * from mortuary_allocation where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec641 = mysql_query($query641) or die(mysql_error());
			$num121=mysql_num_rows($exec641);
			while($res641= mysql_fetch_array($exec641))
		   {
			 $nhifdate = $res641['recorddate'];
			//echo $mortuaryupdatedate;
			$nhifrefno = $res641['docno'];
			$package = $res641['package'];
			$shelve = $res641['shelve'];
			
			$query642 = "select shelfcharges from master_shelf where shelf like '%$shelve%'";
			$exec642 = mysql_query($query642) or die(mysql_error());
			$res642= mysql_fetch_array($exec642);
			$shelfcharges = $res642['shelfcharges'];
			
		    $diff = abs(strtotime($nhifdate) - strtotime($mortuaryupdatedate));
			
			
			$years = floor($diff / (365*60*60*24));
			$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
			$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
			$days=$days+1;
			
			
			$shelfamount=$shelfcharges * $days;
			
			if($package!='')
			{
			 $query6430 = "select total,days from master_mortuarypackage where packagename like '%$package%'";
			$exec6430 = mysql_query($query6430) or die(mysql_error());
			$res6430= mysql_fetch_array($exec6430);
			$packagecharges = $res6430['total'];			
			$packagedays = $res6430['days'];
						$amount=$packagecharges;	

			}
						
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
			}
			if($num121!=0)
			{
			if($package!='')
			{
				
				//copay starts
			//$originalmiscbillingamount = $originalmiscbillingamount + $miscbillingamount;
			$originalamount =  $amount;
			
				 if(($mortuary_copay<100.00)&&($mortuary_copay>0.00))
				{ 
					$insumor_copay=100-$mortuary_copay;
					//$amount=($originalamount/100)*$insumor_copay;
					//$miscbillingamount=($originalmiscbillingamount1/100)*$insumis_copay;
				}
				if($mortuary_copay>=100.00){$amount=0;}
			
			//copay end
			$mortuarypackageamount = $amount;
		
			$copayamount2 = ($originalamount/100)*$mortuary_copay;
			$sno = $sno + 1; 
			?>
            <?php if($mortuary_copay<100){?>
			 <tr>
			 <td class="bodytext31" valign="center"  align="left"width="79"><?php echo date("d-m-Y", strtotime($nhifdate)); ?></td>
			 <td class="bodytext31" valign="center"  align="left"width="77"><?php echo $nhifrefno; ?></td>
			 <td class="bodytext31" valign="center"  align="left"width="267"> <?php echo $package; ?></td>
				 <td class="bodytext31" valign="center"  align="right"width="36"><?php echo '1'; ?></td>
                  
             <td class="bodytext31" valign="center"  align="right"width="66">
			<?php echo number_format($amount,2,'.',','); ?>               </td>
             <td class="bodytext31" valign="center"  align="right"width="63"><?php echo number_format($amount,2,'.',','); ?></td>
		      </tr>
                <?php
				$totalshelfamount = $totalshelfamount + $amount;
				 }?>
                 <?php if($mortuary_copay>0.00){
				  $copayamount = ($originalamount/100)*$mortuary_copay;
				   //$copayamount = $copayrate*$quantity;
				   $copaytotalbed = $copaytotalbed + $copayamount;
				   $sno = $sno + 1; 
			  ?>
               <!--<tr>
			 <td class="bodytext31" valign="center"  align="left"><?php echo $nhifdate; ?></td>
			 <td class="bodytext31" valign="center"  align="left"><?php echo $nhifrefno; ?></td>
			 <td class="bodytext31" valign="center"  align="left"> <?php echo $package ,' COPAY'; ?></td>
				 <td class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>
                 
             <td class="bodytext31" valign="center"  align="right">
               <?php echo number_format($copayamount,2); ?>
             </td>
             
             <td class="bodytext31" valign="center"  align="right"><?php echo number_format($copayamount,2,'.',','); ?></td>
			 </tr>-->
			  <?php
			  //$totalshelfamount = $totalshelfamount + $copayamount;
			   }?>
                
				<?php
			}
			else
			{
				$originalshelfcharges =  $shelfcharges;
				$originalshelfamount =  $shelfamount;
			
				 if(($mortuary_copay<100.00)&&($mortuary_copay>0.00))
				{ 
					$insushel_copay=100-$mortuary_copay;
					//$shelfcharges=($originalshelfcharges/100)*$insushel_copay;
					//$shelfamount=($originalshelfamount/100)*$insushel_copay;
				}
				if($mortuary_copay>=100.00){$amount=0;}
				
				$copayshelfamount3 = ($originalshelfamount/100)*$mortuary_copay;
				$sno = $sno + 1; 
				if($mortuary_copay<100){?>
                
			 <tr>
              <td class="bodytext31" valign="center"  align="left"width="79"><?php echo date("d-m-Y", strtotime($nhifdate)); ?></td>
			 <td class="bodytext31" valign="center"  align="left"width="77"><?php echo $nhifrefno; ?></td>
			 <td class="bodytext31" valign="center"  align="left"width="267"> <?php echo $shelve; ?></td>
				 <td class="bodytext31" valign="center"  align="right"width="36"><?php echo $days; ?>				 </td>
             <td class="bodytext31" valign="center"  align="right"width="66"><?php echo number_format($shelfcharges,2,'.',','); ?></td>
			 <td class="bodytext31" valign="center"  align="right"width="63"><?php echo number_format($shelfamount,2,'.',','); ?></td>
		      </tr>
                <?php
				$totalshelfamount = $totalshelfamount + $shelfamount;
				 }?>
                 <?php if($mortuary_copay>0.00){
				  $copayshelfcharges = ($originalshelfcharges/100)*$mortuary_copay;
				  $copayshelfamount = ($originalshelfamount/100)*$mortuary_copay;
				   //$copayamount = $copayrate*$quantity;
				   $copaytotalbed = $copaytotalbed + $copayshelfamount;
				   $sno = $sno + 1; 
			  ?>
                <!--<tr>
             
			  <td class="bodytext31" valign="center"  align="left"><?php echo $nhifdate; ?></td>
			 <td class="bodytext31" valign="center"  align="left"><?php echo $nhifrefno; ?></td>
			 <td class="bodytext31" valign="center"  align="left"> <?php echo $shelve,' COPAY' ?></td>
				 <td class="bodytext31" valign="center"  align="right"><?php echo $days; ?></td>
                 
             <td class="bodytext31" valign="center"  align="right"><?php echo number_format($copayshelfcharges,2,'.',','); ?></td>
			 <td class="bodytext31" valign="center"  align="right"><?php echo number_format($copayshelfamount,2,'.',','); ?></td>
			    </tr>-->
              <?php 
			  //$totalshelfamount = $totalshelfamount + $copayshelfamount;
			  }?>
				<?php

			}
			if($package!='')
			{
			if($days> $packagedays)
			{
				
			$daysafterpackage=$days-$packagedays+1;
			
			$shelfamount=$shelfcharges*$daysafterpackage;
			
			    $originalshelfcharges =  $shelfcharges;
				$originalshelfamount =  $shelfamount;
			
				 if(($mortuary_copay<100.00)&&($mortuary_copay>0.00))
				{ 
					$insushel_copay=100-$mortuary_copay;
					//$shelfcharges=($originalshelfcharges/100)*$insushel_copay;
					//$shelfamount=($originalshelfamount/100)*$insushel_copay;
				}
				if($mortuary_copay>=100.00){$amount=0;}
				
				$copayshelfamount3 = ($originalshelfamount/100)*$mortuary_copay;
				$sno = $sno + 1; 
				if($mortuary_copay<100){
				?>
			 <tr>
			  <td class="bodytext31" valign="center"  align="left"width="79"><?php echo date("d-m-Y", strtotime($nhifdate)); ?></td>
			 <td class="bodytext31" valign="center"  align="left"width="77"><?php echo $nhifrefno; ?></td>
			 <td class="bodytext31" valign="center"  align="left"width="267"> <?php echo $shelve ?></td>
				 <td class="bodytext31" valign="center"  align="right"width="36"><?php echo $daysafterpackage; ?>                 </td>
               
             <td class="bodytext31" valign="center"  align="right"width="66"><?php echo number_format($shelfcharges,2,'.',','); ?></td>
			 <td class="bodytext31" valign="center"  align="right"width="63"><?php echo number_format($shelfamount,2,'.',','); ?></td>
		      </tr>
                 <?php
				 $totalshelfamount = $totalshelfamount + $shelfamount;
				  }?>
                 <?php if($mortuary_copay>0.00){
				  $copayshelfcharges = ($originalshelfcharges/100)*$mortuary_copay;
				  $copayshelfamount = ($originalshelfamount/100)*$mortuary_copay;
				   //$copayamount = $copayrate*$quantity;
				   $copaytotalbed = $copaytotalbed + $copayshelfamount;
				   $sno = $sno + 1;
			  ?>
                <!--<tr>
             
			 <td class="bodytext31" valign="center"  align="left"><?php echo $nhifdate; ?></td>
			 <td class="bodytext31" valign="center"  align="left"><?php echo $nhifrefno; ?></td>
			 <td class="bodytext31" valign="center"  align="left"> <?php echo $shelve,' COPAY' ?></td>
				 <td class="bodytext31" valign="center"  align="right"><?php echo $days; ?></td>
                 
            
             <td class="bodytext31" valign="center"  align="right"><?php echo number_format($copayshelfcharges,2,'.',','); ?></td>
			 <td class="bodytext31" valign="center"  align="right"><?php echo number_format($copayshelfamount,2,'.',','); ?></td>
			    </tr>-->
              <?php
			   //$totalshelfamount = $totalshelfamount + $copayshelfamount;
			   }?>
				<?php
				
			}
			}
			}
				}
				?>
			   <?php 
			$totalpharm=0;
			
			$query23 = "select * from pharmacysales_details where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode' and freestatus = 'No' group by itemcode";
			$exec23 = mysql_query($query23) or die ("Error in Query1".mysql_error());
			$num_pharmacy = mysql_num_rows($exec23);
			if($num_pharmacy>0){
				echo "<tr><td colspan='6'><strong>PHARMACY</strong></td></tr>";
			}
			while($res23 = mysql_fetch_array($exec23))
			{
			$phaquantity=0;
			$quantity1=0;
			$phaamount=0;
			$phaquantity1=0;
			$totalrefquantity=0;
			$phaamount1=0;
			$phadate=$res23['entrydate'];
			$phaname=$res23['itemname'];
			$phaitemcode=$res23['itemcode'];
			$pharate=$res23['rate'];
			$refno = $res23['ipdocno'];
			$pharmfree = $res23['freestatus'];
			$query33 = "select * from pharmacysales_details where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode'";
			$exec33 = mysql_query($query33) or die ("Error in Query1".mysql_error());
		    while($res33 = mysql_fetch_array($exec33))
			{
			$quantity=$res33['quantity'];
			$phaquantity=$phaquantity+$quantity;
			$amount=$res33['totalamount'];
			$phaamount=$phaamount+$amount;
			}
			
			$query331 = "select * from pharmacysalesreturn_details where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode'";
			$exec331 = mysql_query($query331) or die ("Error in Query1".mysql_error());
		    while($res331 = mysql_fetch_array($exec331))
			{
			$quantity1=$res331['quantity'];
			$phaquantity1=$phaquantity1+$quantity1;
			$amount1=$res331['totalamount'];
			$phaamount1=$phaamount1+$amount1;
			}
			
			$resquantity = $phaquantity - $phaquantity1;
			$resamount = $phaamount - $phaamount1;
						
			$resamount=number_format($resamount,2,'.','');
			if($resquantity != 0)
			{
			if($pharmfree =='No')
			{
				$colorloopcount = $colorloopcount + 1;
			$showcolor = ($colorloopcount & 1); 
		
			$totalpharm=$totalpharm+$resamount;
			?>
		<tr>
			
			  <td class="bodytext31" valign="center"  align="left"width="79"><?php echo  date('d-m-Y', strtotime($phadate)); ?></td>
			 <td class="bodytext31" valign="center"  align="left"width="77"><?php echo $refno; ?></td>
			 <td class="bodytext31" valign="center"  align="left"  width="267"><?php echo $phaname; ?></td>
			 <td class="bodytext31" valign="center"  align="right"width="36"><?php echo $resquantity; ?></td>
             <td class="bodytext31" valign="center"  align="right"width="66"><?php echo number_format($pharate,2,'.',','); ?></td>
			 <td class="bodytext31" valign="center"  align="right"width="63"><?php echo $resamount; ?></td>
		     
		</tr>	
			
			  
			  <?php }
			  }
			  }
			  ?>
			  <?php 
			  $totallab=0;
			  $query19 = "select * from ipconsultation_lab where locationcode='$locationcode' and patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemname <> '' and labrefund <> 'refund' and freestatus='No'";
			$exec19 = mysql_query($query19) or die ("Error in Query1".mysql_error());
			$num_lab = mysql_num_rows($exec19);
			if($num_lab>0){
			echo "<tr><td colspan='6'><strong>LAB</strong></td></tr>";
			}
			while($res19 = mysql_fetch_array($exec19))
			{
			$labdate=$res19['consultationdate'];
			$labname=$res19['labitemname'];
			$labcode=$res19['labitemcode'];
			$labrate=$res19['labitemrate'];
			$labrefno=$res19['iptestdocno'];
			$labfree = $res19['freestatus'];
			
			if($labfree == 'No')
			{
			
			
			$totallab=$totallab+$labrate;
			?>
		<tr>
			
			<td class="bodytext31" valign="center"  align="left"width="79"><?php echo  date('d-m-Y', strtotime($labdate)); ?></td>
			<td class="bodytext31" valign="center"  align="left"width="77"><?php echo $labrefno; ?></td>
			<td class="bodytext31" valign="center"  align="left"  width="267"><?php echo $labname; ?></td>
			<td class="bodytext31" valign="center"  align="right"width="36"><?php echo '1'; ?></td>
			<td class="bodytext31" valign="center"  align="right"width="66"><?php echo number_format($labrate,2,'.',','); ?></td>
			<td class="bodytext31" valign="center"  align="right"width="63"><?php echo number_format($labrate,2,'.',','); ?></td>
		</tr>	
			  
			  <?php 
			  }
			  }
			  ?>
			  
			    <?php 
				$totalrad=0;
			  $query20 = "select * from ipconsultation_radiology where locationcode='$locationcode' and patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemname <> '' and radiologyrefund <> 'refund' and freestatus= 'No'";
			$exec20 = mysql_query($query20) or die ("Error in Query1".mysql_error());
			$num_radio = mysql_num_rows($exec20);
						
			if($num_radio>0){
			echo "<tr><td colspan='6'><strong>RADIOLOGY</strong></td></tr>";   
			}
			while($res20 = mysql_fetch_array($exec20))
			{
			$raddate=$res20['consultationdate'];
			$radname=$res20['radiologyitemname'];
			$radrate=$res20['radiologyitemrate'];
			$radref=$res20['iptestdocno'];
			$radiologyfree = $res20['freestatus'];
			
			if($radiologyfree == 'No')
			{
			
		
			
			$totalrad=$totalrad+$radrate;
			?>
		<tr>
			
			<td class="bodytext31" valign="center"  align="left"width="79"><?php echo  date('d-m-Y', strtotime($raddate)); ?></td>
			<td class="bodytext31" valign="center"  align="left"width="77"><?php echo $radref; ?></td>
			<td class="bodytext31" valign="center"  align="left"  width="267"><?php echo $radname; ?></td>
			<td class="bodytext31" valign="center"  align="right"width="36"><?php echo '1'; ?></td>
			<td class="bodytext31" valign="center"  align="right"width="66"><?php echo number_format($radrate,2,'.',','); ?></td>
			<td class="bodytext31" valign="center"  align="right"width="63"><?php echo number_format($radrate,2,'.',','); ?></td>
		</tr>	
			  
			  <?php 
			  }
			  }
			  ?>
			  	    <?php 
					
					$totalser=0;
		    $query21 = "select * from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> '' and servicerefund <> 'refund' and freestatus = 'No'";
			$exec21 = mysql_query($query21) or die ("Error in Query1".mysql_error());
			$num_service = mysql_num_rows($exec21);
			if($num_service>0){
			echo "<tr><td colspan='6'><strong>SERVICE</strong></td></tr>";
			}
			while($res21 = mysql_fetch_array($exec21))
			{
			$serdate=$res21['consultationdate'];
			$sername=$res21['servicesitemname'];
			$serrate=$res21['servicesitemrate'];
			$serref=$res21['iptestdocno'];
			$servicesfree = $res21['freestatus'];
			$sercode=$res21['servicesitemcode'];
			$query2111 = "select * from ipconsultation_services where locationcode='$locationcode' and patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' and iptestdocno = '$serref' and servicerefund <> 'refund'";
			$exec2111 = mysql_query($query2111) or die ("Error in Query2111".mysql_error());
			$numrow2111 = mysql_num_rows($exec2111);
			
			$resqty = mysql_fetch_array($exec2111);
			 $serqty=$resqty['serviceqty'];
			 if($serqty==0){$serqty=$numrow2111;}
			$servicesfree = strtoupper($servicesfree);
			if($servicesfree == 'NO')
			{
				$totserrate=$resqty['amount'];
				 if($totserrate==0){
			$totserrate=$serrate*$numrow2111;
			  }
			//$totserrate=$serrate*$numrow2111;
	
			$totalser=$totalser+$totserrate;
			?>
			<tr>
				
				<td class="bodytext31" valign="center"  align="left"width="79"><?php echo  date('d-m-Y', strtotime($serdate)); ?></td>
				<td class="bodytext31" valign="center"  align="left"width="77"><?php echo $serref; ?></td>
				<td class="bodytext31" valign="center"  align="left"  width="267"><?php echo $sername; ?></td>
				<td class="bodytext31" valign="center"  align="right"width="36"><?php echo $serqty; ?></td>
				<td class="bodytext31" valign="center"  align="right"width="66"><?php echo number_format($serrate,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right"width="63"><?php echo number_format($totserrate,2,'.',','); ?></td>
			</tr>	
			  
			  <?php }
			  }
			  ?>
			<?php
			$totalotbillingamount = 0;
			$query61 = "select * from ip_otbilling where locationcode='$locationcode' and patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec61 = mysql_query($query61) or die(mysql_error());
			$num_ot = mysql_num_rows($exec61);
			if($num_ot>0 ){
				echo "<tr><td colspan='6'><strong>OT SURGERY</strong></td></tr>";
			}
			while($res61 = mysql_fetch_array($exec61))
		   {
			$otbillingdate = $res61['consultationdate'];
			$otbillingrefno = $res61['docno'];
			$otbillingname = $res61['surgeryname'];
			$otbillingrate = $res61['rate'];
			
			$totalotbillingamount = $totalotbillingamount + $otbillingrate;
			?>
		<tr>
			
			<td class="bodytext31" valign="center"  align="left"width="79"><?php echo  date('d-m-Y', strtotime($otbillingdate)); ?></td>
			<td class="bodytext31" valign="center"  align="left"width="77"><?php echo $otbillingrefno; ?></td>
			<td class="bodytext31" valign="center"  align="left"  width="267"><?php echo $otbillingname; ?></td>
			<td class="bodytext31" valign="center"  align="right"width="36"><?php echo '1'; ?></td>
			<td class="bodytext31" valign="center"  align="right"width="66"><?php echo number_format($otbillingrate,2,'.',','); ?></td>
			<td class="bodytext31" valign="center"  align="right"width="63"><?php echo number_format($otbillingrate,2,'.',','); ?></td>
		</tr>
				<?php
				}
				?>
				<?php
			$totalprivatedoctoramount = 0;
			$query62 = "select * from ipprivate_doctor where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec62 = mysql_query($query62) or die(mysql_error());
			$num_pvt = mysql_num_rows($exec62);
			if($num_pvt>0 ){
				echo "<tr><td colspan='6'><strong>PVT DOCTOR CHARGES</strong></td></tr>";
			}
			while($res62 = mysql_fetch_array($exec62))
		   {
			$privatedoctordate = $res62['consultationdate'];
			$privatedoctorrefno = $res62['docno'];
			$privatedoctor = $res62['doctorname'];
			$privatedoctorrate = $res62['rate'];
			$privatedoctoramount = $res62['amount'];
			$privatedoctorunit = $res62['units'];
			$description = $res62['remarks'];
			if($description != '')
			{
			$description = '-'.$description;
			}
			
			$totalprivatedoctoramount = $totalprivatedoctoramount + $privatedoctoramount;
			?>
			<tr>
				
				<td class="bodytext31" valign="center"  align="left"width="79"><?php echo  date('d-m-Y', strtotime($privatedoctordate)); ?></td>
				<td class="bodytext31" valign="center"  align="left"width="77"><?php echo $privatedoctorrefno; ?></td>
				<td class="bodytext31" valign="center"  align="left"  width="267"><?php echo $privatedoctor.' '.$description; ?></td>
				<td class="bodytext31" valign="center"  align="right"width="36"><?php echo $privatedoctorunit; ?></td>
				<td class="bodytext31" valign="center"  align="right"width="66"><?php echo number_format($privatedoctorrate,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right"width="63"><?php echo number_format($privatedoctoramount,2,'.',','); ?></td>
			</tr>
				<?php
				}
				?>
				<?php
			$totalambulanceamount = 0;
			$query63 = "select * from ip_ambulance where locationcode='$locationcode' and patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec63 = mysql_query($query63) or die(mysql_error());
			$num_rescue = mysql_num_rows($exec63);
			if($num_rescue>0){
			echo "<tr><td colspan='6'><strong>RESCUE CHARGES</strong></td></tr>";
			}
			while($res63 = mysql_fetch_array($exec63))
		   {
			$ambulancedate = $res63['consultationdate'];
			$ambulancerefno = $res63['docno'];
			$ambulance = $res63['description'];
			$ambulancerate = $res63['rate'];
			$ambulanceamount = $res63['amount'];
			$ambulanceunit = $res63['units'];
			
			$totalambulanceamount = $totalambulanceamount + $ambulanceamount;
			?>
			<tr>
				
				<td class="bodytext31" valign="center"  align="left"width="79"><?php echo  date('d-m-Y', strtotime($ambulancedate)); ?></td>
				<td class="bodytext31" valign="center"  align="left"width="77"><?php echo $ambulancerefno; ?></td>
				<td class="bodytext31" valign="center"  align="left"  width="267"><?php echo $ambulance; ?></td>
				<td class="bodytext31" valign="center"  align="right"width="36"><?php echo $ambulanceunit; ?></td>
				<td class="bodytext31" valign="center"  align="right"width="66"><?php echo number_format($ambulancerate,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right"width="63"><?php echo number_format($ambulanceamount,2,'.',','); ?></td>
			</tr>
				<?php
				}
				?>
                
                <?php
			$totalhomecareamount = 0;
			$query63 = "select * from iphomecare where locationcode='$locationcode' and patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec63 = mysql_query($query63) or die(mysql_error());
			$num_rescue = mysql_num_rows($exec63);
			if($num_rescue>0){
			echo "<tr><td colspan='6'><strong>HOMECARE CHARGES</strong></td></tr>";
			}
			while($res63 = mysql_fetch_array($exec63))
		   {
			$homecaredate = $res63['consultationdate'];
			$homecarerefno = $res63['docno'];
			$homecare = $res63['description'];
			$homecarerate = $res63['rate'];
			$homecareamount = $res63['amount'];
			$homecareunit = $res63['units'];
			
			$totalhomecareamount = $totalhomecareamount + $homecareamount;
			?>
			<tr>
				
				<td class="bodytext31" valign="center"  align="left"width="79"><?php echo  date('d-m-Y', strtotime($homecaredate)); ?></td>
				<td class="bodytext31" valign="center"  align="left"width="77"><?php echo $homecarerefno; ?></td>
				<td class="bodytext31" valign="center"  align="left"  width="267"><?php echo $homecare; ?></td>
				<td class="bodytext31" valign="center"  align="right"width="36"><?php echo $homecareunit; ?></td>
				<td class="bodytext31" valign="center"  align="right"width="66"><?php echo number_format($homecarerate,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right"width="63"><?php echo number_format($homecareamount,2,'.',','); ?></td>
			</tr>
				<?php
				}
				?>
                
				<?php
			$totalmiscbillingamount = 0;
			$query69 = "select * from ipmisc_billing where locationcode='$locationcode' and patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec69 = mysql_query($query69) or die(mysql_error());
			$num_misc = mysql_num_rows($exec69);
			if($num_misc>0){
			echo "<tr><td colspan='6'><strong>MISC CHARGES</strong></td></tr>";
			}
			while($res69 = mysql_fetch_array($exec69))
		   {
			$miscbillingdate = $res69['consultationdate'];
			$miscbillingrefno = $res69['docno'];
			$miscbilling = $res69['description'];
			$miscbillingrate = $res69['rate'];
			$miscbillingamount = $res69['amount'];
			$miscbillingunit = $res69['units'];
		
			$totalmiscbillingamount = $totalmiscbillingamount + $miscbillingamount;
			?>
			<tr>
				
				<td class="bodytext31" valign="center"  align="left"width="79"><?php echo  date('d-m-Y', strtotime($miscbillingdate)); ?></td>
				<td class="bodytext31" valign="center"  align="left"width="77"><?php echo $miscbillingrefno; ?></td>
				<td class="bodytext31" valign="center"  align="left"  width="267"><?php echo $miscbilling; ?></td>
				<td class="bodytext31" valign="center"  align="right"width="36"><?php echo $miscbillingunit; ?></td>
				<td class="bodytext31" valign="center"  align="right"width="66"><?php echo number_format($miscbillingrate,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right"width="63"><?php echo number_format($miscbillingamount,2,'.',','); ?></td>
			</tr>
				<?php
				}
				?>
				<?php
				 $payoveralltotal=($totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalprivatedoctoramount+$totalambulanceamount+$totalhomecareamount+$totalmiscbillingamount+$totalshelfamount);
				?>			
			<tr>
			<td colspan="6" align="left" class="bodytext31" valign="middle" style="border-top:solid 1px #000000;"></td>
			</tr>
			<tr>
			<td align="right" class="bodytext31" colspan="5" valign="middle"><strong>INVOICE TOTAL AMOUNT :</strong></td>
			<td align="right" class="bodytext31" valign="middle" style=""><strong><?php echo number_format($payoveralltotal,2,'.',','); ?></strong></td>
			</tr>
			<tr>
			<td colspan="6" align="left" class="bodytext31" valign="middle" style="">&nbsp;</td>
			</tr>
			<?php
			$totaldepositamount = 0;
			$query112 = "select * from master_transactionipdeposit where locationcode='$locationcode' and patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysql_query($query112) or die(mysql_error());
			$num_receipt = mysql_num_rows($exec112);
			if($num_receipt>0){
				$temp = 1;
				echo '<tr><td align="center" class="underline" colspan="6" valign="middle">RECEIPTS</td></tr>';	
			}
			while($res112 = mysql_fetch_array($exec112))
			{
			$depositamount = $res112['transactionamount'];
			$depositamount1 = -$depositamount;
			$docno = $res112['docno'];
			$transactionmode = $res112['transactionmode'];
			$transactiondate = $res112['transactiondate'];
			$chequenumber = $res112['chequenumber'];
			
			
			$query731 = "select * from master_ipvisitentry where locationcode='$locationcode' and visitcode='$visitcode' and patientcode='$patientcode'";
			$exec731 = mysql_query($query731) or die(mysql_error());
			$res731 = mysql_fetch_array($exec731);
			$depositbilltype = $res731['billtype'];
		
		
			$totaldepositamount = $totaldepositamount + $depositamount1;
			?>
			<tr>
				
				<td class="bodytext31" valign="center"  align="left"width="79"><?php echo  date('d-m-Y', strtotime($transactiondate)); ?></td>
				<td class="bodytext31" valign="center"  align="left"width="77"><?php echo $docno; ?></td>
				<td class="bodytext31" valign="center"  align="left"  width="267"><?php echo 'Deposit'; ?>&nbsp;&nbsp;<?php echo $transactionmode; ?>
				<?php
				if($transactionmode == 'CHEQUE')
				{
				echo $chequenumber;
				}
				?></td>
				<td class="bodytext31" valign="center"  align="right"width="36"><?php echo '1'; ?></td>
				<td class="bodytext31" valign="center"  align="right"width="66"><?php echo number_format($depositamount,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right"width="63">-<?php echo number_format($depositamount,2,'.',','); ?></td>
			</tr>
			    
			  
			  <?php }
				  
			 $totaladvancedepositamount=0;
				$query112 = "select * from master_transactionadvancedeposit where patientcode='$patientcode' and visitcode='$visitcode' and recordstatus='adjusted'";
			$exec112 = mysql_query($query112) or die(mysql_error());
			while($res112 = mysql_fetch_array($exec112))
			{
			$advancedepositamount = $res112['transactionamount'];
			$docno = $res112['docno'];
			$transactiondate = $res112['transactiondate'];
			
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
			}
			$totaladvancedepositamount += $advancedepositamount;
			?>
			 <tr>
			  <td class="bodytext31" valign="center"  align="left"width="79"><?php echo  date('d-m-Y', strtotime($transactiondate));  ?></td>
			 <td class="bodytext31" valign="center"  align="left"width="77"><?php echo $docno; ?></td>
			 <td class="bodytext31" valign="center"  align="left" width="267"><?php echo 'Advance Deposit'; ?>			</td>
			 <td class="bodytext31" valign="center"  align="left"width="36"><?php echo '1'; ?></td>
             <td class="bodytext31" valign="center"  align="left"width="66"><?php echo number_format($advancedepositamount,2,'.',','); ?></td>
			 <td class="bodytext31" valign="center"  align="left"width="63">-<?php echo number_format($advancedepositamount,2,'.',','); ?></td>
		      </tr>
			  
			  <?php 
			  }
			  ?>
              
			  <?php
			$totaldepositrefundamount = 0;
			$query112 = "select * from deposit_refund where locationcode='$locationcode' and patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysql_query($query112) or die(mysql_error());
			$num_receipt1 = mysql_num_rows($exec112);
			if($num_receipt1>0 && $temp !=1){
				$temp = 1;
				echo '<tr><td align="center" class="underline" colspan="6" valign="middle">RECEIPTS</td></tr>';	
			}
			while($res112 = mysql_fetch_array($exec112))
			{
			$depositrefundamount = $res112['amount'];
			$docno = $res112['docno'];
			$transactiondate = $res112['recorddate'];
			
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
			}
			$totaldepositrefundamount = $totaldepositrefundamount + $depositrefundamount;
			?>
			  <tr>
				 
				 <td class="bodytext31" valign="center"  align="left"width="79"><?php echo date('d-m-Y', strtotime($transactiondate)); ?></td>
				 <td class="bodytext31" valign="center"  align="left"width="77"><?php echo $docno; ?></td>
				 <td class="bodytext31" valign="center"  align="left"  width="267"><?php echo 'Deposit Refund'; ?></td>

				 <td class="bodytext31" valign="center"  align="right"width="36"><?php echo '1'; ?></td>
				 <td class="bodytext31" valign="center"  align="right"width="66"><?php echo number_format($depositrefundamount,2,'.',','); ?></td>
				 <td class="bodytext31" valign="center"  align="right"width="63"><?php echo number_format($depositrefundamount,2,'.',','); ?></td>
			  </tr>
			  <?php 
			  }
			  ?>
			  
						<?php
			$totalnhifamount = 0;
			$query641 = "select * from ip_nhifprocessing where locationcode='$locationcode' and patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec641 = mysql_query($query641) or die(mysql_error());
			$num_receipt2 = mysql_num_rows($exec641);
			if($num_receipt2>0 && $temp !=1){
				$temp = 1;
				echo '<tr><td colspan="6">&nbsp;</td> </tr><tr><td align="center" class="underline" colspan="6" valign="middle">RECEIPTS</td></tr>';	
			}
			while($res641= mysql_fetch_array($exec641))
		   {
			$nhifdate = $res641['consultationdate'];
			$nhifrefno = $res641['docno'];
			$nhifqty = $res641['totaldays'];
			$nhifrate = $res641['nhifrebate'];
			$nhifclaim = $res641['nhifclaim'];
			$nhifclaim = -$nhifclaim;
			
			$totalnhifamount = $totalnhifamount + $nhifclaim;
			?>
			<tr>
				
				<td class="bodytext31" valign="center"  align="left"width="79"><?php echo  date('d-m-Y', strtotime($nhifdate)); ?></td>
				<td class="bodytext31" valign="center"  align="left"width="77"><?php echo $nhifrefno; ?></td>
				<td class="bodytext31" valign="center"  align="left"  width="267"> <?php echo 'NHIF'; ?></td>
				<td class="bodytext31" valign="center"  align="right"width="36"><?php echo $nhifqty; ?></td>
				<td class="bodytext31" valign="center"  align="right"width="66"><?php echo number_format($nhifrate,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right"width="63"><?php echo number_format($nhifclaim,2,'.',','); ?></td>
			</tr>
				<?php
				}
				?>
				<?php
			$totaldiscountamount = 0;
			$query64 = "select * from ip_discount where locationcode='$locationcode' and patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec64 = mysql_query($query64) or die(mysql_error());
			$num_ipdiscount = mysql_num_rows($exec64);
			if($num_ipdiscount>0){
				echo '<tr><td colspan="6">&nbsp;</td> </tr><tr><td align="center" colspan="6" class="underline" valign="middle">CREDITS</td></tr>';
			}
			while($res64 = mysql_fetch_array($exec64))
		   {
			$discountdate = $res64['consultationdate'];
			$discountrefno = $res64['docno'];
			$discount= $res64['description'];
			$discountrate = $res64['rate'];
			$discountrate1 = $discountrate;
			$discountrate = -$discountrate;
			$authorizedby = $res64['authorizedby'];
		
			$totaldiscountamount = $totaldiscountamount + $discountrate;
			?>
			<tr>
				
				<td class="bodytext31" valign="center"  align="left"width="79"><?php echo  date('d-m-Y', strtotime($discountdate)); ?></td>
				<td class="bodytext31" valign="center"  align="left"width="77"><?php echo $discountrefno; ?></td>
				<td class="bodytext31" valign="center"  align="left"  width="267">Discount On <?php echo $discount; ?> by <?php echo $authorizedby; ?></td>
				<td class="bodytext31" valign="center"  align="right"width="36"><?php echo '1'; ?></td>
				<td class="bodytext31" valign="center"  align="right"width="66"><?php echo number_format($discountrate1,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right"width="63"><?php echo number_format($discountrate,2,'.',','); ?></td>
			</tr>
				<?php
				}
				?>

				<?php
			$paid_amount = 0;
			$query64 = "select transactiondate,billnumber,cashamount,onlineamount,creditamount,chequeamount,cardamount,mpesaamount,username, returnbalance from master_transactionip where locationcode='$locationcode' and patientcode='$patientcode' and visitcode='$visitcode'";
			$exec64 = mysql_query($query64) or die(mysql_error());
			while($res64 = mysql_fetch_array($exec64))
		   {
			$billdate = $res64['transactiondate'];
			$billnumber = $res64['billnumber'];
			$returnbalance = $res64['returnbalance'];
            $kj=0;

			if(($res64['cashamount']+$res64['onlineamount']+$res64['creditamount']+$res64['chequeamount']+$res64['cardamount']+$res64['mpesaamount'])>0){
				echo '<tr><td colspan="6">&nbsp;</td> </tr><tr><td align="center" colspan="6" class="underline" valign="middle">PAYMENTS</td></tr>';
			}

			while($kj<=5){
				
 			if($kj==0){
				$mode="CASH";
				$amount = $res64['cashamount'];
			}else if($kj==1){
				$mode="ONLINE";
				$amount = $res64['onlineamount'];			
			}else if($kj==2){
				$mode="CREDIT";
				$amount = $res64['creditamount'];			
			}else if($kj==3){
				$mode="CHEQUE";
				$amount = $res64['chequeamount'];			
			}else if($kj==4){
				$mode="CARD";
				$amount = $res64['cardamount'];			
			}else if($kj==5){
				$mode="MPESA";
				$amount = $res64['mpesaamount'];			
			}
			if($amount>0){
				
			$authorizedby = $res64['username'];
			$amount = $amount + $returnbalance;
			
			$paid_amount = $paid_amount + $amount;
			?>
			<tr>
				<td class="bodytext31" valign="center"  align="left"width="79"><?php echo  date('d-m-Y', strtotime($billdate)); ?></td>
				<td class="bodytext31" valign="center"  align="left"width="77"><?php echo $billnumber; ?></td>
				<td class="bodytext31" valign="center"  align="left"width="267"> Payment By <?php echo $mode; ?> </td>
				<td class="bodytext31" valign="center"  align="right"width="36"><?php echo '1'; ?></td>
				<td class="bodytext31" valign="center"  align="right"width="66"><?php echo number_format($amount,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right"width="63">-<?php echo number_format($amount,2,'.',','); ?></td>
			</tr>
				<?php
						}
										$kj++;

					}
				
				}
				?>

						
			  <?php 
			  include('convert_currency_to_words.php');
			  $depositamount = 0;
			  $overalltotal=($totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalprivatedoctoramount+$totalambulanceamount+$totalhomecareamount+$totaldiscountamount+$totalmiscbillingamount+$totaldepositamount+$totalnhifamount+$totaldepositrefundamount)-$totaladvancedepositamount-$paid_amount;
                          $overalltotal=$overalltotal+$totalshelfamount;
			  $overalltotal=number_format($overalltotal,2,'.','');
			  if($overalltotal<0 or $overalltotal == '-0.00')
                          {
                          $overalltotal=abs($overalltotal);
                          $convertedwords = covert_currency_to_words($overalltotal);
                          $overalltotal='-'.number_format($overalltotal,2,'.','');
                          }else
                          {
                          $convertedwords = covert_currency_to_words($overalltotal);
			  $overalltotal=number_format($overalltotal,2,'.','');
                          }
			  $consultationtotal=$totalop;
			   $consultationtotal=number_format($consultationtotal,2,'.','');
			   $netpay= $consultationtotal+$totallab+$totalpharm+$totalrad+$totalser;
			   $netpay=number_format($netpay,2,'.','');
			  ?>
    </tbody>
			<tr>
			<td colspan="6" align="left" class="bodytext31" valign="middle" style="border-top:solid 1px #000000;"></td>
			</tr>
			<tr> 
            <td colspan="4" class="bodytext31" align="left"><strong>Kenya Shillings:</strong><?php echo str_replace('Kenya Shillings','',$convertedwords); ?></td> 
			<td colspan="" class="bodytext31" align="right"><strong>Balance :</strong></td>
			<td class="bodytext31" align="right"><strong><?php echo $overalltotal; ?></strong></td>
		</tr>
		<tr>
			<td colspan="6" align="left" class="bodytext31" valign="middle" style="border-top:solid 1px #000000;"></td>
	</tr>
         <tr>
			<td colspan="6" class="bodytext31" align="right">&nbsp;</td>
    </tr>
		<tr>

			<td class="bodytext31"  colspan="6"  align="left" width="79">Discharged By : <?php echo $employeename; ?></td>
    </tr>

            <!--<tr>
				<td align="center" class="underline" colspan="6" valign="middle"><b style="text-decoration:underline">SUMMARY</b><br /><br />
                </td></tr>
                	
               
            <?php if($totalop>0){ ?>
            <tr>
                <td colspan="2" align="center"></td>
                <td width="auto" align="left" ><strong>Admission Charges:</strong></td>
                <td align="right" ><?php echo number_format($totalop,2,'.',','); ?></td>
            </tr>
			<?php } ?>
            <?php if($packageamount>0){ ?>
            <tr>
                <td colspan="2" align="center"></td>
                <td width="auto" align="left" ><strong>Package Charges:</strong></td>
                <td align="right" ><?php echo number_format($packageamount,2,'.',','); ?></td>
            </tr>
			<?php } ?>
            <?php if($totalbedtransferamount+$totalbedallocationamount>0){ ?>
            <tr>
                <td colspan="2" align="center"></td>
                <td width="auto" align="left" ><strong>Bed Charges:</strong></td>
                <td align="right" ><?php echo number_format($totalbedtransferamount+$totalbedallocationamount,2,'.',','); ?></td>
            </tr>
			<?php } ?>
			<?php if($totalshelfamount>0){ ?>
            <tr>
                <td colspan="2" align="center"></td>
              <td align="left"><strong>Mortuary Amount:</strong></td>
              <td align="right" ><?php echo number_format($totalshelfamount,2,'.',','); ?></td>
            </tr>
			<?php } ?>
            <?php if($totalpharm>0){ ?>
            <tr>
                <td colspan="2" align="center"></td>
              <td align="left"><strong>Pharmacy Amount:</strong></td>
              <td align="right" ><?php echo number_format($totalpharm,2,'.',','); ?></td>
            </tr>
			<?php } ?>
            <?php if($totallab>0){ ?>
            <tr>
                <td colspan="2" align="center"></td>
              <td align="left"><strong>Lab Amount:</strong></td>
              <td align="right" ><?php echo number_format($totallab,2,'.',','); ?></td>
            </tr>
			<?php } ?>
            <?php if($totalrad>0){ ?>
            <tr>
                <td colspan="2" align="center"></td>
              <td align="left" ><strong>Radiology Amount:</strong></td>
              <td align="right"><?php echo number_format($totalrad,2,'.',','); ?></td>
            </tr>
			<?php } ?>
            <?php if($totalser>0){ ?>
            <tr>
                <td colspan="2" align="center"></td>
              <td align="left"><strong>Service Amount:</strong></td>
              <td align="right"><?php echo number_format($totalser,2,'.',','); ?></td>
            </tr>            
			<?php } ?>
            <?php if($totalotbillingamount>0){ ?>
            <tr>
                <td colspan="2" align="center"></td>
              <td align="left"><strong>OT Charges:</strong></td>
              <td align="right"><?php echo number_format($totalotbillingamount,2,'.',','); ?></td>
            </tr>
			<?php } ?>
            <?php if($totalprivatedoctoramount>0){ ?>
            <tr>
                <td colspan="2" align="center"></td>
              <td align="left"><strong>Private Amount:</strong></td>
              <td align="right"><?php echo number_format($totalprivatedoctoramount,2,'.',','); ?></td>
            </tr>
			<?php } ?>
            <?php if($totalmiscbillingamount>0){ ?>
            <tr>
                <td colspan="2" align="center"></td>
                <td width="auto" align="left" ><strong>Misc Charges:</strong></td>
                <td align="right" ><?php echo number_format($totalmiscbillingamount,2,'.',','); ?></td>
            </tr>
			<?php } ?>
            <?php if($totalambulanceamount>0){ ?>
            <tr>
                <td colspan="2" align="center"></td>
                <td width="auto" align="left" ><strong>Ambulance Charges:</strong></td>
                <td align="right" ><?php echo number_format($totalambulanceamount,2,'.',','); ?></td>
            </tr>
			<?php } ?>
            <?php if($totalhomecareamount>0){ ?>
            <tr>
                <td colspan="2" align="center"></td>
                <td width="auto" align="left" ><strong>Homecare Charges:</strong></td>
                <td align="right" ><?php echo number_format($totalhomecareamount,2,'.',','); ?></td>
            </tr>
			<?php } ?>
            <tr>
                <td colspan="2" align="center"></td>
                <td width="auto" align="left" ><strong>Discount Amount:</strong></td>
                <td align="right" ><?php echo number_format($totaldiscountamount,2,'.',','); ?></td>
            </tr>
             <tr>
                <td colspan="2" align="center"></td>
                <td width="auto" align="left" ><strong>Deposit Amount:</strong></td>
                <td align="right" ><?php echo number_format($totaldepositamount,2,'.',','); ?></td>
            </tr>
            <tr>
                <td colspan="2" align="center"></td>
                <td width="auto" align="left" ><strong>NHIF amount:</strong></td>
                <td align="right" ><?php echo number_format($totalnhifamount,2,'.',','); ?></td>
            </tr>
            <tr>
                <td colspan="2" align="center"></td>
                <td width="auto" align="left" ><strong>Deposit Refund:</strong></td>
                <td align="right" ><?php echo number_format($totaldepositrefundamount,2,'.',','); ?></td>
            </tr>
            <tr>
                <td colspan="2" align="center"></td>
                <td width="auto" align="left" ><strong>Advance Deposit:</strong></td>
                <td align="right" ><?php echo "-".number_format($totaladvancedepositamount,2,'.',','); ?></td>
            </tr>
            <tr>
                <td colspan="2" align="center"></td>
                <td width="auto" align="left" ><strong>Payment:</strong></td>
                <td align="right" ><?php echo "-".number_format($paid_amount,2,'.',','); ?></td>
            </tr>


            <tr>
                <td colspan="2" align="center"></td>
                <td colspan="2">
                <hr />
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center"></td>
              <td align="left"><strong>Total Amount</strong></td>
              <td align="right"><?php echo number_format($overalltotal,2,'.',','); ?></td>
            </tr>-->


<tr>
    <td colspan="6">
    &nbsp;<br /><br /><br />
    </td>
</tr>


<tr >
<td  align="left" valign="left" 
	 bgcolor="#ffffff" class="bodytext31" colspan="2"> <b>Billing Clerk </b> 
      <br />
      <br />
      Signature ....................
    </td>
<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"  colspan="2">  <b> </b> 
      <br />
      <br />
      
    </td>
<td align="left" valign="left"  colspan="2" 
	 bgcolor="#ffffff"><strong>Patient</strong>
      <br />
      <br />
      Signature ....................    
    </td>
</tr>
<tr>
    <td colspan="6">
    &nbsp;<br />
    </td>
</tr>

<tr>
<td colspan="6" align="center"> </td>
</tr>



</table> 
</page>
<?php	
//exit;
$content = ob_get_clean();

    // convert in PDF
    require_once('html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array(0, 0, 0, 0));
//      $html2pdf->setModeDebug();
//        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('Final Bill.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>
