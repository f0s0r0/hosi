<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d');
$paymentreceiveddateto = date('Y-m-d');

$searchsuppliername = '';
$suppliername = '';
$cbsuppliername = '';
$cbcustomername = '';
$cbbillnumber = '';
$cbbillstatus = '';
$colorloopcount = '';
$sno = '';
$snocount = '';
$visitcode1 = '';
$total = '0.00';
$looptotalpaidamount = '0.00';
$looptotalpendingamount = '0.00';
$looptotalwriteoffamount = '0.00';
$looptotalcashamount = '0.00';
$looptotalcreditamount = '0.00';
$looptotalcardamount = '0.00';
$looptotalonlineamount = '0.00';
$looptotalchequeamount = '0.00';
$looptotaltdsamount = '0.00';
$looptotalwriteoffamount = '0.00';
$pendingamount = '0.00';
$accountname = '';

if (isset($_REQUEST["accountname"])) { $accountname = $_REQUEST["accountname"]; } else { $accountname = ""; }
 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
$locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	//$cbsuppliername = $_REQUEST['cbsuppliername'];
	//$suppliername = $_REQUEST['cbsuppliername'];
	$paymentreceiveddatefrom = $_REQUEST['ADate1'];
	$paymentreceiveddateto = $_REQUEST['ADate2'];
	

}


if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//$paymenttype = $_REQUEST['paymenttype'];
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//$billstatus = $_REQUEST['billstatus'];


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
<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>

</head>

<script src="js/datetimepicker_css.js"></script>

<body>
<table width="1900" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="9" bgcolor="#6487DC"><?php include ("includes/alertmessages1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#8CAAE6"><?php include ("includes/title1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9" bgcolor="#E0E0E0"><?php include ("includes/menu1.php"); ?></td>
  </tr>
  <tr>
    <td colspan="9">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="99%" valign="top"><table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
		
              <form name="cbform1" method="post" action="opiprevenuereport.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr bgcolor="#011E6A">
                      <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>OP/IP Revenue Report </strong></td>
                      <!--<td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
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
                bgcolor="#FFFFFF"> <strong>Date From</strong> </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><strong> Date To</strong> </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>
					<tr>
  			  <td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
			 
				 <select name="location" id="location" onChange="ajaxlocationfunction(this.value);">
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
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input  type="submit" value="Search" name="Submit" />
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="600" 
            align="left" border="0">
          <tbody>
            <tr>
			  <td colspan="3" bgcolor="#cccccc" class="bodytext31" align="center"><strong>OP Revenue</strong></td>
              <td width="10%"  class="bodytext31">&nbsp;</td>
              <td colspan="3" bgcolor="#cccccc" class="bodytext31" align="center"><span class="bodytext311"><strong>IP Revenue</strong>
              
 				
              
              <!--<input  value="Print Report" onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" />
&nbsp;				<input  value="Export Excel" onClick="javascript:printbillreport2()" name="resetbutton22" type="button" id="resetbutton22"  style="border: 1px solid #001E6A" />-->
</span></td>
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td width="20%" align="left" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Description </strong></div></td>
              <td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="style1">Amount</td>
				<td width="10%" align="left" valign="center"  
                 class="style1" bgcolor="#E0E0E0">&nbsp;</td>
              <td align="left" valign="center"  
                bgcolor="#ffffff" class="style1">No.</td>
              <td width="20%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Description</strong></div></td>  
			  <td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Amount</strong></div></td>  
            </tr>
			<?php
			
			
		    if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
		  if ($cbfrmflag1 == 'cbfrmflag1')
		  {
			
			$query1 = "select sum(billamount) as billamount1 from master_billing where locationcode='$locationcode1' and billingdatetime between '$ADate1' and '$ADate2'";
			$exec1 = mysql_query($query1) or die ("Error in query1".mysql_error());
			$res1 = mysql_fetch_array($exec1);
			$res1consultationamount = $res1['billamount1'];
			
			$query2 = "select sum(amount) from billing_ipadmissioncharge where locationcode='$locationcode1' and recorddate between '$ADate1' and '$ADate2' ";
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			$num2=mysql_num_rows($exec2);
			$res2 = mysql_fetch_array($exec2);
			$totalipadmissionamount =$res2['sum(amount)'];
			
			$query3 = "select sum(packagecharge) as packagecharge from master_ipvisitentry where locationcode='$locationcode1' and consultationdate between '$ADate1' and '$ADate2' ";
			$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
			$num3=mysql_num_rows($exec3);
			$res3 = mysql_fetch_array($exec3);
			$totalippackageamount =$res3['packagecharge'];
			
			$query4 = "select sum(amount) from billing_ipbedcharges where locationcode='$locationcode1' and description='bed charges' and recorddate between '$ADate1' and '$ADate2' ";
			$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
			$num4 = mysql_num_rows($exec4);
			$res4 = mysql_fetch_array($exec4);
			$totalbedcharges =$res4['sum(amount)'];
			
			$totalhospitalrevenue = $totalbedcharges + $totalippackageamount + $totalipadmissionamount;
			
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
                <div class="bodytext31">Consultation</div>              </td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($res1consultationamount,2,'.',','); ?></div>              </td>
              <td class="bodytext31" valign="center"  align="left" bgcolor="#E0E0E0">&nbsp;
			  </td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $snocount; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="left">Hospital Revenue</div></td>
				<td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($totalhospitalrevenue,2,'.',','); ?></div></td>
           </tr>
		      <?php
		  	$query5 = "select sum(amount) as pharmamount from billing_paylaterpharmacy where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'";
			$exec5 = mysql_query($query5) or die ("Error in query5".mysql_error());
			$res5 = mysql_fetch_array($exec5);
			$res5lpharmamount = $res5['pharmamount'];
			
			$query6 = "select sum(amount) as pharmamount from billing_paynowpharmacy where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'";
			$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
			$res6 = mysql_fetch_array($exec6);
			$res6lpharmamount = $res6['pharmamount'];
			
			$query7 = "select sum(amount) as pharmamount from billing_externalpharmacy where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'";
			$exec7 = mysql_query($query7) or die ("Error in query7".mysql_error());
			$res7 = mysql_fetch_array($exec7);
			$res7lpharmamount = $res7['pharmamount'];
			
			$totalpharmamount = $res5lpharmamount + $res6lpharmamount + $res7lpharmamount;
			
			$query8 = "select sum(amount) as pharmamount from billing_ippharmacy where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'";
			$exec8 = mysql_query($query8) or die ("Error in query8".mysql_error());
			$res8 = mysql_fetch_array($exec8);
			$res8pharmamount= $res8['pharmamount'];
		   ?>
		   <tr bgcolor="#CBDBFA">
              <td class="bodytext31" valign="center"  align="left"><?php echo ++$snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">Pharmacy</div>              </td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($totalpharmamount,2,'.',','); ?></div>              </td>
              <td class="bodytext31" valign="center"  align="left" bgcolor="#E0E0E0">&nbsp;
			  </td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $snocount; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="left">Pharmacy</div></td>
				<td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($res8pharmamount,2,'.',','); ?></div></td>
           </tr>
		   <?php
		  	$query5 = "select sum(labitemrate) as labitemrate1 from billing_paylaterlab where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'";
			$exec5 = mysql_query($query5) or die ("Error in query5".mysql_error());
			$res5 = mysql_fetch_array($exec5);
			$res5labitemrate = $res5['labitemrate1'];
			
			$query6 = "select sum(labitemrate) as labitemrate1 from billing_paynowlab where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'";
			$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
			$res6 = mysql_fetch_array($exec6);
			$res6labitemrate = $res6['labitemrate1'];
			
			$query7 = "select sum(labitemrate) as labitemrate1 from billing_externallab where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'";
			$exec7 = mysql_query($query7) or die ("Error in query7".mysql_error());
			$res7 = mysql_fetch_array($exec7);
			$res7labitemrate = $res7['labitemrate1'];
			
			$totallabitemrate = $res5labitemrate + $res6labitemrate + $res7labitemrate;
			
			$query8 = "select sum(labitemrate) as labitemrate1 from billing_iplab where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'";
			$exec8 = mysql_query($query8) or die ("Error in query8".mysql_error());
			$res8 = mysql_fetch_array($exec8);
			$res8labitemrate = $res8['labitemrate1'];
		   ?>
		   <tr bgcolor="#CBDBFA">
              <td class="bodytext31" valign="center"  align="left"><?php echo ++$snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">Laboratory</div>              </td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($totallabitemrate,2,'.',','); ?></div>              </td>
              <td class="bodytext31" valign="center"  align="left" bgcolor="#E0E0E0">&nbsp;
			  </td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $snocount; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="left">Laboratory</div></td>
				<td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($res8labitemrate,2,'.',','); ?></div></td>
           </tr>
		   <?php 
		    $query9 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_paylaterradiology  where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'";
			$exec9 = mysql_query($query9) or die ("Error in query9".mysql_error());
			$res9 = mysql_fetch_array($exec9);
			$res9radiologyitemrate = $res9['radiologyitemrate1'];
			
			$query10 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_paynowradiology where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'";
			$exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());
			$res10 = mysql_fetch_array($exec10);
			$res10radiologyitemrate = $res10['radiologyitemrate1'];
			
			$query11 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_externalradiology where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'";
			$exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
			$res11 = mysql_fetch_array($exec11);
			$res11radiologyitemrate = $res11['radiologyitemrate1'];
			
			$totalradiologyitemrate = $res9radiologyitemrate + $res10radiologyitemrate + $res11radiologyitemrate;
			
			$query12 = "select sum(radiologyitemrate) as radiologyitemrate1 from billing_ipradiology where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'";
			$exec12 = mysql_query($query12) or die ("Error in query12".mysql_error());
			$res12 = mysql_fetch_array($exec12);
			$res12radiologyitemrate = $res12['radiologyitemrate1'];
		   ?>
		   <tr bgcolor="#D3EEB7">
              <td class="bodytext31" valign="center"  align="left"><?php echo ++$snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">Radiology</div>              </td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($totalradiologyitemrate,2,'.',','); ?></div>              </td>
              <td class="bodytext31" valign="center"  align="left" bgcolor="#E0E0E0">&nbsp;
			  </td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $snocount; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="left">Radiology</div></td>
				<td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($res12radiologyitemrate,2,'.',','); ?></div></td>
           </tr>
		   <?php 
		    $query13 = "select sum(servicesitemrate) as servicesitemrate1 from billing_paylaterservices where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'";
			$exec13 = mysql_query($query13) or die ("Error in query13".mysql_error());
			$res13 = mysql_fetch_array($exec13);
			$res13servicesitemrate = $res13['servicesitemrate1'];
			
			$query14 = "select sum(servicesitemrate) as servicesitemrate1 from billing_paynowservices where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'";
			$exec14 = mysql_query($query14) or die ("Error in Query14".mysql_error());
			$res14 = mysql_fetch_array($exec14);
			$res14servicesitemrate = $res14['servicesitemrate1'];
			
			$query15 = "select sum(servicesitemrate) as servicesitemrate1 from billing_externalservices where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'";
			$exec15 = mysql_query($query15) or die ("Error in Query15".mysql_error());
			$res15 = mysql_fetch_array($exec15);
			$res15servicesitemrate = $res15['servicesitemrate1'];
			
			$totalservicesitemrate = $res13servicesitemrate + $res14servicesitemrate + $res15servicesitemrate ;
			
			$query16 = "select sum(servicesitemrate) as servicesitemrate1 from billing_ipservices where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'";
			$exec16 = mysql_query($query16) or die ("Error in Query16".mysql_error());
			$res16 = mysql_fetch_array($exec16);
			$res16servicesitemrate = $res16['servicesitemrate1'];
		   ?>
		   <tr bgcolor="#CBDBFA">
              <td class="bodytext31" valign="center"  align="left"><?php echo ++$snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">Services</div>              </td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($totalservicesitemrate,2,'.',','); ?></div>              </td>
              <td class="bodytext31" valign="center"  align="right" bgcolor="#E0E0E0">&nbsp;
			  </td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $snocount; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
			    <div align="left">Services</div></td>
				<td class="bodytext31" valign="center"  align="right">
			    <div align="right"><?php echo number_format($res16servicesitemrate,2,'.',','); ?></div></td>
           </tr>
		   <?php
		    $query17 = "select sum(referalrate) as referalrate1 from billing_paylaterreferal where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'";
			$exec17 = mysql_query($query17) or die ("Error in query17".mysql_error());
			$res17 = mysql_fetch_array($exec17);
			$res17referalitemrate = $res17['referalrate1'];
			
			$query18 = "select sum(referalrate) as referalrate1 from billing_paynowreferal where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'";
			$exec18 = mysql_query($query18) or die ("Error in Query18".mysql_error());
			$res18 = mysql_fetch_array($exec18);
			$res18referalitemrate = $res18['referalrate1'];
			
			$totalreferalitemrate = $res17referalitemrate + $res18referalitemrate;
			$totaliprevenue = $totalhospitalrevenue + $res8labitemrate + $res12radiologyitemrate + $res16servicesitemrate;
		   ?>
		   <tr bgcolor="#D3EEB7">
              <td class="bodytext31" valign="center"  align="left"><?php echo ++$snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31">Referal</div>              </td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><?php echo number_format($totalreferalitemrate,2,'.',','); ?></div>              </td>
              <td class="bodytext31" valign="center"  align="left" bgcolor="#E0E0E0">&nbsp;
			  </td>
              <td class="bodytext31" valign="center"  align="left" bgcolor="#CCCCCC">
			    <div align="left"></div></td>
               <td class="bodytext31" valign="center"  align="left" bgcolor="#CCCCCC">
			    <div align="left"><strong>Total</strong></div></td>
				<td class="bodytext31" valign="center"  align="right" bgcolor="#CCCCCC">
			    <div align="right"><strong><?php echo number_format($totaliprevenue,2,'.',','); ?></strong></div></td>
           </tr>
		   <?php 
		   $totaloprevenue = $res1consultationamount + $totallabitemrate + $totalradiologyitemrate + $totalservicesitemrate + $totalreferalitemrate + $totalpharmamount;
		   $totalrevenue = $totaliprevenue + $totaloprevenue;
		   if($totalrevenue!=0)
		   {
		   $oppercent = $totaloprevenue / $totalrevenue* 100;
		   $ippercent = $totaliprevenue / $totalrevenue* 100;
		   }
		   else
		   {
		  $oppercent = $totaloprevenue;
		  $ippercent = $totaliprevenue;
		   }
		  
		   ?>
		   <tr bgcolor="#D3EEB7">
              <td class="bodytext31" valign="center"  align="left" bgcolor="#CCCCCC">&nbsp;</td>
               <td class="bodytext31" valign="center"  align="left" bgcolor="#CCCCCC">
                <div class="bodytext31"><strong>Total</strong></div>              </td>
              <td class="bodytext31" valign="center"  align="right" bgcolor="#CCCCCC">
                <div class="bodytext31"><strong><?php echo number_format($totaloprevenue,2,'.',','); ?></strong></div>              </td>
              
           </tr>
		   
		   <tr>
             
               <td class="bodytext31" valign="center"  align="left" colspan="2">
                <div class="bodytext31"><strong></strong></div>              </td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><strong>&nbsp;</strong></div>              </td>
              
           </tr>
		   
		   <tr>
             
               <td class="bodytext31" valign="center"  align="left" colspan="2">
                <div class="bodytext31"><strong>Total Revenue</strong></div>              </td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><strong><?php echo number_format($totalrevenue,2,'.',','); ?></strong></div>              </td>
              
           </tr>
		   <tr>
             
               <td class="bodytext31" valign="center"  align="left" colspan="2">
                <div class="bodytext31"><strong>OP %</strong></div>              </td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><strong><?php echo number_format($oppercent,2,'.',',').'%'; ?></strong></div>              </td>
              
           </tr>
		    <tr>
             
               <td class="bodytext31" valign="center"  align="left" colspan="2">
                <div class="bodytext31"><strong>IP %</strong></div>              </td>
              <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><strong><?php echo number_format($ippercent,2,'.',',').'%'; ?></strong></div>              </td>
              
           </tr>
			<?php
			
			}
			
			?>
            
          </tbody>
        </table></td>
      </tr>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

