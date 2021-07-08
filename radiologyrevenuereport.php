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
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

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
$amount = '';

 $location=isset($_REQUEST['location'])?$_REQUEST['location']:'';
$locationcode1=isset($_REQUEST['location'])?$_REQUEST['location']:'';
if (isset($_REQUEST["accountname"])) { $accountname = $_REQUEST["accountname"]; } else { $accountname = ""; }

if (isset($_REQUEST["department"])) { $department = $_REQUEST["department"]; } else { $department = ""; }
//echo $department;
$query111 = "select amount from billing_paynowpharmacy where auto_number = '$department'";
$exec111 = mysql_query($query111) or die ("Error in query111".mysql_error());
$res111 = mysql_fetch_array($exec111);
$res111amount = $res111['amount'];

if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
//$getcanum = $_GET['canum'];
if ($getcanum != '')
{
	$query4 = "select suppliername from master_supplier where auto_number = '$getcanum'";
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
		
		
              <form name="cbform1" method="post" action="radiologyrevenuereport.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr bgcolor="#011E6A">
                      <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Radiology Revenue</strong></td>
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
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>
					
					<tr>
  			  <td width="10%" align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Location</td>
              <td width="30%" align="left" valign="top"  bgcolor="#FFFFFF"><span class="bodytext3">
			 
				 <select name="location" id="location" onChange="ajaxlocationfunction(this.value);">
                    <?php
						
						$query1 = "select locationname,locationcode from login_locationdetails where   username='$username' and docno='$docno' order by locationname";
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
            bordercolor="#666666" cellspacing="0" cellpadding="4" width="602" 
            align="left" border="0">
          <tbody>
		  <?php
            if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
		    if ($cbfrmflag1 == 'cbfrmflag1')
			{
			?>
            <tr>
              <td width="108"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Description</strong></td>
              <td width="154" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Amount</strong></div></td>
                
              
            </tr>
			
			<?php
			
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			


					$amount=0;
					$amount1=0;
					$ipamount=0;
					
					$query02="select sum(radiologyitemrate) as amount from  billing_paynowradiology where billdate between '$ADate1' and '$ADate2' and locationcode='$locationcode1' ";
					$exec02=mysql_query($query02) or die(mysql_error());
					if($res02=mysql_fetch_array($exec02))
						$amount+=$res02['amount'];	

					$query02="select sum(radiologyitemrate) as amount from  billing_paylaterradiology where billdate between '$ADate1' and '$ADate2' and locationcode='$locationcode1' ";
					$exec02=mysql_query($query02) or die(mysql_error());
					if($res02=mysql_fetch_array($exec02))
					 	$amount1+=$res02['amount'];
							
				  $totallopamount = $amount + $amount1;


					$query02="select sum(radiologyitemrate) as amount from  billing_ipradiology where billdate between '$ADate1' and '$ADate2' and locationcode='$locationcode1' ";
					$exec02=mysql_query($query02) or die(mysql_error());
					if($res02=mysql_fetch_array($exec02))
						$ipamount+=$res02['amount'];
		   
		  $query6647 = "select sum(radiologyitemrate) as sumrate from billing_externalradiology where locationcode='$locationcode1' and billdate between '$ADate1' and '$ADate2'";
		  $exec6647 = mysql_query($query6647) or die(mysql_error());
		  $res6647 = mysql_fetch_array($exec6647);
		  $externalrate = $res6647['sumrate'];
		  
		   $totalradiologysales = $totallopamount + $ipamount + $externalrate ;
		 
		 
		 $sumtransactionamount=0;
		 $sumtransactionamount1=0;
		 $sumtransactionamount2=0;
		  
			$query02="select sum(radiologyitemrate) as radiologyrate from refund_paynowradiology where patientvisitcode <>'walkinvis' and billdate between '$ADate1' and '$ADate2'";
			$exec02=mysql_query($query02) or die(mysql_error());
			$res02=mysql_fetch_array($exec02);
				$sumtransactionamount =$res02['radiologyrate'];	
			
		$query021="select sum(radiologyitemrate) as radiologyrate from refund_paynowradiology where patientvisitcode ='walkinvis' and billdate between '$ADate1' and '$ADate2'";
			$exec021=mysql_query($query021) or die(mysql_error());
			$res021=mysql_fetch_array($exec021);
				$sumtransactionamount1 =$res021['radiologyrate'];	
				
				
//IP Discount for radiology 

		 
		  $totallsumtransactionamount2=$sumtransactionamount+$sumtransactionamount1;
		  $nettotalamount=$totalradiologysales - $totallsumtransactionamount2;
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
              <td class="bodytext31" valign="center"  align="left"><a href="opsalesdetailed_radiology.php?locationcode=<?php echo $locationcode1;?>&&adate1=<?php echo $ADate1;?>&&adate2=<?php echo $ADate2;?>" /><strong>OP Sales</strong></td>
               <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><strong><?php echo number_format($totallopamount,2,'.',','); ?></strong></div></td>
                
            
             
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
              <td class="bodytext31" valign="center"  align="left"><a href="ipsalesdetailed_radiology.php?locationcode=<?php echo $locationcode1;?>&&adate1=<?php echo $ADate1;?>&&adate2=<?php echo $ADate2;?>" /><strong>IP Sales</strong></td>
               <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><strong><?php echo number_format($ipamount,2,'.',','); ?></strong></div></td>
                
              
             
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
              <td class="bodytext31" valign="center"  align="left"><a href="external_salesdetailed_radiology.php?locationcode=<?php echo $locationcode1;?>&&adate1=<?php echo $ADate1;?>&&adate2=<?php echo $ADate2;?>" /><strong>External Sales</strong></td>
               <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><strong><?php echo number_format($externalrate,2,'.',','); ?></strong></div></td>   
                 
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
              <td  align="left" valign="center" class="bodytext31"><strong>Total</strong></td>
               <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><strong><?php echo number_format($totalradiologysales,2,'.',','); ?></strong></div></td> 
                  
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
              <td  align="left" valign="center" class="bodytext31"><a href="opreturns_radiology.php?locationcode=<?php echo $locationcode1;?>&&adate1=<?php echo $ADate1;?>&&adate2=<?php echo $ADate2;?>" /><strong>OP Returns</strong></td>
               <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><strong>-<?php echo number_format($sumtransactionamount,2,'.',','); ?></strong></div></td>  
                
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
              <td  align="left" valign="center" class="bodytext31"><a href="externalreturns_radiology.php?locationcode=<?php echo $locationcode1;?>&&adate1=<?php echo $ADate1;?>&&adate2=<?php echo $ADate2;?>" /><strong>Ext Returns</strong></td>
               <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><strong>-<?php echo number_format($sumtransactionamount1,2,'.',','); ?></strong></div></td>
                  
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
              <td  align="left" valign="center" class="bodytext31"><strong>Total</strong></td>
               <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><strong>-<?php echo number_format($totallsumtransactionamount2,2,'.',','); ?></strong></div></td>
                  
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
              <td  align="left" valign="center" class="bodytext31"><strong>Net Total</strong></td>
               <td class="bodytext31" valign="center"  align="right">
                <div class="bodytext31"><strong><?php echo number_format($nettotalamount,2,'.',','); ?></strong></div></td>   
				<?php if($nettotalamount != 0.00) { 
				
				?>	
              <td rowspan="2" align="right" valign="center" 
			   bgcolor="#e0e0e0" class="bodytext31"><div align="left"><a target="_blank" href="print_radiologyrevenue.php?locationcode=<?php echo $locationcode1; ?>&&ADate1=<?php echo $transactiondatefrom; ?>&&ADate2=<?php echo $transactiondateto; ?>"><img src="images/excel-xls-icon.png" width="30" height="30"></a></div></td>
               <?php } ?>
				
           </tr>
       
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#cccccc">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="">&nbsp;</td>
				 <td class="bodytext31" valign="center"  align="left" 
                bgcolor="">&nbsp;</td>
 			
             
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

