<?php
require_once('html2pdf/html2pdf.class.php');
ob_start();
session_start();
include ("includes/loginverify.php");
include ("db/db_connect.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];
$updatedatetime = date('Y-m-d H:i:s');
$username = $_SESSION['username'];
$companyanum = $_SESSION['companyanum'];
$companyname = $_SESSION['companyname'];
$currentdate = date("Y-m-d");
$searchcustomername = '';
$patientfirstname = '';
$visitcode = '';
$customername = '';
$cbcustomername = '';
$cbbillnumber = '';
$cbbillstatus = '';
$customername = '';
$paymenttype = '';
$billstatus = '';
$res2loopcount = '';
$custid = '';
$visitcode1='';
$res2username ='';
$custname = '';
$colorloopcount = '';
$sno = '';
$customercode = '';
$totalsalesamount = '0.00';
$totalsalesreturnamount = '0.00';
$netcollectionamount = '0.00';
$netpaymentamount = '0.00';
$res2total = '0.00';
$cashamount = '0.00';
$cardamount = '0.00';
$chequeamount = '0.00';
$onlineamount = '0.00';
$total = '0.00';
$cashtotal = '0.00';
$cardtotal = '0.00';
$chequetotal = '0.00';
$onlinetotal = '0.00';
$credittotal = '0.00';
$res2cashamount1 ='';
$res2cardamount1 = '';
$res2chequeamount1 = '';
$res2onlineamount1 ='';
$res2creditamount1 ='';
$cashamount2 = '0.00';
$cardamount2 = '0.00';
$chequeamount2 = '0.00';
$onlineamount2 = '0.00';
$creditamount2 = '0.00';
$total1 = '0.00';

$transactiondatefrom = date('Y-m-d', strtotime('-1 month'));
$transactiondateto = date('Y-m-d');
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//$paymenttype = $_REQUEST['paymenttype'];
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
include ("autocompletebuild_users.php");
$cbcustomername = isset( $_REQUEST['user'])?$_REQUEST['user']:'';
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


if (isset($_REQUEST["canum"])) { $getcanum = $_REQUEST["canum"]; } else { $getcanum = ""; }
$locationcode=isset($_REQUEST['locationcode'])?$_REQUEST['locationcode']:'';
//$getcanum = $_GET['canum'];

if ($getcanum != '')
{
	$query4 = "select * from master_customer where auto_number = '$getcanum'";
	$exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
	$res4 = mysql_fetch_array($exec4);
	$cbcustomername = $res4['customername'];
	$customername = $res4['customername'];
}

if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }

$usernam = $_REQUEST['user'];

$query141 = "select billnumber from master_transactionpaynow where locationcode='$locationcode' and username = '$usernam' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";
			$exe141 = mysql_query($query141) or die("Error in Query141".mysql_error());
		    $num11 = mysql_num_rows($exe141);
			//echo $num1;
			$res141 = mysql_fetch_array($exe141);
			//$res41billnumber1 = $res41['billnumber1'];
			//echo $res41billnumber1;
			
			$query151 = "select billnumber from master_transactionexternal where locationcode='$locationcode' and username = '$usernam' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";
			$exe151 = mysql_query($query151) or die("Error in Query151".mysql_error());
			$num12 = mysql_num_rows($exe151);
			$res151 = mysql_fetch_array($exe151);
			
			$query161 = "select billnumber from master_billing where locationcode='$locationcode' and username = '$usernam' and billingdatetime between '$transactiondatefrom' and '$transactiondateto'";
			$exe161 = mysql_query($query161) or die("Error in Query161".mysql_error());
			$num13 = mysql_num_rows($exe161);
			$res161 = mysql_fetch_array($exe161);
			
			$query171 = "select billnumber from refund_paynow where locationcode='$locationcode' and username = '$usernam' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";
			$exe171 = mysql_query($query171) or die("Error in Query171".mysql_error());
			$num14 = mysql_num_rows($exe171);
			$res171 = mysql_fetch_array($exe171);
			
			$query181 = "select * from receiptsub_details where locationcode='$locationcode' and username = '$usernam' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";
			$exe181 = mysql_query($query181) or die("Error in Query181".mysql_error());
			$num15 = mysql_num_rows($exe181);
			$res181 = mysql_fetch_array($exe181);
			
			$query191 = "select * from master_transactionadvancedeposit where locationcode='$locationcode' and username like '%$usernam%' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";
			$exe191 = mysql_query($query191) or die("Error in Query191".mysql_error());
			$num16 = mysql_num_rows($exe191);
			$res191 = mysql_fetch_array($exe191);
			
			$query1101 = "select * from master_transactionipdeposit where locationcode='$locationcode' and username like '%$usernam%' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";
			$exe1101 = mysql_query($query1101) or die("Error in Query1101".mysql_error());
			$num17 = mysql_num_rows($exe1101);
			$res1101 = mysql_fetch_array($exe1101);
			
			$query1111 = "select * from master_transactionip where locationcode='$locationcode' and username like '%$usernam%' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";
			$exe1111 = mysql_query($query1111) or die("Error in Query1111".mysql_error());
			$num18 = mysql_num_rows($exe1111);
			$res1111 = mysql_fetch_array($exe1111);
			
			$query1121 = "select * from master_transactionipcreditapproved where username like '%$usernam%' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";
			$exe1121 = mysql_query($query1121) or die("Error in Query1121".mysql_error());
			$num19 = mysql_num_rows($exe1121);
			$res1121 = mysql_fetch_array($exe1121);
			
			$numbills1 = $num11 + $num12 + $num13 + $num14 + $num15 + $num16 + $num17 + $num18 + $num19;
?>
<table width="673" height="352" border="0" align="center" cellpadding="4" cellspacing="0" >
           <tr>
             <td colspan="7">&nbsp;</td>
           </tr>
           <tr>
             <td colspan="7">&nbsp;</td>
           </tr>
           <tr>
<?php 
$query2 = "select * from master_company where locationcode='$locationcode' and auto_number = '$companyanum'";
$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
$res2 = mysql_fetch_array($exec2);
$companyname = $res2["companyname"];
$address1 = $res2["address1"];
$address2 = $res2["address2"];
$area = $res2["area"];
$city = $res2["city"];
$pincode = $res2["pincode"];
$phonenumber1 = $res2["phonenumber1"];
$phonenumber2 = $res2["phonenumber2"];
$tinnumber1 = $res2["tinnumber"];
$cstnumber1 = $res2["cstnumber"];
?>
			<td colspan="7">
			  <div align="center">
			    <?php
			$strlen2 = strlen($companyname);
			$totalcharacterlength2 = 35;
			$totalblankspace2 = 35 - $strlen2;
			$splitblankspace2 = $totalblankspace2 / 2;
			for($i=1;$i<=$splitblankspace2;$i++)
			{
			$companyname = ' '.$companyname.' ';
			}
			?>			
	        </div></td>
  </tr>
		<tr>
			<td colspan="7"><div align="center"><?php echo $companyname; ?>
		      <?php
			$strlen3 = strlen($address1);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address1 = ' '.$address1.' ';
			}
			?>			
		    </div></td>
		</tr>
		<tr>
			<td colspan="7"><div align="center"><?php echo $address1; ?>
		      <?php
			$address2 = $area.''.$city.' '.$pincode.'';
			$strlen3 = strlen($address2);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address2 = ' '.$address2.' ';
			}
			?>			
		    </div></td>
		</tr>
		<tr>
			<td colspan="7">
			
			  <div align="center"><?php echo $address2; ?>
		        <?php
			$address3 = "PHONE: ".$phonenumber1.' '.$phonenumber2;
			$strlen3 = strlen($address3);
			$totalcharacterlength3 = 35;
			$totalblankspace3 = 35 - $strlen3;
			$splitblankspace3 = $totalblankspace3 / 2;
			for($i=1;$i<=$splitblankspace3;$i++)
			{
			$address3 = ' '.$address3.' ';
			}
			?>			
	        </div></td>
		</tr>
            <tr>
              <td colspan="7"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="7"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><div align="center"><strong>Collections Summary By User </strong></div></td>
            </tr>
            <tr>
              <td colspan="7"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="7"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong>User: <?php echo strtoupper ($usernam);?> (<?php echo $numbills1; ?>)</strong></td>
            </tr>
            <tr>
              <td colspan="7"  align="left" valign="center" bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
            </tr>
            <tr>
              <td width="2%"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
              <td width="7%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Cash </strong></td>
              <td width="7%" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Card </strong></td>
              <td width="7%"  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong> Cheque </strong></td>
				<td width="7%"  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong> Online </strong></td>
                <td width="7%"  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong> MPESA </strong></td>
              <td width="7%"  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Total </strong></td>
  </tr>
			  <?php
			 
			  if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
				//$cbfrmflag1 = $_REQUEST['cbfrmflag1'];
				if ($cbfrmflag1 == 'cbfrmflag1')
				{
			$cbcustomername=trim($cbcustomername);
			$query21 = "select * from master_transactionpaynow where locationcode='$locationcode' and username like '%$cbcustomername%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' group by username";//   order by transactiondate desc";
		
			$exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
				mysql_num_rows($exec21);
			while ($res21 = mysql_fetch_array($exec21)) 
			{
			 //$res21employeename = $res21['employeename'];
			 $res21username = $res21['username'];
			 
			$query31 = "select* from master_employee where locationcode='$locationcode' and username = '$res21username' and status <>'DELETED'";
			$exe31 = mysql_query($query31) or die("Error in Query31".mysql_error());
			$res31 = mysql_fetch_array($exe31);
			$res3username = $res31["username"];
			 
			$query41 = "select billnumber from master_transactionpaynow where locationcode='$locationcode' and username = '$res3username' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";
			$exe41 = mysql_query($query41) or die("Error in Query41".mysql_error());
		    $num1 = mysql_num_rows($exe41);
			//echo $num1;
			$res41 = mysql_fetch_array($exe41);
			//$res41billnumber1 = $res41['billnumber1'];
			//echo $res41billnumber1;
			
			$query51 = "select billnumber from master_transactionexternal where locationcode='$locationcode' and username = '$res3username' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";
			$exe51 = mysql_query($query51) or die("Error in Query51".mysql_error());
			$num2 = mysql_num_rows($exe51);
			$res51 = mysql_fetch_array($exe51);
			
			$query61 = "select billnumber from master_billing where locationcode='$locationcode' and username = '$res3username' and billingdatetime between '$transactiondatefrom' and '$transactiondateto'";
			$exe61 = mysql_query($query61) or die("Error in Query61".mysql_error());
			$num3 = mysql_num_rows($exe61);
			$res61 = mysql_fetch_array($exe61);
			
			$query71 = "select billnumber from refund_paynow where locationcode='$locationcode' and username = '$res3username' and transactiondate between '$transactiondatefrom' and '$transactiondateto'";
			$exe71 = mysql_query($query71) or die("Error in Query71".mysql_error());
			$num4 = mysql_num_rows($exe71);
			$res71 = mysql_fetch_array($exe71);
			
			$numbills = $num1 + $num2 + $num3 + $num4;
			
			 if( $res21username != '')
			{
			?>
			

			<?php
			 
			$dotarray = explode("-", $transactiondateto);
			$dotyear = $dotarray[0];
			$dotmonth = $dotarray[1];
			$dotday = $dotarray[2];
			$transactiondateto = date("Y-m-d", mktime(0, 0, 0, $dotmonth, $dotday + 1, $dotyear));
			
			
			$query2 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(chequeamount) as chequeamount1, sum(creditamount) as creditamount1, sum(onlineamount) as onlineamount1 from master_transactionpaynow where locationcode='$locationcode' and username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' group by username";
			$exec2 = mysql_query($query2) or die ("Error in Query2".mysql_error());
	        $res2 = mysql_fetch_array($exec2);
			$res2cashamount1 = $res2['cashamount1'];
			$res2cardamount1 = $res2['cardamount1'];
			$res2chequeamount1 = $res2['chequeamount1'];
			$res2onlineamount1 = $res2['onlineamount1'];
			$res2creditamount1 = $res2['creditamount1'];
			
		  $query3 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionexternal where locationcode='$locationcode' and username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' group by username"; 
		  $exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
		  $res3 = mysql_fetch_array($exec3);
		  
     	  $res3cashamount1 = $res3['cashamount1'];
		  $res3onlineamount1 = $res3['onlineamount1'];
		  $res3creditamount1 = $res3['creditamount1'];
		  $res3chequeamount1 = $res3['chequeamount1'];
		  $res3cardamount1 = $res3['cardamount1'];
		  
		  $query4 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_billing where locationcode='$locationcode' and username = '$res21username' and billingdatetime between '$transactiondatefrom' and '$transactiondateto' group by username"; 
		  $exec4 = mysql_query($query4) or die ("Error in Query4".mysql_error());
		  $res4 = mysql_fetch_array($exec4);
		  
     	 $res4cashamount1 = $res4['cashamount1'];
		 $res4onlineamount1 = $res4['onlineamount1'];
		 $res4creditamount1 = $res4['creditamount1'];
		 $res4chequeamount1 = $res4['chequeamount1'];
		 $res4cardamount1 = $res4['cardamount1'];
		  
		  $query5 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from refund_paynow where locationcode='$locationcode' and username = '$res21username' and transactiondate between '$transactiondatefrom' and '$transactiondateto' group by username"; 
		  $exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
		  //$num = mysql_num_rows($exec5);
		  //echo $num;
		  $res5 = mysql_fetch_array($exec5);
		  
     	  $res5cashamount1 = $res5['cashamount1'];
		  $res5onlineamount1 = $res5['onlineamount1'];
		  $res5creditamount1 = $res5['creditamount1'];
		  $res5chequeamount1 = $res5['chequeamount1'];
		  $res5cardamount1 = $res5['cardamount1'];
		  
		 $query6 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionadvancedeposit where locationcode='$locationcode' and username like '%$res21username%' and transactiondate between '$transactiondatefrom' and '$transactiondateto'"; 
		  $exec6 = mysql_query($query6) or die ("Error in Query5".mysql_error());
		  $res6 = mysql_fetch_array($exec6);
		  
     	  $res6cashamount1 = $res6['cashamount1'];
		  $res6onlineamount1 = $res6['onlineamount1'];
		  $res6creditamount1 = $res6['creditamount1'];
		  $res6chequeamount1 = $res6['chequeamount1'];
		  $res6cardamount1 = $res6['cardamount1'];

		  $query7 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionipdeposit where locationcode='$locationcode' and username like '%$res21username%' and transactiondate between '$transactiondatefrom' and '$transactiondateto'"; 
		  $exec7 = mysql_query($query7) or die ("Error in Query5".mysql_error());
		  $res7 = mysql_fetch_array($exec7);
		  
     	  $res7cashamount1 = $res7['cashamount1'];
		  $res7onlineamount1 = $res7['onlineamount1'];
		  $res7creditamount1 = $res7['creditamount1'];
		  $res7chequeamount1 = $res7['chequeamount1'];
		  $res7cardamount1 = $res7['cardamount1'];
		  
		  $query8 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionip where locationcode='$locationcode' and username like '%$res21username%' and transactiondate between '$transactiondatefrom' and '$transactiondateto'"; 
		  $exec8 = mysql_query($query8) or die ("Error in Query5".mysql_error());
		  $res8 = mysql_fetch_array($exec8);
		  
     	  $res8cashamount1 = $res8['cashamount1'];
		  $res8onlineamount1 = $res8['onlineamount1'];
		  $res8creditamount1 = $res8['creditamount1'];
		  $res8chequeamount1 = $res8['chequeamount1'];
		  $res8cardamount1 = $res8['cardamount1'];
		  
    	  $query9 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from master_transactionipcreditapproved where locationcode='$locationcode' and username like '%$res21username%' and transactiondate between '$transactiondatefrom' and '$transactiondateto'"; 
		  $exec9 = mysql_query($query9) or die ("Error in Query5".mysql_error());
		  $res9 = mysql_fetch_array($exec9);
		  
     	  $res9cashamount1 = $res9['cashamount1'];
		  $res9onlineamount1 = $res9['onlineamount1'];
		  $res9creditamount1 = $res9['creditamount1'];
		  $res9chequeamount1 = $res9['chequeamount1'];
		  $res9cardamount1 = $res9['cardamount1'];
		  
		  $query10 = "select sum(cashamount) as cashamount1, sum(cardamount) as cardamount1, sum(onlineamount) as onlineamount1, sum(creditamount) as creditamount1, sum(chequeamount) as chequeamount1 from receiptsub_details where locationcode='$locationcode' and username like '%$res21username%' and transactiondate between '$transactiondatefrom' and '$transactiondateto' group by username"; 
		  $exec10 = mysql_query($query10) or die ("Error in Query10".mysql_error());
		  //$num = mysql_num_rows($exec5);
		  //echo $num;
		  $res10 = mysql_fetch_array($exec10);
		  
     	  $res10cashamount1 = $res10['cashamount1'];
		  $res10onlineamount1 = $res10['onlineamount1'];
		  $res10creditamount1 = $res10['creditamount1'];
		  $res10chequeamount1 = $res10['chequeamount1'];
		  $res10cardamount1 = $res10['cardamount1'];
		  
		  $cashamount = $res2cashamount1 + $res3cashamount1 + $res4cashamount1 + $res6cashamount1 + $res7cashamount1 + $res8cashamount1 + $res9cashamount1 + $res10cashamount1;
		  $cardamount = $res2cardamount1 + $res3cardamount1 + $res4cardamount1 + $res6cardamount1 + $res7cardamount1 + $res8cardamount1 + $res9cardamount1 + $res10cardamount1;
		  $chequeamount = $res2chequeamount1 + $res3chequeamount1 + $res4chequeamount1 + $res6chequeamount1 + $res7chequeamount1 + $res8chequeamount1 + $res9chequeamount1 + $res10chequeamount1;
		  $onlineamount = $res2onlineamount1 + $res3onlineamount1 + $res4onlineamount1 + $res6onlineamount1 + $res7onlineamount1 + $res8onlineamount1 + $res9onlineamount1 + $res10onlineamount1;
		  $creditamount = $res2creditamount1 + $res3creditamount1 + $res4creditamount1 + $res6creditamount1 + $res7creditamount1 + $res8creditamount1 + $res9creditamount1 + $res10creditamount1;
		  		  
		  $cashamount1 = $cashamount - $res5cashamount1;
		  $cardamount1 = $cardamount - $res5cardamount1;
		  $chequeamount1 = $chequeamount - $res5chequeamount1;
		  $onlineamount1 = $onlineamount - $res5onlineamount1;
		   $creditamount1 = $creditamount - $res5creditamount1;
		  
		  $cashamount2 = $cashamount2 + $cashamount1;
		  $cardamount2 = $cardamount2 + $cardamount1;
		  $chequeamount2 = $chequeamount2 + $chequeamount1;
		  $onlineamount2 = $onlineamount2 + $onlineamount1;
		  $creditamount2 = $creditamount2 + $creditamount1;
		   
		  $total = $cashamount1 + $onlineamount1 + $chequeamount1 + $cardamount1 + $creditamount1;
		  
		  $total1 = $total1 + $total;
			
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
              <td class="bodytext31" valign="center"  align="left"><?php echo $sno = $sno + 1; ?></td>
              <td class="bodytext31" valign="center"  align="right">
                <?php echo number_format($cashamount1,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right"><?php echo number_format($cardamount1,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right">
              <?php echo number_format($chequeamount1,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right">
              <?php echo number_format($onlineamount1,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right">
              <?php echo number_format($creditamount1,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right">
              <?php echo number_format($total, 2,'.',','); ?></td>
  </tr>
			<?php
			}
			}
			}
			?>
            
			<tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#FFFFFF">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#FFFFFF">&nbsp;</td>
            </tr>
            <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#FFFFFF"><strong>Total:</strong></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#FFFFFF"><?php echo number_format($cashamount2,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#FFFFFF"><?php echo number_format($cardamount2,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#FFFFFF"><?php echo number_format($chequeamount2,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#FFFFFF"><?php echo number_format($onlineamount2,2,'.',',');?></td>
                <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#FFFFFF"><?php echo number_format($creditamount2,2,'.',',');?></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#FFFFFF"><?php echo number_format($total1,2,'.',',');?></td> 
  </tr>
</table>
<?php

    $content = ob_get_clean();

    // convert in PDF
    require_once('html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
//      $html2pdf->setModeDebug();
        //$html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('paymentmodecollectionuser.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>

