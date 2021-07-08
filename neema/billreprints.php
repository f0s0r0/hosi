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

$colorloopcount = '';
$sno = '';
$snocount = '';

 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
 $locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';
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

if (isset($_REQUEST["billtype"])) { $billtype = $_REQUEST["billtype"]; } else { $billtype = ""; }
if (isset($_REQUEST["searchpatient"])) { $searchpatient = $_REQUEST["searchpatient"]; } else { $searchpatient = ""; }
if (isset($_REQUEST["searchpatientcode"])) { $searchpatientcode = $_REQUEST["searchpatientcode"]; } else { $searchpatientcode = ""; }
if (isset($_REQUEST["searchvisitcode"])) { $searchvisitcode = $_REQUEST["searchvisitcode"]; } else { $searchvisitcode = ""; }

if (isset($_REQUEST["billnumber"])) { $billnumber = $_REQUEST["billnumber"]; } else { $billnumber = ""; }

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//$paymenttype = $_REQUEST['paymenttype'];
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//$billstatus = $_REQUEST['billstatus'];
if ($ADate1 != '' && $ADate2 != '')
{
	$transactiondatefrom = $_REQUEST['ADate1'];
	$transactiondateto = $_REQUEST['ADate2'];
}
else
{
	$transactiondatefrom = date('Y-m-d');
	$transactiondateto = date('Y-m-d');
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



function funcBill()
{
if((document.getElementById("billtype").value == "")||(document.getElementById("billtype").value == " "))
{
alert('Please Select Bill');
return false;
}
}
</script>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>

<style type="text/css">
<!--
.bodytext31 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration:none
}
.bodytext311 {FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma
}
.style3 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>
</head>
<script>
function myFunction()
{
	if(document.getElementById("billtype").value == '')
	{
	alert("Please Select Deposit Type");
	document.getElementById("billtype").focus();
	return false;
	}
}
</script>

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
    <td width="99%" valign="top">
    <table width="116%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="860">
		
              <form name="cbform1" method="post" action="billreprints.php">
                <table width="815" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr bgcolor="#011E6A">
                      <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Bill Reprints </strong></td>
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
                bgcolor="#FFFFFF">Select</td>
                      <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><strong>
                        <select name="billtype" id="billtype" >
                          <option value="">Select Bill</option>
                          <option value="1" >Consultation</option>
						  <option value="2" >Bill Paynow</option>
						  <option value="3" >Paynow Refund</option>
						  <option value="4" >Consultation Refund</option>
						  <option value="5" >External Bill</option>
						  <option value="6" >Advance Deposit</option>
						  <option value="7" >IP Deposit</option>
						  <option value="8" >IP Final</option> 
						  <option value="9" >Bill Paylater</option> 
                          <option value="16" >OP Credit</option>
						  <option value="10" >IP Credit Approved</option>
						  <option value="11" >IP Receipts</option>
						  <option value="12" >Sick Leave</option>
						  <option value="13" >Discharge Summary</option>
						  <option value="14" >Manual LPO</option>
						  <option value="15" >Misc Receipt</option>
						  <option value="17" >IP Credit Note</option>
						  <option value="18" >IP Debit Note</option>
                          <option value="19" >Pharmacy Credit</option>
                          <option value="20" >Bulk Debit</option>
                          <option value="21" >Bulk Credit</option>
						  <option value="22" >Mortuary Bill</option>
                          <option value="23" >External Mortuary Deposit</option>
                          <option value="24" >External Mortuary Services</option>
						  <option value="25" >Account Receivable</option>
						  <option value="26" >Supplier Payment</option>
						  <option value="27" >Payroll Payment</option>
						  <option value="28" >Purchase Invoice Entry</option>
                        </select>
                      </strong></td>
                      <td align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31">&nbsp;</td>
                      <td align="left" valign="center"  bgcolor="#FFFFFF">&nbsp;</td>
                    </tr>
					 <tr>
                      <td class="bodytext31" valign="center"  align="left" 
               		 bgcolor="#FFFFFF"> Patient Name </td>
                      <td colspan="3" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input type="text" name="searchpatient" id="searchpatient" value="<?php echo $searchpatient; ?>" size="50" /></td>
                    </tr>
					<tr>
                      <td class="bodytext31" valign="center"  align="left" 
               		 bgcolor="#FFFFFF"> Patient Code </td>
                      <td colspan="3" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input type="text" name="searchpatientcode" id="searchpatientcode" value="<?php echo $searchpatientcode; ?>" size="50" /></td>
                    </tr>
					<tr>
                      <td class="bodytext31" valign="center"  align="left" 
               		 bgcolor="#FFFFFF"> Visit Code </td>
					 
                      <td colspan="3" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input type="text" name="searchvisitcode" id="searchvisitcode" value="<?php echo $searchvisitcode; ?>" size="50" /></td>
                    </tr>
					
					<tr>
                      <td class="bodytext31" valign="center"  align="left" 
               		 bgcolor="#FFFFFF"> Bill Number </td>
					 
                      <td colspan="3" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input type="text" name="billnumber" id="billnumber" value="<?php echo $billnumber; ?>" size="50" /></td>
                    </tr>
					
					
                    <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>
					<tr>
  			  <td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
			 
				 <select name="location" id="location" onChange="ajaxlocationfunction(this.value);">
                    <?php
						
						$query1 = "select * from master_employeelocation where username='$username' group by locationcode order by locationcode";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						$loccode=array();
						while ($res1 = mysql_fetch_array($exec1))
						{
						$locationname = $res1["locationname"];
						$locationcode = $res1["locationcode"];
						
						?>
						 <option value="<?php echo $locationcode; ?>" <?php if($location!='')if($location==$locationcode){echo "selected";}?>><?php echo strtoupper($locationname); ?></option>
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
                          <input  type="submit" onClick= "return funcBill();" value="Search" name="Submit" />
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1052" 
            align="left" border="0">
          <tbody>
			<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				?>
			<?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 1)
				{
			$query1 = "select * from billing_consultation where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billnumber like '%$billnumber%' and locationcode='$locationcode1' and billdate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec1 = mysql_query($query1) or die ("Error in query1".mysql_error());	
			$num1 = mysql_num_rows($exec1);
			 ?> 	
			<tr>
				<td colspan="9" bgcolor="#cccccc" class="style3">Consultation Bills <?php echo '('.$num1.')'; ?> </td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit No</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">User</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              <td width="7%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">&nbsp;</td>
            </tr>
             
            <?php
			$query1 = "select * from billing_consultation where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billnumber like '%$billnumber%' and  locationcode='$locationcode1' and billdate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec1 = mysql_query($query1) or die ("Error in query1".mysql_error());
			while($res1 = mysql_fetch_array($exec1))
			 {
			$res1patientcode= $res1['patientcode'];
			$res1patientvisitcode= $res1['patientvisitcode'];
			$res1billdate= $res1['billdate'];
			$res1patientname= $res1['patientname'];
			$res1billnumber= $res1['billnumber'];
			$res1username= $res1['username'];
			
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1billdate; ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res1billnumber; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res1patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res1username); ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_consultationbill_dmp4inch1.php?locationcode=<?php echo $locationcode1; ?>&&billautonumber=<?php echo $res1billnumber; ?>"><strong>Print</strong></a></td>
               <td class="bodytext31" valign="center"  align="left"><?php //echo $res2department; ?></td>
               </tr>
		   <?php } } ?>
		    
			<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				?>
			<?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 2)
				{
			$query2 = "select * from billing_paynow where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billno like '%$billnumber%' and locationcode='$locationcode1' and billdate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec2 = mysql_query($query2) or die ("Error in query2".mysql_error()); 	
		    $num2 = mysql_num_rows($exec2);
			 ?> 	
			<tr>
				<td colspan="9" bgcolor="#cccccc" class="style3">Bill Paynow <?php echo '('.$num2.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit No</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">User</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              <td width="7%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">&nbsp;</td>
            </tr>
		   
		   <?php
			$query2 = "select * from billing_paynow where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billno like '%$billnumber%' and locationcode='$locationcode1' and billdate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec2 = mysql_query($query2) or die ("Error in query2".mysql_error());
			while($res2 = mysql_fetch_array($exec2))
			 {
			$res2patientcode= $res2['patientcode'];
			$res2patientvisitcode= $res2['visitcode'];
			$res2billdate= $res2['billdate'];
			$res2patientname= $res2['patientname'];
			$res2billnumber= $res2['billno'];
			$res2username= $res2['username'];
			
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
			//checking for copay
			$query17 = "select * from master_visitentry where visitcode='$res2patientvisitcode' and patientcode='$res2patientcode'";
			$exec17 = mysql_query($query17) or die ("Error in Query1".mysql_error());
			$res17 = mysql_fetch_array($exec17);
			//$consultationfee=$res17['consultationfees'];
			//$consultationfee = number_format($consultationfee,2,'.','');
			//$viscode=$res17['visitcode'];
			//$consultationdate=$res17['consultationdate'];
			//$plannumber = $res17['planname'];
			 $planpercentage = $res17['planpercentage'];
			
			/*$queryplanname = "select forall from master_planname where auto_number ='".$plannumber."' ";// and (billingdatetime between '$triagedatefrom' and '$triagedateto')";//
			$execplanname = mysql_query($queryplanname) or die ("Error in Queryplanname".mysql_error());
			$resplanname = mysql_fetch_array($execplanname);
		 	$planforall = $resplanname['forall'];*/
			?>
            
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res2billdate; ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res2billnumber; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res2patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res2patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res2patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res2username); ?></td>
               <td class="bodytext31" valign="center"  align="left">
               <?php if($planpercentage==0){?>
               <a target="_blank" href="print_billpaynowbill_dmp4inch1.php?locationcode=<?php echo $locationcode1; ?>&&billautonumber=<?php echo $res2billnumber; ?>&&patientcode=<?php echo $res2patientcode; ?>"><strong>Bill Paynow</strong></a></td>
               
               <?php } else {?>
			    <a target="_blank" href="print_billpaynowbill_dmp4inch_copay.php?locationcode=<?php echo $locationcode1; ?>&&billautonumber=<?php echo $res2billnumber; ?>&&patientcode=<?php echo $res2patientcode; ?>"><strong>Bill Paynow</strong></a></td>
			   <?php }?>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_paynowsummary.php?locationcode=<?php echo $locationcode1; ?>&&patientcode=<?php echo $res2patientcode; ?>&&visitcode=<?php echo $res2patientvisitcode; ?>&&billautonumber=<?php echo $res2billnumber; ?>"><strong>Summary</strong></a></td>
               </tr>
		   <?php } } ?>
		   
		   <?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				?>
			<?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 3)
				{
					
			$query3 = "select * from refund_paynow where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billnumber like '%$billnumber%'  and locationcode='$locationcode1' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec3 = mysql_query($query3) or die ("Error in query3".mysql_error());
		    $num3 = mysql_num_rows($exec3);
			 ?> 	
			<tr>
				<td colspan="9" bgcolor="#cccccc" class="style3">Paynow  Refund <?php echo '('.$num3.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit No</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">User</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              <td width="7%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">&nbsp;</td>
            </tr>
		   
		   <?php
			$query3 = "select * from refund_paynow where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billnumber like '%$billnumber%' and locationcode='$locationcode1' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec3 = mysql_query($query3) or die ("Error in query3".mysql_error());
			while($res3 = mysql_fetch_array($exec3))
			 {
			$res3patientcode= $res3['patientcode'];
			$res3patientvisitcode= $res3['visitcode'];
			$res3billdate= $res3['transactiondate'];
			$res3patientname= $res3['patientname'];
			$res3billnumber= $res3['billnumber'];
			$res3username= $res3['username'];
			
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res3billdate; ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res3billnumber; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res3patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res3patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res3patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res3username); ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_paynow_refund.php?locationcode=<?php echo $locationcode1; ?>&&billnumber=<?php echo $res3billnumber; ?>"><strong>Print</strong></a></td>
               <td class="bodytext31" valign="center"  align="left"><?php //echo $res2department; ?></td>
               </tr>
		   <?php } } ?>
		   
		   <?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				?>
			<?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 4)
				{
			$query4 = "select * from refund_consultation where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billnumber like '%$billnumber%' and locationcode='$locationcode1' and billdate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec4 = mysql_query($query4) or die ("Error in query4".mysql_error());
		    $num4 = mysql_num_rows($exec4);
			 ?> 	
			<tr>
				<td colspan="9" bgcolor="#cccccc" class="style3">Consultation Refund <?php echo '('.$num4.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit No</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">User</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              <td width="7%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">&nbsp;</td>
            </tr>
		   
		   <?php
			$query4 = "select * from refund_consultation where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billnumber like '%$billnumber%' and locationcode='$locationcode1' and billdate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec4 = mysql_query($query4) or die ("Error in query4".mysql_error());
			while($res4 = mysql_fetch_array($exec4))
			 {
			$res4patientcode= $res4['patientcode'];
			$res4patientvisitcode= $res4['patientvisitcode'];
			$res4billdate= $res4['billdate'];
			$res4patientname= $res4['patientname'];
			$res4billnumber= $res4['billnumber'];
			$res4username= $res4['username'];
			
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res4billdate; ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res4billnumber; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res4patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res4patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res4patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res4username); ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_consultationrefund_dmp4inch1.php?locationcode=<?php echo $locationcode1; ?>&&patientcode=<?php echo $res4patientcode; ?>&&billautonumber=<?php echo $res4billnumber; ?>"><strong>Print</strong></a></td>
               <td class="bodytext31" valign="center"  align="left"><?php //echo $res2department; ?></td>
               </tr>
		   <?php } }  ?>
		   
		   <?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				?>
			<?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 5)
				{
			$query5 = "select * from billing_external where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billno like '%$billnumber%' and locationcode='$locationcode1' and billdate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec5 = mysql_query($query5) or die ("Error in query5".mysql_error());
			$num5 = mysql_num_rows($exec5);
	        ?> 	
			<tr>
				<td colspan="9" bgcolor="#cccccc" class="style3">External Bill <?php echo '('.$num5.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit No</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">User</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              <td width="7%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">&nbsp;</td>
            </tr>
		   
		   <?php
			$query5 = "select * from billing_external where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billno like '%$billnumber%' and locationcode='$locationcode1' and billdate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec5 = mysql_query($query5) or die ("Error in query5".mysql_error());
			while($res5 = mysql_fetch_array($exec5))
			 {
			$res5patientcode= $res5['patientcode'];
			$res5patientvisitcode= $res5['visitcode'];
			$res5billdate= $res5['billdate'];
			$res5patientname= $res5['patientname'];
			$res5billnumber= $res5['billno'];
			$res5username= $res5['username'];
			
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res5billdate; ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res5billnumber; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res5patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res5patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res5patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res5username); ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_external_bill.php?locationcode=<?php echo $locationcode1; ?>&&billnumber=<?php echo $res5billnumber; ?>"><strong>Print</strong></a></td>
               <td class="bodytext31" valign="center"  align="left"><?php //echo $res2department; ?></td>
               </tr>
		   <?php } }  ?>
		   
		   <?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				?>
			<?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 6)
				{
				$query6 = "select * from master_transactionadvancedeposit where patientcode like '%$searchpatientcode%' and patientname like '%$searchpatient%' and docno like '%$billnumber%' and locationcode='$locationcode1' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
				$exec6 = mysql_query($query6) or die ("Error in query6".mysql_error());
				$num6 = mysql_num_rows($exec6);
			 ?> 	
			<tr>
				<td colspan="8" bgcolor="#cccccc" class="style3">Advance Deposit <?php echo '('.$num6.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">User</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              <td width="7%" align="left" valign="center" bgcolor="#FFFFF6F" class="style3">&nbsp;</td>
            </tr>
		   
		   <?php
			$query6 = "select * from master_transactionadvancedeposit where patientcode like '%$searchpatientcode%' and patientname like '%$searchpatient%' and docno like '%$billnumber%' and locationcode='$locationcode1' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec6 = mysql_query($query6) or die ("Error in query6".mysql_error());
			while($res6 = mysql_fetch_array($exec6))
			 {
			$res6patientcode= $res6['patientcode'];
			//$res6patientvisitcode= $res6['visitcode'];
			$res6billdate= $res6['transactiondate'];
			$res6patientname= $res6['patientname'];
			$res6billnumber= $res6['docno'];
			$res6username= $res6['username'];
			
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
				$colorcode = 'bgcolor="#D3EEB6"';
			}
			?>
             
            <tr <?php echo $colorcode; ?>>
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res6billdate; ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res6billnumber; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res6patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res6patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res6username); ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_advancedeposit_dmp4inch1.php?locationcode=<?php echo $locationcode1; ?>&&patientcode=<?php echo $res6patientcode; ?>&&billnumbercode=<?php echo $res6billnumber; ?>"><strong>Print</strong></a></td>
               <td class="bodytext31" valign="center"  align="left"><?php //echo $res2department; ?></td>
               </tr>
		   <?php } }  ?>
		   
		   <?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				?>
			<?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 7)
				{
				$query7 = "select * from master_transactionipdeposit where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and docno like '%$billnumber%' and locationcode='$locationcode1' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
				$exec7 = mysql_query($query7) or die ("Error in query7".mysql_error());
				$num7 = mysql_num_rows($exec7);
			 ?> 	
			<tr>
				<td colspan="9" bgcolor="#cccccc" class="style3">IP Deposit <?php echo '('.$num7.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit No</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">User</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              <td width="7%" align="left" valign="center" bgcolor="#FFFFF6F" class="style3">&nbsp;</td>
            </tr>
		   
		   <?php
			$query7 = "select * from master_transactionipdeposit where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and docno like '%$billnumber%' and locationcode='$locationcode1' and transactiondate between '$transactiondatefrom' and '$transactiondateto'  order by auto_number desc ";
			$exec7 = mysql_query($query7) or die ("Error in query7".mysql_error());
			while($res7 = mysql_fetch_array($exec7))
			 {
			$res7patientcode= $res7['patientcode'];
			$res7patientvisitcode= $res7['visitcode'];
			$res7billdate= $res7['transactiondate'];
			$res7patientname= $res7['patientname'];
			$res7billnumber= $res7['docno'];
			$res7username= $res7['username'];
			
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7billdate; ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res7billnumber; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res7username); ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_depositcollection_dmp4inch1.php?locationcode=<?php echo $locationcode1; ?>&&billnumbercode=<?php echo $res7billnumber; ?>&&patientcode=<?php echo $res7patientcode; ?>"><strong>Print</strong></a></td>
               <td class="bodytext31" valign="center"  align="left"><?php //echo $res2department; ?></td>
               </tr>
		   <?php } }  ?>
		   
		    <?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				?>
			<?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 8)
				{
				$query7 = "select * from master_transactionip where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billnumber like '%$billnumber%' and locationcode='$locationcode1' and transactiontype = 'finalize' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
				$exec7 = mysql_query($query7) or die ("Error in query7".mysql_error());
				$num7 = mysql_num_rows($exec7);
			 ?> 	
			<tr>
				<td colspan="9" bgcolor="#cccccc" class="style3">IP Final <?php echo '('.$num7.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit No</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">User</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              <td width="7%" align="left" valign="center" bgcolor="#FFFFF6F" class="style3">&nbsp;</td>
            </tr>
		   
		   <?php
		    $query7 = "select * from master_transactionip where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billnumber like '%$billnumber%' and locationcode='$locationcode1' and transactiontype = 'finalize' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec7 = mysql_query($query7) or die ("Error in query7".mysql_error());
			while($res7 = mysql_fetch_array($exec7))
			 {
			$res7patientcode= $res7['patientcode'];
			$res7patientvisitcode= $res7['visitcode'];
			$res7billdate= $res7['transactiondate'];
			$res7patientname= $res7['patientname'];
			$res7billnumber= $res7['billnumber'];
			$res7username= $res7['username'];
			
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7billdate; ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res7billnumber; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res7username); ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_ipfinalinvoice1.php?locationcode=<?php echo $locationcode1; ?>&&patientcode=<?php echo $res7patientcode; ?>&&visitcode=<?php echo $res7patientvisitcode; ?>&&billnumber=<?php echo $res7billnumber; ?>"><strong>Print A4 </strong></a></td>
                  </tr>
		   <?php } }  ?>
		   
		   <?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 9)
				{
				$query7 = "select * from billing_paylater where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billno like '%$billnumber%' and locationcode='$locationcode1' and patientcode <> '' and billdate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
				$exec7 = mysql_query($query7) or die ("Error in query7".mysql_error());
				$num7 = mysql_num_rows($exec7);
			 ?> 	
			<tr>
				<td colspan="9" bgcolor="#cccccc" class="style3">Bill Paylater <?php echo '('.$num7.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit No</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">User</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              <td width="7%" align="left" valign="center" bgcolor="#FFFFF6F" class="style3">&nbsp;</td>
            </tr>
		   
		   <?php
		    $query7 = "select * from billing_paylater where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billno like '%$billnumber%' and locationcode='$locationcode1' and patientcode <> '' and billdate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc "; 
			$exec7 = mysql_query($query7) or die ("Error in query7".mysql_error());
			$num7 = mysql_num_rows($exec7);
			while($res7 = mysql_fetch_array($exec7))
			 {
			$res7patientcode= $res7['patientcode'];
			$res7patientvisitcode= $res7['visitcode'];
			$res7billdate= $res7['billdate'];
			$res7patientname= $res7['patientname'];
			$res7billnumber= $res7['billno'];
			
			$query27 = "select * from master_transactionpaylater where locationcode='$locationcode1' and transactiontype='finalize' and billnumber='$res7billnumber'";
			$exec27 = mysql_query($query27) or die(mysql_error());
			$res27 = mysql_fetch_array($exec27);
			
			$res7username= $res27['username'];
			
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7billdate; ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res7billnumber; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res7username); ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_paylater_detailed.php?locationcode=<?php echo $locationcode1; ?>&&billautonumber=<?php echo $res7billnumber; ?>"><strong>Print</strong></a></td>
               <td class="bodytext31" valign="center"  align="left"><?php //echo $res2department; ?></td>
               </tr>
		   <?php } }  ?>
		   
		   <?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 10)
				{
				$query7 = "select * from master_transactionipcreditapproved where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billnumber like '%$billnumber%' and locationcode='$locationcode1' and transactiontype='finalize' and transactiondate between '$transactiondatefrom' and '$transactiondateto' group by billnumber order by auto_number desc ";
				$exec7 = mysql_query($query7) or die ("Error in query7".mysql_error());
				$num7 = mysql_num_rows($exec7);
			 ?> 	
			<tr>
				<td colspan="9" bgcolor="#cccccc" class="style3">IP Credit Approved <?php echo '('.$num7.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit No</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">User</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              <td width="7%" align="left" valign="center" bgcolor="#FFFFF6F" class="style3">&nbsp;</td>
            </tr>
		   
		   <?php
		    $query7 = "select * from master_transactionipcreditapproved where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billnumber like '%$billnumber%' and locationcode='$locationcode1' and transactiontype='finalize' and transactiondate between '$transactiondatefrom' and '$transactiondateto' group by billnumber order by auto_number desc ";
			$exec7 = mysql_query($query7) or die ("Error in query7".mysql_error());
			while($res7 = mysql_fetch_array($exec7))
			 {
			$res7patientcode= $res7['patientcode'];
			$res7patientvisitcode= $res7['visitcode'];
			$res7billdate= $res7['transactiondate'];
			$res7patientname= $res7['patientname'];
			$res7billnumber= $res7['billnumber'];
			$res7username= $res7['username'];
			
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7billdate; ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res7billnumber; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res7username); ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_creditapproval.php?locationcode=<?php echo $locationcode1; ?>&&patientcode=<?php echo $res7patientcode; ?>&&visitcode=<?php echo $res7patientvisitcode; ?>&&billnumber=<?php echo $res7billnumber; ?>"><strong>Print</strong></a></td>
               <td class="bodytext31" valign="center"  align="left"><?php //echo $res2department; ?></td>
               </tr>
		   <?php } }  ?>
		   <?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 11)
				{
				$query7 = "select * from master_transactionip where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billnumber like '%$billnumber%' and locationcode='$locationcode1' and transactiontype = 'finalize' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
				$exec7 = mysql_query($query7) or die ("Error in query7".mysql_error());
				$num7 = mysql_num_rows($exec7);
			 ?> 	
			<tr>
				<td colspan="9" bgcolor="#cccccc" class="style3">IP Final <?php echo '('.$num7.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit No</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">User</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              <td width="7%" align="left" valign="center" bgcolor="#FFFFF6F" class="style3">&nbsp;</td>
            </tr>
		   
		   <?php
		    $query7 = "select * from master_transactionip where patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billnumber like '%$billnumber%' and locationcode='$locationcode1' and transactiontype = 'finalize' and transactiondate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec7 = mysql_query($query7) or die ("Error in query7".mysql_error());
			while($res7 = mysql_fetch_array($exec7))
			 {
			$res7patientcode= $res7['patientcode'];
			$res7patientvisitcode= $res7['visitcode'];
			$res7billdate= $res7['transactiondate'];
			$res7patientname= $res7['patientname'];
			$res7billnumber= $res7['billnumber'];
			$res7username= $res7['username'];
			
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7billdate; ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res7billnumber; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res7username); ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_ipfinal_dmp4inch1.php?locationcode=<?php echo $locationcode1; ?>&&patientcode=<?php echo $res7patientcode; ?>&&billnumbercode=<?php echo $res7billnumber; ?>"><strong>Print</strong></a></td>
               <td class="bodytext31" valign="center"  align="left"><?php //echo $res2department; ?></td>
               </tr>
		   <?php } }  ?>
		   
		   <?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 12)
				{
				$query7 = "select * from sickleave_entry where  recorddate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
				$exec7 = mysql_query($query7) or die ("Error in query7".mysql_error());
				$num7 = mysql_num_rows($exec7);
			 ?> 	
			<tr>
				<td colspan="6" bgcolor="#cccccc" class="style3">Sick Leave <?php echo '('.$num7.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              <td width="7%" align="left" valign="center" bgcolor="#FFFFF6F" class="style3">&nbsp;</td>
            </tr>
		   
		   <?php
		    $query7 = "select * from sickleave_entry where  recorddate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec7 = mysql_query($query7) or die ("Error in query7".mysql_error());
			while($res7 = mysql_fetch_array($exec7))
			 {
			$res7patientcode= $res7['patientcode'];
			$res7billdate= $res7['recorddate'];
			$res7patientname= $res7['patientname'];
			$res7visitcode1=$res7['visitcode'];
			
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7billdate; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_sickleave.php?patientcode=<?php echo $res7patientcode; ?>&&visitcode=<?=$res7visitcode1;?>"><strong>Print</strong></a></td>
               <td class="bodytext31" valign="center"  align="left"><?php //echo $res2department; ?></td>
               </tr>
		   <?php } }  ?>
		      <?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 13)
				{
				$query7 = "select * from dischargesummary where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and locationcode='$locationcode1' and summarydate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
				$exec7 = mysql_query($query7) or die ("Error in query7".mysql_error());
				$num7 = mysql_num_rows($exec7);
			 ?> 	
			<tr>
				<td colspan="6" bgcolor="#cccccc" class="style3">Discharge Summary<?php echo '('.$num7.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Date</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
			  <td width="7%" align="left" valign="center" bgcolor="#FFFFF6F" class="style3">Visit No</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              
            </tr>
		   
		   <?php
		    $query7 = "select * from dischargesummary where patientcode like '%$searchpatientcode%' and patientvisitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and locationcode='$locationcode1' and summarydate between '$transactiondatefrom' and '$transactiondateto' order by auto_number desc ";
			$exec7 = mysql_query($query7) or die ("Error in query7".mysql_error());
			while($res7 = mysql_fetch_array($exec7))
			 {
			$res7patientcode= $res7['patientcode'];
			$res7visitcode= $res7['patientvisitcode'];
			$res7billdate= $res7['summarydate'];
			$res7patientname= $res7['patientname'];
			
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7billdate; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7visitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_dischargesummary.php?locationcode=<?php echo $locationcode1; ?>&&patientcode=<?php echo $res7patientcode; ?>&&visitcode=<?php echo $res7visitcode; ?>"><strong>Print</strong></a></td>
               </tr>
		   <?php } }  ?>
		    <?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 14)
				{
				$query7 = "select * from manual_lpo where locationcode='$locationcode1' and billnumber like '%$billnumber%'  and entrydate between '$transactiondatefrom' and '$transactiondateto' group by billnumber order by auto_number desc ";
				$exec7 = mysql_query($query7) or die ("Error in query7".mysql_error());
				$num7 = mysql_num_rows($exec7);
			 ?> 	
			<tr>
				<td colspan="5" bgcolor="#cccccc" class="style3">Manual LPO<?php echo '('.$num7.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3"> PO No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Supplier</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              
            </tr>
		   
		   <?php
		    $query7 = "select * from manual_lpo where locationcode='$locationcode1' and billnumber like '%$billnumber%' and entrydate between '$transactiondatefrom' and '$transactiondateto' group by billnumber order by auto_number desc ";
			$exec7 = mysql_query($query7) or die ("Error in query7".mysql_error());
			while($res7 = mysql_fetch_array($exec7))
			 {
			
			
			$res7billdate= $res7['entrydate'];
			$res7billno= $res7['billnumber'];
			$res7supplier= $res7['suppliername'];
			
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7billdate; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7billno; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7supplier; ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_manualpurchaseorder.php?locationcode=<?php echo $locationcode1; ?>&&billnumber=<?php echo $res7billno; ?>"><strong>Print</strong></a></td>
               </tr>
		   <?php } }  ?>
		    <?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 15)
				{
				$query7 = "select * from receiptsub_details where locationcode='$locationcode1' and docnumber like '%$billnumber%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' group by docnumber order by auto_number desc ";
				$exec7 = mysql_query($query7) or die ("Error in query7".mysql_error());
				$num7 = mysql_num_rows($exec7);
			 ?> 	
			<tr>
				<td colspan="6" bgcolor="#cccccc" class="style3">Misc Receipt <?php echo '('.$num7.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3"> Doc No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Description</td>
			  <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Received From</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              
            </tr>
		   
		   <?php
		    $query7 = "select * from receiptsub_details where locationcode='$locationcode1' and docnumber like '%$billnumber%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' group by docnumber order by auto_number desc ";
			$exec7 = mysql_query($query7) or die ("Error in query7".mysql_error());
			while($res7 = mysql_fetch_array($exec7))
			 {
			
			$anum7 = $res7['auto_number'];
			$res7billdate= $res7['transactiondate'];
			$res7billno= $res7['docnumber'];
			$res7supplier= $res7['receiptsubname'];
			$receivedfrom = $res7['receivedfrom'];
			
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7billdate; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7billno; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7supplier; ?></td>
			   <td class="bodytext31" valign="center"  align="left"><?php echo $receivedfrom; ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_receipt_receipt1.php?locationcode=<?php echo $locationcode1; ?>&&receiptanum=<?php echo $anum7; ?>"><strong>Print</strong></a></td>
               </tr>
		   <?php } }  ?>
           <?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 16)
				{
				$query7 = "select * from refund_paylater where locationcode='$locationcode1' and billno like '%$billnumber%' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' group by billno order by auto_number desc ";
				$exec7 = mysql_query($query7) or die ("Error in query7".mysql_error());
				$num7 = mysql_num_rows($exec7);
			 ?> 	
			<tr>
				<td colspan="7" bgcolor="#cccccc" class="style3">OP Credit<?php echo '('.$num7.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit No</td>
              
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              
            </tr>
		   
		   <?php
		    $query7 = "select * from refund_paylater where locationcode='$locationcode1' and billno like '%$billnumber%' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' group by billno order by auto_number desc ";
			$exec7 = mysql_query($query7) or die ("Error in query7".mysql_error());
			while($res7 = mysql_fetch_array($exec7))
			 {
			
			$res7patientcode= $res7['patientcode'];
			$res7billno= $res7['billno'];
			$res7visitcode= $res7['visitcode'];
			$res7billdate= $res7['billdate'];
			$res7patientname= $res7['patientname'];
		//	$res7username= $res7['username'];
			
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7billdate; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7billno; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7visitcode; ?></td>
               
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_paylaterrefund.php?locationcode=<?php echo $locationcode1; ?>&&patientcode=<?php echo $res7patientcode; ?>&&visitcode=<?php echo $res7visitcode; ?>&&billno=<?php echo $res7billno; ?>"><strong>Print</strong></a></td>
               </tr>
		   <?php } }  ?>

		
           <?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 17)
				{
				$query76 = "select * from ip_creditnote where locationcode='$locationcode1' and billno like '%$billnumber%' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' group by billno order by auto_number desc ";
				$exec76 = mysql_query($query76) or die ("Error in query76".mysql_error());
				$num76 = mysql_num_rows($exec76);
			 ?> 	
			<tr>
				<td colspan="7" bgcolor="#cccccc" class="style3">IP Credit Note<?php echo '('.$num76.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>

              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit No</td>
              
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              
            </tr>
		   
		   <?php
		    $query7 = "select * from ip_creditnote where locationcode='$locationcode1' and billno like '%$billnumber%' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' group by billno order by auto_number desc ";
			$exec7 = mysql_query($query7) or die ("Error in query7".mysql_error());
			while($res7 = mysql_fetch_array($exec7))
			 {
			
			$res7patientcode= $res7['patientcode'];
			$res7billno= $res7['billno'];
			$res7visitcode= $res7['visitcode'];
			$res7billdate= $res7['billdate'];
			$res7patientname= $res7['patientname'];
		//	$res7username= $res7['username'];
			
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7billdate; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7billno; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7visitcode; ?></td>
               
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_creditnote.php?locationcode=<?php echo $locationcode1; ?>&&patientcode=<?php echo $res7patientcode; ?>&&visitcode=<?php echo $res7visitcode; ?>&&billno=<?php echo $res7billno; ?>"><strong>Print</strong></a></td>
               </tr>
		   <?php } }  ?>

		<?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 18)
				{
				$query76 = "select * from ip_debitnote where locationcode='$locationcode1' and billno like '%$billnumber%' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' group by billno order by auto_number desc ";
				$exec76 = mysql_query($query76) or die ("Error in query76".mysql_error());
				$num76 = mysql_num_rows($exec76);
			 ?> 	
			<tr>
				<td colspan="7" bgcolor="#cccccc" class="style3">IP Debit Note<?php echo '('.$num76.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>

              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit No</td>
              
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              
            </tr>
		   
		   <?php
		    $query7 = "select * from ip_debitnote where locationcode='$locationcode1' and billno like '%$billnumber%' and billdate between '$transactiondatefrom' and '$transactiondateto' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' group by billno order by auto_number desc ";
			$exec7 = mysql_query($query7) or die ("Error in query7".mysql_error());
			while($res7 = mysql_fetch_array($exec7))
			 {
			
			$res7patientcode= $res7['patientcode'];
			$res7billno= $res7['billno'];
			$res7visitcode= $res7['visitcode'];
			$res7billdate= $res7['billdate'];
			$res7patientname= $res7['patientname'];
		//	$res7username= $res7['username'];
			
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7billdate; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7billno; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7visitcode; ?></td>
               
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_debitnote.php?locationcode=<?php echo $locationcode1; ?>&&patientcode=<?php echo $res7patientcode; ?>&&visitcode=<?php echo $res7visitcode; ?>&&billno=<?php echo $res7billno; ?>"><strong>Print</strong></a></td>
               </tr>
		   <?php } }  ?>
            <?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 19)
				{
				$query19 = "select * from master_transactionpaylater where locationcode='$locationcode1' and billnumber like '%$billnumber%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and transactiontype ='pharmacycredit' group by docno order by auto_number desc ";
				$exec19 = mysql_query($query19) or die ("Error in query19".mysql_error());
				$num19 = mysql_num_rows($exec19);
			 ?> 	
			<tr>
				<td colspan="7" bgcolor="#cccccc" class="style3">Pharmacy Credit<?php echo '('.$num19.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit No</td>
              
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              
            </tr>
		   
		   <?php
		    $query19 = "select patientcode,docno,visitcode,transactiondate,patientname from master_transactionpaylater where locationcode='$locationcode1' and docno like '%$billnumber%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and transactiontype ='pharmacycredit' group by docno order by auto_number desc ";
			$exec19 = mysql_query($query19) or die ("Error in query19".mysql_error());
			while($res19 = mysql_fetch_array($exec19))
			 {
			
			$res19patientcode= $res19['patientcode'];
			$res19docno= $res19['docno'];
			$res19visitcode= $res19['visitcode'];
			$res19transactiondate= $res19['transactiondate'];
			$res19patientname= $res19['patientname'];
		//	$res7username= $res7['username'];
			
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res19transactiondate; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res19docno; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res19patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res19patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res19visitcode; ?></td>
               
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_paylaterrefphar.php?locationcode=<?php echo $locationcode1; ?>&&patientcode=<?php echo $res19patientcode; ?>&&visitcode=<?php echo $res19visitcode; ?>&&billno=<?php echo $res19docno; ?>"><strong>Print</strong></a></td>
               </tr>
		   <?php } }  ?>
  <?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 20)
				{
				$query190 = "select * from master_transactionpaylater where locationcode='$locationcode1'  and transactiondate between '$transactiondatefrom' and '$transactiondateto' and transactiontype ='finalize' and particulars <> '' order by auto_number desc ";
				$exec190 = mysql_query($query190) or die ("Error in query190".mysql_error());
				$num190 = mysql_num_rows($exec190);
			 ?> 	
			<tr>
				<td colspan="7" bgcolor="#cccccc" class="style3">Debit Note<?php echo '('.$num190.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Docno</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Account Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Description</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Amount</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              
            </tr>
		   
		   <?php
		   
			while($res190 = mysql_fetch_array($exec190))
			 {
			
			$transactiondate0= $res190['transactiondate'];
			$accountname0= $res190['accountname'];
			$docno0= $res190['docno'];
			$particulars0= $res190['particulars'];
			$transactionamount0= $res190['transactionamount'];
		//	$res7username= $res7['username'];
			
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $transactiondate0; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $docno0 ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $accountname0 ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $particulars0 ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $transactionamount0; ?></td>
               <td class="bodytext31" valign="center"  align="left"><a href="print_bulkdebit_ind.php?fromdate=<?= $transactiondatefrom?>&&todate=<?= $transactiondateto ?>&&locationcode=<?= $locationcode1?>&&docnumber=<?= $docno0?>" target="_blank">Print</a></td></td>
               
              
               </tr>
		   <?php } ?>
		   <tr>
				<td colspan="7" bgcolor="#cccccc" class="style3">&nbsp;</td>
			</tr>
	
		   
		   
		   <?php }  ?>
            <?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 21)
				{
					
				$query190 = "select * from master_transactionpaylater where locationcode='$locationcode1'  and transactiondate between '$transactiondatefrom' and '$transactiondateto' and transactiontype ='paylatercredit' and particulars <> '' order by auto_number desc ";
				$exec190 = mysql_query($query190) or die ("Error in query190".mysql_error());
				$num190 = mysql_num_rows($exec190);
			 ?> 	
			<tr>
				<td colspan="7" bgcolor="#cccccc" class="style3">Credit Note<?php echo '('.$num190.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Docno</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Account Name</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Description</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Amount</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              
            </tr>
		   
		   <?php
		   
			while($res190 = mysql_fetch_array($exec190))
			 {
			
			$transactiondate0= $res190['transactiondate'];
			$accountname0= $res190['accountname'];
			$docno0= $res190['docno'];
			$particulars0= $res190['particulars'];
			$transactionamount0= $res190['transactionamount'];
		//	$res7username= $res7['username'];
			
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $transactiondate0; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $docno0 ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $accountname0 ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $particulars0 ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $transactionamount0; ?></td>
               <td class="bodytext31" valign="center"  align="left"><a href="print_bulkcredit_ind.php?fromdate=<?= $transactiondatefrom?>&&todate=<?= $transactiondateto ?>&&locationcode=<?= $locationcode1?>&&docnumber=<?= $docno0?>" target="_blank">Print</a></td></td>
               
              
               </tr>
		   <?php } ?>
		   <tr>
				<td colspan="7" bgcolor="#cccccc" class="style3">&nbsp;</td>
			</tr>
	
		   <?php }  ?>
			<?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 22)
				{
				$query7 = "select * from mortuary_allocation where dischargestatus = 'discharged' and dischargedate between '$transactiondatefrom' and '$transactiondateto' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' order by auto_number desc ";
				$exec7 = mysql_query($query7) or die ("Error in query7".mysql_error());
				$num7 = mysql_num_rows($exec7);
			 ?> 	
			<tr>
				<td colspan="9" bgcolor="#cccccc" class="style3">Mortuary Details<?php echo '('.$num7.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="3%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="7%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Date</td>
              <td width="11%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="11%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
			  <td width="9%" align="left" valign="center" bgcolor="#FFFFF6F" class="style3">Visit No</td>
              <td width="18%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Receive</td>
              <td width="6%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Transfer</td>
              <td width="18%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Removal</td>
              <td width="6%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Burial</td>
            </tr>
		   
		   <?php
				$query7 = "select * from mortuary_allocation where dischargestatus = 'discharged' and dischargedate between '$transactiondatefrom' and '$transactiondateto' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%'  order by auto_number desc ";
			$exec7 = mysql_query($query7) or die ("Error in query7".mysql_error());
			while($res7 = mysql_fetch_array($exec7))
			 {
			$res7patientcode= $res7['patientcode'];
			$res7visitcode= $res7['visitcode'];
			$res7billdate= $res7['recorddate'];
			$dischargedate= $res7['dischargedate'];
			$res7patientname= $res7['patientname'];

			$allocateddocno= $res7['docno'];
			$requstedno= $res7['requestno'];
			
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7billdate; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res7visitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_mortuarylist.php?docno=<?php echo $requstedno; ?>&&patientcode=<?php echo $res7patientcode; ?>&&visitcode=<?php echo $res7visitcode; ?>"><strong>Print</strong></a></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_mortuarytransferlist.php?docno=<?php echo $allocateddocno; ?>&&patientcode=<?php echo $res7patientcode; ?>&&visitcode=<?php echo $res7visitcode; ?>"><strong>Print</strong></a></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_mortuaryremovelist.php?docno=<?php echo $allocateddocno; ?>&&patientcode=<?php echo $res7patientcode; ?>&&visitcode=<?php echo $res7visitcode; ?>"><strong>Print</strong></a></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_mortuaryburiallist.php?docno=<?php echo $allocateddocno; ?>&&patientcode=<?php echo $res7patientcode; ?>&&visitcode=<?php echo $res7visitcode; ?>"><strong>Print</strong></a></td>
               </tr>
		   <?php } }  ?>
            <?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 23)
				{
				$query8 = "select * from master_mortuaryexternaldeposit where transactiondate between '$transactiondatefrom' and '$transactiondateto' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billnumber like '%$billnumber%' order by auto_number desc ";
				$exec8 = mysql_query($query8) or die ("Error in query8".mysql_error());
				$num8 = mysql_num_rows($exec8);
			 ?> 	
           
            <tr>
				<td colspan="7" bgcolor="#cccccc" class="style3">External Mortuary Deposit<?php echo '('.$num8.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="3%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="7%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill.No</td>
              <td width="11%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="11%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Code</td>
			  <td width="9%" align="left" valign="center" bgcolor="#FFFFF6F" class="style3">Visit Code</td>
              <td width="18%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="6%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
            </tr>?
		   
		   <?php
				$query8 = "select * from master_mortuaryexternaldeposit where transactiondate between '$transactiondatefrom' and '$transactiondateto' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billnumber like '%$billnumber%' order by auto_number desc ";
			$exec8 = mysql_query($query8) or die ("Error in query8".mysql_error());
			while($res8 = mysql_fetch_array($exec8))
			 {
				 $allocateddocno= $res8['docno'];
			     $billdate= $res8['transactiondate'];
			     $res8patientcode= $res8['patientcode'];
			 	 $res8visitcode= $res8['visitcode'];
			   //$res8billdate= $res8['recorddate'];
				 $res8patientname= $res8['patientname'];

			
		//	$requstedno= $res8['requestno'];
			
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $allocateddocno; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $billdate; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res8patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res8visitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo  $res8patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_externaldepositcollection_dmp4inch1.php?billnumbercode=<?php echo $allocateddocno; ?>&&patientcode=<?php echo $res8patientcode; ?>"><strong>Print</strong></a></td>
             
               </tr>
           <?php }
				}
?>
		 <?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				?>
			<?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 24)
				{
			$query5 = "select * from billing_external where billdate between '$transactiondatefrom' and '$transactiondateto' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billno LIKE 'EXMB-%' order by auto_number desc ";
			$exec5 = mysql_query($query5) or die ("Error in query5".mysql_error());
			$num5 = mysql_num_rows($exec5);
	        ?> 	
			<tr>
				<td colspan="9" bgcolor="#cccccc" class="style3">External Mortuary Services <?php echo '('.$num5.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="3%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="7%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill Date</td>
              <td width="11%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Bill No</td>
              <td width="11%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Patient Name</td>
              <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Reg No</td>
              <td width="18%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Visit No</td>
              <td width="6%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">User</td>
              <td width="18%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              <td width="6%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">&nbsp;</td>
            </tr>
		   
		   <?php
			$query5 = "select * from billing_external where billdate between '$transactiondatefrom' and '$transactiondateto' and patientcode like '%$searchpatientcode%' and visitcode like '%$searchvisitcode%' and patientname like '%$searchpatient%' and billno LIKE 'EXMB-%' order by auto_number desc ";
			$exec5 = mysql_query($query5) or die ("Error in query5".mysql_error());
			while($res5 = mysql_fetch_array($exec5))
			 {
			$res5patientcode= $res5['patientcode'];
			$res5patientvisitcode= $res5['visitcode'];
			$res5billdate= $res5['billdate'];
			$res5patientname= $res5['patientname'];
			$res5billnumber= $res5['billno'];
			$res5username= $res5['username'];
			
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res5billdate; ?></td>
               <td align="left" valign="center"  class="bodytext31"><?php echo $res5billnumber; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res5patientname; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res5patientcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res5patientvisitcode; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res5username); ?></td>
               <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_external_billamb.php?billnumber=<?php echo $res5billnumber; ?>"><strong>Print</strong></a></td>
               <td class="bodytext31" valign="center"  align="left"><?php //echo $res2department; ?></td>
               </tr>
		   <?php } }  ?>
           
           <?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 25)
				{
				$query721 = "select * from master_transactionpaylater where docno like '%$billnumber%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' and transactionstatus = 'onaccount' group by docno order by auto_number desc ";
				$exec721 = mysql_query($query721) or die ("Error in query721".mysql_error());
				$num721 = mysql_num_rows($exec721);
			 ?> 	
			<tr>
				<td colspan="6" bgcolor="#cccccc" class="style3">Account Receivable Receipt <?php echo '('.$num721.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3"> Doc No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Description</td>
			  <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">&nbsp;</td>
			  <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              
            </tr>
		   
		   <?php
		    $query721 = "select * from master_transactionpaylater where docno like '%$billnumber%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' and transactionstatus = 'onaccount' group by docno order by auto_number desc ";
			$exec721 = mysql_query($query721) or die ("Error in query721".mysql_error());
			while($res721 = mysql_fetch_array($exec721))
			 {
			
			$anum721 = $res721['auto_number'];
			$res721billdate= $res721['transactiondate'];
			$res721billno= $res721['docno'];
			$res721supplier= $res721['accountname'];
			
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res721billdate; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res721billno; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res721supplier; ?></td>
			   <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
			   <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="receipt_receivable_print.php?receiptanum=<?php echo $anum721; ?>"><strong>Print</strong></a></td>
               </tr>
		   <?php } }  ?>
		   <?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 26)
				{
				$query721 = "select * from master_transactionpharmacy where docno like '%$billnumber%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' and transactionmodule = 'PAYMENT' and recordstatus = 'allocated' group by docno order by auto_number desc ";
				$exec721 = mysql_query($query721) or die ("Error in query721".mysql_error());
				$num721 = mysql_num_rows($exec721);
			 ?> 	
			<tr>
				<td colspan="6" bgcolor="#cccccc" class="style3">Account Payables  <?php echo '('.$num721.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3"> Doc No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Description</td>
			  <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">&nbsp;</td>
			  <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              
            </tr>
		   
		   <?php
		    $query721 = "select * from master_transactionpharmacy where docno like '%$billnumber%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' and transactionmodule = 'PAYMENT' and recordstatus = 'allocated' group by docno order by auto_number desc ";
			$exec721 = mysql_query($query721) or die ("Error in query721".mysql_error());
			while($res721 = mysql_fetch_array($exec721))
			 {
			
			$anum721 = $res721['auto_number'];
			$res721billdate= $res721['transactiondate'];
			$res721billno= $res721['docno'];
			$res721supplier= $res721['suppliername'];
			
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res721billdate; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res721billno; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res721supplier; ?></td>
			   <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
			   <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_payment1.php?billnumber=<?php echo $res721billno; ?>"><strong>Print</strong></a></td>
               </tr>
		   <?php } }  ?>
		<?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 27)
				{
				$query721 = "select * from master_transactionpayroll where docno like '%$billnumber%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' and transactionmodule = 'PAYMENT' and recordstatus = 'allocated' group by docno order by auto_number desc ";
				$exec721 = mysql_query($query721) or die ("Error in query721".mysql_error());
				$num721 = mysql_num_rows($exec721);
			 ?> 	
			<tr>
				<td colspan="6" bgcolor="#cccccc" class="style3">Account Payables  <?php echo '('.$num721.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3"> Doc No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Description</td>
			  <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">&nbsp;</td>
			  <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              
            </tr>
		   
		   <?php
		    $query721 = "select * from master_transactionpayroll where docno like '%$billnumber%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' and transactionmodule = 'PAYMENT' and recordstatus = 'allocated' group by docno order by auto_number desc ";
			$exec721 = mysql_query($query721) or die ("Error in query721".mysql_error());
			while($res721 = mysql_fetch_array($exec721))
			 {
			
			$anum721 = $res721['auto_number'];
			$res721billdate= $res721['transactiondate'];
			$res721billno= $res721['docno'];
			$res721supplier= $res721['accountname'];
			
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res721billdate; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res721billno; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res721supplier; ?></td>
			   <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
			   <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_paymentpayroll1.php?billnumber=<?php echo $res721billno; ?>"><strong>Print</strong></a></td>
               </tr>
		   <?php } }  ?>





		<?php if ($cbfrmflag1 == 'cbfrmflag1' && $billtype== 28)
				{
				$query721 = "select * from purchase_details where billnumber like '%$billnumber%' and entrydate between '$transactiondatefrom' and '$transactiondateto' and billnumber like 'NMP%' group by billnumber order by auto_number desc ";
				$exec721 = mysql_query($query721) or die ("Error in query721".mysql_error());
				$num721 = mysql_num_rows($exec721);
			 ?> 	
			<tr>
				<td colspan="6" bgcolor="#cccccc" class="style3">Purchase Invoice Entry <?php echo '('.$num721.')'; ?></td>
			</tr>
             <tr <?php //echo $colorcode; ?>>
              <td width="5%" align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong>S.No.</strong></td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Date</td>
              <td width="10%" align="left" valign="center" bgcolor="#FFFFFF" class="style3"> Bill No</td>
              <td width="29%" align="left" valign="center" bgcolor="#FFFFFF" class="style3"> Supplier</td>
			  <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">&nbsp;</td>
			  <td width="9%" align="left" valign="center" bgcolor="#FFFFFF" class="style3">Action</td>
              
            </tr>
		   
		   <?php
		    $query721 = "select * from purchase_details where billnumber like '%$billnumber%' and entrydate between '$transactiondatefrom' and '$transactiondateto' and billnumber like 'NMP%' group by billnumber order by auto_number desc ";
			$exec721 = mysql_query($query721) or die ("Error in query721".mysql_error());
			while($res721 = mysql_fetch_array($exec721))
			 {
			
			$anum721 = $res721['auto_number'];
			$res721billdate= $res721['entrydate'];
			$res721billno= $res721['billnumber'];
			$res721supplier= $res721['suppliername'];
			
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
              <td class="bodytext31" valign="center" align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res721billdate; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res721billno; ?></td>
               <td class="bodytext31" valign="center"  align="left"><?php echo $res721supplier; ?></td>
			   <td class="bodytext31" valign="center"  align="left">&nbsp;</td>
			   <td class="bodytext31" valign="center"  align="left"><a target="_blank" href="print_invoiceentry.php?invoice_number=<?php echo $res721billno; ?>"><strong>Print</strong></a></td>
               </tr>
		   <?php } }  ?>

            <tr>
              <td colspan="2"  class="bodytext31" valign="center"  align="right" 
                bgcolor="#E0E0E0">&nbsp;</td>
              <td align="right" valign="center" 
                bgcolor="#E0E0E0" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#E0E0E0" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#E0E0E0" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#E0E0E0" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#E0E0E0" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#E0E0E0" class="bodytext31">&nbsp;</td>
				<td rowspan="2" align="right" valign="center" bgcolor="#E0E0E0" class="bodytext31">&nbsp;</td>
				<td width="1%" rowspan="2" align="right" valign="center" bgcolor="#E0E0E0" class="bodytext31">&nbsp;</td>
			   </tr>          </tbody>
        </table></td>
      </tr>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

