<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$timeonly = date("H:i:s");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];

$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];

$titlestr = 'SALES BILL';

$query231 = "select * from master_employee where username='$username'";
$exec231 = mysql_query($query231) or die(mysql_error());
$res231 = mysql_fetch_array($exec231);
$res7locationanum1 = $res231['location'];

$query551 = "select * from master_location where auto_number='$res7locationanum1'";
$exec551 = mysql_query($query551) or die(mysql_error());
$res551 = mysql_fetch_array($exec551);
$location1 = $res551['locationname'];

$res7storeanum1 = $res231['store'];

$query751 = "select * from master_store where auto_number='$res7storeanum1'";
$exec751 = mysql_query($query751) or die(mysql_error());
$res751 = mysql_fetch_array($exec751);
$store1 = $res751['store'];

if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{   
$patientcode=$_REQUEST['patientcode'];
$visitcode=$_REQUEST['visitcode'];
$companyanum = $_SESSION["companyanum"];
$patientname=$_REQUEST['customername'];
$paynowbillprefix = 'PI-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from pharmacysales_details where patientcode <> 'walkin' and ipdocno='' order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docnumber"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='PI-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["docnumber"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	//echo $billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'PI-' .$maxanum;
	}
	$docnumber = $billnumbercode;
$accountname=$_REQUEST['account'];
foreach($_POST['medicine'] as $key => $value)
		{
		$medicinename=$_POST['medicine'][$key];
		$itemcode=$_POST['itemcode'][$key];
		$quantity=$_POST['issue'][$key];
		$rate=$_POST['rate'][$key];
		$amount=$rate * $quantity;
		$batch=$_POST['batch'][$key];
		$pending=$_POST['pending'][$key];
		$route = $_POST['route'][$key];
		$instructions=$_POST['instructions'][$key];
		
			$query31 = "select * from master_itempharmacy where itemcode = '$itemcode'"; 
			$exec31 = mysql_query($query31) or die ("Error in Query31".mysql_error());
			$res31 = mysql_fetch_array($exec31);
			$categoryname = $res31['categoryname'];
					
 // mysql_query("insert into master_stock(itemname,itemcode,quantity,batchnumber,rateperunit,totalrate,companyanum,transactionmodule,transactionparticular)values('$medicine','$itemcode','$quantity',' $batch','$rate','$amount','$companyanum','SALES','BY SALES (BILL NO: $billnumber )')");
   if($medicinename != "")
   {
   
   $query32 = "insert into pharmacysales_details(itemname,itemcode,quantity,rate,totalamount,batchnumber,companyanum,patientcode,visitcode,patientname,financialyear,username,ipaddress,entrydate,accountname,docnumber,entrytime,location,store,instructions,categoryname,route)values('$medicinename','$itemcode','$quantity','$rate','$amount','$batch','$companyanum','$patientcode','$visitcode','$patientname','$financialyear','$username','$ipaddress','$dateonly','$accountname','$docnumber','$timeonly','$location1','$store1','$instructions','$categoryname','$route')";
   $exec32 = mysql_query($query32) or die(mysql_error());
	mysql_query("update master_consultationpharmissue set quantity='$pending',docnumber='$docnumber' where medicinecode='$itemcode' and patientvisitcode='$visitcode'") or die(mysql_error());
		//header("location:pharmacylist1.php");
	}
	if($pending == '')
{
	mysql_query("update master_consultationpharm set medicineissue='completed' and docnumber='$docnumber' where medicinecode='$itemcode' and patientvisitcode='$visitcode'");
	}
	
}
	header("location:pharmacylist1.php?patientcode=$patientcode&&visitcode=$visitcode&&billnumber=$docnumber");
	exit();
}

?>

<?php
if (isset($_REQUEST["errcode"])) { $errcode = $_REQUEST["errcode"]; } else { $errcode = ""; }
if($errcode == 'failed')
{
	$errmsg="No Stock";
}
?>




<style type="text/css">
.bodytext3 {	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext312 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
body {
	margin-left: 0px;
	margin-top: 0px;
	background-color: #E0E0E0;
}
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
</style>
<?php
$patientcode = $_REQUEST["patientcode"];
$visitcode = $_REQUEST["visitcode"];
?>
<script src="js/datetimepicker_css.js"></script>
<?php
$query65= "select * from master_visitentry where patientcode='$patientcode'";
$exec65=mysql_query($query65) or die("error in query65".mysql_error());
$res65=mysql_fetch_array($exec65);
$Patientname=$res65['patientfullname'];

$query69="select * from master_customer where customercode='$patientcode'";
$exec69=mysql_query($query69) or die(mysql_error());
$res69=mysql_fetch_array($exec69);
$patientage=$res69['age'];
$patientgender=$res69['gender'];
$patientaccount=$res69['accountname'];

$query70="select * from master_accountname where auto_number='$patientaccount'";
$exec70=mysql_query($query70);
$res70=mysql_fetch_array($exec70);
$accountname=$res70['accountname'];

$query23 = "select * from master_employee where username='$username'";
$exec23 = mysql_query($query23) or die(mysql_error());
$res23 = mysql_fetch_array($exec23);
$res7locationanum = $res23['location'];

$query55 = "select * from master_location where auto_number='$res7locationanum'";
$exec55 = mysql_query($query55) or die(mysql_error());
$res55 = mysql_fetch_array($exec55);
$location = $res55['locationname'];

$res7storeanum = $res23['store'];

$query75 = "select * from master_store where auto_number='$res7storeanum'";
$exec75 = mysql_query($query75) or die(mysql_error());
$res75 = mysql_fetch_array($exec75);
$store = $res75['store'];

?>
<?php
$query3 = "select * from master_company where companystatus = 'Active'";
$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
$res3 = mysql_fetch_array($exec3);
$paynowbillprefix = 'PI-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from pharmacysales_details where patientcode <> 'walkin' and ipdocno='' order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docnumber"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='PI-'.'1';
	$openingbalance = '0.00';
}
else
{
	$billnumber = $res2["docnumber"];
	$billnumbercode = substr($billnumber,$paynowbillprefix1, $billdigit);
	$billnumbercode;
	$billnumbercode = intval($billnumbercode);
	$billnumbercode = $billnumbercode + 1;

	$maxanum = $billnumbercode;
	
	
	$billnumbercode = 'PI-' .$maxanum;
	$openingbalance = '0.00';
	//echo $companycode;
}
?>
</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />      
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="frmsales" id="frmsales" method="post" action="pharmacy1.php" onKeyDown="return disableEnterKey(event)">
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
<!--  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
-->
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="980" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td colspan="4" align="left" valign="middle"  bgcolor="<?php if ($errmsg == '') { echo '#FFFFFF'; } else { echo 'red'; } ?>" class="bodytext3"><strong><?php echo $errmsg;?>&nbsp;</strong></td></tr>
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
            <tbody>
              <tr bgcolor="#011E6A">
              
                    <input name="billnumberprefix" id="billnumberprefix" value="<?php echo $billnumberprefix; ?>" type="hidden" style="border: 1px solid #001E6A"  size="5" /> 
                    <input type="hidden" name="patientcode" value="<?php echo $patientcode; ?>">
               <td bgcolor="#CCCCCC" class="bodytext31"><strong>Patient  </strong></td>
	           <td width="26%" align="left" valign="middle" class="bodytext3" bgcolor="#CCCCCC"><?php echo $Patientname; ?>
				<input name="customername" id="customer" type="hidden" value="<?php echo $Patientname; ?>"  size="40" autocomplete="off" readonly/>                  </td>
                          <td bgcolor="#CCCCCC" class="bodytext3"><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5"> <strong>Date </strong></td>
				
                  <input name="billnumberpostfix" id="billnumberpostfix" value="<?php echo $billnumberpostfix; ?>" style="border: 1px solid #001E6A"  size="5" type="hidden" />
                
                <td width="27%" bgcolor="#CCCCCC" class="bodytext3"><?php echo $dateonly; ?>
               
                  <input name="ADate" id="ADate" style="border: 1px solid #001E6A" type="hidden" value="<?php echo $dateonly; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" /></td>
               
                <td width="9%" align="left" valign="middle"  bgcolor="#CCCCCC" class="bodytext3"><strong>Doc No</strong></td>
                <td width="20%" align="left" valign="middle" class="bodytext3" bgcolor="#CCCCCC"><?php echo $billnumbercode; ?>
			<input name="docnumber" id="docnumber" value="<?php echo $billnumbercode; ?>" type="hidden" style="border: 1px solid #001E6A" size="8" rsize="20" readonly/>                  </td>
              </tr>
			 
		
			  <tr>

			    <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Visit No </strong></td>
                <td width="26%" align="left" valign="middle" class="bodytext3"><?php echo $visitcode; ?>
			<input name="visitcode" id="visitcode" value="<?php echo $visitcode; ?>" type="hidden" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>                  </td>
                 <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Reg.No</strong></td>
                 <td align="left" valign="middle" class="bodytext3"><?php echo $patientcode; ?>
				<input name="customercode" id="customercode" type="hidden" value="<?php echo $patientcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				
				<!--<textarea name="deliveryaddress" cols="25" rows="3" id="deliveryaddress" style="border: 1px solid #001E6A"><?php //echo $res41deliveryaddress; ?></textarea>--></td>
             
			    <td align="left" valign="middle" class="bodytext3"><strong>Location</strong></td>
			    <td align="left" valign="middle" class="bodytext3"><?php echo $location; ?><input  name="location" type="hidden" value="<?php echo $location; ?>" size="18" style="border: 1px solid #001E6A" readonly></td>
			  </tr>
				  <tr>

			  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="style4"></span><strong>Age &amp; Gender </strong></td>
			    <td align="left" valign="middle" class="bodytext3"><?php echo $patientage; ?>
				<input type="hidden" name="patientage" id="patientage" value="<?php echo $patientage; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly>
				&  <?php echo $patientgender; ?>
				<input type="hidden" name="patientgender" id="patientgender" value="<?php echo $patientgender; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly>				     </td>
                <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Account</strong></td>
                <td align="left" valign="middle" class="bodytext3"><?php echo $accountname; ?>
				<input name="account" id="account" type="hidden" value="<?php echo $accountname; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>				                  
                <td align="left" valign="middle" class="bodytext3"><strong>Store</strong></td>           
                <td align="left" valign="middle" class="bodytext3"><?php echo $store; ?><input type="hidden" name="store" value="<?php echo $store; ?>" size="18" style="border: 1px solid #001E6A" readonly>  </td>           
				  </tr>
			    
			   
				  <tr>
				  <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>&nbsp;</strong></td>
				  </tr>
            </tbody>
        </table></td>
      </tr>
      
      <tr>
        <td>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="2" width="99%" 
            align="left" border="0">
          <tbody id="foo">
            <tr>
              <td width="18%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Medicine Name</strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Dose</strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Frequency</strong></div></td>
					<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Days</strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Pres.Qty</strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Batch.No</strong></div></td>
						<td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Iss.Qty</strong></div></td>
				<td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Route</strong></div></td>
				<td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Instructions</strong></div></td>
				<td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Pending.Qty</strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"></div></td>
			      </tr>
				  		<?php
			$colorloopcount = '';
			$sno = '';
			$totalamount=0;		
			$zero=0;	
			$query23 = "select * from master_employee where username='$username'";
$exec23 = mysql_query($query23) or die(mysql_error());
$res23 = mysql_fetch_array($exec23);
$res7locationanum = $res23['location'];

$query55 = "select * from master_location where auto_number='$res7locationanum'";
$exec55 = mysql_query($query55) or die(mysql_error());
$res55 = mysql_fetch_array($exec55);
$location = $res55['locationname'];

$res7storeanum = $res23['store'];

$query75 = "select * from master_store where auto_number='$res7storeanum'";
$exec75 = mysql_query($query75) or die(mysql_error());
$res75 = mysql_fetch_array($exec75);
$store = $res75['store'];
			$query61 = "select * from master_consultationpharmissue where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and recordstatus <>'deleted' and quantity <> '$zero' and paymentstatus='completed' group by medicinename";
$exec61 = mysql_query($query61) or die ("Error in Query1".mysql_error());
$numb=mysql_num_rows($exec61);
//echo $numb;
while($res61 = mysql_fetch_array($exec61))
{
$res1medicinename1='';
$oldmedicinename='';
$totalstock=0;
$oldstock=0;
$i=0;
$totalst=0;
$pending='';
$res1medicinename =$res61["medicinename"];
$res1dose = $res61["dose"];
$res1frequency = $res61["frequencynumber"];
$res1days = $res61["days"];
$res1quantity = $res61["quantity"];
$res1route = $res61["route"];
$res3quantity = $res61["prescribed_quantity"];
$res1rate = $res61["rate"];
$res1amount = $res61["amount"];
$instructions = $res61['instructions'];
$res1medicinename=trim($res1medicinename);
$query49="select * from master_itempharmacy where itemname='$res1medicinename'";
$res49=mysql_query($query49);
$nummm=mysql_num_rows($res49);
$exec49=mysql_fetch_array($res49);
$itemcode=$exec49['itemcode'];
$query77 = "select * from purchase_details where itemcode='$itemcode'";
//echo $query57;
$res77=mysql_query($query77);
$num77=mysql_num_rows($res77);
//echo $num77;
while($exec77 = mysql_fetch_array($res77))
{
$batchname = $exec77['batchnumber']; 
//echo $batchname;
$companyanum = $_SESSION["companyanum"];
			$itemcode = $itemcode;
			$batchname = $batchname;
	include ('autocompletestockbatch.php');
	$currentstock = $currentstock; 
	$totalst=$totalst+$currentstock;
	//echo $totalst;
	}
	//echo $totalst;
if($totalst == 0)
{
?>
  <tr>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res1medicinename;?></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res1dose;?></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res1frequency;?></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res1days;?></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res3quantity;?></div></td>
		
		<td class="bodytext31" valign="center"  align="left"><div align="center"></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res1route;?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res1quantity;?></div></td>
		 <td class="bodytext31" valign="center"  align="center">
                 <input type="hidden" name="pending" value=""></td>
				</tr>

<?php
}
else
{
$i=0;
$loopcontrol='';
$query23 = "select * from master_employee where username='$username'";
$exec23 = mysql_query($query23) or die(mysql_error());
$res23 = mysql_fetch_array($exec23);
$res7locationanum = $res23['location'];

$query55 = "select * from master_location where auto_number='$res7locationanum'";
$exec55 = mysql_query($query55) or die(mysql_error());
$res55 = mysql_fetch_array($exec55);
$location = $res55['locationname'];

$res7storeanum = $res23['store'];

$query75 = "select * from master_store where auto_number='$res7storeanum'";
$exec75 = mysql_query($query75) or die(mysql_error());
$res75 = mysql_fetch_array($exec75);
$store = $res75['store'];
$query35=mysql_query("select * from master_itempharmacy where itemname='$res1medicinename'");
$exec35=mysql_fetch_array($query35);
$itemcode=$exec35['itemcode'];
$query36=mysql_query("select * from purchase_details where itemname='$res1medicinename'");
$exec36=mysql_fetch_array($query36);
$batch=$exec36['batchnumber'];
$query38 = mysql_query("select * from purchase_details where itemname='$res1medicinename' ");
$rowcount=mysql_num_rows($query38);
$query57 = "select * from purchase_details where itemcode='$itemcode'";
//echo $query57;
$res57=mysql_query($query57);
$num57=mysql_num_rows($res57);
//echo $num57;
while($exec57 = mysql_fetch_array($res57))
{
if($loopcontrol != 'stop')
{
$batchname = $exec57['batchnumber']; 
//echo $batchname;
$companyanum = $_SESSION["companyanum"];
			$itemcode = $itemcode;
			$batchname = $batchname;
	include ('autocompletestockbatch.php');
	$currentstock = $currentstock;
	//echo $currentstock;
	if($currentstock > 0 )
	{
$totalstock = $totalstock+$currentstock;
if($totalstock >= $res1quantity)
{

$issuequantity = $res1quantity-$oldstock;
}
 else
 {
 $issuequantity = $currentstock;
 $oldstock = $oldstock+$currentstock;

 $pending=$res1quantity-$oldstock;

 }	
 $res1medicinename1=$res1medicinename;
 if($oldmedicinename == $res1medicinename)
 {
 $res1medicinename1='';
 $res1dose='';
 $res1frequency='';
 $res1days='';
 
 }
 $oldmedicinename=$res1medicinename;
 ?>
			  <tr>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res1medicinename1;?></div></td>
			 <input type="hidden" name="medicine[]" value="<?php echo $res1medicinename;?>" />
			 <input type="hidden" name="itemcode[]" value="<?php echo $itemcode; ?>" />
			    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res1dose;?></div></td>
					    <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res1frequency;?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res1days;?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res3quantity;?></div></td>
			 <input type="hidden" name="quantity[]" value="<?php echo $res1quantity;?>" />

			 	 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $batchname;?></div></td>
					 <input type="hidden" name="batch[]" value="<?php echo $batchname;?>" />
				<input type="hidden" name="rate[]" value="<?php echo $res1rate;?>" />
				<input type="hidden" name="pending[]" value="<?php echo $pending; ?>">
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $issuequantity;?></div></td>
				 <input type="hidden" name="amount[]" value="<?php echo$res1amount;?>" />
				 <input type="hidden" name="issue[]" value="<?php echo $issuequantity;?>">
				 			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res1route;?></div></td>
			 <input type="hidden" name="route[]" value="<?php echo $res1route;?>" />
		
			 	 <td class="bodytext31" valign="center"  align="left"> <input type="text" name="instructions[]" value="<?php echo $instructions ;?>" size="25" align="absmiddle"></div></td>
                 <input type="hidden" name="currentstock" value="<?php echo $currentstock;?>">
				 	 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pending; ?></div></td>
				 <td class="bodytext31" valign="center"  align="center">
                 <input type="hidden" name="pending" value=""></td>
				  	</tr>
			<?php 
			if($totalstock >= $res1quantity)
			{
			$loopcontrol = 'stop';
			}
		
			}
			}
			}
			}

			}
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
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
       
             </tr>
           
          </tbody>
        </table>		</td>
      </tr>
      
      
      
      <tr>
        <td><table width="99%" border="0" align="left" cellpadding="2" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr>
              <td width="54%" align="right" valign="top" >
                     <input name="frm1submit1" id="frm1submit1" type="hidden" value="frm1submit1">
             	  <input name="Submit2223" type="submit" onClick="return funcPrintBill()" value="Save " accesskey="b" class="button" />
               </td>
              
            </tr>
          </tbody>
        </table></td>
      </tr>
    </table>
  </table>

</form>
<?php include ("includes/footer1.php"); ?>
<?php //include ("print_bill_dmp4inch1.php"); ?>
</body>
</html>