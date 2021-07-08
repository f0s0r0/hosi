<?php
require_once('html2pdf/html2pdf.class.php');
ob_start();
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
$totalat = '0.00';
$searchsuppliername = "";
$cbsuppliername = "";
$snocount = "";
$colorloopcount="";
$range = "";
$arraysuppliername = '';
$arraysuppliercode = '';	
$totalatret = 0.00;
$totalamount30 = 0;
$totalamount60 = 0;
$totalamount90 = 0;
$totalamount120 = 0;
$totalamount180 = 0;
$totalamountgreater = 0;

if (isset($_REQUEST["name"])) { $searchsuppliername = $_REQUEST["name"]; } else { $searchsuppliername = ""; }

if (isset($_REQUEST["code"])) { $searchsuppliercode = $_REQUEST["code"]; } else { $searchsuppliercode = ""; }
//echo $searchsuppliername;
if (isset($_REQUEST["ADate1"])) { $ADate1 = $_REQUEST["ADate1"]; } else { $ADate1 = ""; }
//echo $ADate1;
if (isset($_REQUEST["ADate2"])) { $ADate2 = $_REQUEST["ADate2"]; } else { $ADate2 = ""; }
//echo $amount;
if (isset($_REQUEST["cbfrmflag2"])) { $cbfrmflag2 = $_REQUEST["cbfrmflag2"]; } else { $cbfrmflag2 = ""; }
//$cbfrmflag2 = $_REQUEST['cbfrmflag2'];
if (isset($_REQUEST["frmflag2"])) { $frmflag2 = $_REQUEST["frmflag2"]; } else { $frmflag2 = ""; }
//$frmflag2 = $_POST['frmflag2'];
?>


           <table cellspacing="0" cellpadding="4" width="998" align="left" border="0	">
		   <tr>
		   <td width="990">
		   <table cellspacing="2" cellpadding="4" width="990" align="left" border="0">
            <tr>
              <td width="24"  align="left" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>No.</strong></td>
              <td width="82" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Date</strong></td>
              <td width="184" align="left" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong> Description </strong></td>
              <td width="90" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Debit</strong></td>
              <td width="100" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Credit</strong></td>
				<td width="90" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Days</strong></td>
				<td width="90" align="right" valign="center"  
                bgcolor="#ffffff" class="bodytext31"><strong>Current Balance</strong></td>
            </tr>
			<?php
		/*
			 $query1 = "select * from master_supplier where suppliercode = '$searchsuppliercode'";
			$exec1 = mysql_query($query1) or die ("Error in Query1".mysql_error());
			$res1 = mysql_fetch_array($exec1);
			$openingbalance = $res1['openingbalance'];	*/
		  ?>
		
			<?php
		/*	if (isset($_REQUEST["cbfrmflag1"])) { $cbfrmflag1 = $_REQUEST["cbfrmflag1"]; } else { $cbfrmflag1 = ""; }
			if ($cbfrmflag1 == 'cbfrmflag1')
			{
		  	$query21 = "select * from master_supplier where suppliername like '%$searchsuppliername%' and   status <>'DELETED' and dateposted between '$ADate1' and '$ADate2' group by suppliername order by suppliername desc ";
			$exec21 = mysql_query($query21) or die ("Error in Query21".mysql_error());
			$res21 = mysql_fetch_array($exec21);
			$res21accountname = $res21['suppliername'];
			$supplieranum = $res21['auto_number'];*/
			 ?>
         
			<tr bgcolor="#ffffff">
            <td colspan="7" align="left" valign="center" bgcolor="#ffffff" class="bodytext31"><strong><?php //echo $res21accountname;?> (Date From: <?php //echo $ADate1; ?> Date To: <?php //$ADate2;?>)</strong></td>
            </tr>
		
		    <?php		
		
		  $query45 = "select * from master_transactionpharmacy where suppliercode = '$searchsuppliercode' and transactiondate between '$ADate1' and '$ADate2' and transactiontype = 'PURCHASE' order by transactiondate desc";
		 $exec45 = mysql_query($query45) or die ("Error in Query45".mysql_error());
		  $num45 = mysql_num_rows($exec45);
		  while ($res45 = mysql_fetch_array($exec45))
		  {
     	  $res45transactiondate = $res45['transactiondate'];
	      $res45patientname = $res45['suppliername'];
		  $res45patientcode = $res45['suppliercode'];
		  $res45transactionamount = $res45['transactionamount'];
		  $res45billnumber = $res45['billnumber'];
		  $res45openingbalance = $res45['openingbalance'];
		  
		  $query85 = "select * from master_purchase where billnumber = '$res45billnumber' and billdate between '$ADate1' and '$ADate2' order by billdate desc";
		  $exec85 = mysql_query($query85) or die ("Error in Query85".mysql_error());
		  //echo $num = mysql_num_rows($exec3);
		   while ($res85 = mysql_fetch_array($exec85))
		  {
		  $res85supplierbillnumber = $res85['supplierbillnumber'];
		 
		  $t1 = strtotime("$ADate2");
		  $t2 = strtotime("$res45transactiondate");
		  $days_between = ceil(abs($t1 - $t2) / 86400);
		  
		  $totalat = $totalat + $res45transactionamount + $openingbalance;
	
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
			
           <tr>
              <td class="bodytext31" valign="center"  align="left"><?php echo $snocount; ?></td>
               <td class="bodytext31" valign="center"  align="left">
                <?php echo $res45transactiondate; ?></td>
              <td class="bodytext31" valign="center"  align="left">
                <?php echo 'Towards Purchase'; ?> (<?php echo $res85supplierbillnumber; ?>,<?php echo $res45billnumber; ?>)</td>
              <td class="bodytext31" valign="center"  align="right">
			  <?php //echo number_format($res45transactionamount,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right">
			   <?php echo number_format($res45transactionamount,2,'.',',');?></td>
				<td class="bodytext31" valign="center"  align="right">
			   <?php echo $days_between;?></td>
               <td class="bodytext31" valign="center"  align="right"><?php echo number_format($totalat,2,'.',','); ?></td>
           </tr>
		   <?php
		   }  }
		   ?>
			
			<?php
		  $query5 = "select * from master_transactionpharmacy where suppliercode = '$searchsuppliercode' and transactiondate between '$ADate1' and '$ADate2' and transactionmodule = 'PAYMENT' order by transactiondate desc";
		  $exec5 = mysql_query($query5) or die ("Error in Query5".mysql_error());
		  //echo $num = mysql_num_rows($exec3);
		  while ($res5 = mysql_fetch_array($exec5))
		  {
     	  $res5transactiondate = $res5['transactiondate'];
	      $res5patientname = $res5['suppliername'];
		  $res5patientcode = $res5['suppliercode'];
		  $res5transactionamount = $res5['transactionamount'];
		  $res5billnumber = $res5['billnumber'];
		  $res5openingbalance = $res5['openingbalance'];
		  $res5docnumber = $res5['docno'];
		  $res5particulars = $res5['particulars'];
		  //$res5particulars = substr($res5particulars,2,6);
		  $res5transactionmode= $res5['transactionmode'];
		  $res5chequenumber= $res5['chequenumber'];
		  $res5remarks = $res5['remarks'];
		  
		  $query15 = "select * from master_purchase where billnumber = '$res5billnumber' ";
		  $exec15 = mysql_query($query15) or die ("Error in Query15".mysql_error());
		  //echo $num = mysql_num_rows($exec3);
		   $res15 = mysql_fetch_array($exec15);
		  
		  $res15supplierbillnumber = $res15['supplierbillnumber'];
		 
		  $t1 = strtotime("$ADate2");
		  $t2 = strtotime("$res5transactiondate");
		  $days_between = ceil(abs($t1 - $t2) / 86400);
		 
		  $total = $res5transactionamount + $res5openingbalance;
		  
		  $totalat = $totalat - $total;
	
		  
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
                <?php echo $res5transactiondate; ?></td>
              <td class="bodytext31" valign="center"  align="left">
                <?php echo 'Towards Payment ('.$res5transactionmode.','.$res5chequenumber.','.$res5docnumber.','.$res5remarks; ?>)</td>
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($res5transactionamount,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right"><?php //echo number_format($res5transactionamount,2,'.',',');?></td>
				<td class="bodytext31" valign="center"  align="right"><?php echo $days_between;?></td>
               <td class="bodytext31" valign="center"  align="right"><?php echo number_format($totalat,2,'.',','); ?></td>
           </tr>
		   <?php
		   }  
		   ?>
		   
		   <?php
		  $query65 = "select * from purchasereturn_details where suppliercode = '$searchsuppliercode' and entrydate between '$ADate1' and '$ADate2' order by entrydate desc";
		   $exec65 = mysql_query($query65) or die ("Error in Query65".mysql_error());
		  //echo $num = mysql_num_rows($exec3);
		  while ($res65 = mysql_fetch_array($exec65))
		  {
     	  $res65transactiondate = $res65['entrydate'];
	      $res65patientname = $res65['suppliername'];
		  $res65patientcode = $res65['suppliercode'];
		  $res65subtotal= $res65['subtotal'];
		  $res65billnumber = $res65['billnumber'];
		  $res65grnnumber = $res65['grnbillnumber'];
		 
		  $totalatret = $totalat - $res65subtotal ;
		  
		  $totalat = $totalat - $res65subtotal; 
		  
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
                <?php echo $res65transactiondate; ?></td>
              <td class="bodytext31" valign="center"  align="left">
                <?php echo 'Towards Return ('.$res65billnumber.','.$res65grnnumber; ?>)</td>
              <td class="bodytext31" valign="center"  align="right">
			  <?php echo number_format($res65subtotal,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right"><?php //echo number_format($res5transactionamount,2,'.',',');?></td>
				<td class="bodytext31" valign="center"  align="right"><?php echo $days_between;?></td>
               <td class="bodytext31" valign="center"  align="right"><?php echo number_format($totalat,2,'.',','); ?></td>
           </tr>
		   <?php
		   }  
		   ?>
	    </table>
		</td>
		</tr>
		<tr>
		<td>
			<table cellspacing="0" cellpadding="4" width="990" 
            align="left" border="0">
	
				<tr>
				  <td  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
				  <td  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
				  <td  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
				  <td  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
				  <td  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
				  <td  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
				  <td  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31">&nbsp;</td>
			  </tr>
				<tr>
               <td width="85"  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>30 days</strong></td>
              <td width="85"  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>60 days</strong></td>
              <td width="85"  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>90 days</strong></td>
				<td width="85"  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>120 days</strong></td>
				<td width="85"  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>180 days</strong></td>
           <td width="154"  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>180+ days</strong></td>
           
             	 <td width="105"  align="right" valign="center" 
                bgcolor="#ffffff" class="bodytext31"><strong>Total Due</strong></td>
            </tr>
			<?php 
			$grandtotal = $totalat;
			?>
			<tr>
               <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><?php echo number_format($grandtotal,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><?php echo number_format($totalamount60,2,'.',','); ?></td>
              <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><?php echo number_format($totalamount90,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><?php echo number_format($totalamount120,2,'.',','); ?></td>
				<td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><?php echo number_format($totalamount180,2,'.',','); ?></td>
            <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><?php echo number_format($totalamountgreater,2,'.',','); ?></td>
             	 <td class="bodytext31" valign="center"  align="right" 
                bgcolor="#ffffff"><?php echo number_format($totalat,2,'.',','); ?></td>
		    </tr>
			
		    <tr>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              <td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
				<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
					<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
           
		   	<td class="bodytext31" valign="center"  align="left" 
                bgcolor="#ffffff">&nbsp;</td>
              </tr>
			 
		
			<?php
			//}
			?>
 </table>
	      </td>
</tr>
</table>
<?php

    $content = ob_get_clean();

    // convert in PDF
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'en');
//      $html2pdf->setModeDebug();
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('print_supplierstatement.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>