<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");


$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$updatedate = date('Y-m-d');
$username = $_SESSION['username'];
$docno = $_SESSION['docno'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$tottransactionamount1 = '';
$registrationdate = '';
$packageanum1 = '';
$billtype = '';
$tottransactionamount = '';

 $colorloopcount1 =0;
 $sno1 = 0;
 $transactionamount = '';

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
.style3 {
	COLOR: #3b3b3c;
	FONT-FAMILY: Tahoma;
	text-decoration: none;
	font-size: 11px;
	font-weight: bold;
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
		<form name="cbform1" method="post" action="ipcreditaccountreport.php">
          <table width="1040" border="0"  align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
           <tbody>
          <tr bgcolor="#011E6A">
              <td height="21" colspan="4" bgcolor="#CCCCCC" class="bodytext3"><strong>IP Credit Account Report </strong></td>
            </tr>
             <tr>
          <td width="263" height="35" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Date From </strong></td>
          <td align="left" valign="center"  bgcolor="#ffffff" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $transactiondatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/>			</td>
          <td width="155" align="left" valign="center"  bgcolor="#FFFFFF" class="style1"><span class="bodytext31"><strong> Date To </strong></span></td>
          <td width="206" align="left" valign="center"  bgcolor="#ffffff"><span class="bodytext31">
            <input name="ADate2" id="ADate2" value="<?php echo $transactiondateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
			<img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/>
		  </span></td>
          </tr>
           <tr>
  			  <td width="263" height="28" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
			 
				 <select name="location" id="location" onChange="return funcSubTypeChange1()">
                    <?php
						
						$query1 = "select * from login_locationdetails where  username='$username' and docno='$docno' order by locationname";
						$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
						$loccode=array();
						while ($res1 = mysql_fetch_array($exec1))
						{
						$locationname = $res1["locationname"];
						$locationcode = $res1["locationcode"];
						
						?>
						<option value="<?php echo $locationcode; ?>"><?php echo $locationname; ?></option>
						<?php
						} 
						?>
                </select>
					 
              </span></td>
			   <td align="left" colspan="2" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
		     </tr>
						
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input  type="submit" value="Search" name="Submit" />
                  <input name="resetbutton" type="reset" id="resetbutton" value="Reset" /></td>
            </tr>
			
			</tbody>
		
			</form>
			</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1000" 
            align="left" border="0">
	  
             <tr>
              <td width="3%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>No.</strong></div></td>
					 <td width="20%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Patient</strong></div></td>
				 <td width="8%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>Reg No</strong></div></td>
				
				 <td width="7%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>IP Visit</strong></div></td>
				  <td width="11%" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><div align="center"><strong>IP Date</strong></div></td>
					 <td width="7%"  align="left" valign="center" 
                bgcolor="#ffffff" class="style3"><div align="center">Bed No </div></td>
					 <td width="17%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Account</strong></div></td>
			 <td width="9%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Total Deposits </strong></div></td>
				    <td width="8%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Outstanding</strong></div></td>
				 <td width="4%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Limit</strong></div></td>
				 <td width="6%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Interim</strong></div></td>
              </tr>
			  <?php 
			   
		   $query34 = "select * from ip_bedallocation where locationcode='$locationcode1' and  paymentstatus = '' and creditapprovalstatus = '' ";
		   $exec34 = mysql_query($query34) or die(mysql_error());
		   $num1 = mysql_num_rows($exec34);
		   while($res34 = mysql_fetch_array($exec34))
		   {
		   $patientname = $res34['patientname'];
		   $patientcode = $res34['patientcode'];
		   $visitcode = $res34['visitcode'];
		   $docnumberr = $res34['docno'];
		   
		   $query36 = "select * from ip_bedtransfer where locationcode='$locationcode1' and  patientcode= '$patientcode' and visitcode='$visitcode' order by auto_number desc ";
		   $exec36 = mysql_query($query36) or die(mysql_error());
		   $num36 = mysql_num_rows($exec36);
		   $res36 = mysql_fetch_array($exec36);
		   $nbed = $res36['bed'];
		   
           $query35 = "select * from ip_bedallocation where locationcode='$locationcode1' and  patientcode= '$patientcode' and visitcode='$visitcode' and docno = '$docnumberr' and paymentstatus = '' and creditapprovalstatus = '' ";
		   $exec35 = mysql_query($query35) or die(mysql_error());
		   $res35 = mysql_fetch_array($exec35);
		   $bednumber = $res35['bed'];
		   $paymentstatus = $res35['paymentstatus'];
		   $creditapprovalstatus = $res35['creditapprovalstatus'];
		   
		     
		   if($num36 > 0)
		     {
			   $bednumber = $nbed; 
			  }
		   
		   $query50 = "select * from master_bed where locationcode='$locationcode1' and  auto_number='$bednumber'";
		                  $exec50 = mysql_query($query50) or die(mysql_error());
						  $res50 = mysql_fetch_array($exec50);
						  $bednames = $res50['bed'];
		 
		  
			include ('ipcreditaccountreport3.php');
			$total = $overalltotal;
		//echo  $overalltotal;
		   $query82 = "select * from master_ipvisitentry where locationcode='$locationcode1' and  patientcode='$patientcode' and visitcode='$visitcode'";
		   $exec82 = mysql_query($query82) or die(mysql_error());
		   $res82 = mysql_fetch_array($exec82);
		   $accountname = $res82['accountfullname'];
		   $registrationdate = $res82['registrationdate'];
		   $billtype = $res82['billtype'];
		   $overalllimit = $res82['overalllimit'];
		   //$consultationfee = $res82['admissionfees'];
		   
		     $query83 = "select sum(transactionamount) from   master_transactionipdeposit where locationcode='$locationcode1' and patientcode='$patientcode' and visitcode='$visitcode'";
		     $exec83 = mysql_query($query83) or die(mysql_error());
		     $res83 = mysql_fetch_array($exec83);
			$transactionamount = $res83['sum(transactionamount)'];
			
			$tottransactionamount = $tottransactionamount + $transactionamount;
			$tottransactionamount1 = $tottransactionamount1 + $total;
			  
		    $colorloopcount1 = $colorloopcount1 + 1;
			$showcolor1 = ($colorloopcount1 & 1); 
			if ($showcolor1 == 0)
			{
				//echo "if";
				$colorcode1 = 'bgcolor="#CBDBFA"';
			}
			else
			{
				//echo "else";
				$colorcode1 = 'bgcolor="#D3EEB7"';
			}
			?>
			  <tr <?php echo $colorcode1; ?>>	  
             <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $sno1 = $sno1 + 1; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $patientname; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $patientcode; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $visitcode; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $registrationdate; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $bednames; ?></div></td>
			   <td class="bodytext31" valign="center"  align="left"><div align="center"><?php echo $accountname; ?></div></td>
			  <td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo number_format($transactionamount,2,'.',','); ?></div></td>
			 <td class="bodytext31" valign="center"  align="left"><?php echo number_format($total,2,'.',',');  ?></td>
			<td class="bodytext31" valign="center"  align="left"><div align="left"><?php echo number_format($overalllimit,2,'.',','); ?></div></td>
			 <td width="6%"  align="left" valign="center" class="bodytext31"><div align="center"><a target="_blank" href="ipinteriminvoiceserver.php?patientcode=<?php echo $patientcode; ?>&&visitcode=<?php echo $visitcode; ?>"><strong>View</strong></a> </div></td>
			  </tr>
			  <?php
			  }
			  }
			  ?>
		   <tr>
		   <td class="bodytext31" valign="center"  align="right" colspan="8"><div align="right"><strong><?php echo number_format($tottransactionamount,2,'.',','); ?></strong></div></td>
		   <td class="bodytext31" valign="center"  align="right"><div align="right"><strong><?php echo number_format($tottransactionamount1,2,'.',','); ?></strong></div></td>

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
	  
	  
    </table>
  </table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

