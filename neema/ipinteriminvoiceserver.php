<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$updatetime = date('H:i:s');
$mortuaryupdatedate = date('Y-m-d');
$totalbedtransferamount='';
$totalbedallocationamount ='';
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
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
-->
</style>
<script src="js/jquery.min.js"></script>

<script>

function checkrefundapproval(visitcode,patientcode)
{
	//alert('first');
$.ajax({
type:"get",
url:"ajax/ajaxgetrefundapproval.php?visitcode="+visitcode,

success: function(data){
	var getval=data;
	//alert(getval);
	if(getval==1)
	{
	alert('Request for refund is already done');
	//window.history.back();
	//document.referrer;	
	window.location.reload;
	
	}
	else
	{
		//alert('hai');
	//window.location("depositrefundrequest.php?patientcode="+patientcode+"&&visitcode="+visitcode);
	window.location.href = "depositrefundrequest.php?patientcode=" + patientcode + "&visitcode=" + visitcode;	
	}
	//$("#backup").val("Completed");
	//var set=setTimeout(function(){$("#backup").val("Back Up");},1000);
	}


}); 


}



function funcwardChange1()
{
	/*if(document.getElementById("ward").value == "1")
	{
		alert("You Cannot Add Account For CASH Type");
		document.getElementById("ward").focus();
		return false;
	}*/
	<?php 
	$query12 = "select * from master_ward where recordstatus=''";
	$exec12 = mysql_query($query12) or die ("Error in Query11".mysql_error());
	while ($res12 = mysql_fetch_array($exec12))
	{
	$res12wardanum = $res12["auto_number"];
	$res12ward = $res12["ward"];
	?>
	if(document.getElementById("ward").value=="<?php echo $res12wardanum; ?>")
	{
		document.getElementById("bed").options.length=null; 
		var combo = document.getElementById('bed'); 	
		<?php 
		$loopcount=0;
		?>
		combo.options[<?php echo $loopcount;?>] = new Option ("Select Sub Type", ""); 
		<?php
		$query10 = "select * from master_bed where ward = '$res12wardanum' and recordstatus = ''";
		$exec10 = mysql_query($query10) or die ("error in query10".mysql_error());
		while ($res10 = mysql_fetch_array($exec10))
		{
		$loopcount = $loopcount+1;
		$res10bedanum = $res10['auto_number'];
		$res10bed = $res10["bed"];
		
		
		
		?>
			combo.options[<?php echo $loopcount;?>] = new Option ("<?php echo $res10bed;?>", "<?php echo $res10bedanum;?>"); 
		<?php 
		
		}
		?>
	}
	<?php
	}
	?>	
}


function funcvalidation()
{
//alert('h');
if(document.getElementById("readytodischarge").checked == false)
{
alert("Please Click on Ready To Discharge");
return false;
}

}
function funcPrint(){
	var printType = document.getElementById("print").value;
	var patientCode = '<?php echo $patientcode;?>';
	var visitCode = '<?php echo $visitcode;?>';
	if(printType == 'summary'){
		window.open("printipinteriminvoice1.php?patientcode="+patientCode+"&&visitcode="+visitCode+"","_blank");
	}else if(printType == 'detail'){
		window.open("printipinteriminvoice2.php?patientcode="+patientCode+"&&visitcode="+visitCode+"","_blank");
	}else if(printType == 'final'){
		window.open("printipinteriminvoice3.php?patientcode="+patientCode+"&&visitcode="+visitCode+"","_blank");
	}
}
</script>


<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
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
.bali
{
text-align:right;
}
</style>
</head>

<script src="js/datetimepicker_css.js"></script>
<script type="text/javascript">
function ViewDr(patientcodes,visitcodes)
{
window.open("viewdoctorbill.php?patientcode="+patientcodes+"&&visitcode="+visitcodes,"OriginalWindowA25",'width=750,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
}

</script>
<body>
<form name="form1" id="form1" method="post" action="ipinteriminvoice.php" onSubmit="return validcheck()">	
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="15" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="15" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="15" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="15">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
   
    <td colspan="6" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      
	 
	
		<tr>
		<td>
<?php 

$query1 = "select locationcode from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		
		while($res1 = mysql_fetch_array($exec1))
		{
		
		
		$locationcodeget = $res1['locationcode'];
		$query551 = "select * from master_location where locationcode='".$locationcodeget."'";
		$exec551 = mysql_query($query551) or die(mysql_error());
		$res551 = mysql_fetch_array($exec551);
		$locationnameget = $res551['locationname'];
		}?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
             <tr>
						  <td colspan="4" class="bodytext31" bgcolor="#CCCCCC"><strong>IP Interim Invoice</strong></td>
                          <td colspan="3" class="bodytext31" bgcolor="#CCCCCC"><strong>Location &nbsp;</strong><?php echo $locationnameget;?></td>
						</tr>
            <tr>
              
				 <td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient Name</strong></div></td>
           
				 <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Code  </strong></div></td>
				 <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>IP Visit  </strong></div></td>
				 <td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bill Type</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Account</strong></div></td>
              </tr>
           <?php
            $colorloopcount ='';
		
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
		
		
		
		$querymenu = "select subtype from master_customer where customercode='$patientcode'";
		$execmenu = mysql_query($querymenu) or die ("Error in Query1".mysql_error());
		$nummenu=mysql_num_rows($execmenu);
		
		$resmenu = mysql_fetch_array($execmenu);
		
		$menusub=$resmenu['subtype'];
		
	$query32 = "select subtype,bedtemplate,labtemplate,radtemplate,sertemplate from master_subtype where auto_number = '".$menusub."'";
		$exec32 = mysql_query($query32) or die ("Error in Query2".mysql_error());
	//	$res2 = mysql_num_rows($exec2);
		$mastervalue = mysql_fetch_array($exec32);
		//$currency=$mastervalue['currency'];
		//$fxrate=$mastervalue['fxrate'];
		$subtype=$mastervalue['subtype'];
		$bedtemplate=$mastervalue['bedtemplate'];
		$labtemplate=$mastervalue['labtemplate'];
		$radtemplate=$mastervalue['radtemplate'];
		$sertemplate=$mastervalue['sertemplate'];
		
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
          <tr <?php echo $colorcode; ?>>
             
			  <td align="left" valign="center" class="bodytext31">
			    <div align="center"><?php echo $patientname; ?></div></td>
				<td align="center" valign="center" class="bodytext31"><?php echo $patientcode; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $visitcode; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $updatedate; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $billtype; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $accname; ?></td>
			<input type="hidden" name="patientname" id="patientname" value="<?php echo $patientname; ?>">
				 
				<input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>">
				<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>">
			
				<input type="hidden" name="accname" id="accname" value="<?php echo $accname; ?>">
			   </tr>
		   <?php 
		   } 
		  
		   ?>
           
            <tr>
             	<td colspan="6" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#cccccc" class="bodytext311">&nbsp;</td>
             	</tr>
          </tbody>
        </table>		</td>
		</tr>
		
		</table>		</td>
		</tr>
		<tr>
        <td>&nbsp;</td>
		</tr>
	<tr>
	
	<td>&nbsp;</td>
	<td width="6%">&nbsp;</td>
	<td colspan="2">
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
		   <?php
		  
		  $locationnameget=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';
		   $query1 = "select locationcode,package from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		
		while($res1 = mysql_fetch_array($exec1))
		{
		
		
		$locationcodeget = $res1['locationcode'];
		$res2package = $res1["package"];
		$query551 = "select * from master_location where locationcode='".$locationcodeget."'";
		$exec551 = mysql_query($query551) or die(mysql_error());
		$res551 = mysql_fetch_array($exec551);
		$locationnameget = $res551['locationname'];
		}?>
		  <?php $numpr=0;
		if($res2package != 0) {
			$query112 = "select * from privatedoctor_billing where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysql_query($query112) or die(mysql_error());
			$privno = mysql_num_rows($exec112);
			
			$query112 = "select * from residentdoctor_billing where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec112 = mysql_query($query112) or die(mysql_error());
			$resno = mysql_num_rows($exec112);
			$numpr = $privno+$resno;
			if($numpr == '0') { ?>
			
			<?php }
			if($numpr > '0')
			{
			?>
			<tr>
			<td colspan="7" bgcolor="#cc99ff" class="bodytext311" align="left"><strong>Doctor Bill Posted. &nbsp; <a id="myLink" href="#" onClick="return ViewDr('<?php echo $patientcode; ?>','<?php echo $visitcode; ?>');">Click to see</a></strong></td>
			</tr>
			<?php
			}
		} ?>
           <tr bgcolor="#011E6A">
                <td colspan="8" bgcolor="#CCCCCC" class="bodytext31"><strong>Transaction Details</strong></td>
			 </tr>
          
            <tr>
			 
              <td width="5%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
				<td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Date</strong></div></td>
				<td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Ref.No</strong></div></td>
				<td width="13%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Description</strong></div></td>
                <td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Qty</strong></div></td>
				<td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Rate  </strong></div></td>
					<td width="5%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount </strong></div></td>
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
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Admission Charge'; ?></div></td>
			     <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($consultationfee,2,'.',','); ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $consultationfee; ?></div></td>
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
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $consultationdate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Admission Charge'; ?></div></td>
			     <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($consultationfee,2,'.',','); ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $consultationfee; ?></div></td>
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
			   <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $packagedate1; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $visitcode; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $packagename; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
               <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($packageamount,2,'.',','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($packageamount,2,'.',','); ?></div></td>
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
								//$bedrate = $rate - $bedratecopay;
								$bedrate = $rate;
								
								$totalcopay = $totalcopay + ($bedratecopay*$quantity);
					  ?>
					   <?php if($rowbedtr == 0) { $totalbedallocationamount=$totalbedallocationamount+$amount; ?>
								<tr <?php echo $colorcode; ?>>
									<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $bedallocateddate; ?></div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $charge; ?>(<?php echo $bedname; ?>)</div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $quantity; ?></div></td>
									<input type="hidden" name="descriptioncharge[]" id="descriptioncharge" value="<?php echo $charge; ?>">
									<input type="hidden" name="descriptionchargerate[]" id="descriptionchargerate" value="<?php echo $rate; ?>">
									<input type="hidden" name="descriptionchargeamount[]" id="descriptionchargeamount" value="<?php echo $amount; ?>">
									<input type="hidden" name="descriptionchargequantity[]" id="descriptionchargequantity" value="<?php echo $quantity; ?>">
									<input type="hidden" name="descriptionchargedocno[]" id="descriptionchargedocno" value="<?php echo $refno; ?>">
									<input type="hidden" name="descriptionchargeward[]" id="descriptionchargeward" value="<?php echo $ward; ?>">
									<input type="hidden" name="descriptionchargebed[]" id="descriptionchargebed" value="<?php echo $bed; ?>">
									<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($bedrate,2,'.',','); ?></div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($bedrate*$quantity,2,'.',','); ?></div></td>
								</tr>              
					   <?php } 
					   if($bcopay > 0) { ?>
					   <tr <?php echo $colorcode; ?>>
									<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $bedallocateddate; ?></div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $charge; ?>(<?php echo $bedname; ?>) Copay</div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $quantity; ?></div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo '-'.number_format($bedratecopay,2,'.',','); ?></div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo '-'.number_format($bedratecopay*$quantity,2,'.',','); ?></div></td>
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
									//$bedrate = $rate - $bedratecopay;
									$bedrate = $rate;
								
									$totalbedtransferamount=$totalbedtransferamount+$amount;
									$totalcopay = $totalcopay + ($bedratecopay*$quantity);
						  ?>
									<tr <?php echo $colorcode; ?>>
										<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
										<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $date; ?></div></td>
										<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
										<td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $charge; ?>(<?php echo $bedname; ?>)</div></td>
										<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $quantity; ?></div></td>
										<input type="hidden" name="descriptioncharge[]" id="descriptioncharge" value="<?php echo $charge; ?>">
										<input type="hidden" name="descriptionchargerate[]" id="descriptionchargerate" value="<?php echo $rate; ?>">
										<input type="hidden" name="descriptionchargeamount[]" id="descriptionchargeamount" value="<?php echo $amount; ?>">
										<input type="hidden" name="descriptionchargequantity[]" id="descriptionchargequantity" value="<?php echo $quantity; ?>">
										<input type="hidden" name="descriptionchargedocno[]" id="descriptionchargedocno" value="<?php echo $refno; ?>">
										<input type="hidden" name="descriptionchargeward[]" id="descriptionchargeward" value="<?php echo $ward; ?>">
										<input type="hidden" name="descriptionchargebed[]" id="descriptionchargebed" value="<?php echo $bed; ?>">
										<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($bedrate,2,'.',','); ?></div></td>
										<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($bedrate*$quantity,2,'.',','); ?></div></td>
									</tr>  
									<?php            
						 			if($bcopay > 0) { ?>
					   			<tr <?php echo $colorcode; ?>>
									<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $bedallocateddate; ?></div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $charge; ?>(<?php echo $bedname; ?>) Copay</div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $quantity; ?></div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo '-'.number_format($bedratecopay,2,'.',','); ?></div></td>
									<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo '-'.number_format($bedratecopay*$quantity,2,'.',','); ?></div></td>
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
					$amount=($originalamount/100)*$insumor_copay;
					//$miscbillingamount=($originalmiscbillingamount1/100)*$insumis_copay;
				}
				if($mortuary_copay>=100.00){$amount=0;}
			
			//copay end
			$mortuarypackageamount = $amount;
			?>
            <?php if($mortuary_copay<100){?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"> <?php echo $package; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
                  
             <td class="bodytext31" valign="center"  align="left"><div align="right">
			<?php echo number_format($amount,2,'.',','); ?></div></td>
             
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
			    </tr>
                <?php
				$totalshelfamount = $totalshelfamount + $amount;
				 }?>
                 <?php if($mortuary_copay>0.00){
				  $copayamount = ($originalamount/100)*$mortuary_copay;
				   //$copayamount = $copayrate*$quantity;
				   $copaytotalbed = $copaytotalbed + $copayamount;
			  ?>
               <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"> <?php echo $package ,' COPAY'; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
                 
             <td class="bodytext31" valign="center"  align="left"><div align="right">
               <?php echo number_format($copayamount,2); ?>
             </div></td>
             
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copayamount,2,'.',','); ?></div></td>
			 </tr>
			  <?php
			  $totalshelfamount = $totalshelfamount + $copayamount;
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
					$shelfcharges=($originalshelfcharges/100)*$insushel_copay;
					$shelfamount=($originalshelfamount/100)*$insushel_copay;
				}
				if($mortuary_copay>=100.00){$amount=0;}
				
				
				if($mortuary_copay<100){?>
                
			 <tr <?php echo $colorcode; ?>>
             
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"> <?php echo $shelve; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $days; ?></div></td>
                
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($shelfcharges,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($shelfamount,2,'.',','); ?></div></td>
			    </tr>
                <?php
				$totalshelfamount = $totalshelfamount + $shelfamount;
				 }?>
                 <?php if($mortuary_copay>0.00){
				  $copayshelfcharges = ($originalshelfcharges/100)*$mortuary_copay;
				  $copayshelfamount = ($originalshelfamount/100)*$mortuary_copay;
				   //$copayamount = $copayrate*$quantity;
				   $copaytotalbed = $copaytotalbed + $copayshelfamount;
			  ?>
                <tr <?php echo $colorcode; ?>>
             
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"> <?php echo $shelve,' COPAY' ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $days; ?></div></td>
                 
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copayshelfcharges,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copayshelfamount,2,'.',','); ?></div></td>
			    </tr>
              <?php 
			  $totalshelfamount = $totalshelfamount + $copayshelfamount;
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
					$shelfcharges=($originalshelfcharges/100)*$insushel_copay;
					$shelfamount=($originalshelfamount/100)*$insushel_copay;
				}
				if($mortuary_copay>=100.00){$amount=0;}
				
				
				if($mortuary_copay<100){
				?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"> <?php echo $shelve ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $daysafterpackage; ?></div></td>
                 
               
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($shelfcharges,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($shelfamount,2,'.',','); ?></div></td>
			    </tr>
                 <?php
				 $totalshelfamount = $totalshelfamount + $shelfamount;
				  }?>
                 <?php if($mortuary_copay>0.00){
				  $copayshelfcharges = ($originalshelfcharges/100)*$mortuary_copay;
				  $copayshelfamount = ($originalshelfamount/100)*$mortuary_copay;
				   //$copayamount = $copayrate*$quantity;
				   $copaytotalbed = $copaytotalbed + $copayshelfamount;
			  ?>
                <tr <?php echo $colorcode; ?>>
             
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"> <?php echo $shelve,' COPAY' ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $days; ?></div></td>
                 
            
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copayshelfcharges,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($copayshelfamount,2,'.',','); ?></div></td>
			    </tr>
              <?php
			   $totalshelfamount = $totalshelfamount + $copayshelfamount;
			   }?>
				<?php
				
			}
			}
			}
				}
				?>
              
              <?php
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
			//$phacopay = $pharate - $pharatecopay;
			$phacopay = $pharate;
			
			$totalcopay = $totalcopay + ($pharatecopay*$resquantity); 
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phadate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $phaname; ?></div></td>
			 <input name="medicinename[]" type="hidden" id="medicinename" size="25" value="<?php echo $phaname; ?>">
			 <input name="quantity[]" type="hidden" id="quantity" size="8" readonly value="<?php echo $resquantity; ?>">
			 <input name="rate[]" type="hidden" id="rate" readonly size="8" value="<?php echo $pharate; ?>">
			 <input name="amount[]" type="hidden" id="amount" readonly size="8" value="<?php echo $resamount; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $resquantity; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo $phacopay; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($phacopay*$resquantity,2); ?></div></td>
		     </tr>
			 <?php
			 if($pharmacy_copay > 0)
			 { 
			 ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $phadate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $refno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $phaname.' Copay'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $resquantity; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo '-'.$pharatecopay; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo '-'.number_format($pharatecopay*$resquantity,2); ?></div></td>
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
			//$labcopayrate = $labrate - $labcopay;
			$labcopayrate = $labrate;
			$totalcopay = $totalcopay + $labcopay;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labrefno; ?></div></td>
			 <input name="lab[]" id="lab" size="69" type="hidden" value="<?php echo $labname; ?>">
			 <input name="rate5[]" id="rate5" readonly size="8" type="hidden" value="<?php echo $labrate; ?>">
			 <input name="labcode[]" id="labcode" readonly size="8" type="hidden" value="<?php echo $labcode; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $labname; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labcopayrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($labcopayrate,2,'.',','); ?></div></td>
		     </tr>  
			  <?php
			  if($lab_copay > 0)
			  {
			  ?>
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $labrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $labname.' Copay'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo '-'.number_format($labcopay,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo '-'.number_format($labcopay,2,'.',','); ?></div></td>
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
			//$radratecopay = $radrate - $radcopay;
			$radratecopay = $radrate;
			$totalrad=$totalrad+$radrate;
			$totalcopay=$totalcopay+$radcopay;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $raddate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $radref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $radname; ?></div></td>

			 <input name="radiology[]" id="radiology" type="hidden" size="69" autocomplete="off" value="<?php echo $radname; ?>">
			 <input name="rate8[]" type="hidden" id="rate8" readonly size="8" value="<?php echo $radrate; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radratecopay,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($radratecopay,2,'.',','); ?></div></td>
			 </tr>   
			  <?php
			  if($radiology_copay > 0)
			 { ?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $raddate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $radref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $radname.' Copay'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo '-'.number_format($radcopay,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo '-'.number_format($radcopay,2,'.',','); ?></div></td>
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
			//$sercopayrate = $serrate - $sercopay;
			$sercopayrate = $serrate;
			$totalser=$totalser+$totserrate;
			$totalcopay = $totalcopay + ($sercopay*$serqty);
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sername; ?></div></td>
			 <input name="services[]" type="hidden" id="services" size="69" value="<?php echo $sername; ?>">
			 <input name="rate3[]" type="hidden" id="rate3" readonly size="8" value="<?php echo $serrate; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serqty; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($sercopayrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($sercopayrate*$serqty,2,'.',','); ?></div></td>
			  </tr>
			  <?php if($service_copay > 0)
			{ ?>
			  <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serref; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $sername.' Copay'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $serqty; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo '-'.number_format($sercopay,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo '-'.number_format($sercopay*$serqty,2,'.',','); ?></div></td>
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
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $otbillingdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $otbillingrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $otbillingname; ?></div></td>
			 <input name="surgeryname[]" type="hidden" id="surgeryname" size="69" value="<?php echo $otbillingname; ?>">
			 <input name="surgeryrate[]" type="hidden" id="surgeryrate" readonly size="8" value="<?php echo $otbillingrate; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($otbillingrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($otbillingrate,2,'.',','); ?></div></td>
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
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $privatedoctordate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $privatedoctorrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $privatedoctor.' '.$description; ?></div></td>
			 <input name="doctorname[]" type="hidden" id="doctorname" size="69" value="<?php echo $privatedoctor; ?>">
			 <input name="doctorrate[]" type="hidden" id="doctorrate" readonly size="8" value="<?php echo $privatedoctorrate; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $privatedoctorunit; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($privatedoctorrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($privatedoctoramount,2,'.',','); ?></div></td>
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
			//$ambratecopay = $ambulancerate - $ambcopay;
			$ambratecopay = $ambulancerate;
			$totalcopay = $totalcopay + ($ambcopay*$ambulanceunit);
			$totalambulanceamount = $totalambulanceamount + $ambulanceamount;
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $ambulancedate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $ambulancerefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $ambulance; ?></div></td>
			 <input name="doctorname[]" type="hidden" id="doctorname" size="69" value="<?php echo $ambulance; ?>">
			 <input name="doctorrate[]" type="hidden" id="doctorrate" readonly size="8" value="<?php echo $ambulancerate; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $ambulanceunit; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($ambratecopay,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($ambratecopay*$ambulanceunit,2,'.',','); ?></div></td>
			    </tr>
				<?php
				if($ambulance_copay > 0)
				{ ?>
				<tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $ambulancedate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $ambulancerefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $ambulance.' Copay'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $ambulanceunit; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo '-'.number_format($ambcopay,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo '-'.number_format($ambcopay*$ambulanceunit,2,'.',','); ?></div></td>
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
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $homecaredate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $homecarerefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $homecare; ?></div></td>
			 <input name="doctorname[]" type="hidden" id="doctorname" size="69" value="<?php echo $homecare; ?>">
			 <input name="doctorrate[]" type="hidden" id="doctorrate" readonly size="8" value="<?php echo $homecarerate; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $homecareunit; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($homecarerate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($homecareamount,2,'.',','); ?></div></td>
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
			//$misccopayrate = $miscbillingrate - $misccopay;
			$misccopayrate = $miscbillingrate;
			$totalmiscbillingamount = $totalmiscbillingamount + $miscbillingamount;
			$totalcopay = $totalcopay + ($misccopay*$miscbillingunit);
			?>
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $miscbillingdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $miscbillingrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $miscbilling; ?></div></td>
			 <input name="doctorname[]" type="hidden" id="doctorname" size="69" value="<?php echo $miscbilling; ?>">
			 <input name="doctorrate[]" type="hidden" id="doctorrate" readonly size="8" value="<?php echo $miscbillingrate; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $miscbillingunit; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($misccopayrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($misccopayrate*$miscbillingunit,2,'.',','); ?></div></td>
			    </tr>
				<?php
				if($misc_copay > 0)
				{
				?>
				<tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $miscbillingdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $miscbillingrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo $miscbilling.' Copay'; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $miscbillingunit; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo '-'.number_format($misccopay,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo '-'.number_format($misccopay*$miscbillingunit,2,'.',','); ?></div></td>
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
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $discountdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $discountrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left">Discount On <?php echo $discount; ?> by <?php echo $authorizedby; ?></div></td>
			 <input name="doctorname[]" type="hidden" id="doctorname" size="69" value="<?php echo $discount; ?>">
			 <input name="doctorrate[]" type="hidden" id="doctorrate" readonly size="8" value="<?php echo $discountrate; ?>">
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($discountrate1,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($discountrate,2,'.',','); ?></div></td>
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
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifdate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifrefno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"> <?php echo 'NHIF'; ?></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $nhifqty; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($nhifrate,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($nhifclaim,2,'.',','); ?></div></td>
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
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $transactiondate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Deposit'; ?>&nbsp;&nbsp;<?php echo $transactionmode; ?>
			 <?php
			 if($transactionmode == 'CHEQUE')
			 {
			 echo $chequenumber;
			 }
			 ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($depositamount,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($depositamount,2,'.',','); ?></div></td>
			    
			  
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
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $transactiondate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Deposit Refund'; ?>
			</div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($depositrefundamount,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($depositrefundamount,2,'.',','); ?></div></td>
			    
			  
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
			 <tr <?php echo $colorcode; ?>>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $transactiondate; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $docno; ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo 'Advance Deposit'; ?>
			</div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '1'; ?></div></td>
             <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($advancedepositamount,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="right">-<?php echo number_format($advancedepositamount,2,'.',','); ?></div></td>
			    
			  
			  <?php 
			  }
			  ?>
			  <?php 
			  $depositamount = 0;
			  if($totalcopay>0)
			  {
			  $overalltotal=($totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalprivatedoctoramount+$totalambulanceamount+$totalhomecareamount+$totalmiscbillingamount+$totaldepositamount+$totalnhifamount+$totaldepositrefundamount)+$totaldiscountamount-$totaladvancedepositamount;
			  $overalltotal = $overalltotal+$totalshelfamount;  
			  }
			  else
			  {
			  $overalltotal=($totalop+$totalbedtransferamount+$totalbedallocationamount+$totallab+$totalpharm+$totalrad+$totalser+$packageamount+$totalotbillingamount+$totalprivatedoctoramount+$totalambulanceamount+$totalhomecareamount+$totalmiscbillingamount+$totaldepositamount+$totalnhifamount+$totaldepositrefundamount)+$totaldiscountamount-$totaladvancedepositamount;
			  $overalltotal = $overalltotal+$totalshelfamount;  
			  }
			  $overalltotal=number_format($overalltotal,2,'.','');
			  $consultationtotal=$totalop;
			   $consultationtotal=number_format($consultationtotal,2,'.','');
			   $netpay= $consultationtotal+$totallab+$totalpharm+$totalrad+$totalser+$totalshelfamount;
			   $netpay=number_format($netpay,2,'.','');
			  ?>
			  <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong></strong></td>
             <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong></strong></td>
			 </tr>
          </tbody>
        </table>		</td>
	</tr>
	<tr>
	  <td colspan="4" class="bodytext31" align="right"><strong> Net Payable&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($overalltotal,2,'.',','); ?></strong></td>
	     <td class="bodytext31" align="center">&nbsp;</td>
	     <td class="bodytext31" align="center">&nbsp;</td>
		 <td class="bodytext31" align="center">&nbsp;
		 <input type="hidden" name="totalcopay" id="totalcopay" value="<?php echo number_format(abs(round($copaytotalbed+$totalcopay+$totaldepositamount-$totaladvancedepositamount)),2,'.',''); ?>">
		 </td>
		</tr>
		<?php
		if($totalcopay > 0) { ?>
		<tr>
	  <td colspan="4" class="bodytext31" align="right"><strong> Copay&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($copaytotalbed+$totalcopay,2,'.',','); ?></strong></td>
	     <td class="bodytext31" align="center">&nbsp;</td>
	     <td class="bodytext31" align="center">&nbsp;</td>
		 <td class="bodytext31" align="center">&nbsp;</td>
		</tr>
	  <?php } ?>
	  <tr>
        <td>&nbsp;</td>
		 <td>&nbsp;</td>
		  <td width="45%"><!--<a target="_blank" href="printipinteriminvoice1.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">-->
		    <input name="button" type="button" onClick="funcPrint();" value="Print"/>
		  <!--</a>--></td>
		  <td width="15%" class="bodytext31" align="right" >
		  <?php
		  if($overalltotal < 0)
		  {
		  ?>
		  <a onClick="checkrefundapproval('<?php echo $visitcode; ?>','<?php echo $patientcode;?>')" style="cursor:pointer; color:#00F">Click to Refund Deposit</a></td>

  <?php
		  }
		  ?>
	    <td width="1%">&nbsp;</td>
		<td width="1%">
        <select id="print">
        	<option value="summary">Summary</option>
            <option value="detail">Detailed</option>
			<option value="final">Interim Final</option>
        </select>
        </td>
		<td width="31%" align="center" valign="center" class="bodytext311">         
        <a href="ipbilling.php"><input type="button" value="Back"/></a></td>
      </tr>
    </table>
  </table>
</form>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

