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
		
		$query13 = "select subtype,bedtemplate,labtemplate,radtemplate,sertemplate from master_subtype where auto_number = '$subtypeanum'";
		$exec13 = mysql_query($query13) or die("Error in Query13".mysql_error());
		$res13 = mysql_fetch_array($exec13);
		$subtype = $res13['subtype'];
	//	$fxrate=$res13['fxrate'];
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
		
		 $query511 = "select bed from `$bedtable` where auto_number='$bed'";
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
    
<!--<page_footer>
 <hr class="style8" />
  <div class="page_footer" >
                   <h4>"WE CARE, GOD HEALS"</h4>
 </div>
    </page_footer>-->
	
		<table width="100%" align="center" border="0" cellspacing="4" cellpadding="2">

        <tr><td colspan="7">
        <?php 
		$k=0;
		while($k<10){
		 ?>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php
			$k++;
		} ?>
        </td></tr>
		   <tr>
             <td  width="20%"  align="left" valign="top" bgcolor="#ffffff" class="bodytext31"><strong>Name : </strong></td> 
		     <td  align="left" valign="top" class="bodytext31"><?php echo $patientname; ?></td>
             <td>&nbsp; </td>
             <td>&nbsp; </td>
             <td>&nbsp; </td>
		     <td align="left" valign="top" bgcolor="#ffffff" class="bodytext31"><strong>Bill Date : </strong></td> 
		     <td align="left" valign="top" class="bodytext31"><?php echo  date("m/d/y", strtotime($currentdate)); ?></td>
          </tr>
		  
	       <tr>
             <td   width="20%" align="left" valign="top" bgcolor="#ffffff" class="bodytext31"><strong>Reg. No. : </strong></td>
	         <td align="left" colspan="4"  valign="top" class="bodytext31"><?php echo $patientcode; ?></td>
	         <td  align="left" valign="top" bgcolor="#ffffff" class="bodytext31"><strong>IP Visit No. : </strong></td>
			<td align="auto" valign="left" class="bodytext31"><?php echo $visitcode; ?></td>

         </tr>
          <tr>
             <td  width="20%" align="left" valign="top" bgcolor="#ffffff" class="bodytext31"><strong>Bill Type : </strong></td>
	         <td align="left" colspan="4"  valign="top" class="bodytext31"><?php echo $billtype; ?></td>
	         <td  align="left" valign="top" bgcolor="#ffffff" class="bodytext31"><strong>Admission Date : </strong></td> 
	         <td  align="left" valign="top" class="bodytext31"><?php echo  date("m/d/y", strtotime($admissiondate)); ?></td>
         </tr>
        <tr>
			<td   width="20%"  align="left"  valign="top" bgcolor="#ffffff" class="bodytext31"><strong>Account : </strong></td>
			<td align="left" colspan="4"  valign="top"  class="bodytext31"><?php echo $accname; ?></td>
		  	<td align="left" valign="top" bgcolor="#ffffff" class="bodytext31"><strong>No of Days : </strong></td>
			<td align="left" valign="left" class="bodytext31"><?php echo $nbOfDays; ?></td>
			<!--<td  width=""  align="left" valign="top" bgcolor="#ffffff" class="bodytext31"><strong>Doctor :</strong></td>
			<td align="" valign="top" class="bodytext31"><?php //echo $consultingdoctor; ?></td>-->
          </tr>
		
		 <tr>
         	<td   width="20%"  align="left"  valign="top" bgcolor="#ffffff" class="bodytext31"><strong>Catagory : </strong></td>
			<td align="left" colspan="4"   valign="top"  class="bodytext31"><?php echo $subtype; ?></td>
           <td align="left" valign="top" bgcolor="#ffffff" class="bodytext31"><strong>Type : </strong></td>
			<td align="left" valign="left" class="bodytext31"><?php echo $type; ?></td>
          </tr>
          <tr>
           <td   width="20%"  align="left"  valign="top" bgcolor="#ffffff" class="bodytext31"><strong>Membership No:</strong></td>
			<td align="left"  colspan="4"  valign="top"  class="bodytext31"><?php echo $mrdno; ?></td>
         	<td  align="left" valign="top"  bgcolor="#ffffff" class="bodytext31"><strong>Bed: </strong></td>
			<td align="left" valign="top"  class="bodytext31"><?php echo $bedname1;?></td>
		</tr>
         
           <tr>
           <td colspan="5" ></td>
         	<td    align="left" valign="top" bgcolor="#ffffff" class="bodytext31"><strong>Diagnostic Code 1:</strong></td>
			<td align="left"  valign="top"  class="bodytext31"><?php echo $diagnostic; ?></td>
           
          </tr>
           <tr>
           <td colspan="5" ></td>
         	<td    align="left"  valign="top" bgcolor="#ffffff" class="bodytext31"><strong>Diagnostic Code 2:</strong></td>
			<td align="left"  valign="top"  class="bodytext31"><?php echo $diagnostic1; ?></td>
           
          </tr>
          <tr>
               <td  align="center" colspan="7" valign="left"  class="bodytext31">&nbsp;</td>
               
          </tr>
</table>
		<table width="100%" align="center" border="0" cellspacing="4" cellpadding="2">

			<tr>
			 	<td colspan="7"><hr /></td>
			</tr>

			<tr>
			 	<td colspan="7"   align="center"><strong>INTERIM INVOICE</strong></td>
			</tr>
			<tr>
			 	<td colspan="7"><hr /></td>
			</tr>
		
			<tr>
				<td  width="" class="bodytext31" valign="top"  align="center" 
				bgcolor="#ffffff"><strong>No.</strong></td>
				<td width=""  align="center" valign="top" 
				bgcolor="#ffffff" class="bodytext31"><strong>Date</strong></td>
				<td width=""  align="left" valign="top" 
				bgcolor="#ffffff" class="bodytext31"><strong>Ref.No</strong></td>
				<td width=""  align="left" valign="top" style="white-space:normal"
				bgcolor="#ffffff" class="bodytext31"><strong>Description</strong></td>
				<td width="50"  align="center" valign="top" 
				bgcolor="#ffffff" class="bodytext31"><strong>Qty</strong></td>
				<td width=""  align="right" valign="top" 
				bgcolor="#ffffff" class="bodytext31"><strong>Rate  </strong></td>
				<td width=""  align="right" valign="top" 
				bgcolor="#ffffff" class="bodytext31"><strong>Amount </strong></td>
			</tr>
				  				  		<?php
			$colorloopcount = '';
			$sno = '';
			$totalamount=0;
			$totalquantity = 0;
			$totalop =0;
			$totalcopay = 0;
			$query17 = "select * from master_ipvisitentry where visitcode='$visitcode' and patientcode='$patientcode'";
			$exec17 = mysql_query($query17) or die ("Error in Query1".mysql_error());
			$res17 = mysql_fetch_array($exec17);
			$consultationfee=$res17['admissionfees'];
			$packageanum1 = $res17['package'];
			$consultationfee = number_format($consultationfee,2,'.','');
			$viscode=$res17['visitcode'];
			$consultationdate=$res17['consultationdate'];
			$packchargeapply = $res17['packchargeapply'];
			$type=$res17['type'];
			$discharge=$res17['discharge'];
			$accountnum = $res17['accountname'];
			
			$querycop = "select lab_copay,admission_copay,radiology_copay,service_copay,pharmacy_copay,bed_copay,nursing_copay,rmo_copay,package_copay,misc_copay,ambulance_copay,mortuary_copay from master_copayaccount where accountnameano='$accountnum' and recordstatus <>'DELETED'";
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
			$admission_copay = $rescop["admission_copay"];
			$copayyes = $lab_copay+$radiology_copay+$service_copay+$pharmacy_copay+$bed_copay+$nursing_copay+$rmo_copay+$package_copay+$misc_copay+$ambulance_copay+$mortuary_copay;
			
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

$admissionratecopay=0;
 $bcopay = $admission_copay;
if($bcopay > 0){
 $admissionratecopay = $consultationfee * ($bcopay / 100); } else {
$admissionratecopay = 0; 
}
$consultationfee = $consultationfee - $admissionratecopay;
$totalcopay = $totalcopay + $admissionratecopay;



			?>
			  <tr>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
				<td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $refno; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="left"><?php echo 'Admission Charge'; ?></div></td>
			     <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo '1'; ?></div></td>
                <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($consultationfee,2,'.',','); ?></div></td>
				 <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($consultationfee,2,'.',','); ?></div></td>
           	</tr>

<?php if($bcopay > 0) { ?>
			  <tr>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
				<td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $refno; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="left"><?php echo 'Admission Charge  Copay'; ?></div></td>
			     <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo '1'; ?></div></td>
                <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($admissionratecopay,2,'.',','); ?></div></td>
				 <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($admissionratecopay,2,'.',','); ?></div></td>
           	</tr>

			<?php
}
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

$admissionratecopay=0;
 $bcopay = $admission_copay;
if($bcopay > 0){
 $admissionratecopay = $consultationfee * ($bcopay / 100); } else {
$admissionratecopay = 0; 
}
$consultationfee = $consultationfee - $admissionratecopay;
$totalcopay = $totalcopay + $admissionratecopay;


			?>
			  <tr>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
				<td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $refno; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="left"><?php echo 'Admission Charge'; ?></div></td>
			     <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo '1'; ?></div></td>
                <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($consultationfee,2,'.',','); ?></div></td>
				 <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($consultationfee,2,'.',','); ?></div></td>
           	</tr>

<?php if($bcopay > 0) { ?>
			  <tr>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
				<td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $refno; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="left"><?php echo 'Admission Charge  Copay'; ?></div></td>
			     <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo '1'; ?></div></td>
                <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($admissionratecopay,2,'.',','); ?></div></td>
				 <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($admissionratecopay,2,'.',','); ?></div></td>
           	</tr>
			<?php
			}
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
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $packagedate1; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $visitcode; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="left"><?php echo $packagename; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo '1'; ?></div></td>
               <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($packageamount,2,'.',','); ?></div></td>
			  <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($packageamount,2,'.',','); ?></div></td>
			  </tr>
			  <?php
			  }
			  ?>
              
			  <?php
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
						if($quantity>=0)
						{
							if($type=='hospital'||$charge!='Resident Doctor Charges')
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
								
								if($charge == 'Bed Charges')
								{
									$bcopay = $bed_copay;
								}
								else if($charge == 'Nursing Charges')
								{
									$bcopay = $nursing_copay;
								}
								else if($charge == 'RMO Charges')
								{
									$bcopay = $rmo_copay;
								}
								else
								{
									$bcopay = 0;
								}
								if($bcopay > 0){
								$bedratecopay = $rate * ($bcopay / 100); } else {
								$bedratecopay = 0; }
								$bedrate = $rate - $bedratecopay;
								
								$totalcopay = $totalcopay + ($bedratecopay*$quantity);
					  ?>
					   <?php if($rowbedtr == 0) { $totalbedallocationamount=$totalbedallocationamount+$amount; ?>
								<tr>
									<td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
									<td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $bedallocateddate; ?></div></td>
									<td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $refno; ?></div></td>
									<td class="bodytext31" valign="top"  align="left"><div align="left"><?php echo $charge; ?>(<?php echo $bedname; ?>)</div></td>
									<td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $quantity; ?></div></td>
									<td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($bedrate,2,'.',','); ?></div></td>
									<td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($bedrate*$quantity,2,'.',','); ?></div></td>
								</tr>              
					   <?php } 
					   if($bcopay > 0) { ?>
					   <tr>
									<td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
									<td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $bedallocateddate; ?></div></td>
									<td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $refno; ?></div></td>
									<td class="bodytext31" valign="top"  align="left"><div align="left"><?php echo $charge; ?>(<?php echo $bedname; ?>) Copay</div></td>
									<td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $quantity; ?></div></td>
									<td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($bedratecopay,2,'.',','); ?></div></td>
									<td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($bedratecopay*$quantity,2,'.',','); ?></div></td>
		  </tr>   
					   <?php
					   }
					   ?>
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
					$quantity='0';
					$bedcharge='0';
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
							if($quantity>=0)
							{
								if($type=='hospital'||$charge!='Resident Doctor Charges')
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
									
									if($charge == 'Bed Charges')
									{
										$bcopay = $bed_copay;
									}
									else if($charge == 'Nursing Charges')
									{
										$bcopay = $nursing_copay;
									}
									else if($charge == 'RMO Charges')
									{
										$bcopay = $rmo_copay;
									}
									else
									{
										$bcopay = 0;
									}
									if($bcopay > 0){
									$bedratecopay = $rate * ($bcopay / 100); } else {
									$bedratecopay = 0; }
									$bedrate = $rate - $bedratecopay;
								
									$totalbedtransferamount=$totalbedtransferamount+$amount;
									$totalcopay = $totalcopay + ($bedratecopay*$quantity);
						  ?>
									<tr>
										<td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
										<td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $date; ?></div></td>
										<td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $refno; ?></div></td>
										<td class="bodytext31" valign="top"  align="left"><div align="left"><?php echo $charge; ?>(<?php echo $bedname; ?>)</div></td>
										<td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $quantity; ?></div></td>
										<td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($bedrate,2,'.',','); ?></div></td>
										<td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($bedrate*$quantity,2,'.',','); ?></div></td>
									</tr>  
									<?php            
						 			if($bcopay > 0) { ?>
					   			<tr>
									<td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
									<td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $bedallocateddate; ?></div></td>
									<td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $refno; ?></div></td>
									<td class="bodytext31" valign="top"  align="left"><div align="left"><?php echo $charge; ?>(<?php echo $bedname; ?>) Copay</div></td>
									<td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $quantity; ?></div></td>
									<td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($bedratecopay,2,'.',','); ?></div></td>
									<td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($bedratecopay*$quantity,2,'.',','); ?></div></td>
								</tr>   
					   <?php
					   }
					   ?>
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
				
			//$totalcopay;
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
			
			if($pharmacy_copay > 0)
			{
				$pharatecopay = $pharate * ($pharmacy_copay / 100);
			}
			else
			{
				$pharatecopay = 0;
			}
			$phacopay = $pharate - $pharatecopay;
			
			$totalcopay = $totalcopay + ($pharatecopay*$resquantity); 
			?>
			 <tr>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $phadate; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $refno; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="left"><?php echo $phaname; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $resquantity; ?></div></td>
             <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo $phacopay; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($phacopay*$resquantity,2); ?></div></td>
		     </tr>
			 <?php
			 if($pharmacy_copay > 0)
			 { 
			 ?>
			 <tr>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $phadate; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $refno; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="left"><?php echo $phaname.' Copay'; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $resquantity; ?></div></td>
             <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo $pharatecopay; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($pharatecopay*$resquantity,2); ?></div></td>
		     </tr>
			 <?php
			 }
			 ?>
			  <?php }
			  }
			  }
			  ?>
			  <?php 
			  //echo $totalcopay;
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
			if($lab_copay > 0)
			{
				$labcopay = $labrate * ($lab_copay / 100);
			}
			else
			{
				$labcopay = 0;
			}
			$labcopayrate = $labrate - $labcopay;
			$totalcopay = $totalcopay + $labcopay;
			?>
			 <tr>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $labdate; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $labrefno; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="left"><?php echo $labname; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($labcopayrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($labcopayrate,2,'.',','); ?></div></td>
		     </tr>  
			  <?php
			  if($lab_copay > 0)
			  {
			  ?>
			  <tr>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $labdate; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $labrefno; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="left"><?php echo $labname.' Copay'; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($labcopay,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($labcopay,2,'.',','); ?></div></td>
		     </tr>  
			  <?php
			  }
			  ?>
			  <?php }
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
			if($radiology_copay > 0)
			{	
				$radcopay = $radrate * ($radiology_copay / 100);
			}
			else
			{
				$radcopay = 0;
			}
			$radratecopay = $radrate - $radcopay;
			$totalrad=$totalrad+$radrate;
			$totalcopay=$totalcopay+$radcopay;
			?>
			 <tr>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $raddate; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $radref; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="left"><?php echo $radname; ?></div></td>
			<td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($radratecopay,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($radratecopay,2,'.',','); ?></div></td>
			 </tr>   
			  <?php
			  if($radiology_copay > 0)
			 { ?>
			 <tr>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $raddate; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $radref; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="left"><?php echo $radname.' Copay'; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($radcopay,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($radcopay,2,'.',','); ?></div></td>
			 </tr>   
			  <?php 
			  }
			  }
			  }
			  ?>
		  <?php 
					
					$totalser=0;
		    $query21 = "select * from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemname <> '' and servicerefund <> 'refund' ";
			$exec21 = mysql_query($query21) or die ("Error in Query1".mysql_error());
			while($res21 = mysql_fetch_array($exec21))
			{
			$serdate=$res21['consultationdate'];
			$sername=$res21['servicesitemname'];
			$serrate=$res21['servicesitemrate'];
			$sercode=$res21['servicesitemcode'];
			$serref=$res21['iptestdocno'];
			$servicesfree = $res21['freestatus'];
			$query2111 = "select * from ipconsultation_services where patientvisitcode='$visitcode' and patientcode='$patientcode' and servicesitemcode = '$sercode' and iptestdocno = '$serref' and servicerefund <> 'refund'";
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
			if($service_copay > 0)
			{
				$sercopay = $serrate * ($service_copay / 100);
			}
			else
			{
				$sercopay = 0;
			}
			$sercopayrate = $serrate - $sercopay;
			$totalser=$totalser+$totserrate;
			$totalcopay = $totalcopay + ($sercopay*$serqty);
			?>
			 <tr>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $serdate; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $serref; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="left"><?php echo $sername; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $serqty; ?></div></td>
             <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($sercopayrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($sercopayrate*$serqty,2,'.',','); ?></div></td>
		  </tr>
			  <?php if($service_copay > 0)
			{ ?>
			  <tr>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $serdate; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $serref; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="left"><?php echo $sername.' Copay'; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $serqty; ?></div></td>
             <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($sercopay,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($sercopay*$serqty,2,'.',','); ?></div></td>
			  </tr>
			  <?php 
			  }
			  }
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
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $otbillingdate; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $otbillingrefno; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="left"><?php echo $otbillingname; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($otbillingrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($otbillingrate,2,'.',','); ?></div></td>
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
			 <tr>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $privatedoctordate; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $privatedoctorrefno; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="left"><?php echo $privatedoctor.' '.$description; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $privatedoctorunit; ?></div></td>
             <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($privatedoctorrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($privatedoctoramount,2,'.',','); ?></div></td>
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
			if($ambulance_copay > 0)
			{
				$ambcopay = $ambulancerate * ($ambulance_copay / 100);
			}
			else
			{
				$ambcopay = 0;
			}
			$ambratecopay = $ambulancerate - $ambcopay;
			$totalcopay = $totalcopay + ($ambcopay*$ambulanceunit);
			$totalambulanceamount = $totalambulanceamount + $ambulanceamount;
			?>
			 <tr>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $ambulancedate; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $ambulancerefno; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="left"><?php echo $ambulance; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $ambulanceunit; ?></div></td>
             <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($ambratecopay,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($ambratecopay*$ambulanceunit,2,'.',','); ?></div></td>
	      </tr>
				<?php
				if($ambulance_copay > 0)
				{ ?>
				<tr>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $ambulancedate; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $ambulancerefno; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="left"><?php echo $ambulance.' Copay'; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $ambulanceunit; ?></div></td>
             <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($ambcopay,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($ambcopay*$ambulanceunit,2,'.',','); ?></div></td>
			    </tr>
				<?php
				}
				}
				
			$totalhomecareamount = 0;
			$query63 = "select * from iphomecare where patientcode='$patientcode' and patientvisitcode='$visitcode'";
			$exec63 = mysql_query($query63) or die(mysql_error());
			while($res63 = mysql_fetch_array($exec63))
		   {
			$homecaredate = $res63['consultationdate'];
			$homecarerefno = $res63['docno'];
			$homecare = $res63['description'];
			$homecarerate = $res63['rate'];
			$homecareamount = $res63['amount'];
			$homecareunit = $res63['units'];
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
			$totalhomecareamount = $totalhomecareamount + $homecareamount;
			?>
			 <tr>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $homecaredate; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $homecarerefno; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="left"><?php echo $homecare; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $homecareunit; ?></div></td>
             <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($homecarerate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($homecareamount,2,'.',','); ?></div></td>
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
			if($misc_copay > 0)
			{
				$misccopay = $miscbillingrate * ($misc_copay / 100);
			}
			else
			{
				$misccopay = 0;
			}
			$misccopayrate = $miscbillingrate - $misccopay;
			$totalmiscbillingamount = $totalmiscbillingamount + $miscbillingamount;
			$totalcopay = $totalcopay + ($misccopay*$miscbillingunit);
			?>
			 <tr>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $miscbillingdate; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $miscbillingrefno; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="left"><?php echo $miscbilling; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $miscbillingunit; ?></div></td>
             <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($misccopayrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($misccopayrate*$miscbillingunit,2,'.',','); ?></div></td>
	      </tr>
				<?php
				if($misc_copay > 0)
				{
				?>
				<tr>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $miscbillingdate; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $miscbillingrefno; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="left"><?php echo $miscbilling.' Copay'; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $miscbillingunit; ?></div></td>
             <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($misccopay,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($misccopay*$miscbillingunit,2,'.',','); ?></div></td>
			    </tr>
				<?php
				}
				}
				?>
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
			 <tr>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $discountdate; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $discountrefno; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="left">Discount On <?php echo $discount; ?> by <?php echo $authorizedby; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($discountrate1,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($discountrate,2,'.',','); ?></div></td>
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
			 <tr>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $nhifdate; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $nhifrefno; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="left"> <?php echo 'NHIF'; ?></div></td>
				 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $nhifqty; ?></div></td>
             <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($nhifrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($nhifclaim,2,'.',','); ?></div></td>
	      </tr>
				<?php
				}
				?>
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
			 <tr>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $transactiondate; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $docno; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="left"><?php echo 'Deposit'; ?>&nbsp;&nbsp;<?php echo $transactionmode; ?>
			 <?php
			 if($transactionmode == 'CHEQUE')
			 {
			 echo $chequenumber;
			 }
			 ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($depositamount,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="right">-<?php echo number_format($depositamount,2,'.',','); ?></div></td>
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
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $transactiondate; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $docno; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="left"><?php echo 'Deposit Refund'; ?>
			</div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($depositrefundamount,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($depositrefundamount,2,'.',','); ?></div></td>
			 </tr>   
			  
			  <?php 
			  }
			  ?>
               <?php
			$totaladvancedepositamount = 0;
			$query112 = "select * from master_transactionadvancedeposit where patientcode='$patientcode' ";
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
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $transactiondate; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo $docno; ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="left"><?php echo 'Advance Deposit'; ?>
			</div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="top"  align="left"><div align="right"><?php echo number_format($advancedepositamount,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="top"  align="left"><div align="right">-<?php echo number_format($advancedepositamount,2,'.',','); ?></div></td>
		  </tr>  
			  
			  <?php 
			  }
			  ?>
			  <?php 
			  $depositamount = 0;
			  $overalltotal=($totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalprivatedoctoramount+$totalambulanceamount+$totalhomecareamount+$totalmiscbillingamount+$totaldepositamount+$totalnhifamount+$totaldepositrefundamount-$totaladvancedepositamount)+$totaldiscountamount;

 $overalltotal=($totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalprivatedoctoramount+$totalambulanceamount+$totalhomecareamount+$totalmiscbillingamount+$totaldepositamount+$totalnhifamount+$totaldepositrefundamount-$totaladvancedepositamount);

			  $overalltotal = $overalltotal;
			  $overalltotal=number_format($overalltotal,2,'.','');
			  $consultationtotal=$totalop;
			   $consultationtotal=number_format($consultationtotal,2,'.','');
			   $netpay= $consultationtotal+$totallab+$totalpharm+$totalrad+$totalser;
			   $netpay=number_format($netpay,2,'.','');
			  

			  $grandtotal=($totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalprivatedoctoramount+$totalambulanceamount+$totalhomecareamount+$totalmiscbillingamount-$totaldiscountamount+$totalnhifamount);


$deposit_total=abs($totaldepositamount)-abs($totaldepositrefundamount)+abs($totaladvancedepositamount);
$total_copay=(abs($totalcopay+$totaldepositamount-$totaladvancedepositamount)<0.5)?0:abs($totalcopay+$totaldepositamount-$totaladvancedepositamount);

	?>			  
          
		<tr>  
			<td colspan="6" class="bodytext31" align="right"><strong>Grand Total :</strong></td>
			<td class="bodytext31" align="right"><strong><?php echo number_format($grandtotal,2,'.',','); ?></strong></td>
		</tr>
		<tr>  
			<td colspan="6" class="bodytext31" align="right"><strong>Deposit Total :</strong></td>
			<td class="bodytext31" align="right"><strong><?php echo number_format($deposit_total); ?></strong></td>
		</tr>	
		<tr>  
			<td colspan="6" class="bodytext31" align="right"><strong>Net Payable :</strong></td>
			<td class="bodytext31" align="right"><strong><?php echo number_format($grandtotal-$deposit_total-$overalltotal,2,'.',','); ?></strong></td>
		</tr>
		<?php
		if($totalcopay > 0) { ?>
		<tr>  
			<td colspan="6" class="bodytext31" align="right"><strong>Copay :</strong></td>
			<td class="bodytext31" align="right"><strong><?php echo number_format($total_copay,2,'.',','); ?></strong></td>
		</tr>
	  <?php } ?>
			<tr>
			<td colspan="7" align="left" class="bodytext31" valign="middle" style="border-top:solid 1px #000000;"></td>
			</tr>
			<tr>  
			<td colspan="6" class="bodytext31" align="right"><strong>Balance :</strong></td>
			<td class="bodytext31" align="right"><strong><?php echo number_format($grandtotal-$deposit_total-$overalltotal,2,'.',','); ?></strong></td>		</tr>
		<tr>
			<td colspan="7" align="left" class="bodytext31" valign="middle" style="border-top:solid 1px #000000;"></td>
		  </tr>
         <tr>
			<td colspan="7" class="bodytext31" align="right">&nbsp;</td>
		  </tr>
         <tr>
			<td colspan="7" class="bodytext31" align="center"><strong>This is an Interim Invoice only not final invoice.</strong></td>
		 </tr>
         


<tr >
<td  align="left" valign="left" bgcolor="#ffffff" class="bodytext31"   colspan="2"> <b>Billing Clerk </b> 
      <br />
      <br />
      Signature ....................
    </td>
<td align="center" valign="left" 
	 bgcolor="#ffffff" class="bodytext31"  colspan="3">  
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
    <td>
    &nbsp;<br />
    </td>
</tr>

<tr>
<td colspan="7" align="center"> </td>
</tr>

        
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
        $html2pdf->Output('Interim Bill.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>
