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
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
$totallab = '0.00';
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$totalamount1 = '0.00';
$totalamount2 = '0.00';
$totalamount3 = '0.00';
$totalamount4 = '0.00';
$totalamount5 = '0.00';
$totalamount6 = '0.00';
$totalamount7 = '0.00';
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$range = "";
$res3labitemrate = "";
$location =isset( $_REQUEST['location'])?$_REQUEST['location']:'';
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

<script type="text/javascript" src="js/autocomplete_accounts2.js"></script>
<script type="text/javascript" src="js/autosuggest4accounts.js"></script>
<script type="text/javascript">
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
		
		
              <form name="cbform1" method="post" action="unfinalizedpaylatervisits.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#CCCCCC" class="bodytext3"><strong>Unfinalized Paylater Visits</strong></td>
              </tr>
            <!--<tr>
              <td colspan="4" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">
			  <input name="printreceipt1" type="reset" id="printreceipt1" onClick="return funcPrintReceipt1()" style="border: 1px solid #001E6A" value="Print Receipt - Previous Payment Entry" /> 
                *To Print Other Receipts Please Go To Menu:	Reports	-&gt; Payments Given 
				</td>
              </tr>-->
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Account </td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
              <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">
              </span></td>
           </tr>
		   <tr>
  			  <td width="12%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td width="59%" align="left" valign="top"  bgcolor="#FFFFFF">
			 
				 <select name="location" id="location">
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
					 
              </td>
			   <td width="29%" colspan="2" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"></td>
			  </tr>
			 	
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3"><input type="hidden" name="searchsuppliercode" onBlur="return suppliercodesearch1()" onKeyDown="return suppliercodesearch2()" id="searchsuppliercode" style="text-transform:uppercase" value="<?php echo $searchsuppliercode; ?>" size="20" /></td>
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="1400" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="3%" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
              <td colspan="14" bgcolor="#cccccc" class="bodytext31"><span class="bodytext311">
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
					
					//$transactiondatefrom = $_REQUEST['ADate1'];
					//$transactiondateto = $_REQUEST['ADate2'];
					
					//$paymenttype = $_REQUEST['paymenttype'];
					//$billstatus = $_REQUEST['billstatus'];
					
					$urlpath = "ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";
				}
				else
				{
					$urlpath = "ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";
				}
				?>
 				<?php
				//For excel file creation.
				
				$applocation1 = $applocation1; //Value from db_connect.php file giving application path.
				$filename1 = "print_paymentgivenreport1.php?$urlpath";
				$fileurl = $applocation1."/".$filename1;
				$filecontent1 = @file_get_contents($fileurl);
				
				$indiatimecheck = date('d-M-Y-H-i-s');
				$foldername = "dbexcelfiles";
				$fp = fopen($foldername.'/PaymentGivenToSupplier.xls', 'w+');
				fwrite($fp, $filecontent1);
				fclose($fp);

				?>
              <script language="javascript">
				function printbillreport1()
				{
					window.open("print_paymentgivenreport1.php?<?php echo $urlpath; ?>","Window1",'width=900,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
					//window.open("message_popup.php?anum="+anum,"Window1",'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=200,height=400,left=312,top=84');
				}
				function printbillreport2()
				{
					window.location = "dbexcelfiles/PaymentGivenToSupplier.xls"
				}
				</script>
              <!--<input  value="Print Report" onClick="javascript:printbillreport1()" name="resetbutton2" type="submit" id="resetbutton2"  style="border: 1px solid #001E6A" />
&nbsp;				<input  value="Export Excel" onClick="javascript:printbillreport2()" name="resetbutton22" type="button" id="resetbutton22"  style="border: 1px solid #001E6A" />-->
</span></td>  
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
				<td width="8%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg. Date</strong></div></td>
              <td width="8%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit No</strong></div></td>
              <td width="7%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Reg. No </strong></td>
				<td width="11%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Account </strong></td>
              <td width="14%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Patient </strong></td>
              <td width="7%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Total </strong></div></td>
				<td width="7%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Lab </strong></div></td>
              <td width="7%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Service </strong></div></td>
				<td width="8%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Pharmacy</strong></div></td>
				<td width="7%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right">
				  <div align="right"><strong>Radiology </strong></div>
				  </div></td>
				<td width="7%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Consultation</strong></div></td>
				<td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Referral </strong></div></td>
            </tr>
			<?php
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					
			$searchsuppliername=trim($searchsuppliername);
					
			$query21 = "select * from master_visitentry where billtype='PAY LATER' and overallpayment='' and locationcode='$location' and accountfullname like '%$searchsuppliername%' group by accountfullname order by accountfullname desc";
			$exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
			while ($res21 = mysql_fetch_array($exec21))
			{
			$res21accountname = $res21['accountfullname'];
			$res21accountnamecode = $res21['accountname'];
			
			$query22 = "select * from master_accountname where auto_number = '$res21accountnamecode' and recordstatus <>'DELETED' ";
			$exec22 = mysql_query($query22) or die ("Error in Query22".mysql_error());
			$res22 = mysql_fetch_array($exec22);
			$res22accountname = $res22['accountname'];

			if( $res21accountname != '')
			{
			?>
			<tr bgcolor="#cccccc">
            <td colspan="15"  align="left" valign="center" bgcolor="#cccccc" class="bodytext31"><strong><?php echo $res22accountname;?></strong></td>
            </tr>
			
			<?php
			
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			$res3labitemrate = "0.00";
		       
		  $query2 = "select * from master_visitentry where billtype='PAY LATER' and overallpayment='' and locationcode='$location' and accountfullname = '$res21accountname' order by accountfullname desc ";
		  $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		  while ($res2 = mysql_fetch_array($exec2))
		  {
		  $res2patientcode = $res2['patientcode'];
		  $res2visitcode = $res2['visitcode'];
		  $res2patientfullname = $res2['patientfullname'];
		  $res2registrationdate = $res2['consultationdate'];
		  $res2accountname = $res2['accountfullname'];
		  
		  //$query10 = "select * from master_accountname where auto_number = '$res2accountname' group by accountname desc";
		  //$exec10 = mysql_query($query10) or die ("Error in query10".mysql_error());
		  //$res10 = mysql_fetch_array($exec10);
		  //$res10auto_number = $res10['auto_number'];
		  //$res10accountname = $res10['accountname'];
		  
		  $query3 = "select sum(labitemrate) as labitemrate1 from consultation_lab where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode'";
		  $exec3 = mysql_query($query3) or die ("Error in query3".mysql_error());
		  $res3 = mysql_fetch_array($exec3);
		  $res3labitemrate = $res3['labitemrate1'];
		  if ($res3labitemrate =='')
		  {
		  $res3labitemrate = '0.00';
		  }
		  else 
		  {
		  $res3labitemrate = $res3['labitemrate1'];
		  }
		  $query4 = "select sum(servicesitemrate) as servicesitemrate1 from consultation_services where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' ";
		  $exec4 = mysql_query($query4) or die ("Error in query4".mysql_error());
		  $res4 = mysql_fetch_array($exec4);
		  $res4servicesitemrate = $res4['servicesitemrate1'];
		  if ($res4servicesitemrate =='')
		  {
		  $res4servicesitemrate = '0.00';
		  }
		  else 
		  {
		  $res4servicesitemrate = $res4['servicesitemrate1'];
		  }
		  $query5 = "select sum(radiologyitemrate) as radiologyitemrate1 from consultation_radiology where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' ";
		  $exec5 = mysql_query($query5) or die ("Error in query5".mysql_error());
		  $res5 = mysql_fetch_array($exec5);
		  $res5radiologyitemrate = $res5['radiologyitemrate1'];
		  if ($res5radiologyitemrate =='')
		  {
		  $res5radiologyitemrate = '0.00';
		  }
		  else 
		  {
		   $res5radiologyitemrate = $res5['radiologyitemrate1'];
		  }
		  $query6 = "select sum(referalrate) as referalrate1 from consultation_referal where patientcode = '$res2patientcode' and patientvisitcode = '$res2visitcode' ";
		  $exec6 = mysql_query($query6) or die ("Error in query6".mysql_error());
		  $res6 = mysql_fetch_array($exec6);
		  $res6referalrate = $res6['referalrate1'];
		  if ($res6referalrate =='')
		  {
		  $res6referalrate = '0.00';
		  }
		  else 
		  {
		    $res6referalrate = $res6['referalrate1'];
		  }
		  
		  $query7 = "select sum(consultationfees) as consultationfees1 from master_visitentry where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' ";
		  $exec7 = mysql_query($query7) or die ("Error in query7".mysql_error());
		  $res7 = mysql_fetch_array($exec7);
		  $res7consultationfees = $res7['consultationfees1'];
		 
		  $query8 = "select sum(copayfixedamount) as copayfixedamount1 from master_billing where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' ";
		  $exec8 = mysql_query($query8) or die ("Error in query8".mysql_error());
		  $res8 = mysql_fetch_array($exec8);
		  $res8copayfixedamount = $res8['copayfixedamount1'];
		  
		  $consultation = $res7consultationfees - $res8copayfixedamount;
		  
		  $query9 = "select sum(totalamount) as totalamount1 from pharmacysales_details where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' ";
		  $exec9 = mysql_query($query9) or die ("Error in query9".mysql_error());
		  $res9 = mysql_fetch_array($exec9);
		  $res9pharmacyrate = $res9['totalamount1'];
		  if ($res9pharmacyrate == '')
		  {
		  $res9pharmacyrate = '0.00';
		  }
		  else 
		  {
		  $res9pharmacyrate = $res9['totalamount1'];
		  }
		  
		  $totalamount = $res3labitemrate + $res4servicesitemrate + $res5radiologyitemrate + $res6referalrate + $consultation + $res9pharmacyrate;
		  $totalamount1 = $totalamount1 + $totalamount;
		  $totalamount2 = $totalamount2 + $res3labitemrate;
		  $totalamount3 = $totalamount3 + $res4servicesitemrate;
		  $totalamount4 = $totalamount4 + $res9pharmacyrate;
		  $totalamount5 = $totalamount5 + $res5radiologyitemrate;
		  $totalamount6 = $totalamount6 + $consultation;
		  $totalamount7 = $totalamount7 + $res6referalrate;
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
                <div class="bodytext31"><?php echo $res2registrationdate; ?></div></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2patientcode; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2accountname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div class="bodytext31"><?php echo $res2patientfullname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($totalamount,2,'.',','); ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="right"><?php echo number_format($res3labitemrate,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res4servicesitemrate,2,'.',','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res9pharmacyrate,2,'.',','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res5radiologyitemrate,2,'.',','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($consultation,2,'.',','); ?></div></td>
			  <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res6referalrate,2,'.',','); ?></div></td>
           </tr>
			<?php
			}
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
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong>Total:</strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totalamount1,2,'.',','); ?></strong></td>
				 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totalamount2,2,'.',','); ?></strong></td>
				 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totalamount3,2,'.',','); ?></strong></td>
				 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totalamount4,2,'.',','); ?></strong></td>
				 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totalamount5,2,'.',','); ?></strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totalamount6,2,'.',','); ?></strong></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($totalamount7,2,'.',','); ?></strong></td>
            </tr>
          </tbody>
        </table></td>
      </tr>
	  
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>
