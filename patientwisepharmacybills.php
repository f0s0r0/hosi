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
$total1='';
$grandtotal='0';
//This include updatation takes too long to load for hunge items database.
//include ("autocompletebuild_customer2.php");


if (isset($_REQUEST["searchsuppliername"])) { $searchsuppliername = $_REQUEST["searchsuppliername"]; } else { $searchsuppliername = ""; }
if (isset($_REQUEST["searchsuppliercode"])) { $searchsuppliercode = $_REQUEST["searchsuppliercode"]; } else { $searchsuppliercode = ""; }
if (isset($_REQUEST["searchvisitcode"])) { $searchvisitcode = $_REQUEST["searchvisitcode"]; } else { $searchvisitcode = ""; }
if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//echo $ADate2;
if (isset($_REQUEST["range"])) { $range = $_REQUEST["range"]; } else { $range = ""; }
//echo $range;
if (isset($_REQUEST["amount"])) { $amount = $_REQUEST["amount"]; } else { $amount = ""; }
//echo $amount;
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
<script type="text/javascript" src="js/autocomplete_patientstatus.js"></script>
<script type="text/javascript" src="js/autosuggestpatientstatus1.js"></script>

<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/autocomplete.css">
<script>

$(document).ready(function(e) {
	$('#patienttype').click(function (){
	var type=$('#patienttype').val();
	if(type=='credit')
	{
	$(this).closest("tr").next("tr").show();
	}
	else
	{
		$(this).closest("tr").next("tr").hide();
	}
	});
	
	
});
$(document).ready(function(e) {
   
		$('#searchaccountname').autocomplete({
		
	
	source:"autocompleteaccount.php",
	//alert(source);
	matchContains: true,
	minLength:1,
	html: true, 
		select: function(event,ui){
			var accountname=ui.item.value;
			var accountname=ui.item.accountname;
			//alert(auto_number);
			$("#searchaccountname").val(accountname);
			
			
			},
    
	});
		
});

$(document).ready(function(e) {
   
		$('#searchsuppliername').autocomplete({
		
	
	source:"ajaxpatientsearch.php",
	//alert(source);
	matchContains: true,
	minLength:1,
	html: true, 
		select: function(event,ui){
			var patname=ui.item.patientname;
			
			//alert(auto_number);
			$("#searchsupplierfullname").val(patname);
			
			
			},
    
	});
		
});

</script>    
<script type="text/javascript">
function ack()
{
	var sel=document.getElementById("patienttype").value;
	
	if(sel=='')
	{
		alert ("Please select patient Type");
		document.getElementById("patienttype").focus();
		return false;
	}
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
		
		
              <form name="cbform1" method="post" action="patientwisepharmacybills.php">
		<table width="800" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
          <tbody>
            <tr bgcolor="#011E6A">
              <td colspan="4" bgcolor="#CCCCCC" class="bodytext3"><strong>Patient Wise Pharmacy Bills</strong></td>
              </tr>
            <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Patient</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input name="searchsuppliername" type="text" id="searchsuppliername" value="<?php echo $searchsuppliername; ?>" size="50" autocomplete="off">
			  <input name="searchsupplierfullname" id="searchsupplierfullname" value="" type="hidden">
			  </td>
           </tr>
           <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Type</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <select name="patienttype" id="patienttype">
              <option value="">--Select--</option>
              <option value="cash">CASH</option>
              <option value="credit">CREDIT</option>
              </select>
			  </td>
           </tr>
		    <tr style="display:none" id='show'>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Search Account</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input name="searchaccountname" type="text" id="searchaccountname" size="50" autocomplete="off">
			  </td>
           </tr>
           <tr>
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Patient Type</td>
              <td width="82%" colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <select name="patienttype1" id="patienttype1">
              <option value="all">ALL</option>
              <option value="op">OP</option>
              <option value="ip">IP</option>
              </select>
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
              <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
              <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                  <input type="submit" value="Search" name="Submit" onClick="return ack()"/>
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
              <td width="13%" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
              <td colspan="3" bgcolor="#cccccc" class="bodytext31"><span class="bodytext311">
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
              <td width="52%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Test Name </strong></div></td>
              
              <td width="10%" align="left" valign="center"  
                bgcolor="#ffffff" class="style1"><div align="left"><strong>Qty</strong></div></td>
              <td width="21%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount</strong></div></td>
            </tr>
			<?php
			 
			 if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
				
				$patienttype=isset($_REQUEST['patienttype'])?$_REQUEST['patienttype']:'';
  $accountname=isset($_REQUEST['searchaccountname'])?$_REQUEST['searchaccountname']:'';
   $patienttype1=isset($_REQUEST['patienttype1'])?$_REQUEST['patienttype1']:'';
    $searchsuppliername=isset($_REQUEST['searchsupplierfullname'])?$_REQUEST['searchsupplierfullname']:'';
   
				if($patienttype1 <>'ip')
				{
					?>
                     <tr>
              <td colspan="10" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>OP</strong></td>
              </tr>
                    <?php
			 $total='';		   
		  if($patienttype == 'cash')
		  { 
	 	  $query21 = "select patientvisitcode,patientname,patientcode from billing_paynowpharmacy where patientname like '%$searchsuppliername%' and billdate between '$ADate1' and '$ADate2' group by patientvisitcode order by auto_number desc";
		  }
		  if($patienttype =='credit')
		 {
			 
			 $query21 = "select patientvisitcode,patientname,patientcode from billing_paylaterpharmacy where patientname like '%$searchsuppliername%' and billdate between '$ADate1' and '$ADate2' and accountname like '%$accountname%' group by patientvisitcode order by auto_number desc";
		 }
		  $exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
		  while ($res21 = mysql_fetch_array($exec21))
		  {
			  $resvisitcode=$res21['patientvisitcode'];
			  $respatientname=$res21['patientname'];
			  $respatientcode=$res21['patientcode'];
			  if($patienttype == 'cash')
			  { 
			  $paynowqry="select medicinename,quantity,amount from billing_paynowpharmacy where patientvisitcode='$resvisitcode' and amount <>'0'";
		 	  }
			  if($patienttype == 'credit')
			  { 
			  $paynowqry="select medicinename,quantity,amount from billing_paylaterpharmacy where patientvisitcode='$resvisitcode' and amount <>'0'";
		 	  }
			  $exqry=mysql_query($paynowqry);
			  $rw=mysql_num_rows($exqry);
			  if($rw>0)
			  {
		  ?>
		  
		  <tr bgcolor="#9999FF">
              <td colspan="4"  align="left" valign="center" bgcolor="#cccccc" class="bodytext31"><strong><?php echo strtoupper($respatientname); ?> (<?php echo $respatientcode;?>, <?php echo $resvisitcode; ?> )</strong></td>
              </tr>
			  
			  <?php
			 
		  while ($res31= mysql_fetch_array($exqry))
		  {
		  $res31medicinename = $res31['medicinename'];
		  $res31quantity = $res31['quantity'];
		  $res31amount = $res31['amount'];
		  
					 
						//  echo '<br>'. $res31amount .'=>';
					 $total = $total + $res31amount;
		 
		  
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
<td  align="left" valign="center" class="bodytext31">
<div class="bodytext31"><?php echo $res31medicinename; ?></div></td>

<td  align="center" valign="center" class="bodytext31"><?php echo $res31quantity; ?></td>
<td class="bodytext31" valign="center"  align="left">
<div align="right"><?php echo number_format($res31amount,2,'.',','); ?></div></td>
</tr>
			<?php
						$res31amount='';
						
			}
		 		 }
		  }
			if($total > 0)
			{	
			?>
			<tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td colspan="2"  align="left" valign="center" 
                bgcolor="#cccccc" class="bodytext31"> <strong> Total:</strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($total,2,'.',','); ?></strong></td>
            </tr>
	<?php	}
}
			//<-------------------------IP---------------------->//
			
		if($patienttype1 <>'op')
				{
					 if($patienttype == 'cash')
			  { 
				 	$ipvisitqry="select visitcode,patientfullname,patientcode from master_ipvisitentry where patientfullname like '%$searchsuppliername%' and consultationdate between '$ADate1' and '$ADate2' and billtype='PAY NOW' group by visitcode order by auto_number desc";
				
			  }
			  
			  if($patienttype == 'credit')
			  { 
				 	$ipvisitqry="select visitcode,patientfullname,patientcode from master_ipvisitentry where patientfullname like '%$searchsuppliername%' and consultationdate between '$ADate1' and '$ADate2' and billtype='PAY LATER'  and accountname like '%$accountname%' group by visitcode order by auto_number desc";
				
			  }
			 $exec211 = mysql_query($ipvisitqry) or die ("Error in ipvisitqry".mysql_error());
			 $numr=mysql_num_rows($exec211);
			 if($numr>0)
			 { 
			 ?><tr>
              <td colspan="10" class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>IP</strong></td>
              </tr>
              <?php
			 }
		  while ($res211 = mysql_fetch_array($exec211))
		  {		
			  $resvisitcode1=$res211['visitcode'];
			  $respatientname1=$res211['patientfullname'];
			  $respatientcode1=$res211['patientcode'];
			
			  $paynowqry="select medicinename,quantity,amount from billing_ippharmacy where patientvisitcode='$resvisitcode1' and amount <>'0'";
		 	 
			  $exqry=mysql_query($paynowqry);
			  $rw=mysql_num_rows($exqry);
			  if($rw>0)
			  {
		  ?>
		  
		  <tr bgcolor="#9999FF">
              <td colspan="4"  align="left" valign="center" bgcolor="#cccccc" class="bodytext31"><strong><?php echo strtoupper($respatientname1); ?> (<?php echo $respatientcode1;?>, <?php echo $resvisitcode1; ?> )</strong></td>
              </tr>
			  
			  <?php
			 
		  while ($res31= mysql_fetch_array($exqry))
		  {
		  $res31medicinename = $res31['medicinename'];
		  $res31quantity = $res31['quantity'];
		  $res31amount = $res31['amount'];
		  
					 
						//  echo '<br>'. $res31amount .'=>';
					 $total1 = $total1 + $res31amount;
		 
		  
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
<td  align="left" valign="center" class="bodytext31">
<div class="bodytext31"><?php echo $res31medicinename; ?></div></td>

<td  align="center" valign="center" class="bodytext31"><?php echo $res31quantity; ?></td>
<td class="bodytext31" valign="center"  align="left">
<div align="right"><?php echo number_format($res31amount,2,'.',','); ?></div></td>
</tr>
			<?php
						$res31amount='';
						
			}
		 		 
		  
		  }
							
				}
				
				if($total1 > 0)
			{	
			?>
			<tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td colspan="2"  align="left" valign="center" 
                bgcolor="#cccccc" class="bodytext31"> <strong> Total:</strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($total1,2,'.',','); ?></strong></td>
            </tr>
	<?php	}
				}
				
				$grandtotal=$total+$total1;
			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left"  colspan="2"
                bgcolor="#cccccc"><strong>Grand Total:</strong></td>
				 
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc"><strong><?php echo number_format($grandtotal,2,'.',','); ?></strong></td>
              
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
