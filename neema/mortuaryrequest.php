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

//This include updatation takes too long to load for hunge items database.


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


include ("autocompletebuild_customeripbilling.php");
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
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<?php include ("js/dropdownlistipbilling.php"); ?>
<script type="text/javascript" src="js/autosuggestipbilling.js"></script> <!-- For searching customer -->
<script type="text/javascript" src="js/autocomplete_customeripbilling.js"></script>
<script language="javascript">

function cbsuppliername1()
{
	document.cbform1.submit();
}

function funcOnLoadBodyFunctionCall()
{ 
	//alert ("Inside Body On Load Fucntion.");
	//funcBodyOnLoad(); //To reset any previous values in text boxes. source .js - sales1scripting1.php
	
	funcCustomerDropDownSearch1(); //To handle ajax dropdown list.
	funcPopupOnLoad1();
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


function funcPrintReceipt1()
{
	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	window.open("print_payment_receipt1.php","OriginalWindow<?php echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
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

<script>
function funcPopupOnLoad1()
{
<?php  
if (isset($_REQUEST["savedpatientcode"])) { $savedpatientcode = $_REQUEST["savedpatientcode"]; } else { $savedpatientcode = ""; }
if (isset($_REQUEST["savedvisitcode"])) { $savedvisitcode = $_REQUEST["savedvisitcode"]; } else { $savedvisitcode = ""; }
if (isset($_REQUEST["billnumber"])) { $billnumbers = $_REQUEST["billnumber"]; } else { $billnumbers = ""; }
?>
var patientcodes = "<?php echo $savedpatientcode; ?>";
var visitcodes = "<?php echo $savedvisitcode; ?>";
var billnumbers = "<?php echo $billnumbers; ?>";
//alert(billnumbers);
	if(patientcodes != "") 
	{
		window.open("print_ipfinalinvoice.php?patientcode="+patientcodes+"&&visitcode="+visitcodes+"&&billnumber="+billnumbers,"OriginalWindowA4",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
	}
}
</script>

<script src="js/datetimepicker_css.js"></script>

<body onLoad="return funcOnLoadBodyFunctionCall()">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
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
    <td width="97%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="5" bgcolor="#CCCCCC" class="bodytext3"><strong>Mortuary Request</strong></td>
              </tr>
          
           <tr>
				  <td align="left" valign="middle"  bgcolor="#E0E0E0" class="bodytext3">Patient Search </td>
				  <td colspan="6" align="left" valign="middle"  bgcolor="#E0E0E0">
				  <input name="customer" id="customer" size="60" autocomplete="off">
				  <input name="customercode" id="customercode" value="" type="hidden">
				<input type="hidden" name="recordstatus" id="recordstatus">
				  <input type="hidden" name="billnumbercode" id="billnumbercode" value="<?php echo $billnumbercode; ?>" readonly style="border: 1px solid #001E6A;"></td>
				
             
              <td width="20%" align="left" valign="top"  bgcolor="#E0E0E0"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input   type="submit" value="Search" name="Submit" onClick="return funcvalidcheck();"/>
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
      
	  <form name="form11" id="form11" method="post" action="ipbilling.php">	
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
              <td width="7%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
					 <td width="22%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Patient Name</strong></div></td>
				 <td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Reg No</strong></div></td>
				  <td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>IP Date</strong></div></td>
				 <td width="10%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>IP Visit</strong></div></td>
					 <td width="18%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Account</strong></div></td>
			 <td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Action </strong></div></td>
			
			
              </tr>
           <?php
		  
		  if($searchpatient != '')
		  { 
           $query34 = "select * from ip_bedallocation where patientname like '%$searchpatient%' or patientcode like '%$searchpatient%' or visitcode like '%$searchpatient%'";
		   $exec34 = mysql_query($query34) or die(mysql_error());
		   while($res34 = mysql_fetch_array($exec34))
		   {
		   $patientname = $res34['patientname'];
		   $patientcode = $res34['patientcode'];
		   $visitcode = $res34['visitcode'];
		   $paymentstatus = $res34['paymentstatus'];
		   $creditapprovalstatus = $res34['creditapprovalstatus'];
		  
		   
		   
		   $query82 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
		   $exec82 = mysql_query($query82) or die(mysql_error());
		   $res82 = mysql_fetch_array($exec82);
		   $date = $res82['consultationdate'];
		   $accountname = $res82['accountfullname'];
		   
		   $query83 = "select * from mortuary_request where patientcode='$patientcode' and visitcode='$visitcode'";
		   $exec83 = mysql_query($query83) or die("Error in Query83".mysql_error());
		   $res83 = mysql_fetch_array($exec83);
		   $mortuaryrequest = mysql_num_rows($exec83);
		 	if($mortuaryrequest==0){
		   if($paymentstatus == '')
		   {
		   if($creditapprovalstatus == '')
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
		
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientname; ?></div></td>
				
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientcode; ?></div></td>
					  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $date; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $visitcode; ?></div></td>
					  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $accountname; ?></div></td>
						<td class="bodytext31" valign="center"  align="center"><a href="mortuaryrequestapproval.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">Request</a></td>
			     </tr>
		  <?php
		  }
		  }
			}
		 }
		  }else
		  {
		 $query34 = "select * from ip_bedallocation where paymentstatus = '' and creditapprovalstatus = ''";
		   $exec34 = mysql_query($query34) or die(mysql_error());
		   while($res34 = mysql_fetch_array($exec34))
		   {
		   $patientname = $res34['patientname'];
		   $patientcode = $res34['patientcode'];
		   $visitcode = $res34['visitcode'];
		  
		 
		   
		   $query82 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode'";
		   $exec82 = mysql_query($query82) or die(mysql_error());
		   $res82 = mysql_fetch_array($exec82);
		   $date = $res82['consultationdate'];
		   $accountname = $res82['accountfullname'];
		   
		   $query83 = "select * from mortuary_request where patientcode='$patientcode' and visitcode='$visitcode'";
		   $exec83 = mysql_query($query83) or die("Error in Query83".mysql_error());
		   $res83 = mysql_fetch_array($exec83);
		   $mortuaryrequest = mysql_num_rows($exec83);
			if($mortuaryrequest==0){
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
		
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientname; ?></div></td>
				
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientcode; ?></div></td>
					  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $date; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $visitcode; ?></div></td>
					  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $accountname; ?></div></td>
						<td class="bodytext31" valign="center"  align="center"><a href="mortuaryrequestapproval.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">Request</a></td>
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

