<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');

$colorloopcount = '';
$sno1 = '';
$sno2 = '';
$sno3 = '';
$sno4 = '';
$snocount = '';

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
if ($cbfrmflag1 == 'cbfrmflag1')
{
	$paymentreceiveddatefrom = $_REQUEST['ADate1'];
	$paymentreceiveddateto = $_REQUEST['ADate2'];
}


if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
if ($ADate1 != '' && $ADate2 != '')
{
	$transactiondatefrom = $_REQUEST['ADate1'];
	$transactiondateto = $_REQUEST['ADate2'];
}
else
{
	$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
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
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<script language="javascript">

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
		
		
              <form name="cbform1" method="post" action="doctorwisedepartmentwise.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr bgcolor="#011E6A">
                      <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Doctor Wise Department Wise</strong></td>
                      <!--<td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                      <td bgcolor="#CCCCCC" class="bodytext3" colspan="2">&nbsp;</td>
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
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
					  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
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
		  <?php
            if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
		    if ($cbfrmflag1 == 'cbfrmflag1')
			{
				
				  $querydoc = "select * from master_consultationlist where date between '$ADate1' and '$ADate2' group by username"; 
		  $execdoc = mysql_query($querydoc) or die ("Error in Querydoc".mysql_error());
		  while($resdoc = mysql_fetch_array($execdoc))
			{
			$resdocdoctorname = $resdoc['username'];
			?><tr>
				<td colspan="4" align="left" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><strong>&nbsp;Doctor Name :<?php echo ucfirst($resdocdoctorname);?></strong></td>
                </tr>
			<tr>
				<td width="66"  align="left" valign="center" 
				bgcolor="#ffffff" class="bodytext31"><strong>&nbsp;S.No.</strong></td>
				<td width="418" align="left" valign="center"  
				bgcolor="#ffffff" class="bodytext31"><strong>Doctor Name </strong></td>
				<td width="92" align="right" valign="center"  
				bgcolor="#ffffff" class="bodytext31"><strong>Total Revenue </strong></td>
			</tr>
			<tr>
			  <td colspan="2"  align="left" valign="center" 
				bgcolor="#cccccc" class="bodytext31"><strong>Pharmacy</strong></td>
			  <td align="right" valign="center"  
				bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
			  </tr>
			
			<?php
		 
		  
		   $totallab=0;
		  $totalrad=0;
		  $totalpharm=0;
		  $totalservice=0;
		  $alltotallab=0;
		  $alltotalrad=0;
		  $alltotalpharm=0;
		  $alltotalservice=0;
		  $grandtotal=0;
		  $query1 = "select * from master_consultationlist where date between '$ADate1' and '$ADate2' and username = '".$resdocdoctorname."' group by username"; 
		  $exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
		  while($res1 = mysql_fetch_array($exec1))
			{
			$res1doctorname = $res1['username'];
				
			$query2 = "select * from consultation_lab where username = '$res1doctorname' and consultationdate between '$ADate1' and '$ADate2' group by patientvisitcode"; 
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
			$num2=mysql_num_rows($exec2);
			while($res2 = mysql_fetch_array($exec2))
			{
			$res2patientcode = $res2['patientcode'];
			$res2patientvisitcode = $res2['patientvisitcode'];
			$res2username = $res2['username'];
			
			$query3 = "select sum(amount) as sumpharmacy from billing_paynowpharmacy where patientcode='$res2patientcode' and patientvisitcode='$res2patientvisitcode' and billdate between '$ADate1' and '$ADate2'"; 
			$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
			$num3=mysql_num_rows($exec3);
			$res3 = mysql_fetch_array($exec3);
			$res3sumpharmacy= $res3['sumpharmacy'];
			
			$query33 = "select sum(amount) as sumpaylaterpharmacy from billing_paylaterpharmacy where patientcode='$res2patientcode' and patientvisitcode='$res2patientvisitcode' and billdate between '$ADate1' and '$ADate2'"; 
			$exec33 = mysql_query($query33) or die ("Error in Query33".mysql_error());
			$num33=mysql_num_rows($exec33);
			$res33 = mysql_fetch_array($exec33);
			$res33sumpaylaterpharmacy= $res33['sumpaylaterpharmacy'];
			$totalpharm=$res3sumpharmacy + $res33sumpaylaterpharmacy;

		    $alltotalpharm=$alltotalpharm + $totalpharm;
			
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
				<td class="bodytext31" valign="center"  align="left"><?php echo $sno1=$sno1 + 1; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $res2username; ?></td>
				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($totalpharm,2); ?></td>
			</tr>
			<?php 
			}
			}
			 ?>
			<tr>
			  <td bgcolor="#cccccc" class="bodytext31" valign="center"  align="left">&nbsp;</td>
			  <td bgcolor="#cccccc" class="bodytext31" valign="center"  align="right"><strong>Total</strong></td>
			  <td bgcolor="#cccccc" class="bodytext31" valign="center"  align="right"><strong><?php echo number_format($alltotalpharm,2); ?></strong></td>
			  </tr>
			<tr>
				<td class="bodytext31" valign="center"  align="left">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="right">&nbsp;</td>
			</tr> 
			<tr>
			  <td colspan="2"  align="left" valign="center" 
				bgcolor="#cccccc" class="bodytext31"><strong>Lab</strong></td>
			  <td align="right" valign="center"  
				bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
			  </tr>
			<?php
		  $query4 = "select * from master_consultationlist where date between '$ADate1' and '$ADate2'  and username = '".$resdocdoctorname."'  group by username"; 
		  $exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		  while($res4 = mysql_fetch_array($exec4))
			{
			$res4doctorname = $res4['username'];
				
			$query5 = "select * from consultation_lab where username = '$res4doctorname' and consultationdate between '$ADate1' and '$ADate2' group by patientvisitcode"; 
			$exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
			$num5=mysql_num_rows($exec5);
			while($res5 = mysql_fetch_array($exec5))
			{
			$res5patientcode = $res5['patientcode'];
			$res5patientvisitcode = $res5['patientvisitcode'];
			$res5username = $res5['username'];
			
			$query6 = "select sum(labitemrate) as sumlab from billing_paynowlab where patientcode='$res5patientcode' and patientvisitcode='$res5patientvisitcode' and billdate between '$ADate1' and '$ADate2'"; 
			$exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
			$num6=mysql_num_rows($exec6);
			$res6 = mysql_fetch_array($exec6);
			$res6sumlab= $res6['sumlab'];
			
			$query16 = "select sum(labitemrate) as sumpaylaterlab from billing_paylaterlab where patientcode='$res5patientcode' and patientvisitcode='$res5patientvisitcode' and billdate between '$ADate1' and '$ADate2'"; 
			$exec16 = mysql_query($query16) or die ("Error in Query16".mysql_error());
			$num16=mysql_num_rows($exec16);
			$res16 = mysql_fetch_array($exec16);
			$res16sumpaylaterlab= $res16['sumpaylaterlab'];
			$totallab=$res6sumlab + $res16sumpaylaterlab;
			$alltotallab=$alltotallab + $totallab;
			
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
				<td class="bodytext31" valign="center"  align="left"><?php echo $sno2=$sno2 + 1; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $res5username; ?></td>
				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($totallab,2); ?></td>
			</tr>
			<?php 
			}
			}
			 ?>
			 <tr>
				<td  bgcolor="#cccccc" class="bodytext31" valign="center"  align="left">&nbsp;</td>
				<td  bgcolor="#cccccc" class="bodytext31" valign="center"  align="right"><strong>Total</strong></td>
				<td  bgcolor="#cccccc" class="bodytext31" valign="center"  align="right"><strong><?php echo number_format($alltotallab,2); ?></strong></td>
			</tr>
			<tr>
				<td class="bodytext31" valign="center"  align="left">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="right">&nbsp;</td>
			</tr> 
			<tr>
				<td colspan="2"  bgcolor="#cccccc" align="left" valign="center" class="bodytext31"><strong>Radiology</strong></td>
				<td class="bodytext31" bgcolor="#cccccc" valign="center"  align="right">&nbsp;</td>
			</tr> 
			<?php
		  $query8 = "select * from master_consultationlist where date between '$ADate1' and '$ADate2'  and username = '".$resdocdoctorname."'  group by username"; 
		  $exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
		  while($res8 = mysql_fetch_array($exec8))
			{
			$res8doctorname = $res8['username'];
				
			$query9 = "select * from consultation_lab where username = '$res8doctorname' and consultationdate between '$ADate1' and '$ADate2' group by patientvisitcode"; 
			$exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
			$num9=mysql_num_rows($exec9);
			while($res9 = mysql_fetch_array($exec9))
			{
			$res9patientcode = $res9['patientcode'];
			$res9patientvisitcode = $res9['patientvisitcode'];
			$res9username = $res9['username'];
			
			$query10 = "select sum(radiologyitemrate) as sumradiology from billing_paynowradiology where patientcode='$res9patientcode' and patientvisitcode='$res9patientvisitcode' and billdate between '$ADate1' and '$ADate2'"; 
			$exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());
			$num10=mysql_num_rows($exec10);
			$res10 = mysql_fetch_array($exec10);
			$res10sumradiology= $res10['sumradiology'];
			
			$query100 = "select sum(radiologyitemrate) as sumpaylaterradiology from billing_paylaterradiology where patientcode='$res5patientcode' and patientvisitcode='$res5patientvisitcode' and billdate between '$ADate1' and '$ADate2'"; 
			$exec100 = mysql_query($query100) or die ("Error in Query100".mysql_error());
			$num100=mysql_num_rows($exec100);
			$res100 = mysql_fetch_array($exec100);
			$res100sumpaylaterradiology= $res100['sumpaylaterradiology'];
			$totalrad=$res10sumradiology + $res100sumpaylaterradiology;
			$alltotalrad=$alltotalrad + $totalrad;
			
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
				<td class="bodytext31" valign="center"  align="left"><?php echo $sno3=$sno3 + 1; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $res9username; ?></td>
				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($totalrad,2); ?></td>
			</tr>
			<?php 
			} } ?>
			<tr>
			  <td bgcolor="#cccccc" class="bodytext31" valign="center"  align="left">&nbsp;</td>
			  <td bgcolor="#cccccc" class="bodytext31" valign="center"  align="right"><strong>Total</strong></td>
			  <td bgcolor="#cccccc" class="bodytext31" valign="center"  align="right"><strong><?php echo number_format($alltotalrad,2); ?></strong></td>
			  </tr>
			<tr>
				<td colspan="2"  align="left" valign="center" class="bodytext31">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="right">&nbsp;</td>
			</tr> 
			<tr>
				<td colspan="2"  bgcolor="#cccccc" align="left" valign="center" class="bodytext31"><strong>Service</strong></td>
				<td class="bodytext31" bgcolor="#cccccc" valign="center"  align="right">&nbsp;</td>
			</tr> 
			<?php
		  $query11 = "select * from master_consultationlist where date between '$ADate1' and '$ADate2'  and username = '".$resdocdoctorname."'  group by username"; 
		  $exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
		  while($res11 = mysql_fetch_array($exec11))
			{
			$doctorname = $res11['username'];
				
			$query12 = "select * from consultation_lab where username = '$doctorname' and consultationdate between '$ADate1' and '$ADate2' group by patientvisitcode"; 
			$exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
			$num12=mysql_num_rows($exec12);
			while($res12 = mysql_fetch_array($exec12))
			{
			$res12patientcode = $res12['patientcode'];
			$res12patientvisitcode = $res12['patientvisitcode'];
			$res12username = $res12['username'];
			
			$query13 = "select sum(servicesitemrate) as sumservices from billing_paynowservices where patientcode='$res12patientcode' and patientvisitcode='$res12patientvisitcode' and billdate between '$ADate1' and '$ADate2'"; 
			$exec13 = mysql_query($query13) or die ("Error in Query13".mysql_error());
			$num13=mysql_num_rows($exec13);
			$res13 = mysql_fetch_array($exec13);
			$res13sumservices= $res13['sumservices'];
			
			$query133 = "select sum(servicesitemrate) as sumpaylaterservice from billing_paylaterservices where patientcode='$res5patientcode' and patientvisitcode='$res5patientvisitcode' and billdate between '$ADate1' and '$ADate2'"; 
			$exec133 = mysql_query($query133) or die ("Error in Query133".mysql_error());
			$num133=mysql_num_rows($exec133);
			$res133 = mysql_fetch_array($exec133);
			$res133sumpaylaterservice= $res133['sumpaylaterservice'];
			$totalservice=$res13sumservices + $res133sumpaylaterservice;
			$alltotalservice=$alltotalservice + $totalservice;
			
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
				<td class="bodytext31" valign="center"  align="left"><?php echo $sno4=$sno4 + 1; ?></td>
				<td class="bodytext31" valign="center"  align="left"><?php echo $res12username; ?></td>
				<td class="bodytext31" valign="center"  align="right"><?php echo number_format($totalservice,2); ?></td>
			</tr>
			
			<?php
			   
			}
		
			  $grandtotal=$alltotallab + $alltotalrad + $alltotalpharm + $alltotalservice;
			 
			  }
			 ?>
			 <tr>
			  <td bgcolor="#cccccc" class="bodytext31" valign="center"  align="left">&nbsp;</td>
			  <td bgcolor="#cccccc" class="bodytext31" valign="center"  align="right"><strong>Total</strong></td>
			  <td bgcolor="#cccccc" class="bodytext31" valign="center"  align="right"><strong><?php echo number_format($alltotalservice,2); ?></strong></td>
			  </tr>
			  <tr>
			  <td  class="bodytext31" valign="center"  align="left">&nbsp;</td>
			  <td  align="right" valign="center"  class="bodytext31"><strong>Grand Total </strong></td>
			  <td  class="bodytext31" valign="center"  align="right"><strong><?php echo number_format($grandtotal,2); ?></strong></td>
			  </tr>
			 <?php
			} }
			?>
          </tbody>
        </table></td>
      </tr>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

