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
$paymentreceiveddatefrom = date('Y-m-d');
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d');
$transactiondateto = date('Y-m-d');

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$total = '0.00';
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$range = "";
$res1suppliername = '';
$total1 = '0.00';
$total2 = '0.00';
$total3 = '0.00';
$total4 = '0.00';
$total5 = '0.00';
$total6 = '0.00';
//This include updatation takes too long to load for hunge items database.
//include ("autocompletebuild_customer2.php");

 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];
	
$locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';
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
<script src="js/datetimepicker_css.js"></script>
<!--<script type="text/javascript" src="js/autocomplete_customer2.js"></script>
<script type="text/javascript" src="js/autosuggestcustomer.js"></script>-->
<script type="text/javascript">


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



window.onload = function () 
{
	var oTextbox = new AutoSuggestControl(document.getElementById("searchsuppliername"), new StateSuggestions());        
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
		
		
              <form name="cbform1" method="post" action="cashbillsreportnew.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Cash Bills Report</strong></td>
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
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>	
					<tr>
             <td  align="left" valign="center" 
			  <td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
			 
				 <select name="location" id="location" onChange="ajaxlocationfunction(this.value)">
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
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
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
        <td><table id="AutoNumber3" style="BORDER-COLLAPSE: collapse" 
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1000" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="7%" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
              <td colspan="6" bgcolor="#cccccc" class="bodytext31">
             
				  </td>  
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
				 <td width="11%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>  Date </strong></td>
              <td width="19%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient</strong></div></td>
				  <td width="11%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Code</strong></div></td>
                           <td width="9%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Visit No </strong></td>
				<td width="7%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Bill No </strong></td>
   				  <td width="12%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount</strong></div></td>
				<td width="12%" align="left" valign="center"  
                bgcolor="#E0E0E0" class="bodytext31">&nbsp;</td>
				<td width="12%" align="left" valign="center"  
                bgcolor="#E0E0E0" class="bodytext31">&nbsp;</td>
            </tr>
			
			<?php
		
			
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			
		      
		
		  $query4 = "select * from master_billing where locationcode='$locationcode1' and billingdatetime between '$ADate1' and '$ADate2'"; 
		  $exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		  while($res4 = mysql_fetch_array($exec4))
{

			$patientname = $res4['patientfullname'];
			$patientcode = $res4['patientcode'];
			$visitcode = $res4['visitcode'];
			$date = $res4['billingdatetime'];
			$amount = $res4['totalamount'];
			$billnumber = $res4['billnumber'];
			$total6 = $total6 + $amount;

		  	$snocount = $snocount + 1;
			
			//echo $cashamount;
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
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $date; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $patientcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $visitcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left"><?php echo $billnumber; ?></td>
             			  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
			  
			  
           </tr>
			<?php
			}
			?>
			<?php
		  $query4 = "select * from master_transactionpaynow where locationcode='$locationcode1' and transactiondate between '$ADate1' and '$ADate2'"; 
		  $exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		  while($res4 = mysql_fetch_array($exec4))
{

			$patientname = $res4['patientname'];
			$patientcode = $res4['patientcode'];
			$visitcode = $res4['visitcode'];
			$date = $res4['transactiondate'];
			$amount = $res4['cashamount'];
			$billnumber = $res4['billnumber'];
			$total6 = $total6 + $amount;

		  	$snocount = $snocount + 1;
			
			//echo $cashamount;
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
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $date; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $patientcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $visitcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left"><?php echo $billnumber; ?></td>
             			  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
			  
			  
           </tr>
			<?php
			}
			?>
					<?php
		  $query4 = "select * from master_transactionexternal where locationcode='$locationcode1' and transactiondate between '$ADate1' and '$ADate2'"; 
		  $exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		  while($res4 = mysql_fetch_array($exec4))
{

			$patientname = $res4['patientname'];
			$patientcode = $res4['patientcode'];
			$visitcode = $res4['visitcode'];
			$date = $res4['transactiondate'];
			$amount = $res4['cashamount'];
			$billnumber = $res4['billnumber'];
			$total6 = $total6 + $amount;

		  	$snocount = $snocount + 1;
			
			//echo $cashamount;
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
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $date; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $patientcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $visitcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left"><?php echo $billnumber; ?></td>
             			  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
			  
			  
           </tr>
			<?php
			}
			?>
			<?php
		  $query4 = "select * from master_transactionadvancedeposit where locationcode='$locationcode1' and transactiondate between '$ADate1' and '$ADate2'"; 
		  $exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		  while($res4 = mysql_fetch_array($exec4))
{

			$patientname = $res4['patientname'];
			$patientcode = $res4['patientcode'];
			$visitcode = '';
			$date = $res4['transactiondate'];
			$amount = $res4['cashamount'];
			$billnumber = $res4['docno'];
			$total6 = $total6 + $amount;

		  	$snocount = $snocount + 1;
			
			//echo $cashamount;
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
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $date; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $patientcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $visitcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left"><?php echo $billnumber; ?></td>
             			  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
			  
			  
           </tr>
			<?php
			}
			?>
				<?php
		  $query4 = "select * from master_transactionipdeposit where locationcode='$locationcode1' and transactionmodule <> 'Adjustment' and transactiondate between '$ADate1' and '$ADate2'"; 
		  $exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		  while($res4 = mysql_fetch_array($exec4))
{

			$patientname = $res4['patientname'];
			$patientcode = $res4['patientcode'];
			$visitcode = $res4['visitcode'];
			$date = $res4['transactiondate'];
			$amount = $res4['cashamount'];
			$billnumber = $res4['docno'];
			$total6 = $total6 + $amount;

		  	$snocount = $snocount + 1;
			
			//echo $cashamount;
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
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $date; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $patientcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $visitcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left"><?php echo $billnumber; ?></td>
             			  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
			  
			  
           </tr>
			<?php
			}
			?>
			
			<?php
		  $query4 = "select * from master_transactionip where locationcode='$locationcode1' and transactiondate between '$ADate1' and '$ADate2'"; 
		  $exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		  while($res4 = mysql_fetch_array($exec4))
{

			$patientname = $res4['patientname'];
			$patientcode = $res4['patientcode'];
			$visitcode = $res4['visitcode'];
			$date = $res4['transactiondate'];
			$amount = $res4['cashamount'];
			$billnumber = $res4['billnumber'];
			
			
			if($amount != '0.00')
{
$total6 = $total6 + $amount;
		  	$snocount = $snocount + 1;
			
			//echo $cashamount;
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
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $date; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $patientcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $visitcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left"><?php echo $billnumber; ?></td>
             			  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
			  
			  
           </tr>
			<?php
			}
			}
			?>
					<?php
		  $query4 = "select * from master_transactionipcreditapproved where locationcode='$locationcode1' and transactiondate between '$ADate1' and '$ADate2'"; 
		  $exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		  while($res4 = mysql_fetch_array($exec4))
{

			$patientname = $res4['patientname'];
			$patientcode = $res4['patientcode'];
			$visitcode = $res4['visitcode'];
			$date = $res4['transactiondate'];
			$amount = $res4['cashamount'];
			$billnumber = $res4['billnumber'];
			
			
			if($amount != '0.00')
{
$total6 = $total6 + $amount;
		  	$snocount = $snocount + 1;
			
			//echo $cashamount;
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
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $date; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $patientcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $visitcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left"><?php echo $billnumber; ?></td>
             			  <td  align="left" valign="center" class="bodytext31"><div align="right"><?php echo number_format($amount,2,'.',','); ?></div></td>
			  
			  
           </tr>
			<?php
			}
			}
			?>
		
			
								<?php
		  $query4 = "select * from refund_paynow where locationcode='$locationcode1' and transactiondate between '$ADate1' and '$ADate2'"; 
		  $exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		  while($res4 = mysql_fetch_array($exec4))
{

			$patientname = $res4['patientname'];
			$patientcode = $res4['patientcode'];
			$visitcode = $res4['visitcode'];
			$date = $res4['transactiondate'];
			$amount = $res4['cashamount'];
			$billnumber = $res4['billnumber'];
			
			
			if($amount != '0.00')
{

$total6 = $total6 - $amount;
		  	$snocount = $snocount + 1;
			
			//echo $cashamount;
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
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $date; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $patientname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $patientcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <?php echo $visitcode; ?></td>
			  <td class="bodytext31" valign="center"  align="left"><?php echo $billnumber; ?></td>
             			  <td  align="left" valign="center" class="bodytext31"><div align="right"> - <?php echo number_format($amount,2,'.',','); ?></div></td>
			  
			  
           </tr>
			<?php
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

              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong>Total:</strong></td>
								<td  align="right" valign="center" 
                bgcolor="#cccccc" class="bodytext31"><strong><?php echo number_format($total6,2,'.',','); ?></strong></td>
				 
			  <?php if($total6 != 0)
			 { 
			  ?>	 
				 <td align="right" valign="center" bgcolor="#E0E0E0" class="bodytext31"><a target="_blank" href="print_cashbillsreportnew.php?cbfrmflag1=cbfrmflag1&&ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&locationcode=<?php echo $locationcode1; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></td>
              <?php
		      }
		   ?>
			</tr>
          </tbody>
        </table></td>
      </tr>
	  
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
