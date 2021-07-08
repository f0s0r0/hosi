<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$docno = $_SESSION['docno'];
 //get location for sort by location purpose
  $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
	if($location!='')
	{
		  $locationcode=$location;
		}
		//location get end here
  
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
$sno = "";
$colorloopcount1="";
$grandtotal = '';
$grandtotal1 = "0.00";
//This include updatation takes too long to load for hunge items database.
include ("autocompletebuild_account2.php");

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
		
		
              <form name="cbform1" method="post" action="journalreport.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="1" bgcolor="#CCCCCC" class="bodytext3"><strong>Journal Report</strong></td>
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
            <!--<tr>
              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
			  <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Payment Entry" /> 
                *To Print Other Receipts Please Go To Menu:	Reports	-&gt; Payments Given 
				</td>
              </tr>-->
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
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>	
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input type="submit" onClick="return funcAccount();" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" 
            align="left" border="0">
          <tbody>
            		
            <tr>
              <td width="47"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
              <td width="86" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Date</strong></div></td>
              <td width="169" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Description </strong></td>
				 <td width="93" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Vch No</strong></td>
		
              <td width="93" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Amount</strong></td>
			      </tr>
		
			<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
			$cashcoa = '';
			$cardcoa = '';
			$chequecoa = '';
			$onlinecoa = '';
			$mpesacoa = '';
			$accountssub = '';
			$res2visitcode = '';
		  $query2 = "select * from paymentmodedebit where locationcode ='".$locationcode."' AND source='consultationbilling' and billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		  while ($res2 = mysql_fetch_array($exec2))
		  {
     	  $res2transactiondate = $res2['billdate'];
		  $res2billnumber = $res2['billnumber'];
		  $cashamount2 = $res2['cash'];
		  $cashcoa =  $res2['cashcoa'];
		  $cardamount2 = $res2['card'];
		  $cardcoa =  $res2['cardcoa'];
		  $chequeamount2 = $res2['cheque'];
		  $chequecoa =  $res2['chequecoa'];
		  $onlineamount2 = $res2['online'];
		  $onlinecoa =  $res2['onlinecoa'];
		  $mpesaamount2 = $res2['mpesa'];
		  $mpesacoa =  $res2['mpesacoa'];
		 
		  
		  
		  $query21 = "select * from master_accountname where id='$cashcoa' or id='$cardcoa' or id='$chequecoa' or id='$onlinecoa' or id='$mpesacoa'";
		  $exec21 = mysql_query($query21) or die(mysql_error());
		  $res21 = mysql_fetch_array($exec21);
		  $accountssub = $res21['accountssub'];
		  
		  $query212 = "select * from master_accountssub where auto_number='$accountssub'";
		  $exec212 = mysql_query($query212) or die(mysql_error());
		  $res212 = mysql_fetch_array($exec212);
		  $accountssubname = $res212['accountssub'];
		 	  $snocount = $snocount + 1;
					if($cashamount2 != '0.00')
	{
		
					
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
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'CASH'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($cashamount2,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   }
		   if($chequeamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			  <?php
			  if($cashamount2 == '0.00')
			  {
			  echo $snocount; 
			  }
			  ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'CHEQUE'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($chequeamount2,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   }
		   if($cardamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			   <?php
			  if(($cashamount2 == '0.00')&&($chequeamount2 == '0.00'))
			  {
			  echo $snocount; 
			  }
			  ?>
			  </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'CARD'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($cardamount2,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   } if($onlineamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			   <?php
			  if(($cashamount2 == '0.00')&&($chequeamount2 == '0.00')&&($cardamount2 == '0.00'))
			  {
			  echo $snocount; 
			  }
			  ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'ONLINE'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($onlineamount2,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   }
		   if($mpesaamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			   <?php
			  if(($cashamount2 == '0.00')&&($chequeamount2 == '0.00')&&($cardamount2 == '0.00')&&($onlineamount2 == '0.00'))
			  {
			  echo $snocount; 
			  }
			  ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'MPESA'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($mpesaamount2,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   }
		   $query81 = "select * from billing_consultation where billnumber='$res2billnumber'";
		   $exec81 = mysql_query($query81) or die(mysql_error());
		   $res81 = mysql_fetch_array($exec81);
		   $resconsultationdate = $res81['billdate'];
		   $resconsultationamount = $res81['consultation'];
		   $resconsultationcoa = $res81['consultationcoa'];
		   
		   $query811 = "select * from master_accountname where id='$resconsultationcoa'";
		   $exec811 = mysql_query($query811) or die(mysql_error());
		   $res811 = mysql_fetch_array($exec811);
		   $resconsultationcoaname = $res811['accountname'];
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resconsultationdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="center">
                <?php echo $resconsultationcoaname; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($resconsultationamount,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   
			<?php
			}
			?>
			<?php
			  $query42 = "select * from paymentmodedebit where locationcode ='".$locationcode."' AND source='billingpaynow' and billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec42 = mysql_query($query42) or die ("Error in Query2".mysql_error());
		  while ($res42 = mysql_fetch_array($exec42))
		  {
     	  $res2transactiondate4 = $res42['billdate'];
		  $res2billnumber4 = $res42['billnumber'];
		  $cashamount24 = $res42['cash'];
		  $cashcoa4 =  $res42['cashcoa'];
		  $cardamount24 = $res42['card'];
		  $cardcoa4 =  $res42['cardcoa'];
		  $chequeamount24 = $res42['cheque'];
		  $chequecoa4 =  $res42['chequecoa'];
		  $onlineamount24 = $res42['online'];
		  $onlinecoa4 =  $res42['onlinecoa'];
		  $mpesaamount24 = $res42['mpesa'];
		  $mpesacoa4 =  $res42['mpesacoa'];
		  $query214 = "select * from master_accountname where id='$cashcoa' or id='$cardcoa' or id='$chequecoa' or id='$onlinecoa' or id='$mpesacoa'";
		  $exec214 = mysql_query($query214) or die(mysql_error());
		  $res214 = mysql_fetch_array($exec214);
		  $accountssub4 = $res214['accountssub'];
		  
		  $query2124 = "select * from master_accountssub where auto_number='$accountssub'";
		  $exec2124 = mysql_query($query2124) or die(mysql_error());
		  $res2124= mysql_fetch_array($exec2124);
		  $accountssubname4 = $res2124['accountssub'];
		 	 $snocount = $snocount + 1;
					if($cashamount24 != '0.00')
	{
		 
					
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
                <div class="bodytext31"><?php echo $res2transactiondate4; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'CASH'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber4; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($cashamount24,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   }
		   if($chequeamount24 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			    <?php
			  if($cashamount24 == '0.00')
			  {
			  echo $snocount; 
			  }
			  ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate4; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'CHEQUE'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber4; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($chequeamount24,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   }
		   if($cardamount24 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			    <?php
			  if(($cashamount24 == '0.00')&&($chequeamount24 == '0.00'))
			  {
			  echo $snocount; 
			  }
			  ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate4; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'CARD'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber4; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($cardamount24,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   } if($onlineamount24 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			  <?php
			  if(($cashamount24 == '0.00')&&($chequeamount24 == '0.00')&&($cardamount24 == '0.00'))
			  {
			  echo $snocount; 
			  }
			  ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate4; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'ONLINE'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber4; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($onlineamount24,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   }
		   if($mpesaamount24 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			  <?php
			  if(($cashamount24 == '0.00')&&($chequeamount24 == '0.00')&&($cardamount24 == '0.00')&&($onlineamount24 == '0.00'))
			  {
			  echo $snocount; 
			  }
			  ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate4; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'MPESA'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber4; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($mpesaamount24,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   }
		   $grandpharmamount = 0;
		   $respharmcoaname4 = '';
		   $query814 = "select * from billing_paynowpharmacy where billnumber='$res2billnumber4'";
		   $exec814 = mysql_query($query814) or die(mysql_error());
		   while($res814 = mysql_fetch_array($exec814))
		   {
		   $respharmdate = $res814['billdate'];
		   $respharmamount = $res814['amount'];
		   $respharmcoa = $res814['pharmacycoa'];
		 
		   $query8114 = "select * from master_accountname where id='$respharmcoa'";
		   $exec8114 = mysql_query($query8114) or die(mysql_error());
		   $res8114 = mysql_fetch_array($exec8114);
		   $respharmcoaname4 = $res8114['accountname'];
		   $grandpharmamount = $grandpharmamount + $respharmamount;
		   }
		   if($respharmcoaname4 != '')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $respharmdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $respharmcoaname4; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber4; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandpharmamount,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   
			<?php
			}
			$grandlabamount = 0;
			$reslabcoaname5 = '';
			 $query815 = "select * from billing_paynowlab where billnumber='$res2billnumber4'";
		   $exec815 = mysql_query($query815) or die(mysql_error());
		   while($res815 = mysql_fetch_array($exec815))
		   {
		   $reslabdate = $res815['billdate'];
		   $reslabamount = $res815['labitemrate'];
		   $reslabcoa = $res815['labcoa'];
		   
		   $query8115 = "select * from master_accountname where id='$reslabcoa'";
		   $exec8115 = mysql_query($query8115) or die(mysql_error());
		   $res8115 = mysql_fetch_array($exec8115);
		   $reslabcoaname5 = $res8115['accountname'];
		   $grandlabamount = $grandlabamount + $reslabamount;
		   }
		   if($reslabcoaname5 != '')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $reslabdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $reslabcoaname5; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber4; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandlabamount,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   
			<?php
			}
			$grandradiologyamount = 0;
			$resradiologycoaname6 = '';
		   $query816 = "select * from billing_paynowradiology where billnumber='$res2billnumber4'";
		   $exec816 = mysql_query($query816) or die(mysql_error());
		   while($res816 = mysql_fetch_array($exec816))
		   {
		   $resradiologydate = $res816['billdate'];
		   $resradiologyamount = $res816['radiologyitemrate'];
		   $resradiologycoa = $res816['radiologycoa'];
		   
		   $query8116 = "select * from master_accountname where id='$resradiologycoa'";
		   $exec8116 = mysql_query($query8116) or die(mysql_error());
		   $res8116 = mysql_fetch_array($exec8116);
		   $resradiologycoaname6 = $res8116['accountname'];
		    $grandradiologyamount = $grandradiologyamount + $resradiologyamount;
		   }
		   if($resradiologycoaname6 != '')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resradiologydate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $resradiologycoaname6; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber4; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandradiologyamount,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   
			<?php
			}
			$grandservicesamount = 0;
			$resservicescoaname6 = '';
			 $query817 = "select * from billing_paynowservices where billnumber='$res2billnumber4'";
		   $exec817 = mysql_query($query817) or die(mysql_error());
		   while($res817 = mysql_fetch_array($exec817))
		   {
		   $resservicesdate = $res817['billdate'];
		   $resservicesamount = $res817['servicesitemrate'];
		   $resservicescoa = $res817['servicecoa'];
		   
		   $query8117 = "select * from master_accountname where id='$resservicescoa'";
		   $exec8117 = mysql_query($query8117) or die(mysql_error());
		   $res8117 = mysql_fetch_array($exec8117);
		   $resservicescoaname6 = $res8117['accountname'];
		   $grandservicesamount = $grandservicesamount + $resservicesamount;
		   }
		   if($resservicescoaname6 != '')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resservicesdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $resservicescoaname6; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber4; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandservicesamount,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   
			<?php
			}
			$grandreferalamount = 0;
			$resreferalcoaname6 ='';
			$query818 = "select * from billing_paynowreferal where billnumber='$res2billnumber4'";
		   $exec818 = mysql_query($query818) or die(mysql_error());
		   while($res818 = mysql_fetch_array($exec818))
		   {
		   $resreferaldate = $res818['billdate'];
		   $resreferalamount = $res818['referalrate'];
		   $resreferalcoa = $res818['referalcoa'];
		   
		   $query8118 = "select * from master_accountname where id='$resreferalcoa'";
		   $exec8118 = mysql_query($query8118) or die(mysql_error());
		   $res8118 = mysql_fetch_array($exec8118);
		   $resreferalcoaname6 = $res8118['accountname'];
		   $grandreferalamount = $grandreferalamount + $resreferalamount;
		   }
		   if($resreferalcoaname6 != '')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resreferaldate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $resreferalcoaname6; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber4; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandreferalamount,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   
			<?php
			}
			}
			?>
			<?php
			 $query82 = "select * from refund_consultation where locationcode ='".$locationcode."' AND billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		   $exec82 = mysql_query($query82) or die(mysql_error());
		   while($res82 = mysql_fetch_array($exec82))
		   {
		   $resconsultationrefunddate = $res82['billdate'];
		   $resconsultationrefundamount = $res82['consultation'];
		   $resconsultationrefundcoa = $res82['consultationcoa'];
		   $res2consultationrefundbillnumber = $res82['billnumber'];
		   
		   $query821 = "select * from master_accountname where id='$resconsultationrefundcoa'";
		   $exec821 = mysql_query($query821) or die(mysql_error());
		   $res821 = mysql_fetch_array($exec821);
		   $resconsultationrefundcoaname = $res821['accountname'];
		   $colorloopcount = $colorloopcount + 1;
		     $snocount = $snocount + 1;
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
                <div class="bodytext31"><?php echo $resconsultationrefunddate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <?php echo $resconsultationrefundcoaname; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2consultationrefundbillnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($resconsultationrefundamount,2,'.',','); ?> </td>
           
           </tr>	   
		   
			<?php
			
			 $query822 = "select * from paymentmodecredit where source='consultationrefund' and billnumber='$res2consultationrefundbillnumber' and billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec822 = mysql_query($query822) or die ("Error in Query2".mysql_error());
		  while ($res822 = mysql_fetch_array($exec822))
		  {
     	  $res2transactiondate = $res822['billdate'];
		  $res2billnumber = $res822['billnumber'];
		  $cashamount2 = $res822['cash'];
		  $cashcoa =  $res822['cashcoa'];
		  $cardamount2 = $res822['card'];
		  $cardcoa =  $res822['cardcoa'];
		  $chequeamount2 = $res822['cheque'];
		  $chequecoa =  $res822['chequecoa'];
		  $onlineamount2 = $res822['online'];
		  $onlinecoa =  $res822['onlinecoa'];
		  $mpesaamount2 = $res822['mpesa'];
		  $mpesacoa =  $res822['mpesacoa'];
		  $query823 = "select * from master_accountname where id='$cashcoa' or id='$cardcoa' or id='$chequecoa' or id='$onlinecoa' or id='$mpesacoa'";
		  $exec823 = mysql_query($query823) or die(mysql_error());
		  $res823 = mysql_fetch_array($exec823);
		  $accountssub = $res823['accountssub'];
		  
		  $query824 = "select * from master_accountssub where auto_number='$accountssub'";
		  $exec824 = mysql_query($query824) or die(mysql_error());
		  $res824 = mysql_fetch_array($exec824);
		  $accountssubname = $res824['accountssub'];
		 	
		
							if($cashamount2 != '0.00')
	{
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <div class="bodytext31"><?php echo 'CASH'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($cashamount2,2,'.',','); ?> Cr</td>
           
           </tr>
		   <?php
		   }
		   if($chequeamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			 </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <div class="bodytext31"><?php echo 'CHEQUE'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($chequeamount2,2,'.',','); ?> Cr</td>
           
           </tr>
		   <?php
		   }
		   if($cardamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			  
			  </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <div class="bodytext31"><?php echo 'CARD'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($cardamount2,2,'.',','); ?> Cr</td>
           
           </tr>
		   <?php
		   } if($onlineamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			  </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <div class="bodytext31"><?php echo 'ONLINE'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($onlineamount2,2,'.',','); ?> Cr</td>
           
           </tr>
		   <?php
		   }
		   if($mpesaamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			  </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <div class="bodytext31"><?php echo 'MPESA'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($mpesaamount2,2,'.',','); ?> Cr</td>
           
           </tr>
		   <?php
		   }
		  }
		  }
			?>
			<?php
			
			$respharmcoaname4 = '';
			$query83 = "select * from refund_paynow where locationcode ='".$locationcode."' AND source = 'paynowrefund' and transactiondate between '$ADate1' and '$ADate2' order by auto_number desc";
			$exec83 = mysql_query($query83) or die(mysql_error());
			while($res83 = mysql_fetch_array($exec83)) 
			{
			$grandpharmamount = 0;
			$res2paynowrefundbillnumber = $res83['billnumber'];
			$query831 = "select * from refund_paynowpharmacy where billnumber='$res2paynowrefundbillnumber'";
		   $exec831 = mysql_query($query831) or die(mysql_error());
		   while($res831 = mysql_fetch_array($exec831))
		   {
		   $respharmdate = $res831['billdate'];
		   $respharmamount = $res831['amount'];
		   $respharmcoa = $res831['pharmacycoa'];
		 
		   $query832 = "select * from master_accountname where id='$respharmcoa'";
		   $exec832 = mysql_query($query832) or die(mysql_error());
		   $res832 = mysql_fetch_array($exec832);
		   $respharmcoaname4 = $res832['accountname'];
		   
		  $grandpharmamount = $grandpharmamount + $respharmamount;
		   }
		   $snocount = $snocount + 1;
		   if(($respharmcoaname4 != '')&&($grandpharmamount != ''))
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
              <td class="bodytext31" valign="center"  align="left">
			 <?php echo $snocount; ?>  </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $respharmdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <?php echo $respharmcoaname4; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2paynowrefundbillnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandpharmamount,2,'.',','); ?></td>
           
           </tr>	   
		   
			<?php
			}
			$grandlabamount = 0;
			$reslabcoaname5 = '';
		   $query833 = "select * from refund_paynowlab where billnumber='$res2paynowrefundbillnumber'";
		   $exec833 = mysql_query($query833) or die(mysql_error());
		   while($res833 = mysql_fetch_array($exec833))
		   {
		   $reslabdate = $res833['billdate'];
		   $reslabamount = $res833['labitemrate'];
		   $reslabcoa = $res833['labcoa'];
		   
		   $query834 = "select * from master_accountname where id='$reslabcoa'";
		   $exec834 = mysql_query($query834) or die(mysql_error());
		   $res834 = mysql_fetch_array($exec834);
		   $reslabcoaname5 = $res834['accountname'];
		   $grandlabamount = $grandlabamount + $reslabamount;
		   }
		   if($reslabcoaname5 != '')
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
              <td class="bodytext31" valign="center"  align="left">
			  <?php
			  if($grandpharmamount == '')
			  {
			  echo $snocount; 
			  }
			  ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $reslabdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <?php echo $reslabcoaname5; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2paynowrefundbillnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandlabamount,2,'.',','); ?> </td>
           
           </tr>	   
		   
			<?php
			}
			$grandradiologyamount = 0;
			$resradiologycoaname6 = '';
		   $query835 = "select * from refund_paynowradiology where billnumber='$res2paynowrefundbillnumber'";
		   $exec835 = mysql_query($query835) or die(mysql_error());
		   while($res835 = mysql_fetch_array($exec835))
		   {
		   $resradiologydate = $res835['billdate'];
		   $resradiologyamount = $res835['radiologyitemrate'];
		   $resradiologycoa = $res835['radiologycoa'];
		   
		   $query836 = "select * from master_accountname where id='$resradiologycoa'";
		   $exec836 = mysql_query($query836) or die(mysql_error());
		   $res836 = mysql_fetch_array($exec836);
		   $resradiologycoaname6 = $res836['accountname'];
		    $grandradiologyamount = $grandradiologyamount + $resradiologyamount;
		   }
		   if($resradiologycoaname6 != '')
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
              <td class="bodytext31" valign="center"  align="left">
			  <?php
			  if(($respharmcoaname4 == '')&&($reslabcoaname5 == ''))
			  {
			  echo $snocount; 
			  }
			  ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resradiologydate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <?php echo $resradiologycoaname6; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2paynowrefundbillnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandradiologyamount,2,'.',','); ?> </td>
           
           </tr>	   
		   
			<?php
			}
			$grandservicesamount = 0;
			$resservicescoaname6 = '';
			 $query837 = "select * from refund_paynowservices where billnumber='$res2paynowrefundbillnumber'";
		   $exec837 = mysql_query($query837) or die(mysql_error());
		   while($res837 = mysql_fetch_array($exec837))
		   {
		   $resservicesdate = $res837['billdate'];
		   $resservicesamount = $res837['servicesitemrate'];
		   $resservicescoa = $res837['servicecoa'];
		   
		   $query837 = "select * from master_accountname where id='$resservicescoa'";
		   $exec837 = mysql_query($query837) or die(mysql_error());
		   $res837 = mysql_fetch_array($exec837);
		   $resservicescoaname6 = $res837['accountname'];
		   $grandservicesamount = $grandservicesamount + $resservicesamount;
		   }
		   if($resservicescoaname6 != '')
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
              <td class="bodytext31" valign="center"  align="left">
			  <?php
			  if(($respharmcoaname4 == '')&&($reslabcoaname5 == '')&&($resradiologycoaname6 == ''))
			  {
			  echo $snocount; 
			  }
			  ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resservicesdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <?php echo $resservicescoaname6; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2paynowrefundbillnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandservicesamount,2,'.',','); ?></td>
           
           </tr>	   
		   
			<?php
			}
			$grandreferalamount = 0;
			$resreferalcoaname6 ='';
			$query838 = "select * from refund_paynowreferal where billnumber='$res2paynowrefundbillnumber'";
		   $exec838 = mysql_query($query838) or die(mysql_error());
		   while($res838 = mysql_fetch_array($exec838))
		   {
		   $resreferaldate = $res838['billdate'];
		   $resreferalamount = $res838['referalrate'];
		   $resreferalcoa = $res838['referalcoa'];
		   
		   $query839 = "select * from master_accountname where id='$resreferalcoa'";
		   $exec839 = mysql_query($query839) or die(mysql_error());
		   $res839 = mysql_fetch_array($exec839);
		   $resreferalcoaname6 = $res839['accountname'];
		   $grandreferalamount = $grandreferalamount + $resreferalamount;
		   }
		   if($resreferalcoaname6 != '')
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
              <td class="bodytext31" valign="center"  align="left">
			   <?php
			  if(($respharmcoaname4 == '')&&($reslabcoaname5 == '')&&($resradiologycoaname6 == '')&&($resservicescoaname6 == ''))
			  {
			  echo $snocount; 
			  }
			  ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resreferaldate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <?php echo $resreferalcoaname6; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber4; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandreferalamount,2,'.',','); ?></td>
           
           </tr>	   
		   
			<?php
			}
			  $query43 = "select * from paymentmodecredit where source='paynowrefund' and billnumber = '$res2paynowrefundbillnumber' and billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec43 = mysql_query($query43) or die ("Error in Query2".mysql_error());
		  while ($res43 = mysql_fetch_array($exec43))
		  {
     	  $res2transactiondate4 = $res43['billdate'];
		  $res2billnumber4 = $res43['billnumber'];
		  $cashamount24 = $res43['cash'];
		  $cashcoa4 =  $res43['cashcoa'];
		  $cardamount24 = $res43['card'];
		  $cardcoa4 =  $res43['cardcoa'];
		  $chequeamount24 = $res43['cheque'];
		  $chequecoa4 =  $res43['chequecoa'];
		  $onlineamount24 = $res43['online'];
		  $onlinecoa4 =  $res43['onlinecoa'];
		  $mpesaamount24 = $res43['mpesa'];
		  $mpesacoa4 =  $res43['mpesacoa'];
		  $query431 = "select * from master_accountname where id='$cashcoa' or id='$cardcoa' or id='$chequecoa' or id='$onlinecoa' or id='$mpesacoa'";
		  $exec431 = mysql_query($query431) or die(mysql_error());
		  $res431 = mysql_fetch_array($exec431);
		  $accountssub4 = $res431['accountssub'];
		  
		  $query432 = "select * from master_accountssub where auto_number='$accountssub'";
		  $exec432 = mysql_query($query432) or die(mysql_error());
		  $res432= mysql_fetch_array($exec432);
		  $accountssubname4 = $res432['accountssub'];
		 	
					if($cashamount24 != '0.00')
	{
		 
					
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate4; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <div class="bodytext31"><?php echo 'CASH'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2paynowrefundbillnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($cashamount24,2,'.',','); ?> Cr</td>
           
           </tr>
		   <?php
		   }
		   if($chequeamount24 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate4; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <div class="bodytext31"><?php echo 'CHEQUE'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2paynowrefundbillnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($chequeamount24,2,'.',','); ?> Cr</td>
           
           </tr>
		   <?php
		   }
		   if($cardamount24 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate4; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <div class="bodytext31"><?php echo 'CARD'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2paynowrefundbillnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($cardamount24,2,'.',','); ?> Cr</td>
           
           </tr>
		   <?php
		   } if($onlineamount24 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate4; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <div class="bodytext31"><?php echo 'ONLINE'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2paynowrefundbillnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($onlineamount24,2,'.',','); ?> Cr</td>
           
           </tr>
		   <?php
		   }
		   if($mpesaamount24 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate4; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <div class="bodytext31"><?php echo 'MPESA'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2paynowrefundbillnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($mpesaamount24,2,'.',','); ?> Cr</td>
           
           </tr>
		   <?php
		   }
		 }
		 }
			?>
			<?php
		   $query433 = "select * from billing_paylater where locationcode ='".$locationcode."' AND billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		   $exec433 = mysql_query($query433) or die(mysql_error());
		   while($res433 = mysql_fetch_array($exec433))
		   {
		   $resbillpaylaterdate = $res433['billdate'];
		   $resbillpaylateramount = $res433['totalamount'];
		   $res2billpaylaterbillnumber = $res433['billno'];
		   $res2billpaylateraccountname = $res433['accountname'];
		    $snocount = $snocount + 1;
		 
		   if($resbillpaylateramount != '')
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
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resbillpaylaterdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <?php echo $res2billpaylateraccountname; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billpaylaterbillnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($resbillpaylateramount,2,'.',','); ?> </td>
           
           </tr>	   
		   <?php
		   }
		   $grandpharmamount = 0;
		    $query434 = "select * from billing_paylaterpharmacy where billnumber='$res2billpaylaterbillnumber'";
		   $exec434 = mysql_query($query434) or die(mysql_error());
		   while($res434 = mysql_fetch_array($exec434))
		   {
		   $respharmdate = $res434['billdate'];
		   $respharmamount = $res434['amount'];
		   $respharmcoa = $res434['pharmacycoa'];
		 
		   $query435 = "select * from master_accountname where id='$respharmcoa'";
		   $exec435 = mysql_query($query435) or die(mysql_error());
		   $res435 = mysql_fetch_array($exec435);
		   $respharmcoaname4 = $res435['accountname'];
		   $grandpharmamount = $grandpharmamount + $respharmamount;
		   }
		   if($grandpharmamount != '')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $respharmdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $respharmcoaname4; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billpaylaterbillnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandpharmamount,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   
			<?php
			}
			$grandconsultationamount = 0;
			$resconsultationcoaname4 = '';
		    $query444 = "select * from billing_paylaterconsultation where billno='$res2billpaylaterbillnumber'";
		   $exec444 = mysql_query($query444) or die(mysql_error());
		   while($res444 = mysql_fetch_array($exec444))
		   {
		   $resconsultationdate = $res444['billdate'];
		   $resconsultationamount = $res444['totalamount'];
		   $resconsultationcoa = $res444['consultationcoa'];
		 
		   $query445 = "select * from master_accountname where id='$resconsultationcoa'";
		   $exec445 = mysql_query($query445) or die(mysql_error());
		   $res445 = mysql_fetch_array($exec445);
		   $resconsultationcoaname4 = $res445['accountname'];
		   $grandconsultationamount = $grandconsultationamount + $resconsultationamount;
		   }
		   if($resconsultationcoaname4 != '')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resconsultationdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $resconsultationcoaname4; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billpaylaterbillnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandconsultationamount,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   
			<?php
			}
			$grandlabamount = 0;
			$reslabcoaname5 = '';
			 $query436 = "select * from billing_paylaterlab where billnumber='$res2billpaylaterbillnumber'";
		   $exec436 = mysql_query($query436) or die(mysql_error());
		   while($res436 = mysql_fetch_array($exec436))
		   {
		   $reslabdate = $res436['billdate'];
		   $reslabamount = $res436['labitemrate'];
		   $reslabcoa = $res436['labcoa'];
		   
		   $query437 = "select * from master_accountname where id='$reslabcoa'";
		   $exec437 = mysql_query($query437) or die(mysql_error());
		   $res437 = mysql_fetch_array($exec437);
		   $reslabcoaname5 = $res437['accountname'];
		   $grandlabamount = $grandlabamount + $reslabamount;
		   }
		   if($reslabcoaname5 != '')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $reslabdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $reslabcoaname5; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billpaylaterbillnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandlabamount,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   
			<?php
			}
			$grandradiologyamount = 0;
			$resradiologycoaname6 = '';
		   $query438 = "select * from billing_paylaterradiology where billnumber='$res2billpaylaterbillnumber'";
		   $exec438 = mysql_query($query438) or die(mysql_error());
		   while($res438 = mysql_fetch_array($exec438))
		   {
		   $resradiologydate = $res438['billdate'];
		   $resradiologyamount = $res438['radiologyitemrate'];
		   $resradiologycoa = $res438['radiologycoa'];
		   
		   $query439 = "select * from master_accountname where id='$resradiologycoa'";
		   $exec439 = mysql_query($query439) or die(mysql_error());
		   $res439 = mysql_fetch_array($exec439);
		   $resradiologycoaname6 = $res439['accountname'];
		    $grandradiologyamount = $grandradiologyamount + $resradiologyamount;
		   }
		   if($resradiologycoaname6 != '')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resradiologydate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $resradiologycoaname6; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billpaylaterbillnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandradiologyamount,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   
			<?php
			}
			$grandservicesamount = 0;
			$resservicescoaname6 = '';
			 $query440 = "select * from billing_paylaterservices where billnumber='$res2billpaylaterbillnumber'";
		   $exec440 = mysql_query($query440) or die(mysql_error());
		   while($res440 = mysql_fetch_array($exec440))
		   {
		   $resservicesdate = $res440['billdate'];
		   $resservicesamount = $res440['servicesitemrate'];
		   $resservicescoa = $res440['servicecoa'];
		   
		   $query441 = "select * from master_accountname where id='$resservicescoa'";
		   $exec441 = mysql_query($query441) or die(mysql_error());
		   $res441 = mysql_fetch_array($exec441);
		   $resservicescoaname6 = $res441['accountname'];
		   $grandservicesamount = $grandservicesamount + $resservicesamount;
		   }
		   if($resservicescoaname6 != '')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resservicesdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $resservicescoaname6; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billpaylaterbillnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandservicesamount,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   
			<?php
			}
			$grandreferalamount = 0;
			$resreferalcoaname6 ='';
			$query442 = "select * from billing_paylaterreferal where billnumber='$res2billpaylaterbillnumber'";
		   $exec442 = mysql_query($query442) or die(mysql_error());
		   while($res442 = mysql_fetch_array($exec442))
		   {
		   $resreferaldate = $res442['billdate'];
		   $resreferalamount = $res442['referalrate'];
		   $resreferalcoa = $res442['referalcoa'];
		   
		   $query443 = "select * from master_accountname where id='$resreferalcoa'";
		   $exec443 = mysql_query($query443) or die(mysql_error());
		   $res443 = mysql_fetch_array($exec443);
		   $resreferalcoaname6 = $res443['accountname'];
		   $grandreferalamount = $grandreferalamount + $resreferalamount;
		   }
		   if($resreferalcoaname6 != '')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resreferaldate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $resreferalcoaname6; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billpaylaterbillnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandreferalamount,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   
			<?php
			}
			$grandopenbalanceamount = 0;
			$resopenbalancecoaname6 ='';
			$query4421 = "select * from openingbalanceaccount where docno='$res2billpaylaterbillnumber'";
		   $exec4421 = mysql_query($query4421) or die(mysql_error());
		   while($res4421 = mysql_fetch_array($exec4421))
		   {
		   $resopenbalancedate = $res4421['entrydate'];
		   $resopenbalanceamount = $res4421['amount'];
		   $resopenbalancecoa = $res4421['coa'];
		   
		   $query443 = "select * from master_accountname where id='$resopenbalancecoa'";
		   $exec443 = mysql_query($query443) or die(mysql_error());
		   $res443 = mysql_fetch_array($exec443);
		   $resopenbalancecoaname6 = $res443['accountname'];
		   $grandopenbalanceamount = $grandopenbalanceamount + $resopenbalanceamount;
		   }
		   if($resopenbalancecoaname6 != '')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resopenbalancedate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $resopenbalancecoaname6; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billpaylaterbillnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandopenbalanceamount,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   
			<?php
			}
			}
			?>
			<?php
			
			
			
			$query446 = "select * from refund_paylater where locationcode ='".$locationcode."' AND billdate between '$ADate1' and '$ADate2' order by auto_number desc";
			$exec446 = mysql_query($query446) or die(mysql_error());
			while($res446 = mysql_fetch_array($exec446)) 
			{
			$grandpharmamount = 0;
			$res2paylaterrefundbillnumber = $res446['billno'];
			
			$grandlabamount = 0;
			$reslabcoaname5 = '';
		   $query447 = "select * from refund_paylaterlab where billnumber='$res2paylaterrefundbillnumber'";
		   $exec447 = mysql_query($query447) or die(mysql_error());
		   while($res447 = mysql_fetch_array($exec447))
		   {
		   $reslabdate = $res447['billdate'];
		   $reslabamount = $res447['labitemrate'];
		   $reslabcoa = $res447['labcoa'];
		   
		   $query448 = "select * from master_accountname where id='$reslabcoa'";
		   $exec448 = mysql_query($query448) or die(mysql_error());
		   $res448 = mysql_fetch_array($exec448);
		   $reslabcoaname5 = $res448['accountname'];
		   $grandlabamount = $grandlabamount + $reslabamount;
		   }
		   $snocount = $snocount + 1;
		   if($reslabcoaname5 != '')
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
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?>
			  </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $reslabdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <?php echo $reslabcoaname5; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2paylaterrefundbillnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandlabamount,2,'.',','); ?> </td>
           
           </tr>	   
		   
			<?php
			}
			$grandradiologyamount = 0;
			$resradiologycoaname6 = '';
		   $query449 = "select * from refund_paylaterradiology where billnumber='$res2paylaterrefundbillnumber'";
		   $exec449 = mysql_query($query449) or die(mysql_error());
		   while($res449 = mysql_fetch_array($exec449))
		   {
		   $resradiologydate = $res449['billdate'];
		   $resradiologyamount = $res449['radiologyitemrate'];
		   $resradiologycoa = $res449['radiologycoa'];
		   
		   $query450 = "select * from master_accountname where id='$resradiologycoa'";
		   $exec450 = mysql_query($query450) or die(mysql_error());
		   $res450 = mysql_fetch_array($exec450);
		   $resradiologycoaname6 = $res450['accountname'];
		    $grandradiologyamount = $grandradiologyamount + $resradiologyamount;
		   }
		   if($resradiologycoaname6 != '')
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
              <td class="bodytext31" valign="center"  align="left">
			  <?php
			  if($reslabcoaname5 == '')
			  {
			  echo $snocount; 
			  }
			  ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resradiologydate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <?php echo $resradiologycoaname6; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2paylaterrefundbillnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandradiologyamount,2,'.',','); ?> </td>
           
           </tr>	   
		   
			<?php
			}
			$grandservicesamount = 0;
			$resservicescoaname6 = '';
			 $query451 = "select * from refund_paylaterservices where billnumber='$res2paylaterrefundbillnumber'";
		   $exec451 = mysql_query($query451) or die(mysql_error());
		   while($res451 = mysql_fetch_array($exec451))
		   {
		   $resservicesdate = $res451['billdate'];
		   $resservicesamount = $res451['servicesitemrate'];
		   $resservicescoa = $res451['servicecoa'];
		   
		   $query452 = "select * from master_accountname where id='$resservicescoa'";
		   $exec452 = mysql_query($query452) or die(mysql_error());
		   $res452 = mysql_fetch_array($exec452);
		   $resservicescoaname6 = $res452['accountname'];
		   $grandservicesamount = $grandservicesamount + $resservicesamount;
		   }
		   if($resservicescoaname6 != '')
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
              <td class="bodytext31" valign="center"  align="left">
			  <?php
			  if(($reslabcoaname5 == '')||($resradiologycoaname6 == ''))
			  {
			  echo $snocount; 
			  }
			  ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resservicesdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <?php echo $resservicescoaname6; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2paylaterrefundbillnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandservicesamount,2,'.',','); ?></td>
           
           </tr>	   
		   
			<?php
			}
			$grandreferalamount = 0;
			$resreferalcoaname6 ='';
			$query453 = "select * from refund_paylaterreferal where billnumber='$res2paylaterrefundbillnumber'";
		   $exec453 = mysql_query($query453) or die(mysql_error());
		   while($res453 = mysql_fetch_array($exec453))
		   {
		   $resreferaldate = $res453['billdate'];
		   $resreferalamount = $res453['referalrate'];
		   $resreferalcoa = $res453['referalcoa'];
		   
		   $query454 = "select * from master_accountname where id='$resreferalcoa'";
		   $exec454 = mysql_query($query454) or die(mysql_error());
		   $res454 = mysql_fetch_array($exec454);
		   $resreferalcoaname6 = $res454['accountname'];
		   $grandreferalamount = $grandreferalamount + $resreferalamount;
		   }
		   if($resreferalcoaname6 != '')
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
              <td class="bodytext31" valign="center"  align="left">
			   <?php
			  if(($reslabcoaname5 == '')||($resradiologycoaname6 == '')||($resservicescoaname6 == ''))
			  {
			  echo $snocount; 
			  }
			  ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resreferaldate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <?php echo $resreferalcoaname6; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2paylaterrefundbillnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandreferalamount,2,'.',','); ?></td>
           
           </tr>	   
		   
			<?php
			}
			$query455 = "select * from refund_paylater where billno='$res2paylaterrefundbillnumber' and billdate between '$ADate1' and '$ADate2' order by auto_number desc";
			$exec455 = mysql_query($query455) or die(mysql_error());
			$res455 = mysql_fetch_array($exec455);
			$res2paylaterrefundbilldate = $res455['billdate'];
			$res2paylaterrefundaccountname = $res455['accountname'];
			$res2paylaterrefundamount = $res455['totalamount'];
			$res2paylaterrefundamount = -$res2paylaterrefundamount;
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
              <td class="bodytext31" valign="center"  align="left">
			   </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2paylaterrefundbilldate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $res2paylaterrefundaccountname; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2paylaterrefundbillnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($res2paylaterrefundamount,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   <?php
		
			}
			?>
			<?php
			$query456 = "select * from pharmacysalesreturn_details where locationcode ='".$locationcode."' AND billstatus = 'completed' and entrydate between '$ADate1' and '$ADate2' order by auto_number desc";
			$exec456 = mysql_query($query456) or die(mysql_error());
			while($res456 = mysql_fetch_array($exec456))
			{
			$res2pharmrefundbilldate = $res456['entrydate'];
			$res2pharmrefundcoa = $res456['pharmacycoa'];
			$res2pharmrefundamount = $res456['totalamount'];
			$res2pharmrefundbillnumber = $res456['billnumber'];
			$res2patientcode = $res456['patientcode'];
			
			$query4562 = "select * from master_customer where customercode = '$res2patientcode'";
			$exec4562 = mysql_query($query4562) or die(mysql_error());
			$res4562 = mysql_fetch_array($exec4562);
			$patientbilltype = $res4562['billtype'];
			
			if($patientbilltype == 'PAY LATER')
			{
			
		   $query4561 = "select * from master_accountname where id='$res2pharmrefundcoa'";
		   $exec4561 = mysql_query($query4561) or die(mysql_error());
		   $res4561 = mysql_fetch_array($exec4561);
		   $res2pharmrefundcoaname = $res4561['accountname'];
			$colorloopcount = $colorloopcount + 1;
			 $snocount = $snocount + 1;
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
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?>
			   </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2pharmrefundbilldate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <?php echo $res2pharmrefundcoaname; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2pharmrefundbillnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($res2pharmrefundamount,2,'.',','); ?></td>
           
           </tr>	   
		   <?php
		    $query457 = "select * from paylaterpharmareturns where billnumber='$res2pharmrefundbillnumber' and billdate between '$ADate1' and '$ADate2' order by auto_number desc";
			$exec457 = mysql_query($query457) or die(mysql_error());
			$res457 = mysql_fetch_array($exec457);
			
			$res2pharmrefundbilldate1 = $res457['billdate'];
			$res2pharmrefundamount1 = $res457['amount'];
			$res2pharmrefundbillnumber1 = $res457['billnumber'];
		    $res2pharmrefundcoaname1 = $res457['accountname'];
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
              <td class="bodytext31" valign="center"  align="left">
			   </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2pharmrefundbilldate1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $res2pharmrefundcoaname1; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2pharmrefundbillnumber1; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($res2pharmrefundamount1,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   <?php
		   }
		   }
		   ?>
		   <?php
		  
		  $query458 = "select * from paymentmodedebit where locationcode ='".$locationcode."' AND source='accountreceivable' and billdate between '$ADate1' and '$ADate2' group by billnumber order by auto_number desc";
		  $exec458 = mysql_query($query458) or die ("Error in Query2".mysql_error());
		  while ($res458 = mysql_fetch_array($exec458))
		  {
     	  $res2transactiondate = $res458['billdate'];
		  $res2billnumber = $res458['billnumber'];
		   $totalamount2 = 0;
		  $query462="select * from paymentmodedebit where source='accountreceivable' and billnumber='$res2billnumber'";
		  $exec462 = mysql_query($query462) or die(mysql_error());
		  while($res462 = mysql_fetch_array($exec462))
		  {
		  $cashamount2 = $res462['cash'];
		  $cashcoa =  $res462['cashcoa'];
		  $cardamount2 = $res462['card'];
		  $cardcoa =  $res462['cardcoa'];
		  $chequeamount2 = $res462['cheque'];
		  $chequecoa =  $res462['chequecoa'];
		  $onlineamount2 = $res462['online'];
		  $onlinecoa =  $res462['onlinecoa'];
		  $mpesaamount2 = $res462['mpesa'];
		  $mpesacoa =  $res462['mpesacoa'];
		  $totalamount2 = $totalamount2 + $cashamount2 + $cardamount2 + $chequeamount2 + $onlineamount2 + $mpesaamount2;
		  }
		  $query459 = "select * from master_accountname where id='$cashcoa' or id='$cardcoa' or id='$chequecoa' or id='$onlinecoa' or id='$mpesacoa'";
		  $exec459 = mysql_query($query459) or die(mysql_error());
		  $res459 = mysql_fetch_array($exec459);
		  $accountssub = $res459['accountssub'];
		  
		  $query460 = "select * from master_accountssub where auto_number='$accountssub'";
		  $exec460 = mysql_query($query460) or die(mysql_error());
		  $res460 = mysql_fetch_array($exec460);
		  $accountssubname = $res460['accountssub'];
		 	  $snocount = $snocount + 1;
					if($cashamount2 != '0.00')
	{
		
					
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
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'CASH'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($totalamount2,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   }
		   if($chequeamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			  <?php
			  if($cashamount2 == '0.00')
			  {
			  echo $snocount; 
			  }
			  ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'CHEQUE'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($totalamount2,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   }
		   if($cardamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			   <?php
			  if(($cashamount2 == '0.00')&&($chequeamount2 == '0.00'))
			  {
			  echo $snocount; 
			  }
			  ?>
			  </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'CARD'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($totalamount2,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   } if($onlineamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			   <?php
			  if(($cashamount2 == '0.00')&&($chequeamount2 == '0.00')&&($cardamount2 == '0.00'))
			  {
			  echo $snocount; 
			  }
			  ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'ONLINE'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($totalamount2,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   }
		   if($mpesaamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			   <?php
			  if(($cashamount2 == '0.00')&&($chequeamount2 == '0.00')&&($cardamount2 == '0.00')&&($onlineamount2 == '0.00'))
			  {
			  echo $snocount; 
			  }
			  ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'MPESA'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($totalamount2,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   }
		   ?>
		    <?php
			$res2totalamount1 = 0;
		    $query461 = "select * from master_transactionpaylater where docno='$res2billnumber' and transactiontype = 'PAYMENT' and transactionmodule = 'PAYMENT' and transactiondate between '$ADate1' and '$ADate2' order by auto_number desc";
			$exec461 = mysql_query($query461) or die(mysql_error());
			while($res461 = mysql_fetch_array($exec461))
			{
			$res2billdate1 = $res461['transactiondate'];
			$res2amount1 = $res461['transactionamount'];
			$res2billnumber1 = $res461['docno'];
		    $res2coaname1 = $res461['accountname'];
			$res2totalamount1 = $res2totalamount1 + $res2amount1;
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
              <td class="bodytext31" valign="center"  align="left">
			   </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billdate1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $res2coaname1; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($res2totalamount1,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   <?php
		   }
		   ?>
		   <?php
			
		    $query462 = "select * from master_transactionpharmacy where locationcode ='".$locationcode."' AND transactiontype = 'PAYMENT' and transactionmodule = 'PAYMENT' and recordstatus = 'allocated' and transactiondate between '$ADate1' and '$ADate2' group by docno order by auto_number desc";
			$exec462 = mysql_query($query462) or die(mysql_error());
			while($res462 = mysql_fetch_array($exec462))
			{
			$res2suppliertotalamount1 = 0;
			$res2supplierbilldate1 = $res462['transactiondate'];
			$timestamp = strtotime($res2supplierbilldate1);
			$date = date('Y-m-d', $timestamp);
			$res2supplierbillnumber1 = $res462['docno'];
		    $res2suppliercoaname1 = $res462['suppliername'];
			
			$query463 = "select * from master_transactionpharmacy where docno = '$res2supplierbillnumber1' and recordstatus = 'allocated'";
			$exec463 = mysql_query($query463) or die(mysql_error());
			while($res463 = mysql_fetch_array($exec463))
			{
			$res2supplieramount1 = $res462['transactionamount'];
			$res2suppliertotalamount1 = $res2suppliertotalamount1 + $res2supplieramount1;
			}
			  $snocount = $snocount + 1;
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
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?>
			   </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $date; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <?php echo $res2suppliercoaname1; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2supplierbillnumber1; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($res2suppliertotalamount1,2,'.',','); ?> </td>
           
           </tr>	   
		    <?php
		  
		  $query464 = "select * from paymentmodecredit where source='supplierpaymententry' and billnumber='$res2supplierbillnumber1' and billdate between '$ADate1' and '$ADate2' group by billnumber order by auto_number desc";
		  $exec464 = mysql_query($query464) or die ("Error in Query2".mysql_error());
		  while ($res464 = mysql_fetch_array($exec464))
		  {
     	  $res2suppliertransactiondate = $res464['billdate'];
		
		   $totalsupplieramount2 = 0;
		  $query465="select * from paymentmodecredit where source='supplierpaymententry' and billnumber='$res2supplierbillnumber1'";
		  $exec465 = mysql_query($query465) or die(mysql_error());
		  while($res465 = mysql_fetch_array($exec465))
		  {
		  $cashamount2 = $res465['cash'];
		  $cashcoa =  $res465['cashcoa'];
		  $cardamount2 = $res465['card'];
		  $cardcoa =  $res465['cardcoa'];
		  $chequeamount2 = $res465['cheque'];
		  $chequecoa =  $res465['chequecoa'];
		  $onlineamount2 = $res465['online'];
		  $onlinecoa =  $res465['onlinecoa'];
		  $mpesaamount2 = $res465['mpesa'];
		  $mpesacoa =  $res465['mpesacoa'];
		
		 
		  $totalsupplieramount2 = $totalsupplieramount2 + $cashamount2 + $cardamount2 + $chequeamount2 + $onlineamount2 + $mpesaamount2;
		  }
		   $query468 = "select * from master_transactionpharmacy where docno = '$res2supplierbillnumber1'";
		  $exec468 = mysql_query($query468) or die(mysql_error());
		  $res468 = mysql_fetch_array($exec468);
		
		  $taxamount = $res468['taxamount'];
		  
		  $query466 = "select * from master_accountname where id='$cashcoa' or id='$cardcoa' or id='$chequecoa' or id='$onlinecoa' or id='$mpesacoa'";
		  $exec466 = mysql_query($query466) or die(mysql_error());
		  $res466 = mysql_fetch_array($exec466);
		  $accountssub = $res466['accountssub'];
		  
		  $query467 = "select * from master_accountssub where auto_number='$accountssub'";
		  $exec467 = mysql_query($query467) or die(mysql_error());
		  $res467 = mysql_fetch_array($exec467);
		  $accountssubname = $res467['accountssub'];
		 	 
					if($cashamount2 != '0.00')
	{
		
					
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2suppliertransactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <div class="bodytext31"><?php echo 'CASH'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2supplierbillnumber1; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($totalsupplieramount2,2,'.',','); ?> Cr</td>
           
           </tr>
		   <?php
		   }
		   if($chequeamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			</td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2suppliertransactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <div class="bodytext31"><?php echo 'CHEQUE'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2supplierbillnumber1; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($totalsupplieramount2,2,'.',','); ?> Cr</td>
           
           </tr>
		   <?php
		   }
		   if($cardamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			  
			  </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2suppliertransactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <div class="bodytext31"><?php echo 'CARD'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2supplierbillnumber1; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($totalsupplieramount2,2,'.',','); ?> Cr</td>
           
           </tr>
		   <?php
		   } if($onlineamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			   </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2suppliertransactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <div class="bodytext31"><?php echo 'ONLINE'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2supplierbillnumber1; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($totalsupplieramount2,2,'.',','); ?> Cr</td>
           
           </tr>
		   <?php
		   }
		   if($mpesaamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			 </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2suppliertransactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <div class="bodytext31"><?php echo 'MPESA'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2supplierbillnumber1; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($totalsupplieramount2,2,'.',','); ?> Cr</td>
           
           </tr>
		   <?php
		   }
		  
		   }
		   }
		   ?>
		   <?php
		    
			
		    $query468 = "select * from master_transactiondoctor where locationcode ='".$locationcode."' AND transactiontype = 'PAYMENT' and transactionmodule = 'PAYMENT' and transactiondate between '$ADate1' and '$ADate2' group by docno order by auto_number desc";
			$exec468 = mysql_query($query468) or die(mysql_error());
			while($res468 = mysql_fetch_array($exec468))
			{
			$res2doctortotalamount1 = 0;
			$res2doctorbilldate1 = $res468['transactiondate'];
			
			$res2doctorbillnumber1 = $res468['docno'];
		    $res2doctorcoaname1 = $res468['doctorname'];
			
			$query469 = "select * from master_transactiondoctor where docno = '$res2doctorbillnumber1'";
			$exec469 = mysql_query($query469) or die(mysql_error());
			while($res469 = mysql_fetch_array($exec469))
			{
			$res2doctoramount1 = $res469['transactionamount'];
			$res2doctortotalamount1 = $res2doctortotalamount1 + $res2doctoramount1;
			}
			  $snocount = $snocount + 1;
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
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?>
			   </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2doctorbilldate1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <?php echo $res2doctorcoaname1; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2doctorbillnumber1; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($res2doctortotalamount1,2,'.',','); ?> </td>
           
           </tr>	   
		    <?php
		  
		  $query470 = "select * from paymentmodedebit where source='doctorpaymententry' and billnumber='$res2doctorbillnumber1' and billdate between '$ADate1' and '$ADate2' group by billnumber order by auto_number desc";
		  $exec470 = mysql_query($query470) or die ("Error in Query2".mysql_error());
		  while ($res470 = mysql_fetch_array($exec470))
		  {
     	  $res2doctortransactiondate = $res470['billdate'];
		
		   $totaldoctoramount2 = 0;
		  $query471="select * from paymentmodedebit where source='doctorpaymententry' and billnumber='$res2doctorbillnumber1'";
		  $exec471 = mysql_query($query471) or die(mysql_error());
		  while($res471 = mysql_fetch_array($exec471))
		  {
		  $cashamount2 = $res471['cash'];
		  $cashcoa =  $res471['cashcoa'];
		  $cardamount2 = $res471['card'];
		  $cardcoa =  $res471['cardcoa'];
		  $chequeamount2 = $res471['cheque'];
		  $chequecoa =  $res471['chequecoa'];
		  $onlineamount2 = $res471['online'];
		  $onlinecoa =  $res471['onlinecoa'];
		  $mpesaamount2 = $res471['mpesa'];
		  $mpesacoa =  $res471['mpesacoa'];
		
		 
		  $totaldoctoramount2 = $totaldoctoramount2 + $cashamount2 + $cardamount2 + $chequeamount2 + $onlineamount2 + $mpesaamount2;
		  }
		
	
		 	 
					if($cashamount2 != '0.00')
	{
		
					
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2doctortransactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <div class="bodytext31"><?php echo 'CASH'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2doctorbillnumber1; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($totaldoctoramount2,2,'.',','); ?> Cr</td>
           
           </tr>
		   <?php
		   }
		   if($chequeamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			</td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2doctortransactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <div class="bodytext31"><?php echo 'CHEQUE'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2doctorbillnumber1; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($totaldoctoramount2,2,'.',','); ?> Cr</td>
           
           </tr>
		   <?php
		   }
		   if($cardamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			  
			  </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2doctortransactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <div class="bodytext31"><?php echo 'CARD'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2doctorbillnumber1; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($totaldoctoramount2,2,'.',','); ?> Cr</td>
           
           </tr>
		   <?php
		   } if($onlineamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			   </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2doctortransactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <div class="bodytext31"><?php echo 'ONLINE'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2doctorbillnumber1; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($totaldoctoramount2,2,'.',','); ?> Cr</td>
           
           </tr>
		   <?php
		   }
		   if($mpesaamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			 </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2doctortransactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <div class="bodytext31"><?php echo 'MPESA'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2doctorbillnumber1; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($totaldoctoramount2,2,'.',','); ?> Cr</td>
           
           </tr>
		   <?php
		   }
		  
		   }
		   }
		   ?>
		    <?php
		  
		  $query472 = "select * from paymentmodedebit where locationcode ='".$locationcode."' AND source='advancedeposit' and billdate between '$ADate1' and '$ADate2' group by billnumber order by auto_number desc";
		  $exec472 = mysql_query($query472) or die ("Error in Query2".mysql_error());
		  while ($res472 = mysql_fetch_array($exec472))
		  {
     	  $res2transactiondate = $res472['billdate'];
		  $res2billnumber = $res472['billnumber'];
		   $totalamountipdeposit2 = 0;
		  $query473="select * from paymentmodedebit where source='advancedeposit' and billnumber='$res2billnumber'";
		  $exec473 = mysql_query($query473) or die(mysql_error());
		  while($res473 = mysql_fetch_array($exec473))
		  {
		  $cashamount2 = $res473['cash'];
		  $cashcoa =  $res473['cashcoa'];
		  $cardamount2 = $res473['card'];
		  $cardcoa =  $res473['cardcoa'];
		  $chequeamount2 = $res473['cheque'];
		  $chequecoa =  $res473['chequecoa'];
		  $onlineamount2 = $res473['online'];
		  $onlinecoa =  $res473['onlinecoa'];
		  $mpesaamount2 = $res473['mpesa'];
		  $mpesacoa =  $res473['mpesacoa'];
		  $totalamountipdeposit2 = $totalamountipdeposit2 + $cashamount2 + $cardamount2 + $chequeamount2 + $onlineamount2 + $mpesaamount2;
		  }
		 
		 	  $snocount = $snocount + 1;
					if($cashamount2 != '0.00')
	{
		
					
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
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'CASH'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($totalamountipdeposit2,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   }
		   if($chequeamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			  <?php
			  if($cashamount2 == '0.00')
			  {
			  echo $snocount; 
			  }
			  ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'CHEQUE'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($totalamountipdeposit2,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   }
		   if($cardamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			   <?php
			  if(($cashamount2 == '0.00')&&($chequeamount2 == '0.00'))
			  {
			  echo $snocount; 
			  }
			  ?>
			  </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'CARD'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($totalamountipdeposit2,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   } if($onlineamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			   <?php
			  if(($cashamount2 == '0.00')&&($chequeamount2 == '0.00')&&($cardamount2 == '0.00'))
			  {
			  echo $snocount; 
			  }
			  ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'ONLINE'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($totalamountipdeposit2,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   }
		   if($mpesaamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			   <?php
			  if(($cashamount2 == '0.00')&&($chequeamount2 == '0.00')&&($cardamount2 == '0.00')&&($onlineamount2 == '0.00'))
			  {
			  echo $snocount; 
			  }
			  ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'MPESA'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($totalamountipdeposit2,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   }
		   ?>
		    <?php
			$res2totalamountadvance1 = 0;
		    $query474 = "select * from master_transactionadvancedeposit where docno='$res2billnumber' and transactiontype = 'PAYMENT' and transactionmodule = 'PAYMENT' and transactiondate between '$ADate1' and '$ADate2' order by auto_number desc";
			$exec474 = mysql_query($query474) or die(mysql_error());
			while($res474 = mysql_fetch_array($exec474))
			{
			$res2billdate1 = $res474['transactiondate'];
			$res2amount1 = $res474['transactionamount'];
			$res2billnumber1 = $res474['docno'];
		    $res2coa = $res474['coa'];
			
			$query475 = "select * from master_accountname where id='$res2coa'";
		   $exec475 = mysql_query($query475) or die(mysql_error());
		   $res475 = mysql_fetch_array($exec475);
		   $res2coaname = $res475['accountname'];
			$res2totalamountadvance1 = $res2totalamountadvance1 + $res2amount1;
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
              <td class="bodytext31" valign="center"  align="left">
			   </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billdate1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $res2coaname; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($res2totalamountadvance1,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   <?php
		   }
		   ?>
		     <?php
		  
		  $query476 = "select * from paymentmodedebit where locationcode ='".$locationcode."' AND source='deposit' and billdate between '$ADate1' and '$ADate2' group by billnumber order by auto_number desc";
		  $exec476 = mysql_query($query476) or die ("Error in Query2".mysql_error());
		  while ($res476 = mysql_fetch_array($exec476))
		  {
     	  $res2transactiondate = $res476['billdate'];
		  $res2billnumber = $res476['billnumber'];
		   $totalamountdeposit2 = 0;
		  $query477="select * from paymentmodedebit where source='deposit' and billnumber='$res2billnumber'";
		  $exec477 = mysql_query($query477) or die(mysql_error());
		  while($res477 = mysql_fetch_array($exec477))
		  {
		  $cashamount2 = $res477['cash'];
		  $cashcoa =  $res477['cashcoa'];
		  $cardamount2 = $res477['card'];
		  $cardcoa =  $res477['cardcoa'];
		  $chequeamount2 = $res477['cheque'];
		  $chequecoa =  $res477['chequecoa'];
		  $onlineamount2 = $res477['online'];
		  $onlinecoa =  $res477['onlinecoa'];
		  $mpesaamount2 = $res477['mpesa'];
		  $mpesacoa =  $res477['mpesacoa'];
		  $totalamountdeposit2 = $totalamountdeposit2 + $cashamount2 + $cardamount2 + $chequeamount2 + $onlineamount2 + $mpesaamount2;
		  }
		 
		 	  $snocount = $snocount + 1;
					if($cashamount2 != '0.00')
	{
		
					
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
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'CASH'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($totalamountdeposit2,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   }
		   if($chequeamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			  <?php
			  if($cashamount2 == '0.00')
			  {
			  echo $snocount; 
			  }
			  ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo 'CHEQUE'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($totalamountdeposit2,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   }
		   if($cardamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			   <?php
			  if(($cashamount2 == '0.00')&&($chequeamount2 == '0.00'))
			  {
			  echo $snocount; 

			  }
			  ?>
			  </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'CARD'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($totalamountdeposit2,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   } if($onlineamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			   <?php
			  if(($cashamount2 == '0.00')&&($chequeamount2 == '0.00')&&($cardamount2 == '0.00'))
			  {
			  echo $snocount; 
			  }
			  ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'ONLINE'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($totalamountdeposit2,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   }
		   if($mpesaamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			   <?php
			  if(($cashamount2 == '0.00')&&($chequeamount2 == '0.00')&&($cardamount2 == '0.00')&&($onlineamount2 == '0.00'))
			  {
			  echo $snocount; 
			  }
			  ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'MPESA'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($totalamountdeposit2,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   }
		   ?>
		    <?php
			$res2totalamountdeposit1 = 0;
		    $query478 = "select * from master_transactionipdeposit where docno='$res2billnumber' and transactiontype = 'PAYMENT' and transactionmodule = 'PAYMENT' and transactiondate between '$ADate1' and '$ADate2' order by auto_number desc";
			$exec478 = mysql_query($query478) or die(mysql_error());
			while($res478 = mysql_fetch_array($exec478))
			{
			$res2billdate1 = $res478['transactiondate'];
			$res2amount1 = $res478['transactionamount'];
			$res2billnumber1 = $res478['docno'];
		    $res2coa = $res478['coa'];
			
			$query479 = "select * from master_accountname where id='$res2coa'";
		   $exec479 = mysql_query($query479) or die(mysql_error());
		   $res479 = mysql_fetch_array($exec479);
		   $res2coaname = $res479['accountname'];
			$res2totalamountdeposit1 = $res2totalamountdeposit1 + $res2amount1;
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
              <td class="bodytext31" valign="center"  align="left">
			   </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billdate1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $res2coaname; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($res2totalamountdeposit1,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   <?php
		   }
		   ?>
		   
		  
		   		    <?php
			
		    $query480 = "select * from billing_ip where locationcode ='".$locationcode."' AND billdate between '$ADate1' and '$ADate2' order by auto_number desc";
			$exec480 = mysql_query($query480) or die(mysql_error());
			while($res480 = mysql_fetch_array($exec480))
			{
			$res2finalbilldate1 = $res480['billdate'];
			$res2finalamount1 = $res480['totalamount'];
			$res2finalbillnumber1 = $res480['billno'];
			$res2finalaccountname = $res480['accountname'];
			$res2patienttype = $res480['patientbilltype'];
			
			 $snocount = $snocount + 1;
			
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
              <td class="bodytext31" valign="center"  align="left">
			   <?php echo $snocount;  ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalbilldate1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <?php echo $res2finalaccountname; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalbillnumber1; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($res2finalamount1,2,'.',','); ?></td>
           
           </tr>	   
		   <?php
		  
		  $query481 = "select * from paymentmodedebit where source='ipfinalinvoice' and billnumber='$res2finalbillnumber1' and billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec481 = mysql_query($query481) or die ("Error in Query2".mysql_error());
		  while ($res481 = mysql_fetch_array($exec481))
		  {
     	  $res2finaltransactiondate = $res481['billdate'];
		  $res2finalbillnumber = $res481['billnumber'];
		  $res2visitcode = $res481['patientvisitcode'];
		 
		  $cashamount2 = $res481['cash'];
		  $cashcoa =  $res481['cashcoa'];
		  $cardamount2 = $res481['card'];
		  $cardcoa =  $res481['cardcoa'];
		  $chequeamount2 = $res481['cheque'];
		  $chequecoa =  $res481['chequecoa'];
		  $onlineamount2 = $res481['online'];
		  $onlinecoa =  $res481['onlinecoa'];
		  $mpesaamount2 = $res481['mpesa'];
		  $mpesacoa =  $res481['mpesacoa'];
		 
		 
		 	 
					if($cashamount2 != '0.00')
	{
		
					
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finaltransactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'CASH'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalbillnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($cashamount2,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   }
		   if($chequeamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			 </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finaltransactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo 'CHEQUE'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalbillnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($chequeamount2,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   }
		   if($cardamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			 
			  </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finaltransactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'CARD'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalbillnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($cardamount2,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   } if($onlineamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			   </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finaltransactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'ONLINE'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalbillnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($onlineamount2,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   }
		   if($mpesaamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			   </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finaltransactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'MPESA'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalbillnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($mpesaamount2,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   }
		  
		  }
		   ?>
		   <?php
		   if($res2patienttype == 'PAY NOW')
		   {
		    $grandfinalipdepositamount11 = '0.00';
			$res2finalipdepositaccountcoa = '';
		    $query504 = "select * from master_transactionipdeposit where visitcode='$res2visitcode' and transactionmodule <> 'Adjustment' order by auto_number desc";
			$exec504 = mysql_query($query504) or die(mysql_error());
			while($res504 = mysql_fetch_array($exec504))
			{
			$res2finalipdepositbilldate1 = $res504['transactiondate'];
			$res2finalipdepositamount1 = $res504['transactionamount'];
			$res2finalipdepositaccountcoa = $res504['coa'];
			$grandfinalipdepositamount11 = $grandfinalipdepositamount11 + $res2finalipdepositamount1;
			}
			
		   $query505 = "select * from master_accountname where id='$res2finalipdepositaccountcoa'";
		   $exec505 = mysql_query($query505) or die(mysql_error());
		   $res505 = mysql_fetch_array($exec505);
		   $res2finalipdepositcoaname = $res505['accountname'];
			
			if($grandfinalipdepositamount11 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			 </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalipdepositbilldate1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <?php echo $res2finalipdepositcoaname; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalbillnumber1; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($res2finalipdepositamount1,2,'.',','); ?></td>
           
           </tr>	   
		  
		   <?php
		  }
		  }
		   	$grandfinallabamount = 0;
			$resfinallabcoaname6 = '';
			 $query482 = "select * from billing_iplab where billnumber='$res2finalbillnumber1'";
		   $exec482 = mysql_query($query482) or die(mysql_error());
		   while($res482 = mysql_fetch_array($exec482))
		   {
		   $resfinallabdate = $res482['billdate'];
		   $resfinallabamount = $res482['labitemrate'];
		   $resfinallabcoa = $res482['labcoa'];
		   
		   $query483 = "select * from master_accountname where id='$resfinallabcoa'";
		   $exec483 = mysql_query($query483) or die(mysql_error());
		   $res483 = mysql_fetch_array($exec483);
		   $resfinallabcoaname6 = $res483['accountname'];
		   $grandfinallabamount = $grandfinallabamount + $resfinallabamount;
		   }
		   if($resfinallabcoaname6 != '')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resfinallabdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $resfinallabcoaname6; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalbillnumber1; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandfinallabamount,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   
			<?php
			}
			?>
					   <?php
		   	$grandfinalradiologyamount = 0;
			$resfinalradiologycoaname6 = '';
			 $query484 = "select * from billing_ipradiology where billnumber='$res2finalbillnumber1'";
		   $exec484 = mysql_query($query484) or die(mysql_error());
		   while($res484 = mysql_fetch_array($exec484))
		   {
		   $resfinalradiologydate = $res484['billdate'];
		   $resfinalradiologyamount = $res484['radiologyitemrate'];
		   $resfinalradiologycoa = $res484['radiologycoa'];
		   
		   $query485 = "select * from master_accountname where id='$resfinalradiologycoa'";
		   $exec485 = mysql_query($query485) or die(mysql_error());
		   $res485 = mysql_fetch_array($exec485);
		   $resfinalradiologycoaname6 = $res485['accountname'];
		   $grandfinalradiologyamount = $grandfinalradiologyamount + $resfinalradiologyamount;
		   }
		   if($resfinalradiologycoaname6 != '')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resfinalradiologydate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $resfinalradiologycoaname6; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalbillnumber1; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandfinalradiologyamount,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   
			<?php
			}
			?>
							   <?php
		   	$grandfinalservicesamount = 0;
			$resfinalservicescoaname6 = '';
			 $query486 = "select * from billing_ipservices where billnumber='$res2finalbillnumber1'";
		   $exec486 = mysql_query($query486) or die(mysql_error());
		   while($res486 = mysql_fetch_array($exec486))
		   {
		   $resfinalservicesdate = $res486['billdate'];
		   $resfinalservicesamount = $res486['servicesitemrate'];
		   $resfinalservicescoa = $res486['servicecoa'];
		   
		   $query487 = "select * from master_accountname where id='$resfinalservicescoa'";
		   $exec487 = mysql_query($query487) or die(mysql_error());
		   $res487 = mysql_fetch_array($exec487);
		   $resfinalservicescoaname6 = $res487['accountname'];
		   $grandfinalservicesamount = $grandfinalservicesamount + $resfinalservicesamount;
		   }
		   if($resfinalservicescoaname6 != '')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resfinalservicesdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $resfinalservicescoaname6; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalbillnumber1; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandfinalservicesamount,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   
			<?php
			}
			?>
		 <?php
		   	$grandfinalpharmacyamount = 0;
			$resfinalpharmacycoaname6 = '';
			 $query488 = "select * from billing_ippharmacy where billnumber='$res2finalbillnumber1'";
		   $exec488 = mysql_query($query488) or die(mysql_error());
		   while($res488 = mysql_fetch_array($exec488))
		   {
		   $resfinalpharmacydate = $res488['billdate'];
		   $resfinalpharmacyamount = $res488['amount'];
		   $resfinalpharmacycoa = $res488['pharmacycoa'];
		   
		   $query489 = "select * from master_accountname where id='$resfinalpharmacycoa'";
		   $exec489 = mysql_query($query489) or die(mysql_error());
		   $res489 = mysql_fetch_array($exec489);
		   $resfinalpharmacycoaname6 = $res489['accountname'];
		   $grandfinalpharmacyamount = $grandfinalpharmacyamount + $resfinalpharmacyamount;
		   }
		   if($resfinalpharmacycoaname6 != '')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resfinalpharmacydate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $resfinalpharmacycoaname6; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalbillnumber1; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandfinalpharmacyamount,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   
			<?php
			}
			?>
				 <?php
		   	$grandfinalbedchargesamount = 0;
			$resfinalbedchargescoaname6 = '';
			 $query490 = "select * from billing_ipbedcharges where docno='$res2finalbillnumber1'";
		   $exec490 = mysql_query($query490) or die(mysql_error());
		   while($res490 = mysql_fetch_array($exec490))
		   {
		   $resfinalbedchargesdate = $res490['recorddate'];
		   $resfinalbedchargesamount = $res490['amount'];
		   $resfinalbedchargescoa = $res490['coa'];
		   
		   $query491 = "select * from master_accountname where id='$resfinalbedchargescoa'";
		   $exec491 = mysql_query($query491) or die(mysql_error());
		   $res491 = mysql_fetch_array($exec491);
		   $resfinalbedchargescoaname6 = $res491['accountname'];
		   $grandfinalbedchargesamount = $grandfinalbedchargesamount + $resfinalbedchargesamount;
		   }
		   if($resfinalbedchargescoaname6 != '')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resfinalbedchargesdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $resfinalbedchargescoaname6; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalbillnumber1; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandfinalbedchargesamount,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   
			<?php
			}
			?>
						 <?php
		   	$grandfinalprivatedoctoramount = 0;
			$resfinalprivatedoctorcoaname6 = '';
			 $query492 = "select * from billing_ipprivatedoctor where docno='$res2finalbillnumber1'";
		   $exec492 = mysql_query($query492) or die(mysql_error());
		   while($res492 = mysql_fetch_array($exec492))
		   {
		   $resfinalprivatedoctordate = $res492['recorddate'];
		   $resfinalprivatedoctoramount = $res492['amount'];
		   $resfinalprivatedoctorcoa = $res492['coa'];
		   
		   $query493 = "select * from master_accountname where id='$resfinalprivatedoctorcoa'";
		   $exec493 = mysql_query($query493) or die(mysql_error());
		   $res493 = mysql_fetch_array($exec493);
		   $resfinalprivatedoctorcoaname6 = $res493['accountname'];
		   $grandfinalprivatedoctoramount = $grandfinalprivatedoctoramount + $resfinalprivatedoctoramount;
		   }
		   if($resfinalprivatedoctorcoaname6 != '')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resfinalprivatedoctordate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $resfinalprivatedoctorcoaname6; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalbillnumber1; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandfinalprivatedoctoramount,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   
			<?php
			}
			?>
								 <?php
		   	$grandfinalambulanceamount = 0;
			$resfinalambulancecoaname6 = '';
			 $query494 = "select * from billing_ipambulance where docno='$res2finalbillnumber1'";
		   $exec494 = mysql_query($query494) or die(mysql_error());
		   while($res494 = mysql_fetch_array($exec494))
		   {
		   $resfinalambulancedate = $res494['recorddate'];
		   $resfinalambulanceamount = $res494['amount'];
		   $resfinalambulancecoa = $res494['coa'];
		   
		   $query495 = "select * from master_accountname where id='$resfinalambulancecoa'";
		   $exec495 = mysql_query($query495) or die(mysql_error());
		   $res495 = mysql_fetch_array($exec495);
		   $resfinalambulancecoaname6 = $res495['accountname'];
		   $grandfinalambulanceamount = $grandfinalambulanceamount + $resfinalambulanceamount;
		   }
		   if($resfinalambulancecoaname6 != '')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resfinalambulancedate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $resfinalambulancecoaname6; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalbillnumber1; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandfinalambulanceamount,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   
			<?php
			}
			?>
									 <?php
		   	$grandfinalnhifamount = 0;
			$resfinalnhifcoaname6 = '';
			 $query496 = "select * from billing_ipnhif where docno='$res2finalbillnumber1'";
		   $exec496 = mysql_query($query496) or die(mysql_error());
		   while($res496 = mysql_fetch_array($exec496))
		   {
		   $resfinalnhifdate = $res496['recorddate'];
		   $resfinalnhifamount = $res496['amount'];
		   $resfinalnhifcoa = $res496['coa'];
		   
		   $query497 = "select * from master_accountname where id='$resfinalnhifcoa'";
		   $exec497 = mysql_query($query497) or die(mysql_error());
		   $res497 = mysql_fetch_array($exec497);
		   $resfinalnhifcoaname6 = $res497['accountname'];
		   $grandfinalnhifamount = $grandfinalnhifamount + $resfinalnhifamount;
		   }
		   if($resfinalnhifcoaname6 != '')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resfinalnhifdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $resfinalnhifcoaname6; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalbillnumber1; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandfinalnhifamount,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   
			<?php
			}
			?>
			 <?php
		   	$grandfinalotbillingamount = 0;
			$resfinalotbillingcoaname6 = '';
			 $query498 = "select * from billing_ipotbilling where docno='$res2finalbillnumber1'";
		   $exec498 = mysql_query($query498) or die(mysql_error());
		   while($res498 = mysql_fetch_array($exec498))
		   {
		   $resfinalotbillingdate = $res498['recorddate'];
		   $resfinalotbillingamount = $res498['amount'];
		   $resfinalotbillingcoa = $res498['coa'];
		   
		   $query499 = "select * from master_accountname where id='$resfinalotbillingcoa'";
		   $exec499 = mysql_query($query499) or die(mysql_error());
		   $res499 = mysql_fetch_array($exec499);
		   $resfinalotbillingcoaname6 = $res499['accountname'];
		   $grandfinalotbillingamount = $grandfinalotbillingamount + $resfinalotbillingamount;
		   }
		   if($resfinalotbillingcoaname6 != '')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resfinalotbillingdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $resfinalotbillingcoaname6; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalbillnumber1; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandfinalotbillingamount,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   
			<?php
			}
			?>
			<?php
		   	$grandfinalmiscbillingamount = 0;
			$resfinalmiscbillingcoaname6 = '';
			 $query500 = "select * from billing_ipmiscbilling where docno='$res2finalbillnumber1'";
		   $exec500 = mysql_query($query500) or die(mysql_error());
		   while($res500 = mysql_fetch_array($exec500))
		   {
		   $resfinalmiscbillingdate = $res500['recorddate'];
		   $resfinalmiscbillingamount = $res500['amount'];
		   $resfinalmiscbillingcoa = $res500['coa'];
		   
		   $query501 = "select * from master_accountname where id='$resfinalmiscbillingcoa'";
		   $exec501 = mysql_query($query501) or die(mysql_error());
		   $res501 = mysql_fetch_array($exec501);
		   $resfinalmiscbillingcoaname6 = $res501['accountname'];
		   $grandfinalmiscbillingamount = $grandfinalmiscbillingamount + $resfinalmiscbillingamount;
		   }
		   if($resfinalmiscbillingcoaname6 != '')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resfinalmiscbillingdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $resfinalmiscbillingcoaname6; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalbillnumber1; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandfinalmiscbillingamount,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   
			<?php
			}
			?>
			<?php
		   	$grandfinaladmissionchargeamount = 0;
			$resfinaladmissionchargecoaname6 = '';
			 $query502 = "select * from billing_ipadmissioncharge where docno='$res2finalbillnumber1'";
		   $exec502 = mysql_query($query502) or die(mysql_error());
		   while($res502 = mysql_fetch_array($exec502))
		   {
		   $resfinaladmissionchargedate = $res502['recorddate'];
		   $resfinaladmissionchargeamount = $res502['amount'];
		   $resfinaladmissionchargecoa = $res502['coa'];
		   
		   $query503 = "select * from master_accountname where id='$resfinaladmissionchargecoa'";
		   $exec503 = mysql_query($query503) or die(mysql_error());
		   $res503 = mysql_fetch_array($exec503);
		   $resfinaladmissionchargecoaname6 = $res503['accountname'];
		   $grandfinaladmissionchargeamount = $grandfinaladmissionchargeamount + $resfinaladmissionchargeamount;
		   }
		   if($resfinaladmissionchargecoaname6 != '')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resfinaladmissionchargedate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $resfinaladmissionchargecoaname6; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalbillnumber1; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandfinaladmissionchargeamount,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   
			<?php
			}
			?>
		   <?php
		   }
		   ?>
		   		    <?php
			
		    $query504 = "select * from master_transactionipcreditapproved where locationcode ='".$locationcode."' AND transactiondate between '$ADate1' and '$ADate2' group by billnumber order by auto_number desc";
			$exec504 = mysql_query($query504) or die(mysql_error());
			while($res504 = mysql_fetch_array($exec504))
			{
			$res2finalbilldate1 = $res504['transactiondate'];
			$res2finalamount1 = $res504['transactionamount'];
			$res2finalbillnumber1 = $res504['billnumber'];
			$res2visitcode = $res504['visitcode'];
			$res2finalbillcreditaccountname = $res504['accountname'];
			$snocount = $snocount + 1;
			$sn = $snocount;
			$query505 = "select * from master_transactionipcreditapproved where billnumber='$res2finalbillnumber1'";
			$exec505 = mysql_query($query505) or die(mysql_error());
			while($res505 = mysql_fetch_array($exec505))
			{
			
			$res2finalbilldate2 = $res505['transactiondate'];
			$res2finalbillcreditaccountname2 = $res505['postingaccount'];
			$res2finalbillcreditpatientaccountname2 = $res505['accountname'];
			$res2finalcreditamount1 = $res505['transactionamount'];
			  if(($res2finalbillcreditaccountname2 != 'CASH')||($res2finalbillcreditpatientaccountname2 != 'CASH'))
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
              <td class="bodytext31" valign="center"  align="left">
			   <?php echo $sn;  ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalbilldate2; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <?php echo $res2finalbillcreditaccountname2; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalbillnumber1; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($res2finalcreditamount1,2,'.',','); ?></td>
           
           </tr>	   
		   <?php
		   }
		   if(($res2finalbillcreditaccountname2 == 'CASH')&&($res2finalbillcreditpatientaccountname2 == 'CASH'))
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
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $sn;  ?> </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalbilldate2; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <?php echo $res2finalbillcreditpatientaccountname2; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalbillnumber1; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($res2finalcreditamount1,2,'.',','); ?></td>
           
           </tr>	   
		   <?php
		   }
		   $sn = '';
		   }
		 
		   ?>
		   <?php
		  
		  $query506 = "select * from paymentmodedebit where billnumber='$res2finalbillnumber1' and billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec506 = mysql_query($query506) or die ("Error in Query2".mysql_error());
		  while ($res506 = mysql_fetch_array($exec506))
		  {
     	  $res2finaltransactiondate = $res506['billdate'];
		  $res2finalbillnumber = $res506['billnumber'];
		  $res2visitcode = $res506['patientvisitcode'];
		 
		  $cashamount2 = $res506['cash'];
		  $cashcoa =  $res506['cashcoa'];
		  $cardamount2 = $res506['card'];
		  $cardcoa =  $res506['cardcoa'];
		  $chequeamount2 = $res506['cheque'];
		  $chequecoa =  $res506['chequecoa'];
		  $onlineamount2 = $res506['online'];
		  $onlinecoa =  $res506['onlinecoa'];
		  $mpesaamount2 = $res506['mpesa'];
		  $mpesacoa =  $res506['mpesacoa'];
		 
		 
		 	 
					if($cashamount2 != '0.00')
	{
		
					
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finaltransactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'CASH'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalbillnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($cashamount2,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   }
		   if($chequeamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			 </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finaltransactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
				<div class="bodytext31"><?php echo 'CHEQUE'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalbillnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($chequeamount2,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   }
		   if($cardamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			 
			  </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finaltransactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'CARD'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalbillnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($cardamount2,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   } if($onlineamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			   </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finaltransactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'ONLINE'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalbillnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($onlineamount2,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   }
		   if($mpesaamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			   </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finaltransactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'MPESA'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalbillnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($mpesaamount2,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   }
		  
		  }
		   ?>
		   <?php
		    $grandfinalipdepositamount1 = '0.00';
		    $query529 = "select * from master_transactionipdeposit where visitcode='$res2visitcode' order by auto_number desc";
			$exec529 = mysql_query($query529) or die(mysql_error());
			while($res529 = mysql_fetch_array($exec529))
			{
			$res2finalipdepositbilldate1 = $res529['transactiondate'];
			$res2finalipdepositamount1 = $res529['transactionamount'];
			$res2finalipdepositaccountcoa = $res529['coa'];
			$grandfinalipdepositamount1 = $grandfinalipdepositamount1 + $res2finalipdepositamount1;
			}
			
		   $query530 = "select * from master_accountname where id='$res2finalipdepositaccountcoa'";
		   $exec530 = mysql_query($query530) or die(mysql_error());
		   $res530 = mysql_fetch_array($exec530);
		   $res2finalipdepositcoaname = $res530['accountname'];
			
			if($grandfinalipdepositamount1 !='')
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
              <td class="bodytext31" valign="center"  align="left">
			 </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalipdepositbilldate1; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <?php echo $res2finalipdepositcoaname; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalbillnumber1; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandfinalipdepositamount1,2,'.',','); ?></td>
           
           </tr>	   
		   <?php
	}
		   	$grandfinallabamount = 0;
			$resfinallabcoaname6 = '';
			 $query507 = "select * from billing_iplab where billnumber='$res2finalbillnumber1'";
		   $exec507 = mysql_query($query507) or die(mysql_error());
		   while($res507 = mysql_fetch_array($exec507))
		   {
		   $resfinallabdate = $res507['billdate'];
		   $resfinallabamount = $res507['labitemrate'];
		   $resfinallabcoa = $res507['labcoa'];
		   
		   $query508 = "select * from master_accountname where id='$resfinallabcoa'";
		   $exec508 = mysql_query($query508) or die(mysql_error());
		   $res508 = mysql_fetch_array($exec508);
		   $resfinallabcoaname6 = $res508['accountname'];
		   $grandfinallabamount = $grandfinallabamount + $resfinallabamount;
		   }
		   if($resfinallabcoaname6 != '')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resfinallabdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $resfinallabcoaname6; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalbillnumber1; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandfinallabamount,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   
			<?php
			}
			?>
					   <?php
		   	$grandfinalradiologyamount = 0;
			$resfinalradiologycoaname6 = '';
			 $query509 = "select * from billing_ipradiology where billnumber='$res2finalbillnumber1'";
		   $exec509 = mysql_query($query509) or die(mysql_error());
		   while($res509 = mysql_fetch_array($exec509))
		   {
		   $resfinalradiologydate = $res509['billdate'];
		   $resfinalradiologyamount = $res509['radiologyitemrate'];
		   $resfinalradiologycoa = $res509['radiologycoa'];
		   
		   $query510 = "select * from master_accountname where id='$resfinalradiologycoa'";
		   $exec510 = mysql_query($query510) or die(mysql_error());
		   $res510 = mysql_fetch_array($exec510);
		   $resfinalradiologycoaname6 = $res510['accountname'];
		   $grandfinalradiologyamount = $grandfinalradiologyamount + $resfinalradiologyamount;
		   }
		   if($resfinalradiologycoaname6 != '')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resfinalradiologydate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $resfinalradiologycoaname6; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalbillnumber1; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandfinalradiologyamount,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   
			<?php
			}
			?>
							   <?php
		   	$grandfinalservicesamount = 0;
			$resfinalservicescoaname6 = '';
			 $query511 = "select * from billing_ipservices where billnumber='$res2finalbillnumber1'";
		   $exec511 = mysql_query($query511) or die(mysql_error());
		   while($res511 = mysql_fetch_array($exec511))
		   {
		   $resfinalservicesdate = $res511['billdate'];
		   $resfinalservicesamount = $res511['servicesitemrate'];
		   $resfinalservicescoa = $res511['servicecoa'];
		   
		   $query512 = "select * from master_accountname where id='$resfinalservicescoa'";
		   $exec512 = mysql_query($query512) or die(mysql_error());
		   $res512 = mysql_fetch_array($exec512);
		   $resfinalservicescoaname6 = $res512['accountname'];
		   $grandfinalservicesamount = $grandfinalservicesamount + $resfinalservicesamount;
		   }
		   if($resfinalservicescoaname6 != '')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resfinalservicesdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $resfinalservicescoaname6; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalbillnumber1; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandfinalservicesamount,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   
			<?php
			}
			?>
		 <?php
		   	$grandfinalpharmacyamount = 0;
			$resfinalpharmacycoaname6 = '';
			 $query513 = "select * from billing_ippharmacy where billnumber='$res2finalbillnumber1'";
		   $exec513 = mysql_query($query513) or die(mysql_error());
		   while($res513 = mysql_fetch_array($exec513))
		   {
		   $resfinalpharmacydate = $res513['billdate'];
		   $resfinalpharmacyamount = $res513['amount'];
		   $resfinalpharmacycoa = $res513['pharmacycoa'];
		   
		   $query514 = "select * from master_accountname where id='$resfinalpharmacycoa'";
		   $exec514 = mysql_query($query514) or die(mysql_error());
		   $res514 = mysql_fetch_array($exec514);
		   $resfinalpharmacycoaname6 = $res514['accountname'];
		   $grandfinalpharmacyamount = $grandfinalpharmacyamount + $resfinalpharmacyamount;
		   }
		   if($resfinalpharmacycoaname6 != '')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resfinalpharmacydate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $resfinalpharmacycoaname6; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalbillnumber1; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandfinalpharmacyamount,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   
			<?php
			}
			?>
				 <?php
		   	$grandfinalbedchargesamount = 0;
			$resfinalbedchargescoaname6 = '';
			 $query515 = "select * from billing_ipbedcharges where docno='$res2finalbillnumber1'";
		   $exec515 = mysql_query($query515) or die(mysql_error());
		   while($res515 = mysql_fetch_array($exec515))
		   {
		   $resfinalbedchargesdate = $res515['recorddate'];
		   $resfinalbedchargesamount = $res515['amount'];
		   $resfinalbedchargescoa = $res515['coa'];
		   
		   $query516 = "select * from master_accountname where id='$resfinalbedchargescoa'";
		   $exec516 = mysql_query($query516) or die(mysql_error());
		   $res516 = mysql_fetch_array($exec516);
		   $resfinalbedchargescoaname6 = $res516['accountname'];
		   $grandfinalbedchargesamount = $grandfinalbedchargesamount + $resfinalbedchargesamount;
		   }
		   if($resfinalbedchargescoaname6 != '')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resfinalbedchargesdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $resfinalbedchargescoaname6; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalbillnumber1; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandfinalbedchargesamount,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   
			<?php
			}
			?>
						 <?php
		   	$grandfinalprivatedoctoramount = 0;
			$resfinalprivatedoctorcoaname6 = '';
			 $query517 = "select * from billing_ipprivatedoctor where docno='$res2finalbillnumber1'";
		   $exec517 = mysql_query($query517) or die(mysql_error());
		   while($res517 = mysql_fetch_array($exec517))
		   {
		   $resfinalprivatedoctordate = $res517['recorddate'];
		   $resfinalprivatedoctoramount = $res517['amount'];
		   $resfinalprivatedoctorcoa = $res517['coa'];
		   
		   $query518 = "select * from master_accountname where id='$resfinalprivatedoctorcoa'";
		   $exec518 = mysql_query($query518) or die(mysql_error());
		   $res518 = mysql_fetch_array($exec518);
		   $resfinalprivatedoctorcoaname6 = $res518['accountname'];
		   $grandfinalprivatedoctoramount = $grandfinalprivatedoctoramount + $resfinalprivatedoctoramount;
		   }
		   if($resfinalprivatedoctorcoaname6 != '')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resfinalprivatedoctordate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $resfinalprivatedoctorcoaname6; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalbillnumber1; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandfinalprivatedoctoramount,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   
			<?php
			}
			?>
								 <?php
		   	$grandfinalambulanceamount = 0;
			$resfinalambulancecoaname6 = '';
			 $query519 = "select * from billing_ipambulance where docno='$res2finalbillnumber1'";
		   $exec519 = mysql_query($query519) or die(mysql_error());
		   while($res519 = mysql_fetch_array($exec519))
		   {
		   $resfinalambulancedate = $res519['recorddate'];
		   $resfinalambulanceamount = $res519['amount'];
		   $resfinalambulancecoa = $res519['coa'];
		   
		   $query520 = "select * from master_accountname where id='$resfinalambulancecoa'";
		   $exec520 = mysql_query($query520) or die(mysql_error());
		   $res520 = mysql_fetch_array($exec520);
		   $resfinalambulancecoaname6 = $res520['accountname'];
		   $grandfinalambulanceamount = $grandfinalambulanceamount + $resfinalambulanceamount;
		   }
		   if($resfinalambulancecoaname6 != '')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resfinalambulancedate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $resfinalambulancecoaname6; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalbillnumber1; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandfinalambulanceamount,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   
			<?php
			}
			?>
									 <?php
		   	$grandfinalnhifamount = 0;
			$resfinalnhifcoaname6 = '';
			 $query521 = "select * from billing_ipnhif where docno='$res2finalbillnumber1'";
		   $exec521 = mysql_query($query521) or die(mysql_error());
		   while($res521 = mysql_fetch_array($exec521))
		   {
		   $resfinalnhifdate = $res521['recorddate'];
		   $resfinalnhifamount = $res521['amount'];
		   $resfinalnhifcoa = $res521['coa'];
		   
		   $query522 = "select * from master_accountname where id='$resfinalnhifcoa'";
		   $exec522 = mysql_query($query522) or die(mysql_error());
		   $res522 = mysql_fetch_array($exec522);
		   $resfinalnhifcoaname6 = $res522['accountname'];
		   $grandfinalnhifamount = $grandfinalnhifamount + $resfinalnhifamount;
		   }
		   if($resfinalnhifcoaname6 != '')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resfinalnhifdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $resfinalnhifcoaname6; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalbillnumber1; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandfinalnhifamount,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   
			<?php
			}
			?>
			 <?php
		   	$grandfinalotbillingamount = 0;
			$resfinalotbillingcoaname6 = '';
			 $query523 = "select * from billing_ipotbilling where docno='$res2finalbillnumber1'";
		   $exec523 = mysql_query($query523) or die(mysql_error());
		   while($res523 = mysql_fetch_array($exec523))
		   {
		   $resfinalotbillingdate = $res523['recorddate'];
		   $resfinalotbillingamount = $res523['amount'];
		   $resfinalotbillingcoa = $res523['coa'];
		   
		   $query524 = "select * from master_accountname where id='$resfinalotbillingcoa'";
		   $exec524 = mysql_query($query524) or die(mysql_error());
		   $res524 = mysql_fetch_array($exec524);
		   $resfinalotbillingcoaname6 = $res524['accountname'];
		   $grandfinalotbillingamount = $grandfinalotbillingamount + $resfinalotbillingamount;
		   }
		   if($resfinalotbillingcoaname6 != '')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resfinalotbillingdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $resfinalotbillingcoaname6; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalbillnumber1; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandfinalotbillingamount,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   
			<?php
			}
			?>
			<?php
		   	$grandfinalmiscbillingamount = 0;
			$resfinalmiscbillingcoaname6 = '';
			 $query525 = "select * from billing_ipmiscbilling where docno='$res2finalbillnumber1'";
		   $exec525 = mysql_query($query525) or die(mysql_error());
		   while($res525 = mysql_fetch_array($exec525))
		   {
		   $resfinalmiscbillingdate = $res525['recorddate'];
		   $resfinalmiscbillingamount = $res525['amount'];
		   $resfinalmiscbillingcoa = $res525['coa'];
		   
		   $query526 = "select * from master_accountname where id='$resfinalmiscbillingcoa'";
		   $exec526 = mysql_query($query526) or die(mysql_error());
		   $res526 = mysql_fetch_array($exec526);
		   $resfinalmiscbillingcoaname6 = $res526['accountname'];
		   $grandfinalmiscbillingamount = $grandfinalmiscbillingamount + $resfinalmiscbillingamount;
		   }
		   if($resfinalmiscbillingcoaname6 != '')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resfinalmiscbillingdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $resfinalmiscbillingcoaname6; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalbillnumber1; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandfinalmiscbillingamount,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   
			<?php
			}
			?>
			<?php
		   	$grandfinaladmissionchargeamount = 0;
			$resfinaladmissionchargecoaname6 = '';
			 $query527 = "select * from billing_ipadmissioncharge where docno='$res2finalbillnumber1'";
		   $exec527 = mysql_query($query527) or die(mysql_error());
		   while($res527 = mysql_fetch_array($exec527))
		   {
		   $resfinaladmissionchargedate = $res527['recorddate'];
		   $resfinaladmissionchargeamount = $res527['amount'];
		   $resfinaladmissionchargecoa = $res527['coa'];
		   
		   $query528 = "select * from master_accountname where id='$resfinaladmissionchargecoa'";
		   $exec528 = mysql_query($query528) or die(mysql_error());
		   $res528 = mysql_fetch_array($exec528);
		   $resfinaladmissionchargecoaname6 = $res528['accountname'];
		   $grandfinaladmissionchargeamount = $grandfinaladmissionchargeamount + $resfinaladmissionchargeamount;
		   }
		   if($resfinaladmissionchargecoaname6 != '')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resfinaladmissionchargedate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $resfinaladmissionchargecoaname6; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2finalbillnumber1; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandfinaladmissionchargeamount,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   
			<?php
			}
			?>
		   <?php
		   }
		   ?>
		   <?php
			$query8 = "select * from expensesub_details where locationcode ='".$locationcode."' AND transactiondate between '$ADate1' and '$ADate2'";
			$exec8 = mysql_query($query8) or die(mysql_error());
			while($res8 = mysql_fetch_array($exec8))
			{
		   $expensecoa = $res8['expensecoa'];
		   $expenseamount = $res8['transactionamount'];
		   $expensetransactiondate = $res8['transactiondate'];
		   $expensedocno = $res8['docnumber'];
		   $query811 = "select * from master_accountname where id='$expensecoa'";
		   $exec811 = mysql_query($query811) or die(mysql_error());
		   $res811 = mysql_fetch_array($exec811);
		   $resexpensecoaname = $res811['accountname'];
		   
		   if($resexpensecoaname != '')
		   {
		   $snocount = $snocount + 1;
			$sn = $snocount;
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
              <td class="bodytext31" valign="center"  align="left"> <?php echo $sn;  ?> </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $expensetransactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <?php echo $resexpensecoaname; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $expensedocno; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($expenseamount,2,'.',','); ?></td>
           
           </tr>	  
		   <?php
		   }
		   
			
		  $query61 = "select * from paymentmodecredit where billnumber='$expensedocno' and billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec61 = mysql_query($query61) or die ("Error in Query2".mysql_error());
		  while ($res61 = mysql_fetch_array($exec61))
		  {
     	  $res2transactiondate = $res61['billdate'];
		  $res2billnumber = $res61['billnumber'];
		  $cashamount2 = $res61['cash'];
		  $cashcoa =  $res61['cashcoa'];
		  $cardamount2 = $res61['card'];
		  $cardcoa =  $res61['cardcoa'];
		  $chequeamount2 = $res61['cheque'];
		  $chequecoa =  $res61['chequecoa'];
		  $onlineamount2 = $res61['online'];
		  $onlinecoa =  $res61['onlinecoa'];
		  $mpesaamount2 = $res61['mpesa'];
		  $mpesacoa =  $res61['mpesacoa'];
		  $query611 = "select * from master_accountname where id='$cashcoa' or id='$cardcoa' or id='$chequecoa' or id='$onlinecoa' or id='$mpesacoa'";
		  $exec611 = mysql_query($query611) or die(mysql_error());
		  $res611 = mysql_fetch_array($exec611);
		  $accountssub = $res611['accountssub'];
		  
		  $query612 = "select * from master_accountssub where auto_number='$accountssub'";
		  $exec612 = mysql_query($query612) or die(mysql_error());
		  $res612 = mysql_fetch_array($exec612);
		  $accountssubname = $res612['accountssub'];
		 	
		
							if($cashamount2 != '0.00')
	{
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <div class="bodytext31"><?php echo 'CASH'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($cashamount2,2,'.',','); ?> Cr</td>
           
           </tr>
		   <?php
		   }
		   if($chequeamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			 </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <div class="bodytext31"><?php echo 'CHEQUE'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($chequeamount2,2,'.',','); ?> Cr</td>
           
           </tr>
		   <?php
		   }
		   if($cardamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			  
			  </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <div class="bodytext31"><?php echo 'CARD'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($cardamount2,2,'.',','); ?> Cr</td>
           
           </tr>
		   <?php
		   } if($onlineamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			  </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <div class="bodytext31"><?php echo 'ONLINE'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($onlineamount2,2,'.',','); ?> Cr</td>
           
           </tr>
		   <?php
		   }
		   if($mpesaamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			  </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <div class="bodytext31"><?php echo 'MPESA'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($mpesaamount2,2,'.',','); ?> Cr</td>
           
           </tr>
		   <?php
		   }
		  }
		  }
		  $query62 = "select * from paymentmodedebit where locationcode ='".$locationcode."' AND source='receiptentry' and billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec62 = mysql_query($query62) or die ("Error in Query2".mysql_error());
		  while ($res62 = mysql_fetch_array($exec62))
		  {
     	  $res2transactiondate = $res62['billdate'];
		  $res2billnumber = $res62['billnumber'];
		  $cashamount2 = $res62['cash'];
		  $cashcoa =  $res62['cashcoa'];
		  $cardamount2 = $res62['card'];
		  $cardcoa =  $res62['cardcoa'];
		  $chequeamount2 = $res62['cheque'];
		  $chequecoa =  $res62['chequecoa'];
		  $onlineamount2 = $res62['online'];
		  $onlinecoa =  $res62['onlinecoa'];
		  $mpesaamount2 = $res62['mpesa'];
		  $mpesacoa =  $res62['mpesacoa'];
		  
		  $query621 = "select * from master_accountname where id='$cashcoa' or id='$cardcoa' or id='$chequecoa' or id='$onlinecoa' or id='$mpesacoa'";
		  $exec621 = mysql_query($query621) or die(mysql_error());
		  $res621 = mysql_fetch_array($exec621);
		  $accountssub = $res621['accountssub'];
		  
		  $query622 = "select * from master_accountssub where auto_number='$accountssub'";
		  $exec622 = mysql_query($query622) or die(mysql_error());
		  $res622 = mysql_fetch_array($exec622);
		  $accountssubname = $res622['accountssub'];
		 	  $snocount = $snocount + 1;
					if($cashamount2 != '0.00')
	{
		
					
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
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'CASH'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($cashamount2,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   }
		   if($chequeamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			  <?php
			  if($cashamount2 == '0.00')
			  {
			  echo $snocount; 
			  }
			  ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'CHEQUE'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($chequeamount2,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   }
		   if($cardamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			   <?php
			  if(($cashamount2 == '0.00')&&($chequeamount2 == '0.00'))
			  {
			  echo $snocount; 
			  }
			  ?>
			  </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'CARD'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($cardamount2,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   } if($onlineamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			   <?php
			  if(($cashamount2 == '0.00')&&($chequeamount2 == '0.00')&&($cardamount2 == '0.00'))
			  {
			  echo $snocount; 
			  }
			  ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'ONLINE'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($onlineamount2,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   }
		   if($mpesaamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			   <?php
			  if(($cashamount2 == '0.00')&&($chequeamount2 == '0.00')&&($cardamount2 == '0.00')&&($onlineamount2 == '0.00'))
			  {
			  echo $snocount; 
			  }
			  ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'MPESA'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($mpesaamount2,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   }
		   $query63 = "select * from receiptsub_details where docnumber='$res2billnumber'";
		   $exec63 = mysql_query($query63) or die(mysql_error());
		   $res63 = mysql_fetch_array($exec63);
		   $restransactiondate = $res63['transactiondate'];
		   $restransactionamount = $res63['transactionamount'];
		   $resreceiptcoa = $res63['receiptcoa'];
		   
		   $query631 = "select * from master_accountname where id='$resreceiptcoa'";
		   $exec631 = mysql_query($query631) or die(mysql_error());
		   $res631 = mysql_fetch_array($exec631);
		   $resreceiptcoaname = $res631['accountname'];
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $restransactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="center">
                <?php echo $resreceiptcoaname; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($restransactionamount,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   
			<?php
			}
			?>
		  <?php
		   $query64 = "select * from purchase_details where locationcode ='".$locationcode."' AND entrydate between '$ADate1' and '$ADate2' group by billnumber order by auto_number desc";
		   $exec64 = mysql_query($query64) or die(mysql_error());
		   while($res64 = mysql_fetch_array($exec64))
		   {
		   $restransactiondate = $res64['entrydate'];
		   $restransactionamount = $res64['totalamount'];
		   $resgrncoa = $res64['coa'];
		   $resdocno = $res64['billnumber'];
		   
		   $query649 = "select sum(totalamount) as totalamount from purchase_details where billnumber = '$resdocno' and entrydate between '$ADate1' and '$ADate2' group by billnumber order by auto_number desc";
		   $exec649 = mysql_query($query649) or die(mysql_error());
		   $res649 = mysql_fetch_array($exec649);
		   $grandpurchaseamount = $res649['totalamount'];

		   
		   $query641 = "select * from master_accountname where id='$resgrncoa'";
		   $exec641 = mysql_query($query641) or die(mysql_error());
		   $res641 = mysql_fetch_array($exec641);
		   $resgrncoaname = $res641['accountname'];
		   
		   
		   if($resgrncoaname != '')
		   {
		   $snocount = $snocount + 1;
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
                <div class="bodytext31"><?php echo $restransactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <?php echo $resgrncoaname; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resdocno; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandpurchaseamount,2,'.',','); ?> </td>
           
           </tr>	   
		   <?php
		   }
		   	   $query65 = "select * from master_transactionpharmacy where transactionmode='CREDIT' and billnumber='$resdocno' and transactiondate between '$ADate1' and '$ADate2' group by billnumber order by auto_number desc";
		   $exec65 = mysql_query($query65) or die(mysql_error());
		   while($res65 = mysql_fetch_array($exec65))
		   {
		   $restransactiondate = $res65['transactiondate'];
		   $restransactionamount = $res65['transactionamount'];
		   $ressuppliername = $res64['suppliername'];
		   
		   
		 		   if($ressuppliername != '')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $restransactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="center">
                <?php echo $ressuppliername; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resdocno; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($restransactionamount,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   <?php
		   }
		   
		    }
		   }
		   ?>
		   <?php
		  $query72 = "select * from paymentmodedebit where locationcode ='".$locationcode."' AND source='externalbilling' and billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec72 = mysql_query($query72) or die ("Error in Query2".mysql_error());
		  while ($res72 = mysql_fetch_array($exec72))
		  {
     	  $res2transactiondate7 = $res72['billdate'];
		  $res2billnumber7 = $res72['billnumber'];
		  $cashamount74 = $res72['cash'];
		  $cashcoa7 =  $res72['cashcoa'];
		  $cardamount74 = $res72['card'];
		  $cardcoa7 =  $res72['cardcoa'];
		  $chequeamount74 = $res72['cheque'];
		  $chequecoa7 =  $res72['chequecoa'];
		  $onlineamount74 = $res72['online'];
		  $onlinecoa7 =  $res72['onlinecoa'];
		  $mpesaamount74 = $res72['mpesa'];
		  $mpesacoa7 =  $res72['mpesacoa'];
		
		 	 $snocount = $snocount + 1;
					if($cashamount74 != '0.00')
	{
		 
					
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
                <div class="bodytext31"><?php echo $res2transactiondate7; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'CASH'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber7; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($cashamount74,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   }
		   if($chequeamount74 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			    <?php
			  if($cashamount74 == '0.00')
			  {
			  echo $snocount; 
			  }
			  ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate7; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'CHEQUE'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber7; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($chequeamount74,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   }
		   if($cardamount74 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			    <?php
			  if(($cashamount74 == '0.00')&&($chequeamount74 == '0.00'))
			  {
			  echo $snocount; 
			  }
			  ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate7; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'CARD'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber7; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($cardamount74,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   } if($onlineamount74 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			  <?php
			  if(($cashamount74 == '0.00')&&($chequeamount74 == '0.00')&&($cardamount74 == '0.00'))
			  {
			  echo $snocount; 
			  }
			  ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate7; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'ONLINE'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber7; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($onlineamount74,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   }
		   if($mpesaamount74 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			  <?php
			  if(($cashamount74 == '0.00')&&($chequeamount74 == '0.00')&&($cardamount74 == '0.00')&&($onlineamount74 == '0.00'))
			  {
			  echo $snocount; 
			  }
			  ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate7; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo 'MPESA'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber7; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($mpesaamount74,2,'.',','); ?></td>
           
           </tr>
		   <?php
		   }
		   $grandpharmamount7 = 0;
		   $respharmcoaname7 = '';
		   $query874 = "select * from billing_externalpharmacy where billnumber='$res2billnumber7'";
		   $exec874 = mysql_query($query874) or die(mysql_error());
		   while($res874 = mysql_fetch_array($exec874))
		   {
		   $respharmdate = $res874['billdate'];
		   $respharmamount = $res874['amount'];
		   $respharmcoa = $res874['pharmacycoa'];
		 
		   $query8174 = "select * from master_accountname where id='$respharmcoa'";
		   $exec8174 = mysql_query($query8174) or die(mysql_error());
		   $res8174 = mysql_fetch_array($exec8174);
		   $respharmcoaname7 = $res8174['accountname'];
		   $grandpharmamount7 = $grandpharmamount7 + $respharmamount;
		   }
		   if($respharmcoaname7 != '')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $respharmdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $respharmcoaname7; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber7; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandpharmamount7,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   
			<?php
			}
			$grandlabamount7 = 0;
			$reslabcoaname7 = '';
		   $query875 = "select * from billing_externallab where billnumber='$res2billnumber7'";
		   $exec875 = mysql_query($query875) or die(mysql_error());
		   while($res875 = mysql_fetch_array($exec875))
		   {
		   $reslabdate = $res875['billdate'];
		   $reslabamount = $res875['labitemrate'];
		   $reslabcoa = $res875['labcoa'];
		   
		   $query8175 = "select * from master_accountname where id='$reslabcoa'";
		   $exec8175 = mysql_query($query8175) or die(mysql_error());
		   $res8175 = mysql_fetch_array($exec8175);
		   $reslabcoaname7 = $res8175['accountname'];
		   $grandlabamount7 = $grandlabamount7 + $reslabamount;
		   }
		   if($reslabcoaname7 != '')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $reslabdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $reslabcoaname7; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber7; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandlabamount7,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   
			<?php
			}
			$grandradiologyamount7 = 0;
			$resradiologycoaname7 = '';
		   $query876 = "select * from billing_externalradiology where billnumber='$res2billnumber7'";
		   $exec876 = mysql_query($query876) or die(mysql_error());
		   while($res876 = mysql_fetch_array($exec876))
		   {
		   $resradiologydate = $res876['billdate'];
		   $resradiologyamount = $res876['radiologyitemrate'];
		   $resradiologycoa = $res876['radiologycoa'];
		   
		   $query8176 = "select * from master_accountname where id='$resradiologycoa'";
		   $exec8176 = mysql_query($query8176) or die(mysql_error());
		   $res8176 = mysql_fetch_array($exec8176);
		   $resradiologycoaname7 = $res8176['accountname'];
		    $grandradiologyamount7 = $grandradiologyamount7 + $resradiologyamount;
		   }
		   if($resradiologycoaname7 != '')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resradiologydate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $resradiologycoaname7; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber7; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandradiologyamount7,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   
			<?php
			}
			$grandservicesamount7 = 0;
			$resservicescoaname7 = '';
			 $query877 = "select * from billing_externalservices where billnumber='$res2billnumber7'";
		   $exec877 = mysql_query($query877) or die(mysql_error());
		   while($res877 = mysql_fetch_array($exec877))
		   {
		   $resservicesdate = $res877['billdate'];
		   $resservicesamount = $res877['servicesitemrate'];
		   $resservicescoa = $res877['servicecoa'];
		   
		   $query8177 = "select * from master_accountname where id='$resservicescoa'";
		   $exec8177 = mysql_query($query8177) or die(mysql_error());
		   $res8177 = mysql_fetch_array($exec8177);
		   $resservicescoaname7 = $res8177['accountname'];
		   $grandservicesamount7 = $grandservicesamount7 + $resservicesamount;
		   }
		   if($resservicescoaname7 != '')
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resservicesdate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $resservicescoaname7; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber7; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($grandservicesamount7,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   
			<?php
			}
			
			}
			?>
			<?php
		   $query69 = "select * from purchasereturn_details where locationcode ='".$locationcode."' AND entrydate between '$ADate1' and '$ADate2' group by billnumber order by auto_number desc";
		   $exec69 = mysql_query($query69) or die(mysql_error());
		   while($res69 = mysql_fetch_array($exec69))
		   {
		   $restransactiondate = $res69['entrydate'];
		   $restransactionamount = $res69['totalamount'];
		   $resgrtcoa = $res69['grtcoa'];
		   $resdocno = $res69['billnumber'];
		   $ressuppliername = $res69['suppliername'];
		   
		   $query691 = "select * from master_accountname where id='$resgrtcoa'";
		   $exec691 = mysql_query($query691) or die(mysql_error());
		   $res691 = mysql_fetch_array($exec691);
		   $resgrtcoaname = $res691['accountname'];
		   
		   
		   if($resgrtcoaname != '')
		   {
		   $snocount = $snocount + 1;
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
                <div class="bodytext31"><?php echo $restransactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <?php echo $ressuppliername; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resdocno; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($restransactionamount,2,'.',','); ?> </td>
           
           </tr>	   
		   <?php
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $restransactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <?php echo $resgrtcoaname; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $resdocno; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($restransactionamount,2,'.',','); ?> Cr</td>
           
           </tr>	   
		   <?php
		   }
		   }
			?>
			<?php
			
			 $query61 = "select * from deposit_refund where locationcode ='".$locationcode."' AND recorddate between '$ADate1' and '$ADate2' order by auto_number desc";
		   $exec61 = mysql_query($query61) or die(mysql_error());
		   while($res61 = mysql_fetch_array($exec61))
		   {
		   $resdepositrefunddate = $res61['recorddate'];
		   $resdepositrefundamount = $res61['amount'];
		   $resdepositrefundcoa = $res61['coa'];
		   $res2depositrefundbillnumber = $res61['docno'];
		    $resdepositrefundcoaname = $res61['accountname'];
		   $colorloopcount = $colorloopcount + 1;
		     $snocount = $snocount + 1;
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
                <div class="bodytext31"><?php echo $resdepositrefunddate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <?php echo $resdepositrefundcoaname; ?></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2depositrefundbillnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($resdepositrefundamount,2,'.',','); ?> </td>
           
           </tr>	   
		   
			<?php
			
			 $query822 = "select * from paymentmodecredit where source='ipdepositrefund' and billnumber='$res2depositrefundbillnumber' and billdate between '$ADate1' and '$ADate2' order by auto_number desc";
		  $exec822 = mysql_query($query822) or die ("Error in Query2".mysql_error());
		  while ($res822 = mysql_fetch_array($exec822))
		  {
     	  $res2transactiondate = $res822['billdate'];
		  $res2billnumber = $res822['billnumber'];
		  $cashamount2 = $res822['cash'];
		  $cashcoa =  $res822['cashcoa'];
		  $cardamount2 = $res822['card'];
		  $cardcoa =  $res822['cardcoa'];
		  $chequeamount2 = $res822['cheque'];
		  $chequecoa =  $res822['chequecoa'];
		  $onlineamount2 = $res822['online'];
		  $onlinecoa =  $res822['onlinecoa'];
		  $mpesaamount2 = $res822['mpesa'];
		  $mpesacoa =  $res822['mpesacoa'];
		  $query823 = "select * from master_accountname where id='$cashcoa' or id='$cardcoa' or id='$chequecoa' or id='$onlinecoa' or id='$mpesacoa'";
		  $exec823 = mysql_query($query823) or die(mysql_error());
		  $res823 = mysql_fetch_array($exec823);
		  $accountssub = $res823['accountssub'];
		  
		  $query824 = "select * from master_accountssub where auto_number='$accountssub'";
		  $exec824 = mysql_query($query824) or die(mysql_error());
		  $res824 = mysql_fetch_array($exec824);
		  $accountssubname = $res824['accountssub'];
		 	
		
							if($cashamount2 != '0.00')
	{
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
              <td class="bodytext31" valign="center"  align="left"></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <div class="bodytext31"><?php echo 'CASH'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($cashamount2,2,'.',','); ?> Cr</td>
           
           </tr>
		   <?php
		   }
		   if($chequeamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			 </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <div class="bodytext31"><?php echo 'CHEQUE'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($chequeamount2,2,'.',','); ?> Cr</td>
           
           </tr>
		   <?php
		   }
		   if($cardamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			  
			  </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <div class="bodytext31"><?php echo 'CARD'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($cardamount2,2,'.',','); ?> Cr</td>
           
           </tr>
		   <?php
		   } if($onlineamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			  </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <div class="bodytext31"><?php echo 'ONLINE'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($onlineamount2,2,'.',','); ?> Cr</td>
           
           </tr>
		   <?php
		   }
		   if($mpesaamount2 != '0.00')
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
              <td class="bodytext31" valign="center"  align="left">
			  </td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2transactiondate; ?></div></td>
              <td class="bodytext31" valign="center"  align="left" style="padding-left:40px;">
                <div class="bodytext31"><?php echo 'MPESA'; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billnumber; ?></div></td>
            
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($mpesaamount2,2,'.',','); ?> Cr</td>
           
           </tr>
		   <?php
		   }
		  }
		  }
			?>
   		  </tbody>
        </table></td>
      </tr>
			<?php
			}
			?>
         
</table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
