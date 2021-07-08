<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";

$docno = $_SESSION['docno'];
 //get location for sort by location purpose
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
	if($location!='')
	{
		  $locationcode=$location;
		}
		//location get end here
//This include updatation takes too long to load for hunge items database.
?>
<script>
//This include updatation takes too long to load for hunge items database.
<?php
if (isset($_REQUEST["billno"])) { 
	$billno = $_REQUEST["billno"];
	$visitcode = $_REQUEST["visitcode"];
	$patientcode = $_REQUEST["patientcode"];
	?>
		 window.open('print_debitnote.php?billno=<?php echo $billno;?>&&visitcode=<?php echo $visitcode;?>&&patientcode=<?php echo $patientcode;?>');
		
		<?php
} 
?>
</script>

<?php 

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select * from master_supplier where auto_number = '$getcanum'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	$res4 = mysql_fetch_array($exec4);
	$cbsuppliername = $res4['suppliername'];
	$suppliername = $res4['suppliername'];
}



if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];

if ($frmflag2 == 'frmflag2')
{
    $itemname=$_REQUEST['itemname'];
	$itemcode=$_REQUEST['itemcode'];
$adjustmentdate=date('Y-m-d');
	foreach($_POST['batch'] as $key => $value)
		{
		$batchnumber=$_POST['batch'][$key];
		$addstock=$_POST['addstock'][$key];
		$minusstock=$_POST['minusstock'][$key];
		$query40 = "select * from master_itempharmacy where itemcode = '$itemcode'";
	$exec40 = mysql_query($query40) or die ("Error in Query40".mysql_error());
	$res40 = mysql_fetch_array($exec40);
	$itemmrp = $res40['rateperunit'];
	
	$itemsubtotal = $itemmrp * $addstock;
	
		if($addstock != '')
		{
		$query65="insert into master_stock (itemcode, itemname, transactiondate, transactionmodule, 
	transactionparticular, billautonumber, billnumber, quantity, remarks, 
	 username, ipaddress, rateperunit, totalrate, companyanum, companyname,batchnumber)
	values ('$itemcode', '$itemname', '$adjustmentdate', 'ADJUSTMENT', 
	'BY ADJUSTMENT ADD', '$billautonumber', '$billnumber', '$addstock', '$remarks', 
	'$username', '$ipaddress', '$itemmrp', '$itemsubtotal', '$companyanum', '$companyname','$batchnumber')";
$exec65=mysql_query($query65) or die(mysql_error());
		}
		else
		{
		$query65="insert into master_stock (itemcode, itemname, transactiondate, transactionmodule, 
	transactionparticular, billautonumber, billnumber, quantity, remarks, 
	 username, ipaddress, rateperunit, totalrate, companyanum, companyname,batchnumber)
	values ('$itemcode', '$itemname', '$adjustmentdate', 'ADJUSTMENT', 
	'BY ADJUSTMENT MINUS', '$billautonumber', '$billnumber', '$minusstock', '$remarks', 
	'$username', '$ipaddress', '$itemmrp', '$itemsubtotal', '$companyanum', '$companyname','$batchnumber')";
$exec65=mysql_query($query65) or die(mysql_error());
	
		}
		}
	header("location:stockadjustment.php");
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

//include ("autocompletebuild_customerip.php");
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
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<!--<?php //include ("js/dropdownlistip.php"); ?>
<script type="text/javascript" src="js/autosuggestip.js"></script>
<script type="text/javascript" src="js/autocomplete_customerip.js"></script>-->
<script language="javascript">


function ajaxlocationfunction(val)
{ 
if (window.XMLHttpRequest)
					  {// code for IE7+, Firefox, Chrome, Opera, Safari
					  xmlhttp=new XMLHttpRequest();
					  }
					else
					  {// code for IE6, IE5
					  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
					  }
					xmlhttp.onreadystatechange=function()
					  {
					  if (xmlhttp.readyState==4 && xmlhttp.status==200)
						{
						document.getElementById("ajaxlocation").innerHTML=xmlhttp.responseText;
						}
					  }
					xmlhttp.open("GET","ajax/ajaxgetlocationname.php?loccode="+val,true);
					xmlhttp.send();
}
					
//ajax to get location which is selected ends here


function cbsuppliername1()
{
	document.cbform1.submit();
}

function funcOnLoadBodyFunctionCall()
{ 
	//alert ("Inside Body On Load Fucntion.");
	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	//funcCustomerDropDownSearch1(); //To handle ajax dropdown list.
}



</script>
<script type="text/javascript">


function disableEnterKey(varPassed)
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
	
	var key;
	if(window.event)
	{
		key = window.event.keyCode;     //IE
	}
	else
	{
		key = e.which;     //firefox
	}

	if(key == 13) // if enter key press
	{
		//alert ("Enter Key Press2");
		return false;
	}
	else
	{
		return true;
	}
}


function process1backkeypress1()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
}

function disableEnterKey()
{
	//alert ("Back Key Press");
	if (event.keyCode==8) 
	{
		event.keyCode=0; 
		return event.keyCode 
		return false;
	}
	
	var key;
	if(window.event)
	{
		key = window.event.keyCode;     //IE
	}
	else
	{
		key = e.which;     //firefox
	}
	
	if(key == 13) // if enter key press
	{
		return false;
	}
	else
	{
		return true;
	}

}
function validchecking()
{
var customer = document.getElementById("customer").value;
if(customer == '')
{
alert("Please Select a Patient");
document.getElementById("customer").focus();
return false;
}
}

function funcPrintReceipt1()
{
	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}

</script>
<link rel="stylesheet" type="text/css" href="css/autosuggest.css" />      
<script src="js/datetimepicker_css.js"></script>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autocomplete.css">      
<script>

$(document).ready(function(e) {
   
		$('#customer').autocomplete({
		
	
	source:"ajaxdebit.php",
	//alert(source);
	matchContains: true,
	minLength:1,
	html: true, 
		select: function(event,ui){
			var patientcode=ui.item.patientcode;
			$("#customercode").val(patientcode);
			
			},
    
	});
		
});
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
<table width="101%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="10" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="debitnotelist.php" onSubmit="return validchecking()">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Debit Note List </strong></td>
               <td colspan="3" align="right" bgcolor="#CCCCCC" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
                  <?php
						
						if ($location!='')
						{
						$query12 = "select locationname from master_location where locationcode='$location' order by locationname";
						$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
						$res12 = mysql_fetch_array($exec12);
						
						echo $res1location = $res12["locationname"];
						//echo $location;
						}
						else
						{
						$query1 = "select locationname from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						$res1 = mysql_fetch_array($exec1);
						
						echo $res1location = $res1["locationname"];
						//$res1locationanum = $res1["locationcode"];
						}
						?>
						
						
                  
                  </td> 
              </tr>
          <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
               <select name="location" id="location" onChange=" ajaxlocationfunction(this.value);"  style="border: 1px solid #001E6A;">
                  <?php
						
						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						while ($res1 = mysql_fetch_array($exec1))
						{
						$res1location = $res1["locationname"];
						$res1locationanum = $res1["locationcode"];
						?>
						<option value="<?php echo $res1locationanum; ?>" <?php if($location!='')if($location==$res1locationanum){echo "selected";}?>><?php echo $res1location; ?></option>
						<?php
						}
						?>
                  </select>
              </span></td>
              </tr>
           <tr>
				  <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Search </td>
				  <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF">
				  <input name="customer" id="customer" style="border: 1px solid #001E6A;" size="60" autocomplete="off">
				  <input name="customercode" id="customercode" value="" type="hidden">
				<input type="hidden" name="recordstatus" id="recordstatus">
				  <input type="hidden" name="billnumbercode" id="billnumbercode" value="<?php echo $billnumbercode; ?>" readonly style="border: 1px solid #001E6A;"></td>
				
             
              
            </tr>
            <tr>
            <td colspan="1" bgcolor="#FFFFFF">&nbsp;</td>
            <td colspan="3"  align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  style="border: 1px solid #001E6A" type="submit" value="Search" name="Submit" onClick="return funcvalidcheck();"/>
            </td>
            </tr>
			    
             </tbody>
        </table>
		</form>		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      
	  <form name="form1" id="form1" method="post" action="debitnotelist.php">	
	  <tr>
        <td>
	
		
<?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	$searchpatient = $_POST['customer'];
	
	
		
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1150" 
            align="left" border="0">
          <tbody>
             
            <tr>
              <td width="5%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
					 <td width="8%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Bill No</strong></div></td>
			
					 <td width="20%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Patient Name</strong></div></td>
				 <td width="8%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Reg No</strong></div></td>
				  <td width="8%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Visit Date</strong></div></td>
				 <td width="8%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Visit Code</strong></div></td>
				
				 <td width="16%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Account</strong></div></td>
			
					 <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Action</strong></div></td>
			
              </tr>
           <?php
		  
		  if($searchpatient != '')
		  { 
           $query34 = "select * from master_ipvisitentry where locationcode = '".$locationcode."' AND (patientfullname like '%$searchpatient%' or patientcode like '%$searchpatient%' or visitcode like '%$searchpatient%' or finalbillno like '%$searchpatient%')";
		   $exec34 = mysql_query($query34) or die(mysql_error());
		   while($res34 = mysql_fetch_array($exec34))
		   {
		   $patientname = $res34['patientfullname'];
		   $patientcode = $res34['patientcode'];
		   $visitcode = $res34['visitcode'];
		   $date = $res34['consultationdate'];
		   $accountname = $res34['accountfullname'];
		   $paymentstatus=$res34['paymentstatus'];
		   
		   $query33 = "select * from billing_ip where patientcode='$patientcode' and visitcode='$visitcode'";
	$exec33 = mysql_query($query33) or die(mysql_error());
	$num33 = mysql_num_rows($exec33);
	if($num33 != 0)
	{
	$res33 = mysql_fetch_array($exec33);
	$billno = $res33['billno'];
	}
	else
	{
	$query39 = "select * from billing_ipcreditapproved where patientcode='$patientcode' and visitcode='$visitcode'";
	$exec39 = mysql_query($query39) or die(mysql_error());
	$res39= mysql_fetch_array($exec39);
	$billno = $res39['billno'];
	}
		if($paymentstatus == 'completed')
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
			?>
			
          <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientname; ?></div></td>
				
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientcode; ?></div></td>
					  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $date; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $visitcode; ?></div></td>
						  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $accountname; ?></div></td>
				<td class="bodytext31" valign="center"  align="center"><a href="debitnote.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">Process</a></td>
			
			
			
              </tr>
		  <?php
		  }
		  }		   
           $query34 = "select * from master_visitentry where  locationcode = '".$locationcode."' AND (patientfullname like '%$searchpatient%' or patientcode like '%$searchpatient%' or visitcode like '%$searchpatient%') and billtype<>'PAY NOW'";
		   $exec34 = mysql_query($query34) or die(mysql_error());
		   while($res34 = mysql_fetch_array($exec34))
		   {
		   $patientname = $res34['patientfullname'];
		   $patientcode = $res34['patientcode'];
		   $visitcode = $res34['visitcode'];
		   $date = $res34['consultationdate'];
		   $accountname = $res34['accountfullname'];
		   $paymentstatus=$res34['paymentstatus'];
		   $billno='';
		    $query33 = "select * from billing_paylater where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec33 = mysql_query($query33) or die(mysql_error());
			$num33 = mysql_num_rows($exec33);
			if($num33 != 0)
			{
			$res33 = mysql_fetch_array($exec33);
			$billno = $res33['billno'];
			}
		if($paymentstatus == 'completed' && $billno != '')
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
			?>
			
          <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientname; ?></div></td>
				
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientcode; ?></div></td>
					  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $date; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $visitcode; ?></div></td>
						  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $accountname; ?></div></td>
				<td class="bodytext31" valign="center"  align="center"><a href="debitnote.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">Process</a></td>
			
			
			
              </tr>
		  <?php
		  }
		  }
		  }else
		  {
		 $query34 = "select * from master_ipvisitentry where locationcode = '".$locationcode."' AND paymentstatus = 'completed'";
		   $exec34 = mysql_query($query34) or die(mysql_error());
		  $num34 = mysql_num_rows($exec34);
		   while($res34 = mysql_fetch_array($exec34))
		   {
		   $patientname = $res34['patientfullname'];
		   $patientcode = $res34['patientcode'];
		   $visitcode = $res34['visitcode'];
		   $date = $res34['consultationdate'];
		   $accountname = $res34['accountfullname'];
		   
		   $query33 = "select * from billing_ip where patientcode='$patientcode' and visitcode='$visitcode'";
	$exec33 = mysql_query($query33) or die(mysql_error());
	$num33 = mysql_num_rows($exec33);
	if($num33 != 0)
	{
	$res33 = mysql_fetch_array($exec33);
	$billno = $res33['billno'];
	}
	else
	{
	$query39= "select * from billing_ipcreditapproved where patientcode='$patientcode' and visitcode='$visitcode'";
	$exec39 = mysql_query($query39) or die(mysql_error());
	$res39 = mysql_fetch_array($exec39);
	$billno = $res39['billno'];
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
			?>
			
          <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientname; ?></div></td>
				
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientcode; ?></div></td>
					  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $date; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $visitcode; ?></div></td>
					  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $accountname; ?></div></td>
				<td class="bodytext31" valign="center"  align="center"><a href="debitnote.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">Process</a></td>
			
			
			
              </tr>
		  <?php
		 
		  }
		  $query34 = "select * from master_visitentry where  locationcode = '".$locationcode."' and billtype<>'PAY NOW'";
		   $exec34 = mysql_query($query34) or die(mysql_error());
		   while($res34 = mysql_fetch_array($exec34))
		   {
		   $patientname = $res34['patientfullname'];
		   $patientcode = $res34['patientcode'];
		   $visitcode = $res34['visitcode'];
		   $date = $res34['consultationdate'];
		   $accountname = $res34['accountfullname'];
		   $paymentstatus=$res34['paymentstatus'];
		   $billno='';
		    $query33 = "select * from billing_paylater where patientcode='$patientcode' and visitcode='$visitcode'";
			$exec33 = mysql_query($query33) or die(mysql_error());
			$num33 = mysql_num_rows($exec33);
			if($num33 != 0)
			{
			$res33 = mysql_fetch_array($exec33);
			$billno = $res33['billno'];
			}
		if($paymentstatus == 'completed' && $billno != '')
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
			?>
			
          <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
		<td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $billno; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientname; ?></div></td>
				
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientcode; ?></div></td>
					  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $date; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $visitcode; ?></div></td>
						  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $accountname; ?></div></td>
				<td class="bodytext31" valign="center"  align="center"><a href="debitnote.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">Process</a></td>
			
			
			
              </tr>
		  <?php
		  }
		  }
		  }
           ?>
            <tr>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
			
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
             	<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
            
            		   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
            	   <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
            
      
			</tr>
			
          </tbody>
        </table>
<?php
}


?>	
		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
	  
	  </form>
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

