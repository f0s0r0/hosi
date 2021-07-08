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

$errmsg = "";
$banum = "1";
$supplieranum = "";
$custid = "";
$custname = "";
$balanceamount = "0.00";
$openingbalance = "0.00";
$total = '0.00';
$totalat = '0.00';
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$range = "";
$doctorname = '';
$arraysuppliercode = '';	
$totalatret = 0.00;

$totalamount30 = 0;
$totalamount60 = 0;
$totalamount90 = 0;
$totalamount120 = 0;
$totalamount180 = 0;
$totalamountgreater = 0;
		  
if (isset($_REQUEST["code"])) { $code = $_REQUEST["code"]; } else { $code = ""; }
//echo $code;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//echo $ADate2;

	$querydoc = "SELECT * FROM master_doctor WHERE doctorcode = '".$code."' and status <> 'Deleted'";
	$execdoc = mysql_query($querydoc) or die("Error in querydoc ".mysql_error());
	$resdoc = mysql_fetch_array($execdoc);
	$doctorname = $resdoc['doctorname'];
	$arraysuppliercode = $resdoc['doctorcode'];
	$locationcode = $resdoc['locationcode'];
//header location
	$query1 = "select * from login_locationdetails where username='$username' and docno='$docno' group by locationname order by locationname ";
	$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
	$res1 = mysql_fetch_array($exec1);
	
 	$locationname = $res1["locationname"];
	$locationcode = $res1["locationcode"];
	$query3 = "select * from master_location where locationcode = '$locationcode'";
	$exec3 = mysql_query($query3) or die ("Error in Query3".mysql_error());
	$res3 = mysql_fetch_array($exec3);
	//$companyname = $res2["companyname"];
	$address1 = $res3["address1"];
	$address2 = $res3["address2"];
	//$area = $res2["area"];
	//$city = $res2["city"];
	//$pincode = $res2["pincode"];
	$emailid1 = $res3["email"];
	$phonenumber1 = $res3["phone"];
	$locationcode = $res3["locationcode"];
	//$phonenumber2 = $res2["phonenumber2"];
	//$tinnumber1 = $res2["tinnumber"];
	//$cstnumber1 = $res2["cstnumber"];
	$locationname =  $res3["locationname"];
	$prefix = $res3["prefix"];
	$suffix = $res3["suffix"];
ob_start();
?>

<style>
.logo{font-weight:bold; font-size:18px; text-align:center;}
.bodyhead{font-weight:bold; font-size:20px; text-align:center; }
.bodytextbold{font-weight:bold; font-size:15px; text-align:center;}
.bodytext{font-weight:normal; font-size:15px; text-align:center; vertical-align:middle;}
.border{border-top: 1px #000000; border-bottom:1px #000000;}
td, th{padding: 5px; }
td{ vertical-align:;}
table{table-layout:fixed;
width:100%;
display:table;
border-collapse:collapse;
font-family:Arial, Helvetica, sans-serif;
}
.width{ max-width:150px;}
.left{text-align:left;}
</style>
<!--<page backtop="10mm" backbottom="10mm" backright="5mm" backleft="5mm">-->
<?php include("print_header.php");?>
<table border="" align="center">
	<tr>
    	<td class="logo" colspan="3">STATEMENT OF ACCOUNT</td>
    </tr>
    <tr>
    	<td class="bodytext" colspan="3"><strong>From: </strong><?php echo $ADate1; ?><strong> To: </strong><?php echo $ADate2; ?></td>
    </tr>
	<tr>
    	<td class="bodytextbold left"><?php echo $doctorname;?></td>
        <td class="bodytextbold" width="400">&nbsp;</td>
        <td class="bodytextbold left">AVENUE HEALTHCARE LTD</td>
    </tr>
	<tr>
    	<td class="bodytextbold left" max-width="300" align="left">Code: <?php echo $code;?></td>
        <td class="bodytextbold left" max-width="50">&nbsp;</td>
        <td class="bodytextbold left" align="left">P. O BOX 45280 00100 NAIROBI</td>
    </tr>
	<tr>
    	<td class="bodytextbold left" align="left">Nairobi, Kenya.</td>
        <td class="bodytextbold left">&nbsp;</td>
        <td class="bodytextbold left" align="left">TEL: <?php echo $phonenumber1;?></td>
    </tr>
</table>

<table border="1"   align="center">
    <tr>
        <td class="bodytextbold" width="60">Date</td>
        <td class="bodytextbold" width="60" >Invoice No</td>
        <td class="bodytextbold width">Description</td>
        <td class="bodytextbold" width="60">Debit Amt</td>
        <td class="bodytextbold" width="60">Credit Amt</td>
        <td class="bodytextbold" width="60">Days</td>
        <td class="bodytextbold" width="60">Current Bal</td>
    </tr>
			<?php
		$openingcreditamount = 0;
		$openingdebittamount = 0;
			 $query81 = "select * from billing_paynow where referalname = '$doctorname' and billstatus='paid' and billdate < '$ADate1'";
			 $exec81 = mysql_query($query81) or die(mysql_error());
			 while($res81 = mysql_fetch_array($exec81))
			 {
			 $res81visitcode = $res81['visitcode'];
			 $query123="select * from consultation_referal where patientvisitcode='$res81visitcode' and referalname ='$doctorname'";
		  	 $exec123=mysql_query($query123) or die(mysql_error()); 
			 while($res123 = mysql_fetch_array($exec123))
			 {
			 $paynowamount = $res123['referalrate'];
			 $openingcreditamount = $openingcreditamount + $paynowamount;
			 }
			 }
			  $query82 = "select * from billing_paylater where referalname = '$doctorname' and billdate < '$ADate1'";
			 $exec82 = mysql_query($query82) or die(mysql_error());
			 while($res82 = mysql_fetch_array($exec82))
			 {
			 $res82visitcode = $res82['visitcode'];
			 $query124="select * from consultation_referal where patientvisitcode='$res82visitcode' and referalname ='$doctorname'";
		  	 $exec124=mysql_query($query124) or die(mysql_error());
			 while($res124 = mysql_fetch_array($exec124))
			 {
			 $paylateramount = $res124['referalrate'];
			 $openingcreditamount = $openingcreditamount + $paylateramount;
			 }
			 }
			 $query83 = "select * from billing_ipprivatedoctor where description='$doctorname' and recorddate < '$ADate1'";
			 $exec83 = mysql_query($query83) or die(mysql_error());
			 while($res83 = mysql_fetch_array($exec83))
			 {
			 $ipamount = $res83['amount'];
			 $openingcreditamount = $openingcreditamount + $ipamount;
			 }
			 $query51 = "select * from paymentmodecredit where source = 'doctorpaymententry' and billdate < '$ADate1'";
		  $exec51 = mysql_query($query51) or die ("Error in Query5".mysql_error());
		  //echo $num = mysql_num_rows($exec3);
		  while ($res51 = mysql_fetch_array($exec51))
		  {
		  $paymentdocno = $res51['billnumber'];
		  $res5transactionamount = $res51['transactionamount'];
		  $res5transactiondate = $res51['billdate'];
		  
		   $query15 = "select * from master_transactiondoctor where doctorcode = '$arraysuppliercode' and transactiondate < '$ADate1' and transactionmodule = 'PAYMENT' and docno ='$paymentdocno' and recordstatus <> 'deallocated'  order by transactiondate desc";
		  $exec15 = mysql_query($query15) or die ("Error in Query5".mysql_error());
		  $num15 = mysql_num_rows($exec15);
		  if($num15 > 0)
		  {
		  
		  $openingdebittamount = $openingdebittamount + $res5transactionamount;
		  }
			 }
			 
			  $query5 = "select * from master_transactiondoctor where accountname = '$doctorname' and transactiondate < '$ADate1' and recordstatus <> 'deallocated' group by docno order by transactiondate desc";
		  $exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
		  $num5 = mysql_num_rows($exec5);
		  while($res5 = mysql_fetch_array($exec5))
		  {
		  $totaltransamount = $res5['taxamount'];
		   $openingdebittamount = $openingdebittamount + $totaltransamount;
		  }
			 $openingbalance = $openingcreditamount - $openingdebittamount;
		  ?>
    <tr>
        <td class="bodytext"><?php echo $ADate1;?></td>
        <td colspan="5" class="bodytextbold">Opening Balance</td>
        <td class="bodytext"><?php echo number_format($openingbalance,2,'.',','); ?></td>
    </tr>
                
			<?php
			
		  	$query21 = "select * from master_doctor where doctorname like '%$doctorname%' and status <>'DELETED' group by doctorname order by doctorname desc ";
			$exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
			$res21 = mysql_fetch_array($exec21);
			$res21accountname = $res21['doctorname'];
			$supplieranum = $res21['auto_number'];
			 ?>
         
		
		    <?php		
		
		  $query45 = "select * from billing_paynow where referalname = '$res21accountname' and billstatus='paid' and billdate between '$ADate1' and '$ADate2' order by billdate desc";
		  $exec45 = mysql_query($query45) or die ("Error in Query45".mysql_error());
		  $num45 = mysql_num_rows($exec45);
		  while ($res45 = mysql_fetch_array($exec45))
		  {
     	  $res45transactiondate = $res45['billdate'];
		  $res45visitcode = $res45['visitcode'];
	      $res45patientname = $res45['referalname'];
		  $res45billnumber = $res45['billno'];
		  $res45accountname = $res45['accountname'];
		  $res45patientname = $res45['patientname'];
		  
		  $query123="select * from consultation_referal where patientvisitcode='$res45visitcode' and referalname ='$res21accountname'";
		  $exec123=mysql_query($query123) or die(mysql_error());
		  $num123=mysql_num_rows($exec123);
		  if($num123 > 0)
		  {
		  $res123=mysql_fetch_array($exec123);
		  $res45transactionamount = $res123['referalrate'];
		  $res2transactionamount = $res45transactionamount;

		 if($res45transactionamount==0){
			continue;				
		 }
		  
		  $t1 = strtotime("$ADate2");
		  $t2 = strtotime("$res45transactiondate");
		  $days_between = ceil(abs($t1 - $t2) / 86400);
		  $snocount = $snocount + 1;
		  
		  if($snocount == 1)
		  {
		  $totalat = $openingbalance + $res45transactionamount;
		  }
		  else
		  {
		  $totalat = $totalat + $res45transactionamount;
		  }
		  if ($res2transactionamount == '')
		  {
		  $res2transactionamount = '0.00';
		  }
		  else
		  {
		  $res2transactionamount = $res123['referalrate'];
		  }
		  
		  if($days_between <= 30)
		  {
		  if($snocount == 1)
		  {
		  $totalamount30 = $openingbalance + $res2transactionamount;
		  }
		  else
		  {
		  $totalamount30 = $totalamount30 + $res2transactionamount;
		  }
		  }
		  else if(($days_between >30) && ($days_between <=60))
		  {
		  if($snocount == 1)
		  {
		  $totalamount60 = $openingbalance + $res2transactionamount;
		  }
		  else
		  {
		  $totalamount60 = $totalamount60 + $res2transactionamount;
		  }
		  }
		  else if(($days_between >60) && ($days_between <=90))
		  {
		  if($snocount == 1)
		  {
		  $totalamount90 = $openingbalance + $res2transactionamount;
		  }
		  else
		  {
		  $totalamount90 = $totalamount90 + $res2transactionamount;
		  }
		  }
		  else if(($days_between >90) && ($days_between <=120))
		  {
		  if($snocount == 1)
		  {
		  $totalamount120 = $openingbalance + $res2transactionamount;
		  }
		  else
		  {
		  $totalamount120 = $totalamount120 + $res2transactionamount;
		  }
		  }
		  else if(($days_between >120) && ($days_between <=180))
		  {
		    if($snocount == 1)
		  {
		  $totalamount180 = $openingbalance + $res2transactionamount;
		  }
		  else
		  {
		  $totalamount180 = $totalamount180 + $res2transactionamount;
		  }
		  }
		  else
		  {
		      if($snocount == 1)
		  {
		  $totalamountgreater = $openingbalance + $res2transactionamount;
		  }
		  else
		  {
		  $totalamountgreater = $totalamountgreater + $res2transactionamount;
		  }
		  }
		  
		 
		
		  
		   if($snocount == 1)
		  {
		  $totalat = $openingbalance + $res45transactionamount;
		  }
		  else
		  {
		  $totalat = $totalat + $res45transactionamount;
		  }
	
		
			?>
			
    <tr>
        <td class="bodytext"><?php echo $res45transactiondate; ?></td>
        <td class="bodytext"><?php echo $res45billnumber; ?></td>
        <td class="bodytext left"><?php echo nl2br('Towards Bill - '.$res45patientname .', ' . $res45billnumber. ', ' .$res45accountname); ?></td>
        <td class="bodytext"><?php //echo number_format($res45transactionamount,2,'.',','); ?></td>
        <td class="bodytext"><?php echo number_format($res45transactionamount,2,'.',',');?></td>
        <td class="bodytext"><?php echo $days_between;?></td>
        <td class="bodytext"><?php echo number_format($totalat,2,'.',','); ?></td>
    </tr>
		   <?php
		   }  
		   }
		   ?>
		   
		    <?php		
		
		  $query45 = "select * from billing_paylater where referalname = '$res21accountname' and billdate between '$ADate1' and '$ADate2' order by billdate desc";
		  $exec45 = mysql_query($query45) or die ("Error in Query45".mysql_error());
		  $num45 = mysql_num_rows($exec45);
		  while ($res45 = mysql_fetch_array($exec45))
		  {
     	  $res45transactiondate = $res45['billdate'];
		  $res45visitcode = $res45['visitcode'];
	      $res45patientname = $res45['referalname'];
		  $res45billnumber = $res45['billno'];
		  $res45accountname = $res45['accountname'];
		  $res45patientname = $res45['patientname'];
		  
		  $query123="select * from consultation_referal where patientvisitcode='$res45visitcode' and referalname ='$res21accountname'";
		  $exec123=mysql_query($query123) or die(mysql_error());
		  $num123=mysql_num_rows($exec123);
		  if($num123 > 0)
		  {
		  $res123=mysql_fetch_array($exec123);
		  $res45transactionamount = $res123['referalrate'];
		  $res2transactionamount = $res45transactionamount;

		 if($res45transactionamount==0){
			continue;				
		 }
		  
		  
		    $t1 = strtotime("$ADate2");
		  $t2 = strtotime("$res45transactiondate");
		  $days_between = ceil(abs($t1 - $t2) / 86400);
		  $snocount = $snocount + 1;
		  
		
		  if ($res2transactionamount == '')
		  {
		  $res2transactionamount = '0.00';
		  }
		  else
		  {
		  $res2transactionamount = $res123['referalrate'];
		  }
		  
		  if($days_between <= 30)
		  {
		  if($snocount == 1)
		  {
		  $totalamount30 = $openingbalance + $res2transactionamount;
		  }
		  else
		  {
		  $totalamount30 = $totalamount30 + $res2transactionamount;
		  }
		  }
		  else if(($days_between >30) && ($days_between <=60))
		  {
		  if($snocount == 1)
		  {
		  $totalamount60 = $openingbalance + $res2transactionamount;
		  }
		  else
		  {
		  $totalamount60 = $totalamount60 + $res2transactionamount;
		  }
		  }
		  else if(($days_between >60) && ($days_between <=90))
		  {
		  if($snocount == 1)
		  {
		  $totalamount90 = $openingbalance + $res2transactionamount;
		  }
		  else
		  {
		  $totalamount90 = $totalamount90 + $res2transactionamount;
		  }
		  }
		  else if(($days_between >90) && ($days_between <=120))
		  {
		  if($snocount == 1)
		  {
		  $totalamount120 = $openingbalance + $res2transactionamount;
		  }
		  else
		  {
		  $totalamount120 = $totalamount120 + $res2transactionamount;
		  }
		  }
		  else if(($days_between >120) && ($days_between <=180))
		  {
		    if($snocount == 1)
		  {
		  $totalamount180 = $openingbalance + $res2transactionamount;
		  }
		  else
		  {
		  $totalamount180 = $totalamount180 + $res2transactionamount;
		  }
		  }
		  else
		  {
		      if($snocount == 1)
		  {
		  $totalamountgreater = $openingbalance + $res2transactionamount;
		  }
		  else
		  {
		  $totalamountgreater = $totalamountgreater + $res2transactionamount;
		  }
		  }
		  
		 
		
		    if($snocount == 1)
		  {
		  $totalat = $openingbalance + $res45transactionamount;
		  }
		  else
		  {
		  $totalat = $totalat + $res45transactionamount;
		  }
		
	
		  
			?>
			
    <tr>
        <td class="bodytext"><?php echo $res45transactiondate; ?></td>
        <td class="bodytext"><?php echo $res45billnumber; ?></td>
        <td class="bodytext left"><?php echo nl2br('Towards Bill - '.$res45patientname.', '.$res45billnumber.', '.$res45accountname);?></td>
        <td class="bodytext"><?php //echo number_format($res45transactionamount,2,'.',','); ?></td>
        <td class="bodytext"><?php echo number_format($res45transactionamount,2,'.',',');?></td>
        <td class="bodytext"><?php echo $days_between;?></td>
        <td class="bodytext"><?php echo number_format($totalat,2,'.',','); ?></td>
    </tr>
		   <?php
		   } 
		   } 
		   ?>
		   	    <?php		
		
		  $query45 = "select * from billing_ipprivatedoctor where description='$res21accountname' and recorddate between '$ADate1' and '$ADate2' order by recorddate desc";
		  $exec45 = mysql_query($query45) or die ("Error in Query45".mysql_error());
		  $num45 = mysql_num_rows($exec45);
		  while ($res45 = mysql_fetch_array($exec45))
		  {
     	  $res45transactiondate = $res45['recorddate'];
		  $res45visitcode = $res45['visitcode'];
		  $res45patientnames = $res45['patientname'];
		  
		  $query11 = "select * from master_ipvisitentry where visitcode='$res45visitcode'";
		  $exec11 = mysql_query($query11) or die(mysql_error());
		  $res11 = mysql_fetch_array($exec11);
		  
		  $billtype = $res11['billtype'];
		  $res45accountname = $res11['accountfullname'];
	      $res45patientname = $res45['description'];
		  $res45billnumber = $res45['docno'];
		  
		 
		  $res45transactionamount = $res45['amount'];
		  $res2transactionamount = $res45transactionamount;

		 if($res45transactionamount==0){
			continue;				
		 }
		  
		    $t1 = strtotime("$ADate2");
		  $t2 = strtotime("$res45transactiondate");
		  $days_between = ceil(abs($t1 - $t2) / 86400);
		  $snocount = $snocount + 1;
		  
		  
		  if ($res2transactionamount == '')
		  {
		  $res2transactionamount = '0.00';
		  }
		  else
		  {
		  $res2transactionamount = $res45['amount'];
		  }
		  
		  if($days_between <= 30)
		  {
		  if($snocount == 1)
		  {
		  $totalamount30 = $openingbalance + $res2transactionamount;
		  }
		  else
		  {
		  $totalamount30 = $totalamount30 + $res2transactionamount;
		  }
		  }
		  else if(($days_between >30) && ($days_between <=60))
		  {
		  if($snocount == 1)
		  {
		  $totalamount60 = $openingbalance + $res2transactionamount;
		  }
		  else
		  {
		  $totalamount60 = $totalamount60 + $res2transactionamount;
		  }
		  }
		  else if(($days_between >60) && ($days_between <=90))
		  {
		  if($snocount == 1)
		  {
		  $totalamount90 = $openingbalance + $res2transactionamount;
		  }
		  else
		  {
		  $totalamount90 = $totalamount90 + $res2transactionamount;
		  }
		  }
		  else if(($days_between >90) && ($days_between <=120))
		  {
		  if($snocount == 1)
		  {
		  $totalamount120 = $openingbalance + $res2transactionamount;
		  }
		  else
		  {
		  $totalamount120 = $totalamount120 + $res2transactionamount;
		  }
		  }
		  else if(($days_between >120) && ($days_between <=180))
		  {
		    if($snocount == 1)
		  {
		  $totalamount180 = $openingbalance + $res2transactionamount;
		  }
		  else
		  {
		  $totalamount180 = $totalamount180 + $res2transactionamount;
		  }
		  }
		  else
		  {
		      if($snocount == 1)
		  {
		  $totalamountgreater = $openingbalance + $res2transactionamount;
		  }
		  else
		  {
		  $totalamountgreater = $totalamountgreater + $res2transactionamount;
		  }
		  }
		  
		 
		
		  
		  if($snocount == 1)
		  {
		  $totalat = $openingbalance + $res45transactionamount;
		  }
		  else
		  {
		  $totalat = $totalat + $res45transactionamount;
		  }
	
		  
		
			?>
			
    <tr>
        <td class="bodytext"><?php echo $res45transactiondate; ?></td>
        <td class="bodytext"><?php echo $res45billnumber; ?></td>
        <td class="bodytext left"><?php echo nl2br('Towards Bill - '.$res45patientnames.', '.$res45billnumber.', '.$res45accountname);?></td>
        <td class="bodytext"><?php //echo number_format($res45transactionamount,2,'.',','); ?></td>
        <td class="bodytext"><?php echo number_format($res45transactionamount,2,'.',',');?></td>
        <td class="bodytext"><?php echo $days_between;?></td>
        <td class="bodytext"><?php echo number_format($totalat,2,'.',','); ?></td>
    </tr>
		   <?php
		   }  
		   ?>
			
			<?php
			
		  $query51 = "select * from paymentmodecredit where source = 'doctorpaymententry' and billdate between '$ADate1' and '$ADate2' group by billnumber order by billdate desc";
		  $exec51 = mysql_query($query51) or die ("Error in Query5".mysql_error());
		  //echo $num = mysql_num_rows($exec3);
		  while ($res51 = mysql_fetch_array($exec51))
		  {
		  $paymentdocno = $res51['billnumber'];
		  $res5transactionamount = $res51['transactionamount'];
		  $res5transactiondate = $res51['billdate'];
		  
		   $query5 = "select * from master_transactiondoctor where doctorcode = '$arraysuppliercode' and transactiondate between '$ADate1' and '$ADate2' and transactionmodule = 'PAYMENT' and docno ='$paymentdocno' and recordstatus <> 'deallocated'  order by transactiondate desc";
		  $exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
		  $num5 = mysql_num_rows($exec5);
		  if($num5 > 0)
		  {
		  while($res5 = mysql_fetch_array($exec5))
		  {
		  $res65visitcode = $res5['visitcode'];

     	  $query111 = "select * from master_ipvisitentry where visitcode='$res65visitcode'";
		  $exec111 = mysql_query($query111) or die(mysql_error());
		  $res111 = mysql_fetch_array($exec111);
		  
		  $billtype = $res111['billtype'];
		  $res65accountname = $res111['accountname'];
	      $res5patientname = $res5['accountname'];
		  $res5patientcode = $res5['doctorcode'];
		  //$totaltransamount = $res5['transactionamount'];
		  $res5billnumber = $res5['billnumber'];
		  $res5openingbalance = $res5['openingbalance'];
		  $res5docnumber = $res5['docno'];
		  $res5particulars = $res5['particulars'];
		  //$res5particulars = substr($res5particulars,2,6);
		   $res5transactionmode= $res5['transactionmode'];
		  if($res5transactionmode=='CHEQUE')
		  {
		    $totaltransamount = $res5['chequeamount'];
		  }
		  else if($res5transactionmode=='CASH')
		  {
		    $totaltransamount = $res5['cashamount'];
		  }
		  else if($res5transactionmode=='ONLINE')
		  {
		    $totaltransamount = $res5['onlineamount'];
		  }
		  else if($res5transactionmode=='CREDIT CARD')
		  {
		    $totaltransamount = $res5['cardamount'];
		  }
		  else if($res5transactionmode=='MPESA')
		  {
		    $totaltransamount = $res5['creditamount'];
		  }
		  else
		  {
		   $totaltransamount = $res5['transactionamount'];
		  }
//		  $res5taxamount = $res5['taxamount'];
		  $res5taxamount = 0;
		  $totaltransamount = $totaltransamount-$res5taxamount;
		  $res5chequenumber= $res5['chequenumber'];
		  $res5remarks = $res5['remarks'];

		 if($totaltransamount==0){
			continue;				
		 }
		  
		   $t1 = strtotime("$ADate2");
		  $t2 = strtotime("$res5transactiondate");
		  $days_between = ceil(abs($t1 - $t2) / 86400);
		   $snocount = $snocount + 1;
		  
		   if($days_between <= 30)
		  {
		  if($snocount == 1)
		  {
		  $totalamount30 = $openingbalance - $totaltransamount;
		  }
		  else
		  {
		  $totalamount30 = $totalamount30 - $totaltransamount;
		  }
		  }
		  else if(($days_between >30) && ($days_between <=60))
		  {
		  if($snocount == 1)
		  {
		  $totalamount60 = $openingbalance - $totaltransamount;
		  }
		  else
		  {
		  $totalamount60 = $totalamount60 - $totaltransamount;
		  }
		  }
		  else if(($days_between >60) && ($days_between <=90))
		  {
		  if($snocount == 1)
		  {
		  $totalamount90 = $openingbalance - $totaltransamount;
		  }
		  else
		  {
		  $totalamount90 = $totalamount90 - $totaltransamount;
		  }
		  }
		  else if(($days_between >90) && ($days_between <=120))
		  {
		  if($snocount == 1)
		  {
		  $totalamount120 = $openingbalance - $totaltransamount;
		  }
		  else
		  {
		  $totalamount120 = $totalamount120 - $totaltransamount;
		  }
		  }
		  else if(($days_between >120) && ($days_between <=180))
		  {
		    if($snocount == 1)

		  {
		  $totalamount180 = $openingbalance - $totaltransamount;
		  }
		  else
		  {
		  $totalamount180 = $totalamount180 - $totaltransamount;
		  }
		  }
		  else
		  {
		      if($snocount == 1)
		  {
		  $totalamountgreater = $openingbalance - $totaltransamount;
		  }
		  else
		  {
		  $totalamountgreater = $totalamountgreater - $totaltransamount;
		  }
		  }
		  
		 
		
		  
		  if($snocount == 1)
		  {
		  $totalat = $openingbalance - $totaltransamount;
		  }
		  else
		  {
		  $totalat = $totalat - $totaltransamount;
		  }
			if($res5chequenumber != '')
			{
			$res5chequenumber = ','.$res5chequenumber;
			}
			else
			{
			$res5chequenumber = '';
			}
			if($res5docnumber != '')
			{
			$res5docnumber = ','.$res5docnumber;
			}
			else
			{
			$res5docnumber = '';
			}
			if($res5remarks != '')
			{
			$res5remarks = ','.$res5remarks;
			}
			else
			{
			$res5remarks = '';
			}
			if($res5billnumber != '')
			{
			$res5billnumber = ','.$res5billnumber;
			}
			else
			{
			$res5billnumber = '';
			}
			
	       
			?>
			
    <tr>
        <td class="bodytext"><?php echo $res5transactiondate; ?></td>
        <td class="bodytext"><?php echo $paymentdocno; ?></td>
        <td class="bodytext left"><?php echo nl2br('Towards Payment - '.$res5transactionmode.$res5chequenumber.$res5docnumber.$res5remarks.$res5billnumber);?></td>
        <td class="bodytext"><?php echo number_format($totaltransamount,2,'.',','); ?></td>
        <td class="bodytext"><?php //echo number_format($res5transactionamount,2,'.',',');?></td>
        <td class="bodytext"><?php echo $days_between;?></td>
        <td class="bodytext"><?php echo number_format($totalat,2,'.',','); ?></td>
    </tr>
		   <?php
		   }
		   }
		   }  
		   ?>
		   	
			<?php
			
		  	  
		  $query5 = "select * from master_transactiondoctor where accountname = '$res21accountname' and transactiondate between '$ADate1' and '$ADate2' and recordstatus <> 'deallocated' group by docno order by transactiondate desc";
		  $exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
		  $num5 = mysql_num_rows($exec5);
		  while($res5 = mysql_fetch_array($exec5))
		  {
		 
		  $totaltransamount = $res5['taxamount'];
		  $res5billnumber = $res5['billnumber'];
		  $res5transactiondate = $res5['transactiondate'];
		  $res5docnumber = $res5['docno'];
		
		  //$res5particulars = substr($res5particulars,2,6);
		  $res5transactionmode= $res5['transactionmode'];
		  $res5chequenumber= $res5['chequenumber'];
		  $res5remarks = $res5['remarks'];

		 if($totaltransamount==0){
			continue;				
		 }

		  
		  if($totaltransamount != '0.00')
		  {
		  
		   $t1 = strtotime("$ADate2");
		  $t2 = strtotime("$res5transactiondate");
		  $days_between = ceil(abs($t1 - $t2) / 86400);
		   $snocount = $snocount + 1;
		  
		    if($days_between <= 30)
		  {
		  if($snocount == 1)
		  {
		  $totalamount30 = $openingbalance - $totaltransamount;
		  }
		  else
		  {
		  $totalamount30 = $totalamount30 - $totaltransamount;
		  }
		  }
		  else if(($days_between >30) && ($days_between <=60))
		  {
		  if($snocount == 1)
		  {
		  $totalamount60 = $openingbalance - $totaltransamount;
		  }
		  else
		  {
		  $totalamount60 = $totalamount60 - $totaltransamount;
		  }
		  }
		  else if(($days_between >60) && ($days_between <=90))
		  {
		  if($snocount == 1)
		  {
		  $totalamount90 = $openingbalance - $totaltransamount;
		  }
		  else
		  {
		  $totalamount90 = $totalamount90 - $totaltransamount;
		  }
		  }
		  else if(($days_between >90) && ($days_between <=120))
		  {
		  if($snocount == 1)
		  {
		  $totalamount120 = $openingbalance - $totaltransamount;
		  }
		  else
		  {
		  $totalamount120 = $totalamount120 - $totaltransamount;
		  }
		  }
		  else if(($days_between >120) && ($days_between <=180))
		  {
		    if($snocount == 1)
		  {
		  $totalamount180 = $openingbalance - $totaltransamount;
		  }
		  else
		  {
		  $totalamount180 = $totalamount180 - $totaltransamount;
		  }
		  }
		  else
		  {
		      if($snocount == 1)
		  {
		  $totalamountgreater = $openingbalance - $totaltransamount;
		  }
		  else
		  {
		  $totalamountgreater = $totalamountgreater - $totaltransamount;
		  }
		  }
		  
		 
		
		  
		  if($snocount == 1)
		  {
		  $totalat = $openingbalance - $totaltransamount;
		  }
		  else
		  {
		  $totalat = $totalat - $totaltransamount;
		  }
			
			if($res5chequenumber != '')
			{
			$res5chequenumber = ','.$res5chequenumber;
			}
			else
			{
			$res5chequenumber = '';
			}
			if($res5docnumber != '')
			{
			$res5docnumber = ','.$res5docnumber;
			}
			else
			{
			$res5docnumber = '';
			}
			if($res5remarks != '')
			{
			$res5remarks = ','.$res5remarks;
			}
			else
			{
			$res5remarks = '';
			}
			
	       
			?>
			
    <tr>
        <td class="bodytext"><?php echo $res5transactiondate; ?></td>
        <td class="bodytext"><?php echo $res5billnumber; ?></td>
        <td class="bodytext left"><?php echo nl2br('Towards Withholding Tax -'.$res5transactionmode.$res5chequenumber.$res5docnumber.$res5remarks); ?></td>
        <td class="bodytext"><?php echo number_format($totaltransamount,2,'.',','); ?></td>
        <td class="bodytext"><?php //echo number_format($res5transactionamount,2,'.',',');?></td>
        <td class="bodytext"><?php echo $days_between;?></td>
        <td class="bodytext"><?php echo number_format($totalat,2,'.',','); ?></td>
    </tr>
		   <?php
		   }
		 }
		   ?>
		  	  
  
</table>
<p>&nbsp;</p>
<table align="center" border="1">
   
    <tr>
        <td class="bodytext">30 days</td>
        <td class="bodytext">60 days</td>
        <td class="bodytext">90 days</td>
        <td class="bodytext">120 days</td>
        <td class="bodytext">180 days</td>
        <td class="bodytext">180+ days</td>
        <td class="bodytext">Total Due</td>
    </tr>
    <?php 
    $grandtotal = $totalat;
    ?>
    <tr>
        <td class="bodytext"><?php echo number_format($totalamount30,2,'.',','); ?></td>
        <td class="bodytext"><?php echo number_format($totalamount60,2,'.',','); ?></td>
        <td class="bodytext"><?php echo number_format($totalamount90,2,'.',','); ?></td>
        <td class="bodytext"><?php echo number_format($totalamount120,2,'.',','); ?></td>
        <td class="bodytext"><?php echo number_format($totalamount180,2,'.',','); ?></td>
        <td class="bodytext"><?php echo number_format($totalamountgreater,2,'.',','); ?></td>
        <td class="bodytext"><?php echo number_format($totalat,2,'.',','); ?></td>
    
    </tr>


</table>

<!--</page>-->
<!---------------------------------------------unwanted-------------------------------------------------------------->
<?php	
require_once("dompdf/dompdf_config.inc.php");
$html =ob_get_clean();
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper("A4","landscape");
$dompdf->render();
$canvas = $dompdf->get_canvas();
//$canvas->line(10,800,800,800,array(0,0,0),1);
$font = Font_Metrics::get_font("times-roman", "normal");
$canvas->page_text(272, 814, "Page {PAGE_NUM}/{PAGE_COUNT}", $font, 10, array(0,0,0));
$dompdf->stream("LPO.pdf", array("Attachment" => 0)); 
?>
<?php


    /*$content = ob_get_clean();

    // convert in PDF
    require_once('html2pdf/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
//      $html2pdf->setModeDebug();
        //$html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('printviewapo.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }*/
?>
