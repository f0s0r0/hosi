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

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
?>


<?php

if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag1"])) { $frmflag1 = $_REQUEST["frmflag1"]; } else { $frmflag1 = ""; }
//$frmflag2 = $_POST['frmflag2'];

if ($frmflag1 == 'frmflag1')
{
       
		$paynowbillprefix7 = 'DIS-';
$paynowbillprefix17=strlen($paynowbillprefix7);
$query27 = "select * from ip_discharge order by auto_number desc limit 0, 1";
$exec27 = mysql_query($query27) or die ("Error in Query27".mysql_error());
$res27 = mysql_fetch_array($exec27);
$billnumber7 = $res27["docno"];
$billdigit7=strlen($billnumber7);

if ($billnumber7 == '')
{
	$billnumbercode7 =$paynowbillprefix7.'1';
		$openingbalance = '0.00';

}
else
{
	$billnumber7 = $res27["docno"];
	$billnumbercode7 = substr($billnumber7,$paynowbillprefix17, $billdigit7);
	//echo $billnumbercode;
	$billnumbercode7 = intval($billnumbercode7);
	$billnumbercode7 = $billnumbercode7 + 1;

	$maxanum7 = $billnumbercode7;
	
	
	$billnumbercode7 = $paynowbillprefix7 .$maxanum7;
		}
		$patientname = $_REQUEST['patientname'];
		$patientcode = $_REQUEST['patientcode'];
		$visitcode = $_REQUEST['visitcode'];
		$mortuarydocno = $_REQUEST['mortuarydocno'];
		
		$accname = $_REQUEST['accname'];
		/*$ward1 = $_REQUEST['wardanum'];
		$bed1 = $_REQUEST['bedanum'];*/
		$readytodischarge = $_REQUEST['readytodischarge'];
		$shelf = $_REQUEST['shelf'];
		//$frompage = $_REQUEST['frompage'];
			
		$query33 = "select * from ip_discharge where patientcode = '".$patientcode."'	AND visitcode = '".$visitcode."'";
		$exec33 = mysql_query($query33) or die(mysql_error());
		$num33 = mysql_num_rows($exec33);
		
		if($num33 != 0)
		{
		if($readytodischarge == 1)
		{
		
		
		
		$query67 = "UPDATE mortuary_allocation SET dischargestatus = 'discharged',dischargedate='$updatedate' WHERE patientcode = '".$patientcode."'	AND visitcode = '".$visitcode."' and docno='$mortuarydocno'";
		$exec67 = mysql_query($query67) or die("Error in Query67: ".mysql_error());
		
		$query68 = "UPDATE master_shelf SET allocationstatus = '' WHERE shelf = '".$shelf."'";
		$exec68 = mysql_query($query68) or die("Error in Query68: ".mysql_error());
	/*	
		$query79 = "update master_bed set recordstatus='' where auto_number='$bed1' and ward='$ward1'";
		$exec79 = mysql_query($query79) or die(mysql_error());
		
		$query81 = "update master_ipvisitentry set discharge='completed' where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec81 = mysql_query($query81) or die(mysql_error());
		
		$query88 = "update ip_bedallocation set recordstatus='discharged' where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec88 = mysql_query($query88) or die(mysql_query());
		
		$query881 = "update ip_bedtransfer set recordstatus='discharged' where patientcode='$patientcode' and visitcode='$visitcode'";
		$exec881 = mysql_query($query881) or die(mysql_query());
		
		$query8811 = "update newborn_motherdetails set discharge='discharged' where patientcode='$patientcode' and patientvisitcode='$visitcode'";
		$exec8811 = mysql_query($query8811) or die(mysql_query());*/
		
		
	}
	
			}
		
		header("location:mortuaryactivity.php");
		
		exit;

}

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
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$paynowbillprefix = 'DIS-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from ip_discharge order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docno"];
$billdigit=strlen($billnumber);

if ($billnumber == '')
{
	$billnumbercode =$paynowbillprefix.'1';
		$openingbalance = '0.00';

}
else
{
	$billnumber = $res2["docno"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = $paynowbillprefix .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}

?>
<?php

if(isset($_REQUEST['patientcode'])) { $patientcode = $_REQUEST["patientcode"]; } else { $patientcode = ""; }
if(isset($_REQUEST['visitcode'])) { $visitcode = $_REQUEST["visitcode"]; } else { $visitcode = ""; }
if(isset($_REQUEST['docno'])) { $mortuarydocno = $_REQUEST["docno"]; } else { $mortuarydocno = ""; }
if(isset($_REQUEST["frompage"])){$frompage = $_REQUEST["frompage"]; }else{$frompage ='';}
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

<script>


function validcheck()
{
if(document.getElementById("ward").value == '')
{
alert("Please Select Ward");
document.getElementById("ward").focus();
return false;
}
if(document.getElementById("bed").value == '')
{
alert("Please Select Bed");
document.getElementById("bed").focus();
return false;
}
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
function funcFinalBill(){
	
<?php
	$queryfinal = "SELECT * FROM master_transactionip WHERE patientcode = '$patientcode' AND visitcode = '$visitcode' AND transactiontype ='finalize'";
	$execfinal = mysql_query($queryfinal) or die("Error in Queryfinal: ".mysql_error());
	$numfinal = mysql_num_rows($execfinal);
?>
	var numFinal = "<?php echo $numfinal;?>";
	if(numFinal==0){
		alert("Please Finalize the Bill before Discharge.");
		document.getElementById("readytodischarge").checked = false;
	}
}

function funcvalidation()
{
//alert('h');
if(document.getElementById("readytodischarge").checked == false)
{
alert("Please Check on Discharge");
return false;
}
if(confirm("Do you want to discharge this Body?")==false){
	return false;	
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

<body>
<form name="form1" id="form1" method="post" action="" onSubmit="return validcheck()">	
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="14" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="14" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="14" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  
  <tr>
    <td colspan="14">&nbsp;</td>
  </tr>
  <tr>
    <td width="2%">&nbsp;</td>
   
    <td colspan="5" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      
	 
	
		<tr>
		<td>

		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1100" 
            align="left" border="0">
          <tbody>
             <tr>
			  
			   <td width="8%"  align="center" valign="center" class="bodytext31"><strong>Date</strong></td>
			   <td width="13%"  align="center" valign="center" class="bodytext31"> 
			   <input type="text" name="date" id="date" value="<?php echo $updatedate; ?>" size="10" readonly>
                    <strong><span class="bodytext312"> <img src="images2/cal.gif" onClick="javascript:NewCssCal('dateofbirth')" style="cursor:pointer"/> </span></strong>               </td>
					  <td width="10%" align="center" valign="center" class="bodytext31"><strong>Time</strong></td>
                      <td colspan="2" align="left" valign="center" class="bodytext31"> <input type="text" name="time" id="time" value="<?php echo $updatetime; ?>" size="10" readonly></td>
             </tr>
             
             <?php 
			 if($patientcode!='walkin')
			 {
  			$queryfinal = "SELECT * FROM master_transactionip WHERE patientcode = '".$patientcode."' AND visitcode='".$visitcode."' AND transactiontype ='finalize'";
			$execfinal = mysql_query($queryfinal) or die("Error in Queryfinal: ".mysql_error());
			$numfinal = mysql_num_rows($execfinal);
			if($numfinal==0){
  ?>
  <tr>
    <td colspan="12"  bgcolor="#ED4337" class="bodytext31" align="center"><strong>Please Finalize the Bill before Discharge.</strong></td>
  </tr>
  <?php }
			 }
			 else
			 {
  			$queryfinal = "SELECT * FROM mortuaryexternal_services WHERE patientcode = '".$patientcode."' AND patientvisitcode='".$visitcode."' AND mortuarydocno ='$mortuarydocno' and paymentstatus='pending' and freestatus = '0'";
			$execfinal = mysql_query($queryfinal) or die("Error in Queryfinal: ".mysql_error());
			$numfinal1 = mysql_num_rows($execfinal);
			if($numfinal1!=0){
  ?>
  <tr>
    <td colspan="12"  bgcolor="#ED4337" class="bodytext31" align="center"><strong>Please Pay the service Bill.</strong></td>
  </tr>
  <?php }
			 }
			 ?>
            <tr>
              
				 <td colspan="2"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient Name</strong></div></td>
           
				 <td colspan="2"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Code  </strong></div></td>
				 <td colspan="2"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>IP Visit</strong></div></td>
				 <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Age</strong></div></td>
                <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Gender</strong></div></td>
                <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Shelf No </strong></div></td>
				<td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Package</strong></div></td>
				<td width="21%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Account</strong></div></td>
              </tr>
           <?php
            $colorloopcount ='';
			
		
		  $query34 = "SELECT * FROM mortuary_allocation WHERE patientcode = '".$patientcode."' AND visitcode='".$visitcode."' and docno='$mortuarydocno' ";
			$exec34 = mysql_query($query34) or die("Error in Query34: ".mysql_error());
			while($res34 = mysql_fetch_array($exec34))
			{
			 $docno = $res34['docno'];
			 $patientname = $res34['patientname'];
			 $patientcode = $res34['patientcode'];
			 $visitcode = $res34['visitcode'];
			 $ward = $res34['ward'];
			 $bed = $res34['bed'];
			 $shelf = $res34['shelve'];
			 $package = $res34['package'];
			 $accountname = $res34['accountname'];
			 $requestno = $res34['requestno'];
		
		
//		$query69 = "SELECT * FROM master_customer WHERE customercode = '$patientcode'";
//		$exec69 = mysql_query($query69) or die(mysql_error());
//		$num69 = mysql_num_rows($exec69);
//		$res69 = mysql_fetch_array($exec69);
//		$age = $res69['age'];
//		$gender = $res69['gender'];
//		$dob = $res69['dateofbirth'];
	
		$query69 = "SELECT * FROM mortuary_request WHERE docno = '$requestno'";
		$exec69 = mysql_query($query69) or die(mysql_error());
		$num69 = mysql_num_rows($exec69);
		$res69 = mysql_fetch_array($exec69);
		$age = $res69['age'];
		$gender = $res69['gender'];


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
             
			  <td colspan="2"  align="left" valign="center" class="bodytext31">
			    <div align="center"><?php echo $patientname; ?></div></td>
				<td colspan="2"  align="center" valign="center" class="bodytext31"><?php echo $patientcode; ?></td>
				<td colspan="2"  align="center" valign="center" class="bodytext31"><?php echo $visitcode; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $age; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $gender; ?></td>
                <td  align="center" valign="center" class="bodytext31"><?php echo $shelf; ?></td>
                <td  align="center" valign="center" class="bodytext31"><?php echo $package; ?></td>
				<td  align="center" valign="center" class="bodytext31"><?php echo $accountname; ?></td>
				<input type="hidden" name="wardanum" id="wardanum" value="<?php echo $ward; ?>">
				<input type="hidden" name="bedanum" id="bedanum" value="<?php echo $bed; ?>">
				<input type="hidden" name="patientname" id="patientname" value="<?php echo $patientname; ?>">
				 <input name="frompage" id="frompage" value="<?php echo $frompage; ?>" type="hidden">
				<input type="hidden" name="patientcode" id="patientcode" value="<?php echo $patientcode; ?>">
				<input type="hidden" name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>">
                <input type="hidden" name="shelf" id="shelf" value="<?php echo $shelf; ?>">
                <input type="hidden" name="mortuarydocno" id="mortuarydocno" value="<?php echo $mortuarydocno; ?>">
				<input type="hidden" name="accname" id="accname" value="<?php echo $accountname; ?>">
			   </tr>
		   <?php 
		   } 
		  
		   ?>
           
            <tr>
             	<td colspan="10" align="left" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#cccccc" class="bodytext311">&nbsp;</td><td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
            
             	<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
             	</tr>
          </tbody>
        </table>		</td>
		</tr>
		
		</table>		</td>
		</tr>
	
      
       <tr>
        <td>&nbsp;</td>
		 <td width="3%">&nbsp;</td>
		  <td width="3%">&nbsp;</td>
		<td width="26%" align="right" valign="center" class="bodytext311"> Discharge</td>
		<td width="29%" align="left" valign="center" class="bodytext311"><input type="checkbox" name="readytodischarge"  <?php if($patientcode!='walkin'){?>onClick="return funcFinalBill();" <?php }?>id="readytodischarge" value="1"></td>
        <td  align="left" valign="center" class="bodytext311"><input type="hidden" name="frmflag1" value="frmflag1" />
        <?php 
		if($patientcode!='walkin')
		{
		?>
        <input <?php  if($numfinal==0){echo "disabled";} ?> type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A"  onClick="return funcvalidation()"/>
        <?php
		}
		else
		{
?>
        <input <?php  if($numfinal1!=0){echo "disabled";} ?> type="submit" name="Submit" value="Submit" style="border: 1px solid #001E6A"  onClick="return funcvalidation()"/>

<?php		}
		?>
        </td>
      </tr>
	  <tr>
        <td>&nbsp;</td>
		 <td>&nbsp;</td>
		  <td>&nbsp;</td>
		<td>&nbsp;</td>
		
		
                 
      </tr>
    </table>
  </table>
</form>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

