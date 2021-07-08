<?php
session_start();
error_reporting(0);
//date_default_timezone_set('Asia/Calcutta');
include ("db/db_connect.php");
include ("includes/loginverify.php");
$updatedatetime = date("Y-m-d H:i:s");
$indiandatetime = date ("d-m-Y H:i:s");
$dateonly = date("Y-m-d");
$datetimeonly = date("Y-m-d H:i:s");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];
$timeonly = date("H:i:s");
$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];

//get locationcode to get locationname
 $locationcode=isset($_REQUEST['loccode'])?$_REQUEST['loccode']:'';

$titlestr = 'SALES BILL';


if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{  

//get location and store
 //$locationcodeget=isset($_REQUEST['location'])?$_REQUEST['location']:'';
// $locationnameget=isset($_REQUEST['locationname'])?$_REQUEST['locationname']:'';
 $storecodeget=isset($_REQUEST['storeget'])?$_REQUEST['storeget']:'';
 $locationnameget=isset($_REQUEST['locationnameget'])?$_REQUEST['locationnameget']:'';
		$locationcodeget=isset($_REQUEST['locationcodeget'])?$_REQUEST['locationcodeget']:'';
 
$patientname=$_REQUEST['customername'];

$companyanum = $_SESSION["companyanum"];

$paynowbillprefix = 'EPI-';
$paynowbillprefix1=strlen($paynowbillprefix);
$query2 = "select * from pharmacysales_details where patientcode = 'walkin' and ipdocno='' order by auto_number desc limit 0, 1";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$billnumber = $res2["docnumber"];
$billdigit=strlen($billnumber);
if ($billnumber == '')
{
	$billnumbercode ='EPI-'.'1';
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
	
	
	$billnumbercode = 'EPI-' .$maxanum;
	}
	$docnumber = $billnumbercode;
	$billnumber=$_REQUEST['billnumber'];
foreach($_POST['ref1'] as $key => $value)
		{
		$medicinename=$_POST['medicine'][$key];
		$itemcode=$_POST['itemcode'][$key];
		$quantity=$_POST['issue'][$key];
		$rate=$_POST['rate'][$key];
		$amount=$_POST['amount'][$key];
		$batch=$_POST['batch'][$key];
		$pending=$_POST['pending'][$key];
		$instructions=$_POST['instructions'][$key];
		$fifo_code=$_POST['fifo_code'][$key];
		$query23 = "select * from master_itempharmacy where itemcode = '$itemcode'";
			$exec23 = mysql_query($query23) or die(mysql_error());
			$res23 = mysql_fetch_array($exec23);
			$categoryname = $res23['categoryname'];
			
			$query31 = "select * from master_medicine where itemcode = '$itemcode'"; 
			$exec31 = mysql_query($query31) or die ("Error in Query31".mysql_error());
			$res31 = mysql_fetch_array($exec31);
			$categoryname = $res31['categoryname'];
			$purchaseprice = $res31['purchaseprice'];
			$totalcp = $purchaseprice * $quantity;

		
 // mysql_query("insert into master_stock(itemname,itemcode,quantity,batchnumber,rateperunit,totalrate,companyanum,transactionmodule,transactionparticular)values('$medicine','$itemcode','$quantity',' $batch','$rate','$amount','$companyanum','SALES','BY SALES (BILL NO: $billnumber )')");
   if($medicinename != "")
   {
    $query251 = "select * from pharmacysales_details where itemcode='$itemcode' and fifo_code='$fifo_code' and docnumber='$docnumber' and entrydate='$dateonly'";
   $exec251 = mysql_query($query251) or die(mysql_error());
   $num251 = mysql_num_rows($exec251);
   if($num251 == 0)
   {
	   $querycumstock2 = "select cum_quantity from transaction_stock where cum_stockstatus='1' and itemcode='$itemcode' and locationcode='$locationcodeget' and storecode ='$storecodeget'";
				$execcumstock2 = mysql_query($querycumstock2) or die ("Error in CumQuery2".mysql_error());
				$rescumstock2 = mysql_fetch_array($execcumstock2);
				$cum_quantity = $rescumstock2["cum_quantity"];
				$cum_quantity = $cum_quantity-$quantity;
				if($cum_quantity=='0'){ $cum_stockstatus='0'; }else{$cum_stockstatus='1';}
				//echo $cum_quantity.','.$itemcode.'<br>';
				$aa = 'stock';
				if($aa == 'stock')
				{
					$querybatstock2 = "select batch_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$locationcodeget' and fifo_code='$fifo_code' and storecode ='$storecodeget'";
					$execbatstock2 = mysql_query($querybatstock2) or die ("Error in batQuery2".mysql_error());
					$resbatstock2 = mysql_fetch_array($execbatstock2);
					$bat_quantity = $resbatstock2["batch_quantity"];
					$bat_quantity = $bat_quantity-$quantity;
					$bat_quantity;
					if($bat_quantity=='0'){ $batch_stockstatus='0'; }else{$batch_stockstatus='1';}
					if($bat_quantity>='0')
					{
						$queryupdatebatstock2 = "update transaction_stock set cum_stockstatus='0' ,batch_stockstatus='0' where itemcode='$itemcode' and locationcode='$locationcodeget' and storecode='$storecodeget' and fifo_code='$fifo_code'";
						$execupdatebatstock2 = mysql_query($queryupdatebatstock2) or die ("Error in updatebatQuery2".mysql_error());
						
						$queryupdatebatstock2 = "update transaction_stock set cum_stockstatus='0' where itemcode='$itemcode' and locationcode='$locationcodeget'";
						$execupdatebatstock2 = mysql_query($queryupdatebatstock2) or die ("Error in updatebatQuery2".mysql_error());
						
						$stockquery2="insert into transaction_stock (fifo_code,tablename,itemcode, itemname, transaction_date,transactionfunction,description,
						batchnumber, batch_quantity, 
						transaction_quantity, cum_quantity, entrydocno, docstatus, cum_stockstatus, batch_stockstatus,locationcode,locationname,storecode,storename,username,ipaddress,recorddate,recordtime,updatetime,patientcode,patientvisitcode,patientname,rate,totalprice)
						values ('$fifo_code','pharmacysales_details','$itemcode', '$medicinename', '$dateonly','0', 'Sales', 
						'$batch', '$bat_quantity', '$quantity', 
						'$cum_quantity', '$docnumber', '','$cum_stockstatus','$batch_stockstatus', '$locationcodeget','','$storecodeget', '', '$username', '$ipaddress','$dateonly','$timeonly','$datetimeonly','walkin','walkinvis','$patientname','$rate','$amount')";
						
						$stockexecquery2=mysql_query($stockquery2) or die(mysql_error());
						
						   mysql_query("insert into pharmacysales_details(fifo_code,itemname,itemcode,quantity,rate,totalamount,batchnumber,companyanum,patientcode,visitcode,patientname,financialyear,username,ipaddress,entrydate,billnumber,docnumber,entrytime,location,store,instructions,categoryname,locationname,locationcode,costprice,totalcp)values('$fifo_code','$medicinename','$itemcode','$quantity','$rate','$amount','$batch','$companyanum','walkin','walkinvis','$patientname','$financialyear','$username','$ipaddress','$dateonly','$billnumber','$docnumber','$timeonly','$location1','$storecodeget','$instructions','$categoryname','".$locationnameget."','".$locationcodeget."','$purchaseprice','$totalcp')");
							mysql_query("update master_consultationpharmissue set quantity='$pending',docnumber='$docnumber' where medicinecode='$itemcode' and billnumber='$billnumber'") or die(mysql_error());
								header("location:pharmacylist1.php");
								
									mysql_query("update master_consultationpharmissue set instructions='$instructions' where medicinecode='$itemcode' and billnumber='$billnumber'") or die(mysql_error());
					mysql_query("update master_consultationpharm set instructions='$instructions' where  medicinecode='$itemcode' and billnumber='$billnumber'") or die(mysql_error());
					}
				}
	}
	}
	if($pending == '')
{
	mysql_query("update master_consultationpharm set medicineissue='completed' where medicinecode='$itemcode' and billnumber='$billnumber'");
	}
	
}
foreach($_POST['pending2'] as $key => $value)
		{
		$pending2=$_POST['pending2'][$key];
		$medicinename2=$_POST['medicinename2'][$key];
		
		
			if($pending2 == '')
{
	mysql_query("update master_consultationpharm set medicineissue='completed',docnumber='$docnumber' where medicinename='$medicinename2' and patientvisitcode='$visitcode'");
	}
		
		}	
	header("location:pharmacylist1.php?billnumber=$docnumber");
}

?>

<?php
if (isset($_REQUEST["errcode"])) { $errcode = $_REQUEST["errcode"]; } else { $errcode = ""; }
if($errcode == 'failed')
{
	$errmsg="No Stock";
}
?>
<link rel="stylesheet" type="text/css" href="css/autocomplete.css" />  
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>

<script>
function autochangeins(id)
{
//var id1=$("#ainstructions"+id).val();
    $("#ainstructions"+id).autocomplete({
		
	
	source:"ajaxinewinstruction.php",
	minLength:1,
	matchContains: true,
	delay:false,
	html: true, 
		select: function(event,ui){
			},
			
    });
}


</script>
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
.style1 {
	font-size: 36px;
	font-weight: bold;
}
.style2 {
	font-size: 18px;
	font-weight: bold;
}
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
.style6 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }

</style>
<?php
$patientcode = $_REQUEST["patientcode"];
$visitcode = $_REQUEST["visitcode"];
?>
<script src="js/datetimepicker_css.js"></script>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<?php
 $billnumber = $_REQUEST["billnumber"];
$query55="select * from master_consultationpharmissue where billnumber='$billnumber'";
$exec55=mysql_query($query55) or die(mysql_error());
$res55=mysql_fetch_array($exec55);
$patientname=$res55['patientname'];

 $locationname=$res55['locationname'];
 $locationcode=$res55['locationcode'];

$Querylab=mysql_query("select * from prescription_externalpharmacy where billnumber='$billnumber'");
$execlab=mysql_fetch_array($Querylab);
 $age=$execlab['age'];
 $gender=$execlab['gender'];

$query55 = "select * from master_location where auto_number='$res7locationanum'";
$exec55 = mysql_query($query55) or die(mysql_error());
$res55 = mysql_fetch_array($exec55);
$location = $res55['locationname'];

$querysto = "select * from master_employeelocation where username='$username' AND locationcode = '".$locationcode."' and defaultstore = 'default' order by  storecode ";
$execsto = mysql_query($querysto) or die(mysql_error());
$ressto = mysql_fetch_array($execsto);
	$res7locationanum = $ressto['locationanum'];
	$location = $ressto['locationname'];
    $res7storeanum = $ressto['storecode'];

$query55 = "select * from master_location where auto_number='$res7locationanum'";
$exec55 = mysql_query($query55) or die(mysql_error());
$res55 = mysql_fetch_array($exec55);
$locationname = $res55['locationname'];
$locationcode = $res55['locationcode'];

$query75 = "select * from master_store where auto_number='$res7storeanum'";
$exec75 = mysql_query($query75) or die(mysql_error());
$res75 = mysql_fetch_array($exec75);
$store = $res75['store'];
$storecode = $res75['storecode'];
?>
</head>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />        
<body onLoad="return funcOnLoadBodyFunctionCall();">
 
<form name="frmsales" id="frmsales" method="post" action="externalpharmacy1.php" onKeyDown="return disableEnterKey(event)" onSubmit="document.getElementById('subbutton').disabled=true">
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
               <td bgcolor="#CCCCCC" class="bodytext3"><strong>Patient  </strong></td>
	           <td width="30%" align="left"  class="bodytext3" valign="middle" bgcolor="#CCCCCC"><?php echo $patientname; ?>
				<input type="hidden" name="customername" id="customer" value="<?php echo $patientname; ?>" style="border: 1px solid #001E6A;" size="40" autocomplete="off" readonly/>
                  </td>
                          <td bgcolor="#CCCCCC" class="bodytext3"><input name="latestbillnumber" id="latestbillnumber" value="<?php echo $billnumber; ?>" type="hidden" size="5"> <strong>Date </strong></td>
				
                  <input name="billnumberpostfix" id="billnumberpostfix" value="<?php echo $billnumberpostfix; ?>" style="border: 1px solid #001E6A"  size="5" type="hidden" />
                
                <td width="42%" bgcolor="#CCCCCC" class="bodytext3"><?php echo $dateonly; ?>
               
                  <input name="ADate" id="ADate" style="border: 1px solid #001E6A" type="hidden" value="<?php echo $dateonly; ?>"  size="8"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                 <!-- <img src="images2/cal.gif" style="cursor:pointer"/>-->
				</td>
               
               
              </tr>
				  <tr>

			  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="style4"></span><strong>Age &amp; Gender </strong></td>
			    <td align="left" valign="middle" class="bodytext3"><?php echo $age; ?>
				<input name="patientage" id="patientage" type="hidden" value="<?php echo $age; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly>
				& <?php echo $gender; ?>
				<input type="hidden" name="patientgender" id="patientgender" value="<?php echo $gender; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="5" readonly>
				     </td>
					   <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Bill No</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $billnumber; ?>
				<input name="billnumber" id="billnumber" type="hidden" value="<?php echo $billnumber; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>  <input type="hidden" name="locationcodeget" value="<?php echo $locationcode;?>">
                <input type="hidden" name="locationnameget" value="<?php echo $locationname;?>">
				</td>
			
              	  </tr>
				  
				  <tr>

			  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><span class="style4"></span><strong>Store </strong></td>
			    <td align="left" valign="middle" class="bodytext3"><?php echo $store; ?>
				<input type="hidden" name="storeget" id="storeget" value="<?php echo $storecode; ?>" style="border: 1px solid #001E6A;text-transform: uppercase;"  size="18" readonly>
					     </td>
					   <td width="9%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>Location</strong></td>
                <td colspan="3" align="left" valign="middle" class="bodytext3"><?php echo $locationname; ?>
				<input type="hidden" name="location" id="location" value="<?php echo $locationcode; ?>" style="border: 1px solid #001E6A" size="18" rsize="20" readonly/>
				</td>
			
              	  </tr>
			  
				  <tr>
				  <td width="14%" align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3"><strong>&nbsp;</strong></td>
              
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
             <td width="8%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>&nbsp;</strong></div></td>
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
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount</strong></div></td>
				<td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Instructions</strong></div></td>
				<td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Pending.Qty</strong></div></td>
				      </tr>
				  		<?php
			$colorloopcount = '';
			$sno = '0';
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
$query61 = "select * from master_consultationpharmissue where billnumber='$billnumber' and recordstatus <>'deleted' and quantity <> '$zero' group by medicinename";
$exec61 = mysql_query($query61) or die ("Error in Query1".mysql_error());
$numb=mysql_num_rows($exec61);
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
 $res1medicinename =addslashes($res1medicinename);
$res1dose = $res61["dose"];
$res1frequency = $res61["frequencynumber"];
$res1days = $res61["days"];
$res1quantity = $res61["quantity"];
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
$query77 = "select itemcode,batchnumber,batch_quantity,description,fifo_code from transaction_stock where storecode='".$storecode."' AND locationcode='".$locationcode."' AND itemcode = '$itemcode' and batch_stockstatus='1'";
//echo $query57;
$res77=mysql_query($query77);
$num77=mysql_num_rows($res77);
//echo $num57;
while($exec77 = mysql_fetch_array($res77))
{
$batchname = $exec77['batchnumber']; 
//echo $batchname;
$currentstock = $exec77["batch_quantity"];
$fifo_code = $exec77["fifo_code"];
$companyanum = $_SESSION["companyanum"];
			$itemcode = $itemcode;
			$batchname = $batchname;
	//include ('autocompletestockbatch.php');
	$currentstock = $currentstock; 
	$totalst=$totalst+$currentstock;
	
	}
	
if($totalst == 0)
{
?>
  <tr>
  		<td class="bodytext31" valign="center"  align="left"><div align="center">
        <input type="checkbox" disabled name="ref1[]" id="ref<?php echo $sno; ?>" value="<?php echo $sno; ?>" onClick="return checkboxcheck1"/></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res1medicinename;?></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res1dose;?></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res1frequency;?></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res1days;?></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res3quantity;?></div></td>
        <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '0';?></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res1quantity;?></div></td>
		<input type="hidden" name="pending2[]" value="<?php echo $res1quantity;?>">
				  <input type="hidden" name="medicinename2[]" value="<?php echo $res1medicinename;?>">
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
$query23 = "select * from master_employeelocation where username='$username'";
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

$query57 = "select itemcode,batchnumber,batch_quantity,description,fifo_code from transaction_stock where storecode='".$storecode."' AND locationcode='".$locationcode."' AND itemcode = '$itemcode' and batch_stockstatus='1'";
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
$currentstock = $exec57["batch_quantity"];
$fifo_code = $exec57["fifo_code"];
$companyanum = $_SESSION["companyanum"];
			$itemcode = $itemcode;
			$batchname = $batchname;
	//include ('autocompletestockbatch.php');
	$currentstock = $currentstock;
	
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
// $res1medicinename1='';
 $res1dose='';
 $res1frequency='';
 $res1days='';
 
 }
 $oldmedicinename=$res1medicinename;
 ?>
			  <tr>
              <td class="bodytext31" valign="center"  align="left"><div align="center">
        <input type="checkbox" name="ref1[]" id="ref<?php echo $sno; ?>" value="<?php echo $sno; ?>" onClick="return checkboxcheck1"/></div></td>
			 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res1medicinename1;?></div></td>
			 <input type="hidden" name="medicine[]" value="<?php echo $res1medicinename;?>" />
			 <input type="hidden" name="itemcode[]" value="<?php echo $itemcode; ?>" />
             <input type="hidden" name="fifo_code[]" value="<?php echo $fifo_code; ?>" />
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
                 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res1amount;?></div></td>
			 	 <td class="bodytext31" valign="center"  align="left"> <input type="text" name="instructions[]"  onFocus="return autochangeins(<?= $sno;?>)" id="ainstructions<?php echo $sno; ?>" value="<?php echo $instructions ;?>" size="25" align="absmiddle"></div></td>
                 <input type="hidden" name="currentstock" value="<?php echo $currentstock;?>">
				 	 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pending; ?></div></td>
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
             	  <input name="Submit2223" type="submit" id="subbutton" onClick="return funcSaveBill1()" value="Save " accesskey="b" class="button"/>
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