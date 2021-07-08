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

$locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';
 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
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
        <td width="860"><form name="cbform1" method="post" action="hospitalrevenuereportdetailed.php">
          <table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Hospital Detail Revenue </strong></td>
              <td colspan="2" align="right" bgcolor="#CCCCCC" class="bodytext3" id="ajaxlocation"><strong> Location </strong>
             
            
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
          <td width="76" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td width="123" align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="51" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td width="129" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
            <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
          </tr>
           <tr>
  			  <td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
			 
				 <select name="location" id="location"  onChange=" ajaxlocationfunction(this.value);" >
                    <?php
						
						$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' order by locationname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						$loccode=array();
						while ($res1 = mysql_fetch_array($exec1))
						{
						$locationname = $res1["locationname"];
						$locationcode = $res1["locationcode"];
						
						?>
						<option value="<?php echo $locationcode; ?>" <?php if($location!='')if($location==$locationcode){echo "selected";}?>><?php echo $locationname; ?></option>
						<?php
						} 
						?>
                      </select>
					 
              </span></td>
			   <td width="10%" align="left" colspan="2" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
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
	$colorloopcount=0;
	$sno=0;
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

if ($cbfrmflag1 == 'cbfrmflag1')
{

	$fromdate=$_POST['ADate1'];
	$todate=$_POST['ADate2'];

	
?>
		<table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1334" 
            align="left" border="0">
          <tbody>
             <tr>
			 <td colspan="18" bgcolor="#cccccc" class="bodytext31" align="left" valign="middle"><strong>Hospital Detail Revenue</strong></td>
			 </tr>
			  <tr>
				  <td width="30" class="bodytext31" valign="center"  align="left" 
					bgcolor="#ffffff"><div align="center"><strong>S.No. </strong></div></td>
  				    <td width="193" class="bodytext31" valign="center"  align="left" 
					bgcolor="#ffffff"><div align="center"><strong>Patient</strong></div></td>
  				    <td width="64" class="bodytext31" valign="center"  align="left" 
					bgcolor="#ffffff"><div align="center"><strong>Reg No. </strong></div></td>
  				    <td width="66"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="center">IP No </div></td>
  				    <td width="55"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="right">Adm Fee </div></td>
  				    <td width="38"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="right">Bed</div></td>
  				    <td width="55"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="right">Nursing</div></td>
  				    <td width="55"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="right">RMO</div></td>
  				    <td width="54"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="right">Lab</div></td>
  				    <td width="44"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="right">Rad</div></td>
  				    <td width="61"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="right">Pharma</div></td>
  				    <td width="59"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="right">Services</div></td>
  				    <td width="59"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="right">OT</div></td>
  				    <td width="69"  align="left" valign="center" 
					bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Ambulance</strong></div></td>
				    <td width="58"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="right">Pvt Dr.</div></td>
				    <td width="82"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="right">Deposit</div></td>
					<td width="67"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="right">Discount</div></td>
					<td width="80"  align="left" valign="center" 
					bgcolor="#ffffff" class="style2"><div align="right">Misc Billing</div></td>
              </tr>					
        <?php
		$admissionamount=0.00;
		$ipdiscountamount = 0.00;
		$totaladmissionamount = 0.00;
		$totallabamount = 0.00;
		$totalpharmacyamount = 0.00;
		$totalradiologyamount = 0.00;
		$totalservicesamount = 0.00;
		$totalotamount = 0.00;
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
		
	    $query1 = "select * from master_ipvisitentry where locationcode='$locationcode1' and registrationdate between '$fromdate' and '$todate' order by auto_number DESC ";
		$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		$num1=mysql_num_rows($exec1);
		
		while($res1 = mysql_fetch_array($exec1))
		{
		$patientname=$res1['patientfullname'];
		$patientcode=$res1['patientcode'];
		$visitcode=$res1['visitcode'];
		$consultationdate=$res1['registrationdate'];
	  //  $docnumber=$res1['docno'];

	    $query2 = "select * from billing_ipadmissioncharge where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		$num2=mysql_num_rows($exec2);
		$res2 = mysql_fetch_array($exec2);
		$res2patientname=$res2['patientname'];
		$res2patientcode=$res2['patientcode'];
		$res2visitcode=$res2['visitcode'];
		
		$admissionamount=$res2['amount'];
	    $totaladmissionamount=$totaladmissionamount + $admissionamount;
		
		  $query3 = "select sum(labitemrate) from billing_iplab where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
		$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
		$num3=mysql_num_rows($exec3);
	    $res3 = mysql_fetch_array($exec3);
		$labamount=$res3['sum(labitemrate)'];
		 $totallabamount=$totallabamount + $labamount;
		
		  $query4 = "select * from billing_ipradiology where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
		$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		$num4=mysql_num_rows($exec4);
		$res4 = mysql_fetch_array($exec4);
		$radiologyamount=$res4['radiologyitemrate'];
	   $totalradiologyamount=$totalradiologyamount + $radiologyamount;

		  $query5 = "select * from billing_ippharmacy where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
		$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
		$num5=mysql_num_rows($exec5);
		$res5 = mysql_fetch_array($exec5);
		$pharmacyamount=$res5['amount'];
			   $totalpharmacyamount=$totalpharmacyamount + $pharmacyamount;
	
	    $query6 = "select * from billing_ipservices where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and billdate between '$fromdate' and '$todate'  ";
		$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
		$num6=mysql_num_rows($exec6);
		$res6 = mysql_fetch_array($exec6);
		$servicesamount=$res6['servicesitemrate'];
           $totalservicesamount=$totalservicesamount + $servicesamount;
		
		 $query7 = "select * from billing_ipotbilling where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		$exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
		$num7=mysql_num_rows($exec7);
		$res7 = mysql_fetch_array($exec7);
		$otamount=$res7['amount'];
		 $totalotamount=$totalotamount + $otamount;
	     
	     $query8 = "select * from billing_ipambulance where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
		$num8=mysql_num_rows($exec8);
		$res8 = mysql_fetch_array($exec8);
		$ambulanceamount=$res8['amount'];
		 $totalambulanceamount=$totalambulanceamount + $ambulanceamount;
		
		 $query8 = "select * from billing_ipprivatedoctor where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate'  ";
		$exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
		$num8=mysql_num_rows($exec8);
		$res8 = mysql_fetch_array($exec8);
		$privatedoctoramount=$res8['amount'];
		$totalprivatedoctoramount=$totalprivatedoctoramount + $privatedoctoramount;
		
		 $query9 = "select * from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'bed charges' and recorddate between '$fromdate' and '$todate' ";
		$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		$num9=mysql_num_rows($exec9);
		$res9 = mysql_fetch_array($exec9);
		$ipbedcharges=$res9['amount'];
		
			$totalipbedcharges=$totalipbedcharges + $ipbedcharges;
		
	    $query10 = "select * from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'nursing charges' and recorddate between '$fromdate' and '$todate' ";
		$exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());
		$num10=mysql_num_rows($exec10);
		$res10 = mysql_fetch_array($exec10);
		$ipnursingcharges=$res10['amount'];
		
			$totalipnursingcharges=$totalipnursingcharges + $ipnursingcharges;
		
		$query11 = "select * from billing_ipbedcharges where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and description = 'RMO charges' and recorddate between '$fromdate' and '$todate' ";
		$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
		$num11=mysql_num_rows($exec11);
		$res11 = mysql_fetch_array($exec11);
		$iprmocharges=$res11['amount'];
		$totaliprmocharges=$totaliprmocharges + $iprmocharges;
		
		$query13 = "select * from ip_discount where locationcode='$locationcode1' and patientcode = '$patientcode' and patientvisitcode='$visitcode' and consultationdate between '$fromdate' and '$todate' ";
		$exec13 = mysql_query($query13) or die ("Error in Query13".mysql_error());
		$num13=mysql_num_rows($exec13);
		$res13 = mysql_fetch_array($exec13);
		$ipdiscountamount=$res13['rate'];
		
		$totalipdiscountamount=$totalipdiscountamount + $ipdiscountamount;
		
		
		$query14 = "select * from billing_ipmiscbilling where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and recorddate between '$fromdate' and '$todate' ";
		$exec14 = mysql_query($query14) or die ("Error in Query14".mysql_error());
		$num14=mysql_num_rows($exec14);
		$res14 = mysql_fetch_array($exec14);
		$ipmiscamount=$res14['amount'];
		$totalipmiscamount=$totalipmiscamount + $ipmiscamount;
		
		 $query15 = "select * from master_ipvisitentry where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and registrationdate between '$fromdate' and '$todate' ";
		$exec15 = mysql_query($query15) or die ("Error in Query15".mysql_error());
		$num15=mysql_num_rows($exec15);
		
		$res15 = mysql_fetch_array($exec15);
		
		$res15patientname=$res1['patientfullname'];
		$res15patientcode=$res1['patientcode'];
		$res15visitcode=$res1['visitcode'];
		$res15consultationdate=$res1['registrationdate'];
		
		
		$query12 = "select * from master_transactionipdeposit where locationcode='$locationcode1' and patientcode = '$patientcode' and visitcode='$visitcode' and transactiondate between '$fromdate' and '$todate' ";
		$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
		$num12=mysql_num_rows($exec12);
		
		while(		$res12 = mysql_fetch_array($exec12))
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
          <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno = $sno + 1; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div class="bodytext31" align="center">
			    <div align="center"><?php echo $res15patientname; ?></div>
			  </div></td>
			  <td class="bodytext31" valign="center"  align="left">
			    <div align="center"><?php echo $res15patientcode; ?></div></td>
			    <td class="bodytext31" valign="center"  align="left">
			      <div align="center"><?php echo $res15visitcode; ?></div></td>	
            
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($admissionamount,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($ipbedcharges,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($ipnursingcharges,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="left"><div align="right"><?php echo number_format($iprmocharges,2,'.',','); ?></div></td>
                <td class="bodytext31" valign="center"  align="left">
			      <div align="right"><?php echo number_format($labamount,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			      <div align="right"><?php echo number_format($radiologyamount,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			      <div align="right"><?php echo number_format($pharmacyamount,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			        <div align="right"><?php echo number_format($servicesamount,2,'.',','); ?></div></td>
				    <td class="bodytext31" valign="center"  align="left">
			          <div align="right"><?php echo number_format($otamount,2,'.',','); ?></div></td>
				  <td class="bodytext31" valign="center"  align="left">
			        <div align="right"><?php echo number_format($ambulanceamount,2,'.',','); ?></div></td>
				   <td class="bodytext31" valign="center"  align="left">
			         <div align="right"><?php echo number_format($privatedoctoramount,2,'.',','); ?></div></td>
				    <td class="bodytext31" valign="center"  align="left">
			         <div align="right"><?php echo number_format($transactionamount,2,'.',','); ?></div></td>
				   <td class="bodytext31" valign="center"  align="left">
                      <div align="right"><?php echo number_format($ipdiscountamount,2,'.',','); ?></div></td>
				                   <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($ipmiscamount,2,'.',','); ?></div></td>
                  </tr>
		   <?php 
		    
		     }
		   ?>
           
            <tr>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
				<td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc"><div align="right">
				
				<?php $grandtotal = $totaladmissionamount + $totalipbedcharges + $totalipnursingcharges + $totaliprmocharges + $totallabamount + $totalradiologyamount
				+ $totalpharmacyamount + $totalservicesamount + $totalotamount + $totalambulanceamount+ $totalprivatedoctoramount + $totalipmiscamount; ?>
				
                  <strong>Grand Total:</strong> </div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc"><div align="right">
                <strong><?php echo number_format($grandtotal,2,'.',','); ?></strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totaladmissionamount,2,'.',','); ?></strong></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totalipbedcharges,2,'.',','); ?></strong></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totalipnursingcharges,2,'.',','); ?></strong></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totaliprmocharges,2,'.',','); ?></strong></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc"><div align="right"><strong><?php echo number_format($totallabamount,2,'.',','); ?></strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc"><div align="right"><strong><?php echo number_format($totalradiologyamount,2,'.',','); ?></strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="left" 
                bgcolor="#cccccc"><div align="right"><strong><?php echo number_format($totalpharmacyamount,2,'.',','); ?></strong></div></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totalservicesamount,2,'.',','); ?></strong></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totalotamount,2,'.',','); ?></strong></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totalambulanceamount,2,'.',','); ?></strong></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totalprivatedoctoramount,2,'.',','); ?></strong></td>
              <td align="right" valign="center" bordercolor="#f3f3f3" 
                bgcolor="#cccccc" class="style2">-<?php echo number_format($totaltransactionamount,2,'.',','); ?></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                bgcolor="#cccccc"><strong>-<?php echo number_format($totalipdiscountamount,2,'.',','); ?></strong></td>
              <td class="bodytext311" valign="center" bordercolor="#f3f3f3" align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totalipmiscamount,2,'.',','); ?></strong></td>
            </tr>
          </tbody>
        </table>
<?php
}
?>	
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

