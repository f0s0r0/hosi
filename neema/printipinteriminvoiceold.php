<?php
session_start();
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$updatetime = date('H:i:s');

ob_start();

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

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
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; 
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 12px; COLOR: #3b3b3c; 
}

.bodytexthead {FONT-WEIGHT: normal; FONT-SIZE: 15px; COLOR: #3b3b3c; 
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c;  text-decoration:none
}
.bodytext365 {FONT-WEIGHT: normal; FONT-SIZE: 14px; COLOR: #3b3b3c;  text-decoration:none
}
.bodytext366 {FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #3b3b3c;  text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; 
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; 
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; 
}
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #FFFFFF;
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C;  }
</style>
<table width="530" border="0" cellpadding="0" cellspacing="0" align="center" style="border-bottom:solid 1px #000000;">  
	<tr>
<?php 
$query2 = "select * from master_company where auto_number = '$companyanum'";
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
$cstnumber1 = $res2["cstnumber"];
?>

    <td width="100" rowspan="4" align="left" valign="center" 
	 bgcolor="#ffffff" class="bodytexthead">
	
	<?php
			$query3showlogo = "select * from settings_billhospital where companyanum = '$companyanum'";
			$exec3showlogo = mysql_query($query3showlogo) or die ("Error in Query3showlogo".mysql_error());
			$res3showlogo = mysql_fetch_array($exec3showlogo);
			$showlogo = $res3showlogo['showlogo'];
			if ($showlogo == 'SHOW LOGO')
			{
			?>
				
			<img src="logofiles/<?php echo $companyanum;?>.jpg" width="100" height="100" />
			
			<?php
			}
			?>	</td>
			
 
			<td colspan="4" class="bodytexthead"><div align="left"><?php echo $companyname; ?>
		      <?php
			$strlen3 = strlen($address1);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address1 = ' '.$address1.' ';
			}
			?>			
		    </div></td>
	  <td width="156" colspan="2" class="bodytexthead"><div align="right" style="font-size:18px;">INTERIM INVOICE</div></td>
  </tr>
		<tr>
			<td colspan="4" class="bodytexthead"><div align="left"><?php echo $address1; ?>
		      <?php
			$address2 = $area.''.$city.' '.$pincode.'';
			$strlen3 = strlen($address2);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address2 = ' '.$address2.' ';    
			}
			?>			
		    </div></td>
			<td colspan="2" class="bodytexthead"><div align="left">&nbsp;</div></td>
		</tr>
		<tr>
			<td colspan="4" class="bodytexthead">
			
			  <div align="left"><?php echo $address2; ?>
		        <?php
			$address3 = "PHONE: ".$phonenumber1.' '.$phonenumber2;
			$strlen3 = strlen($address3);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address3 = ' '.$address3.' ';
			}
			?>			
	        </div></td>
			<td colspan="2" class="bodytexthead"><div align="left">&nbsp;</div></td>
		</tr>

<tr>
<td colspan="6" style="">&nbsp;</td>
</tr>
<tr>
<td colspan="7" style="">&nbsp;</td>
</tr>
</table>

	<table width="530" align="center" border="0" cellspacing="0" cellpadding="2">
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
		
		$query13 = "select * from master_subtype where auto_number = '$subtypeanum'";
		$exec13 = mysql_query($query13) or die("Error in Query13".mysql_error());
		$res13 = mysql_fetch_array($exec13);
		$subtype = $res13['subtype'];
		
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
		 
		$query2 = "select * from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";
		$exec2 = mysql_query($query2) or die(mysql_error());
		$res2 = mysql_fetch_array($exec2);
		$admissiondate = $res2['recorddate'];
		$wardanum = $res2['ward'];
		
		$query12 = "select * from master_ward where auto_number = '$wardanum'";
		$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
		$res12 = mysql_fetch_array($exec12);
		$wardname = $res12['ward'];
		?>
		   <tr>
             <td width="76" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong> Patient Name</strong></td> 
		     <td width="217" align="left" valign="center" class="bodytext31"><?php echo $patientname; ?></td>
		     <td  width="16" align="center" valign="center" class="bodytext31">&nbsp;</td>
		     <td width="94" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Bill Date </strong></td> 
		     <td width="107"  align="left" valign="center" class="bodytext31"><?php echo  date("d/m/Y", strtotime($updatedate)); ?></td>
          </tr>
		  
	       <tr>
             <td width="76" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong> Reg. No. </strong></td>
	         <td width="217" align="left" valign="center" class="bodytext31"><?php echo $patientcode; ?></td>
	         <td width="16" align="left" valign="center" class="bodytext31">&nbsp;</td>
	         <td width="94"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Admission Date </strong></td> 
	         <td width="107"  align="left" valign="center" class="bodytext31"><?php echo  date("d/m/y", strtotime($admissiondate)); ?></td>
         </tr>
        <tr>
			<td width="76"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>IP Visit No. </strong></td>
			<td  align="left" valign="left" class="bodytext31"><?php echo $visitcode; ?></td>
			<td  align="center" valign="left" class="bodytext31">&nbsp;</td>
			<td  width="94"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Doctor :</strong></td>
			<td align="left" valign="center" class="bodytext31"><?php echo $consultingdoctor; ?></td>
		</tr>
		 <tr>
			<td width="76"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Ward : </strong></td>
			<td  align="left" valign="left" class="bodytext31"><?php echo $wardname; ?></td>
			<td  align="center" valign="left" class="bodytext31">&nbsp;</td>
			<td  width="94"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Account</strong></td>
			<td align="left" valign="center" class="bodytext31"><?php echo $accname; ?></td>
		</tr>
		 <tr>
			<td width="76"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>NHIF No : </strong></td>
			<td  align="left" valign="left" class="bodytext31"><?php echo $nhifid; ?></td>
			<td  align="center" valign="left" class="bodytext31">&nbsp;</td>
			<td  width="94"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Covered By :</strong></td>
			<td align="left" valign="center" class="bodytext31"><?php echo $subtype; ?></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid black;">&nbsp;</td>
			<td style="border-bottom:1px solid black;">&nbsp;</td>
			<td style="border-bottom:1px solid black;">&nbsp;</td>
			<td style="border-bottom:1px solid black;">&nbsp;</td>
			<td style="border-bottom:1px solid black;">&nbsp;</td>
		</tr>
	</table>	
	
		<table width="530" align="center" border="0" cellspacing="4" cellpadding="2">
			<tr>
			 	<td colspan="7">&nbsp;</td>
			</tr>
		
			<tr>
				<td width="24" class="bodytext31" valign="center"  align="left" 
				bgcolor="#ffffff"><strong>No.</strong></td>
				<td width="60"  align="left" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><strong>Date</strong></td>
				<td width="55"  align="left" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><strong>Ref.No</strong></td>
				<td width="120"  align="left" valign="center" style="white-space:normal"
				bgcolor="#ffffff" class="bodytext31"><strong>Description</strong></td>
				<td width="20"  align="center" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><strong>Qty</strong></td>
				<td width="70"  align="center" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><strong>Rate  </strong></td>
				<td width="70"  align="center" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><strong>Amount </strong></td>
			</tr>
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
                <td class="bodytext31" valign="center"  align="left"><?php echo number_format($consultationfee,2,'.',','); ?></td>
				 <td class="bodytext31" valign="center"  align="left"><?php echo $consultationfee; ?></td>
				
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
			    <td class="bodytext31" valign="center"  align="left"><?php echo date("m/d/y", strtotime($consultationdate)); ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $refno; ?></td>
			 <td class="bodytext31" valign="center"  align="left"><?php echo 'Admission Charge'; ?></td>
			     <td class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>
                <td class="bodytext31" valign="center"  align="right"><?php echo number_format($consultationfee,2,'.',','); ?></td>
				 <td class="bodytext31" valign="center"  align="right"><?php echo number_format($consultationfee,2,'.',','); ?></td>
				
           	</tr>
			<?php
			}
			?>
			<?php

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
		<tr>
			<td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			<td class="bodytext31" valign="center"  align="left"><?php echo  date("m/d/y", strtotime($packagedate1)); ?></td>
			<td class="bodytext31" valign="center"  align="left"><?php echo $visitcode; ?></td>
			<td class="bodytext31" valign="center"  align="left"><?php echo $packagename; ?></td>
			<td class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>
			<td class="bodytext31" valign="center"  align="right"><?php echo number_format($packageamount,2,'.',','); ?></td>
			<td class="bodytext31" valign="center"  align="right"><?php echo number_format($packageamount,2,'.',','); ?></td>
		</tr>
			  <?php
			  }
			  ?>
			<?php 
			$totalbedallocationamount = 0;
			
			 $requireddate = '';
			 $quantity = '';
			 $allocatenewquantity = '';
			$query18 = "select * from ip_bedallocation where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec18 = mysql_query($query18) or die ("Error in Query1".mysql_error());
			$res18 = mysql_fetch_array($exec18);
			$ward = $res18['ward'];
			$allocateward = $res18['ward'];
			
			$bed = $res18['bed'];
			$refno = $res18['docno'];
			$date = $res18['recorddate'];
			$bedallocateddate = $res18['recorddate'];
			$packagedate = $res18['recorddate'];
			$newdate = $res18['recorddate'];
			
			
			$query73 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec73 = mysql_query($query73) or die(mysql_error());
			$res73 = mysql_fetch_array($exec73);
			$packageanum = $res73['package'];
			
			
			$query74 = "select * from master_ippackage where auto_number='$packageanum'";
			$exec74 = mysql_query($query74) or die(mysql_error());
			$res74 = mysql_fetch_array($exec74);
			$packdays = $res74['days'];
			
		   $query51 = "select * from master_bed where auto_number='$bed'";
		   $exec51 = mysql_query($query51) or die(mysql_error());
		   $res51 = mysql_fetch_array($exec51);
		   $bedname = $res51['bed'];
		   $threshold = $res51['threshold'];
		   $thresholdvalue = $threshold/100;
		   
			$query91 = "select * from master_bedcharge where bedanum='$bed' and recordstatus =''";
			$exec91 = mysql_query($query91) or die(mysql_error());
			$num91 = mysql_num_rows($exec91);
			while($res91 = mysql_fetch_array($exec91))
		   {
		   $charge = $res91['charge'];
		   $rate = $res91['rate'];
		   
		   if($billtype == 'PAY LATER')
		   {
		   $thresholdamount = $rate * $thresholdvalue;
		   $rate = $rate + $thresholdamount;
		   }
		    $query181 = "select * from ip_bedtransfer where visitcode='$visitcode' and patientcode='$patientcode' order by auto_number asc limit 0,1";
			$exec181 = mysql_query($query181) or die ("Error in Query181".mysql_error());
			$num181 = mysql_num_rows($exec181);
			if($num181 > 0)
			{
			$query79 = "select * from ip_bedtransfer where visitcode='$visitcode' and patientcode='$patientcode' order by auto_number asc limit 0,1";
			$exec79 = mysql_query($query79) or die(mysql_error());
			$res79 = mysql_fetch_array($exec79);
			$date1 = $res79['recorddate'];
			$diff = abs(strtotime($date1) - strtotime($date));
			}
			else
			{		
		    $diff = abs(strtotime($date) - strtotime($updatedate));
			}
			$years = floor($diff / (365*60*60*24));
			$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
			$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
			
			$allocatedate = $date;
			$allocate1date = $date;
			
			
		
			if($days < $packdays)
			{
			
			$quantity = $days + 1;
			 
			}
			
					if($days > $packdays)
			{
			
			
		
			$days1 = $days - $packdays;
			
		
			if($packdays == 0)
			{
			   $query1281 = "select * from ip_bedtransfer where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec1281 = mysql_query($query1281) or die ("Error in Query1".mysql_error());
			$num1281 = mysql_num_rows($exec1281);
			if($num1281 > 0)
			{
			 $quantity = $days1;
			}
			else
			{
		   $quantity = $days1 + 1;
		   }
		   }
		   else
		   {
		   $query1281 = "select * from ip_bedtransfer where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec1281 = mysql_query($query1281) or die ("Error in Query1".mysql_error());
			$num1281 = mysql_num_rows($exec1281);
			if($num1281 > 0)
			{
			 $quantity = $days1;
			}
			else
			{
			$quantity = $days1 + 1;
			}
		  
		   }
		  
		   if($packageanum != 0)
		   {
		    	$reqdate = date('Y-m-d',strtotime($packagedate1) + (24*3600*$reqquantity));
			}
			else
			{
			$reqdate = $date;
			}
			
		   $amount = $quantity * $rate;
		   
		   $allocatequantiy = $quantity;
		   $allocatenewquantity = $quantity;
		   
		 
		   
		
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
			$totalbedallocationamount = $totalbedallocationamount + $amount;
			$totalquantity = $totalquantity + $quantity;
				 ?>
			 <tr>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo date("m/d/y", strtotime($reqdate)); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $refno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $charge; ?>(<?php echo $bedname; ?>)</div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $quantity; ?></div></td>
			         
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($rate,2,'.',','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
			  </tr>
			  <?php 
			 
			 }
			 
		
			 if($days == $packdays)
			 {
			 
			 if($packdays != 0)
			{
			 $days = $days - $packdays;
			
			if($days != 0)
			{
		   $quantity = $days + 1;
		  
		   
		   $amount = $quantity * $rate;
		   
		   $allocatequantiy = $quantity;
		   $allocatenewquantiy = $quantity;
		   
		
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
			$totalbedallocationamount = $totalbedallocationamount + $amount;
			$totalquantity = $totalquantity + $quantity;
				 ?>
			 <tr>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo date("m/d/y", strtotime($date)); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $refno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $charge; ?>(<?php echo $bedname; ?>)</div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $quantity; ?></div></td>
			 	        
       
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($rate,2,'.',','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
			  </tr>
			  <?php 
			 }
			 }
			 }
			 if($packdays == 0)
			 {
			 if($days == 0)
			 {
			
		   $quantity = $days + 1;
		   
		   $reqdate = $date;
		   
		   $amount = $quantity * $rate;
		   
		   $allocatequantiy = $quantity;
		    $allocatenewquantiy = $quantity;
		
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
			$totalbedallocationamount = $totalbedallocationamount + $amount;
			$totalquantity = $totalquantity + $quantity;
				 ?>
			 <tr>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo date("m/d/y", strtotime($date)); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $refno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $charge; ?>(<?php echo $bedname; ?>)</div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $quantity; ?></div></td>
			 	
         
       
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($rate,2,'.',','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
			  </tr>
			  <?php
			 }
			 }
			 }
			  ?>
		
			  <?php 
			  $snno =0;
			  $i = 0;
			  $j=0;
			 
			  $totalbedtransferamount = 0;
			  $diff5 = 0;
			  $newdate = '';
				
			 
			$query128 = "select * from ip_bedtransfer where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec128 = mysql_query($query128) or die ("Error in Query1".mysql_error());
			$num128 = mysql_num_rows($exec128);
			while($res128 = mysql_fetch_array($exec128))
			{
			$snno = $snno + 1;
			$j = $j + 1;
			
			$ward = $res128['ward'];
			$transfer1ward = $res128['ward'];
			$bed = $res128['bed'];
			$refno = $res128['docno'];
			$date = $res128['recorddate'];
			
			$newdate = $res128['recorddate'];
			$transferanum = $res128['auto_number'];
			
		    $datediff = abs(strtotime($bedallocateddate) - strtotime($date));
			$years5 = floor($datediff / (365*60*60*24));
			$months5 = floor(($datediff - $years5 * 365*60*60*24) / (30*60*60*24));
			$days5 = floor(($datediff - $years5 * 365*60*60*24 - $months5*30*60*60*24)/ (60*60*24));
			
			$newpackdays = $packdays - $days5;
			if($newpackdays > 0)
			{
		    $date = date('Y-m-d',strtotime($date) + (24*3600*$newpackdays));
			}
		
			
			   $query512 = "select * from master_bed where auto_number='$bed'";
			   $exec512 = mysql_query($query512) or die(mysql_error());
			   $res512 = mysql_fetch_array($exec512);
			   $bedname = $res512['bed'];
			   $threshold = $res512['threshold'];
			   $thresholdvalue = $threshold/100;
			   
			$query912 = "select * from master_bedcharge where bedanum='$bed' and recordstatus =''";
			$exec912 = mysql_query($query912) or die(mysql_error());
			$num912 = mysql_num_rows($exec912);
			while($res912 = mysql_fetch_array($exec912))
		    {
			$i = $i + 1;
		    $charge = $res912['charge'];
		    $rate = $res912['rate'];
		   
		  	 if($billtype == 'PAY LATER')
		   {
		   $thresholdamount = $rate * $thresholdvalue;
		   $rate = $rate + $thresholdamount;
		   }
			$query66 = "select * from ip_bedtransfer where visitcode='$visitcode' and patientcode='$patientcode' and auto_number > '$transferanum' order by auto_number asc limit 0,1";
			$exec66 = mysql_query($query66) or die(mysql_error());
			$res66 = mysql_fetch_array($exec66);
			$date1 = $res66['recorddate'];
			$transferdate = $res66['recorddate'];
		   $diff = abs(strtotime($date1) - strtotime($date));
			
			if($num128 == $snno)
			{
			$query81 = "select * from ip_discharge where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec81 = mysql_query($query81) or die(mysql_error());
			$num81 = mysql_num_rows($exec81);
			if($num81 > 0)
			{
			$res81 = mysql_fetch_array($exec81);
			$date1 = $res81['recorddate'];
			
			$diff = abs(strtotime($date1) - strtotime($date));
		
			}else
			{
		 	$diff = abs(strtotime($updatedate) - strtotime($date));
			
			}
			}
			
			$years = floor($diff / (365*60*60*24));
			$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
		    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
			
			$query811 = "select * from ip_discharge where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec811 = mysql_query($query811) or die(mysql_error());
			$num811 = mysql_num_rows($exec811);
		
			if($num811 > 0)
			{
			$res811 = mysql_fetch_array($exec811);
			$date12 = $res811['recorddate'];
				if($packageanum1 != 0)
			{
			$diff5 = abs(strtotime($date12) - strtotime($packagedate));
			}
			}
			else
			{
					if($packageanum1 != 0)
			{
		    $diff5 = abs(strtotime($updatedate) - strtotime($packagedate));
			}
			}
			$years5 = floor($diff5 / (365*60*60*24));
			$months5 = floor(($diff5 - $years5 * 365*60*60*24) / (30*60*60*24));
		    $days5 = floor(($diff5 - $years5 * 365*60*60*24 - $months5*30*60*60*24)/ (60*60*24));
			if($packageanum1 != 0)
			{
			if($days5 >= $packdays)
			{
			
			if($allocateward == $ward)
			{
			if($allocatedate != '')
			{
				if($allocatedate == $allocate1date)
			{
			
			if($quantity != '')
			{
			 $quantity = $quantity - 1;
			
			 }
			
			 if($packageanum1 != 0)
			 {
			 $quantity = $quantity + $packdays;
			 }
			 $transdate = date('Y-m-d',strtotime($allocatedate) + (24*3600*$quantity));
			 }
			 else
			 {
			 $transdate = date('Y-m-d',strtotime($allocatedate) + (24*3600*$quantity));
			 }
			 }
			
		
			
			$query812 = "select * from ip_discharge where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec812 = mysql_query($query812) or die(mysql_error());
			$num812 = mysql_num_rows($exec812);
			if($num812 > 0)
			{
			$res812 = mysql_fetch_array($exec812);
			$date12 = $res812['recorddate'];
			
			if($date12 == $transferdate)
			{
			$days = $days - 1;
			}
		
			}else
			{
		 	if($updatedate == $transferdate)
			{
			$days = $days - 1;
			}
			
			}
				
			}
			if($j > 1)
			{
			
			if($allocateward != $ward)
			{
			$quantity = $days + 1;
			}
			else
			{
			$quantity = $days;
			}
			}
			else
			{
		 $quantity = $days + 1;
		 }
		  
		   if($quantity != 0)
		   {
		   if($i == 1)
		   {
		   
		     $reqdate = date('Y-m-d',strtotime($reqdate) + (24*3600*$allocatenewquantity));
		    }
			if($allocateward != $ward)
				{
				$reqdate = $newdate;
				}
		   $amount = $quantity * $rate;
		   $totalbedtransferamount = $totalbedtransferamount + $amount;
		   
		   $totalquantity = $totalquantity + $quantity;
		
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
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo date("m/d/y", strtotime($reqdate)); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $refno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $charge; ?>(<?php echo $bedname; ?>)</div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $quantity; ?></div></td>
			  	  
     
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($rate,2,'.',','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
			  </tr>
			  <?php 
			
			  }
			  $allocatedate = '';
			 }
			 }
			 
			
			if($packageanum1 == 0)
			{
			
			if($i == 1)
		   {
		   if($reqdate == $date )
		   {
		   $reqdate2 = $date;
		   }
		   else
		   {
	    $reqdate2 = date('Y-m-d',strtotime($reqdate) + (24*3600*$allocatenewquantity) - 1);
		}
		  
		if( $reqdate2 == $date)
		{
		$reqdate = $date;
		}
		else
		{
			$reqdate = date('Y-m-d',strtotime($reqdate) + (24*3600*$quantity));
			}
			}
			
			 if($days5 == 0)
			 {
			 if($allocateward == $ward)
			{
			
			if($allocatedate != '')
			{
			if($allocatedate == $allocate1date)
			{
			 $quantity = $quantity - 1;
			 $transdate = date('Y-m-d',strtotime($allocatedate) + (24*3600*$quantity));
			 }
			 else
			 {
			 $transdate = date('Y-m-d',strtotime($allocatedate) + (24*3600*$quantity));
			 if($transdate > $updatedate)
			 {
			 $transdate = $updatedate;
			 }
			 }
			 }
			
		if($transdate == $newdate)
		{
		 $days = $days - 1;
		}
		}
		
		
		  $quantity = $days + 1;
		  
		   
		   if($quantity != 0)
		   {
		  
		
		   $amount = $quantity * $rate;
		   $totalbedtransferamount = $totalbedtransferamount + $amount;
		   
		   $totalquantity = $totalquantity + $quantity;
		
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
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo date("m/d/y", strtotime($date)); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $refno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $charge; ?>(<?php echo $bedname; ?>)</div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $quantity; ?></div></td>
			 	  	  
  
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($rate,2,'.',','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
			  </tr>
			  <?php 
			
			  }
			  $allocatedate = '';
			 }
			}
			 }
		 $reqdate = date('Y-m-d',strtotime($reqdate) + (24*3600*$quantity));
		 
		 if($reqdate > $updatedate)
		 {
		 $reqdate = $updatedate;
		
		 }
		
			$allocatedate = $newdate;
			$allocateward = $ward;
			 }
			  ?>
			 
			   <?php 
			$totalpharm=0;
			
			$query23 = "select * from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' group by itemcode";
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
			$query33 = "select * from pharmacysales_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode'";
			$exec33 = mysql_query($query33) or die ("Error in Query1".mysql_error());
		    while($res33 = mysql_fetch_array($exec33))
			{
			$quantity=$res33['quantity'];
			$phaquantity=$phaquantity+$quantity;
			$amount=$res33['totalamount'];
			$phaamount=$phaamount+$amount;
			}
			
			$query331 = "select * from pharmacysalesreturn_details where visitcode='$visitcode' and patientcode='$patientcode' and itemcode='$phaitemcode'";
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
			<td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			  <td class="bodytext31" valign="center"  align="left"><?php echo  date("m/d/y", strtotime($phadate)); ?></td>
			 <td class="bodytext31" valign="center"  align="left"><?php echo $refno; ?></td>
			 <td class="bodytext31" valign="center"  align="left"><?php echo $phaname; ?></td>
			 <input name="medicinename[]" type="hidden" id="medicinename" size="25" value="<?php echo $phaname; ?>">
			 <input name="quantity[]" type="hidden" id="quantity" size="8" readonly value="<?php echo $resquantity; ?>">
			 <input name="rate[]" type="hidden" id="rate" readonly size="8" value="<?php echo $pharate; ?>">
			 <input name="amount[]" type="hidden" id="amount" readonly size="8" value="<?php echo $resamount; ?>">
			 <td class="bodytext31" valign="center"  align="right"><?php echo $resquantity; ?></td>
             <td class="bodytext31" valign="center"  align="right"><?php echo number_format($pharate,2,'.',','); ?></td>
			 <td class="bodytext31" valign="center"  align="right"><?php echo $resamount; ?></td>
		     
		</tr>	
			
			  
			  <?php }
			  }
			  }
			  ?>
			  <?php 
			  $totallab=0;
			  $query19 = "select * from ipconsultation_lab where patientvisitcode='$visitcode' and patientcode='$patientcode' and labitemname <> '' and labrefund <> 'refund'";
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
			
			
			$totallab=$totallab+$labrate;
			?>
		<tr>
			<td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			<td class="bodytext31" valign="center"  align="left"><?php echo  date("m/d/y", strtotime($labdate)); ?></td>
			<td class="bodytext31" valign="center"  align="left"><?php echo $labrefno; ?></td>
			<input name="lab[]" id="lab" size="69" type="hidden" value="<?php echo $labname; ?>">
			<input name="rate5[]" id="rate5" readonly size="8" type="hidden" value="<?php echo $labrate; ?>">
			<input name="labcode[]" id="labcode" readonly size="8" type="hidden" value="<?php echo $labcode; ?>">
			<td class="bodytext31" valign="center"  align="left"><?php echo $labname; ?></td>
			<td class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>
			<td class="bodytext31" valign="center"  align="right"><?php echo number_format($labrate,2,'.',','); ?></td>
			<td class="bodytext31" valign="center"  align="right"><?php echo number_format($labrate,2,'.',','); ?></td>
		</tr>	
			  
			  <?php 
			  }
			  }
			  ?>
			  
			    <?php 
				$totalrad=0;
			  $query20 = "select * from ipconsultation_radiology where patientvisitcode='$visitcode' and patientcode='$patientcode' and radiologyitemname <> '' and radiologyrefund <> 'refund'";
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
			
		
			
			$totalrad=$totalrad+$radrate;
			?>
		<tr>
			<td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			<td class="bodytext31" valign="center"  align="left"><?php echo  date("m/d/y", strtotime($raddate)); ?></td>
			<td class="bodytext31" valign="center"  align="left"><?php echo $radref; ?></td>
			<td class="bodytext31" valign="center"  align="left"><?php echo $radname; ?></td>
			
			<input name="radiology[]" id="radiology" type="hidden" size="69" autocomplete="off" value="<?php echo $radname; ?>">
			<input name="rate8[]" type="hidden" id="rate8" readonly size="8" value="<?php echo $radrate; ?>">
			<td class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>
			<td class="bodytext31" valign="center"  align="right"><?php echo number_format($radrate,2,'.',','); ?></td>
			<td class="bodytext31" valign="center"  align="right"><?php echo number_format($radrate,2,'.',','); ?></td>
		</tr>	
			  
			  <?php 
			  }
			  }
			  ?>
			  	    <?php 
					
					$totalser=0;
		    $query21 = "select * from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> '' and servicerefund <> 'refund' group by servicesitemname";
			$exec21 = mysql_query($query21) or die ("Error in Query1".mysql_error());
			while($res21 = mysql_fetch_array($exec21))
			{
			$serdate=$res21['consultationdate'];
			$sername=$res21['servicesitemname'];
			$serrate=$res21['servicesitemrate'];
			$serref=$res21['iptestdocno'];
			$servicesfree = $res21['freestatus'];
			$sercode=$res21['servicesitemcode'];
			$query2111 = "select * from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' and servicerefund <> 'refund'";
			$exec2111 = mysql_query($query2111) or die ("Error in Query2111".mysql_error());
			$numrow2111 = mysql_num_rows($exec2111);
			if($servicesfree == 'No')
			{
			$totserrate=$serrate*$numrow2111;
	
			$totalser=$totalser+$totserrate;
			?>
			<tr>
				<td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo  date("m/d/y", strtotime($serdate)); ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $serref; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $sername; ?></td>
				<input name="services[]" type="hidden" id="services" size="69" value="<?php echo $sername; ?>">
				<input name="rate3[]" type="hidden" id="rate3" readonly size="8" value="<?php echo $serrate; ?>">
				<td class="bodytext31" valign="center"  align="right"><?php echo $numrow2111; ?></td>
				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($serrate,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($totserrate,2,'.',','); ?></td>
			</tr>	
			  
			  <?php }
			  }
			  ?>
			<?php
			$totalotbillingamount = 0;
			$query61 = "select * from ip_otbilling where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec61 = mysql_query($query61) or die(mysql_error());
			while($res61 = mysql_fetch_array($exec61))
		   {
			$otbillingdate = $res61['consultationdate'];
			$otbillingrefno = $res61['docno'];
			$otbillingname = $res61['surgeryname'];
			$otbillingrate = $res61['rate'];
			
			$totalotbillingamount = $totalotbillingamount + $otbillingrate;
			?>
		<tr>
			<td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
			<td class="bodytext31" valign="center"  align="left"><?php echo  date("m/d/y", strtotime($otbillingdate)); ?></td>
			<td class="bodytext31" valign="center"  align="left"><?php echo $otbillingrefno; ?></td>
			<td class="bodytext31" valign="center"  align="left"><?php echo $otbillingname; ?></td>
			<input name="surgeryname[]" type="hidden" id="surgeryname" size="69" value="<?php echo $otbillingname; ?>">
			<input name="surgeryrate[]" type="hidden" id="surgeryrate" readonly size="8" value="<?php echo $otbillingrate; ?>">
			<td class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>
			<td class="bodytext31" valign="center"  align="right"><?php echo number_format($otbillingrate,2,'.',','); ?></td>
			<td class="bodytext31" valign="center"  align="right"><?php echo number_format($otbillingrate,2,'.',','); ?></td>
		</tr>
				<?php
				}
				?>
				<?php
			$totalprivatedoctoramount = 0;
			$query62 = "select * from ipprivate_doctor where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec62 = mysql_query($query62) or die(mysql_error());
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
				<td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo  date("m/d/y", strtotime($privatedoctordate)); ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $privatedoctorrefno; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $privatedoctor.' '.$description; ?></td>
				<input name="doctorname[]" type="hidden" id="doctorname" size="69" value="<?php echo $privatedoctor; ?>">
				<input name="doctorrate[]" type="hidden" id="doctorrate" readonly size="8" value="<?php echo $privatedoctorrate; ?>">
				<td class="bodytext31" valign="center"  align="right"><?php echo $privatedoctorunit; ?></td>
				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($privatedoctorrate,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($privatedoctoramount,2,'.',','); ?></td>
			</tr>
				<?php
				}
				?>
				<?php
			$totalambulanceamount = 0;
			$query63 = "select * from ip_ambulance where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec63 = mysql_query($query63) or die(mysql_error());
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
				<td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo  date("m/d/y", strtotime($ambulancedate)); ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $ambulancerefno; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $ambulance; ?></td>
				<input name="doctorname[]" type="hidden" id="doctorname" size="69" value="<?php echo $ambulance; ?>">
				<input name="doctorrate[]" type="hidden" id="doctorrate" readonly size="8" value="<?php echo $ambulancerate; ?>">
				<td class="bodytext31" valign="center"  align="right"><?php echo $ambulanceunit; ?></td>
				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($ambulancerate,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($ambulanceamount,2,'.',','); ?></td>
			</tr>
				<?php
				}
				?>
				<?php
			$totalmiscbillingamount = 0;
			$query69 = "select * from ipmisc_billing where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec69 = mysql_query($query69) or die(mysql_error());
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
				<td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo  date("m/d/y", strtotime($miscbillingdate)); ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $miscbillingrefno; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $miscbilling; ?></td>
				<input name="doctorname[]" type="hidden" id="doctorname" size="69" value="<?php echo $miscbilling; ?>">
				<input name="doctorrate[]" type="hidden" id="doctorrate" readonly size="8" value="<?php echo $miscbillingrate; ?>">
				<td class="bodytext31" valign="center"  align="right"><?php echo $miscbillingunit; ?></td>
				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($miscbillingrate,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($miscbillingamount,2,'.',','); ?></td>
			</tr>
				<?php
				}
				?>
				<?php
				 $payoveralltotal=($totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalprivatedoctoramount+$totalambulanceamount+$totalmiscbillingamount);
				?>			
			<tr>
			<td colspan="7" align="left" class="bodytext31" valign="middle" style="border-top:solid 1px #000000;"></td>
			</tr>
			<tr>
			<td colspan="3" align="left" class="bodytext31" valign="middle">&nbsp;</td>
			<td align="left" class="bodytext31" valign="middle"><strong>INVOICE TOTAL AMOUNT :</strong></td>
			<td colspan="2" align="left" class="bodytext31" valign="middle">&nbsp;</td>
			<td align="right" class="bodytext31" valign="middle" style=""><strong><?php echo number_format($payoveralltotal,2,'.',','); ?></strong></td>
			</tr>
			<tr>
			<td colspan="7" align="left" class="bodytext31" valign="middle" style="">&nbsp;</td>
			</tr>
			<tr>
			<td colspan="3" align="left" class="bodytext31" valign="middle">&nbsp;</td>
			<td align="left" class="bodytext31" valign="middle"><strong>RECEIPTS</strong></td>
			<td colspan="3" align="right" class="bodytext31" valign="middle"><strong>&nbsp;</strong></td>
			</tr>
				
			<?php
			$totaldepositamount = 0;
			$query112 = "select * from master_transactionipdeposit where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysql_query($query112) or die(mysql_error());
			while($res112 = mysql_fetch_array($exec112))
			{
			$depositamount = $res112['transactionamount'];
			$depositamount1 = -$depositamount;
			$docno = $res112['docno'];
			$transactionmode = $res112['transactionmode'];
			$transactiondate = $res112['transactiondate'];
			$chequenumber = $res112['chequenumber'];
			
			$query731 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec731 = mysql_query($query731) or die(mysql_error());
			$res731 = mysql_fetch_array($exec731);
			$depositbilltype = $res731['billtype'];
		
		
			$totaldepositamount = $totaldepositamount + $depositamount1;
			?>
			<tr>
				<td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo  date("m/d/y", strtotime($transactiondate)); ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $docno; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo 'Deposit'; ?>&nbsp;&nbsp;<?php echo $transactionmode; ?>
				<?php
				if($transactionmode == 'CHEQUE')
				{
				echo $chequenumber;
				}
				?></td>
				<td class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>
				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($depositamount,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right">-<?php echo number_format($depositamount,2,'.',','); ?></td>
			</tr>
			    
			  
			  <?php }
				  
			  ?>
			  <?php
			$totaldepositrefundamount = 0;
			$query112 = "select * from deposit_refund where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysql_query($query112) or die(mysql_error());
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
				 <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
				 <td class="bodytext31" valign="center"  align="left"><?php echo date("m/d/y", strtotime($transactiondate)); ?></td>
				 <td class="bodytext31" valign="center"  align="left"><?php echo $docno; ?></td>
				 <td class="bodytext31" valign="center"  align="left"><?php echo 'Deposit Refund'; ?></td>
				 <td class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>
				 <td class="bodytext31" valign="center"  align="right"><?php echo number_format($depositrefundamount,2,'.',','); ?></td>
				 <td class="bodytext31" valign="center"  align="right"><?php echo number_format($depositrefundamount,2,'.',','); ?></td>
				 </tr>
			  <?php 
			  }
			  ?>
			  
						<?php
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
			?>
			<tr>
				<td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo  date("m/d/y", strtotime($nhifdate)); ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $nhifrefno; ?></td>
				<td class="bodytext31" valign="center"  align="left"> <?php echo 'NHIF'; ?></td>
				<td class="bodytext31" valign="center"  align="right"><?php echo $nhifqty; ?></td>
				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($nhifrate,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($nhifclaim,2,'.',','); ?></td>
			</tr>
				<?php
				}
				?>
			  <tr>
			<td colspan="7" align="left" class="bodytext31" valign="middle" style="">&nbsp;</td>
			</tr>
			<tr>
			<td colspan="3" align="left" class="bodytext31" valign="middle">&nbsp;</td>
			<td align="left" class="bodytext31" valign="middle"><strong>CREDITS</strong></td>
			<td colspan="3" align="right" class="bodytext31" valign="middle"><strong>&nbsp;</strong></td>
			</tr>
				<?php
			$totaldiscountamount = 0;
			$query64 = "select * from ip_discount where patientcode='$patientcode' and patientvisitcode='$visitcode'";
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
		
			$totaldiscountamount = $totaldiscountamount + $discountrate;
			?>
			<tr>
				<td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo  date("m/d/y", strtotime($discountdate)); ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $discountrefno; ?></td>
				<td class="bodytext31" valign="center"  align="left">Discount On <?php echo $discount; ?> by <?php echo $authorizedby; ?></td>
				<input name="doctorname[]" type="hidden" id="doctorname" size="69" value="<?php echo $discount; ?>">
				<input name="doctorrate[]" type="hidden" id="doctorrate" readonly size="8" value="<?php echo $discountrate; ?>">
				<td class="bodytext31" valign="center"  align="right"><?php echo '1'; ?></td>
				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($discountrate1,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($discountrate,2,'.',','); ?></td>
			</tr>
				<?php
				}
				?>
						
			  <?php 
			  $depositamount = 0;
			  $overalltotal=($totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalprivatedoctoramount+$totalambulanceamount+$totaldiscountamount+$totalmiscbillingamount+$totaldepositamount+$totalnhifamount+$totaldepositrefundamount);
			  $overalltotal=number_format($overalltotal,2,'.','');
			  $consultationtotal=$totalop;
			   $consultationtotal=number_format($consultationtotal,2,'.','');
			   $netpay= $consultationtotal+$totallab+$totalpharm+$totalrad+$totalser;
			   $netpay=number_format($netpay,2,'.','');
			  ?>
			<tr>
			<td colspan="7" align="left" class="bodytext31" valign="middle" style="border-top:solid 1px #000000;"></td>
			</tr>
			<tr>  
			<td colspan="6" class="bodytext31" align="right"><strong>Balance :</strong></td>
			<td class="bodytext31" align="right"><strong><?php echo number_format($overalltotal,2,'.',','); ?></strong></td>
		</tr>
		<tr>
			<td colspan="7" align="left" class="bodytext31" valign="middle" style="border-top:solid 1px #000000;"></td>
			</tr>
         <tr>
			<td colspan="7" class="bodytext31" align="right">&nbsp;</td>
		  </tr>
         <tr>
			<td colspan="7" class="bodytext31" align="center"><strong>This is an Interim Invoice only not final invoice.</strong></td>
		 </tr>
</table>
<?php	
require_once("dompdf/dompdf_config.inc.php");
$html =ob_get_clean();
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper("A4");
$dompdf->render();
$canvas = $dompdf->get_canvas();
//$canvas->line(10,800,800,800,array(0,0,0),1);
$font = Font_Metrics::get_font("times-roman", "normal");
$canvas->page_text(272, 814, "Page {PAGE_NUM}/{PAGE_COUNT}", $font, 10, array(0,0,0));
$dompdf->stream("IpInterim.pdf", array("Attachment" => 0)); 
?>
