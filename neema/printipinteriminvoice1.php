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
$mortuaryupdatedate = date('Y-m-d');
$updatetime = date('H:i:s');
$currentdate = date('Y-m-d');
$docno=$_SESSION["docno"];
ob_start();

$query = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname ";
	$exec = mysql_query($query) or die ("Error in Query1".mysql_error());
	$res = mysql_fetch_array($exec);
	
 	$locationname = $res["locationname"];
	$locationcode = $res["locationcode"];
$reqdate="";
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$phaname='';
$resquantity='';
$pharate='';
$phaamount='';
$sername='';
$serrate='';
$resquantity='';
$pharate='';
$phaamount='';
$sername='';
$serrate='';

if (isset($_REQUEST["st"])) { $st = $_REQUEST["st"]; } else { $st = ""; }
//$st = $_REQUEST['st'];
if ($st == '1')
{
	$errmsg = "Success. Payment Entry Update Completed.";
}
if ($st == '2')
{
	$errmsg = "Failed. Payment Entry Not Completed.";
}


?>

<?php
if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
?>
 
<style type="text/css">

.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; 
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #000000; 
}
.bodytext34 {FONT-WEIGHT: bold; FONT-SIZE: 15px; COLOR: #000000;
}
.bodytexthead {FONT-WEIGHT: normal; FONT-SIZE: 40px; COLOR: #000000; 
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000;  text-decoration:none
}
.bodytext365 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #000000;  text-decoration:none
}
.bodytext366 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #000000;  text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; 
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; 
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; 
}
.underline{text-decoration: underline;}

body {
	margin:0 auto; 
	width:100%;
	background-color: #FFFFFF;
	font-family:Arial, Helvetica, sans-serif;
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C;  }

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
</style>


<?php 
/*$query2 = "select * from master_company where auto_number = '$companyanum'";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$companyname = $res2["companyname"];
$address1 = $res2["address1"];
$address2 = $res2["address2"];
$area = $res2["area"];
$city = $res2["city"];
$pincode = $res2["pincode"];
$phonenumber1 = $res2["phonenumber1"];
$phonenumber2 = $res2["phonenumber2"];
$tinnumber1 = $res2["tinnumber"];
$cstnumber1 = $res2["cstnumber"];*/
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
		$locationname =  $res2["locationname"];
		$prefix = $res2["prefix"];
		$suffix = $res2["suffix"];

?>
           <?php
 		$query1 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
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
		$accountnum = $res1['accountname'];
			
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
			
		
		$query13 = "select * from master_subtype where auto_number = '$subtypeanum'";
		$exec13 = mysql_query($query13) or die("Error in Query13".mysql_error());
		$res13 = mysql_fetch_array($exec13);
		$subtype = $res13['subtype'];
//		$fxrate=$res13['fxrate'];
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
		
		$query813 = "select * from ip_discharge where visitcode='$visitcode' and patientcode='$patientcode'";
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
		 
		 $query677 = "select * from master_customer where customercode='$patientcode'"; 
		$exec677 = mysql_query($query677); 
		$res677 = mysql_fetch_array($exec677);
		$mrdno = $res677['mrdno'];
		
		 $query622 = "select * from consultation_icd where patientcode='$patientcode' and patientvisitcode='$visitcode'"  ; 
		$exec622 = mysql_query($query622); 
		$res622 = mysql_fetch_array($exec622);
		$diagnostic = $res622['primarydiag'];
		
		 $query453 = "select * from consultation_icd1 where  patientcode='$patientcode' and patientvisitcode='$visitcode'" ; 
		$exec453 = mysql_query($query453); 
		$res453 = mysql_fetch_array($exec453);
		$diagnostic1 = $res453['disease'];
		 
		$query2 = "select * from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";
		$exec2 = mysql_query($query2) or die(mysql_error());
		$res2 = mysql_fetch_array($exec2);
		$admissiondate = $res2['recorddate'];
		$wardanum = $res2['ward'];
		$bed = $res2['bed'];
		
		 $query511 = "select * from `$bedtable` where auto_number='$bed'";
		 $exec511 = mysql_query($query511) or die(mysql_error());
		 $res511 = mysql_fetch_array($exec511);
		 $bedname1 = $res511['bed'];
		
		$query12 = "select * from master_ward where auto_number = '$wardanum'";
		$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
		$res12 = mysql_fetch_array($exec12);
		$wardname = $res12['ward'];
		//No. of days calculation
		$startdate = strtotime($admissiondate);
		$enddate = strtotime($currentdate);
		$nbOfDays = $enddate - $startdate;
		$nbOfDays = ceil($nbOfDays/60/60/24);
		//billno
		$querybill = "select billno from billing_ip where locationcode='$locationcode' and patientcode = '$patientcode' and visitcode = '$visitcode'"; 
		$execbill = mysql_query($querybill) or die ("Error in querybill".mysql_error());
		$resbill = mysql_fetch_array($execbill);
		$billno = $resbill['billno'];
		?>

<page pagegroup="new" backtop="12mm" backbottom="20mm" backleft="2mm" backright="3mm">
 <?php  include('print_header_invoice.php'); ?>
    

  <table width="100%"  border="0" cellpadding="2" cellspacing="2" align="center">
		  <tr><td colspan="6">&nbsp;
          
         </td></tr>

		   <tr>
             <td width="25%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Name : </strong></td> 
		     <td  width="350"   align="left" valign="center" class="bodytext31"><?php echo $patientname; ?></td>
		     <td  width="25%"   align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Bill Date : </strong></td> 
		     <td  width="25%"   align="left" valign="center" class="bodytext31"><?php echo  date("d/m/Y", strtotime($currentdate)); ?></td>
          </tr>
		  
	       <tr>
             <td  width="25%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Reg. No. : </strong></td>
	         <td  width="25%"  align="left"  valign="center" class="bodytext31"><?php echo $patientcode; ?></td>
	         <td  width="25%"  align="left"  valign="center" bgcolor="#ffffff" class="bodytext31"><strong>IP Visit No. : </strong></td>
			<td  width="25%" align="auto" valign="left" class="bodytext31"><?php echo $visitcode; ?></td>

         </tr>
          <tr>
             <td  width="25%" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Bill Type : </strong></td>
	         <td  width="25%"    align="left" valign="center" class="bodytext31"><?php echo $billtype; ?></td>
	         <td  width="25%"   align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Admission Date : </strong></td> 
	         <td  width="25%"  align="left" valign="center" class="bodytext31"><?php echo  date("d/m/Y", strtotime($admissiondate)); ?></td>
         </tr>
        <tr>
			<td  width="25%"  align="left" rowspan= "1" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Account : </strong></td>
			<td  width="25%"   align="left" valign="center" rowspan= "1" class="bodytext31"><?php echo $accname; ?></td>
			 <td  width="25%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>No of Days : </strong></td>
			<td  width="25%" align="left" valign="left" class="bodytext31"><?php echo $nbOfDays; ?></td>
			<!--<td  width="25%"  width=""  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Doctor :</strong></td>
			<td  width="25%" align="" valign="center" class="bodytext31"><?php //echo $consultingdoctor; ?></td>-->
            </tr>
		
		 <tr>
         	<td  width="25%"  align="left" rowspan= "1" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Catagory : </strong></td>
			<td  width="25%"  align="left"  valign="center" rowspan= "1" class="bodytext31"><?php echo $subtype; ?></td>
            <td  width="25%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Type : </strong></td>
			<td  width="25%" align="left" valign="left" class="bodytext31"><?php echo $type; ?></td>
          </tr>
          <tr>
           <td  width="25%"  align="left" rowspan= "1" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Membership No:</strong></td>
			<td  width="25%"    align="left"  valign="center" rowspan= "1" class="bodytext31"><?php echo $mrdno; ?></td>
           <td  width="25%"   align="left" valign="center" rowspan= "1" bgcolor="#ffffff" class="bodytext31"><strong>Bed: </strong></td>
			<td  width="25%" align="left" valign="center" rowspan= "1" class="bodytext31"><?php echo $bedname1;?></td>
		</tr>
         
           <tr>
           	<td  width="25%" colspan="2" ></td>
         	<td  width="25%"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Diagnostic Code 1:</strong></td>
			<td  width="25%" align="left"  valign="center"  class="bodytext31"><?php echo $diagnostic; ?></td>
           
          </tr>
           <tr>
           	<td  width="25%" colspan="2" ></td>
         	<td  width="25%"  align="left"  valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Diagnostic Code 2:</strong></td>
			<td  width="25%" align="left"  valign="center"  class="bodytext31"><?php echo $diagnostic1; ?></td>
           
          </tr>

			<tr>
			 	<td colspan="6"   align="center"><hr /></td>
			</tr>
			<tr>
			 	<td colspan="6"   align="center"><strong>SUMMARY INVOICE</strong></td>
			</tr>
			<tr>
			 	<td colspan="6"   align="center"><hr /></td>
			</tr>
		<!--<thead>
			<tr class="flyleaf">
				<td width=""  align="left" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><strong></strong></td>
				<td width="20%"  align="left" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><strong>BILL DATE</strong></td>
				<td width="20%"  align="left" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><strong>REF No.</strong></td>
				<td width="25%"  align="left" valign="center" style="white-space:normal"
				bgcolor="#ffffff" class="bodytext31"><strong>DESCRIPTION</strong></td>
				<td width="7%"  align="right" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><strong>QTY</strong></td>
				<td width="12%"  align="right" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><strong>RATE </strong></td>
				<td width="16%"  align="right" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><strong>AMOUNT </strong></td>
			</tr>
            </thead>-->
            <tbody>
				  		
			
			<?php
			$colorloopcount = '';
			$sno = '';
			$totalamount=0;
			$totalquantity = 0;

					  $packageamount = 0;
			 $query731 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'"; 
			$exec731 = mysql_query($query731) or die(mysql_error());
			$res731 = mysql_fetch_array($exec731);
			$packageanum1 = $res731['package'];
			$packagedate1 = $res731['consultationdate'];
			$packageamount = $res731['packagecharge'];
			
			$query741 = "select * from master_ippackage where auto_number='$packageanum1'";
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
          <!--   <tr><td colspan="6"><strong>PACKAGE CHARGE</strong></td></tr>
		<tr>
			<td class="bodytext31" valign="center"  align="left"><?php //echo $sno = $sno + 1; ?></td>
			<td class="bodytext31" valign="center"  align="left"><?php echo  date("d-m-Y", strtotime($packagedate1)); ?></td>
			<td class="bodytext31" valign="center"  align="left"><?php echo $visitcode; ?></td>
			<td class="bodytext31" valign="center"  align="left"><?php echo $packagename; ?></td>
			<td class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>
			<td class="bodytext31" valign="center"  align="right"><?php echo number_format($packageamount,2,'.',','); ?></td>
			<td class="bodytext31" valign="center"  align="right"><?php echo number_format($packageamount,2,'.',','); ?></td>
		</tr> -->
			  <?php
			  }
			  ?>
			<?php 
			$totalbedallocationamount = 0;
			
			 $requireddate = '';
			 $quantity = '';
			 $allocatenewquantity = '';
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
                        <td class="bodytext31" colspan="4" valign="center"  align="left"><strong><?php echo $charge;?></strong></td>
                        <td class="bodytext31" valign="center"  align="right"><?php  echo number_format($amount,2,'.',',');  ?></td>                   
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
							<td class="bodytext31" colspan="4" valign="center"  align="left"><strong><?php echo $charge;?></strong></td>
							<td class="bodytext31" valign="center"  align="right"><?php  echo number_format($amount,2,'.',',');  ?></td>                   
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
			 
                <?php
				$totalshelfamount = $totalshelfamount + $amount;
				 }?>
                 <?php if($mortuary_copay>0.00){
				  $copayamount = ($originalamount/100)*$mortuary_copay;
				   //$copayamount = $copayrate*$quantity;
				   $copaytotalbed = $copaytotalbed + $copayamount;
				   $sno = $sno + 1; 
			  ?>
               
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
               
              <?php
			   //$totalshelfamount = $totalshelfamount + $copayshelfamount;
			   }?>
				<?php
				
			}
			}
			}
				}
				?>
				<tr>
					<td class="bodytext31" colspan="4" valign="center"  align="left"><strong><?php echo 'Mortuary Charges:';?></strong></td>
					<td class="bodytext31" valign="center"  align="right"><?php  echo number_format($totalshelfamount,2,'.',',');  ?></td>                   
				</tr>
			   <?php 
			$totalpharm=0;
			$phaamount31=0;
			$phaamount3=0;
			$query23 = "select * from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' and freestatus = 'No' group by itemcode";
			$exec23 = mysql_query($query23) or die ("Error in Query1".mysql_error());
			$num_pharmacy = mysql_num_rows($exec23);
			
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
			$query33 = "select * from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode'";
			$exec33 = mysql_query($query33) or die ("Error in Query1".mysql_error());
			$num_pharmacy = mysql_num_rows($exec33);
		    while($res33 = mysql_fetch_array($exec33))
			{
			$quantity=$res33['quantity'];
			$phaquantity=$phaquantity+$quantity;
			$amount=$res33['totalamount'];
			$phaamount=$phaamount+$amount;
			}
			
			$query331 = "select * from pharmacysalesreturn_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode'";
			$exec331 = mysql_query($query331) or die ("Error in Query1".mysql_error());
			$num_pharmacy = mysql_num_rows($exec331);
			
		    while($res331 = mysql_fetch_array($exec331))
			{
			$quantity1=$res331['quantity'];
			$phaquantity1=$phaquantity1+$quantity1;
			$amount1=$res331['totalamount'];
			$phaamount1=$phaamount1+$amount1;
			}
			
			$phaamount3=$phaamount3+$phaamount;
			$phaamount31=$phaamount31+$phaamount1; 
			
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
			}
			 }
			  }
			?>
        
		<tr>
			<td class="bodytext31" colspan="4" valign="center"  align="left"><strong>Pharmacy:</strong></td>
			 
			 <input name="medicinename[]" type="hidden" id="medicinename" size="25" value="<?php echo $phaname; ?>">
			 <input name="quantity[]" type="hidden" id="quantity" size="8" readonly value="<?php echo $resquantity; ?>">
			 <input name="rate[]" type="hidden" id="rate" readonly size="8" value="<?php echo $pharate; ?>">
			 <input name="amount[]" type="hidden" id="amount" readonly size="8" value="<?php echo $phaamount; ?>">
			
			 <td class="bodytext31" valign="center"  align="right"><?php  echo number_format($phaamount3,2,'.',',');  ?></td>
		     
		</tr>
        <tr>
			<td class="bodytext31" colspan="4" valign="center"  align="left"><strong>Pharmacy Returns:</strong></td>
			 
			 	
			 <td class="bodytext31" valign="center"  align="right"><?php  echo number_format($phaamount31,2,'.',',');  ?></td>
		     
		</tr>	
			
			  
			  <?php
			 //  }
//			  }
			 // }
			  ?>
			  <?php 
			  $totallab=0;
			  $query19 = "select * from ipconsultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemname <> '' and labrefund <> 'refund' and freestatus='No'";
			$exec19 = mysql_query($query19) or die ("Error in Query1".mysql_error());
			$num_lab = mysql_num_rows($exec19);
				
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
			 }
			  }
			?>
        
		<tr>
			<td class="bodytext31" colspan="4" valign="center"  align="left"><strong>Laboratory:</strong></td>
			
				
			<td class="bodytext31" valign="center"  align="right"><?php echo number_format($totallab,2,'.',','); ?></td>
		</tr>	
			  
			  <?php 
			 
			  ?>
			  
			    <?php 
				$totalrad=0;
			  $query20 = "select * from ipconsultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemname <> '' and radiologyrefund <> 'refund' and freestatus= 'No'";
			$exec20 = mysql_query($query20) or die ("Error in Query1".mysql_error());
			$num_radio = mysql_num_rows($exec20);
						
			/*if($num_radio>0){
			echo "<tr><td colspan='6'><strong>RADIOLOGY</strong></td></tr>";   
			}*/
			
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
			}
			}
			?>
       
		<tr>
        
			<td class="bodytext31" colspan="4" valign="center"  align="left"><strong>Radiology:</strong></td>
			
			<td class="bodytext31" valign="center"  align="right"><?php echo number_format($totalrad,2,'.',','); ?></td>
		</tr>	
			  
			  <?php 
			  $theatreamt=0;
			
		   $query199 = "select * from ipconsultation_services where servicesitemname like '%THEATRE%' AND patientvisitcode='$visitcode' and patientcode='$patientcode'";
			$exec199 = mysql_query($query199) or die ("Error in Query1".mysql_error());
			
				
			while($res199 = mysql_fetch_array($exec199))
			{
			
			$theatrerate=$res199['amount'];
			$theatrefreestatus=$res199['freestatus'];
			
			
			if($theatrefreestatus == 'No')
			{
			
			
			//$theatreamt=$theatreamt+$theatrerate;
			  }
              }
			?>
        
		<?php /*?><tr>
			<td class="bodytext31" colspan="4" valign="center"  align="left"><strong>Theatre:</strong></td>
			
				
			<td class="bodytext31" valign="center"  align="right"><?php echo number_format($theatreamt,2,'.',','); ?></td>
		</tr><?php */?>
        <?php	
             
			  ?>
              <?php
			$colorloopcount = '';
			$sno = '';
			$totalamount=0;
			$totalquantity = 0;
			$totalop =0;
			$query17 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec17 = mysql_query($query17) or die ("Error in Query1".mysql_error());
			$res17 = mysql_fetch_array($exec17);
			$consultationfee=$res17['admissionfees'];
			$packageanum1 = $res17['package'];
			$consultationfee = number_format($consultationfee,2,'.','');
			$viscode=$res17['visitcode'];
			$consultationdate=$res17['consultationdate'];
			$packchargeapply = $res17['packchargeapply'];
			
			
			$query53 = "select * from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec53 = mysql_query($query53) or die(mysql_error());
			$res53 = mysql_fetch_array($exec53);
			$refno = $res53['docno'];
			
			
			$totalop=$consultationfee;
			
			?>
       
			  <tr>
			 <td class="bodytext31" colspan="4" valign="center"  align="left"><strong>Admission Fees:</strong></td>
			   
                <td class="bodytext31" valign="center"  align="right"><?php echo number_format($consultationfee,2,'.',','); ?></td>
				 
           	</tr>	
              
              
              
              
			  	    <?php 
					
					$totalser=0;
					$totserrate=0;
		    $query21 = "select * from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname != '' and servicerefund != 'refund'"; 
			$exec21 = mysql_query($query21) or die ("Error in Query1".mysql_error());
			$num_service = mysql_num_rows($exec21);
			/*if($num_service>0){
			echo "<tr><td colspan='6'><strong>SERVICE</strong></td></tr>";
			}*/
			while($res21 = mysql_fetch_array($exec21))
			{
				
			$serdate=$res21['consultationdate'];
			$sername=$res21['servicesitemname'];
			$serrate=$res21['servicesitemrate'];  
			$serref=$res21['iptestdocno'];
			$servicesfree = $res21['freestatus'];
			$sercode=$res21['servicesitemcode'];
			$query2111 = "select * from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' and iptestdocno = '$serref' and servicerefund <> 'refund'";
			$exec2111 = mysql_query($query2111) or die ("Error in Query2111".mysql_error());
			$numrow2111 = mysql_num_rows($exec2111);
			$res211 = mysql_fetch_array($exec2111);
			
			$res21['amount'];
			
			if($servicesfree == 'No' or $servicesfree == 'no')
			{
				$totserrate=$res21['amount'];
				if($totserrate==0)
				{
			$totserrate=$serrate*$numrow2111;
				}
	
			$totalser=$totalser+$totserrate;
			}
			}
			?>
            
			<tr>
				<td class="bodytext31" colspan="4" valign="center"  align="left"><strong>Services and Procedures:</strong></td>
				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($totserrate,2,'.',','); ?></td>
			</tr>	
			  
			 
			<?php
			$totalotbillingamount = 0;
			$query61 = "select * from ip_otbilling where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec61 = mysql_query($query61) or die(mysql_error());
			$num_ot = mysql_num_rows($exec61);
			/*if($num_ot>0 ){
				echo "<tr><td colspan='6'><strong>OT SURGERY</strong></td></tr>";
			}*/
			while($res61 = mysql_fetch_array($exec61))
		   {
			$otbillingdate = $res61['consultationdate'];
			$otbillingrefno = $res61['docno'];
			$otbillingname = $res61['surgeryname'];
			$otbillingrate = $res61['rate'];
			
			$totalotbillingamount = $totalotbillingamount + $otbillingrate;
		   }
			?>
		<tr>
			<td class="bodytext31" colspan="4" valign="center"  align="left"><strong>OT Surgery:</strong></td>
			
			
			<td class="bodytext31" valign="center"  align="right"><?php echo number_format($totalotbillingamount,2,'.',','); ?></td>
		</tr>
				
				<?php
			$totalprivatedoctoramount = 0;
			$query62 = "select * from ipprivate_doctor where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec62 = mysql_query($query62) or die(mysql_error());
			$num_pvt = mysql_num_rows($exec62);
			
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
		   }
			?>
            
			<tr>
				<td class="bodytext31" colspan="4" valign="center"  align="left"><strong>PVT Doctor Charges</strong></td>
				
				
			
				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($totalprivatedoctoramount,2,'.',','); ?></td>
			</tr>
				
				<?php
			$totalambulanceamount = 0;
			$query63 = "select * from ip_ambulance where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec63 = mysql_query($query63) or die(mysql_error());
			$num_rescue = mysql_num_rows($exec63);
			
			while($res63 = mysql_fetch_array($exec63))
		   {
			$ambulancedate = $res63['consultationdate'];
			$ambulancerefno = $res63['docno'];
			$ambulance = $res63['description'];
			$ambulancerate = $res63['rate'];
			$ambulanceamount = $res63['amount'];
			$ambulanceunit = $res63['units'];
			
			$totalambulanceamount = $totalambulanceamount + $ambulanceamount;
		   }
			?>
            
			<tr>
				<td class="bodytext31" colspan="4" valign="center"  align="left"><strong>Rescue Charges:</strong></td>
				
							
				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($totalambulanceamount,2,'.',','); ?></td>
			</tr>
				
                <?php
			$totalhomecareamount = 0;
			$query63 = "select * from iphomecare where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec63 = mysql_query($query63) or die(mysql_error());
			$num_rescue = mysql_num_rows($exec63);
			
			while($res63 = mysql_fetch_array($exec63))
		   {
			$homecaredate = $res63['consultationdate'];
			$homecarerefno = $res63['docno'];
			$homecare = $res63['description'];
			$homecarerate = $res63['rate'];
			$homecareamount = $res63['amount'];
			$homecareunit = $res63['units'];
			
			$totalhomecareamount = $totalhomecareamount + $homecareamount;
		   }
			?>
            
			<tr>
				<td class="bodytext31" colspan="4" valign="center"  align="left"><strong>Homecare Charges:</strong></td>
				
							
				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($totalhomecareamount,2,'.',','); ?></td>
			</tr>
                
				<?php
			$totalmiscbillingamount = 0;
			$query69 = "select * from ipmisc_billing where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec69 = mysql_query($query69) or die(mysql_error());
			$num_misc = mysql_num_rows($exec69);
			/*if($num_misc>0){
			echo "<tr><td colspan='6'><strong>MISC CHARGES</strong></td></tr>";
			}*/
			while($res69 = mysql_fetch_array($exec69))
		   {
			$miscbillingdate = $res69['consultationdate'];
			$miscbillingrefno = $res69['docno'];
			$miscbilling = $res69['description'];
			$miscbillingrate = $res69['rate'];
			$miscbillingamount = $res69['amount'];
			$miscbillingunit = $res69['units'];
		
			$totalmiscbillingamount = $totalmiscbillingamount + $miscbillingamount;
		   }
			?>
			<tr>
				<td class="bodytext31" colspan="4" valign="center"  align="left"><strong>MISC Charges: </strong></td>
				
								
				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($totalmiscbillingamount,2,'.',','); ?></td>
			</tr>
				
				<?php
				 $payoveralltotal=($totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalprivatedoctoramount+$totalambulanceamount+$totalhomecareamount+$totalmiscbillingamount+$theatreamt+$totalshelfamount); 
				?>			
			<tr>
			<td align="left" colspan="4"class="bodytext31" valign="middle"><strong>Copay Amount: :</strong></td>
			<td align="right" class="bodytext31" valign="middle" style=""><?php echo '0.00'; ?></td>
			</tr>
			
            
            
			<tr>
			<td align="left" colspan="4"class="bodytext31" valign="middle"><strong>Total Bill Amount: :</strong></td>
			<td align="right" class="bodytext31" valign="middle" style=""><?php echo number_format($payoveralltotal,2,'.',','); ?></td>
			</tr>
			
            
            <?php 
				
			$totalcreditamt = 0;
			$query644 = "select * from ip_creditnote where patientcode='$patientcode' and visitcode='$visitcode'";  
			$exec644 = mysql_query($query644) or die(mysql_error());
			$num_ipdiscount = mysql_num_rows($exec644);
			
			while($res644 = mysql_fetch_array($exec644))
		   {
			
			
			$creditamount = $res644['totalamount']; 
					
			$totalcreditamt = $totalcreditamt + $creditamount; 
		  } 
			?>
			<tr>
				<td class="bodytext31" colspan="4" valign="center"  align="left"> <strong>Total Credits</strong></td>
				
				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($totalcreditamt,2,'.',','); ?></td>
			</tr>
			
            
			<?php
			
			$totaldepositfinal=0;
			$totaldepositamount=0;
			$totaldepositrefundamount = 0;	
			$depositrefundamount=0;
			$totaldeposit=0;
			$tot=0;
			$query112 = "select * from master_transactionipdeposit where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysql_query($query112) or die(mysql_error());
			$num_receipt = mysql_num_rows($exec112);
			
			while($res112 = mysql_fetch_array($exec112))
			{
			$depositamount = $res112['transactionamount'];
			$depositamount1 = -$depositamount;
			$docno = $res112['docno'];
			$transactionmode = $res112['transactionmode'];
			$transactiondate = $res112['transactiondate'];
			$chequenumber = $res112['chequenumber'];
			$totaldepositamount = $totaldepositamount + $depositamount1;
			$tot=$tot+$depositamount; 
			}
			$query731 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec731 = mysql_query($query731) or die(mysql_error());
			$res731 = mysql_fetch_array($exec731);
			$depositbilltype = $res731['billtype'];
			
			$totaldiscountamount = 0;
			$query64 = "select * from ip_discount where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec64 = mysql_query($query64) or die(mysql_error());
			while($res64 = mysql_fetch_array($exec64))
		   {
			 $discountrate = $res64['rate'];
			 $discountrate = -$discountrate;
			 $totaldiscountamount = $totaldiscountamount + $discountrate;  
			   
		   }
			 
			$query1122 = "select * from deposit_refund where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec1122 = mysql_query($query1122) or die(mysql_error());
			$num_receipt1 = mysql_num_rows($exec1122);
			 while($res1122 = mysql_fetch_array($exec1122))
			{
			$depositrefundamount = $res1122['amount'];
			
			$totaldepositrefundamount = $totaldepositrefundamount + $depositrefundamount;
			 
			}
			
			$totaldeposit=$tot-$totaldepositrefundamount-$totaldiscountamount; 
			//$totaldepositfinal=-$totaldeposit; 
			
			//*****************advance deposit*******************
			$totaladvancedepositamount = 0;
			$query112 = "select * from master_transactionadvancedeposit where patientcode='$patientcode' and visitcode='$visitcode' and recordstatus='adjusted'";
			$exec112 = mysql_query($query112) or die(mysql_error());
			while($res112 = mysql_fetch_array($exec112))
			{
			$advancedepositamount = $res112['transactionamount'];
			$docno = $res112['docno'];
			$transactiondate = $res112['transactiondate'];
			
			$totaladvancedepositamount += $advancedepositamount;
			?>
			
			  
			  <?php 
			  }
			 
			$totalnhifamount = 0;
			$query641 = "select * from ip_nhifprocessing where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec641 = mysql_query($query641) or die(mysql_error());
			while($res641= mysql_fetch_array($exec641))
		   {
			$nhifdate = $res641['consultationdate'];
			$nhifrefno = $res641['docno'];
			$nhifqty = $res641['totaldays'];
			$nhifrate = $res641['nhifrebate'];
			$nhifclaim = $res641['nhifclaim'];
			$nhifclaim = -$nhifclaim;
			
			$totalnhifamount = $totalnhifamount + $nhifclaim;
		  }	
			
			//*****************advance deposit ends*******************
			$totaldeposit += $totaladvancedepositamount - $totalnhifamount;
			$totaldepositfinal=-$totaldeposit;
			
			?>
			<tr>
				<td class="bodytext31" colspan="4" valign="center"  align="left"><strong>Less Deposit and Payments received:</strong></td>
				
				<td class="bodytext31" colspan="1" valign="center"  align="right">-<?php echo number_format($totaldeposit,2,'.',','); ?></td>
			</tr>
			   
               <?php
			
			?>
			  
				
			
			
				
			  <?php 
			  
			  include('convert_currency_to_words.php');
			  $depositamount = 0;
			  $overalltotal=($totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalprivatedoctoramount+$totalambulanceamount+$totalhomecareamount+$totalcreditamt+$totalmiscbillingamount+$totaldepositfinal); 
			  $overalltotal = $overalltotal + $totalshelfamount;
			  $convertedwords = covert_currency_to_words($overalltotal);
			  $overalltotal=number_format($overalltotal,2,'.','');
			  $consultationtotal=$totalop; 
			   $consultationtotal=number_format($consultationtotal,2,'.','');
			   $netpay= $consultationtotal+$totallab+$totalpharm+$totalrad+$totalser; 
			   $netpay=number_format($netpay,2,'.','');
			  ?>
			<tr>
			<td colspan="6" class="bodytext31" align="right">&nbsp;</td>
		  </tr>
		<tr>
        	
        	<td colspan="4"  class="bodytext31" align="left"><strong>Amount Due :</strong></td>
			<td class="bodytext31" align="right"><strong><?php echo number_format($overalltotal,2,'.',','); ?></strong></td>
		</tr>
		
         <tr>
			<td colspan="6" class="bodytext31" align="right">&nbsp;<br /><br /><br /><br /></td>
		  </tr>


<tr >
<td  align="left" valign="left" bgcolor="#ffffff" class="bodytext31"  width="20%"> <b>Billing Clerk </b> 
      <br />
      <br />
      Signature ....................
     </td>
<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"  colspan="2"  width="32%">  
     </td>
<td align="left" valign="left"  colspan="2"  width="32%" 
	 bgcolor="#ffffff"><strong>Client</strong>
      <br />
      <br />
      Signature ....................    
     </td>
</tr>
<tr>
    <td>
    &nbsp;<br />
    </td>
</tr>



         </tbody>
</table>
</page>
<?php	

$content = ob_get_clean();

    // convert in PDF
    require_once('html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array(0, 0, 0, 0));
//      $html2pdf->setModeDebug();
//        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('Interim Summary Bill.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>
