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
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
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
    <td class="bodytext31">&nbsp;</td>
    <td class="bodytext31">&nbsp;</td>
    <td class="bodytext31">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="2%" valign="top"><?php //include ("includes/menu4.php"); ?>
      &nbsp;</td>
    <td width="97%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="peadiatricactivity.php">
		<table width="510" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="5" bgcolor="#CCCCCC" class="bodytext3"><strong>Peadiatric Activity</strong></td>
              </tr>
          
            <tr>
              <td width="23%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Ward</td>
              <td width="15%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
                <select name="ward" id="ward" onChange="return funcwardChange1()">
                         
						   <option value=""> All</option>
						  <?php 
						  $query78 = "select * from master_ward where recordstatus=''";
						  $exec78 = mysql_query($query78) or die(mysql_error());
						  while($res78 = mysql_fetch_array($exec78))
						  {
						  $wardanum = $res78['auto_number'];
						  $wardname = $res78['ward'];
						  
						    ?>
						  
                          <option value="<?php echo $wardanum; ?>"><?php echo $wardname; ?></option>
						  <?php
						  }
                          ?>
                      </select>
              </span></td>
              
              <td width="62%" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                <input  type="submit" value="Search" name="Submit" onClick="return funcvalidcheck();"/></td>
            </tr>
             </tbody>
        </table>
		  <iframe marginheight="1" marginwidth="50" src="inpatientlabtestscrolling.php" frameborder="0" scrolling="no" width="450" height="70"></iframe>
		</form>		</td>
      </tr>
      

	  <form name="form1" id="form1" method="post" action="inpatientactivity.php">	
	  <tr>
        <td>
	
		
<?php
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	$searchward = $_POST['ward'];
	
	
	$query781 = "select * from master_ward where auto_number='$searchward' and recordstatus=''";
						  $exec781 = mysql_query($query781) or die(mysql_error());
						  $res781 = mysql_fetch_array($exec781);
						  $wardname = $res781['ward'];
						
	
		//echo $searchpatient;
		//$transactiondatefrom = $_REQUEST['ADate1'];
	//$transactiondateto = $_REQUEST['ADate2'];


	
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1199" 
            align="left" border="0">
          <tbody>
             
            <tr>
              <td width="4%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
					 <td width="22%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Patient Name</strong></div></td>
				     <td width="7%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Age</strong></div></td>
				     <td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="style1"><div align="center">Gender</div></td>
			        <td width="6%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Reg No</strong></div></td>
				  <td width="7%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>DOA</strong></div></td>
				 <td width="7%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>IP Visit</strong></div></td>
				 <td width="7%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Ward</strong></div></td>
			 <td width="7%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Bed No </strong></div></td>
			 <td width="7%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Dept.</strong></div></td>
                
				 <td width="15%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Account</strong></div></td>
			
					 <td width="12%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>IP Activity</strong></div></td>
              </tr>
            <?php
            $query34 = "select * from master_ward where ward like '%$wardname%'";
			$exec34 = mysql_query($query34) or die(mysql_error());
			while($res34 = mysql_fetch_array($exec34))
			{
			 $wardnum = $res34['auto_number'];
			 $wardname5 = $res34['ward'];
			?>
			<tr>
			  <td colspan="12" align="left" valign="center" 
                bgcolor="#CCCCCC" class="bodytext31"><div align="left"><strong><?php echo $wardname5; ?></strong></div></td>
			 </tr>
			<?php
	
		$query50 = "select * from master_bed where ward='$wardnum'";
		$exec50 = mysql_query($query50) or die(mysql_error());
		while($res50 = mysql_fetch_array($exec50))
		{
		$bedname = $res50['bed'];
		$bedanum = $res50['auto_number'];
		$bed = '';
		$ward = '';
		$patientcode = '';
		$visitcode = '';
		
		
		$query69 = "select auto_number from master_bed where auto_number='$bedanum' and ward='$wardnum' and recordstatus='occupied' order by auto_number desc limit 0, 1";
		$exec69 = mysql_query($query69) or die(mysql_error());
		$num69 = mysql_num_rows($exec69);
	
	
		$query59 = "select * from ip_bedallocation where ward='$wardnum' and bed='$bedanum' and recordstatus = '' order by auto_number desc limit 0, 1";
		$exec59 = mysql_query($query59) or die(mysql_error());
		$res59 = mysql_fetch_array($exec59);
		$num59 = mysql_num_rows($exec59);
		if($num59 > 0)
		{
		$ward = $res59['ward'];
		$bed = $res59['bed'];
		$patientname = $res59['patientname'];
		$patientcode = $res59['patientcode'];
		$visitcode = $res59['visitcode'];
		
		$query49 = "select consultationdate,accountfullname,age,gender,department from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode' order by auto_number desc limit 0, 1" ;
		$exec49 = mysql_query($query49) or die(mysql_error());
		$res49 = mysql_fetch_array($exec49);
		$date = $res49['consultationdate'];
		$accoutname = $res49['accountfullname'];
		$res10age = $res49['age']; 
		$res10gender = $res49['gender'];
		$departmentanum = $res49['department'];
		
			//$departmentanum = $res1['department'];
			
				$query505 = "select department from master_ipadmdept where recordstatus = '' and deptid='$departmentanum'";
				$exec505 = mysql_query($query505) or die ("Error in Query505".mysql_error());
				$res505 = mysql_fetch_array($exec505);
				
				$department = $res505["department"];
				
				
		
		
/*		$query10 = "select * from master_ipvisitentry where patientcode='$patientcode' ";
		$exec10 = mysql_query($query10) or die(mysql_error());
		$res10 = mysql_fetch_array($exec10);
		$res10age = $res10['age'];
		$res10gender = $res10['gender'];
		*/
		}
		else
		{
		$query592 = "select * from ip_bedtransfer where ward='$wardnum' and bed='$bedanum' and recordstatus = '' order by auto_number desc limit 0, 1";
		$exec592 = mysql_query($query592) or die(mysql_error());
		$res592 = mysql_fetch_array($exec592);
		$num592 = mysql_num_rows($exec592);
		if($num592 > 0)
		{
		$ward = $res592['ward'];
		$bed = $res592['bed'];
		$patientname = $res592['patientname'];
		$patientcode = $res592['patientcode'];
		$visitcode = $res592['visitcode'];
		
		$query10 = "select consultationdate,accountfullname,age,gender,department from master_ipvisitentry where patientcode='$patientcode' ";
		$exec10 = mysql_query($query10) or die(mysql_error());
		$res10 = mysql_fetch_array($exec10);
		$res10age = $res10['age'];
		$res10gender = $res10['gender'];
		$date = $res10['consultationdate'];
		$accoutname = $res10['accountfullname'];
				$departmentanum = $res10['department'];
								$query5051 = "select department from master_ipadmdept where recordstatus = '' and deptid='$departmentanum'";
				$exec5051 = mysql_query($query5051) or die ("Error in Query5051".mysql_error());
				$res5051 = mysql_fetch_array($exec5051);
				
				$department = $res5051["department"];
		
/*		$query492 = "select * from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode' order by auto_number desc limit 0, 1" ;
		$exec492 = mysql_query($query492) or die(mysql_error());
		$res492 = mysql_fetch_array($exec492);
		$date = $res492['consultationdate'];
		$accoutname = $res492['accountfullname'];
*/		}
		}
		   
		   
			
			$query78 = "select docno from paed_babyrecord where  patientcode='$patientcode' and visitcode='$visitcode'";
			$exec78= mysql_query($query78) or die(mysql_error());
			$res78 = mysql_fetch_array($exec78);
			$docno1 = $res78['docno'];
			
			$query78 = "select docno from paed_admexamination where  patientcode='$patientcode' and visitcode='$visitcode'";
			$exec78= mysql_query($query78) or die(mysql_error());
			$res78 = mysql_fetch_array($exec78);
			$docno12 = $res78['docno'];
			
			
			
			$query7811 = "select ward from master_ward where auto_number='$ward' and recordstatus=''";
			$exec7811 = mysql_query($query7811) or die(mysql_error());
			$res7811 = mysql_fetch_array($exec7811);
			$wardname1 = $res7811['ward'];
			if($num69 > 0)
		    {
		
		   $query82 = "select visitcode from master_ipvisitentry where patientcode='$patientcode' and visitcode='$visitcode' and discharge = ''";
		   $exec82 = mysql_query($query82) or die(mysql_error());
		   $num82 = mysql_num_rows($exec82);
		   if($num82 > 0)
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
			
				$query55 = "select ip_dept from master_employee where username = '$username'";
				$exec55 = mysql_query($query55) or die ("Error in Query55".mysql_error());
				$res55 = mysql_fetch_array($exec55);
			    $userdept = $res55["ip_dept"];
				 
			if($userdept=='all')
			{
			?>
			
          <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
		
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientname; ?></div></td>
				
				  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res10age; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res10gender; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientcode; ?></div></td>
					  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $date; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><a href="ipquickview.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>" target="_blank"><strong><?php echo $visitcode; ?></strong></a></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $wardname1; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $bedname; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $department; ?></div></td>
                
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $accoutname; ?></div></td>
                
				<td class="bodytext31" valign="center"  align="left">
			    <select name="order" id="order" onChange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
				<option>Select Activity</option>
				<option value="paed_babyrecordview.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docno=<?php echo $docno1; ?>">Baby Record</option>
				<option value="paed_admissionrecordview.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>&&docno=<?php echo $docno12; ?>">Admission Record</option>
				<option value="paed_foodintake.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">Food</option>
				<option value="paed_feedingcard.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">Feedingcard</option>
				</select></td>
              </tr>
		   <?php 
			}
			else
			{
									if($userdept == $departmentanum)
				{
					?>
          <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
		
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientname; ?></div></td>
				
				  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res10age; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $res10gender; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $patientcode; ?></div></td>
					  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $date; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><a href="ipquickview.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>" target="_blank"><strong><?php echo $visitcode; ?></strong></a></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $wardname1; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $bedname; ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $department; ?></div></td>
                
				  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $accoutname; ?></div></td>
                
				<td class="bodytext31" valign="center"  align="left">
			    <select name="order" id="order" onChange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
				<option>Select Activity</option>
				<option value="ipdrugchart.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">Drug Chart</option>
				<!--<option value="vitalio.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">Vital I/O</option>-->
				<option value="vitals.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">Vitals</option>
				<option value="fluidbalance.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">Input / Output</option>
				<option value="ipprogressnotes.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">Nursing Cardex</option>
				<option value="ipdoctornotes.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">Doctors Notes</option>
				<option value="ipotrequest.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">OT Request</option>
				<option value="ipicdentry.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">ICD</option>
			    <option value="ipclinicalrecords.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>">Clinical Records</option>
				</select></td>
              </tr>
                    
                    <?php
				}
	
			}
		   }
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


?>		</td>
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

