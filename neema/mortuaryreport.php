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
$total = '';

if (isset($_REQUEST["accountname"])) { $accountname = $_REQUEST["accountname"]; } else { $accountname = ""; }

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

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	//$cbsuppliername = $_REQUEST['cbsuppliername'];
	//$suppliername = $_REQUEST['cbsuppliername'];
	$paymentreceiveddatefrom = $_REQUEST['ADate1'];
	$paymentreceiveddateto = $_REQUEST['ADate2'];
	$visitcode1 = 10;

}

if (isset($_REQUEST["task"])) { $task = $_REQUEST["task"]; } else { $task = ""; }
//$task = $_REQUEST['task'];
if ($task == 'deleted')
{
	$errmsg = 'Payment Entry Delete Completed.';
}

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//$paymenttype = $_REQUEST['paymenttype'];
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }

if (isset($_REQUEST["option"])) { $option = $_REQUEST["option"]; } else { $option = ""; }



//$billstatus = $_REQUEST['billstatus'];
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
.style1 {FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #3b3b3c; FONT-FAMILY: Tahoma; text-decoration: none; }
-->
</style>
<script language="javascript">

function funcPrintReceipt1(varRecAnum)
{
	var varRecAnum = varRecAnum
	//alert (varRecAnum);
	//window.open("print_bill1.php?printsource=billpage&&billautonumber="+varBillAutoNumber+"&&companyanum="+varBillCompanyAnum+"&&title1="+varTitleHeader+"&&copy1="+varPrintHeader+"&&billnumber="+varBillNumber+"","OriginalWindow<?php //echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
	window.open("print_payment_receipt1.php?receiptanum="+varRecAnum+"","OriginalWindow<?php //echo $banum; ?>",'width=722,height=950,toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=1,resizable=1,left=25,top=25');
}

function funcDeletePayment1(varPaymentSerialNumber)
{
	var varPaymentSerialNumber = varPaymentSerialNumber;
	var fRet;
	fRet = confirm('Are you sure want to delete this payment entry serial number '+varPaymentSerialNumber+'?');
	//alert(fRet);
	if (fRet == true)
	{
		alert ("Payment Entry Delete Completed.");
		//return false;
	}
	if (fRet == false)
	{
		alert ("Payment Entry Delete Not Completed.");
		return false;
	}
	//return false;
}

</script>
</head>

<script src="js/datetimepicker_css.js"></script>

<body>
<table width="2900" border="0" cellspacing="0" cellpadding="2">
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
		
		
              <form name="cbform1" method="post" action="mortuaryreport.php">
                <table width="668" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr bgcolor="#011E6A">
                      <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Mortuary Report </strong></td>
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
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Choose Option </td>
                       <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">
                		<select name="option">
                        	<option value="1" <?php if($option==1) echo "selected"; ?> >Detailed</option>
                            <option value="2" <?php if($option==2) echo "selected"; ?> >Discharged</option>
                            <option value="3" <?php if($option==3) echo "selected"; ?> >Current Bodies</option>
                            
                        </select>
                	 </td>
                     <td class="bodytext31" valign="center"  align="left" 
              		  bgcolor="#FFFFFF">&nbsp;  </td>
              			  <td class="bodytext31" valign="center"  align="left" 
               			 bgcolor="#FFFFFF">&nbsp;  </td>
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="800" 
            align="left" border="0">
          <tbody>
            <tr>
              <td width="4%" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
              <td colspan="9" bgcolor="#cccccc" class="bodytext31"><span class="bodytext311">
              <?php
				if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
					
					
					$transactiondatefrom = $_REQUEST['ADate1'];
					$transactiondateto = $_REQUEST['ADate2'];
					
					
					$urlpath = "cbcustomername=$cbcustomername&&cbbillnumber=$cbbillnumber&&cbbillstatus=$cbbillstatus&&ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";
				}
				else
				{
					$urlpath = "cbcustomername=$cbcustomername&&cbbillnumber=$cbbillnumber&&cbbillstatus=$cbbillstatus&&ADate1=$transactiondatefrom&&ADate2=$transactiondateto&&username=$username&&companyanum=$companyanum";//&&companyname=$companyname";
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
              <td width="20%" align="left" valign="left"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient Name </strong></div></td>
              <td width="11%" align="left" valign="center"  
                bgcolor="#ffffff" class="style1">Paitent Code</td>
              <td width="8%" align="left" valign="right"  
                bgcolor="#ffffff" class="style1"><div align="right"><strong>Visitcode</strong></div></td>
              <td width="11%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Package</strong></div></td>  
                <td width="6%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Shelve</strong></div></td>
                 <td width="10%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Status</strong></div></td>
                <td width="14%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Record Date</strong></div></td>  
                
                <?php 
					if($option!=3)
					{
				?>
                 <td width="16%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Discharge Date</strong></div></td>  
                <?php
					}
				?>
                
                <td width="24%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31" ><div align="right"><strong>No of days in Mortuary </strong></div></td>  
                
            </tr>
			<?php
			
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$amount = 0.00;
			$total = 0.00;	
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
		//	echo $option;
			
		
		  	 if($option==3)
		  	{
				$query2 = "select * from mortuary_allocation where dischargestatus='' and recorddate between '$transactiondatefrom' and '$transactiondateto' ";
			}
			else if($option==2)
		  	{
				$query2 = "select * from mortuary_allocation where dischargestatus='discharged' and recorddate between '$transactiondatefrom' and '$transactiondateto' ";
			}
			else
			{
				$query2 = "select * from mortuary_allocation where recorddate between '$transactiondatefrom' and '$transactiondateto' "; 			
			}
			
			
			
		    if ( $visitcode1 == 10 )
			{
				
			
		  $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		  while ($res2 = mysql_fetch_array($exec2))
		  {
     	  $patientname = $res2['patientname'];
		  $patientcode = $res2['patientcode'];
		  $visitcode = $res2['visitcode'];
		  $shelve = $res2['shelve'];
		  $package = $res2['package'];
		  $status = $res2['dischargestatus'];
		  $recorddate = $res2['recorddate'];
		  $dischargedate = $res2['dischargedate'];
		  $mdocnumber = $res2['docno'];
	 
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
                <div class="bodytext31"><?php echo $patientname; ?></div>              </td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $patientcode; ?></div>              </td>
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo $visitcode; ?></td>
               <td class="bodytext31" valign="center"  align="right">
			  <?php echo $package; ?></td>
               <td class="bodytext31" valign="center"  align="right">
			  <?php echo $shelve; ?></td>
              <td class="bodytext31" valign="center"  align="right">
			  <?php if($status!='') echo $status; else echo "In Shelve"; ?></td>
               <td class="bodytext31" valign="center"  align="right">
			  <?php echo $recorddate; ?></td>
              
              <?php
			  if($dischargedate=="0000-00-00" )
			 	{
				
				  $dischargedate='';
			  }
			  ?>
			  <?php
			  	if($option!=3)
				{
			  ?>
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo $dischargedate;  ?></td>
              <?php
		  			}
			  ?>
               <td width="24%" class="bodytext31" valign="center"  align="right">
			  <?php 
			  
				$date1=date_create($recorddate);
				$date2=date_create($dischargedate);
				$diff=date_diff($date1,$date2);
				echo $diff->format("%a");
			  
			   ?></td>
              
           </tr>
          <?php
		  if($option==1)
		  {
			  $ssno=1;
			  $query01="select * from mortuaryexternal_services where mortuarydocno='$mdocnumber' ";
			  $exec01=mysql_query($query01) or die("Error in query01");
			  $num01=mysql_num_rows($exec01);
			  if($num01>0)
			  	{?>
                <tr class="bodytext31" <?php echo $colorcode; ?>>
            		<td colspan="10">Services</td>
          		 </tr>
                 <tr <?php echo $colorcode; ?>>
            		<td class="bodytext31" bgcolor="#ffffff"><strong>Sno</strong></td>
                    <td class="bodytext31" bgcolor="#ffffff"><strong>Service code</strong></td>
                    <td class="bodytext31" colspan="2"  bgcolor="#ffffff"><strong>Service Name</strong></td>
                    <td class="bodytext31" bgcolor="#ffffff"><strong>Quatity</strong></td>
                    <td class="bodytext31" align="right"  bgcolor="#ffffff"><strong>Rate</strong></td>
                    <td class="bodytext31" align="right"  bgcolor="#ffffff"><strong>Amount</strong></td>       
                    <td class="bodytext31" align="right" colspan="3"  bgcolor="#ffffff">&nbsp;</td>                    
          		 </tr>
				<?php		
				 while ($res01 = mysql_fetch_array($exec01))
		 		 {
					 $serviceitemcode=$res01['servicesitemcode'];
					 $serviceitemname=$res01['servicesitemname'];
					  $serviceitemquantity=$res01['quantity'];
					   $serviceitemqrate=$res01['servicesitemrate'];
					 
			  ?>
	               <tr <?php echo $colorcode; ?>>
	                   <td class="bodytext31" valign="center"  align="left"><?=$ssno; ?></td>
            			<td class="bodytext31" valign="center"  align="left"><?=$serviceitemcode; ?></td>
                        <td class="bodytext31" valign="center"  align="left" colspan="2"><?= $serviceitemname; ?></td>
                        <td class="bodytext31" valign="center"  align="left"><?= $serviceitemquantity; ?></td>
                        <td class="bodytext31" valign="center"  align="right"><?= number_format($serviceitemqrate,2,'.',','); ?></td>
                        <td class="bodytext31" valign="center"  align="right"><?= number_format($serviceitemqrate*$serviceitemquantity,2,'.',','); ?></td>
                        <td colspan="4">&nbsp;   </td>
          		   </tr>
			<?php
					$ssno++;
				  }
				
				}
				  $ssno=1;
		 	 }
		  if($option==1)
		  {
		  ?>
          
           <tr class="bodytext31">
            		<td colspan="9"></td>
          		 </tr>
          
			<?php
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
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc">&nbsp; </td>
                 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc">&nbsp; </td>
                 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc">&nbsp; </td>
                 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#cccccc" colspan="3">&nbsp; </td>
            </tr>
          </tbody>
        </table></td>
      </tr>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body>
</html>

