
<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');

$docno = $_SESSION['docno'];
 //get location for sort by location purpose
   $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
  $location1=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';

	if($location1!='')
	{
		  $locationcode=$location;
	}
		//location get end here
  
 $query1111 = "select * from master_employee where username = '$username'";
$exec1111 = mysql_query($query1111) or die ("Error in Query1111".mysql_error());
while ($res1111 = mysql_fetch_array($exec1111))
{
 $locationnumber = $res1111["location"];
 $query1112 = "select * from master_location where auto_number = '$locationnumber' and status<>'delete'";
$exec1112 = mysql_query($query1112) or die ("Error in Query1112".mysql_error());
while ($res1112 = mysql_fetch_array($exec1112))
{
 $locationname = $res1112["locationname"];    
 $locationcode = $res1112["locationcode"];
}
 }
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
<script>
<?php 
if (isset($_REQUEST["refundbillnumber"])) { $refundbillnumbers = $_REQUEST["refundbillnumber"]; } else { $refundbillnumbers = ""; }
if (isset($_REQUEST["patientcode"])) { $refundpatientcode = $_REQUEST["patientcode"]; } else { $refundpatientcode = ""; }
if (isset($_REQUEST["visitcode"])) { $refundvisitcode= $_REQUEST["visitcode"]; } else { $refundvisitcode = ""; }
if (isset($_REQUEST["locationcode"])) { $refundlocationode= $_REQUEST["locationcode"]; } else { $refundlocationode = ""; }
?>
	var refundbillnumber;
	var refundbillnumber = "<?php echo $refundbillnumbers; ?>";
	var refundpatientcodes;
	var refundpatientcodes = "<?php echo $refundpatientcode; ?>";
	var refundvisitcodes;
	var refundvisitcodes = "<?php echo $refundvisitcode; ?>";
	var refloccode;
	var refloccode = "<?php echo $refundlocationode; ?>";
	//alert(refundbillnumber);
	if(refundbillnumber != "") 
	{
		window.open("print_paynow_refund.php?billnumber="+refundbillnumber+"&&patientcode="+refundpatientcodes+"&&visitcode="+refundvisitcodes+"&&locationcode="+refloccode,"OriginalWindowA25",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
	}	
</script>
<script>
<?php 
if (isset($_REQUEST["otcbillnumber"])) { $otcbillnumbers = $_REQUEST["otcbillnumber"]; } else { $otcbillnumbers = ""; }
?>
	var otcbillnumberr;
	var otcbillnumberr = "<?php echo $otcbillnumbers; ?>";
	//alert(refundbillnumber);
	if(otcbillnumberr != "") 
	{
		window.open("print_otcbilling_dmp4inch1.php?billnumber="+otcbillnumberr,"OriginalWindowA25",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
	}	
</script>
<script>
<?php 
if (isset($_REQUEST["paynowpatientcode"])) { $paynowpatientcoder = $_REQUEST["paynowpatientcode"]; } else { $paynowpatientcoder = ""; }
if (isset($_REQUEST["paynowbillnumber"])) { $paynowbillnumbers = $_REQUEST["paynowbillnumber"]; } else { $paynowbillnumbers = ""; }
if (isset($_REQUEST["paynowpatientcode1"])) { $paynowpatientcoder1 = $_REQUEST["paynowpatientcode1"]; } else { $paynowpatientcoder1 = ""; }
?>
	var paynowpatientcoderr;
	var paynowpatientcoderr = "<?php echo $paynowpatientcoder; ?>";
	
	
	
	var paynowbillnumberr;
	var paynowbillnumberr = "<?php echo $paynowbillnumbers; ?>";
	//copay
	var paynowpatientcoderr1;
	var paynowpatientcoderr1 = "<?php echo $paynowpatientcoder1; ?>";
	//alert(refundbillnumber);
	if(paynowpatientcoderr1 != "") 
	{
		window.open("print_billpaynowbill_dmp4inch_copay.php?billautonumber="+paynowbillnumberr+"&&patientcode="+paynowpatientcoderr+"","OriginalWindowA25",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
	}	
	else if(paynowpatientcoderr != "") 
	{
		window.open("print_billpaynowbill_dmp4inch1.php?billautonumber="+paynowbillnumberr+"&&patientcode="+paynowpatientcoderr+"","OriginalWindowA25",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
	}	
	
</script>
<script>	
<?php 
if (isset($_REQUEST["consbillautonumber"])) { $consbillautonumbers = $_REQUEST["consbillautonumber"]; } else { $paynowpatientcoder = ""; }
?>
	var consbillautonumberr;
	var consbillautonumberr = "<?php echo $consbillautonumbers; ?>";
	//alert(refundbillnumber);
	if(consbillautonumberr != "") 
	{
		window.open("print_consultationbill_dmp4inch1.php?billautonumber="+consbillautonumberr+"","OriginalWindowA25",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
	}				
</script>
<script>	
<?php 
if (isset($_REQUEST["ipbillnumber"])) { $ipbillnumbers = $_REQUEST["ipbillnumber"]; } else { $ipbillnumbers = ""; }
if (isset($_REQUEST["ippatientcode"])) { $ippatientcodes = $_REQUEST["ippatientcode"]; } else { $ipbillnumbers = ""; }
?>
	var ipbillnumberr;
	var ipbillnumberr = "<?php echo $ipbillnumbers; ?>";
	var ippatientcoder;
	var ippatientcoder = "<?php echo $ippatientcodes; ?>";
	//alert(refundbillnumber);
	if(ipbillnumberr != "") 
	{
		window.open("print_depositcollection_dmp4inch1.php?billnumbercode="+ipbillnumberr+"&&patientcode="+ippatientcoder+"","OriginalWindowA25",'width=400,height=500,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25'); 
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
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3B3B3C; FONT-FAMILY: Tahoma
}
.bodytext32 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
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
        <td width="800" rowspan="9"><form name="cbform1" method="post" action="packagepatientslist.php">
          <table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
		  <!--<tr bgcolor="red">
              <td colspan="4" bgcolor="red" class="bodytext3"><strong> PLEASE REFRESH PAGE BEFORE MAKING BILL </strong></td>
              </tr>-->
            <tr bgcolor="#011E6A">
              <td colspan="3" bgcolor="#CCCCCC" class="bodytext3"><strong> Search Package Patient </strong></td>
              <td colspan="1" bgcolor="#CCCCCC" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
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
						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						$res1 = mysql_fetch_array($exec1);
						
						echo $res1location = $res1["locationname"];
						 $res1locationanum = $res1['locationcode'];
						}
						?>
						
                  
                  </td>
     
              </tr>
             <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
               <select name="location" id="location" onChange="ajaxlocationfunction(this.value);"  style="border: 1px solid #001E6A;">
                  <?php
						
						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						while ($res1 = mysql_fetch_array($exec1))
						{
						$res1location = $res1["locationname"];
						$res1locationanum = $res1["locationcode"];
						$locationcode2=$reslocationanum;
						?>
						<option value="<?php echo $res1locationanum; ?>" <?php if($location!='')if($location==$res1locationanum){echo "selected";}?>><?php echo $res1location; ?></option>
						<?php
						}
						?>
                  </select>
            </span></td>
              </tr>
			    <tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Name</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="patient" type="text" id="patient" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			    <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Registration No</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="patientcode" type="text" id="patient" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			   <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Visitcode</td>
              <td colspan="4" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <input name="visitcode" type="text" id="visitcode" value="" size="50" autocomplete="off">
              </span></td>
              </tr>
			  <tr>
          <td width="136" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="131" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="76" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td width="425" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
            <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
          </tr>
			   <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton"  value="Reset" /></td>
            </tr>
          </tbody>
        </table>
		</form>		</td>
        <td width="481" class="bodytext3" style="font-size: 14px">&nbsp;</td>
      </tr>
      <tr>
        <td class="bodytext3" style="font-size: 14px"><span class="bodytext32" style="font-size: 14px"><strong>&nbsp;</strong></span></td>
      </tr>
     <!-- <tr>
        <td class="bodytext3" style="font-size: 14px"><span class="bodytext32" style="font-size: 14px"><strong><a href="billing_pending_op2.php" target="_blank" style="text-decoration:none;">Credit Patient Billing</a></strong></span></td>
      </tr>-->
      <tr>
         <td class="bodytext3" style="font-size: 14px"><span class="bodytext32" style="font-size: 14px"><strong>&nbsp;</strong></span></td>
      </tr>
      <tr>
        <td><span class="bodytext32" style="font-size: 14px"><strong>&nbsp;</strong></span></td>
      </tr>
      <tr>
         <td><span class="bodytext32" style="font-size: 14px"><strong>&nbsp;</strong></span></td>
      </tr>
      <tr>
        <td><span class="bodytext32" style="font-size: 14px"><strong>&nbsp;</strong></span></td>
      </tr>
      <tr>
       <!-- <td><span class="bodytext32" style="font-size: 14px"><strong><a href="paylaterrefundlist.php" target="_blank" style="text-decoration:none;">Credit Patient Refund </a></strong></span></td>
      </tr>-->
      <tr>
        <td><span class="bodytext32" style="font-size: 14px"><strong>&nbsp;</strong></span></td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
	  <tr>
        <td colspan="2">
	
		
<?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	$searchpatient = $_POST['patient'];
	$searchpatientcode=$_POST['patientcode'];
	$searchvisitcode = $_POST['visitcode'];
	$fromdate=$_POST['ADate1'];
	$todate=$_POST['ADate2'];



	//echo $searchpatient;
		//$transactiondatefrom = $_REQUEST['ADate1'];
	//$transactiondateto = $_REQUEST['ADate2'];


	
?>
<form name="form1" id="form1" method="post" action="packagepatientslist.php">	
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1200" 
            align="left" border="0">
          <tbody>
             
           <tr>
                <td width="44"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
                               <td width="96" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Reg Code</strong></td>
				  <td width="100" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Visit Code</strong></td>
					  <td width="93" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>IP Date</strong></td>
			
			        <td width="208"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Name </strong></div></td>
               <td width="75" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Type</strong></div></td>
                           <td width="225"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Account Name</strong></div></td>
                 <td width="103" align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Awaiting</strong></td>
                 </tr>
			  <?php 
						//location code get
						$locationcode= isset($_REQUEST['location'])?$_REQUEST['location']:'';	  
           $query1 = "select * from master_ipvisitentry where patientfullname like '%$searchpatient%' and locationcode='$locationcode' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and consultationdate between '$fromdate' and '$todate' and package <> '0' order by auto_number desc";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			while ($res1 = mysql_fetch_array($exec1))
			{
			$patientcode = $res1['patientcode'];
			$visitcode = $res1['visitcode'];
			$patientfullname = $res1['patientfullname'];
			$accountname=$res1['accountname'];
			$query23=mysql_query("select * from master_accountname where auto_number = '$accountname'");
			$exec23=mysql_fetch_array($query23);
			$patientaccountname=$exec23['accountname'];
			$consultationdate = $res1['consultationdate'];
			  //$res2contactperson1 = $res2['contactperson1'];
			  $paymenttypeanum = $res1['paymenttype'];
			  
			  $query3 = "select * from master_paymenttype where auto_number = '$paymenttypeanum'";
			  $exec3 = mysql_query($query3) or die ("Error in Query5".mysql_error());
			  $res3 = mysql_fetch_array($exec3);
			  $res3paymenttype = $res3['paymenttype'];
			  
			  $query2 = "select visitcode from billing_ip where visitcode = '$visitcode'";
			  $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			  $rows2 = mysql_num_rows($exec2);
			  if($rows2 == 0)
			  {
			  
			  $query112 = "select * from privatedoctor_billing where patientcode='$patientcode' and visitcode='$visitcode'";
				$exec112 = mysql_query($query112) or die(mysql_error());
				$privno = mysql_num_rows($exec112);
				
				$query112 = "select * from residentdoctor_billing where patientcode='$patientcode' and visitcode='$visitcode'";
				$exec112 = mysql_query($query112) or die(mysql_error());
				$resno = mysql_num_rows($exec112);
				$numpr = $privno+$resno;
				if($numpr > '0') 
				{ 
			
			  $colorloopcount = $colorloopcount + 1;
			  $showcolor = ($colorloopcount & 1); 
			  $colorcode = '';
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
                <td class="bodytext31" valign="center"  align="left"><?php echo $colorloopcount; ?></td>
                       <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $patientcode; ?></span></div>
                </div></td>
				  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $visitcode; ?></span></div>
                </div></td>
					  <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"><span class="bodytext32"><?php echo $consultationdate; ?></span></div>
                </div></td>
           
                   <td class="bodytext31" valign="center"  align="left">
				  <div align="left"><?php echo $patientfullname; ?></div></td>
           
                <td  align="left" valign="center" class="bodytext31"><div class="bodytext31">
                    <div align="left"> <span class="bodytext3"> <?php echo $res3paymenttype; ?> </span> </div>
                </div></td>
                               <td  align="left" valign="center" class="bodytext31"><div align="left"> <?php echo $patientaccountname; ?></div></td>
                  <td  align="left" valign="center" class="bodytext31">
				  <div align="left"><a href="editpackagebilling.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>"><strong>Edit Package</strong></a></div></td>
                    </tr>
			  <?php
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
           	</tr>
          </tbody>
        </table>

		 </form>
		 <?php
		}
		 ?>		</td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
	  
	 
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

