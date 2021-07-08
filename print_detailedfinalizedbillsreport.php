<?php
//session_start();
//include ("includes/loginverify.php");
include ("db/db_connect.php");
$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d');
$paymentreceiveddatefrom = date('Y-m-d', strtotime('-1 month'));
$paymentreceiveddateto = date('Y-m-d');
$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');

$username = '';
$companyanum = '';
$companyname = '';
$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="detailedfinalizedbill.xls"');
header('Cache-Control: max-age=80');

if ($companyanum == '') //For print view.
{
	if (isset($_SESSION["username"])) { $username = $_SESSION["username"]; } else { $username = ""; }
	//$username = $_SESSION['username'];
	if (isset($_SESSION["companyanum"])) { $companyanum = $_SESSION["companyanum"]; } else { $companyanum = ""; }
	//$companyanum = $_SESSION['companyanum'];
	if (isset($_SESSION["companyname"])) { $companyname = $_SESSION["companyname"]; } else { $companyname = ""; }
	//$companyname = $_SESSION['companyname'];
	if (isset($_SESSION["financialyear"])) { $financialyear = $_SESSION["financialyear"]; } else { $financialyear = ""; }
	//$financialyear = $_SESSION['financialyear'];
}
if ($companyanum == '')  // For excel export.
{
	if (isset($_REQUEST["username"])) { $username = $_REQUEST["username"]; } else { $username = ""; }
	//$username = $_REQUEST['username'];
	if (isset($_REQUEST["companyanum"])) { $companyanum = $_REQUEST["companyanum"]; } else { $companyanum = ""; }
	//$companyanum = $_REQUEST['companyanum'];
	if (isset($_REQUEST["companyname"])) { $companyname = $_REQUEST["companyname"]; } else { $companyname = ""; }
	//$companyname = $_REQUEST['companyname'];
	if (isset($_REQUEST["financialyear"])) { $financialyear = $_REQUEST["financialyear"]; } else { $financialyear = ""; }
	//$financialyear = $_REQUEST['financialyear'];
}

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

if (isset($_REQUEST["user"])) { $searchsuppliername = $_REQUEST["user"]; } else { $searchsuppliername = ""; }

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
//$cbfrmflag1 = $_POST['cbfrmflag1'];
if ($cbfrmflag1 == 'cbfrmflag1')
{

}

if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//$paymenttype = $_REQUEST['paymenttype'];
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//$billstatus = $_REQUEST['billstatus'];
//echo $ADate2;

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
<table width="98%" border="0" cellspacing="0" cellpadding="0">
          <tbody>
            <tr>
              <td colspan="14" bgcolor="#FFFFFF" class="bodytext31">
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
					
			  	}
				?> </td>  
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff"><strong>No.</strong></td>
              <td width="7%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Visit No</strong></div></td>
              <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Bill No </strong></td>
              <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Bill Date </strong></td>
              <td width="8%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Reg No. </strong></div></td>
              <td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Patient</strong></div></td>
				<td width="15%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Payment Type</strong></div></td>
              <td width="8%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="left"><strong>Plan Name </strong></div></td>
              <td width="3%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Lab</strong></div></td>
              <td width="4%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Service</strong></div></td>
              <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Pharmacy</strong></div></td>
              <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Radiology</strong></div></td>
              <td width="6%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Consultation</strong></div></td>
              <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><div align="right"><strong>Referral</strong></div></td>
              <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Total</strong></td>
			   <td width="5%" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Username</strong></td>	
              </tr>
			<?php
			
			if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
				
				$grandtotal = 0;
			$query21 = "select * from billing_paylater where accountname like '%$searchsuppliername%' and billdate between '$ADate1' and '$ADate2' group by accountname order by accountname desc  ";
			$exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
			while ($res21 = mysql_fetch_array($exec21))
			{
			$res21accountname = $res21['accountname'];
			
			$query22 = "select * from master_accountname where accountname = '$res21accountname' and recordstatus <>'DELETED' ";
			$exec22 = mysql_query($query22) or die ("Error in Query22".mysql_error());
			$res22 = mysql_fetch_array($exec22);
			$res22accountname = $res22['accountname'];

			if( $res21accountname != '')
			{
			?>
			<tr bgcolor="#FFFFFF">
            <td colspan="15"  align="left" valign="center" bgcolor="#FFFFFF" class="bodytext31"><strong><?php echo $res22accountname;?></strong></td>
            </tr>
			
			<?php
			
			$dotarray = explode("-", $paymentreceiveddateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$paymentreceiveddateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			
		  $query1 = "select * from master_accountname where accountname = '$searchsuppliername'";
		  $exec1 = mysql_query($query1) or die ("Error in query1".mysql_error());
		  $res1 = mysql_fetch_array($exec1);
		  $res1auto_number = $res1['auto_number'];
		  $res1accountname = $res1['accountname'];
			
		  $query2 = "select * from billing_paylater where accountname = '$res21accountname' and billdate between '$ADate1' and '$ADate2' order by accountname desc "; 
		  $exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
		  while ($res2 = mysql_fetch_array($exec2))
		  {
     	  $res2accountname = $res2['accountname'];
		  $res2patientcode = $res2['patientcode'];
		  $res2visitcode = $res2['visitcode'];
		  $res2billno = $res2['billno'];
		  $res2billdate = $res2['billdate'];
		  $res2patientname = $res2['patientname'];
		  //echo $res2paymenttype = $res2['paymenttype'];
		  $res5labitemrate1 = '0.00';
		  $res6servicesitemrate1 = '0.00';
		  $res7pharmacyitemrate1 = '0.00';
		  $res8radiologyitemrate1 = '0.00';
		  $res9referalitemrate1 = '0.00';
		  $res10consultationitemrate1 = '0.00';
		  
		  $query12 = "select * from master_transactionpaylater where patientcode = '$res2patientcode' and visitcode = '$res2visitcode' and billnumber='$res2billno' and transactiontype='finalize' ";
          $exec12 = mysql_query($query12) or die ("Error in Query12".mysql_error());
		  $res12 = mysql_fetch_array($exec12);
		  $res12username = $res12['username'];
		  
		  $query10 = "select * from master_accountname where accountname = '$res2accountname'";
		  $exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());
		  $res10 = mysql_fetch_array($exec10);
		  $res10paymenttype = $res10['paymenttype'];
		  
		  $query11 = "select * from master_paymenttype where auto_number = '$res10paymenttype'";
		  $exec11 = mysql_query($query11) or die ("Error in Query11".mysql_error());
		  $res11 = mysql_fetch_array($exec11);
		  $res11paymenttype = $res11['paymenttype'];
		  
		  $query3 = "select * from master_customer where customercode = '$res2patientcode'";
		  $exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
		  $res3 = mysql_fetch_array($exec3);
		  $res3planname = $res3['planname'];
		  
		  $query4 = "select * from master_planname where auto_number = '$res3planname'";
		  $exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		  $res4 = mysql_fetch_array($exec4);
		  $res4planname = $res4['planname'];
		  
		  $query5 = "select * from billing_paylaterlab where billnumber = '$res2billno'";
		  $exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
		  while ($res5 = mysql_fetch_array($exec5))
		  {
		  $res5labitemrate = $res5['labitemrate'];
		  $res5labitemrate1 = $res5labitemrate1 + $res5labitemrate;
		  }
		  $res5labitemrate1 = number_format($res5labitemrate1,'2','.','');
		  
		  $query6 = "select * from billing_paylaterservices where billnumber = '$res2billno'";
		  $exec6 = mysql_query($query6) or die ("Error in Query6".mysql_error());
		  while ($res6 = mysql_fetch_array($exec6))
		  {
		  $res6servicesitemrate = $res6['servicesitemrate'];
		  $res6servicesitemrate1 = $res6servicesitemrate1 + $res6servicesitemrate;
		  }
		  $res6servicesitemrate1 = number_format($res6servicesitemrate1,'2','.','');
		  
		  $query7 = "select * from billing_paylaterpharmacy where billnumber = '$res2billno'";
		  $exec7 = mysql_query($query7) or die ("Error in Query7".mysql_error());
		  while ($res7 = mysql_fetch_array($exec7))
		  {
		  $res7pharmacyitemrate = $res7['amount'];
		  $res7pharmacyitemrate1 = $res7pharmacyitemrate1 + $res7pharmacyitemrate;
		  }
		  $res7pharmacyitemrate1 = number_format($res7pharmacyitemrate1,'2','.','');
		  
		  $query8 = "select * from billing_paylaterradiology where billnumber = '$res2billno'";
		  $exec8 = mysql_query($query8) or die ("Error in Query8".mysql_error());
		  while ($res8 = mysql_fetch_array($exec8))
		  {
		  $res8radiologyitemrate = $res8['radiologyitemrate'];
		  $res8radiologyitemrate1 = $res8radiologyitemrate1 + $res8radiologyitemrate;
		  }
		  $res8radiologyitemrate1 = number_format($res8radiologyitemrate1,'2','.','');
		  
		  $query9 = "select * from billing_paylaterreferal where billnumber = '$res2billno'";
		  $exec9 = mysql_query($query9) or die ("Error in Query9".mysql_error());
		  while ($res9 = mysql_fetch_array($exec9))
		  {
		  $res9referalitemrate = $res9['referalrate'];
		  $res9referalitemrate1 = $res9referalitemrate1 + $res9referalitemrate;
		  }
		  $res9referalitemrate1 = number_format($res9referalitemrate1,'2','.','');
		  
		  $query10 = "select * from billing_paylaterconsultation where billno = '$res2billno'";
		  $exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());
		  while ($res10 = mysql_fetch_array($exec10))
		  {
		  $res10consultationitemrate = $res10['totalamount'];
		  $res10consultationitemrate1 = $res10consultationitemrate1 + $res10consultationitemrate;
		  }
		  $res10consultationitemrate1 = number_format($res10consultationitemrate1,'2','.','');
		 
		  $total = $res5labitemrate1 + $res6servicesitemrate1 + $res7pharmacyitemrate1 + $res8radiologyitemrate1 + $res9referalitemrate1 + $res10consultationitemrate1;
		  $total = number_format($total,'2','.','');
		  $grandtotal = $grandtotal + $total;
		  
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
           <tr>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2visitcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
                <div class="bodytext31"><?php echo $res2billno; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <?php echo $res2billdate; ?></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientcode; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res2patientname; ?></div></td>
				<td class="bodytext31" valign="center"  align="left">
			    <div align="left"><?php echo $res11paymenttype; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="left"><?php echo $res4planname; ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res5labitemrate1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res6servicesitemrate1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res7pharmacyitemrate1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res8radiologyitemrate1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res10consultationitemrate1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left">
			  <div align="right"><?php echo number_format($res9referalitemrate1,2,'.',','); ?></div></td>
              <td class="bodytext31" valign="center"  align="left"><?php echo number_format($total,2,'.',','); ?></td>
			  <td class="bodytext31" valign="center"  align="left"><?php echo strtoupper($res12username); ?></td>
              <td class="bodytext31" valign="center"  align="left">&nbsp; </td>
              </tr>
			<?php
			$res21accountname ='';
			
			}
			
			}
			$res22accountname ='';
	        }
			
			}
			
			?>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"><div align="right"><strong> </strong></div></td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"><div align="right"><strong> </strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"><div align="right"><strong><!--Total--></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"><div align="right"><strong><?php //echo $totallab; ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"><div align="right"><strong><?php //echo $totalservices; ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"><div align="right"><strong><?php //echo $looptotalcardamount; ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"><div align="right"><strong><?php //echo $looptotalonlineamount; ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"><div align="right"><strong><?php //echo $looptotalchequeamount; ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"><div align="right"><strong><?php //echo $looptotalwriteoffamount; ?></strong></div></td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"><?php echo number_format($grandtotal,2,'.',','); ?></td>
			  <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td> 	
              </tr>
          </tbody>
        </table>