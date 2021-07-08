<?php
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");
set_time_limit(0);

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$docno=$_SESSION['docno'];
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
$temp = '' ;	




if (isset($_REQUEST["accountname"])) { $accountname = $_REQUEST["accountname"]; } else { $accountname = ""; }
 if (isset($_REQUEST["employeeusername"])) { $employeeusername = $_REQUEST["employeeusername"]; } else { $employeeusername = ""; }

 if (isset($_REQUEST["employee"])) { $employee = $_REQUEST["employee"]; } else { $employee = ""; }


if (isset($_REQUEST["consultingdoctor"])) { $consultingdoctor = $_REQUEST["consultingdoctor"]; } else { $consultingdoctor = ""; }
  $locationcode=isset($_REQUEST['locationdetail'])?$_REQUEST['locationdetail']:'';

$query111 = "select doctorname from master_doctor where auto_number = '$consultingdoctor'";
$exec111 = mysql_query($query111) or die ("Error in query111".mysql_error());
$res111 = mysql_fetch_array($exec111);
$res111doctorname = $res111['doctorname'];

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
.ui-menu .ui-menu-item{ zoom:1 !important; }

</style>
<link href="css/datepickerstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/adddate.js"></script>
<script type="text/javascript" src="js/adddate2.js"></script>
<link href="autocomplete.css" rel="stylesheet">
<script src="js/jquery.min-autocomplete.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script language="javascript">

function cbsuppliername1()
{
	document.cbform1.submit();
}



$(function() {
	
$('#employee').autocomplete({
		
	source:'ajaxemployeesearch.php', 
	minLength:1,
	delay: 0,
	html: true, 
		select: function(event,ui){
			var code = ui.item.id;
			var employeeusername = ui.item.employeeusername;
			$('#employeeusername').val(employeeusername);
			}
    });
});

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
		
		
              <form name="cbform1" method="post" action="doctorutilizationreport.php">
                <table width="600" border="0" align="left" cellpadding="4" cellspacing="0" bordercolor="#666666" id="AutoNumber3" style="border-collapse: collapse">
                  <tbody>
                    <tr bgcolor="#011E6A">
                      <td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><strong>Doctor Utilization Report</strong></td>
                      <!--<td colspan="2" bgcolor="#CCCCCC" class="bodytext3"><?php echo $errmgs; ?>&nbsp;</td>-->
                      <td bgcolor="#CCCCCC" class="bodytext3" colspan="2">&nbsp;</td>
                    </tr>
					<tr>
			 <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">Consulting Doctor </td>
				  <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
				  	<input type="text" size="40" name="employee" id="employee" value="<?= $employee; ?>" />
                    <input type="hidden" size="40" name="employeeusername" id="employeeusername" value="<?= $employeeusername; ?>" />
				  </td>
			</tr>
            <tr>
            <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Location </td>
                <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
			<select name="locationdetail" id="locationdetail" ><option value="all">All</option>
             <?php
			 $locationdetail="select locationname,locationcode from master_location where status <>'deleted' "; 
			 $exeloc=mysql_query($locationdetail);
			 while($resloc=mysql_fetch_array($exeloc))
			 {
			 ?>
             <option value="<?= $resloc['locationcode'] ?>"><?= $resloc['locationname'] ?></option>
             <?php
			 } ?>
             </select>
             </td>
            </tr>
                    <tr>
                      <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"> Date From </td>
                      <td width="30%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"><input name="ADate1" id="ADate1" style="border: 1px solid #001E6A" value="<?php echo $paymentreceiveddatefrom; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                          <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate1')" style="cursor:pointer"/> </td>
                      <td width="16%" align="left" valign="center"  bgcolor="#FFFFFF" class="bodytext31"> Date To </td>
                      <td width="33%" align="left" valign="center"  bgcolor="#FFFFFF"><span class="bodytext31">
                        <input name="ADate2" id="ADate2" style="border: 1px solid #001E6A" value="<?php echo $paymentreceiveddateto; ?>"  size="10"  readonly="readonly" onKeyDown="return disableEnterKey()" />
                        <img src="images2/cal.gif" onClick="javascript:NewCssCal('ADate2')" style="cursor:pointer"/> </span></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"  bgcolor="#FFFFFF" class="bodytext3">&nbsp;</td>
                      <td colspan="3" align="left" valign="top"  bgcolor="#FFFFFF">
					  <input type="hidden" name="cbfrmflag1" value="cbfrmflag1">
                          <input  style="border: 1px solid #001E6A" type="submit" value="Search" name="Submit" />
                          <input name="resetbutton" type="reset" id="resetbutton"  style="border: 1px solid #001E6A" value="Reset" /></td>
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
            <!--<tr>
			<td width="5%" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
              <td colspan="30" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
            </tr>
			<tr>
			<td bgcolor="#ffffff">&nbsp;</td>
			</tr>-->
			<?php 
		  
		  
		  //print_r($paymenttypename); 
		  
		  ?>
		  
		  <?php 
		  if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
		 
		  
//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

	if($employeeusername == "")

{
	 $emp='AHC';
	 if($locationcode == 'all')
	 {
	 $query15 = "select username from master_consultationlist where department like '%$emp%' group by username";
	 }
	 else
	 {
		 $query15 = "select username from master_consultationlist where department like '%$emp%' and locationcode='$locationcode' group by username";
	 }
	$exec15 = mysql_query($query15) or die ("Error in Query15".mysql_error());
}
else
{if($locationcode == 'all')
	 {
	$query15 = "select username from master_consultationlist where username like '%$employeeusername%' group by username";
	 }
	 else
	 {
		$query15 = "select username from master_consultationlist where username like '%$employeeusername%' and locationcode='$locationcode' group by username"; 
		 }
		  $exec15 = mysql_query($query15) or die ("Error in Query15".mysql_error());
}
		  while ($res15 = mysql_fetch_array($exec15))
		  {


		   $doctorname = $res15['username'];
		
		  $username1 =  $res15['username'];
		  
		  
		  $query6 = "select employeename from master_employee where username='$username1'";
		 $exec6 = mysql_query($query6) or die(mysql_error());
		 $res6 = mysql_fetch_array($exec6);
		 $employeename = $res6['employeename'];
		  
		  $paymenttypename = array();
			$billcount='0';
			$averagecost='0.00';
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$totalcashamount = '0.00';
			$revenueamountfinal = '0.00';
			$billnumberamountfinal = '0.00';
			$averagecostfinal = '0.00';
			$billcountfinal=array();
			$billnumbercount ='0.00';
			$revenueamount='0.00';
			
		   $paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));

		  $revenueamountfinal = array();
		  $billnumberamountfinal = array();
		  $averagecostfinal = array();
	 		$billcount='0.00';
		
		$aacount=0;
		$sub_t=array();	
		  
		  $query21 = "select auto_number,paymenttype from master_paymenttype where recordstatus <> 'deleted'"; 
		  $exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
		  while ($res21 = mysql_fetch_array($exec21))
		  {
		   $res21paymenttype = $res21['paymenttype'];
		   $res2auto_number = $res21['auto_number']; 
		  array_push($paymenttypename, $res21paymenttype);
		    $res5totalamount = '0';
			$sub_t[$aacount++]=0;
			  
			// if($res2auto_number<>'1')
			  if(1){

			if($locationcode == 'all')
			{	  
//	 	 $query0="select visitcode from master_visitentry where paymenttype='$res2auto_number' and consultationdate between '$ADate1' and '$ADate2'  and billtype='PAY LATER' and visitcode in (select patientvisitcode from master_consultation where consultationform='1' and recorddate between '$ADate1' and '$ADate2' and username='$employeename' order by auto_number desc)  order by auto_number desc";
	 	 $query0="select visitcode,billtype from master_visitentry where paymenttype='$res2auto_number' and consultationdate between '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where consultationform='1' and recorddate between '$ADate1' and '$ADate2' and username='$employeename' order by auto_number desc)  order by auto_number desc";

			}
			else
			{
		//	 	$query0="select visitcode from master_visitentry where paymenttype='$res2auto_number' and consultationdate between '$ADate1' and '$ADate2'  and billtype='PAY LATER' and visitcode in (select patientvisitcode from master_consultation where consultationform='1' and recorddate between '$ADate1' and '$ADate2' and username='$employeename' and locationcode='$locationcode' order by auto_number desc)  order by auto_number desc";
			 	$query0="select visitcode,billtype from master_visitentry where paymenttype='$res2auto_number' and consultationdate between '$ADate1' and '$ADate2' and visitcode in (select patientvisitcode from master_consultation where consultationform='1' and recorddate between '$ADate1' and '$ADate2' and username='$employeename' and locationcode='$locationcode' order by auto_number desc)  order by auto_number desc";
			}
			$exequery0=mysql_query($query0)or die("Error in Query0".mysql_error());
			$billcount=mysql_num_rows($exequery0);
			if($billcount>0)
			//{
			while($resquery0=mysql_fetch_array($exequery0))
			{
			$visitcode=$resquery0['visitcode'];
		
			if($resquery0['billtype']=="PAY NOW"){
			    goto l1;
                         }

			  $query5 = "select sum(transactionamount) as transactionamount1 from master_transactionpaylater where visitcode = '$visitcode' and transactiontype = 'finalize' and transactionamount <>'0.00' "; 
			  $exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
			  $res5 = mysql_fetch_array($exec5);
			  $res5totalamount += $res5['transactionamount1'];
			}
			   $revenueamount =  $res5totalamount;
			   
			   if($billcount != 0)
			  {
			  $averagecost = $revenueamount/$billcount;
			  }
			  else 
			  {
			  $averagecost = $revenueamount/1;
			  }
			  
			  } 
			  else
			  {
				  $billcount='0.00';
				  $revenueamount='0.00';
				  $billnumbercount='0.00';
				  $averagecost='0.00';
			  }
			l1:
			 array_push($billcountfinal, $billcount);
			 array_push($revenueamountfinal, $revenueamount);
			 array_push($billnumberamountfinal, $billnumbercount);
 			 array_push($averagecostfinal,$averagecost);
		  }
			
		 $value = max($revenueamountfinal);
		 if($value>0)
		 { 
		  ?>
		  <tr>
			<td width="30%" bgcolor="#cccccc" class="bodytext31"><strong>
<a target="_blank" href="doctorutilizationreportdetailed.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&employeename=<?php echo $doctorname; ?>"><?php echo $employeename; ?></a></strong></td>
              <td colspan="30" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
              <?php
              	if($temp==""){
					?>
                   <td class="bodytext31" valign="top" bgcolor="#E0E0E0" align="left"> 
                 <a target="_blank" href="print_doctorutilizationreport.php?ADate1=<?php echo $ADate1; ?>&&ADate2=<?php echo $ADate2; ?>&&employeename=<?php echo $employeeusername; ?>&&location=<?= $locationcode;?>"> <img src="images/pdfdownload.jpg" width="30" height="30"></a> 
                </td>
				<?php
				$temp = $temp+1;	
				}
			  ?> 
            </tr>
			<tr>
			<td bgcolor="#ffffff">&nbsp;</td>
		  <?php
		  $paycount=count($paymenttypename);
			for($i=0;$i<$paycount;$i++)
			{
		 $paytypevalue=$paymenttypename[$i];
		
		  ?>
		 
		  <td class="bodytext31" valign="center"  align="left" bgcolor="#ffffff"><strong><?php echo $paytypevalue; ?></strong></td>
		  <?php 
		  }
	      ?>	
		 </tr>
		  <tr>
		  <td class="bodytext31" valign="center"  align="left" bgcolor="#D3EEB7"><strong>Revenue</strong></td> 
		  
		  <?php
			
		  	
			$revenue=count($revenueamountfinal);
			for($i=0;$i<$revenue;$i++)
			{
		 $revenuevalue=$revenueamountfinal[$i];
		$sub_t[$i]+=$revenuevalue;
																																																														
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
		  <td class="bodytext31" valign="center"  align="left" bgcolor="#D3EEB7"><strong><?php  echo number_format($revenuevalue,2,'.',','); ?></strong></td>	
			<?php
			}
			?>
			</tr>
		    <tr>
		   <td class="bodytext31" valign="center"  align="left" bgcolor="#CBDBFA"><strong>No.</strong></td>	
		    <?php
			$bill=count($billcountfinal);
			for($i=0;$i<$bill;$i++)
			{
		  $billvalue=$billcountfinal[$i];
$sub_t[$i]+=$billvalue;
		
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
		  <td class="bodytext31" valign="center"  align="left" bgcolor="#CBDBFA"><strong><?php  echo number_format($billvalue,2,'.',','); ?></strong></td>	
			<?php
			}
			?>	 
			</tr>
			 <tr>
		   <td class="bodytext31" valign="center"  align="left" bgcolor="#D3EEB7"><strong>Avg Cost</strong></td>		 
	
			 <?php
			
			
		  $avg=count($averagecostfinal);
			for($i=0;$i<$avg;$i++)
			{
		  $avgvalue=$averagecostfinal[$i];
$sub_t[$i]+=$avgvalue;
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
		  <td class="bodytext31" valign="center"  align="left" bgcolor="#D3EEB7"><strong><?php  echo number_format($avgvalue,2,'.',','); ?></strong></td>	
			<?php
			}
			?>
			</tr>	 
			<tr>		
		   <td class="bodytext31" valign="center"  align="left" bgcolor="#D3EEB7"><strong>Sub Total</strong></td>		 

		<?php
			


		  $paycount=count($paymenttypename);
			for($i=0;$i<$paycount;$i++)
			{?>

		  <td class="bodytext31" valign="center"  align="left" bgcolor="#D3EEB7"><strong><?php  echo number_format($sub_t[$i],2,'.',','); ?></strong></td>	
		<?php	}
			}
}
}
			?>
		  </tr> 
            <tr>
              <td colspan="30" bgcolor="#cccccc" class="bodytext31">&nbsp;</td>
            </tr>
          </tbody>
          </table>
            </td>
    </table>
</table>
<?php include ("includes/footer1.php"); ?>
</body></html>

