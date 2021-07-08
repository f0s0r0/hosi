<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');


  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
  $locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';
  $transactiondatefrom=isset($_REQUEST['ADate1'])?$_REQUEST['ADate1']:'';
   $transactiondateto=isset($_REQUEST['ADate2'])?$_REQUEST['ADate2']:'';
   if($transactiondatefrom=='')
   {
   $transactiondatefrom = date('Y-m-d', strtotime('-1 month')); }
    if($transactiondateto==''){
   $transactiondateto =  date('Y-m-d');}
 
$totalhospitalrevenue = '0.00';
$colorloopcount = 0;
$rowtot1 = 0;
$rowtot2 = 0;
$rowtot3 = 0;
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
.style2 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
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
        <td width="860"><form name="cbform1" method="post" action="hospitalrevenuereport.php">
          <table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Hospital Revenue </strong></td>
              <td colspan="2" align="right" bgcolor="#CCCCCC" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
                  <?php
						
						if ($location!='')
						{
							
						$query12 = "select locationname from master_location where locationcode='$location' order by locationname";
						$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
						$res12 = mysql_fetch_assoc($exec12);
						
						echo $res1location = $res12['locationname'];
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
          <td width="76" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="123" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1"  value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly"  />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="51" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td width="129" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
            <input name="ADate2" id="ADate2"  value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly"  />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
          </tr>
		  <tr>
		   <td width="68" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Location </strong></span></td>
          <td width="263" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
           <select name="location" id="location"  onChange=" ajaxlocationfunction(this.value);" >
		   <?php 
		   $query = "select locationname,locationcode from login_locationdetails where username='$username' and docno='$docno' order by locationname"; 
           $exec = mysql_query($query) or die ("Error in Query1".mysql_error());
           while($res = mysql_fetch_array($exec))
			{
	 		$locationname  = $res["locationname"]; 
	 		$locationcode = $res["locationcode"];
     		//$reslocationanum = $res["auto_number"];
			?>
		    <option value="<?php echo $locationcode; ?>" <?php if($location!='')if($location==$locationcode){echo "selected";}?>><?php echo $locationname; ?></option>
		   <?php } ?>
		   </select></span></td>
		   <td width="68" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> &nbsp;</strong></span></td>
		    <td width="263" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">&nbsp;</span></td>
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
      </tr>
      
      
      <tr>
        <td>&nbsp;</td>
      </tr>
	  <tr>
        <td>
	<form name="form1" id="form1" method="post" action="labresultsviewlist.php">	
		
<?php
	/*$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

if ($cbfrmflag1 == 'cbfrmflag1')
{

	$fromdate=$_POST['ADate1'];
	$todate=$_POST['ADate2'];
	$searchlocationcode=$_POST['location'];
	
?>
		

<?php
}*/
?>	

<table width="auto" id="AutoNumber3" style="BORDER-COLLAPSE: collapse"  bordercolor="#666666" cellspacing="0" cellpadding="4"  align="left" border="0">
          <tbody>
            <tr>
             <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Hospital Renenue </strong></td>
              <!--<td width="10%" bgcolor="#cccccc" class="bodytext31">Ip Renenue</td>-->
              <td colspan="26" bgcolor="#cccccc" class="bodytext31">
              <?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					if (isset($_REQUEST["cbcustomername"])) { $cbcustomername = $_REQUEST["cbcustomername"]; } else { $cbcustomername = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["customername"])) { $customername = $_REQUEST["customername"]; } else { $customername = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
					if (isset($_REQUEST["cbbillnumber"])) { $cbbillnumber = $_REQUEST["cbbillnumber"]; } else { $cbbillnumber = ""; }
					//$cbbillnumber = $_REQUEST['cbbillnumber'];
					if (isset($_REQUEST["cbbillstatus"])) { $cbbillstatus = $_REQUEST["cbbillstatus"]; } else { $cbbillstatus = ""; }
					//$cbbillstatus = $_REQUEST['cbbillstatus'];
					
					$transactiondatefrom = $_REQUEST['ADate1'];
					$transactiondateto = $_REQUEST['ADate2'];
					$fromdate = $_REQUEST['ADate1'];
					$todate = $_REQUEST['ADate2'];
				
					?>
               </td>
            </tr>
            
		    <tr <?php //echo $colorcode; ?> margin='10'>
              <td width="32" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"></td>
              <td width="126"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Adm Fee</strong> </div></td>
                  <td width="78"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>IP&nbsp;Package</strong></div></td>
			      <td width="56"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Bed</strong></div></td>
			      <td width="68"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Nursing</strong></div></td>
			      <td width="26"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>RMO</strong></div></td>
  				    <td width="31"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Lab</strong></div></td>
  				    <td width="24"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Rad</strong></div></td>
  				    <td width="42"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Pharma</strong></div></td>
  				    <td width="49"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Services</strong></div></td>
  				    <td width="63"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Ambulance</strong></div></td>
                     <td width="58"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Homecare</strong></div></td>
			      <td width="43"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Pvt Dr</strong></div></td>
				  <td width="78"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Misc&nbsp;Billing</strong></div></td>
              <td width="55" align="right" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>Total</strong></td>
             </tr>
            <?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
		        if($location!='All')
				{
				
		$admissionamount=0.00;
		$ipdiscountamount = 0.00;
		$totaladmissionamount = 0.00;
		$totallabamount = 0.00;
		$totalpharmacyamount = 0.00;
		$totalradiologyamount = 0.00;
		$totalservicesamount = 0.00;
		//$totalotamount = 0.00;
		$totalambulanceamount = 0.00;
		$totalprivatedoctoramount = 0.00;
		$totalipbedcharges = 0.00;
		$totalipnursingcharges = 0.00;
		$totaliprmocharges = 0.00;
		$totalipdiscountamount = 0.00;
		$totalipmiscamount = 0.00;
		$totaltransactionamount = 0.00;
		$colorcode = '';
		$transactionamount = 0.00;
		$totalhospitalrevenue = '0.00';
		$totalpackagecharge=0.00;
		$totalhomecareamount=0.00;
		$totalotamount=0.00;
		$totaliprefundamount=0.00;
		$totalnhifamount =0.00;
		
		//VARIABLES FOR -- CREDITNOTE--
		
		
		$bedchgsdiscount=0;
		$labchgsdiscount=0;
		$nursechgsdiscount=0;
		$pharmachgsdiscount=0;
		$radchgsdiscount = 0;
		$rmochgsdiscount = 0;
		$servchgsdiscount = 0;
		
		$totbedchgdisc=0;
		$totlabchgdisc=0;
		$totnursechgdisc=0;
		$totpharmachgdisc=0;
		$totradchgdisc=0;
		$totrmochgdisc=0;
		$totservchgdisc=0;
		
		$brfbedchgsdiscount = 0;
		$brflabchgsdiscount = 0;
		$brfnursechgsdiscount = 0;
		$brfpharmachgsdiscount=0;
		$brfradchgsdiscount=0;
		$brfrmochgsdiscount = 0;
		$brfservchgsdiscount  = 0;
		
		$totbrfbeddisc=0;
		$totbrflabdisc=0;
		$totbrfnursedisc=0;
		$totbrfpharmadisc=0;
		$totbrfraddisc=0;
		$totbrfrmodisc=0;
		$totbrfservdisc=0;
		
		$totcreditnotebedchgs = 0;
		$totcreditnotelabchgs = 0; 
		$totcreditnotenursechgs = 0;
		$totcreditnotepharmachgs = 0; 
		$totcreditnoteradchgs = 0;
		$totcreditnotermochgs = 0;
		$totcreditnoteservchgs = 0;
		
		$totadmn = 0;
		$totpkg = 0;
		$totbed = 0;
		$totnur = 0;
		$totrmo = 0;
		$totlab = 0;
		$totrad = 0;
		$totpha = 0;
		$totser = 0;
		$totamb = 0;
		$tothom = 0;
		$totdr = 0;
		$totmisc = 0;
		
		
		//QUERY TO GET PATIENT DETAILS TO PASS
	   $query1 = "select  patientname,patientcode,visitcode from billing_ip where locationcode='$locationcode1' and patientbilltype = 'PAY NOW' and billdate between '$fromdate' and '$todate' group by visitcode  order by auto_number DESC ";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		
		while($res1 = mysql_fetch_array($exec1))
		{
		$patientname=$res1['patientname'];
		$patientcode=$res1['patientcode'];
		$visitcode=$res1['visitcode'];
		
	   	
		//VENU -- CHANGE QUERY
		 //$query112 = "select  sum(packagecharge)  from master_ipvisitentry where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and consultationdate between '$fromdate' and '$todate'  ";
		
		//TO GET TOTAL IP PACKAGE CHARGES AMOUNT  
		 $query112 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description!='Resident Doctor Charges' and description!='Ward Dispensing Charges' and description!='bed charges' and recorddate between '$fromdate' and '$todate' ";
		  
		$exec112 = mysql_query($query112) or die ("Error in Query112".mysql_error());
		$num112=mysql_num_rows($exec112);
		$res112 = mysql_fetch_array($exec112);
		 $packagecharge=$res112['sum(amount)'];
		$totalpackagecharge=$totalpackagecharge + $packagecharge; 

		//TO GET TOTAL ADMIN FEE
	     $query2 = "select  amount  from billing_ipadmissioncharge where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		 
		$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		$num2=mysql_num_rows($exec2);
		$res2 = mysql_fetch_array($exec2);				
		$admissionamount=$res2['amount'];
	    $totaladmissionamount=$totaladmissionamount + $admissionamount; 
		
		//TO GET TOTAL LAB AMOUNT
		  $query3 = "select sum(labitemrate) from billing_iplab where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
		$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
		$num3=mysql_num_rows($exec3);
	    $res3 = mysql_fetch_array($exec3);
		$labamount=$res3['sum(labitemrate)'];
		 $totallabamount=$totallabamount + $labamount;
		
		//TO GET TOTAL RADIOLOGY CHARGES AMOUNT
		  $query4 = "select sum(radiologyitemrate) from billing_ipradiology where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
		$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		$num4=mysql_num_rows($exec4);
		$res4 = mysql_fetch_array($exec4);
		$radiologyamount=$res4['sum(radiologyitemrate)'];
	   $totalradiologyamount=$totalradiologyamount + $radiologyamount;

		 //TO GET TOTAL PHARMACY CHARGES AMOUNT
		 $query5 = "select sum(amount) from billing_ippharmacy where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
		$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
		$num5=mysql_num_rows($exec5);
		$res5 = mysql_fetch_array($exec5);
		$pharmacyamount=$res5['sum(amount)'];
		 $totalpharmacyamount=$totalpharmacyamount + $pharmacyamount;
	
		//TO GET TOTAL SERVICE CHARGES AMOUNT
	    $query6 = "select sum(servicesitemrate) from billing_ipservices where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
		$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
		$num6=mysql_num_rows($exec6);
		$res6 = mysql_fetch_array($exec6);
		$servicesamount=$res6['sum(servicesitemrate)'];
           $totalservicesamount=$totalservicesamount + $servicesamount;
		
		//VENU -- REMOVE OT
		/* $query7 = "select sum(amount) from billing_ipotbilling where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
		$num7=mysql_num_rows($exec7);
		$res7 = mysql_fetch_array($exec7);
		$otamount=$res7['sum(amount)'];
		 $totalotamount=$totalotamount + $otamount;*/
	     
		 //TO GET TOTAL AMBULANCE CHARGES AMOUNT
	     $query8 = "select sum(amount) from billing_ipambulance where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
		$num8=mysql_num_rows($exec8);
		$res8 = mysql_fetch_array($exec8);
		$ambulanceamount=$res8['sum(amount)'];
		 $totalambulanceamount=$totalambulanceamount + $ambulanceamount;
		 
		 
		 //TO GET TOTAL HOME CARE CHARGES AMOUNT
		 $query81 = "select sum(amount) from billing_iphomecare where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		$exec81 = mysql_query($query81) or die ("Error in Query81".mysql_error());
		$num81=mysql_num_rows($exec81);
		$res81 = mysql_fetch_array($exec81);
		$homecareamount=$res81['sum(amount)'];
		 $totalhomecareamount=$totalhomecareamount + $homecareamount;
		
		//VENU -- CHANGE THE QUERY
		// $query8 = "select sum(amount) from billing_ipprivatedoctor where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		
		//TO GET TOTAL PRIVATE DOCTER CHARGES AMOUNT
		$query8 = "select sum(amount) from billing_ipprivatedoctor where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and billtype <>'' and recorddate between '$fromdate' and '$todate'  ";
		$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
		$num8=mysql_num_rows($exec8);
		$res8 = mysql_fetch_array($exec8);
		$privatedoctoramount=$res8['sum(amount)'];
		$totalprivatedoctoramount=$totalprivatedoctoramount + $privatedoctoramount;
		
		 //TO GET TOTAL BED CHARGES AMOUNT
		 $query9 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'bed charges' and recorddate between '$fromdate' and '$todate' ";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		 $num9=mysql_num_rows($exec9);
		$res9 = mysql_fetch_array($exec9);
		$ipbedcharges=$res9['sum(amount)'];
		$totalipbedcharges=$totalipbedcharges + $ipbedcharges;
		
    
		//VENU -- CHANGE THE QUERY
		
		//TO GET TOTAL IP NURSE CHARGES AMOUNT
	    $query10 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'Ward Dispensing Charges' and recorddate between '$fromdate' and '$todate' ";
		$exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());
		$num10=mysql_num_rows($exec10);
		$res10 = mysql_fetch_array($exec10);
		$ipnursingcharges=$res10['sum(amount)'];
		$totalipnursingcharges=$totalipnursingcharges + $ipnursingcharges;
		
		//VENU-CHANGING QUERY
		//$query11 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'RMO charges' and recorddate between '$fromdate' and '$todate' ";
		
		//TO GET TOTAL RMO CHARGES AMOUNT
		$query11 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'Resident Doctor Charges' and recorddate between '$fromdate' and '$todate' ";
		$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
		$num11=mysql_num_rows($exec11);
		$res11 = mysql_fetch_array($exec11);
		$iprmocharges=$res11['sum(amount)'];
		$totaliprmocharges=$totaliprmocharges + $iprmocharges;
		
		//VENU-- REMOVE DEPOSIT AMOUNT
		/*$query13 = "select sum(rate) from ip_discount where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and consultationdate between '$fromdate' and '$todate' ";
		$exec13 = mysql_query($query13) or die ("Error in Query13".mysql_error());
		$num13=mysql_num_rows($exec13);
		$res13 = mysql_fetch_array($exec13);
		$ipdiscountamount=$res13['sum(rate)'];
		
		$totalipdiscountamount=$totalipdiscountamount + $ipdiscountamount;*/
		//ENDS
		
		//VENU -- REMOVE IP REFUND
		/*$query133 = "select sum(amount) from deposit_refund where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";
		$exec133 = mysql_query($query133) or die ("Error in Query133".mysql_error());
		$num133=mysql_num_rows($exec133);
		$res133 = mysql_fetch_array($exec133);
		$iprefundamount=$res133['sum(amount)'];
		
		$totaliprefundamount=$totaliprefundamount + $iprefundamount;*/
		//ENDS
		
		//VENU -- REMOVE NHIF
		/*$query1333 = "select sum(nhifclaim) from ip_nhifprocessing where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and consultationdate between '$fromdate' and '$todate' ";
		$exec1333 = mysql_query($query1333) or die ("Error in Query1333".mysql_error());
		$num1333=mysql_num_rows($exec1333);
		$res1333 = mysql_fetch_array($exec1333);
		$nhifamount=$res1333['sum(nhifclaim)'];
		
		$totalnhifamount=$totalnhifamount + $nhifamount;*/
		//ENDS
		
		//TO GET TOTAL IP MISC BILL AMOUNT
		$query14 = "select sum(amount) from billing_ipmiscbilling where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";
		$exec14 = mysql_query($query14) or die ("Error in Query14".mysql_error());
		$num14=mysql_num_rows($exec14);
		$res14 = mysql_fetch_array($exec14);
		$ipmiscamount=$res14['sum(amount)'];
		$totalipmiscamount=$totalipmiscamount + $ipmiscamount;
		
		
		//TO GET PATIEN NAME, PATIENT REGISTER NUMBER, PATIEN VISIT CODE
		 $query15 = "select patientname,patientcode,visitcode from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";
		$exec15 = mysql_query($query15) or die ("Error in Query15".mysql_error());
		$num15=mysql_num_rows($exec15);
		
		$res15 = mysql_fetch_array($exec15);
		
		$res15patientname=$res1['patientname'];
		$res15patientcode=$res1['patientcode'];
		$res15visitcode=$res1['visitcode'];
		
		
		
		
		//TO GET TOTAL TRANSACTION AMOUNT
		$query12 = "select transactionamount,docno from master_transactionipdeposit where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and transactiondate between '$fromdate' and '$todate' ";
		$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
		$num12=mysql_num_rows($exec12);
		
		while($res12 = mysql_fetch_array($exec12))
		{
			 $transactionamount=$res12['transactionamount'];
			 $referencenumber=$res12['docno'];
			 $totaltransactionamount=$totaltransactionamount + $transactionamount;
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
		   <?php 
		     }
			 $totadmn = $totadmn + $totaladmissionamount;
			$totpkg = $totpkg + $totalpackagecharge;
			$totbed = $totbed + $totalipbedcharges;
			$totnur = $totnur + $totalipnursingcharges;
			$totrmo = $totrmo + $totaliprmocharges;
			$totlab = $totlab + $totallabamount;
			$totrad = $totrad + $totalradiologyamount;
			$totpha = $totpha + $totalpharmacyamount;
			$totser = $totser + $totalservicesamount;
			$totamb = $totamb + $totalambulanceamount;
			$tothom = $tothom + $totalhomecareamount;
			$totdr = $totdr + $totalprivatedoctoramount;
			$totmisc = $totmisc + $totalipmiscamount;
			
			$rowtot1 = $totaladmissionamount+$totalpackagecharge+$totalipbedcharges+$totalipnursingcharges+$totaliprmocharges+$totallabamount+$totalradiologyamount+
						$totalpharmacyamount+$totalservicesamount+$totalambulanceamount+$totalhomecareamount+$totalprivatedoctoramount+$totalipmiscamount;
			 ?>
			 <tr bgcolor="#D3EEB7">
              <td class="bodytext31" valign="center"  align="left"><div align="center"><strong>Cash</strong></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totaladmissionamount,2,'.',','); ?></div></td>
                 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totalpackagecharge,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totalipbedcharges,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totalipnursingcharges,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totaliprmocharges,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			      <div align="right"><?php echo number_format($totallabamount,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			      <div align="right"><?php echo number_format($totalradiologyamount,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			      <div align="right"><?php echo number_format($totalpharmacyamount,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			        <div align="right"><?php echo number_format($totalservicesamount,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			        <div align="right"><?php echo number_format($totalambulanceamount,2,'.',','); ?></div></td>
                    <td class="bodytext31" valign="center"  align="left">
			        <div align="right"><?php echo number_format($totalhomecareamount,2,'.',','); ?></div></td>
				   <td class="bodytext31" valign="center"  align="left">
			         <div align="right"><?php echo number_format($totalprivatedoctoramount,2,'.',','); ?></div></td>
				  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($totalipmiscamount,2,'.',','); ?></div></td>
                   <td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo number_format($rowtot1,2,'.',','); ?></strong></div></td>
                  </tr>
        <?php
		$admissionamount=0.00;
		$ipdiscountamount = 0.00;
		$totaladmissionamount = 0.00;
		$totallabamount = 0.00;
		$totalpharmacyamount = 0.00;
		$totalradiologyamount = 0.00;
		$totalservicesamount = 0.00;
		//$totalotamount = 0.00;
		$totalambulanceamount = 0.00;
		$totalprivatedoctoramount = 0.00;
		$totalipbedcharges = 0.00;
		$totalipnursingcharges = 0.00;
		$totaliprmocharges = 0.00;
		$totalipdiscountamount = 0.00;
		$totalipmiscamount = 0.00;
		$totaltransactionamount = 0.00;
		$colorcode = '';
		$transactionamount = 0.00;
		$totalhospitalrevenue = '0.00';
		$totalpackagecharge=0.00;
		$totalhomecareamount=0.00;
		$totalotamount=0.00;
		$totaliprefundamount=0.00;
		$totalnhifamount =0.00;
		
		//VARIABLES FOR -- CREDITNOTE--
		
		
		$bedchgsdiscount=0;
		$labchgsdiscount=0;
		$nursechgsdiscount=0;
		$pharmachgsdiscount=0;
		$radchgsdiscount = 0;
		$rmochgsdiscount = 0;
		$servchgsdiscount = 0;
		
		$totbedchgdisc=0;
		$totlabchgdisc=0;
		$totnursechgdisc=0;
		$totpharmachgdisc=0;
		$totradchgdisc=0;
		$totrmochgdisc=0;
		$totservchgdisc=0;
		
		$brfbedchgsdiscount = 0;
		$brflabchgsdiscount = 0;
		$brfnursechgsdiscount = 0;
		$brfpharmachgsdiscount=0;
		$brfradchgsdiscount=0;
		$brfrmochgsdiscount = 0;
		$brfservchgsdiscount  = 0;
		
		$totbrfbeddisc=0;
		$totbrflabdisc=0;
		$totbrfnursedisc=0;
		$totbrfpharmadisc=0;
		$totbrfraddisc=0;
		$totbrfrmodisc=0;
		$totbrfservdisc=0;
		
		$totcreditnotebedchgs = 0;
		$totcreditnotelabchgs = 0; 
		$totcreditnotenursechgs = 0;
		$totcreditnotepharmachgs = 0; 
		$totcreditnoteradchgs = 0;
		$totcreditnotermochgs = 0;
		$totcreditnoteservchgs = 0;
		
		
		//QUERY TO GET PATIENT DETAILS TO PASS
	   $query105 = "select  patientname,patientcode,visitcode from billing_ip where locationcode='$locationcode1' and patientbilltype = 'PAY LATER' and billdate between '$fromdate' and '$todate' group by visitcode  order by auto_number DESC ";
		$exec105 = mysql_query($query105) or die ("Error in query105".mysql_error());
		$num105=mysql_num_rows($exec105);
		
		while($res105 = mysql_fetch_array($exec105))
		{
		$patientname=$res105['patientname'];
		$patientcode=$res105['patientcode'];
		$visitcode=$res105['visitcode'];
		
	   	
		//VENU -- CHANGE QUERY
		 //$query112 = "select  sum(packagecharge)  from master_ipvisitentry where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and consultationdate between '$fromdate' and '$todate'  ";
		
		//TO GET TOTAL IP PACKAGE CHARGES AMOUNT  
		 $query112 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description!='Resident Doctor Charges' and description!='Ward Dispensing Charges' and description!='bed charges' and recorddate between '$fromdate' and '$todate' ";
		  
		$exec112 = mysql_query($query112) or die ("Error in Query112".mysql_error());
		$num112=mysql_num_rows($exec112);
		$res112 = mysql_fetch_array($exec112);
		 $packagecharge=$res112['sum(amount)'];
		$totalpackagecharge=$totalpackagecharge + $packagecharge; 

		//TO GET TOTAL ADMIN FEE
	     $query2 = "select  amount  from billing_ipadmissioncharge where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		 
		$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		$num2=mysql_num_rows($exec2);
		$res2 = mysql_fetch_array($exec2);				
		$admissionamount=$res2['amount'];
	    $totaladmissionamount=$totaladmissionamount + $admissionamount; 
		
		//TO GET TOTAL LAB AMOUNT
		  $query3 = "select sum(labitemrate) from billing_iplab where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
		$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
		$num3=mysql_num_rows($exec3);
	    $res3 = mysql_fetch_array($exec3);
		$labamount=$res3['sum(labitemrate)'];
		 $totallabamount=$totallabamount + $labamount;
		
		//TO GET TOTAL RADIOLOGY CHARGES AMOUNT
		  $query4 = "select sum(radiologyitemrate) from billing_ipradiology where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
		$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		$num4=mysql_num_rows($exec4);
		$res4 = mysql_fetch_array($exec4);
		$radiologyamount=$res4['sum(radiologyitemrate)'];
	   $totalradiologyamount=$totalradiologyamount + $radiologyamount;

		 //TO GET TOTAL PHARMACY CHARGES AMOUNT
		 $query5 = "select sum(amount) from billing_ippharmacy where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
		$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
		$num5=mysql_num_rows($exec5);
		$res5 = mysql_fetch_array($exec5);
		$pharmacyamount=$res5['sum(amount)'];
		 $totalpharmacyamount=$totalpharmacyamount + $pharmacyamount;
	
		//TO GET TOTAL SERVICE CHARGES AMOUNT
	    $query6 = "select sum(servicesitemrate) from billing_ipservices where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
		$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
		$num6=mysql_num_rows($exec6);
		$res6 = mysql_fetch_array($exec6);
		$servicesamount=$res6['sum(servicesitemrate)'];
           $totalservicesamount=$totalservicesamount + $servicesamount;
		
		//VENU -- REMOVE OT
		/* $query7 = "select sum(amount) from billing_ipotbilling where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
		$num7=mysql_num_rows($exec7);
		$res7 = mysql_fetch_array($exec7);
		$otamount=$res7['sum(amount)'];
		 $totalotamount=$totalotamount + $otamount;*/
	     
		 //TO GET TOTAL AMBULANCE CHARGES AMOUNT
	     $query8 = "select sum(amount) from billing_ipambulance where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
		$num8=mysql_num_rows($exec8);
		$res8 = mysql_fetch_array($exec8);
		$ambulanceamount=$res8['sum(amount)'];
		 $totalambulanceamount=$totalambulanceamount + $ambulanceamount;
		 
		 
		 //TO GET TOTAL HOME CARE CHARGES AMOUNT
		 $query81 = "select sum(amount) from billing_iphomecare where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		$exec81 = mysql_query($query81) or die ("Error in Query81".mysql_error());
		$num81=mysql_num_rows($exec81);
		$res81 = mysql_fetch_array($exec81);
		$homecareamount=$res81['sum(amount)'];
		 $totalhomecareamount=$totalhomecareamount + $homecareamount;
		
		//VENU -- CHANGE THE QUERY
		// $query8 = "select sum(amount) from billing_ipprivatedoctor where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		
		//TO GET TOTAL PRIVATE DOCTER CHARGES AMOUNT
		$query8 = "select sum(amount) from billing_ipprivatedoctor where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and billtype <>'' and recorddate between '$fromdate' and '$todate'  ";
		$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
		$num8=mysql_num_rows($exec8);
		$res8 = mysql_fetch_array($exec8);
		$privatedoctoramount=$res8['sum(amount)'];
		$totalprivatedoctoramount=$totalprivatedoctoramount + $privatedoctoramount;
		
		 //TO GET TOTAL BED CHARGES AMOUNT
		 $query9 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'bed charges' and recorddate between '$fromdate' and '$todate' ";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		 $num9=mysql_num_rows($exec9);
		$res9 = mysql_fetch_array($exec9);
		$ipbedcharges=$res9['sum(amount)'];
		$totalipbedcharges=$totalipbedcharges + $ipbedcharges;
		
    
		//VENU -- CHANGE THE QUERY
		
		//TO GET TOTAL IP NURSE CHARGES AMOUNT
	    $query10 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'Ward Dispensing Charges' and recorddate between '$fromdate' and '$todate' ";
		$exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());
		$num10=mysql_num_rows($exec10);
		$res10 = mysql_fetch_array($exec10);
		$ipnursingcharges=$res10['sum(amount)'];
		$totalipnursingcharges=$totalipnursingcharges + $ipnursingcharges;
		
		//VENU-CHANGING QUERY
		//$query11 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'RMO charges' and recorddate between '$fromdate' and '$todate' ";
		
		//TO GET TOTAL RMO CHARGES AMOUNT
		$query11 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'Resident Doctor Charges' and recorddate between '$fromdate' and '$todate' ";
		$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
		$num11=mysql_num_rows($exec11);
		$res11 = mysql_fetch_array($exec11);
		$iprmocharges=$res11['sum(amount)'];
		$totaliprmocharges=$totaliprmocharges + $iprmocharges;
		
		//VENU-- REMOVE DEPOSIT AMOUNT
		/*$query13 = "select sum(rate) from ip_discount where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and consultationdate between '$fromdate' and '$todate' ";
		$exec13 = mysql_query($query13) or die ("Error in Query13".mysql_error());
		$num13=mysql_num_rows($exec13);
		$res13 = mysql_fetch_array($exec13);
		$ipdiscountamount=$res13['sum(rate)'];
		
		$totalipdiscountamount=$totalipdiscountamount + $ipdiscountamount;*/
		//ENDS
		
		//VENU -- REMOVE IP REFUND
		/*$query133 = "select sum(amount) from deposit_refund where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";
		$exec133 = mysql_query($query133) or die ("Error in Query133".mysql_error());
		$num133=mysql_num_rows($exec133);
		$res133 = mysql_fetch_array($exec133);
		$iprefundamount=$res133['sum(amount)'];
		
		$totaliprefundamount=$totaliprefundamount + $iprefundamount;*/
		//ENDS
		
		//VENU -- REMOVE NHIF
		/*$query1333 = "select sum(nhifclaim) from ip_nhifprocessing where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and consultationdate between '$fromdate' and '$todate' ";
		$exec1333 = mysql_query($query1333) or die ("Error in Query1333".mysql_error());
		$num1333=mysql_num_rows($exec1333);
		$res1333 = mysql_fetch_array($exec1333);
		$nhifamount=$res1333['sum(nhifclaim)'];
		
		$totalnhifamount=$totalnhifamount + $nhifamount;*/
		//ENDS
		
		//TO GET TOTAL IP MISC BILL AMOUNT
		$query14 = "select sum(amount) from billing_ipmiscbilling where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";
		$exec14 = mysql_query($query14) or die ("Error in Query14".mysql_error());
		$num14=mysql_num_rows($exec14);
		$res14 = mysql_fetch_array($exec14);
		$ipmiscamount=$res14['sum(amount)'];
		$totalipmiscamount=$totalipmiscamount + $ipmiscamount;
		
		
		//TO GET PATIEN NAME, PATIENT REGISTER NUMBER, PATIEN VISIT CODE
		 $query15 = "select patientname,patientcode,visitcode from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";
		$exec15 = mysql_query($query15) or die ("Error in Query15".mysql_error());
		$num15=mysql_num_rows($exec15);
		
		$res15 = mysql_fetch_array($exec15);
		
		$res15patientname=$res1['patientname'];
		$res15patientcode=$res1['patientcode'];
		$res15visitcode=$res1['visitcode'];
		
		
		
		
		//TO GET TOTAL TRANSACTION AMOUNT
		$query12 = "select transactionamount,docno from master_transactionipdeposit where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and transactiondate between '$fromdate' and '$todate' ";
		$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
		$num12=mysql_num_rows($exec12);
		
		while($res12 = mysql_fetch_array($exec12))
		{
			 $transactionamount=$res12['transactionamount'];
			 $referencenumber=$res12['docno'];
			 $totaltransactionamount=$totaltransactionamount + $transactionamount;
		} 	
		
		}
		
		$query186 = "select  patientname,patientcode,visitcode from billing_ipcreditapproved where locationcode='$locationcode1' and billdate between '$fromdate' and '$todate' group by visitcode  order by auto_number DESC ";
		$exec186 = mysql_query($query186) or die ("Error in Query186".mysql_error());
		$num186=mysql_num_rows($exec186);
		
		while($res186 = mysql_fetch_array($exec186))
		{ 
			 
		$patientname=$res186['patientname'];
		$patientcode=$res186['patientcode'];
		$visitcode=$res186['visitcode'];
		
	   	
		//VENU -- CHANGE QUERY
		 //$query112 = "select  sum(packagecharge)  from master_ipvisitentry where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and consultationdate between '$fromdate' and '$todate'  ";
		
		//TO GET TOTAL IP PACKAGE CHARGES AMOUNT  
		 $query112 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description!='Resident Doctor Charges' and description!='Ward Dispensing Charges' and description!='bed charges' and recorddate between '$fromdate' and '$todate' ";
		  
		$exec112 = mysql_query($query112) or die ("Error in Query112".mysql_error());
		$num112=mysql_num_rows($exec112);
		$res112 = mysql_fetch_array($exec112);
		 $packagecharge=$res112['sum(amount)'];
		$totalpackagecharge=$totalpackagecharge + $packagecharge; 

		//TO GET TOTAL ADMIN FEE
	     $query2 = "select  amount  from billing_ipadmissioncharge where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		 
		$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		$num2=mysql_num_rows($exec2);
		$res2 = mysql_fetch_array($exec2);				
		$admissionamount=$res2['amount'];
	    $totaladmissionamount=$totaladmissionamount + $admissionamount; 
		
		//TO GET TOTAL LAB AMOUNT
		  $query3 = "select sum(labitemrate) from billing_iplab where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
		$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
		$num3=mysql_num_rows($exec3);
	    $res3 = mysql_fetch_array($exec3);
		$labamount=$res3['sum(labitemrate)'];
		 $totallabamount=$totallabamount + $labamount;
		
		//TO GET TOTAL RADIOLOGY CHARGES AMOUNT
		  $query4 = "select sum(radiologyitemrate) from billing_ipradiology where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
		$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		$num4=mysql_num_rows($exec4);
		$res4 = mysql_fetch_array($exec4);
		$radiologyamount=$res4['sum(radiologyitemrate)'];
	   $totalradiologyamount=$totalradiologyamount + $radiologyamount;

		 //TO GET TOTAL PHARMACY CHARGES AMOUNT
		 $query5 = "select sum(amount) from billing_ippharmacy where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
		$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
		$num5=mysql_num_rows($exec5);
		$res5 = mysql_fetch_array($exec5);
		$pharmacyamount=$res5['sum(amount)'];
		 $totalpharmacyamount=$totalpharmacyamount + $pharmacyamount;
	
		//TO GET TOTAL SERVICE CHARGES AMOUNT
	    $query6 = "select sum(servicesitemrate) from billing_ipservices where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
		$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
		$num6=mysql_num_rows($exec6);
		$res6 = mysql_fetch_array($exec6);
		$servicesamount=$res6['sum(servicesitemrate)'];
           $totalservicesamount=$totalservicesamount + $servicesamount;
		
		//VENU -- REMOVE OT
		/* $query7 = "select sum(amount) from billing_ipotbilling where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
		$num7=mysql_num_rows($exec7);
		$res7 = mysql_fetch_array($exec7);
		$otamount=$res7['sum(amount)'];
		 $totalotamount=$totalotamount + $otamount;*/
	     
		 //TO GET TOTAL AMBULANCE CHARGES AMOUNT
	     $query8 = "select sum(amount) from billing_ipambulance where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
		$num8=mysql_num_rows($exec8);
		$res8 = mysql_fetch_array($exec8);
		$ambulanceamount=$res8['sum(amount)'];
		 $totalambulanceamount=$totalambulanceamount + $ambulanceamount;
		 
		 
		 //TO GET TOTAL HOME CARE CHARGES AMOUNT
		 $query81 = "select sum(amount) from billing_iphomecare where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		$exec81 = mysql_query($query81) or die ("Error in Query81".mysql_error());
		$num81=mysql_num_rows($exec81);
		$res81 = mysql_fetch_array($exec81);
		$homecareamount=$res81['sum(amount)'];
		 $totalhomecareamount=$totalhomecareamount + $homecareamount;
		
		//VENU -- CHANGE THE QUERY
		// $query8 = "select sum(amount) from billing_ipprivatedoctor where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		
		//TO GET TOTAL PRIVATE DOCTER CHARGES AMOUNT
		$query8 = "select sum(amount) from billing_ipprivatedoctor where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and billtype <>'' and recorddate between '$fromdate' and '$todate'  ";
		$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
		$num8=mysql_num_rows($exec8);
		$res8 = mysql_fetch_array($exec8);
		$privatedoctoramount=$res8['sum(amount)'];
		$totalprivatedoctoramount=$totalprivatedoctoramount + $privatedoctoramount;
		
		 //TO GET TOTAL BED CHARGES AMOUNT
		 $query9 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'bed charges' and recorddate between '$fromdate' and '$todate' ";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		 $num9=mysql_num_rows($exec9);
		$res9 = mysql_fetch_array($exec9);
		$ipbedcharges=$res9['sum(amount)'];
		$totalipbedcharges=$totalipbedcharges + $ipbedcharges;
		
    
		//VENU -- CHANGE THE QUERY
		
		//TO GET TOTAL IP NURSE CHARGES AMOUNT
	    $query10 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'Ward Dispensing Charges' and recorddate between '$fromdate' and '$todate' ";
		$exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());
		$num10=mysql_num_rows($exec10);
		$res10 = mysql_fetch_array($exec10);
		$ipnursingcharges=$res10['sum(amount)'];
		$totalipnursingcharges=$totalipnursingcharges + $ipnursingcharges;
		
		//VENU-CHANGING QUERY
		//$query11 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'RMO charges' and recorddate between '$fromdate' and '$todate' ";
		
		//TO GET TOTAL RMO CHARGES AMOUNT
		$query11 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'Resident Doctor Charges' and recorddate between '$fromdate' and '$todate' ";
		$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
		$num11=mysql_num_rows($exec11);
		$res11 = mysql_fetch_array($exec11);
		$iprmocharges=$res11['sum(amount)'];
		$totaliprmocharges=$totaliprmocharges + $iprmocharges;
		
		//VENU-- REMOVE DEPOSIT AMOUNT
		/*$query13 = "select sum(rate) from ip_discount where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and consultationdate between '$fromdate' and '$todate' ";
		$exec13 = mysql_query($query13) or die ("Error in Query13".mysql_error());
		$num13=mysql_num_rows($exec13);
		$res13 = mysql_fetch_array($exec13);
		$ipdiscountamount=$res13['sum(rate)'];
		
		$totalipdiscountamount=$totalipdiscountamount + $ipdiscountamount;*/
		//ENDS
		
		//VENU -- REMOVE IP REFUND
		/*$query133 = "select sum(amount) from deposit_refund where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";
		$exec133 = mysql_query($query133) or die ("Error in Query133".mysql_error());
		$num133=mysql_num_rows($exec133);
		$res133 = mysql_fetch_array($exec133);
		$iprefundamount=$res133['sum(amount)'];
		
		$totaliprefundamount=$totaliprefundamount + $iprefundamount;*/
		//ENDS
		
		//VENU -- REMOVE NHIF
		/*$query1333 = "select sum(nhifclaim) from ip_nhifprocessing where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and consultationdate between '$fromdate' and '$todate' ";
		$exec1333 = mysql_query($query1333) or die ("Error in Query1333".mysql_error());
		$num1333=mysql_num_rows($exec1333);
		$res1333 = mysql_fetch_array($exec1333);
		$nhifamount=$res1333['sum(nhifclaim)'];
		
		$totalnhifamount=$totalnhifamount + $nhifamount;*/
		//ENDS
		
		//TO GET TOTAL IP MISC BILL AMOUNT
		$query14 = "select sum(amount) from billing_ipmiscbilling where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";
		$exec14 = mysql_query($query14) or die ("Error in Query14".mysql_error());
		$num14=mysql_num_rows($exec14);
		$res14 = mysql_fetch_array($exec14);
		$ipmiscamount=$res14['sum(amount)'];
		$totalipmiscamount=$totalipmiscamount + $ipmiscamount;
		
		
		//TO GET PATIEN NAME, PATIENT REGISTER NUMBER, PATIEN VISIT CODE
		 $query15 = "select patientname,patientcode,visitcode from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";
		$exec15 = mysql_query($query15) or die ("Error in Query15".mysql_error());
		$num15=mysql_num_rows($exec15);
		
		$res15 = mysql_fetch_array($exec15);
		
		$res15patientname=$res1['patientname'];
		$res15patientcode=$res1['patientcode'];
		$res15visitcode=$res1['visitcode'];
		
		
		
		
		//TO GET TOTAL TRANSACTION AMOUNT
		$query12 = "select transactionamount,docno from master_transactionipdeposit where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and transactiondate between '$fromdate' and '$todate' ";
		$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
		$num12=mysql_num_rows($exec12);
		
		while($res12 = mysql_fetch_array($exec12))
		{
			 $transactionamount=$res12['transactionamount'];
			 $referencenumber=$res12['docno'];
			 $totaltransactionamount=$totaltransactionamount + $transactionamount;
		} 	
		
		}
	
			$totadmn = $totadmn + $totaladmissionamount;
			$totpkg = $totpkg + $totalpackagecharge;
			$totbed = $totbed + $totalipbedcharges;
			$totnur = $totnur + $totalipnursingcharges;
			$totrmo = $totrmo + $totaliprmocharges;
			$totlab = $totlab + $totallabamount;
			$totrad = $totrad + $totalradiologyamount;
			$totpha = $totpha + $totalpharmacyamount;
			$totser = $totser + $totalservicesamount;
			$totamb = $totamb + $totalambulanceamount;
			$tothom = $tothom + $totalhomecareamount;
			$totdr = $totdr + $totalprivatedoctoramount;
			$totmisc = $totmisc + $totalipmiscamount;
			
			$rowtot2 = $totaladmissionamount+$totalpackagecharge+$totalipbedcharges+$totalipnursingcharges+$totaliprmocharges+$totallabamount+$totalradiologyamount+
						$totalpharmacyamount+$totalservicesamount+$totalambulanceamount+$totalhomecareamount+$totalprivatedoctoramount+$totalipmiscamount;
			
		?>
			  <tr bgcolor="#CBDBFA">
              <td class="bodytext31" valign="center"  align="left"><div align="center"><strong>Credit</strong></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totaladmissionamount,2,'.',','); ?></div></td>
                 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totalpackagecharge,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totalipbedcharges,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totalipnursingcharges,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($totaliprmocharges,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			      <div align="right"><?php echo number_format($totallabamount,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			      <div align="right"><?php echo number_format($totalradiologyamount,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			      <div align="right"><?php echo number_format($totalpharmacyamount,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			        <div align="right"><?php echo number_format($totalservicesamount,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			        <div align="right"><?php echo number_format($totalambulanceamount,2,'.',','); ?></div></td>
                    <td class="bodytext31" valign="center"  align="left">
			        <div align="right"><?php echo number_format($totalhomecareamount,2,'.',','); ?></div></td>
				   <td class="bodytext31" valign="center"  align="left">
			         <div align="right"><?php echo number_format($totalprivatedoctoramount,2,'.',','); ?></div></td>
				  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($totalipmiscamount,2,'.',','); ?></div></td>
                  <td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo number_format($rowtot2,2,'.',','); ?></strong></div></td>
                  </tr>
        
          <?php
         $qrycreditbrf = "select patientcode, patientvisitcode,patientname from ip_creditnotebrief where locationcode = '$locationcode1' and consultationdate between '$fromdate' and '$todate' group by patientcode";
		  $execcredibrf = mysql_query($qrycreditbrf) or die ("Error in qrycreditbrf".mysql_error());
	
		while($rescreditbrf = mysql_fetch_array($execcredibrf))
		{
   			$pcode = $rescreditbrf["patientcode"];
   			$vcode =$rescreditbrf["patientvisitcode"]; 
			$patienname = $rescreditbrf["patientname"];
		  
		  //TO GET DISCOUT FOR BED CHGS -- ip_creditnotebrief
		  $qrybrfbedchgsdisc = "select sum(rate) as brfbedchgsdisc from ip_creditnotebrief where description='Bed Charges'  AND patientcode = '$pcode' AND patientvisitcode = '$vcode'  and locationcode = '$locationcode1' and consultationdate between '$fromdate' and '$todate'";
		   $execbrfbedchgsdisc = mysql_query($qrybrfbedchgsdisc) or die ("Error in qrybrfbedchgsdisc".mysql_error());
		   $rescbrfbedchgsdisc= mysql_fetch_array($execbrfbedchgsdisc);
		   $brfbedchgsdiscount = $rescbrfbedchgsdisc['brfbedchgsdisc'];
		   
		   $totbrfbeddisc = $totbrfbeddisc + $brfbedchgsdiscount;
		   
		   	//TO GET DISCOUT FOR LAB CHGS -- ip_creditnotebrief
			$qrybrflabchgsdisc = "SELECT sum(rate) AS brflabchgsdisc FROM ip_creditnotebrief WHERE description='Lab'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$fromdate' and '$todate'";
			$execbrflabchgsdisc = mysql_query($qrybrflabchgsdisc) or die ("Error in qrybrflabchgsdisc".mysql_error());
			$rescbrflabchgsdisc= mysql_fetch_array($execbrflabchgsdisc);
			$brflabchgsdiscount = $rescbrflabchgsdisc['brflabchgsdisc'];
				
			$totbrflabdisc = $totbrflabdisc + $brflabchgsdiscount;
			
			//TO GET DISCOUT FOR NURSING CHGS -- ip_creditnotebrief
			$qrybrfnursechgsdisc = "SELECT sum(rate) AS brfnursechgsdisc FROM ip_creditnotebrief WHERE description='Nursing Charges'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$fromdate' and '$todate'";
			$execbrfnursechgsdisc = mysql_query($qrybrfnursechgsdisc) or die ("Error in qrybrfnursechgsdisc".mysql_error());
			$rescbrfnursechgsdisc= mysql_fetch_array($execbrfnursechgsdisc);
			$brfnursechgsdiscount = $rescbrfnursechgsdisc['brfnursechgsdisc'];
				
			$totbrfnursedisc = $totbrfnursedisc + $brfnursechgsdiscount;
			
			//TO GET DISCOUT FOR PHARMACY CHGS  -- ip_creditnotebrief
			$qrybrfpharmachgsdisc = "SELECT sum(rate) AS brfpharmachgsdisc FROM ip_creditnotebrief WHERE description='Pharmacy'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$fromdate' and '$todate'";
			$execbrfpharmachgsdisc = mysql_query($qrybrfpharmachgsdisc) or die ("Error in qrybrfpharmachgsdisc".mysql_error());
			$rescbrfpharmachgsdisc= mysql_fetch_array($execbrfpharmachgsdisc);
			$brfpharmachgsdiscount = $rescbrfpharmachgsdisc['brfpharmachgsdisc'];
				
			$totbrfpharmadisc = $totbrfpharmadisc + $brfpharmachgsdiscount ;
			
			
			//TO GET DISCOUT FOR RADIOLOGY CHGS  -- ip_creditnotebrief
			$qrybrfradchgsdisc = "SELECT sum(rate) AS brfradchgsdisc FROM ip_creditnotebrief WHERE description='Radiology'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$fromdate' and '$todate'";
			$execbrfradchgsdisc = mysql_query($qrybrfradchgsdisc) or die ("Error in qrybrfradchgsdisc".mysql_error());
			$rescbrfradchgsdisc= mysql_fetch_array($execbrfradchgsdisc);
			$brfradchgsdiscount = $rescbrfradchgsdisc['brfradchgsdisc'];
				
			$totbrfraddisc = $totbrfraddisc + $brfradchgsdiscount;
			
			//TO GET DISCOUT FOR RMO CHGS -- ip_creditnotebrief
			$qrybrfrmochgsdisc = "SELECT sum(rate) AS brfrmochgsdisc FROM ip_creditnotebrief WHERE description='RMO Charges'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$fromdate' and '$todate'";
			$execbrfrmochgsdisc = mysql_query($qrybrfrmochgsdisc) or die ("Error in qrybrfrmochgsdisc".mysql_error());
			$rescbrfrmochgsdisc= mysql_fetch_array($execbrfrmochgsdisc);
			$brfrmochgsdiscount = $rescbrfrmochgsdisc['brfrmochgsdisc'];
				
			$totbrfrmodisc = $totbrfrmodisc + $brfrmochgsdiscount;
			
			//TO GET DISCOUT FOR SERVICEE CHGS-- ip_creditnotebrief
			$qrybrfservchgsdisc = "SELECT sum(rate) AS brfservchgsdisc FROM ip_creditnotebrief WHERE description='Service'  AND patientcode = '$pcode' AND patientvisitcode='$vcode' AND locationcode='$locationcode1' AND consultationdate BETWEEN '$fromdate' and '$todate'";
			$execbrfservchgsdisc = mysql_query($qrybrfservchgsdisc) or die ("Error in qrybrfservchgsdisc".mysql_error());
			$rescbrfservchgsdisc= mysql_fetch_array($execbrfservchgsdisc);
			$brfservchgsdiscount = $rescbrfservchgsdisc['brfservchgsdisc'];
				
			$totbrfservdisc = $totbrfservdisc + $brfservchgsdiscount;
			
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
         <!--DISPLAY CREDITNOTE DETAILS-->
         
         <!--DISPLAY ENDS-->
				<?php
				}
				
				//$totadmn += $totaladmissionamount;
				//$totpkg += $totalpackagecharge;
				$totbed -= $totbrfbeddisc;
				$totnur -= $totbrfnursedisc;
				$totrmo -= $totbrfrmodisc;
				$totlab -= $totbrflabdisc;
				$totrad -= $totbrfraddisc;
				$totpha -= $totbrfpharmadisc;
				$totser -= $totbrfservdisc;
				//$totamb += $totalambulanceamount;
				//$tothom += $totalhomecareamount;
				//$totdr += $totalprivatedoctoramount;
				//$totmisc += $totalipmiscamount;
				
				$rowtot3 = $totbrfbeddisc+$totbrfnursedisc+$totbrfrmodisc+$totbrflabdisc+$totbrfraddisc+$totbrfpharmadisc+$totbrfservdisc;
						
				?>
				<tr bgcolor="#D3EEB7">
              <td class="bodytext31" valign="center"  align="left"><div align="center"><strong>Credit Note</strong></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format($admissionamount,2,'.',','); ?>0.00</div></td>
                 <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format($packagecharge,2,'.',','); ?>0.00</div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo "-".number_format($totbrfbeddisc,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo "-".number_format($totbrfnursedisc,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo "-".number_format($totbrfrmodisc,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo "-".number_format($totbrflabdisc,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo "-".number_format($totbrfraddisc,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo "-".number_format($totbrfpharmadisc,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo "-".number_format($totbrfservdisc,2,'.',','); ?></div></td>
              
				  <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format($ambulanceamount,2,'.',','); ?>0.00</div></td>
                    <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format($homecareamount,2,'.',','); ?>0.00</div></td>
				   <td class="bodytext31" valign="center"  align="left"><div align="right"><?php //echo number_format($privatedoctoramount,2,'.',','); ?>0.00</div></td>
               
				  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php //echo number_format($ipmiscamount,2,'.',','); ?>0.00</div></td>
                  <td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo '-'.number_format($rowtot3,2,'.',','); ?></strong></div></td>
                  </tr>
				<?php
				}
				}
			$rowtot4 = $rowtot1+$rowtot2-$rowtot3;
			?>
			
			<tr bgcolor="#CCC">
              <td class="bodytext31" valign="center"  align="left"><div align="center"><strong>Total</strong></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="right"><strong><?php echo number_format($totadmn,2,'.',','); ?></strong></div></td>
                 <td class="bodytext31" valign="center"  align="left"><div align="right"><strong><?php echo number_format($totpkg,2,'.',','); ?></strong></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><strong><?php echo number_format($totbed,2,'.',','); ?></strong></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><strong><?php echo number_format($totnur,2,'.',','); ?></strong></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><strong><?php echo number_format($totrmo,2,'.',','); ?></strong></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><strong><?php echo number_format($totlab,2,'.',','); ?></strong></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="right"><strong><?php echo number_format($totrad,2,'.',','); ?></strong></div></td>
				<td class="bodytext31" valign="center"  align="left"><div align="right"><strong><?php echo number_format($totpha,2,'.',','); ?></strong></div></td>
				  <td class="bodytext31" valign="center"  align="left"><div align="right"><strong><?php echo number_format($totser,2,'.',','); ?></strong></div></td>
              
				  <td class="bodytext31" valign="center"  align="left"><div align="right"><strong><?php echo number_format($totamb,2,'.',','); ?></strong></div></td>
                    <td class="bodytext31" valign="center"  align="left"><div align="right"><strong><?php echo number_format($tothom,2,'.',','); ?></strong></div></td>
				   <td class="bodytext31" valign="center"  align="left"><div align="right"><strong><?php echo number_format($totdr,2,'.',','); ?></strong></div></td>
               
				  <td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo number_format($totmisc,2,'.',','); ?></strong></div></td>
                  <td  align="left" valign="center" class="bodytext31"><div align="right"><strong><?php echo number_format($rowtot4,2,'.',','); ?></strong></div></td>
                  
                  </tr>
				  
				  <?php
				  }
				  ?>
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

