<?php
session_start();
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
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
$colorloopcount = '';
$sno = '';
			
ob_start();

	$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname ";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	$res1 = mysql_fetch_array($exec1);
	
 	$locationname = $res1["locationname"];
	$locationcode = $res1["locationcode"];
	
		$query3 = "select * from master_location where locationcode = '$locationcode'";
		$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
		$res3 = mysql_fetch_array($exec3);
		//$companyname = $res2["companyname"];
		$address1 = $res3["address1"];
		$address2 = $res3["address2"];
//		$area = $res2["area"];
//		$city = $res2["city"];
//		$pincode = $res2["pincode"];
		$emailid1 = $res3["email"];
		$phonenumber1 = $res3["phone"];
		$locationcode = $res3["locationcode"];
//		$phonenumber2 = $res2["phonenumber2"];
//		$tinnumber1 = $res2["tinnumber"];
//		$cstnumber1 = $res2["cstnumber"];
		$locationname =  $res3["locationname"];
		$prefix = $res3["prefix"];
		$suffix = $res3["suffix"];

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{
   
 

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
}

?>

<?php
if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if(isset($_REQUEST['billnumber'])) { $billnumbers = $_REQUEST["billnumber"]; } else { $billnumbers = ""; }
include("print_header.php");
?>

<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; 
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 12px; COLOR: #000000; 
}


.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000;  text-decoration:none
}
.bodytext365 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3b3b3c;  text-decoration:none
}
.bodytext366 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #3b3b3c;  text-decoration:none
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 15px; COLOR: #000000; 
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; 
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
	background-color: #E0E0E0;
}
</style>

    <table width="100%" border="" cellspacing="0" cellpadding="2" align="center">
        <?php
            
		$query1 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		
		$res1 = mysql_fetch_array($exec1);
		
		$patientname=$res1['patientfullname'];
		$patientcode=$res1['patientcode'];
		$accountname = $res1['accountname'];
		$billtype = $res1['billtype'];
		$gender = $res1['gender'];
		$age = $res1['age'];
		
		$subtypeanum = $res1['subtype'];
		$type = $res1['type'];
		
		$query13 = "select * from master_subtype where  auto_number = '$subtypeanum'";
		$exec13 = mysql_query($query13) or die("Error in Query13".mysql_error());
		$res13 = mysql_fetch_array($exec13);
		$subtype = $res13['subtype'];
		//$fxrate=$res13['fxrate'];
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
		
		$query2 = "select * from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";
		$exec2 = mysql_query($query2) or die(mysql_error());
		$res2 = mysql_fetch_array($exec2);
		$admissiondate = $res2['recorddate'];
			?>
		<tr>
		  <td colspan="5" align="left" valign="center" 
			bgcolor="#ffffff" class="bodytext32">&nbsp;</td>
	    </tr>
		<tr>
		 <td width="" align="left" valign="center" 
			bgcolor="#ffffff"><strong>Patient Name</strong></td>
			<td align="left" valign="center" ><strong><?php echo $patientname; ?></strong></td>
            <td>&nbsp;</td>
		  <td width=""  align="left" valign="center" 
			bgcolor="#ffffff" ><strong>Bill Date </strong></td>
		  <td width="90"  align="left" valign="center" 
			bgcolor="#ffffff" ><strong><?php echo  date("d/m/Y", strtotime($updatedate)); ?></strong></td>
		</tr>
		
		<tr>
			<td width="" align="left" valign="center" ><strong>Reg. No</strong></td>
			<td   align="left" valign="center" ><strong><?php echo $patientcode; ?></strong></td>
            <td>&nbsp;</td>
			<td  align="left" valign="center" ><strong>Admission Date</strong></td>
			<td  align="left" valign="center" ><strong><?php echo  date("d/m/y", strtotime($admissiondate)); ?></strong></td>
		</tr>
		<tr>
			<td width="" align="left" valign="center"><strong>IP Visit No</strong></td>
			<td  align="left" valign="center"><strong><?php echo $visitcode; ?></strong></td>
            <td>&nbsp;</td>
			<td  align="left" valign="center"><strong>Bill Number </strong></td>
			<td  align="left" valign="center"  ><strong><?php echo $billnumbers; ?></strong></td>
		</tr>
		<tr>
          <td colspan="5" style="border-bottom:1px solid black;">&nbsp;</td>
	    </tr>
	   
	    <tr>
	      <td colspan="5" align="left" valign="center" class="bodytext321">
		    <table cellspacing="0" cellpadding="2" width="100%" 
            align="left" border="0" >
          
              <tr>
                <td colspan="7" class="bodytext31"><strong>Transaction Details</strong></td>
			 </tr>
          
              <tr>
                <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
                <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
                <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
                <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
                <td  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
                <td  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
                <td  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
              </tr>
              <tr>
			 
              <td width="29" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
				<td width="76"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Date</strong></td>
				<td width="47"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Ref.No</strong></td>
					<td width="320"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Description</strong></td>
                <td width="33"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Qty</strong></td>
				<td width="77"  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Rate  </strong></td>
					<td width="86"  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Amount </strong></td>
              </tr>
				  		<?php
			$colorloopcount = '';
			$sno = '';
			$totalamount=0;
			$totalquantity = 0;
			$totalop =0;
			$query17 = "select * from master_ipvisitentry where  visitcode='$visitcode' and patientcode='$patientcode'";
			$exec17 = mysql_query($query17) or die ("Error in Query1".mysql_error());
			$res17 = mysql_fetch_array($exec17);
			$consultationfee=$res17['admissionfees'];
			$consultationfee = number_format($consultationfee,2,'.','');
			$viscode=$res17['visitcode'];
			$consultationdate=$res17['consultationdate'];
			$packchargeapply = $res17['packchargeapply'];
			$packageanum1 = $res17['package'];
			
			$query53 = "select * from ip_bedallocation where  visitcode='$visitcode' and patientcode='$patientcode'";
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
			  <tr>
			 <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			    <td class="bodytext31" valign="center"  align="left"><?php echo $consultationdate; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $refno; ?></td>
			 <td class="bodytext31" valign="center"  align="left"><?php echo 'Admission Charge'; ?></td>
			     <td class="bodytext31" valign="center"  align="left"><?php echo '1'; ?></td>
				 		  	 <input type="hidden" name="admissionchargerate[]" id="admissionchargerate" value="<?php echo $consultationfee; ?>">
			 <input type="hidden" name="admissionchargeamount[]" id="admissionchargeamount" value="<?php echo $consultationfee; ?>">
		
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
			  <tr>
			 <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			    <td class="bodytext31" valign="center"  align="left"><?php echo $consultationdate; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $refno; ?></td>
			 <td class="bodytext31" valign="center"  align="left"><?php echo 'Admission Charge'; ?></td>
			     <td class="bodytext31" valign="center"  align="left"><?php echo '1'; ?></td>
				 		  	 <input type="hidden" name="admissionchargerate[]" id="admissionchargerate" value="<?php echo $consultationfee; ?>">
			 <input type="hidden" name="admissionchargeamount[]" id="admissionchargeamount" value="<?php echo $consultationfee; ?>">
	
                <td class="bodytext31" valign="center"  align="right"><?php echo number_format($consultationfee,2,'.',','); ?></td>
				 <td class="bodytext31" valign="center"  align="right"><?php echo $consultationfee; ?></td>
           	</tr>
			<?php
			}
			
			?>
					  <?php
					  $packageamount = 0;
			 $query731 = "select * from master_ipvisitentry where  visitcode='$visitcode' and patientcode='$patientcode'";
			$exec731 = mysql_query($query731) or die(mysql_error());
			$res731 = mysql_fetch_array($exec731);
			$packageanum1 = $res731['package'];
			$packagedate1 = $res731['consultationdate'];
			$packageamount = $res731['packagecharge'];
			
			$query741 = "select * from master_ippackage where  auto_number='$packageanum1'";
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
			  ?>
			   <tr>
			 <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			    <td class="bodytext31" valign="center"  align="left"><?php echo $packagedate1; ?></td>
			 <td class="bodytext31" valign="center"  align="left"><?php echo $visitcode; ?></td>
			 <td class="bodytext31" valign="center"  align="left"><?php echo $packagename; ?></td>
			 <td class="bodytext31" valign="center"  align="left"><?php echo '1'; ?></td>
			 	 <input type="hidden" name="description[]" id="description" value="<?php echo $packagename; ?>">
			 <input type="hidden" name="descriptionrate[]" id="descriptionrate" value="<?php echo $packageamount; ?>">
			 <input type="hidden" name="descriptionamount[]" id="descriptionamount" value="<?php echo $packageamount; ?>">
			 <input type="hidden" name="descriptionquantity[]" id="descriptionquantity" value="<?php echo '1'; ?>">
			  <input type="hidden" name="descriptiondocno[]" id="descriptiondocno" value="<?php echo $visitcode; ?>">
    
               <td class="bodytext31" valign="center"  align="right"><?php echo number_format($packageamount,2,'.',','); ?></td>
			  <td class="bodytext31" valign="center"  align="right"><?php echo number_format($packageamount,2,'.',','); ?></td>
			  </tr>
			  <?php
			  }
			  ?>
			<?php 
			$totalbedallocationamount = 0;
		 
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
							if($type=='hospital'||$charge!='RMO Charges')
							{
								$colorloopcount = $sno + 1;
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
								
								
					  ?>
					   <?php if($rowbedtr == 0) { $totalbedallocationamount=$totalbedallocationamount+$amount; ?>
								<tr>
									<td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
									<td class="bodytext31" valign="center"  align="left"><?php echo $bedallocateddate; ?></td>
									<td class="bodytext31" valign="center"  align="left"><?php echo $refno; ?></td>
									<td class="bodytext31" valign="center"  align="left"><?php echo $charge; ?>(<?php echo $bedname; ?>)</td>
									<td class="bodytext31" valign="center"  align="left"><?php echo $quantity; ?></td>
									<td class="bodytext31" valign="center"  align="right"><?php echo number_format($rate,2,'.',','); ?></td>
									<td class="bodytext31" valign="center"  align="right"><?php echo number_format($amount,2,'.',','); ?></td>
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
								if($type=='hospital'||$charge!='RMO Charges')
								{
									$colorloopcount = $sno + 1;
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
									$totalbedtransferamount=$totalbedtransferamount+$amount;
						  ?>
									<tr>
										<td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
										<td class="bodytext31" valign="center"  align="left"><?php echo $date; ?></td>
										<td class="bodytext31" valign="center"  align="left"><?php echo $refno; ?></td>
										<td class="bodytext31" valign="center"  align="left"><?php echo $charge; ?>(<?php echo $bedname; ?>)</td>
										<td class="bodytext31" valign="center"  align="left"><?php echo $quantity; ?></td>
										<td class="bodytext31" valign="center"  align="right"><?php echo number_format($rate,2,'.',','); ?></td>
										<td class="bodytext31" valign="center"  align="right"><?php echo number_format($amount,2,'.',','); ?></td>
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
			$totalpharm=0;

			 
			$query23 = "select * from pharmacysales_details where  visitcode='$visitcode' and patientcode='$patientcode' group by itemcode";
			$exec23 = mysql_query($query23) or die ("Error in Query1".mysql_error());
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
			$query33 = "select * from pharmacysales_details where  visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode'";
			$exec33 = mysql_query($query33) or die ("Error in Query1".mysql_error());
		    while($res33 = mysql_fetch_array($exec33))
			{
			$quantity=$res33['quantity'];
			$phaquantity=$phaquantity+$quantity;
			$amount=$res33['totalamount'];
			$phaamount=$phaamount+$amount;
			}
			
			$query331 = "select * from pharmacysalesreturn_details where  visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode'";
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
			$totalpharm=$totalpharm+$resamount;
			?>
			 <tr>
			 <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			  <td class="bodytext31" valign="center"  align="left"><?php echo $phadate; ?></td>
			 <td class="bodytext31" valign="center"  align="left"><?php echo $refno; ?></td>
			 <td class="bodytext31" valign="center"  align="left"><?php echo $phaname; ?></td>
			 <input name="medicinename[]" type="hidden" id="medicinename" size="25" value="<?php echo $phaname; ?>">
			 <input name="quantity[]" type="hidden" id="quantity" size="8" readonly value="<?php echo $resquantity; ?>">
			 <input name="rate[]" type="hidden" id="rate" readonly size="8" value="<?php echo $pharate; ?>">
			 <input name="amount[]" type="hidden" id="amount" readonly size="8" value="<?php echo $resamount; ?>">
			 <td class="bodytext31" valign="center"  align="left"><?php echo $resquantity; ?></td>
             <td class="bodytext31" valign="center"  align="right"><?php echo number_format($pharate,2,'.',','); ?></td>
			 <td class="bodytext31" valign="center"  align="right"><?php echo $resamount; ?></td>
		     </tr>
			  
			  <?php }
			  }
			  }
			  ?>
			  <?php 
			  $totallab=0;
			  $query19 = "select * from ipconsultation_lab where  patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemname <> '' and labrefund <> 'refund'";
			$exec19 = mysql_query($query19) or die ("Error in Query1".mysql_error());
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
			$totallab=$totallab+$labrate;
			?>
			 <tr>
			 <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			  <td class="bodytext31" valign="center"  align="left"><?php echo $labdate; ?></td>
			 <td class="bodytext31" valign="center"  align="left"><?php echo $labrefno; ?></td>
			 <input name="lab[]" id="lab" size="69" type="hidden" value="<?php echo $labname; ?>">
			 <input name="rate5[]" id="rate5" readonly size="8" type="hidden" value="<?php echo $labrate; ?>">
			 <input name="labcode[]" id="labcode" readonly size="8" type="hidden" value="<?php echo $labcode; ?>">
			 <td class="bodytext31" valign="center"  align="left"><?php echo $labname; ?></td>
			 <td class="bodytext31" valign="center"  align="left"><?php echo '1'; ?></td>
             <td class="bodytext31" valign="center"  align="right"><?php echo number_format($labrate,2,'.',','); ?></td>
			 <td class="bodytext31" valign="center"  align="right"><?php echo number_format($labrate,2,'.',','); ?></td>
		      </tr> 
			  
			  <?php }
			  }
			  ?>
			  
			    <?php 
				$totalrad=0;
			  $query20 = "select * from ipconsultation_radiology where  patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemname <> '' and radiologyrefund <> 'refund'";
			$exec20 = mysql_query($query20) or die ("Error in Query1".mysql_error());
			while($res20 = mysql_fetch_array($exec20))
			{
			$raddate=$res20['consultationdate'];
			$radname=$res20['radiologyitemname'];
			$radrate=$res20['radiologyitemrate'];
			$radref=$res20['iptestdocno'];
			$radiologyfree = $res20['freestatus'];
			
			if($radiologyfree == 'No')
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
			$totalrad=$totalrad+$radrate;
			?>
			 <tr>
			 <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			  <td class="bodytext31" valign="center"  align="left"><?php echo $raddate; ?></td>
			 <td class="bodytext31" valign="center"  align="left"><?php echo $radref; ?></td>
			 <td class="bodytext31" valign="center"  align="left"><?php echo $radname; ?></td>

			 <input name="radiology[]" id="radiology" type="hidden" size="69" autocomplete="off" value="<?php echo $radname; ?>">
			 <input name="rate8[]" type="hidden" id="rate8" readonly size="8" value="<?php echo $radrate; ?>">
			 <td class="bodytext31" valign="center"  align="left"><?php echo '1'; ?></td>
             <td class="bodytext31" valign="center"  align="right"><?php echo number_format($radrate,2,'.',','); ?></td>
			 <td class="bodytext31" valign="center"  align="right"><?php echo number_format($radrate,2,'.',','); ?></td>
			  </tr>  
			  
			  <?php }
			  }
			  ?>
				  	    <?php 
					
					$totalser=0;
		    $query21 = "select * from ipconsultation_services where  patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> '' and servicerefund <> 'refund' group by servicesitemname";
			$exec21 = mysql_query($query21) or die ("Error in Query1".mysql_error());
			while($res21 = mysql_fetch_array($exec21))
			{
			$serdate=$res21['consultationdate'];
			$sername=$res21['servicesitemname'];
			$serrate=$res21['servicesitemrate'];
			$serref=$res21['iptestdocno'];
			$servicesfree = $res21['freestatus'];
			$sercode=$res21['servicesitemcode'];
			$query2111 = "select * from ipconsultation_services where  patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' and servicerefund <> 'refund' and iptestdocno = '$serref'";
			$exec2111 = mysql_query($query2111) or die ("Error in Query2111".mysql_error());
			$numrow2111 = mysql_num_rows($exec2111);
			if($servicesfree == 'No')
			{			
			$totserrate=$serrate*$numrow2111;
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
			$totalser=$totalser+$totserrate;
			?>
			 <tr>
			 <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			  <td class="bodytext31" valign="center"  align="left"><?php echo $serdate; ?></td>
			 <td class="bodytext31" valign="center"  align="left"><?php echo $serref; ?></td>
			 <td class="bodytext31" valign="center"  align="left"><?php echo $sername; ?></td>
			 <input name="services[]" type="hidden" id="services" size="69" value="<?php echo $sername; ?>">
			 <input name="rate3[]" type="hidden" id="rate3" readonly size="8" value="<?php echo $serrate; ?>">
			 <td class="bodytext31" valign="center"  align="left"><?php echo $numrow2111; ?></td>
             <td class="bodytext31" valign="center"  align="right"><?php echo number_format($serrate,2,'.',','); ?></td>
			 <td class="bodytext31" valign="center"  align="right"><?php echo number_format($totserrate,2,'.',','); ?></td>
			  </tr>   
			  
			  <?php }
			  }
			  ?>
			<?php
			$totalotbillingamount = 0;
			$query61 = "select * from ip_otbilling where  patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec61 = mysql_query($query61) or die(mysql_error());
			while($res61 = mysql_fetch_array($exec61))
		   {
			$otbillingdate = $res61['consultationdate'];
			$otbillingrefno = $res61['docno'];
			$otbillingname = $res61['surgeryname'];
			$otbillingrate = $res61['rate'];
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
			$totalotbillingamount = $totalotbillingamount + $otbillingrate;
			?>
			 <tr>
			 <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			  <td class="bodytext31" valign="center"  align="left"><?php echo $otbillingdate; ?></td>
			 <td class="bodytext31" valign="center"  align="left"><?php echo $otbillingrefno; ?></td>
			 <td class="bodytext31" valign="center"  align="left"><?php echo $otbillingname; ?></td>
		  		 <input type="hidden" name="otbilling[]" id="otbilling" value="<?php echo $otbillingname; ?>">
			 	 <input type="hidden" name="otbillingrate[]" id="otbillingrate" value="<?php echo $otbillingrate; ?>">
			 <input type="hidden" name="otbillingamount[]" id="otbillingamount" value="<?php echo $otbillingrate; ?>">
			 <td class="bodytext31" valign="center"  align="left"><?php echo '1'; ?></td>
             <td class="bodytext31" valign="center"  align="right"><?php echo number_format($otbillingrate,2,'.',','); ?></td>
			 <td class="bodytext31" valign="center"  align="right"><?php echo number_format($otbillingrate,2,'.',','); ?></td>
		      </tr>
				<?php
				}
				?>
				<?php
			$totalprivatedoctoramount = 0;
			$query62 = "select * from ipprivate_doctor where  patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec62 = mysql_query($query62) or die(mysql_error());
			while($res62 = mysql_fetch_array($exec62))
		   {
			$privatedoctordate = $res62['consultationdate'];
			$privatedoctorrefno = $res62['docno'];
			$privatedoctor = $res62['doctorname'];
			$privatedoctorrate = $res62['rate'];
			$privatedoctoramount = $res62['amount'];
			$privatedoctorunit = $res62['units'];
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
			$totalprivatedoctoramount = $totalprivatedoctoramount + $privatedoctoramount;
			?>
			 <tr >
			 <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			  <td class="bodytext31" valign="center"  align="left"><?php echo $privatedoctordate; ?></td>
			 <td class="bodytext31" valign="center"  align="left"><?php echo $privatedoctorrefno; ?></td>
			 <td class="bodytext31" valign="center"  align="left"><?php echo $privatedoctor; ?></td>
				 		 <input type="hidden" name="privatedoctor[]" id="privatedoctor" value="<?php echo $privatedoctor; ?>">
			 	 <input type="hidden" name="privatedoctorrate[]" id="privatedoctorrate" value="<?php echo $privatedoctorrate; ?>">
			 <input type="hidden" name="privatedoctoramount[]" id="privatedoctoramount" value="<?php echo $privatedoctoramount; ?>">
			 <input type="hidden" name="privatedoctorquantity[]" id="privatedoctorquantity" value="<?php echo $privatedoctorunit; ?>">
	 <td class="bodytext31" valign="center"  align="left"><?php echo $privatedoctorunit; ?></td>
             <td class="bodytext31" valign="center"  align="right"><?php echo number_format($privatedoctorrate,2,'.',','); ?></td>
			 <td class="bodytext31" valign="center"  align="right"><?php echo number_format($privatedoctoramount,2,'.',','); ?></td>
		      </tr>
				<?php
				}
				?>
				<?php
			$totalambulanceamount = 0;
			$query63 = "select * from ip_ambulance where  patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec63 = mysql_query($query63) or die(mysql_error());
			while($res63 = mysql_fetch_array($exec63))
		   {
			$ambulancedate = $res63['consultationdate'];
			$ambulancerefno = $res63['docno'];
			$ambulance = $res63['description'];
			$ambulancerate = $res63['rate'];
			$ambulanceamount = $res63['amount'];
			$ambulanceunit = $res63['units'];
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
			$totalambulanceamount = $totalambulanceamount + $ambulanceamount;
			?>
			 <tr>
			 <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			  <td class="bodytext31" valign="center"  align="left"><?php echo $ambulancedate; ?></td>
			 <td class="bodytext31" valign="center"  align="left"><?php echo $ambulancerefno; ?></td>
			 <td class="bodytext31" valign="center"  align="left"><?php echo $ambulance; ?></td>
			 <input type="hidden" name="ambulance[]" id="ambulance" value="<?php echo $ambulance; ?>">
			 	 <input type="hidden" name="ambulancerate[]" id="ambulancerate" value="<?php echo $ambulancerate; ?>">
			 <input type="hidden" name="ambulanceamount[]" id="ambulanceamount" value="<?php echo $ambulanceamount; ?>">
			 <input type="hidden" name="ambulancequantity[]" id="ambulancequantity" value="<?php echo $ambulanceunit; ?>">
			 <td class="bodytext31" valign="center"  align="left"><?php echo $ambulanceunit; ?></td>
             <td class="bodytext31" valign="center"  align="right"><?php echo number_format($ambulancerate,2,'.',','); ?></td>
			 <td class="bodytext31" valign="center"  align="right"><?php echo number_format($ambulanceamount,2,'.',','); ?></td>
		      </tr>
				<?php
				}
				?>
				<?php
			$totalmiscbillingamount = 0;
			$query69 = "select * from ipmisc_billing where  patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec69 = mysql_query($query69) or die(mysql_error());
			while($res69 = mysql_fetch_array($exec69))
		   {
			$miscbillingdate = $res69['consultationdate'];
			$miscbillingrefno = $res69['docno'];
			$miscbilling = $res69['description'];
			$miscbillingrate = $res69['rate'];
			$miscbillingamount = $res69['amount'];
			$miscbillingunit = $res69['units'];
			
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
			$totalmiscbillingamount = $totalmiscbillingamount + $miscbillingamount;
			?>
			 <tr >
			 <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			  <td class="bodytext31" valign="center"  align="left"><?php echo $miscbillingdate; ?></td>
			 <td class="bodytext31" valign="center"  align="left"><?php echo $miscbillingrefno; ?></td>
			 <td class="bodytext31" valign="center"  align="left"><?php echo $miscbilling; ?></td>
				  <input type="hidden" name="miscbilling[]" id="miscbilling" value="<?php echo $miscbilling; ?>">
			 	 <input type="hidden" name="miscbillingrate[]" id="miscbillingrate" value="<?php echo $miscbillingrate; ?>">
			 <input type="hidden" name="miscbillingamount[]" id="miscbillingamount" value="<?php echo $miscbillingamount; ?>">
			 <input type="hidden" name="miscbillingquantity[]" id="miscbillingquantity" value="<?php echo $miscbillingunit; ?>">
		 <td class="bodytext31" valign="center"  align="left"><?php echo $miscbillingunit; ?></td>
             <td class="bodytext31" valign="center"  align="right"><?php echo number_format($miscbillingrate,2,'.',','); ?></td>
			 <td class="bodytext31" valign="center"  align="right"><?php echo number_format($miscbillingamount,2,'.',','); ?></td>
		      </tr>
				<?php
				}
				?>
				<?php
			$totaldiscountamount = 0;
			$query64 = "select * from ip_discount where  patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec64 = mysql_query($query64) or die(mysql_error());
			while($res64 = mysql_fetch_array($exec64))
		   {
			$discountdate = $res64['consultationdate'];
			$discountrefno = $res64['docno'];
			$discount= $res64['description'];
			$discountrate = $res64['rate'];
			$discountrate1 = $discountrate;
			$discountrate = -$discountrate;
			$authorizedby = $res64['authorizedby'];
			
						
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
			$totaldiscountamount = $totaldiscountamount + $discountrate;
			?>
			 <tr >
			 <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			  <td class="bodytext31" valign="center"  align="left"><?php echo $discountdate; ?></td>
			 <td class="bodytext31" valign="center"  align="left"><?php echo $discountrefno; ?></td>
			 <td class="bodytext31" valign="center"  align="left">Discount On <?php echo $discount; ?> by <?php echo $authorizedby; ?></td>
			 <input name="doctorname[]" type="hidden" id="doctorname" size="69" value="<?php echo $discount; ?>">
			 <input name="doctorrate[]" type="hidden" id="doctorrate" readonly size="8" value="<?php echo $discountrate; ?>">
			 <td class="bodytext31" valign="center"  align="left"><?php echo '1'; ?></td>
             <td class="bodytext31" valign="center"  align="right"><?php echo number_format($discountrate1,2,'.',','); ?></td>
			 <td class="bodytext31" valign="center"  align="right"><?php echo number_format($discountrate,2,'.',','); ?></td>
		      </tr>
				<?php
				}
				?>
						<?php
			$totalnhifamount = 0;
			$query641 = "select * from ip_nhifprocessing where  patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec641 = mysql_query($query641) or die(mysql_error());
			while($res641= mysql_fetch_array($exec641))
		   {
			$nhifdate = $res641['consultationdate'];
			$nhifrefno = $res641['docno'];
			$nhifqty = $res641['totaldays'];
			$nhifrate = $res641['nhifrebate'];
			$nhifclaim = $res641['nhifclaim'];
			$nhifclaim = -$nhifclaim;
			
						
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
			$totalnhifamount = $totalnhifamount + $nhifclaim;
			?>
			 <tr >
			 <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			  <td class="bodytext31" valign="center"  align="left"><?php echo $nhifdate; ?></td>
			 <td class="bodytext31" valign="center"  align="left"><?php echo $nhifrefno; ?></td>
			 <td class="bodytext31" valign="center"  align="left"> <?php echo 'NHIF'; ?></td>
			 	 	 <input type="hidden" name="nhifrate[]" id="nhifrate" value="<?php echo $nhifrate; ?>">
			 <input type="hidden" name="nhifamount[]" id="nhifamount" value="<?php echo $nhifclaim; ?>">
			 <input type="hidden" name="nhifquantity[]" id="nhifquantity" value="<?php echo $nhifqty; ?>">
	
				 <td class="bodytext31" valign="center"  align="left"><?php echo $nhifqty; ?></td>
             <td class="bodytext31" valign="center"  align="right"><?php echo number_format($nhifrate,2,'.',','); ?></td>
			 <td class="bodytext31" valign="center"  align="right"><?php echo number_format($nhifclaim,2,'.',','); ?></td>
		      </tr>
				<?php
				}
				?>
			<?php
			$totaldepositamount = 0;
			$query112 = "select * from master_transactionipdeposit where  patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysql_query($query112) or die(mysql_error());
			while($res112 = mysql_fetch_array($exec112))
			{
			$depositamount = $res112['transactionamount'];
			$depositamount1 = -$depositamount;
			$docno = $res112['docno'];
			$transactionmode = $res112['transactionmode'];
			$transactiondate = $res112['transactiondate'];
			$chequenumber = $res112['chequenumber'];
			
			$query731 = "select * from master_ipvisitentry where  visitcode='$visitcode' and patientcode='$patientcode'";
			$exec731 = mysql_query($query731) or die(mysql_error());
			$res731 = mysql_fetch_array($exec731);
			$depositbilltype = $res731['billtype'];
		
			
			
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
			$totaldepositamount = $totaldepositamount + $depositamount1;
			?>
			 <tr >
			 <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			  <td class="bodytext31" valign="center"  align="left"><?php echo $transactiondate; ?></td>
			 <td class="bodytext31" valign="center"  align="left"><?php echo $docno; ?></td>
			 <td class="bodytext31" valign="center"  align="left"><?php echo 'Deposit'; ?>&nbsp;&nbsp;<?php echo $transactionmode; ?>
			 <?php
			 if($transactionmode == 'CHEQUE')
			 {
			 echo $chequenumber;
			 }
			 ?></td>
			 <td class="bodytext31" valign="center"  align="left"><?php echo '1'; ?></td>
             <td class="bodytext31" valign="center"  align="right"><?php echo number_format($depositamount,2,'.',','); ?></td>
			 <td class="bodytext31" valign="center"  align="right">-<?php echo number_format($depositamount,2,'.',','); ?></td>
		      </tr>
			  
			  <?php }
			  
			  ?>
			  <?php 
			  $depositamount = 0;
			  $overalltotal=($totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalprivatedoctoramount+$totalambulanceamount+$totaldiscountamount+$totalmiscbillingamount+$totaldepositamount+$totalnhifamount);
			  $overalltotal=number_format($overalltotal,2,'.','');
			    $totalrevenue = $totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalprivatedoctoramount+$totalambulanceamount+$totalmiscbillingamount;
			  $consultationtotal=$totalop;
			   $consultationtotal=number_format($consultationtotal,2,'.','');
			   $netpay= $consultationtotal+$totallab+$totalpharm+$totalrad+$totalser;
			   $netpay=number_format($netpay,2,'.','');
			   $positivetotaldiscountamount = -($totaldiscountamount);
			   $positivetotaldepositamount = -($totaldepositamount);
			   $positivetotalnhifamount = -($totalnhifamount);
			  ?>
	          <tr>
	            <td colspan="7" class="bodytext31" align="right">&nbsp;</td>
              </tr>
	          <tr>
	<td colspan="7" class="bodytext31" align="right"><strong> Grand Total&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($overalltotal,2,'.',','); ?></strong></td>
	</tr>
	   
	<tr>
	<?php  $overalltotal = round($overalltotal); ?>
	<td colspan="7" class="bodytext31" align="right"><strong> Net Payable&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($overalltotal,2,'.',','); ?></strong></td>
	</tr>
        </table>		  </td>
        </tr>
	    <tr>
	      <td colspan="5" align="left" valign="center" bordercolor="#f3f3f3" class="bodytext31">&nbsp;</td>
        </tr>
	    <tr>
		<td colspan="5" align="left" valign="center" bordercolor="#f3f3f3" class="bodytext31"><strong>Receivable Accounts:</strong></td>
	   </tr>
	   <tr>
	     <td colspan="5" align="left" valign="center" bordercolor="#f3f3f3" class="bodytext31">&nbsp;</td>
       </tr>
		   <?php
			$query41="select * from master_transactionipcreditapproved where  transactiontype='finalize' and patientcode='$patientcode' and visitcode='$visitcode' and billnumber='$billnumbers' ";
		   $exec41 = mysql_query($query41) or die(mysql_error());
			while($res41=mysql_fetch_array($exec41))
			{
			$postingaccount = $res41['postingaccount'];
			$transactionamount = $res41['transactionamount'];
			
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

			//if ($balanceamount != 0.00)
			//{
			?>
			<tr>
				<td colspan="2" class="bodytext31" valign="center" bordercolor="#f3f3f3"  align="right"><strong><?php echo $postingaccount; ?></strong></td>
				<td width="65" align="right" valign="center" bordercolor="#f3f3f3" class="bodytext31"><?php echo number_format($transactionamount,2,'.',','); ?></td>
				<td align="right" valign="right"  colspan="2" bordercolor="#f3f3f3" class="bodytext31">&nbsp;</td>
			</tr>
			<tr>
			  <td colspan="2" class="bodytext31" valign="center" bordercolor="#f3f3f3" align="right">&nbsp;</td>
			  <td align="right" valign="center" bordercolor="#f3f3f3" class="bodytext31">&nbsp;</td>
			  <td width="303" align="right" valign="right" colspan="2" bordercolor="#f3f3f3" class="bodytext31">&nbsp;</td>
	    </tr>
			<tr>
			  <td colspan="2" class="bodytext31" valign="center" bordercolor="#f3f3f3" align="right">&nbsp;</td>
			  <td align="right" valign="center" bordercolor="#f3f3f3" class="bodytext31">&nbsp;</td>
			  <td align="right"  valign="right" bordercolor="#f3f3f3" class="bodytext31" colspan="2">&nbsp;</td>
	    </tr>
			<?php 
		   } 

		   ?>
</table>

<?php

    $content = ob_get_clean();

    // convert in PDF
    require_once('html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
//      $html2pdf->setModeDebug();
        //$html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('printcreditapproval.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>

	
