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
<script language="javascript">

function cbsuppliername1()
{
	document.cbform1.submit();
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

function paymententry1process2()
{
	if (document.getElementById("cbfrmflag1").value == "")
	{
		alert ("Search Bill Number Cannot Be Empty.");
		document.getElementById("cbfrmflag1").focus();
		document.getElementById("cbfrmflag1").value = "<?php echo $cbfrmflag1; ?>";
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
.number
{
padding-left:900px;
text-align:right;
font-weight:bold;
}
.bali
{
text-align:right;
}
.style1 {font-weight: bold}
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
	<form name="form1" id="form1" method="post" action="labresultsviewlist.php">	
		
<?php
	$colorloopcount=0;
	$sno=0;

$patientcode = $_REQUEST['patientcode'];
			$visitcode = $_REQUEST['visitcode'];
		
		
	$querynw1 = "select * from resultentry_lab where patientcode like '$patientcode' and patientvisitcode like '$visitcode' group by docnumber  order by auto_number desc";

			$execnw1 = mysql_query($querynw1) or die ("Error in Query1".mysql_error());
			$resnw1=mysql_num_rows($execnw1);

	
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="959" 
            align="left" border="0">
          <tbody>
             <tr>
			 <td colspan="9" bgcolor="#cccccc" class="bodytext31" nowrap="nowrap"><div align="left"><strong>Lab Results View</strong><label class="number"><<<?php echo $resnw1; ?>>></label></div></td>
			 </tr>
            <tr>
              <td width="2%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>No.</strong></div></td>
				 <td width="3%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Print</strong></td>
				 <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Date </strong></div></td>
				<td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Patient Code  </strong></div></td>
				<td width="7%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Visit Code  </strong></div></td>
              <td width="20%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Patient Name</strong></div></td>
				  <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong> Doc Number</strong></div></td>
             
                <td width="30%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Test Name</strong></div></td>
             <td width="10%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Action</strong></td>
              </tr>
           <?php
            
		$query1 = "select * from resultentry_lab where patientcode like '$patientcode' and patientvisitcode like '$visitcode' group by docnumber  order by auto_number desc";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		
		while($res1 = mysql_fetch_array($exec1))
		{
		$itemname='';
		$patientname=$res1['patientname'];
		$patientcode=$res1['patientcode'];
		$visitcode=$res1['patientvisitcode'];
		$consultationdate=$res1['recorddate'];
	   $docnumber=$res1['docnumber'];
	   
	   $query11="select * from resultentry_lab where patientcode like '$patientcode' and patientvisitcode like '$visitcode' and docnumber = '$docnumber' group by itemcode ";
				  $exec11=mysql_query($query11) or die(mysql_error());
				  $num11=mysql_num_rows($exec11);
	   
	    while($res11=mysql_fetch_array($exec11))
				  {
				 $item=$res11['itemname'];
				   if($num11 == '1') {
				 $itemname=$item;    }
				 else {
				 $itemname=$item.', '. $itemname;
				      }
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
              <td height="45"  align="left" valign="center" class="bodytext31"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="center"><a target="_blank" href="printlabresults.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docnumber=<?php echo $docnumber; ?>"><strong>Print</strong></a></td>
              
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $consultationdate; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center"><?php echo $patientname; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $docnumber; ?></div></td>
             <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $itemname; ?></div></td>
                  
              
              <td class="bodytext31" valign="center"  align="left"><a href="labresultsview.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docnumber=<?php echo $docnumber; ?>"><strong>View</strong></a></td>
              </tr>
		   <?php 
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
                bgcolor="#cccccc"><div align="right"><strong>
                
              </strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc"><div align="right"><strong>
             
              </strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
      <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
			</tr>
          </tbody>
        </table>

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

