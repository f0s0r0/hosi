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
$datetimeonly = date("Y-m-d H:i:s");
$username = $_SESSION["username"];
$ipaddress = $_SERVER["REMOTE_ADDR"];

$companyname = $_SESSION["companyname"];
$financialyear = $_SESSION["financialyear"];

//get locationcode to get locationname
 $locationcode=isset($_REQUEST['loccode'])?$_REQUEST['loccode']:'';

$titlestr = 'SALES BILL';


if (isset($_REQUEST["frm1submit1"])) { $frm1submit1 = $_REQUEST["frm1submit1"]; } else { $frm1submit1 = ""; }
if ($frm1submit1 == 'frm1submit1')
{   

//get location and store
 $locationcodeget=isset($_REQUEST['location'])?$_REQUEST['location']:'';
 $locationnameget=isset($_REQUEST['locationname'])?$_REQUEST['locationname']:'';
 $storecodeget=isset($_REQUEST['store'])?$_REQUEST['store']:'';

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
$totalpending = 0;
		foreach($_POST['ref'] as $key => $value)
		{ 
		 
		 $key=$key-1;
		 $refnumber=$_POST['refnumber'][$key];
			$medicinename=$_POST['medicine'][$key];
			$itemcode=$_POST['itemcode'][$key];
			$quantity=$_POST['issue'][$key];
			$rate=$_POST['rate'][$key];
			$amount=$rate * $quantity;
			$batch=$_POST['batch'][$key];
			$pending=$_POST['pending1'][$key];
			$route = $_POST['route'][$key];
			$instructions=$_POST['instructions'][$key];
			$fifo_code=$_POST['fifo_code'][$key];
			
			$query31 = "select * from master_medicine where itemcode = '$itemcode'"; 
			$exec31 = mysql_query($query31) or die ("Error in Query31".mysql_error());
			$res31 = mysql_fetch_array($exec31);
			$categoryname = $res31['categoryname'];
			$purchaseprice = $res31['purchaseprice'];
			$totalcp = $purchaseprice * $quantity;
						//echo '<br>';
	 // mysql_query("insert into master_stock(itemname,itemcode,quantity,batchnumber,rateperunit,totalrate,companyanum,transactionmodule,transactionparticular)values('$medicine','$itemcode','$quantity',' $batch','$rate','$amount','$companyanum','SALES','BY SALES (BILL NO: $billnumber )')");
	   if($medicinename != "")
	   {   
		   $query251 = "select * from pharmacysales_details where itemcode='$itemcode' and fifo_code='$fifo_code' and visitcode='$visitcode' and docnumber='$docnumber' and entrydate='$dateonly'";
		   $exec251 = mysql_query($query251) or die(mysql_error());
		   $num251 = mysql_num_rows($exec251);
		   if($num251 == 0)
		   {
			   
				$querycumstock2 = "select sum(cum_quantity) as cum_quantity from transaction_stock where batch_stockstatus='1' and itemcode='$itemcode' and locationcode='$locationcodeget' and storecode ='$storecodeget'";
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
					//echo $bat_quantity.','.$itemcode.'<br>'; 
					if($bat_quantity=='0'){ $batch_stockstatus='0'; }else{$batch_stockstatus='1';}
					if($bat_quantity>='0')
					{
						$queryupdatebatstock2 = "update transaction_stock set cum_stockstatus='0' ,batch_stockstatus='0' where itemcode='$itemcode' and locationcode='$locationcodeget' and storecode='$storecodeget' and fifo_code='$fifo_code'";
						$execupdatebatstock2 = mysql_query($queryupdatebatstock2) or die ("Error in updatebatQuery2".mysql_error());
						
						//$queryupdatebatstock2 = "update transaction_stock set cum_stockstatus='0' where itemcode='$itemcode' and locationcode='$locationcodeget'";
						//$execupdatebatstock2 = mysql_query($queryupdatebatstock2) or die ("Error in updatebatQuery2".mysql_error());
						
						$stockquery2="insert into transaction_stock (fifo_code,tablename,itemcode, itemname, transaction_date,transactionfunction,description,
						batchnumber, batch_quantity, 
						transaction_quantity, cum_quantity, entrydocno, docstatus, cum_stockstatus, batch_stockstatus,locationcode,locationname,storecode,storename,username,ipaddress,recorddate,recordtime,updatetime,patientcode,patientvisitcode,patientname,rate,totalprice)
						values ('$fifo_code','pharmacysales_details','$itemcode', '$medicinename', '$dateonly','0', 'Sales', 
						'$batch', '$bat_quantity', '$quantity', 
						'$cum_quantity', '$docnumber', '','$cum_stockstatus','$batch_stockstatus', '$locationcodeget','','$storecodeget', '', '$username', '$ipaddress','$dateonly','$timeonly','$datetimeonly','$patientcode','$visitcode','$patientname','$rate','$amount')";
						
						$stockexecquery2=mysql_query($stockquery2) or die(mysql_error());
						
						$query32 = "insert into pharmacysales_details(fifo_code,itemname,itemcode,quantity,rate,totalamount,batchnumber,companyanum,patientcode,visitcode,patientname,financialyear,username,ipaddress,entrydate,accountname,docnumber,entrytime,location,store,instructions,categoryname,route,locationname,locationcode,costprice,totalcp)values('$fifo_code','$medicinename','$itemcode','$quantity','$rate','$amount','$batch','$companyanum','$patientcode','$visitcode','$patientname','$financialyear','$username','$ipaddress','$dateonly','$accountname','$docnumber','$timeonly','$location1','".$storecodeget."','$instructions','$categoryname','$route','".$locationnameget."','".$locationcodeget."','$purchaseprice','$totalcp')";
						$exec32 = mysql_query($query32) or die(mysql_error());
						mysql_query("update master_consultationpharmissue set quantity='$pending',docnumber='$docnumber' where medicinecode='$itemcode' and patientvisitcode='$visitcode' and refno='$refnumber'") or die(mysql_error());
						
					mysql_query("update master_consultationpharmissue set instructions='$instructions' where medicinecode='$itemcode' and patientvisitcode='$visitcode' and refno='$refnumber'") or die(mysql_error());
					mysql_query("update master_consultationpharm set instructions='$instructions' where medicinecode='$itemcode' and patientvisitcode='$visitcode' and refno='$refnumber'") or die(mysql_error());
						
					}
					else
					{
						//exit;
					}
				}
				else
				{
					//exit;
				}
				
			//header("location:pharmacylist1.php");
			}
		}// exit;
		if($pending == '')
		{
		
		mysql_query("update master_consultationpharm set medicineissue='completed',docnumber='$docnumber' where medicinecode='$itemcode' and patientvisitcode='$visitcode' and refno='$refnumber'");
		}
	
	}// exit;
	
	foreach($_POST['pending2'] as $key => $value)
	{
		$pending2=$_POST['pending2'][$key];
		$medicinename2=$_POST['medicinename2'][$key];		
		if($pending2 == '')
		{
			mysql_query("update master_consultationpharm set medicineissue='pending',docnumber='$docnumber' where medicinename='$medicinename2' and patientvisitcode='$visitcode' and refno='$refnumber'");
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

<script src="jquery/jquery-1.11.3.min.js"></script>
<script>
$(document).ready(function(){

var count = $("[type='checkbox']:checked").length;
if(count==0)
$('#subbutton').attr('disabled','disabled');
else
$('#subbutton').attr('disabled',false);

$("input[type='checkbox']").change(function(){
var count = $("[type='checkbox']:checked").length;
if(count==0)
$('#subbutton').attr('disabled','disabled');
else
$('#subbutton').attr('disabled',false);
});

});
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
.style4 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma; }
</style>
<?php
$patientcode = $_REQUEST["patientcode"];
$visitcode = $_REQUEST["visitcode"];
?>
<script type="text/javascript" src="js/disablebackenterkey.js"></script>
<script src="js/datetimepicker_css.js"></script>
<?php
$query65= "select * from master_visitentry where patientcode='$patientcode'";
$exec65=mysql_query($query65) or die("error in query65".mysql_error());
$res65=mysql_fetch_array($exec65);
$Patientname=$res65['patientfullname'];

$query69="select * from master_customer where customercode='$patientcode'";
$exec69=mysql_query($query69) or die(mysql_error());
$res69=mysql_fetch_array($exec69);
$dob = $res69['dateofbirth'];
$patientage = calculate_age($dob);
$billtype = $res69['billtype'];

$patientgender=$res69['gender'];
$patientaccount=$res69['accountname'];

$query70="select * from master_accountname where auto_number='$patientaccount'";
$exec70=mysql_query($query70);
$res70=mysql_fetch_array($exec70);
$accountname=$res70['accountname'];

if(isset($_REQUEST['store'])){ $defaultstore = $_REQUEST['store']; } else { $defaultstore = ''; }
if($defaultstore == '')
{
$querysto = "select storecode,locationanum from master_employeelocation where username='$username' AND locationcode = '".$locationcode."' and defaultstore='default' order by  storecode desc";
}
else
{
$querysto = "select storecode,locationanum from master_employeelocation where username='$username' AND locationcode = '".$locationcode."' and storecode='$defaultstore' order by  storecode desc";
}
$execsto = mysql_query($querysto) or die(mysql_error());
while ($ressto = mysql_fetch_array($execsto))
{
    $res7storeanum = $ressto['storecode'];
	$res7locationanum = $ressto['locationanum'];
}


$query55 = "select * from master_location where auto_number='$res7locationanum'";
$exec55 = mysql_query($query55) or die(mysql_error());
$res55 = mysql_fetch_array($exec55);
$locationname = $res55['locationname']; 
$locationcode = $res55['locationcode']; 

//$res7storeanum = $res23['store'];

$query75 = "select ms.store,ms.storecode from master_store as ms where auto_number='$res7storeanum'";
$exec75 = mysql_query($query75) or die(mysql_error());
$res75 = mysql_fetch_array($exec75);
   $store = $res75['store'];
   $storecode = $res75['storecode'];
/*$query61 = "select * from master_consultationpharmissue where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and recordstatus <>'deleted' and quantity <> '$zero' and paymentstatus='completed'";*/
function calculate_age($birthday)
{
    $today = new DateTime();
    $diff = $today->diff(new DateTime($birthday));

    if ($diff->y)
    {
        return $diff->y . ' Years';
    }
    elseif ($diff->m)
    {
        return $diff->m . ' Months';
    }
    else
    {
        return $diff->d . ' Days';
    }
}

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
<script type="text/javascript">
function Redirect(patientcode,visitcode,location)
{
var patientcode = patientcode;
var visitcode = visitcode;
var location = location;

var Store = document.getElementById("store").value;

<?php
$query10 = "select * from master_store";
$exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());
while($res10 = mysql_fetch_array($exec10))
{
$res10storecode = $res10['storecode'];
$res10storeanum = $res10['auto_number'];
?>
if(document.getElementById("store").value == "<?php echo $res10storecode; ?>")
{
//alert("<?php echo $res10storeanum; ?>");
var Storeanum = "<?php echo $res10storeanum; ?>";
window.location = "pharmacy1.php?patientcode="+patientcode+"&&visitcode="+visitcode+"&&loccode="+location+"&&store="+Storeanum;
}
<?php
}
?>
//window.location = "pharmacy1.php?patientcode="+patientcode+"&&visitcode="+visitcode+"&&loccode="+location+"&&store="+Store;

}

</script>  
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
 
<body onLoad="return funcOnLoadBodyFunctionCall();">
<form name="frmsales" id="frmsales" method="post" action="pharmacy1.php" onKeyDown="return disableEnterKey(event)" onSubmit="document.getElementById('subbutton').disabled=true">
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
			    <td align="left" valign="middle" class="bodytext3"><?php echo $locationname; ?><input  name="location" type="hidden" value="<?php echo $locationcode; ?>" size="18" style="border: 1px solid #001E6A" readonly><input  name="locationname" type="hidden" value="<?php echo $locationname; ?>" size="18" style="border: 1px solid #001E6A" readonly></td>
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
                <td align="left" valign="middle" class="bodytext3"> 
				<select name="store" id="store" onChange="return Redirect('<?php echo $patientcode; ?>','<?php echo $visitcode; ?>','<?php echo $locationcode; ?>')">
				<?php if($storecode != '') { ?>
				<option value="<?php echo $storecode; ?>"><?php echo $store; ?></option>
				<?php } ?>
				<?php 
				$query9 = "select * from master_employeelocation where username = '$username' and locationcode = '$locationcode'";
				$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
				while($res9 = mysql_fetch_array($exec9))
				{
				$res9anum = $res9['storecode'];
				$res9default = $res9['defaultstore'];
				
				$query10 = "select * from master_store where auto_number = '$res9anum'";
				$exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());
				$res10 = mysql_fetch_array($exec10);
				$res10storecode = $res10['storecode'];
				$res10store = $res10['store'];
				$res10anum = $res10['auto_number'];
				?>
				<option value="<?php echo $res10storecode; ?>"><?php echo $res10store; ?></option>
				<?php } ?>
				</select>
				 </td>           
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
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Avl .Qty</strong></div></td>
						<td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Iss.Qty</strong></div></td>
                		<td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Amount</strong></div></td>
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
			$query23 = "select * from master_employeelocation where username='$username' and defaultstore = 'default' and locationcode='$locationcode'";
$exec23 = mysql_query($query23) or die(mysql_error());
$res23 = mysql_fetch_array($exec23);
 $location = $res23['locationname'];
 $res7locationanum = $res23['locationcode'];
 $res7storeanum = $res23['storecode'];

/*$query55 = "select * from master_location where locationcode='$res7locationanum'";
$exec55 = mysql_query($query55) or die(mysql_error());
$res55 = mysql_fetch_array($exec55);
$location = $res55['locationname'];
*/


$query75 = "select * from master_store where auto_number='$res7storeanum'";
$exec75 = mysql_query($query75) or die(mysql_error());
$res75 = mysql_fetch_array($exec75);
 $storename = $res75['store'];

if($billtype == 'PAY NOW')
{
			$query61 = "select * from master_consultationpharmissue where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and recordstatus <>'deleted' and quantity <> '$zero' and paymentstatus='completed'";
}
else
{
			$query61 = "select * from master_consultationpharmissue where patientcode = '$patientcode' and patientvisitcode = '$visitcode' and recordstatus <>'deleted' and quantity <> '$zero' and paymentstatus='completed' ";
}
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
$res1medicinename =addslashes($res1medicinename);
$refnumber=$res61["refno"];
 $itemcode =$res61['medicinecode'];
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
$excludestatus=$res61['excludestatus'];
			$excludebill = $res61['excludebill'];
			
$query49="select * from master_itempharmacy where itemname='$res1medicinename'";
$res49=mysql_query($query49);
$nummm=mysql_num_rows($res49);
$exec49=mysql_fetch_array($res49);
if($itemcode == '')
{
$itemcode=$exec49['itemcode'];
}

if((($excludestatus == '')&&($excludebill == ''))||(($excludestatus == 'excluded')&&($excludebill == 'completed')))
			{
		
		
$query77 = "select itemcode,batchnumber,batch_quantity,description,fifo_code from transaction_stock where storecode='".$storecode."' AND locationcode='".$locationcode."' AND itemcode = '$itemcode' and batch_stockstatus='1'";
//$query77 = "select * from purchase_details where itemcode='$itemcode' AND locationcode = '".$locationcode."' AND store = '".$storecode."'";
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
			
$currentstock = $exec77["batch_quantity"];
$itemcode = $itemcode;
$batchname = $batchname;
$description = $exec77["description"];
$fifo_code = $exec77["fifo_code"];
	//include ('autocompletestockbatch.php');
	$currentstock = $currentstock; 
	$totalst=$totalst+$currentstock;
	//echo $totalst;
	}
	//echo $totalst;
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
		
		<td class="bodytext31" valign="center"  align="left"><div align="center"></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"></div></td>
        <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo '0';?></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res1route;?></div></td>
			<td class="bodytext31" valign="center"  align="left"><div align="center"></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res1quantity;?></div></td>
		 <td class="bodytext31" valign="center"  align="center">
                 <input type="hidden" name="pending2[]" value="<?php echo $res1quantity;?>">
				  <input type="hidden" name="medicinename2[]" value="<?php echo $res1medicinename;?>"></td>
				</tr>

<?php
}
else
{
$i=0;

$loopcontrol='';
$query23 = "select * from master_employeelocation where locationcode='$locationcode' AND username = '".$username."' and defaultstore = 'default'";
$exec23 = mysql_query($query23) or die(mysql_error());
$res23 = mysql_fetch_array($exec23);
 $location = $res23['locationname'];
 $res7locationanum = $res23['locationcode'];
 $res7storeanum = $res23['storecode'];

$query75 = "select * from master_store where auto_number='$res7storeanum'";
$exec75 = mysql_query($query75) or die(mysql_error());
$res75 = mysql_fetch_array($exec75);
 $storename = $res75['store'];
$query35=mysql_query("select * from master_itempharmacy where itemname='$res1medicinename'");
$exec35=mysql_fetch_array($query35);
if($itemcode == '')
{
$itemcode=$exec35['itemcode'];
}
 
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
$companyanum = $_SESSION["companyanum"];
$currentstock = $exec57["batch_quantity"];
$fifo_code = $exec57["fifo_code"];
			$itemcode = $itemcode;
			$batchname = $batchname;
	//include ('autocompletestockbatch.php');
	 $currentstock = $currentstock;
	//echo $currentstock;
	if($currentstock > 0 )
	{
  $totalstock = $totalstock+$currentstock;
if($totalstock >= $res1quantity)
{

 $issuequantity = $res1quantity-$oldstock;
  $pending='';
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
 //$res1medicinename1='';
 $res1dose='';
 $res1frequency='';
 $res1days='';
 $pending='';
 
 }
 $oldmedicinename=$res1medicinename;
 $sno=$sno+1;
 ?>
			  <tr>
              <td class="bodytext31" valign="center"  align="left"><div align="center">
        <input type="checkbox" name="ref[<?php echo $sno; ?>]" id="ref<?php echo $sno; ?>" checked value="<?php echo $sno; ?>"/>
        <input type="hidden" name="refnumber[]" value="<?php echo $refnumber; ?>" />
         </div></td>
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
				<input type="hidden" name="pending1[]" value="<?php echo $pending; ?>">
				 <td class="bodytext31" valign="center"  align="left" style="background-color:#82FA58;"><div align="center"><strong><?php echo $currentstock;?></strong></div></td>
				 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $issuequantity;?></div></td>
				 <input type="hidden" name="amount[]" value="<?php echo $res1amount;?>" />
				 <input type="hidden" name="issue[]" value="<?php echo $issuequantity;?>">
   				 <input type="hidden" name="currentstock1[]" value="<?php echo $currentstock;?>">
                 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res1rate*$res3quantity;?></div></td>
				 			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res1route;?></div></td>
			 <input type="hidden" name="route[]" value="<?php echo $res1route;?>" />
		
			 	 <td class="bodytext31" valign="center"  align="left"> <input type="text" onFocus="return autochangeins(<?= $sno;?>)" id="ainstructions<?php echo $sno; ?>" name="instructions[]" value="<?php echo $instructions ;?>" size="25" align="absmiddle"></div></td>
                 <input type="hidden" name="currentstock" value="<?php echo $currentstock;?>">
				 	 <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $pending; ?></div></td>
				 <td class="bodytext31" valign="center"  align="center">
                 <input type="hidden" name="pending" value="<?php echo $pending; ?>"></td>
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
           <td colspan="2" class="bodytext31" valign="center"  align="left" 
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
             	  <input name="Submit2223" type="submit" id="subbutton" onClick="return funcPrintBill()" value="Save " accesskey="b" class="button" />
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
